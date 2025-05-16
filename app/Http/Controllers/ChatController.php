<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Conversacion;
use App\Models\Mensaje;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Muestra solo la bandeja de entrada (lista de chats mutuos),
     * excluyendo usuarios baneados.
     */
    public function inbox()
    {
        $me = Auth::user();

        // 1) IDs de quienes sigo y me siguen en estado 'aceptada'
        $siguiendo  = $me->siguiendo()
                         ->wherePivot('status', 'aceptada')
                         ->pluck('id_receptor')
                         ->toArray();
        $seguidores = $me->seguidores()
                         ->wherePivot('status', 'aceptada')
                         ->pluck('id_emisor')
                         ->toArray();

        // 2) Solo la intersección (seguimiento mutuo)
        $contactIds = array_intersect($siguiendo, $seguidores);

        // 3) Traer usuarios mutuos excluyendo los baneados
        $contacts = Usuario::whereIn('id_usuario', $contactIds)
                           ->where('estado', '!=', 'baneado')
                           ->get();

        return view('chat.bandejaChats', compact('contacts'));
    }

    /**
     * Muestra la conversación con $otroUsuarioId (siempre que sea mutuo y no baneado).
     */
    public function index($otroUsuarioId)
    {
        $me = Auth::user();

        // 1) IDs de contactos mutuos
        $siguiendo  = $me->siguiendo()
                         ->wherePivot('status', 'aceptada')
                         ->pluck('id_receptor')
                         ->toArray();
        $seguidores = $me->seguidores()
                         ->wherePivot('status', 'aceptada')
                         ->pluck('id_emisor')
                         ->toArray();
        $contactIds = array_intersect($siguiendo, $seguidores);

        // 2) Si el otro no es mutuo, 403
        if (! in_array($otroUsuarioId, $contactIds)) {
            abort(403, 'Solo puedes chatear con usuarios que se siguen mutuamente.');
        }

        // 3) Obtener el modelo Usuario del otro y comprobar que no esté baneado
        $otro = Usuario::findOrFail($otroUsuarioId);
        if ($otro->estado === 'baneado') {
            abort(403, 'No puedes chatear con un usuario baneado.');
        }

        // 4) Recrear la misma lista de contactos (excluyendo baneados)
        $contacts = Usuario::whereIn('id_usuario', $contactIds)
                           ->where('estado', '!=', 'baneado')
                           ->get();

        // 5) Obtener o crear la conversación única, con IDs ordenados
        list($u1, $u2) = $this->orderedIds($me->id_usuario, $otroUsuarioId);
        $conv = Conversacion::firstOrCreate([
            'user1_id' => $u1,
            'user2_id' => $u2,
        ]);

        // 6) Cargar mensajes históricos ordenados
        $mensajes = $conv->mensajes()
                         ->orderBy('enviado_en')
                         ->get();

        return view('chat.chat', compact('contacts', 'conv', 'otro', 'mensajes'));
    }

    /**
     * Devuelve por JSON todos los mensajes de la conversación con $otroUsuarioId.
     */
    public function getMessages(Request $request, $otroUsuarioId)
    {
        $conv = $this->getConversation(Auth::id(), $otroUsuarioId);

        return response()->json(
            $conv->mensajes()->orderBy('enviado_en')->get()
        );
    }

    /**
     * Almacena un nuevo mensaje y lo devuelve en JSON.
     */
    public function sendMessage(Request $request, $otroUsuarioId)
    {
        $request->validate(['contenido' => 'required|string']);

        $conv = $this->getConversation(Auth::id(), $otroUsuarioId);

        $msg = Mensaje::create([
            'conversacion_id' => $conv->id,
            'emisor_id'       => Auth::id(),
            'contenido'       => $request->contenido,
        ]);

        return response()->json($msg);
    }

    /**
     * Helper: obtiene o crea la conversación después de validar mutuo follow y sin baneados.
     */
    protected function getConversation($miId, $otroId)
    {
        // 1) Validar seguimiento mutuo
        if (! $this->mutualFollow($miId, $otroId)) {
            abort(403, 'No está permitida la conversación.');
        }

        // 2) Validar que el otro usuario no esté baneado
        $otro = Usuario::findOrFail($otroId);
        if ($otro->estado === 'baneado') {
            abort(403, 'No puedes chatear con un usuario baneado.');
        }

        // 3) Crear o recuperar conversación con IDs ordenados
        list($u1, $u2) = $this->orderedIds($miId, $otroId);
        return Conversacion::firstOrCreate([
            'user1_id' => $u1,
            'user2_id' => $u2,
        ]);
    }

    /**
     * Comprueba si dos usuarios se siguen mutuamente con status 'aceptada'.
     */
    protected function mutualFollow($miId, $otroId)
    {
        $me = Usuario::findOrFail($miId);

        $sigo = $me->siguiendo()
                   ->where('id_receptor', $otroId)
                   ->wherePivot('status', 'aceptada')
                   ->exists();

        $meSiguen = $me->seguidores()
                       ->where('id_emisor', $otroId)
                       ->wherePivot('status', 'aceptada')
                       ->exists();

        return $sigo && $meSiguen;
    }

    /**
     * Garantiza unicidad de la conversación devolviendo [menor, mayor].
     */
    protected function orderedIds($a, $b)
    {
        return $a < $b ? [$a, $b] : [$b, $a];
    }
}

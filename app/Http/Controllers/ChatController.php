<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Conversacion;
use App\Models\Mensaje;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Muestra la lista de chats y la conversación con $otroUsuarioId.
     * Si no existe la conversación, la crea.
     */
    public function index($otroUsuarioId)
    {
        $me = Auth::user();

        // 1) Construir bandeja de contactos mutuos (seguimiento aceptado en ambos sentidos)
        $siguiendo  = $me->siguiendo()->wherePivot('status', 'aceptada')->pluck('id_receptor')->toArray();
        $seguidores = $me->seguidores()->wherePivot('status', 'aceptada')->pluck('id_emisor')->toArray();
        $contactIds = array_intersect($siguiendo, $seguidores);
        $contacts   = Usuario::whereIn('id_usuario', $contactIds)->get();

        // 2) Validar que el usuario destino es contacto mutuo
        if (! in_array($otroUsuarioId, $contactIds)) {
            abort(403, 'Solo puedes chatear con usuarios que se siguen mutuamente.');
        }

        // 3) Ordenar IDs para la conversación única
        list($u1, $u2) = $this->orderedIds($me->id_usuario, $otroUsuarioId);

        // 4) Buscar o crear la conversación
        $conv = Conversacion::firstOrCreate([
            'user1_id' => $u1,
            'user2_id' => $u2,
        ]);

        // 5) Cargar mensajes
        $mensajes = $conv->mensajes()
                         ->orderBy('enviado_en')
                         ->get();

        // 6) Cargar datos del otro usuario
        $otro = Usuario::findOrFail($otroUsuarioId);

        return view('chat.chat', compact('contacts', 'conv', 'otro', 'mensajes'));
    }

    /**
     * Devuelve JSON con el historial de mensajes de la conversación actual.
     */
    public function getMessages(Request $request, $otroUsuarioId)
    {
        $conv = $this->getConversation(Auth::id(), $otroUsuarioId);

        return response()->json(
            $conv->mensajes()->orderBy('enviado_en')->get()
        );
    }

    /**
     * Almacena un nuevo mensaje en la conversación y devuelve el mensaje en JSON.
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
     * Helper: busca o crea la conversación y comprueba mutuo follow.
     */
    protected function getConversation($miId, $otroId)
    {
        if (! $this->mutualFollow($miId, $otroId)) {
            abort(403, 'No está permitida la conversación.');
        }

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
     * Dada una pareja de IDs, retorna [menor, mayor] para clave única.
     */
    protected function orderedIds($a, $b)
    {
        return $a < $b ? [$a, $b] : [$b, $a];
    }
}

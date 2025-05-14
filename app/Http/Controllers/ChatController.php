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
     * Muestra solo la bandeja de entrada (lista de chats mutuos).
     */
    public function inbox()
    {
        $me = Auth::user();
    
        $siguiendo  = $me->siguiendo()
                        ->wherePivot('status', 'aceptada')
                        ->pluck('id_receptor')
                        ->toArray();
        $seguidores = $me->seguidores()
                        ->wherePivot('status', 'aceptada')
                        ->pluck('id_emisor')
                        ->toArray();
    
        $contactIds = array_intersect($siguiendo, $seguidores);
        $contacts   = Usuario::whereIn('id_usuario', $contactIds)->get();
    
        // Ahora llamamos correctamente a la vista dentro de la carpeta 'chat'
        return view('chat.bandejaChats', compact('contacts'));
    }
    

    /**
     * Muestra la bandeja de contactos y la conversación con $otroUsuarioId.
     * Crea la conversación si no existía.
     */
    public function index($otroUsuarioId)
    {
        $me = Auth::user();

        // 1) Construir bandeja de contactos mutuos
        $siguiendo  = $me->siguiendo()->wherePivot('status', 'aceptada')->pluck('id_receptor')->toArray();
        $seguidores = $me->seguidores()->wherePivot('status', 'aceptada')->pluck('id_emisor')->toArray();
        $contactIds = array_intersect($siguiendo, $seguidores);
        $contacts   = Usuario::whereIn('id_usuario', $contactIds)->get();

        // 2) Validar que el destino es mutuo
        if (! in_array($otroUsuarioId, $contactIds)) {
            abort(403, 'Solo puedes chatear con usuarios que se siguen mutuamente.');
        }

        // 3) Obtener o crear la conversación única
        list($u1, $u2) = $this->orderedIds($me->id_usuario, $otroUsuarioId);
        $conv = Conversacion::firstOrCreate([
            'user1_id' => $u1,
            'user2_id' => $u2,
        ]);

        // 4) Cargar mensajes históricos
        $mensajes = $conv->mensajes()
                         ->orderBy('enviado_en')
                         ->get();

        // 5) Datos del otro usuario
        $otro = Usuario::findOrFail($otroUsuarioId);

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
     * Helper: obtiene o crea la conversación tras comprobar mutuo follow.
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
     * Para garantizar unicidad: devuelve [menor, mayor].
     */
    protected function orderedIds($a, $b)
    {
        return $a < $b ? [$a, $b] : [$b, $a];
    }
}

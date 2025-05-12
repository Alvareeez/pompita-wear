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
     * Muestra la pantalla de chat con $otroUsuarioId.
     * Crea la conversación única entre ambos si no existe.
     */
    public function index($otroUsuarioId)
    {
        $me   = Auth::user();
        $otro = Usuario::findOrFail($otroUsuarioId);

        // Verificar seguimiento mutuo aceptado
        if (! $this->mutualFollow($me->id_usuario, $otroUsuarioId)) {
            abort(403, 'Solo puedes chatear con usuarios que se siguen mutuamente.');
        }

        // Ordenar IDs para única combinación
        [$u1, $u2] = $this->orderedIds($me->id_usuario, $otroUsuarioId);

        // Buscar o crear la conversación
        $conv = Conversacion::firstOrCreate([
            'user1_id' => $u1,
            'user2_id' => $u2,
        ]);

        // Cargar mensajes
        $mensajes = Mensaje::where('conversacion_id', $conv->id)
                           ->orderBy('enviado_en')
                           ->get();

        return view('chat.chat', compact('conv', 'otro', 'mensajes'));
    }

    /**
     * Devuelve en JSON el historial de mensajes.
     */
    public function getMessages($otroUsuarioId)
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
     * Busca o crea la conversación y valida mutuo follow.
     */
    protected function getConversation($miId, $otroId)
    {
        if (! $this->mutualFollow($miId, $otroId)) {
            abort(403);
        }
        [$u1, $u2] = $this->orderedIds($miId, $otroId);
        return Conversacion::firstOrCreate([
            'user1_id' => $u1,
            'user2_id' => $u2,
        ]);
    }

    /**
     * Ordena dos IDs (menor, mayor).
     */
    protected function orderedIds($a, $b)
    {
        return $a < $b ? [$a, $b] : [$b, $a];
    }

    /**
     * Comprueba que ambos se sigan mutuamente con status 'aceptada'.
     */
    protected function mutualFollow($miId, $otroId)
    {
        $me = Usuario::findOrFail($miId);
        $sigo     = $me->siguiendo()
                      ->where('id_receptor', $otroId)
                      ->wherePivot('status', 'aceptada')
                      ->exists();
        $meSiguen = $me->seguidores()
                      ->where('id_emisor', $otroId)
                      ->wherePivot('status', 'aceptada')
                      ->exists();
        return $sigo && $meSiguen;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Solicitud;
use App\Models\Usuario;
use App\Notifications\SolicitudNotification;

class SolicitudController extends Controller
{
    /**
     * Envía una nueva solicitud de seguimiento o actualiza el estado
     * (aceptada si la cuenta es pública, pendiente si es privada).
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_receptor' => 'required|exists:usuarios,id_usuario',
        ]);

        $emisor   = Auth::user();
        $receptor = Usuario::findOrFail($request->id_receptor);

        if ($emisor->id_usuario === $receptor->id_usuario) {
            return $request->ajax()
                ? response()->json(['error' => 'No puedes enviarte una solicitud a ti mismo.'], 422)
                : back()->with('error', 'No puedes enviarte una solicitud a ti mismo.');
        }

        // Busca o crea la solicitud existente
        $solicitud = Solicitud::firstOrNew([
            'id_emisor'   => $emisor->id_usuario,
            'id_receptor' => $receptor->id_usuario,
        ]);

        // Asigna el status según privacidad del receptor
        $solicitud->status = $receptor->is_private ? 'pendiente' : 'aceptada';
        $solicitud->save();

        // Notificación al receptor
        if ($solicitud->status === 'pendiente') {
            $receptor->notify(new SolicitudNotification("{$emisor->nombre} te ha enviado una solicitud de seguimiento."));
        } else {
            $receptor->notify(new SolicitudNotification("{$emisor->nombre} ha comenzado a seguirte."));
            // Notifica al emisor que la solicitud fue aceptada automáticamente
            $emisor->notify(new SolicitudNotification("Has comenzado a seguir a {$receptor->nombre}."));
        }

        if ($request->ajax()) {
            return response()->json([
                'status'       => $solicitud->status,
                'solicitud_id' => $solicitud->id,
                'message'      => 'Solicitud enviada correctamente.',
            ]);
        }

        return back()->with('success', 'Solicitud enviada correctamente.');
    }

    /**
     * Cancela o elimina una solicitud (tanto pendientes como aceptadas).
     */
    public function destroy(Request $request, Solicitud $solicitud)
    {
        // Solo el emisor puede eliminar su propia solicitud
        if ($solicitud->id_emisor != Auth::id()) {
            return $request->ajax()
                ? response()->json(['error' => 'No puedes cancelar esa solicitud.'], 403)
                : back()->with('error', 'No puedes cancelar esa solicitud.');
        }

        $solicitud->delete();

        if ($request->ajax()) {
            return response()->json([
                'message' => 'Solicitud cancelada correctamente.',
            ]);
        }

        return back()->with('success', 'Solicitud cancelada correctamente.');
    }

    /**
     * Comprueba si hay seguimiento mutuo entre el usuario autenticado y otro.
     * Devuelve JSON { mutual: true|false }.
     */
    public function checkMutual($other)
    {
        $me = Auth::user();

        // Comprueba si yo sigo a $other en estado 'aceptada'
        $meSigue = Solicitud::where('id_emisor', $me->id_usuario)
                            ->where('id_receptor', $other)
                            ->where('status', 'aceptada')
                            ->exists();

        // Comprueba si $other me sigue a mí en estado 'aceptada'
        $otroMeSigue = Solicitud::where('id_emisor', $other)
                                ->where('id_receptor', $me->id_usuario)
                                ->where('status', 'aceptada')
                                ->exists();

        return response()->json([
            'mutual' => ($meSigue && $otroMeSigue)
        ]);
    }

    /**
     * Acepta una solicitud pendiente de seguimiento.
     */
    public function accept(Request $request, Solicitud $solicitud)
    {
        // Solo el receptor puede aceptar
        if ($solicitud->id_receptor != Auth::user()->id_usuario) {
            return back()->with('error', 'No autorizado.');
        }

        $solicitud->status = 'aceptada';
        $solicitud->save();

        // Notifica al emisor que su solicitud fue aceptada
        $solicitud->emisor->notify(new SolicitudNotification(
            "{$solicitud->receptor->nombre} ha aceptado tu solicitud de seguimiento."
        ));

        return back()->with('success', 'Solicitud aceptada.');
    }
}

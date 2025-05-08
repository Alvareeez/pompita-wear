<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Solicitud;
use App\Models\Usuario;

class SolicitudController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_receptor' => 'required|exists:usuarios,id_usuario',
        ]);

        $emisor    = Auth::user();
        $receptor  = Usuario::findOrFail($request->id_receptor);

        if ($emisor->id_usuario === $receptor->id_usuario) {
            return back()->with('error', 'No puedes enviarte una solicitud a ti mismo.');
        }

        // Busca o crea la solicitud
        $solicitud = Solicitud::firstOrNew([
            'id_emisor'   => $emisor->id_usuario,
            'id_receptor' => $receptor->id_usuario,
        ]);

        // Si la cuenta es pública, auto-acepta
        $solicitud->status = $receptor->is_private ? 'pendiente' : 'aceptada';
        $solicitud->save();

        return back()->with('success', 'Solicitud enviada correctamente.');
    }

    public function destroy(Solicitud $solicitud)
    {
        // Sólo puede borrar su propia solicitud pendiente
        if ($solicitud->id_emisor != auth()->id() || $solicitud->status !== 'pendiente') {
            return back()->with('error', 'No puedes cancelar esa solicitud.');
        }

        $solicitud->delete();

        return back()->with('success', 'Solicitud cancelada correctamente.');
    }

}

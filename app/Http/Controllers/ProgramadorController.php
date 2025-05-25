<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudPlantilla;
use App\Models\Plantilla;
use Illuminate\Support\Facades\Auth;

class ProgramadorController extends Controller
{
    public function __construct()
    {
        // Sólo usuarios con rol programador (por ejemplo id_rol==5)
        abort_unless(
            Auth::check() && Auth::user()->id_rol === 5,
            403,
            'Acceso denegado'
        );
    }

    /**
     * 1) Listar todas las solicitudes pendientes de plantilla
     */
    public function index()
    {
        $solicitudes = SolicitudPlantilla::where('estado', 'pendiente')->get();
        return view('programador.index', compact('solicitudes'));
    }

    /**
     * 2) Mostrar detalles de una solicitud
     */
    public function showPlantilla(SolicitudPlantilla $plantilla)
    {
        return view('programador.show-plantilla', compact('plantilla'));
    }

    /**
     * 3) Procesar (aprobar o rechazar) la solicitud
     */
    public function procesarPlantilla(Request $request, SolicitudPlantilla $plantilla)
    {
        $request->validate([
            'action' => 'required|in:aprobar,rechazar'
        ]);

        if ($request->action === 'rechazar') {
            $plantilla->update(['estado' => 'rechazada', 'procesada_en' => now()]);
            return redirect()->route('programador.index')
                             ->with('error', 'Has rechazado la solicitud.');
        }

        // Si es aprobar, creamos la plantilla definitiva
        $plantilla->update(['estado' => 'aprobada', 'procesada_en' => now()]);

        Plantilla::create([
            'empresa_id'       => $plantilla->empresa_id,
            'programador_id'   => Auth::id(),
            'slug'             => $plantilla->slug,
            'nombre'           => $plantilla->nombre,
            'foto'             => $plantilla->foto,
            'enlace'           => $plantilla->enlace,
            'color_primario'   => $plantilla->color_primario,
            'color_secundario' => $plantilla->color_secundario,
            'color_terciario'  => $plantilla->color_terciario,
        ]);

        return redirect()->route('programador.index')
                         ->with('success', 'Solicitud aprobada y plantilla creada.');
    }
}

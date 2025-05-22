<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudDestacado;
use App\Models\Prenda;

class GestorController extends Controller
{
    /**
     * Muestra el panel de gestión de solicitudes.
     */
    public function index()
    {
        $pendientes = SolicitudDestacado::where('estado', 'pendiente')
            ->with(['empresa', 'plan', 'prenda'])
            ->get();

        $aceptadas = SolicitudDestacado::where('estado', 'aprobada')
            ->with(['empresa', 'plan', 'prenda'])
            ->get();

        $rechazadas = SolicitudDestacado::where('estado', 'rechazada')
            ->with(['empresa', 'plan', 'prenda'])
            ->get();

        return view('gestor.index', compact('pendientes', 'aceptadas', 'rechazadas'));
    }

    /**
     * Muestra el CRUD de prendas destacadas. Si la petición es AJAX,
     * devuelve solo la tabla parcial para no recargar la página completa.
     */
    public function manageDestacados(Request $request)
    {
        $q = Prenda::query();

        // Filtro opcional por rango de fechas
        if ($request->filled('desde')) {
            $q->where('destacado_hasta', '>=', $request->desde);
        }
        if ($request->filled('hasta')) {
            $q->where('destacado_hasta', '<=', $request->hasta);
        }

        $prendas = $q->paginate(12);

        // Petición AJAX → solo la tabla parcial
        if ($request->ajax()) {
            return view('gestor.partials.destacados-table', compact('prendas'));
        }

        // Petición normal → vista completa
        return view('gestor.destacados', compact('prendas'));
    }

    /**
     * Actualiza el flag 'destacada' y la fecha 'destacado_hasta'.
     */
    public function updateDestacado(Request $request, Prenda $prenda)
    {
        $request->validate([
            'destacada'       => 'required|boolean',
            'destacado_hasta' => 'nullable|date',
        ]);

        $prenda->update($request->only('destacada', 'destacado_hasta'));

        return redirect()
            ->route('gestor.destacados')
            ->with('success', 'Prenda actualizada correctamente.');
    }

    /**
     * Aprueba una solicitud pendiente.
     */
    public function approve(SolicitudDestacado $solicitud)
    {
        $solicitud->update(['estado' => 'aprobada']);
        return back()->with('success', 'Solicitud aprobada.');
    }

    /**
     * Rechaza una solicitud pendiente.
     */
    public function reject(SolicitudDestacado $solicitud)
    {
        $solicitud->update(['estado' => 'rechazada']);
        return back()->with('success', 'Solicitud rechazada.');
    }

    /**
     * Marca la prenda asociada como destacada.
     */
    public function highlight(SolicitudDestacado $solicitud)
    {
        $prenda = $solicitud->prenda;
        $prenda->update([
            'destacada'       => true,
            'destacado_hasta' => now()->addDays($solicitud->plan->duracion_dias),
        ]);

        return back()->with('success', 'Prenda marcada como destacada.');
    }
}

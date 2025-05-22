<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudDestacado;

class GestorController extends Controller
{
    public function index()
    {
        $pendientes = SolicitudDestacado::where('estado','pendiente')
                         ->with(['empresa','plan','prenda'])
                         ->get();
        $aceptadas  = SolicitudDestacado::where('estado','aprobada')
                         ->with(['empresa','plan','prenda'])
                         ->get();
        $rechazadas = SolicitudDestacado::where('estado','rechazada')
                         ->with(['empresa','plan','prenda'])
                         ->get();

        return view('gestor.index', compact('pendientes','aceptadas','rechazadas'));
    }

    public function highlight(SolicitudDestacado $solicitud)
    {
        // Marcar como destacada (solo si estaba aprobada)
        if ($solicitud->estado === 'aprobada' && ! $solicitud->prenda->destacada) {
            $solicitud->prenda->update([
                'destacada'       => true,
                'destacado_hasta' => now()->addDays($solicitud->plan->duracion_dias),
            ]);
        }

        return redirect()
            ->route('gestor.index')
            ->with('success','Prenda marcada como destacada.');
    }

    public function reject(SolicitudDestacado $solicitud)
    {
        if ($solicitud->estado === 'pendiente') {
            $solicitud->update(['estado'=>'rechazada']);
        }

        return redirect()
            ->route('gestor.index')
            ->with('success','Solicitud rechazada.');
    }

    public function approve(SolicitudDestacado $solicitud)
    {
        if ($solicitud->estado === 'pendiente') {
            $solicitud->update(['estado'=>'aprobada']);
        }

        return redirect()
            ->route('gestor.index')
            ->with('success','Solicitud aprobada.');
    }
}

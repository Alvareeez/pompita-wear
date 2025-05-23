<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plantilla;
use Illuminate\Support\Facades\Auth;


class ProgramadorController extends Controller
{

    public function __construct()
    {
        // Sólo Programador (id_rol === 5) puede acceder; si no, aborta con 403
        abort_unless(
            Auth::check() && Auth::user()->id_rol === 5,
            403,
            'Acceso denegado'
        );
    }

    /**
     * Mostrar todas las plantillas pendientes.
     */
    public function index()
    {
        // Sólo las pendientes, con la empresa para mostrar nombre
        $pendientes = Plantilla::where('estado','pendiente')
                        ->with('empresa')
                        ->orderBy('created_at','desc')
                        ->get();

        return view('programador.index', compact('pendientes'));
    }

    /**
     * Aprobar una plantilla.
     */
    public function aprobar(Plantilla $plantilla)
    {
        $plantilla->update(['estado'=>'aprobada']);
        return back()->with('success','Plantilla aprobada.');
    }

    /**
     * Rechazar una plantilla.
     */
    public function rechazar(Plantilla $plantilla)
    {
        $plantilla->update(['estado'=>'rechazada']);
        return back()->with('error','Plantilla rechazada.');
    }
}

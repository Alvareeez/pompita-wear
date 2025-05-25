<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Plantilla;
use Illuminate\Support\Str;

class ProgramadorController extends Controller
{
    public function __construct()
    {
        // Sólo programador (id_rol === 5) puede acceder
        abort_unless(
            Auth::check() && Auth::user()->id_rol === 5,
            403,
            'Acceso denegado'
        );
    }

    /**
     * 1) Listado de plantillas pendientes de procesar
     */
    public function index()
    {
        // Plantillas con estado 'pendiente'
        $pendientes = Plantilla::where('estado','pendiente')
                               ->with('empresa')
                               ->orderBy('created_at','desc')
                               ->get();

        return view('programador.index', compact('pendientes'));
    }

    /**
     * 2) Mostrar formulario para completar y aprobar plantilla
     */
    public function showPlantilla(Plantilla $plantilla)
    {
        abort_unless($plantilla->estado === 'pendiente', 403);
        return view('programador.plantillas.show', compact('plantilla'));
    }

    /**
     * 3) Procesar la plantilla: validar, actualizar y marcar aprobada
     */
    public function procesarPlantilla(Request $request, Plantilla $plantilla)
    {
        abort_unless($plantilla->estado === 'pendiente', 403);

        $request->validate([
            'slug'      => 'required|alpha_dash|unique:plantillas,slug,'.$plantilla->id,
            'nombre'    => 'required|string|max:255',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'enlace'    => 'nullable|url',
            'colores'   => 'required|array|size:3',
            'colores.*' => ['required','regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        // Subir nueva foto si viene, o conservar la anterior
        if ($request->hasFile('foto')) {
            $plantilla->foto = 'storage/'.$request->file('foto')->store('plantillas','public');
        }

        // Actualizar campos
        $plantilla->slug           = $request->slug;
        $plantilla->nombre         = $request->nombre;
        $plantilla->enlace         = $request->enlace;
        $plantilla->colores        = $request->colores;
        $plantilla->programador_id = Auth::user()->id_usuario;
        $plantilla->estado         = 'aprobada';
        $plantilla->save();

        return redirect()
               ->route('programador.index')
               ->with('success','Plantilla aprobada y actualizada correctamente.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Prenda;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class EmpresaController extends Controller
{
    public function __construct()
    {
        // Sólo empresas (id_rol === 3)
        abort_unless(
            Auth::check() && Auth::user()->id_rol === 3,
            403,
            'Acceso denegado'
        );
    }

    /**
     * 1) Mostrar panel con lista de planes
     */
    public function index()
    {
        $planes = Plan::all();
        return view('empresas.index', compact('planes'));
    }

    /**
     * 2) Tras elegir plan, si es el 3 vamos al form, si no al selector de prenda
     */
    public function selectPrenda(Plan $plan)
    {
        if ($plan->id === 3) {
            return redirect()->route('empresa.plantilla.form');
        }
        $prendas = Prenda::all();
        return view('empresas.select-prenda', compact('plan','prendas'));
    }

    /**
     * 3) AJAX para filtrar prendas
     */
    public function prendasAjax(Request $request)
    {
        $q = Prenda::query();
        if ($request->filled('q')) {
            $q->where('nombre', 'like', '%'.$request->q.'%');
        }
        $prendas = $q->get();

        if ($request->ajax()) {
            return view('empresa.partials.prendas-cards', compact('prendas'))->render();
        }
        abort(404);
    }

    /**
     * 4) Mostrar formulario de solicitud de plantilla
     */
    public function showPlantillaForm()
    {
        return view('empresas.create-plantilla');
    }

    /**
     * 5) Validar inputs, subir la foto, guardar TODO en sesión y redirigir al checkout PayPal
     */
    public function submitPlantillaForm(Request $request)
    {
        $request->validate([
            'slug'             => 'required|alpha_dash|unique:solicitudes_plantilla,slug',
            'nombre'           => 'required|string|max:255',
            'foto'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'enlace'           => 'nullable|url',
            'color_primario'   => ['required','regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_secundario' => ['required','regex:/^#[0-9A-Fa-f]{6}$/'],
            'color_terciario'  => ['required','regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        // 5.1) Subir foto si la hay
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $filename = time().'_'.preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('img/plantillas'), $filename);
            $fotoPath = 'img/plantillas/'.$filename;
        }

        // 5.2) Guardar TODO en sesión
        Session::put('plantilla', [
            'plan_id'          => 3,
            'slug'             => $request->slug,
            'nombre'           => $request->nombre,
            'foto'             => $fotoPath,
            'enlace'           => $request->enlace,
            'color_primario'   => $request->color_primario,
            'color_secundario' => $request->color_secundario,
            'color_terciario'  => $request->color_terciario,
        ]);

        // 5.3) Redirigir al checkout de PayPal
        return redirect()->route('paypal.checkout', [
            'plan_id' => 3,
            // prenda_id no es necesario para plan 3
        ]);
    }
}

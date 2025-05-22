<?php
// app/Http/Controllers/EmpresaController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Prenda;

class EmpresaController extends Controller
{
    // 1) Mostrar panel con lista de planes
    public function index()
    {
        $planes = Plan::all();
        return view('empresas.index', compact('planes'));
    }

    // 2) Elegir prenda tras seleccionar plan
    public function selectPrenda(Plan $plan)
    {
        // Obtén todas las prendas (o filtra según tu lógica)
        $prendas = Prenda::all();
        return view('empresas.select-prenda', compact('plan','prendas'));
    }

    public function prendasAjax(Request $request)
    {
        $q = Prenda::query();
    
        if ($request->filled('q')) {
            $q->where('nombre', 'like', '%'.$request->q.'%');
        }
    
        $prendas = $q->get();
    
        // Si es AJAX, devolvemos sólo el HTML del partial
        if ($request->ajax()) {
            return view('empresa.partials.prendas-cards', compact('prendas'))
                   ->render();
        }
    
        abort(404);
    }
    
}

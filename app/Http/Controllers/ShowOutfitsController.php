<?php

namespace App\Http\Controllers;

use App\Models\Outfit;
use Illuminate\Http\Request;

class ShowOutfitsController extends Controller
{
    public function index()
    {
        // Recuperar todos los outfits con las prendas asociadas
        $outfits = Outfit::with('prendas', 'usuario')->get();

        // Calcular el precio total de cada outfit
        foreach ($outfits as $outfit) {
            $outfit->prendas = $outfit->prendas->sortBy('id_tipoPrenda'); // Ordenar prendas por tipo
            $outfit->precio_total = $outfit->prendas->sum('precio'); // Sumar precios de las prendas
        }

        return view('outfit.outfits', compact('outfits'));
    }
    public function filtrar(Request $request)
{
    $query = Outfit::with(['prendas', 'usuario']);

    // Filtros
    if ($request->has('nombre') && !empty($request->nombre)) {
        $query->where('nombre', 'like', '%'.$request->nombre.'%');
    }

    if ($request->has('creador') && !empty($request->creador)) {
        $query->whereHas('usuario', function($q) use ($request) {
            $q->where('nombre', 'like', '%'.$request->creador.'%');
        });
    }

    $outfits = $query->get();

    // Calcular precios
    foreach ($outfits as $outfit) {
        $outfit->prendas = $outfit->prendas->sortBy('id_tipoPrenda');
        $outfit->precio_total = $outfit->prendas->sum('precio');
    }

    return view('outfit.partials.outfits_list', compact('outfits'))->render();
}
}

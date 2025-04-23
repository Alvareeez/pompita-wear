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
}

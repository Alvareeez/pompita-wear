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
    
        // Ordenar las prendas dentro de cada outfit por id_tipoPrenda (del 1 al 4)
        foreach ($outfits as $outfit) {
            $outfit->prendas = $outfit->prendas->sortBy('id_tipoPrenda');
        }
    
        return view('outfit.outfits', compact('outfits'));
    }
    
}

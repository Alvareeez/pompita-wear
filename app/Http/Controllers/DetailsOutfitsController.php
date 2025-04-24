<?php

namespace App\Http\Controllers;

use App\Models\Outfit;
use Illuminate\Http\Request;

class DetailsOutfitsController extends Controller
{
    public function show($id)
    {
        $outfit = Outfit::with('prendas.tipo', 'usuario')->findOrFail($id);

        // Calcular el precio total del outfit
        $precioTotal = $outfit->prendas->sum('precio');

        return view('outfit.show', compact('outfit', 'precioTotal'));
    }
}

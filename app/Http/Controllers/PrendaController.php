<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prenda;
use App\Models\Estilo;

class PrendaController extends Controller
{
    public function index()
    {
        // Top 5 prendas con más likes
        $prendasPopulares = Prenda::withCount('likes')
            ->orderByDesc('likes_count')
            ->take(5)
            ->get();
    
        // Todos los estilos
        $estilos = Estilo::all();
    
        return view('prendas.index', compact('prendasPopulares', 'estilos'));
    }

    public function porEstilo($id)
    {
        $estilo = Estilo::findOrFail($id);
    
        $prendas = Prenda::withCount('likes')
            ->whereHas('estilos', function ($query) use ($id) {
                $query->where('estilos.id_estilo', $id);
            })
            ->get();
    
        return view('prendas.por_estilo', compact('prendas', 'estilo'));
    }
    
    
}

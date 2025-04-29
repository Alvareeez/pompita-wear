<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prenda;
use App\Models\Estilo;
use App\Models\Outfit;

class HomeController extends Controller
{

    public function index()
    {
        // Top 5 prendas con más likes
        $prendasPopulares = Prenda::withCount('likes')
            ->orderByDesc('likes_count')
            ->take(5)
            ->get();
    
        // Top 3 outfits con más likes
        $outfitsPopulares = Outfit::withCount('likes')
            ->with(['usuario', 'prendas'])
            ->orderByDesc('likes_count')
            ->take(3)
            ->get();
    
        // Todos los estilos
        $estilos = Estilo::all();
    
        return view('cliente.index', compact('prendasPopulares', 'outfitsPopulares', 'estilos'));
    }
    
}
?>
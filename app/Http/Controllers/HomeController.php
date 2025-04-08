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
        $prendasPopulares = Prenda::orderByDesc('likes')->take(5)->get();

        // Todos los estilos
        $estilos = Estilo::all();

        $outfitsPopulares = Outfit::orderByDesc('likes')->take(5)->get();


        return view('cliente.index', compact('outfitsPopulares', 'prendasPopulares', 'estilos'));    }
}

?>

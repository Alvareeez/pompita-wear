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
        $prendasPopulares = Prenda::withCount('likes')  // Relacionamos y contamos los likes de cada prenda
            ->orderByDesc('likes_count') // Ordenamos por el número de likes
            ->take(5)
            ->get();

        // Todos los estilos
        $estilos = Estilo::all();

        // Retornamos los datos a la vista
        return view('cliente.index', compact( 'prendasPopulares', 'estilos'));
    }
}
?>
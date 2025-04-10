<?php
namespace App\Http\Controllers;

use App\Models\Prenda;  // Asegúrate de importar el modelo Prenda
use App\Models\Prenda;  // Asegúrate de importar el modelo Prenda
use Illuminate\Http\Request;


class OutfitController extends Controller
{
    public function index()
    {
        // Obtener los colores de la base de datos
        $colores = Color::all();
    
        // Obtener las prendas de cada tipo
        $prendasCabeza = Prenda::where('tipo_prenda', 'cabeza')->get();
        $prendasTorso = Prenda::where('tipo_prenda', 'torso')->get();
        $prendasPiernas = Prenda::where('tipo_prenda', 'piernas')->get();
        $prendasPies = Prenda::where('tipo_prenda', 'pies')->get();
    
        return view('outfit.index', compact('prendasCabeza', 'prendasTorso', 'prendasPiernas', 'prendasPies', 'colores'));
    }
    
}

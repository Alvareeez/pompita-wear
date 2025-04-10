<?php
namespace App\Http\Controllers;

use App\Models\Prenda;
use App\Models\Color;
use App\Models\PrendaColor;
use Illuminate\Http\Request;

class OutfitController extends Controller
{
    public function index(Request $request)
    {
        // Obtener todos los colores disponibles
        $colores = Color::all();
        
        // Recuperar prendas de torso (tipo 2) con posibilidad de filtrar por color
        $queryTorso = Prenda::where('id_tipoPrenda', 2);
        
        // Aplicar filtro por color si se ha seleccionado uno
        if ($request->has('color_id') && $request->color_id != '') {
            $colorId = $request->color_id;
            
            $queryTorso->whereHas('colores', function($q) use ($colorId) {
                $q->where('colores.id_color', $colorId); // Especificamos la tabla
            });
        }
        
        $prendasTorso = $queryTorso->get();
        
        // Obtener las demás prendas sin filtro
        $prendasCabeza = Prenda::where('id_tipoPrenda', 1)->get();
        $prendasPiernas = Prenda::where('id_tipoPrenda', 3)->get();
        $prendasPies = Prenda::where('id_tipoPrenda', 4)->get();

        return view('outfit.index', compact(
            'prendasCabeza',
            'prendasTorso',
            'prendasPiernas',
            'prendasPies',
            'colores'
        ));
    }
}
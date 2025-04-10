<?php
namespace App\Http\Controllers;

use App\Models\Prenda;
use App\Models\Color;
use Illuminate\Http\Request;

class OutfitController extends Controller
{
    public function index(Request $request)
    {
        // Obtener todos los colores disponibles
        $colores = Color::all();
        
        // Función para filtrar prendas por tipo y color
        $filterByTypeAndColor = function($typeId, $colorParam) use ($request) {
            $query = Prenda::where('id_tipoPrenda', $typeId);
            
            if ($request->has($colorParam) && $request->$colorParam != '') {
                $query->whereHas('colores', function($q) use ($request, $colorParam) {
                    $q->where('colores.id_color', $request->$colorParam);
                });
            }
            
            return $query->get();
        };
        
        // Obtener prendas con filtros aplicados
        $prendasCabeza = $filterByTypeAndColor(1, 'color_cabeza');
        $prendasTorso = $filterByTypeAndColor(2, 'color_torso');
        $prendasPiernas = $filterByTypeAndColor(3, 'color_piernas');
        $prendasPies = $filterByTypeAndColor(4, 'color_pies');

        return view('outfit.index', compact(
            'prendasCabeza',
            'prendasTorso',
            'prendasPiernas',
            'prendasPies',
            'colores'
        ));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Outfit;
use App\Models\OutfitPrenda;
use App\Models\Prenda;
use App\Models\Color;
use App\Models\Estilo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutfitController extends Controller
{
    public function index(Request $request)
    {
        // Obtener todos los colores y estilos disponibles
        $colores = Color::all();
        $estilos = Estilo::all();
        
        // Función para filtrar prendas por tipo, color y estilo
        $filterByTypeColorAndStyle = function($typeId, $colorParam, $styleParam) use ($request) {
            $query = Prenda::where('id_tipoPrenda', $typeId);
            
            // Filtro por color
            if ($request->has($colorParam) && $request->$colorParam != '') {
                $query->whereHas('colores', function($q) use ($request, $colorParam) {
                    $q->where('colores.id_color', $request->$colorParam);
                });
            }
            
            // Filtro por estilo
            if ($request->has($styleParam) && $request->$styleParam != '') {
                $query->whereHas('estilos', function($q) use ($request, $styleParam) {
                    $q->where('estilos.id_estilo', $request->$styleParam);
                });
            }
            
            return $query->get();
        };
        
        // Obtener prendas con filtros aplicados
        $prendasCabeza = $filterByTypeColorAndStyle(1, 'color_cabeza', 'estilo_cabeza');
        $prendasTorso = $filterByTypeColorAndStyle(2, 'color_torso', 'estilo_torso');
        $prendasPiernas = $filterByTypeColorAndStyle(3, 'color_piernas', 'estilo_piernas');
        $prendasPies = $filterByTypeColorAndStyle(4, 'color_pies', 'estilo_pies');

        return view('outfit.index', compact(
            'prendasCabeza',
            'prendasTorso',
            'prendasPiernas',
            'prendasPies',
            'colores',
            'estilos'
        ));
    }

    public function store(Request $request)
    {
        // Validar que se hayan seleccionado prendas
        $request->validate([
            'cabeza_id' => 'required|exists:prendas,id_prenda',
            'torso_id' => 'required|exists:prendas,id_prenda',
            'piernas_id' => 'required|exists:prendas,id_prenda',
            'pies_id' => 'required|exists:prendas,id_prenda'
        ]);

        // Crear el outfit
        $outfit = Outfit::create([
            'id_usuario' => Auth::id(),
            'likes' => 0
        ]);

        // Asociar las prendas al outfit
        $prendas = [
            $request->cabeza_id,
            $request->torso_id,
            $request->piernas_id,
            $request->pies_id
        ];

        foreach ($prendas as $prendaId) {
            OutfitPrenda::create([
                'id_outfit' => $outfit->id_outfit,
                'id_prenda' => $prendaId
            ]);
        }

        return redirect()->route('outfit.index')
            ->with('success', 'Outfit creado exitosamente!');
    }
}
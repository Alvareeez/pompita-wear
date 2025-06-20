<?php

namespace App\Http\Controllers;

use App\Models\Prenda;
use App\Models\Color;
use App\Models\Estilo;
use App\Models\Outfit;
use App\Models\OutfitPrenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OutfitNotification;

class OutfitController extends Controller
{

    public function __construct()
    {
        // Si el usuario está baneado, aborta con 403
        abort_if(
            Auth::check() && Auth::user()->estado === 'baneado',
            403,
            'Tu cuenta ha sido baneada.'
        );
    }
    
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
        // Validar los datos
        $request->validate([
            'nombre' => 'required|string|max:255', // Validar el nombre
            'prenda_cabeza' => 'nullable|exists:prendas,id_prenda',
            'prenda_torso' => 'nullable|exists:prendas,id_prenda',
            'prenda_piernas' => 'nullable|exists:prendas,id_prenda',
            'prenda_pies' => 'nullable|exists:prendas,id_prenda',
        ]);

        // Crear un nuevo outfit
        $outfit = Outfit::create([
            'id_usuario' => auth()->id(),
            'nombre' => $request->nombre, // Guardar el nombre del outfit
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Asociar las prendas seleccionadas al outfit
        $prendas = [
            $request->prenda_cabeza,
            $request->prenda_torso,
            $request->prenda_piernas,
            $request->prenda_pies,
        ];

        foreach ($prendas as $prendaId) {
            if ($prendaId) { // Verifica que el ID de la prenda no sea nulo
                OutfitPrenda::create([
                    'id_outfit' => $outfit->id_outfit, // Asigna el ID del outfit recién creado
                    'id_prenda' => $prendaId,         // Asigna el ID de la prenda seleccionada
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        // Enviar notificación al usuario autenticado
        $user = Auth::user();
        $user->notify(new OutfitNotification("El outfit '{$outfit->nombre}' ha sido creado exitosamente."));
        return redirect()->route('outfit.index')->with('success', 'Outfit creado exitosamente.');
    }
    public function filterAjax(Request $request)
    {
        // Mismo filtrado que en index
        $filterByTypeColorAndStyle = function($typeId, $colorParam, $styleParam) use ($request) {
            $query = Prenda::where('id_tipoPrenda', $typeId);
    
            if ($request->has($colorParam) && $request->$colorParam != '') {
                $query->whereHas('colores', function($q) use ($request, $colorParam) {
                    $q->where('colores.id_color', $request->$colorParam);
                });
            }
    
            if ($request->has($styleParam) && $request->$styleParam != '') {
                $query->whereHas('estilos', function($q) use ($request, $styleParam) {
                    $q->where('estilos.id_estilo', $request->$styleParam);
                });
            }
    
            return $query->get();
        };
    
        $prendasCabeza = $filterByTypeColorAndStyle(1, 'color_cabeza', 'estilo_cabeza');
        $prendasTorso = $filterByTypeColorAndStyle(2, 'color_torso', 'estilo_torso');
        $prendasPiernas = $filterByTypeColorAndStyle(3, 'color_piernas', 'estilo_piernas');
        $prendasPies = $filterByTypeColorAndStyle(4, 'color_pies', 'estilo_pies');
    
        $partes = [
            'Cabeza' => $prendasCabeza,
            'Torso' => $prendasTorso,
            'Piernas' => $prendasPiernas,
            'Pies' => $prendasPies
        ];
    
        try {
            $html = view('outfit.partials.carousel', compact('partes'))->render();
            return response($html, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno: ' . $e->getMessage()], 500);
        }
    }
}    
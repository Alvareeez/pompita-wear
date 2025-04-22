<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prenda;
use App\Models\Estilo;
use App\Models\ValoracionPrenda;
use App\Models\ComentarioPrenda;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class PrendaController extends Controller
{
    // Mostrar la página principal de prendas destacadas
    public function index()
    {
        // Top 5 prendas con más likes
        $prendasPopulares = Prenda::withCount('likes')
            ->orderByDesc('likes_count')
            ->take(5)
            ->get();

        // Todos los estilos disponibles
        $estilos = Estilo::all();

        return view('prendas.index', compact('prendasPopulares', 'estilos'));
    }

    // Mostrar las prendas por estilo con filtros
    public function porEstilo(Request $request, $id)
    {
        $estilo = Estilo::findOrFail($id);

        // Comenzamos la query base
        $query = Prenda::withCount('likes')
            ->whereHas('estilos', function ($q) use ($id) {
                $q->where('estilos.id_estilo', $id);
            });

        // Filtro por nombre si se proporciona
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        // Filtro por orden si se proporciona
        if ($request->filled('orden')) {
            switch ($request->orden) {
                case 'mas_likes':
                    $query->orderByDesc('likes_count');
                    break;
                case 'precio_asc':
                    $query->orderBy('precio', 'asc');
                    break;
                case 'precio_desc':
                    $query->orderBy('precio', 'desc');
                    break;
            }
        }

        // Ejecutamos la consulta
        $prendas = $query->get();

        return view('prendas.por_estilo', compact('prendas', 'estilo'));
    }

    // Mostrar detalle de una prenda
    public function show($id)
    {
        $prenda = Prenda::findOrFail($id);
        return view('prendas.show', compact('prenda'));
    }
}

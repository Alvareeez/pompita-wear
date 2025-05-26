<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prenda;
use App\Models\Estilo;
use App\Models\Color;
use App\Models\TipoPrenda;
use App\Models\ComentarioPrenda;
use App\Models\ValoracionPrenda;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PrendaController extends Controller
{
    public function index(Request $request)
    {
        // Obtener estilos, colores y tipos de prenda para los filtros
        $estilos = Estilo::all();
        $colores = Color::all();
        $tiposPrenda = TipoPrenda::all();

        // Query base
        $query = Prenda::withCount('likes')
                       ->withAvg('valoraciones', 'puntuacion');

        // Filtro por nombre
        if ($request->filled('nombre')) {
            $query->where('nombre', 'LIKE', '%' . $request->nombre . '%');
        }

        // Filtro por estilo
        if ($request->filled('id_estilo')) {
            $query->whereHas('estilos', function ($q) use ($request) {
                $q->where('estilos.id_estilo', $request->id_estilo);
            });
        }

        // Filtro por color
        if ($request->filled('id_color')) {
            $query->whereHas('colores', function ($q) use ($request) {
                $q->where('colores.id_color', $request->id_color);
            });
        }

        // Filtro por tipo de prenda
        if ($request->filled('id_tipoPrenda')) {
            $query->where('id_tipoPrenda', $request->id_tipoPrenda);
        }

        // Ordenación
        if ($request->orden === 'likes') {
            $query->orderByDesc('likes_count');
        } elseif ($request->orden === 'valoracion') {
            $query->orderByDesc('valoraciones_avg_puntuacion');
        }

        // Paginación
        $prendas = $query->paginate(12);

        // Si es petición AJAX, devolvemos solo el partial renderizado
        if ($request->ajax()) {
            return view('prendas.partials.product-list', compact('prendas'))->render();
        }

        // Datos adicionales para la vista normal
        $topPrendas = Prenda::withCount('likes')
            ->orderByDesc('likes_count')
            ->limit(5)
            ->get();

        $destacadas = Prenda::destacadas()
        ->orderByDesc('destacado_hasta')
        ->get();


        return view('prendas.index', compact(
            'prendas',
            'estilos',
            'colores',
            'tiposPrenda',
            'topPrendas',
            'destacadas'
        ));
    }

    public function porEstilo($id)
    {
        $estilo = Estilo::findOrFail($id);

        $prendas = Prenda::withCount('likes')
            ->whereHas('estilos', function ($q) use ($id) {
                $q->where('estilos.id_estilo', $id);
            })
            ->get();

        return view('prendas.por_estilo', compact('prendas', 'estilo'));
    }

    public function show($id)
    {
        // 1) Recuperamos la prenda
        $prenda = Prenda::with([
                    'comentarios.usuario',
                    'comentarios.likes',
                    'valoraciones.usuario'
                ])->findOrFail($id);
    
        // 2) Registramos la visita en la tabla prenda_vistas
        $prenda->vistas()->create([
            'id_usuario' => auth()->id(), // o null si invitado
        ]);
    
        // 3) Preparamos datos de puntuación
        $puntuacionPromedio = $prenda->promedioValoraciones();
        $puntuacionUsuario  = $prenda->valoraciones()
                                    ->where('id_usuario', auth()->id())
                                    ->first();
    
        // 4) Listado de comentarios y valoraciones ya viene en la relación
    
        return view('prendas.show', compact(
            'prenda',
            'puntuacionPromedio',
            'puntuacionUsuario'
        ));
    }
    
    

    public function toggleLike(Request $request, $id)
    {
        $prenda = Prenda::findOrFail($id);
        $user   = Auth::user();

        if (! $user) {
            return response()->json(['error' => 'Debes iniciar sesión'], 401);
        }
    
        // Verificar si ya existe el like usando la tabla directamente
        $likeExists = DB::table('likes_prendas')
                        ->where('id_prenda', $id)
                        ->where('id_usuario', $user->id_usuario)
                        ->exists();

        if ($likeExists) {
            DB::table('likes_prendas')
              ->where('id_prenda', $id)
              ->where('id_usuario', $user->id_usuario)
              ->delete();
            $liked = false;
        } else {
            DB::table('likes_prendas')->insert([
                'id_prenda'  => $id,
                'id_usuario' => $user->id_usuario,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $liked = true;
        }

        $likesCount = DB::table('likes_prendas')
                        ->where('id_prenda', $id)
                        ->count();

        return response()->json([
            'liked'       => $liked,
            'likes_count' => $likesCount,
            'message'     => $liked
                ? 'Prenda liked successfully'
                : 'Prenda unliked successfully',
        ]);
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'comentario' => 'required|string|max:500',
        ]);

        ComentarioPrenda::create([
            'id_prenda'  => $id,
            'id_usuario' => auth()->id(),
            'comentario' => $request->comentario,
        ]);

        return back()->with('success', 'Comentario añadido');
    }

    public function toggleCommentLike(Request $request, $id)
    {
        $comentario = ComentarioPrenda::findOrFail($id);
        $user       = Auth::user();

        if (! $user) {
            return response()->json(['error' => 'Debes iniciar sesión'], 401);
        }

        if ($comentario->isLikedByUser($user->id_usuario)) {
            $comentario->likes()->detach($user->id_usuario);
            $liked = false;
        } else {
            $comentario->likes()->attach($user->id_usuario);
            $liked = true;
        }

        return response()->json([
            'liked'       => $liked,
            'likes_count' => $comentario->likesCount(),
        ]);
    }

    public function storeValoracion(Request $request, $id)
    {
        $request->validate([
            'puntuacion' => 'required|integer|between:1,5',
        ]);

        ValoracionPrenda::updateOrCreate(
            [
                'id_prenda'  => $id,
                'id_usuario' => auth()->id(),
            ],
            ['puntuacion' => $request->puntuacion]
        );

        return back()->with('success', 'Valoración guardada');
    }

    public function toggleFavorite(Request $request, $id)
    {
        $user = Auth::user();

        if (! $user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $exists = DB::table('favoritos_prendas')
                    ->where('id_prenda', $id)
                    ->where('id_usuario', $user->id_usuario)
                    ->exists();

        if ($exists) {
            DB::table('favoritos_prendas')
              ->where('id_prenda', $id)
              ->where('id_usuario', $user->id_usuario)
              ->delete();
            $favorited = false;
        } else {
            DB::table('favoritos_prendas')->insert([
                'id_prenda'  => $id,
                'id_usuario' => $user->id_usuario,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $favorited = true;
        }

        $count = DB::table('favoritos_prendas')
                   ->where('id_prenda', $id)
                   ->count();

        return response()->json([
            'favorited' => $favorited,
            'count'     => $count,
        ]);
    }
}

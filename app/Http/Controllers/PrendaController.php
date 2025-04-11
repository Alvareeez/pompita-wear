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
    public function index()
    {
        // Top 5 prendas con más likes
        $prendasPopulares = Prenda::withCount('likes')
            ->orderByDesc('likes_count')
            ->take(5)
            ->get();
    
        // Todos los estilos
        $estilos = Estilo::all();
    
        return view('prendas.index', compact('prendasPopulares', 'estilos'));
    }

    public function porEstilo($id)
    {
        $estilo = Estilo::findOrFail($id);
    
        $prendas = Prenda::withCount('likes')
            ->whereHas('estilos', function ($query) use ($id) {
                $query->where('estilos.id_estilo', $id);
            })
            ->get();
    
        return view('prendas.por_estilo', compact('prendas', 'estilo'));
    }

    public function show($id)
    {
    $prenda = Prenda::with(['comentarios.usuario', 'comentarios.likes', 'valoraciones.usuario'])
                  ->findOrFail($id);
                  
    return view('prendas.show', [
        'prenda' => $prenda,
        'puntuacionPromedio' => $prenda->promedioValoraciones(),
        'puntuacionUsuario' => $prenda->valoraciones()
                                    ->where('id_usuario', auth()->id())
                                    ->first()
    ]);
    }

    public function isLikedByUser($userId)
    {
        return $this->likes()->where('likes_prendas.id_usuario', $userId)->exists();
    }

    // Busca la prenda por ID o devuelve un error 404 si no se encuentra
    public function toggleLike(Request $request, $id)
    {
        $prenda = Prenda::findOrFail($id);
        $user = auth()->user();
    
        if (!$user) {
            return response()->json(['error' => 'Debes iniciar sesión'], 401);
        }
    
        // Verificar si ya existe el like usando la tabla pivot directamente
        $likeExists = DB::table('likes_prendas')
                      ->where('id_prenda', $prenda->id_prenda)
                      ->where('id_usuario', $user->id_usuario)
                      ->exists();
    
        if ($likeExists) {
            DB::table('likes_prendas')
              ->where('id_prenda', $prenda->id_prenda)
              ->where('id_usuario', $user->id_usuario)
              ->delete();
            $liked = false;
        } else {
            DB::table('likes_prendas')->insert([
                'id_prenda' => $prenda->id_prenda,
                'id_usuario' => $user->id_usuario,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $liked = true;
        }
    
        // Obtener el nuevo conteo de likes
        $likesCount = DB::table('likes_prendas')
                      ->where('id_prenda', $prenda->id_prenda)
                      ->count();
    
        return response()->json([
            'liked' => $liked,
            'likes_count' => $likesCount,
            'message' => $liked ? 'Prenda liked successfully' : 'Prenda unliked successfully'
        ]);
    }
    public function storeComment(Request $request, $id)
{
    $request->validate([
        'comentario' => 'required|string|max:500'
    ]);

    $comentario = new ComentarioPrenda();
    $comentario->id_prenda = $id;
    $comentario->id_usuario = auth()->id();
    $comentario->comentario = $request->comentario;
    $comentario->save();

    return back()->with('success', 'Comentario añadido');
}

public function toggleCommentLike(Request $request, $id)
{
    $comentario = ComentarioPrenda::findOrFail($id);
    $user = auth()->user();

    if (!$user) {
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
        'liked' => $liked,
        'likes_count' => $comentario->likesCount()
    ]);
}
public function storeValoracion(Request $request, $id)
{
    $request->validate([
        'puntuacion' => 'required|integer|between:1,5'
    ]);

    $valoracion = ValoracionPrenda::updateOrCreate(
        [
            'id_prenda' => $id,
            'id_usuario' => auth()->id()
        ],
        [
            'puntuacion' => $request->puntuacion
        ]
    );

    return back()->with('success', 'Valoración guardada');
}
public function toggleFavorite($id)
{
    DB::beginTransaction();
    try {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        $prenda = Prenda::findOrFail($id);

        // Consulta directa para verificar existencia
        $exists = DB::table('favoritos_prendas')
                  ->where('id_prenda', $prenda->id_prenda)
                  ->where('id_usuario', $user->id_usuario) // Asegúrate que coincida con tu DB
                  ->exists();

        if ($exists) {
            DB::table('favoritos_prendas')
              ->where('id_prenda', $prenda->id_prenda)
              ->where('id_usuario', $user->id_usuario)
              ->delete();
            $favorited = false;
        } else {
            DB::table('favoritos_prendas')->insert([
                'id_prenda' => $prenda->id_prenda,
                'id_usuario' => $user->id_usuario,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $favorited = true;
        }

        // Conteo directo desde la base de datos
        $count = DB::table('favoritos_prendas')
                 ->where('id_prenda', $prenda->id_prenda)
                 ->count();

        DB::commit();

        return response()->json([
            'favorited' => $favorited,
            'count' => $count,
            'debug' => [ // Datos para depuración
                'prenda_id' => $prenda->id_prenda,
                'user_id' => $user->id_usuario
            ]
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'error' => 'Error del servidor',
            'details' => config('app.debug') ? $e->getMessage() : null
        ], 500);
    }
}
}

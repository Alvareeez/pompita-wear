<?php

namespace App\Http\Controllers;

use App\Models\ComentarioOutfit;
use App\Models\Outfit;
use App\Models\LikeComentarioOutfit;
use App\Models\ValoracionOutfit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LikeOutfit;
class DetailsOutfitsController extends Controller
{
    public function show($id)
    {
        $outfit = Outfit::with(['prendas.tipo', 'usuario', 'comentarios.usuario', 'valoraciones.usuario'])
            ->findOrFail($id);
    
        // Calcular el precio total sumando el precio de todas las prendas
        $precioTotal = $outfit->prendas->sum('precio');
        
        $puntuacionPromedio = $outfit->puntuacionPromedio();
        $puntuacionUsuario = auth()->check() ? $outfit->valoracionUsuario(auth()->id()) : null;
    
        return view('outfit.show', compact(
            'outfit', 
            'precioTotal',
            'puntuacionPromedio', 
            'puntuacionUsuario'
        ));
    }
public function storeComment(Request $request, $id)
{
    $request->validate([
        'comentario' => 'required|string|max:500'
    ]);

    $outfit = Outfit::findOrFail($id);

    $comentario = new ComentarioOutfit();
    $comentario->id_outfit = $outfit->id_outfit;
    $comentario->id_usuario = auth()->id();
    $comentario->comentario = $request->comentario;
    $comentario->save();

    return back()->with('success', 'Comentario añadido correctamente');
}

public function toggleCommentLike($id)
{
    $comentario = ComentarioOutfit::findOrFail($id);
    $userId = auth()->id();

    $like = LikeComentarioOutfit::where('id_comentario', $id)
        ->where('id_usuario', $userId)
        ->first();

    if ($like) {
        $like->delete();
        $isLiked = false;
    } else {
        LikeComentarioOutfit::create([
            'id_comentario' => $id,
            'id_usuario' => $userId
        ]);
        $isLiked = true;
    }

    return response()->json([
        'liked' => $isLiked,
        'likes_count' => $comentario->likes()->count()
    ]);
}
public function toggleLike($id)
{
    try {
        DB::beginTransaction();
        
        $outfit = Outfit::findOrFail($id);
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Debes iniciar sesión'], 401);
        }

        $likeExists = DB::table('likes_outfits')
                      ->where('id_outfit', $outfit->id_outfit)
                      ->where('id_usuario', $user->id_usuario)
                      ->exists();

        if ($likeExists) {
            DB::table('likes_outfits')
              ->where('id_outfit', $outfit->id_outfit)
              ->where('id_usuario', $user->id_usuario)
              ->delete();
            $liked = false;
        } else {
            DB::table('likes_outfits')->insert([
                'id_outfit' => $outfit->id_outfit,
                'id_usuario' => $user->id_usuario,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            $liked = true;
        }

        $likesCount = DB::table('likes_outfits')
                      ->where('id_outfit', $outfit->id_outfit)
                      ->count();

        DB::commit();

        return response()->json([
            'liked' => $liked,
            'likes_count' => $likesCount,
            'message' => $liked ? 'Like agregado' : 'Like removido'
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Error al procesar el like'], 500);
    }
}
public function storeValoracion(Request $request, $id)
{
    $request->validate([
        'puntuacion' => 'required|integer|between:1,5'
    ]);

    $outfit = Outfit::findOrFail($id);
    $userId = auth()->id();

    $valoracion = ValoracionOutfit::updateOrCreate(
        ['id_outfit' => $outfit->id_outfit, 'id_usuario' => $userId],
        ['puntuacion' => $request->puntuacion]
    );

    return back()->with('success', 'Valoración guardada correctamente');
}
}

<?php

namespace App\Http\Controllers;

use App\Models\ComentarioOutfit;
use App\Models\Outfit;
use App\Models\LikeComentarioOutfit;
use App\Models\ValoracionOutfit;
use Illuminate\Http\Request;

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
        $liked = false;
    } else {
        LikeComentarioOutfit::create([
            'id_comentario' => $id,
            'id_usuario' => $userId
        ]);
        $liked = true;
    }

    return response()->json([
        'liked' => $liked,
        'likes_count' => $comentario->likes()->count()
    ]);
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

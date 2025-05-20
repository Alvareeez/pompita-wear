<?php

namespace App\Http\Controllers;

use App\Models\ComentarioOutfit;
use App\Models\Outfit;
use App\Models\LikeComentarioOutfit;
use App\Models\ValoracionOutfit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetailsOutfitsController extends Controller
{
    /**
     * Muestra los detalles de un outfit, incluyendo prendas, valoraciones y comentarios.
     */
    public function show($id)
    {
        $outfit = Outfit::with([
            'prendas' => function($query) {
                $query->orderBy('tipo_prenda', 'asc') // Ordenar por tipo de prenda
                      ->orderBy('nombre', 'asc');      // Y luego por nombre
            },
            'prendas.tipo',
            'usuario',
            'comentarios.usuario',
            'valoraciones.usuario'
        ])
        ->findOrFail($id);

        $precioTotal       = $outfit->prendas->sum('precio');
        $puntuacionPromedio = $outfit->puntuacionPromedio();
        $puntuacionUsuario  = auth()->check()
            ? $outfit->valoracionUsuario(auth()->id())
            : null;

        return view('outfit.show', compact(
            'outfit',
            'precioTotal',
            'puntuacionPromedio',
            'puntuacionUsuario'
        ));
    }

    /**
     * Almacena un nuevo comentario.
     */
    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'comentario' => 'required|string|max:500'
        ]);

        ComentarioOutfit::create([
            'id_outfit'  => $id,
            'id_usuario' => auth()->id(),
            'comentario' => $request->comentario,
        ]);

        return back()->with('success', 'Comentario añadido correctamente');
    }

    /**
     * Alterna like sobre un comentario.
     */
    public function toggleCommentLike($id)
    {
        $comentario = ComentarioOutfit::findOrFail($id);
        $userId     = auth()->id();

        $like = LikeComentarioOutfit::where('id_comentario', $id)
            ->where('id_usuario', $userId)
            ->first();

        if ($like) {
            $like->delete();
            $isLiked = false;
        } else {
            LikeComentarioOutfit::create([
                'id_comentario' => $id,
                'id_usuario'    => $userId,
            ]);
            $isLiked = true;
        }

        return response()->json([
            'liked'       => $isLiked,
            'likes_count' => $comentario->likes()->count(),
        ]);
    }

    /**
     * Alterna like sobre el outfit.
     */
    public function toggleLike($id)
    {
        $userId = auth()->id();
        if (! $userId) {
            return response()->json(['error' => 'Debes iniciar sesión'], 401);
        }

        DB::beginTransaction();
        try {
            $exists = DB::table('likes_outfits')
                ->where('id_outfit', $id)
                ->where('id_usuario', $userId)
                ->exists();

            if ($exists) {
                DB::table('likes_outfits')
                    ->where('id_outfit', $id)
                    ->where('id_usuario', $userId)
                    ->delete();
                $liked = false;
            } else {
                DB::table('likes_outfits')->insert([
                    'id_outfit'   => $id,
                    'id_usuario'  => $userId,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
                $liked = true;
            }

            $likesCount = DB::table('likes_outfits')
                ->where('id_outfit', $id)
                ->count();

            DB::commit();

            return response()->json([
                'liked'       => $liked,
                'likes_count' => $likesCount,
                'message'     => $liked ? 'Like agregado' : 'Like removido',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error al procesar el like'], 500);
        }
    }

    /**
     * Guarda o actualiza la valoración del usuario.
     */
    public function storeValoracion(Request $request, $id)
    {
        $request->validate([
            'puntuacion' => 'required|integer|between:1,5'
        ]);

        ValoracionOutfit::updateOrCreate(
            ['id_outfit' => $id, 'id_usuario' => auth()->id()],
            ['puntuacion' => $request->puntuacion]
        );

        return back()->with('success', 'Valoración guardada correctamente');
    }

    /**
     * Elimina un outfit y todas sus relaciones en una transacción.
     */
    public function destroy($id)
    {
        $outfit = Outfit::with([
                'valoraciones',
                'comentarios.likes',
                'likes',
                'prendas',
                'favoritos'
            ])
            ->findOrFail($id);

        DB::transaction(function() use ($outfit) {
            // 1) Valoraciones
            $outfit->valoraciones()->delete();

            // 2) Likes de comentarios
            foreach ($outfit->comentarios as $comentario) {
                $comentario->likes()->delete();
            }
            $outfit->comentarios()->delete();

            // 3) Likes de outfit
            $outfit->likes()->delete();

            // 4) Pivot prendas
            $outfit->prendas()->detach();

            // 5) Pivot favoritos
            $outfit->favoritos()->detach();

            // 6) Outfit
            $outfit->delete();
        });

        return redirect()
            ->route('outfit.outfits')
            ->with('success', 'Outfit y todos sus datos asociados eliminados correctamente.');
    }

    /**
     * Alterna favorito (añade/quita) vía AJAX.
     */
    public function toggleFavorite($id)
    {
        $userId = auth()->id();
        if (! $userId) {
            return response()->json(['error' => 'Debes iniciar sesión'], 401);
        }

        DB::beginTransaction();
        try {
            $exists = DB::table('favoritos_outfits')
                ->where('id_outfit', $id)
                ->where('id_usuario', $userId)
                ->exists();

            if ($exists) {
                DB::table('favoritos_outfits')
                    ->where('id_outfit', $id)
                    ->where('id_usuario', $userId)
                    ->delete();
                $favorited = false;
            } else {
                DB::table('favoritos_outfits')->insert([
                    'id_outfit'  => $id,
                    'id_usuario' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $favorited = true;
            }

            $count = DB::table('favoritos_outfits')
                ->where('id_outfit', $id)
                ->count();

            DB::commit();

            return response()->json([
                'favorited'       => $favorited,
                'favorites_count' => $count,
                'message'         => $favorited
                                     ? 'Añadido a favoritos'
                                     : 'Eliminado de favoritos',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Error procesando el favorito'], 500);
        }
    }
}

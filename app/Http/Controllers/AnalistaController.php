<?php
// app/Http/Controllers/AnalistaController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prenda;

class AnalistaController extends Controller
{
    public function __construct()
    {
        // Sólo analista (id_rol === 6) puede acceder; si no, aborta con 403
        abort_unless(
            Auth::check() && Auth::user()->id_rol === 6,
            403,
            'Acceso denegado'
        );
    }
    
    /**
     * Mostrar panel de métricas:
     * - Top 5 prendas con más vistas en los últimos 30 días
     * - Listado paginado de todas las prendas con total de vistas
     */
    public function index()
    {
        // Top 5 por vistas en últimos 30 días
        $top5 = Prenda::withCount([
            'vistas as views_last_30_days' => function ($q) {
                $q->where('created_at', '>=', now()->subDays(30));
            }
        ])
        ->orderByDesc('views_last_30_days')
        ->take(5)
        ->get();

        // Todas las prendas con conteo total de vistas
        $prendas = Prenda::withCount('vistas')
                ->orderByDesc('vistas_count')
                ->paginate(12);
        
        return view('analista.index', compact('top5', 'prendas'));
    }
    

    /**
     * Mostrar comparativa de una prenda concreta:
     * - total de vistas
     * - vistas últimos 30 días
     * - total de likes
     * - total de comentarios
     */
    public function show($id)
    {
        $prenda = Prenda::withCount('vistas', 'likes', 'comentarios')
                        ->findOrFail($id);

        $viewsLast30 = $prenda->vistas()
                              ->where('created_at', '>=', now()->subDays(30))
                              ->count();

        return view('analista.show', [
            'prenda'        => $prenda,
            'totalViews'    => $prenda->vistas_count,
            'viewsLast30'   => $viewsLast30,
            'totalLikes'    => $prenda->likes_count,
            'totalComments' => $prenda->comentarios_count,
        ]);
    }
}

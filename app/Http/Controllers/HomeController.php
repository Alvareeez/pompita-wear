<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  // <-- importar Auth
use App\Models\Prenda;
use App\Models\Estilo;
use App\Models\Outfit;
use App\Models\Usuario;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Si el usuario está autenticado y su estado es 'baneado', 403
        $user = $request->user();
        if ($user && $user->estado === 'baneado') {
            abort(403, 'Tu cuenta ha sido baneada.');
        }

        // Top 5 prendas con más likes
        $prendasPopulares = Prenda::withCount('likes')
            ->orderByDesc('likes_count')
            ->take(5)
            ->get();

        // Top 3 outfits con más likes
        $outfitsPopulares = Outfit::withCount('likes')
            ->with(['usuario', 'prendas'])
            ->orderByDesc('likes_count')
            ->take(3)
            ->get();

        // Últimos 6 usuarios
        $usuariosRecientes = Usuario::take(6)->get();

        // Todos los estilos
        $estilos = Estilo::all();

        return view('cliente.index', compact(
            'prendasPopulares',
            'outfitsPopulares',
            'estilos',
            'usuariosRecientes'
        ));
    }
}

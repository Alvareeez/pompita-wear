<?php
namespace App\Http\Controllers;

use App\Models\Plantilla;
use App\Models\SolicitudRopa;
use App\Models\Prenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PlantillaController extends Controller
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
    

    public function show($slug)
    {
        // 1) Carga la plantilla aprobada
        $plantilla = Plantilla::where('slug', $slug)
                              ->firstOrFail();

        // 2) ID del usuario/empresa propietario
        $userId = $plantilla->empresa->usuario->id_usuario;

        // 3) Recoge todas las solicitudes de ropa aceptadas de este usuario
        $solicitudes = SolicitudRopa::where('id_usuario', $userId)
                                    ->where('estado', 'aceptada')
                                    ->get(['img_frontal']); // solo nos interesa el campo img_frontal

        // 4) Extrae los nombres de fichero
        $frentes = $solicitudes->pluck('img_frontal')->filter()->unique()->all();

        // 5) Busca las prendas que tengan exactamente esos mismos nombres de imagen
        $prendas = Prenda::whereIn('img_frontal', $frentes)->get();

        return view('plantillas.show', compact('plantilla','prendas'));
    }

    public function checkSlug(Request $request)
    {
        $slug = $request->input('slug');
        $exists = Plantilla::where('slug', $slug)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function checkNombre(Request $request)
    {
        $nombre = $request->input('nombre');
        $exists = Plantilla::where('nombre', $nombre)->exists();
        return response()->json(['exists' => $exists]);
    }
}

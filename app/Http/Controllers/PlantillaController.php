<?php
namespace App\Http\Controllers;

use App\Models\Plantilla;
use App\Models\SolicitudRopa;
use App\Models\Prenda;
use Illuminate\Http\Request;

class PlantillaController extends Controller
{
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
}

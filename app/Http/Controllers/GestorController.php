<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SolicitudDestacado;
use Illuminate\Support\Facades\Redirect;

class GestorController extends Controller
{
    public function index()
    {
        // Trae solo las solicitudes con estado 'aprobada'
        $solicitudes = SolicitudDestacado::where('estado','aprobada')
                             ->with(['empresa','plan','prenda'])
                             ->paginate(12);

        return view('gestor.index', compact('solicitudes'));
    }

    public function highlight(SolicitudDestacado $solicitud)
    {
        $prenda = $solicitud->prenda;
        $prenda->update([
            'destacada'       => true,
            'destacado_hasta' => now()->addDays($solicitud->plan->duracion_dias),
        ]);

        return Redirect::route('gestor.index')
                       ->with('success', 'Prenda marcada como destacada.');
    }
}

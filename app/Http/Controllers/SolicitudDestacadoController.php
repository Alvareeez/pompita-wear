<?php
// app/Http/Controllers/SolicitudDestacadoController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\SolicitudDestacado;
use App\Models\Plan;
use App\Models\Prenda;

class SolicitudDestacadoController extends Controller
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
    
    public function store(Request $request, Plan $plan)
    {
        $request->validate([
            'prenda_id' => 'required|exists:prendas,id_prenda',
        ]);

        $empresaId = Auth::id();
        $prendaId  = $request->input('prenda_id');

        // 0) Impedir si la prenda ya está globalmente destacada
        $prenda = Prenda::findOrFail($prendaId);
        if ($prenda->destacada) {
            return back()->with('error', 'Esta prenda ya está destacada.');
        }

        // 1) No permitir duplicados en pendiente o aprobada
        $ya = SolicitudDestacado::where('empresa_id',$empresaId)
            ->where('prenda_id',$prendaId)
            ->whereIn('estado',['pendiente','aprobada'])
            ->exists();
        if($ya){
            return back()->with('error','Ya tienes una solicitud pendiente o aprobada.');
        }

        // 2) Borrar rechazos antiguos
        SolicitudDestacado::where('empresa_id',$empresaId)
            ->where('prenda_id',$prendaId)
            ->where('estado','rechazada')
            ->delete();

        // 3) Crear la nueva solicitud en PENDIENTE
        $solicitud = SolicitudDestacado::create([
            'empresa_id'    => $empresaId,
            'prenda_id'     => $prendaId,
            'plan_id'       => $plan->id,
            'estado'        => 'pendiente',
            'solicitada_en' => Carbon::now(),
        ]);

        // 4) Redirigir al checkout de PayPal pasándole la solicitud
        return redirect()->route('paypal.checkout', ['solicitud' => $solicitud->id]);
    }
}

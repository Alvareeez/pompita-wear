<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\SolicitudDestacado;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SolicitudPlantilla;
use App\Models\Plan;

class PaymentController extends Controller
{
    /**
     * 3) Crear orden y redirigir a PayPal.
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'plan_id'   => 'required|exists:planes,id',
            'prenda_id' => 'required_if:plan_id,1,2|exists:prendas,id_prenda',
        ]);

        Session::put('payment.plan_id', $request->plan_id);
        Session::put('payment.prenda_id', $request->prenda_id);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $plan = Plan::findOrFail($request->plan_id);

        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'EUR',
                    'value'        => number_format($plan->precio, 2, '.', '')
                ],
            ]],
            'application_context' => [
                'return_url' => route('paypal.return'),
                'cancel_url' => route('paypal.cancel'),
            ],
        ]);

        Log::debug('PayPal createOrder:', $response);

        foreach (($response['result']['links'] ?? $response['links'] ?? []) as $link) {
            if (($link['rel'] ?? '') === 'approve') {
                return redirect($link['href']);
            }
        }

        return redirect()->route('empresas.index')
            ->with('error', 'No se pudo iniciar el pago en PayPal.');
    }

    /**
     * 4) Callback: capturar y crear la solicitud.
     */
    public function captureOrder(Request $request)
    {
        $token    = $request->query('token');
        $planId   = Session::get('payment.plan_id');
        $prendaId = Session::get('payment.prenda_id');

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($token);
        Log::debug('PayPal captureOrder:', $response);

        $status = $response['result']['status']
            ?? $response['status']
            ?? null;

        // Obtener el ID de la empresa real
        $empresaId = Auth::user()->empresa->id;

        if ($status === 'COMPLETED' && $planId == 3) {
            $datos = Session::get('plantilla', []);

            $solicitud = SolicitudPlantilla::create([
                'empresa_id'      => $empresaId,
                'plan_id'         => $datos['plan_id'],
                'slug'            => $datos['slug'],
                'nombre'          => $datos['nombre'],
                'foto'            => $datos['foto'],
                'enlace'          => $datos['enlace'],
                'color_primario'   => $datos['color_primario'],
                'color_secundario' => $datos['color_secundario'],
                'color_terciario'  => $datos['color_terciario'],
                'estado'          => 'pendiente',
                'solicitada_en'   => now(),
            ]);

            Session::forget(['payment.plan_id', 'payment.prenda_id', 'plantilla']);

            return redirect()->route('empresas.index')
                ->with(['factura_id' => $solicitud->id]);
        }

        if ($status === 'COMPLETED' && in_array($planId, [1, 2])) {
            $solicitud = SolicitudDestacado::create([
                'empresa_id'    => $empresaId,
                'prenda_id'     => $prendaId,
                'plan_id'       => $planId,
                'estado'        => 'pendiente',
                'solicitada_en' => now(),
            ]);

            Session::forget(['payment.plan_id', 'payment.prenda_id']);

            // Redirige con el ID de la solicitud para mostrar el modal
            return redirect()->route('empresas.index')
                ->with(['factura_id' => $solicitud->id]);
        }

        return $this->cancelOrder();
    }

    /**
     * 4b) Cancelación o fallo.
     */
    public function cancelOrder()
    {
        Session::forget(['payment.plan_id', 'payment.prenda_id', 'plantilla']);
        return redirect()->route('empresas.index')
            ->with('error', 'Has cancelado el pago.');
    }
    public function downloadInvoice($solicitudId)
    {
        // Intenta buscar primero en SolicitudDestacado (planes 1 y 2)
        $solicitud = SolicitudDestacado::with([
            'plan',
            'prenda',
            'empresa.datosFiscales'
        ])->find($solicitudId);

        $esPlan3 = false;

        // Si no existe, busca en SolicitudPlantilla (plan 3)
        if (!$solicitud) {
            $solicitud = SolicitudPlantilla::with([
                'plan',
                'empresa.datosFiscales'
            ])->findOrFail($solicitudId);
            $esPlan3 = true;
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('empresas.invoice', [
            'solicitud' => $solicitud,
            'esPlan3' => $esPlan3
        ]);

        return $pdf->download('factura_' . $solicitud->id . '.pdf');
    }
}

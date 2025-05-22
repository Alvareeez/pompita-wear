<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Plan;
use App\Models\SolicitudDestacado;

class PaymentController extends Controller
{
    /**
     * 3) Crear orden y redirigir a PayPal.
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'plan_id'   => 'required|exists:planes,id',
            'prenda_id' => 'required|exists:prendas,id_prenda',
        ]);

        $plan     = Plan::findOrFail($request->plan_id);
        $prendaId = $request->prenda_id;

        // Pre-registra la solicitud en estado 'pendiente'
        $sol = SolicitudDestacado::create([
            'empresa_id'    => Auth::id(),
            'prenda_id'     => $prendaId,
            'plan_id'       => $plan->id,
            'estado'        => 'pendiente',
            'solicitada_en' => Carbon::now(),
        ]);

        // Guarda en session para luego actualizar
        session(['highlight_id' => $sol->id]);

        // PayPal SDK
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            'intent'          => 'CAPTURE',
            'purchase_units'  => [[
                'amount' => [
                    'currency_code' => 'EUR',
                    'value'         => number_format($plan->precio, 2, '.', '')
                ]
            ]],
            'application_context' => [
                'return_url' => route('paypal.return'),
                'cancel_url' => route('paypal.cancel'),
            ],
        ]);

        Log::debug('PayPal createOrder response:', $response);

        $links = $response['result']['links'] 
               ?? $response['links'] 
               ?? null;

        if (! is_array($links)) {
            Log::error('PayPal createOrder: links no encontrados.', $response);
            return redirect()
                ->route('empresas.index')
                ->with('error', 'No se pudo iniciar el pago en PayPal.');
        }

        foreach ($links as $link) {
            if (($link['rel'] ?? '') === 'approve') {
                return redirect($link['href']);
            }
        }

        Log::error('PayPal createOrder: enlace approve no encontrado.', $links);
        return redirect()
            ->route('empresas.index')
            ->with('error', 'No se encontró el enlace de aprobación.');
    }

    /**
     * 4) Capturar el pago y actualizar la solicitud.
     */
    public function captureOrder(Request $request)
    {
        $token       = $request->query('token');        // Order ID
        $highlightId = session('highlight_id');

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($token);
        Log::debug('PayPal captureOrder response:', $response);

        $status = $response['result']['status'] 
               ?? $response['status'] 
               ?? null;

        if ($status === 'COMPLETED' && $highlightId) {
            $sol = SolicitudDestacado::findOrFail($highlightId);
            $sol->update([
                'estado'      => 'aprobada',
                'aprobada_en' => Carbon::now(),
                'expira_en'   => Carbon::now()->addDays($sol->plan->duracion_dias),
            ]);
            session()->forget('highlight_id');

            return redirect()
                ->route('empresas.index')
                ->with('success', 'Pago completado y plan activado.');
        }

        Log::error('PayPal captureOrder: pago no completado.', $response);
        return redirect()
            ->route('empresas.index')
            ->with('error', 'El pago no se completó.');
    }

    /**
     * 4b) Cancelación del pago.
     */
    public function cancelOrder()
    {
        session()->forget('highlight_id');
        return redirect()
            ->route('empresas.index')
            ->with('error', 'Has cancelado el pago.');
    }
}

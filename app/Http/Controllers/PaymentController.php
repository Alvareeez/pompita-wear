<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\SolicitudDestacado;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    /**
     * 3) Crear orden y redirigir a PayPal.
     *     Pre-registra la solicitud pero no la guarda hasta la captura.
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'plan_id'   => 'required|exists:planes,id',
            'prenda_id' => 'required|exists:prendas,id_prenda',
        ]);

        // Guardamos en sesión datos para crear la solicitud solo al capturar
        session([
            'highlight.plan_id'   => $request->plan_id,
            'highlight.prenda_id' => $request->prenda_id,
        ]);

        // SDK PayPal
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'EUR',
                    'value' => number_format(
                        \App\Models\Plan::find($request->plan_id)->precio,
                        2,
                        '.',
                        ''
                    )
                ]
            ]],
            'application_context' => [
                'return_url' => route('paypal.return'),
                'cancel_url' => route('paypal.cancel'),
            ]
        ]);

        Log::debug('PayPal createOrder response:', $response);

        $links = $response['result']['links']
            ?? $response['links']
            ?? null;

        if (!is_array($links)) {
            return redirect()->route('empresas.index')
                ->with('error', 'No se pudo iniciar el pago en PayPal.');
        }

        foreach ($links as $link) {
            if (($link['rel'] ?? '') === 'approve') {
                return redirect($link['href']);
            }
        }

        return redirect()->route('empresas.index')
            ->with('error', 'No se encontró el enlace de aprobación.');
    }

    /**
     * 4) Capturar el pago y crear la solicitud.
     */
    public function captureOrder(Request $request)
    {
        $token = $request->query('token');
        $planId   = session('highlight.plan_id');
        $prendaId = session('highlight.prenda_id');

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($token);
        Log::debug('PayPal captureOrder response:', $response);

        $status = $response['result']['status']
            ?? $response['status']
            ?? null;

        // Solo si el pago fue completado
        if ($status === 'COMPLETED' && $planId && $prendaId) {
            $solicitud = SolicitudDestacado::create([
                'empresa_id'    => Auth::id(),
                'prenda_id'     => $prendaId,
                'plan_id'       => $planId,
                'estado'        => 'pendiente',
                'solicitada_en' => now(),
            ]);
            session()->forget(['highlight.plan_id', 'highlight.prenda_id']);

            // Redirige con el ID de la solicitud para mostrar el modal
            return redirect()->route('empresas.index')
                ->with(['factura_id' => $solicitud->id]);
        }

        // En otros casos, lo tratamos como cancelación
        return $this->cancelOrder();
    }

    /**
     * 4b) Cancelación o fallo del pago.
     *     Eliminamos cualquier dato pendiente en sesión.
     */
    public function cancelOrder()
    {
        session()->forget(['highlight.plan_id', 'highlight.prenda_id']);

        return redirect()->route('empresas.index')
            ->with('error', 'Has cancelado el pago.');
    }
    public function downloadInvoice($solicitudId)
    {
        $solicitud = SolicitudDestacado::with([
            'plan',
            'prenda',
            'empresa.datosFiscales' // <--- importante
        ])->findOrFail($solicitudId);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('empresas.invoice', [
            'solicitud' => $solicitud,
        ]);

        return $pdf->download('factura_' . $solicitud->id . '.pdf');
    }
}

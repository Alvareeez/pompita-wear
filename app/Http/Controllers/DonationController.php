<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;

class DonationController extends Controller
{
    public function process(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|string',
            'amount' => 'required|numeric|min:1',
        ]);

        // Configurar Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Crear un PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => $validated['amount'] * 100, // Convertir a centavos
                'currency' => 'eur',
                'payment_method_types' => ['card'], // Solo tarjeta de crédito
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkout()
    {
        // Configurar la clave secreta de Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Crear una sesión de Stripe Checkout
            $session = Session::create([
                'payment_method_types' => ['card'], // Métodos de pago permitidos
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur', // Moneda
                        'product_data' => [
                            'name' => 'Donación para nuestra página', // Nombre del producto
                        ],
                        'unit_amount' => 1000, // Monto en centavos (10.00 EUR)
                    ],
                    'quantity' => 1, // Cantidad
                ]],
                'mode' => 'payment', // Modo de pago
                'success_url' => route('donations.success'), // URL de éxito
                'cancel_url' => route('donations.cancel'), // URL de cancelación
            ]);

            // Redirigir al usuario a la URL de Stripe Checkout
            return redirect($session->url);
        } catch (\Exception $e) {
            // Manejar errores y mostrar un mensaje al usuario
            return back()->withErrors(['error' => 'Error al iniciar el proceso de pago: ' . $e->getMessage()]);
        }
    }

    public function success()
    {
        // Vista de éxito después de un pago exitoso
        return view('cliente.donation-success');
    }

    public function cancel()
    {
        // Vista de cancelación si el usuario cancela el pago
        return view('cliente.donation-cancel');
    }
}
<?php
/**
 * PayPal Setting & API Credentials
 */

return [
    // Modo: sandbox o live
    'mode'    => env('PAYPAL_MODE', 'sandbox'),

    // Configuración sandbox
    'sandbox' => [
        'client_id'     => env('PAYPAL_SANDBOX_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_SANDBOX_CLIENT_SECRET', ''),
        'app_id'        => env('PAYPAL_SANDBOX_APP_ID', 'APP-80W284485P519543T'),
    ],

    // Configuración live (producción)
    'live' => [
        'client_id'     => env('PAYPAL_LIVE_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
        'app_id'        => env('PAYPAL_LIVE_APP_ID', ''),
    ],

    // Acción de pago: Sale, Authorization u Order
    'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'),

    // Moneda por defecto
    'currency'       => env('PAYPAL_CURRENCY', 'EUR'),

    // URL para notificaciones IPN si las usas
    'notify_url'     => env('PAYPAL_NOTIFY_URL', ''),

    // Localización de la ventana PayPal
    'locale'         => env('PAYPAL_LOCALE', 'es_ES'),

    // Validar SSL (cURL)
    'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true),
];

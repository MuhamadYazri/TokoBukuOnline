<?php

return [
    // Merchant ID dari Midtrans dashboard
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),

    // Client key untuk frontend (Snap.js)
    'client_key' => env('MIDTRANS_CLIENT_KEY'),

    // Server key untuk backend API calls
    'server_key' => env('MIDTRANS_SERVER_KEY'),

    // Environment: false = Sandbox (testing), true = Production (live)
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    // Sanitize input untuk keamanan
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),

    // Enable 3D Secure untuk kartu kredit (recommended)
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
];

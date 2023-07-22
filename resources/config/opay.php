<?php

return [
    'base_url' => env('OPAY_BASE_URL', 'https://cashierapi.opayweb.com'),
    'secret_key' => env('OPAY_SECRET_KEY', ''),
    'public_key' => env('OPAY_PUBLIC_KEY', ''),
    'merchant_id' => env('OPAY_MERCHANT_ID', '')
];

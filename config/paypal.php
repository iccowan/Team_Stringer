<?php

return [

    //Token Authentication Credentials
    'client_id' => env('LIVE_PAYPAL_CLIENT_ID'),
    'secret' => env('LIVE_PAYPAL_SECRET'),
    'sandbox_client_id' => env('SANDBOX_PAYPAL_CLIENT_ID'),
    'sandbox_secret' => env('SANDBOX_PAYPAL_SECRET'),

    // TOKENS
    'token' => env('LIVE_PAYPAL_TOKEN'),
    'sandbox_token' => env('SANDBOX_PAYPAL_TOKEN')

];

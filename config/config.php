<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Stripe API Keys
    |--------------------------------------------------------------------------
    |
    | These are the Stripe API keys that will be used for processing payments.
    | You can set your keys in the .env file as well, so they are not hardcoded.
    |
    */

    'stripe_secret' => env('STRIPE_SECRET'),
    'stripe_publishable' => env('STRIPE_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Success and Cancel URLs
    |--------------------------------------------------------------------------
    |
    | Here, you can define the URLs that users will be redirected to after a
    | successful payment or if they cancel the transaction.
    |
    */

    'success_url' => env('STRIPE_SUCCESS_URL', 'http://yourdomain.com/success'),
    'cancel_url' => env('STRIPE_CANCEL_URL', 'http://yourdomain.com/cancel'),

    /*
    |--------------------------------------------------------------------------
    | Currency and Payment Mode
    |--------------------------------------------------------------------------
    |
    | You can define the default currency for your Stripe payments and the
    | payment mode (either "payment" or "subscription").
    |
    */

    'currency' => env('STRIPE_CURRENCY', 'usd'),
    'payment_mode' => env('STRIPE_PAYMENT_MODE', 'payment'), // 'payment' or 'subscription'
];

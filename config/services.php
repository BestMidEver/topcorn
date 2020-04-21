<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '525225627985884',
        'client_secret' => 'd628b4ef4ecd62515f74863ae40ff073',
        'redirect' => config('api.url').'/login/facebook/callback',
    ],
    
    'passport' => [
        'login_endpoint' => env('APP_URL').'/oauth/token',
        'client_id' => '2',
        'client_secret' => 'p1rfitDI8PXGb1cJuAU9fSGQeS1fLwqCGHm0KtB6',
    ],

];

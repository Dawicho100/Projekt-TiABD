<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],
    'stripe' => [
        'key' => env('pk_test_51OHT6eIcXC9mi8vyltXK2qi8jEaJmiNV0yqJWuKE40Mcbav8u1DGOfWu2pw10bHSunp5vfsgoAXfr21mXYI2aGx300d8ZQvMy2'),
        'secret' => env('sk_test_51OHT6eIcXC9mi8vystOvPutjXugM8Qwmgvbv09sST5JMufm5xb7NWp19eg2THnzI0Ocubrlpfc0vpVYdYNNy7RMr00C0i85xhk'),
    ],


    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];

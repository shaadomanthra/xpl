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
        'domain' => env('mail.onlinelibrary.co'),
        'secret' => env('key-62404258f1dee0412ceefa926d97750d'),
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
        'model' => PacketPrep\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'paytm-wallet' => [
        'env' => 'local', // values : (local | production)
        'merchant_id' => 'QUEDBE64489893677306',
        'merchant_key' => 'NlcRdn0jXZk8lZSM',
        'merchant_website' => 'WEBSTAGING',
        'channel' => 'WEB',
        'industry_type' => 'Retail',
    ],

];

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
    'google' => [
    'client_id' => '241175231912-3ehnfjl5udiuthqmofgkjo3hha4b9scd.apps.googleusercontent.com',
    'client_secret' => 'UkIN_4fYQWYUrA_DM4bDGxnf',
    'redirect' => 'http://chronosh.com/sentradiskon/callback/google',
    ],

    'facebook' => [
    'client_id' => '1355746781157721',
    'client_secret' => '2f6945d32e35c0f8baf6b7f98ba5d1c8',
    'redirect' => 'http://chronosh.com/sentradiskon/callback/facebook',
    ],

];

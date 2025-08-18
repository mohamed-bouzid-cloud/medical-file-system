<?php

return [

    // --------------------------
    // Authentication Defaults
    // --------------------------
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    // --------------------------
    // Guards
    // --------------------------
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],
    ],

    // --------------------------
    // User Providers
    // --------------------------
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
    ],

    // --------------------------
    // Password Reset
    // --------------------------
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    // --------------------------
    // Password Confirmation Timeout
    // --------------------------
    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),
];

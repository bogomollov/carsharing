<?php

return [


    'defaults' => [
        'guard' => 'web',
        'passwords' => 'arendators',
    ],


    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'arendators',
        ],
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
            'hash' => false
        ],
    ],


    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'arendators' => [
            'driver' => 'eloquent',
            'model' => App\Models\Arendator::class,
        ],

    ],


    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],

        'arendators' => [
            'provider' => 'arendators',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],


    'password_timeout' => 10800,

];

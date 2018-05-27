<?php

return [
    'defaults' => [
        'guard'    => 'api-auth',
        'provider' => 'customers',
    ],
    'guards' => [
        'api-auth' => [
            'driver'   => 'session',
            'provider' => 'customers',
        ],
        'api-user' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],
    ],
    'providers' => [
        'customers' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Customer::class,
        ],
        'users' => [
            'driver' => 'eloquent',
            'model'  => App\Models\User::class,
        ],
    ],
];

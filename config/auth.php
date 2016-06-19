<?php

return [
    'defaults' => [
        'guard' => 'api'
    ],
    'guards' => [
        'api' => [
            'driver' => 'session',
            'provider' => 'customers',
        ],
    ],
    'providers' => [
        'customers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Customer::class,
        ]
    ]
];

<?php

return [
    'fetch'       => PDO::FETCH_CLASS,
    'default'     => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        'sqlite' => [
            'driver'   => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix'   => '',
        ],
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', 'localhost'),
            'port'      => env('DB_PORT', 3306),
            'database'  => env('DB_DATABASE', 'forge'),
            'username'  => env('DB_USERNAME', 'forge'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
        'mongodb' => [
            'driver'    => 'mongodb',
            'host'      => env('DB_HOST', 'localhost'),
            'port'      => env('DB_PORT', 27017),
            'database'  => env('DB_DATABASE', 'default'),
            'username'  => env('DB_USERNAME', ''),
            'password'  => env('DB_PASSWORD', ''),
        ],
        'redis' => [
            'cluster' => false,
            'default' => [
                'host'     => env('REDIS_HOST', '127.0.0.1'),
                'port'     => env('REDIS_PORT', 6379),
                'password' => env('REDIS_PASSWORD', null),
                'database' => 0,
            ],
        ],
    ],
    'migrations' => 'migrations',
];

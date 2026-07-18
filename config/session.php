<?php

return [
    'defaults' => [
        'path' => '/',
        'domain' => env('SESSION_DOMAIN'),
        'secure' => env('SESSION_SECURE', false),
        'encrypted' => env('SESSION_ENCRYPT', true),
        'lifetime' => env('SESSION_LIFETIME', 120),
        'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),
        'same_site' => 'strict',
        'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),
    ],
    'lifetime' => env('SESSION_LIFETIME', 120),
    'expire_on_close' => false,
    'encrypt' => env('SESSION_ENCRYPT', true),
    'files' => storage_path('framework/sessions'),
    'connection' => env('SESSION_CONNECTION'),
    'table' => env('SESSION_TABLE', 'sessions'),
    'store' => env('SESSION_DRIVER', env('CACHE_STORE', 'redis')),
    'lottery' => [2, 100],
    'cookie' => env('SESSION_COOKIE', 'meditrack_session'),
    'path' => env('SESSION_PATH', '/'),
    'domain' => env('SESSION_DOMAIN'),
    'secure' => env('SESSION_SECURE', false),
    'http_only' => true,
    'same_site' => 'strict',
    'partitioned' => false,
];

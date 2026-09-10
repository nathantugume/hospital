<?php

return [
    'driver' => env('HASH_DRIVER', 'bcrypt'),
    'bcrypt' => ['rounds' => env('HASH_BCRYPT_ROUNDS', 12)],
    'argon' => [
        'memory' => env('HASH_ARGON_MEMORY', 65536),
        'threads' => env('HASH_ARGON_THREADS', 1),
        'time' => env('HASH_ARGON_TIME', 4),
    ],
];

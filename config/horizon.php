<?php

return [
    'domain' => null,
    'path' => env('HORIZON_DASHBOARD_PATH', 'horizon'),
    'use' => 'default',
    'prefix' => env('HORIZON_PREFIX', 'horizon:'),
    'middleware' => ['web', 'auth'],
    'notifications' => [
        'email' => env('HORIZON_EMAIL'),
        'slack' => env('HORIZON_SLACK_WEBHOOK'),
    ],
    'waits' => [
        'redis:default' => 60,
        'redis:sms' => 300,
        'redis:payments' => 300,
        'redis:notifications' => 60,
        'redis:integrations' => 600,
    ],
    'night' => [
        'timezone' => env('APP_TIMEZONE', 'Africa/Kampala'),
        'duration' => env('HORIZON_NIGHT_DURATION', 6),
    ],
    'supervisor-1' => [
        'connection' => 'redis',
        'queue' => ['default', 'sms', 'notifications'],
        'balance' => 'auto',
        'maxProcesses' => 4,
        'maxTime' => 0,
        'maxJobs' => 0,
        'memory' => 128,
        'tries' => 3,
        'timeout' => 60,
        'nice' => 0,
    ],
    'supervisor-2' => [
        'connection' => 'redis',
        'queue' => ['payments', 'integrations'],
        'balance' => 'auto',
        'maxProcesses' => 4,
        'maxTime' => 0,
        'maxJobs' => 0,
        'memory' => 256,
        'tries' => 3,
        'timeout' => 300,
        'nice' => 0,
    ],
];

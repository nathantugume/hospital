<?php

return [
    'cache' => [
        'enabled' => env('OCTANE_CACHE', true),
        'store' => env('OCTANE_CACHE_STORE', 'octane'),
    ],
    'listeners' => [
        Illuminate\Foundation\Http\Events\RequestReceived::class => [
            Laravel\Octane\Listeners\FlushTemporaryContainerInstances::class,
        ],
        Illuminate\Foundation\Http\Events\RequestTerminated::class => [
            Laravel\Octane\Listeners\FlushTemporaryContainerInstances::class,
        ],
    ],
    'warm' => [
        ...array_values(array_filter([
            'view',
            'config',
            'cache',
            'storage',
            'db',
        ])),
    ],
    'flush' => [
        ...array_values(array_filter([])),
    ],
    'watchers' => [
        'cache' => env('OCTANE_CACHE_WATCHER', true),
        'config' => env('OCTANE_CONFIG_WATCHER', true),
        'storage' => env('OCTANE_STORAGE_WATCHER', true),
    ],
    'garbage_collection' => [
        'enabled' => env('OCTANE_GC_ENABLED', true),
        'max_requests' => env('OCTANE_GC_MAX_REQUESTS', 1000),
    ],
    'server' => env('OCTANE_SERVER', 'swoole'),
    'servers' => [
        'swoole' => [
            'host' => '0.0.0.0',
            'port' => env('OCTANE_PORT', 8000),
            'workers' => env('OCTANE_WORKERS', 4),
            'task_workers' => env('OCTANE_TASK_WORKERS', 8),
            'max_requests' => env('OCTANE_MAX_REQUESTS', 1000),
            'options' => [],
        ],
    ],
];

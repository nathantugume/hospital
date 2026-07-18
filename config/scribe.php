<?php

return [
    'domain' => env('SCRIBE_API_DOMAIN', 'localhost:8000'),
    'type' => env('SCRIBE_TYPE', 'laravel'),
    'static' => [
        'output_path' => 'public/docs',
    ],
    'laravel' => [
        'output_path' => 'public/docs',
        'example_creator' => \Knuckles\Scribe\Extracting\Strategies\ResponseFields\GetFromResponseFieldTag::class,
    ],
    'base_path' => env('SCRIBE_BASE_PATH', 'api/v1'),
    'routes' => [
        'match' => [
            'prefixes' => ['api/v1/*', 'api/*'],
            'domains' => ['*'],
            'always_include' => [],
            'always_exclude' => [],
        ],
        'apply' => [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ],
    ],
    'title' => env('SCRIBE_TITLE', 'Meditrack HMS API'),
    'description' => env('SCRIBE_DESCRIPTION', 'Hospital Management System API for East Africa'),
    'version' => env('SCRIBE_VERSION', '1.0.0'),
    'auth' => [
        'enabled' => true,
        'default' => true,
        'in' => 'bearer',
        'name' => 'Authorization',
        'use_value' => env('SCRIBE_AUTH_KEY'),
        'placeholder' => '{BEARER_TOKEN}',
        'extra_info' => 'You can obtain a token by sending a POST request to `/api/v1/auth/login` with valid credentials.',
    ],
    'intro' => null,
    'example_languages' => ['bash', 'javascript', 'php'],
    'language_examples' => [],
    'logo' => false,
    'last_updated' => null,
    'try_it_out' => [
        'enabled' => true,
        'base_url' => null,
        'browser_csrf' => false,
    ],
    'fractal' => [
        'version' => 0,
    ],
    'database_connections' => [
        'default' => env('DB_CONNECTION', 'mysql'),
    ],
    'interactive' => true,
    'faker_seed' => null,
    'output' => 'static',
    'postman' => [
        'enabled' => true,
        'overrides' => [],
    ],
    'openapi' => [
        'enabled' => true,
        'overrides' => [],
    ],
    'groups' => [
        'order' => [
            'Authentication' => 1,
            'Patients' => 2,
            'Staff & Doctors' => 3,
            'Appointments' => 4,
            'Billing & Invoices' => 5,
            'Insurance' => 6,
            'Laboratory' => 7,
            'Pharmacy & Prescriptions' => 8,
            'Radiology' => 9,
            'Surgery / OT' => 10,
            'Blood Bank' => 11,
            'Ambulance' => 12,
            'Inventory' => 13,
            'Rooms & Wards' => 14,
            'Physiotherapy' => 15,
            'Vaccinations' => 16,
            'Birth & Death Records' => 17,
            'Payroll' => 18,
            'Super-admin / SaaS' => 19,
            'Integrations' => 20,
        ],
    ],
    'examples_in_request' => false,
];

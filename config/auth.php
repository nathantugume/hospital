<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'sanctum' => [
            'driver' => 'sanctum',
            'provider' => null,
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => env('AUTH_MODEL', App\Models\User::class),
        ],
    ],
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
    'password_timeout' => 10800,
    'roles' => [
        'super_admin',
        'admin',
        'doctor',
        'nurse',
        'receptionist',
        'lab_technician',
        'pharmacist',
        'radiology_technician',
        'physiotherapist',
        'surgeon',
        'blood_bank_staff',
        'ambulance_driver',
        'ambulance_dispatcher',
        'patient',
        'accountant',
        'insurance_officer',
        'hr_manager',
        'inventory_manager',
    ],
];

<?php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
        'username' => 'email',
        'home' => env('FORTIFY_HOME', '/dashboard'),
        'view_path' => env('FORTIFY_VIEW_PATH', 'resources/views'),
    ],
    'limiters' => [
        'login' => env('FORTIFY_LIMIT_LOGIN', '5'),
        'two-factor' => env('FORTIFY_LIMIT_2FA', '5'),
    ],
    'features' => [
        Laravel\Fortify\Features::registration(),
        Laravel\Fortify\Features::resetPasswords(),
        Laravel\Fortify\Features::emailVerification(),
        Laravel\Fortify\Features::updateProfileInformation(),
        Laravel\Fortify\Features::updatePasswords(),
        Laravel\Fortify\Features::twoFactorAuthentication([
            'confirm' => true,
            'confirmPassword' => true,
        ]),
    ],
];

<?php

return [
    'stateful' => array_filter(explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,localhost:8000,127.0.0.1,127.0.0.1:8000',
        env('APP_URL') ? ',' . parse_url(env('APP_URL'), PHP_URL_HOST) : ''
    )))),
    'guard' => ['web'],
    // Tokens expire after 30 days (in minutes). Force re-authentication periodically.
    // Set to null in .env (SANCTUM_TOKEN_EXPIRATION=null) for non-expiring tokens.
    'expiration' => env('SANCTUM_TOKEN_EXPIRATION') !== null
        ? (int) env('SANCTUM_TOKEN_EXPIRATION')
        : 60 * 24 * 30, // 30 days = 43200 minutes
    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', 'meditrack_'),
    'middleware' => [
        'authenticate_session' => Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
        'encrypt_cookies' => App\Http\Middleware\EncryptCookies::class,
        'verify_csrf_token' => App\Http\Middleware\VerifyCsrfToken::class,
    ],
];

<?php

/**
 * CORS Configuration — SECURITY HARDENED
 *
 * Restricts API access to only the configured frontend domains.
 * Set CORS_ALLOWED_ORIGINS in .env as a comma-separated list.
 *
 * Default: https://meditrack-healthcare.com (production)
 * Override in .env for local dev: http://localhost:3000,http://localhost:8000
 */

$allowedOrigins = array_filter(array_map('trim', explode(',', env('CORS_ALLOWED_ORIGINS', 'https://meditrack-healthcare.com'))));

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
    'allowed_origins' => $allowedOrigins,
    'allowed_origins_patterns' => [],
    'allowed_headers' => [
        'Accept',
        'Authorization',
        'Content-Type',
        'X-Requested-With',
        'X-CSRF-Token',
        'X-XSRF-Token',
        'X-Meditrack-Request',
    ],
    'exposed_headers' => [
        'X-Total-Count',
        'X-Page-Count',
        'X-RateLimit-Limit',
        'X-RateLimit-Remaining',
    ],
    'max_age' => 86400, // 24 hours — cache preflight responses
    'supports_credentials' => true,
];

<?php

/**
 * Security Headers Configuration — FULLY CONFIGURED
 *
 * All 6 security headers are explicitly set:
 *   1. Strict-Transport-Security (HSTS)
 *   2. X-Frame-Options
 *   3. X-Content-Type-Options
 *   4. Content-Security-Policy
 *   5. Referrer-Policy
 *   6. Permissions-Policy
 *
 * These protect against: clickjacking, MIME sniffing, XSS,
 * downgrade attacks, and unauthorized device API access.
 */

return [
    /*
    |==========================================================================
    | Strict-Transport-Security (HSTS)
    |==========================================================================
    | Forces HTTPS for all requests. Once a browser sees this header, it will
    | refuse to connect via HTTP for the specified max-age.
    | - max-age: 1 year (31536000 seconds)
    | - includeSubDomains: applies to all subdomains
    | - preload: eligible for browser HSTS preload lists
    */
    'strict-transport-security' => [
        'enabled' => env('SECURITY_HSTS_ENABLED', true),
        'max-age' => 31536000,
        'include-sub-domains' => true,
        'preload' => true,
    ],

    /*
    |==========================================================================
    | X-Frame-Options
    |==========================================================================
    | Prevents the page from being embedded in <iframe>, <object>, <embed>.
    | DENY: no framing allowed at all (most secure)
    | SAMEORIGIN: only same-site can frame (use if you need iframes)
    */
    'x-frame-options' => [
        'enabled' => true,
        'mode' => 'deny',
    ],

    /*
    |==========================================================================
    | X-Content-Type-Options
    |==========================================================================
    | Prevents browsers from MIME-sniffing. Forces them to respect the
    | declared Content-Type. Stops attacks where a .txt file is executed as JS.
    */
    'x-content-type-options' => [
        'enabled' => true,
    ],

    /*
    |==========================================================================
    | Content-Security-Policy (CSP)
    |==========================================================================
    | The most powerful XSS mitigation. Restricts which resources can load.
    |
    | Directives:
    |   - default-src 'self': default policy — only same origin
    |   - script-src: scripts (CDN whitelist + inline for existing pages)
    |   - style-src: stylesheets
    |   - img-src: images
    |   - font-src: fonts
    |   - connect-src: AJAX/XHR/WebSocket destinations
    |   - frame-ancestors 'none': equivalent to X-Frame-Options: DENY
    |   - base-uri 'self': restricts <base> tag
    |   - form-action 'self': restricts form submissions
    */
    'content-security-policy' => [
        'enabled' => env('SECURITY_CSP_ENABLED', true),
        'report-only' => false,
        'directives' => [
            'default-src' => ["'self'"],
            'script-src' => [
                "'self'",
                "'unsafe-inline'",  // Required for existing inline <script> blocks
                "'unsafe-eval'",    // Required for some legacy JS (remove in production)
                'https://cdn.jsdelivr.net',
                'https://cdnjs.cloudflare.com',
                'https://cdn.tailwindcss.com',
                'https://unpkg.com',
                'https://cdn.sheetjs.com',
            ],
            'style-src' => [
                "'self'",
                "'unsafe-inline'",  // Required for Tailwind + inline styles
                'https://fonts.googleapis.com',
                'https://cdn.jsdelivr.net',
                'https://cdnjs.cloudflare.com',
            ],
            'img-src' => [
                "'self'",
                'data:',
                'blob:',
                'https://ui-avatars.com',
                'https://fonts.googleapis.com',
                'https://fonts.gstatic.com',
            ],
            'font-src' => [
                "'self'",
                'https://fonts.gstatic.com',
                'https://fonts.googleapis.com',
                'data:',
            ],
            'connect-src' => [
                "'self'",
                'https://api.africastalking.com',
                'https://sandbox.momodeveloper.mtn.com',
                'https://openapiuat.airtel.africa',
                'https://sandbox.safaricom.co.ke',
                'https://api.twilio.com',
                'https://open.er-api.com',
            ],
            'frame-ancestors' => ["'none'"],
            'base-uri' => ["'self'"],
            'form-action' => ["'self'"],
            'object-src' => ["'none'"],
            'manifest-src' => ["'self'"],
            'worker-src' => ["'self'", 'blob:'],
        ],
    ],

    /*
    |==========================================================================
    | Referrer-Policy
    |==========================================================================
    | Controls how much referrer info is sent with requests.
    | strict-origin-when-cross-origin: sends full origin for same-origin,
    | scheme+host (no path) for cross-origin HTTPS→HTTPS, nothing for HTTPS→HTTP.
    */
    'referrer-policy' => [
        'enabled' => true,
        'policy' => 'strict-origin-when-cross-origin',
    ],

    /*
    |==========================================================================
    | Permissions-Policy
    |==========================================================================
    | Controls which browser features the page can use.
    | Disables: camera, microphone, geolocation, payment, USB (unless needed)
    */
    'permissions-policy' => [
        'enabled' => true,
        'directives' => [
            'geolocation' => [],           // Empty = denied for all
            'microphone' => [],
            'camera' => [],
            'payment' => [],
            'usb' => [],
            'magnetometer' => [],
            'gyroscope' => [],
            'accelerometer' => [],
            'ambient-light-sensor' => [],
            'autoplay' => ['self'],
            'document-domain' => [],
            'encrypted-media' => ['self'],
            'fullscreen' => ['self'],
            'picture-in-picture' => ['self'],
            'sync-xhr' => ['self'],
            'wake-lock' => [],
        ],
    ],

    /*
    |==========================================================================
    | X-XSS-Protection (legacy, but still useful for older browsers)
    |==========================================================================
    */
    'x-xss-protection' => [
        'enabled' => true,
        'mode' => 'block',
    ],
];

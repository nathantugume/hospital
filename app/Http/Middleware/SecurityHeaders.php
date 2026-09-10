<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $headers = [
            'X-Frame-Options' => 'DENY',
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=(), payment=()',
        ];

        if (config('security-headers.strict-transport-security.enabled', true)) {
            $headers['Strict-Transport-Security'] = 'max-age=' . config('security-headers.strict-transport-security.max-age', 31536000)
                . '; includeSubDomains; preload';
        }

        if (config('security-headers.content-security-policy.enabled', true)) {
            $directives = [];
            foreach (config('security-headers.content-security-policy.directives', []) as $directive => $sources) {
                $directives[] = $directive . ' ' . implode(' ', $sources);
            }
            $headers['Content-Security-Policy'] = implode('; ', $directives);
        }

        foreach ($headers as $name => $value) {
            $response->headers->set($name, $value);
        }

        return $response;
    }
}

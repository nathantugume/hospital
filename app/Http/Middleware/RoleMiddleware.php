<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();
        if (! $user) {
            if (! $request->expectsJson() && ! $request->is('api/*')) {
                return redirect()->route('login');
            }

            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated.',
            ], 401);
        }
        if (! $user->hasRole($roles)) {
            if (! $request->expectsJson() && ! $request->is('api/*')) {
                return redirect()->route('access.denied');
            }

            return response()->json([
                'success' => false,
                'message' => 'Forbidden. Required role(s): ' . implode(', ', $roles),
                'required_roles' => $roles,
                'current_role' => $user->role,
            ], 403);
        }
        return $next($request);
    }
}

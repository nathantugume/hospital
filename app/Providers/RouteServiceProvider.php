<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/dashboard';

    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('login', fn(Request $r) => Limit::perMinute(5)->by($r->input('email') . '|' . $r->ip()));
        RateLimiter::for('register', fn(Request $r) => Limit::perHour(3)->by($r->ip()));
        RateLimiter::for('password-reset', fn(Request $r) => Limit::perHour(3)->by($r->ip()));
        RateLimiter::for('2fa', fn(Request $r) => Limit::perMinute(5)->by($r->session()->get('login.id')));

    }
}

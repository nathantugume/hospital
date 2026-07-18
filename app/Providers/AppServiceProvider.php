<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register integration services only when their packages are installed
        if (class_exists(\App\Services\AfricasTalkingService::class)) {
            $this->app->singleton(\App\Services\AfricasTalkingService::class, fn($app) => new \App\Services\AfricasTalkingService(config('services.africas_talking')));
        }

        $this->app->singleton(\App\Services\MomoService::class, fn($app) => new \App\Services\MomoService(config('services.mtn_momo')));
        $this->app->singleton(\App\Services\NiraService::class, fn($app) => new \App\Services\NiraService(config('services.nira')));
    }

    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}

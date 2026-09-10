<?php

namespace App\Providers;

use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();
    }

    protected function authorization(): void
    {
        Horizon::auth(function ($request) {
            // Only super_admin and admin can access Horizon dashboard
            return $request->user() && $request->user()->hasRole(['super_admin', 'admin']);
        });
    }

    protected function notification(): void
    {
        Horizon::routeMailNotificationsTo(env('HORIZON_EMAIL'));
        Horizon::routeSlackNotificationsTo(env('HORIZON_SLACK_WEBHOOK'));
    }
}

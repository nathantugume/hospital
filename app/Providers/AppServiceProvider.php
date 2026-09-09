<?php

namespace App\Providers;

use App\Services\CurrencyService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        $this->app->singleton(CurrencyService::class);
    }

    public function boot(): void
    {
        View::composer('partials.header', function ($view): void {
            $view->with('headerNotifications', \App\Models\Notification::query()
                ->where('user_id', auth()->id())->latest()->limit(8)->get());
        });
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Blade::directive('money', function (string $expression): string {
            return "<?php echo e(app(\\App\\Services\\CurrencyService::class)->format($expression)); ?>";
        });
    }
}

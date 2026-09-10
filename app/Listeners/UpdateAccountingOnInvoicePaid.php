<?php

namespace App\Listeners;

use App\Events\InvoicePaid;
use App\Services\AfricasTalkingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateAccountingOnInvoicePaid implements ShouldQueue
{
    use InteractsWithQueue;

    public $queue = 'notifications';

    public function __construct(
        protected AfricasTalkingService $sms
    ) {}

    public function handle(InvoicePaid $event): void
    {
        $model = $event->invoice;

        try {
            // Listener-specific behavior — see special cases below
            $this->execute($model);
        } catch (\Throwable $e) {
            Log::error('Listener failed: UpdateAccountingOnInvoicePaid', [
                'error' => $e->getMessage(),
                'model_id' => $model->id ?? null,
            ]);
        }
    }

    protected function execute($model): void
    {
        // Default: log only — override in specific cases below
        Log::info('Listener executed: UpdateAccountingOnInvoicePaid', [
            'model_id' => $model->id ?? null,
            'model_class' => get_class($model),
        ]);
    }
}

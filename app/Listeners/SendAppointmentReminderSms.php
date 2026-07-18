<?php

namespace App\Listeners;

use App\Events\AppointmentReminder;
use App\Services\AfricasTalkingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendAppointmentReminderSms implements ShouldQueue
{
    use InteractsWithQueue;

    public $queue = 'notifications';

    public function __construct(
        protected AfricasTalkingService $sms
    ) {}

    public function handle(AppointmentReminder $event): void
    {
        $model = $event->model;

        try {
            // Listener-specific behavior — see special cases below
            $this->execute($model);
        } catch (\Throwable $e) {
            Log::error('Listener failed: SendAppointmentReminderSms', [
                'error' => $e->getMessage(),
                'model_id' => $model->id ?? null,
            ]);
        }
    }

    protected function execute($model): void
    {
        // Default: log only — override in specific cases below
        Log::info('Listener executed: SendAppointmentReminderSms', [
            'model_id' => $model->id ?? null,
            'model_class' => get_class($model),
        ]);
    }
}

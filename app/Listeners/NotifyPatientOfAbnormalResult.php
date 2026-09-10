<?php

namespace App\Listeners;

use App\Events\AbnormalLabResult;
use App\Services\AfricasTalkingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Models\Notification;

class NotifyPatientOfAbnormalResult implements ShouldQueue
{
    use InteractsWithQueue;

    public $queue = 'notifications';

    public function __construct(
        protected AfricasTalkingService $sms
    ) {}

    public function handle(AbnormalLabResult $event): void
    {
        $model = $event->labResult;

        try {
            // Listener-specific behavior — see special cases below
            $this->execute($model);
        } catch (\Throwable $e) {
            Log::error('Listener failed: NotifyPatientOfAbnormalResult', [
                'error' => $e->getMessage(),
                'model_id' => $model->id ?? null,
            ]);
        }
    }

    protected function execute($model): void
    {
        if ($model->status !== 'Verified' || ! $model->patient?->user) { return; }
        Notification::firstOrCreate(
            ['user_id' => $model->patient->user->id, 'type' => 'abnormal_lab_result', 'action_url' => route('web.laboratory.results') . '?search=' . urlencode($model->code)],
            ['title' => 'Laboratory result available', 'message' => "Your verified {$model->test_name} result is available. Please contact your care team for interpretation.", 'category' => 'clinical', 'is_read' => false]
        );
    }
}

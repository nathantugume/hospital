<?php

namespace App\Listeners;

use App\Events\PatientRegistered;
use App\Services\AfricasTalkingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendWelcomeSms implements ShouldQueue
{
    use InteractsWithQueue;

    public $queue = 'notifications';

    public function __construct(protected AfricasTalkingService $sms) {}

    public function handle(PatientRegistered $event): void
    {
        $patient = $event->patient;
        $phone = $patient->phone;
        if (! $phone) {
            return;
        }

        $message = "Welcome to Medi-track, {$patient->first_name}! Your patient ID is {$patient->code}. "
            . "For appointments or emergencies, call +256 414 100 100.";

        $this->sms->queue($phone, $message, 'welcome', [
            'patient_id' => $patient->id,
            'recipient_name' => $patient->full_name,
        ]);

        Log::info('Welcome SMS queued for patient', ['patient_id' => $patient->id]);
    }
}

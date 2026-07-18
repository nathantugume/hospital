<?php

namespace App\Listeners;

use App\Events\AbnormalLabResult;
use App\Services\AfricasTalkingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class NotifyDoctorOfAbnormalResult implements ShouldQueue
{
    use InteractsWithQueue;

    public $queue = 'notifications';

    public function __construct(protected AfricasTalkingService $sms) {}

    public function handle(AbnormalLabResult $event): void
    {
        $labResult = $event->labResult;
        $doctor = $labResult->orderedBy;
        if (! $doctor || ! $doctor->phone) {
            return;
        }

        $message = "ABNORMAL LAB RESULT ALERT: Patient {$labResult->patient->full_name} ({$labResult->patient->code}) "
            . "Test: {$labResult->test_name} "
            . "Result: {$labResult->result_value} {$labResult->unit} "
            . "Flag: {$labResult->flag} "
            . "Normal range: {$labResult->normal_range}";

        $this->sms->queue($doctor->phone, $message, 'abnormal_lab_result', [
            'staff_id' => $doctor->id,
            'patient_id' => $labResult->patient_id,
            'recipient_name' => $doctor->full_name,
        ]);

        Log::warning('Abnormal lab result — doctor notified', [
            'lab_result_id' => $labResult->id,
            'doctor_id' => $doctor->id,
            'flag' => $labResult->flag,
        ]);
    }
}

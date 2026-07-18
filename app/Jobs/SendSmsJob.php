<?php

namespace App\Jobs;

use App\Models\SmsLog;
use App\Services\AfricasTalkingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 30;

    public function __construct(public int $smsLogId) {}

    public function handle(AfricasTalkingService $sms): void
    {
        $log = SmsLog::find($this->smsLogId);
        if (! $log) {
            Log::warning('SendSmsJob: SMS log not found', ['sms_log_id' => $this->smsLogId]);
            return;
        }

        if ($log->status === 'delivered' || $log->status === 'Sent') {
            return;
        }

        $sms->send($log->to_phone, $log->message, $log->category ?? 'general', [
            'patient_id' => $log->patient_id,
            'staff_id' => $log->staff_id,
            'user_id' => $log->user_id,
            'recipient_name' => $log->recipient_name,
        ]);
    }

    public function failed(\Throwable $e): void
    {
        Log::error('SendSmsJob failed', [
            'sms_log_id' => $this->smsLogId,
            'error' => $e->getMessage(),
        ]);

        SmsLog::where('id', $this->smsLogId)->update([
            'status' => 'failed',
            'error_message' => $e->getMessage(),
        ]);
    }
}

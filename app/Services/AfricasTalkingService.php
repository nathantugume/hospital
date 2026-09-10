<?php

namespace App\Services;

use App\Jobs\SendSmsJob;
use App\Models\SmsLog;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Africa's Talking SMS Service
 *
 * Covers: Uganda, Kenya, Tanzania, Rwanda, Burundi, Ethiopia, South Sudan, DRC
 * API docs: https://developers.africastalking.com/docs/sms
 *
 * Usage:
 *   $sms = app(AfricasTalkingService::class);
 *   $sms->send('+256712345678', 'Your lab result is ready.', 'lab_result');
 *
 * All SMS are queued via Redis. Status is logged in sms_logs table.
 */
class AfricasTalkingService
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Send SMS synchronously (used by queue worker).
     */
    public function send(string $to, string $message, string $category = 'general', array $context = []): ?SmsLog
    {
        $log = SmsLog::create([
            'to_phone' => $to,
            'recipient_name' => $context['recipient_name'] ?? null,
            'message' => $message,
            'sender_id' => $this->config['sender_id'],
            'provider' => 'africas_talking',
            'status' => 'queued',
            'category' => $category,
            'user_id' => $context['user_id'] ?? null,
            'patient_id' => $context['patient_id'] ?? null,
            'staff_id' => $context['staff_id'] ?? null,
        ]);

        try {
            $isSandbox = (bool) ($this->config['sandbox'] ?? true);
            $baseUrl = $this->config['base_url'] ?? 'https://api.africastalking.com/version1';
            $endpoint = $isSandbox
                ? 'https://api.sandbox.africastalking.com/version1/messaging'
                : $baseUrl . '/messaging/bulk';

            /** @var Response $response */
            $response = Http::withHeaders([
                'apiKey' => $this->config['api_key'],
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json',
            ])->asForm()->post($endpoint, [
                'username' => $this->config['username'],
                'to' => $to,
                'message' => $message,
                'from' => $this->config['sender_id'],
            ]);

            $body = $response->json();

            if ($response->successful() && isset($body['SMSMessageData']['Message'])) {
                $messageData = $body['SMSMessageData'];
                $recipients = $messageData['Recipients'] ?? [];
                $recipient = $recipients[0] ?? [];

                $log->update([
                    'message_id' => $recipient['messageId'] ?? null,
                    'status' => $recipient['status'] ?? 'Sent',
                    'status_code' => (string) $response->status(),
                    'cost' => $recipient['cost'] ?? null,
                    'currency' => 'UGX',
                    'sent_at' => now(),
                ]);

                return $log->fresh();
            }

            $log->update([
                'status' => 'failed',
                'status_code' => (string) $response->status(),
                'error_message' => $body['SMSMessageData']['Message'] ?? $response->body(),
            ]);

            Log::error("Africa's Talking SMS failed", [
                'to' => $to,
                'response' => $body,
            ]);

            return $log->fresh();

        } catch (\Throwable $e) {
            $log->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            Log::error("Africa's Talking SMS exception", [
                'to' => $to,
                'error' => $e->getMessage(),
            ]);
            return $log->fresh();
        }
    }

    /**
     * Queue SMS via Redis queue (preferred).
     */
    public function queue(string $to, string $message, string $category = 'general', array $context = []): SmsLog
    {
        $log = SmsLog::create([
            'to_phone' => $to,
            'recipient_name' => $context['recipient_name'] ?? null,
            'message' => $message,
            'sender_id' => $this->config['sender_id'],
            'provider' => 'africas_talking',
            'status' => 'queued',
            'category' => $category,
            'user_id' => $context['user_id'] ?? null,
            'patient_id' => $context['patient_id'] ?? null,
            'staff_id' => $context['staff_id'] ?? null,
        ]);

        SendSmsJob::dispatch($log->id)->onQueue('sms');

        return $log;
    }

    /**
     * Fetch delivery reports from Africa's Talking callback.
     */
    public function processDeliveryReport(array $payload): void
    {
        $messageId = $payload['id'] ?? null;
        if (! $messageId) {
            return;
        }

        $log = SmsLog::where('message_id', $messageId)->first();
        if (! $log) {
            return;
        }

        $log->update([
            'status' => $payload['status'] ?? $log->status,
            'delivered_at' => isset($payload['doneDate']) ? now()->parse($payload['doneDate']) : null,
        ]);
    }

    /**
     * Voice call (Africa's Talking Voice).
     */
    public function makeVoiceCall(string $to, string $text): ?array
    {
        $endpoint = ($this->config['voice_base_url'] ?? 'https://voice.africastalking.com') . '/call';

        $response = Http::withHeaders([
            'apiKey' => $this->config['api_key'],
        ])->asForm()->post($endpoint, [
            'username' => $this->config['username'],
            'from' => $this->config['sender_id'],
            'to' => $to,
            'text' => $text,
        ]);

        return $response->successful() ? $response->json() : null;
    }
}

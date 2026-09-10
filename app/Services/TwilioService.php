<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Twilio Service — Emergency voice calls for ambulance dispatch & critical alerts.
 *
 * Used for:
 *   - Emergency triage notifications (Red/Orange severity)
 *   - Auto-call nearest ambulance driver
 *   - Code Blue / Code Red alerts to ER staff
 */
class TwilioService
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Make an emergency voice call using TwiML.
     */
    public function emergencyCall(string $to, string $message, string $severity = 'Red'): ?array
    {
        $accountSid = $this->config['account_sid'] ?? null;
        $authToken = $this->config['auth_token'] ?? null;
        $from = $this->config['from'] ?? null;

        if (! $accountSid || ! $authToken || str_starts_with($accountSid, 'ACxxx')) {
            // Sandbox mode
            Log::info('Twilio emergency call (sandbox)', [
                'to' => $to,
                'message' => $message,
                'severity' => $severity,
            ]);
            return [
                'status' => 'queued',
                'to' => $to,
                'severity' => $severity,
                '_mock' => true,
                '_note' => 'Set TWILIO_ACCOUNT_SID and TWILIO_AUTH_TOKEN in .env to enable real calls.',
            ];
        }

        try {
            $twiml = '<Response><Say voice="alice" language="en-GB">'
                . htmlspecialchars($message)
                . '</Say></Response>';

            $response = Http::withBasicAuth($accountSid, $authToken)
                ->asForm()->post("https://api.twilio.com/2010-04-01/Accounts/{$accountSid}/Calls.json", [
                    'To' => $to,
                    'From' => $from,
                    'Twiml' => $twiml,
                    'StatusCallback' => config('app.url') . '/api/v1/integrations/twilio/status-callback',
                ]);

            return $response->successful() ? $response->json() : ['status' => 'failed', 'error' => $response->body()];

        } catch (\Throwable $e) {
            Log::error('Twilio emergency call failed', ['to' => $to, 'error' => $e->getMessage()]);
            return ['status' => 'failed', 'error' => $e->getMessage()];
        }
    }

    /**
     * Trigger triage alert — calls the configured emergency group.
     */
    public function triggerTriageAlert(string $severity, string $patientName, string $location, array $extra = []): array
    {
        $severity = ucfirst(strtolower($severity));
        $message = "Emergency triage alert. Severity: {$severity}. Patient: {$patientName}. Location: {$location}.";
        if (! empty($extra['reason'])) {
            $message .= " Reason: {$extra['reason']}.";
        }

        $emergencyGroup = explode(',', $this->config['emergency_group'] ?? '');
        $results = [];

        foreach ($emergencyGroup as $phone) {
            $phone = trim($phone);
            if ($phone) {
                $results[$phone] = $this->emergencyCall($phone, $message, $severity);
            }
        }

        return [
            'severity' => $severity,
            'message' => $message,
            'calls' => $results,
        ];
    }
}

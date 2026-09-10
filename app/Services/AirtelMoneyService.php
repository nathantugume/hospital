<?php

namespace App\Services;

use App\Models\MobileMoneyTransaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Airtel Money Service — Uganda collections
 *
 * API docs: https://developers.airtel.africa
 * Sandbox: https://openapiuat.airtel.africa
 */
class AirtelMoneyService
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getAccessToken(): string
    {
        return \Cache::remember('airtel_money_token', 50 * 60, function () {
            $baseUrl = $this->config['base_url'] ?? 'https://openapiuat.airtel.africa';
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => '*/*',
            ])->post("{$baseUrl}/auth/oauth2/token", [
                'client_id' => $this->config['client_id'],
                'client_secret' => $this->config['client_secret'],
                'grant_type' => $this->config['grant_type'] ?? 'client_credentials',
            ]);

            if (! $response->successful()) {
                throw new \RuntimeException('Airtel Money auth failed: ' . $response->body());
            }
            return $response->json('access_token');
        });
    }

    public function initiateCollection(string $payerPhone, float $amount, string $currency, string $reference, string $remarks, ?int $invoiceId = null, ?int $patientId = null): MobileMoneyTransaction
    {
        $baseUrl = $this->config['base_url'] ?? 'https://openapiuat.airtel.africa';
        $txnId = (string) Str::uuid();

        $txn = MobileMoneyTransaction::create([
            'code' => 'AMT-' . str_pad((string) (MobileMoneyTransaction::max('id') + 1), 6, '0', STR_PAD_LEFT),
            'provider' => 'airtel',
            'provider_reference' => $txnId,
            'status' => 'initiated',
            'direction' => 'collection',
            'amount' => $amount,
            'currency' => $currency,
            'payer_phone' => $payerPhone,
            'payer_name' => null,
            'payee_note' => $remarks,
            'payment_reason' => $remarks,
            'invoice_id' => $invoiceId,
            'patient_id' => $patientId,
        ]);

        try {
            $response = Http::withToken($this->getAccessToken())
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("{$baseUrl}/standard/v1/collections/", [
                    'reference' => $reference,
                    'subscriber' => [
                        'country' => 'UG',
                        'currency' => $currency,
                        'msisdn' => ltrim($payerPhone, '+'),
                    ],
                    'transaction' => [
                        'amount' => $amount,
                        'country' => 'UG',
                        'currency' => $currency,
                        'id' => $txnId,
                    ],
                ]);

            $txn->update([
                'request_payload' => json_encode(['amount' => $amount, 'currency' => $currency, 'payer_phone' => $payerPhone]),
                'response_payload' => $response->body(),
            ]);

            $data = $response->json();
            $status = $data['status']['success'] ?? false;
            $txn->update([
                'status' => $status ? 'pending' : 'failed',
                'error_message' => $status ? null : ($data['status']['message'] ?? 'Unknown error'),
            ]);

            return $txn->fresh();

        } catch (\Throwable $e) {
            $txn->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            Log::error('Airtel Money collection failed', ['transaction_id' => $txn->id, 'error' => $e->getMessage()]);
            return $txn->fresh();
        }
    }

    public function processCallback(array $payload): ?MobileMoneyTransaction
    {
        $txnId = $payload['transaction']['id'] ?? null;
        if (! $txnId) {
            return null;
        }

        $txn = MobileMoneyTransaction::where('provider_reference', $txnId)->first();
        if (! $txn) {
            return null;
        }

        $status = $payload['transaction']['status'] ?? 'FAILED';
        $txn->update([
            'transaction_id' => $payload['transaction']['financial_transaction_id'] ?? null,
            'status' => strtolower($status),
            'callback_payload' => json_encode($payload),
            'completed_at' => strtolower($status) === 'success' ? now() : null,
        ]);

        if (strtolower($status) === 'success' && $txn->invoice_id) {
            event(new \App\Events\InvoicePaid($txn->invoice, $txn));
        }

        return $txn->fresh();
    }
}

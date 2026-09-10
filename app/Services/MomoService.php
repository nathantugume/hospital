<?php

namespace App\Services;

use App\Models\MobileMoneyTransaction;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * MTN MoMo (Mobile Money) Service — Uganda collections + disbursements
 *
 * API docs: https://momodeveloper.mtn.com
 * Sandbox: https://sandbox.momodeveloper.mtn.com
 *
 * Flow:
 *   1. getAccessToken() → caches token
 *   2. initiateCollection() → POST /collection/v1_0/requesttopay
 *   3. Poll status OR wait for callback at /api/v1/payments/mtn/callback
 *   4. processCallback() → updates MobileMoneyTransaction
 */
class MomoService
{
    protected array $config;
    protected ?string $token = null;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get OAuth access token (cached 50 minutes in Redis).
     */
    public function getAccessToken(): string
    {
        return \Cache::remember('mtn_momo_token', 50 * 60, function () {
            $baseUrl = $this->config['base_url'] ?? 'https://sandbox.momodeveloper.mtn.com';
            $response = Http::withBasicAuth(
                $this->config['api_user'],
                $this->config['api_key']
            )->withHeaders([
                'Ocp-Apim-Subscription-Key' => $this->config['subscription_key'],
            ])->post("{$baseUrl}/collection/token/");

            if (! $response->successful()) {
                throw new \RuntimeException('MTN MoMo auth failed: ' . $response->body());
            }
            return $response->json('access_token');
        });
    }

    /**
     * Initiate a Collection (request-to-pay).
     */
    public function initiateCollection(string $payerPhone, float $amount, string $currency, string $externalId, string $payerMessage, string $payeeNote, ?int $invoiceId = null, ?int $patientId = null): MobileMoneyTransaction
    {
        $baseUrl = $this->config['base_url'] ?? 'https://sandbox.momodeveloper.mtn.com';
        $referenceId = (string) Str::uuid();

        $txn = MobileMoneyTransaction::create([
            'code' => 'MMT-' . str_pad((string) (MobileMoneyTransaction::max('id') + 1), 6, '0', STR_PAD_LEFT),
            'provider' => 'mtn',
            'provider_reference' => $referenceId,
            'status' => 'initiated',
            'direction' => 'collection',
            'amount' => $amount,
            'currency' => $currency,
            'payer_phone' => $payerPhone,
            'payer_name' => null,
            'payee_note' => $payeeNote,
            'payment_reason' => $payerMessage,
            'invoice_id' => $invoiceId,
            'patient_id' => $patientId,
        ]);

        try {
            $response = Http::withToken($this->getAccessToken())
                ->withHeaders([
                    'X-Reference-Id' => $referenceId,
                    'X-Target-Environment' => $this->config['target_environment'] ?? 'mtncameroon',
                    'Ocp-Apim-Subscription-Key' => $this->config['subscription_key'],
                ])->post("{$baseUrl}/collection/v1_0/requesttopay", [
                    'amount' => (string) $amount,
                    'currency' => $currency,
                    'externalId' => $externalId,
                    'payer' => [
                        'partyIdType' => 'MSISDN',
                        'partyId' => $payerPhone,
                    ],
                    'payerMessage' => $payerMessage,
                    'payeeNote' => $payeeNote,
                ]);

            $txn->update([
                'request_payload' => json_encode([
                    'amount' => $amount,
                    'currency' => $currency,
                    'payer_phone' => $payerPhone,
                ]),
                'response_payload' => $response->body(),
            ]);

            if ($response->status() === 202) {
                $txn->update(['status' => 'pending']);
                return $txn->fresh();
            }

            $txn->update([
                'status' => 'failed',
                'error_message' => 'HTTP ' . $response->status() . ': ' . $response->body(),
            ]);

            return $txn->fresh();

        } catch (\Throwable $e) {
            $txn->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            Log::error('MTN MoMo collection failed', [
                'transaction_id' => $txn->id,
                'error' => $e->getMessage(),
            ]);
            return $txn->fresh();
        }
    }

    /**
     * Check transaction status (polling fallback).
     */
    public function checkStatus(string $referenceId): array
    {
        $baseUrl = $this->config['base_url'] ?? 'https://sandbox.momodeveloper.mtn.com';
        $response = Http::withToken($this->getAccessToken())
            ->withHeaders([
                'X-Target-Environment' => $this->config['target_environment'] ?? 'mtncameroon',
                'Ocp-Apim-Subscription-Key' => $this->config['subscription_key'],
            ])->get("{$baseUrl}/collection/v1_0/requesttopay/{$referenceId}");

        return $response->json() ?? ['status' => 'UNKNOWN'];
    }

    /**
     * Process the callback from MTN MoMo.
     */
    public function processCallback(array $payload): ?MobileMoneyTransaction
    {
        $referenceId = $payload['referenceId'] ?? null;
        if (! $referenceId) {
            return null;
        }

        $txn = MobileMoneyTransaction::where('provider_reference', $referenceId)->first();
        if (! $txn) {
            Log::warning('MTN callback for unknown transaction', $payload);
            return null;
        }

        $status = $payload['status'] ?? 'UNKNOWN';
        $txn->update([
            'transaction_id' => $payload['financialTransactionId'] ?? $txn->transaction_id,
            'status' => strtolower($status),
            'callback_payload' => json_encode($payload),
            'completed_at' => in_array(strtolower($status), ['success', 'successful', 'completed']) ? now() : null,
        ]);

        if (in_array(strtolower($status), ['success', 'successful', 'completed'])) {
            // Fire InvoicePaid event if linked to invoice
            if ($txn->invoice_id) {
                event(new \App\Events\InvoicePaid($txn->invoice, $txn));
            }
        }

        return $txn->fresh();
    }
}

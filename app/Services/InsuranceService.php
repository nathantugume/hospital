<?php

namespace App\Services;

use App\Models\InsuranceClaim;
use App\Models\InsuranceCommunication;
use App\Models\InsuranceProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Insurance Integration Service — pre-authorization & claim submission.
 *
 * Supported providers (configured in config/services.php):
 *   - UAP Old Mutual (UG/KE/TZ/RW)
 *   - Jubilee Insurance
 *   - ICEA Lion
 *   - Britam
 *   - Sanlam
 *   - NHIF Kenya
 *   - NHIF Tanzania
 *   - RSSB Rwanda
 *
 * Workflow:
 *   1. verifyPolicy($provider, $policyNumber) — check coverage
 *   2. preAuthorize($provider, $claim) — request pre-auth for planned procedure
 *   3. submitClaim($provider, $claim) — submit final claim
 *   4. trackClaim($claim) — poll status
 */
class InsuranceService
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Verify that a policy number is active and has coverage.
     */
    public function verifyPolicy(string $providerKey, string $policyNumber, ?int $claimId = null): array
    {
        $provider = InsuranceProvider::where('api_provider_key', $providerKey)
            ->orWhere('code', $providerKey)
            ->first();

        if (! $provider) {
            return ['status' => 'error', 'message' => "Unknown provider: {$providerKey}"];
        }

        $providerConfig = $this->config['providers'][$providerKey] ?? null;
        $apiUrl = $providerConfig['url'] ?? $provider->api_url;
        $apiKey = $providerConfig['key'] ?? $provider->api_key;

        $log = $this->logCommunication($claimId, 'out', 'verify_policy', [
            'provider' => $providerKey,
            'policy_number' => $policyNumber,
        ]);

        try {
            if (! $apiUrl || ! $apiKey || str_starts_with($apiKey, 'xxx')) {
                // Sandbox / mock response
                $response = [
                    'status' => 'verified',
                    'policy_number' => $policyNumber,
                    'policy_holder' => 'Okello David',
                    'coverage' => 'Active',
                    'benefits' => ['Inpatient', 'Outpatient', 'Lab', 'Pharmacy'],
                    'remaining_annual_limit' => 50000000,
                    'currency' => 'UGX',
                    '_mock' => true,
                ];
            } else {
                $httpResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])->post("{$apiUrl}/policy/verify", [
                    'policy_number' => $policyNumber,
                ]);
                $response = $httpResponse->json();
                $log->update(['status_code' => (string) $httpResponse->status()]);
            }

            $log->update(['response_body' => json_encode($response)]);

            return $response;

        } catch (\Throwable $e) {
            $log->update([
                'response_body' => json_encode(['error' => $e->getMessage()]),
            ]);
            Log::error('Insurance policy verification failed', [
                'provider' => $providerKey,
                'policy' => $policyNumber,
                'error' => $e->getMessage(),
            ]);
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Request pre-authorization for a planned procedure.
     */
    public function preAuthorize(string $providerKey, InsuranceClaim $claim): array
    {
        $providerConfig = $this->config['providers'][$providerKey] ?? null;
        $apiUrl = $providerConfig['url'] ?? null;
        $apiKey = $providerConfig['key'] ?? null;

        $log = $this->logCommunication($claim->id, 'out', 'pre_authorization', [
            'claim_id' => $claim->id,
            'provider' => $providerKey,
            'amount' => $claim->amount,
        ]);

        try {
            if (! $apiUrl || ! $apiKey || str_starts_with($apiKey, 'xxx')) {
                $response = [
                    'status' => 'approved',
                    'pre_auth_id' => 'PA-' . str_pad((string) $claim->id, 6, '0', STR_PAD_LEFT),
                    'approved_amount' => $claim->amount,
                    'currency' => $claim->currency,
                    'valid_until' => now()->addDays(30)->toDateString(),
                    '_mock' => true,
                ];
            } else {
                $httpResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                ])->post("{$apiUrl}/claims/pre-authorize", [
                    'policy_number' => $claim->policy_number,
                    'amount' => $claim->amount,
                    'currency' => $claim->currency,
                    'services' => $claim->services->map(fn($s) => ['name' => $s->name, 'billed' => $s->billed]),
                ]);
                $response = $httpResponse->json();
                $log->update(['status_code' => (string) $httpResponse->status()]);
            }

            $log->update(['response_body' => json_encode($response)]);

            if (($response['status'] ?? '') === 'approved') {
                $claim->update([
                    'status' => 'Pre-Approved',
                    'approved_amount' => $response['approved_amount'] ?? $claim->amount,
                ]);
            }

            return $response;

        } catch (\Throwable $e) {
            $log->update(['response_body' => json_encode(['error' => $e->getMessage()])]);
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Submit a final claim.
     */
    public function submitClaim(InsuranceClaim $claim): array
    {
        $providerKey = $claim->insuranceProvider->api_provider_key
            ?? strtolower(str_replace(' ', '_', $claim->provider));

        $providerConfig = $this->config['providers'][$providerKey] ?? null;
        $apiUrl = $providerConfig['url'] ?? null;
        $apiKey = $providerConfig['key'] ?? null;

        $log = $this->logCommunication($claim->id, 'out', 'submit_claim', [
            'claim_id' => $claim->id,
            'amount' => $claim->amount,
        ]);

        try {
            if (! $apiUrl || ! $apiKey || str_starts_with($apiKey, 'xxx')) {
                $response = [
                    'status' => 'submitted',
                    'claim_reference' => 'CLM-' . str_pad((string) $claim->id, 8, '0', STR_PAD_LEFT),
                    'submitted_at' => now()->toIso8601String(),
                    '_mock' => true,
                ];
            } else {
                $httpResponse = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                ])->post("{$apiUrl}/claims/submit", [
                    'policy_number' => $claim->policy_number,
                    'amount' => $claim->amount,
                    'services' => $claim->services->toArray(),
                ]);
                $response = $httpResponse->json();
                $log->update(['status_code' => (string) $httpResponse->status()]);
            }

            $log->update(['response_body' => json_encode($response)]);

            $claim->update([
                'status' => 'Submitted',
                'submitted_date' => now(),
            ]);

            return $response;

        } catch (\Throwable $e) {
            $log->update(['response_body' => json_encode(['error' => $e->getMessage()])]);
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    protected function logCommunication(?int $claimId, string $direction, string $type, array $request): InsuranceCommunication
    {
        return InsuranceCommunication::create([
            'claim_id' => $claimId,
            'direction' => $direction,
            'message_type' => $type,
            'request_body' => json_encode($request),
        ]);
    }
}

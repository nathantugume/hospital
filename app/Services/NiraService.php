<?php

namespace App\Services;

use App\Models\NationalIdVerification;
use App\Models\Patient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * NIRA / NIIMS / NIDA National ID Verification Service
 *
 * - Uganda: NIRA (National Identification and Registration Authority)
 * - Kenya:  NIIMS / Huduma Namb
 * - Tanzania: NIDA (National Identification Authority)
 * - Rwanda: NIDA Rwanda
 *
 * API endpoints are configured in config/services.php per country.
 */
class NiraService
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Verify a National ID number against the configured provider.
     *
     * @param string $nationalId The national ID number (encrypted in DB)
     * @param string $country One of: Uganda, Kenya, Tanzania, Rwanda
     * @param int|null $patientId Link to patient record
     * @return NationalIdVerification
     */
    public function verify(string $nationalId, string $country = 'Uganda', ?int $patientId = null, ?int $userId = null): NationalIdVerification
    {
        $provider = $this->resolveProvider($country);

        $verification = NationalIdVerification::create([
            'national_id' => $nationalId,
            'country' => $country,
            'provider' => $provider,
            'status' => 'pending',
            'patient_id' => $patientId,
            'user_id' => $userId,
        ]);

        try {
            $response = $this->callProvider($provider, $nationalId);

            $verification->update([
                'verification_id' => $response['verification_id'] ?? null,
                'full_name' => $response['full_name'] ?? null,
                'date_of_birth' => $response['date_of_birth'] ?? null,
                'gender' => $response['gender'] ?? null,
                'photo_url' => $response['photo_url'] ?? null,
                'status' => $response['status'] ?? 'verified',
                'response_payload' => json_encode($response),
            ]);

            // Auto-populate patient record if linked
            if ($patientId && ($response['full_name'] ?? null)) {
                $patient = Patient::find($patientId);
                if ($patient) {
                    $parts = explode(' ', trim($response['full_name']), 2);
                    $patient->update([
                        'first_name' => $parts[0] ?? $patient->first_name,
                        'last_name' => $parts[1] ?? $patient->last_name,
                        'date_of_birth' => $response['date_of_birth'] ?? $patient->date_of_birth,
                        'gender' => $response['gender'] ?? $patient->gender,
                    ]);
                }
            }

            return $verification->fresh();

        } catch (\Throwable $e) {
            $verification->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            Log::error('National ID verification failed', [
                'verification_id' => $verification->id,
                'provider' => $provider,
                'error' => $e->getMessage(),
            ]);
            return $verification->fresh();
        }
    }

    protected function resolveProvider(string $country): string
    {
        return match (strtolower($country)) {
            'uganda' => 'NIRA',
            'kenya' => 'NIIMS',
            'tanzania' => 'NIDA',
            'rwanda' => 'NIDA_Rwanda',
            default => 'NIRA',
        };
    }

    protected function callProvider(string $provider, string $nationalId): array
    {
        $config = match ($provider) {
            'NIRA' => $this->config,
            'NIIMS' => config('services.niims'),
            'NIDA' => config('services.nida'),
            'NIDA_Rwanda' => config('services.nida_rwanda'),
            default => $this->config,
        };

        $apiUrl = $config['api_url'] ?? null;
        $apiKey = $config['api_key'] ?? null;

        $hasRealCredentials = $apiUrl && $apiKey
            && ! preg_match('/^(x+|your[_-]?|change[_-]?|placeholder)/i', (string) $apiKey);

        if (! $hasRealCredentials) {
            // Mock response in sandbox/no-credentials mode
            return [
                'status' => 'verified',
                'verification_id' => 'MOCK-' . substr(md5($nationalId), 0, 12),
                'full_name' => 'Okello David',
                'date_of_birth' => '1980-05-15',
                'gender' => 'Male',
                'photo_url' => null,
                '_mock' => true,
                '_note' => 'Mock response — set NIRA_API_KEY in .env to enable real verification.',
            ];
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->withOptions([
            'timeout' => $config['timeout'] ?? 30,
        ])->post("{$apiUrl}/verify", [
            'national_id' => $nationalId,
            'provider' => $provider,
        ]);

        if (! $response->successful()) {
            throw new \RuntimeException('Provider returned HTTP ' . $response->status() . ': ' . $response->body());
        }

        $data = $response->json();
        return [
            'status' => $data['status'] ?? 'verified',
            'verification_id' => $data['verification_id'] ?? null,
            'full_name' => $data['full_name'] ?? $data['name'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? $data['dob'] ?? null,
            'gender' => $data['gender'] ?? null,
            'photo_url' => $data['photo_url'] ?? $data['photo'] ?? null,
        ];
    }
}

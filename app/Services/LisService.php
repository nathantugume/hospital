<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Laboratory Information System (LIS) Service.
 *
 * Bridges to external lab analyzers / LIS via:
 *   - REST API (for modern instruments)
 *   - HL7 over TCP (legacy, port 2575)
 *   - FHIR R4 DiagnosticReport (modern interoperability)
 *
 * Workflow:
 *   1. pushResult($labResult) — push results from HMS → LIS
 *   2. receiveResult($payload) — receive from LIS webhook → create/update lab_results
 *   3. getEquipmentStatus($equipmentId) — query instrument status
 */
class LisService
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Push a lab result to the external LIS.
     */
    public function pushResult(\App\Models\LabResult $result): array
    {
        $apiUrl = $this->config['api_url'] ?? null;
        $apiKey = $this->config['api_key'] ?? null;

        if (! $apiUrl || ! $apiKey || str_starts_with($apiKey, 'xxx')) {
            return [
                'status' => 'mocked',
                '_note' => 'Set LIS_API_KEY in .env to enable real integration.',
                'result_id' => $result->id,
            ];
        }

        $fhirPayload = $this->toFhirDiagnosticReport($result);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/fhir+json',
            ])->post("{$apiUrl}/fhir/DiagnosticReport", $fhirPayload);

            return [
                'status' => $response->successful() ? 'pushed' : 'failed',
                'status_code' => $response->status(),
                'response' => $response->json(),
            ];

        } catch (\Throwable $e) {
            Log::error('LIS push failed', ['result_id' => $result->id, 'error' => $e->getMessage()]);
            return ['status' => 'failed', 'error' => $e->getMessage()];
        }
    }

    /**
     * Receive a result from the LIS (webhook).
     */
    public function receiveResult(array $payload): ?\App\Models\LabResult
    {
        $sampleId = $payload['sample_id'] ?? $payload['specimen']['identifier']['value'] ?? null;
        if (! $sampleId) {
            return null;
        }

        $result = \App\Models\LabResult::where('sample_id', $sampleId)->first();
        if (! $result) {
            // Could be a new result from a sample collected externally
            $patientId = $payload['patient_id'] ?? null;
            if (! $patientId) {
                return null;
            }
            $result = \App\Models\LabResult::create([
                'code' => 'RES-' . str_pad((string) (\App\Models\LabResult::max('id') + 1), 4, '0', STR_PAD_LEFT),
                'sample_id' => $sampleId,
                'patient_id' => $patientId,
                'test_name' => $payload['test_name'] ?? 'Unknown',
                'result_date' => now(),
                'collection_date' => $payload['collection_date'] ?? now(),
                'status' => 'Pending',
                'department' => $payload['department'] ?? 'General Lab',
            ]);
        }

        // Update main result fields
        $result->update([
            'result_value' => $payload['result_value'] ?? $result->result_value,
            'normal_range' => $payload['normal_range'] ?? $result->normal_range,
            'unit' => $payload['unit'] ?? $result->unit,
            'flag' => $payload['flag'] ?? 'Normal',
            'status' => 'Completed',
            'result_date' => now(),
        ]);

        // Update individual result items (panel parameters)
        if (isset($payload['items']) && is_array($payload['items'])) {
            foreach ($payload['items'] as $item) {
                \App\Models\LabResultItem::updateOrCreate(
                    ['lab_result_id' => $result->id, 'test' => $item['test']],
                    [
                        'result' => $item['result'] ?? null,
                        'range' => $item['range'] ?? null,
                        'unit' => $item['unit'] ?? null,
                        'flag' => $item['flag'] ?? 'Normal',
                    ]
                );
            }
        }

        return $result->fresh();
    }

    /**
     * Convert lab result to FHIR R4 DiagnosticReport resource.
     */
    public function toFhirDiagnosticReport(\App\Models\LabResult $result): array
    {
        return [
            'resourceType' => 'DiagnosticReport',
            'status' => 'final',
            'category' => [[
                'coding' => [[
                    'system' => 'http://terminology.hl7.org/CodeSystem/v2-0074',
                    'code' => 'LAB',
                    'display' => 'Laboratory',
                ]],
            ]],
            'code' => [[
                'coding' => [[
                    'display' => $result->test_name,
                ]],
            ]],
            'subject' => ['reference' => 'Patient/' . $result->patient_id],
            'effectiveDateTime' => $result->collection_date?->toIso8601String(),
            'issued' => $result->result_date?->toIso8601String(),
            'specimen' => [['reference' => 'Specimen/' . $result->sample_id]],
            'result' => $result->items->map(fn($item) => [
                'reference' => 'Observation/' . $item->id,
                'display' => $item->test . ': ' . $item->result . ' ' . $item->unit,
            ])->toArray(),
            'conclusion' => $result->notes,
        ];
    }
}

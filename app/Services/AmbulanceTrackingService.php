<?php

namespace App\Services;

use App\Models\Ambulance;
use App\Models\AmbulanceGpsPosition;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Ambulance GPS Tracking Service.
 *
 * Pulls GPS positions from the configured provider (OnTrack by default for Uganda)
 * every GPS_POLL_INTERVAL seconds and stores them in ambulance_gps_positions.
 *
 * Also supports inbound webhooks from GPS devices mounted on ambulances.
 */
class AmbulanceTrackingService
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Pull the latest position for a single ambulance.
     */
    public function fetchPosition(Ambulance $ambulance): ?AmbulanceGpsPosition
    {
        $apiUrl = $this->config['api_url'] ?? null;
        $apiKey = $this->config['api_key'] ?? null;

        if (! $apiUrl || ! $apiKey || str_starts_with($apiKey, 'xxx')) {
            // Sandbox — generate a plausible Kampala-area position
            $kampalaCenter = [0.3476, 32.5825];
            return $this->storePosition($ambulance->id, null,
                $kampalaCenter[0] + (rand(-100, 100) / 1000),
                $kampalaCenter[1] + (rand(-100, 100) / 1000),
                rand(0, 80),
                rand(0, 360),
                ['_mock' => true]
            );
        }

        try {
            $response = Http::withHeaders(['Authorization' => 'Bearer ' . $apiKey])
                ->get("{$apiUrl}/vehicles/{$ambulance->reg_no}/position");

            if (! $response->successful()) {
                return null;
            }

            $data = $response->json();
            return $this->storePosition(
                $ambulance->id,
                $data['call_id'] ?? null,
                $data['lat'],
                $data['lng'],
                $data['speed'] ?? 0,
                $data['heading'] ?? 0,
                $data
            );

        } catch (\Throwable $e) {
            Log::error('Ambulance GPS fetch failed', [
                'ambulance_id' => $ambulance->id,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Inbound callback from a GPS device / provider webhook.
     */
    public function processCallback(array $payload): ?AmbulanceGpsPosition
    {
        $regNo = $payload['vehicle_id'] ?? $payload['reg_no'] ?? null;
        if (! $regNo) {
            return null;
        }

        $ambulance = Ambulance::where('reg_no', $regNo)->first();
        if (! $ambulance) {
            return null;
        }

        return $this->storePosition(
            $ambulance->id,
            $payload['call_id'] ?? null,
            $payload['lat'],
            $payload['lng'],
            $payload['speed'] ?? 0,
            $payload['heading'] ?? 0,
            $payload
        );
    }

    /**
     * Sync all ambulances (called by scheduler every minute).
     */
    public function syncAll(): int
    {
        $count = 0;
        foreach (Ambulance::where('status', 'On Call')->get() as $ambulance) {
            if ($this->fetchPosition($ambulance)) {
                $count++;
            }
        }
        return $count;
    }

    protected function storePosition(int $ambulanceId, ?int $callId, float $lat, float $lng, float $speed, float $heading, array $raw = []): AmbulanceGpsPosition
    {
        $position = AmbulanceGpsPosition::create([
            'ambulance_id' => $ambulanceId,
            'ambulance_call_id' => $callId,
            'lat' => $lat,
            'lng' => $lng,
            'speed' => $speed,
            'heading' => $heading,
            'recorded_at' => now(),
        ]);

        // Update ambulance's current position (denormalized for quick lookup)
        if ($callId) {
            \App\Models\AmbulanceCall::where('id', $callId)->update([
                'current_lat' => $lat,
                'current_lng' => $lng,
            ]);
        }

        return $position;
    }
}

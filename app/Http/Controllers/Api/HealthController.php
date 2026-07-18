<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Queue;

class HealthController extends Controller
{
    /**
     * GET /api/v1/health
     * Returns DB status, Redis status, queue status.
     */
    public function index(): JsonResponse
    {
        $checks = [
            'database' => $this->checkDatabase(),
            'redis' => $this->checkRedis(),
            'queue' => $this->checkQueue(),
        ];

        $healthy = ! in_array(false, $checks, true);

        // Keep the liveness endpoint reachable even when an optional dependency
        // such as Redis is unavailable; callers can inspect the service status.
        return response()->json([
            'success' => $healthy,
            'status' => $healthy ? 'healthy' : 'degraded',
            'timestamp' => now()->toIso8601String(),
            'environment' => app()->environment(),
            'services' => $checks,
            'version' => config('app.version', '1.0.0'),
            'timezone' => config('app.timezone'),
        ], 200);
    }

    protected function checkDatabase(): bool
    {
        try {
            DB::connection()->getPdo();
            DB::select('SELECT 1');
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    protected function checkRedis(): bool
    {
        try {
            Redis::connection()->ping();
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    protected function checkQueue(): bool
    {
        try {
            // If using sync driver, queue is always "ok" (synchronous)
            if (config('queue.default') === 'sync') {
                return true;
            }
            return Queue::size() >= 0;
        } catch (\Throwable $e) {
            return false;
        }
    }
}

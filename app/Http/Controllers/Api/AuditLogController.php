<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    /**
     * GET /api/v1/audit-logs
     * Returns paginated audit log entries with filters.
     *
     * Query params:
     *   - search: search by user_name, action, entity
     *   - user_id: filter by user
     *   - action: filter by action (Login, Create, Update, Delete, etc.)
     *   - entity: filter by entity type
     *   - from: date range start (Y-m-d)
     *   - to: date range end (Y-m-d)
     *   - ip_address: filter by IP
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', AuditLog::class);

        $query = AuditLog::query()->with(['user']);

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('user_name', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%")
                  ->orWhere('entity', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        // Filters
        if ($userId = $request->input('user_id')) {
            $query->where('user_id', $userId);
        }
        if ($action = $request->input('action')) {
            $query->where('action', $action);
        }
        if ($entity = $request->input('entity')) {
            $query->where('entity', 'like', "%{$entity}%");
        }
        if ($ip = $request->input('ip_address')) {
            $query->where('ip_address', $ip);
        }
        if ($from = $request->input('from')) {
            $query->whereDate('timestamp', '>=', $from);
        }
        if ($to = $request->input('to')) {
            $query->whereDate('timestamp', '<=', $to);
        }

        $perPage = min((int) $request->input('per_page', 25), 100);
        $items = $query->latest('timestamp')->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Audit logs retrieved.',
            'data' => $items->items(),
            'meta' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem(),
            ],
        ]);
    }

    /**
     * GET /api/v1/audit-logs/export
     * Export audit logs as CSV.
     */
    public function export(Request $request): JsonResponse
    {
        $this->authorize('viewAny', AuditLog::class);

        $query = AuditLog::query();
        if ($from = $request->input('from')) $query->whereDate('timestamp', '>=', $from);
        if ($to = $request->input('to')) $query->whereDate('timestamp', '<=', $to);

        $logs = $query->latest('timestamp')->limit(10000)->get();

        return response()->json([
            'success' => true,
            'data' => $logs,
            'meta' => ['total' => $logs->count()],
        ]);
    }

    /**
     * GET /api/v1/audit-logs/stats
     * Returns summary statistics for the audit dashboard.
     */
    public function stats(Request $request): JsonResponse
    {
        $this->authorize('viewAny', AuditLog::class);

        $stats = [
            'total' => AuditLog::count(),
            'today' => AuditLog::whereDate('timestamp', today())->count(),
            'this_week' => AuditLog::where('timestamp', '>=', now()->startOfWeek())->count(),
            'this_month' => AuditLog::whereMonth('timestamp', now()->month)->count(),
            'by_action' => AuditLog::selectRaw('action, COUNT(*) as count')
                ->groupBy('action')
                ->pluck('count', 'action')
                ->toArray(),
            'by_entity' => AuditLog::selectRaw('entity, COUNT(*) as count')
                ->groupBy('entity')
                ->orderByDesc('count')
                ->limit(10)
                ->pluck('count', 'entity')
                ->toArray(),
            'recent_users' => AuditLog::selectRaw('user_name, COUNT(*) as count, MAX(timestamp) as last_activity')
                ->whereNotNull('user_name')
                ->groupBy('user_name')
                ->orderByDesc('last_activity')
                ->limit(10)
                ->get(),
        ];

        return response()->json(['success' => true, 'data' => $stats]);
    }
}

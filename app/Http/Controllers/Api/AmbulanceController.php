<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ambulance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AmbulanceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Ambulance::class);

        $query = Ambulance::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('reg_no', 'like', "%{$search}%")->orWhere('model', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['driver', 'calls' => fn($q) => $q->latest()->limit(5), 'gpsPositions' => fn($q) => $q->latest()->limit(1)]);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Ambulance list retrieved.',
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

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', Ambulance::class);
        $data = $request->validate(['reg_no' => 'required|string|max:20|unique:ambulances,reg_no', 'model' => 'required|string|max:100', 'year' => 'required|integer|min:1990|max:2030', 'type' => 'required|in:Basic Life Support,Advanced Life Support,Patient Transport', 'driver_id' => 'nullable|exists:staff,id', 'location' => 'nullable|string|max:100']);

        if (empty($data['code'])) { $data['code'] = 'AMB-' . str_pad((string) (Ambulance::max('id') + 1), 3, '0', STR_PAD_LEFT); }

        $item = Ambulance::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Ambulance created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, Ambulance $ambulance): JsonResponse
    {
        $this->authorize('view', $ambulance);
        $ambulance->load(['driver', 'calls' => fn($q) => $q->latest()->limit(10), 'gpsPositions' => fn($q) => $q->latest()->limit(20)]);
        return response()->json([
            'success' => true,
            'data' => $ambulance,
        ]);
    }

    public function update(Request $request, Ambulance $ambulance): JsonResponse
    {
        $this->authorize('update', $ambulance);
        $data = $request->validate(['status' => 'sometimes|in:Available,On Call,Maintenance,Out of Service', 'location' => 'sometimes|string|max:100', 'driver_id' => 'nullable|exists:staff,id']);
        $ambulance->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Ambulance updated.',
            'data' => $ambulance->fresh(),
        ]);
    }

    public function destroy(Request $request, Ambulance $ambulance): JsonResponse
    {
        $this->authorize('delete', $ambulance);
        $ambulance->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ambulance deleted.',
        ]);
    }

    public function track(Ambulance $ambulance): JsonResponse
    {
        $this->authorize('view', $ambulance);
        $latestPosition = $ambulance->gpsPositions()->latest('recorded_at')->first();
        return response()->json(['success' => true, 'data' => ['ambulance' => $ambulance, 'position' => $latestPosition]]);
    }
}

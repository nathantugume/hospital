<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AmbulanceCall;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AmbulanceCallController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', AmbulanceCall::class);

        $query = AmbulanceCall::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")->orWhere('caller_name', 'like', "%{$search}%")->orWhere('patient_name', 'like', "%{$search}%")->orWhere('pickup_location', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['ambulance', 'driver', 'dispatcher', 'gpsPositions' => fn($q) => $q->latest()->limit(20)]);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Ambulance call list retrieved.',
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
        $this->authorize('create', AmbulanceCall::class);
        $data = $request->validate(['ambulance_id' => 'nullable|exists:ambulances,id', 'caller_name' => 'required|string|max:255', 'patient_name' => 'nullable|string|max:255', 'pickup_location' => 'required|string', 'destination' => 'nullable|string', 'priority' => 'nullable|in:Emergency,Urgent,Routine', 'severity' => 'nullable|in:Red,Orange,Yellow,Green', 'pickup_lat' => 'nullable|numeric', 'pickup_lng' => 'nullable|numeric']);

        if (empty($data['code'])) { $data['code'] = 'CALL-' . str_pad((string) (AmbulanceCall::max('id') + 1), 4, '0', STR_PAD_LEFT); } $data['dispatcher_id'] = $request->user()->staff_id;

        $item = AmbulanceCall::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Ambulance call created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, AmbulanceCall $call): JsonResponse
    {
        $this->authorize('view', $call);
        $call->load(['ambulance', 'driver', 'dispatcher', 'gpsPositions' => fn($q) => $q->latest()->limit(50)]);
        return response()->json([
            'success' => true,
            'data' => $call,
        ]);
    }

    public function update(Request $request, AmbulanceCall $call): JsonResponse
    {
        $this->authorize('update', $call);
        $data = $request->validate(['status' => 'sometimes|in:Dispatched,En Route,On Scene,Transporting,Completed,Cancelled', 'arrival_time' => 'nullable|date']);
        $call->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Ambulance call updated.',
            'data' => $call->fresh(),
        ]);
    }

    public function destroy(Request $request, AmbulanceCall $call): JsonResponse
    {
        $this->authorize('delete', $call);
        $call->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ambulance call deleted.',
        ]);
    }

    public function dispatch(Request $request, AmbulanceCall $call): JsonResponse
    {
        $this->authorize('update', $call);
        $request->validate(['ambulance_id' => 'required|exists:ambulances,id']);
        $call->update(['status' => 'Dispatched', 'dispatch_time' => now(), 'ambulance_id' => $request->ambulance_id]);
        event(new \App\Events\AmbulanceDispatched($call));
        return response()->json(['success' => true, 'message' => 'Ambulance dispatched.', 'data' => $call]);
    }

    public function arrive(Request $request, AmbulanceCall $call): JsonResponse
    {
        $this->authorize('update', $call);
        $call->update(['status' => 'On Scene', 'arrival_time' => now()]);
        return response()->json(['success' => true, 'message' => 'Arrived on scene.', 'data' => $call]);
    }

    public function complete(Request $request, AmbulanceCall $call): JsonResponse
    {
        $this->authorize('update', $call);
        $call->update(['status' => 'Completed']);
        return response()->json(['success' => true, 'message' => 'Call completed.', 'data' => $call]);
    }
}

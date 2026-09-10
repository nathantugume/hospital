<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RoomAllotment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomAllotmentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', RoomAllotment::class);

        $query = RoomAllotment::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")->orWhereHas('patient', fn($pq) => $pq->where('first_name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['patient', 'room', 'department', 'doctor']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Room allotment list retrieved.',
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
        $this->authorize('create', RoomAllotment::class);
        $data = $request->validate(['patient_id' => 'required|exists:patients,id', 'room_id' => 'required|exists:rooms,id', 'allotment_date' => 'required|date', 'doctor_id' => 'nullable|exists:staff,id', 'daily_rate' => 'nullable|numeric|min:0']);

        if (empty($data['code'])) { $data['code'] = 'RA-' . str_pad((string) (RoomAllotment::max('id') + 1), 3, '0', STR_PAD_LEFT); }

        $item = RoomAllotment::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Room allotment created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, RoomAllotment $roomAllotment): JsonResponse
    {
        $this->authorize('view', $roomAllotment);
        $roomAllotment->load(['patient', 'room', 'department', 'doctor']);
        return response()->json([
            'success' => true,
            'data' => $roomAllotment,
        ]);
    }

    public function update(Request $request, RoomAllotment $roomAllotment): JsonResponse
    {
        $this->authorize('update', $roomAllotment);
        $data = $request->validate(['status' => 'sometimes|in:Occupied,Discharged,Reserved', 'discharge_date' => 'nullable|date|after:allotment_date']);
        $roomAllotment->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Room allotment updated.',
            'data' => $roomAllotment->fresh(),
        ]);
    }

    public function destroy(Request $request, RoomAllotment $roomAllotment): JsonResponse
    {
        $this->authorize('delete', $roomAllotment);
        $roomAllotment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Room allotment deleted.',
        ]);
    }

    
}

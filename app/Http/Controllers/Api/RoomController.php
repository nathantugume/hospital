<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Room::class);

        $query = Room::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")->orWhere('type', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['department', 'ward', 'patient', 'doctor', 'allotments' => fn($q) => $q->latest()->limit(5)]);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Room list retrieved.',
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
        $this->authorize('create', Room::class);
        $data = $request->validate(['number' => 'required|string|max:20|unique:rooms,number', 'type' => 'nullable|in:Private,Semi-Private,General,ICU,Operating,Consultation,Therapy,Recovery', 'status' => 'nullable|in:Available,Occupied,Maintenance,Reserved', 'department_id' => 'nullable|exists:departments,id', 'ward_id' => 'nullable|exists:wards,id', 'capacity' => 'nullable|integer|min:1']);

        

        $item = Room::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Room created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, Room $room): JsonResponse
    {
        $this->authorize('view', $room);
        $room->load(['department', 'ward', 'patient', 'doctor', 'allotments' => fn($q) => $q->latest()->limit(10)]);
        return response()->json([
            'success' => true,
            'data' => $room,
        ]);
    }

    public function update(Request $request, Room $room): JsonResponse
    {
        $this->authorize('update', $room);
        $data = $request->validate(['status' => 'sometimes|in:Available,Occupied,Maintenance,Reserved', 'patient_id' => 'nullable|exists:patients,id', 'doctor_id' => 'nullable|exists:staff,id']);
        $room->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Room updated.',
            'data' => $room->fresh(),
        ]);
    }

    public function destroy(Request $request, Room $room): JsonResponse
    {
        $this->authorize('delete', $room);
        $room->delete();

        return response()->json([
            'success' => true,
            'message' => 'Room deleted.',
        ]);
    }

    
}

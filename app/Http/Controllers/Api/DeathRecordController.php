<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeathRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DeathRecordController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', DeathRecord::class);

        $query = DeathRecord::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")->orWhere('name', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['patient', 'doctor']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Death record list retrieved.',
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
        $this->authorize('create', DeathRecord::class);
        $data = $request->validate(['name' => 'required|string|max:255', 'age' => 'required|integer|min:0|max:150', 'date_of_death' => 'required|date', 'cause' => 'required|string|max:255', 'doctor_id' => 'nullable|exists:staff,id', 'location' => 'nullable|string|max:100']);

        if (empty($data['code'])) { $data['code'] = 'DR-' . date('Y') . '-' . str_pad((string) (DeathRecord::max('id') + 1), 3, '0', STR_PAD_LEFT); }

        $item = DeathRecord::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Death record created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, DeathRecord $deathRecord): JsonResponse
    {
        $this->authorize('view', $deathRecord);
        $deathRecord->load(['patient', 'doctor']);
        return response()->json([
            'success' => true,
            'data' => $deathRecord,
        ]);
    }

    public function update(Request $request, DeathRecord $deathRecord): JsonResponse
    {
        $this->authorize('update', $deathRecord);
        $data = $request->validate(['status' => 'sometimes|in:Verified,Pending']);
        $deathRecord->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Death record updated.',
            'data' => $deathRecord->fresh(),
        ]);
    }

    public function destroy(Request $request, DeathRecord $deathRecord): JsonResponse
    {
        $this->authorize('delete', $deathRecord);
        $deathRecord->delete();

        return response()->json([
            'success' => true,
            'message' => 'Death record deleted.',
        ]);
    }

    public function certificate(DeathRecord $deathRecord): JsonResponse
    {
        $this->authorize('view', $deathRecord);
        return response()->json(['success' => true, 'data' => ['certificate_no' => 'DC-UG-' . date('Y') . '-' . str_pad((string) $deathRecord->id, 5, '0', STR_PAD_LEFT), 'record' => $deathRecord]]);
    }
}

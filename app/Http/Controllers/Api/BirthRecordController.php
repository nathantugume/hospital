<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BirthRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BirthRecordController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', BirthRecord::class);

        $query = BirthRecord::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")->orWhere('child_name', 'like', "%{$search}%")->orWhere('mother_name', 'like', "%{$search}%");
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
            'message' => 'Birth record list retrieved.',
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
        $this->authorize('create', BirthRecord::class);
        $data = $request->validate(['child_name' => 'required|string|max:255', 'date_of_birth' => 'required|date', 'gender' => 'nullable|in:Male,Female,Other', 'weight' => 'nullable|numeric|min:0|max:10', 'mother_name' => 'nullable|string|max:255', 'father_name' => 'nullable|string|max:255', 'doctor_id' => 'nullable|exists:staff,id', 'place_of_birth' => 'nullable|string|max:255', 'location' => 'nullable|string|max:100']);

        if (empty($data['code'])) { $data['code'] = 'BR-' . date('Y') . '-' . str_pad((string) (BirthRecord::max('id') + 1), 3, '0', STR_PAD_LEFT); }

        $item = BirthRecord::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Birth record created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, BirthRecord $birthRecord): JsonResponse
    {
        $this->authorize('view', $birthRecord);
        $birthRecord->load(['patient', 'doctor']);
        return response()->json([
            'success' => true,
            'data' => $birthRecord,
        ]);
    }

    public function update(Request $request, BirthRecord $birthRecord): JsonResponse
    {
        $this->authorize('update', $birthRecord);
        $data = $request->validate(['status' => 'sometimes|in:Verified,Pending']);
        $birthRecord->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Birth record updated.',
            'data' => $birthRecord->fresh(),
        ]);
    }

    public function destroy(Request $request, BirthRecord $birthRecord): JsonResponse
    {
        $this->authorize('delete', $birthRecord);
        $birthRecord->delete();

        return response()->json([
            'success' => true,
            'message' => 'Birth record deleted.',
        ]);
    }

    public function certificate(BirthRecord $birthRecord): JsonResponse
    {
        $this->authorize('view', $birthRecord);
        return response()->json(['success' => true, 'data' => ['certificate_no' => 'BC-UG-' . date('Y') . '-' . str_pad((string) $birthRecord->id, 5, '0', STR_PAD_LEFT), 'record' => $birthRecord]]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BloodUnit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BloodUnitController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', BloodUnit::class);

        $query = BloodUnit::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")->orWhere('blood_type', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['donor']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Blood unit list retrieved.',
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
        $this->authorize('create', BloodUnit::class);
        $data = $request->validate(['blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-', 'units' => 'required|integer|min:1', 'collection_date' => 'required|date', 'expiry_date' => 'required|date|after:collection_date', 'location' => 'nullable|string|max:100', 'donor_id' => 'nullable|exists:blood_donors,id']);

        if (empty($data['code'])) { $data['code'] = 'BS-' . str_pad((string) (BloodUnit::max('id') + 1), 3, '0', STR_PAD_LEFT); }

        $item = BloodUnit::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Blood unit created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, BloodUnit $bloodUnit): JsonResponse
    {
        $this->authorize('view', $bloodUnit);
        $bloodUnit->load(['donor']);
        return response()->json([
            'success' => true,
            'data' => $bloodUnit,
        ]);
    }

    public function update(Request $request, BloodUnit $bloodUnit): JsonResponse
    {
        $this->authorize('update', $bloodUnit);
        $data = $request->validate(['status' => 'sometimes|in:Available,Reserved,Expiring Soon,Discarded,Used', 'location' => 'sometimes|string|max:100']);
        $bloodUnit->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Blood unit updated.',
            'data' => $bloodUnit->fresh(),
        ]);
    }

    public function destroy(Request $request, BloodUnit $bloodUnit): JsonResponse
    {
        $this->authorize('delete', $bloodUnit);
        $bloodUnit->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blood unit deleted.',
        ]);
    }

    
}

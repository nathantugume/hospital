<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BloodDonor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BloodDonorController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', BloodDonor::class);

        $query = BloodDonor::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%")->orWhere('blood_type', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['donations', 'bloodUnits']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Blood donor list retrieved.',
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
        $this->authorize('create', BloodDonor::class);
        $data = $request->validate(['name' => 'required|string|max:255', 'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-', 'phone' => 'required|string|max:30', 'email' => 'nullable|email']);

        if (empty($data['code'])) { $data['code'] = 'D-' . str_pad((string) (BloodDonor::max('id') + 1), 4, '0', STR_PAD_LEFT); }

        $item = BloodDonor::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Blood donor created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, BloodDonor $donor): JsonResponse
    {
        $this->authorize('view', $donor);
        $donor->load(['donations', 'bloodUnits']);
        return response()->json([
            'success' => true,
            'data' => $donor,
        ]);
    }

    public function update(Request $request, BloodDonor $donor): JsonResponse
    {
        $this->authorize('update', $donor);
        $data = $request->validate(['status' => 'sometimes|in:Eligible,Ineligible,New Donor', 'donor_tier' => 'sometimes|in:New,Regular,Silver Donor,Gold Donor,Platinum Donor']);
        $donor->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Blood donor updated.',
            'data' => $donor->fresh(),
        ]);
    }

    public function destroy(Request $request, BloodDonor $donor): JsonResponse
    {
        $this->authorize('delete', $donor);
        $donor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blood donor deleted.',
        ]);
    }

    
}

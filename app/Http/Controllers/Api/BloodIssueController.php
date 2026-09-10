<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BloodIssue;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BloodIssueController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', BloodIssue::class);

        $query = BloodIssue::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")->orWhere('recipient', 'like', "%{$search}%")->orWhere('blood_type', 'like', "%{$search}%");
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
            'message' => 'Blood issue list retrieved.',
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
        $this->authorize('create', BloodIssue::class);
        $data = $request->validate(['patient_id' => 'nullable|exists:patients,id', 'recipient' => 'required|string|max:255', 'recipient_type' => 'nullable|in:patient,external', 'blood_type' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-', 'units' => 'required|integer|min:1', 'date' => 'required|date', 'doctor_id' => 'nullable|exists:staff,id', 'purpose' => 'nullable|string|max:255', 'emergency' => 'boolean', 'department' => 'nullable|string|max:100']);

        if (empty($data['code'])) { $data['code'] = 'ISS-' . str_pad((string) (BloodIssue::max('id') + 1), 3, '0', STR_PAD_LEFT); }

        $item = BloodIssue::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Blood issue created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, BloodIssue $bloodIssue): JsonResponse
    {
        $this->authorize('view', $bloodIssue);
        $bloodIssue->load(['patient', 'doctor']);
        return response()->json([
            'success' => true,
            'data' => $bloodIssue,
        ]);
    }

    public function update(Request $request, BloodIssue $bloodIssue): JsonResponse
    {
        $this->authorize('update', $bloodIssue);
        $data = $request->validate(['status' => 'sometimes|in:Pending,Delivered,In Transit']);
        $bloodIssue->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Blood issue updated.',
            'data' => $bloodIssue->fresh(),
        ]);
    }

    public function destroy(Request $request, BloodIssue $bloodIssue): JsonResponse
    {
        $this->authorize('delete', $bloodIssue);
        $bloodIssue->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blood issue deleted.',
        ]);
    }

    
}

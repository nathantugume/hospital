<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Prescription::class);

        $query = Prescription::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', fn($pq) => $pq->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['patient', 'doctor', 'items.medicine']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Prescription list retrieved.',
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
        $this->authorize('create', Prescription::class);
        $data = $request->validate(['patient_id' => 'required|exists:patients,id', 'doctor_id' => 'nullable|exists:staff,id', 'date' => 'required|date', 'medications' => 'nullable|string', 'refills' => 'nullable|integer|min:0']);

        if (empty($data['code'])) { $data['code'] = 'RX-' . str_pad((string) (Prescription::max('id') + 1), 5, '0', STR_PAD_LEFT); }

        $item = Prescription::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Prescription created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, Prescription $prescription): JsonResponse
    {
        $this->authorize('view', $prescription);
        $prescription->load(['patient', 'doctor', 'items.medicine']);
        return response()->json([
            'success' => true,
            'data' => $prescription,
        ]);
    }

    public function update(Request $request, Prescription $prescription): JsonResponse
    {
        $this->authorize('update', $prescription);
        $data = $request->validate(['status' => 'sometimes|in:Active,Expired,Completed,Cancelled', 'refills' => 'sometimes|integer|min:0']);
        $prescription->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Prescription updated.',
            'data' => $prescription->fresh(),
        ]);
    }

    public function destroy(Request $request, Prescription $prescription): JsonResponse
    {
        $this->authorize('delete', $prescription);
        $prescription->delete();

        return response()->json([
            'success' => true,
            'message' => 'Prescription deleted.',
        ]);
    }

    public function dispense(Request $request, Prescription $prescription): JsonResponse
    {
        $this->authorize('update', $prescription);
        $prescription->update(['status' => 'Dispensed']);
        return response()->json(['success' => true, 'message' => 'Prescription dispensed.', 'data' => $prescription]);
    }

    public function renew(Request $request, Prescription $prescription): JsonResponse
    {
        $this->authorize('update', $prescription);
        $newRx = $prescription->replicate();
        $newRx->status = 'Active';
        $newRx->date = now()->toDateString();
        $newRx->refills = $prescription->refills > 0 ? $prescription->refills - 1 : 0;
        $newRx->save();
        return response()->json(['success' => true, 'message' => 'Prescription renewed.', 'data' => $newRx], 201);
    }
}

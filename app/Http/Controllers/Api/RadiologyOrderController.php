<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RadiologyOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RadiologyOrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', RadiologyOrder::class);

        $query = RadiologyOrder::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")->orWhereHas('patient', fn($pq) => $pq->where('first_name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['patient', 'referringDoctor', 'radiologist']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Radiology order list retrieved.',
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
        $this->authorize('create', RadiologyOrder::class);
        $data = $request->validate(['patient_id' => 'required|exists:patients,id', 'modality' => 'required|in:CT,MRI,X-Ray,Ultrasound,Mammography,Fluoroscopy,DEXA', 'body_part' => 'required|string|max:255', 'priority' => 'nullable|in:Routine,Urgent,STAT', 'referring_doctor_id' => 'nullable|exists:staff,id']);

        if (empty($data['code'])) { $data['code'] = 'ORD-' . str_pad((string) (RadiologyOrder::max('id') + 1), 3, '0', STR_PAD_LEFT); }

        $item = RadiologyOrder::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Radiology order created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, RadiologyOrder $radiologyOrder): JsonResponse
    {
        $this->authorize('view', $radiologyOrder);
        $radiologyOrder->load(['patient', 'referringDoctor', 'radiologist']);
        return response()->json([
            'success' => true,
            'data' => $radiologyOrder,
        ]);
    }

    public function update(Request $request, RadiologyOrder $radiologyOrder): JsonResponse
    {
        $this->authorize('update', $radiologyOrder);
        $data = $request->validate(['status' => 'sometimes|in:Pending,In Progress,Completed,Cancelled', 'report_status' => 'sometimes|in:Draft,Final,Pending', 'radiologist_id' => 'nullable|exists:staff,id', 'report_findings' => 'nullable|string', 'scheduled_date' => 'nullable|date', 'completed_date' => 'nullable|date']);
        $radiologyOrder->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Radiology order updated.',
            'data' => $radiologyOrder->fresh(),
        ]);
    }

    public function destroy(Request $request, RadiologyOrder $radiologyOrder): JsonResponse
    {
        $this->authorize('delete', $radiologyOrder);
        $radiologyOrder->delete();

        return response()->json([
            'success' => true,
            'message' => 'Radiology order deleted.',
        ]);
    }

    
}

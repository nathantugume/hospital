<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LabEquipment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LabEquipmentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', LabEquipment::class);

        $query = LabEquipment::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")->orWhere('name', 'like', "%{$search}%")->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($department = $request->input('department')) { $query->where('department', $department); }

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Lab equipment list retrieved.',
            'data' => $items->items(),
            'meta' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem(),
            ],
            'links' => [
                'first' => $items->url(1),
                'last' => $items->url($items->lastPage()),
                'prev' => $items->previousPageUrl(),
                'next' => $items->nextPageUrl(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', LabEquipment::class);
        $data = $request->validate(['name' => 'required|string|max:255', 'department' => 'nullable|string', 'serial_number' => 'nullable|string|max:100', 'status' => 'nullable|in:Operational,Maintenance,Repair,Decommissioned']);
        if (empty($data['code'])) { $data['code'] = 'EQP-' . str_pad((string) (LabEquipment::max('id') + 1), 3, '0', STR_PAD_LEFT); }
        $item = LabEquipment::create($data);
        return $this->success($item, 'Lab equipment created.', 201);
    }

    public function show(Request $request, LabEquipment $labEquipment): JsonResponse
    {
        $this->authorize('view', $labEquipment);
        return $this->success($labEquipment);
    }

    public function update(Request $request, LabEquipment $labEquipment): JsonResponse
    {
        $this->authorize('update', $labEquipment);
        $data = $request->validate(['status' => 'sometimes|in:Operational,Maintenance,Repair,Decommissioned', 'location' => 'sometimes|string']);
        $labEquipment->update($data);
        return $this->success($labEquipment, 'Lab equipment updated.');
    }

    public function destroy(Request $request, LabEquipment $labEquipment): JsonResponse
    {
        $this->authorize('delete', $labEquipment);
        $labEquipment->delete();
        return response()->json(['success' => true, 'message' => 'Lab equipment deleted.']);
    }
}

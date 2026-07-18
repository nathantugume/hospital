<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InventoryTransfer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InventoryTransferController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', InventoryTransfer::class);

        $query = InventoryTransfer::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")->orWhere('from_location', 'like', "%{$search}%")->orWhere('to_location', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['requestedBy', 'approvedBy', 'dispatchedBy', 'receivedBy', 'transferItems', 'dispatches']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Transfer list retrieved.',
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
        $this->authorize('create', InventoryTransfer::class);
        $data = $request->validate(['from_location' => 'required|string|max:100', 'to_location' => 'required|string|max:100', 'qty' => 'required|integer|min:1', 'date' => 'required|date', 'items' => 'nullable|string']);

        if (empty($data['code'])) { $data['code'] = 'TRF-' . str_pad((string) (InventoryTransfer::max('id') + 1), 3, '0', STR_PAD_LEFT); } $data['requested_by'] = $request->user()->staff_id;

        $item = InventoryTransfer::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Transfer created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, InventoryTransfer $transfer): JsonResponse
    {
        $this->authorize('view', $transfer);
        $transfer->load(['requestedBy', 'approvedBy', 'dispatchedBy', 'receivedBy', 'transferItems', 'dispatches']);
        return response()->json([
            'success' => true,
            'data' => $transfer,
        ]);
    }

    public function update(Request $request, InventoryTransfer $transfer): JsonResponse
    {
        $this->authorize('update', $transfer);
        $data = $request->validate(['status' => 'sometimes|in:Draft,Pending,Approved,Rejected,Dispatched,Cancelled,Completed', 'rejection_reason' => 'nullable|string']);
        $transfer->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Transfer updated.',
            'data' => $transfer->fresh(),
        ]);
    }

    public function destroy(Request $request, InventoryTransfer $transfer): JsonResponse
    {
        $this->authorize('delete', $transfer);
        $transfer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transfer deleted.',
        ]);
    }

    public function approve(Request $request, InventoryTransfer $transfer): JsonResponse
    {
        $this->authorize('update', $transfer);
        $transfer->update(['status' => 'Approved', 'approved_by' => $request->user()->staff_id]);
        return response()->json(['success' => true, 'message' => 'Transfer approved.', 'data' => $transfer]);
    }

    public function dispatch(Request $request, InventoryTransfer $transfer): JsonResponse
    {
        $this->authorize('update', $transfer);
        $transfer->update(['status' => 'Dispatched', 'dispatched_by' => $request->user()->staff_id]);
        return response()->json(['success' => true, 'message' => 'Transfer dispatched.', 'data' => $transfer]);
    }

    public function receive(Request $request, InventoryTransfer $transfer): JsonResponse
    {
        $this->authorize('update', $transfer);
        $transfer->update(['status' => 'Completed', 'received_by' => $request->user()->staff_id]);
        return response()->json(['success' => true, 'message' => 'Transfer received.', 'data' => $transfer]);
    }
}

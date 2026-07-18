<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', PurchaseOrder::class);

        $query = PurchaseOrder::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")->orWhere('item', 'like', "%{$search}%")->orWhereHas('supplier', fn($sq) => $sq->where('name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['supplier', 'trackingEvents']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Purchase order list retrieved.',
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
        $this->authorize('create', PurchaseOrder::class);
        $data = $request->validate(['supplier_id' => 'required|exists:suppliers,id', 'item' => 'required|string|max:255', 'quantity' => 'required|integer|min:1', 'unit_price' => 'required|numeric|min:0', 'order_date' => 'required|date', 'priority' => 'nullable|in:Normal,High,Urgent']);

        $data['amount'] = $data['quantity'] * $data['unit_price']; if (empty($data['code'])) { $data['code'] = 'PO-' . str_pad((string) (PurchaseOrder::max('id') + 1), 4, '0', STR_PAD_LEFT); }

        $item = PurchaseOrder::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Purchase order created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, PurchaseOrder $purchaseOrder): JsonResponse
    {
        $this->authorize('view', $purchaseOrder);
        $purchaseOrder->load(['supplier', 'trackingEvents']);
        return response()->json([
            'success' => true,
            'data' => $purchaseOrder,
        ]);
    }

    public function update(Request $request, PurchaseOrder $purchaseOrder): JsonResponse
    {
        $this->authorize('update', $purchaseOrder);
        $data = $request->validate(['status' => 'sometimes|in:Pending,Processing,Shipped,Delivered,Cancelled', 'delivery_date' => 'nullable|date', 'tracking_number' => 'nullable|string|max:100', 'carrier' => 'nullable|string|max:100']);
        $purchaseOrder->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Purchase order updated.',
            'data' => $purchaseOrder->fresh(),
        ]);
    }

    public function destroy(Request $request, PurchaseOrder $purchaseOrder): JsonResponse
    {
        $this->authorize('delete', $purchaseOrder);
        $purchaseOrder->delete();

        return response()->json([
            'success' => true,
            'message' => 'Purchase order deleted.',
        ]);
    }

    
}

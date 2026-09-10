<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InventoryItemController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', InventoryItem::class);

        $query = InventoryItem::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%")->orWhere('category', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['supplier']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Inventory item list retrieved.',
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
        $this->authorize('create', InventoryItem::class);
        $data = $request->validate(['name' => 'required|string|max:255', 'category' => 'nullable|string|max:100', 'stock_current' => 'required|integer|min:0', 'min_level' => 'nullable|integer|min:0', 'unit' => 'nullable|string|max:20', 'supplier_id' => 'nullable|exists:suppliers,id']);

        if (empty($data['code'])) { $data['code'] = 'INV' . str_pad((string) (InventoryItem::max('id') + 1), 3, '0', STR_PAD_LEFT); }

        $item = InventoryItem::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Inventory item created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, InventoryItem $inventoryItem): JsonResponse
    {
        $this->authorize('view', $inventoryItem);
        $inventoryItem->load(['supplier']);
        return response()->json([
            'success' => true,
            'data' => $inventoryItem,
        ]);
    }

    public function update(Request $request, InventoryItem $inventoryItem): JsonResponse
    {
        $this->authorize('update', $inventoryItem);
        $data = $request->validate(['name' => 'sometimes|string|max:255', 'stock_current' => 'sometimes|integer|min:0', 'status' => 'sometimes|in:In Stock,Low Stock,Out of Stock']);
        $inventoryItem->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Inventory item updated.',
            'data' => $inventoryItem->fresh(),
        ]);
    }

    public function destroy(Request $request, InventoryItem $inventoryItem): JsonResponse
    {
        $this->authorize('delete', $inventoryItem);
        $inventoryItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Inventory item deleted.',
        ]);
    }

    public function stockAlerts(Request $request): JsonResponse
    {
        $this->authorize('viewAny', InventoryItem::class);
        $items = InventoryItem::whereColumn('stock_current', '<=', 'min_level')
            ->orWhere('status', 'Out of Stock')
            ->with('supplier')
            ->get();
        return response()->json(['success' => true, 'data' => $items, 'meta' => ['total' => $items->count()]]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Supplier::class);

        $query = Supplier::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->withCount(['products', 'purchaseOrders']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Supplier list retrieved.',
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
        $this->authorize('create', Supplier::class);
        $data = $request->validate(['name' => 'required|string|max:255', 'category' => 'nullable|string|max:100', 'email' => 'nullable|email', 'phone' => 'nullable|string|max:30', 'address' => 'nullable|string', 'location' => 'nullable|string|max:100', 'rating' => 'nullable|integer|min:1|max:5', 'preferred' => 'boolean']);

        if (empty($data['code'])) { $data['code'] = 'SUP' . str_pad((string) (Supplier::max('id') + 1), 3, '0', STR_PAD_LEFT); }

        $item = Supplier::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Supplier created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, Supplier $supplier): JsonResponse
    {
        $this->authorize('view', $supplier);
        $supplier->load(['products', 'purchaseOrders' => fn($q) => $q->latest()->limit(10)]);
        return response()->json([
            'success' => true,
            'data' => $supplier,
        ]);
    }

    public function update(Request $request, Supplier $supplier): JsonResponse
    {
        $this->authorize('update', $supplier);
        $data = $request->validate(['name' => 'sometimes|string|max:255', 'status' => 'sometimes|in:Active,Inactive', 'rating' => 'sometimes|integer|min:1|max:5']);
        $supplier->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Supplier updated.',
            'data' => $supplier->fresh(),
        ]);
    }

    public function destroy(Request $request, Supplier $supplier): JsonResponse
    {
        $this->authorize('delete', $supplier);
        $supplier->delete();

        return response()->json([
            'success' => true,
            'message' => 'Supplier deleted.',
        ]);
    }

    
}

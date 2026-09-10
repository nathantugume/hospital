<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Medicine::class);

        $query = Medicine::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('generic_name', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['batches', 'transactions' => fn($q) => $q->latest()->limit(10)]);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Medicine list retrieved.',
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
        $this->authorize('create', Medicine::class);
        $data = $request->validate(['name' => 'required|string|max:255', 'generic_name' => 'nullable|string|max:255', 'category' => 'nullable|string|max:100', 'type' => 'required|in:prescription,otc,controlled', 'manufacturer' => 'nullable|string|max:255', 'selling_price' => 'required|numeric|min:0', 'stock' => 'required|integer|min:0', 'reorder_level' => 'nullable|integer|min:0', 'expiry' => 'nullable|date']);

        if (empty($data['code'])) { $data['code'] = 'MED' . str_pad((string) (Medicine::max('id') + 1), 3, '0', STR_PAD_LEFT); }

        $item = Medicine::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Medicine created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, Medicine $medicine): JsonResponse
    {
        $this->authorize('view', $medicine);
        $medicine->load(['batches', 'transactions' => fn($q) => $q->latest()->limit(20)]);
        return response()->json([
            'success' => true,
            'data' => $medicine,
        ]);
    }

    public function update(Request $request, Medicine $medicine): JsonResponse
    {
        $this->authorize('update', $medicine);
        $data = $request->validate(['name' => 'sometimes|string|max:255', 'selling_price' => 'sometimes|numeric|min:0', 'stock' => 'sometimes|integer|min:0', 'status' => 'sometimes|in:In Stock,Low Stock,Out of Stock']);
        $medicine->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Medicine updated.',
            'data' => $medicine->fresh(),
        ]);
    }

    public function destroy(Request $request, Medicine $medicine): JsonResponse
    {
        $this->authorize('delete', $medicine);
        $medicine->delete();

        return response()->json([
            'success' => true,
            'message' => 'Medicine deleted.',
        ]);
    }

    public function transactions(Medicine $medicine): JsonResponse
    {
        $this->authorize('view', $medicine);
        $transactions = $medicine->transactions()->with(['patient', 'supplier', 'user'])->latest()->paginate(15);
        return response()->json(['success' => true, 'data' => $transactions]);
    }

    public function batches(Medicine $medicine): JsonResponse
    {
        $this->authorize('view', $medicine);
        $batches = $medicine->batches()->latest('expiry_date')->get();
        return response()->json(['success' => true, 'data' => $batches]);
    }
}

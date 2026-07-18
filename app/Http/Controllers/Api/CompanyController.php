<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Company::class);

        $query = Company::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->withCount(['users', 'patients', 'staff', 'subscriptions']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Company list retrieved.',
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
        $this->authorize('create', Company::class);
        $data = $request->validate(['name' => 'required|string|max:255', 'email' => 'required|email|unique:companies,email', 'phone' => 'required|string|max:30', 'plan' => 'nullable|in:Essential Care,Professional Growth,Enterprise Suite', 'country' => 'nullable|string|max:50', 'city' => 'nullable|string|max:100']);

        if (empty($data['code'])) { $data['code'] = 'COM-' . str_pad((string) (Company::max('id') + 1), 3, '0', STR_PAD_LEFT); }

        $item = Company::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Company created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, Company $company): JsonResponse
    {
        $this->authorize('view', $company);
        $company->load(['users', 'subscriptions', 'purchaseTransactions']);
        return response()->json([
            'success' => true,
            'data' => $company,
        ]);
    }

    public function update(Request $request, Company $company): JsonResponse
    {
        $this->authorize('update', $company);
        $data = $request->validate(['name' => 'sometimes|string|max:255', 'status' => 'sometimes|in:Active,Trial,Pending,Suspended', 'plan' => 'sometimes|in:Essential Care,Professional Growth,Enterprise Suite']);
        $company->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Company updated.',
            'data' => $company->fresh(),
        ]);
    }

    public function destroy(Request $request, Company $company): JsonResponse
    {
        $this->authorize('delete', $company);
        $company->delete();

        return response()->json([
            'success' => true,
            'message' => 'Company deleted.',
        ]);
    }

    
}

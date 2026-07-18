<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Staff::class);

        $query = Staff::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['department', 'ward', 'certifications', 'reviews' => fn($q) => $q->latest()->limit(5)]);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Staff list retrieved.',
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
        $this->authorize('create', Staff::class);
        $data = $request->validate(['first_name' => 'required|string|max:100', 'last_name' => 'required|string|max:100', 'email' => 'required|email|unique:staff,email', 'phone' => 'required|string|max:30', 'role' => 'required|string|max:100', 'department_id' => 'nullable|exists:departments,id', 'joined_date' => 'nullable|date', 'license_number' => 'nullable|string|max:100']);

        if (empty($data['code'])) { $data['code'] = 'ST-' . str_pad((string) (Staff::max('id') + 1), 3, '0', STR_PAD_LEFT); } $data['initials'] = strtoupper(substr($data['first_name'], 0, 1) . substr($data['last_name'], 0, 1));

        $item = Staff::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Staff created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, Staff $staff): JsonResponse
    {
        $this->authorize('view', $staff);
        $staff->load(['department', 'ward', 'certifications', 'attendance' => fn($q) => $q->latest()->limit(20), 'leaves', 'reviews', 'payrollEntries']);
        return response()->json([
            'success' => true,
            'data' => $staff,
        ]);
    }

    public function update(Request $request, Staff $staff): JsonResponse
    {
        $this->authorize('update', $staff);
        $data = $request->validate(['first_name' => 'sometimes|string|max:100', 'last_name' => 'sometimes|string|max:100', 'role' => 'sometimes|string|max:100', 'status' => 'sometimes|in:Active,On Leave,Inactive']);
        $staff->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Staff updated.',
            'data' => $staff->fresh(),
        ]);
    }

    public function destroy(Request $request, Staff $staff): JsonResponse
    {
        $this->authorize('delete', $staff);
        $staff->delete();

        return response()->json([
            'success' => true,
            'message' => 'Staff deleted.',
        ]);
    }

    
}

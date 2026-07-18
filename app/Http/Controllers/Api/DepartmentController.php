<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Department::class);

        $query = Department::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['head', 'staff', 'rooms', 'services']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Department list retrieved.',
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
        $this->authorize('create', Department::class);
        $data = $request->validate(['name' => 'required|string|max:100', 'code' => 'nullable|string|max:20|unique:departments,code', 'head_staff_id' => 'nullable|exists:staff,id', 'description' => 'nullable|string']);

        

        $item = Department::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Department created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, Department $department): JsonResponse
    {
        $this->authorize('view', $department);
        $department->load(['head', 'staff', 'rooms', 'services']);
        return response()->json([
            'success' => true,
            'data' => $department,
        ]);
    }

    public function update(Request $request, Department $department): JsonResponse
    {
        $this->authorize('update', $department);
        $data = $request->validate(['name' => 'sometimes|string|max:100', 'head_staff_id' => 'nullable|exists:staff,id', 'status' => 'sometimes|in:Active,Inactive']);
        $department->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Department updated.',
            'data' => $department->fresh(),
        ]);
    }

    public function destroy(Request $request, Department $department): JsonResponse
    {
        $this->authorize('delete', $department);
        $department->delete();

        return response()->json([
            'success' => true,
            'message' => 'Department deleted.',
        ]);
    }

    public function staff(Department $department): JsonResponse
    {
        $this->authorize('view', $department);
        $staff = $department->staff()->with(['certifications'])->paginate(15);
        return response()->json(['success' => true, 'data' => $staff]);
    }

    public function rooms(Department $department): JsonResponse
    {
        $this->authorize('view', $department);
        $rooms = $department->rooms()->with(['patient', 'doctor'])->paginate(15);
        return response()->json(['success' => true, 'data' => $rooms]);
    }
}

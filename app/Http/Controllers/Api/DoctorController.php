<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Staff::class);

        $query = Staff::query()->forCompany($request->user());

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")->orWhere('last_name', 'like', "%{$search}%")->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['department', 'certifications', 'reviews'])
            ->where(function ($query): void {
                $query->where('role', 'like', '%Doctor%')
                    ->orWhere('role', 'like', '%Physician%')
                    ->orWhere('role', 'like', '%Surgeon%');
            });

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Doctor list retrieved.',
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
        $data = $request->validate(['first_name' => 'required|string|max:100', 'last_name' => 'required|string|max:100', 'email' => 'required|email|unique:staff,email', 'phone' => 'required|string|max:30', 'role' => 'required|string|max:100', 'department_id' => 'nullable|exists:departments,id', 'specialization' => 'nullable|string|max:255', 'license_number' => 'nullable|string|max:100']);
        $data['company_id'] = $request->user()->company_id;

        if (! empty($data['department_id'])) {
            abort_unless(\App\Models\Department::forCompany($request->user())->whereKey($data['department_id'])->exists(), 422);
        }

        if (empty($data['code'])) { $data['code'] = 'ST-' . str_pad((string) (Staff::max('id') + 1), 3, '0', STR_PAD_LEFT); } $data['initials'] = strtoupper(substr($data['first_name'], 0, 1) . substr($data['last_name'], 0, 1));

        $item = Staff::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Doctor created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, Staff $doctor): JsonResponse
    {
        $this->authorize('view', $doctor);
        $doctor->load(['department', 'certifications', 'reviews', 'appointments' => fn($q) => $q->latest()->limit(10)]);
        return response()->json([
            'success' => true,
            'data' => $doctor,
        ]);
    }

    public function update(Request $request, Staff $doctor): JsonResponse
    {
        $this->authorize('update', $doctor);
        $data = $request->validate(['first_name' => 'sometimes|string|max:100', 'specialization' => 'sometimes|string|max:255', 'status' => 'sometimes|in:Active,On Leave,Inactive']);
        $doctor->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Doctor updated.',
            'data' => $doctor->fresh(),
        ]);
    }

    public function destroy(Request $request, Staff $doctor): JsonResponse
    {
        $this->authorize('delete', $doctor);
        $doctor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Doctor deleted.',
        ]);
    }

    
}

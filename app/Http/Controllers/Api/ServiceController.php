<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Service::class);

        $query = Service::query()->forCompany($request->user());

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('type', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['department', 'availability', 'providers.staff']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Service list retrieved.',
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
        $this->authorize('create', Service::class);
        $data = $request->validate(['name' => 'required|string|max:255', 'department_id' => 'nullable|exists:departments,id', 'type' => 'nullable|in:Preventive,Diagnostic,Treatment,Surgical', 'duration' => 'nullable|string|max:50', 'price' => 'required|numeric|min:0']);
        if (! empty($data['department_id'])) {
            $department = \App\Models\Department::forCompany($request->user())->findOrFail($data['department_id']);
            $data['department_name'] = $department->name;
        }

        $item = Service::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Service created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, Service $service): JsonResponse
    {
        $this->authorize('view', $service);
        $service->load(['department', 'availability', 'providers.staff']);
        return response()->json([
            'success' => true,
            'data' => $service,
        ]);
    }

    public function update(Request $request, Service $service): JsonResponse
    {
        $this->authorize('update', $service);
        $data = $request->validate(['name' => 'sometimes|string|max:255', 'price' => 'sometimes|numeric|min:0', 'status' => 'sometimes|in:Active,Inactive']);
        $service->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Service updated.',
            'data' => $service->fresh(),
        ]);
    }

    public function destroy(Request $request, Service $service): JsonResponse
    {
        $this->authorize('delete', $service);
        $service->delete();

        return response()->json([
            'success' => true,
            'message' => 'Service deleted.',
        ]);
    }

    
}

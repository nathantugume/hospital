<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vaccination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VaccinationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Vaccination::class);

        $query = Vaccination::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")->orWhere('vaccine_name', 'like', "%{$search}%")->orWhereHas('patient', fn($pq) => $pq->where('first_name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['patient', 'administeredBy']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Vaccination list retrieved.',
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
        $this->authorize('create', Vaccination::class);
        $data = $request->validate(['patient_id' => 'required|exists:patients,id', 'vaccine_name' => 'required|string|max:255', 'dose' => 'nullable|string|max:50', 'date' => 'required|date', 'administered_by' => 'nullable|exists:staff,id', 'next_dose_date' => 'nullable|date|after:date']);

        if (empty($data['code'])) { $data['code'] = 'VAC-' . str_pad((string) (Vaccination::max('id') + 1), 4, '0', STR_PAD_LEFT); }

        $item = Vaccination::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Vaccination created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, Vaccination $vaccination): JsonResponse
    {
        $this->authorize('view', $vaccination);
        $vaccination->load(['patient', 'administeredBy']);
        return response()->json([
            'success' => true,
            'data' => $vaccination,
        ]);
    }

    public function update(Request $request, Vaccination $vaccination): JsonResponse
    {
        $this->authorize('update', $vaccination);
        $data = $request->validate(['status' => 'sometimes|in:Completed,Scheduled,Cancelled']);
        $vaccination->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Vaccination updated.',
            'data' => $vaccination->fresh(),
        ]);
    }

    public function destroy(Request $request, Vaccination $vaccination): JsonResponse
    {
        $this->authorize('delete', $vaccination);
        $vaccination->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vaccination deleted.',
        ]);
    }

    
}

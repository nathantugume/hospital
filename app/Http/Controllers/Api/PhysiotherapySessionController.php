<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PhysiotherapySession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PhysiotherapySessionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', PhysiotherapySession::class);

        $query = PhysiotherapySession::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', fn($pq) => $pq->where('first_name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['patient', 'therapist']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Physiotherapy session list retrieved.',
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
        $this->authorize('create', PhysiotherapySession::class);
        $data = $request->validate(['patient_id' => 'required|exists:patients,id', 'therapist_id' => 'nullable|exists:staff,id', 'date' => 'required|date', 'time' => 'required', 'type' => 'nullable|string|max:50', 'room' => 'nullable|string|max:100', 'duration' => 'nullable|string|max:20', 'condition' => 'nullable|string|max:255']);

        

        $item = PhysiotherapySession::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Physiotherapy session created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, PhysiotherapySession $session): JsonResponse
    {
        $this->authorize('view', $session);
        $session->load(['patient', 'therapist']);
        return response()->json([
            'success' => true,
            'data' => $session,
        ]);
    }

    public function update(Request $request, PhysiotherapySession $session): JsonResponse
    {
        $this->authorize('update', $session);
        $data = $request->validate(['status' => 'sometimes|in:Scheduled,In Progress,Completed,Cancelled', 'notes' => 'nullable|string']);
        $session->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Physiotherapy session updated.',
            'data' => $session->fresh(),
        ]);
    }

    public function destroy(Request $request, PhysiotherapySession $session): JsonResponse
    {
        $this->authorize('delete', $session);
        $session->delete();

        return response()->json([
            'success' => true,
            'message' => 'Physiotherapy session deleted.',
        ]);
    }

    
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Surgery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SurgeryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Surgery::class);

        $query = Surgery::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")->orWhere('procedure', 'like', "%{$search}%")->orWhereHas('patient', fn($pq) => $pq->where('first_name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['patient', 'surgeon', 'anesthesiologist', 'nurse']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Surgery list retrieved.',
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
        $this->authorize('create', Surgery::class);
        $data = $request->validate(['patient_id' => 'required|exists:patients,id', 'procedure' => 'required|string|max:255', 'ot_room' => 'required|string|max:50', 'surgeon_id' => 'nullable|exists:staff,id', 'anesthesiologist_id' => 'nullable|exists:staff,id', 'nurse_id' => 'nullable|exists:staff,id', 'date' => 'required|date', 'start_time' => 'required', 'end_time' => 'nullable', 'priority' => 'nullable|in:Normal,High,Critical']);

        if (empty($data['code'])) { $data['code'] = 'SURG' . str_pad((string) (Surgery::max('id') + 1), 4, '0', STR_PAD_LEFT); }

        $item = Surgery::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Surgery created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, Surgery $surgery): JsonResponse
    {
        $this->authorize('view', $surgery);
        $surgery->load(['patient', 'surgeon', 'anesthesiologist', 'nurse']);
        return response()->json([
            'success' => true,
            'data' => $surgery,
        ]);
    }

    public function update(Request $request, Surgery $surgery): JsonResponse
    {
        $this->authorize('update', $surgery);
        $data = $request->validate(['status' => 'sometimes|in:Scheduled,Pre-Op,In Progress,Emergency,Completed,Cancelled', 'priority' => 'sometimes|in:Normal,High,Critical', 'notes' => 'nullable|string']);
        $surgery->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Surgery updated.',
            'data' => $surgery->fresh(),
        ]);
    }

    public function destroy(Request $request, Surgery $surgery): JsonResponse
    {
        $this->authorize('delete', $surgery);
        $surgery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Surgery deleted.',
        ]);
    }

    
}

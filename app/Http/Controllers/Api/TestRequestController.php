<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TestRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestRequestController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', TestRequest::class);

        $query = TestRequest::query()->forCompany($request->user())->with(['patient', 'doctor', 'labTests']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")->orWhereHas('patient', fn($p) => $p->where('first_name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($patientId = $request->input('patient_id')) { $query->where('patient_id', $patientId); }
        if ($priority = $request->input('priority')) { $query->where('priority', $priority); }

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Test request list retrieved.',
            'data' => $items->items(),
            'meta' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem(),
            ],
            'links' => [
                'first' => $items->url(1),
                'last' => $items->url($items->lastPage()),
                'prev' => $items->previousPageUrl(),
                'next' => $items->nextPageUrl(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', TestRequest::class);
        $data = $request->validate(['patient_id' => 'required|exists:patients,id', 'doctor_id' => 'nullable|exists:staff,id', 'priority' => 'nullable|in:Routine,Urgent,STAT', 'requested_date' => 'required|date']);
        abort_unless(\App\Models\Patient::forCompany($request->user())->whereKey($data['patient_id'])->exists(), 422);

        if (! empty($data['doctor_id'])) {
            abort_unless(\App\Models\Staff::forCompany($request->user())->whereKey($data['doctor_id'])->exists(), 422);
        }
        if (empty($data['code'])) { $data['code'] = 'TR-' . str_pad((string) (TestRequest::max('id') + 1), 4, '0', STR_PAD_LEFT); }
        $item = TestRequest::create($data);
        $item->load(['patient', 'doctor', 'labTests']);
        return $this->success($item, 'Test request created.', 201);
    }

    public function show(Request $request, TestRequest $testRequest): JsonResponse
    {
        $this->authorize('view', $testRequest);
        $testRequest->load(['patient', 'doctor', 'labTests']);
        return $this->success($testRequest);
    }

    public function update(Request $request, TestRequest $testRequest): JsonResponse
    {
        $this->authorize('update', $testRequest);
        $data = $request->validate(['status' => 'sometimes|in:Pending,Sample Collected,In Progress,Completed,Cancelled', 'priority' => 'sometimes|in:Routine,Urgent,STAT']);
        $testRequest->update($data);
        $testRequest->load(['patient', 'doctor', 'labTests']);
        return $this->success($testRequest, 'Test request updated.');
    }

    public function destroy(Request $request, TestRequest $testRequest): JsonResponse
    {
        $this->authorize('delete', $testRequest);
        $testRequest->delete();
        return response()->json(['success' => true, 'message' => 'Test request deleted.']);
    }
}

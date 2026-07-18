<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LabResults\StoreLabResultRequest;
use App\Http\Requests\LabResults\UpdateLabResultRequest;
use App\Http\Resources\LabResults\Resource;
use App\Models\LabResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class LabResultController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', LabResult::class);

        $query = LabResult::query()->with(['patient', 'labTest', 'orderedBy', 'verifiedBy', 'items']);

        if ($search = $request->input('search')) {
            $query->where('code', 'like', "%{$search}%")
                  ->orWhereHas('patient', fn($q) => $q->where('first_name', 'like', "%{$search}%"));
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($flag = $request->input('flag')) {
            $query->where('flag', $flag);
        }

        if ($patientId = $request->input('patient_id')) {
            $query->where('patient_id', $patientId);
        }

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest('result_date')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => Resource::collection($items->items()),
            'meta' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
            ],
        ]);
    }

    public function store(StoreLabResultRequest $request): JsonResponse
    {
        $this->authorize('create', LabResult::class);
        $data = $request->validated();

        if (empty($data['code'])) {
            $data['code'] = 'RES-' . str_pad((string) (LabResult::max('id') + 1), 4, '0', STR_PAD_LEFT);
        }

        $result = LabResult::create($data);

        // Create result items if provided
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $result->items()->create($item);
            }
        }

        // Fire abnormal result event if flagged
        if (in_array($result->flag, ['High', 'Low', 'Critical'])) {
            event(new \App\Events\AbnormalLabResult($result));
        }

        $result->load(['patient', 'labTest', 'orderedBy', 'items']);
        return $this->resource(new Resource($result), 'Lab result created.', 201);
    }

    public function show(Request $request, LabResult $labResult): JsonResponse
    {
        $this->authorize('view', $labResult);
        $labResult->load(['patient', 'labTest', 'orderedBy', 'verifiedBy', 'items']);
        return $this->resource(new Resource($labResult));
    }

    public function update(UpdateLabResultRequest $request, LabResult $labResult): JsonResponse
    {
        $this->authorize('update', $labResult);
        $labResult->update($request->validated());
        $labResult->load(['patient', 'labTest', 'items']);
        return $this->resource(new Resource($labResult), 'Lab result updated.');
    }

    public function destroy(Request $request, LabResult $labResult): JsonResponse
    {
        $this->authorize('delete', $labResult);
        $labResult->delete();
        return response()->json(['success' => true, 'message' => 'Lab result deleted.']);
    }

    public function verify(Request $request, LabResult $labResult): JsonResponse
    {
        $this->authorize('update', $labResult);
        $labResult->update([
            'verified_by' => $request->user()->staff_id,
            'verified_date' => now(),
            'status' => 'Completed',
        ]);
        $labResult->load(['patient', 'verifiedBy', 'items']);
        return $this->resource(new Resource($labResult), 'Lab result verified.');
    }

    public function shareUrl(Request $request, LabResult $labResult): JsonResponse
    {
        $this->authorize('view', $labResult);

        $token = \Illuminate\Support\Str::random(64);
        $labResult->update([
            'share_token' => $token,
            'share_expires_at' => now()->addDays(7),
        ]);

        $url = URL::temporarySignedRoute('share.lab-result', now()->addDays(7), ['token' => $token]);

        return response()->json([
            'success' => true,
            'data' => [
                'share_url' => $url,
                'expires_at' => $labResult->share_expires_at->toIso8601String(),
            ],
        ]);
    }
}

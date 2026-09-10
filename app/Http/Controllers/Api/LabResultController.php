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
use Illuminate\View\View;

class LabResultController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', LabResult::class);

        $query = LabResult::query()->forCompany($request->user())->with(['patient', 'labTest', 'orderedBy', 'verifiedBy', 'items']);

        if ($search = $request->input('search')) {
            $query->where(function ($query) use ($search): void {
                $query->where('code', 'like', "%{$search}%")
                    ->orWhereHas('patient', fn($q) => $q->where('first_name', 'like', "%{$search}%"));
            });
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
        abort_unless(\App\Models\Patient::forCompany($request->user())->whereKey($data['patient_id'])->exists(), 422);

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
        abort_unless($request->user()->hasRole(['admin', 'super_admin', 'doctor', 'lab_technician']), 403);
        abort_unless($request->user()->staff_id !== null, 422, 'A linked staff record is required to verify results.');
        abort_unless($labResult->status === 'Completed' && filled($labResult->result_value), 409, 'Only completed results with a value can be verified.');
        $labResult->update([
            'verified_by' => $request->user()->staff_id,
            'verified_date' => now(),
            'status' => 'Verified',
        ]);
        if (in_array($labResult->flag, ['High', 'Low', 'Critical'], true)) { event(new \App\Events\AbnormalLabResult($labResult->fresh())); }
        $labResult->load(['patient', 'verifiedBy', 'items']);
        return $this->resource(new Resource($labResult), 'Lab result verified.');
    }

    public function shareUrl(Request $request, LabResult $labResult): JsonResponse
    {
        $this->authorize('view', $labResult);
        abort_unless($labResult->status === 'Verified', 409, 'Only verified results can be shared.');

        $token = \Illuminate\Support\Str::random(64);
        $labResult->update([
            'share_token' => hash('sha256', $token),
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

    public function sharedView(Request $request, string $token): View
    {
        abort_unless($request->hasValidSignature(), 403);
        $labResult = LabResult::query()->where('share_token', hash('sha256', $token))->where('status', 'Verified')->where('share_expires_at', '>', now())->with(['patient', 'labTest', 'verifiedBy'])->firstOrFail();
        return view('laboratory.shared-result', compact('labResult'));
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InsuranceClaim;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InsuranceClaimController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', InsuranceClaim::class);

        $query = InsuranceClaim::query()->with(['patient', 'invoice', 'provider', 'services', 'communications']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")->orWhere('provider', 'like', "%{$search}%")->orWhere('policy_number', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($patientId = $request->input('patient_id')) { $query->where('patient_id', $patientId); }
        if ($providerId = $request->input('insurance_provider_id')) { $query->where('insurance_provider_id', $providerId); }

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Insurance claim list retrieved.',
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
        $this->authorize('create', InsuranceClaim::class);
        $data = $request->validate(['patient_id' => 'required|exists:patients,id', 'provider' => 'required|string|max:255', 'policy_number' => 'required|string|max:100', 'amount' => 'required|numeric|min:0', 'type' => 'nullable|in:Medical,Dental,Vision', 'invoice_id' => 'nullable|exists:invoices,id', 'insurance_provider_id' => 'nullable|exists:insurance_providers,id']);
        if (empty($data['code'])) { $data['code'] = 'CLM-' . str_pad((string) (InsuranceClaim::max('id') + 1), 3, '0', STR_PAD_LEFT); }
        $item = InsuranceClaim::create($data);
        $item->load(['patient', 'invoice', 'provider', 'services', 'communications']);
        return $this->success($item, 'Insurance claim created.', 201);
    }

    public function show(Request $request, InsuranceClaim $insuranceClaim): JsonResponse
    {
        $this->authorize('view', $insuranceClaim);
        $insuranceClaim->load(['patient', 'invoice', 'provider', 'services', 'communications']);
        return $this->success($insuranceClaim);
    }

    public function update(Request $request, InsuranceClaim $insuranceClaim): JsonResponse
    {
        $this->authorize('update', $insuranceClaim);
        $data = $request->validate(['status' => 'sometimes|in:Draft,Submitted,Pending,Approved,Rejected', 'approved_amount' => 'nullable|numeric|min:0', 'rejection_reason' => 'nullable|string']);
        $insuranceClaim->update($data);
        $insuranceClaim->load(['patient', 'invoice', 'provider', 'services', 'communications']);
        return $this->success($insuranceClaim, 'Insurance claim updated.');
    }

    public function destroy(Request $request, InsuranceClaim $insuranceClaim): JsonResponse
    {
        $this->authorize('delete', $insuranceClaim);
        $insuranceClaim->delete();
        return response()->json(['success' => true, 'message' => 'Insurance claim deleted.']);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Invoices\StoreInvoiceRequest;
use App\Http\Requests\Invoices\UpdateInvoiceRequest;
use App\Http\Resources\Invoices\Resource;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Invoice::class);

        $query = Invoice::query()->forCompany($request->user())->with(['patient', 'items', 'insuranceClaims']);

        if ($request->user()->isPatient()) {
            $query->where('patient_id', $request->user()->patient_id);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($query) use ($search): void {
                $query->where('code', 'like', "%{$search}%")
                    ->orWhereHas('patient', fn($q) => $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

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

    public function store(StoreInvoiceRequest $request): JsonResponse
    {
        $this->authorize('create', Invoice::class);
        $data = $request->validated();
        $data['company_id'] = $request->user()->company_id;
        abort_unless(\App\Models\Patient::forCompany($request->user())->whereKey($data['patient_id'])->exists(), 422);

        if (empty($data['code'])) {
            $data['code'] = 'INV-' . str_pad((string) (Invoice::max('id') + 1), 5, '0', STR_PAD_LEFT);
        }

        $invoice = Invoice::create($data);

        // Create invoice items if provided
        if (isset($data['items'])) {
            foreach ($data['items'] as $item) {
                $invoice->items()->create($item);
            }
            $invoice->update(['amount' => collect($data['items'])->sum('total')]);
        }

        $invoice->load(['patient', 'items']);
        return $this->resource(new Resource($invoice), 'Invoice created.', 201);
    }

    public function show(Request $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('view', $invoice);
        $invoice->load(['patient', 'items', 'insuranceClaims.claimServices', 'services.service']);
        return $this->resource(new Resource($invoice));
    }

    public function update(UpdateInvoiceRequest $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('update', $invoice);
        $invoice->update($request->validated());
        $invoice->load(['patient', 'items']);
        return $this->resource(new Resource($invoice), 'Invoice updated.');
    }

    public function destroy(Request $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('delete', $invoice);
        $invoice->delete();
        return response()->json(['success' => true, 'message' => 'Invoice deleted.']);
    }

    public function pay(Request $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('update', $invoice);

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'payment_reference' => 'nullable|string|max:100',
        ]);

        $paidAmount = $invoice->paid_amount + $request->amount;
        $balance = $invoice->amount - $paidAmount;

        $invoice->update([
            'paid_amount' => $paidAmount,
            'balance' => max(0, $balance),
            'status' => $balance <= 0 ? 'Paid' : 'Partially Paid',
            'payment_date' => now(),
            'payment_method' => $request->payment_method,
            'payment_reference' => $request->payment_reference,
        ]);

        if ($invoice->status === 'Paid') {
            event(new \App\Events\InvoicePaid($invoice));
        }

        $invoice->load(['patient', 'items']);
        return $this->resource(new Resource($invoice), 'Payment processed successfully.');
    }

    public function cancel(Request $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('update', $invoice);
        $invoice->update(['status' => 'Void']);
        return $this->resource(new Resource($invoice), 'Invoice voided.');
    }

    public function receipt(Request $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('view', $invoice);
        $invoice->load(['patient', 'items']);
        return response()->json([
            'success' => true,
            'data' => [
                'receipt_number' => 'RCP-' . $invoice->id,
                'invoice' => new Resource($invoice),
                'hospital' => [
                    'name' => 'MediTrack Healthcare',
                    'address' => 'Plot 14, Kampala Road, Kampala, Uganda',
                    'phone' => '+256-414-100-100',
                ],
                'generated_at' => now()->toIso8601String(),
            ],
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PayrollEntry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', PayrollEntry::class);

        $query = PayrollEntry::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")->orWhere('employee_name', 'like', "%{$search}%")->orWhereHas('staff', fn($sq) => $sq->where('first_name', 'like', "%{$search}%"));
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $query->with(['staff', 'payslips']);

        $perPage = min((int) $request->input('per_page', 15), 100);
        $items = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Payroll entry list retrieved.',
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
        $this->authorize('create', PayrollEntry::class);
        $data = $request->validate(['staff_id' => 'required|exists:staff,id', 'employee_name' => 'required|string|max:255', 'joining_date' => 'required|date', 'role' => 'required|string|max:100', 'salary' => 'required|numeric|min:0', 'currency' => 'nullable|string|size:3', 'payment_method' => 'nullable|in:bank,cash,mobile_money,cheque']);

        if (empty($data['code'])) { $data['code'] = 'PMT-' . str_pad((string) (PayrollEntry::max('id') + 1), 3, '0', STR_PAD_LEFT); }

        $item = PayrollEntry::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Payroll entry created.',
            'data' => $item,
        ], 201);
    }

    public function show(Request $request, PayrollEntry $payrollEntry): JsonResponse
    {
        $this->authorize('view', $payrollEntry);
        $payrollEntry->load(['staff', 'payslips' => fn($q) => $q->latest()]);
        return response()->json([
            'success' => true,
            'data' => $payrollEntry,
        ]);
    }

    public function update(Request $request, PayrollEntry $payrollEntry): JsonResponse
    {
        $this->authorize('update', $payrollEntry);
        $data = $request->validate(['salary' => 'sometimes|numeric|min:0', 'status' => 'sometimes|in:Active,Inactive', 'payment_method' => 'sometimes|in:bank,cash,mobile_money,cheque']);
        $payrollEntry->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Payroll entry updated.',
            'data' => $payrollEntry->fresh(),
        ]);
    }

    public function destroy(Request $request, PayrollEntry $payrollEntry): JsonResponse
    {
        $this->authorize('delete', $payrollEntry);
        $payrollEntry->delete();

        return response()->json([
            'success' => true,
            'message' => 'Payroll entry deleted.',
        ]);
    }

    
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function financial(Request $request, CurrencyService $currency): View
    {
        $this->authorize('viewAny', Invoice::class);
        $from = $request->date('from') ?? now()->subMonths(5)->startOfMonth();
        $to = $request->date('to') ?? now();

        $invoices = Invoice::forCompany($request->user())->with('patient')
            ->whereDate('date', '>=', $from->toDateString())
            ->whereDate('date', '<=', $to->toDateString())
            ->get();

        $stats = [
            'invoiced' => $invoices->sum('amount'),
            'collected' => $invoices->sum('paid_amount'),
            'outstanding' => $invoices->whereIn('status', ['Pending', 'Partial', 'Overdue'])->sum('balance'),
            'invoice_count' => $invoices->count(),
        ];

        $monthlySummary = $invoices
            ->groupBy(fn (Invoice $invoice) => $invoice->date->format('Y-m'))
            ->sortKeys()
            ->map(fn ($group, $period) => (object) [
                'period_label' => $group->first()->date->format('M Y'),
                'invoiced' => $group->sum('amount'),
                'collected' => $group->sum('paid_amount'),
                'invoice_count' => $group->count(),
            ])
            ->values();

        $statusBreakdown = $invoices
            ->groupBy(fn (Invoice $invoice) => $invoice->status ?: 'Pending')
            ->map(fn ($group, $status) => (object) [
                'status' => $status,
                'invoice_count' => $group->count(),
                'total_amount' => $group->sum('amount'),
            ])
            ->sortByDesc('total_amount')
            ->values();

        $topPatients = $invoices
            ->groupBy('patient_id')
            ->map(fn ($group) => (object) [
                'patient' => $group->first()->patient,
                'total_amount' => $group->sum('amount'),
                'invoice_count' => $group->count(),
            ])
            ->sortByDesc('total_amount')
            ->take(8)
            ->values();

        return view('reports.financial', compact(
            'currency',
            'stats',
            'monthlySummary',
            'statusBreakdown',
            'topPatients',
            'from',
            'to'
        ));
    }
}

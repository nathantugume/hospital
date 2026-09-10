<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Invoice::class);

        $invoices = Invoice::query()
            ->forCompany($request->user())
            ->with('patient')
            ->when($request->string('search')->trim()->value(), function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('code', 'like', "%{$search}%")
                        ->orWhereHas('patient', fn ($query) => $query
                            ->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%"));
                });
            })
            ->when($request->string('status')->trim()->value(), fn ($query, string $status) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'outstanding' => Invoice::forCompany($request->user())->whereIn('status', ['Pending', 'Partial', 'Overdue'])->sum('balance'),
            'paid_this_month' => Invoice::forCompany($request->user())->where('status', 'Paid')->whereMonth('payment_date', now()->month)->whereYear('payment_date', now()->year)->sum('amount'),
            'overdue' => Invoice::forCompany($request->user())->where('status', 'Overdue')->count(),
            'partial' => Invoice::forCompany($request->user())->where('status', 'Partial')->count(),
        ];

        return view('invoices.index', compact('invoices', 'stats'));
    }
}

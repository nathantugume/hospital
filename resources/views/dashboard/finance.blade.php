@extends('layouts.app')

@section('title', 'Finance Dashboard')
@section('header', 'Finance')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Finance dashboard</h1>
            <p class="text-gray-500">Billing, collections, and insurance claims in {{ $currency->code() }}.</p>
        </div>
        <a href="{{ route('web.invoices.index') }}" class="inline-flex items-center justify-center rounded-md bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 text-sm shadow-sm">Open billing</a>
    </div>

    <div class="grid gap-4 md:grid-cols-4">
        <div class="rounded-lg p-4 border bg-background shadow-sm">
            <h3 class="text-gray-500 text-sm">Total Outstanding</h3>
            <p class="text-2xl font-bold pt-2">@money($stats['outstanding'])</p>
        </div>
        <div class="rounded-lg p-4 border bg-background shadow-sm">
            <h3 class="text-gray-500 text-sm">Paid This Month</h3>
            <p class="text-2xl font-bold pt-2">@money($stats['paid_this_month'])</p>
        </div>
        <div class="rounded-lg p-4 border bg-background shadow-sm">
            <h3 class="text-gray-500 text-sm">Overdue Invoices</h3>
            <p class="text-2xl font-bold pt-2">{{ number_format($stats['overdue']) }}</p>
        </div>
        <div class="rounded-lg p-4 border bg-background shadow-sm">
            <h3 class="text-gray-500 text-sm">Pending Claims</h3>
            <p class="text-2xl font-bold pt-2">{{ number_format($stats['pending_claims']) }}</p>
        </div>
    </div>

    <div class="rounded-lg border bg-background shadow-sm">
        <div class="p-4 border-b flex items-center justify-between"><h2 class="text-xl font-semibold">Recent invoices</h2><a href="{{ route('web.invoices.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all</a></div>
        <div class="overflow-x-auto">
            @if ($recentInvoices->isEmpty())
                <div class="text-center py-8 text-gray-500">No invoices have been recorded.</div>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b bg-gray-50"><th class="text-left p-3">Invoice #</th><th class="text-left p-3">Patient</th><th class="text-left p-3">Date</th><th class="text-right p-3">Amount</th><th class="text-right p-3">Balance</th><th class="text-left p-3">Status</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($recentInvoices as $invoice)
                            @php
                                $statusClasses = match ($invoice->status ?? 'Pending') {
                                    'Paid' => 'bg-green-100 text-green-700',
                                    'Partial' => 'bg-amber-100 text-amber-700',
                                    'Overdue', 'Cancelled' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 font-medium">{{ $invoice->code }}</td>
                                <td class="p-3">{{ $invoice->patient?->full_name ?? '—' }}</td>
                                <td class="p-3">{{ optional($invoice->date)->format('d M Y') }}</td>
                                <td class="p-3 text-right">@money($invoice->amount)</td>
                                <td class="p-3 text-right">@money($invoice->balance)</td>
                                <td class="p-3"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $statusClasses }}">{{ $invoice->status ?? 'Pending' }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="rounded-lg border bg-background shadow-sm">
        <div class="p-4 border-b"><h2 class="text-xl font-semibold">Recent insurance claims</h2></div>
        <div class="overflow-x-auto">
            @if ($recentClaims->isEmpty())
                <div class="text-center py-8 text-gray-500">No insurance claims have been submitted.</div>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b bg-gray-50"><th class="text-left p-3">Patient</th><th class="text-left p-3">Provider</th><th class="text-left p-3">Submitted</th><th class="text-right p-3">Amount</th><th class="text-left p-3">Status</th></tr>
                    </thead>
                    <tbody>
                        @foreach ($recentClaims as $claim)
                            @php
                                $statusClasses = match ($claim->status ?? 'Pending') {
                                    'Approved', 'Paid' => 'bg-green-100 text-green-700',
                                    'Rejected' => 'bg-red-100 text-red-700',
                                    default => 'bg-amber-100 text-amber-700',
                                };
                            @endphp
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3">{{ $claim->patient?->full_name ?? '—' }}</td>
                                <td class="p-3">{{ $claim->provider ?? '—' }}</td>
                                <td class="p-3">{{ optional($claim->submitted_date)->format('d M Y') }}</td>
                                <td class="p-3 text-right">@money($claim->amount)</td>
                                <td class="p-3"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $statusClasses }}">{{ $claim->status ?? 'Pending' }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection

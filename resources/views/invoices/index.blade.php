@extends('layouts.app')

@section('title', 'Invoices')
@section('header', 'Billing')

@section('content')
<div class="flex flex-col gap-5">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Invoices</h1>
            <p class="text-gray-500">Review patient billing and outstanding balances.</p>
        </div>
        <a href="{{ url('/create-invoice.html') }}" class="inline-flex items-center gap-2 rounded-md bg-primary text-white px-4 py-2 text-sm hover:bg-primary/90">+ Create invoice</a>
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
            <h3 class="text-gray-500 text-sm">Partially Paid</h3>
            <p class="text-2xl font-bold pt-2">{{ number_format($stats['partial']) }}</p>
        </div>
    </div>

    <div class="rounded-lg border bg-background shadow-sm">
        <div class="p-4 border-b flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="text-xl font-semibold">{{ number_format($invoices->total()) }} invoices</h2>
            <form method="GET" action="{{ route('web.invoices.index') }}" class="flex flex-wrap gap-2">
                <div class="relative">
                    <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search invoices..." class="h-10 rounded-md border border-gray-300 bg-background pl-8 pr-3 text-sm w-full md:w-[220px] focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <select name="status" class="h-10 rounded-md border border-gray-300 bg-background px-3 text-sm">
                    <option value="">All statuses</option>
                    @foreach (['Pending', 'Partial', 'Paid', 'Overdue', 'Cancelled'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <button type="submit" class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-background px-3 py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10">Filter</button>
            </form>
        </div>
        <div class="overflow-x-auto">
            @if ($invoices->isEmpty())
                <div class="text-center py-8 text-gray-500">No invoices match the selected filters.</div>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left p-3">Invoice #</th>
                            <th class="text-left p-3">Patient</th>
                            <th class="text-left p-3">Date</th>
                            <th class="text-right p-3">Amount</th>
                            <th class="text-right p-3">Balance</th>
                            <th class="text-left p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
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
        @include('partials.pagination', ['paginator' => $invoices, 'label' => 'invoices'])
    </div>
</div>
@endsection

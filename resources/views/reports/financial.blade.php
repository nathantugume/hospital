@extends('layouts.app')

@section('title', 'Financial Reports')
@section('header', 'Financial Reports')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Financial Reports</h1>
            <p class="text-gray-500">Track revenue and collections in {{ $currency->code() }}.</p>
        </div>
        <form method="GET" action="{{ route('web.reports.financial') }}" class="flex flex-wrap items-center gap-2">
            <input type="date" name="from" value="{{ $from->toDateString() }}" class="h-10 rounded-md border border-gray-300 bg-background px-3 text-sm">
            <span class="text-gray-400 text-sm">to</span>
            <input type="date" name="to" value="{{ $to->toDateString() }}" class="h-10 rounded-md border border-gray-300 bg-background px-3 text-sm">
            <button type="submit" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 text-sm shadow-sm">Apply</button>
        </form>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Total invoiced</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">@money($stats['invoiced'])</div>
            <p class="text-xs text-gray-500 mt-1">{{ $from->format('d M Y') }} &ndash; {{ $to->format('d M Y') }}</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Total collected</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">@money($stats['collected'])</div>
            <p class="text-xs text-gray-500 mt-1">Paid amount received</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Outstanding</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">@money($stats['outstanding'])</div>
            <p class="text-xs text-gray-500 mt-1">Pending, partial or overdue</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Invoices issued</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['invoice_count']) }}</div>
            <p class="text-xs text-gray-500 mt-1">In selected range</p>
        </div>
    </div>

    <div class="rounded-lg border bg-background shadow-sm">
        <div class="p-4 border-b"><h2 class="text-xl font-semibold">Financial summary</h2><p class="text-gray-500 text-sm">Invoiced and collected totals by month.</p></div>
        <div class="overflow-x-auto">
            @if ($monthlySummary->isEmpty())
                <div class="text-center py-8 text-gray-500">No invoices in the selected range.</div>
            @else
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="text-left p-3">Month</th>
                            <th class="text-right p-3">Invoiced</th>
                            <th class="text-right p-3">Collected</th>
                            <th class="text-right p-3">Invoices</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthlySummary as $row)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3 font-medium">{{ $row->period_label }}</td>
                                <td class="p-3 text-right">@money($row->invoiced)</td>
                                <td class="p-3 text-right">@money($row->collected)</td>
                                <td class="p-3 text-right">{{ number_format($row->invoice_count) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b"><h2 class="text-lg font-semibold">By status</h2></div>
            <div class="overflow-x-auto">
                @if ($statusBreakdown->isEmpty())
                    <div class="text-center py-8 text-gray-500">No invoices in the selected range.</div>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="text-left p-3">Status</th>
                                <th class="text-right p-3">Invoices</th>
                                <th class="text-right p-3">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statusBreakdown as $row)
                                @php
                                    $statusClasses = match ($row->status) {
                                        'Paid' => 'bg-green-100 text-green-700',
                                        'Partial' => 'bg-amber-100 text-amber-700',
                                        'Overdue', 'Cancelled' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold {{ $statusClasses }}">{{ $row->status }}</span></td>
                                    <td class="p-3 text-right">{{ number_format($row->invoice_count) }}</td>
                                    <td class="p-3 text-right">@money($row->total_amount)</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b flex items-center justify-between"><h2 class="text-lg font-semibold">Top patients by billing</h2><a href="{{ route('web.invoices.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all invoices</a></div>
            <div class="overflow-x-auto">
                @if ($topPatients->isEmpty())
                    <div class="text-center py-8 text-gray-500">No invoices in the selected range.</div>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="text-left p-3">Patient</th>
                                <th class="text-right p-3">Invoices</th>
                                <th class="text-right p-3">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topPatients as $row)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 font-medium">{{ $row->patient?->full_name ?? 'Unknown patient' }}</td>
                                    <td class="p-3 text-right">{{ number_format($row->invoice_count) }}</td>
                                    <td class="p-3 text-right">@money($row->total_amount)</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

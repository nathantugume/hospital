@extends('layouts.app')

@section('title', 'Stock Alerts')
@section('header', 'Stock alerts')

@section('content')
<div class="flex flex-col gap-5">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('web.pharmacy.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground size-10" aria-label="Back to pharmacy">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Stock alerts</h1>
                <p class="text-gray-500">Monitor and manage inventory alerts.</p>
            </div>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border bg-background shadow-sm p-4">
            <div class="flex justify-between"><h3 class="text-sm font-medium text-gray-500">Low stock items</h3><span class="text-amber-500">&#9888;</span></div>
            <div class="text-2xl font-bold mt-2">{{ number_format($stats['low_stock']) }}</div>
            <p class="text-xs text-gray-500">Below minimum levels</p>
        </div>
        <div class="rounded-lg border bg-background shadow-sm p-4">
            <div class="flex justify-between"><h3 class="text-sm font-medium text-gray-500">Out of stock items</h3><span class="text-red-500">&#9888;</span></div>
            <div class="text-2xl font-bold mt-2">{{ number_format($stats['out_of_stock']) }}</div>
            <p class="text-xs text-gray-500">Completely depleted</p>
        </div>
        <div class="rounded-lg border bg-background shadow-sm p-4">
            <div class="flex justify-between"><h3 class="text-sm font-medium text-gray-500">Expiring soon</h3><span class="text-orange-500">&#9203;</span></div>
            <div class="text-2xl font-bold mt-2">{{ number_format($stats['expiring']) }}</div>
            <p class="text-xs text-gray-500">Within next 30 days</p>
        </div>
        <div class="rounded-lg border bg-background shadow-sm p-4">
            <div class="flex justify-between"><h3 class="text-sm font-medium text-gray-500">Catalogue</h3></div>
            <div class="text-2xl font-bold mt-2">{{ number_format($stats['catalogue']) }}</div>
            <p class="text-xs text-gray-500"><a href="{{ route('web.pharmacy.index') }}" class="hover:underline">View all medicines</a></p>
        </div>
    </div>

    <div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1 gap-1 w-fit">
        @foreach (['all' => 'All alerts', 'low' => 'Low stock', 'out' => 'Out of stock', 'expiring' => 'Expiring soon'] as $value => $label)
            <a href="{{ route('web.pharmacy.alerts', ['type' => $value]) }}" class="inline-flex items-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all {{ $type === $value ? 'bg-background shadow-sm text-gray-900' : 'text-gray-600 hover:text-gray-900' }}">{{ $label }}</a>
        @endforeach
    </div>

    <div class="rounded-lg border bg-background shadow-sm">
        <div class="p-4 border-b"><h2 class="text-xl font-semibold">{{ number_format($alerts->total()) }} alerts</h2><p class="text-gray-500">Items that need attention, sorted by stock level.</p></div>
        <div class="overflow-x-auto">
            @if ($alerts->isEmpty())
                <div class="text-center py-10 text-gray-500">
                    <div class="rounded-full bg-green-50 p-3 inline-flex mx-auto mb-2"><svg class="h-6 w-6 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg></div>
                    <p>No alerts in this category.</p>
                </div>
            @else
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="h-12 px-4 text-left">Item</th>
                            <th class="h-12 px-4 text-left">Category</th>
                            <th class="h-12 px-4 text-left">Stock</th>
                            <th class="h-12 px-4 text-left">Min. level</th>
                            <th class="h-12 px-4 text-left">Expiry</th>
                            <th class="h-12 px-4 text-left">Status</th>
                            <th class="h-12 px-4 text-left">Manufacturer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alerts as $medicine)
                            @php
                                $isOut = $medicine->stock <= 0;
                                $isLow = ! $isOut && $medicine->stock <= $medicine->reorder_level;
                                $isExpiring = $medicine->expiry && $medicine->expiry->between(today(), today()->addDays(30));
                                $statusLabel = $isOut ? 'Out of stock' : ($isLow ? 'Low stock' : ($isExpiring ? 'Expiring soon' : 'OK'));
                                $statusClasses = $isOut ? 'bg-red-100 text-red-700' : ($isLow ? 'bg-amber-100 text-amber-700' : ($isExpiring ? 'bg-orange-100 text-orange-700' : 'bg-gray-100 text-gray-700'));
                            @endphp
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3"><div class="font-medium">{{ $medicine->name }}</div><div class="text-xs text-gray-500">{{ $medicine->code }}</div></td>
                                <td class="px-4 py-3">{{ $medicine->category ?: 'General' }}</td>
                                <td class="px-4 py-3">{{ number_format($medicine->stock) }}</td>
                                <td class="px-4 py-3">{{ number_format($medicine->reorder_level) }}</td>
                                <td class="px-4 py-3">{{ optional($medicine->expiry)->format('d M Y') ?? '—' }}</td>
                                <td class="px-4 py-3"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $statusLabel }}</span></td>
                                <td class="px-4 py-3">{{ $medicine->manufacturer ?: '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        @include('partials.pagination', ['paginator' => $alerts, 'label' => 'alerts'])
    </div>
</div>
@endsection

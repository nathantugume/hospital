@extends('layouts.app')

@section('title', 'Pharmacy')
@section('header', 'Pharmacy')

@section('content')
<div class="flex flex-col gap-5">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2 text-gray-900">Pharmacy</h1>
            <p class="text-gray-500">Monitor medicine stock, expiry risk, and prescription activity.</p>
        </div>
        @can('create', App\Models\Medicine::class)<a href="{{ route('web.pharmacy.create') }}" class="inline-flex items-center justify-center rounded-md bg-primary text-white h-10 px-4 py-2 text-sm">+ Add medicine</a>@endcan
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <div class="flex justify-between items-center"><h2 class="text-sm font-medium">Catalogue</h2></div>
            <h2 class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['catalogue']) }}</h2>
            <p class="text-xs text-gray-500">Medicines tracked</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <div class="flex justify-between items-center"><h2 class="text-sm font-medium">Low stock</h2><span class="text-amber-500">&#9888;</span></div>
            <h2 class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['low_stock']) }}</h2>
            <p class="text-xs text-gray-500">At or below reorder level</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <div class="flex justify-between items-center"><h2 class="text-sm font-medium">Out of stock</h2><span class="text-red-500">&#9888;</span></div>
            <h2 class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['out_of_stock']) }}</h2>
            <p class="text-xs text-gray-500">Requires replenishment</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <div class="flex justify-between items-center"><h2 class="text-sm font-medium">Expiring soon</h2></div>
            <h2 class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['expiring']) }}</h2>
            <p class="text-xs text-gray-500">Within the next 90 days</p>
        </div>
    </div>

    <form method="GET" action="{{ route('web.pharmacy.index') }}" class="flex flex-col gap-4 md:flex-row">
        <div class="relative flex-1">
            <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search medicines..." class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 pl-8 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <select name="stock" class="flex h-10 w-full md:w-[180px] items-center rounded-md border border-gray-300 bg-background px-3 py-2 text-sm">
            <option value="">All medicines</option>
            <option value="low" @selected(request('stock') === 'low')>Low stock only</option>
        </select>
        <button type="submit" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 text-sm shadow-sm">Filter</button>
    </form>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-lg border bg-background shadow-sm lg:col-span-2">
            <div class="p-4 border-b flex items-center justify-between"><h2 class="text-xl font-semibold">{{ number_format($medicines->total()) }} medicines</h2><a href="{{ route('web.pharmacy.alerts') }}" class="text-sm text-indigo-600 hover:text-indigo-700">Stock alerts</a></div>
            <div class="overflow-x-auto">
                @if ($medicines->isEmpty())
                    <div class="text-center py-8 text-gray-500">No medicines match the selected filters.</div>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="h-12 px-4 text-left font-medium">Medicine</th>
                                <th class="h-12 px-4 text-left font-medium">Category</th>
                                <th class="h-12 px-4 text-left font-medium">Stock</th>
                                <th class="h-12 px-4 text-left font-medium">Price</th>
                                <th class="h-12 px-4 text-left font-medium">Expiry</th>
                                <th class="h-12 px-4 text-left font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medicines as $medicine)
                                @php
                                    $isOut = $medicine->stock <= 0;
                                    $isLow = ! $isOut && $medicine->stock <= $medicine->reorder_level;
                                    $statusLabel = $isOut ? 'Out of stock' : ($isLow ? 'Low stock' : 'In stock');
                                    $statusClasses = $isOut ? 'bg-red-500 text-white' : ($isLow ? 'bg-amber-500 text-white' : 'bg-green-500 text-white');
                                @endphp
                                <tr class="border-b hover:bg-gray-50 transition-colors">
                                    <td class="p-4 align-middle"><a class="font-medium text-primary" href="{{ route('web.pharmacy.show',$medicine) }}">{{ $medicine->name }}</a><div class="text-gray-500 text-xs">{{ $medicine->code }}{{ $medicine->generic_name ? ' · '.$medicine->generic_name : '' }}</div></td>
                                    <td class="p-4 align-middle">{{ $medicine->category ?: 'General' }}</td>
                                    <td class="p-4 align-middle">{{ number_format($medicine->stock) }} <span class="text-gray-500">/ {{ number_format($medicine->reorder_level) }}</span></td>
                                    <td class="p-4 align-middle font-medium">@money($medicine->selling_price)</td>
                                    <td class="p-4 align-middle">{{ optional($medicine->expiry)->format('d M Y') ?? '—' }}</td>
                                    <td class="p-4 align-middle"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $statusLabel }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            @include('partials.pagination', ['paginator' => $medicines, 'label' => 'medicines'])
        </div>
        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b flex items-center justify-between"><h2 class="text-xl font-semibold">Recent activity</h2><span class="text-sm text-gray-400 cursor-not-allowed" title="Coming soon">All prescriptions</span></div>
            <div class="overflow-x-auto">
                @if ($recentPrescriptions->isEmpty())
                    <div class="text-center py-8 text-gray-500">No prescriptions are available.</div>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="h-12 px-4 text-left font-medium">Prescription</th>
                                <th class="h-12 px-4 text-left font-medium">Patient</th>
                                <th class="h-12 px-4 text-left font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentPrescriptions as $prescription)
                                @php
                                    $statusClasses = match ($prescription->status ?? 'Active') {
                                        'Completed' => 'bg-green-100 text-green-700',
                                        'Cancelled' => 'bg-red-100 text-red-700',
                                        default => 'bg-blue-100 text-blue-700',
                                    };
                                @endphp
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-4 align-middle"><div class="font-medium">{{ $prescription->code }}</div><div class="text-gray-500 text-xs">{{ optional($prescription->date)->format('d M Y') }}</div></td>
                                    <td class="p-4 align-middle">{{ $prescription->patient?->full_name ?? 'Unknown patient' }}</td>
                                    <td class="p-4 align-middle"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $prescription->status ?? 'Active' }}</span></td>
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

@extends('layouts.app')

@section('title', 'Pharmacist Dashboard')
@section('header', 'Pharmacy dashboard')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Pharmacy dashboard</h1>
            <p class="text-gray-500">Stock health and prescriptions awaiting dispensing.</p>
        </div>
        <a href="{{ route('web.pharmacy.index') }}" class="inline-flex items-center justify-center rounded-md bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 text-sm shadow-sm">Open pharmacy</a>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium">Catalogue</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['catalogue']) }}</div>
            <p class="text-xs text-gray-500">Medicines tracked</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium">Low stock</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['low_stock']) }}</div>
            <p class="text-xs text-gray-500">At or below reorder level</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium">Out of stock</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['out_of_stock']) }}</div>
            <p class="text-xs text-gray-500">Requires replenishment</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium">Expiring soon</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['expiring']) }}</div>
            <p class="text-xs text-gray-500">Within the next 90 days</p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b flex items-center justify-between"><h2 class="text-lg font-semibold">Needs reordering</h2><a href="{{ route('web.pharmacy.index', ['stock' => 'low']) }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all</a></div>
            <div class="overflow-x-auto">
                @if ($lowStockMedicines->isEmpty())
                    <div class="text-center py-8 text-gray-500">Nothing is low on stock right now.</div>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr><th class="h-10 px-4 text-left">Medicine</th><th class="h-10 px-4 text-left">Stock</th><th class="h-10 px-4 text-left">Status</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($lowStockMedicines as $medicine)
                                @php
                                    $isOut = $medicine->stock <= 0;
                                @endphp
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3"><div class="font-medium">{{ $medicine->name }}</div><div class="text-xs text-gray-500">{{ $medicine->code }}</div></td>
                                    <td class="p-3">{{ number_format($medicine->stock) }} <span class="text-gray-500">/ {{ number_format($medicine->reorder_level) }}</span></td>
                                    <td class="p-3"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $isOut ? 'bg-red-500 text-white' : 'bg-amber-500 text-white' }}">{{ $isOut ? 'Out of stock' : 'Low stock' }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b flex items-center justify-between"><h2 class="text-lg font-semibold">Prescriptions to fill</h2><span class="text-sm text-gray-400 cursor-not-allowed" title="Coming soon">All prescriptions</span></div>
            <div class="overflow-x-auto">
                @if ($recentPrescriptions->isEmpty())
                    <div class="text-center py-8 text-gray-500">No prescriptions are awaiting action.</div>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr><th class="h-10 px-4 text-left">Prescription</th><th class="h-10 px-4 text-left">Patient</th><th class="h-10 px-4 text-left">Clinician</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($recentPrescriptions as $prescription)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 font-medium">{{ $prescription->code }}<div class="text-xs text-gray-500 font-normal">{{ optional($prescription->date)->format('d M Y') }}</div></td>
                                    <td class="p-3">{{ $prescription->patient?->full_name ?? 'Unknown patient' }}</td>
                                    <td class="p-3">{{ $prescription->doctor?->full_name ?? 'Unassigned' }}</td>
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

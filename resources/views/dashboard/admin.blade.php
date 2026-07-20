@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('header', 'Admin dashboard')

@section('content')
@php
    $firstName = str($user->name)->before(' ');
    $maxAppointmentStatus = max(1, (int) $appointmentStatus->max());
    $cards = [
        ['label' => 'Active patients', 'value' => number_format($stats['active_patients']), 'detail' => 'Current patient records'],
        ['label' => "Today's appointments", 'value' => number_format($stats['today_appointments']), 'detail' => 'Scheduled for today'],
        ['label' => 'Care team', 'value' => number_format($stats['staff']), 'detail' => 'Active staff profiles'],
        ['label' => 'Outstanding balance', 'value' => $currency->format($stats['outstanding']), 'detail' => 'Pending, partial or overdue'],
        ['label' => 'Collected this month', 'value' => $currency->format($stats['monthly_revenue']), 'detail' => 'Paid invoices'],
    ];
@endphp

<div class="flex flex-col gap-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Welcome back, {{ $firstName }}</h1>
            <p class="text-gray-500">System overview in {{ $currency->code() }} &middot; {{ now()->format('l, d F Y') }}</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('web.patients.index') }}" class="inline-flex items-center justify-center gap-2 rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 text-sm shadow-sm">+ Register patient</a>
            <a href="{{ route('web.appointments.index') }}" class="inline-flex items-center justify-center gap-2 rounded-md bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 text-sm shadow-sm">Open schedule</a>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-5">
        @foreach ($cards as $card)
            <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
                <h3 class="text-sm font-medium text-gray-500">{{ $card['label'] }}</h3>
                <div class="text-2xl xl:text-3xl font-bold mt-2">{{ $card['value'] }}</div>
                <p class="text-xs text-gray-500 mt-1">{{ $card['detail'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b flex items-center justify-between">
                <h2 class="text-lg font-semibold">Today's workload by status</h2>
                <a href="{{ route('web.appointments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">Open schedule</a>
            </div>
            <div class="p-4 space-y-4">
                @if ($appointmentStatus->isEmpty())
                    <div class="text-center py-8 text-gray-500">No appointments scheduled today.</div>
                @else
                    @foreach ($appointmentStatus as $status => $count)
                        <div class="space-y-1">
                            <div class="flex justify-between text-sm"><span class="font-medium text-gray-700">{{ $status }}</span><span class="text-gray-500">{{ number_format($count) }}</span></div>
                            <div class="h-2 rounded-full bg-gray-100"><div class="h-2 rounded-full bg-primary" style="width: {{ round(($count / $maxAppointmentStatus) * 100) }}%"></div></div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b flex items-center justify-between">
                <h2 class="text-lg font-semibold">Upcoming appointments</h2>
                <a href="{{ route('web.appointments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all</a>
            </div>
            <div class="overflow-x-auto">
                @if ($upcomingAppointments->isEmpty())
                    <div class="text-center py-8 text-gray-500">No upcoming appointments have been recorded.</div>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr><th class="h-10 px-4 text-left">When</th><th class="h-10 px-4 text-left">Patient</th><th class="h-10 px-4 text-left">Status</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($upcomingAppointments as $appointment)
                                @php
                                    $statusClasses = match ($appointment->status ?? 'Pending') {
                                        'Confirmed' => 'bg-blue-100 text-blue-700',
                                        'Completed' => 'bg-green-100 text-green-700',
                                        'Cancelled', 'No-Show' => 'bg-red-100 text-red-700',
                                        default => 'bg-amber-100 text-amber-700',
                                    };
                                @endphp
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3">{{ optional($appointment->date)->format('d M') }}<div class="text-xs text-gray-500">{{ $appointment->start_time }}</div></td>
                                    <td class="p-3">{{ $appointment->patient?->full_name ?? 'Patient record' }}<div class="text-xs text-gray-500">{{ $appointment->doctor?->full_name ?? 'Unassigned clinician' }}</div></td>
                                    <td class="p-3"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $appointment->status ?? 'Pending' }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <div class="rounded-lg border bg-background shadow-sm">
        <div class="p-4 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold">Recent invoices</h2>
            <a href="{{ route('web.invoices.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View billing</a>
        </div>
        <div class="overflow-x-auto">
            @if ($recentInvoices->isEmpty())
                <div class="text-center py-8 text-gray-500">No invoices have been recorded.</div>
            @else
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr><th class="h-10 px-4 text-left">Invoice</th><th class="h-10 px-4 text-left">Patient</th><th class="h-10 px-4 text-right">Amount</th><th class="h-10 px-4 text-right">Balance</th><th class="h-10 px-4 text-left">Status</th></tr>
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
                                <td class="p-3 font-medium">{{ $invoice->code }}<div class="text-xs text-gray-500 font-normal">{{ optional($invoice->date)->format('d M Y') }}</div></td>
                                <td class="p-3">{{ $invoice->patient?->full_name ?? 'Patient record' }}</td>
                                <td class="p-3 text-right">@money($invoice->amount)</td>
                                <td class="p-3 text-right">@money($invoice->balance)</td>
                                <td class="p-3"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $invoice->status ?? 'Pending' }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'My Dashboard')
@section('header', 'My care')

@section('content')
<div class="flex flex-col gap-6">
    <div>
        <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Welcome back, {{ str($user->name)->before(' ') }}</h1>
        <p class="text-gray-500">{{ now()->format('l, d F Y') }} &middot; Here's an overview of your care.</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Today</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['appointments']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Appointments today</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Active prescriptions</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['prescriptions']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Currently active</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Lab results</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['lab_results']) }}</div>
            <p class="text-xs text-gray-500 mt-1">On record</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Outstanding balance</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">@money($stats['outstanding'])</div>
            <p class="text-xs text-gray-500 mt-1">Across your invoices</p>
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
                        <tr><th class="h-10 px-4 text-left">Date</th><th class="h-10 px-4 text-left">Clinician</th><th class="h-10 px-4 text-left">Department</th><th class="h-10 px-4 text-left">Status</th></tr>
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
                                <td class="p-3">{{ optional($appointment->date)->format('d M Y') }}<div class="text-xs text-gray-500">{{ substr((string) $appointment->start_time, 0, 5) }}</div></td>
                                <td class="p-3">{{ $appointment->doctor?->full_name ?? 'Unassigned' }}</td>
                                <td class="p-3">{{ $appointment->department?->name ?? '—' }}</td>
                                <td class="p-3"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $appointment->status ?? 'Pending' }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b"><h2 class="text-lg font-semibold">Prescriptions</h2></div>
            <div class="overflow-x-auto">
                @if ($recentPrescriptions->isEmpty())
                    <div class="text-center py-8 text-gray-500">No prescriptions on record.</div>
                @else
                    <table class="w-full text-sm">
                        <tbody>
                            @foreach ($recentPrescriptions as $prescription)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3"><div class="font-medium">{{ $prescription->doctor?->full_name ?? 'Unknown clinician' }}</div><div class="text-xs text-gray-500">{{ optional($prescription->date)->format('d M Y') }}</div></td>
                                    <td class="p-3 text-right"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold bg-blue-100 text-blue-700">{{ $prescription->status ?? 'Active' }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b"><h2 class="text-lg font-semibold">Lab results</h2></div>
            <div class="overflow-x-auto">
                @if ($recentLabResults->isEmpty())
                    <div class="text-center py-8 text-gray-500">No lab results on record.</div>
                @else
                    <table class="w-full text-sm">
                        <tbody>
                            @foreach ($recentLabResults as $result)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3"><div class="font-medium">{{ $result->test_name }}</div><div class="text-xs text-gray-500">{{ optional($result->result_date)->format('d M Y') }}</div></td>
                                    <td class="p-3 text-right"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold bg-gray-100 text-gray-700">{{ $result->status ?? 'Pending' }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b flex items-center justify-between"><h2 class="text-lg font-semibold">Invoices</h2><a href="{{ route('web.invoices.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all</a></div>
            <div class="overflow-x-auto">
                @if ($invoices->isEmpty())
                    <div class="text-center py-8 text-gray-500">No invoices on record.</div>
                @else
                    <table class="w-full text-sm">
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
                                    <td class="p-3"><div class="font-medium">{{ $invoice->code }}</div><div class="text-xs text-gray-500">@money($invoice->balance) due</div></td>
                                    <td class="p-3 text-right"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $invoice->status ?? 'Pending' }}</span></td>
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

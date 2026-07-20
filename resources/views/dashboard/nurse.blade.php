@extends('layouts.app')

@section('title', 'Nurse Dashboard')
@section('header', 'Nurse station')

@section('content')
<div class="flex flex-col gap-6">
    <div>
        <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Welcome back, {{ str($user->name)->after('Nurse ')->before(' ') }}</h1>
        <p class="text-gray-500">{{ now()->format('l, d F Y') }} &middot; Department overview and today's care schedule.</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Today</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['today_appointments']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Appointments in your department</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Active patients</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['active_patients']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Across the hospital</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">On duty</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['on_duty_staff']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Active staff in department</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Urgent lab requests</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['urgent_lab_requests']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Awaiting results</p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b flex items-center justify-between">
                <h2 class="text-lg font-semibold">Today's appointments</h2>
                <a href="{{ route('web.appointments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all</a>
            </div>
            <div class="overflow-x-auto">
                @if ($todaysAppointments->isEmpty())
                    <div class="text-center py-8 text-gray-500">No appointments scheduled for today.</div>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr><th class="h-10 px-4 text-left">Time</th><th class="h-10 px-4 text-left">Patient</th><th class="h-10 px-4 text-left">Clinician</th><th class="h-10 px-4 text-left">Status</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($todaysAppointments as $appointment)
                                @php
                                    $statusClasses = match ($appointment->status ?? 'Pending') {
                                        'Confirmed' => 'bg-blue-100 text-blue-700',
                                        'Completed' => 'bg-green-100 text-green-700',
                                        'Cancelled', 'No-Show' => 'bg-red-100 text-red-700',
                                        default => 'bg-amber-100 text-amber-700',
                                    };
                                @endphp
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3">{{ substr((string) $appointment->start_time, 0, 5) }}</td>
                                    <td class="p-3 font-medium">{{ $appointment->patient?->full_name ?? 'Unknown patient' }}</td>
                                    <td class="p-3">{{ $appointment->doctor?->full_name ?? 'Unassigned' }}</td>
                                    <td class="p-3"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $appointment->status ?? 'Pending' }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b flex items-center justify-between">
                <h2 class="text-lg font-semibold">Recent patients</h2>
                <a href="{{ route('web.patients.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all</a>
            </div>
            <div class="overflow-x-auto">
                @if ($recentPatients->isEmpty())
                    <div class="text-center py-8 text-gray-500">No patient records yet.</div>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr><th class="h-10 px-4 text-left">Patient</th><th class="h-10 px-4 text-left">Code</th><th class="h-10 px-4 text-left">Status</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($recentPatients as $patient)
                                @php
                                    $statusClasses = match ($patient->status ?? 'Active') {
                                        'Active' => 'bg-green-100 text-green-800',
                                        'Discharged' => 'bg-gray-100 text-gray-700',
                                        default => 'bg-yellow-100 text-yellow-800',
                                    };
                                @endphp
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3"><div class="font-medium">{{ $patient->full_name }}</div><div class="text-xs text-gray-500">{{ $patient->gender ?? '—' }}</div></td>
                                    <td class="p-3">{{ $patient->code }}</td>
                                    <td class="p-3"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $patient->status ?? 'Active' }}</span></td>
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

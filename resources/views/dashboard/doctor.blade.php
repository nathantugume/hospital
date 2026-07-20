@extends('layouts.app')

@section('title', 'Doctor Dashboard')
@section('header', 'My dashboard')

@section('content')
<div class="flex flex-col gap-6">
    <div>
        <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Welcome back, {{ str($user->name)->after('Dr. ')->before(' ') }}</h1>
        <p class="text-gray-500">{{ now()->format('l, d F Y') }} &middot; Here's your clinical workload today.</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Today</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['today']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Appointments scheduled</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Upcoming</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['upcoming']) }}</div>
            <p class="text-xs text-gray-500 mt-1">From today onward</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">My patients</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['patients']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Seen under your care</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Active prescriptions</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['prescriptions']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Currently active</p>
        </div>
    </div>

    <div class="rounded-lg border bg-background shadow-sm">
        <div class="p-4 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold">Today's appointments</h2>
            <a href="{{ route('web.appointments.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">Open schedule</a>
        </div>
        <div class="overflow-x-auto">
            @if ($todaysAppointments->isEmpty())
                <div class="text-center py-8 text-gray-500">No appointments scheduled for today.</div>
            @else
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr><th class="h-10 px-4 text-left">Time</th><th class="h-10 px-4 text-left">Patient</th><th class="h-10 px-4 text-left">Department</th><th class="h-10 px-4 text-left">Type</th><th class="h-10 px-4 text-left">Status</th></tr>
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
                                <td class="p-3">{{ $appointment->department?->name ?? '—' }}</td>
                                <td class="p-3">{{ $appointment->type }}</td>
                                <td class="p-3"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $appointment->status ?? 'Pending' }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b"><h2 class="text-lg font-semibold">Recent prescriptions</h2></div>
            <div class="overflow-x-auto">
                @if ($recentPrescriptions->isEmpty())
                    <div class="text-center py-8 text-gray-500">No prescriptions written yet.</div>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr><th class="h-10 px-4 text-left">Prescription</th><th class="h-10 px-4 text-left">Patient</th><th class="h-10 px-4 text-left">Status</th></tr>
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
                                    <td class="p-3 font-medium">{{ $prescription->code }}<div class="text-xs text-gray-500 font-normal">{{ optional($prescription->date)->format('d M Y') }}</div></td>
                                    <td class="p-3">{{ $prescription->patient?->full_name ?? 'Unknown patient' }}</td>
                                    <td class="p-3"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $prescription->status ?? 'Active' }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b"><h2 class="text-lg font-semibold">Pending lab requests</h2></div>
            <div class="overflow-x-auto">
                @if ($pendingLabRequests->isEmpty())
                    <div class="text-center py-8 text-gray-500">No pending lab requests.</div>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr><th class="h-10 px-4 text-left">Request</th><th class="h-10 px-4 text-left">Patient</th><th class="h-10 px-4 text-left">Priority</th><th class="h-10 px-4 text-left">Status</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingLabRequests as $request)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 font-medium">{{ $request->code }}</td>
                                    <td class="p-3">{{ $request->patient?->full_name ?? 'Unknown patient' }}</td>
                                    <td class="p-3">{{ $request->priority }}</td>
                                    <td class="p-3"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold bg-yellow-100 text-yellow-700">{{ $request->status }}</span></td>
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

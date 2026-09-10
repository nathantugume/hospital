@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="flex flex-col gap-6">
    <div>
        <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Good {{ now()->format('A') === 'AM' ? 'morning' : 'afternoon' }}, {{ $user->name }}</h1>
        <p class="text-gray-500">{{ now()->format('l, d F Y') }} &middot; {{ $user->role_label }}</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-5">
        @php
        $cards = [
            ['label' => 'Patients', 'value' => number_format($stats['patients']), 'detail' => 'Registered records'],
            ['label' => "Today's appointments", 'value' => number_format($stats['appointments']), 'detail' => 'Scheduled today'],
            ['label' => 'Care team', 'value' => number_format($stats['staff']), 'detail' => 'Staff profiles'],
            ['label' => 'Outstanding balance', 'value' => app(\App\Services\CurrencyService::class)->format($stats['outstanding']), 'detail' => 'Pending or overdue'],
            ['label' => 'Medicines', 'value' => number_format($stats['medicines']), 'detail' => 'Inventory catalogue'],
        ];
        @endphp
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
                <h2 class="text-lg font-semibold">Upcoming appointments</h2>
                <a href="{{ route('web.appointments.index') }}" class="inline-flex items-center justify-center rounded-md bg-primary text-white hover:bg-primary/90 h-9 px-3 text-sm">Open schedule</a>
            </div>
            <div class="overflow-x-auto">
                @if ($upcomingAppointments->isEmpty())
                    <div class="text-center py-8 text-gray-500">No upcoming appointments have been recorded.</div>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr><th class="h-10 px-4 text-left">Date</th><th class="h-10 px-4 text-left">Patient</th><th class="h-10 px-4 text-left">Clinician</th><th class="h-10 px-4 text-left">Status</th></tr>
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
                                    <td class="p-3">{{ optional($appointment->date)->format('d M Y') }}<div class="text-xs text-gray-500">{{ $appointment->start_time }}</div></td>
                                    <td class="p-3">{{ $appointment->patient?->full_name ?? $user->patient?->full_name ?? 'Patient record' }}</td>
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
                @if (Route::has('web.patients.index') && ! $user->isPatient())
                    <a href="{{ route('web.patients.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700">View all</a>
                @endif
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

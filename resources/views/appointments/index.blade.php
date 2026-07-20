@extends('layouts.app')

@section('title', 'Appointments')
@section('header', 'Appointments')

@section('content')
<div class="flex flex-col gap-5">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">Appointments</h1>
            <p class="text-gray-500">Coordinate patient visits, clinicians, and daily care capacity.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ url('/appointment-calendar.html') }}" class="inline-flex items-center justify-center gap-2 rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 text-sm shadow-sm">Calendar view</a>
            <a href="{{ url('/add-appointment.html') }}" class="inline-flex items-center justify-center gap-2 rounded-md bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 text-sm shadow-sm">+ New appointment</a>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <div class="flex justify-between items-center"><h3 class="text-sm font-medium text-gray-500">Today</h3><span class="text-gray-400">&#9689;</span></div>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['today']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Scheduled for today</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <div class="flex justify-between items-center"><h3 class="text-sm font-medium text-gray-500">Upcoming</h3><span class="text-gray-400">&rarr;</span></div>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['upcoming']) }}</div>
            <p class="text-xs text-gray-500 mt-1">From today onward</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <div class="flex justify-between items-center"><h3 class="text-sm font-medium text-gray-500">Pending</h3><span class="inline-flex items-center rounded-full bg-yellow-100 text-yellow-700 px-2 py-0.5 text-xs font-semibold">!</span></div>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['pending']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Need confirmation</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <div class="flex justify-between items-center"><h3 class="text-sm font-medium text-gray-500">Completed</h3><span class="text-green-500">&check;</span></div>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['completed']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Completed visits</p>
        </div>
    </div>

    <div class="rounded-lg border bg-background shadow-sm">
        <div class="p-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 border-b">
            <div><h2 class="text-xl font-semibold tracking-tight">{{ number_format($appointments->total()) }} appointments</h2><div class="text-gray-500">View and manage scheduled appointments.</div></div>
            <form method="GET" action="{{ route('web.appointments.index') }}" class="flex flex-wrap gap-2">
                <div class="relative">
                    <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search patient..." class="h-10 rounded-md border border-gray-300 bg-background px-3 py-2 pl-8 text-sm w-full sm:w-[220px] focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
                <input type="date" name="date" value="{{ request('date') }}" class="h-10 rounded-md border border-gray-300 bg-background px-3 text-sm">
                <select name="status" class="h-10 rounded-md border border-gray-300 bg-background px-3 text-sm">
                    <option value="">All statuses</option>
                    @foreach (['Pending', 'Confirmed', 'Completed', 'Cancelled', 'No-Show'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 text-sm shadow-sm">Filter</button>
            </form>
        </div>
        <div class="p-4 overflow-x-auto">
            @if ($appointments->isEmpty())
                <div class="flex flex-col items-center py-12 text-gray-500">
                    <div class="rounded-full bg-gray-100 p-3"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line></svg></div>
                    <p class="mt-2 font-medium">No appointments found</p>
                    <p class="text-sm">Try adjusting your search or filters.</p>
                </div>
            @else
                <table class="w-full caption-bottom text-sm whitespace-nowrap">
                    <thead class="border-b bg-gray-50">
                        <tr>
                            <th class="h-12 px-4 text-left font-medium text-gray-600">Patient</th>
                            <th class="h-12 px-4 text-left font-medium text-gray-600">Clinician</th>
                            <th class="h-12 px-4 text-left font-medium text-gray-600">Department</th>
                            <th class="h-12 px-4 text-left font-medium text-gray-600">Date &amp; time</th>
                            <th class="h-12 px-4 text-left font-medium text-gray-600">Type</th>
                            <th class="h-12 px-4 text-left font-medium text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($appointments as $appointment)
                            @php
                                $statusClasses = match ($appointment->status ?? 'Pending') {
                                    'Confirmed' => 'bg-blue-100 text-blue-700 border border-blue-200',
                                    'Completed' => 'bg-green-100 text-green-700 border border-green-200',
                                    'Cancelled', 'No-Show' => 'bg-red-100 text-red-700 border border-red-200',
                                    default => 'bg-amber-100 text-amber-700 border border-amber-200',
                                };
                            @endphp
                            <tr class="border-b hover:bg-gray-50 transition-colors">
                                <td class="p-4 align-middle"><div><p class="font-medium text-gray-900">{{ $appointment->patient?->full_name ?? 'Unknown patient' }}</p><p class="text-sm text-gray-500">{{ $appointment->patient?->code ?? '—' }}</p></div></td>
                                <td class="p-4 align-middle text-gray-700">{{ $appointment->doctor?->full_name ?? 'Unassigned' }}</td>
                                <td class="p-4 align-middle text-gray-600">{{ $appointment->department?->name ?? '—' }}</td>
                                <td class="p-4 align-middle"><p>{{ optional($appointment->date)->format('d M Y') }}</p><p class="text-gray-500">{{ substr((string) $appointment->start_time, 0, 5) }}</p></td>
                                <td class="p-4 align-middle text-gray-600">{{ $appointment->type }}</td>
                                <td class="p-4 align-middle"><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $appointment->status ?? 'Pending' }}</div></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        @include('partials.pagination', ['paginator' => $appointments, 'label' => 'appointments'])
    </div>
</div>
@endsection

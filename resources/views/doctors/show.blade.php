@extends('layouts.app')

@section('title', 'Doctor Profile')
@section('header', 'Doctor profile')

@section('content')
<div class="flex flex-col gap-5">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('web.doctors.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground size-10" aria-label="Back to doctors">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold tracking-tight text-gray-900">Doctor Profile</h1>
                <p class="text-gray-500">View and manage doctor information.</p>
            </div>
        </div>
        <div class="flex gap-2">
            @can('manageAvailability', $doctor)
                <a href="{{ route('web.doctors.availability.index', $doctor) }}" class="inline-flex items-center gap-2 border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 rounded-md text-sm">Availability</a>
            @endcan
            @if (auth()->user()->isAdmin())
                <a href="{{ route('web.doctors.edit', $doctor) }}" class="inline-flex items-center gap-2 border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 rounded-md text-sm">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg> Edit doctor
                </a>
                @if ($doctor->status !== 'Inactive')
                    <form method="POST" action="{{ route('web.doctors.destroy', $doctor) }}" onsubmit="return confirm('Are you sure you want to deactivate this doctor?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="border border-red-200 text-red-600 bg-background hover:bg-red-50 h-10 px-4 rounded-md text-sm">Deactivate</button>
                    </form>
                @endif
            @endif
        </div>
    </div>

    <div class="grid gap-5 lg:grid-cols-[320px_1fr]">
        <div class="rounded-lg border border-gray-200 bg-background shadow-sm p-5 space-y-4 h-fit">
            <div class="flex flex-col items-center text-center gap-2">
                <span class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-2xl font-semibold text-indigo-700">{{ strtoupper(substr($doctor->first_name, 0, 1)) }}{{ strtoupper(substr($doctor->last_name, 0, 1)) }}</span>
                <h2 class="text-xl font-semibold tracking-tight">Dr. {{ $doctor->full_name }}</h2>
                <p class="text-gray-500">{{ $doctor->specialization }}@if($doctor->secondary_specialization) &middot; {{ $doctor->secondary_specialization }}@endif</p>
                @php
                    $statusClasses = match ($doctor->status) {
                        'Active' => 'bg-green-100 text-green-800 border border-green-200',
                        'On Leave' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                        default => 'bg-gray-100 text-gray-700 border border-gray-200',
                    };
                @endphp
                <span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClasses }}">{{ $doctor->status }}</span>
            </div>
            <div class="border-t pt-4 space-y-3 text-sm">
                <div class="flex items-start"><svg class="h-4 w-4 mr-2 mt-1 text-gray-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z" opacity="0"></path><path d="m4 4 8 8 8-8"></path><path d="M4 4h16v16H4V4Z"></path></svg><div><p class="font-medium mb-0.5">Email</p><p class="text-gray-500 break-all">{{ $doctor->email }}</p></div></div>
                <div class="flex items-start"><svg class="h-4 w-4 mr-2 mt-1 text-gray-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path></svg><div><p class="font-medium mb-0.5">Phone</p><p class="text-gray-500">{{ $doctor->phone }}</p></div></div>
                <div class="flex items-start"><svg class="h-4 w-4 mr-2 mt-1 text-gray-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg><div><p class="font-medium mb-0.5">Patients</p><p class="text-gray-500">{{ $patientCount }} active patients</p></div></div>
                <div class="flex items-start"><svg class="h-4 w-4 mr-2 mt-1 text-gray-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg><div><p class="font-medium mb-0.5">Experience</p><p class="text-gray-500">{{ $doctor->experience_years }} years</p></div></div>
                <div class="flex items-start"><svg class="h-4 w-4 mr-2 mt-1 text-gray-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path></svg><div><p class="font-medium mb-0.5">Department</p><p class="text-gray-500">{{ $doctor->department?->name ?? '—' }} &middot; {{ $doctor->position }}</p></div></div>
                @if ($doctor->license_number)
                    <div class="flex items-start"><svg class="h-4 w-4 mr-2 mt-1 text-gray-400 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6"></path></svg><div><p class="font-medium mb-0.5">License</p><p class="text-gray-500">{{ $doctor->license_number }}@if($doctor->license_expiry) &middot; expires {{ $doctor->license_expiry->format('d M Y') }}@endif</p></div></div>
                @endif
            </div>
        </div>

        <div class="space-y-4">
            <div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1 text-gray-500 gap-1">
                <button type="button" data-tab="overview" class="doctor-profile-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Overview</button>
                <button type="button" data-tab="appointments" class="doctor-profile-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Appointments</button>
                <button type="button" data-tab="performance" class="doctor-profile-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Performance</button>
            </div>

            {{-- Overview --}}
            <div data-tab-panel="overview" class="doctor-profile-panel space-y-4">
                <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
                    <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">About</h2></div>
                    <div class="p-4 space-y-3">
                        <p class="text-gray-500">{{ $doctor->qualifications ?: 'No qualifications on file yet.' }}</p>
                        @if ($doctor->education)
                            <div class="pt-2 border-t"><h4 class="text-sm font-medium mb-1">Education &amp; Certifications</h4><p class="text-gray-500 whitespace-pre-line">{{ $doctor->education }}</p></div>
                        @endif
                    </div>
                </div>
                <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
                    <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Today's Schedule</h2></div>
                    <div class="p-4">
                        @if ($todaysAppointments->isEmpty())
                            <p class="text-gray-500 text-sm">No appointments scheduled for today.</p>
                        @else
                            <div class="space-y-4">
                                @foreach ($todaysAppointments as $appointment)
                                    <div class="flex justify-between items-center">
                                        <div><span class="text-sm font-medium">{{ substr((string) $appointment->start_time, 0, 5) }}</span><div class="text-xs text-gray-500">{{ $appointment->type ?? 'Appointment' }}</div></div>
                                        <div class="text-right"><span class="text-sm font-medium">{{ $appointment->patient?->full_name ?? 'Unknown patient' }}</span><div class="text-xs {{ $appointment->status === 'Completed' ? 'text-green-500' : 'text-blue-500' }}">{{ $appointment->status ?? 'Scheduled' }}</div></div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Appointments --}}
            <div data-tab-panel="appointments" class="doctor-profile-panel space-y-4 hidden">
                <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
                    <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Appointment History</h2></div>
                    <div class="p-3 md:p-4">
                        @if ($appointments->isEmpty())
                            <p class="text-gray-500 text-sm p-2">No appointments recorded yet.</p>
                        @else
                            <div class="relative w-full overflow-auto">
                                <table class="w-full text-sm whitespace-nowrap">
                                    <thead class="border-b bg-gray-50"><tr><th class="h-10 px-3 text-left font-medium text-gray-600">Date</th><th class="h-10 px-3 text-left font-medium text-gray-600">Patient</th><th class="h-10 px-3 text-left font-medium text-gray-600">Type</th><th class="h-10 px-3 text-left font-medium text-gray-600">Status</th></tr></thead>
                                    <tbody>
                                        @foreach ($appointments as $appointment)
                                            <tr class="border-b hover:bg-gray-50">
                                                <td class="p-3">{{ optional($appointment->date)->format('d M Y') }}</td>
                                                <td class="p-3 font-medium">{{ $appointment->patient?->full_name ?? 'Unknown patient' }}</td>
                                                <td class="p-3">{{ $appointment->type ?? '—' }}</td>
                                                <td class="p-3">{{ $appointment->status ?? 'Scheduled' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Performance --}}
            <div data-tab-panel="performance" class="doctor-profile-panel space-y-4 hidden">
                <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
                    <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Performance Metrics</h2></div>
                    <div class="p-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div><p class="text-sm text-gray-500">Total appointments</p><p class="text-2xl font-bold">{{ number_format($performance['total_appointments']) }}</p></div>
                        <div><p class="text-sm text-gray-500">Completed</p><p class="text-2xl font-bold">{{ number_format($performance['completed']) }}</p></div>
                        <div><p class="text-sm text-gray-500">Cancelled / No-show</p><p class="text-2xl font-bold">{{ number_format($performance['cancelled']) }}</p></div>
                        <div><p class="text-sm text-gray-500">Upcoming</p><p class="text-2xl font-bold">{{ number_format($performance['upcoming']) }}</p></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const tabs = document.querySelectorAll('.doctor-profile-tab');
    const panels = document.querySelectorAll('.doctor-profile-panel');

    function activate(name) {
        tabs.forEach((tab) => {
            const isActive = tab.dataset.tab === name;
            tab.classList.toggle('bg-background', isActive);
            tab.classList.toggle('shadow-sm', isActive);
            tab.classList.toggle('text-gray-900', isActive);
            tab.classList.toggle('text-gray-500', !isActive);
        });
        panels.forEach((panel) => panel.classList.toggle('hidden', panel.dataset.tabPanel !== name));
    }

    tabs.forEach((tab) => tab.addEventListener('click', () => activate(tab.dataset.tab)));
    activate('overview');
})();
</script>
@endpush
@endsection

@extends('layouts.app')
@section('title', 'Appointment Details')
@section('content')
@php($statusOptions = ['Pending' => ['Confirmed', 'Cancelled'], 'Confirmed' => ['Completed', 'Cancelled', 'No-Show']][$appointment->status] ?? [])
<div class="flex flex-col gap-5">
    <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
        <div><a href="{{ route('web.appointments.index') }}" class="text-sm text-primary">← Appointments</a><h1 class="mt-2 text-2xl font-bold tracking-tight lg:text-3xl">Appointment Details</h1><p class="text-gray-500">{{ $appointment->patient?->full_name }} · {{ $appointment->date?->format('d M Y') }}</p></div>
        @can('update', $appointment)<a href="{{ route('web.appointments.edit', $appointment) }}" class="inline-flex h-10 items-center rounded-md bg-primary px-4 text-sm text-white">Reschedule or edit</a>@endcan
    </div>
    <div class="grid gap-5 lg:grid-cols-3">
        <section class="rounded-lg border bg-background shadow-sm lg:col-span-2">
            <dl class="grid gap-5 p-5 text-sm sm:grid-cols-2">
                <div><dt class="text-gray-500">Patient</dt><dd class="mt-1 font-medium">{{ $appointment->patient?->full_name }}</dd></div>
                <div><dt class="text-gray-500">Clinician</dt><dd class="mt-1 font-medium">{{ $appointment->doctor?->full_name ?? 'Unassigned' }}</dd></div>
                <div><dt class="text-gray-500">Date and time</dt><dd class="mt-1 font-medium">{{ $appointment->date?->format('d M Y') }} at {{ substr((string) $appointment->start_time, 0, 5) }}</dd></div>
                <div><dt class="text-gray-500">Type and duration</dt><dd class="mt-1 font-medium">{{ $appointment->type }} · {{ $appointment->duration }}</dd></div>
                <div><dt class="text-gray-500">Department</dt><dd class="mt-1 font-medium">{{ $appointment->department?->name ?? '—' }}</dd></div>
                <div><dt class="text-gray-500">Service</dt><dd class="mt-1 font-medium">{{ $appointment->service?->name ?? '—' }}</dd></div>
                <div class="sm:col-span-2"><dt class="text-gray-500">Notes</dt><dd class="mt-1 whitespace-pre-line">{{ $appointment->notes ?: 'No notes recorded.' }}</dd></div>
            </dl>
        </section>
        <aside class="rounded-lg border bg-background p-5 shadow-sm">
            <h2 class="font-semibold">Status</h2><p class="mt-2 text-lg font-medium">{{ $appointment->status }}</p>
            @can('update', $appointment)
                @if ($statusOptions)
                    <form method="POST" action="{{ route('web.appointments.status', $appointment) }}" class="mt-4 space-y-3">@csrf @method('PATCH')
                        <label class="text-sm font-medium">Change status<select name="status" class="mt-1 flex h-10 w-full rounded-md border border-gray-300 px-3 text-sm">@foreach($statusOptions as $status)<option value="{{ $status }}">{{ $status }}</option>@endforeach</select></label>
                        <button class="inline-flex h-10 items-center rounded-md border border-gray-300 px-3 text-sm">Update status</button>
                    </form>
                @else
                    <p class="mt-3 text-sm text-gray-500">This appointment is closed.</p>
                @endif
            @endcan
        </aside>
    </div>
</div>
@endsection

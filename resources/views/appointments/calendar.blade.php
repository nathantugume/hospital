@extends('layouts.app')

@section('title', 'Appointment Calendar')

@section('content')
<div class="flex flex-col gap-5">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div><h1 class="text-2xl font-bold tracking-tight lg:text-3xl">Appointment Calendar</h1><p class="text-gray-500">Review scheduled patient visits by month, week, or day.</p></div>
        @can('create', \App\Models\Appointment::class)<a href="{{ route('web.appointments.create') }}" class="inline-flex h-10 items-center justify-center rounded-md bg-primary px-4 text-sm text-white">+ New appointment</a>@endcan
    </div>

    <div class="rounded-lg border bg-background shadow-sm">
        <div class="flex flex-col gap-3 border-b p-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="inline-flex w-fit rounded-md border p-1">
                @foreach (['month' => 'Month', 'week' => 'Week', 'day' => 'Day'] as $mode => $label)
                    <a href="{{ route('web.appointments.calendar', ['view' => $mode, 'date' => $selectedDate->toDateString()]) }}" class="rounded px-3 py-1.5 text-sm {{ $view === $mode ? 'bg-primary text-white' : 'text-gray-600 hover:bg-gray-100' }}">{{ $label }}</a>
                @endforeach
            </div>
            <div class="flex items-center justify-between gap-3">
                <a class="rounded-md border px-3 py-2 text-sm" href="{{ route('web.appointments.calendar', ['view' => $view, 'date' => $previousDate->toDateString()]) }}">← Previous</a>
                <h2 class="min-w-44 text-center text-base font-semibold">
                    @if ($view === 'month') {{ $selectedDate->format('F Y') }}
                    @elseif ($view === 'week') {{ $rangeStart->format('d M') }} – {{ $rangeEnd->format('d M Y') }}
                    @else {{ $selectedDate->format('l, d M Y') }} @endif
                </h2>
                <a class="rounded-md border px-3 py-2 text-sm" href="{{ route('web.appointments.calendar', ['view' => $view, 'date' => $nextDate->toDateString()]) }}">Next →</a>
            </div>
        </div>

        @if ($view === 'day')
            <div class="divide-y">
                @forelse ($appointments->get($selectedDate->toDateString(), collect()) as $appointment)
                    <a href="{{ route('web.appointments.show', $appointment) }}" class="flex flex-col gap-1 p-4 hover:bg-gray-50 sm:flex-row sm:items-center sm:gap-5">
                        <span class="w-28 font-semibold text-primary">{{ substr((string) $appointment->start_time, 0, 5) }} – {{ substr((string) $appointment->end_time, 0, 5) }}</span>
                        <span class="font-medium">{{ $appointment->patient?->full_name }}</span>
                        <span class="text-sm text-gray-500">{{ $appointment->doctor?->full_name ?? 'Unassigned' }} · {{ $appointment->type }}</span>
                        <span class="text-sm sm:ml-auto">{{ $appointment->status }}</span>
                    </a>
                @empty
                    <p class="p-10 text-center text-sm text-gray-500">No appointments scheduled for this day.</p>
                @endforelse
            </div>
        @else
            <div class="overflow-x-auto"><div class="grid min-w-[760px] grid-cols-7 border-l border-t">
                @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)<div class="border-b border-r bg-gray-50 p-3 text-center text-xs font-medium text-gray-600">{{ $dayName }}</div>@endforeach
                @foreach ($days as $day)
                    <div class="border-b border-r p-2 {{ $view === 'month' ? 'min-h-32' : 'min-h-72' }} {{ $view === 'month' && $day->month !== $selectedDate->month ? 'bg-gray-50 text-gray-400' : '' }}">
                        <div class="mb-2 text-sm font-medium">{{ $view === 'week' ? $day->format('d M') : $day->day }}</div>
                        <div class="space-y-1">
                            @forelse ($appointments->get($day->toDateString(), collect()) as $appointment)
                                <a href="{{ route('web.appointments.show', $appointment) }}" class="block rounded bg-indigo-50 px-2 py-1 text-xs text-indigo-800 hover:bg-indigo-100"><span class="font-medium">{{ substr((string) $appointment->start_time, 0, 5) }}</span> {{ $appointment->patient?->full_name }}@if ($view === 'week')<span class="mt-0.5 block text-indigo-600">{{ $appointment->doctor?->full_name ?? 'Unassigned' }}</span>@endif</a>
                            @empty
                                @if ($view === 'week')<span class="text-xs text-gray-400">No visits</span>@endif
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div></div>
        @endif
    </div>
</div>
@endsection

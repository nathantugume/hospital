@extends('layouts.app')

@section('title', 'Doctor Availability')

@section('content')
@php($days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'])
<div class="flex flex-col gap-5">
    <div class="flex items-center gap-4">
        <a href="{{ route('web.doctors.show', $doctor) }}" class="inline-flex size-10 items-center justify-center rounded-md border border-gray-300" aria-label="Back to doctor profile">←</a>
        <div><h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Manage Availability</h1><p class="text-gray-500">Set recurring hours and date-specific availability for Dr. {{ $doctor->full_name }}.</p></div>
    </div>

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_360px]">
        <section class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b"><h2 class="text-xl font-semibold">Configured slots</h2><p class="text-gray-500">Appointments can only be scheduled inside these slots once any slot is configured.</p></div>
            <div class="p-4 overflow-x-auto">
                @if ($availability->isEmpty())
                    <p class="py-8 text-center text-sm text-gray-500">No availability has been configured. This clinician can currently be scheduled at any time.</p>
                @else
                    <table class="w-full text-sm whitespace-nowrap"><thead class="border-b bg-gray-50"><tr><th class="p-3 text-left font-medium text-gray-600">Schedule</th><th class="p-3 text-left font-medium text-gray-600">Hours</th><th class="p-3 text-left font-medium text-gray-600">State</th><th class="p-3 text-right font-medium text-gray-600">Action</th></tr></thead><tbody>
                    @foreach ($availability as $slot)
                        <tr class="border-b"><td class="p-3">{{ $slot->date?->format('d M Y') ?? $days[$slot->day_of_week] }}</td><td class="p-3">{{ substr((string) $slot->start_time, 0, 5) }} – {{ substr((string) $slot->end_time, 0, 5) }}</td><td class="p-3"><span class="rounded-full px-2 py-1 text-xs {{ $slot->is_available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ $slot->is_available ? 'Available' : 'Blocked' }}</span>@if($slot->notes)<p class="mt-1 whitespace-normal text-gray-500">{{ $slot->notes }}</p>@endif</td><td class="p-3 text-right"><form method="POST" action="{{ route('web.doctors.availability.destroy', [$doctor, $slot]) }}" onsubmit="return confirm('Remove this availability slot?');">@csrf @method('DELETE')<button class="text-red-600 hover:underline">Remove</button></form></td></tr>
                    @endforeach
                    </tbody></table>
                @endif
            </div>
        </section>

        <aside class="rounded-lg border bg-background shadow-sm h-fit"><div class="p-4 border-b"><h2 class="text-xl font-semibold">Add availability</h2><p class="text-gray-500">Use a weekday for recurring hours or a date for a one-off slot.</p></div><form method="POST" action="{{ route('web.doctors.availability.store', $doctor) }}" class="p-4 space-y-4">@csrf
            <label class="block space-y-1"><span class="text-sm font-medium">Recurring weekday</span><select name="day_of_week" class="flex h-10 w-full rounded-md border border-gray-300 px-3 text-sm"><option value="">Choose a weekday</option>@foreach($days as $index => $day)<option value="{{ $index }}" @selected((string) old('day_of_week') === (string) $index)>{{ $day }}</option>@endforeach</select></label>
            <div class="text-center text-xs text-gray-500">or</div>
            <label class="block space-y-1"><span class="text-sm font-medium">Specific date</span><input type="date" min="{{ today()->toDateString() }}" name="date" value="{{ old('date') }}" class="flex h-10 w-full rounded-md border border-gray-300 px-3 text-sm"></label>
            <div class="grid grid-cols-2 gap-3"><label class="block space-y-1"><span class="text-sm font-medium">Start</span><input required type="time" name="start_time" value="{{ old('start_time', '09:00') }}" class="flex h-10 w-full rounded-md border border-gray-300 px-3 text-sm"></label><label class="block space-y-1"><span class="text-sm font-medium">End</span><input required type="time" name="end_time" value="{{ old('end_time', '17:00') }}" class="flex h-10 w-full rounded-md border border-gray-300 px-3 text-sm"></label></div>
            <label class="flex items-center gap-2 text-sm"><input type="hidden" name="is_available" value="0"><input type="checkbox" name="is_available" value="1" @checked(old('is_available', true))> Available for appointments</label>
            <label class="block space-y-1"><span class="text-sm font-medium">Notes</span><textarea name="notes" maxlength="500" class="min-h-20 w-full rounded-md border border-gray-300 px-3 py-2 text-sm">{{ old('notes') }}</textarea></label>
            <button class="inline-flex h-10 w-full items-center justify-center rounded-md bg-primary px-4 text-sm text-white">Add slot</button>
        </form></aside>
    </div>

    <div class="grid gap-5 lg:grid-cols-[minmax(0,1fr)_360px]">
        <section class="rounded-lg border bg-background shadow-sm">
            <div class="border-b p-4"><h2 class="text-xl font-semibold">Leave and time off</h2><p class="text-gray-500">Approved entries prevent appointments from being scheduled on those dates.</p></div>
            <div class="overflow-x-auto p-4">
                <table class="w-full whitespace-nowrap text-sm">
                    <thead class="border-b bg-gray-50"><tr><th class="p-3 text-left">Type</th><th class="p-3 text-left">Dates</th><th class="p-3 text-left">Status</th><th class="p-3 text-right">Actions</th></tr></thead>
                    <tbody>
                    @forelse ($leaves as $leave)
                        <tr class="border-b">
                            <td class="p-3">{{ $leave->type }}@if($leave->reason)<p class="mt-1 max-w-sm whitespace-normal text-gray-500">{{ $leave->reason }}</p>@endif</td>
                            <td class="p-3">{{ $leave->start_date?->format('d M Y') }} – {{ $leave->end_date?->format('d M Y') }}<span class="block text-xs text-gray-500">{{ $leave->duration }}</span></td>
                            <td class="p-3">{{ $leave->status }}</td>
                            <td class="p-3 text-right">
                                @if (auth()->user()->isAdmin() && $leave->status === 'Pending')
                                    <form class="inline" method="POST" action="{{ route('web.doctors.leave.update', [$doctor, $leave->id]) }}">@csrf @method('PATCH')<button name="status" value="Approved" class="text-green-700">Approve</button><button name="status" value="Rejected" class="ml-2 text-red-600">Reject</button></form>
                                @endif
                                @if (auth()->user()->isAdmin() || $leave->status === 'Pending')
                                    <form class="ml-2 inline" method="POST" action="{{ route('web.doctors.leave.destroy', [$doctor, $leave->id]) }}" onsubmit="return confirm('Remove this time-off entry?');">@csrf @method('DELETE')<button class="text-red-600">Remove</button></form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="p-8 text-center text-gray-500">No leave or time-off entries recorded.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="h-fit rounded-lg border bg-background shadow-sm">
            <div class="border-b p-4"><h2 class="text-xl font-semibold">Add time off</h2><p class="text-gray-500">Doctor requests require approval; administrators approve immediately.</p></div>
            <form method="POST" action="{{ route('web.doctors.leave.store', $doctor) }}" class="space-y-4 p-4">@csrf
                <label class="block space-y-1"><span class="text-sm font-medium">Type</span><select name="type" required class="h-10 w-full rounded-md border px-3 text-sm">@foreach(['Annual','Sick','Emergency','Study','Other'] as $type)<option value="{{ $type }}" @selected(old('type') === $type)>{{ $type }}</option>@endforeach</select></label>
                <div class="grid grid-cols-2 gap-3"><label class="block space-y-1"><span class="text-sm font-medium">Start date</span><input required type="date" min="{{ today()->toDateString() }}" name="start_date" value="{{ old('start_date') }}" class="h-10 w-full rounded-md border px-3 text-sm"></label><label class="block space-y-1"><span class="text-sm font-medium">End date</span><input required type="date" min="{{ today()->toDateString() }}" name="end_date" value="{{ old('end_date') }}" class="h-10 w-full rounded-md border px-3 text-sm"></label></div>
                <label class="block space-y-1"><span class="text-sm font-medium">Reason</span><textarea name="reason" maxlength="1000" class="min-h-20 w-full rounded-md border px-3 py-2 text-sm">{{ old('reason') }}</textarea></label>
                <button class="inline-flex h-10 w-full items-center justify-center rounded-md bg-primary px-4 text-sm text-white">Save time off</button>
            </form>
        </aside>
    </div>
</div>
@endsection

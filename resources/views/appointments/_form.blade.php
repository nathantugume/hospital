@php
    $isEditing = $appointment->exists;
    $selectedDuration = (int) old('duration_minutes', $appointment->duration ? (int) $appointment->duration : 30);
@endphp
<form method="POST" action="{{ $isEditing ? route('web.appointments.update', $appointment) : route('web.appointments.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-5">
    @csrf
    @if ($isEditing) @method('PUT') @endif
    <section class="lg:col-span-2 space-y-5">
        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Appointment Details</h2><p class="text-gray-500">Choose a time and record the reason for the visit.</p></div>
            <div class="p-4 grid gap-5 sm:grid-cols-2">
                <label class="space-y-2"><span class="text-sm font-medium">Appointment type</span><input required name="type" value="{{ old('type', $appointment->type ?: 'Consultation') }}" class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 text-sm" maxlength="50"></label>
                <label class="space-y-2"><span class="text-sm font-medium">Date</span><input required type="date" min="{{ today()->toDateString() }}" name="date" value="{{ old('date', $appointment->date?->toDateString() ?: today()->toDateString()) }}" class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 text-sm"></label>
                <label class="space-y-2"><span class="text-sm font-medium">Start time</span><input required type="time" name="start_time" value="{{ old('start_time', $appointment->start_time ? substr((string) $appointment->start_time, 0, 5) : '09:00') }}" class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 text-sm"></label>
                <label class="space-y-2"><span class="text-sm font-medium">Duration</span><select required name="duration_minutes" class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 text-sm">@foreach ([15, 20, 30, 45, 60] as $minutes)<option value="{{ $minutes }}" @selected($selectedDuration === $minutes)>{{ $minutes }} minutes</option>@endforeach</select></label>
                <label class="space-y-2"><span class="text-sm font-medium">Department</span><select name="department_id" class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 text-sm"><option value="">Select department</option>@foreach ($departments as $department)<option value="{{ $department->id }}" @selected((int) old('department_id', $appointment->department_id) === $department->id)>{{ $department->name }}</option>@endforeach</select></label>
                <label class="space-y-2"><span class="text-sm font-medium">Service</span><select name="service_id" class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 text-sm"><option value="">Select service</option>@foreach ($services as $service)<option value="{{ $service->id }}" @selected((int) old('service_id', $appointment->service_id) === $service->id)>{{ $service->name }}</option>@endforeach</select></label>
                <label class="space-y-2 sm:col-span-2"><span class="text-sm font-medium">Reason and notes</span><textarea name="notes" class="flex min-h-[110px] w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm" maxlength="2000">{{ old('notes', $appointment->notes) }}</textarea></label>
                @if (! $isEditing)
                    <fieldset class="space-y-2 sm:col-span-2"><legend class="text-sm font-medium">Initial status</legend><div class="flex gap-5 text-sm"><label><input type="radio" name="status" value="Pending" @checked(old('status', 'Pending') === 'Pending')> Pending confirmation</label><label><input type="radio" name="status" value="Confirmed" @checked(old('status') === 'Confirmed')> Confirmed</label></div></fieldset>
                @else
                    <input type="hidden" name="status" value="{{ $appointment->status }}">
                @endif
            </div>
        </div>
        <div class="flex justify-end gap-3"><a href="{{ $isEditing ? route('web.appointments.show', $appointment) : route('web.appointments.index') }}" class="inline-flex items-center rounded-md border border-gray-300 px-4 h-10 text-sm">Cancel</a><button class="inline-flex items-center rounded-md bg-primary text-white px-4 h-10 text-sm">{{ $isEditing ? 'Save changes' : 'Schedule appointment' }}</button></div>
    </section>
    <aside class="space-y-5">
        <div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h2 class="text-xl font-semibold">Patient</h2><p class="text-gray-500">Choose the patient for this visit.</p></div><div class="p-4"><select required name="patient_id" class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 text-sm"><option value="">Select patient</option>@foreach ($patients as $patient)<option value="{{ $patient->id }}" @selected((int) old('patient_id', $appointment->patient_id) === $patient->id)>{{ $patient->full_name }} · {{ $patient->code }}</option>@endforeach</select></div></div>
        <div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h2 class="text-xl font-semibold">Clinician</h2><p class="text-gray-500">An unassigned appointment remains in the queue.</p></div><div class="p-4"><select name="doctor_id" class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 text-sm"><option value="">Unassigned</option>@foreach ($doctors as $doctor)<option value="{{ $doctor->id }}" @selected((int) old('doctor_id', $appointment->doctor_id) === $doctor->id)>Dr. {{ $doctor->full_name }}@if($doctor->specialization) · {{ $doctor->specialization }}@endif</option>@endforeach</select></div></div>
    </aside>
</form>

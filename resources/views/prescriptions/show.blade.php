@extends('layouts.app')
@section('title', $prescription->code)
@section('content')
<div class="space-y-5">
    <div class="flex flex-col justify-between gap-3 sm:flex-row">
        <div><a href="{{ route('web.prescriptions.index') }}" class="text-sm text-primary">← Prescriptions</a><h1 class="mt-2 text-2xl font-bold">{{ $prescription->code }}</h1><p class="text-gray-500">{{ $prescription->patient?->full_name }} · {{ $prescription->date?->format('d M Y') }}</p></div>
        @can('update', $prescription)<div class="flex gap-2">
            @if ($prescription->status === 'Active')<a href="{{ route('web.prescriptions.edit', $prescription) }}" class="rounded-md border px-4 py-2 text-sm">Edit</a><form method="POST" action="{{ route('web.prescriptions.discontinue', $prescription) }}">@csrf @method('PATCH')<button class="rounded-md border border-red-300 px-4 py-2 text-sm text-red-600">Discontinue</button></form>@endif
            @if ($prescription->refills > 0 && in_array($prescription->status, ['Active', 'Completed', 'Dispensed'], true))<form method="POST" action="{{ route('web.prescriptions.renew', $prescription) }}">@csrf<button class="rounded-md bg-primary px-4 py-2 text-sm text-white">Renew</button></form>@endif
        </div>@endcan
    </div>
    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-lg border bg-background p-4"><span class="text-sm text-gray-500">Status</span><p class="font-semibold">{{ $prescription->status }}</p></div>
        <div class="rounded-lg border bg-background p-4"><span class="text-sm text-gray-500">Prescriber</span><p class="font-semibold">{{ $prescription->doctor?->full_name ?? 'Unassigned' }}</p></div>
        <div class="rounded-lg border bg-background p-4"><span class="text-sm text-gray-500">Refills remaining</span><p class="font-semibold">{{ $prescription->refills }}</p></div>
    </div>
    <section class="rounded-lg border bg-background p-5">
        <h2 class="text-lg font-semibold">Medications</h2><div class="mt-3 divide-y">
        @foreach ($prescription->items as $item)<div class="py-3"><strong>{{ $item->medication }}</strong><p class="text-sm text-gray-600">{{ $item->dosage }} · {{ $item->frequency }} · {{ $item->route }}{{ $item->duration ? ' · '.$item->duration.' '.$item->duration_unit : '' }}</p>@if ($item->instructions)<p class="text-sm text-gray-500">{{ $item->instructions }}</p>@endif</div>@endforeach
        </div>@if ($prescription->notes)<div class="border-t pt-4 text-sm"><span class="text-gray-500">Notes</span><p>{{ $prescription->notes }}</p></div>@endif
    </section>
    @if ($prescription->status === 'Active' && auth()->user()->hasRole(['admin', 'super_admin', 'pharmacist']))
        <section class="rounded-lg border bg-background p-5">
            <h2 class="text-lg font-semibold">Dispense prescription</h2><p class="mt-1 text-sm text-gray-500">Select an active batch and enter the quantity supplied for every medication.</p>
            <form method="POST" action="{{ route('web.prescriptions.dispense', $prescription) }}" class="mt-4 space-y-4">@csrf
                @foreach ($prescription->items as $item)
                    <div class="grid gap-3 rounded-md border p-4 sm:grid-cols-[1fr_2fr_1fr] sm:items-end">
                        <div><span class="text-sm text-gray-500">Medication</span><p class="font-medium">{{ $item->medication }}</p></div>
                        <label class="text-sm">Batch<select name="dispense[{{ $item->id }}][batch_id]" required class="mt-1 w-full rounded-md border px-3 py-2"><option value="">Select batch</option>@foreach ($item->medicine?->batches ?? [] as $batch)<option value="{{ $batch->id }}" @selected(old("dispense.{$item->id}.batch_id") == $batch->id)>{{ $batch->batch_number }} · {{ $batch->quantity }} available · expires {{ $batch->expiry_date->format('d M Y') }}</option>@endforeach</select></label>
                        <label class="text-sm">Quantity<input type="number" min="1" name="dispense[{{ $item->id }}][quantity]" value="{{ old("dispense.{$item->id}.quantity", 1) }}" required class="mt-1 w-full rounded-md border px-3 py-2"></label>
                        @error("dispense.{$item->id}.batch_id")<p class="text-sm text-red-600 sm:col-start-2">{{ $message }}</p>@enderror
                        @error("dispense.{$item->id}.quantity")<p class="text-sm text-red-600 sm:col-start-3">{{ $message }}</p>@enderror
                    </div>
                @endforeach
                @error('dispense')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                <button class="rounded-md bg-primary px-4 py-2 text-sm font-medium text-white">Confirm dispensing</button>
            </form>
        </section>
    @endif
    @if ($prescription->dispenses->isNotEmpty())<section class="rounded-lg border bg-background p-5"><h2 class="text-lg font-semibold">Dispensing record</h2><p class="mt-2 text-sm text-gray-600">Dispensed {{ $prescription->dispenses->sum('quantity') }} unit(s) on {{ $prescription->dispenses->first()->dispensed_at->format('d M Y H:i') }}.</p></section>@endif
</div>
@endsection

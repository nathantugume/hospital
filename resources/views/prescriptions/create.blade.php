@extends('layouts.app')

@section('title', 'Create Prescription')
@section('header', 'Create prescription')

@section('content')
<div class="flex flex-col gap-5">
    <div class="flex items-center flex-wrap gap-4">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground size-10" aria-label="Back to dashboard">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Create Prescription</h1>
            <p class="text-gray-500">Create a new prescription for a patient.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('web.prescriptions.store') }}" class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        @csrf

        <div class="lg:col-span-2 space-y-5">
            <div class="rounded-lg border bg-background shadow-sm">
                <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Prescription details</h2><p class="text-gray-500">Enter the details for the new prescription.</p></div>
                <div class="p-4 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label for="date" class="text-sm font-medium">Prescription date</label>
                            <input id="date" name="date" type="date" value="{{ old('date', now()->toDateString()) }}" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                        </div>
                        <div class="space-y-2">
                            <label for="refills" class="text-sm font-medium">Refills allowed</label>
                            <input id="refills" name="refills" type="number" min="0" max="12" value="{{ old('refills', 0) }}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label for="notes" class="text-sm font-medium">Diagnosis / notes</label>
                        <textarea id="notes" name="notes" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Enter diagnosis or notes for the pharmacist">{{ old('notes') }}</textarea>
                    </div>

                    <div class="border-t"></div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium">Medications</h3>
                            <button type="button" id="addMedicationBtn" class="inline-flex items-center gap-2 h-9 rounded-md bg-primary text-white hover:bg-primary/90 px-3 py-1.5 text-sm">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5v14"></path></svg>Add medication
                            </button>
                        </div>
                        <div id="medicationsContainer" class="space-y-4"></div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('dashboard') }}" class="border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 rounded-md text-sm inline-flex items-center">Cancel</a>
                <button type="submit" class="bg-primary text-white hover:bg-primary/90 px-4 py-2 rounded-md text-sm">Create prescription</button>
            </div>
        </div>

        <div class="space-y-5">
            <div class="rounded-lg border bg-background shadow-sm">
                <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Patient</h2><p class="text-gray-500">Select a patient for this prescription.</p></div>
                <div class="p-4 space-y-2">
                    <select id="patient_id" name="patient_id" required class="w-full h-10 rounded-md border border-gray-300 bg-background px-3 text-sm" onchange="location.href='{{ route('web.prescriptions.create') }}?patient_id=' + this.value">
                        <option value="">Select a patient&hellip;</option>
                        @foreach ($patients as $patient)
                            <option value="{{ $patient->id }}" @selected((int) old('patient_id', $selectedPatientId) === $patient->id)>{{ $patient->full_name }} &middot; {{ $patient->code }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500">Selecting a patient reloads the page to show their prescription history.</p>
                </div>
            </div>

            <div class="rounded-lg border bg-background shadow-sm">
                <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Prescription history</h2><p class="text-gray-500">Recent prescriptions for this patient.</p></div>
                <div class="p-4 space-y-3">
                    @if (! $selectedPatientId)
                        <p class="text-sm text-gray-500">Select a patient to see their prescription history.</p>
                    @elseif ($recentPrescriptions->isEmpty())
                        <p class="text-sm text-gray-500">No previous prescriptions on record.</p>
                    @else
                        @foreach ($recentPrescriptions as $prescription)
                            <div class="rounded-md border p-3 text-sm">
                                <div class="flex items-center justify-between">
                                    <span class="font-medium">{{ $prescription->code }}</span>
                                    <span class="text-xs text-gray-500">{{ optional($prescription->date)->format('d M Y') }}</span>
                                </div>
                                <span class="text-xs text-gray-500">{{ $prescription->status }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>

<template id="medicationRowTemplate">
    <div class="medication-row rounded-md border p-4 space-y-3">
        <div class="flex items-center justify-between">
            <h4 class="text-sm font-semibold">Medication</h4>
            <button type="button" class="remove-medication-btn text-gray-400 hover:text-red-600 text-sm">Remove</button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div class="space-y-1">
                <label class="text-xs font-medium text-gray-500">Medicine</label>
                <select name="__NAME__[medicine_id]" class="medicine-select w-full h-10 rounded-md border border-gray-300 px-3 text-sm">
                    <option value="">Not in catalogue</option>
                    @foreach ($medicines as $medicine)
                        <option value="{{ $medicine->id }}" data-name="{{ $medicine->name }}">{{ $medicine->name }}{{ $medicine->generic_name ? ' · '.$medicine->generic_name : '' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-1">
                <label class="text-xs font-medium text-gray-500">Medication name</label>
                <input type="text" name="__NAME__[medication]" required class="medication-name-input w-full h-10 rounded-md border border-gray-300 px-3 text-sm" placeholder="e.g. Amoxicillin 500mg">
            </div>
            <div class="space-y-1">
                <label class="text-xs font-medium text-gray-500">Dosage</label>
                <input type="text" name="__NAME__[dosage]" required class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm" placeholder="e.g. 500mg">
            </div>
            <div class="space-y-1">
                <label class="text-xs font-medium text-gray-500">Frequency</label>
                <input type="text" name="__NAME__[frequency]" required class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm" placeholder="e.g. Twice daily">
            </div>
            <div class="space-y-1">
                <label class="text-xs font-medium text-gray-500">Route</label>
                <select name="__NAME__[route]" class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm">
                    <option>Oral</option>
                    <option>IV</option>
                    <option>IM</option>
                    <option>Topical</option>
                    <option>Subcutaneous</option>
                    <option>Inhalation</option>
                    <option>Rectal</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="space-y-1">
                    <label class="text-xs font-medium text-gray-500">Duration</label>
                    <input type="number" min="1" name="__NAME__[duration]" class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm" placeholder="7">
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-gray-500">Unit</label>
                    <select name="__NAME__[duration_unit]" class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm">
                        <option>Days</option>
                        <option>Weeks</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="space-y-1">
            <label class="text-xs font-medium text-gray-500">Instructions</label>
            <input type="text" name="__NAME__[instructions]" class="w-full h-10 rounded-md border border-gray-300 px-3 text-sm" placeholder="e.g. Take with food">
        </div>
    </div>
</template>

@push('scripts')
<script>
(function () {
    const container = document.getElementById('medicationsContainer');
    const template = document.getElementById('medicationRowTemplate');
    let rowIndex = 0;

    function addRow() {
        const html = template.innerHTML.replaceAll('__NAME__', `items[${rowIndex}]`);
        const wrapper = document.createElement('div');
        wrapper.innerHTML = html.trim();
        const row = wrapper.firstElementChild;

        row.querySelector('.remove-medication-btn').addEventListener('click', () => {
            if (container.children.length > 1) {
                row.remove();
            }
        });

        row.querySelector('.medicine-select').addEventListener('change', (event) => {
            const option = event.target.selectedOptions[0];
            const nameInput = row.querySelector('.medication-name-input');
            if (option && option.dataset.name && ! nameInput.value) {
                nameInput.value = option.dataset.name;
            }
        });

        container.appendChild(row);
        rowIndex += 1;
    }

    document.getElementById('addMedicationBtn').addEventListener('click', addRow);
    addRow();
})();
</script>
@endpush
@endsection

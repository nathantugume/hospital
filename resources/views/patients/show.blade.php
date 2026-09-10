@extends('layouts.app')

@section('title', $patient->full_name)
@section('header', 'Patient details')

@section('content')
@php
    $statusClasses = match ($patient->status ?? 'Active') {
        'Active' => 'bg-green-500 text-white',
        'Discharged' => 'bg-gray-500 text-white',
        default => 'bg-yellow-500 text-white',
    };
    $canManage = auth()->user()->hasRole(['super_admin', 'admin', 'receptionist', 'nurse', 'doctor']);
@endphp
<div class="flex flex-col gap-5">
    <div class="flex items-center gap-4 flex-wrap justify-between">
        <div class="flex items-center gap-4 flex-wrap">
            <a href="{{ route('web.patients.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 shadow-sm bg-background hover:bg-accent hover:text-accent-foreground size-10">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Patient Details</h1>
                <p class="text-gray-500">View and manage patient information.</p>
            </div>
        </div>
        @if ($canManage)
            <a href="{{ route('web.patients.edit', $patient) }}" class="inline-flex items-center justify-center gap-2 rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 text-sm shadow-sm">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path></svg>Edit patient
            </a>
        @endif
    </div>

    <div class="flex flex-col lg:flex-row gap-5">
        {{-- Profile card --}}
        <div class="rounded-lg border bg-background shadow-sm lg:w-1/3">
            <div class="p-4 md:p-6 pb-2">
                <h2 class="text-xl font-semibold tracking-tight">Patient Profile</h2>
                <div class="text-sm text-gray-500">Patient ID: {{ $patient->code }}</div>
            </div>
            <div class="p-4 md:p-6 space-y-6">
                <div class="flex flex-col items-center text-center">
                    <span class="relative flex shrink-0 overflow-hidden rounded-full h-24 w-24 mb-4 bg-indigo-100 items-center justify-center text-2xl font-semibold text-indigo-700">{{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}</span>
                    <h2 class="text-xl font-bold">{{ $patient->full_name }}</h2>
                    <p class="text-gray-500">{{ optional($patient->date_of_birth)->age }} years &middot; {{ $patient->gender }}</p>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $patient->status ?? 'Active' }}</span>
                        @if ($patient->blood_type)
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold border border-blue-500 text-blue-500 bg-white">{{ $patient->blood_type }}</span>
                        @endif
                    </div>
                </div>
                <div class="border-t"></div>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <svg class="shrink-0 h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <div class="space-y-1.5">
                            <h3 class="font-medium mb-2">Personal Information</h3>
                            <p class="text-sm">Date of Birth: {{ optional($patient->date_of_birth)->format('d M Y') ?? '—' }}</p>
                            <p class="text-sm">Phone: {{ $patient->phone ?? '—' }}</p>
                            <p class="text-sm">Email: {{ $patient->email ?? '—' }}</p>
                            <p class="text-sm">Address: {{ collect([$patient->address, $patient->city, $patient->district])->filter()->implode(', ') ?: '—' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="shrink-0 h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg>
                        <div>
                            <h3 class="font-medium mb-2">Medical Information</h3>
                            <div class="text-sm space-y-1.5">
                                <p>Blood Type: {{ $patient->blood_type ?: '—' }}</p>
                                <p>Allergies: {{ $patient->allergies ?: 'None recorded' }}</p>
                                <p>Conditions: {{ $patient->chronic_conditions ?: $patient->condition ?: 'None recorded' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="shrink-0 h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"></path><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path></svg>
                        <div class="space-y-1.5">
                            <h3 class="font-medium mb-2">Insurance Information</h3>
                            @if ($patient->primaryInsurance)
                                <p class="text-sm">Provider: {{ $patient->primaryInsurance->provider }}</p>
                                <p class="text-sm">Policy Number: {{ $patient->primaryInsurance->policy_number ?: '—' }}</p>
                            @else
                                <p class="text-sm text-gray-500">Self-pay &mdash; no insurance on file.</p>
                            @endif
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <svg class="shrink-0 h-5 w-5 text-gray-400 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <div class="space-y-1.5">
                            <h3 class="font-medium mb-2">Emergency Contact</h3>
                            @if ($patient->emergency_contact_name)
                                <p class="text-sm">Name: {{ $patient->emergency_contact_name }}</p>
                                <p class="text-sm">Relationship: {{ $patient->emergency_contact_relationship ?: '—' }}</p>
                                <p class="text-sm">Phone: {{ $patient->emergency_contact_phone ?: '—' }}</p>
                            @else
                                <p class="text-sm text-gray-500">No emergency contact on file.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="border-t"></div>
                <div class="flex justify-between text-sm text-gray-500">
                    <span>Registered on: {{ $patient->created_at->format('d M Y') }}</span>
                    <span>Last updated: {{ $patient->updated_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="flex-1">
            <div class="space-y-4">
                <div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1 text-gray-500 w-full grid grid-cols-2 md:grid-cols-5">
                    <button type="button" data-tab="overview" class="patient-detail-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Overview</button>
                    <button type="button" data-tab="appointments" class="patient-detail-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Appointments</button>
                    <button type="button" data-tab="prescriptions" class="patient-detail-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Prescriptions</button>
                    <button type="button" data-tab="lab-results" class="patient-detail-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Lab Results</button>
                    <button type="button" data-tab="billing" class="patient-detail-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Billing</button>
                </div>

                <div data-tab-panel="overview" class="patient-detail-panel">
                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-lg border bg-background shadow-sm p-4">
                            <h3 class="text-sm font-medium text-gray-500">Upcoming appointment</h3>
                            @php $nextAppointment = $patient->appointments->firstWhere('date', '>=', today()); @endphp
                            @if ($nextAppointment)
                                <p class="mt-2 font-semibold">{{ optional($nextAppointment->date)->format('d M Y') }} with {{ $nextAppointment->doctor?->full_name ?? 'Unassigned' }}</p>
                            @else
                                <p class="mt-2 text-gray-500">No upcoming appointments.</p>
                            @endif
                        </div>
                        <div class="rounded-lg border bg-background shadow-sm p-4">
                            <h3 class="text-sm font-medium text-gray-500">Outstanding balance</h3>
                            <p class="mt-2 font-semibold">@money($patient->invoices->whereIn('status', ['Pending', 'Partial', 'Overdue'])->sum('balance'))</p>
                        </div>
                        <div class="rounded-lg border bg-background shadow-sm p-4">
                            <h3 class="text-sm font-medium text-gray-500">Active prescriptions</h3>
                            <p class="mt-2 font-semibold">{{ $patient->prescriptions->where('status', 'Active')->count() }}</p>
                        </div>
                        <div class="rounded-lg border bg-background shadow-sm p-4">
                            <h3 class="text-sm font-medium text-gray-500">Lab results on file</h3>
                            <p class="mt-2 font-semibold">{{ $patient->labResults->count() }}</p>
                        </div>
                    </div>
                </div>

                <div data-tab-panel="appointments" class="patient-detail-panel hidden">
                    <div class="rounded-lg border bg-background shadow-sm overflow-x-auto">
                        @if ($patient->appointments->isEmpty())
                            <div class="text-center py-8 text-gray-500">No appointments on record.</div>
                        @else
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 border-b"><tr><th class="h-10 px-4 text-left">Date</th><th class="h-10 px-4 text-left">Clinician</th><th class="h-10 px-4 text-left">Department</th><th class="h-10 px-4 text-left">Status</th></tr></thead>
                                <tbody>
                                    @foreach ($patient->appointments as $appointment)
                                        @php
                                            $statusClasses = match ($appointment->status ?? 'Pending') {
                                                'Confirmed' => 'bg-blue-100 text-blue-700', 'Completed' => 'bg-green-100 text-green-700',
                                                'Cancelled', 'No-Show' => 'bg-red-100 text-red-700', default => 'bg-amber-100 text-amber-700',
                                            };
                                        @endphp
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="p-3">{{ optional($appointment->date)->format('d M Y') }}</td>
                                            <td class="p-3">{{ $appointment->doctor?->full_name ?? 'Unassigned' }}</td>
                                            <td class="p-3">{{ $appointment->department?->name ?? '—' }}</td>
                                            <td class="p-3"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $appointment->status ?? 'Pending' }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

                <div data-tab-panel="prescriptions" class="patient-detail-panel hidden">
                    <div class="rounded-lg border bg-background shadow-sm overflow-x-auto">
                        @if ($patient->prescriptions->isEmpty())
                            <div class="text-center py-8 text-gray-500">No prescriptions on record.</div>
                        @else
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 border-b"><tr><th class="h-10 px-4 text-left">Prescription</th><th class="h-10 px-4 text-left">Prescribed by</th><th class="h-10 px-4 text-left">Date</th><th class="h-10 px-4 text-left">Status</th></tr></thead>
                                <tbody>
                                    @foreach ($patient->prescriptions as $prescription)
                                        @php
                                            $statusClasses = match ($prescription->status ?? 'Active') {
                                                'Completed' => 'bg-green-100 text-green-700', 'Cancelled' => 'bg-red-100 text-red-700', default => 'bg-blue-100 text-blue-700',
                                            };
                                        @endphp
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="p-3 font-medium">{{ $prescription->code }}</td>
                                            <td class="p-3">{{ $prescription->doctor?->full_name ?? 'Unassigned' }}</td>
                                            <td class="p-3">{{ optional($prescription->date)->format('d M Y') }}</td>
                                            <td class="p-3"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $prescription->status ?? 'Active' }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

                <div data-tab-panel="lab-results" class="patient-detail-panel hidden">
                    <div class="rounded-lg border bg-background shadow-sm overflow-x-auto">
                        @if ($patient->labResults->isEmpty())
                            <div class="text-center py-8 text-gray-500">No lab results on record.</div>
                        @else
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 border-b"><tr><th class="h-10 px-4 text-left">Test</th><th class="h-10 px-4 text-left">Date</th><th class="h-10 px-4 text-left">Flag</th><th class="h-10 px-4 text-left">Status</th></tr></thead>
                                <tbody>
                                    @foreach ($patient->labResults as $result)
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="p-3 font-medium">{{ $result->test_name }}</td>
                                            <td class="p-3">{{ optional($result->result_date)->format('d M Y') }}</td>
                                            <td class="p-3">{{ $result->flag ?: 'Normal' }}</td>
                                            <td class="p-3"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold bg-gray-100 text-gray-700">{{ $result->status ?? 'Pending' }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

                <div data-tab-panel="billing" class="patient-detail-panel hidden">
                    <div class="rounded-lg border bg-background shadow-sm overflow-x-auto">
                        @if ($patient->invoices->isEmpty())
                            <div class="text-center py-8 text-gray-500">No invoices on record.</div>
                        @else
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 border-b"><tr><th class="h-10 px-4 text-left">Invoice</th><th class="h-10 px-4 text-left">Date</th><th class="h-10 px-4 text-right">Amount</th><th class="h-10 px-4 text-right">Balance</th><th class="h-10 px-4 text-left">Status</th></tr></thead>
                                <tbody>
                                    @foreach ($patient->invoices as $invoice)
                                        @php
                                            $statusClasses = match ($invoice->status ?? 'Pending') {
                                                'Paid' => 'bg-green-100 text-green-700', 'Partial' => 'bg-amber-100 text-amber-700',
                                                'Overdue', 'Cancelled' => 'bg-red-100 text-red-700', default => 'bg-gray-100 text-gray-700',
                                            };
                                        @endphp
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="p-3 font-medium">{{ $invoice->code }}</td>
                                            <td class="p-3">{{ optional($invoice->date)->format('d M Y') }}</td>
                                            <td class="p-3 text-right">@money($invoice->amount)</td>
                                            <td class="p-3 text-right">@money($invoice->balance)</td>
                                            <td class="p-3"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $invoice->status ?? 'Pending' }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
(function () {
    const tabs = document.querySelectorAll('.patient-detail-tab');
    const panels = document.querySelectorAll('.patient-detail-panel');

    function activate(name) {
        tabs.forEach((tab) => {
            const isActive = tab.dataset.tab === name;
            tab.classList.toggle('bg-background', isActive);
            tab.classList.toggle('shadow-sm', isActive);
            tab.classList.toggle('text-indigo-700', isActive);
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

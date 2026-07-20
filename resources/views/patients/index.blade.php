@extends('layouts.app')

@section('title', 'Patients')
@section('header', 'Patient records')

@section('content')
<div class="flex flex-col gap-5">
    <div class="flex flex-col md:flex-row justify-between gap-4">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">Patients</h1>
            <p class="text-gray-500">Manage your patients and their medical records.</p>
        </div>
        <span class="inline-flex items-center justify-center gap-2 rounded-md border border-dashed border-gray-300 text-gray-400 h-10 px-4 py-2 text-sm cursor-not-allowed" title="Coming soon">+ Add Patient <span class="text-[10px] uppercase tracking-wide bg-gray-100 text-gray-400 px-1.5 py-0.5 rounded-full">Soon</span></span>
    </div>

    <div class="rounded-lg border bg-background shadow-sm">
        <div class="p-4 space-y-4 border-b">
            <div class="flex flex-col md:flex-row justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold">Patients List</h2>
                    <div class="text-gray-500">A list of all patients in your clinic with their details.</div>
                </div>
                <form method="GET" action="{{ route('web.patients.index') }}" class="flex flex-col sm:flex-row gap-2">
                    <div class="relative">
                        <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search patients..." class="h-10 rounded-md border border-gray-300 bg-background px-3 py-2 text-sm pl-8 w-full sm:w-[220px] focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                    <select name="status" class="h-10 rounded-md border border-gray-300 bg-background px-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="">All statuses</option>
                        @foreach (['Active', 'Inactive', 'Discharged'] as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 text-sm shadow-sm">Filter</button>
                </form>
            </div>
        </div>
        <div class="p-3 md:p-4">
            @if ($patients->isEmpty())
                <div class="flex flex-col items-center py-10 text-gray-500">
                    <div class="rounded-full bg-gray-100 p-3"><svg class="h-6 w-6 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg></div>
                    <h3 class="text-lg font-semibold mt-2 text-gray-900">No patients found</h3>
                    <p class="text-sm">Try adjusting your search or filters.</p>
                </div>
            @else
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm whitespace-nowrap">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="p-4 text-left font-semibold text-gray-700">Name</th>
                                <th class="p-4 text-left font-semibold text-gray-700">Code</th>
                                <th class="p-4 text-left font-semibold text-gray-700">Age/Gender</th>
                                <th class="p-4 text-left font-semibold text-gray-700">Contact</th>
                                <th class="p-4 text-left font-semibold text-gray-700">Last Visit</th>
                                <th class="p-4 text-left font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patients as $patient)
                                @php
                                    $statusClasses = match ($patient->status ?? 'Active') {
                                        'Active' => 'bg-green-100 text-green-800 border border-green-200',
                                        'Discharged' => 'bg-gray-100 text-gray-700 border border-gray-200',
                                        default => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                    };
                                @endphp
                                <tr class="border-b hover:bg-gray-50 transition-colors">
                                    <td class="p-4"><div class="flex items-center gap-3"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full bg-indigo-100 items-center justify-center font-medium text-indigo-700">{{ strtoupper(substr($patient->full_name, 0, 1)) }}</span><span class="font-medium text-gray-900">{{ $patient->full_name }}</span></div></td>
                                    <td class="p-4 text-gray-600">{{ $patient->code }}</td>
                                    <td class="p-4 text-gray-600">{{ optional($patient->date_of_birth)->age ?? '—' }} &middot; {{ $patient->gender }}</td>
                                    <td class="p-4 text-gray-600">{{ $patient->phone ?? $patient->email ?? '—' }}</td>
                                    <td class="p-4 text-gray-600">{{ optional($patient->last_visit)->format('d M Y') ?? '—' }}</td>
                                    <td class="p-4"><span class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClasses }}">{{ $patient->status ?? 'Active' }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @include('partials.pagination', ['paginator' => $patients, 'label' => 'patient records'])
    </div>
</div>
@endsection

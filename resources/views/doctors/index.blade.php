@extends('layouts.app')

@section('title', 'Doctors')
@section('header', 'Doctors')

@section('content')
<div class="flex flex-col gap-5">
    <div class="flex flex-col md:flex-row justify-between gap-4">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">Doctors</h1>
            <p class="text-gray-500">Manage doctors, specializations, and clinical staff accounts.</p>
        </div>
        @if (auth()->user()->isAdmin())
            <a href="{{ route('web.doctors.create') }}" class="inline-flex items-center justify-center gap-2 rounded-md bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 text-sm shadow-sm">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg> Add Doctor
            </a>
        @endif
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Total doctors</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['total']) }}</div>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Active</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['active']) }}</div>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">On leave</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['on_leave']) }}</div>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <h3 class="text-sm font-medium text-gray-500">Departments</h3>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['departments']) }}</div>
        </div>
    </div>

    <div class="rounded-lg border bg-background shadow-sm">
        <div class="p-4 space-y-4 border-b">
            <div class="flex flex-col md:flex-row justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold">Doctors List</h2>
                    <div class="text-gray-500">Search and filter doctors by status, specialty, and experience.</div>
                </div>
                <form method="GET" action="{{ route('web.doctors.index') }}" class="flex flex-col sm:flex-row flex-wrap gap-2">
                    <div class="relative">
                        <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search doctors..." class="h-10 rounded-md border border-gray-300 bg-background px-3 py-2 text-sm pl-8 w-full sm:w-[220px] focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                    <select name="status" class="h-10 rounded-md border border-gray-300 bg-background px-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="">All statuses</option>
                        @foreach (['Active', 'On Leave', 'Inactive'] as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    <select name="specialty" class="h-10 rounded-md border border-gray-300 bg-background px-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="">All specialties</option>
                        @foreach ($specialties as $specialty)
                            <option value="{{ $specialty }}" @selected(request('specialty') === $specialty)>{{ $specialty }}</option>
                        @endforeach
                    </select>
                    <select name="experience" class="h-10 rounded-md border border-gray-300 bg-background px-3 text-sm focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                        <option value="">Any experience</option>
                        <option value="0-5" @selected(request('experience') === '0-5')>0-5 years</option>
                        <option value="5-10" @selected(request('experience') === '5-10')>5-10 years</option>
                        <option value="10-15" @selected(request('experience') === '10-15')>10-15 years</option>
                        <option value="15+" @selected(request('experience') === '15+')>15+ years</option>
                    </select>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 text-sm shadow-sm">Apply Filters</button>
                </form>
            </div>
        </div>
        <div class="p-3 md:p-4">
            @if ($doctors->isEmpty())
                <div class="flex flex-col items-center py-10 text-gray-500">
                    <div class="rounded-full bg-gray-100 p-3"><svg class="h-6 w-6 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg></div>
                    <h3 class="text-lg font-semibold mt-2 text-gray-900">No doctors found</h3>
                    <p class="text-sm">Try adjusting your filters or search.</p>
                </div>
            @else
                <div class="relative w-full overflow-auto">
                    <table class="w-full caption-bottom text-sm whitespace-nowrap">
                        <thead class="[&_tr]:border-b">
                            <tr class="border-b hover:bg-muted/50">
                                <th class="h-12 px-4 text-left align-middle font-medium text-gray-600">Name</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-gray-600">Specialty</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-gray-600">Status</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-gray-600">Patients</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-gray-600">Experience</th>
                                <th class="h-12 px-4 text-left align-middle font-medium text-gray-600">Contact</th>
                                <th class="h-12 px-4 text-right align-middle font-medium text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($doctors as $doctor)
                                @php
                                    $statusClasses = match ($doctor->status) {
                                        'Active' => 'bg-green-100 text-green-800 border border-green-200',
                                        'On Leave' => 'bg-yellow-100 text-yellow-800 border border-yellow-200',
                                        default => 'bg-gray-100 text-gray-700 border border-gray-200',
                                    };
                                @endphp
                                <tr class="border-b hover:bg-gray-50 transition-colors">
                                    <td class="p-4"><a href="{{ route('web.doctors.show', $doctor) }}" class="flex items-center gap-3"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full bg-indigo-100 items-center justify-center font-medium text-indigo-700">{{ strtoupper(substr($doctor->first_name, 0, 1)) }}{{ strtoupper(substr($doctor->last_name, 0, 1)) }}</span><span class="font-medium text-gray-900 hover:underline">Dr. {{ $doctor->full_name }}</span></a></td>
                                    <td class="p-4 text-gray-700">{{ $doctor->specialization }}</td>
                                    <td class="p-4"><span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $doctor->status }}</span></td>
                                    <td class="p-4 text-gray-700">{{ number_format($doctor->real_patients_count) }}</td>
                                    <td class="p-4 text-gray-700">{{ $doctor->experience_years }} yrs</td>
                                    <td class="p-4"><div class="text-sm"><p class="mb-1 text-gray-800">{{ $doctor->email }}</p><p class="text-gray-500">{{ $doctor->phone }}</p></div></td>
                                    <td class="p-4 text-right"><a href="{{ route('web.doctors.show', $doctor) }}" class="text-sm text-indigo-600 hover:text-indigo-700">View</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @include('partials.pagination', ['paginator' => $doctors, 'label' => 'doctors'])
    </div>
</div>
@endsection

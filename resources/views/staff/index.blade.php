@extends('layouts.app')

@section('title', 'Care Team')
@section('header', 'Care team')

@section('content')
<div class="flex flex-col gap-5">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">Care team</h1>
            <p class="text-gray-500">Find clinicians and staff by department, role, and availability.</p>
        </div>
        @if (auth()->user()->isAdmin())
            <span class="inline-flex items-center justify-center gap-2 rounded-md border border-dashed border-gray-300 text-gray-400 h-10 px-4 py-2 text-sm cursor-not-allowed" title="Coming soon">+ Add staff member <span class="text-[10px] uppercase tracking-wide bg-gray-100 text-gray-400 px-1.5 py-0.5 rounded-full">Soon</span></span>
        @endif
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <div class="flex justify-between items-center"><h3 class="text-sm font-medium text-gray-500">Active staff</h3><span class="text-green-500">&bull;</span></div>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['active']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Available in the system</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <div class="flex justify-between items-center"><h3 class="text-sm font-medium text-gray-500">Doctors</h3><span class="text-gray-400">&#10010;</span></div>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['doctors']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Active physicians</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <div class="flex justify-between items-center"><h3 class="text-sm font-medium text-gray-500">Departments</h3><span class="text-gray-400">&#9671;</span></div>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['departments']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Operational departments</p>
        </div>
        <div class="rounded-lg border bg-white dark:bg-background shadow-sm hover:shadow-md transition p-4">
            <div class="flex justify-between items-center"><h3 class="text-sm font-medium text-gray-500">On leave</h3><span class="inline-flex items-center rounded-full bg-yellow-100 text-yellow-700 px-2 py-0.5 text-xs font-semibold">!</span></div>
            <div class="text-2xl xl:text-3xl font-bold mt-2">{{ number_format($stats['on_leave']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Currently unavailable</p>
        </div>
    </div>

    <div class="rounded-lg border bg-background shadow-sm">
        <div class="p-4 border-b">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div><h2 class="text-xl font-semibold">Staff Directory</h2><div class="text-gray-500">{{ number_format($staff->total()) }} staff members</div></div>
                <form method="GET" action="{{ route('web.staff.index') }}" class="flex flex-col gap-2 sm:flex-row">
                    <div class="relative">
                        <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search staff..." class="h-10 rounded-md border border-gray-300 bg-background px-3 py-2 pl-8 text-sm w-full sm:w-[220px] focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <select name="department_id" class="h-10 rounded-md border border-gray-300 bg-background px-3 text-sm">
                        <option value="">All departments</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}" @selected((string) request('department_id') === (string) $department->id)>{{ $department->name }}</option>
                        @endforeach
                    </select>
                    <select name="status" class="h-10 rounded-md border border-gray-300 bg-background px-3 text-sm">
                        <option value="">All statuses</option>
                        @foreach (['Active', 'Inactive', 'On Leave'] as $status)
                            <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 text-sm shadow-sm">Filter</button>
                </form>
            </div>
        </div>
        <div class="p-4">
            @if ($staff->isEmpty())
                <div class="text-center py-8 text-gray-500">No staff members found</div>
            @else
                <div class="rounded-md border overflow-x-auto">
                    <table class="w-full text-sm whitespace-nowrap">
                        <thead class="bg-gray-50">
                            <tr class="border-b">
                                <th class="h-12 px-4 text-left">Staff member</th>
                                <th class="h-12 px-4 text-left">Role</th>
                                <th class="h-12 px-4 text-left hidden md:table-cell">Department</th>
                                <th class="h-12 px-4 text-left hidden md:table-cell">Specialization</th>
                                <th class="h-12 px-4 text-left hidden md:table-cell">Contact</th>
                                <th class="h-12 px-4 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staff as $member)
                                @php
                                    $statusClasses = match ($member->status ?? 'Active') {
                                        'Active' => 'bg-green-100 text-green-800',
                                        'On Leave' => 'bg-yellow-100 text-yellow-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <tr class="border-b hover:bg-accent hover:text-accent-foreground">
                                    <td class="p-4"><div class="flex items-center gap-3"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full bg-indigo-100 items-center justify-center font-medium text-indigo-700">{{ strtoupper(substr($member->full_name, 0, 1)) }}</span><div><div class="font-medium">{{ $member->full_name }}</div><div class="text-xs text-gray-500">{{ $member->code }}</div></div></div></td>
                                    <td class="p-4">{{ $member->position ?: $member->role ?: 'Care team' }}</td>
                                    <td class="p-4 hidden md:table-cell">{{ $member->department?->name ?? '—' }}</td>
                                    <td class="p-4 hidden md:table-cell">{{ $member->specialization ?: 'General care' }}</td>
                                    <td class="p-4 hidden md:table-cell text-xs text-gray-500">{{ $member->email ?: '—' }}</td>
                                    <td class="p-4"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $member->status ?? 'Active' }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        @include('partials.pagination', ['paginator' => $staff, 'label' => 'staff members'])
    </div>
</div>
@endsection

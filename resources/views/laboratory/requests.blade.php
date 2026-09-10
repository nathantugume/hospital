@extends('layouts.app')

@section('title', 'Test Requests')
@section('header', 'Test requests')

@section('content')
<div class="flex flex-col gap-5">
    @can('create', \App\Models\TestRequest::class)<div class="flex justify-end"><a href="{{ route('web.laboratory.requests.create') }}" class="inline-flex h-10 items-center rounded-md bg-primary px-4 text-sm text-white">+ New test request</a></div>@endcan
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('web.laboratory.index') }}" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground size-10" aria-label="Back to laboratory">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Test requests</h1>
                <p class="text-gray-500">Manage and track laboratory test requests from doctors.</p>
            </div>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border bg-background shadow-sm p-4">
            <h3 class="text-sm font-medium text-gray-500">Pending</h3>
            <div class="text-2xl font-bold mt-2">{{ number_format($stats['pending']) }}</div>
        </div>
        <div class="rounded-lg border bg-background shadow-sm p-4">
            <h3 class="text-sm font-medium text-gray-500">In progress</h3>
            <div class="text-2xl font-bold mt-2">{{ number_format($stats['in_progress']) }}</div>
        </div>
        <div class="rounded-lg border bg-background shadow-sm p-4">
            <h3 class="text-sm font-medium text-gray-500">Completed</h3>
            <div class="text-2xl font-bold mt-2">{{ number_format($stats['completed']) }}</div>
        </div>
        <div class="rounded-lg border bg-background shadow-sm p-4">
            <h3 class="text-sm font-medium text-gray-500">Cancelled</h3>
            <div class="text-2xl font-bold mt-2">{{ number_format($stats['cancelled']) }}</div>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1 gap-1">
            @foreach (['' => 'All requests', 'Pending' => 'Pending', 'In Progress' => 'In progress', 'Completed' => 'Completed', 'Cancelled' => 'Cancelled'] as $value => $label)
                <a href="{{ route('web.laboratory.requests', array_filter(['status' => $value] + request()->only('search'))) }}" class="inline-flex items-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all {{ $status === $value ? 'bg-background shadow-sm text-gray-900' : 'text-gray-500 hover:text-gray-900' }}">{{ $label }}</a>
            @endforeach
        </div>
        <form method="GET" action="{{ route('web.laboratory.requests') }}" class="flex gap-2">
            <input type="hidden" name="status" value="{{ $status }}">
            <div class="relative">
                <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search requests..." class="h-10 rounded-md border border-gray-300 bg-background pl-8 pr-3 text-sm w-full md:w-[250px] focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <button type="submit" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 text-sm shadow-sm">Filter</button>
        </form>
    </div>

    <div class="rounded-lg border bg-background shadow-sm">
        <div class="overflow-x-auto">
            @if ($testRequests->isEmpty())
                <div class="text-center py-10 text-gray-500">No test requests match the selected filters.</div>
            @else
                <table class="w-full caption-bottom text-sm">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="h-12 px-4 text-left align-middle font-medium text-gray-600">Request ID</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-gray-600">Patient</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-gray-600">Requested by</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-gray-600">Request date</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-gray-600">Priority</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-gray-600">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testRequests as $testRequest)
                            @php
                                $statusClasses = match ($testRequest->status) {
                                    'Completed' => 'bg-green-100 text-green-700',
                                    'Cancelled' => 'bg-red-100 text-red-700',
                                    'In Progress' => 'bg-blue-100 text-blue-700',
                                    default => 'bg-yellow-100 text-yellow-700',
                                };
                                $priorityClasses = $testRequest->priority === 'Urgent' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700';
                            @endphp
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4 align-middle font-medium"><a class="text-primary" href="{{ route('web.laboratory.requests.show',$testRequest) }}">{{ $testRequest->code }}</a></td>
                                <td class="p-4 align-middle">{{ $testRequest->patient?->full_name ?? 'Unknown patient' }}</td>
                                <td class="p-4 align-middle">{{ $testRequest->doctor?->full_name ?? 'Unassigned' }}</td>
                                <td class="p-4 align-middle">{{ optional($testRequest->requested_date)->format('d M Y') }}</td>
                                <td class="p-4 align-middle"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $priorityClasses }}">{{ $testRequest->priority }}</span></td>
                                <td class="p-4 align-middle"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $testRequest->status }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        @include('partials.pagination', ['paginator' => $testRequests, 'label' => 'test requests'])
    </div>
</div>
@endsection

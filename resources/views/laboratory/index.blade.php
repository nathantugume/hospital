@extends('layouts.app')

@section('title', 'Laboratory')
@section('header', 'Laboratory')

@section('content')
<div class="flex flex-col gap-6">
    <div class="flex items-center justify-between gap-4 flex-wrap">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Laboratory</h1>
            <p class="text-gray-500">Track test requests, result readiness, and urgent work in the lab.</p>
        </div>
        <span class="inline-flex items-center justify-center gap-2 rounded-md border border-dashed border-gray-300 text-gray-400 h-10 px-4 py-2 text-sm cursor-not-allowed" title="Coming soon">+ New test request <span class="text-[10px] uppercase tracking-wide bg-gray-100 text-gray-400 px-1.5 py-0.5 rounded-full">Soon</span></span>
    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-lg border bg-white shadow-sm hover:shadow-md transition p-4">
            <div class="flex justify-between items-center"><h3 class="text-sm font-medium text-gray-500">Open requests</h3></div>
            <div class="text-2xl font-bold mt-2">{{ number_format($stats['pending_requests']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Pending or in progress</p>
        </div>
        <div class="rounded-lg border bg-white shadow-sm hover:shadow-md transition p-4">
            <div class="flex justify-between items-center"><h3 class="text-sm font-medium text-gray-500">Ready results</h3><span class="text-green-500">&check;</span></div>
            <div class="text-2xl font-bold mt-2">{{ number_format($stats['ready_results']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Completed or verified</p>
        </div>
        <div class="rounded-lg border bg-white shadow-sm hover:shadow-md transition p-4">
            <div class="flex justify-between items-center"><h3 class="text-sm font-medium text-gray-500">Urgent</h3><span class="inline-flex items-center rounded-full bg-red-100 text-red-700 px-2 py-0.5 text-xs font-semibold">!</span></div>
            <div class="text-2xl font-bold mt-2">{{ number_format($stats['urgent']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Priority requests</p>
        </div>
        <div class="rounded-lg border bg-white shadow-sm hover:shadow-md transition p-4">
            <div class="flex justify-between items-center"><h3 class="text-sm font-medium text-gray-500">Test catalogue</h3></div>
            <div class="text-2xl font-bold mt-2">{{ number_format($stats['catalogue']) }}</div>
            <p class="text-xs text-gray-500 mt-1">Active lab tests</p>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b flex items-center justify-between"><h2 class="text-lg font-semibold">Recent test requests</h2><span class="text-sm text-gray-400 cursor-not-allowed" title="Coming soon">Open queue</span></div>
            <div class="overflow-x-auto">
                @if ($requests->isEmpty())
                    <div class="text-center py-8 text-gray-500">No test requests are available.</div>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr><th class="h-10 px-4 text-left">Request</th><th class="h-10 px-4 text-left">Patient</th><th class="h-10 px-4 text-left">Requested</th><th class="h-10 px-4 text-left">Priority</th><th class="h-10 px-4 text-left">Status</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $request)
                                @php
                                    $statusClasses = match ($request->status) {
                                        'Completed', 'Verified' => 'bg-green-100 text-green-700',
                                        'Cancelled' => 'bg-red-100 text-red-700',
                                        default => 'bg-yellow-100 text-yellow-700',
                                    };
                                @endphp
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 font-medium">{{ $request->code }}</td>
                                    <td class="p-3">{{ $request->patient?->full_name ?? 'Unknown patient' }}</td>
                                    <td class="p-3">{{ optional($request->requested_date)->format('d M Y') }}</td>
                                    <td class="p-3">{{ $request->priority }}</td>
                                    <td class="p-3"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $request->status }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <div class="rounded-lg border bg-background shadow-sm">
            <div class="p-4 border-b flex items-center justify-between"><h2 class="text-lg font-semibold">Latest lab results</h2><span class="text-sm text-gray-400 cursor-not-allowed" title="Coming soon">View results</span></div>
            <div class="overflow-x-auto">
                @if ($results->isEmpty())
                    <div class="text-center py-8 text-gray-500">No lab results are available.</div>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b">
                            <tr><th class="h-10 px-4 text-left">Test</th><th class="h-10 px-4 text-left">Patient</th><th class="h-10 px-4 text-left">Date</th><th class="h-10 px-4 text-left">Flag</th><th class="h-10 px-4 text-left">Status</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $result)
                                @php
                                    $statusClasses = match ($result->status ?? 'Pending') {
                                        'Completed', 'Verified' => 'bg-green-100 text-green-700',
                                        default => 'bg-yellow-100 text-yellow-700',
                                    };
                                @endphp
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 font-medium">{{ $result->test_name }}<div class="text-xs text-gray-500 font-normal">{{ $result->code }}</div></td>
                                    <td class="p-3">{{ $result->patient?->full_name ?? 'Unknown patient' }}</td>
                                    <td class="p-3">{{ optional($result->result_date)->format('d M Y') }}</td>
                                    <td class="p-3">{{ $result->flag ?: 'Normal' }}</td>
                                    <td class="p-3"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses }}">{{ $result->status ?? 'Pending' }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

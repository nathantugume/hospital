@extends('layouts.app')

@section('title', 'Laboratory')
@section('header', 'Laboratory')

@section('content')
<div class="page-heading">
    <div><h1>Laboratory</h1><p>Track test requests, result readiness, and urgent work in the lab.</p></div>
    <a class="button button-primary" href="{{ url('/test-requests.html') }}">New test request</a>
</div>

<div class="stat-grid">
    <div class="stat-card"><div class="stat-card-top"><span class="label">Open requests</span><span class="metric-icon">◌</span></div><strong class="value">{{ number_format($stats['pending_requests']) }}</strong><span class="detail">Pending or in progress</span></div>
    <div class="stat-card"><div class="stat-card-top"><span class="label">Ready results</span><span class="metric-icon">✓</span></div><strong class="value">{{ number_format($stats['ready_results']) }}</strong><span class="detail">Completed or verified</span></div>
    <div class="stat-card"><div class="stat-card-top"><span class="label">Urgent</span><span class="metric-icon">!</span></div><strong class="value">{{ number_format($stats['urgent']) }}</strong><span class="detail">Priority requests</span></div>
    <div class="stat-card"><div class="stat-card-top"><span class="label">Test catalogue</span><span class="metric-icon">▤</span></div><strong class="value">{{ number_format($stats['catalogue']) }}</strong><span class="detail">Active lab tests</span></div>
</div>

<div class="dashboard-grid dashboard-grid-primary">
    <section class="panel">
        <div class="panel-header"><div><span class="panel-kicker">Queue</span><h2>Recent test requests</h2></div><a class="text-link" href="{{ url('/test-requests.html') }}">Open queue</a></div>
        <div class="panel-body table-wrap">
            @if ($requests->isEmpty())<div class="empty">No test requests are available.</div>@else
                <table><thead><tr><th>Request</th><th>Patient</th><th>Requested</th><th>Priority</th><th>Status</th></tr></thead><tbody>
                @foreach ($requests as $request)<tr>
                    <td><strong>{{ $request->code }}</strong></td><td>{{ $request->patient?->full_name ?? 'Unknown patient' }}</td><td>{{ optional($request->requested_date)->format('d M Y') }}</td><td>{{ $request->priority }}</td><td><span class="status status-{{ strtolower(str_replace(' ', '-', $request->status)) }}">{{ $request->status }}</span></td>
                </tr>@endforeach
                </tbody></table>
            @endif
        </div>
    </section>
    <section class="panel">
        <div class="panel-header"><div><span class="panel-kicker">Results</span><h2>Latest lab results</h2></div><a class="text-link" href="{{ url('/lab-results.html') }}">View results</a></div>
        <div class="panel-body table-wrap">
            @if ($results->isEmpty())<div class="empty">No lab results are available.</div>@else
                <table><thead><tr><th>Test</th><th>Patient</th><th>Date</th><th>Flag</th><th>Status</th></tr></thead><tbody>
                @foreach ($results as $result)<tr>
                    <td><strong>{{ $result->test_name }}</strong><br><span class="muted">{{ $result->code }}</span></td><td>{{ $result->patient?->full_name ?? 'Unknown patient' }}</td><td>{{ optional($result->result_date)->format('d M Y') }}</td><td>{{ $result->flag ?: 'Normal' }}</td><td><span class="status status-{{ strtolower($result->status ?? 'pending') }}">{{ $result->status ?? 'Pending' }}</span></td>
                </tr>@endforeach
                </tbody></table>
            @endif
        </div>
    </section>
</div>
@endsection

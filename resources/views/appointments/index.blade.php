@extends('layouts.app')

@section('title', 'Appointments')
@section('header', 'Appointments')

@section('content')
<div class="page-heading">
    <div><h1>Appointments</h1><p>Coordinate patient visits, clinicians, and daily care capacity.</p></div>
    <a class="button button-primary" href="{{ url('/add-appointment.html') }}">New appointment</a>
</div>

<div class="stat-grid">
    <div class="stat-card"><div class="stat-card-top"><span class="label">Today</span><span class="metric-icon">◷</span></div><strong class="value">{{ number_format($stats['today']) }}</strong><span class="detail">Scheduled for today</span></div>
    <div class="stat-card"><div class="stat-card-top"><span class="label">Upcoming</span><span class="metric-icon">→</span></div><strong class="value">{{ number_format($stats['upcoming']) }}</strong><span class="detail">From today onward</span></div>
    <div class="stat-card"><div class="stat-card-top"><span class="label">Pending</span><span class="metric-icon">!</span></div><strong class="value">{{ number_format($stats['pending']) }}</strong><span class="detail">Need confirmation</span></div>
    <div class="stat-card"><div class="stat-card-top"><span class="label">Completed</span><span class="metric-icon">✓</span></div><strong class="value">{{ number_format($stats['completed']) }}</strong><span class="detail">Completed visits</span></div>
</div>

<form class="filters" method="GET" action="{{ route('web.appointments.index') }}">
    <div class="field"><label for="search">Search patient</label><input id="search" name="search" value="{{ request('search') }}" placeholder="Patient name"></div>
    <div class="field"><label for="date">Date</label><input id="date" name="date" type="date" value="{{ request('date') }}"></div>
    <div class="field"><label for="status">Status</label><select id="status" name="status"><option value="">All statuses</option>@foreach (['Pending', 'Confirmed', 'Completed', 'Cancelled', 'No-Show'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>@endforeach</select></div>
    <button class="button button-primary" type="submit">Filter</button>
</form>

<section class="panel">
    <div class="panel-header"><div><span class="panel-kicker">Care calendar</span><h2>{{ number_format($appointments->total()) }} appointments</h2></div><a class="text-link" href="{{ url('/appointment-calendar.html') }}">Calendar view</a></div>
    <div class="panel-body table-wrap">
        @if ($appointments->isEmpty())
            <div class="empty">No appointments match the selected filters.</div>
        @else
            <table><thead><tr><th>Patient</th><th>Clinician</th><th>Department</th><th>Date and time</th><th>Visit type</th><th>Status</th></tr></thead><tbody>
            @foreach ($appointments as $appointment)<tr>
                <td><strong>{{ $appointment->patient?->full_name ?? 'Unknown patient' }}</strong><br><span class="muted">{{ $appointment->patient?->code ?? '—' }}</span></td>
                <td>{{ $appointment->doctor?->full_name ?? 'Unassigned' }}</td>
                <td>{{ $appointment->department?->name ?? '—' }}</td>
                <td>{{ optional($appointment->date)->format('d M Y') }}<br><span class="muted">{{ substr((string) $appointment->start_time, 0, 5) }}</span></td>
                <td>{{ $appointment->type }}</td>
                <td><span class="status status-{{ strtolower(str_replace(' ', '-', $appointment->status ?? 'pending')) }}">{{ $appointment->status ?? 'Pending' }}</span></td>
            </tr>@endforeach
            </tbody></table>
            <div class="pagination"><span>Showing {{ $appointments->firstItem() }}–{{ $appointments->lastItem() }} of {{ $appointments->total() }}</span><span>{{ $appointments->links() }}</span></div>
        @endif
    </div>
</section>
@endsection

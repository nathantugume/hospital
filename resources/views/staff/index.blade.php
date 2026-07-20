@extends('layouts.app')

@section('title', 'Care Team')
@section('header', 'Care team')

@section('content')
<div class="page-heading">
    <div><h1>Care team</h1><p>Find clinicians and staff by department, role, and availability.</p></div>
    @if (auth()->user()->isAdmin())<a class="button button-primary" href="{{ url('/add-staff.html') }}">Add staff member</a>@endif
</div>

<div class="stat-grid">
    <div class="stat-card"><div class="stat-card-top"><span class="label">Active staff</span><span class="metric-icon">●</span></div><strong class="value">{{ number_format($stats['active']) }}</strong><span class="detail">Available in the system</span></div>
    <div class="stat-card"><div class="stat-card-top"><span class="label">Doctors</span><span class="metric-icon">✚</span></div><strong class="value">{{ number_format($stats['doctors']) }}</strong><span class="detail">Active physicians</span></div>
    <div class="stat-card"><div class="stat-card-top"><span class="label">Departments</span><span class="metric-icon">◇</span></div><strong class="value">{{ number_format($stats['departments']) }}</strong><span class="detail">Operational departments</span></div>
    <div class="stat-card"><div class="stat-card-top"><span class="label">On leave</span><span class="metric-icon">!</span></div><strong class="value">{{ number_format($stats['on_leave']) }}</strong><span class="detail">Currently unavailable</span></div>
</div>

<form class="filters" method="GET" action="{{ route('web.staff.index') }}">
    <div class="field"><label for="search">Search care team</label><input id="search" name="search" value="{{ request('search') }}" placeholder="Name, code, specialization"></div>
    <div class="field"><label for="department_id">Department</label><select id="department_id" name="department_id"><option value="">All departments</option>@foreach ($departments as $department)<option value="{{ $department->id }}" @selected((string) request('department_id') === (string) $department->id)>{{ $department->name }}</option>@endforeach</select></div>
    <div class="field"><label for="status">Status</label><select id="status" name="status"><option value="">All statuses</option>@foreach (['Active', 'Inactive', 'On Leave'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>@endforeach</select></div>
    <button class="button button-primary" type="submit">Filter</button>
</form>

<section class="panel">
    <div class="panel-header"><div><span class="panel-kicker">People directory</span><h2>{{ number_format($staff->total()) }} staff members</h2></div><a class="text-link" href="{{ url('/staff-schedule.html') }}">Staff schedule</a></div>
    <div class="panel-body table-wrap">
        @if ($staff->isEmpty())
            <div class="empty">No staff members match the selected filters.</div>
        @else
            <table><thead><tr><th>Staff member</th><th>Role</th><th>Department</th><th>Specialization</th><th>Contact</th><th>Status</th></tr></thead><tbody>
            @foreach ($staff as $member)<tr>
                <td><strong>{{ $member->full_name }}</strong><br><span class="muted">{{ $member->code }}</span></td>
                <td>{{ $member->position ?: $member->role ?: 'Care team' }}</td>
                <td>{{ $member->department?->name ?? '—' }}</td>
                <td>{{ $member->specialization ?: 'General care' }}</td>
                <td>{{ $member->email ?: '—' }}</td>
                <td><span class="status status-{{ strtolower(str_replace(' ', '-', $member->status ?? 'active')) }}">{{ $member->status ?? 'Active' }}</span></td>
            </tr>@endforeach
            </tbody></table>
            <div class="pagination"><span>Showing {{ $staff->firstItem() }}–{{ $staff->lastItem() }} of {{ $staff->total() }}</span><span>{{ $staff->links() }}</span></div>
        @endif
    </div>
</section>
@endsection

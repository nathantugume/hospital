@extends('layouts.app')

@section('title', 'Patients')
@section('header', 'Patient records')

@section('content')
<div class="page-heading">
    <div><h1>Patients</h1><p>Search and review registered patient records.</p></div>
    <a class="button button-primary" href="{{ url('/add-patient.html') }}">Add patient</a>
</div>

<form class="filters" method="GET" action="{{ route('web.patients.index') }}">
    <div class="field"><label for="search">Search</label><input id="search" name="search" value="{{ request('search') }}" placeholder="Name or patient code"></div>
    <div class="field"><label for="status">Status</label><select id="status" name="status"><option value="">All statuses</option>@foreach (['Active', 'Inactive', 'Discharged'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>@endforeach</select></div>
    <button class="button button-primary" type="submit">Filter</button>
</form>

<section class="panel">
    <div class="panel-header"><h2>{{ number_format($patients->total()) }} patient records</h2></div>
    <div class="panel-body table-wrap">
        @if ($patients->isEmpty())
            <div class="empty">No patients match the selected filters.</div>
        @else
            <table>
                <thead><tr><th>Patient</th><th>Code</th><th>Contact</th><th>Last visit</th><th>Status</th></tr></thead>
                <tbody>@foreach ($patients as $patient)<tr>
                    <td><strong>{{ $patient->full_name }}</strong><br><span class="muted">{{ $patient->gender }}, {{ optional($patient->date_of_birth)->age }} years</span></td>
                    <td>{{ $patient->code }}</td><td>{{ $patient->phone ?? $patient->email ?? '—' }}</td><td>{{ optional($patient->last_visit)->format('d M Y') ?? '—' }}</td>
                    <td><span class="status status-{{ strtolower($patient->status ?? 'active') }}">{{ $patient->status ?? 'Active' }}</span></td>
                </tr>@endforeach</tbody>
            </table>
            <div class="pagination"><span>Showing {{ $patients->firstItem() }}–{{ $patients->lastItem() }} of {{ $patients->total() }}</span><span>{{ $patients->links() }}</span></div>
        @endif
    </div>
</section>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="page-heading">
    <div>
        <h1>Good {{ now()->format('A') === 'AM' ? 'morning' : 'afternoon' }}, {{ $user->name }}</h1>
        <p>{{ now()->format('l, d F Y') }} · {{ $user->role_label }}</p>
    </div>
</div>

<div class="card-grid">
    @php($cards = [
        ['label' => 'Patients', 'value' => number_format($stats['patients']), 'detail' => 'Registered records'],
        ['label' => 'Today\'s appointments', 'value' => number_format($stats['appointments']), 'detail' => 'Scheduled today'],
        ['label' => 'Care team', 'value' => number_format($stats['staff']), 'detail' => 'Staff profiles'],
        ['label' => 'Outstanding balance', 'value' => 'UGX '.number_format((float) $stats['outstanding']), 'detail' => 'Pending or overdue'],
        ['label' => 'Medicines', 'value' => number_format($stats['medicines']), 'detail' => 'Inventory catalogue'],
    ])
    @foreach ($cards as $card)
        <article class="stat-card">
            <span class="label">{{ $card['label'] }}</span>
            <strong class="value">{{ $card['value'] }}</strong>
            <span class="detail">{{ $card['detail'] }}</span>
        </article>
    @endforeach
</div>

<div class="dashboard-grid">
    <section class="panel">
        <div class="panel-header">
            <h2>Upcoming appointments</h2>
            <a class="button button-primary" href="{{ url('/appointments.html') }}">Open schedule</a>
        </div>
        <div class="panel-body table-wrap">
            @if ($upcomingAppointments->isEmpty())
                <div class="empty">No upcoming appointments have been recorded.</div>
            @else
                <table>
                    <thead><tr><th>Date</th><th>Patient</th><th>Clinician</th><th>Status</th></tr></thead>
                    <tbody>
                    @foreach ($upcomingAppointments as $appointment)
                        <tr>
                            <td>{{ optional($appointment->date)->format('d M Y') }}<br><span class="muted">{{ $appointment->start_time }}</span></td>
                            <td>{{ $appointment->patient?->full_name ?? $user->patient?->full_name ?? 'Patient record' }}</td>
                            <td>{{ $appointment->doctor?->full_name ?? 'Unassigned' }}</td>
                            <td><span class="status status-{{ strtolower($appointment->status ?? 'pending') }}">{{ $appointment->status ?? 'Pending' }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <h2>Recent patients</h2>
            @if (Route::has('web.patients.index') && ! $user->isPatient())<a class="muted" href="{{ route('web.patients.index') }}">View all</a>@endif
        </div>
        <div class="panel-body table-wrap">
            @if ($recentPatients->isEmpty())
                <div class="empty">No patient records yet.</div>
            @else
                <table>
                    <thead><tr><th>Patient</th><th>Code</th><th>Status</th></tr></thead>
                    <tbody>
                    @foreach ($recentPatients as $patient)
                        <tr>
                            <td><strong>{{ $patient->full_name }}</strong><br><span class="muted">{{ $patient->gender ?? '—' }}</span></td>
                            <td>{{ $patient->code }}</td>
                            <td><span class="status status-{{ strtolower($patient->status ?? 'active') }}">{{ $patient->status ?? 'Active' }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </section>
</div>
@endsection

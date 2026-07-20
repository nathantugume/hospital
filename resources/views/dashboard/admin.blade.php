@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('header', 'Admin dashboard')

@section('content')
@php
    $currency = app(\App\Services\CurrencyService::class);
    $firstName = str($user->name)->before(' ');
    $maxAppointmentStatus = max(1, (int) $appointmentStatus->max());
    $cards = [
        ['label' => 'Active patients', 'value' => number_format($stats['active_patients']), 'detail' => 'Current patient records', 'icon' => '◉'],
        ['label' => "Today's appointments", 'value' => number_format($stats['today_appointments']), 'detail' => 'Scheduled for today', 'icon' => '◷'],
        ['label' => 'Care team', 'value' => number_format($stats['staff']), 'detail' => 'Active staff profiles', 'icon' => '✚'],
        ['label' => 'Outstanding balance', 'value' => $currency->format($stats['outstanding']), 'detail' => 'Pending, partial or overdue', 'icon' => '¤'],
        ['label' => 'Collected this month', 'value' => $currency->format($stats['monthly_revenue']), 'detail' => 'Paid invoices', 'icon' => '▤'],
    ];
@endphp

<div class="dashboard-hero">
    <div>
        <span class="eyebrow">Admin workspace</span>
        <h1>Welcome back, {{ $firstName }}</h1>
        <p>System overview in {{ $currency->code() }} · Keep today’s patient flow, care delivery, and billing on track.</p>
    </div>
    <div class="dashboard-hero-meta">
        <span class="live-indicator"><span class="live-dot" aria-hidden="true"></span>Live demo</span>
        <span>{{ now()->format('D, d M Y') }}</span>
    </div>
</div>

<nav class="quick-actions" aria-label="Quick actions">
    <a class="quick-action" href="{{ route('web.patients.index') }}">
        <span class="quick-action-icon" aria-hidden="true">＋</span>
        <span><strong>Register patient</strong><small>Start a new record</small></span>
        <span class="quick-action-arrow" aria-hidden="true">→</span>
    </a>
    <a class="quick-action" href="{{ route('web.appointments.index') }}">
        <span class="quick-action-icon" aria-hidden="true">◷</span>
        <span><strong>Open appointments</strong><small>Review today’s schedule</small></span>
        <span class="quick-action-arrow" aria-hidden="true">→</span>
    </a>
    <a class="quick-action" href="{{ route('web.invoices.index') }}">
        <span class="quick-action-icon" aria-hidden="true">▤</span>
        <span><strong>Review billing</strong><small>Track invoices and balances</small></span>
        <span class="quick-action-arrow" aria-hidden="true">→</span>
    </a>
    <a class="quick-action" href="{{ route('admin.settings.edit') }}">
        <span class="quick-action-icon" aria-hidden="true">⚙</span>
        <span><strong>System settings</strong><small>Currency and preferences</small></span>
        <span class="quick-action-arrow" aria-hidden="true">→</span>
    </a>
</nav>

<div class="stat-grid">
    @foreach ($cards as $card)
        <article class="stat-card">
            <div class="stat-card-top">
                <span class="label">{{ $card['label'] }}</span>
                <span class="metric-icon" aria-hidden="true">{{ $card['icon'] }}</span>
            </div>
            <strong class="value">{{ $card['value'] }}</strong>
            <span class="detail">{{ $card['detail'] }}</span>
        </article>
    @endforeach
</div>

<div class="dashboard-grid dashboard-grid-primary">
    <section class="panel">
        <div class="panel-header">
            <div><span class="panel-kicker">Today</span><h2>Workload by status</h2></div>
            <a class="text-link" href="{{ route('web.appointments.index') }}">Open schedule <span aria-hidden="true">→</span></a>
        </div>
        <div class="panel-body workload-list">
            @if ($appointmentStatus->isEmpty())
                <div class="empty">No appointments scheduled today.</div>
            @else
                @foreach ($appointmentStatus as $status => $count)
                    <div class="workload-row">
                        <div class="workload-label"><span>{{ $status }}</span><strong>{{ number_format($count) }}</strong></div>
                        <div class="workload-track"><span style="width: {{ round(($count / $maxAppointmentStatus) * 100) }}%"></span></div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <section class="panel">
        <div class="panel-header">
            <div><span class="panel-kicker">Next up</span><h2>Upcoming appointments</h2></div>
            <a class="text-link" href="{{ route('web.appointments.index') }}" aria-label="View all appointments">View all <span aria-hidden="true">→</span></a>
        </div>
        <div class="panel-body table-wrap">
            @if ($upcomingAppointments->isEmpty())
                <div class="empty">No upcoming appointments have been recorded.</div>
            @else
                <table>
                    <thead><tr><th>When</th><th>Patient</th><th>Status</th></tr></thead>
                    <tbody>
                    @foreach ($upcomingAppointments as $appointment)
                        <tr>
                            <td><strong>{{ optional($appointment->date)->format('d M') }}</strong><br><span class="muted">{{ $appointment->start_time }}</span></td>
                            <td>{{ $appointment->patient?->full_name ?? 'Patient record' }}<br><span class="muted">{{ $appointment->doctor?->full_name ?? 'Unassigned clinician' }}</span></td>
                            <td><span class="status status-{{ strtolower($appointment->status ?? 'pending') }}">{{ $appointment->status ?? 'Pending' }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </section>
</div>

<section class="panel dashboard-section">
    <div class="panel-header">
        <div><span class="panel-kicker">Finance</span><h2>Recent invoices</h2></div>
        <a class="text-link" href="{{ route('web.invoices.index') }}">View billing <span aria-hidden="true">→</span></a>
    </div>
    <div class="panel-body table-wrap">
        @if ($recentInvoices->isEmpty())
            <div class="empty">No invoices have been recorded.</div>
        @else
            <table>
                <thead><tr><th>Invoice</th><th>Patient</th><th>Amount</th><th>Balance</th><th>Status</th></tr></thead>
                <tbody>
                @foreach ($recentInvoices as $invoice)
                    <tr>
                        <td><strong>{{ $invoice->code }}</strong><br><span class="muted">{{ optional($invoice->date)->format('d M Y') }}</span></td>
                        <td>{{ $invoice->patient?->full_name ?? 'Patient record' }}</td>
                        <td>@money($invoice->amount)</td>
                        <td>@money($invoice->balance)</td>
                        <td><span class="status status-{{ strtolower($invoice->status ?? 'pending') }}">{{ $invoice->status ?? 'Pending' }}</span></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>
@endsection

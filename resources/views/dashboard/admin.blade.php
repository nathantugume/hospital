@extends('layouts.app')

@section('title', 'Admin Dashboard')
@section('header', 'Admin dashboard')

@section('content')
<div class="page-heading">
    <div>
        <h1>Admin dashboard</h1>
        <p>{{ now()->format('l, d F Y') }} · System overview in {{ app(\App\Services\CurrencyService::class)->code() }}</p>
    </div>
    <a class="button button-primary" href="{{ route('admin.settings.edit') }}">Open settings</a>
</div>

<div class="card-grid">
    @php($cards = [
        ['label' => 'Active patients', 'value' => number_format($stats['active_patients']), 'detail' => 'Current patient records'],
        ['label' => "Today's appointments", 'value' => number_format($stats['today_appointments']), 'detail' => 'Scheduled for today'],
        ['label' => 'Care team', 'value' => number_format($stats['staff']), 'detail' => 'Active staff profiles'],
        ['label' => 'Outstanding balance', 'value' => app(\App\Services\CurrencyService::class)->format($stats['outstanding']), 'detail' => 'Pending, partial or overdue'],
        ['label' => 'Collected this month', 'value' => app(\App\Services\CurrencyService::class)->format($stats['monthly_revenue']), 'detail' => 'Paid invoices'],
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
            <a class="muted" href="{{ url('/appointments.html') }}">Open schedule</a>
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
                            <td>{{ $appointment->patient?->full_name ?? 'Patient record' }}</td>
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
        <div class="panel-header"><h2>Today's status</h2></div>
        <div class="panel-body table-wrap">
            @if ($appointmentStatus->isEmpty())
                <div class="empty">No appointments scheduled today.</div>
            @else
                <table>
                    <thead><tr><th>Status</th><th>Appointments</th></tr></thead>
                    <tbody>
                    @foreach ($appointmentStatus as $status => $count)
                        <tr><td><span class="status status-{{ strtolower($status) }}">{{ $status }}</span></td><td>{{ number_format($count) }}</td></tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </section>
</div>

<section class="panel" style="margin-top: 18px">
    <div class="panel-header">
        <h2>Recent invoices</h2>
        <a class="muted" href="{{ route('web.invoices.index') }}">View billing</a>
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

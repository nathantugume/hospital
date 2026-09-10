@extends('layouts.app')
@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('content')
@php
    $cards = [
        ['label' => 'Total Revenue', 'value' => $currency->format($analytics['periodRevenue']), 'raw' => $analytics['periodRevenue'], 'detail' => 'Collected in selected period', 'color' => 'text-green-600', 'icon' => 'revenue'],
        ['label' => 'Appointments', 'value' => number_format($analytics['periodAppointments']), 'raw' => $analytics['periodAppointments'], 'detail' => 'In selected period', 'color' => 'text-blue-500', 'icon' => 'calendar'],
        ['label' => 'Patients', 'value' => number_format($stats['active_patients']), 'raw' => $stats['active_patients'], 'detail' => 'Active patients', 'color' => 'text-amber-500', 'icon' => 'patient'],
        ['label' => 'Staff', 'value' => number_format($stats['staff']), 'raw' => $stats['staff'], 'detail' => 'Active care team', 'color' => 'text-purple-500', 'icon' => 'staff'],
    ];
@endphp
<div class="flex flex-col gap-5 overflow-x-hidden max-full mx-auto">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <div><h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">Dashboard</h1><p class="text-gray-500">Welcome back, {{ $user->name }}! Here's what's happening today.</p></div>
        <div class="flex items-center flex-wrap gap-2">
            <details class="relative header-menu">
                <summary id="dateRangeBtn" class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-background h-10 px-4 text-sm cursor-pointer" aria-label="Choose reporting dates">
                    @include('partials.icon', ['icon' => 'calendar'])<span>{{ $from->format('M j, Y') }} - {{ $to->format('M j, Y') }}</span>
                </summary>
                <form method="GET" action="{{ route('dashboard') }}" class="absolute right-0 mt-2 z-50 rounded-md border border-gray-200 bg-background shadow-lg p-4 space-y-4" style="width: 260px">
                    <div><label for="report-from" class="block text-sm font-medium mb-1">Start Date</label><input id="report-from" name="from" type="date" value="{{ $from->toDateString() }}" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                    <div><label for="report-to" class="block text-sm font-medium mb-1">End Date</label><input id="report-to" name="to" type="date" value="{{ $to->toDateString() }}" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                    <div class="flex gap-2"><button class="flex-1 rounded-md bg-primary text-white py-2 text-sm" type="submit">Apply</button><a href="{{ route('dashboard') }}" class="flex-1 text-center rounded-md border border-gray-300 py-2 text-sm">Reset</a></div>
                </form>
            </details>
            <button type="button" data-export-dashboard class="inline-flex items-center gap-2 rounded-md border px-3 py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10">@include('partials.icon', ['icon' => 'download'])Export</button>
        </div>
    </div>
    <div class="grid gap-4 xl:gap-6 sm:grid-cols-2 lg:grid-cols-4" id="statsCards">
        @foreach($cards as $card)
        <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition" data-metric="{{ $card['label'] }}" data-value="{{ $card['raw'] }}">
            <div class="flex flex-col gap-1">
                @include('partials.icon', ['icon' => $card['icon'], 'iconClass' => 'h-6 w-6 '.$card['color']])
                <h2 class="text-base font-semibold">{{ $card['label'] }}</h2><p class="text-gray-500">{{ $card['detail'] }}</p>
            </div><div class="mt-2"><p class="text-3xl font-bold mt-2">{{ $card['value'] }}</p></div>
        </div>
        @endforeach
    </div>
    <div dir="ltr" class="space-y-4">
        <div role="tablist" aria-label="Dashboard sections" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1">
            @foreach(['overview' => 'Overview', 'analytics' => 'Analytics', 'reports' => 'Reports', 'notifications' => 'Notifications'] as $key => $label)
                <button type="button" role="tab" id="dashboard-tab-{{ $key }}" aria-controls="tab-{{ $key }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}" data-dashboard-tab="{{ $key }}" class="tab-btn inline-flex rounded-sm px-3 py-1.5 text-sm font-medium" data-state="{{ $loop->first ? 'active' : 'inactive' }}">{{ $label }}</button>
            @endforeach
        </div>
        <div id="tab-overview" role="tabpanel" aria-labelledby="dashboard-tab-overview" class="tab-panel mt-4 space-y-4">
            <div class="max-md:space-y-4 md:grid md:gap-4 md:grid-cols-2 lg:grid-cols-7">
                <div class="rounded-lg border bg-background shadow-sm lg:col-span-4">
                    <div class="p-4 border-b"><h2 class="text-xl font-semibold">Overview</h2><p class="text-gray-500">Patient visits and revenue for the current period.</p></div>
                    <div class="p-4">
                        <div id="revenueChart" data-chart="{{ json_encode($chart) }}" data-currency="{{ $currency->code() }}" aria-label="Monthly revenue and patient visits"></div>
                        <details class="mt-2 text-sm text-gray-500"><summary class="cursor-pointer">View chart data</summary><div class="overflow-x-auto"><table class="w-full text-sm"><caption class="sr-only">Monthly revenue and patient visits</caption><thead><tr><th class="p-2 text-left">Month</th><th class="p-2 text-right">Revenue ({{ $currency->code() }})</th><th class="p-2 text-right">Visits</th></tr></thead><tbody>@foreach($chart as $point)<tr><td class="p-2">{{ $point['month'] }}</td><td class="p-2 text-right">{{ $currency->format($point['revenue']) }}</td><td class="p-2 text-right">{{ $point['visits'] }}</td></tr>@endforeach</tbody></table></div></details>
                    </div>
                </div>
                <div class="rounded-lg border bg-background shadow-sm lg:col-span-3">
                    <div class="p-4 border-b"><h2 class="text-xl font-semibold">Recent Appointments</h2><p class="text-gray-500">You have {{ number_format($stats['today_appointments']) }} appointments today.</p></div>
                    <div class="p-4 max-h-[400px] overflow-y-auto pr-2" id="recentAppointmentsContainer" aria-label="Upcoming appointments">
                        <div class="space-y-3">
                        @forelse($upcomingAppointments as $appointment)
                            <div class="flex items-center justify-between gap-3 p-3 border rounded-md">
                                <div class="flex items-center gap-3 min-w-0"><img src="{{ asset('user.png') }}" class="h-10 w-10 rounded-full" alt=""><div class="min-w-0"><p class="font-medium">{{ $appointment->patient?->full_name ?? 'Patient record' }}</p><p class="text-gray-500">{{ $appointment->type ?? 'Consultation' }}</p><p class="text-xs text-gray-500 mt-1">{{ optional($appointment->date)->format('d M Y') }} &nbsp; {{ $appointment->start_time }}</p></div></div>
                                <span class="inline-flex rounded-full border px-2 py-0.5 text-xs font-semibold {{ $appointment->status === 'Confirmed' ? 'text-blue-600' : 'text-gray-500' }}">{{ $appointment->status }}</span>
                            </div>
                        @empty<p class="py-8 text-center text-gray-500">No upcoming appointments have been recorded.</p>@endforelse
                        </div>
                    </div>
                    <a class="inline-flex items-center justify-center text-sm font-medium text-indigo-600 hover:underline w-full text-center mb-4" href="{{ route('web.appointments.index') }}">View all appointments</a>
                </div>
            </div>
        </div>
        <div id="tab-analytics" role="tabpanel" aria-labelledby="dashboard-tab-analytics" class="tab-panel hidden mt-4 space-y-4">
            <div><h2 class="text-xl font-semibold">Detailed Analytics</h2><p class="text-gray-500">Insights from your clinic data</p></div>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h3 class="text-xl font-semibold">Patient Demographics</h3><p class="text-gray-500">Age and gender of registered patients</p></div><div class="p-4"><div id="demographicsChart" data-chart="{{ json_encode($analytics['demographics']) }}"></div></div></div>
                <div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h3 class="text-xl font-semibold">Appointment Types</h3><p class="text-gray-500">Distribution by service category</p></div><div class="p-4"><div id="appointmentTypesChart" data-chart="{{ json_encode($analytics['appointmentTypes']) }}"></div></div></div>
                <div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h3 class="text-xl font-semibold">Revenue Sources</h3><p class="text-gray-500">Collected payments by payment method</p></div><div class="p-4"><div id="revenueSourcesChart" data-chart="{{ json_encode($analytics['revenueSources']) }}"></div></div></div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h3 class="text-xl font-semibold">Patient Satisfaction</h3><p class="text-gray-500">Based on feedback surveys</p></div><div class="p-4 space-y-4">
                    @forelse($analytics['satisfaction'] as $feedback)<div class="flex justify-between items-center"><div><p class="text-sm font-medium">{{ $feedback->category }}</p><p class="text-xs text-gray-500">{{ $feedback->responses }} responses</p></div><span class="text-sm font-semibold">{{ number_format($feedback->rating, 1) }} average</span></div>@empty<p class="text-sm text-gray-500 py-6 text-center">No patient feedback in this period.</p>@endforelse
                </div></div>
                <div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h3 class="text-xl font-semibold">Staff Performance</h3><p class="text-gray-500">Top performing staff members</p></div><div class="p-4 space-y-4">
                    @forelse($analytics['staffPerformance'] as $review)<div class="flex items-center justify-between gap-3"><div class="flex items-center gap-3"><img src="{{ asset('user.png') }}" alt="" class="h-8 w-8 rounded-full"><div><p class="text-sm font-medium">{{ $review['name'] }}</p><p class="text-xs text-gray-500">{{ $review['reviews'] }} reviews</p></div></div><span class="text-sm font-semibold">{{ number_format($review['rating'], 1) }} average</span></div>@empty<p class="text-sm text-gray-500 py-6 text-center">No staff reviews in this period.</p>@endforelse
                </div></div>
            </div>
        </div>
        <div id="tab-reports" role="tabpanel" aria-labelledby="dashboard-tab-reports" class="tab-panel hidden mt-4 space-y-4">
            <div><h2 class="text-xl font-semibold">Available Reports</h2><p class="text-gray-500">Access detailed reports</p></div>
            <div class="rounded-lg border bg-background shadow-sm p-4"><h3 class="font-semibold mb-3">Financial Reports</h3><p class="text-sm text-gray-500 mb-3">Outstanding balance: <strong>{{ $currency->format($stats['outstanding']) }}</strong></p><a class="text-sm text-indigo-600 hover:underline" href="{{ route('web.reports.financial') }}">Monthly revenue and outstanding payments →</a></div>
            <div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h3 class="text-xl font-semibold">Recent invoices</h3></div><div class="overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr><th class="p-4 text-left">Invoice</th><th class="p-4 text-left">Patient</th><th class="p-4 text-right">Amount</th><th class="p-4 text-left">Status</th></tr></thead><tbody>@forelse($recentInvoices as $invoice)<tr class="border-b"><td class="p-4">{{ $invoice->code }}</td><td class="p-4">{{ $invoice->patient?->full_name ?? 'Patient record' }}</td><td class="p-4 text-right">@money($invoice->amount)</td><td class="p-4">{{ $invoice->status }}</td></tr>@empty<tr><td colspan="4" class="p-8 text-center text-gray-500">No invoices have been recorded.</td></tr>@endforelse</tbody></table></div></div>
        </div>
        <div id="tab-notifications" role="tabpanel" aria-labelledby="dashboard-tab-notifications" class="tab-panel hidden mt-4 space-y-4">
            <div><h2 class="text-xl font-semibold">Notifications</h2><p class="text-gray-500">Stay updated with important alerts and messages</p></div>
            <div class="rounded-lg border bg-background shadow-sm p-4">@forelse($dashboardNotifications as $notification)<div class="py-3 border-b"><h3 class="text-sm font-medium">{{ $notification->title }}</h3><p class="text-sm text-gray-500">{{ $notification->message }}</p><p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p></div>@empty<p class="text-gray-500">No new notifications.</p>@endforelse</div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts" crossorigin="anonymous"></script>
<script src="{{ asset('js/blade-dashboard.js') }}" defer></script>
@endpush

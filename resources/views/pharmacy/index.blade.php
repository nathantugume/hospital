@extends('layouts.app')

@section('title', 'Pharmacy')
@section('header', 'Pharmacy')

@section('content')
<div class="page-heading">
    <div><h1>Pharmacy</h1><p>Monitor medicine stock, expiry risk, and prescription activity.</p></div>
    <a class="button button-primary" href="{{ url('/add-medicine.html') }}">Add medicine</a>
</div>

<div class="stat-grid">
    <div class="stat-card"><div class="stat-card-top"><span class="label">Catalogue</span><span class="metric-icon">▣</span></div><strong class="value">{{ number_format($stats['catalogue']) }}</strong><span class="detail">Medicines tracked</span></div>
    <div class="stat-card"><div class="stat-card-top"><span class="label">Low stock</span><span class="metric-icon">!</span></div><strong class="value">{{ number_format($stats['low_stock']) }}</strong><span class="detail">At or below reorder level</span></div>
    <div class="stat-card"><div class="stat-card-top"><span class="label">Out of stock</span><span class="metric-icon">×</span></div><strong class="value">{{ number_format($stats['out_of_stock']) }}</strong><span class="detail">Requires replenishment</span></div>
    <div class="stat-card"><div class="stat-card-top"><span class="label">Expiring soon</span><span class="metric-icon">◷</span></div><strong class="value">{{ number_format($stats['expiring']) }}</strong><span class="detail">Within the next 90 days</span></div>
</div>

<form class="filters" method="GET" action="{{ route('web.pharmacy.index') }}">
    <div class="field"><label for="search">Search medicine</label><input id="search" name="search" value="{{ request('search') }}" placeholder="Name, generic name, or code"></div>
    <div class="field"><label for="stock">Stock view</label><select id="stock" name="stock"><option value="">All medicines</option><option value="low" @selected(request('stock') === 'low')>Low stock only</option></select></div>
    <button class="button button-primary" type="submit">Filter</button>
</form>

<div class="dashboard-grid dashboard-grid-primary">
    <section class="panel">
        <div class="panel-header"><div><span class="panel-kicker">Inventory</span><h2>{{ number_format($medicines->total()) }} medicines</h2></div><a class="text-link" href="{{ url('/stock-alerts.html') }}">Stock alerts</a></div>
        <div class="panel-body table-wrap">
            @if ($medicines->isEmpty())<div class="empty">No medicines match the selected filters.</div>@else
                <table><thead><tr><th>Medicine</th><th>Category</th><th>Stock</th><th>Price</th><th>Expiry</th><th>Status</th></tr></thead><tbody>
                @foreach ($medicines as $medicine)<tr>
                    <td><strong>{{ $medicine->name }}</strong><br><span class="muted">{{ $medicine->code }}{{ $medicine->generic_name ? ' · '.$medicine->generic_name : '' }}</span></td><td>{{ $medicine->category ?: 'General' }}</td><td>{{ number_format($medicine->stock) }} <span class="muted">/ {{ number_format($medicine->reorder_level) }}</span></td><td>@money($medicine->selling_price)</td><td>{{ optional($medicine->expiry)->format('d M Y') ?? '—' }}</td><td><span class="status status-{{ $medicine->stock <= 0 ? 'out-of-stock' : ($medicine->stock <= $medicine->reorder_level ? 'pending' : 'active') }}">{{ $medicine->stock <= 0 ? 'Out of stock' : ($medicine->stock <= $medicine->reorder_level ? 'Low stock' : 'In stock') }}</span></td>
                </tr>@endforeach
                </tbody></table>
                <div class="pagination"><span>Showing {{ $medicines->firstItem() }}–{{ $medicines->lastItem() }} of {{ $medicines->total() }}</span><span>{{ $medicines->links() }}</span></div>
            @endif
        </div>
    </section>
    <section class="panel">
        <div class="panel-header"><div><span class="panel-kicker">Prescriptions</span><h2>Recent activity</h2></div><a class="text-link" href="{{ url('/prescriptions.html') }}">All prescriptions</a></div>
        <div class="panel-body table-wrap">
            @if ($recentPrescriptions->isEmpty())<div class="empty">No prescriptions are available.</div>@else
                <table><thead><tr><th>Prescription</th><th>Patient</th><th>Date</th><th>Status</th></tr></thead><tbody>
                @foreach ($recentPrescriptions as $prescription)<tr><td><strong>{{ $prescription->code }}</strong></td><td>{{ $prescription->patient?->full_name ?? 'Unknown patient' }}</td><td>{{ optional($prescription->date)->format('d M Y') }}</td><td><span class="status status-{{ strtolower($prescription->status ?? 'active') }}">{{ $prescription->status ?? 'Active' }}</span></td></tr>@endforeach
                </tbody></table>
            @endif
        </div>
    </section>
</div>
@endsection

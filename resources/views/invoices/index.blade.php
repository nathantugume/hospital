@extends('layouts.app')

@section('title', 'Invoices')
@section('header', 'Billing')

@section('content')
<div class="page-heading">
    <div><h1>Invoices</h1><p>Review patient billing and outstanding balances.</p></div>
    <a class="button button-primary" href="{{ url('/create-invoice.html') }}">Create invoice</a>
</div>

<form class="filters" method="GET" action="{{ route('web.invoices.index') }}">
    <div class="field"><label for="search">Search</label><input id="search" name="search" value="{{ request('search') }}" placeholder="Invoice code or patient"></div>
    <div class="field"><label for="status">Status</label><select id="status" name="status"><option value="">All statuses</option>@foreach (['Pending', 'Partial', 'Paid', 'Overdue', 'Cancelled'] as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>@endforeach</select></div>
    <button class="button button-primary" type="submit">Filter</button>
</form>

<section class="panel">
    <div class="panel-header"><h2>{{ number_format($invoices->total()) }} invoices</h2></div>
    <div class="panel-body table-wrap">
        @if ($invoices->isEmpty())
            <div class="empty">No invoices match the selected filters.</div>
        @else
            <table><thead><tr><th>Invoice</th><th>Patient</th><th>Date</th><th>Amount</th><th>Balance</th><th>Status</th></tr></thead><tbody>
            @foreach ($invoices as $invoice)<tr>
                <td><strong>{{ $invoice->code }}</strong></td><td>{{ $invoice->patient?->full_name ?? '—' }}</td><td>{{ optional($invoice->date)->format('d M Y') }}</td><td>@money($invoice->amount)</td><td>@money($invoice->balance)</td><td><span class="status status-{{ strtolower($invoice->status ?? 'pending') }}">{{ $invoice->status ?? 'Pending' }}</span></td>
            </tr>@endforeach
            </tbody></table>
            <div class="pagination"><span>Showing {{ $invoices->firstItem() }}–{{ $invoices->lastItem() }} of {{ $invoices->total() }}</span><span>{{ $invoices->links() }}</span></div>
        @endif
    </div>
</section>
@endsection

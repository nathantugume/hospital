@extends('layouts.app')

@section('title', 'Settings')
@section('header', 'System settings')

@section('content')
<div class="page-heading">
    <div>
        <h1>System settings</h1>
        <p>Configure defaults used across the hospital workspace.</p>
    </div>
</div>

<section class="panel">
    <div class="panel-header">
        <div>
            <h2>Currency</h2>
            <p class="muted">Choose the display currency for dashboard and billing totals.</p>
        </div>
    </div>
    <div class="panel-body">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="auth-form" style="max-width: 520px; padding-top: 18px">
            @csrf
            @method('PUT')
            <div class="field">
                <label for="currency">Default currency</label>
                <select id="currency" name="currency" required>
                    @foreach ($currencies as $code => $definition)
                        <option value="{{ $code }}" @selected($currency->code() === $code)>{{ $code }} - {{ $definition['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <p class="muted">Preview: <strong>@money(125000)</strong></p>
            <div><button class="button button-primary" type="submit">Save currency</button></div>
        </form>
    </div>
</section>
@endsection

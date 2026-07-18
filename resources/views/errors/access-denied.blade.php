@extends('layouts.app')

@section('title', 'Access denied')

@section('content')
<section class="panel" style="max-width: 640px; margin: 70px auto; padding: 28px; text-align: center;">
    <h1>Access denied</h1>
    <p class="muted">Your account does not have permission to open this area.</p>
    <a class="button button-primary" href="{{ route('dashboard') }}">Return to dashboard</a>
</section>
@endsection

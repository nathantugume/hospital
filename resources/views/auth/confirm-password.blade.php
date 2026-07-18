@extends('layouts.guest')

@section('title', 'Confirm password')
@section('heading', 'Confirm your password')

@section('content')
<p class="intro">For security, confirm your password before continuing.</p>
<form class="auth-form" method="POST" action="{{ route('password.confirm.store') }}">
    @csrf
    <div class="field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" autocomplete="current-password" required autofocus>
    </div>
    <button class="button button-primary" type="submit">Confirm password</button>
</form>
@endsection

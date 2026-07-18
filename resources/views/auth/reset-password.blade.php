@extends('layouts.guest')

@section('title', 'Choose a new password')
@section('heading', 'Choose a new password')

@section('content')
<p class="intro">Set a new password for your MediTrack account.</p>
<form class="auth-form" method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <div class="field">
        <label for="email">Email address</label>
        <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" autocomplete="email" required autofocus>
    </div>
    <div class="field">
        <label for="password">New password</label>
        <input id="password" name="password" type="password" autocomplete="new-password" required>
    </div>
    <div class="field">
        <label for="password_confirmation">Confirm password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
    </div>
    <button class="button button-primary" type="submit">Reset password</button>
</form>
@endsection

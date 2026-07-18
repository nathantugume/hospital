@extends('layouts.guest')

@section('title', 'Create account')
@section('heading', 'Create your account')

@section('content')
<p class="intro">Create a patient account to request care and view your records.</p>
<form class="auth-form" method="POST" action="{{ route('register.store') }}">
    @csrf
    <div class="field">
        <label for="name">Full name</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" autocomplete="name" required autofocus>
    </div>
    <div class="field">
        <label for="email">Email address</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>
    </div>
    <div class="field">
        <label for="phone">Phone number <span class="muted">(optional)</span></label>
        <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" autocomplete="tel">
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" autocomplete="new-password" required>
    </div>
    <div class="field">
        <label for="password_confirmation">Confirm password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required>
    </div>
    <button class="button button-primary" type="submit">Create account</button>
</form>
<p class="auth-switch">Already registered? <a href="{{ route('login') }}">Sign in</a></p>
@endsection

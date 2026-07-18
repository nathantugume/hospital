@extends('layouts.guest')

@section('title', 'Reset password')
@section('heading', 'Forgot your password?')

@section('content')
<p class="intro">Enter your email address and we will send a password reset link.</p>
<form class="auth-form" method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="field">
        <label for="email">Email address</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
    </div>
    <button class="button button-primary" type="submit">Email reset link</button>
</form>
<p class="auth-switch"><a href="{{ route('login') }}">Back to sign in</a></p>
@endsection

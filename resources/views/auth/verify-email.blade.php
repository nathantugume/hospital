@extends('layouts.guest')

@section('title', 'Verify email')
@section('heading', 'Verify your email')

@section('content')
<p class="intro">We sent a verification link to <strong>{{ auth()->user()->email }}</strong>. Check your inbox before continuing.</p>
<form class="auth-form" method="POST" action="{{ route('verification.send') }}">
    @csrf
    <button class="button button-primary" type="submit">Resend verification email</button>
</form>
<form class="auth-form" method="POST" action="{{ route('logout') }}" style="margin-top: 10px;">
    @csrf
    <button class="button logout-button" type="submit">Sign out</button>
</form>
@endsection

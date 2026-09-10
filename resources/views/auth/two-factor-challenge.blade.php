@extends('layouts.guest')

@section('title', 'Two-factor verification')
@section('heading', 'Verify your identity')

@section('content')
<p class="intro">Enter the authentication code from your app, or use a recovery code.</p>
<form class="auth-form" method="POST" action="{{ route('two-factor.login.store') }}">
    @csrf
    <div class="field">
        <label for="code">Authentication code</label>
        <input id="code" name="code" type="text" inputmode="numeric" autocomplete="one-time-code" autofocus>
    </div>
    <div class="field">
        <label for="recovery_code">Recovery code <span class="muted">(optional)</span></label>
        <input id="recovery_code" name="recovery_code" type="text" autocomplete="off">
    </div>
    <label class="check-row"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
    <button class="button button-primary" type="submit">Verify and continue</button>
</form>
<p class="auth-switch"><a href="{{ route('login') }}">Start over</a></p>
@endsection

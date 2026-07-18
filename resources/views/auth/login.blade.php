<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign in | MediTrack HMS</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('blade.css') }}">
</head>
<body>
<main class="auth-shell">
    <section class="auth-card" aria-labelledby="login-heading">
        <div class="auth-brand">
            <img src="{{ asset('logo.png') }}" alt="MediTrack">
            <div><strong>MediTrack HMS</strong><span>Hospital operations, connected</span></div>
        </div>
        <h1 id="login-heading">Sign in</h1>
        <p class="intro">Use your clinical or administration account to continue.</p>

        <section class="demo-credentials" aria-labelledby="demo-access-heading">
            <div class="demo-credentials-heading">
                <div>
                    <strong id="demo-access-heading">Demo access</strong>
                    <span>For testing this demo site</span>
                </div>
                <span class="demo-badge">Test accounts</span>
            </div>
            <p class="demo-credentials-note">All demo accounts use the password <code>password123</code>.</p>
            <dl class="demo-account-list">
                <div><dt>Admin</dt><dd><code>admin@meditrack.ea</code></dd></div>
                <div><dt>Super admin</dt><dd><code>superadmin@meditrack.ea</code></dd></div>
                <div><dt>Doctor</dt><dd><code>doctor@meditrack.ea</code></dd></div>
                <div><dt>Nurse</dt><dd><code>nurse@meditrack.ea</code></dd></div>
                <div><dt>Receptionist</dt><dd><code>receptionist@meditrack.ea</code></dd></div>
                <div><dt>Laboratory</dt><dd><code>lab@meditrack.ea</code></dd></div>
                <div><dt>Pharmacy</dt><dd><code>pharmacist@meditrack.ea</code></dd></div>
                <div><dt>Patient</dt><dd><code>patient@meditrack.ea</code></dd></div>
            </dl>
        </section>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="auth-form" method="POST" action="{{ route('login.store') }}">
            @csrf
            <div class="field">
                <label for="email">Email address</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
            </div>
            <div class="field">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required>
            </div>
            <label class="check-row"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
            <button class="button button-primary" type="submit">Sign in</button>
        </form>
        <p class="auth-switch"><a href="{{ route('password.request') }}">Forgot password?</a></p>
        <p class="auth-switch">Need an account? <a href="{{ route('register') }}">Create one</a></p>
    </section>
</main>
</body>
</html>

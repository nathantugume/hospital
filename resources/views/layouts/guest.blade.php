<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Account') | MediTrack HMS</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('blade.css') }}">
</head>
<body>
<main class="auth-shell">
    <section class="auth-card" aria-labelledby="auth-heading">
        <div class="auth-brand">
            <img src="{{ asset('logo.png') }}" alt="MediTrack">
            <div><strong>MediTrack HMS</strong><span>Hospital operations, connected</span></div>
        </div>

        <h1 id="auth-heading">@yield('heading')</h1>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-error">
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </section>
</main>
</body>
</html>

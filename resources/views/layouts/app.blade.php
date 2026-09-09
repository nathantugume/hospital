<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Medi-track | @yield('title', 'Dashboard')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="{{ asset('blade.css') }}">
    @yield('head')
    @stack('styles')
    <script src="{{ asset('js/blade-ui.js') }}" defer></script>
</head>
<body class="bg-gray-50 antialiased meditrack-blade">
    @include('partials.header')
    <div class="flex flex-1 items-start relative">
        @include('partials.sidebar')
        <button type="button" class="blade-backdrop" data-menu-close aria-label="Close navigation" hidden></button>
        <main id="main-content" class="flex-1 overflow-auto p-4 xl:p-6 w-full">
            @if (session('status'))
                <div role="status" class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div role="alert" class="alert alert-error">
                    <ul class="error-list">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>

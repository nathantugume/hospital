<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'MediTrack HMS') | MediTrack HMS</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('blade.css') }}">
    @stack('styles')
</head>
<body>
<div class="app-shell">
    @include('partials.sidebar')
    <button class="sidebar-backdrop" type="button" data-menu-close aria-label="Close navigation"></button>

    <div class="app-main">
        @include('partials.header')

        <main class="page-content">
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
        </main>

        <footer class="app-footer">MediTrack HMS · {{ now()->format('Y') }}</footer>
    </div>
</div>
<script>
    const sidebar = document.querySelector('[data-sidebar]');
    const menuToggle = document.querySelector('[data-menu-toggle]');
    const closeButtons = document.querySelectorAll('[data-menu-close]');
    const setNavigationOpen = (isOpen) => {
        sidebar?.classList.toggle('is-open', isOpen);
        document.querySelector('.sidebar-backdrop')?.classList.toggle('is-visible', isOpen);
        menuToggle?.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    };

    menuToggle?.addEventListener('click', () => setNavigationOpen(true));
    closeButtons.forEach((button) => button.addEventListener('click', () => setNavigationOpen(false)));
    sidebar?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setNavigationOpen(false)));
</script>
@stack('scripts')
</body>
</html>

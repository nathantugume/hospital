<header class="app-header">
    <div class="header-actions">
        <button class="menu-button" type="button" data-menu-toggle aria-label="Open navigation">☰</button>
        <div class="header-title">@yield('header', 'Clinical operations')</div>
    </div>

    <div class="header-actions">
        <div class="user-chip">
            <span class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <span>{{ auth()->user()->name }} · {{ auth()->user()->role_label }}</span>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-button" type="submit">Sign out</button>
        </form>
    </div>
</header>

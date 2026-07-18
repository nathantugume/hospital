<aside class="app-sidebar" id="primary-navigation" data-sidebar>
    <div class="sidebar-top">
        <a class="brand" href="{{ route('dashboard') }}">
            <img src="{{ asset('logo.png') }}" alt="MediTrack">
            <span>MediTrack<small>Hospital management</small></span>
        </a>
        <button class="sidebar-close" type="button" data-menu-close aria-label="Close navigation">&times;</button>
    </div>

    <div class="sidebar-context">
        <span class="live-dot" aria-hidden="true"></span>
        <span>{{ auth()->user()->isAdmin() ? 'Admin workspace' : 'Care workspace' }}</span>
        <small>Demo site</small>
    </div>

    <nav class="sidebar-nav" aria-label="Primary navigation">
        @if (auth()->user()->isAdmin())
            <div class="nav-label">Overview</div>
            <a class="nav-link {{ request()->routeIs('dashboard', 'admin.dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon" aria-hidden="true">⌂</span><span>Dashboard</span></a>

            <div class="nav-label">Care operations</div>
            @if (Route::has('web.patients.index'))
                <a class="nav-link {{ request()->routeIs('web.patients.*') ? 'active' : '' }}" href="{{ route('web.patients.index') }}"><span class="nav-icon" aria-hidden="true">◉</span><span>Patients</span></a>
            @endif
            <a class="nav-link {{ request()->is('appointments.html') ? 'active' : '' }}" href="{{ url('/appointments.html') }}"><span class="nav-icon" aria-hidden="true">◷</span><span>Appointments</span></a>
            <a class="nav-link {{ request()->is('doctors.html') ? 'active' : '' }}" href="{{ url('/doctors.html') }}"><span class="nav-icon" aria-hidden="true">✚</span><span>Care team</span></a>
            <a class="nav-link {{ request()->is('lab-dashboard.html') ? 'active' : '' }}" href="{{ url('/lab-dashboard.html') }}"><span class="nav-icon" aria-hidden="true">◇</span><span>Laboratory</span></a>
            <a class="nav-link {{ request()->is('medicine.html') ? 'active' : '' }}" href="{{ url('/medicine.html') }}"><span class="nav-icon" aria-hidden="true">▣</span><span>Pharmacy</span></a>

            <div class="nav-label">Finance</div>
            @if (Route::has('web.invoices.index'))
                <a class="nav-link {{ request()->routeIs('web.invoices.*') ? 'active' : '' }}" href="{{ route('web.invoices.index') }}"><span class="nav-icon" aria-hidden="true">▤</span><span>Invoices</span></a>
            @endif
            <a class="nav-link {{ request()->is('financial-reports.html') ? 'active' : '' }}" href="{{ url('/financial-reports.html') }}"><span class="nav-icon" aria-hidden="true">▥</span><span>Reports</span></a>

            <div class="nav-label">Administration</div>
            <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}"><span class="nav-icon" aria-hidden="true">⚙</span><span>Settings</span></a>
        @elseif (! auth()->user()->isPatient())
            <div class="nav-label">Workspace</div>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon" aria-hidden="true">⌂</span><span>Dashboard</span></a>
            <div class="nav-label">Clinical</div>
            @if (Route::has('web.patients.index') && auth()->user()->hasRole(['doctor', 'nurse', 'receptionist', 'lab_technician', 'pharmacist', 'accountant', 'insurance_officer']))
                <a class="nav-link {{ request()->routeIs('web.patients.*') ? 'active' : '' }}" href="{{ route('web.patients.index') }}"><span class="nav-icon" aria-hidden="true">◉</span><span>Patients</span></a>
            @endif
            <a class="nav-link" href="{{ url('/appointments.html') }}"><span class="nav-icon" aria-hidden="true">◷</span><span>Appointments</span></a>
            <a class="nav-link" href="{{ url('/doctors.html') }}"><span class="nav-icon" aria-hidden="true">✚</span><span>Care team</span></a>
            <a class="nav-link" href="{{ url('/lab-dashboard.html') }}"><span class="nav-icon" aria-hidden="true">◇</span><span>Laboratory</span></a>
            <a class="nav-link" href="{{ url('/medicine.html') }}"><span class="nav-icon" aria-hidden="true">▣</span><span>Pharmacy</span></a>
        @else
            <div class="nav-label">My care</div>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon" aria-hidden="true">⌂</span><span>Dashboard</span></a>
            <a class="nav-link" href="{{ url('/patient-dashboard.html') }}"><span class="nav-icon" aria-hidden="true">◉</span><span>My record</span></a>
            <a class="nav-link" href="{{ url('/appointments.html') }}"><span class="nav-icon" aria-hidden="true">◷</span><span>Appointments</span></a>
            <a class="nav-link" href="{{ url('/prescriptions.html') }}"><span class="nav-icon" aria-hidden="true">▣</span><span>Prescriptions</span></a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <span class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
        <div><small>Signed in as</small><strong>{{ auth()->user()->role_label }}</strong></div>
    </div>
</aside>

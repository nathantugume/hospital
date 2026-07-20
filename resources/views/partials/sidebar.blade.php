@php
    $navUser = auth()->user();
    $workspaceLabel = match (true) {
        $navUser->isAdmin() => 'Admin workspace',
        $navUser->isDoctor() => 'Doctor workspace',
        $navUser->isNurse() => 'Nurse workspace',
        $navUser->isReceptionist() => 'Front desk workspace',
        $navUser->isLabTech() => 'Laboratory workspace',
        $navUser->isPharmacist() => 'Pharmacy workspace',
        $navUser->isPatient() => 'Patient workspace',
        $navUser->isAccountant(), $navUser->isInsuranceOfficer() => 'Finance workspace',
        default => 'Care workspace',
    };
@endphp
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
        <span>{{ $workspaceLabel }}</span>
        <small>Demo site</small>
    </div>

    <nav class="sidebar-nav" aria-label="Primary navigation">
        @if ($navUser->isAdmin())
            <div class="nav-label">Overview</div>
            <a class="nav-link {{ request()->routeIs('dashboard', 'admin.dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon" aria-hidden="true">⌂</span><span>Dashboard</span></a>

            <div class="nav-label">Care operations</div>
            <a class="nav-link {{ request()->routeIs('web.patients.*') ? 'active' : '' }}" href="{{ route('web.patients.index') }}"><span class="nav-icon" aria-hidden="true">◉</span><span>Patients</span></a>
            <a class="nav-link {{ request()->routeIs('web.appointments.*') ? 'active' : '' }}" href="{{ route('web.appointments.index') }}"><span class="nav-icon" aria-hidden="true">◷</span><span>Appointments</span></a>
            <a class="nav-link {{ request()->routeIs('web.staff.*') ? 'active' : '' }}" href="{{ route('web.staff.index') }}"><span class="nav-icon" aria-hidden="true">✚</span><span>Care team</span></a>
            <a class="nav-link {{ request()->routeIs('web.laboratory.*') ? 'active' : '' }}" href="{{ route('web.laboratory.index') }}"><span class="nav-icon" aria-hidden="true">◇</span><span>Laboratory</span></a>
            <a class="nav-link {{ request()->routeIs('web.pharmacy.*') ? 'active' : '' }}" href="{{ route('web.pharmacy.index') }}"><span class="nav-icon" aria-hidden="true">▣</span><span>Pharmacy</span></a>

            <div class="nav-label">Finance</div>
            <a class="nav-link {{ request()->routeIs('web.invoices.*') ? 'active' : '' }}" href="{{ route('web.invoices.index') }}"><span class="nav-icon" aria-hidden="true">▤</span><span>Invoices</span></a>
            <span class="nav-link nav-link-soon"><span class="nav-icon" aria-hidden="true">▥</span><span>Reports</span><span class="soon-badge">Soon</span></span>

            <div class="nav-label">Administration</div>
            <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}"><span class="nav-icon" aria-hidden="true">⚙</span><span>Settings</span></a>
        @elseif ($navUser->isDoctor())
            <div class="nav-label">Workspace</div>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon" aria-hidden="true">⌂</span><span>My dashboard</span></a>

            <div class="nav-label">Clinical</div>
            <a class="nav-link {{ request()->routeIs('web.appointments.*') ? 'active' : '' }}" href="{{ route('web.appointments.index') }}"><span class="nav-icon" aria-hidden="true">◷</span><span>My schedule</span></a>
            <a class="nav-link {{ request()->routeIs('web.patients.*') ? 'active' : '' }}" href="{{ route('web.patients.index') }}"><span class="nav-icon" aria-hidden="true">◉</span><span>My patients</span></a>
            <span class="nav-link nav-link-soon"><span class="nav-icon" aria-hidden="true">℞</span><span>Write prescription</span><span class="soon-badge">Soon</span></span>
            <a class="nav-link {{ request()->routeIs('web.laboratory.*') ? 'active' : '' }}" href="{{ route('web.laboratory.index') }}"><span class="nav-icon" aria-hidden="true">◇</span><span>Laboratory</span></a>
        @elseif ($navUser->isNurse())
            <div class="nav-label">Workspace</div>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon" aria-hidden="true">⌂</span><span>Nurse station</span></a>

            <div class="nav-label">Care</div>
            <a class="nav-link {{ request()->routeIs('web.appointments.*') ? 'active' : '' }}" href="{{ route('web.appointments.index') }}"><span class="nav-icon" aria-hidden="true">◷</span><span>Appointments</span></a>
            <a class="nav-link {{ request()->routeIs('web.patients.*') ? 'active' : '' }}" href="{{ route('web.patients.index') }}"><span class="nav-icon" aria-hidden="true">◉</span><span>Patients</span></a>
            <a class="nav-link {{ request()->routeIs('web.staff.*') ? 'active' : '' }}" href="{{ route('web.staff.index') }}"><span class="nav-icon" aria-hidden="true">✚</span><span>Care team</span></a>
            <a class="nav-link {{ request()->routeIs('web.pharmacy.*') ? 'active' : '' }}" href="{{ route('web.pharmacy.index') }}"><span class="nav-icon" aria-hidden="true">▣</span><span>Medication</span></a>
            <a class="nav-link {{ request()->routeIs('web.laboratory.*') ? 'active' : '' }}" href="{{ route('web.laboratory.index') }}"><span class="nav-icon" aria-hidden="true">◇</span><span>Laboratory</span></a>
        @elseif ($navUser->isReceptionist())
            <div class="nav-label">Workspace</div>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon" aria-hidden="true">⌂</span><span>Front desk</span></a>

            <div class="nav-label">Front office</div>
            <a class="nav-link {{ request()->routeIs('web.appointments.*') ? 'active' : '' }}" href="{{ route('web.appointments.index') }}"><span class="nav-icon" aria-hidden="true">◷</span><span>Appointment queue</span></a>
            <a class="nav-link {{ request()->routeIs('web.patients.*') ? 'active' : '' }}" href="{{ route('web.patients.index') }}"><span class="nav-icon" aria-hidden="true">◉</span><span>Patient registration</span></a>
            <a class="nav-link {{ request()->routeIs('web.staff.*') ? 'active' : '' }}" href="{{ route('web.staff.index') }}"><span class="nav-icon" aria-hidden="true">✚</span><span>Care team</span></a>
        @elseif ($navUser->isLabTech())
            <div class="nav-label">Workspace</div>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon" aria-hidden="true">⌂</span><span>Lab dashboard</span></a>

            <div class="nav-label">Laboratory</div>
            <a class="nav-link {{ request()->routeIs('web.laboratory.*') ? 'active' : '' }}" href="{{ route('web.laboratory.index') }}"><span class="nav-icon" aria-hidden="true">◇</span><span>Requests and results</span></a>
            <span class="nav-link nav-link-soon"><span class="nav-icon" aria-hidden="true">▧</span><span>Test requests</span><span class="soon-badge">Soon</span></span>
            <span class="nav-link nav-link-soon"><span class="nav-icon" aria-hidden="true">⚙</span><span>Lab equipment</span><span class="soon-badge">Soon</span></span>
            <a class="nav-link {{ request()->routeIs('web.patients.*') ? 'active' : '' }}" href="{{ route('web.patients.index') }}"><span class="nav-icon" aria-hidden="true">◉</span><span>Patients</span></a>
        @elseif ($navUser->isPharmacist())
            <div class="nav-label">Workspace</div>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon" aria-hidden="true">⌂</span><span>Pharmacy dashboard</span></a>

            <div class="nav-label">Pharmacy</div>
            <a class="nav-link {{ request()->routeIs('web.pharmacy.*') ? 'active' : '' }}" href="{{ route('web.pharmacy.index') }}"><span class="nav-icon" aria-hidden="true">▣</span><span>Inventory</span></a>
            <span class="nav-link nav-link-soon"><span class="nav-icon" aria-hidden="true">℞</span><span>Prescriptions</span><span class="soon-badge">Soon</span></span>
            <span class="nav-link nav-link-soon"><span class="nav-icon" aria-hidden="true">!</span><span>Stock alerts</span><span class="soon-badge">Soon</span></span>
            <a class="nav-link {{ request()->routeIs('web.patients.*') ? 'active' : '' }}" href="{{ route('web.patients.index') }}"><span class="nav-icon" aria-hidden="true">◉</span><span>Patients</span></a>
        @elseif ($navUser->isAccountant() || $navUser->isInsuranceOfficer())
            <div class="nav-label">Workspace</div>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon" aria-hidden="true">⌂</span><span>Finance dashboard</span></a>

            <div class="nav-label">Finance</div>
            <a class="nav-link {{ request()->routeIs('web.invoices.*') ? 'active' : '' }}" href="{{ route('web.invoices.index') }}"><span class="nav-icon" aria-hidden="true">▤</span><span>Invoices</span></a>
            <span class="nav-link nav-link-soon"><span class="nav-icon" aria-hidden="true">❖</span><span>Insurance claims</span><span class="soon-badge">Soon</span></span>
            <span class="nav-link nav-link-soon"><span class="nav-icon" aria-hidden="true">▥</span><span>Reports</span><span class="soon-badge">Soon</span></span>
            <a class="nav-link {{ request()->routeIs('web.patients.*') ? 'active' : '' }}" href="{{ route('web.patients.index') }}"><span class="nav-icon" aria-hidden="true">◉</span><span>Patients</span></a>
        @elseif ($navUser->isPatient())
            <div class="nav-label">My care</div>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon" aria-hidden="true">⌂</span><span>Dashboard</span></a>
            <a class="nav-link {{ request()->routeIs('web.appointments.*') ? 'active' : '' }}" href="{{ route('web.appointments.index') }}"><span class="nav-icon" aria-hidden="true">◷</span><span>Appointments</span></a>
            <span class="nav-link nav-link-soon"><span class="nav-icon" aria-hidden="true">◉</span><span>My record</span><span class="soon-badge">Soon</span></span>
            <span class="nav-link nav-link-soon"><span class="nav-icon" aria-hidden="true">℞</span><span>Prescriptions</span><span class="soon-badge">Soon</span></span>
            <span class="nav-link nav-link-soon"><span class="nav-icon" aria-hidden="true">◇</span><span>Lab results</span><span class="soon-badge">Soon</span></span>
            <span class="nav-link nav-link-soon"><span class="nav-icon" aria-hidden="true">▤</span><span>Billing</span><span class="soon-badge">Soon</span></span>
        @else
            <div class="nav-label">Workspace</div>
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon" aria-hidden="true">⌂</span><span>Dashboard</span></a>
            <div class="nav-label">Clinical</div>
            <a class="nav-link {{ request()->routeIs('web.patients.*') ? 'active' : '' }}" href="{{ route('web.patients.index') }}"><span class="nav-icon" aria-hidden="true">◉</span><span>Patients</span></a>
            <a class="nav-link {{ request()->routeIs('web.appointments.*') ? 'active' : '' }}" href="{{ route('web.appointments.index') }}"><span class="nav-icon" aria-hidden="true">◷</span><span>Appointments</span></a>
            <a class="nav-link {{ request()->routeIs('web.staff.*') ? 'active' : '' }}" href="{{ route('web.staff.index') }}"><span class="nav-icon" aria-hidden="true">✚</span><span>Care team</span></a>
            <a class="nav-link {{ request()->routeIs('web.laboratory.*') ? 'active' : '' }}" href="{{ route('web.laboratory.index') }}"><span class="nav-icon" aria-hidden="true">◇</span><span>Laboratory</span></a>
            <a class="nav-link {{ request()->routeIs('web.pharmacy.*') ? 'active' : '' }}" href="{{ route('web.pharmacy.index') }}"><span class="nav-icon" aria-hidden="true">▣</span><span>Pharmacy</span></a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <span class="avatar">{{ strtoupper(substr($navUser->name, 0, 1)) }}</span>
        <div><small>Signed in as</small><strong>{{ $navUser->role_label }}</strong></div>
    </div>
</aside>

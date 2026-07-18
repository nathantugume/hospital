<aside class="app-sidebar" data-sidebar>
    <a class="brand" href="{{ route('dashboard') }}">
        <img src="{{ asset('logo.png') }}" alt="MediTrack">
        <span>MediTrack<small>Hospital management</small></span>
    </a>

    <div class="nav-label">Workspace</div>
    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><span class="nav-icon">◈</span>Dashboard</a>

    @if (! auth()->user()->isPatient())
        <div class="nav-label">Clinical</div>
        @if (Route::has('web.patients.index') && auth()->user()->hasRole(['super_admin', 'admin', 'doctor', 'nurse', 'receptionist', 'lab_technician', 'pharmacist', 'accountant', 'insurance_officer']))
            <a class="nav-link {{ request()->routeIs('web.patients.*') ? 'active' : '' }}" href="{{ route('web.patients.index') }}"><span class="nav-icon">◉</span>Patients</a>
        @endif
        <a class="nav-link" href="{{ url('/appointments.html') }}"><span class="nav-icon">◷</span>Appointments</a>
        <a class="nav-link" href="{{ url('/doctors.html') }}"><span class="nav-icon">✚</span>Care team</a>
        <a class="nav-link" href="{{ url('/lab-dashboard.html') }}"><span class="nav-icon">◇</span>Laboratory</a>
        <a class="nav-link" href="{{ url('/medicine.html') }}"><span class="nav-icon">▣</span>Pharmacy</a>

        <div class="nav-label">Finance</div>
        @if (Route::has('web.invoices.index') && auth()->user()->hasRole(['super_admin', 'admin', 'accountant', 'insurance_officer']))
            <a class="nav-link {{ request()->routeIs('web.invoices.*') ? 'active' : '' }}" href="{{ route('web.invoices.index') }}"><span class="nav-icon">▤</span>Invoices</a>
        @endif
        <a class="nav-link" href="{{ url('/financial-reports.html') }}"><span class="nav-icon">▥</span>Reports</a>
    @else
        <div class="nav-label">My care</div>
        <a class="nav-link" href="{{ url('/patient-dashboard.html') }}"><span class="nav-icon">◉</span>My record</a>
        <a class="nav-link" href="{{ url('/appointments.html') }}"><span class="nav-icon">◷</span>Appointments</a>
        <a class="nav-link" href="{{ url('/prescriptions.html') }}"><span class="nav-icon">▣</span>Prescriptions</a>
    @endif
</aside>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
        <link rel="icon" type="image/png" href="favicon.png">
    <title>Medi-track | Sign In</title>
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="style.css">
    
    </script>
</head>
<body class="bg-gray-50 antialiased">

<div class="flex min-h-screen items-center justify-center px-4 py-12">
    <div class="w-full max-w-md space-y-8">
        <!-- Logo / Header -->
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <img src="logo.png" alt="Medi-track Logo" class="w-12 h-12 object-contain" ">
            </div>
            <h2 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2 text-gray-900">Medi-track</h2>
            <p class="mt-2 text-gray-500">Healthcare administration simplified</p>
        </div>

        <!-- Login Card -->
        <div class="rounded-lg border bg-background shadow-sm border-gray-200">
            <div class="flex flex-col space-y-1.5 p-6">
                <h2 class="text-xl font-semibold tracking-tight text-gray-900">Sign in to your account</h2>
                <div class="text-gray-500">Enter your credentials to access the dashboard</div>
            </div>

            <form id="loginForm">
                <div class="p-6 pt-0 space-y-4">
                    <!-- Error Message (hidden by default) -->
                    <div id="errorMessage" class="hidden rounded-md bg-red-50 border border-red-200 p-3 text-sm text-red-700">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" >
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" x2="12" y1="8" y2="12"></line>
                                <line x1="12" x2="12.01" y1="16" y2="16"></line>
                            </svg>
                            <span id="errorText">Invalid email or password</span>
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700" for="email">Email</label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-3 h-4 w-4 text-gray-400">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                            <input class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 pl-10 text-gray-900" 
                                   id="email" placeholder="name@meditrack.com" required type="email" value="admin@meditrack.com">
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-700" for="password">Password</label>
                            <a class="text-xs text-indigo-600 hover:text-indigo-700" href="forgot-password.html">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-3 h-4 w-4 text-gray-400">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 pl-10 text-gray-900" 
                                   id="password" placeholder="Password" required type="password" value="password123">
                            <button type="button" id="togglePassword" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me Checkbox (Radix UI style) -->
                    <div class="flex items-center space-x-2">
                        <button type="button" role="checkbox" aria-checked="false" id="rememberCheckbox" 
                                class="remember-checkbox peer h-4 w-4 shrink-0 rounded-sm border border-gray-300 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=checked]:bg-primary data-[state=checked]:border-indigo-600 flex items-center justify-center">
                        </button>
                        <label class="text-sm font-medium text-gray-700 cursor-pointer" for="rememberCheckbox">Remember me for 30 days</label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="items-center p-6 pt-0 flex flex-col space-y-4">
                    <button type="submit" id="signInBtn" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 w-full shadow-sm">
                        <svg class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" >
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                            <polyline points="10 17 15 12 10 7"></polyline>
                            <line x1="15" x2="3" y1="12" y2="12"></line>
                        </svg>
                        Sign in
                    </button>
                    <p class="text-center text-sm text-gray-500">
                        Don't have an account? 
                        <a class="text-indigo-600 hover:text-indigo-700 font-medium" href="register.html">Create an account</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>






<!-- 1. Settings Manager (MUST be first) -->
<script src="js/features/settings-manager.js"></script>

<!-- 2. Core UI -->
<script src="js/core/theme.js"></script>
<script src="js/core/sidebar.js"></script>
<script src="js/core/accordion.js"></script>
<script src="js/core/notifications.js"></script>
<script src="js/core/profile.js"></script>

<!-- 3. Features -->
<script src="js/features/currency.js"></script>
<script src="js/features/tabs.js"></script>   
<script src="js/features/pip-widget.js"></script>
<script src="js/features/regional.js"></script>
<script src="js/features/language.js"></script>

<!-- 4. Main Init (last) -->
<script src="js/init.js"></script>


<script>
    /**
     * Meditrack HMS — Login Flow with Role-Based Dashboards
     *
     * Each user role has its own dashboard:
     *   - super_admin      → super-admin.html
     *   - admin             → index.html
     *   - doctor            → doctor-dashboard.html
     *   - nurse             → nurse-station.html
     *   - receptionist      → appointments.html
     *   - lab_technician    → lab-dashboard.html
     *   - pharmacist        → medicine.html
     *   - radiology_tech    → radiology-list.html
     *   - physiotherapist   → physiotherapy-dashboard.html
     *   - surgeon           → ot-dashboard.html
     *   - blood_bank_staff  → blood-stock.html
     *   - ambulance_driver  → ambulance-calls.html
     *   - ambulance_dispatcher → dispatch.html
     *   - patient           → patient-dashboard.html
     *   - accountant        → billing.html
     *   - insurance_officer → insurance-claims.html
     *   - hr_manager        → staff-management.html
     *   - inventory_manager → inventory.html
     *
     * Demo credentials for all 18 roles are listed below.
     * In production, replace this with a real API call to /api/v1/auth/login.
     */

    // ============================================================
    // DEMO CREDENTIALS — one per role (all password = "password123")
    // ============================================================
    const DEMO_USERS = {
        // === PRIMARY ACCOUNTS (user-requested) ===
        'superadmin@meditrack.com':     { password: 'password123', role: 'super_admin',         name: 'Ssentongo James',       dashboard: 'super-admin.html' },
        'admin@meditrack.com':          { password: 'password123', role: 'admin',                name: 'Nakato Sarah',          dashboard: 'index.html' },
        'doctor@meditrack.com':         { password: 'password123', role: 'doctor',               name: 'Dr. Mwangi Peter',      dashboard: 'doctor-dashboard.html' },
        'nurse@meditrack.com':          { password: 'password123', role: 'nurse',                name: 'Nalwoga Sarah',         dashboard: 'nurse-station.html' },
        'business@meditrack.com':       { password: 'password123', role: 'super_admin',         name: 'Business Manager',      dashboard: 'business-dashboard.html' },
        'patient@meditrack.com':        { password: 'password123', role: 'patient',              name: 'Okello David',          dashboard: 'patient-dashboard.html' },

        // === SECONDARY ROLE ACCOUNTS (for completeness) ===
        'receptionist@meditrack.com':   { password: 'password123', role: 'receptionist',         name: 'Akampa David',          dashboard: 'appointments.html' },
        'lab@meditrack.com':            { password: 'password123', role: 'lab_technician',       name: 'Kibirige John',         dashboard: 'lab-dashboard.html' },
        'pharmacist@meditrack.com':     { password: 'password123', role: 'pharmacist',           name: 'Ssemwogerere David',    dashboard: 'medicine.html' },
        'radiology@meditrack.com':      { password: 'password123', role: 'radiology_technician', name: 'Nabwire Emily',         dashboard: 'radiology-list.html' },
        'physio@meditrack.com':         { password: 'password123', role: 'physiotherapist',      name: 'Kemigisha Jennifer',    dashboard: 'physiotherapy-dashboard.html' },
        'surgeon@meditrack.com':        { password: 'password123', role: 'surgeon',              name: 'Dr. Okello James',      dashboard: 'ot-dashboard.html' },
        'bloodbank@meditrack.com':      { password: 'password123', role: 'blood_bank_staff',     name: 'Nabisere Patricia',     dashboard: 'blood-stock.html' },
        'driver@meditrack.com':         { password: 'password123', role: 'ambulance_driver',     name: 'Mukasa David',          dashboard: 'ambulance-calls.html' },
        'dispatcher@meditrack.com':     { password: 'password123', role: 'ambulance_dispatcher', name: 'Tumusiime Thomas',      dashboard: 'dispatch.html' },
        'accountant@meditrack.com':     { password: 'password123', role: 'accountant',           name: 'Nabisere Patricia',     dashboard: 'billing.html' },
        'insurance@meditrack.com':      { password: 'password123', role: 'insurance_officer',    name: 'Atim Linda',            dashboard: 'insurance-claims.html' },
        'hr@meditrack.com':             { password: 'password123', role: 'hr_manager',           name: 'Wanjiru Emily',         dashboard: 'staff-management.html' },
        'inventory@meditrack.com':      { password: 'password123', role: 'inventory_manager',    name: 'Byaruhanga Robert',     dashboard: 'inventory.html' },
    };

    // Default for backwards compatibility
    const DEFAULT_EMAIL = 'admin@meditrack.com';
    const DEFAULT_PASSWORD = 'password123';

    // Pre-fill email field with default
    document.getElementById('email').value = DEFAULT_EMAIL;
    document.getElementById('password').value = DEFAULT_PASSWORD;

    // ============================================================
    // TOGGLE PASSWORD VISIBILITY
    // ============================================================
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword?.addEventListener('click', () => {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        const icon = togglePassword.querySelector('svg');
        if (type === 'text') {
            icon.innerHTML = '<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle><path d="M22 4 2 20"></path><line x1="4" x2="20" y1="4" y2="20"></line>';
        } else {
            icon.innerHTML = '<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle>';
        }
    });

    // ============================================================
    // REMEMBER ME CHECKBOX
    // ============================================================
    const rememberCheckbox = document.getElementById('rememberCheckbox');
    let isChecked = false;

    rememberCheckbox?.addEventListener('click', () => {
        isChecked = !isChecked;
        if (isChecked) {
            rememberCheckbox.classList.add('bg-primary', 'border-indigo-600');
            rememberCheckbox.setAttribute('aria-checked', 'true');
            rememberCheckbox.innerHTML = '<svg class="h-3 w-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="M20 6 9 17l-5-5"></path></svg>';
        } else {
            rememberCheckbox.classList.remove('bg-primary', 'border-indigo-600');
            rememberCheckbox.setAttribute('aria-checked', 'false');
            rememberCheckbox.innerHTML = '';
        }
    });

    // ============================================================
    // FAILED ATTEMPTS TRACKER (5 attempts → lockout)
    // ============================================================
    function getFailedAttempts() {
        return parseInt(localStorage.getItem('meditrack_login_attempts') || '0', 10);
    }
    function incrementFailedAttempts() {
        const n = getFailedAttempts() + 1;
        localStorage.setItem('meditrack_login_attempts', String(n));
        return n;
    }
    function resetFailedAttempts() {
        localStorage.removeItem('meditrack_login_attempts');
    }
    function getLockoutTime() {
        return parseInt(localStorage.getItem('meditrack_lockout_until') || '0', 10);
    }
    function setLockout(seconds) {
        localStorage.setItem('meditrack_lockout_until', String(Date.now() + seconds * 1000));
    }

    // ============================================================
    // LOGIN SUBMIT
    // ============================================================
    const loginForm = document.getElementById('loginForm');
    const errorMessageDiv = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');

    loginForm?.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Check lockout
        const lockoutUntil = getLockoutTime();
        if (Date.now() < lockoutUntil) {
            const secondsLeft = Math.ceil((lockoutUntil - Date.now()) / 1000);
            errorText.textContent = `Account locked. Try again in ${secondsLeft} seconds.`;
            errorMessageDiv.classList.remove('hidden');
            return;
        }

        const email = document.getElementById('email').value.trim().toLowerCase();
        const password = document.getElementById('password').value;

        // Basic validation
        if (!email || !password) {
            errorText.textContent = 'Please enter both email and password.';
            errorMessageDiv.classList.remove('hidden');
            return;
        }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            errorText.textContent = 'Please enter a valid email address.';
            errorMessageDiv.classList.remove('hidden');
            return;
        }

        // Try real API first (if backend available), fall back to demo
        let user = null;
        try {
            if (window.Meditrack && window.MEDITRACK_API_BASE && !window.MEDITRACK_API_BASE.includes('/api')) {
                // Skip API attempt if base URL looks unconfigured
            } else if (window.Meditrack) {
                const result = await window.Meditrack.api('POST', '/auth/login', { email, password });
                if (result.success && result.data && result.data.token) {
                    user = {
                        role: result.data.user.role,
                        name: result.data.user.name,
                        email: result.data.user.email,
                        token: result.data.token,
                        ...result.data.user,
                    };
                }
            }
        } catch (err) {
            // fall through to demo
        }

        // Demo fallback
        if (!user) {
            const demoUser = DEMO_USERS[email];
            if (demoUser && password === demoUser.password) {
                user = {
                    role: demoUser.role,
                    name: demoUser.name,
                    email: email,
                    token: 'demo_token_' + Math.random().toString(36).substr(2),
                };
            }
        }

        if (user) {
            // Successful login
            resetFailedAttempts();
            errorMessageDiv.classList.add('hidden');

            // Persist auth state in localStorage
            localStorage.setItem('meditrack_auth_token', user.token);
            localStorage.setItem('meditrack_user', JSON.stringify({
                role: user.role,
                name: user.name,
                email: user.email,
                id: user.id || null,
                staff_id: user.staff_id || null,
                patient_id: user.patient_id || null,
                company_id: user.company_id || null,
            }));
            localStorage.setItem('meditrack_user_role', user.role);
            localStorage.setItem('meditrack_login_time', new Date().toISOString());

            // Determine dashboard based on role
            const dashboard = (DEMO_USERS[email] && DEMO_USERS[email].dashboard) || getDashboardForRole(user.role);

            // Show success toast + redirect
            if (window.Meditrack) {
                window.Meditrack.Toast.success(`Welcome back, ${user.name}!`, { title: 'Login Successful' });
            }
            setTimeout(() => {
                window.location.href = dashboard;
            }, 600);
        } else {
            // Failed login — track attempts
            const attempts = incrementFailedAttempts();
            if (attempts >= 5) {
                setLockout(60); // 1-minute lockout
                errorText.textContent = 'Too many failed attempts. Account locked for 60 seconds.';
                localStorage.setItem('meditrack_login_attempts', '0');
            } else {
                errorText.textContent = `Invalid email or password. ${5 - attempts} attempt(s) remaining.`;
            }
            errorMessageDiv.classList.remove('hidden');

            // Shake animation
            errorMessageDiv.style.animation = 'none';
            setTimeout(() => { errorMessageDiv.style.animation = ''; }, 10);
        }
    });

    function getDashboardForRole(role) {
        const map = {
            'super_admin': 'super-admin.html',
            'admin': 'index.html',
            'doctor': 'doctor-dashboard.html',
            'nurse': 'nurse-station.html',
            'receptionist': 'appointments.html',
            'lab_technician': 'lab-dashboard.html',
            'pharmacist': 'medicine.html',
            'radiology_technician': 'radiology-list.html',
            'physiotherapist': 'physiotherapy-dashboard.html',
            'surgeon': 'ot-dashboard.html',
            'blood_bank_staff': 'blood-stock.html',
            'ambulance_driver': 'ambulance-calls.html',
            'ambulance_dispatcher': 'dispatch.html',
            'patient': 'patient-dashboard.html',
            'accountant': 'billing.html',
            'insurance_officer': 'insurance-claims.html',
            'hr_manager': 'staff-management.html',
            'inventory_manager': 'inventory.html',
        };
        return map[role] || 'index.html';
    }

    // Hide error when user starts typing
    document.getElementById('email')?.addEventListener('input', () => {
        errorMessageDiv.classList.add('hidden');
    });
    document.getElementById('password')?.addEventListener('input', () => {
        errorMessageDiv.classList.add('hidden');
    });

    // If already logged in, redirect to dashboard
    (function checkExistingSession() {
        const token = localStorage.getItem('meditrack_auth_token');
        const user = localStorage.getItem('meditrack_user');
        if (token && user) {
            try {
                const u = JSON.parse(user);
                if (u.role) {
                    window.location.href = getDashboardForRole(u.role);
                }
            } catch (e) {}
        }
    })();
</script>

<!-- Quick login chips for demo — show all roles -->
<style>
    .quick-login-chips {
        display: flex; flex-wrap: wrap; gap: 6px; margin-top: 16px; justify-content: center;
    }
    .quick-login-chip {
        padding: 4px 10px; border: 1px solid #e5e7eb; border-radius: 14px;
        font-size: 11px; color: #6b7280; cursor: pointer; background: white;
        transition: all 0.15s;
    }
    .quick-login-chip:hover {
        background: #3b82f6; color: white; border-color: #3b82f6;
    }
</style>
<div id="quickLoginChips" class="quick-login-chips" style="display:none;">
    <!-- chips inserted by JS below -->
</div>
<script>
    // Show quick login chips with all role demo accounts (demo only)
    (function() {
        const chipsContainer = document.getElementById('quickLoginChips');
        if (!chipsContainer) return;
        const roles = [
            { email: 'superadmin@meditrack.com', label: 'Super Admin' },
            { email: 'admin@meditrack.com', label: 'Admin' },
            { email: 'doctor@meditrack.com', label: 'Doctor' },
            { email: 'nurse@meditrack.com', label: 'Nurse' },
            { email: 'business@meditrack.com', label: 'Business' },
            { email: 'patient@meditrack.com', label: 'Patient' },
            { email: 'receptionist@meditrack.com', label: 'Receptionist' },
            { email: 'lab@meditrack.com', label: 'Lab Tech' },
            { email: 'pharmacist@meditrack.com', label: 'Pharmacist' },
            { email: 'accountant@meditrack.com', label: 'Accountant' },
        ];
        roles.forEach(r => {
            const chip = document.createElement('div');
            chip.className = 'quick-login-chip';
            chip.textContent = r.label;
            chip.title = `Login as ${r.label} (${r.email} / password123)`;
            chip.onclick = () => {
                document.getElementById('email').value = r.email;
                document.getElementById('password').value = 'password123';
                loginForm.dispatchEvent(new Event('submit'));
            };
            chipsContainer.appendChild(chip);
        });
        // Show chips on second visit
        if (localStorage.getItem('meditrack_visited_once')) {
            chipsContainer.style.display = 'flex';
        }
        localStorage.setItem('meditrack_visited_once', '1');
    })();
</script>

    
    


    <script src="js/meditrack-security.js"></script>
    <script src="js/meditrack.js"></script>
    <script src="js/meditrack-realtime.js"></script>
    <script src="js/meditrack-language.js"></script>
    <script src="js/meditrack-flags.js"></script>
    <script src="js/meditrack-avatars.js"></script>
    <script src="js/meditrack-store.js"></script>
    <script src="js/meditrack-action-menu.js"></script>
    <script src="js/meditrack-pdf.js"></script>
    <script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('service-worker.js').then(function(reg) {
            console.log('[PWA] Service Worker registered:', reg.scope);
        }).catch(function(err) {
            console.warn('[PWA] Service Worker registration failed:', err);
        });
    });
}
</script>
</body>
</html>
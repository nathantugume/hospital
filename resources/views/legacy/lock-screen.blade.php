<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Lock Screen</title>
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        body { background-color: #f3f4f6; }
    </style>
</head>
<body class="bg-gray-50 antialiased">

<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md space-y-8">
        <!-- Logo / Header -->
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <img src="logo.png" alt="Medi-track Logo" class="w-12 h-12 object-contain">
            </div>
            <h2 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2 text-gray-900">Medi-track</h2>
            <p class="mt-2 text-gray-500">Healthcare administration simplified</p>
        </div>

        <!-- Lock Screen Card -->
        <div class="rounded-lg border bg-background shadow-sm border-gray-200">
            <div class="flex flex-col items-center p-6 text-center space-y-4">
                <!-- User Avatar -->
                <div class="mb-2">
                    <div class="mx-auto flex h-15 w-15 items-center justify-center rounded-full bg-indigo-100 ring-4 ring-indigo-50">
                        <span class="relative flex shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span>
                    </div>
                </div>

                <!-- User Info -->
                <div>
                    <h3 id="userName" class="text-xl font-semibold tracking-tight text-gray-900">Ssentongo John</h3>
                    <p id="userRole" class="text-sm text-gray-500">Administrator</p>
                </div>

                <p class="text-gray-400 text-sm">Enter your password to unlock</p>

                <!-- Unlock Form -->
                <form id="lockForm" class="w-full space-y-4">
                    <!-- Error Message (hidden) -->
                    <div id="errorMessage" class="hidden rounded-md bg-red-50 border border-red-200 p-3 text-sm text-red-700">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" x2="12" y1="8" y2="12"></line>
                                <line x1="12" x2="12.01" y1="16" y2="16"></line>
                            </svg>
                            <span id="errorText">Incorrect password</span>
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2 pt-0">
                        <label class="text-sm font-medium text-gray-700 sr-only" for="password">Password</label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-3 h-4 w-4 text-gray-400">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 pl-10 text-gray-900" 
                                   id="password" required type="password" placeholder="Password" autofocus>
                            <button type="button" class="toggle-password absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Unlock Button -->
                    <button type="submit" id="unlockBtn" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 w-full shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4">
                            <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        Unlock
                    </button>
                </form>

                <!-- Sign in as different user -->
                <a href="login.html" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                    Sign in as different user
                </a>
            </div>
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
    // Demo unlock password
    const UNLOCK_PASSWORD = "password123";

    // Extract user info from URL parameters (or use defaults)
    const urlParams = new URLSearchParams(window.location.search);
    const nameParam = urlParams.get('name') || 'Ssentongo John';
    const roleParam = urlParams.get('role') || 'Administrator';

    // Display user name and role
    document.getElementById('userName').textContent = nameParam;
    document.getElementById('userRole').textContent = roleParam;

    // Generate initials from name
    const initials = nameParam
        .split(' ')
        .map(word => word.charAt(0))
        .join('')
        .toUpperCase()
        .slice(0, 2);
    document.getElementById('userInitials').textContent = initials;

    // Toggle password visibility
    const togglePassword = document.querySelector('.toggle-password');
    const passwordInput = document.getElementById('password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            const icon = togglePassword.querySelector('svg');
            if (type === 'text') {
                icon.innerHTML = '<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle><path d="M22 4 2 20"></path><line x1="4" x2="20" y1="4" y2="20"></line>';
            } else {
                icon.innerHTML = '<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        });
    }

    // Unlock form submission
    const lockForm = document.getElementById('lockForm');
    const errorDiv = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');
    const unlockBtn = document.getElementById('unlockBtn');

    lockForm?.addEventListener('submit', (e) => {
        e.preventDefault();
        const enteredPassword = passwordInput.value;

        if (!enteredPassword) {
            errorText.textContent = 'Please enter your password.';
            errorDiv.classList.remove('hidden');
            return;
        }

        if (enteredPassword === UNLOCK_PASSWORD) {
            // Success: hide error, show quick feedback and redirect
            errorDiv.classList.add('hidden');
            unlockBtn.innerHTML = `
                <svg class="h-4 w-4 mr-2 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10" stroke-dasharray="32" stroke-dashoffset="32"></circle>
                </svg>
                Unlocking...
            `;
            unlockBtn.disabled = true;

            setTimeout(() => {
                window.location.href = 'index.html'; // Redirect to dashboard
            }, 800);
        } else {
            errorText.textContent = 'Incorrect password. Please try again.';
            errorDiv.classList.remove('hidden');
            passwordInput.value = '';
            passwordInput.focus();

            // Optional shake animation on error
            errorDiv.style.animation = 'none';
            setTimeout(() => { errorDiv.style.animation = ''; }, 10);
        }
    });

    // Hide error when user starts typing
    passwordInput?.addEventListener('input', () => {
        errorDiv.classList.add('hidden');
    });
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
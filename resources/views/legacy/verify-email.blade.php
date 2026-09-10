<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Verify Email</title>
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="style.css">
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

        <!-- Verify Email Card -->
        <div class="rounded-lg border bg-background shadow-sm border-gray-200">
            <div class="flex flex-col space-y-1.5 p-6 text-center">
                <div class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold tracking-tight text-gray-900">Verify your email</h2>
                <div class="text-gray-500">
                    We’ve sent a verification link to <span id="userEmailDisplay" class="font-medium text-gray-700">your email</span>. Please follow the link inside to continue.
                </div>
                <!-- Status Messages -->
                <div class="px-6 pb-0 space-y-3">
                    <!-- Error Message (hidden) -->
                    <div id="errorMessage" class="hidden rounded-md bg-red-50 border border-red-200 p-3 text-sm text-red-700">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" x2="12" y1="8" y2="12"></line>
                                <line x1="12" x2="12.01" y1="16" y2="16"></line>
                            </svg>
                            <span id="errorText"></span>
                        </div>
                    </div>
    
                    <!-- Success Message (hidden) -->
                    <div id="successMessage" class="hidden rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-700">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 6L9 17l-5-5"></path>
                            </svg>
                            <span id="successText">Verification link resent! Check your inbox.</span>
                        </div>
                    </div>
                </div>
    
                <!-- Action Buttons -->
                <div class="pt-2 flex flex-col space-y-4">
                    <button type="button" id="resendBtn" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 w-full shadow-sm">
                        <svg class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 12a9 9 0 11-1.5-4.87"></path>
                            <path d="M21 3v5h-5"></path>
                            <path d="M21 3l-5 5"></path>
                        </svg>
                        Resend Link
                    </button>
                    <a href="login.html" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 w-full text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4">
                            <path d="m12 19-7-7 7-7"></path>
                            <path d="M19 12H5"></path>
                        </svg>
                        Return to Login
                    </a>
                </div>
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
    // Extract email from URL parameter ?email=user@hmail.com
    const urlParams = new URLSearchParams(window.location.search);
    const emailParam = urlParams.get('email');
    const userEmailSpan = document.getElementById('userEmailDisplay');
    if (emailParam) {
        userEmailSpan.textContent = emailParam;
    } else {
        // fallback placeholder
        userEmailSpan.textContent = 'your email address';
    }

    const resendBtn = document.getElementById('resendBtn');
    const successDiv = document.getElementById('successMessage');
    const errorDiv = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');

    resendBtn?.addEventListener('click', () => {
        // Hide previous messages
        errorDiv.classList.add('hidden');
        successDiv.classList.add('hidden');

        // Simulate resend (real implementation would call an API)
        // Show success for a few seconds
        successDiv.classList.remove('hidden');

        // Optionally disable button temporarily to prevent spamming
        resendBtn.disabled = true;
        setTimeout(() => {
            resendBtn.disabled = false;
        }, 3000);

        // Auto-hide success after 5 seconds
        setTimeout(() => {
            if (!successDiv.classList.contains('hidden')) {
                successDiv.classList.add('hidden');
            }
        }, 5000);
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

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Two-Step Verification</title>
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="style.css">
    <style>
        * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        body { background-color: #f3f4f6; }
        /* Optional: fine‑tune digit box alignment */
        .otp-digit-input {
            text-align: center;
            font-size: 1.125rem;
            font-weight: 600;
        }
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

        <!-- Two-Step Verification Card -->
        <div class="rounded-lg border bg-background shadow-sm border-gray-200">
            <div class="flex flex-col space-y-1.5 p-6 text-center">
                <div class="mx-auto mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold tracking-tight text-gray-900">Login with your Email Address</h2>
                <div class="text-gray-500">
                    We sent a verification code to <span id="userEmailDisplay" class="font-medium text-gray-700">your email</span>.
                    Enter the code from the email in the field below.
                </div>
                <form id="otpForm">
                    <div class="p-6 pt-0 space-y-4">
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
                                <span id="successText">Verification successful! Redirecting...</span>
                            </div>
                        </div>
    
                        <!-- OTP Digit Inputs (6 separate boxes) -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700">Verification Code</label>
                            <div class="flex justify-center gap-2" id="otpContainer">
                                <!-- 6 digit inputs generated below -->
                            </div>
                        </div>
    
                        <!-- Timer & Resend -->
                        <div class="flex items-center justify-between text-sm">
                            <div id="timerDisplay" class="text-gray-500">
                                OTP expires in <span id="timerCountdown" class="font-semibold text-indigo-600">01:59</span>
                            </div>
                            <button type="button" id="resendBtn" class="text-indigo-600 hover:text-indigo-700 disabled:text-gray-400 disabled:cursor-not-allowed font-medium">
                                Resend Code
                            </button>
                        </div>
                    </div>
    
                    <!-- Buttons -->
                    <div class="items-center pb-3 flex flex-col space-y-4">
                        <button type="submit" id="verifyBtn" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 w-full shadow-sm">
                            <svg class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                <polyline points="10 17 15 12 10 7"></polyline>
                                <line x1="15" x2="3" y1="12" y2="12"></line>
                            </svg>
                            Verify
                        </button>
                        <a href="login.html" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 h-10 px-4 py-2 w-full text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4">
                                <path d="m12 19-7-7 7-7"></path>
                                <path d="M19 12H5"></path>
                            </svg>
                            Return to Login
                        </a>
                    </div>
                </form>
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
    // ====== Persistent Email ======
    const urlParams = new URLSearchParams(window.location.search);
    const emailParam = urlParams.get('email') || 'your email';
    document.getElementById('userEmailDisplay').textContent = emailParam;

    // ====== OTP Digit Inputs Setup ======
    const OTP_LENGTH = 6;
    const container = document.getElementById('otpContainer');
    const inputs = [];

    // Create 6 individual inputs
    for (let i = 0; i < OTP_LENGTH; i++) {
        const input = document.createElement('input');
        input.type = 'text';
        input.inputMode = 'numeric';
        input.maxLength = 1;
        input.autocomplete = 'one-time-code'; // may not work perfectly across browsers but helpful
        input.classList.add(
            'flex', 'h-12', 'w-12', 'rounded-md', 'border', 'border-gray-300',
            'bg-background', 'px-0', 'py-2', 'text-sm', 'ring-offset-background',
            'placeholder:text-gray-400', 'focus-visible:outline-none',
            'focus-visible:ring-2', 'focus-visible:ring-indigo-500',
            'focus-visible:ring-offset-2', 'disabled:cursor-not-allowed',
            'disabled:opacity-50', 'otp-digit-input'
        );
        input.setAttribute('aria-label', `Digit ${i + 1}`);
        container.appendChild(input);
        inputs.push(input);
    }

    // Auto-focus first input on load
    if (inputs.length > 0) inputs[0].focus();

    // Handle input events: move to next, validate numeric, handle backspace
    container.addEventListener('input', (e) => {
        const current = e.target;
        if (!inputs.includes(current)) return;

        const value = current.value;
        // Allow only a single digit (0-9)
        if (!/^\d$/.test(value)) {
            current.value = '';
            return;
        }

        // Move to next input if it exists
        const idx = inputs.indexOf(current);
        if (idx < OTP_LENGTH - 1) {
            inputs[idx + 1].focus();
        }
        // Hide error on any input
        document.getElementById('errorMessage').classList.add('hidden');
    });

    container.addEventListener('keydown', (e) => {
        const current = e.target;
        if (!inputs.includes(current)) return;
        const idx = inputs.indexOf(current);

        // Backspace on empty field: move to previous
        if (e.key === 'Backspace' && current.value === '' && idx > 0) {
            inputs[idx - 1].focus();
            e.preventDefault(); // prevent any default Backspace action
        }
        // Allow left/right arrow navigation
        if (e.key === 'ArrowLeft' && idx > 0) {
            inputs[idx - 1].focus();
            e.preventDefault();
        }
        if (e.key === 'ArrowRight' && idx < OTP_LENGTH - 1) {
            inputs[idx + 1].focus();
            e.preventDefault();
        }
    });

    // Paste handler: distribute pasted digits across boxes
    container.addEventListener('paste', (e) => {
        e.preventDefault();
        const pasteData = (e.clipboardData || window.clipboardData).getData('text');
        const digits = pasteData.replace(/\D/g, '').slice(0, OTP_LENGTH);
        if (digits.length === 0) return;

        // Fill digits from first input
        for (let i = 0; i < OTP_LENGTH; i++) {
            inputs[i].value = digits[i] || '';
        }
        // Focus last filled or first empty
        const lastFilledIndex = Math.min(digits.length - 1, OTP_LENGTH - 1);
        inputs[lastFilledIndex].focus();
        // Hide error on paste
        document.getElementById('errorMessage').classList.add('hidden');
    });

    // Disable all OTP inputs
    function setOTPDisabled(disabled) {
        inputs.forEach(input => {
            input.disabled = disabled;
        });
    }

    // Get combined OTP string
    function getOTPValue() {
        return inputs.map(input => input.value).join('');
    }

    // Clear all OTP inputs
    function clearOTP() {
        inputs.forEach(input => { input.value = ''; });
    }

    // ====== Timer Logic ======
    const DEMO_OTP = "123456";
    const OTP_EXPIRY_SECONDS = 120; // 2 minutes

    const timerSpan = document.getElementById('timerCountdown');
    const resendBtn = document.getElementById('resendBtn');
    const verifyBtn = document.getElementById('verifyBtn');
    const form = document.getElementById('otpForm');
    const errorDiv = document.getElementById('errorMessage');
    const errorText = document.getElementById('errorText');
    const successDiv = document.getElementById('successMessage');

    let timeLeft = OTP_EXPIRY_SECONDS;
    let timerInterval = null;
    let expired = false;

    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        return `${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
    }

    function updateTimerDisplay() {
        timerSpan.textContent = formatTime(timeLeft);
        if (timeLeft <= 30) {
            timerSpan.classList.add('text-red-600');
            timerSpan.classList.remove('text-indigo-600');
        } else {
            timerSpan.classList.add('text-indigo-600');
            timerSpan.classList.remove('text-red-600');
        }
    }

    function stopTimer() {
        if (timerInterval) {
            clearInterval(timerInterval);
            timerInterval = null;
        }
    }

    function startTimer() {
        stopTimer();
        timeLeft = OTP_EXPIRY_SECONDS;
        expired = false;
        updateTimerDisplay();
        verifyBtn.disabled = false;
        setOTPDisabled(false);
        resendBtn.disabled = false;

        timerInterval = setInterval(() => {
            timeLeft--;
            updateTimerDisplay();
            if (timeLeft <= 0) {
                timeLeft = 0;
                expired = true;
                updateTimerDisplay();
                stopTimer();
                errorText.textContent = 'Verification code has expired. Please request a new one.';
                errorDiv.classList.remove('hidden');
                verifyBtn.disabled = true;
                setOTPDisabled(true);
                resendBtn.disabled = false; // still allow resend
            }
        }, 1000);
    }

    // Initial start
    startTimer();

    // Resend button logic
    resendBtn.addEventListener('click', () => {
        errorDiv.classList.add('hidden');
        successDiv.classList.add('hidden');
        // Simulate sending a new code
        successDiv.querySelector('span').textContent = 'A new verification code has been sent to your email.';
        successDiv.classList.remove('hidden');
        clearOTP();
        startTimer();
        if (inputs.length > 0) inputs[0].focus();

        setTimeout(() => {
            if (!successDiv.classList.contains('hidden')) {
                successDiv.classList.add('hidden');
            }
        }, 4000);
    });

    // Form submit – verify OTP
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        errorDiv.classList.add('hidden');
        successDiv.classList.add('hidden');

        if (expired) {
            errorText.textContent = 'Verification code has expired. Please request a new one.';
            errorDiv.classList.remove('hidden');
            return;
        }

        const enteredOTP = getOTPValue();

        if (enteredOTP.length < OTP_LENGTH) {
            errorText.textContent = 'Please enter the complete 6‑digit code.';
            errorDiv.classList.remove('hidden');
            return;
        }

        if (enteredOTP === DEMO_OTP) {
            successDiv.querySelector('span').textContent = 'Verification successful! Redirecting...';
            successDiv.classList.remove('hidden');
            stopTimer();
            setOTPDisabled(true);
            verifyBtn.disabled = true;
            setTimeout(() => {
                window.location.href = 'index.html'; // change to your dashboard
            }, 1500);
        } else {
            errorText.textContent = 'Invalid verification code. Please try again.';
            errorDiv.classList.remove('hidden');
        }
    });

    // Hide error when user interacts with OTP boxes
    inputs.forEach(input => {
        input.addEventListener('input', () => {
            errorDiv.classList.add('hidden');
        });
        input.addEventListener('focus', () => {
            errorDiv.classList.add('hidden');
        });
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
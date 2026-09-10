<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Sign Up</title>
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

        <!-- Sign Up Card -->
        <div class="rounded-lg border bg-background shadow-sm border-gray-200">
            <div class="flex flex-col space-y-1.5 p-6">
                <h2 class="text-xl font-semibold tracking-tight text-gray-900">Create an account</h2>
                <div class="text-gray-500">Enter your information to get started</div>
                <form id="signupForm">
                    <div class="pb-3 space-y-4">
                        <!-- Error Message (hidden by default) -->
                        <div id="errorMessage" class="hidden rounded-md bg-red-50 border border-red-200 p-3 text-sm text-red-700">
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" >
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" x2="12" y1="8" y2="12"></line>
                                    <line x1="12" x2="12.01" y1="16" y2="16"></line>
                                </svg>
                                <span id="errorText"></span>
                            </div>
                        </div>
    
                        <!-- Success Message (hidden by default) -->
                        <div id="successMessage" class="hidden rounded-md bg-green-50 border border-green-200 p-3 text-sm text-green-700">
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" >
                                    <path d="M20 6L9 17l-5-5"></path>
                                </svg>
                                <span id="successText">Account created successfully! Redirecting to login...</span>
                            </div>
                        </div>
    
                        <!-- Full Name Field -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700" for="name">Full Name</label>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-3 h-4 w-4 text-gray-400">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <input class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 pl-10 text-gray-900" 
                                       id="name" placeholder="Ssentongo John" required type="text">
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
                                       id="email" placeholder="name@hospital.ug" required type="email">
                            </div>
                        </div>
    
                        <!-- Password Field -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700" for="password">Password</label>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-3 h-4 w-4 text-gray-400">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <input class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 pl-10 text-gray-900" 
                                       id="password" required type="password">
                                <button type="button" class="toggle-password absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                        <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>
    
                        <!-- Confirm Password Field -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-gray-700" for="confirmPassword">Confirm Password</label>
                            <div class="relative">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-3 h-4 w-4 text-gray-400">
                                    <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <input class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 pl-10 text-gray-900" 
                                       id="confirmPassword" required type="password">
                                <button type="button" class="toggle-confirm-password absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                        <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>
    
                        <!-- Terms Checkbox (Radix UI style) -->
                        <div class="flex items-start space-x-2">
                            <button type="button" role="checkbox" aria-checked="false" id="termsCheckbox" 
                                    class="terms-checkbox h-4 w-4 shrink-0 rounded-sm border border-gray-300 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 flex items-center justify-center mt-1">
                            </button>
                            <label class="text-sm font-medium text-gray-700 cursor-pointer" for="termsCheckbox">
                                I agree to the <a class="text-indigo-600 hover:text-indigo-700" href="#">Terms of Service</a> and <a class="text-indigo-600 hover:text-indigo-700" href="#">Privacy Policy</a>
                            </label>
                        </div>
                    </div>
    
                    <!-- Buttons -->
                    <div class="items-center flex flex-col space-y-4">
                        <button type="submit" id="signupBtn" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 w-full shadow-sm">
                            <svg class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" >
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            Create account
                        </button>
                        <p class="text-center text-sm text-gray-500">
                            Already have an account? 
                            <a class="text-indigo-600 hover:text-indigo-700 font-medium" href="login.html">Sign in</a>
                        </p>
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


    // Toggle password visibility for Password field
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
    
    // Toggle password visibility for Confirm Password field
    const toggleConfirmPassword = document.querySelector('.toggle-confirm-password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    
    if (toggleConfirmPassword && confirmPasswordInput) {
        toggleConfirmPassword.addEventListener('click', () => {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            
            const icon = toggleConfirmPassword.querySelector('svg');
            if (type === 'text') {
                icon.innerHTML = '<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle><path d="M22 4 2 20"></path><line x1="4" x2="20" y1="4" y2="20"></line>';
            } else {
                icon.innerHTML = '<path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle>';
            }
        });
    }
    
    // Terms checkbox (Radix UI style)
    const termsCheckbox = document.getElementById('termsCheckbox');
    let termsChecked = false;
    
    if (termsCheckbox) {
        termsCheckbox.addEventListener('click', () => {
            termsChecked = !termsChecked;
            if (termsChecked) {
                termsCheckbox.classList.add('bg-primary', 'border-indigo-600');
                termsCheckbox.setAttribute('aria-checked', 'true');
                termsCheckbox.innerHTML = '<svg class="h-3 w-3 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"></path></svg>';
            } else {
                termsCheckbox.classList.remove('bg-primary', 'border-indigo-600');
                termsCheckbox.setAttribute('aria-checked', 'false');
                termsCheckbox.innerHTML = '';
            }
        });
    }
    
// Form validation and submission
const signupForm = document.getElementById('signupForm');
const errorMessageDiv = document.getElementById('errorMessage');
const errorText = document.getElementById('errorText');
const successMessageDiv = document.getElementById('successMessage');

signupForm?.addEventListener('submit', (e) => {
    e.preventDefault();
    
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    
    // Hide previous messages
    errorMessageDiv.classList.add('hidden');
    successMessageDiv.classList.add('hidden');
    
    // Basic validation
    if (!name || !email || !password || !confirmPassword) {
        errorText.textContent = 'Please fill in all fields.';
        errorMessageDiv.classList.remove('hidden');
        return;
    }
    
    if (password !== confirmPassword) {
        errorText.textContent = 'Passwords do not match.';
        errorMessageDiv.classList.remove('hidden');
        return;
    }
    
    if (!termsChecked) {
        errorText.textContent = 'Please agree to the Terms of Service and Privacy Policy.';
        errorMessageDiv.classList.remove('hidden');
        return;
    }
    
    // ---- ENFORCE PASSWORD POLICY FROM SETTINGS ----
    if (window.validatePassword) {
        var result = window.validatePassword(password);
        if (!result.valid) {
            errorText.textContent = result.errors.join('. ') + '.';
            errorMessageDiv.classList.remove('hidden');
            return;
        }
    } else {
        // Fallback if settings-manager not loaded
        if (password.length < 6) {
            errorText.textContent = 'Password must be at least 6 characters long.';
            errorMessageDiv.classList.remove('hidden');
            return;
        }
    }
    
    // Show success message and redirect
    successText.textContent = 'Account created successfully! Redirecting to login...';
    successMessageDiv.classList.remove('hidden');
    
setTimeout(() => {
    window.location.href = 'verify-email.html?email=' + encodeURIComponent(email);
}, 2000);


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
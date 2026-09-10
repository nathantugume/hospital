<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <title>Medi-track | Sign in | MediTrack HMS</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="{{ asset('style.css') }}">


</head>
<body class="bg-gray-50 antialiased">

<div class="flex min-h-screen items-center justify-center px-4 py-12">
    <div class="w-full max-w-md space-y-8">
        <!-- Logo / Header -->
        <div class="text-center">
            <div class="flex justify-center mb-4">
                <img src="{{ asset('logo.png') }}" alt="Medi-track Logo" class="w-12 h-12 object-contain">
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

            <form id="loginForm" method="POST" action="{{ route('login.store') }}">
@csrf
                <div class="p-6 pt-0 space-y-4">
@if ($errors->any())<div role="alert" class="rounded-md bg-red-50 border border-red-200 p-3 text-sm text-red-700">@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>@endif
@if (session('status'))<div role="status" class="rounded-md border p-3 text-sm">{{ session('status') }}</div>@endif
                    <!-- Email Field -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700" for="email">Email</label>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-3 h-4 w-4 text-gray-400">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                            <input class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 pl-10 text-gray-900"
                                   id="email" name="email" autocomplete="username" placeholder="name@meditrack.com" required type="email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <!-- Password Field -->
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-700" for="password">Password</label>
                            <a class="text-xs text-indigo-600 hover:text-indigo-700" href="{{ route('password.request') }}">Forgot password?</a>
                        </div>
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="absolute left-3 top-3 h-4 w-4 text-gray-400">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <input class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-400 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 pl-10 text-gray-900"
                                   id="password" name="password" autocomplete="current-password" placeholder="Password" required type="password" >
                            <button type="button" id="togglePassword" aria-label="Show password" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                    <path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me Checkbox (Radix UI style) -->
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="remember" value="1" id="rememberCheckbox" class="h-4 w-4 rounded-sm border border-gray-300">
                        <label class="text-sm font-medium text-gray-700 cursor-pointer" for="rememberCheckbox">Remember me</label>
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
                        <a class="text-indigo-600 hover:text-indigo-700 font-medium" href="{{ route('register') }}">Create an account</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>






<script src="{{ asset('js/blade-ui.js') }}" defer></script>
</body>
</html>

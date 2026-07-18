<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-950">
            <p class="font-semibold">Demo access</p>
            <p class="mt-1 text-emerald-800">Use these accounts to explore the different roles. Please do not enter real patient information.</p>

            <div class="mt-4 space-y-4">
                <div>
                    <p class="font-semibold text-emerald-950">Patient / tester</p>
                    <dl class="mt-1 space-y-1 text-emerald-950">
                        <div class="flex gap-2">
                            <dt class="font-medium">Email:</dt>
                            <dd><code class="break-all">demo.tester@hospital.alwaysdata.net</code></dd>
                        </div>
                        <div class="flex gap-2">
                            <dt class="font-medium">Password:</dt>
                            <dd><code class="break-all">HospitalDemo2026!</code></dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <p class="font-semibold text-emerald-950">Patient</p>
                    <dl class="mt-1 space-y-1 text-emerald-950">
                        <div class="flex gap-2">
                            <dt class="font-medium">Email:</dt>
                            <dd><code class="break-all">demo.patient@hospital.alwaysdata.net</code></dd>
                        </div>
                        <div class="flex gap-2">
                            <dt class="font-medium">Password:</dt>
                            <dd><code class="break-all">HospitalPatient2026!</code></dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <p class="font-semibold text-emerald-950">Administrator</p>
                    <dl class="mt-1 space-y-1 text-emerald-950">
                        <div class="flex gap-2">
                            <dt class="font-medium">Email:</dt>
                            <dd><code class="break-all">demo.admin@hospital.alwaysdata.net</code></dd>
                        </div>
                        <div class="flex gap-2">
                            <dt class="font-medium">Password:</dt>
                            <dd><code class="break-all">HospitalAdmin2026!</code></dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

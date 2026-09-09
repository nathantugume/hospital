<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Account') | MediTrack HMS</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="{{ asset('blade.css') }}">
    <script src="{{ asset('js/blade-ui.js') }}" defer></script>
</head>
<body class="bg-gray-50 antialiased">
<main class="flex min-h-screen items-center justify-center px-4 py-12"><div class="w-full max-w-md space-y-8"><div class="text-center"><div class="flex justify-center mb-4"><img src="{{ asset('logo.png') }}" alt="" class="w-12 h-12 object-contain"></div><h2 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">Medi-track</h2><p class="mt-2 text-gray-500">Healthcare administration simplified</p></div>
    <section class="rounded-lg border bg-background shadow-sm border-gray-200 p-6" aria-labelledby="auth-heading">
        <h1 id="auth-heading" class="text-xl font-semibold tracking-tight mb-4">@yield('heading')</h1>
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-error">
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </section>
</div></main>
</body>
</html>

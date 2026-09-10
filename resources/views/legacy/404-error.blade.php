<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Page Not Found</title>
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

        <!-- 404 Error Card -->
        <div>
            <div class="flex flex-col items-center p-6 text-center space-y-4">
                <!-- Error Image (inline SVG, matches example layout) -->
                <div class="mb-4">
                    <div>
                        <img class="w-full" src="error-404.png" alt="">
                    </div>
                </div>

                <h3 class="text-2xl font-bold tracking-tight text-gray-900">Oops, something went wrong</h3>
                <p class="text-center text-gray-500 text-sm max-w-sm mx-auto">
                    Error 404 Page not found. Sorry the page you looking for doesn’t exist or has been moved
                </p>
                <a href="login.html" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 w-full shadow-sm mt-2">
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
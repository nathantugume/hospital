<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <!-- <script src="https://cdn.tailwindcss.com" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="style.css">    
    <script>
// Try to load ApexCharts - if offline, define a placeholder to prevent errors
window.ApexCharts = window.ApexCharts || null;
</script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts" onerror="console.warn('ApexCharts CDN unavailable - charts will not render')" crossorigin="anonymous"></script>
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .rounded-lg.border { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted { background-color: #262626 !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .tab-panel.hidden { display: none; }
        [role="tab"][data-state="active"] { background: white; color: #1f2937; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        body.dark [role="tab"][data-state="active"] { background: #131212; color: #e5e5e5; }
        .dropdown-menu {
            position: fixed;
            z-index: 100;
            background-color: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            overflow: hidden;
            min-width: 180px;
        }
        body.dark .dropdown-menu { background-color: #2a2a2a; border-color: #404040; }
        .dropdown-item { padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: background 0.1s; }
        .dropdown-item:hover { background-color: #f3f4f6; }
        body.dark .dropdown-item:hover { background-color: #3f3f46; }
        .action-menu { position: fixed; z-index: 100; background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 0.25rem; min-width: 180px; }
        body.dark .action-menu { background: #2a2a2a; border-color: #404040; }
        .action-menu-item { padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: background 0.1s; }
        .action-menu-item:hover { background-color: #f3f4f6; }
        .toast-notify { transition: opacity 0.3s ease; }
        /* Custom toggle switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e1;
            transition: .3s;
            border-radius: 24px;
        }
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .3s;
            border-radius: 50%;
        }
        input:checked + .toggle-slider { background-color: #4f46e5; }
        input:checked + .toggle-slider:before { transform: translateX(20px); }
        body.dark .toggle-slider { background-color: #475569; }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    

    <!-- Sticky Header -->
        <header class="sticky top-0 z-40 border-b bg-background shadow-sm border-gray-200">
            <div class="flex h-16 items-center justify-between px-4 md:px-6">
                <div class="flex items-center gap-2">
                    <button class="focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="18" y2="18"></line></svg></button>
                    <a href="index.html" id="headerLogo" class="flex items-center space-x-2">
                        <img alt="Medi-track" src="logo.png" class="h-8 " >
                        <span class="font-bold text-xl">Medi-track</span>
                    </a>                
                </div>
            <div class="flex items-center gap-4">
                <!-- Fullscreen Toggle Button -->
                <button id="meditrack-lang-btn" class="inline-flex items-center justify-center gap-1 rounded-md border border-gray-200 bg-white px-2.5 py-1.5 text-sm font-medium text-gray-700 transition-colors hover:border-indigo-500 hover:bg-gray-50 size-10" aria-label="Language">
                        <span style="font-size: 16px;">🇬🇧</span>
                        <span class="hidden sm:inline">EN</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>
                
                <!-- Theme Toggle Button -->
                <button id="themeToggleBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-gray-100 size-10" aria-label="Toggle theme">
                    <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="hidden text-gray-600"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path></svg>
                    <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-600"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path></svg>
                </button>
                
                <!-- Notifications Dropdown -->
                <div class="relative">
                    <button id="notificationsBtn" class="inline-flex items-center justify-center rounded-md transition-colors hover:bg-gray-100 size-10 relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path></svg>
                        <span class="absolute right-1 top-1 flex h-2 w-2 rounded-full bg-red-500"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span></span>
                    </button>
                    <div id="notificationsDropdown" class="hidden absolute right-0 mt-2 z-50 w-80 rounded-md border bg-background shadow-lg overflow-hidden">
                        <div class="px-3 py-2 text-sm font-semibold flex justify-between border-b"><span>Notifications</span><button id="markAllReadBtn" class="text-xs text-indigo-600">Mark all as read</button></div>
                        <div class="max-h-[300px] overflow-y-auto">
                            <div role="group">
                                <div role="menuitem" class="relative flex cursor-default select-none items-center gap-2 rounded-sm text-sm outline-none transition-colors focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 p-0 focus:bg-transparent" tabindex="-1" data-orientation="vertical" data-radix-collection-item="">
                                    
                                    <div class="flex items-start gap-2 p-3 text-sm transition-colors hover:bg-muted/50 rounded-md bg-muted/30">
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary/10">
                                            <span role="img" aria-label="appointment">🗓️</span></div><div class="flex-1 space-y-1">
                                                <div class="flex items-center justify-between">
                                                    <p class="font-semibold">New appointment request</p>
                                                    <p class="text-xs text-muted-foreground">Just now</p>
                                                </div>
                                                <p class="text-xs text-muted-foreground">Dr. Ssemwogerere has a new appointment request from John Donanto</p>
                                            </div>
                                            <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground size-10 h-6 w-6 shrink-0 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check h-3 w-3"><path d="M20 6 9 17l-5-5"></path></svg>
                                                <span class="sr-only">Mark as read</span>
                                            </button>
                                            </div>
                                            </div>
                                            <div role="menuitem" class="relative flex cursor-default select-none items-center gap-2 rounded-sm text-sm outline-none transition-colors focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 p-0 focus:bg-transparent" tabindex="-1" data-orientation="vertical" data-radix-collection-item="">
                                                <div class="flex items-start gap-2 p-3 text-sm transition-colors hover:bg-muted/50 rounded-md bg-muted/30">
                                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary/10">
                                                        <span role="img" aria-label="prescription">💊</span></div><div class="flex-1 space-y-1">
                                                            <div class="flex items-center justify-between">
                                                                <p class="font-semibold">Prescription renewal</p>
                                                                <p class="text-xs text-muted-foreground">5 min ago</p>
                                                            </div>
                                                            <p class="text-xs text-muted-foreground">Patient Emily Johnson requested a prescription renewal</p>
                                                        </div>
                                                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground size-10 h-6 w-6 shrink-0 rounded-full">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check h-3 w-3"><path d="M20 6 9 17l-5-5"></path></svg>
                                                            <span class="sr-only">Mark as read</span></button></div></div><div role="menuitem" class="relative flex cursor-default select-none items-center gap-2 rounded-sm text-sm outline-none transition-colors focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 p-0 focus:bg-transparent" tabindex="-1" data-orientation="vertical" data-radix-collection-item="">
                                                                <div class="flex items-start gap-2 p-3 text-sm transition-colors hover:bg-muted/50 rounded-md bg-muted/30">
                                                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary/10">
                                                                        <span role="img" aria-label="system">🔔</span>
                                                                    </div>
                                                                        <div class="flex-1 space-y-1">
                                                                            <div class="flex items-center justify-between">
                                                                            <p class="font-semibold">Lab results available</p>
                                                                            <p class="text-xs text-muted-foreground">1 hour ago</p>
                                                                        </div>
                                                                        <p class="text-xs text-muted-foreground">New lab results are available for patient Michael Lee</p>
                                                                    </div>
                                                                    <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground size-10 h-6 w-6 shrink-0 rounded-full">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check h-3 w-3"><path d="M20 6 9 17l-5-5"></path></svg>
                                                                        <span class="sr-only">Mark as read</span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div role="menuitem" class="relative flex cursor-default select-none items-center gap-2 rounded-sm text-sm outline-none transition-colors focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 p-0 focus:bg-transparent" tabindex="-1" data-orientation="vertical" data-radix-collection-item="">
                                                                <div class="flex items-start gap-2 p-3 text-sm transition-colors hover:bg-muted/50 rounded-md opacity-80">
                                                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary/10">
                                                                        <span role="img" aria-label="message">💬</span></div>
                                                                        <div class="flex-1 space-y-1">
                                                                            <div class="flex items-center justify-between"><p class="font-medium">New message</p>
                                                                                <p class="text-xs text-muted-foreground">3 hours ago</p>
                                                                            </div>
                                                                            <p class="text-xs text-muted-foreground">You have a new message from Dr. Wamala</p>
                                                                        </div>
                                                                </div>
                                                            </div>
                                                                        <div role="menuitem" class="relative flex cursor-default select-none items-center gap-2 rounded-sm text-sm outline-none transition-colors focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 p-0 focus:bg-transparent" tabindex="-1" data-orientation="vertical" data-radix-collection-item="">
                                                                            <div class="flex items-start gap-2 p-3 text-sm transition-colors hover:bg-muted/50 rounded-md opacity-80">
                                                                                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary/10">
                                                                                    <span role="img" aria-label="billing">💰</span>
                                                                                </div>
                                                                                    <div class="flex-1 space-y-1">
                                                                                        <div class="flex items-center justify-between">
                                                                                            <p class="font-medium">Payment received</p>
                                                                                            <p class="text-xs text-muted-foreground">Yesterday</p>
                                                                                        </div>
                                                                                        <p class="text-xs text-muted-foreground">Payment of $150 received from patient Wanjiru Sarah</p>
                                                                                    </div>
                                                                            </div>
                            </div>
                        </div>
                                </div>
                        <div class="p-2 text-center border-t"><a href="notifications.html" class="text-sm text-indigo-600">View all notifications</a></div>
                    </div>
                </div>
                
                <!-- Profile Dropdown with Chat & Support -->
                <div class="relative">
                    <button id="profileBtn" class="flex items-center justify-center h-8 w-8 rounded-full hover:ring-2 hover:ring-gray-200">
                        <img src="user.png" alt="Profile" class="h-8 w-8 rounded-full object-cover">
                    </button>
                    <div id="profileDropdown" class="hidden absolute right-0 mt-2 z-50 w-56 rounded-md border bg-background shadow-lg p-1">
                        <div class="px-2 py-1.5 border-b">
                            <p class="font-medium text-sm">Dr. Nakato Sarah</p>
                            <p class="text-xs text-gray-500">admin@hospital.ug</p>
                        </div>
                        
                        <!-- Profile -->
                        <a href="profile-setting.html" class="flex items-center gap-2 px-2 py-1.5 text-sm hover:bg-gray-100 rounded">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Profile
                        </a>
                        
                        <!-- Settings -->
                        <a href="settings.html" class="flex items-center gap-2 px-2 py-1.5 text-sm hover:bg-gray-100 rounded">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                            </svg>
                            Settings
                        </a>
                        
                        <!-- Chat -->
                        <a href="chat.html" class="flex items-center gap-2 px-2 py-1.5 text-sm hover:bg-gray-100 rounded">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"></path>
                            </svg>
                            Chat
                        </a>
                        
                        <!-- Support -->
                        <a href="support.html" class="flex items-center gap-2 px-2 py-1.5 text-sm hover:bg-gray-100 rounded">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                                <path d="M12 17h.01"></path>
                            </svg>
                            Support
                        </a>
                        
                        <div class="border-t my-1"></div>
                        
                        <!-- Logout -->
                        <a href="login.html" class="flex items-center gap-2 px-2 py-1.5 text-sm text-red-600 hover:bg-gray-100 rounded">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" x2="9" y1="12" y2="12"></line>
                            </svg>
                            Log out
                        </a>
                    </div>
                </div>
            </div>
            </div>
        </header>

    <div class="flex flex-1 items-start relative">
<aside class="!fixed h-full left-0 bottom-0 z-50 flex w-64 flex-col border-r bg-background transition-transform duration-300 ease-in-out translate-x-0 shadow-lg">
    <div class="flex py-3 xl:py-3.5 items-center justify-between px-4 border-b border-gray-200">
        <a class="flex items-center space-x-2" href="index.html"><img alt="Meditrack" loading="lazy" width="36" height="36" decoding="async" data-nimg="1" src="logo.png" style="color: transparent;">
            <span class="font-bold inline-block">Medi-track</span>
        </a>
        <button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-gray-100 hover:text-gray-900 size-10 xl:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x size-6 text-gray-600"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
            <span class="sr-only">Close sidebar</span>
        </button>
    </div>
    <div class="flex-1 py-2 border-t border-gray-200 h-full overflow-y-auto custom-scrollbar">
        <nav class="space-y-1 px-2">
            <!-- Dashboard Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="dashboard-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard mr-2 h-4 w-4"><rect width="7" height="9" x="3" y="3" rx="1"></rect><rect width="7" height="5" x="14" y="3" rx="1"></rect><rect width="7" height="9" x="14" y="12" rx="1"></rect><rect width="7" height="5" x="3" y="16" rx="1"></rect></svg>
                        Dashboard
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="dashboard-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="dashboard-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="index.html">Admin Dashboard</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="doctor-dashboard.html">Doctor Dashboard</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="patient-dashboard.html">Patient Dashboard</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="business-dashboard.html">Business Dashboard</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="nurse-station.html">Nurse Station</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="super-admin.html">Super Admin</a>

                </div>
            </div>

            <!-- Doctors Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="doctors-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users mr-2 h-4 w-4"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                        Doctors
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="doctors-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="doctors-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="doctors.html">Doctors List</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="schedule.html">Doctor Schedule</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="specialisation.html">Specializations</a>
                </div>
            </div>

            <!-- Patients -->
            <div class="space-y-1 custom-scrollbar">
                <a class="nav-link flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900 text-gray-600" href="patients.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round mr-2 h-4 w-4">
                        <circle cx="12" cy="8" r="5"></circle>
                        <path d="M20 21a8 8 0 0 0-16 0"></path>
                    </svg>
                    Patients
                </a>
            </div>

            <!-- Appointments Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="appointments-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar mr-2 h-4 w-4"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                        Appointments
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="appointments-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="appointments-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="appointments.html">All Appointments</a>
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="appointment-calendar.html">Calendar View</a>
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="appointment-requests.html">Appointment Requests</a>
                </div>
            </div>

            <!-- Prescriptions Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="prescriptions-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-briefcase-medical-icon lucide-briefcase-medical mr-2 h-4 w-4">
                            <path d="M12 11v4"/>
                            <path d="M14 13h-4"/>
                            <path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/>
                            <path d="M18 6v14"/>
                            <path d="M6 6v14"/>
                            <rect width="20" height="14" x="2" y="6" rx="2"/>
                        </svg>
                        Prescriptions
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="prescriptions-arrow h-4 w-4 transition-transform duration-200">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div class="prescriptions-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="prescriptions.html">All Prescriptions</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="medicine-templates.html">Medicine Templates</a>
                </div>
            </div>

            <!-- Radiology Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="radiology-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-scan mr-2 h-4 w-4"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/></svg>
                        Radiology
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="radiology-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="radiology-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="radiology-list.html">All Orders</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="radiology-schedule.html">Imaging Schedule</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="radiology-reports.html">Reports</a>
                </div>
            </div>

            <!-- Ambulance Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="ambulance-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ambulance mr-2 h-4 w-4"><path d="M10 10H6"></path><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"></path><path d="M19 18h2a1 1 0 0 0 1-1v-3.28a1 1 0 0 0-.684-.948l-1.923-.641a1 1 0 0 1-.578-.502l-1.539-3.076A1 1 0 0 0 16.382 8H14"></path><path d="M8 8v4"></path><path d="M9 18h6"></path><circle cx="17" cy="18" r="2"></circle><circle cx="7" cy="18" r="2"></circle></svg>
                        Ambulance
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="ambulance-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="ambulance-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="ambulance-calls.html">Ambulance Call List</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="ambulance-list.html">Ambulance List</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="ambulance-details.html">Ambulance Details</a>
                </div>
            </div>

            <!-- Laboratory Accordion (NEW) -->
            <div class="space-y-1 custom-scrollbar">
                <button class="laboratory-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-flask-conical mr-2 h-4 w-4"><path d="M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"></path><path d="M8.5 2h7"></path><path d="M12 2v4"></path></svg>
                        Laboratory
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="laboratory-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="laboratory-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="lab-dashboard.html">Lab Dashboard</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="lab-tests-management.html">Test Catalog</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="test-requests.html">Test Requests</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="sample-collection.html">Sample Collection</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="result-entry.html">Result Entry</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="lab-equipment.html">Equipment</a>
                </div>
            </div>

<!-- Vaccination Accordion -->
<div class="space-y-1 custom-scrollbar">
    <button class="vaccination-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-syringe mr-2 h-4 w-4"><path d="m18 2 4 4"/><path d="m17 7 3-3"/><path d="M19 9 8.7 19.3c-1 1-2.5 1-3.4 0l-.6-.6c-1-1-1-2.5 0-3.4L15 5"/><path d="m9 11 4 4"/><path d="m5 19-3 3"/><path d="m14 4 6 6"/></svg>
            Vaccination
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="vaccination-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
    </button>
    <div class="vaccination-submenu hidden ml-4 space-y-1 pl-2 pt-1">
        <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="vaccination-schedule.html">Schedule</a>
        <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="vaccination.html">Records</a>
    </div>
</div>

            <!-- Physiotherapy Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="physio-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-activity mr-2 h-4 w-4"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                        Physiotherapy
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="physio-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <div class="physio-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="physiotherapy-dashboard.html">Dashboard</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="physiotherapy-schedule.html">Schedule</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="physiotherapy-treatment-plans.html">Treatment Plans</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="physiotherapy-exercises.html">Exercise Library</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="physiotherapy-hep.html">Home Exercises</a>
                </div>
            </div>

            <!-- Nutrition / Dietary Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="nutrition.html">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-soup-icon lucide-soup mr-2 h-4 w-4"><path d="M12 21a9 9 0 0 0 9-9H3a9 9 0 0 0 9 9Z"/><path d="M7 21h10"/><path d="M19.5 12 22 6"/><path d="M16.25 3c.27.1.8.53.75 1.36-.06.83-.93 1.2-1 2.02-.05.78.34 1.24.73 1.62"/><path d="M11.25 3c.27.1.8.53.74 1.36-.05.83-.93 1.2-.98 2.02-.06.78.33 1.24.72 1.62"/><path d="M6.25 3c.27.1.8.53.75 1.36-.06.83-.93 1.2-1 2.02-.05.78.34 1.24.74 1.62"/></svg>                      
                    Nutrition
                </a>
            </div>

            <!-- OT / Surgery Accordion (NEW) -->
            <div class="space-y-1 custom-scrollbar">
                <button class="surgery-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-scalpel mr-2 h-4 w-4"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
                        OT / Surgery
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="surgery-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="surgery-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="ot-dashboard.html">OT Dashboard</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="ot-schedule.html">OT Schedule</a>
                </div>
            </div>

            <!-- Pharmacy Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="medicine.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pill mr-2 h-4 w-4"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"></path><path d="m8.5 8.5 7 7"></path></svg>
                    Pharmacy
                </a>
            </div>

            <!-- Blood Bank Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="bloodbank-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-droplet mr-2 h-4 w-4"><path d="M12 22a7 7 0 0 0 7-7c0-2-1-3.9-3-5.5s-3.5-4-4-6.5c-.5 2.5-2 4.9-4 6.5C6 11.1 5 13 5 15a7 7 0 0 0 7 7z"></path></svg>
                        Blood Bank
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="bloodbank-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="bloodbank-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="blood-stock.html">Blood Stock</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="blood-donors.html">Blood Donor</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="issued-blood.html">Blood Issued</a>
                </div>
            </div>

            <!-- Billing Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="billing-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-receipt mr-2 h-4 w-4"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"></path><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path><path d="M12 17.5v-11"></path></svg>
                        Billing
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="billing-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="billing-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="billing.html">Invoices List</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="payments.html">Payments History</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="insurance-claims.html">Insurance Claims</a>
                </div>
            </div>

            <!-- Departments Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="departments-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building2 mr-2 h-4 w-4"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path><path d="M10 6h4"></path><path d="M10 10h4"></path><path d="M10 14h4"></path><path d="M10 18h4"></path></svg>
                        Departments
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="departments-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="departments-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="departments.html">Department List</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="services.html">Services Offered</a>
                </div>
            </div>

            <!-- Inventory Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="inventory-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package mr-2 h-4 w-4"><path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"></path><path d="M12 22V12"></path><path d="m3.3 7 7.703 4.734a2 2 0 0 0 1.994 0L20.7 7"></path><path d="m7.5 4.27 9 5.15"></path></svg>
                        Inventory
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="inventory-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="inventory-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="inventory.html">Inventory List</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="stock-alerts.html">Stock Alerts</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="suppliers.html">Suppliers List</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="transfers.html">Transfers</a>
                </div>
            </div>

            <!-- Staff Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="staff-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-cog mr-2 h-4 w-4"><circle cx="18" cy="15" r="3"></circle><circle cx="9" cy="7" r="4"></circle><path d="M10 15H6a4 4 0 0 0-4 4v2"></path><path d="m21.7 16.4-.9-.3"></path><path d="m15.2 13.9-.9-.3"></path><path d="m16.6 18.7.3-.9"></path><path d="m19.1 12.2.3-.9"></path><path d="m19.6 18.7-.4-1"></path><path d="m16.8 12.3-.4-1"></path><path d="m14.3 16.6 1-.4"></path><path d="m20.7 13.8 1-.4"></path></svg>
                        Staff
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="staff-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="staff-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="staff-management.html">All Staff</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="add-staff.html">Add Staff</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="roles-permissions.html">Roles &amp; Permissions</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="staff-attendance.html">Attendance</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="payroll.html">Payroll</a>
                </div>
            </div>

            <!-- Records Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="records-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text mr-2 h-4 w-4"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg>
                        Records
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="records-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="records-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="birth-records.html">Birth Records</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="death-records.html">Death Records</a>
                </div>
            </div>

            <!-- Room Allotment Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="rooms-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-bed mr-2 h-4 w-4"><path d="M2 4v16"></path><path d="M2 8h18a2 2 0 0 1 2 2v10"></path><path d="M2 17h20"></path><path d="M6 8v9"></path></svg>
                        Room Allotment
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="rooms-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="rooms-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="rooms-alloted.html">Alloted Rooms</a>
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="rooms-by-department.html">Rooms by Department</a>
                </div>
            </div>

            <!-- Reviews Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="reviews-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star mr-2 h-4 w-4"><path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"></path></svg>
                        Reviews
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="reviews-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="reviews-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="doctor-review.html">Doctor Reviews</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="patient-review.html">Patient Reviews</a>
                </div>
            </div>

            <!-- Feedback (single link) -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="feedback.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square mr-2 h-4 w-4"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    Feedback
                </a>
            </div>

            <!-- Reports Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="reports-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-column mr-2 h-4 w-4"><path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="M18 17V9"></path><path d="M13 17V5"></path><path d="M8 17v-3"></path></svg>
                        Reports
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="reports-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="reports-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="reports.html">Overview</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="appointment-reports.html">Appointment Reports</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="financial-reports.html">Financial Reports</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="inventory-report.html">Inventory Reports</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="patient-visit-report.html">Patient Visit Reports</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="operational-reports.html">Operational Reports</a>
                </div>
            </div>

            <!-- Settings Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="settings-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings mr-2 h-4 w-4"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        Settings
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="settings-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="settings-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="settings.html">General Settings</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="settings-notifications.html">Notifications</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="hours.html">Working Hours</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="integrations.html">Integrations</a>
                </div>
            </div>

            <!-- Authentication Accordion -->
            <div class="space-y-1 custom-scrollbar">
                <button class="auth-toggle flex w-full items-center justify-between rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check mr-2 h-4 w-4"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg>
                        Authentication
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="auth-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
                </button>
                <div class="auth-submenu hidden ml-4 space-y-1 pl-2 pt-1">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="login.html">Login</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="register.html">Register</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="forgot-password.html">Forgot Password</a>
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="profile-setting.html">Profile Settings</a>
                </div>
            </div>

            <!-- Calendar (single link) -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="calendar.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar1 mr-2 h-4 w-4"><path d="M11 14h1v4"></path><path d="M16 2v4"></path><path d="M3 10h18"></path><path d="M8 2v4"></path><rect x="3" y="4" width="18" height="18" rx="2"></rect></svg>
                    Calendar
                </a>
            </div>

            <!-- Tasks (single link) -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="task.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check mr-2 h-4 w-4"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
                    Tasks
                </a>
            </div>

            <!-- Queque (single link) -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="queue-dashboard.html">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ticket mr-2 h-4 w-4">
    <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path>
    <path d="M13 5v2"></path>
    <path d="M13 17v2"></path>
    <path d="M13 11v2"></path>
</svg>Queque
                </a>
            </div>

            <!-- Contacts (single link) -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="contacts.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round mr-2 h-4 w-4"><circle cx="12" cy="8" r="5"></circle><path d="M20 21a8 8 0 0 0-16 0"></path></svg>
                    Contacts
                </a>
            </div>

            <!-- Email (single link) -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="email.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail mr-2 h-4 w-4"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>
                    Email
                </a>
            </div>

            <!-- Chat (single link) -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="chat.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-circle mr-2 h-4 w-4"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"></path></svg>
                    Chat
                </a>
            </div>

            <!-- Support (single link) -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="support.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-help mr-2 h-4 w-4"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><path d="M12 17h.01"></path></svg>
                    Support
                </a>
            </div>

            <!-- Widgets (single link) -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="widgets.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-grid3x3 mr-2 h-4 w-4"><rect width="18" height="18" x="3" y="3" rx="2"></rect><path d="M3 9h18"></path><path d="M3 15h18"></path><path d="M9 3v18"></path><path d="M15 3v18"></path></svg>
                    Widgets
                </a>
            </div>
        </nav>
    </div>
    <div class="border-t border-gray-200 p-4 shrink-0">
        <div class="flex items-center gap-3">
            <span class="relative flex shrink-0 overflow-hidden rounded-full h-8 w-8">
                <span class="flex h-full w-full items-center justify-center rounded-full bg-gray-200 text-gray-700 text-sm font-semibold">SJ</span>
            </span>
            <div class="space-y-0.5">
                <p class="text-sm font-medium text-gray-800">Dr. Nakato Sarah</p>
                <p class="text-xs text-gray-500">Administrator</p>
            </div>
        </div>
    </div>
</aside>

        <main class="flex-1 overflow-auto p-4 xl:p-6 xl:ml-64 w-full">
            <div class="flex flex-col gap-5 overflow-x-hidden max-full mx-auto">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4"><div><h2 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">Dashboard</h2><p class="text-gray-500">Welcome back, Dr. Johnson! Here's what's happening today.</p></div><div class="flex items-center flex-wrap gap-2"><div class="relative"><button id="dateRangeBtn" class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-background h-10 px-4 text-sm w-[260px] justify-start  hover:bg-accent hover:text-accent-foreground h-10 "><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 2v4M16 2v4M3 10h18"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect></svg><span id="dateRangeText">Apr 1, 2025 - Apr 30, 2025</span></button><div id="datePickerPopover" class="hidden absolute z-50 mt-2 w-[260px] rounded-md border border-gray-200 bg-background shadow-lg"><div class="p-4 space-y-4"><div><label class="text-sm font-medium text-gray-700 block mb-1">Start Date</label><input type="date" id="startDate" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div><div><label class="text-sm font-medium text-gray-700 block mb-1">End Date</label><input type="date" id="endDate" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div><div class="flex gap-2 pt-2"><button id="applyDateBtn" class="flex-1 rounded-md bg-primary text-white py-2 text-sm font-medium hover:bg-primary/90">Apply</button><button id="cancelDateBtn" class="flex-1 rounded-md border border-gray-300 bg-background py-2 text-sm font-medium  hover:bg-accent hover:text-accent-foreground h-10">Cancel</button></div></div></div></div><button id="exportDashboardBtn" class="inline-flex items-center gap-2 rounded-md border px-3 py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10 "><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>Export</button></div></div>

                <!-- Stats Cards -->
                <div class="grid gap-4 xl:gap-6 sm:grid-cols-2 lg:grid-cols-4" id="statsCards"></div>

                <!-- Tabs -->
                <div dir="ltr" class="space-y-4"><div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1"><button type="button" data-tab="overview" class="tab-btn inline-flex rounded-sm px-3 py-1.5 text-sm font-medium" data-state="active">Overview</button><button type="button" data-tab="analytics" class="tab-btn inline-flex rounded-sm px-3 py-1.5 text-sm font-medium" data-state="inactive">Analytics</button><button type="button" data-tab="reports" class="tab-btn inline-flex rounded-sm px-3 py-1.5 text-sm font-medium" data-state="inactive">Reports</button><button type="button" data-tab="notifications" class="tab-btn inline-flex rounded-sm px-3 py-1.5 text-sm font-medium" data-state="inactive">Notifications</button></div>
                    
                    <!-- Overview Tab -->
                    <div id="tab-overview" class="tab-panel mt-4 space-y-4"><div class="max-md:space-y-4 md:grid md:gap-4 md:grid-cols-2 lg:grid-cols-7"><div class="rounded-lg border bg-background shadow-sm lg:col-span-4"><div class="p-4 border-b"><h2 class="text-xl font-semibold">Overview</h2><div class="text-gray-500">Patient visits and revenue for the current period.</div></div><div class="p-4"><div id="revenueChart"></div></div></div><div class="rounded-lg border bg-background shadow-sm lg:col-span-3"><div class="p-4 border-b"><h2 class="text-xl font-semibold">Recent Appointments</h2><div class="text-gray-500">You have 12 appointments today.</div></div><div class="p-4 max-h-[400px] overflow-y-auto pr-2" id="recentAppointmentsContainer"></div>
                    <a class="inline-flex items-center justify-center text-sm font-medium text-indigo-600 hover:underline w-full text-center mb-4" href="appointments.html">View all appointments</a>
                </div></div></div>
                    
                    <!-- Analytics Tab -->
                    <div id="tab-analytics" class="tab-panel hidden mt-4 space-y-4"><div class="flex items-center justify-between gap-3 flex-wrap"><div><h2 class="text-xl font-semibold">Detailed Analytics</h2><p class="text-gray-500">Insights and trends from your clinic data</p></div><div class="flex items-center gap-2"><button id="exportAnalyticsBtn" class="inline-flex items-center gap-2 rounded-md border px-3 py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10 "><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>Export</button></div></div><div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3"><div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h2 class="text-xl font-semibold">Patient Demographics</h2><div class="text-gray-500">Age and gender distribution</div></div><div class="p-4"><div id="demographicsChart"></div></div></div><div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h2 class="text-xl font-semibold">Appointment Types</h2><div class="text-gray-500">Distribution by service category</div></div><div class="p-4"><div id="appointmentTypesChart"></div></div></div><div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h2 class="text-xl font-semibold">Revenue Sources</h2><div class="text-gray-500">Breakdown by department</div></div><div class="p-4"><div id="revenueSourcesChart"></div></div></div></div><div class="grid gap-4 md:grid-cols-2"><div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h2 class="text-xl font-semibold">Patient Satisfaction</h2><div class="text-gray-500">Based on feedback surveys</div></div><div class="p-4"><div class="space-y-4" id="satisfactionScores"></div></div></div><div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h2 class="text-xl font-semibold">Staff Performance</h2><div class="text-gray-500">Top performing staff members</div></div><div class="p-4"><div class="space-y-4" id="staffPerformance"></div></div></div></div></div>
                    
                    <!-- Reports Tab -->
                    <div id="tab-reports" class="tab-panel hidden mt-4 space-y-4"><div class="flex items-center justify-between flex-wrap gap-3"><div><h2 class="text-xl font-semibold mb-2">Available Reports</h2><p class="text-gray-500">Access and generate detailed reports</p></div><button class="inline-flex items-center gap-2 rounded-md bg-primary text-white px-4 py-2 text-sm hover:bg-primary/90"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>Generate New Report</button></div><div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3"><div class="rounded-lg border bg-background shadow-sm p-4"><h3 class="font-semibold mb-3">Financial Reports</h3><div class="space-y-3"><div class="flex justify-between items-center"><span class="text-sm">Monthly Revenue Summary</span><button class="text-indigo-600 text-sm hover:underline">View</button></div><div class="flex justify-between items-center"><span class="text-sm">Quarterly Financial Analysis</span><button class="text-indigo-600 text-sm hover:underline">View</button></div><div class="flex justify-between items-center"><span class="text-sm">Insurance Claims Report</span><button class="text-indigo-600 text-sm hover:underline">View</button></div><div class="flex justify-between items-center"><span class="text-sm">Outstanding Payments</span><button class="text-indigo-600 text-sm hover:underline">View</button></div></div><a href="financial-reports.html" class="inline-block mt-3 text-sm text-indigo-600 hover:underline">View all financial reports →</a></div><div class="rounded-lg border bg-background shadow-sm p-4"><h3 class="font-semibold mb-3">Patient Reports</h3><div class="space-y-3"><div class="flex justify-between items-center"><span class="text-sm">New Patient Registrations</span><button class="text-indigo-600 text-sm hover:underline">View</button></div><div class="flex justify-between items-center"><span class="text-sm">Patient Demographics</span><button class="text-indigo-600 text-sm hover:underline">View</button></div><div class="flex justify-between items-center"><span class="text-sm">Visit Frequency Analysis</span><button class="text-indigo-600 text-sm hover:underline">View</button></div><div class="flex justify-between items-center"><span class="text-sm">Treatment Outcomes</span><button class="text-indigo-600 text-sm hover:underline">View</button></div></div><a href="patient-visit-report.html" class="inline-block mt-3 text-sm text-indigo-600 hover:underline">View all patient reports →</a></div><div class="rounded-lg border bg-background shadow-sm p-4"><h3 class="font-semibold mb-3">Operational Reports</h3><div class="space-y-3"><div class="flex justify-between items-center"><span class="text-sm">Staff Performance Metrics</span><button class="text-indigo-600 text-sm hover:underline">View</button></div><div class="flex justify-between items-center"><span class="text-sm">Inventory Status</span><button class="text-indigo-600 text-sm hover:underline">View</button></div><div class="flex justify-between items-center"><span class="text-sm">Room Utilization</span><button class="text-indigo-600 text-sm hover:underline">View</button></div><div class="flex justify-between items-center"><span class="text-sm">Wait Time Analysis</span><button class="text-indigo-600 text-sm hover:underline">View</button></div></div><a href="operational-reports.html" class="inline-block mt-3 text-sm text-indigo-600 hover:underline">View all operational reports →</a></div></div><div class="rounded-lg border bg-background shadow-sm p-4 max-h-[300px] overflow-y-auto"><h3 class="font-semibold mb-3">Recent Report Activity</h3><div class="space-y-3" id="reportActivity"></div></div></div>
                    
                    <!-- Notifications Tab -->
                    <div id="tab-notifications" class="tab-panel hidden mt-4 space-y-4"><div class="flex items-center justify-between flex-wrap gap-3"><div><h2 class="text-xl font-semibold mb-2">Notifications</h2><p class="text-gray-500">Stay updated with important alerts and messages</p></div><div class="flex items-center gap-2"><button id="markAllReadBtn" class="inline-flex items-center gap-2 rounded-md border px-3 py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10 ">Mark All as Read</button><button class="inline-flex items-center gap-2 rounded-md border px-3 py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10 "><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>Filter</button></div></div><div class="grid gap-4 md:grid-cols-3"><div class="rounded-lg border bg-background shadow-sm p-4"><div class="flex justify-between items-center mb-3"><h3 class="font-semibold">Unread</h3><span class="inline-flex rounded-full border px-2 py-0.5 text-xs bg-primary text-white">12</span></div><div class="space-y-3 max-h-[300px] overflow-y-auto pr-2" id="unreadNotifications"></div></div><div class="rounded-lg border bg-background shadow-sm p-4"><div class="flex justify-between items-center mb-3"><h3 class="font-semibold">Today</h3><span class="inline-flex rounded-full border px-2 py-0.5 text-xs">8</span></div><div class="space-y-3 max-h-[400px] overflow-y-auto pr-2" id="todayNotifications"></div></div><div class="rounded-lg border bg-background shadow-sm p-4"><div class="flex justify-between items-center mb-3"><h3 class="font-semibold">Earlier</h3><span class="inline-flex rounded-full border px-2 py-0.5 text-xs">15</span></div><div class="space-y-3 max-h-[400px] overflow-y-auto pr-2" id="earlierNotifications"></div></div></div><div class="rounded-lg border bg-background shadow-sm p-4"><h3 class="font-semibold mb-4">Notification Settings</h3><div class="grid gap-4 md:grid-cols-2"><div class="space-y-4"><h4 class="text-sm font-medium">Notification Categories</h4><div class="flex justify-between items-center"><div><p class="text-sm font-medium">Appointments</p><p class="text-xs text-gray-500">New, cancelled, and rescheduled appointments</p></div><label class="toggle-switch"><input type="checkbox" id="toggleAppointments" checked><span class="toggle-slider"></span></label></div><div class="flex justify-between items-center"><div><p class="text-sm font-medium">Patient Updates</p><p class="text-xs text-gray-500">New registrations and patient status changes</p></div><label class="toggle-switch"><input type="checkbox" id="togglePatients" checked><span class="toggle-slider"></span></label></div><div class="flex justify-between items-center"><div><p class="text-sm font-medium">Staff Alerts</p><p class="text-xs text-gray-500">Schedule changes and staff announcements</p></div><label class="toggle-switch"><input type="checkbox" id="toggleStaff" checked><span class="toggle-slider"></span></label></div><div class="flex justify-between items-center"><div><p class="text-sm font-medium">Inventory Alerts</p><p class="text-xs text-gray-500">Low stock and reorder notifications</p></div><label class="toggle-switch"><input type="checkbox" id="toggleInventory" checked><span class="toggle-slider"></span></label></div></div><div class="space-y-4"><h4 class="text-sm font-medium">Delivery Methods</h4><div class="flex justify-between items-center"><div><p class="text-sm font-medium">In-app Notifications</p><p class="text-xs text-gray-500">Receive notifications within the dashboard</p></div><label class="toggle-switch"><input type="checkbox" id="toggleInApp" checked><span class="toggle-slider"></span></label></div><div class="flex justify-between items-center"><div><p class="text-sm font-medium">Email Notifications</p><p class="text-xs text-gray-500">Receive notifications via email</p></div><label class="toggle-switch"><input type="checkbox" id="toggleEmail" checked><span class="toggle-slider"></span></label></div><div class="flex justify-between items-center"><div><p class="text-sm font-medium">SMS Notifications</p><p class="text-xs text-gray-500">Receive notifications via text message</p></div><label class="toggle-switch"><input type="checkbox" id="toggleSMS"><span class="toggle-slider"></span></label></div><div class="flex justify-between items-center"><div><p class="text-sm font-medium">Push Notifications</p><p class="text-xs text-gray-500">Receive notifications on your mobile device</p></div><label class="toggle-switch"><input type="checkbox" id="togglePush"><span class="toggle-slider"></span></label></div></div></div></div></div></div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- 1. Settings Manager (MUST be first - handles cross-page sync) -->
<script src="js/features/settings-manager.js"></script>

<!-- 2. Core UI Modules (order doesn't strictly matter, but logical grouping helps) -->
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


<!-- 4. Main Initialization (MUST be last) -->
<script src="js/init.js"></script>


<script>    

    

    // Populate all sections
    function showToast(msg) { let t=document.getElementById('toast'); if(!t){t=document.createElement('div');t.id='toast';t.className='fixed bottom-4 right-4 bg-gray-800 text-white px-4 py-2 rounded-md shadow-lg z-50 text-sm opacity-0 transition-opacity';document.body.appendChild(t);} t.textContent=msg; t.classList.remove('opacity-0');t.classList.add('opacity-100');setTimeout(()=>t.classList.remove('opacity-100'),2500); }
    
    // Stats Cards
    document.getElementById('statsCards').innerHTML = `<div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex flex-col gap-1"><svg class="h-6 w-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg><h3 class="text-base font-semibold">Total Revenue</h3><p class="text-gray-500"><span class="text-green-600">+20.1%</span> from last month</p></div><div class="mt-2"><p class="text-3xl font-bold mt-2">{{ $currency->format(45231.89) }}</p></div></div><div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex flex-col gap-1"><svg class="h-6 w-6 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg><h3 class="text-base font-semibold">Appointments</h3><p class="text-gray-500"><span class="text-blue-600">+10.1%</span> from last month</p></div><div class="mt-2"><p class="text-3xl font-bold mt-2">+2,350</p></div></div><div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex flex-col gap-1"><svg class="h-6 w-6 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg><h3 class="text-base font-semibold">Patients</h3><p class="text-gray-500"><span class="text-amber-600">+19%</span> from last month</p></div><div class="mt-2"><p class="text-3xl font-bold mt-2">+12,234</p></div></div><div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex flex-col gap-1"><svg class="h-6 w-6 text-purple-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg><h3 class="text-base font-semibold">Staff</h3><p class="text-gray-500"><span class="text-purple-600">+4</span> new this month</p></div><div class="mt-2"><p class="text-3xl font-bold mt-2">+573</p></div></div>`;
    
    // Appointments with action menu
    const appointments = [{ id: 1, name: "Okello David", type: "Check-up", status: "Confirmed", time: "10:00 AM", initials: "JS" }, { id: 2, name: "Nakato Mary", type: "Consultation", status: "In Progress", time: "11:30 AM", initials: "ED" }, { id: 3, name: "Mwangi Peter", type: "Follow-up", status: "Completed", time: "09:15 AM", initials: "RW" }, { id: 4, name: "Nabisere Maria", type: "Emergency", status: "Pending", time: "02:00 PM", initials: "MG" }, { id: 5, name: "Ssentongo James", type: "Check-up", status: "Confirmed", time: "03:30 PM", initials: "JB" }];
    function showActionMenu(btn, id) { if(window.activeMenu) window.activeMenu.remove(); const rect = btn.getBoundingClientRect(); const menu = document.createElement('div'); menu.className = 'action-menu'; let left = rect.left; let top = rect.bottom + 6; if(left+200>innerWidth) left=innerWidth-210; if(top+150>innerHeight) top=rect.top-160; menu.style.top=top+'px'; menu.style.left=left+'px'; menu.innerHTML=`<div class="px-3 py-2 text-sm font-semibold border-b">Actions</div><div class="action-menu-item" data-action="view">View details</div><div class="action-menu-item" data-action="edit">Edit appointment</div><div class="h-px bg-gray-200 my-1"></div><div class="action-menu-item text-red-600" data-action="cancel">Cancel appointment</div>`; document.body.appendChild(menu); window.activeMenu = menu; const close=(e)=>{if(!menu.contains(e.target)&&e.target!==btn){menu.remove(); window.activeMenu=null; document.removeEventListener('click',close);}}; setTimeout(()=>document.addEventListener('click',close),10); menu.querySelectorAll('.action-menu-item').forEach(el=>el.addEventListener('click',()=>{showToast(`${el.textContent} for appointment ${id}`); menu.remove(); window.activeMenu=null;})); }
    document.getElementById('recentAppointmentsContainer').innerHTML = appointments.map(apt => `<div class="flex items-center justify-between flex-wrap gap-3 rounded-md border p-3 mb-3"><div class="flex items-center gap-3"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span><div><p class="font-medium">${apt.name}</p><p class="text-gray-500">${apt.type}</p><div class="flex items-center gap-2 mt-1"><svg class="h-3 w-3 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg><span class="text-xs text-gray-500">Today</span><svg class="h-3 w-3 text-gray-400 ml-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg><span class="text-xs text-gray-500">${apt.time}</span></div></div></div><div class="flex items-center gap-2"><span class="inline-flex rounded-full border px-2 py-0.5 text-xs font-semibold ${apt.status==='Confirmed'?'text-blue-500 border-blue-500':apt.status==='In Progress'?'text-amber-500 border-amber-500':apt.status==='Completed'?'text-green-600 border-green-600 bg-green-50':'text-gray-500 border-gray-500'}">${apt.status}</span><button class="appointment-action p-1 rounded hover:bg-gray-100" data-id="${apt.id}"><svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg></button></div></div>`).join('');
    document.querySelectorAll('.appointment-action').forEach(btn => btn.addEventListener('click', (e) => { e.stopPropagation(); showActionMenu(btn, btn.dataset.id); }));
    
    // Charts are initialized via the initCharts() function below — do not render here
    // Satisfaction and Staff Performance
    document.getElementById('satisfactionScores').innerHTML = `<div><div class="flex justify-between mb-1"><span>Overall Experience</span><span>87%</span></div><div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-green-500 h-2 rounded-full" style="width:87%"></div></div></div><div><div class="flex justify-between mb-1"><span>Wait Times</span><span>72%</span></div><div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-green-500 h-2 rounded-full" style="width:72%"></div></div></div><div><div class="flex justify-between mb-1"><span>Staff Friendliness</span><span>94%</span></div><div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-green-500 h-2 rounded-full" style="width:94%"></div></div></div><div><div class="flex justify-between mb-1"><span>Treatment Effectiveness</span><span>89%</span></div><div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-green-500 h-2 rounded-full" style="width:89%"></div></div></div>`;
    document.getElementById('staffPerformance').innerHTML = `<div class="flex items-center justify-between"><div class="flex items-center gap-2"><div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">SC</div><div><p class="font-medium text-sm">Dr. Sarah Chen</p><p class="text-xs text-gray-500">Cardiologist</p></div></div><div class="text-right"><p class="text-sm font-medium">42 patients</p><p class="text-xs text-gray-500">Rating: 4.9/5</p></div></div><div class="flex items-center justify-between"><div class="flex items-center gap-2"><div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">MR</div><div><p class="font-medium text-sm">Dr. Michael Rodriguez</p><p class="text-xs text-gray-500">Pediatrician</p></div></div><div class="text-right"><p class="text-sm font-medium">38 patients</p><p class="text-xs text-gray-500">Rating: 4.8/5</p></div></div><div class="flex items-center justify-between"><div class="flex items-center gap-2"><div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">EJ</div><div><p class="font-medium text-sm">Dr. Emily Johnson</p><p class="text-xs text-gray-500">Neurologist</p></div></div><div class="text-right"><p class="text-sm font-medium">35 patients</p><p class="text-xs text-gray-500">Rating: 4.7/5</p></div></div>`;
    
    // Report Activity
    document.getElementById('reportActivity').innerHTML = `<div class="flex justify-between items-center"><div><p class="text-sm font-medium">Dr. Johnson generated <span class="font-semibold">Monthly Revenue Summary</span></p><p class="text-xs text-gray-500">2 hours ago</p></div><button class="text-indigo-600 text-sm hover:underline">View</button></div><div class="flex justify-between items-center"><div><p class="text-sm font-medium">Admin Sarah viewed <span class="font-semibold">Staff Performance Metrics</span></p><p class="text-xs text-gray-500">Yesterday, 4:30 PM</p></div><button class="text-indigo-600 text-sm hover:underline">View</button></div><div class="flex justify-between items-center"><div><p class="text-sm font-medium">Dr. Akampa generated <span class="font-semibold">Patient Demographics</span></p><p class="text-xs text-gray-500">Yesterday, 2:15 PM</p></div><button class="text-indigo-600 text-sm hover:underline">View</button></div><div class="flex justify-between items-center"><div><p class="text-sm font-medium">Nurse Kim viewed <span class="font-semibold">Inventory Status</span></p><p class="text-xs text-gray-500">2 days ago</p></div><button class="text-indigo-600 text-sm hover:underline">View</button></div>`;
    
    // Notifications
    document.getElementById('unreadNotifications').innerHTML = `
<div class="space-y-4"><div class="flex gap-3 border-b pb-3 last:border-0 last:pb-0"><div class="mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert h-4 w-4 text-red-500"><circle cx="12" cy="12" r="10"></circle><line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line></svg></div><div><p class="text-sm font-medium mb-1 line-clamp-1">Urgent: Low medication stock</p><p class="text-xs text-muted-foreground line-clamp-1">Amoxicillin stock is critically low. Please reorder.</p><p class="text-xs text-muted-foreground mt-1">10 minutes ago</p></div></div><div class="flex gap-3 border-b pb-3 last:border-0 last:pb-0"><div class="mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar h-4 w-4 text-blue-500"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg></div><div><p class="text-sm font-medium mb-1 line-clamp-1">New appointment request</p><p class="text-xs text-muted-foreground line-clamp-1">Patient Okello James requested an appointment for tomorrow.</p><p class="text-xs text-muted-foreground mt-1">30 minutes ago</p></div></div><div class="flex gap-3 border-b pb-3 last:border-0 last:pb-0"><div class="mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round h-4 w-4 text-green-500"><circle cx="12" cy="8" r="5"></circle><path d="M20 21a8 8 0 0 0-16 0"></path></svg></div><div><p class="text-sm font-medium mb-1 line-clamp-1">New patient registration</p><p class="text-xs text-muted-foreground line-clamp-1">Nakato Mary has registered as a new patient.</p><p class="text-xs text-muted-foreground mt-1">1 hour ago</p></div></div><div class="flex gap-3 border-b pb-3 last:border-0 last:pb-0"><div class="mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock h-4 w-4 text-orange-500"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></div><div><p class="text-sm font-medium mb-1 line-clamp-1">Staff schedule update</p><p class="text-xs text-muted-foreground line-clamp-1">Dr. Robert has requested time off next week.</p><p class="text-xs text-muted-foreground mt-1">2 hours ago</p></div></div><div class="flex gap-3 border-b pb-3 last:border-0 last:pb-0"><div class="mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dollar-sign h-4 w-4 text-purple-500"><line x1="12" x2="12" y1="2" y2="22"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></div><div><p class="text-sm font-medium mb-1 line-clamp-1">Payment received</p><p class="text-xs text-muted-foreground line-clamp-1">Insurance payment of $1,250 received for patient #12345.</p><p class="text-xs text-muted-foreground mt-1">3 hours ago</p></div></div></div>
`;
    document.getElementById('todayNotifications').innerHTML = `
<div class="space-y-4"><div class="flex gap-3 border-b pb-3 last:border-0 last:pb-0"><div class="mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check h-4 w-4 text-green-500"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg></div><div><p class="text-sm font-medium mb-1">Appointment confirmed</p><p class="text-xs text-muted-foreground line-clamp-1">Dr. Cheptgei confirmed appointment with patient #23456.</p><p class="text-xs text-muted-foreground mt-1">4 hours ago</p></div></div><div class="flex gap-3 border-b pb-3 last:border-0 last:pb-0"><div class="mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users h-4 w-4 text-blue-500"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></div><div><p class="text-sm font-medium mb-1">Staff meeting reminder</p><p class="text-xs text-muted-foreground line-clamp-1">Weekly staff meeting today at 3:00 PM in Conference Room A.</p><p class="text-xs text-muted-foreground mt-1">5 hours ago</p></div></div><div class="flex gap-3 border-b pb-3 last:border-0 last:pb-0"><div class="mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar h-4 w-4 text-purple-500"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg></div><div><p class="text-sm font-medium mb-1">Schedule change</p><p class="text-xs text-muted-foreground line-clamp-1">Your 2:00 PM appointment has been rescheduled to 3:30 PM.</p><p class="text-xs text-muted-foreground mt-1">6 hours ago</p></div></div><div class="flex gap-3 border-b pb-3 last:border-0 last:pb-0"><div class="mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dollar-sign h-4 w-4 text-green-500"><line x1="12" x2="12" y1="2" y2="22"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg></div><div><p class="text-sm font-medium mb-1">Invoice paid</p><p class="text-xs text-muted-foreground line-clamp-1">Patient Maria G Akello has paid invoice #INV-2023-0456.</p><p class="text-xs text-muted-foreground mt-1">8 hours ago</p></div></div></div>
    `;
    document.getElementById('earlierNotifications').innerHTML = `
<div class="space-y-4"><div class="flex gap-3 border-b pb-3 last:border-0 last:pb-0"><div class="mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ban h-4 w-4 text-red-500"><circle cx="12" cy="12" r="10"></circle><path d="m4.9 4.9 14.2 14.2"></path></svg></div><div><p class="text-sm font-medium mb-1">Appointment cancelled</p><p class="text-xs text-muted-foreground line-clamp-1">Patient Thomas Biisa cancelled his appointment for yesterday.</p><p class="text-xs text-muted-foreground mt-1">Yesterday</p></div></div><div class="flex gap-3 border-b pb-3 last:border-0 last:pb-0"><div class="mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert h-4 w-4 text-orange-500"><circle cx="12" cy="12" r="10"></circle><line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line></svg></div><div><p class="text-sm font-medium mb-1">System maintenance</p><p class="text-xs text-muted-foreground line-clamp-1">Scheduled system maintenance completed successfully.</p><p class="text-xs text-muted-foreground mt-1">Yesterday</p></div></div><div class="flex gap-3 border-b pb-3 last:border-0 last:pb-0"><div class="mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check h-4 w-4 text-green-500"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg></div><div><p class="text-sm font-medium mb-1">Lab results ready</p><p class="text-xs text-muted-foreground line-clamp-1">Lab results for patient #34567 are now available.</p><p class="text-xs text-muted-foreground mt-1">2 days ago</p></div></div><div class="flex gap-3 border-b pb-3 last:border-0 last:pb-0"><div class="mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users h-4 w-4 text-blue-500"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></div><div><p class="text-sm font-medium mb-1">New staff onboarding</p><p class="text-xs text-muted-foreground line-clamp-1">Please welcome Dr. Lisa W Adong to the Pediatrics department.</p><p class="text-xs text-muted-foreground mt-1">3 days ago</p></div></div></div>
    `;
    

    
    // Export button
    document.getElementById('exportDashboardBtn')?.addEventListener('click', () => { const data = { date: new Date().toISOString(), stats: "Dashboard data exported" }; const csv = "Metric,Value\nTotal Revenue,$45,231.89\nAppointments,+2,350\nPatients,+12,234\nStaff,+573"; const blob = new Blob([csv], {type: "text/csv"}); const a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = `dashboard_export_${new Date().toISOString().slice(0,10)}.csv`; a.click(); showToast("Dashboard data exported successfully!"); });
    document.getElementById('exportAnalyticsBtn')?.addEventListener('click', () => showToast("Analytics data exported"));
    document.getElementById('markAllReadBtn')?.addEventListener('click', () => showToast("All notifications marked as read"));
    
    
    // Date Range Picker
    const dateRangeBtn = document.getElementById('dateRangeBtn');
    const datePickerPopover = document.getElementById('datePickerPopover');
    dateRangeBtn?.addEventListener('click', (e) => { e.stopPropagation(); datePickerPopover.classList.toggle('hidden'); });
    document.addEventListener('click', (e) => { if (!dateRangeBtn?.contains(e.target) && !datePickerPopover?.contains(e.target)) datePickerPopover?.classList.add('hidden'); });
    document.getElementById('applyDateBtn')?.addEventListener('click', () => { datePickerPopover.classList.add('hidden'); showToast("Date range updated"); });
    document.getElementById('cancelDateBtn')?.addEventListener('click', () => datePickerPopover.classList.add('hidden'));
    
    // Tab switching
// ==================== TAB SWITCHING (WORKS OFFLINE) ====================
const tabs = ['overview', 'analytics', 'reports', 'notifications'];
let chartsInitialized = false;
let charts = { revenueChart: null, demographicsChart: null, appointmentTypesChart: null, revenueSourcesChart: null };

function safeRenderChart(chartInstance, elementId, chartConfig) {
    if (!chartInstance && elementId && chartConfig && window.ApexCharts) {
        try {
            const element = document.querySelector(elementId);
            if (element && !element.hasAttribute('data-chart-rendered')) {
                chartInstance = new ApexCharts(element, chartConfig);
                chartInstance.render();
                element.setAttribute('data-chart-rendered', 'true');
                return chartInstance;
            }
        } catch (e) { console.warn('Chart render failed:', e); }
    }
    return chartInstance;
}

function initCharts() {
    if (!window.ApexCharts) {
        console.warn('ApexCharts not available - charts will not render');
        return false;
    }
    
    // Revenue Chart
    if (document.querySelector("#revenueChart")) {
        try {
            if (charts.revenueChart) charts.revenueChart.destroy();
            charts.revenueChart = new ApexCharts(document.querySelector("#revenueChart"), {
                series: [{ name: 'Revenue', data: [30000, 35000, 42000, 38000, 45000, 52000] }],
                chart: { type: 'area', height: 320, toolbar: { show: false }, redrawOnWindowResize: true },
                xaxis: { categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'] },
                colors: ['#4f46e5'], fill: { type: 'gradient' }, dataLabels: { enabled: false }
            });
            charts.revenueChart.render();
        } catch(e) { console.warn('Revenue chart error:', e); }
    }
    
    // Demographics Chart
    if (document.querySelector("#demographicsChart")) {
        try {
            if (charts.demographicsChart) charts.demographicsChart.destroy();
            charts.demographicsChart = new ApexCharts(document.querySelector("#demographicsChart"), {
                series: [{ name: 'Male', data: [25, 35, 45, 30, 20] }, { name: 'Female', data: [30, 40, 50, 35, 25] }],
                chart: { type: 'bar', height: 250, toolbar: { show: false }, redrawOnWindowResize: true },
                xaxis: { categories: ['0-17', '18-34', '35-49', '50-64', '65+'] },
                colors: ['#171717', '#ec4899'], plotOptions: { bar: { borderRadius: 0, columnWidth: '60%' } }
            });
            charts.demographicsChart.render();
        } catch(e) { console.warn('Demographics chart error:', e); }
    }
    
    // Appointment Types Chart
    if (document.querySelector("#appointmentTypesChart")) {
        try {
            if (charts.appointmentTypesChart) charts.appointmentTypesChart.destroy();
            charts.appointmentTypesChart = new ApexCharts(document.querySelector("#appointmentTypesChart"), {
                series: [35, 25, 20, 10, 5, 5],
                chart: { type: 'donut', height: 250, toolbar: { show: false }, redrawOnWindowResize: true },
                labels: ['Check-up', 'Consultation', 'Follow-up', 'Procedure', 'Emergency', 'Other'],
                colors: ['#2563eb', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899']
            });
            charts.appointmentTypesChart.render();
        } catch(e) { console.warn('Appointment types chart error:', e); }
    }
    
    // Revenue Sources Chart
    if (document.querySelector("#revenueSourcesChart")) {
        try {
            if (charts.revenueSourcesChart) charts.revenueSourcesChart.destroy();
            charts.revenueSourcesChart = new ApexCharts(document.querySelector("#revenueSourcesChart"), {
                series: [{ name: 'Revenue', data: [45000, 28000, 32000, 21000, 18000] }],
                chart: { type: 'bar', height: 250, toolbar: { show: false }, redrawOnWindowResize: true },
                xaxis: { categories: ['Cardiology', 'Orthopedics', 'Pediatrics', 'Neurology', 'Dermatology'] },
                colors: ['#10b981'], plotOptions: { bar: { borderRadius: 0, horizontal: true } }
            });
            charts.revenueSourcesChart.render();
        } catch(e) { console.warn('Revenue sources chart error:', e); }
    }
    
    chartsInitialized = true;
    return true;
}

function activateTab(tabId) {
    // Hide all tab panels
    tabs.forEach(t => {
        const panel = document.getElementById(`tab-${t}`);
        if (panel) panel.classList.add('hidden');
        
        const btn = document.querySelector(`.tab-btn[data-tab="${t}"]`);
        if (btn) {
            btn.setAttribute('data-state', t === tabId ? 'active' : 'inactive');
            if (t === tabId) {
                btn.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
                btn.classList.remove('text-gray-500');
            } else {
                btn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
                btn.classList.add('text-gray-500');
            }
        }
    });
    
    // Show selected tab panel
    const activePanel = document.getElementById(`tab-${tabId}`);
    if (activePanel) {
        activePanel.classList.remove('hidden');
        
        // Re-render charts when switching to overview or analytics tabs
        if (tabId === 'overview' || tabId === 'analytics') {
            chartsInitialized = false;
            setTimeout(() => {
                initCharts();
                window.dispatchEvent(new Event('resize'));
            }, 150);
        }
    }
}

// Initialize everything when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Set up tab click handlers
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const tabId = this.getAttribute('data-tab');
            if (tabId) activateTab(tabId);
        });
    });
    
    // Initialize charts (if online, they'll render; if offline, they'll skip gracefully)
    setTimeout(() => initCharts(), 100);
    
    // Activate overview tab by default
    activateTab('overview');
});

// Also handle case where DOMContentLoaded already fired
if (document.readyState === 'interactive' || document.readyState === 'complete') {
    setTimeout(() => {
        if (!document.querySelector('.tab-btn[data-tab="overview"]')?.classList.contains('bg-white')) {
            activateTab('overview');
        }
    }, 50);
}

// Refresh charts on sidebar toggle and fullscreen
function refreshAllCharts() {
    setTimeout(() => {
        window.dispatchEvent(new Event('resize'));
    }, 350);
}
document.querySelector('.lucide-menu')?.closest('button')?.addEventListener('click', refreshAllCharts);
    
</script>


    <script src="js/meditrack-security.js"></script>
    <script src="js/meditrack.js"></script>
    <script src="js/meditrack-realtime.js"></script>
    <script src="js/meditrack-language.js"></script>
    <script src="js/meditrack-flags.js"></script>
    <script src="js/meditrack-avatars.js"></script>
    <script src="js/meditrack-nav-confirm.js"></script>
    <script src="js/meditrack-store.js"></script>
    <script src="js/meditrack-apex-data.js"></script>
    <script src="js/meditrack-pagination.js"></script>
    <script src="js/meditrack-search.js"></script>
    <script src="js/meditrack-pdf.js"></script>
    <script src="js/clinical-sync.js"></script>
    <script src="js/meditrack-action-menu.js"></script>
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

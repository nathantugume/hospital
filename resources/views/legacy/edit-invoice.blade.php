<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Edit Invoice</title>
    <link rel="icon" type="image/png" href="favicon.png">

    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" crossorigin="anonymous"></script>
    <!-- <script src="https://cdn.tailwindcss.com" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="style.css">
    
    <style>

        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .rounded-lg.border,
        body.dark .modal-container, body.dark .popover-content, body.dark .radix-select-content { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700,
        body.dark .text-muted-foreground, body.dark label { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted, body.dark .bg-gray-50 { background-color: #262626 !important; }
        body.dark input, body.dark textarea, body.dark .radix-select-trigger { background-color: #262626 !important; border-color: #404040 !important; color: #e5e5e5 !important; }
        
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        .radix-select-trigger {
            display: flex; height: 2.5rem; width: 100%; align-items: center; justify-content: space-between;
            border-radius: 0.375rem; border: 1px solid #e5e7eb; background-color: #ffffff;
            padding: 0 0.75rem; font-size: 0.875rem; cursor: pointer;
        }
        .radix-select-content {
            position: absolute; z-index: 100; background: white; border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border: 1px solid #e5e7eb;
            margin-top: 4px; min-width: 100%; max-height: 200px; overflow-y: auto;
            animation: fadeInScale 0.12s ease-out;
        }
        .radix-select-item { padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer; transition: background 0.1s; }
        .radix-select-item:hover { background-color: #f3f4f6; }
        @keyframes fadeInScale { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        
        .popover-content {
            position: fixed; z-index: 100; background: white; border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border: 1px solid #e5e7eb;
            width: 320px; max-height: 400px; overflow: hidden; animation: fadeIn 0.15s ease-out;
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-4px); } to { opacity: 1; transform: translateY(0); } }
        
        .modal-overlay {
            position: fixed; inset: 0; background-color: rgb(0 0 0 / 87%); z-index: 1000;
            display: flex; align-items: center; justify-content: center; animation: fadeIn 0.2s ease-out;
        }
        .modal-container { background: white; border-radius: 0.75rem; width: 100%; max-width: 850px; max-height: 85vh; overflow-y: auto; padding: 1.5rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }
        body.dark .modal-container { background: #131212; }
        .modal-header { padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; background: white; }
        body.dark .modal-header { border-bottom-color: #404040; background: #131212; }
        .modal-title { font-size: 1.125rem; font-weight: 600; }
        .modal-close { background: transparent; border: none; font-size: 1.5rem; cursor: pointer; color: #6b7280; line-height: 1; padding: 0; width: 28px; height: 28px; border-radius: 0.375rem; }
        .modal-close:hover { color: #1f2937; background-color: #f3f4f6; }
        .modal-footer { padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 0.5rem; background: white; }
        body.dark .modal-footer { border-top-color: #404040; background: #131212; }
        
        .toast-message {
            position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white;
            padding: 12px 20px; border-radius: 8px; z-index: 1100; font-size: 0.875rem;
            animation: slideIn 0.3s ease-out;
        }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }
        
        .coverage-radio[data-checked="true"] { background-color: #6366f1 !important; border-color: #6366f1 !important; }
        .payment-checkbox[data-checked="true"] { background-color: #6366f1 !important; border-color: #6366f1 !important; }
        .payment-checkbox[data-checked="true"]::after { content: "✓"; color: white; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; }
        .coverage-radio[data-checked="true"]::after { content: ""; width: 6px; height: 6px; background: white; border-radius: 50%; display: block; margin: auto; }
        .flatpickr-calendar { z-index: 100 !important; }
    </style>
</head>
<body class="antialiased">

<body class="bg-gray-50 font-sans antialiased">

<div class="flex min-h-screen flex-col">
    <!-- Header -->
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
            <!-- Sidebar (Full Navigation with Accordions) -->
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
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="add-doctor.html">Add Doctor</a>
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="schedule.html">Doctor Schedule</a>
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="specialisation.html">Specializations</a>
                            </div>
                        </div>

                        <!-- Patients (active link, no accordion) -->
                        <div class="space-y-1 custom-scrollbar">
                            <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors bg-indigo-50 text-indigo-700" href="patients.html">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round mr-2 h-4 w-4"><circle cx="12" cy="8" r="5"></circle><path d="M20 21a8 8 0 0 0-16 0"></path></svg>
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
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="create-prescription.html">Create Prescription</a>
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="medicine-templates.html">Medicine Templates</a>
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
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="add-blood-unit.html">Add Blood Unit</a>
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="issue-blood.html">Issue Blood</a>
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
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="create-invoice.html">Create Invoice</a>
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
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="add-department.html">Add Department</a>
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="services.html"">Services Offered</a>
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
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="add-inventory.html">Add Item</a>
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="stock-alerts.html">Stock Alerts</a>
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="suppliers.html">Suppliers List</a>
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
<span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span>
                        <div class="space-y-0.5">
                            <p class="text-sm font-medium text-gray-800">Dr. Nakato Sarah</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                    </div>
                </div>
            </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-auto duration-300 p-4 xl:p-6 xl:ml-64 w-full">
<div class="flex flex-col space-y-4">
                <div class="flex items-center gap-4 flex-wrap">
                    <a href="billing.html" class="inline-flex items-center justify-center rounded-md border border-gray-300 shadow-sm bg-background hover:bg-accent hover:text-accent-foreground size-10">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                    </a>
                    <div><h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">Edit Invoice</h1><p class="text-gray-500">Update invoice details for patient billing.</p></div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-5">
                        <div class="rounded-lg border bg-background shadow-sm">
                            <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Invoice Details</h2><div class="text-gray-500">Update the invoice details.</div></div>
                            <div class="p-4 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="space-y-2"><label class="text-sm font-medium">Invoice Number</label><input id="invoiceNumber" class="h-10 w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-sm" readonly value="INV-008"></div>
                                    <div class="space-y-2"><label class="text-sm font-medium">Invoice Date</label><input id="invoiceDatePicker" class="h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm cursor-pointer"></div>
                                    <div class="space-y-2"><label class="text-sm font-medium">Due Date</label><input id="dueDatePicker" class="h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm cursor-pointer"></div>
                                </div>
                                
                                <div class="space-y-2">
                                    <label class="text-sm font-medium">Invoice Type</label>
                                    <div class="relative"><button id="invoiceTypeTrigger" class="radix-select-trigger w-full justify-between"><span id="invoiceTypeText">Standard Invoice</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
                                    <div id="invoiceTypeDropdown" class="radix-select-content hidden w-full"><div class="radix-select-item" data-value="Standard Invoice">Standard Invoice</div><div class="radix-select-item" data-value="Proforma Invoice">Proforma Invoice</div><div class="radix-select-item" data-value="Recurring Invoice">Recurring Invoice</div></div></div>
                                </div>
                                
                                <div class="space-y-2"><label class="text-sm font-medium">Reference / PO Number</label><input id="reference" class="h-10 w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Enter reference" value="PO-2024-0012"></div>
                                
                                <div class="border-t"></div>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between"><h3 class="text-lg font-medium">Items & Services</h3><button id="addItemBtn" class="inline-flex items-center gap-2 h-9 rounded-md bg-primary text-white hover:bg-primary/90 px-3 py-1.5 text-sm"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5v14"></path></svg>Add Item</button></div>
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-50 border-b">
                                                <th class="px-4 py-3 text-left w-10"></th><th class="px-4 py-3 text-left">Description</th><th class="px-4 py-3 text-right w-24">Quantity</th><th class="px-4 py-3 text-right w-28">Unit Price</th><th class="px-4 py-3 text-right w-28">Total</th><th class="px-4 py-3 text-center w-10"></th>
                                            </thead>
                                            <tbody id="itemsTableBody"></tbody>
                                        </table>
                                    </div>
                                    <div class="flex flex-col items-end space-y-2">
                                        <div class="flex justify-between w-64"><span class="font-medium">Subtotal:</span><span id="subtotal">$0.00</span></div>
                                        <div class="flex justify-between w-64"><span>Tax (<span id="taxRateDisplay">8</span>%):</span><span id="taxAmount">$0.00</span></div>
                                        <div class="flex justify-between w-64 font-bold"><span class="text-lg">Total:</span><span id="totalAmount" class="text-lg">$0.00</span></div>
                                    </div>
                                </div>
                                
                                <div class="border-t"></div>
                                <div class="space-y-4">
                                    <h3 class="text-lg font-medium">Additional Information</h3>
                                    <div class="space-y-2"><label class="text-sm font-medium">Notes</label><textarea id="notes" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Enter any additional notes">Follow-up appointment scheduled for next month. Thank you for choosing Medi-track.</textarea></div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium">Payment Terms</label>
                                        <div class="relative"><button id="paymentTermsTrigger" class="radix-select-trigger w-full justify-between"><span id="paymentTermsText">Net 30 Days</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg></button>
                                        <div id="paymentTermsDropdown" class="radix-select-content hidden w-full"><div class="radix-select-item" data-value="Net 15 Days">Net 15 Days</div><div class="radix-select-item" data-value="Net 30 Days">Net 30 Days</div><div class="radix-select-item" data-value="Due on Receipt">Due on Receipt</div></div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end gap-4"><button id="saveDraftBtn" class="border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 rounded-md text-sm">Save as Draft</button><button id="updateInvoiceBtn" class="bg-primary text-white hover:bg-primary/90 px-4 py-2 rounded-md text-sm">Update Invoice</button></div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="space-y-5">
                        <div class="rounded-lg border bg-background shadow-sm">
                            <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Patient Information</h2><div class="text-gray-500">Patient details for this invoice.</div></div>
                            <div class="p-4 space-y-4">
                                <button id="selectPatientBtn" class="flex w-full items-center justify-between rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 text-sm"><span>Search patients...</span><svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg></button>
                                <div id="selectedPatientCard" class="p-4 border rounded-md">
                                    <div class="flex items-center gap-3"><img id="patientAvatar" class="h-10 w-10 rounded-full object-cover" src="user.png" alt="User profile photo"><div><p id="patientName" class="font-medium">Okello David</p><p id="patientInfo" class="text-gray-500">45 • Male • ID: P12345</p></div></div>
                                    <div class="mt-3 space-y-1 text-sm"><p id="patientEmail">okello.david@hmail.com</p><p id="patientPhone">+256 712 345 678</p><p id="patientAddress" class="text-xs">Plot 14, Kampala Road, Kampala, Uganda</p></div>
                                    <button id="viewPatientDetails" class="text-indigo-600 text-sm mt-2 hover:underline">View patient details</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="rounded-lg border bg-background shadow-sm">
                            <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Insurance Information</h2></div>
                            <div class="p-4 space-y-4">
                                <div class="space-y-2"><div class="flex items-center justify-between"><label class="text-sm font-medium">Bill to Insurance</label><button id="insuranceToggle" class="switch relative inline-flex h-6 w-11 items-center rounded-full transition-colors bg-primary" role="switch" aria-checked="true"><span class="inline-block h-5 w-5 transform rounded-full bg-background transition-transform translate-x-5"></span></button></div>
                                <div id="insuranceDetails" class="p-4border rounded-md"><p class="font-medium">AAR Insurance</p><p class="text-sm">Policy #: BCBS123456789</p><p class="text-sm">Group #: GRP987654321</p><p class="text-sm">Coverage: PPO</p></div></div>
                                <div class="space-y-2"><label class="text-sm font-medium">Copay Amount</label><input id="copayAmount" type="number" step="0.01" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" value="25.00"></div>
                                <div class="space-y-2"><label class="text-sm font-medium">Coverage Verification</label><div class="space-y-1"><label class="flex items-center gap-2"><button type="button" role="radio" class="coverage-radio h-4 w-4 rounded-full border border-gray-400 flex items-center justify-center" data-value="verified" data-checked="true"></button><span class="text-sm">Verified</span></label><label class="flex items-center gap-2"><button type="button" role="radio" class="coverage-radio h-4 w-4 rounded-full border border-gray-400 flex items-center justify-center" data-value="pending"></button><span class="text-sm">Pending Verification</span></label><label class="flex items-center gap-2"><button type="button" role="radio" class="coverage-radio h-4 w-4 rounded-full border border-gray-400 flex items-center justify-center" data-value="not-covered"></button><span class="text-sm">Not Covered</span></label></div></div>
                            </div>
                        </div>
                        
                        <div class="rounded-lg border bg-background shadow-sm">
                            <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Payment Options</h2></div>
                            <div class="p-4 space-y-4">
                                <div><label class="text-sm font-medium block mb-3">Accepted Payment Methods</label><div class="grid grid-cols-2 gap-3"><label class="flex items-center gap-2"><button type="button" role="checkbox" class="payment-checkbox h-4 w-4 rounded-sm border border-gray-400 flex items-center justify-center" data-checked="true"></button><span class="text-sm">Credit Card</span></label><label class="flex items-center gap-2"><button type="button" role="checkbox" class="payment-checkbox h-4 w-4 rounded-sm border border-gray-400 flex items-center justify-center" data-checked="true"></button><span class="text-sm">Debit Card</span></label><label class="flex items-center gap-2"><button type="button" role="checkbox" class="payment-checkbox h-4 w-4 rounded-sm border border-gray-400 flex items-center justify-center" data-checked="true"></button><span class="text-sm">Cash</span></label><label class="flex items-center gap-2"><button type="button" role="checkbox" class="payment-checkbox h-4 w-4 rounded-sm border border-gray-400 flex items-center justify-center" data-checked="true"></button><span class="text-sm">Insurance</span></label></div></div>
                                <div class="flex items-center justify-between"><label class="text-sm font-medium">Offer Payment Plan</label><button id="paymentPlanToggle" class="switch relative inline-flex h-6 w-11 items-center rounded-full transition-colors bg-gray-300" role="switch" aria-checked="false"><span class="inline-block h-5 w-5 transform rounded-full bg-background transition-transform translate-x-0"></span></button></div>
                                <div class="flex justify-between gap-2"><button id="taxCalculatorBtn" class="border rounded-md px-3 py-1.5 text-sm flex items-center gap-1 h-10"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2"></rect><line x1="8" x2="16" y1="6" y2="6"></line><line x1="16" x2="16" y1="14" y2="18"></line></svg>Tax Calculator</button><button id="previewBtn" class="border rounded-md px-3 py-1.5 text-sm flex items-center gap-1 h-10"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg>Preview Invoice</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
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


<div id="patientSearchPopover" class="hidden popover-content"><div class="flex items-center border-b px-3"><svg class="mr-2 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg><input id="patientSearchInput" type="text" placeholder="Search patients..." class="flex-1 py-3 text-sm outline-none bg-transparent"></div><div id="patientSearchResults" class="max-h-64 overflow-y-auto p-1"></div></div>

<script>

    

// Sample data - pre-filled invoice
let currentTaxRate = 8;
const serviceOptions = [
    { id: 1, name: "General Consultation", price: 150 },
    { id: 2, name: "Blood Test - Basic Panel", price: 80 },
    { id: 3, name: "X-Ray - Chest", price: 200 },
    { id: 4, name: "MRI Scan", price: 500 },
    { id: 5, name: "Physical Therapy Session", price: 120 }
];
const patients = [
    { name: "Okello David", id: "P12345", age: 45, gender: "Male", email: "okello.david@hmail.com", phone: "+256 712 345 678", address: "Plot 14, Kampala Road, Kampala, Uganda", insurance: "AAR Insurance", policy: "BCBS123456789", group: "GRP987654321" },
    { name: "Nakato Mary", id: "P23456", age: 33, gender: "Female", email: "nakato.mary@hmail.com", phone: "+256 712 345 679", address: "Plot 12, Ntinda Roadnue, Nairobi, Kenya", insurance: "Jubilee Insurance", policy: "AET987654321", group: "GRP123456" }
];
let selectedPatient = patients[0];
let invoiceItems = [
    { id: 101, description: "General Consultation", qty: 1, unitPrice: 150, additionalDesc: "Initial consultation with Dr. Nakato Sarah" },
    { id: 102, description: "Blood Test - Basic Panel", qty: 1, unitPrice: 80, additionalDesc: "Complete blood count and metabolic panel" },
    { id: 103, description: "X-Ray - Chest", qty: 1, unitPrice: 200, additionalDesc: "Chest X-ray for respiratory evaluation" }
];
let activeModal = null;

// Format currency
function formatCurrency(amt) { return `$${amt.toFixed(2)}`; }
function closeModal() { if (activeModal) { activeModal.remove(); activeModal = null; } }
function showToast(msg, isError = false) { const toast = document.createElement('div'); toast.className = `toast-message ${isError ? 'error' : ''}`; toast.innerText = msg; document.body.appendChild(toast); setTimeout(() => toast.remove(), 3000); }

// Initialize date pickers with pre-filled dates
const today = new Date();
const dueDate = new Date(); dueDate.setDate(today.getDate() + 30);
flatpickr("#invoiceDatePicker", { dateFormat: "M d, Y", defaultDate: today });
flatpickr("#dueDatePicker", { dateFormat: "M d, Y", defaultDate: dueDate });
document.getElementById('invoiceDatePicker').value = today.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
document.getElementById('dueDatePicker').value = dueDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });

function calculateTotals() {
    const subtotal = invoiceItems.reduce((sum, item) => sum + (item.qty * item.unitPrice), 0);
    const tax = subtotal * (currentTaxRate / 100);
    const total = subtotal + tax;
    document.getElementById('subtotal').innerText = formatCurrency(subtotal);
    document.getElementById('taxAmount').innerText = formatCurrency(tax);
    document.getElementById('totalAmount').innerText = formatCurrency(total);
    document.getElementById('taxRateDisplay').innerText = currentTaxRate;
}

// Radix Select Helpers
function initRadixSelect(triggerId, dropdownId, textSpanId) {
    const trigger = document.getElementById(triggerId);
    const dropdown = document.getElementById(dropdownId);
    const textSpan = document.getElementById(textSpanId);
    if (!trigger || !dropdown || !textSpan) return;
    trigger.addEventListener('click', (e) => { e.stopPropagation(); dropdown.classList.toggle('hidden'); });
    dropdown.querySelectorAll('.radix-select-item').forEach(item => {
        item.addEventListener('click', () => { textSpan.innerText = item.dataset.value; dropdown.classList.add('hidden'); });
    });
    document.addEventListener('click', (e) => { if (!trigger.contains(e.target) && !dropdown.contains(e.target)) dropdown.classList.add('hidden'); });
}
initRadixSelect('invoiceTypeTrigger', 'invoiceTypeDropdown', 'invoiceTypeText');
initRadixSelect('paymentTermsTrigger', 'paymentTermsDropdown', 'paymentTermsText');

// Service dropdown for inline editing
function showServiceDropdown(button) {
    const existing = document.querySelector('.service-dropdown');
    if(existing) existing.remove();
    const dropdown = document.createElement('div');
    dropdown.className = 'radix-select-content service-dropdown';
    dropdown.innerHTML = serviceOptions.map(opt => `<div class="radix-select-item" data-name="${opt.name}" data-price="${opt.price}">${opt.name} - ${formatCurrency(opt.price)}</div>`).join('');
    const rect = button.getBoundingClientRect();
    dropdown.style.top = `${rect.bottom + 5}px`;
    dropdown.style.left = `${rect.left}px`;
    dropdown.style.position = 'fixed';
    dropdown.style.minWidth = `${rect.width}px`;
    document.body.appendChild(dropdown);
    dropdown.querySelectorAll('.radix-select-item').forEach(item => {
        item.addEventListener('click', (e) => {
            e.stopPropagation();
            const name = item.dataset.name;
            const price = parseFloat(item.dataset.price);
            const row = button.closest('tr');
            const rowId = row.querySelector('.delete-item')?.dataset.id;
            const itemObj = invoiceItems.find(i => i.id == rowId);
            if(itemObj) { itemObj.description = name; itemObj.unitPrice = price; renderItemsTable(); }
            dropdown.remove();
        });
    });
    const closeDropdown = (e) => { if(!dropdown.contains(e.target) && e.target !== button) { dropdown.remove(); document.removeEventListener('click', closeDropdown); } };
    setTimeout(() => document.addEventListener('click', closeDropdown), 10);
}

function renderItemsTable() {
    const tbody = document.getElementById('itemsTableBody');
    tbody.innerHTML = invoiceItems.map((item) => `
        <tr class="item-row border-b">
            <td class="px-4 py-3"><button type="button" class="item-checkbox h-4 w-4 rounded-sm border border-gray-400" data-id="${item.id}"></button></td>
            <td class="px-4 py-3">
                <div class="space-y-2">
                    <button class="service-select-btn w-full text-left border rounded-md px-3 py-1.5 text-sm bg-background  hover:bg-accent hover:text-accent-foreground h-10 flex justify-between items-center" data-id="${item.id}">
                        <span class="service-name">${item.description}</span>
                        <svg class="h-3 w-3 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                    </button>
                    <input type="text" class="item-additional-desc w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm placeholder:text-gray-400" placeholder="Additional description" value="${item.additionalDesc || ''}" data-id="${item.id}">
                </div>
            </td>
            <td class="px-4 py-3"><input type="number" value="${item.qty}" min="1" step="1" class="item-qty w-20 text-right border rounded px-2 py-1 text-sm" data-id="${item.id}"></td>
            <td class="px-4 py-3"><input type="number" value="${item.unitPrice}" min="0" step="0.01" class="item-price w-24 text-right border rounded px-2 py-1 text-sm" data-id="${item.id}"></td>
            <td class="px-4 py-3 text-right font-medium">${formatCurrency(item.qty * item.unitPrice)}</td>
            <td class="px-4 py-3 text-center"><button class="delete-item text-red-500 hover:text-red-700" data-id="${item.id}"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg></button></td>
        </tr>
    `).join('');
    calculateTotals();
    document.querySelectorAll('.service-select-btn').forEach(btn => btn.addEventListener('click', (e) => { e.stopPropagation(); showServiceDropdown(btn); }));
    document.querySelectorAll('.item-additional-desc').forEach(inp => inp.addEventListener('change', (e) => { const item = invoiceItems.find(i => i.id == e.target.dataset.id); if(item) item.additionalDesc = e.target.value; }));
    document.querySelectorAll('.item-qty').forEach(inp => inp.addEventListener('change', (e) => { const item = invoiceItems.find(i => i.id == e.target.dataset.id); if(item) { item.qty = parseInt(e.target.value) || 1; renderItemsTable(); } }));
    document.querySelectorAll('.item-price').forEach(inp => inp.addEventListener('change', (e) => { const item = invoiceItems.find(i => i.id == e.target.dataset.id); if(item) { item.unitPrice = parseFloat(e.target.value) || 0; renderItemsTable(); } }));
    document.querySelectorAll('.delete-item').forEach(btn => btn.addEventListener('click', (e) => { invoiceItems = invoiceItems.filter(i => i.id != btn.dataset.id); if(invoiceItems.length === 0) invoiceItems = [{ id: Date.now(), description: "New Service", qty: 1, unitPrice: 0, additionalDesc: "" }]; renderItemsTable(); }));
}

// Tax Calculator Modal
function showTaxCalculatorModal() {
    closeModal();
    const subtotal = invoiceItems.reduce((sum, item) => sum + (item.qty * item.unitPrice), 0);
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `<div class="modal-container" style="max-width: 500px;"><div class="modal-header"><h2 class="modal-title">Tax Calculator</h2><button class="modal-close">&times;</button></div><div class="modal-body"><div class="space-y-4"><div class="grid grid-cols-2 gap-4"><div><label class="text-sm font-medium">Subtotal</label><p class="text-lg font-semibold" id="calcSubtotal">${formatCurrency(subtotal)}</p></div><div><label class="text-sm font-medium">Tax Rate (%)</label><input type="number" id="taxRateInput" step="0.5" value="${currentTaxRate}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div></div><div class="grid grid-cols-2 gap-4"><div><label class="text-sm font-medium">Tax Amount</label><p class="text-lg font-semibold text-indigo-600" id="calcTaxAmount">${formatCurrency(subtotal * currentTaxRate / 100)}</p></div><div><label class="text-sm font-medium">Total with Tax</label><p class="text-lg font-semibold text-green-600" id="calcTotal">${formatCurrency(subtotal + subtotal * currentTaxRate / 100)}</p></div></div></div></div><div class="modal-footer"><button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm  hover:bg-accent hover:text-accent-foreground h-10">Close</button><button id="applyTaxBtn" class="inline-flex rounded-md bg-primary text-white px-4 py-2 text-sm hover:bg-primary/90">Apply Tax Rate</button></div></div>`;
    document.body.appendChild(modal);
    activeModal = modal;
    const taxRateInput = modal.querySelector('#taxRateInput');
    const calcTaxAmount = modal.querySelector('#calcTaxAmount');
    const calcTotal = modal.querySelector('#calcTotal');
    function updateCalc() { const rate = parseFloat(taxRateInput.value) || 0; const taxAmt = subtotal * (rate / 100); if(calcTaxAmount) calcTaxAmount.textContent = formatCurrency(taxAmt); if(calcTotal) calcTotal.textContent = formatCurrency(subtotal + taxAmt); }
    taxRateInput.addEventListener('input', updateCalc);
    modal.querySelector('.modal-close')?.addEventListener('click', closeModal);
    modal.querySelector('.cancel-modal')?.addEventListener('click', closeModal);
    modal.querySelector('#applyTaxBtn')?.addEventListener('click', () => { currentTaxRate = parseFloat(taxRateInput.value) || 0; calculateTotals(); showToast(`Tax rate updated to ${currentTaxRate}%`); closeModal(); });
}

// Preview Modal
function showPreviewModal() {
    closeModal();
    const subtotal = invoiceItems.reduce((sum, item) => sum + (item.qty * item.unitPrice), 0);
    const tax = subtotal * (currentTaxRate / 100);
    const total = subtotal + tax;
    const invoiceNumber = document.getElementById('invoiceNumber').value;
    const invoiceDate = document.getElementById('invoiceDatePicker').value;
    const dueDate = document.getElementById('dueDatePicker').value;
    const notes = document.getElementById('notes').value;
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `<div class="modal-container" style="max-width: 900px;"><div class="modal-header"><h2 class="modal-title">Invoice Preview</h2><button class="modal-close">&times;</button></div><div class="modal-body" id="previewContent"><div class="invoice-preview-content"><div class="invoice-header text-center mb-4"><h2 class="text-2xl font-bold">Medi-track Healthcare EA System</h2><p class="text-gray-500">Plot 14, Kampala Road, Kampala, Uganda | Tel: +256 712 345 678</p></div><div class="border-t my-4"></div><div class="grid grid-cols-2 gap-4 mb-4"><div><p class="text-xs text-gray-500">INVOICE TO</p><p class="font-semibold">${selectedPatient.name}</p><p class="text-sm">${selectedPatient.address}</p></div><div class="text-right"><p class="text-xs text-gray-500">INVOICE #</p><p class="font-semibold">${invoiceNumber}</p><p class="text-xs">Date: ${invoiceDate}</p><p class="text-xs">Due: ${dueDate}</p></div></div><table class="w-full text-sm mb-4"><thead><tr class="border-b"><th class="py-2 text-left">Description</th><th class="py-2 text-right">Qty</th><th class="py-2 text-right">Unit Price</th><th class="py-2 text-right">Amount</th></tr></thead><tbody>${invoiceItems.map(item => `<tr><td class="py-2">${item.description}${item.additionalDesc ? `<br><span class="text-xs text-gray-500">${item.additionalDesc}</span>` : ''}</td><td class="py-2 text-right">${item.qty}</td><td class="py-2 text-right">${formatCurrency(item.unitPrice)}</td><td class="py-2 text-right">${formatCurrency(item.qty * item.unitPrice)}</td></tr>`).join('')}</tbody><tfoot><tr><td colspan="3" class="py-2 text-right font-medium">Subtotal:</td><td class="py-2 text-right">${formatCurrency(subtotal)}</td></tr><tr><td colspan="3" class="py-2 text-right font-medium">Tax (${currentTaxRate}%):</td><td class="py-2 text-right">${formatCurrency(tax)}</td></tr><tr><td colspan="3" class="py-2 text-right font-bold">Total:</td><td class="py-2 text-right font-bold">${formatCurrency(total)}</td></tr></tfoot></table><div class="border-t my-4"></div><div><p class="text-xs text-gray-500">Notes</p><p class="text-sm">${notes || 'No additional notes'}</p></div></div></div><div class="modal-footer"><button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm  hover:bg-accent hover:text-accent-foreground h-10">Close</button><button id="downloadPdfBtn" class="inline-flex rounded-md bg-primary text-white px-4 py-2 text-sm hover:bg-primary/90">Download PDF</button></div></div>`;
    document.body.appendChild(modal);
    activeModal = modal;
    modal.querySelector('.modal-close')?.addEventListener('click', closeModal);
    modal.querySelector('.cancel-modal')?.addEventListener('click', closeModal);
    modal.querySelector('#downloadPdfBtn')?.addEventListener('click', () => { const element = document.getElementById('previewContent'); if(element) html2pdf().from(element).set({ margin: 0.5, filename: `Invoice_${invoiceNumber}_Preview.pdf` }).save().then(() => showToast('PDF downloaded!')); });
}

// Patient Search
const popover = document.getElementById('patientSearchPopover');
const searchInput = document.getElementById('patientSearchInput');
const resultsDiv = document.getElementById('patientSearchResults');
function renderPatientSearch(query) {
    const filtered = patients.filter(p => p.name.toLowerCase().includes(query.toLowerCase()));
    resultsDiv.innerHTML = filtered.map(p => `<div class="patient-result flex items-center gap-3 p-2 hover:bg-gray-100 rounded cursor-pointer" data-name="${p.name}" data-id="${p.id}" data-age="${p.age}" data-gender="${p.gender}" data-email="${p.email}" data-phone="${p.phone}" data-address="${p.address}" data-insurance="${p.insurance}" data-policy="${p.policy}" data-group="${p.group}"><img src="user.png" class="h-8 w-8 rounded-full object-cover" alt="User profile photo"><div><p class="text-sm font-medium">${p.name}</p><p class="text-xs text-gray-500">${p.age} • ${p.gender} • ID: ${p.id}</p></div></div>`).join('');
    document.querySelectorAll('.patient-result').forEach(el => el.addEventListener('click', () => { selectedPatient = { name: el.dataset.name, id: el.dataset.id, age: el.dataset.age, gender: el.dataset.gender, email: el.dataset.email, phone: el.dataset.phone, address: el.dataset.address, insurance: el.dataset.insurance, policy: el.dataset.policy, group: el.dataset.group }; updatePatientUI(); popover.classList.add('hidden'); showToast(`Patient changed to ${selectedPatient.name}`); }));
}
function updatePatientUI() {
    document.getElementById('patientName').innerText = selectedPatient.name;
    document.getElementById('patientInfo').innerText = `${selectedPatient.age} • ${selectedPatient.gender} • ID: ${selectedPatient.id}`;
    document.getElementById('patientEmail').innerText = selectedPatient.email;
    document.getElementById('patientPhone').innerText = selectedPatient.phone;
    document.getElementById('patientAddress').innerText = selectedPatient.address;
    document.getElementById('insuranceDetails').innerHTML = `<p class="font-medium">${selectedPatient.insurance}</p><p class="text-sm">Policy #: ${selectedPatient.policy}</p><p class="text-sm">Group #: ${selectedPatient.group}</p><p class="text-sm">Coverage: PPO</p>`;
}
document.getElementById('selectPatientBtn').addEventListener('click', (e) => { e.stopPropagation(); const rect = document.getElementById('selectPatientBtn').getBoundingClientRect(); popover.style.top = `${rect.bottom + 5}px`; popover.style.left = `${rect.left}px`; popover.classList.toggle('hidden'); renderPatientSearch(''); });
searchInput.addEventListener('input', (e) => renderPatientSearch(e.target.value));
document.addEventListener('click', (e) => { if (!document.getElementById('selectPatientBtn').contains(e.target) && !popover.contains(e.target)) popover.classList.add('hidden'); });
document.getElementById('viewPatientDetails')?.addEventListener('click', () => showToast(`Patient: ${selectedPatient.name}, ID: ${selectedPatient.id}`));

// Toggles
const insuranceToggle = document.getElementById('insuranceToggle');
insuranceToggle?.addEventListener('click', () => { const isChecked = insuranceToggle.getAttribute('aria-checked') === 'true'; insuranceToggle.setAttribute('aria-checked', !isChecked); insuranceToggle.classList.toggle('bg-primary', !isChecked); insuranceToggle.classList.toggle('bg-gray-300', isChecked); const span = insuranceToggle.querySelector('span'); span.classList.toggle('translate-x-5', !isChecked); showToast(`Insurance billing ${!isChecked ? 'enabled' : 'disabled'}`); });
const paymentPlanToggle = document.getElementById('paymentPlanToggle');
paymentPlanToggle?.addEventListener('click', () => { const isChecked = paymentPlanToggle.getAttribute('aria-checked') === 'true'; paymentPlanToggle.setAttribute('aria-checked', !isChecked); paymentPlanToggle.classList.toggle('bg-primary', !isChecked); paymentPlanToggle.classList.toggle('bg-gray-300', isChecked); const span = paymentPlanToggle.querySelector('span'); span.classList.toggle('translate-x-5', !isChecked); showToast(`Payment plan ${!isChecked ? 'offered' : 'removed'}`); });

// Coverage Radios
document.querySelectorAll('.coverage-radio').forEach(radio => radio.addEventListener('click', () => { document.querySelectorAll('.coverage-radio').forEach(r => { r.removeAttribute('data-checked'); r.classList.remove('bg-primary', 'border-indigo-600'); r.classList.add('border-gray-400'); }); radio.setAttribute('data-checked', 'true'); radio.classList.add('bg-primary', 'border-indigo-600'); radio.classList.remove('border-gray-400'); showToast(`Coverage status updated to ${radio.nextElementSibling?.innerText}`); }));
document.querySelector('.coverage-radio[data-value="verified"]')?.click();
document.querySelectorAll('.payment-checkbox').forEach(cb => { cb.addEventListener('click', () => { const isChecked = cb.getAttribute('data-checked') === 'true'; cb.setAttribute('data-checked', !isChecked); if(!isChecked) { cb.classList.add('bg-primary', 'border-indigo-600'); cb.classList.remove('border-gray-400'); } else { cb.classList.remove('bg-primary', 'border-indigo-600'); cb.classList.add('border-gray-400'); } }); if(cb.getAttribute('data-checked') === 'true') { cb.classList.add('bg-primary', 'border-indigo-600'); cb.classList.remove('border-gray-400'); } });

// Action Buttons
document.getElementById('addItemBtn')?.addEventListener('click', () => { invoiceItems.push({ id: Date.now(), description: "New Service", qty: 1, unitPrice: 0, additionalDesc: "" }); renderItemsTable(); });
document.getElementById('updateInvoiceBtn')?.addEventListener('click', () => showToast(`Invoice ${document.getElementById('invoiceNumber').value} updated successfully for ${selectedPatient.name}!`));
document.getElementById('saveDraftBtn')?.addEventListener('click', () => showToast('Invoice saved as draft'));
document.getElementById('previewBtn')?.addEventListener('click', showPreviewModal);
document.getElementById('taxCalculatorBtn')?.addEventListener('click', showTaxCalculatorModal);


renderItemsTable();
updatePatientUI();
</script>

    
    


    <script src="js/meditrack-security.js"></script>
    <script src="js/meditrack.js"></script>
    <script src="js/meditrack-realtime.js"></script>
    <script src="js/meditrack-language.js"></script>
    <script src="js/meditrack-flags.js"></script>
    <script src="js/meditrack-avatars.js"></script>
    <script src="js/meditrack-nav-confirm.js"></script>
    <script src="js/meditrack-store.js"></script>
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
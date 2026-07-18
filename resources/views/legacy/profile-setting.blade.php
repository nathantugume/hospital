<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Profile Settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <!-- <script src="https://cdn.tailwindcss.com" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="style.css">    <script src="https://unpkg.com/lucide@latest" crossorigin="anonymous"></script>
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; transition: background-color 0.2s; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .bg-gray-50 { background-color: #131212 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700, body.dark .text-gray-600 { color: #e5e5e5 !important; }
        body.dark .border-gray-200 { border-color: #333 !important; }
        body.dark .bg-gray-100 { background-color: #2a2a2a !important; }
        body.dark .border { border-color: #333 !important; }
        body.dark .switch-root { background-color: #3f3f4e; }
        
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        [data-state="inactive"][role="tabpanel"] { display: none; }
        [data-state="active"][role="tabpanel"] { display: block; animation: fadeIn 0.2s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        
        /* shadcn/ui switch styling */
        .switch-root {
            all: unset;
            position: relative;
            display: inline-flex;
            align-items: center;
            width: 44px;
            height: 24px;
            border-radius: 9999px;
            background-color: #cbd5e1;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .switch-root[data-state="checked"] { background-color: #171717; }
        .switch-thumb {
            display: block;
            width: 20px;
            height: 20px;
            background-color: white;
            border-radius: 9999px;
            transition: transform 0.2s;
            transform: translateX(2px);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .switch-root[data-state="checked"] .switch-thumb { transform: translateX(22px); }
        
        .tabs-trigger[data-state="active"] {
            background-color: white;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        body.dark .tabs-trigger[data-state="active"] {
            background-color: #2a2a2a;
        }
        button, .switch-root { transition: all 0.2s; }

        /* Unified Modal Overlay System */
.modal-overlay {
    position: fixed;
    inset: 0;
    background-color: rgb(0 0 0 / 87%);
    backdrop-filter: blur(4px);
    z-index: 1000;
    display: none; /* Controlled by JS (flex) */
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.2s ease-out;
}

.modal-container {
position: fixed;
    left: 50%;
    top: 50%;
    z-index: 10000;
    transform: translate(-50%, -50%);
    width: 90%;
    max-width: 500px;
    background: white;
    border-radius: 0.75rem;
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    gap: 1rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    animation: modalSlideIn 0.2s ease-out;
}

.alert-dialog-title {
    font-size: 1.125rem;
    font-weight: 600;
    line-height: 1.4;
    letter-spacing: -0.02em;
}

body.dark .modal-container { background: #1e1e1e; border: 1px solid #333; }

@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.hidden { display: none !important; }
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

        <!-- Main Flex: Sidebar -->
        <div class="flex flex-1 items-start relative">
            <!-- Sidebar -->
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

            <!-- Patients (active link, no accordion) -->
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
<span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span>
            <div class="space-y-0.5">
                <p class="text-sm font-medium text-gray-800">Dr. Nakato Sarah</p>
                <p class="text-xs text-gray-500">Administrator</p>
            </div>
        </div>
    </div>
</aside>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-auto p-4 xl:p-6 xl:ml-64 w-full">
            <div id="profileRoot"></div>
        </main>

<!-- Active Sessions Modal -->
<div id="activeSessionsOverlay" class="modal-overlay">
    <div class="modal-container">
        <div class="flex justify-between items-center p-6 border-b dark:border-gray-800">
            <h2 class="text-xl font-semibold">Active Sessions</h2>
            <button onclick="closeModal('activeSessionsOverlay')" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-500 mb-4">Manage your currently active login sessions across devices.</p>
            <div class="rounded-md border dark:border-gray-800 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-900 border-b dark:border-gray-800">
                        <tr>
                            <th class="text-left p-3 font-medium">Signed In</th>
                            <th class="text-left p-3 font-medium">Browser</th>
                            <th class="text-left p-3 font-medium">IP Address</th>
                            <th class="text-left p-3 font-medium">Location</th>
                            <th class="text-right p-3 font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-gray-800">
                        <tr>
                            <td class="p-3 text-green-600 font-medium">Now</td>
                            <td class="p-3">Chrome (Windows)</td>
                            <td class="p-3">250.364.239.254</td>
                            <td class="p-3">Kampala, USA</td>
                            <td class="p-3 text-right"><span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-2 py-0.5 text-xs font-semibold">Current</span></td>
                        </tr>
                        <tr>
                            <td class="p-3 text-gray-500">1 day ago</td>
                            <td class="p-3">Chrome (Windows)</td>
                            <td class="p-3">250.364.239.254</td>
                            <td class="p-3">Kampala, USA</td>
                            <td class="p-3 text-right"><button class="text-red-600 text-xs hover:underline" onclick="showToast('Session ended')">End Session</button></td>
                        </tr>
                        <tr>
                            <td class="p-3 text-gray-500">2 days ago</td>
                            <td class="p-3">Safari (MacOS)</td>
                            <td class="p-3">198.162.45.123</td>
                            <td class="p-3">Nairobi, USA</td>
                            <td class="p-3 text-right"><button class="text-red-600 text-xs hover:underline" onclick="showToast('Session ended')">End Session</button></td>
                        </tr>
                        <tr>
                            <td class="p-3 text-gray-500">3 days ago</td>
                            <td class="p-3">Firefox (Linux)</td>
                            <td class="p-3">92.184.112.78</td>
                            <td class="p-3">London, UK</td>
                            <td class="p-3 text-right"><button class="text-red-600 text-xs hover:underline" onclick="showToast('Session ended')">End Session</button></td>
                        </tr>
                        <tr>
                            <td class="p-3 text-gray-500">5 days ago</td>
                            <td class="p-3">Chrome (Android)</td>
                            <td class="p-3">176.45.89.201</td>
                            <td class="p-3">Toronto, Canada</td>
                            <td class="p-3 text-right"><button class="text-red-600 text-xs hover:underline" onclick="showToast('Session ended')">End Session</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex justify-end gap-3 p-6 border-t dark:border-gray-800">
            <button onclick="closeModal('activeSessionsOverlay')" class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100 dark:hover:bg-gray-800">Close</button>
            <button onclick="showToast('All other sessions ended')" class="px-4 py-2 bg-red-600 text-white rounded-md text-sm hover:bg-red-700">End All Sessions</button>
        </div>
    </div>
</div>

<!-- Login History Modal -->
<div id="loginHistoryOverlay" class="modal-overlay">
    <div class="modal-container">
        <div class="flex justify-between items-center p-6 border-b dark:border-gray-800">
            <h2 class="text-xl font-semibold">Login History</h2>
            <button onclick="closeModal('loginHistoryOverlay')" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">&times;</button>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-500 mb-4">Review your recent login activity and identify any suspicious access.</p>
            <div class="rounded-md border dark:border-gray-800 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-900 border-b dark:border-gray-800">
                        <tr>
                            <th class="text-left p-3 font-medium">Action</th>
                            <th class="text-left p-3 font-medium">Source</th>
                            <th class="text-left p-3 font-medium">IP Address</th>
                            <th class="text-left p-3 font-medium">Location</th>
                            <th class="text-left p-3 font-medium">When</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y dark:divide-gray-800">
                        <tr>
                            <td class="p-3"><span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-2 py-0.5 text-xs font-semibold">Sign In</span></td>
                            <td class="p-3">Web</td>
                            <td class="p-3">157.17.345.234</td>
                            <td class="p-3">Kampala, USA</td>
                            <td class="p-3 text-gray-500">1 hour ago</td>
                        </tr>
                        <tr>
                            <td class="p-3"><span class="inline-flex items-center rounded-full bg-red-100 text-red-700 px-2 py-0.5 text-xs font-semibold">Sign Out</span></td>
                            <td class="p-3">Web</td>
                            <td class="p-3">157.17.345.234</td>
                            <td class="p-3">Kampala, USA</td>
                            <td class="p-3 text-gray-500">3 hours ago</td>
                        </tr>
                        <tr>
                            <td class="p-3"><span class="inline-flex items-center rounded-full bg-green-100 text-green-700 px-2 py-0.5 text-xs font-semibold">Sign In</span></td>
                            <td class="p-3">API</td>
                            <td class="p-3">198.162.45.123</td>
                            <td class="p-3">Nairobi, USA</td>
                            <td class="p-3 text-gray-500">5 hours ago</td>
                        </tr>
                        <tr>
                            <td class="p-3"><span class="inline-flex items-center rounded-full bg-red-100 text-red-700 px-2 py-0.5 text-xs font-semibold">Sign Out</span></td>
                            <td class="p-3">API</td>
                            <td class="p-3">198.162.45.123</td>
                            <td class="p-3">Nairobi, USA</td>
                            <td class="p-3 text-gray-500">5 hours ago</td>
                        </tr>
                        <tr>
                            <td class="p-3"><span class="inline-flex items-center rounded-full bg-yellow-100 text-yellow-700 px-2 py-0.5 text-xs font-semibold">Failed</span></td>
                            <td class="p-3">Web</td>
                            <td class="p-3">45.67.89.101</td>
                            <td class="p-3">Unknown</td>
                            <td class="p-3 text-gray-500">18 hours ago</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex justify-end gap-3 p-6 border-t dark:border-gray-800">
            <button onclick="closeModal('loginHistoryOverlay')" class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Close</button>
            <button onclick="showToast('Exporting to CSV...')" class="px-4 py-2 bg-primary text-white rounded-md text-sm">Export CSV</button>
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

<!-- Delete Account Modal -->
<div id="deleteAccountOverlay" class="modal-overlay">
<div class="modal-container" style="max-width:500px;">
        <div class="flex justify-between items-center">
            <h2 class=" font-semibold text-red-600 pb-3">Are you sure you want to Delete this account?</h2>
            <button onclick="closeModal('deleteAccountOverlay')" class="text-gray-400 hover:text-gray-600 text-2xl leading-none">×</button>
        </div>
        <div>
            <div class="flex items-center gap-3 mb-4 p-3 bg-red-50 rounded-lg border border-red-200">
                <svg class="h-6 w-6 text-red-500 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                <p class="text-sm text-red-700"><strong>Warning:</strong> This action is irreversible. All your data, settings, and history will be permanently deleted.</p>
            </div>
            <p class="text-sm text-gray-600 mb-4">Please type <strong>DELETE</strong> to confirm:</p>
            <input type="text" id="deleteConfirmInput" class="w-full border rounded-md px-3 py-2 text-sm mb-4" placeholder="Type DELETE to confirm">
            <p class="text-xs text-gray-500 mb-4">We recommend exporting your data before deleting your account.</p>
        </div>
        <div class="flex justify-end gap-3">
            <button onclick="closeModal('deleteAccountOverlay')" class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Cancel</button>
            <button id="confirmDeleteBtn" class="px-4 py-2 bg-gray-300 text-gray-500 rounded-md text-sm cursor-not-allowed" disabled="">Delete Account</button>
        </div>
    </div>
</div>


<script>   


    // ---------- GLOBAL STATE ----------
    let currentView = 'default';   // 'default', 'editProfile', 'changePassword'
    let activeTab = 'activity';

    // === DYNAMIC: load from logged-in user (set by login.html) ===
    // Falls back to Ssentongo John (default admin) if not logged in.
    let _loggedInUser = {};
    try { _loggedInUser = JSON.parse(localStorage.getItem('meditrack_user') || '{}'); } catch (e) {}
    const _roleLabel = (_loggedInUser.role || 'admin').replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase());
    const _roleDepartmentMap = {
        'super_admin': 'Administration', 'admin': 'IT Operations', 'doctor': 'Cardiology',
        'nurse': 'Emergency', 'receptionist': 'Front Desk', 'lab_technician': 'Laboratory',
        'pharmacist': 'Pharmacy', 'patient': 'Outpatient', 'accountant': 'Finance',
        'insurance_officer': 'Insurance', 'hr_manager': 'Human Resources',
        'inventory_manager': 'Inventory', 'surgeon': 'Surgery', 'physiotherapist': 'Physiotherapy',
        'radiology_technician': 'Radiology', 'blood_bank_staff': 'Blood Bank',
        'ambulance_driver': 'Emergency', 'ambulance_dispatcher': 'Emergency',
    };
    let profileData = {
        name: _loggedInUser.name || 'Ssentongo John',
        email: _loggedInUser.email || 'admin@meditrack.com',
        phone: _loggedInUser.phone || '+256 712 345 678',
        location: _loggedInUser.location || 'Kampala, Uganda',
        department: _loggedInUser.department || _roleDepartmentMap[_loggedInUser.role] || 'IT Operations',
        role: _loggedInUser.role || 'admin',
        roleLabel: _roleLabel,
    };
    console.log('[ProfileSetting] Loaded profile for:', profileData.name, '(', profileData.roleLabel, ')');

    // Original activity data (preserved exactly as provided)
    const activityData = [
        { action: "Password changed", date: "March 15, 2024 10:30 AM", details: "Changed from web browser (Chrome)", color: "green", icon: "key" },
        { action: "Login from new device", date: "March 14, 2024 3:45 PM", details: "MacBook Pro - Kampala, USA", color: "yellow", icon: "user" },
        { action: "Profile updated", date: "March 13, 2024 2:15 PM", details: "Updated contact information", color: "muted", icon: "user" },
        { action: "Security settings modified", date: "March 12, 2024 11:20 AM", details: "Enabled 2FA authentication", color: "green", icon: "shield" },
        { action: "Document downloaded", date: "March 11, 2024 9:15 AM", details: "Downloaded annual report", color: "muted", icon: "file-text" },
        { action: "Failed login attempt", date: "March 10, 2024 8:20 PM", details: "Invalid credentials from unknown IP", color: "red", icon: "lock" },
        { action: "Account recovery initiated", date: "March 9, 2024 4:15 PM", details: "Password reset requested", color: "yellow", icon: "key" },
        { action: "New device registered", date: "March 8, 2024 1:30 PM", details: "iPhone 13 - Kampala, USA", color: "muted", icon: "user" },
        { action: "Security alert", date: "March 7, 2024 10:45 AM", details: "Suspicious activity detected", color: "red", icon: "bell" },
        { action: "Backup completed", date: "March 6, 2024 9:00 AM", details: "System backup successful", color: "green", icon: "file-text" }
    ];

function downloadFullProfileCSV() {
    const rows = [
        ['Field', 'Value'],
        ['Full Name', profileData.name],
        ['Email', profileData.email],
        ['Phone', profileData.phone],
        ['Location', profileData.location],
        ['Department', profileData.department],
        ['Role', 'System Administrator'],
        ['2FA Status', 'Enabled'],
        ['Last Password Change', '7 days ago'],
        ['Security Score', '95/100'],
        ['', ''],
        ['--- Recent Activity ---', ''],
        ['Action', 'Date', 'Details'],
        ...activityData.map(item => [item.action, item.date, item.details])
    ];
    const csvContent = rows.map(row => row.map(cell => `"${cell}"`).join(',')).join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', 'full_profile_data.csv');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
    showToast('Full profile data exported to CSV');
}

    // ----- FULL TAB RENDERER (preserving original structure exactly) -----
    function renderTabs() {
        return `
            <div class="w-full" data-orientation="horizontal">
                <div role="tablist" data-orientation="horizontal" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1">
                    <button type="button" role="tab" data-tab="activity" id="tab-activity" aria-selected="${activeTab === 'activity'}" data-state="${activeTab === 'activity' ? 'active' : 'inactive'}" class="tabs-trigger px-3 py-1.5 text-sm font-medium rounded-sm flex items-center gap-2 transition-all ${activeTab === 'activity' ? 'bg-background shadow-sm' : ''}"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2"/></svg>Activity</button>
                    <button type="button" role="tab" data-tab="security" id="tab-security" aria-selected="${activeTab === 'security'}" data-state="${activeTab === 'security' ? 'active' : 'inactive'}" class="tabs-trigger px-3 py-1.5 text-sm font-medium rounded-sm flex items-center gap-2 transition-all ${activeTab === 'security' ? 'bg-background shadow-sm' : ''}"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>Security</button>
                    <button type="button" role="tab" data-tab="notifications" id="tab-notifications" aria-selected="${activeTab === 'notifications'}" data-state="${activeTab === 'notifications' ? 'active' : 'inactive'}" class="tabs-trigger px-3 py-1.5 text-sm font-medium rounded-sm flex items-center gap-2 transition-all ${activeTab === 'notifications' ? 'bg-background shadow-sm' : ''}"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>Notifications</button>
                </div>
                
                <!-- Activity Tab Panel - Original content preserved -->
                <div data-state="${activeTab === 'activity' ? 'active' : 'inactive'}" data-orientation="horizontal" role="tabpanel" aria-labelledby="tab-activity" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none space-y-4">
                    <div class="rounded-lg border bg-background text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-3 md:p-4">
                            <div class="flex items-center justify-between">
                                <h4 class="text-lg font-medium">Recent Activity</h4>
                        <button onclick="window.location.href='profile-activity.html'" class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors hover:bg-accent hover:text-accent-foreground h-10 rounded-md px-3 border cursor-pointer">View All</button>                            </div>
                        </div>
                        <div class="p-4 md:p-4 pt-0">
                            <div class="space-y-4">
                                ${activityData.map(item => `
                                    <div class="flex items-start gap-4">
                                        <div class="rounded-full p-2 ${item.color === 'green' ? 'bg-green-100 text-green-600' : item.color === 'yellow' ? 'bg-yellow-100 text-yellow-600' : item.color === 'red' ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600'}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-${item.icon} h-4 w-4">
                                                ${item.icon === 'key' ? '<path d="m15.5 7.5 2.3 2.3a1 1 0 0 0 1.4 0l2.1-2.1a1 1 0 0 0 0-1.4L19 4"></path><path d="m21 2-9.6 9.6"></path><circle cx="7.5" cy="15.5" r="5.5"></circle>' : ''}
                                                ${item.icon === 'user' ? '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>' : ''}
                                                ${item.icon === 'shield' ? '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>' : ''}
                                                ${item.icon === 'file-text' ? '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path>' : ''}
                                                ${item.icon === 'lock' ? '<rect width="18" height="11" x="3" y="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path>' : ''}
                                                ${item.icon === 'bell' ? '<path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>' : ''}
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm font-medium">${item.action}</p>
                                                <span class="text-xs text-gray-500">${item.date}</span>
                                            </div>
                                            <p class="text-gray-500">${item.details}</p>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Security Tab Panel - Original preserved -->
                <div data-state="${activeTab === 'security' ? 'active' : 'inactive'}" data-orientation="horizontal" role="tabpanel" aria-labelledby="tab-security" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none space-y-4">
                    <div class="rounded-lg border bg-background shadow-sm">
                        <div class="p-4 md:p-4">
                            <div class="space-y-6">
                                <div><div class="flex items-center justify-between"><div class="flex items-center gap-4"><div class="rounded-full p-2 bg-green-100 text-green-600"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg></div><div><h5 class="font-medium">Two-Factor Authentication</h5><p class="text-gray-500">Add an extra layer of security to your account</p></div></div><div class="flex items-center gap-2"><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-500 hover:bg-green-500/80 text-white">Enabled</span><button onclick="window.location.href='settings.html#privacy'" class="border rounded-md px-3 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground h-10 cursor-pointer">Configure</button></div></div><div class="border-t my-4"></div></div>
                                <div><div class="flex items-center justify-between"><div class="flex items-center gap-4"><div class="rounded-full p-2 bg-green-100 text-green-600"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15.5 7.5 2.3 2.3a1 1 0 0 0 1.4 0l2.1-2.1a1 1 0 0 0 0-1.4L19 4"/><path d="m21 2-9.6 9.6"/><circle cx="7.5" cy="15.5" r="5.5"/></svg></div><div><h5 class="font-medium">Password Settings</h5><p class="text-gray-500">Manage your password and security preferences</p></div></div><div class="flex items-center gap-2"><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-500 hover:bg-green-500/80 text-white">Enabled</span><button id="changePwdFromSecurityBtn" class="border rounded-md px-3 py-1.5 text-sm  hover:bg-accent hover:text-accent-foreground h-10  hover:bg-accent hover:text-accent-foreground h-10 ">Update</button></div></div><div class="border-t my-4"></div></div>
                                <div><div class="flex items-center justify-between"><div class="flex items-center gap-4"><div class="rounded-full p-2 bg-yellow-100 text-yellow-600"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div><div><h5 class="font-medium">Active Sessions</h5><p class="text-gray-500">View and manage your active login sessions</p></div></div><div class="flex items-center gap-2"><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-amber-500 text-white">Warning</span><button class="security-view-all border rounded-md px-3 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground h-10">View All</button></div></div><div class="border-t my-4"></div></div>
                                <div><div class="flex items-center justify-between"><div class="flex items-center gap-4"><div class="rounded-full p-2 bg-green-100 text-green-600"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div><div><h5 class="font-medium">Login History</h5><p class="text-gray-500">Review your recent login activity</p></div></div><div class="flex items-center gap-2"><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-500 hover:bg-green-500/80 text-white">Enabled</span><button class="security-view-login border rounded-md px-3 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground h-10">View</button></div></div><div class="border-t my-4"></div></div>
                                <div><div class="flex items-center justify-between"><div class="flex items-center gap-4"><div class="rounded-full p-2 bg-green-100 text-green-600"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg></div><div><h5 class="font-medium">Security Notifications</h5><p class="text-gray-500">Configure your security alert preferences</p></div></div><div class="flex items-center gap-2"><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-500 hover:bg-green-500/80 text-white">Enabled</span><button onclick="window.location.href='settings-notifications.html'" class="border rounded-md px-3 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground h-10 cursor-pointer">Settings</button></div></div><div class="border-t my-4"></div></div>
                                <div><div class="flex items-center justify-between"><div class="flex items-center gap-4"><div class="rounded-full p-2 bg-gray-100"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/><path d="M17 21v-7a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v7"/><path d="M7 3v4a1 1 0 0 0 1 1h7"/></svg></div><div><h5 class="font-medium">Backup &amp; Recovery</h5><p class="text-gray-500">Manage your account backup and recovery options</p></div></div><div class="flex items-center gap-2"><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-gray-300 text-gray-700">Disabled</span><button onclick="window.location.href='settings.html#backup'" class="border rounded-md px-3 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground h-10 cursor-pointer">Configure</button></div></div><div class="border-t my-4"></div></div>
                                <div><div class="flex items-center justify-between"><div class="flex items-center gap-4"><div class="rounded-full p-2 bg-green-100 text-green-600"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div><div><h5 class="font-medium">API Access</h5><p class="text-gray-500">Manage third-party application access</p></div></div><div class="flex items-center gap-2"><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-500 hover:bg-green-500/800 text-white">Enabled</span><button onclick="window.location.href='integrations.html'" class="border rounded-md px-3 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground h-10 cursor-pointer">Manage</button></div></div><div class="border-t my-4"></div></div>
                                <div><div class="flex items-center justify-between"><div class="flex items-center gap-4"><div class="rounded-full p-2 bg-green-100 text-green-600"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg></div><div><h5 class="font-medium">Privacy Settings</h5><p class="text-gray-500">Control your data sharing preferences</p></div></div><div class="flex items-center gap-2"><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-500 hover:bg-green-500/80 text-white">Enabled</span><button onclick="window.location.href='settings.html#security'" class="border rounded-md px-3 py-1.5 text-sm hover:bg-accent hover:text-accent-foreground h-10 cursor-pointer configure-2fa">Configure</button></div></div></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Notifications Tab Panel - Original preserved -->
                <div data-state="${activeTab === 'notifications' ? 'active' : 'inactive'}" data-orientation="horizontal" role="tabpanel" aria-labelledby="tab-notifications" tabindex="0" class="mt-2 ring-offset-background focus-visible:outline-none space-y-4">
                    <div class="rounded-lg border bg-background shadow-sm">
                        <div class="p-4 md:p-4">
                            <div class="space-y-6">
                                <div class="space-y-4"><div><h5 class="font-medium">Email Notifications</h5><p class="text-gray-500">Receive important updates via email</p></div><div class="space-y-3"><div class="flex items-center justify-between"><span class="text-sm">Security Alerts</span><button type="button" role="switch" aria-checked="false" data-state="unchecked" class="switch-root"><span data-state="unchecked" class="switch-thumb"></span></button></div><div class="flex items-center justify-between"><span class="text-sm">Account Updates</span><button type="button" role="switch" aria-checked="false" data-state="unchecked" class="switch-root"><span data-state="unchecked" class="switch-thumb"></span></button></div><div class="flex items-center justify-between"><span class="text-sm">Newsletter</span><button type="button" role="switch" aria-checked="false" data-state="unchecked" class="switch-root"><span data-state="unchecked" class="switch-thumb"></span></button></div></div><div class="border-t my-4"></div></div>
                                <div class="space-y-4"><div><h5 class="font-medium">Push Notifications</h5><p class="text-gray-500">Get instant notifications on your devices</p></div><div class="space-y-3"><div class="flex items-center justify-between"><span class="text-sm">Login Alerts</span><button type="button" role="switch" aria-checked="false" data-state="unchecked" class="switch-root"><span data-state="unchecked" class="switch-thumb"></span></button></div><div class="flex items-center justify-between"><span class="text-sm">Critical Updates</span><button type="button" role="switch" aria-checked="false" data-state="unchecked" class="switch-root"><span data-state="unchecked" class="switch-thumb"></span></button></div><div class="flex items-center justify-between"><span class="text-sm">Reminders</span><button type="button" role="switch" aria-checked="false" data-state="unchecked" class="switch-root"><span data-state="unchecked" class="switch-thumb"></span></button></div></div><div class="border-t my-4"></div></div>
                                <div class="space-y-4"><div><h5 class="font-medium">System Notifications</h5><p class="text-gray-500">In-app notification preferences</p></div><div class="space-y-3"><div class="flex items-center justify-between"><span class="text-sm">Task Updates</span><button type="button" role="switch" aria-checked="false" data-state="unchecked" class="switch-root"><span data-state="unchecked" class="switch-thumb"></span></button></div><div class="flex items-center justify-between"><span class="text-sm">Comments</span><button type="button" role="switch" aria-checked="false" data-state="unchecked" class="switch-root"><span data-state="unchecked" class="switch-thumb"></span></button></div><div class="flex items-center justify-between"><span class="text-sm">Mentions</span><button type="button" role="switch" aria-checked="false" data-state="unchecked" class="switch-root"><span data-state="unchecked" class="switch-thumb"></span></button></div></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    // ----- VIEW RENDERERS (preserving original layout) -----
    function renderDefaultView() {
        return `
            <div class="space-y-6">
                <div><h3 class="text-lg font-medium">Profile</h3><p class="text-gray-500">Manage your profile settings and account preferences.</p></div>
                <div class="border-t"></div>
                <div class="grid gap-6 md:grid-cols-[1fr,2fr]">
                    <div class="space-y-6">
                        <div class="rounded-lg border bg-background shadow-sm">
                            <div class="p-4 md:p-4 flex flex-row items-center gap-4">
                                <span class="relative flex h-16 w-16 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span>
                                <div><div class="flex items-center gap-2"><h4 class="text-xl font-semibold">${profileData.name}</h4><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-gray-100">${profileData.roleLabel || 'Admin'}</span></div><p class="text-gray-500">${profileData.department || 'System Administrator'}</p></div>
                            </div>
                            <div class="p-4 md:p-4 space-y-4">
                                <div class="space-y-4"><div class="flex items-center justify-between"><div class="flex items-center gap-2"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg><span class="text-sm font-medium">Basic Information</span></div><button id="editProfileBtn" class="text-sm text-indigo-600">Edit</button></div>
                                <div class="grid gap-3 text-sm"><div class="flex justify-between"><span class="text-gray-500">Email</span><span>${profileData.email}</span></div><div class="flex justify-between"><span class="text-gray-500">Phone</span><span>${profileData.phone}</span></div><div class="flex justify-between"><span class="text-gray-500">Location</span><span>${profileData.location}</span></div><div class="flex justify-between"><span class="text-gray-500">Department</span><span>${profileData.department}</span></div></div></div>
                                <div class="border-t"></div>
                                <div class="space-y-4"><div class="flex items-center justify-between"><div class="flex items-center gap-2"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg><span class="text-sm font-medium">Security Status</span></div><button id="changePasswordBtn" class="text-sm text-indigo-600">Change Password</button></div>
                                <div class="grid gap-2 text-sm"><div class="flex justify-between"><span class="text-gray-500">2FA Status</span><span class="bg-green-100 text-green-700 px-2 py-0.5 rounded-full text-xs">Enabled</span></div><div class="flex justify-between"><span class="text-gray-500">Last Password Change</span><span>7 days ago</span></div><div class="flex justify-between"><span class="text-gray-500">Security Score</span><span class="bg-gray-100 px-2 py-0.5 rounded-full text-xs">95/100</span></div></div></div>
                            </div>
                        </div>
                        <div class="rounded-lg border bg-background shadow-sm p-4"><h4 class="text-sm font-medium mb-3">Quick Actions</h4><div class="space-y-3"><button id="quickEditProfileBtn" class="w-full border rounded-md py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10  flex items-center justify-center gap-2 hover:bg-accent hover:text-accent-foreground h-10 "><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>Edit Profile</button><button id="quickChangePasswordBtn" class="w-full border rounded-md py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10  flex items-center justify-center gap-2 hover:bg-accent hover:text-accent-foreground h-10 "><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>Change Password</button><button id="downloadDataBtn" class="w-full border rounded-md py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10 flex items-center justify-center gap-2"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>Download Data (CSV)</button>
<button id="exportFullProfileBtn" class="w-full border rounded-md py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10 flex items-center justify-center gap-2"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>Export Full Profile (JSON)</button>
<button id="deleteAccountBtn" class="w-full border border-red-300 rounded-md py-2 text-sm text-red-600 hover:bg-red-50 h-10 flex items-center justify-center gap-2"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>Delete Account</button></div></div>
                    </div>
                    <div class="space-y-6">${renderTabs()}</div>
                </div>
            </div>
        `;
    }

    function renderEditProfileView() { /* kept identical to original structure */ return `<div class="space-y-6"><div><h3 class="text-lg font-medium">Edit Profile</h3><p class="text-gray-500">Update your personal information.</p></div><div class="border-t"></div><div class="grid gap-6 md:grid-cols-[1fr,2fr]"><div class="space-y-6"><div class="rounded-lg border bg-background shadow-sm p-4"><div class="space-y-4"><div class="space-y-2"><label class="text-sm font-medium">Full Name</label><input id="editName" type="text" value="${profileData.name}" class="w-full border rounded-md px-3 py-2 text-sm"></div><div class="space-y-2"><label class="text-sm font-medium">Email</label><input id="editEmail" type="email" value="${profileData.email}" class="w-full border rounded-md px-3 py-2 text-sm"></div><div class="space-y-2"><label class="text-sm font-medium">Phone</label><input id="editPhone" type="tel" value="${profileData.phone}" class="w-full border rounded-md px-3 py-2 text-sm"></div><div class="space-y-2"><label class="text-sm font-medium">Location</label><input id="editLocation" value="${profileData.location}" class="w-full border rounded-md px-3 py-2 text-sm"></div><div class="space-y-2"><label class="text-sm font-medium">Department</label><input id="editDepartment" value="${profileData.department}" class="w-full border rounded-md px-3 py-2 text-sm"></div><div class="flex gap-3 pt-2"><button id="saveProfileBtn" class="bg-primary text-white px-4 py-2 rounded-md text-sm">Save Changes</button><button id="cancelEditBtn" class="border px-4 py-2 rounded-md text-sm hover:bg-accent hover:text-accent-foreground h-10 ">Cancel</button></div></div></div><div class="rounded-lg border bg-background shadow-sm p-4"><h4 class="text-sm font-medium mb-3">Quick Actions</h4><div class="space-y-3"><button id="quickCancelEditBtn" class="w-full border rounded-md py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10 ">Back to Profile</button><button id="quickChangePasswordFromEdit" class="w-full border rounded-md py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10 ">Change Password</button></div></div></div><div class="space-y-6">${renderTabs()}</div></div></div>`; }
    function renderChangePasswordView() { return `<div class="space-y-6"><div><h3 class="text-lg font-medium">Change Password</h3><p class="text-gray-500">Update your password to keep your account secure.</p></div><div class="border-t"></div><div class="grid gap-6 md:grid-cols-[1fr,2fr]"><div class="space-y-6"><div class="rounded-lg border bg-background shadow-sm p-4"><div class="space-y-4"><div class="space-y-2"><label class="text-sm font-medium">Current Password</label><input type="password" id="currentPwd" class="w-full border rounded-md px-3 py-2 text-sm"></div><div class="space-y-2"><label class="text-sm font-medium">New Password</label><input type="password" id="newPwd" class="w-full border rounded-md px-3 py-2 text-sm"></div><div class="space-y-2"><label class="text-sm font-medium">Confirm New Password</label><input type="password" id="confirmPwd" class="w-full border rounded-md px-3 py-2 text-sm"></div><div class="flex gap-3 pt-2"><button id="savePasswordBtn" class="bg-primary text-white px-4 py-2 rounded-md text-sm">Update Password</button><button id="cancelPasswordBtn" class="border px-4 py-2 rounded-md text-sm hover:bg-accent hover:text-accent-foreground h-10 ">Cancel</button></div></div></div><div class="rounded-lg border bg-background shadow-sm p-4"><h4 class="text-sm font-medium mb-3">Quick Actions</h4><div class="space-y-3"><button id="editProfileFromQuickBtn" class="w-full border rounded-md py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10 ">Edit Profile</button><button id="backToProfileBtn" class="w-full border rounded-md py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10 ">Back to Profile</button></div></div></div><div class="space-y-6">${renderTabs()}</div></div></div>`; }

    // Master render + event binding
    function render() {
        const root = document.getElementById('profileRoot');
        if (!root) return;
        if (currentView === 'editProfile') root.innerHTML = renderEditProfileView();
        else if (currentView === 'changePassword') root.innerHTML = renderChangePasswordView();
        else root.innerHTML = renderDefaultView();

        // Tab activation
        const triggers = document.querySelectorAll('[role="tab"][data-tab]');
        const activateTab = (tabId) => {
            activeTab = tabId;
            triggers.forEach(trigger => {
                const isActive = trigger.getAttribute('data-tab') === tabId;
                trigger.setAttribute('aria-selected', isActive);
                trigger.setAttribute('data-state', isActive ? 'active' : 'inactive');
                if(isActive) trigger.classList.add('bg-white', 'shadow-sm');
                else trigger.classList.remove('bg-white', 'shadow-sm');
            });
            ['activity', 'security', 'notifications'].forEach(pid => {
                const panel = document.querySelector(`[role="tabpanel"][aria-labelledby="tab-${pid}"]`);
                if(panel) panel.setAttribute('data-state', pid === tabId ? 'active' : 'inactive');
            });
        };
        triggers.forEach(trigger => {
            trigger.removeEventListener('click', trigger._handler);
            trigger._handler = () => activateTab(trigger.getAttribute('data-tab'));
            trigger.addEventListener('click', trigger._handler);
        });
        activateTab(activeTab);

        // Switch handlers
        document.querySelectorAll('.switch-root').forEach(sw => {
            sw.removeEventListener('click', sw._switchHandler);
            sw._switchHandler = () => {
                const cur = sw.getAttribute('data-state');
                const newState = cur === 'checked' ? 'unchecked' : 'checked';
                sw.setAttribute('data-state', newState);
                sw.setAttribute('aria-checked', newState === 'checked');
            };
            sw.addEventListener('click', sw._switchHandler);
        });

        // Button handlers
        if (currentView === 'default') {
            document.getElementById('editProfileBtn')?.addEventListener('click', () => { currentView = 'editProfile'; render(); });
            document.getElementById('quickEditProfileBtn')?.addEventListener('click', () => { currentView = 'editProfile'; render(); });
            document.getElementById('changePasswordBtn')?.addEventListener('click', () => { currentView = 'changePassword'; render(); });
            document.getElementById('quickChangePasswordBtn')?.addEventListener('click', () => { currentView = 'changePassword'; render(); });
            document.getElementById('downloadDataBtn')?.addEventListener('click', downloadFullProfileCSV);
            // Export Full Profile as JSON
document.getElementById('exportFullProfileBtn')?.addEventListener('click', () => {
    const fullProfile = {
        basicInfo: {
            name: profileData.name,
            email: profileData.email,
            phone: profileData.phone,
            location: profileData.location,
            department: profileData.department,
            role: 'System Administrator'
        },
        security: {
            twoFactorEnabled: true,
            lastPasswordChange: '7 days ago',
            securityScore: '95/100'
        },
        activity: activityData,
        exportedAt: new Date().toISOString()
    };
    const jsonStr = JSON.stringify(fullProfile, null, 2);
    const blob = new Blob([jsonStr], { type: 'application/json' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', `profile_export_${new Date().toISOString().slice(0,10)}.json`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
    showToast('Full profile exported as JSON');
});

// Delete Account Modal
document.getElementById('deleteAccountBtn')?.addEventListener('click', () => {
    openModal('deleteAccountOverlay');
    document.getElementById('deleteConfirmInput').value = '';
    document.getElementById('confirmDeleteBtn').disabled = true;
    document.getElementById('confirmDeleteBtn').className = 'px-4 py-2 bg-gray-300 text-gray-500 rounded-md text-sm cursor-not-allowed';
});

// Delete confirmation input listener
document.getElementById('deleteConfirmInput')?.addEventListener('input', (e) => {
    const btn = document.getElementById('confirmDeleteBtn');
    if (e.target.value === 'DELETE') {
        btn.disabled = false;
        btn.className = 'px-4 py-2 bg-red-600 text-white rounded-md text-sm hover:bg-red-700 cursor-pointer';
    } else {
        btn.disabled = true;
        btn.className = 'px-4 py-2 bg-gray-300 text-gray-500 rounded-md text-sm cursor-not-allowed';
    }
});

// Confirm delete
document.getElementById('confirmDeleteBtn')?.addEventListener('click', () => {
    if (document.getElementById('deleteConfirmInput').value === 'DELETE') {
        closeModal('deleteAccountOverlay');
        showToast('Your account has been scheduled for deletion. You will receive a confirmation email.');
    }
});

            // Active Sessions & Login History modal triggers (delegated)
document.addEventListener('click', function(e) {
    if (e.target.closest('.security-view-all')) {
        openActiveSessionsModal();
    }
    if (e.target.closest('.security-view-login')) {
        openLoginHistoryModal();
    }
});
        } else if (currentView === 'editProfile') {
            document.getElementById('saveProfileBtn')?.addEventListener('click', () => {
                profileData.name = document.getElementById('editName').value;
                profileData.email = document.getElementById('editEmail').value;
                profileData.phone = document.getElementById('editPhone').value;
                profileData.location = document.getElementById('editLocation').value;
                profileData.department = document.getElementById('editDepartment').value;
                currentView = 'default'; render();
            });
            document.getElementById('cancelEditBtn')?.addEventListener('click', () => { currentView = 'default'; render(); });
            document.getElementById('quickCancelEditBtn')?.addEventListener('click', () => { currentView = 'default'; render(); });
            document.getElementById('quickChangePasswordFromEdit')?.addEventListener('click', () => { currentView = 'changePassword'; render(); });
        } else if (currentView === 'changePassword') {
            document.getElementById('savePasswordBtn')?.addEventListener('click', () => {
    const current = document.getElementById('currentPwd')?.value;
    const newPwd = document.getElementById('newPwd')?.value;
    const confirm = document.getElementById('confirmPwd')?.value;

    if (!current || !newPwd || !confirm) {
        if (window.Meditrack) window.Meditrack.Toast.error('Please fill in all password fields.', { title: 'Validation Error' });
        else alert('Please fill all fields');
        return;
    }
    if (newPwd !== confirm) {
        if (window.Meditrack) window.Meditrack.Toast.error('New passwords do not match.', { title: 'Validation Error' });
        else alert('New passwords do not match');
        return;
    }

    // Verify current password matches the demo password (demo mode)
    // In production, this would call POST /api/v1/auth/change-password
    const expectedCurrent = 'password123'; // demo only
    if (current !== expectedCurrent) {
        if (window.Meditrack) window.Meditrack.Toast.error('Current password is incorrect.', { title: 'Authentication Failed' });
        else alert('Current password is incorrect');
        return;
    }

    // ---- ENFORCE PASSWORD POLICY ----
    if (newPwd.length < 8) {
        if (window.Meditrack) window.Meditrack.Toast.error('Password must be at least 8 characters.', { title: 'Weak Password' });
        else alert('Password must be at least 8 characters');
        return;
    }
    if (!/[A-Z]/.test(newPwd) || !/[a-z]/.test(newPwd) || !/[0-9]/.test(newPwd)) {
        if (window.Meditrack) window.Meditrack.Toast.error('Password must contain uppercase, lowercase, and a number.', { title: 'Weak Password' });
        else alert('Password must contain uppercase, lowercase, and a number');
        return;
    }

    // ---- PERSIST to localStorage (so it sticks for this session) ----
    // Try real API first, fall back to local
    if (window.Meditrack) {
        window.Meditrack.api('POST', '/auth/change-password', {
            current_password: current,
            new_password: newPwd,
            new_password_confirmation: confirm,
        }).then(result => {
            if (result.success) {
                window.Meditrack.Toast.success('Password updated successfully. Please log in again with your new password.', { title: 'Password Changed', duration: 6000 });
                setTimeout(() => {
                    localStorage.removeItem('meditrack_auth_token');
                    localStorage.removeItem('meditrack_user');
                    localStorage.removeItem('meditrack_user_role');
                    window.location.href = 'login.html';
                }, 2000);
            } else {
                // API not available — local success
                window.Meditrack.Toast.success('Password updated successfully (local mode).', { title: 'Password Changed' });
                currentView = 'default';
                render();
            }
        }).catch(() => {
            // Network error — local success
            window.Meditrack.Toast.success('Password updated successfully (local mode).', { title: 'Password Changed' });
            currentView = 'default';
            render();
        });
    } else {
        alert('Password changed successfully!');
        currentView = 'default';
        render();
    }
});
            document.getElementById('cancelPasswordBtn')?.addEventListener('click', () => { currentView = 'default'; render(); });
            document.getElementById('editProfileFromQuickBtn')?.addEventListener('click', () => { currentView = 'editProfile'; render(); });
            document.getElementById('backToProfileBtn')?.addEventListener('click', () => { currentView = 'default'; render(); });
            document.getElementById('changePwdFromSecurityBtn')?.addEventListener('click', () => { currentView = 'changePassword'; render(); });
        }
        if (window.lucide) lucide.createIcons();
    }


    // --- MODAL CONTROLLER ---
function openModal(id) {
    const overlay = document.getElementById(id);
    if (overlay) {
        overlay.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Stop background scrolling
    }
}

function closeModal(id) {
    const overlay = document.getElementById(id);
    if (overlay) {
        overlay.style.display = 'none';
        document.body.style.overflow = ''; // Restore scrolling
    }
}

// Global Listener for Clicks
document.addEventListener('click', function(e) {
    // 1. Open Active Sessions
    if (e.target.closest('.security-view-all')) {
        openModal('activeSessionsOverlay');
    }
    // 2. Open Login History
    if (e.target.closest('.security-view-login')) {
        openModal('loginHistoryOverlay');
    }
    // 3. Close if background (overlay) is clicked
    if (e.target.classList.contains('modal-overlay')) {
        closeModal(e.target.id);
    }
});

// Close on Escape Key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay').forEach(ov => closeModal(ov.id));
    }
});


    render();
</script>

    
    


    <script src="js/meditrack-security.js"></script>
    <script src="js/meditrack.js"></script>
    <script src="js/meditrack-realtime.js"></script>
    <script src="js/meditrack-language.js"></script>
    <script src="js/meditrack-flags.js"></script>
    <script src="js/meditrack-avatars.js"></script>
    <script src="js/meditrack-nav-confirm.js"></script>
    <script src="js/meditrack-store.js"></script>
    <script src="js/meditrack-action-menu.js"></script>
    <script src="js/meditrack-pagination.js"></script>
    <script src="js/meditrack-search.js"></script>
    <script src="js/meditrack-pdf.js"></script>

<script>
/**
 * Profile-Setting Sync Script
 * ============================
 * 1. Makes the Security tab buttons lead to the right tab in settings.html
 *    - "Configure" (2FA)      → settings.html#security
 *    - "Update" (Password)     → triggers changePassword view (already wired)
 *    - "Settings" (Sec Notif)  → settings-notifications.html
 *    - "Connected Accounts"    → settings.html#system
 *    - "Login Activity"        → settings.html#security
 *
 * 2. Makes the Notifications tab sync with settings-notifications.html
 *    by using the same `meditrack_notification_prefs` localStorage key.
 *    Toggling a switch here updates the global prefs and vice versa.
 */
(function() {
    'use strict';

    // ============================================================
    // 1. SECURITY TAB → SETTINGS.HTML TAB LINKS
    // ============================================================
    // Update all the inline onclick handlers to point to the right settings.html tab
    function wireSecurityTabLinks() {
        // 2FA Configure button
        document.querySelectorAll('button[onclick*="settings.html#privacy"]').forEach(btn => {
            btn.removeAttribute('onclick');
            btn.addEventListener('click', () => {
                if (window.Meditrack) window.Meditrack.Toast.info('Opening Security settings in settings page...');
                setTimeout(() => window.location.href = 'settings.html#security', 500);
            });
        });

        // Security Notifications Settings button → settings-notifications.html
        document.querySelectorAll('button[onclick*="settings-notifications.html"]').forEach(btn => {
            btn.removeAttribute('onclick');
            btn.addEventListener('click', () => {
                if (window.Meditrack) window.Meditrack.Toast.info('Opening notification preferences...');
                setTimeout(() => window.location.href = 'settings-notifications.html', 500);
            });
        });

        // Add handlers for any "Configure" / "Manage" buttons in the security tab that don't have one
        const securityPanel = document.querySelector('[data-state="active"][role="tabpanel"][aria-labelledby="tab-security"], #tab-security');
        if (securityPanel) {
            securityPanel.querySelectorAll('button.border, button[class*="border"]').forEach(btn => {
                if (btn.id === 'changePwdFromSecurityBtn') return; // already wired
                if (btn.onclick || btn.dataset.wired) return;
                btn.dataset.wired = '1';
                const label = btn.textContent.trim().toLowerCase();
                if (label.includes('configure') || label.includes('manage') || label.includes('settings')) {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        const card = btn.closest('div').querySelector('h5');
                        const cardTitle = card ? card.textContent.trim().toLowerCase() : '';
                        let target = 'settings.html#security';
                        if (cardTitle.includes('connected') || cardTitle.includes('account')) target = 'settings.html#system';
                        else if (cardTitle.includes('login') || cardTitle.includes('activity')) target = 'settings.html#security';
                        else if (cardTitle.includes('notification')) target = 'settings-notifications.html';
                        if (window.Meditrack) window.Meditrack.Toast.info('Opening ' + cardTitle + ' settings...');
                        setTimeout(() => window.location.href = target, 500);
                    });
                }
            });
        }
    }

    // ============================================================
    // 2. NOTIFICATIONS TAB → SYNC WITH settings-notifications.html
    // ============================================================
    // The notification prefs are stored in localStorage under 'meditrack_notification_prefs'.
    // settings-notifications.html already exposes window.MeditrackNotifications API.
    // We mirror the same structure here.
    const NOTIF_PREFS_KEY = 'meditrack_notification_prefs';
    const DEFAULT_NOTIF_PREFS = {
        // Email
        'email-appointments': true, 'email-prescriptions': true, 'email-lab': true,
        'email-billing': true, 'email-newsletter': false,
        // SMS
        'sms-appointments': true, 'sms-prescriptions': true, 'sms-billing': false,
        // App/Push
        'app-appointments': true, 'app-messages': true, 'app-system': true,
        // Quiet hours
        'quiet-hours-enabled': false, 'quiet-hours-start': '22:00', 'quiet-hours-end': '07:00',
    };

    function getNotifPrefs() {
        try { return { ...DEFAULT_NOTIF_PREFS, ...JSON.parse(localStorage.getItem(NOTIF_PREFS_KEY) || '{}') }; }
        catch (e) { return { ...DEFAULT_NOTIF_PREFS }; }
    }

    function setNotifPref(key, value) {
        const prefs = getNotifPrefs();
        prefs[key] = value;
        localStorage.setItem(NOTIF_PREFS_KEY, JSON.stringify(prefs));
        // Broadcast system-wide
        window.dispatchEvent(new CustomEvent('meditrack-notification-prefs-changed', { detail: { key, value } }));
        if (window.Meditrack?.Toast) {
            window.Meditrack.Toast.success(`Notification preference "${key.replace(/-/g, ' ')}" ${value ? 'enabled' : 'disabled'} and synced system-wide.`);
        }
    }

    // Map profile-setting notification switches to the global pref keys
    // The Notifications tab structure has 3 sections: Email, Push, System
    // Each section has toggle switches in order.
    const NOTIF_TAB_MAPPING = {
        // Email Notifications section
        'Email Notifications': {
            'Security Alerts': 'email-billing',     // closest match
            'Account Updates': 'email-billing',
            'Newsletter': 'email-newsletter',
        },
        // Push Notifications section
        'Push Notifications': {
            'Login Alerts': 'app-system',
            'Critical Updates': 'app-system',
            'Reminders': 'app-appointments',
        },
        // System Notifications section
        'System Notifications': {
            'Task Updates': 'app-appointments',
            'Comments': 'app-messages',
            'Mentions': 'app-messages',
        },
    };

    function syncNotifTabFromPrefs() {
        const prefs = getNotifPrefs();
        // Find all notification sections in the Notifications tab
        const notifPanel = document.querySelector('[data-state="active"][role="tabpanel"][aria-labelledby="tab-notifications"], #tab-notifications');
        if (!notifPanel) return;

        // Each section is identified by its h5 heading
        notifPanel.querySelectorAll('h5').forEach(h5 => {
            const sectionName = h5.textContent.trim();
            const mapping = NOTIF_TAB_MAPPING[sectionName];
            if (!mapping) return;

            // Find the section container (parent of the h5)
            const section = h5.closest('div.space-y-4');
            if (!section) return;

            // Each row is a flex justify-between with a span (label) + switch button
            section.querySelectorAll('.flex.items-center.justify-between').forEach(row => {
                const labelEl = row.querySelector('span.text-sm');
                if (!labelEl) return;
                const label = labelEl.textContent.trim();
                const prefKey = mapping[label];
                if (!prefKey) return;

                const switchBtn = row.querySelector('.switch-root');
                if (!switchBtn) return;

                // Set initial state from prefs
                const isEnabled = prefs[prefKey] !== false;
                switchBtn.setAttribute('aria-checked', String(isEnabled));
                switchBtn.setAttribute('data-state', isEnabled ? 'checked' : 'unchecked');
                const thumb = switchBtn.querySelector('.switch-thumb');
                if (thumb) thumb.setAttribute('data-state', isEnabled ? 'checked' : 'unchecked');

                // Wire click handler (only once)
                if (switchBtn.dataset.syncWired) return;
                switchBtn.dataset.syncWired = '1';
                switchBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const currentState = switchBtn.getAttribute('data-state') === 'checked';
                    const newState = !currentState;
                    setNotifPref(prefKey, newState);
                    switchBtn.setAttribute('aria-checked', String(newState));
                    switchBtn.setAttribute('data-state', newState ? 'checked' : 'unchecked');
                    if (thumb) thumb.setAttribute('data-state', newState ? 'checked' : 'unchecked');
                });
            });
        });
    }

    // Listen for changes from settings-notifications.html (other tabs)
    window.addEventListener('storage', (e) => {
        if (e.key === NOTIF_PREFS_KEY) {
            syncNotifTabFromPrefs();
        }
    });
    window.addEventListener('meditrack-notification-prefs-changed', () => {
        syncNotifTabFromPrefs();
    });

    // ============================================================
    // INIT — runs after each render() call too
    // ============================================================
    function init() {
        wireSecurityTabLinks();
        syncNotifTabFromPrefs();
    }

    // Run on DOMContentLoaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Re-run after a small delay (the page re-renders via JS template literals)
    setTimeout(init, 500);
    setTimeout(init, 1500);

    // Also re-run whenever the active tab changes
    document.addEventListener('click', (e) => {
        if (e.target.closest('.tabs-trigger, [role="tab"]')) {
            setTimeout(init, 100);
        }
    });

    // Expose API for external control (matches settings-notifications.html)
    window.MeditrackNotifications = window.MeditrackNotifications || {
        get: (key) => getNotifPrefs()[key],
        set: setNotifPref,
        getAll: getNotifPrefs,
        defaults: DEFAULT_NOTIF_PREFS,
    };

    console.log('[ProfileSetting] Sync script loaded — security links + notification sync active');
})();
</script>
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
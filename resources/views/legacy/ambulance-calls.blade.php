<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Ambulance Call Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <style>

        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .rounded-lg.border { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted { background-color: #262626 !important; }
        body.dark input, body.dark textarea, body.dark .radix-select { background-color: #262626 !important; border-color: #404040 !important; color: #e5e5e5 !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        .radix-select {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 0.375rem;
            border: 1px solid #e2e8f0;
            background-color: white;
            padding: 0.375rem 2rem 0.375rem 0.75rem;
            font-size: 0.875rem;
            cursor: pointer;
            width: 100%;
        }
        body.dark .radix-select { background-color: #262626; border-color: #404040; color: #e5e5e5; }
        .select-chevron { position: absolute; right: 0.5rem; pointer-events: none; top: 50%; transform: translateY(-50%); }
        .radix-dropdown-menu {
            position: fixed;
            z-index: 100;
            min-width: 8rem;
            overflow: hidden;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
            background-color: white;
            padding: 0.25rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        body.dark .radix-dropdown-menu { background-color: #2a2a2a; border-color: #404040; }
        .radix-menu-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            border-radius: 0.25rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            transition: background-color 0.1s;
        }
        .radix-menu-item:hover { background-color: #f1f5f9; }
        body.dark .radix-menu-item:hover { background-color: #3f3f46; }
        .radix-separator { height: 1px; background: #e2e8f0; margin: 0.25rem 0; }
        body.dark .radix-separator { background: #404040; }
        
        .modal-backdrop {
            position: fixed; inset: 0; background-color: rgb(0 0 0 / 87%); backdrop-filter: blur(4px);
            z-index: 1000; display: flex; align-items: center; justify-content: center;
        }
        .modal-content { background: white; border-radius: 0.5rem; max-width: 550px; width: 90%; animation: fadeIn 0.2s ease; }
        body.dark .modal-content { background: #131212; border-color: #333; }
        .modal-backdrop.hidden { display: none; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-4px); } to { opacity: 1; transform: translateY(0); } }
        
        .toast-message {
            position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white;
            padding: 12px 20px; border-radius: 8px; z-index: 1100; font-size: 0.875rem;
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }
        
        .size-8 { width: 2rem; height: 2rem; }
        .text-muted-foreground { color: #6b7280; }
        body.dark .text-muted-foreground { color: #9ca3af; }


body.dark .action-menu {
    background: #2a2a2a;
    border-color: #404040;
}
.action-menu-header {
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 0.25rem;
}
body.dark .action-menu-header {
    color: #9ca3af;
    border-bottom-color: #404040;
}
.action-item {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    border-radius: 0.25rem;
    transition: background 0.1s;
    width: 100%;
    background: transparent;
    border: none;
    text-align: left;
}
.action-item:hover {
    background-color: #f3f4f6;
}
body.dark .action-item:hover {
    background-color: #3f3f46;
}
.action-divider {
    height: 1px;
    background-color: #e5e7eb;
    margin: 0.25rem 0;
}
body.dark .action-divider {
    background-color: #404040;
}
.text-red-600 { color: #dc2626; }

/* Action Menu Styles - Matching Test Requests page */
.action-menu {
    position: fixed;
    z-index: 10000;
    min-width: 200px;
    background: white;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    padding: 0.25rem;
    animation: fadeInScale 0.12s ease-out;
}
body.dark .action-menu {
    background: #2a2a2a;
    border-color: #404040;
}
.action-menu-header {
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 0.25rem;
}
body.dark .action-menu-header {
    color: #9ca3af;
    border-bottom-color: #404040;
}
.action-item {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    border-radius: 0.25rem;
    transition: background 0.1s;
    width: 100%;
    background: transparent;
    border: none;
    text-align: left;
    color: inherit;
}
.action-item:hover {
    background-color: #f3f4f6;
}
body.dark .action-item:hover {
    background-color: #3f3f46;
}
.action-divider {
    height: 1px;
    background-color: #e5e7eb;
    margin: 0.25rem 0;
}
body.dark .action-divider {
    background-color: #404040;
}
.text-amber-600 { color: #d97706; }
.text-amber-600:hover { background-color: #fef3c7; }
.text-red-600 { color: #dc2626; }
.text-red-600:hover { background-color: #fee2e2; }

@keyframes fadeInScale {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

/* Delete Modal Styles */
#deleteModalOverlay {
    position: fixed;
    inset: 0;
    z-index: 10001;
    background: rgb(0 0 0 / 87%);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
}

#deleteModalOverlay.modal-hidden {
    display: none !important;
}

#deleteModal {
    position: fixed;
    left: 50%;
    top: 50%;
    z-index: 10002;
    transform: translate(-50%, -50%);
    width: 90%;
    max-width: 500px;
    background: #ffffff;
    border-radius: 0.75rem;
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

#deleteModal.modal-hidden {
    display: none !important;
}

body.dark #deleteModal {
    background: #1a1a1a;
    border-color: #333333;
}

#deleteModal .delete-warning-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: #fee2e2;
    margin-bottom: 0.5rem;
}

body.dark #deleteModal .delete-warning-icon {
    background: #7f1d1d;
}


    </style>
</head>
<body class="bg-gray-50 antialiased">

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
<span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span>
            <div class="space-y-0.5">
                <p class="text-sm font-medium text-gray-800">Dr. Nakato Sarah</p>
                <p class="text-xs text-gray-500">Administrator</p>
            </div>
        </div>
    </div>
</aside>

        <main class="flex-1 overflow-auto p-4 xl:p-6 xl:ml-64 w-full"> 
            <div class="flex flex-col gap-4">
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div><h1 class="text-2xl font-bold tracking-tight mb-2">Ambulance Call List</h1><p class="text-muted-foreground text-gray-500">Manage and track all ambulance calls and dispatches</p></div>
                    <div class="flex items-center gap-2">
    <button id="newCallBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-white hover:bg-indigo-700 size-10" title="Quick Add Ambulance Call"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg></button>
    <a href="add-ambulance-call.html" class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium bg-primary text-white hover:bg-indigo-700 h-10 px-4 py-2">Add Ambulance Call</a>
</div>
                </div>

                <!-- Stats Cards with icons - Enhanced design like the example -->
                <div class="grid gap-4 md:grid-cols-3" id="statsContainer">
                    <!-- Stats will be dynamically updated but with icon layout -->
                </div>

                <!-- Calls Management Panel -->
                <div class="rounded-lg border bg-background shadow-sm">
                    <div class="flex flex-col space-y-1.5 p-4 border-b"><h2 class="text-xl font-semibold">Ambulance Calls</h2><div class="text-gray-500">View and manage all ambulance calls and dispatches</div></div>
                    <div class="p-4">
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                <div class="flex w-full items-center gap-2 md:w-auto relative"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4 text-gray-400 absolute left-3"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg><input type="text" id="searchInput" placeholder="Search calls (ID, patient, location)..." class="h-10 rounded-md border border-gray-300 bg-background px-3 py-2 text-sm pl-8 w-full md:w-[250px] focus:ring-2 focus:ring-indigo-500 focus:outline-none"></div>
                                <div class="flex flex-col gap-2 md:flex-row md:items-center">
                                    <div class="relative w-full md:w-[160px]"><button id="statusSelectTrigger" class="radix-select w-full justify-between"><span id="statusSelectedText">All Statuses</span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="select-chevron"><polyline points="6 9 12 15 18 9"></polyline></svg></button><div id="statusDropdown" class="radix-dropdown-menu hidden w-[160px]"><div class="radix-menu-item" data-status="all">All Statuses</div><div class="radix-menu-item" data-status="Pending">Pending</div><div class="radix-menu-item" data-status="In Progress">In Progress</div><div class="radix-menu-item" data-status="Completed">Completed</div></div></div>
                                    <div class="relative w-full md:w-[180px]"><button id="dateSelectTrigger" class="radix-select w-full justify-between"><span id="dateSelectedText">All Time</span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="select-chevron"><polyline points="6 9 12 15 18 9"></polyline></svg></button><div id="dateDropdown" class="radix-dropdown-menu hidden w-[180px]"><div class="radix-menu-item" data-date="all">All Time</div><div class="radix-menu-item" data-date="today">Today</div><div class="radix-menu-item" data-date="week">This Week</div><div class="radix-menu-item" data-date="month">This Month</div></div></div>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-1 border-b pb-2">
                                <button data-tab="all" class="status-tab px-3 py-1.5 text-sm font-medium rounded-md bg-indigo-50 text-indigo-700 transition-all">All</button>
                                <button data-tab="Pending" class="status-tab px-3 py-1.5 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-100">Pending</button>
                                <button data-tab="In Progress" class="status-tab px-3 py-1.5 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-100">In Progress</button>
                                <button data-tab="Completed" class="status-tab px-3 py-1.5 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-100">Completed</button>
                            </div>
                            <div class="rounded-md border overflow-x-auto"><table class="w-full caption-bottom text-sm">
<thead class="[&_tr]:border-b bg-gray-50">
    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Call ID</th>
    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Date & Time</th>
    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Patient</th>
    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500 hidden md:table-cell">Location</th>
    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Reason</th>
    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500">Status</th>
    <th class="h-12 px-4 text-left align-middle font-medium text-gray-500 hidden lg:table-cell">Ambulance</th>
    <th class="h-12 px-4 text-right align-middle font-medium text-gray-500">Actions</th>
</thead>                                <tbody id="callsTableBody"></tbody></table></div>
                            <div id="noResultsMsg" class="text-center py-8 text-gray-500 hidden">No ambulance calls match your filters.</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="newCallModal" class="modal-backdrop hidden"><div class="modal-content p-6"><div class="flex justify-between items-center mb-4"><h2 class="text-xl font-semibold">New Ambulance Call</h2><button id="closeModalBtn" class="text-gray-500 text-2xl hover:text-gray-700">&times;</button></div><div class="space-y-4"><div class="grid grid-cols-2 gap-4"><div><label class="text-sm font-medium">Patient Name <span class="text-red-500">*</span></label><input id="patientName" class="w-full mt-1 rounded-md border border-gray-300 px-3 py-2 text-sm"></div><div><label class="text-sm font-medium">Phone Number</label><input id="phoneNumber" class="w-full mt-1 rounded-md border border-gray-300 px-3 py-2 text-sm"></div></div><div><label class="text-sm font-medium">Location <span class="text-red-500">*</span></label><input id="locationInput" class="w-full mt-1 rounded-md border border-gray-300 px-3 py-2 text-sm"></div><div class="grid grid-cols-2 gap-4"><div><label class="text-sm font-medium">Reason</label><div class="relative mt-1"><button id="reasonBtn" class="radix-select w-full justify-between"><span id="reasonSelected">Select reason</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg></button><div id="reasonDropdown" class="radix-dropdown-menu hidden w-full"><div data-reason="Chest Pain" class="radix-menu-item">Chest Pain</div><div data-reason="Traffic Accident" class="radix-menu-item">Traffic Accident</div><div data-reason="Difficulty Breathing" class="radix-menu-item">Difficulty Breathing</div><div data-reason="Fall Injury" class="radix-menu-item">Fall Injury</div><div data-reason="Stroke Symptoms" class="radix-menu-item">Stroke Symptoms</div><div data-reason="Cardiac Arrest" class="radix-menu-item">Cardiac Arrest</div><div data-reason="Seizure" class="radix-menu-item">Seizure</div><div data-reason="Other" class="radix-menu-item">Other</div></div></div></div><div><label class="text-sm font-medium">Assign Ambulance</label><div class="relative mt-1"><button id="ambulanceBtn" class="radix-select w-full justify-between"><span id="ambulanceSelected">Select ambulance</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg></button><div id="ambulanceDropdown" class="radix-dropdown-menu hidden w-full"><div data-ambulance="AMB-001" class="radix-menu-item">AMB-001 (Driver: Kimera John)</div><div data-ambulance="AMB-002" class="radix-menu-item">AMB-002 (Driver: Wanjiru Sarah)</div><div data-ambulance="AMB-003" class="radix-menu-item">AMB-003 (Driver: Byaruhanga Robert)</div><div data-ambulance="AMB-004" class="radix-menu-item">AMB-004 (Driver: Tumusiime Thomas)</div><div data-ambulance="AMB-005" class="radix-menu-item">AMB-005 (Driver: Atim Linda)</div></div></div></div></div><div><label class="text-sm font-medium">Notes</label><textarea id="callNotes" rows="2" class="w-full mt-1 rounded-md border border-gray-300 px-3 py-2 text-sm"></textarea></div><div class="flex justify-end gap-3 pt-4"><button id="cancelModalBtn" class="px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100 text-sm font-medium">Cancel</button><button id="saveCallBtn" class="px-4 py-2 rounded-md bg-primary text-white hover:bg-indigo-700 text-sm font-medium">Create Call</button></div></div></div></div>

    

<!-- Delete Confirmation Modal -->
<div id="deleteModalOverlay" class="modal-hidden"></div>
<div id="deleteModal" role="alertdialog" class="modal-hidden" style="position:fixed;left:50%;top:50%;z-index:10002;transform:translate(-50%,-50%);width:90%;max-width:500px;background:#ffffff;border-radius:0.75rem;border:1px solid #e5e7eb;padding:1.5rem;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);display:flex;flex-direction:column;gap:1rem;">
    <div>
        <div class="delete-warning-icon" style="display:flex;align-items:center;justify-content:center;width:48px;height:48px;border-radius:50%;background:#fee2e2;margin-bottom:0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" x2="12" y1="8" y2="12"></line>
                <line x1="12" x2="12.01" y1="16" y2="16"></line>
            </svg>
        </div>
        <h2 id="deleteModalTitle" style="font-size:1.125rem;font-weight:600;color:#111827;margin-bottom:0.5rem;">Are you sure you want to delete this call?</h2>
        <p id="deleteModalDesc" style="font-size:0.875rem;color:#6b7280;line-height:1.5;">
            This action is irreversible. The ambulance call record for <span id="deleteCallId" style="font-weight:500;color:#374151;">AC001</span> will be permanently removed from the system.
        </p>
    </div>
    <div style="display:flex;justify-content:flex-end;gap:0.75rem;">
        <button type="button" id="deleteModalCloseBtn" style="display:inline-flex;align-items:center;justify-content:center;border-radius:0.5rem;border:1px solid #d1d5db;background:#ffffff;padding:0.5rem 1rem;font-size:0.875rem;font-weight:500;color:#374151;cursor:pointer;height:2.5rem;">Keep Call</button>
        <button type="button" id="confirmDeleteBtn" style="display:inline-flex;align-items:center;justify-content:center;border-radius:0.5rem;border:none;background:#dc2626;padding:0.5rem 1rem;font-size:0.875rem;font-weight:500;color:#ffffff;cursor:pointer;height:2.5rem;">Delete Call</button>
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
                

        let callsData = [
            { id: "AC001", dateTime: "2025-04-22T08:30", patient: "Ssentongo John", phone: "+256 712 345 678", location: "Plot 14, Kampala Road, Kampala", reason: "Chest Pain", status: "Completed", ambulanceId: "AMB-001", driver: "Kimera John", notes: "" },
            { id: "AC002", dateTime: "2025-04-22T09:45", patient: "Nabukenya Jane", phone: "+1 +256 712 987 654", location: "Plot 12, Ntinda Road, Kampala", reason: "Traffic Accident", status: "In Progress", ambulanceId: "AMB-003", driver: "Byaruhanga Robert", notes: "" },
            { id: "AC003", dateTime: "2025-04-22T11:15", patient: "Emily Johnson", phone: "+256 712 345 681", location: "Plot 23, Kololo Hill Drive, Kampala", reason: "Difficulty Breathing", status: "Pending", ambulanceId: "AMB-002", driver: "Wanjiru Sarah", notes: "" },
            { id: "AC004", dateTime: "2025-04-21T14:30", patient: "David Brown", phone: "+256 712 345 679", location: "321 Elm St, Nowhere", reason: "Fall Injury", status: "Completed", ambulanceId: "AMB-001", driver: "Kimera John", notes: "" },
        ];
        
        let currentFilters = { search: '', status: 'all', dateRange: 'all', tab: 'all' };
        
        function formatDateTime(isoString) { const d = new Date(isoString); return `${d.toLocaleDateString()}<br><span class="text-xs text-gray-400">${d.toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'})}</span>`; }
        function getStatusBadge(status) { if(status === 'Completed') return '<span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-800">Completed</span>'; if(status === 'In Progress') return '<span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-semibold text-blue-800">In Progress</span>'; return '<span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-semibold text-yellow-800">Pending</span>'; }
        
        function filterCalls() { let filtered = [...callsData]; const searchTerm = currentFilters.search.toLowerCase(); if(searchTerm) filtered = filtered.filter(call => call.id.toLowerCase().includes(searchTerm) || call.patient.toLowerCase().includes(searchTerm) || call.location.toLowerCase().includes(searchTerm)); const activeStatus = currentFilters.status !== 'all' ? currentFilters.status : (currentFilters.tab !== 'all' ? currentFilters.tab : null); if(activeStatus && activeStatus !== 'all') filtered = filtered.filter(call => call.status === activeStatus); const now = new Date(); const todayStart = new Date(now.getFullYear(), now.getMonth(), now.getDate()); if(currentFilters.dateRange === 'today') filtered = filtered.filter(call => new Date(call.dateTime) >= todayStart); else if(currentFilters.dateRange === 'week') { const weekStart = new Date(now); weekStart.setDate(now.getDate() - now.getDay()); filtered = filtered.filter(call => new Date(call.dateTime) >= weekStart); } else if(currentFilters.dateRange === 'month') { const monthStart = new Date(now.getFullYear(), now.getMonth(), 1); filtered = filtered.filter(call => new Date(call.dateTime) >= monthStart); } return filtered; }
        
        function updateStats() { 
            const total = callsData.length; 
            const active = callsData.filter(c => c.status === 'In Progress' || c.status === 'Pending').length;
            const avgResponse = "8.5";
            document.getElementById('statsContainer').innerHTML = `
                <div class="rounded-lg text-card-foreground border bg-white dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex flex-col space-y-1.5 p-3 md:p-4 pb-2"><h2 class="xl:text-2xl mb-2 tracking-tight text-sm font-medium">Total Calls</h2></div><div class="p-3 md:p-4"><div class="flex items-center justify-between"><div class="text-2xl font-bold">${total}</div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-ambulance size-8 text-muted-foreground"><path d="M10 10H6"></path><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"></path><path d="M19 18h2a1 1 0 0 0 1-1v-3.28a1 1 0 0 0-.684-.948l-1.923-.641a1 1 0 0 1-.578-.502l-1.539-3.076A1 1 0 0 0 16.382 8H14"></path><path d="M8 8v4"></path><path d="M9 18h6"></path><circle cx="17" cy="18" r="2"></circle><circle cx="7" cy="18" r="2"></circle></svg></div><p class="text-xs text-muted-foreground">+5.2% from last month</p></div></div>
                <div class="rounded-lg text-card-foreground border bg-white dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex flex-col space-y-1.5 p-3 md:p-4 pb-2"><h2 class="xl:text-2xl mb-2 tracking-tight text-sm font-medium">Active Calls</h2></div><div class="p-3 md:p-4"><div class="flex items-center justify-between"><div class="text-2xl font-bold">${active}</div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-phone size-8 text-muted-foreground"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg></div><p class="text-xs text-muted-foreground">${callsData.filter(c=>c.status==='Pending').length} pending, ${callsData.filter(c=>c.status==='In Progress').length} in progress</p></div></div>
                <div class="rounded-lg text-card-foreground border bg-white dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex flex-col space-y-1.5 p-3 md:p-4 pb-2"><h2 class="xl:text-2xl mb-2 tracking-tight text-sm font-medium">Avg Response Time</h2></div><div class="p-3 md:p-4"><div class="flex items-center justify-between"><div class="text-2xl font-bold">${avgResponse} min</div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-clock size-8 text-muted-foreground"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></div><p class="text-xs text-muted-foreground">-1.2 min from last month</p></div></div>
            `;
        }
        
        let activeMenu = null;
        function closeActiveMenu() { if(activeMenu && activeMenu.remove) { activeMenu.remove(); activeMenu = null; } }
        function showToast(msg) { const toast = document.createElement('div'); toast.className = 'toast-message'; toast.innerText = msg; document.body.appendChild(toast); setTimeout(() => toast.remove(), 3000); }
        

        
        // ==================== UPDATED ACTION MENU ====================
        let activeActionMenu = null;
        
        function closeActionMenu() { 
            if (activeActionMenu) { 
                activeActionMenu.remove(); 
                activeActionMenu = null; 
            } 
        }

function showActionMenu(btn, call) {
    closeActionMenu();
    
    const rect = btn.getBoundingClientRect();
    const menu = document.createElement('div');
    menu.className = 'action-menu';
    
    // Calculate position based on viewport (not scroll position)
    let left = rect.left;
    let top = rect.bottom + 6;
    const menuWidth = 220;
    const menuHeight = 320; // Height for 6 items + headers + dividers
    
    // Horizontal boundary check - flip to left if needed
    if (left + menuWidth > window.innerWidth) {
        left = window.innerWidth - menuWidth - 10;
    }
    if (left < 10) left = 10;
    
    // Vertical boundary check - flip to top if needed (CRITICAL)
    if (top + menuHeight > window.innerHeight) {
        top = rect.top - menuHeight - 6;
    }
    if (top < 10) top = 10;
    
    menu.style.top = `${top}px`;
    menu.style.left = `${left}px`;
    
    // Menu HTML (same as before with all options)
    menu.innerHTML = `
        <div class="action-menu-header">Actions - ${call.id}</div>
        <button data-action="view-details" class="action-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
            View Details
        </button>
        <button data-action="edit-call" class="action-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
            Edit Call
        </button>
        <button data-action="view-patient" class="action-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 1 0-16 0"/></svg>
            View Patient
        </button>
        <button data-action="view-ambulance" class="action-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 10H6"/><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.28a1 1 0 0 0-.684-.948l-1.923-.641a1 1 0 0 1-.578-.502l-1.539-3.076A1 1 0 0 0 16.382 8H14"/><path d="M8 8v4"/><path d="M9 18h6"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
            View Ambulance
        </button>
        <div class="action-divider"></div>
        <button data-action="print-report" class="action-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
            Print Report
        </button>
        <div class="action-divider"></div>
        <button data-action="delete-call" class="action-item text-red-600">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
            Delete Call
        </button>
    `;
    
    document.body.appendChild(menu);
    activeActionMenu = menu;
    
    // Close menu when clicking outside
    const closeHandler = (e) => { 
        if (!menu.contains(e.target) && e.target !== btn) { 
            closeActionMenu(); 
            document.removeEventListener('click', closeHandler); 
        } 
    };
    setTimeout(() => document.addEventListener('click', closeHandler), 10);
    
    // Menu item handlers
    menu.querySelector('[data-action="view-details"]')?.addEventListener('click', () => {
        window.location.href = `ambulance-calls-details.html?id=${call.id}`;
        closeActionMenu();
    });
    
    menu.querySelector('[data-action="edit-call"]')?.addEventListener('click', () => {
        window.location.href = `edit-ambulance-call.html?id=${call.id}`;
        closeActionMenu();
    });
    
    menu.querySelector('[data-action="view-patient"]')?.addEventListener('click', () => {
        window.location.href = `patient-profile.html?name=${encodeURIComponent(call.patient)}`;
        closeActionMenu();
    });
    
    menu.querySelector('[data-action="view-ambulance"]')?.addEventListener('click', () => {
        window.location.href = `ambulance-details.html?id=${call.ambulanceId || 'AMB-001'}`;
        closeActionMenu();
    });
    
    menu.querySelector('[data-action="print-report"]')?.addEventListener('click', () => {
        showToast(`Preparing report for call ${call.id}...`);
        closeActionMenu();
    });
    
   menu.querySelector('[data-action="delete-call"]')?.addEventListener('click', () => {
    closeActionMenu();
    // Store the call to delete
    window._callToDelete = call;
    openDeleteModal(call);
});
}

// Delete Modal Logic
let callToDelete = null;

function openDeleteModal(call) {
    callToDelete = call;
    document.getElementById('deleteCallId').innerText = call.id;
    document.getElementById('deleteModalOverlay').classList.remove('modal-hidden');
    document.getElementById('deleteModal').classList.remove('modal-hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModalOverlay').classList.add('modal-hidden');
    document.getElementById('deleteModal').classList.add('modal-hidden');
    callToDelete = null;
}

document.getElementById('deleteModalCloseBtn')?.addEventListener('click', closeDeleteModal);
document.getElementById('deleteModalOverlay')?.addEventListener('click', closeDeleteModal);

document.getElementById('confirmDeleteBtn')?.addEventListener('click', () => {
    if (callToDelete) {
        const index = callsData.findIndex(c => c.id === callToDelete.id);
        if (index !== -1) {
            callsData.splice(index, 1);
            renderTable();
            showToast(`Call ${callToDelete.id} has been deleted`);
        }
    }
    closeDeleteModal();
});

// Close delete modal on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !document.getElementById('deleteModal').classList.contains('modal-hidden')) {
        closeDeleteModal();
    }
});

function showCallDetails(call) {
            // Redirect to ambulance-calls-details.html with call ID as parameter
            window.location.href = `ambulance-calls-details.html?id=${call.id}`;
        }

                function viewPatientProfile(call) {
            // Redirect to patient-profile.html with patient ID/name as parameter
            // Using patient name as identifier for demo, you can replace with actual patient ID
            const patientIdentifier = encodeURIComponent(call.patient);
            window.location.href = `patient-profile.html?name=${patientIdentifier}`;
        }
        
        function viewAmbulanceDetails(call) {
            // Redirect to ambulance-details.html with ambulance ID as parameter
            const ambulanceId = call.ambulanceId || 'AMB-001'; // Fallback if not assigned
            window.location.href = `ambulance-details.html?id=${ambulanceId}`;
        }
        
        function printCallReport(call) {
            // Show toast notification for print report
            showToast(`Preparing report for call ${call.id}...`);
            // You can implement actual print logic here
            // For example: window.print() or open a print-friendly version
        }
        
        function showEditCallModal(call) {
            const modal = document.createElement('div');
            modal.className = 'modal-backdrop';
            modal.innerHTML = `
                <div class="modal-content p-6" style="max-width: 500px;">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Edit Call - ${call.id}</h2>
                        <button class="close-edit-modal text-gray-500 text-2xl hover:text-gray-700">&times;</button>
                    </div>
                    <div class="space-y-4">
                        <div><label class="text-sm font-medium">Patient Name</label><input id="editPatient" class="w-full mt-1 rounded-md border border-gray-300 px-3 py-2 text-sm" value="${call.patient}"></div>
                        <div><label class="text-sm font-medium">Phone Number</label><input id="editPhone" class="w-full mt-1 rounded-md border border-gray-300 px-3 py-2 text-sm" value="${call.phone || ''}"></div>
                        <div><label class="text-sm font-medium">Location</label><input id="editLocation" class="w-full mt-1 rounded-md border border-gray-300 px-3 py-2 text-sm" value="${call.location}"></div>
                        <div><label class="text-sm font-medium">Reason</label>
                            <select id="editReason" class="w-full mt-1 rounded-md border border-gray-300 px-3 py-2 text-sm">
                                <option ${call.reason === 'Chest Pain' ? 'selected' : ''}>Chest Pain</option>
                                <option ${call.reason === 'Traffic Accident' ? 'selected' : ''}>Traffic Accident</option>
                                <option ${call.reason === 'Difficulty Breathing' ? 'selected' : ''}>Difficulty Breathing</option>
                                <option ${call.reason === 'Fall Injury' ? 'selected' : ''}>Fall Injury</option>
                                <option ${call.reason === 'Stroke Symptoms' ? 'selected' : ''}>Stroke Symptoms</option>
                                <option ${call.reason === 'Cardiac Arrest' ? 'selected' : ''}>Cardiac Arrest</option>
                                <option ${call.reason === 'Seizure' ? 'selected' : ''}>Seizure</option>
                                <option ${call.reason === 'Other' ? 'selected' : ''}>Other</option>
                            </select>
                        </div>
                        <div><label class="text-sm font-medium">Notes</label><textarea id="editNotes" rows="2" class="w-full mt-1 rounded-md border border-gray-300 px-3 py-2 text-sm">${call.notes || ''}</textarea></div>
                    </div>
                    <div class="flex justify-end gap-3 pt-4">
                        <button class="close-edit-modal px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100">Cancel</button>
                        <button id="saveEditBtn" class="px-4 py-2 rounded-md bg-primary text-white hover:bg-indigo-700">Save Changes</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            document.body.style.overflow = 'hidden';
            
            const closeModal = () => { modal.remove(); document.body.style.overflow = ''; };
            modal.querySelectorAll('.close-edit-modal').forEach(btn => btn.addEventListener('click', closeModal));
            modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
            
            modal.querySelector('#saveEditBtn')?.addEventListener('click', () => {
                call.patient = modal.querySelector('#editPatient').value;
                call.phone = modal.querySelector('#editPhone').value;
                call.location = modal.querySelector('#editLocation').value;
                call.reason = modal.querySelector('#editReason').value;
                call.notes = modal.querySelector('#editNotes').value;
                renderTable();
                showToast(`Call ${call.id} updated`);
                closeModal();
            });
        }
        
        function showUpdateStatusModal(call) {
            const modal = document.createElement('div');
            modal.className = 'modal-backdrop';
            modal.innerHTML = `
                <div class="modal-content p-6" style="max-width: 400px;">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Update Status - ${call.id}</h2>
                        <button class="close-status-modal text-gray-500 text-2xl hover:text-gray-700">&times;</button>
                    </div>
                    <div class="space-y-4">
                        <div><label class="text-sm font-medium">Current Status</label><div class="mt-1 px-3 py-2 bg-gray-100 rounded-md text-sm">${call.status}</div></div>
                        <div><label class="text-sm font-medium">New Status</label>
                            <select id="newStatus" class="w-full mt-1 rounded-md border border-gray-300 px-3 py-2 text-sm">
                                <option value="Pending" ${call.status === 'Pending' ? 'selected' : ''}>Pending</option>
                                <option value="In Progress" ${call.status === 'In Progress' ? 'selected' : ''}>In Progress</option>
                                <option value="Completed" ${call.status === 'Completed' ? 'selected' : ''}>Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-4">
                        <button class="close-status-modal px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100">Cancel</button>
                        <button id="saveStatusBtn" class="px-4 py-2 rounded-md bg-primary text-white hover:bg-indigo-700">Update</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            document.body.style.overflow = 'hidden';
            
            const closeModal = () => { modal.remove(); document.body.style.overflow = ''; };
            modal.querySelectorAll('.close-status-modal').forEach(btn => btn.addEventListener('click', closeModal));
            modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
            
            modal.querySelector('#saveStatusBtn')?.addEventListener('click', () => {
                call.status = modal.querySelector('#newStatus').value;
                renderTable();
                showToast(`Status updated to ${call.status}`);
                closeModal();
            });
        }
        
        function showAssignDriverModal(call) {
            const drivers = ['Kimera John', 'Wanjiru Sarah', 'Byaruhanga Robert', 'Tumusiime Thomas', 'Atim Linda'];
            const modal = document.createElement('div');
            modal.className = 'modal-backdrop';
            modal.innerHTML = `
                <div class="modal-content p-6" style="max-width: 400px;">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Assign Driver - ${call.id}</h2>
                        <button class="close-driver-modal text-gray-500 text-2xl hover:text-gray-700">&times;</button>
                    </div>
                    <div class="space-y-4">
                        <div><label class="text-sm font-medium">Current Driver</label><div class="mt-1 px-3 py-2 bg-gray-100 rounded-md text-sm">${call.driver || 'Unassigned'}</div></div>
                        <div><label class="text-sm font-medium">Select Driver</label>
                            <select id="newDriver" class="w-full mt-1 rounded-md border border-gray-300 px-3 py-2 text-sm">
                                ${drivers.map(d => `<option value="${d}" ${call.driver === d ? 'selected' : ''}>${d}</option>`).join('')}
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 pt-4">
                        <button class="close-driver-modal px-4 py-2 rounded-md border border-gray-300 hover:bg-gray-100">Cancel</button>
                        <button id="saveDriverBtn" class="px-4 py-2 rounded-md bg-primary text-white hover:bg-indigo-700">Assign</button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            document.body.style.overflow = 'hidden';
            
            const closeModal = () => { modal.remove(); document.body.style.overflow = ''; };
            modal.querySelectorAll('.close-driver-modal').forEach(btn => btn.addEventListener('click', closeModal));
            modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
            
            modal.querySelector('#saveDriverBtn')?.addEventListener('click', () => {
                call.driver = modal.querySelector('#newDriver').value;
                renderTable();
                showToast(`Driver assigned to ${call.id}`);
                closeModal();
            });
        }
        
        function completeCall(call) {
            if (confirm(`Mark call ${call.id} as completed?`)) {
                call.status = 'Completed';
                renderTable();
                showToast(`Call ${call.id} marked as completed`);
            }
        }        
        function renderTable() { 
            const filtered = filterCalls(); 
            const tbody = document.getElementById('callsTableBody'); 
            const noResults = document.getElementById('noResultsMsg'); 
            if(filtered.length === 0) { 
                tbody.innerHTML = ''; 
                noResults.classList.remove('hidden'); 
                updateStats(); 
                return; 
            } 
            noResults.classList.add('hidden'); 
            tbody.innerHTML = filtered.map(call => `
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-4 align-middle font-medium">${call.id}</td>
                    <td class="p-4 align-middle">${formatDateTime(call.dateTime)}</td>
                    <td class="p-4 align-middle">${call.patient}<br><span class="text-xs text-gray-400">${call.phone || 'N/A'}</span></td>
                    <td class="p-4 align-middle hidden md:table-cell">${call.location}</td>
                    <td class="p-4 align-middle"><span class="p-4 align-middle hidden md:table-cell" ${getReasonBadgeClass(call.reason)}">${call.reason}</span></td>
                    <td class="p-4 align-middle">${getStatusBadge(call.status)}</td>
                    <td class="p-4 align-middle hidden lg:table-cell">${call.ambulanceId || 'Unassigned'}<br><span class="text-xs text-gray-400">${call.driver || 'TBD'}</span></td>
                    <td class="p-4 align-middle text-right">
                        <button class="action-menu-trigger inline-flex items-center justify-center rounded-md hover:bg-gray-100 size-8" data-call-id="${call.id}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="1"/>
                                <circle cx="19" cy="12" r="1"/>
                                <circle cx="5" cy="12" r="1"/>
                            </svg>
                        </button>
                    </td>
                 `
            ).join(''); 
            updateStats(); 
            document.querySelectorAll('.action-menu-trigger').forEach(btn => { 
                btn.removeEventListener('click', function(e) { 
                    const id = btn.getAttribute('data-call-id'); 
                    const call = callsData.find(c => c.id === id);
                    if(call) showActionMenu(btn, call); 
                }); 
                btn.addEventListener('click', function(e) { 
                    e.stopPropagation(); 
                    const id = btn.getAttribute('data-call-id'); 
                    const call = callsData.find(c => c.id === id);
                    if(call) showActionMenu(btn, call); 
                }); 
            }); 
        }
        
        // Helper function for reason badge styling
        function getReasonBadgeClass(reason) {
            const highPriority = ['Chest Pain', 'Cardiac Arrest', 'Stroke Symptoms', 'Difficulty Breathing'];
            const mediumPriority = ['Traffic Accident', 'Seizure'];
            if (highPriority.includes(reason)) return 'bg-red-100 text-red-700';
            if (mediumPriority.includes(reason)) return 'bg-orange-100 text-orange-700';
            return 'bg-blue-100 text-blue-700';
        }        
        function initSelect(triggerId, dropdownId, onSelect) { const trigger = document.getElementById(triggerId); const dropdown = document.getElementById(dropdownId); if(!trigger || !dropdown) return; trigger.addEventListener('click', (e) => { e.stopPropagation(); document.querySelectorAll('.radix-dropdown-menu').forEach(menu => { if(menu !== dropdown) menu.classList.add('hidden'); }); const isHidden = dropdown.classList.contains('hidden'); if(isHidden) { dropdown.classList.remove('hidden'); const rect = trigger.getBoundingClientRect(); dropdown.style.top = `${rect.bottom + window.scrollY + 2}px`; dropdown.style.left = `${rect.left + window.scrollX}px`; dropdown.style.width = `${rect.width}px`; } else dropdown.classList.add('hidden'); }); dropdown.querySelectorAll('.radix-menu-item').forEach(item => { item.addEventListener('click', () => { const value = item.getAttribute('data-status') || item.getAttribute('data-date') || item.getAttribute('data-reason') || item.getAttribute('data-ambulance'); const text = item.innerText; if(triggerId === 'statusSelectTrigger') document.getElementById('statusSelectedText').innerText = text; else if(triggerId === 'dateSelectTrigger') document.getElementById('dateSelectedText').innerText = text; else if(triggerId === 'reasonBtn') document.getElementById('reasonSelected').innerText = text; else if(triggerId === 'ambulanceBtn') document.getElementById('ambulanceSelected').innerText = text; if(onSelect) onSelect(value); dropdown.classList.add('hidden'); }); }); }
        
        initSelect('statusSelectTrigger', 'statusDropdown', (val) => { currentFilters.status = val; currentFilters.tab = 'all'; document.querySelectorAll('.status-tab').forEach(t => t.classList.remove('bg-indigo-50','text-indigo-700')); if(document.querySelector(`.status-tab[data-tab="${val === 'all' ? 'all' : val}"]`)) document.querySelector(`.status-tab[data-tab="${val === 'all' ? 'all' : val}"]`).classList.add('bg-indigo-50','text-indigo-700'); else document.querySelector('.status-tab[data-tab="all"]').classList.add('bg-indigo-50','text-indigo-700'); renderTable(); });
        initSelect('dateSelectTrigger', 'dateDropdown', (val) => { currentFilters.dateRange = val; renderTable(); });
        initSelect('reasonBtn', 'reasonDropdown', null); initSelect('ambulanceBtn', 'ambulanceDropdown', null);
        document.getElementById('searchInput').addEventListener('input', (e) => { currentFilters.search = e.target.value; renderTable(); });
        document.querySelectorAll('.status-tab').forEach(tab => { tab.addEventListener('click', () => { const val = tab.getAttribute('data-tab'); currentFilters.tab = val; currentFilters.status = 'all'; document.getElementById('statusSelectedText').innerText = val === 'all' ? 'All Statuses' : val; document.querySelectorAll('.status-tab').forEach(t => t.classList.remove('bg-indigo-50','text-indigo-700')); tab.classList.add('bg-indigo-50','text-indigo-700'); renderTable(); }); });
        document.addEventListener('click', (e) => { if(!e.target.closest('.radix-select') && !e.target.closest('.radix-dropdown-menu')) document.querySelectorAll('.radix-dropdown-menu').forEach(menu => menu.classList.add('hidden')); });
        
        const modal = document.getElementById('newCallModal'); function openModal() { modal.classList.remove('hidden'); } function closeModal() { modal.classList.add('hidden'); }
        document.getElementById('newCallBtn').addEventListener('click', openModal); document.getElementById('closeModalBtn').addEventListener('click', closeModal); document.getElementById('cancelModalBtn').addEventListener('click', closeModal);
        document.getElementById('saveCallBtn').addEventListener('click', () => { const patientName = document.getElementById('patientName').value.trim(); const location = document.getElementById('locationInput').value.trim(); if(!patientName || !location) { showToast('Please fill required fields'); return; } const newId = `AC00${callsData.length + 5}`; const now = new Date(); const dateTimeStr = `${now.getFullYear()}-${String(now.getMonth()+1).padStart(2,'0')}-${String(now.getDate()).padStart(2,'0')}T${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}`; const newCall = { id: newId, dateTime: dateTimeStr, patient: patientName, phone: document.getElementById('phoneNumber').value.trim() || 'N/A', location: location, reason: document.getElementById('reasonSelected').innerText !== 'Select reason' ? document.getElementById('reasonSelected').innerText : 'Other', status: 'Pending', ambulanceId: document.getElementById('ambulanceSelected').innerText !== 'Select ambulance' ? document.getElementById('ambulanceSelected').innerText.split(' ')[0] : 'Unassigned', driver: document.getElementById('ambulanceSelected').innerText.includes('Driver:') ? document.getElementById('ambulanceSelected').innerText.split('Driver:')[1].trim() : 'TBD', notes: document.getElementById('callNotes').value }; callsData.unshift(newCall); renderTable(); closeModal(); document.getElementById('patientName').value = ''; document.getElementById('phoneNumber').value = ''; document.getElementById('locationInput').value = ''; document.getElementById('reasonSelected').innerText = 'Select reason'; document.getElementById('ambulanceSelected').innerText = 'Select ambulance'; document.getElementById('callNotes').value = ''; showToast(`New call ${newId} created`); });
        
        renderTable();
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
    <script src="js/meditrack-map.js"></script>
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
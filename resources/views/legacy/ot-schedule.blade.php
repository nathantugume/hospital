<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | OT Schedule</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-background { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .border-gray-200, body.dark .border-gray-300 { border-color: #333333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-muted, body.dark .bg-gray-100 { background-color: #262626 !important; }
        body.dark input, body.dark select, body.dark .border-input { background-color: #262626; border-color: #404040; color: #e5e5e5; }
        
        [data-state="active"] { background-color: white !important; color: #1f2937 !important; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        body.dark [data-state="active"] { background-color: #131212 !important; color: #e5e5e5 !important; }
        
        .tab-panel { display: none; animation: fadeIn 0.2s ease-out; }
        .tab-panel.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }
        
        .dropdown-animation { animation: fadeInScale 0.12s ease-out; }
        @keyframes fadeInScale { from { opacity: 0; transform: scale(0.96); } to { opacity: 1; transform: scale(1); } }
        
        .status-badge {
            display: inline-flex; align-items: center; border-radius: 9999px;
            padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 600;
        }
        .status-ongoing { background: #dbeafe; color: #1e40af; }
        .status-scheduled { background: #fef3c7; color: #92400e; }
        .status-completed { background: #dcfce7; color: #166534; }
        .status-emergency { background: #fee2e2; color: #991b1b; }
        .status-preop { background: #f3e8ff; color: #6b21a8; }
        .status-cancelled { background: #f3f4f6; color: #6b7280; }
        
        body.dark .status-ongoing { background: #1e3a8a; color: #bfdbfe; }
        body.dark .status-scheduled { background: #78350f; color: #fde68a; }
        body.dark .status-completed { background: #14532d; color: #bbf7d0; }
        body.dark .status-emergency { background: #7f1d1d; color: #fecaca; }
        body.dark .status-preop { background: #4c1d95; color: #e9d5ff; }
        body.dark .status-cancelled { background: #374151; color: #d1d5db; }
        
        .calendar-day:hover { background-color: #eef2ff; }
        
        /* Action Menu / Popover */
        .action-popover {
            position: fixed; z-index: 10000; min-width: 200px; background: white;
            border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.15);
            padding: 0.25rem; animation: fadeInScale 0.12s ease-out;
        }
        body.dark .action-popover { background: #2a2a2a; border-color: #404040; }
        .popover-header { padding: 0.5rem 0.75rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb; margin-bottom: 0.25rem; }
        body.dark .popover-header { color: #9ca3af; border-bottom-color: #404040; }
        .popover-item {
            padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer; display: flex;
            align-items: center; gap: 8px; border-radius: 0.25rem; transition: background 0.1s;
            width: 100%; background: transparent; border: none; color: inherit; text-align: left;
        }
        .popover-item:hover { background-color: #f3f4f6; }
        body.dark .popover-item:hover { background-color: #3f3f46; }
        .popover-divider { height: 1px; background-color: #e5e7eb; margin: 0.25rem 0; }
        body.dark .popover-divider { background-color: #404040; }
        .text-red-600 { color: #dc2626; }
        
        /* Modal */
        .modal-overlay {
            position: fixed; inset: 0; background-color: rgba(0,0,0,0.6); backdrop-filter: blur(4px);
            display: flex; align-items: center; justify-content: center; z-index: 9999;
            animation: fadeIn 0.2s ease-out;
        }
        .modal-container {
            background: white; border-radius: 0.75rem; width: 100%; max-width: 550px;
            max-height: 90vh; overflow-y: auto; animation: slideUp 0.2s ease; position: relative;
        }
        body.dark .modal-container { background: #1e1e1e; border: 1px solid #333; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header { padding: 1rem 1.5rem;  display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; background: white; z-index: 10; }
        body.dark .modal-header {  background: #1e1e1e; }
        .modal-title { font-size: 1.125rem; font-weight: 600; }
        .modal-close { background: transparent; border: none; font-size: 1.5rem; cursor: pointer; color: #6b7280; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 0.375rem; }
        .modal-close:hover { color: #1f2937; background-color: #f3f4f6; }
        body.dark .modal-close:hover { color: #e5e5e5; background-color: #374151; }
        .modal-body { padding: 0 1.5rem; }
        .modal-footer { padding: 1rem 1.5rem;  display: flex; justify-content: flex-end; gap: 0.5rem; position: sticky; bottom: 0; background: white; }
        body.dark .modal-footer {  background: #1e1e1e; padding: .5rem;}
        
        .toast-message {
            position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white;
            padding: 12px 20px; border-radius: 8px; z-index: 11000; font-size: 0.875rem;
            animation: slideIn 0.3s ease-out;
        }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

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
        <div class="flex flex-col gap-5">
            <!-- Header -->
<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-4">
                    <a href="ot-dashboard.html" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white hover:bg-gray-100 size-10">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="arrow-left" aria-hidden="true" class="lucide lucide-arrow-left h-4 w-4"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                    </a>
                    <div><h1 class="text-2xl lg:text-3xl font-bold tracking-tight">OT Schedule</h1><p class="text-gray-500">Manage operating theater bookings and surgical schedules</p></div>
                </div>
                <div class="flex gap-2">
                    <button onclick="window.location.href='add-appointment.html'" class="bg-primary text-white hover:bg-primary/90 h-10 px-4 rounded-md text-sm flex items-center gap-2 transition" style="background-color: #4f46e5;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="plus" aria-hidden="true" class="lucide lucide-plus h-4 w-4"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>Book Surgery
                    </button>
                </div>
            </div>

<div class="grid gap-4 md:grid-cols-4">
    <!-- Today Card -->
    <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition cursor-pointer p-4">
        <div class="flex justify-between items-center mb-3">
            <span class="text-sm text-gray-500">Today</span>
            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2"></rect>
                <path d="M16 2v4"></path>
                <path d="M8 2v4"></path>
                <path d="M3 10h18"></path>
            </svg>
        </div>
        <div class="text-2xl font-bold text-blue-600 mb-1" id="statToday">8</div>
        <p class="text-xs text-gray-400">Scheduled surgeries</p>
    </div>

    <!-- In Progress Card -->
    <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition cursor-pointer p-4">
        <div class="flex justify-between items-center mb-3">
            <span class="text-sm text-gray-500">In Progress</span>
            <svg class="h-5 w-5 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
            </svg>
        </div>
        <div class="text-2xl font-bold text-amber-600 mb-1" id="statInProgress">2</div>
        <p class="text-xs text-gray-400">Currently in OT</p>
    </div>

    <!-- Completed Card -->
    <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition cursor-pointer p-4">
        <div class="flex justify-between items-center mb-3">
            <span class="text-sm text-gray-500">Completed</span>
            <svg class="h-5 w-5 text-green-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 6 9 17l-5-5"></path>
            </svg>
        </div>
        <div class="text-2xl font-bold text-green-600 mb-1" id="statCompleted">4</div>
        <p class="text-xs text-gray-400">Today's completions</p>
    </div>

    <!-- Available Slots Card -->
    <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition cursor-pointer p-4">
        <div class="flex justify-between items-center mb-3">
            <span class="text-sm text-gray-500">Available Slots</span>
            <svg class="h-5 w-5 text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M12 6v6l4 2"></path>
            </svg>
        </div>
        <div class="text-2xl font-bold text-indigo-600 mb-1" id="statAvailable">3</div>
        <p class="text-xs text-gray-400">Open for booking</p>
    </div>
</div>

            <div class="flex flex-col md:flex-row gap-4">
                <!-- Left Column: Mini Calendar & Filters -->
                <div class="rounded-lg border bg-background shadow-sm md:w-80 h-full">
                    <div class="p-4 border-b"><h2 class="text-xl font-semibold">Calendar</h2><p class="text-gray-500 text-sm">Select a date to view schedules.</p></div>
                    <div class="p-4" id="calendarContainer"></div>
                    <div class="p-4 space-y-4 border-t">
                        <div class="space-y-2">
                            <label class="text-sm font-medium">Filter by OT Room</label>
                            <div class="relative" id="roomSelectContainer">
                                <button type="button" id="roomSelectTrigger" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-background px-3 py-2 text-sm">
                                    <span id="selectedRoomText">All OT Rooms</span>
                                    <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                                </button>
                                <div id="roomSelectDropdown" class="hidden absolute z-50 mt-1 w-full rounded-md border bg-background shadow-lg dropdown-animation">
                                    <div class="p-1">
                                        <div class="room-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="all">All OT Rooms</div>
                                        <div class="room-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="OT-1">OT-1 (Cardiac Suite)</div>
                                        <div class="room-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="OT-2">OT-2 (General Surgery)</div>
                                        <div class="room-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="OT-3">OT-3 (Trauma & Emergency)</div>
                                        <div class="room-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="OT-4">OT-4 (Orthopedic Suite)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium">Filter by Surgeon</label>
                            <div class="relative" id="surgeonSelectContainer">
                                <button type="button" id="surgeonSelectTrigger" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-background px-3 py-2 text-sm">
                                    <span id="selectedSurgeonText">All Surgeons</span>
                                    <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                                </button>
                                <div id="surgeonSelectDropdown" class="hidden absolute z-50 mt-1 w-full rounded-md border bg-background shadow-lg dropdown-animation">
                                    <div class="p-1">
                                        <div class="surgeon-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="all">All Surgeons</div>
                                        <div class="surgeon-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="Dr. Mwangi Peter">Dr. Mwangi Peter</div>
                                        <div class="surgeon-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="Dr. Achieng Grace">Dr. Achieng Grace</div>
                                        <div class="surgeon-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="Dr. Okello James">Dr. Okello James</div>
                                        <div class="surgeon-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="Dr. Wanjiru Emily">Dr. Wanjiru Emily</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="add-appointment.html" class="inline-flex items-center justify-center gap-2 rounded-md bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 text-sm w-full shadow-sm transition-colors">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            Book Surgery
                        </a>
                    </div>
                </div>

                <!-- Right Column: Schedule Views -->
                <div class="flex-1">
                    <div class="space-y-4">
                        <!-- Tab triggers + Navigation -->
                        <div class="flex justify-between items-center flex-wrap gap-3">
                            <div class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1">
                                <button data-tab="day" class="schedule-tab inline-flex items-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all bg-white text-gray-900 shadow-sm">Day</button>
                                <button data-tab="week" class="schedule-tab inline-flex items-center rounded-sm px-3 py-1.5 text-sm font-medium text-gray-600 hover:text-gray-900">Week</button>
                                <button data-tab="month" class="schedule-tab inline-flex items-center rounded-sm px-3 py-1.5 text-sm font-medium text-gray-600 hover:text-gray-900">Month</button>
                                <button data-tab="list" class="schedule-tab inline-flex items-center rounded-sm px-3 py-1.5 text-sm font-medium text-gray-600 hover:text-gray-900">List</button>
                            </div>
                            <div class="flex items-center gap-2">
                                <button id="prevDateBtn" class="border border-gray-300 bg-background hover:bg-gray-100 h-10 size-10 rounded-md shadow-sm flex items-center justify-center"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></button>
                                <div id="currentDateDisplay" class="text-sm font-medium min-w-[100px] text-center">April 13, 2026</div>
                                <button id="nextDateBtn" class="border border-gray-300 bg-background hover:bg-gray-100 h-10 size-10 rounded-md shadow-sm flex items-center justify-center"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></button>
                                <button id="todayBtn" class="border border-gray-300 bg-background hover:bg-gray-100 h-10 px-3 py-2 text-sm rounded-md shadow-sm">Today</button>
                            </div>
                        </div>

                        <!-- Tab Panels -->
                        <div id="dayViewPanel" class="tab-panel active rounded-lg border bg-background shadow-sm"></div>
                        <div id="weekViewPanel" class="tab-panel rounded-lg border bg-background shadow-sm"></div>
                        <div id="monthViewPanel" class="tab-panel rounded-lg border bg-background shadow-sm"></div>
                        <div id="listViewPanel" class="tab-panel rounded-lg border bg-background shadow-sm"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Action Popover (Context Menu) -->
<div id="actionPopover" class="action-popover hidden"></div>

<!-- Book/Edit Surgery Modal -->
<div id="surgeryModal" class="modal-overlay" style="display: none;">
    <div class="modal-container" style="max-width: 600px;">
        <div class="modal-header">
            <h2 class="modal-title" id="surgeryModalTitle">Book Surgery</h2>
            <button class="modal-close" id="closeSurgeryModal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="space-y-4">
                <div class="grid md:grid-cols-2 gap-4">
                    <div><label class="text-sm font-medium block mb-1">Patient Name <span class="text-red-500">*</span></label><input type="text" id="modalPatient" class="w-full rounded-md border px-3 py-2 text-sm" placeholder="Enter patient name"></div>
                    <div><label class="text-sm font-medium block mb-1">Procedure <span class="text-red-500">*</span></label><input type="text" id="modalProcedure" class="w-full rounded-md border px-3 py-2 text-sm" placeholder="Enter procedure name"></div>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium block mb-1">OT Room <span class="text-red-500">*</span></label>
                        <select id="modalOTRoom" class="w-full rounded-md border px-3 py-2 text-sm">
                            <option value="">Select room</option>
                            <option value="OT-1">OT-1 (Cardiac Suite)</option>
                            <option value="OT-2">OT-2 (General Surgery)</option>
                            <option value="OT-3">OT-3 (Trauma & Emergency)</option>
                            <option value="OT-4">OT-4 (Orthopedic Suite)</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium block mb-1">Priority</label>
                        <select id="modalPriority" class="w-full rounded-md border px-3 py-2 text-sm">
                            <option value="Normal">Normal</option>
                            <option value="High">High</option>
                            <option value="Critical">Critical</option>
                        </select>
                    </div>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div><label class="text-sm font-medium block mb-1">Lead Surgeon <span class="text-red-500">*</span></label><select id="modalSurgeon" class="w-full rounded-md border px-3 py-2 text-sm"><option value="">Select surgeon</option><option value="Dr. Mwangi Peter">Dr. Mwangi Peter</option><option value="Dr. Achieng Grace">Dr. Achieng Grace</option><option value="Dr. Okello James">Dr. Okello James</option><option value="Dr. Wanjiru Emily">Dr. Wanjiru Emily</option></select></div>
                    <div><label class="text-sm font-medium block mb-1">Anesthesiologist</label><select id="modalAnesthesiologist" class="w-full rounded-md border px-3 py-2 text-sm"><option value="">Select anesthesiologist</option><option value="Dr. Lumu">Dr. Lumu</option><option value="Dr. Tumusiime">Dr. Tumusiime</option><option value="Dr. Byaruhanga">Dr. Byaruhanga</option><option value="Dr. Akampa">Dr. Akampa</option></select></div>
                </div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div><label class="text-sm font-medium block mb-1">Date <span class="text-red-500">*</span></label><input type="date" id="modalDate" class="w-full rounded-md border px-3 py-2 text-sm"></div>
                    <div class="grid grid-cols-2 gap-2">
                        <div><label class="text-sm font-medium block mb-1">Start Time</label><input type="time" id="modalStartTime" class="w-full rounded-md border px-3 py-2 text-sm"></div>
                        <div><label class="text-sm font-medium block mb-1">End Time</label><input type="time" id="modalEndTime" class="w-full rounded-md border px-3 py-2 text-sm"></div>
                    </div>
                </div>
                <div><label class="text-sm font-medium block mb-1">Notes</label><textarea id="modalNotes" rows="2" class="w-full rounded-md border px-3 py-2 text-sm" placeholder="Additional notes..."></textarea></div>
            </div>
        </div>
        <div class="modal-footer">
            <button id="cancelSurgeryBtn" class="border px-4 py-2 rounded-md h-10 text-sm hover:bg-gray-100">Cancel</button>
            <button id="saveSurgeryBtn" class="bg-primary text-white px-4 py-2 h-10 rounded-md text-sm hover:bg-primary/90">Save Surgery</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="modal-overlay" style="display: none;">
    <div class="modal-container" style="max-width: 450px;">
        <div class="modal-header">
            <h2 class="modal-title">Confirm Cancellation</h2>
            <button class="modal-close" id="closeDeleteModal">&times;</button>
        </div>
        <div class="modal-body">
            <p class="text-sm" id="deleteModalMessage">Are you sure you want to cancel this surgery? This action cannot be undone.</p>
        </div>
        <div class="modal-footer">
            <button id="cancelDeleteBtn" class="border px-4 py-2 rounded-md text-sm hover:bg-gray-100">Keep Surgery</button>
            <button id="confirmDeleteBtn" class="bg-red-600 text-white px-4 py-2 rounded-md text-sm hover:bg-red-700">Yes, Cancel Surgery</button>
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
// ==================== DATA ====================
let surgeries = [
    { id: "SURG001", patient: "Mwesigwa Robert", procedure: "CABG - Triple Bypass", otRoom: "OT-1", surgeon: "Dr. Mwangi Peter", anesthesiologist: "Dr. Lumu", date: "2026-04-13", startTime: "08:30", endTime: "13:30", status: "In Progress", priority: "High", notes: "Patient stable, on bypass" },
    { id: "SURG002", patient: "John Mwanza", procedure: "Laparoscopic Cholecystectomy", otRoom: "OT-2", surgeon: "Dr. Achieng Grace", anesthesiologist: "Dr. Tumusiime", date: "2026-04-13", startTime: "11:00", endTime: "12:30", status: "Pre-Op", priority: "Normal", notes: "Patient prepped" },
    { id: "SURG003", patient: "Sarah Achieng", procedure: "Emergency Appendectomy", otRoom: "OT-3", surgeon: "Dr. Okello James", anesthesiologist: "Dr. Byaruhanga", date: "2026-04-13", startTime: "09:15", endTime: "10:45", status: "Emergency", priority: "Critical", notes: "Ruptured appendix suspected" },
    { id: "SURG004", patient: "Nalwoga Emily", procedure: "Total Hip Replacement", otRoom: "OT-4", surgeon: "Dr. Okello James", anesthesiologist: "Dr. Akampa", date: "2026-04-13", startTime: "14:00", endTime: "17:00", status: "Scheduled", priority: "Normal", notes: "Left hip" },
    { id: "SURG005", patient: "David Okonkwo", procedure: "Coronary Angioplasty", otRoom: "OT-1", surgeon: "Dr. Mwangi Peter", anesthesiologist: "Dr. Lumu", date: "2026-04-14", startTime: "10:00", endTime: "12:00", status: "Scheduled", priority: "High", notes: "" },
    { id: "SURG006", patient: "Grace Nakamya", procedure: "Knee Arthroscopy", otRoom: "OT-4", surgeon: "Dr. Wanjiru Emily", anesthesiologist: "Dr. Kakonge", date: "2026-04-14", startTime: "08:00", endTime: "09:30", status: "Scheduled", priority: "Normal", notes: "Right knee" },
    { id: "SURG007", patient: "Namyalo Maria", procedure: "C-Section Delivery", otRoom: "OT-2", surgeon: "Dr. Achieng Grace", anesthesiologist: "Dr. Tumusiime", date: "2026-04-13", startTime: "06:00", endTime: "07:30", status: "Completed", priority: "High", notes: "Healthy baby delivered" },
    { id: "SURG008", patient: "Tumusiime Thomas", procedure: "Hernia Repair", otRoom: "OT-3", surgeon: "Dr. Mwangi Peter", anesthesiologist: "Dr. Byaruhanga", date: "2026-04-13", startTime: "07:00", endTime: "08:15", status: "Completed", priority: "Normal", notes: "Inguinal hernia" },
    { id: "SURG009", patient: "Amina Hassan", procedure: "Thyroidectomy", otRoom: "OT-2", surgeon: "Dr. Achieng Grace", anesthesiologist: "Dr. Tumusiime", date: "2026-04-15", startTime: "09:00", endTime: "11:00", status: "Scheduled", priority: "Normal", notes: "Total thyroidectomy" },
    { id: "SURG010", patient: "James Omondi", procedure: "Spinal Fusion", otRoom: "OT-3", surgeon: "Dr. Wanjiru Emily", anesthesiologist: "Dr. Akampa", date: "2026-04-16", startTime: "07:00", endTime: "13:00", status: "Scheduled", priority: "High", notes: "L4-L5 fusion" }
];

let currentDate = new Date(2026, 3, 13);
let currentTab = "day";
let currentRoomFilter = "all";
let currentSurgeonFilter = "all";
let editingSurgeryId = null;
let deletingSurgeryId = null;

// ==================== HELPERS ====================
function formatDateKey(date) { return `${date.getFullYear()}-${String(date.getMonth()+1).padStart(2,'0')}-${String(date.getDate()).padStart(2,'0')}`; }
function formatDisplayDate(date) { return date.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }); }
function getStatusBadgeClass(status) {
    if (status === "Completed") return "status-completed";
    if (status === "In Progress") return "status-ongoing";
    if (status === "Pre-Op") return "status-preop";
    if (status === "Emergency") return "status-emergency";
    if (status === "Cancelled") return "status-cancelled";
    return "status-scheduled";
}

function getFilteredSurgeries(date) {
    const dateStr = formatDateKey(date);
    let filtered = surgeries.filter(s => s.date === dateStr);
    if (currentRoomFilter !== "all") filtered = filtered.filter(s => s.otRoom === currentRoomFilter);
    if (currentSurgeonFilter !== "all") filtered = filtered.filter(s => s.surgeon === currentSurgeonFilter);
    return filtered;
}

function generateId() {
    const num = surgeries.length + 1;
    return `SURG${String(num).padStart(3, '0')}`;
}

// ==================== TOAST ====================
function showToast(msg, isError = false) {
    const existing = document.querySelector('.toast-message'); if (existing) existing.remove();
    const toast = document.createElement('div'); toast.className = `toast-message ${isError ? 'error' : ''}`;
    toast.innerText = msg; document.body.appendChild(toast); setTimeout(() => toast.remove(), 3000);
}

// ==================== ACTION POPOVER ====================
function closePopover() {
    const popover = document.getElementById('actionPopover');
    popover.classList.add('hidden');
}

function showPopover(targetEl, surgery) {
    const popover = document.getElementById('actionPopover');
    const rect = targetEl.getBoundingClientRect();
    let left = rect.right - 200;
    let top = rect.bottom + 5;
    if (left < 10) left = 10;
    if (top + 300 > window.innerHeight) top = rect.top - 310;

    popover.style.top = `${top}px`;
    popover.style.left = `${left}px`;
    
    const isActive = surgery.status === "In Progress" || surgery.status === "Emergency";
    const isScheduled = surgery.status === "Scheduled" || surgery.status === "Pre-Op";
    
    popover.innerHTML = `
        <div class="popover-header">Actions - ${surgery.id}</div>
        <button data-action="view" class="popover-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
            View Details
        </button>
        <button data-action="edit" class="popover-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
            Edit Surgery
        </button>
        ${isActive ? `
        <button data-action="complete" class="popover-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            Mark as Completed
        </button>` : ''}
        ${isScheduled ? `
        <button data-action="start" class="popover-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg>
            Start Surgery
        </button>` : ''}
        <div class="popover-divider"></div>
        <button data-action="cancel" class="popover-item text-red-600">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            Cancel Surgery
        </button>
    `;
    popover.classList.remove('hidden');

    // Bind actions
    popover.querySelector('[data-action="view"]').onclick = () => { window.location.href = `surgery-details.html?id=${surgery.id}`; closePopover(); };
    popover.querySelector('[data-action="edit"]').onclick = () => { openSurgeryModal(surgery); closePopover(); };
    popover.querySelector('[data-action="complete"]')?.addEventListener('click', () => { surgery.status = "Completed"; updateAllViews(); showToast(`Surgery ${surgery.id} marked as completed.`); closePopover(); });
    popover.querySelector('[data-action="start"]')?.addEventListener('click', () => { surgery.status = "In Progress"; updateAllViews(); showToast(`Surgery ${surgery.id} started.`); closePopover(); });
    popover.querySelector('[data-action="cancel"]')?.addEventListener('click', () => { openDeleteModal(surgery.id); closePopover(); });
}

document.addEventListener('click', (e) => {
    const popover = document.getElementById('actionPopover');
    if (!popover.classList.contains('hidden') && !popover.contains(e.target) && !e.target.closest('[data-surgery-id]')) {
        closePopover();
    }
});

// ==================== MODALS ====================
function openSurgeryModal(surgery = null) {
    editingSurgeryId = surgery ? surgery.id : null;
    const modal = document.getElementById('surgeryModal');
    document.getElementById('surgeryModalTitle').textContent = surgery ? 'Edit Surgery' : 'Book Surgery';
    
    if (surgery) {
        document.getElementById('modalPatient').value = surgery.patient;
        document.getElementById('modalProcedure').value = surgery.procedure;
        document.getElementById('modalOTRoom').value = surgery.otRoom;
        document.getElementById('modalPriority').value = surgery.priority;
        document.getElementById('modalSurgeon').value = surgery.surgeon;
        document.getElementById('modalAnesthesiologist').value = surgery.anesthesiologist;
        document.getElementById('modalDate').value = surgery.date;
        document.getElementById('modalStartTime').value = surgery.startTime;
        document.getElementById('modalEndTime').value = surgery.endTime;
        document.getElementById('modalNotes').value = surgery.notes || '';
    } else {
        // Pre-fill date with current selected date
        document.getElementById('modalDate').value = formatDateKey(currentDate);
        document.getElementById('modalPatient').value = '';
        document.getElementById('modalProcedure').value = '';
        document.getElementById('modalOTRoom').value = '';
        document.getElementById('modalPriority').value = 'Normal';
        document.getElementById('modalSurgeon').value = '';
        document.getElementById('modalAnesthesiologist').value = '';
        document.getElementById('modalStartTime').value = '';
        document.getElementById('modalEndTime').value = '';
        document.getElementById('modalNotes').value = '';
    }
    
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeSurgeryModal() {
    document.getElementById('surgeryModal').style.display = 'none';
    document.body.style.overflow = '';
    editingSurgeryId = null;
}

function saveSurgery() {
    const patient = document.getElementById('modalPatient').value.trim();
    const procedure = document.getElementById('modalProcedure').value.trim();
    const otRoom = document.getElementById('modalOTRoom').value;
    const surgeon = document.getElementById('modalSurgeon').value;
    const date = document.getElementById('modalDate').value;
    
    if (!patient || !procedure || !otRoom || !surgeon || !date) {
        showToast('Please fill all required fields.', true);
        return;
    }
    
    const data = {
        patient, procedure, otRoom,
        priority: document.getElementById('modalPriority').value,
        surgeon,
        anesthesiologist: document.getElementById('modalAnesthesiologist').value,
        date,
        startTime: document.getElementById('modalStartTime').value || '08:00',
        endTime: document.getElementById('modalEndTime').value || '10:00',
        notes: document.getElementById('modalNotes').value,
        status: "Scheduled"
    };
    
    if (editingSurgeryId) {
        const idx = surgeries.findIndex(s => s.id === editingSurgeryId);
        if (idx !== -1) {
            surgeries[idx] = { ...surgeries[idx], ...data };
            showToast(`Surgery ${editingSurgeryId} updated successfully.`);
        }
    } else {
        data.id = generateId();
        surgeries.push(data);
        showToast(`New surgery booked: ${data.id}`);
    }
    
    closeSurgeryModal();
    updateAllViews();
}

function openDeleteModal(surgeryId) {
    deletingSurgeryId = surgeryId;
    const surgery = surgeries.find(s => s.id === surgeryId);
    document.getElementById('deleteModalMessage').textContent = `Are you sure you want to cancel "${surgery.procedure}" for patient ${surgery.patient}? This action cannot be undone.`;
    document.getElementById('deleteConfirmModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    document.getElementById('deleteConfirmModal').style.display = 'none';
    document.body.style.overflow = '';
    deletingSurgeryId = null;
}

function confirmDelete() {
    if (deletingSurgeryId) {
        const idx = surgeries.findIndex(s => s.id === deletingSurgeryId);
        if (idx !== -1) {
            surgeries[idx].status = "Cancelled";
            showToast(`Surgery ${deletingSurgeryId} cancelled.`);
        }
    }
    closeDeleteModal();
    updateAllViews();
}

// Modal event listeners
document.getElementById('closeSurgeryModal').addEventListener('click', closeSurgeryModal);
document.getElementById('cancelSurgeryBtn').addEventListener('click', closeSurgeryModal);
document.getElementById('saveSurgeryBtn').addEventListener('click', saveSurgery);
document.getElementById('closeDeleteModal').addEventListener('click', closeDeleteModal);
document.getElementById('cancelDeleteBtn').addEventListener('click', closeDeleteModal);
document.getElementById('confirmDeleteBtn').addEventListener('click', confirmDelete);
document.getElementById('surgeryModal').addEventListener('click', (e) => { if (e.target === e.currentTarget) closeSurgeryModal(); });
document.getElementById('deleteConfirmModal').addEventListener('click', (e) => { if (e.target === e.currentTarget) closeDeleteModal(); });

// ==================== CALENDAR ====================
function renderCalendar() {
    const container = document.getElementById('calendarContainer');
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const firstDay = new Date(year, month, 1);
    const startDayOfWeek = firstDay.getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const today = new Date();
    
    let html = `<div class="text-center mb-3 flex justify-between items-center px-2">
        <button id="prevMonthBtn" class="p-1 rounded hover:bg-gray-100"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg></button>
        <span class="font-semibold">${firstDay.toLocaleDateString('en-US', { month: 'long', year: 'numeric' })}</span>
        <button id="nextMonthBtn" class="p-1 rounded hover:bg-gray-100"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg></button>
    </div>`;
    html += `<div class="grid grid-cols-7 gap-1 text-center text-xs font-medium text-gray-500 mb-2"><div>Su</div><div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div></div><div class="grid grid-cols-7 gap-1">`;
    
    let dayCount = 1;
    for (let i = 0; i < 42; i++) {
        if (i < startDayOfWeek || dayCount > daysInMonth) {
            html += `<div class="h-9 w-9 flex items-center justify-center text-gray-300 text-sm"></div>`;
        } else {
            const cellDate = new Date(year, month, dayCount);
            const isSelected = cellDate.toDateString() === currentDate.toDateString();
            const isToday = cellDate.toDateString() === today.toDateString();
            let cls = 'calendar-day h-9 w-9 rounded-md text-sm transition-colors hover:bg-gray-100 cursor-pointer';
            if (isSelected) cls += ' bg-indigo-600 text-white hover:bg-indigo-700';
            else if (isToday) cls += ' border border-indigo-500 bg-indigo-50 font-bold';
            
            // Check if there are surgeries on this day
            const dateStr = formatDateKey(cellDate);
            const hasSurgery = surgeries.some(s => s.date === dateStr);
            if (hasSurgery && !isSelected) cls += ' font-semibold';
            
            html += `<button data-date="${dateStr}" class="${cls}">${dayCount}${hasSurgery && !isSelected ? '<span class="block w-1 h-1 bg-indigo-500 rounded-full mx-auto mt-0.5"></span>' : ''}</button>`;
            dayCount++;
        }
    }
    html += `</div>`;
    container.innerHTML = html;
    
    document.querySelectorAll('.calendar-day').forEach(btn => {
        btn.addEventListener('click', () => {
            const [y, m, d] = btn.dataset.date.split('-');
            currentDate = new Date(parseInt(y), parseInt(m)-1, parseInt(d));
            updateAllViews();
        });
    });
    document.getElementById('prevMonthBtn')?.addEventListener('click', () => { currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth()-1, 1); updateAllViews(); });
    document.getElementById('nextMonthBtn')?.addEventListener('click', () => { currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth()+1, 1); updateAllViews(); });
}

// ==================== DAY VIEW ====================
function renderDayView() {
    const filtered = getFilteredSurgeries(currentDate);
    const container = document.getElementById('dayViewPanel');
    const hours = [6,7,8,9,10,11,12,13,14,15,16,17];
    
    let html = `<div class="p-4 border-b"><h2 class="text-xl font-semibold">Daily OT Schedule</h2><p class="text-gray-500 text-sm">${formatDisplayDate(currentDate)} • ${currentRoomFilter === 'all' ? 'All Rooms' : currentRoomFilter} • ${currentSurgeonFilter === 'all' ? 'All Surgeons' : currentSurgeonFilter}</p></div><div class="p-4"><div class="space-y-1">`;
    
    hours.forEach(hour => {
        const hourLabel = hour === 12 ? "12:00 PM" : hour < 12 ? `${hour}:00 AM` : `${hour-12}:00 PM`;
        const surgeriesAtHour = filtered.filter(s => parseInt(s.startTime.split(':')[0]) === hour);
        
        html += `<div class="grid grid-cols-[80px_1fr] gap-4"><div class="text-sm text-gray-500 py-3">${hourLabel}</div><div class="border-t py-3 relative min-h-[50px]">`;
        
        if (surgeriesAtHour.length === 0) {
            html += `<div class="flex items-center justify-center h-full"><p class="text-sm text-gray-400">No surgeries</p></div>`;
        } else {
            surgeriesAtHour.forEach(s => {
                let borderColor = 'border-blue-500', bgClass = 'bg-blue-500/10';
                if (s.status === 'Completed') { borderColor = 'border-green-500'; bgClass = 'bg-green-500/10'; }
                else if (s.status === 'In Progress') { borderColor = 'border-blue-500'; bgClass = 'bg-blue-500/10'; }
                else if (s.status === 'Emergency') { borderColor = 'border-red-500'; bgClass = 'bg-red-500/10'; }
                else if (s.status === 'Pre-Op') { borderColor = 'border-purple-500'; bgClass = 'bg-purple-500/10'; }
                else if (s.status === 'Cancelled') { borderColor = 'border-gray-400'; bgClass = 'bg-gray-100'; }
                
                html += `<div class="rounded-md p-3 text-sm ${bgClass} border-l-4 ${borderColor} cursor-pointer hover:shadow-sm transition-shadow" data-surgery-id="${s.id}">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold">${s.procedure}</p>
                            <p class="text-xs text-gray-500">${s.patient} • ${s.startTime} - ${s.endTime}</p>
                        </div>
                        <span class="status-badge ${getStatusBadgeClass(s.status)}">${s.status}</span>
                    </div>
                    <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">
                        <span>🏥 ${s.otRoom}</span>
                        <span>👨‍⚕️ ${s.surgeon}</span>
                        ${s.priority === 'Critical' ? '<span class="text-red-500 font-semibold">⚠️ Critical</span>' : s.priority === 'High' ? '<span class="text-amber-500 font-semibold">⚡ High</span>' : ''}
                    </div>
                </div>`;
            });
        }
        html += `</div></div>`;
    });
    html += `</div></div>`;
    container.innerHTML = html;
    attachPopoverEvents(container);
}

// ==================== WEEK VIEW ====================
function renderWeekView() {
    const startOfWeek = new Date(currentDate);
    startOfWeek.setDate(currentDate.getDate() - currentDate.getDay());
    const weekDays = [];
    for (let i = 0; i < 7; i++) { const day = new Date(startOfWeek); day.setDate(startOfWeek.getDate() + i); weekDays.push(day); }
    
    const container = document.getElementById('weekViewPanel');
    let html = `<div class="p-4 border-b"><h2 class="text-xl font-semibold">Weekly OT Schedule</h2><p class="text-gray-500 text-sm">Week of ${weekDays[0].toLocaleDateString()} - ${weekDays[6].toLocaleDateString()}</p></div>
    <div class="p-4 overflow-x-auto">
        <div class="flex justify-between items-center mb-4">
            <button id="weekPrevBtn" class="inline-flex items-center gap-2 border rounded-md px-3 py-1.5 text-sm hover:bg-gray-100"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg> Prev Week</button>
            <button id="weekNextBtn" class="inline-flex items-center gap-2 border rounded-md px-3 py-1.5 text-sm hover:bg-gray-100">Next Week <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></button>
        </div>
        <div class="min-w-[800px]">
            <div class="grid grid-cols-8 gap-1 mb-2"><div class="h-12"></div>`;
    
    weekDays.forEach(day => {
        const isToday = day.toDateString() === currentDate.toDateString();
        html += `<div class="text-center p-2 font-medium ${isToday ? 'bg-indigo-500/10 rounded-t-md' : ''}"><div>${day.toLocaleDateString('en-US', { weekday: 'short' })}</div><div class="text-gray-500">${day.getDate()}</div></div>`;
    });
    html += `</div>`;
    
    const hours = [7,8,9,10,11,12,13,14,15,16,17];
    hours.forEach(hour => {
        html += `<div class="grid grid-cols-8 gap-1"><div class="text-sm text-gray-500 p-2 text-right">${hour === 12 ? '12 PM' : hour < 12 ? `${hour} AM` : `${hour-12} PM`}</div>`;
        weekDays.forEach(day => {
            const daySurgeries = getFilteredSurgeries(day).filter(s => parseInt(s.startTime.split(':')[0]) === hour);
            html += `<div class="border-t min-h-[70px] p-1"><div class="space-y-1">`;
            daySurgeries.forEach(s => {
                let borderColor = 'border-blue-500', bgClass = 'bg-blue-500/10';
                if (s.status === 'Completed') { borderColor = 'border-green-500'; bgClass = 'bg-green-500/10'; }
                else if (s.status === 'Emergency') { borderColor = 'border-red-500'; bgClass = 'bg-red-500/10'; }
                else if (s.status === 'Pre-Op') { borderColor = 'border-purple-500'; bgClass = 'bg-purple-500/10'; }
                
                html += `<div class="rounded text-xs p-1 ${bgClass} border-l-2 ${borderColor} cursor-pointer" data-surgery-id="${s.id}">
                    <div class="font-medium truncate">${s.procedure}</div>
                    <div class="text-[10px] text-gray-500">${s.startTime}-${s.endTime}</div>
                    <div class="text-[10px]">${s.otRoom} • ${s.surgeon}</div>
                </div>`;
            });
            html += `</div></div>`;
        });
        html += `</div>`;
    });
    html += `</div></div>`;
    container.innerHTML = html;
    attachPopoverEvents(container);
    document.getElementById('weekPrevBtn')?.addEventListener('click', () => { currentDate.setDate(currentDate.getDate() - 7); updateAllViews(); });
    document.getElementById('weekNextBtn')?.addEventListener('click', () => { currentDate.setDate(currentDate.getDate() + 7); updateAllViews(); });
}

// ==================== MONTH VIEW ====================
function renderMonthView() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const firstDay = new Date(year, month, 1);
    const startDayOfWeek = firstDay.getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const container = document.getElementById('monthViewPanel');
    const today = new Date();
    
    let html = `<div class="p-4 border-b"><h2 class="text-xl font-semibold">Monthly OT Schedule</h2><p class="text-gray-500 text-sm">${firstDay.toLocaleDateString('en-US', { month: 'long', year: 'numeric' })}</p></div>
    <div class="p-4">
        <div class="flex justify-between items-center mb-4">
            <button id="monthPrevBtn" class="inline-flex items-center gap-2 border rounded-md px-3 py-1.5 text-sm hover:bg-gray-100"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg> Prev</button>
            <button id="monthNextBtn" class="inline-flex items-center gap-2 border rounded-md px-3 py-1.5 text-sm hover:bg-gray-100">Next <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></button>
        </div>
        <div class="grid grid-cols-7 gap-1 text-center mb-2">
            <div class="font-medium text-sm">Sun</div><div class="font-medium text-sm">Mon</div><div class="font-medium text-sm">Tue</div><div class="font-medium text-sm">Wed</div><div class="font-medium text-sm">Thu</div><div class="font-medium text-sm">Fri</div><div class="font-medium text-sm">Sat</div>
        </div>
        <div class="grid grid-cols-7 gap-1">`;
    
    let dayCount = 1;
    for (let i = 0; i < 42; i++) {
        if (i < startDayOfWeek || dayCount > daysInMonth) {
            html += `<div class="min-h-[90px] border rounded-md p-2 bg-gray-50 opacity-50"><div class="text-right text-sm mb-1 text-gray-400">${i < startDayOfWeek ? new Date(year, month, 0).getDate() - (startDayOfWeek - i - 1) : dayCount - daysInMonth}</div></div>`;
            if (i >= startDayOfWeek) dayCount++;
        } else {
            const cellDate = new Date(year, month, dayCount);
            const isToday = cellDate.toDateString() === today.toDateString();
            const cellSurgeries = getFilteredSurgeries(cellDate);
            
            html += `<div class="min-h-[90px] border rounded-md p-2 ${isToday ? 'border-indigo-500 bg-indigo-50' : ''}">
                <div class="text-right text-sm mb-1 ${isToday ? 'font-bold text-indigo-600' : ''}">${dayCount}</div>
                <div class="space-y-1">`;
            
            cellSurgeries.slice(0, 3).forEach(s => {
                let bgClass = 'bg-blue-500/10';
                if (s.status === 'Completed') bgClass = 'bg-green-500/10';
                else if (s.status === 'Emergency') bgClass = 'bg-red-500/10';
                
                html += `<div class="rounded text-xs p-1 ${bgClass} cursor-pointer" data-surgery-id="${s.id}">
                    <div class="truncate font-medium">${s.procedure}</div>
                    <div class="text-[10px] text-gray-500 truncate">${s.startTime} • ${s.otRoom}</div>
                </div>`;
            });
            if (cellSurgeries.length > 3) html += `<div class="text-xs text-center text-indigo-500">+${cellSurgeries.length-3} more</div>`;
            html += `</div></div>`;
            dayCount++;
        }
    }
    html += `</div></div>`;
    container.innerHTML = html;
    attachPopoverEvents(container);
    document.getElementById('monthPrevBtn')?.addEventListener('click', () => { currentDate = new Date(year, month-1, 1); updateAllViews(); });
    document.getElementById('monthNextBtn')?.addEventListener('click', () => { currentDate = new Date(year, month+1, 1); updateAllViews(); });
}

// ==================== LIST VIEW ====================
function renderListView() {
    const filtered = getFilteredSurgeries(currentDate);
    const container = document.getElementById('listViewPanel');
    
    if (filtered.length === 0) {
        container.innerHTML = `<div class="p-8 text-center text-gray-500">No surgeries scheduled for ${formatDisplayDate(currentDate)}.</div>`;
        return;
    }
    
    let html = `<div class="p-4 border-b"><h2 class="text-xl font-semibold">Surgery List</h2><p class="text-gray-500 text-sm">${formatDisplayDate(currentDate)} • ${filtered.length} surgeries</p></div><div class="p-4">
        <div class="border rounded-md overflow-auto"><table class="w-full text-sm">
            <thead><tr class="border-b bg-gray-50">
                <th class="h-10 px-3 text-left font-medium">ID</th><th class="h-10 px-3 text-left font-medium">Patient</th><th class="h-10 px-3 text-left font-medium">Procedure</th><th class="h-10 px-3 text-left font-medium">OT Room</th><th class="h-10 px-3 text-left font-medium">Surgeon</th><th class="h-10 px-3 text-left font-medium">Time</th><th class="h-10 px-3 text-left font-medium">Status</th><th class="h-10 px-3 text-right font-medium">Actions</th>
            </tr></thead>
            <tbody>`;
    
    filtered.forEach(s => {
        html += `<tr class="border-b hover:bg-gray-50 transition-colors">
            <td class="p-3 font-medium">${s.id}</td>
            <td class="p-3">${s.patient}</td>
            <td class="p-3">${s.procedure}</td>
            <td class="p-3">${s.otRoom}</td>
            <td class="p-3">${s.surgeon}</td>
            <td class="p-3">${s.startTime} - ${s.endTime}</td>
            <td class="p-3"><span class="status-badge ${getStatusBadgeClass(s.status)}">${s.status}</span></td>
            <td class="p-3 text-right"><button class="action-btn inline-flex items-center justify-center rounded-md hover:bg-gray-200 h-8 w-8" data-surgery-id="${s.id}"><svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg></button></td>
        </tr>`;
    });
    
    html += `</tbody></table></div></div>`;
    container.innerHTML = html;
    attachPopoverEvents(container);
}

// ==================== POPOVER BINDING ====================
function attachPopoverEvents(container) {
    container.querySelectorAll('[data-surgery-id]').forEach(el => {
        el.addEventListener('click', (e) => {
            e.stopPropagation();
            const surgeryId = el.dataset.surgeryId;
            const surgery = surgeries.find(s => s.id === surgeryId);
            if (surgery) showPopover(el, surgery);
        });
    });
}

// ==================== UPDATE ALL VIEWS ====================
function updateAllViews() {
    renderCalendar();
    if (currentTab === 'day') renderDayView();
    else if (currentTab === 'week') renderWeekView();
    else if (currentTab === 'month') renderMonthView();
    else if (currentTab === 'list') renderListView();
    document.getElementById('currentDateDisplay').innerText = formatDisplayDate(currentDate);
}

// ==================== TAB SWITCHING ====================
function initTabs() {
    const tabs = document.querySelectorAll('.schedule-tab');
    const panels = {
        day: document.getElementById('dayViewPanel'),
        week: document.getElementById('weekViewPanel'),
        month: document.getElementById('monthViewPanel'),
        list: document.getElementById('listViewPanel')
    };
    
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const tabId = tab.dataset.tab;
            currentTab = tabId;
            tabs.forEach(t => { t.classList.remove('bg-white', 'text-gray-900', 'shadow-sm'); t.classList.add('text-gray-600'); });
            tab.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
            Object.keys(panels).forEach(key => panels[key].classList.remove('active'));
            panels[tabId].classList.add('active');
            updateAllViews();
        });
    });
}

// ==================== DROPDOWNS ====================
function initRoomSelect() {
    const trigger = document.getElementById('roomSelectTrigger');
    const dropdown = document.getElementById('roomSelectDropdown');
    trigger.addEventListener('click', (e) => { e.stopPropagation(); dropdown.classList.toggle('hidden'); document.getElementById('surgeonSelectDropdown')?.classList.add('hidden'); });
    document.querySelectorAll('.room-option').forEach(opt => {
        opt.addEventListener('click', () => {
            currentRoomFilter = opt.dataset.value;
            document.getElementById('selectedRoomText').innerText = opt.innerText;
            dropdown.classList.add('hidden');
            updateAllViews();
        });
    });
}

function initSurgeonSelect() {
    const trigger = document.getElementById('surgeonSelectTrigger');
    const dropdown = document.getElementById('surgeonSelectDropdown');
    trigger.addEventListener('click', (e) => { e.stopPropagation(); dropdown.classList.toggle('hidden'); document.getElementById('roomSelectDropdown')?.classList.add('hidden'); });
    document.querySelectorAll('.surgeon-option').forEach(opt => {
        opt.addEventListener('click', () => {
            currentSurgeonFilter = opt.dataset.value;
            document.getElementById('selectedSurgeonText').innerText = opt.innerText;
            dropdown.classList.add('hidden');
            updateAllViews();
        });
    });
}

document.addEventListener('click', (e) => {
    if (!e.target.closest('#roomSelectContainer')) document.getElementById('roomSelectDropdown')?.classList.add('hidden');
    if (!e.target.closest('#surgeonSelectContainer')) document.getElementById('surgeonSelectDropdown')?.classList.add('hidden');
});

// ==================== NAVIGATION ====================
document.getElementById('prevDateBtn')?.addEventListener('click', () => { currentDate.setDate(currentDate.getDate() - 1); updateAllViews(); });
document.getElementById('nextDateBtn')?.addEventListener('click', () => { currentDate.setDate(currentDate.getDate() + 1); updateAllViews(); });
document.getElementById('todayBtn')?.addEventListener('click', () => { currentDate = new Date(); updateAllViews(); });

// Keyboard
document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { closePopover(); closeSurgeryModal(); closeDeleteModal(); } });

// Init
initTabs();
initRoomSelect();
initSurgeonSelect();
updateAllViews();
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
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Blood Donors Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    </script>    <script src="https://cdn.jsdelivr.net/npm/apexcharts" crossorigin="anonymous"></script>
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .rounded-lg.border { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700, 
        body.dark .text-card-foreground, body.dark .text-foreground { color: #e5e5e5 !important; }
        body.dark .text-muted-foreground { color: #9ca3af !important; }
        body.dark .bg-gray-100, body.dark .bg-muted, body.dark .bg-gray-50 { background-color: #262626 !important; }
        body.dark .border-gray-200, body.dark .border-input, body.dark .border { border-color: #333 !important; }
        body.dark .bg-blue-50 { background-color: #1e3a5f !important; }
        body.dark .text-blue-800 { color: #93c5fd !important; }
        body.dark .bg-red-500\/10 { background-color: rgba(239, 68, 68, 0.1) !important; }
        body.dark .bg-green-500\/10 { background-color: rgba(34, 197, 94, 0.1) !important; }
        body.dark .bg-blue-500\/10 { background-color: rgba(59, 130, 246, 0.1) !important; }
        body.dark .bg-purple-500\/10 { background-color: rgba(168, 85, 247, 0.1) !important; }
        body.dark .bg-amber-500\/10 { background-color: rgba(245, 158, 11, 0.1) !important; }
        body.dark .bg-zinc-500\/10 { background-color: rgba(113, 113, 122, 0.1) !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        body.dark ::-webkit-scrollbar-track { background: #2a2a2a; }
        body.dark ::-webkit-scrollbar-thumb { background: #555; }
        
        .tab-panel.hidden { display: none; }
        [role="tab"][data-state="active"] { background: white; color: #1f2937; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        body.dark [role="tab"][data-state="active"] { background: #131212; color: #e5e5e5; }
        
        /* Modern Action Menu */
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
        body.dark .action-menu { background: #2a2a2a; border-color: #404040; }
        .action-menu-header { padding: 0.5rem 0.75rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb; margin-bottom: 0.25rem; }
        body.dark .action-menu-header { color: #9ca3af; border-bottom-color: #404040; }
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
            color: inherit;
            text-align: left;
        }
        .action-item:hover { background-color: #f3f4f6; }
        body.dark .action-item:hover { background-color: #3f3f46; }
        .action-divider { height: 1px; background-color: #e5e7eb; margin: 0.25rem 0; }
        body.dark .action-divider { background-color: #404040; }
        .text-red-600 { color: #dc2626; }
        .text-red-600:hover { background-color: #fee2e2; }
        body.dark .text-red-600:hover { background-color: #7f1d1d; color: #fecaca; }
        
        @keyframes fadeInScale { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        
        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgb(0 0 0 / 87%);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            animation: fadeIn 0.2s ease-out;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        
        .modal-container {
            background: white;
            border-radius: 0.75rem;
            width: 100%;
            animation: slideUp 0.2s ease;
            position: relative;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        }
        body.dark .modal-container { background: #1e1e1e; border: 1px solid #333; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        
        .select-trigger {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 40px;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            background-color: white;
            padding: 0 0.75rem;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.1s;
        }
        body.dark .select-trigger { background-color: #262626; border-color: #404040; color: #e5e5e5; }
        .select-content {
            position: absolute;
            z-index: 100;
            background-color: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            overflow: hidden;
            min-width: 150px;
        }
        body.dark .select-content { background-color: #2a2a2a; border-color: #404040; }
        .select-item { padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer; transition: background 0.1s; }
        .select-item:hover { background-color: #f3f4f6; }
        body.dark .select-item:hover { background-color: #3f3f46; }
        
        .toast-message { position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white; padding: 12px 20px; border-radius: 8px; z-index: 11000; animation: slideIn 0.3s ease-out; font-size: 0.875rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        
        .apexcharts-canvas { background-color: transparent !important; }
        body.dark .apexcharts-text, body.dark .apexcharts-legend-text { fill: #e5e5e5 !important; color: #e5e5e5 !important; }
        body.dark .apexcharts-grid line { stroke: #404040 !important; }
        body.dark .apexcharts-grid-borders line { stroke: #404040 !important; }
        
        /* Donor Card Styles */
        .donor-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        body.dark .donor-card {
            background: linear-gradient(135deg, #4c51bf 0%, #5b3a8c 100%);
        }
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
            <div class="flex flex-col gap-5">
                <!-- Header -->
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-2xl lg:text-3xl font-bold tracking-tight">Blood Donors</h2>
                        <p class="text-gray-500">Manage and track blood donors in your blood bank</p>
                    </div>
                    <a href="edit-donor.html" class="bg-primary inline-flex items-center justify-center gap-2 rounded-md h-10 px-4 py-2 text-sm font-medium text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowmr-2 h-4 w-4"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
                        Register New Donor
                    </a>
                </div>

                <!-- Stats Cards -->
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-lg p-4 text-card-foreground border bg-white dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex items-center justify-between"><h2 class="text-sm font-medium text-gray-500">Total Donors</h2><svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></div><div class="text-2xl font-bold mt-2" id="totalDonors">247</div><p class="text-xs text-gray-500">+12 from last month</p></div>
                    <div class="rounded-lg p-4 text-card-foreground border bg-white dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex items-center justify-between"><h2 class="text-sm font-medium text-gray-500">Donations This Month</h2><svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path><path d="M8 2v4"></path><path d="M16 2v4"></path></svg></div><div class="text-2xl font-bold mt-2">38</div><p class="text-xs text-gray-500">+5 compared to last month</p></div>
                    <div class="rounded-lg p-4 text-card-foreground border bg-white dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex items-center justify-between"><h2 class="text-sm font-medium text-gray-500">Eligible Donors</h2><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-800">Active</span></div><div class="text-2xl font-bold mt-2" id="eligibleCount">183</div><p class="text-xs text-gray-500">Ready for donation</p></div>
                    <div class="rounded-lg p-4 text-card-foreground border bg-white dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex items-center justify-between"><h2 class="text-sm font-medium text-gray-500">Frequent Donors</h2><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold bg-purple-100 text-purple-800">VIP</span></div><div class="text-2xl font-bold mt-2">42</div><p class="text-xs text-gray-500">5+ donations</p></div>
                </div>

                <!-- Charts Row -->
                <div class="grid gap-4 md:grid-cols-2">
                    <div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h2 class="text-xl font-semibold">Donors by Blood Type</h2><div class="text-gray-500">Distribution of registered donors by blood type</div></div><div class="p-4"><div id="bloodTypeChart" class="h-[300px] w-full"></div></div></div>
                    <div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h2 class="text-xl font-semibold">Donation Frequency</h2><div class="text-gray-500">Number of donors by donation frequency</div></div><div class="p-4"><div id="frequencyChart" class="h-[300px] w-full"></div></div></div>
                </div>

                <!-- Filters -->
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="flex flex-1 items-center gap-2 flex-wrap">
                        <div class="relative flex-1 md:w-[250px] md:flex-initial"><svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg><input id="searchInput" type="search" placeholder="Search donors..." class="h-10 w-full rounded-md border border-gray-300 pl-8 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div>
                        <div class="filter-group relative"><button id="bloodTypeBtn" class="select-trigger w-[150px]"><span id="bloodTypeText">All Blood Types</span><svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="m6 9 6 6 6-6"></path></svg></button><div id="bloodTypeDropdown" class="select-content hidden"></div></div>
                        <div class="filter-group relative"><button id="statusBtn" class="select-trigger w-[150px]"><span id="statusText">All Statuses</span><svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="m6 9 6 6 6-6"></path></svg></button><div id="statusDropdown" class="select-content hidden"></div></div>
                        <button id="resetFiltersBtn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background size-10" title="Reset Filters"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path><path d="M8 16H3v5"></path></svg></button>
                    </div>
                    <div class="flex items-center gap-2">
                        
                        <button id="exportBtn" class="inline-flex items-center justify-center gap-2 rounded-md border border-gray-300 bg-background h-9 px-3 text-sm"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg>Export</button>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="w-full">
                    <div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-muted p-1 text-gray-500">
                        <button type="button" data-tab="all" class="tab-trigger inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all" data-state="active">All Donors</button>
                        <button type="button" data-tab="eligible" class="tab-trigger inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all" data-state="inactive">Eligible</button>
                        <button type="button" data-tab="ineligible" class="tab-trigger inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all" data-state="inactive">Ineligible</button>
                        <button type="button" data-tab="new" class="tab-trigger inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all" data-state="inactive">New</button>
                    </div>

                    <div id="tab-all" class="tab-panel mt-2 border rounded-md"><div class="relative w-full overflow-auto"><table class="w-full caption-bottom text-sm whitespace-nowrap"><thead><tr class="border-b"><th class="h-12 px-4 text-left font-medium sort-header" data-sort="name">Donor <span class="sort-icon">↕</span></th><th class="h-12 px-4 text-left font-medium sort-header" data-sort="bloodType">Blood Type <span class="sort-icon">↕</span></th><th class="h-12 px-4 text-left font-medium">Contact</th><th class="h-12 px-4 text-left font-medium sort-header" data-sort="lastDonation">Last Donation <span class="sort-icon">↕</span></th><th class="h-12 px-4 text-left font-medium sort-header" data-sort="status">Status <span class="sort-icon">↕</span></th><th class="h-12 px-4 text-left font-medium sort-header" data-sort="totalDonations">Total Donations <span class="sort-icon">↕</span></th><th class="h-12 px-4 text-left font-medium sort-header" data-sort="nextEligible">Next Eligible <span class="sort-icon">↕</span></th><th class="h-12 px-4 text-left font-medium"></th></tr></thead><tbody id="allDonorsBody"></tbody></table></div></div>
                    <div id="tab-eligible" class="tab-panel hidden mt-2 border rounded-md"><div class="relative w-full overflow-auto"><table class="w-full caption-bottom text-sm whitespace-nowrap"><thead><tr class="border-b"><th class="h-12 px-4 text-left font-medium">Donor</th><th class="h-12 px-4 text-left font-medium">Blood Type</th><th class="h-12 px-4 text-left font-medium">Contact</th><th class="h-12 px-4 text-left font-medium">Last Donation</th><th class="h-12 px-4 text-left font-medium">Status</th><th class="h-12 px-4 text-left font-medium">Total Donations</th><th class="h-12 px-4 text-left font-medium">Next Eligible</th><th class="h-12 px-4 text-left font-medium"></th></tr></thead><tbody id="eligibleDonorsBody"></tbody></table></div></div>
                    <div id="tab-ineligible" class="tab-panel hidden mt-2 border rounded-md"><div class="relative w-full overflow-auto"><table class="w-full caption-bottom text-sm whitespace-nowrap"><thead><tr class="border-b"><th class="h-12 px-4 text-left font-medium">Donor</th><th class="h-12 px-4 text-left font-medium">Blood Type</th><th class="h-12 px-4 text-left font-medium">Contact</th><th class="h-12 px-4 text-left font-medium">Last Donation</th><th class="h-12 px-4 text-left font-medium">Status</th><th class="h-12 px-4 text-left font-medium">Total Donations</th><th class="h-12 px-4 text-left font-medium">Next Eligible</th><th class="h-12 px-4 text-left font-medium"></th></tr></thead><tbody id="ineligibleDonorsBody"></tbody></table></div></div>
                    <div id="tab-new" class="tab-panel hidden mt-2 border rounded-md"><div class="relative w-full overflow-auto"><table class="w-full caption-bottom text-sm whitespace-nowrap"><thead><tr class="border-b"><th class="h-12 px-4 text-left font-medium">Donor</th><th class="h-12 px-4 text-left font-medium">Blood Type</th><th class="h-12 px-4 text-left font-medium">Contact</th><th class="h-12 px-4 text-left font-medium">Last Donation</th><th class="h-12 px-4 text-left font-medium">Status</th><th class="h-12 px-4 text-left font-medium">Total Donations</th><th class="h-12 px-4 text-left font-medium">Next Eligible</th><th class="h-12 px-4 text-left font-medium"></th></tr></thead><tbody id="newDonorsBody"></tbody></table></div></div>
                </div>

                <!-- Pagination Info -->
                <div class="flex items-center justify-between"><div class="text-gray-500" id="paginationInfo"></div><div class="flex items-center gap-2"><button id="prevPageBtn" class="inline-flex rounded-md border px-3 py-1 text-sm h-10 disabled:opacity-50 disabled:cursor-not-allowed" disabled>Previous</button><button id="nextPageBtn" class="inline-flex rounded-md border px-3 py-1 text-sm h-10 disabled:opacity-50 disabled:cursor-not-allowed" disabled>Next</button></div></div>

                <!-- Info Banner -->
                <div class="flex items-center rounded-md bg-blue-50 p-4 text-blue-800"><svg class="mr-2 size-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg><p class="text-sm">Regular blood donation helps save lives. Donors can donate every 56 days for whole blood donation.</p></div>
            </div>
        </main>
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

// ==================== TOAST FUNCTION ====================
function showToast(message, isError = false) { const existing = document.querySelector('.toast-message'); if (existing) existing.remove(); const toast = document.createElement('div'); toast.className = `toast-message ${isError ? 'error' : ''}`; toast.textContent = message; document.body.appendChild(toast); setTimeout(() => toast.remove(), 3000); }

// ==================== DONOR DATA ====================
const allDonors = [
    { id: "D-1001", name: "Okello David", bloodType: "O+", phone: "+256 712 345 678", email: "okello.david@hmail.com", lastDonation: "2023-03-15", status: "Eligible", totalDonations: 8, nextEligible: "2023-07-15", donorTier: "Silver Donor" },
    { id: "D-1002", name: "Nakato Sarah", bloodType: "A-", phone: "+1 +256 712 987 654", email: "nakato.sarah@hmail.com", lastDonation: "2023-05-22", status: "Ineligible", totalDonations: 3, nextEligible: "2023-09-22", donorTier: "Regular" },
    { id: "D-1003", name: "Mwangi Peter", bloodType: "B+", phone: "+256 712 345 681", email: "mchen@hmail.com", lastDonation: "2023-01-10", status: "Eligible", totalDonations: 12, nextEligible: "2023-05-10", donorTier: "Gold Donor" },
    { id: "D-1004", name: "Emily Rodriguez", bloodType: "AB+", phone: "+256 712 345 679", email: "emily.r@hmail.com", lastDonation: null, status: "New Donor", totalDonations: 0, nextEligible: "N/A", donorTier: "New" },
    { id: "D-1005", name: "Mukasa David", bloodType: "O-", phone: "+1 (555) 876-5432", email: "dwilson@hmail.com", lastDonation: "2023-04-05", status: "Eligible", totalDonations: 25, nextEligible: "2023-08-05", donorTier: "Platinum Donor" },
    { id: "D-1006", name: "Nabwire Lisa", bloodType: "A+", phone: "+256 712 345 680", email: "lisa.t@hmail.com", lastDonation: "2023-06-18", status: "Ineligible", totalDonations: 5, nextEligible: "2023-10-18", donorTier: "Silver Donor" }
];

// Donation history data
const donationHistory = {
    "D-1001": [{ date: "2023-03-15", type: "Whole Blood", bloodUnit: "BU-5678", volume: "450 ml", location: "Main Clinic", status: "Completed" }, { date: "2022-11-20", type: "Whole Blood", bloodUnit: "BU-4567", volume: "450 ml", location: "Mobile Drive - City Square (Kampala)", status: "Completed" }],
    "D-1002": [{ date: "2023-05-22", type: "Plasma", bloodUnit: "BU-6789", volume: "600 ml", location: "Main Clinic", status: "Completed" }],
    "D-1003": [{ date: "2023-01-10", type: "Whole Blood", bloodUnit: "BU-3456", volume: "450 ml", location: "Nakasero Blood Bank", status: "Completed" }, { date: "2022-09-05", type: "Platelets", bloodUnit: "BU-2345", volume: "250 ml", location: "Main Clinic", status: "Completed" }],
    "D-1005": [{ date: "2023-04-05", type: "Double Red Cells", bloodUnit: "BU-7890", volume: "500 ml", location: "Bugolobi Branch", status: "Completed" }, { date: "2023-01-15", type: "Whole Blood", bloodUnit: "BU-1234", volume: "450 ml", location: "Main Clinic", status: "Completed" }]
};

let currentTab = "all", searchQuery = "", bloodTypeFilter = "all", statusFilter = "all", currentSort = { column: "name", direction: "asc" }, currentPage = 1;
const itemsPerPage = 5, bloodTypes = ["A+", "A-", "B+", "B-", "AB+", "AB-", "O+", "O-"], statuses = ["Eligible", "Ineligible", "New Donor"];
let activeActionMenu = null, activeModal = null, pendingDeleteDonor = null;

function closeActionMenu() { if (activeActionMenu) { activeActionMenu.remove(); activeActionMenu = null; } }
function closeModal() { if (activeModal) { activeModal.remove(); activeModal = null; } document.body.style.overflow = ''; }

function getInitials(name) { return name.split(' ').map(n => n[0]).join(''); }
function getBloodTypeColor(type) { const colors = { 'O+': 'bg-red-500/10 text-red-500 border-red-500/20', 'O-': 'bg-red-500/10 text-red-500 border-red-500/20', 'A+': 'bg-blue-500/10 text-blue-500 border-blue-500/20', 'A-': 'bg-blue-500/10 text-blue-500 border-blue-500/20', 'B+': 'bg-green-500/10 text-green-500 border-green-500/20', 'B-': 'bg-green-500/10 text-green-500 border-green-500/20', 'AB+': 'bg-purple-500/10 text-purple-500 border-purple-500/20', 'AB-': 'bg-purple-500/10 text-purple-500 border-purple-500/20' }; return colors[type] || 'bg-gray-500/10 text-gray-500 border-gray-500/20'; }
function getStatusColor(status) { if (status === 'Eligible') return 'bg-green-500 text-white'; if (status === 'Ineligible') return 'bg-red-500 text-white'; return 'bg-yellow-500 text-white'; }
function getTierColor(tier) { if (tier === 'Platinum Donor') return 'bg-purple-500/10 text-purple-500 border-purple-500/20'; if (tier === 'Gold Donor') return 'bg-amber-500/10 text-amber-500 border-amber-500/20'; if (tier === 'Silver Donor') return 'bg-zinc-500/10 text-zinc-500 border-zinc-500/20'; return ''; }
function formatDate(dateStr) { if (!dateStr) return 'Never donated'; const date = new Date(dateStr); return `${date.getMonth()+1}/${date.getDate()}/${date.getFullYear()}`; }

// ==================== DELETE MODAL ====================
function openDeleteModal(donor) {
    pendingDeleteDonor = donor;
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-background p-6 shadow-lg duration-200 sm:rounded-lg">
            <div class="flex flex-col space-y-2 text-center sm:text-left">
                <h2 class="text-lg font-semibold">Are you sure you want to delete this donor?</h2>
                <p class="text-sm text-muted-foreground">This action cannot be undone. This will permanently delete the donor record for <strong>${donor.name}</strong> and remove them from the blood bank system.${donor.totalDonations > 0 ? `<span class="mt-2 block text-red-500">Warning: This donor has ${donor.totalDonations} donation${donor.totalDonations !== 1 ? 's' : ''} recorded. Deleting will also remove donation history.</span>` : ''}</p>
            </div>
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
                <button class="cancel-delete inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 mt-2 sm:mt-0">Cancel</button>
                <button class="confirm-delete inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium h-10 px-4 py-2 bg-red-500 text-white hover:bg-red-700">Delete</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    activeModal = modal;
    document.body.style.overflow = 'hidden';
    modal.querySelector('.cancel-delete')?.addEventListener('click', closeModal);
    modal.querySelector('.confirm-delete')?.addEventListener('click', () => { const index = allDonors.findIndex(d => d.id === donor.id); if (index !== -1) { allDonors.splice(index, 1); renderAllTables(); showToast(`Donor "${donor.name}" deleted successfully.`); } closeModal(); });
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
}

// ==================== SCHEDULE DONATION MODAL ====================
// ==================== SCHEDULE DONATION MODAL (RADIX UI) ====================
function openScheduleModal(donor) {
    closeModal();
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div style="background:white;border-radius:0.75rem;width:90%;max-width:550px;max-height:85vh;overflow-y:auto;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);animation:modalSlideIn 0.2s ease-out;">
            <div style="display:flex;justify-content:space-between;align-items:center;padding:1.25rem 1.5rem;border-bottom:1px solid #e5e7eb;">
                <h2 style="font-size:1.125rem;font-weight:600;">Schedule Donation - ${donor.name}</h2>
                <button class="close-schedule-modal" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#6b7280;line-height:1;padding:0;">&times;</button>
            </div>
            <div style="padding:1.5rem;">
                <div style="display:flex;flex-direction:column;gap:1rem;">
                    <!-- Donation Type -->
                    <div>
                        <label style="display:block;font-size:0.875rem;font-weight:500;color:#374151;margin-bottom:0.25rem;">Donation Type *</label>
                        <div class="radix-select-wrapper" style="position:relative;">
                            <button type="button" id="donationTypeBtn" class="radix-select-trigger" style="display:flex;align-items:center;justify-content:space-between;width:100%;height:40px;border-radius:0.375rem;border:1px solid #d1d5db;background:white;padding:0 0.75rem;font-size:0.875rem;cursor:pointer;text-align:left;">
                                <span id="donationTypeText">Whole Blood</span>
                                <svg style="width:1rem;height:1rem;opacity:0.5;flex-shrink:0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </button>
                            <div id="donationTypeDropdown" class="radix-select-dropdown hidden" style="position:absolute;z-index:60;top:100%;left:0;right:0;margin-top:4px;background:white;border-radius:0.5rem;border:1px solid #e5e7eb;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);overflow:hidden;animation:fadeInScale 0.12s ease-out;">
                                <div class="radix-select-item" data-value="Whole Blood" style="padding:0.5rem 0.75rem;font-size:0.875rem;cursor:pointer;display:flex;align-items:center;gap:0.5rem;transition:background 0.1s;">
                                    Whole Blood</div>
                                <div class="radix-select-item" data-value="Plasma" style="padding:0.5rem 0.75rem;font-size:0.875rem;cursor:pointer;display:flex;align-items:center;gap:0.5rem;transition:background 0.1s;">
                                    Plasma</div>
                                <div class="radix-select-item" data-value="Platelets" style="padding:0.5rem 0.75rem;font-size:0.875rem;cursor:pointer;display:flex;align-items:center;gap:0.5rem;transition:background 0.1s;">
                                    Platelets</div>
                                <div class="radix-select-item" data-value="Double Red Cells" style="padding:0.5rem 0.75rem;font-size:0.875rem;cursor:pointer;display:flex;align-items:center;gap:0.5rem;transition:background 0.1s;">
                                    Double Red Cells</div>
                            </div>
                        </div>
                    </div>
                    <!-- Date and Time -->
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div><label style="display:block;font-size:0.875rem;font-weight:500;color:#374151;margin-bottom:0.25rem;">Date *</label><input type="date" id="donationDate" style="width:100%;border-radius:0.375rem;border:1px solid #d1d5db;padding:0.5rem 0.75rem;font-size:0.875rem;background:white;"></div>
                        <div><label style="display:block;font-size:0.875rem;font-weight:500;color:#374151;margin-bottom:0.25rem;">Time *</label><input type="time" id="donationTime" value="09:00" style="width:100%;border-radius:0.375rem;border:1px solid #d1d5db;padding:0.5rem 0.75rem;font-size:0.875rem;background:white;"></div>
                    </div>
                    <!-- Location -->
                    <div>
                        <label style="display:block;font-size:0.875rem;font-weight:500;color:#374151;margin-bottom:0.25rem;">Location *</label>
                        <div class="radix-select-wrapper" style="position:relative;">
                            <button type="button" id="donationLocationBtn" class="radix-select-trigger" style="display:flex;align-items:center;justify-content:space-between;width:100%;height:40px;border-radius:0.375rem;border:1px solid #d1d5db;background:white;padding:0 0.75rem;font-size:0.875rem;cursor:pointer;text-align:left;">
                                <span id="donationLocationText">Main Clinic - Blood Bank</span>
                                <svg style="width:1rem;height:1rem;opacity:0.5;flex-shrink:0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </button>
                            <div id="donationLocationDropdown" class="radix-select-dropdown hidden" style="position:absolute;z-index:60;top:100%;left:0;right:0;margin-top:4px;background:white;border-radius:0.5rem;border:1px solid #e5e7eb;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);overflow:hidden;animation:fadeInScale 0.12s ease-out;">
                                <div class="radix-select-item" data-value="Main Clinic" style="padding:0.5rem 0.75rem;font-size:0.875rem;cursor:pointer;display:flex;align-items:center;gap:0.5rem;transition:background 0.1s;">
                                    
                                    Main Clinic - Blood Bank</div>
                                <div class="radix-select-item" data-value="Mobile Drive - City Square (Kampala)" style="padding:0.5rem 0.75rem;font-size:0.875rem;cursor:pointer;display:flex;align-items:center;gap:0.5rem;transition:background 0.1s;">
                                    
                                    Mobile Drive - City Square (Kampala)</div>
                                <div class="radix-select-item" data-value="Mobile Drive - Makerere University" style="padding:0.5rem 0.75rem;font-size:0.875rem;cursor:pointer;display:flex;align-items:center;gap:0.5rem;transition:background 0.1s;">
                                    
                                    Mobile Drive - Makerere University</div>
                                <div class="radix-select-item" data-value="Mobile Drive - Community Center" style="padding:0.5rem 0.75rem;font-size:0.875rem;cursor:pointer;display:flex;align-items:center;gap:0.5rem;transition:background 0.1s;">
                                    
                                    Mobile Drive - Community Center</div>
                                <div class="radix-select-item" data-value="OPD Wing Clinic" style="padding:0.5rem 0.75rem;font-size:0.875rem;cursor:pointer;display:flex;align-items:center;gap:0.5rem;transition:background 0.1s;">
                                    
                                    OPD Wing Clinic</div>
                            </div>
                        </div>
                    </div>
                    <!-- Phlebotomist -->
                    <div>
                        <label style="display:block;font-size:0.875rem;font-weight:500;color:#374151;margin-bottom:0.25rem;">Assigned Phlebotomist</label>
                        <div class="radix-select-wrapper" style="position:relative;">
                            <button type="button" id="phlebotomistBtn" class="radix-select-trigger" style="display:flex;align-items:center;justify-content:space-between;width:100%;height:40px;border-radius:0.375rem;border:1px solid #d1d5db;background:white;padding:0 0.75rem;font-size:0.875rem;cursor:pointer;text-align:left;">
                                <span id="phlebotomistText" style="color:#9ca3af;">Select phlebotomist (optional)</span>
                                <svg style="width:1rem;height:1rem;opacity:0.5;flex-shrink:0;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                            </button>
                            <div id="phlebotomistDropdown" class="radix-select-dropdown hidden" style="position:absolute;z-index:60;top:100%;left:0;right:0;margin-top:4px;background:white;border-radius:0.5rem;border:1px solid #e5e7eb;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);overflow:hidden;animation:fadeInScale 0.12s ease-out;">
                                <div class="radix-select-item" data-value="" style="padding:0.5rem 0.75rem;font-size:0.875rem;cursor:pointer;color:#9ca3af;transition:background 0.1s;">None (unassigned)</div>
                                <div class="radix-select-item" data-value="Nurse Thompson" style="padding:0.5rem 0.75rem;font-size:0.875rem;cursor:pointer;display:flex;align-items:center;gap:0.5rem;transition:background 0.1s;">
                                    Nurse Thompson</div>
                                <div class="radix-select-item" data-value="Nurse Martinez" style="padding:0.5rem 0.75rem;font-size:0.875rem;cursor:pointer;display:flex;align-items:center;gap:0.5rem;transition:background 0.1s;">
                                    Nurse Martinez</div>
                                <div class="radix-select-item" data-value="Lab Tech Johnson" style="padding:0.5rem 0.75rem;font-size:0.875rem;cursor:pointer;display:flex;align-items:center;gap:0.5rem;transition:background 0.1s;">
                                    Lab Tech Johnson</div>
                                <div class="radix-select-item" data-value="Nurse Williams" style="padding:0.5rem 0.75rem;font-size:0.875rem;cursor:pointer;display:flex;align-items:center;gap:0.5rem;transition:background 0.1s;">
                                    Nurse Williams</div>
                            </div>
                        </div>
                    </div>
                    <!-- Notes -->
                    <div><label style="display:block;font-size:0.875rem;font-weight:500;color:#374151;margin-bottom:0.25rem;">Notes</label><textarea id="donationNotes" rows="3" placeholder="Any special instructions or notes..." style="width:100%;border-radius:0.375rem;border:1px solid #d1d5db;padding:0.5rem 0.75rem;font-size:0.875rem;resize:vertical;"></textarea></div>
                    <!-- Reminder -->
                    <div style="display:flex;align-items:center;gap:0.5rem;"><input type="checkbox" id="sendReminder" checked style="width:1rem;height:1rem;border-radius:0.25rem;border:1px solid #d1d5db;accent-color:#4f46e5;"><label for="sendReminder" style="font-size:0.875rem;color:#374151;">Send reminder to donor</label></div>
                </div>
            </div>
            <div style="display:flex;justify-content:flex-end;gap:0.75rem;padding:1rem 1.5rem;border-top:1px solid #e5e7eb;">
                <button class="cancel-schedule-modal" style="background:white;border:1px solid #d1d5db;border-radius:0.375rem;padding:0.5rem 1rem;font-size:0.875rem;font-weight:500;cursor:pointer;color:#374151;">Cancel</button>
                <button class="confirm-schedule-modal" style="background:#4f46e5;color:white;border:none;border-radius:0.375rem;padding:0.5rem 1rem;font-size:0.875rem;font-weight:500;cursor:pointer;">Schedule Donation</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    activeModal = modal;
    document.body.style.overflow = 'hidden';
    
    // Set default date
    const today = new Date().toISOString().split('T')[0];
    modal.querySelector('#donationDate').value = today;
    
    // Initialize Radix selects
    initModalRadixSelect(modal, 'donationTypeBtn', 'donationTypeDropdown', 'donationTypeText');
    initModalRadixSelect(modal, 'donationLocationBtn', 'donationLocationDropdown', 'donationLocationText');
    initModalRadixSelect(modal, 'phlebotomistBtn', 'phlebotomistDropdown', 'phlebotomistText');
    
    // Close handlers
    modal.querySelector('.close-schedule-modal')?.addEventListener('click', closeModal);
    modal.querySelector('.cancel-schedule-modal')?.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
    
    // Confirm handler
    modal.querySelector('.confirm-schedule-modal')?.addEventListener('click', () => {
        const type = modal.querySelector('#donationTypeText').textContent;
        const date = modal.querySelector('#donationDate').value;
        const time = modal.querySelector('#donationTime').value;
        const location = modal.querySelector('#donationLocationText').textContent;
        const phlebotomist = modal.querySelector('#phlebotomistText').textContent;
        const notes = modal.querySelector('#donationNotes').value;
        const sendReminder = modal.querySelector('#sendReminder').checked;
        
        if (!date || !time) { showToast('Please select both date and time', true); return; }
        
        const formattedDate = new Date(date + 'T' + time).toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
        let message = `${type} donation scheduled for ${donor.name} on ${formattedDate} at ${time}`;
        if (location) message += ` at ${location}`;
        if (phlebotomist && phlebotomist !== 'Select phlebotomist (optional)') message += ` with ${phlebotomist}`;
        if (sendReminder) message += '. Reminder will be sent.';
        
        showToast(message);
        closeModal();
    });
}

// Helper function to initialize Radix selects within modals
function initModalRadixSelect(modal, triggerId, dropdownId, textId) {
    const trigger = modal.querySelector('#' + triggerId);
    const dropdown = modal.querySelector('#' + dropdownId);
    const textEl = modal.querySelector('#' + textId);
    
    if (!trigger || !dropdown || !textEl) return;
    
    trigger.addEventListener('click', function(e) {
        e.stopPropagation();
        modal.querySelectorAll('.radix-select-dropdown').forEach(d => { if (d !== dropdown) d.classList.add('hidden'); });
        dropdown.classList.toggle('hidden');
    });
    
    dropdown.querySelectorAll('.radix-select-item').forEach(item => {
        item.addEventListener('click', function() {
            const value = this.dataset.value;
            const text = this.textContent.trim().replace(/^\w{2}/, '').trim() || this.textContent.trim();
            textEl.textContent = text;
            if (!value && text === 'None (unassigned)') {
                textEl.style.color = '#9ca3af';
                textEl.textContent = 'Select phlebotomist (optional)';
            } else {
                textEl.style.color = '';
            }
            dropdown.classList.add('hidden');
        });
    });
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.radix-select-wrapper')) {
        document.querySelectorAll('.radix-select-dropdown').forEach(d => d.classList.add('hidden'));
    }
});

// ==================== DONATION HISTORY MODAL ====================
function openHistoryModal(donor) {
    closeModal();
    const history = donationHistory[donor.id] || [];
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-background p-6 shadow-lg duration-200 sm:rounded-lg sm:max-w-[700px]">
            <div class="flex flex-col space-y-1.5 text-center sm:text-left"><h2 class="text-lg font-semibold leading-none tracking-tight">Donation History</h2><p class="text-sm text-muted-foreground">Complete donation history for ${donor.name} (ID: ${donor.id})</p></div>
            <div class="max-h-[400px] overflow-y-auto"><div class="relative w-full overflow-auto"><table class="w-full caption-bottom text-sm whitespace-nowrap"><thead><tr class="border-b"><th class="h-12 px-4 text-left font-medium">Date</th><th class="h-12 px-4 text-left font-medium">Type</th><th class="h-12 px-4 text-left font-medium">Blood Unit</th><th class="h-12 px-4 text-left font-medium">Volume</th><th class="h-12 px-4 text-left font-medium">Location</th><th class="h-12 px-4 text-left font-medium">Status</th></tr></thead><tbody id="historyTableBody"></tbody></table></div></div>
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2"><button class="close-history inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">Close</button></div>
            <button type="button" class="absolute right-4 top-4 rounded-sm opacity-70 hover:opacity-100"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button>
        </div>
    `;
    document.body.appendChild(modal);
    activeModal = modal;
    document.body.style.overflow = 'hidden';
    
    const tbody = modal.querySelector('#historyTableBody');
    if (history.length === 0) { tbody.innerHTML = '<tr><td colspan="6" class="text-center py-4">No donation history found</td></tr>'; }
    else { tbody.innerHTML = history.map(h => `<tr class="border-b"><td class="p-4">${formatDate(h.date)}</td><td class="p-4">${h.type}</td><td class="p-4">${h.bloodUnit}</td><td class="p-4">${h.volume}</td><td class="p-4">${h.location}</td><td class="p-4"><div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-500/10 text-green-500 border-green-500/20">${h.status}</div></td></tr>`).join(''); }
    
    modal.querySelector('.close-history')?.addEventListener('click', closeModal);
    modal.querySelector('.absolute.right-4')?.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
}

// ==================== DONOR CARD MODAL (Print) ====================
function openDonorCardModal(donor) {
    closeModal();
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-background p-6 shadow-lg duration-200 sm:rounded-lg sm:max-w-[500px]">
            <div class="flex flex-col space-y-1.5 text-center sm:text-left"><h2 class="text-lg font-semibold leading-none tracking-tight">Donor Card</h2><p class="text-sm text-muted-foreground">Blood donor identification card for ${donor.name}</p></div>
            <div class="donor-card rounded-lg p-6 text-white text-center"><div class="mb-4"><div class="w-20 h-20 mx-auto bg-white/20 rounded-full flex items-center justify-center text-3xl font-bold">${getInitials(donor.name)}</div></div><h3 class="text-xl font-bold">${donor.name}</h3><p class="text-white/80 mb-4">Blood Donor ID: ${donor.id}</p><div class="grid grid-cols-2 gap-4 text-left mt-4"><div><p class="text-white/60 text-xs">Blood Type</p><p class="font-bold text-lg">${donor.bloodType}</p></div><div><p class="text-white/60 text-xs">Donor Since</p><p class="font-semibold">${donor.lastDonation ? new Date(donor.lastDonation).getFullYear() : '2024'}</p></div><div><p class="text-white/60 text-xs">Total Donations</p><p class="font-semibold">${donor.totalDonations}</p></div><div><p class="text-white/60 text-xs">Status</p><p class="font-semibold">${donor.status}</p></div></div><div class="mt-6 pt-4 border-t border-white/20 text-center"><p class="text-white/60 text-xs">Medi-track Blood Bank</p><p class="text-white/60 text-xs">Every drop counts - Save lives</p></div></div>
            <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2"><button class="print-card inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">Print Card</button><button class="close-card inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">Close</button></div>
            <button type="button" class="absolute right-4 top-4 rounded-sm opacity-70 hover:opacity-100"><svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button>
        </div>
    `;
    document.body.appendChild(modal);
    activeModal = modal;
    document.body.style.overflow = 'hidden';
    modal.querySelector('.print-card')?.addEventListener('click', () => { window.print(); showToast('Print dialog opened'); });
    modal.querySelector('.close-card')?.addEventListener('click', closeModal);
    modal.querySelector('.absolute.right-4')?.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
}

// ==================== MODERN ACTION MENU ====================
function showActionMenu(btn, donor) {
    closeActionMenu();
    const rect = btn.getBoundingClientRect();
    const menu = document.createElement('div');
    menu.className = 'action-menu';
    let left = rect.left, top = rect.bottom + 6;
    if (left + 220 > window.innerWidth) left = window.innerWidth - 230;
    if (top + 300 > window.innerHeight) top = rect.top - 310;
    menu.style.top = `${top}px`;
    menu.style.left = `${left}px`;
    menu.innerHTML = `
        <div class="action-menu-header">Actions</div>
        <button data-action="view" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>View Donor Details</button>
        <button data-action="schedule" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M8 2v4M16 2v4M3 10h18M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01"/><rect width="18" height="18" x="3" y="4" rx="2"/></svg>Schedule Donation</button>
        <button data-action="edit" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>Edit Donor Info</button>
        <div class="action-divider"></div>
        <button data-action="history" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>View Donation History</button>
        <button data-action="card" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M3 15h18"/><path d="M9 21v-6"/><path d="M15 21v-6"/><path d="M7 3v4"/><path d="M17 3v4"/></svg>Print Donor Card</button>
        <div class="action-divider"></div>
        <button data-action="delete" class="action-item text-red-600"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>Delete Donor</button>
    `;
    document.body.appendChild(menu);
    activeActionMenu = menu;
    const closeHandler = (e) => { if (!menu.contains(e.target) && e.target !== btn) { closeActionMenu(); document.removeEventListener('click', closeHandler); } };
    setTimeout(() => document.addEventListener('click', closeHandler), 10);
    menu.querySelector('[data-action="view"]')?.addEventListener('click', () => { window.location.href = `donor-details.html?id=${donor.id}`; closeActionMenu(); });
    menu.querySelector('[data-action="schedule"]')?.addEventListener('click', () => { openScheduleModal(donor); closeActionMenu(); });
    menu.querySelector('[data-action="edit"]')?.addEventListener('click', () => { window.location.href = `edit-donor.html?id=${donor.id}`; closeActionMenu(); });
    menu.querySelector('[data-action="history"]')?.addEventListener('click', () => { openHistoryModal(donor); closeActionMenu(); });
    menu.querySelector('[data-action="card"]')?.addEventListener('click', () => { openDonorCardModal(donor); closeActionMenu(); });
    menu.querySelector('[data-action="delete"]')?.addEventListener('click', () => { openDeleteModal(donor); closeActionMenu(); });
}

// ==================== RENDER FUNCTIONS ====================
function getFilteredData() { let filtered = [...allDonors]; if (currentTab === "eligible") filtered = filtered.filter(d => d.status === "Eligible"); else if (currentTab === "ineligible") filtered = filtered.filter(d => d.status === "Ineligible"); else if (currentTab === "new") filtered = filtered.filter(d => d.status === "New Donor"); if (searchQuery) { const q = searchQuery.toLowerCase(); filtered = filtered.filter(d => d.name.toLowerCase().includes(q) || d.id.toLowerCase().includes(q) || d.email.toLowerCase().includes(q)); } if (bloodTypeFilter !== "all") filtered = filtered.filter(d => d.bloodType === bloodTypeFilter); if (statusFilter !== "all" && currentTab === "all") filtered = filtered.filter(d => d.status === statusFilter); filtered.sort((a, b) => { let aVal = a[currentSort.column], bVal = b[currentSort.column]; if (currentSort.column === "lastDonation") { aVal = a.lastDonation || "9999-12-31"; bVal = b.lastDonation || "9999-12-31"; } if (currentSort.column === "nextEligible") { aVal = a.nextEligible === "N/A" ? "9999-12-31" : a.nextEligible; bVal = b.nextEligible === "N/A" ? "9999-12-31" : b.nextEligible; } if (typeof aVal === 'string') aVal = aVal.toLowerCase(); if (typeof bVal === 'string') bVal = bVal.toLowerCase(); if (aVal < bVal) return currentSort.direction === "asc" ? -1 : 1; if (aVal > bVal) return currentSort.direction === "asc" ? 1 : -1; return 0; }); return filtered; }

function renderDonorRow(donor) { return `<tr class="border-b hover:bg-gray-50"><td class="p-4"><div class="flex items-center gap-2"><span class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-sm font-semibold">${getInitials(donor.name)}</span><div><span class="font-medium">${donor.name}</span><span class="text-xs text-gray-500 block">${donor.id}</span></div></div></td><td class="p-4"><div class="inline-flex items-center rounded-full border px-2 py-0.5 text-xs font-semibold ${getBloodTypeColor(donor.bloodType)}">${donor.bloodType}</div></td><td class="p-4"><div><div class="flex items-center gap-1"><svg class="h-3 w-3 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg><span class="text-xs">${donor.phone}</span></div><div class="flex items-center gap-1"><svg class="h-3 w-3 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg><span class="text-xs">${donor.email}</span></div></div></td><td class="p-4">${formatDate(donor.lastDonation)}</td><td class="p-4"><div class="inline-flex items-center rounded-full border px-2 py-0.5 text-xs font-semibold ${getStatusColor(donor.status)}">${donor.status}</div></td><td class="p-4"><div class="flex items-center gap-2"><span>${donor.totalDonations}</span>${donor.donorTier !== 'Regular' && donor.donorTier !== 'New' ? `<div class="inline-flex items-center rounded-full border px-2 py-0.5 text-xs font-semibold ${getTierColor(donor.donorTier)}">${donor.donorTier}</div>` : ''}</div></td><td class="p-4">${donor.nextEligible}</td><td class="p-4"><button data-id="${donor.id}" class="action-trigger inline-flex items-center justify-center h-10 w-10 rounded-md hover:bg-gray-100"><svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg></button></td></tr>`; }

function renderAllTables() {
    const filtered = getFilteredData(); const start = (currentPage - 1) * itemsPerPage; const paginated = filtered.slice(start, start + itemsPerPage);
    document.getElementById('allDonorsBody').innerHTML = paginated.map(d => renderDonorRow(d)).join('');
    document.getElementById('eligibleDonorsBody').innerHTML = allDonors.filter(d => d.status === "Eligible").map(d => renderDonorRow(d)).join('');
    document.getElementById('ineligibleDonorsBody').innerHTML = allDonors.filter(d => d.status === "Ineligible").map(d => renderDonorRow(d)).join('');
    document.getElementById('newDonorsBody').innerHTML = allDonors.filter(d => d.status === "New Donor").map(d => renderDonorRow(d)).join('');
    document.getElementById('paginationInfo').innerHTML = `Showing <strong>${filtered.length === 0 ? 0 : start + 1}</strong> to <strong>${Math.min(start + itemsPerPage, filtered.length)}</strong> of <strong>${filtered.length}</strong> donors`;
    document.getElementById('totalDonors').innerText = allDonors.length; document.getElementById('eligibleCount').innerText = allDonors.filter(d => d.status === "Eligible").length;
    document.getElementById('prevPageBtn').disabled = currentPage === 1; document.getElementById('nextPageBtn').disabled = start + itemsPerPage >= filtered.length;
    document.querySelectorAll('.action-trigger').forEach(btn => { btn.addEventListener('click', (e) => { e.stopPropagation(); const donor = allDonors.find(d => d.id === btn.dataset.id); if (donor) showActionMenu(btn, donor); }); });
}

// ==================== CHARTS ====================
function initCharts() { new ApexCharts(document.querySelector("#bloodTypeChart"), { series: [{ name: 'Donors', data: [95, 45, 30, 15, 22, 18, 15, 7] }], chart: { type: 'bar', height: 300, toolbar: { show: false }, background: 'transparent' }, colors: ['#ef4444', '#3b82f6', '#22c55e', '#a855f7', '#dc2626', '#2563eb', '#16a34a', '#9333ea'], plotOptions: { bar: { borderRadius: 8, columnWidth: '60%' } }, dataLabels: { enabled: false }, xaxis: { categories: ['O+', 'A+', 'B+', 'AB+', 'O-', 'A-', 'B-', 'AB-'] }, yaxis: { title: { text: 'Number of Donors' } }, grid: { borderColor: '#e5e7eb' } }).render(); new ApexCharts(document.querySelector("#frequencyChart"), { series: [{ name: 'Donors', data: [98, 107, 24, 12, 6] }], chart: { type: 'bar', height: 300, toolbar: { show: false }, background: 'transparent' }, colors: ['#6366f1'], plotOptions: { bar: { borderRadius: 8, columnWidth: '60%' } }, dataLabels: { enabled: false }, xaxis: { categories: ['First Time', '2-4 Times', '5-9 Times', '10-24 Times', '25+ Times'] }, yaxis: { title: { text: 'Number of Donors' } }, grid: { borderColor: '#e5e7eb' } }).render(); }

// ==================== DROPDOWNS ====================
function initDropdowns() {
    const bloodTypeBtn = document.getElementById('bloodTypeBtn'), bloodTypeDropdown = document.getElementById('bloodTypeDropdown'), bloodTypeText = document.getElementById('bloodTypeText');
    bloodTypeDropdown.innerHTML = ['All Blood Types', ...bloodTypes].map(opt => `<div class="select-item" data-value="${opt === 'All Blood Types' ? 'all' : opt}">${opt}</div>`).join('');
    bloodTypeBtn.addEventListener('click', (e) => { e.stopPropagation(); bloodTypeDropdown.classList.toggle('hidden'); });
    bloodTypeDropdown.querySelectorAll('.select-item').forEach(item => { item.addEventListener('click', () => { bloodTypeFilter = item.dataset.value; bloodTypeText.textContent = item.dataset.value === 'all' ? 'All Blood Types' : item.dataset.value; bloodTypeDropdown.classList.add('hidden'); currentPage = 1; renderAllTables(); }); });
    const statusBtn = document.getElementById('statusBtn'), statusDropdown = document.getElementById('statusDropdown'), statusText = document.getElementById('statusText');
    statusDropdown.innerHTML = ['All Statuses', ...statuses].map(opt => `<div class="select-item" data-value="${opt === 'All Statuses' ? 'all' : opt}">${opt}</div>`).join('');
    statusBtn.addEventListener('click', (e) => { e.stopPropagation(); statusDropdown.classList.toggle('hidden'); });
    statusDropdown.querySelectorAll('.select-item').forEach(item => { item.addEventListener('click', () => { statusFilter = item.dataset.value; statusText.textContent = item.dataset.value === 'all' ? 'All Statuses' : item.dataset.value; statusDropdown.classList.add('hidden'); currentPage = 1; renderAllTables(); }); });
    document.addEventListener('click', (e) => { if (!bloodTypeBtn.contains(e.target)) bloodTypeDropdown.classList.add('hidden'); if (!statusBtn.contains(e.target)) statusDropdown.classList.add('hidden'); });
}

// ==================== EVENT LISTENERS ====================
document.getElementById('searchInput')?.addEventListener('input', (e) => { searchQuery = e.target.value.toLowerCase(); currentPage = 1; renderAllTables(); });
document.getElementById('resetFiltersBtn')?.addEventListener('click', () => { searchQuery = ""; bloodTypeFilter = "all"; statusFilter = "all"; document.getElementById('searchInput').value = ""; document.getElementById('bloodTypeText').textContent = "All Blood Types"; document.getElementById('statusText').textContent = "All Statuses"; currentPage = 1; renderAllTables(); });
document.getElementById('exportBtn')?.addEventListener('click', () => { const data = getFilteredData(); const headers = ["ID","Name","Blood Type","Phone","Email","Last Donation","Status","Total Donations","Next Eligible","Donor Tier"]; const rows = data.map(d => [d.id, d.name, d.bloodType, d.phone, d.email, d.lastDonation || 'Never', d.status, d.totalDonations, d.nextEligible, d.donorTier]); const csv = [headers, ...rows].map(row => row.join(",")).join("\n"); const blob = new Blob([csv], {type: "text/csv"}); const a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = `blood_donors_${new Date().toISOString().slice(0,10)}.csv`; a.click(); URL.revokeObjectURL(a.href); showToast("Export complete"); });
document.getElementById('prevPageBtn')?.addEventListener('click', () => { if (currentPage > 1) { currentPage--; renderAllTables(); } });
document.getElementById('nextPageBtn')?.addEventListener('click', () => { currentPage++; renderAllTables(); });
document.querySelectorAll('.sort-header').forEach(header => { header.addEventListener('click', () => { const sortColumn = header.dataset.sort; if (currentSort.column === sortColumn) currentSort.direction = currentSort.direction === "asc" ? "desc" : "asc"; else { currentSort.column = sortColumn; currentSort.direction = "asc"; } currentPage = 1; renderAllTables(); }); });
document.querySelectorAll('.tab-trigger').forEach(trigger => { trigger.addEventListener('click', () => { const tabs = ['all', 'eligible', 'ineligible', 'new']; tabs.forEach(t => { document.getElementById(`tab-${t}`)?.classList.add('hidden'); const btn = document.querySelector(`.tab-trigger[data-tab="${t}"]`); if (btn) { if (t === trigger.dataset.tab) { btn.setAttribute('data-state', 'active'); btn.classList.add('bg-white', 'text-gray-900', 'shadow-sm'); btn.classList.remove('bg-transparent', 'text-gray-500'); } else { btn.setAttribute('data-state', 'inactive'); btn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm'); btn.classList.add('bg-transparent', 'text-gray-500'); } } }); document.getElementById(`tab-${trigger.dataset.tab}`)?.classList.remove('hidden'); currentTab = trigger.dataset.tab; currentPage = 1; renderAllTables(); }); });
document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { closeActionMenu(); closeModal(); } });
window.addEventListener('scroll', () => closeActionMenu());

initCharts(); initDropdowns(); renderAllTables();
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
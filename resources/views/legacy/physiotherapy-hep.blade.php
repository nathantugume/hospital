<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Home Exercise Program (HEP)</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .bg-background, body.dark .modal-container { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700, body.dark .text-muted-foreground { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted, body.dark .bg-gray-50 { background-color: #262626 !important; }
        body.dark .border-gray-200, body.dark .border-gray-300 { border-color: #404040 !important; }
        body.dark input, body.dark select, body.dark textarea { background-color: #262626 !important; border-color: #404040 !important; color: #e5e5e5 !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        [role="tabpanel"][data-state="inactive"] { display: none; }
        [role="tabpanel"][data-state="active"] { display: block; animation: fadeIn 0.2s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }

        .tab-btn.active { background-color: white !important; color: #1f2937 !important; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        body.dark .tab-btn.active { background-color: #2a2a2a !important; color: #e5e5e5 !important; }

        .toast-message { position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white; padding: 12px 20px; border-radius: 8px; z-index: 1200; animation: slideIn 0.3s ease-out; font-size: 0.875rem; }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        .action-menu { position: fixed; z-index: 1000; background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); min-width: 220px; padding: 0.25rem; animation: fadeIn 0.12s ease-out; }
        body.dark .action-menu { background: #2a2a2a; border-color: #404040; }
        .action-menu-header { padding: 0.5rem 0.75rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb; margin-bottom: 0.25rem; }
        body.dark .action-menu-header { color: #9ca3af; border-bottom-color: #404040; }
        .action-item { display: flex; align-items: center; gap: 0.5rem; width: 100%; padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer; border-radius: 0.375rem; transition: background 0.1s; border: none; background: none; text-align: left; color: inherit; }
        .action-item:hover { background-color: #f3f4f6; }
        body.dark .action-item:hover { background-color: #3f3f46; }
        .action-item.text-red { color: #ef4444; }
        .action-item.text-red:hover { background-color: #fef2f2; }
        body.dark .action-item.text-red:hover { background-color: #450a0a; }
        .action-divider { height: 1px; background: #e5e7eb; margin: 0.25rem 0; }
        body.dark .action-divider { background: #404040; }

        .modal-overlay { position: fixed; inset: 0; z-index: 200; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; animation: fadeIn 0.15s ease-out; }
        .modal-container { background: white; border-radius: 0.75rem; box-shadow: 0 20px 60px rgba(0,0,0,0.2); width: 90%; max-width: 700px; max-height: 85vh; overflow-y: auto; animation: modalSlide 0.2s ease-out; }
        @keyframes modalSlide { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        body.dark .modal-container { background: #131212; border: 1px solid #333; }

        .select-trigger { display: flex; align-items: center; justify-content: space-between; width: 100%; height: 40px; border: 1px solid #d1d5db; background-color: white; padding: 0 0.75rem; font-size: 0.875rem; cursor: pointer; border-radius: 0.375rem; }
        body.dark .select-trigger { background-color: #131212; border-color: #404040; color: #e5e5e5; }
        .select-dropdown { position: absolute; z-index: 50; background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); margin-top: 4px; min-width: 100%; max-height: 200px; overflow-y: auto; }
        body.dark .select-dropdown { background: #2a2a2a; border-color: #404040; }
        .select-item { padding: 0.5rem 0.75rem; cursor: pointer; font-size: 0.875rem; transition: background 0.1s; }
        .select-item:hover { background-color: #f3f4f6; }
        body.dark .select-item:hover { background-color: #3f3f46; }

        .radix-select { position: relative; width: 100%; }
        .radix-select-trigger { display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 0.5rem 0.75rem; font-size: 0.875rem; border-radius: 0.375rem; border: 1px solid #d1d5db; background-color: white; cursor: pointer; min-height: 40px; }
        body.dark .radix-select-trigger { background-color: #131212; border-color: #404040; color: #e5e5e5; }
        .radix-select-content { position: absolute; top: 100%; left: 0; right: 0; margin-top: 4px; background: white; border: 1px solid #e5e7eb; border-radius: 0.375rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); z-index: 10001; overflow: hidden; max-height: 200px; overflow-y: auto; }
        body.dark .radix-select-content { background: #2a2a2a; border-color: #404040; }
        .radix-select-item { padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; justify-content: space-between; }
        .radix-select-item:hover { background-color: #f3f4f6; }
        body.dark .radix-select-item:hover { background-color: #3f3f46; }
        .radix-select-item[data-selected="true"] { background-color: #eef2ff; color: #4f46e5; font-weight: 500; }
        body.dark .radix-select-item[data-selected="true"] { background-color: #1e1b4b; color: #818cf8; }
        .radix-select-item-indicator { display: none; }
        .radix-select-item[data-selected="true"] .radix-select-item-indicator { display: block; }

        .hep-card {  overflow: hidden; }
        .hep-card:hover { border-color: #6366f1; box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
        body.dark .hep-card { background: #131212; border-color: #404040; }
        body.dark .hep-card:hover { border-color: #818cf8; }
        .hep-card-header { padding: 1rem 1.25rem; border-bottom: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: flex-start; }
        body.dark .hep-card-header { border-bottom-color: #262626; }
        .hep-card-body { padding: 1rem 1.25rem; }
        .hep-card-footer { padding: 0.75rem 1.25rem; border-top: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center; }
        body.dark .hep-card-footer { border-top-color: #262626; }

        .exercise-row { display: flex; align-items: center; gap: 1rem; padding: 0.75rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; margin-bottom: 0.5rem; transition: all 0.15s; }
        .exercise-row:hover { border-color: #6366f1; background: #fafaff; }
        body.dark .exercise-row { border-color: #404040; }
        body.dark .exercise-row:hover { border-color: #818cf8; background: #1a1a2e; }
        .exercise-row:last-child { margin-bottom: 0; }

        .adherence-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; }
        .adherence-dot.done { background: #10b981; }
        .adherence-dot.missed { background: #ef4444; }
        .adherence-dot.partial { background: #f59e0b; }
        .adherence-dot.upcoming { background: #d1d5db; }

        .print-preview { background: white; padding: 2rem; border: 1px solid #e5e7eb; border-radius: 0.5rem; }
        body.dark .print-preview { background: #1a1a1a; border-color: #404040; }

        .video-thumb { position: relative; width: 100%; height: 160px; border-radius: 0.5rem; overflow: hidden; cursor: pointer; background: #1f2937; display: flex; align-items: center; justify-content: center; }
        .video-thumb:hover .video-play-overlay { opacity: 1; }
        .video-play-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; opacity: 0.7; transition: opacity 0.15s; }

        .reminder-badge { display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.25rem 0.625rem; border-radius: 9999px; font-size: 0.6875rem; font-weight: 500; }
        .reminder-badge.active { background: #d1fae5; color: #065f46; }
        .reminder-badge.paused { background: #fef3c7; color: #92400e; }
        .reminder-badge.none { background: #f3f4f6; color: #6b7280; }
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
        <div class="flex flex-col gap-6">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div><h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Home Exercise Program (HEP)</h1><p class="text-gray-500">Manage patient home exercise prescriptions, track adherence, and send reminders</p></div>
                <div class="flex gap-2">
<button id="quickActionsBtn" onclick="openCreateHepModal()" class="inline-flex items-center gap-2 rounded-md bg-primary text-white px-4 h-10 text-sm hover:bg-primary/90 shadow-sm">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus h-5 w-5 text-white"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
    Create Program
</button>
                    <button id="refreshBtn" class="inline-flex items-center gap-2 rounded-md border px-3 py-2 text-sm hover:bg-accent"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>Refresh</button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg p-4 border bg-background shadow-sm"><div class="flex justify-between"><span class="text-sm font-medium text-gray-500">Active HEPs</span><div class="bg-blue-100 p-1.5 rounded-lg"><svg class="h-5 w-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/></svg></div></div><div class="text-2xl font-bold mt-2">142</div><p class="text-xs text-gray-500 mt-1">Across 98 patients</p></div>
                <div class="rounded-lg p-4 border bg-background shadow-sm"><div class="flex justify-between"><span class="text-sm font-medium text-gray-500">Adherence Rate</span><div class="bg-green-100 p-1.5 rounded-lg"><svg class="h-5 w-5 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg></div></div><div class="text-2xl font-bold mt-2">76%</div><p class="text-xs text-green-500 mt-1">↑ 4% this month</p></div>
                <div class="rounded-lg p-4 border bg-background shadow-sm"><div class="flex justify-between"><span class="text-sm font-medium text-gray-500">Reminders Sent</span><div class="bg-purple-100 p-1.5 rounded-lg"><svg class="h-5 w-5 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></div></div><div class="text-2xl font-bold mt-2">1,240</div><p class="text-xs text-gray-500 mt-1">This month</p></div>
                <div class="rounded-lg p-4 border bg-background shadow-sm"><div class="flex justify-between"><span class="text-sm font-medium text-gray-500">Avg. Exercises/HEP</span><div class="bg-amber-100 p-1.5 rounded-full"><svg class="h-5 w-5 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div></div><div class="text-2xl font-bold mt-2">5.2</div><p class="text-xs text-gray-500 mt-1">Per program</p></div>
            </div>

            <!-- Tabs -->
            <div class="w-full">
                <div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-muted p-1 text-muted-foreground mb-4">
<button type="button" data-tab="all" class="tab-btn inline-flex items-center rounded-sm px-3 py-1.5 text-sm font-medium gap-2 active"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>All Programs</button>
<button type="button" data-tab="adherence" class="tab-btn inline-flex items-center rounded-sm px-3 py-1.5 text-sm font-medium gap-2"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>Adherence</button>
<button type="button" data-tab="templates" class="tab-btn inline-flex items-center rounded-sm px-3 py-1.5 text-sm font-medium gap-2"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect width="6" height="4" x="9" y="3" rx="1"/></svg>HEP Templates</button>                </div>

                <!-- All Programs Tab -->
                <div id="tab-all" role="tabpanel" data-state="active" class="mt-4 space-y-6">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center flex-wrap">
                        <div class="relative flex-1 min-w-[260px]"><svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg><input id="hepSearch" type="search" placeholder="Search by patient, condition, or therapist..." class="h-10 w-full rounded-md border border-gray-300 pl-8 pr-3 text-sm"></div>
                        <div class="flex gap-2">
                            <div class="relative"><button id="statusFilterBtn" class="select-trigger w-[150px]"><span id="statusFilterText">All Status</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="statusFilterDropdown" class="hidden select-dropdown"><div class="select-item" data-value="all">All Status</div><div class="select-item" data-value="Active">Active</div><div class="select-item" data-value="Completed">Completed</div><div class="select-item" data-value="Paused">Paused</div></div></div>
                        </div>
                    </div>
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3" id="hepGrid"></div>
                </div>

                <!-- Adherence Tab -->
                <div id="tab-adherence" role="tabpanel" data-state="inactive" class="mt-4 space-y-6">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center flex-wrap">
                        <div class="relative flex-1 min-w-[260px]"><svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg><input id="adherenceSearch" type="search" placeholder="Search by patient name..." class="h-10 w-full rounded-md border border-gray-300 pl-8 pr-3 text-sm"></div>
                    </div>
                    <div class="rounded-lg border bg-white overflow-x-auto">
                        <table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr><th class="h-10 px-4 text-left">Patient</th><th class="h-10 px-4 text-left">HEP</th><th class="h-10 px-4 text-left">Exercises</th><th class="h-10 px-4 text-left">Adherence</th><th class="h-10 px-4 text-left hidden md:table-cell">Last 7 Days</th><th class="h-10 px-4 text-left">Status</th><th class="h-10 px-4 text-right">Actions</th></tr></thead><tbody id="adherenceTableBody"></tbody></table>
                    </div>
                </div>

                <!-- HEP Templates Tab -->
                <div id="tab-templates" role="tabpanel" data-state="inactive" class="mt-4 space-y-6">
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3" id="templatesGrid"></div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Create/Edit HEP Modal -->
<div id="createHepModal" style="display:none;" class="modal-overlay">
    <div class="modal-container" style="max-width:750px;">
        <div class="flex justify-between items-start mb-4 p-6 pb-0"><div><h3 class="text-lg font-semibold" id="hepModalTitle">Create Home Exercise Program</h3><p class="text-gray-500">Assign exercises with instructions for home practice</p></div><button id="closeHepModalBtn" class="text-gray-400 hover:text-gray-600"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button></div>
        <div class="p-6 pt-2 space-y-4">
            <div class="grid gap-4 md:grid-cols-2">
                <div><label class="text-sm font-medium block mb-1">Patient <span class="text-red-500">*</span></label><div class="radix-select" id="hepPatientSelect"><button type="button" class="radix-select-trigger"><span>Select patient...</span><svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div class="radix-select-content hidden"><div class="radix-select-item" data-value="PT-001" data-name="Okello David">Okello David (PT-001)</div><div class="radix-select-item" data-value="PT-002" data-name="Emma Davis">Emma Davis (PT-002)</div><div class="radix-select-item" data-value="PT-003" data-name="Mwangi Peter">Mwangi Peter (PT-003)</div><div class="radix-select-item" data-value="PT-004" data-name="Nansubuga Sophia">Nansubuga Sophia (PT-004)</div><div class="radix-select-item" data-value="PT-005" data-name="Kimera Liam">Kimera Liam (PT-005)</div></div></div></div>
                <div><label class="text-sm font-medium block mb-1">Therapist</label><div class="radix-select" id="hepTherapistSelect"><button type="button" class="radix-select-trigger"><span>Dr. Nakato Sarah</span><svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div class="radix-select-content hidden"><div class="radix-select-item" data-value="Dr. Nakato Sarah" data-selected="true">Dr. Nakato Sarah<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div><div class="radix-select-item" data-value="Dr. Mwangi Peter">Dr. Mwangi Peter</div><div class="radix-select-item" data-value="Namyalo Emma">Namyalo Emma</div><div class="radix-select-item" data-value="Dr. Okello James">Dr. Okello James</div></div></div></div>
            </div>
            <div><label class="text-sm font-medium block mb-1">Program Name</label><input id="hepProgramName" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="e.g. Post-ACL Home Program"></div>
            <div class="grid gap-4 md:grid-cols-2">
                <div><label class="text-sm font-medium block mb-1">Start Date</label><input type="date" id="hepStartDate" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" value="2026-06-14"></div>
                <div><label class="text-sm font-medium block mb-1">Duration (Weeks)</label><input type="number" id="hepDuration" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" value="4" min="1" max="52"></div>
            </div>
            <div class="border-t pt-4">
                <div class="flex items-center justify-between mb-3"><h3 class="font-semibold flex items-center gap-2"><svg class="h-4 w-4 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>Exercises</h3><button type="button" id="addHepExerciseBtn" class="inline-flex items-center gap-1 text-sm text-indigo-600 hover:underline"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Add Exercise</button></div>
                <div id="hepExercisesList" class="space-y-3">
                    <div class="exercise-row">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold flex-shrink-0">1</span>
                        <div class="flex-1 grid gap-3 md:grid-cols-12 items-end">
                            <div class="md:col-span-4"><label class="text-xs font-medium">Exercise</label><input class="w-full rounded-lg h-10 border border-gray-300 px-2 py-1 text-sm" value="Straight Leg Raise" placeholder="Exercise name"></div>
                            <div class="md:col-span-2"><label class="text-xs font-medium">Sets</label><input type="number" class="w-full rounded-lg h-10 border border-gray-300 px-2 py-1 text-sm" value="3" min="1"></div>
                            <div class="md:col-span-2"><label class="text-xs font-medium">Reps</label><input type="number" class="w-full rounded-lg h-10 border border-gray-300 px-2 py-1 text-sm" value="10" min="1"></div>
                            <div class="md:col-span-2"><label class="text-xs font-medium">Hold (sec)</label><input type="number" class="w-full rounded-lg h-10 border border-gray-300 px-2 py-1 text-sm" value="5" min="0"></div>
                            <div class="md:col-span-1"><label class="text-xs font-medium">Freq</label><div class="radix-select"><button type="button" class="radix-select-trigger"><span>Daily</span><svg class="h-3 w-3 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div class="radix-select-content hidden"><div class="radix-select-item" data-value="Daily" data-selected="true">Daily<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div><div class="radix-select-item" data-value="2x/day">2x/day</div><div class="radix-select-item" data-value="Every other day">Every other day</div><div class="radix-select-item" data-value="3x/week">3x/week</div></div></div></div>
                            <div class="md:col-span-1 flex justify-end"><button type="button" class="text-gray-300 hover:text-red-500 transition-colors p-1" onclick="this.closest('.exercise-row').remove();renumberHepExercises()" title="Remove"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button></div>
                        </div>
                    </div>
                    <div class="exercise-row">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold flex-shrink-0">2</span>
                        <div class="flex-1 grid gap-3 md:grid-cols-12 items-end">
                            <div class="md:col-span-4"><label class="text-xs font-medium">Exercise</label><input class="w-full rounded-lg h-10 border border-gray-300 px-2 py-1 text-sm" value="Quad Sets" placeholder="Exercise name"></div>
                            <div class="md:col-span-2"><label class="text-xs font-medium">Sets</label><input type="number" class="w-full rounded-lg h-10 border border-gray-300 px-2 py-1 text-sm" value="3" min="1"></div>
                            <div class="md:col-span-2"><label class="text-xs font-medium">Reps</label><input type="number" class="w-full rounded-lg h-10 border border-gray-300 px-2 py-1 text-sm" value="15" min="1"></div>
                            <div class="md:col-span-2"><label class="text-xs font-medium">Hold (sec)</label><input type="number" class="w-full rounded-lg h-10 border border-gray-300 px-2 py-1 text-sm" value="10" min="0"></div>
                            <div class="md:col-span-1"><label class="text-xs font-medium">Freq</label><div class="radix-select"><button type="button" class="radix-select-trigger"><span>Daily</span><svg class="h-3 w-3 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div class="radix-select-content hidden"><div class="radix-select-item" data-value="Daily" data-selected="true">Daily<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div><div class="radix-select-item" data-value="2x/day">2x/day</div><div class="radix-select-item" data-value="Every other day">Every other day</div><div class="radix-select-item" data-value="3x/week">3x/week</div></div></div></div>
                            <div class="md:col-span-1 flex justify-end"><button type="button" class="text-gray-300 hover:text-red-500 transition-colors p-1" onclick="this.closest('.exercise-row').remove();renumberHepExercises()" title="Remove"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2">
                <div><label class="text-sm font-medium block mb-1">Precautions</label><textarea id="hepPrecautions" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="• Stop if sharp pain occurs&#10;• Use ice after exercises if needed"></textarea></div>
<div>
    <label class="text-sm font-medium block mb-1">Reminders</label>
    <div class="border rounded-lg p-3 space-y-3 bg-gray-50/50">
        <label class="flex items-center gap-2.5 text-sm cursor-pointer">
            <input type="checkbox" id="enableReminders" checked class="rounded border-gray-300 text-indigo-600 h-4 w-4">
            <span class="font-medium">Enable daily reminders</span>
        </label>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="text-xs text-gray-500 block mb-1">Time</label>
                <input type="time" id="reminderTime" value="08:00" class="h-10 w-full rounded border border-gray-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label class="text-xs text-gray-500 block mb-1">Method</label>
                <div class="radix-select"><button type="button" class="radix-select-trigger h-10"><span>SMS</span><svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div class="radix-select-content hidden"><div class="radix-select-item" data-value="SMS" data-selected="true">SMS<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div><div class="radix-select-item" data-value="Email">Email</div><div class="radix-select-item" data-value="Both">Both</div></div></div>
            </div>
        </div>
    </div>
</div>
            </div>
            <div><label class="text-sm font-medium block mb-1">Additional Notes</label><textarea id="hepNotes" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Any special instructions for the patient..."></textarea></div>
        </div>
        <div class="flex justify-end gap-2 p-6 pt-0">
    <button id="cancelHepBtn" class="inline-flex items-center px-4 h-10 border rounded-md text-sm hover:bg-gray-100">Cancel</button>
    <button id="saveHepBtn" class="inline-flex items-center gap-1.5 px-4 h-10 bg-primary text-white rounded-md text-sm hover:bg-indigo-700">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15.2 3a2 2 0 0 1 1.4.6l3.8 3.8a2 2 0 0 1 .6 1.4V19a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z"/></svg>
        Save HEP
    </button>
</div>
    </div>
</div>

<!-- View HEP Details Modal -->
<div id="viewHepModal" style="display:none;" class="modal-overlay">
    <div class="modal-container" style="max-width:750px;">
        <div class="flex justify-between items-start mb-4 p-6 pb-0">
            <div><h3 class="text-lg font-semibold" id="viewHepTitle">HEP Details</h3><p class="text-gray-500" id="viewHepSubtitle"></p></div>
            <button id="closeViewHepBtn" class="text-gray-400 hover:text-gray-600"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
        </div>
        <div class="p-6 pt-2"><div id="viewHepContent" class="space-y-4"></div></div>
        <div class="flex justify-end gap-2 p-6 pt-0">
            <button id="closeViewHepFooterBtn" class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Close</button>
            <button id="printFromViewBtn" class="inline-flex items-center gap-1.5 px-4 h-10 bg-primary text-white rounded-md text-sm hover:bg-indigo-700">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/></svg>
                Print HEP Sheet
            </button>
        </div>
    </div>
</div>

<!-- Print Preview Modal -->
<div id="printPreviewModal" style="display:none;" class="modal-overlay">
    <div class="modal-container" style="max-width:800px;">
        <div class="flex justify-between items-start mb-4 p-6 pb-0"><div><h3 class="text-lg font-semibold">Print HEP Sheet</h3><p class="text-gray-500" id="printPreviewSubtitle">Printable home exercise program</p></div><button id="closePrintPreviewBtn" class="text-gray-400 hover:text-gray-600"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button></div>
        <div class="p-6 pt-2"><div id="printPreviewContent" class="print-preview"></div></div>
        <div class="flex justify-end gap-2 p-6 pt-0">
    <button id="closePrintFooterBtn" class="inline-flex items-center px-4 h-10 border rounded-md text-sm hover:bg-gray-100">Close</button>
    <button id="printBtn" class="inline-flex items-center gap-1.5 px-4 h-10 bg-primary text-white rounded-md text-sm hover:bg-indigo-700">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/></svg>
        Print
    </button>
</div>
    </div>
</div>

<script src="js/features/settings-manager.js"></script>
<script src="js/core/theme.js"></script>
<script src="js/core/sidebar.js"></script>
<script src="js/core/accordion.js"></script>
<script src="js/core/notifications.js"></script>
<script src="js/core/profile.js"></script>
<script src="js/features/currency.js"></script>
<script src="js/features/tabs.js"></script>
<script src="js/features/pip-widget.js"></script>
<script src="js/features/regional.js"></script>
<script src="js/features/language.js"></script>
<script src="js/init.js"></script>

<script>
// ==================== DATA ====================
const hepPrograms = [
    { id:1, patient:"Okello David", patientId:"PT-001", programName:"Post-ACL Home Program", therapist:"Dr. Nakato Sarah", startDate:"2026-05-01", duration:4, status:"Active", adherence:85, exercises:[{name:"Straight Leg Raise",sets:3,reps:10,hold:5,freq:"Daily"},{name:"Quad Sets",sets:3,reps:15,hold:10,freq:"Daily"},{name:"Heel Slides",sets:2,reps:15,hold:3,freq:"Daily"},{name:"Ankle Pumps",sets:3,reps:20,hold:0,freq:"2x/day"}], last7Days:[true,true,true,false,true,true,true], reminders:true, reminderTime:"08:00", condition:"Post-ACL Reconstruction" },
    { id:2, patient:"Emma Davis", patientId:"PT-002", programName:"Rotator Cuff Home Rehab", therapist:"Namyalo Emma", startDate:"2026-04-20", duration:8, status:"Active", adherence:72, exercises:[{name:"Pendulum Exercise",sets:2,reps:20,hold:0,freq:"Daily"},{name:"Wall Slides",sets:2,reps:10,hold:3,freq:"Daily"}], last7Days:[true,false,true,true,true,false,true], reminders:true, reminderTime:"09:00", condition:"Rotator Cuff Repair" },
    { id:3, patient:"Mwangi Peter", patientId:"PT-003", programName:"Core Stability Program", therapist:"Dr. Nakato Sarah", startDate:"2026-06-01", duration:6, status:"Active", adherence:68, exercises:[{name:"Bridges",sets:3,reps:12,hold:5,freq:"Daily"},{name:"Plank Hold",sets:3,reps:1,hold:30,freq:"Daily"},{name:"Hamstring Stretch",sets:3,reps:1,hold:30,freq:"Daily"}], last7Days:[true,true,false,true,false,true,true], reminders:true, reminderTime:"07:30", condition:"Chronic Low Back Pain" },
    { id:4, patient:"Nansubuga Sophia", patientId:"PT-004", programName:"Stroke Recovery HEP", therapist:"Dr. Mwangi Peter", startDate:"2026-03-15", duration:12, status:"Active", adherence:55, exercises:[{name:"Ankle Pumps",sets:3,reps:20,hold:0,freq:"2x/day"},{name:"Single Leg Balance",sets:3,reps:1,hold:30,freq:"Daily"}], last7Days:[true,false,true,false,true,false,false], reminders:true, reminderTime:"10:00", condition:"Stroke Rehabilitation" },
    { id:5, patient:"Kimera Liam", patientId:"PT-005", programName:"Ankle Rehab Program", therapist:"Dr. Okello James", startDate:"2026-06-10", duration:4, status:"Active", adherence:90, exercises:[{name:"Ankle Pumps",sets:3,reps:20,hold:0,freq:"Daily"},{name:"Standing Calf Raises",sets:3,reps:15,hold:2,freq:"Daily"}], last7Days:[true,true,true,true,true,true,false], reminders:true, reminderTime:"08:30", condition:"Ankle Sprain" },
    { id:6, patient:"Nakato Olivia", patientId:"PT-006", programName:"Cervical Spine HEP", therapist:"Dr. Nakato Sarah", startDate:"2026-05-20", duration:6, status:"Completed", adherence:94, exercises:[{name:"Wall Slides",sets:2,reps:10,hold:3,freq:"Daily"}], last7Days:[true,true,true,true,true,true,true], reminders:false, reminderTime:"", condition:"Cervical Spondylosis" },
];

const hepTemplates = [
    { id:1, name:"Post-ACL Basic", category:"Orthopedic", exercises:5, duration:4, usedCount:28, description:"Basic home exercises for post-ACL reconstruction patients." },
    { id:2, name:"Low Back Pain Essentials", category:"Orthopedic", exercises:4, duration:6, usedCount:42, description:"Core stabilization and flexibility for chronic LBP." },
    { id:3, name:"Shoulder Rehab Standard", category:"Post-Surgical", exercises:4, duration:8, usedCount:18, description:"Progressive shoulder rehabilitation home program." },
    { id:4, name:"Ankle Sprain Recovery", category:"Sports", exercises:3, duration:4, usedCount:22, description:"Balance and strengthening for ankle sprain recovery." },
    { id:5, name:"Stroke Mobility Basic", category:"Neurological", exercises:5, duration:12, usedCount:15, description:"Basic mobility and strengthening post-stroke." },
    { id:6, name:"Total Hip Replacement HEP", category:"Post-Surgical", exercises:4, duration:6, usedCount:20, description:"Safe home exercises following THR surgery." },
];

let hepFilters = { search:'', status:'all' };
let adherenceFilters = { search:'' };
let activeActionMenu = null;

function showToast(msg, isError) { const t = document.createElement('div'); t.className = 'toast-message' + (isError?' error':''); t.textContent = msg; document.body.appendChild(t); setTimeout(() => t.remove(), 2500); }
function closeActionMenu() { if (activeActionMenu) { activeActionMenu.remove(); activeActionMenu = null; } }
function showActionMenu(btn, items) { closeActionMenu(); const rect = btn.getBoundingClientRect(); const menu = document.createElement('div'); menu.className = 'action-menu'; let left = rect.left, top = rect.bottom + 6; if (left + 220 > window.innerWidth) left = window.innerWidth - 230; if (top + items.length * 44 > window.innerHeight) top = rect.top - items.length * 44 - 10; menu.style.top = top + 'px'; menu.style.left = left + 'px'; let html = '<div class="action-menu-header">Actions</div>'; items.forEach((i,idx) => { if (i.divider) { html += '<div class="action-divider"></div>'; return; } html += `<button class="action-item${i.cls||''}" data-idx="${idx}"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">${i.icon}</svg>${i.label}</button>`; }); menu.innerHTML = html; document.body.appendChild(menu); activeActionMenu = menu; const closeHandler = (e) => { if (!menu.contains(e.target) && e.target !== btn) { closeActionMenu(); document.removeEventListener('click', closeHandler); } }; setTimeout(() => document.addEventListener('click', closeHandler), 10); menu.querySelectorAll('.action-item').forEach(el => { el.addEventListener('click', () => { const it = items[parseInt(el.dataset.idx)]; if (it && it.callback) it.callback(); closeActionMenu(); }); }); }

function initRadixSelect(el) { if (!el) return; const t = el.querySelector('.radix-select-trigger'), c = el.querySelector('.radix-select-content'), items = el.querySelectorAll('.radix-select-item'); if (!t || !c) return; t.addEventListener('click', (e) => { e.stopPropagation(); document.querySelectorAll('.radix-select-content').forEach(x => { if (x !== c) x.classList.add('hidden'); }); c.classList.toggle('hidden'); }); items.forEach(i => { i.addEventListener('click', (e) => { e.stopPropagation(); t.querySelector('span').textContent = i.textContent.replace(/<svg[\s\S]*?<\/svg>/g, '').trim(); t.setAttribute('data-value', i.dataset.value); items.forEach(x => x.setAttribute('data-selected', 'false')); i.setAttribute('data-selected', 'true'); c.classList.add('hidden'); }); }); }
document.querySelectorAll('.radix-select').forEach(s => initRadixSelect(s));
document.addEventListener('click', () => { document.querySelectorAll('.radix-select-content').forEach(c => c.classList.add('hidden')); });

function getAdherenceDots(last7) {
    return last7.map(d => `<span class="adherence-dot ${d?'done':'missed'}" title="${d?'Completed':'Missed'}"></span>`).join('');
}

function getStatusBadge(s) { const m = {'Active':'bg-green-100 text-green-700','Completed':'bg-blue-100 text-blue-700','Paused':'bg-amber-100 text-amber-700'}; return `<span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold ${m[s]||'bg-gray-100 text-gray-600'}">${s}</span>`; }

function renderHepGrid() {
    let filtered = [...hepPrograms];
    if (hepFilters.search) { const q = hepFilters.search.toLowerCase(); filtered = filtered.filter(h => h.patient.toLowerCase().includes(q) || h.programName.toLowerCase().includes(q) || h.therapist.toLowerCase().includes(q)); }
    if (hepFilters.status !== 'all') filtered = filtered.filter(h => h.status === hepFilters.status);
    document.getElementById('hepGrid').innerHTML = filtered.map(h => `
        <div class="hep-card transition border rounded-lg bg-white">
            <div class="hep-card-header">
                <div>
                    <div class="flex items-center gap-2"><svg class="h-4 w-4 text-indigo-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/></svg><h3 class="font-semibold text-sm">${h.programName}</h3></div>
                    <p class="text-xs text-gray-500 mt-1 flex items-center gap-1"><svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>${h.patient} <span class="text-gray-400">${h.patientId}</span></p>
                </div>
                ${getStatusBadge(h.status)}
            </div>
            <div class="hep-card-body">
                <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
                    <span class="inline-flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>${h.exercises.length} exercises</span>
                    <span class="inline-flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>${h.duration} weeks</span>
                    <span class="inline-flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>${h.adherence}%</span>
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span>Last 7 days:</span>
                    <div class="flex gap-1">${getAdherenceDots(h.last7Days)}</div>
                </div>
                ${h.reminders ? `<div class="mt-2"><span class="reminder-badge active"><svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>Reminders: ${h.reminderTime}</span></div>` : ''}
            </div>
            <div class="hep-card-footer">
                <span class="text-xs text-gray-400">Started ${h.startDate}</span>
                <div class="flex gap-1">
                    <button class="p-1.5 rounded hover:bg-gray-100 transition" onclick="event.stopPropagation();viewPrintPreview(${h.id})" title="Print"><svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/></svg></button>
                    <button class="p-1.5 rounded hover:bg-gray-100 transition hep-action-btn" data-id="${h.id}" title="More actions"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg></button>
                </div>
            </div>
        </div>`).join('') || '<p class="col-span-full text-center py-8 text-gray-500">No HEPs found</p>';
    document.querySelectorAll('.hep-action-btn').forEach(btn => { btn.addEventListener('click', (e) => { e.stopPropagation(); const h = hepPrograms.find(x => x.id == btn.dataset.id); if (h) showActionMenu(btn, [
{ icon:'<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>', label:'View Details', callback:() => viewHepDetails(h.id) },        { icon:'<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>', label:'Edit Program', callback:() => openCreateHepModal(h) },
        { icon:'<path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>', label:'Print HEP Sheet', callback:() => viewPrintPreview(h.id) },
        { icon:'<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>', label:'Toggle Reminders', callback:() => { h.reminders = !h.reminders; renderHepGrid(); showToast(`Reminders ${h.reminders?'enabled':'disabled'} for ${h.patient}`); } },
        { divider:true },
        { icon:'<path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>', label:'Deactivate HEP', cls:' text-red', callback:() => { h.status = 'Paused'; renderHepGrid(); renderAdherenceTable(); showToast(`HEP paused for ${h.patient}`); } },
    ]); }); });
}

function renderAdherenceTable() {
    let filtered = [...hepPrograms];
    if (adherenceFilters.search) { const q = adherenceFilters.search.toLowerCase(); filtered = filtered.filter(h => h.patient.toLowerCase().includes(q)); }
    document.getElementById('adherenceTableBody').innerHTML = filtered.map(h => `
        <tr class="border-b hover:bg-gray-50">
            <td class="p-4 font-medium">${h.patient} <span class="text-xs text-gray-400">${h.patientId}</span></td>
            <td class="p-4">${h.programName}</td>
            <td class="p-4">${h.exercises.length}</td>
            <td class="p-4"><div class="flex items-center gap-2"><div class="progress-bar flex-1" style="height:8px;border-radius:9999px;background:#e5e7eb;overflow:hidden;"><div style="height:100%;border-radius:9999px;width:${h.adherence}%;background:${h.adherence>=80?'#10b981':h.adherence>=60?'#f59e0b':'#ef4444'}"></div></div><span class="text-xs font-medium">${h.adherence}%</span></div></td>
            <td class="p-4 hidden md:table-cell"><div class="flex gap-1">${getAdherenceDots(h.last7Days)}</div></td>
            <td class="p-4">${getStatusBadge(h.status)}</td>
            <td class="p-4 text-right"><button class="adherence-action-btn p-1 rounded hover:bg-gray-100" data-id="${h.id}"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg></button></td>
        </tr>`).join('') || '<tr><td colspan="7" class="p-8 text-center text-gray-500">No records found</td></tr>';
    document.querySelectorAll('.adherence-action-btn').forEach(btn => { btn.addEventListener('click', (e) => { e.stopPropagation(); const h = hepPrograms.find(x => x.id == btn.dataset.id); if (h) showActionMenu(btn, [
{ icon:'<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>', label:'View Details', callback:() => viewHepDetails(h.id) },
        { icon:'<path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/>', label:'Print Report', callback:() => showToast('Printing adherence report') },
    ]); }); });
}

function renderTemplatesGrid() {
    document.getElementById('templatesGrid').innerHTML = hepTemplates.map(t => `
        <div class="hep-card border trantion bg-white rounded-lg">
            <div class="hep-card-header">
                <div>
                    <div class="flex items-center gap-2"><svg class="h-4 w-4 text-purple-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect width="6" height="4" x="9" y="3" rx="1"/></svg><h3 class="font-semibold text-sm">${t.name}</h3></div>
                    <p class="text-xs text-gray-500 mt-1"><span class="inline-flex rounded-full px-2 py-0.5 text-xs bg-purple-100 text-purple-700">${t.category}</span></p>
                </div>
            </div>
            <div class="hep-card-body">
                <p class="text-sm text-gray-500 mb-3">${t.description}</p>
                <div class="flex items-center gap-4 text-xs text-gray-500">
                    <span class="inline-flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>${t.exercises} exercises</span>
                    <span class="inline-flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>${t.duration} weeks</span>
                    <span class="inline-flex items-center gap-1"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>Used ${t.usedCount}x</span>
                </div>
            </div>
            <div class="hep-card-footer">
                <span class="text-xs text-gray-400">Template</span>
<button class="inline-flex items-center gap-1.5 px-3 h-8 rounded border border-gray-300 text-xs text-indigo-600 hover:bg-indigo-50 transition" onclick="openCreateHepModal(null,'${t.name}')"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Use Template
                </button>
            </div>
        </div>`).join('');
}

let currentViewHepId = null;

function viewHepDetails(hepId) {
    const h = hepPrograms.find(x => x.id === hepId);
    if (!h) return;
    currentViewHepId = hepId;
    
    document.getElementById('viewHepTitle').textContent = h.programName;
    document.getElementById('viewHepSubtitle').textContent = `${h.patient} (${h.patientId}) · ${h.therapist}`;
    
    document.getElementById('viewHepContent').innerHTML = `
        <div class="grid gap-4 md:grid-cols-2 mb-4">
            <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-500 flex items-center gap-1.5"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Patient</p>
                <p class="font-medium text-sm">${h.patient} <span class="text-gray-400 text-xs">${h.patientId}</span></p>
            </div>
            <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-500 flex items-center gap-1.5"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>Status</p>
                <p class="font-medium text-sm">${getStatusBadge(h.status)} · ${h.adherence}% adherence</p>
            </div>
            <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-500 flex items-center gap-1.5"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>Timeline</p>
                <p class="font-medium text-sm">Started ${h.startDate} · ${h.duration} weeks</p>
            </div>
            <div class="p-3 bg-gray-50 rounded-lg">
                <p class="text-xs text-gray-500 flex items-center gap-1.5"><svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>Reminders</p>
                <p class="font-medium text-sm">${h.reminders ? `Enabled · ${h.reminderTime}` : 'Disabled'}</p>
            </div>
        </div>
        
        ${h.condition ? `<div class="mb-4"><span class="inline-flex rounded-full px-2 py-0.5 text-xs bg-indigo-100 text-indigo-700">${h.condition}</span></div>` : ''}
        
        <div class="border-t pt-4">
            <h4 class="font-semibold text-sm mb-3 flex items-center gap-2">
                <svg class="h-4 w-4 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                Exercises (${h.exercises.length})
            </h4>
            <div class="space-y-2">
                ${h.exercises.map((e, i) => `
                    <div class="exercise-row">
                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold flex-shrink-0">${i+1}</span>
                        <div class="flex-1">
                            <p class="font-medium text-sm">${e.name}</p>
                            <p class="text-xs text-gray-500">${e.sets} sets × ${e.reps} reps · ${e.hold}s hold · ${e.freq}</p>
                        </div>
                    </div>
                `).join('')}
            </div>
        </div>
        
        <div class="border-t pt-4">
            <h4 class="font-semibold text-sm mb-2 flex items-center gap-2">
                <svg class="h-4 w-4 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                Last 7 Days Adherence
            </h4>
            <div class="flex items-center gap-3">
                <div class="flex gap-1.5">${getAdherenceDots(h.last7Days)}</div>
                <span class="text-xs text-gray-500">${h.last7Days.filter(Boolean).length}/7 days completed</span>
            </div>
        </div>
    `;
    
    document.getElementById('viewHepModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // Set up print button
    document.getElementById('printFromViewBtn').onclick = () => {
        closeViewHepModal();
        viewPrintPreview(currentViewHepId);
    };
}

function closeViewHepModal() {
    document.getElementById('viewHepModal').style.display = 'none';
    document.body.style.overflow = '';
    currentViewHepId = null;
}

document.getElementById('closeViewHepBtn')?.addEventListener('click', closeViewHepModal);
document.getElementById('closeViewHepFooterBtn')?.addEventListener('click', closeViewHepModal);
document.getElementById('viewHepModal')?.addEventListener('click', function(e) { if (e.target === this) closeViewHepModal(); });

function viewPrintPreview(hepId) {
    const h = hepPrograms.find(x => x.id === hepId); if (!h) return;
    document.getElementById('printPreviewSubtitle').textContent = `${h.patient} — ${h.programName}`;
    document.getElementById('printPreviewContent').innerHTML = `
        <div class="text-center mb-6"><h2 class="text-xl font-bold">Home Exercise Program</h2><p class="text-gray-500">${h.programName}</p></div>
        <div class="grid grid-cols-2 gap-4 mb-6 text-sm"><div><strong>Patient:</strong> ${h.patient} (${h.patientId})</div><div><strong>Therapist:</strong> ${h.therapist}</div><div><strong>Condition:</strong> ${h.condition}</div><div><strong>Start Date:</strong> ${h.startDate} · ${h.duration} weeks</div></div>
        <h4 class="font-semibold mb-3 flex items-center gap-2"><svg class="h-4 w-4 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>Exercises</h4>
        <table class="w-full text-sm mb-6" style="border-collapse:collapse;"><thead><tr style="border-bottom:2px solid #e5e7eb;"><th class="text-left p-2">#</th><th class="text-left p-2">Exercise</th><th class="text-center p-2">Sets</th><th class="text-center p-2">Reps</th><th class="text-center p-2">Hold</th><th class="text-center p-2">Frequency</th></tr></thead><tbody>${h.exercises.map((e,i) => `<tr style="border-bottom:1px solid #f3f4f6;"><td class="p-2">${i+1}</td><td class="p-2 font-medium">${e.name}</td><td class="text-center p-2">${e.sets}</td><td class="text-center p-2">${e.reps}</td><td class="text-center p-2">${e.hold}s</td><td class="text-center p-2">${e.freq}</td></tr>`).join('')}</tbody></table>
        <div class="text-xs text-gray-500 mt-4 pt-4 border-t"><strong>Reminders:</strong> ${h.reminders ? `Enabled at ${h.reminderTime}` : 'Disabled'} · <strong>Adherence:</strong> ${h.adherence}%</div>`;
    document.getElementById('printPreviewModal').style.display = 'flex'; document.body.style.overflow = 'hidden';
}
function closePrintPreview() { document.getElementById('printPreviewModal').style.display = 'none'; document.body.style.overflow = ''; }
document.getElementById('closePrintPreviewBtn')?.addEventListener('click', closePrintPreview);
document.getElementById('closePrintFooterBtn')?.addEventListener('click', closePrintPreview);
document.getElementById('printPreviewModal')?.addEventListener('click', function(e) { if (e.target === this) closePrintPreview(); });
document.getElementById('printBtn')?.addEventListener('click', () => { window.print(); showToast('Printing HEP sheet...'); });

function renumberHepExercises() {
    document.querySelectorAll('#hepExercisesList .exercise-row').forEach((row, i) => {
        const numSpan = row.querySelector('span:first-child');
        if (numSpan) numSpan.textContent = i + 1;
    });
}

function openCreateHepModal(hepData, templateName) {
    document.getElementById('hepModalTitle').textContent = hepData ? 'Edit Home Exercise Program' : 'Create Home Exercise Program';
    document.getElementById('hepProgramName').value = hepData ? hepData.programName : (templateName || '');
    document.getElementById('hepStartDate').value = hepData ? hepData.startDate : '2026-06-14';
    document.getElementById('hepDuration').value = hepData ? hepData.duration : 4;
    document.getElementById('createHepModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    // Re-init radix selects in modal
    document.querySelectorAll('#createHepModal .radix-select').forEach(s => initRadixSelect(s));
}
function closeHepModal() { document.getElementById('createHepModal').style.display = 'none'; document.body.style.overflow = ''; }
document.getElementById('closeHepModalBtn')?.addEventListener('click', closeHepModal);
document.getElementById('cancelHepBtn')?.addEventListener('click', closeHepModal);
document.getElementById('createHepModal')?.addEventListener('click', function(e) { if (e.target === this) closeHepModal(); });
document.getElementById('saveHepBtn')?.addEventListener('click', () => {
    const patientTrigger = document.querySelector('#hepPatientSelect .radix-select-trigger');
    const patientName = patientTrigger?.querySelector('span')?.textContent || '';
    const patientId = patientTrigger?.getAttribute('data-value') || '';
    if (!patientId || patientName === 'Select patient...') { showToast('Please select a patient', true); return; }
    const programName = document.getElementById('hepProgramName').value.trim() || 'Home Exercise Program';
    const exercises = [...document.querySelectorAll('#hepExercisesList .exercise-row')].map(row => ({
        name: row.querySelectorAll('input')[0]?.value || 'Exercise',
        sets: parseInt(row.querySelectorAll('input')[1]?.value) || 3,
        reps: parseInt(row.querySelectorAll('input')[2]?.value) || 10,
        hold: parseInt(row.querySelectorAll('input')[3]?.value) || 0,
        freq: row.querySelector('.radix-select-trigger')?.getAttribute('data-value') || 'Daily'
    }));
    hepPrograms.push({ id:Date.now(), patient:patientName, patientId, programName, therapist:document.querySelector('#hepTherapistSelect .radix-select-trigger')?.getAttribute('data-value')||'Dr. Nakato Sarah', startDate:document.getElementById('hepStartDate').value, duration:parseInt(document.getElementById('hepDuration').value)||4, status:'Active', adherence:0, exercises, last7Days:[false,false,false,false,false,false,false], reminders:document.getElementById('enableReminders').checked, reminderTime:document.getElementById('reminderTime').value, condition:'' });
    closeHepModal();
    renderHepGrid();
    renderAdherenceTable();
    showToast(`HEP created for ${patientName}`);
});

document.getElementById('addHepExerciseBtn')?.addEventListener('click', () => {
    const container = document.getElementById('hepExercisesList');
    const count = container.querySelectorAll('.exercise-row').length + 1;
    const div = document.createElement('div'); div.className = 'exercise-row';
    div.innerHTML = `
        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold flex-shrink-0">${count}</span>
        <div class="flex-1 grid gap-3 md:grid-cols-12 items-end">
            <div class="md:col-span-4"><label class="text-xs font-medium">Exercise</label><input class="w-full rounded-lg h-10 border border-gray-300 px-2 py-1 text-sm" placeholder="Exercise name"></div>
            <div class="md:col-span-2"><label class="text-xs font-medium">Sets</label><input type="number" class="w-full rounded-lg h-10 border border-gray-300 px-2 py-1 text-sm" value="3" min="1"></div>
            <div class="md:col-span-2"><label class="text-xs font-medium">Reps</label><input type="number" class="w-full rounded-lg h-10 border border-gray-300 px-2 py-1 text-sm" value="10" min="1"></div>
            <div class="md:col-span-2"><label class="text-xs font-medium">Hold (sec)</label><input type="number" class="w-full rounded-lg h-10 border border-gray-300 px-2 py-1 text-sm" value="5" min="0"></div>
            <div class="md:col-span-1"><label class="text-xs font-medium">Freq</label><div class="radix-select"><button type="button" class="radix-select-trigger"><span>Daily</span><svg class="h-3 w-3 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div class="radix-select-content hidden"><div class="radix-select-item" data-value="Daily" data-selected="true">Daily<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div><div class="radix-select-item" data-value="2x/day">2x/day</div><div class="radix-select-item" data-value="Every other day">Every other day</div><div class="radix-select-item" data-value="3x/week">3x/week</div></div></div></div>
            <div class="md:col-span-1 flex justify-end"><button type="button" class="text-gray-300 hover:text-red-500 transition-colors p-1" onclick="this.closest('.exercise-row').remove();renumberHepExercises()" title="Remove"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button></div>
        </div>`;
    container.appendChild(div);
    initRadixSelect(div.querySelector('.radix-select'));
    setTimeout(() => div.querySelector('input[placeholder="Exercise name"]').focus(), 100);
});

// Filters
function initFilters() {
    [{ btn:'statusFilterBtn', dropdown:'statusFilterDropdown', text:'statusFilterText', setter:'status', filterObj:hepFilters, renderFn:() => { renderHepGrid(); } }].forEach(f => {
        const btn = document.getElementById(f.btn), dd = document.getElementById(f.dropdown), txt = document.getElementById(f.text);
        if (!btn) return;
        btn.addEventListener('click', (e) => { e.stopPropagation(); closeActionMenu(); dd.classList.toggle('hidden'); });
        dd.querySelectorAll('.select-item').forEach(i => { i.addEventListener('click', () => { txt.textContent = i.textContent; f.filterObj[f.setter] = i.dataset.value; dd.classList.add('hidden'); f.renderFn(); }); });
        document.addEventListener('click', (e) => { if (!btn.contains(e.target) && !dd.contains(e.target)) dd.classList.add('hidden'); });
    });
}

// Tab switching
function activateTab(tabId) {
    ['all','adherence','templates'].forEach(t => { const p = document.getElementById(`tab-${t}`), b = document.querySelector(`.tab-btn[data-tab="${t}"]`); if(p) p.setAttribute('data-state', t===tabId?'active':'inactive'); if(b) { if(t===tabId) b.classList.add('active'); else b.classList.remove('active'); } });
    if (tabId === 'adherence') renderAdherenceTable();
    if (tabId === 'templates') renderTemplatesGrid();
}
document.querySelectorAll('.tab-btn').forEach(b => b.addEventListener('click', () => activateTab(b.dataset.tab)));

document.getElementById('hepSearch')?.addEventListener('input', (e) => { hepFilters.search = e.target.value; renderHepGrid(); });
document.getElementById('adherenceSearch')?.addEventListener('input', (e) => { adherenceFilters.search = e.target.value; renderAdherenceTable(); });


document.getElementById('refreshBtn')?.addEventListener('click', () => { renderHepGrid(); renderAdherenceTable(); renderTemplatesGrid(); showToast('Refreshed'); });
document.addEventListener('click', () => document.getElementById('profileDropdown')?.classList.add('hidden'));
document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { closeActionMenu(); closeHepModal(); closePrintPreview();closeViewHepModal();  } });
document.querySelector('.physio-toggle')?.addEventListener('click', function() { const sub = document.querySelector('.physio-submenu'), arrow = document.querySelector('.physio-arrow'); if (sub.style.display === 'none' || !sub.style.display) { sub.style.display = 'block'; arrow.style.transform = 'rotate(180deg)'; } else { sub.style.display = 'none'; arrow.style.transform = 'rotate(0deg)'; } });
document.querySelector('.physio-submenu').style.display = 'block';
document.querySelector('.physio-arrow').style.transform = 'rotate(180deg)';
function refreshAllCharts() { setTimeout(() => { window.dispatchEvent(new Event('resize')); }, 350); }
document.querySelector('.lucide-menu')?.closest('button')?.addEventListener('click', refreshAllCharts);

initFilters();
renderHepGrid();
renderTemplatesGrid();
activateTab('all');
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
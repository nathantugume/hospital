<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Business Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts" crossorigin="anonymous"></script>
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .rounded-lg.border, body.dark .bg-background { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted, body.dark .bg-gray-50 { background-color: #262626 !important; }
        body.dark input, body.dark textarea, body.dark select { background-color: #262626 !important; border-color: #404040 !important; color: #e5e5e5 !important; }
        body.dark .border-gray-200, body.dark .border-gray-300 { border-color: #404040 !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        .tab-btn { transition: all 0.2s ease; color: #6b7280; }
        .tab-btn.active { background-color: white; color: #1f2937; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        body.dark .tab-btn.active { background-color: #131212; color: #e5e5e5; }
        .tab-panel { display: none; animation: fadeIn 0.2s ease-out; }
        .tab-panel.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }
        
        .action-menu {
            position: fixed; z-index: 100; min-width: 200px;
            background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 0.25rem;
            animation: fadeInScale 0.12s ease-out;
        }
        body.dark .action-menu { background: #2a2a2a; border-color: #404040; }
        .action-menu-header { padding: 0.5rem 0.75rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb; margin-bottom: 0.25rem; }
        body.dark .action-menu-header { border-bottom-color: #404040; color: #9ca3af; }
        .action-item { padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; gap: 8px; border-radius: 0.25rem; width: 100%; background: transparent; border: none; text-align: left; color: inherit; }
        .action-item:hover { background-color: #f3f4f6; }
        body.dark .action-item:hover { background-color: #3f3f46; }
        .action-divider { height: 1px; background-color: #e5e7eb; margin: 0.25rem 0; }
        body.dark .action-divider { background-color: #404040; }
        @keyframes fadeInScale { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }

        .modal-overlay { position: fixed; inset: 0; background-color: rgb(0 0 0 / 87%); backdrop-filter: blur(2px); z-index: 1000; display: none; align-items: center; justify-content: center; }
        .modal-overlay.show { display: flex; animation: fadeIn 0.2s ease-out; }
        .modal-container { background: white; border-radius: 0.75rem; width: 100%; max-width: 650px; max-height: 85vh; overflow-y: auto; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); animation: slideUp 0.2s ease; }
        body.dark .modal-container { background: #1e293b; border: 1px solid #334155; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header { padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; background: white; z-index: 10; }
        body.dark .modal-header { border-bottom-color: #334155; background: #1e293b; }
        .modal-title { font-size: 1.125rem; font-weight: 600; }
        .modal-close { background: transparent; border: none; font-size: 1.5rem; cursor: pointer; color: #6b7280; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 0.375rem; }
        .modal-close:hover { color: #1f2937; background-color: #f3f4f6; }
        .modal-body { padding: 1.5rem; }
        .modal-footer { padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 0.75rem; position: sticky; bottom: 0; background: white; }
        body.dark .modal-footer { border-top-color: #334155; background: #1e293b; }

        .toast-message { position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white; padding: 12px 20px; border-radius: 8px; z-index: 1200; font-size: 0.875rem; animation: slideIn 0.3s ease-out; display: flex; align-items: center; gap: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }

        .status-badge { display: inline-flex; align-items: center; border-radius: 9999px; padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 600; }
        .status-active { background-color: #dcfce7; color: #166534; }
        .status-expired { background-color: #fee2e2; color: #991b1b; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-trial { background-color: #dbeafe; color: #1e40af; }
        body.dark .status-active { background-color: #14532d; color: #dcfce7; }
        body.dark .status-expired { background-color: #7f1d1d; color: #fee2e2; }
        body.dark .status-pending { background-color: #78350f; color: #fef3c7; }
        body.dark .status-trial { background-color: #1e3a5f; color: #dbeafe; }

        .data-row:hover { background-color: #f9fafb; }
        body.dark .data-row:hover { background-color: #1f1f1f; }
        .dropdown-animation { animation: fadeInScale 0.12s ease-out; }
        .filter-option:hover { background-color: #f3f4f6; }
        body.dark .filter-option:hover { background-color: #3f3f46; }

        /* ==================== GRID SYSTEM ==================== */
.grid { display: grid; }
.grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
.grid-cols-12 { grid-template-columns: repeat(12, minmax(0, 1fr)); }
.gap-6 { gap: 1.5rem; }
.items-stretch { align-items: stretch; }

.col-span-1 { grid-column: span 1 / span 1; }
.col-span-12 { grid-column: span 12 / span 12; }

@media (min-width: 640px) {
    .sm\:col-span-6 { grid-column: span 6 / span 6; }
}

@media (min-width: 1024px) {
    .lg\:grid-cols-12 { grid-template-columns: repeat(12, minmax(0, 1fr)); }
    .lg\:col-span-2 { grid-column: span 2 / span 2; }
    .lg\:col-span-4 { grid-column: span 4 / span 4; }
    .lg\:col-span-6 { grid-column: span 6 / span 6; }
}
    </style>
</head>
<body class="bg-gray-50 antialiased">

<header class="sticky top-0 z-40 border-b bg-white shadow-sm border-gray-200 dark:bg-[#131212] dark:border-[#262626]">
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
            <button id="themeToggleBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-gray-100 dark:hover:bg-[#262626] size-10" aria-label="Toggle theme">
                <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="hidden text-gray-600 dark:text-gray-300"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path></svg>
                <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-600 dark:text-gray-300"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path></svg>
            </button>
            
            <!-- Notifications Dropdown -->
            <div class="relative">
                <button id="notificationsBtn" class="inline-flex items-center justify-center rounded-md transition-colors hover:bg-gray-100 dark:hover:bg-[#262626] size-10 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path></svg>
                    <span class="absolute right-1 top-1 flex h-2 w-2 rounded-full bg-red-500"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span></span>
                </button>
                    <div id="notificationsDropdown" class="hidden absolute right-0 mt-2 z-50 w-80 rounded-md border bg-background shadow-lg overflow-hidden">
                        <div class="px-3 py-2 text-sm font-semibold flex justify-between border-b"><span>Notifications</span><button id="markAllReadBtn" class="text-xs text-gray-900">Mark all as read</button></div>
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
                        <div class="p-2 text-center border-t"><a href="notifications.html" class="text-sm text-gray-900">View all notifications</a></div>
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
    <!-- Super Admin Sidebar -->
    <aside class="!fixed h-full left-0 bottom-0 z-50 flex w-64 flex-col border-r bg-background transition-transform duration-300 ease-in-out translate-x-0 shadow-lg">
        <div class="flex py-3 xl:py-3.5 items-center justify-between px-4 border-b border-gray-200">
            <a class="flex items-center space-x-2" href="index.html"><img alt="Meditrack" width="36" height="36" src="logo.png"><span class="font-bold inline-block">Medi-track</span></a>
            <button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors hover:bg-gray-100 hover:text-gray-900 size-10 xl:hidden"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-x size-6 text-gray-600"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg></button>
        </div>
        <div class="flex-1 py-2 border-t border-gray-200 h-full overflow-y-auto custom-scrollbar">
            <nav class="space-y-1 px-2">
                <div class="space-y-1 custom-scrollbar">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="business-dashboard.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-layout-dashboard mr-2 h-4 w-4"><rect width="7" height="9" x="3" y="3" rx="1"></rect><rect width="7" height="5" x="14" y="3" rx="1"></rect><rect width="7" height="9" x="14" y="12" rx="1"></rect><rect width="7" height="5" x="3" y="16" rx="1"></rect></svg>Dashboard
                    </a>
                </div>
                <div class="space-y-1 custom-scrollbar">
                    <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors bg-indigo-50 text-indigo-700" href="companies.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-building2 mr-2 h-4 w-4"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path><path d="M10 6h4"></path><path d="M10 10h4"></path><path d="M10 14h4"></path><path d="M10 18h4"></path></svg>Companies
                    </a>
                </div>
                <div class="space-y-1 custom-scrollbar"><a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="subscriptions.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-credit-card mr-2 h-4 w-4"><rect width="20" height="14" x="2" y="5" rx="2"></rect><line x1="2" x2="22" y1="10" y2="10"></line></svg>Subscriptions</a></div>
                <div class="space-y-1 custom-scrollbar"><a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="packages.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-package mr-2 h-4 w-4"><path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"></path><path d="M12 22V12"></path></svg>Packages</a></div>
                <div class="space-y-1 custom-scrollbar"><a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="purchase-transaction.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-shopping-cart mr-2 h-4 w-4"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>Transactions</a></div>
            </nav>

        </div>
<div class="border-t border-gray-200 dark:border-[#262626] shrink-0">
    <!-- Upgrade Banner -->
    <div class="px-3 pt-3">
        <div class="trial-item bg-white dark:bg-gray-800 text-center border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden relative">
            <div class="bg-indigo-50 dark:bg-indigo-900/30 p-3 text-center">
<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-500 mx-auto lucide lucide-gem"><path d="M10.5 3 8 9l4 13 4-13-2.5-6"/><path d="M17 3a2 2 0 0 1 1.6.8l3 4a2 2 0 0 1 .013 2.382l-7.99 10.986a2 2 0 0 1-3.247 0l-7.99-10.986A2 2 0 0 1 2.4 7.8l2.998-3.997A2 2 0 0 1 7 3z"/><path d="M2 9h20"/></svg>            </div>
            <div class="p-3">
                <h6 class="text-sm font-semibold mb-1 text-gray-800 dark:text-gray-200">Enterprise Suite</h6>
                <p class="text-xs text-gray-500 mb-3">Unlimited hospitals & users</p>
                <a href="pricing.html" class="bg-primary text-white hover:bg-primary/90 w-full h-9 rounded-md text-xs font-medium flex items-center justify-center gap-1.5 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                    Upgrade Now
                </a>
            </div>
            <button class="close-icon absolute top-2 right-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 h-6 w-6 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition" onclick="this.closest('.trial-item').style.display='none'" title="Dismiss">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
            </button>
        </div>
    </div>
    <!-- User Profile -->
    <div class="p-4">
        <div class="flex items-center gap-3">
            <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span>
            <div class="space-y-0.5"><p class="text-sm font-medium">Dr. Nakato Sarah</p><p class="text-xs text-gray-500">Super Admin</p></div>
        </div>
    </div>
</div>    </aside>

    <main class="flex-1 overflow-auto p-4 xl:p-6 xl:ml-64 w-full">
        <div class="flex flex-col gap-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div><h1 class="text-2xl lg:text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Business Dashboard</h1><p class="text-gray-500">Complete overview of HMS clients, subscriptions, and financial metrics</p></div>
                <div class="flex gap-2">
                    <div class="relative">
                        <button id="dateRangeBtn" class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#262626] hover:bg-gray-50 h-10 px-4 rounded-md text-sm flex items-center gap-2 transition text-gray-700 dark:text-gray-300"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg><span id="dateRangeText">Jun 10, 2026 - Jun 10, 2026</span></button>
                        <div id="datePickerPopover" class="hidden absolute z-50 mt-2 w-[240px] rounded-md border border-gray-200 bg-background shadow-lg dark:bg-[#1c1c1e] dark:border-[#262626]"><div class="p-4 space-y-4"><div><label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-1">Start Date</label><input type="date" id="startDate" class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#262626] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div><div><label class="text-sm font-medium text-gray-700 dark:text-gray-300 block mb-1">End Date</label><input type="date" id="endDate" class="w-full rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#262626] px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></div><div class="flex gap-2 pt-2"><button id="applyDateBtn" class="flex-1 rounded-md bg-primary text-white py-2 text-sm font-medium hover:bg-primary/90">Apply</button><button id="cancelDateBtn" class="flex-1 rounded-md border border-gray-300 dark:border-gray-600 bg-white dark:bg-[#262626] py-2 text-sm font-medium hover:bg-gray-50 dark:hover:bg-[#333]">Cancel</button></div></div></div>
                    </div>
                    <button class="bg-primary text-white hover:bg-primary-hover h-10 px-4 rounded-md text-sm flex items-center gap-2 transition"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>Export Report</button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
                <div class="col-span-1 lg:col-span-4 bg-primary rounded-lg p-6 text-white relative overflow-hidden flex flex-col justify-between shadow-sm min-h-[220px]">
                    <div class="relative z-10"><div class="flex items-center gap-2 mb-2"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sun"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path></svg><h2 class="text-xl font-bold tracking-tight">Good Morning, Jonathan</h2></div><p class="text-white/95 text-lg font-medium leading-snug">14 HMS Clients <br> Active Today</p></div>
                    <div class="relative z-10 flex gap-2.5 mt-6"><button class="bg-primary border text-white hover:bg-primary/30 h-10 px-5 rounded-lg text-sm font-semibold transition shadow-sm mr-4" onclick="window.location.href='companies.html'">View Hospitals</button><button class="bg-background text-gray-950 border text-primary h-10 px-5 rounded-lg text-sm font-semibold transition shadow-sm" onclick="window.location.href='packages.html'">All Packages</button></div>
                    <div class="absolute right-2 bottom-0 top-0 w-1/3 hidden md:flex items-center justify-center pointer-events-none"><img src="dashboard.svg" alt=""></div>
                </div>
                <div class="col-span-1 sm:col-span-6 lg:col-span-2 bg-white dark:bg-[#121212] border border-gray-200 dark:border-[#262626] rounded-lg p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between"><div><div class="bg-sky-50 dark:bg-sky-950/20 p-2.5 rounded-lg w-fit mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-building2 text-sky-600"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path><path d="M10 6h4"></path><path d="M10 10h4"></path><path d="M10 14h4"></path><path d="M10 18h4"></path></svg></div><p class="text-[15px] font-medium text-gray-500 dark:text-gray-400">Total Hospitals</p></div><div class="mt-2"><p class="text-3xl font-bold">987</p><p class="text-[13px] text-emerald-600 font-semibold mt-1 flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline><polyline points="16 7 22 7 22 13"></polyline></svg><span>14%</span><span class="text-gray-400 font-normal">last month</span></p></div></div>
                <div class="col-span-1 sm:col-span-6 lg:col-span-2 bg-white dark:bg-[#121212] border border-gray-200 dark:border-[#262626] rounded-lg p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between"><div><div class="bg-emerald-50 dark:bg-emerald-950/20 p-2.5 rounded-lg w-fit mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-activity text-emerald-600"><path d="M22 12h-4l-3 9L9 3l-3 9H2"></path></svg></div><p class="text-[15px] font-medium text-gray-500 dark:text-gray-400">Active Clients</p></div><div class="mt-2"><p class="text-3xl font-bold">154</p><p class="text-[13px] text-emerald-600 font-semibold mt-1 flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline><polyline points="16 7 22 7 22 13"></polyline></svg><span>8.36%</span><span class="text-gray-400 font-normal">last month</span></p></div></div>
                <div class="col-span-1 sm:col-span-6 lg:col-span-2 bg-white dark:bg-[#121212] border border-gray-200 dark:border-[#262626] rounded-lg p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between"><div><div class="bg-pink-50 dark:bg-pink-950/20 p-2.5 rounded-lg w-fit mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock text-pink-600"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></div><p class="text-[15px] font-medium text-gray-500 dark:text-gray-400">Trial / Pending</p></div><div class="mt-2"><p class="text-3xl font-bold">12</p><p class="text-[13px] text-emerald-600 font-semibold mt-1 flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline><polyline points="16 7 22 7 22 13"></polyline></svg><span>12.8%</span><span class="text-gray-400 font-normal">last month</span></p></div></div>
                <div class="col-span-1 sm:col-span-6 lg:col-span-2 bg-white dark:bg-[#121212] border border-gray-200 dark:border-[#262626] rounded-lg p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between"><div><div class="bg-purple-50 dark:bg-purple-950/20 p-2.5 rounded-lg w-fit mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package text-purple-600"><path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"></path><path d="M12 22V12"></path></svg></div><p class="text-[15px] font-medium text-gray-500 dark:text-gray-400">Active HMS Plans</p></div><div class="mt-2"><p class="text-3xl font-bold">6</p><p class="text-[13px] text-emerald-600 font-semibold mt-1 flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trending-up"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline><polyline points="16 7 22 7 22 13"></polyline></svg><span>16%</span><span class="text-gray-400 font-normal">last month</span></p></div></div>
            </div>

            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 md:col-span-6 lg:col-span-4"><div class="rounded-lg border bg-white dark:bg-[#131212] dark:border-[#262626] shadow-sm h-full"><div class="p-4 border-b dark:border-[#262626] flex justify-between items-center"><h2 class="text-base font-semibold text-gray-900 dark:text-white">Most Subscribed Plan</h2><div class="relative"><button id="planPeriodBtn" class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#262626] hover:bg-gray-50 h-8 px-3 rounded-md text-xs flex items-center gap-1 transition text-gray-700 dark:text-gray-300">This Month <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="planPeriodDropdown" class="hidden absolute right-0 z-50 mt-1 w-36 rounded-md border bg-background dark:bg-background shadow-lg dropdown-animation"><div class="p-1"><div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-xs">Today</div><div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-xs">This Week</div><div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-xs">This Month</div><div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-xs">This Year</div></div></div></div></div><div class="p-4"><div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4"><div class="flex items-center justify-between gap-3"><div class="flex items-center gap-3 min-w-0"><div class="bg-white dark:bg-gray-700 p-2 rounded-lg border dark:border-gray-600 h-12 w-12 flex items-center justify-center shrink-0 overflow-hidden"><img src="user.png" alt="Enterprise" class="h-8 w-8 rounded-full object-cover"></div><div class="min-w-0"><p class="font-semibold text-sm truncate text-gray-900 dark:text-white">Enterprise Suite <span class="text-gray-500 dark:text-gray-400 font-normal">(Annual)</span></p><p class="text-xs text-gray-500 dark:text-gray-400">Total Hospitals: 201</p></div></div><p class="font-bold text-lg shrink-0 text-gray-900 dark:text-white">$15,000</p></div></div></div></div></div>
                <div class="col-span-12 md:col-span-6 lg:col-span-4"><div class="rounded-lg border bg-white dark:bg-[#131212] dark:border-[#262626] shadow-sm h-full"><div class="p-4 border-b dark:border-[#262626] flex justify-between items-center"><h2 class="text-base font-semibold text-gray-900 dark:text-white">Top Hospital Client</h2><div class="relative"><button id="topHospitalPeriodBtn" class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#262626] hover:bg-gray-50 h-8 px-3 rounded-md text-xs flex items-center gap-1 transition text-gray-700 dark:text-gray-300">Today <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="topHospitalPeriodDropdown" class="hidden absolute right-0 z-50 mt-1 w-36 rounded-md border bg-background dark:bg-background shadow-lg dropdown-animation"><div class="p-1"><div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-xs">Today</div><div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-xs">This Week</div><div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-xs">This Month</div><div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-xs">This Year</div></div></div></div></div><div class="p-4"><div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4"><div class="flex items-center justify-between gap-3"><div class="flex items-center gap-3 min-w-0"><div class="bg-white dark:bg-gray-700 p-2 rounded-lg border dark:border-gray-600 h-12 w-12 flex items-center justify-center shrink-0 overflow-hidden"><img src="user.png" alt="Hospital" class="h-8 w-8 rounded-full object-cover"></div><div class="min-w-0"><p class="font-semibold text-sm truncate text-gray-900 dark:text-white">Mulago National Referral Hospital</p><p class="text-xs text-gray-500 dark:text-gray-400 truncate">admin@mulago.go.ug</p></div></div><p class="font-bold shrink-0 text-gray-900 dark:text-white">3 Plans</p></div></div></div></div></div>
                <div class="col-span-12 md:col-span-6 lg:col-span-4"><div class="rounded-lg border bg-white dark:bg-[#131212] dark:border-[#262626] shadow-sm h-full"><div class="p-4 border-b dark:border-[#262626] flex justify-between items-center"><h2 class="text-base font-semibold text-gray-900 dark:text-white">Most Active Domain</h2><div class="relative"><button id="domainPeriodBtn" class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#262626] hover:bg-gray-50 h-8 px-3 rounded-md text-xs flex items-center gap-1 transition text-gray-700 dark:text-gray-300">This Week <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="domainPeriodDropdown" class="hidden absolute right-0 z-50 mt-1 w-36 rounded-md border bg-background dark:bg-background shadow-lg dropdown-animation"><div class="p-1"><div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-xs">Today</div><div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-xs">This Week</div><div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-xs">This Month</div><div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-xs">This Year</div></div></div></div></div><div class="p-4"><div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4"><div class="flex items-center justify-between gap-3"><div class="flex items-center gap-3 min-w-0"><div class="bg-white dark:bg-gray-700 p-2 rounded-lg border dark:border-gray-600 h-12 w-12 flex items-center justify-center shrink-0 overflow-hidden"><img src="user.png" alt="Domain" class="h-8 w-8 rounded-full object-cover"></div><div class="min-w-0"><p class="font-semibold text-sm truncate text-gray-900 dark:text-white">Mengo Hospital</p><p class="text-xs text-gray-500 dark:text-gray-400 truncate">metromed.meditrack.com</p></div></div><p class="font-bold shrink-0 text-gray-900 dark:text-white">150 Users</p></div></div></div></div></div>
            </div>

            <div class="w-full">
                <div class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1 dark:bg-gray-800">
                    <button data-tab="companies" class="tab-btn active rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Hospitals</button>
                    <button data-tab="plans" class="tab-btn rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Plans Expired</button>
                    <button data-tab="domains" class="tab-btn rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Domains</button>
                    <button data-tab="earnings" class="tab-btn rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Earnings</button>
                </div>

                <div id="tab-companies" class="tab-panel active mt-4"><div class="rounded-lg border bg-white dark:bg-[#131212] dark:border-[#262626] shadow-sm"><div class="p-4 border-b dark:border-[#262626] flex justify-between items-center flex-wrap gap-3"><div><h2 class="text-xl font-semibold text-gray-900 dark:text-white">Latest Registered Hospitals</h2><p class="text-gray-500 text-sm">Recent HMS client signups with plan details</p></div><div class="flex gap-2"><input type="text" id="companySearch" class="h-9 w-[200px] rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#262626] px-3 py-1.5 text-sm" placeholder="Search hospitals..."><button class="bg-primary text-white hover:bg-[#4338ca] h-9 px-4 rounded-md text-sm">View All</button></div></div><div class="overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 border-b dark:bg-gray-800 dark:border-[#262626]"><tr class="text-gray-700 dark:text-gray-300"><th class="px-4 py-3 text-left">Hospital</th><th class="px-4 py-3 text-left">HMS Plan</th><th class="px-4 py-3 text-left hidden md:table-cell">Due Date</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-right">Actions</th></tr></thead><tbody id="companiesTableBody"></tbody></table></div><div class="flex items-center justify-between px-4 py-3 border-t dark:border-[#262626]"><p class="text-sm text-gray-500">Showing 1-7 of 7 items</p><div class="flex gap-1"><button class="h-8 w-8 rounded-md border text-sm flex items-center justify-center hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-zinc-800 text-gray-500 dark:text-gray-400" disabled>←</button><button class="h-8 w-8 rounded-md bg-primary text-white text-sm">1</button><button class="h-8 w-8 rounded-md border text-sm flex items-center justify-center hover:bg-gray-100 dark:border-gray-700 dark:hover:bg-zinc-800 text-gray-500 dark:text-gray-400" disabled>→</button></div></div></div></div>
                <div id="tab-plans" class="tab-panel mt-4"><div class="rounded-lg border bg-white dark:bg-[#131212] dark:border-[#262626] shadow-sm"><div class="p-4 border-b dark:border-[#262626] flex justify-between items-center"><div><h2 class="text-xl font-semibold text-gray-900 dark:text-white">Recent Plan Expired</h2><p class="text-gray-500 text-sm">Hospitals with expired subscriptions requiring attention</p></div><button class="bg-primary text-white hover:bg-indigo-700 h-9 px-4 rounded-md text-sm">Send Reminders</button></div><div class="overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 border-b dark:bg-gray-800 dark:border-[#262626]"><tr class="text-gray-700 dark:text-gray-300"><th class="px-4 py-3 text-left">Hospital</th><th class="px-4 py-3 text-left">Plan</th><th class="px-4 py-3 text-left hidden md:table-cell">Expired On</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-right">Actions</th></tr></thead><tbody id="expiredTableBody"></tbody></table></div></div></div>
                <div id="tab-domains" class="tab-panel mt-4"><div class="rounded-lg border bg-white dark:bg-[#131212] dark:border-[#262626] shadow-sm"><div class="p-4 border-b dark:border-[#262626]"><h2 class="text-xl font-semibold text-gray-900 dark:text-white">Recent Domains</h2><p class="text-gray-500 text-sm">Domain verification and management for HMS clients</p></div><div class="overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 border-b dark:bg-gray-800 dark:border-[#262626]"><tr class="text-gray-700 dark:text-gray-300"><th class="px-4 py-3 text-left">Hospital</th><th class="px-4 py-3 text-left">Plan</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-right">Actions</th></tr></thead><tbody id="domainsTableBody"></tbody></table></div></div></div>
                <div id="tab-earnings" class="tab-panel mt-4"><div class="grid grid-cols-12 gap-6"><div class="col-span-12 lg:col-span-6"><div class="rounded-lg border bg-white dark:bg-[#131212] dark:border-[#262626] shadow-sm"><div class="p-4 border-b dark:border-[#262626] flex justify-between items-center flex-wrap gap-3"><h2 class="text-xl font-semibold text-gray-900 dark:text-white">HMS Revenue Overview</h2><div class="flex items-center gap-3"><div class="flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400"><span class="w-3 h-3 rounded-full bg-indigo-500 inline-block"></span> Income</div><div class="flex items-center gap-1.5 text-sm text-gray-600 dark:text-gray-400"><span class="w-3 h-3 rounded-full bg-purple-200 inline-block"></span> Remaining</div><input type="text" class="border border-gray-300 dark:border-gray-700 rounded-md px-3 py-1.5 text-sm w-20 bg-white dark:bg-[#262626]" value="2024"></div></div><div class="p-4"><div id="earningsChart" style="min-height: 350px;"></div></div></div></div><div class="col-span-12 lg:col-span-6"><div class="rounded-lg border bg-white dark:bg-[#131212] dark:border-[#262626] shadow-sm"><div class="p-4 border-b dark:border-[#262626] flex justify-between items-center"><h2 class="text-xl font-semibold text-gray-900 dark:text-white">Hospitals Registered</h2><div class="relative">
    <button id="registerPeriodBtn" class="border border-gray-300 dark:border-gray-700 bg-white dark:bg-[#262626] hover:bg-gray-50 h-9 px-3 rounded-md text-xs flex items-center gap-1 transition text-gray-700 dark:text-gray-300">
        <span>This Week</span>
        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
    </button>
    <div id="registerPeriodDropdown" class="hidden absolute right-0 z-50 mt-1 w-36 rounded-md border bg-background dark:bg-[#1c1c1e] shadow-lg dropdown-animation">
        <div class="p-1">
            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-xs">Today</div>
            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-xs">This Week</div>
            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-xs">This Month</div>
            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-xs">This Year</div>
        </div>
    </div>
</div></div><div class="p-4"><div id="registerChart" style="min-height: 335px;"></div></div></div></div><div class="col-span-12"><div class="rounded-lg border bg-white dark:bg-[#131212] dark:border-[#262626] shadow-sm"><div class="p-4 border-b dark:border-[#262626] flex justify-between items-center"><h2 class="text-xl font-semibold text-gray-900 dark:text-white">Top HMS Plans Performance</h2><button class="bg-primary text-white hover:bg-indigo-700 h-9 px-4 rounded-md text-sm">View All Plans</button></div><div class="p-4"><div id="plansChart" style="min-height: 350px;"></div></div></div></div></div></div>
            </div>
        </div>
    </main>
</div>

<div id="addHospitalModal" class="modal-overlay"><div class="modal-container"><div class="modal-header"><h2 class="modal-title">Add New Hospital Client</h2><button class="modal-close" data-close="addHospitalModal">&times;</button></div><div class="modal-body"><div class="space-y-4"><div class="grid grid-cols-2 gap-4"><div><label class="text-sm font-medium block mb-1">Hospital Name</label><input type="text" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm bg-white dark:bg-[#262626] dark:border-gray-600"></div><div><label class="text-sm font-medium block mb-1">Admin Email</label><input type="email" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm bg-white dark:bg-[#262626] dark:border-gray-600"></div></div><div class="grid grid-cols-2 gap-4"><div><label class="text-sm font-medium block mb-1">HMS Plan</label><select class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm bg-white dark:bg-[#262626] dark:border-gray-600"><option>Enterprise Suite</option><option>Professional Growth</option><option>Essential Care</option></select></div><div><label class="text-sm font-medium block mb-1">Status</label><select class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm bg-white dark:bg-[#262626] dark:border-gray-600"><option>Active</option><option>Trial</option><option>Pending</option></select></div></div></div></div><div class="modal-footer"><button class="border border-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-100" data-close="addHospitalModal">Cancel</button><button class="bg-primary text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">Add Hospital</button></div></div></div>


<!-- 1. Settings Manager FIRST -->
<script src="js/features/settings-manager.js"></script>

<!-- 2. Core -->
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

<!-- 4. Init Last -->
<script src="js/init.js"></script>

<script>
    const companies = [
        { name: "Mulago National Referral Hospital", plan: "Enterprise Suite", due: "18 Oct 2024", status: "Active" },
        { name: "Mengo Hospital", plan: "Professional Growth", due: "25 Oct 2024", status: "Active" },
        { name: "Nakasero Hospital", plan: "Essential Care", due: "22 Sep 2024", status: "Trial" },
        { name: "AAR Healthcare", plan: "Professional Growth", due: "20 Feb 2025", status: "Active" },
        { name: "King Faisal Hospital", plan: "Enterprise Suite", due: "12 Nov 2024", status: "Trial" },
        { name: "Addis Ababa Mulago Hospital", plan: "Enterprise Suite", due: "15 Sep 2024", status: "Pending" },
        { name: "Kenyatta National Hospital", plan: "Professional Growth", due: "04 Mar 2025", status: "Active" }
    ];
    const expiredPlans = [
        { name: "International Hospital Kampala", plan: "Essential Care", expired: "18 Oct 2024" },
        { name: "Muhimbili National Hospital", plan: "Essential Care", expired: "12 Nov 2024" },
        { name: "Mbarara Regional Referral", plan: "Essential Care", expired: "22 Sep 2024" },
        { name: "Jinja Regional Referral", plan: "Essential Care", expired: "04 Mar 2025" },
        { name: "Rubaga Hospital", plan: "Essential Care", expired: "20 Feb 2025" },
        { name: "Victoria Hospital Bukoba", plan: "Essential Care", expired: "25 Oct 2024" },
        { name: "Nsambya Hospital", plan: "Essential Care", expired: "15 Sep 2024" }
    ];
    const domains = [
        { name: "Aga Khan Hospital", plan: "Essential Care" },
        { name: "Gulu Regional Referral", plan: "Professional Growth" },
        { name: "St. Francis Hospital Nsambya", plan: "Professional Growth" },
        { name: "Uganda Cancer Institute", plan: "Professional Growth" },
        { name: "Mulago Pediatric Ward", plan: "Essential Care" },
        { name: "Bugando Medical Centre", plan: "Essential Care" },
        { name: "Mengo Hospital", plan: "Professional Growth" }
    ];

    let activeMenu = null;
    function closeMenu() { if(activeMenu) { activeMenu.remove(); activeMenu = null; } }
    function getStatusBadge(s) { const m = {'Active':'status-active','Expired':'status-expired','Pending':'status-pending','Trial':'status-trial'}; return `<span class="status-badge ${m[s]||'status-active'}">${s}</span>`; }
    function showToast(msg, err=false) { const e = document.querySelector('.toast-message'); if(e) e.remove(); const t = document.createElement('div'); t.className = `toast-message ${err?'error':''}`; t.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle>${err?'<line x1="12" x2="12" y1="8" y2="12"></line>':'<path d="m9 12 2 2 4-4"></path>'}</svg> ${msg}`; document.body.appendChild(t); setTimeout(() => t.remove(), 3500); }
    function openModal(id) { document.getElementById(id)?.classList.add('show'); }
    function closeModal(id) { document.getElementById(id)?.classList.remove('show'); }

    function showActionMenu(btn, item, type) {
        closeMenu(); const rect = btn.getBoundingClientRect(); const menu = document.createElement('div'); menu.className = 'action-menu';
        let left = rect.left, top = rect.bottom + 6; if (left + 220 > window.innerWidth) left = window.innerWidth - 230; if (top + 220 > window.innerHeight) top = rect.top - 230; if (left < 10) left = 10; if (top < 10) top = 10;
        menu.style.top = top + 'px'; menu.style.left = left + 'px';
        menu.innerHTML = `<div class="action-menu-header">Actions</div>
            <button data-action="edit" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path></svg>Edit ${type}</button>
            <button data-action="viewDoctors" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>View Details</button>
            <div class="action-divider"></div>
            <button data-action="delete" class="action-item text-red-600"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>Delete</button>`;
        document.body.appendChild(menu); activeMenu = menu;
menu.addEventListener('click', e => { 
    const action = e.target.closest('[data-action]')?.dataset.action; 
    if (!action) return; 
    closeMenu(); 
    if (action === 'edit') {
        // Open edit modal or navigate to edit page
        if (type === 'Hospital') window.location.href = 'companies.html';
        else if (type === 'Plan') window.location.href = 'subscription.html';
        else if (type === 'Domain') window.location.href = 'companies.html';
    }
    else if (action === 'viewDoctors') {
        // View details
        if (type === 'Hospital') window.location.href = 'companies.html';
        else if (type === 'Plan') window.location.href = 'subscription.html';
        else if (type === 'Domain') window.location.href = 'companies.html';
    }
    else if (action === 'delete') {
        // Show delete confirmation
        if (confirm(`Are you sure you want to delete "${item.name}"?`)) {
            if (type === 'Hospital') {
                const idx = companies.findIndex(x => x.name === item.name);
                if (idx > -1) { companies.splice(idx, 1); renderCompanies(); }
            } else if (type === 'Plan') {
                const idx = expiredPlans.findIndex(x => x.name === item.name);
                if (idx > -1) { expiredPlans.splice(idx, 1); renderExpired(); }
            } else if (type === 'Domain') {
                const idx = domains.findIndex(x => x.name === item.name);
                if (idx > -1) { domains.splice(idx, 1); renderDomains(); }
            }
        }
    }
});
        setTimeout(() => { document.addEventListener('click', function closeHandler(e) { if (!menu.contains(e.target) && e.target !== btn) { closeMenu(); document.removeEventListener('click', closeHandler); } }, { once: false }); }, 10);
    }

    function renderCompanies() { document.getElementById('companiesTableBody').innerHTML = companies.map(c => `<tr class="border-b dark:border-[#262626] data-row"><td class="px-4 py-3"><div class="flex items-center gap-3"><span class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="${c.name}"></span><span class="font-medium text-gray-900 dark:text-white">${c.name}</span></div></td><td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">${c.plan}</td><td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 hidden md:table-cell">${c.due}</td><td class="px-4 py-3">${getStatusBadge(c.status)}</td><td class="px-4 py-3 text-right"><button class="action-trigger inline-flex items-center justify-center h-10 w-10 rounded-md hover:bg-gray-100" data-name="${c.name}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button></td></tr>`).join('');
        document.querySelectorAll('#companiesTableBody .action-trigger').forEach(btn => { btn.addEventListener('click', e => { e.stopPropagation(); const c = companies.find(x => x.name === btn.dataset.name); if (c) showActionMenu(btn, c, 'Hospital'); }); }); }
    function renderExpired() { document.getElementById('expiredTableBody').innerHTML = expiredPlans.map(e => `<tr class="border-b dark:border-[#262626] data-row"><td class="px-4 py-3"><div class="flex items-center gap-3"><span class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="${e.name}"></span><span class="font-medium text-gray-900 dark:text-white">${e.name}</span></div></td><td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">${e.plan}</td><td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400 hidden md:table-cell">${e.expired}</td><td class="px-4 py-3">${getStatusBadge('Expired')}</td><td class="px-4 py-3 text-right"><button class="action-trigger inline-flex items-center justify-center h-10 w-10 rounded-md hover:bg-gray-100" data-name="${e.name}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button></td></tr>`).join('');
        document.querySelectorAll('#expiredTableBody .action-trigger').forEach(btn => { btn.addEventListener('click', e => { e.stopPropagation(); const c = expiredPlans.find(x => x.name === btn.dataset.name); if (c) showActionMenu(btn, c, 'Plan'); }); }); }
    function renderDomains() { document.getElementById('domainsTableBody').innerHTML = domains.map(d => `<tr class="border-b dark:border-[#262626] data-row"><td class="px-4 py-3"><div class="flex items-center gap-3"><span class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="${d.name}"></span><span class="font-medium text-gray-900 dark:text-white">${d.name}</span></div></td><td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">${d.plan}</td><td class="px-4 py-3">${getStatusBadge('Active')}</td><td class="px-4 py-3 text-right"><button class="action-trigger inline-flex items-center justify-center h-10 w-10 rounded-md hover:bg-gray-100" data-name="${d.name}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button></td></tr>`).join('');
        document.querySelectorAll('#domainsTableBody .action-trigger').forEach(btn => { btn.addEventListener('click', e => { e.stopPropagation(); const c = domains.find(x => x.name === btn.dataset.name); if (c) showActionMenu(btn, c, 'Domain'); }); }); }

    function initCharts() {
        new ApexCharts(document.querySelector("#earningsChart"), { series: [{name:'Income',data:[22,40,27,53,40,27,35,27,43,24,45,56]},{name:'Remaining',data:[12,20,13,27,20,13,19,13,22,12,23,29]}], chart:{type:'bar',height:350,toolbar:{show:false},stacked:true}, colors:['#7539ff','#e6e4f6'], plotOptions:{bar:{borderRadius:6,columnWidth:'55%'}}, xaxis:{categories:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']}, legend:{show:false}, grid:{borderColor:'#e5e7eb'} }).render();
        new ApexCharts(document.querySelector("#registerChart"), { series:[{name:'Hospitals',data:[28,35,38,40,35,30,42]}], chart:{type:'area',height:335,toolbar:{show:false}}, colors:['#7b4dff'], fill:{type:'gradient',gradient:{shade:'light',opacityFrom:0.8,opacityTo:0.1}}, stroke:{curve:'smooth',width:3}, markers:{size:4}, xaxis:{categories:['Mon','Tue','Wed','Thu','Fri','Sat','Sun']}, grid:{borderColor:'#e5e7eb'} }).render();
new ApexCharts(document.querySelector("#plansChart"), { 
    series:[{data:[400,325,312,294,254,254]}], 
    chart:{type:'bar',height:350,toolbar:{show:false}}, 
    colors:['#4f46e5','#059669','#d97706','#dc2626','#7c3aed','#0891b2'], 
    plotOptions:{bar:{borderRadius:6,horizontal:true,barHeight:'65%',distributed:true}}, 
    dataLabels:{enabled:true,formatter:function(val,opt){
        const labels=['Enterprise Suite • $15,000','Professional Growth • $8,400','Essential Care • $4,200','Enterprise (Q) • $4,100','Professional (M) • $899','Essential (M) • $399'];
        return labels[opt.dataPointIndex]+' | Hospitals: '+val;
    },style:{fontSize:'11px',fontWeight:600,colors:['#fff']}}, 
    xaxis:{categories:['Enterprise Suite','Professional Growth','Essential Care','Enterprise (Q)','Professional (M)','Essential (M)']}, 
    grid:{borderColor:'#e5e7eb'}, legend:{show:false} 
}).render();

}

    document.querySelectorAll('.tab-btn').forEach(btn => { btn.addEventListener('click', () => { const tab = btn.dataset.tab; document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active')); document.getElementById(`tab-${tab}`).classList.add('active'); document.querySelectorAll('.tab-btn').forEach(b => { b.classList.remove('active','bg-white','text-gray-900','shadow-sm'); }); btn.classList.add('active','bg-white','text-gray-900','shadow-sm'); }); });

    // Date Picker
    const dateRangeBtn = document.getElementById('dateRangeBtn'), datePickerPopover = document.getElementById('datePickerPopover');
    dateRangeBtn?.addEventListener('click', (e) => { e.stopPropagation(); datePickerPopover.classList.toggle('hidden'); });
    document.getElementById('applyDateBtn')?.addEventListener('click', () => { datePickerPopover.classList.add('hidden'); showToast('Date range updated'); });
    document.getElementById('cancelDateBtn')?.addEventListener('click', () => datePickerPopover.classList.add('hidden'));
    document.addEventListener('click', (e) => { if (!dateRangeBtn?.contains(e.target) && !datePickerPopover?.contains(e.target)) datePickerPopover?.classList.add('hidden'); });

    // Period Dropdowns
    ['planPeriodBtn','topHospitalPeriodBtn','domainPeriodBtn','registerPeriodBtn'].forEach(btnId => {
        const btn = document.getElementById(btnId), dropdownId = btnId.replace('Btn','Dropdown'), dropdown = document.getElementById(dropdownId);
        btn?.addEventListener('click', (e) => { e.stopPropagation(); document.querySelectorAll('[id$="PeriodDropdown"]').forEach(d => { if (d !== dropdown) d.classList.add('hidden'); }); dropdown.classList.toggle('hidden'); });
        dropdown?.querySelectorAll('.filter-option').forEach(opt => { opt.addEventListener('click', () => { btn.querySelector('span') ? btn.innerHTML = opt.textContent + ' <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>' : null; dropdown.classList.add('hidden'); }); });
    });
    document.addEventListener('click', (e) => { if (!e.target.closest('[id$="PeriodBtn"]')) document.querySelectorAll('[id$="PeriodDropdown"]').forEach(d => d.classList.add('hidden')); });

    document.querySelectorAll('.modal-close, [data-close]').forEach(b => b.addEventListener('click', (e) => { e.stopPropagation(); closeModal(b.dataset.close || b.closest('.modal-overlay').id); }));
    document.querySelectorAll('.modal-overlay').forEach(o => o.addEventListener('click', (e) => { if (e.target === o) closeModal(o.id); }));
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { closeModal('addHospitalModal'); closeMenu(); } });

    renderCompanies(); renderExpired(); renderDomains(); initCharts();
    document.querySelector('[data-tab="companies"]').classList.add('active','bg-white','text-gray-900','shadow-sm');
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
    <script src="js/meditrack-apex-data.js"></script>
    <script src="js/meditrack-pagination.js"></script>
    <script src="js/meditrack-search.js"></script>
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
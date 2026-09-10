<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Companies</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .rounded-lg.border { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted { background-color: #262626 !important; }
        body.dark input, body.dark textarea { background-color: #262626 !important; border-color: #404040 !important; color: #e5e5e5 !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        .tab-btn { transition: all 0.2s ease; color: #6b7280; }
        .tab-btn.active { background-color: white; color: #1f2937; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        body.dark .tab-btn.active { background-color: #131212; color: #e5e5e5; }

        .action-menu {
            position: fixed; z-index: 100; min-width: 210px;
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

        .modal-overlay {
            position: fixed; inset: 0; background-color: rgb(0 0 0 / 87%);
            backdrop-filter: blur(2px); z-index: 1000; display: none;
            align-items: center; justify-content: center;
        }
        .modal-overlay.show { display: flex; animation: fadeIn 0.2s ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .modal-container {
            background: white; border-radius: 0.75rem; width: 100%;
            max-width: 600px; max-height: 85vh; overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); animation: slideUp 0.2s ease;
        }
        body.dark .modal-container { background: #1e293b; border: 1px solid #334155; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header {
            padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb;
            display: flex; justify-content: space-between; align-items: center;
            position: sticky; top: 0; background: white; z-index: 10;
        }
        body.dark .modal-header { border-bottom-color: #334155; background: #1e293b; }
        .modal-title { font-size: 1.125rem; font-weight: 600; }
        .modal-close {
            background: transparent; border: none; font-size: 1.5rem; cursor: pointer;
            color: #6b7280; line-height: 1; padding: 0;
            width: 28px; height: 28px; display: flex;
            align-items: center; justify-content: center; border-radius: 0.375rem;
        }
        .modal-close:hover { color: #1f2937; background-color: #f3f4f6; }
        body.dark .modal-close:hover { color: #e5e5e5; background-color: #374151; }
        .modal-body { padding: 1.5rem; }
        .modal-footer {
            padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb;
            display: flex; justify-content: flex-end; gap: 0.75rem;
            position: sticky; bottom: 0; background: white;
        }
        body.dark .modal-footer { border-top-color: #334155; background: #1e293b; }

        .alert-dialog-overlay {
            position: fixed; inset: 0; background-color: rgb(0 0 0 / 87%);
            z-index: 1100; display: none; align-items: center; justify-content: center;
        }
        .alert-dialog-overlay.show { display: flex; animation: fadeIn 0.2s ease-out; }
        .alert-dialog {
            background-color: white; border-radius: 0.75rem; width: 90%;
            max-width: 450px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            animation: slideUp 0.2s ease; overflow: hidden;
        }
        body.dark .alert-dialog { background-color: #1f1f1f; border: 1px solid #333; }
        .alert-dialog-header { padding: 1.5rem 1.5rem 0.75rem 1.5rem; }
        .alert-dialog-title { font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0 0 0.5rem 0; }
        body.dark .alert-dialog-title { color: #f3f4f6; }
        .alert-dialog-description { font-size: 0.875rem; color: #6b7280; line-height: 1.5; margin: 0; }
        body.dark .alert-dialog-description { color: #9ca3af; }
        .alert-dialog-footer { padding: 1rem 1.5rem 1.5rem 1.5rem; display: flex; justify-content: flex-end; gap: 0.75rem; }
        .alert-dialog-cancel {
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 0.5rem; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500;
            background-color: transparent; border: 1px solid #e5e7eb; color: #374151; cursor: pointer;
        }
        body.dark .alert-dialog-cancel { border-color: #404040; color: #e5e5e5; }
        .alert-dialog-delete {
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 0.5rem; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500;
            background-color: #ef4444; border: none; color: white; cursor: pointer;
        }
        .alert-dialog-delete:hover { background-color: #dc2626; }

        .toast-message {
            position: fixed; bottom: 20px; right: 20px; background: #10b981;
            color: white; padding: 12px 20px; border-radius: 8px; z-index: 1200;
            font-size: 0.875rem; animation: slideIn 0.3s ease-out;
            display: flex; align-items: center; gap: 8px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }

        .dropdown-animation { animation: fadeInScale 0.12s ease-out; }
        .filter-option:hover { background-color: #f3f4f6; }
        body.dark .filter-option:hover { background-color: #3f3f46; }

        .status-badge { display: inline-flex; align-items: center; border-radius: 9999px; padding: 0.25rem 0.625rem; font-size: 0.75rem; font-weight: 600; }
        .status-active { background-color: #dcfce7; color: #166534; }
        .status-inactive { background-color: #fee2e2; color: #991b1b; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-suspended { background-color: #f3f4f6; color: #6b7280; }
        .status-trial { background-color: #dbeafe; color: #1e40af; }
        body.dark .status-active { background-color: #14532d; color: #dcfce7; }
        body.dark .status-inactive { background-color: #7f1d1d; color: #fee2e2; }
        body.dark .status-pending { background-color: #78350f; color: #fef3c7; }
        body.dark .status-suspended { background-color: #374151; color: #d1d5db; }
        body.dark .status-trial { background-color: #1e3a5f; color: #dbeafe; }

        .data-row:hover { background-color: #f9fafb; }
        body.dark .data-row:hover { background-color: #1f1f1f; }

        /* Radix Select Styles */
        .select-trigger {
            display: flex; height: 2.5rem; width: 100%;
            align-items: center; justify-content: space-between;
            border-radius: 0.375rem; border: 1px solid #d1d5db;
            background-color: #ffffff; padding: 0 0.75rem;
            font-size: 0.875rem; cursor: pointer; transition: all 0.15s ease;
            color: #374151;
        }
        .select-trigger:hover { border-color: #9ca3af; }
        .select-trigger:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99,102,241,0.2); }
        body.dark .select-trigger { background-color: #262626; border-color: #404040; color: #e5e5e5; }
        .select-content {
            position: absolute; z-index: 50; background-color: white;
            border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
            border: 1px solid #e5e7eb; margin-top: 4px; width: 100%;
            max-height: 240px; overflow-y: auto; animation: fadeInScale 0.12s ease-out;
        }
        body.dark .select-content { background-color: #1e293b; border-color: #334155; }
        .select-item {
            padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer;
            transition: background 0.1s; display: flex; align-items: center; gap: 0.5rem;
        }
        .select-item:hover { background-color: #f3f4f6; }
        body.dark .select-item:hover { background-color: #334155; }
        .select-item.selected { background-color: #eef2ff; color: #4338ca; font-weight: 500; }
        body.dark .select-item.selected { background-color: #1e1b4b; color: #a5b4fc; }
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
        <div class="flex flex-col gap-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div><h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Companies</h1><p class="text-gray-500">Manage hospital clients using your HMS platform</p></div>
                <div class="flex gap-2">
                    <button id="exportBtn" class="border border-gray-300 bg-background hover:bg-gray-50 h-10 px-4 rounded-md text-sm flex items-center gap-2 transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>Export
                    </button>
                    <button id="addCompanyBtn" class="bg-primary text-white hover:bg-primary/90 h-10 px-4 rounded-md text-sm flex items-center gap-2 transition">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 12h14M12 5v14"/></svg>Add Company
                    </button>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-4">
                <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition cursor-pointer" id="cardTotal"><div class="p-4 pb-2"><div class="flex items-center justify-between"><h2 class="text-sm font-medium text-gray-500">Total Companies</h2><svg class="h-5 w-5 text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path></svg></div></div><div class="p-4 pt-0"><div class="text-2xl font-bold text-indigo-600" id="statTotal">20</div><p class="text-xs text-gray-400 mt-1">HMS clients</p></div></div>
                <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition cursor-pointer" id="cardActive"><div class="p-4 pb-2"><div class="flex items-center justify-between"><h2 class="text-sm font-medium text-gray-500">Active</h2><svg class="h-5 w-5 text-green-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg></div></div><div class="p-4 pt-0"><div class="text-2xl font-bold text-green-600" id="statActive">14</div><p class="text-xs text-gray-400 mt-1">Live accounts</p></div></div>
                <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition cursor-pointer" id="cardTrial"><div class="p-4 pb-2"><div class="flex items-center justify-between"><h2 class="text-sm font-medium text-gray-500">On Trial</h2><svg class="h-5 w-5 text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div></div><div class="p-4 pt-0"><div class="text-2xl font-bold text-blue-600" id="statTrial">4</div><p class="text-xs text-gray-400 mt-1">Evaluating HMS</p></div></div>
                <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition cursor-pointer" id="cardInactive"><div class="p-4 pb-2"><div class="flex items-center justify-between"><h2 class="text-sm font-medium text-gray-500">Inactive</h2><svg class="h-5 w-5 text-red-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"></path></svg></div></div><div class="p-4 pt-0"><div class="text-2xl font-bold text-red-600" id="statInactive">2</div><p class="text-xs text-gray-400 mt-1">Suspended/expired</p></div></div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="relative">
                    <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input id="searchInput" type="text" placeholder="Search by company, email, plan..." class="pl-8 w-[200px] md:w-[400px] h-10 rounded-md border border-gray-300 px-3 py-2 text-sm bg-white">
                </div>
                <div class="flex gap-2 flex-wrap">
                    <div class="relative">
                        <button id="statusFilterBtn" class="flex h-10 w-[150px] items-center justify-between rounded-md border border-gray-300 bg-background px-3 py-2 text-sm">
                            <span id="statusFilterText">All Status</span>
                            <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div id="statusFilterDropdown" class="hidden absolute z-50 mt-1 w-full rounded-md border bg-background shadow-lg dropdown-animation"><div class="p-1">
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="all">All Status</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="Active">Active</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="Trial">Trial</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="Pending">Pending</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="Suspended">Suspended</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="Inactive">Inactive</div>
                        </div></div>
                    </div>
                </div>
            </div>

            <div class="w-full">
                <div class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1 dark:bg-gray-800">
                    <button data-tab="all" class="tab-btn active rounded-sm px-3 py-1.5 text-sm font-medium transition-all">All Companies</button>
                    <button data-tab="active" class="tab-btn rounded-sm px-3 py-1.5 text-sm font-medium">Active</button>
                    <button data-tab="trial" class="tab-btn rounded-sm px-3 py-1.5 text-sm font-medium">Trial</button>
                    <button data-tab="inactive" class="tab-btn rounded-sm px-3 py-1.5 text-sm font-medium">Inactive</button>
                </div>
                <div class="mt-4 rounded-lg border bg-background shadow-sm overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-3 text-left">Company</th>
                                <th class="px-4 py-3 text-left hidden md:table-cell">Email</th>
                                <th class="px-4 py-3 text-left hidden lg:table-cell">Account URL</th>
                                <th class="px-4 py-3 text-left">Plan</th>
                                <th class="px-4 py-3 text-left hidden lg:table-cell">Created On</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="companiesTableBody"></tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between mt-4 px-2">
                    <p class="text-sm text-gray-500" id="showingText">Showing 1-10 of 20 companies</p>
                    <div class="flex gap-1">
                        <button id="prevPageBtn" class="inline-flex items-center justify-center h-10 w-10 rounded-md border text-sm hover:bg-gray-100" disabled><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
                        <button class="page-btn inline-flex items-center justify-center h-10 w-10 rounded-md bg-primary text-white text-sm font-medium" data-page="1">1</button>
                        <button class="page-btn inline-flex items-center justify-center h-10 w-10 rounded-md text-sm hover:bg-gray-100" data-page="2">2</button>
                        <button id="nextPageBtn" class="inline-flex items-center justify-center h-10 w-10 rounded-md border text-sm hover:bg-gray-100"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Add/Edit Company Modal with Radix Select -->
<div id="companyModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header"><h2 class="modal-title" id="companyModalTitle">Add Company</h2><button class="modal-close" data-close="companyModal">&times;</button></div>
        <div class="modal-body">
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-sm font-medium block mb-1">Company Name <span class="text-red-500">*</span></label><input type="text" id="companyName" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Enter company name"></div>
                    <div><label class="text-sm font-medium block mb-1">Email <span class="text-red-500">*</span></label><input type="email" id="companyEmail" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="company@hospital.ug"></div>
                </div>
                <div><label class="text-sm font-medium block mb-1">Account URL</label><input type="text" id="companyUrl" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="company.meditrack.com"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium block mb-1">Plan <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <button id="planSelectBtn" class="select-trigger justify-between" type="button">
                                <span id="planSelectText">Essential Care</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                            </button>
                            <div id="planSelectDropdown" class="select-content hidden">
                                <div class="select-item" data-value="Essential Care">Essential Care</div>
                                <div class="select-item" data-value="Professional Growth">Professional Growth</div>
                                <div class="select-item" data-value="Enterprise Suite">Enterprise Suite</div>
                                <div class="select-item" data-value="Custom Plan">Custom Plan</div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-medium block mb-1">Status <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <button id="statusSelectBtn" class="select-trigger justify-between" type="button">
                                <span id="statusSelectText">Active</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                            </button>
                            <div id="statusSelectDropdown" class="select-content hidden">
                                <div class="select-item" data-value="Active">Active</div>
                                <div class="select-item" data-value="Trial">Trial</div>
                                <div class="select-item" data-value="Pending">Pending</div>
                                <div class="select-item" data-value="Suspended">Suspended</div>
                                <div class="select-item" data-value="Inactive">Inactive</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div><label class="text-sm font-medium block mb-1">Contact Person</label><input type="text" id="companyContact" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Contact person name"></div>
                <div><label class="text-sm font-medium block mb-1">Phone</label><input type="tel" id="companyPhone" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Phone number"></div>
                <div><label class="text-sm font-medium block mb-1">Notes</label><textarea id="companyNotes" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Additional notes..."></textarea></div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="border border-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-100" data-close="companyModal">Cancel</button>
            <button id="saveCompanyBtn" class="bg-primary text-white px-4 py-2 rounded-md text-sm hover:bg-primary/90">Save Company</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Dialog -->
<div id="deleteConfirmDialog" class="alert-dialog-overlay">
    <div role="alertdialog" class="alert-dialog">
        <div class="alert-dialog-header"><h2 class="alert-dialog-title">Delete Company</h2><p class="alert-dialog-description" id="deleteDesc">This action cannot be undone. The company will be permanently removed.</p></div>
        <div class="alert-dialog-footer">
            <button class="alert-dialog-cancel" id="deleteCancelBtn">Cancel</button>
            <button class="alert-dialog-delete" id="deleteConfirmBtn">Delete Company</button>
        </div>
    </div>
</div>


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
    // HMS Client Companies
    let companies = [
        { id: "COM-001", name: "Mulago National Referral Hospital", email: "admin@mulago.go.ug", url: "stmarys.meditrack.com", plan: "Enterprise Suite", contact: "Dr. Ssentongo James", phone: "+256 414 100 101", createdOn: "2024-06-15", status: "Active", notes: "Full HMS deployment - 500 beds" },
        { id: "COM-002", name: "Mengo Hospital", email: "info@mengo.go.ug", url: "metromed.meditrack.com", plan: "Professional Growth", contact: "Sarah Williams", phone: "+256 414 100 102", createdOn: "2024-08-20", status: "Active", notes: "Multi-specialty hospital" },
        { id: "COM-003", name: "Nakasero Hospital", email: "hello@nakasero.co.ug", url: "riverside.meditrack.com", plan: "Essential Care", contact: "Dr. Namyalo Maria", phone: "+256 414 100 103", createdOn: "2024-09-10", status: "Active", notes: "Small community clinic - 50 beds" },
        { id: "COM-004", name: "International Hospital Kampala", email: "ops@mengo.go.ug", url: "sunrise.meditrack.com", plan: "Essential Care", contact: "Kimera Robert", phone: "+254 712 100 104", createdOn: "2024-10-05", status: "Active", notes: "Lab & imaging center" },
        { id: "COM-005", name: "AAR Healthcare", email: "contact@lacor.org", url: "greenwood.meditrack.com", plan: "Professional Growth", contact: "Dr. Nalwoga Emily", phone: "+254 712 100 105", createdOn: "2024-11-15", status: "Active", notes: "Pediatric specialty - 200 beds" },
        { id: "COM-006", name: "Aga Khan Hospital", email: "care@nsambya.org", url: "harmony.meditrack.com", plan: "Essential Care", contact: "Dr. Nabwire Lisa", phone: "+255 712 100 106", createdOn: "2024-12-01", status: "Active", notes: "Women's health specialty" },
        { id: "COM-007", name: "Kenyatta National Hospital", email: "info@gulu.go.ug", url: "northview.meditrack.com", plan: "Professional Growth", contact: "Dr. Ssali Michael", phone: "+255 712 100 107", createdOn: "2025-01-10", status: "Active", notes: "Orthopedic specialty center" },
        { id: "COM-008", name: "Muhimbili National Hospital", email: "admin@knh.go.ke", url: "coastalcardio.meditrack.com", plan: "Essential Care", contact: "Dr. Mukasa David", phone: "+250 712 100 108", createdOn: "2025-01-20", status: "Active", notes: "Cardiology practice" },
        { id: "COM-009", name: "King Faisal Hospital", email: "info@mbarara.go.ug", url: "valleyregional.meditrack.com", plan: "Enterprise Suite", contact: "Kemigisha Jennifer", phone: "+250 712 100 109", createdOn: "2025-02-01", status: "Trial", notes: "Evaluating HMS - 300 beds" },
        { id: "COM-010", name: "Bugando Medical Centre", email: "admin@jinja.go.ug", url: "pinecrest.meditrack.com", plan: "Essential Care", contact: "Nabisere Patricia", phone: "+256 414 100 110", createdOn: "2025-02-15", status: "Active", notes: "Elderly care facility" },
        { id: "COM-011", name: "Gulu Regional Referral", email: "info@butabika.go.ug", url: "evergreen.meditrack.com", plan: "Professional Growth", contact: "Dr. Tumusiime Thomas", phone: "+256 414 100 111", createdOn: "2025-02-20", status: "Active", notes: "Mental health facility" },
        { id: "COM-012", name: "Mbarara Regional Referral", email: "contact@muhimbili.go.tz", url: "lakeside.meditrack.com", plan: "Essential Care", contact: "Amanda Garcia", phone: "+254 712 100 112", createdOn: "2025-03-01", status: "Trial", notes: "Urgent care chain - 5 locations" },
        { id: "COM-013", name: "Jinja Regional Referral", email: "admin@mbarrara.go.ug", url: "heritagerehab.meditrack.com", plan: "Essential Care", contact: "Ssentongo Daniel", phone: "+254 712 100 113", createdOn: "2025-03-10", status: "Active", notes: "Physical therapy & rehab" },
        { id: "COM-014", name: "St. Francis Hospital Nsambya", email: "ops@nsambya.org", url: "blueridge.meditrack.com", plan: "Professional Growth", contact: "Nalwoga Michelle", phone: "+255 712 100 114", createdOn: "2025-03-20", status: "Pending", notes: "Surgical center - onboarding" },
        { id: "COM-015", name: "Rubaga Hospital", email: "info@ihk.co.ug", url: "silveroak.meditrack.com", plan: "Essential Care", contact: "Dr. Ssemwogerere Christopher", phone: "+255 712 100 115", createdOn: "2025-04-01", status: "Active", notes: "Dental practice" },
        { id: "COM-016", name: "Victoria Hospital Bukoba", email: "care@ihk.co.ug", url: "cedargrove.meditrack.com", plan: "Essential Care", contact: "Dr. Nankya Stephanie", phone: "+250 712 100 116", createdOn: "2025-04-10", status: "Trial", notes: "Ophthalmology practice" },
        { id: "COM-017", name: "Nsambya Hospital", email: "hello@victoriahospital.co.tz", url: "westside.meditrack.com", plan: "Essential Care", contact: "Dr. Byaruhanga Andrew", phone: "+250 712 100 117", createdOn: "2025-04-20", status: "Active", notes: "Family practice" },
        { id: "COM-018", name: "Uganda Cancer Institute", email: "info@uci.go.ug", url: "summitoncology.meditrack.com", plan: "Professional Growth", contact: "Dr. Nabwire Rachel", phone: "+256 414 100 118", createdOn: "2025-05-01", status: "Active", notes: "Cancer treatment center" },
        { id: "COM-019", name: "Mulago Pediatric Ward", email: "admin@mulago-pediatric.go.ug", url: "birchwood.meditrack.com", plan: "Essential Care", contact: "Dr. Tumusiimeera Brian", phone: "+256 414 100 119", createdOn: "2025-05-10", status: "Trial", notes: "Evaluating for pediatric use" },
        { id: "COM-020", name: "Addis Ababa Mulago Hospital", email: "info@lacor.org", url: "phoenix.meditrack.com", plan: "Enterprise Suite", contact: "Nabisere Catherine", phone: "+254 712 100 120", createdOn: "2025-05-20", status: "Pending", notes: "Large hospital - 800 beds - contract negotiation" }
    ];

    let currentTab = "all", searchQuery = "", statusFilter = "all";
    let currentPage = 1, activeMenu = null;
    const itemsPerPage = 10;

    function openModal(id) { document.getElementById(id)?.classList.add('show'); }
    function closeModal(id) { document.getElementById(id)?.classList.remove('show'); }
    function closeAllModals() { document.querySelectorAll('.modal-overlay.show, .alert-dialog-overlay.show').forEach(m => m.classList.remove('show')); }
    function showToast(msg, err=false) {
        const e = document.querySelector('.toast-message'); if(e) e.remove();
        const t = document.createElement('div'); t.className = `toast-message ${err?'error':''}`;
        t.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle>${err?'<line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line>':'<path d="m9 12 2 2 4-4"></path>'}</svg> ${msg}`;
        document.body.appendChild(t); setTimeout(() => t.remove(), 3500);
    }
    function closeMenu() { if(activeMenu) { activeMenu.remove(); activeMenu = null; } }
    function formatDate(d) { return d ? new Date(d + 'T00:00:00').toLocaleDateString('en-US', {month:'short', day:'numeric', year:'numeric'}) : '—'; }

    function getStatusBadge(s) {
        const m = {'Active':'status-active','Trial':'status-trial','Pending':'status-pending','Suspended':'status-suspended','Inactive':'status-inactive'};
        return `<span class="status-badge ${m[s]||'status-pending'}">${s}</span>`;
    }

    function getPlanBadge(p) {
        const colors = {'Enterprise Suite':'bg-purple-100 text-purple-700','Professional Growth':'bg-indigo-100 text-indigo-700','Essential Care':'bg-emerald-100 text-emerald-700','Custom Plan':'bg-amber-100 text-amber-700'};
        return `<span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold ${colors[p]||'bg-gray-100 text-gray-700'}">${p}</span>`;
    }

    function getFiltered() {
        let f = [...companies];
        if(currentTab==='active') f = f.filter(c => c.status==='Active');
        else if(currentTab==='trial') f = f.filter(c => c.status==='Trial');
        else if(currentTab==='inactive') f = f.filter(c => c.status==='Inactive' || c.status==='Suspended' || c.status==='Pending');
        if(searchQuery) { const q = searchQuery.toLowerCase(); f = f.filter(c => c.name.toLowerCase().includes(q) || c.email.toLowerCase().includes(q) || c.plan.toLowerCase().includes(q) || c.url.toLowerCase().includes(q)); }
        if(statusFilter!=='all') f = f.filter(c => c.status===statusFilter);
        return f;
    }

    function updateStats() {
        document.getElementById('statTotal').innerText = companies.length;
        document.getElementById('statActive').innerText = companies.filter(c => c.status==='Active').length;
        document.getElementById('statTrial').innerText = companies.filter(c => c.status==='Trial').length;
        document.getElementById('statInactive').innerText = companies.filter(c => c.status==='Inactive' || c.status==='Suspended').length;
    }

    function renderTable() {
        const f = getFiltered(), tp = Math.ceil(f.length/itemsPerPage);
        if(currentPage>tp) currentPage = tp||1;
        const s = (currentPage-1)*itemsPerPage, p = f.slice(s,s+itemsPerPage);
        const tbody = document.getElementById('companiesTableBody');
        tbody.innerHTML = p.length===0 ? '<tr><td colspan="7" class="text-center py-10 text-gray-500">No companies found</td></tr>' :
            p.map(c => `<tr class="border-b data-row">
                <td class="p-4"><div class="font-medium text-indigo-600">${c.name}</div><div class="text-xs text-gray-500">${c.contact}</div></td>
                <td class="p-4 hidden md:table-cell text-gray-500 text-sm">${c.email}</td>
                <td class="p-4 hidden lg:table-cell text-gray-500 text-sm">${c.url}</td>
                <td class="p-4">${getPlanBadge(c.plan)}</td>
                <td class="p-4 hidden lg:table-cell text-gray-500">${formatDate(c.createdOn)}</td>
                <td class="p-4">${getStatusBadge(c.status)}</td>
                <td class="p-4 text-right"><button class="action-trigger inline-flex items-center justify-center h-10 w-10 rounded-md hover:bg-gray-100" data-id="${c.id}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button></td>
            </tr>`).join('');

        document.getElementById('showingText').innerText = f.length===0?'No companies found':`Showing ${s+1}-${Math.min(s+itemsPerPage,f.length)} of ${f.length} companies`;
        document.getElementById('prevPageBtn').disabled = currentPage<=1;
        document.getElementById('nextPageBtn').disabled = currentPage>=tp;
        document.querySelectorAll('.page-btn').forEach(b => { const pg = parseInt(b.dataset.page); b.classList.toggle('bg-primary',pg===currentPage); b.classList.toggle('text-white',pg===currentPage); });
        document.querySelectorAll('.action-trigger').forEach(b => { b.addEventListener('click',e => { e.stopPropagation(); const c = companies.find(x => x.id===b.dataset.id); if(c) showActionMenu(b,c); }); });
    }

    function showActionMenu(btn, c) {
        closeMenu(); const r = btn.getBoundingClientRect(); const m = document.createElement('div'); m.className='action-menu';
        let l=r.left, t=r.bottom+6; if(l+230>innerWidth) l=innerWidth-240; if(t+320>innerHeight) t=r.top-330; if(l<10)l=10;if(t<10)t=10;
        m.style.top=t+'px'; m.style.left=l+'px';
        m.innerHTML=`<div class="action-menu-header">Actions</div>
            <button data-action="edit" class="action-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path><path d="m15 5 4 4"></path></svg>Edit Company</button>
            <button data-action="view" class="action-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle></svg>View Details</button>
            <div class="action-divider"></div>
            ${c.status==='Active'?`<button data-action="suspend" class="action-item text-amber-600"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" x2="12" y1="8" y2="12"></line></svg>Suspend</button>`:''}
            ${c.status==='Trial'?`<button data-action="activate" class="action-item text-green-600"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17l-5-5"></polyline></svg>Activate</button>`:''}
            ${c.status==='Pending'?`<button data-action="approve" class="action-item text-green-600"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17l-5-5"></polyline></svg>Approve</button>`:''}
            ${c.status==='Suspended'||c.status==='Inactive'?`<button data-action="reactivate" class="action-item text-green-600"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path></svg>Reactivate</button>`:''}
            <button data-action="delete" class="action-item text-red-600"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path></svg>Delete Company</button>`;
        document.body.appendChild(m); activeMenu=m;
        m.addEventListener('click',e => { const a=e.target.closest('[data-action]')?.dataset.action; if(!a)return; closeMenu();
            if(a==='edit') openCompanyModal(c);
            else if(a==='view') showToast(`Viewing ${c.name} - ${c.url}`);
            else if(a==='suspend') { c.status='Suspended'; renderTable(); updateStats(); showToast(`${c.name} suspended`); }
            else if(a==='activate') { c.status='Active'; renderTable(); updateStats(); showToast(`${c.name} activated`); }
            else if(a==='approve') { c.status='Active'; renderTable(); updateStats(); showToast(`${c.name} approved`); }
            else if(a==='reactivate') { c.status='Active'; renderTable(); updateStats(); showToast(`${c.name} reactivated`); }
            else if(a==='delete') showDeleteDialog(c);
        });
        setTimeout(()=>document.addEventListener('click',function h(e){if(!m.contains(e.target)){closeMenu();document.removeEventListener('click',h);}},{once:false}),10);
    }

    // Radix Select Handler
    function initRadixSelect(btnId, dropdownId, textId) {
        const btn = document.getElementById(btnId);
        const dropdown = document.getElementById(dropdownId);
        const textEl = document.getElementById(textId);
        btn.addEventListener('click', (e) => { e.stopPropagation(); document.querySelectorAll('.select-content').forEach(d => { if(d !== dropdown) d.classList.add('hidden'); }); dropdown.classList.toggle('hidden'); });
        dropdown.querySelectorAll('.select-item').forEach(item => {
            item.addEventListener('click', () => { textEl.textContent = item.textContent; dropdown.classList.add('hidden'); dropdown.querySelectorAll('.select-item').forEach(i => i.classList.remove('selected')); item.classList.add('selected'); });
        });
    }
    initRadixSelect('planSelectBtn', 'planSelectDropdown', 'planSelectText');
    initRadixSelect('statusSelectBtn', 'statusSelectDropdown', 'statusSelectText');
    document.addEventListener('click', (e) => { if (!e.target.closest('.select-trigger') && !e.target.closest('.select-content')) document.querySelectorAll('.select-content').forEach(d => d.classList.add('hidden')); });

    function openCompanyModal(c = null) {
        document.getElementById('companyModalTitle').innerText = c ? 'Edit Company' : 'Add Company';
        document.getElementById('companyName').value = c ? c.name : '';
        document.getElementById('companyEmail').value = c ? c.email : '';
        document.getElementById('companyUrl').value = c ? c.url : '';
        document.getElementById('companyContact').value = c ? c.contact : '';
        document.getElementById('companyPhone').value = c ? c.phone : '';
        document.getElementById('companyNotes').value = c ? c.notes : '';
        
        // Set plan select
        document.getElementById('planSelectText').textContent = c ? c.plan : 'Essential Care';
        document.querySelectorAll('#planSelectDropdown .select-item').forEach(i => i.classList.toggle('selected', i.dataset.value === (c ? c.plan : 'Essential Care')));
        
        // Set status select
        document.getElementById('statusSelectText').textContent = c ? c.status : 'Active';
        document.querySelectorAll('#statusSelectDropdown .select-item').forEach(i => i.classList.toggle('selected', i.dataset.value === (c ? c.status : 'Active')));
        
        document.getElementById('companyModal')._company = c;
        openModal('companyModal');
    }

    document.getElementById('saveCompanyBtn').addEventListener('click', () => {
        const name = document.getElementById('companyName').value.trim();
        const email = document.getElementById('companyEmail').value.trim();
        if (!name || !email) { showToast('Company name and email are required', true); return; }
        const existing = document.getElementById('companyModal')._company;
        const data = {
            name, email,
            url: document.getElementById('companyUrl').value,
            plan: document.getElementById('planSelectText').textContent,
            status: document.getElementById('statusSelectText').textContent,
            contact: document.getElementById('companyContact').value,
            phone: document.getElementById('companyPhone').value,
            notes: document.getElementById('companyNotes').value
        };
        if (existing) { Object.assign(existing, data); showToast(`"${name}" updated`); }
        else { companies.push({ id: 'COM-' + String(companies.length + 1).padStart(3, '0'), createdOn: new Date().toISOString().split('T')[0], ...data }); showToast(`"${name}" added`); }
        renderTable(); updateStats(); closeModal('companyModal');
    });

    function showDeleteDialog(c) { document.getElementById('deleteDesc').innerText = `"${c.name}" will be permanently removed.`; document.getElementById('deleteConfirmDialog')._company = c; openModal('deleteConfirmDialog'); }
    document.getElementById('deleteConfirmBtn').addEventListener('click', () => { const c = document.getElementById('deleteConfirmDialog')._company; if(c) { companies = companies.filter(x => x.id !== c.id); renderTable(); updateStats(); showToast(`"${c.name}" deleted`); } closeModal('deleteConfirmDialog'); });
    document.getElementById('deleteCancelBtn').addEventListener('click', () => closeModal('deleteConfirmDialog'));
    document.getElementById('addCompanyBtn').addEventListener('click', () => openCompanyModal());
    document.getElementById('exportBtn').addEventListener('click', () => showToast('Companies exported'));
    document.querySelectorAll('.modal-close, [data-close]').forEach(b => { b.addEventListener('click', e => { e.stopPropagation(); const id = b.dataset.close || b.closest('.modal-overlay, .alert-dialog-overlay')?.id; if(id) closeModal(id); }); });
    document.querySelectorAll('.modal-overlay, .alert-dialog-overlay').forEach(o => { o.addEventListener('click', function(e) { if(e.target===this) closeModal(this.id); }); });
    document.addEventListener('keydown', e => { if(e.key==='Escape') { closeAllModals(); closeMenu(); } });
    document.getElementById('searchInput').addEventListener('input', e => { searchQuery = e.target.value; currentPage = 1; renderTable(); });
    function initFD(bid,did,tid,sf) { const b=document.getElementById(bid),d=document.getElementById(did),t=document.getElementById(tid); b.addEventListener('click',e=>{e.stopPropagation();document.querySelectorAll('[id$="FilterDropdown"]').forEach(x=>{if(x!==d)x.classList.add('hidden');});d.classList.toggle('hidden');});d.querySelectorAll('.filter-option').forEach(o=>{o.addEventListener('click',()=>{t.textContent=o.textContent.trim();d.classList.add('hidden');sf(o.dataset.value);currentPage=1;renderTable();});});}
    initFD('statusFilterBtn','statusFilterDropdown','statusFilterText',v=>{statusFilter=v;});
    document.addEventListener('click',e=>{if(!e.target.closest('[id$="FilterBtn"]')&&!e.target.closest('[id$="FilterDropdown"]'))document.querySelectorAll('[id$="FilterDropdown"]').forEach(d=>d.classList.add('hidden'));});
    document.querySelectorAll('.tab-btn').forEach(b=>{b.addEventListener('click',()=>{currentTab=b.dataset.tab;currentPage=1;document.querySelectorAll('.tab-btn').forEach(x=>x.classList.remove('active','bg-white','shadow-sm','text-gray-900'));b.classList.add('active','bg-white','shadow-sm','text-gray-900');renderTable();});});
    document.getElementById('prevPageBtn').addEventListener('click',()=>{if(currentPage>1){currentPage--;renderTable();}});
    document.getElementById('nextPageBtn').addEventListener('click',()=>{if(currentPage<Math.ceil(getFiltered().length/itemsPerPage)){currentPage++;renderTable();}});
    document.querySelectorAll('.page-btn').forEach(b=>b.addEventListener('click',()=>{currentPage=parseInt(b.dataset.page);renderTable();}));
    document.getElementById('cardActive').addEventListener('click',()=>activateTab('active'));
    document.getElementById('cardTrial').addEventListener('click',()=>activateTab('trial'));
    document.getElementById('cardInactive').addEventListener('click',()=>activateTab('inactive'));
    document.getElementById('cardTotal').addEventListener('click',()=>activateTab('all'));
    function activateTab(t){currentTab=t;currentPage=1;document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active','bg-white','shadow-sm','text-gray-900'));const tb=document.querySelector(`[data-tab="${t}"]`);if(tb)tb.classList.add('active','bg-white','shadow-sm','text-gray-900');renderTable();}
    updateStats(); renderTable(); closeAllModals();
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
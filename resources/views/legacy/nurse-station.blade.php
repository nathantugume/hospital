<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Nurse Station</title>
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

        /* Sidebar Dev Mode */
        aside.dev-mode { width: 60px !important; min-width: 60px !important; overflow: hidden; }
        aside.dev-mode .brand-text, aside.dev-mode .nav-text, aside.dev-mode .arrow-icon, aside.dev-mode .user-details, aside.dev-mode .close-btn { display: none !important; }
        aside.dev-mode nav > div { padding: 2px 0; }
        aside.dev-mode nav a, aside.dev-mode nav button { justify-content: center !important; padding: 0.5rem !important; width: 44px; height: 44px; }
        aside.dev-mode nav a svg, aside.dev-mode nav button svg { margin-right: 0 !important; }

        .tab-btn { transition: all 0.2s ease; color: #6b7280; }
        .tab-btn.active { background-color: white; color: #1f2937; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        body.dark .tab-btn.active { background-color: #131212; color: #e5e5e5; }
        .tab-panel { display: none; animation: fadeIn 0.2s ease-out; }
        .tab-panel.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }

        .action-menu {
            position: fixed; z-index: 100; min-width: 220px;
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
        .modal-container { background: white; border-radius: 0.75rem; width: 100%; max-width: 600px; max-height: 85vh; overflow-y: auto; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); animation: slideUp 0.2s ease; }
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
        .status-stable { background-color: #dcfce7; color: #166534; }
        .status-observation { background-color: #fef3c7; color: #92400e; }
        .status-critical { background-color: #fee2e2; color: #991b1b; }
        .status-discharged { background-color: #f3f4f6; color: #6b7280; }
        .status-administered { background-color: #dcfce7; color: #166534; }
        .status-pending { background-color: #dbeafe; color: #1e40af; }
        .status-missed { background-color: #fee2e2; color: #991b1b; }
        body.dark .status-stable { background-color: #14532d; color: #dcfce7; }
        body.dark .status-observation { background-color: #78350f; color: #fef3c7; }
        body.dark .status-critical { background-color: #7f1d1d; color: #fee2e2; }

        .data-row:hover { background-color: #f9fafb; }
        body.dark .data-row:hover { background-color: #1f1f1f; }

        .select-trigger { display: flex; height: 2.5rem; width: 100%; align-items: center; justify-content: space-between; border-radius: 0.375rem; border: 1px solid #d1d5db; background-color: #ffffff; padding: 0 0.75rem; font-size: 0.875rem; cursor: pointer; transition: all 0.15s ease; color: #374151; }
        .select-trigger:hover { border-color: #9ca3af; }
        body.dark .select-trigger { background-color: #262626; border-color: #404040; color: #e5e5e5; }
        .select-content { position: absolute; z-index: 50; background-color: white; border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); border: 1px solid #e5e7eb; margin-top: 4px; width: 100%; max-height: 240px; overflow-y: auto; animation: fadeInScale 0.12s ease-out; }
        body.dark .select-content { background-color: #1e293b; border-color: #334155; }
        .select-item { padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer; transition: background 0.1s; display: flex; align-items: center; gap: 0.5rem; }
        .select-item:hover { background-color: #f3f4f6; }
        body.dark .select-item:hover { background-color: #334155; }
        .select-item.selected { background-color: #eef2ff; color: #4338ca; font-weight: 500; }
        body.dark .select-item.selected { background-color: #1e1b4b; color: #a5b4fc; }

/* Task Edit Modal */
.task-modal-backdrop {
    position: fixed;
    inset: 0;
    background-color: rgb(0 0 0 / 87%);
    backdrop-filter: blur(4px);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.2s ease-out;
}
.task-modal-backdrop.hidden { display: none; }
.task-modal {
    background: white;
    border-radius: 0.75rem;
    width: 100%;
    max-width: 550px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    animation: slideUp 0.2s ease;
}
body.dark .task-modal { background: #1e293b; border: 1px solid #334155; }
.task-modal-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: sticky;
    top: 0;
    background: white;
    z-index: 10;
    border-radius: 0.75rem 0.75rem 0 0;
}
body.dark .task-modal-header { border-bottom-color: #334155; background: #1e293b; }
.task-modal-body { padding: 1.5rem; }
.task-modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    position: sticky;
    bottom: 0;
    background: white;
}
body.dark .task-modal-footer { border-top-color: #334155; background: #1e293b; }
.task-modal-title { font-size: 1.125rem; font-weight: 600; }
.task-modal-close {
    background: transparent;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #6b7280;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.375rem;
}
.task-modal-close:hover { color: #1f2937; background-color: #f3f4f6; }
body.dark .task-modal-close:hover { color: #e5e5e5; background-color: #374151; }
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
            <div class="flex flex-col gap-6">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div><h1 class="text-2xl lg:text-3xl font-bold tracking-tight text-gray-900 dark:text-white">Nurse Station</h1><p class="text-gray-500">Welcome back, Rebecca. Here's your ward overview for today.</p></div>
                    <div class="flex gap-2">
                        <button class="bg-primary text-white hover:bg-primary/90 h-10 px-4 rounded-md text-sm flex items-center gap-2 transition" onclick="MeditrackUtils.openModal('handoverModal')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/></svg>Shift Handover</button>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-4">
                    <div class="rounded-lg border bg-white dark:bg-[#131212] shadow-sm p-4"><div class="flex items-center justify-between"><h3 class="text-sm font-medium text-gray-500">My Patients Today</h3><div class="bg-blue-100 p-2 rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-blue-600"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div></div><div class="mt-3"><p class="text-3xl font-bold text-blue-600">12</p><p class="text-xs text-gray-500 mt-1">Ward B assignments</p></div></div>
                    <div class="rounded-lg border bg-white dark:bg-[#131212] shadow-sm p-4"><div class="flex items-center justify-between"><h3 class="text-sm font-medium text-gray-500">Pending Medications</h3><div class="bg-amber-100 p-2 rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-amber-600"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"/><path d="m8.5 8.5 7 7"/></svg></div></div><div class="mt-3"><p class="text-3xl font-bold text-amber-600">5</p><p class="text-xs text-gray-500 mt-1">3 due within 1 hour</p></div></div>
                    <div class="rounded-lg border bg-white dark:bg-[#131212] shadow-sm p-4"><div class="flex items-center justify-between"><h3 class="text-sm font-medium text-gray-500">Lab Results Ready</h3><div class="bg-green-100 p-2 rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-green-600"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/></svg></div></div><div class="mt-3"><p class="text-3xl font-bold text-green-600">3</p><p class="text-xs text-gray-500 mt-1">Awaiting review</p></div></div>
                    <div class="rounded-lg border bg-white dark:bg-[#131212] shadow-sm p-4"><div class="flex items-center justify-between"><h3 class="text-sm font-medium text-gray-500">Pending Tasks</h3><div class="bg-purple-100 p-2 rounded-lg"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-purple-600"><rect width="8" height="4" x="8" y="2" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/></svg></div></div><div class="mt-3"><p class="text-3xl font-bold text-purple-600">8</p><p class="text-xs text-gray-500 mt-1">2 high priority</p></div></div>
                </div>

                <div class="w-full">
                    <div class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1 dark:bg-gray-800">
                        <button data-tab="patients" class="tab-btn active rounded-sm px-3 py-1.5 text-sm font-medium transition-all">My Patients</button>
                        <button data-tab="medications" class="tab-btn rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Medications</button>
                        <button data-tab="vitals" class="tab-btn rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Vitals Entry</button>
                        <button data-tab="tasks" class="tab-btn rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Tasks</button>
                    </div>

                    <div id="tab-patients" class="tab-panel active mt-4">
                        <div class="rounded-lg border bg-white dark:bg-[#131212] shadow-sm">
                            <div class="p-4 border-b flex justify-between items-center"><div><h2 class="text-xl font-semibold">Assigned Patients</h2><p class="text-gray-500 text-sm">Ward B - Today's roster</p></div><button class="bg-primary text-white hover:bg-primary/90 h-9 px-4 rounded-md text-sm" onclick="MeditrackUtils.openModal('addPatientModal')">Admit Patient</button></div>
                            <div class="overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr><th class="px-4 py-3 text-left">Patient</th><th class="px-4 py-3 text-left">Room</th><th class="px-4 py-3 text-left hidden md:table-cell">Diagnosis</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-right">Actions</th></tr></thead><tbody id="patientsTableBody"></tbody></table></div>
                        </div>
                    </div>
                    <div id="tab-medications" class="tab-panel mt-4">
                        <div class="rounded-lg border bg-white dark:bg-[#131212] shadow-sm">
                            <div class="p-4 border-b flex justify-between items-center"><div><h2 class="text-xl font-semibold">Medication Schedule</h2><p class="text-gray-500 text-sm">Today's medication rounds</p></div><button class="bg-primary text-white hover:bg-primary/90 h-9 px-4 rounded-md text-sm" onclick="MeditrackUtils.openModal('administerMedModal')">Administer Med</button></div>
                            <div class="overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr><th class="px-4 py-3 text-left">Patient</th><th class="px-4 py-3 text-left">Medication</th><th class="px-4 py-3 text-left hidden md:table-cell">Dosage</th><th class="px-4 py-3 text-left">Time</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-right">Actions</th></tr></thead><tbody id="medicationsTableBody"></tbody></table></div>
                        </div>
                    </div>
                    <div id="tab-vitals" class="tab-panel mt-4">
                        <div class="rounded-lg border bg-white dark:bg-[#131212] shadow-sm">
                            <div class="p-4 border-b flex justify-between items-center"><div><h2 class="text-xl font-semibold">Vitals Entry</h2><p class="text-gray-500 text-sm">Record patient vital signs</p></div><button class="bg-primary text-white hover:bg-primary/90 h-9 px-4 rounded-md text-sm" onclick="MeditrackUtils.openModal('vitalsModal')">Record Vitals</button></div>
                            <div class="overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr><th class="px-4 py-3 text-left">Patient</th><th class="px-4 py-3 text-left">BP</th><th class="px-4 py-3 text-left">HR</th><th class="px-4 py-3 text-left hidden md:table-cell">Temp</th><th class="px-4 py-3 text-left hidden lg:table-cell">O2 Sat</th><th class="px-4 py-3 text-left">Last Updated</th><th class="px-4 py-3 text-right">Actions</th></tr></thead><tbody id="vitalsTableBody"></tbody></table></div>
                        </div>
                    </div>
<div id="tab-tasks" class="tab-panel mt-4">
    <div class="rounded-lg border bg-white dark:bg-[#131212] shadow-sm">
        <div class="p-4 border-b flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold">Nursing Tasks</h2>
                <p class="text-gray-500 text-sm">Pending tasks for your shift</p>
            </div>
            <button id="addTaskBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-white hover:bg-primary/90 h-9 px-4 py-2 gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                Add Task
            </button>
        </div>
        <div class="p-4 space-y-3" id="tasksContainer"></div>
    </div>
</div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Note Modal -->
    <div id="addNoteModal" class="modal-overlay"><div class="modal-container"><div class="modal-header"><h2 class="modal-title">Add Nursing Note</h2><button class="modal-close" data-close="addNoteModal">&times;</button></div><div class="modal-body"><div class="space-y-4">
        <div><label class="text-sm font-medium block mb-1">Patient <span class="text-red-500">*</span></label><div class="relative"><button id="notePatientSelectBtn" class="select-trigger justify-between" type="button"><span id="notePatientSelectText">Select patient</span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="notePatientSelectDropdown" class="select-content hidden"><div class="select-item" data-value="Nalwoga Emma">Nalwoga Emma</div><div class="select-item" data-value="Mwangi Peter">Mwangi Peter</div><div class="select-item" data-value="Sophia Rodriguez">Sophia Rodriguez</div><div class="select-item" data-value="Okello James">Okello James</div></div></div></div>
        <div><label class="text-sm font-medium block mb-1">Note Type <span class="text-red-500">*</span></label><div class="relative"><button id="noteTypeSelectBtn" class="select-trigger justify-between" type="button"><span id="noteTypeSelectText">Select type</span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="noteTypeSelectDropdown" class="select-content hidden"><div class="select-item" data-value="Observation">Observation</div><div class="select-item" data-value="Assessment">Assessment</div><div class="select-item" data-value="Intervention">Intervention</div><div class="select-item" data-value="Handover">Handover</div></div></div></div>
        <div><label class="text-sm font-medium block mb-1">Priority</label><div class="relative"><button id="notePrioritySelectBtn" class="select-trigger justify-between" type="button"><span id="notePrioritySelectText">Routine</span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="notePrioritySelectDropdown" class="select-content hidden"><div class="select-item" data-value="Routine">Routine</div><div class="select-item" data-value="Important">Important</div><div class="select-item" data-value="Urgent">Urgent</div></div></div></div>
        <div><label class="text-sm font-medium block mb-1">Notes <span class="text-red-500">*</span></label><textarea id="noteContent" rows="4" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Enter your nursing notes..."></textarea></div>
    </div></div><div class="modal-footer"><button class="border border-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-100" data-close="addNoteModal">Cancel</button><button class="bg-primary text-white px-4 py-2 rounded-md text-sm hover:bg-primary/90" id="saveNoteBtn">Save Note</button></div></div></div>

    <!-- Admit Patient Modal -->
    <div id="addPatientModal" class="modal-overlay"><div class="modal-container"><div class="modal-header"><h2 class="modal-title">Admit New Patient</h2><button class="modal-close" data-close="addPatientModal">&times;</button></div><div class="modal-body"><div class="space-y-4"><div class="grid grid-cols-2 gap-4"><div><label class="text-sm font-medium block mb-1">Patient Name</label><input type="text" id="admitName" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Full name"></div><div><label class="text-sm font-medium block mb-1">Room</label><div class="relative"><button id="roomSelectBtn" class="select-trigger justify-between" type="button"><span id="roomSelectText">Select room</span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="roomSelectDropdown" class="select-content hidden"><div class="select-item" data-value="B-101">B-101</div><div class="select-item" data-value="B-102">B-102</div><div class="select-item" data-value="B-103">B-103</div><div class="select-item" data-value="B-104">B-104</div></div></div></div></div><div class="grid grid-cols-2 gap-4"><div><label class="text-sm font-medium block mb-1">Diagnosis</label><input type="text" id="admitDiagnosis" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Primary diagnosis"></div><div><label class="text-sm font-medium block mb-1">Attending Doctor</label><div class="relative"><button id="doctorSelectBtn" class="select-trigger justify-between" type="button"><span id="doctorSelectText">Select doctor</span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="doctorSelectDropdown" class="select-content hidden"><div class="select-item" data-value="Dr. Johnson">Dr. Johnson</div><div class="select-item" data-value="Dr. Nabwire">Dr. Nabwire</div><div class="select-item" data-value="Dr. Kibirige">Dr. Kibirige</div></div></div></div></div><div><label class="text-sm font-medium block mb-1">Admission Notes</label><textarea id="admitNotes" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Nursing notes..."></textarea></div></div></div><div class="modal-footer"><button class="border border-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-100" data-close="addPatientModal">Cancel</button><button class="bg-primary text-white px-4 py-2 rounded-md text-sm hover:bg-primary/90" id="saveAdmitBtn">Admit Patient</button></div></div></div>

    <!-- Record Vitals Modal -->
    <div id="vitalsModal" class="modal-overlay"><div class="modal-container"><div class="modal-header"><h2 class="modal-title">Record Vital Signs</h2><button class="modal-close" data-close="vitalsModal">&times;</button></div><div class="modal-body"><div class="space-y-4"><div><label class="text-sm font-medium block mb-1">Patient <span class="text-red-500">*</span></label><div class="relative"><button id="vitalsPatientSelectBtn" class="select-trigger justify-between" type="button"><span id="vitalsPatientSelectText">Select patient</span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="vitalsPatientSelectDropdown" class="select-content hidden"><div class="select-item" data-value="Nalwoga Emma">Nalwoga Emma</div><div class="select-item" data-value="Mwangi Peter">Mwangi Peter</div><div class="select-item" data-value="Sophia Rodriguez">Sophia Rodriguez</div><div class="select-item" data-value="Okello James">Okello James</div></div></div></div><div class="grid grid-cols-2 gap-4"><div><label class="text-sm font-medium block mb-1">Blood Pressure</label><input type="text" id="vitalsBP" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="120/80"></div><div><label class="text-sm font-medium block mb-1">Heart Rate (BPM)</label><input type="number" id="vitalsHR" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="72"></div></div><div class="grid grid-cols-2 gap-4"><div><label class="text-sm font-medium block mb-1">Temperature (°F)</label><input type="number" id="vitalsTemp" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="98.6" step="0.1"></div><div><label class="text-sm font-medium block mb-1">O2 Saturation (%)</label><input type="number" id="vitalsO2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="98"></div></div><div><label class="text-sm font-medium block mb-1">Notes</label><textarea id="vitalsNotes" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Any observations..."></textarea></div></div></div><div class="modal-footer"><button class="border border-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-100" data-close="vitalsModal">Cancel</button><button class="bg-primary text-white px-4 py-2 rounded-md text-sm hover:bg-primary/90" id="saveVitalsBtn">Save Vitals</button></div></div></div>

    <!-- Administer Medication Modal -->
    <div id="administerMedModal" class="modal-overlay"><div class="modal-container"><div class="modal-header"><h2 class="modal-title">Administer Medication</h2><button class="modal-close" data-close="administerMedModal">&times;</button></div><div class="modal-body"><div class="space-y-4"><div class="bg-blue-50 rounded-lg p-3 text-sm">Select a scheduled medication to administer.</div><div><label class="text-sm font-medium block mb-1">Patient <span class="text-red-500">*</span></label><div class="relative"><button id="medPatientSelectBtn" class="select-trigger justify-between" type="button"><span id="medPatientSelectText">Select patient</span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="medPatientSelectDropdown" class="select-content hidden"><div class="select-item" data-value="Nalwoga Emma">Nalwoga Emma</div><div class="select-item" data-value="Mwangi Peter">Mwangi Peter</div><div class="select-item" data-value="Okello James">Okello James</div></div></div></div><div><label class="text-sm font-medium block mb-1">Medication <span class="text-red-500">*</span></label><div class="relative"><button id="medNameSelectBtn" class="select-trigger justify-between" type="button"><span id="medNameSelectText">Select medication</span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="medNameSelectDropdown" class="select-content hidden"><div class="select-item" data-value="Lisinopril 10mg">Lisinopril 10mg</div><div class="select-item" data-value="Metformin 500mg">Metformin 500mg</div><div class="select-item" data-value="Amoxicillin 500mg">Amoxicillin 500mg</div></div></div></div><div class="grid grid-cols-2 gap-4"><div><label class="text-sm font-medium block mb-1">Route</label><div class="relative"><button id="medRouteSelectBtn" class="select-trigger justify-between" type="button"><span id="medRouteSelectText">Oral</span><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="medRouteSelectDropdown" class="select-content hidden"><div class="select-item" data-value="Oral">Oral</div><div class="select-item" data-value="IV">IV</div><div class="select-item" data-value="IM">IM</div><div class="select-item" data-value="Subcutaneous">Subcutaneous</div></div></div></div><div><label class="text-sm font-medium block mb-1">Time Given</label><input type="time" id="medTime" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div></div><div><label class="text-sm font-medium block mb-1">Notes</label><textarea id="medNotes" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Administration notes..."></textarea></div></div></div><div class="modal-footer"><button class="border border-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-100" data-close="administerMedModal">Cancel</button><button class="bg-primary text-white px-4 py-2 rounded-md text-sm hover:bg-primary/90" id="saveMedBtn">Record Administration</button></div></div></div>

    <!-- Shift Handover Modal -->
    <div id="handoverModal" class="modal-overlay"><div class="modal-container" style="max-width:700px"><div class="modal-header"><h2 class="modal-title">Shift Handover Report</h2><button class="modal-close" data-close="handoverModal">&times;</button></div><div class="modal-body"><div class="space-y-4"><div class="bg-indigo-50 rounded-lg p-4"><p class="font-semibold">Shift: Night (7PM - 7AM) → Day (7AM - 7PM)</p><p class="text-sm text-gray-500">Nurse Rebecca Adams handing over to Nurse Sarah Mitchell</p></div><div><h3 class="font-semibold mb-2">Patient Updates</h3><div class="space-y-2" id="handoverPatients"></div></div><div><label class="text-sm font-medium block mb-1">Handover Notes</label><textarea id="handoverNotes" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Important updates for the next shift..."></textarea></div></div></div><div class="modal-footer"><button class="border border-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-100" data-close="handoverModal">Cancel</button><button class="bg-primary text-white px-4 py-2 rounded-md text-sm hover:bg-primary/90" id="saveHandoverBtn">Complete Handover</button></div></div></div>

    <!-- Scripts -->
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
    <script src="js/utils.js"></script>

  <script>
    // ============================================================
    // DATA
    // ============================================================
    const patients = [
        { name: "Nalwoga Emma", room: "B-101", diagnosis: "Pneumonia", status: "Stable", doctor: "Dr. Johnson" },
        { name: "Mwangi Peter", room: "B-102", diagnosis: "Post-OP Knee", status: "Observation", doctor: "Dr. Nabwire" },
        { name: "Sophia Rodriguez", room: "B-103", diagnosis: "UTI", status: "Stable", doctor: "Dr. Kibirige" },
        { name: "Okello James", room: "B-104", diagnosis: "Chest Pain", status: "Critical", doctor: "Dr. Johnson" },
        { name: "Nabwire Lisa", room: "B-105", diagnosis: "Diabetes Management", status: "Stable", doctor: "Dr. Nabwire" },
        { name: "Byaruhanga Robert", room: "B-106", diagnosis: "Fracture Femur", status: "Observation", doctor: "Dr. Kibirige" },
        { name: "Nabisere Maria", room: "B-107", diagnosis: "COPD Exacerbation", status: "Critical", doctor: "Dr. Johnson" }
    ];
    const medications = [
        { patient: "Nalwoga Emma", med: "Azithromycin", dosage: "500mg", time: "08:00 AM", status: "Administered" },
        { patient: "Mwangi Peter", med: "Morphine", dosage: "5mg", time: "08:30 AM", status: "Pending" },
        { patient: "Sophia Rodriguez", med: "Ciprofloxacin", dosage: "250mg", time: "09:00 AM", status: "Pending" },
        { patient: "Okello James", med: "Nitroglycerin", dosage: "0.4mg", time: "07:30 AM", status: "Missed" },
        { patient: "Nabwire Lisa", med: "Metformin", dosage: "500mg", time: "08:00 AM", status: "Administered" },
        { patient: "Byaruhanga Robert", med: "Ibuprofen", dosage: "400mg", time: "09:00 AM", status: "Pending" },
        { patient: "Nabisere Maria", med: "Prednisone", dosage: "40mg", time: "08:00 AM", status: "Administered" }
    ];
    const vitals = [
        { patient: "Nalwoga Emma", bp: "118/78", hr: "72", temp: "98.6", o2: "98%", updated: "Today, 7:45 AM" },
        { patient: "Mwangi Peter", bp: "130/85", hr: "88", temp: "99.2", o2: "96%", updated: "Today, 7:30 AM" },
        { patient: "Sophia Rodriguez", bp: "110/70", hr: "68", temp: "98.4", o2: "99%", updated: "Today, 6:00 AM" },
        { patient: "Okello James", bp: "150/95", hr: "102", temp: "100.1", o2: "94%", updated: "Today, 7:15 AM" },
        { patient: "Nabwire Lisa", bp: "122/80", hr: "74", temp: "98.8", o2: "97%", updated: "Today, 7:00 AM" }
    ];

    const tasks = [
        { id: 1, title: "Review patient records", description: "Go through the latest patient records and update the system", status: "todo", priority: "High", dueDate: "2026-04-14", assignedTo: "Dr. Nakato Sarah", completed: false },
        { id: 2, title: "Change wound dressing - Room B-102", description: "Regular wound care for post-op patient", status: "in progress", priority: "High", dueDate: "2026-04-14", assignedTo: "Nurse Rebecca", completed: false },
        { id: 3, title: "Collect blood sample - Room B-105", description: "Morning blood draw for lab work", status: "todo", priority: "Medium", dueDate: "2026-04-15", assignedTo: "Nurse Rebecca", completed: false },
        { id: 4, title: "Assist with mobilization - Room B-106", description: "Help patient with physical therapy exercises", status: "completed", priority: "Low", dueDate: "2026-04-13", assignedTo: "Nurse Sarah", completed: true },
        { id: 5, title: "Check IV line - Room B-104", description: "Verify IV patency and change dressing if needed", status: "todo", priority: "High", dueDate: "2026-04-14", assignedTo: "Dr. Nakato Sarah", completed: false },
        { id: 6, title: "Update care plans for all patients", description: "Review and update nursing care plans", status: "todo", priority: "Medium", dueDate: "2026-04-16", assignedTo: "Nurse Rebecca", completed: false }
    ];

    let activeMenu = null;
    let currentSearch = "";
    let currentStatus = "all";
    let currentPriority = "all";
    let pendingDeleteTaskId = null;

    // ============================================================
    // HELPERS
    // ============================================================
    function closeMenu() { if(activeMenu) { activeMenu.remove(); activeMenu = null; } }

    function getStatusBadge(status) {
        const map = {
            'Stable': 'status-stable',
            'Observation': 'status-observation',
            'Critical': 'status-critical',
            'Administered': 'status-administered',
            'Pending': 'status-pending',
            'Missed': 'status-missed'
        };
        const cls = map[status] || 'status-pending';
        return `<span class="status-badge ${cls}">${status}</span>`;
    }

    function escapeHtml(str) {
        return String(str).replace(/[&<>]/g, function(m){
            if(m === '&') return '&amp;';
            if(m === '<') return '&lt;';
            if(m === '>') return '&gt;';
            return m;
        });
    }

    function showActionMenu(btn, item, type) {
        closeMenu();
        const rect = btn.getBoundingClientRect();
        const menu = document.createElement('div');
        menu.className = 'action-menu';
        let left = rect.left, top = rect.bottom + 6;
        if (left + 220 > window.innerWidth) left = window.innerWidth - 230;
        if (top + 250 > window.innerHeight) top = rect.top - 260;
        if (left < 10) left = 10;
        if (top < 10) top = 10;
        menu.style.top = top + 'px';
        menu.style.left = left + 'px';
        menu.innerHTML = `
            <div class="action-menu-header">${type} Actions</div>
            <button data-action="view" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>View Details</button>
            <button data-action="history" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>Medical History</button>
            <div class="action-divider"></div>
            <button data-action="note" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>Add Note</button>
        `;
        document.body.appendChild(menu);
        activeMenu = menu;
        menu.addEventListener('click', e => {
            const action = e.target.closest('[data-action]')?.dataset.action;
            if (!action) return;
            closeMenu();
            if (action === 'view') window.location.href = 'patient-profile.html';
            else if (action === 'history') window.location.href = 'history.html';
            else if (action === 'note') MeditrackUtils.openModal('addNoteModal');
        });
        setTimeout(() => {
            document.addEventListener('click', function h(e) {
                if (!menu.contains(e.target) && e.target !== btn) {
                    closeMenu();
                    document.removeEventListener('click', h);
                }
            }, { once: false });
        }, 10);
    }

    // ============================================================
    // RENDER FUNCTIONS
    // ============================================================
    function renderPatients() {
        document.getElementById('patientsTableBody').innerHTML = patients.map(p => `
            <tr class="border-b data-row">
                <td class="px-4 py-3"><div class="flex items-center gap-3"><span class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="${p.name}"></span><span class="font-medium">${p.name}</span></div></td>
                <td class="px-4 py-3 text-sm">${p.room}</td>
                <td class="px-4 py-3 text-sm text-gray-500 hidden md:table-cell">${p.diagnosis}</td>
                <td class="px-4 py-3">${getStatusBadge(p.status)}</td>
                <td class="px-4 py-3 text-right"><button class="action-trigger inline-flex items-center justify-center h-10 w-10 rounded-md hover:bg-gray-100" data-name="${p.name}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button></td>
            </tr>
        `).join('');
        document.querySelectorAll('#patientsTableBody .action-trigger').forEach(b => {
            b.addEventListener('click', e => {
                e.stopPropagation();
                const p = patients.find(x => x.name === b.dataset.name);
                if (p) showActionMenu(b, p, 'Patient');
            });
        });
    }

    function renderMedications() {
        document.getElementById('medicationsTableBody').innerHTML = medications.map(m => `
            <tr class="border-b data-row">
                <td class="px-4 py-3 font-medium">${m.patient}</td>
                <td class="px-4 py-3 text-sm">${m.med}</td>
                <td class="px-4 py-3 text-sm text-gray-500 hidden md:table-cell">${m.dosage}</td>
                <td class="px-4 py-3 text-sm">${m.time}</td>
                <td class="px-4 py-3">${getStatusBadge(m.status)}</td>
                <td class="px-4 py-3 text-right"><button class="action-trigger inline-flex items-center justify-center h-10 w-10 rounded-md hover:bg-gray-100" data-patient="${m.patient}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button></td>
            </tr>
        `).join('');
        document.querySelectorAll('#medicationsTableBody .action-trigger').forEach(b => {
            b.addEventListener('click', e => {
                e.stopPropagation();
                const m = medications.find(x => x.patient === b.dataset.patient);
                if (m) showActionMenu(b, m, 'Medication');
            });
        });
    }

    function renderVitals() {
        document.getElementById('vitalsTableBody').innerHTML = vitals.map(v => `
            <tr class="border-b data-row">
                <td class="px-4 py-3 font-medium">${v.patient}</td>
                <td class="px-4 py-3">${v.bp}</td>
                <td class="px-4 py-3">${v.hr}</td>
                <td class="px-4 py-3 text-sm text-gray-500 hidden md:table-cell">${v.temp}°F</td>
                <td class="px-4 py-3 text-sm hidden lg:table-cell">${v.o2}</td>
                <td class="px-4 py-3 text-sm text-gray-500">${v.updated}</td>
                <td class="px-4 py-3 text-right"><button class="action-trigger inline-flex items-center justify-center h-10 w-10 rounded-md hover:bg-gray-100" data-name="${v.patient}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="12" cy="5" r="1"/><circle cx="12" cy="19" r="1"/></svg></button></td>
            </tr>
        `).join('');
        document.querySelectorAll('#vitalsTableBody .action-trigger').forEach(b => {
            b.addEventListener('click', e => {
                e.stopPropagation();
                const v = vitals.find(x => x.patient === b.dataset.name);
                if (v) showActionMenu(b, v, 'Vitals');
            });
        });
    }

    function renderHandover() {
        document.getElementById('handoverPatients').innerHTML = patients.filter(p => p.status === 'Critical' || p.status === 'Observation').map(p => `
            <div class="flex items-center justify-between p-2 rounded-md bg-gray-50">
                <div><span class="font-medium text-sm">${p.name}</span><span class="text-xs text-gray-500 ml-2">${p.room}</span></div>
                ${getStatusBadge(p.status)}
            </div>
        `).join('');
    }

    // ============================================================
    // TASKS FUNCTIONS
    // ============================================================
    document.getElementById('addTaskBtn')?.addEventListener('click', function() {
        openTaskModal(null);
    });

    function filterTasks() {
        return tasks.filter(task => {
            const matchesSearch = task.title.toLowerCase().includes(currentSearch.toLowerCase()) || task.description.toLowerCase().includes(currentSearch.toLowerCase());
            const matchesStatus = currentStatus === "all" || task.status === currentStatus;
            const matchesPriority = currentPriority === "all" || task.priority === currentPriority;
            return matchesSearch && matchesStatus && matchesPriority;
        });
    }

    function updateTaskCount() {
        const filtered = filterTasks();
        const countEl = document.querySelector("#tab-tasks .text-gray-500.text-sm");
        if (countEl) {
            countEl.innerText = `Pending tasks for your shift • ${filtered.length} tasks`;
        }
    }

    function toggleTaskCompletion(id) {
        const task = tasks.find(t => t.id === id);
        if (task) {
            task.completed = !task.completed;
            task.status = task.completed ? "completed" : (task.status === "completed" ? "todo" : task.status);
            renderTasks();
            MeditrackUtils.showToast(task.completed ? 'Task completed!' : 'Task reopened');
        }
    }

    // ============================================================
    // DELETE TASK WITH ALERT DIALOG
    // ============================================================
    function showDeleteConfirmation(taskId, taskTitle) {
        pendingDeleteTaskId = taskId;
        
        // Create overlay
        const overlay = document.createElement('div');
        overlay.className = 'alert-dialog-overlay';
        overlay.style.cssText = 'position:fixed;inset:0;background-color:rgba(0,0,0,0.87);backdrop-filter:blur(4px);z-index:1100;display:flex;align-items:center;justify-content:center;';
        
        // Create modal dialog
        overlay.innerHTML = `
            <div role="alertdialog" class="alert-dialog" aria-labelledby="dialog-title" aria-describedby="dialog-description" style="background-color:white;border-radius:0.75rem;width:90%;max-width:450px;box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);animation:fadeIn 0.2s ease-out;overflow:hidden;">
                <div class="alert-dialog-header" style="padding:1.5rem 1.5rem 0.75rem 1.5rem;">
                    <h2 id="dialog-title" class="alert-dialog-title" style="font-size:1.125rem;font-weight:600;color:#111827;margin:0 0 0.5rem 0;">Are you sure you want to Delete this task</h2>
                    <p id="dialog-description" class="alert-dialog-description" style="font-size:0.875rem;color:#6b7280;line-height:1.5;margin:0;">
                        This will permanently delete the task <span class="font-medium" style="font-weight:500;">"${escapeHtml(taskTitle)}"</span> and cannot be undone.
                    </p>
                </div>
                <div class="alert-dialog-footer" style="padding:1rem 1.5rem 1.5rem 1.5rem;display:flex;justify-content:flex-end;gap:0.75rem;">
                    <button type="button" class="alert-dialog-cancel" style="display:inline-flex;align-items:center;justify-content:center;border-radius:0.5rem;padding:0.5rem 1rem;font-size:0.875rem;font-weight:500;background-color:transparent;border:1px solid #e5e7eb;color:#374151;cursor:pointer;">Cancel</button>
                    <button type="button" class="alert-dialog-delete" style="display:inline-flex;align-items:center;justify-content:center;border-radius:0.5rem;padding:0.5rem 1rem;font-size:0.875rem;font-weight:500;background-color:#ef4444;border:none;color:white;cursor:pointer;">Delete</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(overlay);
        document.body.style.overflow = 'hidden';
        
        // Close function
        const closeModal = () => {
            if (overlay && overlay.parentNode) {
                overlay.remove();
            }
            document.body.style.overflow = '';
            pendingDeleteTaskId = null;
        };
        
        // Cancel button handler
        const cancelBtn = overlay.querySelector('.alert-dialog-cancel');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', closeModal);
        }
        
        // Delete button handler
        const deleteBtn = overlay.querySelector('.alert-dialog-delete');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', () => {
                if (pendingDeleteTaskId !== null) {
                    tasks = tasks.filter(t => t.id !== pendingDeleteTaskId);
                    renderTasks();
                    MeditrackUtils.showToast('Task deleted successfully');
                }
                closeModal();
            });
        }
        
        // Click outside to close
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) closeModal();
        });
        
        // Close on Escape key
        const escHandler = (e) => {
            if (e.key === 'Escape') {
                closeModal();
                document.removeEventListener('keydown', escHandler);
            }
        };
        document.addEventListener('keydown', escHandler);
    }

    function deleteTask(id) {
        const task = tasks.find(t => t.id === id);
        if (task) {
            showDeleteConfirmation(id, task.title);
        }
    }

    // ============================================================
    // TASK EDIT MODAL
    // ============================================================
    function openTaskModal(existingTask = null) {
        const isEdit = !!existingTask;
        
        // Remove any existing modal
        const existingModal = document.querySelector('.task-modal-backdrop');
        if (existingModal) existingModal.remove();

        // Create modal backdrop
        const backdrop = document.createElement('div');
        backdrop.className = 'task-modal-backdrop';
        backdrop.style.cssText = 'position:fixed;inset:0;background-color:rgb(0 0 0 / 87%);backdrop-filter:blur(4px);z-index:1000;display:flex;align-items:center;justify-content:center;animation:fadeIn 0.2s ease-out;';
        
        // Build modal content with Radix UI style selects
        backdrop.innerHTML = `
            <div class="task-modal" role="dialog" aria-labelledby="task-modal-title" style="background:white;border-radius:0.75rem;width:100%;max-width:550px;max-height:90vh;overflow-y:auto;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);animation:slideUp 0.2s ease;">
                <div class="task-modal-header" style="padding:1rem 1.5rem;border-bottom:1px solid #e5e7eb;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;background:white;z-index:10;border-radius:0.75rem 0.75rem 0 0;">
                    <h2 id="task-modal-title" class="task-modal-title" style="font-size:1.125rem;font-weight:600;">${isEdit ? 'Edit Task' : 'Create New Task'}</h2>
                    <button type="button" class="task-modal-close" aria-label="Close" style="background:transparent;border:none;font-size:1.5rem;cursor:pointer;color:#6b7280;width:28px;height:28px;display:flex;align-items:center;justify-content:center;border-radius:0.375rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                    </button>
                </div>
                <div class="task-modal-body" style="padding:1.5rem;">
                    <div class="grid gap-4">
                        <div>
                            <label class="text-sm font-medium block mb-1">Title <span class="text-red-500">*</span></label>
                            <input type="text" id="taskModalTitle" class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm" placeholder="Task title" value="${isEdit ? escapeHtml(existingTask.title) : ''}">
                        </div>
                        <div>
                            <label class="text-sm font-medium block mb-1">Description</label>
                            <textarea id="taskModalDesc" rows="3" class="flex min-h-[80px] w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm" placeholder="Task description">${isEdit ? escapeHtml(existingTask.description) : ''}</textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium block mb-1">Status</label>
                                <div class="relative">
                                    <button type="button" id="taskModalStatusBtn" class="select-trigger justify-between" style="display:flex;height:2.5rem;width:100%;align-items:center;justify-content:space-between;border-radius:0.375rem;border:1px solid #d1d5db;background-color:#ffffff;padding:0 0.75rem;font-size:0.875rem;cursor:pointer;transition:all 0.15s ease;color:#374151;">
                                        <span id="taskModalStatusText">${isEdit ? existingTask.status : 'Select status'}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                                    </button>
                                    <div id="taskModalStatusDropdown" class="select-content hidden" style="position:absolute;z-index:50;background-color:white;border-radius:0.5rem;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);border:1px solid #e5e7eb;margin-top:4px;width:100%;max-height:240px;overflow-y:auto;animation:fadeInScale 0.12s ease-out;">
                                        <div class="select-item" data-value="todo">To Do</div>
                                        <div class="select-item" data-value="in progress">In Progress</div>
                                        <div class="select-item" data-value="completed">Completed</div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="text-sm font-medium block mb-1">Priority</label>
                                <div class="relative">
                                    <button type="button" id="taskModalPriorityBtn" class="select-trigger justify-between" style="display:flex;height:2.5rem;width:100%;align-items:center;justify-content:space-between;border-radius:0.375rem;border:1px solid #d1d5db;background-color:#ffffff;padding:0 0.75rem;font-size:0.875rem;cursor:pointer;transition:all 0.15s ease;color:#374151;">
                                        <span id="taskModalPriorityText">${isEdit ? existingTask.priority : 'Select priority'}</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                                    </button>
                                    <div id="taskModalPriorityDropdown" class="select-content hidden" style="position:absolute;z-index:50;background-color:white;border-radius:0.5rem;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);border:1px solid #e5e7eb;margin-top:4px;width:100%;max-height:240px;overflow-y:auto;animation:fadeInScale 0.12s ease-out;">
                                        <div class="select-item" data-value="High">High</div>
                                        <div class="select-item" data-value="Medium">Medium</div>
                                        <div class="select-item" data-value="Low">Low</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-medium block mb-1">Due Date</label>
                            <input type="date" id="taskModalDueDate" class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm" value="${isEdit ? existingTask.dueDate : ''}">
                        </div>
                        <div>
                            <label class="text-sm font-medium block mb-1">Assigned To</label>
                            <input type="text" id="taskModalAssigned" class="flex h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm" placeholder="Person responsible" value="${isEdit ? escapeHtml(existingTask.assignedTo) : ''}">
                        </div>
                    </div>
                </div>
                <div class="task-modal-footer" style="padding:1rem 1.5rem;border-top:1px solid #e5e7eb;display:flex;justify-content:flex-end;gap:0.75rem;position:sticky;bottom:0;background:white;">
                    <button type="button" class="task-modal-cancel border border-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-100">Cancel</button>
                    <button type="button" class="task-modal-save bg-primary text-white px-4 py-2 rounded-md text-sm hover:bg-primary/90">${isEdit ? 'Update Task' : 'Create Task'}</button>
                </div>
            </div>
        `;

        document.body.appendChild(backdrop);

        // Get elements
        const closeBtn = backdrop.querySelector('.task-modal-close');
        const cancelBtn = backdrop.querySelector('.task-modal-cancel');
        const saveBtn = backdrop.querySelector('.task-modal-save');

        // Close handlers
        function closeTaskModal() {
            backdrop.remove();
        }

        closeBtn.addEventListener('click', closeTaskModal);
        cancelBtn.addEventListener('click', closeTaskModal);
        backdrop.addEventListener('click', function(e) {
            if (e.target === backdrop) closeTaskModal();
        });

        // Setup Radix UI style selects for Status
        const statusBtn = document.getElementById('taskModalStatusBtn');
        const statusDropdown = document.getElementById('taskModalStatusDropdown');
        const statusText = document.getElementById('taskModalStatusText');
        
        statusBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            // Close other dropdowns
            document.querySelectorAll('#taskModalPriorityDropdown').forEach(d => d.classList.add('hidden'));
            statusDropdown.classList.toggle('hidden');
        });
        
        statusDropdown.querySelectorAll('.select-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.stopPropagation();
                statusText.textContent = this.dataset.value;
                statusDropdown.classList.add('hidden');
            });
        });

        // Setup Radix UI style selects for Priority
        const priorityBtn = document.getElementById('taskModalPriorityBtn');
        const priorityDropdown = document.getElementById('taskModalPriorityDropdown');
        const priorityText = document.getElementById('taskModalPriorityText');
        
        priorityBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            // Close other dropdowns
            document.querySelectorAll('#taskModalStatusDropdown').forEach(d => d.classList.add('hidden'));
            priorityDropdown.classList.toggle('hidden');
        });
        
        priorityDropdown.querySelectorAll('.select-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.stopPropagation();
                priorityText.textContent = this.dataset.value;
                priorityDropdown.classList.add('hidden');
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('#taskModalStatusBtn')) {
                document.getElementById('taskModalStatusDropdown')?.classList.add('hidden');
            }
            if (!e.target.closest('#taskModalPriorityBtn')) {
                document.getElementById('taskModalPriorityDropdown')?.classList.add('hidden');
            }
        });

        // Save handler
        saveBtn.addEventListener('click', function() {
            const title = document.getElementById('taskModalTitle').value.trim();
            const description = document.getElementById('taskModalDesc').value.trim();
            const status = document.getElementById('taskModalStatusText').textContent;
            const priority = document.getElementById('taskModalPriorityText').textContent;
            const dueDate = document.getElementById('taskModalDueDate').value;
            const assignedTo = document.getElementById('taskModalAssigned').value.trim();

            if (!title) {
                MeditrackUtils.showToast('Title is required', true);
                return;
            }

            if (isEdit) {
                const idx = tasks.findIndex(t => t.id === existingTask.id);
                if (idx !== -1) {
                    tasks[idx] = {
                        ...tasks[idx],
                        title,
                        description: description || tasks[idx].description,
                        status: status !== 'Select status' ? status : tasks[idx].status,
                        priority: priority !== 'Select priority' ? priority : tasks[idx].priority,
                        dueDate: dueDate || tasks[idx].dueDate,
                        assignedTo: assignedTo || tasks[idx].assignedTo,
                        completed: status === 'completed'
                    };
                }
                MeditrackUtils.showToast('Task updated successfully');
            } else {
                const newId = Date.now();
                tasks.push({
                    id: newId,
                    title,
                    description: description || 'New task',
                    status: status !== 'Select status' ? status : 'todo',
                    priority: priority !== 'Select priority' ? priority : 'Medium',
                    dueDate: dueDate || new Date().toISOString().split('T')[0],
                    assignedTo: assignedTo || 'Unassigned',
                    completed: status === 'completed'
                });
                MeditrackUtils.showToast('Task created successfully');
            }

            closeTaskModal();
            renderTasks();
        });

        // Close on Escape key
        const escHandler = function(e) {
            if (e.key === 'Escape') {
                closeTaskModal();
                document.removeEventListener('keydown', escHandler);
            }
        };
        document.addEventListener('keydown', escHandler);
    }

    // ============================================================
    // TASKS RENDER FUNCTION
    // ============================================================
    function renderTasks() {
        const filtered = filterTasks();
        const container = document.getElementById("tasksContainer");
        updateTaskCount();
        
        if (filtered.length === 0) {
            container.innerHTML = `<div class="flex flex-col items-center justify-center p-12 text-center"><h3 class="text-lg font-medium text-gray-900">No tasks found</h3><p class="text-gray-500">Try adjusting your search or filters</p></div>`;
            return;
        }

        container.innerHTML = filtered.map((task, idx) => `
            <div class="task-item p-4 rounded-lg border bg-background transition-all hover:shadow-sm" data-index="${idx}">
                <div class="flex items-start flex-wrap gap-3">
                    <div class="flex items-start grow gap-3">
                        <button type="button" class="task-checkbox h-4 w-4 shrink-0 rounded-sm border border-gray-300 mt-1 flex items-center justify-center ${task.completed ? 'bg-primary border-indigo-600' : 'bg-white'}" data-id="${task.id}">
                            ${task.completed ? '<svg class="h-3 w-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M20 6 9 17l-5-5"></path></svg>' : ''}
                        </button>
                        <div class="flex-1">
                            <div class="flex items-center flex-wrap gap-2">
                                <h3 class="font-medium ${task.completed ? 'line-through text-gray-500' : 'text-gray-900'}">${escapeHtml(task.title)}</h3>
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ${task.priority === 'High' ? 'bg-destructive text-destructive-foreground' : task.priority === 'Medium' ? 'bg-amber-500 text-white' : 'bg-gray-100 text-gray-700'}">${task.priority}</span>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">${escapeHtml(task.description)}</p>
                            <div class="flex flex-wrap gap-3 mt-3">
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="h-4 w-4 mr-1 ${task.status === 'todo' ? 'text-gray-400' : task.status === 'in progress' ? 'text-blue-500' : 'text-green-500'}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        ${task.status === 'todo' ? '<circle cx="12" cy="12" r="10"></circle>' : task.status === 'in progress' ? '<circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>' : '<circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path>'}
                                    </svg>
                                    <span class="capitalize">${task.status}</span>
                                </div>
                                <div class="flex items-center text-xs text-gray-500">
                                    <svg class="h-3.5 w-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                                    Due: ${task.dueDate}
                                </div>
                                <div class="flex items-center text-xs text-gray-500">
                                    <span>Assigned to: ${escapeHtml(task.assignedTo)}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-1">
                        <button class="edit-task p-2 rounded hover:bg-gray-100" data-id="${task.id}">
                            <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path></svg>
                        </button>
                        <button class="delete-task p-2 rounded hover:bg-gray-100" data-id="${task.id}">
                            <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
                        </button>
                    </div>
                </div>
            </div>
        `).join('');

        // Checkbox toggle
        document.querySelectorAll('.task-checkbox').forEach(btn => btn.addEventListener('click', (e) => { 
            e.stopPropagation(); 
            toggleTaskCompletion(parseInt(btn.dataset.id)); 
        }));
        
        // Delete task
        document.querySelectorAll('.delete-task').forEach(btn => btn.addEventListener('click', (e) => { 
            e.stopPropagation(); 
            deleteTask(parseInt(btn.dataset.id)); 
        }));
        
        // Edit task
        document.querySelectorAll('.edit-task').forEach(btn => btn.addEventListener('click', (e) => { 
            e.stopPropagation(); 
            const task = tasks.find(t => t.id === parseInt(btn.dataset.id));
            if (task) openTaskModal(task);
        }));
    }

    // ============================================================
    // MODAL HANDLERS
    // ============================================================
    document.getElementById('saveAdmitBtn')?.addEventListener('click', () => {
        const n = document.getElementById('admitName').value;
        if (!n) { MeditrackUtils.showToast('Please enter patient name', true); return; }
        patients.push({
            name: n,
            room: document.getElementById('roomSelectText').textContent,
            diagnosis: document.getElementById('admitDiagnosis').value || 'Pending',
            status: 'Stable',
            doctor: document.getElementById('doctorSelectText').textContent
        });
        renderPatients();
        MeditrackUtils.showToast(`${n} admitted successfully`);
        MeditrackUtils.closeModal('addPatientModal');
    });

    document.getElementById('saveVitalsBtn')?.addEventListener('click', () => {
        const p = document.getElementById('vitalsPatientSelectText').textContent;
        const bp = document.getElementById('vitalsBP').value;
        if (p === 'Select patient' || !bp) {
            MeditrackUtils.showToast('Please select patient and enter blood pressure', true);
            return;
        }
        const idx = vitals.findIndex(v => v.patient === p);
        const data = {
            patient: p,
            bp: bp,
            hr: document.getElementById('vitalsHR').value || '--',
            temp: document.getElementById('vitalsTemp').value || '--',
            o2: document.getElementById('vitalsO2').value ? document.getElementById('vitalsO2').value + '%' : '--',
            updated: 'Today, ' + new Date().toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })
        };
        if (idx > -1) vitals[idx] = data;
        else vitals.push(data);
        renderVitals();
        MeditrackUtils.showToast(`Vitals recorded for ${p}`);
        MeditrackUtils.closeModal('vitalsModal');
    });

    document.getElementById('saveMedBtn')?.addEventListener('click', () => {
        const p = document.getElementById('medPatientSelectText').textContent;
        const m = document.getElementById('medNameSelectText').textContent;
        const route = document.getElementById('medRouteSelectText').textContent;
        if (p === 'Select patient' || m === 'Select medication') {
            MeditrackUtils.showToast('Please select patient and medication', true);
            return;
        }
        medications.push({
            patient: p,
            med: m,
            dosage: '--',
            time: document.getElementById('medTime').value || 'Now',
            status: 'Administered'
        });
        renderMedications();
        MeditrackUtils.showToast(`Medication administered to ${p}`);
        MeditrackUtils.closeModal('administerMedModal');
    });

    document.getElementById('saveHandoverBtn')?.addEventListener('click', () => {
        MeditrackUtils.showToast('Handover report completed and sent!');
        MeditrackUtils.closeModal('handoverModal');
    });

    document.getElementById('saveNoteBtn')?.addEventListener('click', () => {
        const patient = document.getElementById('notePatientSelectText').textContent;
        const type = document.getElementById('noteTypeSelectText').textContent;
        const content = document.getElementById('noteContent').value.trim();
        if (patient === 'Select patient' || type === 'Select type' || !content) {
            MeditrackUtils.showToast('Please fill all required fields', true);
            return;
        }
        MeditrackUtils.showToast(`Note saved for ${patient}`);
        MeditrackUtils.closeModal('addNoteModal');
    });

    // ============================================================
    // TABS
    // ============================================================
    document.querySelectorAll('.tab-btn').forEach(b => {
        b.addEventListener('click', () => {
            const t = b.dataset.tab;
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            document.getElementById(`tab-${t}`).classList.add('active');
            document.querySelectorAll('.tab-btn').forEach(x => x.classList.remove('active', 'bg-white', 'text-gray-900', 'shadow-sm'));
            b.classList.add('active', 'bg-white', 'text-gray-900', 'shadow-sm');
        });
    });

    // ============================================================
    // MODAL UTILS INIT
    // ============================================================
    if (typeof MeditrackUtils === 'undefined') {
        window.MeditrackUtils = {
            openModal: function(id) {
                const modal = document.getElementById(id);
                if (modal) modal.classList.add('show');
            },
            closeModal: function(id) {
                const modal = document.getElementById(id);
                if (modal) modal.classList.remove('show');
            },
            closeAllModals: function() {
                document.querySelectorAll('.modal-overlay.show').forEach(m => m.classList.remove('show'));
            },
            showToast: function(msg, isErr) {
                const existing = document.querySelector('.toast-message');
                if (existing) existing.remove();
                const toast = document.createElement('div');
                toast.className = `toast-message ${isErr ? 'error' : ''}`;
                toast.textContent = msg;
                document.body.appendChild(toast);
                setTimeout(() => toast.remove(), 3000);
            },
            setupDropdown: function(triggerId, dropdownId, textId) {
                const trigger = document.getElementById(triggerId);
                const dropdown = document.getElementById(dropdownId);
                const textEl = document.getElementById(textId);
                if (!trigger || !dropdown) return;
                trigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    document.querySelectorAll('.select-content').forEach(d => d.classList.add('hidden'));
                    dropdown.classList.toggle('hidden');
                });
                dropdown.querySelectorAll('.select-item').forEach(item => {
                    item.addEventListener('click', function(e) {
                        e.stopPropagation();
                        if (textEl) textEl.textContent = this.dataset.value;
                        dropdown.classList.add('hidden');
                    });
                });
            }
        };
    }

    // Initialize select dropdowns
    MeditrackUtils.setupDropdown('roomSelectBtn', 'roomSelectDropdown', 'roomSelectText');
    MeditrackUtils.setupDropdown('doctorSelectBtn', 'doctorSelectDropdown', 'doctorSelectText');
    MeditrackUtils.setupDropdown('vitalsPatientSelectBtn', 'vitalsPatientSelectDropdown', 'vitalsPatientSelectText');
    MeditrackUtils.setupDropdown('medPatientSelectBtn', 'medPatientSelectDropdown', 'medPatientSelectText');
    MeditrackUtils.setupDropdown('medNameSelectBtn', 'medNameSelectDropdown', 'medNameSelectText');
    MeditrackUtils.setupDropdown('medRouteSelectBtn', 'medRouteSelectDropdown', 'medRouteSelectText');
    MeditrackUtils.setupDropdown('notePatientSelectBtn', 'notePatientSelectDropdown', 'notePatientSelectText');
    MeditrackUtils.setupDropdown('noteTypeSelectBtn', 'noteTypeSelectDropdown', 'noteTypeSelectText');
    MeditrackUtils.setupDropdown('notePrioritySelectBtn', 'notePrioritySelectDropdown', 'notePrioritySelectText');

    // Initialize modal closers
    document.querySelectorAll('.modal-close, [data-close]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const modalId = btn.dataset.close || btn.closest('.modal-overlay').id;
            MeditrackUtils.closeModal(modalId);
        });
    });
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) MeditrackUtils.closeModal(overlay.id);
        });
    });

    // ============================================================
    // KEYBOARD SHORTCUTS
    // ============================================================
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            MeditrackUtils.closeAllModals();
            closeMenu();
        }
    });

    // ============================================================
    // INIT
    // ============================================================
    renderPatients();
    renderMedications();
    renderVitals();
    renderTasks();
    renderHandover();

    console.log('✅ Nurse Station — Fully functional with Radix UI style selects');
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
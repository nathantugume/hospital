<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Surveys</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts" crossorigin="anonymous"></script>
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; margin: 0; padding: 0; box-sizing: border-box; }
        body { background-color: #f9fafb; }
        
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .bg-background { background-color: #131212 !important; }
        body.dark .border-gray-200, body.dark .border-gray-300, body.dark .border-input { border-color: #333333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700, 
        body.dark .text-muted-foreground, body.dark label, body.dark h1, body.dark h2, body.dark h3 { color: #e5e5e5 !important; }
        body.dark .bg-gray-50 { background-color: #1a1a1a !important; }
        body.dark .bg-gray-100, body.dark .bg-muted { background-color: #262626 !important; }
        body.dark .bg-indigo-50 { background-color: #1e1b4b !important; }
        body.dark .bg-green-50 { background-color: #064e3b !important; }
        body.dark .bg-red-50 { background-color: #7f1d1d !important; }
        body.dark .bg-amber-50 { background-color: #451a03 !important; }
        
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background-color: rgb(0 0 0 / 87%);
            backdrop-filter: blur(2px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-backdrop.hidden { display: none; }
        .modal-content {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: modalSlideUp 0.2s ease-out;
            max-width: 450px;
            width: 90%;
        }
        body.dark .modal-content { background: #131212; border: 1px solid #333; }
        
        @keyframes modalSlideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        .toast-notification { animation: slideInRight 0.3s ease-out; position: fixed; bottom: 24px; right: 24px; z-index: 1100; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-active { background-color: #dcfce7; color: #166534; }
        .status-draft { background-color: #fef9c3; color: #854d0e; }
        .status-inactive { background-color: #fee2e2; color: #991b1b; }
        body.dark .status-active { background-color: #14532d; color: #86efac; }
        body.dark .status-draft { background-color: #713f12; color: #fde047; }
        body.dark .status-inactive { background-color: #7f1d1d; color: #fca5a5; }
        
        .dropdown-content {
            position: absolute;
            z-index: 50;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            margin-top: 4px;
            min-width: 160px;
            max-height: 200px;
            overflow-y: auto;
        }
        body.dark .dropdown-content { background: #2a2a2a; border-color: #404040; }
        .dropdown-item { padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer; transition: background 0.1s; }
        .dropdown-item:hover { background-color: #f3f4f6; }
        body.dark .dropdown-item:hover { background-color: #3f3f46; }
        
        .survey-card, .response-card {
            transition: all 0.2s ease;
        }
        .survey-card:hover, .response-card:hover {
            transform: translateY(-2px);
        }
        
        .action-menu {
            position: absolute;
            z-index: 50;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            min-width: 180px;
            overflow: hidden;
        }
        body.dark .action-menu { background: #2a2a2a; border-color: #404040; }
        .action-menu-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background 0.1s;
        }
        .action-menu-item:hover { background-color: #f3f4f6; }
        body.dark .action-menu-item:hover { background-color: #3f3f46; }
        .action-menu-item svg { width: 1rem; height: 1rem; }
        .action-menu-separator { height: 1px; background-color: #e5e7eb; margin: 0.25rem 0; }
        body.dark .action-menu-separator { background-color: #404040; }
        .action-menu-item.text-red { color: #dc2626; }
        body.dark .action-menu-item.text-red { color: #f87171; }
        
        .tab-trigger.active {
            background-color: white !important;
            color: #1f2937 !important;
            box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);
        }
        body.dark .tab-trigger.active {
            background-color: #262626 !important;
            color: #e5e5e5 !important;
        }
        
        .progress-bar { transition: width 0.5s ease; }
        
        .comment-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, padding 0.3s ease;
            padding: 0 1rem;
        }
        .comment-content.expanded {
            max-height: 200px;
            padding: 1rem;
        }

        .action-menu {
    position: fixed;
    z-index: 100;
    min-width: 220px;
    background: white;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    padding: 0.25rem;
    animation: fadeIn 0.12s ease-out;
}
body.dark .action-menu {
    background: #2a2a2a;
    border-color: #404040;
}
.action-menu-header {
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6b7280;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 0.25rem;
}
body.dark .action-menu-header {
    color: #9ca3af;
    border-bottom-color: #404040;
}
.action-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    color: #374151;
    text-decoration: none;
    cursor: pointer;
    border-radius: 0.375rem;
    transition: background-color 0.15s;
}
body.dark .action-item {
    color: #e5e5e5;
}
.action-item:hover {
    background-color: #f3f4f6;
}
body.dark .action-item:hover {
    background-color: #3f3f46;
}
.action-item.text-red-600 {
    color: #dc2626;
}
body.dark .action-item.text-red-600 {
    color: #f87171;
}
.action-item.text-red-600:hover {
    background-color: #fee2e2;
}
body.dark .action-item.text-red-600:hover {
    background-color: #7f1d1d;
}
.action-divider {
    height: 1px;
    background-color: #e5e7eb;
    margin: 0.25rem 0;
}
body.dark .action-divider {
    background-color: #404040;
}
@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
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
            <div class="mx-auto space-y-6">
                <!-- Header -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">Surveys</h1>
        <p class="text-gray-500">Manage all your patient feedback surveys</p>
    </div>
    <div class="flex items-center gap-2">
        <button id="exportAllBtn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background px-5 py-2 text-sm font-medium text-gray-800 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-background hover:bg-accent hover:text-accent-foreground h-10">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
            Export Data
        </button>
        <a href="create-survey.html" class="bg-primary text-white hover:bg-indigo-700 h-10 px-4 rounded-md text-sm flex items-center gap-2 transition-colors">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
            Create Survey
        </a>
    </div>
</div>

<!-- Stats Cards - New Design -->
<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
    <div class="rounded-lg border border-gray-200 bg-background p-4 shadow-sm">
        <div class="flex justify-between items-center">
            <h3 class="text-sm font-medium text-gray-500">Total Surveys</h3>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-list h-5 w-5 text-gray-400">
                <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                <path d="M12 11h4"></path>
                <path d="M12 16h4"></path>
                <path d="M8 11h.01"></path>
                <path d="M8 16h.01"></path>
            </svg>
        </div>
        <div class="text-3xl font-bold mt-2 text-indigo-600" id="totalSurveys">8</div>
        <p class="text-xs text-gray-500">All surveys created</p>
    </div>
    
    <div class="rounded-lg border border-gray-200 bg-background p-4 shadow-sm">
        <div class="flex justify-between items-center">
            <h3 class="text-sm font-medium text-gray-500">Active Surveys</h3>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle h-5 w-5 text-green-500">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
        </div>
        <div class="text-3xl font-bold mt-2 text-green-600" id="activeSurveys">4</div>
        <p class="text-xs text-gray-500">Currently collecting responses</p>
    </div>
    
    <div class="rounded-lg border border-gray-200 bg-background p-4 shadow-sm">
        <div class="flex justify-between items-center">
            <h3 class="text-sm font-medium text-gray-500">Total Responses</h3>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square h-5 w-5 text-amber-500">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
        </div>
        <div class="text-3xl font-bold mt-2 text-amber-600" id="totalResponses">1,284</div>
        <p class="text-xs text-gray-500">From all active surveys</p>
    </div>
    
    <div class="rounded-lg border border-gray-200 bg-background p-4 shadow-sm">
        <div class="flex justify-between items-center">
            <h3 class="text-sm font-medium text-gray-500">Avg. Satisfaction</h3>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star h-5 w-5 text-yellow-500">
                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
            </svg>
        </div>
        <div class="text-3xl font-bold mt-2 text-emerald-600" id="avgSatisfaction">4.1</div>
        <p class="text-xs text-gray-500">out of 5 stars</p>
    </div>
</div>

                <!-- Tabs -->
<div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1 text-gray-500">
    <button type="button" data-tab="surveys" class="tab-trigger active inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all bg-white text-gray-900 shadow-sm">Surveys</button>
    <button type="button" data-tab="responses" class="tab-trigger inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Recent Responses</button>
    <button type="button" data-tab="analytics" class="tab-trigger inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Analytics</button>
    <button type="button" data-tab="performance" class="tab-trigger inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Performance Rankings</button>
</div>

                <!-- Tab Content: Surveys -->
                <div id="surveysTab" class="space-y-4">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex items-center gap-2">
                            <div class="relative">
                                <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                                <input id="surveySearch" type="search" placeholder="Search surveys..." class="pl-8 w-[200px] md:w-[300px] h-10 rounded-md border border-gray-300 px-3 py-2 text-sm bg-white">
                            </div>
                            <div class="relative">
                                <button id="statusFilterBtn" class="flex h-10 items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm w-[180px]">
                                    <span id="statusFilterText">All Status</span>
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>
                                </button>
                                <div id="statusFilterDropdown" class="hidden dropdown-content">
                                    <div data-status="All" class="dropdown-item">All Status</div>
                                    <div data-status="Active" class="dropdown-item">Active</div>
                                    <div data-status="Draft" class="dropdown-item">Draft</div>
                                    <div data-status="Inactive" class="dropdown-item">Inactive</div>
                                </div>
                            </div>
                            <button id="clearFiltersBtn" class="border border-gray-300 bg-white hover:bg-gray-50 h-10 px-4 rounded-md text-sm">Clear</button>
                        </div>
                        <div class="text-gray-500 text-sm" id="surveyCount">Showing 8 of 8 surveys</div>
                    </div>
                    <div id="surveysGrid" class="grid grid-cols-1 lg:grid-cols-2 gap-5"></div>
                </div>

                <!-- Tab Content: Recent Responses -->
                <div id="responsesTab" class="hidden space-y-4">
                    <div class="flex justify-between items-center">
                        <div><h2 class="text-xl font-semibold">Recent Anonymous Responses</h2><p class="text-gray-500 text-sm">Latest feedback from patients across all surveys</p></div>
                        <a href="survey-responses.html" class="text-indigo-600 text-sm hover:text-indigo-700 flex items-center gap-1">View all responses <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></a>
                    </div>
                    <div id="recentResponsesList" class="grid grid-cols-1 lg:grid-cols-2 gap-5"></div>
                </div>

                <!-- Tab Content: Analytics -->
                <div id="analyticsTab" class="hidden space-y-6">
                    <!-- Satisfaction Trend - Full width -->
                    <div class="rounded-lg border border-gray-200 bg-background shadow-sm p-4">
                        <h3 class="text-lg font-semibold mb-2">Satisfaction Trend</h3>
                        <p class="text-xs text-gray-500 mb-4">Monthly average satisfaction scores vs. response volume</p>
                        <div id="satisfactionTrendChart"></div>
                    </div>
                    
                    <!-- Two columns for Department and Rating Distribution -->
                    <div class="grid grid-cols-2 lg:grid-cols-2 gap-6">
                        <div class="rounded-lg border border-gray-200 bg-background shadow-sm p-4">
                            <h3 class="text-lg font-semibold mb-2">Responses by Department</h3>
                            <p class="text-xs text-gray-500 mb-4">Distribution of feedback across departments</p>
                            <div id="departmentChart"></div>
                        </div>
                        <div class="rounded-lg border border-gray-200 bg-background shadow-sm p-4">
                            <h3 class="text-lg font-semibold mb-2">Rating Distribution</h3>
                            <p class="text-xs text-gray-500 mb-4">Breakdown of satisfaction ratings (1-5 stars)</p>
                            <div id="ratingDistributionChart"></div>
                        </div>
                    </div>
                    
                    <!-- Survey Performance - Full width -->
                    <div class="rounded-lg border border-gray-200 bg-background shadow-sm p-4">
                        <h3 class="text-lg font-semibold mb-2">Survey Performance</h3>
                        <p class="text-xs text-gray-500 mb-4">Responses per survey</p>
                        <div id="surveyResponsesChart"></div>
                    </div>
                </div>

                <!-- Tab Content: Performance Rankings -->
<div id="performanceTab" class="hidden space-y-6">
    <!-- Facility Rankings Section -->
    <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
        <div class="p-4 border-b">
            <h2 class="text-xl font-semibold">Branch Performance Rankings</h2>
            <p class="text-gray-500 text-sm">Ranking of health facilities based on patient satisfaction scores</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">Rank</th>
                        <th class="px-4 py-3 text-left font-medium">Branch Name</th>
                        <th class="px-4 py-3 text-left font-medium">Satisfaction Score</th>
                        <th class="px-4 py-3 text-left font-medium">Total Responses</th>
                        <th class="px-4 py-3 text-left font-medium">Would Recommend (%)</th>
                        <th class="px-4 py-3 text-left font-medium">Avg Wait Time (min)</th>
                        <th class="px-4 py-3 text-left font-medium">Trend</th>
                    </tr>
                </thead>
                <tbody id="facilityRankingsBody"></tbody>
            </table>
        </div>
    </div>

    <!-- Department Rankings Section -->
    <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
        <div class="p-4 border-b">
            <h2 class="text-xl font-semibold">Department Performance Rankings</h2>
            <p class="text-gray-500 text-sm">Ranking of departments across all facilities</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium">Rank</th>
                        <th class="px-4 py-3 text-left font-medium">Department</th>
                        <th class="px-4 py-3 text-left font-medium">Satisfaction Score</th>
                        <th class="px-4 py-3 text-left font-medium">Total Responses</th>
                        <th class="px-4 py-3 text-left font-medium">Staff Friendly (%)</th>
                        <th class="px-4 py-3 text-left font-medium">Cleanliness (%)</th>
                        <th class="px-4 py-3 text-left font-medium">Avg Wait Time (min)</th>
                    </tr>
                </thead>
                <tbody id="departmentRankingsBody"></tbody>
            </table>
        </div>
    </div>

<!-- Top Compliments and Common Complaints - Side by Side -->
<div class="grid grid-cols-2 lg:grid-cols-2 gap-6">
    <!-- Top Compliments Section -->
    <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
        <div class="p-4 border-b">
            <h2 class="text-xl font-semibold">Top Compliments</h2>
            <p class="text-gray-500 text-sm">Most appreciated aspects of service delivery</p>
        </div>
        <div class="p-4 space-y-3" id="topComplimentsList"></div>
    </div>

    <!-- Common Complaints Section -->
    <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
        <div class="p-4 border-b">
            <h2 class="text-xl font-semibold">Common Complaints</h2>
            <p class="text-gray-500 text-sm">Areas needing improvement based on patient feedback</p>
        </div>
        <div class="p-4 space-y-3" id="commonComplaintsList"></div>
    </div>
</div>
</div>
            </div>
        </main>
    </div>

    <!-- Delete Survey Modal -->
    <div id="deleteSurveyModal" class="modal-backdrop hidden">
        <div class="modal-content p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="h-5 w-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                </div>
                <h2 class="text-lg font-semibold">Delete Survey?</h2>
            </div>
            <p id="deleteSurveyMessage" class="text-sm text-gray-600 mb-6">This action will permanently delete this survey and all associated responses. This cannot be undone.</p>
            <div class="flex justify-end gap-3">
                <button id="cancelDeleteBtn" class="px-4 py-2 rounded-md border border-gray-300 text-sm font-medium hover:bg-gray-100 transition">Cancel</button>
                <button id="confirmDeleteBtn" class="px-4 py-2 rounded-md bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition">Delete Survey</button>
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
    // Survey data
    let surveys = [
        { id: 1, title: "Patient Satisfaction Survey", description: "General satisfaction survey for all patients", status: "Active", responses: 342, created: "2026-03-15", lastModified: "2026-05-28", avgRating: 4.2, completionRate: 78 },
        { id: 2, title: "Outpatient Services Feedback", description: "Feedback for outpatient department services", status: "Active", responses: 187, created: "2026-04-01", lastModified: "2026-05-25", avgRating: 4.0, completionRate: 72 },
        { id: 3, title: "Telemedicine Consultation Feedback", description: "Virtual consultation experience survey", status: "Active", responses: 96, created: "2026-04-20", lastModified: "2026-05-27", avgRating: 4.5, completionRate: 85 },
        { id: 4, title: "Post-Surgery Follow-up", description: "Recovery and post-operative care feedback", status: "Active", responses: 54, created: "2026-05-01", lastModified: "2026-05-26", avgRating: 4.3, completionRate: 80 },
        { id: 5, title: "Pharmacy Service Quality Survey", description: "Medication dispensing and pharmacy experience", status: "Inactive", responses: 128, created: "2026-02-10", lastModified: "2026-04-30", avgRating: 3.5, completionRate: 65 },
        { id: 6, title: "Pediatrics Patient Feedback", description: "Specialized clinic feedback for Pediatrics patients", status: "Draft", responses: 0, created: "2026-05-22", lastModified: "2026-05-22", avgRating: 0, completionRate: 0 },
        { id: 7, title: "Maternity Ward Experience", description: "Pregnancy and delivery care feedback", status: "Active", responses: 234, created: "2026-03-10", lastModified: "2026-05-24", avgRating: 4.4, completionRate: 82 },
        { id: 8, title: "COVID-19 Vaccination Survey", description: "Vaccination campaign feedback", status: "Draft", responses: 0, created: "2026-05-15", lastModified: "2026-05-20", avgRating: 0, completionRate: 0 }
    ];

    let filteredSurveys = [...surveys];
    let currentActionMenu = null;
    let deleteSurveyId = null;

    // Recent responses data
    const recentResponses = [
        { id: 1, date: "2026-05-28", time: "14:30", satisfaction: 5, department: "General Medicine", survey: "Patient Satisfaction Survey", comment: "The staff was very professional and caring. I felt well taken care of during my visit." },
        { id: 2, date: "2026-05-28", time: "11:15", satisfaction: 4, department: "Immunization", survey: "Outpatient Services Feedback", comment: "Nurses were gentle with my baby and explained everything clearly." },
        { id: 3, date: "2026-05-27", time: "09:45", satisfaction: 2, department: "Pharmacy", survey: "Pharmacy Service Quality Survey", comment: "Medicines were out of stock again. Had to come back three times." },
        { id: 4, date: "2026-05-27", time: "13:20", satisfaction: 5, department: "Cardiology", survey: "Cardiology Ward Experience", comment: "The nurse was very supportive throughout my treatment journey." },
        { id: 5, date: "2026-05-26", time: "16:00", satisfaction: 3, department: "Outpatient clinic", survey: "Patient Satisfaction Survey", comment: "Long wait, but doctor was good and addressed all my concerns." },
        { id: 6, date: "2026-05-26", time: "10:30", satisfaction: 5, department: "Telemedicine", survey: "Telemedicine Consultation Feedback", comment: "Virtual visit was convenient and doctor was very thorough." }
    ];

    function escapeHtml(str) { return String(str).replace(/[&<>]/g, function(m) { return m === '&' ? '&amp;' : m === '<' ? '&lt;' : '&gt;'; }); }

    function showToast(message, type = 'success') {
        const existing = document.querySelector('.toast-notification');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.className = `toast-notification flex items-center gap-2 px-4 py-3 rounded-lg shadow-lg text-white text-sm`;
        toast.style.backgroundColor = type === 'success' ? '#10b981' : '#ef4444';
        toast.innerHTML = `<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg><span>${message}</span>`;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    function updateStats() {
        const total = surveys.length;
        const active = surveys.filter(s => s.status === 'Active').length;
        const totalResponses = surveys.reduce((sum, s) => sum + s.responses, 0);
        const avgSat = surveys.filter(s => s.avgRating > 0).reduce((sum, s) => sum + s.avgRating, 0) / surveys.filter(s => s.avgRating > 0).length || 0;
        
        document.getElementById('totalSurveys').innerHTML = total;
        document.getElementById('activeSurveys').innerHTML = active;
        document.getElementById('totalResponses').innerHTML = totalResponses;
        document.getElementById('avgSatisfaction').innerHTML = avgSat.toFixed(1);
    }

    function renderSurveysGrid() {
        const searchTerm = document.getElementById('surveySearch')?.value.toLowerCase() || '';
        const statusFilter = document.getElementById('statusFilterText').innerText;
        
        filteredSurveys = surveys.filter(survey => {
            if (searchTerm && !survey.title.toLowerCase().includes(searchTerm) && !survey.description.toLowerCase().includes(searchTerm)) return false;
            if (statusFilter !== 'All Status' && survey.status !== statusFilter) return false;
            return true;
        });
        
        const container = document.getElementById('surveysGrid');
        document.getElementById('surveyCount').innerHTML = `Showing ${filteredSurveys.length} of ${surveys.length} surveys`;
        
        if (filteredSurveys.length === 0) {
            container.innerHTML = `<div class="col-span-2 text-center py-12 text-gray-500 border-2 border-dashed rounded-lg">No surveys found. Create your first survey!</div>`;
            return;
        }
        
        container.innerHTML = filteredSurveys.map(s => `
            <div class="survey-card rounded-lg border border-gray-200 bg-background shadow-sm hover:shadow-md ">
                <div class="p-4 pb-2">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-xl font-semibold tracking-tight">${escapeHtml(s.title)}</h2>
                            <div class="text-gray-500 text-sm mt-0.5">${escapeHtml(s.description)}</div>
                        </div>
                        <button class="action-menu-btn p-1 hover:bg-gray-100 rounded transition-colors" data-id="${s.id}">
                            <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                        </button>
                    </div>
                </div>
                <div class="p-4 pt-2">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div><div class="text-sm font-medium">Status</div><div><span class="status-badge status-${s.status.toLowerCase()}">${s.status}</span></div></div>
                        <div><div class="text-sm font-medium">Responses</div><div class="text-lg font-semibold">${s.responses}</div></div>
                        <div><div class="text-sm font-medium">Average Rating</div><div class="flex items-center gap-1"><span class="text-lg font-semibold">${s.avgRating || '—'}</span>${s.avgRating > 0 ? '<span class="text-yellow-500">★</span>' : ''}</div></div>
                    </div>
                    ${s.completionRate > 0 ? `
                    <div class="mt-4">
                        <div class="flex justify-between text-sm"><span>Completion Rate</span><span>${s.completionRate}%</span></div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-1"><div class="bg-primary h-2 rounded-full transition-all duration-500" style="width: ${s.completionRate}%"></div></div>
                    </div>` : ''}
                </div>
                <div class="text-gray-500 p-4 pt-0 text-sm">Created on ${s.created} • Last updated ${s.lastModified}</div>
            </div>
        `).join('');
        
        attachActionButtons();
    }

    function attachActionButtons() {
        document.querySelectorAll('.action-menu-btn').forEach(btn => {
            btn.removeEventListener('click', handleActionClick);
            btn.addEventListener('click', handleActionClick);
        });
    }

    function handleActionClick(e) {
        e.stopPropagation();
        const btn = e.currentTarget;
        const surveyId = parseInt(btn.dataset.id);
        const survey = surveys.find(s => s.id === surveyId);
        
        if (currentActionMenu) currentActionMenu.remove();
        
        const rect = btn.getBoundingClientRect();
        const menu = document.createElement('div');
        menu.className = 'action-menu';
        menu.style.top = `${rect.bottom + 4}px`;
        menu.style.right = `${window.innerWidth - rect.right}px`;
        menu.innerHTML = `
            <div class="action-menu-header">Actions</div>
            <a href="survey-details.html?id=${surveyId}" class="action-item">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg>
                View Details
            </a>
            <a href="edit-survey.html?id=${surveyId}" class="action-item">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path></svg>
                Edit Survey
            </a>
            <a href="survey-responses.html?survey=${surveyId}" class="action-item">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                View Responses (${survey.responses})
            </a>
            <div class="action-divider"></div>
            <button data-action="deactivate" data-id="${surveyId}" data-name="${escapeHtml(survey.title)}" class="action-item">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="18" y1="6" x2="6" y2="18"></line></svg>
                Deactivate Survey
            </button>
            <button data-action="delete" data-id="${surveyId}" data-name="${escapeHtml(survey.title)}" data-responses="${survey.responses}" class="action-item text-red-600">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
                Delete Survey
            </button>
        `;
        document.body.appendChild(menu);
        currentActionMenu = menu;
        
        const closeMenu = (e) => {
            if (!menu.contains(e.target) && e.target !== btn) {
                menu.remove();
                currentActionMenu = null;
                document.removeEventListener('click', closeMenu);
            }
        };
        setTimeout(() => document.addEventListener('click', closeMenu), 0);
        
        const deactivateBtn = menu.querySelector('[data-action="deactivate"]');
        if (deactivateBtn) {
            deactivateBtn.addEventListener('click', () => {
                const surveyName = deactivateBtn.dataset.name;
                const surveyIdNum = parseInt(deactivateBtn.dataset.id);
                const surveyToDeactivate = surveys.find(s => s.id === surveyIdNum);
                if (surveyToDeactivate && surveyToDeactivate.status === 'Active') {
                    surveyToDeactivate.status = 'Inactive';
                    renderSurveysGrid();
                    updateStats();
                    showToast(`"${surveyName}" has been deactivated`);
                } else if (surveyToDeactivate && surveyToDeactivate.status === 'Inactive') {
                    surveyToDeactivate.status = 'Active';
                    renderSurveysGrid();
                    updateStats();
                    showToast(`"${surveyName}" has been activated`);
                }
                menu.remove();
                currentActionMenu = null;
            });
        }
        
        const deleteBtn = menu.querySelector('[data-action="delete"]');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', () => {
                deleteSurveyId = parseInt(deleteBtn.dataset.id);
                const surveyName = deleteBtn.dataset.name;
                const responseCount = deleteBtn.dataset.responses;
                document.getElementById('deleteSurveyMessage').innerHTML = `This action will permanently delete "${surveyName}" and all ${responseCount} associated responses. This cannot be undone.`;
                document.getElementById('deleteSurveyModal').classList.remove('hidden');
                menu.remove();
                currentActionMenu = null;
            });
        }
    }

    let currentResponseActionMenu = null;

    function renderRecentResponses() {
        const container = document.getElementById('recentResponsesList');
        container.innerHTML = recentResponses.map(r => `
            <div class="response-card rounded-lg border border-gray-200 bg-background shadow-sm hover:shadow-md transition-all duration-200">
                <div class="p-4 pb-2">
                    <div class="flex justify-between gap-3 flex-wrap items-start">
                        <div>
                            <h2 class="text-base font-semibold tracking-tight">Response to <span class="font-medium text-indigo-600">${escapeHtml(r.survey)}</span></h2>
                            <div class="flex items-center gap-2 mt-1 flex-wrap">
                                <span class="text-xs text-gray-500">${r.date} at ${r.time}</span>
                                <span class="inline-flex px-2 py-0.5 rounded-full border text-xs">${escapeHtml(r.department)}</span>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <div class="flex">${[1,2,3,4,5].map(s => `<span class="text-lg ${s <= r.satisfaction ? 'text-yellow-500' : 'text-gray-300'}">★</span>`).join('')}</div>
                        </div>
                    </div>
                </div>
                <div class="px-4 pb-3">
                    <div class="text-xs text-gray-400 mb-1">Anonymous Patient</div>
                    <p class="text-sm text-gray-600">"${escapeHtml(r.comment)}"</p>
                </div>
                <div class="p-4 pt-0 flex justify-end">
                    <button class="response-action-btn hover:bg-gray-100 h-8 px-3 rounded-md text-xs flex items-center gap-1 transition-colors" data-id="${r.id}" data-survey="${escapeHtml(r.survey)}" data-date="${r.date}" data-time="${r.time}" data-department="${escapeHtml(r.department)}" data-satisfaction="${r.satisfaction}" data-comment="${escapeHtml(r.comment)}">
                        <svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                        Actions
                    </button>
                </div>
            </div>
        `).join('');
        
        document.querySelectorAll('.response-action-btn').forEach(btn => {
            btn.removeEventListener('click', handleResponseActionClick);
            btn.addEventListener('click', handleResponseActionClick);
        });
    }

    function handleResponseActionClick(e) {
        e.stopPropagation();
        const btn = e.currentTarget;
        const responseId = parseInt(btn.dataset.id);
        const response = recentResponses.find(r => r.id === responseId);
        
        if (currentResponseActionMenu) currentResponseActionMenu.remove();
        
        const rect = btn.getBoundingClientRect();
        const menu = document.createElement('div');
        menu.className = 'action-menu';
        menu.style.top = `${rect.bottom + 4}px`;
        menu.style.right = `${window.innerWidth - rect.right}px`;
        menu.innerHTML = `
            <div class="action-menu-header">Actions</div>
            <button data-action="view" data-id="${responseId}" data-survey="${escapeHtml(response.survey)}" data-date="${response.date}" data-time="${response.time}" data-department="${escapeHtml(response.department)}" data-satisfaction="${response.satisfaction}" data-comment="${escapeHtml(response.comment)}" class="action-item">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>
                View Details
            </button>
            <div class="action-divider"></div>
            <button data-action="delete" data-id="${responseId}" data-survey="${escapeHtml(response.survey)}" class="action-item text-red-600">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>
                Delete Response
            </button>
        `;
        document.body.appendChild(menu);
        currentResponseActionMenu = menu;
        
        const closeMenu = (e) => {
            if (!menu.contains(e.target) && e.target !== btn) {
                menu.remove();
                currentResponseActionMenu = null;
                document.removeEventListener('click', closeMenu);
            }
        };
        setTimeout(() => document.addEventListener('click', closeMenu), 0);
        
        const viewBtn = menu.querySelector('[data-action="view"]');
        if (viewBtn) {
            viewBtn.addEventListener('click', () => {
                const surveyName = viewBtn.dataset.survey;
                const date = viewBtn.dataset.date;
                const time = viewBtn.dataset.time;
                const department = viewBtn.dataset.department;
                const satisfaction = parseInt(viewBtn.dataset.satisfaction);
                const comment = viewBtn.dataset.comment;
                showResponseDetailsModal(surveyName, date, time, department, satisfaction, comment);
                menu.remove();
                currentResponseActionMenu = null;
            });
        }
        
        const deleteBtn = menu.querySelector('[data-action="delete"]');
        if (deleteBtn) {
            deleteBtn.addEventListener('click', () => {
                const responseIdToDelete = parseInt(deleteBtn.dataset.id);
                const surveyName = deleteBtn.dataset.survey;
                showDeleteResponseModal(responseIdToDelete, surveyName);
                menu.remove();
                currentResponseActionMenu = null;
            });
        }
    }

    function showResponseDetailsModal(surveyName, date, time, department, satisfaction, comment) {
        const modal = document.createElement('div');
        modal.className = 'modal-backdrop';
        modal.innerHTML = `
            <div class="modal-content" style="max-width: 550px;">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-xl font-semibold">Response Details</h2>
                        <button class="close-modal-btn text-gray-400 hover:text-gray-600">✕</button>
                    </div>
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div><label class="text-xs text-gray-500">Survey</label><p class="font-medium text-sm mt-0.5">${escapeHtml(surveyName)}</p></div>
                            <div><label class="text-xs text-gray-500">Date & Time</label><p class="font-medium text-sm mt-0.5">${date} at ${time}</p></div>
                            <div><label class="text-xs text-gray-500">Department</label><p class="font-medium text-sm mt-0.5">${escapeHtml(department)}</p></div>
                            <div><label class="text-xs text-gray-500">Satisfaction Rating</label><div class="flex items-center gap-0.5 mt-1">${[1,2,3,4,5].map(s => `<span class="text-xl ${s <= satisfaction ? 'text-yellow-500' : 'text-gray-300'}">★</span>`).join('')}</div></div>
                        </div>
                        <div><label class="text-xs text-gray-500">Comment</label><p class="text-sm mt-1 bg-gray-50 p-3 rounded-lg">"${escapeHtml(comment)}"</p></div>
                    </div>
                    <div class="flex justify-end mt-6">
                        <button class="close-modal-btn px-4 py-2 rounded-md border border-gray-300 text-sm font-medium hover:bg-gray-100 transition">Close</button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        
        const closeModal = () => modal.remove();
        modal.querySelectorAll('.close-modal-btn').forEach(btn => btn.addEventListener('click', closeModal));
        modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
    }

    let deleteResponseId = null;
    function showDeleteResponseModal(responseId, surveyName) {
        deleteResponseId = responseId;
        
        const modal = document.createElement('div');
        modal.className = 'modal-backdrop';
        modal.innerHTML = `
            <div class="modal-content" style="max-width: 450px;">
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                            <svg class="h-5 w-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                        </div>
                        <h2 class="text-lg font-semibold">Delete Response?</h2>
                    </div>
                    <p class="text-sm text-gray-600 mb-6">This action will permanently delete this response from "${escapeHtml(surveyName)}". This cannot be undone.</p>
                    <div class="flex justify-end gap-3">
                        <button class="cancel-delete-btn px-4 py-2 rounded-md border border-gray-300 text-sm font-medium hover:bg-gray-100 transition">Cancel</button>
                        <button class="confirm-delete-btn px-4 py-2 rounded-md bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition">Delete Response</button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        
        const closeModal = () => modal.remove();
        modal.querySelector('.cancel-delete-btn')?.addEventListener('click', closeModal);
        modal.querySelector('.confirm-delete-btn')?.addEventListener('click', () => {
            const index = recentResponses.findIndex(r => r.id === deleteResponseId);
            if (index !== -1) {
                recentResponses.splice(index, 1);
                renderRecentResponses();
                showToast('Response deleted successfully');
            }
            closeModal();
            deleteResponseId = null;
        });
        modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
    }

    function initCharts() {
        const satisfactionOptions = {
            series: [{ name: "Satisfaction Score (avg)", type: "line", data: [3.8, 4.0, 4.2, 4.1, 4.3, 4.2, 4.4, 4.1, 4.2, 4.3, 4.5, 4.4] }, { name: "Response Volume", type: "column", data: [85, 92, 110, 125, 140, 155, 170, 160, 148, 135, 142, 128] }],
            chart: { type: "line", height: 350, toolbar: { show: false }, background: "transparent" },
            stroke: { width: [3, 0], curve: "smooth" },
            colors: ["#4f46e5", "#10b981"],
            xaxis: { categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"] },
            yaxis: [{ title: { text: "Satisfaction (1-5)" }, min: 0, max: 5 }, { opposite: true, title: { text: "Responses" } }],
            tooltip: { shared: true, intersect: false },
            legend: { position: "top" }
        };
        new ApexCharts(document.querySelector("#satisfactionTrendChart"), satisfactionOptions).render();
        
        const deptOptions = {
            series: [342, 187, 234, 128, 96],
            chart: { type: 'donut', height: 320, background: 'transparent' },
            labels: ['Outpatient', 'Telemedicine', 'Maternity', 'Pharmacy', 'Post-Surgery'],
            colors: ['#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
            legend: { position: 'bottom' },
            dataLabels: { enabled: true, formatter: (val) => val.toFixed(0) + '%' }
        };
        new ApexCharts(document.querySelector("#departmentChart"), deptOptions).render();
        
        const surveyOptions = {
            series: [{ name: "Responses", data: [342, 187, 234, 128, 96, 54] }],
            chart: { type: 'bar', height: 320, toolbar: { show: false }, background: 'transparent' },
            plotOptions: { bar: { borderRadius: 8, horizontal: false, columnWidth: '60%' } },
            xaxis: { categories: ['Patient Satisfaction', 'Outpatient', 'Maternity', 'Pharmacy', 'Telemedicine', 'Post-Surgery'] },
            colors: ['#4f46e5']
        };
        new ApexCharts(document.querySelector("#surveyResponsesChart"), surveyOptions).render();
        
        const ratingOptions = {
            series: [{ name: "Responses", data: [412, 356, 189, 98, 56] }],
            chart: { type: 'bar', height: 320, toolbar: { show: false }, background: 'transparent' },
            plotOptions: { bar: { borderRadius: 8, horizontal: false, columnWidth: '50%' } },
            xaxis: { categories: ['5 Stars', '4 Stars', '3 Stars', '2 Stars', '1 Star'] },
            colors: ['#f59e0b'],
            dataLabels: { enabled: true, formatter: (val) => val.toString() }
        };
        new ApexCharts(document.querySelector("#ratingDistributionChart"), ratingOptions).render();
    }

    // Performance Rankings Data
    const facilityRankings = [
        { rank: 1, name: "Arua", score: 4.8, responses: 342, recommend: 94, waitTime: 28, trend: "up" },
        { rank: 2, name: "Jinja", score: 4.6, responses: 298, recommend: 91, waitTime: 32, trend: "up" },
        { rank: 3, name: "Ntinda", score: 4.4, responses: 267, recommend: 89, waitTime: 35, trend: "steady" },
        { rank: 4, name: "Mukono", score: 4.2, responses: 312, recommend: 85, waitTime: 42, trend: "down" },
        { rank: 5, name: "Wakiso", score: 4.0, responses: 156, recommend: 82, waitTime: 38, trend: "up" },
        { rank: 6, name: "Gulu", score: 3.8, responses: 189, recommend: 78, waitTime: 45, trend: "steady" }
    ];

    const departmentRankings = [
        { rank: 1, department: "Immunization", score: 4.9, responses: 234, staffFriendly: 98, cleanliness: 96, waitTime: 15 },
        { rank: 2, department: "Maternity", score: 4.7, responses: 312, staffFriendly: 95, cleanliness: 92, waitTime: 22 },
        { rank: 3, department: "Cardiology", score: 4.6, responses: 289, staffFriendly: 94, cleanliness: 91, waitTime: 25 },
        { rank: 4, department: "Pediatrics", score: 4.5, responses: 178, staffFriendly: 96, cleanliness: 88, waitTime: 20 },
        { rank: 5, department: "Outpatient", score: 4.2, responses: 567, staffFriendly: 88, cleanliness: 85, waitTime: 48 },
        { rank: 6, department: "Pharmacy", score: 3.5, responses: 234, staffFriendly: 72, cleanliness: 78, waitTime: 35 },
        { rank: 7, department: "Dentistry", score: 3.2, responses: 89, staffFriendly: 68, cleanliness: 82, waitTime: 40 }
    ];

    const topCompliments = [
        "The nurses are very caring and professional",
        "The facility is clean and well organized",
        "Staff respects patient privacy",
        "The midwife was very supportive during delivery",
        "Short waiting time compared to other facilities"
    ];

    const commonComplaints = [
        "Medicines frequently out of stock - patients forced to buy from private pharmacies",
        "Long waiting times (60-120+ minutes) before being attended to",
        "Doctor/Dentist not available - patients told to come back another day",
        "Staff rude or unprofessional behavior towards patients",
        "Referred to other facilities (Mulago) due to limited capacity",
        "Lab results delayed - long waits for test results",
        "Small/congested wards - insufficient space for admitted patients",
        "Family planning services unavailable (implants out of stock)",
        "Staff take long breaks, arrive late, work slowly",
        "Poor communication about diagnosis and treatment"
    ];

    function renderPerformanceRankings() {
        console.log('Rendering Performance Rankings...');
        
        const facilityBody = document.getElementById('facilityRankingsBody');
        if (facilityBody) {
            facilityBody.innerHTML = facilityRankings.map(f => `
                <tr class="border-b hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 font-semibold">${f.rank === 1 ? '🥇 ' : f.rank === 2 ? '🥈 ' : f.rank === 3 ? '🥉 ' : `${f.rank}`}</td>
                    <td class="px-4 py-3 font-medium">${escapeHtml(f.name)}</td>
                    <td class="px-4 py-3"><div class="flex items-center gap-1"><span class="font-bold text-lg">${f.score}</span><span class="text-yellow-500">★</span></div></td>
                    <td class="px-4 py-3">${f.responses}</td>
                    <td class="px-4 py-3"><div class="flex items-center gap-2"><div class="w-16 bg-gray-200 rounded-full h-2"><div class="bg-green-500 h-2 rounded-full" style="width: ${f.recommend}%"></div></div><span class="text-sm">${f.recommend}%</span></div></td>
                    <td class="px-4 py-3">${f.waitTime} min</td>
                    <td class="px-4 py-3"><span class="${f.trend === 'up' ? 'text-green-600' : f.trend === 'down' ? 'text-red-600' : 'text-gray-500'}">${f.trend === 'up' ? '↑ ' + Math.floor(Math.random() * 10 + 1) + '%' : f.trend === 'down' ? '↓ ' + Math.floor(Math.random() * 10 + 1) + '%' : '→ 0%'}</span></td>
                </tr>
            `).join('');
        }

        const deptBody = document.getElementById('departmentRankingsBody');
        if (deptBody) {
            deptBody.innerHTML = departmentRankings.map(d => `
                <tr class="border-b hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 font-semibold">${d.rank === 1 ? '🥇 ' : d.rank === 2 ? '🥈 ' : d.rank === 3 ? '🥉 ' : `${d.rank}`}</td>
                    <td class="px-4 py-3 font-medium">${escapeHtml(d.department)}</td>
                    <td class="px-4 py-3"><div class="flex items-center gap-1"><span class="font-bold text-lg">${d.score}</span><span class="text-yellow-500">★</span></div></td>
                    <td class="px-4 py-3">${d.responses}</td>
                    <td class="px-4 py-3"><div class="flex items-center gap-2"><div class="w-16 bg-gray-200 rounded-full h-2"><div class="bg-green-500 h-2 rounded-full" style="width: ${d.staffFriendly}%"></div></div><span class="text-sm">${d.staffFriendly}%</span></div></td>
                    <td class="px-4 py-3"><div class="flex items-center gap-2"><div class="w-16 bg-gray-200 rounded-full h-2"><div class="bg-blue-500 h-2 rounded-full" style="width: ${d.cleanliness}%"></div></div><span class="text-sm">${d.cleanliness}%</span></div></td>
                    <td class="px-4 py-3">${d.waitTime} min</td>
                </tr>
            `).join('');
        }

        const complimentsContainer = document.getElementById('topComplimentsList');
        if (complimentsContainer) {
            complimentsContainer.innerHTML = topCompliments.map((c, i) => `
                <div class="flex items-start gap-3 p-3 bg-green-50 rounded-lg border border-green-200">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xs font-bold">${i + 1}</div>
                    <p class="text-sm text-green-800">"${escapeHtml(c)}"</p>
                </div>
            `).join('');
        }

        const complaintsContainer = document.getElementById('commonComplaintsList');
        if (complaintsContainer) {
            complaintsContainer.innerHTML = commonComplaints.map((c, i) => `
                <div class="flex items-start gap-3 p-3 bg-red-50 rounded-lg border border-red-200">
                    <div class="flex-shrink-0 w-6 h-6 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xs font-bold">${i + 1}</div>
                    <p class="text-sm text-red-800">"${escapeHtml(c)}"</p>
                </div>
            `).join('');
        }
        
        console.log('Performance Rankings rendered successfully');
    }

    // Tab switching
    function initTabs() {
        const tabs = document.querySelectorAll('.tab-trigger');
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active', 'bg-white', 'text-gray-900', 'shadow-sm'));
                tab.classList.add('active', 'bg-white', 'text-gray-900', 'shadow-sm');
                
                const tabName = tab.dataset.tab;
                document.getElementById('surveysTab').classList.toggle('hidden', tabName !== 'surveys');
                document.getElementById('responsesTab').classList.toggle('hidden', tabName !== 'responses');
                document.getElementById('analyticsTab').classList.toggle('hidden', tabName !== 'analytics');
                document.getElementById('performanceTab').classList.toggle('hidden', tabName !== 'performance');
                
                if (tabName === 'analytics') {
                    setTimeout(() => initCharts(), 100);
                }
                if (tabName === 'performance') {
                    renderPerformanceRankings();
                }
            });
        });
    }

    // Event listeners
    document.getElementById('surveySearch')?.addEventListener('input', () => renderSurveysGrid());
    document.getElementById('clearFiltersBtn')?.addEventListener('click', () => {
        document.getElementById('surveySearch').value = '';
        document.getElementById('statusFilterText').innerText = 'All Status';
        renderSurveysGrid();
        showToast('Filters cleared');
    });
    
    function setupStatusDropdown() {
        const trigger = document.getElementById('statusFilterBtn');
        const dropdown = document.getElementById('statusFilterDropdown');
        const span = document.getElementById('statusFilterText');
        trigger.addEventListener('click', (e) => { e.stopPropagation(); dropdown.classList.toggle('hidden'); });
        dropdown.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', () => { span.innerText = item.dataset.status === 'All' ? 'All Status' : item.dataset.status; dropdown.classList.add('hidden'); renderSurveysGrid(); });
        });
    }
    setupStatusDropdown();

    // Add Export All handler
    document.getElementById('exportAllBtn')?.addEventListener('click', () => {
        const exportData = { surveys: surveys, responses: recentResponses, facilityRankings: facilityRankings, departmentRankings: departmentRankings, exportedAt: new Date().toISOString() };
        const dataStr = JSON.stringify(exportData, null, 2);
        const blob = new Blob([dataStr], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `meditrack-export-${new Date().toISOString().split('T')[0]}.json`;
        a.click();
        URL.revokeObjectURL(url);
        showToast('All data exported successfully');
    });
    
    // Delete modal handlers
    document.getElementById('cancelDeleteBtn')?.addEventListener('click', () => document.getElementById('deleteSurveyModal').classList.add('hidden'));
    document.getElementById('confirmDeleteBtn')?.addEventListener('click', () => {
        if (deleteSurveyId) {
            surveys = surveys.filter(s => s.id !== deleteSurveyId);
            renderSurveysGrid();
            updateStats();
            showToast('Survey deleted successfully');
        }
        document.getElementById('deleteSurveyModal').classList.add('hidden');
    });
    document.getElementById('deleteSurveyModal')?.addEventListener('click', (e) => { if (e.target === document.getElementById('deleteSurveyModal')) document.getElementById('deleteSurveyModal').classList.add('hidden'); });
    
    document.addEventListener('click', () => document.querySelectorAll('.dropdown-content').forEach(d => d.classList.add('hidden')));
    
    // Initialize
    renderSurveysGrid();
    renderRecentResponses();
    updateStats();
    initTabs();
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
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Audit Logs</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    
    <style>
        * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        [data-radix-select-trigger] {
            display: flex;
            height: 2.5rem;
            width: 100%;
            align-items: center;
            justify-content: space-between;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
            background-color: #ffffff;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.15s;
        }
        body.dark [data-radix-select-trigger] { 
            background-color: #262626; 
            border-color: #404040; 
            color: #e5e5e5; 
        }
        [data-radix-select-trigger]:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }

        [data-radix-select-content] {
            position: absolute;
            z-index: 50;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            margin-top: 4px;
            min-width: 100%;
            max-height: 240px;
            overflow-y: auto;
            animation: radixSlideIn 0.15s ease-out;
        }
        body.dark [data-radix-select-content] { 
            background: #1e1e1e; 
            border-color: #333; 
        }

        [data-radix-select-item] {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background 0.1s;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 0.25rem;
            margin: 2px;
        }
        [data-radix-select-item]:hover { background-color: #f3f4f6; }
        body.dark [data-radix-select-item]:hover { background-color: #262626; }
        [data-radix-select-item][data-highlighted] { 
            background-color: #eef2ff; 
            color: #4338ca; 
        }
        body.dark [data-radix-select-item][data-highlighted] { 
            background-color: #1e1b4b; 
            color: #818cf8; 
        }
        [data-radix-select-item][data-state="checked"] { 
            background-color: #eef2ff; 
            color: #4338ca;
            font-weight: 500;
        }

        @keyframes radixSlideIn { 
            from { opacity: 0; transform: translateY(-4px); } 
            to { opacity: 1; transform: translateY(0); } 
        }

        .dropdown-content {
            position: absolute;
            z-index: 50;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            margin-top: 4px;
            min-width: 180px;
            max-height: 240px;
            overflow-y: auto;
            animation: radixSlideIn 0.15s ease-out;
        }
        body.dark .dropdown-content { background: #2a2a2a; border-color: #404040; }
        .dropdown-item { padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer; transition: background 0.1s; }
        .dropdown-item:hover { background-color: #f3f4f6; }
        body.dark .dropdown-item:hover { background-color: #3f3f46; }

        /* Event type badges */
        .event-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            border-radius: 9999px;
            padding: 0.125rem 0.625rem;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            white-space: nowrap;
        }
        .event-created { background-color: #dbeafe; color: #1e40af; }
        .event-edited { background-color: #e0e7ff; color: #3730a3; }
        .event-submitted { background-color: #ede9fe; color: #5b21b6; }
        .event-approved { background-color: #d1fae5; color: #065f46; }
        .event-rejected { background-color: #fee2e2; color: #991b1b; }
        .event-dispatched { background-color: #dbeafe; color: #1e3a5f; }
        .event-received { background-color: #ccfbf1; color: #134e4a; }
        .event-cancelled { background-color: #ffedd5; color: #9a3412; }
        .event-deleted { background-color: #fee2e2; color: #7f1d1d; }
        .event-printed { background-color: #f3f4f6; color: #374151; }
        .event-exported { background-color: #f3f4f6; color: #374151; }
        .event-viewed { background-color: #f3f4f6; color: #6b7280; }
        .event-system { background-color: #f3f4f6; color: #6b7280; }
        .event-received-damaged { background-color: #fef2f2; color: #991b1b; }
        .event-reversed { background-color: #fef3c7; color: #92400e; }
        .event-restored { background-color: #d1fae5; color: #065f46; }
        .event-flagged { background-color: #fee2e2; color: #991b1b; }
        .event-login { background-color: #f0fdf4; color: #166534; }
        .event-logout { background-color: #f3f4f6; color: #374151; }
        .event-failed-login { background-color: #fee2e2; color: #7f1d1d; }
        .event-permission-change { background-color: #fef3c7; color: #92400e; }
        body.dark .event-created { background-color: #1e3a5f; color: #93c5fd; }
        body.dark .event-edited { background-color: #1e1b4b; color: #a5b4fc; }
        body.dark .event-submitted { background-color: #2e1065; color: #c4b5fd; }
        body.dark .event-approved { background-color: #064e3b; color: #6ee7b7; }
        body.dark .event-rejected { background-color: #7f1d1d; color: #fca5a5; }
        body.dark .event-dispatched { background-color: #1e3a5f; color: #93c5fd; }
        body.dark .event-received { background-color: #134e4a; color: #5eead4; }
        body.dark .event-cancelled { background-color: #431407; color: #fdba74; }
        body.dark .event-deleted { background-color: #450a0a; color: #fca5a5; }
        body.dark .event-reversed { background-color: #78350f; color: #fcd34d; }
        body.dark .event-restored { background-color: #064e3b; color: #6ee7b7; }
        body.dark .event-flagged { background-color: #7f1d1d; color: #fca5a5; }
        body.dark .event-login { background-color: #052e16; color: #86efac; }
        body.dark .event-failed-login { background-color: #450a0a; color: #fca5a5; }
        body.dark .event-permission-change { background-color: #78350f; color: #fcd34d; }

        .severity-info { background-color: #dbeafe; color: #1e40af; }
        .severity-warning { background-color: #fef3c7; color: #92400e; }
        .severity-critical { background-color: #fee2e2; color: #991b1b; }
        body.dark .severity-info { background-color: #1e3a5f; color: #93c5fd; }
        body.dark .severity-warning { background-color: #78350f; color: #fcd34d; }
        body.dark .severity-critical { background-color: #7f1d1d; color: #fca5a5; }

        .diff-before { background-color: #fee2e2; color: #991b1b; padding: 1px 4px; border-radius: 3px; text-decoration: line-through; }
        .diff-after { background-color: #d1fae5; color: #065f46; padding: 1px 4px; border-radius: 3px; }
        body.dark .diff-before { background-color: #450a0a; color: #fca5a5; }
        body.dark .diff-after { background-color: #064e3b; color: #6ee7b7; }

        .row-flagged { background-color: #fef2f2 !important; }
        body.dark .row-flagged { background-color: #1a0a0a !important; }

        @keyframes pulse-warning {
            0%, 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            50% { box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
        }

/* Severity Tabs */
/* Improved Tabs - Maintaining your original colors */
.tab-button {
    transition: all 0.15s ease;
}

.tab-button:hover {
    background-color: #f3f4f6;
}

.tab-button.active,
.tab-button[aria-selected="true"] {
    background: white;
    color: #1f2937;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}

body.dark .tab-button {
    color: #e5e5e5;
}

body.dark .tab-button:hover {
    background-color: #374151;
}

body.dark .tab-button.active,
body.dark .tab-button[aria-selected="true"] {
    background: #131212;
    color: #e5e5e5;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3);
}

        @media print {
            header, aside, .no-print { display: none !important; }
            main { margin-left: 0 !important; padding: 0 !important; }
            body { background: white !important; }
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
        <div class="flex flex-col gap-5 max-w-full mx-auto">
            <!-- Header -->
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between no-print">
                <div class="flex items-center gap-3">
                    <a href="transfers.html" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white hover:bg-gray-50 size-10 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left h-4 w-4 text-gray-600"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                    </a>
                    <div>
                        <h2 class="text-2xl lg:text-3xl font-bold tracking-tight ">Audit Logs</h2>
                        <p class="text-sm text-gray-500">Immutable activity trail • Reversal tracking • Theft prevention • Compliance ready</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button id="printAuditBtn" class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"></path><rect x="6" y="14" width="12" height="8" rx="1"></rect></svg>
                        Print
                    </button>
                    <button id="exportAuditBtn" class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download h-4 w-4"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg>
                        Export CSV
                    </button>
                </div>
            </div>

            <!-- Use Case Banners -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4 no-print">
                <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                    <div class="flex items-center gap-2 mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-refresh-cw h-5 w-5 text-blue-600"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        <p class="text-sm font-semibold text-blue-800">Reversal Tracking</p>
                    </div>
                    <p class="text-xs text-blue-600">Trace every action. Before/after diffs. Restore previous states.</p>
                </div>
                <div class="rounded-lg border border-red-200 bg-red-50 p-4">
                    <div class="flex items-center gap-2 mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield h-5 w-5 text-red-600"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg>
                        <p class="text-sm font-semibold text-red-800">Theft Prevention</p>
                    </div>
                    <p class="text-xs text-red-600">Full chain of custody. IP logging. Gap detection. Immutable records.</p>
                </div>
                <div class="rounded-lg border border-green-200 bg-green-50 p-4">
                    <div class="flex items-center gap-2 mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-check h-5 w-5 text-green-600"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="m9 15 2 2 4-4"></path></svg>
                        <p class="text-sm font-semibold text-green-800">Audit Ready</p>
                    </div>
                    <p class="text-xs text-green-600">ISO 13485 compliant. Exportable. Filterable. 365-day retention.</p>
                </div>
                <div class="rounded-lg border border-amber-200 bg-amber-50 p-4">
                    <div class="flex items-center gap-2 mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-check h-5 w-5 text-amber-600"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><polyline points="16 11 18 13 22 9"></polyline></svg>
                        <p class="text-sm font-semibold text-amber-800">Accountability</p>
                    </div>
                    <p class="text-xs text-amber-600">Named actions. Role tracking. Precise timestamps. Permanent record.</p>
                </div>
            </div>

            <!-- Stats Row -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg border border-gray-200 bg-background p-4 shadow-sm">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-500">Total Events</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text h-5 w-5 text-gray-400"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path></svg>
                    </div>
                    <div class="text-3xl font-bold mt-2 " id="totalEventsCount">156</div>
                    <p class="text-xs text-gray-500">Last 30 days</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-background p-4 shadow-sm">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-500">Today's Events</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar h-5 w-5 text-blue-500"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>
                    </div>
                    <div class="text-3xl font-bold mt-2 text-blue-600" id="todayEventsCount">12</div>
                    <p class="text-xs text-gray-500" id="todayDate">April 22, 2023</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-background p-4 shadow-sm">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-500">Anomalies Flagged</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-alert-triangle h-5 w-5 text-red-500 anomaly-indicator rounded-full"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"></path><path d="M12 9v4"></path><path d="M12 17h.01"></path></svg>
                    </div>
                    <div class="text-3xl font-bold mt-2 text-red-600" id="anomaliesCount">5</div>
                    <p class="text-xs text-gray-500">Requires investigation</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-background p-4 shadow-sm">
                    <div class="flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-500">Reversals Performed</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-undo-2 h-5 w-5 text-amber-500"><path d="M9 14 4 9l5-5"></path><path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5v0a5.5 5.5 0 0 1-5.5 5.5H11"></path></svg>
                    
                    </div>
                    <div class="text-3xl font-bold mt-2 text-amber-600" id="reversalsCount">2</div>
                    <p class="text-xs text-gray-500">Actions reversed/restored</p>
                </div>
            </div>

<!-- Filters & Search Row (Single Row) -->
<div class="flex flex-col sm:flex-row sm:items-center pb-4 justify-between gap-4 no-print">
    <!-- Severity Tabs -->
    <div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1 shrink-0">
        <button role="tab" data-tab="all" class="severity-tab tab-button px-4 py-1.5 text-sm font-medium rounded-sm transition-all bg-white shadow-sm" aria-selected="true">
            All Events
        </button>
        <button role="tab" data-tab="info" class="severity-tab tab-button px-4 py-1.5 text-sm font-medium rounded-sm transition-all" aria-selected="false">
            Info
        </button>
        <button role="tab" data-tab="warning" class="severity-tab tab-button px-4 py-1.5 text-sm font-medium rounded-sm transition-all" aria-selected="false">
            Warning
        </button>
        <button role="tab" data-tab="critical" class="severity-tab tab-button px-4 py-1.5 text-sm font-medium rounded-sm transition-all" aria-selected="false">
            Critical
        </button>
    </div>

    <!-- Search + Filters -->
    <div class="flex gap-3 flex-wrap sm:flex-nowrap items-center w-full sm:w-auto">
        <!-- Search -->
        <div class="relative flex-1 sm:flex-none sm:w-[220px]">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search absolute left-2.5 top-2.5 h-4 w-4 text-gray-400">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.3-4.3"></path>
            </svg>
            <input id="searchInput" type="text" placeholder="Search user or IP..." 
                   class="h-10 w-full rounded-md border border-gray-300 bg-white pl-8 pr-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <!-- Date Range -->
        <div class="relative">
            <button type="button" id="dateRangeBtn" 
                    class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white h-10 px-4 text-sm whitespace-nowrap hover:bg-gray-50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar h-4 w-4">
                    <path d="M8 2v4"></path><path d="M16 2v4"></path>
                    <rect width="18" height="18" x="3" y="4" rx="2"></rect>
                    <path d="M3 10h18"></path>
                </svg>
                <span id="dateRangeText">Mar 22, 2023 - Apr 22, 2023</span>
            </button>
            <!-- Date popover remains the same -->
<div id="datePickerPopover" class="hidden absolute z-50 mt-2 w-[260px] rounded-md border border-gray-200 bg-white shadow-lg overflow-hidden right-0">
    <div class="p-4 space-y-4">
        <div>
            <label class="text-sm font-medium text-gray-700 block mb-1">Start Date</label>
            <input type="date" id="startDate" class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" value="2023-03-22">
        </div>
        <div>
            <label class="text-sm font-medium text-gray-700 block mb-1">End Date</label>
            <input type="date" id="endDate" class="w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" value="2023-04-22">
        </div>
        <div class="flex gap-2 pt-2">
            <button id="applyDateBtn" class="flex-1 rounded-md bg-indigo-600 text-white py-2 text-sm font-medium hover:bg-indigo-700 transition-colors">Apply</button>
            <button id="cancelDateBtn" class="flex-1 rounded-md border border-gray-300 bg-white py-2 text-sm font-medium hover:bg-gray-50 transition-colors">Cancel</button>
        </div>
    </div>
</div>
        </div>

        <!-- Event Type Dropdown -->
        <div class="relative">
            <button id="eventTypeFilterBtn" 
                    class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm hover:bg-gray-50 transition-colors h-10 whitespace-nowrap">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-filter h-4 w-4">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                </svg>
                <span id="eventTypeFilterLabel">All Events</span>
            </button>
            <!-- Your existing dropdown content -->
<div id="eventTypeFilterDropdown" class="hidden dropdown-content w-48">
    <div data-filter="all" class="dropdown-item font-medium">All Events</div>
    <div class="border-t my-1"></div>
    <div data-filter="Created" class="dropdown-item">Created</div>
    <div data-filter="Edited" class="dropdown-item">Edited</div>
    <div data-filter="Submitted" class="dropdown-item">Submitted</div>
    <div data-filter="Approved" class="dropdown-item">Approved</div>
    <div data-filter="Rejected" class="dropdown-item">Rejected</div>
    <div data-filter="Dispatched" class="dropdown-item">Dispatched</div>
    <div data-filter="Received" class="dropdown-item">Received</div>
    <div data-filter="Cancelled" class="dropdown-item">Cancelled</div>
    <div data-filter="Deleted" class="dropdown-item">Deleted</div>
    <div class="border-t my-1"></div>
    <div data-filter="Reversed" class="dropdown-item">Reversed</div>
    <div data-filter="Restored" class="dropdown-item">Restored</div>
    <div data-filter="Flagged" class="dropdown-item">Flagged</div>
    <div data-filter="Failed Login" class="dropdown-item">Failed Login</div>
    <div data-filter="Permission Change" class="dropdown-item">Permission Change</div>
    <div data-filter="Printed" class="dropdown-item">Printed</div>
    <div data-filter="Login" class="dropdown-item">Login</div>
    <div data-filter="System" class="dropdown-item">System</div>
</div>
        </div>

        <button id="exportBtn" class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-3 py-2 text-sm hover:bg-gray-50 transition-colors h-10 whitespace-nowrap">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download h-4 w-4">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" x2="12" y1="15" y2="3"></line>
            </svg>
            Export
        </button>
    </div>
</div>
            </div>

            <!-- Audit Log Table -->
            <div class="rounded-lg border border-gray-200 bg-background shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Timestamp</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Event Type</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Transfer ID</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP Address</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Severity</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="auditTableBody" class="divide-y divide-gray-200"></tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="flex items-center justify-between px-4 py-3 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center gap-4">
                        <p class="text-sm text-gray-500" id="paginationInfo">Showing 1-10 of 156 events</p>
                        <span class="text-xs text-gray-400">•</span>
                        <p class="text-xs text-gray-400">Logs retained for <strong class="text-gray-500">365 days</strong></p>
                    </div>
                    <div class="flex gap-1">
                        <button id="prevPageBtn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors disabled:opacity-50" disabled>Previous</button>
                        <button class="page-btn inline-flex items-center justify-center rounded-md bg-primary text-white px-3 py-1.5 text-sm font-medium" data-page="1">1</button>
                        <button class="page-btn inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors" data-page="2">2</button>
                        <button class="page-btn inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors" data-page="3">3</button>
                        <button id="nextPageBtn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors">Next</button>
                    </div>
                </div>
            </div>

            <!-- Retention Notice -->
            <div class="rounded-lg border border-gray-200 bg-gray-50 p-3 mb-8">
                <p class="text-xs text-gray-500 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info h-3.5 w-3.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    Audit logs are immutable and retained for <strong class="text-gray-700">365 days</strong>. Logs cannot be modified or deleted by any user.
                </p>
            </div>
        </div>
    </main>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[9999] flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-2xl w-full max-w-2xl max-h-[85vh] overflow-y-auto m-4">
        <div class="flex items-center justify-between p-5 border-b border-gray-200 sticky top-0 bg-white z-10">
            <h3 class="text-lg font-semibold " id="modalTitle">Event Details</h3>
            <button id="closeDetailModal" class="inline-flex items-center justify-center rounded-md hover:bg-gray-100 size-8 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x h-5 w-5 text-gray-500"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
            </button>
        </div>
        <div class="p-5" id="modalContent"></div>
        <div class="flex justify-between items-center p-5 border-t border-gray-200">
            <button id="flagEventBtn" class="inline-flex items-center gap-2 rounded-md border border-red-300 bg-white px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-flag h-4 w-4"><path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path><line x1="4" y1="22" x2="4" y2="15"></line></svg>
                Flag for Investigation
            </button>
            <div class="flex gap-2">
                <button id="reverseEventBtn" class="inline-flex items-center gap-2 rounded-md border border-amber-300 bg-white px-4 py-2 text-sm font-medium text-amber-700 hover:bg-amber-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-undo-2 h-4 w-4"><path d="M9 14 4 9l5-5"></path><path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5v0a5.5 5.5 0 0 1-5.5 5.5H11"></path></svg>
                    Reverse This Action
                </button>
                <button id="closeDetailBtn" class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors">Close</button>
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

<script>
// ==================== DATA ====================
const auditLogs = [
    { id: "AUD-1015", timestamp: "2023-04-22 17:30:00", eventType: "Flagged", transferId: "TRF-055", userName: "System", userRole: "System", department: "—", description: "ANOMALY: Dispatch from unrecognized IP address 203.0.113.45. User typically operates from 192.168.1.x range.", severity: "critical", ipAddress: "203.0.113.45", flagged: true, details: { action: "anomaly_detection", expectedIPRange: "192.168.1.0/24", actualIP: "203.0.113.45", riskLevel: "HIGH", recommendation: "Verify user identity immediately. Consider freezing transfer." } },
    { id: "AUD-1014", timestamp: "2023-04-22 16:30:00", eventType: "Reversed", transferId: "TRF-057", userName: "Dr. Nakato Sarah", userRole: "Administrator", department: "Administration", description: "Rejection of TRF-057 reversed — status restored to 'Pending' for re-evaluation.", severity: "warning", ipAddress: "192.168.1.20", details: { action: "reverse_rejection", originalEventId: "AUD-1005", previousStatus: "Rejected", newStatus: "Pending" } },
    { id: "AUD-1013", timestamp: "2023-04-22 16:15:32", eventType: "Dispatched", transferId: "TRF-055", userName: "Supply Mgr. Ana Ruiz", userRole: "Supply Manager", department: "Central Supply", description: "Transfer TRF-055 dispatched to Central Supply via Internal Courier. Tracking: TRK-2023-0422.", severity: "info", ipAddress: "203.0.113.45", details: { action: "dispatch", transportMethod: "Internal Courier", trackingNumber: "TRK-2023-0422", items: [{ name: "Surgical Gowns", batch: "SG-2023-0418", qty: 20, unit: "pcs" }, { name: "Surgical Masks", batch: "SM-2023-0418", qty: 10, unit: "box" }] } },
    { id: "AUD-1012", timestamp: "2023-04-22 14:30:00", eventType: "Approved", transferId: "TRF-055", userName: "Dr. Nakato Sarah", userRole: "Administrator", department: "Administration", description: "Transfer TRF-055 approved. Full quantity: 30 units.", severity: "info", ipAddress: "192.168.1.20", details: { action: "approve", approvedQty: 30, items: [{ name: "Surgical Gowns", requested: 20, approved: 20 }, { name: "Surgical Masks", requested: 15, approved: 10 }] } },
    { id: "AUD-1011", timestamp: "2023-04-22 10:00:00", eventType: "Failed Login", transferId: "—", userName: "Unknown", userRole: "—", department: "—", description: "Failed login attempt for user 'admin' from IP 198.51.100.22 — 5 consecutive failures. Account locked.", severity: "critical", ipAddress: "198.51.100.22", flagged: true, details: { action: "failed_login", username: "admin", attempts: 5 } },
    { id: "AUD-1010", timestamp: "2023-04-21 10:45:00", eventType: "Edited", transferId: "TRF-059", userName: "Dr. Nakato Sarah", userRole: "Administrator", department: "Administration", description: "Draft TRF-059 edited — changed quantity of Surgical Gloves from 40 to 45 units.", severity: "info", ipAddress: "192.168.1.20", details: { action: "edit", changes: [{ field: "Quantity", before: "40 pcs", after: "45 pcs", item: "Surgical Gloves" }] } },
    { id: "AUD-1009", timestamp: "2023-04-21 09:00:00", eventType: "Permission Change", transferId: "—", userName: "Dr. Nakato Sarah", userRole: "Administrator", department: "Administration", description: "User 'Nurse Mike Chen' granted 'Receive Confirmation' permission.", severity: "warning", ipAddress: "192.168.1.20", details: { action: "permission_grant", targetUser: "Nurse Mike Chen", permission: "receive_confirmation" } },
    { id: "AUD-1008", timestamp: "2023-04-20 15:00:00", eventType: "Printed", transferId: "TRF-056", userName: "Dr. Emily White", userRole: "Doctor", department: "Pediatrics", description: "Transfer TRF-056 printed for records.", severity: "info", ipAddress: "192.168.1.55", details: { action: "print" } },
    { id: "AUD-1007", timestamp: "2023-04-20 09:30:00", eventType: "Rejected", transferId: "TRF-057", userName: "Dr. Nakato Sarah", userRole: "Administrator", department: "Administration", description: "Transfer TRF-057 rejected — Reason: Insufficient Stock.", severity: "warning", ipAddress: "192.168.1.20", details: { action: "reject", reason: "Insufficient Stock" } },
    { id: "AUD-1006", timestamp: "2023-04-19 16:00:00", eventType: "Deleted", transferId: "TRF-058", userName: "Dr. Emily White", userRole: "Doctor", department: "Pediatrics", description: "Cancelled transfer TRF-058 permanently deleted.", severity: "warning", ipAddress: "192.168.1.55", details: { action: "delete", previousStatus: "Cancelled" } },
    { id: "AUD-1005", timestamp: "2023-04-19 11:00:00", eventType: "Cancelled", transferId: "TRF-058", userName: "Dr. Emily White", userRole: "Doctor", department: "Pediatrics", description: "Transfer TRF-058 cancelled — Reason: No longer needed.", severity: "warning", ipAddress: "192.168.1.55", details: { action: "cancel", reason: "No longer needed" } },
    { id: "AUD-1004", timestamp: "2023-04-18 16:00:00", eventType: "Restored", transferId: "TRF-060", userName: "Dr. Nakato Sarah", userRole: "Administrator", department: "Administration", description: "Previously deleted transfer TRF-060 restored from backup.", severity: "warning", ipAddress: "192.168.1.20", details: { action: "restore" } },
    { id: "AUD-1003", timestamp: "2023-04-18 14:20:00", eventType: "Submitted", transferId: "TRF-055", userName: "Dr. Mike Brown", userRole: "Doctor", department: "Surgery", description: "Transfer TRF-055 submitted for approval.", severity: "info", ipAddress: "192.168.1.30", details: { action: "submit", items: [{ name: "Surgical Gowns", qty: 20 }, { name: "Surgical Masks", qty: 15 }] } },
    { id: "AUD-1002", timestamp: "2023-04-18 09:15:00", eventType: "Created", transferId: "TRF-055", userName: "Dr. Mike Brown", userRole: "Doctor", department: "Surgery", description: "Transfer TRF-055 created as draft.", severity: "info", ipAddress: "192.168.1.30", details: { action: "create", sourceLocation: "Surgery Department", destLocation: "Central Supply" } },
    { id: "AUD-1001", timestamp: "2023-04-18 08:00:00", eventType: "Login", transferId: "—", userName: "Dr. Nakato Sarah", userRole: "Administrator", department: "Administration", description: "User logged in successfully.", severity: "info", ipAddress: "192.168.1.20", details: { action: "login" } }
];

let currentPage = 1;
const perPage = 10;
let currentFilteredLogs = [...auditLogs];
let currentDetailEvent = null;
let currentSeverityFilter = 'all';
let currentEventTypeFilter = 'all';
let currentDateRange = { from: '2023-03-22', to: '2023-04-22' };

// ==================== TOAST ====================
function showToast(message, isError = false) {
    const existing = document.querySelector('.toast-message');
    if (existing) existing.remove();
    const toast = document.createElement('div');
    toast.className = `fixed bottom-5 right-5 px-5 py-3 rounded-lg text-sm text-white shadow-lg z-[11000] animate-slide-in ${isError ? 'bg-red-500' : 'bg-emerald-500'}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// ==================== EVENT BADGES ====================
function getEventBadgeClass(et) {
    const m = { 'Created':'event-created','Edited':'event-edited','Submitted':'event-submitted','Approved':'event-approved','Rejected':'event-rejected','Dispatched':'event-dispatched','Received':'event-received','Received Damaged':'event-received-damaged','Cancelled':'event-cancelled','Deleted':'event-deleted','Printed':'event-printed','Exported':'event-exported','Viewed':'event-viewed','System':'event-system','Reversed':'event-reversed','Restored':'event-restored','Flagged':'event-flagged','Login':'event-login','Logout':'event-logout','Failed Login':'event-failed-login','Permission Change':'event-permission-change' };
    return m[et] || 'event-system';
}
function getEventIcon(et) {
    return '';
}
function getSeverityBadgeClass(s) {
    const m = { 'info':'severity-info','warning':'severity-warning','critical':'severity-critical' };
    return m[s] || 'severity-info';
}

// ==================== APPLY ALL FILTERS ====================
function applyAllFilters() {
    let filtered = [...auditLogs];

    // Severity tab filter
    if (currentSeverityFilter !== 'all') {
        filtered = filtered.filter(l => l.severity === currentSeverityFilter);
    }

    // Event type dropdown filter
    if (currentEventTypeFilter !== 'all') {
        filtered = filtered.filter(l => l.eventType === currentEventTypeFilter);
    }

    // Search (user or IP)
    const searchVal = document.getElementById('searchInput')?.value?.trim().toLowerCase();
    if (searchVal) {
        filtered = filtered.filter(l => 
            l.userName.toLowerCase().includes(searchVal) || 
            l.ipAddress.includes(searchVal)
        );
    }

    // Date range
    if (currentDateRange.from) {
        filtered = filtered.filter(l => l.timestamp.slice(0, 10) >= currentDateRange.from);
    }
    if (currentDateRange.to) {
        filtered = filtered.filter(l => l.timestamp.slice(0, 10) <= currentDateRange.to);
    }

    currentFilteredLogs = filtered;
    currentPage = 1;
    renderAuditTable(filtered, currentPage);
}

// ==================== RENDER TABLE ====================
function renderAuditTable(logs, page = 1) {
    const start = (page - 1) * perPage;
    const end = start + perPage;
    const pageLogs = logs.slice(start, end);
    const tbody = document.getElementById('auditTableBody');
    
    if (pageLogs.length === 0) {
        tbody.innerHTML = `<tr><td colspan="8" class="px-4 py-12 text-center text-gray-500">No audit events found matching your filters.</td></tr>`;
        document.getElementById('paginationInfo').textContent = 'No events found';
        return;
    }

    tbody.innerHTML = pageLogs.map((log, i) => `
        <tr class="border-b hover:bg-gray-50 cursor-pointer audit-row ${log.flagged ? 'row-flagged' : ''}" data-audit-id="${log.id}">
            <td class="px-4 py-3 text-gray-700 text-xs font-mono whitespace-nowrap">${log.timestamp}</td>
            <td class="px-4 py-3"><span class="event-badge ${getEventBadgeClass(log.eventType)}">${log.eventType}</span></td>
            <td class="px-4 py-3">${log.transferId !== '—' ? `<a href="transfer-details.html?id=${log.transferId}" class="text-indigo-600 hover:text-indigo-800 font-medium text-xs">${log.transferId}</a>` : `<span class="text-gray-400 text-xs">—</span>`}</td>
            <td class="px-4 py-3"><div class="flex flex-col"><span class=" font-medium text-xs">${log.userName}</span><span class="text-gray-500 text-[0.65rem]">${log.userRole}</span></div></td>
            <td class="px-4 py-3 text-gray-500 text-xs font-mono">${log.ipAddress}</td>
            <td class="px-4 py-3 text-gray-700 text-xs max-w-xs">${log.flagged ? '<span class="inline-flex items-center gap-1 text-red-600 font-semibold mr-1">🚨</span>' : ''}${log.description}</td>
            <td class="px-4 py-3 text-center"><span class="inline-flex rounded-full px-2 py-0.5 text-[0.65rem] font-semibold ${getSeverityBadgeClass(log.severity)} text-xs">${log.severity.toUpperCase()}</span></td>
            <td class="px-4 py-3 text-center">
                <button class="view-detail-btn inline-flex h-8 w-8 items-center justify-center rounded-md hover:bg-gray-100" data-audit-id="${log.id}" title="View details">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye h-4 w-4 text-gray-500"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>
                </button>
            </td>
        </tr>
    `).join('');

    document.querySelectorAll('.audit-row').forEach(row => {
        row.addEventListener('click', function(e) {
            if (e.target.closest('a') || e.target.closest('.view-detail-btn')) return;
            openDetailModal(this.dataset.auditId);
        });
    });
    document.querySelectorAll('.view-detail-btn').forEach(btn => {
        btn.addEventListener('click', function(e) { e.stopPropagation(); openDetailModal(this.dataset.auditId); });
    });

    const totalPages = Math.ceil(logs.length / perPage);
    document.getElementById('paginationInfo').textContent = `Showing ${start + 1}-${Math.min(end, logs.length)} of ${logs.length} events`;
    updatePaginationButtons(page, totalPages);
}

function updatePaginationButtons(currentPage, totalPages) {
    document.getElementById('prevPageBtn').disabled = currentPage <= 1;
    document.getElementById('nextPageBtn').disabled = currentPage >= totalPages;
    document.querySelectorAll('.page-btn').forEach(btn => {
        const page = parseInt(btn.dataset.page);
        if (page === currentPage) {
            btn.className = 'page-btn inline-flex items-center justify-center rounded-md bg-primary text-white px-3 py-1.5 text-sm font-medium';
        } else {
            btn.className = 'page-btn inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors';
        }
    });
}

// ==================== DETAIL MODAL ====================
function openDetailModal(auditId) {
    const log = auditLogs.find(l => l.id === auditId);
    if (!log) return;
    currentDetailEvent = log;
    
    document.getElementById('modalTitle').textContent = `Event Details — ${log.id}`;
    
    let detailsHTML = '';
    if (log.details.changes) {
        detailsHTML = `<div class="space-y-4"><div class="grid grid-cols-2 gap-4">
            <div class="p-3 bg-red-50 rounded-lg border border-red-100"><p class="text-xs font-semibold text-red-700 mb-2">BEFORE</p>${log.details.changes.map(c => `<div class="text-xs text-red-700"><strong>${c.field}:</strong> <span class="diff-before">${c.before}</span></div>`).join('')}</div>
            <div class="p-3 bg-green-50 rounded-lg border border-green-100"><p class="text-xs font-semibold text-green-700 mb-2">AFTER</p>${log.details.changes.map(c => `<div class="text-xs text-green-700"><strong>${c.field}:</strong> <span class="diff-after">${c.after}</span></div>`).join('')}</div>
        </div></div>`;
    } else if (log.details.items) {
        detailsHTML = `<div class="space-y-3"><p class="text-sm font-medium text-gray-700">Items:</p>
            <table class="w-full text-xs border border-gray-200 rounded-lg overflow-hidden"><thead class="bg-gray-50"><tr><th class="px-3 py-2 text-left text-gray-500">Item</th><th class="px-3 py-2 text-left text-gray-500">Batch</th><th class="px-3 py-2 text-center text-gray-500">Qty</th><th class="px-3 py-2 text-left text-gray-500">Unit</th></tr></thead>
            <tbody class="divide-y divide-gray-200">${log.details.items.map(item => `<tr><td class="px-3 py-2 font-medium ">${item.name}</td><td class="px-3 py-2 text-gray-500">${item.batch || '—'}</td><td class="px-3 py-2 text-center text-gray-700">${item.qty || item.approved || '—'}</td><td class="px-3 py-2 text-gray-500">${item.unit || '—'}</td></tr>`).join('')}</tbody></table></div>`;
    }

    const reversibleEvents = ['Approved', 'Rejected', 'Dispatched', 'Deleted'];
    const reverseBtn = document.getElementById('reverseEventBtn');
    if (reversibleEvents.includes(log.eventType)) {
        reverseBtn.style.display = 'inline-flex';
        reverseBtn.innerHTML = log.eventType === 'Deleted' ? 
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rotate-ccw h-4 w-4"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg> Restore Transfer' :
            '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-undo-2 h-4 w-4"><path d="M9 14 4 9l5-5"></path><path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5v0a5.5 5.5 0 0 1-5.5 5.5H11"></path></svg> Reverse This Action';
    } else {
        reverseBtn.style.display = 'none';
    }

    const content = `<div class="space-y-4">
        <div class="grid grid-cols-2 gap-3 text-sm">
            <div><span class="text-gray-500">Event ID:</span> <span class="font-medium ">${log.id}</span></div>
            <div><span class="text-gray-500">Timestamp:</span> <span class="font-medium ">${log.timestamp}</span></div>
            <div><span class="text-gray-500">Event Type:</span> <span class="event-badge ${getEventBadgeClass(log.eventType)}">${log.eventType}</span></div>
            <div><span class="text-gray-500">Severity:</span> <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold ${getSeverityBadgeClass(log.severity)}">${log.severity.toUpperCase()}</span></div>
            <div><span class="text-gray-500">Transfer:</span> ${log.transferId !== '—' ? `<a href="transfer-details.html?id=${log.transferId}" class="text-indigo-600 hover:underline font-medium">${log.transferId}</a>` : '<span class="text-gray-400">—</span>'}</div>
            <div><span class="text-gray-500">User:</span> <span class="font-medium ">${log.userName}</span></div>
            <div><span class="text-gray-500">Role:</span> <span class="text-gray-700">${log.userRole}</span></div>
            <div><span class="text-gray-500">Department:</span> <span class="text-gray-700">${log.department}</span></div>
            <div><span class="text-gray-500">IP Address:</span> <span class="text-gray-700 font-mono text-xs">${log.ipAddress}</span></div>
        </div>
        <div class="border-t border-gray-200 pt-3"><p class="text-sm "><strong>Description:</strong> ${log.description}</p></div>
        ${log.flagged ? `<div class="border-t border-red-200 pt-3"><div class="p-3 bg-red-50 rounded-lg border border-red-200"><p class="text-sm font-semibold text-red-800 mb-1">🚨 This event has been flagged for investigation</p><p class="text-xs text-red-600">${log.details.recommendation || 'This event requires immediate attention.'}</p></div></div>` : ''}
        ${detailsHTML ? `<div class="border-t border-gray-200 pt-3">${detailsHTML}</div>` : ''}
        ${log.details.reason ? `<div class="border-t border-gray-200 pt-3"><p class="text-sm text-gray-700"><strong>Reason:</strong> ${log.details.reason}</p></div>` : ''}
        ${log.details.transportMethod ? `<div class="border-t border-gray-200 pt-3"><p class="text-sm text-gray-700"><strong>Transport:</strong> ${log.details.transportMethod} | <strong>Tracking:</strong> ${log.details.trackingNumber || 'N/A'}</p></div>` : ''}
        <div class="border-t border-gray-200 pt-3">
            <details class="text-xs"><summary class="cursor-pointer text-gray-500 hover:text-gray-700 font-medium">View Raw JSON Data</summary><pre class="mt-2 p-3 bg-gray-50 rounded-lg text-xs text-gray-700 overflow-x-auto max-h-40">${JSON.stringify(log, null, 2)}</pre></details>
        </div>
    </div>`;
    
    document.getElementById('modalContent').innerHTML = content;
    document.getElementById('detailModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDetailModal() {
    document.getElementById('detailModal').classList.add('hidden');
    document.body.style.overflow = '';
    currentDetailEvent = null;
}

document.getElementById('closeDetailModal')?.addEventListener('click', closeDetailModal);
document.getElementById('closeDetailBtn')?.addEventListener('click', closeDetailModal);
document.getElementById('detailModal')?.addEventListener('click', function(e) { if (e.target === this) closeDetailModal(); });

// Flag event
document.getElementById('flagEventBtn')?.addEventListener('click', () => {
    if (currentDetailEvent) {
        currentDetailEvent.flagged = true;
        currentDetailEvent.severity = 'critical';
        currentDetailEvent.eventType = 'Flagged';
        applyAllFilters();
        updateStats();
        showToast(`Event ${currentDetailEvent.id} flagged for investigation`);
        closeDetailModal();
    }
});

// Reverse event
document.getElementById('reverseEventBtn')?.addEventListener('click', () => {
    if (!currentDetailEvent) return;
    if (confirm(`Are you sure you want to reverse this action?\n\nEvent: ${currentDetailEvent.eventType}\nTransfer: ${currentDetailEvent.transferId}\nBy: ${currentDetailEvent.userName}\n\nA new audit entry will be created recording this reversal.`)) {
        const reversalLog = {
            id: "AUD-" + String(Math.floor(Math.random() * 9000) + 1000),
            timestamp: new Date().toISOString().replace('T', ' ').slice(0, 19),
            eventType: currentDetailEvent.eventType === 'Deleted' ? 'Restored' : 'Reversed',
            transferId: currentDetailEvent.transferId,
            userName: "Dr. Nakato Sarah",
            userRole: "Administrator",
            department: "Administration",
            description: `${currentDetailEvent.eventType === 'Deleted' ? 'Restored' : 'Reversed'} ${currentDetailEvent.eventType} action on ${currentDetailEvent.transferId}.`,
            severity: "warning",
            ipAddress: "192.168.1.20",
            details: { action: currentDetailEvent.eventType === 'Deleted' ? 'restore' : 'reverse', originalEventId: currentDetailEvent.id }
        };
        auditLogs.unshift(reversalLog);
        applyAllFilters();
        updateStats();
        showToast(`Action reversed. New audit entry ${reversalLog.id} created.`);
        closeDetailModal();
    }
});

// ==================== SEVERITY TABS ====================
document.querySelectorAll('.severity-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        // Remove active from all
        document.querySelectorAll('.tab-button').forEach(t => {
            t.classList.remove('active');
            t.setAttribute('aria-selected', 'false');
        });

        // Activate clicked tab
        tab.classList.add('active');
        tab.setAttribute('aria-selected', 'true');

        currentSeverityFilter = tab.dataset.tab;
        applyAllFilters();
    });
});

// ==================== EVENT TYPE DROPDOWN ====================
document.getElementById('eventTypeFilterBtn')?.addEventListener('click', (e) => {
    e.stopPropagation();
    document.getElementById('eventTypeFilterDropdown').classList.toggle('hidden');
});
document.querySelectorAll('#eventTypeFilterDropdown .dropdown-item').forEach(item => {
    item.addEventListener('click', () => {
        currentEventTypeFilter = item.dataset.filter;
        document.getElementById('eventTypeFilterLabel').textContent = item.textContent;
        document.getElementById('eventTypeFilterDropdown').classList.add('hidden');
        applyAllFilters();
    });
});
document.addEventListener('click', (e) => {
    const btn = document.getElementById('eventTypeFilterBtn');
    const dd = document.getElementById('eventTypeFilterDropdown');
    if (!btn?.contains(e.target) && !dd?.contains(e.target)) dd?.classList.add('hidden');
});

// ==================== DATE POPOVER ====================
document.getElementById('dateRangeBtn')?.addEventListener('click', (e) => {
    e.stopPropagation();
    document.getElementById('datePickerPopover').classList.toggle('hidden');
});
document.getElementById('applyDateBtn')?.addEventListener('click', () => {
    const from = document.getElementById('startDate').value;
    const to = document.getElementById('endDate').value;
    if (from && to) {
        currentDateRange = { from, to };
        document.getElementById('dateRangeText').textContent = `${new Date(from).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })} - ${new Date(to).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
    }
    document.getElementById('datePickerPopover').classList.add('hidden');
    applyAllFilters();
});
document.getElementById('cancelDateBtn')?.addEventListener('click', () => {
    document.getElementById('datePickerPopover').classList.add('hidden');
});
document.addEventListener('click', (e) => {
    const popover = document.getElementById('datePickerPopover');
    const btn = document.getElementById('dateRangeBtn');
    if (popover && !popover.classList.contains('hidden') && !popover.contains(e.target) && !btn?.contains(e.target)) {
        popover.classList.add('hidden');
    }
});

// ==================== SEARCH ====================
document.getElementById('searchInput')?.addEventListener('input', applyAllFilters);

// ==================== PAGINATION ====================
document.getElementById('prevPageBtn')?.addEventListener('click', () => {
    if (currentPage > 1) { currentPage--; renderAuditTable(currentFilteredLogs, currentPage); }
});
document.getElementById('nextPageBtn')?.addEventListener('click', () => {
    const totalPages = Math.ceil(currentFilteredLogs.length / perPage);
    if (currentPage < totalPages) { currentPage++; renderAuditTable(currentFilteredLogs, currentPage); }
});
document.querySelectorAll('.page-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        currentPage = parseInt(btn.dataset.page);
        renderAuditTable(currentFilteredLogs, currentPage);
    });
});

// ==================== EXPORT ====================
document.getElementById('exportAuditBtn')?.addEventListener('click', () => exportData());
document.getElementById('exportBtn')?.addEventListener('click', () => exportData());

function exportData() {
    const headers = ["Event ID","Timestamp","Event Type","Transfer ID","User","Role","Department","Description","Severity","IP Address","Flagged"];
    const rows = currentFilteredLogs.map(l => [l.id, l.timestamp, l.eventType, l.transferId, l.userName, l.userRole, l.department, `"${l.description.replace(/"/g, '""')}"`, l.severity, l.ipAddress, l.flagged ? 'YES' : 'NO']);
    const csv = [headers, ...rows].map(row => row.join(",")).join("\n");
    const blob = new Blob([csv], {type:"text/csv"});
    const a = document.createElement('a'); 
    a.href = URL.createObjectURL(blob); 
    a.download = `audit_logs_${new Date().toISOString().slice(0,10)}.csv`; 
    a.click(); 
    URL.revokeObjectURL(a.href);
    showToast(`${currentFilteredLogs.length} audit log entries exported to CSV`);
}

// ==================== PRINT ====================
document.getElementById('printAuditBtn')?.addEventListener('click', () => window.print());

// ==================== UPDATE STATS ====================
function updateStats() {
    document.getElementById('totalEventsCount').textContent = auditLogs.length;
    document.getElementById('todayEventsCount').textContent = auditLogs.filter(l => l.timestamp.startsWith('2023-04-22')).length;
    document.getElementById('anomaliesCount').textContent = auditLogs.filter(l => l.flagged).length;
    document.getElementById('reversalsCount').textContent = auditLogs.filter(l => l.eventType === 'Reversed' || l.eventType === 'Restored').length;
}

// ==================== KEYBOARD ====================
document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeDetailModal(); });

// ==================== INITIALIZATION ====================
function initializePage() {
    const urlParams = new URLSearchParams(window.location.search);
    const transferId = urlParams.get('transferId');
    if (transferId) {
        document.getElementById('searchInput').value = transferId;
        applyAllFilters();
    } else {
        renderAuditTable(currentFilteredLogs);
    }
    updateStats();
    document.getElementById('todayDate').textContent = new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
}

initializePage();
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
    <script src="js/meditrack-audit-viewer.js"></script>
    <script src="js/meditrack-audit-backup.js"></script>
</body>
</html>
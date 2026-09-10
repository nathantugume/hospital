<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Vaccination Schedule</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted, body.dark .bg-gray-50 { background-color: #262626 !important; }
        body.dark .border-gray-200, body.dark .border-gray-300 { border-color: #333 !important; }

        [role="tab"][data-state="active"] { background: white; color: #1f2937; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        body.dark [role="tab"][data-state="active"] { background: #131212; color: #e5e5e5; }
        .schedule-tab[data-state="active"] { background: white; color: #1f2937; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        body.dark .schedule-tab[data-state="active"] { background: #131212; color: #e5e5e5; }
        .schedule-tab[data-state="inactive"] { color: #6b7280; }
        body.dark .schedule-tab[data-state="inactive"] { color: #9ca3af; }
        .tab-panel.hidden { display: none; }

        .calendar-day { width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: 50%; cursor: pointer; font-size: 0.8rem; transition: all 0.15s; position: relative; }
        #calendarGrid { display: grid; gap: 2px; }
        .calendar-day:hover { background-color: #f3f4f6; }
        body.dark .calendar-day:hover { background-color: #374151; }
        .calendar-day.today { background: #6366f1; color: white; font-weight: 700; }
        .calendar-day.selected { background: #e0e7ff; color: #4f46e5; font-weight: 700; }
        body.dark .calendar-day.selected { background: #1e1b4b; color: #818cf8; }
        .calendar-day.has-events::after { content: ''; position: absolute; bottom: 3px; width: 4px; height: 4px; border-radius: 50%; background: #6366f1; }
        .calendar-day.other-month { color: #d1d5db; }
        body.dark .calendar-day.other-month { color: #4b5563; }

        .schedule-card { transition: all 0.2s; cursor: pointer; }
        .schedule-card:hover { border-color: #6366f1; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }

        .btn-cancel { background: transparent; border: 1px solid #d1d5db; padding: 0.5rem 1rem; border-radius: 0.375rem; cursor: pointer; font-size: 0.875rem; font-weight: 500; color: #374151; display: inline-flex; align-items: center; gap: 0.5rem; }
        .btn-cancel:hover { background: #f3f4f6; }
        body.dark .btn-cancel { border-color: #555; color: #e5e5e5; }
        body.dark .btn-cancel:hover { background: #374151; }
        .btn-primary { color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.375rem; cursor: pointer; font-size: 0.875rem; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem; }

        .toast-message { position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white; padding: 12px 20px; border-radius: 8px; z-index: 11000; animation: slideIn 0.3s ease-out; font-size: 0.875rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
        .status-dot.completed { background: #10b981; }
        .status-dot.scheduled { background: #3b82f6; }
        .status-dot.overdue { background: #ef4444; }
        .status-dot.in-progress { background: #f59e0b; }

        /* Month Calendar Grid Styles */
        .month-calendar { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; }
        .month-day-cell { min-height: 100px; border: 1px solid #e5e7eb; border-radius: 0.375rem; padding: 0.25rem; }
        body.dark .month-day-cell { border-color: #333; }
        .month-day-cell.other-month { background-color: rgba(107, 114, 128, 0.2); opacity: 0.5; }
        body.dark .month-day-cell.other-month { background-color: rgba(75, 85, 99, 0.3); }
        .month-day-cell.today { border-color: #6366f1; border-width: 2px; }
        .month-day-cell.selected { border-color: #4f46e5; border-width: 2px; background: #eef2ff; }
        body.dark .month-day-cell.selected { background: #1e1b4b; }
        .month-day-number { font-size: 0.75rem; font-weight: 600; margin-bottom: 0.25rem; }
        .today .month-day-number { color: #6366f1; }
        .month-event { font-size: 0.65rem; padding: 1px 4px; margin-bottom: 1px; border-radius: 2px; cursor: pointer; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .month-event.completed { background: #dcfce7; color: #166534; }
        .month-event.scheduled { background: #dbeafe; color: #1e40af; }
        .month-event.overdue { background: #fee2e2; color: #991b1b; }
        .month-event.in-progress { background: #fef3c7; color: #92400e; }
        body.dark .month-event.completed { background: #14532d; color: #86efac; }
        body.dark .month-event.scheduled { background: #1e3a5f; color: #93c5fd; }
        body.dark .month-event.overdue { background: #7f1d1d; color: #fca5a5; }
        body.dark .month-event.in-progress { background: #78350f; color: #fcd34d; }
        .month-event.more-events { background: #f3f4f6; color: #6b7280; text-align: center; font-weight: 600; cursor: pointer; }
        body.dark .month-event.more-events { background: #374151; color: #9ca3af; }

        /* Filter Styles */
        .filter-badge { display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; background: #eef2ff; color: #4f46e5; }
        body.dark .filter-badge { background: #1e1b4b; color: #818cf8; }
        .filter-badge button { background: none; border: none; cursor: pointer; padding: 0; margin-left: 0.25rem; color: inherit; font-size: 0.875rem; line-height: 1; }
        .filter-badge button:hover { opacity: 0.7; }

        .dropdown-animation { animation: dropdownIn 0.15s ease-out; }
        @keyframes dropdownIn { from { opacity: 0; transform: translateY(-4px); } to { opacity: 1; transform: translateY(0); } }

        body.dark .filter-option:hover { background-color: #374151; }
        body.dark .filter-option { color: #e5e5e5; }
        body.dark #searchInput { background-color: #262626; border-color: #555; color: #e5e5e5; }
        body.dark #searchInput::placeholder { color: #9ca3af; }
        body.dark select { background-color: #262626; border-color: #555; color: #e5e5e5; }
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
        <div class="flex flex-col gap-5">
            <!-- Header -->
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <a href="vaccination.html" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background hover:bg-gray-50 size-10">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                    </a>
                    <div><h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Vaccination Schedule</h1><p class="text-gray-500">Manage and view upcoming vaccination appointments</p></div>
                </div>
                <div class="flex gap-2">
                    <button id="todayBtn" class="btn-cancel text-sm">Today</button>
                    <a href="add-appointment.html" class="btn-primary bg-primary hover:bg-primary/90"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>Schedule Vaccination</a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid gap-4 md:grid-cols-4">
                <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition cursor-pointer" id="cardToday">
                    <div class="p-4 pb-2">
                        <div class="flex items-center justify-between">
                            <h2 class="text-sm font-medium text-gray-500">Today's Appointments</h2>
                            <svg class="h-5 w-5 text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M16 2v4"></path><path d="M8 2v4"></path><path d="M3 10h18"></path></svg>
                        </div>
                    </div>
                    <div class="p-4 pt-0">
                        <div class="text-2xl font-bold text-blue-600" id="statToday">0</div>
                        <p class="text-xs text-gray-400 mt-1" id="statTodayDetail">0 scheduled</p>
                    </div>
                </div>
                <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition cursor-pointer" id="cardWeek">
                    <div class="p-4 pb-2">
                        <div class="flex items-center justify-between">
                            <h2 class="text-sm font-medium text-gray-500">This Week</h2>
                            <svg class="h-5 w-5 text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path><path d="M8 2v4"></path><path d="M16 2v4"></path><path d="M8 14h.01"></path><path d="M12 14h.01"></path><path d="M16 14h.01"></path></svg>
                        </div>
                    </div>
                    <div class="p-4 pt-0">
                        <div class="text-2xl font-bold text-indigo-600" id="statWeek">0</div>
                        <p class="text-xs text-gray-400 mt-1" id="statWeekDetail">0 remaining</p>
                    </div>
                </div>
                <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition cursor-pointer" id="cardMonth">
                    <div class="p-4 pb-2">
                        <div class="flex items-center justify-between">
                            <h2 class="text-sm font-medium text-gray-500">This Month</h2>
                            <svg class="h-5 w-5 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path><path d="M8 2v4"></path><path d="M16 2v4"></path><path d="M3 16h18"></path></svg>
                        </div>
                    </div>
                    <div class="p-4 pt-0">
                        <div class="text-2xl font-bold text-amber-600" id="statMonth">0</div>
                        <p class="text-xs text-gray-400 mt-1" id="statMonthDetail">0 completed</p>
                    </div>
                </div>
                <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition cursor-pointer" id="cardAvailable">
                    <div class="p-4 pb-2">
                        <div class="flex items-center justify-between">
                            <h2 class="text-sm font-medium text-gray-500">Available Slots</h2>
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"></path><path d="M12 2v4"></path><path d="M12 18v4"></path></svg>
                        </div>
                    </div>
                    <div class="p-4 pt-0">
                        <div class="text-2xl font-bold text-green-600" id="statAvailable">0</div>
                        <p class="text-xs text-gray-400 mt-1" id="statAvailableDetail">Open today</p>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="relative">
                    <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                    <input id="searchInput" type="text" placeholder="Search by patient, vaccine, provider..." class="pl-8 w-[200px] md:w-[400px] h-10 rounded-md border border-gray-300 px-3 py-2 text-sm bg-white">
                </div>
                <div class="flex gap-2 flex-wrap items-center">
                    <div class="relative">
                        <button id="statusFilterBtn" class="flex h-10 w-[150px] items-center justify-between rounded-md border border-gray-300 bg-background px-3 py-2 text-sm">
                            <span id="statusFilterText">All Status</span>
                            <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div id="statusFilterDropdown" class="hidden absolute z-50 mt-1 w-full rounded-md border bg-background shadow-lg dropdown-animation"><div class="p-1">
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="all">All Status</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="Scheduled">Scheduled</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="In Progress">In Progress</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="Completed">Completed</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="Overdue">Overdue</div>
                        </div></div>
                    </div>
                    <div class="relative">
                        <button id="vaccineFilterBtn" class="flex h-10 w-[160px] items-center justify-between rounded-md border border-gray-300 bg-background px-3 py-2 text-sm">
                            <span id="vaccineFilterText">All Vaccines</span>
                            <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div id="vaccineFilterDropdown" class="hidden absolute z-50 mt-1 w-full rounded-md border bg-background shadow-lg dropdown-animation"><div class="p-1 max-h-[200px] overflow-y-auto">
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="all">All Vaccines</div>
                        </div></div>
                    </div>
                    <div class="relative">
                        <button id="doseFilterBtn" class="flex h-10 w-[140px] items-center justify-between rounded-md border border-gray-300 bg-background px-3 py-2 text-sm">
                            <span id="doseFilterText">All Doses</span>
                            <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div id="doseFilterDropdown" class="hidden absolute z-50 mt-1 w-full rounded-md border bg-background shadow-lg dropdown-animation"><div class="p-1">
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100" data-value="all">All Doses</div>
                        </div></div>
                    </div>
                    <button id="resetFiltersBtn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background size-10 hover:bg-gray-50" title="Reset Filters">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path><path d="M8 16H3v5"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Active Filter Badges -->
            <div class="flex flex-wrap gap-2" id="activeFilters"></div>

            <!-- Main Content: Calendar + Schedule -->
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="lg:col-span-1">
                    <div class="rounded-lg border bg-background shadow-sm">
                        <div class="p-4 border-b flex items-center justify-between">
                            <button id="prevMonthBtn" class="p-1 hover:bg-gray-100 rounded"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg></button>
                            <h2 class="text-lg font-semibold" id="calendarMonthYear">June 2026</h2>
                            <button id="nextMonthBtn" class="p-1 hover:bg-gray-100 rounded"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg></button>
                        </div>
                        <div class="p-4">
<div class="grid gap-1 mb-2" id="calendarDayHeaders" style="display:grid;">
    <!-- Day headers rendered dynamically by renderCalendar() -->
</div>
                            <div class="grid grid-cols-7 gap-1" id="calendarGrid"></div>
                        </div>
                        <div class="p-4 border-t">
                            <h3 class="text-sm font-semibold mb-3">Upcoming (Next 7 Days)</h3>
                            <div class="space-y-2" id="upcomingList"></div>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <div class="rounded-lg border bg-background shadow-sm">
                        <div class="p-4 border-b">
                            <div class="flex items-center justify-between flex-wrap gap-3">
                                <h2 class="text-xl font-semibold" id="scheduleDateTitle">Monday, June 9, 2026</h2>
                                <div role="tablist" class="inline-flex items-center rounded-md bg-gray-100 p-1">
                                    <button data-view="day" class="schedule-tab inline-flex rounded-sm px-3 py-1.5 text-sm font-medium" data-state="active">Day</button>
                                    <button data-view="week" class="schedule-tab inline-flex rounded-sm px-3 py-1.5 text-sm font-medium" data-state="inactive">Week</button>
                                    <button data-view="month" class="schedule-tab inline-flex rounded-sm px-3 py-1.5 text-sm font-medium" data-state="inactive">Month</button>
                                    <button data-view="list" class="schedule-tab inline-flex rounded-sm px-3 py-1.5 text-sm font-medium" data-state="inactive">List</button>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <div id="view-day" class="schedule-view"><div class="space-y-3" id="daySchedule"></div></div>
                            <div id="view-week" class="schedule-view hidden"><div class="overflow-x-auto"><div class="min-w-[700px]"><div class="grid grid-cols-7 gap-2 mb-3" id="weekHeader"></div><div class="space-y-2" id="weekSchedule"></div></div></div></div>
                            <div id="view-month" class="schedule-view hidden"><div id="monthCalendarGrid"></div></div>
                            <div id="view-list" class="schedule-view hidden"><div class="space-y-2" id="listSchedule"></div></div>
                        </div>
                    </div>
                </div>
            </div>
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
function showToast(msg, err = false) { const t = document.createElement('div'); t.className = `toast-message ${err ? 'error' : ''}`; t.textContent = msg; document.body.appendChild(t); setTimeout(() => t.remove(), 3000); }

const scheduleData = [
    { id: 1, patient: "Nalwoga Emma", vaccine: "COVID-19", dose: "2nd Dose", date: "2026-06-09", time: "09:00 AM", status: "Scheduled", provider: "Dr. Sarah Chen", site: "Left Arm" },
    { id: 2, patient: "Mukasa Noah", vaccine: "Influenza", dose: "Annual", date: "2026-06-09", time: "10:30 AM", status: "Scheduled", provider: "Dr. Tumusiimeera Robert", site: "Right Arm" },
    { id: 3, patient: "Wanjiru Ava", vaccine: "Polio", dose: "3rd Dose", date: "2026-06-09", time: "02:00 PM", status: "Scheduled", provider: "Dr. Nabwire Lisa", site: "Oral" },
    { id: 4, patient: "Kimera Liam", vaccine: "Tetanus", dose: "Booster", date: "2026-06-10", time: "09:30 AM", status: "Scheduled", provider: "Dr. Okello James", site: "Left Arm" },
    { id: 5, patient: "Nansubuga Sophia", vaccine: "COVID-19", dose: "Booster", date: "2026-06-10", time: "11:00 AM", status: "Scheduled", provider: "Dr. Sarah Chen", site: "Right Arm" },
    { id: 6, patient: "Ethan Brown", vaccine: "MMR", dose: "1st Dose", date: "2026-06-11", time: "09:00 AM", status: "Scheduled", provider: "Dr. Tumusiimeera Robert", site: "Left Arm" },
    { id: 7, patient: "Nakato Olivia", vaccine: "Hepatitis B", dose: "1st Dose", date: "2026-06-12", time: "10:00 AM", status: "Overdue", provider: "Dr. Nabwire Lisa", site: "Right Arm" },
    { id: 8, patient: "James Taylor", vaccine: "Influenza", dose: "Annual", date: "2026-06-15", time: "09:00 AM", status: "Scheduled", provider: "Dr. Sarah Chen", site: "Left Arm" },
    { id: 9, patient: "Nalwoga Emma", vaccine: "COVID-19", dose: "1st Dose", date: "2026-06-09", time: "08:00 AM", status: "Completed", provider: "Dr. Sarah Chen", site: "Left Arm" },
    { id: 10, patient: "Mia Anderson", vaccine: "HPV", dose: "1st Dose", date: "2026-06-16", time: "11:00 AM", status: "Scheduled", provider: "Dr. Okello James", site: "Left Arm" },
    { id: 11, patient: "Lucas Green", vaccine: "DTaP", dose: "4th Dose", date: "2026-06-12", time: "02:30 PM", status: "In Progress", provider: "Dr. Nabwire Lisa", site: "Right Arm" }
];

let currentDate = new Date(2026, 5, 9);
let currentView = 'day';
let selectedDate = new Date(2026, 5, 9);
let searchQuery = '';
let activeFilters = { vaccine: '', dose: '', status: '' };

// ==================== REGIONAL SETTINGS HELPERS ====================
function getRegionalPrefs() {
    let showWeekends = true;
    let firstDayIdx = 0; // 0=Sun, 1=Mon, 6=Sat
    if (window.MeditrackRegional) {
        showWeekends = window.MeditrackRegional.getShowWeekends();
        firstDayIdx = window.MeditrackRegional.getFirstDayIndex();
    } else if (window.MeditrackSettings) {
        const sw = window.MeditrackSettings.get('show_weekends');
        if (sw === true || sw === 'true') showWeekends = true;
        if (sw === false || sw === 'false') showWeekends = false;
        const fd = window.MeditrackSettings.get('first_day');
        if (fd === 'Monday') firstDayIdx = 1;
        if (fd === 'Saturday') firstDayIdx = 6;
    }
    return { showWeekends, firstDayIdx };
}

/**
 * Returns the ordered array of visible day names based on preferences.
 * When weekends are hidden, ONLY Mon-Fri are returned (5 days).
 */
function getOrderedDayNames(firstDayIdx, showWeekends) {
    const allDays = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
    // Start with the full week ordered by first_day preference
    const ordered = allDays.slice(firstDayIdx).concat(allDays.slice(0, firstDayIdx));
    if (!showWeekends) {
        // Filter to ONLY weekdays (Mon-Fri), preserving the first_day order
        return ordered.filter(d => d === 'Mon' || d === 'Tue' || d === 'Wed' || d === 'Thu' || d === 'Fri');
    }
    return ordered;
}

// ==================== DATA FILTERING ====================
function getFilteredData() {
    let data = scheduleData;
    if (searchQuery) {
        data = data.filter(s => s.patient.toLowerCase().includes(searchQuery) || s.vaccine.toLowerCase().includes(searchQuery) || s.provider.toLowerCase().includes(searchQuery) || s.dose.toLowerCase().includes(searchQuery));
    }
    if (activeFilters.vaccine) data = data.filter(s => s.vaccine === activeFilters.vaccine);
    if (activeFilters.dose) data = data.filter(s => s.dose === activeFilters.dose);
    if (activeFilters.status) data = data.filter(s => s.status === activeFilters.status);
    return data;
}

function populateFilters() {
    const vaccines = [...new Set(scheduleData.map(s => s.vaccine))].sort();
    const doses = [...new Set(scheduleData.map(s => s.dose))].sort();
    const vaccineDropdown = document.getElementById('vaccineFilterDropdown').querySelector('.p-1');
    const doseDropdown = document.getElementById('doseFilterDropdown').querySelector('.p-1');
    const vaccineAll = vaccineDropdown.querySelector('[data-value="all"]');
    const doseAll = doseDropdown.querySelector('[data-value="all"]');
    vaccineDropdown.innerHTML = ''; doseDropdown.innerHTML = '';
    vaccineDropdown.appendChild(vaccineAll); doseDropdown.appendChild(doseAll);
    vaccines.forEach(v => { const div = document.createElement('div'); div.className = 'filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100'; div.dataset.value = v; div.textContent = v; vaccineDropdown.appendChild(div); });
    doses.forEach(d => { const div = document.createElement('div'); div.className = 'filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm hover:bg-gray-100'; div.dataset.value = d; div.textContent = d; doseDropdown.appendChild(div); });
}

function setupDropdown(buttonId, dropdownId, textId, filterKey) {
    const button = document.getElementById(buttonId);
    const dropdown = document.getElementById(dropdownId);
    const text = document.getElementById(textId);
    if (!button || !dropdown || !text) return;
    text.dataset.default = text.textContent;
    button.addEventListener('click', (e) => {
        e.stopPropagation();
        document.querySelectorAll('[id$="FilterDropdown"]').forEach(d => { if (d.id !== dropdownId) d.classList.add('hidden'); });
        dropdown.classList.toggle('hidden');
    });
    dropdown.querySelectorAll('.filter-option').forEach(option => {
        option.addEventListener('click', (e) => {
            e.stopPropagation();
            const value = option.dataset.value;
            activeFilters[filterKey] = value === 'all' ? '' : value;
            text.textContent = value === 'all' ? text.dataset.default : value;
            dropdown.classList.add('hidden');
            updateFilterBadges();
            renderAll();
        });
    });
}

document.addEventListener('click', () => { document.querySelectorAll('[id$="FilterDropdown"]').forEach(d => d.classList.add('hidden')); });

function updateFilterBadges() {
    const container = document.getElementById('activeFilters');
    let badges = [];
    if (activeFilters.vaccine) badges.push(`<span class="filter-badge">Vaccine: ${activeFilters.vaccine} <button data-filter="vaccine">×</button></span>`);
    if (activeFilters.dose) badges.push(`<span class="filter-badge">Dose: ${activeFilters.dose} <button data-filter="dose">×</button></span>`);
    if (activeFilters.status) badges.push(`<span class="filter-badge">Status: ${activeFilters.status} <button data-filter="status">×</button></span>`);
    if (searchQuery) badges.push(`<span class="filter-badge">Search: "${searchQuery}" <button data-filter="search">×</button></span>`);
    container.innerHTML = badges.join('');
    container.querySelectorAll('button[data-filter]').forEach(btn => {
        btn.addEventListener('click', () => {
            const type = btn.dataset.filter;
            if (type === 'vaccine') { activeFilters.vaccine = ''; document.getElementById('vaccineFilterText').textContent = document.getElementById('vaccineFilterText').dataset.default; }
            else if (type === 'dose') { activeFilters.dose = ''; document.getElementById('doseFilterText').textContent = document.getElementById('doseFilterText').dataset.default; }
            else if (type === 'status') { activeFilters.status = ''; document.getElementById('statusFilterText').textContent = document.getElementById('statusFilterText').dataset.default; }
            else if (type === 'search') { searchQuery = ''; document.getElementById('searchInput').value = ''; }
            updateFilterBadges();
            renderAll();
        });
    });
}

function resetAllFilters() {
    activeFilters = { vaccine: '', dose: '', status: '' };
    searchQuery = '';
    document.getElementById('searchInput').value = '';
    document.getElementById('vaccineFilterText').textContent = document.getElementById('vaccineFilterText').dataset.default;
    document.getElementById('doseFilterText').textContent = document.getElementById('doseFilterText').dataset.default;
    document.getElementById('statusFilterText').textContent = document.getElementById('statusFilterText').dataset.default;
    updateFilterBadges();
    renderAll();
}

document.getElementById('searchInput')?.addEventListener('input', (e) => {
    searchQuery = e.target.value.toLowerCase();
    updateFilterBadges();
    renderAll();
});

document.getElementById('resetFiltersBtn')?.addEventListener('click', resetAllFilters);

setupDropdown('statusFilterBtn', 'statusFilterDropdown', 'statusFilterText', 'status');
setupDropdown('vaccineFilterBtn', 'vaccineFilterDropdown', 'vaccineFilterText', 'vaccine');
setupDropdown('doseFilterBtn', 'doseFilterDropdown', 'doseFilterText', 'dose');

function getStatusBadge(status) {
    const badges = { 'Completed': 'bg-green-100 text-green-700', 'Scheduled': 'bg-blue-100 text-blue-700', 'Overdue': 'bg-red-100 text-red-700', 'In Progress': 'bg-yellow-100 text-yellow-800' };
    return `<span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold ${badges[status] || 'bg-gray-100 text-gray-700'}">${status}</span>`;
}

// ==================== MINI CALENDAR (LEFT PANEL) ====================
function renderCalendar() {
    const filteredData = getFilteredData();
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    document.getElementById('calendarMonthYear').textContent = `${monthNames[month]} ${year}`;
    
    // ---- READ REGIONAL PREFERENCES ----
    const { showWeekends, firstDayIdx } = getRegionalPrefs();
    const orderedDays = getOrderedDayNames(firstDayIdx, showWeekends);
    const colCount = orderedDays.length; // 7 when weekends shown, 5 when hidden
    
    const ALL_DAY_NAMES = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
    const rawFirstDow = new Date(year, month, 1).getDay(); // 0=Sun..6=Sat
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();
    const today = new Date();
    const todayStr = today.toISOString().split('T')[0];
    
    // ---- FIND STARTING COLUMN ----
    // Which visible column does the 1st of the month fall in?
    let startCol = -1;
    for (let vi = 0; vi < orderedDays.length; vi++) {
        const dayIdx = ALL_DAY_NAMES.indexOf(orderedDays[vi]);
        if (dayIdx === rawFirstDow) { startCol = vi; break; }
    }
    // If 1st is on a hidden weekend day, find the next visible day
    if (startCol === -1) {
        for (let offset = 1; offset <= 7; offset++) {
            const next = (rawFirstDow + offset) % 7;
            for (let vj = 0; vj < orderedDays.length; vj++) {
                if (ALL_DAY_NAMES.indexOf(orderedDays[vj]) === next) {
                    startCol = vj; break;
                }
            }
            if (startCol !== -1) break;
        }
        if (startCol === -1) startCol = 0;
    }
    
    // ---- BUILD HEADERS + CELLS ----
    // Day name headers go into calendarDayHeaders
    let headerHtml = '';
    orderedDays.forEach(d => {
        headerHtml += `<div class="text-center text-xs font-medium text-gray-500 py-1">${d}</div>`;
    });
    
    // Calendar cells go into calendarGrid
    let html = '';
    
    // Leading spacers (previous month days)
    for (let i = startCol - 1; i >= 0; i--) {
        html += `<div class="calendar-day other-month relative">${daysInPrevMonth - i}</div>`;
    }
    
    // Day cells for current month
    for (let d = 1; d <= daysInMonth; d++) {
        const dateObj = new Date(year, month, d);
        const dow = dateObj.getDay();
        const isWeekend = (dow === 0 || dow === 6);
        
        // SKIP weekend days entirely when weekends are hidden
        if (!showWeekends && isWeekend) continue;
        
        const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        const isToday = dateStr === todayStr;
        const isSelected = dateStr === selectedDate.toISOString().split('T')[0];
        const hasEvents = filteredData.some(s => s.date === dateStr);
        
        html += `<div class="calendar-day relative ${isToday ? 'today bg-primary' : ''} ${isSelected ? 'selected' : ''} ${hasEvents ? 'has-events' : ''}" data-date="${dateStr}">${d}</div>`;
    }
    
    // Trailing spacers (next month days) — fill remaining cells in last row
    // Count how many cells we've rendered total (spacers + visible days)
    let visibleDayCount = 0;
    for (let d = 1; d <= daysInMonth; d++) {
        const dow = new Date(year, month, d).getDay();
        if (showWeekends || (dow !== 0 && dow !== 6)) visibleDayCount++;
    }
    const totalRendered = startCol + visibleDayCount;
    const remaining = (colCount - (totalRendered % colCount)) % colCount;
    for (let d = 1; d <= remaining; d++) {
        html += `<div class="calendar-day other-month relative">${d}</div>`;
    }
    
    // Update DOM
    document.getElementById('calendarDayHeaders').innerHTML = headerHtml;
    document.getElementById('calendarDayHeaders').style.gridTemplateColumns = `repeat(${colCount}, minmax(0, 1fr))`;
    document.getElementById('calendarDayHeaders').style.display = 'grid';
    document.getElementById('calendarDayHeaders').style.gap = '2px';
    
    document.getElementById('calendarGrid').innerHTML = html;
    document.getElementById('calendarGrid').style.gridTemplateColumns = `repeat(${colCount}, minmax(0, 1fr))`;
    
    // Re-attach click handlers
    document.querySelectorAll('#calendarGrid .calendar-day[data-date]').forEach(day => {
        day.addEventListener('click', () => { 
            selectedDate = new Date(day.dataset.date + 'T00:00:00'); 
            renderAll(); 
        });
    });
    
    // ---- UPCOMING LIST ----
    const upcoming = filteredData.filter(s => s.date >= todayStr && (s.status === 'Scheduled' || s.status === 'In Progress')).slice(0, 5);
    document.getElementById('upcomingList').innerHTML = upcoming.length === 0 
        ? '<p class="text-sm text-gray-400">No upcoming appointments</p>' 
        : upcoming.map(s => `<div class="flex items-center gap-2 text-sm"><span class="status-dot ${s.status.toLowerCase().replace(' ', '-')}"></span><span class="font-medium">${s.patient}</span><span class="text-gray-400 ml-auto">${s.date.slice(5)}</span></div>`).join('');
    
    // ---- STATS ----
    const todayAppts = filteredData.filter(s => s.date === todayStr);
    const todayScheduled = todayAppts.filter(s => s.status === 'Scheduled' || s.status === 'In Progress');
    const todayCompleted = todayAppts.filter(s => s.status === 'Completed');
    document.getElementById('statToday').textContent = todayAppts.length;
    document.getElementById('statTodayDetail').textContent = `${todayScheduled.length} scheduled, ${todayCompleted.length} completed`;
    
    const weekStart = new Date(today); weekStart.setDate(today.getDate() - today.getDay());
    const weekEnd = new Date(weekStart); weekEnd.setDate(weekStart.getDate() + 6);
    const weekAppts = filteredData.filter(s => s.date >= weekStart.toISOString().split('T')[0] && s.date <= weekEnd.toISOString().split('T')[0]);
    const weekScheduled = weekAppts.filter(s => s.status === 'Scheduled' || s.status === 'In Progress');
    document.getElementById('statWeek').textContent = weekAppts.length;
    document.getElementById('statWeekDetail').textContent = `${weekScheduled.length} remaining`;
    
    const monthAppts = filteredData.filter(s => s.date.startsWith(`${year}-${String(month+1).padStart(2,'0')}`));
    const monthCompleted = monthAppts.filter(s => s.status === 'Completed');
    document.getElementById('statMonth').textContent = monthAppts.length;
    document.getElementById('statMonthDetail').textContent = `${monthCompleted.length} completed`;
    
    const availableSlots = Math.max(0, 20 - todayAppts.length);
    document.getElementById('statAvailable').textContent = availableSlots;
    document.getElementById('statAvailableDetail').textContent = availableSlots > 0 ? `${availableSlots} open today` : 'Fully booked';
}

// ==================== SCHEDULE VIEWS (RIGHT PANEL) ====================
function updateScheduleTitle() {
    const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
    if (currentView === 'month') {
        document.getElementById('scheduleDateTitle').textContent = `${months[selectedDate.getMonth()]} ${selectedDate.getFullYear()}`;
    } else {
        const days = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
        document.getElementById('scheduleDateTitle').textContent = `${days[selectedDate.getDay()]}, ${months[selectedDate.getMonth()]} ${selectedDate.getDate()}, ${selectedDate.getFullYear()}`;
    }
}

function renderDayView() {
    const filteredData = getFilteredData();
    const dateStr = selectedDate.toISOString().split('T')[0];
    const dayData = filteredData.filter(s => s.date === dateStr).sort((a,b) => a.time.localeCompare(b.time));
    document.getElementById('daySchedule').innerHTML = dayData.length === 0 ? `<div class="text-center py-8 text-gray-400"><svg class="h-12 w-12 mx-auto mb-3 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg><p class="font-medium">No appointments for this day</p><p class="text-sm">Select another date or schedule a vaccination</p></div>` : dayData.map(s => `<div class="schedule-card rounded-lg border p-4 hover:shadow-md"><div class="flex items-start justify-between"><div class="flex items-start gap-3"><div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-semibold text-indigo-600">${s.patient.split(' ').map(n=>n[0]).join('')}</div><div><p class="font-semibold">${s.patient}</p><p class="text-sm text-gray-500">${s.vaccine} - ${s.dose}</p><div class="flex items-center gap-3 mt-2 text-xs text-gray-500"><span>🕐 ${s.time}</span><span>💉 ${s.site}</span><span>👨‍⚕️ ${s.provider}</span></div></div></div><div class="text-right">${getStatusBadge(s.status)}<div class="flex gap-1 mt-2"><button class="text-xs text-indigo-600 hover:text-indigo-800 cursor-pointer" onclick="showToast('View details: ${s.patient}')">View</button></div></div></div></div>`).join('');
}

function renderWeekView() {
    const filteredData = getFilteredData();
    const { firstDayIdx, showWeekends } = getRegionalPrefs();
    const orderedDays = getOrderedDayNames(firstDayIdx, showWeekends);
    const colCount = orderedDays.length;
    
    // Calculate week start based on first_day preference
    const currentDow = selectedDate.getDay();
    const offset = (currentDow - firstDayIdx + 7) % 7;
    const startOfWeek = new Date(selectedDate);
    startOfWeek.setDate(selectedDate.getDate() - offset);
    
    let headerHtml = '', scheduleHtml = '';
    for (let i = 0; i < colCount; i++) {
        const d = new Date(startOfWeek); d.setDate(startOfWeek.getDate() + i);
        const dateStr = d.toISOString().split('T')[0];
        const isToday = dateStr === new Date().toISOString().split('T')[0];
        headerHtml += `<div class="text-center"><div class="text-xs text-gray-500">${orderedDays[i]}</div><div class="text-lg font-bold ${isToday ? 'text-indigo-600' : ''}">${d.getDate()}</div></div>`;
        const dayData = filteredData.filter(s => s.date === dateStr);
        const bgClass = s => s.status === 'Completed' ? 'bg-green-100' : s.status === 'Scheduled' ? 'bg-blue-100' : s.status === 'In Progress' ? 'bg-yellow-100' : 'bg-red-100';
        scheduleHtml += `<div class="space-y-1 min-h-[80px] p-1 rounded ${isToday ? 'bg-indigo-50' : 'bg-gray-50'}">${dayData.map(s => `<div class="text-xs p-1.5 rounded ${bgClass(s)} cursor-pointer hover:shadow-sm" title="${s.patient} - ${s.vaccine} (${s.time})"><span class="font-medium">${s.patient.split(' ')[0]}</span><br>${s.time}</div>`).join('')}${dayData.length === 0 ? '<div class="text-xs text-gray-300 text-center py-2">—</div>' : ''}</div>`;
    }
    document.getElementById('weekHeader').innerHTML = headerHtml;
    document.getElementById('weekHeader').style.gridTemplateColumns = `repeat(${colCount}, minmax(0, 1fr))`;
    document.getElementById('weekSchedule').innerHTML = `<div class="grid gap-1" style="grid-template-columns: repeat(${colCount}, minmax(0, 1fr));">${scheduleHtml}</div>`;
}

function renderMonthView() {
    const filteredData = getFilteredData();
    const year = selectedDate.getFullYear();
    const month = selectedDate.getMonth();
    const { firstDayIdx, showWeekends } = getRegionalPrefs();
    const ALL_DAY_NAMES = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    const dayNames = getOrderedDayNames(firstDayIdx, showWeekends);
    
    const rawFirstDow = new Date(year, month, 1).getDay();
    // Find which visible column the 1st lands in
    let adjustedFirstDay = -1;
    for (let vi = 0; vi < dayNames.length; vi++) {
        if (ALL_DAY_NAMES.indexOf(dayNames[vi]) === rawFirstDow) { adjustedFirstDay = vi; break; }
    }
    if (adjustedFirstDay === -1) {
        for (let offset = 1; offset <= 7; offset++) {
            const next = (rawFirstDow + offset) % 7;
            for (let vj = 0; vj < dayNames.length; vj++) {
                if (ALL_DAY_NAMES.indexOf(dayNames[vj]) === next) { adjustedFirstDay = vj; break; }
            }
            if (adjustedFirstDay !== -1) break;
        }
        if (adjustedFirstDay === -1) adjustedFirstDay = 0;
    }
    
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const daysInPrevMonth = new Date(year, month, 0).getDate();
    const today = new Date();
    const todayStr = today.toISOString().split('T')[0];
    
    let html = '<div class="month-calendar" style="display:grid; gap:2px;">';
    // Day headers
    dayNames.forEach(day => { html += `<div class="text-center text-xs font-semibold text-gray-500 py-2">${day}</div>`; });
    
    // Previous month spacers
    const prevMonth = month === 0 ? 11 : month - 1;
    const prevYear = month === 0 ? year - 1 : year;
    for (let i = adjustedFirstDay - 1; i >= 0; i--) {
        const d = daysInPrevMonth - i;
        const dateStr = `${prevYear}-${String(prevMonth+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        html += renderMonthDayCell(d, filteredData.filter(s => s.date === dateStr), true, dateStr === todayStr, false);
    }
    
    // Current month days
    for (let d = 1; d <= daysInMonth; d++) {
        const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        const dow = new Date(year, month, d).getDay();
        const isWeekend = (dow === 0 || dow === 6);
        // Skip hidden weekend days entirely
        if (!showWeekends && isWeekend) continue;
        html += renderMonthDayCell(d, filteredData.filter(s => s.date === dateStr), false, dateStr === todayStr, dateStr === selectedDate.toISOString().split('T')[0]);
    }
    
    // Next month spacers (fill remaining cells in the 6-row grid)
    let visibleCount = adjustedFirstDay;
    for (let d = 1; d <= daysInMonth; d++) {
        const dow = new Date(year, month, d).getDay();
        if (showWeekends || (dow !== 0 && dow !== 6)) visibleCount++;
    }
    const colCount = dayNames.length;
    const totalCells = Math.ceil(visibleCount / colCount) * colCount; // round up to full rows
    const remaining = totalCells - visibleCount;
    
    const nextMonth = month === 11 ? 0 : month + 1;
    const nextYear = month === 11 ? year + 1 : year;
    for (let d = 1; d <= remaining; d++) {
        const dateStr = `${nextYear}-${String(nextMonth+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        html += renderMonthDayCell(d, filteredData.filter(s => s.date === dateStr), true, dateStr === todayStr, false);
    }
    html += '</div>';
    document.getElementById('monthCalendarGrid').innerHTML = html;
    
    // Set grid columns on the month-calendar div
    const mc = document.querySelector('#monthCalendarGrid .month-calendar');
    if (mc) mc.style.gridTemplateColumns = `repeat(${colCount}, 1fr)`;
    
    // Event listeners
    document.querySelectorAll('.month-event').forEach(event => {
        event.addEventListener('click', (e) => { e.stopPropagation(); const appt = scheduleData.find(s => s.patient === event.dataset.patient && s.date === event.dataset.date); if (appt) showToast(`${appt.patient} - ${appt.vaccine} ${appt.dose} at ${appt.time}`); });
    });
    document.querySelectorAll('.month-event.more-events').forEach(btn => {
        btn.addEventListener('click', (e) => { e.stopPropagation(); const dateStr = btn.closest('.month-day-cell').dataset.date; if (dateStr) { selectedDate = new Date(dateStr + 'T00:00:00'); currentView = 'day'; document.querySelectorAll('.schedule-tab').forEach(t => t.setAttribute('data-state', 'inactive')); document.querySelector('.schedule-tab[data-view="day"]').setAttribute('data-state', 'active'); renderAll(); } });
    });
    document.querySelectorAll('.month-day-cell[data-date]').forEach(cell => {
        cell.addEventListener('click', () => { selectedDate = new Date(cell.dataset.date + 'T00:00:00'); renderAll(); });
    });
    updateScheduleTitle();
}

function renderMonthDayCell(day, events, isOtherMonth, isToday, isSelected) {
    const cellClasses = ['month-day-cell', 'min-h-[100px] border rounded-md p-1', isOtherMonth ? 'other-month bg-gray-500/20 opacity-50' : '', isToday ? 'today' : '', isSelected ? 'selected' : ''].filter(Boolean).join(' ');
    const maxEvents = 3;
    const dateStr = events.length > 0 ? events[0].date : '';
    let eventsHtml = '';
    events.slice(0, maxEvents).forEach(event => { eventsHtml += `<div class="month-event ${event.status.toLowerCase().replace(' ', '-')}" data-patient="${event.patient}" data-date="${event.date}" title="${event.patient} - ${event.vaccine} (${event.time})">${event.patient.split(' ')[0]} ${event.time}</div>`; });
    if (events.length > maxEvents) eventsHtml += `<div class="month-event more-events">+${events.length - maxEvents} more</div>`;
    if (events.length === 0) eventsHtml = '<div style="flex:1"></div>';
    return `<div class="${cellClasses}" data-date="${dateStr || ''}"><div class="month-day-number">${day}</div><div class="month-events-container">${eventsHtml}</div></div>`;
}

function renderListView() {
    const filteredData = getFilteredData();
    const dateStr = selectedDate.toISOString().split('T')[0].slice(0, 7);
    const monthData = filteredData.filter(s => s.date.startsWith(dateStr)).sort((a,b) => a.date.localeCompare(b.date) || a.time.localeCompare(b.time));
    document.getElementById('listSchedule').innerHTML = monthData.length === 0 ? '<div class="text-center py-8 text-gray-400">No appointments this month</div>' : `<div class="rounded-lg border overflow-hidden"><table class="w-full text-sm"><thead class="bg-gray-50"><tr><th class="text-left p-3">Patient</th><th class="text-left p-3">Vaccine</th><th class="text-left p-3">Dose</th><th class="text-left p-3">Date</th><th class="text-left p-3">Time</th><th class="text-left p-3">Status</th></tr></thead><tbody>${monthData.map(s => `<tr class="border-b hover:bg-gray-50 cursor-pointer"><td class="p-4 font-medium">${s.patient}</td><td class="p-4">${s.vaccine}</td><td class="p-4">${s.dose}</td><td class="p-4">${s.date.slice(5)}</td><td class="p-4">${s.time}</td><td class="p-4">${getStatusBadge(s.status)}</td></tr>`).join('')}</tbody></table></div>`;
}

function renderCurrentView() {
    document.querySelectorAll('.schedule-view').forEach(v => v.classList.add('hidden'));
    document.getElementById(`view-${currentView}`).classList.remove('hidden');
    if (currentView === 'day') { updateScheduleTitle(); renderDayView(); }
    else if (currentView === 'week') { updateScheduleTitle(); renderWeekView(); }
    else if (currentView === 'month') { renderMonthView(); }
    else if (currentView === 'list') { updateScheduleTitle(); renderListView(); }
}

function renderAll() { renderCalendar(); renderCurrentView(); }

// ==================== EVENT LISTENERS ====================
document.getElementById('prevMonthBtn')?.addEventListener('click', () => { currentDate.setMonth(currentDate.getMonth() - 1); selectedDate = new Date(currentDate); renderAll(); });
document.getElementById('nextMonthBtn')?.addEventListener('click', () => { currentDate.setMonth(currentDate.getMonth() + 1); selectedDate = new Date(currentDate); renderAll(); });
document.getElementById('todayBtn')?.addEventListener('click', () => { selectedDate = new Date(); currentDate = new Date(); renderAll(); });

document.querySelectorAll('.schedule-tab').forEach(tab => {
    tab.addEventListener('click', () => { document.querySelectorAll('.schedule-tab').forEach(t => t.setAttribute('data-state', 'inactive')); tab.setAttribute('data-state', 'active'); currentView = tab.dataset.view; renderCurrentView(); });
});

document.getElementById('cardToday')?.addEventListener('click', () => { selectedDate = new Date(); currentDate = new Date(); currentView = 'day'; document.querySelectorAll('.schedule-tab').forEach(t => t.setAttribute('data-state', 'inactive')); document.querySelector('.schedule-tab[data-view="day"]').setAttribute('data-state', 'active'); renderAll(); });
document.getElementById('cardWeek')?.addEventListener('click', () => { selectedDate = new Date(); currentDate = new Date(); currentView = 'week'; document.querySelectorAll('.schedule-tab').forEach(t => t.setAttribute('data-state', 'inactive')); document.querySelector('.schedule-tab[data-view="week"]').setAttribute('data-state', 'active'); renderAll(); });
document.getElementById('cardMonth')?.addEventListener('click', () => { currentView = 'month'; document.querySelectorAll('.schedule-tab').forEach(t => t.setAttribute('data-state', 'inactive')); document.querySelector('.schedule-tab[data-view="month"]').setAttribute('data-state', 'active'); renderAll(); });
document.getElementById('cardAvailable')?.addEventListener('click', () => { selectedDate = new Date(); currentDate = new Date(); currentView = 'day'; document.querySelectorAll('.schedule-tab').forEach(t => t.setAttribute('data-state', 'inactive')); document.querySelector('.schedule-tab[data-view="day"]').setAttribute('data-state', 'active'); renderAll(); showToast('Showing available slots for today'); });

// Listen for regional settings changes
window.addEventListener('meditrack-setting-changed', function(e) {
    if (e.detail && (e.detail.key === 'first_day' || e.detail.key === 'show_weekends')) {
        renderAll();
    }
});
window.addEventListener('meditrack-weekends-changed', function() {
    renderAll();
});

// ==================== INITIALIZATION ====================
populateFilters();
renderCalendar();
updateScheduleTitle();
renderDayView();
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
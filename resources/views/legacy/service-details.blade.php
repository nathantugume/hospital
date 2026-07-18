<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | MRI Scan - Service Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <style>

        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card { background-color: #131212 !important; }
        body.dark .border-gray-200, body.dark .border-gray-300 { border-color: #333333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted { background-color: #262626 !important; }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        @media print {
            header, aside, .no-print, .action-buttons, .tab-buttons, .print-hide {
                display: none !important;
            }
            main {
                margin-left: 0 !important;
                padding: 20px !important;
            }
            .rounded-lg, .shadow-sm {
                box-shadow: none !important;
                border: 1px solid #e5e7eb !important;
            }
        }

        /* Modal styles */
.modal-backdrop {
    position: fixed;
    inset: 0;
    background-color: rgb(0 0 0 / 87%);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}
.modal-content {
    background: white;
    border-radius: 0.75rem;
    max-width: 500px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
}
body.dark .modal-content {
    background: #131212;
    border-color: #333;
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
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="add-doctor.html">Add Doctor</a>
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="schedule.html">Doctor Schedule</a>
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="specialisation.html">Specializations</a>
                            </div>
                        </div>

                        <!-- Patients (active link, no accordion) -->
                        <div class="space-y-1 custom-scrollbar">
                            <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors bg-indigo-50 text-indigo-700" href="patients.html">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round mr-2 h-4 w-4"><circle cx="12" cy="8" r="5"></circle><path d="M20 21a8 8 0 0 0-16 0"></path></svg>
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
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="create-prescription.html">Create Prescription</a>
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="medicine-templates.html">Medicine Templates</a>
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
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="add-blood-unit.html">Add Blood Unit</a>
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="issue-blood.html">Issue Blood</a>
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
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="create-invoice.html">Create Invoice</a>
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
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="add-department.html">Add Department</a>
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
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="add-inventory.html">Add Item</a>
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="stock-alerts.html">Stock Alerts</a>
                                <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="suppliers.html">Suppliers List</a>
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
                <!-- Header -->
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-2">
                        <a class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap rounded-md text-sm font-medium border border-input bg-background hover:bg-accent hover:text-accent-foreground size-10" href="services.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left h-4 w-4"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                        </a>
                        <h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">MRI Scan</h1>
                        <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold">Diagnostic</div>
                    </div>
                    <div class="flex gap-2 flex-wrap action-buttons no-print">
                        <button id="printBtn" class="inline-flex items-center justify-center gap-2 rounded-md border border-input bg-background hover:bg-accent h-10 px-4 py-2 text-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-printer mr-2 h-4 w-4"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"></path><rect x="6" y="14" width="12" height="8" rx="1"></rect></svg>Print</button>
                        <button class="inline-flex items-center justify-center gap-2 rounded-md border border-input bg-background hover:bg-accent h-10 px-4 py-2 text-sm"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-share2 mr-2 h-4 w-4"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"></line><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"></line></svg>Share</button>
                        <a class="inline-flex items-center justify-center gap-2 rounded-md bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 text-sm" href="edit-services.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen mr-2 h-4 w-4"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path></svg>Edit Service</a>
                    </div>
                </div>

                <!-- Service Info and Stats -->
                <div class="grid gap-6 md:grid-cols-3">
                    <div class="rounded-lg border bg-background shadow-sm md:col-span-2">
                        <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Service Information</h2><div class="text-gray-500">Detailed information about MRI Scan</div></div>
                        <div class="p-4 space-y-4">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div><div class="text-sm font-medium text-gray-500">Department</div><div>Radiology</div></div>
                                <div><div class="text-sm font-medium text-gray-500">Service Type</div><div>Diagnostic</div></div>
                                <div><div class="text-sm font-medium text-gray-500">Duration</div><div class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock mr-2 h-4 w-4 text-gray-500"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>45 minutes</div></div>
                                <div><div class="text-sm font-medium text-gray-500">Price</div><div class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dollar-sign mr-2 h-4 w-4 text-gray-500"><line x1="12" x2="12" y1="2" y2="22"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>$850</div></div>
                            </div>
                            <div><div class="text-sm font-medium text-gray-500">Description</div><p>Magnetic Resonance Imaging (MRI) is a non-invasive imaging technology that produces three-dimensional detailed anatomical images. It is often used for disease detection, diagnosis, and treatment monitoring.</p></div>
                            <div><div class="text-sm font-medium text-gray-500">Patient Preparation</div><p>You may be asked not to eat or drink for 4-6 hours before the scan. If you have any metal implants, please inform the staff beforehand.</p></div>
                        </div>
                    </div>

                    <div class="rounded-lg border bg-background shadow-sm">
                        <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Service Statistics</h2><div class="text-gray-500">Performance metrics for this month</div></div>
                        <div class="p-4 space-y-4">
                            <div><div class="flex justify-between text-sm"><span class="font-medium text-gray-500">Appointments</span><span>124</span></div><div class="mt-1 h-2 w-full bg-gray-200 rounded-full"><div class="h-2 bg-primary rounded-full" style="width: 75%"></div></div></div>
                            <div><div class="flex justify-between text-sm"><span class="font-medium text-gray-500">Average Rating</span><div class="flex items-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star mr-1 h-4 w-4 fill-yellow-400 text-yellow-400"><path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"></path></svg>4.5/5</div></div><div class="mt-1 h-2 w-full bg-gray-200 rounded-full"><div class="h-2 bg-primary rounded-full" style="width: 90%"></div></div></div>
                            <div><div class="flex justify-between text-sm"><span class="font-medium text-gray-500">Revenue</span><span>$105,400</span></div><div class="mt-1 h-2 w-full bg-gray-200 rounded-full"><div class="h-2 bg-primary rounded-full" style="width: 80%"></div></div></div>
                            <div class="flex items-center justify-between rounded-md bg-gray-100 p-3"><span class="text-sm font-medium">Growth Rate</span><span class="text-sm font-medium text-green-500">+8.5%</span></div>
                        </div>
                        <div class="p-4 pt-0"><button id="viewAnalyticsBtn" class="border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 rounded-md text-sm w-full">View Detailed Analytics</button></div>
                    </div>
                </div>

                <!-- Tabs Section -->
                <div dir="ltr" class="w-full">
                    <div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1 tab-buttons">
                        <button data-tab="availability" class="service-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all bg-background text-indigo-700 shadow-sm">Availability</button>
                        <button data-tab="providers" class="service-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium text-gray-600">Service Providers</button>
                        <button data-tab="equipment" class="service-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium text-gray-600">Equipment</button>
                        <button data-tab="reviews" class="service-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium text-gray-600">Reviews</button>
                    </div>

                    <!-- Availability Tab Content -->
                    <div id="tab-availability" class="tab-content active mt-4">
                        <div class="rounded-lg border bg-background shadow-sm">
                            <div class="p-4 border-b flex flex-row items-center justify-between flex-wrap gap-3">
                                <div><h2 class="text-xl font-semibold tracking-tight">Service Availability</h2><div class="text-gray-500">When this service is available for booking</div></div>
                                <a class="inline-flex items-center justify-center gap-2 rounded-md bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 text-sm" href="availability.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar mr-2 h-4 w-4"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>Manage Schedule</a>
                            </div>
                            <div class="p-4 overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-50 border-b"><tr><th class="h-12 px-4 text-left">Day</th><th class="h-12 px-4 text-left">Available Slots</th><th class="h-12 px-4 text-right">Actions</th></tr></thead>
                                    <tbody>
                                        <tr class="border-b"><td class="p-4 font-medium">Monday</td><td class="p-4"><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold mr-2 mb-2">09:00 AM - 11:00 AM</span><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold mr-2 mb-2">02:00 PM - 04:00 PM</span></td><td class="p-4 text-right"><button class="edit-slot-btn hover:bg-gray-100 p-1 rounded"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path><path d="m15 5 4 4"></path></svg></button></td></tr>
                                        <tr class="border-b"><td class="p-4 font-medium">Tuesday</td><td class="p-4"><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold mr-2 mb-2">09:00 AM - 11:00 AM</span><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold mr-2 mb-2">02:00 PM - 04:00 PM</span></td><td class="p-4 text-right"><button class="edit-slot-btn hover:bg-gray-100 p-1 rounded"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path><path d="m15 5 4 4"></path></svg></button></td></tr>
                                        <tr class="border-b"><td class="p-4 font-medium">Wednesday</td><td class="p-4"><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold mr-2 mb-2">09:00 AM - 11:00 AM</span><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold mr-2 mb-2">02:00 PM - 04:00 PM</span></td><td class="p-4 text-right"><button class="edit-slot-btn hover:bg-gray-100 p-1 rounded"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path><path d="m15 5 4 4"></path></svg></button></td></tr>
                                        <tr class="border-b"><td class="p-4 font-medium">Thursday</td><td class="p-4"><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold mr-2 mb-2">09:00 AM - 11:00 AM</span><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold mr-2 mb-2">02:00 PM - 04:00 PM</span></td><td class="p-4 text-right"><button class="edit-slot-btn hover:bg-gray-100 p-1 rounded"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path><path d="m15 5 4 4"></path></svg></button></td></tr>
                                        <tr class="border-b"><td class="p-4 font-medium">Friday</td><td class="p-4"><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold mr-2 mb-2">09:00 AM - 11:00 AM</span><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold mr-2 mb-2">02:00 PM - 04:00 PM</span></td><td class="p-4 text-right"><button class="edit-slot-btn hover:bg-gray-100 p-1 rounded"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path><path d="m15 5 4 4"></path></svg></button></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Service Providers Tab Content -->
                    <div id="tab-providers" class="tab-content hidden mt-4">
                        <div class="rounded-lg border bg-background shadow-sm">
                            <div class="p-4 border-b flex flex-row items-center justify-between flex-wrap gap-3">
                                <div><h2 class="text-xl font-semibold tracking-tight">Service Providers</h2><div class="text-gray-500">Staff who can perform this service</div></div>
                                <button id="addProviderBtn" class="inline-flex items-center gap-2 rounded-md bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 text-sm"><svg class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5v14"></path></svg>Add Provider</button>
                            </div>
                            <div class="p-4">
                                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                                    <div class="rounded-lg border bg-background shadow-sm">
                                        <div class="p-6 pt-6"><div class="flex flex-col items-center text-center"><img src="user.png" class="h-20 w-20 rounded-full object-cover" alt="User profile photo"><h3 class="mt-4 text-lg font-medium">Dr. Nakato Sarah</h3><p class="text-gray-500">Radiologist</p><div class="mt-4 flex gap-2"><button class="view-provider-btn border rounded-md px-3 py-1.5 text-sm">View Profile</button><button class="contact-provider-btn border rounded-md px-3 py-1.5 text-sm">Contact</button></div></div></div>
                                    </div>
                                    <div class="rounded-lg border bg-background shadow-sm">
                                        <div class="p-6 pt-6"><div class="flex flex-col items-center text-center"><img src="user.png" class="h-20 w-20 rounded-full object-cover" alt="User profile photo"><h3 class="mt-4 text-lg font-medium">Dr. Mwangi Peter</h3><p class="text-gray-500">Radiologist</p><div class="mt-4 flex gap-2"><button class="view-provider-btn border rounded-md px-3 py-1.5 text-sm">View Profile</button><button class="contact-provider-btn border rounded-md px-3 py-1.5 text-sm">Contact</button></div></div></div>
                                    </div>
                                    <div class="rounded-lg border bg-background shadow-sm">
                                        <div class="p-6 pt-6"><div class="flex flex-col items-center text-center"><img src="user.png" class="h-20 w-20 rounded-full object-cover" alt="User profile photo"><h3 class="mt-4 text-lg font-medium">Dr. Wanjiru Emily</h3><p class="text-gray-500">Neuroradiologist</p><div class="mt-4 flex gap-2"><button class="view-provider-btn border rounded-md px-3 py-1.5 text-sm">View Profile</button><button class="contact-provider-btn border rounded-md px-3 py-1.5 text-sm">Contact</button></div></div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Equipment Tab Content -->
                    <div id="tab-equipment" class="tab-content hidden mt-4">
                        <div class="rounded-lg border bg-background shadow-sm">
                            <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Equipment</h2><div class="text-gray-500">Equipment used for this service</div></div>
                            <div class="p-4 overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-50 border-b"><tr><th class="h-12 px-4 text-left">Equipment Name</th><th class="h-12 px-4 text-left">Status</th><th class="h-12 px-4 text-left">Last Maintenance</th><th class="h-12 px-4 text-right">Actions</th></tr></thead>
                                    <tbody>
                                        <tr class="border-b"><td class="p-4 font-medium">Siemens MAGNETOM Vida 3T</td><td class="p-4"><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-50 text-green-700">Operational</span></td><td class="p-4">2023-03-15</td><td class="p-4 text-right"><button class="view-equipment-btn hover:bg-gray-100 p-1 rounded"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg></button></td></tr>
                                        <tr class="border-b"><td class="p-4 font-medium">GE Healthcare SIGNA Pioneer 3.0T</td><td class="p-4"><span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-50 text-green-700">Operational</span></td><td class="p-4">2023-02-28</td><td class="p-4 text-right"><button class="view-equipment-btn hover:bg-gray-100 p-1 rounded"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg></button></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

<!-- Reviews Tab Content -->
<div id="tab-reviews" class="tab-content hidden mt-4">
    <div class="rounded-lg border bg-background shadow-sm">
        <div class="p-4 border-b flex flex-row items-center justify-between flex-wrap gap-3">
            <div><h2 class="text-xl font-semibold tracking-tight">Patient Reviews</h2><div class="text-gray-500">What patients are saying about this service</div></div>
            <div class="flex items-center"><svg class="h-4 w-4 mr-1 fill-yellow-400 text-yellow-400" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg><span class="font-medium">4.5</span><span class="ml-1 text-gray-500">/ 5</span></div>
        </div>
        <div class="p-4 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs">Date</th>
                        <th class="px-4 py-3 text-left text-sm">Visit Type</th>
                        <th class="px-4 py-3 text-left">Rating</th>
                        <th class="px-4 py-3 text-left text-sm">Duration</th>
                        <th class="px-4 py-3 text-left text-sm">Review</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-xs">2026-05-28</td>
                        <td class="px-4 py-3 text-sm">Outpatient clinic</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-0.5">
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <svg class="h-4 w-4 text-gray-300" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm"><span class="px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700">45 min</span></td>
                        <td class="px-4 py-3 text-sm max-w-[300px] truncate">"Very thorough examination, staff was professional and caring."</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-xs">2026-05-25</td>
                        <td class="px-4 py-3 text-sm">Inpatient</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-0.5">
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm"><span class="px-2 py-0.5 rounded-full bg-green-100 text-green-700">30 min</span></td>
                        <td class="px-4 py-3 text-sm max-w-[300px] truncate">"Excellent service, the doctor explained everything clearly."</td>
                    </tr>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-3 text-xs">2026-05-20</td>
                        <td class="px-4 py-3 text-sm">Emergency</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-0.5">
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                                <svg class="h-4 w-4 text-gray-300" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm"><span class="px-2 py-0.5 rounded-full bg-red-100 text-red-700">60 min</span></td>
                        <td class="px-4 py-3 text-sm max-w-[300px] truncate">"Good experience overall, but had to wait a bit longer than expected."</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-4 pt-0"><button id="viewAllReviewsBtn" class="border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 rounded-md text-sm w-full">View All Reviews</button></div>
    </div>
</div>
                </div>

                <!-- Related Services -->
                <div class="space-y-4">
                    <h2 class="text-2xl font-bold tracking-tight mb-2">Related Services</h2>
                    <div class="grid gap-4 md:grid-cols-3">
                        <div class="rounded-lg border bg-background shadow-sm"><div class="p-4"><h3 class="text-lg font-semibold">CT Scan</h3><div class="text-gray-500">Radiology</div><div class="mt-2 flex items-center"><svg class="h-4 w-4 mr-2 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="2" y2="22"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg><span>$650</span></div><a class="inline-flex items-center justify-center mt-3 w-full border rounded-md px-4 py-2 text-sm" href="service-details.html">View Details</a></div></div>
                        <div class="rounded-lg border bg-background shadow-sm"><div class="p-4"><h3 class="text-lg font-semibold">X-Ray</h3><div class="text-gray-500">Radiology</div><div class="mt-2 flex items-center"><svg class="h-4 w-4 mr-2 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="2" y2="22"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg><span>$150</span></div><a class="inline-flex items-center justify-center mt-3 w-full border rounded-md px-4 py-2 text-sm" href="service-details.html">View Details</a></div></div>
                        <div class="rounded-lg border bg-background shadow-sm"><div class="p-4"><h3 class="text-lg font-semibold">Ultrasound</h3><div class="text-gray-500">Radiology</div><div class="mt-2 flex items-center"><svg class="h-4 w-4 mr-2 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" x2="12" y1="2" y2="22"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg><span>$250</span></div><a class="inline-flex items-center justify-center mt-3 w-full border rounded-md px-4 py-2 text-sm" href="service-details.html">View Details</a></div></div>
                    </div>
                </div>
            </div>
        </main>
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


<!-- Add Time Slot Modal -->
<div id="addSlotModal" class="modal-backdrop" style="display: none;">
    <div class="modal-content p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Add Time Slot</h2>
            <button id="closeSlotModalBtn" class="text-gray-500 hover:text-gray-700 text-2xl">×</button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="text-sm font-medium">Day</label>
                <div class="relative w-full mt-1">
                    <button type="button" id="slotDayBtn" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-background px-3 py-2 text-sm ring-offset-background focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <span id="slotDaySelected">Monday</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  class="ml-2 h-4 w-4 opacity-50"><path d="m6 9 6 6 6-6"></path></svg>
                    </button>
                    <div id="slotDayDropdown" class="hidden absolute z-50 mt-1 w-full rounded-md border border-gray-200 bg-background shadow-lg overflow-hidden">
                        <div class="py-1">
                            <div data-value="Monday" class="slot-day-option cursor-pointer px-3 py-2 text-sm hover:bg-gray-100">Monday</div>
                            <div data-value="Tuesday" class="slot-day-option cursor-pointer px-3 py-2 text-sm hover:bg-gray-100">Tuesday</div>
                            <div data-value="Wednesday" class="slot-day-option cursor-pointer px-3 py-2 text-sm hover:bg-gray-100">Wednesday</div>
                            <div data-value="Thursday" class="slot-day-option cursor-pointer px-3 py-2 text-sm hover:bg-gray-100">Thursday</div>
                            <div data-value="Friday" class="slot-day-option cursor-pointer px-3 py-2 text-sm hover:bg-gray-100">Friday</div>
                        </div>
                    </div>
                </div>
            </div>
            <div><label class="text-sm font-medium">Start Time</label><input type="time" id="startTime" class="w-full mt-1 rounded-md border border-gray-300 px-3 py-2" value="09:00"></div>
            <div><label class="text-sm font-medium">End Time</label><input type="time" id="endTime" class="w-full mt-1 rounded-md border border-gray-300 px-3 py-2" value="11:00"></div>
            <div class="flex justify-end gap-3 pt-4">
                <button id="cancelSlotBtn" class="px-4 py-2 rounded-md border  hover:bg-accent hover:text-accent-foreground h-10">Cancel</button>
                <button id="saveSlotBtn" class="px-4 py-2 rounded-md bg-primary text-white hover:bg-primary/90">Add Slot</button>
            </div>
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


    // Tab switching functionality
    const tabs = document.querySelectorAll('.service-tab');
    const tabContents = {
        availability: document.getElementById('tab-availability'),
        providers: document.getElementById('tab-providers'),
        equipment: document.getElementById('tab-equipment'),
        reviews: document.getElementById('tab-reviews')
    };

    function activateTab(tabId) {
        Object.keys(tabContents).forEach(key => {
            if (tabContents[key]) {
                tabContents[key].classList.add('hidden');
                tabContents[key].classList.remove('active');
            }
        });
        if (tabContents[tabId]) {
            tabContents[tabId].classList.remove('hidden');
            tabContents[tabId].classList.add('active');
        }
        
        tabs.forEach(tab => {
            const isActive = tab.dataset.tab === tabId;
            if (isActive) {
                tab.classList.add('bg-white', 'text-indigo-700', 'shadow-sm');
                tab.classList.remove('text-gray-600');
            } else {
                tab.classList.remove('bg-white', 'text-indigo-700', 'shadow-sm');
                tab.classList.add('text-gray-600');
            }
        });
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', (e) => {
            e.preventDefault();
            const tabId = tab.dataset.tab;
            if (tabId && tabContents[tabId]) {
                activateTab(tabId);
            }
        });
    });

    activateTab('availability');

    // Modal functionality
    const modal = document.getElementById('addSlotModal');
    let currentRow = null;
    let currentDay = '';

    // Day dropdown functionality
    const slotDayBtn = document.getElementById('slotDayBtn');
    const slotDayDropdown = document.getElementById('slotDayDropdown');
    const slotDaySelected = document.getElementById('slotDaySelected');

    slotDayBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        slotDayDropdown?.classList.toggle('hidden');
    });

    document.querySelectorAll('.slot-day-option').forEach(option => {
        option.addEventListener('click', () => {
            const dayValue = option.dataset.value;
            slotDaySelected.innerText = dayValue;
            slotDayDropdown.classList.add('hidden');
            currentDay = dayValue;
        });
    });

    document.addEventListener('click', (e) => {
        if (!slotDayBtn?.contains(e.target) && !slotDayDropdown?.contains(e.target)) {
            slotDayDropdown?.classList.add('hidden');
        }
    });

    // Open modal when edit button is clicked
    function openModal(day, rowElement) {
        currentRow = rowElement;
        currentDay = day;
        slotDaySelected.innerText = day;
        modal.style.display = 'flex';
    }

    function closeModal() {
        modal.style.display = 'none';
        currentRow = null;
        currentDay = '';
        // Reset form
        document.getElementById('startTime').value = '09:00';
        document.getElementById('endTime').value = '11:00';
    }

    // Add click handlers to edit slot buttons
    document.querySelectorAll('.edit-slot-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const row = btn.closest('tr');
            const day = row.querySelector('td:first-child')?.innerText || 'Monday';
            openModal(day, row);
        });
    });

    // Modal close handlers
    document.getElementById('closeSlotModalBtn')?.addEventListener('click', closeModal);
    document.getElementById('cancelSlotBtn')?.addEventListener('click', closeModal);
    
    // Click outside modal to close
    modal?.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });

    // Save slot handler
    document.getElementById('saveSlotBtn')?.addEventListener('click', () => {
        const startTime = document.getElementById('startTime').value;
        const endTime = document.getElementById('endTime').value;
        const selectedDay = slotDaySelected.innerText;
        
        if (currentRow) {
            // Update the day if changed
            if (currentDay !== selectedDay) {
                const dayCell = currentRow.querySelector('td:first-child');
                if (dayCell) dayCell.innerText = selectedDay;
            }
            
            // Add the new time slot
            const slotsContainer = currentRow.querySelector('td:nth-child(2)');
            const newSlot = document.createElement('span');
            newSlot.className = 'inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold mr-2 mb-2';
            newSlot.textContent = `${startTime} - ${endTime}`;
            slotsContainer.appendChild(newSlot);
        } else {
            // Find or create row for the selected day
            const table = document.querySelector('#tab-availability table tbody');
            let targetRow = null;
            
            for (let row of table.querySelectorAll('tr')) {
                const dayCell = row.querySelector('td:first-child');
                if (dayCell && dayCell.innerText === selectedDay) {
                    targetRow = row;
                    break;
                }
            }
            
            if (targetRow) {
                const slotsContainer = targetRow.querySelector('td:nth-child(2)');
                const newSlot = document.createElement('span');
                newSlot.className = 'inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold mr-2 mb-2';
                newSlot.textContent = `${startTime} - ${endTime}`;
                slotsContainer.appendChild(newSlot);
            }
        }
        
        closeModal();
    });

    // Print functionality
    document.getElementById('printBtn')?.addEventListener('click', () => {
        window.print();
    });

    // Share button - copy URL to clipboard
document.querySelector('button .lucide-share2')?.closest('button')?.addEventListener('click', () => {
    navigator.clipboard.writeText(window.location.href).then(() => {
        showToast('URL copied to clipboard!');
    }).catch(() => {
        showToast('Failed to copy URL', true);
    });
});




    // Other button handlers (no alerts)
// View Detailed Analytics button - opens analytics modal
document.getElementById('viewAnalyticsBtn')?.addEventListener('click', () => {
    const modal = document.createElement('div');
    modal.className = 'modal-backdrop';
    modal.style.cssText = 'position:fixed;inset:0;background:rgb(0 0 0 / 87%);z-index:1000;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);';
    modal.innerHTML = `
        <div style="background:white;border-radius:0.75rem;width:90%;max-width:650px;max-height:85vh;overflow-y:auto;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
            <div style="display:flex;justify-content:space-between;align-items:center;padding:1.25rem 1.5rem;border-bottom:1px solid #e5e7eb;">
                <h2 style="font-size:1.125rem;font-weight:600;">MRI Scan - Detailed Analytics</h2>
                <button class="close-analytics-modal" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#6b7280;">&times;</button>
            </div>
            <div style="padding:1.5rem;">
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-bottom:1.5rem;">
                    <div style="background:#f0fdf4;padding:1rem;border-radius:0.5rem;text-align:center;">
                        <p style="font-size:1.5rem;font-weight:700;color:#16a34a;">124</p><p style="font-size:0.75rem;color:#6b7280;">Total Appointments</p>
                    </div>
                    <div style="background:#eff6ff;padding:1rem;border-radius:0.5rem;text-align:center;">
                        <p style="font-size:1.5rem;font-weight:700;color:#2563eb;">$105.4k</p><p style="font-size:0.75rem;color:#6b7280;">Monthly Revenue</p>
                    </div>
                    <div style="background:#fefce8;padding:1rem;border-radius:0.5rem;text-align:center;">
                        <p style="font-size:1.5rem;font-weight:700;color:#ca8a04;">4.5/5</p><p style="font-size:0.75rem;color:#6b7280;">Avg Rating</p>
                    </div>
                </div>
                <div style="border:1px solid #e5e7eb;border-radius:0.5rem;padding:1rem;">
                    <h3 style="font-weight:600;margin-bottom:0.75rem;">Monthly Trends</h3>
                    <div style="height:200px;display:flex;align-items:flex-end;gap:12px;padding:0 10px;">
                        ${['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'].map((m,i) => {
                            const height = Math.floor(Math.random() * 150) + 30;
                            return `<div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:4px;">
                                <span style="font-size:0.65rem;color:#6b7280;">${Math.floor(height/2)}</span>
                                <div style="width:100%;height:${height}px;background:linear-gradient(180deg,#4f46e5,#818cf8);border-radius:4px 4px 0 0;"></div>
                                <span style="font-size:0.65rem;color:#6b7280;">${m}</span>
                            </div>`;
                        }).join('')}
                    </div>
                </div>
            </div>
            <div style="display:flex;justify-content:flex-end;padding:1rem 1.5rem;border-top:1px solid #e5e7eb;">
                <button class="close-analytics-modal" style="background:#4f46e5;color:white;border:none;border-radius:0.375rem;padding:0.5rem 1rem;font-size:0.875rem;cursor:pointer;">Close</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    const closeModal = () => modal.remove();
    modal.querySelectorAll('.close-analytics-modal').forEach(b => b.addEventListener('click', closeModal));
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
});    


// Add Provider modal with photo upload
document.getElementById('addProviderBtn')?.addEventListener('click', () => {
    const modal = document.createElement('div');
    modal.className = 'modal-backdrop';
    modal.style.cssText = 'position:fixed;inset:0;background:rgb(0 0 0 / 87%);z-index:1000;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);';
    modal.innerHTML = `
        <div style="background:white;border-radius:0.75rem;width:90%;max-width:550px;max-height:85vh;overflow-y:auto;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
            <div style="display:flex;justify-content:space-between;align-items:center;padding:1.25rem 1.5rem;border-bottom:1px solid #e5e7eb;">
                <h2 style="font-size:1.125rem;font-weight:600;">Add Service Provider</h2>
                <button class="close-provider-modal" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#6b7280;">&times;</button>
            </div>
            <div style="padding:1.5rem;">
                <div style="display:flex;flex-direction:column;gap:1.25rem;">
                    
                    <!-- Photo Upload Section -->
                    <div>
                        <label style="font-size:0.875rem;font-weight:500;display:block;margin-bottom:0.5rem;">Provider Photo</label>
                        <div style="display:flex;align-items:center;gap:1rem;">
                            <div id="photoPreviewContainer" style="position:relative;width:80px;height:80px;border-radius:50%;background:#f3f4f6;border:2px dashed #d1d5db;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
                                <svg id="defaultPhotoIcon" style="width:2rem;height:2rem;color:#9ca3af;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                <img id="photoPreview" src="user.png" alt="Preview" style="display:none;width:100%;height:100%;object-fit:cover;position:absolute;inset:0;">
                            </div>
                            <div style="display:flex;flex-direction:column;gap:0.5rem;">
                                <label for="providerPhoto" style="display:inline-flex;align-items:center;gap:0.5rem;background:white;border:1px solid #d1d5db;border-radius:0.375rem;padding:0.5rem 0.75rem;font-size:0.75rem;cursor:pointer;color:#374151;transition:background 0.15s;">
                                    <svg style="width:0.875rem;height:0.875rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                                    Upload Photo
                                </label>
                                <input type="file" id="providerPhoto" accept="image/*" style="display:none;">
                                <button id="removePhotoBtn" style="display:none;background:none;border:none;font-size:0.75rem;color:#ef4444;cursor:pointer;padding:0;">Remove photo</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Provider Name -->
                    <div>
                        <label style="font-size:0.875rem;font-weight:500;display:block;margin-bottom:0.25rem;">Provider Name *</label>
                        <input type="text" id="providerName" class="form-input" style="width:100%;border-radius:0.375rem;border:1px solid #d1d5db;padding:0.5rem 0.75rem;font-size:0.875rem;box-sizing:border-box;" placeholder="e.g., Dr. Nabukenya Jane">
                    </div>
                    
                    <!-- Specialization -->
                    <div>
                        <label style="font-size:0.875rem;font-weight:500;display:block;margin-bottom:0.25rem;">Specialization *</label>
                        <input type="text" id="providerSpecialty" class="form-input" style="width:100%;border-radius:0.375rem;border:1px solid #d1d5db;padding:0.5rem 0.75rem;font-size:0.875rem;box-sizing:border-box;" placeholder="e.g., Radiologist">
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label style="font-size:0.875rem;font-weight:500;display:block;margin-bottom:0.25rem;">Email</label>
                        <input type="email" id="providerEmail" class="form-input" style="width:100%;border-radius:0.375rem;border:1px solid #d1d5db;padding:0.5rem 0.75rem;font-size:0.875rem;box-sizing:border-box;" placeholder="provider@hmail.com">
                    </div>
                    
                    <!-- Phone -->
                    <div>
                        <label style="font-size:0.875rem;font-weight:500;display:block;margin-bottom:0.25rem;">Phone</label>
                        <input type="tel" id="providerPhone" class="form-input" style="width:100%;border-radius:0.375rem;border:1px solid #d1d5db;padding:0.5rem 0.75rem;font-size:0.875rem;box-sizing:border-box;" placeholder="+1 (555) 000-0000">
                    </div>
                    
                    <!-- Availability Status -->
                    <div>
                        <label style="font-size:0.875rem;font-weight:500;display:block;margin-bottom:0.25rem;">Availability</label>
                        <div style="display:flex;gap:1rem;">
                            <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                                <input type="radio" name="availability" value="available" checked style="accent-color:#4f46e5;">
                                <span style="font-size:0.875rem;">Available</span>
                            </label>
                            <label style="display:flex;align-items:center;gap:0.5rem;cursor:pointer;">
                                <input type="radio" name="availability" value="unavailable" style="accent-color:#4f46e5;">
                                <span style="font-size:0.875rem;">Unavailable</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Notes -->
                    <div>
                        <label style="font-size:0.875rem;font-weight:500;display:block;margin-bottom:0.25rem;">Notes</label>
                        <textarea id="providerNotes" style="width:100%;border-radius:0.375rem;border:1px solid #d1d5db;padding:0.5rem 0.75rem;font-size:0.875rem;resize:vertical;min-height:60px;box-sizing:border-box;" placeholder="Any additional notes about this provider..."></textarea>
                    </div>
                </div>
            </div>
            <div style="display:flex;justify-content:flex-end;gap:0.75rem;padding:1rem 1.5rem;border-top:1px solid #e5e7eb;">
                <button class="close-provider-modal" style="background:white;border:1px solid #d1d5db;border-radius:0.375rem;padding:0.5rem 1rem;font-size:0.875rem;cursor:pointer;">Cancel</button>
                <button id="saveProviderBtn" style="background:#4f46e5;color:white;border:none;border-radius:0.375rem;padding:0.5rem 1rem;font-size:0.875rem;cursor:pointer;">Add Provider</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    
    // Photo upload functionality
    const photoInput = modal.querySelector('#providerPhoto');
    const photoPreview = modal.querySelector('#photoPreview');
    const defaultIcon = modal.querySelector('#defaultPhotoIcon');
    const removeBtn = modal.querySelector('#removePhotoBtn');
    
    photoInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                photoPreview.src = event.target.result;
                photoPreview.style.display = 'block';
                defaultIcon.style.display = 'none';
                removeBtn.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
    
    removeBtn.addEventListener('click', () => {
        photoPreview.src = '#';
        photoPreview.style.display = 'none';
        defaultIcon.style.display = 'block';
        removeBtn.style.display = 'none';
        photoInput.value = '';
    });
    
    // Close handlers
    const closeModal = () => modal.remove();
    modal.querySelectorAll('.close-provider-modal').forEach(b => b.addEventListener('click', closeModal));
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
    
    // Save handler
    modal.querySelector('#saveProviderBtn')?.addEventListener('click', () => {
        const name = modal.querySelector('#providerName').value.trim();
        const specialty = modal.querySelector('#providerSpecialty').value.trim();
        const email = modal.querySelector('#providerEmail').value.trim();
        const phone = modal.querySelector('#providerPhone').value.trim();
        const availability = modal.querySelector('input[name="availability"]:checked')?.value;
        const notes = modal.querySelector('#providerNotes').value.trim();
        const hasPhoto = photoPreview.style.display === 'block';
        
        if (!name) { showToast('Please enter provider name', true); return; }
        if (!specialty) { showToast('Please enter specialization', true); return; }
        
        let message = `Provider "${name}" added successfully!`;
        if (hasPhoto) message += ' (with photo)';
        showToast(message);
        closeModal();
    });
    
    // Close on Escape
    const escHandler = (e) => {
        if (e.key === 'Escape') { closeModal(); document.removeEventListener('keydown', escHandler); }
    };
    document.addEventListener('keydown', escHandler);
});

// View All Reviews - redirect to survey-responses.html
document.getElementById('viewAllReviewsBtn')?.addEventListener('click', () => {
    window.location.href = 'survey-responses.html';
});


// View Provider Profile - redirect to staff-profile.html
// View Provider Profile - opens provider details modal
document.querySelectorAll('.view-provider-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const card = btn.closest('.rounded-lg');
        const name = card?.querySelector('h3')?.innerText || 'Provider';
        const specialty = card?.querySelector('.text-gray-500')?.innerText || 'Specialist';
        const imgSrc = card?.querySelector('img')?.src || 'user.png';
        
        // Create modal
        const modal = document.createElement('div');
        modal.className = 'modal-backdrop';
        modal.style.cssText = 'position:fixed;inset:0;background:rgb(0 0 0 / 87%);z-index:1000;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);';
        
        modal.innerHTML = `
            <div style="background:white;border-radius:0.75rem;width:90%;max-width:550px;max-height:85vh;overflow-y:auto;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);">
                <div style="display:flex;justify-content:space-between;align-items:center;padding:1.25rem 1.5rem;border-bottom:1px solid #e5e7eb;">
                    <h2 style="font-size:1.125rem;font-weight:600;">Provider Profile</h2>
                    <button class="close-view-modal" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#6b7280;">&times;</button>
                </div>
                <div style="padding:1.5rem;">
                    <!-- Provider Header -->
                    <div style="display:flex;flex-direction:column;align-items:center;text-align:center;margin-bottom:1.5rem;">
                        <div style="width:100px;height:100px;border-radius:50%;overflow:hidden;border:3px solid #e0e7ff;margin-bottom:0.75rem;">
                            <img src="user.png" alt="${name}" style="width:100%;height:100%;object-fit:cover;" onerror="this.src="user.png"">
                        </div>
                        <h3 style="font-size:1.25rem;font-weight:600;margin:0;">${name}</h3>
                        <p style="color:#6b7280;font-size:0.875rem;margin:0.25rem 0 0.5rem 0;">${specialty}</p>
                        <span style="display:inline-flex;align-items:center;border-radius:9999px;padding:0.25rem 0.75rem;font-size:0.75rem;font-weight:600;background:#dcfce7;color:#166534;">Available</span>
                    </div>
                    
                    <!-- Provider Details Grid -->
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
                        <div style="background:#f9fafb;padding:0.75rem;border-radius:0.5rem;">
                            <p style="font-size:0.7rem;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 0.25rem 0;">Email</p>
                            <p style="font-size:0.875rem;font-weight:500;margin:0;">${name.toLowerCase().replace(' ', '.')}@hospital.ug</p>
                        </div>
                        <div style="background:#f9fafb;padding:0.75rem;border-radius:0.5rem;">
                            <p style="font-size:0.7rem;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 0.25rem 0;">Phone</p>
                            <p style="font-size:0.875rem;font-weight:500;margin:0;">+1 (555) 000-0000</p>
                        </div>
                        <div style="background:#f9fafb;padding:0.75rem;border-radius:0.5rem;">
                            <p style="font-size:0.7rem;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 0.25rem 0;">Department</p>
                            <p style="font-size:0.875rem;font-weight:500;margin:0;">Radiology</p>
                        </div>
                        <div style="background:#f9fafb;padding:0.75rem;border-radius:0.5rem;">
                            <p style="font-size:0.7rem;color:#6b7280;text-transform:uppercase;letter-spacing:0.5px;margin:0 0 0.25rem 0;">Experience</p>
                            <p style="font-size:0.875rem;font-weight:500;margin:0;">8+ years</p>
                        </div>
                    </div>
                    
                    <!-- Schedule -->
                    <div style="border-top:1px solid #e5e7eb;padding-top:1rem;margin-bottom:1.5rem;">
                        <h4 style="font-size:0.875rem;font-weight:600;margin:0 0 0.5rem 0;">Weekly Schedule</h4>
                        <div style="display:flex;flex-direction:column;gap:0.25rem;">
                            <div style="display:flex;justify-content:space-between;font-size:0.8rem;"><span style="color:#6b7280;">Mon - Wed:</span><span>9:00 AM - 5:00 PM</span></div>
                            <div style="display:flex;justify-content:space-between;font-size:0.8rem;"><span style="color:#6b7280;">Thu - Fri:</span><span>9:00 AM - 3:00 PM</span></div>
                            <div style="display:flex;justify-content:space-between;font-size:0.8rem;"><span style="color:#6b7280;">Sat - Sun:</span><span>Closed</span></div>
                        </div>
                    </div>
                    
                    <!-- Stats -->
                    <div style="display:flex;gap:1rem;margin-bottom:1.5rem;">
                        <div style="flex:1;background:#eff6ff;padding:0.75rem;border-radius:0.5rem;text-align:center;">
                            <p style="font-size:1.25rem;font-weight:700;color:#2563eb;margin:0;">1,245</p>
                            <p style="font-size:0.7rem;color:#6b7280;margin:0;">Patients Served</p>
                        </div>
                        <div style="flex:1;background:#f0fdf4;padding:0.75rem;border-radius:0.5rem;text-align:center;">
                            <p style="font-size:1.25rem;font-weight:700;color:#16a34a;margin:0;">4.8</p>
                            <p style="font-size:0.7rem;color:#6b7280;margin:0;">Avg Rating</p>
                        </div>
                        <div style="flex:1;background:#fefce8;padding:0.75rem;border-radius:0.5rem;text-align:center;">
                            <p style="font-size:1.25rem;font-weight:700;color:#ca8a04;margin:0;">98%</p>
                            <p style="font-size:0.7rem;color:#6b7280;margin:0;">Satisfaction</p>
                        </div>
                    </div>
                </div>
                <div style="display:flex;justify-content:flex-end;gap:0.75rem;padding:1rem 1.5rem;border-top:1px solid #e5e7eb;">
                    <button class="contact-view-btn" style="background:white;border:1px solid #d1d5db;border-radius:0.375rem;padding:0.5rem 1rem;font-size:0.875rem;cursor:pointer;">Contact</button>
                    <button class="close-view-modal" style="background:#4f46e5;color:white;border:none;border-radius:0.375rem;padding:0.5rem 1rem;font-size:0.875rem;cursor:pointer;">Close</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        const closeModal = () => modal.remove();
        modal.querySelectorAll('.close-view-modal').forEach(b => b.addEventListener('click', closeModal));
        modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
        
        // Contact button
        modal.querySelector('.contact-view-btn')?.addEventListener('click', () => {
            window.location.href = `mailto:${name.toLowerCase().replace(' ', '.')}@hospital.ug?subject=Regarding ${name}`;
        });
        
        // Escape key
        const escHandler = (e) => {
            if (e.key === 'Escape') { closeModal(); document.removeEventListener('keydown', escHandler); }
        };
        document.addEventListener('keydown', escHandler);
    });
});

// Contact Provider - opens email client
document.querySelectorAll('.contact-provider-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const card = btn.closest('.rounded-lg');
        const name = card?.querySelector('h3')?.innerText || 'Provider';
        window.location.href = `mailto:provider@hospital.ug?subject=Regarding ${name}`;
    });
});
    document.querySelectorAll('.contact-provider-btn').forEach(btn => {
        btn.addEventListener('click', () => {});
    });

    // View Equipment - redirect to lab-equipment-details.html
document.querySelectorAll('.view-equipment-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        const row = btn.closest('tr');
        const equipName = row?.querySelector('td:first-child')?.innerText || 'Equipment';
        window.location.href = `lab-equipment-details.html?name=${encodeURIComponent(equipName)}`;
    });
});

function showToast(message, isError = false) {
    const existing = document.querySelector('.toast-message');
    if (existing) existing.remove();
    const toast = document.createElement('div');
    toast.className = 'toast-message';
    toast.style.cssText = `position:fixed;bottom:20px;right:20px;background:${isError ? '#ef4444' : '#10b981'};color:white;padding:12px 20px;border-radius:8px;z-index:11000;animation:slideIn 0.3s ease-out;font-size:0.875rem;box-shadow:0 4px 12px rgba(0,0,0,0.15);`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}
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
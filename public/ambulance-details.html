<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Ambulance Details - AMB-002</title>
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <!-- Tailwind CSS -->
    <!-- <script src="https://cdn.tailwindcss.com" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="style.css">    
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        body { scrollbar-width: thin; background-color: #f9fafb; }
        
        /* Radix-style animations */
        .dropdown-content {
            animation: fadeInScale 0.12s ease-out;
            transform-origin: var(--radix-dropdown-menu-content-transform-origin);
        }
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        
        /* Radix Dropdown Menu */
        .radix-dropdown-menu {
            position: fixed;
            z-index: 50;
            min-width: 8rem;
            overflow: hidden;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
            background-color: white;
            padding: 0.25rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        .radix-menu-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            border-radius: 0.25rem;
            padding: 0.375rem 0.5rem;
            font-size: 0.875rem;
            transition: background-color 0.1s;
        }
        .radix-menu-item:hover { background-color: #f1f5f9; }
        .radix-separator { height: 1px; background-color: #e2e8f0; margin: 0.25rem 0; }
        
        /* Tab styling */
        .tab-trigger {
            transition: all 0.2s ease;
        }
        .tab-trigger.active {
            background-color: white;
            color: #1f2937;
            box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);
        }
        .tab-panel {
            animation: fadeIn 0.2s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Modal Styles */
        .modal-overlay {
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
        .modal-overlay.hidden { display: none; }
        .modal-container {
            background: white;
            border-radius: 0.75rem;
            width: 100%;
            max-width: 500px;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            animation: slideUp 0.2s ease;
        }
        body.dark .modal-container { background: #1e293b; border: 1px solid #334155; }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .modal-header { padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; }
        body.dark .modal-header { border-bottom-color: #334155; }
        .modal-title { font-size: 1.125rem; font-weight: 600; }
        .modal-body { padding: 1.5rem; }
        .modal-footer { padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 0.75rem; }
        body.dark .modal-footer { border-top-color: #334155; }
        .modal-close-btn { background: transparent; border: none; cursor: pointer; color: #6b7280; font-size: 1.25rem; line-height: 1; padding: 0; }
        .btn-secondary { background-color: #f3f4f6; color: #374151; padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; cursor: pointer; transition: background-color 0.1s; border: 1px solid #e5e7eb; }
        body.dark .btn-secondary { background-color: #374151; color: #e5e5e5; border-color: #4b5563; }
        
        /* Toast message */
        .toast-message {
            position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white;
            padding: 12px 20px; border-radius: 8px; z-index: 1100; font-size: 0.875rem;
            animation: slideIn 0.3s ease-out;
        }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }
        
        /* Status badge variants */
        .status-badge { display: inline-flex; align-items: center; border-radius: 9999px; padding: 0.25rem 0.625rem; font-size: 0.75rem; font-weight: 600; }
        .status-available { background-color: #dcfce7; color: #166534; }
        .status-on-call { background-color: #fef08a; color: #854d0e; }
        .status-on-maintenance { background-color: #fed7aa; color: #9a3412; }
        .status-out-of-service { background-color: #fee2e2; color: #991b1b; }
        body.dark .status-available { background-color: #14532d; color: #bbf7d0; }
        body.dark .status-on-call { background-color: #713f12; color: #fef08a; }
        body.dark .status-on-maintenance { background-color: #7c2d12; color: #fed7aa; }
        body.dark .status-out-of-service { background-color: #7f1d1d; color: #fecaca; }

        /* Status Update Modal Styles */
.modal-container {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 10002;
    background: white;
    border-radius: 0.75rem;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    animation: modalSlideIn 0.2s ease-out;
}
body.dark .modal-container {
    background: #1e293b;
    border: 1px solid #334155;
}
.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}
body.dark .modal-header {
    border-bottom-color: #334155;
}
.modal-title {
    font-size: 1.125rem;
    font-weight: 600;
}
.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #6b7280;
    line-height: 1;
    padding: 0;
}
.modal-close:hover {
    color: #1f2937;
}
body.dark .modal-close:hover {
    color: #e5e5e5;
}
.modal-body {
    padding: 1.5rem;
}
.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    border-top: 1px solid #e5e7eb;
}
body.dark .modal-footer {
    border-top-color: #334155;
}
.cancel-modal {
    background: transparent;
    border: 1px solid #d1d5db;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    cursor: pointer;
    font-size: 0.875rem;
}
.cancel-modal:hover {
    background-color: #f3f4f6;
}
body.dark .cancel-modal {
    border-color: #475569;
    color: #e5e5e5;
}
body.dark .cancel-modal:hover {
    background-color: #334155;
}

.cancel-modal {
    background: transparent;
    border: 1px solid #d1d5db;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    cursor: pointer;
    font-size: 0.875rem;
}
.cancel-modal:hover {
    background-color: #f3f4f6;
}
body.dark .cancel-modal {
    border-color: #475569;
    color: #e5e5e5;
}
body.dark .cancel-modal:hover {
    background-color: #334155;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #6b7280;
    line-height: 1;
    padding: 0;
}
.modal-close:hover {
    color: #1f2937;
}
body.dark .modal-close:hover {
    color: #e5e5e5;
}

/* Action Menu Styles */
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
body.dark .action-menu {
    background: #2a2a2a;
    border-color: #404040;
}
.action-menu-header {
    padding: 0.5rem 0.75rem;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    border-bottom: 1px solid #e5e7eb;
    margin-bottom: 0.25rem;
}
body.dark .action-menu-header {
    color: #9ca3af;
    border-bottom-color: #404040;
}
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
    text-align: left;
    color: inherit;
}
.action-item:hover {
    background-color: #f3f4f6;
}
body.dark .action-item:hover {
    background-color: #3f3f46;
}
.action-divider {
    height: 1px;
    background-color: #e5e7eb;
    margin: 0.25rem 0;
}
body.dark .action-divider {
    background-color: #404040;
}
.action-item.text-red-600 { color: #dc2626; }
.action-item.text-red-600:hover { background-color: #fee2e2; }
body.dark .action-item.text-red-600:hover { background-color: #7f1d1d; }


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
                <a class="nav-link flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="patients.html">
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

        <main class="flex-1 overflow-auto p-4 xl:p-6 xl:ml-64 w-full"> 
    <div class="flex flex-col gap-4">
        <!-- Breadcrumb and Header -->
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between flex-wrap">
            <div class="flex items-center gap-2 flex-wrap">
                <a class="text-gray-500 hover:text-gray-900" href="ambulance-list.html">Ambulances</a>
                <span class="text-gray-400">/</span>
                <h2 class="text-2xl font-bold leading-tight mb-2">AMB-002</h2>
                <div id="statusBadge" class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-800 border-transparent ml-2">Available</div>
            </div>
            <div class="flex flex-col gap-2 sm:flex-row">
                <button id="scheduleMaintenanceBtn" class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium border border-gray-300 bg-background hover:bg-gray-50 h-10 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-2 h-4 w-4"><path d="M15.707 21.293a1 1 0 0 1-1.414 0l-1.586-1.586a1 1 0 0 1 0-1.414l5.586-5.586a1 1 0 0 1 1.414 0l1.586 1.586a1 1 0 0 1 0 1.414z"></path><path d="m18 13-1.375-6.874a1 1 0 0 0-.746-.776L3.235 2.028a1 1 0 0 0-1.207 1.207L5.35 15.879a1 1 0 0 0 .776.746L13 18"></path><path d="m2.3 2.3 7.286 7.286"></path><circle cx="11" cy="11" r="2"></circle></svg>Schedule Maintenance
                </button>
                <button id="updateStatusBtn" class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mr-2 h-4 w-4"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>Update Status
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-lg text-card-foreground border bg-white dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex flex-col space-y-1.5 p-3 md:p-4 xxl:p-6 pb-2"><h2 class="xl:text-2xl mb-2 tracking-tight text-sm font-medium">Status</h2></div><div class="p-4 md:p-4 xxl:p-6"><div class="flex items-center justify-between"><div class="text-2xl font-bold" id="statStatus">Available</div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-ambulance size-8 text-muted-foreground"><path d="M10 10H6"></path><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"></path><path d="M19 18h2a1 1 0 0 0 1-1v-3.28a1 1 0 0 0-.684-.948l-1.923-.641a1 1 0 0 1-.578-.502l-1.539-3.076A1 1 0 0 0 16.382 8H14"></path><path d="M8 8v4"></path><path d="M9 18h6"></path><circle cx="17" cy="18" r="2"></circle><circle cx="7" cy="18" r="2"></circle></svg></div><p class="text-xs text-muted-foreground">Last updated: Today, 9:30 AM</p></div></div>
            <div class="rounded-lg text-card-foreground border bg-white dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex flex-col space-y-1.5 p-3 md:p-4 xxl:p-6 pb-2"><h2 class="xl:text-2xl mb-2 tracking-tight text-sm font-medium">Last Maintenance</h2></div><div class="p-4 md:p-4 xxl:p-6"><div class="flex items-center justify-between"><div class="text-2xl font-bold">2026-04-02</div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-calendar size-8 text-muted-foreground"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg></div><p class="text-xs text-muted-foreground">Next: 2026-07-02</p></div></div>
            <div class="rounded-lg text-card-foreground border bg-white dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex flex-col space-y-1.5 p-3 md:p-4 xxl:p-6 pb-2"><h2 class="xl:text-2xl mb-2 tracking-tight text-sm font-medium">Total Calls</h2></div><div class="p-4 md:p-4 xxl:p-6"><div class="flex items-center justify-between"><div class="text-2xl font-bold">42</div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-file-text size-8 text-muted-foreground"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg></div><p class="text-xs text-muted-foreground">4 calls this month</p></div></div>
            <div class="rounded-lg text-card-foreground border bg-white dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex flex-col space-y-1.5 p-3 md:p-4 xxl:p-6 pb-2"><h2 class="xl:text-2xl mb-2 tracking-tight text-sm font-medium">Current Driver</h2></div><div class="p-4 md:p-4 xxl:p-6"><div class="flex items-center justify-between"><div class="text-2xl font-bold">Wanjiru Sarah</div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-user size-8 text-muted-foreground"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg></div><p class="text-xs text-muted-foreground">Assigned since: April 1, 2026</p></div></div>
        </div>

        <!-- Tabs Container -->
        <div dir="ltr" data-orientation="horizontal" class="w-full">
            <div role="tablist" aria-orientation="horizontal" class="inline-flex flex-wrap items-center rounded-md bg-muted p-1 text-gray-500" id="tabList">
                <button type="button" role="tab" data-tab="overview" class="tab-trigger inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all active">Overview</button>
                <button type="button" role="tab" data-tab="maintenance" class="tab-trigger inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Maintenance</button>
                <button type="button" role="tab" data-tab="equipment" class="tab-trigger inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Equipment</button>
                <button type="button" role="tab" data-tab="calls" class="tab-trigger inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Call Assignments</button>
            </div>

            <!-- Overview Tab Panel -->
            <div id="tab-overview" class="tab-panel mt-4">
                <div class="rounded-lg border bg-background shadow-sm">
                    <div class="flex flex-col space-y-1.5 p-4 border-b"><h2 class="text-xl xl:text-2xl font-semibold leading-tight mb-2 tracking-tight">Ambulance Overview</h2><div class="text-gray-500">General information and specifications</div></div>
                    <div class="p-6"><div class="grid gap-6 md:grid-cols-2"><div><h3 class="mb-4 text-lg font-medium">General Information</h3><dl class="grid grid-cols-2 gap-2 text-sm"><dt class="font-medium text-gray-500">ID:</dt><dd>AMB-002</dd><dt class="font-medium text-gray-500">Registration:</dt><dd>UAH 456K</dd><dt class="font-medium text-gray-500">Model:</dt><dd>Mercedes Sprinter</dd><dt class="font-medium text-gray-500">Year:</dt><dd>2022</dd><dt class="font-medium text-gray-500">Type:</dt><dd>Advanced Life Support</dd><dt class="font-medium text-gray-500">Purchase Date:</dt><dd>2022-01-15</dd><dt class="font-medium text-gray-500">Insurance Expiry:</dt><dd>2024-01-15</dd></dl></div><div><h3 class="mb-4 text-lg font-medium">Technical Specifications</h3><dl class="grid grid-cols-2 gap-2 text-sm"><dt class="font-medium text-gray-500">Fuel Type:</dt><dd>Diesel</dd><dt class="font-medium text-gray-500">Mileage:</dt><dd>12,450 km</dd><dt class="font-medium text-gray-500">Capacity:</dt><dd>2 stretchers, 3 seated</dd><dt class="font-medium text-gray-500">Current Location:</dt><dd>OPD Wing</dd><dt class="font-medium text-gray-500">Current Driver:</dt><dd>Wanjiru Sarah</dd><dt class="font-medium text-gray-500">Last Maintenance:</dt><dd>2023-04-02</dd><dt class="font-medium text-gray-500">Next Maintenance:</dt><dd>2023-07-02</dd></dl></div></div><div class="mt-8"><h3 class="mb-4 text-lg font-medium">Usage Statistics</h3><div class="grid gap-4 md:grid-cols-3"><div class="rounded-lg border bg-background shadow-sm"><div class="p-4 pb-2"><h2 class="text-sm font-medium text-gray-500">Total Distance</h2></div><div class="p-4 pt-0"><div class="flex items-center justify-between"><div class="text-2xl font-bold">12,450 km</div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-8 w-8 text-gray-400"><path d="m12 14 4-4"></path><path d="M3.34 19a10 10 0 1 1 17.32 0"></path></svg></div><p class="text-xs text-gray-400 mt-2">+450 km this month</p></div></div><div class="rounded-lg border bg-background shadow-sm"><div class="p-4 pb-2"><h2 class="text-sm font-medium text-gray-500">Average Response Time</h2></div><div class="p-4 pt-0"><div class="flex items-center justify-between"><div class="text-2xl font-bold">8.2 min</div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-8 w-8 text-gray-400"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></div><p class="text-xs text-gray-400 mt-2">-0.5 min from last month</p></div></div><div class="rounded-lg border bg-background shadow-sm"><div class="p-4 pb-2"><h2 class="text-sm font-medium text-gray-500">Fuel Efficiency</h2></div><div class="p-4 pt-0"><div class="flex items-center justify-between"><div class="text-2xl font-bold">9.8 L/100km</div><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-8 w-8 text-gray-400"><path d="m12 14 4-4"></path><path d="M3.34 19a10 10 0 1 1 17.32 0"></path></svg></div><p class="text-xs text-gray-400 mt-2">Within normal range</p></div></div></div></div></div>
                </div>
            </div>

            <!-- Maintenance Tab Panel -->
            <div id="tab-maintenance" class="tab-panel mt-4 hidden">
                <div class="rounded-lg border bg-background shadow-sm">
                    <div class="p-4 border-b"><h2 class="text-xl font-semibold">Maintenance History</h2><div class="text-gray-500">Record of all maintenance activities</div></div>
                    <div class="p-6"><div class="rounded-md border overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr><th class="h-12 px-4 text-left font-medium">ID</th><th class="h-12 px-4 text-left font-medium">Date</th><th class="h-12 px-4 text-left font-medium">Type</th><th class="h-12 px-4 text-left font-medium hidden md:table-cell">Description</th><th class="h-12 px-4 text-left font-medium hidden lg:table-cell">Technician</th><th class="h-12 px-4 text-left font-medium">Cost</th><th class="h-12 px-4 text-left font-medium">Status</th><th class="h-12 px-4 text-right font-medium">Actions</th></tr></thead><tbody id="maintenanceTableBody"></tbody></table></div><div class="mt-6"><h3 class="mb-4 text-lg font-medium">Upcoming Maintenance</h3><div class="rounded-lg border bg-white"><div class="p-4 border-b"><h2 class="text-base font-semibold">Regular Service</h2><div class="text-gray-500">Scheduled for 2023-07-02</div></div><div class="p-6"><ul class="list-disc pl-5 text-sm"><li>Oil and filter change</li><li>Brake inspection</li><li>Tire rotation and pressure check</li><li>Fluid levels check and top-up</li><li>General safety inspection</li></ul><div class="mt-4 flex justify-end"><button id="rescheduleMaintenanceBtn" class="border border-gray-300 bg-background hover:bg-gray-50 h-10 rounded-md px-3 py-2 text-sm">Reschedule</button></div></div></div></div></div>
                </div>
            </div>

            <!-- Equipment Tab Panel -->
            <div id="tab-equipment" class="tab-panel mt-4 hidden">
                <div class="rounded-lg border bg-background shadow-sm">
                    <div class="p-4 border-b"><h2 class="text-xl font-semibold">Equipment Inventory</h2><div class="text-gray-500">List of all equipment on board</div></div>
                    <div class="p-6"><div class="rounded-md border overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr><th class="h-12 px-4 text-left font-medium">ID</th><th class="h-12 px-4 text-left font-medium">Equipment</th><th class="h-12 px-4 text-left font-medium hidden md:table-cell">Model</th><th class="h-12 px-4 text-left font-medium hidden lg:table-cell">Serial Number</th><th class="h-12 px-4 text-left font-medium">Last Inspection</th><th class="h-12 px-4 text-left font-medium">Status</th><th class="h-12 px-4 text-right font-medium">Actions</th></tr></thead><tbody id="equipmentTableBody"></tbody></table></div><div class="mt-6 flex justify-end"><button class="bg-primary text-white hover:bg-primary/90 rounded-md px-4 py-2 text-sm"><span class="mr-2">+</span>Add Equipment</button></div></div>
                </div>
            </div>

            <!-- Call Assignments Tab Panel -->
            <div id="tab-calls" class="tab-panel mt-4 hidden">
                <div class="rounded-lg border bg-background shadow-sm">
                    <div class="p-4 border-b"><h2 class="text-xl font-semibold">Call Assignments</h2><div class="text-gray-500">History of calls this ambulance has been assigned to</div></div>
                    <div class="p-6"><div class="rounded-md border overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr><th class="h-12 px-4 text-left font-medium">ID</th><th class="h-12 px-4 text-left font-medium">Date & Time</th><th class="h-12 px-4 text-left font-medium">Patient</th><th class="h-12 px-4 text-left font-medium hidden md:table-cell">Location</th><th class="h-12 px-4 text-left font-medium hidden lg:table-cell">Reason</th><th class="h-12 px-4 text-left font-medium">Duration</th><th class="h-12 px-4 text-left font-medium">Status</th><th class="h-12 px-4 text-right font-medium">Actions</th></tr></thead><tbody id="callsTableBody"></tbody></table></div></div>
                </div>
            </div>
        </div>
    </div>
</main>
</div>

<!-- ==================== MODALS ==================== -->

<!-- Update Status Modal - Dropdown Style -->
<div id="updateStatusModal" class="modal-overlay hidden">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="modal-title">Update Status - AMB-002</h2>
            <button class="modal-close" id="closeStatusModalBtn">&times;</button>
        </div>
        <div class="modal-body">
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium block mb-2">Current Status: 
                        <span id="currentStatusDisplay" class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Available</span>
                    </label>
                    <select id="newStatusSelect" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
                        <option value="Available" selected>Available</option>
                        <option value="On Call">On Call</option>
                        <option value="On Maintenance">On Maintenance</option>
                        <option value="Out of Service">Out of Service</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium block mb-1">Notes (optional)</label>
                    <textarea id="statusNotes" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none" placeholder="Reason for status change..."></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm hover:bg-gray-100" id="cancelStatusBtn">Cancel</button>
            <button id="confirmStatusBtn" class="inline-flex rounded-md bg-primary px-4 py-2 text-sm text-white hover:bg-primary/90">Update Status</button>
        </div>
    </div>
</div>

<!-- Schedule Maintenance Modal -->
<div id="scheduleMaintenanceModal" class="modal-overlay hidden">
    <div class="modal-container">
        <div class="modal-header"><h2 class="modal-title">Schedule Maintenance</h2><button class="modal-close-btn" id="closeMaintenanceModalBtn">&times;</button></div>
        <div class="modal-body">
            <p class="text-sm text-gray-500 mb-4">Schedule a maintenance task for ambulance <strong>AMB-002</strong></p>
            <div class="space-y-4">
                <div><label class="text-sm font-medium block mb-1">Maintenance Type *</label><select id="maintenanceType" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"><option value="Regular Service">Regular Service</option><option value="Engine Repair">Engine Repair</option><option value="Brake Replacement">Brake Replacement</option><option value="Tire Replacement">Tire Replacement</option><option value="Electrical System">Electrical System</option><option value="Inspection">Inspection</option></select></div>
                <div><label class="text-sm font-medium block mb-1">Schedule Date *</label><input type="date" id="maintenanceDate" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                <div><label class="text-sm font-medium block mb-1">Estimated Cost</label><input type="number" id="maintenanceCost" step="0.01" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="e.g., 350.00"></div>
                <div><label class="text-sm font-medium block mb-1">Description / Notes</label><textarea id="maintenanceNotes" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Describe the maintenance work required..."></textarea></div>
            </div>
        </div>
        <div class="modal-footer"><button class="btn-secondary" id="cancelMaintenanceBtn">Cancel</button><button class="text-sm font-medium bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 rounded-lg" id="confirmMaintenanceBtn">Schedule Maintenance</button></div>
    </div>
</div>

<!-- Add Equipment Modal -->
<div id="addEquipmentModal" class="modal-overlay hidden">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="modal-title">Add Equipment - AMB-002</h2>
            <button class="modal-close-btn" id="closeEquipmentModalBtn">&times;</button>
        </div>
        <div class="modal-body">
            <p class="text-sm text-gray-500 mb-4">Add new equipment to ambulance <strong>AMB-002</strong></p>
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium block mb-1">Equipment ID *</label>
                    <input type="text" id="equipmentId" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="e.g., E006">
                </div>
                <div>
                    <label class="text-sm font-medium block mb-1">Equipment Name *</label>
                    <input type="text" id="equipmentName" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="e.g., Cardiac Monitor">
                </div>
                <div>
                    <label class="text-sm font-medium block mb-1">Model</label>
                    <input type="text" id="equipmentModel" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="e.g., GE Dash 3000">
                </div>
                <div>
                    <label class="text-sm font-medium block mb-1">Serial Number</label>
                    <input type="text" id="equipmentSerial" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="e.g., SN-98765">
                </div>
                <div>
                    <label class="text-sm font-medium block mb-1">Last Inspection Date *</label>
                    <input type="date" id="equipmentLastInspection" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="text-sm font-medium block mb-1">Next Inspection Date *</label>
                    <input type="date" id="equipmentNextInspection" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label class="text-sm font-medium block mb-1">Status</label>
                    <select id="equipmentStatus" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                        <option value="Operational">Operational</option>
                        <option value="Needs Inspection">Needs Inspection</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary" id="cancelEquipmentBtn">Cancel</button>
            <button class="text-sm font-medium bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 rounded-lg" id="confirmEquipmentBtn">Add Equipment</button>
        </div>
    </div>
</div>

</div>

<!-- ==================== MAINTENANCE VIEW MODAL ==================== -->
<div id="maintenanceViewModal" class="modal-overlay hidden">
    <div class="modal-container" style="max-width:550px;">
        <div class="modal-header">
            <h2 class="modal-title" id="maintViewTitle">Maintenance Details</h2>
            <button class="modal-close" id="closeMaintViewBtn">&times;</button>
        </div>
        <div class="modal-body">
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-sm font-medium text-gray-500">Date</label><p class="font-medium" id="maintViewDate"></p></div>
                    <div><label class="text-sm font-medium text-gray-500">Type</label><p class="font-medium" id="maintViewType"></p></div>
                    <div><label class="text-sm font-medium text-gray-500">Technician</label><p class="font-medium" id="maintViewTech"></p></div>
                    <div><label class="text-sm font-medium text-gray-500">Cost</label><p class="font-medium" id="maintViewCost"></p></div>
                    <div><label class="text-sm font-medium text-gray-500">Status</label><p id="maintViewStatus"></p></div>
                </div>
                <div><label class="text-sm font-medium text-gray-500">Description</label><p class="text-sm" id="maintViewDesc"></p></div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm hover:bg-gray-100" id="closeMaintViewFooter">Close</button>
            <button class="inline-flex rounded-md bg-primary px-4 py-2 text-sm text-white hover:bg-primary/90" id="printMaintView">Print</button>
        </div>
    </div>
</div>

<!-- ==================== MAINTENANCE EDIT MODAL ==================== -->
<div id="maintenanceEditModal" class="modal-overlay hidden">
    <div class="modal-container" style="max-width:550px;">
        <div class="modal-header">
            <h2 class="modal-title" id="maintEditTitle">Edit Maintenance Record</h2>
            <button class="modal-close" id="closeMaintEditBtn">&times;</button>
        </div>
        <div class="modal-body">
            <div class="space-y-4">
                <input type="hidden" id="editMaintId">
                <div><label class="text-sm font-medium block mb-1">Date</label><input type="date" id="editMaintDate" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                <div><label class="text-sm font-medium block mb-1">Type</label><select id="editMaintType" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"><option>Regular Service</option><option>Tire Replacement</option><option>Brake Repair</option><option>Engine Repair</option><option>Electrical System</option><option>Inspection</option></select></div>
                <div><label class="text-sm font-medium block mb-1">Technician</label><input type="text" id="editMaintTech" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                <div><label class="text-sm font-medium block mb-1">Cost ($)</label><input type="text" id="editMaintCost" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                <div><label class="text-sm font-medium block mb-1">Description</label><textarea id="editMaintDesc" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></textarea></div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm hover:bg-gray-100" id="cancelMaintEditBtn">Cancel</button>
            <button class="inline-flex rounded-md bg-primary px-4 py-2 text-sm text-white hover:bg-primary/90" id="saveMaintEditBtn">Save Changes</button>
        </div>
    </div>
</div>

<!-- ==================== EQUIPMENT VIEW MODAL ==================== -->
<div id="equipmentViewModal" class="modal-overlay hidden">
    <div class="modal-container" style="max-width:550px;">
        <div class="modal-header">
            <h2 class="modal-title" id="equipViewTitle">Equipment Details</h2>
            <button class="modal-close" id="closeEquipViewBtn">&times;</button>
        </div>
        <div class="modal-body">
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-sm font-medium text-gray-500">Equipment</label><p class="font-medium" id="equipViewName"></p></div>
                    <div><label class="text-sm font-medium text-gray-500">Model</label><p class="font-medium" id="equipViewModel"></p></div>
                    <div><label class="text-sm font-medium text-gray-500">Serial Number</label><p class="font-medium" id="equipViewSerial"></p></div>
                    <div><label class="text-sm font-medium text-gray-500">Status</label><p id="equipViewStatus"></p></div>
                    <div><label class="text-sm font-medium text-gray-500">Last Inspection</label><p class="font-medium" id="equipViewLastInsp"></p></div>
                    <div><label class="text-sm font-medium text-gray-500">Next Inspection</label><p class="font-medium" id="equipViewNextInsp"></p></div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm hover:bg-gray-100" id="closeEquipViewFooter">Close</button>
        </div>
    </div>
</div>

<!-- ==================== INSPECTION MODAL ==================== -->
<div id="inspectionModal" class="modal-overlay hidden">
    <div class="modal-container" style="max-width:500px;">
        <div class="modal-header">
            <h2 class="modal-title" id="inspectionTitle">Record Inspection</h2>
            <button class="modal-close" id="closeInspectionBtn">&times;</button>
        </div>
        <div class="modal-body">
            <div class="space-y-4">
                <input type="hidden" id="inspectEquipId">
                <div class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-md">
                    <p class="text-sm"><strong>Equipment:</strong> <span id="inspectEquipName"></span></p>
                    <p class="text-sm mt-1"><strong>Last Inspection:</strong> <span id="inspectLastDate"></span></p>
                </div>
                <div><label class="text-sm font-medium block mb-1">Inspection Date</label><input type="date" id="inspectionDate" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                <div><label class="text-sm font-medium block mb-1">Next Inspection Due</label><input type="date" id="nextInspectionDate" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                <div><label class="text-sm font-medium block mb-1">Inspector Name</label><input type="text" id="inspectorName" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Enter inspector name"></div>
                <div><label class="text-sm font-medium block mb-1">Result</label><select id="inspectionResult" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"><option value="Passed">Passed</option><option value="Needs Attention">Needs Attention</option><option value="Failed">Failed</option></select></div>
                <div><label class="text-sm font-medium block mb-1">Notes</label><textarea id="inspectionNotes" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Inspection notes..."></textarea></div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm hover:bg-gray-100" id="cancelInspectionBtn">Cancel</button>
            <button class="inline-flex rounded-md bg-primary px-4 py-2 text-sm text-white hover:bg-primary/90" id="saveInspectionBtn">Save Inspection</button>
        </div>
    </div>
</div>

<!-- ==================== REPLACE EQUIPMENT MODAL ==================== -->
<div id="replaceEquipmentModal" class="modal-overlay hidden">
    <div class="modal-container" style="max-width:500px;">
        <div class="modal-header">
            <h2 class="modal-title" id="replaceTitle">Replace Equipment</h2>
            <button class="modal-close" id="closeReplaceBtn">&times;</button>
        </div>
        <div class="modal-body">
            <div class="space-y-4">
                <input type="hidden" id="replaceEquipId">
                <div class="bg-red-50 dark:bg-red-900/20 p-3 rounded-md">
                    <p class="text-sm text-red-800 dark:text-red-200">You are about to replace <strong id="replaceEquipName"></strong>. This will mark the current equipment as decommissioned.</p>
                </div>
                <div><label class="text-sm font-medium block mb-1">New Equipment Name *</label><input type="text" id="newEquipName" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="e.g., Defibrillator Pro"></div>
                <div><label class="text-sm font-medium block mb-1">New Model</label><input type="text" id="newEquipModel" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Model number"></div>
                <div><label class="text-sm font-medium block mb-1">New Serial Number</label><input type="text" id="newEquipSerial" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Serial number"></div>
                <div><label class="text-sm font-medium block mb-1">Reason for Replacement</label><textarea id="replaceReason" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Reason for replacement..."></textarea></div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm hover:bg-gray-100" id="cancelReplaceBtn">Cancel</button>
            <button class="inline-flex rounded-md bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700" id="confirmReplaceBtn">Replace Equipment</button>
        </div>
    </div>
</div>

<!-- ==================== REPORT ISSUE MODAL ==================== -->
<div id="reportIssueModal" class="modal-overlay hidden">
    <div class="modal-container" style="max-width:500px;">
        <div class="modal-header">
            <h2 class="modal-title" id="reportIssueTitle">Report Issue</h2>
            <button class="modal-close" id="closeReportIssueBtn">&times;</button>
        </div>
        <div class="modal-body">
            <div class="space-y-4">
                <input type="hidden" id="reportEquipId">
                <div class="bg-yellow-50 dark:bg-yellow-900/20 p-3 rounded-md">
                    <p class="text-sm"><strong>Equipment:</strong> <span id="reportEquipName"></span></p>
                    <p class="text-sm mt-1"><strong>Current Status:</strong> <span id="reportEquipStatus"></span></p>
                </div>
                <div><label class="text-sm font-medium block mb-1">Issue Severity *</label><select id="issueSeverity" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"><option value="Low">Low - Minor issue</option><option value="Medium">Medium - Needs attention</option><option value="High">High - Critical issue</option></select></div>
                <div><label class="text-sm font-medium block mb-1">Issue Description *</label><textarea id="issueDesc" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Describe the issue..."></textarea></div>
                <div><label class="text-sm font-medium block mb-1">Reported By</label><input type="text" id="reportedBy" value="Wanjiru Sarah" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm hover:bg-gray-100" id="cancelReportIssueBtn">Cancel</button>
            <button class="inline-flex rounded-md bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700" id="submitIssueBtn">Submit Report</button>
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
        


        // ==================== TOAST NOTIFICATION ====================
function showToast(message, isError = false) {
    const existing = document.querySelector('.toast-message');
    if (existing) existing.remove();
    const toast = document.createElement('div');
    toast.className = `toast-message ${isError ? 'error' : ''}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// ==================== UPDATE STATUS MODAL FUNCTIONS ====================
const statusModal = document.getElementById('updateStatusModal');
const statusSelect = document.getElementById('newStatusSelect');
const statusNotesEl = document.getElementById('statusNotes');
const currentStatusSpan = document.getElementById('currentStatusDisplay');

function openStatusModal() { 
    statusModal.classList.remove('hidden'); 
    // Reset form
    statusSelect.value = getCurrentStatusValue();
    statusNotesEl.value = '';
}

function closeStatusModal() { statusModal.classList.add('hidden'); }

function getCurrentStatusValue() {
    const badge = document.getElementById('statusBadge');
    const currentText = badge ? badge.innerText : 'Available';
    switch(currentText) {
        case 'Available': return 'Available';
        case 'On Call': return 'On Call';
        case 'On Maintenance': return 'On Maintenance';
        case 'Out of Service': return 'Out of Service';
        default: return 'Available';
    }
}

function getStatusClasses(status) {
    switch(status) {
        case 'Available': return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
        case 'On Call': return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
        case 'On Maintenance': return 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200';
        case 'Out of Service': return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
        default: return 'bg-green-100 text-green-800';
    }
}

// Confirm Status Update
document.getElementById('confirmStatusBtn')?.addEventListener('click', () => {
    const newStatus = statusSelect.value;
    const notes = statusNotesEl.value.trim();
    
    // Update badge
    const badge = document.getElementById('statusBadge');
    const statusClass = getStatusClasses(newStatus);
    badge.className = `inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold ${statusClass} border-transparent ml-2`;
    badge.innerText = newStatus;
    
    // Update stat card
    document.getElementById('statStatus').innerText = newStatus;
    
    // Update current status display for next modal open
    currentStatusSpan.className = `inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold ${statusClass}`;
    currentStatusSpan.innerText = newStatus;
    
    let message = `Status updated to ${newStatus}`;
    if (notes) message += ` with note: ${notes}`;
    showToast(message);
    
    closeStatusModal();
});

// Modal close buttons
document.getElementById('closeStatusModalBtn')?.addEventListener('click', closeStatusModal);
document.getElementById('cancelStatusBtn')?.addEventListener('click', closeStatusModal);
document.getElementById('updateStatusBtn')?.addEventListener('click', openStatusModal);

// Close modal when clicking outside
statusModal?.addEventListener('click', (e) => { if (e.target === statusModal) closeStatusModal(); });

// Close on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && statusModal && !statusModal.classList.contains('hidden')) {
        closeStatusModal();
    }
});

// ==================== MAINTENANCE MODAL FUNCTIONS ====================
const maintenanceModal = document.getElementById('scheduleMaintenanceModal');

function openMaintenanceModal() { 
    const today = new Date().toISOString().split('T')[0];
    const dateInput = document.getElementById('maintenanceDate');
    if (dateInput) dateInput.value = today;
    maintenanceModal.classList.remove('hidden'); 
}

function closeMaintenanceModal() { maintenanceModal.classList.add('hidden'); }

// Confirm Maintenance Schedule
document.getElementById('confirmMaintenanceBtn')?.addEventListener('click', () => {
    const type = document.getElementById('maintenanceType').value;
    const date = document.getElementById('maintenanceDate').value;
    if (!date) { showToast('Please select a date', true); return; }
    showToast(`Maintenance scheduled: ${type} on ${date}`);
    closeMaintenanceModal();
    document.getElementById('maintenanceType').value = 'Regular Service';
    const costInput = document.getElementById('maintenanceCost');
    if (costInput) costInput.value = '';
    const notesInput = document.getElementById('maintenanceNotes');
    if (notesInput) notesInput.value = '';
});

// Modal close buttons
document.getElementById('closeMaintenanceModalBtn')?.addEventListener('click', closeMaintenanceModal);
document.getElementById('cancelMaintenanceBtn')?.addEventListener('click', closeMaintenanceModal);
document.getElementById('scheduleMaintenanceBtn')?.addEventListener('click', openMaintenanceModal);

// Close maintenance modal when clicking outside
maintenanceModal?.addEventListener('click', (e) => { if (e.target === maintenanceModal) closeMaintenanceModal(); });

// ==================== DATA AND TABLE RENDERING (existing) ====================
const maintenanceData = [
    { id: "M001", date: "2023-04-02", type: "Regular Service", desc: "Oil change, filter replacement, brake inspection", tech: "John Mechanic", cost: "$350", status: "Completed" },
    { id: "M002", date: "2023-01-10", type: "Tire Replacement", desc: "Replaced all four tires with winter tires", tech: "Mike Tire", cost: "$800", status: "Completed" },
    { id: "M003", date: "2022-10-15", type: "Regular Service", desc: "Oil change, filter replacement, general inspection", tech: "John Mechanic", cost: "$320", status: "Completed" },
    { id: "M004", date: "2022-07-22", type: "Brake Repair", desc: "Front brake pads replacement and rotor resurfacing", tech: "Robert Brake", cost: "$450", status: "Completed" }
];
const equipmentData = [
    { id: "E001", name: "Defibrillator", model: "Philips HeartStart FR3", serial: "PHI-12345", lastInspection: "2023-03-15", nextInspection: "2023-06-15", status: "Operational" },
    { id: "E002", name: "Oxygen Tank", model: "OxyFlow 5000", serial: "OF-67890", lastInspection: "2023-04-01", nextInspection: "2023-07-01", status: "Operational" },
    { id: "E003", name: "Stretcher", model: "Stryker Power-PRO XT", serial: "SPX-54321", lastInspection: "2023-03-20", nextInspection: "2023-06-20", status: "Operational" },
    { id: "E004", name: "Suction Unit", model: "VacuMed 3000", serial: "VM-13579", lastInspection: "2023-02-28", nextInspection: "2023-05-28", status: "Needs Inspection" },
    { id: "E005", name: "Blood Pressure Monitor", model: "Omron Pro", serial: "OP-24680", lastInspection: "2023-03-10", nextInspection: "2023-06-10", status: "Operational" }
];
const callsData = [
    { id: "CA001", dateTime: "2023-04-18T14:30", patient: "Ssentongo John", location: "Plot 14, Kampala Road, Kampala", reason: "Chest Pain", duration: "45 min", status: "Completed" },
    { id: "CA002", dateTime: "2023-04-15T09:15", patient: "Nabukenya Jane", location: "Plot 12, Ntinda Road, Kampala", reason: "Traffic Accident", duration: "1 hr 20 min", status: "Completed" },
    { id: "CA003", dateTime: "2023-04-10T18:45", patient: "Robert Johnson", location: "Plot 23, Kololo Hill Drive, Kampala", reason: "Stroke Symptoms", duration: "55 min", status: "Completed" },
    { id: "CA004", dateTime: "2023-04-05T11:30", patient: "Nakato Mary", location: "321 Elm St, Nowhere", reason: "Allergic Reaction", duration: "40 min", status: "Completed" }
];

function formatDateTime(isoString) { const d = new Date(isoString); return `${d.toLocaleDateString()}<br><span class="text-xs text-gray-400">${d.toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'})}</span>`; }
function getStatusBadge(status, type) { if (type === 'equipment') return status === 'Operational' ? '<span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-800">Operational</span>' : '<span class="inline-flex rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-semibold text-yellow-800">Needs Inspection</span>'; return '<span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-semibold text-green-800">Completed</span>'; }

// ==================== ACTION MENU SYSTEM ====================
let activeActionMenu = null;

function closeActionMenu() {
    if (activeActionMenu) { activeActionMenu.remove(); activeActionMenu = null; }
}

// ==================== MAINTENANCE ACTION MENU ====================
function showMaintenanceActionMenu(btn, recordId) {
    closeActionMenu();
    const record = maintenanceData.find(r => r.id === recordId);
    if (!record) return;
    
    const rect = btn.getBoundingClientRect();
    const menu = document.createElement('div');
    menu.className = 'action-menu';
    let left = rect.left, top = rect.bottom + 6;
    if (left + 220 > window.innerWidth) left = window.innerWidth - 230;
    if (left < 10) left = 10;
    if (top + 200 > window.innerHeight) top = rect.top - 210;
    if (top < 10) top = 10;
    menu.style.top = `${top}px`; menu.style.left = `${left}px`;
    
    menu.innerHTML = `
        <div class="action-menu-header">Actions - ${record.id}</div>
        <button data-action="view" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>View Details</button>
        <button data-action="edit" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>Edit Record</button>
        <div class="action-divider"></div>
        <button data-action="print" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>Print Report</button>
    `;
    document.body.appendChild(menu);
    activeActionMenu = menu;
    
    const closeHandler = (e) => { if (!menu.contains(e.target) && e.target !== btn) { closeActionMenu(); document.removeEventListener('click', closeHandler); } };
    setTimeout(() => document.addEventListener('click', closeHandler), 10);
    
    menu.querySelector('[data-action="view"]').addEventListener('click', () => { openMaintViewModal(record); closeActionMenu(); });
    menu.querySelector('[data-action="edit"]').addEventListener('click', () => { openMaintEditModal(record); closeActionMenu(); });
    menu.querySelector('[data-action="print"]').addEventListener('click', () => { printWithoutSidebar(); closeActionMenu(); });
}

// ==================== EQUIPMENT ACTION MENU ====================
function showEquipmentActionMenu(btn, equipmentId) {
    closeActionMenu();
    const equipment = equipmentData.find(e => e.id === equipmentId);
    if (!equipment) return;
    
    const rect = btn.getBoundingClientRect();
    const menu = document.createElement('div');
    menu.className = 'action-menu';
    let left = rect.left, top = rect.bottom + 6;
    if (left + 220 > window.innerWidth) left = window.innerWidth - 230;
    if (left < 10) left = 10;
    if (top + 280 > window.innerHeight) top = rect.top - 290;
    if (top < 10) top = 10;
    menu.style.top = `${top}px`; menu.style.left = `${left}px`;
    
    menu.innerHTML = `
        <div class="action-menu-header">Actions - ${equipment.id}</div>
        <button data-action="view" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>View Details</button>
        <button data-action="inspect" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Record Inspection</button>
        <div class="action-divider"></div>
        <button data-action="replace" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/></svg>Replace Equipment</button>
        <button data-action="report" class="action-item text-red-600"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4"/><path d="M12 16h.01"/><circle cx="12" cy="12" r="10"/></svg>Report Issue</button>
    `;
    document.body.appendChild(menu);
    activeActionMenu = menu;
    
    const closeHandler = (e) => { if (!menu.contains(e.target) && e.target !== btn) { closeActionMenu(); document.removeEventListener('click', closeHandler); } };
    setTimeout(() => document.addEventListener('click', closeHandler), 10);
    
    menu.querySelector('[data-action="view"]').addEventListener('click', () => { openEquipViewModal(equipment); closeActionMenu(); });
    menu.querySelector('[data-action="inspect"]').addEventListener('click', () => { openInspectionModal(equipment); closeActionMenu(); });
    menu.querySelector('[data-action="replace"]').addEventListener('click', () => { openReplaceModal(equipment); closeActionMenu(); });
    menu.querySelector('[data-action="report"]').addEventListener('click', () => { openReportIssueModal(equipment); closeActionMenu(); });
}

// ==================== CALLS ACTION MENU ====================
function showCallsActionMenu(btn, callId) {
    closeActionMenu();
    const call = callsData.find(c => c.id === callId);
    if (!call) return;
    
    const rect = btn.getBoundingClientRect();
    const menu = document.createElement('div');
    menu.className = 'action-menu';
    let left = rect.left, top = rect.bottom + 6;
    if (left + 220 > window.innerWidth) left = window.innerWidth - 230;
    if (left < 10) left = 10;
    if (top + 220 > window.innerHeight) top = rect.top - 230;
    if (top < 10) top = 10;
    menu.style.top = `${top}px`; menu.style.left = `${left}px`;
    
    menu.innerHTML = `
        <div class="action-menu-header">Actions - ${call.id}</div>
        <button data-action="view" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>View Details</button>
        <button data-action="edit" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>Edit Call</button>
        <div class="action-divider"></div>
        <button data-action="patient" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg>View Patient</button>
        <button data-action="report" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>Print Report</button>
    `;
    document.body.appendChild(menu);
    activeActionMenu = menu;
    
    const closeHandler = (e) => { if (!menu.contains(e.target) && e.target !== btn) { closeActionMenu(); document.removeEventListener('click', closeHandler); } };
    setTimeout(() => document.addEventListener('click', closeHandler), 10);
    
    menu.querySelector('[data-action="view"]').addEventListener('click', () => { window.location.href = 'ambulance-calls-details.html?id=' + call.id; closeActionMenu(); });
    menu.querySelector('[data-action="edit"]').addEventListener('click', () => { window.location.href = 'edit-ambulance-call.html?id=' + call.id; closeActionMenu(); });
    menu.querySelector('[data-action="patient"]').addEventListener('click', () => { window.location.href = 'patient-profile.html?name=' + encodeURIComponent(call.patient); closeActionMenu(); });
    menu.querySelector('[data-action="report"]').addEventListener('click', () => { printWithoutSidebar(); closeActionMenu(); });
}

// ==================== PRINT WITHOUT SIDEBAR ====================
function printWithoutSidebar() {
    showToast('Preparing print...');
    const style = document.createElement('style');
    style.id = 'print-style-temp';
    style.innerHTML = `@media print { header, aside, .no-print, button, .action-menu, .modal-overlay { display: none !important; } main { margin-left: 0 !important; padding: 20px !important; width: 100% !important; } }`;
    document.head.appendChild(style);
    setTimeout(() => { window.print(); setTimeout(() => style.remove(), 500); }, 300);
}

// ==================== MAINTENANCE MODAL HANDLERS ====================
function openMaintViewModal(record) {
    document.getElementById('maintViewDate').innerText = record.date;
    document.getElementById('maintViewType').innerText = record.type;
    document.getElementById('maintViewTech').innerText = record.tech;
    document.getElementById('maintViewCost').innerText = record.cost;
    document.getElementById('maintViewStatus').innerHTML = getStatusBadge(record.status);
    document.getElementById('maintViewDesc').innerText = record.desc;
    document.getElementById('maintenanceViewModal').classList.remove('hidden');
}
function openMaintEditModal(record) {
    document.getElementById('editMaintId').value = record.id;
    document.getElementById('editMaintDate').value = record.date;
    document.getElementById('editMaintType').value = record.type;
    document.getElementById('editMaintTech').value = record.tech;
    document.getElementById('editMaintCost').value = record.cost.replace('$','');
    document.getElementById('editMaintDesc').value = record.desc;
    document.getElementById('maintenanceEditModal').classList.remove('hidden');
}

// ==================== EQUIPMENT MODAL HANDLERS ====================
function openEquipViewModal(equipment) {
    document.getElementById('equipViewName').innerText = equipment.name;
    document.getElementById('equipViewModel').innerText = equipment.model;
    document.getElementById('equipViewSerial').innerText = equipment.serial;
    document.getElementById('equipViewStatus').innerHTML = getStatusBadge(equipment.status, 'equipment');
    document.getElementById('equipViewLastInsp').innerText = equipment.lastInspection;
    document.getElementById('equipViewNextInsp').innerText = equipment.nextInspection;
    document.getElementById('equipmentViewModal').classList.remove('hidden');
}
function openInspectionModal(equipment) {
    const today = new Date().toISOString().split('T')[0];
    const threeMonths = new Date(); threeMonths.setMonth(threeMonths.getMonth() + 3);
    document.getElementById('inspectEquipId').value = equipment.id;
    document.getElementById('inspectEquipName').innerText = equipment.name + ' (' + equipment.id + ')';
    document.getElementById('inspectLastDate').innerText = equipment.lastInspection;
    document.getElementById('inspectionDate').value = today;
    document.getElementById('nextInspectionDate').value = threeMonths.toISOString().split('T')[0];
    document.getElementById('inspectorName').value = '';
    document.getElementById('inspectionResult').value = 'Passed';
    document.getElementById('inspectionNotes').value = '';
    document.getElementById('inspectionModal').classList.remove('hidden');
}
function openReplaceModal(equipment) {
    document.getElementById('replaceEquipId').value = equipment.id;
    document.getElementById('replaceEquipName').innerText = equipment.name + ' (' + equipment.id + ')';
    document.getElementById('newEquipName').value = '';
    document.getElementById('newEquipModel').value = '';
    document.getElementById('newEquipSerial').value = '';
    document.getElementById('replaceReason').value = '';
    document.getElementById('replaceEquipmentModal').classList.remove('hidden');
}
function openReportIssueModal(equipment) {
    document.getElementById('reportEquipId').value = equipment.id;
    document.getElementById('reportEquipName').innerText = equipment.name + ' (' + equipment.id + ')';
    document.getElementById('reportEquipStatus').innerText = equipment.status;
    document.getElementById('issueSeverity').value = 'Medium';
    document.getElementById('issueDesc').value = '';
    document.getElementById('reportedBy').value = 'Wanjiru Sarah';
    document.getElementById('reportIssueModal').classList.remove('hidden');
}

// ==================== MODAL CLOSE BUTTONS ====================
// Close any modal when clicking overlay or close button
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function(e) { if (e.target === this) this.classList.add('hidden'); });
});
// Maintenance View
['closeMaintViewBtn','closeMaintViewFooter'].forEach(id => document.getElementById(id)?.addEventListener('click', () => document.getElementById('maintenanceViewModal').classList.add('hidden')));
document.getElementById('printMaintView')?.addEventListener('click', () => { printWithoutSidebar(); });
// Maintenance Edit
['closeMaintEditBtn','cancelMaintEditBtn'].forEach(id => document.getElementById(id)?.addEventListener('click', () => document.getElementById('maintenanceEditModal').classList.add('hidden')));
document.getElementById('saveMaintEditBtn')?.addEventListener('click', () => {
    const id = document.getElementById('editMaintId').value;
    const record = maintenanceData.find(r => r.id === id);
    if (record) {
        record.date = document.getElementById('editMaintDate').value;
        record.type = document.getElementById('editMaintType').value;
        record.tech = document.getElementById('editMaintTech').value;
        record.cost = '$' + document.getElementById('editMaintCost').value;
        record.desc = document.getElementById('editMaintDesc').value;
        renderMaintenanceTable();
        showToast('Maintenance record updated');
    }
    document.getElementById('maintenanceEditModal').classList.add('hidden');
});
// Equipment View
['closeEquipViewBtn','closeEquipViewFooter'].forEach(id => document.getElementById(id)?.addEventListener('click', () => document.getElementById('equipmentViewModal').classList.add('hidden')));
// Inspection
['closeInspectionBtn','cancelInspectionBtn'].forEach(id => document.getElementById(id)?.addEventListener('click', () => document.getElementById('inspectionModal').classList.add('hidden')));
document.getElementById('saveInspectionBtn')?.addEventListener('click', () => {
    const id = document.getElementById('inspectEquipId').value;
    const equipment = equipmentData.find(e => e.id === id);
    if (equipment) {
        equipment.lastInspection = document.getElementById('inspectionDate').value;
        equipment.nextInspection = document.getElementById('nextInspectionDate').value;
        if (document.getElementById('inspectionResult').value === 'Failed') equipment.status = 'Needs Inspection';
        else equipment.status = 'Operational';
        renderEquipmentTable();
        showToast('Inspection recorded for ' + equipment.name);
    }
    document.getElementById('inspectionModal').classList.add('hidden');
});
// Replace Equipment
['closeReplaceBtn','cancelReplaceBtn'].forEach(id => document.getElementById(id)?.addEventListener('click', () => document.getElementById('replaceEquipmentModal').classList.add('hidden')));
document.getElementById('confirmReplaceBtn')?.addEventListener('click', () => {
    const id = document.getElementById('replaceEquipId').value;
    const equipment = equipmentData.find(e => e.id === id);
    const newName = document.getElementById('newEquipName').value.trim();
    if (!newName) { showToast('Please enter new equipment name', true); return; }
    if (equipment) {
        equipment.name = newName;
        equipment.model = document.getElementById('newEquipModel').value.trim() || 'N/A';
        equipment.serial = document.getElementById('newEquipSerial').value.trim() || 'N/A';
        equipment.lastInspection = new Date().toISOString().split('T')[0];
        equipment.status = 'Operational';
        renderEquipmentTable();
        showToast('Equipment replaced with ' + newName);
    }
    document.getElementById('replaceEquipmentModal').classList.add('hidden');
});
// Report Issue
['closeReportIssueBtn','cancelReportIssueBtn'].forEach(id => document.getElementById(id)?.addEventListener('click', () => document.getElementById('reportIssueModal').classList.add('hidden')));
document.getElementById('submitIssueBtn')?.addEventListener('click', () => {
    const id = document.getElementById('reportEquipId').value;
    const equipment = equipmentData.find(e => e.id === id);
    const desc = document.getElementById('issueDesc').value.trim();
    if (!desc) { showToast('Please describe the issue', true); return; }
    if (equipment) {
        equipment.status = 'Needs Inspection';
        renderEquipmentTable();
        showToast('Issue reported for ' + equipment.name);
    }
    document.getElementById('reportIssueModal').classList.add('hidden');
});
// ==================== MAINTENANCE MODALS ====================

// View Maintenance Details Modal
function showMaintenanceViewModal(record) {
    if (activeModal) { activeModal.remove(); activeModal = null; }
    
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="modal-container" style="max-width:550px;">
            <div class="modal-header">
                <h2 class="modal-title">Maintenance Details - ${record.id}</h2>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="text-sm font-medium text-gray-500">Date</label><p class="font-medium">${record.date}</p></div>
                        <div><label class="text-sm font-medium text-gray-500">Type</label><p class="font-medium">${record.type}</p></div>
                        <div><label class="text-sm font-medium text-gray-500">Technician</label><p class="font-medium">${record.tech}</p></div>
                        <div><label class="text-sm font-medium text-gray-500">Cost</label><p class="font-medium">${record.cost}</p></div>
                        <div><label class="text-sm font-medium text-gray-500">Status</label><p>${getStatusBadge(record.status)}</p></div>
                    </div>
                    <div><label class="text-sm font-medium text-gray-500">Description</label><p class="text-sm">${record.desc}</p></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm hover:bg-gray-100 close-view-modal">Close</button>
                <button class="inline-flex rounded-md bg-primary px-4 py-2 text-sm text-white hover:bg-primary/90 print-view-modal">Print</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    activeModal = modal;
    
    modal.querySelector('.modal-close')?.addEventListener('click', () => { modal.remove(); activeModal = null; });
    modal.querySelector('.close-view-modal')?.addEventListener('click', () => { modal.remove(); activeModal = null; });
    modal.querySelector('.print-view-modal')?.addEventListener('click', () => { showToast('Printing maintenance details...'); setTimeout(() => window.print(), 300); });
    modal.addEventListener('click', (e) => { if (e.target === modal) { modal.remove(); activeModal = null; } });
}

// Edit Maintenance Record Modal
function showMaintenanceEditModal(record) {
    if (activeModal) { activeModal.remove(); activeModal = null; }
    
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="modal-container" style="max-width:550px;">
            <div class="modal-header">
                <h2 class="modal-title">Edit Maintenance - ${record.id}</h2>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="space-y-4">
                    <div><label class="text-sm font-medium block mb-1">Date</label><input type="date" id="editMaintDate" value="${record.date}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                    <div><label class="text-sm font-medium block mb-1">Type</label><select id="editMaintType" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"><option ${record.type === 'Regular Service' ? 'selected' : ''}>Regular Service</option><option ${record.type === 'Tire Replacement' ? 'selected' : ''}>Tire Replacement</option><option ${record.type === 'Brake Repair' ? 'selected' : ''}>Brake Repair</option><option ${record.type === 'Engine Repair' ? 'selected' : ''}>Engine Repair</option></select></div>
                    <div><label class="text-sm font-medium block mb-1">Technician</label><input type="text" id="editMaintTech" value="${record.tech}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                    <div><label class="text-sm font-medium block mb-1">Cost</label><input type="text" id="editMaintCost" value="${record.cost}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                    <div><label class="text-sm font-medium block mb-1">Description</label><textarea id="editMaintDesc" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">${record.desc}</textarea></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm hover:bg-gray-100 close-edit-modal">Cancel</button>
                <button class="inline-flex rounded-md bg-primary px-4 py-2 text-sm text-white hover:bg-primary/90 save-edit-modal">Save Changes</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    activeModal = modal;
    
    modal.querySelector('.modal-close')?.addEventListener('click', () => { modal.remove(); activeModal = null; });
    modal.querySelector('.close-edit-modal')?.addEventListener('click', () => { modal.remove(); activeModal = null; });
    modal.querySelector('.save-edit-modal')?.addEventListener('click', () => {
        record.date = modal.querySelector('#editMaintDate').value || record.date;
        record.type = modal.querySelector('#editMaintType').value;
        record.tech = modal.querySelector('#editMaintTech').value || record.tech;
        record.cost = modal.querySelector('#editMaintCost').value || record.cost;
        record.desc = modal.querySelector('#editMaintDesc').value || record.desc;
        renderMaintenanceTable();
        showToast(`Maintenance record ${record.id} updated`);
        modal.remove();
        activeModal = null;
    });
    modal.addEventListener('click', (e) => { if (e.target === modal) { modal.remove(); activeModal = null; } });
}

// ==================== EQUIPMENT MODALS ====================

// View Equipment Details Modal
function showEquipmentViewModal(equipment) {
    if (activeModal) { activeModal.remove(); activeModal = null; }
    
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="modal-container" style="max-width:550px;">
            <div class="modal-header">
                <h2 class="modal-title">Equipment Details - ${equipment.id}</h2>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="text-sm font-medium text-gray-500">Equipment</label><p class="font-medium">${equipment.name}</p></div>
                        <div><label class="text-sm font-medium text-gray-500">Model</label><p class="font-medium">${equipment.model}</p></div>
                        <div><label class="text-sm font-medium text-gray-500">Serial Number</label><p class="font-medium">${equipment.serial}</p></div>
                        <div><label class="text-sm font-medium text-gray-500">Status</label><p>${getStatusBadge(equipment.status, 'equipment')}</p></div>
                        <div><label class="text-sm font-medium text-gray-500">Last Inspection</label><p class="font-medium">${equipment.lastInspection}</p></div>
                        <div><label class="text-sm font-medium text-gray-500">Next Inspection</label><p class="font-medium">${equipment.nextInspection}</p></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm hover:bg-gray-100 close-view-eq">Close</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    activeModal = modal;
    
    modal.querySelector('.modal-close')?.addEventListener('click', () => { modal.remove(); activeModal = null; });
    modal.querySelector('.close-view-eq')?.addEventListener('click', () => { modal.remove(); activeModal = null; });
    modal.addEventListener('click', (e) => { if (e.target === modal) { modal.remove(); activeModal = null; } });
}

// Record Inspection Modal
function showInspectionModal(equipment) {
    if (activeModal) { activeModal.remove(); activeModal = null; }
    
    const today = new Date().toISOString().split('T')[0];
    const threeMonths = new Date();
    threeMonths.setMonth(threeMonths.getMonth() + 3);
    const nextDate = threeMonths.toISOString().split('T')[0];
    
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="modal-container" style="max-width:500px;">
            <div class="modal-header">
                <h2 class="modal-title">Record Inspection - ${equipment.name}</h2>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="space-y-4">
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-3 rounded-md">
                        <p class="text-sm"><strong>Equipment:</strong> ${equipment.name} (${equipment.id})</p>
                        <p class="text-sm mt-1"><strong>Last Inspection:</strong> ${equipment.lastInspection}</p>
                    </div>
                    <div><label class="text-sm font-medium block mb-1">Inspection Date</label><input type="date" id="inspectionDate" value="${today}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                    <div><label class="text-sm font-medium block mb-1">Next Inspection Due</label><input type="date" id="nextInspectionDate" value="${nextDate}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                    <div><label class="text-sm font-medium block mb-1">Inspector Name</label><input type="text" id="inspectorName" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Enter inspector name"></div>
                    <div><label class="text-sm font-medium block mb-1">Result</label><select id="inspectionResult" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"><option value="Passed">Passed</option><option value="Needs Attention">Needs Attention</option><option value="Failed">Failed</option></select></div>
                    <div><label class="text-sm font-medium block mb-1">Notes</label><textarea id="inspectionNotes" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Inspection notes..."></textarea></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm hover:bg-gray-100 close-inspection-modal">Cancel</button>
                <button class="inline-flex rounded-md bg-primary px-4 py-2 text-sm text-white hover:bg-primary/90 save-inspection-modal">Save Inspection</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    activeModal = modal;
    
    modal.querySelector('.modal-close')?.addEventListener('click', () => { modal.remove(); activeModal = null; });
    modal.querySelector('.close-inspection-modal')?.addEventListener('click', () => { modal.remove(); activeModal = null; });
    modal.querySelector('.save-inspection-modal')?.addEventListener('click', () => {
        equipment.lastInspection = modal.querySelector('#inspectionDate').value;
        equipment.nextInspection = modal.querySelector('#nextInspectionDate').value;
        const result = modal.querySelector('#inspectionResult').value;
        if (result === 'Failed') equipment.status = 'Needs Inspection';
        else equipment.status = 'Operational';
        renderEquipmentTable();
        showToast(`Inspection recorded for ${equipment.name}`);
        modal.remove();
        activeModal = null;
    });
    modal.addEventListener('click', (e) => { if (e.target === modal) { modal.remove(); activeModal = null; } });
}

// Replace Equipment Modal
function showReplaceEquipmentModal(equipment) {
    if (activeModal) { activeModal.remove(); activeModal = null; }
    
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="modal-container" style="max-width:500px;">
            <div class="modal-header">
                <h2 class="modal-title">Replace Equipment - ${equipment.name}</h2>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="space-y-4">
                    <div class="bg-red-50 dark:bg-red-900/20 p-3 rounded-md">
                        <p class="text-sm text-red-800 dark:text-red-200">You are about to replace <strong>${equipment.name} (${equipment.id})</strong>. This will mark the current equipment as decommissioned.</p>
                    </div>
                    <div><label class="text-sm font-medium block mb-1">New Equipment Name *</label><input type="text" id="newEquipName" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="e.g., Defibrillator Pro"></div>
                    <div><label class="text-sm font-medium block mb-1">New Model</label><input type="text" id="newEquipModel" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Model number"></div>
                    <div><label class="text-sm font-medium block mb-1">New Serial Number</label><input type="text" id="newEquipSerial" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Serial number"></div>
                    <div><label class="text-sm font-medium block mb-1">Reason for Replacement</label><textarea id="replaceReason" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Reason for replacement..."></textarea></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm hover:bg-gray-100 close-replace-modal">Cancel</button>
                <button class="inline-flex rounded-md bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700 confirm-replace-modal">Replace Equipment</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    activeModal = modal;
    
    modal.querySelector('.modal-close')?.addEventListener('click', () => { modal.remove(); activeModal = null; });
    modal.querySelector('.close-replace-modal')?.addEventListener('click', () => { modal.remove(); activeModal = null; });
    modal.querySelector('.confirm-replace-modal')?.addEventListener('click', () => {
        const newName = modal.querySelector('#newEquipName').value.trim();
        if (!newName) { showToast('Please enter new equipment name', true); return; }
        const newModel = modal.querySelector('#newEquipModel').value.trim() || 'N/A';
        const newSerial = modal.querySelector('#newEquipSerial').value.trim() || 'N/A';
        const today = new Date().toISOString().split('T')[0];
        equipment.name = newName;
        equipment.model = newModel;
        equipment.serial = newSerial;
        equipment.lastInspection = today;
        equipment.status = 'Operational';
        renderEquipmentTable();
        showToast(`Equipment replaced with ${newName}`);
        modal.remove();
        activeModal = null;
    });
    modal.addEventListener('click', (e) => { if (e.target === modal) { modal.remove(); activeModal = null; } });
}

// Report Issue Modal
function showReportIssueModal(equipment) {
    if (activeModal) { activeModal.remove(); activeModal = null; }
    
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="modal-container" style="max-width:500px;">
            <div class="modal-header">
                <h2 class="modal-title">Report Issue - ${equipment.name}</h2>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="space-y-4">
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 p-3 rounded-md">
                        <p class="text-sm"><strong>Equipment:</strong> ${equipment.name} (${equipment.id})</p>
                        <p class="text-sm mt-1"><strong>Current Status:</strong> ${equipment.status}</p>
                    </div>
                    <div><label class="text-sm font-medium block mb-1">Issue Severity *</label><select id="issueSeverity" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"><option value="Low">Low - Minor issue</option><option value="Medium">Medium - Needs attention</option><option value="High">High - Critical issue</option></select></div>
                    <div><label class="text-sm font-medium block mb-1">Issue Description *</label><textarea id="issueDesc" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Describe the issue..."></textarea></div>
                    <div><label class="text-sm font-medium block mb-1">Reported By</label><input type="text" id="reportedBy" value="Wanjiru Sarah" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm hover:bg-gray-100 close-issue-modal">Cancel</button>
                <button class="inline-flex rounded-md bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700 submit-issue-modal">Submit Report</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    activeModal = modal;
    
    modal.querySelector('.modal-close')?.addEventListener('click', () => { modal.remove(); activeModal = null; });
    modal.querySelector('.close-issue-modal')?.addEventListener('click', () => { modal.remove(); activeModal = null; });
    modal.querySelector('.submit-issue-modal')?.addEventListener('click', () => {
        const severity = modal.querySelector('#issueSeverity').value;
        const desc = modal.querySelector('#issueDesc').value.trim();
        if (!desc) { showToast('Please describe the issue', true); return; }
        equipment.status = 'Needs Inspection';
        renderEquipmentTable();
        showToast(`Issue reported for ${equipment.name} (${severity} severity)`);
        modal.remove();
        activeModal = null;
    });
    modal.addEventListener('click', (e) => { if (e.target === modal) { modal.remove(); activeModal = null; } });
}

// ==================== CALL ASSIGNMENTS MODALS ====================

// View Call Details Modal
function showCallViewModal(call) {
    if (activeModal) { activeModal.remove(); activeModal = null; }
    
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="modal-container" style="max-width:550px;">
            <div class="modal-header">
                <h2 class="modal-title">Call Details - ${call.id}</h2>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="text-sm font-medium text-gray-500">Date & Time</label><p class="font-medium">${new Date(call.dateTime).toLocaleString()}</p></div>
                        <div><label class="text-sm font-medium text-gray-500">Patient</label><p class="font-medium">${call.patient}</p></div>
                        <div><label class="text-sm font-medium text-gray-500">Location</label><p class="font-medium">${call.location}</p></div>
                        <div><label class="text-sm font-medium text-gray-500">Reason</label><p class="font-medium">${call.reason}</p></div>
                        <div><label class="text-sm font-medium text-gray-500">Duration</label><p class="font-medium">${call.duration}</p></div>
                        <div><label class="text-sm font-medium text-gray-500">Status</label><p>${getStatusBadge(call.status)}</p></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm hover:bg-gray-100 close-view-call">Close</button>
                <button class="inline-flex rounded-md bg-primary px-4 py-2 text-sm text-white hover:bg-primary/90 print-view-call">Print</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    activeModal = modal;
    
    modal.querySelector('.modal-close')?.addEventListener('click', () => { modal.remove(); activeModal = null; });
    modal.querySelector('.close-view-call')?.addEventListener('click', () => { modal.remove(); activeModal = null; });
    modal.querySelector('.print-view-call')?.addEventListener('click', () => { showToast('Printing call details...'); setTimeout(() => window.print(), 300); });
    modal.addEventListener('click', (e) => { if (e.target === modal) { modal.remove(); activeModal = null; } });
}

// Edit Call Modal
function showCallEditModal(call) {
    if (activeModal) { activeModal.remove(); activeModal = null; }
    
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="modal-container" style="max-width:550px;">
            <div class="modal-header">
                <h2 class="modal-title">Edit Call - ${call.id}</h2>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="space-y-4">
                    <div><label class="text-sm font-medium block mb-1">Patient Name</label><input type="text" id="editCallPatient" value="${call.patient}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                    <div><label class="text-sm font-medium block mb-1">Location</label><input type="text" id="editCallLocation" value="${call.location}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                    <div><label class="text-sm font-medium block mb-1">Reason</label><select id="editCallReason" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"><option ${call.reason === 'Chest Pain' ? 'selected' : ''}>Chest Pain</option><option ${call.reason === 'Traffic Accident' ? 'selected' : ''}>Traffic Accident</option><option ${call.reason === 'Stroke Symptoms' ? 'selected' : ''}>Stroke Symptoms</option><option ${call.reason === 'Allergic Reaction' ? 'selected' : ''}>Allergic Reaction</option></select></div>
                    <div><label class="text-sm font-medium block mb-1">Duration</label><input type="text" id="editCallDuration" value="${call.duration}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                    <div><label class="text-sm font-medium block mb-1">Status</label><select id="editCallStatus" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"><option value="Completed" ${call.status === 'Completed' ? 'selected' : ''}>Completed</option><option value="In Progress">In Progress</option><option value="Pending">Pending</option></select></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm hover:bg-gray-100 close-edit-call">Cancel</button>
                <button class="inline-flex rounded-md bg-primary px-4 py-2 text-sm text-white hover:bg-primary/90 save-edit-call">Save Changes</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    activeModal = modal;
    
    modal.querySelector('.modal-close')?.addEventListener('click', () => { modal.remove(); activeModal = null; });
    modal.querySelector('.close-edit-call')?.addEventListener('click', () => { modal.remove(); activeModal = null; });
    modal.querySelector('.save-edit-call')?.addEventListener('click', () => {
        call.patient = modal.querySelector('#editCallPatient').value || call.patient;
        call.location = modal.querySelector('#editCallLocation').value || call.location;
        call.reason = modal.querySelector('#editCallReason').value;
        call.duration = modal.querySelector('#editCallDuration').value || call.duration;
        call.status = modal.querySelector('#editCallStatus').value;
        renderCallsTable();
        showToast(`Call ${call.id} updated`);
        modal.remove();
        activeModal = null;
    });
    modal.addEventListener('click', (e) => { if (e.target === modal) { modal.remove(); activeModal = null; } });
}

// Update renderCallsTable to include action menu triggers
function handleCallsClick(e) {
    e.stopPropagation();
    const id = this.getAttribute('data-id');
    showCallsActionMenu(this, id);
}

function renderMaintenanceTable() {
    const tbody = document.getElementById('maintenanceTableBody');
    tbody.innerHTML = maintenanceData.map(row => `
        <tr class="border-b hover:bg-gray-50">
            <td class="p-4 font-medium">${row.id}</td>
            <td class="p-4">${row.date}</td>
            <td class="p-4">${row.type}</td>
            <td class="p-4 hidden md:table-cell max-w-[300px] truncate">${row.desc}</td>
            <td class="p-4 hidden lg:table-cell">${row.tech}</td>
            <td class="p-4">${row.cost}</td>
            <td class="p-4">${getStatusBadge(row.status)}</td>
            <td class="p-4 text-right">
                <button class="action-btn-maintenance size-8 inline-flex items-center justify-center rounded-md hover:bg-gray-100" data-id="${row.id}">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="1"></circle>
                        <circle cx="19" cy="12" r="1"></circle>
                        <circle cx="5" cy="12" r="1"></circle>
                    </svg>
                </button>
            </td>
        </tr>
    `).join('');
    
    // Attach action menu event listeners
    document.querySelectorAll('.action-btn-maintenance').forEach(btn => {
        btn.removeEventListener('click', handleMaintenanceClick);
        btn.addEventListener('click', handleMaintenanceClick);
    });
}

function handleMaintenanceClick(e) {
    e.stopPropagation();
    const id = this.getAttribute('data-id');
    showMaintenanceActionMenu(this, id);
}

function renderEquipmentTable() {
    const tbody = document.getElementById('equipmentTableBody');
    tbody.innerHTML = equipmentData.map(row => `
        <tr class="border-b hover:bg-gray-50">
            <td class="p-4 font-medium">${row.id}</td>
            <td class="p-4">${row.name}</td>
            <td class="p-4 hidden md:table-cell">${row.model}</td>
            <td class="p-4 hidden lg:table-cell">${row.serial}</td>
            <td class="p-4">${row.lastInspection}<br><span class="text-xs text-gray-400">Next: ${row.nextInspection}</span></td>
            <td class="p-4">${getStatusBadge(row.status, 'equipment')}</td>
            <td class="p-4 text-right">
                <button class="action-btn-equipment size-8 inline-flex items-center justify-center rounded-md hover:bg-gray-100" data-id="${row.id}">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="1"></circle>
                        <circle cx="19" cy="12" r="1"></circle>
                        <circle cx="5" cy="12" r="1"></circle>
                    </svg>
                </button>
            </td>
        </tr>
    `).join('');
    
    // Attach action menu event listeners
    document.querySelectorAll('.action-btn-equipment').forEach(btn => {
        btn.removeEventListener('click', handleEquipmentClick);
        btn.addEventListener('click', handleEquipmentClick);
    });
}

function handleEquipmentClick(e) {
    e.stopPropagation();
    const id = this.getAttribute('data-id');
    showEquipmentActionMenu(this, id);
}

function renderCallsTable() {
    const tbody = document.getElementById('callsTableBody');
    if (!tbody) return;
    tbody.innerHTML = callsData.map(row => `
        <tr class="border-b hover:bg-gray-50">
            <td class="p-4 font-medium">${row.id}</td>
            <td class="p-4">${formatDateTime(row.dateTime)}</td>
            <td class="p-4">${row.patient}</td>
            <td class="p-4 hidden md:table-cell max-w-[200px] truncate">${row.location}</td>
            <td class="p-4 hidden lg:table-cell">${row.reason}</td>
            <td class="p-4">${row.duration}</td>
            <td class="p-4">${getStatusBadge(row.status)}</td>
            <td class="p-4 text-right">
                <button class="action-btn-calls size-8 inline-flex items-center justify-center rounded-md hover:bg-gray-100" data-id="${row.id}">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="1"/>
                        <circle cx="19" cy="12" r="1"/>
                        <circle cx="5" cy="12" r="1"/>
                    </svg>
                </button>
            </td>
        </tr>
    `).join('');
    
    // Attach action menu event listeners for calls
    document.querySelectorAll('.action-btn-calls').forEach(btn => {
        btn.removeEventListener('click', handleCallsClick);
        btn.addEventListener('click', handleCallsClick);
    });
}



// Tab switching
function switchTab(tabId) {
    document.getElementById('tab-overview').classList.add('hidden');
    document.getElementById('tab-maintenance').classList.add('hidden');
    document.getElementById('tab-equipment').classList.add('hidden');
    document.getElementById('tab-calls').classList.add('hidden');
    document.getElementById(`tab-${tabId}`).classList.remove('hidden');
    document.querySelectorAll('.tab-trigger').forEach(tab => { if(tab.getAttribute('data-tab') === tabId) tab.classList.add('active', 'bg-white', 'text-gray-900', 'shadow-sm'); else tab.classList.remove('active', 'bg-white', 'text-gray-900', 'shadow-sm'); });
}
document.querySelectorAll('.tab-trigger').forEach(tab => tab.addEventListener('click', () => switchTab(tab.getAttribute('data-tab'))));
document.querySelector('.tab-trigger[data-tab="overview"]').classList.add('active', 'bg-white', 'text-gray-900', 'shadow-sm');


// ==================== EQUIPMENT MODAL FUNCTIONS ====================
const equipmentModal = document.getElementById('addEquipmentModal');

function openEquipmentModal() {
    const today = new Date().toISOString().split('T')[0];
    const threeMonthsLater = new Date();
    threeMonthsLater.setMonth(threeMonthsLater.getMonth() + 3);
    const nextDate = threeMonthsLater.toISOString().split('T')[0];
    
    document.getElementById('equipmentLastInspection').value = today;
    document.getElementById('equipmentNextInspection').value = nextDate;
    document.getElementById('equipmentId').value = '';
    document.getElementById('equipmentName').value = '';
    document.getElementById('equipmentModel').value = '';
    document.getElementById('equipmentSerial').value = '';
    document.getElementById('equipmentStatus').value = 'Operational';
    equipmentModal.classList.remove('hidden');
}

function closeEquipmentModal() { equipmentModal.classList.add('hidden'); }

// Confirm Add Equipment
document.getElementById('confirmEquipmentBtn')?.addEventListener('click', () => {
    const id = document.getElementById('equipmentId').value.trim();
    const name = document.getElementById('equipmentName').value.trim();
    const model = document.getElementById('equipmentModel').value.trim();
    const serial = document.getElementById('equipmentSerial').value.trim();
    const lastInspection = document.getElementById('equipmentLastInspection').value;
    const nextInspection = document.getElementById('equipmentNextInspection').value;
    const status = document.getElementById('equipmentStatus').value;
    
    if (!id || !name || !lastInspection || !nextInspection) {
        showToast('Please fill in all required fields', true);
        return;
    }
    
    // Add to equipment data array
    equipmentData.push({
        id: id,
        name: name,
        model: model || 'N/A',
        serial: serial || 'N/A',
        lastInspection: lastInspection,
        nextInspection: nextInspection,
        status: status
    });
    
    // Re-render the table
    renderEquipmentTable();
    
    showToast(`Equipment ${name} added successfully`);
    closeEquipmentModal();
});

// Equipment Modal close buttons
document.getElementById('closeEquipmentModalBtn')?.addEventListener('click', closeEquipmentModal);
document.getElementById('cancelEquipmentBtn')?.addEventListener('click', closeEquipmentModal);

// Close equipment modal when clicking outside
equipmentModal?.addEventListener('click', (e) => { 
    if (e.target === equipmentModal) closeEquipmentModal(); 
});

// Close equipment modal on Escape
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && equipmentModal && !equipmentModal.classList.contains('hidden')) {
        closeEquipmentModal();
    }
});

// Attach Reschedule button to open maintenance modal
document.getElementById('rescheduleMaintenanceBtn')?.addEventListener('click', openMaintenanceModal);

// Attach Add Equipment button in equipment tab
const addEquipmentBtn = document.querySelector('#tab-equipment button');
if (addEquipmentBtn) {
    addEquipmentBtn.addEventListener('click', openEquipmentModal);
}

renderMaintenanceTable(); renderEquipmentTable(); renderCallsTable();
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
    <script src="js/meditrack-map.js"></script>
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
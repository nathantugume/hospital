<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
        <link rel="icon" type="image/png" href="favicon.png">
    <title>Medi-track | Insurance Claims</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    </script>    <!-- html2pdf library for PDF generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" crossorigin="anonymous"></script>
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .bg-background { background-color: #131212 !important; }
        body.dark .border-gray-200, body.dark .border-gray-300, body.dark .border-input { border-color: #333333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700, 
        body.dark .text-muted-foreground, body.dark label, body.dark h1, body.dark h2, body.dark h3 { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted { background-color: #262626 !important; }
        body.dark input, body.dark select { background-color: #262626 !important; border-color: #404040 !important; color: #e5e5e5 !important; }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .filter-popover, .date-picker-popover, .action-menu-popover {
            position: fixed;
            z-index: 1000;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            animation: fadeInScale 0.15s ease-out;
        }
        body.dark .filter-popover, body.dark .date-picker-popover, body.dark .action-menu-popover { background: #2a2a2a; border-color: #404040; }
        
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        
        /* Updated modern modal styles matching the card design */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgb(0 0 0 / 87%);
            backdrop-filter: blur(2px);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.2s ease-out;
        }
        .modern-modal {
            background: white;
            border-radius: 1rem;
            max-width: 950px;
            width: 95%;
            max-height: 90vh;
            overflow-y: auto;
            animation: slideUp 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        body.dark .modern-modal { background: #131212; border: 1px solid #2c2c2c; }
        
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        /* Sidebar transition */
        .sidebar-transition { transition: transform 0.3s ease-in-out; }
        .action-menu-item { cursor: pointer; }
        .action-btn { background: transparent; border: none; cursor: pointer; }
        .eye-icon { cursor: pointer; transition: all 0.2s; }
        .eye-icon:hover { transform: scale(1.1); color: #4f46e5; }
        
        /* Table responsive */
        @media (max-width: 768px) {
            .table-wrapper { overflow-x: auto; }
        }
        
        /* Toast notification */
        .toast-message {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #10b981;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
            font-size: 0.875rem;
        }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        /* Action Menu Popover */
.action-menu-popover {
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
body.dark .action-menu-popover { background: #2a2a2a; border-color: #404040; }
.action-menu-header { padding: 0.5rem 0.75rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb; margin-bottom: 0.25rem; }
body.dark .action-menu-header { color: #9ca3af; border-bottom-color: #404040; }
.action-menu-item {
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
.action-menu-item:hover { background-color: #f3f4f6; }
body.dark .action-menu-item:hover { background-color: #3f3f46; }
.action-menu-divider { height: 1px; background-color: #e5e7eb; margin: 0.25rem 0; }
body.dark .action-menu-divider { background-color: #404040; }
.action-menu-item.text-red { color: #ef4444; }
.action-menu-item.text-red:hover { background-color: #fee2e2; }
body.dark .action-menu-item.text-red:hover { background-color: rgba(239,68,68,0.1); }

/* Cancel Modal */
.alert-dialog-overlay {
    position: fixed;
    inset: 0;
    background-color: rgb(0 0 0 / 87%);
    backdrop-filter: blur(4px);
    z-index: 10001;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.15s ease-out;
}
.alert-dialog-overlay.hidden { display: none; }
.alert-dialog {
    position: fixed;
    left: 50%;
    top: 50%;
    z-index: 10002;
    transform: translate(-50%, -50%);
    width: 90%;
    max-width: 500px;
    background: white;
    border-radius: 0.75rem;
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    gap: 1rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    animation: modalSlideIn 0.2s ease-out;
}
body.dark .alert-dialog { background: #131212; border-color: #2a2a3a; }
.alert-dialog-header { display: flex; flex-direction: column; gap: 0.5rem; }
.alert-dialog-title { font-size: 1.125rem; font-weight: 600; }
.alert-dialog-description { font-size: 0.875rem; color: #6b7280; }
body.dark .alert-dialog-description { color: #9ca3af; }
.alert-dialog-footer { display: flex; flex-direction: column-reverse; gap: 0.5rem; margin-top: 0.5rem; }
@media (min-width: 640px) { .alert-dialog-footer { flex-direction: row; justify-content: flex-end; } }
.alert-dialog-cancel-btn { display: inline-flex; align-items: center; justify-content: center; border-radius: 0.375rem; border: 1px solid #e5e7eb; background-color: white; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; cursor: pointer; }
body.dark .alert-dialog-cancel-btn { background-color: #262626; border-color: #404040; color: #e5e5e5; }
.alert-dialog-delete-btn { display: inline-flex; align-items: center; justify-content: center; border-radius: 0.375rem; background-color: #ef4444; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500; color: white; cursor: pointer; border: none; }
.alert-dialog-delete-btn:hover { background-color: #dc2626; }


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

            <!-- Main Content Area -->
            <main class="flex-1 overflow-auto p-4 xl:p-6 xl:ml-64 w-full">  
            <div class="container mx-auto space-y-6">

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="flex items-center flex-wrap gap-4">
                    <a class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background  size-10 bg-background hover:bg-accent hover:text-accent-foreground h-10" href="billing.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                    </a>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2 text-gray-900">Insurance Claims</h1>
                        <p class="text-gray-500">Manage and track insurance claims for patient services.</p>
                    </div>
                </div>

                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-2">
                    <a class="bg-primary text-white hover:bg-primary/90 h-10 px-4 rounded-md text-sm flex items-center gap-2 transition" href="add-claim.html">
                        Add Insurance Claim
                    </a>
                    </div>


                    </div>
                </div>               

                <!-- Stats Cards -->
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition"><div class="pb-2"><h2 class="text-sm font-medium text-gray-500">Total Claims</h2></div><div class="pt-0"><div class="text-2xl font-bold text-gray-900" id="totalAmount">$0.00</div><p class="text-xs text-gray-500" id="totalCount">From 0 claims</p></div></div>
                    <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition"><div class="pb-2"><h2 class="text-sm font-medium text-gray-500">Approved Claims</h2></div><div class="pt-0"><div class="text-2xl font-bold text-gray-900" id="approvedAmount">$0.00</div><p class="text-xs text-gray-500" id="approvedCount">From 0 claims</p></div></div>
                    <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition"><div class="pb-2"><h2 class="text-sm font-medium text-gray-500">Pending Claims</h2></div><div class="pt-0"><div class="text-2xl font-bold text-gray-900" id="pendingAmount">$0.00</div><p class="text-xs text-gray-500" id="pendingCount">From 0 claims</p></div></div>
                    <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition"><div class="pb-2"><h2 class="text-sm font-medium text-gray-500">Claim Success Rate</h2></div><div class="pt-0"><div class="text-2xl font-bold text-gray-900" id="successRate">0%</div><p class="text-xs text-gray-500">Approval rate for submitted claims</p></div></div>
                </div>
                
                
                <!-- Filter Bar -->


                <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex gap-2 flex-wrap">
                        <div class="relative"><svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg><input id="searchInput" class="h-10 rounded-md border border-gray-300 bg-white px-3 py-2 pl-8 w-full md:w-[250px] focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm" placeholder="Search claims..."></div>
                        <button id="filterBtn" class="inline-flex items-center justify-center rounded-md border border-gray-300 shadow-sm bg-white hover:bg-gray-50 size-10"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg></button>
                        <button id="downloadBtn" class="inline-flex items-center justify-center rounded-md border border-gray-300 shadow-sm bg-white hover:bg-gray-50 size-10"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg></button>
                    </div>
                    <div class="relative">
                        <button id="dateRangeBtn" class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white h-10 px-4 text-sm w-[260px] justify-start hover:bg-gray-50"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 2v4M16 2v4M3 10h18"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect></svg><span id="dateRangeText">All Dates</span></button>
                        <div id="datePickerPopover" class="hidden date-picker-popover w-[260px] p-4"><div class="space-y-4"><div><label class="text-sm font-medium">Start Date</label><input type="date" id="startDateInput" class="w-full rounded-md border px-3 py-2 text-sm"></div><div><label class="text-sm font-medium">End Date</label><input type="date" id="endDateInput" class="w-full rounded-md border px-3 py-2 text-sm"></div><div class="flex gap-2 pt-2"><button id="applyDateBtn" class="flex-1 rounded-md bg-primary text-white py-2 text-sm">Apply</button><button id="cancelDateBtn" class="flex-1 rounded-md border bg-white py-2 text-sm">Cancel</button></div></div></div>
                    </div>
                </div>


                
                <div class="space-y-4">
                    <div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1">
                        <button data-tab="all" class="claims-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all bg-white text-indigo-700 shadow-sm">All Claims</button>
                        <button data-tab="approved" class="claims-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium text-gray-600">Approved</button>
                        <button data-tab="pending" class="claims-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium text-gray-600">Pending</button>
                        <button data-tab="rejected" class="claims-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium text-gray-600">Rejected</button>
                        <button data-tab="draft" class="claims-tab inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium text-gray-600">Draft</button>
                    </div>
                    <div id="allTab" class="tab-content active"></div>
                    <div id="approvedTab" class="tab-content"></div>
                    <div id="pendingTab" class="tab-content"></div>
                    <div id="rejectedTab" class="tab-content"></div>
                    <div id="draftTab" class="tab-content"></div>
                </div>



                <div id="claimDetailsContainer" class="hidden"></div>
            </div>
        </main>
    </div>

    <div id="filterPopover" class="hidden filter-popover w-72 p-4"><h3 class="font-medium mb-3">Filter Claims</h3><div class="space-y-4"><div><label class="text-sm font-medium block mb-2">Claim Type</label><div id="typeFilterOptions"></div></div><div><label class="text-sm font-medium block mb-2">Status</label><div id="statusFilterOptions"></div></div></div><div class="flex gap-2 mt-4"><button id="applyFilterBtn" class="flex-1 bg-primary text-white py-1.5 h-10 rounded-md text-sm">Apply</button><button id="resetFilterBtn" class="flex-1 border h-10 border-gray-300 bg-white py-1.5 rounded-md text-sm">Reset</button></div></div>




<!-- Cancel Claim Modal -->
<div id="cancelClaimModal" class="alert-dialog-overlay hidden">
    <div role="alertdialog" class="alert-dialog">
        <div class="alert-dialog-header">
            <h2 id="cancelModalTitle" class="alert-dialog-title">Are you sure you want to Cancel this claim?</h2>
            <p id="cancelModalDesc" class="alert-dialog-description">This action cannot be undone. The claim will be permanently cancelled.</p>
        </div>
        <div class="alert-dialog-footer">
            <button type="button" id="cancelModalCancelBtn" class="alert-dialog-cancel-btn">Keep </button>
            <button type="button" id="cancelModalConfirmBtn" class="alert-dialog-delete-btn">Cancel </button>
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


        function showToast(message, isError = false) { const existing = document.querySelector('.toast-message'); if(existing) existing.remove(); const toast = document.createElement('div'); toast.className = `toast-message ${isError ? 'error' : ''}`; toast.textContent = message; document.body.appendChild(toast); setTimeout(() => toast.remove(), 3000); }

        // ---------- CLAIMS DATA ----------
const allClaims = [
    { id: "CLM-001", patient: "Okello David", patientId: "P12345", provider: "AAR Insurance", policy: "BCBS123456789", groupNumber: "GRP987654321", relationship: "Self", date: "2024-04-15", amount: 200, approvedAmount: 180, status: "Approved", type: "Medical", paymentDate: "2024-04-22", patientResponsibility: 20, services: [{ name: "General Consultation", date: "2024-04-15", billed: 150, allowed: 135, patientResp: 15 },{ name: "Blood Test", date: "2024-04-15", billed: 50, allowed: 45, patientResp: 5 }], notes: "Claim approved with standard copay deduction", invoice: "INV-001" },
    { id: "CLM-002", patient: "Nakato Mary", patientId: "P23456", provider: "Jubilee Insurance", policy: "AET987654321", groupNumber: "GRP123456", relationship: "Self", date: "2024-04-16", amount: 280, approvedAmount: null, status: "Pending", type: "Medical", paymentDate: null, patientResponsibility: null, services: [], notes: "Awaiting insurance review", invoice: "INV-002" },
    { id: "CLM-003", patient: "Mwangi Peter", patientId: "P34567", provider: "UAP Old Mutual", policy: "UHC567891234", groupNumber: "GRP456789", relationship: "Spouse", date: "2024-04-10", amount: 140, approvedAmount: 140, status: "Approved", type: "Medical", paymentDate: "2024-04-20", patientResponsibility: 0, services: [], notes: "Full coverage approved", invoice: "INV-003" },
    { id: "CLM-004", patient: "Achieng Grace", patientId: "P45678", provider: "CIC Insurance", policy: "DD456789123", groupNumber: "GRP789012", relationship: "Self", date: "2024-04-05", amount: 416, approvedAmount: 350, status: "Approved", type: "Dental", paymentDate: "2024-04-18", patientResponsibility: 66, services: [], notes: "Partial coverage approved", invoice: "INV-004" },
    { id: "CLM-005", patient: "Kimera John", patientId: "P56789", provider: "Britam Insurance", policy: "CIG123789456", groupNumber: "GRP345678", relationship: "Self", date: "2024-04-18", amount: 360, approvedAmount: null, status: "Submitted", type: "Medical", paymentDate: null, patientResponsibility: null, services: [], notes: "Submitted for review", invoice: "INV-005" },
    { id: "CLM-006", patient: "Wanjiru Sarah", patientId: "P67890", provider: "APA Insurance", policy: "HUM789123456", groupNumber: "GRP901234", relationship: "Self", date: "2024-04-12", amount: 240, approvedAmount: 0, status: "Rejected", type: "Medical", paymentDate: null, patientResponsibility: 240, services: [], notes: "Service not covered", rejectionReason: "Service not covered under current policy", invoice: "INV-006" },
    { id: "CLM-007", patient: "Mukasa David", patientId: "P78901", provider: "Medi-track", policy: "MED123456789", groupNumber: "GRP567890", relationship: "Self", date: null, amount: 180, approvedAmount: null, status: "Draft", type: "Medical", paymentDate: null, patientResponsibility: null, services: [], notes: "Awaiting completion", invoice: "INV-007" },
    { id: "CLM-008", patient: "Nabwire Lisa", patientId: "P89012", provider: "Jubilee Insurance", policy: "AET456789123", groupNumber: "GRP234567", relationship: "Self", date: "2024-04-20", amount: 520, approvedAmount: null, status: "Submitted", type: "Dental", paymentDate: null, patientResponsibility: null, services: [], notes: "Electronically submitted to payer", invoice: "INV-008" }
];

        let currentTab = "all", searchQuery = "", filters = { type: "all", status: "all" }, dateRange = { start: null, end: null };
        function getStatusBadge(status) { const map = { "Approved":"bg-green-100 text-green-700", "Pending":"bg-amber-100 text-amber-700", "Submitted":"bg-blue-100 text-blue-700", "Rejected":"bg-red-100 text-red-700","Draft":"bg-gray-100 text-gray-700" }; return `<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ${map[status] || 'bg-gray-100 text-gray-700'}">${status}</span>`; }
        function getFilteredClaims() { let filtered = [...allClaims]; if(currentTab !== "all") filtered = filtered.filter(c => c.status.toLowerCase() === currentTab); if(searchQuery) { const q=searchQuery.toLowerCase(); filtered = filtered.filter(c=>c.id.toLowerCase().includes(q)||c.patient.toLowerCase().includes(q)||c.provider.toLowerCase().includes(q)); } if(filters.type !== "all") filtered = filtered.filter(c=>c.type === filters.type); if(filters.status !== "all") filtered = filtered.filter(c=>c.status === filters.status); if(dateRange.start && dateRange.end) filtered = filtered.filter(c=>c.date && c.date >= dateRange.start && c.date <= dateRange.end); return filtered; }
        function updateStats() { const all = allClaims.filter(c=>c.status!=="Draft"); const approved=all.filter(c=>c.status==="Approved"), pending=all.filter(c=>c.status==="Pending"); const totalAmt=all.reduce((s,c)=>s+c.amount,0), approvedAmt=approved.reduce((s,c)=>s+(c.approvedAmount||0),0), pendingAmt=pending.reduce((s,c)=>s+c.amount,0), rate=all.length?Math.round((approved.length/all.length)*100):0; document.getElementById('totalAmount').innerText=`$${totalAmt.toFixed(2)}`; document.getElementById('totalCount').innerText=`From ${all.length} claims`; document.getElementById('approvedAmount').innerText=`$${approvedAmt.toFixed(2)}`; document.getElementById('approvedCount').innerText=`From ${approved.length} claims`; document.getElementById('pendingAmount').innerText=`$${pendingAmt.toFixed(2)}`; document.getElementById('pendingCount').innerText=`From ${pending.length} claims`; document.getElementById('successRate').innerText=`${rate}%`; }
        function downloadCSV(data,filename){ if(!data.length)return; const headers=Object.keys(data[0]); const rows=[headers.join(',')]; data.forEach(row=>rows.push(headers.map(h=>`"${String(row[h]||'').replace(/"/g,'""')}"`).join(','))); const blob=new Blob(["\uFEFF"+rows.join('\n')],{type:'text/csv'}); const a=document.createElement('a');a.href=URL.createObjectURL(blob);a.download=filename;document.body.appendChild(a);a.click();document.body.removeChild(a);URL.revokeObjectURL(a.href); }
        
        // PDF generation function for claim
        function downloadClaimPDF(claim) {
            const element = document.createElement('div');
            element.innerHTML = `
                <div style="padding: 30px; font-family: 'Inter', sans-serif; max-width: 800px; margin: 0 auto;">
                    <div style="text-align: center; margin-bottom: 30px;">
                        <h1 style="margin: 0;">Medi-track Healthcare EA</h1>
                        <p style="margin: 5px 0; color: #666;">Insurance Claim Summary</p>
                        <hr style="margin: 15px 0;">
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 25px;">
                        <div><strong>Claim ID:</strong> ${claim.id}</div>
                        <div><strong>Status:</strong> ${claim.status}</div>
                        <div><strong>Date:</strong> ${claim.date || 'Not submitted'}</div>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <h3 style="border-bottom: 2px solid #4f46e5; padding-bottom: 8px;">Patient Information</h3>
                        <p><strong>Name:</strong> ${claim.patient}</p>
                        <p><strong>Patient ID:</strong> ${claim.patientId}</p>
                        <p><strong>Provider:</strong> ${claim.provider}</p>
                        <p><strong>Policy Number:</strong> ${claim.policy}</p>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <h3 style="border-bottom: 2px solid #4f46e5; padding-bottom: 8px;">Claim Details</h3>
                        <p><strong>Claim Amount:</strong> $${claim.amount.toFixed(2)}</p>
                        <p><strong>Approved Amount:</strong> ${claim.approvedAmount ? `$${claim.approvedAmount.toFixed(2)}` : '—'}</p>
                        <p><strong>Patient Responsibility:</strong> ${claim.patientResponsibility !== null ? `$${claim.patientResponsibility.toFixed(2)}` : '—'}</p>
                        <p><strong>Notes:</strong> ${claim.notes || 'No additional notes'}</p>
                    </div>
                    <div style="margin-top: 30px; text-align: center; font-size: 12px; color: #999;">
                        <hr>
                        <p>This is an official document from Medi-track. For any questions, please contact our billing department.</p>
                    </div>
                </div>
            `;
            html2pdf().from(element).set({ margin: 0.5, filename: `Claim_${claim.id}_${claim.patient}.pdf`, html2canvas: { scale: 2 }, jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' } }).save();
            showToast(`PDF download started for ${claim.id}`);
        }

        // Download EOB (Explanation of Benefits) as PDF
function downloadEOBAsPDF(claim) {
    const element = document.createElement('div');
    element.innerHTML = `
        <div style="padding: 30px; font-family: 'Inter', sans-serif; max-width: 800px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="margin: 0; color: #4f46e5;">Medi-track Healthcare EA</h1>
                <p style="margin: 5px 0;">Explanation of Benefits (EOB)</p>
                <hr style="margin: 15px 0;">
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 25px;">
                <div><strong>Claim ID:</strong> ${claim.id}</div>
                <div><strong>Status:</strong> ${claim.status}</div>
                <div><strong>Date of Service:</strong> ${claim.date || 'Not submitted'}</div>
            </div>
            <div style="margin-bottom: 20px;">
                <h3 style="border-bottom: 2px solid #4f46e5; padding-bottom: 8px;">Patient Information</h3>
                <p><strong>Name:</strong> ${claim.patient}</p>
                <p><strong>Patient ID:</strong> ${claim.patientId}</p>
                <p><strong>Insurance Provider:</strong> ${claim.provider}</p>
                <p><strong>Policy Number:</strong> ${claim.policy}</p>
            </div>
            <div style="margin-bottom: 20px;">
                <h3 style="border-bottom: 2px solid #4f46e5; padding-bottom: 8px;">Benefit Summary</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: 1px solid #ddd;"><td style="padding: 8px 0;"><strong>Amount Billed:</strong></td><td style="padding: 8px 0; text-align: right;">$${claim.amount.toFixed(2)}</td></tr>
                    <tr style="border-bottom: 1px solid #ddd;"><td style="padding: 8px 0;"><strong>Plan Discount:</strong></td><td style="padding: 8px 0; text-align: right;">$${(claim.amount - (claim.approvedAmount || 0)).toFixed(2)}</td></tr>
                    <tr style="border-bottom: 1px solid #ddd;"><td style="padding: 8px 0;"><strong>Plan Paid:</strong></td><td style="padding: 8px 0; text-align: right;">$${(claim.approvedAmount || 0).toFixed(2)}</td></tr>
                    <tr><td style="padding: 8px 0;"><strong>Patient Responsibility:</strong></td><td style="padding: 8px 0; text-align: right;"><strong>$${claim.patientResponsibility !== null ? claim.patientResponsibility.toFixed(2) : '0.00'}</strong></td></tr>
                </table>
            </div>
            <div style="margin-top: 30px; text-align: center; font-size: 12px; color: #999;">
                <hr>
                <p>This is not a bill. This is an explanation of benefits from Medi-track.</p>
                <p>For questions, contact billing@hospital.ug</p>
            </div>
        </div>
    `;
    html2pdf().from(element).set({ margin: 0.5, filename: `EOB_${claim.id}_${claim.patient}.pdf`, html2canvas: { scale: 2 }, jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' } }).save();
    showToast(`EOB PDF download started for ${claim.id}`);
}

// Download Receipt as PDF (with payment confirmation)
function downloadReceiptAsPDF(claim) {
    const element = document.createElement('div');
    element.innerHTML = `
        <div style="padding: 30px; font-family: 'Inter', sans-serif; max-width: 800px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="margin: 0; color: #4f46e5;">Medi-track Healthcare EA</h1>
                <p style="margin: 5px 0;">Payment Receipt</p>
                <hr style="margin: 15px 0;">
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 25px;">
                <div><strong>Receipt #:</strong> RCP-${claim.id}</div>
                <div><strong>Date:</strong> ${new Date().toLocaleDateString()}</div>
                <div><strong>Status:</strong> <span style="color: ${claim.status === 'Approved' ? 'green' : 'orange'}">${claim.status}</span></div>
            </div>
            <div style="margin-bottom: 20px;">
                <h3 style="border-bottom: 2px solid #4f46e5; padding-bottom: 8px;">Patient Details</h3>
                <p><strong>Name:</strong> ${claim.patient}</p>
                <p><strong>Patient ID:</strong> ${claim.patientId}</p>
                <p><strong>Insurance:</strong> ${claim.provider}</p>
            </div>
            <div style="margin-bottom: 20px;">
                <h3 style="border-bottom: 2px solid #4f46e5; padding-bottom: 8px;">Payment Details</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: 1px solid #ddd;"><td style="padding: 8px 0;"><strong>Total Billed Amount:</strong></td><td style="padding: 8px 0; text-align: right;">$${claim.amount.toFixed(2)}</td></tr>
                    <tr style="border-bottom: 1px solid #ddd;"><td style="padding: 8px 0;"><strong>Insurance Payment:</strong></td><td style="padding: 8px 0; text-align: right;">$${(claim.approvedAmount || 0).toFixed(2)}</td></tr>
                    <tr style="border-bottom: 1px solid #ddd;"><td style="padding: 8px 0;"><strong>Patient Payment:</strong></td><td style="padding: 8px 0; text-align: right;">$${claim.patientResponsibility !== null ? claim.patientResponsibility.toFixed(2) : '0.00'}</td></tr>
                    ${claim.paymentDate ? `<tr><td style="padding: 8px 0;"><strong>Payment Date:</strong></td><td style="padding: 8px 0; text-align: right;">${claim.paymentDate}</td></tr>` : ''}
                </table>
            </div>
            ${claim.services && claim.services.length > 0 ? `
            <div style="margin-bottom: 20px;">
                <h3 style="border-bottom: 2px solid #4f46e5; padding-bottom: 8px;">Service Breakdown</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead><tr style="background: #f3f4f6;"><th style="padding: 8px; text-align: left;">Service</th><th style="padding: 8px; text-align: right;">Billed</th><th style="padding: 8px; text-align: right;">Patient Resp.</th></tr></thead>
                    <tbody>${claim.services.map(s => `<tr><td style="padding: 8px; border-bottom: 1px solid #eee;">${s.name}</td><td style="padding: 8px; text-align: right; border-bottom: 1px solid #eee;">$${s.billed.toFixed(2)}</td><td style="padding: 8px; text-align: right; border-bottom: 1px solid #eee;">$${s.patientResp.toFixed(2)}</td></tr>`).join('')}</tbody>
                </table>
            </div>
            ` : ''}
            <div style="margin-top: 30px; text-align: center; font-size: 12px; color: #999;">
                <hr>
                <p>Thank you for choosing Medi-track. This is your official payment receipt.</p>
                <p>Amount Paid: <strong>$${claim.patientResponsibility !== null ? claim.patientResponsibility.toFixed(2) : '0.00'}</strong></p>
            </div>
        </div>
    `;
    html2pdf().from(element).set({ margin: 0.5, filename: `Receipt_${claim.id}_${claim.patient}.pdf`, html2canvas: { scale: 2 }, jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' } }).save();
    showToast(`Receipt PDF download started for ${claim.id}`);
}

        // MODERN MODAL with Eye icon changed to Download PDF button, and View Invoice now goes to invoice.html
        function showModernClaimModal(claim) {
            const modalOverlay = document.createElement('div');
            modalOverlay.className = 'modal-overlay';
            const hasServices = claim.services && claim.services.length > 0;
            const serviceRows = hasServices ? claim.services.map(s => `<tr class="border-b"><td class="p-3 align-middle">${s.name}</td><td class="p-3">${s.date}</td><td class="p-3 text-right">$${s.billed.toFixed(2)}</td><td class="p-3 text-right">$${s.allowed.toFixed(2)}</td><td class="p-3 text-right">$${s.patientResp.toFixed(2)}</td></tr>`).join('') : '<tr><td colspan="5" class="p-4 text-center text-muted-foreground">No service line items</td></tr>';
            
            const approvedAmountDisplay = claim.approvedAmount ? `$${claim.approvedAmount.toFixed(2)}` : '—';
            const patientRespDisplay = claim.patientResponsibility !== null ? `$${claim.patientResponsibility.toFixed(2)}` : '—';
            const paymentDateDisplay = claim.paymentDate || '—';
            
            modalOverlay.innerHTML = `
                <div class="modern-modal w-full max-w-4xl mx-4">
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
                        <div class="flex flex-col space-y-1.5 p-3 md:p-4 xxl:p-6 border-b">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h2 class="text-xl xl:text-2xl font-semibold leading-tight mb-1 tracking-tight">Claim Details</h2>
                                    <div class="text-sm text-muted-foreground">View detailed information about a selected claim.</div>
                                </div>
                                <button class="close-modal-btn text-gray-400 hover:text-gray-600"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6L6 18M6 6l12 12"/></svg></button>
                            </div>
                        </div>
                        <div class="p-3 md:p-4 xxl:p-6">
                            <div class="space-y-6">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div><h3 class="text-lg font-medium">${claim.id}</h3><p class="text-sm text-muted-foreground">${claim.provider} • Submitted on ${claim.date || 'Not submitted'}</p></div>
                                    <div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold w-fit ${claim.status === 'Approved' ? 'bg-green-500 text-white' : claim.status === 'Pending' ? 'bg-amber-500 text-white' : claim.status === 'Rejected' ? 'bg-red-500 text-white' : 'bg-gray-400 text-white'}">${claim.status}</div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-4"><h4 class="font-medium">Patient Information</h4><div class="flex items-center gap-3"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full bg-indigo-100 items-center justify-center text-indigo-700 font-semibold">${claim.patient.charAt(0)}</span><div><p class="font-medium">${claim.patient}</p><p class="text-sm text-muted-foreground">ID: ${claim.patientId}</p></div></div><div class="space-y-1 text-sm"><p>Policy Number: ${claim.policy}</p><p>Group Number: ${claim.groupNumber}</p><p>Relationship: ${claim.relationship}</p></div></div>
                                    <div class="space-y-4"><h4 class="font-medium">Claim Information</h4><div class="space-y-1 text-sm"><div class="flex justify-between"><p>Claim Type:</p><p class="font-medium">${claim.type}</p></div><div class="flex justify-between"><p>Claim Amount:</p><p class="font-medium">$${claim.amount.toFixed(2)}</p></div><div class="flex justify-between"><p>Approved Amount:</p><p class="font-medium">${approvedAmountDisplay}</p></div><div class="flex justify-between"><p>Patient Responsibility:</p><p class="font-medium">${patientRespDisplay}</p></div><div class="flex justify-between"><p>Payment Date:</p><p class="font-medium">${paymentDateDisplay}</p></div></div></div>
                                </div>
                                <div class="space-y-4"><h4 class="font-medium">Services & Procedures</h4><div class="relative w-full overflow-auto"><table class="w-full caption-bottom text-sm"><thead class="border-b"><tr><th class="h-10 px-2 text-left">Service</th><th class="h-10 px-2 text-left">Date</th><th class="h-10 px-2 text-right">Billed</th><th class="h-10 px-2 text-right">Allowed</th><th class="h-10 px-2 text-right">Patient Resp.</th></tr></thead><tbody>${serviceRows}</tbody></table></div></div>
                                <div class="space-y-2"><h4 class="font-medium">Notes</h4><p class="text-sm">${claim.notes || 'No additional notes'}</p>${claim.rejectionReason ? `<p class="text-sm text-red-600">Rejection reason: ${claim.rejectionReason}</p>` : ''}</div>
<div class="flex justify-end gap-2 flex-wrap">
    <!-- Download EOB (as PDF) -->
    <button class="download-eob-btn inline-flex items-center justify-center gap-2 border border-input bg-background hover:bg-accent h-10 rounded-md px-3 text-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>Download EOB</button>
    
    <!-- Download Receipt (as PDF) -->
    <button class="download-receipt-btn inline-flex items-center justify-center gap-2 border border-input bg-background hover:bg-accent h-10 rounded-md px-3 text-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"/><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/><path d="M12 17.5v-11"/></svg>Download Receipt</button>
    
    <!-- View Invoice (redirects to invoice.html) -->
    <button class="view-invoice-redirect-btn inline-flex items-center justify-center gap-2 border border-input bg-background hover:bg-accent h-10 rounded-md px-3 text-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>View Invoice</button>
    
    <!-- Mark as Reconciled -->
    <button class="mark-reconciled-btn inline-flex items-center justify-center gap-2 bg-primary text-primary-foreground hover:bg-primary/90 h-10 rounded-md px-3 text-sm bg-primary text-white"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.801 10A10 10 0 1 1 17 3.335"/><path d="m9 11 3 3L22 4"/></svg>Mark as Reconciled</button>
</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modalOverlay);
            const closeBtn = modalOverlay.querySelector('.close-modal-btn');
            const closeModal = () => modalOverlay.remove();
            closeBtn.addEventListener('click', closeModal);
            modalOverlay.addEventListener('click', (e) => { if(e.target === modalOverlay) closeModal(); });

            // Download EOB as PDF (shorter document - just claim summary)
modalOverlay.querySelector('.download-eob-btn')?.addEventListener('click', () => { 
    downloadEOBAsPDF(claim); 
});

// Download Receipt as PDF (detailed with payment breakdown)
modalOverlay.querySelector('.download-receipt-btn')?.addEventListener('click', () => { 
    downloadReceiptAsPDF(claim); 
});

// View Invoice button - redirect to invoice.html
modalOverlay.querySelector('.view-invoice-redirect-btn')?.addEventListener('click', () => { 
    window.location.href = `invoice.html?id=${claim.id}`; 
});
            
            modalOverlay.querySelector('.mark-reconciled-btn')?.addEventListener('click', () => { alert(`Claim ${claim.id} marked as reconciled.`); closeModal(); });
        }
        
function renderAllTab(claims) {
    const container = document.getElementById('allTab');
    if(!claims.length){ container.innerHTML=`<div class="rounded-lg border bg-white p-8 text-center text-gray-500">No claims found</div>`; return; }
    let html=`<div class="rounded-lg border bg-white shadow-sm overflow-x-auto"><table class="w-full caption-bottom text-sm whitespace-nowrap"><thead class="bg-gray-50 border-b"><tr><th class="h-12 px-4 text-left">Claim ID</th><th class="h-12 px-4 text-left">Patient</th><th class="h-12 px-4 text-left">Provider</th><th class="h-12 px-4 text-left">Type</th><th class="h-12 px-4 text-left">Submitted</th><th class="h-12 px-4 text-right">Amount</th><th class="h-12 px-4 text-left">Status</th><th class="h-12 px-4 text-right">Actions</th></tr></thead><tbody>`;
    claims.forEach(claim => { html+=`<tr class="border-b hover:bg-gray-50"><td class="p-4 font-medium">${claim.id}</td><td class="p-4"><div class="flex items-center gap-3"><img src="user.png" class="h-8 w-8 rounded-full object-cover" "="" alt="User profile photo"><span>${claim.patient}</span></div></td><td class="p-4">${claim.provider}</td><td class="p-4"><span class="inline-flex rounded-full px-2 py-0.5 text-xs bg-gray-100 text-gray-700">${claim.type}</span></td><td class="p-4">${claim.date || '—'}</td><td class="p-4 text-right">$${claim.amount.toFixed(2)}</td><td class="p-4">${getStatusBadge(claim.status)}</td><td class="p-4 text-right"><button class="action-trigger-btn inline-flex h-8 w-8 items-center justify-center rounded-md hover:bg-gray-100" data-id="${claim.id}"><svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg></button></td></tr>`; });
    html+=`</tbody></table></div>`;
    container.innerHTML = html;
    container.querySelectorAll('.action-trigger-btn').forEach(btn => btn.addEventListener('click', (e) => { e.stopPropagation(); const claim = allClaims.find(c=>c.id===btn.dataset.id); if(claim) showClaimActionMenu(btn, claim); }));
}


        
        function renderSimpleTab(containerId, claims, columns, displayFields) { 
            const container = document.getElementById(containerId);
            if(!claims.length){ container.innerHTML=`<div class="rounded-lg border bg-white p-8 text-center">No claims found</div>`; return; }
            let html=`<div class="rounded-lg border bg-white shadow-sm overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr>${columns.map(col=>`<th class="p-3 text-left">${col}</th>`).join('')}<th class="p-3 text-right">View</th></tr></thead><tbody>`;
            claims.forEach(claim => { html+=`<tr class="border-b hover:bg-gray-50 cursor-pointer simple-view" data-id="${claim.id}">${columns.map(col=>{ if(col==='Amount') return `<td class="p-3 text-right">$${claim.amount.toFixed(2)}</td>`; if(col==='Status') return `<td class="p-3">${getStatusBadge(claim.status)}</td>`; return `<td class="p-3">${claim[displayFields[col]] || '—'}</td>`; }).join('')}<td class="p-3 text-right"><button class="view-text-btn text-indigo-600 hover:text-indigo-800 text-sm font-medium" data-id="${claim.id}">View</button></td></tr>`; });
            html+=`</tbody></div>`;
            container.innerHTML = html;
// View text button redirects to claim-details.html
container.querySelectorAll('.view-text-btn').forEach(btn => btn.addEventListener('click', (e) => { 
    e.stopPropagation(); 
    const claimId = btn.dataset.id;
    window.location.href = `claim-details.html?id=${claimId}`; 
}));

// Clicking on table row opens modal
container.querySelectorAll('.simple-view').forEach(row => row.addEventListener('click', (e) => { 
    if(!e.target.closest('.view-text-btn')){ 
        const claim = allClaims.find(c=>c.id===row.dataset.id); 
        if(claim) showModernClaimModal(claim); 
    } 
}));            container.querySelectorAll('.view-detail-btn').forEach(btn => btn.addEventListener('click', (e) => { e.stopPropagation(); const claim = allClaims.find(c=>c.id===btn.closest('tr').dataset.id); if(claim) showModernClaimModal(claim); }));
        }
        function renderApprovedTab(claims) {
    const container = document.getElementById('approvedTab');
    if(!claims.length){ container.innerHTML=`<div class="rounded-lg border bg-white p-8 text-center">No approved claims found</div>`; return; }
    let html=`<div class="rounded-lg border bg-white shadow-sm overflow-x-auto"><table class="w-full caption-bottom text-sm whitespace-nowrap"><thead class="bg-gray-50 border-b"><tr><th class="h-12 px-4 text-left">Claim ID</th><th class="h-12 px-4 text-left">Patient</th><th class="h-12 px-4 text-left">Provider</th><th class="h-12 px-4 text-right">Amount</th><th class="h-12 px-4 text-left">Payment Date</th><th class="h-12 px-4 text-right">Actions</th></tr></thead><tbody>`;
    claims.forEach(claim => { html+=`<tr class="border-b hover:bg-gray-50"><td class="p-4 font-medium">${claim.id}</td><td class="p-4"><div class="flex items-center gap-3"><img src="user.png" class="h-8 w-8 rounded-full object-cover" "="" alt="User profile photo"><span>${claim.patient}</span></div></td><td class="p-4">${claim.provider}</td><td class="p-4 text-right">$${claim.amount.toFixed(2)}</td><td class="p-4">${claim.paymentDate || '—'}</td><td class="p-4 text-right"><div class="flex justify-end gap-2"><button class="view-details-btn inline-flex items-center gap-2 border bg-white hover:bg-gray-50 rounded-md px-3 h-9 text-sm" data-id="${claim.id}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text h-4 w-4"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>View Details</button></div></td></tr>`; });
    html+=`</tbody></table></div>`;
    container.innerHTML = html;
    container.querySelectorAll('.view-details-btn').forEach(btn => btn.addEventListener('click', (e) => { e.stopPropagation(); const claim = allClaims.find(c=>c.id===btn.dataset.id); if(claim) showModernClaimModal(claim); }));
    container.querySelectorAll('.download-claim-btn').forEach(btn => btn.addEventListener('click', (e) => { e.stopPropagation(); const claim = allClaims.find(c=>c.id===btn.dataset.id); if(claim) downloadClaimPDF(claim); }));
}
        function renderPendingTab(claims) {
    const container = document.getElementById('pendingTab');
    if(!claims.length){ container.innerHTML=`<div class="rounded-lg border bg-white p-8 text-center">No pending claims found</div>`; return; }
    let html=`<div class="rounded-lg border bg-white shadow-sm overflow-x-auto"><table class="w-full caption-bottom text-sm whitespace-nowrap"><thead class="bg-gray-50 border-b"><tr><th class="h-12 px-4 text-left">Claim ID</th><th class="h-12 px-4 text-left">Patient</th><th class="h-12 px-4 text-left">Provider</th><th class="h-12 px-4 text-left">Submitted</th><th class="h-12 px-4 text-right">Amount</th><th class="h-12 px-4 text-left">Status</th><th class="h-12 px-4 text-right">Actions</th></tr></thead><tbody>`;
    claims.forEach(claim => { html+=`<tr class="border-b hover:bg-gray-50"><td class="p-4 font-medium">${claim.id}</td><td class="p-4"><div class="flex items-center gap-3"><img src="user.png" class="h-8 w-8 rounded-full object-cover" "="" alt="User profile photo"><span>${claim.patient}</span></div></td><td class="p-4">${claim.provider}</td><td class="p-4">${claim.date || '—'}</td><td class="p-4 text-right">$${claim.amount.toFixed(2)}</td><td class="p-4"><div class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold border-amber-500 text-amber-500">${claim.status}</div></td><td class="p-4 text-right"><div class="flex justify-end gap-2"><button class="check-status-btn inline-flex items-center gap-2 bg-primary text-white hover:bg-primary/90 rounded-md px-3 h-9 text-sm" data-id="${claim.id}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert h-4 w-4"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg><span class="hidden sm:inline">Check Status</span></button><button class="view-details-btn inline-flex items-center gap-2 border bg-white hover:bg-gray-50 rounded-md px-3 h-9 text-sm" data-id="${claim.id}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text h-4 w-4"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg><span class="hidden sm:inline">Details</span></button></div></td></tr>`; });
    html+=`</tbody></table></div>`;
    container.innerHTML = html;
container.querySelectorAll('.check-status-btn').forEach(btn => btn.addEventListener('click', (e) => { 
    e.stopPropagation(); 
    const claim = allClaims.find(c => c.id === btn.dataset.id); 
    if (claim) showCheckStatusModal(claim); // Changed from showModernClaimModal
}));    container.querySelectorAll('.view-details-btn').forEach(btn => btn.addEventListener('click', (e) => { e.stopPropagation(); const claim = allClaims.find(c=>c.id===btn.dataset.id); if(claim) showModernClaimModal(claim); }));
}
        function renderRejectedTab(claims) {
    const container = document.getElementById('rejectedTab');
    if(!claims.length){ container.innerHTML=`<div class="rounded-lg border bg-white p-8 text-center">No rejected claims found</div>`; return; }
    let html=`<div class="rounded-lg border bg-white shadow-sm overflow-x-auto"><table class="w-full caption-bottom text-sm whitespace-nowrap"><thead class="bg-gray-50 border-b"><tr><th class="h-12 px-4 text-left">Claim ID</th><th class="h-12 px-4 text-left">Patient</th><th class="h-12 px-4 text-left">Provider</th><th class="h-12 px-4 text-right">Amount</th><th class="h-12 px-4 text-left hidden md:table-cell">Rejection Reason</th><th class="h-12 px-4 text-right">Actions</th></tr></thead><tbody>`;
    claims.forEach(claim => { html+=`<tr class="border-b hover:bg-gray-50"><td class="p-4 font-medium">${claim.id}</td><td class="p-4"><div class="flex items-center gap-3"><img src="user.png" class="h-8 w-8 rounded-full object-cover" "="" alt="User profile photo"><span>${claim.patient}</span></div></td><td class="p-4">${claim.provider}</td><td class="p-4 text-right">$${claim.amount.toFixed(2)}</td><td class="p-4 hidden md:table-cell">${claim.rejectionReason || '—'}</td><td class="p-4 text-right"><button class="resubmit-btn inline-flex items-center gap-2 bg-primary text-white hover:bg-primary/90 rounded-md px-3 h-9 text-sm" data-id="${claim.id}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send h-4 w-4"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg><span class="hidden sm:inline">Resubmit</span></button></td></tr>`; });
    html+=`</tbody></table></div>`;
    container.innerHTML = html;
    container.querySelectorAll('.resubmit-btn').forEach(btn => btn.addEventListener('click', (e) => { e.stopPropagation(); const claim = allClaims.find(c=>c.id===btn.dataset.id); if(claim) { showToast(`Resubmitting claim ${claim.id}...`); } }));
}
        function renderDraftTab(claims) {
    const container = document.getElementById('draftTab');
    if(!claims.length){ container.innerHTML=`<div class="rounded-lg border bg-white p-8 text-center">No draft claims found</div>`; return; }
    let html=`<div class="rounded-lg border bg-white shadow-sm overflow-x-auto"><table class="w-full caption-bottom text-sm whitespace-nowrap"><thead class="bg-gray-50 border-b"><tr><th class="h-12 px-4 text-left">Claim ID</th><th class="h-12 px-4 text-left">Patient</th><th class="h-12 px-4 text-left">Provider</th><th class="h-12 px-4 text-right">Amount</th><th class="h-12 px-4 text-left hidden md:table-cell">Invoice</th><th class="h-12 px-4 text-right">Actions</th></tr></thead><tbody>`;
    claims.forEach(claim => { html+=`<tr class="border-b hover:bg-gray-50"><td class="p-4 font-medium">${claim.id}</td><td class="p-4"><div class="flex items-center gap-3"><img src="user.png" class="h-8 w-8 rounded-full object-cover" "="" alt="User profile photo"><span>${claim.patient}</span></div></td><td class="p-4">${claim.provider}</td><td class="p-4 text-right">$${claim.amount.toFixed(2)}</td><td class="p-4 hidden md:table-cell">${claim.invoice || '—'}</td><td class="p-4 text-right"><div class="flex justify-end gap-2"><button class="submit-draft-btn inline-flex items-center gap-2 bg-primary text-white hover:bg-primary/90 rounded-md px-3 h-9 text-sm" data-id="${claim.id}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send h-4 w-4"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg><span class="hidden sm:inline">Submit</span></button><button class="edit-draft-btn inline-flex items-center gap-2 border bg-white hover:bg-gray-50 rounded-md px-3 h-9 text-sm" data-id="${claim.id}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text h-4 w-4"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg><span class="hidden sm:inline">Edit</span></button></div></td></tr>`; });
    html+=`</tbody></table></div>`;
    container.innerHTML = html;
    container.querySelectorAll('.submit-draft-btn').forEach(btn => btn.addEventListener('click', (e) => { e.stopPropagation(); const claim = allClaims.find(c=>c.id===btn.dataset.id); if(claim) { claim.status = 'Pending'; showToast(`Claim ${claim.id} submitted!`); renderCurrentTab(); } }));
    container.querySelectorAll('.edit-draft-btn').forEach(btn => btn.addEventListener('click', (e) => { e.stopPropagation(); const claim = allClaims.find(c=>c.id===btn.dataset.id); if(claim) showModernClaimModal(claim); }));
}

// ==================== ACTION MENU & CANCEL MODAL ====================
let activeActionMenu = null;
let cancelTargetClaim = null;

function closeActionMenu() { if (activeActionMenu) { activeActionMenu.remove(); activeActionMenu = null; } }

function showClaimActionMenu(btn, claim) {
    closeActionMenu();
    const rect = btn.getBoundingClientRect();
    const menu = document.createElement('div');
    menu.className = 'action-menu-popover';
    let left = rect.left;
    let top = rect.bottom + 6;
    if (left + 220 > window.innerWidth) left = window.innerWidth - 230;
    if (top + 300 > window.innerHeight) top = rect.top - 310;
    menu.style.top = `${top}px`;
    menu.style.left = `${left}px`;

    let menuHTML = `<div class="action-menu-header">Actions</div>`;
    
    // View Details - always available
    menuHTML += `<button data-action="view" class="action-menu-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text h-4 w-4"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>View Details</button>`;

    if (claim.status === 'Approved') {
        menuHTML += `<div class="action-menu-divider"></div>`;
        menuHTML += `<button data-action="download" class="action-menu-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download h-4 w-4"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>Download Claim</button>`;
    }

    if (claim.status === 'Pending' || claim.status === 'Submitted') {
        menuHTML += `<button data-action="check-status" class="action-menu-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-alert h-4 w-4"><circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/></svg>Check Status</button>`;
        menuHTML += `<div class="action-menu-divider"></div>`;
        menuHTML += `<button data-action="download" class="action-menu-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download h-4 w-4"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>Download Claim</button>`;
        menuHTML += `<button data-action="cancel" class="action-menu-item text-red">Cancel Claim</button>`;
    }

    if (claim.status === 'Rejected') {
        menuHTML += `<button data-action="resubmit" class="action-menu-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send h-4 w-4"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg>Resubmit Claim</button>`;
        menuHTML += `<div class="action-menu-divider"></div>`;
        menuHTML += `<button data-action="download" class="action-menu-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download h-4 w-4"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>Download Claim</button>`;
        menuHTML += `<button data-action="cancel" class="action-menu-item text-red">Cancel Claim</button>`;
    }

    if (claim.status === 'Draft') {
        menuHTML += `<button data-action="submit-claim" class="action-menu-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send h-4 w-4"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"/><path d="m21.854 2.147-10.94 10.939"/></svg>Submit Claim</button>`;
        menuHTML += `<div class="action-menu-divider"></div>`;
        menuHTML += `<button data-action="download" class="action-menu-item"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download h-4 w-4"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>Download Claim</button>`;
        menuHTML += `<button data-action="cancel" class="action-menu-item text-red">Cancel Claim</button>`;
    }

    menu.innerHTML = menuHTML;
    document.body.appendChild(menu);
    activeActionMenu = menu;

    const closeHandler = (e) => { if (!menu.contains(e.target) && e.target !== btn) { closeActionMenu(); document.removeEventListener('click', closeHandler); } };
    setTimeout(() => document.addEventListener('click', closeHandler), 10);

    menu.querySelector('[data-action="view"]')?.addEventListener('click', () => { showModernClaimModal(claim); closeActionMenu(); });
    menu.querySelector('[data-action="download"]')?.addEventListener('click', () => { downloadClaimPDF(claim); closeActionMenu(); });
menu.querySelector('[data-action="check-status"]')?.addEventListener('click', () => { 
    showCheckStatusModal(claim); // Changed from showModernClaimModal
    closeActionMenu(); 
});    menu.querySelector('[data-action="resubmit"]')?.addEventListener('click', () => { showToast(`Resubmitting claim ${claim.id}...`); closeActionMenu(); });
    menu.querySelector('[data-action="submit-claim"]')?.addEventListener('click', () => { claim.status = 'Pending'; claim.date = new Date().toISOString().slice(0,10); showToast(`Claim ${claim.id} submitted!`); renderCurrentTab(); closeActionMenu(); });
    menu.querySelector('[data-action="cancel"]')?.addEventListener('click', () => { openCancelClaimModal(claim); closeActionMenu(); });
}

// Cancel Claim Modal Functions
function openCancelClaimModal(claim) {
    cancelTargetClaim = claim;
    document.getElementById('cancelModalTitle').textContent = `Are you sure you want to Cancel claim ${claim.id}?`;
    document.getElementById('cancelModalDesc').textContent = `This action cannot be undone. The claim for ${claim.patient} ($${claim.amount.toFixed(2)}) will be permanently cancelled.`;
    document.getElementById('cancelClaimModal').classList.remove('hidden');
}

function closeCancelClaimModal() {
    document.getElementById('cancelClaimModal').classList.add('hidden');
    cancelTargetClaim = null;
}

function confirmCancelClaim() {
    if (cancelTargetClaim) {
        const idx = allClaims.indexOf(cancelTargetClaim);
        if (idx > -1) allClaims.splice(idx, 1);
        showToast(`Claim ${cancelTargetClaim.id} has been cancelled`);
        renderCurrentTab();
    }
    closeCancelClaimModal();
}

// ============================================
// CHECK STATUS MODAL - Shared Function
// ============================================
function showCheckStatusModal(claim) {
    const existingModal = document.getElementById('statusModal');
    if (existingModal) existingModal.remove();
    
    const modal = document.createElement('div');
    modal.id = 'statusModal';
    modal.className = 'modal-overlay';
    modal.style.cssText = 'position:fixed;inset:0;background:rgb(0 0 0 / 87%);z-index:10000;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(4px);';
    
    const statusSteps = getClaimStatusSteps(claim);
    
    modal.innerHTML = `
        <div style="background:white;border-radius:0.75rem;width:90%;max-width:480px;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);animation:slideUp 0.2s ease;">
            <div style="display:flex;justify-content:space-between;align-items:center;padding:1.25rem 1.5rem;border-bottom:1px solid #e5e7eb;">
                <h2 style="font-size:1.125rem;font-weight:600;">Claim Status - ${claim.id}</h2>
                <button class="close-status-modal" style="background:none;border:none;font-size:1.5rem;cursor:pointer;color:#6b7280;">&times;</button>
            </div>
            <div style="padding:1.5rem;">
                <div style="display:flex;flex-direction:column;gap:0;">
                    ${statusSteps.map((step, index) => `
                        <div style="display:flex;gap:12px;padding-bottom:${index < statusSteps.length - 1 ? '16px' : '0'};">
                            <div style="display:flex;flex-direction:column;align-items:center;">
                                <div style="width:28px;height:28px;border-radius:50%;background:${step.completed ? '#22c55e' : step.current ? '#f59e0b' : '#e5e7eb'};display:flex;align-items:center;justify-content:center;${step.current ? 'animation:pulse 2s infinite;' : ''}">
                                    ${step.completed ? `<svg style="width:14px;height:14px;color:white;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>` : 
                                    step.current ? `<svg style="width:14px;height:14px;color:white;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>` :
                                    `<svg style="width:14px;height:14px;color:#9ca3af;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>`}
                                </div>
                                ${index < statusSteps.length - 1 ? `<div style="width:2px;flex:1;background:${step.completed ? '#22c55e' : '#e5e7eb'};min-height:20px;"></div>` : ''}
                            </div>
                            <div style="padding-bottom:${index < statusSteps.length - 1 ? '8px' : '0'};">
                                <p style="font-weight:600;font-size:0.875rem;${step.current ? 'color:#f59e0b;' : step.completed ? '' : 'color:#9ca3af;'}">${step.label}</p>
                                <p style="font-size:0.75rem;color:#6b7280;">${step.date}</p>
                                <p style="font-size:0.75rem;color:#6b7280;">${step.description}</p>
                            </div>
                        </div>
                    `).join('')}
                </div>
                
                <div style="margin-top:16px;padding:12px;background:#f9fafb;border-radius:0.5rem;border:1px solid #e5e7eb;">
                    <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                        <span style="font-size:0.8rem;color:#6b7280;">Claim ID:</span>
                        <span style="font-size:0.8rem;font-weight:500;">${claim.id}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                        <span style="font-size:0.8rem;color:#6b7280;">Patient:</span>
                        <span style="font-size:0.8rem;font-weight:500;">${claim.patient}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                        <span style="font-size:0.8rem;color:#6b7280;">Provider:</span>
                        <span style="font-size:0.8rem;font-weight:500;">${claim.provider}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;margin-bottom:6px;">
                        <span style="font-size:0.8rem;color:#6b7280;">Amount:</span>
                        <span style="font-size:0.8rem;font-weight:600;">$${claim.amount.toFixed(2)}</span>
                    </div>
                    <div style="display:flex;justify-content:space-between;">
                        <span style="font-size:0.8rem;color:#6b7280;">Current Status:</span>
                        <span style="font-size:0.8rem;font-weight:600;color:${claim.status === 'Approved' ? '#22c55e' : claim.status === 'Pending' ? '#f59e0b' : claim.status === 'Rejected' ? '#ef4444' : '#6b7280'};">${claim.status}</span>
                    </div>
                </div>
            </div>
            <div style="display:flex;justify-content:flex-end;gap:0.75rem;padding:1rem 1.5rem;border-top:1px solid #e5e7eb;">
                <button class="close-status-modal" style="background:white;border:1px solid #d1d5db;border-radius:0.375rem;padding:0.5rem 1rem;font-size:0.875rem;cursor:pointer;">Close</button>
                <button class="view-full-claim-btn bg-primary hover:bg-primary/90" style="color:white;border:none;border-radius:0.375rem;padding:0.5rem 1rem;font-size:0.875rem;cursor:pointer;">View Full Claim</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    const closeModal = () => modal.remove();
    
    modal.querySelectorAll('.close-status-modal').forEach(btn => {
        btn.addEventListener('click', closeModal);
    });
    
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });
    
    modal.querySelector('.view-full-claim-btn')?.addEventListener('click', () => {
        closeModal();
        showModernClaimModal(claim);
    });
    
    // Escape key
    const escHandler = (e) => {
        if (e.key === 'Escape') {
            closeModal();
            document.removeEventListener('keydown', escHandler);
        }
    };
    document.addEventListener('keydown', escHandler);
}

function getClaimStatusSteps(claim) {
    const steps = [];
    
    // Step 1: Draft/Created
    steps.push({
        label: 'Claim Created',
        date: claim.date || 'Pending creation',
        description: `Claim ${claim.id} was created for ${claim.patient}`,
        completed: true,
        current: false
    });
    
    // Step 2: Submitted
    if (claim.status === 'Draft') {
        steps.push({
            label: 'Submitted to Payer',
            date: 'Not yet submitted',
            description: 'Claim needs to be submitted for processing',
            completed: false,
            current: false
        });
        steps.push({
            label: 'Under Review',
            date: 'Pending submission',
            description: 'Awaiting insurance review',
            completed: false,
            current: false
        });
        steps.push({
            label: 'Claim Processed',
            date: 'Pending',
            description: 'Final determination pending',
            completed: false,
            current: false
        });
    } else if (claim.status === 'Pending' || claim.status === 'Submitted') {
        steps.push({
            label: 'Submitted to Payer',
            date: claim.date || 'Recently submitted',
            description: 'Claim has been submitted to insurance provider',
            completed: true,
            current: false
        });
        steps.push({
            label: 'Under Review',
            date: 'In progress',
            description: 'Insurance provider is reviewing the claim',
            completed: false,
            current: true
        });
        steps.push({
            label: 'Claim Processed',
            date: 'Pending review',
            description: 'Final determination pending',
            completed: false,
            current: false
        });
    } else if (claim.status === 'Approved') {
        steps.push({
            label: 'Submitted to Payer',
            date: claim.date,
            description: 'Claim submitted to insurance provider',
            completed: true,
            current: false
        });
        steps.push({
            label: 'Under Review',
            date: claim.date,
            description: 'Insurance provider reviewed the claim',
            completed: true,
            current: false
        });
        steps.push({
            label: 'Claim Approved',
            date: claim.paymentDate || claim.date,
            description: `Approved amount: $${(claim.approvedAmount || 0).toFixed(2)}`,
            completed: true,
            current: true
        });
    } else if (claim.status === 'Rejected') {
        steps.push({
            label: 'Submitted to Payer',
            date: claim.date,
            description: 'Claim submitted to insurance provider',
            completed: true,
            current: false
        });
        steps.push({
            label: 'Under Review',
            date: claim.date,
            description: 'Insurance provider reviewed the claim',
            completed: true,
            current: false
        });
        steps.push({
            label: 'Claim Rejected',
            date: claim.date,
            description: claim.rejectionReason || 'Claim was not approved',
            completed: false,
            current: true
        });
    }
    
    return steps;
}

document.getElementById('cancelModalCancelBtn')?.addEventListener('click', closeCancelClaimModal);
document.getElementById('cancelModalConfirmBtn')?.addEventListener('click', confirmCancelClaim);
document.getElementById('cancelClaimModal')?.addEventListener('click', (e) => { if (e.target === document.getElementById('cancelClaimModal')) closeCancelClaimModal(); });
document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { closeActionMenu(); closeCancelClaimModal(); } });


        function renderCurrentTab() { const filtered=getFilteredClaims(); if(currentTab==='all') renderAllTab(filtered); else if(currentTab==='approved') renderApprovedTab(filtered); else if(currentTab==='pending') renderPendingTab(filtered); else if(currentTab==='rejected') renderRejectedTab(filtered); else if(currentTab==='draft') renderDraftTab(filtered); updateStats(); }
        
        document.querySelectorAll('.claims-tab').forEach(tab=>{ tab.addEventListener('click',()=>{ currentTab=tab.dataset.tab; document.querySelectorAll('.claims-tab').forEach(t=>{ t.classList.remove('bg-white','text-indigo-700','shadow-sm'); t.classList.add('text-gray-600'); }); tab.classList.add('bg-white','text-indigo-700','shadow-sm'); document.querySelectorAll('.tab-content').forEach(c=>c.classList.remove('active')); document.getElementById(`${currentTab}Tab`).classList.add('active'); renderCurrentTab(); }); });
        document.getElementById('searchInput').addEventListener('input',(e)=>{ searchQuery=e.target.value; renderCurrentTab(); });
        const dateBtn=document.getElementById('dateRangeBtn'),datePop=document.getElementById('datePickerPopover'); dateBtn?.addEventListener('click',(e)=>{ e.stopPropagation(); const rect=dateBtn.getBoundingClientRect(); datePop.style.top=`${rect.bottom+8}px`; datePop.style.left=`${rect.left}px`; datePop.classList.toggle('hidden'); });
        document.getElementById('applyDateBtn')?.addEventListener('click',()=>{ const start=document.getElementById('startDateInput').value,end=document.getElementById('endDateInput').value; if(start&&end){ dateRange.start=start; dateRange.end=end; document.getElementById('dateRangeText').innerText=`${start} to ${end}`; } else { dateRange.start=null; dateRange.end=null; document.getElementById('dateRangeText').innerText='All Dates'; } datePop.classList.add('hidden'); renderCurrentTab(); });
        document.getElementById('cancelDateBtn')?.addEventListener('click',()=>datePop.classList.add('hidden'));
        const filterBtn=document.getElementById('filterBtn'),filterPop=document.getElementById('filterPopover'); filterBtn?.addEventListener('click',(e)=>{ e.stopPropagation(); const types=[...new Set(allClaims.map(c=>c.type))]; let typeHtml=`<div class="flex items-center space-x-2"><input type="radio" name="typeFilter" value="all" id="type-all" ${filters.type==='all'?'checked':''}><label>All Types</label></div>`; types.forEach(t=>{ typeHtml+=`<div class="flex items-center space-x-2"><input type="radio" name="typeFilter" value="${t}" id="type-${t}" ${filters.type===t?'checked':''}><label>${t}</label></div>`; }); let statusHtml=`<div class="flex items-center space-x-2"><input type="radio" name="statusFilter" value="all" id="status-all" ${filters.status==='all'?'checked':''}><label>All Statuses</label></div>`; ['Approved','Pending','Rejected','Draft'].forEach(s=>{ statusHtml+=`<div class="flex items-center space-x-2"><input type="radio" name="statusFilter" value="${s}" id="status-${s}" ${filters.status===s?'checked':''}><label>${s}</label></div>`; }); document.getElementById('typeFilterOptions').innerHTML=typeHtml; document.getElementById('statusFilterOptions').innerHTML=statusHtml; const rect=filterBtn.getBoundingClientRect(); filterPop.style.top=`${rect.bottom+8}px`; filterPop.style.left=`${rect.left}px`; filterPop.classList.toggle('hidden'); });
        document.getElementById('applyFilterBtn')?.addEventListener('click',()=>{ const selectedType=document.querySelector('input[name="typeFilter"]:checked'); const selectedStatus=document.querySelector('input[name="statusFilter"]:checked'); if(selectedType) filters.type=selectedType.value; if(selectedStatus) filters.status=selectedStatus.value; filterPop.classList.add('hidden'); renderCurrentTab(); });
        document.getElementById('resetFilterBtn')?.addEventListener('click',()=>{ filters={type:"all",status:"all"}; filterPop.classList.add('hidden'); renderCurrentTab(); });
        document.getElementById('downloadBtn').addEventListener('click',()=>{ const filtered=getFilteredClaims(); downloadCSV(filtered.map(c=>({"Claim ID":c.id,"Patient":c.patient,"Provider":c.provider,"Amount":c.amount,"Status":c.status})),`claims_${currentTab}.csv`); });
        renderCurrentTab();
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
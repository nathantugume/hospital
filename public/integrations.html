<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Integrations</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <!-- <script src="https://cdn.tailwindcss.com" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" href="style.css">    
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .bg-background { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted { background-color: #262626 !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        [data-state="inactive"][role="tabpanel"] { display: none; }
        [data-state="active"][role="tabpanel"] { display: block; animation: fadeIn 0.2s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Switch styling */
        .switch-root {
            all: unset;
            position: relative;
            display: inline-flex;
            align-items: center;
            width: 44px;
            height: 24px;
            border-radius: 9999px;
            background-color: #cbd5e1;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .switch-root[data-state="checked"] { background-color: #171717; }
        .switch-root[data-state="unchecked"] { background-color: #94a3b8; }
        .switch-thumb {
            display: block;
            width: 20px;
            height: 20px;
            background-color: white;
            border-radius: 9999px;
            transition: transform 0.2s;
            transform: translateX(2px);
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .switch-root[data-state="checked"] .switch-thumb { transform: translateX(22px); }
        
        /* Toast notification */
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background-color: #10b981;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 1000;
            animation: slideIn 0.3s ease-out;
            font-size: 14px;
            font-weight: 500;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        /* Copy feedback */
        .copy-feedback {
            position: absolute;
            background: #1f2937;
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
            white-space: nowrap;
            z-index: 100;
        }

        /* Modal Overlay & Dialog */
.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgb(0 0 0 / 87%);
    backdrop-filter: blur(4px);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.2s ease-out;
}
.alert-dialog {
    position: fixed;
    left: 50%;
    top: 50%;
    z-index: 10001;
    transform: translate(-50%, -50%);
    width: 90%;
    max-width: 500px;
    background: white;
    border-radius: 0.75rem;
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    animation: modalSlideIn 0.2s ease-out;
}
body.dark .alert-dialog { background: #1e1e1e; border-color: #333; }
.alert-dialog-header { margin-bottom: 1rem; }
.alert-dialog-title { font-size: 1.125rem; font-weight: 600; margin-bottom: 0.5rem; }
.alert-dialog-description { font-size: 0.875rem; color: #6b7280; }
.alert-dialog-footer { display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.5rem; }
.alert-dialog-cancel {
    padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500;
    cursor: pointer; background: transparent; border: 1px solid #d1d5db; color: #374151;
}
.alert-dialog-cancel:hover { background: #f3f4f6; }
body.dark .alert-dialog-cancel { border-color: #404040; color: #e5e5e5; }
body.dark .alert-dialog-cancel:hover { background: #2a2a2a; }
.alert-dialog-confirm {
    padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500;
    cursor: pointer; color: white; border: none;
}
.alert-dialog-delete {
    padding: 0.5rem 1rem; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500;
    cursor: pointer; background: #ef4444; color: white; border: none;
}
.alert-dialog-delete:hover { background: #dc2626; }
.alert-dialog-close {
    position: absolute; right: 12px; top: 12px; background: transparent; border: none;
    font-size: 1.25rem; cursor: pointer; color: #9ca3af; padding: 4px; border-radius: 4px; line-height: 1;
}
.alert-dialog-close:hover { color: #374151; background: #f3f4f6; }
body.dark .alert-dialog-close:hover { color: #e5e5e5; background: #333; }
.alert-dialog-form-group { margin-bottom: 1rem; }
.alert-dialog-form-group label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.375rem; color: #374151; }
body.dark .alert-dialog-form-group label { color: #d1d5db; }
.alert-dialog-input {
    width: 100%; height: 40px; border-radius: 0.375rem; border: 1px solid #d1d5db;
    background: white; padding: 0 0.75rem; font-size: 0.875rem; outline: none;
}
.alert-dialog-input:focus { border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99,102,241,0.1); }
body.dark .alert-dialog-input { background: #111; border-color: #404040; color: #e5e5e5; }
.alert-dialog-select {
    width: 100%; height: 40px; border-radius: 0.375rem; border: 1px solid #d1d5db;
    background: white; padding: 0 0.75rem; font-size: 0.875rem; cursor: pointer; outline: none;
}
body.dark .alert-dialog-select { background: #111; border-color: #404040; color: #e5e5e5; }
/* Checkbox list */
.scope-checkbox { display: flex; align-items: center; gap: 8px; padding: 6px 0; font-size: 0.875rem; }
.scope-checkbox input[type="checkbox"] { width: 16px; height: 16px; cursor: pointer; }
/* Usage Stats */
.usage-stat { text-align: center; padding: 12px; }
.usage-stat-value { font-size: 1.5rem; font-weight: 700; }
.usage-stat-label { font-size: 0.75rem; color: #6b7280; margin-top: 2px; }
body.dark .usage-stat-label { color: #9ca3af; }


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


<div class="container mx-auto md:p-6 lg:p-8">
                <!-- Header with Back button -->
                <div class="flex items-center justify-between gap-4 flex-wrap">
                    <div class="flex items-center gap-2 flex-wrap">
<a class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background  size-10 bg-background hover:bg-accent hover:text-accent-foreground h-10" href="settings.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  class="h-4 w-4"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                            <span class="sr-only">Back</span>
                        </a>
                        <h2 class="text-2xl font-bold tracking-tight">Integrations</h2>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
<button id="refreshBtn" class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium border border-input bg-background hover:bg-gray-100 h-10 px-4 py-2 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  class="mr-2 h-4 w-4"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path><path d="M8 16H3v5"></path></svg>Refresh Status
</button>
<button id="usageBtn" class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium border border-input bg-background hover:bg-gray-100 h-10 px-4 py-2 transition-colors">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  class="mr-2 h-4 w-4"><path d="M3 3v16a2 2 0 0 0 2 2h16"></path><path d="M18 17V9"></path><path d="M13 17V5"></path><path d="M8 17v-3"></path></svg>Usage Analytics
</button>
                    </div>
                </div>

                <!-- Tabs Container -->
                <div dir="ltr" data-orientation="horizontal" class="w-full pt-4">
                    <div role="tablist" aria-orientation="horizontal" class="flex-wrap items-center rounded-md bg-muted p-1 text-muted-foreground grid w-full grid-cols-3 md:w-[400px]" id="tabList">
                        <button type="button" role="tab" data-tab="active" class="tab-trigger inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all active">Active</button>
                        <button type="button" role="tab" data-tab="available" class="tab-trigger inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Available</button>
                        <button type="button" role="tab" data-tab="settings" class="tab-trigger inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Settings</button>
                    </div>

                    <!-- Active Tab Panel -->
                    <div id="tab-active" role="tabpanel" data-state="active" class="mt-4 space-y-6 pt-2">
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            <!-- Africa's Talking SMS -->
                            <div class="rounded-lg border bg-background shadow-sm">
                                <div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">Africa's Talking SMS</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-700">Connected</div></div><div class="text-sm text-gray-500 mt-1">SMS gateway for Uganda, Kenya, Tanzania, Rwanda, Burundi, Ethiopia</div></div>
                                <div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-red-50 p-2"><svg class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div><div><p class="text-sm font-medium">Africa's Talking</p><p class="text-xs text-gray-400">Sender ID: MEDITRACK • 2,450 credits</p></div></div><button type="button" role="switch" data-switch="sms" aria-checked="true" data-state="checked" class="switch-root"><span class="switch-thumb"></span></button></div></div>
                                <div class="p-4 pt-0"><button class="configure-btn w-full rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm transition-colors" data-integration="AfricasTalking">Configure</button></div>
                            </div>
                            <!-- MTN MoMo -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">MTN MoMo</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-700">Connected</div></div><div class="text-sm text-gray-500 mt-1">Uganda mobile money collections + disbursements</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-yellow-50 p-2"><svg class="h-6 w-6 text-yellow-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg></div><div><p class="text-sm font-medium">MTN Mobile Money</p><p class="text-xs text-gray-400">Account: ****4589 • Sandbox</p></div></div><button type="button" role="switch" data-switch="mtn" aria-checked="true" data-state="checked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="configure-btn w-full rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm transition-colors" data-integration="MTNMoMo">Configure</button></div></div>
                            <!-- Airtel Money -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">Airtel Money</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-700">Connected</div></div><div class="text-sm text-gray-500 mt-1">Uganda mobile money collections</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-red-50 p-2"><svg class="h-6 w-6 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg></div><div><p class="text-sm font-medium">Airtel Money Uganda</p><p class="text-xs text-gray-400">Account: ****1234 • Sandbox</p></div></div><button type="button" role="switch" data-switch="airtel" aria-checked="true" data-state="checked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="configure-btn w-full rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm transition-colors" data-integration="AirtelMoney">Configure</button></div></div>
                            <!-- M-Pesa Kenya -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">M-Pesa</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-700">Connected</div></div><div class="text-sm text-gray-500 mt-1">Kenya Safaricom M-Pesa STK Push + C2B</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-green-50 p-2"><svg class="h-6 w-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg></div><div><p class="text-sm font-medium">Safaricom M-Pesa</p><p class="text-xs text-gray-400">Shortcode: 174379 • Sandbox</p></div></div><button type="button" role="switch" data-switch="mpesa" aria-checked="true" data-state="checked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="configure-btn w-full rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm transition-colors" data-integration="MPesa">Configure</button></div></div>
                            <!-- NIRA (Uganda National ID) -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">NIRA — National ID</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-700">Connected</div></div><div class="text-sm text-gray-500 mt-1">Uganda National Identification & Registration Authority</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-blue-50 p-2"><svg class="h-6 w-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><rect width="20" height="14" x="2" y="5" rx="2"/><circle cx="12" cy="12" r="3"/></svg></div><div><p class="text-sm font-medium">NIRA Uganda</p><p class="text-xs text-gray-400">12,450 verifications this month</p></div></div><button type="button" role="switch" data-switch="nira" aria-checked="true" data-state="checked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="configure-btn w-full rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm transition-colors" data-integration="NIRA">Configure</button></div></div>
                            <!-- Twilio Emergency Voice -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">Twilio Emergency Voice</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-700">Connected</div></div><div class="text-sm text-gray-500 mt-1">Emergency voice calls for ambulance dispatch & code blue alerts</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-red-50 p-2"><svg class="h-6 w-6 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div><div><p class="text-sm font-medium">Twilio Voice</p><p class="text-xs text-gray-400">From: +256 700 000 000</p></div></div><button type="button" role="switch" data-switch="twilio" aria-checked="true" data-state="checked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="configure-btn w-full rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm transition-colors" data-integration="Twilio">Configure</button></div></div>
                            <!-- Ambulance GPS Tracking -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">Ambulance GPS Tracking</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-700">Connected</div></div><div class="text-sm text-gray-500 mt-1">Real-time ambulance GPS via OnTrack Uganda</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-indigo-50 p-2"><svg class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div><div><p class="text-sm font-medium">OnTrack GPS</p><p class="text-xs text-gray-400">5 ambulances tracked • 30s interval</p></div></div><button type="button" role="switch" data-switch="gps" aria-checked="true" data-state="checked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="configure-btn w-full rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm transition-colors" data-integration="GPS">Configure</button></div></div>
                            <!-- LIS Integration -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">Lab Information System</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-700">Connected</div></div><div class="text-sm text-gray-500 mt-1">HL7 + FHIR R4 bridge to lab analyzers</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-purple-50 p-2"><svg class="h-6 w-6 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M4.18 4.18A2 2 0 0 0 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 1.82-1.18"/><path d="M21 15.5V6a2 2 0 0 0-2-2H9.5"/><path d="M16 2v4"/><path d="M12 2v4"/><path d="M8 2v4"/><path d="M20 10H4"/></svg></div><div><p class="text-sm font-medium">LabConnect EA</p><p class="text-xs text-gray-400">FHIR R4 + HL7 v2.5</p></div></div><button type="button" role="switch" data-switch="lis" aria-checked="true" data-state="checked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="configure-btn w-full rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm transition-colors" data-integration="LIS">Configure</button></div></div>
                            <!-- NMS Pharmacy Supply Chain -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">NMS Uganda</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-700">Connected</div></div><div class="text-sm text-gray-500 mt-1">National Medical Stores pharmacy supply chain</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-emerald-50 p-2"><svg class="h-6 w-6 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg></div><div><p class="text-sm font-medium">National Medical Stores</p><p class="text-xs text-gray-400">Account: NMS-12345 • 3 orders pending</p></div></div><button type="button" role="switch" data-switch="nms" aria-checked="true" data-state="checked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="configure-btn w-full rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm transition-colors" data-integration="NMS">Configure</button></div></div>
                        </div>
                    </div>

                    <!-- Available Tab Panel — Additional EA integrations -->
                    <div id="tab-available" role="tabpanel" data-state="inactive" class="hidden mt-4 space-y-6 pt-2">
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            <!-- NHIF Kenya -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">NHIF Kenya</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">National Hospital Insurance Fund — Kenya</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-green-50 p-2"><svg class="h-6 w-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/></svg></div><div><p class="text-sm font-medium">NHIF Kenya</p><p class="text-xs text-gray-400">Verify coverage + submit claims</p></div></div><button type="button" role="switch" data-switch="nhif-kenya" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="NHIFKenya"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                            <!-- NHIF Tanzania -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">NHIF Tanzania</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">National Health Insurance Fund — Tanzania</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-yellow-50 p-2"><svg class="h-6 w-6 text-yellow-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/></svg></div><div><p class="text-sm font-medium">NHIF Tanzania</p><p class="text-xs text-gray-400">Verify + claim submission</p></div></div><button type="button" role="switch" data-switch="nhif-tz" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="NHIFTanzania"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                            <!-- RSSB Rwanda -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">RSSB Rwanda</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">Rwanda Social Security Board — Health Insurance</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-blue-50 p-2"><svg class="h-6 w-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/></svg></div><div><p class="text-sm font-medium">RSSB Rwanda</p><p class="text-xs text-gray-400">Mutuelle de Santé integration</p></div></div><button type="button" role="switch" data-switch="rssb-rw" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="RSSBRwanda"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                            <!-- NIIMS / Huduma Namb Kenya -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">NIIMS (Huduma Namb)</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">Kenya National Identity Management System</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-red-50 p-2"><svg class="h-6 w-6 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><rect width="20" height="14" x="2" y="5" rx="2"/><circle cx="12" cy="12" r="3"/></svg></div><div><p class="text-sm font-medium">NIIMS Kenya</p><p class="text-xs text-gray-400">Huduma Namb ID verification</p></div></div><button type="button" role="switch" data-switch="niims" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="NIIMS"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                            <!-- NIDA Tanzania -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">NIDA Tanzania</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">National Identification Authority of Tanzania</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-emerald-50 p-2"><svg class="h-6 w-6 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><rect width="20" height="14" x="2" y="5" rx="2"/><circle cx="12" cy="12" r="3"/></svg></div><div><p class="text-sm font-medium">NIDA Tanzania</p><p class="text-xs text-gray-400">National ID verification</p></div></div><button type="button" role="switch" data-switch="nida-tz" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="NIDA"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                            <!-- NIDA Rwanda -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">NIDA Rwanda</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">National Identification Agency of Rwanda</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-sky-50 p-2"><svg class="h-6 w-6 text-sky-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><rect width="20" height="14" x="2" y="5" rx="2"/><circle cx="12" cy="12" r="3"/></svg></div><div><p class="text-sm font-medium">NIDA Rwanda</p><p class="text-xs text-gray-400">Amakuru y'umwirondoro</p></div></div><button type="button" role="switch" data-switch="nida-rw" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="NIDARwanda"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                            <!-- Jubilee Insurance -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">Jubilee Insurance</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">East African insurance — pre-auth + claims</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-indigo-50 p-2"><svg class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/></svg></div><div><p class="text-sm font-medium">Jubilee Insurance</p><p class="text-xs text-gray-400">UG / KE / TZ coverage</p></div></div><button type="button" role="switch" data-switch="jubilee" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="Jubilee"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                            <!-- UAP Old Mutual -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">UAP Old Mutual</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">Pan-African insurance — pre-auth + claims</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-rose-50 p-2"><svg class="h-6 w-6 text-rose-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/></svg></div><div><p class="text-sm font-medium">UAP Old Mutual</p><p class="text-xs text-gray-400">UG / KE / TZ / RW</p></div></div><button type="button" role="switch" data-switch="uap" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="UAP"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                            <!-- Britam -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">Britam Insurance</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">British-American Insurance — East Africa</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-orange-50 p-2"><svg class="h-6 w-6 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/></svg></div><div><p class="text-sm font-medium">Britam</p><p class="text-xs text-gray-400">Health + life insurance</p></div></div><button type="button" role="switch" data-switch="britam" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="Britam"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                            <!-- KEMSA -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">KEMSA Kenya</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">Kenya Medical Supplies Authority</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-emerald-50 p-2"><svg class="h-6 w-6 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/></svg></div><div><p class="text-sm font-medium">KEMSA</p><p class="text-xs text-gray-400">Kenya supply chain</p></div></div><button type="button" role="switch" data-switch="kemsa" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="KEMSA"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                            <!-- MSD Tanzania -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">MSD Tanzania</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">Medical Stores Department — Tanzania</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-yellow-50 p-2"><svg class="h-6 w-6 text-yellow-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/></svg></div><div><p class="text-sm font-medium">MSD Tanzania</p><p class="text-xs text-gray-400">Tanzania supply chain</p></div></div><button type="button" role="switch" data-switch="msd" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="MSD"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                            <!-- Sanlam Insurance -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">Sanlam Insurance</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">Pan-African insurance group</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-purple-50 p-2"><svg class="h-6 w-6 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/></svg></div><div><p class="text-sm font-medium">Sanlam</p><p class="text-xs text-gray-400">UG / KE / TZ</p></div></div><button type="button" role="switch" data-switch="sanlam" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="Sanlam"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                            <!-- ICEA Lion -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">ICEA Lion</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">Insurance Company of East Africa</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-amber-50 p-2"><svg class="h-6 w-6 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/></svg></div><div><p class="text-sm font-medium">ICEA Lion</p><p class="text-xs text-gray-400">UG / KE / TZ</p></div></div><button type="button" role="switch" data-switch="icea" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="ICEA"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                            <!-- Telehealth (Babylon Health EA / Rocket Health) -->
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">Rocket Health Uganda</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">Telehealth platform — virtual appointments</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-teal-50 p-2"><svg class="h-6 w-6 text-teal-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14v-4z"/><rect x="3" y="6" width="12" height="12" rx="2" ry="2"/></svg></div><div><p class="text-sm font-medium">Rocket Health</p><p class="text-xs text-gray-400">DPPA-compliant video calls</p></div></div><button type="button" role="switch" data-switch="telehealth" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="Telehealth"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                        </div>
                    </div>

                    <!-- Available Tab Panel -->
                    <div id="tab-available" role="tabpanel" data-state="inactive" class="hidden mt-4 space-y-6 pt-2">
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">Telehealth Platform</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">Conduct virtual appointments with patients</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-red-50 p-2"><svg class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14v-4z"/><rect x="3" y="6" width="12" height="12" rx="2" ry="2"/></svg></div><div><p class="text-sm font-medium">MediConnect</p><p class="text-xs text-gray-400">Data Protection (DPPA) compliant video calls</p></div></div><button type="button" role="switch" data-switch="telehealth" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="Telehealth"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">Insurance Verification</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">Verify patient insurance eligibility</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-red-50 p-2"><svg class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="M13 5v2"/><path d="M13 17v2"/><path d="M13 11v2"/></svg></div><div><p class="text-sm font-medium">InsureCheck</p><p class="text-xs text-gray-400">Real-time eligibility verification</p></div></div><button type="button" role="switch" data-switch="insurance" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="Insurance"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                            <div class="rounded-lg border bg-background shadow-sm"><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">Lab Results</h2><div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-amber-100 text-amber-700">Available</div></div><div class="text-sm text-gray-500 mt-1">Integrate with laboratory systems</div></div><div class="p-3 md:p-4 xxl:p-6 pb-3"><div class="flex items-center justify-between"><div class="flex items-center space-x-3"><div class="h-10 w-10 rounded-full bg-red-50 p-2"><svg class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M4.18 4.18A2 2 0 0 0 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 1.82-1.18"/><path d="M21 15.5V6a2 2 0 0 0-2-2H9.5"/><path d="M16 2v4"/><path d="M12 2v4"/><path d="M8 2v4"/><path d="M20 10H4"/><path d="m14.5 16-2.5-2.5-7 7"/></svg></div><div><p class="text-sm font-medium">LabConnect</p><p class="text-xs text-gray-400">Automated lab results import</p></div></div><button type="button" role="switch" data-switch="lab" aria-checked="false" data-state="unchecked" class="switch-root"><span class="switch-thumb"></span></button></div></div><div class="p-4 pt-0"><button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 w-full" data-integration="Lab"><svg class="inline mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>Connect</button></div></div>
                        </div>
                    </div>

                    <!-- Settings Tab Panel -->
                    <div id="tab-settings" role="tabpanel" data-state="inactive" class="hidden mt-4 space-y-6 pt-2">
                        <div class="rounded-lg border bg-background shadow-sm">
                            <div class="p-4 border-b"><h2 class="text-xl font-semibold">API Settings</h2><div class="text-sm text-gray-500 mt-1">Manage your API keys and webhook endpoints</div></div>
                            <div class="p-6 space-y-6">
                                <div class="space-y-4"><h3 class="text-lg font-medium">API Keys</h3>
                                    <div class="grid gap-4"><div><label class="text-sm font-medium">Production API Key</label><div class="flex items-center space-x-2 mt-1"><input type="password" id="prodApiKey" readonly value="sk_live_51NxXxXxXxXxXxXxXxXxXxXxXx" class="flex h-10 w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-sm"><button class="copy-btn inline-flex items-center justify-center rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm" data-target="prodApiKey">Copy</button><button class="regenerate-btn inline-flex items-center justify-center rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm" data-key="prod">Regenerate</button></div></div>
                                        <div><label class="text-sm font-medium">Test API Key</label><div class="flex items-center space-x-2 mt-1"><input type="password" id="testApiKey" readonly value="sk_test_51NxXxXxXxXxXxXxXxXxXxXxXx" class="flex h-10 w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-sm"><button class="copy-btn inline-flex items-center justify-center rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm" data-target="testApiKey">Copy</button><button class="regenerate-btn inline-flex items-center justify-center rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm" data-key="test">Regenerate</button></div></div>
                                    </div>
                                </div>
                                <div class="border-t"></div>
                                <div class="space-y-4"><h3 class="text-lg font-medium">Webhook Endpoints</h3>
                                    <div class="grid gap-4"><div><label class="text-sm font-medium">Webhook URL</label><div class="flex items-center space-x-2 mt-1"><input type="url" id="webhookUrl" placeholder="https://your-domain.com/api/webhook" value="https://meditrack.com/api/webhook" class="flex h-10 w-full rounded-md border border-gray-200 bg-background px-3 py-2 text-sm"><button id="verifyWebhookBtn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm">Verify</button></div><p class="text-xs text-gray-400 mt-1">The URL where webhook events will be sent</p></div>
                                        <div><label class="text-sm font-medium">Webhook Secret</label><div class="flex items-center space-x-2 mt-1"><input type="password" id="webhookSecret" readonly value="whsec_xXxXxXxXxXxXxXxXxXxXxXxX" class="flex h-10 w-full rounded-md border border-gray-200 bg-gray-50 px-3 py-2 text-sm"><button class="copy-btn inline-flex items-center justify-center rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm" data-target="webhookSecret">Copy</button><button class="regenerate-secret-btn inline-flex items-center justify-center rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm">Regenerate</button></div><p class="text-xs text-gray-400 mt-1">Used to verify webhook signatures</p></div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 border-t flex justify-between gap-2 flex-wrap"><button id="resetSettingsBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2">Reset to Default</button><button id="saveApiSettingsBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2">Save Changes</button></div>
                        </div>
                        <div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h2 class="text-xl font-semibold">Integration Documentation</h2><div class="text-sm text-gray-500 mt-1">Access documentation for available integrations</div></div><div class="p-6"><div class="grid gap-4 md:grid-cols-2"><div class="flex items-center justify-between rounded-lg border p-4"><div><h3 class="font-medium">API Documentation</h3><p class="text-gray-500">Complete API reference and guides</p></div><a href="#" class="doc-link inline-flex items-center justify-center rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm" data-doc="api"><svg class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>View</a></div><div class="flex items-center justify-between rounded-lg border p-4"><div><h3 class="font-medium">Webhook Events</h3><p class="text-gray-500">List of available webhook events</p></div><a href="#" class="doc-link inline-flex items-center justify-center rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm" data-doc="webhook"><svg class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>View</a></div><div class="flex items-center justify-between rounded-lg border p-4"><div><h3 class="font-medium">SDK Documentation</h3><p class="text-gray-500">Client libraries and SDKs</p></div><a href="#" class="doc-link inline-flex items-center justify-center rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm" data-doc="sdk"><svg class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>View</a></div><div class="flex items-center justify-between rounded-lg border p-4"><div><h3 class="font-medium">Integration Tutorials</h3><p class="text-gray-500">Step-by-step integration guides</p></div><a href="#" class="doc-link inline-flex items-center justify-center rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-3 text-sm" data-doc="tutorials"><svg class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M15 3h6v6"/><path d="M10 14 21 3"/><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/></svg>View</a></div></div></div></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- ==================== MODALS ==================== -->

<!-- Connect Integration Modal -->
<div id="connectModal" class="modal-overlay" style="display:none;">
    <div class="alert-dialog">
        <button class="alert-dialog-close" onclick="closeModal('connectModal')">✕</button>
        <div class="alert-dialog-header">
            <h2 class="alert-dialog-title">Connect <span id="connectIntegrationName">Integration</span></h2>
            <p class="alert-dialog-description">Enter your API credentials to connect this integration.</p>
        </div>
        <div class="alert-dialog-form-group">
            <label>API Key</label>
            <input type="text" id="connectApiKey" class="alert-dialog-input" placeholder="Enter API key">
        </div>
        <div class="alert-dialog-form-group">
            <label>API Secret (optional)</label>
            <input type="password" id="connectApiSecret" class="alert-dialog-input" placeholder="Enter API secret">
        </div>
        <div class="alert-dialog-form-group">
            <label>Webhook URL (optional)</label>
            <input type="url" id="connectWebhookUrl" class="alert-dialog-input" placeholder="https://your-domain.com/webhook">
        </div>
        <div class="alert-dialog-footer">
            <button class="alert-dialog-cancel" onclick="closeModal('connectModal')">Cancel</button>
            <button class="alert-dialog-confirm bg-primary hover:bg-primary" id="confirmConnectBtn">Connect</button>
        </div>
    </div>
</div>

<!-- Configure Integration Modal -->
<div id="configureModal" class="modal-overlay" style="display:none;">
    <div class="alert-dialog">
        <button class="alert-dialog-close" onclick="closeModal('configureModal')">✕</button>
        <div class="alert-dialog-header">
            <h2 class="alert-dialog-title">Configure <span id="configureIntegrationName">Integration</span></h2>
            <p class="alert-dialog-description">Adjust settings for this integration.</p>
        </div>
        <div class="alert-dialog-form-group">
            <label>Sync Frequency</label>
            <select id="configSyncFrequency" class="alert-dialog-select">
                <option>Every 15 minutes</option>
                <option>Every hour</option>
                <option>Every 6 hours</option>
                <option>Daily</option>
                <option>Manual only</option>
            </select>
        </div>
        <div class="alert-dialog-form-group">
            <label>Notification Email</label>
            <input type="email" id="configNotifyEmail" class="alert-dialog-input" placeholder="admin@hospital.ug" value="admin@hospital.ug">
        </div>
        <div class="alert-dialog-form-group">
            <label>Data Sync Direction</label>
            <select id="configSyncDir" class="alert-dialog-select">
                <option>Bidirectional</option>
                <option>Import only</option>
                <option>Export only</option>
            </select>
        </div>
        <div class="alert-dialog-footer">
            <button class="alert-dialog-cancel" onclick="closeModal('configureModal')">Cancel</button>
            <button class="alert-dialog-confirm bg-primary hover:bg-primary" id="confirmConfigBtn">Save Configuration</button>
        </div>
    </div>
</div>

<!-- Disconnect Confirmation Modal -->
<div id="disconnectModal" class="modal-overlay" style="display:none;">
    <div class="alert-dialog">
        <button class="alert-dialog-close" onclick="closeModal('disconnectModal')">✕</button>
        <div class="alert-dialog-header">
            <h2 class="alert-dialog-title">Disconnect <span id="disconnectIntegrationName">Integration</span>?</h2>
            <p class="alert-dialog-description">This will stop all data sync with this integration. Historical data will be preserved but no new data will be exchanged. This action can be reversed by reconnecting.</p>
        </div>
        <div class="alert-dialog-footer">
            <button class="alert-dialog-cancel" onclick="closeModal('disconnectModal')">Cancel</button>
            <button class="alert-dialog-delete" id="confirmDisconnectBtn">Disconnect</button>
        </div>
    </div>
</div>

<!-- API Key Permissions Modal -->
<div id="apiPermissionsModal" class="modal-overlay" style="display:none;">
    <div class="alert-dialog" style="max-width:550px;">
        <button class="alert-dialog-close" onclick="closeModal('apiPermissionsModal')">✕</button>
        <div class="alert-dialog-header">
            <h2 class="alert-dialog-title">API Key Permissions</h2>
            <p class="alert-dialog-description">Manage scopes for <strong id="apiKeyName">Production API Key</strong></p>
        </div>
        <div class="scope-checkbox"><input type="checkbox" id="scopeRead" checked><label for="scopeRead">Read - Access patient records, appointments</label></div>
        <div class="scope-checkbox"><input type="checkbox" id="scopeWrite" checked><label for="scopeWrite">Write - Create/update records</label></div>
        <div class="scope-checkbox"><input type="checkbox" id="scopeDelete"><label for="scopeDelete">Delete - Remove records</label></div>
        <div class="scope-checkbox"><input type="checkbox" id="scopeBilling"><label for="scopeBilling">Billing - Access payment data</label></div>
        <div class="scope-checkbox"><input type="checkbox" id="scopeAdmin"><label for="scopeAdmin">Admin - Full system access</label></div>
        <div class="alert-dialog-footer">
            <button class="alert-dialog-cancel" onclick="closeModal('apiPermissionsModal')">Cancel</button>
            <button class="alert-dialog-confirm bg-primary hover:bg-primary" id="confirmPermissionsBtn">Save Permissions</button>
        </div>
    </div>
</div>

<!-- Connection Status Modal -->
<div id="connectionStatusModal" class="modal-overlay" style="display:none;">
    <div class="alert-dialog" style="max-width:550px;">
        <button class="alert-dialog-close" onclick="closeModal('connectionStatusModal')">✕</button>
        <div class="alert-dialog-header">
            <h2 class="alert-dialog-title">Integration Connection Status</h2>
            <p class="alert-dialog-description">Real-time health check of all connected services</p>
        </div>
        <div style="font-size:0.875rem;">
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #e5e7eb;">
                <div><span style="font-weight:600;">EHR (MediSync)</span><br><span style="font-size:0.75rem;color:#6b7280;">Last synced: 2 hours ago</span></div>
                <span style="display:flex;align-items:center;gap:6px;color:#16a34a;font-weight:500;"><span style="width:8px;height:8px;border-radius:50%;background:#16a34a;display:inline-block;"></span>Online</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #e5e7eb;">
                <div><span style="font-weight:600;">Payment Gateway (MediPay)</span><br><span style="font-size:0.75rem;color:#6b7280;">Account: ****4589</span></div>
                <span style="display:flex;align-items:center;gap:6px;color:#16a34a;font-weight:500;"><span style="width:8px;height:8px;border-radius:50%;background:#16a34a;display:inline-block;"></span>Online</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #e5e7eb;">
                <div><span style="font-weight:600;">SMS Notifications (TextAlert)</span><br><span style="font-size:0.75rem;color:#6b7280;">Credits: 2,450 remaining</span></div>
                <span style="display:flex;align-items:center;gap:6px;color:#ca8a04;font-weight:500;"><span style="width:8px;height:8px;border-radius:50%;background:#ca8a04;display:inline-block;"></span>Degraded</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid #e5e7eb;">
                <div><span style="font-weight:600;">Telehealth (MediConnect)</span><br><span style="font-size:0.75rem;color:#6b7280;">Not connected</span></div>
                <span style="display:flex;align-items:center;gap:6px;color:#9ca3af;font-weight:500;"><span style="width:8px;height:8px;border-radius:50%;background:#9ca3af;display:inline-block;"></span>Offline</span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;">
                <div><span style="font-weight:600;">Webhook Endpoint</span><br><span style="font-size:0.75rem;color:#6b7280;">meditrack.com/api/webhook</span></div>
                <span style="display:flex;align-items:center;gap:6px;color:#16a34a;font-weight:500;"><span style="width:8px;height:8px;border-radius:50%;background:#16a34a;display:inline-block;"></span>Online</span>
            </div>
        </div>
        <div style="font-size:0.75rem;color:#9ca3af;text-align:center;margin-top:8px;">Last checked: Just now</div>
        <div class="alert-dialog-footer">
            <button class="alert-dialog-cancel" onclick="closeModal('connectionStatusModal')">Close</button>
            <button class="alert-dialog-confirm bg-primary hover:bg-primary" onclick="closeModal('connectionStatusModal');showToast('All connections refreshed!')">Refresh All</button>
        </div>
    </div>
</div>

<!-- Usage Analytics Modal -->
<div id="usageModal" class="modal-overlay" style="display:none;">
    <div class="alert-dialog" style="max-width:650px;">
        <button class="alert-dialog-close" onclick="closeModal('usageModal')">✕</button>
        <div class="alert-dialog-header">
            <h2 class="alert-dialog-title">Integration Usage Analytics</h2>
            <p class="alert-dialog-description">Usage statistics for the last 30 days</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:1rem;">
            <div class="usage-stat" style="background:#f0fdf4;border-radius:8px;">
                <div class="usage-stat-value" style="color:#16a34a;">12,847</div>
                <div class="usage-stat-label">API Calls</div>
            </div>
            <div class="usage-stat" style="background:#eff6ff;border-radius:8px;">
                <div class="usage-stat-value" style="color:#2563eb;">2,450</div>
                <div class="usage-stat-label">SMS Credits</div>
            </div>
            <div class="usage-stat" style="background:#fefce8;border-radius:8px;">
                <div class="usage-stat-value" style="color:#ca8a04;">847</div>
                <div class="usage-stat-label">Sync Events</div>
            </div>
        </div>
        <div style="font-size:0.875rem;color:#6b7280;">
            <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #e5e7eb;">
                <span>EHR Sync</span><span style="font-weight:500;">5,230 calls · 99.8% success</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #e5e7eb;">
                <span>Payment Gateway</span><span style="font-weight:500;">3,120 calls · 99.5% success</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #e5e7eb;">
                <span>SMS Notifications</span><span style="font-weight:500;">4,497 calls · 97.2% success</span>
            </div>
            <div style="display:flex;justify-content:space-between;padding:8px 0;">
                <span>Webhook Deliveries</span><span style="font-weight:500;">847 events · 100% delivered</span>
            </div>
        </div>
        <div class="alert-dialog-footer">
            <button class="alert-dialog-cancel" onclick="closeModal('usageModal')">Close</button>
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

// ==================== TAB SWITCHING ====================
const tabs = document.querySelectorAll('.tab-trigger');
const panels = {
    active: document.getElementById('tab-active'),
    available: document.getElementById('tab-available'),
    settings: document.getElementById('tab-settings')
};

function switchTab(tabId) {
    Object.keys(panels).forEach(key => {
        if (panels[key]) {
            panels[key].setAttribute('data-state', 'inactive');
            panels[key].classList.add('hidden');
        }
    });
    if (panels[tabId]) {
        panels[tabId].setAttribute('data-state', 'active');
        panels[tabId].classList.remove('hidden');
    }
    tabs.forEach(tab => {
        if (tab.getAttribute('data-tab') === tabId) {
            tab.classList.add('active', 'bg-white', 'text-gray-900', 'shadow-sm');
            tab.classList.remove('text-gray-500');
        } else {
            tab.classList.remove('active', 'bg-white', 'text-gray-900', 'shadow-sm');
            tab.classList.add('text-gray-500');
        }
    });
}

tabs.forEach(tab => {
    tab.addEventListener('click', () => switchTab(tab.getAttribute('data-tab')));
});
switchTab('active');

// ==================== TOAST ====================
function showToast(message) {
    const existingToast = document.querySelector('.toast');
    if (existingToast) existingToast.remove();
    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

// ==================== MODAL HELPERS ====================
function openModal(id) {
    document.getElementById(id).style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeModal(id) {
    document.getElementById(id).style.display = 'none';
    document.body.style.overflow = '';
}
// Close modals on overlay click
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal-overlay')) {
        e.target.style.display = 'none';
        document.body.style.overflow = '';
    }
});
// Close modals on Escape
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay').forEach(m => {
            m.style.display = 'none';
        });
        document.body.style.overflow = '';
    }
});

// ==================== SWITCH TOGGLES (with disconnect flow) ====================
document.querySelectorAll('.switch-root').forEach(switchEl => {
    switchEl.addEventListener('click', () => {
        const isChecked = switchEl.getAttribute('aria-checked') === 'true';
        const integration = switchEl.getAttribute('data-switch') || 'integration';
        
        if (isChecked) {
            // Turning OFF - show disconnect modal
            const displayNames = { ehr: 'EHR', payment: 'Payment Gateway', sms: 'SMS Notifications', telehealth: 'Telehealth', insurance: 'Insurance Verification', lab: 'Lab Results' };
            document.getElementById('disconnectIntegrationName').textContent = displayNames[integration] || integration;
            openModal('disconnectModal');
            // Store reference to switch for later
            document.getElementById('confirmDisconnectBtn').onclick = function() {
                switchEl.setAttribute('aria-checked', 'false');
                switchEl.setAttribute('data-state', 'unchecked');
                showToast(integration + ' disconnected');
                closeModal('disconnectModal');
            };
        } else {
            // Turning ON - show connect modal
            const displayNames = { ehr: 'EHR', payment: 'Payment Gateway', sms: 'SMS Notifications', telehealth: 'Telehealth', insurance: 'Insurance Verification', lab: 'Lab Results' };
            document.getElementById('connectIntegrationName').textContent = displayNames[integration] || integration;
            openModal('connectModal');
            document.getElementById('confirmConnectBtn').onclick = function() {
                switchEl.setAttribute('aria-checked', 'true');
                switchEl.setAttribute('data-state', 'checked');
                showToast(integration + ' connected successfully');
                closeModal('connectModal');
            };
        }
    });
});

// ==================== CONFIGURE BUTTONS (Active tab) ====================
document.querySelectorAll('.configure-btn').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        const integration = btn.getAttribute('data-integration') || 'Integration';
        document.getElementById('configureIntegrationName').textContent = integration;
        openModal('configureModal');
    });
});
document.getElementById('confirmConfigBtn')?.addEventListener('click', () => {
    showToast('Configuration saved successfully');
    closeModal('configureModal');
});

// ==================== CONNECT BUTTONS (Available tab) ====================
document.querySelectorAll('#tab-available button[data-integration]').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        const integration = btn.getAttribute('data-integration') || 'Integration';
        document.getElementById('connectIntegrationName').textContent = integration;
        openModal('connectModal');
        document.getElementById('confirmConnectBtn').onclick = function() {
            showToast(integration + ' connected successfully');
            closeModal('connectModal');
        };
    });
});

// ==================== COPY BUTTONS ====================
document.querySelectorAll('.copy-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const targetId = btn.getAttribute('data-target');
        const input = document.getElementById(targetId);
        if (input) { input.select(); document.execCommand('copy'); showToast('Copied to clipboard!'); }
    });
});

// ==================== REGENERATE API KEYS (with permissions modal) ====================
document.querySelectorAll('.regenerate-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const keyType = btn.getAttribute('data-key');
        document.getElementById('apiKeyName').textContent = keyType === 'prod' ? 'Production API Key' : 'Test API Key';
        openModal('apiPermissionsModal');
        document.getElementById('confirmPermissionsBtn').onclick = function() {
            const newKey = 'sk_' + (keyType === 'prod' ? 'live_' : 'test_') + Math.random().toString(36).substring(2, 15);
            if (keyType === 'prod') document.getElementById('prodApiKey').value = newKey;
            else document.getElementById('testApiKey').value = newKey;
            showToast('API key regenerated with new permissions');
            closeModal('apiPermissionsModal');
        };
    });
});

// ==================== REGENERATE WEBHOOK SECRET ====================
document.querySelector('.regenerate-secret-btn')?.addEventListener('click', () => {
    const newSecret = 'whsec_' + Math.random().toString(36).substring(2, 20);
    document.getElementById('webhookSecret').value = newSecret;
    showToast('Webhook secret regenerated');
});

// ==================== VERIFY WEBHOOK (Test Event) ====================
document.getElementById('verifyWebhookBtn')?.addEventListener('click', () => {
    const url = document.getElementById('webhookUrl').value;
    if (url) {
        showToast('Test event sent to ' + url + ' - Response: 200 OK');
    } else {
        showToast('Please enter a valid webhook URL');
    }
});

// ==================== REFRESH STATUS ====================
document.getElementById('refreshBtn')?.addEventListener('click', () => {
    openModal('connectionStatusModal');
});

// ==================== USAGE ANALYTICS ====================
document.getElementById('usageBtn')?.addEventListener('click', () => {
    openModal('usageModal');
});

// ==================== SAVE/RESET BUTTONS ====================
document.getElementById('resetSettingsBtn')?.addEventListener('click', () => {
    document.getElementById('prodApiKey').value = 'sk_live_51NxXxXxXxXxXxXxXxXxXxXxXx';
    document.getElementById('testApiKey').value = 'sk_test_51NxXxXxXxXxXxXxXxXxXxXxXx';
    document.getElementById('webhookUrl').value = 'https://meditrack.com/api/webhook';
    document.getElementById('webhookSecret').value = 'whsec_xXxXxXxXxXxXxXxXxXxXxXxX';
    showToast('Settings reset to default');
});
document.getElementById('saveApiSettingsBtn')?.addEventListener('click', () => showToast('API settings saved successfully'));


// ==================== DOCUMENTATION LINKS ====================
document.querySelectorAll('.doc-link').forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        showToast('Opening documentation: ' + link.getAttribute('data-doc'));
    });
});

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
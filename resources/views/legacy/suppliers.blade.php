<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Suppliers Directory</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #0a0a0a; }
        body.dark .bg-white, body.dark .bg-card, body.dark .rounded-lg.border { background-color: #1a1a1a !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted { background-color: #262626 !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        /* Modern Action Menu */
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
        body.dark .action-menu { background: #2a2a2a; border-color: #404040; }
        .action-menu-header { padding: 0.5rem 0.75rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb; margin-bottom: 0.25rem; }
        body.dark .action-menu-header { color: #9ca3af; border-bottom-color: #404040; }
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
            color: inherit;
            text-align: left;
        }
        .action-item:hover { background-color: #f3f4f6; }
        body.dark .action-item:hover { background-color: #3f3f46; }
        .action-divider { height: 1px; background-color: #e5e7eb; margin: 0.25rem 0; }
        body.dark .action-divider { background-color: #404040; }
        
        @keyframes fadeInScale { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        
        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgb(0 0 0 / 87%);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            animation: fadeIn 0.2s ease-out;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        
        .toast-message { position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white; padding: 12px 20px; border-radius: 8px; z-index: 11000; animation: slideIn 0.3s ease-out; font-size: 0.875rem; }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        
        .tab-panel.hidden { display: none; }
        [role="tab"][data-state="active"] { background: white; color: #1f2937; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        body.dark [role="tab"][data-state="active"] { background: #1a1a1a; color: #e5e5e5; }
    
    /* Modal Overlay (standardized) */
.modal-overlay {
    position: fixed;
    inset: 0;
    background-color: rgb(0 0 0 / 87%);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    animation: fadeIn 0.2s ease-out;
}
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

.modal-container {
    background: white;
    border-radius: 0.75rem;
    width: 100%;
    max-width: 500px;
    animation: slideUp 0.2s ease;
    position: relative;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
}
body.dark .modal-container { background: #1e1e1e; border: 1px solid #333; }
@keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

.modal-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; }
body.dark .modal-header { border-bottom-color: #333; }
.modal-title { font-size: 1.125rem; font-weight: 600; }
.modal-close { background: transparent; border: none; font-size: 1.5rem; cursor: pointer; color: #6b7280; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 0.375rem; }
.modal-close:hover { color: #1f2937; background-color: #f3f4f6; }
body.dark .modal-close:hover { color: #e5e5e5; background-color: #374151; }
.modal-body { padding: 1.5rem; }
.modal-body-scrollable { max-height: calc(80vh - 120px); overflow-y: auto; padding-right: 8px; }
.modal-footer { padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 0.75rem; }
body.dark .modal-footer { border-top-color: #333; }
.btn-cancel { background: transparent; border: 1px solid #d1d5db; padding: 0.5rem 1rem; border-radius: 0.375rem; cursor: pointer; font-size: 0.875rem; }
.btn-cancel:hover { background: #f3f4f6; }
body.dark .btn-cancel { border-color: #555; color: #e5e5e5; }
body.dark .btn-cancel:hover { background: #374151; }
.btn-submit { color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.375rem; cursor: pointer; font-size: 0.875rem; }

/* Radix Select */
.radix-select { position: relative; width: 100%; }
.radix-select-trigger {
    display: flex; align-items: center; justify-content: space-between;
    width: 100%; padding: 0.5rem 0.75rem; font-size: 0.875rem;
    border-radius: 0.375rem; border: 1px solid #e5e7eb;
    background-color: white; cursor: pointer; min-height: 38px;
}
body.dark .radix-select-trigger { background-color: #262626; border-color: #404040; color: #e5e5e5; }
.radix-select-content {
    position: absolute; top: 100%; left: 0; right: 0; margin-top: 4px;
    background: white; border: 1px solid #e5e7eb; border-radius: 0.375rem;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); z-index: 10001;
    overflow: hidden; animation: selectSlideDown 0.15s ease-out;
}
body.dark .radix-select-content { background: #2a2a2a; border-color: #404040; }
.radix-select-item {
    padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer;
    display: flex; align-items: center; justify-content: space-between;
    transition: background-color 0.1s;
}
.radix-select-item:hover { background-color: #f3f4f6; }
body.dark .radix-select-item:hover { background-color: #3f3f46; }
.radix-select-item[data-selected="true"] { background-color: #eef2ff; color: #4f46e5; font-weight: 500; }
body.dark .radix-select-item[data-selected="true"] { background-color: #1e1b4b; color: #818cf8; }
.radix-select-item-indicator { display: none; }
.radix-select-item[data-selected="true"] .radix-select-item-indicator { display: block; }
@keyframes selectSlideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

.bg-primary { background-color: #4f46e5; }
.bg-primary:hover { background-color: #4338ca; }

/* Form Elements for Modals */
.form-group {
    margin-bottom: 1rem;
}
.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 0.375rem;
    color: #374151;
}
body.dark .form-label {
    color: #d1d5db;
}
.form-input {
    width: 100%;
    height: 40px;
    border-radius: 0.375rem;
    border: 1px solid #d1d5db;
    background: white;
    padding: 0 0.75rem;
    font-size: 0.875rem;
    color: #1f2937;
    transition: border-color 0.15s, box-shadow 0.15s;
    outline: none;
}
.form-input:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.15);
}
.form-input:disabled {
    background: #f9fafb;
    color: #6b7280;
    cursor: not-allowed;
}
.form-textarea {
    width: 100%;
    border-radius: 0.375rem;
    border: 1px solid #d1d5db;
    background: white;
    padding: 0.625rem 0.75rem;
    font-size: 0.875rem;
    color: #1f2937;
    resize: vertical;
    min-height: 100px;
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
    font-family: 'Inter', system-ui, sans-serif;
}
.form-textarea:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.15);
}
body.dark .form-input {
    background: #262626;
    border-color: #404040;
    color: #e5e5e5;
}
body.dark .form-input:disabled {
    background: #1f1f1f;
    color: #9ca3af;
}
body.dark .form-textarea {
    background: #262626;
    border-color: #404040;
    color: #e5e5e5;
}
body.dark .form-input:focus,
body.dark .form-textarea:focus {
    border-color: #818cf8;
    box-shadow: 0 0 0 2px rgba(129, 140, 248, 0.15);
}

/* Improved modal body scroll */
.modal-body-scrollable {
    max-height: calc(80vh - 130px);
    overflow-y: auto;
    padding-right: 4px;
}
.modal-body-scrollable::-webkit-scrollbar {
    width: 5px;
}
.modal-body-scrollable::-webkit-scrollbar-track {
    background: transparent;
}
.modal-body-scrollable::-webkit-scrollbar-thumb {
    background: #d1d5db;
    border-radius: 10px;
}
body.dark .modal-body-scrollable::-webkit-scrollbar-thumb {
    background: #555;
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
            <div class="flex flex-col gap-5">
                <!-- Header -->
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div><h2 class="text-2xl lg:text-3xl font-bold tracking-tight">Suppliers</h2><p class="text-gray-500">Manage your inventory suppliers and vendors</p></div>
                    <div class="flex items-center gap-2">
                        <a href="add-supplier.html"><button class="bg-primary text-white hover:bg-primary/90 h-10 px-4 rounded-md text-sm flex items-center gap-2"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 12h14M12 5v14"></path></svg>Add Supplier</button></a>
                        <button id="exportBtn" class="border border-gray-300 bg-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 h-10 px-4 rounded-md text-sm flex items-center gap-2"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg>Export</button>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid gap-4 md:grid-cols-4">
                    <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex items-center justify-between"><h2 class="text-sm font-medium dark:text-gray-300">Total Suppliers</h2><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-gray-400"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path><path d="M8 6h.01"></path><path d="M16 6h.01"></path><path d="M12 6h.01"></path></svg></div><div class="text-2xl font-bold mt-2">38</div><p class="text-xs text-gray-500">+3 new this quarter</p></div>
                    <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex items-center justify-between"><h2 class="text-sm font-medium dark:text-gray-300">Active Orders</h2><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-gray-400"><path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"></path><path d="M12 22V12"></path><path d="m3.3 7 7.703 4.734a2 2 0 0 0 1.994 0L20.7 7"></path></svg></div><div class="text-2xl font-bold mt-2">12</div><p class="text-xs text-gray-500">4 arriving this week</p></div>
                    <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex items-center justify-between"><h2 class="text-sm font-medium dark:text-gray-300">Top Supplier</h2><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-yellow-500"><path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"></path></svg></div><div class="text-2xl font-bold mt-2">MedPlus</div><p class="text-xs text-gray-500">98% reliability rating</p></div>
                    <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex items-center justify-between"><h2 class="text-sm font-medium dark:text-gray-300">Monthly Spend</h2><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-gray-400"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"></path><path d="M15 18H9"></path><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"></path><circle cx="17" cy="18" r="2"></circle><circle cx="7" cy="18" r="2"></circle></svg></div><div class="text-2xl font-bold mt-2">$24,350</div><p class="text-xs text-gray-500">-8% from last month</p></div>
                </div>

                <!-- Search -->
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="relative w-full md:w-80"><svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg><input id="searchInput" class="h-10 rounded-md border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 pl-8 w-full text-sm dark:text-white" placeholder="Search suppliers..."></div>
                </div>

                <!-- Tabs -->
                <div class="w-full">
                    <div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 dark:bg-gray-800 p-1">
                        <button type="button" data-tab="all" class="main-tab inline-flex rounded-sm px-3 py-1.5 text-sm font-medium" data-state="active">All Suppliers</button>
                        <button type="button" data-tab="preferred" class="main-tab inline-flex rounded-sm px-3 py-1.5 text-sm font-medium" data-state="inactive">Preferred</button>
                        <button type="button" data-tab="medications" class="main-tab inline-flex rounded-sm px-3 py-1.5 text-sm font-medium" data-state="inactive">Medications</button>
                        <button type="button" data-tab="medical-supplies" class="main-tab inline-flex rounded-sm px-3 py-1.5 text-sm font-medium" data-state="inactive">Medical Supplies</button>
                    </div>

                    <div id="tab-all" class="tab-panel mt-4"><div class="rounded-lg border bg-white dark:bg-[#1a1a1a] dark:border-gray-800 overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 dark:bg-gray-900 border-b dark:border-gray-800"><tr><th class="px-4 py-3 text-left">ID</th><th class="px-4 py-3 text-left">Name</th><th class="px-4 py-3 text-left">Category</th><th class="px-4 py-3 text-left">Contact</th><th class="px-4 py-3 text-left">Rating</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-right">Actions</th></tr></thead><tbody id="allSuppliersBody"></tbody></table></div></div>
                    <div id="tab-preferred" class="tab-panel hidden mt-4"><div class="rounded-lg border bg-white dark:bg-[#1a1a1a] dark:border-gray-800 overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 dark:bg-gray-900 border-b dark:border-gray-800"><tr><th class="px-4 py-3 text-left">ID</th><th class="px-4 py-3 text-left">Name</th><th class="px-4 py-3 text-left">Category</th><th class="px-4 py-3 text-left">Contact</th><th class="px-4 py-3 text-left">Rating</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-right">Actions</th></tr></thead><tbody id="preferredSuppliersBody"></tbody></table></div></div>
                    <div id="tab-medications" class="tab-panel hidden mt-4"><div class="rounded-lg border bg-white dark:bg-[#1a1a1a] dark:border-gray-800 overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 dark:bg-gray-900 border-b dark:border-gray-800"><tr><th class="px-4 py-3 text-left">ID</th><th class="px-4 py-3 text-left">Name</th><th class="px-4 py-3 text-left">Category</th><th class="px-4 py-3 text-left">Contact</th><th class="px-4 py-3 text-left">Rating</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-right">Actions</th></tr></thead><tbody id="medicationsSuppliersBody"></tbody></table></div></div>
                    <div id="tab-medical-supplies" class="tab-panel hidden mt-4"><div class="rounded-lg border bg-white dark:bg-[#1a1a1a] dark:border-gray-800 overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 dark:bg-gray-900 border-b dark:border-gray-800"><tr><th class="px-4 py-3 text-left">ID</th><th class="px-4 py-3 text-left">Name</th><th class="px-4 py-3 text-left">Category</th><th class="px-4 py-3 text-left">Contact</th><th class="px-4 py-3 text-left">Rating</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-right">Actions</th></tr></thead><tbody id="medicalSuppliesBody"></tbody></table></div></div>
                </div>

                <!-- Featured Suppliers -->
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="rounded-lg border bg-white dark:bg-[#1a1a1a] dark:border-gray-800 md:col-span-2">
                        <div class="p-4 border-b dark:border-gray-800"><h2 class="text-xl font-semibold dark:text-white">Featured Suppliers</h2><div class="text-sm text-gray-500">Your top-rated and most reliable suppliers</div></div>
                        <div class="p-4 grid gap-4 md:grid-cols-2" id="featuredSuppliersContainer"></div>
                    </div>
                    <div class="rounded-lg border bg-white dark:bg-[#1a1a1a] dark:border-gray-800">
                        <div class="p-4 border-b dark:border-gray-800"><h2 class="text-xl font-semibold dark:text-white">Recent Orders</h2><div class="text-sm text-gray-500">Your most recent supplier orders</div></div>
                        <div class="p-4 space-y-4">
                            <div class="flex items-center justify-between rounded-md border p-3 dark:border-gray-700"><div><p class="text-sm font-medium dark:text-white">AAR Healthcare Supplies</p><p class="text-xs text-gray-500">Order #ORD4872 • Apr 18, 2023</p><span class="inline-flex rounded-full px-2 py-0.5 text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 mt-1">Delivered</span></div><div class="text-right"><p class="text-sm font-medium dark:text-white">$1,245.00</p><p class="text-xs text-gray-500">12 items</p></div></div>
                            <div class="flex items-center justify-between rounded-md border p-3 dark:border-gray-700"><div><p class="text-sm font-medium dark:text-white">Biopharm Uganda</p><p class="text-xs text-gray-500">Order #ORD4865 • Apr 15, 2023</p><span class="inline-flex rounded-full px-2 py-0.5 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 mt-1">Shipped</span></div><div class="text-right"><p class="text-sm font-medium dark:text-white">$876.50</p><p class="text-xs text-gray-500">8 items</p></div></div>
                            <button id="viewAllOrdersBtn" class="w-full border rounded-md px-4 py-2 text-sm dark:border-gray-700">View All Orders</button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modern Place Order Modal -->
<div id="orderModalOverlay" class="modal-overlay" style="display: none;">
    <div class="modal-container" style="max-width: 700px;">
        <div class="modal-header">
            <h2 id="orderModalTitle" class="modal-title">Place Order with Supplier</h2>
            <button class="modal-close" id="closeOrderModalBtn">&times;</button>
        </div>
        <form id="orderFormModal">
            <div class="modal-body modal-body-scrollable">
                <div id="orderSupplierInfo" class="flex items-center gap-2 mb-4">
                    <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9 22v-4h6v4"/></svg>
                    <h3 id="orderSupplierName" class="text-lg font-semibold">Supplier Name</h3>
                </div>
                <div class="border rounded-md p-4 mb-4">
                    <h4 class="font-medium mb-3">Order Items</h4>
                    <div id="orderItemsContainer">
                        <div class="grid grid-cols-12 gap-2 mb-2 order-item-row">
                            <div class="col-span-5"><input class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" placeholder="Item name" required></div>
                            <div class="col-span-2"><input type="number" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" placeholder="Qty" min="1" value="1" required></div>
                            <div class="col-span-2"><input type="text" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm item-price" placeholder="Unit price" required></div>
                            <div class="col-span-2"><input type="text" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm item-total bg-gray-50 dark:bg-gray-700" placeholder="Total" disabled readonly></div>
                            <div class="col-span-1 flex items-center justify-center"><button type="button" class="remove-item-btn text-red-500 hover:text-red-700 text-lg">&times;</button></div>
                        </div>
                    </div>
                    <div class="flex justify-between mt-4">
                        <button type="button" id="addItemBtn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 h-9 px-3 text-sm">+ Add Item</button>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">Total</div>
                            <div id="orderTotalDisplay" class="text-lg font-semibold">$0.00</div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="text-sm font-medium block mb-2">Expected Delivery</label><input type="date" id="deliveryDate" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" value="2026-06-08"></div>
                    <div>
                        <label class="text-sm font-medium block mb-2">Priority</label>
                        <div class="radix-select" id="priorityRadixSelect">
                            <button type="button" class="radix-select-trigger" data-value="Normal">
                                <span>Normal</span>
                                <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                            </button>
                            <div class="radix-select-content hidden">
                                <div class="radix-select-item" data-value="Low">Low<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                <div class="radix-select-item" data-value="Normal" data-selected="true">Normal<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                <div class="radix-select-item" data-value="High">High<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                                <div class="radix-select-item" data-value="Urgent">Urgent<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4"><label class="text-sm font-medium block mb-2">Notes</label><textarea id="orderNotes" rows="3" class="flex min-h-[80px] w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" placeholder="Additional instructions for this order"></textarea></div>
            </div>
            <div class="modal-footer">
                <button type="button" id="cancelOrderBtn" class="btn-cancel">Cancel</button>
                <button type="submit" class="btn-submit bg-primary hover:bg-primary/90">Place Order</button>
            </div>
        </form>
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
    // ==================== TOAST ====================
function showToast(message, isError = false) { 
    const existing = document.querySelector('.toast-message'); 
    if (existing) existing.remove(); 
    const toast = document.createElement('div'); 
    toast.className = `toast-message ${isError ? 'error' : ''}`; 
    toast.textContent = message; 
    document.body.appendChild(toast); 
    setTimeout(() => toast.remove(), 3000); 
}

// ==================== SUPPLIERS DATA ====================
const suppliers = [
    { id: "SUP001", name: "AAR Healthcare Supplies", category: "Medical Supplies", email: "contact@aar.com", phone: "+256 712 345 678", rating: 5, status: "Active", preferred: true },
    { id: "SUP002", name: "Biopharm Uganda", category: "Medications", email: "sales@eclipse.co.ug", phone: "+256 712 987 654", rating: 4, status: "Active", preferred: true },
    { id: "SUP003", name: "Rocimar Pharma", category: "Equipment", email: "info@laborex.co.ug", phone: "+256 712 345 681", rating: 4, status: "Active", preferred: true },
    { id: "SUP004", name: "Eclipse Medical Supplies", category: "Medical Supplies", email: "orders@nms.go.ug", phone: "+256 712 345 679", rating: 3, status: "Active", preferred: false },
    { id: "SUP005", name: "Mediq EA", category: "Office Supplies", email: "medical@mediq.co.ug", phone: "+256 712 345 680", rating: 4, status: "Active", preferred: false },
    { id: "SUP006", name: "National Medical Stores (NMS)", category: "Medications", email: "sales@biopharm.co.ug", phone: "+256 712 345 684", rating: 5, status: "Active", preferred: true },
    { id: "SUP008", name: "KEMSA", category: "Laboratory", email: "orders@laborex.co.ug", phone: "+256 712 345 682", rating: 4, status: "Active", preferred: false }
];

let currentTab = "all";
let searchQuery = "";
let activeActionMenu = null;
let activeContactModal = null;

// ==================== HELPERS ====================
function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

function renderStars(rating) { 
    let stars = ''; 
    for (let i = 1; i <= 5; i++) {
        stars += `<svg class="h-3 w-3 inline ${i <= rating ? 'text-yellow-500 fill-yellow-500' : 'text-gray-300'}" viewBox="0 0 24 24" fill="currentColor"><path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"></path></svg>`; 
    }
    return stars; 
}

function closeActionMenu() { 
    if (activeActionMenu) { 
        activeActionMenu.remove(); 
        activeActionMenu = null; 
    } 
}

function closeContactModal() {
    if (activeContactModal) {
        activeContactModal.remove();
        activeContactModal = null;
    }
    document.body.style.overflow = '';
}

// ==================== MODERN ACTION MENU ====================
function showActionMenu(btn, supplier) {
    closeActionMenu();
    const rect = btn.getBoundingClientRect();
    const menu = document.createElement('div');
    menu.className = 'action-menu';
    let left = rect.left;
    let top = rect.bottom + 6;
    if (left + 220 > window.innerWidth) left = window.innerWidth - 230;
    if (top + 230 > window.innerHeight) top = rect.top - 240;
    menu.style.top = `${top}px`;
    menu.style.left = `${left}px`;
    
    menu.innerHTML = `
        <div class="action-menu-header">Actions</div>
        <button data-action="view" class="action-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
            View Details
        </button>
        <button data-action="contact" class="action-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            Contact Supplier
        </button>
        <div class="action-divider"></div>
        <button data-action="order" class="action-item text-blue-600">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5v14"/></svg>
            Place Order
        </button>
        <button data-action="edit" class="action-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
            Edit Supplier
        </button>
    `;
    document.body.appendChild(menu);
    activeActionMenu = menu;
    
    const closeHandler = (e) => { 
        if (!menu.contains(e.target) && e.target !== btn) { 
            closeActionMenu(); 
            document.removeEventListener('click', closeHandler); 
        } 
    };
    setTimeout(() => document.addEventListener('click', closeHandler), 10);
    
    menu.querySelector('[data-action="view"]')?.addEventListener('click', () => { 
        window.location.href = `supplier-details.html?id=${supplier.id}`; 
        closeActionMenu(); 
    });
    menu.querySelector('[data-action="contact"]')?.addEventListener('click', () => { 
        showContactModal(supplier); 
        closeActionMenu(); 
    });
    menu.querySelector('[data-action="order"]')?.addEventListener('click', () => { 
        openOrderModal(supplier); 
        closeActionMenu(); 
    });
    menu.querySelector('[data-action="edit"]')?.addEventListener('click', () => { 
        window.location.href = `edit-supplier.html?id=${supplier.id}`; 
        closeActionMenu(); 
    });
}

// ==================== MODERN CONTACT MODAL ====================
function showContactModal(supplier) {
    closeContactModal();
    closeActionMenu();
    
    const overlay = document.createElement('div');
    overlay.className = 'modal-overlay';
    overlay.style.zIndex = '10000';
    overlay.innerHTML = `
        <div class="modal-container" style="max-width:520px;display:flex;flex-direction:column;max-height:90vh;">
            <div class="modal-header" style="flex-shrink:0;">
                <div>
                    <h2 class="modal-title">Contact Supplier</h2>
                    <p class="text-sm text-gray-500 mt-0.5">Send a message to ${escapeHtml(supplier.name)}</p>
                </div>
                <button class="modal-close close-contact-btn">&times;</button>
            </div>
            <form id="contactFormModal" style="display:flex;flex-direction:column;overflow:hidden;">
                <div class="modal-body modal-body-scrollable" style="flex:1;">
                    <div class="form-group">
                        <label class="form-label">Supplier</label>
                        <input class="form-input" disabled value="${escapeHtml(supplier.name)}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact Person</label>
                        <input class="form-input" id="contactPersonInput" placeholder="Enter contact person name" value="Not specified">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Contact Method</label>
                        <div class="radix-select" id="contactMethodRadixSelect">
                            <button type="button" class="radix-select-trigger" data-value="email">
                                <span> Email</span>
                                <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                            </button>
                            <div class="radix-select-content hidden">
                                <div class="radix-select-item" data-value="email" data-selected="true">
                                    <span></span> Email
                                    <svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </div>
                                <div class="radix-select-item" data-value="phone">
                                    <span></span> Phone
                                    <svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Contact Info Display -->
                    <div class="form-group" id="emailField">
                        <label class="form-label">Email Address</label>
                        <div class="flex items-center gap-2">
                            <input class="form-input flex-1" disabled value="${escapeHtml(supplier.email)}">
                            <button type="button" class="copy-btn inline-flex items-center justify-center h-10 w-10 rounded-md border border-gray-300 hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700" data-copy="${escapeHtml(supplier.email)}" title="Copy email">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="form-group hidden" id="phoneField">
                        <label class="form-label">Phone Number</label>
                        <div class="flex items-center gap-2">
                            <input class="form-input flex-1" disabled value="${escapeHtml(supplier.phone)}">
                            <button type="button" class="copy-btn inline-flex items-center justify-center h-10 w-10 rounded-md border border-gray-300 hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700" data-copy="${escapeHtml(supplier.phone)}" title="Copy phone">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subject <span style="color:#ef4444;">*</span></label>
                        <input class="form-input" id="contactSubject" value="Inquiry about products" required placeholder="Enter subject">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Message <span style="color:#ef4444;">*</span></label>
                        <textarea class="form-textarea" id="contactMessage" rows="5" required placeholder="Type your message here..."></textarea>
                        <p class="text-xs text-gray-400 mt-1" id="charCount">0 / 500 characters</p>
                    </div>
                </div>
                <div class="modal-footer" style="flex-shrink:0;">
                    <button type="button" class="btn-cancel close-contact-btn">Cancel</button>
                    <button type="submit" class="btn-submit bg-primary hover:bg-primary/90 flex items-center gap-2">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polyline points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    `;
    
    document.body.appendChild(overlay);
    activeContactModal = overlay;
    document.body.style.overflow = 'hidden';
    
    // Initialize Radix select
    initRadixSelect(overlay.querySelector('#contactMethodRadixSelect'));
    
    // Toggle email/phone fields
    const methodTrigger = overlay.querySelector('#contactMethodRadixSelect .radix-select-trigger');
    const emailField = overlay.querySelector('#emailField');
    const phoneField = overlay.querySelector('#phoneField');
    
    const updateContactFields = () => {
        const method = methodTrigger.getAttribute('data-value');
        if (method === 'email') {
            emailField?.classList.remove('hidden');
            phoneField?.classList.add('hidden');
        } else {
            emailField?.classList.add('hidden');
            phoneField?.classList.remove('hidden');
        }
    };
    
    const observer = new MutationObserver(updateContactFields);
    if (methodTrigger) observer.observe(methodTrigger, { attributes: true, attributeFilter: ['data-value'] });
    
    // Copy buttons
    overlay.querySelectorAll('.copy-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const text = btn.dataset.copy;
            navigator.clipboard.writeText(text).then(() => {
                showToast('📋 Copied to clipboard!');
            }).catch(() => {
                showToast('Failed to copy', true);
            });
        });
    });
    
    // Character count
    const messageTextarea = overlay.querySelector('#contactMessage');
    const charCount = overlay.querySelector('#charCount');
    messageTextarea?.addEventListener('input', () => {
        const len = messageTextarea.value.length;
        if (charCount) {
            charCount.textContent = `${len} / 500 characters`;
            charCount.style.color = len > 450 ? '#ef4444' : len > 400 ? '#f59e0b' : '#9ca3af';
        }
    });
    
    // Close handlers
    const closeFn = () => {
        observer.disconnect();
        closeContactModal();
    };
    
    overlay.querySelectorAll('.close-contact-btn').forEach(btn => btn.addEventListener('click', closeFn));
    overlay.addEventListener('click', (e) => { if (e.target === overlay) closeFn(); });
    
    // Form submission
    overlay.querySelector('#contactFormModal')?.addEventListener('submit', (e) => {
        e.preventDefault();
        const method = methodTrigger?.getAttribute('data-value') || 'email';
        const contactInfo = method === 'email' ? supplier.email : supplier.phone;
        const subject = overlay.querySelector('#contactSubject')?.value || '';
        const message = overlay.querySelector('#contactMessage')?.value || '';
        
        if (!subject.trim()) {
            showToast('⚠️ Please enter a subject', true);
            overlay.querySelector('#contactSubject')?.focus();
            return;
        }
        if (!message.trim()) {
            showToast('⚠️ Please enter a message', true);
            messageTextarea?.focus();
            return;
        }
        
        // Show loading state
        const submitBtn = overlay.querySelector('button[type="submit"]');
        const originalHTML = submitBtn.innerHTML;
        submitBtn.innerHTML = `<svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Sending...`;
        submitBtn.disabled = true;
        
        setTimeout(() => {
            showToast(`✅ Message sent to ${supplier.name} via ${method}`);
            closeFn();
        }, 1200);
    });
    
    // Focus subject input
    setTimeout(() => overlay.querySelector('#contactSubject')?.focus(), 150);
}

// ==================== ORDER MODAL (Standardized Pattern) ====================
const orderModalOverlay = document.getElementById('orderModalOverlay');
const orderModalTitle = document.getElementById('orderModalTitle');
const orderSupplierName = document.getElementById('orderSupplierName');
const orderItemsContainer = document.getElementById('orderItemsContainer');
const orderTotalDisplay = document.getElementById('orderTotalDisplay');
let currentSupplier = null;

function calculateOrderTotal() {
    let total = 0;
    document.querySelectorAll('#orderItemsContainer .order-item-row').forEach(row => {
        const qty = parseFloat(row.querySelector('input[type="number"]')?.value) || 0;
        const price = parseFloat(row.querySelector('.item-price')?.value) || 0;
        const itemTotal = qty * price;
        const totalInput = row.querySelector('.item-total');
        if (totalInput) totalInput.value = `$${itemTotal.toFixed(2)}`;
        total += itemTotal;
    });
    if (orderTotalDisplay) orderTotalDisplay.textContent = `$${total.toFixed(2)}`;
}

function addOrderItemRow() {
    const newRow = document.createElement('div');
    newRow.className = 'grid grid-cols-12 gap-2 mb-2 order-item-row';
    newRow.innerHTML = `
        <div class="col-span-5"><input class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" placeholder="Item name" required></div>
        <div class="col-span-2"><input type="number" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" placeholder="Qty" min="1" value="1" required></div>
        <div class="col-span-2"><input type="text" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm item-price" placeholder="Unit price" required></div>
        <div class="col-span-2"><input type="text" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm item-total bg-gray-50 dark:bg-gray-700" placeholder="Total" disabled readonly></div>
        <div class="col-span-1 flex items-center justify-center"><button type="button" class="remove-item-btn text-red-500 hover:text-red-700 text-lg">&times;</button></div>
    `;
    orderItemsContainer.appendChild(newRow);
    attachOrderItemEvents(newRow);
    calculateOrderTotal();
}

function attachOrderItemEvents(row) {
    const qtyInput = row.querySelector('input[type="number"]');
    const priceInput = row.querySelector('.item-price');
    const removeBtn = row.querySelector('.remove-item-btn');
    if (qtyInput) qtyInput.addEventListener('input', calculateOrderTotal);
    if (priceInput) priceInput.addEventListener('input', calculateOrderTotal);
    if (removeBtn) removeBtn.addEventListener('click', () => { 
        if (document.querySelectorAll('#orderItemsContainer .order-item-row').length > 1) {
            row.remove(); 
            calculateOrderTotal(); 
        }
    });
}

function openOrderModal(supplier) {
    currentSupplier = supplier;
    orderModalTitle.textContent = `Place Order with ${supplier.name}`;
    orderSupplierName.textContent = supplier.name;
    
    // Clear existing items except first row
    while (orderItemsContainer.children.length > 1) {
        orderItemsContainer.removeChild(orderItemsContainer.lastChild);
    }
    // Clear first row inputs
    const firstRow = orderItemsContainer.children[0];
    if (firstRow) {
        firstRow.querySelectorAll('input').forEach(inp => inp.value = '');
        const qtyInput = firstRow.querySelector('input[type="number"]');
        if (qtyInput) qtyInput.value = '1';
    }
    
    calculateOrderTotal();
    orderModalOverlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // Initialize Radix select
    initRadixSelect(document.getElementById('priorityRadixSelect'));
}

function closeOrderModal() {
    orderModalOverlay.style.display = 'none';
    document.body.style.overflow = '';
    currentSupplier = null;
}

// ==================== RADIX SELECT INIT ====================
function initRadixSelect(selectElement) {
    if (!selectElement) return;
    const trigger = selectElement.querySelector('.radix-select-trigger');
    const content = selectElement.querySelector('.radix-select-content');
    const items = selectElement.querySelectorAll('.radix-select-item');
    
    // Remove old listeners by cloning
    const newTrigger = trigger.cloneNode(true);
    if (trigger && trigger.parentNode) {
        trigger.parentNode.replaceChild(newTrigger, trigger);
    }
    
    newTrigger?.addEventListener('click', (e) => {
        e.stopPropagation();
        document.querySelectorAll('.radix-select-content').forEach(c => { 
            if (c !== content) c.classList.add('hidden'); 
        });
        content?.classList.toggle('hidden');
    });
    
    items.forEach(item => {
        item.addEventListener('click', (e) => {
            e.stopPropagation();
            const value = item.getAttribute('data-value');
            const label = item.textContent.replace(/<svg[\s\S]*?<\/svg>/g, '').trim();
            if (newTrigger) {
                newTrigger.querySelector('span').textContent = label;
                newTrigger.setAttribute('data-value', value);
            }
            items.forEach(i => i.setAttribute('data-selected', 'false'));
            item.setAttribute('data-selected', 'true');
            content?.classList.add('hidden');
        });
    });
}

// Close radix selects on outside click
document.addEventListener('click', (e) => {
    if (!e.target.closest('.radix-select')) {
        document.querySelectorAll('.radix-select-content').forEach(c => c.classList.add('hidden'));
    }
});

// ==================== ORDER MODAL EVENT LISTENERS ====================
document.getElementById('addItemBtn')?.addEventListener('click', addOrderItemRow);
document.getElementById('cancelOrderBtn')?.addEventListener('click', closeOrderModal);
document.getElementById('closeOrderModalBtn')?.addEventListener('click', closeOrderModal);
orderModalOverlay?.addEventListener('click', (e) => { 
    if (e.target === orderModalOverlay) closeOrderModal(); 
});

document.getElementById('orderFormModal')?.addEventListener('submit', (e) => {
    e.preventDefault();
    const priorityTrigger = document.querySelector('#priorityRadixSelect .radix-select-trigger');
    const priority = priorityTrigger?.getAttribute('data-value') || 'Normal';
    const deliveryDate = document.getElementById('deliveryDate')?.value || '';
    showToast(`Order placed with ${currentSupplier?.name || 'supplier'} (${priority} priority, delivery by ${deliveryDate})`);
    closeOrderModal();
});

// Attach events to existing first row in order modal
document.querySelectorAll('#orderItemsContainer .order-item-row').forEach(row => attachOrderItemEvents(row));

// ==================== RENDERING ====================
function getFilteredData(tab) {
    let filtered = [...suppliers];
    if (tab === "preferred") filtered = filtered.filter(s => s.preferred === true);
    else if (tab === "medications") filtered = filtered.filter(s => s.category === "Medications");
    else if (tab === "medical-supplies") filtered = filtered.filter(s => s.category === "Medical Supplies");
    if (searchQuery) filtered = filtered.filter(s => 
        s.name.toLowerCase().includes(searchQuery) || 
        s.email.toLowerCase().includes(searchQuery) || 
        s.id.toLowerCase().includes(searchQuery)
    );
    return filtered;
}

function renderSuppliersTable(tab) {
    const filtered = getFilteredData(tab);
    const tbodyMap = { 
        all: 'allSuppliersBody', 
        preferred: 'preferredSuppliersBody', 
        medications: 'medicationsSuppliersBody', 
        'medical-supplies': 'medicalSuppliesBody' 
    };
    const tbody = document.getElementById(tbodyMap[tab]); 
    if (!tbody) return;
    
    if (filtered.length === 0) { 
        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-8 text-gray-500">No suppliers found</td></tr>'; 
        return; 
    }
    
    tbody.innerHTML = filtered.map(s => `
        <tr class="border-b dark:border-gray-800">
            <td class="p-4 font-medium">${s.id}</td>
            <td class="p-4">${s.name}</td>
            <td class="p-4"><span class="inline-flex rounded-full px-2 py-0.5 text-xs bg-gray-100 dark:bg-gray-700 dark:text-gray-300">${s.category}</span></td>
            <td class="p-4"><div class="flex items-center gap-1"><svg class="h-3 w-3 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg><span class="text-xs">${s.email}</span></div></td>
            <td class="p-4"><div class="flex items-center gap-0.5">${renderStars(s.rating)}</div></td>
            <td class="p-4"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">${s.status}</span></td>
            <td class="p-4 text-right">
                <button data-id='${s.id}' class="action-trigger inline-flex items-center justify-center h-10 w-10 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                </button>
            </td>
        </tr>
    `).join('');
    
    // Attach action triggers
    tbody.querySelectorAll('.action-trigger').forEach(btn => { 
        btn.addEventListener('click', (e) => { 
            e.stopPropagation(); 
            const supplier = suppliers.find(s => s.id === btn.dataset.id); 
            if (supplier) showActionMenu(btn, supplier); 
        }); 
    });
}

function renderFeaturedSuppliers() {
    const featured = suppliers.filter(s => s.preferred === true).slice(0, 2);
    const container = document.getElementById('featuredSuppliersContainer');
    if (!container) return;
    container.innerHTML = featured.map(s => `
        <div class="flex flex-col rounded-lg border p-4 shadow-sm dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect><path d="M9 22v-4h6v4"></path></svg>
                    <h3 class="font-semibold dark:text-white">${s.name}</h3>
                </div>
                <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">Active</span>
            </div>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Leading provider of high-quality medical supplies and equipment.</p>
            <div class="mt-3 space-y-1 text-sm">
                <div class="flex items-center gap-2"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg><span class="dark:text-gray-300">${s.email}</span></div>
                <div class="flex items-center gap-2"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg><span class="dark:text-gray-300">${s.phone}</span></div>
            </div>
            <div class="mt-4 flex items-center justify-between">
                <div class="flex items-center gap-0.5">${renderStars(s.rating)}</div>
                <button class="inline-flex items-center gap-1.5 border rounded-md px-3 py-1.5 text-sm dark:border-gray-600 dark:hover:bg-gray-700 visit-website-btn" data-url="#">
    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
    Visit Website
</button>
            </div>
        </div>
    `).join('');
    document.querySelectorAll('.visit-website-btn').forEach(btn => 
        btn.addEventListener('click', () => showToast('Website link would open here'))
    );
}

function renderAllTables() {
    renderSuppliersTable('all');
    renderSuppliersTable('preferred');
    renderSuppliersTable('medications');
    renderSuppliersTable('medical-supplies');
    renderFeaturedSuppliers();
}

function activateTab(tabId) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
    document.getElementById(`tab-${tabId}`)?.classList.remove('hidden');
    document.querySelectorAll('.main-tab').forEach(btn => { 
        const isActive = btn.dataset.tab === tabId; 
        btn.setAttribute('data-state', isActive ? 'active' : 'inactive'); 
        if (isActive) {
            btn.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
            btn.classList.remove('dark:bg-gray-700');
        } else {
            btn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
        }
    });
    currentTab = tabId;
    renderSuppliersTable(tabId);
}

// ==================== EVENT LISTENERS ====================
document.querySelectorAll('.main-tab').forEach(btn => 
    btn.addEventListener('click', () => activateTab(btn.dataset.tab))
);

document.getElementById('searchInput')?.addEventListener('input', (e) => { 
    searchQuery = e.target.value.toLowerCase(); 
    renderAllTables(); 
});

document.getElementById('exportBtn')?.addEventListener('click', () => { 
    const data = getFilteredData(currentTab); 
    const headers = ["ID", "Name", "Category", "Email", "Phone", "Rating", "Status"]; 
    const rows = data.map(s => [s.id, s.name, s.category, s.email, s.phone, s.rating, s.status]); 
    const csv = [headers, ...rows].map(row => row.join(",")).join("\n"); 
    const blob = new Blob([csv], { type: "text/csv" }); 
    const a = document.createElement('a'); 
    a.href = URL.createObjectURL(blob); 
    a.download = `suppliers_${new Date().toISOString().slice(0, 10)}.csv`; 
    a.click(); 
    URL.revokeObjectURL(a.href); 
    showToast("Export complete"); 
});

document.getElementById('viewAllOrdersBtn')?.addEventListener('click', () => { 
    window.location.href = 'orders.html'; 
});

// Global keyboard and scroll handlers
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeActionMenu();
        if (orderModalOverlay?.style.display === 'flex') closeOrderModal();
        if (activeContactModal) closeContactModal();
    }
});

window.addEventListener('scroll', () => closeActionMenu());

// ==================== INIT ====================
renderAllTables();
activateTab('all');
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
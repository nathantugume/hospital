<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
        <link rel="icon" type="image/png" href="favicon.png">
    <title>Medi-track | Stock Alerts</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <script src="https://unpkg.com/lucide@latest" crossorigin="anonymous"></script>
    <style>
        * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .rounded-lg.border { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted { background-color: #262626 !important; }
        
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
        .text-amber-600 { color: #d97706; }
        .text-amber-600:hover { background-color: #fef3c7; }
        .text-blue-600 { color: #2563eb; }
        .text-blue-600:hover { background-color: #dbeafe; }
        .text-green-600 { color: #16a34a; }
        .text-green-600:hover { background-color: #dcfce7; }
        
        @keyframes fadeInScale { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        
/* Modal Overlay Styles */
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

/* Update Stock and Place Order Modal Containers */
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
.modal-footer { padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 0.75rem; }
body.dark .modal-footer { border-top-color: #333; }

.btn-cancel { background: transparent; border: 1px solid #d1d5db; padding: 0.5rem 1rem; border-radius: 0.375rem; cursor: pointer; font-size: 0.875rem; transition: background 0.1s; }
.btn-cancel:hover { background: #f3f4f6; }
body.dark .btn-cancel { border-color: #555; color: #e5e5e5; }
body.dark .btn-cancel:hover { background: #374151; }
.btn-submit {color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.375rem; cursor: pointer; font-size: 0.875rem; transition: background 0.1s; }

.form-group { margin-bottom: 1rem; }
.form-label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem; }
.form-input, .form-select, .form-textarea {
    width: 100%;
    border-radius: 0.375rem;
    border: 1px solid #e5e7eb;
    background-color: white;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    transition: all 0.1s;
}
body.dark .form-input, body.dark .form-select, body.dark .form-textarea { background-color: #262626; border-color: #404040; color: #e5e5e5; }
.form-input:focus, .form-select:focus, .form-textarea:focus { outline: none; ring: 2px solid #4f46e5; border-color: #4f46e5; }        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        
        .toast-message { position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white; padding: 12px 20px; border-radius: 8px; z-index: 11000; animation: slideIn 0.3s ease-out; font-size: 0.875rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        
        .dropdown-animation { animation: fadeInScale 0.12s ease-out; }
        .tab-panel.hidden { display: none; }
        [role="tab"][data-state="active"] { background: white; color: #1f2937; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        body.dark [role="tab"][data-state="active"] { background: #131212; color: #e5e5e5; }
   
   
   /* Add these styles to the existing <style> section */

/* Modal Body Scroll */
.modal-body-scroll {
    max-height: 60vh;
    overflow-y: auto;
    padding-right: 0.25rem;
}

/* Custom Select Dropdown (Radix UI Style) */
.custom-select {
    position: relative;
    width: 100%;
}

.custom-select-trigger {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.25rem;
    border-radius: 0.375rem;
    border: 1px solid #e5e7eb;
    background-color: white;
    cursor: pointer;
    transition: all 0.15s ease;
    text-align: left;
    color: inherit;
}

body.dark .custom-select-trigger {
    background-color: #262626;
    border-color: #404040;
    color: #e5e5e5;
}

.custom-select-trigger:hover {
    border-color: #d1d5db;
}

body.dark .custom-select-trigger:hover {
    border-color: #525252;
}

.custom-select-trigger:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
}

.custom-select-trigger[data-placeholder] {
    color: #9ca3af;
}

.custom-select-content {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    width: 100%;
    min-width: var(--radix-select-trigger-width);
    background: white;
    border-radius: 0.375rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    z-index: 1000;
    overflow: hidden;
    animation: selectSlideIn 0.15s ease-out;
}

body.dark .custom-select-content {
    background: #2a2a2a;
    border-color: #404040;
}

@keyframes selectSlideIn {
    from {
        opacity: 0;
        transform: translateY(-4px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.custom-select-viewport {
    padding: 0.25rem;
}

.custom-select-item {
    position: relative;
    display: flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.25rem;
    border-radius: 0.25rem;
    cursor: pointer;
    user-select: none;
    transition: background-color 0.1s;
}

.custom-select-item:hover {
    background-color: #f3f4f6;
}

body.dark .custom-select-item:hover {
    background-color: #3f3f46;
}

.custom-select-item[data-highlighted] {
    background-color: #4f46e5;
    color: white;
    outline: none;
}

body.dark .custom-select-item[data-highlighted] {
    background-color: #6366f1;
}

.custom-select-item[data-state="checked"] {
    font-weight: 600;
    background-color: #eef2ff;
}

body.dark .custom-select-item[data-state="checked"] {
    background-color: #1e1b4b;
}

.custom-select-item-indicator {
    position: absolute;
    right: 0.5rem;
    display: flex;
    align-items: center;
}

.custom-select-scroll-button {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 25px;
    background: white;
    cursor: default;
}

body.dark .custom-select-scroll-button {
    background: #2a2a2a;
}

/* Scrollable Modal Body */
.modal-body-scrollable {
    max-height: calc(80vh - 120px);
    overflow-y: auto;
    padding-right: 8px;
}

/* Custom scrollbar for modal body */
.modal-body-scrollable::-webkit-scrollbar {
    width: 6px;
}

.modal-body-scrollable::-webkit-scrollbar-track {
    background: transparent;
}

.modal-body-scrollable::-webkit-scrollbar-thumb {
    background-color: #d1d5db;
    border-radius: 3px;
}

body.dark .modal-body-scrollable::-webkit-scrollbar-thumb {
    background-color: #4b5563;
}

/* Radix UI Style Select */
.radix-select {
    position: relative;
    width: 100%;
}

.radix-select-trigger {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 0.375rem;
    border: 1px solid #e5e7eb;
    background-color: white;
    cursor: pointer;
    transition: all 0.15s ease;
    min-height: 38px;
}

body.dark .radix-select-trigger {
    background-color: #262626;
    border-color: #404040;
    color: #e5e5e5;
}

.radix-select-trigger:hover {
    border-color: #d1d5db;
}

.radix-select-trigger:focus {
    outline: none;
    border-color: #4f46e5;
    box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
}

.radix-select-content {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    margin-top: 4px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    z-index: 10001;
    overflow: hidden;
    animation: selectSlideDown 0.15s ease-out;
}

body.dark .radix-select-content {
    background: #2a2a2a;
    border-color: #404040;
}

.radix-select-item {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: space-between;
    transition: background-color 0.1s;
}

.radix-select-item:hover {
    background-color: #f3f4f6;
}

body.dark .radix-select-item:hover {
    background-color: #3f3f46;
}

.radix-select-item[data-selected="true"] {
    background-color: #eef2ff;
    color: #4f46e5;
    font-weight: 500;
}

body.dark .radix-select-item[data-selected="true"] {
    background-color: #1e1b4b;
    color: #818cf8;
}

.radix-select-item-indicator {
    display: none;
}

.radix-select-item[data-selected="true"] .radix-select-item-indicator {
    display: block;
}

@keyframes selectSlideDown {
    from {
        opacity: 0;
        transform: translateY(-8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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
            <!-- Header Section -->
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="inventory.html">
                        <button class="inline-flex items-center justify-center shrink-0 gap-2 rounded-md text-sm font-medium border border-gray-300 bg-background hover:bg-gray-100 size-10">
                            <svg class="lucide lucide-arrow-left h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                        </button>
                    </a>
                    <div><h2 class="text-2xl lg:text-3xl font-bold tracking-tight">Stock Alerts</h2><p class="text-gray-500">Monitor and manage inventory alerts</p></div>
                </div>
                <div class="flex items-center gap-2">
                    <button id="exportBtn" class="inline-flex items-center justify-center gap-2 rounded-md border bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 text-sm">
                        <svg class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg> Export
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex justify-between"><h3 class="text-sm font-medium text-gray-500">Low Stock Items</h3><svg class="w-5 h-5 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line></svg></div><div class="text-2xl font-bold mt-2" id="lowStockCount">7</div><p class="text-xs text-gray-500">Below minimum levels</p></div>
                <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex justify-between"><h3 class="text-sm font-medium text-gray-500">Out of Stock Items</h3><svg class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line></svg></div><div class="text-2xl font-bold mt-2" id="outOfStockCount">5</div><p class="text-xs text-gray-500">Completely depleted</p></div>
                <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex justify-between"><h3 class="text-sm font-medium text-gray-500">Expiring Soon</h3><svg class="w-5 h-5 text-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg></div><div class="text-2xl font-bold mt-2" id="expiringCount">6</div><p class="text-xs text-gray-500">Within next 30 days</p></div>
                <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition"><div class="flex justify-between"><h3 class="text-sm font-medium text-gray-500">Pending Orders</h3><svg class="w-5 h-5 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="8" cy="21" r="1"></circle><circle cx="19" cy="21" r="1"></circle><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg></div><div class="text-2xl font-bold mt-2">7</div><p class="text-xs"><a href="orders.html" class="hover:underline">View orders</a></p></div>
            </div>

            <!-- Filters Bar -->
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="flex w-full items-center gap-2 md:w-auto flex-wrap">
                    <div class="relative w-full md:w-80">
                        <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                        <input id="searchInput" class="h-10 rounded-md border border-gray-300 bg-background pl-8 pr-3 py-2 text-sm w-full focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Search alerts..." type="search">
                    </div>
                    
                    <!-- Alert Type Filter Dropdown -->
                    <div class="relative">
                        <button id="alertTypeFilterBtn" type="button" class="flex h-10 items-center justify-between rounded-md border border-gray-300 bg-background px-3 py-2 text-sm w-[150px]">
                            <span id="alertTypeFilterText">All Alerts</span>
                            <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                        </button>
                        <div id="alertTypeDropdown" class="hidden absolute top-full left-0 mt-1 w-full rounded-md border bg-background shadow-lg z-50 py-1 dropdown-animation">
                            <div data-alert-type="all" class="dropdown-item px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer">All Alerts</div>
                            <div data-alert-type="Low Stock" class="dropdown-item px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer">Low Stock</div>
                            <div data-alert-type="Out of Stock" class="dropdown-item px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer">Out of Stock</div>
                            <div data-alert-type="Expiring Soon" class="dropdown-item px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer">Expiring Soon</div>
                        </div>
                    </div>
                    
                    <!-- Category Filter Dropdown -->
                    <div class="relative">
                        <button id="categoryFilterBtn" type="button" class="flex h-10 items-center justify-between rounded-md border border-gray-300 bg-background px-3 py-2 text-sm w-[160px]">
                            <span id="categoryFilterText">All Categories</span>
                            <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                        </button>
                        <div id="categoryDropdown" class="hidden absolute top-full left-0 mt-1 w-full rounded-md border bg-background shadow-lg z-50 py-1 dropdown-animation">
                            <div data-category="all" class="dropdown-item px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer">All Categories</div>
                            <div data-category="Medications" class="dropdown-item px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer">Medications</div>
                            <div data-category="Medical Supplies" class="dropdown-item px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer">Medical Supplies</div>
                        </div>
                    </div>

                    <!-- Sort By Dropdown -->
                    <div class="relative">
                        <button id="sortByBtn" type="button" class="flex h-10 items-center justify-between rounded-md border border-gray-300 bg-background px-3 py-2 text-sm w-[160px]">
                            <span id="sortByText">Sort By</span>
                            <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                        </button>
                        <div id="sortByDropdown" class="hidden absolute top-full left-0 mt-1 w-full rounded-md border bg-background shadow-lg z-50 py-1 dropdown-animation">
                            <div data-sort="name_asc" class="dropdown-item px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer">Name (A to Z)</div>
                            <div data-sort="name_desc" class="dropdown-item px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer">Name (Z to A)</div>
                            <div class="border-t my-1"></div>
                            <div data-sort="stock_asc" class="dropdown-item px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer">Stock: Low to High</div>
                            <div data-sort="stock_desc" class="dropdown-item px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer">Stock: High to Low</div>
                            <div class="border-t my-1"></div>
                            <div data-sort="expiry_asc" class="dropdown-item px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer">Expiry: Soonest First</div>
                            <div data-sort="expiry_desc" class="dropdown-item px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer">Expiry: Latest First</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="w-full">
                <div class="flex flex-wrap items-center gap-1 rounded-md bg-gray-100 p-1 w-fit">
                    <button data-tab="all" class="tab-btn px-3 py-1.5 text-sm font-medium rounded-sm transition">All Alerts</button>
                    <button data-tab="low-stock" class="tab-btn active-tab px-3 py-1.5 text-sm font-medium rounded-sm bg-white shadow-sm transition">Low Stock</button>
                    <button data-tab="out-of-stock" class="tab-btn px-3 py-1.5 text-sm font-medium rounded-sm transition">Out of Stock</button>
                    <button data-tab="expiring" class="tab-btn px-3 py-1.5 text-sm font-medium rounded-sm transition">Expiring Soon</button>
                </div>
                <div class="mt-4">
                    <div id="panel-low-stock" class="tab-panel"></div>
                    <div id="panel-out-of-stock" class="tab-panel hidden"></div>
                    <div id="panel-expiring" class="tab-panel hidden"></div>
                    <div id="panel-all" class="tab-panel hidden"></div>
                </div>
            </div>

            <!-- Alert Settings -->
            <div class="rounded-lg border bg-background shadow-sm">
                <div class="p-4 border-b"><h2 class="text-xl font-semibold">Alert Settings</h2><p class="text-gray-500">Configure how and when you receive inventory alerts</p></div>
                <div class="p-4 space-y-4">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="space-y-2"><h3 class="text-sm font-medium">Notification Preferences</h3>
                            <div class="flex items-center justify-between rounded-md border p-4"><div class="flex items-center gap-2"><svg class="w-4 h-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path></svg><div><p class="text-sm font-medium">Email Notifications</p><p class="text-xs text-gray-500">Receive alerts via email</p></div></div><button class="rounded-md h-10 border px-3 py-1 text-sm">Configure</button></div>
                            <div class="flex items-center justify-between rounded-md border p-4"><div class="flex items-center gap-2"><svg class="w-4 h-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg><div><p class="text-sm font-medium">Alert Frequency</p><p class="text-xs text-gray-500">Daily summary at 9:00 AM</p></div></div><button class="rounded-md h-10 border px-3 py-1 text-sm">Configure</button></div>
                        </div>
                        <div class="space-y-2"><h3 class="text-sm font-medium">Alert Thresholds</h3>
                            <div class="flex items-center justify-between rounded-md border p-4"><div class="flex items-center gap-2"><svg class="w-4 h-4 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line></svg><div><p class="text-sm font-medium">Low Stock Threshold</p><p class="text-xs text-gray-500">Default: 20% of minimum level</p></div></div><button class="rounded-md h-10 border px-3 py-1 text-sm">Configure</button></div>
                            <div class="flex items-center justify-between rounded-md border p-4"><div class="flex items-center gap-2"><svg class="w-4 h-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg><div><p class="text-sm font-medium">Expiry Alert Period</p><p class="text-xs text-gray-500">Default: 30 days before expiry</p></div></div><button class="rounded-md h-10 border px-3 py-1 text-sm">Configure</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<!-- Global Modal Backdrop -->
<div id="globalModalBackdrop" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40" style="display: none;"></div>

<!-- Dismiss Alert Modal Wrapper -->
<div id="dismissAlertOverlay" class="modal-overlay" style="display: none;">
    <div id="dismissAlertModal" class="modal-container sm:max-w-[425px]">
        <div class="modal-header">
            <h2 class="modal-title">Dismiss Alert</h2>
            <button type="button" class="modal-close close-dismiss-modal">&times;</button>
        </div>
        <form id="dismissAlertForm">
            <div class="modal-body space-y-4">
                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="text-sm font-medium text-right">Item</label>
                    <input id="dismissItemName" class="form-input bg-gray-50 col-span-3" disabled>
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="text-sm font-medium text-right">Alert</label>
                    <input id="dismissAlertType" class="form-input bg-gray-50 col-span-3" disabled>
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="text-sm font-medium text-right">Reason</label>
                    <div class="relative col-span-3">
                        <button type="button" id="dismissReasonBtn" class="form-select flex justify-between items-center">
                            <span id="dismissReasonText">Issue Resolved</span>
                            <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                        </button>
                        <div id="dismissReasonDropdown" class="hidden absolute top-full left-0 mt-1 w-full rounded-md border bg-background shadow-lg z-[100] py-1">
                            <div data-reason="resolved" class="dismiss-reason-option px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer">Issue Resolved</div>
                            <div data-reason="ordered" class="dismiss-reason-option px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer">Order Placed</div>
                            <div data-reason="false-alert" class="dismiss-reason-option px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer">False Alert</div>
                            <div data-reason="other" class="dismiss-reason-option px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-800 cursor-pointer">Other</div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-4 items-center gap-4">
                    <label class="text-sm font-medium text-right">Notes</label>
                    <textarea id="dismissNotes" class="form-textarea col-span-3" placeholder="Optional notes..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel cancel-dismiss-btn">Cancel</button>
                <button type="submit" class="btn-submit bg-primary hover:bg-primary/90">Dismiss Alert</button>
            </div>
        </form>
    </div>
</div>

<!-- Dismiss Modal Overlay -->
<div id="dismissModalOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40" style="display: none;"></div>

<!-- Backdrop for modals -->
<div id="modalBackdrop" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40" style="display: none;"></div>

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
function showToast(message, isError = false) { const existing = document.querySelector('.toast-message'); if (existing) existing.remove(); const toast = document.createElement('div'); toast.className = `toast-message ${isError ? 'error' : ''}`; toast.textContent = message; document.body.appendChild(toast); setTimeout(() => toast.remove(), 3000); }

// ==================== DATA ====================
const lowStockData = [
    { id: "INV002", name: "Ibuprofen 200mg", category: "Medications", currentStock: 12, minLevel: 15, status: "Low Stock", supplier: "Biopharm Uganda" },
    { id: "INV005", name: "Amoxicillin 500mg", category: "Medications", currentStock: 8, minLevel: 10, status: "Low Stock", supplier: "AAR Healthcare Supplies" },
    { id: "INV007", name: "Examination Table Paper", category: "Medical Supplies", currentStock: 3, minLevel: 5, status: "Low Stock", supplier: "Eclipse Medical Supplies" },
    { id: "INV011", name: "Surgical Gloves (Medium)", category: "Medical Supplies", currentStock: 45, minLevel: 50, status: "Low Stock", supplier: "Rocimar Pharma" },
    { id: "INV015", name: "Bandages (Box)", category: "Medical Supplies", currentStock: 7, minLevel: 10, status: "Low Stock", supplier: "Eclipse Medical Supplies" },
    { id: "INV018", name: "Antiseptic Solution", category: "Medical Supplies", currentStock: 4, minLevel: 6, status: "Low Stock", supplier: "AAR Healthcare Supplies" },
    { id: "INV023", name: "Syringes 10ml", category: "Medical Supplies", currentStock: 30, minLevel: 40, status: "Low Stock", supplier: "Rocimar Pharma" }
];

const outOfStockData = [
    { id: "INV004", name: "Surgical Masks (Box)", category: "Medical Supplies", currentStock: 0, minLevel: 10, status: "Out of Stock", supplier: "MedSupply Co." },
    { id: "INV019", name: "Lidocaine 2%", category: "Medications", currentStock: 0, minLevel: 8, status: "Out of Stock", supplier: "Biopharm Uganda" },
    { id: "INV027", name: "Sterile Gauze Pads", category: "Medical Supplies", currentStock: 0, minLevel: 25, status: "Out of Stock", supplier: "Eclipse Medical Supplies" },
    { id: "INV031", name: "Disposable Thermometer Covers", category: "Medical Supplies", currentStock: 0, minLevel: 100, status: "Out of Stock", supplier: "Rocimar Pharma" },
    { id: "INV042", name: "Tongue Depressors (Box)", category: "Medical Supplies", currentStock: 0, minLevel: 15, status: "Out of Stock", supplier: "MedSupply Co." }
];

const expiringData = [
    { id: "INV008", name: "Epinephrine Injection", category: "Medications", currentStock: 12, expiryDate: "2023-05-15", status: "Expiring Soon", supplier: "Biopharm Uganda" },
    { id: "INV013", name: "Flu Vaccines", category: "Medications", currentStock: 25, expiryDate: "2023-05-20", status: "Expiring Soon", supplier: "AAR Healthcare Supplies" },
    { id: "INV021", name: "Insulin Vials", category: "Medications", currentStock: 8, expiryDate: "2023-05-25", status: "Expiring Soon", supplier: "Biopharm Uganda" },
    { id: "INV024", name: "Tetanus Vaccines", category: "Medications", currentStock: 15, expiryDate: "2023-05-18", status: "Expiring Soon", supplier: "AAR Healthcare Supplies" },
    { id: "INV029", name: "Saline Solution", category: "Medical Supplies", currentStock: 30, expiryDate: "2023-05-30", status: "Expiring Soon", supplier: "Eclipse Medical Supplies" },
    { id: "INV035", name: "Sterilization Indicators", category: "Medical Supplies", currentStock: 40, expiryDate: "2023-05-22", status: "Expiring Soon", supplier: "Rocimar Pharma" }
];

let currentSearchQuery = "";
let currentAlertTypeFilter = "all";
let currentCategoryFilter = "all";
let currentSortBy = "name_asc";
let activeActionMenu = null;
let currentDismissItem = null;

const globalModalBackdrop = document.getElementById('globalModalBackdrop');
const dismissModal = document.getElementById('dismissAlertModal');
const dismissItemName = document.getElementById('dismissItemName');
const dismissAlertType = document.getElementById('dismissAlertType');
const dismissReasonBtn = document.getElementById('dismissReasonBtn');
const dismissReasonDropdown = document.getElementById('dismissReasonDropdown');
const dismissReasonText = document.getElementById('dismissReasonText');
const dismissNotes = document.getElementById('dismissNotes');

// Dismiss Reason button - Remove old event listener and add Radix select
const dismissReasonRadixSelect = document.getElementById('dismissReasonRadixSelect');
if (dismissReasonBtn) {
    // Create a wrapper div if needed
    const reasonWrapper = document.createElement('div');
    reasonWrapper.className = 'radix-select';
    reasonWrapper.id = 'dismissReasonRadixSelect';
    
    // Replace the button structure if it's a button, otherwise wrap it
    if (dismissReasonBtn.tagName === 'BUTTON') {
        dismissReasonBtn.parentNode.insertBefore(reasonWrapper, dismissReasonBtn);
        reasonWrapper.appendChild(dismissReasonBtn);
        reasonWrapper.appendChild(dismissReasonDropdown);
        
        // Add Radix select trigger class
        dismissReasonBtn.className = 'radix-select-trigger flex justify-between items-center';
        dismissReasonDropdown.className = 'radix-select-content hidden';
        
        // Add classes to options
        document.querySelectorAll('.dismiss-reason-option').forEach(opt => {
            opt.className = 'radix-select-item';
            // Add checkmark indicator
            const checkmark = document.createElement('span');
            checkmark.innerHTML = `<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>`;
            opt.appendChild(checkmark);
            if (opt.getAttribute('data-reason') === 'resolved') {
                opt.setAttribute('data-selected', 'true');
            }
        });
        
        // Initialize
        initRadixSelect(reasonWrapper);
    }
}

// ==================== MODERN ACTION MENU ====================
function closeActionMenu() { if (activeActionMenu) { activeActionMenu.remove(); activeActionMenu = null; } }

function showActionMenu(btn, item) {
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
        <div class="action-divider"></div>
        <button data-action="updateStock" class="action-item text-amber-600">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
            Update Stock
        </button>
        <button data-action="placeOrder" class="action-item text-blue-600">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
            Place Order
        </button>
        <div class="action-divider"></div>
        <button data-action="dismiss" class="action-item text-green-600">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            Dismiss Alert
        </button>
    `;
    document.body.appendChild(menu);
    activeActionMenu = menu;
    
    const closeHandler = (e) => { if (!menu.contains(e.target) && e.target !== btn) { closeActionMenu(); document.removeEventListener('click', closeHandler); } };
    setTimeout(() => document.addEventListener('click', closeHandler), 10);
    
    menu.querySelector('[data-action="view"]')?.addEventListener('click', () => { window.location.href = `inventory-details.html?id=${item.id}`; closeActionMenu(); });
    menu.querySelector('[data-action="updateStock"]')?.addEventListener('click', () => { openUpdateStockModal(item); closeActionMenu(); });
    menu.querySelector('[data-action="placeOrder"]')?.addEventListener('click', () => { openPlaceOrderModal(item); closeActionMenu(); });
    menu.querySelector('[data-action="dismiss"]')?.addEventListener('click', () => { openDismissModal(item); closeActionMenu(); });
}



// ==================== DISMISS MODAL LOGIC ====================
const dismissOverlay = document.getElementById('dismissAlertOverlay');

function openDismissModal(item) {
    currentDismissItem = item;
    dismissItemName.value = item.name;
    dismissAlertType.value = item.status;
    dismissReasonText.textContent = 'Issue Resolved';
    dismissNotes.value = '';
    
    // Show the entire overlay
    dismissOverlay.style.display = 'flex';
    document.body.style.overflow = 'hidden'; // Prevent background scroll
}

function closeDismissModal() {
    dismissOverlay.style.display = 'none';
    document.body.style.overflow = '';
    currentDismissItem = null;
}

// Close when clicking directly on the overlay backdrop
dismissOverlay.addEventListener('click', (e) => {
    if (e.target === dismissOverlay) closeDismissModal();
});

// Reason dropdown inside modal
dismissReasonBtn?.addEventListener('click', (e) => {
    e.stopPropagation();
    dismissReasonDropdown.classList.toggle('hidden');
});

document.querySelectorAll('.dismiss-reason-option').forEach(opt => {
    opt.addEventListener('click', () => {
        dismissReasonText.textContent = opt.textContent;
        dismissReasonDropdown.classList.add('hidden');
    });
});

// Form Submission
document.getElementById('dismissAlertForm')?.addEventListener('submit', (e) => {
    e.preventDefault();
    showToast(`Alert for ${currentDismissItem?.name} dismissed.`);
    closeDismissModal();
});

// Wire up the close/cancel buttons
document.querySelector('.cancel-dismiss-btn')?.addEventListener('click', closeDismissModal);
document.querySelector('.close-dismiss-modal')?.addEventListener('click', closeDismissModal);// Reason dropdown
if (dismissReasonBtn) {
    dismissReasonBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        dismissReasonDropdown.classList.toggle('hidden');
    });
}

document.querySelectorAll('.dismiss-reason-option').forEach(opt => {
    opt.addEventListener('click', () => {
        dismissReasonText.textContent = opt.textContent;
        dismissReasonDropdown.classList.add('hidden');
    });
});

// Close modal handlers
document.querySelector('.cancel-dismiss-btn')?.addEventListener('click', closeDismissModal);
document.querySelector('.close-dismiss-modal')?.addEventListener('click', closeDismissModal);
if (globalModalBackdrop) globalModalBackdrop.addEventListener('click', closeDismissModal);

document.addEventListener('click', (e) => {
    if (dismissReasonBtn && !dismissReasonBtn.contains(e.target) && dismissReasonDropdown && !dismissReasonDropdown.contains(e.target)) {
        dismissReasonDropdown?.classList.add('hidden');
    }
});

document.getElementById('dismissAlertForm')?.addEventListener('submit', (e) => {
    e.preventDefault();
    showToast(`Alert for ${currentDismissItem?.name} dismissed. Reason: ${dismissReasonText.textContent}`);
    closeDismissModal();
});

// ==================== UPDATE STOCK MODAL ====================
// ==================== UPDATE STOCK MODAL ====================
function openUpdateStockModal(item) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 z-50 flex items-center justify-center modal-overlay';
    modal.innerHTML = `
        <div class="modal-container">
            <div class="modal-header">
                <h2 class="modal-title">Update Stock Level</h2>
                <button class="modal-close close-modal-btn">&times;</button>
            </div>
            <div class="modal-body modal-body-scrollable">
                <div class="form-group"><label class="form-label">Item</label><input type="text" class="form-input bg-gray-50" disabled value="${escapeHtml(item.name)}"></div>
                <div class="form-group"><label class="form-label">Current Stock</label><input type="number" class="form-input bg-gray-50" disabled value="${item.currentStock}"></div>
                <div class="form-group"><label class="form-label">New Stock *</label><input type="number" id="newStockVal" class="form-input" min="0" value="${item.currentStock}"></div>
                <div class="form-group">
                    <label class="form-label">Reason</label>
                    <div class="radix-select" id="reasonRadixSelect">
                        <button type="button" class="radix-select-trigger" data-value="Restock">
                            <span>Restock</span>
                            <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                        </button>
                        <div class="radix-select-content hidden">
                            <div class="radix-select-item" data-value="Restock" data-selected="true">
                                Restock
                                <svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <div class="radix-select-item" data-value="Inventory Adjustment">
                                Inventory Adjustment
                                <svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <div class="radix-select-item" data-value="Damaged/Expired">
                                Damaged/Expired
                                <svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <div class="radix-select-item" data-value="Used in Procedure">
                                Used in Procedure
                                <svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group"><label class="form-label">Notes</label><textarea class="form-textarea" rows="2" placeholder="Additional details"></textarea></div>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel close-modal-btn">Cancel</button>
                <button id="confirmStockBtn" class="btn-submit bg-primary hover:bg-primary/90">Update Stock</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    if (globalModalBackdrop) globalModalBackdrop.style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    const closeModal = () => { modal.remove(); if (globalModalBackdrop) globalModalBackdrop.style.display = 'none'; document.body.style.overflow = ''; };
    modal.querySelectorAll('.close-modal-btn').forEach(btn => btn.addEventListener('click', closeModal));
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
    
    // Initialize Radix UI select
    initRadixSelect(modal.querySelector('#reasonRadixSelect'));
    
    modal.querySelector('#confirmStockBtn')?.addEventListener('click', () => {
        const newStock = modal.querySelector('#newStockVal').value;
        const reasonTrigger = modal.querySelector('#reasonRadixSelect .radix-select-trigger');
        const reason = reasonTrigger.getAttribute('data-value');
        showToast(`Stock updated for ${item.name} to ${newStock} units (${reason})`);
        closeModal();
    });
}

// ==================== PLACE ORDER MODAL ====================
// ==================== PLACE ORDER MODAL ====================
function openPlaceOrderModal(item) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 z-50 flex items-center justify-center modal-overlay';
    modal.innerHTML = `
        <div class="modal-container">
            <div class="modal-header">
                <h2 class="modal-title">Place Order</h2>
                <button class="modal-close close-modal-btn">&times;</button>
            </div>
            <div class="modal-body modal-body-scrollable">
                <div class="form-group"><label class="form-label">Item</label><input type="text" class="form-input bg-gray-50" disabled value="${escapeHtml(item.name)}"></div>
                <div class="form-group"><label class="form-label">Current Stock</label><div class="flex items-center gap-2"><input type="text" class="form-input w-24 bg-gray-50" disabled value="${item.currentStock}"><span class="text-xs text-gray-500">Min Level: ${item.minLevel || 'N/A'}</span></div></div>
                <div class="form-group"><label class="form-label">Order Quantity *</label><input type="number" id="orderQty" class="form-input" min="1" value="1"></div>
                <div class="form-group"><label class="form-label">Supplier *</label><input type="text" id="supplierName" class="form-input" value="${escapeHtml(item.supplier)}"></div>
                <div class="form-group"><label class="form-label">Delivery Date</label><input type="date" id="deliveryDate" class="form-input" value="${new Date().toISOString().split('T')[0]}"></div>
                <div class="form-group">
                    <label class="form-label">Priority</label>
                    <div class="radix-select" id="priorityRadixSelect">
                        <button type="button" class="radix-select-trigger" data-value="Normal">
                            <span>Normal</span>
                            <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                        </button>
                        <div class="radix-select-content hidden">
                            <div class="radix-select-item" data-value="Low">
                                Low
                                <svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <div class="radix-select-item" data-value="Normal" data-selected="true">
                                Normal
                                <svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <div class="radix-select-item" data-value="High">
                                High
                                <svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                            <div class="radix-select-item" data-value="Urgent">
                                Urgent
                                <svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group"><label class="form-label">Notes</label><textarea class="form-textarea" rows="2" placeholder="Additional instructions"></textarea></div>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel close-modal-btn">Cancel</button>
                <button id="confirmOrderBtn" class="btn-submit bg-primary hover:bg-primary/90">Place Order</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    if (globalModalBackdrop) globalModalBackdrop.style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    const closeModal = () => { modal.remove(); if (globalModalBackdrop) globalModalBackdrop.style.display = 'none'; document.body.style.overflow = ''; };
    modal.querySelectorAll('.close-modal-btn').forEach(btn => btn.addEventListener('click', closeModal));
    modal.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
    
    // Initialize Radix UI select
    initRadixSelect(modal.querySelector('#priorityRadixSelect'));
    
    modal.querySelector('#confirmOrderBtn')?.addEventListener('click', () => {
        const qty = modal.querySelector('#orderQty').value;
        const supplier = modal.querySelector('#supplierName').value;
        const priorityTrigger = modal.querySelector('#priorityRadixSelect .radix-select-trigger');
        const priority = priorityTrigger.getAttribute('data-value');
        if (!supplier) { showToast('Please enter supplier name', true); return; }
        showToast(`Order placed for ${qty} units from ${supplier} (${priority} priority)`);
        closeModal();
    });
}

// ==================== RADIX UI SELECT ====================
function initRadixSelect(selectElement) {
    if (!selectElement) return;
    
    const trigger = selectElement.querySelector('.radix-select-trigger');
    const content = selectElement.querySelector('.radix-select-content');
    const items = selectElement.querySelectorAll('.radix-select-item');
    
    // Toggle dropdown
    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = !content.classList.contains('hidden');
        
        // Close all other radix selects
        document.querySelectorAll('.radix-select-content').forEach(c => c.classList.add('hidden'));
        
        if (isOpen) {
            content.classList.add('hidden');
        } else {
            content.classList.remove('hidden');
        }
    });
    
    // Select item
    items.forEach(item => {
        item.addEventListener('click', (e) => {
            e.stopPropagation();
            const value = item.getAttribute('data-value');
            const label = item.textContent.trim();
            
            // Update trigger
            trigger.querySelector('span').textContent = label;
            trigger.setAttribute('data-value', value);
            
            // Update selected state
            items.forEach(i => i.setAttribute('data-selected', 'false'));
            item.setAttribute('data-selected', 'true');
            
            // Close dropdown
            content.classList.add('hidden');
        });
    });
    
    // Close on outside click
    document.addEventListener('click', (e) => {
        if (!selectElement.contains(e.target)) {
            content.classList.add('hidden');
        }
    });
    
    // Close on escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            content.classList.add('hidden');
        }
    });
}

// ==================== FILTERING & SORTING ====================
function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

function getStatusBadge(status) {
    const base = "inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ";
    if (status === "Low Stock") return base + "bg-amber-100 text-amber-800";
    if (status === "Out of Stock") return base + "bg-red-100 text-red-800";
    if (status === "Expiring Soon") return base + "bg-orange-100 text-orange-800";
    return base + "bg-gray-100 text-gray-800";
}

function applySorting(items) {
    const sorted = [...items];
    switch(currentSortBy) {
        case 'name_asc': return sorted.sort((a, b) => a.name.localeCompare(b.name));
        case 'name_desc': return sorted.sort((a, b) => b.name.localeCompare(a.name));
        case 'stock_asc': return sorted.sort((a, b) => (a.currentStock || 0) - (b.currentStock || 0));
        case 'stock_desc': return sorted.sort((a, b) => (b.currentStock || 0) - (a.currentStock || 0));
        case 'expiry_asc': return sorted.sort((a, b) => {
            if (!a.expiryDate) return 1; if (!b.expiryDate) return -1;
            return new Date(a.expiryDate) - new Date(b.expiryDate);
        });
        case 'expiry_desc': return sorted.sort((a, b) => {
            if (!a.expiryDate) return 1; if (!b.expiryDate) return -1;
            return new Date(b.expiryDate) - new Date(a.expiryDate);
        });
        default: return sorted;
    }
}

function getFilteredLowStockData() {
    let filtered = [...lowStockData];
    if (currentSearchQuery) filtered = filtered.filter(item => item.name.toLowerCase().includes(currentSearchQuery.toLowerCase()) || item.id.toLowerCase().includes(currentSearchQuery.toLowerCase()));
    if (currentCategoryFilter !== "all") filtered = filtered.filter(item => item.category === currentCategoryFilter);
    return applySorting(filtered);
}

function getFilteredOutOfStockData() {
    let filtered = [...outOfStockData];
    if (currentSearchQuery) filtered = filtered.filter(item => item.name.toLowerCase().includes(currentSearchQuery.toLowerCase()) || item.id.toLowerCase().includes(currentSearchQuery.toLowerCase()));
    if (currentCategoryFilter !== "all") filtered = filtered.filter(item => item.category === currentCategoryFilter);
    return applySorting(filtered);
}

function getFilteredExpiringData() {
    let filtered = [...expiringData];
    if (currentSearchQuery) filtered = filtered.filter(item => item.name.toLowerCase().includes(currentSearchQuery.toLowerCase()) || item.id.toLowerCase().includes(currentSearchQuery.toLowerCase()));
    if (currentCategoryFilter !== "all") filtered = filtered.filter(item => item.category === currentCategoryFilter);
    return applySorting(filtered);
}

function getFilteredAllAlerts() {
    let allItems = [...lowStockData, ...outOfStockData, ...expiringData];
    if (currentSearchQuery) allItems = allItems.filter(item => item.name.toLowerCase().includes(currentSearchQuery.toLowerCase()) || item.id.toLowerCase().includes(currentSearchQuery.toLowerCase()));
    if (currentAlertTypeFilter !== "all") allItems = allItems.filter(item => item.status === currentAlertTypeFilter);
    if (currentCategoryFilter !== "all") allItems = allItems.filter(item => item.category === currentCategoryFilter);
    return applySorting(allItems);
}

// ==================== RENDER FUNCTIONS ====================
function attachActionTriggers() {
    document.querySelectorAll('.action-trigger').forEach(btn => {
        btn.removeEventListener('click', handleActionClick);
        btn.addEventListener('click', handleActionClick);
    });
}

function handleActionClick(e) {
    e.stopPropagation();
    const btn = e.currentTarget;
    const item = JSON.parse(btn.getAttribute('data-item'));
    showActionMenu(btn, item);
}

function renderLowStockTable() {
    const panel = document.getElementById('panel-low-stock');
    if (!panel) return;
    const filteredData = getFilteredLowStockData();
    if (filteredData.length === 0) { panel.innerHTML = `<div class="rounded-lg border bg-background shadow-sm p-8 text-center text-gray-500">No low stock items found</div>`; return; }
    panel.innerHTML = `<div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h2 class="text-xl font-semibold">Low Stock Items</h2><p class="text-gray-500">Items that have fallen below their minimum stock level</p></div><div class="p-4 overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr><th class="h-12 px-4 text-left">Item ID</th><th class="h-12 px-4 text-left">Name</th><th class="h-12 px-4 text-left">Category</th><th class="h-12 px-4 text-left">Current Stock</th><th class="h-12 px-4 text-left">Min. Level</th><th class="h-12 px-4 text-left">Status</th><th class="h-12 px-4 text-left">Supplier</th><th class="h-12 px-4 text-right">Actions</th></tr></thead><tbody>${filteredData.map(item => `<tr class="border-b hover:bg-gray-50"><td class="px-4 py-3">${item.id}</td><td class="px-4 py-3 font-medium">${escapeHtml(item.name)}</td><td class="px-4 py-3">${item.category}</td><td class="px-4 py-3">${item.currentStock}</td><td class="px-4 py-3">${item.minLevel}</td><td class="px-4 py-3"><span class="${getStatusBadge(item.status)}">${item.status}</span></td><td class="px-4 py-3">${escapeHtml(item.supplier)}</td><td class="px-4 py-3 text-right"><button data-item='${JSON.stringify(item).replace(/'/g, "\\'")}' class="action-trigger inline-flex h-8 w-8 items-center justify-center rounded-md hover:bg-gray-100"><svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg></button></td></tr>`).join('')}</tbody></table></div></div>`;
    attachActionTriggers();
}

function renderOutOfStockTable() {
    const panel = document.getElementById('panel-out-of-stock');
    if (!panel) return;
    const filteredData = getFilteredOutOfStockData();
    if (filteredData.length === 0) { panel.innerHTML = `<div class="rounded-lg border bg-background shadow-sm p-8 text-center text-gray-500">No out of stock items found</div>`; return; }
    panel.innerHTML = `<div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h2 class="text-xl font-semibold">Out of Stock Items</h2><p class="text-gray-500">Items that are completely out of stock</p></div><div class="p-4 overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr><th class="h-12 px-4 text-left">Item ID</th><th class="h-12 px-4 text-left">Name</th><th class="h-12 px-4 text-left">Category</th><th class="h-12 px-4 text-left">Current Stock</th><th class="h-12 px-4 text-left">Min. Level</th><th class="h-12 px-4 text-left">Status</th><th class="h-12 px-4 text-left">Supplier</th><th class="h-12 px-4 text-right">Actions</th></tr></thead><tbody>${filteredData.map(item => `<tr class="border-b hover:bg-gray-50"><td class="px-4 py-3">${item.id}</td><td class="px-4 py-3 font-medium">${escapeHtml(item.name)}</td><td class="px-4 py-3">${item.category}</td><td class="px-4 py-3">${item.currentStock}</td><td class="px-4 py-3">${item.minLevel}</td><td class="px-4 py-3"><span class="${getStatusBadge(item.status)}">${item.status}</span></td><td class="px-4 py-3">${escapeHtml(item.supplier)}</td><td class="px-4 py-3 text-right"><button data-item='${JSON.stringify(item).replace(/'/g, "\\'")}' class="action-trigger inline-flex h-8 w-8 items-center justify-center rounded-md hover:bg-gray-100"><svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg></button></td></tr>`).join('')}</tbody></table></div></div>`;
    attachActionTriggers();
}

function renderExpiringTable() {
    const panel = document.getElementById('panel-expiring');
    if (!panel) return;
    const filteredData = getFilteredExpiringData();
    if (filteredData.length === 0) { panel.innerHTML = `<div class="rounded-lg border bg-background shadow-sm p-8 text-center text-gray-500">No expiring items found</div>`; return; }
    panel.innerHTML = `<div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h2 class="text-xl font-semibold">Expiring Soon</h2><p class="text-gray-500">Items that will expire within the next 30 days</p></div><div class="p-4 overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr><th class="h-12 px-4 text-left">Item ID</th><th class="h-12 px-4 text-left">Name</th><th class="h-12 px-4 text-left">Category</th><th class="h-12 px-4 text-left">Current Stock</th><th class="h-12 px-4 text-left">Expiry Date</th><th class="h-12 px-4 text-left">Status</th><th class="h-12 px-4 text-left">Supplier</th><th class="h-12 px-4 text-right">Actions</th></tr></thead><tbody>${filteredData.map(item => `<tr class="border-b hover:bg-gray-50"><td class="px-4 py-3">${item.id}</td><td class="px-4 py-3 font-medium">${escapeHtml(item.name)}</td><td class="px-4 py-3">${item.category}</td><td class="px-4 py-3">${item.currentStock}</td><td class="px-4 py-3">${item.expiryDate}</td><td class="px-4 py-3"><span class="${getStatusBadge(item.status)}">${item.status}</span></td><td class="px-4 py-3">${escapeHtml(item.supplier)}</td><td class="px-4 py-3 text-right"><button data-item='${JSON.stringify(item).replace(/'/g, "\\'")}' class="action-trigger inline-flex h-8 w-8 items-center justify-center rounded-md hover:bg-gray-100"><svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg></button></td></tr>`).join('')}</tbody></table></div></div>`;
    attachActionTriggers();
}

function renderAllAlertsTable() {
    const allAlerts = getFilteredAllAlerts();
    const panel = document.getElementById('panel-all');
    if (!panel) return;
    if (allAlerts.length === 0) { panel.innerHTML = `<div class="rounded-lg border bg-background shadow-sm p-8 text-center text-gray-500">No alerts found matching your filters</div>`; return; }
    panel.innerHTML = `<div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><h2 class="text-xl font-semibold">All Alerts</h2><p class="text-gray-500">All inventory alerts in one view</p></div><div class="p-4 overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr><th class="h-12 px-4 text-left">Item ID</th><th class="h-12 px-4 text-left">Name</th><th class="h-12 px-4 text-left">Category</th><th class="h-12 px-4 text-left">Alert Type</th><th class="h-12 px-4 text-left">Current Stock</th><th class="h-12 px-4 text-left">Supplier</th><th class="h-12 px-4 text-right">Actions</th></tr></thead><tbody>${allAlerts.map(item => `<tr class="border-b hover:bg-gray-50"><td class="px-4 py-3">${item.id}</td><td class="px-4 py-3 font-medium">${escapeHtml(item.name)}</td><td class="px-4 py-3">${item.category}</td><td class="px-4 py-3"><span class="${getStatusBadge(item.status)}">${item.status}</span></td><td class="px-4 py-3">${item.currentStock}</td><td class="px-4 py-3">${escapeHtml(item.supplier)}</td><td class="px-4 py-3 text-right"><button data-item='${JSON.stringify(item).replace(/'/g, "\\'")}' class="action-trigger inline-flex h-8 w-8 items-center justify-center rounded-md hover:bg-gray-100"><svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg></button></td></tr>`).join('')}</tbody></div></div>`;
    attachActionTriggers();
}

function updateStatsCards() {
    document.getElementById('lowStockCount').innerText = getFilteredLowStockData().length;
    document.getElementById('outOfStockCount').innerText = getFilteredOutOfStockData().length;
    document.getElementById('expiringCount').innerText = getFilteredExpiringData().length;
}

function renderAll() {
    renderLowStockTable();
    renderOutOfStockTable();
    renderExpiringTable();
    renderAllAlertsTable();
    updateStatsCards();
}

// ==================== DROPDOWNS ====================
function initDropdowns() {
    const alertTypeBtn = document.getElementById('alertTypeFilterBtn');
    const alertTypeDropdown = document.getElementById('alertTypeDropdown');
    const alertTypeText = document.getElementById('alertTypeFilterText');
    if (alertTypeBtn && alertTypeDropdown) {
        alertTypeBtn.addEventListener('click', (e) => { e.stopPropagation(); alertTypeDropdown.classList.toggle('hidden'); });
        alertTypeDropdown.querySelectorAll('[data-alert-type]').forEach(item => {
            item.addEventListener('click', () => {
                currentAlertTypeFilter = item.getAttribute('data-alert-type');
                alertTypeText.textContent = item.textContent.trim();
                alertTypeDropdown.classList.add('hidden');
                renderAll();
            });
        });
    }
    
    const categoryBtn = document.getElementById('categoryFilterBtn');
    const categoryDropdown = document.getElementById('categoryDropdown');
    const categoryText = document.getElementById('categoryFilterText');
    if (categoryBtn && categoryDropdown) {
        categoryBtn.addEventListener('click', (e) => { e.stopPropagation(); categoryDropdown.classList.toggle('hidden'); });
        categoryDropdown.querySelectorAll('[data-category]').forEach(item => {
            item.addEventListener('click', () => {
                currentCategoryFilter = item.getAttribute('data-category');
                categoryText.textContent = item.textContent.trim();
                categoryDropdown.classList.add('hidden');
                renderAll();
            });
        });
    }
    
    const sortByBtn = document.getElementById('sortByBtn');
    const sortByDropdown = document.getElementById('sortByDropdown');
    const sortByText = document.getElementById('sortByText');
    if (sortByBtn && sortByDropdown) {
        sortByBtn.addEventListener('click', (e) => { e.stopPropagation(); sortByDropdown.classList.toggle('hidden'); });
        sortByDropdown.querySelectorAll('[data-sort]').forEach(item => {
            item.addEventListener('click', () => {
                currentSortBy = item.getAttribute('data-sort');
                sortByText.textContent = item.textContent.trim();
                sortByDropdown.classList.add('hidden');
                renderAll();
            });
        });
    }
    
    document.addEventListener('click', (e) => {
        if (alertTypeBtn && !alertTypeBtn.contains(e.target)) alertTypeDropdown?.classList.add('hidden');
        if (categoryBtn && !categoryBtn.contains(e.target)) categoryDropdown?.classList.add('hidden');
        if (sortByBtn && !sortByBtn.contains(e.target)) sortByDropdown?.classList.add('hidden');
    });
}

// ==================== EVENT LISTENERS ====================
document.getElementById('searchInput')?.addEventListener('input', (e) => { currentSearchQuery = e.target.value; renderAll(); });
document.getElementById('exportBtn')?.addEventListener('click', () => { 
    const data = getFilteredAllAlerts();
    const headers = ["Item ID","Name","Category","Alert Type","Current Stock","Supplier"];
    const rows = data.map(item => [item.id, item.name, item.category, item.status, item.currentStock, item.supplier]);
    const csv = [headers, ...rows].map(row => row.join(",")).join("\n");
    const blob = new Blob([csv], {type:"text/csv"});
    const a = document.createElement('a'); a.href = URL.createObjectURL(blob); a.download = `stock_alerts_${new Date().toISOString().slice(0,10)}.csv`; a.click(); URL.revokeObjectURL(a.href);
    showToast("Export complete");
});

document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('bg-white', 'shadow-sm'));
        btn.classList.add('bg-white', 'shadow-sm');
        const tab = btn.getAttribute('data-tab');
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.add('hidden'));
        document.getElementById(`panel-${tab}`).classList.remove('hidden');
    });
});

document.addEventListener('keydown', (e) => { 
    if (e.key === 'Escape') { 
        closeActionMenu(); 
        if (dismissModal?.style.display === 'block') closeDismissModal(); 
        if (globalModalBackdrop?.style.display === 'block') {
            document.querySelectorAll('.modal-overlay').forEach(modal => modal.remove());
            globalModalBackdrop.style.display = 'none';
            document.body.style.overflow = '';
        }
    } 
});

window.addEventListener('scroll', () => closeActionMenu());

initDropdowns();
renderAll();
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
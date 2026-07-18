<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Payroll Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-background { background-color: #131212 !important; }
        body.dark .border-gray-200, body.dark .border-input { border-color: #333333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-700, body.dark h1, body.dark label { color: #e5e5e5 !important; }
        body.dark input, body.dark select { background-color: #262626 !important; border-color: #404040 !important; color: #e5e5e5 !important; }

        /* Action Menu Styles */
        .action-menu {
            position: fixed;
            z-index: 1000;
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            min-width: 168px;
            padding: 0.25rem;
            animation: fadeIn 0.12s ease-out;
        }
        body.dark .action-menu { background: #2a2a2a; border-color: #404040; }
        .action-menu-header {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 0.25rem;
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
        }
        .action-item:hover { background-color: #f3f4f6; }
        body.dark .action-item:hover { background-color: #3f3f46; }
        .action-divider { height: 1px; background-color: #e5e7eb; margin: 0.25rem 0; }
        body.dark .action-divider { background-color: #404040; }
        .action-item.text-red { color: #ef4444; }
        .action-item.text-red:hover { background-color: #fee2e2; }
        body.dark .action-item.text-red:hover { background-color: rgba(239,68,68,0.1); }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Toast */
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

        /* Delete Modal */
        .alert-dialog-overlay {
            position: fixed;
            inset: 0;
            background-color: rgb(0 0 0 / 87%);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeInBackdrop 0.15s ease-out;
        }
        .alert-dialog-overlay.hidden { display: none; }
        .alert-dialog {
            position: fixed;
            left: 50%;
            top: 50%;
            z-index: 10000;
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
        @keyframes fadeInBackdrop { from { opacity: 0; } to { opacity: 1; } }
        @keyframes modalSlideIn {
            from { opacity: 0; transform: translate(-50%, -48%) scale(0.96); }
            to { opacity: 1; transform: translate(-50%, -50%) scale(1); }
        }
        .alert-dialog-header { display: flex; flex-direction: column; gap: 0.5rem; }
        .alert-dialog-title { font-size: 1.125rem; font-weight: 600; line-height: 1.4; letter-spacing: -0.02em; }
        .alert-dialog-description { font-size: 0.875rem; color: #6b7280; }
        body.dark .alert-dialog-description { color: #9ca3af; }
        .alert-dialog-footer {
            display: flex;
            flex-direction: column-reverse;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }
        @media (min-width: 640px) {
            .alert-dialog-footer { flex-direction: row; justify-content: flex-end; }
        }
        .alert-dialog-cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
            background-color: white;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.1s;
        }
        body.dark .alert-dialog-cancel { background-color: #262626; border-color: #404040; color: #e5e5e5; }
        .alert-dialog-cancel:hover { background-color: #f9fafb; }
        body.dark .alert-dialog-cancel:hover { background-color: #374151; }
        .alert-dialog-delete {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            background-color: #ef4444;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: white;
            cursor: pointer;
            transition: background-color 0.1s;
            border: none;
        }
        .alert-dialog-delete:hover { background-color: #dc2626; }

        /* Filter Popover */
        .filter-popover {
            position: fixed;
            z-index: 1000;
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            width: 350px;
            padding: 1rem;
            animation: fadeIn 0.12s ease-out;
        }
        body.dark .filter-popover { background: #2a2a2a; border-color: #404040; }

        /* Add/Edit Payroll Dialog Overlay */
.dialog-overlay {
    position: fixed;
    inset: 0;
    background-color: rgb(0 0 0 / 87%);
    backdrop-filter: blur(2px);
    z-index: 9999;
    animation: fadeInBackdrop 0.2s ease-out;
}

/* Add/Edit Payroll Dialog Content */
.dialog-content {
    position: fixed;
    z-index: 10000;
    background: white;
    border-radius: 0.75rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    animation: modalSlideUp 0.2s ease-out;
    max-width: 700px;
    width: 90%;
}
body.dark .dialog-content {
    background: #1e1e1e !important;
    border: 1px solid #333;
}
body.dark .dialog-content input,
body.dark .dialog-content select {
    background-color: #262626 !important;
    border-color: #404040 !important;
    color: #e5e5e5 !important;
}

.dialog-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
body.dark .dialog-header { border-bottom-color: #404040; }
.dialog-title { font-size: 1.125rem; font-weight: 600; }
.dialog-close {
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
.dialog-close:hover { color: #1f2937; background-color: #f3f4f6; }
body.dark .dialog-close:hover { color: #e5e5e5; background-color: #374151; }
.dialog-body { padding: 1.5rem; }
.dialog-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}
body.dark .dialog-footer { border-top-color: #404040; }

@keyframes fadeInBackdrop {
    from { opacity: 0; }
    to { opacity: 1; }
}
@keyframes modalSlideUp {
    from { opacity: 0; transform: translate(-50%, -48%) scale(0.96); }
    to { opacity: 1; transform: translate(-50%, -50%) scale(1); }
}

/* Staff Select Dropdown */
.staff-select-trigger {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: 40px;
    border-radius: 0.375rem;
    border: 1px solid #e5e7eb;
    background-color: white;
    padding: 0 0.75rem;
    font-size: 0.875rem;
    cursor: pointer;
}
body.dark .staff-select-trigger { background-color: #262626; border-color: #404040; color: #e5e5e5; }
.staff-select-content {
    position: absolute;
    z-index: 10001;
    margin-top: 4px;
    width: 100%;
    max-height: 200px;
    overflow-y: auto;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    background-color: white;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
}

/* Dialog Body Scrollable */
.dialog-body {
    max-height: calc(85vh - 140px);
    overflow-y: auto;
    padding-right: 0.5rem;
}

/* Custom scrollbar for dialog body */
.dialog-body::-webkit-scrollbar {
    width: 6px;
}

.dialog-body::-webkit-scrollbar-track {
    background: transparent;
    border-radius: 10px;
}

.dialog-body::-webkit-scrollbar-thumb {
    background-color: #d1d5db;
    border-radius: 10px;
}

body.dark .dialog-body::-webkit-scrollbar-thumb {
    background-color: #4b5563;
}

/* Ensure dialog content has proper height constraints */
.dialog-content {
    max-height: 90vh;
    display: flex;
    flex-direction: column;
}

.dialog-body {
    flex: 1;
    min-height: 0;
}

body.dark .staff-select-content { background-color: #2a2a2a; border-color: #404040; }
.staff-select-item {
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    cursor: pointer;
    transition: background-color 0.1s;
}
.staff-select-item:hover { background-color: #f3f4f6; }
body.dark .staff-select-item:hover { background-color: #3a3a3a; }
    
    
    /* Radix UI Select Styles */
.radix-select-wrap {
    position: relative;
    width: 100%;
}

.radix-select-trigger {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    height: 40px;
    border-radius: 0.375rem;
    border: 1px solid #e5e7eb;
    background-color: white;
    padding: 0 0.75rem;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.15s ease;
    text-align: left;
    color: #374151;
}

body.dark .radix-select-trigger {
    background-color: #262626;
    border-color: #404040;
    color: #e5e5e5;
}

.radix-select-trigger:hover {
    border-color: #6366f1;
}

.radix-select-trigger:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.radix-select-content {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    width: 100%;
    max-height: 240px;
    overflow-y: auto;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.5rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
    z-index: 10001;
    animation: radixSlideDown 0.15s ease-out;
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
    color: #374151;
}

body.dark .radix-select-item {
    color: #e5e5e5;
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

.radix-select-check {
    display: none;
    width: 16px;
    height: 16px;
}

.radix-select-item[data-selected="true"] .radix-select-check {
    display: block;
}

@keyframes radixSlideDown {
    from {
        opacity: 0;
        transform: translateY(-8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}</style>


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
            <div class="flex flex-col md:flex-row justify-between gap-4">
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">Payroll</h1>
                    <p class="text-gray-500">Manage employee salaries and generate payslips.</p>
                </div>
                <button id="addPayrollBtn" class="inline-flex items-center justify-center rounded-md bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 text-sm shadow-sm">+ Add Payroll Entry</button>
            </div>

            <!-- Payroll Card -->
            <div class="rounded-lg border bg-background shadow-sm">
                <div class="p-4 space-y-4">
                    <div class="flex flex-col md:flex-row justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-semibold">Employee Payroll</h2>
                            <div class="text-gray-500">A list of all employees with their salary details.</div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <div class="relative">
                                <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                                <input id="searchInput" class="h-10 rounded-md border border-gray-300 bg-background px-3 py-2 text-sm pl-8 w-full md:w-[250px] focus:ring-2 focus:ring-indigo-500 focus:outline-none" placeholder="Search employees...">
                            </div>
                            <button id="filterButton" class="inline-flex items-center justify-center gap-2 w-40 rounded-md border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 text-sm shadow-sm">Filters</button>
                            <button id="downloadCsvBtn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background size-10 hover:bg-accent hover:text-accent-foreground h-10 text-gray-600 shadow-sm"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg><span class="sr-only">Download CSV</span></button>
                        </div>
                    </div>
                    <div id="activeFiltersContainer" class="flex flex-wrap gap-2"></div>
                </div>
                <div class="p-3 md:p-4 xxl:p-6">
                    <div class="relative w-full overflow-auto">
                        <div id="tableContainer" class="p-4 pt-0 overflow-x-auto"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Filter Popover -->
<div id="filterPopover" class="filter-popover hidden">
    <div class="flex justify-between items-center mb-4">
        <h4 class="font-semibold text-gray-900">Filter</h4>
        <button id="clearAllFilters" class="text-xs text-indigo-600 hover:text-indigo-700 font-medium">Clear All</button>
    </div>

    <!-- Employee Filter -->
    <div class="space-y-2 mb-4">
        <div class="flex items-center justify-between">
            <label class="text-sm font-medium text-gray-700">Employee</label>
            <button class="reset-filter text-xs text-indigo-600 hover:text-indigo-700 font-medium" data-filter="employee">Reset</button>
        </div>
        <select id="filterEmployee" class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">Please select</option>
        </select>
    </div>

    <!-- Role Filter -->
    <div class="space-y-2 mb-4">
        <div class="flex items-center justify-between">
            <label class="text-sm font-medium text-gray-700">Role</label>
            <button class="reset-filter text-xs text-indigo-600 hover:text-indigo-700 font-medium" data-filter="role">Reset</button>
        </div>
        <select id="filterRole" class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">Please select</option>
        </select>
    </div>

    <!-- Date Filter -->
    <div class="space-y-2 mb-4">
        <div class="flex items-center justify-between">
            <label class="text-sm font-medium text-gray-700">Date</label>
            <button class="reset-filter text-xs text-indigo-600 hover:text-indigo-700 font-medium" data-filter="date">Reset</button>
        </div>
        <input type="date" id="filterDate" class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
    </div>

    <!-- Status Filter -->
    <div class="space-y-2 mb-4">
        <div class="flex items-center justify-between">
            <label class="text-sm font-medium text-gray-700">Status</label>
            <button class="reset-filter text-xs text-indigo-600 hover:text-indigo-700 font-medium" data-filter="status">Reset</button>
        </div>
        <select id="filterStatus" class="w-full border border-gray-300 rounded-md p-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">Please select</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
        </select>
    </div>

    <button id="applyFiltersBtn" class="w-full bg-primary hover:bg-primary/90 transition-colors text-white py-2 rounded-md font-medium text-sm shadow-sm">Apply Filters</button>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="alert-dialog-overlay hidden">
    <div role="alertdialog" class="alert-dialog">
        <div class="alert-dialog-header">
            <h2 id="deleteModalTitle" class="alert-dialog-title">Are you sure you want to delete this payroll entry?</h2>
            <p id="deleteModalDesc" class="alert-dialog-description">This action cannot be undone. The payroll data will be permanently removed.</p>
        </div>
        <div class="alert-dialog-footer">
            <button type="button" id="deleteModalCancel" class="alert-dialog-cancel">Cancel</button>
            <button type="button" id="deleteModalConfirm" class="alert-dialog-delete">Delete</button>
        </div>
    </div>
</div>

<!-- Add Employee Salary Modal -->
<div id="addPayrollModal" class="hidden">
    <div class="dialog-content" style="left: 50%; top: 50%; transform: translate(-50%, -50%);">
        <div class="dialog-header">
            <h4 class="dialog-title">Add Employee Salary</h4>
            <button type="button" class="dialog-close" id="closeAddModalBtn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
        <form id="addPayrollForm">
            <div class="dialog-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-sm font-medium block mb-1">Select Staff</label>
                        <div class="relative" id="addStaffDropdown">
                            <button type="button" class="staff-select-trigger" id="addStaffTrigger">
                                <span id="addStaffLabel">Select staff</span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M4.516 7.548c0.436-0.446 1.043-0.481 1.576 0l3.908 3.747 3.908-3.747c0.533-0.481 1.141-0.446 1.574 0 0.436 0.445 0.408 1.197 0 1.615-0.406 0.418-4.695 4.502-4.695 4.502-0.217 0.223-0.502 0.335-0.787 0.335s-0.57-0.112-0.789-0.335c0 0-4.287-4.084-4.695-4.502s-0.436-1.17 0-1.615z"></path></svg>
                            </button>
                            <div class="staff-select-content hidden" id="addStaffContent"></div>
                        </div>
                    </div>
<div>
    <label class="text-sm font-medium block mb-1">Currency</label>
    <div class="radix-select-wrap" id="addCurrencySelect">
        <button type="button" class="radix-select-trigger">
            <span>UGX - Ugandan Shilling</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="radix-select-content hidden">
            <div class="radix-select-item" data-value="UGX" data-selected="true">UGX - Ugandan Shilling<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="KES">KES - Kenyan Shilling<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="TZS">TZS - Tanzanian Shilling<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="RWF">RWF - Rwandan Franc<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="USD">USD - US Dollar<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
        </div>
    </div>
</div>
<div>
    <label class="text-sm font-medium block mb-1">Payment Period</label>
    <div class="radix-select-wrap" id="addPaymentPeriodSelect">
        <button type="button" class="radix-select-trigger">
            <span>Monthly</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="radix-select-content hidden">
            <div class="radix-select-item" data-value="monthly" data-selected="true">Monthly<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="biweekly">Bi-Weekly<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="weekly">Weekly<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
        </div>
    </div>
</div>
                    <div>
                        <label class="text-sm font-medium block mb-1">Net Salary</label>
                        <input type="text" id="addNetSalary" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm bg-gray-50" readonly>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Earnings Column -->
                    <div>
                        <h6 class="text-sm font-semibold mb-3 text-green-700">Earnings</h6>
                        <div class="space-y-3">
                            <div><label class="text-sm font-medium">Basic Salary <span class="text-red-500">*</span></label><input type="number" id="addBasicSalary" class="add-earning w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                            <div><label class="text-sm font-medium">House Allowance</label><input type="number" id="addHouseAllowance" class="add-earning w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                            <div><label class="text-sm font-medium">Transport Allowance</label><input type="number" id="addTransportAllowance" class="add-earning w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                            <div><label class="text-sm font-medium">Medical Allowance</label><input type="number" id="addMedicalAllowance" class="add-earning w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                            <div><label class="text-sm font-medium">Responsibility Allowance</label><input type="number" id="addResponsibilityAllowance" class="add-earning w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                            <div><label class="text-sm font-medium">Overtime Pay</label><input type="number" id="addOvertimePay" class="add-earning w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                            <div><label class="text-sm font-medium">Bonus/Arrears</label><input type="number" id="addBonus" class="add-earning w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                        </div>
                    </div>

                    <!-- Deductions Column -->
                    <div>
                        <h6 class="text-sm font-semibold mb-3 text-red-700">Deductions</h6>
                        <div class="space-y-3">
                            <div><label class="text-sm font-medium">PAYE (Income Tax) <span class="text-red-500">*</span></label><input type="number" id="addPAYE" class="add-deduction w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                            <div><label class="text-sm font-medium">NSSF/NHIF Contribution</label><input type="number" id="addNSSF" class="add-deduction w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                            <div><label class="text-sm font-medium">Pension Contribution</label><input type="number" id="addPension" class="add-deduction w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                            <div><label class="text-sm font-medium">Loan Recovery</label><input type="number" id="addLoanRecovery" class="add-deduction w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                            <div><label class="text-sm font-medium">Salary Advance</label><input type="number" id="addSalaryAdvance" class="add-deduction w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                            <div><label class="text-sm font-medium">SACCO Contribution</label><input type="number" id="addSACCO" class="add-deduction w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                            <div><label class="text-sm font-medium">Absenteeism Penalty</label><input type="number" id="addAbsenteeism" class="add-deduction w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                        </div>
                    </div>
                </div>

                <!-- Bank Details (East Africa specific) -->
                <div class="border-t pt-4 mt-4">
                    <h6 class="text-sm font-semibold mb-3">Bank Payment Details</h6>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
<div>
    <label class="text-sm font-medium block mb-1">Bank Name</label>
    <div class="radix-select-wrap" id="addBankNameSelect">
        <button type="button" class="radix-select-trigger">
            <span>Select Bank</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="radix-select-content hidden">
            <div class="radix-select-item" data-value="Equity Bank">Equity Bank<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="KCB Bank">KCB Bank<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="Stanbic Bank">Stanbic Bank<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="CRDB Bank">CRDB Bank<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="NMB Bank">NMB Bank<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="Bank of Kigali">Bank of Kigali<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="DTB">Diamond Trust Bank<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="Absa Bank">Absa Bank<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="NCBA Bank">NCBA Bank<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="I&M Bank">I&M Bank<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
        </div>
    </div>
</div>
                        <div>
                            <label class="text-sm font-medium block mb-1">Account Number</label>
                            <input type="text" id="addAccountNumber" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Enter account number">
                        </div>
<div>
    <label class="text-sm font-medium block mb-1">Payment Method</label>
    <div class="radix-select-wrap" id="addPaymentMethodSelect">
        <button type="button" class="radix-select-trigger">
            <span>Bank Transfer</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="radix-select-content hidden">
            <div class="radix-select-item" data-value="bank" data-selected="true">Bank Transfer<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="mobile">Mobile Money<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="cash">Cash<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="cheque">Cheque<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
        </div>
    </div>
</div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3" id="mobileMoneyFields" style="display:none;">
<div>
    <label class="text-sm font-medium block mb-1">Mobile Money Provider</label>
    <div class="radix-select-wrap" id="addMobileProviderSelect">
        <button type="button" class="radix-select-trigger">
            <span>Select Provider</span>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
        </button>
        <div class="radix-select-content hidden">
            <div class="radix-select-item" data-value="M-Pesa">M-Pesa<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="Airtel Money">Airtel Money<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="MTN Mobile Money">MTN Mobile Money<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
            <div class="radix-select-item" data-value="Tigo Pesa">Tigo Pesa<span class="radix-select-check"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></span></div>
        </div>
    </div>
</div>
                        <div>
                            <label class="text-sm font-medium block mb-1">Mobile Number</label>
                            <input type="text" id="addMobileNumber" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="e.g. 07XX XXX XXX">
                        </div>
                    </div>
                </div>
            </div>
            <div class="dialog-footer">
                <button type="button" class="cancel-dialog-btn rounded-md border border-gray-300 bg-white px-4 py-2 text-sm hover:bg-gray-50">Cancel</button>
                <button type="submit" class="rounded-md bg-primary text-white px-4 py-2 text-sm hover:bg-primary/90">Add Payslip</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Employee Salary Modal -->
<div id="editPayrollModal" class="hidden">
    <div class="dialog-content" style="left: 50%; top: 50%; transform: translate(-50%, -50%);">
        <div class="dialog-header">
            <h4 class="dialog-title">Edit Employee Salary</h4>
            <button type="button" class="dialog-close" id="closeEditModalBtn">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
            </button>
        </div>
        <form id="editPayrollForm">
            <div class="dialog-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-sm font-medium block mb-1">Select Staff</label>
                        <div class="relative" id="editStaffDropdown">
                            <button type="button" class="staff-select-trigger" id="editStaffTrigger">
                                <span id="editStaffLabel">Select staff</span>
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M4.516 7.548c0.436-0.446 1.043-0.481 1.576 0l3.908 3.747 3.908-3.747c0.533-0.481 1.141-0.446 1.574 0 0.436 0.445 0.408 1.197 0 1.615-0.406 0.418-4.695 4.502-4.695 4.502-0.217 0.223-0.502 0.335-0.787 0.335s-0.57-0.112-0.789-0.335c0 0-4.287-4.084-4.695-4.502s-0.436-1.17 0-1.615z"></path></svg>
                            </button>
                            <div class="staff-select-content hidden" id="editStaffContent"></div>
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-medium block mb-1">Currency</label>
                        <select id="editCurrency" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm">
                            <option value="UGX">UGX - Ugandan Shilling</option>
                            <option value="KES" selected>KES - Kenyan Shilling</option>
                            <option value="TZS">TZS - Tanzanian Shilling</option>
                            <option value="RWF">RWF - Rwandan Franc</option>
                            <option value="USD">USD - US Dollar</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium block mb-1">Payment Period</label>
                        <select id="editPaymentPeriod" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm">
                            <option value="monthly" selected>Monthly</option>
                            <option value="biweekly">Bi-Weekly</option>
                            <option value="weekly">Weekly</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm font-medium block mb-1">Net Salary</label>
                        <input type="text" id="editNetSalary" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm bg-gray-50" readonly value="0">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Earnings Column -->
                    <div>
                        <h6 class="text-sm font-semibold mb-3 text-green-700">Earnings</h6>
                        <div class="space-y-3">
                            <div><label class="text-sm font-medium">Basic Salary <span class="text-red-500">*</span></label><input type="number" id="editBasicSalary" class="edit-earning w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="80000" step="0.01"></div>
                            <div><label class="text-sm font-medium">House Allowance</label><input type="number" id="editHouseAllowance" class="edit-earning w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="25000" step="0.01"></div>
                            <div><label class="text-sm font-medium">Transport Allowance</label><input type="number" id="editTransportAllowance" class="edit-earning w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="15000" step="0.01"></div>
                            <div><label class="text-sm font-medium">Medical Allowance</label><input type="number" id="editMedicalAllowance" class="edit-earning w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="10000" step="0.01"></div>
                            <div><label class="text-sm font-medium">Responsibility Allowance</label><input type="number" id="editResponsibilityAllowance" class="edit-earning w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="5000" step="0.01"></div>
                            <div><label class="text-sm font-medium">Overtime Pay</label><input type="number" id="editOvertimePay" class="edit-earning w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                            <div><label class="text-sm font-medium">Bonus/Arrears</label><input type="number" id="editBonus" class="edit-earning w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                        </div>
                    </div>

                    <!-- Deductions Column -->
                    <div>
                        <h6 class="text-sm font-semibold mb-3 text-red-700">Deductions</h6>
                        <div class="space-y-3">
                            <div><label class="text-sm font-medium">PAYE (Income Tax) <span class="text-red-500">*</span></label><input type="number" id="editPAYE" class="edit-deduction w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="12000" step="0.01"></div>
                            <div><label class="text-sm font-medium">NSSF/NHIF Contribution</label><input type="number" id="editNSSF" class="edit-deduction w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="4000" step="0.01"></div>
                            <div><label class="text-sm font-medium">Pension Contribution</label><input type="number" id="editPension" class="edit-deduction w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="4000" step="0.01"></div>
                            <div><label class="text-sm font-medium">Loan Recovery</label><input type="number" id="editLoanRecovery" class="edit-deduction w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="5000" step="0.01"></div>
                            <div><label class="text-sm font-medium">Salary Advance</label><input type="number" id="editSalaryAdvance" class="edit-deduction w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                            <div><label class="text-sm font-medium">SACCO Contribution</label><input type="number" id="editSACCO" class="edit-deduction w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="3000" step="0.01"></div>
                            <div><label class="text-sm font-medium">Absenteeism Penalty</label><input type="number" id="editAbsenteeism" class="edit-deduction w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="0" step="0.01"></div>
                        </div>
                    </div>
                </div>

                <!-- Bank Details -->
                <div class="border-t pt-4 mt-4">
                    <h6 class="text-sm font-semibold mb-3">Bank Payment Details</h6>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="text-sm font-medium block mb-1">Bank Name</label>
                            <select id="editBankName" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm">
                                <option value="">Select Bank</option>
                                <option value="Equity Bank" selected>Equity Bank</option>
                                <option value="KCB Bank">KCB Bank</option>
                                <option value="Stanbic Bank">Stanbic Bank</option>
                                <option value="CRDB Bank">CRDB Bank</option>
                                <option value="NMB Bank">NMB Bank</option>
                                <option value="Bank of Kigali">Bank of Kigali</option>
                                <option value="DTB">Diamond Trust Bank</option>
                                <option value="Absa Bank">Absa Bank</option>
                                <option value="NCBA Bank">NCBA Bank</option>
                                <option value="I&M Bank">I&M Bank</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-medium block mb-1">Account Number</label>
                            <input type="text" id="editAccountNumber" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" value="1234567890">
                        </div>
                        <div>
                            <label class="text-sm font-medium block mb-1">Payment Method</label>
                            <select id="editPaymentMethod" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm">
                                <option value="bank" selected>Bank Transfer</option>
                                <option value="mobile">Mobile Money</option>
                                <option value="cash">Cash</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3" id="editMobileMoneyFields" style="display:none;">
                        <div>
                            <label class="text-sm font-medium block mb-1">Mobile Money Provider</label>
                            <select id="editMobileProvider" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm">
                                <option value="">Select Provider</option>
                                <option value="M-Pesa">M-Pesa</option>
                                <option value="Airtel Money">Airtel Money</option>
                                <option value="MTN Mobile Money">MTN Mobile Money</option>
                                <option value="Tigo Pesa">Tigo Pesa</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm font-medium block mb-1">Mobile Number</label>
                            <input type="text" id="editMobileNumber" class="w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="e.g. 07XX XXX XXX">
                        </div>
                    </div>
                </div>
            </div>
            <div class="dialog-footer">
                <button type="button" class="cancel-dialog-btn rounded-md border border-gray-300 bg-white px-4 py-2 text-sm hover:bg-gray-50">Cancel</button>
                <button type="submit" class="rounded-md bg-primary text-white px-4 py-2 text-sm hover:bg-primary/90">Save Changes</button>
            </div>
        </form>
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
    // ========== Payroll Data ==========
    let payrollData = [
        { id: 'PMT-001', employee: 'Dr. Nakato Sarah', email: 'nakato.sarah@hospital.ug', joiningDate: '2020-03-15', role: 'Senior Doctor', salary: 120000, status: 'Active' },
        { id: 'PMT-002', employee: 'Dr. Mwangi Peter', email: 'mwangi.peter@hospital.ug', joiningDate: '2021-06-01', role: 'Cardiologist', salary: 110000, status: 'Active' },
        { id: 'PMT-003', employee: 'Emily Rodriguez', email: 'emily.r@hospital.ug', joiningDate: '2019-11-20', role: 'Nurse Manager', salary: 75000, status: 'Active' },
        { id: 'PMT-004', employee: 'Kimera Robert', email: 'kimera.robert@hospital.ug', joiningDate: '2022-01-10', role: 'Lab Technician', salary: 55000, status: 'Active' },
        { id: 'PMT-005', employee: 'Lisa Patel', email: 'lisa.p@hospital.ug', joiningDate: '2018-08-05', role: 'Administrator', salary: 65000, status: 'Inactive' },
        { id: 'PMT-006', employee: 'Okello James', email: 'james.w@hospital.ug', joiningDate: '2023-02-14', role: 'Pharmacist', salary: 60000, status: 'Active' },
    ];

    let currentSearch = '';
    let currentFilters = { employee: '', role: '', date: '', status: '' };

    // ========== Toast ==========
    function showToast(message, isError = false) {
        const existing = document.querySelector('.toast-message');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.className = `toast-message ${isError ? 'error' : ''}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // ========== Format Currency ==========
    function formatCurrency(amount) {
        return '$' + amount.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
    }

    // ========== Populate Filter Dropdowns ==========
    function populateFilterDropdowns() {
        const employeeSelect = document.getElementById('filterEmployee');
        const roleSelect = document.getElementById('filterRole');
        const employees = [...new Set(payrollData.map(p => p.employee))];
        const roles = [...new Set(payrollData.map(p => p.role))];
        employeeSelect.innerHTML = '<option value="">Please select</option>';
        employees.forEach(emp => { employeeSelect.innerHTML += `<option value="${emp}">${emp}</option>`; });
        roleSelect.innerHTML = '<option value="">Please select</option>';
        roles.forEach(role => { roleSelect.innerHTML += `<option value="${role}">${role}</option>`; });
    }

    // ========== Update Filters UI ==========
    function updateFiltersUI() {
        const container = document.getElementById('activeFiltersContainer');
        let chips = [];
        if (currentSearch) chips.push(`<div class="inline-flex items-center gap-1 rounded-full bg-gray-100 border border-gray-200 px-3 py-1 text-xs font-medium text-gray-700 shadow-sm">Search: ${currentSearch}<button class="ml-1 remove-filter text-gray-400 hover:text-gray-700 transition-colors" data-type="search">✕</button></div>`);
        if (currentFilters.employee) chips.push(`<div class="inline-flex items-center gap-1 rounded-full bg-gray-100 border border-gray-200 px-3 py-1 text-xs font-medium text-gray-700 shadow-sm">Employee: ${currentFilters.employee}<button class="ml-1 remove-filter text-gray-400 hover:text-gray-700 transition-colors" data-type="employee">✕</button></div>`);
        if (currentFilters.role) chips.push(`<div class="inline-flex items-center gap-1 rounded-full bg-gray-100 border border-gray-200 px-3 py-1 text-xs font-medium text-gray-700 shadow-sm">Role: ${currentFilters.role}<button class="ml-1 remove-filter text-gray-400 hover:text-gray-700 transition-colors" data-type="role">✕</button></div>`);
        if (currentFilters.date) chips.push(`<div class="inline-flex items-center gap-1 rounded-full bg-gray-100 border border-gray-200 px-3 py-1 text-xs font-medium text-gray-700 shadow-sm">Date: ${currentFilters.date}<button class="ml-1 remove-filter text-gray-400 hover:text-gray-700 transition-colors" data-type="date">✕</button></div>`);
        if (currentFilters.status) chips.push(`<div class="inline-flex items-center gap-1 rounded-full bg-gray-100 border border-gray-200 px-3 py-1 text-xs font-medium text-gray-700 shadow-sm">Status: ${currentFilters.status}<button class="ml-1 remove-filter text-gray-400 hover:text-gray-700 transition-colors" data-type="status">✕</button></div>`);
        container.innerHTML = chips.join('');
        document.querySelectorAll('.remove-filter').forEach(btn => {
            btn.addEventListener('click', (e) => {
                const type = btn.dataset.type;
                if (type === 'search') { currentSearch = ''; document.getElementById('searchInput').value = ''; }
                if (type === 'employee') { currentFilters.employee = ''; document.getElementById('filterEmployee').value = ''; }
                if (type === 'role') { currentFilters.role = ''; document.getElementById('filterRole').value = ''; }
                if (type === 'date') { currentFilters.date = ''; document.getElementById('filterDate').value = ''; }
                if (type === 'status') { currentFilters.status = ''; document.getElementById('filterStatus').value = ''; }
                updateFiltersUI();
                renderTable();
            });
        });
    }

    // ========== Render Table ==========
    function renderTable() {
        let filtered = payrollData.filter(p => {
            if (currentSearch && !p.employee.toLowerCase().includes(currentSearch.toLowerCase()) && !p.email.toLowerCase().includes(currentSearch.toLowerCase()) && !p.id.toLowerCase().includes(currentSearch.toLowerCase())) return false;
            if (currentFilters.employee && p.employee !== currentFilters.employee) return false;
            if (currentFilters.role && p.role !== currentFilters.role) return false;
            if (currentFilters.date && p.joiningDate !== currentFilters.date) return false;
            if (currentFilters.status && p.status !== currentFilters.status) return false;
            return true;
        });
        const container = document.getElementById('tableContainer');
        if (filtered.length === 0) {
            container.innerHTML = `<div class="flex flex-col items-center py-10 text-gray-500"><div class="rounded-full bg-gray-100 p-3"><svg class="h-6 w-6 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg></div><h3 class="text-lg font-semibold mt-2 text-gray-900">No payroll entries found</h3><p class="text-sm">Try adjusting your filters or search.</p><button id="resetFiltersEmpty" class="mt-3 border border-gray-300 bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 rounded-md text-sm font-medium shadow-sm transition-colors text-gray-700">Reset filters</button></div>`;
            document.getElementById('resetFiltersEmpty')?.addEventListener('click', resetAllFilters);
            return;
        }
        let html = `<table class="w-full caption-bottom text-sm whitespace-nowrap"><thead class="border-b bg-gray-50"><tr><th class="p-4 text-left font-semibold text-gray-700">Employee</th><th class="p-4 text-left font-semibold text-gray-700">Email</th><th class="p-4 text-left font-semibold text-gray-700">Joining Date</th><th class="p-4 text-left font-semibold text-gray-700">Role</th><th class="p-4 text-left font-semibold text-gray-700">Salary</th><th class="p-4 text-left font-semibold text-gray-700">Status</th><th class="p-4 text-right font-semibold text-gray-700">Actions</th></tr></thead><tbody>`;
        filtered.forEach(p => {
            html += `<tr class="border-b transition-colors hover:bg-muted/50">
                <td class="p-4"><div class="flex items-center gap-3"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span><span class="font-medium text-gray-900">${p.employee}</span></div></td>
                <td class="p-4 text-gray-600">${p.email}</td>
                <td class="p-4 text-gray-600">${p.joiningDate}</td>
                <td class="p-4 text-gray-600">${p.role}</td>
                <td class="p-4 font-medium text-gray-900">${formatCurrency(p.salary)}</td>
                <td class="p-4"><span class="px-2.5 py-1 rounded-full text-xs font-medium ${p.status === 'Active' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-yellow-100 text-yellow-800 border border-yellow-200'}">${p.status}</span></td>
                <td class="p-4 text-right"><button class="action-menu-btn w-8 h-8 rounded-full hover:bg-gray-200 flex items-center justify-center ml-auto transition-colors" data-id="${p.id}"><svg class="h-4 w-4 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg></button></td>
            </tr>`;
        });
        html += `</tbody></table>`;
        container.innerHTML = html;
        document.querySelectorAll('.action-menu-btn').forEach(btn => {
            btn.addEventListener('click', (e) => { e.stopPropagation(); showActionMenu(btn, btn.dataset.id); });
        });
    }

    // ========== Action Menu ==========
    let activeActionMenu = null;

    function closeActionMenu() {
        if (activeActionMenu) { activeActionMenu.remove(); activeActionMenu = null; }
    }

    function showActionMenu(btn, payrollId) {
        closeActionMenu();
        const entry = payrollData.find(p => p.id === payrollId);
        if (!entry) return;
        const rect = btn.getBoundingClientRect();
        const menu = document.createElement('div');
        menu.className = 'action-menu';
        let left = rect.left;
        let top = rect.bottom + 6;
        const menuWidth = 180;
        const menuHeight = 150;
        if (left + menuWidth > window.innerWidth) left = window.innerWidth - menuWidth - 10;
        if (left < 10) left = 10;
        if (top + menuHeight > window.innerHeight) top = rect.top - menuHeight - 6;
        if (top < 10) top = 10;
        menu.style.top = `${top}px`;
        menu.style.left = `${left}px`;
        menu.innerHTML = `<div class="action-menu-header">Payroll Actions</div><button data-action="slip" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1Z"></path><path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"></path><path d="M12 17.5v-11"></path></svg>Generate Slip</button><button data-action="edit" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>Edit</button><div class="action-divider"></div><button data-action="delete" class="action-item text-red"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>Delete</button>`;
        document.body.appendChild(menu);
        activeActionMenu = menu;
        const closeHandler = (e) => { if (!menu.contains(e.target) && e.target !== btn) { closeActionMenu(); document.removeEventListener('click', closeHandler); } };
        setTimeout(() => document.addEventListener('click', closeHandler), 10);

        // Generate Slip - navigate to payslip page
        menu.querySelector('[data-action="slip"]')?.addEventListener('click', () => {
            closeActionMenu();
            window.location.href = `payslip.html?id=${entry.id}`;
        });

        // Edit - open the edit modal
        menu.querySelector('[data-action="edit"]')?.addEventListener('click', () => {
            closeActionMenu();
            openEditPayrollModal(entry);
        });

        // Delete - open delete confirmation
        menu.querySelector('[data-action="delete"]')?.addEventListener('click', () => {
            closeActionMenu();
            openDeleteModal(entry);
        });
    }

    // ========== Delete Modal ==========
    let pendingDeleteEntry = null;

    function openDeleteModal(entry) {
        pendingDeleteEntry = entry;
        document.getElementById('deleteConfirmModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteConfirmModal').classList.add('hidden');
        pendingDeleteEntry = null;
    }

    function confirmDelete() {
        if (pendingDeleteEntry) {
            payrollData = payrollData.filter(p => p.id !== pendingDeleteEntry.id);
            populateFilterDropdowns();
            renderTable();
            showToast(`${pendingDeleteEntry.employee}'s payroll entry has been deleted`);
            closeDeleteModal();
        }
    }

    document.getElementById('deleteModalCancel')?.addEventListener('click', closeDeleteModal);
    document.getElementById('deleteModalConfirm')?.addEventListener('click', confirmDelete);
    document.getElementById('deleteConfirmModal')?.addEventListener('click', (e) => { if (e.target === document.getElementById('deleteConfirmModal')) closeDeleteModal(); });

    // ========== Filter Popover ==========
    const filterBtn = document.getElementById('filterButton');
    const filterPopover = document.getElementById('filterPopover');
    filterBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        const rect = filterBtn.getBoundingClientRect();
        filterPopover.style.top = `${rect.bottom + 8}px`;
        if (window.innerWidth < 640) { filterPopover.style.left = '16px'; filterPopover.style.width = 'calc(100% - 32px)'; }
        else { filterPopover.style.left = 'auto'; filterPopover.style.right = `${window.innerWidth - rect.right}px`; }
        filterPopover.classList.toggle('hidden');
    });
    document.addEventListener('click', (e) => { if (!filterPopover.contains(e.target) && e.target !== filterBtn) filterPopover.classList.add('hidden'); });
    document.getElementById('applyFiltersBtn')?.addEventListener('click', () => {
        currentFilters.employee = document.getElementById('filterEmployee').value;
        currentFilters.role = document.getElementById('filterRole').value;
        currentFilters.date = document.getElementById('filterDate').value;
        currentFilters.status = document.getElementById('filterStatus').value;
        updateFiltersUI();
        renderTable();
        filterPopover.classList.add('hidden');
    });
    document.querySelectorAll('.reset-filter').forEach(btn => {
        btn.addEventListener('click', () => {
            const filterType = btn.dataset.filter;
            if (filterType === 'employee') { currentFilters.employee = ''; document.getElementById('filterEmployee').value = ''; }
            if (filterType === 'role') { currentFilters.role = ''; document.getElementById('filterRole').value = ''; }
            if (filterType === 'date') { currentFilters.date = ''; document.getElementById('filterDate').value = ''; }
            if (filterType === 'status') { currentFilters.status = ''; document.getElementById('filterStatus').value = ''; }
            updateFiltersUI();
            renderTable();
        });
    });
    document.getElementById('clearAllFilters')?.addEventListener('click', () => { resetAllFilters(); filterPopover.classList.add('hidden'); });

    function resetAllFilters() {
        currentSearch = '';
        currentFilters = { employee: '', role: '', date: '', status: '' };
        document.getElementById('searchInput').value = '';
        document.getElementById('filterEmployee').value = '';
        document.getElementById('filterRole').value = '';
        document.getElementById('filterDate').value = '';
        document.getElementById('filterStatus').value = '';
        updateFiltersUI();
        renderTable();
    }

    // ========== CSV Download ==========
    document.getElementById('downloadCsvBtn')?.addEventListener('click', () => {
        let filtered = payrollData.filter(p => {
            if (currentSearch && !p.employee.toLowerCase().includes(currentSearch.toLowerCase()) && !p.email.toLowerCase().includes(currentSearch.toLowerCase()) && !p.id.toLowerCase().includes(currentSearch.toLowerCase())) return false;
            if (currentFilters.employee && p.employee !== currentFilters.employee) return false;
            if (currentFilters.role && p.role !== currentFilters.role) return false;
            if (currentFilters.date && p.joiningDate !== currentFilters.date) return false;
            if (currentFilters.status && p.status !== currentFilters.status) return false;
            return true;
        });
        const headers = ["ID", "Employee", "Email", "Joining Date", "Role", "Salary", "Status"];
        const rows = filtered.map(p => [p.id, p.employee, p.email, p.joiningDate, p.role, p.salary, p.status]);
        const csvContent = [headers, ...rows].map(row => row.join(",")).join("\n");
        const blob = new Blob([csvContent], { type: "text/csv" });
        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = "payroll.csv";
        link.click();
        URL.revokeObjectURL(link.href);
        showToast("CSV exported successfully");
    });

    // ========== Search ==========
    document.getElementById('searchInput')?.addEventListener('input', (e) => { currentSearch = e.target.value; updateFiltersUI(); renderTable(); });

    // ========== ADD/EDIT PAYROLL MODALS ==========
    const staffList = [
        { name: 'Dr. Nakato Sarah', id: 'ST-001' },
        { name: 'Dr. Mwangi Peter', id: 'ST-002' },
        { name: 'Emily Rodriguez', id: 'ST-003' },
        { name: 'Kimera Robert', id: 'ST-004' },
        { name: 'Lisa Patel', id: 'ST-005' },
        { name: 'Okello James', id: 'ST-006' },
    ];

    let activeDialogOverlay = null;
    let activeDialogPopup = null;
    let selectedAddStaff = null;
    let selectedEditStaff = null;

    function closeAllDialogs() {
        if (activeDialogOverlay) { 
            activeDialogOverlay.remove(); 
            activeDialogOverlay = null; 
        }
        if (activeDialogPopup) {
            activeDialogPopup.classList.add('hidden');
            // Move modal back to body if it was appended elsewhere
            if (activeDialogPopup.parentElement !== document.body) {
                document.body.appendChild(activeDialogPopup);
            }
            activeDialogPopup = null;
        }
        document.querySelectorAll('.staff-select-content').forEach(d => d.classList.add('hidden'));
    }

    function createDialogOverlay() {
        const overlay = document.createElement('div');
        overlay.className = 'dialog-overlay';
        overlay.addEventListener('click', (e) => { if (e.target === overlay) closeAllDialogs(); });
        return overlay;
    }

    function populateStaffDropdown(contentEl, triggerEl, labelEl, callback) {
        contentEl.innerHTML = staffList.map(s => `<div class="staff-select-item" data-name="${s.name}" data-id="${s.id}">${s.name} (${s.id})</div>`).join('');
        contentEl.querySelectorAll('.staff-select-item').forEach(item => {
            item.addEventListener('click', () => {
                const name = item.dataset.name;
                const id = item.dataset.id;
                labelEl.textContent = `${name} (${id})`;
                contentEl.classList.add('hidden');
                if (callback) callback({ name, id });
            });
        });
    }

    document.addEventListener('click', (e) => {
        const addDropdown = document.getElementById('addStaffDropdown');
        const editDropdown = document.getElementById('editStaffDropdown');
        if (addDropdown && !addDropdown.contains(e.target)) document.getElementById('addStaffContent')?.classList.add('hidden');
        if (editDropdown && !editDropdown.contains(e.target)) document.getElementById('editStaffContent')?.classList.add('hidden');
    });

// Toggle mobile money fields based on payment method
['add', 'edit'].forEach(prefix => {
    const paymentMethod = document.getElementById(prefix + 'PaymentMethod');
    const mobileFields = document.getElementById(prefix + 'MobileMoneyFields');
    
    if (paymentMethod && mobileFields) {
        paymentMethod.addEventListener('change', () => {
            if (paymentMethod.value === 'mobile') {
                mobileFields.style.display = 'grid';
            } else {
                mobileFields.style.display = 'none';
            }
        });
    }
});

function calculateNetSalary(prefix) {
    const earnings = [
        'BasicSalary', 'HouseAllowance', 'TransportAllowance', 
        'MedicalAllowance', 'ResponsibilityAllowance', 'OvertimePay', 'Bonus'
    ];
    const deductions = [
        'PAYE', 'NSSF', 'Pension', 'LoanRecovery', 
        'SalaryAdvance', 'SACCO', 'Absenteeism'
    ];
    
    let totalEarnings = 0, totalDeductions = 0;
    
    earnings.forEach(field => { 
        totalEarnings += parseFloat(document.getElementById(prefix + field)?.value) || 0; 
    });
    deductions.forEach(field => { 
        totalDeductions += parseFloat(document.getElementById(prefix + field)?.value) || 0; 
    });
    
    const netInput = document.getElementById(prefix + 'NetSalary');
    if (netInput) {
        const currency = document.getElementById(prefix + 'Currency')?.value || 'KES';
        const symbol = { UGX: 'USh', KES: 'KSh', TZS: 'TSh', RWF: 'RF', USD: '$' }[currency] || '';
        netInput.value = `${symbol} ${(totalEarnings - totalDeductions).toLocaleString()}`;
    }
}

['add', 'edit'].forEach(prefix => {
    document.querySelectorAll(`.${prefix}-earning, .${prefix}-deduction`).forEach(input => {
        input.addEventListener('input', () => calculateNetSalary(prefix));
    });
    // Also recalculate when currency changes
    document.getElementById(prefix + 'Currency')?.addEventListener('change', () => calculateNetSalary(prefix));
});

    function openAddPayrollModal() {
        closeAllDialogs();
        const overlay = createDialogOverlay();
        document.body.appendChild(overlay);
        activeDialogOverlay = overlay;
        const modal = document.getElementById('addPayrollModal');
        modal.classList.remove('hidden');
        // Append modal to overlay so it sits on top
        overlay.appendChild(modal);
        activeDialogPopup = modal;
        const contentEl = document.getElementById('addStaffContent');
        const triggerEl = document.getElementById('addStaffTrigger');
        const labelEl = document.getElementById('addStaffLabel');
        populateStaffDropdown(contentEl, triggerEl, labelEl, (staff) => { selectedAddStaff = staff; });
        triggerEl.onclick = (e) => { e.stopPropagation(); contentEl.classList.toggle('hidden'); };
        calculateNetSalary('add');
    }

    function openEditPayrollModal(entry) {
        closeAllDialogs();
        const overlay = createDialogOverlay();
        document.body.appendChild(overlay);
        activeDialogOverlay = overlay;
        const modal = document.getElementById('editPayrollModal');
        modal.classList.remove('hidden');
        // Append modal to overlay so it sits on top
        overlay.appendChild(modal);
        activeDialogPopup = modal;
        const contentEl = document.getElementById('editStaffContent');
        const triggerEl = document.getElementById('editStaffTrigger');
        const labelEl = document.getElementById('editStaffLabel');
        populateStaffDropdown(contentEl, triggerEl, labelEl, (staff) => { selectedEditStaff = staff; });
        triggerEl.onclick = (e) => { e.stopPropagation(); contentEl.classList.toggle('hidden'); };
        if (entry) {
            const staff = staffList.find(s => s.name === entry.employee);
            if (staff) { labelEl.textContent = `${staff.name} (${staff.id})`; selectedEditStaff = staff; }
        }
        calculateNetSalary('edit');
    }

    // ========== RADIX UI SELECT INITIALIZATION ==========
function initRadixSelect(wrapElement) {
    if (!wrapElement) return;
    
    const trigger = wrapElement.querySelector('.radix-select-trigger');
    const content = wrapElement.querySelector('.radix-select-content');
    const items = wrapElement.querySelectorAll('.radix-select-item');
    
    if (!trigger || !content) return;
    
    // Toggle dropdown
    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        // Close all other radix selects
        document.querySelectorAll('.radix-select-content').forEach(c => {
            if (c !== content) c.classList.add('hidden');
        });
        content.classList.toggle('hidden');
    });
    
    // Select item
    items.forEach(item => {
        item.addEventListener('click', (e) => {
            e.stopPropagation();
            const value = item.getAttribute('data-value');
            const label = item.childNodes[0].textContent.trim();
            
            // Update trigger text
            trigger.querySelector('span').textContent = label;
            trigger.setAttribute('data-value', value);
            
            // Update selected state
            items.forEach(i => i.setAttribute('data-selected', 'false'));
            item.setAttribute('data-selected', 'true');
            
            // Close dropdown
            content.classList.add('hidden');
            
            // Trigger change event
            const event = new CustomEvent('radix-change', { 
                detail: { value, label, selectId: wrapElement.id } 
            });
            wrapElement.dispatchEvent(event);
        });
    });
    
    // Close on outside click
    document.addEventListener('click', (e) => {
        if (!wrapElement.contains(e.target)) {
            content.classList.add('hidden');
        }
    });
}

// Initialize all Radix selects
function initAllRadixSelects() {
    document.querySelectorAll('.radix-select-wrap').forEach(wrap => {
        initRadixSelect(wrap);
    });
}

// Call after modals are opened
function openAddPayrollModal() {
    closeAllDialogs();
    const overlay = createDialogOverlay();
    document.body.appendChild(overlay);
    activeDialogOverlay = overlay;
    const modal = document.getElementById('addPayrollModal');
    modal.classList.remove('hidden');
    overlay.appendChild(modal);
    activeDialogPopup = modal;
    
    const contentEl = document.getElementById('addStaffContent');
    const triggerEl = document.getElementById('addStaffTrigger');
    const labelEl = document.getElementById('addStaffLabel');
    populateStaffDropdown(contentEl, triggerEl, labelEl, (staff) => { selectedAddStaff = staff; });
    triggerEl.onclick = (e) => { e.stopPropagation(); contentEl.classList.toggle('hidden'); };
    
    // Initialize Radix selects
    setTimeout(() => initAllRadixSelects(), 100);
    
    // Listen for payment method changes
    const paymentMethodWrap = document.getElementById('addPaymentMethodSelect');
    if (paymentMethodWrap) {
        paymentMethodWrap.addEventListener('radix-change', (e) => {
            const mobileFields = document.getElementById('addMobileMoneyFields');
            if (mobileFields) {
                mobileFields.style.display = e.detail.value === 'mobile' ? 'grid' : 'none';
                if (e.detail.value === 'mobile') {
                    setTimeout(() => {
                        const mobileWrap = document.getElementById('addMobileProviderSelect');
                        if (mobileWrap) initRadixSelect(mobileWrap);
                    }, 50);
                }
            }
        });
    }
    
    // Listen for currency changes
    const currencyWrap = document.getElementById('addCurrencySelect');
    if (currencyWrap) {
        currencyWrap.addEventListener('radix-change', () => calculateNetSalary('add'));
    }
    
    calculateNetSalary('add');
}

function openEditPayrollModal(entry) {
    closeAllDialogs();
    const overlay = createDialogOverlay();
    document.body.appendChild(overlay);
    activeDialogOverlay = overlay;
    const modal = document.getElementById('editPayrollModal');
    modal.classList.remove('hidden');
    overlay.appendChild(modal);
    activeDialogPopup = modal;
    
    const contentEl = document.getElementById('editStaffContent');
    const triggerEl = document.getElementById('editStaffTrigger');
    const labelEl = document.getElementById('editStaffLabel');
    populateStaffDropdown(contentEl, triggerEl, labelEl, (staff) => { selectedEditStaff = staff; });
    triggerEl.onclick = (e) => { e.stopPropagation(); contentEl.classList.toggle('hidden'); };
    
    if (entry) {
        const staff = staffList.find(s => s.name === entry.employee);
        if (staff) { labelEl.textContent = `${staff.name} (${staff.id})`; selectedEditStaff = staff; }
    }
    
    // Initialize Radix selects
    setTimeout(() => initAllRadixSelects(), 100);
    
    // Listen for payment method changes
    const paymentMethodWrap = document.getElementById('editPaymentMethodSelect');
    if (paymentMethodWrap) {
        paymentMethodWrap.addEventListener('radix-change', (e) => {
            const mobileFields = document.getElementById('editMobileMoneyFields');
            if (mobileFields) {
                mobileFields.style.display = e.detail.value === 'mobile' ? 'grid' : 'none';
                if (e.detail.value === 'mobile') {
                    setTimeout(() => {
                        const mobileWrap = document.getElementById('editMobileProviderSelect');
                        if (mobileWrap) initRadixSelect(mobileWrap);
                    }, 50);
                }
            }
        });
    }
    
    calculateNetSalary('edit');
}

// Get selected value from Radix select
function getRadixValue(wrapId) {
    const wrap = document.getElementById(wrapId);
    if (!wrap) return '';
    const trigger = wrap.querySelector('.radix-select-trigger');
    return trigger ? trigger.getAttribute('data-value') || '' : '';
}

    // Close buttons
    document.querySelectorAll('.cancel-dialog-btn').forEach(btn => btn.addEventListener('click', closeAllDialogs));
    document.getElementById('closeAddModalBtn')?.addEventListener('click', closeAllDialogs);
    document.getElementById('closeEditModalBtn')?.addEventListener('click', closeAllDialogs);

    // Form submits
    document.getElementById('addPayrollForm')?.addEventListener('submit', (e) => {
        e.preventDefault();
        if (!selectedAddStaff) { showToast('Please select a staff member', true); return; }
        showToast(`Payslip added for ${selectedAddStaff.name}`);
        closeAllDialogs();
        document.getElementById('addPayrollForm').reset();
        document.getElementById('addStaffLabel').textContent = 'Select staff';
        selectedAddStaff = null;
    });

    document.getElementById('editPayrollForm')?.addEventListener('submit', (e) => {
        e.preventDefault();
        if (!selectedEditStaff) { showToast('Please select a staff member', true); return; }
        showToast(`Payslip updated for ${selectedEditStaff.name}`);
        closeAllDialogs();
    });

    // Hook Add button
    document.getElementById('addPayrollBtn').addEventListener('click', openAddPayrollModal);

    // Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeAllDialogs();
            closeActionMenu();
            closeDeleteModal();
            filterPopover.classList.add('hidden');
        }
    });

    // ========== Initial Setup ==========
    populateFilterDropdowns();
    renderTable();
    updateFiltersUI();
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
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Survey Responses</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet" crossorigin="anonymous">
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
            max-width: 90vw;
            width: 100%;
            max-height: 85vh;
            overflow-y: auto;
        }
        body.dark .modal-content { background: #131212; border: 1px solid #333; }
        
        @keyframes modalSlideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        .toast-notification { animation: slideInRight 0.3s ease-out; position: fixed; bottom: 24px; right: 24px; z-index: 1100; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        
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
        
        /* Action Menu Styles */
        .action-menu {
            position: absolute;
            z-index: 50;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            min-width: 200px;
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
        
        .response-card {
            transition: all 0.2s ease;
        }
        .response-card:hover {
            border-color: #cbd5e1;
            background-color: #fafafa;
        }
        body.dark .response-card:hover {
            background-color: #1f1f1f;
        }
        
        /* Modal width fixes - add these to existing styles */
.modal-content {
    background: white;
    border-radius: 0.75rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    animation: modalSlideUp 0.2s ease-out;
    max-width: 90vw;
    width: 100%;
    max-height: 85vh;
    overflow-y: auto;
}

/* Specific modal width controls */
#viewDetailsModal .modal-content {
    max-width: 700px;
    width: 90%;
}

#deleteResponseModal .modal-content {
    max-width: 520px;
    width: 90%;
}

/* For very small screens */
@media (max-width: 640px) {
    #viewDetailsModal .modal-content {
        max-width: 95%;
        width: 95%;
        margin: 0 10px;
    }
    #deleteResponseModal .modal-content {
        max-width: 95%;
        width: 95%;
        margin: 0 10px;
    }
}

/* Better scrolling for long content */
.modal-content {
    max-height: 85vh;
    overflow-y: auto;
}

/* Optional: Add nice scrollbar for modal content */
.modal-content::-webkit-scrollbar {
    width: 6px;
}
.modal-content::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}
.modal-content::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}
body.dark .modal-content::-webkit-scrollbar-track {
    background: #2a2a2a;
}
body.dark .modal-content::-webkit-scrollbar-thumb {
    background: #555;
}

/* Enhanced Action Menu Styles */
.action-menu {
    position: fixed;
    z-index: 1000;
    min-width: 200px;
    background: white;
    border-radius: 0.75rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    padding: 0.375rem;
    animation: actionMenuIn 0.15s ease-out;
}

@keyframes actionMenuIn {
    from { opacity: 0; transform: scale(0.95) translateY(-4px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}

body.dark .action-menu {
    background: #1e293b;
    border-color: #334155;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.4), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
}

.action-header {
    padding: 0.5rem 0.75rem;
    font-size: 0.7rem;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid #f3f4f6;
    margin-bottom: 0.25rem;
}

body.dark .action-header {
    color: #6b7280;
    border-bottom-color: #374151;
}

.action-menu-item {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.1s ease;
    width: 100%;
    text-align: left;
    background: transparent;
    border: none;
    border-radius: 0.375rem;
    color: #374151;
    font-weight: 450;
}

.action-menu-item:hover {
    background-color: #f3f4f6;
    color: #111827;
}

body.dark .action-menu-item {
    color: #d1d5db;
}

body.dark .action-menu-item:hover {
    background-color: #334155;
    color: #f9fafb;
}

.action-menu-item svg {
    width: 1rem;
    height: 1rem;
    flex-shrink: 0;
    color: #6b7280;
}

.action-menu-item:hover svg {
    color: #374151;
}

body.dark .action-menu-item svg {
    color: #9ca3af;
}

body.dark .action-menu-item:hover svg {
    color: #e5e5e5;
}

.action-menu-separator {
    height: 1px;
    background-color: #f3f4f6;
    margin: 0.25rem 0.5rem;
}

body.dark .action-menu-separator {
    background-color: #374151;
}

.action-menu-item.text-red {
    color: #ef4444;
}

.action-menu-item.text-red:hover {
    background-color: #fef2f2;
    color: #dc2626;
}

.action-menu-item.text-red svg {
    color: #ef4444;
}

.action-menu-item.text-red:hover svg {
    color: #dc2626;
}

body.dark .action-menu-item.text-red {
    color: #f87171;
}

body.dark .action-menu-item.text-red:hover {
    background-color: #450a0a;
    color: #fca5a5;
}

body.dark .action-menu-item.text-red svg {
    color: #f87171;
}

body.dark .action-menu-item.text-red:hover svg {
    color: #fca5a5;
}

/* Enhanced Action Trigger Button (Three Dots) */
.action-trigger-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 0.375rem;
    border: 1px solid transparent;
    background: transparent;
    cursor: pointer;
    transition: all 0.15s ease;
}

.action-trigger-btn:hover {
    background-color: #f3f4f6;
    border-color: #e5e7eb;
}

body.dark .action-trigger-btn:hover {
    background-color: #374151;
    border-color: #4b5563;
}

.action-trigger-btn svg {
    width: 1rem;
    height: 1rem;
    color: #9ca3af;
    transition: color 0.15s ease;
}

.action-trigger-btn:hover svg {
    color: #6b7280;
}

body.dark .action-trigger-btn svg {
    color: #6b7280;
}

body.dark .action-trigger-btn:hover svg {
    color: #d1d5db;
}

/* Enhanced Table Row Hover */
#responsesTableBody tr {
    transition: background-color 0.15s ease;
}

#responsesTableBody tr:hover {
    background-color: #f9fafb;
}

body.dark #responsesTableBody tr:hover {
    background-color: #1f2937;
}

/* Enhanced Response Cards */
.response-card {
    transition: all 0.2s ease;
    border: 1px solid #e5e7eb;
}

.response-card:hover {
    border-color: #cbd5e1;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transform: translateY(-1px);
}

body.dark .response-card {
    border-color: #374151;
}

body.dark .response-card:hover {
    border-color: #4b5563;
    background-color: #1f2937;
}

/* View Details Button in Cards */
.view-details-btn {
    transition: all 0.15s ease;
}

.view-details-btn:hover {
    background-color: #f3f4f6;
    border-color: #cbd5e1;
}

body.dark .view-details-btn:hover {
    background-color: #374151;
    border-color: #4b5563;
}

/* Enhanced Delete Modal */
#deleteResponseModal .modal-content {
    border: 1px solid #fee2e2;
}

body.dark #deleteResponseModal .modal-content {
    border-color: #7f1d1d;
}

/* Toast Notification Enhancement */
.toast-notification {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    font-weight: 500;
}

/* Pagination Active State */
.pagination-btn.active {
    background-color: #6366f1 !important;
    color: white !important;
    border-color: #6366f1 !important;
    font-weight: 500;
}

.pagination-btn.active:hover {
    background-color: #4f46e5 !important;
}

/* Individual Pagination */
.individual-pagination-btn.active {
    background-color: #6366f1 !important;
    color: white !important;
    border-color: #6366f1 !important;
    font-weight: 500;
}

.individual-pagination-btn.active:hover {
    background-color: #4f46e5 !important;
}

/* Smooth tab transition */
.tab-trigger {
    transition: all 0.2s ease;
}

.tab-trigger:hover:not(.active) {
    color: #374151;
    background-color: rgba(255, 255, 255, 0.5);
}

body.dark .tab-trigger:hover:not(.active) {
    color: #e5e5e5;
    background-color: rgba(255, 255, 255, 0.05);
}

/* Export button hover */
#exportBtn {
    transition: all 0.15s ease;
}

#exportBtn:hover {
    background-color: #f3f4f6;
    border-color: #cbd5e1;
}

body.dark #exportBtn:hover {
    background-color: #374151;
    border-color: #4b5563;
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
            <div class=" mx-auto space-y-6">
                <!-- Header with back button -->
                <div class="flex items-center flex-wrap gap-2">
                    <a class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background size-10" href="survey-details.html">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">Patient Satisfaction Survey - Responses</h1>
                        <p class="text-gray-500">View and analyze anonymous patient feedback</p>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition">
                        <div class="font-medium">Total Responses</div>
                        <div class="text-2xl font-bold text-indigo-600 mt-1" id="totalResponses">128</div>
                        <div class="text-xs text-green-600 mt-1">+12 this week</div>
                    </div>
                    <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition">
                        <div class="font-medium">Average Satisfaction</div>
                        <div class="text-2xl font-bold text-amber-600 mt-1" id="avgSatisfaction">4.2</div>
                        <div class="flex items-center gap-0.5 mt-1">
                            <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
                            <span class="text-xs text-gray-500">out of 5</span>
                        </div>
                    </div>
                    <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition">
                        <div class="font-medium">Would Recommend</div>
                        <div class="text-2xl font-bold text-green-600 mt-1" id="recommendRate">84%</div>
                        <div class="text-xs text-gray-500 mt-1">of respondents</div>
                    </div>
                    <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition">
                        <div class="font-medium">Avg Wait Time</div>
                        <div class="text-2xl font-bold text-amber-600 mt-1" id="avgWaitTime">32</div>
                        <div class="text-xs text-gray-500 mt-1">minutes</div>
                    </div>
                </div>

                <!-- Tabs -->
                <div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1 text-gray-500">
                    <button type="button" data-tab="table" class="tab-trigger active inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all bg-white text-gray-900 shadow-sm">Table View</button>
                    <button type="button" data-tab="individual" class="tab-trigger inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all">Individual Responses</button>
                </div>

                <!-- Filters Bar (Table View) -->
                <div id="tableFilters" >
                    <div class="flex flex-wrap items-center gap-2">
                        <div class="relative flex-1 min-w-[200px]">
                            <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                            <input id="tableSearch" type="search" placeholder="Search responses..." class="pl-8 w-full h-10 rounded-md border border-gray-300 px-3 py-2 text-sm bg-white">
                        </div>
                        
                        <div class="relative">
                            <button id="deptFilterBtn" class="flex h-10 items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm w-[150px]">
                                <span id="deptFilterText">All Departments</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>
                            </button>
                            <div id="deptDropdown" class="hidden dropdown-content">
                                <div data-value="All" class="dropdown-item">All Departments</div>
                                <div data-value="Outpatient clinic" class="dropdown-item">Outpatient Clinic</div>
                                <div data-value="Immunization" class="dropdown-item">Immunization</div>
                                <div data-value="Endocrinology" class="dropdown-item">Endocrinology</div>
                                <div data-value="Maternity" class="dropdown-item">Maternity</div>
                                <div data-value="Orthopedics" class="dropdown-item">Orthopedics</div>
                                <div data-value="Pharmacy" class="dropdown-item">Pharmacy</div>
                                <div data-value="Dermatology" class="dropdown-item">Dermatology</div>
                                <div data-value="Dentistry" class="dropdown-item">Dentistry</div>
                                <div data-value="Pediatric" class="dropdown-item">Pediatric</div>
                            </div>
                        </div>
                        
                        <div class="relative">
                            <button id="ratingFilterBtn" class="flex h-10 items-center justify-between rounded-md border border-gray-300 bg-white px-3 py-2 text-sm w-[150px]">
                                <span id="ratingFilterText">All Ratings</span>
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m6 9 6 6 6-6"></path></svg>
                            </button>
                            <div id="ratingDropdown" class="hidden dropdown-content">
                                <div data-value="All" class="dropdown-item">All Ratings</div>
                                <div data-value="5" class="dropdown-item">5 Stars ★★★★★</div>
                                <div data-value="4" class="dropdown-item">4 Stars ★★★★☆</div>
                                <div data-value="3" class="dropdown-item">3 Stars ★★★☆☆</div>
                                <div data-value="2" class="dropdown-item">2 Stars ★★☆☆☆</div>
                                <div data-value="1" class="dropdown-item">1 Star ★☆☆☆☆</div>
                            </div>
                        </div>
                        
                        <div class="relative">
                            <button id="dateRangeBtn" class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-white h-10 px-4 text-sm w-[260px] justify-start">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 2v4M16 2v4M3 10h18"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect></svg>
                                <span id="dateRangeText">All Dates</span>
                            </button>
                            <div id="datePickerPopover" class="absolute z-50 mt-2 w-[280px] rounded-md border border-gray-200 bg-background  shadow-lg hidden">
                                <div class="p-4 space-y-4">
                                    <div><label class="text-sm font-medium text-gray-700 block mb-1">Start Date</label><input type="date" id="startDate" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                                    <div><label class="text-sm font-medium text-gray-700 block mb-1">End Date</label><input type="date" id="endDate" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                                    <div class="flex gap-2 pt-2"><button id="applyDateBtn" class="flex-1 rounded-md bg-primary text-white py-2 text-sm font-medium hover:bg-primary/90">Apply</button><button id="cancelDateBtn" class="flex-1 rounded-md border border-gray-300 bg-white py-2 text-sm font-medium hover:bg-gray-50">Cancel</button></div>
                                </div>
                            </div>
                        </div>
                        
                        <button id="clearFiltersBtn" class="border border-gray-300 bg-white hover:bg-gray-50 h-10 px-4 rounded-md text-sm">Clear Filters</button>
                        <button id="exportBtn" class="border border-gray-300 bg-white hover:bg-gray-50 h-10 px-4 rounded-md text-sm flex items-center gap-2">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                            Export
                        </button>
                    </div>
                </div>

                <!-- Table View Content -->
                <div id="tableView" class="rounded-lg border border-gray-200 bg-background shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium">Date</th>
                                    <th class="px-4 py-3 text-left font-medium">Department</th>
                                    <th class="px-4 py-3 text-left font-medium">Rating</th>
                                    <th class="px-4 py-3 text-left font-medium">Wait Time</th>
                                    <th class="px-4 py-3 text-left font-medium">Comment</th>
                                    <th class="px-4 py-3 text-left font-medium"></th>
                                </tr>
                            </thead>
                            <tbody id="responsesTableBody"></tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t flex justify-between items-center">
                        <div class="font-medium" id="paginationInfo">Showing 1-10 of 128 responses</div>
                        <div class="flex gap-1" id="paginationControls"></div>
                    </div>
                </div>

                <!-- Individual View Content (3 columns grid) -->
                <div id="individualView" class="hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="individualCardsContainer"></div>
                    <div class="mt-6 flex justify-between items-center">
                        <div class="font-medium" id="individualPaginationInfo">Showing 1-9 of 128 responses</div>
                        <div class="flex gap-1" id="individualPaginationControls"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- View Details Modal -->
    <div id="viewDetailsModal" class="modal-backdrop hidden">
        <div class="modal-content max-w-2xl w-full mx-4">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <h2 class="text-xl font-semibold">Response Details</h2>
                    <button id="closeDetailsModal" class="text-gray-400 hover:text-gray-600">✕</button>
                </div>
                <div id="detailsContent" class="space-y-4"></div>
                <div class="flex justify-end mt-6">
                    <button id="closeDetailsBtn" class="px-4 py-2 rounded-md border border-gray-300 text-sm font-medium hover:bg-gray-50">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteResponseModal" class="modal-backdrop hidden">
        <div class="modal-content max-w-lg w-full mx-4">
            <div class="p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="h-5 w-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    </div>
                    <h2 class="text-lg font-semibold">Delete Response?</h2>
                </div>
                <p class="text-sm text-gray-600 mb-6">This action will permanently delete this anonymous response. This cannot be undone.</p>
                <div class="flex justify-end gap-3">
                    <button id="cancelDeleteResponseBtn" class="px-4 py-2 rounded-md border border-gray-300 text-sm font-medium hover:bg-gray-100 transition">Cancel</button>
                    <button id="confirmDeleteResponseBtn" class="px-4 py-2 rounded-md bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition">Delete Response</button>
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
    // Sample responses data (anonymous)
let allResponses = [
    { id: 1, date: "2026-05-28", time: "14:30", satisfaction: 5, department: "Outpatient clinic", waitTime: 45, wouldRecommend: true, clean: true, staffFriendly: true, gotMedication: true, referred: false, returnCount: 0, ageRange: "30-50", gender: "Female", language: "English", cooperative: "Very cooperative", comment: "Very friendly staff, but waited 45 minutes", suggestion: "Add more nurses during peak hours" },
    { id: 2, date: "2026-05-28", time: "11:15", satisfaction: 4, department: "Immunization", waitTime: 20, wouldRecommend: true, clean: true, staffFriendly: true, gotMedication: true, referred: false, returnCount: 0, ageRange: "Under 30", gender: "Female", language: "Luganda", cooperative: "Very cooperative", comment: "Nurses were gentle with my baby", suggestion: "" },
    { id: 3, date: "2026-05-27", time: "09:45", satisfaction: 2, department: "Pharmacy", waitTime: 60, wouldRecommend: false, clean: false, staffFriendly: false, gotMedication: false, referred: false, returnCount: 2, ageRange: "Over 50", gender: "Male", language: "English", cooperative: "Neutral", comment: "Medicines were out of stock again", suggestion: "Government should supply more medicines" },
    { id: 4, date: "2026-05-27", time: "13:20", satisfaction: 5, department: "Endocrinology", waitTime: 15, wouldRecommend: true, clean: true, staffFriendly: true, gotMedication: true, referred: false, returnCount: 0, ageRange: "30-50", gender: "Female", language: "Luganda", cooperative: "Very cooperative", comment: "The midwife was very supportive", suggestion: "" },
    { id: 5, date: "2026-05-26", time: "16:00", satisfaction: 3, department: "Outpatient clinic", waitTime: 50, wouldRecommend: true, clean: true, staffFriendly: true, gotMedication: false, referred: true, returnCount: 1, ageRange: "Under 30", gender: "Male", language: "English", cooperative: "Cooperative", comment: "Long wait, but doctor was good", suggestion: "Reduce waiting time" },
    { id: 6, date: "2026-05-26", time: "10:30", satisfaction: 5, department: "Maternity", waitTime: 10, wouldRecommend: true, clean: true, staffFriendly: true, gotMedication: true, referred: false, returnCount: 0, ageRange: "30-50", gender: "Female", language: "Luganda", cooperative: "Very cooperative", comment: "I received excellent care during delivery", suggestion: "" },
    { id: 7, date: "2026-05-25", time: "14:00", satisfaction: 1, department: "Pharmacy", waitTime: 90, wouldRecommend: false, clean: false, staffFriendly: false, gotMedication: false, referred: false, returnCount: 3, ageRange: "Over 50", gender: "Male", language: "English", cooperative: "Uncooperative", comment: "The pharmacist was rude and medication was unavailable", suggestion: "Train staff on customer care" },
    { id: 8, date: "2026-05-25", time: "09:00", satisfaction: 4, department: "Orthopedics", waitTime: 25, wouldRecommend: true, clean: true, staffFriendly: true, gotMedication: true, referred: false, returnCount: 0, ageRange: "30-50", gender: "Female", language: "English", cooperative: "Very cooperative", comment: "Staff respected my privacy and were very professional", suggestion: "" },
    { id: 9, date: "2026-05-24", time: "15:45", satisfaction: 3, department: "Dentistry", waitTime: 55, wouldRecommend: false, clean: true, staffFriendly: false, gotMedication: true, referred: true, returnCount: 1, ageRange: "Under 30", gender: "Male", language: "English", cooperative: "Neutral", comment: "Doctor was rushed, didn't explain procedure properly", suggestion: "Doctors should explain procedures" },
    { id: 10, date: "2026-05-24", time: "11:00", satisfaction: 5, department: "Dermatology", waitTime: 5, wouldRecommend: true, clean: true, staffFriendly: true, gotMedication: true, referred: false, returnCount: 0, ageRange: "30-50", gender: "Female", language: "Luganda", cooperative: "Very cooperative", comment: "Very informative counseling session", suggestion: "" },
    { id: 11, date: "2026-05-23", time: "13:30", satisfaction: 4, department: "Pediatric", waitTime: 35, wouldRecommend: true, clean: true, staffFriendly: true, gotMedication: true, referred: false, returnCount: 0, ageRange: "30-50", gender: "Female", language: "English", cooperative: "Very cooperative", comment: "Doctor was great with my child", suggestion: "" },
    { id: 12, date: "2026-05-23", time: "10:00", satisfaction: 2, department: "Outpatient clinic", waitTime: 75, wouldRecommend: false, clean: false, staffFriendly: false, gotMedication: false, referred: false, returnCount: 2, ageRange: "Under 30", gender: "Male", language: "English", cooperative: "Neutral", comment: "Very disorganized, waited over an hour", suggestion: "Improve organization and reduce wait times" }
];

    let filteredResponses = [...allResponses];
    let currentPage = 1;
    let currentIndividualPage = 1;
    const itemsPerPage = 10;
    const individualItemsPerPage = 9;
    let activeTab = 'table';
    let currentActionMenu = null;
    let deleteResponseId = null;

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

    function closeActionMenu() {
        if (currentActionMenu) {
            currentActionMenu.remove();
            currentActionMenu = null;
        }
    }

    function showActionMenu(btn, responseId) {
        closeActionMenu();
        const rect = btn.getBoundingClientRect();
        const menu = document.createElement('div');
        menu.className = 'action-menu';
        let left = rect.left - 180;
        if (left < 10) left = 10;
        let top = rect.bottom + 4;
        if (top + 200 > window.innerHeight) top = rect.top - 200;
        menu.style.top = `${top}px`;
        menu.style.left = `${left}px`;
        
        menu.innerHTML = `
            <div class="action-header">Actions</div>
            <button data-action="view" class="action-menu-item">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                View Details
            </button>
            <div class="action-menu-separator"></div>
            <button data-action="delete" class="action-menu-item text-red">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                <span>Delete Response</span>
            </button>`;
        
        document.body.appendChild(menu);
        currentActionMenu = menu;
        
        // Action handlers
        menu.querySelector('[data-action="view"]').addEventListener('click', () => {
            closeActionMenu();
            showDetailsModal(responseId);
        });
        menu.querySelector('[data-action="delete"]').addEventListener('click', () => {
            closeActionMenu();
            showDeleteModal(responseId);
        });
        
        // Close on outside click
        setTimeout(() => {
            document.addEventListener('click', function handler(e) {
                if (!menu.contains(e.target) && e.target !== btn) {
                    closeActionMenu();
                    document.removeEventListener('click', handler);
                }
            });
        }, 10);
    }

    function updateStats() {
        const total = filteredResponses.length;
        const avgSat = total > 0 ? (filteredResponses.reduce((sum, r) => sum + r.satisfaction, 0) / total).toFixed(1) : 0;
        const recommendCount = filteredResponses.filter(r => r.wouldRecommend).length;
        const recommendRate = total > 0 ? Math.round((recommendCount / total) * 100) : 0;
        const avgWait = total > 0 ? Math.round(filteredResponses.reduce((sum, r) => sum + r.waitTime, 0) / total) : 0;
        document.getElementById('totalResponses').innerHTML = total;
        document.getElementById('avgSatisfaction').innerHTML = avgSat;
        document.getElementById('recommendRate').innerHTML = recommendRate + '%';
        document.getElementById('avgWaitTime').innerHTML = avgWait;
    }

    function applyFilters() {
        const searchTerm = document.getElementById('tableSearch')?.value.toLowerCase() || '';
        const dept = document.getElementById('deptFilterText').innerText;
        const ratingText = document.getElementById('ratingFilterText').innerText;
        const startDate = document.getElementById('startDate')?.value;
        const endDate = document.getElementById('endDate')?.value;
        
        filteredResponses = allResponses.filter(response => {
            if (searchTerm && !response.comment.toLowerCase().includes(searchTerm) && !response.department.toLowerCase().includes(searchTerm)) return false;
            if (dept !== 'All Departments' && response.department !== dept) return false;
            if (ratingText !== 'All Ratings' && response.satisfaction !== parseInt(ratingText)) return false;
            if (startDate && response.date < startDate) return false;
            if (endDate && response.date > endDate) return false;
            return true;
        });
        
        currentPage = 1;
        currentIndividualPage = 1;
        renderTable();
        renderIndividualCards();
        updateStats();
    }

    function clearFilters() {
        document.getElementById('tableSearch').value = '';
        document.getElementById('deptFilterText').innerText = 'All Departments';
        document.getElementById('ratingFilterText').innerText = 'All Ratings';
        document.getElementById('startDate').value = '';
        document.getElementById('endDate').value = '';
        document.getElementById('dateRangeText').innerText = 'All Dates';
        filteredResponses = [...allResponses];
        currentPage = 1;
        currentIndividualPage = 1;
        renderTable();
        renderIndividualCards();
        updateStats();
        showToast('Filters cleared');
    }

    function renderTable() {
        const startIndex = (currentPage - 1) * itemsPerPage;
        const pageResponses = filteredResponses.slice(startIndex, startIndex + itemsPerPage);
        const totalPages = Math.ceil(filteredResponses.length / itemsPerPage);
        const tbody = document.getElementById('responsesTableBody');
        
        if (pageResponses.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6" class="text-center py-8 text-gray-500">No responses found</td></tr>';
        } else {
            tbody.innerHTML = pageResponses.map(r => `
                <tr class="border-b hover:bg-gray-50 cursor-pointer" data-id="${r.id}">
                    <td class="px-4 py-3 text-xs">${r.date}</td>
                    <td class="px-4 py-3 text-sm">${escapeHtml(r.department)}</td>
                    <td class="px-4 py-3"><div class="flex items-center gap-0.5">${[1,2,3,4,5].map(s => `<svg class="h-4 w-4 ${s <= r.satisfaction ? 'text-yellow-500' : 'text-gray-300'}" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>`).join('')}</div></td>
                    <td class="px-4 py-3 text-sm"><span class="px-2 py-0.5 rounded-full ${r.waitTime <= 30 ? 'bg-green-100 text-green-700' : r.waitTime <= 60 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'}">${r.waitTime} min</span></td>
                    <td class="px-4 py-3 text-sm max-w-[200px] truncate">"${escapeHtml(r.comment.substring(0, 50))}${r.comment.length > 50 ? '...' : ''}"</td>
                    <td class="px-4 py-3">
                        <button class="action-trigger-btn p-2 rounded-md hover:bg-gray-100" data-id="${r.id}">
                            <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                        </button>
                    </td>
                </tr>
            `).join('');
        }
        
        document.getElementById('paginationInfo').innerHTML = `Showing ${startIndex + 1}-${Math.min(startIndex + itemsPerPage, filteredResponses.length)} of ${filteredResponses.length} responses`;
        const paginationContainer = document.getElementById('paginationControls');
        if (totalPages <= 1) paginationContainer.innerHTML = '';
        else paginationContainer.innerHTML = Array.from({length: totalPages}, (_, i) => `<button class="pagination-btn px-3 py-1 rounded-md border border-gray-300 text-sm ${i+1 === currentPage ? 'active bg-primary text-white border-indigo-600' : 'bg-white hover:bg-gray-50'}" data-page="${i+1}">${i+1}</button>`).join('');
        document.querySelectorAll('.pagination-btn').forEach(btn => btn.addEventListener('click', () => { currentPage = parseInt(btn.dataset.page); renderTable(); }));
        
        // Action trigger buttons (three dots)
        document.querySelectorAll('.action-trigger-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = parseInt(btn.dataset.id);
                showActionMenu(btn, id);
            });
        });
        
        // Row click to view details
        document.querySelectorAll('#responsesTableBody tr').forEach(row => {
            row.addEventListener('click', (e) => {
                if (e.target.closest('.action-trigger-btn') || e.target.closest('.action-menu')) return;
                const id = parseInt(row.dataset.id);
                showDetailsModal(id);
            });
        });
    }

    function renderIndividualCards() {
        const startIndex = (currentIndividualPage - 1) * individualItemsPerPage;
        const pageResponses = filteredResponses.slice(startIndex, startIndex + individualItemsPerPage);
        const totalPages = Math.ceil(filteredResponses.length / individualItemsPerPage);
        const container = document.getElementById('individualCardsContainer');
        
        if (pageResponses.length === 0) {
            container.innerHTML = '<div class="col-span-3 text-center py-8 text-gray-500">No responses found</div>';
        } else {
            container.innerHTML = pageResponses.map(r => `
                <div class="individual-card rounded-lg border border-gray-200 bg-white p-4 response-card">
                    <div class="flex justify-between items-start mb-3">
                        <div><span class="text-xs text-gray-500">${r.date}</span><span class="text-xs ml-2 px-2 py-0.5 rounded-full bg-gray-100">${escapeHtml(r.department)}</span></div>
                        <div class="flex items-center gap-2">
                            <div class="flex items-center gap-0.5">${[1,2,3,4,5].map(s => `<svg class="h-4 w-4 ${s <= r.satisfaction ? 'text-yellow-500' : 'text-gray-300'}" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>`).join('')}</div>
                            <button class="action-trigger-btn p-1 rounded-md hover:bg-gray-100" data-id="${r.id}">
                                <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                            </button>
                        </div>
                    </div>
                    <p class="font-medium text-gray-600 mb-3">"${escapeHtml(r.comment)}"</p>
                    <div class="flex flex-wrap gap-2 mb-3"><span class="text-xs px-2 py-0.5 rounded-full ${r.waitTime <= 30 ? 'bg-green-100 text-green-700' : r.waitTime <= 60 ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'}">Wait: ${r.waitTime} min</span><span class="text-xs px-2 py-0.5 rounded-full ${r.clean ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">Clean: ${r.clean ? 'Yes' : 'No'}</span><span class="text-xs px-2 py-0.5 rounded-full ${r.staffFriendly ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">Staff Friendly: ${r.staffFriendly ? 'Yes' : 'No'}</span></div>
                    <button class="view-details-btn inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium border border-gray-300 bg-background hover:bg-gray-50 h-10 px-4 py-2" data-id="${r.id}">View Details</button>
                </div>
            `).join('');
        }
        
        document.getElementById('individualPaginationInfo').innerHTML = `Showing ${startIndex + 1}-${Math.min(startIndex + individualItemsPerPage, filteredResponses.length)} of ${filteredResponses.length} responses`;
        const paginationContainer = document.getElementById('individualPaginationControls');
        if (totalPages <= 1) paginationContainer.innerHTML = '';
        else paginationContainer.innerHTML = Array.from({length: totalPages}, (_, i) => `<button class="individual-pagination-btn px-3 py-1 rounded-md border border-gray-300 text-sm ${i+1 === currentIndividualPage ? 'active bg-primary text-white border-indigo-600' : 'bg-white hover:bg-gray-50'}" data-page="${i+1}">${i+1}</button>`).join('');
        document.querySelectorAll('.individual-pagination-btn').forEach(btn => btn.addEventListener('click', () => { currentIndividualPage = parseInt(btn.dataset.page); renderIndividualCards(); }));
        
        // View Details buttons
        document.querySelectorAll('.view-details-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                showDetailsModal(parseInt(btn.dataset.id));
            });
        });
        
        // Action trigger buttons (three dots) in cards
        document.querySelectorAll('.individual-card .action-trigger-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const id = parseInt(btn.dataset.id);
                showActionMenu(btn, id);
            });
        });
    }

    function showDeleteModal(id) {
        deleteResponseId = id;
        document.getElementById('deleteResponseModal').classList.remove('hidden');
    }

    function showDetailsModal(id) {
        const response = allResponses.find(r => r.id === id);
        if (response) {
            const detailsHTML = `
                <div class="space-y-5">
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">📋 Submission Information</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div><label class="text-xs text-gray-500">Submission Date</label><p class="font-medium text-sm mt-0.5">${response.date} at ${response.time}</p></div>
                            <div><label class="text-xs text-gray-500">Department Visited</label><p class="font-medium text-sm mt-0.5">${escapeHtml(response.department)}</p></div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">⭐ Satisfaction & Experience</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div><label class="text-xs text-gray-500">Overall Satisfaction Rating</label><div class="flex items-center gap-0.5 mt-1">${[1,2,3,4,5].map(s => `<svg class="h-5 w-5 ${s <= response.satisfaction ? 'text-yellow-500' : 'text-gray-300'}" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>`).join('')}</div></div>
                            <div><label class="text-xs text-gray-500">Waiting Time</label><p class="font-medium text-sm mt-0.5">${response.waitTime} minutes</p></div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">🏥 Service Quality</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div><label class="text-xs text-gray-500">Staff Friendly & Professional?</label><p class="font-medium text-sm mt-0.5 ${response.staffFriendly ? 'text-green-600' : 'text-red-600'}">${response.staffFriendly ? '✅ Yes' : '❌ No'}</p></div>
                            <div><label class="text-xs text-gray-500">Clean Environment?</label><p class="font-medium text-sm mt-0.5 ${response.clean ? 'text-green-600' : 'text-red-600'}">${response.clean ? '✅ Yes' : '❌ No'}</p></div>
                            <div><label class="text-xs text-gray-500">Would Recommend?</label><p class="font-medium text-sm mt-0.5 ${response.wouldRecommend ? 'text-green-600' : 'text-red-600'}">${response.wouldRecommend ? '✅ Yes' : '❌ No'}</p></div>
                            <div><label class="text-xs text-gray-500">Got All Medication?</label><p class="font-medium text-sm mt-0.5">${response.gotMedication !== undefined ? (response.gotMedication ? '✅ Yes, all' : '⚠️ Some, not all') : 'Not answered'}</p></div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">📝 Additional Information</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div><label class="text-xs text-gray-500">Referred to Another Facility?</label><p class="font-medium text-sm mt-0.5">${response.referred !== undefined ? (response.referred ? 'Yes' : 'No') : 'Not answered'}</p></div>
                            <div><label class="text-xs text-gray-500">Times Returned for Follow-up</label><p class="font-medium text-sm mt-0.5">${response.returnCount !== undefined ? response.returnCount + ' times' : 'Not answered'}</p></div>
                            <div><label class="text-xs text-gray-500">Age Range</label><p class="font-medium text-sm mt-0.5">${response.ageRange || 'Not answered'}</p></div>
                            <div><label class="text-xs text-gray-500">Gender</label><p class="font-medium text-sm mt-0.5">${response.gender || 'Not answered'}</p></div>
                            <div><label class="text-xs text-gray-500">Language</label><p class="font-medium text-sm mt-0.5">${response.language || 'Not answered'}</p></div>
                            <div><label class="text-xs text-gray-500">Cooperative Level</label><p class="font-medium text-sm mt-0.5">${response.cooperative || 'Not answered'}</p></div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">💬 Detailed Feedback</h3>
                        <div><label class="text-xs text-gray-500">What could we improve?</label><p class="text-sm mt-1">"${escapeHtml(response.comment)}"</p></div>
                        ${response.suggestion ? `<div class="mt-3"><label class="text-xs text-gray-500">Suggestions</label><p class="text-sm mt-1">"${escapeHtml(response.suggestion)}"</p></div>` : ''}
                    </div>
                </div>`;
            document.getElementById('detailsContent').innerHTML = detailsHTML;
            document.getElementById('viewDetailsModal').classList.remove('hidden');
        }
    }

    // Modal event listeners
    document.getElementById('cancelDeleteResponseBtn')?.addEventListener('click', () => {
        document.getElementById('deleteResponseModal').classList.add('hidden');
        deleteResponseId = null;
    });
    
    document.getElementById('confirmDeleteResponseBtn')?.addEventListener('click', () => {
        if (deleteResponseId) {
            allResponses = allResponses.filter(r => r.id !== deleteResponseId);
            filteredResponses = filteredResponses.filter(r => r.id !== deleteResponseId);
            deleteResponseId = null;
            document.getElementById('deleteResponseModal').classList.add('hidden');
            renderTable();
            renderIndividualCards();
            updateStats();
            showToast('Response deleted');
        }
    });
    
    document.getElementById('closeDetailsModal')?.addEventListener('click', () => document.getElementById('viewDetailsModal').classList.add('hidden'));
    document.getElementById('closeDetailsBtn')?.addEventListener('click', () => document.getElementById('viewDetailsModal').classList.add('hidden'));
    document.getElementById('viewDetailsModal')?.addEventListener('click', (e) => {
        if (e.target === document.getElementById('viewDetailsModal')) document.getElementById('viewDetailsModal').classList.add('hidden');
    });
    document.getElementById('deleteResponseModal')?.addEventListener('click', (e) => {
        if (e.target === document.getElementById('deleteResponseModal')) {
            document.getElementById('deleteResponseModal').classList.add('hidden');
            deleteResponseId = null;
        }
    });

    // Close action menu on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeActionMenu();
            document.getElementById('viewDetailsModal')?.classList.add('hidden');
            document.getElementById('deleteResponseModal')?.classList.add('hidden');
        }
    });

    // Close action menu on scroll
    document.addEventListener('scroll', closeActionMenu, true);

    // Tab switching
    document.querySelectorAll('.tab-trigger').forEach(tab => {
        tab.addEventListener('click', () => {
            document.querySelectorAll('.tab-trigger').forEach(t => { t.classList.remove('active', 'bg-white', 'text-gray-900', 'shadow-sm'); });
            tab.classList.add('active', 'bg-white', 'text-gray-900', 'shadow-sm');
            activeTab = tab.dataset.tab;
            if (activeTab === 'table') {
                document.getElementById('tableView').classList.remove('hidden');
                document.getElementById('individualView').classList.add('hidden');
                document.getElementById('tableFilters').classList.remove('hidden');
                renderTable();
            } else {
                document.getElementById('tableView').classList.add('hidden');
                document.getElementById('individualView').classList.remove('hidden');
                document.getElementById('tableFilters').classList.add('hidden');
                renderIndividualCards();
            }
        });
    });

    // Dropdowns
    function setupDropdown(triggerId, dropdownId, textSpanId, onSelect) {
        const trigger = document.getElementById(triggerId), dropdown = document.getElementById(dropdownId), span = document.getElementById(textSpanId);
        if (!trigger || !dropdown) return;
        trigger.addEventListener('click', (e) => { e.stopPropagation(); dropdown.classList.toggle('hidden'); });
        dropdown.querySelectorAll('.dropdown-item').forEach(item => {
            item.addEventListener('click', () => {
                span.innerText = item.dataset.value;
                dropdown.classList.add('hidden');
                if (onSelect) onSelect();
            });
        });
    }
    setupDropdown('deptFilterBtn', 'deptDropdown', 'deptFilterText', () => applyFilters());
    setupDropdown('ratingFilterBtn', 'ratingDropdown', 'ratingFilterText', () => applyFilters());
    
    document.getElementById('tableSearch')?.addEventListener('input', () => applyFilters());
    document.getElementById('clearFiltersBtn')?.addEventListener('click', clearFilters);
    
    document.getElementById('exportBtn')?.addEventListener('click', () => {
        const data = JSON.stringify(filteredResponses, null, 2);
        const blob = new Blob([data], { type: 'application/json' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `survey-responses-${new Date().toISOString().split('T')[0]}.json`;
        a.click();
        URL.revokeObjectURL(url);
        showToast('Responses exported');
    });
    
    const dateRangeBtn = document.getElementById('dateRangeBtn'), datePicker = document.getElementById('datePickerPopover');
    dateRangeBtn?.addEventListener('click', (e) => { e.stopPropagation(); datePicker.classList.toggle('hidden'); });
    document.getElementById('applyDateBtn')?.addEventListener('click', () => {
        datePicker.classList.add('hidden');
        const start = document.getElementById('startDate').value, end = document.getElementById('endDate').value;
        if (start || end) document.getElementById('dateRangeText').innerText = start && end ? `${start} to ${end}` : start || end || 'All Dates';
        else document.getElementById('dateRangeText').innerText = 'All Dates';
        applyFilters();
    });
    document.getElementById('cancelDateBtn')?.addEventListener('click', () => datePicker.classList.add('hidden'));
    
    document.addEventListener('click', (e) => {
        if (!dateRangeBtn?.contains(e.target) && !datePicker?.contains(e.target)) datePicker?.classList.add('hidden');
        document.querySelectorAll('.dropdown-content').forEach(d => d.classList.add('hidden'));
        // Don't close action menu here - it has its own handler
    });
    
    renderTable();
    updateStats();
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
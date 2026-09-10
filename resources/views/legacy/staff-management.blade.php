<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Staff Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <style>

        * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .rounded-lg.border { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted { background-color: #262626 !important; }
        body.dark .text-muted-foreground { color: #a1a1aa !important; }
        body.dark .border-gray-200 { border-color: #404040 !important; }
        body.dark .bg-gray-50 { background-color: #0f0f0f !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        body.dark ::-webkit-scrollbar-track { background: #2a2a2a; }
        body.dark ::-webkit-scrollbar-thumb { background: #555; }
        
        /* Tab Panel visibility */
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }
        
        /* Tab button active state */
        .tab-btn[data-state="active"] { 
            background: white; 
            color: #1f2937; 
            box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); 
        }
        body.dark .tab-btn[data-state="active"] { 
            background: #131212; 
            color: #e5e5e5; 
        }
        .tab-btn[data-state="inactive"] { 
            background: transparent; 
            color: #6b7280; 
        }
        
        /* Dropdown Menu Styles - Matching examples */
        .dropdown-menu {
            position: fixed;
            z-index: 100;
            background-color: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            min-width: 200px;
            animation: fadeIn 0.15s ease-out;
        }
        body.dark .dropdown-menu { background-color: #2a2a2a; border-color: #404040; }
        .dropdown-item {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background 0.1s;
        }
        .dropdown-item:hover { background-color: #f3f4f6; }
        body.dark .dropdown-item:hover { background-color: #3f3f46; }
        .dropdown-divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 0.25rem 0;
        }
        body.dark .dropdown-divider { background-color: #404040; }
        .dropdown-header {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 0.25rem;
        }
        body.dark .dropdown-header { border-bottom-color: #404040; color: #9ca3af; }
        .text-red { color: #ef4444; }
        .text-red:hover { background-color: #fee2e2; }
        body.dark .text-red:hover { background-color: rgba(239, 68, 68, 0.1); }
        
        /* Filter Section */
        .filter-section {
            padding: 0.5rem 0.75rem;
        }
        .filter-label {
            font-size: 0.75rem;
            font-weight: 500;
            color: #6b7280;
            margin-bottom: 0.25rem;
            display: block;
        }
        .filter-select {
            width: 100%;
            height: 32px;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            background-color: white;
            padding: 0 0.5rem;
            font-size: 0.875rem;
            cursor: pointer;
        }
        body.dark .filter-select { background-color: #131212; border-color: #404040; color: #e5e5e5; }
        
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-4px); } to { opacity: 1; transform: translateY(0); } }
        
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
        
        .search-input:focus { border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.1); }

        /* modals added */
        /* Confirmation Modal Styles */
.confirm-modal-overlay {
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

.confirm-modal-container {
    background: white;
    border-radius: 0.75rem;
    width: 100%;
    max-width: 500px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    animation: modalSlideUp 0.2s ease;
    overflow: hidden;
}

body.dark .confirm-modal-container {
    background: #1e1e1e;
    border: 1px solid #333;
}

.confirm-modal-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

body.dark .confirm-modal-header {
    border-bottom-color: #333;
}

.confirm-modal-title {
    font-size: 1.125rem;
    font-weight: 600;
}

.confirm-modal-body {
    padding: 1.25rem 1.5rem;
}

.confirm-modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}

body.dark .confirm-modal-footer {
    border-top-color: #333;
}

.confirm-btn {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.15s;
    border: none;
}

.confirm-btn-cancel {
    background: transparent;
    border: 1px solid #d1d5db;
    color: #374151;
}

body.dark .confirm-btn-cancel {
    border-color: #404040;
    color: #e5e5e5;
}

.confirm-btn-cancel:hover {
    background: #f3f4f6;
}

body.dark .confirm-btn-cancel:hover {
    background: #2a2a2a;
}

.confirm-btn-danger {
    background: #ef4444;
    color: white;
}

.confirm-btn-danger:hover {
    background: #dc2626;
}

/* Fix modal overlays to cover sidebar */
#deleteModal, #deactivateModal {
    z-index: 10000 !important;
}

#assignWardModal.assign-modal-overlay {
    z-index: 10000 !important;
}

/* Modal backdrop should cover everything */
.modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgb(0 0 0 / 87%);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: none;
}

.modal-backdrop.show {
    display: block;
}
/* Assign Ward Modal */
.assign-modal-overlay {
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
.assign-modal-container {
    background: white;
    border-radius: 0.75rem;
    width: 100%;
    max-width: 520px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    animation: modalSlideUp 0.2s ease;
    overflow: hidden;
}
body.dark .assign-modal-container { background: #1e1e1e; border: 1px solid #333; }
.assign-modal-header {
    padding: 1rem 1.5rem 0rem;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}
body.dark .assign-modal-header { border-bottom-color: #333; }
.assign-modal-title { font-size: 1.125rem; font-weight: 600; }
.assign-modal-subtitle { font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem; }
.assign-modal-body { padding: 1.25rem 1.5rem; }
.assign-modal-footer {
    padding: 0rem  1.5rem 1rem;
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}
body.dark .assign-modal-footer { border-top-color: #333; }
.assign-form-group { margin-bottom: 1rem; }
.assign-form-group:last-child { margin-bottom: 0; }
.assign-form-group label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 0.375rem;
    color: #374151;
}
body.dark .assign-form-group label { color: #d1d5db; }
.assign-select {
    width: 100%;
    height: 40px;
    border-radius: 0.375rem;
    border: 1px solid #d1d5db;
    background: white;
    padding: 0 0.75rem;
    font-size: 0.875rem;
    cursor: pointer;
    outline: none;
}
.assign-select:focus { border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.1); }
body.dark .assign-select { background: #111; border-color: #404040; color: #e5e5e5; }
.assign-modal-close {
    background: transparent;
    border: none;
    font-size: 1.25rem;
    cursor: pointer;
    color: #9ca3af;
    padding: 0.25rem;
    border-radius: 0.25rem;
    line-height: 1;
}
.assign-modal-close:hover { color: #374151; background: #f3f4f6; }
body.dark .assign-modal-close:hover { color: #e5e5e5; background: #333; }
.assign-btn-cancel {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    background: transparent;
    border: 1px solid #d1d5db;
    color: #374151;
}
.assign-btn-cancel:hover { background: #f3f4f6; }
body.dark .assign-btn-cancel { border-color: #404040; color: #e5e5e5; }
body.dark .assign-btn-cancel:hover { background: #2a2a2a; }
.assign-btn-save {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
}
.assign-btn-save:hover { background: #4f46e5; }
.current-assignment {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 2px 8px;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    background: #eef2ff;
    color: #4338ca;
}
body.dark .current-assignment { background: #1e1b4b; color: #a5b4fc; }
.assignment-unassigned {
    color: #9ca3af;
    font-size: 0.75rem;
    font-style: italic;
}

/* Radix Select */
.radix-select { position: relative; width: 100%; }
.radix-select-trigger {
    display: flex; align-items: center; justify-content: space-between;
    width: 100%; padding: 0.5rem 0.75rem; font-size: 0.875rem;
    border-radius: 0.375rem; border: 1px solid #d1d5db;
    background-color: white; cursor: pointer; min-height: 40px;
    text-align: left; transition: all 0.15s;
}
body.dark .radix-select-trigger { background-color: #111; border-color: #404040; color: #e5e5e5; }
.radix-select-trigger:focus { border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.1); outline: none; }
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

.remove-filter-pill:hover {
    opacity: 0.7;
}

#applyFiltersBtn:hover {
    background: #4f46e5 !important;
}

.filter-radix .radix-select-trigger {
    min-height: 36px !important;
    font-size: 0.8125rem !important;
}

.filter-section {
    padding: 0.5rem 0.75rem;
}

.remove-filter-pill:hover {
    opacity: 0.7;
}

#applyFiltersBtn:hover {
    background: #4f46e5 !important;
}

.filter-radix .radix-select-trigger {
    min-height: 36px !important;
    font-size: 0.8125rem !important;
}

.filter-section {
    padding: 0.5rem 0.75rem;
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
                    <a id="rolesBtn" class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="roles-permissions.html">Roles &amp; Permissions</a>
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
            <div class="flex flex-col gap-6">
                <!-- Header -->
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">Staff Management</h2>
                        <p class="text-gray-500">Manage clinic staff, roles, and permissions</p>
                    </div>
                    <div class="flex items-center flex-wrap gap-2">
                        <a href="add-staff.html" class="bg-primary inline-flex items-center justify-center gap-2 rounded-md h-10 px-4 py-2 text-sm font-medium text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  class="mr-2 h-4 w-4"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" x2="19" y1="8" y2="14"></line><line x1="22" x2="16" y1="11" y2="11"></line></svg>
                            Add Staff
                        </a>
                        <button id="moreOptionsBtn" class="inline-flex items-center justify-center gap-2 rounded-md border px-4 py-2 text-sm  hover:bg-accent hover:text-accent-foreground h-10 ">
                            <svg class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg>
                            More Options
                            <svg class="ml-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                        </button>
                    </div>
                </div>

                <div class="md:grid max-md:space-y-6 gap-6 md:grid-cols-4">
                    <!-- Main Content Area -->
                    <div class="rounded-lg border bg-background shadow-sm md:col-span-3">
                        <div class="p-4 border-b">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <h2 class="text-xl font-semibold">Staff Directory</h2>
                                <div class="flex flex-col gap-2 sm:flex-row">
                                    <div class="relative">
                                        <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                                        <input id="searchInput" type="search" placeholder="Search staff..." class="search-input flex h-10 rounded-md border border-gray-300 bg-background px-3 py-2 text-sm pl-8 w-full sm:w-[300px] focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                    <button id="filterBtn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background  size-10 bg-background hover:bg-accent hover:text-accent-foreground h-10">
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-4">
                            <!-- Tabs -->
                            <div class="w-full">
                                <div role="tablist" class="flex flex-wrap items-center rounded-md bg-gray-100 p-1 text-gray-500 mb-4">
                                    <button type="button" data-tab="list" class="tab-btn inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all flex-1" data-state="active">List View</button>
                                    <button type="button" data-tab="grid" class="tab-btn inline-flex items-center justify-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all flex-1" data-state="inactive">Grid View</button>
                                </div>

                                <!-- List View Tab -->
                                <div id="tab-list" class="tab-panel active">
                                    <div class="rounded-md border overflow-x-auto">
                                        <table class="w-full text-sm whitespace-nowrap">
                                            <thead class="bg-gray-50">
                                                <tr class="border-b">
                                                    <th class="h-12 px-4 text-left">Name</th>
                                                    <th class="h-12 px-4 text-left">Role</th>
                                                    <th class="h-12 px-4 text-left hidden md:table-cell">Department</th>
                                                    <th class="h-12 px-4 text-left hidden md:table-cell">Contact</th>
                                                    <th class="h-12 px-4 text-left hidden md:table-cell">Joined</th>
                                                    <th class="h-12 px-4 text-left">Assigned Ward</th>
                                                    <th class="h-12 px-4 text-left">Status</th>
                                                    <th class="h-12 px-4 text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="listViewBody"></tbody>
                                        </table>
                                    </div>
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="text-gray-500" id="paginationInfo">Showing <strong>0</strong> to <strong>0</strong> of <strong>0</strong> staff members</div>
                                        <div class="flex items-center gap-2">
                                            <button id="prevPageBtn" class="inline-flex rounded-md border px-3 py-1 text-sm  hover:bg-accent hover:text-accent-foreground h-10 disabled:opacity-50 disabled:cursor-not-allowed" disabled>Previous</button>
                                            <button id="nextPageBtn" class="inline-flex rounded-md border px-3 py-1 text-sm  hover:bg-accent hover:text-accent-foreground h-10">Next</button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Grid View Tab -->
                                <div id="tab-grid" class="tab-panel">
                                    <div id="gridViewBody" class="grid gap-4 sm:grid-cols-2 lg:grid-cols-2"></div>
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="text-gray-500" id="gridPaginationInfo">Showing <strong>0</strong> to <strong>0</strong> of <strong>0</strong> staff members</div>
                                        <div class="flex items-center gap-2">
                                            <button id="gridPrevPageBtn" class="inline-flex rounded-md border px-3 py-1 text-sm  hover:bg-accent hover:text-accent-foreground h-10 disabled:opacity-50 disabled:cursor-not-allowed" disabled>Previous</button>
                                            <button id="gridNextPageBtn" class="inline-flex rounded-md border px-3 py-1 text-sm  hover:bg-accent hover:text-accent-foreground h-10">Next</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Stats -->
                    <div class="flex flex-col gap-6">
                        <div class="rounded-lg border bg-background shadow-sm">
                            <div class="p-4 flex items-center justify-between">
                                <h2 class="text-lg font-semibold">Staff Overview</h2>
                                <svg class="h-8 w-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                            </div>
                            <div class="p-4 pt-0">
                                <div class="flex items-center justify-between">
                                    <div class="flex flex-col">
                                        <span class="text-3xl font-bold" id="totalStaff">63</span>
                                        <span class="text-xs text-gray-500">Total Staff</span>
                                    </div>
                                </div>
                                <div class="mt-4 space-y-2">
                                    <div class="flex items-center justify-between text-sm"><span>Active</span><div class="flex items-center gap-2"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-800" id="activeCount">52</span><span class="text-xs text-gray-500">83%</span></div></div>
                                    <div class="flex items-center justify-between text-sm"><span>On Leave</span><div class="flex items-center gap-2"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold bg-yellow-100 text-yellow-800" id="onLeaveCount">8</span><span class="text-xs text-gray-500">13%</span></div></div>
                                    <div class="flex items-center justify-between text-sm"><span>Inactive</span><div class="flex items-center gap-2"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold bg-gray-100 text-gray-800" id="inactiveCount">3</span><span class="text-xs text-gray-500">4%</span></div></div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg border bg-background shadow-sm">
                            <div class="p-4"><h2 class="text-lg font-semibold mb-2">Departments</h2></div>
                            <div class="p-4 pt-0">
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2"><div class="h-3 w-3 rounded-full bg-blue-500"></div><div class="flex flex-1 items-center justify-between"><span class="text-sm">Medical</span><span class="text-sm font-medium">12</span></div></div>
                                    <div class="flex items-center gap-2"><div class="h-3 w-3 rounded-full bg-green-500"></div><div class="flex flex-1 items-center justify-between"><span class="text-sm">Nursing</span><span class="text-sm font-medium">18</span></div></div>
                                    <div class="flex items-center gap-2"><div class="h-3 w-3 rounded-full bg-purple-500"></div><div class="flex flex-1 items-center justify-between"><span class="text-sm">Administration</span><span class="text-sm font-medium">8</span></div></div>
                                    <div class="flex items-center gap-2"><div class="h-3 w-3 rounded-full bg-amber-500"></div><div class="flex flex-1 items-center justify-between"><span class="text-sm">Laboratory</span><span class="text-sm font-medium">5</span></div></div>
                                    <div class="flex items-center gap-2"><div class="h-3 w-3 rounded-full bg-red-500"></div><div class="flex flex-1 items-center justify-between"><span class="text-sm">Pharmacy</span><span class="text-sm font-medium">4</span></div></div>
                                    <div class="flex items-center gap-2"><div class="h-3 w-3 rounded-full bg-indigo-500"></div><div class="flex flex-1 items-center justify-between"><span class="text-sm">Radiology</span><span class="text-sm font-medium">3</span></div></div>
                                    <div class="flex items-center gap-2"><div class="h-3 w-3 rounded-full bg-pink-500"></div><div class="flex flex-1 items-center justify-between"><span class="text-sm">Therapy</span><span class="text-sm font-medium">6</span></div></div>
                                    <div class="flex items-center gap-2"><div class="h-3 w-3 rounded-full bg-cyan-500"></div><div class="flex flex-1 items-center justify-between"><span class="text-sm">Support</span><span class="text-sm font-medium">7</span></div></div>
                                </div>
                                <div class="mt-4 flex justify-center">
                                    <a href="departments.html" class="inline-flex items-center rounded-md border px-3 py-2 w-full justify-center text-sm  hover:bg-accent hover:text-accent-foreground h-10">Manage Departments</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

<!-- Delete Confirmation Modal -->
<div role="alertdialog" id="deleteModal" aria-describedby="deleteModalDesc" aria-labelledby="deleteModalTitle" data-state="open" class="fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-background p-6 shadow-lg duration-200 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[state=closed]:slide-out-to-left-1/2 data-[state=closed]:slide-out-to-top-[48%] data-[state=open]:slide-in-from-left-1/2 data-[state=open]:slide-in-from-top-[48%] sm:rounded-lg" style="display: none; pointer-events: auto;">
    <div class="flex flex-col space-y-2 text-center sm:text-left">
        <h2 id="deleteModalTitle" class="text-lg font-semibold">Are you sure you want to Delete this staff member?</h2>
        <p id="deleteModalDesc" class="text-sm text-muted-foreground">This action will permanently delete the staff member's record from the system. This action cannot be undone and will remove all associated data including schedules, permissions and attendance records.</p>
    </div>
    <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
        <button type="button" class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 mt-2 sm:mt-0" onclick="closeDeleteModal()">Cancel</button>
        <button type="button" id="confirmDeleteBtn" class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 h-10 px-4 py-2 bg-red-500 text-neutral-50 hover:bg-red-700">Delete</button>
    </div>
</div>

<!-- Deactivate Confirmation Modal -->
<div role="alertdialog" id="deactivateModal" aria-describedby="deactivateModalDesc" aria-labelledby="deactivateModalTitle" data-state="open" class="fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-background p-6 shadow-lg duration-200 data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[state=closed]:slide-out-to-left-1/2 data-[state=closed]:slide-out-to-top-[48%] data-[state=open]:slide-in-from-left-1/2 data-[state=open]:slide-in-from-top-[48%] sm:rounded-lg" style="display: none; pointer-events: auto;">
    <div class="flex flex-col space-y-2 text-center sm:text-left">
        <h2 id="deactivateModalTitle" class="text-lg font-semibold">Are you sure you want to Deactivate this staff member?</h2>
        <p id="deactivateModalDesc" class="text-sm text-muted-foreground">This action will remove the staff member from active status and they will no longer have access to the system. You can reactivate them later if needed.</p>
    </div>
    <div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">
        <button type="button" class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 mt-2 sm:mt-0" onclick="closeDeactivateModal()">Cancel</button>
        <button type="button" id="confirmDeactivateBtn" class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 h-10 px-4 py-2 bg-red-500 text-neutral-50 hover:bg-red-700">Deactivate</button>
    </div>
</div>


    </div>
</div>

<!-- Assign Ward Modal -->
<div id="assignWardModal" class="assign-modal-overlay" style="display:none;">
    <div class="assign-modal-container">
        <div class="assign-modal-header">
            <div>
                <div class="assign-modal-title">Assign Ward</div>
                <div class="assign-modal-subtitle" id="assignWardSubtitle">Select a ward for this staff member</div>
            </div>
            <button class="assign-modal-close" onclick="closeAssignWardModal()">✕</button>
        </div>
        <div class="assign-modal-body">
            <div class="assign-form-group">
                <label>Current Assignment</label>
                <div id="currentWardDisplay" style="padding:8px 0;font-size:0.875rem;"></div>
            </div>
<div class="assign-form-group">
    <label>Select Ward</label>
    <div class="radix-select" id="wardRadixSelect">
        <button type="button" class="radix-select-trigger" data-value="">
            <span>-- Select a ward --</span>
            <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
        </button>
        <div class="radix-select-content hidden" style="max-height:200px;overflow-y:auto;"></div>
    </div>
</div>
            <div class="assign-form-group">
                <label for="patientCountInput">Number of Patients (optional)</label>
                <input type="number" id="patientCountInput" class="assign-select" placeholder="e.g. 8" min="0" max="50" style="width:100%;">
            </div>
        </div>
        <div class="assign-modal-footer">
            <button class="assign-btn-cancel" onclick="closeAssignWardModal()">Cancel</button>
            <button class="assign-btn-save assign-btn-save bg-primary rounded-lg h-10 border text-white" id="confirmAssignWardBtn">Save Assignment</button>
        </div>
    </div>
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
    // Staff Data
const staffData = [
    { id: 1, name: "Dr. Nakato Sarah", initials: "SJ", role: "Cardiologist", department: "Medical", email: "nakato.sarah@hospital.ug", phone: "+256 712 345 101", joined: "May 15, 2012", status: "Active", ward: "Cardiology Wing", wardPatients: 12 },
    { id: 2, name: "Dr. Mwangi Peter", initials: "MC", role: "Neurologist", department: "Medical", email: "mwangi.peter@hospital.ug", phone: "+256 712 345 102", joined: "Jun 22, 2015", status: "Active", ward: "Neurology Unit", wardPatients: 8 },
    { id: 3, name: "Namyalo Emma", initials: "ER", role: "Head Nurse", department: "Nursing", email: "emma.r@hospital.ug", phone: "+256 712 345 103", joined: "Feb 10, 2018", status: "On Leave", ward: "ICU & Cardiology", wardPatients: 4 },
    { id: 4, name: "Byaruhanga Robert", initials: "RD", role: "Lab Technician", department: "Laboratory", email: "robert.d@hospital.ug", phone: "+256 712 345 104", joined: "Nov 5, 2019", status: "Active", ward: null, wardPatients: 0 },
    { id: 5, name: "Kemigisha Jennifer", initials: "JK", role: "Pharmacist", department: "Pharmacy", email: "jennifer.k@hospital.ug", phone: "+256 712 345 105", joined: "Mar 18, 2017", status: "Active", ward: "Pharmacy Dispensary", wardPatients: 0 },
    { id: 6, name: "Mukasa David", initials: "DW", role: "Radiologist", department: "Radiology", email: "david.w@hospital.ug", phone: "+256 712 345 106", joined: "Sep 30, 2016", status: "Inactive", ward: null, wardPatients: 0 },
    { id: 7, name: "Nabisere Maria", initials: "MG", role: "Receptionist", department: "Administration", email: "maria.g@hospital.ug", phone: "+256 712 345 107", joined: "Jan 12, 2020", status: "Active", ward: "Front Desk", wardPatients: 0 },
    { id: 8, name: "Ssentongo James", initials: "JB", role: "Physical Therapist", department: "Therapy", email: "james.b@hospital.ug", phone: "+256 712 345 108", joined: "Jul 7, 2018", status: "Active", ward: "Rehabilitation Center", wardPatients: 6 }
];

// Available wards for assignment
const availableWards = [
    "ICU & Cardiology", "Neurology Unit", "Cardiology Wing", "General Ward A",
    "General Ward B", "Pediatrics", "Maternity", "Emergency", "Rehabilitation Center",
    "Pharmacy Dispensary", "Front Desk", "Radiology Unit", "Laboratory"
];

let currentTab = "list";
let searchQuery = "";
let departmentFilter = "all";
let roleFilter = "all";
let statusFilter = "all";
let currentPage = 1;
let itemsPerPage = 5;
let activeMenu = null;
let currentActionStaff = { id: null, name: null, action: null };
let currentAssignStaffId = null;
let currentAssignStaffName = null;

const departments = ["All", "Medical", "Nursing", "Administration", "Laboratory", "Pharmacy", "Radiology", "Therapy", "Support"];
const roles = ["All", "Cardiologist", "Neurologist", "Head Nurse", "Lab Technician", "Pharmacist", "Radiologist", "Receptionist", "Physical Therapist"];
const statuses = ["All", "Active", "On Leave", "Inactive"];

// ==================== HELPERS ====================
function showToast(message, isError = false) {
    const existing = document.querySelector('.toast-message');
    if (existing) existing.remove();
    const toast = document.createElement('div');
    toast.className = `toast-message ${isError ? 'error' : ''}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

function closeMenu() { 
    if (activeMenu) { 
        activeMenu.remove(); 
        activeMenu = null; 
    } 
}

function getStatusColor(status) {
    if (status === 'Active') return 'bg-green-100 text-green-800';
    if (status === 'On Leave') return 'bg-yellow-100 text-yellow-800';
    return 'bg-gray-100 text-gray-800';
}

function getFilteredData() {
    let filtered = [...staffData];
    if (searchQuery) {
        const q = searchQuery.toLowerCase();
        filtered = filtered.filter(s => s.name.toLowerCase().includes(q) || s.role.toLowerCase().includes(q) || s.email.toLowerCase().includes(q));
    }
    if (departmentFilter !== "all") filtered = filtered.filter(s => s.department.toLowerCase() === departmentFilter);
    if (roleFilter !== "all") filtered = filtered.filter(s => s.role.toLowerCase() === roleFilter);
    if (statusFilter !== "all") filtered = filtered.filter(s => s.status.toLowerCase() === statusFilter);
    return filtered;
}

// ==================== DROPDOWN MENUS ====================
function showMoreOptionsMenu(btn) {
    closeMenu();
    const rect = btn.getBoundingClientRect();
    const menu = document.createElement('div');
    menu.className = 'dropdown-menu';
    menu.style.minWidth = '200px';
    
    const mainContent = document.querySelector('main');
    const mainRect = mainContent.getBoundingClientRect();
    
    let left = rect.right - 200;
    let top = rect.bottom + 6;
    
    if (left + 200 > mainRect.right) left = mainRect.right - 210;
    if (left + 200 > window.innerWidth) left = window.innerWidth - 210;
    if (left < mainRect.left) left = mainRect.left + 10;
    if (left < 10) left = 10;
    
    menu.style.top = `${top}px`;
    menu.style.left = `${left}px`;
    
    menu.innerHTML = `
        <div class="dropdown-header">Actions</div>
        <a href="roles-permissions.html" class="dropdown-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg>
            Roles &amp; Permissions
        </a>
        <a href="staff-attendance.html" class="dropdown-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            Attendance
        </a>
        <a href="certification.html" class="dropdown-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"></path><circle cx="12" cy="8" r="6"></circle></svg>
            Certifications
        </a>
        <a href="performance.html" class="dropdown-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path></svg>
            Performance
        </a>
    `;
    document.body.appendChild(menu);
    activeMenu = menu;
    
    const menuHeight = menu.offsetHeight;
    const maxBottom = Math.min(mainRect.bottom, window.innerHeight);
    if (rect.bottom + 6 + menuHeight > maxBottom) {
        top = rect.top - menuHeight - 6;
        if (top < Math.max(mainRect.top, 10)) top = Math.max(mainRect.top, 10);
        menu.style.top = `${top}px`;
    }
    
    const closeHandler = (e) => { 
        if (!menu.contains(e.target) && e.target !== btn) { 
            closeMenu(); 
            document.removeEventListener('click', closeHandler); 
        } 
    };
    setTimeout(() => document.addEventListener('click', closeHandler), 10);
}

function showFilterMenu(btn) {
    closeMenu();
    const rect = btn.getBoundingClientRect();
    const menu = document.createElement('div');
    menu.className = 'dropdown-menu';
    menu.style.minWidth = '280px';
    
    const mainContent = document.querySelector('main');
    const mainRect = mainContent.getBoundingClientRect();
    
    let left = rect.left;
    let top = rect.bottom + 6;
    
    if (left + 280 > mainRect.right) left = mainRect.right - 290;
    if (left + 280 > window.innerWidth) left = window.innerWidth - 290;
    if (left < mainRect.left) left = mainRect.left + 10;
    if (left < 10) left = 10;
    
    menu.style.top = `${top}px`;
    menu.style.left = `${left}px`;
    
    // Build department options
    const deptOptions = departments.map(d => d === 'All' ? '' : d.toLowerCase());
    const deptLabels = departments;
    const currentDept = departmentFilter || '';
    const currentDeptLabel = deptLabels[deptOptions.indexOf(currentDept)] || 'All';
    
    // Build role options
    const roleOptions = roles.map(r => r === 'All' ? '' : r.toLowerCase());
    const roleLabels = roles;
    const currentRole = roleFilter || '';
    const currentRoleLabel = roleLabels[roleOptions.indexOf(currentRole)] || 'All';
    
    // Build status options
    const statusOptions = statuses.map(s => s === 'All' ? '' : s.toLowerCase());
    const statusLabels = statuses;
    const currentStatus = statusFilter || '';
    const currentStatusLabel = statusLabels[statusOptions.indexOf(currentStatus)] || 'All';
    
    menu.innerHTML = `
        <div class="dropdown-header">
            Filter Staff
            <span style="float:right;font-weight:400;color:#9ca3af;font-size:0.7rem;">
                ${(departmentFilter !== '' && departmentFilter !== 'all' ? 1 : 0) + (roleFilter !== '' && roleFilter !== 'all' ? 1 : 0) + (statusFilter !== '' && statusFilter !== 'all' ? 1 : 0)} active
            </span>
        </div>
        
        <!-- Department Radix Select -->
        <div class="filter-section">
            <label class="filter-label">Department</label>
            <div class="radix-select filter-radix" id="filterDeptSelect">
                <button type="button" class="radix-select-trigger" data-value="${currentDept}" style="min-height:36px;font-size:0.8125rem;">
                    <span>${currentDeptLabel}</span>
                    <svg class="h-3.5 w-3.5 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                </button>
                <div class="radix-select-content hidden" style="max-height:180px;overflow-y:auto;">
                    ${deptLabels.map((label, i) => `
                        <div class="radix-select-item" data-value="${deptOptions[i]}" data-selected="${deptOptions[i] === currentDept ? 'true' : 'false'}">
                            ${label}
                            <svg class="radix-select-item-indicator h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                    `).join('')}
                </div>
            </div>
        </div>
        
        <!-- Role Radix Select -->
        <div class="filter-section">
            <label class="filter-label">Role</label>
            <div class="radix-select filter-radix" id="filterRoleSelect">
                <button type="button" class="radix-select-trigger" data-value="${currentRole}" style="min-height:36px;font-size:0.8125rem;">
                    <span>${currentRoleLabel}</span>
                    <svg class="h-3.5 w-3.5 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                </button>
                <div class="radix-select-content hidden" style="max-height:180px;overflow-y:auto;">
                    ${roleLabels.map((label, i) => `
                        <div class="radix-select-item" data-value="${roleOptions[i]}" data-selected="${roleOptions[i] === currentRole ? 'true' : 'false'}">
                            ${label}
                            <svg class="radix-select-item-indicator h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                    `).join('')}
                </div>
            </div>
        </div>
        
        <!-- Status Radix Select -->
        <div class="filter-section">
            <label class="filter-label">Status</label>
            <div class="radix-select filter-radix" id="filterStatusSelect">
                <button type="button" class="radix-select-trigger" data-value="${currentStatus}" style="min-height:36px;font-size:0.8125rem;">
                    <span>${currentStatusLabel}</span>
                    <svg class="h-3.5 w-3.5 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                </button>
                <div class="radix-select-content hidden" style="max-height:180px;overflow-y:auto;">
                    ${statusLabels.map((label, i) => `
                        <div class="radix-select-item" data-value="${statusOptions[i]}" data-selected="${statusOptions[i] === currentStatus ? 'true' : 'false'}">
                            ${label}
                            <svg class="radix-select-item-indicator h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        </div>
                    `).join('')}
                </div>
            </div>
        </div>
        
        <!-- Active Filter Pills -->
        <div id="activeFilterPills" style="padding:0 0.75rem 0.5rem;display:flex;flex-wrap:wrap;gap:4px;${(departmentFilter && departmentFilter !== 'all') || (roleFilter && roleFilter !== 'all') || (statusFilter && statusFilter !== 'all') ? '' : 'display:none;'}">
            ${departmentFilter && departmentFilter !== 'all' ? `<span style="display:inline-flex;align-items:center;gap:4px;background:#eef2ff;color:#4338ca;padding:2px 8px;border-radius:9999px;font-size:0.6875rem;font-weight:500;">${currentDeptLabel}<svg class="remove-filter-pill" data-type="department" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;cursor:pointer;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></span>` : ''}
            ${roleFilter && roleFilter !== 'all' ? `<span style="display:inline-flex;align-items:center;gap:4px;background:#eef2ff;color:#4338ca;padding:2px 8px;border-radius:9999px;font-size:0.6875rem;font-weight:500;">${currentRoleLabel}<svg class="remove-filter-pill" data-type="role" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;cursor:pointer;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></span>` : ''}
            ${statusFilter && statusFilter !== 'all' ? `<span style="display:inline-flex;align-items:center;gap:4px;background:#eef2ff;color:#4338ca;padding:2px 8px;border-radius:9999px;font-size:0.6875rem;font-weight:500;">${currentStatusLabel}<svg class="remove-filter-pill" data-type="status" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:12px;height:12px;cursor:pointer;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></span>` : ''}
        </div>
        
        <div class="dropdown-divider"></div>
        
        <!-- Action Buttons -->
        <div style="display:flex;gap:6px;padding:0.25rem 0.5rem;">
            <button id="resetFiltersBtn" class="dropdown-item flex-1 justify-center" style="color:#6b7280;">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
                Reset
            </button>
            <button id="applyFiltersBtn" class="dropdown-item flex-1 justify-center" style="background:#6366f1;color:white;border-radius:0.25rem;">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Apply
            </button>
        </div>
    `;
    
    document.body.appendChild(menu);
    activeMenu = menu;
    
    // Position adjustment
    const menuHeight = menu.offsetHeight;
    const maxBottom = Math.min(mainRect.bottom, window.innerHeight);
    if (rect.bottom + 6 + menuHeight > maxBottom) {
        top = rect.top - menuHeight - 6;
        if (top < Math.max(mainRect.top, 10)) top = Math.max(mainRect.top, 10);
        menu.style.top = `${top}px`;
    }
    
    // Initialize all Radix selects in the filter
    menu.querySelectorAll('.filter-radix').forEach(select => {
        initRadixSelect(select);
        
        // Add change handler
        const trigger = select.querySelector('.radix-select-trigger');
        const items = select.querySelectorAll('.radix-select-item');
        
        items.forEach(item => {
            item.addEventListener('click', () => {
                // Update the filter variable based on which select
                if (select.id === 'filterDeptSelect') {
                    departmentFilter = item.dataset.value;
                } else if (select.id === 'filterRoleSelect') {
                    roleFilter = item.dataset.value;
                } else if (select.id === 'filterStatusSelect') {
                    statusFilter = item.dataset.value;
                }
                // Don't close - let user apply
            });
        });
    });
    
    // Remove filter pill handlers
    menu.querySelectorAll('.remove-filter-pill').forEach(pill => {
        pill.addEventListener('click', (e) => {
            e.stopPropagation();
            const type = pill.dataset.type;
            if (type === 'department') {
                departmentFilter = '';
            } else if (type === 'role') {
                roleFilter = '';
            } else if (type === 'status') {
                statusFilter = '';
            }
            // Refresh the filter menu
            closeMenu();
            showFilterMenu(btn);
        });
    });
    
    // Reset button
    menu.querySelector('#resetFiltersBtn')?.addEventListener('click', () => {
        departmentFilter = '';
        roleFilter = '';
        statusFilter = '';
        closeMenu();
        showFilterMenu(btn);
    });
    
    // Apply button
    menu.querySelector('#applyFiltersBtn')?.addEventListener('click', () => {
        currentPage = 1;
        renderAll();
        closeMenu();
        showToast('Filters applied');
    });
    
    // Close handler
    const closeHandler = (e) => { 
        if (!menu.contains(e.target) && e.target !== btn) { 
            closeMenu(); 
            document.removeEventListener('click', closeHandler); 
        } 
    };
    setTimeout(() => document.addEventListener('click', closeHandler), 10);
}

function showActionMenu(btn, staffId, staffName) {
    closeMenu();
    const rect = btn.getBoundingClientRect();
    const menu = document.createElement('div');
    menu.className = 'dropdown-menu';
    menu.style.minWidth = '200px';
    
    const mainContent = document.querySelector('main');
    const mainRect = mainContent.getBoundingClientRect();
    
    let left = rect.left;
    let top = rect.bottom + 6;
    
    if (left + 200 > mainRect.right) left = mainRect.right - 210;
    if (left + 200 > window.innerWidth) left = window.innerWidth - 210;
    if (left < mainRect.left) left = mainRect.left + 10;
    if (left < 10) left = 10;
    
    menu.style.top = `${top}px`;
    menu.style.left = `${left}px`;
    
    menu.innerHTML = `
        <div class="dropdown-header">Actions</div>
        <a href="staff-profile.html?id=${staffId}" class="dropdown-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>
            View Profile
        </a>
        <a href="edit-staff-profile.html?id=${staffId}" class="dropdown-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path></svg>
            Edit
        </a>
        <a href="staff-schedule.html?id=${staffId}" class="dropdown-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path><path d="M8 2v4"></path><path d="M16 2v4"></path></svg>
            Schedule
        </a>
        <div class="dropdown-divider"></div>
        <div class="dropdown-header" style="border-bottom:none;margin-bottom:0;">Manage</div>
        <div class="dropdown-item assign-ward-item" data-id="${staffId}" data-name="${staffName}">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/></svg>
            Assign Ward
        </div>
        <div class="dropdown-item deactivate-item" data-id="${staffId}" data-name="${staffName}">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="17" x2="22" y1="8" y2="13"></line><line x1="22" x2="17" y1="8" y2="13"></line></svg>
            Deactivate
        </div>
        <div class="dropdown-item text-red delete-item" data-id="${staffId}" data-name="${staffName}">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
            Delete
        </div>
    `;
    document.body.appendChild(menu);
    activeMenu = menu;
    
    const menuHeight = menu.offsetHeight;
    const maxBottom = Math.min(mainRect.bottom, window.innerHeight);
    if (rect.bottom + 6 + menuHeight > maxBottom) {
        top = rect.top - menuHeight - 6;
        if (top < Math.max(mainRect.top, 10)) top = Math.max(mainRect.top, 10);
        menu.style.top = `${top}px`;
    }
    
    menu.querySelector('.deactivate-item')?.addEventListener('click', (e) => {
        e.preventDefault();
        closeMenu();
        openDeactivateModal(e.currentTarget.getAttribute('data-id'), e.currentTarget.getAttribute('data-name'));
    });
    menu.querySelector('.delete-item')?.addEventListener('click', (e) => {
        e.preventDefault();
        closeMenu();
        openDeleteModal(e.currentTarget.getAttribute('data-id'), e.currentTarget.getAttribute('data-name'));
    });
    menu.querySelector('.assign-ward-item')?.addEventListener('click', (e) => {
        e.preventDefault();
        closeMenu();
        openAssignWardModal(e.currentTarget.getAttribute('data-id'), e.currentTarget.getAttribute('data-name'));
    });
    
    const closeHandler = (e) => { if (!menu.contains(e.target) && e.target !== btn) { closeMenu(); document.removeEventListener('click', closeHandler); } };
    setTimeout(() => document.addEventListener('click', closeHandler), 10);
}

// ==================== MODAL FUNCTIONS ====================
function openDeleteModal(staffId, staffName) {
    currentActionStaff = { id: staffId, name: staffName, action: 'delete' };
    document.getElementById('deleteModal').style.display = 'grid';
    showBackdrop();
}

function openDeactivateModal(staffId, staffName) {
    currentActionStaff = { id: staffId, name: staffName, action: 'deactivate' };
    document.getElementById('deactivateModal').style.display = 'grid';
    showBackdrop();
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
    hideBackdrop();
    currentActionStaff = { id: null, name: null, action: null };
}

function closeDeactivateModal() {
    document.getElementById('deactivateModal').style.display = 'none';
    hideBackdrop();
    currentActionStaff = { id: null, name: null, action: null };
}

function showBackdrop() {
    let backdrop = document.querySelector('.modal-backdrop');
    if (!backdrop) {
        backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop';
        document.body.appendChild(backdrop);
    }
    backdrop.classList.add('show');
    document.body.style.overflow = 'hidden';
}

function hideBackdrop() {
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) backdrop.classList.remove('show');
    document.body.style.overflow = '';
}

// ==================== RADIX SELECT ====================
function initRadixSelect(selectElement) {
    if (!selectElement) return;
    const trigger = selectElement.querySelector('.radix-select-trigger');
    const content = selectElement.querySelector('.radix-select-content');
    const items = selectElement.querySelectorAll('.radix-select-item');
    
    const newTrigger = trigger.cloneNode(true);
    if (trigger && trigger.parentNode) {
        trigger.parentNode.replaceChild(newTrigger, trigger);
    }
    
    newTrigger?.addEventListener('click', (e) => {
        e.stopPropagation();
        document.querySelectorAll('.radix-select-content').forEach(c => { if (c !== content) c.classList.add('hidden'); });
        content?.classList.toggle('hidden');
    });
    
    items.forEach(item => {
        item.addEventListener('click', (e) => {
            e.stopPropagation();
            const value = item.getAttribute('data-value');
            const label = item.getAttribute('data-value') || '-- Select a ward --';
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

// ==================== ASSIGN WARD MODAL ====================
function openAssignWardModal(staffId, staffName) {
    currentAssignStaffId = staffId;
    currentAssignStaffName = staffName;
    
    const staff = staffData.find(s => s.id == staffId);
    document.getElementById('assignWardSubtitle').textContent = `Select a ward for ${staffName}`;
    
    const currentDisplay = document.getElementById('currentWardDisplay');
    if (staff && staff.ward) {
        currentDisplay.innerHTML = `<span class="current-assignment">${staff.ward}${staff.wardPatients > 0 ? ` · ${staff.wardPatients} patients` : ''}</span>`;
    } else {
        currentDisplay.innerHTML = `<span class="assignment-unassigned">Not currently assigned to any ward</span>`;
    }
    
    const radixContent = document.querySelector('#wardRadixSelect .radix-select-content');
    const radixTrigger = document.querySelector('#wardRadixSelect .radix-select-trigger');
    
    radixContent.innerHTML = availableWards.map(w => 
        `<div class="radix-select-item" data-value="${w}" ${staff && staff.ward === w ? 'data-selected="true"' : ''}>
            ${w}
            <svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </div>`
    ).join('');
    
    if (staff && staff.ward) {
        radixTrigger.querySelector('span').textContent = staff.ward;
        radixTrigger.setAttribute('data-value', staff.ward);
    } else {
        radixTrigger.querySelector('span').textContent = '-- Select a ward --';
        radixTrigger.setAttribute('data-value', '');
    }
    
    document.getElementById('patientCountInput').value = staff ? (staff.wardPatients || 0) : 0;
    
    document.getElementById('assignWardModal').style.display = 'flex';
    showBackdrop();
    
    initRadixSelect(document.getElementById('wardRadixSelect'));
}

function closeAssignWardModal() {
    document.getElementById('assignWardModal').style.display = 'none';
    hideBackdrop();
    currentAssignStaffId = null;
    currentAssignStaffName = null;
}

// ==================== RENDER FUNCTIONS ====================
function renderListView() {
    const filtered = getFilteredData();
    const start = (currentPage - 1) * itemsPerPage;
    const paginated = filtered.slice(start, start + itemsPerPage);
    const tbody = document.getElementById('listViewBody');
    
    if (!tbody) return;
    
    if (paginated.length === 0) {
        tbody.innerHTML = `<tr><td colspan="8" class="text-center py-8 text-gray-500">No staff members found</td></tr>`;
    } else {
        tbody.innerHTML = paginated.map(staff => `
            <tr class="border-b hover:bg-accent hover:text-accent-foreground h-10">
                <td class="p-4"><div class="flex items-center gap-3"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span><div class="font-medium">${staff.name}</div></div></td>
                <td class="p-4">${staff.role}</td>
                <td class="p-4 hidden md:table-cell">${staff.department}</td>
                <td class="p-4 hidden md:table-cell"><div class="flex flex-col"><span class="text-xs text-gray-500">${staff.email}</span><span class="text-xs text-gray-500">${staff.phone}</span></div></td>
                <td class="p-4 hidden md:table-cell">${staff.joined}</td>
                <td class="p-4">${staff.ward ? `<span class="current-assignment">${staff.ward}${staff.wardPatients > 0 ? ` · ${staff.wardPatients} pts` : ''}</span>` : `<span class="assignment-unassigned">Unassigned</span>`}</td>
                <td class="p-4"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold ${getStatusColor(staff.status)}">${staff.status}</span></td>
                <td class="p-4 text-right"><button data-id="${staff.id}" data-name="${staff.name}" class="action-trigger inline-flex items-center justify-center h-10 w-10 rounded-md hover:bg-gray-100"><svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg></button></td>
            </tr>
        `).join('');
    }
    
    const paginationInfo = document.getElementById('paginationInfo');
    if (paginationInfo) {
        paginationInfo.innerHTML = `Showing <strong>${filtered.length === 0 ? 0 : start + 1}</strong> to <strong>${Math.min(start + itemsPerPage, filtered.length)}</strong> of <strong>${filtered.length}</strong> staff members`;
    }
    document.getElementById('prevPageBtn').disabled = currentPage === 1;
    document.getElementById('nextPageBtn').disabled = start + itemsPerPage >= filtered.length;
    
    document.querySelectorAll('#listViewBody .action-trigger').forEach(btn => {
        btn.addEventListener('click', (e) => { e.stopPropagation(); showActionMenu(btn, btn.dataset.id, btn.dataset.name); });
    });
}

function renderGridView() {
    const filtered = getFilteredData();
    const start = (currentPage - 1) * itemsPerPage;
    const paginated = filtered.slice(start, start + itemsPerPage);
    const container = document.getElementById('gridViewBody');
    
    if (!container) return;
    
    if (paginated.length === 0) {
        container.innerHTML = '<div class="col-span-full text-center py-8 text-gray-500">No staff members found</div>';
    } else {
        container.innerHTML = paginated.map(staff => `
            <div class="rounded-lg border bg-background shadow-sm overflow-hidden">
                <div class="flex flex-col">
                    <div class="flex items-center justify-between bg-gray-50 p-4">
                        <div class="flex items-center gap-3">
                            <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span>
                            <div><div class="font-medium">${staff.name}</div><div class="text-xs text-gray-500">${staff.role}</div></div>
                        </div>
                        <span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold ${getStatusColor(staff.status)}">${staff.status}</span>
                    </div>
                    <div class="p-4"><div class="grid gap-2">
                        <div class="flex items-center gap-2"><svg class="h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/></svg><span class="text-sm">${staff.ward ? `${staff.ward}${staff.wardPatients > 0 ? ` · ${staff.wardPatients} pts` : ''}` : `<span style="color:#9ca3af;font-style:italic;">Unassigned</span>`}</span></div>
                        <div class="flex items-center gap-2"><svg class="h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2" ry="2"></rect></svg><span class="text-sm">${staff.department}</span></div>
                        <div class="flex items-center gap-2"><svg class="h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg><span class="text-sm">${staff.email}</span></div>
                        <div class="flex items-center gap-2"><svg class="h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg><span class="text-sm">${staff.phone}</span></div>
                        <div class="flex items-center gap-2"><svg class="h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg><span class="text-sm">Joined ${staff.joined}</span></div>
                    </div></div>
                    <div class="flex border-t">
                        <a href="staff-profile.html?id=${staff.id}" class="flex-1 inline-flex items-center justify-center gap-2 border-r py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>View</a>
                        <a href="edit-staff-profile.html?id=${staff.id}" class="flex-1 inline-flex items-center justify-center gap-2 border-r py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path></svg>Edit</a>
                        <a href="staff-schedule.html?id=${staff.id}" class="flex-1 inline-flex items-center justify-center gap-2 py-2 text-sm hover:bg-accent hover:text-accent-foreground h-10"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>Schedule</a>
                    </div>
                </div>
            </div>
        `).join('');
    }
    
    const gridPaginationInfo = document.getElementById('gridPaginationInfo');
    if (gridPaginationInfo) {
        gridPaginationInfo.innerHTML = `Showing <strong>${filtered.length === 0 ? 0 : start + 1}</strong> to <strong>${Math.min(start + itemsPerPage, filtered.length)}</strong> of <strong>${filtered.length}</strong> staff members`;
    }
    document.getElementById('gridPrevPageBtn').disabled = currentPage === 1;
    document.getElementById('gridNextPageBtn').disabled = start + itemsPerPage >= filtered.length;
}

function renderAll() {
    if (currentTab === 'list') renderListView();
    else renderGridView();
    
    const totalStaffEl = document.getElementById('totalStaff');
    const activeCountEl = document.getElementById('activeCount');
    const onLeaveCountEl = document.getElementById('onLeaveCount');
    const inactiveCountEl = document.getElementById('inactiveCount');
    
    if (totalStaffEl) totalStaffEl.innerText = staffData.length;
    if (activeCountEl) activeCountEl.innerText = staffData.filter(s => s.status === 'Active').length;
    if (onLeaveCountEl) onLeaveCountEl.innerText = staffData.filter(s => s.status === 'On Leave').length;
    if (inactiveCountEl) inactiveCountEl.innerText = staffData.filter(s => s.status === 'Inactive').length;
}

function activateTab(tabId) {
    const tabs = ['list', 'grid'];
    tabs.forEach(id => {
        const panel = document.getElementById(`tab-${id}`);
        if (panel) panel.classList.remove('active');
        const btn = document.querySelector(`.tab-btn[data-tab="${id}"]`);
        if (btn) {
            btn.setAttribute('data-state', id === tabId ? 'active' : 'inactive');
            if (id === tabId) { btn.classList.add('bg-white', 'text-gray-900', 'shadow-sm'); btn.classList.remove('bg-transparent', 'text-gray-500'); }
            else { btn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm'); btn.classList.add('bg-transparent', 'text-gray-500'); }
        }
    });
    const activePanel = document.getElementById(`tab-${tabId}`);
    if (activePanel) activePanel.classList.add('active');
    currentTab = tabId;
    currentPage = 1;
    renderAll();
}

// ==================== INITIALIZATION ====================
document.addEventListener('DOMContentLoaded', () => {
    // Tab buttons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => activateTab(btn.getAttribute('data-tab')));
    });
    
    // Search
    document.getElementById('searchInput')?.addEventListener('input', (e) => { 
        searchQuery = e.target.value.toLowerCase(); 
        currentPage = 1; 
        renderAll(); 
    });
    
    // Pagination
    document.getElementById('prevPageBtn')?.addEventListener('click', () => { if (currentPage > 1) { currentPage--; renderAll(); } });
    document.getElementById('nextPageBtn')?.addEventListener('click', () => { currentPage++; renderAll(); });
    document.getElementById('gridPrevPageBtn')?.addEventListener('click', () => { if (currentPage > 1) { currentPage--; renderAll(); } });
    document.getElementById('gridNextPageBtn')?.addEventListener('click', () => { currentPage++; renderAll(); });
    
    // Dropdown buttons
    document.getElementById('moreOptionsBtn')?.addEventListener('click', (e) => { e.stopPropagation(); showMoreOptionsMenu(e.currentTarget); });
    document.getElementById('filterBtn')?.addEventListener('click', (e) => { e.stopPropagation(); showFilterMenu(e.currentTarget); });
    
    // Confirm Delete
    document.getElementById('confirmDeleteBtn')?.addEventListener('click', () => {
        if (currentActionStaff.id) {
            const index = staffData.findIndex(s => s.id == currentActionStaff.id);
            if (index !== -1) {
                const name = staffData[index].name;
                staffData.splice(index, 1);
                showToast(`Staff member "${name}" has been deleted successfully.`);
                renderAll();
            }
            closeDeleteModal();
        }
    });
    
    // Confirm Deactivate
    document.getElementById('confirmDeactivateBtn')?.addEventListener('click', () => {
        if (currentActionStaff.id) {
            const staff = staffData.find(s => s.id == currentActionStaff.id);
            if (staff && staff.status !== 'Inactive') {
                staff.status = 'Inactive';
                showToast(`Staff member "${currentActionStaff.name}" has been deactivated.`);
                renderAll();
            } else if (staff && staff.status === 'Inactive') {
                showToast(`${currentActionStaff.name} is already inactive.`, true);
            }
            closeDeactivateModal();
        }
    });
    
    // Confirm Assign Ward
    document.getElementById('confirmAssignWardBtn')?.addEventListener('click', () => {
        const wardTrigger = document.querySelector('#wardRadixSelect .radix-select-trigger');
        const ward = wardTrigger?.getAttribute('data-value') || '';
        const patientCount = parseInt(document.getElementById('patientCountInput').value) || 0;
        
        if (!ward) {
            showToast('Please select a ward', true);
            return;
        }
        
        const staff = staffData.find(s => s.id == currentAssignStaffId);
        if (staff) {
            staff.ward = ward;
            staff.wardPatients = patientCount;
            showToast(`${currentAssignStaffName} assigned to ${ward}`);
            renderAll();
        }
        closeAssignWardModal();
    });
    
    // Initialize
    activateTab('list');
});

// Global event listeners
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('modal-backdrop')) {
        closeDeleteModal();
        closeDeactivateModal();
        closeAssignWardModal();
    }
    if (!e.target.closest('.radix-select')) {
        document.querySelectorAll('.radix-select-content').forEach(c => c.classList.add('hidden'));
    }
});

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeDeleteModal();
        closeDeactivateModal();
        closeAssignWardModal();
        closeMenu();
    }
});

window.addEventListener('scroll', () => closeMenu());
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
    <script src="js/admin-sync.js"></script>
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
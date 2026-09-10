<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | All Orders with Tracking</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <style>

        * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .rounded-lg.border { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted { background-color: #262626 !important; }
        body.dark input, body.dark textarea, body.dark select { background-color: #262626 !important; border-color: #404040 !important; color: #e5e5e5 !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        .radix-select {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: space-between;
            border-radius: 0.375rem;
            border: 1px solid #e2e8f0;
            background-color: white;
            padding: 0.375rem 2rem 0.375rem 0.75rem;
            font-size: 0.875rem;
            cursor: pointer;
            width: 100%;
        }
        body.dark .radix-select { background-color: #262626; border-color: #404040; color: #e5e5e5; }
        .select-chevron { position: absolute; right: 0.5rem; pointer-events: none; top: 50%; transform: translateY(-50%); }
        .radix-dropdown-menu {
            position: fixed;
            z-index: 100;
            min-width: 8rem;
            overflow: hidden;
            border-radius: 0.5rem;
            border: 1px solid #e2e8f0;
            background-color: white;
            padding: 0.25rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        body.dark .radix-dropdown-menu { background-color: #2a2a2a; border-color: #404040; }
        .radix-menu-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            border-radius: 0.25rem;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            transition: background-color 0.1s;
        }
        .radix-menu-item:hover { background-color: #f1f5f9; }
        body.dark .radix-menu-item:hover { background-color: #3f3f46; }
        
        .modal-fixed-overlay {
            position: fixed; inset: 0; background-color: rgb(0 0 0 / 87%); backdrop-filter: blur(4px);
            z-index: 1000; display: flex; align-items: center; justify-content: center;
            animation: fadeIn 0.2s ease-out;
        }
        .modal-fixed-content {
            background: white; border-radius: 0.5rem; width: 90%; max-width: 32rem;
            animation: slideIn 0.2s ease-out; position: relative;
        }
        body.dark .modal-fixed-content { background: #1f1f1f; border: 1px solid #374151; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        
        .tracking-modal { max-width: 36rem; }
        .timeline-step { position: relative; padding-left: 2rem; padding-bottom: 1.5rem; }
        .timeline-step::before { content: ''; position: absolute; left: 0.5rem; top: 0.25rem; width: 1rem; height: 1rem; border-radius: 50%; background: #e5e7eb; border: 2px solid #9ca3af; }
        .timeline-step.completed::before { background: #10b981; border-color: #10b981; }
        .timeline-step.current::before { background: #3b82f6; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.3); }
        .timeline-step::after { content: ''; position: absolute; left: 0.95rem; top: 1.25rem; width: 2px; height: calc(100% - 1rem); background: #e5e7eb; }
        .timeline-step:last-child::after { display: none; }
        body.dark .timeline-step::before { background: #374151; border-color: #4b5563; }
        
        .status-badge {
            display: inline-flex; align-items: center; border-radius: 9999px; padding: 0.25rem 0.625rem;
            font-size: 0.75rem; font-weight: 600;
        }
        .status-delivered { background-color: #d1fae5; color: #065f46; }
        .status-shipped { background-color: #dbeafe; color: #1e40af; }
        .status-processing { background-color: #fed7aa; color: #92400e; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-cancelled { background-color: #fee2e2; color: #991b1b; }
        body.dark .status-delivered { background-color: #064e3b; color: #a7f3d0; }
        body.dark .status-shipped { background-color: #1e3a8a; color: #bfdbfe; }
        
        .toast-message {
            position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white;
            padding: 12px 20px; border-radius: 8px; z-index: 1100; font-size: 0.875rem;
            animation: slideInRight 0.3s ease-out;
        }
        @keyframes slideInRight { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }
        
        .action-menu-trigger { cursor: pointer; background: transparent; border: none; }
        .action-menu-trigger:hover { background-color: #f3f4f6; }
    
    
    /* Action Menu (matching Stock Alerts pattern) */
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
    padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer;
    display: flex; align-items: center; gap: 8px; border-radius: 0.25rem;
    transition: background 0.1s; width: 100%; background: transparent;
    border: none; color: inherit; text-align: left;
}
.action-item:hover { background-color: #f3f4f6; }
body.dark .action-item:hover { background-color: #3f3f46; }
.action-divider { height: 1px; background-color: #e5e7eb; margin: 0.25rem 0; }
body.dark .action-divider { background-color: #404040; }
.text-red-600 { color: #dc2626; }
.text-red-600:hover { background-color: #fef2f2; }

@keyframes fadeInScale { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }

/* Modal Overlay (standardized) */
.modal-overlay {
    position: fixed; inset: 0; background-color: rgb(0 0 0 / 87%);
    backdrop-filter: blur(4px); display: flex; align-items: center;
    justify-content: center; z-index: 9999; animation: fadeIn 0.2s ease-out;
}
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

.modal-container {
    background: white; border-radius: 0.75rem; width: 100%; max-width: 500px;
    animation: slideUp 0.2s ease; position: relative;
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

/* Radix Select for modals */
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
.bg-red-600 { background-color: #dc2626; }
.bg-red-600:hover { background-color: #b91c1c; }

</style>
</head>
<body class="bg-gray-50 antialiased">

        <header class="sticky top-0 z-40 border-b bg-background duration-300 xl:ml-64 shadow-sm border-gray-200">
            <div class="sticky flex h-16 items-center justify-between px-4 md:px-6">
<button><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="18" y2="18"></line></svg></button>
                <div class="ml-auto flex items-center space-x-4">
                    <div class="flex items-center gap-4">
                        <button id="themeToggleBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-gray-100 size-10" aria-label="Toggle theme">
                            <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  class="hidden text-gray-600"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path></svg>
                            <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  class="text-gray-600"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path></svg>
                        </button>

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
<div class="relative">
    <button id="profileBtn" class="flex items-center justify-center h-8 w-8 rounded-full hover:ring-2 hover:ring-gray-200">
        <img src="user.png" alt="Profile" class="h-8 w-8 rounded-full object-cover">
    </button>
    <div id="profileDropdown" class="hidden absolute right-0 mt-2 z-50 w-56 rounded-md border bg-background shadow-lg p-1 dropdown-content">
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
        
        <!-- Chat - NEW -->
        <a href="chat.html" class="flex items-center gap-2 px-2 py-1.5 text-sm hover:bg-gray-100 rounded">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"></path>
            </svg>
            Chat
        </a>
        
        <!-- Support - NEW -->
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
                <!-- Header -->
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div><h1 class="text-2xl font-bold tracking-tight mb-2">All Orders</h1><p class="text-gray-500">Manage and track all purchase orders across suppliers</p></div>
                    <button id="createOrderBtn" class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium bg-primary  text-white hover:bg-indigo-700 h-10 px-4 py-2"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>Create Order</button>
                </div>

                <!-- Stats Cards -->
                <div class="grid gap-4 md:grid-cols-4" id="statsContainer"></div>

                <!-- Orders Table -->
                <div class="rounded-lg border bg-background shadow-sm">
                    <div class="p-4">
                        <div class="flex flex-col gap-4">
<div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <div>
        <h2 class="text-xl font-semibold">Purchase Orders</h2>
        <p class="text-gray-500">View and manage all orders from suppliers</p>
    </div>
    <div class="flex flex-col gap-2 md:flex-row md:items-center">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" id="searchInput" placeholder="Search by order ID, supplier, item..." class="search-input flex h-10 rounded-md border border-gray-300 bg-background px-3 py-2 text-sm pl-8 w-full sm:w-[300px] focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div class="relative w-[140px]">
            <button id="statusFilterBtn" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-white dark:bg-gray-800 dark:border-gray-600 dark:text-white px-3 py-2 text-sm">
                <span id="statusFilterText">All Statuses</span>
                <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div id="statusFilterDropdown" class="hidden absolute top-full right-0 mt-1 w-full rounded-md border bg-background dark:bg-gray-800 dark:border-gray-600 shadow-lg z-50 py-1">
                <div data-status="all" class="px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">All Statuses</div>
                <div data-status="Delivered" class="px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">Delivered</div>
                <div data-status="Shipped" class="px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">Shipped</div>
                <div data-status="Processing" class="px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">Processing</div>
                <div data-status="Pending" class="px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">Pending</div>
                <div data-status="Cancelled" class="px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">Cancelled</div>
            </div>
        </div>
        <div class="relative w-[130px]">
            <button id="dateFilterBtn" class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-white dark:bg-gray-800 dark:border-gray-600 dark:text-white px-3 py-2 text-sm">
                <span id="dateFilterText">All Time</span>
                <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div id="dateFilterDropdown" class="hidden absolute top-full right-0 mt-1 w-full rounded-md border bg-background dark:bg-gray-800 dark:border-gray-600 shadow-lg z-50 py-1">
                <div data-date="all" class="px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">All Time</div>
                <div data-date="today" class="px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">Today</div>
                <div data-date="week" class="px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">This Week</div>
                <div data-date="month" class="px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">This Month</div>
            </div>
        </div>
    </div>
</div>
                            <!-- Table -->
                            <div class="rounded-md border overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-50 border-b">
                                        <tr>
                                            <th class="h-12 px-4 text-left font-medium text-gray-500">Order ID</th>
                                            <th class="h-12 px-4 text-left font-medium text-gray-500">Supplier</th>
                                            <th class="h-12 px-4 text-left font-medium text-gray-500">Item</th>
                                            <th class="h-12 px-4 text-left font-medium text-gray-500">Qty</th>
                                            <th class="h-12 px-4 text-left font-medium text-gray-500">Amount</th>
                                            <th class="h-12 px-4 text-left font-medium text-gray-500">Order Date</th>
                                            <th class="h-12 px-4 text-left font-medium text-gray-500">Status</th>
                                            <th class="h-12 px-4 text-center font-medium text-gray-500">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ordersTableBody"></tbody>
                                </table>
                            </div>
                            <div id="noResultsMsg" class="text-center py-8 text-gray-500 hidden">No orders match your filters.</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
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

// ==================== DATA WITH TRACKING INFO ====================
let ordersData = [
    { id: "PO-1001", supplier: "AAR Healthcare Supplies", item: "Surgical Gloves (Box)", quantity: 50, unitPrice: 12.50, amount: 625.00, orderDate: "2025-04-18", deliveryDate: "2025-04-22", status: "Delivered", priority: "Normal", trackingNumber: "1Z999AA10123456784", carrier: "DHL Express EA", trackingHistory: [
        { date: "2025-04-18 14:30", location: "Kampala, Uganda", status: "Order Confirmed", description: "Order received and confirmed" },
        { date: "2025-04-19 08:15", location: "Kampala, Uganda", status: "Processing", description: "Order is being processed at warehouse" },
        { date: "2025-04-20 11:45", location: "Kampala, Uganda", status: "Shipped", description: "Package shipped from distribution center" },
        { date: "2025-04-21 09:30", location: "Entebbe, Uganda", status: "In Transit", description: "Package arrived at sorting facility" },
        { date: "2025-04-22 10:00", location: "Destination", status: "Delivered", description: "Package delivered successfully" }
    ] },
    { id: "PO-1002", supplier: "AAR Healthcare Supplies", item: "Disposable Face Masks", quantity: 100, unitPrice: 8.99, amount: 899.00, orderDate: "2025-04-15", deliveryDate: "2025-04-19", status: "Shipped", priority: "High", trackingNumber: "1Z999BB10987654321", carrier: "G4S Uganda", trackingHistory: [
        { date: "2025-04-15 09:00", location: "Kampala, Uganda", status: "Order Confirmed", description: "Order received" },
        { date: "2025-04-16 10:30", location: "Kampala, Uganda", status: "Processing", description: "Preparing for shipment" },
        { date: "2025-04-17 16:20", location: "Kampala, Uganda", status: "Shipped", description: "Package in transit - Estimated delivery Apr 19" }
    ] },
    { id: "PO-1003", supplier: "HealthEquip Inc", item: "Digital Thermometer", quantity: 20, unitPrice: 24.95, amount: 499.00, orderDate: "2025-04-12", deliveryDate: "2025-04-19", status: "Processing", priority: "Normal", trackingNumber: "1Z999CC11223344556", carrier: "Posta Uganda", trackingHistory: [
        { date: "2025-04-12 11:00", location: "Nairobi, Kenya", status: "Order Confirmed", description: "Order confirmed" },
        { date: "2025-04-13 14:45", location: "Nairobi, Kenya", status: "Processing", description: "Processing in warehouse" }
    ] },
    { id: "PO-1004", supplier: "AAR Healthcare Supplies", item: "Blood Pressure Monitor", quantity: 10, unitPrice: 89.99, amount: 899.90, orderDate: "2025-04-10", deliveryDate: "2025-04-18", status: "Delivered", priority: "Low", trackingNumber: "1Z999DD99887766554", carrier: "DHL Express EA", trackingHistory: [
        { date: "2025-04-10 08:00", location: "Kampala, Uganda", status: "Order Confirmed", description: "Order confirmed" },
        { date: "2025-04-11 09:30", location: "Kampala, Uganda", status: "Shipped", description: "Shipped" },
        { date: "2025-04-18 12:00", location: "Destination", status: "Delivered", description: "Delivered" }
    ] },
    { id: "PO-1005", supplier: "PharmaDirect", item: "Stethoscope", quantity: 15, unitPrice: 45.00, amount: 675.00, orderDate: "2025-04-08", deliveryDate: "2025-04-15", status: "Delivered", priority: "Normal", trackingNumber: "1Z999EE88776655443", carrier: "G4S Uganda", trackingHistory: [] },
    { id: "PO-1006", supplier: "HealthEquip Inc", item: "Wheelchair", quantity: 5, unitPrice: 299.00, amount: 1495.00, orderDate: "2025-04-20", deliveryDate: "2025-04-28", status: "Pending", priority: "Urgent", trackingNumber: "TBD", carrier: "TBD", trackingHistory: [] }
];

let currentFilters = { search: '', status: 'all', dateRange: 'all' };
let activeActionMenu = null;
let currentEditOrder = null;

function formatDate(dateStr) { 
    const d = new Date(dateStr); 
    return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }); 
}

function getStatusClass(status) {
    const map = { Delivered: 'status-delivered', Shipped: 'status-shipped', Processing: 'status-processing', Pending: 'status-pending', Cancelled: 'status-cancelled' };
    return map[status] || 'status-processing';
}

// ==================== MODERN ACTION MENU ====================
function closeActionMenu() { 
    if (activeActionMenu) { 
        activeActionMenu.remove(); 
        activeActionMenu = null; 
    } 
}

function showActionMenu(btn, order) {
    closeActionMenu();
    const rect = btn.getBoundingClientRect();
    const menu = document.createElement('div');
    menu.className = 'action-menu';
    menu.style.cssText = `
        position: fixed;
        z-index: 10000;
        min-width: 200px;
        background: white;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        padding: 0.25rem;
        animation: fadeInScale 0.12s ease-out;
    `;
    if (document.body.classList.contains('dark')) {
        menu.style.background = '#2a2a2a';
        menu.style.borderColor = '#404040';
    }
    
    let left = rect.left;
    let top = rect.bottom + 6;
    if (left + 220 > window.innerWidth) left = window.innerWidth - 230;
    if (top + 230 > window.innerHeight) top = rect.top - 240;
    menu.style.top = `${top}px`;
    menu.style.left = `${left}px`;
    
    menu.innerHTML = `
        <div class="action-menu-header">Actions</div>
        <button data-action="track" class="action-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h18v18H3z"/><path d="M8 7v10"/><path d="M16 7v10"/><path d="M12 7v10"/></svg>
            Track Order
        </button>
        <button data-action="view" class="action-item">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
            View Details
        </button>
        <div class="action-divider"></div>
        <button data-action="edit" class="action-item text-blue-600">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
            Edit Order
        </button>
        <div class="action-divider"></div>
        <button data-action="cancel" class="action-item text-red-600">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
            Cancel Order
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
    
    menu.querySelector('[data-action="track"]')?.addEventListener('click', () => { openTrackingModal(order.id); closeActionMenu(); });
    menu.querySelector('[data-action="view"]')?.addEventListener('click', () => { openTrackingModal(order.id); closeActionMenu(); });
    menu.querySelector('[data-action="edit"]')?.addEventListener('click', () => { openEditOrderModal(order); closeActionMenu(); });
    menu.querySelector('[data-action="cancel"]')?.addEventListener('click', () => { openCancelOrderModal(order); closeActionMenu(); });
}

// ==================== TRACKING MODAL ====================
function openTrackingModal(orderId) {
    const order = ordersData.find(o => o.id === orderId);
    if (!order) return;
    
    closeAllModals();
    
    const overlay = document.createElement('div');
    overlay.className = 'modal-overlay';
    overlay.innerHTML = `
        <div class="modal-container tracking-modal" style="max-width: 36rem;">
            <div class="modal-header">
                <h2 class="modal-title">Track Order ${order.id}</h2>
                <button class="modal-close close-modal-btn">&times;</button>
            </div>
            <div class="modal-body modal-body-scrollable">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3h18v18H3zM8 7v10M16 7v10M12 7v10"/></svg>
                    </div>
                    <div>
                        <p class="text-gray-500">${order.supplier} • ${order.item}</p>
                    </div>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mb-4">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><span class="text-gray-500">Tracking Number:</span><br><span class="font-mono font-medium">${order.trackingNumber || 'Not assigned yet'}</span></div>
                        <div><span class="text-gray-500">Carrier:</span><br><span class="font-medium">${order.carrier || 'Pending'}</span></div>
                        <div><span class="text-gray-500">Current Status:</span><br><span class="status-badge ${getStatusClass(order.status)}">${order.status}</span></div>
                        <div><span class="text-gray-500">Est. Delivery:</span><br><span class="font-medium">${formatDate(order.deliveryDate)}</span></div>
                    </div>
                </div>
                
                <h3 class="font-semibold mb-3">Tracking Timeline</h3>
                <div class="space-y-0 max-h-96 overflow-y-auto">
                    ${order.trackingHistory && order.trackingHistory.length > 0 ? order.trackingHistory.map((event, idx) => {
                        const isLast = idx === order.trackingHistory.length - 1;
                        return `
                            <div class="timeline-step ${isLast && order.status === 'Delivered' ? 'completed' : ''} ${isLast && order.status !== 'Delivered' ? 'current' : 'completed'}">
                                <div class="font-medium text-sm">${event.status}</div>
                                <div class="text-xs text-gray-500">${event.date} • ${event.location}</div>
                                <div class="text-sm text-gray-600 mt-1">${event.description}</div>
                            </div>
                        `;
                    }).join('') : '<div class="text-center py-8 text-gray-500">Tracking information will appear once the order is processed.</div>'}
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel close-modal-btn">Close</button>
                <button id="refreshTrackingBtn" class="btn-submit bg-primary hover:bg-primary/90">Refresh Tracking</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(overlay);
    document.body.style.overflow = 'hidden';
    
    const closeModal = () => { overlay.remove(); document.body.style.overflow = ''; };
    overlay.querySelectorAll('.close-modal-btn').forEach(btn => btn.addEventListener('click', closeModal));
    overlay.addEventListener('click', (e) => { if (e.target === overlay) closeModal(); });
    
    overlay.querySelector('#refreshTrackingBtn')?.addEventListener('click', () => {
        showToast(`Refreshing tracking info for ${order.id}...`);
        setTimeout(() => showToast(`Tracking info updated for ${order.id}`), 1000);
    });
}

// ==================== EDIT ORDER MODAL ====================
function openEditOrderModal(order) {
    currentEditOrder = order;
    closeAllModals();
    
    const overlay = document.createElement('div');
    overlay.className = 'modal-overlay';
    overlay.innerHTML = `
        <div class="modal-container" style="max-width: 700px;">
            <div class="modal-header">
                <h2 class="modal-title">Edit Order ${order.id}</h2>
                <button class="modal-close close-modal-btn">&times;</button>
            </div>
            <div class="modal-body modal-body-scrollable">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9 22v-4h6v4"/></svg>
                    <h3 class="text-lg font-semibold">${order.supplier}</h3>
                </div>
                <div class="border rounded-md p-4">
                    <h4 class="font-medium mb-3">Order Items</h4>
                    <div id="editOrderItemsContainer">
                        <div class="grid grid-cols-12 gap-2 mb-2 order-item-row">
                            <div class="col-span-5"><input class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" placeholder="Item name" value="${escapeHtml(order.item)}" required></div>
                            <div class="col-span-2"><input type="number" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" placeholder="Qty" min="1" value="${order.quantity}" required></div>
                            <div class="col-span-2"><input type="text" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm item-price" placeholder="Unit price" value="${order.unitPrice.toFixed(2)}" required></div>
                            <div class="col-span-2"><input type="text" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm item-total bg-gray-50" placeholder="Total" value="$${order.amount.toFixed(2)}" disabled readonly></div>
                            <div class="col-span-1 flex items-center justify-center"><button type="button" class="remove-item-btn text-red-500 hover:text-red-700 text-lg">&times;</button></div>
                        </div>
                    </div>
                    <div class="flex justify-between mt-4">
                        <button type="button" id="editAddItemBtn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 h-9 px-3 text-sm">+ Add Item</button>
                        <div class="text-right">
                            <div class="text-sm text-gray-500">Total</div>
                            <div id="editOrderTotalDisplay" class="text-lg font-semibold">$${order.amount.toFixed(2)}</div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mt-4">
                    <div><label class="text-sm font-medium block mb-2">Expected Delivery</label><input type="date" id="editDeliveryDate" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" value="${order.deliveryDate}"></div>
                    <div><label class="text-sm font-medium block mb-2">Priority</label>
                        <div class="radix-select" id="editPrioritySelect">
                            <button type="button" class="radix-select-trigger" data-value="${order.priority}">
                                <span>${order.priority}</span>
                                <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                            </button>
                            <div class="radix-select-content hidden">
                                <div class="radix-select-item" data-value="Low" ${order.priority === 'Low' ? 'data-selected="true"' : ''}>Low<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>
                                <div class="radix-select-item" data-value="Normal" ${order.priority === 'Normal' ? 'data-selected="true"' : ''}>Normal<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>
                                <div class="radix-select-item" data-value="High" ${order.priority === 'High' ? 'data-selected="true"' : ''}>High<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>
                                <div class="radix-select-item" data-value="Urgent" ${order.priority === 'Urgent' ? 'data-selected="true"' : ''}>Urgent<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4"><label class="text-sm font-medium block mb-2">Notes</label><textarea id="editOrderNotes" rows="3" class="flex min-h-[80px] w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" placeholder="Additional instructions for this order"></textarea></div>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel close-modal-btn">Cancel</button>
                <button id="saveEditOrderBtn" class="btn-submit bg-primary hover:bg-primary/90">Save Changes</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(overlay);
    document.body.style.overflow = 'hidden';
    
    const closeModal = () => { overlay.remove(); document.body.style.overflow = ''; currentEditOrder = null; };
    overlay.querySelectorAll('.close-modal-btn').forEach(btn => btn.addEventListener('click', closeModal));
    overlay.addEventListener('click', (e) => { if (e.target === overlay) closeModal(); });
    
    // Initialize Radix select
    initRadixSelect(overlay.querySelector('#editPrioritySelect'));
    
    // Add item button
    overlay.querySelector('#editAddItemBtn')?.addEventListener('click', () => {
        const container = overlay.querySelector('#editOrderItemsContainer');
        const newRow = document.createElement('div');
        newRow.className = 'grid grid-cols-12 gap-2 mb-2 order-item-row';
        newRow.innerHTML = `
            <div class="col-span-5"><input class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" placeholder="Item name" required></div>
            <div class="col-span-2"><input type="number" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" placeholder="Qty" min="1" value="1" required></div>
            <div class="col-span-2"><input type="text" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm item-price" placeholder="Unit price" required></div>
            <div class="col-span-2"><input type="text" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm item-total bg-gray-50" placeholder="Total" disabled readonly></div>
            <div class="col-span-1 flex items-center justify-center"><button type="button" class="remove-item-btn text-red-500 hover:text-red-700 text-lg">&times;</button></div>
        `;
        container.appendChild(newRow);
        attachEditItemEvents(newRow, overlay);
    });
    
    // Attach events to existing row
    overlay.querySelectorAll('.order-item-row').forEach(row => attachEditItemEvents(row, overlay));
    
    // Save button
    overlay.querySelector('#saveEditOrderBtn')?.addEventListener('click', () => {
        const firstRow = overlay.querySelector('.order-item-row');
        const itemName = firstRow.querySelector('input[placeholder="Item name"]')?.value || order.item;
        const qty = parseInt(firstRow.querySelector('input[type="number"]')?.value) || order.quantity;
        const price = parseFloat(firstRow.querySelector('.item-price')?.value) || order.unitPrice;
        const priorityTrigger = overlay.querySelector('#editPrioritySelect .radix-select-trigger');
        const priority = priorityTrigger?.getAttribute('data-value') || order.priority;
        const deliveryDate = overlay.querySelector('#editDeliveryDate')?.value || order.deliveryDate;
        
        order.item = itemName;
        order.quantity = qty;
        order.unitPrice = price;
        order.amount = qty * price;
        order.priority = priority;
        order.deliveryDate = deliveryDate;
        
        renderTable();
        showToast(`Order ${order.id} updated successfully`);
        closeModal();
    });
}

function attachEditItemEvents(row, overlay) {
    const qtyInput = row.querySelector('input[type="number"]');
    const priceInput = row.querySelector('.item-price');
    const removeBtn = row.querySelector('.remove-item-btn');
    
    const calculateTotal = () => {
        let total = 0;s
        overlay.querySelectorAll('.order-item-row').forEach(r => {
            const qty = parseFloat(r.querySelector('input[type="number"]')?.value) || 0;
            const price = parseFloat(r.querySelector('.item-price')?.value) || 0;
            const itemTotal = qty * price;
            const totalInput = r.querySelector('.item-total');
            if (totalInput) totalInput.value = `$${itemTotal.toFixed(2)}`;
            total += itemTotal;
        });
        const display = overlay.querySelector('#editOrderTotalDisplay');
        if (display) display.textContent = `$${total.toFixed(2)}`;
    };
    
    if (qtyInput) qtyInput.addEventListener('input', calculateTotal);
    if (priceInput) priceInput.addEventListener('input', calculateTotal);
    if (removeBtn) removeBtn.addEventListener('click', () => { 
        if (overlay.querySelectorAll('.order-item-row').length > 1) {
            row.remove(); 
            calculateTotal(); 
        } else {
            showToast('Cannot remove the last item', true);
        }
    });
}

// ==================== CANCEL ORDER MODAL ====================
function openCancelOrderModal(order) {
    closeAllModals();
    
    const overlay = document.createElement('div');
    overlay.className = 'modal-overlay';
    overlay.innerHTML = `
        <div class="modal-container" style="max-width: 450px;">
            <div class="modal-header">
                <h2 class="modal-title">Cancel Order</h2>
                <button class="modal-close close-modal-btn">&times;</button>
            </div>
            <div class="modal-body">
                <div class="flex items-center gap-3 mb-4 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg">
                    <svg class="h-8 w-8 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                    <div>
                        <p class="font-semibold">Are you sure?</p>
                        <p class="text-sm text-gray-500">This action cannot be undone.</p>
                    </div>
                </div>
                <div class="space-y-3">
                    <div class="flex justify-between"><span class="text-sm text-gray-500">Order ID:</span><span class="font-mono font-medium">${order.id}</span></div>
                    <div class="flex justify-between"><span class="text-sm text-gray-500">Supplier:</span><span>${order.supplier}</span></div>
                    <div class="flex justify-between"><span class="text-sm text-gray-500">Item:</span><span>${order.item}</span></div>
                    <div class="flex justify-between"><span class="text-sm text-gray-500">Amount:</span><span class="font-semibold">$${order.amount.toFixed(2)}</span></div>
                    <div class="flex justify-between"><span class="text-sm text-gray-500">Current Status:</span><span class="status-badge ${getStatusClass(order.status)}">${order.status}</span></div>
                </div>
                <div class="mt-4">
                    <label class="text-sm font-medium block mb-2">Cancellation Reason</label>
                    <textarea id="cancelReason" rows="3" class="flex min-h-[80px] w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" placeholder="Please provide a reason for cancellation..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel close-modal-btn">Keep Order</button>
                <button id="confirmCancelBtn" class="btn-submit bg-red-600 hover:bg-red-700 text-white">Cancel Order</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(overlay);
    document.body.style.overflow = 'hidden';
    
    const closeModal = () => { overlay.remove(); document.body.style.overflow = ''; };
    overlay.querySelectorAll('.close-modal-btn').forEach(btn => btn.addEventListener('click', closeModal));
    overlay.addEventListener('click', (e) => { if (e.target === overlay) closeModal(); });
    
    overlay.querySelector('#confirmCancelBtn')?.addEventListener('click', () => {
        const reason = overlay.querySelector('#cancelReason')?.value || 'No reason provided';
        order.status = 'Cancelled';
        order.trackingHistory = [];
        renderTable();
        showToast(`Order ${order.id} has been cancelled`);
        closeModal();
    });
}

// ==================== CREATE ORDER MODAL ====================
function openCreateOrderModal() {
    closeAllModals();
    
    const overlay = document.createElement('div');
    overlay.className = 'modal-overlay';
    overlay.innerHTML = `
        <div class="modal-container" style="max-width: 700px;">
            <div class="modal-header">
                <h2 class="modal-title">Create New Order</h2>
                <button class="modal-close close-modal-btn">&times;</button>
            </div>
            <div class="modal-body modal-body-scrollable">
                <div class="grid gap-4">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9 22v-4h6v4"/></svg>
                        <div class="flex-1">
                            <label class="text-sm font-medium">Supplier *</label>
                            <select id="createSupplier" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm mt-1">
                                <option value="AAR Healthcare Supplies">AAR Healthcare Supplies</option>
                                <option value="HealthEquip Inc">HealthEquip Inc</option>
                                <option value="PharmaDirect">PharmaDirect</option>
                            </select>
                        </div>
                    </div>
                    <div class="border rounded-md p-4">
                        <h4 class="font-medium mb-3">Order Items</h4>
                        <div id="createOrderItemsContainer">
                            <div class="grid grid-cols-12 gap-2 mb-2 order-item-row">
                                <div class="col-span-5"><input class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" placeholder="Item name" required></div>
                                <div class="col-span-2"><input type="number" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" placeholder="Qty" min="1" value="1" required></div>
                                <div class="col-span-2"><input type="text" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm item-price" placeholder="Unit price" required></div>
                                <div class="col-span-2"><input type="text" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm item-total bg-gray-50" placeholder="Total" disabled readonly></div>
                                <div class="col-span-1 flex items-center justify-center"><button type="button" class="remove-item-btn text-red-500 hover:text-red-700 text-lg">&times;</button></div>
                            </div>
                        </div>
                        <div class="flex justify-between mt-4">
                            <button type="button" id="createAddItemBtn" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 h-9 px-3 text-sm">+ Add Item</button>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">Total</div>
                                <div id="createOrderTotalDisplay" class="text-lg font-semibold">$0.00</div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="text-sm font-medium block mb-2">Expected Delivery</label><input type="date" id="createDeliveryDate" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" value="${new Date(Date.now() + 7*86400000).toISOString().split('T')[0]}"></div>
                        <div><label class="text-sm font-medium block mb-2">Priority</label>
                            <div class="radix-select" id="createPrioritySelect">
                                <button type="button" class="radix-select-trigger" data-value="Normal">
                                    <span>Normal</span>
                                    <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                                </button>
                                <div class="radix-select-content hidden">
                                    <div class="radix-select-item" data-value="Low">Low<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>
                                    <div class="radix-select-item" data-value="Normal" data-selected="true">Normal<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>
                                    <div class="radix-select-item" data-value="High">High<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>
                                    <div class="radix-select-item" data-value="Urgent">Urgent<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div><label class="text-sm font-medium block mb-2">Notes</label><textarea id="createOrderNotes" rows="3" class="flex min-h-[80px] w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" placeholder="Additional instructions for this order"></textarea></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel close-modal-btn">Cancel</button>
                <button id="confirmCreateOrderBtn" class="btn-submit bg-primary hover:bg-primary/90">Place Order</button>
            </div>
        </div>
    `;
    
    document.body.appendChild(overlay);
    document.body.style.overflow = 'hidden';
    
    const closeModal = () => { overlay.remove(); document.body.style.overflow = ''; };
    overlay.querySelectorAll('.close-modal-btn').forEach(btn => btn.addEventListener('click', closeModal));
    overlay.addEventListener('click', (e) => { if (e.target === overlay) closeModal(); });
    
    initRadixSelect(overlay.querySelector('#createPrioritySelect'));
    
    const calculateCreateTotal = () => {
        let total = 0;
        overlay.querySelectorAll('.order-item-row').forEach(r => {
            const qty = parseFloat(r.querySelector('input[type="number"]')?.value) || 0;
            const price = parseFloat(r.querySelector('.item-price')?.value) || 0;
            const itemTotal = qty * price;
            const totalInput = r.querySelector('.item-total');
            if (totalInput) totalInput.value = `$${itemTotal.toFixed(2)}`;
            total += itemTotal;
        });
        const display = overlay.querySelector('#createOrderTotalDisplay');
        if (display) display.textContent = `$${total.toFixed(2)}`;
    };
    
    overlay.querySelectorAll('.order-item-row').forEach(row => {
        row.querySelector('input[type="number"]')?.addEventListener('input', calculateCreateTotal);
        row.querySelector('.item-price')?.addEventListener('input', calculateCreateTotal);
        row.querySelector('.remove-item-btn')?.addEventListener('click', () => {
            if (overlay.querySelectorAll('.order-item-row').length > 1) {
                row.remove();
                calculateCreateTotal();
            }
        });
    });
    
    overlay.querySelector('#createAddItemBtn')?.addEventListener('click', () => {
        const container = overlay.querySelector('#createOrderItemsContainer');
        const newRow = document.createElement('div');
        newRow.className = 'grid grid-cols-12 gap-2 mb-2 order-item-row';
        newRow.innerHTML = `
            <div class="col-span-5"><input class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" placeholder="Item name" required></div>
            <div class="col-span-2"><input type="number" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm" placeholder="Qty" min="1" value="1" required></div>
            <div class="col-span-2"><input type="text" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm item-price" placeholder="Unit price" required></div>
            <div class="col-span-2"><input type="text" class="flex h-10 w-full rounded-md border border-gray-300 bg-white dark:bg-gray-800 px-3 py-2 text-sm item-total bg-gray-50" placeholder="Total" disabled readonly></div>
            <div class="col-span-1 flex items-center justify-center"><button type="button" class="remove-item-btn text-red-500 hover:text-red-700 text-lg">&times;</button></div>
        `;
        container.appendChild(newRow);
        newRow.querySelector('input[type="number"]')?.addEventListener('input', calculateCreateTotal);
        newRow.querySelector('.item-price')?.addEventListener('input', calculateCreateTotal);
        newRow.querySelector('.remove-item-btn')?.addEventListener('click', () => {
            if (overlay.querySelectorAll('.order-item-row').length > 1) {
                newRow.remove();
                calculateCreateTotal();
            }
        });
    });
    
    overlay.querySelector('#confirmCreateOrderBtn')?.addEventListener('click', () => {
        const supplier = overlay.querySelector('#createSupplier')?.value || 'Unknown';
        const firstRow = overlay.querySelector('.order-item-row');
        const itemName = firstRow?.querySelector('input[placeholder="Item name"]')?.value;
        if (!itemName) { showToast('Please enter an item name', true); return; }
        
        const qty = parseInt(firstRow.querySelector('input[type="number"]')?.value) || 1;
        const price = parseFloat(firstRow.querySelector('.item-price')?.value) || 0;
        const priorityTrigger = overlay.querySelector('#createPrioritySelect .radix-select-trigger');
        const priority = priorityTrigger?.getAttribute('data-value') || 'Normal';
        const deliveryDate = overlay.querySelector('#createDeliveryDate')?.value || '';
        
        const newId = `PO-${Math.floor(Math.random() * 9000 + 2000)}`;
        const newOrder = {
            id: newId, supplier, item: itemName, quantity: qty, unitPrice: price, amount: qty * price,
            orderDate: new Date().toISOString().split('T')[0], deliveryDate,
            status: 'Pending', priority, trackingNumber: 'TBD', carrier: 'TBD', trackingHistory: []
        };
        ordersData.unshift(newOrder);
        renderTable();
        showToast(`Order ${newId} created successfully`);
        closeModal();
    });
}

// ==================== RADIX SELECT INIT ====================
function initRadixSelect(selectElement) {
    if (!selectElement) return;
    const trigger = selectElement.querySelector('.radix-select-trigger');
    const content = selectElement.querySelector('.radix-select-content');
    const items = selectElement.querySelectorAll('.radix-select-item');
    
    trigger?.addEventListener('click', (e) => {
        e.stopPropagation();
        document.querySelectorAll('.radix-select-content').forEach(c => { if (c !== content) c.classList.add('hidden'); });
        content?.classList.toggle('hidden');
    });
    
    items.forEach(item => {
        item.addEventListener('click', (e) => {
            e.stopPropagation();
            const value = item.getAttribute('data-value');
            const label = item.textContent.replace(/<svg[\s\S]*?<\/svg>/g, '').trim();
            if (trigger) {
                trigger.querySelector('span').textContent = label;
                trigger.setAttribute('data-value', value);
            }
            items.forEach(i => i.setAttribute('data-selected', 'false'));
            item.setAttribute('data-selected', 'true');
            content?.classList.add('hidden');
        });
    });
    
    document.addEventListener('click', (e) => {
        if (!selectElement.contains(e.target)) content?.classList.add('hidden');
    });
}

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

function closeAllModals() {
    document.querySelectorAll('.modal-overlay').forEach(m => m.remove());
    document.body.style.overflow = '';
    closeActionMenu();
}

// ==================== FILTERING ====================
function filterOrders() {
    let filtered = [...ordersData];
    const search = currentFilters.search.toLowerCase();
    if (search) filtered = filtered.filter(o => o.id.toLowerCase().includes(search) || o.supplier.toLowerCase().includes(search) || o.item.toLowerCase().includes(search));
    if (currentFilters.status !== 'all') filtered = filtered.filter(o => o.status === currentFilters.status);
    const now = new Date();
    const todayStart = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    if (currentFilters.dateRange === 'today') filtered = filtered.filter(o => new Date(o.orderDate) >= todayStart);
    else if (currentFilters.dateRange === 'week') { const weekStart = new Date(now); weekStart.setDate(now.getDate() - now.getDay()); filtered = filtered.filter(o => new Date(o.orderDate) >= weekStart); }
    else if (currentFilters.dateRange === 'month') { const monthStart = new Date(now.getFullYear(), now.getMonth(), 1); filtered = filtered.filter(o => new Date(o.orderDate) >= monthStart); }
    return filtered;
}

// ==================== STATS ====================
function updateStats() {
    const total = ordersData.length;
    const active = ordersData.filter(o => o.status === 'Processing' || o.status === 'Shipped' || o.status === 'Pending').length;
    const delivered = ordersData.filter(o => o.status === 'Delivered').length;
    const totalValue = ordersData.reduce((sum, o) => sum + o.amount, 0);
    document.getElementById('statsContainer').innerHTML = `
        <div class="rounded-lg border bg-card p-4 shadow-sm"><div class="flex items-center justify-between"><div><div class="text-sm font-medium text-gray-500">Total Orders</div><div class="text-2xl font-bold mt-1">${total}</div></div><svg class="w-8 h-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z"/><path d="M12 22V12"/></svg></div><p class="text-xs text-gray-400 mt-2">+12% from last month</p></div>
        <div class="rounded-lg border bg-card p-4 shadow-sm"><div class="flex items-center justify-between"><div><div class="text-sm font-medium text-gray-500">Active Orders</div><div class="text-2xl font-bold mt-1">${active}</div></div><svg class="w-8 h-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div><p class="text-xs text-gray-400 mt-2">Processing: ${ordersData.filter(o=>o.status==='Processing').length} | Shipped: ${ordersData.filter(o=>o.status==='Shipped').length}</p></div>
        <div class="rounded-lg border bg-card p-4 shadow-sm"><div class="flex items-center justify-between"><div><div class="text-sm font-medium text-gray-500">Delivered</div><div class="text-2xl font-bold mt-1">${delivered}</div></div><svg class="w-8 h-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg></div><p class="text-xs text-gray-400 mt-2">On-time delivery rate: 92%</p></div>
        <div class="rounded-lg border bg-card p-4 shadow-sm"><div class="flex items-center justify-between"><div><div class="text-sm font-medium text-gray-500">Total Value</div><div class="text-2xl font-bold mt-1">$${totalValue.toLocaleString()}</div></div><svg class="w-8 h-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 7H7M17 17H7"/></svg></div><p class="text-xs text-gray-400 mt-2">Avg order: $${(totalValue/total).toFixed(2)}</p></div>
    `;
}

// ==================== RENDER TABLE ====================
function renderTable() {
    const filtered = filterOrders();
    const tbody = document.getElementById('ordersTableBody');
    const noResults = document.getElementById('noResultsMsg');
    
    if (filtered.length === 0) { 
        tbody.innerHTML = ''; 
        noResults?.classList.remove('hidden'); 
        updateStats(); 
        return; 
    }
    
    noResults?.classList.add('hidden');
    tbody.innerHTML = filtered.map(order => `
        <tr class="border-b hover:bg-gray-50 transition">
            <td class="p-4 align-middle font-mono font-medium">${order.id}</td>
            <td class="p-4 align-middle">${order.supplier}</td>
            <td class="p-4 align-middle">${order.item}</td>
            <td class="p-4 align-middle">${order.quantity}</td>
            <td class="p-4 align-middle font-medium">$${order.amount.toFixed(2)}</td>
            <td class="p-4 align-middle">${formatDate(order.orderDate)}</td>
            <td class="p-4 align-middle"><span class="status-badge ${getStatusClass(order.status)}">${order.status}</span></td>
            <td class="p-4 align-middle text-center">
                <button class="action-trigger inline-flex h-8 w-8 items-center justify-center rounded-md hover:bg-gray-100" data-order-id="${order.id}">
                    <svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                </button>
            </td>
        </tr>
    `).join('');
    
    updateStats();
    
    document.querySelectorAll('.action-trigger').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const orderId = btn.getAttribute('data-order-id');
            const order = ordersData.find(o => o.id === orderId);
            if (order) showActionMenu(btn, order);
        });
    });
}

// ==================== FILTER INIT ====================
// ==================== FILTER INIT ====================
function initSelect(triggerId, dropdownId, onSelect) {
    const trigger = document.getElementById(triggerId);
    const dropdown = document.getElementById(dropdownId);
    if (!trigger || !dropdown) return;
    
    trigger.addEventListener('click', (e) => { 
        e.stopPropagation();
        // Close other dropdowns
        document.querySelectorAll('#statusFilterDropdown, #dateFilterDropdown').forEach(d => {
            if (d !== dropdown) d.classList.add('hidden');
        });
        dropdown.classList.toggle('hidden');
        
        // Position the dropdown
        const rect = trigger.getBoundingClientRect();
        dropdown.style.position = 'fixed';
        dropdown.style.top = `${rect.bottom + 4}px`;
        dropdown.style.left = `${rect.left}px`;
        dropdown.style.width = `${rect.width}px`;
        dropdown.style.zIndex = '100';
    });
    
    dropdown.querySelectorAll('div[data-status], div[data-date]').forEach(item => {
        item.addEventListener('click', () => { 
            const val = item.getAttribute('data-status') || item.getAttribute('data-date'); 
            const text = item.innerText; 
            if (triggerId === 'statusFilterBtn') {
                document.getElementById('statusFilterText').innerText = text;
            } else {
                document.getElementById('dateFilterText').innerText = text; 
            }
            if (onSelect) onSelect(val); 
            dropdown.classList.add('hidden'); 
        });
    });
}

initSelect('statusFilterBtn', 'statusFilterDropdown', (val) => { 
    currentFilters.status = val; 
    renderTable(); 
});

initSelect('dateFilterBtn', 'dateFilterDropdown', (val) => { 
    currentFilters.dateRange = val; 
    renderTable(); 
});

// Close dropdowns when clicking outside
document.addEventListener('click', (e) => {
    if (!e.target.closest('#statusFilterBtn') && !e.target.closest('#statusFilterDropdown')) {
        document.getElementById('statusFilterDropdown')?.classList.add('hidden');
    }
    if (!e.target.closest('#dateFilterBtn') && !e.target.closest('#dateFilterDropdown')) {
        document.getElementById('dateFilterDropdown')?.classList.add('hidden');
    }
});


// ==================== EVENT LISTENERS ====================
document.getElementById('searchInput')?.addEventListener('input', (e) => { 
    currentFilters.search = e.target.value; 
    renderTable(); 
});document.getElementById('createOrderBtn')?.addEventListener('click', openCreateOrderModal);

document.addEventListener('click', (e) => { 
    if (!e.target.closest('.radix-select') && !e.target.closest('.radix-dropdown-menu')) {
        document.querySelectorAll('.radix-dropdown-menu').forEach(menu => menu.classList.add('hidden'));
    }
});

document.addEventListener('keydown', (e) => { 
    if (e.key === 'Escape') { 
        closeActionMenu(); 
        document.querySelectorAll('.modal-overlay').forEach(m => m.remove());
        document.body.style.overflow = '';
    } 
});

window.addEventListener('scroll', () => closeActionMenu());

// ==================== INIT ====================
renderTable();
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
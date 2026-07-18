<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Physiotherapy Schedule</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .bg-background, body.dark .modal-container { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700, body.dark .text-muted-foreground { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted, body.dark .bg-gray-50 { background-color: #262626 !important; }
        body.dark .border-gray-200, body.dark .border-gray-300 { border-color: #404040 !important; }
        body.dark input, body.dark select, body.dark textarea { background-color: #262626 !important; border-color: #404040 !important; color: #e5e5e5 !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        [role="tabpanel"][data-state="inactive"] { display: none; }
        [role="tabpanel"][data-state="active"] { display: block; animation: fadeIn 0.2s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }

        .tab-btn.active { background-color: white !important; color: #1f2937 !important; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        body.dark .tab-btn.active { background-color: #2a2a2a !important; color: #e5e5e5 !important; }

        .toast-message { position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white; padding: 12px 20px; border-radius: 8px; z-index: 1200; animation: slideIn 0.3s ease-out; font-size: 0.875rem; }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        .action-menu { position: fixed; z-index: 1000; background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); min-width: 210px; padding: 0.25rem; animation: fadeIn 0.12s ease-out; }
        body.dark .action-menu { background: #2a2a2a; border-color: #404040; }
        .action-menu-header { padding: 0.5rem 0.75rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb; margin-bottom: 0.25rem; }
        body.dark .action-menu-header { color: #9ca3af; border-bottom-color: #404040; }
        .action-item { display: flex; align-items: center; gap: 0.5rem; width: 100%; padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer; border-radius: 0.375rem; transition: background 0.1s; border: none; background: none; text-align: left; color: inherit; }
        .action-item:hover { background-color: #f3f4f6; }
        body.dark .action-item:hover { background-color: #3f3f46; }
        .action-item.text-red { color: #ef4444; }
        .action-item.text-red:hover { background-color: #fef2f2; }
        body.dark .action-item.text-red:hover { background-color: #450a0a; }
        .action-divider { height: 1px; background: #e5e7eb; margin: 0.25rem 0; }
        body.dark .action-divider { background: #404040; }

        .modal-overlay { 
    position: fixed; 
    inset: 0; 
    z-index: 9999; 
    background: rgba(0,0,0,0.6); 
    backdrop-filter: blur(4px); 
    display: none; 
    align-items: center; 
    justify-content: center; 
    animation: fadeIn 0.15s ease-out; 
}
        .modal-container { background: white; border-radius: 0.75rem; box-shadow: 0 20px 60px rgba(0,0,0,0.2); width: 90%; max-width: 650px; max-height: 85vh; overflow-y: auto; animation: modalSlide 0.2s ease-out; }
        @keyframes modalSlide { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        body.dark .modal-container { background: #131212; border: 1px solid #333; }

        .select-trigger { display: flex; align-items: center; justify-content: space-between; width: 100%; height: 40px; border: 1px solid #d1d5db; background-color: white; padding: 0 0.75rem; font-size: 0.875rem; cursor: pointer; border-radius: 0.375rem; }
        body.dark .select-trigger { background-color: #131212; border-color: #404040; color: #e5e5e5; }
        .select-dropdown { position: absolute; z-index: 50; background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); margin-top: 4px; min-width: 100%; max-height: 200px; overflow-y: auto; }
        body.dark .select-dropdown { background: #2a2a2a; border-color: #404040; }
        .select-item { padding: 0.5rem 0.75rem; cursor: pointer; font-size: 0.875rem; transition: background 0.1s; }
        .select-item:hover { background-color: #f3f4f6; }
        body.dark .select-item:hover { background-color: #3f3f46; }


.alert-dialog {
    position: relative;
    z-index: 10000;
    background: white;
    border-radius: 0.75rem;
    border: 1px solid #e5e7eb;
    padding: 1.5rem;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    animation: modalSlideIn 0.2s ease-out;
}
body.dark .alert-dialog {
    background: #1e1e1e;
    border-color: #333;
}
.alert-dialog-header {
    margin-bottom: 1rem;
}
.alert-dialog-title {
    font-size: 1.125rem;
    font-weight: 600;
    margin: 0 0 0.5rem 0;
    color: #1f2937;
}
body.dark .alert-dialog-title {
    color: #e5e5e5;
}
.alert-dialog-description {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
    line-height: 1.5;
}
body.dark .alert-dialog-description {
    color: #9ca3af;
}
.alert-dialog-footer {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    padding-top: 0.5rem;
}
.alert-dialog-cancel {
    background: transparent;
    border: 1px solid #d1d5db;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    cursor: pointer;
    font-size: 0.875rem;
    color: #374151;
    transition: background 0.15s;
}
.alert-dialog-cancel:hover {
    background: #f3f4f6;
}
body.dark .alert-dialog-cancel {
    border-color: #555;
    color: #e5e5e5;
}
body.dark .alert-dialog-cancel:hover {
    background: #374151;
}
.alert-dialog-confirm {
    background: #ef4444;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    cursor: pointer;
    font-size: 0.875rem;
    transition: background 0.15s;
}
.alert-dialog-confirm:hover {
    background: #dc2626;
}
@keyframes modalSlideIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}
        .session-card { border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 0.75rem; cursor: pointer; transition: all 0.15s; }
        .session-card:hover { border-color: #6366f1; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        body.dark .session-card { border-color: #404040; }
        .session-card .time-badge { display: inline-flex; align-items: center; padding: 0.125rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
        .session-card.type-initial { border-left: 3px solid #3b82f6; }
        .session-card.type-followup { border-left: 3px solid #10b981; }
        .session-card.type-manual { border-left: 3px solid #8b5cf6; }
        .session-card.type-rehab { border-left: 3px solid #f59e0b; }
        .session-card.type-discharge { border-left: 3px solid #6b7280; }

        .calendar-day { width: 100%; aspect-ratio: 1; border-radius: 0.5rem; cursor: pointer; transition: all 0.15s; display: flex; flex-direction: column; align-items: center; justify-content: center; font-size: 0.875rem; position: relative; }
        .calendar-day:hover { background: #f3f4f6; }
        body.dark .calendar-day:hover { background: #262626; }
        .calendar-day.today { background: #eef2ff; font-weight: 700; color: #4f46e5; }
        body.dark .calendar-day.today { background: #1e1b4b; color: #818cf8; }
        .calendar-day.selected { background: #4f46e5; color: white; }
        .calendar-day.has-sessions::after { content: ''; position: absolute; bottom: 4px; width: 6px; height: 6px; border-radius: 50%; background: #4f46e5; }
        .calendar-day.selected.has-sessions::after { background: white; }
        .calendar-day-header { font-size: 0.75rem; color: #6b7280; font-weight: 500; text-align: center; padding: 0.5rem 0; }

        .schedule-tab { padding: 0.375rem 0.75rem; font-size: 0.8125rem; font-weight: 500; border-radius: 0.25rem; cursor: pointer; transition: all 0.15s; background: transparent; border: none; color: #6b7280; }
        .schedule-tab.active { background: white; color: #1f2937; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        body.dark .schedule-tab.active { background: #2a2a2a; color: #e5e5e5; }

                .schedule-view { display: none; }
        .schedule-view:not(.hidden) { display: block; }
        .month-day-cell { min-height: 100px; border: 1px solid #e5e7eb; border-radius: 0.375rem; padding: 0.25rem; cursor: pointer; transition: all 0.15s; }
        .month-day-cell:hover { border-color: #6366f1; }
        body.dark .month-day-cell { border-color: #404040; }
        .month-day-cell.today { border-width: px; }
        .month-day-cell.selected { background: #eef2ff; border-color: #4f46e5; }
        body.dark .month-day-cell.selected { background: #1e1b4b; }
        .month-day-number { font-size: 0.75rem; font-weight: 500; margin-bottom: 0.25rem; }
        .month-events-container { display: flex; flex-direction: column; gap: 1px; }
        .month-event { font-size: 0.625rem; padding: 1px 4px; border-radius: 3px; cursor: pointer; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .month-event.scheduled { background: #dbeafe; color: #1d4ed8; }
        .month-event.completed { background: #d1fae5; color: #065f46; }
        .month-event.in-progress { background: #fef3c7; color: #92400e; }
        .month-event.cancelled { background: #fee2e2; color: #991b1b; }
        .month-event.no-show { background: #f3f4f6; color: #6b7280; }
        body.dark .month-event.scheduled { background: #1e3a5f; color: #93c5fd; }
        body.dark .month-event.completed { background: #064e3b; color: #6ee7b7; }
        body.dark .month-event.in-progress { background: #451a03; color: #fcd34d; }
        body.dark .month-event.cancelled { background: #450a0a; color: #fca5a5; }
        body.dark .month-event.no-show { background: #262626; color: #9ca3af; }
        .month-event.more-events { background: #f3f4f6; color: #6b7280; text-align: center; cursor: pointer; }
        body.dark .month-event.more-events { background: #262626; color: #9ca3af; }

        /* Ensure month calendar grid works properly in 2-column layout */
.month-calendar {
    display: grid;
    gap: 2px;
    grid-template-columns: repeat(7, 1fr);
}
.month-day-cell {
    min-height: 100px;
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    padding: 0.25rem;
    cursor: pointer;
    transition: all 0.15s;
}
.month-day-cell:hover { border-color: #6366f1; }
body.dark .month-day-cell { border-color: #404040; }
.month-day-cell.today { border-color: #6366f1; border-width: 2px; }
.month-day-cell.selected { background: #eef2ff; border-color: #4f46e5; }
body.dark .month-day-cell.selected { background: #1e1b4b; }
.month-day-number { font-size: 0.75rem; font-weight: 500; margin-bottom: 0.25rem; }
.month-events-container { display: flex; flex-direction: column; gap: 1px; }

/* Session card styling for right sidebar */
.session-card { 
    border: 1px solid #e5e7eb; 
    border-radius: 0.5rem; 
    padding: 0.75rem; 
    cursor: pointer; 
    transition: all 0.15s; 
}
.session-card:hover { border-color: #6366f1; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
.session-card .time-badge { display: inline-flex; align-items: center; padding: 0.125rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; }
.session-card.type-initial { border-left: 3px solid #3b82f6; }
.session-card.type-followup { border-left: 3px solid #10b981; }
.session-card.type-manual { border-left: 3px solid #8b5cf6; }
.session-card.type-rehab { border-left: 3px solid #f59e0b; }
.session-card.type-discharge { border-left: 3px solid #6b7280; }

#cancelModalOverlay {
    position: fixed;
    inset: 0;
    background-color: rgb(0 0 0 / 87%);
    backdrop-filter: blur(4px);
    z-index: 11000; /* Higher than the Session Details modal */
    display: none; /* Controlled by JS flex */
    align-items: center;
    justify-content: center;
}

#cancelModal {
    /* Remove any absolute positioning or top/left 50% from #cancelModal 
       The flex parent above handles centering now */
    position: relative;
    transform: none; 
    left: auto;
    top: auto;
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
        <div class="flex flex-col gap-6">
            <div class="flex items-center justify-between flex-wrap gap-4">
                <div><h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Physiotherapy Schedule</h1><p class="text-gray-500">Manage therapy sessions, therapist availability, and room assignments</p></div>
                <div class="flex gap-2">
                    <a href="add-physiotherapy-session.html" class="inline-flex items-center gap-2 rounded-md bg-primary text-white px-4 py-2 text-sm hover:bg-primary/90"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>New Session</a>
                    <button id="refreshBtn" class="inline-flex items-center gap-2 rounded-md border px-3 py-2 text-sm hover:bg-accent"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>Refresh</button>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg text-card-foreground p-4 border bg-background shadow-sm hover:shadow-md transition"><div class="flex justify-between"><span class="text-sm font-medium text-gray-500">Total Sessions Today</span><div class="bg-blue-100 p-1.5 rounded-lg"><svg class="h-5 w-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg></div></div><div class="text-2xl font-bold mt-2">28</div><p class="text-xs text-gray-500 mt-1">8 completed · 12 scheduled · 8 in progress</p></div>
                <div class="rounded-lg text-card-foreground p-4 border bg-background shadow-sm hover:shadow-md transition"><div class="flex justify-between"><span class="text-sm font-medium text-gray-500">Available Slots</span><div class="bg-green-100 p-1.5 rounded-lg"><svg class="h-5 w-5 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg></div></div><div class="text-2xl font-bold mt-2">6</div><p class="text-xs text-gray-500 mt-1">3 morning · 3 afternoon</p></div>
                <div class="rounded-lg text-card-foreground p-4 border bg-background shadow-sm hover:shadow-md transition"><div class="flex justify-between"><span class="text-sm font-medium text-gray-500">Room Utilization</span><div class="bg-purple-100 p-1.5 rounded-lg"><svg class="h-5 w-5 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/></svg></div></div><div class="text-2xl font-bold mt-2">82%</div><p class="text-xs text-gray-500 mt-1">4 of 5 rooms occupied</p></div>
                <div class="rounded-lg text-card-foreground p-4 border bg-background shadow-sm hover:shadow-md transition"><div class="flex justify-between"><span class="text-sm font-medium text-gray-500">No-Shows This Week</span><div class="bg-red-100 p-1.5 rounded-full"><svg class="h-5 w-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></div></div><div class="text-2xl font-bold mt-2">3</div><p class="text-xs text-green-500 mt-1">↓ 2 from last week</p></div>
            </div>

            <div class="w-full">
                <div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-muted p-1 text-muted-foreground mb-4">
                    <button type="button" data-tab="calendar" class="tab-btn inline-flex rounded-sm px-3 py-1.5 text-sm font-medium active">Calendar View</button>
                    <button type="button" data-tab="list" class="tab-btn inline-flex rounded-sm px-3 py-1.5 text-sm font-medium">List View</button>
                    <button type="button" data-tab="rooms" class="tab-btn inline-flex rounded-sm px-3 py-1.5 text-sm font-medium">Room View</button>
                </div>

<!-- Calendar View Tab - 2 Column Layout with Right Sidebar -->
<div id="tab-calendar" role="tabpanel" data-state="active" class="mt-4 space-y-6">
    <div class="flex justify-between items-center flex-wrap gap-3">
        <div class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1">
            <button data-cal-tab="day" class="schedule-tab inline-flex items-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all text-gray-600 hover:text-gray-900">Day</button>
            <button data-cal-tab="week" class="schedule-tab inline-flex items-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all text-gray-600 hover:text-gray-900">Week</button>
            <button data-cal-tab="month" class="schedule-tab inline-flex items-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all active bg-white text-indigo-700 shadow-sm">Month</button>
            <button data-cal-tab="list" class="schedule-tab inline-flex items-center rounded-sm px-3 py-1.5 text-sm font-medium transition-all text-gray-600 hover:text-gray-900">List</button>
        </div>
        <div class="flex items-center gap-2">
            <button id="prevDateBtn" class="border border-gray-300 bg-background hover:bg-accent h-10 size-10 rounded-md shadow-sm flex items-center justify-center"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg></button>
            <div id="currentDateDisplay" class="text-sm font-medium min-w-[120px] text-center">June 2026</div>
            <button id="nextDateBtn" class="border border-gray-300 bg-background hover:bg-accent h-10 size-10 rounded-md shadow-sm flex items-center justify-center"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 18 6-6-6-6"/></svg></button>
            <button id="todayBtn" class="border border-gray-300 bg-background hover:bg-accent h-10 px-3 py-2 text-sm rounded-md shadow-sm">Today</button>
        </div>
    </div>
    
    <!-- 2-COLUMN LAYOUT: Calendar Grid + Right Sidebar -->
    <div class="grid gap-6 lg:grid-cols-3">
        <!-- Left Column: Calendar Views -->
        <div class="lg:col-span-2 border rounded-lg bg-background p-4">
            <!-- Day View -->
            <div id="view-day" class="schedule-view hidden"><div class="space-y-3" id="daySchedule"><div class="text-center py-8 text-gray-400"><svg class="h-12 w-12 mx-auto mb-3 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg><p class="font-medium">No appointments for this day</p><p class="text-sm">Select another date or schedule a session</p></div></div></div>
            <!-- Week View -->
            <div id="view-week" class="schedule-view hidden"><div class="overflow-x-auto"><div class="min-w-[700px]"><div class="grid grid-cols-7 gap-2 mb-3" id="weekHeader"></div><div class="space-y-2" id="weekSchedule"></div></div></div></div>
            <!-- Month View -->
            <div id="view-month" class="schedule-view"><div id="monthCalendarGrid"></div></div>
            <!-- List View -->
            <div id="view-list" class="schedule-view hidden"><div class="space-y-2" id="listSchedule"></div></div>
        </div>
        
        <!-- Right Column: Selected Date Appointments Sidebar -->
        <div class="border rounded-lg bg-background p-4">
            <h3 class="font-semibold mb-3" id="selectedDateLabel">Sunday, 06/14/2026</h3>
            <div class="space-y-2" id="dayAppointments"></div>
            <p class="text-sm text-gray-400 text-center py-4 hidden" id="noAppointmentsMsg">No sessions on this date</p>
        </div>
    </div>
</div>

                <!-- List View Tab -->
                <div id="tab-list" role="tabpanel" data-state="inactive" class="mt-4 space-y-6">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center flex-wrap">
                        <div class="relative flex-1 min-w-[260px]"><svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg><input id="sessionSearch" type="search" placeholder="Search by patient, therapist, or condition..." class="h-10 w-full rounded-md border border-gray-300 pl-8 pr-3 text-sm"></div>
                        <div class="flex gap-2 flex-wrap">
                            <div class="relative"><button id="typeFilterBtn" class="select-trigger w-[170px]"><span id="typeFilterText">All Types</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="typeFilterDropdown" class="hidden select-dropdown"><div class="select-item" data-value="all">All Types</div><div class="select-item" data-value="Initial Assessment">Initial Assessment</div><div class="select-item" data-value="Follow-up">Follow-up</div><div class="select-item" data-value="Manual Therapy">Manual Therapy</div><div class="select-item" data-value="Rehab">Rehab</div><div class="select-item" data-value="Discharge">Discharge</div></div></div>
                            <div class="relative"><button id="statusFilterBtn" class="select-trigger w-[150px]"><span id="statusFilterText">All Status</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="statusFilterDropdown" class="hidden select-dropdown"><div class="select-item" data-value="all">All Status</div><div class="select-item" data-value="Scheduled">Scheduled</div><div class="select-item" data-value="In Progress">In Progress</div><div class="select-item" data-value="Completed">Completed</div><div class="select-item" data-value="No-Show">No-Show</div><div class="select-item" data-value="Cancelled">Cancelled</div></div></div>
                            <div class="relative"><button id="therapistFilterBtn" class="select-trigger w-[170px]"><span id="therapistFilterText">All Therapists</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="therapistFilterDropdown" class="hidden select-dropdown"><div class="select-item" data-value="all">All Therapists</div><div class="select-item" data-value="Dr. Nakato Sarah">Dr. Nakato Sarah</div><div class="select-item" data-value="Dr. Mwangi Peter">Dr. Mwangi Peter</div><div class="select-item" data-value="Namyalo Emma">Namyalo Emma</div><div class="select-item" data-value="Dr. Okello James">Dr. Okello James</div></div></div>
                        </div>
                    </div>
                    <div class="rounded-lg border bg-white overflow-x-auto">
                        <table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr><th class="h-10 px-4 text-left">Date & Time</th><th class="h-10 px-4 text-left">Patient</th><th class="h-10 px-4 text-left">Therapist</th><th class="h-10 px-4 text-left">Type</th><th class="h-10 px-4 text-left hidden md:table-cell">Room</th><th class="h-10 px-4 text-left hidden md:table-cell">Duration</th><th class="h-10 px-4 text-left">Status</th><th class="h-10 px-4 text-right">Actions</th></tr></thead><tbody id="sessionsTableBody"></tbody></table>
                        <div class="mt-4 flex items-center justify-between p-4" id="sessionPagination"></div>
                    </div>
                </div>

                <!-- Room View Tab -->
                <div id="tab-rooms" role="tabpanel" data-state="inactive" class="mt-4 space-y-6">
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3" id="roomCards"></div>
                </div>
            </div>
        </div>
        <!-- Progress Note Modal -->
<div id="progressNoteModal" style="display:none;" class="modal-overlay">
    <div class="modal-container" style="max-width:550px;">
        <div class="flex justify-between items-start mb-4 p-6 pb-0">
            <div><h3 class="text-lg font-semibold">Add Progress Note</h3><p class="text-gray-500" id="progressNotePatient"></p></div>
            <button id="closeProgressNoteBtn" class="text-gray-400 hover:text-gray-600"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
        </div>
        <div class="p-6 pt-2 space-y-4">
            <div><label class="text-sm font-medium block mb-1">Note Type</label>
                <div class="radix-select" id="noteTypeSelect">
                    <button type="button" class="radix-select-trigger"><span>Progress Note</span><svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button>
                    <div class="radix-select-content hidden">
                        <div class="radix-select-item" data-value="Progress Note" data-selected="true">Progress Note<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div>
                        <div class="radix-select-item" data-value="Phone Call">Phone Call</div>
                        <div class="radix-select-item" data-value="Assessment">Assessment</div>
                        <div class="radix-select-item" data-value="Other">Other</div>
                    </div>
                </div>
            </div>
            <div><label class="text-sm font-medium block mb-1">Notes</label><textarea id="progressNotes" rows="4" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Enter progress notes..."></textarea></div>
            <div>
                <label class="text-sm font-medium block mb-2">Pain Level (0-10)</label>
                <div class="flex gap-1 flex-wrap" id="progressPainScale">
                    <button type="button" class="w-9 h-9 rounded-md border-2 border-gray-200 text-sm font-semibold hover:border-indigo-400 transition" data-value="0">0</button>
                    <button type="button" class="w-9 h-9 rounded-md border-2 border-gray-200 text-sm font-semibold hover:border-indigo-400 transition" data-value="1">1</button>
                    <button type="button" class="w-9 h-9 rounded-md border-2 border-gray-200 text-sm font-semibold hover:border-indigo-400 transition" data-value="2">2</button>
                    <button type="button" class="w-9 h-9 rounded-md border-2 border-gray-200 text-sm font-semibold hover:border-indigo-400 transition" data-value="3">3</button>
                    <button type="button" class="w-9 h-9 rounded-md border-2 border-gray-200 text-sm font-semibold hover:border-indigo-400 transition" data-value="4">4</button>
                    <button type="button" class="w-9 h-9 rounded-md border-2 border-gray-200 text-sm font-semibold hover:border-indigo-400 transition selected bg-indigo-500 text-white border-indigo-500" data-value="5">5</button>
                    <button type="button" class="w-9 h-9 rounded-md border-2 border-gray-200 text-sm font-semibold hover:border-indigo-400 transition" data-value="6">6</button>
                    <button type="button" class="w-9 h-9 rounded-md border-2 border-gray-200 text-sm font-semibold hover:border-indigo-400 transition" data-value="7">7</button>
                    <button type="button" class="w-9 h-9 rounded-md border-2 border-gray-200 text-sm font-semibold hover:border-indigo-400 transition" data-value="8">8</button>
                    <button type="button" class="w-9 h-9 rounded-md border-2 border-gray-200 text-sm font-semibold hover:border-indigo-400 transition" data-value="9">9</button>
                    <button type="button" class="w-9 h-9 rounded-md border-2 border-gray-200 text-sm font-semibold hover:border-indigo-400 transition" data-value="10">10</button>
                </div>
            </div>
        </div>
        <div class="flex justify-end gap-2 p-6 pt-0">
            <button id="cancelProgressNoteBtn" class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Cancel</button>
            <button id="saveProgressNoteBtn" class="px-4 py-2 bg-primary text-white rounded-md text-sm hover:bg-indigo-700">Save Progress Note</button>
        </div>
    </div>
</div>
    </main>
</div>

<!-- Session Details Modal -->
<div id="sessionDetailModal" style="display:none;" class="modal-overlay">
    <div class="modal-container"><div class="flex justify-between items-start mb-4 p-6 pb-0"><div><h3 class="text-lg font-semibold" id="detailTitle">Session Details</h3><p class="text-gray-500" id="detailSubtitle"></p></div><button id="closeDetailModalBtn" class="text-gray-400 hover:text-gray-600"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button></div><div class="p-6 pt-2"><div id="detailContent" class="space-y-4"></div></div><div class="flex justify-end gap-2 p-6 pt-0"><button id="cancelDetailBtn" class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Close</button><button id="editSessionBtn" class="px-4 py-2 bg-primary text-white rounded-md text-sm hover:bg-indigo-700">Edit Session</button></div></div>
</div>

<!-- Cancel Confirmation Modal - Fixed -->
<div id="cancelModalOverlay" class="modal-overlay" style="display:none;">
    <div id="cancelModal" class="alert-dialog">
        <div class="alert-dialog-header">
            <h2 id="cancelModalTitle" class="alert-dialog-title">Are you sure you want to cancel this appointment?</h2>
            <p id="cancelModalDesc" class="alert-dialog-description">This action is irreversible. If you cancel this appointment, the patient will be notified and the appointment will be cancelled.</p>
        </div>
        <div class="alert-dialog-footer">
            <button type="button" id="cancelModalCloseBtn" class="alert-dialog-cancel">Cancel</button>
            <button type="button" id="confirmCancelBtn" class="alert-dialog-confirm">Cancel Appointment</button>
        </div>
    </div>
</div>

<script src="js/features/settings-manager.js"></script>
<script src="js/core/theme.js"></script>
<script src="js/core/sidebar.js"></script>
<script src="js/core/accordion.js"></script>
<script src="js/core/notifications.js"></script>
<script src="js/core/profile.js"></script>
<script src="js/features/currency.js"></script>
<script src="js/features/tabs.js"></script>
<script src="js/features/pip-widget.js"></script>
<script src="js/features/regional.js"></script>
<script src="js/features/language.js"></script>
<script src="js/init.js"></script>

<script>
    const sessions = [
    { id:1, date:"2026-06-14", time:"08:00 AM", patient:"Okello David", patientId:"PT-001", therapist:"Dr. Nakato Sarah", type:"Initial Assessment", room:"Therapy Room A", duration:"45 min", condition:"Post-ACL Reconstruction", status:"Completed" },
    { id:2, date:"2026-06-14", time:"09:00 AM", patient:"Emma Davis", patientId:"PT-002", therapist:"Namyalo Emma", type:"Follow-up", room:"Therapy Room B", duration:"30 min", condition:"Rotator Cuff Repair", status:"In Progress" },
    { id:3, date:"2026-06-14", time:"09:30 AM", patient:"Mwangi Peter", patientId:"PT-003", therapist:"Dr. Nakato Sarah", type:"Manual Therapy", room:"Therapy Room A", duration:"45 min", condition:"Chronic Low Back Pain", status:"Scheduled" },
    { id:4, date:"2026-06-14", time:"10:30 AM", patient:"Nansubuga Sophia", patientId:"PT-004", therapist:"Dr. Mwangi Peter", type:"Rehab", room:"Gym Area", duration:"60 min", condition:"Stroke Rehabilitation", status:"Scheduled" },
    { id:5, date:"2026-06-14", time:"11:30 AM", patient:"Kimera Liam", patientId:"PT-005", therapist:"Dr. Okello James", type:"Follow-up", room:"Therapy Room C", duration:"30 min", condition:"Ankle Sprain", status:"Scheduled" },
    { id:6, date:"2026-06-14", time:"01:00 PM", patient:"Nakato Olivia", patientId:"PT-006", therapist:"Namyalo Emma", type:"Initial Assessment", room:"Therapy Room B", duration:"45 min", condition:"Cervical Spondylosis", status:"Scheduled" },
    { id:7, date:"2026-06-14", time:"02:00 PM", patient:"Mukasa Noah", patientId:"PT-007", therapist:"Dr. Nakato Sarah", type:"Rehab", room:"Gym Area", duration:"60 min", condition:"Total Hip Replacement", status:"Scheduled" },
    { id:8, date:"2026-06-15", time:"03:00 PM", patient:"Wanjiru Ava", patientId:"PT-008", therapist:"Dr. Mwangi Peter", type:"Follow-up", room:"Therapy Room A", duration:"30 min", condition:"Tennis Elbow", status:"Scheduled" },
    { id:9, date:"2026-06-16", time:"03:30 PM", patient:"Ssentongo William", patientId:"PT-009", therapist:"Dr. Okello James", type:"Manual Therapy", room:"Therapy Room C", duration:"45 min", condition:"Frozen Shoulder", status:"Scheduled" },
    { id:10, date:"2026-06-17", time:"04:30 PM", patient:"Nabisere Isabella", patientId:"PT-010", therapist:"Dr. Nakato Sarah", type:"Discharge", room:"Therapy Room A", duration:"30 min", condition:"Post-Ankle Fracture", status:"Scheduled" },
];
const rooms = [
    { name:"Therapy Room A", capacity:2, equipment:"Treatment table, Ultrasound, TENS", sessions:8 },
    { name:"Therapy Room B", capacity:2, equipment:"Treatment table, Hot/Cold packs", sessions:6 },
    { name:"Therapy Room C", capacity:1, equipment:"Treatment table, Traction unit", sessions:5 },
    { name:"Gym Area", capacity:6, equipment:"Parallel bars, Stationary bike, Treadmill, Weights", sessions:7 },
    { name:"Hydrotherapy Pool", capacity:4, equipment:"Heated pool, Resistance jets", sessions:2 },
];

let sessionFilters = { search:'', type:'all', status:'all', therapist:'all', page:1, perPage:8 };
let activeActionMenu = null;
let currentCancelSession = null;
let calendarDate = new Date(2026, 5, 14);
let selectedDate = new Date(2026, 5, 14);
let calTab = 'month';
let calWeekStart = new Date(2026, 5, 8);
let currentProgressSession = null;
let selectedProgressPain = 5;

function showToast(msg, isError) { const t = document.createElement('div'); t.className = 'toast-message' + (isError?' error':''); t.textContent = msg; document.body.appendChild(t); setTimeout(() => t.remove(), 2500); }
function closeActionMenu() { if (activeActionMenu) { activeActionMenu.remove(); activeActionMenu = null; } }
function showActionMenu(btn, items) {
    closeActionMenu();
    const rect = btn.getBoundingClientRect();
    const menu = document.createElement('div');
    menu.className = 'action-menu';
    
    let left = rect.left, top = rect.bottom + 6;
    if (left + 220 > window.innerWidth) left = window.innerWidth - 230;
    
    // Calculate height for bottom-screen collision
    const menuHeight = items.length * 40; 
    if (top + menuHeight > window.innerHeight) top = rect.top - menuHeight - 10;
    
    menu.style.top = top + 'px';
    menu.style.left = left + 'px';

    let html = '<div class="action-menu-header">Session Actions</div>';
    
    // Generate HTML
    items.forEach((item, index) => {
        if (item.divider) {
            html += '<div class="action-divider"></div>';
        } else {
            // We store the original index in a data attribute to keep the callback link correct
            html += `<button class="action-item ${item.cls || ''}" data-item-index="${index}">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">${item.icon}</svg>
                        ${item.label}
                    </button>`;
        }
    });

    menu.innerHTML = html;
    document.body.appendChild(menu);
    activeActionMenu = menu;

    // Attach Listeners using the stored index
    menu.querySelectorAll('.action-item').forEach((el) => {
        el.addEventListener('click', () => {
            const itemIndex = el.getAttribute('data-item-index');
            const it = items[itemIndex];
            if (it && it.callback) it.callback();
            closeActionMenu();
        });
    });

    // Close menu when clicking away
    const closeHandler = (e) => {
        if (!menu.contains(e.target) && e.target !== btn) {
            closeActionMenu();
            document.removeEventListener('click', closeHandler);
        }
    };
    setTimeout(() => document.addEventListener('click', closeHandler), 10);
}

function getStatusBadge(s) { const m = { 'Completed':'bg-green-100 text-green-700','In Progress':'bg-blue-100 text-blue-700','Scheduled':'bg-indigo-100 text-indigo-700','No-Show':'bg-red-100 text-red-700','Cancelled':'bg-gray-100 text-gray-600' }; return `<span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold ${m[s]||'bg-gray-100 text-gray-600'}">${s}</span>`; }
function getTypeBadge(t) { const m = { 'Initial Assessment':'bg-blue-100 text-blue-700','Follow-up':'bg-green-100 text-green-700','Manual Therapy':'bg-purple-100 text-purple-700','Rehab':'bg-amber-100 text-amber-700','Discharge':'bg-gray-100 text-gray-600' }; return `<span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold ${m[t]||'bg-gray-100 text-gray-600'}">${t}</span>`; }

// ==================== CANCEL MODAL FUNCTIONS (FIXED) ====================
function openCancelModal(session) {
    currentCancelSession = session;
    const modalOverlay = document.getElementById('cancelModalOverlay');
    const modalTitle = document.getElementById('cancelModalTitle');
    const modalDesc = document.getElementById('cancelModalDesc');
    
    if (modalTitle) {
        modalTitle.textContent = 'Are you sure you want to cancel this appointment?';
    }
    if (modalDesc) {
        modalDesc.innerHTML = `This action is irreversible. If you cancel the appointment for <span class="font-medium">${session.patient}</span> with <span class="font-medium">${session.therapist}</span> on ${session.date} at ${session.time}, the patient will be notified and the appointment will be cancelled.`;
    }
    if (modalOverlay) {
        modalOverlay.style.display = 'flex';
    }
    document.body.style.overflow = 'hidden';
}

function closeCancelModal() { 
    const modalOverlay = document.getElementById('cancelModalOverlay');
    if (modalOverlay) {
        modalOverlay.style.display = 'none';
    }
    document.body.style.overflow = ''; 
    currentCancelSession = null; 
}

function confirmCancel() { 
    if (currentCancelSession) { 
        currentCancelSession.status = 'Cancelled'; 
        renderSessionsTable(); 
        renderCalendar(); 
        renderDayAppointments();
        showToast(`Appointment for ${currentCancelSession.patient} has been cancelled`); 
    } 
    closeCancelModal(); 
}

// ==================== CANCEL MODAL EVENT LISTENERS ====================
document.addEventListener('DOMContentLoaded', function() {
    const cancelModalOverlay = document.getElementById('cancelModalOverlay');
    const cancelModalCloseBtn = document.getElementById('cancelModalCloseBtn');
    const confirmCancelBtn = document.getElementById('confirmCancelBtn');

    if (cancelModalOverlay) {
        cancelModalOverlay.addEventListener('click', function(e) {
            if (e.target === cancelModalOverlay) {
                closeCancelModal();
            }
        });
    }

    if (cancelModalCloseBtn) {
        cancelModalCloseBtn.addEventListener('click', closeCancelModal);
    }

    if (confirmCancelBtn) {
        confirmCancelBtn.addEventListener('click', confirmCancel);
    }
});

// Close on Escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        const modalOverlay = document.getElementById('cancelModalOverlay');
        if (modalOverlay && modalOverlay.style.display === 'flex') {
            closeCancelModal();
        }
    }
});
function renderSessionsTable() {
    let filtered = [...sessions]; const f = sessionFilters;
    if (f.search) { const q = f.search.toLowerCase(); filtered = filtered.filter(s => s.patient.toLowerCase().includes(q) || s.therapist.toLowerCase().includes(q) || s.condition.toLowerCase().includes(q)); }
    if (f.type !== 'all') filtered = filtered.filter(s => s.type === f.type);
    if (f.status !== 'all') filtered = filtered.filter(s => s.status === f.status);
    if (f.therapist !== 'all') filtered = filtered.filter(s => s.therapist === f.therapist);
    const total = filtered.length, tp = Math.ceil(total / f.perPage);
    if (f.page > tp) f.page = Math.max(1, tp);
    const start = (f.page - 1) * f.perPage, paginated = filtered.slice(start, start + f.perPage);
    document.getElementById('sessionsTableBody').innerHTML = paginated.map(s => `<tr class="border-b hover:bg-gray-50 transition"><td class="p-4"><span class="font-medium">${s.date}</span><br><span class="text-xs text-gray-500">${s.time}</span></td><td class="p-4"><span class="font-medium">${s.patient}</span><br><span class="text-xs text-gray-500">${s.condition}</span></td><td class="p-4">${s.therapist}</td><td class="p-4">${getTypeBadge(s.type)}</td><td class="p-4 hidden md:table-cell">${s.room}</td><td class="p-4 hidden md:table-cell">${s.duration}</td><td class="p-4">${getStatusBadge(s.status)}</td><td class="p-4 text-right"><button class="session-action-btn p-1 rounded hover:bg-gray-100" data-id="${s.id}"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg></button></td></tr>`).join('') || '<tr><td colspan="8" class="p-8 text-center text-gray-500">No sessions found</td></tr>';
    document.getElementById('sessionPagination').innerHTML = total > f.perPage ? `<div class="text-sm text-gray-500">Showing ${start+1}-${Math.min(start+f.perPage,total)} of ${total}</div><div class="flex gap-1"><button class="px-3 py-1 border rounded text-sm hover:bg-gray-100" onclick="sessionFilters.page--;renderSessionsTable();" ${f.page===1?'disabled':''}>Prev</button><span class="px-3 py-1 text-sm font-medium">${f.page}/${tp}</span><button class="px-3 py-1 border rounded text-sm hover:bg-gray-100" onclick="sessionFilters.page++;renderSessionsTable();" ${f.page>=tp?'disabled':''}>Next</button></div>` : '';
    document.querySelectorAll('.session-action-btn').forEach(btn => { btn.addEventListener('click', (e) => { e.stopPropagation(); const s = sessions.find(x => x.id == btn.dataset.id); if (s) showSessionActions(btn, s); }); });
}

function showSessionActions(btn, session) {
    showActionMenu(btn, [
        { icon:'<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>', label:'View Details', callback:() => showSessionDetail(session) },
        { icon:'<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>', label:'Edit Session', callback:() => { window.location.href = `edit-physiotherapy-session.html?id=${session.id}`; } },
        { icon:'<path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/>', label:'Add Progress Note', callback:() => openProgressNoteModal(session) },
        { icon:'<path d="M8 2v4M16 2v4M3 10h18"/><rect width="18" height="18" x="3" y="4" rx="2"/>', label:'Reschedule', callback:() => { window.location.href = `physiotherapy-schedule.html?reschedule=${session.id}`; } },
        { divider:true, icon:'', label:'' },
        { icon:'<path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>', label:'Cancel Session', cls:' text-red', callback:() => openCancelModal(session) },
    ]);
}

function showSessionDetail(session) {
    document.getElementById('detailTitle').textContent = `${session.patient} — ${session.type}`;
    document.getElementById('detailSubtitle').textContent = `${session.date} at ${session.time} · ${session.duration}`;
    document.getElementById('detailContent').innerHTML = `<div class="grid grid-cols-2 gap-4"><div><p class="text-xs text-gray-500">Patient</p><p class="font-medium">${session.patient} (${session.patientId})</p></div><div><p class="text-xs text-gray-500">Therapist</p><p class="font-medium">${session.therapist}</p></div><div><p class="text-xs text-gray-500">Condition</p><p class="font-medium">${session.condition}</p></div><div><p class="text-xs text-gray-500">Room</p><p class="font-medium">${session.room}</p></div><div><p class="text-xs text-gray-500">Type</p>${getTypeBadge(session.type)}</div><div><p class="text-xs text-gray-500">Status</p>${getStatusBadge(session.status)}</div></div><div class="border-t pt-3 mt-3"><p class="text-xs text-gray-500 mb-2">Session Notes</p><p class="text-sm text-gray-600">${session.status==='Completed'?'Patient demonstrated improved ROM. Pain levels reduced from 6/10 to 4/10.':session.status==='In Progress'?'Session currently underway. '+session.therapist+' is working with the patient.':'Session scheduled. Prepare '+session.room+' with necessary equipment.'}</p></div>`;
    document.getElementById('sessionDetailModal').style.display = 'flex'; document.body.style.overflow = 'hidden';
    document.getElementById('editSessionBtn').onclick = () => { closeDetailModal(); window.location.href = `edit-physiotherapy-session.html?id=${session.id}`; };
}
function closeDetailModal() { document.getElementById('sessionDetailModal').style.display = 'none'; document.body.style.overflow = ''; }
document.getElementById('closeDetailModalBtn')?.addEventListener('click', closeDetailModal);
document.getElementById('cancelDetailBtn')?.addEventListener('click', closeDetailModal);
document.getElementById('sessionDetailModal')?.addEventListener('click', function(e) { if (e.target === this) closeDetailModal(); });

function renderRoomCards() {
    document.getElementById('roomCards').innerHTML = rooms.map(r => {
        const rs = sessions.filter(s => s.room === r.name);
        const utilPct = Math.round((rs.length / r.sessions) * 100) || 0;
        return `<div class="rounded-lg border bg-background shadow-sm"><div class="p-4 border-b"><div class="flex justify-between items-center"><h3 class="font-semibold">${r.name}</h3><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold ${utilPct>80?'bg-red-100 text-red-700':utilPct>50?'bg-amber-100 text-amber-700':'bg-green-100 text-green-700'}">${utilPct}% utilized</span></div><p class="text-xs text-gray-500 mt-1">Capacity: ${r.capacity} · Equipment: ${r.equipment}</p></div><div class="p-4 space-y-2">${rs.slice(0,5).map(s => `<div class="session-card type-${s.type.toLowerCase().replace(/ /g,'-')}"><div class="flex justify-between items-start"><span class="time-badge bg-gray-100 text-gray-700">${s.time}</span><span class="font-medium text-sm ml-2">${s.patient}</span>${getStatusBadge(s.status)}</div><p class="text-xs text-gray-500 mt-1">${s.therapist} · ${s.type} · ${s.duration}</p></div>`).join('') || '<p class="text-sm text-gray-400 text-center py-4">No sessions in this room</p>'}</div></div>`;
    }).join('');
}

// ==================== CALENDAR ====================
function formatDate(d) { return d.toLocaleDateString('en-US', { weekday:'long', year:'numeric', month:'long', day:'numeric' }); }
function dateKey(d) { return `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`; }

function renderDayAppointments() {
    const dk = dateKey(selectedDate);
    const daySessions = sessions.filter(s => s.date === dk);
    const container = document.getElementById('dayAppointments');
    const noMsg = document.getElementById('noAppointmentsMsg');
    const selectedDateLabel = document.getElementById('selectedDateLabel');
    
    selectedDateLabel.textContent = formatDate(selectedDate);
    
    if (daySessions.length === 0) {
        container.innerHTML = '';
        noMsg.classList.remove('hidden');
    } else {
        noMsg.classList.add('hidden');
        container.innerHTML = daySessions.map(s => `
            <div class="session-card type-${s.type.toLowerCase().replace(/ /g,'-')}">
                <div class="flex justify-between items-start mb-1">
                    <span class="time-badge bg-gray-100 text-gray-700">${s.time}</span>
                    ${getStatusBadge(s.status)}
                </div>
                <p class="font-medium text-sm">${s.patient}</p>
                <p class="text-xs text-gray-500">${s.therapist} · ${s.type} · ${s.room} · ${s.duration}</p>
                <div class="flex gap-2 mt-2">
                    <button class="text-xs text-indigo-600 hover:underline" onclick="showSessionDetail(sessions.find(x=>x.id===${s.id}))">View</button>
                    <button class="text-xs text-indigo-600 hover:underline" onclick="window.location.href='edit-physiotherapy-session.html?id=${s.id}'">Edit</button>
                </div>
            </div>
        `).join('');
    }
}

function renderCalendar() {
    document.getElementById('currentDateDisplay').textContent = calendarDate.toLocaleDateString('en-US', { month:'long', year:'numeric' });
    
    document.getElementById('view-day').classList.toggle('hidden', calTab !== 'day');
    document.getElementById('view-week').classList.toggle('hidden', calTab !== 'week');
    document.getElementById('view-month').classList.toggle('hidden', calTab !== 'month');
    document.getElementById('view-list').classList.toggle('hidden', calTab !== 'list');
    
    if (calTab === 'month') renderMonthView();
    else if (calTab === 'day') renderDayView();
    else if (calTab === 'week') renderWeekView();
    else if (calTab === 'list') renderListView();
    
    renderDayAppointments();
}

function renderMonthView() {
    const grid = document.getElementById('monthCalendarGrid');
    const days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
    let html = `<div class="month-calendar" style="display: grid; gap: 2px; grid-template-columns: repeat(7, 1fr);">`;
    html += days.map(d => `<div class="text-center text-xs font-semibold text-gray-500 py-2">${d}</div>`).join('');
    
    const firstDay = new Date(calendarDate.getFullYear(), calendarDate.getMonth(), 1);
    const lastDay = new Date(calendarDate.getFullYear(), calendarDate.getMonth() + 1, 0);
    const startPad = firstDay.getDay();
    const prevLast = new Date(calendarDate.getFullYear(), calendarDate.getMonth(), 0).getDate();
    const todayKey = dateKey(new Date());
    const selKey = dateKey(selectedDate);
    
    for (let i = startPad - 1; i >= 0; i--) {
        html += `<div class="month-day-cell min-h-[100px] border rounded-md p-1 bg-gray-500/20 opacity-50"><div class="month-day-number">${prevLast - i}</div><div class="month-events-container"><div style="flex:1"></div></div></div>`;
    }
    
    for (let i = 1; i <= lastDay.getDate(); i++) {
        const d = new Date(calendarDate.getFullYear(), calendarDate.getMonth(), i);
        const dk = dateKey(d);
        const daySessions = sessions.filter(s => s.date === dk);
        const isToday = dk === todayKey;
        const isSel = dk === selKey;
        const maxEvents = 3;
        
        let eventsHtml = '';
        if (daySessions.length > 0) {
            daySessions.slice(0, maxEvents).forEach(s => {
                const statusClass = s.status.toLowerCase().replace(/ /g,'-');
                eventsHtml += `<div class="month-event ${statusClass}" data-patient="${s.patient}" data-date="${dk}" title="${s.patient} - ${s.type} (${s.time})" onclick="event.stopPropagation();showSessionDetail(sessions.find(x=>x.id==${s.id}))">${s.patient.split(' ')[0]} ${s.time.split(':')[0]+':'+s.time.split(':')[1].split(' ')[0]}</div>`;
            });
            if (daySessions.length > maxEvents) {
                eventsHtml += `<div class="month-event more-events" onclick="event.stopPropagation();selectCalendarDate(${d.getFullYear()},${d.getMonth()},${i});calTab='day';renderCalendar();renderDayAppointments();">+${daySessions.length - maxEvents} more</div>`;
            }
        }
        
        html += `<div class="month-day-cell min-h-[100px] border rounded-md p-1${isToday?' today bg-primary/90 border':''}${isSel?' selected':''}" data-date="${dk}" onclick="selectCalendarDate(${d.getFullYear()},${d.getMonth()},${i})"><div class="month-day-number">${i}</div><div class="month-events-container">${eventsHtml || '<div style="flex:1"></div>'}</div></div>`;
    }
    
    const totalCells = startPad + lastDay.getDate();
    const remaining = totalCells <= 35 ? 35 - totalCells : 42 - totalCells;
    for (let i = 1; i <= remaining; i++) {
        html += `<div class="month-day-cell min-h-[100px] border rounded-md p-1 bg-gray-500/20 opacity-50"><div class="month-day-number">${i}</div><div class="month-events-container"><div style="flex:1"></div></div></div>`;
    }
    
    html += `</div>`;
    grid.innerHTML = html;
}

function renderDayView() {
    const dk = dateKey(selectedDate);
    const daySessions = sessions.filter(s => s.date === dk);
    const container = document.getElementById('daySchedule');
    
    if (daySessions.length === 0) {
        container.innerHTML = `<div class="text-center py-8 text-gray-400"><svg class="h-12 w-12 mx-auto mb-3 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg><p class="font-medium">No appointments for this day</p><p class="text-sm">Select another date or schedule a session</p></div>`;
    } else {
        container.innerHTML = daySessions.map(s => `
            <div class="session-card type-${s.type.toLowerCase().replace(/ /g,'-')}">
                <div class="flex justify-between items-start mb-1"><span class="time-badge bg-gray-100 text-gray-700">${s.time}</span>${getStatusBadge(s.status)}</div>
                <p class="font-medium text-sm">${s.patient}</p><p class="text-xs text-gray-500">${s.therapist} · ${s.type} · ${s.room} · ${s.duration}</p>
                <div class="flex gap-2 mt-2"><button class="text-xs text-indigo-600 hover:underline" onclick="showSessionDetail(sessions.find(x=>x.id===${s.id}))">View</button><button class="text-xs text-indigo-600 hover:underline" onclick="window.location.href='edit-physiotherapy-session.html?id=${s.id}'">Edit</button></div>
            </div>`).join('');
    }
}

function renderWeekView() {
    const startOfWeek = new Date(calWeekStart);
    const days = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
    
    let headerHtml = '';
    for (let i = 0; i < 7; i++) {
        const d = new Date(startOfWeek); d.setDate(d.getDate() + i);
        const dk = dateKey(d);
        const isToday = dk === dateKey(new Date());
        headerHtml += `<div class="text-center p-2 rounded-md ${isToday ? 'bg-indigo-50 font-bold text-indigo-700' : ''}"><div class="text-xs text-gray-500">${days[i]}</div><div class="text-lg">${d.getDate()}</div></div>`;
    }
    document.getElementById('weekHeader').innerHTML = headerHtml;
    
    let scheduleHtml = '';
    for (let i = 0; i < 7; i++) {
        const d = new Date(startOfWeek); d.setDate(d.getDate() + i);
        const dk = dateKey(d);
        const daySessions = sessions.filter(s => s.date === dk);
        scheduleHtml += `<div class="border rounded-md p-2 min-h-[80px]"><div class="text-xs font-medium text-gray-500 mb-1">${days[i]} ${d.getDate()}</div>`;
        if (daySessions.length === 0) {
            scheduleHtml += `<p class="text-xs text-gray-400 text-center py-2">—</p>`;
        } else {
            daySessions.forEach(s => {
                const statusClass = s.status.toLowerCase().replace(/ /g,'-');
                scheduleHtml += `<div class="month-event ${statusClass} mb-1 cursor-pointer" title="${s.patient} - ${s.type}" onclick="showSessionDetail(sessions.find(x=>x.id==${s.id}))">${s.time.split(' ')[0]} ${s.patient.split(' ')[0]}</div>`;
            });
        }
        scheduleHtml += `</div>`;
    }
    document.getElementById('weekSchedule').innerHTML = scheduleHtml;
}

function renderListView() {
    const container = document.getElementById('listSchedule');
    const allSessions = [...sessions].sort((a,b) => a.date.localeCompare(b.date) || a.time.localeCompare(b.time));
    container.innerHTML = allSessions.map(s => `
        <div class="session-card type-${s.type.toLowerCase().replace(/ /g,'-')}">
            <div class="flex justify-between items-start"><div><span class="time-badge bg-gray-100 text-gray-700">${s.date} ${s.time}</span><span class="font-medium text-sm ml-2">${s.patient}</span></div>${getStatusBadge(s.status)}</div>
            <p class="text-xs text-gray-500 mt-1">${s.therapist} · ${s.type} · ${s.room} · ${s.duration}</p>
        </div>`).join('') || '<p class="text-center py-4 text-gray-400">No sessions scheduled</p>';
}

function selectCalendarDate(y, m, d) {
    selectedDate = new Date(y, m, d);
    calendarDate = new Date(y, m, d);
    if (calTab === 'week') { calWeekStart = new Date(selectedDate); calWeekStart.setDate(calWeekStart.getDate() - calWeekStart.getDay()); }
    renderCalendar();
    renderDayAppointments();
}

function openProgressNoteModal(session) {
    currentProgressSession = session;
    document.getElementById('progressNotePatient').textContent = `${session.patient} — ${session.condition} · ${session.therapist}`;
    document.getElementById('progressNotes').value = '';
    selectedProgressPain = 5;
    document.querySelectorAll('#progressPainScale button').forEach(b => {
        b.classList.remove('selected', 'bg-indigo-500', 'text-white', 'border-indigo-500');
        if (b.dataset.value == '5') b.classList.add('selected', 'bg-indigo-500', 'text-white', 'border-indigo-500');
    });
    document.getElementById('progressNoteModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeProgressNoteModal() {
    document.getElementById('progressNoteModal').style.display = 'none';
    document.body.style.overflow = '';
    currentProgressSession = null;
}

document.getElementById('closeProgressNoteBtn')?.addEventListener('click', closeProgressNoteModal);
document.getElementById('cancelProgressNoteBtn')?.addEventListener('click', closeProgressNoteModal);
document.getElementById('progressNoteModal')?.addEventListener('click', function(e) { if (e.target === this) closeProgressNoteModal(); });

document.querySelectorAll('#progressPainScale button').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('#progressPainScale button').forEach(b => b.classList.remove('selected', 'bg-indigo-500', 'text-white', 'border-indigo-500'));
        btn.classList.add('selected', 'bg-indigo-500', 'text-white', 'border-indigo-500');
        selectedProgressPain = parseInt(btn.dataset.value);
    });
});

document.getElementById('saveProgressNoteBtn')?.addEventListener('click', () => {
    const notes = document.getElementById('progressNotes').value.trim();
    if (!notes) { showToast('Please enter some notes', true); return; }
    const noteType = document.querySelector('#noteTypeSelect .radix-select-trigger')?.querySelector('span')?.textContent || 'Progress Note';
    showToast(`✅ ${noteType} saved for ${currentProgressSession.patient} (Pain: ${selectedProgressPain}/10)`);
    closeProgressNoteModal();
});

function initRadixSelect(el) { if (!el) return; const t = el.querySelector('.radix-select-trigger'), c = el.querySelector('.radix-select-content'), items = el.querySelectorAll('.radix-select-item'); if (!t || !c) return; t.addEventListener('click', (e) => { e.stopPropagation(); document.querySelectorAll('.radix-select-content').forEach(x => { if (x !== c) x.classList.add('hidden'); }); c.classList.toggle('hidden'); }); items.forEach(i => { i.addEventListener('click', (e) => { e.stopPropagation(); t.querySelector('span').textContent = i.textContent.replace(/<svg[\s\S]*?<\/svg>/g, '').trim(); t.setAttribute('data-value', i.dataset.value); items.forEach(x => x.setAttribute('data-selected', 'false')); i.setAttribute('data-selected', 'true'); c.classList.add('hidden'); }); }); }
document.querySelectorAll('#progressNoteModal .radix-select').forEach(s => initRadixSelect(s));

document.getElementById('prevDateBtn')?.addEventListener('click', () => {
    if (calTab === 'month') calendarDate.setMonth(calendarDate.getMonth() - 1);
    else if (calTab === 'week') calWeekStart.setDate(calWeekStart.getDate() - 7);
    else { selectedDate.setDate(selectedDate.getDate() - 1); calendarDate = new Date(selectedDate); }
    renderCalendar();
    renderDayAppointments();
});
document.getElementById('nextDateBtn')?.addEventListener('click', () => {
    if (calTab === 'month') calendarDate.setMonth(calendarDate.getMonth() + 1);
    else if (calTab === 'week') calWeekStart.setDate(calWeekStart.getDate() + 7);
    else { selectedDate.setDate(selectedDate.getDate() + 1); calendarDate = new Date(selectedDate); }
    renderCalendar();
    renderDayAppointments();
});
document.getElementById('todayBtn')?.addEventListener('click', () => {
    calendarDate = new Date(); selectedDate = new Date(); calWeekStart = new Date(); calWeekStart.setDate(calWeekStart.getDate() - calWeekStart.getDay());
    renderCalendar();
    renderDayAppointments();
});

document.querySelectorAll('.schedule-tab').forEach(btn => { btn.addEventListener('click', () => {
    calTab = btn.dataset.calTab;
    document.querySelectorAll('.schedule-tab').forEach(b => b.classList.remove('active', 'bg-white', 'text-indigo-700', 'shadow-sm'));
    btn.classList.add('active', 'bg-white', 'text-indigo-700', 'shadow-sm');
    if (calTab === 'day') { selectedDate = new Date(); calendarDate = new Date(); }
    if (calTab === 'week') { calWeekStart = new Date(selectedDate); calWeekStart.setDate(calWeekStart.getDate() - calWeekStart.getDay()); }
    renderCalendar();
    renderDayAppointments();
}); });

function initFilters() {
    [{ btn:'typeFilterBtn', dropdown:'typeFilterDropdown', text:'typeFilterText', setter:'type' },{ btn:'statusFilterBtn', dropdown:'statusFilterDropdown', text:'statusFilterText', setter:'status' },{ btn:'therapistFilterBtn', dropdown:'therapistFilterDropdown', text:'therapistFilterText', setter:'therapist' }].forEach(f => {
        const btn = document.getElementById(f.btn), dd = document.getElementById(f.dropdown), txt = document.getElementById(f.text); if (!btn) return;
        btn.addEventListener('click', (e) => { e.stopPropagation(); closeActionMenu(); dd.classList.toggle('hidden'); });
        dd.querySelectorAll('.select-item').forEach(i => { i.addEventListener('click', () => { txt.textContent = i.textContent; sessionFilters[f.setter] = i.dataset.value; sessionFilters.page = 1; dd.classList.add('hidden'); renderSessionsTable(); }); });
        document.addEventListener('click', (e) => { if (!btn.contains(e.target) && !dd.contains(e.target)) dd.classList.add('hidden'); });
    });
}

function activateTab(tabId) {
    ['calendar','list','rooms'].forEach(t => { const p = document.getElementById(`tab-${t}`), b = document.querySelector(`.tab-btn[data-tab="${t}"]`); if(p) p.setAttribute('data-state', t===tabId?'active':'inactive'); if(b) { if(t===tabId) b.classList.add('active'); else b.classList.remove('active'); } });
    if (tabId === 'calendar') { renderCalendar(); renderDayAppointments(); }
    if (tabId === 'rooms') renderRoomCards();
}
document.querySelectorAll('.tab-btn').forEach(b => b.addEventListener('click', () => activateTab(b.dataset.tab)));
document.getElementById('sessionSearch')?.addEventListener('input', (e) => { sessionFilters.search = e.target.value; sessionFilters.page = 1; renderSessionsTable(); });
document.getElementById('refreshBtn')?.addEventListener('click', () => { renderSessionsTable(); renderCalendar(); renderDayAppointments(); showToast('Schedule refreshed'); });
document.addEventListener('click', () => document.getElementById('profileDropdown')?.classList.add('hidden'));
// Unified Escape key handler (place this ONCE, remove any other Escape handlers)
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        // Close in priority order - check modals first
        const cancelOverlay = document.getElementById('cancelModalOverlay');
        const detailModal = document.getElementById('sessionDetailModal');
        const progressModal = document.getElementById('progressNoteModal');
        
        if (cancelOverlay && cancelOverlay.style.display === 'flex') {
            closeCancelModal();
        } else if (detailModal && detailModal.style.display === 'flex') {
            closeDetailModal();
        } else if (progressModal && progressModal.style.display === 'flex') {
            closeProgressNoteModal();
        } else {
            closeActionMenu();
        }
    }
});

function refreshAllCharts() { setTimeout(() => { window.dispatchEvent(new Event('resize')); }, 350); }
document.querySelector('.lucide-menu')?.closest('button')?.addEventListener('click', refreshAllCharts);
document.querySelector('.physio-toggle')?.addEventListener('click', function() { const sub = document.querySelector('.physio-submenu'), arrow = document.querySelector('.physio-arrow'); if (sub.style.display === 'none' || !sub.style.display) { sub.style.display = 'block'; arrow.style.transform = 'rotate(180deg)'; } else { sub.style.display = 'none'; arrow.style.transform = 'rotate(0deg)'; } });
document.querySelector('.physio-submenu').style.display = 'block'; document.querySelector('.physio-arrow').style.transform = 'rotate(180deg)';

initFilters(); renderSessionsTable(); renderCalendar(); renderDayAppointments(); activateTab('calendar');
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
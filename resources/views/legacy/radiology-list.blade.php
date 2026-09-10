<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Radiology Orders</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .rounded-lg.border { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted { background-color: #262626 !important; }
        body.dark input, body.dark textarea, body.dark select { background-color: #262626 !important; border-color: #404040 !important; color: #e5e5e5 !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        .tab-btn { transition: all 0.2s ease; color: #6b7280; }
        .tab-btn.active { background-color: white; color: #1f2937; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        body.dark .tab-btn.active { background-color: #131212; color: #e5e5e5; }

        .action-menu {
            position: fixed;
            z-index: 100;
            min-width: 210px;
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            padding: 0.25rem;
            animation: fadeInScale 0.12s ease-out;
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
        body.dark .action-menu-header { border-bottom-color: #404040; color: #9ca3af; }
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
        .action-item:hover { background-color: #f3f4f6; }
        body.dark .action-item:hover { background-color: #3f3f46; }
        .action-divider { height: 1px; background-color: #e5e7eb; margin: 0.25rem 0; }
        body.dark .action-divider { background-color: #404040; }
        @keyframes fadeInScale { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgb(0 0 0 / 87%);
            backdrop-filter: blur(2px);
            z-index: 1000;
            display: none;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.show {
            display: flex;
            animation: fadeIn 0.2s ease-out;
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .modal-container {
            background: white;
            border-radius: 0.75rem;
            width: 100%;
            max-width: 600px;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            animation: slideUp 0.2s ease;
        }
        body.dark .modal-container { background: #1e293b; border: 1px solid #334155; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            background: white;
            z-index: 10;
        }
        body.dark .modal-header { border-bottom-color: #334155; background: #1e293b; }
        .modal-title { font-size: 1.125rem; font-weight: 600; }
        .modal-close {
            background: transparent;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6b7280;
            line-height: 1;
            padding: 0;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
        }
        .modal-close:hover { color: #1f2937; background-color: #f3f4f6; }
        body.dark .modal-close:hover { color: #e5e5e5; background-color: #374151; }
        .modal-body { padding: 1.5rem; }
        .modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            position: sticky;
            bottom: 0;
            background: white;
        }
        body.dark .modal-footer { border-top-color: #334155; background: #1e293b; }

        .alert-dialog-overlay {
            position: fixed;
            inset: 0;
            background-color: rgb(0 0 0 / 87%);
            z-index: 1100;
            display: none;
            align-items: center;
            justify-content: center;
        }
        .alert-dialog-overlay.show {
            display: flex;
            animation: fadeIn 0.2s ease-out;
        }
        .alert-dialog {
            background-color: white;
            border-radius: 0.75rem;
            width: 90%;
            max-width: 450px;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            animation: slideUp 0.2s ease;
            overflow: hidden;
        }
        body.dark .alert-dialog { background-color: #1f1f1f; border: 1px solid #333; }
        .alert-dialog-header { padding: 1.5rem 1.5rem 0.75rem 1.5rem; }
        .alert-dialog-title { font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0 0 0.5rem 0; }
        body.dark .alert-dialog-title { color: #f3f4f6; }
        .alert-dialog-description { font-size: 0.875rem; color: #6b7280; line-height: 1.5; margin: 0; }
        body.dark .alert-dialog-description { color: #9ca3af; }
        .alert-dialog-footer { padding: 1rem 1.5rem 1.5rem 1.5rem; display: flex; justify-content: flex-end; gap: 0.75rem; }
        .alert-dialog-cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            background-color: transparent;
            border: 1px solid #e5e7eb;
            color: #374151;
            cursor: pointer;
        }
        body.dark .alert-dialog-cancel { border-color: #404040; color: #e5e5e5; }
        .alert-dialog-delete {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            background-color: #ef4444;
            border: none;
            color: white;
            cursor: pointer;
        }
        .alert-dialog-delete:hover { background-color: #dc2626; }

        .toast-message {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #10b981;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 1200;
            font-size: 0.875rem;
            animation: slideIn 0.3s ease-out;
        }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }

        .dropdown-animation { animation: fadeInScale 0.12s ease-out; }
        .filter-option:hover { background-color: #f3f4f6; }
        body.dark .filter-option:hover { background-color: #3f3f46; }

        .status-badge { display: inline-flex; align-items: center; border-radius: 9999px; padding: 0.25rem 0.625rem; font-size: 0.75rem; font-weight: 600; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-inprogress { background-color: #dbeafe; color: #1e40af; }
        .status-completed { background-color: #dcfce7; color: #166534; }
        .status-cancelled { background-color: #fee2e2; color: #991b1b; }
        body.dark .status-pending { background-color: #78350f; color: #fef3c7; }
        body.dark .status-inprogress { background-color: #1e3a5f; color: #dbeafe; }
        body.dark .status-completed { background-color: #14532d; color: #dcfce7; }
        body.dark .status-cancelled { background-color: #7f1d1d; color: #fee2e2; }

        .priority-stat { background-color: #fee2e2; color: #991b1b; }
        .priority-urgent { background-color: #ffedd5; color: #9a3412; }
        .priority-routine { background-color: #dcfce7; color: #166534; }
        body.dark .priority-stat { background-color: #7f1d1d; color: #fecaca; }
        body.dark .priority-urgent { background-color: #7c2d12; color: #fed7aa; }
        body.dark .priority-routine { background-color: #14532d; color: #bbf7d0; }

        .data-row:hover { background-color: #f9fafb; }
        body.dark .data-row:hover { background-color: #1f1f1f; }
        .data-row.overdue { border-left: 3px solid #ef4444; }
        .data-row.overdue-amber { border-left: 3px solid #f59e0b; }

        .select-trigger {
            display: flex;
            height: 2.5rem;
            width: 100%;
            align-items: center;
            justify-content: space-between;
            border-radius: 0.375rem;
            border: 1px solid #d1d5db;
            background-color: #ffffff;
            padding: 0 0.75rem;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .select-trigger:hover { border-color: #9ca3af; }
        body.dark .select-trigger { background-color: #262626; border-color: #404040; color: #e5e5e5; }
        .select-content {
            position: absolute;
            z-index: 50;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
            border: 1px solid #e5e7eb;
            margin-top: 4px;
            width: 100%;
            max-height: 240px;
            overflow-y: auto;
            animation: fadeInScale 0.12s ease-out;
        }
        body.dark .select-content { background-color: #1e293b; border-color: #334155; }
        .select-item {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background 0.1s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .select-item:hover { background-color: #f3f4f6; }
        body.dark .select-item:hover { background-color: #334155; }
        .select-item.selected { background-color: #eef2ff; color: #4338ca; font-weight: 500; }
        body.dark .select-item.selected { background-color: #1e1b4b; color: #a5b4fc; }
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
                                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 0 0 2.83 2 2 0 0 0-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 0-2 2 2 2 0 0 0-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 0-2.83 0 2 2 0 0 0 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 0-2-2 2 2 0 0 0 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 0 0-2.83 2 2 0 0 0 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 0 2-2 2 2 0 0 0 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 0 2.83 0 2 2 0 0 0 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 0 2 2 2 2 0 0 0-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
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

            <!-- Main Content: Schedule Page -->
            <main class="flex-1 overflow-auto p-4 xl:p-6 xl:ml-64 w-full">
        <div class="flex flex-col gap-5">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div><h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Radiology Orders</h1><p class="text-gray-500">Manage and track all imaging studies and reports</p></div>
                <div class="flex gap-2">
                    <button id="goToScheduleBtn" class="border border-gray-300 bg-background hover:bg-gray-50 h-10 px-4 rounded-md text-sm flex items-center gap-2 transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>Schedule
                    </button>
                    <button id="goToReportsBtn" class="border border-gray-300 bg-background hover:bg-gray-50 h-10 px-4 rounded-md text-sm flex items-center gap-2 transition">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/></svg>Reports
                    </button>
                    <button id="addOrderBtn" class="bg-primary text-white hover:bg-primary/90 h-10 px-4 rounded-md text-sm flex items-center gap-2 transition">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 12h14M12 5v14"/></svg>Add New Order
                    </button>
                </div>
            </div>

<div class="grid gap-4 md:grid-cols-4">
    <!-- Total Orders Card -->
    <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition cursor-pointer" id="cardTotal">
        <div class="p-4 pb-2">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium text-gray-500">Total Orders</h2>
                <svg class="h-5 w-5 text-indigo-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10 2v7.527a2 2 0 0 1-.211.896L4.72 20.55a1 1 0 0 0 .9 1.45h12.76a1 1 0 0 0 .9-1.45l-5.069-10.127A2 2 0 0 1 14 9.527V2"></path>
                    <path d="M8.5 2h7"></path>
                </svg>
            </div>
        </div>
        <div class="p-4 pt-0">
            <div class="text-2xl font-bold text-indigo-600" id="statTotal">12</div>
            <p class="text-xs text-gray-400 mt-1">+3 from last month</p>
        </div>
    </div>

    <!-- Pending Card -->
    <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition cursor-pointer" id="cardPending">
        <div class="p-4 pb-2">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium text-gray-500">Pending</h2>
                <svg class="h-5 w-5 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
        </div>
        <div class="p-4 pt-0">
            <div class="text-2xl font-bold text-amber-600" id="statPending">6</div>
            <p class="text-xs text-gray-400 mt-1">2 STAT, 3 Urgent</p>
        </div>
    </div>

    <!-- In Progress Card -->
    <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition cursor-pointer" id="cardInProgress">
        <div class="p-4 pb-2">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium text-gray-500">In Progress</h2>
                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
                </svg>
            </div>
        </div>
        <div class="p-4 pt-0">
            <div class="text-2xl font-bold text-blue-600" id="statInProgress">3</div>
            <p class="text-xs text-gray-400 mt-1">3 being reported</p>
        </div>
    </div>

    <!-- Completed Today Card -->
    <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition cursor-pointer" id="cardCompleted">
        <div class="p-4 pb-2">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium text-gray-500">Completed Today</h2>
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 6 9 17l-5-5"></path>
                </svg>
            </div>
        </div>
        <div class="p-4 pt-0">
            <div class="text-2xl font-bold text-green-600" id="statCompleted">3</div>
            <p class="text-xs text-gray-400 mt-1">Avg turnaround: 4.2 hrs</p>
        </div>
    </div>
</div>

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="relative">
                    <svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <input id="searchInput" type="text" placeholder="Search by ID, patient, doctor, modality..." class="pl-8 w-[200px] md:w-[400px] h-10 rounded-md border border-gray-300 px-3 py-2 text-sm bg-white">
                </div>
                <div class="flex gap-2 flex-wrap">
                    <div class="relative">
                        <button id="statusFilterBtn" class="flex h-10 w-[150px] items-center justify-between rounded-md border border-gray-300 bg-background px-3 py-2 text-sm">
                            <span id="statusFilterText">All Status</span>
                            <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div id="statusFilterDropdown" class="hidden absolute z-50 mt-1 w-full rounded-md border bg-background shadow-lg dropdown-animation"><div class="p-1">
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="all">All Status</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="Pending">Pending</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="In Progress">In Progress</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="Completed">Completed</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="Cancelled">Cancelled</div>
                        </div></div>
                    </div>
                    <div class="relative">
                        <button id="modalityFilterBtn" class="flex h-10 w-[160px] items-center justify-between rounded-md border border-gray-300 bg-background px-3 py-2 text-sm">
                            <span id="modalityFilterText">All Modalities</span>
                            <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div id="modalityFilterDropdown" class="hidden absolute z-50 mt-1 w-full rounded-md border bg-background shadow-lg dropdown-animation"><div class="p-1">
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="all">All Modalities</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="X-Ray">X-Ray</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="CT">CT Scan</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="MRI">MRI</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="Ultrasound">Ultrasound</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="Mammography">Mammography</div>
                        </div></div>
                    </div>
                    <div class="relative">
                        <button id="priorityFilterBtn" class="flex h-10 w-[140px] items-center justify-between rounded-md border border-gray-300 bg-background px-3 py-2 text-sm">
                            <span id="priorityFilterText">All Priority</span>
                            <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div id="priorityFilterDropdown" class="hidden absolute z-50 mt-1 w-full rounded-md border bg-background shadow-lg dropdown-animation"><div class="p-1">
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="all">All Priority</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="STAT"> STAT</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="Urgent"> Urgent</div>
                            <div class="filter-option cursor-pointer rounded-sm px-2 py-1.5 text-sm" data-value="Routine"> Routine</div>
                        </div></div>
                    </div>
                </div>
            </div>

            <div class="w-full">
                <div class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1 dark:bg-gray-800">
                    <button data-tab="all" class="tab-btn active rounded-sm px-3 py-1.5 text-sm font-medium transition-all">All Orders</button>
                    <button data-tab="pending" class="tab-btn rounded-sm px-3 py-1.5 text-sm font-medium">Pending</button>
                    <button data-tab="inprogress" class="tab-btn rounded-sm px-3 py-1.5 text-sm font-medium">In Progress</button>
                    <button data-tab="completed" class="tab-btn rounded-sm px-3 py-1.5 text-sm font-medium">Completed</button>
                </div>
                <div class="mt-4 rounded-lg border bg-background shadow-sm overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-3 text-left">Order ID</th><th class="px-4 py-3 text-left">Patient</th><th class="px-4 py-3 text-left hidden md:table-cell">Modality</th><th class="px-4 py-3 text-left hidden lg:table-cell">Body Part</th><th class="px-4 py-3 text-left hidden lg:table-cell">Referring Dr.</th><th class="px-4 py-3 text-left">Priority</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-left hidden md:table-cell">Date</th><th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="radiologyTableBody"></tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between mt-4 px-2">
                    <p class="text-sm text-gray-500" id="showingText">Showing 1-10 of 24 orders</p>
                    <div class="flex gap-1">
                        <button id="prevPageBtn" class="inline-flex items-center justify-center h-10 w-10 rounded-md border text-sm hover:bg-gray-100" disabled><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
                        <button class="page-btn inline-flex items-center justify-center h-10 w-10 rounded-md bg-primary text-white text-sm font-medium" data-page="1">1</button>
                        <button class="page-btn inline-flex items-center justify-center h-10 w-10 rounded-md text-sm hover:bg-gray-100" data-page="2">2</button>
                        <button class="page-btn inline-flex items-center justify-center h-10 w-10 rounded-md text-sm hover:bg-gray-100" data-page="3">3</button>
                        <button id="nextPageBtn" class="inline-flex items-center justify-center h-10 w-10 rounded-md border text-sm hover:bg-gray-100"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- ==================== MODALS ==================== -->

<!-- Update Status Modal -->
<div id="updateStatusModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header"><h2 class="modal-title" id="updateStatusTitle">Update Status</h2><button class="modal-close" data-close="updateStatusModal">&times;</button></div>
        <div class="modal-body">
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-md"><p class="text-sm"><strong>Order:</strong> <span id="usOrderId">—</span></p><p class="text-sm mt-1"><strong>Current Status:</strong> <span id="usCurrentStatus">—</span></p></div>
                <div>
                    <label class="text-sm font-medium block mb-1">New Status</label>
<div class="relative" id="newStatusSelectWrapper">
    <button type="button" id="newStatusSelectTrigger" class="select-trigger">
        <span id="newStatusSelectText">Pending</span>
        <svg class="h-4 w-4 opacity-50" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
    </button>
    <div id="newStatusSelectContent" class="hidden select-content">
        <div class="select-item" data-value="Pending">
            <svg class="h-4 w-4 text-amber-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            Pending
        </div>
        <div class="select-item" data-value="In Progress">
            <svg class="h-4 w-4 text-blue-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path></svg>
            In Progress
        </div>
        <div class="select-item" data-value="Completed">
            <svg class="h-4 w-4 text-green-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"></path></svg>
            Completed
        </div>
        <div class="select-item" data-value="Cancelled">
            <svg class="h-4 w-4 text-red-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
            Cancelled
        </div>
    </div>
    <input type="hidden" id="newStatusSelect" value="Pending">
</div>
                </div>
                <div><label class="text-sm font-medium block mb-1">Notes</label><textarea id="statusNotes" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Reason for status change..."></textarea></div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="border border-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-100" data-close="updateStatusModal">Cancel</button>
            <button id="confirmStatusBtn" class="bg-primary text-white px-4 py-2 rounded-md text-sm hover:bg-primary/90">Update Status</button>
        </div>
    </div>
</div>

<!-- Assign Radiologist Modal -->
<div id="assignRadiologistModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header"><h2 class="modal-title" id="assignRadTitle">Assign Radiologist</h2><button class="modal-close" data-close="assignRadiologistModal">&times;</button></div>
        <div class="modal-body">
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-md"><p class="text-sm"><strong>Order:</strong> <span id="arOrderId">—</span></p><p class="text-sm mt-1"><strong>Current Radiologist:</strong> <span id="arCurrentRad">—</span></p></div>
                <div>
                    <label class="text-sm font-medium block mb-1">Select Radiologist</label>
                    <select id="radiologistSelect" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                        <option value="">— Select —</option>
                        <option value="Dr. Kibirige">Dr. Kibirige (General Radiology)</option>
                        <option value="Dr. Nabwire">Dr. Nabwire (Neuroradiology)</option>
                        <option value="Dr. Tumusiime">Dr. Tumusiime (Musculoskeletal)</option>
                        <option value="Dr. Akampa">Dr. Akampa (Body Imaging)</option>
                        <option value="Dr. Thompson">Dr. Thompson (Interventional)</option>
                    </select>
                </div>
                <div><label class="text-sm font-medium block mb-1">Expected Completion</label><input type="datetime-local" id="expectedCompletion" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="border border-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-100" data-close="assignRadiologistModal">Cancel</button>
            <button id="confirmAssignRadBtn" class="bg-primary text-white px-4 py-2 rounded-md text-sm hover:bg-primary/90">Assign</button>
        </div>
    </div>
</div>

<!-- Schedule Study Modal -->
<div id="scheduleModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header"><h2 class="modal-title" id="scheduleTitle">Schedule Study</h2><button class="modal-close" data-close="scheduleModal">&times;</button></div>
        <div class="modal-body">
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-md"><p class="text-sm"><strong>Order:</strong> <span id="schOrderId">—</span></p><p class="text-sm mt-1"><strong>Modality:</strong> <span id="schModality">—</span></p></div>
                <div><label class="text-sm font-medium block mb-1">Date</label><input type="date" id="scheduleDate" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div>
                <div><label class="text-sm font-medium block mb-1">Time Slot</label><select id="scheduleTime" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"><option value="">— Select Time —</option><option value="08:00">08:00 - 08:30</option><option value="09:00">09:00 - 09:30</option><option value="10:00">10:00 - 10:30</option><option value="11:00">11:00 - 11:30</option><option value="13:00">13:00 - 13:30</option><option value="14:00">14:00 - 14:30</option><option value="15:00">15:00 - 15:30</option></select></div>
                <div><label class="text-sm font-medium block mb-1">Room/Equipment</label><select id="scheduleRoom" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"><option value="">— Select Room —</option><option value="CT Room 1">CT Room 1</option><option value="MRI Suite">MRI Suite</option><option value="X-Ray Room 1">X-Ray Room 1</option><option value="Ultrasound Room">Ultrasound Room</option></select></div>
                <div><label class="text-sm font-medium block mb-1">Special Instructions</label><textarea id="scheduleNotes" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="e.g., Patient requires wheelchair..."></textarea></div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="border border-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-100" data-close="scheduleModal">Cancel</button>
            <button id="confirmScheduleBtn" class="bg-primary text-white px-4 py-2 rounded-md text-sm hover:bg-primary/90">Schedule</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Dialog -->
<div id="deleteConfirmDialog" class="alert-dialog-overlay">
    <div role="alertdialog" class="alert-dialog">
        <div class="alert-dialog-header"><h2 class="alert-dialog-title">Are you sure you want to cancel this order?</h2><p class="alert-dialog-description" id="deleteDesc">This action cannot be undone. The radiology order will be permanently cancelled.</p></div>
        <div class="alert-dialog-footer">
            <button class="alert-dialog-cancel" id="deleteCancelBtn">Cancel</button>
            <button class="alert-dialog-delete" id="deleteConfirmBtn">Cancel Order</button>
        </div>
    </div>
</div>

<!-- 1. Settings Manager -->
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
<!-- 4. Main Init -->
<script src="js/init.js"></script>

<script>
    let radiologyOrders = [
        { id: "ORD-001", patient: "Ssentongo John", modality: "CT", bodyPart: "Chest", priority: "Routine", status: "Completed", referringDoctor: "Dr. Ssemwogerere", radiologist: "Dr. Kibirige", orderDate: "2026-05-10", scheduledDate: "2026-05-11", completedDate: "2026-05-11", reportStatus: "Final" },
        { id: "ORD-002", patient: "Nabukenya Jane", modality: "X-Ray", bodyPart: "Left Wrist", priority: "Urgent", status: "Completed", referringDoctor: "Dr. Wamala", radiologist: "Dr. Nabwire", orderDate: "2026-05-12", scheduledDate: "2026-05-12", completedDate: "2026-05-12", reportStatus: "Final" },
        { id: "ORD-003", patient: "Robert Johnson", modality: "MRI", bodyPart: "Brain", priority: "STAT", status: "In Progress", referringDoctor: "Dr. Byaruhanga", radiologist: "Dr. Tumusiime", orderDate: "2026-05-15", scheduledDate: "2026-05-15", completedDate: null, reportStatus: "Draft" },
        { id: "ORD-004", patient: "Nakato Mary", modality: "Ultrasound", bodyPart: "Abdomen", priority: "Routine", status: "Pending", referringDoctor: "Dr. Nankya", radiologist: null, orderDate: "2026-05-16", scheduledDate: null, completedDate: null, reportStatus: null },
        { id: "ORD-005", patient: "Michael Lee", modality: "CT", bodyPart: "Head", priority: "STAT", status: "In Progress", referringDoctor: "Dr. Sentongo", radiologist: "Dr. Kibirige", orderDate: "2026-05-17", scheduledDate: "2026-05-17", completedDate: null, reportStatus: "Draft" },
        { id: "ORD-006", patient: "Wanjiru Sarah", modality: "Mammography", bodyPart: "Breast - Bilateral", priority: "Routine", status: "Pending", referringDoctor: "Dr. Wamala", radiologist: null, orderDate: "2026-05-17", scheduledDate: null, completedDate: null, reportStatus: null },
        { id: "ORD-007", patient: "Mukasa David", modality: "MRI", bodyPart: "Lumbar Spine", priority: "Urgent", status: "Pending", referringDoctor: "Dr. Byaruhanga", radiologist: null, orderDate: "2026-05-18", scheduledDate: "2026-05-19", completedDate: null, reportStatus: null },
        { id: "ORD-008", patient: "Akampola Anna", modality: "X-Ray", bodyPart: "Chest", priority: "Routine", status: "Completed", referringDoctor: "Dr. Ssemwogerere", radiologist: "Dr. Nabwire", orderDate: "2026-05-14", scheduledDate: "2026-05-14", completedDate: "2026-05-14", reportStatus: "Final" },
        { id: "ORD-009", patient: "Tumusiime Thomas", modality: "CT", bodyPart: "Abdomen/Pelvis", priority: "STAT", status: "Pending", referringDoctor: "Dr. Nankya", radiologist: null, orderDate: "2026-05-18", scheduledDate: null, completedDate: null, reportStatus: null },
        { id: "ORD-010", patient: "Nabwire Lisa", modality: "Ultrasound", bodyPart: "Thyroid", priority: "Routine", status: "Pending", referringDoctor: "Dr. Sentongo", radiologist: null, orderDate: "2026-05-19", scheduledDate: null, completedDate: null, reportStatus: null },
        { id: "ORD-011", patient: "Ssentongo James", modality: "CT", bodyPart: "Chest", priority: "STAT", status: "In Progress", referringDoctor: "Dr. Wamala", radiologist: "Dr. Akampa", orderDate: "2026-05-19", scheduledDate: "2026-05-19", completedDate: null, reportStatus: "Draft" },
        { id: "ORD-012", patient: "Nabisere Maria", modality: "X-Ray", bodyPart: "Right Ankle", priority: "Urgent", status: "Pending", referringDoctor: "Dr. Byaruhanga", radiologist: null, orderDate: "2026-05-20", scheduledDate: null, completedDate: null, reportStatus: null }
    ];

    let currentTab = "all", searchQuery = "", statusFilter = "all", modalityFilter = "all", priorityFilter = "all";
    let currentPage = 1, activeMenu = null;
    const itemsPerPage = 10;

    function openModal(modalId) {
        const el = document.getElementById(modalId);
        if (el) el.classList.add('show');
    }
    function closeModal(modalId) {
        const el = document.getElementById(modalId);
        if (el) el.classList.remove('show');
    }
    function closeAllModals() {
        document.querySelectorAll('.modal-overlay.show, .alert-dialog-overlay.show').forEach(m => m.classList.remove('show'));
    }

    function showToast(msg, err=false) {
        const e = document.querySelector('.toast-message'); if(e) e.remove();
        const t = document.createElement('div');
        t.className = `toast-message ${err?'error':''}`;
        t.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle>${err?'<line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line>':'<path d="m9 12 2 2 4-4"></path>'}</svg> ${msg}`;
        document.body.appendChild(t); setTimeout(()=>t.remove(), 3500);
    }

    function closeMenu(){ if(activeMenu){activeMenu.remove();activeMenu=null;} }

    function getStatusBadge(s) {
        const m = {'Pending':'status-pending','In Progress':'status-inprogress','Completed':'status-completed','Cancelled':'status-cancelled'};
        return `<span class="status-badge ${m[s]||'status-pending'}">${s}</span>`;
    }
    function getPriorityBadge(p) {
        const m = {'STAT':'priority-stat','Urgent':'priority-urgent','Routine':'priority-routine'};
        return `<span class="status-badge ${m[p]||'priority-routine'}">${p}</span>`;
    }
    function formatDate(d){ return d ? new Date(d).toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'}) : '—'; }
    function isOverdue(o) {
        if(o.status==='Completed'||o.status==='Cancelled') return null;
        const h = (new Date() - new Date(o.orderDate))/(1000*60*60);
        if(o.priority==='STAT'&&h>24) return 'overdue';
        if(o.priority==='Urgent'&&h>48) return 'overdue';
        if(o.priority==='Routine'&&h>72) return 'overdue-amber';
        return null;
    }

    function getFiltered() {
        let f = [...radiologyOrders];
        if(currentTab==='pending') f = f.filter(o=>o.status==='Pending');
        else if(currentTab==='inprogress') f = f.filter(o=>o.status==='In Progress');
        else if(currentTab==='completed') f = f.filter(o=>o.status==='Completed');
        if(searchQuery){ const q = searchQuery.toLowerCase(); f = f.filter(o=>o.id.toLowerCase().includes(q)||o.patient.toLowerCase().includes(q)||o.referringDoctor.toLowerCase().includes(q)||o.modality.toLowerCase().includes(q)||o.bodyPart.toLowerCase().includes(q)||(o.radiologist&&o.radiologist.toLowerCase().includes(q))); }
        if(statusFilter!=='all') f = f.filter(o=>o.status===statusFilter);
        if(modalityFilter!=='all') f = f.filter(o=>o.modality===modalityFilter);
        if(priorityFilter!=='all') f = f.filter(o=>o.priority===priorityFilter);
        return f;
    }

    function updateStats() {
        document.getElementById('statTotal').innerText = radiologyOrders.length;
        document.getElementById('statPending').innerText = radiologyOrders.filter(o=>o.status==='Pending').length;
        document.getElementById('statInProgress').innerText = radiologyOrders.filter(o=>o.status==='In Progress').length;
        document.getElementById('statCompleted').innerText = radiologyOrders.filter(o=>o.status==='Completed').length;
    }
    // Radix-style Select for Update Status Modal
(function() {
    const trigger = document.getElementById('newStatusSelectTrigger');
    const content = document.getElementById('newStatusSelectContent');
    const text = document.getElementById('newStatusSelectText');
    const hiddenInput = document.getElementById('newStatusSelect');
    const wrapper = document.getElementById('newStatusSelectWrapper');
    const items = content.querySelectorAll('.select-item');
    let isOpen = false;

    function openSelect() {
        content.classList.remove('hidden');
        content.style.width = trigger.offsetWidth + 'px';
        isOpen = true;
        // Highlight current selection
        const currentVal = hiddenInput.value;
        items.forEach(item => {
            item.classList.toggle('selected', item.dataset.value === currentVal);
        });
    }

    function closeSelect() {
        content.classList.add('hidden');
        isOpen = false;
    }

    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        if (isOpen) closeSelect();
        else openSelect();
    });

    items.forEach(item => {
        item.addEventListener('click', () => {
            const value = item.dataset.value;
            hiddenInput.value = value;
            text.textContent = value;
            closeSelect();
        });
    });

    // Close when clicking outside
    document.addEventListener('click', (e) => {
        if (!wrapper.contains(e.target)) {
            closeSelect();
        }
    });

    // Close on Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && isOpen) {
            closeSelect();
            trigger.focus();
        }
    });

    // Keyboard navigation
    trigger.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ' || e.key === 'ArrowDown') {
            e.preventDefault();
            openSelect();
            if (items.length > 0) items[0].focus();
        }
    });

    content.addEventListener('keydown', (e) => {
        const focused = document.activeElement;
        const currentIndex = Array.from(items).indexOf(focused);

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            const next = currentIndex < items.length - 1 ? items[currentIndex + 1] : items[0];
            next.focus();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            const prev = currentIndex > 0 ? items[currentIndex - 1] : items[items.length - 1];
            prev.focus();
        } else if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            if (focused && focused.classList.contains('select-item')) {
                focused.click();
            }
        }
    });

    // Make items focusable
    items.forEach(item => item.setAttribute('tabindex', '-1'));

    // Expose method to set value programmatically
    window.setNewStatusValue = function(value) {
        hiddenInput.value = value;
        text.textContent = value;
        items.forEach(item => {
            item.classList.toggle('selected', item.dataset.value === value);
        });
    };
})();

    function renderTable() {
        const f = getFiltered(), tp = Math.ceil(f.length/itemsPerPage);
        if(currentPage>tp) currentPage = tp||1;
        const s = (currentPage-1)*itemsPerPage, p = f.slice(s,s+itemsPerPage);
        const tbody = document.getElementById('radiologyTableBody');
        tbody.innerHTML = p.length===0 ? '<tr><td colspan="9" class="text-center py-10 text-gray-500">No radiology orders found</td></tr>' :
            p.map(o=>`<tr class="border-b data-row ${isOverdue(o)||''} cursor-pointer" data-id="${o.id}">
                <td class="p-4 font-medium text-indigo-600">${o.id}</td><td class="p-4">${o.patient}</td>
                <td class="p-4 hidden md:table-cell">${o.modality}</td><td class="p-4 hidden lg:table-cell">${o.bodyPart}</td>
                <td class="p-4 hidden lg:table-cell">${o.referringDoctor}</td><td class="p-4">${getPriorityBadge(o.priority)}</td>
                <td class="p-4">${getStatusBadge(o.status)}</td><td class="p-4 hidden md:table-cell text-gray-500">${formatDate(o.orderDate)}</td>
                <td class="p-4 text-right"><button class="action-trigger inline-flex items-center justify-center h-10 w-10 rounded-md hover:bg-gray-100" data-id="${o.id}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button></td>
            </tr>`).join('');

        document.getElementById('showingText').innerText = f.length===0?'No orders found':`Showing ${s+1}-${Math.min(s+itemsPerPage,f.length)} of ${f.length} orders`;
        document.getElementById('prevPageBtn').disabled = currentPage<=1;
        document.getElementById('nextPageBtn').disabled = currentPage>=tp;
        document.querySelectorAll('.page-btn').forEach(b=>{const pg=parseInt(b.dataset.page);b.classList.toggle('bg-primary',pg===currentPage);b.classList.toggle('text-white',pg===currentPage);});

        document.querySelectorAll('.action-trigger').forEach(b=>{b.addEventListener('click',e=>{e.stopPropagation();const o=radiologyOrders.find(x=>x.id===b.dataset.id);if(o)showActionMenu(b,o);});});
    }

    function showActionMenu(btn, o) {
        closeMenu(); const r=btn.getBoundingClientRect(); const m=document.createElement('div'); m.className='action-menu';
        let l=r.left, t=r.bottom+6; if(l+230>innerWidth) l=innerWidth-240; if(t+420>innerHeight) t=r.top-430; if(l<10)l=10;if(t<10)t=10;
        m.style.top=t+'px'; m.style.left=l+'px';
        m.innerHTML=`<div class="action-menu-header">Actions - ${o.id}</div>
            <button data-action="view" class="action-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle></svg>View Details</button>
            <button data-action="updateStatus" class="action-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path><path d="M8 16H3v5"></path></svg>Update Status</button>
            <button data-action="assignRad" class="action-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><polyline points="16 11 18 13 22 9"></polyline></svg>Assign Radiologist</button>
            <button data-action="schedule" class="action-item"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"></rect><path d="M16 2v4"></path><path d="M8 2v4"></path><path d="M3 10h18"></path></svg>Schedule Study</button>
            <div class="action-divider"></div>
            <button data-action="delete" class="action-item text-red-600"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>Cancel Order</button>`;
        document.body.appendChild(m); activeMenu=m;
        m.addEventListener('click',e=>{const a=e.target.closest('[data-action]')?.dataset.action;if(!a)return;closeMenu();
            if(a==='view') location.href=`radiology-details.html?id=${o.id}`;
            else if(a==='updateStatus') openUpdateStatus(o);
            else if(a==='assignRad') openAssignRad(o);
            else if(a==='schedule') openSchedule(o);
            else if(a==='delete') showDeleteDialog(o);
        });
        setTimeout(()=>document.addEventListener('click',function h(e){if(!m.contains(e.target)){closeMenu();document.removeEventListener('click',h);}},{once:false}),10);
    }

    function openUpdateStatus(o) {
        document.getElementById('usOrderId').innerText=o.id; document.getElementById('usCurrentStatus').innerHTML=getStatusBadge(o.status);
        if(window.setNewStatusValue) window.setNewStatusValue(o.status); document.getElementById('statusNotes').value='';
        document.getElementById('updateStatusModal')._order=o; openModal('updateStatusModal');
    }
    function openAssignRad(o) {
        document.getElementById('arOrderId').innerText=o.id; document.getElementById('arCurrentRad').innerText=o.radiologist||'Unassigned';
        document.getElementById('radiologistSelect').value=''; document.getElementById('expectedCompletion').value='';
        document.getElementById('assignRadiologistModal')._order=o; openModal('assignRadiologistModal');
    }
    function openSchedule(o) {
        document.getElementById('schOrderId').innerText=o.id; document.getElementById('schModality').innerText=o.modality;
        document.getElementById('scheduleDate').value=o.scheduledDate||new Date().toISOString().split('T')[0];
        document.getElementById('scheduleTime').value=''; document.getElementById('scheduleRoom').value=''; document.getElementById('scheduleNotes').value='';
        document.getElementById('scheduleModal')._order=o; openModal('scheduleModal');
    }
    function showDeleteDialog(o) {
        document.getElementById('deleteDesc').innerText=`This action cannot be undone. The radiology order "${o.id}" for patient "${o.patient}" will be permanently cancelled.`;
        document.getElementById('deleteConfirmDialog')._order=o; openModal('deleteConfirmDialog');
    }

    document.getElementById('confirmStatusBtn').addEventListener('click',()=>{
        const m=document.getElementById('updateStatusModal'), o=m._order;
        if(o){o.status=document.getElementById('newStatusSelect').value;if(o.status==='Completed')o.completedDate=new Date().toISOString().split('T')[0];renderTable();updateStats();showToast(`Order ${o.id} updated to ${o.status}`);}
        closeModal('updateStatusModal');
    });
    document.getElementById('confirmAssignRadBtn').addEventListener('click',()=>{
        const m=document.getElementById('assignRadiologistModal'), o=m._order, rad=document.getElementById('radiologistSelect').value;
        if(!rad){showToast('Please select a radiologist',true);return;}
        if(o){o.radiologist=rad;if(o.status==='Pending')o.status='In Progress';renderTable();updateStats();showToast(`${rad} assigned to ${o.id}`);}
        closeModal('assignRadiologistModal');
    });
    document.getElementById('confirmScheduleBtn').addEventListener('click',()=>{
        const m=document.getElementById('scheduleModal'), o=m._order, d=document.getElementById('scheduleDate').value, t=document.getElementById('scheduleTime').value;
        if(!d||!t){showToast('Please select date and time',true);return;}
        if(o){o.scheduledDate=d;showToast(`Study ${o.id} scheduled for ${formatDate(d)} at ${t}`);}
        closeModal('scheduleModal');
    });
    document.getElementById('deleteConfirmBtn').addEventListener('click',()=>{
        const d=document.getElementById('deleteConfirmDialog'), o=d._order;
        if(o){o.status='Cancelled';renderTable();updateStats();showToast(`Order ${o.id} has been cancelled`);}
        closeModal('deleteConfirmDialog');
    });
    document.getElementById('deleteCancelBtn').addEventListener('click',()=>closeModal('deleteConfirmDialog'));

    document.querySelectorAll('.modal-close, [data-close]').forEach(b=>{b.addEventListener('click',e=>{e.stopPropagation();const id=b.dataset.close||b.closest('.modal-overlay, .alert-dialog-overlay')?.id;if(id)closeModal(id);});});
    document.querySelectorAll('.modal-overlay, .alert-dialog-overlay').forEach(o=>{o.addEventListener('click',function(e){if(e.target===this)closeModal(this.id);});});
    document.addEventListener('keydown',e=>{if(e.key==='Escape'){closeAllModals();closeMenu();}});

    document.getElementById('searchInput').addEventListener('input',e=>{searchQuery=e.target.value;currentPage=1;renderTable();});
    function initFD(bid,did,tid,sf){const b=document.getElementById(bid),d=document.getElementById(did),t=document.getElementById(tid);b.addEventListener('click',e=>{e.stopPropagation();document.querySelectorAll('[id$="FilterDropdown"]').forEach(x=>{if(x!==d)x.classList.add('hidden');});d.classList.toggle('hidden');});d.querySelectorAll('.filter-option').forEach(o=>{o.addEventListener('click',()=>{t.textContent=o.textContent.trim();d.classList.add('hidden');sf(o.dataset.value);currentPage=1;renderTable();});});}
    initFD('statusFilterBtn','statusFilterDropdown','statusFilterText',v=>{statusFilter=v;});
    initFD('modalityFilterBtn','modalityFilterDropdown','modalityFilterText',v=>{modalityFilter=v;});
    initFD('priorityFilterBtn','priorityFilterDropdown','priorityFilterText',v=>{priorityFilter=v;});
    document.addEventListener('click',e=>{if(!e.target.closest('[id$="FilterBtn"]')&&!e.target.closest('[id$="FilterDropdown"]'))document.querySelectorAll('[id$="FilterDropdown"]').forEach(d=>d.classList.add('hidden'));});

    document.querySelectorAll('.tab-btn').forEach(b=>{b.addEventListener('click',()=>{currentTab=b.dataset.tab;currentPage=1;document.querySelectorAll('.tab-btn').forEach(x=>x.classList.remove('active','bg-white','shadow-sm','text-gray-900'));b.classList.add('active','bg-white','shadow-sm','text-gray-900');renderTable();});});
    document.getElementById('prevPageBtn').addEventListener('click',()=>{if(currentPage>1){currentPage--;renderTable();}});
    document.getElementById('nextPageBtn').addEventListener('click',()=>{if(currentPage<Math.ceil(getFiltered().length/itemsPerPage)){currentPage++;renderTable();}});
    document.querySelectorAll('.page-btn').forEach(b=>b.addEventListener('click',()=>{currentPage=parseInt(b.dataset.page);renderTable();}));

    document.getElementById('cardPending').addEventListener('click',()=>activateTab('pending'));
    document.getElementById('cardInProgress').addEventListener('click',()=>activateTab('inprogress'));
    document.getElementById('cardCompleted').addEventListener('click',()=>activateTab('completed'));
    document.getElementById('cardTotal').addEventListener('click',()=>activateTab('all'));
    function activateTab(t){currentTab=t;currentPage=1;document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active','bg-white','shadow-sm','text-gray-900'));const tb=document.querySelector(`[data-tab="${t}"]`);if(tb)tb.classList.add('active','bg-white','shadow-sm','text-gray-900');renderTable();}

    document.getElementById('addOrderBtn').addEventListener('click',()=>{location.href='add-radiology.html';});
    document.getElementById('goToScheduleBtn').addEventListener('click',()=>{location.href='radiology-schedule.html';});
    document.getElementById('goToReportsBtn').addEventListener('click',()=>{location.href='radiology-reports.html';});

    updateStats(); renderTable(); closeAllModals();
</script>
    <script src="js/meditrack-security.js"></script>
    <script src="js/meditrack.js"></script>
    <script src="js/meditrack-realtime.js"></script>
    <script src="js/meditrack-language.js"></script>
    <script src="js/meditrack-flags.js"></script>
    <script src="js/meditrack-avatars.js"></script>
    <script src="js/meditrack-nav-confirm.js"></script>
    <script src="js/meditrack-store.js"></script>
    <script src="js/meditrack-apex-data.js"></script>
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
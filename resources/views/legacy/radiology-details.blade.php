<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Radiology Details - ORD-003</title>
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

        .tab-trigger { transition: all 0.2s ease; color: #6b7280; }
        .tab-trigger.active { background-color: white; color: #1f2937; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        body.dark .tab-trigger.active { background-color: #131212; color: #e5e5e5; }
        .tab-panel { animation: fadeIn 0.2s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }

        .action-menu {
            position: fixed;
            z-index: 100;
            min-width: 200px;
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
            padding: 0.25rem;
            animation: fadeInScale 0.12s ease-out;
        }
        body.dark .action-menu { background: #1e293b; border-color: #334155; }
        .action-menu-header {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 0.25rem;
        }
        body.dark .action-menu-header { border-bottom-color: #334155; color: #9ca3af; }
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
        body.dark .action-item:hover { background-color: #334155; }
        .action-divider { height: 1px; background-color: #e5e7eb; margin: 0.25rem 0; }
        body.dark .action-divider { background-color: #334155; }
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
        .modal-container.wide { max-width: 800px; }
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
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }

        .status-badge { display: inline-flex; align-items: center; gap: 4px; border-radius: 9999px; padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 600; }
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

        .timeline-item { position: relative; padding-left: 2rem; padding-bottom: 1.5rem; }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 7px;
            top: 24px;
            bottom: 0;
            width: 2px;
            background-color: #e5e7eb;
        }
        body.dark .timeline-item::before { background-color: #374151; }
        .timeline-item:last-child::before { display: none; }
        .timeline-dot {
            position: absolute;
            left: 0;
            top: 4px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid #6366f1;
            background-color: white;
        }
        body.dark .timeline-dot { background-color: #1e293b; }
        .timeline-dot.active { background-color: #6366f1; }

        .image-thumb {
            width: 60px;
            height: 60px;
            border-radius: 0.375rem;
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
            overflow: hidden;
        }
        .image-thumb:hover { border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99,102,241,0.2); }
        body.dark .image-thumb { background-color: #1e293b; border-color: #334155; }

        .report-draft { background-color: #fef3c7; color: #92400e; }
        .report-final { background-color: #dcfce7; color: #166534; }
        .report-amended { background-color: #dbeafe; color: #1e40af; }

        input:focus, textarea:focus, select:focus {
            outline: none;
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 2px rgba(99,102,241,0.2) !important;
        }

                /* Alert Dialog */
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

            <!-- Main Content: Schedule Page -->
            <main class="flex-1 overflow-auto p-4 xl:p-6 xl:ml-64 w-full">
        <div class="flex flex-col gap-4">

            <!-- Breadcrumb and Header -->
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between flex-wrap">
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="radiology-list.html" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background size-10 hover:bg-accent hover:text-accent-foreground h-10">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                    </a>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold tracking-tight" id="detailOrderId">ORD-003</h1>
                        <p class="text-sm text-gray-500">Patient: <span id="detailPatient" class="font-medium text-gray-700">Robert Johnson</span> • Modality: <span id="detailModality" class="font-medium text-gray-700">MRI</span> • Body Part: <span id="detailBodyPart" class="font-medium text-gray-700">Brain</span></p>
                    </div>
                    <span id="statusBadge" class="status-badge status-inprogress ml-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-loader-circle"><path d="M21 12a9 9 0 1 1-6.219-8.56"></path></svg>
                        In Progress
                    </span>
                    <div class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-purple-100 text-purple-800" id="templateBadge">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text mr-1"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path></svg>
                        MRI Brain Template
                    </div>
                </div>
                <div class="flex flex-col gap-2 sm:flex-row">
                    <button id="editOrderBtn" class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium border border-gray-300 bg-background hover:bg-gray-50 h-10 px-4 py-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path><path d="m15 5 4 4"></path></svg>
                        Edit Order
                    </button>
                    <button id="updateStatusBtn" class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-refresh-cw"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path><path d="M8 16H3v5"></path></svg>
                        Update Status
                    </button>
                </div>
            </div>

<div class="grid gap-4 md:grid-cols-4">
    <!-- Status Card -->
    <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition">
        <div class="p-4 pb-2">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium text-gray-500">Status</h2>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-activity text-blue-400">
                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                </svg>
            </div>
        </div>
        <div class="p-4 pt-0">
            <div class="text-xl font-bold text-blue-600" id="statStatus">In Progress</div>
            <p class="text-xs text-gray-400 mt-1">Updated: Today, 10:15 AM</p>
        </div>
    </div>

    <!-- Modality Card -->
    <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition">
        <div class="p-4 pb-2">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium text-gray-500">Modality</h2>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-scan text-purple-400">
                    <path d="M3 7V5a2 2 0 0 1 2-2h2"></path>
                    <path d="M17 3h2a2 2 0 0 1 2 2v2"></path>
                    <path d="M21 17v2a2 2 0 0 1-2 2h-2"></path>
                    <path d="M7 21H5a2 2 0 0 1-2-2v-2"></path>
                </svg>
            </div>
        </div>
        <div class="p-4 pt-0">
            <div class="text-xl font-bold text-purple-600" id="statModality">MRI</div>
            <p class="text-xs text-gray-400 mt-1" id="statBodyPart">Brain</p>
        </div>
    </div>

    <!-- Referring Doctor Card -->
    <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition">
        <div class="p-4 pb-2">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium text-gray-500">Referring Doctor</h2>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-stethoscope text-green-400">
                    <path d="M4.8 2.3A.3.3 0 1 0 5 2H4a2 2 0 0 0-2 2v5a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6V4a2 2 0 0 0-2-2h-1a.2.2 0 1 0 .3.3"></path>
                    <path d="M8 15v1a6 6 0 0 0 6 6v0a6 6 0 0 0 6-6v-4"></path>
                    <circle cx="20" cy="10" r="2"></circle>
                </svg>
            </div>
        </div>
        <div class="p-4 pt-0">
            <div class="text-xl font-bold text-green-600" id="statDoctor">Dr. Byaruhanga</div>
            <p class="text-xs text-gray-400 mt-1">Neurology</p>
        </div>
    </div>

    <!-- Radiologist Card -->
    <div class="rounded-lg border bg-background shadow-sm hover:shadow-md transition">
        <div class="p-4 pb-2">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium text-gray-500">Radiologist</h2>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-check text-indigo-400">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <polyline points="16 11 18 13 22 9"></polyline>
                </svg>
            </div>
        </div>
        <div class="p-4 pt-0">
            <div class="text-xl font-bold text-indigo-600" id="statRadiologist">Dr. Tumusiime</div>
            <p class="text-xs text-gray-400 mt-1">Neuroradiology</p>
        </div>
    </div>
</div>

            <!-- Tabs Container -->
            <div dir="ltr" data-orientation="horizontal" class="w-full">
                <div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1 text-gray-500 dark:bg-gray-800" id="tabList">
                    <button type="button" data-tab="overview" class="tab-trigger active inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text mr-1.5"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path></svg>Overview
                    </button>
                    <button type="button" data-tab="images" class="tab-trigger inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image mr-1.5"><rect width="18" height="18" x="3" y="3" rx="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>Images
                    </button>
                    <button type="button" data-tab="report" class="tab-trigger inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-list mr-1.5"><rect width="8" height="4" x="8" y="2" rx="1"></rect><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><path d="M12 11h4"></path><path d="M12 16h4"></path><path d="M8 11h.01"></path><path d="M8 16h.01"></path></svg>Report
                    </button>
                    <button type="button" data-tab="timeline" class="tab-trigger inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock mr-1.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>Timeline
                    </button>
                </div>

                <!-- TAB 1: Overview -->
                <div id="tab-overview" class="tab-panel mt-4">
                    <div class="rounded-lg border bg-background shadow-sm">
                        <div class="p-4 border-b"><h2 class="text-xl font-semibold">Order Overview</h2><p class="text-gray-500 text-sm">Complete order information and clinical details.</p></div>
                        <div class="p-6">
                            <div class="grid gap-6 md:grid-cols-2">
                                <div>
                                    <h3 class="mb-4 text-lg font-medium flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-list"><rect width="8" height="4" x="8" y="2" rx="1"></rect><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path></svg>Order Information</h3>
                                    <dl class="grid grid-cols-2 gap-3 text-sm">
                                        <dt class="font-medium text-gray-500">Order ID:</dt><dd class="font-medium" id="ovOrderId">ORD-003</dd>
                                        <dt class="font-medium text-gray-500">Patient:</dt><dd id="ovPatient">Robert Johnson</dd>
                                        <dt class="font-medium text-gray-500">Modality:</dt><dd id="ovModality">MRI</dd>
                                        <dt class="font-medium text-gray-500">Body Part:</dt><dd id="ovBodyPart">Brain</dd>
                                        <dt class="font-medium text-gray-500">Priority:</dt><dd id="ovPriority"><span class="status-badge priority-stat">STAT</span></dd>
                                        <dt class="font-medium text-gray-500">Status:</dt><dd id="ovStatus"><span class="status-badge status-inprogress">In Progress</span></dd>
                                        <dt class="font-medium text-gray-500">Order Date:</dt><dd id="ovOrderDate">May 15, 2026</dd>
                                        <dt class="font-medium text-gray-500">Scheduled Date:</dt><dd id="ovScheduledDate">May 15, 2026</dd>
                                        <dt class="font-medium text-gray-500">Completed Date:</dt><dd id="ovCompletedDate">—</dd>
                                    </dl>
                                </div>
                                <div>
                                    <h3 class="mb-4 text-lg font-medium flex items-center gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>Clinical Details</h3>
                                    <dl class="grid grid-cols-2 gap-3 text-sm">
                                        <dt class="font-medium text-gray-500">Referring Doctor:</dt><dd id="ovDoctor">Dr. Byaruhanga</dd>
                                        <dt class="font-medium text-gray-500">Radiologist:</dt><dd id="ovRadiologist">Dr. Tumusiime</dd>
                                        <dt class="font-medium text-gray-500">Protocol:</dt><dd id="ovProtocol">MRI Brain with and without contrast</dd>
                                        <dt class="font-medium text-gray-500">Contrast:</dt><dd id="ovContrast"><span class="inline-flex items-center gap-1 text-green-600"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg> Yes - Gadolinium</span></dd>
                                        <dt class="font-medium text-gray-500">Clinical History:</dt><dd id="ovHistory" class="col-span-2 mt-1 text-gray-600">Recurrent headaches, visual disturbances. Rule out intracranial pathology.</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: Images -->
                <div id="tab-images" class="tab-panel hidden mt-4">
                    <div class="rounded-lg border bg-background shadow-sm">
                        <div class="p-4 border-b flex items-center justify-between flex-wrap gap-3">
                            <div><h2 class="text-xl font-semibold">Images & Files</h2><p class="text-gray-500 text-sm">Uploaded DICOM images and associated files.</p></div>
                            <button id="uploadImageBtn" class="bg-primary text-white hover:bg-primary/90 h-9 px-4 rounded-md text-sm flex items-center gap-2 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" x2="12" y1="3" y2="15"></line></svg>Upload Images
                            </button>
                        </div>
                        <div class="p-6">
                            <div class="rounded-md border overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-50 border-b dark:bg-gray-800">
                                        <tr>
                                            <th class="px-4 py-3 text-left">Thumbnail</th>
                                            <th class="px-4 py-3 text-left">Image ID</th>
                                            <th class="px-4 py-3 text-left">View / Series</th>
                                            <th class="px-4 py-3 text-left hidden md:table-cell">File Name</th>
                                            <th class="px-4 py-3 text-left hidden lg:table-cell">Upload Date</th>
                                            <th class="px-4 py-3 text-left hidden lg:table-cell">Uploaded By</th>
                                            <th class="px-4 py-3 text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="imagesTableBody"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 3: Report -->
                <div id="tab-report" class="tab-panel hidden mt-4">
                    <div class="rounded-lg border bg-background shadow-sm">
                        <div class="p-4 border-b flex items-center justify-between flex-wrap gap-3">
                            <div><h2 class="text-xl font-semibold">Radiology Report</h2><p class="text-gray-500 text-sm">Findings, impression, and recommendations.</p></div>
                            <div class="flex gap-2">
                                <span id="reportStatusBadge" class="status-badge report-draft">Draft</span>
                                <button id="editReportBtn" class="border border-gray-300 bg-background hover:bg-gray-50 h-9 px-3 rounded-md text-sm flex items-center gap-2 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path><path d="m15 5 4 4"></path></svg>Edit Report
                                </button>
                            </div>
                        </div>
                        <div class="p-6 space-y-5">
                            <div><h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Findings</h3><p class="text-sm leading-relaxed" id="reportFindings">Multiple hyperintense lesions in the periventricular white matter on T2/FLAIR sequences. Several lesions show enhancement with gadolinium contrast, suggesting active inflammation. No significant mass effect or midline shift identified. Ventricular size is within normal limits.</p></div>
                            <div class="border-t pt-4"><h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Impression</h3><p class="text-sm leading-relaxed font-medium" id="reportImpression">1. Multiple enhancing white matter lesions consistent with active demyelinating disease.<br>2. Findings are suggestive of Multiple Sclerosis (McDonald criteria).<br>3. Clinical correlation and neurology follow-up recommended.</p></div>
                            <div class="border-t pt-4"><h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-2">Recommendations</h3><p class="text-sm leading-relaxed" id="reportRecommendations">1. Neurology consultation recommended.<br>2. Consider MRI of the cervical and thoracic spine to evaluate for additional lesions.<br>3. Follow-up brain MRI in 6 months to assess disease progression.</p></div>
                            <div class="border-t pt-4 flex flex-col sm:flex-row justify-between gap-4">
                                <div class="text-sm"><p><strong>Reporting Radiologist:</strong> <span id="reportRadiologist">Dr. Tumusiime</span></p><p><strong>Report Date:</strong> <span id="reportDate">May 16, 2026</span></p></div>
                                <div class="flex gap-2">
                                    <button id="markFinalBtn" class="bg-green-600 text-white hover:bg-green-700 h-9 px-4 rounded-md text-sm font-medium transition-colors flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check"><polyline points="20 6 9 17l-5-5"></polyline></svg>Mark as Final
                                    </button>
                                    <button id="printReportBtn" class="border border-gray-300 bg-background hover:bg-gray-50 h-9 px-3 rounded-md text-sm transition-colors flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-printer"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 12H4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2h-2"></path><rect width="12" height="8" x="6" y="14"></rect></svg>Print
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 4: Timeline -->
                <div id="tab-timeline" class="tab-panel hidden mt-4">
                    <div class="rounded-lg border bg-background shadow-sm">
                        <div class="p-4 border-b"><h2 class="text-xl font-semibold">Order Timeline</h2><p class="text-gray-500 text-sm">Complete history of this radiology order.</p></div>
                        <div class="p-6"><div id="timelineContainer" class="space-y-0"></div></div>
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
        <div class="modal-header">
            <h2 class="modal-title">Update Status - <span id="usModalOrderId">ORD-003</span></h2>
            <button class="modal-close" data-close="updateStatusModal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-md">
                    <p class="text-sm"><strong>Current Status:</strong> <span id="usCurrentStatus">In Progress</span></p>
                </div>
                <div>
                    <label class="text-sm font-medium block mb-1">New Status</label>
                    <select id="newStatusSelect" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm">
                        <option value="Pending">Pending</option>
                        <option value="In Progress" selected>In Progress</option>
                        <option value="Completed">Completed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium block mb-1">Notes</label>
                    <textarea id="statusNotes" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Reason for status change..."></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="border border-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-100" data-close="updateStatusModal">Cancel</button>
            <button id="confirmStatusBtn" class="bg-primary text-white px-4 py-2 rounded-md text-sm hover:bg-primary/90">Update Status</button>
        </div>
    </div>
</div>

<!-- Upload Image Modal -->
<div id="uploadImageModal" class="modal-overlay">
    <div class="modal-container">
        <div class="modal-header">
            <h2 class="modal-title">Upload Images - <span id="uiModalOrderId">ORD-003</span></h2>
            <button class="modal-close" data-close="uploadImageModal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="space-y-4">
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-indigo-400 transition-colors cursor-pointer" id="dropZone">
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-upload-cloud mx-auto text-gray-400 mb-3"><path d="M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242"></path><path d="M12 12v9"></path><path d="m16 16-4-4-4 4"></path></svg>
                    <p class="text-sm text-gray-500">Drag & drop DICOM files here, or <span class="text-indigo-600 font-medium">browse</span></p>
                    <p class="text-xs text-gray-400 mt-1">Supported: .dcm, .jpg, .png (Max 50MB per file)</p>
                    <input type="file" id="fileInput" class="hidden" accept=".dcm,.jpg,.jpeg,.png" multiple>
                </div>
                <div id="fileList" class="space-y-2"></div>
                <div class="grid md:grid-cols-2 gap-4">
                    <div><label class="text-sm font-medium block mb-1">View / Series</label><input type="text" id="imageView" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="e.g., Axial T2, Sagittal T1..."></div>
                    <div><label class="text-sm font-medium block mb-1">Sequence (if applicable)</label><input type="text" id="imageSequence" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="e.g., T1, T2, FLAIR, DWI..."></div>
                </div>
                <div><label class="text-sm font-medium block mb-1">Notes</label><textarea id="imageNotes" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Any notes about this image..."></textarea></div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="border border-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-100" data-close="uploadImageModal">Cancel</button>
            <button id="confirmUploadBtn" class="bg-primary text-white px-4 py-2 rounded-md text-sm hover:bg-primary/90">Upload</button>
        </div>
    </div>
</div>

<!-- PACS Image Viewer Modal -->
<div id="viewImageModal" class="modal-overlay">
    <div class="modal-container wide" style="max-width:95vw; width:95vw;">
        <div class="modal-header" style="background: #1a1a1a; color: #fff; border-bottom: 1px solid #333;">
            <div class="flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-indigo-400"><path d="M4.18 4.18A2 2 0 0 0 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 1.82-1.18"/><path d="M21 15.5V6a2 2 0 0 0-2-2H9.5"/><path d="M16 2v4"/><path d="M12 2v4"/><path d="M8 2v4"/><path d="M20 10H4"/></svg>
                <div>
                    <h2 class="modal-title" id="viewImageTitle" style="color:#fff;">PACS Image Viewer</h2>
                    <p class="text-xs text-gray-400" id="viewImageInfo">DICOM Viewer — Mulago PACS</p>
                </div>
            </div>
            <button class="modal-close" data-close="viewImageModal" style="color:#fff;">&times;</button>
        </div>

        <!-- PACS Toolbar -->
        <div style="background: #2a2a2a; padding: 8px 16px; display: flex; gap: 4px; flex-wrap: wrap; border-bottom: 1px solid #333; align-items: center;" id="pacsToolbar">
            <button class="pacs-tool-btn" data-tool="zoomin" title="Zoom In"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg></button>
            <button class="pacs-tool-btn" data-tool="zoomout" title="Zoom Out"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="8" y1="11" x2="14" y2="11"/></svg></button>
            <button class="pacs-tool-btn" data-tool="reset" title="Reset View"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg></button>
            <button class="pacs-tool-btn" data-tool="fit" title="Fit to Window"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h6v6"/><path d="M9 21H3v-6"/><path d="M21 3l-7 7"/><path d="M3 21l7-7"/></svg></button>
            <div style="width:1px; background:#444; margin:0 4px; height:20px;"></div>
            <button class="pacs-tool-btn" data-tool="rotate" title="Rotate 90°"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg></button>
            <button class="pacs-tool-btn" data-tool="flip" title="Flip Horizontal"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v18"/><path d="M16 7l4 5-4 5"/><path d="M8 7l-4 5 4 5"/></svg></button>
            <button class="pacs-tool-btn" data-tool="invert" title="Invert Colors"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2v20"/></svg></button>
            <div style="width:1px; background:#444; margin:0 4px; height:20px;"></div>
            <button class="pacs-tool-btn" data-tool="measure" title="Measure Distance"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.3 8.7 8.7 21.3a2.4 2.4 0 0 1-3.4 0L2.7 18.7a2.4 2.4 0 0 1 0-3.4L15.3 2.7a2.4 2.4 0 0 1 3.4 0l2.6 2.6a2.4 2.4 0 0 1 0 3.4Z"/></svg></button>
            <button class="pacs-tool-btn" data-tool="annotate" title="Annotate"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></button>
            <div style="width:1px; background:#444; margin:0 4px; height:20px;"></div>
            <div style="display:flex; align-items:center; gap:6px; color:#ccc; font-size:11px;">
                <span>B</span>
                <input type="range" id="pacsBrightness" min="0" max="200" value="100" style="width:80px;" title="Brightness">
            </div>
            <div style="display:flex; align-items:center; gap:6px; color:#ccc; font-size:11px;">
                <span>C</span>
                <input type="range" id="pacsContrast" min="0" max="200" value="100" style="width:80px;" title="Contrast">
            </div>
        </div>

        <!-- PACS Viewer Body -->
        <div style="display:flex; background:#000; min-height:520px;">
            <div id="pacsSeriesSidebar" style="width:120px; background:#1a1a1a; padding:8px; overflow-y:auto; border-right:1px solid #333;">
                <div style="color:#888; font-size:10px; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px;">Series</div>
                <div id="pacsSeriesList" style="display:flex; flex-direction:column; gap:6px;"></div>
            </div>

            <div style="flex:1; position:relative; overflow:hidden;" id="pacsViewport">
                <div id="viewImageLoading" style="position:absolute; inset:0; display:flex; align-items:center; justify-content:center; color:#888; flex-direction:column; gap:8px;">
                    <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-gray-700 border-t-indigo-600"></div>
                    <p class="text-sm">Loading DICOM image...</p>
                </div>
                <canvas id="pacsCanvas" width="800" height="600" style="display:none; cursor:grab;"></canvas>

                <div id="pacsOverlayInfo" style="position:absolute; top:8px; left:8px; color:#0f0; font-family:monospace; font-size:11px; text-shadow:0 0 4px #000; pointer-events:none;">
                    <div id="pacsPatientInfo">Patient: —</div>
                    <div id="pacsStudyInfo">Study: —</div>
                    <div id="pacsImageInfo">Image: —</div>
                </div>
                <div id="pacsOverlayWL" style="position:absolute; top:8px; right:8px; color:#0f0; font-family:monospace; font-size:11px; text-shadow:0 0 4px #000; pointer-events:none; text-align:right;">
                    <div>W: <span id="pacsWindow">400</span></div>
                    <div>L: <span id="pacsLevel">40</span></div>
                    <div>Zoom: <span id="pacsZoomDisplay">100%</span></div>
                </div>
                <div id="pacsMeasureReadout" style="position:absolute; bottom:8px; left:8px; color:#ff0; font-family:monospace; font-size:11px; text-shadow:0 0 4px #000; pointer-events:none; display:none;">
                    Distance: <span id="pacsDistance">0.00 mm</span>
                </div>
                <div id="pacsSliceControl" style="position:absolute; bottom:8px; right:8px; display:none; align-items:center; gap:8px; background:rgba(0,0,0,0.6); padding:6px 10px; border-radius:4px;">
                    <button class="pacs-tool-btn" id="pacsPrevSlice" style="padding:2px 6px;">◄</button>
                    <input type="range" id="pacsSliceSlider" min="1" max="1" value="1" style="width:120px;">
                    <span style="color:#fff; font-size:11px; font-family:monospace;"><span id="pacsSliceNum">1</span>/<span id="pacsSliceTotal">1</span></span>
                    <button class="pacs-tool-btn" id="pacsNextSlice" style="padding:2px 6px;">►</button>
                </div>
            </div>
        </div>

        <div class="modal-footer" style="background:#1a1a1a; border-top:1px solid #333;">
            <div class="text-xs text-gray-400" id="viewImageDetails" style="flex:1;">File: —</div>
            <button class="border border-gray-600 text-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-800" data-close="viewImageModal">Close</button>
            <button id="pacsDownloadBtn" class="bg-primary text-white px-4 py-2 rounded-md text-sm hover:bg-primary/90 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg>
                Download DICOM
            </button>
            <button id="pacsExportJpegBtn" class="bg-emerald-600 text-white px-4 py-2 rounded-md text-sm hover:bg-emerald-700 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                Export JPEG
            </button>
        </div>
    </div>
</div>

<style>
.pacs-tool-btn { background: #3a3a3a; color: #ccc; border: 1px solid #444; border-radius: 3px; padding: 4px 6px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.15s; }
.pacs-tool-btn:hover { background: #4a4a4a; color: #fff; border-color: #6366f1; }
.pacs-tool-btn.active { background: #4f46e5; color: #fff; border-color: #6366f1; }
#pacsBrightness::-webkit-slider-thumb, #pacsContrast::-webkit-slider-thumb, #pacsSliceSlider::-webkit-slider-thumb { -webkit-appearance: none; width: 12px; height: 12px; background: #6366f1; border-radius: 50%; cursor: pointer; }
#pacsBrightness, #pacsContrast, #pacsSliceSlider { -webkit-appearance: none; height: 4px; background: #555; border-radius: 2px; outline: none; }
.pacs-thumb { cursor: pointer; border: 2px solid #444; border-radius: 3px; overflow: hidden; position: relative; aspect-ratio: 1; background: #000; }
.pacs-thumb.active { border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.4); }
.pacs-thumb img { width: 100%; height: 100%; object-fit: cover; }
.pacs-thumb-label { position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.7); color: #fff; font-size: 9px; padding: 2px 4px; }
</style>

<script>
/**
 * PACS Viewer Logic — wires the toolbar buttons + canvas interactions
 * to provide a fully functional DICOM-style image viewer.
 */
(function() {
    if (!window.pacsViewerInitialized) {
        window.pacsViewerInitialized = true;

        let pacsState = {
            zoom: 1,
            rotation: 0,
            flipped: false,
            inverted: false,
            brightness: 100,
            contrast: 100,
            currentImage: null,
            measureMode: false,
            measureStart: null,
            measureEnd: null,
        };

        function renderPacsImage(img) {
            pacsState.currentImage = img;
            const loading = document.getElementById('viewImageLoading');
            const canvas = document.getElementById('pacsCanvas');
            const ctx = canvas.getContext('2d');

            loading.style.display = 'flex';
            canvas.style.display = 'none';

            // Simulate PACS load delay
            setTimeout(() => {
                loading.style.display = 'none';
                canvas.style.display = 'block';

                // Update overlay info
                document.getElementById('pacsPatientInfo').textContent = `Patient: ${img.patientName || 'Okello David'} | ID: ${img.patientId || 'P-10001'}`;
                document.getElementById('pacsStudyInfo').textContent = `Study: ${img.view || 'CT Chest'} | ${img.studyDate || '2026-05-11'}`;
                document.getElementById('pacsImageInfo').textContent = `Image: ${img.fileName || 'IMG_001.DCM'} | ${img.modality || 'CT'}`;
                document.getElementById('viewImageTitle').textContent = `PACS Viewer — ${img.id || img.fileName}`;
                document.getElementById('viewImageInfo').textContent = `${img.view || 'CT Chest'} • ${img.modality || 'CT'} • Mulago PACS`;
                document.getElementById('viewImageDetails').textContent = `File: ${img.fileName} • Uploaded ${img.uploadDate || '—'}`;

                // Draw a placeholder medical image (gradient + crosshair)
                canvas.width = 800;
                canvas.height = 600;
                applyFiltersAndDraw(ctx, img);
            }, 600);
        }

        function applyFiltersAndDraw(ctx, img) {
            const canvas = ctx.canvas;
            ctx.save();
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Apply transformations
            ctx.translate(canvas.width / 2, canvas.height / 2);
            ctx.scale(pacsState.zoom * (pacsState.flipped ? -1 : 1), pacsState.zoom);
            ctx.rotate(pacsState.rotation * Math.PI / 180);
            ctx.translate(-canvas.width / 2, -canvas.height / 2);

            // Apply filters
            ctx.filter = `brightness(${pacsState.brightness}%) contrast(${pacsState.contrast}%) ${pacsState.inverted ? 'invert(1)' : ''}`;

            // Draw placeholder medical image (radial gradient — black background, lighter center)
            const grad = ctx.createRadialGradient(canvas.width / 2, canvas.height / 2, 50, canvas.width / 2, canvas.height / 2, 400);
            grad.addColorStop(0, '#444');
            grad.addColorStop(0.4, '#222');
            grad.addColorStop(1, '#000');
            ctx.fillStyle = grad;
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Draw "body cross-section" — oval shapes simulating organs
            ctx.filter = 'none'; // Disable filter for shapes
            ctx.fillStyle = '#1a1a1a';
            ctx.beginPath();
            ctx.ellipse(canvas.width / 2, canvas.height / 2, 200, 250, 0, 0, Math.PI * 2);
            ctx.fill();

            ctx.fillStyle = '#2a2a2a';
            ctx.beginPath();
            ctx.ellipse(canvas.width / 2 - 60, canvas.height / 2 - 50, 60, 70, 0, 0, Math.PI * 2);
            ctx.fill();
            ctx.beginPath();
            ctx.ellipse(canvas.width / 2 + 60, canvas.height / 2 - 50, 60, 70, 0, 0, Math.PI * 2);
            ctx.fill();

            ctx.fillStyle = '#0a0a0a';
            ctx.beginPath();
            ctx.ellipse(canvas.width / 2, canvas.height / 2 + 80, 80, 50, 0, 0, Math.PI * 2);
            ctx.fill();

            // Spine indicator
            ctx.fillStyle = '#fff';
            ctx.fillRect(canvas.width / 2 - 15, canvas.height / 2 - 30, 30, 60);

            // Crosshair (center marker)
            ctx.strokeStyle = 'rgba(255, 0, 0, 0.4)';
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(canvas.width / 2, 0);
            ctx.lineTo(canvas.width / 2, canvas.height);
            ctx.moveTo(0, canvas.height / 2);
            ctx.lineTo(canvas.width, canvas.height / 2);
            ctx.stroke();

            // Measurement line if active
            if (pacsState.measureStart && pacsState.measureEnd) {
                ctx.strokeStyle = '#ff0';
                ctx.lineWidth = 2;
                ctx.beginPath();
                ctx.moveTo(pacsState.measureStart.x, pacsState.measureStart.y);
                ctx.lineTo(pacsState.measureEnd.x, pacsState.measureEnd.y);
                ctx.stroke();
            }

            ctx.restore();

            // Update zoom display
            document.getElementById('pacsZoomDisplay').textContent = Math.round(pacsState.zoom * 100) + '%';
        }

        // Wire toolbar buttons (delegation)
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.pacs-tool-btn[data-tool]');
            if (!btn) return;
            const tool = btn.getAttribute('data-tool');
            const canvas = document.getElementById('pacsCanvas');
            if (!canvas) return;
            const ctx = canvas.getContext('2d');

            switch (tool) {
                case 'zoomin': pacsState.zoom = Math.min(pacsState.zoom * 1.25, 5); break;
                case 'zoomout': pacsState.zoom = Math.max(pacsState.zoom / 1.25, 0.2); break;
                case 'reset':
                    pacsState.zoom = 1; pacsState.rotation = 0; pacsState.flipped = false;
                    pacsState.inverted = false; pacsState.brightness = 100; pacsState.contrast = 100;
                    document.getElementById('pacsBrightness').value = 100;
                    document.getElementById('pacsContrast').value = 100;
                    document.querySelectorAll('.pacs-tool-btn').forEach(b => b.classList.remove('active'));
                    break;
                case 'fit': pacsState.zoom = 1; break;
                case 'rotate': pacsState.rotation = (pacsState.rotation + 90) % 360; break;
                case 'flip': pacsState.flipped = !pacsState.flipped; btn.classList.toggle('active'); break;
                case 'invert': pacsState.inverted = !pacsState.inverted; btn.classList.toggle('active'); break;
                case 'measure':
                    pacsState.measureMode = !pacsState.measureMode;
                    btn.classList.toggle('active');
                    document.getElementById('pacsMeasureReadout').style.display = pacsState.measureMode ? 'block' : 'none';
                    if (!pacsState.measureMode) {
                        pacsState.measureStart = null;
                        pacsState.measureEnd = null;
                    }
                    if (window.Meditrack) {
                        window.Meditrack.Toast.info(pacsState.measureMode ? 'Click two points on the image to measure.' : 'Measurement mode off.');
                    }
                    break;
                case 'annotate':
                    if (window.Meditrack) {
                        window.Meditrack.Toast.info('Annotation mode — click on the image to add a note.');
                    }
                    break;
            }
            if (pacsState.currentImage) applyFiltersAndDraw(ctx, pacsState.currentImage);
        });

        // Brightness/Contrast sliders
        document.addEventListener('input', (e) => {
            if (e.target.id === 'pacsBrightness') {
                pacsState.brightness = parseInt(e.target.value, 10);
                const canvas = document.getElementById('pacsCanvas');
                if (canvas && pacsState.currentImage) applyFiltersAndDraw(canvas.getContext('2d'), pacsState.currentImage);
            }
            if (e.target.id === 'pacsContrast') {
                pacsState.contrast = parseInt(e.target.value, 10);
                const canvas = document.getElementById('pacsCanvas');
                if (canvas && pacsState.currentImage) applyFiltersAndDraw(canvas.getContext('2d'), pacsState.currentImage);
            }
        });

        // Canvas mouse interactions — measure + pan
        document.addEventListener('mousedown', (e) => {
            const canvas = document.getElementById('pacsCanvas');
            if (!canvas || canvas.style.display === 'none') return;
            if (!pacsState.measureMode) return;
            const rect = canvas.getBoundingClientRect();
            const x = (e.clientX - rect.left) * (canvas.width / rect.width);
            const y = (e.clientY - rect.top) * (canvas.height / rect.height);
            if (!pacsState.measureStart) {
                pacsState.measureStart = { x, y };
            } else if (!pacsState.measureEnd) {
                pacsState.measureEnd = { x, y };
                // Calculate distance (assume 1px = 0.5mm for demo)
                const dx = pacsState.measureEnd.x - pacsState.measureStart.x;
                const dy = pacsState.measureEnd.y - pacsState.measureStart.y;
                const dist = Math.sqrt(dx * dx + dy * dy) * 0.5;
                document.getElementById('pacsDistance').textContent = dist.toFixed(2) + ' mm';
                applyFiltersAndDraw(canvas.getContext('2d'), pacsState.currentImage);
                if (window.Meditrack) window.Meditrack.Toast.success(`Measured: ${dist.toFixed(2)} mm`);
            } else {
                // Reset for next measurement
                pacsState.measureStart = { x, y };
                pacsState.measureEnd = null;
            }
        });

        // Download buttons
        document.addEventListener('click', (e) => {
            if (e.target.closest('#pacsDownloadBtn')) {
                if (window.Meditrack) {
                    window.Meditrack.Toast.success('DICOM file download started.');
                }
                // Trigger fake download
                const blob = new Blob(['PACS DICOM export — ' + (pacsState.currentImage?.fileName || 'image.dcm')], { type: 'application/dicom' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url; a.download = pacsState.currentImage?.fileName || 'image.dcm';
                a.click();
                URL.revokeObjectURL(url);
            }
            if (e.target.closest('#pacsExportJpegBtn')) {
                const canvas = document.getElementById('pacsCanvas');
                if (canvas && pacsState.currentImage) {
                    canvas.toBlob((blob) => {
                        const url = URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url; a.download = (pacsState.currentImage?.fileName || 'image').replace(/\.\w+$/, '') + '.jpg';
                        a.click();
                        URL.revokeObjectURL(url);
                        if (window.Meditrack) window.Meditrack.Toast.success('JPEG exported successfully.');
                    }, 'image/jpeg', 0.9);
                }
            }
        });

        // Build series thumbnails
        function buildSeriesThumbnails(images) {
            const list = document.getElementById('pacsSeriesList');
            if (!list) return;
            list.innerHTML = '';
            images.forEach((img, idx) => {
                const thumb = document.createElement('div');
                thumb.className = 'pacs-thumb' + (idx === 0 ? ' active' : '');
                thumb.innerHTML = `
                    <img src="user.png" alt="${img.fileName || img.id}">
                    <div class="pacs-thumb-label">${img.view || 'Series ' + (idx + 1)}</div>
                `;
                thumb.addEventListener('click', () => {
                    document.querySelectorAll('.pacs-thumb').forEach(t => t.classList.remove('active'));
                    thumb.classList.add('active');
                    renderPacsImage(img);
                });
                list.appendChild(thumb);
            });
        }

        // Override the existing openImageViewer function to use new PACS viewer
        const origOpenImageViewer = window.openImageViewer;
        window.openImageViewer = function(img) {
            const modal = document.getElementById('viewImageModal');
            if (modal) modal.style.display = 'flex';
            // Build series with the current image + simulated related series
            const series = [
                { ...img, view: 'Axial' },
                { ...img, id: img.id + '-sag', view: 'Sagittal', fileName: (img.fileName || '').replace(/\.\w+$/, '-sag.dcm') },
                { ...img, id: img.id + '-cor', view: 'Coronal', fileName: (img.fileName || '').replace(/\.\w+$/, '-cor.dcm') },
            ];
            buildSeriesThumbnails(series);
            renderPacsImage(series[0]);
        };

        // Slice slider
        document.addEventListener('input', (e) => {
            if (e.target.id === 'pacsSliceSlider') {
                document.getElementById('pacsSliceNum').textContent = e.target.value;
            }
        });

        console.log('[PACS] Viewer initialized');
    }
})();
</script>

<!-- Edit Report Modal -->
<div id="editReportModal" class="modal-overlay">
    <div class="modal-container wide">
        <div class="modal-header">
            <h2 class="modal-title">Edit Report - <span id="erModalOrderId">ORD-003</span></h2>
            <button class="modal-close" data-close="editReportModal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="space-y-4">
                <div><label class="text-sm font-medium block mb-1">Findings</label><textarea id="editFindings" rows="5" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></textarea></div>
                <div><label class="text-sm font-medium block mb-1">Impression</label><textarea id="editImpression" rows="4" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></textarea></div>
                <div><label class="text-sm font-medium block mb-1">Recommendations</label><textarea id="editRecommendations" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></textarea></div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="border border-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-100" data-close="editReportModal">Cancel</button>
            <button id="saveReportBtn" class="bg-primary text-white px-4 py-2 rounded-md text-sm hover:bg-primary/90">Save Report</button>
        </div>
    </div>
</div>

<!-- Delete Image Confirmation Dialog -->
<div id="deleteImageDialog" class="alert-dialog-overlay">
    <div role="alertdialog" class="alert-dialog">
        <div class="alert-dialog-header">
            <h2 class="alert-dialog-title">Delete Image</h2>
            <p class="alert-dialog-description" id="deleteImageDesc">Are you sure you want to delete this image? This action cannot be undone.</p>
        </div>
        <div class="alert-dialog-footer">
            <button class="alert-dialog-cancel" id="deleteImageCancelBtn">Cancel</button>
            <button class="alert-dialog-delete" id="deleteImageConfirmBtn">Delete Image</button>
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
    // ==================== DATA ====================
    const orderData = {
        id: "ORD-003", patient: "Robert Johnson", modality: "MRI", bodyPart: "Brain",
        clinicalHistory: "Recurrent headaches, visual disturbances. Rule out intracranial pathology.",
        priority: "STAT", status: "In Progress", referringDoctor: "Dr. Byaruhanga", radiologist: "Dr. Tumusiime",
        orderDate: "2026-05-15", scheduledDate: "2026-05-15", completedDate: null,
        protocol: "MRI Brain with and without contrast", contrastRequired: true, contrastType: "Gadolinium",
        reportFindings: "Multiple hyperintense lesions in the periventricular white matter on T2/FLAIR sequences. Several lesions show enhancement with gadolinium contrast, suggesting active inflammation. No significant mass effect or midline shift identified. Ventricular size is within normal limits.",
        reportImpression: "1. Multiple enhancing white matter lesions consistent with active demyelinating disease.\n2. Findings are suggestive of Multiple Sclerosis (McDonald criteria).\n3. Clinical correlation and neurology follow-up recommended.",
        reportRecommendations: "1. Neurology consultation recommended.\n2. Consider MRI of the cervical and thoracic spine to evaluate for additional lesions.\n3. Follow-up brain MRI in 6 months to assess disease progression.",
        reportStatus: "Draft", reportDate: "2026-05-16", reportRadiologist: "Dr. Tumusiime"
    };

    const imagesData = [
        { id: "IMG-001", view: "Axial T2 FLAIR", fileName: "brain_axial_t2_flair.dcm", uploadDate: "2026-05-15", uploadedBy: "CT Tech", sequence: "T2 FLAIR" },
        { id: "IMG-002", view: "Sagittal T1", fileName: "brain_sagittal_t1.dcm", uploadDate: "2026-05-15", uploadedBy: "CT Tech", sequence: "T1" },
        { id: "IMG-003", view: "Axial T1 Post-Contrast", fileName: "brain_axial_t1_post.dcm", uploadDate: "2026-05-15", uploadedBy: "CT Tech", sequence: "T1 +C" },
        { id: "IMG-004", view: "Coronal T2", fileName: "brain_coronal_t2.dcm", uploadDate: "2026-05-15", uploadedBy: "CT Tech", sequence: "T2" },
        { id: "IMG-005", view: "Axial DWI", fileName: "brain_axial_dwi.dcm", uploadDate: "2026-05-15", uploadedBy: "CT Tech", sequence: "DWI" }
    ];

    const timelineData = [
        { date: "2026-05-15 09:30", event: "Order Created", user: "Dr. Byaruhanga", details: "Radiology order placed for MRI Brain", icon: "file-text" },
        { date: "2026-05-15 09:45", event: "Order Reviewed", user: "Radiology Dept", details: "Order reviewed and approved", icon: "clipboard-check" },
        { date: "2026-05-15 10:00", event: "Scheduled", user: "Scheduler", details: "Scheduled for May 15, 2026 at MRI Suite", icon: "calendar" },
        { date: "2026-05-15 14:30", event: "Study Started", user: "MRI Tech", details: "Patient arrived, study in progress", icon: "play-circle" },
        { date: "2026-05-15 15:15", event: "Images Acquired", user: "MRI Tech", details: "5 sequences acquired successfully", icon: "image" },
        { date: "2026-05-15 15:30", event: "Radiologist Assigned", user: "Radiology Dept", details: "Assigned to Dr. Tumusiime (Neuroradiology)", icon: "user-check" },
        { date: "2026-05-16 10:00", event: "Report Started", user: "Dr. Tumusiime", details: "Preliminary report drafted", icon: "edit" },
        { date: "2026-05-16 11:30", event: "Report Updated", user: "Dr. Tumusiime", details: "Report findings and impression added", icon: "edit" }
    ];

    let activeMenu = null;
    let uploadedFiles = [];

    // ==================== MODAL FUNCTIONS ====================
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.add('show');
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.remove('show');
    }

    function closeAllModals() {
        document.querySelectorAll('.modal-overlay.show, .alert-dialog-overlay.show').forEach(modal => modal.classList.remove('show'));
    }

    // ==================== TOAST ====================
    function showToast(message, isError = false) {
        const existing = document.querySelector('.toast-message');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.className = `toast-message ${isError ? 'error' : ''}`;
        toast.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide ${isError ? 'lucide-alert-circle' : 'lucide-check-circle'}"><circle cx="12" cy="12" r="10"></circle>${isError ? '<line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line>' : '<path d="m9 12 2 2 4-4"></path>'}</svg>
            ${message}
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3500);
    }

    function closeMenu() { if (activeMenu) { activeMenu.remove(); activeMenu = null; } }

    function getStatusBadge(status) {
        const map = { 'Pending': 'status-pending', 'In Progress': 'status-inprogress', 'Completed': 'status-completed', 'Cancelled': 'status-cancelled' };
        const icons = { 'Pending': 'clock', 'In Progress': 'loader-circle', 'Completed': 'check-circle', 'Cancelled': 'x-circle' };
        return `<span class="status-badge ${map[status] || 'status-pending'}"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-${icons[status] || 'clock'}"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>${status}</span>`;
    }

    function getPriorityBadge(priority) {
        const map = { 'STAT': 'priority-stat', 'Urgent': 'priority-urgent', 'Routine': 'priority-routine' };
        return `<span class="status-badge ${map[priority] || 'priority-routine'}">${priority}</span>`;
    }

    function formatDate(dateStr) {
        if (!dateStr) return '—';
        return new Date(dateStr).toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
    }

    function formatDateTime(dateStr) {
        if (!dateStr) return '—';
        const d = new Date(dateStr);
        return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }) + ' at ' + d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
    }

    // ==================== TAB SWITCHING ====================
    function switchTab(tabId) {
        ['overview', 'images', 'report', 'timeline'].forEach(id => {
            document.getElementById(`tab-${id}`).classList.add('hidden');
        });
        document.getElementById(`tab-${tabId}`).classList.remove('hidden');
        document.querySelectorAll('.tab-trigger').forEach(tab => {
            if (tab.getAttribute('data-tab') === tabId) {
                tab.classList.add('active', 'bg-white', 'text-gray-900', 'shadow-sm');
            } else {
                tab.classList.remove('active', 'bg-white', 'text-gray-900', 'shadow-sm');
            }
        });
    }
    document.querySelectorAll('.tab-trigger').forEach(tab => {
        tab.addEventListener('click', () => switchTab(tab.getAttribute('data-tab')));
    });

    // ==================== UPDATE STATUS ====================
    function updateAllStatusDisplays(newStatus) {
        const badge = document.getElementById('statusBadge');
        const statStatus = document.getElementById('statStatus');
        const ovStatus = document.getElementById('ovStatus');
        
        const map = { 'Pending': 'status-pending', 'In Progress': 'status-inprogress', 'Completed': 'status-completed', 'Cancelled': 'status-cancelled' };
        const icons = { 'Pending': 'clock', 'In Progress': 'loader-circle', 'Completed': 'check-circle', 'Cancelled': 'x-circle' };
        const cls = map[newStatus] || 'status-pending';
        const icon = icons[newStatus] || 'clock';

        orderData.status = newStatus;
        badge.className = `status-badge ${cls} ml-2`;
        badge.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-${icon}"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>${newStatus}`;
        statStatus.innerText = newStatus;
        ovStatus.innerHTML = getStatusBadge(newStatus);
    }

    document.getElementById('updateStatusBtn')?.addEventListener('click', () => {
        document.getElementById('usModalOrderId').innerText = orderData.id;
        document.getElementById('usCurrentStatus').innerHTML = getStatusBadge(orderData.status);
        document.getElementById('newStatusSelect').value = orderData.status;
        document.getElementById('statusNotes').value = '';
        openModal('updateStatusModal');
    });

    document.getElementById('confirmStatusBtn')?.addEventListener('click', () => {
        const newStatus = document.getElementById('newStatusSelect').value;
        updateAllStatusDisplays(newStatus);
        if (newStatus === 'Completed') orderData.completedDate = new Date().toISOString().split('T')[0];
        timelineData.push({
            date: new Date().toISOString().replace('T', ' ').substring(0, 16),
            event: `Status Changed to ${newStatus}`,
            user: 'Dr. Nakato Sarah',
            details: document.getElementById('statusNotes').value || 'Status updated',
            icon: 'refresh-cw'
        });
        renderTimeline();
        showToast(`Status updated to ${newStatus}`);
        closeModal('updateStatusModal');
    });

    // ==================== UPLOAD IMAGES ====================
    document.getElementById('uploadImageBtn')?.addEventListener('click', () => {
        document.getElementById('uiModalOrderId').innerText = orderData.id;
        document.getElementById('fileList').innerHTML = '';
        uploadedFiles = [];
        document.getElementById('imageView').value = '';
        document.getElementById('imageSequence').value = '';
        document.getElementById('imageNotes').value = '';
        openModal('uploadImageModal');
    });

    document.getElementById('dropZone')?.addEventListener('click', () => {
        document.getElementById('fileInput').click();
    });

    document.getElementById('fileInput')?.addEventListener('change', (e) => {
        uploadedFiles = Array.from(e.target.files);
        renderFileList();
    });

    function renderFileList() {
        const list = document.getElementById('fileList');
        list.innerHTML = uploadedFiles.map((f, i) => `
            <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-800 rounded-md px-3 py-2 text-sm">
                <div class="flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-image text-indigo-500"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><circle cx="10" cy="12" r="2"></circle><path d="m20 17-1.296-1.296a2.41 2.41 0 0 0-3.408 0L9 22"></path></svg>
                    <span>${f.name}</span>
                    <span class="text-xs text-gray-400">(${(f.size / 1024).toFixed(1)} KB)</span>
                </div>
                <button class="text-red-500 hover:text-red-700" data-index="${i}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                </button>
            </div>
        `).join('');
        list.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('click', () => {
                uploadedFiles.splice(parseInt(btn.dataset.index), 1);
                renderFileList();
            });
        });
    }

    document.getElementById('confirmUploadBtn')?.addEventListener('click', () => {
        const view = document.getElementById('imageView').value.trim() || 'Unspecified';
        const sequence = document.getElementById('imageSequence').value.trim();
        if (uploadedFiles.length === 0) { showToast('Please select files to upload', true); return; }
        uploadedFiles.forEach((f, i) => {
            imagesData.push({
                id: 'IMG-' + String(imagesData.length + 1).padStart(3, '0'),
                view: view + (uploadedFiles.length > 1 ? ` (${i + 1})` : ''),
                fileName: f.name,
                uploadDate: new Date().toISOString().split('T')[0],
                uploadedBy: 'Current User',
                sequence: sequence
            });
        });
        renderImagesTable();
        showToast(`${uploadedFiles.length} image(s) uploaded successfully`);
        uploadedFiles = [];
        document.getElementById('fileList').innerHTML = '';
        closeModal('uploadImageModal');
    });

    // ==================== IMAGES TABLE ====================
    function renderImagesTable() {
        const tbody = document.getElementById('imagesTableBody');
        tbody.innerHTML = imagesData.map(img => `
            <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-800/50">
                <td class="p-4"><div class="image-thumb" data-image-id="${img.id}" title="Click to view"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image text-gray-400"><rect width="18" height="18" x="3" y="3" rx="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg></div></td>
                <td class="p-4 font-medium">${img.id}</td>
                <td class="p-4">${img.view}${img.sequence ? `<br><span class="text-xs text-gray-400">${img.sequence}</span>` : ''}</td>
                <td class="p-4 hidden md:table-cell text-sm text-gray-500">${img.fileName}</td>
                <td class="p-4 hidden lg:table-cell">${formatDate(img.uploadDate)}</td>
                <td class="p-4 hidden lg:table-cell">${img.uploadedBy}</td>
                <td class="p-4 text-right">
                    <button class="image-action-btn inline-flex items-center justify-center h-10 w-10 rounded-md hover:bg-gray-100" data-id="${img.id}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ellipsis-vertical text-gray-500"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </button>
                </td>
            </tr>
        `).join('');

        document.querySelectorAll('.image-thumb').forEach(thumb => {
            thumb.addEventListener('click', () => {
                const img = imagesData.find(i => i.id === thumb.dataset.imageId);
                if (img) openImageViewer(img);
            });
        });

        document.querySelectorAll('.image-action-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const img = imagesData.find(i => i.id === btn.dataset.id);
                if (img) showImageActionMenu(btn, img);
            });
        });
    }

    function showImageActionMenu(btn, img) {
        closeMenu();
        const rect = btn.getBoundingClientRect();
        const menu = document.createElement('div');
        menu.className = 'action-menu';
        let left = rect.left, top = rect.bottom + 6;
        if (left + 210 > window.innerWidth) left = window.innerWidth - 220;
        if (top + 160 > window.innerHeight) top = rect.top - 170;
        menu.style.top = `${top}px`; menu.style.left = `${left}px`;
        menu.innerHTML = `
            <div class="action-menu-header">Image ${img.id}</div>
            <button data-action="view" class="action-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"></path><circle cx="12" cy="12" r="3"></circle></svg>View Image
            </button>
            <button data-action="download" class="action-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg>Download
            </button>
            <div class="action-divider"></div>
            <button data-action="delete" class="action-item text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>Delete Image
            </button>
        `;
        document.body.appendChild(menu);
        activeMenu = menu;
        const closeHandler = (e) => { if (!menu.contains(e.target) && e.target !== btn) { closeMenu(); document.removeEventListener('click', closeHandler); } };
        setTimeout(() => document.addEventListener('click', closeHandler), 10);
        menu.querySelector('[data-action="view"]').addEventListener('click', () => { closeMenu(); openImageViewer(img); });
        menu.querySelector('[data-action="download"]').addEventListener('click', () => { closeMenu(); showToast(`Downloading ${img.fileName}...`); });
        menu.querySelector('[data-action="delete"]').addEventListener('click', () => { closeMenu(); showDeleteImageDialog(img); });
    }

function openImageViewer(img) {
    document.getElementById('viewImageTitle').innerText = `Image Viewer - ${img.id}`;
    document.getElementById('viewImageInfo').innerText = `${img.view}${img.sequence ? ' (' + img.sequence + ')' : ''}`;
    document.getElementById('viewImageDetails').innerText = `${img.fileName} • Uploaded ${formatDate(img.uploadDate)}`;
    
    const container = document.getElementById('viewImageContent');
    const loading = document.getElementById('viewImageLoading');
    
    // Show loading
    loading.classList.remove('hidden');
    container.classList.add('hidden');
    
    if (img.fileName.toLowerCase().endsWith('.dcm')) {
        // For DICOM: server will convert to PNG on the fly
        // The conversion endpoint should return a PNG
        const pngPath = `/assets/converted/${img.fileName.replace('.dcm', '.png')}`;
        // Or if your server converts on demand:
        // const pngPath = `/api/convert-dicom?file=${encodeURIComponent(img.fileName)}`;
        
        container.onload = function() {
            loading.classList.add('hidden');
            container.classList.remove('hidden');
        };
        container.onerror = function() {
            loading.innerHTML = `
                <div class="text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-alert-circle text-red-400 mx-auto mb-4"><circle cx="12" cy="12" r="10"></circle><line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line></svg>
                    <p class="text-gray-500">Could not load DICOM file</p>
                    <p class="text-xs text-gray-400 mt-1">Make sure the file exists in the assets folder</p>
                </div>
            `;
        };
        container.src = pngPath;
    } else {
        // For regular images (PNG/JPG)
        container.onload = function() {
            loading.classList.add('hidden');
            container.classList.remove('hidden');
        };
        container.src = `/assets/${img.fileName}`;
    }
    
    openModal('viewImageModal');
}

    function showDeleteImageDialog(img) {
        document.getElementById('deleteImageDesc').innerText = `Are you sure you want to delete image "${img.id}" (${img.view})? This action cannot be undone.`;
        document.getElementById('deleteImageDialog')._img = img;
        openModal('deleteImageDialog');
    }

    function deleteImage(img) {
        const idx = imagesData.findIndex(i => i.id === img.id);
        if (idx > -1) { imagesData.splice(idx, 1); renderImagesTable(); showToast(`Image ${img.id} deleted`); }
    }

    // ==================== REPORT ====================
    document.getElementById('editReportBtn')?.addEventListener('click', () => {
        document.getElementById('erModalOrderId').innerText = orderData.id;
        document.getElementById('editFindings').value = orderData.reportFindings || '';
        document.getElementById('editImpression').value = orderData.reportImpression || '';
        document.getElementById('editRecommendations').value = orderData.reportRecommendations || '';
        openModal('editReportModal');
    });

    document.getElementById('saveReportBtn')?.addEventListener('click', () => {
        orderData.reportFindings = document.getElementById('editFindings').value;
        orderData.reportImpression = document.getElementById('editImpression').value;
        orderData.reportRecommendations = document.getElementById('editRecommendations').value;
        document.getElementById('reportFindings').innerText = orderData.reportFindings || 'No findings recorded.';
        document.getElementById('reportImpression').innerHTML = (orderData.reportImpression || 'No impression recorded.').replace(/\n/g, '<br>');
        document.getElementById('reportRecommendations').innerHTML = (orderData.reportRecommendations || 'No recommendations recorded.').replace(/\n/g, '<br>');
        showToast('Report saved successfully');
        closeModal('editReportModal');
    });

    document.getElementById('markFinalBtn')?.addEventListener('click', () => {
        orderData.reportStatus = 'Final';
        document.getElementById('reportStatusBadge').className = 'status-badge report-final';
        document.getElementById('reportStatusBadge').innerText = 'Final';
        document.getElementById('reportDate').innerText = formatDate(new Date().toISOString().split('T')[0]);
        orderData.reportDate = new Date().toISOString().split('T')[0];
        timelineData.push({
            date: new Date().toISOString().replace('T', ' ').substring(0, 16),
            event: 'Report Finalized',
            user: 'Dr. Tumusiime',
            details: 'Report marked as final',
            icon: 'check-circle'
        });
        renderTimeline();
        showToast('Report marked as Final');
    });

    document.getElementById('printReportBtn')?.addEventListener('click', () => {
        showToast('Preparing report for print...');
        setTimeout(() => window.print(), 500);
    });

    // ==================== TIMELINE ====================
    function renderTimeline() {
        const container = document.getElementById('timelineContainer');
        const iconMap = {
            'file-text': '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg>',
            'clipboard-check': '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clipboard-check"><rect width="8" height="4" x="8" y="2" rx="1"></rect><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><path d="m9 14 2 2 4-4"></path></svg>',
            'calendar': '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar"><path d="M8 2v4"></path><path d="M16 2v4"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect><path d="M3 10h18"></path></svg>',
            'play-circle': '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play-circle"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg>',
            'image': '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image"><rect width="18" height="18" x="3" y="3" rx="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>',
            'user-check': '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-check"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><polyline points="16 11 18 13 22 9"></polyline></svg>',
            'edit': '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-edit"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"></path><path d="m15 5 4 4"></path></svg>',
            'refresh-cw': '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-refresh-cw"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path><path d="M21 3v5h-5"></path><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path><path d="M8 16H3v5"></path></svg>',
            'check-circle': '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>'
        };

        container.innerHTML = timelineData.slice().reverse().map((t, i) => `
            <div class="timeline-item">
                <div class="timeline-dot ${i === 0 ? 'active' : ''}"></div>
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-sm font-semibold">${t.event}</p>
                        <p class="text-xs text-gray-500 mt-0.5">by ${t.user}</p>
                        <p class="text-sm text-gray-600 mt-1">${t.details}</p>
                    </div>
                    <div class="text-xs text-gray-400 whitespace-nowrap">${formatDateTime(t.date)}</div>
                </div>
            </div>
        `).join('');
    }

    // ==================== EDIT ORDER BUTTON ====================
    document.getElementById('editOrderBtn')?.addEventListener('click', () => {
        window.location.href = `edit-radiology.html?id=${orderData.id}`;
    });

    // ==================== MODAL CLOSE HANDLERS ====================
    document.querySelectorAll('.modal-close, [data-close]').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const modalId = btn.dataset.close || btn.closest('.modal-overlay').id;
            closeModal(modalId);
        });
    });

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => { 
            if (e.target === overlay) closeModal(overlay.id);
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeAllModals();
            closeMenu();
        }
    });

    document.addEventListener('click', (e) => {
        if (!e.target.closest('.action-menu') && !e.target.closest('.image-action-btn')) {
            closeMenu();
        }
    });

    // ==================== INIT ====================
    switchTab('overview');
    renderImagesTable();
    renderTimeline();
    closeAllModals();
    
    // Update breadcrumb with order details
    document.getElementById('detailPatient').innerText = orderData.patient;
    document.getElementById('detailModality').innerText = orderData.modality;
    document.getElementById('detailBodyPart').innerText = orderData.bodyPart;
    document.getElementById('detailOrderId').innerText = orderData.id;
    
    // Update template badge based on modality and body part (informational only)
    const templateBadge = document.getElementById('templateBadge');
    const templateMap = {
        'CT-Chest': 'CT Chest Standard',
        'CT-Head': 'CT Head Trauma',
        'CT-Abdomen/Pelvis': 'CT Abdomen/Pelvis Protocol',
        'MRI-Brain': 'MRI Brain Standard',
        'MRI-Lumbar Spine': 'MRI Lumbar Spine',
        'X-Ray-Chest': 'X-Ray Chest PA & Lateral',
        'X-Ray-Left Wrist': 'X-Ray Extremity Views',
        'X-Ray-Right Ankle': 'X-Ray Extremity Views',
        'Ultrasound-Abdomen': 'Ultrasound Abdomen Complete',
        'Ultrasound-Thyroid': 'Ultrasound Thyroid',
        'Mammography-Breast - Bilateral': 'Mammography Screening'
    };
    
    const templateKey = `${orderData.modality}-${orderData.bodyPart}`;
    const templateName = templateMap[templateKey] || `${orderData.modality} ${orderData.bodyPart}`;
    templateBadge.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text mr-1"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path></svg>${templateName}`;
    
    
        // ==================== DELETE IMAGE DIALOG HANDLERS ====================
    document.getElementById('deleteImageConfirmBtn')?.addEventListener('click', () => {
        const dialog = document.getElementById('deleteImageDialog');
        const img = dialog._img;
        if (img) {
            deleteImage(img);
        }
        closeModal('deleteImageDialog');
    });

    document.getElementById('deleteImageCancelBtn')?.addEventListener('click', () => closeModal('deleteImageDialog'));

    // Also handle alert dialog overlay clicks
    document.querySelectorAll('.alert-dialog-overlay').forEach(overlay => {
        overlay.addEventListener('click', function(e) {
            if (e.target === this) closeModal(this.id);
        });
    });// ==================== INIT ====================

    
    switchTab('overview');
    renderImagesTable();
    renderTimeline();
    closeAllModals();
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
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Survey Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" crossorigin="anonymous"></script>
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
        body.dark .bg-blue-50 { background-color: #1e3a5f !important; }
        body.dark .bg-emerald-50 { background-color: #064e3b !important; }
        body.dark .bg-purple-50 { background-color: #2e1065 !important; }
        body.dark .bg-amber-50 { background-color: #451a03 !important; }
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
        body.dark .modal-content { background: #131212; border: 1px solid #333; }
        
        @keyframes modalSlideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        
        @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        .toast-notification { animation: slideInRight 0.3s ease-out; position: fixed; bottom: 24px; right: 24px; z-index: 1100; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-active { background-color: #dcfce7; color: #166534; }
        .status-draft { background-color: #fef9c3; color: #854d0e; }
        .status-inactive { background-color: #fee2e2; color: #991b1b; }
        body.dark .status-active { background-color: #14532d; color: #86efac; }
        body.dark .status-draft { background-color: #713f12; color: #fde047; }
        body.dark .status-inactive { background-color: #7f1d1d; color: #fca5a5; }
        
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
        
        .progress-bar { transition: width 0.3s ease; }
        
        .switch-root {
            display: inline-flex;
            height: 1.5rem;
            width: 2.75rem;
            align-items: center;
            border-radius: 9999px;
            cursor: pointer;
            transition: background-color 0.2s;
            flex-shrink: 0;
        }
        .switch-thumb {
            display: block;
            height: 1.25rem;
            width: 1.25rem;
            border-radius: 9999px;
            background-color: white;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
        }
        
        .method-tab.active {
            background-color: #4f46e5 !important;
            color: white !important;
        }
        .method-tab { transition: all 0.2s; cursor: pointer; }

        /* In the style section, update reportPreviewModal */
#reportPreviewModal .modal-content {
    max-width: 210mm;
    width: 100%;
    padding: 0;
    background: white;
}

/* For screen display, scale it down */
@media screen {
    #reportPreviewModal .modal-content {
        max-width: 90vw;
        width: 90vw;
        overflow-x: auto;
    }
    .report-container {
        transform: scale(0.9);
        transform-origin: top center;
    }
}

/* For print/PDF - full A4 */
@media print {
    .report-container {
        width: 210mm;
        min-height: 297mm;
        padding: 15mm;
        margin: 0;
        page-break-after: avoid;
        page-break-inside: avoid;
    }
    .modal-backdrop, .modal-content, #reportPreviewModal {
        position: static;
        display: block;
        background: white;
        box-shadow: none;
        max-width: none;
        width: 100%;
    }
}

    /* ============================================ */
    /* REPORT MODAL STYLES - HMS Design System       */
    /* ============================================ */

    .modal-overlay {
        position: fixed; inset: 0;
        background-color: rgb(0 0 0 / 87%);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: flex; align-items: center; justify-content: center;
        animation: modalFadeIn 0.15s ease-out;
    }
    .modal-overlay.hidden { display: none; }

    .modal-container {
        background: white; border-radius: 0.75rem; width: 95%;
        max-height: 90vh; overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        animation: modalSlideUp 0.2s ease-out;
    }
    body.dark .modal-container { background: #131212; border: 1px solid #333; }

    .modal-header {
        padding: 1.25rem 1.5rem; border-bottom: 1px solid #e5e7eb;
        display: flex; justify-content: space-between; align-items: flex-start;
        position: sticky; top: 0; background: white; z-index: 10;
        border-radius: 0.75rem 0.75rem 0 0;
    }
    body.dark .modal-header { background: #131212; border-bottom-color: #333; }

    .modal-title { font-size: 1.125rem; font-weight: 600; margin: 0; color: #1f2937; }
    body.dark .modal-title { color: #e5e5e5; }

    .modal-close-btn {
        background: transparent; border: none; font-size: 1.5rem; cursor: pointer;
        color: #6b7280; width: 32px; height: 32px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 0.375rem; flex-shrink: 0; transition: all 0.15s;
    }
    .modal-close-btn:hover { color: #1f2937; background-color: #f3f4f6; }
    body.dark .modal-close-btn:hover { color: #e5e5e5; background-color: #374151; }

    @keyframes modalSlideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    @keyframes modalFadeIn { from { opacity: 0; } to { opacity: 1; } }
    @keyframes selectSlideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

    .rtype-card { cursor: pointer; text-align: center; padding: 1.25rem 1rem; border-radius: 0.5rem; border: 2px solid #e5e7eb; background: white; transition: all 0.15s; }
    .rtype-card:hover { border-color: #a5b4fc; background: #f5f3ff; }
    .rtype-card.selected { border-color: #6366f1; background: #eef2ff; }
    body.dark .rtype-card { background: #1e1e1e; border-color: #404040; }
    body.dark .rtype-card:hover { border-color: #6366f1; background: #1e1b4b; }
    body.dark .rtype-card.selected { border-color: #818cf8; background: #1e1b4b; }

    .section-toggle-btn {
        display: inline-flex; align-items: center; gap: 0.5rem;
        padding: 0.5rem 1rem; border-radius: 9999px;
        font-size: 0.8rem; font-weight: 500; cursor: pointer;
        transition: all 0.15s;
        border: 1px solid #d1d5db; background: white; color: #6b7280;
    }
    .section-toggle-btn:hover { border-color: #a5b4fc; color: #4f46e5; }
    .section-toggle-btn.selected { border-color: #6366f1; background: #eef2ff; color: #4f46e5; }
    body.dark .section-toggle-btn { background: #262626; border-color: #404040; color: #9ca3af; }
    body.dark .section-toggle-btn:hover { border-color: #6366f1; color: #a5b4fc; }
    body.dark .section-toggle-btn.selected { border-color: #818cf8; background: #1e1b4b; color: #a5b4fc; }

    .radix-select { position: relative; width: 100%; }
    .radix-select-trigger {
        display: flex; align-items: center; justify-content: space-between;
        width: 100%; height: 40px; padding: 0 0.75rem;
        font-size: 0.875rem; border-radius: 0.375rem;
        border: 1px solid #d1d5db; background-color: white;
        cursor: pointer; text-align: left; transition: border-color 0.15s;
    }
    .radix-select-trigger:hover { border-color: #a5b4fc; }
    body.dark .radix-select-trigger { background-color: #262626; border-color: #404040; color: #e5e5e5; }
    .radix-select-content {
        position: absolute; top: calc(100% + 4px); left: 0; right: 0;
        z-index: 10003; background: white; border: 1px solid #e5e7eb;
        border-radius: 0.375rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        animation: selectSlideDown 0.15s ease-out; max-height: 240px; overflow-y: auto;
    }
    .radix-select-content.hidden { display: none; }
    body.dark .radix-select-content { background: #2a2a2a; border-color: #404040; }
    .radix-select-item {
        padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer;
        display: flex; align-items: center; gap: 8px; transition: background 0.1s;
    }
    .radix-select-item:hover { background-color: #f3f4f6; }
    body.dark .radix-select-item:hover { background-color: #3f3f46; }
    .radix-select-item[data-selected="true"] { background-color: #eef2ff; color: #4f46e5; font-weight: 500; }
    body.dark .radix-select-item[data-selected="true"] { background-color: #1e1b4b; color: #818cf8; }
    .radix-select-item-indicator { margin-left: auto; }
    .radix-select-item-indicator.hidden { display: none; }

    .btn-primary {
        display: inline-flex; align-items: center; gap: 0.5rem;
        background: #4f46e5; color: white; border: none;
        padding: 0.5rem 1rem; border-radius: 0.375rem;
        cursor: pointer; font-size: 0.875rem; font-weight: 500; height: 40px;
        transition: background 0.15s;
    }
    .btn-primary:hover { background: #4338ca; }

    .btn-cancel {
        display: inline-flex; align-items: center; gap: 0.5rem;
        background: transparent; border: 1px solid #d1d5db;
        padding: 0.5rem 1rem; border-radius: 0.375rem;
        cursor: pointer; font-size: 0.875rem; font-weight: 500;
        color: #374151; height: 40px; transition: background 0.15s;
    }
    .btn-cancel:hover { background: #f3f4f6; }
    body.dark .btn-cancel { border-color: #555; color: #e5e5e5; }
    body.dark .btn-cancel:hover { background: #374151; }

/* Centered analytics text */
.analytics-centered {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
}
.analytics-centered .metric-value {
    font-size: 1.5rem;
    font-weight: 700;
    line-height: 1.2;
}
.analytics-centered .metric-label {
    font-size: 0.8rem;
    color: #6b7280;
    margin-top: 0.25rem;
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
            <div class="mx-auto space-y-6">
                <!-- Header -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <div class="flex items-center flex-wrap gap-4">
                    <a class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background  size-10 bg-background hover:bg-accent hover:text-accent-foreground h-10" href="feedback.html">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                    </a>
                    <div>
                        <h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2 text-gray-900">Survey Details</h1>
                        <p class="text-gray-500">View survey information, responses, and analytics.</p>
                    </div>
                </div>

                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-2">
    <button id="generateReportBtn" class="border border-gray-300 bg-white hover:bg-gray-50 h-10 px-3 rounded-md text-sm flex items-center gap-2 transition-colors">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
            <line x1="16" y1="13" x2="8" y2="13"/>
            <line x1="16" y1="17" x2="8" y2="17"/>
            <polyline points="10 9 9 9 8 9"/>
        </svg>
        Generate Report
    </button>

    <button id="deleteSurveyBtn" class="border border-red-300 bg-red-50 text-red-700 hover:bg-red-100 h-10 px-3 rounded-md text-sm flex items-center gap-2">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
        Delete
    </button>
</div>
                        <button id="editSurveyBtn" class="border border-gray-300 bg-white hover:bg-gray-50 h-10 px-3 rounded-md text-sm flex items-center gap-2 transition-colors">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 3l4 4-7 7H10v-4l7-7z"/><path d="M4 20h16"/></svg>
                            Edit Survey
                        </button>
                        <button id="duplicateSurveyBtn" class="border border-gray-300 bg-white hover:bg-gray-50 h-10 px-3 rounded-md text-sm flex items-center gap-2">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                            Duplicate
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Survey Information Card -->
                        <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
                            <div class="p-4 border-b"><h2 class="text-xl font-semibold">Survey Information</h2></div>
                            <div class="p-4 space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div><label class="text-sm font-medium text-gray-500">Survey Title</label><p id="surveyTitle" class="text-base font-medium mt-1"> Patient Satisfaction Survey</p></div>
                                    <div><label class="text-sm font-medium text-gray-500">Status</label><div class="mt-1"><span id="surveyStatus" class="status-badge status-active">Active</span></div></div>
                                    <div><label class="text-sm font-medium text-gray-500">Created Date</label><p class="text-base mt-1">April 15, 2026</p></div>
                                    <div><label class="text-sm font-medium text-gray-500">Last Modified</label><p class="text-base mt-1">May 28, 2026</p></div>
                                    <div><label class="text-sm font-medium text-gray-500">Total Responses</label><p class="text-2xl font-bold text-indigo-600 mt-1">128</p></div>
                                    <div><label class="text-sm font-medium text-gray-500">Completion Rate</label><p class="text-2xl font-bold text-green-600 mt-1">78%</p></div>
                                </div>
                                <div><label class="text-sm font-medium text-gray-500">Description</label><p id="surveyDescription" class="text-sm text-gray-600 mt-1">A comprehensive survey for patients after their visit to a hospital. Captures satisfaction, waiting times, staff professionalism, and service quality.</p></div>
                                <div><div class="flex justify-between text-sm mb-1"><span>Completion Rate</span><span>78%</span></div><div class="w-full bg-gray-200 rounded-full h-2"><div class="progress-bar bg-primary h-2 rounded-full" style="width: 78%"></div></div></div>
                            </div>
                        </div>

                        <!-- Survey Questions Card -->
                        <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
                            <div class="p-4 border-b"><h2 class="text-xl font-semibold">Survey Questions</h2><p class="text-sm text-gray-500">15 questions · 12 required</p></div>
                            <div class="p-4 space-y-4" id="questionsListContainer">
                <div class="flex items-start justify-between py-3 border p-3 rounded-lg">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-gray-400">Q1</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700">Required</span>
                            <span class="text-xs text-gray-400">Multiple Choice</span>
                        </div>
                        <p class="text-sm font-medium">What department were you visiting?</p>
                        <div class="flex flex-wrap gap-2 mt-2"><span class="text-xs text-gray-400">Options:</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Administration</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Immunization</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Outpatient clinic</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Antenatal</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Endocrinology</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">HIV clinic</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Other</span></div>
                    </div>
                </div>
            
                <div class="flex items-start justify-between py-3 border p-3 rounded-lg">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-gray-400">Q2</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700">Required</span>
                            <span class="text-xs text-gray-400">Rating</span>
                        </div>
                        <p class="text-sm font-medium">How would you rate your overall experience? (1-5)</p>
                        
                    </div>
                </div>
            
                <div class="flex items-start justify-between py-3 border p-3 rounded-lg">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-gray-400">Q3</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700">Required</span>
                            <span class="text-xs text-gray-400">Text Response</span>
                        </div>
                        <p class="text-sm font-medium">How long did you wait? (minutes)</p>
                        
                    </div>
                </div>
            
                <div class="flex items-start justify-between py-3 border p-3 rounded-lg">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-gray-400">Q4</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700">Required</span>
                            <span class="text-xs text-gray-400">Multiple Choice</span>
                        </div>
                        <p class="text-sm font-medium">Were staff friendly and professional?</p>
                        <div class="flex flex-wrap gap-2 mt-2"><span class="text-xs text-gray-400">Options:</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Yes</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">No</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Somewhat</span></div>
                    </div>
                </div>
            
                <div class="flex items-start justify-between py-3 border p-3 rounded-lg">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-gray-400">Q5</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700">Required</span>
                            <span class="text-xs text-gray-400">Multiple Choice</span>
                        </div>
                        <p class="text-sm font-medium">Did you receive all prescribed medication?</p>
                        <div class="flex flex-wrap gap-2 mt-2"><span class="text-xs text-gray-400">Options:</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Yes, all</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Some, not all</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">None</span></div>
                    </div>
                </div>
            
                <div class="flex items-start justify-between py-3 border p-3 rounded-lg">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-gray-400">Q6</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700">Required</span>
                            <span class="text-xs text-gray-400">Multiple Choice</span>
                        </div>
                        <p class="text-sm font-medium">Was the facility clean?</p>
                        <div class="flex flex-wrap gap-2 mt-2"><span class="text-xs text-gray-400">Options:</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Yes</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">No</span></div>
                    </div>
                </div>
            
                <div class="flex items-start justify-between py-3 border p-3 rounded-lg">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-gray-400">Q7</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">Optional</span>
                            <span class="text-xs text-gray-400">Text Response</span>
                        </div>
                        <p class="text-sm font-medium">What could we improve?</p>
                        
                    </div>
                </div>
            
                <div class="flex items-start justify-between py-3 border p-3 rounded-lg">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-gray-400">Q8</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700">Required</span>
                            <span class="text-xs text-gray-400">Multiple Choice</span>
                        </div>
                        <p class="text-sm font-medium">Would you recommend this?</p>
                        <div class="flex flex-wrap gap-2 mt-2"><span class="text-xs text-gray-400">Options:</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Definitely</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Probably</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Not sure</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">No</span></div>
                    </div>
                </div>
            
                <div class="flex items-start justify-between py-3 border p-3 rounded-lg">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-gray-400">Q9</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700">Required</span>
                            <span class="text-xs text-gray-400">Multiple Choice</span>
                        </div>
                        <p class="text-sm font-medium">Gender</p>
                        <div class="flex flex-wrap gap-2 mt-2"><span class="text-xs text-gray-400">Options:</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Male</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Female</span></div>
                    </div>
                </div>
            
                <div class="flex items-start justify-between py-3 border p-3 rounded-lg">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-gray-400">Q10</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700">Required</span>
                            <span class="text-xs text-gray-400">Multiple Choice</span>
                        </div>
                        <p class="text-sm font-medium">Age range</p>
                        <div class="flex flex-wrap gap-2 mt-2"><span class="text-xs text-gray-400">Options:</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Under 30</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">30-50</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Over 50</span></div>
                    </div>
                </div>
            
                <div class="flex items-start justify-between py-3 border p-3 rounded-lg">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-gray-400">Q11</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-red-100 text-red-700">Required</span>
                            <span class="text-xs text-gray-400">Multiple Choice</span>
                        </div>
                        <p class="text-sm font-medium">Language</p>
                        <div class="flex flex-wrap gap-2 mt-2"><span class="text-xs text-gray-400">Options:</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">English</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Luganda</span><span class="text-xs bg-gray-100 px-2 py-0.5 rounded">Other</span></div>
                    </div>
                </div>
            
                <div class="flex items-start justify-between py-3 border p-3 rounded-lg">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-gray-400">Q12</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-600">Optional</span>
                            <span class="text-xs text-gray-400">Text Response</span>
                        </div>
                        <p class="text-sm font-medium">Additional comments</p>
                        
                    </div>
                </div>
            </div>
                        </div>

                        <!-- Recent Responses Card -->
                        <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
                            <div class="p-4 border-b">
                                <h2 class="text-xl font-semibold">Recent Responses</h2>
                                <div class="text-gray-500 text-sm">Latest anonymous feedback from patients</div>
                            </div>
                            <div class="p-4 space-y-4" id="recentResponsesContainer">
                <div class="p-4 border rounded-md response-card">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500">05/28/2026 at 2:30 AM</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100">Outpatient clinic</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">"Very friendly staff, but waited 45 minutes"</p>
                </div>
            
                <div class="p-4 border rounded-md response-card">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500">05/28/2026 at 11:15 AM AM AM</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100">Immunization</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">"Nurses were gentle with my baby"</p>
                </div>
            
                <div class="p-4 border rounded-md response-card">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500">05/27/2026 at 9:45 AM</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100">Pharmacy</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">"Medicines were out of stock again"</p>
                </div>
            
                <div class="p-4 border rounded-md response-card">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500">05/27/2026 at 1:20 AM</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100">Antenatal</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">"The midwife was very supportive"</p>
                </div>
            
                <div class="p-4 border rounded-md response-card">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-gray-500">05/26/2026 at 4:00 AM</span>
                            <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100">Outpatient clinic</span>
                        </div>
                        <div class="flex items-center gap-0.5">
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-yellow-500" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                                <svg class="h-4 w-4 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                                </svg>
                            
                        </div>
                    </div>
                    <p class="mt-2 text-sm text-gray-600">"Long wait, but doctor was good"</p>
                </div>
            </div>
                            <div class="p-4 pt-0">
                                <button id="viewAllResponsesBtn" class="inline-flex items-center justify-center border border-gray-300 bg-white hover:bg-gray-50 h-10 px-3 rounded-md text-sm w-full transition-colors">View All Responses</button>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Analytics Summary -->
                        <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
                            <div class="p-4 border-b"><h2 class="text-xl font-semibold">Analytics Summary</h2></div>
                            <div class="p-4 space-y-4 analytics-centered">
                                <div class="flex justify-between items-center pb-4 border-b w-full">
                                    <span class="text-sm">Average Satisfaction</span>
                                    <span class="font-bold text-lg text-green-600">4.2 / 5</span>
                                </div>
                                <div class="flex justify-between items-center pb-4 border-b w-full">
                                    <span class="text-sm">Average Wait Time</span>
                                    <span class="font-bold text-lg text-amber-600">32 min</span>
                                </div>
                                <div class="flex justify-between items-center pb-4 border-b w-full">
                                    <span class="text-sm">Would Recommend</span>
                                    <span class="font-bold text-lg text-green-600">84%</span>
                                </div>
                                <div class="flex justify-between items-center pb-4 w-full">
                                    <span class="text-sm">Staff Friendly Rating</span>
                                    <span class="font-bold text-lg text-green-600">91%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Distribution Channels Card -->
                        <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
                            <div class="p-4 border-b"><h2 class="text-xl font-semibold">Active Channels</h2></div>
                            <div class="p-4 space-y-2">
                                <div class="flex items-center gap-2 py-1"><svg class="h-4 w-4 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg><span class="text-sm">USSD (*171#)</span></div>
                                <div class="flex items-center gap-2 py-1"><svg class="h-4 w-4 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg><span class="text-sm">SMS (Auto-sent after visit)</span></div>
                                <div class="flex items-center gap-2 py-1"><svg class="h-4 w-4 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg><span class="text-sm">QR Code (Waiting area)</span></div>
                                <div class="flex items-center gap-2 py-1"><svg class="h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="18" y1="6" x2="6" y2="18"/></svg><span class="text-sm text-gray-400">WhatsApp (Inactive)</span></div>
                            </div>
                        </div>

                        <!-- Settings Summary Card -->
                        <div class="rounded-lg border border-gray-200 bg-background shadow-sm">
                            <div class="p-4 border-b"><h2 class="text-xl font-semibold">Survey Settings</h2></div>
                            <div class="p-4 space-y-3">
                                <div class="flex justify-between items-center"><span class="text-sm">Anonymous Responses</span><span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">Enabled</span></div>
                                <div class="flex justify-between items-center"><span class="text-sm">Offline Mode (PWA)</span><span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">Enabled</span></div>
                                <div class="flex justify-between items-center"><span class="text-sm">Stock-Out Alerts</span><span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">Enabled</span></div>
                                <div class="flex justify-between items-center"><span class="text-sm">Auto-close Date</span><span class="text-xs text-gray-500" id="autoCloseStatusDisplay">Not set</span></div>
                            </div>
                        </div>

                        <!-- Pharmacy Stock Alert Card -->
                        <div class="rounded-lg border border-amber-200 bg-amber-50 shadow-sm">
                            <div class="p-4 border-b border-amber-200"><h2 class="text-xl font-semibold text-amber-700">⚠️ Pharmacy Stock Alert</h2><div class="text-amber-600 text-sm">Real-time medication shortage tracking</div></div>
                            <div class="p-4 space-y-3">
                                <div class="flex justify-between items-center">
                                    <div><label class="text-sm font-medium">Stock-Out Alerts</label><p class="text-xs text-gray-600">Alert when 3+ patients report missing drug</p></div>
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700">Enabled</span>
                                </div>
                                <div class="text-xs text-gray-600 mt-2">Current reported shortages this month: <span class="font-bold text-amber-700">12</span> unique medications</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Delete Modal -->
    <div id="deleteSurveyModal" class="modal-backdrop hidden">
        <div class="modal-content max-w-lg w-full mx-4">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="h-5 w-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                    </div>
                    <h2 class="text-lg font-semibold">Delete "Patient Satisfaction Survey"?</h2>
                </div>
                <p class="text-sm text-gray-600 mb-6">This action will permanently delete this survey and all 128 associated responses. This action cannot be undone.</p>
                <div class="flex justify-end gap-3">
                    <button id="cancelDeleteBtn" class="px-4 py-2 rounded-md border border-gray-300 text-sm font-medium hover:bg-gray-100 transition">Cancel</button>
                    <button id="confirmDeleteBtn" class="px-4 py-2 rounded-md bg-red-600 text-white text-sm font-medium hover:bg-red-700 transition">Delete Survey</button>
                </div>
            </div>
        </div>
    </div>

<!-- Generate Report Modal Overlay -->
<div id="reportModalOverlay" class="modal-overlay hidden" style="position:fixed;inset:0;background-color:rgb(0 0 0 / 87%);backdrop-filter:blur(4px);z-index:9999;align-items:center;justify-content:center;">
    
    <!-- Modal Container -->
    <div class="modal-container" style="background:white;border-radius:0.75rem;width:95%;max-width:680px;max-height:90vh;overflow-y:auto;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);animation:modalSlideUp 0.2s ease-out;">
        
        <!-- Header -->
        <div class="modal-header" style="padding:1.25rem 1.5rem;border-bottom:1px solid #e5e7eb;display:flex;justify-content:space-between;align-items:flex-start;position:sticky;top:0;background:white;z-index:10;border-radius:0.75rem 0.75rem 0 0;">
            <div>
                <h2 class="modal-title" style="font-size:1.125rem;font-weight:600;margin:0;">Generate Infographic Report</h2>
                <p style="color:#6b7280;font-size:0.8rem;margin:4px 0 0;">Produces a SEMA-style one-page citizen feedback infographic</p>
            </div>
            <button id="closeReportModalBtn" class="modal-close-btn" style="background:transparent;border:none;font-size:1.5rem;cursor:pointer;color:#6b7280;width:32px;height:32px;display:flex;align-items:center;justify-content:center;border-radius:0.375rem;flex-shrink:0;">&times;</button>
        </div>
        
        <!-- Body -->
        <div style="padding:1.5rem;">
            
            <!-- Report Type Selection -->
            <div style="margin-bottom:1.5rem;">
                <label style="font-size:0.8rem;font-weight:600;color:#374151;text-transform:uppercase;letter-spacing:0.5px;display:block;margin-bottom:0.75rem;">Report Style</label>
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:0.75rem;" id="reportTypeCards">
                    
                    <div class="rtype-card selected" data-value="sema" style="cursor:pointer;text-align:center;padding:1.25rem 1rem;border-radius:0.5rem;border:2px solid #6366f1;background:#eef2ff;transition:all 0.15s;">
                        <div style="font-size:1.5rem;margin-bottom:0.5rem;">📊</div>
                        <div style="font-weight:600;font-size:0.8rem;color:#312e81;">Overview Report</div>
                        <div style="font-size:0.7rem;color:#6b7280;margin-top:4px;">Patient feedback report</div>
                    </div>
                    
                    <div class="rtype-card" data-value="hr" style="cursor:pointer;text-align:center;padding:1.25rem 1rem;border-radius:0.5rem;border:2px solid #e5e7eb;background:white;transition:all 0.15s;">
                        <div style="font-size:1.5rem;margin-bottom:0.5rem;">📋</div>
                        <div style="font-weight:600;font-size:0.8rem;color:#374151;">Annual Summary</div>
                        <div style="font-size:0.7rem;color:#6b7280;margin-top:4px;">Corporate one-pager</div>
                    </div>
                    
                    <div class="rtype-card" data-value="dept" style="cursor:pointer;text-align:center;padding:1.25rem 1rem;border-radius:0.5rem;border:2px solid #e5e7eb;background:white;transition:all 0.15s;">
                        <div style="font-size:1.5rem;margin-bottom:0.5rem;">🏥</div>
                        <div style="font-weight:600;font-size:0.8rem;color:#374151;">Dept Breakdown</div>
                        <div style="font-size:0.7rem;color:#6b7280;margin-top:4px;">Department deep-dive</div>
                    </div>
                    
                </div>
            </div>
            
            <!-- Options Row -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
                <div>
                    <label style="font-size:0.8rem;font-weight:600;color:#374151;display:block;margin-bottom:0.5rem;">Date Range</label>
                    <div class="radix-select" style="position:relative;width:100%;">
                        <button type="button" class="radix-select-trigger" id="reportDateRangeTrigger" style="display:flex;align-items:center;justify-content:space-between;width:100%;height:40px;padding:0 0.75rem;font-size:0.875rem;border-radius:0.375rem;border:1px solid #d1d5db;background-color:white;cursor:pointer;text-align:left;">
                            <span id="reportDateRangeText">This Month</span>
                            <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div id="reportDateRangeDropdown" class="radix-select-content hidden" style="position:absolute;top:calc(100% + 4px);left:0;right:0;z-index:10003;background:white;border:1px solid #e5e7eb;border-radius:0.375rem;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);animation:selectSlideDown 0.15s ease-out;max-height:240px;overflow-y:auto;">
                            <div class="radix-select-item" data-value="all">All Time<svg class="radix-select-item-indicator hidden h-4 w-4 ml-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                            <div class="radix-select-item" data-value="month" data-selected="true" style="background:#eef2ff;color:#4f46e5;font-weight:500;">This Month<svg class="radix-select-item-indicator h-4 w-4 ml-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:block;"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                            <div class="radix-select-item" data-value="quarter">Last 3 Months<svg class="radix-select-item-indicator hidden h-4 w-4 ml-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                            <div class="radix-select-item" data-value="year">This Year<svg class="radix-select-item-indicator hidden h-4 w-4 ml-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label style="font-size:0.8rem;font-weight:600;color:#374151;display:block;margin-bottom:0.5rem;">Facility / Branch</label>
                    <div class="radix-select" style="position:relative;width:100%;">
                        <button type="button" class="radix-select-trigger" id="reportFacilityTrigger" style="display:flex;align-items:center;justify-content:space-between;width:100%;height:40px;padding:0 0.75rem;font-size:0.875rem;border-radius:0.375rem;border:1px solid #d1d5db;background-color:white;cursor:pointer;text-align:left;">
                            <span id="reportFacilityText">Kisenyi</span>
                            <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                        </button>
                        <div id="reportFacilityDropdown" class="radix-select-content hidden" style="position:absolute;top:calc(100% + 4px);left:0;right:0;z-index:10003;background:white;border:1px solid #e5e7eb;border-radius:0.375rem;box-shadow:0 10px 15px -3px rgba(0,0,0,0.1);animation:selectSlideDown 0.15s ease-out;max-height:240px;overflow-y:auto;">
                            <div class="radix-select-item" data-value="kisenyi" data-selected="true" style="background:#eef2ff;color:#4f46e5;font-weight:500;">Kisenyi<svg class="radix-select-item-indicator h-4 w-4 ml-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display:block;"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                            <div class="radix-select-item" data-value="kampala">Arua Clinic<svg class="radix-select-item-indicator hidden h-4 w-4 ml-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                            <div class="radix-select-item" data-value="all">All Facilities<svg class="radix-select-item-indicator hidden h-4 w-4 ml-auto" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sections to Include -->
            <div style="margin-bottom:1.5rem;">
                <label style="font-size:0.8rem;font-weight:600;color:#374151;text-transform:uppercase;letter-spacing:0.5px;display:block;margin-bottom:0.75rem;">Sections to Include</label>
                <div style="display:flex;flex-wrap:wrap;gap:0.5rem;" id="sectionToggles">
                    <button type="button" class="section-toggle-btn selected" data-section="satisfaction">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Satisfaction Rate
                    </button>
                    <button type="button" class="section-toggle-btn selected" data-section="distribution">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Distribution Chart
                    </button>
                    <button type="button" class="section-toggle-btn selected" data-section="departments">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Dept Scores
                    </button>
                    <button type="button" class="section-toggle-btn selected" data-section="experiences">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Patient Experience
                    </button>
                    <button type="button" class="section-toggle-btn selected" data-section="quote">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Patient Quote
                    </button>
                    <button type="button" class="section-toggle-btn selected" data-section="rankings">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Rankings
                    </button>
                    <button type="button" class="section-toggle-btn selected" data-section="complaints">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg> Issues & Gaps
                    </button>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div style="display:flex;gap:0.75rem;align-items:center;flex-wrap:wrap;">
                <button id="previewReportBtn" class="btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    Preview Report
                </button>
                <button id="downloadReportBtn" class="btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg>
                    Download PDF
                </button>
                <button id="cancelReportBtn" class="btn-cancel" style="margin-left:auto;">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>


<!-- ── Report Preview Modal ──────────────────────────────────────── -->
<div id="reportPreviewModal" class="modal-backdrop hidden" style="padding:16px;overflow-y:auto;">
  <div style="max-width:900px;width:100%;margin:0 auto;">
    <!-- Toolbar -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;flex-wrap:wrap;gap:8px;">
      <div style="display:flex;gap:8px;align-items:center;">
        <button id="backToSettingsBtn" style="background:#fff;border:1px solid #d1d5db;padding:8px 14px;border-radius:8px;font-size:.8rem;cursor:pointer;display:flex;align-items:center;gap:5px;">
          ← Back
        </button>
        <span style="font-weight:600;color:#fff;font-size:.9rem;">Report Preview</span>
      </div>
      <div style="display:flex;gap:8px;">
        <button id="downloadFinalBtn" style="background:linear-gradient(135deg,#4f46e5,#7c3aed);color:#fff;border:none;padding:9px 18px;border-radius:8px;font-size:.8rem;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:6px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
          Download PDF
        </button>
        <button id="closePreviewBtn" style="background:rgba(255,255,255,.15);border:none;color:#fff;width:36px;height:36px;border-radius:50%;cursor:pointer;font-size:1rem;">✕</button>
      </div>
    </div>
    <!-- Report content renders here -->
    <div id="reportPreviewContent" style="border-radius:12px;overflow:hidden;box-shadow:0 20px 60px rgba(0,0,0,.4);"></div>
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
    // ============================================================
// REPORT GENERATOR + NEW HMS MODAL
// ============================================================
 
// ── Data ─────────────────────────────────────────────────────
const REPORT_DATA = {
  facility: 'Gulu',
  period: 'May 2026',
  satisfactionRate: 79.3,
  prevRate: 81.5,
  totalInterviewed: 133,
  totalDevicePresses: 59,
  avgWaitTime: 58,
  wouldRecommend: 87.9,
  wouldNotRecommend: 12.1,
  rankings: [
    { name:'Arua', score:82.5 },
    { name:'Mbarara', score:80.8 },
    { name:'Fort Portal', score:79.7 },
    { name:'Arua', score:78.8, isCurrent:true },
    { name:'Jinja', score:77.8 },
    { name:'Mukono', score:75.5 },
    { name:'Gulu', score:73.2 }
  ],
  rankPosition: 4,
  rankTotal: 7,
  rankMonth: 'May 2026',
  distribution: {
    veryGood:  28.6,
    good:      23.3,
    okay:      42.9,
    bad:        4.5,
    veryBad:    0.8
  },
  departments: [
    { name:'Dentistry',     score:88.0, wait:27 },
    { name:'Radiology', score:85.9, wait:60 },
    { name:'Orthopedics',  score:80.0, wait:82 },
    { name:'Maternity',     score:80.0, wait:63 },
    { name:'Dermatology',   score:78.2, wait:40 },
    { name:'Immunization',  score:77.2, wait:49 },
    { name:'Antenatal',     score:74.4, wait:35 },
    { name:'Endocrinology',score:73.3, wait:19 }
  ],
  experiences: [
    { q:'Did you find the medical staff friendly and professional?', yes:96.2 },
    { q:'Did medical personnel explain your disease & medication?',  yes:97.0 },
    { q:'Did you receive care in a clean environment?',              yes:98.5 },
    { q:'Would you recommend anyone to come for services here?',     yes:94.5 }
  ],
  deptFocus: {
    name: 'Radiology',
    body: 'Patients who received services from this department felt that the staff were reliable as there was often an attentive medical officer present to work on them.'
  },
  complaint: 'Majority of the citizens who visited during this month reported that the staff was slow during service delivery.',
  quote: 'I came here to get my baby immunized. The doctor who worked on me was very friendly and kind.',
  quoteSource: 'Patient acquiring services from Immunization dept at Kisenyi',
  contact: 'Operations Manager: Okello David at +256 788 828272 · customer@hospital.ug · www.meditrack.com'
};
 
// ── Helpers ──────────────────────────────────────────────────
function donutSvg(slices, size=140, thickness=22) {
  const R = (size/2) - thickness/2;
  const cx = size/2, cy = size/2;
  const circumference = 2 * Math.PI * R;
  let offset = 0;
  const svgParts = slices.map(s => {
    const dash = (s.pct/100) * circumference;
    const gap  = circumference - dash;
    const el   = `<circle cx="${cx}" cy="${cy}" r="${R}" fill="none" stroke="${s.color}" stroke-width="${thickness}" stroke-dasharray="${dash} ${gap}" stroke-dashoffset="${-offset}" style="transition:all .4s;"/>`;
    offset += dash;
    return el;
  });
  return `<svg width="${size}" height="${size}" viewBox="0 0 ${size} ${size}" style="transform:rotate(-90deg);">${svgParts.join('')}</svg>`;
}
 
function hBar(pct, color='#4f46e5', h=8, radius=4) {
  return `<div style="width:100%;background:#e5e7eb;border-radius:${radius}px;height:${h}px;overflow:hidden;">
    <div style="width:${Math.min(100,pct)}%;height:100%;background:${color};border-radius:${radius}px;transition:width .5s;"></div>
  </div>`;
}
 
function scoreColor(s) {
  if(s>=80) return '#15803d';
  if(s>=60) return '#ca8a04';
  return '#dc2626';
}

// ── State ─────────────────────────────────────────────────────
let reportState = { type: 'sema', dateRange: 'month', facility: 'kisenyi', sections: ['satisfaction','distribution','departments','experiences','quote','rankings','complaints'] };
 
function getSelectedSections() {
  const out = {};
  reportState.sections.forEach(s => { out[s] = true; });
  return out;
}
 
function getFacilityData() {
  const data = {...REPORT_DATA};
  if (reportState.facility === 'kampala') { data.facility = 'Arua Clinic'; data.satisfactionRate = 82.5; data.rankPosition = 1; }
  else if (reportState.facility === 'all') { data.facility = 'All Medi-track Facilities'; data.satisfactionRate = 78.8; }
  return data;
}
 
// ── Report Templates ─────────────────────────────────────────
function buildSemaReport(d, sections) {
  const trend = d.satisfactionRate >= d.prevRate ? '↑' : '↓';
  const trendColor = trend === '↑' ? '#86efac' : '#fca5a5';
  const trendPct = Math.abs(d.satisfactionRate - d.prevRate).toFixed(1);
  const donutSlices = [
    { pct: d.distribution.veryGood, color:'#16a34a' },
    { pct: d.distribution.good,     color:'#22c55e' },
    { pct: d.distribution.okay,     color:'#f59e0b' },
    { pct: d.distribution.bad,      color:'#ef4444' },
    { pct: d.distribution.veryBad,  color:'#dc2626' }
  ];
  return `
  <div id="pdf-report" style="font-family:'Inter',system-ui,sans-serif;background:#fff;width:100%;box-sizing:border-box;">
    <div style="background:linear-gradient(135deg,#1e1b4b 0%,#312e81 40%,#4338ca 100%);padding:22px 28px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
      <div style="display:flex;align-items:center;gap:14px;">
        <div style="background:rgba(255,255,255,.15);border-radius:12px;padding:10px 14px;font-size:1.5rem;font-weight:900;color:#fff;letter-spacing:-1px;">M</div>
        <div>
          <div style="color:rgba(255,255,255,.65);font-size:.7rem;letter-spacing:2px;text-transform:uppercase;font-weight:600;">${d.period} · Citizen Feedback Report</div>
          <div style="color:#fff;font-size:1.4rem;font-weight:800;line-height:1.2;">${d.facility}</div>
        </div>
      </div>
      <div style="display:flex;gap:20px;align-items:center;flex-wrap:wrap;">
        <div style="text-align:center;"><div style="color:#a5b4fc;font-size:.65rem;text-transform:uppercase;letter-spacing:1px;">Interviewed</div><div style="color:#fff;font-size:1.4rem;font-weight:800;">${d.totalInterviewed}</div></div>
        <div style="text-align:center;"><div style="color:#a5b4fc;font-size:.65rem;text-transform:uppercase;letter-spacing:1px;">Device Presses</div><div style="color:#fff;font-size:1.4rem;font-weight:800;">${d.totalDevicePresses}</div></div>
        <div style="text-align:center;"><div style="color:#a5b4fc;font-size:.65rem;text-transform:uppercase;letter-spacing:1px;">Avg Wait</div><div style="color:#fff;font-size:1.4rem;font-weight:800;">${d.avgWaitTime}m</div></div>
      </div>
    </div>
    ${sections.satisfaction ? `
    <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap;background:#4f46e5;padding:2rem;">
      <div style="text-align:center;flex:1;min-width:160px;">
        <div style="color:rgba(255,255,255,.75);font-size:.7rem;letter-spacing:2px;text-transform:uppercase;font-weight:600;margin-bottom:6px;">Service Satisfaction Rate</div>
        <div style="color:#fff;font-size:4rem;font-weight:900;line-height:1;margin-bottom:6px;">${d.satisfactionRate}%</div>
        <div style="color:rgba(255,255,255,.75);font-size:.8rem;">vs prev period <strong style="color:${trendColor};">${trend}${trendPct}%</strong> (was ${d.prevRate}%)</div>
      </div>
      <div style="flex:1;min-width:160px;">
        <div style="color:rgba(255,255,255,.75);font-size:.7rem;letter-spacing:2px;text-transform:uppercase;font-weight:600;margin-bottom:10px;">Would Recommend?</div>
        <div style="display:flex;align-items:center;gap:10px;">
          <div style="flex:1;background:rgba(255,255,255,.2);border-radius:8px;height:12px;overflow:hidden;"><div style="width:${d.wouldRecommend}%;height:100%;background:#22c55e;border-radius:8px;"></div></div>
          <span style="color:#fff;font-size:1.2rem;font-weight:800;min-width:50px;">YES ${d.wouldRecommend}%</span>
        </div>
        <div style="color:rgba(255,255,255,.6);font-size:.75rem;margin-top:6px;">NO ${d.wouldNotRecommend}%</div>
      </div>
    </div>` : ''}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0;">
      <div style="border-right:1px solid #e5e7eb;">
        ${sections.rankings ? `
        <div style="padding:20px 22px;border-bottom:1px solid #e5e7eb;">
          <div style="font-weight:800;font-size:.95rem;color:#1e1b4b;margin-bottom:4px;">Compared to Other Branches</div>
          <div style="font-size:.75rem;color:#6b7280;margin-bottom:14px;">Ranked <strong style="color:#4f46e5;">${d.rankPosition}${['st','nd','rd'][d.rankPosition-1]||'th'} out of ${d.rankTotal}</strong> in ${d.rankMonth}</div>
          ${d.rankings.map((r,i) => `
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
              <div style="display:flex;align-items:center;gap:8px;"><span style="width:18px;height:18px;border-radius:50%;background:${r.isCurrent?'#4f46e5':'#e5e7eb'};color:${r.isCurrent?'#fff':'#6b7280'};font-size:.65rem;font-weight:700;display:flex;align-items:center;justify-content:center;">${i+1}</span><span style="font-size:.8rem;${r.isCurrent?'font-weight:700;color:#1e1b4b;':'color:#374151;'}">${r.name}${r.isCurrent?' ◀':''}</span></div>
              <div style="display:flex;align-items:center;gap:8px;"><div style="width:60px;background:#e5e7eb;border-radius:4px;height:6px;overflow:hidden;"><div style="width:${r.score}%;height:100%;background:${r.isCurrent?'#4f46e5':'#94a3b8'};border-radius:4px;"></div></div><span style="font-size:.75rem;font-weight:700;color:#374151;min-width:38px;text-align:right;">${r.score}%</span></div>
            </div>`).join('')}
        </div>` : ''}
        ${sections.departments ? `
        <div style="padding:20px 22px;border-bottom:1px solid #e5e7eb;">
          <div style="font-weight:800;font-size:.95rem;color:#1e1b4b;margin-bottom:14px;">Department Scores</div>
          <div style="display:grid;grid-template-columns:1fr auto auto;gap:4px 10px;align-items:center;">
            <div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.5px;color:#9ca3af;font-weight:600;">Department</div><div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.5px;color:#9ca3af;font-weight:600;text-align:center;">Score</div><div style="font-size:.65rem;text-transform:uppercase;letter-spacing:.5px;color:#9ca3af;font-weight:600;text-align:center;">Wait</div>
            ${d.departments.map(dep => `<div style="font-size:.78rem;color:#374151;padding:3px 0;border-bottom:1px solid #f3f4f6;">${dep.name}</div><div style="text-align:center;"><span style="background:${scoreColor(dep.score)};color:#fff;font-size:.7rem;font-weight:700;padding:2px 7px;border-radius:20px;">${dep.score}%</span></div><div style="text-align:center;font-size:.75rem;font-weight:600;color:#4b5563;">${dep.wait}m</div>`).join('')}
          </div>
        </div>` : ''}
        ${sections.complaints ? `
        <div style="padding:20px 22px;"><div style="display:flex;align-items:flex-start;gap:10px;background:#fef3c7;border-left:4px solid #f59e0b;border-radius:6px;padding:14px;"><div style="font-size:1.2rem;">⚠️</div><div><div style="font-weight:700;font-size:.8rem;color:#92400e;margin-bottom:4px;">What Can Still Be Worked Upon?</div><p style="font-size:.78rem;color:#78350f;line-height:1.5;margin:0;">${d.complaint}</p></div></div></div>` : ''}
      </div>
      <div>
        ${sections.distribution ? `
        <div style="padding:20px 22px;border-bottom:1px solid #e5e7eb;">
          <div style="font-weight:800;font-size:.95rem;color:#1e1b4b;margin-bottom:14px;">Citizen Satisfaction Distribution</div>
          <div style="display:flex;align-items:center;gap:16px;">
            <div style="position:relative;flex-shrink:0;">${donutSvg(donutSlices, 120, 20)}<div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;"><div style="font-size:1rem;font-weight:800;color:#1e1b4b;">${d.satisfactionRate}%</div><div style="font-size:.55rem;color:#6b7280;">overall</div></div></div>
            <div style="flex:1;">${[{label:'Very Good (81-100%)', pct:d.distribution.veryGood, color:'#16a34a'},{label:'Good (61-80%)', pct:d.distribution.good, color:'#22c55e'},{label:'Okay (41-60%)', pct:d.distribution.okay, color:'#f59e0b'},{label:'Bad (21-40%)', pct:d.distribution.bad, color:'#ef4444'},{label:'Very Bad (0-20%)', pct:d.distribution.veryBad, color:'#dc2626'}].map(s => `<div style="margin-bottom:7px;"><div style="display:flex;justify-content:space-between;font-size:.72rem;margin-bottom:3px;"><span style="color:#374151;">${s.label}</span><span style="font-weight:700;color:#1e1b4b;">${s.pct}%</span></div>${hBar(s.pct, s.color, 6)}</div>`).join('')}</div>
          </div>
        </div>` : ''}
        ${sections.experiences ? `
        <div style="padding:20px 22px;border-bottom:1px solid #e5e7eb;">
          <div style="font-weight:800;font-size:.95rem;color:#1e1b4b;margin-bottom:14px;">Citizens' Experiences at ${d.facility}</div>
          ${d.experiences.map(ex => `<div style="margin-bottom:12px;"><div style="font-size:.75rem;color:#374151;margin-bottom:5px;">${ex.q}</div><div style="display:flex;align-items:center;gap:8px;"><div style="flex:1;background:#e5e7eb;border-radius:4px;height:10px;overflow:hidden;"><div style="width:${ex.yes}%;height:100%;background:#4f46e5;border-radius:4px;"></div></div><span style="font-size:.8rem;font-weight:800;color:#4f46e5;min-width:40px;">YES ${ex.yes}%</span><span style="font-size:.75rem;color:#9ca3af;">NO ${(100-ex.yes).toFixed(1)}%</span></div></div>`).join('')}
        </div>` : ''}
        ${sections.quote ? `
        <div style="padding:20px 22px;"><div style="font-weight:800;font-size:.85rem;color:#1e1b4b;margin-bottom:8px;">🏥 Department Focus: ${d.deptFocus.name}</div><p style="font-size:.75rem;color:#374151;line-height:1.5;margin:0 0 12px;">${d.deptFocus.body}</p><div style="background:#eff6ff;border-left:4px solid #3b82f6;border-radius:6px;padding:12px;margin-bottom:10px;"><div style="font-size:.75rem;color:#1e40af;font-style:italic;line-height:1.5;">"${d.quote}"</div><div style="font-size:.65rem;color:#3b82f6;margin-top:6px;">— ${d.quoteSource}</div></div></div>` : ''}
      </div>
    </div>
    <div style="background:#4f46e5;padding:1rem 1.5rem;display:flex;align-items:center;flex-wrap:wrap;gap:1rem;">
      <div class="text-xs text-white">${d.contact}</div>
      <div class="text-xs text-white">Report generated ${new Date().toLocaleDateString('en-GB',{day:'numeric',month:'long',year:'numeric'})}</div>
    </div>
  </div>`;
}

function buildHRReport(d, sections) {
  return `
  <div id="pdf-report" style="font-family:'Inter',system-ui,sans-serif;background:#fff;width:100%;box-sizing:border-box;">
    <!-- HEADER -->
    <div style="background:linear-gradient(135deg,#0f172a 0%,#1e3a5f 60%,#1e40af 100%);padding:28px;display:flex;justify-content:space-between;align-items:center;gap:20px;flex-wrap:wrap;">
      <div>
        <div style="color:#93c5fd;font-size:.7rem;letter-spacing:2px;text-transform:uppercase;font-weight:600;">Annual Performance Report · ${d.period}</div>
        <h1 style="color:#fff;font-size:2rem;font-weight:900;line-height:1.1;margin:4px 0 0;">${d.facility}</h1>
        <p style="color:rgba(255,255,255,.6);font-size:.85rem;margin:6px 0 0;">Patient Satisfaction & Service Quality Report</p>
      </div>
      <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;">
        ${[
          {label:'Satisfaction', val:d.satisfactionRate+'%', color:'#22c55e'},
          {label:'Responses', val:d.totalInterviewed, color:'#60a5fa'},
          {label:'Avg Wait', val:d.avgWaitTime+'m', color:'#fbbf24'}
        ].map(m => `
          <div style="text-align:center;background:rgba(255,255,255,.08);border-radius:10px;padding:12px 8px;">
            <div style="color:${m.color};font-size:1.5rem;font-weight:900;">${m.val}</div>
            <div style="color:rgba(255,255,255,.5);font-size:.65rem;text-transform:uppercase;letter-spacing:.5px;">${m.label}</div>
          </div>
        `).join('')}
      </div>
    </div>
 
    <!-- PERFORMANCE SNAPSHOT -->
    ${sections.experiences ? `
    <div style="background:#f8fafc;padding:20px 24px;border-bottom:1px solid #e2e8f0;">
      <div style="font-weight:800;font-size:.9rem;color:#1e293b;margin-bottom:16px;text-transform:uppercase;letter-spacing:.5px;">▶ Performance Snapshot</div>
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;">
        ${d.experiences.map(ex => `
          <div style="background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:14px;text-align:center;box-shadow:0 1px 3px rgba(0,0,0,.06);">
            <div style="font-size:1.6rem;font-weight:900;color:#1e40af;">${ex.yes}%</div>
            <div style="font-size:.7rem;color:#64748b;line-height:1.4;margin-top:4px;">${ex.q.substring(0,55)}${ex.q.length>55?'…':''}</div>
          </div>
        `).join('')}
      </div>
    </div>` : ''}
 
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0;">
      <div style="border-right:1px solid #e2e8f0;">
        ${sections.rankings ? `
        <div style="padding:20px 22px;border-bottom:1px solid #e2e8f0;">
          <div style="font-weight:800;font-size:.9rem;color:#1e293b;margin-bottom:14px;">Facility Rankings</div>
          ${d.rankings.map((r,i) => `
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
              <div style="display:flex;align-items:center;gap:8px;">
                <span style="width:22px;height:22px;border-radius:6px;background:${r.isCurrent?'#1e40af':i<3?'#dbeafe':'#f1f5f9'};color:${r.isCurrent?'#fff':i<3?'#1e40af':'#64748b'};font-size:.7rem;font-weight:800;display:flex;align-items:center;justify-content:center;">${i+1}</span>
                <span style="font-size:.8rem;${r.isCurrent?'font-weight:800;color:#1e293b;':'color:#475569;'}">${r.name}${r.isCurrent?' ★':''}</span>
              </div>
              <div style="display:flex;align-items:center;gap:8px;"><div style="width:70px;background:#e2e8f0;border-radius:4px;height:6px;overflow:hidden;"><div style="width:${r.score}%;height:100%;background:${r.isCurrent?'#1e40af':'#94a3b8'};border-radius:4px;"></div></div><span style="font-size:.75rem;font-weight:700;">${r.score}%</span></div>
            </div>`).join('')}
        </div>` : ''}
        ${sections.departments ? `
        <div style="padding:20px 22px;">
          <div style="font-weight:800;font-size:.9rem;color:#1e293b;margin-bottom:14px;">Department Performance</div>
          ${d.departments.map(dep => `
            <div style="margin-bottom:10px;">
              <div style="display:flex;justify-content:space-between;font-size:.78rem;margin-bottom:4px;"><span style="color:#374151;font-weight:500;">${dep.name}</span><span style="font-weight:700;color:${scoreColor(dep.score)};">${dep.score}% <span style="color:#94a3b8;font-weight:400;">(${dep.wait}m)</span></span></div>
              ${hBar(dep.score, scoreColor(dep.score), 7)}
            </div>`).join('')}
        </div>` : ''}
      </div>
      <div>
        ${sections.distribution ? `
        <div style="padding:20px 22px;border-bottom:1px solid #e2e8f0;">
          <div style="font-weight:800;font-size:.9rem;color:#1e293b;margin-bottom:14px;">Satisfaction Distribution</div>
          ${[{label:'Very Good', pct:d.distribution.veryGood, color:'#16a34a'},{label:'Good', pct:d.distribution.good, color:'#22c55e'},{label:'Okay', pct:d.distribution.okay, color:'#f59e0b'},{label:'Bad', pct:d.distribution.bad, color:'#ef4444'},{label:'Very Bad', pct:d.distribution.veryBad, color:'#dc2626'}].map(s => `
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;"><span style="width:8px;height:8px;border-radius:50%;background:${s.color};flex-shrink:0;"></span><div style="flex:1;"><div style="display:flex;justify-content:space-between;font-size:.75rem;margin-bottom:3px;"><span>${s.label}</span><span style="font-weight:700;">${s.pct}%</span></div>${hBar(s.pct, s.color, 8)}</div></div>`).join('')}
        </div>` : ''}
        ${sections.quote ? `
        <div style="padding:20px 22px;border-bottom:1px solid #e2e8f0;">
          <div style="font-weight:800;font-size:.9rem;color:#1e293b;margin-bottom:12px;">Client Testimonial</div>
          <div style="background:linear-gradient(135deg,#eff6ff,#dbeafe);border-radius:10px;padding:16px;"><div style="font-size:2rem;color:#1e40af;line-height:1;margin-bottom:6px;">"</div><p style="font-size:.82rem;color:#1e3a8a;line-height:1.6;margin:0 0 8px;font-style:italic;">${d.quote}</p><div style="font-size:.7rem;color:#3b82f6;font-weight:600;">— ${d.quoteSource}</div></div>
        </div>` : ''}
        ${sections.complaints ? `
        <div style="padding:20px 22px;">
          <div style="font-weight:800;font-size:.9rem;color:#1e293b;margin-bottom:10px;">Areas for Improvement</div>
          <div style="background:#fef3c7;border-radius:8px;padding:14px;border-left:4px solid #f59e0b;"><p style="font-size:.78rem;color:#78350f;line-height:1.5;margin:0;">${d.complaint}</p></div>
          <div style="margin-top:12px;"><div style="font-size:.75rem;font-weight:600;color:#374151;margin-bottom:8px;">Recommended Actions:</div>${['Staff customer care training','Increase medication stock levels','Reduce average waiting times','Deploy more medical officers during peak hours'].map(a => `<div style="display:flex;align-items:flex-start;gap:6px;margin-bottom:5px;font-size:.75rem;color:#475569;"><span style="color:#f59e0b;margin-top:1px;">▶</span>${a}</div>`).join('')}</div>
        </div>` : ''}
      </div>
    </div>
    <!-- FOOTER -->
    <div style="background:#0f172a;padding:14px 22px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
      <div style="color:rgba(255,255,255,.4);font-size:.65rem;">${d.contact}</div>
      <div style="color:rgba(255,255,255,.25);font-size:.65rem;">Generated ${new Date().toLocaleDateString('en-GB',{day:'numeric',month:'long',year:'numeric'})}</div>
    </div>
  </div>`;
}

function buildDeptReport(d, sections) {
  return `
  <div id="pdf-report" style="font-family:'Inter',system-ui,sans-serif;background:#fff;width:100%;box-sizing:border-box;">
    <!-- HEADER -->
    <div style="background:linear-gradient(135deg,#064e3b 0%,#065f46 50%,#047857 100%);padding:22px 28px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
      <div>
        <div style="color:#6ee7b7;font-size:.7rem;letter-spacing:2px;text-transform:uppercase;font-weight:600;">Department Deep-Dive · ${d.period}</div>
        <h1 style="color:#fff;font-size:1.6rem;font-weight:900;margin:4px 0 0;">${d.facility}</h1>
      </div>
      <div style="display:flex;gap:16px;">
        ${[{l:'Overall Score',v:d.satisfactionRate+'%'},{l:'Patients Seen',v:d.totalInterviewed},{l:'Avg Wait',v:d.avgWaitTime+'m'}].map(m=>`<div style="text-align:center;background:rgba(255,255,255,.12);border-radius:8px;padding:10px 14px;"><div style="color:#fff;font-size:1.4rem;font-weight:800;">${m.v}</div><div style="color:#6ee7b7;font-size:.65rem;">${m.l}</div></div>`).join('')}
      </div>
    </div>
    ${sections.departments ? `
    <div style="padding:20px 22px;border-bottom:1px solid #e5e7eb;">
      <div style="font-weight:800;font-size:.95rem;color:#064e3b;margin-bottom:16px;">All Department Scores & Wait Times</div>
      <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;">
        ${d.departments.map(dep => `
          <div style="border:2px solid ${scoreColor(dep.score)}22;border-radius:10px;padding:14px;text-align:center;background:${scoreColor(dep.score)}08;">
            <div style="font-size:1.4rem;font-weight:900;color:${scoreColor(dep.score)};">${dep.score}%</div>
            <div style="font-size:.7rem;font-weight:700;color:#374151;margin:4px 0 2px;">${dep.name}</div>
            <div style="font-size:.65rem;color:#6b7280;">Wait: ${dep.wait} min</div>
            <div style="margin-top:8px;">${hBar(dep.score, scoreColor(dep.score), 5)}</div>
          </div>`).join('')}
      </div>
    </div>` : ''}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:0;">
      <div style="border-right:1px solid #e5e7eb;">
        ${sections.experiences ? `
        <div style="padding:20px 22px;border-bottom:1px solid #e5e7eb;">
          <div style="font-weight:800;font-size:.9rem;color:#064e3b;margin-bottom:14px;">Patient Experience Metrics</div>
          ${d.experiences.map(ex => `<div style="margin-bottom:12px;"><div style="font-size:.75rem;color:#374151;margin-bottom:5px;line-height:1.4;">${ex.q}</div><div style="display:flex;align-items:center;gap:8px;"><div style="flex:1;background:#e5e7eb;border-radius:4px;height:10px;overflow:hidden;"><div style="width:${ex.yes}%;height:100%;background:#047857;border-radius:4px;"></div></div><span style="font-size:.8rem;font-weight:800;color:#047857;">${ex.yes}%</span></div></div>`).join('')}
        </div>` : ''}
        ${sections.complaints ? `
        <div style="padding:20px 22px;"><div style="font-weight:800;font-size:.9rem;color:#064e3b;margin-bottom:10px;">⚠️ Key Issues to Address</div><div style="background:#fef3c7;border-left:4px solid #f59e0b;border-radius:6px;padding:14px;"><p style="font-size:.78rem;color:#78350f;line-height:1.5;margin:0;">${d.complaint}</p></div></div>` : ''}
      </div>
      <div>
        ${sections.distribution ? `
        <div style="padding:20px 22px;border-bottom:1px solid #e5e7eb;">
          <div style="font-weight:800;font-size:.9rem;color:#064e3b;margin-bottom:14px;">Score Distribution</div>
          ${[{label:'Very Good (81-100%)', pct:d.distribution.veryGood, color:'#16a34a'},{label:'Good (61-80%)', pct:d.distribution.good, color:'#22c55e'},{label:'Okay (41-60%)', pct:d.distribution.okay, color:'#f59e0b'},{label:'Bad (21-40%)', pct:d.distribution.bad, color:'#ef4444'},{label:'Very Bad (0-20%)', pct:d.distribution.veryBad, color:'#dc2626'}].map(s => `<div style="margin-bottom:10px;"><div style="display:flex;justify-content:space-between;font-size:.75rem;margin-bottom:4px;"><span style="color:#374151;">${s.label}</span><span style="font-weight:700;">${s.pct}%</span></div>${hBar(s.pct,s.color,7)}</div>`).join('')}
        </div>` : ''}
        ${sections.quote ? `
        <div style="padding:20px 22px;"><div style="font-weight:800;font-size:.9rem;color:#064e3b;margin-bottom:10px;">🏥 Department Highlight: ${d.deptFocus.name}</div><p style="font-size:.78rem;color:#374151;line-height:1.5;margin-bottom:12px;">${d.deptFocus.body}</p><div style="background:#ecfdf5;border-left:4px solid #10b981;border-radius:6px;padding:12px;"><p style="font-size:.75rem;color:#065f46;font-style:italic;line-height:1.5;margin:0;">"${d.quote}"</p><div style="font-size:.65rem;color:#10b981;margin-top:6px;">— ${d.quoteSource}</div></div></div>` : ''}
      </div>
    </div>
    ${sections.rankings ? `
    <div style="padding:16px 22px;background:#f0fdf4;border-top:1px solid #bbf7d0;">
      <div style="font-weight:800;font-size:.85rem;color:#064e3b;margin-bottom:10px;">Facility Ranking Comparison — Ranked ${d.rankPosition} of ${d.rankTotal} this period</div>
      <div style="display:flex;gap:6px;align-items:flex-end;height:50px;">
        ${d.rankings.map(r => `<div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:2px;"><div style="width:100%;background:${r.isCurrent?'#047857':'#bbf7d0'};border-radius:3px 3px 0 0;height:${Math.round((r.score/90)*44)}px;min-height:6px;"></div><div style="font-size:.55rem;color:#374151;text-align:center;line-height:1.2;">${r.name.split(' ')[0]}</div><div style="font-size:.6rem;font-weight:700;color:${r.isCurrent?'#047857':'#6b7280'};">${r.score}%</div></div>`).join('')}
      </div>
    </div>` : ''}
    <!-- FOOTER -->
    <div style="background:#064e3b;padding:14px 22px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
      <div style="color:rgba(255,255,255,.45);font-size:.65rem;">${d.contact}</div>
      <div style="color:rgba(255,255,255,.25);font-size:.65rem;">Generated ${new Date().toLocaleDateString('en-GB',{day:'numeric',month:'long',year:'numeric'})}</div>
    </div>
  </div>`;
}

function generateReportHTML() {
  const sections = getSelectedSections();
  const data = getFacilityData();
  if (reportState.type === 'hr')   return buildHRReport(data, sections);
  if (reportState.type === 'dept') return buildDeptReport(data, sections);
  return buildSemaReport(data, sections);
}

function triggerDownload() {
  const element = document.getElementById('pdf-report') || document.getElementById('reportPreviewContent');
  if (!element || typeof html2pdf === 'undefined') { alert('html2pdf not loaded'); return; }
  const fac = getFacilityData().facility.replace(/\s+/g,'_');
  html2pdf().set({
    margin: 0,
    filename: `${fac}_Report_${new Date().toISOString().split('T')[0]}.pdf`,
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2, useCORS: true, logging: false },
    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
  }).from(element).save();
}

// ==================== NEW HMS MODAL LOGIC ====================

// Open modal
document.getElementById('generateReportBtn')?.addEventListener('click', function() {
    const overlay = document.getElementById('reportModalOverlay');
    overlay.classList.remove('hidden');
    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
});

// Close modal
function closeNewReportModal() {
    const overlay = document.getElementById('reportModalOverlay');
    overlay.classList.add('hidden');
    overlay.style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('closeReportModalBtn')?.addEventListener('click', closeNewReportModal);
document.getElementById('cancelReportBtn')?.addEventListener('click', closeNewReportModal);

// Backdrop click
document.getElementById('reportModalOverlay')?.addEventListener('click', function(e) {
    if (e.target === this) closeNewReportModal();
});

// Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const overlay = document.getElementById('reportModalOverlay');
        if (overlay && !overlay.classList.contains('hidden')) {
            closeNewReportModal();
        }
    }
});

// Report type cards
document.getElementById('reportTypeCards').addEventListener('click', function(e) {
    const card = e.target.closest('.rtype-card');
    if(!card) return;
    document.querySelectorAll('.rtype-card').forEach(c => { c.classList.remove('selected'); c.style.borderColor='#e5e7eb'; c.style.background='white'; });
    card.classList.add('selected'); card.style.borderColor='#6366f1'; card.style.background='#eef2ff';
    reportState.type = card.dataset.value;
});

// Section toggles
document.getElementById('sectionToggles').addEventListener('click', function(e) {
    const btn = e.target.closest('.section-toggle-btn');
    if(!btn) return;
    const isSelected = btn.classList.contains('selected');
    if(isSelected) {
        btn.classList.remove('selected'); btn.style.borderColor='#d1d5db'; btn.style.background='white'; btn.style.color='#6b7280';
        reportState.sections = reportState.sections.filter(s => s !== btn.dataset.section);
    } else {
        btn.classList.add('selected'); btn.style.borderColor='#6366f1'; btn.style.background='#eef2ff'; btn.style.color='#4f46e5';
        if(!reportState.sections.includes(btn.dataset.section)) reportState.sections.push(btn.dataset.section);
    }
});

// Radix UI Selects
function setupRadixSelect(triggerId, dropdownId, textId, onChange) {
    const trigger = document.getElementById(triggerId), dropdown = document.getElementById(dropdownId), text = document.getElementById(textId);
    if(!trigger||!dropdown||!text) return;
    trigger.addEventListener('click', function(e) { e.stopPropagation(); document.querySelectorAll('.radix-select-content').forEach(d => { if(d.id!==dropdownId) d.classList.add('hidden'); }); dropdown.classList.toggle('hidden'); });
    dropdown.querySelectorAll('.radix-select-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.stopPropagation();
            text.textContent = this.textContent.replace(/[✓✔✅]/g,'').trim();
            dropdown.querySelectorAll('.radix-select-item').forEach(i => { i.removeAttribute('data-selected'); const ind = i.querySelector('.radix-select-item-indicator'); if(ind){ind.classList.add('hidden');ind.style.display='none';} i.style.background=''; i.style.color=''; i.style.fontWeight=''; });
            this.setAttribute('data-selected','true'); const ind = this.querySelector('.radix-select-item-indicator'); if(ind){ind.classList.remove('hidden');ind.style.display='block';} this.style.background='#eef2ff'; this.style.color='#4f46e5'; this.style.fontWeight='500';
            dropdown.classList.add('hidden');
            if(onChange) onChange(this.dataset.value);
        });
    });
}
setupRadixSelect('reportDateRangeTrigger','reportDateRangeDropdown','reportDateRangeText', v => reportState.dateRange=v);
setupRadixSelect('reportFacilityTrigger','reportFacilityDropdown','reportFacilityText', v => reportState.facility=v);
document.addEventListener('click', function(e) { if(!e.target.closest('.radix-select')) document.querySelectorAll('.radix-select-content').forEach(d=>d.classList.add('hidden')); });

// Preview & Download buttons
document.getElementById('previewReportBtn')?.addEventListener('click', function() {
    document.getElementById('reportPreviewContent').innerHTML = generateReportHTML();
    closeNewReportModal();
    document.getElementById('reportPreviewModal').classList.remove('hidden');
});
document.getElementById('downloadReportBtn')?.addEventListener('click', function() {
    document.getElementById('reportPreviewContent').innerHTML = generateReportHTML();
    closeNewReportModal();
    document.getElementById('reportPreviewModal').classList.remove('hidden');
    setTimeout(triggerDownload, 300);
});

// Preview modal controls
document.getElementById('closePreviewBtn')?.addEventListener('click', () => document.getElementById('reportPreviewModal').classList.add('hidden'));
document.getElementById('backToSettingsBtn')?.addEventListener('click', () => {
    document.getElementById('reportPreviewModal').classList.add('hidden');
    document.getElementById('reportModalOverlay').classList.remove('hidden');
});
document.getElementById('downloadFinalBtn')?.addEventListener('click', triggerDownload);
document.getElementById('reportPreviewModal')?.addEventListener('click', function(e) { if(e.target===this) this.classList.add('hidden'); });

// ==================== DELETE SURVEY MODAL ====================
document.getElementById('deleteSurveyBtn')?.addEventListener('click', function() {
    document.getElementById('deleteSurveyModal').classList.remove('hidden');
});

document.getElementById('cancelDeleteBtn')?.addEventListener('click', function() {
    document.getElementById('deleteSurveyModal').classList.add('hidden');
});

document.getElementById('confirmDeleteBtn')?.addEventListener('click', function() {
    document.getElementById('deleteSurveyModal').classList.add('hidden');
    showToast('Survey deleted successfully!');
    // Redirect after deletion
    setTimeout(() => {
        window.location.href = 'feedback.html';
    }, 1000);
});

// Close delete modal on backdrop click
document.getElementById('deleteSurveyModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});

// ==================== EDIT SURVEY ====================
document.getElementById('editSurveyBtn')?.addEventListener('click', function() {
    window.location.href = 'edit-survey.html';
});

// ==================== DUPLICATE SURVEY ====================
document.getElementById('duplicateSurveyBtn')?.addEventListener('click', function() {
    showToast('Survey duplicated successfully! A copy has been created.');
    // In production, this would call an API to duplicate the survey
});
console.log('✅ Report modal initialized');
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
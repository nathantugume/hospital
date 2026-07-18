<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Surgery Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-background { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .border-gray-200, body.dark .border-gray-300 { border-color: #333333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-muted, body.dark .bg-gray-100, body.dark .bg-gray-50 { background-color: #262626 !important; }
        body.dark input, body.dark select, body.dark textarea { background-color: #262626; border-color: #404040; color: #e5e5e5; }
        body.dark .bg-teal-50 { background-color: #042f2e !important; }
        body.dark .bg-teal-100 { background-color: #134e4a !important; }
        body.dark .bg-amber-50 { background-color: #451a03 !important; }
        body.dark .bg-red-50 { background-color: #450a0a !important; }
        body.dark .bg-green-50 { background-color: #052e16 !important; }
        body.dark .bg-purple-50 { background-color: #3b0764 !important; }
        body.dark .bg-blue-50 { background-color: #172554 !important; }
        
        [data-state="active"] { background-color: white !important; color: #1f2937 !important; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        body.dark [data-state="active"] { background-color: #131212 !important; color: #e5e5e5 !important; }
        
        .tab-panel { display: none; animation: fadeIn 0.2s ease-out; }
        .tab-panel.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }
        
        .status-badge {
            display: inline-flex; align-items: center; border-radius: 0.375rem;
            padding: 0.25rem 0.75rem; font-size: 0.7rem; font-weight: 600;
            letter-spacing: 0.025em; text-transform: uppercase;
        }
        .status-ongoing { background: #ccfbf1; color: #0f766e; }
        .status-scheduled { background: #fef3c7; color: #92400e; }
        .status-completed { background: #dcfce7; color: #166534; }
        .status-emergency { background: #fee2e2; color: #991b1b; }
        .status-preop { background: #f3e8ff; color: #6b21a8; }
        .status-cancelled { background: #f3f4f6; color: #6b7280; }
        
        body.dark .status-ongoing { background: #134e4a; color: #99f6e4; }
        body.dark .status-scheduled { background: #78350f; color: #fde68a; }
        body.dark .status-completed { background: #14532d; color: #bbf7d0; }
        body.dark .status-emergency { background: #7f1d1d; color: #fecaca; }
        body.dark .status-preop { background: #4c1d95; color: #e9d5ff; }
        body.dark .status-cancelled { background: #374151; color: #d1d5db; }
        
        .pulse-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; animation: pulse 2s infinite; }
        @keyframes pulse { 0%, 100% { opacity: 1; } 50% { opacity: 0.4; } }
        
        .info-row {
            display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
        }
        body.dark .info-row { border-bottom-color: #262626; }
        .info-row:last-child { border-bottom: none; }
        .info-icon {
            width: 36px; height: 36px; border-radius: 0.5rem; display: flex;
            align-items: center; justify-content: center; flex-shrink: 0;
        }
        
        .checklist-item {
            display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem;
            border-radius: 0.5rem; transition: all 0.15s;
        }
        .checklist-item:hover { background-color: #f9fafb; }
        body.dark .checklist-item:hover { background-color: #1a1a1a; }
        .checklist-dot {
            width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0;
            border: 2px solid #d1d5db;
        }
        .checklist-dot.done { background: #0d9488; border-color: #0d9488; }
        .checklist-dot.current { background: #f59e0b; border-color: #f59e0b; animation: pulse .5s infinite; }
        .checklist-dot.pending { background: transparent; border-color: #d1d5db; }
        
        .timeline-step {
            position: relative; padding-left: 40px; padding-bottom: 2rem;
        }
        .timeline-step:last-child { padding-bottom: 0; }
        .timeline-step::before {
            content: ''; position: absolute; left: 8px; top: 4px;
            width: 16px; height: 16px; border-radius: 50%; border: 3px solid #0d9488;
            background: white; z-index: 2;
        }
        body.dark .timeline-step::before { background: #131212; border-color: #14b8a6; }
        .timeline-step.done::before { background: #0d9488; border-color: #0d9488; }
        .timeline-step.current::before { background: #f59e0b; border-color: #f59e0b; animation: pulse .8s infinite; }
        .timeline-step.pending::before { background: white; border-color: #d1d5db; }
        body.dark .timeline-step.pending::before { background: #131212; }
        .timeline-step::after {
            content: ''; position: absolute; left: 15px; top: 20px;
            width: 2px; height: calc(100% - 4px); background: #e5e7eb;
        }
        body.dark .timeline-step::after { background: #404040; }
        .timeline-step:last-child::after { display: none; }
        
        .toast-message {
            position: fixed; bottom: 20px; right: 20px; background: #0d9488; color: white;
            padding: 12px 20px; border-radius: 0.75rem; z-index: 11000; font-size: 0.875rem;
            animation: slideIn 0.3s ease-out; box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }
        
        .text-red-600 { color: #dc2626; }
<style>
    @media print {
        body * { visibility: hidden; }
        #reportPreviewContent, #reportPreviewContent * { visibility: visible; }
        #reportPreviewContent { position: absolute; left: 0; top: 0; width: 210mm; }
    }

    .report-shell {
        width: 210mm;
        min-height: 297mm;
        margin: 0 auto;
        background: #ffffff;
        font-family: 'Inter', sans-serif;
        color: #1e293b;
        position: relative;
        border: 1px solid #e2e8f0;
    }

    /* Header Section */
    .report-header {
        background: #4f46e5;
        color: white;
        padding: 30px 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .report-header h1 {
        font-size: 28px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: -0.5px;
        margin: 0;
    }

    .report-header .meta {
        font-size: 12px;
        font-weight: 600;
        opacity: 0.8;
        letter-spacing: 1px;
    }

    /* Top KPI Row */
    .kpi-row {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr;
        gap: 0;
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }

    .kpi-card {
        padding: 30px;
        border-right: 1px solid #e2e8f0;
        text-align: center;
    }

    .kpi-value {
        font-size: 48px;
        font-weight: 900;
        color: #4f46e5;
        line-height: 1;
    }

    .kpi-label {
        font-size: 12px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        margin-top: 8px;
        letter-spacing: 0.5px;
    }

    .trend-up { color: #10b981; font-size: 14px; font-weight: 600; }
    .trend-down { color: #ef4444; font-size: 14px; font-weight: 600; }

    /* Main Content Grid */
    .report-body {
        padding: 40px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
    }

    .section-title {
        font-size: 16px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title::after {
        content: '';
        flex: 1;
        height: 2px;
        background: #f1f5f9;
    }

    /* Ranking Table */
    .ranking-list {
        list-style: none;
        padding: 0;
    }

    .ranking-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }

    .ranking-item.highlight {
        background: #eef2ff;
        padding: 10px;
        border-radius: 6px;
        font-weight: 700;
        color: #4f46e5;
    }

    /* Satisfaction Distribution */
    .dist-row {
        margin-bottom: 15px;
    }

    .dist-label {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .progress-bg {
        height: 10px;
        background: #f1f5f9;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 10px;
    }

    /* Experience Grid */
    .exp-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .exp-card {
        background: #f8fafc;
        padding: 15px;
        border-radius: 10px;
        border: 1px solid #f1f5f9;
    }

    .exp-val {
        font-size: 20px;
        font-weight: 800;
        color: #4f46e5;
    }

    .exp-txt {
        font-size: 11px;
        color: #64748b;
        line-height: 1.4;
        margin-top: 4px;
    }

    /* Spotlight Section */
    .spotlight {
        grid-column: span 2;
        background: #4f46e5;
        color: white;
        border-radius: 16px;
        padding: 30px;
        display: flex;
        gap: 30px;
        align-items: center;
    }

    .spotlight-icon {
        font-size: 40px;
        background: rgba(255,255,255,0.2);
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .quote-box {
        flex: 1;
    }

    .quote-text {
        font-size: 18px;
        font-weight: 500;
        font-style: italic;
        line-height: 1.6;
    }

    .quote-author {
        font-size: 12px;
        margin-top: 10px;
        opacity: 0.8;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* Footer */
    .report-footer {
        padding: 40px;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .contact-info {
        font-size: 11px;
        color: #94a3b8;
        max-width: 400px;
    }

    .branding {
        text-align: right;
    }

    .badge-un {
        border: 1px solid #e2e8f0;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
        color: #64748b;
    }

    /* Status Modal Overlay Styles - Add to existing style section */
#statusModal {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.85);
    backdrop-filter: blur(4px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
}

#statusModal[style*="display: flex"] {
    display: flex !important;
}

/* Ensure modal container has proper z-index and animation */
#statusModal .relative.z-10 {
    z-index: 10000;
    animation: modalSlideUpFade 0.25s ease-out;
}

@keyframes modalSlideUpFade {
    from {
        opacity: 0;
        transform: translateY(30px) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* Style the backdrop blur div */
#statusModalBackdrop {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.85);
    backdrop-filter: blur(4px);
    z-index: 9998;
}

/* Ensure modal content is above backdrop */
#statusModal .bg-white.rounded-xl {
    position: relative;
    z-index: 10000;
    box-shadow: 0 25px 50px -12px rgb(0 0 0 / 87%);
}

/* Dark mode support for modal */
body.dark #statusModal .bg-white.rounded-xl {
    background-color: #1e1e1e;
    border: 1px solid #333;
}

body.dark #statusModal .border-b,
body.dark #statusModal .border-t {
    border-color: #333;
}

body.dark #statusModal .text-gray-500,
body.dark #statusModal .text-gray-400,
body.dark #statusModal .text-gray-600 {
    color: #9ca3af;
}

body.dark #statusModal .border-gray-200 {
    border-color: #404040;
}

body.dark #statusModal .bg-gray-100 {
    background-color: #2a2a2a;
}
</style>
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

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
            <!-- Header -->
            <div class="flex items-center gap-4">
                <a class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background hover:bg-gray-100 size-10" href="ot-schedule.html">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-4 w-4"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                </a>
                <div class="flex-1">
                    <h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-1">Surgery Details</h1>
                    <p class="text-gray-500 text-sm">Comprehensive view of surgical procedure information</p>
                </div>
                <div class="flex gap-2">
<button id="editSurgeryBtn" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-background hover:bg-gray-100 h-10 px-4 py-2 text-sm font-medium">
    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path></svg>
    Edit
</button>
                    <button id="updateStatusBtn" class="inline-flex items-center gap-2 rounded-lg bg-primary text-white hover:bg-teal-700 h-10 px-4 py-2 text-sm font-medium shadow-sm">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                        Update Status
                    </button>
                </div>
            </div>

            <!-- Two Column Layout -->
            <div class="md:grid max-md:space-y-6 gap-6 md:grid-cols-3">
                <!-- Left Column - Surgery Info Card -->
                <div class="rounded-xl border bg-white shadow-sm md:col-span-1 h-fit">
                    <div class="p-5 border-b flex items-center justify-between">
                        <div>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Surgery ID</span>
                            <h2 class="text-xl font-bold text-teal-700" id="detailId">SURG001</h2>
                        </div>
                        <span class="status-badge status-ongoing" id="detailStatus">In Progress</span>
                    </div>
                    <div class="p-5">
                        <div class="info-row">
                            <div class="info-icon bg-teal-50"><svg class="h-4 w-4 text-teal-600" stroke-width="2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg></div>
                            <div><p class="text-xs text-gray-400 uppercase tracking-wider">Patient</p><p class="font-semibold" id="detailPatient">Mwesigwa Robert</p></div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon bg-purple-50"><svg class="h-4 w-4 text-purple-600" stroke-width="2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg></div>
                            <div><p class="text-xs text-gray-400 uppercase tracking-wider">Procedure</p><p class="font-semibold" id="detailProcedure">CABG - Triple Bypass</p></div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon bg-blue-50"><svg class="h-4 w-4 text-blue-600" stroke-width="2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></div>
                            <div><p class="text-xs text-gray-400 uppercase tracking-wider">Date & Time</p><p class="font-semibold" id="detailDateTime">April 13, 2026 • 08:30 - 13:30</p></div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon bg-amber-50"><svg class="h-4 w-4 text-amber-600" stroke-width="2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/></svg></div>
                            <div><p class="text-xs text-gray-400 uppercase tracking-wider">OT Room</p><p class="font-semibold" id="detailRoom">OT-1 (Cardiac Suite)</p></div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon bg-red-50"><svg class="h-4 w-4 text-red-600" stroke-width="2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
                            <div><p class="text-xs text-gray-400 uppercase tracking-wider">Priority</p><p class="font-semibold" id="detailPriority">High</p></div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon bg-green-50"><svg class="h-4 w-4 text-green-600" stroke-width="2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg></div>
                            <div><p class="text-xs text-gray-400 uppercase tracking-wider">Lead Surgeon</p><p class="font-semibold" id="detailSurgeon">Dr. Mwangi Peter</p></div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Tabs -->
                <div class="rounded-xl border bg-white shadow-sm md:col-span-2">
                    <div class="p-4 border-b">
                        <div role="tablist" class="inline-flex flex-wrap items-center rounded-lg bg-gray-100 p-1">
                            <button type="button" role="tab" data-tab="overview" class="tab-btn inline-flex items-center justify-center rounded-md px-3 py-1.5 text-sm font-medium transition-all" data-state="active">Overview</button>
                            <button type="button" role="tab" data-tab="team" class="tab-btn inline-flex items-center justify-center rounded-md px-3 py-1.5 text-sm font-medium transition-all" data-state="inactive">Surgical Team</button>
                            <button type="button" role="tab" data-tab="checklist" class="tab-btn inline-flex items-center justify-center rounded-md px-3 py-1.5 text-sm font-medium transition-all" data-state="inactive">Checklist</button>
                            <button type="button" role="tab" data-tab="timeline" class="tab-btn inline-flex items-center justify-center rounded-md px-3 py-1.5 text-sm font-medium transition-all" data-state="inactive">Timeline</button>
                        </div>
                    </div>

                    <div class="p-5">
                        <!-- Overview Panel -->
                        <div id="tab-overview" class="tab-panel active space-y-6">
                            <div>
                                <h3 class="text-lg font-semibold mb-3">Procedure Notes</h3>
                                <div class="rounded-lg border p-4 bg-gray-50">
                                    <p class="text-sm text-gray-600" id="detailNotes">Patient stable, currently on cardiopulmonary bypass. All three grafts being placed. Vitals within normal range. Estimated completion time on schedule.</p>
                                </div>
                            </div>
                            <div class="grid md:grid-cols-3 gap-4">
                                <div class="rounded-lg border p-4 text-center">
                                    <div class="text-xs uppercase tracking-wider text-gray-400 mb-1">Duration</div>
                                    <div class="text-2xl font-bold text-teal-700">5 hrs</div>
                                    <div class="text-xs text-gray-400">Estimated</div>
                                </div>
                                <div class="rounded-lg border p-4 text-center">
                                    <div class="text-xs uppercase tracking-wider text-gray-400 mb-1">Blood Loss</div>
                                    <div class="text-2xl font-bold text-amber-600">350ml</div>
                                    <div class="text-xs text-gray-400">Current</div>
                                </div>
                                <div class="rounded-lg border p-4 text-center">
                                    <div class="text-xs uppercase tracking-wider text-gray-400 mb-1">Time Elapsed</div>
                                    <div class="text-2xl font-bold text-blue-600">3.5 hrs</div>
                                    <div class="text-xs text-gray-400">Since 08:30</div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold mb-3">Equipment Used</h3>
                                <div class="flex flex-wrap gap-2">
                                    <span class="rounded-full border px-3 py-1 text-xs font-medium">Heart-Lung Bypass Machine</span>
                                    <span class="rounded-full border px-3 py-1 text-xs font-medium">Anesthesia Machine #2</span>
                                    <span class="rounded-full border px-3 py-1 text-xs font-medium">Surgical Microscope</span>
                                    <span class="rounded-full border px-3 py-1 text-xs font-medium">Defibrillator</span>
                                    <span class="rounded-full border px-3 py-1 text-xs font-medium">Infusion Pumps (x3)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Team Panel -->
                        <div id="tab-team" class="tab-panel space-y-4">
                            <h3 class="text-lg font-semibold">Surgical Team Assignments</h3>
                            <div class="grid md:grid-cols-2 gap-3">
                                <div class="flex items-center gap-3 p-4 rounded-xl border hover:shadow-sm transition">
                                    <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full"><img class="h-full w-full object-cover" src="user.png" alt="User profile photo"></span>
                                    <div>
                                        <p class="font-semibold" id="detailLeadSurgeon">Dr. Mwangi Peter</p>
                                        <p class="text-xs text-gray-500">Lead Surgeon</p>
                                        <span class="inline-flex items-center gap-1 text-xs text-teal-600 mt-1"><span class="animate-ping rounded-full bg-primary" style="width:6px;height:6px;"></span> In Surgery</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 p-4 rounded-xl border hover:shadow-sm transition">
                                    <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full"><img class="h-full w-full object-cover" src="user.png" alt="User profile photo"></span>
                                    <div>
                                        <p class="font-semibold" id="detailAnesthesiologist">Dr. Lumu</p>
                                        <p class="text-xs text-gray-500">Anesthesiologist</p>
                                        <span class="inline-flex items-center gap-1 text-xs text-teal-600 mt-1"><span class="animate-ping rounded-full bg-primary" style="width:6px;height:6px;"></span> In Surgery</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 p-4 rounded-xl border hover:shadow-sm transition">
                                    <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full"><img class="h-full w-full object-cover" src="user.png" alt="User profile photo"></span>
                                    <div>
                                        <p class="font-semibold">N. Peters</p>
                                        <p class="text-xs text-gray-500">Scrub Nurse</p>
                                        <span class="inline-flex items-center gap-1 text-xs text-teal-600 mt-1"><span class="animate-ping rounded-full bg-primary" style="width:6px;height:6px;"></span> In Surgery</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 p-4 rounded-xl border hover:shadow-sm transition">
                                    <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full"><img class="h-full w-full object-cover" src="user.png" alt="User profile photo"></span>
                                    <div>
                                        <p class="font-semibold">R. Thompson</p>
                                        <p class="text-xs text-gray-500">Circulating Nurse</p>
                                        <span class="inline-flex items-center gap-1 text-xs text-teal-600 mt-1"><span class="animate-ping rounded-full bg-primary" style="width:6px;height:6px;"></span> In Surgery</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 p-4 rounded-xl border hover:shadow-sm transition">
                                    <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full"><img class="h-full w-full object-cover" src="user.png" alt="User profile photo"></span>
                                    <div>
                                        <p class="font-semibold">Dr. K. Matthews</p>
                                        <p class="text-xs text-gray-500">Perfusionist</p>
                                        <span class="inline-flex items-center gap-1 text-xs text-teal-600 mt-1"><span class="animate-ping rounded-full bg-primary" style="width:6px;height:6px;"></span> In Surgery</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 p-4 rounded-xl border border-dashed hover:shadow-sm transition opacity-60">
                                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-gray-100"><svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="M12 5v14"/></svg></span>
                                    <div><p class="font-semibold text-gray-400">Add Team Member</p><p class="text-xs text-gray-400">Click to assign</p></div>
                                </div>
                            </div>
                        </div>

                        <!-- Checklist Panel -->
                        <div id="tab-checklist" class="tab-panel space-y-2">
                            <h3 class="text-lg font-semibold mb-1">Surgical Safety Checklist</h3>
                            <p class="text-sm text-gray-500 mb-4">WHO Surgical Safety Checklist — adapted</p>
                            
                            <div class="space-y-1">
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 px-3">Before Induction of Anesthesia</p>
                                <div class="checklist-item"><span class="checklist-dot done"></span><span class="text-sm">Patient identity confirmed</span></div>
                                <div class="checklist-item"><span class="checklist-dot done"></span><span class="text-sm">Surgical site marked</span></div>
                                <div class="checklist-item"><span class="checklist-dot done"></span><span class="text-sm">Anesthesia safety check complete</span></div>
                                <div class="checklist-item"><span class="checklist-dot done"></span><span class="text-sm">Allergies checked</span></div>
                                <div class="checklist-item"><span class="checklist-dot done"></span><span class="text-sm">Airway assessment done</span></div>
                            </div>
                            <div class="space-y-1 mt-4">
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 px-3">Before Skin Incision</p>
                                <div class="checklist-item"><span class="checklist-dot done"></span><span class="text-sm">Team introductions complete</span></div>
                                <div class="checklist-item"><span class="checklist-dot done"></span><span class="text-sm">Procedure confirmed by team</span></div>
                                <div class="checklist-item"><span class="checklist-dot done"></span><span class="text-sm">Antibiotic prophylaxis given</span></div>
                                <div class="checklist-item"><span class="checklist-dot current animate-ping"></span><span class="text-sm">Imaging displayed (in progress)</span></div>
                            </div>
                            <div class="space-y-1 mt-4">
                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 px-3">Before Patient Leaves OT</p>
                                <div class="checklist-item"><span class="checklist-dot pending"></span><span class="text-sm">Instrument & sponge count</span></div>
                                <div class="checklist-item"><span class="checklist-dot pending"></span><span class="text-sm">Specimens labeled</span></div>
                                <div class="checklist-item"><span class="checklist-dot pending"></span><span class="text-sm">Post-op instructions documented</span></div>
                            </div>
                        </div>

                        <!-- Timeline Panel -->
                        <div id="tab-timeline" class="tab-panel">
                            <h3 class="text-lg font-semibold mb-4">Procedure Timeline</h3>
                            <div class="space-y-0">
                                <div class="timeline-step done">
                                    <p class="font-semibold text-sm">Patient Check-in</p>
                                    <p class="text-xs text-gray-500">07:45 AM — Patient arrived and registered</p>
                                </div>
                                <div class="timeline-step done">
                                    <p class="font-semibold text-sm">Pre-Op Preparation</p>
                                    <p class="text-xs text-gray-500">08:00 AM — Vitals checked, IV line placed, consent verified</p>
                                </div>
                                <div class="timeline-step done">
                                    <p class="font-semibold text-sm">Anesthesia Induction</p>
                                    <p class="text-xs text-gray-500">08:20 AM — General anesthesia administered by Dr. Lumu</p>
                                </div>
                                <div class="timeline-step done">
                                    <p class="font-semibold text-sm">Surgery Start — Incision</p>
                                    <p class="text-xs text-gray-500">08:30 AM — Sternotomy performed, bypass initiated</p>
                                </div>
                                <div class="timeline-step current">
                                    <p class="font-semibold text-sm">Graft Placement (In Progress)</p>
                                    <p class="text-xs text-gray-500">09:45 AM — Three grafts being placed. Patient stable on bypass</p>
                                </div>
                                <div class="timeline-step pending">
                                    <p class="font-semibold text-sm">Closure</p>
                                    <p class="text-xs text-gray-500">Estimated: 12:30 PM — Chest closure and wound dressing</p>
                                </div>
                                <div class="timeline-step pending">
                                    <p class="font-semibold text-sm">Transfer to ICU</p>
                                    <p class="text-xs text-gray-500">Estimated: 1:30 PM — Post-op recovery monitoring</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Update Status Modal - Ensure backdrop is inside the modal overlay -->
<div id="statusModal" class="fixed inset-0 z-50 hidden items-center justify-center" style="display: none; background-color: rgba(0,0,0,0.85); backdrop-filter: blur(4px);">
    <div class="relative z-10 bg-background rounded-xl w-full max-w-md mx-4 shadow-2xl animate-slideUp">
        <div class="p-5 border-b flex justify-between items-center">
            <h2 class="text-lg font-semibold">Update Surgery Status</h2>
            <button id="closeStatusModal" class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100">&times;</button>
        </div>
        <div class="p-5 space-y-4">
            <p class="text-sm text-gray-500">Current status: <strong id="currentStatusLabel">In Progress</strong></p>
            <div class="grid grid-cols-2 gap-3">
                <button data-status="Scheduled" class="status-option p-4 rounded-xl border-2 border-gray-200 hover:border-amber-400 text-center transition">
                    <div class="text-2xl mb-1">📋</div>
                    <div class="font-semibold text-sm">Scheduled</div>
                </button>
                <button data-status="Pre-Op" class="status-option p-4 rounded-xl border-2 border-gray-200 hover:border-purple-400 text-center transition">
                    <div class="text-2xl mb-1">🏥</div>
                    <div class="font-semibold text-sm">Pre-Op</div>
                </button>
                <button data-status="In Progress" class="status-option p-4 rounded-xl border-2 border-teal-400 bg-teal-50 text-center transition">
                    <div class="text-2xl mb-1">🔪</div>
                    <div class="font-semibold text-sm">In Progress</div>
                </button>
                <button data-status="Completed" class="status-option p-4 rounded-xl border-2 border-gray-200 hover:border-green-400 text-center transition">
                    <div class="text-2xl mb-1">✅</div>
                    <div class="font-semibold text-sm">Completed</div>
                </button>
            </div>
            <div class="space-y-2">
                <label class="text-sm font-medium">Add Note</label>
                <textarea id="statusNote" rows="2" class="w-full rounded-lg border px-3 py-2 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none" placeholder="Optional note about this status change..."></textarea>
            </div>
        </div>
        <div class="p-4 border-t flex justify-end gap-2">
            <button id="cancelStatusBtn" class="border px-4 py-2 rounded-lg text-sm hover:bg-gray-100 font-medium">Cancel</button>
            <button id="confirmStatusBtn" class="bg-primary text-white px-5 py-2 rounded-lg text-sm hover:bg-teal-700 font-medium">Confirm</button>
        </div>
    </div>
</div>

<style>
    @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .animate-slideUp { animation: slideUp 0.2s ease-out; }
</style>


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
// ==================== SURGERY DATA ====================
// In a real app, this would be fetched from localStorage or URL params
const surgeryData = {
    id: "SURG001",
    patient: "Mwesigwa Robert",
    procedure: "CABG - Triple Bypass",
    otRoom: "OT-1",
    roomName: "OT-1 (Cardiac Suite)",
    surgeon: "Dr. Mwangi Peter",
    anesthesiologist: "Dr. Lumu",
    date: "2026-04-13",
    startTime: "08:30",
    endTime: "13:30",
    status: "In Progress",
    priority: "High",
    notes: "Patient stable, currently on cardiopulmonary bypass. All three grafts being placed. Vitals within normal range. Estimated completion time on schedule."
};

function getStatusBadgeClass(status) {
    if (status === "Completed") return "status-completed";
    if (status === "In Progress") return "status-ongoing";
    if (status === "Pre-Op") return "status-preop";
    if (status === "Emergency") return "status-emergency";
    if (status === "Cancelled") return "status-cancelled";
    return "status-scheduled";
}

function showToast(msg, isError = false) {
    const existing = document.querySelector('.toast-message'); if (existing) existing.remove();
    const toast = document.createElement('div'); toast.className = `toast-message ${isError ? 'error' : ''}`;
    toast.innerText = msg; document.body.appendChild(toast); setTimeout(() => toast.remove(), 3000);
}

// ==================== POPULATE DETAILS ====================
function populateDetails() {
    document.getElementById('detailId').innerText = surgeryData.id;
    document.getElementById('detailPatient').innerText = surgeryData.patient;
    document.getElementById('detailProcedure').innerText = surgeryData.procedure;
    document.getElementById('detailRoom').innerText = surgeryData.roomName;
    document.getElementById('detailSurgeon').innerText = surgeryData.surgeon;
    document.getElementById('detailPriority').innerText = surgeryData.priority;
    document.getElementById('detailDateTime').innerText = `${new Date(surgeryData.date + 'T00:00').toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' })} • ${surgeryData.startTime} - ${surgeryData.endTime}`;
    document.getElementById('detailNotes').innerText = surgeryData.notes;
    document.getElementById('detailLeadSurgeon').innerText = surgeryData.surgeon;
    document.getElementById('detailAnesthesiologist').innerText = surgeryData.anesthesiologist;
    
    const statusBadge = document.getElementById('detailStatus');
    statusBadge.innerText = surgeryData.status;
    statusBadge.className = `status-badge ${getStatusBadgeClass(surgeryData.status)}`;
    
    document.getElementById('currentStatusLabel').innerText = surgeryData.status;
}

// ==================== TAB SWITCHING ====================
const tabBtns = document.querySelectorAll('.tab-btn');
const tabPanels = {
    overview: document.getElementById('tab-overview'),
    team: document.getElementById('tab-team'),
    checklist: document.getElementById('tab-checklist'),
    timeline: document.getElementById('tab-timeline')
};

function switchTab(tabId) {
    Object.values(tabPanels).forEach(p => { p.classList.remove('active'); });
    if (tabPanels[tabId]) tabPanels[tabId].classList.add('active');
    
    tabBtns.forEach(btn => {
        const isActive = btn.dataset.tab === tabId;
        btn.setAttribute('data-state', isActive ? 'active' : 'inactive');
        if (isActive) { btn.classList.add('bg-white', 'text-gray-900', 'shadow-sm'); btn.classList.remove('text-gray-500'); }
        else { btn.classList.remove('bg-white', 'text-gray-900', 'shadow-sm'); btn.classList.add('text-gray-500'); }
    });
}

tabBtns.forEach(btn => btn.addEventListener('click', () => switchTab(btn.dataset.tab)));

// ==================== STATUS MODAL ====================
let selectedStatus = surgeryData.status;

// ==================== STATUS MODAL WITH OVERLAY ====================
function openStatusModal() {
    selectedStatus = surgeryData.status;
    const modal = document.getElementById('statusModal');
    const backdrop = document.getElementById('statusModalBackdrop');
    
    // Ensure backdrop and modal are properly styled
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // Add backdrop if not present or ensure it's visible
    if (backdrop) {
        backdrop.style.display = 'block';
    }
    
    highlightSelectedStatus();
}

function closeStatusModal() {
    const modal = document.getElementById('statusModal');
    const backdrop = document.getElementById('statusModalBackdrop');
    
    modal.style.display = 'none';
    if (backdrop) {
        backdrop.style.display = 'none';
    }
    document.body.style.overflow = '';
}

function highlightSelectedStatus() {
    document.querySelectorAll('.status-option').forEach(btn => {
        btn.classList.remove('border-teal-400', 'bg-teal-50', 'border-2');
        btn.classList.add('border-2', 'border-gray-200');
        if (btn.dataset.status === selectedStatus) {
            btn.classList.add('border-teal-400', 'bg-teal-50');
            btn.classList.remove('border-gray-200');
        }
    });
}

document.getElementById('updateStatusBtn').addEventListener('click', openStatusModal);
document.getElementById('editSurgeryBtn').addEventListener('click', () => { 
    window.location.href = `edit-surgery.html?id=${surgeryData.id}`; 
});
document.getElementById('closeStatusModal').addEventListener('click', closeStatusModal);
document.getElementById('cancelStatusBtn').addEventListener('click', closeStatusModal);
document.getElementById('statusModalBackdrop').addEventListener('click', closeStatusModal);

document.querySelectorAll('.status-option').forEach(btn => {
    btn.addEventListener('click', () => {
        selectedStatus = btn.dataset.status;
        highlightSelectedStatus();
    });
});

document.getElementById('confirmStatusBtn').addEventListener('click', () => {
    surgeryData.status = selectedStatus;
    populateDetails();
    const note = document.getElementById('statusNote').value.trim();
    showToast(`Status updated to "${selectedStatus}"${note ? ' with note' : ''}.`);
    closeStatusModal();
});



// ==================== ADD TEAM MEMBER MODAL FOR SURGERY DETAILS ====================

// Modal elements
let addTeamMemberModal = null;
let currentTeamMemberModal = null;

function createAddTeamMemberModal() {
    const modal = document.createElement('div');
    modal.id = 'addTeamMemberModal';
    modal.className = 'modal-overlay hidden';
    modal.innerHTML = `
        <div class="modal-container" style="max-width: 500px;">
            <div class="modal-header">
                <h2 class="modal-title">Add Team Member</h2>
                <button class="modal-close close-add-member-modal">&times;</button>
            </div>
            <div class="modal-body">
                <input type="text" id="teamMemberSearchInput" class="search-input" placeholder="Search by name or role...">
                <div id="teamMemberSelectList" class="space-y-2">
                    <div class="modal-item" data-name="Dr. Nakato Sarah" data-role="Cardiothoracic Surgeon" data-initials="SJ">
                        <div><p class="font-semibold">Dr. Nakato Sarah</p><p class="text-xs text-gray-500">Cardiothoracic Surgeon</p></div>
                        <button class="text-indigo-600 text-sm select-team-member">Select</button>
                    </div>
                    <div class="modal-item" data-name="Dr. Mukasa David" data-role="Orthopedic Surgeon" data-initials="DK">
                        <div><p class="font-semibold">Dr. Mukasa David</p><p class="text-xs text-gray-500">Orthopedic Surgeon</p></div>
                        <button class="text-indigo-600 text-sm select-team-member">Select</button>
                    </div>
                    <div class="modal-item" data-name="Dr. Maria Gonzales" data-role="Pediatric Surgeon" data-initials="MG">
                        <div><p class="font-semibold">Dr. Maria Gonzales</p><p class="text-xs text-gray-500">Pediatric Surgeon</p></div>
                        <button class="text-indigo-600 text-sm select-team-member">Select</button>
                    </div>
                    <div class="modal-item" data-name="S. Williams" data-role="Scrub Nurse" data-initials="SW">
                        <div><p class="font-semibold">S. Williams</p><p class="text-xs text-gray-500">Scrub Nurse</p></div>
                        <button class="text-indigo-600 text-sm select-team-member">Select</button>
                    </div>
                    <div class="modal-item" data-name="J. Martinez" data-role="Circulating Nurse" data-initials="JM">
                        <div><p class="font-semibold">J. Martinez</p><p class="text-xs text-gray-500">Circulating Nurse</p></div>
                        <button class="text-indigo-600 text-sm select-team-member">Select</button>
                    </div>
                    <div class="modal-item" data-name="Dr. Tumusiime Thomas" data-role="Neurosurgeon" data-initials="TL">
                        <div><p class="font-semibold">Dr. Tumusiime Thomas</p><p class="text-xs text-gray-500">Neurosurgeon</p></div>
                        <button class="text-indigo-600 text-sm select-team-member">Select</button>
                    </div>
                    <div class="modal-item" data-name="K. Anderson" data-role="Anesthesiologist" data-initials="KA">
                        <div><p class="font-semibold">K. Anderson</p><p class="text-xs text-gray-500">Anesthesiologist</p></div>
                        <button class="text-indigo-600 text-sm select-team-member">Select</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="border px-4 py-2 rounded-md text-sm hover:bg-gray-100 close-add-member-modal">Cancel</button>
            </div>
        </div>
    `;
    document.body.appendChild(modal);
    return modal;
}

function openAddTeamMemberModal() {
    if (!addTeamMemberModal) {
        addTeamMemberModal = createAddTeamMemberModal();
    }
    addTeamMemberModal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Re-attach event listeners
    attachModalEventListeners();
}

function closeAddTeamMemberModal() {
    if (addTeamMemberModal) {
        addTeamMemberModal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

function attachModalEventListeners() {
    // Close buttons
    addTeamMemberModal.querySelectorAll('.close-add-member-modal').forEach(btn => {
        btn.removeEventListener('click', closeAddTeamMemberModal);
        btn.addEventListener('click', closeAddTeamMemberModal);
    });
    
    // Search functionality
    const searchInput = addTeamMemberModal.querySelector('#teamMemberSearchInput');
    if (searchInput) {
        searchInput.removeEventListener('input', handleTeamMemberSearch);
        searchInput.addEventListener('input', handleTeamMemberSearch);
    }
    
    // Select buttons
    addTeamMemberModal.querySelectorAll('.select-team-member').forEach(btn => {
        btn.removeEventListener('click', handleTeamMemberSelect);
        btn.addEventListener('click', handleTeamMemberSelect);
    });
    
    // Close on backdrop click
    addTeamMemberModal.removeEventListener('click', handleBackdropClick);
    addTeamMemberModal.addEventListener('click', handleBackdropClick);
}

function handleTeamMemberSearch(e) {
    const searchTerm = e.target.value.toLowerCase();
    const items = addTeamMemberModal.querySelectorAll('.modal-item');
    items.forEach(item => {
        const name = item.dataset.name.toLowerCase();
        const role = item.dataset.role.toLowerCase();
        if (name.includes(searchTerm) || role.includes(searchTerm)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}

function handleTeamMemberSelect(e) {
    const modalItem = e.target.closest('.modal-item');
    const name = modalItem.dataset.name;
    const role = modalItem.dataset.role;
    const initials = modalItem.dataset.initials;
    
    addTeamMemberToSurgeryDetails(name, role, initials);
    closeAddTeamMemberModal();
}

function handleBackdropClick(e) {
    if (e.target === addTeamMemberModal) {
        closeAddTeamMemberModal();
    }
}

function addTeamMemberToSurgeryDetails(name, role, initials) {
    const teamContainer = document.querySelector('#tab-team .grid.md\\:grid-cols-2');
    if (!teamContainer) return;
    
    // Remove the "Add Team Member" placeholder if it exists
    const placeholder = teamContainer.querySelector('.border-dashed');
    if (placeholder && teamContainer.children.length === 1) {
        placeholder.remove();
    }
    
    // Create new team member card
    const newMember = document.createElement('div');
    newMember.className = 'flex items-center gap-3 p-4 rounded-xl border hover:shadow-sm transition';
    newMember.innerHTML = `
        <span class="relative flex h-12 w-12 shrink-0 overflow-hidden rounded-full bg-gray-200">
            <span class="flex h-full w-full items-center justify-center text-sm font-semibold text-gray-600">${initials}</span>
        </span>
        <div>
            <p class="font-semibold">${name}</p>
            <p class="text-xs text-gray-500">${role}</p>
            <span class="inline-flex items-center gap-1 text-xs text-teal-600 mt-1">
                <span class="animate-ping rounded-full bg-teal-500" style="width:6px;height:6px;"></span> 
                Assigned
            </span>
        </div>
        <button class="remove-team-member ml-auto text-red-500 text-xs hover:text-red-700 opacity-60 hover:opacity-100 transition">Remove</button>
    `;
    teamContainer.appendChild(newMember);
    
    // Add remove functionality
    newMember.querySelector('.remove-team-member').addEventListener('click', () => {
        newMember.remove();
        showToast(`Removed ${name} from surgical team`);
        
        // Add back placeholder if no members left
        if (teamContainer.children.length === 0) {
            addTeamMemberPlaceholder();
        }
    });
    
    showToast(`Added ${name} (${role}) to surgical team`);
}

function addTeamMemberPlaceholder() {
    const teamContainer = document.querySelector('#tab-team .grid.md\\:grid-cols-2');
    if (!teamContainer) return;
    
    const placeholder = document.createElement('div');
    placeholder.className = 'flex items-center gap-3 p-4 rounded-xl border border-dashed hover:shadow-sm transition cursor-pointer opacity-80 hover:opacity-100';
    placeholder.innerHTML = `
        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-gray-100">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
        </span>
        <div>
            <p class="font-semibold text-gray-500">Add Team Member</p>
            <p class="text-xs text-gray-400">Click to assign</p>
        </div>
    `;
    placeholder.addEventListener('click', openAddTeamMemberModal);
    teamContainer.appendChild(placeholder);
}

// Add click event to the existing "Add Team Member" placeholder in the Surgical Team tab
function initTeamMemberAddButton() {
    // Find the placeholder card in the Surgical Team tab
    const placeholder = document.querySelector('#tab-team .border-dashed');
    if (placeholder) {
        placeholder.style.cursor = 'pointer';
        placeholder.addEventListener('click', openAddTeamMemberModal);
    }
}

// Add CSS for modal if not already present
function addModalStyles() {
    if (!document.querySelector('#dynamic-modal-styles')) {
        const style = document.createElement('style');
        style.id = 'dynamic-modal-styles';
        style.textContent = `
            .modal-overlay {
                position: fixed;
                inset: 0;
                background-color: rgba(0, 0, 0, 0.85);
                backdrop-filter: blur(4px);
                z-index: 9999;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .modal-overlay.hidden { display: none; }
            .modal-container {
                background: white;
                border-radius: 0.75rem;
                width: 100%;
                max-width: 500px;
                max-height: 85vh;
                overflow-y: auto;
                animation: modalSlideUp 0.2s ease-out;
            }
            body.dark .modal-container { background: #1e1e1e; border: 1px solid #333; }
            @keyframes modalSlideUp {
                from { transform: translateY(20px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
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
            body.dark .modal-header { background: #1e1e1e; border-bottom-color: #333; }
            .modal-title { font-size: 1.125rem; font-weight: 600; }
            .modal-close {
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
            body.dark .modal-footer { background: #1e1e1e; border-top-color: #333; }
            .modal-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0.75rem;
                border-radius: 0.5rem;
                border: 1px solid #e5e7eb;
                margin-bottom: 0.5rem;
                cursor: pointer;
                transition: all 0.15s ease;
            }
            .modal-item:hover { border-color: #4f46e5; background-color: #eef2ff; }
            body.dark .modal-item:hover { background-color: #1e1b4b; border-color: #818cf8; }
            .search-input {
                width: 100%;
                border-radius: 0.5rem;
                border: 1px solid #d1d5db;
                padding: 0.5rem 0.75rem;
                font-size: 0.875rem;
                margin-bottom: 1rem;
            }
            body.dark .search-input { background-color: #262626; border-color: #404040; color: #e5e5e5; }
        `;
        document.head.appendChild(style);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    addModalStyles();
    setTimeout(() => {
        initTeamMemberAddButton();
    }, 500);
});

document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeStatusModal(); });

// Init
populateDetails();
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
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Create Invoice</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <style>

        * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        body { background-color: #f9fafb; margin: 0; padding: 0; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .rounded-lg.border { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700,
        body.dark .text-muted-foreground, body.dark label { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted, body.dark .bg-gray-50 { background-color: #262626 !important; }
        body.dark .border-gray-200, body.dark .border-gray-300 { border-color: #333 !important; }
        body.dark input, body.dark textarea, body.dark .custom-select-trigger { background-color: #262626 !important; border-color: #404040 !important; color: #e5e5e5 !important; }
        
        /* Utility Classes */
        .bg-background { background-color: #ffffff; }
        body.dark .bg-background { background-color: #131212; }
        .border-gray-200 { border-color: #e5e7eb; }
        body.dark .border-gray-200 { border-color: #333; }
        .text-gray-500 { color: #6b7280; }
        body.dark .text-gray-500 { color: #9ca3af; }
        .text-gray-700 { color: #374151; }
        body.dark .text-gray-700 { color: #d1d5db; }
        .hover\:bg-accent:hover { background-color: #f3f4f6; }
        body.dark .hover\:bg-accent:hover { background-color: #374151; }
        
        /* Radix UI style select dropdowns */
        .radix-select-trigger {
            display: flex;
            height: 2.5rem;
            width: 100%;
            align-items: center;
            justify-content: space-between;
            border-radius: 0.375rem;
            border: 1px solid #e5e7eb;
            background-color: #ffffff;
            padding: 0 0.75rem;
            font-size: 0.875rem;
            cursor: pointer;
        }
        body.dark .radix-select-trigger { background-color: #262626; border-color: #404040; color: #e5e5e5; }
        .radix-select-content {
            position: absolute;
            z-index: 100;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            margin-top: 4px;
            min-width: 100%;
            max-height: 200px;
            overflow-y: auto;
            animation: fadeInScale 0.12s ease-out;
        }
        body.dark .radix-select-content { background: #2a2a2a; border-color: #404040; }
        .radix-select-item {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background 0.1s;
        }
        .radix-select-item:hover { background-color: #f3f4f6; }
        body.dark .radix-select-item:hover { background-color: #3f3f46; }
        @keyframes fadeInScale { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        
        /* Popover styles */
        .popover-content {
            position: fixed;
            z-index: 100;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            width: 320px;
            max-height: 400px;
            overflow: hidden;
            animation: fadeIn 0.15s ease-out;
        }
        body.dark .popover-content { background: #2a2a2a; border-color: #404040; }
        
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-4px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgb(0 0 0 / 87%);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.2s ease-out;
        }
        .modal-container {
            background: white;
            border-radius: 0.75rem;
            width: 100%;
            max-width: 850px;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            animation: slideUp 0.2s ease;
            position: relative;
        }
        body.dark .modal-container { background: #131212; border-color: #333; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header { padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; background: white; z-index: 10; }
        body.dark .modal-header { border-bottom-color: #404040; background: #131212; }
        .modal-title { font-size: 1.125rem; font-weight: 600; }
        .modal-close { background: transparent; border: none; font-size: 1.5rem; cursor: pointer; color: #6b7280; transition: color 0.1s; line-height: 1; padding: 0; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 0.375rem; }
        .modal-close:hover { color: #1f2937; background-color: #f3f4f6; }
        body.dark .modal-close:hover { color: #e5e5e5; background-color: #374151; }
        .modal-body { padding: 1.5rem; }
        .modal-footer { padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 0.5rem; position: sticky; bottom: 0;}
        body.dark .modal-footer { border-top-color: #404040; background: #131212; }
        
        .item-row { transition: background 0.2s; }
        .switch { cursor: pointer; }
        .coverage-radio[data-checked="true"] { background-color: #6366f1 !important; border-color: #6366f1 !important; }
        .payment-checkbox[data-checked="true"] { background-color: #6366f1 !important; border-color: #6366f1 !important; }
        .payment-checkbox[data-checked="true"]::after { content: "✓"; color: white; font-size: 0.7rem; display: flex; align-items: center; justify-content: center; }
        .coverage-radio[data-checked="true"]::after { content: ""; width: 6px; height: 6px; background: white; border-radius: 50%; display: block; margin: auto; }
        .flatpickr-calendar { z-index: 100 !important; }
        
        .invoice-preview-content { font-family: 'Inter', sans-serif; }
        .invoice-preview-content .invoice-header { text-align: center; margin-bottom: 1.5rem; }
        .invoice-preview-content .invoice-title { font-size: 1.5rem; font-weight: bold; color: #1f2937; }
        .invoice-preview-content .invoice-subtitle { font-size: 0.875rem; color: #6b7280; }
        body.dark .invoice-preview-content .invoice-title { color: #e5e5e5; }
        body.dark .invoice-preview-content .invoice-subtitle { color: #9ca3af; }
        .invoice-preview-content .invoice-divider { border-top: 1px solid #e5e7eb; margin: 1rem 0; }
        
        .toast-message {
            position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white;
            padding: 12px 20px; border-radius: 8px; z-index: 1100; font-size: 0.875rem;
            animation: slideIn 0.3s ease-out;
        }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }
        
        /* Layout utilities */
        .flex { display: flex; }
        .flex-col { flex-direction: column; }
        .flex-1 { flex: 1; }
        .items-center { align-items: center; }
        .items-start { align-items: flex-start; }
        .justify-between { justify-content: space-between; }
        .justify-end { justify-content: flex-end; }
        .justify-center { justify-content: center; }
        .gap-2 { gap: 0.5rem; }
        .gap-3 { gap: 0.75rem; }
        .gap-4 { gap: 1rem; }
        .gap-5 { gap: 1.25rem; }
        .space-y-1 > * + * { margin-top: 0.25rem; }
        .space-y-2 > * + * { margin-top: 0.5rem; }
        .space-y-3 > * + * { margin-top: 0.75rem; }
        .space-y-4 > * + * { margin-top: 1rem; }
        .space-y-5 > * + * { margin-top: 1.25rem; }
        .space-y-6 > * + * { margin-top: 1.5rem; }
        .grid { display: grid; }
        .grid-cols-1 { grid-template-columns: repeat(1, minmax(0, 1fr)); }
        .grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .md\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .lg\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .col-span-2 { grid-column: span 2 / span 2; }
        .w-full { width: 100%; }
        .w-64 { width: 16rem; }
        .w-28 { width: 7rem; }
        .w-24 { width: 6rem; }
        .w-20 { width: 5rem; }
        .h-10 { height: 2.5rem; }
        .h-16 { height: 4rem; }
        .h-8 { height: 2rem; }
        .h-6 { height: 1.5rem; }
        .h-5 { height: 1.25rem; }
        .h-4 { height: 1rem; }
        .p-1 { padding: 0.25rem; }
        .p-2 { padding: 0.5rem; }
        .p-3 { padding: 0.75rem; }
        .p-4 { padding: 1rem; }
        .p-6 { padding: 1.5rem; }
        .px-2 { padding-left: 0.5rem; padding-right: 0.5rem; }
        .px-3 { padding-left: 0.75rem; padding-right: 0.75rem; }
        .px-4 { padding-left: 1rem; padding-right: 1rem; }
        .py-1 { padding-top: 0.25rem; padding-bottom: 0.25rem; }
        .py-2 { padding-top: 0.5rem; padding-bottom: 0.5rem; }
        .py-3 { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .rounded-md { border-radius: 0.375rem; }
        .rounded-lg { border-radius: 0.5rem; }
        .rounded-full { border-radius: 9999px; }
        .border { border-width: 1px; border-style: solid; }
        .border-t { border-top-width: 1px; border-top-style: solid; border-top-color: #e5e7eb; }
        .border-b { border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #e5e7eb; }
        body.dark .border-b { border-bottom-color: #333; }
        .border-gray-300 { border-color: #d1d5db; }
        .border-gray-400 { border-color: #9ca3af; }
        .bg-gray-50 { background-color: #f9fafb; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-gray-300 { background-color: #d1d5db; }
        .bg-primary { background-color: #4f46e5; }
        .bg-background { background-color: #ffffff; }
        .bg-primary { background-color: #4f46e5; }
        .text-white { color: #ffffff; }
        .text-gray-400 { color: #9ca3af; }
        .text-indigo-600 { color: #4f46e5; }
        .text-red-500 { color: #ef4444; }
        .text-red-600 { color: #dc2626; }
        .text-green-600 { color: #16a34a; }
        .text-blue-800 { color: #1e40af; }
        .bg-blue-50 { background-color: #eff6ff; }
        .font-medium { font-weight: 500; }
        .font-semibold { font-weight: 600; }
        .font-bold { font-weight: 700; }
        .text-sm { font-size: 0.875rem; line-height: 1.25rem; }
        .text-xs { font-size: 0.75rem; line-height: 1rem; }
        .text-lg { font-size: 1.125rem; line-height: 1.75rem; }
        .text-xl { font-size: 1.25rem; line-height: 1.75rem; }
        .text-2xl { font-size: 1.5rem; line-height: 2rem; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .tracking-tight { letter-spacing: -0.025em; }
        .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        .overflow-auto { overflow: auto; }
        .overflow-hidden { overflow: hidden; }
        .overflow-x-auto { overflow-x: auto; }
        .overflow-y-auto { overflow-y: auto; }
        .sticky { position: sticky; }
        .fixed { position: fixed; }
        .relative { position: relative; }
        .absolute { position: absolute; }
        .inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
        .top-0 { top: 0; }
        .right-0 { right: 0; }
        .left-0 { left: 0; }
        .bottom-0 { bottom: 0; }
        .left-2\.5 { left: 0.625rem; }
        .top-2\.5 { top: 0.625rem; }
        .z-40 { z-index: 40; }
        .z-50 { z-index: 50; }
        .inline-flex { display: inline-flex; }
        .hidden { display: none; }
        .ml-auto { margin-left: auto; }
        .mr-1 { margin-right: 0.25rem; }
        .mr-2 { margin-right: 0.5rem; }
        .ml-2 { margin-left: 0.5rem; }
        .mt-1 { margin-top: 0.25rem; }
        .mt-2 { margin-top: 0.5rem; }
        .mt-4 { margin-top: 1rem; }
        .mb-1 { margin-bottom: 0.25rem; }
        .mb-2 { margin-bottom: 0.5rem; }
        .mb-3 { margin-bottom: 0.75rem; }
        .mb-4 { margin-bottom: 1rem; }
        .mr-1 { margin-right: 0.25rem; }
        .transform { transform: translateX(0); }
        .translate-x-0 { transform: translateX(0); }
        .translate-x-5 { transform: translateX(1.25rem); }
        .transition-colors { transition-property: color, background-color, border-color; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 0.15s; }
        .transition-transform { transition-property: transform; transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); transition-duration: 0.15s; }
        .cursor-pointer { cursor: pointer; }
        .cursor-default { cursor: default; }
        .outline-none { outline: none; }
        .focus\:outline-none:focus { outline: none; }
        .focus\:ring-2:focus { box-shadow: 0 0 0 2px #4f46e5; }
        .focus\:ring-indigo-500:focus { box-shadow: 0 0 0 2px #4f46e5; }
        .hover\:bg-gray-50:hover { background-color: #f9fafb; }
        .hover\:bg-gray-100:hover { background-color: #f3f4f6; }
        .hover\:bg-primary\/90:hover { background-color: #4338ca; }
        .hover\:bg-indigo-700:hover { background-color: #4338ca; }
        .hover\:text-indigo-700:hover { color: #4338ca; }
        .hover\:underline:hover { text-decoration: underline; }
        .opacity-50 { opacity: 0.5; }
        .pointer-events-none { pointer-events: none; }
        .select-none { user-select: none; }
        .sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border-width: 0; }
        
        /* Responsive */
        @media (min-width: 768px) {
            .md\:grid-cols-2 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .md\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .md\:w-auto { width: auto; }
            .md\:table-cell { display: table-cell; }
            .md\:p-6 { padding: 1.5rem; }
        }
        @media (min-width: 1024px) {
            .lg\:grid-cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .lg\:col-span-2 { grid-column: span 2 / span 2; }
            .lg\:text-3xl { font-size: 1.875rem; line-height: 2.25rem; }
        }
        body.dark .bg-blue-50 { background-color: #1e3a5f; }
        body.dark .text-blue-800 { color: #93c5fd; }

        /* Watermark styles for draft invoices */
.watermark-container {
    position: relative;
}

.watermark-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-25deg);
    font-size: 5rem;
    font-weight: 800;
    color: rgba(220, 38, 38, 0.15);
    white-space: nowrap;
    pointer-events: none;
    z-index: 10;
    font-family: 'Inter', sans-serif;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    border: 3px solid rgba(220, 38, 38, 0.2);
    padding: 0.5rem 2rem;
    border-radius: 1rem;
}

body.dark .watermark-text {
    color: rgba(239, 68, 68, 0.2);
    border-color: rgba(239, 68, 68, 0.25);
}

/* For smaller screens */
@media (max-width: 640px) {
    .watermark-text {
        font-size: 2.5rem;
        padding: 0.25rem 1rem;
        white-space: nowrap;
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
            <div class="flex flex-col gap-5 overflow-x-hidden max-full mx-auto">
                <div class="flex items-center gap-4 flex-wrap">
                    <a href="billing.html" class="inline-flex items-center justify-center rounded-md border border-gray-300 shadow-sm bg-background hover:bg-accent hover:text-accent-foreground size-10">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg>
                </a>
                    <div><h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">Create Invoice</h1><p class="text-gray-500">Create a new invoice for a patient.</p></div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
                    <!-- Left Column - Invoice Details -->
                    <div class="lg:col-span-2 space-y-5">
                        <div class="rounded-lg border bg-background shadow-sm">
                            <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Invoice Details</h2><div class="text-gray-500">Enter the details for the new invoice.</div></div>
                            <div class="p-4 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="space-y-2"><label class="text-sm font-medium">Invoice Number</label><input id="invoiceNumber" class="h-10 w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-sm" readonly value="INV-008"></div>
                                    <div class="space-y-2"><label class="text-sm font-medium">Invoice Date</label><input type="date" id="invoiceDatePicker" class="h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm cursor-pointer"></div>
                                    <div class="space-y-2"><label class="text-sm font-medium">Due Date</label><input type="date" id="dueDatePicker" class="h-10 w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm cursor-pointer"></div>
                                </div>
                                
                                <!-- Radix UI Invoice Type Select -->
                                <div class="space-y-2">
                                    <label class="text-sm font-medium">Invoice Type</label>
                                    <div class="relative">
                                        <button id="invoiceTypeTrigger" class="radix-select-trigger w-full justify-between">
                                            <span id="invoiceTypeText">Standard Invoice</span>
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                        </button>
                                        <div id="invoiceTypeDropdown" class="radix-select-content hidden w-full">
                                            <div class="radix-select-item" data-value="Standard Invoice">Standard Invoice</div>
                                            <div class="radix-select-item" data-value="Proforma Invoice">Proforma Invoice</div>
                                            <div class="radix-select-item" data-value="Recurring Invoice">Recurring Invoice</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="space-y-2"><label class="text-sm font-medium">Reference / PO Number (Optional)</label><input id="reference" class="h-10 w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Enter reference or PO number"></div>
                                
                                <div class="border-t"></div>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between"><h3 class="text-lg font-medium">Items &amp; Services</h3><button id="addItemBtn" class="inline-flex items-center gap-2 rounded-md bg-primary text-white hover:bg-primary/90px-3 py-2 h-10 px-4 text-sm"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5v14"></path></svg>Add Item</button></div>
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-50 border-b"><tr><th class="px-4 py-3 text-left w-10"></th><th class="px-4 py-3 text-left">Description</th><th class="px-4 py-3 text-right w-24">Quantity</th><th class="px-4 py-3 text-right w-28">Unit Price</th><th class="px-4 py-3 text-right w-28">Total</th><th class="px-4 py-3 text-center w-10"></th></tr></thead>
                                            <tbody id="itemsTableBody"></tbody>
                                        </table>
                                    </div>
                                    <div class="flex flex-col items-end space-y-2">
                                        <div class="flex justify-between w-64"><span class="font-medium">Subtotal:</span><span id="subtotal">$0.00</span></div>
                                        <div class="flex justify-between w-64"><span>Tax (<span id="taxRateDisplay">8</span>%):</span><span id="taxAmount">$0.00</span></div>
                                        <div class="flex justify-between w-64"><span>Discount:</span><span id="discountDisplay">$0.00</span></div>
                                        <div class="border-t w-64"></div>
                                        <div class="flex justify-between w-64 font-bold"><span class="text-lg">Total:</span><span id="totalAmount" class="text-lg">$0.00</span></div>
                                    </div>
                                </div>
                                
                                <div class="border-t"></div>
                                <div class="space-y-4">
                                    <h3 class="text-lg font-medium">Additional Information</h3>
                                    <div class="space-y-2"><label class="text-sm font-medium">Notes</label><textarea id="notes" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Enter any additional notes for this invoice"></textarea></div>
                                    
                                    <!-- Radix UI Payment Terms Select -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium">Payment Terms</label>
                                        <div class="relative">
                                            <button id="paymentTermsTrigger" class="radix-select-trigger w-full justify-between">
                                                <span id="paymentTermsText">Net 30 Days</span>
                                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                            </button>
                                            <div id="paymentTermsDropdown" class="radix-select-content hidden w-full">
                                                <div class="radix-select-item" data-value="Net 15 Days">Net 15 Days</div>
                                                <div class="radix-select-item" data-value="Net 30 Days">Net 30 Days</div>
                                                <div class="radix-select-item" data-value="Due on Receipt">Due on Receipt</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end gap-4"><button id="saveDraftBtn" class="border border-gray-300 bg-background h-10  hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 rounded-md text-sm">Save as Draft</button><button id="createInvoiceBtn" class="bg-primary text-white hover:bg-primary/90 px-4 py-2 px-4 rounded-md text-sm">Create Invoice</button></div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="space-y-5">
                        <div class="rounded-lg border bg-background shadow-sm">
                            <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Patient Information</h2><div class="text-gray-500">Select a patient for this invoice.</div></div>
                            <div class="p-4 space-y-4">
                                <button id="selectPatientBtn" class="flex w-full items-center justify-between rounded-md border border-gray-300 bg-background  hover:bg-accent hover:text-accent-foreground h-10 px-4 py-2 text-sm"><span>Search patients...</span><svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg></button>
                                <div id="selectedPatientCard" class="p-4 border rounded-md hidden"><div class="flex items-center gap-3"><img id="patientAvatar" class="h-10 w-10 rounded-full object-cover" src="user.png" alt="User profile photo"><div><p id="patientName" class="font-medium"></p><p id="patientInfo" class="text-gray-500"></p></div></div><div class="mt-3 space-y-1 text-sm"><p id="patientEmail"></p><p id="patientPhone"></p><p id="patientAddress" class="text-xs"></p></div><button id="viewPatientDetails" class="text-indigo-600 text-sm mt-2 hover:underline">View patient details</button></div>
                            </div>
                        </div>
                        
                        <div class="rounded-lg border bg-background shadow-sm">
                            <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Insurance Information</h2><div class="text-gray-500">Patient's insurance details.</div></div>
                            <div class="p-4 space-y-4">
                                <div class="space-y-2"><div class="flex items-center justify-between"><label class="text-sm font-medium">Bill to Insurance</label><button id="insuranceToggle" class="switch relative inline-flex h-6 w-11 items-center rounded-full transition-colors bg-primary" role="switch" aria-checked="true"><span class="inline-block h-5 w-5 transform rounded-full bg-background transition-transform translate-x-5"></span></button></div>
                                <div id="insuranceDetails" class="p-4border rounded-md"><p class="font-medium">AAR Insurance</p><p class="text-sm">Policy #: BCBS123456789</p><p class="text-sm">Group #: GRP987654321</p><p class="text-sm">Coverage: PPO</p></div></div>
                                <div class="space-y-2"><label class="text-sm font-medium">Copay Amount</label><input id="copayAmount" type="number" step="0.01" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="0.00"></div>
                                <div class="space-y-2"><label class="text-sm font-medium">Coverage Verification</label><div class="space-y-1"><label class="flex items-center gap-2"><button type="button" role="radio" class="coverage-radio h-4 w-4 rounded-full border border-gray-400 flex items-center justify-center" data-value="verified"></button><span class="text-sm">Verified</span></label><label class="flex items-center gap-2"><button type="button" role="radio" class="coverage-radio h-4 w-4 rounded-full border border-gray-400 flex items-center justify-center" data-value="pending"></button><span class="text-sm">Pending Verification</span></label><label class="flex items-center gap-2"><button type="button" role="radio" class="coverage-radio h-4 w-4 rounded-full border border-gray-400 flex items-center justify-center" data-value="not-covered"></button><span class="text-sm">Not Covered</span></label></div></div>
                            </div>
                        </div>
                        
                        <div class="rounded-lg border bg-background shadow-sm">
                            <div class="p-4 border-b"><h2 class="text-xl font-semibold tracking-tight">Payment Options</h2></div>
                            <div class="p-4 space-y-4">
                                <div><label class="text-sm font-medium block mb-3">Accepted Payment Methods</label><div class="grid grid-cols-2 gap-3"><label class="flex items-center gap-2"><button type="button" role="checkbox" class="payment-checkbox h-4 w-4 rounded-sm border border-gray-400 flex items-center justify-center" data-checked="true"></button><span class="text-sm">Credit Card</span></label><label class="flex items-center gap-2"><button type="button" role="checkbox" class="payment-checkbox h-4 w-4 rounded-sm border border-gray-400 flex items-center justify-center" data-checked="true"></button><span class="text-sm">Debit Card</span></label><label class="flex items-center gap-2"><button type="button" role="checkbox" class="payment-checkbox h-4 w-4 rounded-sm border border-gray-400 flex items-center justify-center" data-checked="true"></button><span class="text-sm">Cash</span></label><label class="flex items-center gap-2"><button type="button" role="checkbox" class="payment-checkbox h-4 w-4 rounded-sm border border-gray-400 flex items-center justify-center" data-checked="true"></button><span class="text-sm">Insurance</span></label><label class="flex items-center gap-2"><button type="button" role="checkbox" class="payment-checkbox h-4 w-4 rounded-sm border border-gray-400 flex items-center justify-center"></button><span class="text-sm">Bank Transfer</span></label><label class="flex items-center gap-2"><button type="button" role="checkbox" class="payment-checkbox h-4 w-4 rounded-sm border border-gray-400 flex items-center justify-center"></button><span class="text-sm">Payment Plan</span></label></div></div>
                                <div class="flex items-center justify-between"><label class="text-sm font-medium">Offer Payment Plan</label><button id="paymentPlanToggle" class="switch relative inline-flex h-6 w-11 items-center rounded-full transition-colors bg-gray-300" role="switch" aria-checked="false"><span class="inline-block h-5 w-5 transform rounded-full bg-background transition-transform translate-x-0"></span></button></div>
                                <div class="flex justify-between gap-2"><button id="taxCalculatorBtn" class="border rounded-md px-3 py-1.5 text-sm flex items-center gap-1 h-10"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2"></rect><line x1="8" x2="16" y1="6" y2="6"></line><line x1="16" x2="16" y1="14" y2="18"></line></svg>Tax Calculator</button><button id="previewBtn" class="border rounded-md px-3 py-2 px-4 h-10 text-sm flex items-center gap-1"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg>Preview Invoice</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>


<!-- Patient Search Popover -->
<div id="patientSearchPopover" class="hidden popover-content">
    <div class="flex items-center border-b px-3"><svg class="mr-2 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg><input id="patientSearchInput" type="text" placeholder="Search patients..." class="flex-1 py-3 text-sm outline-none bg-transparent"></div>
    <div id="patientSearchResults" class="max-h-64 overflow-y-auto p-1"></div>
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




        // ==================== INVOICE DATA & FUNCTIONS ====================
let currentTaxRate = 8;
const serviceOptions = [
    { id: 1, name: "General Consultation", price: 150 },
    { id: 2, name: "Blood Test - Basic Panel", price: 80 },
    { id: 3, name: "X-Ray - Chest", price: 200 },
    { id: 4, name: "MRI Scan", price: 500 },
    { id: 5, name: "Physical Therapy Session", price: 120 },
    { id: 6, name: "Prescription Medication", price: 45 },
    { id: 7, name: "Emergency Room Visit", price: 350 },
    { id: 8, name: "Dental Cleaning", price: 100 }
];
const patients = [
    { name: "Okello David", id: "P12345", age: 45, gender: "Male", email: "okello.david@hmail.com", phone: "+256 712 345 678", address: "Plot 14, Kampala Road, Kampala, Uganda", insurance: "AAR Insurance", policy: "BCBS123456789", group: "GRP987654321" },
    { name: "Nakato Mary", id: "P23456", age: 33, gender: "Female", email: "nakato.mary@hmail.com", phone: "+256 712 345 679", address: "Plot 12, Ntinda Roadnue, Nairobi, Kenya", insurance: "Jubilee Insurance", policy: "AET987654321", group: "GRP123456" },
    { name: "Mwangi Peter", id: "P34567", age: 58, gender: "Male", email: "mwangi.peter@hmail.com", phone: "+256 712 345 680", address: "789 Pine Road, Dar es Salaam, Tanzania", insurance: "UAP Old Mutual", policy: "UHC567891234", group: "GRP456789" }
];
let selectedPatient = patients[0];
let invoiceItems = [{ id: Date.now(), description: "General Consultation", qty: 1, unitPrice: 150, additionalDesc: "" }];
let activeModal = null;

// Initialize date pickers with today's date using native HTML date inputs
const todayDate = new Date();
const todayFormatted = todayDate.toISOString().split('T')[0]; // YYYY-MM-DD format
document.getElementById('invoiceDatePicker').value = todayFormatted;
document.getElementById('dueDatePicker').value = todayFormatted;

// For display purposes in the preview modal, we'll format the date
function formatDateForDisplay(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString + 'T00:00:00'); // Add time to avoid timezone issues
    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}

function closeModal() { if (activeModal) { activeModal.remove(); activeModal = null; } }

function calculateTotals() {
    const subtotal = invoiceItems.reduce((sum, item) => sum + (item.qty * item.unitPrice), 0);
    const tax = subtotal * (currentTaxRate / 100);
    const total = subtotal + tax;
    document.getElementById('subtotal').innerText = formatCurrency(subtotal);
    document.getElementById('taxAmount').innerText = formatCurrency(tax);
    document.getElementById('totalAmount').innerText = formatCurrency(total);
    document.getElementById('taxRateDisplay').innerText = currentTaxRate;
}

// Radix UI Select Helpers
function initRadixSelect(triggerId, dropdownId, textSpanId, options) {
    const trigger = document.getElementById(triggerId);
    const dropdown = document.getElementById(dropdownId);
    const textSpan = document.getElementById(textSpanId);
    if (!trigger || !dropdown || !textSpan) return;
    trigger.addEventListener('click', (e) => { e.stopPropagation(); dropdown.classList.toggle('hidden'); });
    dropdown.querySelectorAll('.radix-select-item').forEach(item => {
        item.addEventListener('click', () => {
            textSpan.innerText = item.dataset.value;
            dropdown.classList.add('hidden');
        });
    });
    document.addEventListener('click', (e) => { if (!trigger.contains(e.target) && !dropdown.contains(e.target)) dropdown.classList.add('hidden'); });
}
initRadixSelect('invoiceTypeTrigger', 'invoiceTypeDropdown', 'invoiceTypeText', ['Standard Invoice', 'Proforma Invoice', 'Recurring Invoice']);
initRadixSelect('paymentTermsTrigger', 'paymentTermsDropdown', 'paymentTermsText', ['Net 15 Days', 'Net 30 Days', 'Due on Receipt']);

function showServiceDropdown(button) {
    const existing = document.querySelector('.service-dropdown');
    if(existing) existing.remove();
    const dropdown = document.createElement('div');
    dropdown.className = 'radix-select-content service-dropdown';
    dropdown.innerHTML = serviceOptions.map(opt => `<div class="radix-select-item" data-name="${opt.name}" data-price="${opt.price}">${opt.name} - ${formatCurrency(opt.price)}</div>`).join('');
    const rect = button.getBoundingClientRect();
    dropdown.style.top = `${rect.bottom + 5}px`;
    dropdown.style.left = `${rect.left}px`;
    dropdown.style.position = 'fixed';
    dropdown.style.minWidth = `${rect.width}px`;
    document.body.appendChild(dropdown);
    dropdown.querySelectorAll('.radix-select-item').forEach(item => {
        item.addEventListener('click', (e) => {
            e.stopPropagation();
            const name = item.dataset.name;
            const price = parseFloat(item.dataset.price);
            const row = button.closest('tr');
            const rowId = row.querySelector('.delete-item')?.dataset.id;
            const itemObj = invoiceItems.find(i => i.id == rowId);
            if(itemObj) { itemObj.description = name; itemObj.unitPrice = price; renderItemsTable(); }
            dropdown.remove();
        });
    });
    const closeDropdown = (e) => { if(!dropdown.contains(e.target) && e.target !== button) { dropdown.remove(); document.removeEventListener('click', closeDropdown); } };
    setTimeout(() => document.addEventListener('click', closeDropdown), 10);
}

function renderItemsTable() {
    const tbody = document.getElementById('itemsTableBody');
    tbody.innerHTML = invoiceItems.map((item) => `
        <tr class="item-row border-b">
            <td class="px-4 py-3"><button type="button" class="item-checkbox h-4 w-4 rounded-sm border border-gray-400" data-id="${item.id}"></button></td>
            <td class="px-4 py-3">
                <div class="space-y-2">
                    <button class="service-select-btn w-full text-left border rounded-md px-3 py-1.5 text-sm bg-background  hover:bg-accent hover:text-accent-foreground h-10 flex justify-between items-center" data-id="${item.id}">
                        <span class="service-name">${item.description}</span>
                        <svg class="h-3 w-3 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                    </button>
                    <input type="text" class="item-additional-desc w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Additional description" value="${item.additionalDesc || ''}" data-id="${item.id}">
                </div>
            </td>
            <td class="px-4 py-3"><input type="number" value="${item.qty}" min="1" step="1" class="item-qty w-20 text-right border rounded px-2 py-1 text-sm" data-id="${item.id}"></td>
            <td class="px-4 py-3"><input type="number" value="${item.unitPrice}" min="0" step="0.01" class="item-price w-24 text-right border rounded px-2 py-1 text-sm" data-id="${item.id}"></td>
            <td class="px-4 py-3 text-right font-medium">${formatCurrency(item.qty * item.unitPrice)}</td>
            <td class="px-4 py-3 text-center"><button class="delete-item text-red-500 hover:text-red-700" data-id="${item.id}"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg></button></td>
        </tr>
    `).join('');
    calculateTotals();
    document.querySelectorAll('.service-select-btn').forEach(btn => btn.addEventListener('click', (e) => { e.stopPropagation(); showServiceDropdown(btn); }));
    document.querySelectorAll('.item-additional-desc').forEach(inp => inp.addEventListener('change', (e) => { const item = invoiceItems.find(i => i.id == e.target.dataset.id); if(item) item.additionalDesc = e.target.value; }));
    document.querySelectorAll('.item-qty').forEach(inp => inp.addEventListener('change', (e) => { const item = invoiceItems.find(i => i.id == e.target.dataset.id); if(item) { item.qty = parseInt(e.target.value) || 1; renderItemsTable(); } }));
    document.querySelectorAll('.item-price').forEach(inp => inp.addEventListener('change', (e) => { const item = invoiceItems.find(i => i.id == e.target.dataset.id); if(item) { item.unitPrice = parseFloat(e.target.value) || 0; renderItemsTable(); } }));
    document.querySelectorAll('.delete-item').forEach(btn => btn.addEventListener('click', (e) => { invoiceItems = invoiceItems.filter(i => i.id != btn.dataset.id); if(invoiceItems.length === 0) invoiceItems = [{ id: Date.now(), description: "New Service", qty: 1, unitPrice: 0, additionalDesc: "" }]; renderItemsTable(); }));
}

// TAX CALCULATOR MODAL
function showTaxCalculatorModal() {
    closeModal();
    const subtotal = invoiceItems.reduce((sum, item) => sum + (item.qty * item.unitPrice), 0);
    const currentTax = subtotal * (currentTaxRate / 100);
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="modal-container" style="max-width: 500px;">
            <div class="modal-header"><h2 class="modal-title">Tax Calculator</h2><button class="modal-close">&times;</button></div>
            <div class="modal-body">
                <p class="text-sm text-gray-500 mb-4">Calculate tax for the invoice based on the current subtotal.</p>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4"><div><label class="text-sm font-medium">Subtotal</label><p class="text-lg font-semibold" id="calcSubtotal">${formatCurrency(subtotal)}</p></div>
                    <div><label class="text-sm font-medium">Tax Rate (%)</label><input type="number" id="taxRateInput" step="0.5" value="${currentTaxRate}" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm"></div></div>
                    <div class="grid grid-cols-2 gap-4"><div><label class="text-sm font-medium">Tax Amount</label><p class="text-lg font-semibold text-indigo-600" id="calcTaxAmount">${formatCurrency(currentTax)}</p></div>
                    <div><label class="text-sm font-medium">Total with Tax</label><p class="text-lg font-semibold text-green-600" id="calcTotal">${formatCurrency(subtotal + currentTax)}</p></div></div>
                    <div class="border-t pt-4"><label class="text-sm font-medium">Tax Breakdown</label><div id="taxBreakdown" class="mt-2 space-y-1 text-sm"><div class="flex justify-between"><span>Standard Tax Rate:</span><span id="breakdownAmount">${formatCurrency(currentTax)}</span></div></div></div>
                    <div class="bg-blue-50 p-3 rounded-md dark:bg-blue-900/20"><p class="text-sm text-blue-800 dark:text-blue-300"><strong>Note:</strong> Tax rate is applied to subtotal. Final tax amount will be added to the invoice total.</p></div>
                </div>
            </div>
            <div class="modal-footer"><button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm  hover:bg-accent hover:text-accent-foreground h-10">Close</button><button id="applyTaxBtn" class="inline-flex rounded-md bg-primary text-white px-4 py-2 text-sm hover:bg-primary/90">Apply Tax Rate</button></div>
        </div>
    `;
    document.body.appendChild(modal);
    activeModal = modal;
    const taxRateInput = modal.querySelector('#taxRateInput');
    const calcTaxAmount = modal.querySelector('#calcTaxAmount');
    const calcTotal = modal.querySelector('#calcTotal');
    const breakdownAmount = modal.querySelector('#breakdownAmount');
    function updateCalc() {
        const rate = parseFloat(taxRateInput.value) || 0;
        const taxAmount = subtotal * (rate / 100);
        calcTaxAmount.textContent = formatCurrency(taxAmount);
        calcTotal.textContent = formatCurrency(subtotal + taxAmount);
        if(breakdownAmount) breakdownAmount.textContent = formatCurrency(taxAmount);
    }
    taxRateInput.addEventListener('input', updateCalc);
    modal.querySelector('.modal-close')?.addEventListener('click', () => closeModal());
    modal.querySelector('.cancel-modal')?.addEventListener('click', () => closeModal());
    modal.querySelector('#applyTaxBtn')?.addEventListener('click', () => {
        const newRate = parseFloat(taxRateInput.value) || 0;
        currentTaxRate = newRate;
        calculateTotals();
        showToast(`Tax rate updated to ${currentTaxRate}%`);
        closeModal();
    });
}

// PREVIEW INVOICE MODAL with DRAFT watermark

function showPreviewModal() {
    closeModal();
    const subtotal = invoiceItems.reduce((sum, item) => sum + (item.qty * item.unitPrice), 0);
    const tax = subtotal * (currentTaxRate / 100);
    const total = subtotal + tax;
    const invoiceNumber = document.getElementById('invoiceNumber').value;
const invoiceDateRaw = document.getElementById('invoiceDatePicker').value;
const dueDateRaw = document.getElementById('dueDatePicker').value;
const invoiceDate = formatDateForDisplay(invoiceDateRaw);
const dueDate = formatDateForDisplay(dueDateRaw);
    const notes = document.getElementById('notes').value;
    const invoiceType = document.getElementById('invoiceTypeText').innerText;
    const paymentTerms = document.getElementById('paymentTermsText').innerText;
    const reference = document.getElementById('reference').value;
    
    // Check if this is a draft (since this is preview before saving)
    const isDraft = true;
    
    const modal = document.createElement('div');
    modal.className = 'modal-overlay';
    modal.innerHTML = `
        <div class="modal-container" style="max-width: 900px;">
            <div class="modal-header"><h2 class="modal-title">Invoice Preview</h2><button class="modal-close">&times;</button></div>
            <div class="modal-body" id="previewContent" style="position: relative;">
                <div class="watermark-container" style="position: relative;">
                    ${isDraft ? '<div class="watermark-text">DRAFT</div>' : ''}
                    <div class="invoice-preview-content" style="position: relative; z-index: 1;">
                        <div class="invoice-header"><div class="flex justify-center mb-2"><img src="logo.png" alt="Logo" style="width: 50px; height: 50px;" onerror="this.style.display=\'none\'"></div>
                        <h2 class="invoice-title">Medi-track Healthcare EA System</h2><p class="invoice-subtitle">Plot 14, Kampala Road, Kampala, Uganda</p><p class="invoice-subtitle">Tel: +256 712 345 678 | Email: billing@hospital.ug</p></div>
                        <div class="invoice-divider"></div>
                        <div class="grid grid-cols-2 gap-4 mb-4"><div><p class="text-xs text-gray-500">INVOICE TO</p><p class="font-semibold">${selectedPatient ? selectedPatient.name : 'Not Selected'}</p><p class="text-sm">${selectedPatient ? selectedPatient.address : ''}</p></div>
                        <div class="text-right"><p class="text-xs text-gray-500">INVOICE #</p><p class="font-semibold">${invoiceNumber}</p><p class="text-xs text-gray-500 mt-1">Date: ${invoiceDate}</p><p class="text-xs text-gray-500">Due Date: ${dueDate}</p></div></div>
                        ${reference ? `<div class="mb-3"><p class="text-xs text-gray-500">Reference / PO Number</p><p class="text-sm">${reference}</p></div>` : ''}
                        <table class="w-full text-sm mb-4"><thead><tr class="border-b"><th class="py-2 text-left">Description</th><th class="py-2 text-right">Qty</th><th class="py-2 text-right">Unit Price</th><th class="py-2 text-right">Amount</th></tr></thead>
                        <tbody>${invoiceItems.map(item => `<tr class="border-b"><td class="py-2">${item.description}${item.additionalDesc ? `<br><span class="text-xs text-gray-500">${item.additionalDesc}</span>` : ''}</td><td class="py-2 text-right">${item.qty}</td><td class="py-2 text-right">${formatCurrency(item.unitPrice)}</td><td class="py-2 text-right">${formatCurrency(item.qty * item.unitPrice)}</tr>`).join('')}</tbody>
                        <tfoot><tr><td colspan="3" class="py-2 text-right font-medium">Subtotal:</td><td class="py-2 text-right">${formatCurrency(subtotal)}</tr>
                        <tr><td colspan="3" class="py-2 text-right font-medium">Tax (${currentTaxRate}%):</td><td class="py-2 text-right">${formatCurrency(tax)}</tr>
                        <tr><td colspan="3" class="py-2 text-right font-bold">Total:</td><td class="py-2 text-right font-bold">${formatCurrency(total)}<tr></tfoot>
                    </table>
                        <div class="invoice-divider"></div>
                        <div class="grid grid-cols-2 gap-4 mt-4"><div><p class="text-xs text-gray-500">Payment Terms</p><p class="text-sm">${paymentTerms}</p><p class="text-xs text-gray-500 mt-2">Invoice Type</p><p class="text-sm">${invoiceType}</p></div>
                        <div class="text-right"><p class="text-xs text-gray-500">Notes</p><p class="text-sm">${notes || 'No additional notes'}</p></div></div>
                        <div class="invoice-divider mt-4"></div><div class="text-center text-xs text-gray-500 mt-4"><p>Thank you for choosing Medi-track Healthcare EA System</p><p>This is a computer-generated invoice and requires no signature.</p></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer z-10 bg-background"><button class="cancel-modal inline-flex rounded-md border px-4 py-2 text-sm hover:bg-gray-100">Close</button><button id="downloadPreviewPdfBtn" class="inline-flex rounded-md bg-primary text-white px-4 py-2 text-sm hover:bg-primary/90">Download PDF</button></div>
        </div>
    `;
    
    document.body.appendChild(modal);
    activeModal = modal;
    
    // Close button handlers
    modal.querySelector('.modal-close')?.addEventListener('click', () => closeModal());
    modal.querySelector('.cancel-modal')?.addEventListener('click', () => closeModal());
    
    // Download PDF button
    const downloadBtn = modal.querySelector('#downloadPreviewPdfBtn');
    if (downloadBtn) {
        downloadBtn.addEventListener('click', () => {
            const element = document.getElementById('previewContent');
            if (element) {
                showToast('Generating PDF...');
                
                // Create a clone of the element to include the watermark in PDF
                const cloneElement = element.cloneNode(true);
                
// Trigger browser's native print dialog which can save as PDF
window.print();
showToast('Print dialog opened - you can save as PDF from there');
            } else {
                showToast('Preview content not found', true);
            }
        });
    }
    
    // Click outside to close
    modal.addEventListener('click', (e) => {
        if (e.target === modal) closeModal();
    });
}
// Patient Search
const popover = document.getElementById('patientSearchPopover');
const searchInput = document.getElementById('patientSearchInput');
const resultsDiv = document.getElementById('patientSearchResults');
function renderPatientSearch(query) {
    const filtered = patients.filter(p => p.name.toLowerCase().includes(query.toLowerCase()));
    resultsDiv.innerHTML = filtered.map(p => `<div class="patient-result flex items-center gap-3 p-2 hover:bg-gray-100 rounded cursor-pointer" data-name="${p.name}" data-id="${p.id}" data-age="${p.age}" data-gender="${p.gender}" data-email="${p.email}" data-phone="${p.phone}" data-address="${p.address}" data-insurance="${p.insurance}" data-policy="${p.policy}" data-group="${p.group}"><img src="user.png" class="h-8 w-8 rounded-full object-cover" alt="User profile photo"><div><p class="text-sm font-medium">${p.name}</p><p class="text-xs text-gray-500">${p.age} • ${p.gender} • ID: ${p.id}</p></div></div>`).join('');
    document.querySelectorAll('.patient-result').forEach(el => el.addEventListener('click', () => { selectedPatient = { name: el.dataset.name, id: el.dataset.id, age: el.dataset.age, gender: el.dataset.gender, email: el.dataset.email, phone: el.dataset.phone, address: el.dataset.address, insurance: el.dataset.insurance, policy: el.dataset.policy, group: el.dataset.group }; updateSelectedPatientUI(); popover.classList.add('hidden'); }));
}
function updateSelectedPatientUI() {
    const card = document.getElementById('selectedPatientCard');
    if (selectedPatient) {
        card.classList.remove('hidden');
        document.getElementById('patientName').innerText = selectedPatient.name;
        document.getElementById('patientInfo').innerText = `${selectedPatient.age} • ${selectedPatient.gender} • ID: ${selectedPatient.id}`;
        document.getElementById('patientEmail').innerHTML = `<span class="font-medium">Email:</span> ${selectedPatient.email}`;
        document.getElementById('patientPhone').innerHTML = `<span class="font-medium">Phone:</span> ${selectedPatient.phone}`;
        document.getElementById('patientAddress').innerHTML = selectedPatient.address;
        const insuranceDiv = document.getElementById('insuranceDetails');
        insuranceDiv.innerHTML = `<p class="font-medium">${selectedPatient.insurance}</p><p class="text-sm">Policy #: ${selectedPatient.policy}</p><p class="text-sm">Group #: ${selectedPatient.group}</p><p class="text-sm">Coverage: PPO</p>`;
    } else card.classList.add('hidden');
}
document.getElementById('selectPatientBtn').addEventListener('click', (e) => { e.stopPropagation(); const rect = document.getElementById('selectPatientBtn').getBoundingClientRect(); popover.style.top = `${rect.bottom + 5}px`; popover.style.left = `${rect.left}px`; popover.classList.toggle('hidden'); renderPatientSearch(''); });
searchInput.addEventListener('input', (e) => renderPatientSearch(e.target.value));
document.addEventListener('click', (e) => { if (!document.getElementById('selectPatientBtn').contains(e.target) && !popover.contains(e.target)) popover.classList.add('hidden'); });
document.getElementById('viewPatientDetails')?.addEventListener('click', () => alert(`Patient Details:\nName: ${selectedPatient.name}\nID: ${selectedPatient.id}\nEmail: ${selectedPatient.email}\nPhone: ${selectedPatient.phone}\nAddress: ${selectedPatient.address}`));

// Toggles
const insuranceToggle = document.getElementById('insuranceToggle');
insuranceToggle.addEventListener('click', () => { const isChecked = insuranceToggle.getAttribute('aria-checked') === 'true'; insuranceToggle.setAttribute('aria-checked', !isChecked); insuranceToggle.classList.toggle('bg-primary', !isChecked); insuranceToggle.classList.toggle('bg-gray-300', isChecked); const span = insuranceToggle.querySelector('span'); span.classList.toggle('translate-x-5', !isChecked); });
const paymentPlanToggle = document.getElementById('paymentPlanToggle');
paymentPlanToggle.addEventListener('click', () => { const isChecked = paymentPlanToggle.getAttribute('aria-checked') === 'true'; paymentPlanToggle.setAttribute('aria-checked', !isChecked); paymentPlanToggle.classList.toggle('bg-primary', !isChecked); paymentPlanToggle.classList.toggle('bg-gray-300', isChecked); const span = paymentPlanToggle.querySelector('span'); span.classList.toggle('translate-x-5', !isChecked); });

// Coverage Radios
document.querySelectorAll('.coverage-radio').forEach(radio => radio.addEventListener('click', () => { document.querySelectorAll('.coverage-radio').forEach(r => { r.removeAttribute('data-checked'); r.classList.remove('bg-primary', 'border-indigo-600'); r.classList.add('border-gray-400'); }); radio.setAttribute('data-checked', 'true'); radio.classList.add('bg-primary', 'border-indigo-600'); radio.classList.remove('border-gray-400'); }));
document.querySelector('.coverage-radio[data-value="verified"]')?.click();

// Payment Checkboxes
document.querySelectorAll('.payment-checkbox').forEach(cb => { cb.addEventListener('click', () => { const isChecked = cb.getAttribute('data-checked') === 'true'; cb.setAttribute('data-checked', !isChecked); if(!isChecked) { cb.classList.add('bg-primary', 'border-indigo-600'); cb.classList.remove('border-gray-400'); } else { cb.classList.remove('bg-primary', 'border-indigo-600'); cb.classList.add('border-gray-400'); } }); if(cb.getAttribute('data-checked') === 'true') { cb.classList.add('bg-primary', 'border-indigo-600'); cb.classList.remove('border-gray-400'); } });

// Action Buttons
document.getElementById('addItemBtn').addEventListener('click', () => { invoiceItems.push({ id: Date.now(), description: "New Service", qty: 1, unitPrice: 0, additionalDesc: "" }); renderItemsTable(); });
document.getElementById('createInvoiceBtn').addEventListener('click', () => showToast(`Invoice ${document.getElementById('invoiceNumber').value} created successfully for ${selectedPatient?.name}!`));
document.getElementById('saveDraftBtn').addEventListener('click', () => showToast('Invoice saved as draft'));
document.getElementById('previewBtn').addEventListener('click', showPreviewModal);
document.getElementById('taxCalculatorBtn').addEventListener('click', showTaxCalculatorModal);

renderItemsTable();
updateSelectedPatientUI();
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
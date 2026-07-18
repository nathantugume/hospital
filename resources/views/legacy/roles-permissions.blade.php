<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Roles &amp; Permissions</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <style>

        * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        body { scrollbar-width: thin; background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .rounded-lg.border { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted { background-color: #262626 !important; }
        body.dark .border-gray-200, body.dark .border-gray-300 { border-color: #404040 !important; }
        .tab-panel { display: none; }
        .tab-panel.active { display: block; animation: fadeIn 0.2s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }
        .dropdown-animation { animation: fadeInScale 0.12s ease-out; }
        @keyframes fadeInScale { from { opacity: 0; transform: scale(0.96); } to { opacity: 1; transform: scale(1); } }
        .status-badge { display: inline-flex; align-items: center; border-radius: 9999px; padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 600; }
        
/* Modal Overlay */
.modal-overlay {
    position: fixed;
    inset: 0;
    background-color: rgb(0 0 0 / 87%);
    backdrop-filter: blur(4px);
    display: none;  /* Start hidden */
    align-items: center;
    justify-content: center;
    z-index: 9999;
    animation: fadeIn 0.2s ease-out;
}
        
        .modal-content {
            width: 100%;
            max-width: 540px;
            max-height: 85vh;
            overflow-y: auto;
            animation: slideUp 0.2s ease-out;
            border-radius: 0.75rem;
        }
        
        @media (max-width: 640px) {
            .modal-content { max-width: 92%; margin: 0 1rem; }
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Action Menu Popover */
        .action-popover {
            position: fixed;
            z-index: 100;
            min-width: 200px;
            background: white;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
            padding: 0.5rem;
            animation: fadeInScale 0.12s ease-out;
        }
        
        body.dark .action-popover {
            background: #2a2a2a;
            border-color: #404040;
        }
        
        .action-popover-header {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
            margin-bottom: 0.25rem;
        }
        
        body.dark .action-popover-header {
            color: #9ca3af;
            border-bottom-color: #404040;
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
            color: inherit;
        }
        
        .action-item:hover {
            background-color: #f3f4f6;
        }
        
        body.dark .action-item:hover {
            background-color: #3f3f46;
        }
        
        .action-divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 0.25rem 0;
        }
        
        body.dark .action-divider {
            background-color: #404040;
        }
        
        .action-item.text-destructive {
            color: #ef4444;
        }
        
        .action-item.text-destructive:hover {
            background-color: #fee2e2;
        }
        
        body.dark .action-item.text-destructive:hover {
            background-color: #7f1d1d;
            color: #fecaca;
        }
        
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
        
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

                /* Template Modal Styles */
        .template-modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgb(0 0 0 / 87%);
            backdrop-filter: blur(4px);
            z-index: 1100;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.2s ease-out;
        }
        
        .template-modal {
            background: white;
            border-radius: 0.75rem;
            width: 90%;
            max-width: 600px;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: slideUp 0.2s ease-out;
            position: relative;
        }
        
        body.dark .template-modal {
            background: #1e1e2e;
            border-color: #2a2a3a;
        }
        
        .template-modal-header {
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
        
        body.dark .template-modal-header {
            background: #1e1e2e;
            border-bottom-color: #2a2a3a;
        }
        
        .template-modal-title {
            font-size: 1.125rem;
            font-weight: 600;
        }
        
        .template-modal-close {
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
            transition: background 0.1s;
        }
        
        .template-modal-close:hover {
            background-color: #f3f4f6;
            color: #1f2937;
        }
        
        body.dark .template-modal-close:hover {
            background-color: #374151;
            color: #e5e5e5;
        }
        
        .template-modal-body {
            padding: 1.5rem;
        }
        
        .template-modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            position: sticky;
            bottom: 0;
            background: white;
        }
        
        body.dark .template-modal-footer {
            background: #1e1e2e;
            border-top-color: #2a2a3a;
        }
        
        .permission-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }
        
        .permission-table th,
        .permission-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        
        body.dark .permission-table th,
        body.dark .permission-table td {
            border-bottom-color: #2a2a3a;
        }
        
        .permission-table th {
            font-weight: 500;
            color: #6b7280;
        }
        
        body.dark .permission-table th {
            color: #9ca3af;
        }
        
        .permission-check {
            color: #10b981;
        }
        
        .permission-cross {
            color: #ef4444;
        }

    

                /* Create Template Modal Styles */
        .create-template-modal {
            background: white;
            border-radius: 0.75rem;
            width: 90%;
            max-width: 750px;
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            animation: slideUp 0.2s ease-out;
            position: relative;
        }
        
        body.dark .create-template-modal {
            background: #1e1e2e;
        }
        
        .permission-group {
            padding: 1rem;
            margin-bottom: 1rem;
        }
        
        body.dark .permission-group {
            border-color: #2a2a3a;
        }
        
        .permission-group-title {
            font-weight: 500;
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
        }
        
        .permission-checkbox-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
        }
        
        .permission-checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .permission-checkbox-item label {
            font-size: 0.75rem;
            text-transform: capitalize;
            cursor: pointer;
        }
        
        .permission-checkbox-item input {
            width: 1rem;
            height: 1rem;
            cursor: pointer;
            accent-color: #4f46e5;
        }

        

.modal-container {
    background: white;
    border-radius: 0.75rem;
    width: 100%;
    max-width: 500px;
    animation: slideUp 0.2s ease;
    position: relative;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
}
body.dark .modal-container { background: #1e1e1e; border: 1px solid #333; }

.modal-header { 
    padding: 1.25rem 1.5rem; 
    border-bottom: 1px solid #e5e7eb; 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
}
body.dark .modal-header { border-bottom-color: #333; }

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
.modal-body-scrollable { max-height: calc(80vh - 120px); overflow-y: auto; padding-right: 8px; }

.modal-footer { 
    padding: 1rem 1.5rem; 
    border-top: 1px solid #e5e7eb; 
    display: flex; 
    justify-content: flex-end; 
    gap: 0.75rem; 
}
body.dark .modal-footer { border-top-color: #333; }

.btn-cancel { 
    background: transparent; 
    border: 1px solid #d1d5db; 
    padding: 0.5rem 1rem; 
    border-radius: 0.375rem; 
    cursor: pointer; 
    font-size: 0.875rem; 
}
.btn-cancel:hover { background: #f3f4f6; }
body.dark .btn-cancel { border-color: #555; color: #e5e5e5; }
body.dark .btn-cancel:hover { background: #374151; }

.btn-submit { 
    color: white; 
    border: none; 
    padding: 0.5rem 1rem; 
    border-radius: 0.375rem; 
    cursor: pointer; 
    font-size: 0.875rem; 
}

.form-group { margin-bottom: 1rem; }
.form-label { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem; }
.form-input, .form-textarea {
    width: 100%;
    border-radius: 0.375rem;
    border: 1px solid #e5e7eb;
    background-color: white;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    transition: all 0.1s;
}
body.dark .form-input, body.dark .form-textarea { 
    background-color: #262626; 
    border-color: #404040; 
    color: #e5e5e5; 
}
.form-input:focus, .form-textarea:focus { 
    outline: none; 
    border-color: #4f46e5; 
    box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1); 
}

/* Radix Select */
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
}
.radix-select-item:hover { background-color: #f3f4f6; }
body.dark .radix-select-item:hover { background-color: #3f3f46; }
.radix-select-item[data-selected="true"] { background-color: #eef2ff; color: #4f46e5; font-weight: 500; }
body.dark .radix-select-item[data-selected="true"] { background-color: #1e1b4b; color: #818cf8; }
.radix-select-item-indicator { display: none; }
.radix-select-item[data-selected="true"] .radix-select-item-indicator { display: block; }

@keyframes selectSlideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

.bg-primary { background-color: #4f46e5; }
.bg-primary:hover { background-color: #4338ca; }

/* Alert Dialog */
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
    padding-top: 0.5em;
}

body.dark .alert-dialog-footer {
    border-top-color: #333;
}

.alert-dialog-cancel {
    background: transparent;
    border: 1px solid #d1d5db;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    cursor: pointer;
    font-size: 0.875rem;
    color: #374151;
    transition: background 0.1s;
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

.alert-dialog-delete {
    background: #ef4444;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    cursor: pointer;
    font-size: 0.875rem;
    transition: background 0.1s;
}

.alert-dialog-delete:hover {
    background: #dc2626;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0.95);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }
}

/* Tooltip Styles */
.module-info-wrapper {
    position: relative;
    display: inline-flex;
}

.module-info-tooltip {
    position: absolute;
    bottom: calc(100% + 8px);
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
    background: #1f2937;
    color: white;
    padding: 0.375rem 0.75rem;
    border-radius: 0.375rem;
    font-size: 0.75rem;
    white-space: nowrap;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.15s ease;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
}

body.dark .module-info-tooltip {
    background: #e5e5e5;
    color: #1f2937;
}

.module-info-tooltip::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 5px solid transparent;
    border-top-color: #1f2937;
}

body.dark .module-info-tooltip::after {
    border-top-color: #e5e5e5;
}

.module-info-wrapper:hover .module-info-tooltip {
    opacity: 1;
}

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
            <div class="flex flex-col gap-6">
                <div class="flex items-center gap-4 flex-wrap">
<a class="inline-flex items-center justify-center shrink-0 gap-2 rounded-md text-sm font-medium border border-gray-300 bg-background hover:bg-gray-100 size-10" href="staff-management.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-arrow-left h-4 w-4"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg><span class="sr-only">Back</span></a>                    <div><h1 class="text-2xl font-bold">Roles &amp; Permissions</h1><p class="text-sm text-muted-foreground">Manage staff access and security controls</p></div>
                </div>
                
                <!-- Stats Cards -->
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-lg text-card-foreground border bg-white dark:bg-background shadow-sm hover:shadow-md transition"><div class="p-4 md:p-4 xxl:p-6 flex flex-row items-center justify-between space-y-0 pb-2"><h2 class="xl:text-2xl mb-2 tracking-tight text-sm font-medium">Total Roles</h2><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-shield size-8 text-muted-foreground"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path></svg></div><div class="p-4 md:p-4 xxl:p-6"><div class="text-2xl xl:text-4xl mb-2 font-bold" id="totalRolesCount">0</div><p class="text-xs text-muted-foreground">Total roles in system</p></div></div>
                    <div class="rounded-lg text-card-foreground border bg-white dark:bg-background shadow-sm hover:shadow-md transition"><div class="p-4 md:p-4 xxl:p-6 flex flex-row items-center justify-between space-y-0 pb-2"><h2 class="xl:text-2xl mb-2 tracking-tight text-sm font-medium">Staff Assigned</h2><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-users size-8 text-muted-foreground"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg></div><div class="p-4 md:p-4 xxl:p-6"><div class="text-2xl xl:text-4xl mb-2 font-bold">53</div><p class="text-xs text-muted-foreground">Across all roles</p></div></div>
                    <div class="rounded-lg text-card-foreground border bg-white dark:bg-background shadow-sm hover:shadow-md transition"><div class="p-4 md:p-4 xxl:p-6 flex flex-row items-center justify-between space-y-0 pb-2"><h2 class="xl:text-2xl mb-2 tracking-tight text-sm font-medium">Medical Roles</h2><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-user-cog size-8 text-muted-foreground"><circle cx="18" cy="15" r="3"></circle><circle cx="9" cy="7" r="4"></circle><path d="M10 15H6a4 4 0 0 0-4 4v2"></path><path d="m21.7 16.4-.9-.3"></path><path d="m15.2 13.9-.9-.3"></path><path d="m16.6 18.7.3-.9"></path><path d="m19.1 12.2.3-.9"></path><path d="m19.6 18.7-.4-1"></path><path d="m16.8 12.3-.4-1"></path><path d="m14.3 16.6 1-.4"></path><path d="m20.7 13.8 1-.4"></path></svg></div><div class="p-4 md:p-4 xxl:p-6"><div class="text-2xl xl:text-4xl mb-2 font-bold">3</div><p class="text-xs text-muted-foreground">36 staff assigned</p></div></div>
                    <div class="rounded-lg text-card-foreground border bg-white dark:bg-background shadow-sm hover:shadow-md transition"><div class="p-4 md:p-4 xxl:p-6 flex flex-row items-center justify-between space-y-0 pb-2"><h2 class="xl:text-2xl mb-2 tracking-tight text-sm font-medium">Permission Sets</h2><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-file-text size-8 text-muted-foreground"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg></div><div class="p-4 md:p-4 xxl:p-6"><div class="text-2xl xl:text-4xl mb-2 font-bold">8</div><p class="text-xs text-muted-foreground">4 permission types</p></div></div>
                </div>

                <!-- Tabs -->
                <div dir="ltr" data-orientation="horizontal" class="w-full">
                    <div role="tablist" aria-orientation="horizontal" class="inline-flex flex-wrap items-center rounded-md bg-muted p-1 text-muted-foreground" tabindex="0" data-orientation="horizontal" style="outline: none;">
                        <button type="button" role="tab" aria-selected="true" data-state="active" id="tab-roles" class="tab-btn-main inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm" tabindex="-1" data-orientation="horizontal">Roles</button>
                        <button type="button" role="tab" aria-selected="false" id="tab-templates" class="tab-btn-main inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm" tabindex="-1" data-orientation="horizontal">Templates</button>
                        <button type="button" role="tab" aria-selected="false" id="tab-matrix" class="tab-btn-main inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm" tabindex="-1" data-orientation="horizontal">Permission Matrix</button>
                        <button type="button" role="tab" aria-selected="false" id="tab-audit" class="tab-btn-main inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm" tabindex="-1" data-orientation="horizontal">Audit Logs</button>
                    </div>

                    <!-- Roles Tab Content -->
                    <div id="rolesPanel" class="mt-4 space-y-4">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div class="flex items-center gap-2">
                                <div class="relative"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-search absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg><input id="searchRolesInput" class="flex h-10 rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm w-[200px] pl-8 md:w-[300px]" placeholder="Search roles..." type="search"></div>
                            </div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <button id="openAddRoleModalBtn" class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-plus mr-2 h-4 w-4"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>Add Role</button>
                            </div>
                        </div>
                        
                        <!-- Roles Table -->
                        <div class="rounded-lg border text-card-foreground shadow-sm bg-background">
                            <div class="md:p-4 xxl:p-6 p-0">
                                <div class="relative w-full overflow-auto">
                                    <table class="w-full caption-bottom text-sm whitespace-nowrap">
                                        <thead class="[&_tr]:border-b"><tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted"><th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Role Name</th><th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Category</th><th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Description</th><th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Users</th><th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground hidden md:table-cell">Last Updated</th><th class="h-12 px-4 text-right align-middle font-medium text-muted-foreground">Actions</th></tr></thead>
                                            <tbody id="rolesTableBody"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Templates Tab Content -->
                    <div id="templatesPanel" class="mt-4 hidden">
                        <div class="flex items-center flex-wrap gap-3 justify-between">
                            <div class="flex items-center gap-2">
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-search absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg>
                                    <input id="searchTemplatesInput" class="flex h-10 rounded-md border border-input bg-background px-3 py-2 text-base ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium file:text-foreground placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 md:text-sm w-[200px] pl-8 md:w-[300px]" placeholder="Search templates..." type="search">
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button id="createTemplateBtn" class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-plus mr-2 h-4 w-4"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>Create Template</button>
                            </div>
                        </div>
                        <div class="rounded-lg border text-card-foreground shadow-sm bg-background mt-4">
                            <div class="flex flex-col space-y-1.5 p-3 md:p-4 xxl:p-6">
                                <h2 class="text-xl xl:text-2xl font-semibold leading-tight mb-2 tracking-tight">Role Templates</h2>
                                <div class="text-sm text-muted-foreground">Pre-defined role configurations that can be applied to new staff members</div>
                            </div>
                            <div class="p-3 md:p-4 xxl:p-6">
                                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3" id="templatesGrid"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Permission Matrix Tab Content -->
                    <div id="matrixPanel" class="mt-4 hidden">
                        <div class="rounded-lg border text-card-foreground shadow-sm bg-background">
                            <div class="flex flex-col space-y-1.5 p-3 md:p-4 xxl:p-6">
                                <div class="flex items-center flex-wrap gap-3 justify-between">
                                    <div>
                                        <h2 class="text-xl xl:text-2xl font-semibold leading-tight mb-2 tracking-tight">Permission Matrix</h2>
                                        <div class="text-sm text-muted-foreground">Manage permissions for each role across different modules</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button id="exportMatrixBtn" class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-download mr-2 h-4 w-4"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg>Export Matrix</button>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 md:p-4 xxl:p-6">
                                <div class="overflow-x-auto" id="permissionMatrixContainer"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Audit Logs Tab Content -->
                    <div id="auditPanel" class="mt-4 hidden">
<div class="rounded-lg border text-card-foreground shadow-sm bg-background">
    <div class="flex flex-col space-y-1.5 p-3 md:p-4 xxl:p-6">
        <div class="flex items-center justify-between flex-wrap gap-3">
            <div>
                <h2 class="text-xl xl:text-2xl font-semibold leading-tight mb-2 tracking-tight">Permission Audit Logs</h2>
                <div class="text-sm text-muted-foreground">Track changes to roles and permissions</div>
            </div>
            <div class="flex items-center gap-2">
                <button id="exportAuditBtn" class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&amp;_svg]:pointer-events-none [&amp;_svg]:size-4 [&amp;_svg]:shrink-0 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3">
                    <svg class="lucide lucide-download mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg>
                    Export Logs
                </button>
            </div>
        </div>
    </div>
    <div class="p-3 md:p-4 xxl:p-6">
        <div class="rounded-md border">
            <div class="relative w-full overflow-auto">
                <table class="w-full caption-bottom text-sm whitespace-nowrap">
                    <thead class="[&amp;_tr]:border-b">
                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Timestamp</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">User</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Action</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Role</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Module</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Permission</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Old Value</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">New Value</th>
                            <th class="h-12 px-4 align-middle font-medium text-muted-foreground text-right">IP Address</th>
                        </tr>
                    </thead>
                    <tbody id="auditLogsBody" class="[&amp;_tr:last-child]:border-0 whitespace-nowrap">
                        <!-- Sample Audit Log Entries -->
                        <tr class="border-b transition-colors hover:bg-muted/50">
                            <td class="p-4 align-middle text-xs">2024-04-15 09:23:45</td>
                            <td class="p-4 align-middle"><div class="flex items-center gap-2"><span>Dr. Nakato Sarah</span></div></td>
                            <td class="p-4 align-middle"><div class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold bg-blue-100 text-blue-700">Permission Added</div></td>
                            <td class="p-4 align-middle">Administrator</td>
                            <td class="p-4 align-middle">Reports</td>
                            <td class="p-4 align-middle">delete</td>
                            <td class="p-4 align-middle"><span class="text-gray-400">-</span></td>
                            <td class="p-4 align-middle"><span class="text-green-600">✓ Granted</span></td>
                            <td class="p-4 align-middle text-right text-xs text-gray-400">192.168.1.100</td>
                        </tr>
                        <tr class="border-b transition-colors hover:bg-muted/50">
                            <td class="p-4 align-middle text-xs">2024-04-14 14:12:30</td>
                            <td class="p-4 align-middle"><div class="flex items-center gap-2"><span>Dr. Mwangi Peter</span></div></td>
                            <td class="p-4 align-middle"><div class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold bg-red-100 text-red-700">Permission Removed</div></td>
                            <td class="p-4 align-middle">Doctor</td>
                            <td class="p-4 align-middle">Billing</td>
                            <td class="p-4 align-middle">edit</td>
                            <td class="p-4 align-middle"><span class="text-green-600">✓ Granted</span></td>
                            <td class="p-4 align-middle"><span class="text-red-600">✗ Revoked</span></td>
                            <td class="p-4 align-middle text-right text-xs text-gray-400">192.168.1.102</td>
                        </tr>
                        <tr class="border-b transition-colors hover:bg-muted/50">
                            <td class="p-4 align-middle text-xs">2024-04-10 11:05:22</td>
                            <td class="p-4 align-middle"><div class="flex items-center gap-2"><span>Dr. Nakato Sarah</span></div></td>
                            <td class="p-4 align-middle"><div class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-700">Role Created</div></td>
                            <td class="p-4 align-middle">Senior Doctor</td>
                            <td class="p-4 align-middle">All</td>
                            <td class="p-4 align-middle">N/A</td>
                            <td class="p-4 align-middle"><span class="text-gray-400">-</span></td>
                            <td class="p-4 align-middle"><span class="text-blue-600">New Role</span></td>
                            <td class="p-4 align-middle text-right text-xs text-gray-400">192.168.1.100</td>
                        </tr>
                        <tr class="border-b transition-colors hover:bg-muted/50">
                            <td class="p-4 align-middle text-xs">2024-04-08 16:45:10</td>
                            <td class="p-4 align-middle"><div class="flex items-center gap-2"><span>Namyalo Emma</span></div></td>
                            <td class="p-4 align-middle"><div class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold bg-blue-100 text-blue-700">Permission Added</div></td>
                            <td class="p-4 align-middle">Nurse</td>
                            <td class="p-4 align-middle">Patients</td>
                            <td class="p-4 align-middle">edit</td>
                            <td class="p-4 align-middle"><span class="text-gray-400">-</span></td>
                            <td class="p-4 align-middle"><span class="text-green-600">✓ Granted</span></td>
                            <td class="p-4 align-middle text-right text-xs text-gray-400">192.168.1.105</td>
                        </tr>
                        <tr class="border-b transition-colors hover:bg-muted/50">
                            <td class="p-4 align-middle text-xs">2024-04-05 10:30:15</td>
                            <td class="p-4 align-middle"><div class="flex items-center gap-2"><span>System Admin</span></div></td>
                            <td class="p-4 align-middle"><div class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold bg-red-100 text-red-700">Permission Removed</div></td>
                            <td class="p-4 align-middle">Receptionist</td>
                            <td class="p-4 align-middle">Billing</td>
                            <td class="p-4 align-middle">create</td>
                            <td class="p-4 align-middle"><span class="text-green-600">✓ Granted</span></td>
                            <td class="p-4 align-middle"><span class="text-red-600">✗ Revoked</span></td>
                            <td class="p-4 align-middle text-right text-xs text-gray-400">127.0.0.1</td>
                        </tr>
                        <tr class="border-b transition-colors hover:bg-muted/50">
                            <td class="p-4 align-middle text-xs">2024-04-03 09:15:30</td>
                            <td class="p-4 align-middle"><div class="flex items-center gap-2"><span>Dr. Nakato Sarah</span></div></td>
                            <td class="p-4 align-middle"><div class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold bg-blue-100 text-blue-700">Permission Added</div></td>
                            <td class="p-4 align-middle">Department Head</td>
                            <td class="p-4 align-middle">Settings</td>
                            <td class="p-4 align-middle">view</td>
                            <td class="p-4 align-middle"><span class="text-gray-400">-</span></td>
                            <td class="p-4 align-middle"><span class="text-green-600">✓ Granted</span></td>
                            <td class="p-4 align-middle text-right text-xs text-gray-400">192.168.1.100</td>
                        </tr>
                        <tr class="border-b transition-colors hover:bg-muted/50">
                            <td class="p-4 align-middle text-xs">2024-04-01 14:20:00</td>
                            <td class="p-4 align-middle"><div class="flex items-center gap-2"><span>Dr. Mwangi Peter</span></div></td>
                            <td class="p-4 align-middle"><div class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold bg-orange-100 text-orange-700">Role Modified</div></td>
                            <td class="p-4 align-middle">Doctor</td>
                            <td class="p-4 align-middle">Appointments</td>
                            <td class="p-4 align-middle">delete</td>
                            <td class="p-4 align-middle"><span class="text-green-600">✓ Granted</span></td>
                            <td class="p-4 align-middle"><span class="text-red-600">✗ Revoked</span></td>
                            <td class="p-4 align-middle text-right text-xs text-gray-400">192.168.1.102</td>
                        </tr>
                    </tbody>
                </td>
            </div>
        </div>
    </div>
</div>
                    </div>
                </div>
            </div>
        </main>
    </div>

<!-- CREATE ROLE MODAL -->
<div id="createRoleModal" class="modal-overlay" style="display: none;">
    <div class="modal-container" style="max-width: 500px;">
        <div class="modal-header">
            <h2 class="modal-title">Create New Role</h2>
            <button class="modal-close" id="modalCloseIcon">&times;</button>
        </div>
        <div class="modal-body modal-body-scrollable">
            <div class="form-group">
                <label class="form-label">Role Name</label>
                <input id="newRoleName" class="form-input" placeholder="Enter role name">
            </div>
            <div class="form-group">
                <label class="form-label">Category</label>
                <div class="radix-select" id="roleCategoryRadixSelect">
                    <button type="button" class="radix-select-trigger" data-value="Medical">
                        <span>Medical</span>
                        <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"></path></svg>
                    </button>
                    <div class="radix-select-content hidden">
                        <div class="radix-select-item" data-value="Medical" data-selected="true">Medical<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                        <div class="radix-select-item" data-value="Administrative">Administrative<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                        <div class="radix-select-item" data-value="Custom">Custom<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"></polyline></svg></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea id="newRoleDesc" rows="3" class="form-textarea" placeholder="Enter role description"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button id="closeModalBtn" class="btn-cancel">Cancel</button>
            <button id="confirmCreateRoleBtn" class="btn-submit bg-primary hover:bg-primary/90">Create Role</button>
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

        

        
// Roles Data
let roles = [
    { id: 1, name: "Administrator", category: "Administrative", description: "Full system access with all permissions", users: 3, lastUpdated: "2023-11-15", isDefault: true },
    { id: 2, name: "Doctor", category: "Medical", description: "Access to patient records, appointments, prescriptions", users: 12, lastUpdated: "2023-10-22", isDefault: true },
    { id: 3, name: "Nurse", category: "Medical", description: "Limited access to patient records and appointments", users: 18, lastUpdated: "2023-09-30", isDefault: true },
    { id: 4, name: "Senior Doctor", category: "Custom", description: "Extended permissions for senior medical staff", users: 3, lastUpdated: "2023-11-10", isDefault: false },
    { id: 5, name: "Department Head", category: "Custom", description: "Management role for department leaders", users: 2, lastUpdated: "2023-11-08", isDefault: false }
];

let currentRoleId = 5;
let activeMenu = null;

// Templates Data
let templates = [
    { id: 1, name: "Medical Director", category: "Medical", description: "Full access to all medical functions with administrative oversight", permissions: ["dashboard", "patients", "appointments", "billing", "reports", "settings"] },
    { id: 2, name: "Head Nurse", category: "Medical", description: "Supervises nursing staff and manages patient care", permissions: ["dashboard", "patients", "appointments", "billing", "reports", "settings"] },
    { id: 3, name: "Finance Manager", category: "Administrative", description: "Manages financial operations and billing", permissions: ["dashboard", "patients", "appointments", "billing", "reports", "settings"] },
    { id: 4, name: "IT Administrator", category: "Administrative", description: "Manages system settings and user access", permissions: ["dashboard", "patients", "appointments", "billing", "reports", "settings"] },
    { id: 5, name: "Front Desk Coordinator", category: "Administrative", description: "Manages appointments and patient registration", permissions: ["dashboard", "patients", "appointments", "billing", "reports"] }
];

// Audit Logs Data
let auditLogs = [
    { timestamp: "2023-11-15 09:23:45", role: "Administrator", action: "Permission Added", module: "Reports", permission: "delete", user: "System Admin" },
    { timestamp: "2023-11-14 14:12:30", role: "Doctor", action: "Permission Removed", module: "Billing", permission: "edit", user: "Dr. Nakato Sarah" },
    { timestamp: "2023-11-10 11:05:22", role: "Senior Doctor", action: "Role Created", module: "All", permission: "N/A", user: "Dr. Nakato Sarah" },
    { timestamp: "2023-11-08 16:45:10", role: "Nurse", action: "Permission Added", module: "Patients", permission: "edit", user: "Dr. Mwangi Peter" },
    { timestamp: "2023-11-05 10:30:15", role: "Receptionist", action: "Permission Removed", module: "Billing", permission: "create", user: "System Admin" }
];

// Helper Functions
function showToast(message, isError = false) {
    const existing = document.querySelector('.toast-message');
    if (existing) existing.remove();
    const toast = document.createElement('div');
    toast.className = `toast-message ${isError ? 'error' : ''}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}

function escapeHtml(str) {
    if (!str) return '';
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

function closeMenu() {
    if (activeMenu) {
        activeMenu.remove();
        activeMenu = null;
    }
}

// Delete Confirmation Modal
function showDeleteModal(role) {
    closeMenu();
    
    // Remove any existing delete modal
    const existingModal = document.getElementById('deleteRoleModal');
    if (existingModal) existingModal.remove();
    
    // Create overlay
    const overlay = document.createElement('div');
    overlay.id = 'deleteRoleModalOverlay';
    overlay.style.cssText = 'position:fixed;inset:0;background:rgb(0 0 0 / 87%);backdrop-filter:blur(4px);z-index:9999;';
    
    // Create dialog
    const dialog = document.createElement('div');
    dialog.className = 'alert-dialog';
    dialog.setAttribute('role', 'alertdialog');
    dialog.innerHTML = `
        <div class="alert-dialog-header">
            <h2 id="deleteModalTitle" class="alert-dialog-title">Are you sure you want to delete this role?</h2>
            <p id="deleteModalDesc" class="alert-dialog-description">
                This action cannot be undone. The role <strong>"${escapeHtml(role.name)}"</strong> and its permissions will be permanently removed.
            </p>
        </div>
        <div class="alert-dialog-footer">
            <button type="button" id="deleteModalCancel" class="alert-dialog-cancel">Cancel</button>
            <button type="button" id="deleteModalConfirm" class="alert-dialog-delete">Delete</button>
        </div>
    `;
    
    overlay.appendChild(dialog);
    document.body.appendChild(overlay);
    document.body.style.overflow = 'hidden';
    
    function closeModal() {
        overlay.remove();
        document.body.style.overflow = '';
    }
    
    // Close on overlay click
    overlay.addEventListener('click', function(e) { 
        if (e.target === overlay) closeModal(); 
    });
    
    // Prevent dialog click from closing
    dialog.addEventListener('click', function(e) {
        e.stopPropagation();
    });
    
    // Button handlers
    document.getElementById('deleteModalCancel').onclick = closeModal;
    document.getElementById('deleteModalConfirm').onclick = function() {
        const index = roles.findIndex(r => r.id === role.id);
        if (index !== -1) {
            const deletedName = roles[index].name;
            roles.splice(index, 1);
            renderRolesTable();
            updateTotalRolesCount();
            closeModal();
            showToast('Role "' + deletedName + '" deleted successfully');
        } else {
            closeModal();
            showToast('Role not found', true);
        }
    };
    
    // Escape key
    document.addEventListener('keydown', function escHandler(e) {
        if (e.key === 'Escape') {
            closeModal();
            document.removeEventListener('keydown', escHandler);
        }
    });
}

function cloneRole(role) {
    closeMenu();
    currentRoleId++;
    const newRole = {
        id: currentRoleId,
        name: `${role.name} (Copy)`,
        category: role.category,
        description: `${role.description} (Cloned)`,
        users: 0,
        lastUpdated: new Date().toISOString().slice(0, 10),
        isDefault: false
    };
    roles.push(newRole);
    renderRolesTable();
    updateTotalRolesCount();
    showToast(`Role "${newRole.name}" created successfully`);
}

function showActionMenu(btn, role) {
    closeMenu();
    const rect = btn.getBoundingClientRect();
    const menu = document.createElement('div');
    menu.className = 'action-popover';
    
    let left = rect.left;
    let top = rect.bottom + 6;
    if (left + 220 > window.innerWidth) left = window.innerWidth - 230;
    if (top + 280 > window.innerHeight) top = rect.top - 280;
    
    menu.style.top = `${top}px`;
    menu.style.left = `${left}px`;
    
    menu.innerHTML = `
        <div class="action-popover-header">Actions</div>
        <button data-action="view" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>View Details</button>
        <button data-action="edit" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"></path></svg>Edit Role</button>
        <button data-action="users" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>View Users</button>
        <button data-action="clone" class="action-item"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>Clone Role</button>
        <div class="action-divider"></div>
        <button data-action="delete" class="action-item text-destructive"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>Delete Role</button>
    `;
    
    document.body.appendChild(menu);
    activeMenu = menu;
    
    const closeHandler = (e) => {
        if (!menu.contains(e.target) && e.target !== btn) {
            closeMenu();
            document.removeEventListener('click', closeHandler);
        }
    };
    setTimeout(() => document.addEventListener('click', closeHandler), 10);
    
    menu.querySelector('[data-action="view"]')?.addEventListener('click', () => window.location.href = `role-details.html?id=${role.id}`);
    menu.querySelector('[data-action="edit"]')?.addEventListener('click', () => window.location.href = `edit-roles-permissions.html?id=${role.id}`);
    menu.querySelector('[data-action="users"]')?.addEventListener('click', () => window.location.href = `role-users.html?id=${role.id}`);
    menu.querySelector('[data-action="clone"]')?.addEventListener('click', () => cloneRole(role));
    menu.querySelector('[data-action="delete"]')?.addEventListener('click', () => showDeleteModal(role));
}

function renderRolesTable() {
    const tbody = document.getElementById('rolesTableBody');
    const searchQuery = document.getElementById('searchRolesInput')?.value.toLowerCase() || '';
    if (!tbody) return;
    
    let filteredRoles = [...roles];
    if (searchQuery) {
        filteredRoles = roles.filter(role => 
            role.name.toLowerCase().includes(searchQuery) || 
            role.category.toLowerCase().includes(searchQuery) ||
            role.description.toLowerCase().includes(searchQuery)
        );
    }
    
    tbody.innerHTML = filteredRoles.map(role => `
        <tr class="border-b transition-colors hover:bg-muted/50" data-role-id="${role.id}">
            <td class="p-4 align-middle font-medium">${escapeHtml(role.name)}${role.isDefault ? '<span class="inline-flex items-center rounded-full border px-1.5 md:px-2.5 py-0.5 text-xs font-semibold ml-2">Default</span>' : ''}</td>
            <td class="p-4 align-middle">${escapeHtml(role.category)}</td>
            <td class="p-4 align-middle max-w-xs truncate">${escapeHtml(role.description)}</td>
            <td class="p-4 align-middle">${role.users}</td>
            <td class="p-4 align-middle hidden md:table-cell">${role.lastUpdated}</td>
            <td class="p-4 align-middle text-right">
                <button data-role-id="${role.id}" class="role-action-btn inline-flex items-center justify-center rounded-md hover:bg-accent hover:text-accent-foreground size-8">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                </button>
            </td>
        </tr>
    `).join('');
    
    document.querySelectorAll('.role-action-btn').forEach(btn => {
        const roleId = parseInt(btn.dataset.roleId);
        const role = roles.find(r => r.id === roleId);
        if (role) {
            const newBtn = btn.cloneNode(true);
            btn.parentNode.replaceChild(newBtn, btn);
            newBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                showActionMenu(newBtn, role);
            });
        }
    });
}

function renderTemplates() {
    const container = document.getElementById('templatesGrid');
    if (!container) return;
    
    const searchQuery = document.getElementById('searchTemplatesInput')?.value.toLowerCase() || '';
    let filteredTemplates = templates;
    if (searchQuery) {
        filteredTemplates = templates.filter(t => 
            t.name.toLowerCase().includes(searchQuery) || 
            t.category.toLowerCase().includes(searchQuery) ||
            t.description.toLowerCase().includes(searchQuery)
        );
    }
    
    container.innerHTML = filteredTemplates.map(template => `
        <div class="rounded-lg border text-card-foreground shadow-sm bg-background">
            <div class="flex flex-col space-y-1.5 p-3 md:p-4 xxl:p-6 pb-2">
                <div class="flex items-center justify-between">
                    <h2 class="xl:text-2xl font-semibold mb-2 tracking-tight text-base">${escapeHtml(template.name)}</h2>
                    <div class="inline-flex items-center rounded-full border px-1.5 whitespace-nowrap md:px-2.5 py-0.5 text-xs font-semibold">${escapeHtml(template.category)}</div>
                </div>
                <div class="text-sm text-muted-foreground line-clamp-2">${escapeHtml(template.description)}</div>
            </div>
            <div class="p-3 md:p-4 xxl:p-6 pb-2">
                <div class="flex flex-wrap gap-1">
                    ${template.permissions.map(perm => `<div class="inline-flex items-center rounded-full border px-1.5 whitespace-nowrap md:px-2.5 py-0.5 font-semibold border-transparent bg-secondary text-secondary-foreground hover:bg-secondary/80 text-xs">${perm}</div>`).join('')}
                </div>
            </div>
            <div class="items-center p-3 md:p-4 xxl:p-6 !pt-0 flex justify-between flex-wrap gap-3">
                <button class="template-view-btn inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3" data-template-id="${template.id}">
                    <svg class="lucide lucide-file-text mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path><path d="M14 2v4a2 2 0 0 0 2 2h4"></path><path d="M10 9H8"></path><path d="M16 13H8"></path><path d="M16 17H8"></path></svg>View Details
                </button>
                <div>
                    <button class="template-clone-btn inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 mr-2" data-template-id="${template.id}">
                        <svg class="lucide lucide-copy mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"></rect><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"></path></svg>Clone
                    </button>
                    <button class="template-apply-btn inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-9 rounded-md px-3" data-template-id="${template.id}">
                        <svg class="lucide lucide-shield-check mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path><path d="m9 12 2 2 4-4"></path></svg>Apply
                    </button>
                </div>
            </div>
        </div>
    `).join('');
    
    if (filteredTemplates.length > 0) {
        container.innerHTML += `
            <div class="rounded-lg border text-card-foreground shadow-sm bg-background border-dashed flex flex-col items-center justify-center p-6">
                <div class="rounded-full bg-muted p-3 mb-3">
                    <svg class="lucide lucide-user-plus h-6 w-6 text-muted-foreground" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><line x1="19" x2="19" y1="8" y2="14"></line><line x1="22" x2="16" y1="11" y2="11"></line></svg>
                </div>
                <h3 class="text-lg font-medium mb-1">Create Template</h3>
                <p class="text-sm text-muted-foreground text-center mb-4">Define a new role template with custom permissions</p>
                <button id="createTemplateFromCardBtn" class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">Create New Template</button>
            </div>
        `;
    }
}

// Additional fallback for dynamically created buttons
function ensureTemplateButtonsWork() {
    const cardBtn = document.getElementById('createTemplateFromCardBtn');
    if (cardBtn && !cardBtn.hasAttribute('data-listener-added')) {
        cardBtn.setAttribute('data-listener-added', 'true');
        const newBtn = cardBtn.cloneNode(true);
        cardBtn.parentNode.replaceChild(newBtn, cardBtn);
        newBtn.addEventListener('click', () => {
            showCreateTemplateModal();
        });
    }
}

// Call this after renderTemplates and also set up a MutationObserver for dynamic changes
const observer = new MutationObserver(() => {
    ensureTemplateButtonsWork();
});
observer.observe(document.getElementById('templatesGrid'), { childList: true, subtree: true });


// Module tooltip descriptions
const moduleTooltips = {
    'dashboard': 'View and access dashboard analytics',
    'patients': 'Manage patient records and information',
    'appointments': 'Scheduling and appointment management',
    'billing': 'Invoice and payment processing',
    'reports': 'Generate and view system reports',
    'settings': 'System configuration and preferences',
    'inventory': 'Manage stock and supplies',
    'staff': 'Staff management and administration'
};

function renderPermissionMatrix() {
    const container = document.getElementById('permissionMatrixContainer');
    if (!container) return;
    
    const modules = ['Dashboard', 'Patients', 'Appointments', 'Billing', 'Reports', 'Settings', 'Inventory', 'Staff'];
    const roleColumns = ['Administrator', 'Doctor', 'Nurse', 'Receptionist', 'Billing Staff', 'Lab Technician', 'Senior Doctor', 'Department Head'];
    const actions = ['view', 'create', 'edit', 'delete'];
    
    let tableHtml = `
        <div class="relative w-full overflow-auto">
            <table class="w-full caption-bottom text-sm whitespace-nowrap">
                <thead class="[&_tr]:border-b">
                    <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                        <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0 w-[200px]">Module / Role</th>
                        ${roleColumns.map(role => `<th class="h-12 px-4 align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0 text-center">${role}</th>`).join('')}
                    </tr>
                </thead>
                <tbody class="[&_tr:last-child]:border-0 whitespace-nowrap">
    `;
    
    modules.forEach((module, moduleIndex) => {
        const moduleLower = module.toLowerCase();
        tableHtml += `
            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0 font-medium">
                    <div class="flex items-center justify-between">
                        <span>${module}</span>
<span class="module-info-wrapper">
    <button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground size-10 h-6 w-6" data-state="closed">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="accordion-arrowlucide lucide-info h-4 w-4">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M12 16v-4"></path>
            <path d="M12 8h.01"></path>
        </svg>
    </button>
    <span class="module-info-tooltip">${moduleTooltips[moduleLower] || 'Manage permissions for this module'}</span>
</span>
                    </div>
                </td>
        `;
        
        roleColumns.forEach((role, roleIndex) => {
            const isAdmin = role === 'Administrator';
            const isSeniorDoctor = role === 'Senior Doctor';
            const isDoctor = role === 'Doctor';
            const isDepartmentHead = role === 'Department Head';
            
            // Determine checked states based on role
            const viewChecked = true; // Everyone has view
            const createChecked = isAdmin || isDepartmentHead;
            const editChecked = isAdmin || isDoctor || isSeniorDoctor || isDepartmentHead;
            const deleteChecked = isAdmin;
            
            const actionStates = [viewChecked, createChecked, editChecked, deleteChecked];
            
            tableHtml += `
                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0 text-center">
                    <div class="flex flex-col items-left gap-3">
            `;
            
            actions.forEach((action, actionIdx) => {
                const isChecked = actionStates[actionIdx];
                const actionId = `${moduleLower}-${roleIndex + 1}-${action}`;
                const checkedAttr = isChecked ? 'checked' : '';
                const stateAttr = isChecked ? 'checked' : 'unchecked';
                const bgClass = isChecked ? 'bg-primary text-primary-foreground' : '';
                
                tableHtml += `
                        <div class="flex items-center gap-1">
                            <button type="button" role="checkbox" aria-checked="${isChecked}" data-state="${stateAttr}" value="on" class="peer h-4 w-4 shrink-0 rounded-sm border border-primary ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 data-[state=${stateAttr}]:bg-primary data-[state=${stateAttr}]:text-primary-foreground permission-checkbox" id="${actionId}" data-module="${moduleLower}" data-role="${roleIndex}" data-action="${action}">
                                ${isChecked ? '<span data-state="checked" class="flex items-center justify-center text-current" style="pointer-events: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-check h-4 w-4"><path d="M20 6 9 17l-5-5"></path></svg></span>' : ''}
                            </button>
                            <label class="font-medium peer-disabled:cursor-not-allowed peer-disabled:opacity-70 text-xs capitalize" for="${actionId}">${action}</label>
                        </div>
                `;
            });
            
            tableHtml += `
                    </div>
                </td>
            `;
        });
        
        tableHtml += `</tr>`;
    });
    
    tableHtml += `
                </tbody>
            </table>
        </div>
    `;
    
    container.innerHTML = tableHtml;
    
    // Add click handlers for checkboxes
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.addEventListener('click', function(e) {
            e.stopPropagation();
            const isChecked = this.getAttribute('aria-checked') === 'true';
            const newState = !isChecked;
            
            this.setAttribute('aria-checked', newState);
            this.setAttribute('data-state', newState ? 'checked' : 'unchecked');
            
            if (newState) {
                this.innerHTML = '<span data-state="checked" class="flex items-center justify-center text-current" style="pointer-events: none;"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-check h-4 w-4"><path d="M20 6 9 17l-5-5"></path></svg></span>';
                if (newState) this.classList.add('bg-primary', 'text-primary-foreground');
            } else {
                this.innerHTML = '';
                if (!newState) this.classList.remove('bg-primary', 'text-primary-foreground');
            }
            
            const moduleName = this.dataset.module;
            const action = this.dataset.action;
            showToast(`${moduleName} - ${action} permission ${newState ? 'granted' : 'revoked'}`);
        });
    });
    
}

function renderAuditLogs() {
    const tbody = document.getElementById('auditLogsBody');
    if (!tbody) return;
    
    const getActionClass = (action) => {
        if (action === 'Permission Added') return 'bg-blue-100 text-blue-700';
        if (action === 'Permission Removed') return 'bg-red-100 text-red-700';
        if (action === 'Role Created') return 'bg-green-100 text-green-700';
        if (action === 'Role Modified') return 'bg-orange-100 text-orange-700';
        if (action === 'Role Deleted') return 'bg-red-100 text-red-700';
        return 'bg-gray-100 text-gray-700';
    };
    
    const getUserInitials = (userName) => {
        // Remove titles like Dr., Mr., Mrs., Ms., etc.
        let cleanName = userName.replace(/^(Dr\.|Mr\.|Mrs\.|Ms\.|Prof\.)\s*/i, '');
        // Split by space and take first letter of each part
        const parts = cleanName.split(' ');
        if (parts.length === 1) {
            // Single name - take first 2 letters or just first letter
            return parts[0].substring(0, 2).toUpperCase();
        }
        // Take first letter of first name and first letter of last name
        return (parts[0].charAt(0) + parts[parts.length - 1].charAt(0)).toUpperCase();
    };
    
    const getUserColor = (userName) => {
        const colors = ['indigo', 'green', 'purple', 'yellow', 'blue', 'pink'];
        const index = userName.length % colors.length;
        return colors[index];
    };
    
    const auditLogsData = [
        { timestamp: "2024-04-15 09:23:45", user: "Nakato Sarah", action: "Permission Added", role: "Administrator", module: "Reports", permission: "delete", oldValue: "-", newValue: "Granted", ip: "192.168.1.100" },
        { timestamp: "2024-04-14 14:12:30", user: "Mwangi Peter", action: "Permission Removed", role: "Doctor", module: "Billing", permission: "edit", oldValue: "Granted", newValue: "Revoked", ip: "192.168.1.102" },
        { timestamp: "2024-04-10 11:05:22", user: "Nakato Sarah", action: "Role Created", role: "Senior Doctor", module: "All", permission: "N/A", oldValue: "-", newValue: "New Role", ip: "192.168.1.100" },
        { timestamp: "2024-04-08 16:45:10", user: "Namyalo Emma", action: "Permission Added", role: "Nurse", module: "Patients", permission: "edit", oldValue: "-", newValue: "Granted", ip: "192.168.1.105" },
        { timestamp: "2024-04-05 10:30:15", user: "System Admin", action: "Permission Removed", role: "Receptionist", module: "Billing", permission: "create", oldValue: "Granted", newValue: "Revoked", ip: "127.0.0.1" },
        { timestamp: "2024-04-03 09:15:30", user: "Nakato Sarah", action: "Permission Added", role: "Department Head", module: "Settings", permission: "view", oldValue: "-", newValue: "Granted", ip: "192.168.1.100" },
        { timestamp: "2024-04-01 14:20:00", user: "Mwangi Peter", action: "Role Modified", role: "Doctor", module: "Appointments", permission: "delete", oldValue: "Granted", newValue: "Revoked", ip: "192.168.1.102" }
    ];
    
    tbody.innerHTML = auditLogsData.map(log => {
        const color = getUserColor(log.user);
        const initials = getUserInitials(log.user);
        const oldValueClass = log.oldValue === 'Granted' ? 'text-green-600' : (log.oldValue === 'Revoked' ? 'text-red-600' : 'text-gray-400');
        const newValueClass = log.newValue === 'Granted' ? 'text-green-600' : (log.newValue === 'Revoked' ? 'text-red-600' : (log.newValue === 'New Role' ? 'text-blue-600' : 'text-gray-600'));
        
        return `
            <tr class="border-b transition-colors hover:bg-muted/50">
                <td class="p-4 align-middle text-xs">${log.timestamp}</td>
                <td class="p-4 align-middle">
                    <div class="flex items-center gap-2">
                        <span>${escapeHtml(log.user)}</span>
                    </div>
                </td>
                <td class="p-4 align-middle">
                    <div class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold ${getActionClass(log.action)}">${log.action}</div>
                </td>
                <td class="p-4 align-middle">${escapeHtml(log.role)}</td>
                <td class="p-4 align-middle">${escapeHtml(log.module)}</td>
                <td class="p-4 align-middle">${escapeHtml(log.permission)}</td>
                <td class="p-4 align-middle"><span class="${oldValueClass}">${log.oldValue === '-' ? '—' : (log.oldValue === 'Granted' ? '✓ Granted' : '✗ Revoked')}</span></td>
                <td class="p-4 align-middle"><span class="${newValueClass}">${log.newValue === '-' ? '—' : (log.newValue === 'Granted' ? '✓ Granted' : (log.newValue === 'Revoked' ? '✗ Revoked' : 'New Role'))}</span></td>
                <td class="p-4 align-middle text-right text-xs text-gray-400">${log.ip}</td>
            </tr>
        `;
    }).join('');
}

function updateTotalRolesCount() {
    const countElement = document.getElementById('totalRolesCount');
    if (countElement) countElement.textContent = roles.length;
}

function initTabs() {
    const tabButtons = document.querySelectorAll('.tab-btn-main');
    const panels = {
        'roles': document.getElementById('rolesPanel'),
        'templates': document.getElementById('templatesPanel'),
        'permission matrix': document.getElementById('matrixPanel'), // Match button text
        'audit logs': document.getElementById('auditPanel')         // Match button text
    };
    
    function activateTab(tabId) {
        // Hide all panels first
        Object.values(panels).forEach(panel => {
            if (panel) panel.classList.add('hidden');
        });
        
        // Show the selected panel
        const activePanel = panels[tabId];
        if (activePanel) activePanel.classList.remove('hidden');
        
        // Update button states
        tabButtons.forEach((btn) => {
            const btnText = btn.textContent.toLowerCase();
            if (btnText === tabId) {
                btn.setAttribute('aria-selected', 'true');
                btn.setAttribute('data-state', 'active');
            } else {
                btn.setAttribute('aria-selected', 'false');
                btn.setAttribute('data-state', 'inactive');
            }
        });
    }
    
    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const tabText = btn.textContent.toLowerCase();
            activateTab(tabText);
            
            // Trigger specific renders
            if (tabText === 'templates') renderTemplates();
            if (tabText === 'permission matrix') renderPermissionMatrix();
            if (tabText === 'audit logs') renderAuditLogs();
        });
    });
    
    activateTab('roles');
}

function initModal() {
    // Remove the existing modal from DOM if it exists
    const existingModal = document.getElementById('createRoleModal');
    if (existingModal) existingModal.remove();
    
    // Create modal dynamically
    function openModal() {
        // Remove any existing instance
        const oldModal = document.getElementById('createRoleModal');
        if (oldModal) oldModal.remove();
        
        const modal = document.createElement('div');
        modal.id = 'createRoleModal';
        modal.style.cssText = 'position:fixed;inset:0;background:rgb(0 0 0 / 87%);backdrop-filter:blur(4px);display:flex;align-items:center;justify-content:center;z-index:99999;';
        
        modal.innerHTML = `
            <div style="background:white;border-radius:0.75rem;width:100%;max-width:500px;box-shadow:0 25px 50px -12px rgba(0,0,0,0.25);animation:slideUp 0.2s ease;">
                <div style="padding:1.25rem 1.5rem;border-bottom:1px solid #e5e7eb;display:flex;justify-content:space-between;align-items:center;">
                    <h2 style="font-size:1.125rem;font-weight:600;margin:0;">Create New Role</h2>
                    <button id="modalCloseIconDynamic" style="background:transparent;border:none;font-size:1.5rem;cursor:pointer;color:#6b7280;width:28px;height:28px;display:flex;align-items:center;justify-content:center;border-radius:0.375rem;">&times;</button>
                </div>
                <div style="padding:1.5rem;max-height:calc(80vh - 120px);overflow-y:auto;">
                    <div style="margin-bottom:1rem;">
                        <label style="display:block;font-size:0.875rem;font-weight:500;margin-bottom:0.5rem;">Role Name</label>
                        <input id="newRoleNameDynamic" style="width:100%;border-radius:0.375rem;border:1px solid #e5e7eb;padding:0.5rem 0.75rem;font-size:0.875rem;" placeholder="Enter role name">
                    </div>
                    <div style="margin-bottom:1rem;">
                        <label style="display:block;font-size:0.875rem;font-weight:500;margin-bottom:0.5rem;">Category</label>
                        <select id="newRoleCategoryDynamic" style="width:100%;border-radius:0.375rem;border:1px solid #e5e7eb;padding:0.5rem 0.75rem;font-size:0.875rem;background:white;">
                            <option value="Medical">Medical</option>
                            <option value="Administrative">Administrative</option>
                            <option value="Custom">Custom</option>
                        </select>
                    </div>
                    <div style="margin-bottom:1rem;">
                        <label style="display:block;font-size:0.875rem;font-weight:500;margin-bottom:0.5rem;">Description</label>
                        <textarea id="newRoleDescDynamic" rows="3" style="width:100%;border-radius:0.375rem;border:1px solid #e5e7eb;padding:0.5rem 0.75rem;font-size:0.875rem;" placeholder="Enter role description"></textarea>
                    </div>
                </div>
                <div style="padding:1rem 1.5rem;border-top:1px solid #e5e7eb;display:flex;justify-content:flex-end;gap:0.75rem;">
                    <button id="closeModalBtnDynamic" style="background:transparent;border:1px solid #d1d5db;padding:0.5rem 1rem;border-radius:0.375rem;cursor:pointer;font-size:0.875rem;">Cancel</button>
                    <button id="confirmCreateRoleBtnDynamic" style="background:#4f46e5;color:white;border:none;padding:0.5rem 1rem;border-radius:0.375rem;cursor:pointer;font-size:0.875rem;">Create Role</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        document.body.style.overflow = 'hidden';
        
        function closeModal() {
            modal.remove();
            document.body.style.overflow = '';
        }
        
        // Close events
        modal.addEventListener('click', function(e) { if (e.target === modal) closeModal(); });
        document.getElementById('modalCloseIconDynamic').onclick = closeModal;
        document.getElementById('closeModalBtnDynamic').onclick = closeModal;
        
        // Create role
        document.getElementById('confirmCreateRoleBtnDynamic').onclick = function() {
            const roleName = document.getElementById('newRoleNameDynamic').value.trim();
            const category = document.getElementById('newRoleCategoryDynamic').value;
            const desc = document.getElementById('newRoleDescDynamic').value.trim() || 'Custom role';
            
            if (!roleName) { 
                showToast('Please enter a role name', true); 
                return; 
            }
            
            currentRoleId++;
            const newRole = {
                id: currentRoleId, 
                name: roleName, 
                category: category,
                description: desc, 
                users: 0, 
                lastUpdated: new Date().toISOString().slice(0, 10), 
                isDefault: false
            };
            roles.push(newRole);
            renderRolesTable();
            updateTotalRolesCount();
            closeModal();
            showToast('Role "' + roleName + '" created successfully!');
        };
        
        // Escape key
        document.addEventListener('keydown', function escHandler(e) {
            if (e.key === 'Escape') {
                closeModal();
                document.removeEventListener('keydown', escHandler);
            }
        });
    }
    
    // Wire up the button
    const openBtn = document.getElementById('openAddRoleModalBtn');
    if (openBtn) {
        openBtn.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            openModal();
        };
    }
}

// Add this Radix select init function
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
        document.querySelectorAll('.radix-select-content').forEach(c => { 
            if (c !== content) c.classList.add('hidden'); 
        });
        content?.classList.toggle('hidden');
    });
    
    items.forEach(item => {
        item.addEventListener('click', (e) => {
            e.stopPropagation();
            const value = item.getAttribute('data-value');
            const label = item.textContent.replace(/<svg[\s\S]*?<\/svg>/g, '').trim();
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

// Close radix selects on outside click
document.addEventListener('click', (e) => {
    if (!e.target.closest('.radix-select')) {
        document.querySelectorAll('.radix-select-content').forEach(c => c.classList.add('hidden'));
    }
});


function initDropdowns() {
    const notificationsBtn = document.getElementById('notificationsBtn');
    const notificationsDropdown = document.getElementById('notificationsDropdown');
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');
    
    if (notificationsBtn) {
        notificationsBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            notificationsDropdown.classList.toggle('hidden');
            if (profileDropdown) profileDropdown.classList.add('hidden');
        });
    }
    if (profileBtn) {
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
            if (notificationsDropdown) notificationsDropdown.classList.add('hidden');
        });
    }
    document.addEventListener('click', () => {
        if (notificationsDropdown) notificationsDropdown.classList.add('hidden');
        if (profileDropdown) profileDropdown.classList.add('hidden');
        closeMenu();
    });
}

function initSearch() {
    const searchInput = document.getElementById('searchRolesInput');
    if (searchInput) searchInput.addEventListener('input', () => renderRolesTable());
    
    const templatesSearch = document.getElementById('searchTemplatesInput');
    if (templatesSearch) templatesSearch.addEventListener('input', () => renderTemplates());
}

function initTemplateButtons() {
    // Function to show Create Template Modal
    function showCreateTemplateModal() {
        // Remove existing modal if any
        const existingModal = document.querySelector('.create-template-modal-overlay');
        if (existingModal) existingModal.remove();
        
        const modules = [
            'Dashboard', 'Patients', 'Appointments', 'Billing', 'Reports', 'Settings', 'Inventory', 'Staff'
        ];
        const actions = ['view', 'create', 'edit', 'delete'];
        
        const modalOverlay = document.createElement('div');
        modalOverlay.className = 'template-modal-overlay create-template-modal-overlay';
        modalOverlay.innerHTML = `
            <div class="create-template-modal" role="dialog">
                <div class="template-modal-header">
                    <h2 class="template-modal-title">Create Role Template</h2>
                    <button class="template-modal-close close-create-template-modal">&times;</button>
                </div>
                <div class="template-modal-body">
                    <div class="space-y-4">
                        <div class="grid gap-2">
                            <label class="text-sm font-medium">Template Name</label>
                            <input id="newTemplateName" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm" placeholder="Enter template name">
                        </div>
                        <div class="grid gap-2">
                            <label class="text-sm font-medium">Category</label>
                            <select id="newTemplateCategory" class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm">
                                <option value="Medical">Medical</option>
                                <option value="Administrative">Administrative</option>
                                <option value="Custom">Custom</option>
                            </select>
                        </div>
                        <div class="grid gap-2">
                            <label class="text-sm font-medium">Description</label>
                            <textarea id="newTemplateDescription" rows="2" class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm" placeholder="Enter template description"></textarea>
                        </div>
                        <div>
                            <label class="text-sm font-medium mb-2 block">Permissions</label>
                            <div id="permissionsContainer" class="space-y-3 max-h-80 border rounded-lg overflow-y-auto">
                                ${modules.map(module => `
                                    <div class="permission-group">
                                        <div class="permission-group-title">${module}</div>
                                        <div class="permission-checkbox-grid">
                                            ${actions.map(action => `
                                                <div class="permission-checkbox-item">
                                                    <input type="checkbox" id="perm-${module.toLowerCase()}-${action}" data-module="${module.toLowerCase()}" data-action="${action}" value="${action}">
                                                    <label for="perm-${module.toLowerCase()}-${action}">${action}</label>
                                                </div>
                                            `).join('')}
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="template-modal-footer">
                    <button class="modal-btn-cancel inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 mr-2 close-create-template-modal">Cancel</button>
                    <button id="confirmCreateTemplateBtn" class="modal-btn-apply template-apply-btn inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-9 rounded-md px-3">Create Template</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modalOverlay);
        document.body.style.overflow = 'hidden';
        
        const closeModal = () => {
            modalOverlay.remove();
            document.body.style.overflow = '';
        };
        
        modalOverlay.querySelectorAll('.close-create-template-modal').forEach(btn => {
            btn.addEventListener('click', closeModal);
        });
        
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) closeModal();
        });
        
        // Escape key handler
        const escHandler = (e) => {
            if (e.key === 'Escape') {
                closeModal();
                document.removeEventListener('keydown', escHandler);
            }
        };
        document.addEventListener('keydown', escHandler);
        
        // Handle Create Template button
        const createBtn = modalOverlay.querySelector('#confirmCreateTemplateBtn');
        if (createBtn) {
            createBtn.addEventListener('click', () => {
                const templateName = document.getElementById('newTemplateName')?.value.trim();
                const category = document.getElementById('newTemplateCategory')?.value;
                const description = document.getElementById('newTemplateDescription')?.value.trim() || 'Custom template';
                
                if (!templateName) {
                    showToast('Please enter a template name', true);
                    return;
                }
                
                // Collect permissions
                const permissions = [];
                document.querySelectorAll('#permissionsContainer input[type="checkbox"]:checked').forEach(checkbox => {
                    const module = checkbox.dataset.module;
                    const action = checkbox.dataset.action;
                    if (module && action && !permissions.includes(module)) {
                        permissions.push(module);
                    }
                });
                
                const newTemplate = {
                    id: Date.now(),
                    name: templateName,
                    category: category,
                    description: description,
                    permissions: permissions.length > 0 ? permissions : ['dashboard', 'patients']
                };
                
                templates.push(newTemplate);
                renderTemplates();
                showToast(`Template "${templateName}" created successfully!`);
                closeModal();
            });
        }
    }
    
    // Function to show template details modal with 5-column permission table
    function showTemplateDetailsModal(template) {
        const existingModal = document.querySelector('.template-modal-overlay:not(.create-template-modal-overlay)');
        if (existingModal) existingModal.remove();
        
        const modules = [
            { name: 'Dashboard', view: true, create: false, edit: true, delete: false },
            { name: 'Patients', view: true, create: true, edit: true, delete: true },
            { name: 'Appointments', view: true, create: true, edit: true, delete: true },
            { name: 'Billing', view: true, create: false, edit: true, delete: false },
            { name: 'Reports', view: true, create: true, edit: true, delete: true },
            { name: 'Settings', view: true, create: false, edit: true, delete: false },
            { name: 'Inventory', view: template.permissions.includes('inventory') || false, create: false, edit: false, delete: false },
            { name: 'Staff', view: template.permissions.includes('staff') || false, create: false, edit: false, delete: false }
        ];
        
        const modalOverlay = document.createElement('div');
        modalOverlay.className = 'template-modal-overlay';
        modalOverlay.innerHTML = `
            <div class="template-modal" style="max-width: 800px;" role="dialog">
                <div class="template-modal-header">
                    <h2 class="template-modal-title">${escapeHtml(template.name)} Template</h2>
                    <button class="template-modal-close">&times;</button>
                </div>
                <div class="template-modal-body">
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-medium text-sm mb-1">Description</h4>
                            <p class="text-sm text-muted-foreground">${escapeHtml(template.description)}</p>
                        </div>
                        <div>
                            <h4 class="font-medium text-sm mb-2">Permissions</h4>
                            <div class="relative w-full overflow-auto border rounded-md">
                                <table class="w-full text-sm border-collapse">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr class="border-b dark:border-gray-700">
                                            <th class="h-10 px-3 text-left align-middle font-medium text-muted-foreground">Module</th>
                                            <th class="h-10 px-3 text-left align-middle font-medium text-muted-foreground">View</th>
                                            <th class="h-10 px-3 text-left align-middle font-medium text-muted-foreground">Create</th>
                                            <th class="h-10 px-3 text-left align-middle font-medium text-muted-foreground">Edit</th>
                                            <th class="h-10 px-3 text-left align-middle font-medium text-muted-foreground">Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${modules.map(module => `
                                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                                <td class="p-3 align-middle font-medium capitalize">${module.name}</td>
                                                <td class="p-3 align-middle text-center">
                                                    ${module.view ? 
                                                        '<span class="text-green-600 dark:text-green-400"><svg class="h-5 w-5 inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"></path></svg></span>' : 
                                                        '<span class="text-gray-400"><svg class="h-5 w-5 inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>'
                                                    }
                                                </td>
                                                <td class="p-3 align-middle text-center">
                                                    ${module.create ? 
                                                        '<span class="text-green-600 dark:text-green-400"><svg class="h-5 w-5 inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"></path></svg></span>' : 
                                                        '<span class="text-gray-400"><svg class="h-5 w-5 inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>'
                                                    }
                                                </td>
                                                <td class="p-3 align-middle text-center">
                                                    ${module.edit ? 
                                                        '<span class="text-green-600 dark:text-green-400"><svg class="h-5 w-5 inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"></path></svg></span>' : 
                                                        '<span class="text-gray-400"><svg class="h-5 w-5 inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>'
                                                    }
                                                </td>
                                                <td class="p-3 align-middle text-center">
                                                    ${module.delete ? 
                                                        '<span class="text-green-600 dark:text-green-400"><svg class="h-5 w-5 inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"></path></svg></span>' : 
                                                        '<span class="text-gray-400"><svg class="h-5 w-5 inline" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></span>'
                                                    }
                                                </td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="template-modal-footer">
                    <button class="modal-btn-cancel inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-9 rounded-md px-3 mr-2">Close</button>
                    <button class="modal-btn-apply template-apply-btn inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-9 rounded-md px-3">Apply Template</button>
                </div>
            </div>
        `;
        
        document.body.appendChild(modalOverlay);
        document.body.style.overflow = 'hidden';
        
        const closeModal = () => {
            modalOverlay.remove();
            document.body.style.overflow = '';
        };
        
        modalOverlay.querySelector('.template-modal-close')?.addEventListener('click', closeModal);
        modalOverlay.querySelector('.modal-btn-cancel')?.addEventListener('click', closeModal);
        
        modalOverlay.querySelector('.modal-btn-apply')?.addEventListener('click', () => {
            applyTemplateToNewRole(template);
            closeModal();
        });
        
        modalOverlay.addEventListener('click', (e) => {
            if (e.target === modalOverlay) closeModal();
        });
        
        const escHandler = (e) => {
            if (e.key === 'Escape') {
                closeModal();
                document.removeEventListener('keydown', escHandler);
            }
        };
        document.addEventListener('keydown', escHandler);
    }
    
    function applyTemplateToNewRole(template) {
        currentRoleId++;
        const newRole = {
            id: currentRoleId,
            name: `${template.name} (from template)`,
            category: template.category,
            description: template.description,
            users: 0,
            lastUpdated: new Date().toISOString().slice(0, 10),
            isDefault: false
        };
        roles.push(newRole);
        renderRolesTable();
        updateTotalRolesCount();
        showToast(`Template "${template.name}" applied successfully! New role created.`);
    }
    
    function cloneTemplate(template) {
        const newTemplate = {
            id: Date.now(),
            name: `${template.name} (Copy)`,
            category: template.category,
            description: `${template.description} (Cloned)`,
            permissions: [...template.permissions]
        };
        templates.push(newTemplate);
        renderTemplates();
        showToast(`Template "${newTemplate.name}" created successfully!`);
    }
    
    // Event listeners for buttons
    document.getElementById('createTemplateBtn')?.addEventListener('click', showCreateTemplateModal);
    document.getElementById('createTemplateFromCardBtn')?.addEventListener('click', showCreateTemplateModal);
    
    // Event delegation for template cards
    document.addEventListener('click', (e) => {
        const viewBtn = e.target.closest('.template-view-btn');
        const cloneBtn = e.target.closest('.template-clone-btn');
        const applyBtn = e.target.closest('.template-apply-btn');
        const exportMatrix = e.target.closest('#exportMatrixBtn');
        const exportAudit = e.target.closest('#exportAuditBtn');
        
        if (viewBtn) {
            const templateId = parseInt(viewBtn.dataset.templateId);
            const template = templates.find(t => t.id === templateId);
            if (template) showTemplateDetailsModal(template);
        }
        
        if (cloneBtn) {
            const templateId = parseInt(cloneBtn.dataset.templateId);
            const template = templates.find(t => t.id === templateId);
            if (template) cloneTemplate(template);
        }
        
        if (applyBtn) {
            const templateId = parseInt(applyBtn.dataset.templateId);
            const template = templates.find(t => t.id === templateId);
            if (template) applyTemplateToNewRole(template);
        }
        
        if (exportMatrix) exportPermissionMatrix();
        if (exportAudit) exportAuditLogs();
    });
}

// Export Permission Matrix to CSV
function exportPermissionMatrix() {
    const modules = ['Dashboard', 'Patients', 'Appointments', 'Billing', 'Reports', 'Settings', 'Inventory', 'Staff'];
    const roleColumns = ['Administrator', 'Doctor', 'Nurse', 'Receptionist', 'Billing Staff', 'Lab Technician', 'Senior Doctor', 'Department Head'];
    const actions = ['view', 'create', 'edit', 'delete'];
    
    // Build CSV data
    const csvRows = [];
    
    // Add header row
    const headers = ['Module / Permission', ...roleColumns];
    csvRows.push(headers.join(','));
    
    // For each module and action, create a row
    modules.forEach(module => {
        actions.forEach(action => {
            const row = [`${module} - ${action}`];
            
            roleColumns.forEach(role => {
                const isAdmin = role === 'Administrator';
                const isSeniorDoctor = role === 'Senior Doctor';
                const isDoctor = role === 'Doctor';
                const isDepartmentHead = role === 'Department Head';
                
                let hasPermission = false;
                if (action === 'view') hasPermission = true;
                else if (action === 'create') hasPermission = isAdmin || isDepartmentHead;
                else if (action === 'edit') hasPermission = isAdmin || isDoctor || isSeniorDoctor || isDepartmentHead;
                else if (action === 'delete') hasPermission = isAdmin;
                
                row.push(hasPermission ? '✓ Granted' : '✗ Revoked');
            });
            
            csvRows.push(row.join(','));
        });
    });
    
    // Add separator row
    csvRows.push('');
    csvRows.push('"Permission Matrix Export"');
    csvRows.push(`"Generated: ${new Date().toLocaleString()}"`);
    
    // Create and download CSV
    const csvContent = csvRows.join('\n');
    const blob = new Blob(["\uFEFF" + csvContent], { type: "text/csv;charset=utf-8;" });
    const link = document.createElement("a");
    const url = URL.createObjectURL(blob);
    link.href = url;
    link.setAttribute("download", `permission_matrix_${new Date().toISOString().slice(0, 10)}.csv`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
    
    showToast("Permission Matrix exported successfully!");
}

// Export Audit Logs to CSV
function exportAuditLogs() {
    // Get current audit logs data
    const auditLogsData = [
        { timestamp: "2024-04-15 09:23:45", user: "Nakato Sarah", action: "Permission Added", role: "Administrator", module: "Reports", permission: "delete", oldValue: "-", newValue: "Granted", ip: "192.168.1.100" },
        { timestamp: "2024-04-14 14:12:30", user: "Mwangi Peter", action: "Permission Removed", role: "Doctor", module: "Billing", permission: "edit", oldValue: "Granted", newValue: "Revoked", ip: "192.168.1.102" },
        { timestamp: "2024-04-10 11:05:22", user: "Nakato Sarah", action: "Role Created", role: "Senior Doctor", module: "All", permission: "N/A", oldValue: "-", newValue: "New Role", ip: "192.168.1.100" },
        { timestamp: "2024-04-08 16:45:10", user: "Namyalo Emma", action: "Permission Added", role: "Nurse", module: "Patients", permission: "edit", oldValue: "-", newValue: "Granted", ip: "192.168.1.105" },
        { timestamp: "2024-04-05 10:30:15", user: "System Admin", action: "Permission Removed", role: "Receptionist", module: "Billing", permission: "create", oldValue: "Granted", newValue: "Revoked", ip: "127.0.0.1" },
        { timestamp: "2024-04-03 09:15:30", user: "Nakato Sarah", action: "Permission Added", role: "Department Head", module: "Settings", permission: "view", oldValue: "-", newValue: "Granted", ip: "192.168.1.100" },
        { timestamp: "2024-04-01 14:20:00", user: "Mwangi Peter", action: "Role Modified", role: "Doctor", module: "Appointments", permission: "delete", oldValue: "Granted", newValue: "Revoked", ip: "192.168.1.102" }
    ];
    
    // Headers
    const headers = ['Timestamp', 'User', 'Action', 'Role', 'Module', 'Permission', 'Old Value', 'New Value', 'IP Address'];
    
    // Build CSV rows
    const csvRows = [headers.join(',')];
    
    auditLogsData.forEach(log => {
        const row = [
            `"${log.timestamp}"`,
            `"${log.user}"`,
            `"${log.action}"`,
            `"${log.role}"`,
            `"${log.module}"`,
            `"${log.permission}"`,
            `"${log.oldValue}"`,
            `"${log.newValue}"`,
            `"${log.ip}"`
        ];
        csvRows.push(row.join(','));
    });
    
    // Add footer with generation info
    csvRows.push('');
    csvRows.push(`"Audit Logs Export"`);
    csvRows.push(`"Generated: ${new Date().toLocaleString()}"`);
    csvRows.push(`"Total Records: ${auditLogsData.length}"`);
    
    // Create and download CSV
    const csvContent = csvRows.join('\n');
    const blob = new Blob(["\uFEFF" + csvContent], { type: "text/csv;charset=utf-8;" });
    const link = document.createElement("a");
    const url = URL.createObjectURL(blob);
    link.href = url;
    link.setAttribute("download", `audit_logs_${new Date().toISOString().slice(0, 10)}.csv`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
    
    showToast("Audit logs exported successfully!");
}

document.addEventListener('DOMContentLoaded', () => {
    initTabs();
    initModal();
    initDropdowns();
    initSearch();
    initTemplateButtons();
    renderRolesTable();
    updateTotalRolesCount();
    renderTemplates();
    renderPermissionMatrix();
    renderAuditLogs();
});
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
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Secure Chat</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <style>

        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        .bg-white, .bg-card, .rounded-lg.border { background-color: #ffffff; border-color: #e5e7eb; }
        .text-gray-900, .text-gray-800, .text-gray-700 { color: #1f2937; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.85); backdrop-filter: blur(8px); z-index: 1000; display: flex; align-items: center; justify-content: center; animation: fadeIn 0.2s ease-out; }
        .modal-container { background: #0f0f1a; max-width: 700px; width: 90%; max-height: 85vh; overflow: hidden; box-shadow: 0 25px 50px -12px rgb(0 0 0 / 87%); animation: scaleIn 0.2s ease-out; position: relative; }
        .modal-container.pip-mode { max-width: 320px; width: 320px; max-height: 240px; position: fixed; bottom: 20px; right: 20px; top: auto; left: auto; transform: none; border-radius: 12px; cursor: move; }
        .modal-container.pip-mode .audio-content { padding: 16px; }
        .modal-container.pip-mode .avatar-large { width: 40px; height: 40px; font-size: 16px; }
        .modal-container.pip-mode .contact-name { font-size: 14px; }
        .modal-container.pip-mode .call-status { font-size: 10px; }
        .modal-container.pip-mode .timer { font-size: 10px; padding: 2px 6px; }
        .modal-container.pip-mode .control-buttons { padding: 8px; gap: 8px; }
        .modal-container.pip-mode .control-btn { padding: 6px; }
        .modal-container.pip-mode .control-btn svg { width: 16px; height: 16px; }
        .modal-container.pip-mode .modal-header { padding: 8px; cursor: move; }
        .modal-container.pip-mode .modal-header h1 { font-size: 12px; }
        .modal-container.pip-mode .modal-header p { display: none; }
        
        /* Light modal for conversation info and new chat */
        .light-modal-container { background: white; max-width: 500px; width: 90%; max-height: 85vh; overflow: hidden; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); animation: scaleIn 0.2s ease-out; }
        body.dark .light-modal-container { background: white; color: #1f2937; }
        
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes scaleIn { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
        
        .popover { position: absolute; background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 0.25rem; min-width: 200px; z-index: 100; animation: fadeIn 0.1s ease-out; }
        .popover-item { padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; gap: 8px; border-radius: 0.25rem; transition: background 0.1s; }
        .popover-item:hover { background-color: #f3f4f6; }
        .popover-item.danger { color: #dc2626; }
        .popover-item.danger:hover { background-color: #fee2e2; }
        
        .video-container { position: relative; background: #131212; border-radius: 0.75rem; overflow: hidden; aspect-ratio: 16 / 9; margin: 12px; }
        .remote-video { width: 100%; height: 100%; object-fit: cover; background: #1a1a2e; }
        .local-video-pip { position: absolute; bottom: 16px; right: 16px; width: 160px; aspect-ratio: 16 / 9; border-radius: 8px; overflow: hidden; border: 2px solid rgba(255,255,255,0.3); box-shadow: 0 4px 12px rgba(0,0,0,0.3); cursor: pointer; transition: transform 0.2s; z-index: 10; background: #1a1a2e; }
        .control-btn { transition: all 0.2s; cursor: pointer; border: #ffffff55 .5px solid;}
        .control-btn:hover { transform: scale(1.05); }
        .control-btn.active { background-color: #ef4444; color: white; }
        .timer { font-family: 'Inter', monospace; background: rgba(0,0,0,0.7); backdrop-filter: blur(4px); padding: 6px 12px; border-radius: 6px; font-size: 0.9rem; font-weight: 500; }
        .status-badge { position: absolute; top: 12px; left: 12px; z-index: 20; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); border-radius: 20px; padding: 4px 12px; }
.pip-btn-container {
    position: absolute;
    top: 12px;
    right: 12px;
    z-index: 20;
    background: rgb(0 0 0 / 87%);
    backdrop-filter: blur(4px);
    border-radius: 8px;
    padding: 3px;
}        .control-buttons { display: flex; justify-content: center; gap: 12px; padding: 12px; border-top: 1px solid rgba(255,255,255,0.1); }
        .avatar-large { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #8b5cf6); display: flex; align-items: center; justify-content: center; font-size: 32px; font-weight: 600; color: white; margin: 0 auto; }
        
        .search-result-item { padding: 12px; border: 1px solid #e5e7eb; border-radius: 0.5rem; cursor: pointer; transition: all 0.15s; display: flex; align-items: center; gap: 12px; }
        .search-result-item:hover { background-color: #f3f4f6; border-color: #6366f1; }
        .result-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #8b5cf6); display: flex; align-items: center; justify-content: center; font-weight: 600; color: white; }
        
        .file-attachment { display: flex; align-items: center; gap: 12px; padding: 8px 12px; border-radius: 8px; margin-bottom: 8px; }
        .file-icon { width: 32px; height: 32px; background: #e0e7ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #4f46e5; }
/* Action Buttons Styling */
/* Action Buttons - Minimal & Clean */
.action-buttons {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 6px;
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 12px;
    transition: all 0.2s ease;
    background: transparent;
    min-width: 60px;
}

.action-btn:hover {
    background-color: #f3f4f6;
}

.action-btn svg {
    width: 20px;
    height: 20px;
    stroke: #6b7280;
    transition: stroke 0.2s ease;
}

.action-btn:hover svg {
    stroke: #4f46e5;
}

.action-btn span {
    font-size: 11px;
    font-weight: 500;
    color: #6b7280;
    transition: color 0.2s ease;
}

.action-btn:hover span {
    color: #4f46e5;
}

.action-buttons.hidden {
    display: none;
}

/* Individual button variations on hover */
.action-btn[data-action="file"]:hover svg { stroke: #3b82f6 !important; }
.action-btn[data-action="file"]:hover span { color: #3b82f6; }

.action-btn[data-action="location"]:hover svg { stroke: #10b981 !important; }
.action-btn[data-action="location"]:hover span { color: #10b981; }

.action-btn[data-action="camera"]:hover svg { stroke: #ef4444 !important; }
.action-btn[data-action="camera"]:hover span { color: #ef4444; }

.action-btn[data-action="audio"]:hover svg { stroke: #f59e0b !important; }
.action-btn[data-action="audio"]:hover span { color: #f59e0b; }

.action-btn[data-action="gallery"]:hover svg { stroke: #8b5cf6 !important; }
.action-btn[data-action="gallery"]:hover span { color: #8b5cf6; }

.action-btn[data-action="video"]:hover svg { stroke: #ec4899 !important; }
.action-btn[data-action="video"]:hover span { color: #ec4899; }

.action-btn[data-action="contact"]:hover svg { stroke: #06b6d4 !important; }
.action-btn[data-action="contact"]:hover span { color: #06b6d4; }

.action-buttons.hidden {
    display: none;
}

.action-buttons.hidden {
    display: none;
}        .action-btn { display: flex; flex-direction: column; align-items: center; gap: 4px; cursor: pointer; padding: 6px 12px; border-radius: 8px; transition: all 0.15s; }
        .action-btn:hover { background-color: #f3f4f6; }
        .action-btn span { font-size: 11px; color: #6b7280; }
        .plus-btn { background: #f3f4f6; border-radius: 8px; transition: all 0.15s; }
        .plus-btn:hover { background: #e5e7eb; }
        .action-buttons.hidden { display: none; }
/* Audio pip mode (compact, minimal) */
.modal-container.pip-mode {
    max-width: 320px;
    width: 320px;
    max-height: 240px;
    position: fixed;
    bottom: 20px;
    right: 20px;
    top: auto;
    left: auto;
    transform: none;
    border-radius: 12px;
    cursor: move;
}

.modal-container.pip-mode .audio-content {
    padding: 16px;
}

.modal-container.pip-mode .avatar-large {
    width: 40px;
    height: 40px;
    font-size: 16px;
}

.modal-container.pip-mode .contact-name {
    font-size: 14px;
}

.modal-container.pip-mode .call-status {
    font-size: 10px;
}

.modal-container.pip-mode .timer {
    font-size: 10px;
    padding: 2px 6px;
}

.modal-container.pip-mode .control-buttons {
    padding: 8px;
    gap: 8px;
}

.modal-container.pip-mode .control-btn {
    padding: 6px;
}

.modal-container.pip-mode .control-btn svg {
    width: 16px;
    height: 16px;
}

.modal-container.pip-mode .modal-header {
    padding: 8px;
    cursor: move;
}

.modal-container.pip-mode .modal-header h1 {
    font-size: 12px;
}

.modal-container.pip-mode .modal-header p {
    display: none;
}

/* Video pip mode only (larger, with visible buttons) */
.video-call-container.pip-mode {
    max-width: 360px !important;
    width: 360px !important;
    max-height: 298px !important;
    position: fixed;
    bottom: 20px;
    right: 20px;
    top: auto;
    left: auto;
    transform: none;
    border-radius: 12px;
    cursor: move;
}

.video-call-container.pip-mode .video-container {
    aspect-ratio: 16 / 9;
    margin: 8px;
}

.video-call-container.pip-mode .control-buttons {
    padding: 8px;
    gap: 8px;
}

.video-call-container.pip-mode .control-btn {
    padding: 4px 8px;
}

.video-call-container.pip-mode .control-btn svg {
    width: 16px;
    height: 16px;
}

.video-call-container.pip-mode .control-btn span {
    font-size: 11px;
}

.video-call-container.pip-mode .local-video-pip {
    width: 80px;
}

.video-call-container.pip-mode .status-badge {
    padding: 2px 8px;
    font-size: 10px;
}

.video-call-container.pip-mode .status-badge span {
    font-size: 10px;
}

.video-call-container.pip-mode .timer {
    font-size: 10px;
    padding: 2px 6px;
}

.video-call-container.pip-mode .modal-header {
    padding: 6px 10px;
}

.video-call-container.pip-mode .modal-header h1 {
    font-size: 11px;
}

.video-call-container.pip-mode .modal-header p {
    font-size: 9px;
}

.modal-container.pip-mode .video-container {
    aspect-ratio: 16 / 9;
    margin: 8px;
}

.modal-container.pip-mode .control-buttons {
    padding: 8px;
    gap: 8px;
}

.modal-container.pip-mode .control-btn {
    padding: 4px 8px;
}

.modal-container.pip-mode .control-btn svg {
    width: 16px;
    height: 16px;
}

.modal-container.pip-mode .control-btn span {
    font-size: 11px;
}

.modal-container.pip-mode .local-video-pip {
    width: 80px;
}

.modal-container.pip-mode .status-badge {
    padding: 2px 8px;
    font-size: 10px;
}

.modal-container.pip-mode .status-badge span {
    font-size: 10px;
}

.modal-container.pip-mode .timer {
    font-size: 10px;
    padding: 2px 6px;
}

.modal-container.pip-mode .modal-header {
    padding: 6px 10px;
}

.modal-container.pip-mode .modal-header h1 {
    font-size: 11px;
}

.modal-container.pip-mode .modal-header p {
    font-size: 9px;
}

        .ring-animation-element { 
    position: absolute; 
    inset: -6px; 
    border-radius: 50%; 
    border: 1.5px solid #8b5cf6; 
    background: radial-gradient(circle, rgba(139,92,246,0.15) 0%, rgba(139,92,246,0) 70%);
    animation: ringPulseAudio 1.2s infinite ease-out; 
}

@keyframes ringPulseAudio { 
    0% { transform: scale(0.9); opacity: 0.9; } 
    50% { transform: scale(1.1); opacity: 0.5; border-width: 2px; } 
    100% { transform: scale(1.25); opacity: 0; border-width: 1px; } 
}

.ring-wrapper { 
    position: relative; 
    display: inline-block; 
}

/* Fix PiP click-through */
.modal-overlay.pip-active {
    pointer-events: none !important;
    background: transparent !important;
    backdrop-filter: none !important;
}

.modal-overlay.pip-active .modal-container {
    pointer-events: auto !important;
}

.modal-container.pip-mode {
    z-index: 1001;
    pointer-events: auto !important;
}

/* ============================================
   CHAT BUBBLE FIX — sent messages
   ============================================ */
.flex.justify-start .bg-muted {
    border-radius: 1rem 1rem 1rem 0.25rem !important;
}
.flex.justify-end .bg-primary {
    background-color: var(--color-primary, #4f46e5) !important;
    color: #ffffff !important;
    border-radius: 1rem 1rem 0.25rem 1rem;
}
.flex.justify-end .bg-primary p {
    color: #ffffff !important;
}
.flex.justify-end .bg-primary .text-gray-500,
.flex.justify-end .bg-primary .text-xs {
    color: rgba(255, 255, 255, 0.65) !important;
}
.flex.justify-end .bg-primary svg {
    stroke: rgba(255, 255, 255, 0.80) !important;
}
body.dark .flex.justify-end .bg-primary {
    background-color: var(--color-primary, #4f46e5) !important;
    color: #ffffff !important;
}
body.dark .flex.justify-end .bg-primary .text-gray-500,
body.dark .flex.justify-end .bg-primary .text-xs {
    color: rgba(255, 255, 255, 0.60) !important;
}

/* Toast animation */
@keyframes pipSlideIn {
    from { transform: translateY(10px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Toggle switch */
.toggle-switch {
    position: relative;
    display: inline-block;
    width: 36px;
    height: 20px;
}
.toggle-switch input { opacity: 0; width: 0; height: 0; }
.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0; left: 0; right: 0; bottom: 0;
    background-color: #d1d5db;
    transition: .2s;
    border-radius: 20px;
}
.toggle-slider:before {
    position: absolute;
    content: "";
    height: 16px;
    width: 16px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    transition: .2s;
    border-radius: 50%;
}
input:checked + .toggle-slider {
    background-color: #4f46e5;
}
input:checked + .toggle-slider:before {
    transform: translateX(16px);
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
                        <div class="px-3 py-2 text-sm font-semibold flex justify-between border-b"><span>Notifications</span><button id="markAllReadBtn" class="text-xs text-gray-900">Mark all as read</button></div>
                        <div class="max-h-[300px] overflow-y-auto">
                            <div role="group">
                                <div role="menuitem" class="relative flex cursor-default select-none items-center gap-2 rounded-sm text-sm outline-none transition-colors focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 p-0 focus:bg-transparent" tabindex="-1" data-orientation="vertical" data-radix-collection-item="">
                                    <div class="flex items-start gap-2 p-3 text-sm transition-colors hover:bg-muted/50 rounded-md bg-muted/30">
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary/10">
                                            <span role="img" aria-label="appointment">🗓️</span></div><div class="flex-1 space-y-1">
                                                <div class="flex items-center justify-between">
                                                    <p class="font-semibold">New appointment request</p>
                                                    <p class="text-xs text-muted-foreground">Just now</p>
                                                </div>
                                                <p class="text-xs text-muted-foreground">Dr. Ssemwogerere has a new appointment request from John Donanto</p>
                                            </div>
                                            <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground size-10 h-6 w-6 shrink-0 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check h-3 w-3"><path d="M20 6 9 17l-5-5"></path></svg>
                                                <span class="sr-only">Mark as read</span>
                                            </button>
                                    </div>
                                </div>
                                <div role="menuitem" class="relative flex cursor-default select-none items-center gap-2 rounded-sm text-sm outline-none transition-colors focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 p-0 focus:bg-transparent" tabindex="-1" data-orientation="vertical" data-radix-collection-item="">
                                    <div class="flex items-start gap-2 p-3 text-sm transition-colors hover:bg-muted/50 rounded-md bg-muted/30">
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary/10">
                                            <span role="img" aria-label="prescription">💊</span></div><div class="flex-1 space-y-1">
                                                <div class="flex items-center justify-between">
                                                    <p class="font-semibold">Prescription renewal</p>
                                                    <p class="text-xs text-muted-foreground">5 min ago</p>
                                                </div>
                                                <p class="text-xs text-muted-foreground">Patient Emily Johnson requested a prescription renewal</p>
                                            </div>
                                            <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground size-10 h-6 w-6 shrink-0 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check h-3 w-3"><path d="M20 6 9 17l-5-5"></path></svg>
                                                <span class="sr-only">Mark as read</span></button></div></div>
                                <div role="menuitem" class="relative flex cursor-default select-none items-center gap-2 rounded-sm text-sm outline-none transition-colors focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 p-0 focus:bg-transparent" tabindex="-1" data-orientation="vertical" data-radix-collection-item="">
                                    <div class="flex items-start gap-2 p-3 text-sm transition-colors hover:bg-muted/50 rounded-md bg-muted/30">
                                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary/10">
                                            <span role="img" aria-label="system">🔔</span></div>
                                            <div class="flex-1 space-y-1">
                                                <div class="flex items-center justify-between">
                                                <p class="font-semibold">Lab results available</p>
                                                <p class="text-xs text-muted-foreground">1 hour ago</p>
                                            </div>
                                            <p class="text-xs text-muted-foreground">New lab results are available for patient Michael Lee</p>
                                        </div>
                                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground size-10 h-6 w-6 shrink-0 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check h-3 w-3"><path d="M20 6 9 17l-5-5"></path></svg>
                                            <span class="sr-only">Mark as read</span>
                                        </button>
                                    </div>
                                </div>
                                <div role="menuitem" class="relative flex cursor-default select-none items-center gap-2 rounded-sm text-sm outline-none transition-colors focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 p-0 focus:bg-transparent" tabindex="-1" data-orientation="vertical" data-radix-collection-item="">
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
                                <div role="menuitem" class="relative flex cursor-default select-none items-center gap-2 rounded-sm text-sm outline-none transition-colors focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 p-0 focus:bg-transparent" tabindex="-1" data-orientation="vertical" data-radix-collection-item="">
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
                        <div class="p-2 text-center border-t"><a href="notifications.html" class="text-sm text-gray-900">View all notifications</a></div>
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
                        <a href="profile-setting.html" class="flex items-center gap-2 px-2 py-1.5 text-sm hover:bg-gray-100 rounded">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            Profile
                        </a>
                        <a href="settings.html" class="flex items-center gap-2 px-2 py-1.5 text-sm hover:bg-gray-100 rounded">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                            Settings
                        </a>
                        <a href="chat.html" class="flex items-center gap-2 px-2 py-1.5 text-sm hover:bg-gray-100 rounded">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"></path></svg>
                            Chat
                        </a>
                        <a href="support.html" class="flex items-center gap-2 px-2 py-1.5 text-sm hover:bg-gray-100 rounded">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><path d="M12 17h.01"></path></svg>
                            Support
                        </a>
                        <div class="border-t my-1"></div>
                        <a href="login.html" class="flex items-center gap-2 px-2 py-1.5 text-sm text-red-600 hover:bg-gray-100 rounded">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" x2="9" y1="12" y2="12"></line></svg>
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round mr-2 h-4 w-4"><circle cx="12" cy="8" r="5"></circle><path d="M20 21a8 8 0 0 0-16 0"></path></svg>
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-briefcase-medical-icon lucide-briefcase-medical mr-2 h-4 w-4"><path d="M12 11v4"/><path d="M14 13h-4"/><path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/><path d="M18 6v14"/><path d="M6 6v14"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
                        Prescriptions
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="prescriptions-arrow h-4 w-4 transition-transform duration-200"><polyline points="6 9 12 15 18 9"></polyline></svg>
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

            <!-- Laboratory Accordion -->
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
                    <a class="flex items-center rounded-md px-3 py-2 text-sm transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900" href="add-vaccination.html">Add Record</a>
                </div>
            </div>

            <!-- Nutrition -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="nutrition.html">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-soup-icon lucide-soup mr-2 h-4 w-4"><path d="M12 21a9 9 0 0 0 9-9H3a9 9 0 0 0 9 9Z"/><path d="M7 21h10"/><path d="M19.5 12 22 6"/><path d="M16.25 3c.27.1.8.53.75 1.36-.06.83-.93 1.2-1 2.02-.05.78.34 1.24.73 1.62"/><path d="M11.25 3c.27.1.8.53.74 1.36-.05.83-.93 1.2-.98 2.02-.06.78.33 1.24.72 1.62"/><path d="M6.25 3c.27.1.8.53.75 1.36-.06.83-.93 1.2-1 2.02-.05.78.34 1.24.74 1.62"/></svg>                      
                    Nutrition
                </a>
            </div>

            <!-- OT / Surgery -->
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

            <!-- Pharmacy -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="medicine.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pill mr-2 h-4 w-4"><path d="m10.5 20.5 10-10a4.95 4.95 0 1 0-7-7l-10 10a4.95 4.95 0 1 0 7 7Z"></path><path d="m8.5 8.5 7 7"></path></svg>
                    Pharmacy
                </a>
            </div>

            <!-- Blood Bank -->
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

            <!-- Billing -->
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

            <!-- Departments -->
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

            <!-- Inventory -->
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

            <!-- Staff -->
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

            <!-- Records -->
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

            <!-- Room Allotment -->
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

            <!-- Reviews -->
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

            <!-- Feedback -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="feedback.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square mr-2 h-4 w-4"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    Feedback
                </a>
            </div>

            <!-- Reports -->
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

            <!-- Settings -->
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

            <!-- Authentication -->
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

            <!-- Calendar -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="calendar.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar1 mr-2 h-4 w-4"><path d="M11 14h1v4"></path><path d="M16 2v4"></path><path d="M3 10h18"></path><path d="M8 2v4"></path><rect x="3" y="4" width="18" height="18" rx="2"></rect></svg>
                    Calendar
                </a>
            </div>

            <!-- Tasks -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="task.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check mr-2 h-4 w-4"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>
                    Tasks
                </a>
            </div>

            <!-- Queue -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="queue-dashboard.html">
<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ticket mr-2 h-4 w-4"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"></path><path d="M13 5v2"></path><path d="M13 17v2"></path><path d="M13 11v2"></path></svg>Queue
                </a>
            </div>

            <!-- Contacts -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="contacts.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round mr-2 h-4 w-4"><circle cx="12" cy="8" r="5"></circle><path d="M20 21a8 8 0 0 0-16 0"></path></svg>
                    Contacts
                </a>
            </div>

            <!-- Email -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="email.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail mr-2 h-4 w-4"><rect width="20" height="16" x="2" y="4" rx="2"></rect><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path></svg>
                    Email
                </a>
            </div>

            <!-- Chat -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="chat.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-circle mr-2 h-4 w-4"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"></path></svg>
                    Chat
                </a>
            </div>

            <!-- Support -->
            <div class="space-y-1 custom-scrollbar">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100 hover:text-gray-900" href="support.html">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-help mr-2 h-4 w-4"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><path d="M12 17h.01"></path></svg>
                    Support
                </a>
            </div>

            <!-- Widgets -->
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
    <button id="mobileChatMenuToggle" class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 md:hidden mb-3 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-message-circle h-4 w-4"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"></path></svg>
        Open Chat
    </button>
    <div class="flex h-[calc(100vh-4rem)] flex-col gap-3">
            <div class="flex h-[calc(100vh-4rem)] flex-col gap-3">
                <div class="flex flex-1 overflow-hidden relative">
                    <div class="w-full sm:w-80 xxl:w-96 border-r duration-300 bg-background max-md:absolute max-md:left-0 max-md:top-0 max-md:h-full max-md:z-50 max-md:-translate-x-full" id="sidebar">
                        <div class="p-4"><div class="flex items-center justify-between"><h2 class="text-lg font-semibold">Messages</h2><button id="newChatBtn" class="inline-flex items-center justify-center rounded-md hover:bg-gray-100 size-10"><svg class="lucide lucide-plus h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg></button></div><div class="relative mt-2"><svg class="absolute left-2 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><path d="m21 21-4.3-4.3"></path></svg><input id="searchChats" class="flex h-10 w-full rounded-md border border-gray-200 bg-background px-3 py-2 text-sm pl-8" placeholder="Search conversations"></div></div>
                        <div dir="ltr" class="px-4"><div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-gray-100 p-1 w-full"><button role="tab" data-tab="all" class="chat-tab flex-1 px-3 py-1.5 text-sm font-medium rounded-sm bg-background text-gray-900 shadow-sm">All</button><button role="tab" data-tab="unread" class="chat-tab flex-1 px-3 py-1.5 text-sm font-medium rounded-sm text-gray-500">Unread</button><button role="tab" data-tab="groups" class="chat-tab flex-1 px-3 py-1.5 text-sm font-medium rounded-sm text-gray-500">Groups</button></div></div>
                        <div class="h-[calc(100vh-12rem)] overflow-y-auto p-2" id="chatList"></div>
                    </div>

                    <div class="flex flex-1 flex-col bg-white">
<div class="flex h-16 items-center justify-between border-b px-2 lg:px-4">
    <div class="flex items-center gap-3">
        <span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full">
            <span class="flex h-full w-full items-center justify-center rounded-full bg-muted" id="chatAvatar">DJ</span>
        </span>
        <div class="py-2">
            <div class="flex items-center gap-2">
                <h3 class="font-medium text-sm lg:text-base" id="chatName">Dr. Okello James</h3>
                <span class="text-xs text-green-500" id="chatStatus">Online</span>
            </div>
            <p class="text-xs text-gray-500" id="chatRole">Cardiologist</p>
        </div>
    </div>
    <div class="flex items-center gap-1">
        <button id="voiceCallBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium hover:bg-gray-100 size-10 max-md:hidden" data-state="closed">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
            <span class="sr-only">Voice call</span>
        </button>
        <button id="videoCallBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium hover:bg-gray-100 size-10 max-md:hidden" data-state="closed">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path><rect x="2" y="6" width="14" height="12" rx="2"></rect></svg>
            <span class="sr-only">Video call</span>
        </button>
        <button id="infoBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium hover:bg-gray-100 size-10 max-md:hidden" data-state="closed">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
            <span class="sr-only">Conversation info</span>
        </button>
        <button id="moreOptionsBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium hover:bg-gray-100 size-10 max-md:hidden" data-state="closed">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
            <span class="sr-only">More options</span>
        </button>
        <div id="morePopover" class="popover hidden"></div>
    </div>
</div>
                        <div class="grow overflow-y-auto md:p-4 max-md:py-4" id="messagesArea"><div class="space-y-4" id="messagesList"></div></div>
                        <div class="border-t md:p-4 max-md:pt-4">
<div class="action-buttons-wrapper">
    <div id="actionButtonsContainer" class="action-buttons hidden">
        <div class="action-btn" data-action="file">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13 3l-9 9a4 4 0 0 0 6 6l9-9a2 2 0 0 0-2-2l-7 7a1 1 0 0 1-2-2l6-6"></path></svg>
            <span>File</span>
        </div>
        <div class="action-btn" data-action="location">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path><circle cx="12" cy="10" r="3"></circle></svg>
            <span>Location</span>
        </div>
        <div class="action-btn" data-action="camera">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
            <span>Camera</span>
        </div>
        <div class="action-btn" data-action="audio">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" x2="12" y1="19" y2="22"></line></svg>
            <span>Audio</span>
        </div>
        <div class="action-btn" data-action="gallery">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="2.5"></circle><path d="m21 15-5-4-3 3-4-4-5 5"></path></svg>
            <span>Gallery</span>
        </div>
        <div class="action-btn" data-action="video">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path><rect x="2" y="6" width="14" height="12" rx="2"></rect></svg>
            <span>Video</span>
        </div>
        <div class="action-btn" data-action="contact">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle><path d="M22 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            <span>Contact</span>
        </div>
    </div>
</div>
                            <div class="flex items-center gap-2 mt-2">
                                <button id="plusBtn" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 hover:bg-accent hover:text-accent-foreground size-10 shrink-0"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"></path></svg></button>
<input id="messageInput" class="flex h-10 w-full rounded-md border border-gray-200 bg-background px-3 py-2 text-sm disabled:bg-gray-100 disabled:text-gray-400 disabled:cursor-not-allowed" placeholder="Type a message...">                                <button id="sendBtn" class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg]:size-4 [&_svg]:shrink-0 bg-primary text-primary-foreground hover:bg-primary/90 size-10 shrink-0"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"></path><path d="m21.854 2.147-10.94 10.939"></path></svg></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- External Scripts -->
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
// ============================================
// CHAT PAGE SCRIPT — UPDATED WITH RICH MODALS
// ============================================

// ── DATA ─────────────────────────────────────────────────────────────────────
var chats = [
    { id:1, name:"Dr. Okello James",      role:"Cardiologist",  avatar:"DJ", unread:2, lastMsg:"I'll check the patient's records",    time:"10:42 AM", status:"online",  blocked:false, group:false },
    { id:2, name:"Nurse Emily Chen",      role:"Nurse",         avatar:"EC", unread:0, lastMsg:"The lab results are ready",           time:"9:30 AM",  status:"online",  blocked:false, group:false },
    { id:3, name:"Cardiology Department", role:"Group",         avatar:"CD", unread:0, lastMsg:"Meeting scheduled for tomorrow",      time:"Yesterday",status:"group",   blocked:false, group:true  },
    { id:4, name:"Dr. Nakato Sarah",     role:"Primary Care",  avatar:"SJ", unread:0, lastMsg:"Please update the patient status",    time:"Yesterday",status:"offline", blocked:false, group:false }
];
var messages = { 1: [
    { sender:"them", text:"Hello Dr. Johnson, I need to consult with you about a patient with unusual cardiac symptoms.", time:"10:30 AM" },
    { sender:"me",   text:"Of course, Dr. Wilson. What are the symptoms you're seeing?",                                  time:"10:32 AM" },
    { sender:"them", text:"The patient has intermittent chest pain, but their ECG shows normal sinus rhythm. However, there's an elevation in troponin levels.", time:"10:35 AM" },
    { sender:"me",   text:"That's interesting. Have you checked for pericarditis? Sometimes it can present with normal ECG but elevated troponin.", time:"10:38 AM" },
    { sender:"them", text:"I hadn't considered that. I'll order an echocardiogram to check for pericardial effusion.",    time:"10:40 AM" },
    { sender:"them", text:"I'll check the patient's records for any history of autoimmune disorders as well.",             time:"10:42 AM" }
]};
var currentChatId = 1;
var activeTab     = "all";
var actionBtnsVisible = false;

// Call state
var activeAudioModal  = null, activeVideoModal = null;
var audioTimerSecs    = 0,    videoTimerSecs   = 0;
var audioTimerInt     = null, videoTimerInt    = null;
var isAudioMuted      = false, isAudioSpeakerOff = false;
var isVideoMuted      = false, isVideoSpeakerOff = false, isVideoCamOff = false;
var isAudioPip        = false, isVideoPip = false;
var audioContactName  = "Dr. Okello James";

// ── PIP UTILITIES ─────────────────────────────────────────────────────────────
function syncPip(type, name, secs) {
    try {
        sessionStorage.setItem('pipData', JSON.stringify({
            type: type, contactName: name, seconds: secs,
            muted:      type==='audio' ? isAudioMuted    : isVideoMuted,
            speakerOff: type==='audio' ? isAudioSpeakerOff : isVideoSpeakerOff,
            cameraOff:  isVideoCamOff
        }));
    } catch(e){}
}
function clearPip() { sessionStorage.removeItem('pipData'); }
function enablePip(modal, container) {
    modal.classList.add('pip-active');
    modal.style.cssText += ';background:transparent!important;backdrop-filter:none!important;pointer-events:none!important;';
    container.style.pointerEvents = 'auto';
    container.classList.add('pip-mode');
}
function disablePip(modal, container) {
    modal.classList.remove('pip-active');
    modal.style.background     = 'rgba(0,0,0,0.85)';
    modal.style.backdropFilter = 'blur(8px)';
    modal.style.pointerEvents  = 'auto';
    container.classList.remove('pip-mode');
}

// ── TOAST ─────────────────────────────────────────────────────────────────────
function showToast(msg, isErr) {
    var old = document.querySelector('.pip-toast');
    if (old) old.remove();
    var t = document.createElement('div');
    t.className = 'pip-toast';
    t.style.cssText = 'position:fixed;bottom:80px;right:20px;z-index:99998;background:' +
        (isErr ? '#ef4444' : '#1e293b') +
        ';color:#fff;padding:10px 16px;border-radius:10px;font-size:13px;font-weight:500;' +
        'box-shadow:0 4px 20px rgba(0,0,0,.4);animation:pipSlideIn .2s ease both;max-width:280px;';
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(function(){ if(t.parentNode) t.remove(); }, 3000);
}

// ── TIMER UTIL ───────────────────────────────────────────────────────────────
function fmtTime(s) {
    var h=Math.floor(s/3600), m=Math.floor((s%3600)/60), ss=s%60;
    return [h,m,ss].map(function(v){ return String(v).padStart(2,'0'); }).join(':');
}

// ── INPUT STATE ──────────────────────────────────────────────────────────────
function setInputState(blocked) {
    var inp  = document.getElementById('messageInput');
    var send = document.getElementById('sendBtn');
    var plus = document.getElementById('plusBtn');
    if (!inp) return;
    inp.disabled        = !!blocked;
    inp.placeholder     = blocked ? 'You cannot message a blocked user' : 'Type a message…';
    if (send) { send.style.opacity = blocked ? '0.4' : '1'; send.style.pointerEvents = blocked ? 'none' : 'auto'; }
    if (plus) { plus.style.opacity = blocked ? '0.4' : '1'; plus.style.pointerEvents = blocked ? 'none' : 'auto'; }
}

// ── RENDER CHAT LIST ─────────────────────────────────────────────────────────
function renderChatList() {
    var container = document.getElementById('chatList');
    if (!container) return;
    var list = chats.filter(function(c){
        if (activeTab === 'unread') return c.unread > 0;
        if (activeTab === 'groups') return c.group;
        return true;
    });
    container.innerHTML = list.map(function(c) {
        var isActive = c.id === currentChatId;
        return '<button class="chat-item flex w-full items-center mt-1 gap-3 rounded-lg p-2 text-left transition-colors hover:bg-gray-100 '+(isActive?'bg-gray-100':'')+' '+(c.blocked?'opacity-75':'')+'" data-id="'+c.id+'">' +
            '<div class="relative">' +
                '<span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><span class="flex h-full w-full items-center justify-center rounded-full bg-muted">'+c.avatar+'</span></span>' +
                (!c.blocked && c.status==='online' ? '<span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-background bg-green-500"></span>' : '') +
                (c.blocked ? '<span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-background bg-red-500"></span>' : '') +
            '</div>' +
            '<div class="flex-1 overflow-hidden">' +
                '<div class="flex items-center justify-between"><span class="font-medium text-sm">'+c.name+'</span><span class="text-xs text-gray-400">'+c.time+'</span></div>' +
                '<div class="flex items-center justify-between">' +
                    '<p class="truncate text-xs '+(c.blocked?'text-gray-400 italic':'text-gray-500')+'">'+(c.blocked?'Blocked':c.lastMsg)+'</p>' +
                    ((!c.blocked && c.unread > 0) ? '<span class="inline-flex items-center rounded-full bg-primary text-primary-foreground px-1.5 text-xs font-semibold ml-1">'+c.unread+'</span>' : '') +
                '</div>' +
            '</div>' +
        '</button>';
    }).join('');
    container.querySelectorAll('.chat-item').forEach(function(el) {
        el.addEventListener('click', function() {
            currentChatId = parseInt(el.dataset.id);
            var chat = chats.find(function(c){ return c.id === currentChatId; });
            if (chat && chat.unread > 0) { chat.unread = 0; }
            renderChatList();
            renderMessages();
            updateChatHeader();
            setInputState(chat && chat.blocked);
        });
    });
}

// ── RENDER MESSAGES ──────────────────────────────────────────────────────────
function renderMessages() {
    var container = document.getElementById('messagesList');
    if (!container) return;
    var msgs = messages[currentChatId] || [];
    var chatAvatar = (chats.find(function(c){return c.id===currentChatId;})||{}).avatar || 'U';
    container.innerHTML = msgs.map(function(m) {
        var isMe = m.sender === 'me';
        var bubble = '';
        if (m.attachment) {
            var att = m.attachment;
            if (att.type === 'location') {
                bubble = '<div style="display:flex;align-items:center;gap:10px;padding:8px;background:#f1f5f9;border-radius:10px;">' +
                    '<div style="background:#e0e7ff;color:#4f46e5;border-radius:8px;padding:8px;flex-shrink:0;"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></svg></div>' +
                    '<div><div class="text-sm font-medium">'+att.name+'</div><div class="text-xs text-gray-500">'+att.lat+', '+att.lng+'</div></div></div>';
            } else if (att.type === 'contact') {
                bubble = '<div style="display:flex;align-items:center;gap:10px;padding:8px;background:#f1f5f9;border-radius:10px;">' +
                    '<div style="background:#e0e7ff;color:#4f46e5;border-radius:8px;padding:8px;flex-shrink:0;"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="7" r="4"/><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/></svg></div>' +
                    '<div><div class="text-sm font-medium">'+att.name+'</div><div class="text-xs text-gray-500">'+att.phone+'</div></div></div>';
            } else {
                var preview = (att.preview) ? '<img src="user.png"+att.preview+'" style="max-width:180px;max-height:130px;border-radius:8px;display:block;margin-bottom:6px;" alt="User profile photo">' : '';
                bubble = preview +
                    '<div style="display:flex;align-items:center;gap:10px;padding:8px;background:#f1f5f9;border-radius:10px;">' +
                    '<div style="background:#e0e7ff;color:#4f46e5;border-radius:8px;padding:8px;flex-shrink:0;"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg></div>' +
                    '<div><div class="text-sm font-medium">'+att.name+'</div><div class="text-xs text-gray-500">'+(att.size||'')+'</div></div></div>';
            }
        } else {
            bubble = '<p class="text-sm leading-relaxed">'+m.text+'</p>';
        }
        var avatar = !isMe ? '<span class="relative flex shrink-0 overflow-hidden rounded-full h-8 w-8 mr-1"><span class="flex h-full w-full items-center justify-center rounded-full bg-muted text-xs">'+chatAvatar+'</span></span>' : '';
        var tick = isMe ? '<svg class="h-3 w-3 opacity-70" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 7 17l-5-5"/><path d="m22 10-7.5 7.5L13 16"/></svg>' : '';
        return '<div class="flex '+(isMe?'justify-end':'justify-start')+' mb-3">' +
            '<div class="flex items-end gap-1 max-w-xs lg:max-w-md">' +
                (!isMe ? avatar : '') +
                '<div class="rounded-2xl px-3 py-2 '+(isMe?'bg-primary text-white rounded-br-sm':'bg-muted text-gray-800 rounded-bl-sm')+'">' +
                    bubble +
                    '<div class="flex items-center justify-end gap-1 mt-1 text-xs '+(isMe?'text-white/60':'text-gray-400')+'">'+m.time+' '+tick+'</div>' +
                '</div>' +
            '</div>' +
        '</div>';
    }).join('');
    var area = document.getElementById('messagesArea');
    if (area) setTimeout(function(){ area.scrollTop = area.scrollHeight; }, 40);
}

// ── CHAT HEADER ───────────────────────────────────────────────────────────────
function updateChatHeader() {
    var chat = chats.find(function(c){ return c.id === currentChatId; });
    if (!chat) return;
    var nameEl   = document.getElementById('chatName');
    var roleEl   = document.getElementById('chatRole');
    var avatarEl = document.getElementById('chatAvatar');
    var statusEl = document.getElementById('chatStatus');
    if (nameEl)   nameEl.textContent   = chat.name;
    if (roleEl)   roleEl.textContent   = chat.role;
    if (avatarEl) avatarEl.textContent = chat.avatar;
    if (statusEl) {
        statusEl.textContent = chat.blocked ? 'Blocked' : (chat.status === 'online' ? 'Online' : 'Offline');
        statusEl.className   = 'text-xs ' + (chat.blocked ? 'text-red-500' : (chat.status==='online' ? 'text-green-500' : 'text-gray-400'));
    }
}
function updateChatLastMsg(text) {
    var chat = chats.find(function(c){ return c.id === currentChatId; });
    if (chat) { chat.lastMsg = text; chat.time = 'Just now'; renderChatList(); }
}
function sendMessage() {
    var chat = chats.find(function(c){ return c.id === currentChatId; });
    if (chat && chat.blocked) { showToast('Cannot message a blocked user.', true); return; }
    var inp  = document.getElementById('messageInput');
    var text = inp ? inp.value.trim() : '';
    if (!text) return;
    if (!messages[currentChatId]) messages[currentChatId] = [];
    messages[currentChatId].push({ sender:'me', text:text, time:new Date().toLocaleTimeString([],{hour:'2-digit',minute:'2-digit'}) });
    renderMessages();
    inp.value = '';
    updateChatLastMsg(text);
}

// ── MODAL HELPERS ────────────────────────────────────────────────────────────
function makeLightModal(innerHTML, maxWidth) {
    var overlay = document.createElement('div');
    overlay.className = 'modal-overlay';
    overlay.style.background = 'rgb(0 0 0 / 87%)';
    overlay.style.backdropFilter = 'blur(4px)';
    overlay.innerHTML = '<div class="light-modal-container rounded-lg" style="max-width:'+(maxWidth||500)+'px;">'+innerHTML+'</div>';
    document.body.appendChild(overlay);
    overlay.addEventListener('click', function(e){ if(e.target===overlay) overlay.remove(); });
    return overlay;
}

// ── INFO MODAL (FULL DETAILED VERSION) ────────────────────────────────────────
function showInfoModal() {
    var chat = chats.find(function(c){ return c.id === currentChatId; });
    if (!chat) return;
    var overlay = makeLightModal(
        '<div class="flex items-center justify-between p-4 border-b">' +
            '<h2 class="text-lg font-semibold text-gray-900">Conversation Info</h2>' +
            '<button class="close-modal p-1 hover:bg-gray-100 rounded-full text-gray-500">' +
                '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>' +
            '</button>' +
        '</div>' +
        '<div class="p-6 space-y-4 text-center">' +
            '<div class="w-24 h-24 rounded-full bg-indigo-500 flex items-center justify-center text-3xl font-bold text-white mx-auto">'+chat.avatar+'</div>' +
            '<div>' +
                '<h3 class="text-xl font-semibold text-gray-900">'+chat.name+'</h3>' +
                '<p class="text-gray-500">'+chat.role+'</p>' +
            '</div>' +
            '<div class="grid grid-cols-3 gap-3 pt-2">' +
                '<div class="p-4 bg-gray-100 rounded-lg"><div class="text-2xl font-bold text-indigo-600">24</div><div class="text-xs text-gray-500">Audio Calls</div></div>' +
                '<div class="p-4 bg-gray-100 rounded-lg"><div class="text-2xl font-bold text-purple-600">12</div><div class="text-xs text-gray-500">Video Calls</div></div>' +
                '<div class="p-4 bg-gray-100 rounded-lg"><div class="text-2xl font-bold text-green-600">342</div><div class="text-xs text-gray-500">Messages</div></div>' +
            '</div>' +
            '<div class="border-t pt-4">' +
                '<div class="flex justify-between text-sm"><span class="text-gray-500">Member since</span><span class="text-gray-900">April 2023</span></div>' +
            '</div>' +
        '</div>', 500
    );
    overlay.querySelector('.close-modal').onclick = function(){ overlay.remove(); };
}

// ── CLEAR CHAT CONFIRMATION ──────────────────────────────────────────────────
function showClearChatConfirm() {
    var overlay = document.createElement('div');
    overlay.className = 'modal-overlay';
    overlay.style.background = 'rgb(0 0 0 / 87%)';
    overlay.style.backdropFilter = 'blur(4px)';
    overlay.innerHTML =
        '<div role="alertdialog" class="fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-background p-6 shadow-lg sm:rounded-lg" style="pointer-events:auto;animation:fadeIn .2s ease-out,scaleIn .2s ease-out;">' +
            '<div class="flex flex-col space-y-2 text-center sm:text-left">' +
                '<h2 class="text-lg font-semibold">Are you sure you want to clear this conversation?</h2>' +
                '<p class="text-sm text-muted-foreground">This action cannot be undone. All messages in this conversation will be permanently removed.</p>' +
            '</div>' +
            '<div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">' +
                '<button id="cancelClearChat" class="inline-flex items-center justify-center rounded-md border border-input bg-background hover:bg-accent h-10 px-4 py-2 text-sm font-medium mt-2 sm:mt-0">Cancel</button>' +
                '<button id="confirmClearChat" class="inline-flex items-center justify-center gap-2 rounded-md bg-red-500 text-white hover:bg-red-700 h-10 px-4 py-2 text-sm font-medium">' +
                    '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>' +
                    'Clear Chat' +
                '</button>' +
            '</div>' +
        '</div>';
    document.body.appendChild(overlay);
    overlay.querySelector('#cancelClearChat').onclick = function(){ overlay.remove(); };
    overlay.querySelector('#confirmClearChat').onclick = function(){
        messages[currentChatId] = [];
        renderMessages();
        updateChatLastMsg('Chat cleared');
        overlay.remove();
        showToast('Chat cleared successfully');
    };
    overlay.addEventListener('click', function(e){ if(e.target===overlay) overlay.remove(); });
}

// ── REPORT USER MODAL ────────────────────────────────────────────────────────
function showReportModal() {
    var chat = chats.find(function(c){ return c.id === currentChatId; });
    if (!chat) return;
    var overlay = makeLightModal(
        '<div class="flex items-center justify-between p-4 border-b">' +
            '<h2 class="text-lg font-semibold text-gray-900">Report User</h2>' +
            '<button class="close-modal p-1 hover:bg-gray-100 rounded-full text-gray-500">' +
                '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>' +
            '</button>' +
        '</div>' +
        '<div class="p-6">' +
            '<p class="text-sm text-gray-500 mb-4">You are reporting <strong class="text-gray-900">'+chat.name+'</strong>. Please select a reason:</p>' +
            '<div class="space-y-3 mb-4">' +
                '<label class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer"><input type="radio" name="reportReason" value="spam" class="mt-0.5"><div><p class="font-medium text-gray-900 text-sm">Spam or promotional content</p><p class="text-xs text-gray-500">Unsolicited messages or advertisements</p></div></label>' +
                '<label class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer"><input type="radio" name="reportReason" value="harassment" class="mt-0.5"><div><p class="font-medium text-gray-900 text-sm">Harassment or bullying</p><p class="text-xs text-gray-500">Offensive, intimidating, or threatening behavior</p></div></label>' +
                '<label class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer"><input type="radio" name="reportReason" value="inappropriate" class="mt-0.5"><div><p class="font-medium text-gray-900 text-sm">Inappropriate content</p><p class="text-xs text-gray-500">Content that violates professional standards</p></div></label>' +
                '<label class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 hover:bg-gray-50 cursor-pointer"><input type="radio" name="reportReason" value="other" class="mt-0.5"><div><p class="font-medium text-gray-900 text-sm">Other</p><p class="text-xs text-gray-500">Any other reason not listed above</p></div></label>' +
            '</div>' +
            '<div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">Additional details (optional)</label><textarea id="reportDetails" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Describe the issue..."></textarea></div>' +
            '<div class="flex justify-end gap-3">' +
                '<button class="cancel-modal px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</button>' +
                '<button id="submitReportBtn" class="px-4 py-2 bg-red-500 text-white rounded-md text-sm font-medium hover:bg-red-600 opacity-50 cursor-not-allowed" disabled>Submit Report</button>' +
            '</div>' +
        '</div>', 520
    );
    var submitBtn = overlay.querySelector('#submitReportBtn');
    overlay.querySelectorAll('input[name="reportReason"]').forEach(function(r){
        r.addEventListener('change', function(){
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50','cursor-not-allowed');
        });
    });
    overlay.querySelector('.close-modal').onclick = function(){ overlay.remove(); };
    overlay.querySelector('.cancel-modal').onclick = function(){ overlay.remove(); };
    submitBtn.onclick = function(){
        var reason = overlay.querySelector('input[name="reportReason"]:checked');
        if (!reason) { showToast('Please select a reason', true); return; }
        overlay.remove();
        showToast('Report submitted for '+chat.name);
    };
}

// ── BLOCK USER CONFIRMATION ──────────────────────────────────────────────────
function showBlockConfirm() {
    var chat = chats.find(function(c){ return c.id === currentChatId; });
    if (!chat) return;
    var overlay = makeLightModal(
        '<div class="flex items-center justify-between p-4 border-b">' +
            '<h2 class="text-lg font-semibold text-gray-900">Block User</h2>' +
            '<button class="close-modal p-1 hover:bg-gray-100 rounded-full text-gray-500">' +
                '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>' +
            '</button>' +
        '</div>' +
        '<div class="p-6">' +
            '<div class="flex items-center gap-3 mb-4">' +
                '<div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center"><svg class="h-6 w-6 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" x2="19.07" y1="4.93" y2="19.07"></line></svg></div>' +
                '<div><p class="font-medium text-gray-900">Block '+chat.name+'?</p><p class="text-sm text-gray-500">@'+chat.name.toLowerCase().replace(/\\s+/g,'.')+'</p></div>' +
            '</div>' +
            '<div class="bg-gray-50 rounded-lg p-4 mb-4">' +
                '<p class="text-sm text-gray-600 mb-3">When you block this user:</p>' +
                '<ul class="space-y-2 text-sm text-gray-500">' +
                    '<li class="flex items-start gap-2"><svg class="h-4 w-4 text-gray-400 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"></line><line x1="6" x2="18" y1="6" y2="18"></line></svg>They will no longer be able to send you messages</li>' +
                    '<li class="flex items-start gap-2"><svg class="h-4 w-4 text-gray-400 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"></line><line x1="6" x2="18" y1="6" y2="18"></line></svg>Your conversation history will be preserved</li>' +
                    '<li class="flex items-start gap-2"><svg class="h-4 w-4 text-gray-400 mt-0.5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" x2="6" y1="6" y2="18"></line><line x1="6" x2="18" y1="6" y2="18"></line></svg>You can unblock them anytime from Settings</li>' +
                '</ul>' +
            '</div>' +
            '<label class="flex items-center gap-2 mb-4 cursor-pointer"><input type="checkbox" id="blockAndReport" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"><span class="text-sm text-gray-700">Also report this user</span></label>' +
            '<div class="flex justify-end gap-3">' +
                '<button class="cancel-modal px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">Cancel</button>' +
                '<button id="confirmBlockBtn" class="px-4 py-2 bg-red-500 text-white rounded-md text-sm font-medium hover:bg-red-600">Block User</button>' +
            '</div>' +
        '</div>'
    );
    overlay.querySelector('.close-modal').onclick = function(){ overlay.remove(); };
    overlay.querySelector('.cancel-modal').onclick = function(){ overlay.remove(); };
    overlay.querySelector('#confirmBlockBtn').onclick = function(){
        var alsoReport = overlay.querySelector('#blockAndReport').checked;
        chat.blocked = true;
        renderChatList(); updateChatHeader(); setInputState(true);
        overlay.remove();
        showToast(chat.name + (alsoReport ? ' blocked and reported' : ' has been blocked'));
    };
}

// ── UNBLOCK USER CONFIRMATION ────────────────────────────────────────────────
function showUnblockConfirm() {
    var chat = chats.find(function(c){ return c.id === currentChatId; });
    if (!chat) return;
    var overlay = document.createElement('div');
    overlay.className = 'modal-overlay';
    overlay.style.background = 'rgb(0 0 0 / 87%)';
    overlay.style.backdropFilter = 'blur(4px)';
    overlay.innerHTML =
        '<div role="alertdialog" class="fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-background p-6 shadow-lg sm:rounded-lg" style="pointer-events:auto;animation:fadeIn .2s ease-out;">' +
            '<div class="flex flex-col space-y-2 text-center sm:text-left">' +
                '<h2 class="text-lg font-semibold">Unblock '+chat.name+'?</h2>' +
                '<p class="text-sm text-muted-foreground">They will be able to send you messages again. Your conversation history will be restored.</p>' +
            '</div>' +
            '<div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2">' +
                '<button id="cancelUnblock" class="inline-flex items-center justify-center rounded-md border border-input bg-background hover:bg-accent h-10 px-4 py-2 text-sm mt-2 sm:mt-0">Cancel</button>' +
                '<button id="confirmUnblockBtn" class="inline-flex items-center justify-center gap-2 rounded-md bg-green-500 text-white hover:bg-green-600 h-10 px-4 py-2 text-sm">' +
                    '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m9 12 2 2 4-4"/></svg>Unblock User</button>' +
            '</div>' +
        '</div>';
    document.body.appendChild(overlay);
    overlay.querySelector('#cancelUnblock').onclick = function(){ overlay.remove(); };
    overlay.querySelector('#confirmUnblockBtn').onclick = function(){
        chat.blocked = false;
        renderChatList(); updateChatHeader(); setInputState(false);
        overlay.remove();
        showToast(chat.name + ' has been unblocked');
    };
    overlay.addEventListener('click', function(e){ if(e.target===overlay) overlay.remove(); });
}

// ── CHAT SETTINGS MODAL ──────────────────────────────────────────────────────
function showChatSettingsModal() {
    var chat = chats.find(function(c){ return c.id === currentChatId; }) || {name:'Unknown',role:'',avatar:'?'};
    var overlay = document.createElement('div');
    overlay.className = 'modal-overlay';
    overlay.style.background = 'rgb(0 0 0 / 87%)';
    overlay.style.backdropFilter = 'blur(4px)';
    overlay.innerHTML =
        '<div role="dialog" class="fixed left-[50%] top-[50%] z-50 grid w-full max-w-lg translate-x-[-50%] translate-y-[-50%] gap-4 border bg-background p-6 shadow-lg sm:rounded-lg" style="pointer-events:auto;animation:fadeIn .2s ease-out;">' +
            '<div class="flex items-center justify-between">' +
                '<h2 class="text-lg font-semibold">Chat Settings</h2>' +
                '<button id="closeChatSettings" class="p-1 hover:bg-gray-100 rounded-full text-gray-500">' +
                    '<svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>' +
                '</button>' +
            '</div>' +
            '<div class="space-y-4">' +
                '<div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">' +
                    '<div class="w-12 h-12 rounded-full bg-indigo-500 flex items-center justify-center text-lg font-bold text-white">'+chat.avatar+'</div>' +
                    '<div><p class="font-medium">'+chat.name+'</p><p class="text-sm text-muted-foreground">'+chat.role+'</p></div>' +
                '</div>' +
                '<div class="h-px bg-gray-200"></div>' +
                '<div class="flex items-center justify-between"><div><p class="text-sm font-medium">Mute Notifications</p><p class="text-xs text-muted-foreground">Stop receiving notifications</p></div>' +
                    '<label class="toggle-switch"><input type="checkbox" id="muteNotifications"><span class="toggle-slider"></span></label></div>' +
                '<div class="flex items-center justify-between"><div><p class="text-sm font-medium">Pin Conversation</p><p class="text-xs text-muted-foreground">Keep at top of list</p></div>' +
                    '<label class="toggle-switch"><input type="checkbox" id="pinConversation"><span class="toggle-slider"></span></label></div>' +
                '<div class="flex items-center justify-between"><div><p class="text-sm font-medium">Disappearing Messages</p><p class="text-xs text-muted-foreground">Auto-delete after 24h</p></div>' +
                    '<label class="toggle-switch"><input type="checkbox" id="disappearingMessages"><span class="toggle-slider"></span></label></div>' +
                '<div class="h-px bg-gray-200"></div>' +
                '<div><p class="text-sm font-medium mb-2">Shared Media</p><div class="grid grid-cols-4 gap-2"><div class="aspect-square bg-gray-100 rounded-lg flex items-center justify-center text-xs text-gray-400">No media</div></div></div>' +
            '</div>' +
            '<div class="flex justify-end gap-2 pt-2">' +
                '<button id="cancelChatSettings" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background px-4 py-2 text-sm font-medium hover:bg-gray-50">Close</button>' +
                '<button id="saveChatSettings" class="px-4 py-2 bg-blue- text-white rounded-md text-sm font-medium hover:bg-primary/90">Save Changes</button>' +
            '</div>' +
        '</div>';
    document.body.appendChild(overlay);
    overlay.querySelector('#closeChatSettings').onclick = function(){ overlay.remove(); };
    overlay.querySelector('#cancelChatSettings').onclick = function(){ overlay.remove(); };
    overlay.querySelector('#saveChatSettings').onclick = function(){
        overlay.remove();
        showToast('Chat settings saved');
    };
    overlay.addEventListener('click', function(e){ if(e.target===overlay) overlay.remove(); });
}

// ── MORE POPOVER (WITH SVG ICONS) ────────────────────────────────────────────
function showMorePopover(btn) {
    var existing = document.getElementById('morePopover');
    if (!existing) return;
    var chat = chats.find(function(c){ return c.id === currentChatId; }) || {};
    existing.innerHTML =
        '<div class="popover-item" data-action="clear">' +
            '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path><line x1="10" x2="10" y1="11" y2="17"></line><line x1="14" x2="14" y1="11" y2="17"></line></svg>' +
            'Clear Chat' +
        '</div>' +
        '<div class="popover-item" data-action="report">' +
            '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l4 2"></path></svg>' +
            'Report User' +
        '</div>' +
        (chat.blocked ?
        '<div class="popover-item" data-action="unblock">' +
            '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="m9 12 2 2 4-4"></path></svg>' +
            'Unblock User' +
        '</div>' :
        '<div class="popover-item" data-action="block">' +
            '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" x2="19.07" y1="4.93" y2="19.07"></line></svg>' +
            'Block User' +
        '</div>') +
        '<div class="popover-item" data-action="profile">' +
            '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"></circle><path d="M5.5 20.5a7 7 0 0 1 13 0"></path></svg>' +
            'View Profile' +
        '</div>' +
        '<div class="h-px bg-gray-200 my-1"></div>' +
        '<div class="popover-item" data-action="settings">' +
            '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>' +
            'Chat Settings' +
        '</div>';
    var rect = btn.getBoundingClientRect();
    existing.style.cssText = 'position:fixed;top:'+(rect.bottom+4)+'px;left:'+Math.min(rect.right-200, window.innerWidth-210)+'px;';
    existing.classList.remove('hidden');
    existing.querySelectorAll('.popover-item').forEach(function(item) {
        item.addEventListener('click', function(e){
            e.stopPropagation();
            existing.classList.add('hidden');
            switch(item.dataset.action) {
                case 'clear': showClearChatConfirm(); break;
                case 'report': showReportModal(); break;
                case 'block': showBlockConfirm(); break;
                case 'unblock': showUnblockConfirm(); break;
                case 'profile': window.location.href = 'staff-profile.html'; break;
                case 'settings': showChatSettingsModal(); break;
            }
        });
    });
    function closePop(e) {
        if (!existing.contains(e.target) && e.target !== btn) {
            existing.classList.add('hidden');
            document.removeEventListener('click', closePop);
        }
    }
    setTimeout(function(){ document.addEventListener('click', closePop); }, 10);
}

// ── NEW CONVERSATION ──────────────────────────────────────────────────────────
function showNewConversationModal() {
    var contacts = [
        { name:"Dr. Robert Chen",   role:"Neurologist",       avatar:"RC", status:"online"  },
        { name:"Dr. Nabwire Lisa",     role:"Pediatrician",      avatar:"LW", status:"online"  },
        { name:"Dr. Ssali Michael", role:"Orthopedic Surgeon", avatar:"MB", status:"offline" },
        { name:"Dr. Patricia Lee",  role:"Dermatologist",     avatar:"PL", status:"online"  },
        { name:"Dr. Thomas Clark",  role:"Radiologist",       avatar:"TC", status:"offline" }
    ];
    var overlay = document.createElement('div');
    overlay.className = 'modal-overlay';
    overlay.innerHTML =
        '<div style="background:#fff;border-radius:14px;width:90%;max-width:520px;max-height:85vh;overflow:hidden;box-shadow:0 25px 60px rgba(0,0,0,.3);">' +
        '<div style="padding:18px 20px;border-bottom:1px solid #f1f5f9;display:flex;justify-content:space-between;align-items:center;">' +
            '<h2 style="font-weight:600;font-size:1rem;">Start New Conversation</h2>' +
            '<button class="close-new" style="background:none;border:none;cursor:pointer;padding:4px;border-radius:6px;">✕</button>' +
        '</div>' +
        '<div style="padding:12px 16px;border-bottom:1px solid #f8fafc;">' +
            '<div style="position:relative;"><svg style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#9ca3af;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>' +
            '<input id="newChatSearch" placeholder="Search by name or specialty…" style="width:100%;padding:8px 8px 8px 34px;border:1px solid #e5e7eb;border-radius:8px;font-size:13px;outline:none;"></div>' +
        '</div>' +
        '<div id="contactsList" style="overflow-y:auto;max-height:350px;padding:8px 12px;"></div>' +
        '</div>';
    document.body.appendChild(overlay);
    function renderContacts(list) {
        var el = overlay.querySelector('#contactsList');
        el.innerHTML = list.length ? list.map(function(c){
            return '<div class="contact-row" data-name="'+c.name+'" data-role="'+c.role+'" data-avatar="'+c.avatar+'" ' +
                'style="display:flex;align-items:center;gap:12px;padding:10px;border-radius:10px;cursor:pointer;transition:background .12s;" ' +
                'onmouseover="this.style.background=\'#f8fafc\'" onmouseout="this.style.background=\'\'">' +
                    '<div style="position:relative;">' +
                        '<div style="width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:600;font-size:14px;">'+c.avatar+'</div>' +
                        '<span style="position:absolute;bottom:1px;right:1px;width:11px;height:11px;border-radius:50%;background:'+(c.status==='online'?'#22c55e':'#9ca3af')+';border:2px solid #fff;"></span>' +
                    '</div>' +
                    '<div style="flex:1;"><div style="font-size:13px;font-weight:600;">'+c.name+'</div><div style="font-size:11px;color:#6b7280;">'+c.role+'</div></div>' +
                    '<div style="width:32px;height:32px;background:#eef2ff;border-radius:8px;display:flex;align-items:center;justify-content:center;">' +
                        '<svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2"><path d="M22 17a2 2 0 0 1-2 2H6.828a2 2 0 0 0-1.414.586l-2.202 2.202A.71.71 0 0 1 2 21.286V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2z"/></svg>' +
                    '</div>' +
            '</div>';
        }).join('') : '<p style="text-align:center;padding:24px;color:#9ca3af;font-size:13px;">No contacts found</p>';
        overlay.querySelectorAll('.contact-row').forEach(function(row) {
            row.addEventListener('click', function() {
                var newId = Date.now();
                chats.unshift({ id:newId, name:row.dataset.name, role:row.dataset.role, avatar:row.dataset.avatar, unread:0, lastMsg:'New conversation', time:'Just now', status:'online', blocked:false, group:false });
                messages[newId] = [];
                currentChatId = newId;
                renderChatList(); renderMessages(); updateChatHeader(); setInputState(false);
                overlay.remove();
                showToast('Conversation started with '+row.dataset.name);
            });
        });
    }
    renderContacts(contacts);
    overlay.querySelector('.close-new').onclick = function(){ overlay.remove(); };
    overlay.addEventListener('click', function(e){ if(e.target===overlay) overlay.remove(); });
    overlay.querySelector('#newChatSearch').addEventListener('input', function(e){
        var q = e.target.value.toLowerCase();
        renderContacts(contacts.filter(function(c){ return c.name.toLowerCase().includes(q) || c.role.toLowerCase().includes(q); }));
    });
}

// ── ATTACHMENT HANDLER ────────────────────────────────────────────────────────
function initAttachments() {
    var plusBtn  = document.getElementById('plusBtn');
    var actCont  = document.getElementById('actionButtonsContainer');
    if (!plusBtn || !actCont) return;
    plusBtn.addEventListener('click', function() {
        var chat = chats.find(function(c){ return c.id === currentChatId; });
        if (chat && chat.blocked) { showToast('Cannot attach files for a blocked user.', true); return; }
        actionBtnsVisible = !actionBtnsVisible;
        actCont.classList.toggle('hidden', !actionBtnsVisible);
    });
    actCont.querySelectorAll('.action-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var action = btn.dataset.action;
            if (action === 'location') {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        function(p) { addAttachment({ type:'location', name:'Current Location', lat:p.coords.latitude.toFixed(4)+'°', lng:p.coords.longitude.toFixed(4)+'°' }); },
                        function()  { addAttachment({ type:'location', name:'Current Location', lat:'40.7128° N', lng:'74.0060° W' }); }
                    );
                } else { addAttachment({ type:'location', name:'Current Location', lat:'40.7128° N', lng:'74.0060° W' }); }
            } else if (action === 'contact') {
                var n = prompt('Contact name:','Ssentongo John'); if (!n) return;
                var ph = prompt('Phone number:','+256 712 345 678');
                addAttachment({ type:'contact', name:n, phone:ph||'No phone' });
            } else {
                var accept = {file:'.pdf,.doc,.docx,.txt,.xlsx',camera:'image/*',gallery:'image/*',audio:'audio/*',video:'video/*'}[action]||'*';
                var inp = document.createElement('input'); inp.type='file'; inp.accept=accept;
                if (action==='camera') inp.capture='environment';
                inp.onchange = function(e) {
                    var file = e.target.files[0]; if(!file) return;
                    var att = { type:action, name:file.name, size:(file.size/1024/1024).toFixed(2)+' MB' };
                    if (file.type.startsWith('image/')) {
                        var r = new FileReader(); r.onload = function(ev){ att.preview=ev.target.result; addAttachment(att); }; r.readAsDataURL(file);
                    } else { addAttachment(att); }
                };
                inp.click();
            }
        });
    });
}
function addAttachment(att) {
    if (!messages[currentChatId]) messages[currentChatId] = [];
    messages[currentChatId].push({ sender:'me', text:'', time:new Date().toLocaleTimeString([],{hour:'2-digit',minute:'2-digit'}), attachment:att });
    renderMessages();
    updateChatLastMsg('Shared '+att.type);
    var actCont = document.getElementById('actionButtonsContainer');
    if (actCont) actCont.classList.add('hidden');
    actionBtnsVisible = false;
}

// ── MOBILE SIDEBAR ────────────────────────────────────────────────────────────
function initMobileSidebar() {
    var toggle  = document.getElementById('mobileChatMenuToggle');
    var sidebar = document.getElementById('sidebar');
    if (!toggle || !sidebar) return;
    var open = false;
    function setOpen(v) {
        open = v;
        if (v) { sidebar.classList.remove('max-md:-translate-x-full'); sidebar.classList.add('max-md:translate-x-0'); document.body.style.overflow='hidden'; }
        else   { sidebar.classList.add('max-md:-translate-x-full');    sidebar.classList.remove('max-md:translate-x-0'); document.body.style.overflow=''; }
    }
    toggle.addEventListener('click', function(e){ e.stopPropagation(); setOpen(!open); });
    sidebar.addEventListener('click', function(e){ if(e.target.closest('.chat-item') && window.innerWidth < 768) setTimeout(function(){ setOpen(false); },150); });
    document.addEventListener('click', function(e){ if(open && window.innerWidth<768 && !sidebar.contains(e.target) && !toggle.contains(e.target)) setOpen(false); });
    document.addEventListener('keydown', function(e){ if(e.key==='Escape'&&open) setOpen(false); });
    window.addEventListener('resize', function(){ if(window.innerWidth>=768&&open) setOpen(false); });
    if (window.innerWidth < 768) setOpen(false);
}

// ── AUDIO CALL ────────────────────────────────────────────────────────────────
function showAudioCall(outgoing, contactName, startSecs) {
    if (activeAudioModal) activeAudioModal.remove();
    audioTimerSecs   = startSecs || 0;
    audioContactName = contactName || 'Unknown';
    isAudioMuted = isAudioSpeakerOff = false;
    var modal = document.createElement('div'); modal.className = 'modal-overlay';
    modal.innerHTML =
    '<div class="modal-container rounded-lg audio-call-container" style="max-width:440px;width:92%;">' +
        '<div class="modal-header flex items-center justify-between p-4 " id="audioHdr" style="background:linear-gradient(135deg,#1e1b4b,#312e81);cursor:move;">' +
            '<div><h1 class="text-white font-semibold">Audio Call</h1><p class="text-white text-xs">'+new Date().toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'})+'</p></div>' +
            '<div class="flex items-center gap-2">' +
                '<span id="aud-timer" class="timer text-amber-400 text-sm font-mono">'+fmtTime(audioTimerSecs)+'</span>' +
                '<button id="aud-pip" class="text-white/70 hover:text-white hover:bg-white/20 p-1.5 rounded-full transition" title="Minimise">' +
                    '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m14 10 7-7"/><path d="M20 10h-6V4"/><path d="m3 21 7-7"/><path d="M4 14h6v6"/></svg>' +
                '</button>' +
            '</div>' +
        '</div>' +
        '<div class="audio-content text-center py-8 px-6" style="background:#0f0f1a;">' +
            '<div class="ring-wrapper inline-block mb-4">' +
                '<div class="avatar-large" style="background:linear-gradient(135deg,#6366f1,#8b5cf6);">'+contactName.charAt(0)+'</div>' +
                '<div class="ring-animation-element"></div>' +
            '</div>' +
            '<h2 class="text-xl font-semibold text-white">'+contactName+'</h2>' +
            '<p id="aud-status" class="text-gray-400 text-sm mt-1">'+(outgoing?'Connected':'Incoming…')+'</p>' +
        '</div>' +
        '<div class="control-buttons flex justify-center gap-3 p-4" style="background:#0f0f1a;border-top:1px solid rgba(255,255,255,.08);">' +
            '<button id="aud-mute" class="control-btn p-3 rounded-lg bg-gray-700 hover:bg-gray-600 text-white transition"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19v3"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><rect x="9" y="2" width="6" height="13" rx="3"/></svg></button>' +
            '<button id="aud-speaker" class="control-btn p-3 rounded-lg bg-gray-700 hover:bg-gray-600 text-white transition"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"/><path d="M16 9a5 5 0 0 1 0 6"/><path d="M19.364 18.364a9 9 0 0 0 0-12.728"/></svg></button>' +
            (!outgoing ? '<button id="aud-accept" class="control-btn p-3 rounded-full bg-green-500 hover:bg-green-600 text-white transition"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></button>' : '') +
            '<button id="aud-end" class="control-btn flex items-center gap-2 px-4 rounded-lg bg-red-500 hover:bg-red-600 text-white font-semibold transition"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18.59 5.41L5.41 18.59"/><path d="M5.41 5.41l13.18 13.18"/></svg> End Call</button>' +
        '</div>' +
    '</div>';
    document.body.appendChild(modal);
    activeAudioModal = modal;
    var container = modal.querySelector('.audio-call-container');
    audioTimerInt = setInterval(function() {
        audioTimerSecs++; var el=document.getElementById('aud-timer'); if(el) el.textContent=fmtTime(audioTimerSecs);
        syncPip('audio', audioContactName, audioTimerSecs);
    }, 1000);
    function endAudio() { clearInterval(audioTimerInt); if(activeAudioModal) activeAudioModal.remove(); activeAudioModal=null; clearPip(); isAudioPip=false; }
    modal.querySelector('#aud-end').onclick = endAudio;
    modal.querySelector('#aud-pip').onclick = function() {
        isAudioPip = !isAudioPip;
        if (isAudioPip) { enablePip(modal, container); syncPip('audio',audioContactName,audioTimerSecs); }
        else disablePip(modal, container);
    };
    var muteBtn = modal.querySelector('#aud-mute');
    muteBtn.onclick = function() {
        isAudioMuted = !isAudioMuted;
        muteBtn.style.background = isAudioMuted ? '#ef4444' : '';
        muteBtn.innerHTML = isAudioMuted ?
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19v3"/><path d="M15 9.34V5a3 3 0 0 0-5.68-1.33"/><path d="M16.95 16.95A7 7 0 0 1 5 12v-2"/><path d="M18.89 13.23A7 7 0 0 0 19 12v-2"/><path d="m2 2 20 20"/><path d="M9 9v3a3 3 0 0 0 5.12 2.12"/></svg>' :
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19v3"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><rect x="9" y="2" width="6" height="13" rx="3"/></svg>';
    };
    var spkBtn = modal.querySelector('#aud-speaker');
    spkBtn.onclick = function() {
        isAudioSpeakerOff = !isAudioSpeakerOff;
        spkBtn.style.background = isAudioSpeakerOff ? '#ef4444' : '';
        spkBtn.innerHTML = isAudioSpeakerOff ?
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"/><line x1="22" x2="16" y1="9" y2="15"/><line x1="16" x2="22" y1="9" y2="15"/></svg>' :
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"/><path d="M16 9a5 5 0 0 1 0 6"/><path d="M19.364 18.364a9 9 0 0 0 0-12.728"/></svg>';
    };
    var accBtn = modal.querySelector('#aud-accept');
    if (accBtn) accBtn.onclick = function() {
        var status = document.getElementById('aud-status'); if(status) status.textContent = 'Connected';
        var ring = modal.querySelector('.ring-animation-element'); if(ring) ring.style.display='none';
        accBtn.remove();
    };
}

// ── VIDEO CALL ────────────────────────────────────────────────────────────────
function showVideoCall(startSecs) {
    if (activeVideoModal) activeVideoModal.remove();
    videoTimerSecs = startSecs || 0;
    isVideoMuted = isVideoSpeakerOff = isVideoCamOff = false;
    var contactName = 'Dr. Mette Andersen';
    var modal = document.createElement('div'); modal.className = 'modal-overlay';
    modal.innerHTML =
    '<div class="modal-container rounded-lg video-call-container" style="max-width:700px;width:95%;">' +
        '<div class="modal-header flex items-center justify-between p-4" id="videoHdr" style="background:linear-gradient(135deg,#1e1b4b,#312e81);cursor:move;">' +
            '<div><h1 class="text-white font-semibold">Session with '+contactName+'</h1><p class="text-white text-xs">'+new Date().toLocaleDateString('en-US',{month:'short',day:'numeric',year:'numeric'})+'</p></div>' +
            '<div class="flex items-center gap-2">' +
                '<span id="vid-timer" class="timer text-amber-400 text-sm font-mono">'+fmtTime(videoTimerSecs)+'</span>' +
                '<button id="vid-pip" class="text-white/70 hover:text-white hover:bg-white/20 p-1.5 rounded-full transition" title="Minimise">' +
                    '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m14 10 7-7"/><path d="M20 10h-6V4"/><path d="m3 21 7-7"/><path d="M4 14h6v6"/></svg>' +
                '</button>' +
            '</div>' +
        '</div>' +
        '<div class="video-container relative" style="aspect-ratio:16/9;margin:12px;border-radius:12px;overflow:hidden;background:#000;">' +
            '<div class="status-badge flex items-center gap-2" style="position:absolute;top:8px;left:8px;z-index:10;">' +
                '<span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span></span>' +
                '<span style="background:rgba(0,0,0,.65);backdrop-filter:blur(4px);border-radius:20px;padding:2px 10px;" class="text-white text-xs font-medium">In progress</span>' +
            '</div>' +
            '<img src="user.png" class="w-full h-full object-cover" style="display:block;" alt="User profile photo">' +
            '<div class="local-video-pip" style="position:absolute;bottom:12px;right:12px;width:130px;border-radius:8px;border:2px solid rgba(255,255,255,.3);overflow:hidden;">' +
                '<img id="vid-local" src="b.jpg" style="width:100%;display:block;" alt="Background image">' +
            '</div>' +
        '</div>' +
        '<div class="control-buttons flex justify-center gap-3 p-4" style="background:#0f0f1a;border-top:1px solid rgba(255,255,255,.08);">' +
            '<button id="vid-mute" class="control-btn p-3 rounded-lg bg-gray-700 hover:bg-gray-600 text-white transition"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19v3"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><rect x="9" y="2" width="6" height="13" rx="3"/></svg></button>' +
            '<button id="vid-speaker" class="control-btn p-3 rounded-lg bg-gray-700 hover:bg-gray-600 text-white transition"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"/><path d="M16 9a5 5 0 0 1 0 6"/><path d="M19.364 18.364a9 9 0 0 0 0-12.728"/></svg></button>' +
            '<button id="vid-cam" class="control-btn p-3 rounded-lg bg-gray-700 hover:bg-gray-600 text-white transition"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13.997 4a2 2 0 0 1 1.76 1.05l.486.9A2 2 0 0 0 18.003 7H20a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1.997a2 2 0 0 0 1.759-1.048l.489-.904A2 2 0 0 1 10.004 4z"/><circle cx="12" cy="13" r="3"/></svg></button>' +
            '<button id="vid-end" class="control-btn flex items-center gap-2 px-4 rounded-lg bg-red-500 hover:bg-red-600 text-white font-semibold transition"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18.59 5.41L5.41 18.59"/><path d="M5.41 5.41l13.18 13.18"/></svg> End Call</button>' +
        '</div>' +
    '</div>';
    document.body.appendChild(modal);
    activeVideoModal = modal;
    var container = modal.querySelector('.video-call-container');
    videoTimerInt = setInterval(function() {
        videoTimerSecs++; var el=document.getElementById('vid-timer'); if(el) el.textContent=fmtTime(videoTimerSecs);
        syncPip('video', contactName, videoTimerSecs);
    }, 1000);
    function endVideo() { clearInterval(videoTimerInt); if(activeVideoModal) activeVideoModal.remove(); activeVideoModal=null; clearPip(); isVideoPip=false; }
    modal.querySelector('#vid-end').onclick = endVideo;
    modal.querySelector('#vid-pip').onclick = function() {
        isVideoPip = !isVideoPip;
        if (isVideoPip) { enablePip(modal, container); syncPip('video',contactName,videoTimerSecs); }
        else disablePip(modal, container);
    };
    var muteBtn = modal.querySelector('#vid-mute');
    muteBtn.onclick = function() {
        isVideoMuted = !isVideoMuted;
        muteBtn.style.background = isVideoMuted ? '#ef4444' : '';
        muteBtn.innerHTML = isVideoMuted ?
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19v3"/><path d="M15 9.34V5a3 3 0 0 0-5.68-1.33"/><path d="M16.95 16.95A7 7 0 0 1 5 12v-2"/><path d="M18.89 13.23A7 7 0 0 0 19 12v-2"/><path d="m2 2 20 20"/><path d="M9 9v3a3 3 0 0 0 5.12 2.12"/></svg>' :
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19v3"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><rect x="9" y="2" width="6" height="13" rx="3"/></svg>';
    };
    var spkBtn = modal.querySelector('#vid-speaker');
    spkBtn.onclick = function() {
        isVideoSpeakerOff = !isVideoSpeakerOff;
        spkBtn.style.background = isVideoSpeakerOff ? '#ef4444' : '';
        spkBtn.innerHTML = isVideoSpeakerOff ?
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"/><line x1="22" x2="16" y1="9" y2="15"/><line x1="16" x2="22" y1="9" y2="15"/></svg>' :
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"/><path d="M16 9a5 5 0 0 1 0 6"/><path d="M19.364 18.364a9 9 0 0 0 0-12.728"/></svg>';
    };
    var camBtn = modal.querySelector('#vid-cam');
    camBtn.onclick = function() {
        isVideoCamOff = !isVideoCamOff;
        camBtn.style.background = isVideoCamOff ? '#ef4444' : '';
        camBtn.innerHTML = isVideoCamOff ?
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.564 14.558a3 3 0 1 1-4.122-4.121"/><path d="m2 2 20 20"/><path d="M20 20H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1.997a2 2 0 0 0 .819-.175"/></svg>' :
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13.997 4a2 2 0 0 1 1.76 1.05l.486.9A2 2 0 0 0 18.003 7H20a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1.997a2 2 0 0 0 1.759-1.048l.489-.904A2 2 0 0 1 10.004 4z"/><circle cx="12" cy="13" r="3"/></svg>';
        var localImg = document.getElementById('vid-local');
        if (localImg) localImg.src = isVideoCamOff ? 'https://ui-avatars.com/api/?name=CAM+OFF&background=ef4444&color=fff&size=160' : 'b.jpg';
    };
}

// ── MAIN INIT ─────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    renderChatList();
    renderMessages();
    updateChatHeader();
    setInputState((chats.find(function(c){return c.id===currentChatId;})||{}).blocked);

    var sendBtn  = document.getElementById('sendBtn');
    var msgInput = document.getElementById('messageInput');
    if (sendBtn)  sendBtn.onclick = sendMessage;
    if (msgInput) msgInput.onkeypress = function(e){ if(e.key==='Enter') sendMessage(); };

    var voiceBtn = document.getElementById('voiceCallBtn');
    var videoBtn = document.getElementById('videoCallBtn');
    var infoBtn  = document.getElementById('infoBtn');
    var moreBtn  = document.getElementById('moreOptionsBtn');
    var newBtn   = document.getElementById('newChatBtn');
    if (voiceBtn) voiceBtn.onclick = function(){ var c=chats.find(function(x){return x.id===currentChatId;}); showAudioCall(true,c?c.name:'Unknown',0); };
    if (videoBtn) videoBtn.onclick = function(){ showVideoCall(0); };
    if (infoBtn)  infoBtn.onclick  = showInfoModal;
    if (moreBtn)  moreBtn.onclick  = function(e){ e.stopPropagation(); showMorePopover(e.currentTarget); };
    if (newBtn)   newBtn.onclick   = showNewConversationModal;

    document.querySelectorAll('.chat-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            activeTab = tab.dataset.tab;
            document.querySelectorAll('.chat-tab').forEach(function(t){
                t.classList.remove('bg-white','text-gray-900','shadow-sm'); t.classList.add('text-gray-500');
            });
            tab.classList.add('bg-white','text-gray-900','shadow-sm');
            renderChatList();
        });
    });

    initAttachments();
    initMobileSidebar();

    // Restore call from PiP
    var pip = null;
    try { pip = JSON.parse(sessionStorage.getItem('pipData')); } catch(e){}
    if (pip && pip.type) {
        if (pip.type === 'audio') {
            isAudioMuted = !!pip.muted; isAudioSpeakerOff = !!pip.speakerOff;
            showAudioCall(true, pip.contactName || audioContactName, pip.seconds || 0);
        } else if (pip.type === 'video') {
            isVideoMuted = !!pip.muted; isVideoSpeakerOff = !!pip.speakerOff; isVideoCamOff = !!pip.cameraOff;
            showVideoCall(pip.seconds || 0);
        }
    }
});

// Save before navigation
window.addEventListener('beforeunload', function() {
    var hasActiveCall = (activeAudioModal || activeVideoModal);
    var isPipActive   = (isAudioPip || isVideoPip);
    if (hasActiveCall && isPipActive) {
        if (isAudioPip)  syncPip('audio', audioContactName,   audioTimerSecs);
        if (isVideoPip)  syncPip('video', 'Dr. Mette Andersen', videoTimerSecs);
    } else if (!hasActiveCall) {
        clearPip();
    }
    if (hasActiveCall && !isPipActive) {
        if (activeAudioModal) syncPip('audio', audioContactName,   audioTimerSecs);
        if (activeVideoModal) syncPip('video', 'Dr. Mette Andersen', videoTimerSecs);
    }
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
    <script src="js/meditrack-action-menu.js"></script>
    <script src="js/meditrack-pagination.js"></script>
    <script src="js/meditrack-search.js"></script>
    <script src="js/meditrack-pdf.js"></script>
    <script src="js/messaging-sync.js"></script>
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
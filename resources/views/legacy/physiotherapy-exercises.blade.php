<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Physiotherapy Exercise Library</title>
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

        .modal-overlay { position: fixed; inset: 0; z-index: 200; background: rgba(0,0,0,0.6); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; animation: fadeIn 0.15s ease-out; }
        .modal-container { background: white; border-radius: 0.75rem; box-shadow: 0 20px 60px rgba(0,0,0,0.2); width: 90%; max-width: 700px; max-height: 85vh; overflow-y: auto; animation: modalSlide 0.2s ease-out; }
        @keyframes modalSlide { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        body.dark .modal-container { background: #131212; border: 1px solid #333; }

        .select-trigger { display: flex; align-items: center; justify-content: space-between; width: 100%; height: 40px; border: 1px solid #d1d5db; background-color: white; padding: 0 0.75rem; font-size: 0.875rem; cursor: pointer; border-radius: 0.375rem; }
        body.dark .select-trigger { background-color: #131212; border-color: #404040; color: #e5e5e5; }
        .select-dropdown { position: absolute; z-index: 50; background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); margin-top: 4px; min-width: 100%; max-height: 200px; overflow-y: auto; }
        body.dark .select-dropdown { background: #2a2a2a; border-color: #404040; }
        .select-item { padding: 0.5rem 0.75rem; cursor: pointer; font-size: 0.875rem; transition: background 0.1s; }
        .select-item:hover { background-color: #f3f4f6; }
        body.dark .select-item:hover { background-color: #3f3f46; }

        .radix-select { position: relative; width: 100%; }
        .radix-select-trigger { display: flex; align-items: center; justify-content: space-between; width: 100%; padding: 0.5rem 0.75rem; font-size: 0.875rem; border-radius: 0.375rem; border: 1px solid #d1d5db; background-color: white; cursor: pointer; min-height: 40px; }
        body.dark .radix-select-trigger { background-color: #131212; border-color: #404040; color: #e5e5e5; }
        .radix-select-content { position: absolute; top: 100%; left: 0; right: 0; margin-top: 4px; background: white; border: 1px solid #e5e7eb; border-radius: 0.375rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); z-index: 10001; overflow: hidden; max-height: 200px; overflow-y: auto; }
        body.dark .radix-select-content { background: #2a2a2a; border-color: #404040; }
        .radix-select-item { padding: 0.5rem 0.75rem; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; justify-content: space-between; }
        .radix-select-item:hover { background-color: #f3f4f6; }
        body.dark .radix-select-item:hover { background-color: #3f3f46; }
        .radix-select-item[data-selected="true"] { background-color: #eef2ff; color: #4f46e5; font-weight: 500; }
        body.dark .radix-select-item[data-selected="true"] { background-color: #1e1b4b; color: #818cf8; }
        .radix-select-item-indicator { display: none; }
        .radix-select-item[data-selected="true"] .radix-select-item-indicator { display: block; }
        @keyframes selectSlideDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }

        .exercise-card { border: 1px solid #e5e7eb; border-radius: 0.75rem; overflow: hidden; transition: all 0.15s; cursor: pointer; background: white; }
        .exercise-card:hover { border-color: #6366f1; box-shadow: 0 4px 12px rgba(0,0,0,0.06); transform: translateY(-2px); }
        body.dark .exercise-card { background: #131212; border-color: #404040; }
        body.dark .exercise-card:hover { border-color: #818cf8; }
        .exercise-card-image { height: 100px; display: flex; align-items: center; justify-content: center; }
        .exercise-card-body { padding: 1rem; }
        .exercise-card-footer { padding: 0.75rem 1rem; border-top: 1px solid #f3f4f6; display: flex; justify-content: space-between; align-items: center; }
        body.dark .exercise-card-footer { border-top-color: #262626; }

        .difficulty-badge { display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.125rem 0.625rem; border-radius: 9999px; font-size: 0.6875rem; font-weight: 600; }
        .difficulty-beginner { background: #d1fae5; color: #065f46; }
        .difficulty-intermediate { background: #fef3c7; color: #92400e; }
        .difficulty-advanced { background: #fee2e2; color: #991b1b; }
        body.dark .difficulty-beginner { background: #064e3b; color: #6ee7b7; }
        body.dark .difficulty-intermediate { background: #451a03; color: #fcd34d; }
        body.dark .difficulty-advanced { background: #450a0a; color: #fca5a5; }

        .detail-section { margin-bottom: 1.25rem; }
        .detail-section-title { font-size: 0.75rem; font-weight: 600; color: #6366f1; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem; }
        body.dark .detail-section-title { color: #818cf8; }
        .precaution-item { display: flex; align-items: flex-start; gap: 0.5rem; padding: 0.375rem 0; font-size: 0.875rem; }

        .video-preview { background: #1f2937; border-radius: 0.5rem; height: 200px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s; position: relative; overflow: hidden; }
        .video-preview:hover .video-play-overlay { opacity: 1; }
        .video-play-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; opacity: 0.7; transition: opacity 0.15s; }
        .video-thumbnail { width: 100%; height: 100%; object-fit: cover; }

        .tag-pill { display: inline-flex; align-items: center; padding: 0.1875rem 0.625rem; border-radius: 9999px; font-size: 0.6875rem; font-weight: 500; background: #f3f4f6; color: #374151; }
        body.dark .tag-pill { background: #262626; color: #d1d5db; }

        .inner-tab-btn { padding: 0.375rem 0.75rem; font-size: 0.8125rem; font-weight: 500; border-radius: 0.25rem; cursor: pointer; transition: all 0.15s; background: transparent; border: none; color: #6b7280; display: inline-flex; align-items: center; gap: 0.25rem; }
        .inner-tab-btn.active { background: white; color: #1f2937; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
        body.dark .inner-tab-btn.active { background: #2a2a2a; color: #e5e5e5; }
        .inner-tab-panel { display: none; }
        .inner-tab-panel.active { display: block; animation: fadeIn 0.2s ease-out; }

        .file-upload-area { border: 2px dashed #d1d5db; border-radius: 0.5rem; padding: 1.5rem; text-align: center; cursor: pointer; transition: all 0.15s; }
        .file-upload-area:hover { border-color: #6366f1; background: #f9fafb; }
        body.dark .file-upload-area { border-color: #404040; }
        body.dark .file-upload-area:hover { border-color: #6366f1; background: #1a1a1a; }
        .video-thumb-preview { width: 100%; height: 120px; border-radius: 0.5rem; object-fit: cover; margin-top: 0.5rem; }
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
                <div><h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Exercise Library</h1><p class="text-gray-500">Browse, search, and manage physiotherapy exercises</p></div>
                <div class="flex gap-2">
                    <button id="addExerciseBtn" class="inline-flex items-center gap-2 rounded-md bg-primary text-white px-4 py-2 text-sm hover:bg-primary/90"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Add Exercise</button>
                    <button id="refreshBtn" class="inline-flex items-center gap-2 rounded-md border px-3 py-2 text-sm hover:bg-accent"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>Refresh</button>
                </div>
            </div>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg text-card-foreground p-4 border bg-background shadow-sm hover:shadow-md transition"><div class="flex justify-between"><span class="text-sm font-medium text-gray-500">Total Exercises</span><div class="bg-blue-100 p-1.5 rounded-lg"><svg class="h-5 w-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg></div></div><div class="text-2xl font-bold mt-2">48</div><p class="text-xs text-gray-500 mt-1">8 categories · Updated weekly</p></div>
                <div class="rounded-lg text-card-foreground p-4 border bg-background shadow-sm hover:shadow-md transition"><div class="flex justify-between"><span class="text-sm font-medium text-gray-500">Categories</span><div class="bg-purple-100 p-1.5 rounded-lg"><svg class="h-5 w-5 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg></div></div><div class="text-2xl font-bold mt-2">8</div><p class="text-xs text-gray-500 mt-1">Strengthening · Stretching · More</p></div>
                <div class="rounded-lg text-card-foreground p-4 border bg-background shadow-sm hover:shadow-md transition"><div class="flex justify-between"><span class="text-sm font-medium text-gray-500">Most Prescribed</span><div class="bg-amber-100 p-1.5 rounded-full"><svg class="h-5 w-5 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div></div><div class="text-2xl font-bold mt-2">Bridges</div><p class="text-xs text-gray-500 mt-1">Used in 12 treatment plans</p></div>
                <div class="rounded-lg text-card-foreground p-4 border bg-background shadow-sm hover:shadow-md transition"><div class="flex justify-between"><span class="text-sm font-medium text-gray-500">Video Tutorials</span><div class="bg-green-100 p-1.5 rounded-lg"><svg class="h-5 w-5 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 3 19 12 5 21 5 3"/></svg></div></div><div class="text-2xl font-bold mt-2">32</div><p class="text-xs text-gray-500 mt-1">67% have video guides</p></div>
            </div>

            <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                <div class="flex items-center gap-2">
                    <div class="inline-flex rounded-md bg-gray-100 p-1">
                        <button class="inner-tab-btn active" data-view="list"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>List</button>
                        <button class="inner-tab-btn" data-view="grid"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>Grid</button>
                    </div>
                </div>
                <div class="flex flex-col gap-2 md:flex-row md:items-center flex-wrap">
                    <div class="relative min-w-[240px]"><svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg><input id="exerciseSearch" type="search" placeholder="Search exercises..." class="h-10 w-full rounded-md border border-gray-300 pl-8 pr-3 text-sm"></div>
                    <div class="flex gap-2 flex-wrap">
                        <div class="relative"><button id="catFilterBtn" class="select-trigger w-[160px]"><span id="catFilterText">All Categories</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="catFilterDropdown" class="hidden select-dropdown"><div class="select-item" data-value="all">All Categories</div><div class="select-item" data-value="Strengthening">Strengthening</div><div class="select-item" data-value="Stretching">Stretching</div><div class="select-item" data-value="Balance">Balance</div><div class="select-item" data-value="Mobility">Mobility</div><div class="select-item" data-value="Cardio">Cardio</div><div class="select-item" data-value="Core">Core</div><div class="select-item" data-value="Manual Therapy">Manual Therapy</div><div class="select-item" data-value="Postural">Postural</div></div></div>
                        <div class="relative"><button id="bodyFilterBtn" class="select-trigger w-[150px]"><span id="bodyFilterText">All Body Parts</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="bodyFilterDropdown" class="hidden select-dropdown"><div class="select-item" data-value="all">All Body Parts</div><div class="select-item" data-value="Shoulder">Shoulder</div><div class="select-item" data-value="Knee">Knee</div><div class="select-item" data-value="Hip">Hip</div><div class="select-item" data-value="Spine">Spine</div><div class="select-item" data-value="Ankle">Ankle</div><div class="select-item" data-value="Elbow">Elbow</div><div class="select-item" data-value="Wrist">Wrist</div><div class="select-item" data-value="Neck">Neck</div><div class="select-item" data-value="Full Body">Full Body</div></div></div>
                        <div class="relative"><button id="diffFilterBtn" class="select-trigger w-[140px]"><span id="diffFilterText">All Levels</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="diffFilterDropdown" class="hidden select-dropdown"><div class="select-item" data-value="all">All Levels</div><div class="select-item" data-value="Beginner">Beginner</div><div class="select-item" data-value="Intermediate">Intermediate</div><div class="select-item" data-value="Advanced">Advanced</div></div></div>
                    </div>
                </div>
            </div>

            <div id="listView" class="inner-tab-panel active rounded-lg border bg-white overflow-x-auto">
                <table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr><th class="text-left p-3">Exercise</th><th class="text-left p-3">Category</th><th class="text-left p-3">Body Part</th><th class="text-left p-3 hidden md:table-cell">Difficulty</th><th class="text-left p-3 hidden md:table-cell">Equipment</th><th class="text-left p-3">Sets/Reps</th><th class="text-right p-3">Actions</th></tr></thead><tbody id="listViewBody"></tbody></table>
            </div>
            <div id="gridView" class="inner-tab-panel">
                <div id="gridViewBody" class="grid gap-4 grid-cols-2"></div>
                <div class="mt-4 flex items-center justify-between">
                    <div class="text-gray-500" id="gridPaginationInfo">Showing <strong>1</strong> to <strong>12</strong> of <strong>12</strong> exercises</div>
                    <div class="flex items-center gap-2">
                        <button id="gridPrevPageBtn" class="inline-flex rounded-md border px-3 py-1 text-sm hover:bg-accent hover:text-accent-foreground h-10 disabled:opacity-50 disabled:cursor-not-allowed" disabled>Previous</button>
                        <button id="gridNextPageBtn" class="inline-flex rounded-md border px-3 py-1 text-sm hover:bg-accent hover:text-accent-foreground h-10">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Detail Modal -->
<div id="detailModal" style="display:none;" class="modal-overlay">
    <div class="modal-container" style="max-width:700px;">
        <div class="flex justify-between items-start mb-4 p-6 pb-0"><div><h3 class="text-lg font-semibold" id="detailTitle"></h3><p class="text-gray-500" id="detailSubtitle"></p></div><button id="closeDetailBtn" class="text-gray-400 hover:text-gray-600"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button></div>
        <div class="p-6 pt-2"><div id="detailContent" class="space-y-4"></div></div>
        <div class="flex justify-end gap-2 p-6 pt-0"><button id="closeDetailFooterBtn" class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Close</button><button id="editFromDetailBtn" class="px-4 py-2 bg-primary text-white rounded-md text-sm hover:bg-indigo-700">Edit Exercise</button></div>
    </div>
</div>

<!-- Add/Edit Form Modal -->
<div id="exerciseFormModal" style="display:none;" class="modal-overlay">
    <div class="modal-container" style="max-width:700px;">
        <div class="flex justify-between items-start mb-4 p-6 pb-0"><div><h3 class="text-lg font-semibold" id="formModalTitle">Add Exercise</h3><p class="text-gray-500">Fill in the exercise details</p></div><button id="closeFormBtn" class="text-gray-400 hover:text-gray-600"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button></div>
        <div class="p-6 pt-2 space-y-4">
            <div class="grid gap-4 md:grid-cols-2"><div><label class="text-sm font-medium block mb-1">Name <span class="text-red-500">*</span></label><input id="formName" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Exercise name"></div><div><label class="text-sm font-medium block mb-1">Category</label><div class="radix-select" id="formCategorySelect"><button type="button" class="radix-select-trigger"><span>Strengthening</span><svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div class="radix-select-content hidden"><div class="radix-select-item" data-value="Strengthening" data-selected="true">Strengthening<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div><div class="radix-select-item" data-value="Stretching">Stretching</div><div class="radix-select-item" data-value="Balance">Balance</div><div class="radix-select-item" data-value="Mobility">Mobility</div><div class="radix-select-item" data-value="Cardio">Cardio</div><div class="radix-select-item" data-value="Core">Core</div><div class="radix-select-item" data-value="Manual Therapy">Manual Therapy</div><div class="radix-select-item" data-value="Postural">Postural</div></div></div></div></div>
            <div class="grid gap-4 md:grid-cols-3"><div><label class="text-sm font-medium block mb-1">Body Part</label><div class="radix-select" id="formBodyPartSelect"><button type="button" class="radix-select-trigger"><span>Knee</span><svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div class="radix-select-content hidden"><div class="radix-select-item" data-value="Shoulder">Shoulder</div><div class="radix-select-item" data-value="Knee" data-selected="true">Knee<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div><div class="radix-select-item" data-value="Hip">Hip</div><div class="radix-select-item" data-value="Spine">Spine</div><div class="radix-select-item" data-value="Ankle">Ankle</div><div class="radix-select-item" data-value="Elbow">Elbow</div><div class="radix-select-item" data-value="Wrist">Wrist</div><div class="radix-select-item" data-value="Neck">Neck</div><div class="radix-select-item" data-value="Full Body">Full Body</div></div></div></div><div><label class="text-sm font-medium block mb-1">Difficulty</label><div class="radix-select" id="formDifficultySelect"><button type="button" class="radix-select-trigger"><span>Beginner</span><svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div class="radix-select-content hidden"><div class="radix-select-item" data-value="Beginner" data-selected="true">Beginner<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div><div class="radix-select-item" data-value="Intermediate">Intermediate</div><div class="radix-select-item" data-value="Advanced">Advanced</div></div></div></div><div><label class="text-sm font-medium block mb-1">Equipment</label><div class="radix-select" id="formEquipmentSelect"><button type="button" class="radix-select-trigger"><span>None</span><svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div class="radix-select-content hidden"><div class="radix-select-item" data-value="None" data-selected="true">None<svg class="radix-select-item-indicator h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg></div><div class="radix-select-item" data-value="Resistance Band">Resistance Band</div><div class="radix-select-item" data-value="Dumbbell">Dumbbell</div><div class="radix-select-item" data-value="Swiss Ball">Swiss Ball</div><div class="radix-select-item" data-value="Foam Roller">Foam Roller</div><div class="radix-select-item" data-value="Treadmill">Treadmill</div></div></div></div></div>
            <div class="grid gap-4 md:grid-cols-4"><div><label class="text-sm font-medium block mb-1">Sets</label><input id="formSets" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" value="3"></div><div><label class="text-sm font-medium block mb-1">Reps</label><input id="formReps" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" value="12"></div><div><label class="text-sm font-medium block mb-1">Hold (sec)</label><input id="formHold" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" value="5"></div><div><label class="text-sm font-medium block mb-1">Rest (sec)</label><input id="formRest" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" value="30"></div></div>
            <div><label class="text-sm font-medium block mb-1">Description</label><textarea id="formDescription" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Step-by-step instructions..."></textarea></div>
            <div class="grid gap-4 md:grid-cols-2"><div><label class="text-sm font-medium block mb-1">Target Muscles</label><input id="formTargetMuscles" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="e.g. Quadriceps, Hamstrings"></div><div><label class="text-sm font-medium block mb-1">YouTube URL (optional)</label><input id="formVideoUrl" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="https://youtu.be/... or https://youtube.com/watch?v=..."></div></div>
            <div><label class="text-sm font-medium block mb-1">Precautions</label><textarea id="formPrecautions" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="• Avoid arching lower back&#10;• Stop if sharp pain occurs"></textarea></div>
            <div><label class="text-sm font-medium block mb-1">Video Upload (MP4, WebM)</label><div class="file-upload-area" onclick="document.getElementById('videoFileInput').click()"><svg class="h-8 w-8 text-gray-400 mx-auto mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg><p class="text-sm text-gray-500">Click to upload video file</p><p class="text-xs text-gray-400 mt-1">MP4, WebM up to 50MB</p><input type="file" id="videoFileInput" class="hidden" accept="video/mp4,video/webm" onchange="handleVideoFileSelect(event)"></div><video id="videoPreview" class="video-thumb-preview hidden" controls></video></div>
        </div>
        <div class="flex justify-end gap-2 p-6 pt-0"><button id="cancelFormBtn" class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Cancel</button><button id="saveFormBtn" class="px-4 py-2 bg-primary text-white rounded-md text-sm hover:bg-indigo-700">Save Exercise</button></div>
    </div>
</div>

<!-- Video Player Modal -->
<div id="videoModal" style="display:none;" class="modal-overlay">
    <div class="modal-container" style="max-width:800px;">
        <div class="flex justify-between items-start mb-4 p-6 pb-0">
            <h3 class="text-lg font-semibold" id="videoTitle">Video Tutorial</h3>
            <button id="closeVideoBtn" class="text-gray-400 hover:text-gray-600"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
        </div>
        <div class="p-6 pt-2">
            <!-- Uploaded Video Player -->
            <div id="videoPlayerContainer" class="hidden">
                <video id="videoPlayer" controls class="w-full rounded-lg" style="max-height:400px;">
                    <source src="Physical Therapy and Fitness.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <!-- YouTube Embed -->
            <div id="youtubeContainer" class="hidden">
                <div class="video-preview rounded-lg overflow-hidden">
                    <iframe id="youtubeIframe" class="w-full rounded-lg" height="400" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
            <!-- No Video Placeholder -->
            <div id="noVideoPlaceholder">
                <div class="video-preview rounded-lg">
                    <div class="video-play-overlay">
                        <svg class="h-16 w-16 text-white" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                    </div>
                </div>
                <p class="text-center text-sm text-gray-500 mt-3">No video available for this exercise</p>
            </div>
            <!-- Video Source Tabs -->
            <div id="videoSourceTabs" class="hidden mt-4">
                <p class="text-xs text-gray-500 mb-2">Available sources:</p>
                <div class="flex gap-2" id="videoSourceButtons"></div>
            </div>
        </div>
        <div class="flex justify-end p-6 pt-0"><button id="closeVideoFooterBtn" class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Close</button></div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" style="display:none;" class="modal-overlay">
    <div class="modal-container" style="max-width:500px;"><div class="p-6"><div class="flex flex-col space-y-2 text-center sm:text-left"><h2 class="text-lg font-semibold">Delete Exercise?</h2><p class="text-sm text-gray-500">This action cannot be undone.</p></div><div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2 mt-6"><button id="cancelDeleteBtn" class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100 mt-2 sm:mt-0">Cancel</button><button id="confirmDeleteBtn" class="px-4 py-2 bg-red-500 text-white rounded-md text-sm hover:bg-red-600">Delete</button></div></div></div>
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
const exercises = [
    { id:1, name:"Bridges", category:"Strengthening", bodyPart:"Hip", difficulty:"Beginner", equipment:"None", sets:3, reps:12, hold:5, rest:30, description:"Lie on back with knees bent, feet flat. Tighten abdominals. Lift hips toward ceiling until body forms straight line from shoulders to knees. Squeeze glutes at top. Hold briefly. Lower slowly with control.", targetMuscles:"Gluteus Maximus, Hamstrings, Core", precautions:"Avoid arching lower back excessively. Keep knees aligned with hips. Stop if sharp pain occurs in lower back.", videoUrl:"https://youtu.be/PMXAbOyJ1aw", videoFile:null, usedInPlans:12 },
    { id:2, name:"Straight Leg Raise", category:"Strengthening", bodyPart:"Knee", difficulty:"Beginner", equipment:"None", sets:3, reps:10, hold:5, rest:30, description:"Lie flat on back with one leg bent and other straight. Tighten thigh muscle of straight leg. Slowly lift leg about 12 inches off ground. Hold 5 seconds. Lower slowly with control.", targetMuscles:"Quadriceps, Hip Flexors", precautions:"Keep knee completely straight throughout. Do not arch back. Stop if you feel pinching in hip.", videoUrl:"", videoFile:null, usedInPlans:8 },
    { id:3, name:"Quad Sets", category:"Strengthening", bodyPart:"Knee", difficulty:"Beginner", equipment:"None", sets:3, reps:15, hold:10, rest:20, description:"Sit or lie with leg extended. Place a small rolled towel under knee if needed. Tighten thigh muscle, pushing the back of knee down toward the floor. Hold contraction 5-10 seconds. Relax completely between reps.", targetMuscles:"Quadriceps (VMO)", precautions:"Do not hold breath during contraction. Avoid compensating with hip muscles. Stop if pain increases.", videoUrl:"", videoFile:null, usedInPlans:10 },
    { id:4, name:"Heel Slides", category:"Mobility", bodyPart:"Knee", difficulty:"Beginner", equipment:"None", sets:2, reps:15, hold:3, rest:15, description:"Lie on back with legs straight. Slowly slide one heel toward buttocks, bending knee as far as comfortable. Hold briefly at end range. Slowly slide heel back to starting position.", targetMuscles:"Knee Flexors, Hamstrings", precautions:"Move within pain-free range. Do not force the bend. Use a towel or strap to assist if needed.", videoUrl:"", videoFile:null, usedInPlans:7 },
    { id:5, name:"Mini Squats", category:"Strengthening", bodyPart:"Knee", difficulty:"Intermediate", equipment:"None", sets:3, reps:12, hold:0, rest:45, description:"Stand with feet shoulder-width apart. Hold onto a stable surface if needed. Slowly bend knees to about 45 degrees as if sitting back into a chair. Keep back straight and knees behind toes. Push through heels to return to standing.", targetMuscles:"Quadriceps, Glutes, Hamstrings", precautions:"Keep knees aligned with second toe. Do not let knees cave inward. Limit depth to pain-free range.", videoUrl:"", videoFile:null, usedInPlans:6 },
    { id:6, name:"Wall Slides", category:"Strengthening", bodyPart:"Shoulder", difficulty:"Beginner", equipment:"None", sets:2, reps:10, hold:3, rest:30, description:"Stand with back flat against wall, feet about 6 inches from wall. Place arms against wall with elbows bent at 90 degrees. Slowly slide arms up wall as high as comfortable. Hold 3 seconds at top. Slowly return to starting position.", targetMuscles:"Deltoids, Rotator Cuff, Scapular Stabilizers", precautions:"Maintain wrist and elbow contact with wall. Do not shrug shoulders. Stop at point of pain or pinching.", videoUrl:"", videoFile:null, usedInPlans:5 },
    { id:7, name:"Single Leg Balance", category:"Balance", bodyPart:"Ankle", difficulty:"Intermediate", equipment:"None", sets:3, reps:1, hold:30, rest:30, description:"Stand near a wall or stable surface for safety. Lift one foot off ground. Maintain balance on standing leg for prescribed time.", targetMuscles:"Ankle Stabilizers, Peroneals, Core", precautions:"Always have support nearby. Start with eyes open. Progress gradually.", videoUrl:"", videoFile:null, usedInPlans:9 },
    { id:8, name:"Stationary Bike", category:"Cardio", bodyPart:"Full Body", difficulty:"Beginner", equipment:"Treadmill", sets:1, reps:1, hold:0, rest:0, description:"Adjust seat height so knee has slight bend at bottom of pedal stroke. Start with low resistance. Pedal at comfortable pace (60-80 RPM) for prescribed duration.", targetMuscles:"Quadriceps, Hamstrings, Calves, Cardiovascular", precautions:"Ensure proper seat height to avoid knee strain. Start with 5-10 minutes and progress gradually.", videoUrl:"", videoFile:null, usedInPlans:11 },
    { id:9, name:"Hamstring Stretch", category:"Stretching", bodyPart:"Knee", difficulty:"Beginner", equipment:"None", sets:3, reps:1, hold:30, rest:15, description:"Sit on floor with one leg extended straight. Bend other leg so foot rests against inner thigh. Lean forward from hips toward extended foot. Keep back straight. Hold stretch without bouncing.", targetMuscles:"Hamstrings", precautions:"Do not bounce or force the stretch. Keep extended knee straight but not locked.", videoUrl:"", videoFile:null, usedInPlans:8 },
    { id:10, name:"Standing Calf Raises", category:"Strengthening", bodyPart:"Ankle", difficulty:"Beginner", equipment:"None", sets:3, reps:15, hold:2, rest:30, description:"Stand on edge of a step with heels hanging off. Hold onto railing for balance. Rise up onto toes as high as possible. Hold 2 seconds at top. Slowly lower heels below step level.", targetMuscles:"Gastrocnemius, Soleus", precautions:"Maintain balance with support. Control the movement — no bouncing.", videoUrl:"", videoFile:null, usedInPlans:7 },
    { id:11, name:"Pendulum Exercise", category:"Mobility", bodyPart:"Shoulder", difficulty:"Beginner", equipment:"None", sets:2, reps:20, hold:0, rest:15, description:"Bend forward at waist, supporting yourself with one arm on a table. Let the affected arm hang freely. Gently swing arm in small circles clockwise then counter-clockwise.", targetMuscles:"Shoulder Joint Capsule, Rotator Cuff (gentle mobilization)", precautions:"Keep movements slow and controlled. Use body momentum, not shoulder muscles.", videoUrl:"", videoFile:null, usedInPlans:4 },
    { id:12, name:"Plank Hold", category:"Core", bodyPart:"Full Body", difficulty:"Intermediate", equipment:"None", sets:3, reps:1, hold:30, rest:45, description:"Start on forearms and toes with body in straight line. Engage core by pulling navel toward spine. Keep hips level — do not sag or pike. Hold position while breathing steadily.", targetMuscles:"Transverse Abdominis, Rectus Abdominis, Obliques, Shoulder Girdle", precautions:"Do not hold breath. Keep neck neutral. If wrist pain occurs, perform on forearms.", videoUrl:"", videoFile:null, usedInPlans:6 },
];

let filters = { search:'', category:'all', bodyPart:'all', difficulty:'all' };
let currentView = 'list';
let activeActionMenu = null;
let editingExerciseId = null;
let pendingDeleteId = null;
let tempVideoFile = null;

function showToast(msg, isError) { const t = document.createElement('div'); t.className = 'toast-message' + (isError?' error':''); t.textContent = msg; document.body.appendChild(t); setTimeout(() => t.remove(), 2500); }
function closeActionMenu() { if (activeActionMenu) { activeActionMenu.remove(); activeActionMenu = null; } }
function showActionMenu(btn, items) { closeActionMenu(); const rect = btn.getBoundingClientRect(); const menu = document.createElement('div'); menu.className = 'action-menu'; let left = rect.left, top = rect.bottom + 6; if (left + 220 > window.innerWidth) left = window.innerWidth - 230; if (top + items.length * 44 > window.innerHeight) top = rect.top - items.length * 44 - 10; menu.style.top = top + 'px'; menu.style.left = left + 'px'; let html = '<div class="action-menu-header">Exercise Actions</div>'; items.forEach(i => { if (i.divider) { html += '<div class="action-divider"></div>'; return; } html += `<button class="action-item${i.cls||''}"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">${i.icon}</svg>${i.label}</button>`; }); menu.innerHTML = html; document.body.appendChild(menu); activeActionMenu = menu; const closeHandler = (e) => { if (!menu.contains(e.target) && e.target !== btn) { closeActionMenu(); document.removeEventListener('click', closeHandler); } }; setTimeout(() => document.addEventListener('click', closeHandler), 10); menu.querySelectorAll('.action-item').forEach((el, idx) => { el.addEventListener('click', () => { const it = items[idx]; if (it.callback) it.callback(); closeActionMenu(); }); }); }

function initRadixSelect(el) { if (!el) return; const t = el.querySelector('.radix-select-trigger'), c = el.querySelector('.radix-select-content'), items = el.querySelectorAll('.radix-select-item'); if (!t || !c) return; t.addEventListener('click', (e) => { e.stopPropagation(); document.querySelectorAll('.radix-select-content').forEach(x => { if (x !== c) x.classList.add('hidden'); }); c.classList.toggle('hidden'); }); items.forEach(i => { i.addEventListener('click', (e) => { e.stopPropagation(); t.querySelector('span').textContent = i.textContent.replace(/<svg[\s\S]*?<\/svg>/g, '').trim(); t.setAttribute('data-value', i.dataset.value); items.forEach(x => x.setAttribute('data-selected', 'false')); i.setAttribute('data-selected', 'true'); c.classList.add('hidden'); }); }); }
document.querySelectorAll('.radix-select').forEach(s => initRadixSelect(s));
document.addEventListener('click', () => { document.querySelectorAll('.radix-select-content').forEach(c => c.classList.add('hidden')); });

function getFiltered() { let f = [...exercises]; if (filters.search) { const q = filters.search.toLowerCase(); f = f.filter(e => e.name.toLowerCase().includes(q) || e.bodyPart.toLowerCase().includes(q) || e.targetMuscles.toLowerCase().includes(q) || e.category.toLowerCase().includes(q)); } if (filters.category !== 'all') f = f.filter(e => e.category === filters.category); if (filters.bodyPart !== 'all') f = f.filter(e => e.bodyPart === filters.bodyPart); if (filters.difficulty !== 'all') f = f.filter(e => e.difficulty === filters.difficulty); return f; }

function getDiffBadge(d) {
    if (d === 'Beginner') return '<span class="difficulty-badge difficulty-beginner"><svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>Beginner</span>';
    if (d === 'Intermediate') return '<span class="difficulty-badge difficulty-intermediate"><svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Intermediate</span>';
    return '<span class="difficulty-badge difficulty-advanced"><svg class="h-3 w-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>Advanced</span>';
}

const catColors = { Strengthening:'#eff6ff', Stretching:'#f0fdf4', Balance:'#fefce8', Mobility:'#fdf2f8', Cardio:'#fef2f2', Core:'#f5f3ff', 'Manual Therapy':'#fff7ed', Postural:'#ecfeff' };
const catSvgs = {
    Strengthening: '<svg class="h-10 w-10 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M6.5 6.5L12 2l5.5 4.5"/><path d="M6.5 17.5L12 22l5.5-4.5"/><rect x="2" y="8" width="4" height="8" rx="1"/><rect x="18" y="8" width="4" height="8" rx="1"/></svg>',
    Stretching: '<svg class="h-10 w-10 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="5" r="2"/><path d="M10 22v-6L8 11"/><path d="M14 22v-6l2-5"/></svg>',
    Balance: '<svg class="h-10 w-10 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2v4"/><path d="M8 6h8"/><rect x="6" y="10" width="12" height="12" rx="2"/><line x1="12" y1="6" x2="12" y2="10"/></svg>',
    Mobility: '<svg class="h-10 w-10 text-pink-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v8"/><path d="M8 12h8"/></svg>',
    Cardio: '<svg class="h-10 w-10 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>',
    Core: '<svg class="h-10 w-10 text-purple-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><ellipse cx="12" cy="6" rx="8" ry="3"/><path d="M4 6v6a8 3 0 0 0 16 0V6"/><path d="M4 12a8 3 0 0 0 16 0"/></svg>',
    'Manual Therapy': '<svg class="h-10 w-10 text-orange-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 11V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v0"/><path d="M14 10V4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v2"/><path d="M10 10.5V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v8"/><path d="M18 8a2 2 0 0 1 2 2v4a6 6 0 0 1-6 6h-2a6 6 0 0 1-6-6v-2"/></svg>',
    Postural: '<svg class="h-10 w-10 text-cyan-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2v2"/><path d="M12 20v2"/><path d="M4.93 4.93l1.41 1.41"/><path d="M17.66 17.66l1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/></svg>',
};

function renderList() {
    const f = getFiltered();
    document.getElementById('listViewBody').innerHTML = f.map(e => `<tr class="border-b hover:bg-gray-50"><td class="p-3 font-medium">${e.name}</td><td class="p-3"><span class="tag-pill">${e.category}</span></td><td class="p-3">${e.bodyPart}</td><td class="p-3 hidden md:table-cell">${getDiffBadge(e.difficulty)}</td><td class="p-3 hidden md:table-cell">${e.equipment==='None'?'—':e.equipment}</td><td class="p-3 text-sm">${e.sets}×${e.reps}${e.hold>0?` · ${e.hold}s hold`:''}</td><td class="p-3 text-right"><button class="p-1 rounded hover:bg-gray-100" onclick="showActionMenu(this,getExerciseActions(${e.id}))"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg></button></td></tr>`).join('') || '<tr><td colspan="7" class="p-8 text-center text-gray-500">No exercises found</td></tr>';
}

function renderGrid() {
    const f = getFiltered();
    const container = document.getElementById('gridViewBody');
    if (!container) return;
    
    container.innerHTML = f.map(e => `
        <div class="rounded-lg border bg-background shadow-sm overflow-hidden hover:shadow-md transition cursor-pointer" onclick="viewDetail(${e.id})">
            <div class="flex flex-col">
                <div class="flex items-center justify-between bg-gray-50 p-4">
                    <div class="flex items-center gap-3">
                        <div class="h-12 w-12 rounded-lg flex items-center justify-center" style="background:${catColors[e.category]||'#f9fafb'}">
                            ${catSvgs[e.category] ? catSvgs[e.category].replace('h-10 w-10', 'h-6 w-6') : '<svg class="h-6 w-6 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>'}
                        </div>
                        <div>
                            <div class="font-medium">${e.name}</div>
                            <div class="text-xs text-gray-500">${e.category} · ${e.bodyPart}</div>
                        </div>
                    </div>
                    ${getDiffBadge(e.difficulty)}
                </div>
                <div class="p-4">
                    <div class="grid gap-2">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-gray-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
                            <span class="text-sm">${e.sets} sets × ${e.reps} reps${e.hold > 0 ? ` · ${e.hold}s hold` : ''}${e.rest > 0 ? ` · ${e.rest}s rest` : ''}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-gray-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
                            <span class="text-sm">${e.targetMuscles}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-gray-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2"/></svg>
                            <span class="text-sm">${e.equipment === 'None' ? 'No equipment needed' : e.equipment}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 text-gray-400 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <span class="text-sm">Used in ${e.usedInPlans} treatment plans</span>
                        </div>
                    </div>
                    ${e.description ? `<p class="text-xs text-gray-500 mt-3 line-clamp-2">${e.description}</p>` : ''}
                </div>
                <div class="flex border-t">
                    <button class="flex-1 inline-flex items-center justify-center gap-2 border-r py-2.5 text-sm hover:bg-gray-50 transition" onclick="event.stopPropagation();viewDetail(${e.id})">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>View
                    </button>
                    <button class="flex-1 inline-flex items-center justify-center gap-2 border-r py-2.5 text-sm hover:bg-gray-50 transition" onclick="event.stopPropagation();openForm(${e.id})">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>Edit
                    </button>
                    <button class="flex-1 inline-flex items-center justify-center gap-2 p-2 text-sm hover:bg-gray-50 transition" onclick="event.stopPropagation();showActionMenu(this,getExerciseActions(${e.id}))">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>More
                    </button>
                </div>
            </div>
        </div>`).join('') || '<p class="col-span-full text-center py-8 text-gray-500">No exercises found</p>';
    
    // Update pagination info
    const total = f.length;
    document.getElementById('gridPaginationInfo').innerHTML = `Showing <strong>1</strong> to <strong>${total}</strong> of <strong>${total}</strong> exercises`;
}

function getExerciseActions(id) {
    const e = exercises.find(x => x.id === id); if (!e) return [];
    return [
        { icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>', label: 'View Details', callback: () => viewDetail(id) },
        { icon: '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>', label: 'Edit Exercise', callback: () => openForm(id) },
        { icon: '<polygon points="5 3 19 12 5 21 5 3"/>', label: 'Watch Video', callback: () => openVideoModal(e) },
        { icon: '<path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/>', label: 'Duplicate', callback: () => { exercises.push({...e, id:Date.now(), name:e.name+' (Copy)', usedInPlans:0 }); renderAll(); showToast('Exercise duplicated'); } },
        { divider: true, icon:'', label:'' },
        { icon: '<path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>', label: 'Delete', cls:' text-red', callback: () => openDeleteModal(id) },
    ];
}

function viewDetail(id) {
    const e = exercises.find(x => x.id === id); if (!e) return;
    document.getElementById('detailTitle').textContent = e.name;
    document.getElementById('detailSubtitle').textContent = `${e.category} · ${e.bodyPart} · ${e.difficulty}`;
    document.getElementById('detailContent').innerHTML = `
        <div class="detail-section"><div class="detail-section-title"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/></svg>Description</div><p class="text-sm">${e.description}</p></div>
        <div class="grid grid-cols-4 gap-3 mb-4"><div class="text-center p-3 bg-gray-50 rounded-lg"><p class="text-xs text-gray-500">Sets</p><p class="font-bold">${e.sets}</p></div><div class="text-center p-3 bg-gray-50 rounded-lg"><p class="text-xs text-gray-500">Reps</p><p class="font-bold">${e.reps}</p></div><div class="text-center p-3 bg-gray-50 rounded-lg"><p class="text-xs text-gray-500">Hold</p><p class="font-bold">${e.hold}s</p></div><div class="text-center p-3 bg-gray-50 rounded-lg"><p class="text-xs text-gray-500">Rest</p><p class="font-bold">${e.rest}s</p></div></div>
        <div class="detail-section"><div class="detail-section-title"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>Target Muscles</div><p class="text-sm">${e.targetMuscles}</p></div>
        <div class="detail-section"><div class="detail-section-title"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v4"/><path d="M12 17h.01"/><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg>Precautions</div>${e.precautions.split('.').filter(Boolean).map(p => `<div class="precaution-item"><svg class="h-4 w-4 text-amber-500 flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg><span>${p.trim()}</span></div>`).join('')}</div>
        ${(e.videoUrl || e.videoFile) ? `<div class="video-preview mb-4" onclick="openVideoModal(exercises.find(x=>x.id===${id}))"><div class="video-play-overlay"><svg class="h-12 w-12 text-white" viewBox="0 0 24 24" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"/></svg></div></div>` : ''}
        <div class="text-xs text-gray-400 flex items-center gap-4"><span>📊 Used in <strong>${e.usedInPlans}</strong> treatment plans</span><span>🔧 Equipment: <strong>${e.equipment}</strong></span></div>`;
    document.getElementById('detailModal').style.display = 'flex'; document.body.style.overflow = 'hidden';
    document.getElementById('editFromDetailBtn').onclick = () => { closeDetailModal(); openForm(id); };
}
function closeDetailModal() { document.getElementById('detailModal').style.display = 'none'; document.body.style.overflow = ''; }
document.getElementById('closeDetailBtn')?.addEventListener('click', closeDetailModal);
document.getElementById('closeDetailFooterBtn')?.addEventListener('click', closeDetailModal);
document.getElementById('detailModal')?.addEventListener('click', function(e) { if (e.target === this) closeDetailModal(); });

function openForm(id = null) {
    editingExerciseId = id; tempVideoFile = null;
    document.getElementById('formModalTitle').textContent = id ? 'Edit Exercise' : 'Add Exercise';
    document.getElementById('videoFileInput').value = '';
    document.getElementById('videoPreview').classList.add('hidden');
    if (id) { const e = exercises.find(x => x.id === id); if (!e) return;
        document.getElementById('formName').value = e.name; document.getElementById('formSets').value = e.sets; document.getElementById('formReps').value = e.reps;
        document.getElementById('formHold').value = e.hold; document.getElementById('formRest').value = e.rest; document.getElementById('formDescription').value = e.description;
        document.getElementById('formTargetMuscles').value = e.targetMuscles; document.getElementById('formVideoUrl').value = e.videoUrl; document.getElementById('formPrecautions').value = e.precautions;
    } else { document.querySelectorAll('#exerciseFormModal input:not([type=hidden]), #exerciseFormModal textarea').forEach(el => el.value = ''); document.getElementById('formSets').value = 3; document.getElementById('formReps').value = 12; document.getElementById('formHold').value = 5; document.getElementById('formRest').value = 30; }
    document.getElementById('exerciseFormModal').style.display = 'flex'; document.body.style.overflow = 'hidden';
}
function closeFormModal() { document.getElementById('exerciseFormModal').style.display = 'none'; document.body.style.overflow = ''; editingExerciseId = null; tempVideoFile = null; }
function handleVideoFileSelect(event) {
    const file = event.target.files[0]; if (!file) return;
    if (file.size > 50 * 1024 * 1024) { showToast('Video must be under 50MB', true); return; }
    tempVideoFile = file;
    const preview = document.getElementById('videoPreview');
    preview.src = URL.createObjectURL(file); preview.classList.remove('hidden');
}
function saveForm() {
    const name = document.getElementById('formName').value.trim(); if (!name) { showToast('Please enter an exercise name', true); return; }
    const data = { name, category: document.querySelector('#formCategorySelect .radix-select-trigger')?.getAttribute('data-value')||'Strengthening', bodyPart: document.querySelector('#formBodyPartSelect .radix-select-trigger')?.getAttribute('data-value')||'Knee', difficulty: document.querySelector('#formDifficultySelect .radix-select-trigger')?.getAttribute('data-value')||'Beginner', equipment: document.querySelector('#formEquipmentSelect .radix-select-trigger')?.getAttribute('data-value')||'None', sets: parseInt(document.getElementById('formSets').value)||3, reps: parseInt(document.getElementById('formReps').value)||12, hold: parseInt(document.getElementById('formHold').value)||0, rest: parseInt(document.getElementById('formRest').value)||30, description: document.getElementById('formDescription').value, targetMuscles: document.getElementById('formTargetMuscles').value, precautions: document.getElementById('formPrecautions').value, videoUrl: document.getElementById('formVideoUrl').value, videoFile: tempVideoFile };
    if (editingExerciseId) { const idx = exercises.findIndex(x => x.id === editingExerciseId); if (idx !== -1) { data.id = editingExerciseId; data.usedInPlans = exercises[idx].usedInPlans; if (!tempVideoFile) data.videoFile = exercises[idx].videoFile; exercises[idx] = data; } }
    else { data.id = Date.now(); data.usedInPlans = 0; exercises.push(data); }
    closeFormModal(); renderAll(); showToast(editingExerciseId ? 'Exercise updated!' : 'Exercise added!');
}
document.getElementById('closeFormBtn')?.addEventListener('click', closeFormModal);
document.getElementById('cancelFormBtn')?.addEventListener('click', closeFormModal);
document.getElementById('saveFormBtn')?.addEventListener('click', saveForm);
document.getElementById('exerciseFormModal')?.addEventListener('click', function(e) { if (e.target === this) closeFormModal(); });

function openVideoModal(e) {
    document.getElementById('videoTitle').textContent = e.name + ' — Video Tutorial';
    
    // Hide all containers first
    document.getElementById('videoPlayerContainer').classList.add('hidden');
    document.getElementById('youtubeContainer').classList.add('hidden');
    document.getElementById('noVideoPlaceholder').classList.add('hidden');
    document.getElementById('videoSourceTabs').classList.add('hidden');
    
    // Pause any playing video
    document.getElementById('videoPlayer')?.pause();
    // Reset YouTube iframe
    document.getElementById('youtubeIframe').src = '';
    
    const sources = [];
    
    // Check for YouTube URL first (prefer YouTube if available)
    const videoUrl = e.videoUrl || '';
    let youtubeId = '';
    if (videoUrl) {
        if (videoUrl.includes('youtube.com/watch')) {
            youtubeId = videoUrl.split('v=')[1]?.split('&')[0] || '';
        } else if (videoUrl.includes('youtu.be/')) {
            youtubeId = videoUrl.split('youtu.be/')[1]?.split('?')[0]?.split('&')[0] || '';
        }
    }
    
    // Check for uploaded video file
    const hasUploadedVideo = e.videoFile ? true : false;
    const hasYoutube = youtubeId ? true : false;
    
    // Build sources list
    if (hasUploadedVideo) {
        sources.push({ type: 'upload', label: 'Uploaded Video' });
        const player = document.getElementById('videoPlayer');
        player.querySelector('source').src = URL.createObjectURL(e.videoFile);
        player.querySelector('source').type = e.videoFile.type;
        player.load();
    } else {
        // Default MP4 video
        sources.push({ type: 'upload', label: 'Instructional Video' });
        const player = document.getElementById('videoPlayer');
        player.querySelector('source').src = 'Physical Therapy and Fitness.mp4';
        player.querySelector('source').type = 'video/mp4';
        player.load();
    }
    
    if (hasYoutube) {
        sources.push({ type: 'youtube', label: 'YouTube Tutorial' });
    }
    
    // Show only ONE source at a time, with tabs if multiple
    if (sources.length > 1) {
        // Multiple sources — show tabs, default to first source
        document.getElementById('videoSourceTabs').classList.remove('hidden');
        document.getElementById('videoSourceButtons').innerHTML = sources.map((s, i) => 
            `<button class="px-3 py-1 text-xs rounded-md border hover:bg-gray-100 transition ${i === 0 ? 'bg-indigo-50 border-indigo-200 text-indigo-700 font-medium' : 'text-gray-600'}" onclick="switchVideoSource('${s.type}', this)" data-source="${s.type}">${s.label}</button>`
        ).join('');
        
        // Show first source (upload) by default
        document.getElementById('videoPlayerContainer').classList.remove('hidden');
        document.getElementById('youtubeContainer').classList.add('hidden');
    } else {
        // Single source — show it directly, no tabs
        if (hasYoutube) {
            // Only YouTube available
            document.getElementById('youtubeIframe').src = `https://www.youtube.com/embed/${youtubeId}`;
            document.getElementById('youtubeContainer').classList.remove('hidden');
            document.getElementById('videoPlayerContainer').classList.add('hidden');
        } else {
            // Only MP4 available
            document.getElementById('videoPlayerContainer').classList.remove('hidden');
            document.getElementById('youtubeContainer').classList.add('hidden');
        }
    }
    
    // If no video at all
    if (!hasUploadedVideo && !hasYoutube && sources.length === 0) {
        document.getElementById('noVideoPlaceholder').classList.remove('hidden');
    }
    
    document.getElementById('videoModal').style.display = 'flex'; 
    document.body.style.overflow = 'hidden';
}

function switchVideoSource(type, btn) {
    // Update button styles
    btn.parentElement.querySelectorAll('button').forEach(b => {
        b.classList.remove('bg-indigo-50', 'border-indigo-200', 'text-indigo-700', 'font-medium');
        b.classList.add('text-gray-600');
    });
    btn.classList.add('bg-indigo-50', 'border-indigo-200', 'text-indigo-700', 'font-medium');
    btn.classList.remove('text-gray-600');
    
    // Show ONLY the selected source, hide the other
    if (type === 'upload') {
        document.getElementById('videoPlayerContainer').classList.remove('hidden');
        document.getElementById('youtubeContainer').classList.add('hidden');
        document.getElementById('youtubeIframe').src = ''; // Stop YouTube
    } else {
        document.getElementById('youtubeContainer').classList.remove('hidden');
        document.getElementById('videoPlayerContainer').classList.add('hidden');
        document.getElementById('videoPlayer')?.pause(); // Pause MP4
        
        // Set YouTube src if not already set
        const iframe = document.getElementById('youtubeIframe');
        if (!iframe.src || iframe.src === window.location.href) {
            // Get the exercise being viewed and extract YouTube ID
            const title = document.getElementById('videoTitle').textContent;
            const exerciseName = title.replace(' — Video Tutorial', '');
            const ex = exercises.find(x => x.name === exerciseName);
            if (ex && ex.videoUrl) {
                let ytId = '';
                const url = ex.videoUrl;
                if (url.includes('youtube.com/watch')) ytId = url.split('v=')[1]?.split('&')[0] || '';
                else if (url.includes('youtu.be/')) ytId = url.split('youtu.be/')[1]?.split('?')[0]?.split('&')[0] || '';
                if (ytId) iframe.src = `https://www.youtube.com/embed/${ytId}`;
            }
        }
    }
}

function switchVideoSource(type, btn) {
    // Update button styles
    btn.parentElement.querySelectorAll('button').forEach(b => {
        b.classList.remove('bg-indigo-50', 'border-indigo-200', 'text-indigo-700', 'font-medium');
        b.classList.add('text-gray-600');
    });
    btn.classList.add('bg-indigo-50', 'border-indigo-200', 'text-indigo-700', 'font-medium');
    btn.classList.remove('text-gray-600');
    
    // Show ONLY the selected source, hide the other
    if (type === 'upload') {
        document.getElementById('videoPlayerContainer').classList.remove('hidden');
        document.getElementById('youtubeContainer').classList.add('hidden');
        document.getElementById('youtubeIframe').src = ''; // Stop YouTube
    } else {
        document.getElementById('youtubeContainer').classList.remove('hidden');
        document.getElementById('videoPlayerContainer').classList.add('hidden');
        document.getElementById('videoPlayer')?.pause(); // Pause MP4
        
        // Set YouTube src if not already set
        const iframe = document.getElementById('youtubeIframe');
        if (!iframe.src || iframe.src === window.location.href) {
            // Get the exercise being viewed and extract YouTube ID
            const title = document.getElementById('videoTitle').textContent;
            const exerciseName = title.replace(' — Video Tutorial', '');
            const ex = exercises.find(x => x.name === exerciseName);
            if (ex && ex.videoUrl) {
                let ytId = '';
                const url = ex.videoUrl;
                if (url.includes('youtube.com/watch')) ytId = url.split('v=')[1]?.split('&')[0] || '';
                else if (url.includes('youtu.be/')) ytId = url.split('youtu.be/')[1]?.split('?')[0]?.split('&')[0] || '';
                if (ytId) iframe.src = `https://www.youtube.com/embed/${ytId}`;
            }
        }
    }
}

function switchVideoSource(type, btn) {
    // Update button styles
    btn.parentElement.querySelectorAll('button').forEach(b => {
        b.classList.remove('bg-indigo-50', 'border-indigo-200', 'text-indigo-700', 'font-medium');
        b.classList.add('text-gray-600');
    });
    btn.classList.add('bg-indigo-50', 'border-indigo-200', 'text-indigo-700', 'font-medium');
    btn.classList.remove('text-gray-600');
    
    // Show/hide containers
    document.getElementById('videoPlayerContainer').classList.toggle('hidden', type !== 'upload');
    document.getElementById('youtubeContainer').classList.toggle('hidden', type !== 'youtube');
    
    // Pause the other player
    if (type !== 'upload') document.getElementById('videoPlayer')?.pause();
}
function closeVideoModal() { document.getElementById('videoModal').style.display = 'none'; document.body.style.overflow = ''; }
document.getElementById('closeVideoBtn')?.addEventListener('click', closeVideoModal);
document.getElementById('closeVideoFooterBtn')?.addEventListener('click', closeVideoModal);
document.getElementById('videoModal')?.addEventListener('click', function(e) { if (e.target === this) closeVideoModal(); });

function openDeleteModal(id) { pendingDeleteId = id; document.getElementById('deleteModal').style.display = 'flex'; document.body.style.overflow = 'hidden'; }
function closeDeleteModal() { document.getElementById('deleteModal').style.display = 'none'; document.body.style.overflow = ''; pendingDeleteId = null; }
function confirmDelete() { if (pendingDeleteId) { exercises = exercises.filter(x => x.id !== pendingDeleteId); closeDeleteModal(); renderAll(); showToast('Exercise deleted'); } }
document.getElementById('cancelDeleteBtn')?.addEventListener('click', closeDeleteModal);
document.getElementById('confirmDeleteBtn')?.addEventListener('click', confirmDelete);
document.getElementById('deleteModal')?.addEventListener('click', function(e) { if (e.target === this) closeDeleteModal(); });

function renderAll() { 
    if (currentView === 'grid') renderGrid(); 
    else renderList(); 
    document.getElementById('gridView').classList.toggle('active', currentView === 'grid');
    document.getElementById('listView').classList.toggle('active', currentView === 'list');
}

function initFilters() {
    [{ btn:'catFilterBtn', dd:'catFilterDropdown', txt:'catFilterText', key:'category' }, { btn:'bodyFilterBtn', dd:'bodyFilterDropdown', txt:'bodyFilterText', key:'bodyPart' }, { btn:'diffFilterBtn', dd:'diffFilterDropdown', txt:'diffFilterText', key:'difficulty' }].forEach(f => {
        const btn = document.getElementById(f.btn), dd = document.getElementById(f.dd), txt = document.getElementById(f.txt); if (!btn) return;
        btn.addEventListener('click', (e) => { e.stopPropagation(); closeActionMenu(); dd.classList.toggle('hidden'); });
        dd.querySelectorAll('.select-item').forEach(i => { i.addEventListener('click', () => { txt.textContent = i.textContent; filters[f.key] = i.dataset.value; dd.classList.add('hidden'); renderAll(); }); });
        document.addEventListener('click', (e) => { if (!btn.contains(e.target) && !dd.contains(e.target)) dd.classList.add('hidden'); });
    });
}

document.querySelectorAll('.inner-tab-btn').forEach(b => { b.addEventListener('click', () => { currentView = b.dataset.view; document.querySelectorAll('.inner-tab-btn').forEach(ib => ib.classList.remove('active')); b.classList.add('active'); document.getElementById('listView').classList.toggle('active', currentView === 'list'); document.getElementById('gridView').classList.toggle('active', currentView === 'grid'); renderAll(); }); });
document.getElementById('exerciseSearch')?.addEventListener('input', (e) => { filters.search = e.target.value; renderAll(); });
document.getElementById('addExerciseBtn')?.addEventListener('click', () => openForm());
document.getElementById('refreshBtn')?.addEventListener('click', () => { renderAll(); showToast('Refreshed'); });
document.addEventListener('click', () => document.getElementById('profileDropdown')?.classList.add('hidden'));
document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { closeActionMenu(); closeDetailModal(); closeFormModal(); closeVideoModal(); closeDeleteModal(); } });
document.querySelector('.physio-toggle')?.addEventListener('click', function() { const sub = document.querySelector('.physio-submenu'), arrow = document.querySelector('.physio-arrow'); if (sub.style.display === 'none' || !sub.style.display) { sub.style.display = 'block'; arrow.style.transform = 'rotate(180deg)'; } else { sub.style.display = 'none'; arrow.style.transform = 'rotate(0deg)'; } });
document.querySelector('.physio-submenu').style.display = 'block'; document.querySelector('.physio-arrow').style.transform = 'rotate(180deg)';
function refreshAllCharts() { setTimeout(() => { window.dispatchEvent(new Event('resize')); }, 350); }
document.querySelector('.lucide-menu')?.closest('button')?.addEventListener('click', refreshAllCharts);

initFilters(); renderAll();
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
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Super Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts" crossorigin="anonymous"></script>
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

        .action-menu { position: fixed; z-index: 1000; background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); min-width: 200px; padding: 0.25rem; animation: fadeIn 0.12s ease-out; }
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
        .modal-container { background: white; border-radius: 0.75rem; box-shadow: 0 20px 60px rgba(0,0,0,0.2); width: 90%; max-width: 600px; max-height: 85vh; overflow-y: auto; animation: modalSlide 0.2s ease-out; }
        @keyframes modalSlide { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        body.dark .modal-container { background: #131212; border: 1px solid #333; }

        .switch-root { position: relative; display: inline-flex; align-items: center; width: 44px; height: 24px; border-radius: 9999px; background-color: #cbd5e1; cursor: pointer; transition: background-color 0.2s; }
        .switch-root[data-state="checked"] { background-color: #6366f1; }
        .switch-thumb { display: block; width: 20px; height: 20px; background-color: white; border-radius: 9999px; transition: transform 0.2s; transform: translateX(2px); box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .switch-root[data-state="checked"] .switch-thumb { transform: translateX(22px); }

        .staff-checklist-scroll { max-height: 280px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 0.5rem; }
        body.dark .staff-checklist-scroll { border-color: #404040; }
        .select-trigger { display: flex; align-items: center; justify-content: space-between; width: 100%; height: 40px; border: 1px solid #d1d5db; background-color: white; padding: 0 0.75rem; font-size: 0.875rem; cursor: pointer; border-radius: 0.375rem; }
        body.dark .select-trigger { background-color: #131212; border-color: #404040; color: #e5e5e5; }
        .select-dropdown { position: absolute; z-index: 50; background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); margin-top: 4px; min-width: 100%; max-height: 200px; overflow-y: auto; }
        body.dark .select-dropdown { background: #2a2a2a; border-color: #404040; }
        .select-item { padding: 0.5rem 0.75rem; cursor: pointer; font-size: 0.875rem; transition: background 0.1s; }
        .select-item:hover { background-color: #f3f4f6; }
        body.dark .select-item:hover { background-color: #3f3f46; }

        .bulk-bar { position: fixed; bottom: 24px; left: 50%; transform: translateX(-50%); z-index: 500; background: #1f2937; color: white; border-radius: 0.75rem; padding: 0.75rem 1.5rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 10px 40px rgba(0,0,0,0.3); animation: slideUpBulk 0.3s ease-out; }
        .bulk-bar button { background: rgba(255,255,255,0.15); color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.375rem; cursor: pointer; font-size: 0.8125rem; transition: background 0.15s; }
        .bulk-bar button:hover { background: rgba(255,255,255,0.25); }
        .bulk-bar button.danger { background: #ef4444; }
        .bulk-bar button.danger:hover { background: #dc2626; }
        @keyframes slideUpBulk { from { transform: translateX(-50%) translateY(20px); opacity: 0; } to { transform: translateX(-50%) translateY(0); opacity: 1; } }

        .inline-edit-row td { padding: 0.5rem 1rem; }
        .inline-edit-row input, .inline-edit-row select { width: 100%; border-radius: 0.375rem; border: 1px solid #d1d5db; padding: 0.375rem 0.5rem; font-size: 0.8125rem; }
        body.dark .inline-edit-row input, body.dark .inline-edit-row select { background: #262626; border-color: #404040; color: #e5e5e5; }

        .quick-stats { display: flex; gap: 1.5rem; flex-wrap: wrap; padding: 0.75rem 1rem; background: #f9fafb; border-radius: 0.5rem; border: 1px solid #e5e7eb; font-size: 0.8125rem; }
        body.dark .quick-stats { background: #1a1a1a; border-color: #404040; }
        .quick-stats .stat-item { display: flex; align-items: center; gap: 0.375rem; }
        .quick-stats .dot { width: 8px; height: 8px; border-radius: 50%; }
        .quick-stats .dot.green { background: #10b981; }
        .quick-stats .dot.amber { background: #f59e0b; }
        .quick-stats .dot.red { background: #ef4444; }
        .quick-stats .dot.blue { background: #6366f1; }

        .alerts-banner { background: #fef3c7; border: 1px solid #fcd34d; border-radius: 0.5rem; padding: 0.625rem 1rem; font-size: 0.8125rem; display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }
        body.dark .alerts-banner { background: #451a03; border-color: #78350f; color: #fde68a; }
        .alerts-banner .alert-dot { width: 6px; height: 6px; border-radius: 50%; background: #f59e0b; animation: pulse 1.5s infinite; }
        @keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: 0.3; } }

        .row-selected { background: #eef2ff !important; }
        body.dark .row-selected { background: #1e1b4b !important; }

        .kill-card { border: 2px solid #fca5a5; background: #fef2f2; border-radius: 0.75rem; padding: 1.5rem; transition: all 0.3s; }
        body.dark .kill-card { background: #450a0a; border-color: #dc2626; }
        .kill-card.locked { border-color: #dc2626; background: #fee2e2; }
        body.dark .kill-card.locked { background: #7f1d1d; }
    </style>
</head>
<body class="bg-gray-50 antialiased">

<header class="sticky top-0 z-40 border-b bg-background shadow-sm border-gray-200">
    <div class="flex h-16 items-center justify-between px-4 md:px-6">
        <div class="flex items-center gap-2">
            <button class="focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg></button>
            <a href="index.html" class="flex items-center space-x-2"><img alt="Medi-track" src="logo.png" class="h-8" ><span class="font-bold text-xl">Medi-track</span></a>
        </div>
        <div class="flex items-center gap-4">
            <button id="meditrack-lang-btn" class="inline-flex items-center justify-center gap-1 rounded-md border border-gray-200 bg-white px-2.5 py-1.5 text-sm font-medium text-gray-700 transition-colors hover:border-indigo-500 hover:bg-gray-50 size-10" aria-label="Language">
                        <span style="font-size: 16px;">🇬🇧</span>
                        <span class="hidden sm:inline">EN</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>
            <button id="themeToggleBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-gray-100 size-10" aria-label="Toggle theme">
                <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="hidden text-gray-600"><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-600"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
            </button>
            <div class="relative">
                <button id="profileBtn" class="flex items-center justify-center h-8 w-8 rounded-full hover:ring-2 hover:ring-gray-200"><img src="user.png" alt="Profile" class="h-8 w-8 rounded-full object-cover"></button>
                <div id="profileDropdown" class="hidden absolute right-0 mt-2 z-50 w-56 rounded-md border bg-background shadow-lg p-1">
                    <div class="px-2 py-1.5 border-b"><p class="font-medium text-sm">System Admin</p><p class="text-xs text-gray-500">superadmin@hospital.ug</p></div>
                    <a href="profile-setting.html" class="flex items-center gap-2 px-2 py-1.5 text-sm hover:bg-gray-100 rounded">Profile</a>
                    <a href="settings.html" class="flex items-center gap-2 px-2 py-1.5 text-sm hover:bg-gray-100 rounded">Settings</a>
                    <div class="border-t my-1"></div>
                    <a href="login.html" class="flex items-center gap-2 px-2 py-1.5 text-sm text-red-600 hover:bg-gray-100 rounded">Log out</a>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="flex flex-1 items-start relative">
    <aside class="!fixed h-full left-0 bottom-0 z-50 flex w-64 flex-col border-r bg-background transition-transform duration-300 ease-in-out translate-x-0 shadow-lg">
        <div class="flex py-3 xl:py-3.5 items-center justify-between px-4 border-b border-gray-200">
            <a class="flex items-center space-x-2" href="index.html"><img alt="Meditrack" width="36" height="36" src="logo.png"><span class="font-bold inline-block">Medi-track</span></a>
            <button class="inline-flex items-center justify-center shrink-0 gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors hover:bg-gray-100 hover:text-gray-900 size-10 xl:hidden"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-x size-6 text-gray-600"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button>
        </div>
        <div class="flex-1 py-2 border-t border-gray-200 h-full overflow-y-auto custom-scrollbar">
            <nav class="space-y-1 px-2">
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100" href="index.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-layout-dashboard mr-2 h-4 w-4"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>Dashboard</a>
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium bg-indigo-50 text-indigo-700" href="super-admin.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-shield mr-2 h-4 w-4"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/></svg>Super Admin</a>
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100" href="staff-management.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-users mr-2 h-4 w-4"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>Staff Management</a>
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100" href="roles-permissions.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-shield-check mr-2 h-4 w-4"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>Roles & Permissions</a>
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100" href="departments.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-building2 mr-2 h-4 w-4"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></svg>Departments</a>
                <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100" href="settings.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="lucide lucide-settings mr-2 h-4 w-4"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>Settings</a>
            </nav>
        </div>
        <div class="border-t border-gray-200 dark:border-[#262626] shrink-0">
            <div class="px-3 pt-3"><div class="trial-item bg-white dark:bg-gray-800 text-center border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden relative"><div class="bg-indigo-50 dark:bg-indigo-900/30 p-3 text-center"><svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-500 mx-auto lucide lucide-gem"><path d="M10.5 3 8 9l4 13 4-13-2.5-6"/><path d="M17 3a2 2 0 0 1 1.6.8l3 4a2 2 0 0 1 .013 2.382l-7.99 10.986a2 2 0 0 1-3.247 0l-7.99-10.986A2 2 0 0 1 2.4 7.8l2.998-3.997A2 2 0 0 1 7 3z"/><path d="M2 9h20"/></svg></div><div class="p-3"><h6 class="text-sm font-semibold mb-1 text-gray-800 dark:text-gray-200">Enterprise Suite</h6><p class="text-xs text-gray-500 mb-3">Unlimited access & users</p><button id="upgradeBtn" class="bg-primary text-white hover:bg-primary/90 w-full h-9 rounded-md text-xs font-medium flex items-center justify-center gap-1.5 transition">Upgrade Now</button></div><button class="close-icon absolute top-2 right-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 h-6 w-6 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition" onclick="this.closest('.trial-item').style.display='none'" title="Dismiss"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button></div></div>
            <div class="p-4"><div class="flex items-center gap-3"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span><div class="space-y-0.5"><p class="text-sm font-medium">Dr. Nakato Sarah</p><p class="text-xs text-gray-500">Super Admin</p></div></div></div>
        </div>
    </aside>

    <main class="flex-1 overflow-auto p-4 xl:p-6 xl:ml-64 w-full">
        <div class="flex flex-col gap-6">
            <!-- Maintenance Mode Banner -->
            <div class="alerts-banner" id="maintenanceBanner" style="display:none; background:#fee2e2; border-color:#f87171;">
                <span class="alert-dot" style="background:#ef4444;"></span>
                <strong>⚠️ MAINTENANCE MODE ACTIVE</strong> — System is locked for all non-admin users
                <span>·</span><span>Only Super Admins can access the system</span>
                <button class="ml-auto px-3 py-1 bg-red-600 text-white rounded-md text-xs font-bold hover:bg-red-700" onclick="toggleMaintenanceMode()">DISABLE MAINTENANCE MODE</button>
            </div>
            <!-- Kill Switch Banner -->
            <div class="alerts-banner" id="killSwitchBanner" style="display:none; background:#7f1d1d; border-color:#991b1b; color:#fecaca;">
                <span class="alert-dot" style="background:#fff; animation: pulse 0.5s infinite;"></span>
                <strong>🔒 KILL SWITCH ACTIVATED</strong> — All users locked out. Only Super Admin access permitted.
                <span>·</span><span>System fully locked down</span>
                <button class="ml-auto px-3 py-1 bg-white text-red-700 rounded-md text-xs font-bold hover:bg-gray-100" onclick="toggleKillSwitch()">DEACTIVATE KILL SWITCH</button>
            </div>
            <!-- Alerts Banner -->
            <div class="alerts-banner" id="alertsBanner">
                <span class="alert-dot"></span><span><strong>2 users</strong> have expired passwords</span>
                <span>·</span><span>🔄 <strong>Backup running</strong> (78%)</span>
                <span>·</span><span>✅ All services healthy</span>
                <button class="ml-auto text-xs underline hover:no-underline" onclick="this.parentElement.style.display='none'">Dismiss</button>
            </div>

            <div class="flex items-center justify-between flex-wrap gap-4"><div><h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Super Admin Panel</h1><p class="text-gray-500">System configuration, user management, and security controls</p></div><div class="flex gap-2"><button id="refreshBtn" class="inline-flex items-center gap-2 rounded-md border px-3 py-2 text-sm hover:bg-accent"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>Refresh</button><button id="exportBtn" class="inline-flex items-center gap-2 rounded-md border px-3 py-2 text-sm hover:bg-accent"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg>Export</button></div></div>

            <div class="quick-stats" id="quickStatsBar">
                <div class="stat-item"><span class="dot blue"></span> <strong id="qsTotal">63</strong> Total</div>
                <div class="stat-item"><span class="dot green"></span> <strong id="qsActive">52</strong> Active</div>
                <div class="stat-item"><span class="dot amber"></span> <strong id="qsLeave">8</strong> On Leave</div>
                <div class="stat-item"><span class="dot red"></span> <strong id="qsInactive">3</strong> Inactive</div>
                <div class="stat-item">📋 <strong id="qsDepts">8</strong> Departments</div>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg text-card-foreground p-4 border bg-background shadow-sm hover:shadow-md transition cursor-pointer" onclick="activateTab('users')"><div class="flex items-center space-x-2"><div class="bg-blue-100 p-2 rounded-lg"><svg class="h-5 w-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div><span class="font-medium">Total Users</span></div><div class="mt-4"><div class="text-3xl font-bold" id="statUsers">63</div><p class="text-xs text-gray-500">8 departments</p></div><div class="mt-6"><button class="flex items-center justify-between w-full text-sm text-blue-600 font-medium hover:underline"><span>Manage Users</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg></button></div></div>
                <div class="rounded-lg text-card-foreground p-4 border bg-background shadow-sm hover:shadow-md transition cursor-pointer" onclick="window.location.href='roles-permissions.html'"><div class="flex items-center space-x-2"><div class="bg-purple-100 p-2 rounded-lg"><svg class="h-5 w-5 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg></div><span class="font-medium">Active Roles</span></div><div class="mt-4"><div class="text-3xl font-bold" id="statRoles">6</div><p class="text-xs text-gray-500">Custom permissions</p></div><div class="mt-6"><button class="flex items-center justify-between w-full text-sm text-purple-600 font-medium hover:underline"><span>Manage Roles</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg></button></div></div>
                <div class="rounded-lg text-card-foreground p-4 border bg-background shadow-sm hover:shadow-md transition cursor-pointer" onclick="activateTab('audit')"><div class="flex items-center space-x-2"><div class="bg-amber-100 p-2 rounded-lg"><svg class="h-5 w-5 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/></svg></div><span class="font-medium">Audit Logs</span><span class="ml-auto text-sm text-amber-500 font-medium">1.2k entries</span></div><div class="mt-4"><div class="text-3xl font-bold">1,247</div><p class="text-xs text-gray-500">Actions logged this month</p></div><div class="mt-6"><button class="flex items-center justify-between w-full text-sm text-amber-600 font-medium hover:underline"><span>View Audit Log</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg></button></div></div>
                <div class="rounded-lg text-card-foreground p-4 border bg-background shadow-sm hover:shadow-md transition cursor-pointer" onclick="activateTab('system')"><div class="flex items-center space-x-2"><div class="bg-green-100 p-2 rounded-lg"><svg class="h-5 w-5 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg></div><span class="font-medium">System Health</span></div><div class="mt-4"><div class="text-3xl font-bold text-green-600">99.97%</div><p class="text-xs text-gray-500">Uptime this month</p></div><div class="mt-6"><button class="flex items-center justify-between w-full text-sm text-green-600 font-medium hover:underline"><span>System Status</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg></button></div></div>
            </div>

            <div class="w-full">
                <div role="tablist" class="inline-flex flex-wrap items-center rounded-md bg-muted p-1 text-muted-foreground mb-4">
                    <button type="button" data-tab="users" class="tab-btn inline-flex rounded-sm px-3 py-1.5 text-sm font-medium active">User Management</button>
                    <button type="button" data-tab="roles" class="tab-btn inline-flex rounded-sm px-3 py-1.5 text-sm font-medium">Role Assignment</button>
                    <button type="button" data-tab="audit" class="tab-btn inline-flex rounded-sm px-3 py-1.5 text-sm font-medium">Audit Logs</button>
                    <button type="button" data-tab="departments" class="tab-btn inline-flex rounded-sm px-3 py-1.5 text-sm font-medium">Departments</button>
                    <button type="button" data-tab="system" class="tab-btn inline-flex rounded-sm px-3 py-1.5 text-sm font-medium">System</button>
                </div>

                <!-- USER MANAGEMENT TAB -->
                <div id="tab-users" role="tabpanel" data-state="active" class="mt-4 space-y-6">
                    <div class="rounded-lg border bg-background shadow-sm">
                        <div class="p-4 md:p-6"><div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"><div><h2 class="text-xl font-semibold">Staff Directory</h2><div class="text-gray-500" id="totalUsersCount">Total of 63 staff members</div></div><div class="flex flex-wrap gap-2"><div class="relative"><svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg><input id="searchInput" class="pl-8 h-10 rounded-md border border-gray-300 px-3 py-2 text-sm w-full md:w-[260px]" placeholder="Search users... (Ctrl+K)"></div><button id="assignUserBtn" class="inline-flex items-center gap-2 rounded-md bg-primary px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>Assign Users (Ctrl+N)</button><button id="exportUsersBtn" class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-background px-4 py-2 text-sm font-medium hover:bg-gray-100 h-10"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>Export</button></div></div></div>
                        <div class="p-4 md:p-6 pt-0 overflow-auto">
                            <table class="w-full text-sm"><thead class="border-b"><tr><th class="text-left p-3 font-medium w-10"><input type="checkbox" id="selectAllUsers" class="w-4 h-4 rounded border-gray-300"></th><th class="text-left p-3 font-medium">Name</th><th class="text-left p-3 font-medium">Role</th><th class="text-left p-3 font-medium hidden md:table-cell">Department</th><th class="text-left p-3 font-medium hidden md:table-cell">Contact</th><th class="text-left p-3 font-medium hidden md:table-cell">Joined</th><th class="text-left p-3 font-medium">Status</th><th class="text-right p-3 font-medium">Actions</th></tr></thead><tbody id="usersTableBody"></tbody></table>
                        </div>
                    </div>
                </div>

                <!-- ROLE ASSIGNMENT TAB -->
                <div id="tab-roles" role="tabpanel" data-state="inactive" class="mt-4 space-y-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"><div><h2 class="text-xl font-semibold">Role Assignment</h2><p class="text-gray-500">Assign roles and permissions to users across the hospital</p></div><div class="flex flex-wrap gap-2"><button id="assignNewRoleBtn" class="inline-flex items-center gap-2 rounded-md bg-primary text-white px-4 py-2 text-sm hover:bg-primary/90"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>Assign New Role</button><button id="exportRolesBtn" class="inline-flex items-center gap-2 rounded-md border px-3 py-2 text-sm hover:bg-accent"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg>Export</button></div></div>
                    <div class="flex flex-col gap-3 md:flex-row md:items-center flex-wrap"><div class="relative flex-1 min-w-[260px]"><svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg><input id="roleAssignmentSearch" type="search" placeholder="Search by name, email, department or role..." class="h-10 w-full rounded-md border border-gray-300 pl-8 pr-3 text-sm"></div><div class="flex gap-2 flex-wrap"><div class="relative"><button id="roleDeptFilterBtn" class="select-trigger w-[170px]"><span id="roleDeptFilterText">All Departments</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="roleDeptFilterDropdown" class="hidden select-dropdown"><div class="select-item" data-value="all">All Departments</div><div class="select-item" data-value="Cardiology">Cardiology</div><div class="select-item" data-value="Neurology">Neurology</div><div class="select-item" data-value="Orthopedics">Orthopedics</div><div class="select-item" data-value="Administration">Administration</div><div class="select-item" data-value="Pharmacy">Pharmacy</div><div class="select-item" data-value="Laboratory">Laboratory</div></div></div><div class="relative"><button id="roleStatusFilterBtn" class="select-trigger w-[150px]"><span id="roleStatusFilterText">All Status</span><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg></button><div id="roleStatusFilterDropdown" class="hidden select-dropdown"><div class="select-item" data-value="all">All Status</div><div class="select-item" data-value="Active">Active</div><div class="select-item" data-value="Inactive">Inactive</div></div></div></div></div>
                    <div class="grid gap-4 grid-cols-2 md:grid-cols-4 lg:grid-cols-8" id="roleSummaryCards"></div>
                    <div class="rounded-lg border bg-background shadow-sm"><div class="p-4 md:p-6 pt-0 overflow-auto"><table class="w-full text-sm"><thead class="border-b"><tr><th class="text-left p-3 font-medium w-10"><input type="checkbox" id="selectAllRoles" class="w-4 h-4 rounded border-gray-300"></th><th class="text-left p-3 font-medium cursor-pointer" data-sort="name">Name <span class="sort-arrow text-xs">↕</span></th><th class="text-left p-3 font-medium hidden md:table-cell" data-sort="department">Department</th><th class="text-left p-3 font-medium" data-sort="role">Current Role(s)</th><th class="text-left p-3 font-medium hidden md:table-cell">Assigned By</th><th class="text-left p-3 font-medium hidden lg:table-cell">Last Updated</th><th class="text-left p-3 font-medium">Status</th><th class="text-right p-3 font-medium">Actions</th></tr></thead><tbody id="roleAssignmentTableBody"></tbody></table><div class="mt-4 flex items-center justify-between" id="rolePagination"></div></div></div>
                </div>

                <!-- AUDIT LOGS TAB -->
                <div id="tab-audit" role="tabpanel" data-state="inactive" class="mt-4 space-y-6">
                    <div class="flex justify-between items-center flex-wrap gap-3"><div class="flex gap-2 flex-wrap"><div class="relative w-64"><svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg><input id="auditSearch" type="search" placeholder="Search audit logs..." class="h-10 w-full rounded-md border border-gray-300 pl-8 pr-3 text-sm"></div></div><button id="exportAuditBtn" class="inline-flex items-center gap-2 rounded-md border px-3 py-2 text-sm hover:bg-accent"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/></svg>Export Logs</button></div>
                    <div class="rounded-lg border bg-white overflow-x-auto"><table class="w-full text-sm"><thead class="bg-gray-50 border-b"><tr><th class="h-10 px-4 text-left">Timestamp</th><th class="h-10 px-4 text-left">User</th><th class="h-10 px-4 text-left">Action</th><th class="h-10 px-4 text-left">Entity</th><th class="h-10 px-4 text-left">Department</th><th class="h-10 px-4 text-left">IP Address</th></tr></thead><tbody id="auditTableBody"></tbody></table></div>
                </div>

                <!-- DEPARTMENTS TAB -->
                <div id="tab-departments" role="tabpanel" data-state="inactive" class="mt-4 space-y-6">
                    <div class="flex justify-between items-center flex-wrap gap-3">
                        <div><h2 class="text-xl font-semibold">Department List</h2><p class="text-gray-500">View and manage all departments</p></div>
                        <button id="addDeptBtn" class="inline-flex items-center gap-2 rounded-md bg-primary text-white px-4 py-2 text-sm hover:bg-primary/90"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Add Department</button>
                    </div>
                    <div class="rounded-lg border bg-background shadow-sm">
                        <div class="p-4 border-b">
                            <div class="relative"><svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg><input id="deptSearchInput" type="text" placeholder="Search departments..." class="h-10 rounded-md border border-gray-300 bg-background pl-8 pr-3 text-sm w-full md:w-[300px]"></div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm"><thead><tr class="border-b"><th class="text-left p-3">Department Name</th><th class="text-left p-3">Head of Department</th><th class="text-left p-3">Staff Count</th><th class="text-left p-3">Services</th><th class="text-left p-3">Status</th><th class="text-right p-3">Actions</th></tr></thead><tbody id="deptTableBody"></tbody></table>
                        </div>
                    </div>
                </div>

                <!-- SYSTEM TAB -->
                <div id="tab-system" role="tabpanel" data-state="inactive" class="mt-4 space-y-6">
                    <!-- Emergency Header -->
                    <div class="flex items-center justify-between flex-wrap gap-3 p-4 rounded-lg border-2 border-red-200 bg-red-50" id="emergencyHeader">
                        <div class="flex items-center gap-3">
                            <div class="bg-red-500 text-white rounded-full p-2 animate-pulse"><svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v4"/><path d="M12 17h.01"/><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/></svg></div>
                            <div><h3 class="text-lg font-bold text-red-700">System Controls</h3><p class="text-sm text-red-600">Emergency actions affect all users immediately</p></div>
                        </div>
                        <div class="flex gap-2 flex-wrap">
                            <button id="emergencyStopBtn" class="inline-flex items-center gap-2 rounded-md bg-red-600 text-white px-5 py-2.5 text-sm font-bold hover:bg-red-700 shadow-lg transition" onclick="toggleEmergencyStop()">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect width="16" height="16" x="4" y="4" rx="2"/><line x1="9" y1="9" x2="15" y2="15"/><line x1="15" y1="9" x2="9" y2="15"/></svg>
                                <span id="emergencyStopText">EMERGENCY STOP</span>
                            </button>
                            <button id="restartServicesBtn" class="inline-flex items-center gap-2 rounded-md border-2 border-amber-300 bg-amber-50 text-amber-700 px-4 py-2 text-sm font-medium hover:bg-amber-100 transition" onclick="restartServices()">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/></svg>
                                Restart Services
                            </button>
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                        <div class="rounded-lg border bg-background p-4 hover:shadow-md transition"><div class="flex items-center justify-between mb-3"><span class="text-sm font-medium text-gray-500">CPU Usage</span><div class="bg-blue-100 p-1.5 rounded-lg"><svg class="h-5 w-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="16" x="4" y="4" rx="2"/><rect width="6" height="6" x="9" y="9" rx="1"/><path d="M15 2v2"/><path d="M15 20v2"/><path d="M2 15h2"/><path d="M2 9h2"/><path d="M20 15h2"/><path d="M20 9h2"/><path d="M9 2v2"/><path d="M9 20v2"/></svg></div></div><div class="text-2xl font-bold" id="cpuUsage">34%</div><p class="text-xs text-gray-500 mt-1">4 cores · 3.2 GHz</p><div class="mt-3 w-full bg-gray-200 rounded-full h-2"><div class="bg-blue-500 h-2 rounded-full" style="width:34%"></div></div></div>
                        <div class="rounded-lg border bg-background p-4 hover:shadow-md transition"><div class="flex items-center justify-between mb-3"><span class="text-sm font-medium text-gray-500">Memory Usage</span><div class="bg-amber-100 p-1.5 rounded-full"><svg class="h-5 w-5 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2"/><line x1="8" x2="16" y1="6" y2="6"/><line x1="8" x2="16" y1="10" y2="10"/></svg></div></div><div class="text-2xl font-bold" id="memUsage">62%</div><p class="text-xs text-gray-500 mt-1">9.9 GB / 16 GB</p><div class="mt-3 w-full bg-gray-200 rounded-full h-2"><div class="bg-amber-500 h-2 rounded-full" style="width:62%"></div></div></div>
                        <div class="rounded-lg border bg-background p-4 hover:shadow-md transition"><div class="flex items-center justify-between mb-3"><span class="text-sm font-medium text-gray-500">Disk Space</span><div class="bg-green-100 p-1.5 rounded-lg"><svg class="h-5 w-5 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5V19A9 3 0 0 0 21 19V5"/><path d="M3 12A9 3 0 0 0 21 12"/></svg></div></div><div class="text-2xl font-bold" id="diskUsage">48%</div><p class="text-xs text-gray-500 mt-1">480 GB / 1 TB</p><div class="mt-3 w-full bg-gray-200 rounded-full h-2"><div class="bg-green-500 h-2 rounded-full" style="width:48%"></div></div></div>
                        <div class="rounded-lg border bg-background p-4 hover:shadow-md transition"><div class="flex items-center justify-between mb-3"><span class="text-sm font-medium text-gray-500">Active Sessions</span><div class="bg-purple-100 p-1.5 rounded-lg"><svg class="h-5 w-5 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div></div><div class="text-2xl font-bold" id="activeSessions">247</div><p class="text-xs text-gray-500 mt-1">Last 24 hours · 12 peak</p><div class="mt-3 w-full bg-gray-200 rounded-full h-2"><div class="bg-purple-500 h-2 rounded-full" style="width:62%"></div></div></div>
                    </div>

                    <!-- Kill Switch Card -->
                    <div class="kill-card" id="killSwitchCard">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div class="flex items-center gap-4">
                                <div class="bg-red-500 text-white rounded-full p-3"><svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg></div>
                                <div><h3 class="text-xl font-bold text-red-700">Kill Switch</h3><p class="text-sm text-red-600">Immediately locks all users out of the system. Only Super Admins can access during lockdown.</p><div class="flex items-center gap-2 mt-2"><span class="inline-flex items-center gap-1 text-xs font-medium" id="killSwitchStatus"><span class="w-2 h-2 rounded-full bg-green-500"></span> System is running normally</span></div></div>
                            </div>
                            <button id="killSwitchBtn" class="inline-flex items-center gap-2 rounded-md bg-red-600 text-white px-6 py-3 text-sm font-bold hover:bg-red-700 shadow-lg transition" onclick="toggleKillSwitch()">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2 4 6v6c0 3.31 3.58 8 8 10 4.42-2 8-6.69 8-10V6l-8-4z"/><path d="M12 11c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/><path d="M12 11v4"/></svg>
                                <span id="killSwitchBtnText">ACTIVATE KILL SWITCH</span>
                            </button>
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2"><div class="rounded-lg border bg-background p-4"><h3 class="text-lg font-semibold mb-2">API Request Volume</h3><div id="apiRequestsChart" class="h-[300px]"></div></div><div class="rounded-lg border bg-background p-4"><h3 class="text-lg font-semibold mb-2">Error Rate (Last 24h)</h3><div id="errorRateChart" class="h-[300px]"></div></div></div>
                    <div class="rounded-lg border bg-background p-6"><h3 class="text-lg font-semibold mb-4">System Configuration</h3><div class="grid gap-4 md:grid-cols-2"><div class="flex justify-between items-center"><div><p class="font-medium">Auto-backup</p><p class="text-xs text-gray-500">Daily database backup at 2:00 AM</p></div><button class="switch-root" data-state="checked" id="autoBackupSwitch"><span class="switch-thumb"></span></button></div><div class="flex justify-between items-center"><div><p class="font-medium">Maintenance Mode</p><p class="text-xs text-gray-500">Restrict access during updates</p></div><button class="switch-root" data-state="unchecked" id="maintenanceSwitch"><span class="switch-thumb"></span></button></div><div class="flex justify-between items-center"><div><p class="font-medium">Error Notifications</p><p class="text-xs text-gray-500">Email alerts for system errors</p></div><button class="switch-root" data-state="checked" id="errorNotifySwitch"><span class="switch-thumb"></span></button></div><div class="flex justify-between items-center"><div><p class="font-medium">Debug Logging</p><p class="text-xs text-gray-500">Detailed logs for troubleshooting</p></div><button class="switch-root" data-state="unchecked" id="debugLogSwitch"><span class="switch-thumb"></span></button></div></div></div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Bulk Bar -->
<div id="bulkBar" class="bulk-bar" style="display:none;"><span id="bulkCount">0 selected</span><button onclick="bulkAction('role')">Assign Role</button><button onclick="bulkAction('status')">Change Status</button><button onclick="bulkAction('export')">Export</button><button class="danger" onclick="bulkAction('delete')">Delete</button><button onclick="clearBulkSelection()" style="background:transparent;">✕</button></div>

<!-- Modals -->
<div id="assignModal" style="display:none;" class="modal-overlay"><div class="modal-container"><div class="flex justify-between items-start mb-4 p-6 pb-0"><div><h3 class="text-lg font-semibold">Assign Users to Role</h3><p class="text-gray-500">Select staff members to assign</p></div><button id="closeAssignModalBtn" class="text-gray-400 hover:text-gray-600"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button></div><div class="p-6 pt-2"><div class="relative mb-3"><svg class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg><input type="text" id="assignSearchInput" placeholder="Search staff..." class="pl-8 w-full rounded-md border border-gray-300 p-2 text-sm"></div><div id="staffChecklist" class="staff-checklist-scroll space-y-2 rounded-md p-2"></div><p class="text-xs text-gray-400 mt-2">Scroll to see all available staff members</p></div><div class="flex justify-end gap-2 p-6 pt-0"><button id="cancelAssignBtn" class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Cancel</button><button id="confirmAssignBtn" class="px-4 py-2 bg-primary text-white rounded-md text-sm hover:bg-indigo-700">Assign Selected Users</button></div></div></div>
<div id="addDeptModal" style="display:none;" class="modal-overlay"><div class="modal-container" style="max-width:500px;"><div class="flex justify-between items-start mb-4 p-6 pb-0"><div><h3 class="text-lg font-semibold">Add Department</h3><p class="text-gray-500">Create a new department</p></div><button id="closeAddDeptModalBtn" class="text-gray-400 hover:text-gray-600"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button></div><div class="p-6 pt-2 space-y-4"><div><label class="text-sm font-medium block mb-1">Department Name</label><input id="newDeptName" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Enter department name"></div><div><label class="text-sm font-medium block mb-1">Head of Department</label><input id="newDeptHead" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Enter head name"></div><div><label class="text-sm font-medium block mb-1">Description</label><textarea id="newDeptDesc" rows="2" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" placeholder="Enter description"></textarea></div></div><div class="flex justify-end gap-2 p-6 pt-0"><button id="cancelAddDeptBtn" class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Cancel</button><button id="confirmAddDeptBtn" class="px-4 py-2 bg-primary text-white rounded-md text-sm hover:bg-indigo-700">Add Department</button></div></div></div>
<div id="deleteModal" style="display:none;" class="modal-overlay"><div class="modal-container" style="max-width:500px;"><div class="p-6"><div class="flex flex-col space-y-2 text-center sm:text-left"><h2 class="text-lg font-semibold">Confirm Deletion</h2><p class="text-sm text-gray-500" id="deleteModalMessage">This action cannot be undone.</p></div><div class="flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-2 mt-6"><button id="cancelDeleteBtn" class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100 mt-2 sm:mt-0">Cancel</button><button id="confirmDeleteBtn" class="px-4 py-2 bg-red-500 text-white rounded-md text-sm hover:bg-red-600">Delete</button></div></div></div></div>

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
// ==================== DATA ====================
const staffData = [
    { id: 1, name: "Dr. Nakato Sarah", email: "nakato.sarah@hospital.ug", role: "Administrator", department: "Cardiology", position: "Medical Director", joined: "2012-05-15", status: "Active" },
    { id: 2, name: "Dr. Mwangi Peter", email: "mwangi.peter@hospital.ug", role: "Doctor", department: "Neurology", position: "Neurologist", joined: "2015-06-22", status: "Active" },
    { id: 3, name: "Emily Rodriguez", email: "emily.r@hospital.ug", role: "Administrator", department: "Administration", position: "Clinic Manager", joined: "2018-02-10", status: "Active" },
    { id: 4, name: "Dr. Okello James", email: "james.w@hospital.ug", role: "Doctor", department: "Orthopedics", position: "Department Head", joined: "2016-09-30", status: "Active" },
    { id: 5, name: "Nabwire Lisa", email: "lisa.t@hospital.ug", role: "Administrator", department: "Administration", position: "Finance Director", joined: "2017-03-18", status: "Active" },
    { id: 6, name: "Robert Garcia", email: "robert.g@hospital.ug", role: "Staff", department: "IT", position: "Systems Admin", joined: "2019-11-05", status: "Inactive" },
    { id: 7, name: "Namyalo Maria", email: "maria.s@hospital.ug", role: "Pharmacist", department: "Pharmacy", position: "Chief Pharmacist", joined: "2018-07-07", status: "Active" },
    { id: 8, name: "Kemigisha Jennifer", email: "jennifer.t@hospital.ug", role: "Staff", department: "Laboratory", position: "Lab Supervisor", joined: "2020-01-12", status: "Active" },
];
const availableStaff = [
    { name: "Dr. Tumusiimeera Robert", email: "kimera.robert@hospital.ug", department: "Pediatrics", position: "Pediatrician" },
    { name: "Sarah Williams", email: "sarah.w@hospital.ug", department: "Nursing", position: "Head Nurse" },
    { name: "Mukasa David", email: "david.m@hospital.ug", department: "Administration", position: "HR Manager" },
    { name: "Dr. Kevin Anderson", email: "kevin.a@hospital.ug", department: "Orthopedics", position: "Orthopedic Surgeon" },
    { name: "Tumusiime Thomas", email: "thomas.w@hospital.ug", department: "IT", position: "Network Engineer" },
    { name: "Patricia Lee", email: "patricia.l@hospital.ug", department: "Administration", position: "Compliance Officer" },
];
const roleAssignments = [
    { id: 1, name: "Dr. Nakato Sarah", email: "nakato.sarah@hospital.ug", department: "Cardiology", roles: ["Administrator","Doctor"], assignedBy: "System Admin", lastUpdated: "2026-05-10", status: "Active" },
    { id: 2, name: "Dr. Mwangi Peter", email: "mwangi.peter@hospital.ug", department: "Neurology", roles: ["Doctor","Department Head"], assignedBy: "Dr. Nakato Sarah", lastUpdated: "2026-04-22", status: "Active" },
    { id: 3, name: "Emily Rodriguez", email: "emily.r@hospital.ug", department: "Administration", roles: ["Administrator"], assignedBy: "System Admin", lastUpdated: "2026-03-15", status: "Active" },
    { id: 4, name: "Dr. Okello James", email: "james.w@hospital.ug", department: "Orthopedics", roles: ["Doctor"], assignedBy: "Dr. Nakato Sarah", lastUpdated: "2026-02-10", status: "Active" },
    { id: 5, name: "Nabwire Lisa", email: "lisa.t@hospital.ug", department: "Administration", roles: ["Administrator","Accountant"], assignedBy: "Emily Rodriguez", lastUpdated: "2026-01-20", status: "Active" },
    { id: 6, name: "Robert Garcia", email: "robert.g@hospital.ug", department: "IT", roles: ["Staff"], assignedBy: "Mwangi Peter", lastUpdated: "2025-11-05", status: "Inactive" },
    { id: 7, name: "Namyalo Maria", email: "maria.s@hospital.ug", department: "Pharmacy", roles: ["Pharmacist"], assignedBy: "Emily Rodriguez", lastUpdated: "2026-05-30", status: "Active" },
    { id: 8, name: "Kemigisha Jennifer", email: "jennifer.t@hospital.ug", department: "Laboratory", roles: ["Lab Technician"], assignedBy: "Dr. Nakato Sarah", lastUpdated: "2026-04-18", status: "Active" },
    { id: 9, name: "Sarah Williams", email: "sarah.w@hospital.ug", department: "Nursing", roles: ["Nurse","Head Nurse"], assignedBy: "Emily Rodriguez", lastUpdated: "2026-05-05", status: "Active" },
    { id: 10, name: "Mukasa David", email: "david.m@hospital.ug", department: "Administration", roles: ["HR Manager"], assignedBy: "System Admin", lastUpdated: "2026-03-28", status: "Active" },
];
const recentRoleChanges = [
    { user: "Namyalo Maria", prevRole: "Staff", newRole: "Pharmacist", changedBy: "Emily Rodriguez", date: "2026-05-30" },
    { user: "Dr. Nakato Sarah", prevRole: "Doctor", newRole: "Administrator, Doctor", changedBy: "System Admin", date: "2026-05-10" },
    { user: "Sarah Williams", prevRole: "Nurse", newRole: "Nurse, Head Nurse", changedBy: "Emily Rodriguez", date: "2026-05-05" },
    { user: "Kemigisha Jennifer", prevRole: "Staff", newRole: "Lab Technician", changedBy: "Dr. Nakato Sarah", date: "2026-04-18" },
];
const auditLogs = [
    { timestamp: "2026-06-13 10:32:15", user: "Dr. Nakato Sarah", action: "Login", entity: "User Session", dept: "Cardiology", ip: "192.168.1.45" },
    { timestamp: "2026-06-13 10:28:42", user: "Mwangi Peter", action: "Create", entity: "Patient Record #1245", dept: "Administration", ip: "10.0.0.22" },
    { timestamp: "2026-06-13 10:15:08", user: "Emily Rodriguez", action: "Update", entity: "Staff Schedule", dept: "Administration", ip: "172.16.0.15" },
    { timestamp: "2026-06-13 09:58:33", user: "System", action: "Delete", entity: "Expired Session", dept: "System", ip: "127.0.0.1" },
    { timestamp: "2026-06-13 09:45:21", user: "Nabwire Lisa", action: "Login", entity: "User Session", dept: "Administration", ip: "192.168.5.88" },
    { timestamp: "2026-06-12 16:22:10", user: "Dr. Okello James", action: "Update", entity: "Prescription #8901", dept: "Orthopedics", ip: "192.168.1.50" },
    { timestamp: "2026-06-12 14:10:05", user: "Namyalo Maria", action: "Create", entity: "Inventory Order #456", dept: "Pharmacy", ip: "192.168.1.72" },
];
const departmentsData = [
    { id: 1, name: "Cardiology", head: "Dr. Nakato Sarah", staff: 8, services: 12, status: "Active", icon: "" },
    { id: 2, name: "Neurology", head: "Dr. Mwangi Peter", staff: 6, services: 9, status: "Active", icon: "" },
    { id: 3, name: "Pediatrics", head: "Dr. Tumusiimeera Robert", staff: 10, services: 15, status: "Active", icon: "" },
    { id: 4, name: "Orthopedics", head: "Dr. Okello James", staff: 7, services: 11, status: "Active", icon: "" },
    { id: 5, name: "Laboratory", head: "Kemigisha Jennifer", staff: 5, services: 8, status: "Active", icon: "" },
    { id: 6, name: "Pharmacy", head: "Namyalo Maria", staff: 4, services: 6, status: "Active", icon: "" },
    { id: 7, name: "Nursing", head: "Sarah Williams", staff: 12, services: 10, status: "Active", icon: "" },
    { id: 8, name: "Administration", head: "Emily Rodriguez", staff: 6, services: 5, status: "Active", icon: "" },
    { id: 9, name: "IT", head: "Mwangi Peter", staff: 3, services: 4, status: "Active", icon: "" },
];

let activeActionMenu = null, selectedStaffForAssign = new Set(), selectedUserIds = new Set(), pendingDeleteTarget = null;
let roleAssignmentFilter = { search: '', dept: 'all', status: 'all', sort: 'name', sortDir: 'asc', page: 1, perPage: 8 };
let selectedRoleUsers = new Set(), inlineEditingId = null, systemKillSwitchActive = false;
let charts = {};

function showToast(msg, isError) { const t = document.createElement('div'); t.className = 'toast-message' + (isError ? ' error' : ''); t.textContent = msg; document.body.appendChild(t); setTimeout(() => t.remove(), 2500); }
function closeActionMenu() { if (activeActionMenu) { activeActionMenu.remove(); activeActionMenu = null; } }
function showActionMenu(btn, items) { closeActionMenu(); const rect = btn.getBoundingClientRect(); const menu = document.createElement('div'); menu.className = 'action-menu'; let left = rect.left, top = rect.bottom + 6; if (left + 220 > window.innerWidth) left = window.innerWidth - 230; if (top + items.length * 44 > window.innerHeight) top = rect.top - items.length * 44 - 10; menu.style.top = top + 'px'; menu.style.left = left + 'px'; let html = '<div class="action-menu-header">Actions</div>'; items.forEach(i => { if (i.divider) { html += '<div class="action-divider"></div>'; return; } html += `<button data-action="${i.action||''}" class="action-item${i.cls||''}"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">${i.icon}</svg>${i.label}</button>`; }); menu.innerHTML = html; document.body.appendChild(menu); activeActionMenu = menu; const closeHandler = (e) => { if (!menu.contains(e.target) && e.target !== btn) { closeActionMenu(); document.removeEventListener('click', closeHandler); } }; setTimeout(() => document.addEventListener('click', closeHandler), 10); menu.querySelectorAll('.action-item').forEach(el => { el.addEventListener('click', () => { const it = items.find(i => i.action === el.dataset.action && i.callback); if (it) it.callback(); closeActionMenu(); }); }); }
function updateBulkBar() { const bar = document.getElementById('bulkBar'); const count = selectedUserIds.size; if (count > 0) { bar.style.display = 'flex'; document.getElementById('bulkCount').textContent = `${count} selected`; } else { bar.style.display = 'none'; } }
function clearBulkSelection() { selectedUserIds.clear(); document.querySelectorAll('#usersTableBody .user-row-checkbox').forEach(cb => cb.checked = false); document.getElementById('selectAllUsers').checked = false; updateBulkBar(); }
function bulkAction(action) { const count = selectedUserIds.size; if (count === 0) return; if (action === 'delete') { if (confirm(`Delete ${count} user(s)?`)) { selectedUserIds.forEach(id => { const idx = staffData.findIndex(s => s.id === id); if (idx !== -1) staffData.splice(idx, 1); }); clearBulkSelection(); renderUsersTable(); updateStats(); showToast(`${count} user(s) deleted`); } } else { showToast(`${action} applied to ${count} user(s)`); } }
function startInlineEdit(userId) { inlineEditingId = userId; renderUsersTable(); }
function cancelInlineEdit() { inlineEditingId = null; renderUsersTable(); }
function saveInlineEdit(userId) { const user = staffData.find(s => s.id === userId); if (user) { user.name = document.getElementById('inlineName').value; user.role = document.getElementById('inlineRole').value; user.department = document.getElementById('inlineDept').value; } inlineEditingId = null; renderUsersTable(); showToast('User updated'); }

function openAssignModal() { selectedStaffForAssign.clear(); const existingEmails = new Set(staffData.map(u => u.email.toLowerCase())); const filtered = availableStaff.filter(s => !existingEmails.has(s.email.toLowerCase())); document.getElementById('staffChecklist').innerHTML = filtered.map(s => `<label class="flex items-center space-x-2 p-2 rounded-md hover:bg-muted cursor-pointer"><input type="checkbox" class="staff-checkbox w-4 h-4 rounded border-gray-300 text-indigo-600" value="${s.email}"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span><div class="flex-1 min-w-0"><p class="text-sm font-medium truncate">${s.name}</p><p class="text-xs text-gray-500 truncate">${s.department} · ${s.position}</p></div></label>`).join('') || '<p class="text-sm text-gray-400 text-center py-4">No available staff</p>'; document.querySelectorAll('.staff-checkbox').forEach(cb => cb.addEventListener('change', e => { if (e.target.checked) selectedStaffForAssign.add(e.target.value); else selectedStaffForAssign.delete(e.target.value); })); document.getElementById('assignModal').style.display = 'flex'; document.body.style.overflow = 'hidden'; }
function closeAssignModal() { document.getElementById('assignModal').style.display = 'none'; document.body.style.overflow = ''; }
function confirmAssign() { if (selectedStaffForAssign.size === 0) { showToast('Please select at least one user', true); return; } const today = new Date().toISOString().split('T')[0]; let count = 0; selectedStaffForAssign.forEach(email => { const s = availableStaff.find(a => a.email === email); if (s) { staffData.push({ id: Date.now() + Math.random(), name: s.name, email: s.email, role: 'Staff', department: s.department, position: s.position, joined: today, status: 'Active' }); count++; } }); selectedStaffForAssign.clear(); closeAssignModal(); renderUsersTable(); updateStats(); showToast(`${count} user(s) assigned successfully`); }
function openAddDeptModal() { document.getElementById('addDeptModal').style.display = 'flex'; document.body.style.overflow = 'hidden'; }
function closeAddDeptModal() { document.getElementById('addDeptModal').style.display = 'none'; document.body.style.overflow = ''; }
function confirmAddDept() { const name = document.getElementById('newDeptName').value.trim(); const head = document.getElementById('newDeptHead').value.trim(); if (!name) { showToast('Please enter a department name', true); return; } departmentsData.push({ id: Date.now(), name, head: head || 'TBD', staff: 0, services: 0, status: 'Active', icon: '🏢' }); closeAddDeptModal(); renderDepartments(); updateStats(); showToast(`Department "${name}" added successfully`); }
function openDeleteModal(target) { pendingDeleteTarget = target; document.getElementById('deleteModalMessage').textContent = `Are you sure you want to delete "${target.name || target.role}"? This action cannot be undone.`; document.getElementById('deleteModal').style.display = 'flex'; document.body.style.overflow = 'hidden'; }
function closeDeleteModal() { document.getElementById('deleteModal').style.display = 'none'; document.body.style.overflow = ''; pendingDeleteTarget = null; }
function confirmDelete() { if (!pendingDeleteTarget) return; if (pendingDeleteTarget.email) { const idx = staffData.findIndex(s => s.id === pendingDeleteTarget.id); if (idx !== -1) { staffData.splice(idx, 1); renderUsersTable(); } } else if (pendingDeleteTarget.id && pendingDeleteTarget.head !== undefined) { const idx = departmentsData.findIndex(d => d.id === pendingDeleteTarget.id); if (idx !== -1) { departmentsData.splice(idx, 1); renderDepartments(); } } updateStats(); closeDeleteModal(); showToast('Deleted successfully'); }

function renderUsersTable() {
    const search = document.getElementById('searchInput')?.value?.toLowerCase() || '';
    const filtered = staffData.filter(u => u.name.toLowerCase().includes(search) || u.email.toLowerCase().includes(search) || u.role.toLowerCase().includes(search));
    document.getElementById('totalUsersCount').textContent = `Total of ${filtered.length} staff members`;
    document.getElementById('usersTableBody').innerHTML = filtered.map(u => {
        if (inlineEditingId === u.id) return `<tr class="border-b bg-indigo-50 inline-edit-row"><td class="p-3"></td><td class="p-3"><input id="inlineName" value="${u.name}"></td><td class="p-3"><select id="inlineRole"><option ${u.role==='Administrator'?'selected':''}>Administrator</option><option ${u.role==='Doctor'?'selected':''}>Doctor</option><option ${u.role==='Nurse'?'selected':''}>Nurse</option><option ${u.role==='Staff'?'selected':''}>Staff</option><option ${u.role==='Pharmacist'?'selected':''}>Pharmacist</option></select></td><td class="p-3 hidden md:table-cell"><input id="inlineDept" value="${u.department}"></td><td class="p-3 hidden md:table-cell">—</td><td class="p-3 hidden md:table-cell">—</td><td class="p-3">—</td><td class="p-3 text-right"><button onclick="saveInlineEdit(${u.id})" class="text-green-600 mr-2 hover:underline text-sm">Save</button><button onclick="cancelInlineEdit()" class="text-gray-500 hover:underline text-sm">Cancel</button></td></tr>`;
        return `<tr class="border-b hover:bg-gray-50 transition ${selectedUserIds.has(u.id)?'row-selected':''}"><td class="p-3"><input type="checkbox" class="user-row-checkbox w-4 h-4 rounded border-gray-300" value="${u.id}" ${selectedUserIds.has(u.id)?'checked':''}></td><td class="p-4"><div class="flex items-center gap-2"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span><div><p class="font-medium">${u.name}</p><p class="text-xs text-gray-500">${u.email}</p></div></div></td><td class="p-4"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold bg-indigo-100 text-indigo-700">${u.role}</span></td><td class="p-4 hidden md:table-cell">${u.department}</td><td class="p-4 hidden md:table-cell text-xs">${u.email}<br>${u.position}</td><td class="p-4 hidden md:table-cell">${u.joined}</td><td class="p-4"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold ${u.status==='Active'?'bg-green-100 text-green-700':'bg-gray-100 text-gray-600'}">${u.status}</span></td><td class="p-4 text-right"><button class="user-action-btn p-1 rounded hover:bg-gray-100" data-id="${u.id}"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg></button></td></tr>`;
    }).join('') || '<tr><td colspan="8" class="p-8 text-center text-gray-500">No users found</td></tr>';
    document.querySelectorAll('.user-row-checkbox').forEach(cb => { cb.onchange = (e) => { const id = parseInt(e.target.value); if (e.target.checked) selectedUserIds.add(id); else selectedUserIds.delete(id); updateBulkBar(); }; });
    document.querySelectorAll('.user-action-btn').forEach(btn => { btn.addEventListener('click', (e) => { e.stopPropagation(); const user = staffData.find(s => s.id == btn.dataset.id); if (user) showActionMenu(btn, [
        { icon: '<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>', label: 'View Profile', action: 'view', callback: () => window.location.href = `staff-profile.html?id=${user.id}` },
        { icon: '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>', label: 'Quick Edit (Inline)', action: 'edit', callback: () => startInlineEdit(user.id) },
        { icon: '<path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/>', label: 'Change Role', action: 'role', callback: () => window.location.href = `role-users.html?id=${user.id}` },
        { divider: true },
        { icon: '<path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>', label: 'Delete', action: 'delete', cls: ' text-red', callback: () => openDeleteModal(user) },
    ]); }); });
}

function renderRoleTab() { renderRoleSummaryCards(); renderRoleAssignmentTable(); renderRecentRoleChanges(); initRoleFilters(); }
function renderRoleSummaryCards() { const counts = {}; roleAssignments.forEach(u => { u.roles.forEach(r => { counts[r] = (counts[r]||0)+1; }); }); const colors = { Administrator:'bg-indigo-100 text-indigo-700',Doctor:'bg-blue-100 text-blue-700',Nurse:'bg-green-100 text-green-700',Pharmacist:'bg-purple-100 text-purple-700','Lab Technician':'bg-cyan-100 text-cyan-700','Department Head':'bg-amber-100 text-amber-700',Accountant:'bg-pink-100 text-pink-700','HR Manager':'bg-teal-100 text-teal-700','Head Nurse':'bg-emerald-100 text-emerald-700',Staff:'bg-gray-100 text-gray-700'}; document.getElementById('roleSummaryCards').innerHTML = Object.entries(counts).slice(0,8).map(([r,c]) => `<div class="rounded-lg border bg-background p-3 text-center hover:shadow-md transition cursor-pointer" onclick="roleAssignmentFilter.search='${r.toLowerCase()}';renderRoleAssignmentTable();document.getElementById('roleAssignmentSearch').value='${r}';"><div class="text-xs text-gray-500">${r}</div><div class="text-xl font-bold ${colors[r]||'bg-gray-100 text-gray-700'} rounded-full px-2 py-0.5 mt-1 inline-block">${c}</div></div>`).join(''); }
function renderRoleAssignmentTable() { let f = [...roleAssignments]; const q = roleAssignmentFilter; if (q.search) { const s = q.search.toLowerCase(); f = f.filter(u => u.name.toLowerCase().includes(s)||u.email.toLowerCase().includes(s)||u.department.toLowerCase().includes(s)||u.roles.some(r=>r.toLowerCase().includes(s))); } if (q.dept!=='all') f = f.filter(u => u.department.toLowerCase()===q.dept.toLowerCase()); if (q.status!=='all') f = f.filter(u => u.status===q.status); f.sort((a,b)=>{let va=a[q.sort]||'',vb=b[q.sort]||'';if(Array.isArray(va))va=va.join(', ');if(Array.isArray(vb))vb=vb.join(', ');return q.sortDir==='asc'?String(va).localeCompare(String(vb)):String(vb).localeCompare(String(va));}); const t=f.length, tp=Math.ceil(t/q.perPage); if(q.page>tp) q.page=Math.max(1,tp); const s=(q.page-1)*q.perPage, p=f.slice(s,s+q.perPage); document.getElementById('roleAssignmentTableBody').innerHTML = p.map(u => `<tr class="border-b hover:bg-gray-50"><td class="p-3"><input type="checkbox" class="role-user-checkbox w-4 h-4 rounded border-gray-300" value="${u.id}" ${selectedRoleUsers.has(u.id)?'checked':''}></td><td class="p-3 font-medium">${u.name}<div class="text-xs text-gray-500 md:hidden">${u.department}</div></td><td class="p-3 hidden md:table-cell">${u.department}</td><td class="p-3"><div class="flex flex-wrap gap-1">${u.roles.map(r=>`<span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold bg-indigo-100 text-indigo-700">${r}</span>`).join('')}</div></td><td class="p-3 hidden md:table-cell text-xs">${u.assignedBy}</td><td class="p-3 hidden lg:table-cell text-xs">${u.lastUpdated}</td><td class="p-3"><button class="switch-root" data-state="${u.status==='Active'?'checked':'unchecked'}" onclick="toggleUserStatus(${u.id},this)"><span class="switch-thumb"></span></button></td><td class="p-3 text-right"><button class="role-user-action-btn p-1 rounded hover:bg-gray-100" data-id="${u.id}"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg></button></td></tr>`).join('')||'<tr><td colspan="8" class="p-8 text-center text-gray-500">No users found</td></tr>'; document.getElementById('rolePagination').innerHTML = t>q.perPage?`<div class="text-sm text-gray-500">Showing ${s+1}-${Math.min(s+q.perPage,t)} of ${t}</div><div class="flex gap-1"><button class="px-3 py-1 border rounded text-sm hover:bg-gray-100" onclick="roleAssignmentFilter.page--;renderRoleAssignmentTable();" ${q.page===1?'disabled':''}>Prev</button><span class="px-3 py-1 text-sm font-medium">${q.page}/${tp}</span><button class="px-3 py-1 border rounded text-sm hover:bg-gray-100" onclick="roleAssignmentFilter.page++;renderRoleAssignmentTable();" ${q.page>=tp?'disabled':''}>Next</button></div>`:''; document.querySelectorAll('.role-user-checkbox').forEach(cb=>{cb.onchange=(e)=>{if(e.target.checked)selectedRoleUsers.add(parseInt(e.target.value));else selectedRoleUsers.delete(parseInt(e.target.value));};}); document.querySelectorAll('.role-user-action-btn').forEach(btn=>{btn.addEventListener('click',(e)=>{e.stopPropagation();const u=roleAssignments.find(u=>u.id==btn.dataset.id);if(u)showActionMenu(btn,[{icon:'<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>',label:'Edit Roles',action:'edit',callback:()=>showAssignRoleModal(u)},{icon:'<path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>',label:'View Profile',action:'view',callback:()=>window.location.href=`staff-profile.html?id=${u.id}`},{divider:true},{icon:'<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="22" x2="16" y1="11" y2="11"/>',label:'Remove Role',action:'remove',cls:' text-red',callback:()=>{u.roles=['Staff'];renderRoleAssignmentTable();renderRoleSummaryCards();showToast('Roles removed from '+u.name);}}]);});}); }
function showAssignRoleModal(user) { const em = document.getElementById('assignRoleModal'); if (em) em.remove(); const allRoles = ['Super Admin','Administrator','Doctor','Nurse','Receptionist','Pharmacist','Lab Technician','Accountant','HR Manager','Department Head','Head Nurse','Staff']; const overlay = document.createElement('div'); overlay.id = 'assignRoleModal'; overlay.className = 'modal-overlay'; overlay.style.display = 'flex'; overlay.innerHTML = `<div class="modal-container" style="max-width:550px;"><div class="flex justify-between items-start mb-4 p-6 pb-0"><div><h3 class="text-lg font-semibold">Assign Roles</h3><p class="text-gray-500">${user.name} — ${user.department}</p></div><button id="closeAssignRoleModalBtn" class="text-gray-400 hover:text-gray-600"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg></button></div><div class="p-6 pt-2"><div class="space-y-3 mb-4">${allRoles.map(r => `<label class="flex items-center space-x-2 p-2 rounded-md hover:bg-muted cursor-pointer"><input type="checkbox" class="role-checkbox w-4 h-4 rounded border-gray-300 text-indigo-600" value="${r}" ${user.roles.includes(r)?'checked':''}> <span>${r}</span></label>`).join('')}</div><div class="border-t pt-3"><p class="text-xs font-medium text-gray-500 mb-2">Notes</p><textarea id="roleNotes" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm" rows="2" placeholder="Reason for assignment..."></textarea></div></div><div class="flex justify-end gap-2 p-6 pt-0"><button id="cancelAssignRoleBtn" class="px-4 py-2 border rounded-md text-sm hover:bg-gray-100">Cancel</button><button id="confirmAssignRoleBtn" class="px-4 py-2 bg-primary text-white rounded-md text-sm hover:bg-indigo-700">Save Roles</button></div></div>`; document.body.appendChild(overlay); document.body.style.overflow = 'hidden'; const close = () => { overlay.remove(); document.body.style.overflow = ''; }; overlay.addEventListener('click', (e) => { if (e.target === overlay) close(); }); overlay.querySelector('#closeAssignRoleModalBtn').addEventListener('click', close); overlay.querySelector('#cancelAssignRoleBtn').addEventListener('click', close); overlay.querySelector('#confirmAssignRoleBtn').addEventListener('click', () => { const checked = [...overlay.querySelectorAll('.role-checkbox:checked')].map(cb => cb.value); if (checked.length === 0) { showToast('Please select at least one role', true); return; } user.roles = checked; user.lastUpdated = new Date().toISOString().split('T')[0]; renderRoleAssignmentTable(); renderRoleSummaryCards(); close(); showToast(`Roles updated for ${user.name}`); }); }
function toggleUserStatus(userId, switchEl) { const user = roleAssignments.find(u => u.id === userId); if (user) { user.status = user.status === 'Active' ? 'Inactive' : 'Active'; switchEl.setAttribute('data-state', user.status === 'Active' ? 'checked' : 'unchecked'); showToast(`${user.name} ${user.status === 'Active' ? 'activated' : 'deactivated'}`); } }
function renderRecentRoleChanges() { document.getElementById('recentRoleChangesBody').innerHTML = recentRoleChanges.map(r => `<tr class="border-b hover:bg-gray-50"><td class="p-2 font-medium">${r.user}</td><td class="p-2"><span class="inline-flex rounded-full px-2 py-0.5 text-xs bg-gray-100 text-gray-700">${r.prevRole}</span></td><td class="p-2"><span class="inline-flex rounded-full px-2 py-0.5 text-xs bg-green-100 text-green-700">${r.newRole}</span></td><td class="p-2 text-xs">${r.changedBy}</td><td class="p-2 text-xs">${r.date}</td></tr>`).join(''); }
function initRoleFilters() { [{btn:'roleDeptFilterBtn',dropdown:'roleDeptFilterDropdown',text:'roleDeptFilterText',setter:'dept'},{btn:'roleStatusFilterBtn',dropdown:'roleStatusFilterDropdown',text:'roleStatusFilterText',setter:'status'}].forEach(f=>{const btn=document.getElementById(f.btn),dd=document.getElementById(f.dropdown),txt=document.getElementById(f.text);if(!btn)return;btn.addEventListener('click',(e)=>{e.stopPropagation();closeActionMenu();dd.classList.toggle('hidden');});dd.querySelectorAll('.select-item').forEach(i=>{i.addEventListener('click',()=>{txt.textContent=i.textContent;roleAssignmentFilter[f.setter]=i.dataset.value;roleAssignmentFilter.page=1;dd.classList.add('hidden');renderRoleAssignmentTable();});});document.addEventListener('click',(e)=>{if(!btn.contains(e.target)&&!dd.contains(e.target))dd.classList.add('hidden');});}); }

function renderAuditTable() { const search = document.getElementById('auditSearch')?.value?.toLowerCase() || ''; const filtered = auditLogs.filter(l => l.user.toLowerCase().includes(search) || l.action.toLowerCase().includes(search)); document.getElementById('auditTableBody').innerHTML = filtered.map(l => `<tr class="border-b hover:bg-gray-50"><td class="p-4 text-xs">${l.timestamp}</td><td class="p-4 font-medium">${l.user}</td><td class="p-4"><span class="inline-flex rounded-full px-2 py-0.5 text-xs font-semibold ${l.action==='Delete'?'bg-red-100 text-red-700':l.action==='Create'?'bg-green-100 text-green-700':l.action==='Update'?'bg-amber-100 text-amber-700':'bg-blue-100 text-blue-700'}">${l.action}</span></td><td class="p-4">${l.entity}</td><td class="p-4">${l.dept}</td><td class="p-4 text-xs">${l.ip}</td></tr>`).join('') || '<tr><td colspan="6" class="p-8 text-center text-gray-500">No audit logs found</td></tr>'; }

function renderDepartments() {
    const search = document.getElementById('deptSearchInput')?.value?.toLowerCase() || '';
    const filtered = departmentsData.filter(d => d.name.toLowerCase().includes(search) || d.head.toLowerCase().includes(search));
    document.getElementById('deptTableBody').innerHTML = filtered.map(d => `
        <tr class="border-b hover:bg-gray-50">
            <td class="p-4 font-medium">${d.icon} ${d.name}</td>
            <td class="p-4">${d.head}</td>
            <td class="p-4">${d.staff}</td>
            <td class="p-4">${d.services}</td>
            <td class="p-4"><span class="inline-flex px-2 py-0.5 rounded-full text-xs font-semibold ${d.status==='Active'?'bg-green-100 text-green-700':'bg-yellow-100 text-yellow-700'}">${d.status}</span></td>
            <td class="p-4 text-right"><button data-id="${d.id}" class="dept-action-trigger inline-flex items-center justify-center h-10 w-10 rounded-md hover:bg-gray-100"><svg class="h-4 w-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg></button></td>
        </tr>`).join('') || '<tr><td colspan="6" class="p-8 text-center text-gray-500">No departments found</td></tr>';
    
    document.querySelectorAll('.dept-action-trigger').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const dept = departmentsData.find(d => d.id == btn.dataset.id);
            if (dept) showActionMenu(btn, [
                { icon: '<path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/>', label: 'Edit Department', action: 'edit', callback: () => showToast('Editing ' + dept.name) },
                { icon: '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>', label: 'View Staff', action: 'staff', callback: () => showToast('Viewing staff for ' + dept.name) },
                { divider: true },
                { icon: '<path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>', label: 'Delete Department', action: 'delete', cls: ' text-red', callback: () => openDeleteModal(dept) },
            ]);
        });
    });
}

function updateStats() { document.getElementById('statUsers').textContent = staffData.length; document.getElementById('statRoles').textContent = 6; document.getElementById('qsTotal').textContent = staffData.length; document.getElementById('qsActive').textContent = staffData.filter(s => s.status === 'Active').length; document.getElementById('qsInactive').textContent = staffData.filter(s => s.status === 'Inactive').length; }

function initCharts() {
    if (charts.apiRequests) charts.apiRequests.destroy();
    if (document.querySelector("#apiRequestsChart")) charts.apiRequests = new ApexCharts(document.querySelector("#apiRequestsChart"), { series: [{ name: 'Requests', data: [12500,13800,14200,13500,14800,15200,14000] }], chart: { type: 'bar', height: 280, redrawOnWindowResize: true }, xaxis: { categories: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'] }, colors: ['#6366f1'], plotOptions: { bar: { borderRadius: 8 } } }).render();
    if (charts.errorRate) charts.errorRate.destroy();
    if (document.querySelector("#errorRateChart")) charts.errorRate = new ApexCharts(document.querySelector("#errorRateChart"), { series: [{ name: 'Errors', data: [12,8,15,5,10,7,9] }], chart: { type: 'line', height: 280, redrawOnWindowResize: true }, xaxis: { categories: ['00:00','04:00','08:00','12:00','16:00','20:00','Now'] }, colors: ['#ef4444'], stroke: { curve: 'smooth', width: 2 }, markers: { size: 4 } }).render();
}

// ==================== EMERGENCY CONTROLS ====================
function toggleEmergencyStop() { systemKillSwitchActive = !systemKillSwitchActive; const btn = document.getElementById('emergencyStopText'), stopBtn = document.getElementById('emergencyStopBtn'), killBtn = document.getElementById('killSwitchBtnText'), card = document.getElementById('killSwitchCard'), statusEl = document.getElementById('killSwitchStatus'), ms = document.getElementById('maintenanceSwitch'); if (systemKillSwitchActive) { btn.textContent = '✓ SYSTEM LOCKED'; stopBtn.classList.add('bg-gray-800','hover:bg-gray-900'); stopBtn.classList.remove('bg-red-600','hover:bg-red-700'); if(killBtn) killBtn.textContent = 'DEACTIVATE KILL SWITCH'; if(card) card.classList.add('locked'); if(statusEl) statusEl.innerHTML = '<span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span> SYSTEM LOCKED DOWN'; if(ms) ms.setAttribute('data-state','checked'); document.getElementById('killSwitchBanner').style.display='flex'; document.getElementById('maintenanceBanner').style.display='none'; showToast('🚨 EMERGENCY STOP ACTIVATED — All users locked out', true); } else { btn.textContent = 'EMERGENCY STOP'; stopBtn.classList.add('bg-red-600','hover:bg-red-700'); stopBtn.classList.remove('bg-gray-800','hover:bg-gray-900'); if(killBtn) killBtn.textContent = 'ACTIVATE KILL SWITCH'; if(card) card.classList.remove('locked'); if(statusEl) statusEl.innerHTML = '<span class="w-2 h-2 rounded-full bg-green-500"></span> System is running normally'; if(ms) ms.setAttribute('data-state','unchecked'); document.getElementById('killSwitchBanner').style.display='none'; document.getElementById('maintenanceBanner').style.display='none'; showToast('✅ System restored to normal operation'); } }
function toggleKillSwitch() { systemKillSwitchActive = !systemKillSwitchActive; const btn = document.getElementById('killSwitchBtnText'), statusEl = document.getElementById('killSwitchStatus'), card = document.getElementById('killSwitchCard'), stopText = document.getElementById('emergencyStopText'), stopBtn = document.getElementById('emergencyStopBtn'); if (systemKillSwitchActive) { if(btn) btn.textContent = 'DEACTIVATE KILL SWITCH'; if(statusEl) statusEl.innerHTML = '<span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span> SYSTEM LOCKED DOWN'; if(card) card.classList.add('locked'); if(stopText) stopText.textContent = '✓ SYSTEM LOCKED'; if(stopBtn) { stopBtn.classList.add('bg-gray-800','hover:bg-gray-900'); stopBtn.classList.remove('bg-red-600','hover:bg-red-700'); } document.getElementById('killSwitchBanner').style.display='flex'; document.getElementById('maintenanceBanner').style.display='none'; document.getElementById('maintenanceSwitch')?.setAttribute('data-state','checked'); showToast('🔒 KILL SWITCH ACTIVATED', true); } else { if(btn) btn.textContent = 'ACTIVATE KILL SWITCH'; if(statusEl) statusEl.innerHTML = '<span class="w-2 h-2 rounded-full bg-green-500"></span> System is running normally'; if(card) card.classList.remove('locked'); if(stopText) stopText.textContent = 'EMERGENCY STOP'; if(stopBtn) { stopBtn.classList.add('bg-red-600','hover:bg-red-700'); stopBtn.classList.remove('bg-gray-800','hover:bg-gray-900'); } document.getElementById('killSwitchBanner').style.display='none'; document.getElementById('maintenanceBanner').style.display='none'; document.getElementById('maintenanceSwitch')?.setAttribute('data-state','unchecked'); showToast('✅ Kill switch deactivated'); } }
function toggleMaintenanceMode() { systemKillSwitchActive = false; document.getElementById('maintenanceBanner').style.display='none'; document.getElementById('killSwitchBanner').style.display='none'; document.getElementById('maintenanceSwitch')?.setAttribute('data-state','unchecked'); const st=document.getElementById('emergencyStopText'),sb=document.getElementById('emergencyStopBtn'); if(st) st.textContent='EMERGENCY STOP'; if(sb){sb.classList.add('bg-red-600','hover:bg-red-700');sb.classList.remove('bg-gray-800','hover:bg-gray-900');} const kb=document.getElementById('killSwitchBtnText'); if(kb)kb.textContent='ACTIVATE KILL SWITCH'; const se=document.getElementById('killSwitchStatus'); if(se)se.innerHTML='<span class="w-2 h-2 rounded-full bg-green-500"></span> System is running normally'; const c=document.getElementById('killSwitchCard'); if(c)c.classList.remove('locked'); showToast('✅ Maintenance mode disabled'); }
function restartServices() { const btn = document.getElementById('restartServicesBtn'), orig = btn.innerHTML; btn.innerHTML = '<svg class="animate-spin h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg> Restarting...'; btn.disabled = true; showToast('🔄 Restarting all system services...'); setTimeout(() => { btn.innerHTML = orig; btn.disabled = false; showToast('✅ All services restarted successfully'); }, 3000); }

setInterval(() => { const cpuEl = document.getElementById('cpuUsage'); if (cpuEl && document.getElementById('tab-system')?.getAttribute('data-state') === 'active') { const cpu = (32 + Math.random() * 6).toFixed(1); cpuEl.textContent = cpu + '%'; cpuEl.parentElement.querySelector('.bg-blue-500').style.width = cpu + '%'; const mem = (60 + Math.random() * 5).toFixed(1); const memEl = document.getElementById('memUsage'); if (memEl) { memEl.textContent = mem + '%'; memEl.parentElement.querySelector('.bg-amber-500').style.width = mem + '%'; } const sessions = 240 + Math.floor(Math.random() * 15); const sessEl = document.getElementById('activeSessions'); if (sessEl) sessEl.textContent = sessions; } }, 5000);

function activateTab(tabId) { ['users','roles','audit','departments','system'].forEach(t => { const p = document.getElementById(`tab-${t}`), b = document.querySelector(`.tab-btn[data-tab="${t}"]`); if(p) p.setAttribute('data-state', t===tabId?'active':'inactive'); if(b) { if(t===tabId) b.classList.add('active'); else b.classList.remove('active'); } }); if (tabId === 'roles') renderRoleTab(); if (tabId === 'departments') renderDepartments(); if (tabId === 'system') setTimeout(() => initCharts(), 150); }
document.querySelectorAll('.tab-btn').forEach(b => b.addEventListener('click', () => activateTab(b.dataset.tab)));

document.addEventListener('keydown', (e) => { if (e.key === 'Escape') { closeActionMenu(); closeAssignModal(); closeAddDeptModal(); closeDeleteModal(); } if ((e.ctrlKey||e.metaKey) && e.key === 'k') { e.preventDefault(); document.getElementById('searchInput')?.focus(); } if ((e.ctrlKey||e.metaKey) && e.key === 'n') { e.preventDefault(); openAssignModal(); } if ((e.ctrlKey||e.metaKey) && e.key >= '1' && e.key <= '5') { e.preventDefault(); const tabs = ['users','roles','audit','departments','system']; activateTab(tabs[parseInt(e.key)-1]); } });

document.getElementById('searchInput')?.addEventListener('input', renderUsersTable);
document.getElementById('deptSearchInput')?.addEventListener('input', renderDepartments);
document.getElementById('auditSearch')?.addEventListener('input', renderAuditTable);
document.getElementById('assignUserBtn')?.addEventListener('click', openAssignModal);
document.getElementById('closeAssignModalBtn')?.addEventListener('click', closeAssignModal);
document.getElementById('cancelAssignBtn')?.addEventListener('click', closeAssignModal);
document.getElementById('confirmAssignBtn')?.addEventListener('click', confirmAssign);
document.getElementById('assignSearchInput')?.addEventListener('input', (e) => { const q = e.target.value.toLowerCase(); document.querySelectorAll('#staffChecklist label').forEach(l => l.style.display = l.textContent.toLowerCase().includes(q) ? 'flex' : 'none'); });
document.getElementById('assignModal')?.addEventListener('click', function(e) { if (e.target === this) closeAssignModal(); });
document.getElementById('addDeptBtn')?.addEventListener('click', openAddDeptModal);
document.getElementById('closeAddDeptModalBtn')?.addEventListener('click', closeAddDeptModal);
document.getElementById('cancelAddDeptBtn')?.addEventListener('click', closeAddDeptModal);
document.getElementById('confirmAddDeptBtn')?.addEventListener('click', confirmAddDept);
document.getElementById('addDeptModal')?.addEventListener('click', function(e) { if (e.target === this) closeAddDeptModal(); });
document.getElementById('cancelDeleteBtn')?.addEventListener('click', closeDeleteModal);
document.getElementById('confirmDeleteBtn')?.addEventListener('click', confirmDelete);
document.getElementById('deleteModal')?.addEventListener('click', function(e) { if (e.target === this) closeDeleteModal(); });
document.getElementById('selectAllUsers')?.addEventListener('change', (e) => { document.querySelectorAll('.user-row-checkbox').forEach(cb => { cb.checked = e.target.checked; if (e.target.checked) selectedUserIds.add(parseInt(cb.value)); else selectedUserIds.delete(parseInt(cb.value)); }); updateBulkBar(); });
document.getElementById('refreshBtn')?.addEventListener('click', () => { renderUsersTable(); renderAuditTable(); updateStats(); showToast('Data refreshed'); });
document.getElementById('exportBtn')?.addEventListener('click', () => showToast('Export complete'));
document.getElementById('exportUsersBtn')?.addEventListener('click', () => showToast('Users exported'));
document.getElementById('exportAuditBtn')?.addEventListener('click', () => showToast('Audit logs exported'));
document.getElementById('upgradeBtn')?.addEventListener('click', () => showToast('Upgrade feature coming soon'));
document.getElementById('roleAssignmentSearch')?.addEventListener('input', (e) => { roleAssignmentFilter.search = e.target.value; roleAssignmentFilter.page = 1; renderRoleAssignmentTable(); });
document.getElementById('assignNewRoleBtn')?.addEventListener('click', () => showToast('Select a user and use the action menu to assign roles'));
document.getElementById('exportRolesBtn')?.addEventListener('click', () => showToast('Role assignments exported'));
document.getElementById('selectAllRoles')?.addEventListener('change', (e) => { document.querySelectorAll('.role-user-checkbox').forEach(cb => { cb.checked = e.target.checked; if (e.target.checked) selectedRoleUsers.add(parseInt(cb.value)); else selectedRoleUsers.delete(parseInt(cb.value)); }); });
document.querySelectorAll('#tab-roles thead th[data-sort]').forEach(th => { th.addEventListener('click', () => { const sort = th.dataset.sort; if (roleAssignmentFilter.sort === sort) roleAssignmentFilter.sortDir = roleAssignmentFilter.sortDir === 'asc' ? 'desc' : 'asc'; else { roleAssignmentFilter.sort = sort; roleAssignmentFilter.sortDir = 'asc'; } renderRoleAssignmentTable(); }); });
document.querySelectorAll('.switch-root').forEach(sw => { sw.addEventListener('click', () => { const cur = sw.getAttribute('data-state'); sw.setAttribute('data-state', cur === 'checked' ? 'unchecked' : 'checked'); showToast('Setting updated'); }); });
document.getElementById('maintenanceSwitch')?.addEventListener('click', function() { setTimeout(() => { if (this.getAttribute('data-state') === 'checked') { document.getElementById('maintenanceBanner').style.display = 'flex'; showToast('⚠️ Maintenance mode enabled'); } else { document.getElementById('maintenanceBanner').style.display = 'none'; showToast('✅ Maintenance mode disabled'); } }, 100); });

function refreshAllCharts() { setTimeout(() => { window.dispatchEvent(new Event('resize')); }, 350); }
document.querySelector('.lucide-menu')?.closest('button')?.addEventListener('click', refreshAllCharts);
document.getElementById('profileBtn')?.addEventListener('click', (e) => { e.stopPropagation(); document.getElementById('profileDropdown')?.classList.toggle('hidden'); });
document.addEventListener('click', () => document.getElementById('profileDropdown')?.classList.add('hidden'));

renderUsersTable(); renderAuditTable(); updateStats(); activateTab('users');
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
    <script src="js/meditrack-apex-data.js"></script>
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
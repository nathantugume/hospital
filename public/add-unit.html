<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Add Blood Unit</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <style>

        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .rounded-lg.border { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted { background-color: #262626 !important; }
        body.dark .border-gray-200 { border-color: #333 !important; }
        body.dark .border-gray-300 { border-color: #404040 !important; }
        body.dark .bg-gray-50 { background-color: #0f0f0f !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        body.dark ::-webkit-scrollbar-track { background: #2a2a2a; }
        body.dark ::-webkit-scrollbar-thumb { background: #555; }
        
        .custom-select { position: relative; }
        .select-trigger { display: flex; align-items: center; justify-content: space-between; width: 100%; height: 40px; border-radius: 0.375rem; border: 1px solid #d1d5db; background-color: white; padding: 0 0.75rem; font-size: 0.875rem; cursor: pointer; transition: all 0.1s; }
        body.dark .select-trigger { background-color: #131212; border-color: #404040; color: #e5e5e5; }
        .select-trigger:hover { border-color: #9ca3af; }
        .select-dropdown { position: absolute; top: 100%; left: 0; right: 0; z-index: 50; background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); margin-top: 4px; max-height: 200px; overflow-y: auto; animation: fadeIn 0.15s ease-out; }
        body.dark .select-dropdown { background: #2a2a2a; border-color: #404040; }
        .select-item { padding: 0.5rem 0.75rem; cursor: pointer; font-size: 0.875rem; transition: background 0.1s; }
        .select-item:hover { background-color: #f3f4f6; }
        body.dark .select-item:hover { background-color: #3f3f46; }
        
        .date-picker-dropdown { position: fixed; z-index: 100; background: white; border-radius: 0.5rem; border: 1px solid #e5e7eb; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); padding: 1rem; min-width: 280px; animation: fadeIn 0.15s ease-out; }
        body.dark .date-picker-dropdown { background: #2a2a2a; border-color: #404040; }
        .date-nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
        .date-nav button { padding: 0.25rem 0.5rem; border-radius: 0.25rem; cursor: pointer; transition: background 0.1s; }
        .date-nav button:hover { background-color: #f3f4f6; }
        body.dark .date-nav button:hover { background-color: #3f3f46; }
        .date-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; text-align: center; font-size: 0.875rem; }
        .date-cell { padding: 0.5rem; cursor: pointer; border-radius: 0.25rem; transition: background 0.1s; }
        .date-cell:hover { background-color: #f3f4f6; }
        body.dark .date-cell:hover { background-color: #3f3f46; }
        .date-cell.selected { background-color: #6366f1; color: white; }
        .date-header { font-weight: 500; color: #6b7280; margin-bottom: 0.5rem; }
        
        input[type="checkbox"] { accent-color: #6366f1; cursor: pointer; width: 1rem; height: 1rem; }
        input, textarea { transition: all 0.1s; }
        input:focus, textarea:focus { outline: none; border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.1); }
        
        .toast-message { position: fixed; bottom: 20px; right: 20px; background: #10b981; color: white; padding: 12px 20px; border-radius: 8px; z-index: 1000; animation: slideIn 0.3s ease-out; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-size: 0.875rem; }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-4px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    <!-- Sticky Header -->
    <header class="sticky top-0 z-40 border-b bg-background duration-300 xl:ml-64 shadow-sm border-gray-200">
        <div class="flex h-16 items-center justify-between px-4 md:px-6">
            <button id="sidebarCollapseBtn" class="xl:hidden focus:outline-none">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="18" y2="18"></line></svg>
            </button>
            <div class="ml-auto flex items-center gap-4">
                <button id="themeToggleBtn" class="hover:bg-gray-100 size-10 rounded-md">
                    <svg id="moonIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path></svg>
                    <svg id="sunIcon" class="hidden" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path></svg>
                </button>
                <div class="relative">
                    <button id="profileBtn" class="h-8 w-8 rounded-full hover:ring-2">
                        <img src="user.png" class="h-8 w-8 rounded-full object-cover" alt="User profile photo">
                    </button>
                    <div id="profileDropdown" class="hidden absolute right-0 mt-2 z-50 w-56 rounded-md border bg-background shadow-lg p-1">
                        <div class="px-2 py-1.5 border-b"><p class="font-medium text-sm">Dr. Nakato Sarah</p><p class="text-xs text-gray-500">admin@hospital.ug</p></div>
                        <a href="profile-setting.html" class="flex items-center gap-2 px-2 py-1.5 text-sm hover:bg-gray-100 rounded">Profile</a>
                        <a href="#" class="flex items-center gap-2 px-2 py-1.5 text-sm text-red-600">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="flex flex-1 items-start relative">
        <!-- Sidebar -->
        <aside class="!fixed h-full left-0 bottom-0 z-40 flex w-64 flex-col border-r bg-background transition-transform duration-300 ease-in-out translate-x-0 shadow-lg">
            <div class="flex py-3 xl:py-3.5 items-center justify-between px-4 border-b border-gray-200">
                <a class="flex items-center space-x-2" href="index.html">
                    <img alt="Meditrack" loading="lazy" width="36" height="36" src="logo.png" style="color: transparent;">
                    <span class="font-bold inline-block">Medi-track</span>
                </a>
                <button class="xl:hidden">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                </button>
            </div>
            <div class="flex-1 py-2 border-t border-gray-200 h-full overflow-y-auto custom-scrollbar">
                <nav class="space-y-1 px-2">
                    <div class="space-y-1 custom-scrollbar">
                        <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100" href="blood-stock.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4"><path d="M12 2v20M2 12h20"/></svg>
                            Blood Stock
                        </a>
                    </div>
                    <div class="space-y-1 custom-scrollbar">
                        <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors bg-indigo-50 text-indigo-700" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            Add Blood Unit
                        </a>
                    </div>
                    <div class="space-y-1 custom-scrollbar">
                        <a class="flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-700 hover:bg-gray-100" href="blood-donors.html">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2 h-4 w-4"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Blood Donors
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

        <!-- Main Content -->
        <main class="flex-1 overflow-auto p-4 xl:p-6 xl:ml-64 w-full">
            <div class="flex flex-col gap-5">
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="blood-stock.html" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background size-10 hover:bg-accent hover:text-accent-foreground">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                    </a>
                    <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Add Blood Unit</h1>
                </div>
                <p class="text-gray-500 -mt-2">Add a new blood unit to the blood bank inventory</p>
                
                <div class="rounded-lg border bg-background shadow-sm">
                    <div class="p-4 border-b">
                        <h2 class="text-xl font-semibold">Blood Unit Information</h2>
                        <p class="text-gray-500">Enter the details of the new blood unit to be added to the inventory.</p>
                    </div>
                    <div class="p-4">
                        <form id="addBloodForm" class="space-y-8">
                            <div class="grid gap-6 md:grid-cols-2">
                                <!-- Left Column -->
                                <div class="space-y-6">
                                    <label class="flex items-center gap-2 cursor-pointer">
                                        <input type="checkbox" id="anonymousDonor" class="w-4 h-4">
                                        <span class="text-sm font-medium">Anonymous Donor</span>
                                    </label>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium">Donor ID</label>
                                        <input id="donorId" type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter donor ID">
                                        <p class="text-xs text-gray-500">Enter the unique ID of the donor.</p>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium">Donor Name</label>
                                        <input id="donorName" type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter donor name">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium">Blood Group <span class="text-red-500">*</span></label>
                                        <div class="custom-select">
                                            <button id="bloodGroupBtn" type="button" class="select-trigger">
                                                <span>Select blood group</span>
                                                <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                            </button>
                                            <div id="bloodGroupDropdown" class="select-dropdown hidden"></div>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium">Quantity (units)</label>
                                        <input id="quantity" type="number" min="1" value="1" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <p class="text-xs text-gray-500">Standard unit is 450ml of whole blood.</p>
                                    </div>
                                </div>
                                
                                <!-- Right Column -->
                                <div class="space-y-6">
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium">Collection Date <span class="text-red-500">*</span></label>
                                        <button id="collectionDateBtn" type="button" class="select-trigger justify-start gap-2">
                                            <svg class="h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M8 2v4"/><path d="M16 2v4"/><path d="M3 10h18"/></svg>
                                            <span>Pick a date</span>
                                        </button>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium">Expiry Date <span class="text-red-500">*</span></label>
                                        <button id="expiryDateBtn" type="button" class="select-trigger justify-start gap-2">
                                            <svg class="h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M8 2v4"/><path d="M16 2v4"/><path d="M3 10h18"/></svg>
                                            <span>Pick a date</span>
                                        </button>
                                        <p class="text-xs text-gray-500">Typically 35-42 days after collection for whole blood.</p>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium">Source Type <span class="text-red-500">*</span></label>
                                        <div class="custom-select">
                                            <button id="sourceTypeBtn" type="button" class="select-trigger">
                                                <span>Select source type</span>
                                                <svg class="h-4 w-4 opacity-50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>
                                            </button>
                                            <div id="sourceTypeDropdown" class="select-dropdown hidden"></div>
                                        </div>
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium">Collection Location</label>
                                        <input id="collectionLocation" type="text" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter collection location">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t"></div>
                            
                            <div class="space-y-6">
                                <div class="grid gap-6 md:grid-cols-2">
                                    <label class="flex items-start gap-3 p-4 border rounded-md cursor-pointer hover:bg-accent transition-colors">
                                        <input type="checkbox" id="screeningComplete" class="w-4 h-4 mt-0.5">
                                        <div>
                                            <span class="text-sm font-medium">Screening Complete</span>
                                            <p class="text-xs text-gray-500">Blood has been screened for infectious diseases.</p>
                                        </div>
                                    </label>
                                    <label class="flex items-start gap-3 p-4 border rounded-md cursor-pointer hover:bg-accent transition-colors">
                                        <input type="checkbox" id="processingComplete" class="w-4 h-4 mt-0.5">
                                        <div>
                                            <span class="text-sm font-medium">Processing Complete</span>
                                            <p class="text-xs text-gray-500">Blood has been processed and is ready for storage.</p>
                                        </div>
                                    </label>
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-medium">Additional Notes</label>
                                    <textarea id="notes" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm resize-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter any additional information about this blood unit"></textarea>
                                </div>
                            </div>
                            
                            <div class="flex justify-end gap-3">
                                <a href="blood-stock.html" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background px-4 py-2 text-sm font-medium text-gray-700 hover:bg-accent transition-colors">Cancel</a>
                                <button type="submit" class="bg-primary inline-flex items-center text-white justify-center rounded-md px-4 py-2 text-sm font-medium transition-colors hover:bg-primary/90">Add Blood Unit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
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
    // === SIDEBAR TOGGLE ===
    const menuBtn = document.querySelector('header button:first-child');
    const sidebar = document.querySelector('aside');
    const closeSidebarBtn = document.querySelector('aside .xl\\:hidden');
    const headerLogo = document.getElementById('headerLogo');

    function isMobileView() { return window.innerWidth < 1280; }
    function openSidebar() {
        if (sidebar) {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            localStorage.setItem('sidebarOpen', 'true');
            if (isMobileView()) { document.body.classList.add('sidebar-open'); document.body.style.overflow = 'hidden'; }
            updateHeaderAndMain();
        }
    }
    function closeSidebar() {
        if (sidebar) {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            localStorage.setItem('sidebarOpen', 'false');
            if (isMobileView()) { document.body.classList.remove('sidebar-open'); document.body.style.overflow = ''; }
            updateHeaderAndMain();
        }
    }
    function toggleSidebar() {
        if (!sidebar) return;
        sidebar.classList.contains('-translate-x-full') ? openSidebar() : closeSidebar();
    }
    function updateHeaderAndMain() {
        const header = document.querySelector('header');
        const main = document.querySelector('main');
        if (!header || !main) return;
        if (window.innerWidth >= 1280) {
            if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
                header.style.width = 'calc(100% - 16rem)'; header.style.marginLeft = '16rem';
                main.style.marginLeft = '16rem'; main.style.width = 'calc(100% - 16rem)';
                if (headerLogo) headerLogo.style.display = 'none';
            } else {
                header.style.width = '100%'; header.style.marginLeft = '0';
                main.style.marginLeft = '0'; main.style.width = '100%';
                if (headerLogo) headerLogo.style.display = 'flex';
            }
        } else {
            header.style.width = '100%'; header.style.marginLeft = '0';
            main.style.marginLeft = '0'; main.style.width = '100%';
            if (sidebar && !sidebar.classList.contains('-translate-x-full')) { if (headerLogo) headerLogo.style.display = 'none'; }
            else { if (headerLogo) headerLogo.style.display = 'flex'; }
        }
    }
    function setupSidebar() {
        if (!sidebar) return;
        const isMobile = isMobileView();
        const savedState = localStorage.getItem('sidebarOpen');
        document.body.style.overflow = ''; document.body.classList.remove('sidebar-open');
        if (isMobile) { closeSidebar(); }
        else { savedState === 'false' ? closeSidebar() : openSidebar(); }
        updateHeaderAndMain();
    }
    if (menuBtn) { const nmb = menuBtn.cloneNode(true); menuBtn.parentNode.replaceChild(nmb, menuBtn); nmb.addEventListener('click', (e) => { e.stopPropagation(); toggleSidebar(); }); }
    if (closeSidebarBtn) { const ncb = closeSidebarBtn.cloneNode(true); closeSidebarBtn.parentNode.replaceChild(ncb, closeSidebarBtn); ncb.addEventListener('click', (e) => { e.stopPropagation(); closeSidebar(); }); }
    let resizeTimer;
    window.addEventListener('resize', () => { clearTimeout(resizeTimer); resizeTimer = setTimeout(setupSidebar, 150); });
    document.addEventListener('click', (e) => { if (isMobileView() && sidebar && !sidebar.classList.contains('-translate-x-full') && !sidebar.contains(e.target) && !menuBtn?.contains(e.target)) closeSidebar(); });
    setupSidebar();
    const mainEl = document.querySelector('main'); if (mainEl) mainEl.classList.remove('xl:ml-64');
    const headerDiv = document.querySelector('header > div'); if (headerDiv) headerDiv.style.width = '100%';
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && sidebar && !sidebar.classList.contains('-translate-x-full')) closeSidebar(); });

    // === PERSISTENT THEME TOGGLE ===
    (function() {
        const sunIcon = document.getElementById('sunIcon');
        const moonIcon = document.getElementById('moonIcon');
        const themeToggleBtn = document.getElementById('themeToggleBtn');
        function applyTheme(isDark) {
            if (isDark) { document.body.classList.add('dark'); sunIcon?.classList.remove('hidden'); moonIcon?.classList.add('hidden'); localStorage.setItem('theme', 'dark'); }
            else { document.body.classList.remove('dark'); sunIcon?.classList.add('hidden'); moonIcon?.classList.remove('hidden'); localStorage.setItem('theme', 'light'); }
        }
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') applyTheme(true);
        else if (savedTheme === 'light') applyTheme(false);
        else applyTheme(window.matchMedia('(prefers-color-scheme: dark)').matches);
        themeToggleBtn?.addEventListener('click', () => applyTheme(!document.body.classList.contains('dark')));
    })();

    // === PROFILE DROPDOWN ===
    document.getElementById('profileBtn')?.addEventListener('click', (e) => { e.stopPropagation(); document.getElementById('profileDropdown')?.classList.toggle('hidden'); });
    document.addEventListener('click', (e) => { if (!document.getElementById('profileBtn')?.contains(e.target)) document.getElementById('profileDropdown')?.classList.add('hidden'); });

    // === SIDEBAR MOBILE TOGGLE ===
    document.getElementById('sidebarCollapseBtn')?.addEventListener('click', () => { sidebar?.classList.toggle('-translate-x-full'); });
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1280) sidebar?.classList.remove('-translate-x-full');
        else sidebar?.classList.add('-translate-x-full');
    });

    // === FORM DATA STATE ===
    let anonymousDonor = false, donorId = '', donorName = '', selectedBloodGroup = '', quantity = 1;
    let collectionDate = '', expiryDate = '', selectedSourceType = '', collectionLocation = '';
    let screeningComplete = false, processingComplete = false, notes = '';
    const bloodGroups = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
    const sourceTypes = ['Donation', 'Purchase', 'Transfer from another facility'];
    let activeDatePicker = null;

    // === TOAST ===
    function showToast(message, isError = false) {
        const existing = document.querySelector('.toast-message'); if (existing) existing.remove();
        const toast = document.createElement('div'); toast.className = `toast-message ${isError ? 'error' : ''}`; toast.textContent = message;
        document.body.appendChild(toast); setTimeout(() => toast.remove(), 3000);
    }

    // === DATE PICKER ===
    function closeDatePicker() { if (activeDatePicker) { activeDatePicker.remove(); activeDatePicker = null; } }
    function formatDateShort(date) { if (!date) return ''; const d = new Date(date); return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' }); }
    function createDatePicker(targetId, currentValue, onSelect) {
        closeDatePicker();
        const target = document.getElementById(targetId); if (!target) return;
        const rect = target.getBoundingClientRect();
        const now = new Date();
        const currentDate = currentValue ? new Date(currentValue) : now;
        let cy = currentDate.getFullYear(), cm = currentDate.getMonth();
        const mn = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        const wd = ['Su','Mo','Tu','We','Th','Fr','Sa'];
        function updateCal(p) {
            const fd = new Date(cy, cm, 1), ld = new Date(cy, cm+1, 0), sw = fd.getDay();
            const days = []; for (let i=0;i<sw;i++) days.push(null); for (let i=1;i<=ld.getDate();i++) days.push(i);
            p.querySelector('.days-grid').innerHTML = days.map(d => d ? `<div class="date-cell" data-day="${d}">${d}</div>` : '<div></div>').join('');
            p.querySelector('.month-year').textContent = `${mn[cm]} ${cy}`;
            p.querySelectorAll('.date-cell').forEach(cell => { if(cell.dataset.day) cell.addEventListener('click', () => { onSelect(new Date(cy, cm, parseInt(cell.dataset.day))); closeDatePicker(); }); });
        }
        const picker = document.createElement('div'); picker.className = 'date-picker-dropdown';
        picker.style.cssText = `position:fixed;top:${rect.bottom+window.scrollY+4}px;left:${rect.left+window.scrollX}px;`;
        picker.innerHTML = `<div class="date-nav"><button class="prev-month">←</button><span class="month-year font-medium"></span><button class="next-month">→</button></div><div class="date-grid date-header">${wd.map(d=>`<div>${d}</div>`).join('')}</div><div class="date-grid days-grid"></div>`;
        document.body.appendChild(picker); activeDatePicker = picker; updateCal(picker);
        picker.querySelector('.prev-month').addEventListener('click', (e)=>{e.stopPropagation();cm--;if(cm<0){cm=11;cy--;}updateCal(picker);});
        picker.querySelector('.next-month').addEventListener('click', (e)=>{e.stopPropagation();cm++;if(cm>11){cm=0;cy++;}updateCal(picker);});
        setTimeout(()=>{const h=(e)=>{if(!picker.contains(e.target)&&e.target!==target){closeDatePicker();document.removeEventListener('click',h);}};document.addEventListener('click',h);},10);
    }

    // === CUSTOM SELECT ===
    function closeAllDropdowns() { document.querySelectorAll('.select-dropdown').forEach(dd => dd.classList.add('hidden')); }
    function initSelect(triggerId, dropdownId, options, onSelect) {
        const trigger = document.getElementById(triggerId), dropdown = document.getElementById(dropdownId);
        if (!trigger || !dropdown) return;
        trigger.addEventListener('click', (e) => { e.stopPropagation(); closeAllDropdowns(); dropdown.classList.toggle('hidden'); });
        dropdown.innerHTML = options.map(opt => `<div class="select-item" data-value="${opt}">${opt}</div>`).join('');
        dropdown.querySelectorAll('.select-item').forEach(item => item.addEventListener('click', () => {
            onSelect(item.dataset.value); trigger.querySelector('span').textContent = item.dataset.value; dropdown.classList.add('hidden');
        }));
    }

    // === INITIALIZE SELECTS ===
    initSelect('bloodGroupBtn', 'bloodGroupDropdown', bloodGroups, (val) => { selectedBloodGroup = val; });
    initSelect('sourceTypeBtn', 'sourceTypeDropdown', sourceTypes, (val) => { selectedSourceType = val; });

    // === DATE PICKER BINDINGS ===
    document.getElementById('collectionDateBtn')?.addEventListener('click', (e) => {
        e.stopPropagation(); closeAllDropdowns();
        createDatePicker('collectionDateBtn', collectionDate, (date) => {
            collectionDate = date.toISOString().split('T')[0];
            document.querySelector('#collectionDateBtn span').textContent = formatDateShort(collectionDate);
        });
    });
    document.getElementById('expiryDateBtn')?.addEventListener('click', (e) => {
        e.stopPropagation(); closeAllDropdowns();
        createDatePicker('expiryDateBtn', expiryDate, (date) => {
            expiryDate = date.toISOString().split('T')[0];
            document.querySelector('#expiryDateBtn span').textContent = formatDateShort(expiryDate);
        });
    });

    // === CHECKBOXES & INPUTS ===
    document.getElementById('anonymousDonor')?.addEventListener('change', (e) => { anonymousDonor = e.target.checked; });
    document.getElementById('donorId')?.addEventListener('input', (e) => { donorId = e.target.value; });
    document.getElementById('donorName')?.addEventListener('input', (e) => { donorName = e.target.value; });
    document.getElementById('quantity')?.addEventListener('change', (e) => { quantity = parseInt(e.target.value) || 1; });
    document.getElementById('collectionLocation')?.addEventListener('input', (e) => { collectionLocation = e.target.value; });
    document.getElementById('screeningComplete')?.addEventListener('change', (e) => { screeningComplete = e.target.checked; });
    document.getElementById('processingComplete')?.addEventListener('change', (e) => { processingComplete = e.target.checked; });
    document.getElementById('notes')?.addEventListener('input', (e) => { notes = e.target.value; });

    // === FORM SUBMISSION ===
    document.getElementById('addBloodForm')?.addEventListener('submit', (e) => {
        e.preventDefault();
        if (!selectedBloodGroup) { showToast('Please select blood group', true); return; }
        if (!collectionDate) { showToast('Please select collection date', true); return; }
        if (!expiryDate) { showToast('Please select expiry date', true); return; }
        if (!selectedSourceType) { showToast('Please select source type', true); return; }
        const donorDisplay = anonymousDonor ? 'Anonymous' : (donorName || donorId || 'Not specified');
        showToast(`Blood unit added successfully!\nBlood Group: ${selectedBloodGroup}\nQuantity: ${quantity} unit(s)\nDonor: ${donorDisplay}`);
        setTimeout(() => {
            anonymousDonor = false; donorId = ''; donorName = ''; selectedBloodGroup = ''; quantity = 1;
            collectionDate = ''; expiryDate = ''; selectedSourceType = ''; collectionLocation = '';
            screeningComplete = false; processingComplete = false; notes = '';
            document.getElementById('anonymousDonor').checked = false;
            document.getElementById('donorId').value = '';
            document.getElementById('donorName').value = '';
            document.querySelector('#bloodGroupBtn span').textContent = 'Select blood group';
            document.getElementById('quantity').value = '1';
            document.querySelector('#collectionDateBtn span').textContent = 'Pick a date';
            document.querySelector('#expiryDateBtn span').textContent = 'Pick a date';
            document.querySelector('#sourceTypeBtn span').textContent = 'Select source type';
            document.getElementById('collectionLocation').value = '';
            document.getElementById('screeningComplete').checked = false;
            document.getElementById('processingComplete').checked = false;
            document.getElementById('notes').value = '';
        }, 1500);
    });

    // === CLOSE DROPDOWNS ON OUTSIDE CLICK ===
    document.addEventListener('click', (e) => { if (!e.target.closest('.custom-select')) closeAllDropdowns(); });
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
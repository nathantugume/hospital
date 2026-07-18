<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Medi-track | Staff Attendance</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    
    </script>    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; color: #1f2937; }
        body.dark { background-color: #131212; color: #e5e5e5; }
        body.dark .bg-white, body.dark .card { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-gray-50 { background-color: #0f0f0f !important; }
        body.dark .bg-gray-100 { background-color: #262626 !important; }
        body.dark .text-gray-500 { color: #9ca3af !important; }
        body.dark .border-gray-200 { border-color: #404040 !important; }
        body.dark table thead tr { background-color: #111 !important; }
        body.dark table tbody tr:hover { background-color: #222 !important; }
        body.dark .modal-container { background: #131212; border-color: #333; }
        body.dark .modal-header, body.dark .modal-footer { border-color: #333; }
        body.dark input, body.dark select, body.dark textarea { background-color: #111 !important; border-color: #404040 !important; color: #e5e5e5 !important; }
        body.dark .dropdown-menu { background-color: #2a2a2a; border-color: #404040; }
        body.dark .dropdown-item:hover { background-color: #3f3f46; }
        body.dark .tab-btn[data-state="active"] { background: #131212; color: #e5e5e5; }
        body.dark .tab-bar { background: #262626; }
        body.dark .inner-tab-bar { background: #262626; }
        body.dark .inner-tab-btn[data-state="active"] { background: #131212; color: #e5e5e5; }
        body.dark .stat-card { background: #131212; border-color: #333; }
        body.dark .select-trigger { background-color: #111; border-color: #404040; color: #e5e5e5; }
        body.dark .select-content { background: #2a2a2a; border-color: #404040; }
        body.dark .select-item:hover { background: #3f3f46; }
        body.dark label { color: #d1d5db; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        body.dark ::-webkit-scrollbar-track { background: #2a2a2a; }
        body.dark ::-webkit-scrollbar-thumb { background: #555; }

        /* Layout */
        .page-wrapper { display: flex; min-height: 100vh; flex-direction: column; }
        header { position: sticky; top: 0; z-index: 40; border-bottom: 1px solid #e5e7eb; background: white; box-shadow: 0 1px 2px rgba(0,0,0,.05); }
        body.dark header { background: #131212; border-color: #333; }
        .header-inner { display: flex; height: 4rem; align-items: center; justify-content: space-between; padding: 0 1.5rem; }
        aside { position: fixed; height: 100%; left: 0; bottom: 0; z-index: 40; display: flex; width: 16rem; flex-direction: column; border-right: 1px solid #e5e7eb; background: white; transition: transform .3s ease; }
        body.dark aside { background: #131212; border-color: #333; }
        main { flex: 1; padding: 1.5rem; margin-left: 16rem; }
        @media (max-width: 1279px) { aside { transform: translateX(-100%); } main { margin-left: 0; } header { margin-left: 0 !important; } aside.open { transform: translateX(0); } }

        /* Sidebar */
        .sidebar-logo { display: flex; align-items: center; gap: .5rem; padding: .75rem 1rem; border-bottom: 1px solid #e5e7eb; }
        body.dark .sidebar-logo { border-color: #333; }
        .sidebar-logo span { font-weight: 700; }
        .sidebar-nav { flex: 1; padding: .5rem; overflow-y: auto; }
        .nav-link { display: flex; align-items: center; border-radius: .375rem; padding: .5rem .75rem; font-size: .875rem; font-weight: 500; color: #374151; text-decoration: none; margin-bottom: 2px; }
        .nav-link:hover { background: #f3f4f6; }
        .nav-link.active { background: #eef2ff; color: #4338ca; }
        body.dark .nav-link { color: #d1d5db; }
        body.dark .nav-link:hover { background: #262626; }
        body.dark .nav-link.active { background: #1e1b4b; color: #a5b4fc; }
        .sidebar-footer { border-top: 1px solid #e5e7eb; padding: 1rem; display: flex; align-items: center; gap: .75rem; }
        body.dark .sidebar-footer { border-color: #333; }
        .avatar-circle { height: 2rem; width: 2rem; border-radius: 9999px; background: #e5e7eb; display: flex; align-items: center; justify-content: center; font-size: .875rem; font-weight: 600; flex-shrink: 0; }

        /* Cards */
        .card { background: white; border: 1px solid #e5e7eb; border-radius: .5rem; }
        .stat-card { background: white; border: 1px solid #e5e7eb; border-radius: .5rem; padding: 1rem; }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-value { font-size: 1.5rem; font-weight: 700; }
        .stat-sub { font-size: .75rem; color: #6b7280; margin-top: .25rem; }
        .stat-icon { float: right; }

        /* Tabs */
        .tab-bar { background: #f3f4f6; border-radius: .375rem; padding: .25rem; display: inline-flex; flex-wrap: wrap; gap: 2px; margin-bottom: 1rem; }
        .tab-btn { border: none; border-radius: .25rem; padding: .375rem .75rem; font-size: .875rem; font-weight: 500; cursor: pointer; background: transparent; color: #6b7280; transition: all .15s; }
        .tab-btn[data-state="active"] { background: white; color: #1f2937; box-shadow: 0 1px 2px rgba(0,0,0,.08); }
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }

        /* Inner tabs (for history modal) */
        .inner-tab-bar { background: #f3f4f6; border-radius: .375rem; padding: .25rem; display: inline-flex; flex-wrap: wrap; gap: 2px; margin-bottom: 1rem; }
        .inner-tab-btn { border: none; border-radius: .25rem; padding: .375rem .75rem; font-size: .875rem; font-weight: 500; cursor: pointer; background: transparent; color: #6b7280; transition: all .15s; display: flex; align-items: center; gap: .375rem; }
        .inner-tab-btn[data-state="active"] { background: white; color: #1f2937; box-shadow: 0 1px 2px rgba(0,0,0,.08); }
        .inner-tab-panel { display: none; }
        .inner-tab-panel.active { display: block; }

        /* Table */
        .table-wrap { width: 100%; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: .875rem; white-space: nowrap; }
        thead tr { border-bottom: 1px solid #e5e7eb; background: #f9fafb; }
        body.dark thead tr { background: #111; border-color: #333; }
        th { height: 3rem; padding: 0 1rem; text-align: left; font-weight: 500; color: #6b7280; }
        tbody tr { border-bottom: 1px solid #e5e7eb; transition: background .1s; }
        body.dark tbody tr { border-color: #333; }
        tbody tr:hover { background: #f9fafb; }
        body.dark tbody tr:hover { background: #222; }
        td { padding: .75rem 1rem; vertical-align: middle; }

        /* Badge */
        .badge { display: inline-flex; align-items: center; gap: .25rem; border-radius: 9999px; padding: .125rem .625rem; font-size: .75rem; font-weight: 600; }
        .badge-green { background: #059669; color: white; }
        .badge-red { background: #dc2626; color: white; }
        .badge-amber { background: #d97706; color: white; }
        .badge-blue { background: transparent; border: 1px solid #3b82f6; color: #60a5fa; }
        .badge-gray { background: transparent; border: 1px solid #6b7280; color: #9ca3af; }
        .badge-outline { background: transparent; border: 1px solid #e5e7eb; color: #374151; }
        body.dark .badge-outline { border-color: #555; color: #d1d5db; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: .5rem; border-radius: .375rem; font-size: .875rem; font-weight: 500; cursor: pointer; transition: all .15s; padding: .5rem .75rem; border: 1px solid transparent; }
        .btn-outline { border-color: #d1d5db; background: white; color: #374151; }
        .btn-outline:hover { background: #f9fafb; }
        body.dark .btn-outline { border-color: #404040; background: #131212; color: #d1d5db; }
        body.dark .btn-outline:hover { background: #262626; }
        .btn-blue { background: #2563eb; color: white; border-color: #2563eb; }
        .btn-blue:hover { background: #1d4ed8; }
        .btn-ghost { background: transparent; border-color: transparent; color: #9ca3af; }
        .btn-ghost:hover { background: #f3f4f6; color: #374151; }
        body.dark .btn-ghost:hover { background: #262626; color: #e5e5e5; }
        .btn-icon { width: 2.5rem; height: 2.5rem; padding: 0; justify-content: center; }
        .btn-sm { padding: .375rem .625rem; font-size: .8125rem; }

        /* Modal */
        .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 1000; display: flex; align-items: center; justify-content: center; animation: fadeIn .15s ease; }
        .modal-container { background: white; border-radius: .75rem; width: 100%; max-width: 500px; max-height: 90vh; overflow-y: auto; box-shadow: 0 25px 50px -12px rgba(0,0,0,.25); animation: slideUp .2s ease; position: relative; }
        .modal-container.modal-lg { max-width: 820px; }
        .modal-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: flex-start; }
        .modal-title { font-size: 1.125rem; font-weight: 600; }
        .modal-subtitle { font-size: .875rem; color: #6b7280; margin-top: .25rem; }
        .modal-body { padding: 1.25rem 1.5rem; }
        .modal-footer { padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: .5rem; }
        .modal-close { background: transparent; border: none; font-size: 1.25rem; cursor: pointer; color: #9ca3af; padding: .25rem; border-radius: .25rem; line-height: 1; }
        .modal-close:hover { color: #374151; background: #f3f4f6; }
        body.dark .modal-close:hover { color: #e5e5e5; background: #333; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { transform: translateY(20px) scale(.98); opacity: 0; } to { transform: translateY(0) scale(1); opacity: 1; } }

        /* Form fields */
        .form-group { margin-bottom: 1rem; }
        .form-group:last-child { margin-bottom: 0; }
        label { display: block; font-size: .875rem; font-weight: 500; margin-bottom: .375rem; color: #374151; }
        input[type="text"], input[type="time"], input[type="date"], input[type="search"], textarea, .select-trigger {
            width: 100%; height: 2.5rem; border: 1px solid #d1d5db; border-radius: .375rem; background: white; padding: 0 .75rem; font-size: .875rem; color: #1f2937; outline: none; transition: border-color .15s, box-shadow .15s;
        }
        textarea { height: auto; padding: .5rem .75rem; resize: vertical; }
        input:focus, textarea:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.15); }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

        /* Custom select */
        .select-wrap { position: relative; }
        .select-trigger { display: flex; align-items: center; justify-content: space-between; cursor: pointer; user-select: none; }
        .select-content { position: absolute; top: 100%; left: 0; right: 0; z-index: 200; background: white; border: 1px solid #e5e7eb; border-radius: .5rem; box-shadow: 0 10px 25px rgba(0,0,0,.12); margin-top: 4px; display: none; max-height: 200px; overflow-y: auto; }
        .select-content.open { display: block; }
        .select-item { padding: .5rem .75rem; font-size: .875rem; cursor: pointer; transition: background .1s; }
        .select-item:hover { background: #f3f4f6; }
        .select-item.selected { background: #eef2ff; color: #4338ca; }
        body.dark .select-item.selected { background: #1e1b4b; color: #a5b4fc; }
/* Modern Action Menu */
.action-menu {
    position: fixed;
    z-index: 10000;
    min-width: 200px;
    background: white;
    border-radius: 0.5rem;
    border: 1px solid #e5e7eb;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
    padding: 0.25rem;
    animation: fadeInScale 0.12s ease-out;
}
body.dark .action-menu { background: #2a2a2a; border-color: #404040; }
.action-menu-header { padding: 0.5rem 0.75rem; font-size: 0.75rem; font-weight: 600; color: #6b7280; border-bottom: 1px solid #e5e7eb; margin-bottom: 0.25rem; }
body.dark .action-menu-header { color: #9ca3af; border-bottom-color: #404040; }
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
    text-align: left;
}
.action-item:hover { background-color: #f3f4f6; }
body.dark .action-item:hover { background-color: #3f3f46; }
.action-divider { height: 1px; background-color: #e5e7eb; margin: 0.25rem 0; }
body.dark .action-divider { background-color: #404040; }
.text-red-600 { color: #dc2626; }
.text-red-600:hover { background-color: #fee2e2; }
body.dark .text-red-600:hover { background-color: #7f1d1d; color: #fecaca; }

@keyframes fadeInScale { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }

        /* Toast */
        .toast { position: fixed; bottom: 1.25rem; right: 1.25rem; background: #10b981; color: white; padding: .75rem 1.25rem; border-radius: .5rem; font-size: .875rem; z-index: 2000; animation: slideInRight .3s ease; box-shadow: 0 4px 12px rgba(0,0,0,.15); }
        .toast.error { background: #ef4444; }
        @keyframes slideInRight { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }

        /* Staff avatar row */
        .staff-cell { display: flex; align-items: center; gap: .5rem; }
        .staff-avatar { width: 2rem; height: 2rem; border-radius: 9999px; background: #e5e7eb; display: flex; align-items: center; justify-content: center; font-size: .75rem; font-weight: 600; color: #374151; flex-shrink: 0; }
        .staff-name { font-weight: 500; }

        /* Calendar grid sticky */
        .calendar-staff-col { position: sticky; left: 0; background: white; z-index: 5; min-width: 220px; }
        body.dark .calendar-staff-col { background: #131212; }
        .calendar-staff-col:hover { background: #f9fafb; }
        body.dark .calendar-staff-col:hover { background: #222; }
        thead .calendar-staff-col { background: #f9fafb; }
        body.dark thead .calendar-staff-col { background: #111; }

        /* Legend */
        .legend { display: flex; align-items: center; justify-content: center; gap: 1.5rem; margin-top: 1.5rem; flex-wrap: wrap; }
        .legend-item { display: flex; align-items: center; gap: .5rem; font-size: .875rem; color: #6b7280; }
        body.dark .legend-item { color: #9ca3af; }

        /* Page header */
        .page-header { display: flex; align-items: center; gap: 1rem; border-bottom: 1px solid #e5e7eb; padding-bottom: .75rem; margin-bottom: 1.5rem; }
        body.dark .page-header { border-color: #333; }
        .page-title { font-size: 1.5rem; font-weight: 700; }

        /* Card sections */
        .card-header { padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .75rem; }
        body.dark .card-header { border-color: #333; }
        .card-title { font-size: 1.25rem; font-weight: 600; }
        .card-body { padding: 1rem 1.5rem; }
        .card-subtitle { font-size: .875rem; color: #6b7280; margin-top: .25rem; }

        /* Filter bar */
        .filter-bar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: .75rem; margin-bottom: 1rem; }
        .filter-group { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; }

        /* Profile dropdown */
        .profile-dropdown { position: absolute; right: 0; top: calc(100% + 8px); background: white; border: 1px solid #e5e7eb; border-radius: .5rem; box-shadow: 0 10px 25px rgba(0,0,0,.1); padding: .25rem; min-width: 200px; z-index: 100; }
        body.dark .profile-dropdown { background: #2a2a2a; border-color: #404040; }
        .profile-dropdown-header { padding: .5rem .75rem; border-bottom: 1px solid #e5e7eb; margin-bottom: .25rem; }
        body.dark .profile-dropdown-header { border-color: #404040; }
        .profile-dropdown a { display: flex; align-items: center; gap: .5rem; padding: .375rem .625rem; font-size: .875rem; color: #374151; text-decoration: none; border-radius: .25rem; transition: background .1s; }
        body.dark .profile-dropdown a { color: #d1d5db; }
        .profile-dropdown a:hover { background: #f3f4f6; }
        body.dark .profile-dropdown a:hover { background: #3f3f46; }
        .profile-dropdown a.danger { color: #ef4444; }

        /* Summary stats */
        .summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
        @media (max-width: 768px) { .summary-grid { grid-template-columns: 1fr; } .grid-2 { grid-template-columns: 1fr; } }

        /* ApexCharts fix */
        .apexcharts-canvas { background: transparent !important; }
        body.dark .apexcharts-text, body.dark .apexcharts-legend-text { fill: #e5e5e5 !important; color: #e5e5e5 !important; }
        body.dark .apexcharts-grid line { stroke: #333 !important; }

        /* Clock icon inline */
        .clock-icon { display: inline-flex; align-items: center; gap: .25rem; }
        .clock-icon svg { color: #9ca3af; }
        svg { vertical-align: middle; }

        @media (max-width: 768px) {
    .hide-mobile { display: none; }
    .grid-2 { grid-template-columns: 1fr; }
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .summary-grid { grid-template-columns: 1fr; }
}
@media print {
    aside, header, .tab-bar, .filter-bar, .modal-overlay { display: none !important; }
    main { margin: 0 !important; padding: 0 !important; }
    .tab-panel { display: block !important; }
}

/* Horizontal scroll for calendar */
#calendarContainer {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
#calendarContainer table {
    min-width: 800px;
}

body.dark #timesheetDetailsBody .card {
    background: #131212;
    border-color: #333;
}
body.dark #timesheetDetailsBody table tfoot tr {
    background: #111 !important;
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
    <!-- Page Header -->
                <div class="flex items-center gap-4 flex-wrap mb-4">
                    <a class="inline-flex items-center justify-center rounded-md border p-2   border-input bg-background hover:bg-accent hover:text-accent-foreground size-10" href="staff-management.html"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"></path><path d="M19 12H5"></path></svg></a>
                    <div><h1 class="text-2xl lg:text-3xl font-bold tracking-tight mb-2">Staff Attendance</h1>
                        <p class="text-gray-500">Track attendance, leave, timesheet &amp; reports</p>
                    </div>
                </div>

    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card rounded-lg text-card-foreground p-4 border bg-white dark:bg-background shadow-sm hover:shadow-md transition">
            <div style="display:flex;justify-content:space-between;align-items:flex-start; padding-bottom: 10px;">
                <div class="text-base font-semibold">Present Today</div>
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none"  stroke-width="2"stroke="#10b981" ><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>
            </div>
            <div class="stat-value">5</div>
            <div class="flex items-center mt-1"><div class="w-full bg-gray-200 dark:bg-neutral-900 rounded-full h-2.5"><div class="bg-emerald-500 h-2.5 rounded-full" style="width: 75%;"></div></div><span class="text-xs text-emerald-400 ml-2">+2%</span></div>
            <div class="stat-sub">Out of 8 staff members</div>
        </div>
        <div class="stat-card rounded-lg text-card-foreground p-4 border bg-white dark:bg-background shadow-sm hover:shadow-md transition">
            <div style="display:flex;justify-content:space-between;align-items:flex-start; padding-bottom: 10px;">
                <div class="text-base font-semibold">Absent Today</div>
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none"  stroke-width="2"stroke="#ef4444" ><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="17" x2="22" y1="8" y2="13"/><line x1="22" x2="17" y1="8" y2="13"/></svg>
            </div>
            <div class="stat-value">1</div>
            <div class="flex items-center mt-1"><div class="w-full bg-gray-200 dark:bg-neutral-900 rounded-full h-2.5"><div class="bg-red-500 h-2.5 rounded-full" style="width: 12.5%;"></div></div><span class="text-xs text-red-400 ml-2">-1%</span></div>
            <div class="stat-sub">Unplanned absences</div>
        </div>
        <div class="stat-card rounded-lg text-card-foreground p-4 border bg-white dark:bg-background shadow-sm hover:shadow-md transition">
            <div style="display:flex;justify-content:space-between;align-items:flex-start; padding-bottom: 10px;">
                <div class="text-base font-semibold">On Leave</div>
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none"  stroke-width="2"stroke="#3b82f6" ><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
            </div>
            <div class="stat-value">1</div>
            <div class="flex items-center mt-1"><div class="w-full bg-gray-200 dark:bg-neutral-900 rounded-full h-2.5"><div class="bg-blue-500 h-2.5 rounded-full" style="width: 12.5%;"></div></div><span class="text-xs text-blue-400 ml-2">0%</span></div>
            <div class="stat-sub">Approved leave requests</div>
        </div>
        <div class="stat-card rounded-lg text-card-foreground p-4 border bg-white dark:bg-background shadow-sm hover:shadow-md transition">
            <div style="display:flex;justify-content:space-between;align-items:flex-start; padding-bottom: 10px;">
                <div class="text-base font-semibold">Late Arrivals</div>
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none"  stroke-width="2"stroke="#f59e0b" ><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
            </div>
            <div class="stat-value">1</div>
            <div class="flex items-center mt-1"><div class="w-full bg-gray-200 dark:bg-neutral-900 rounded-full h-2.5"><div class="bg-amber-500 h-2.5 rounded-full" style="width: 12.5%;"></div></div><span class="text-xs text-amber-400 ml-2">-3%</span></div>
            <div class="stat-sub">More than 30 minutes late</div>
        </div>
    </div>

  <!-- closes stats-grid -->

    <!-- Filter & Actions Toolbar -->
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem;margin-bottom:1rem;">
        <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
            <div style="position:relative;">
                <svg style="position:absolute;left:10px;top:50%;transform:translateY(-50%);color:#9ca3af;z-index:1;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input type="search" id="dailySearch" placeholder="Search staff..." oninput="renderDailyTable()" style="height:2.5rem;border:1px solid #d1d5db;border-radius:0.375rem;background:white;padding:0 0.75rem 0 2.25rem;font-size:0.875rem;width:250px;outline:none;">
            </div>
            <div class="select-wrap" style="width:180px;">
                <div class="select-trigger" onclick="toggleSelect('deptSelect')">
                    <span id="deptFilterText">All Departments</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><polyline points="6 9 12 15 18 9"/></svg>
                </div>
                <div class="select-content" id="deptSelect">
                    <div class="select-item selected" onclick="setDeptFilter('all','All Departments')">All Departments</div>
                    <div class="select-item" onclick="setDeptFilter('Medical','Medical')">Medical</div>
                    <div class="select-item" onclick="setDeptFilter('Nursing','Nursing')">Nursing</div>
                    <div class="select-item" onclick="setDeptFilter('Laboratory','Laboratory')">Laboratory</div>
                    <div class="select-item" onclick="setDeptFilter('Administration','Administration')">Administration</div>
                    <div class="select-item" onclick="setDeptFilter('Pharmacy','Pharmacy')">Pharmacy</div>
                    <div class="select-item" onclick="setDeptFilter('IT','IT')">IT</div>
                </div>
            </div>
        <div class="relative" data-radix-popover="">
        <button type="button" id="dateRangeBtn" class="inline-flex items-center gap-2 rounded-md border border-gray-300 bg-background h-10 px-4 text-sm w-[260px] justify-start  hover:bg-accent hover:text-accent-foreground h-10 " data-state="closed">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 2v4M16 2v4M3 10h18"></path><rect width="18" height="18" x="3" y="4" rx="2"></rect></svg>
            <span id="dateRangeText">Apr 1, 2026 - Apr 30, 2026</span>
        </button>
        
        <div id="datePickerPopover" class="hidden absolute z-50 mt-2 w-[260px] rounded-md border border-gray-200 bg-background shadow-lg overflow-hidden" data-radix-popover-content="">
            <div class="p-4 space-y-4">
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1">Start Date</label>
                <input type="date" id="startDate" class="w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1">End Date</label>
                <input type="date" id="endDate" class="w-full rounded-md border border-gray-300 bg-background px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="flex gap-2 pt-2">
                <button id="applyDateBtn" class="flex-1 rounded-md bg-primary text-white py-2 text-sm font-medium hover:bg-primary/90 transition-colors">Apply</button>
                <button id="cancelDateBtn" class="flex-1 rounded-md border border-gray-300 bg-background py-2 text-sm font-medium  hover:bg-accent hover:text-accent-foreground h-10 transition-colors">Cancel</button>
            </div>
            </div>
        </div>
        </div>
        </div>
        <div style="display:flex;align-items:center;gap:0.5rem;">
            <button class="btn bg-primary h-10 btn-sm" onclick="openModal('recordTimeModal')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Record Time
            </button>
<button id="smartExportBtn" class="btn btn-outline h-10 btn-sm">
    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" x2="12" y1="15" y2="3"></line></svg>
    Export
</button>
        </div>
    </div>

<!-- Tabs -->
<div class="tab-bar">
    <button class="tab-btn" data-tab="daily" data-state="active">Daily Attendance</button>
    <button class="tab-btn" data-tab="calendar" data-state="inactive">Calendar View</button>
    <button class="tab-btn" data-tab="timesheet" data-state="inactive">Timesheets</button>
    <button class="tab-btn" data-tab="leave" data-state="inactive">Leave Requests</button>
    <button class="tab-btn" data-tab="shifts" data-state="inactive">Shifts</button>
    <button class="tab-btn" data-tab="reports" data-state="inactive">Reports</button>
</div>

    <!-- ===== TAB 1: DAILY ATTENDANCE ===== -->
    <div id="tab-daily" class="tab-panel active">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Daily Attendance Record</div>
                <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                    <button class="btn btn-outline h-10 btn-sm" onclick="printDailyTable()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
                        Print
                    </button>
                    <button id="smartExportBtn" class="btn btn-outline h-10 btn-sm">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M8 13h2"/><path d="M14 13h2"/><path d="M8 17h2"/><path d="M14 17h2"/></svg>
                        Export CSV
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Staff</th>
                                <th>Department</th>
                                <th class="hide-mobile">Role</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th class="hide-mobile">Hours</th>
                                <th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="dailyTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== TAB 2: CALENDAR VIEW ===== -->
    <div id="tab-calendar" class="tab-panel">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Monthly Attendance Calendar</div>
                <div style="display:flex;align-items:center;gap:.5rem;">
                    <button class="btn btn-outline btn-sm h-10 btn-icon" id="prevMonthBtn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><polyline points="15 18 9 12 15 6"/></svg>
                    </button>
                    <span id="calMonthYear" style="font-size:.875rem;font-weight:500;min-width:100px;text-align:center;">May 2023</span>
                    <button class="btn btn-outline btn-sm h-10 btn-icon" id="nextMonthBtn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>
            </div>
            <div class="card-body">
<div class="table-wrap" id="calendarContainer" style="overflow-x:auto;max-width:100%;"></div>
                <div class="legend">
                    <div class="legend-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" ><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                        Present
                    </div>
                    <div class="legend-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" ><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                        Absent
                    </div>
                    <div class="legend-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" ><path d="M12 16h.01"/><path d="M12 8v4"/><path d="M15.312 2a2 2 0 0 1 1.414.586l4.688 4.688A2 2 0 0 1 22 8.688v6.624a2 2 0 0 1-.586 1.414l-4.688 4.688a2 2 0 0 1-1.414.586H8.688a2 2 0 0 1-1.414-.586l-4.688-4.688A2 2 0 0 1 2 15.312V8.688a2 2 0 0 1 .586-1.414l4.688-4.688A2 2 0 0 1 8.688 2z"/></svg>
                        Late
                    </div>
                    <div class="legend-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" ><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16.5 12"/></svg>
                        On Leave
                    </div>
                    <div class="legend-item">
                        <span style="display:inline-block;width:16px;height:16px;border-radius:50%;border:1px solid #d1d5db;"></span>
                        Weekend
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== TAB 3: TIMESHEETS ===== -->
    <div id="tab-timesheet" class="tab-panel">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Staff Timesheets</div>
                    <div class="card-subtitle">View and manage staff working hours</div>
                </div>
                <button class="btn bg-primary hover:bg-primary/90  btn-sm h-10" onclick="openModal('addTimesheetModal')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"></path><path d="M12 5v14"></path></svg>
                    Add Timesheet
                </button>
            </div>
            <div class="card-body">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Staff</th>
                                <th>Department</th>
                                <th>Week Starting</th>
                                <th>Total Hours</th>
                                <th class="hide-mobile">Overtime</th>
                                <th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="timesheetTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== TAB 4: LEAVE REQUESTS ===== -->
    <div id="tab-leave" class="tab-panel">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Leave Requests</div>
                    <div class="card-subtitle">Manage staff leave and time off requests</div>
                </div>
                <div style="display:flex;gap:.5rem;align-items:center;">
                    <button class="btn btn-outline btn-sm h-10">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
                        All Requests
                    </button>
                    <button class="btn bg-primary hover:bg-primary/90  btn-sm h-10" id="newLeaveRequestBtn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                        New Request
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Staff</th>
                                <th class="hide-mobile">Department</th>
                                <th>Leave Type</th>
                                <th>Duration</th>
                                <th class="hide-mobile">Dates</th>
                                <th>Status</th>
                                <th style="text-align:right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="leaveTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== TAB 5: SHIFTS ===== -->
<div id="tab-shifts" class="tab-panel">
    <div class="card">
        <div class="card-header">
            <div>
                <div class="card-title">Staff Shift Schedule</div>
                <div class="card-subtitle" id="shiftWeekHeader">Week of Jun 12 - Jun 18, 2023</div>
            </div>
            <div class="flex items-center gap-3 flex-wrap">
                                <!-- Navigation Arrows -->
<!-- Navigation Arrows -->
<div style="display:flex;align-items:center;gap:0.25rem;">
    <button class="btn btn-outline btn-sm h-10 btn-icon" id="prevShiftWeekBtn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
    </button>
    <span id="shiftNavMonth" style="font-size:0.875rem;font-weight:500;min-width:120px;text-align:center;color:#374151;">Jun 2023</span>
    <button class="btn btn-outline btn-sm h-10 btn-icon" id="nextShiftWeekBtn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
    </button>
</div>

                <!-- Export Buttons -->
                <button id="shuffleShiftsBtn" class="btn bg-primary hover:bg-primary/90 btn-sm h-10">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/></svg>
                    Change Shifts
                </button>
                <button id="exportShiftPDFBtn" class="btn btn-outline btn-sm h-10">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Download
                </button>
                
            </div>
        </div>
        <div class="card-body">
            <!-- Shift Legend -->
            <div style="display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;margin-bottom:1rem;">
                <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;color:#6b7280;">
                    <span style="display:inline-block;width:14px;height:14px;border-radius:4px;background:#fef3c7;border:1px solid #fcd34d;"></span> Morning (07:00 - 15:00)
                </div>
                <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;color:#6b7280;">
                    <span style="display:inline-block;width:14px;height:14px;border-radius:4px;background:#dbeafe;border:1px solid #93c5fd;"></span> Evening (15:00 - 23:00)
                </div>
                <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;color:#6b7280;">
                    <span style="display:inline-block;width:14px;height:14px;border-radius:4px;background:#ede9fe;border:1px solid #c4b5fd;"></span> Night (23:00 - 07:00)
                </div>
                <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.875rem;color:#6b7280;">
                    <span style="display:inline-block;width:14px;height:14px;border-radius:4px;border:1px dashed #d1d5db;"></span> Off
                </div>
            </div>

            <!-- Shift Grid -->
            <div id="shiftGridContainer" style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
                <table style="min-width:900px;">
                    <thead>
                        <tr>
                            <th class="calendar-staff-col">Staff Name</th>
                            <th style="text-align:center;padding:8px;min-width:80px;font-size:0.75rem;">Mon<br><span id="shiftDate0">6/12</span></th>
                            <th style="text-align:center;padding:8px;min-width:80px;font-size:0.75rem;">Tue<br><span id="shiftDate1">6/13</span></th>
                            <th style="text-align:center;padding:8px;min-width:80px;font-size:0.75rem;">Wed<br><span id="shiftDate2">6/14</span></th>
                            <th style="text-align:center;padding:8px;min-width:80px;font-size:0.75rem;">Thu<br><span id="shiftDate3">6/15</span></th>
                            <th style="text-align:center;padding:8px;min-width:80px;font-size:0.75rem;">Fri<br><span id="shiftDate4">6/16</span></th>
                            <th style="text-align:center;padding:8px;min-width:80px;font-size:0.75rem;">Sat<br><span id="shiftDate5">6/17</span></th>
                            <th style="text-align:center;padding:8px;min-width:80px;font-size:0.75rem;">Sun<br><span id="shiftDate6">6/18</span></th>
                        </tr>
                    </thead>
                    <tbody id="shiftGridBody"></tbody>
                </table>
            </div>

            <p style="text-align:center;font-size:0.75rem;color:#9ca3af;margin-top:0.75rem;">Intelligently redistributes staff based on , expertise and workload</p>
        </div>
    </div>
</div>

    <!-- ===== TAB 6: REPORTS ===== -->
    <div id="tab-reports" class="tab-panel">
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Attendance Reports</div>
                    <div class="card-subtitle">Generate and view comprehensive attendance reports</div>
                </div>
                <button class="btn bg-primary hover:bg-primary/90  btn-sm h-10">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
                    Export Report
                </button>
            </div>
            <div class="card-body">
                <div class="summary-grid">
                    <div class="card" style="padding:1rem;">
                        <h2 class="xl:text-2xl font-semibold mb-2 tracking-tight text-sm text-gray-500">Attendance Summary</h2>
                        <div style="display:flex;flex-direction:column;gap:.5rem;">
                            <div style="display:flex;justify-content:space-between;font-size:.875rem;"><span style="color:#6b7280;">Present:</span><span style="font-weight:500;">92%</span></div>
                            <div style="display:flex;justify-content:space-between;font-size:.875rem;"><span style="color:#6b7280;">Absent:</span><span style="font-weight:500;">3%</span></div>
                            <div style="display:flex;justify-content:space-between;font-size:.875rem;"><span style="color:#6b7280;">On Leave:</span><span style="font-weight:500;">4%</span></div>
                            <div style="display:flex;justify-content:space-between;font-size:.875rem;"><span style="color:#6b7280;">Late:</span><span style="font-weight:500;">1%</span></div>
                        </div>
                    </div>
                    <div class="card" style="padding:1rem;">
                        <h2 class="xl:text-2xl font-semibold mb-2 tracking-tight text-sm text-gray-500">Department Breakdown</h2>
                        <div style="display:flex;flex-direction:column;gap:.5rem;">
                            <div style="display:flex;justify-content:space-between;font-size:.875rem;"><span style="color:#6b7280;">Medical:</span><span style="font-weight:500;">95% present</span></div>
                            <div style="display:flex;justify-content:space-between;font-size:.875rem;"><span style="color:#6b7280;">Nursing:</span><span style="font-weight:500;">90% present</span></div>
                            <div style="display:flex;justify-content:space-between;font-size:.875rem;"><span style="color:#6b7280;">Administration:</span><span style="font-weight:500;">93% present</span></div>
                            <div style="display:flex;justify-content:space-between;font-size:.875rem;"><span style="color:#6b7280;">Support:</span><span style="font-weight:500;">88% present</span></div>
                        </div>
                    </div>
                    <div class="card" style="padding:1rem;">
                        <h2 class="xl:text-2xl font-semibold mb-2 tracking-tight text-sm text-gray-500">Leave Statistics</h2>
                        <div style="display:flex;flex-direction:column;gap:.5rem;">
                            <div style="display:flex;justify-content:space-between;font-size:.875rem;"><span style="color:#6b7280;">Vacation:</span><span style="font-weight:500;">45%</span></div>
                            <div style="display:flex;justify-content:space-between;font-size:.875rem;"><span style="color:#6b7280;">Sick Leave:</span><span style="font-weight:500;">30%</span></div>
                            <div style="display:flex;justify-content:space-between;font-size:.875rem;"><span style="color:#6b7280;">Personal:</span><span style="font-weight:500;">15%</span></div>
                            <div style="display:flex;justify-content:space-between;font-size:.875rem;"><span style="color:#6b7280;">Other:</span><span style="font-weight:500;">10%</span></div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div style="padding:1rem 1.5rem;border-bottom:1px solid #e5e7eb;" id="chartCardHeader">
                        <div style="font-size:1rem;font-weight:600;">Monthly Attendance Trends</div>
                    </div>
                    <div style="padding:1rem 1.5rem;">
                        <div id="attendanceChart" style="height:300px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
</div>
</div>

<!-- ===== MODALS ===== -->

<!-- Edit Time Modal -->
<div id="editTimeModal" class="modal-overlay" style="display:none;">
    <div class="modal-container">
        <div class="modal-header">
            <div>
                <div class="modal-title">Edit Attendance Time</div>
                <div class="modal-subtitle" id="editTimeSubtitle">Update check-in or check-out time.</div>
            </div>
            <button class="modal-close" onclick="closeModal('editTimeModal')">✕</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Record Type</label>
                <div class="select-wrap">
                    <div class="select-trigger" onclick="toggleSelect('recordTypeSelect')">
                        <span id="recordTypeText">Check In</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="select-content" id="recordTypeSelect">
                        <div class="select-item selected" onclick="setSelectVal('recordTypeSelect','recordTypeText','Check In')">Check In</div>
                        <div class="select-item" onclick="setSelectVal('recordTypeSelect','recordTypeText','Check Out')">Check Out</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="editTime">Time</label>
                <input type="time" id="editTime" value="08:45">
            </div>
            <div class="form-group">
                <label for="editDate">Date</label>
                <input type="date" id="editDate">
            </div>
            <div class="form-group">
                <label for="editReason">Reason for Edit</label>
                <input type="text" id="editReason" placeholder="Reason for editing the time record">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('editTimeModal')">Cancel</button>
            <button class="btn bg-primary text-white" onclick="saveModal('editTimeModal','Time updated successfully')">Save Changes</button>
        </div>
    </div>
</div>

<!-- Add Note Modal -->
<div id="addNoteModal" class="modal-overlay" style="display:none;">
    <div class="modal-container">
        <div class="modal-header">
            <div>
                <div class="modal-title">Add Attendance Note</div>
                <div class="modal-subtitle" id="addNoteSubtitle">Add a note to the attendance record.</div>
            </div>
            <button class="modal-close" onclick="closeModal('addNoteModal')">✕</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Note Type</label>
                <div class="select-wrap">
                    <div class="select-trigger" onclick="toggleSelect('noteTypeSelect')">
                        <span id="noteTypeText">General Note</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="select-content" id="noteTypeSelect">
                        <div class="select-item selected" onclick="setSelectVal('noteTypeSelect','noteTypeText','General Note')">General Note</div>
                        <div class="select-item" onclick="setSelectVal('noteTypeSelect','noteTypeText','Warning')">Warning</div>
                        <div class="select-item" onclick="setSelectVal('noteTypeSelect','noteTypeText','Commendation')">Commendation</div>
                        <div class="select-item" onclick="setSelectVal('noteTypeSelect','noteTypeText','Other')">Other</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="noteText">Note</label>
                <textarea id="noteText" rows="4" placeholder="Enter your note here"></textarea>
            </div>
            <div class="form-group">
                <label>Visibility</label>
                <div class="select-wrap">
                    <div class="select-trigger" onclick="toggleSelect('visibilitySelect')">
                        <span id="visibilityText">Management Only</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="select-content" id="visibilitySelect">
                        <div class="select-item selected" onclick="setSelectVal('visibilitySelect','visibilityText','Management Only')">Management Only</div>
                        <div class="select-item" onclick="setSelectVal('visibilitySelect','visibilityText','All Staff')">All Staff</div>
                        <div class="select-item" onclick="setSelectVal('visibilitySelect','visibilityText','HR Only')">HR Only</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('addNoteModal')">Cancel</button>
            <button class="btn bg-primary text-white" onclick="saveModal('addNoteModal','Note saved successfully')">Save Note</button>
        </div>
    </div>
</div>

<!-- View History Modal -->
<div id="historyModal" class="modal-overlay" style="display:none;">
    <div class="modal-container modal-lg">
        <div class="modal-header">
            <div>
                <div class="modal-title">Attendance History</div>
                <div class="modal-subtitle" id="historySubtitle">Viewing attendance history.</div>
            </div>
            <button class="modal-close" onclick="closeModal('historyModal')">✕</button>
        </div>
        <div class="modal-body">
            <div class="inner-tab-bar">
                <button class="inner-tab-btn" data-inner-tab="hist-log" data-state="active">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M8 2v4"/><path d="M16 2v4"/><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                    Attendance Log
                </button>
                <button class="inner-tab-btn" data-inner-tab="hist-edits" data-state="inactive">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Time Edits
                </button>
                <button class="inner-tab-btn" data-inner-tab="hist-notes" data-state="inactive">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                    Notes
                </button>
            </div>
            <div id="hist-log" class="inner-tab-panel active">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Status</th>
                                <th>Hours</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2023-05-15</td>
                                <td><span class="clock-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16.5 12"/></svg>08:45 AM</span></td>
                                <td><span class="clock-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16.5 12"/></svg>05:30 PM</span></td>
                                <td><span class="badge badge-green"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>Present</span></td>
                                <td>8.75</td>
                                <td style="color:#9ca3af;">-</td>
                            </tr>
                            <tr>
                                <td>2023-05-14</td>
                                <td><span class="clock-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16.5 12"/></svg>08:50 AM</span></td>
                                <td><span class="clock-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16.5 12"/></svg>05:15 PM</span></td>
                                <td><span class="badge badge-green"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>Present</span></td>
                                <td>8.42</td>
                                <td style="color:#9ca3af;">-</td>
                            </tr>
                            <tr>
                                <td>2023-05-13</td>
                                <td style="color:#9ca3af;">-</td>
                                <td style="color:#9ca3af;">-</td>
                                <td><span class="badge badge-outline">Weekend</span></td>
                                <td>0</td>
                                <td style="color:#9ca3af;">-</td>
                            </tr>
                            <tr>
                                <td>2023-05-12</td>
                                <td><span class="clock-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16.5 12"/></svg>09:20 AM</span></td>
                                <td><span class="clock-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16.5 12"/></svg>05:45 PM</span></td>
                                <td><span class="badge badge-amber"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>Late</span></td>
                                <td>8.42</td>
                                <td style="font-size:.8125rem;color:#9ca3af;">Traffic delay reported</td>
                            </tr>
                            <tr>
                                <td>2023-05-11</td>
                                <td><span class="clock-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16.5 12"/></svg>08:40 AM</span></td>
                                <td><span class="clock-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16.5 12"/></svg>05:10 PM</span></td>
                                <td><span class="badge badge-green"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>Present</span></td>
                                <td>8.5</td>
                                <td style="color:#9ca3af;">-</td>
                            </tr>
                            <tr>
                                <td>2023-05-10</td>
                                <td><span class="clock-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16.5 12"/></svg>08:30 AM</span></td>
                                <td><span class="clock-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16.5 12"/></svg>04:30 PM</span></td>
                                <td><span class="badge badge-green"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>Present</span></td>
                                <td>8.0</td>
                                <td style="font-size:.8125rem;color:#9ca3af;">Left early - approved</td>
                            </tr>
                            <tr>
                                <td>2023-05-09</td>
                                <td style="color:#9ca3af;">-</td>
                                <td style="color:#9ca3af;">-</td>
                                <td><span class="badge badge-red"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>Absent</span></td>
                                <td>0</td>
                                <td style="font-size:.8125rem;color:#9ca3af;">Sick leave</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="hist-edits" class="inner-tab-panel">
                <div style="padding:2rem;text-align:center;color:#9ca3af;">No time edits recorded.</div>
            </div>
            <div id="hist-notes" class="inner-tab-panel">
                <div style="padding:2rem;text-align:center;color:#9ca3af;">No notes recorded.</div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('historyModal')">Close</button>
            <button class="btn bg-primary text-white" onclick="showToast('Printing history...')">Print History</button>
        </div>
    </div>
</div>

<!-- New Leave Request Modal -->
<div id="leaveRequestModal" class="modal-overlay" style="display:none;">
    <div class="modal-container">
        <div class="modal-header">
            <div>
                <div class="modal-title">Submit Leave Request</div>
                <div class="modal-subtitle">Request time off or leave of absence.</div>
            </div>
            <button class="modal-close" onclick="closeModal('leaveRequestModal')">✕</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Staff Member</label>
                <div class="select-wrap">
                    <div class="select-trigger" onclick="toggleSelect('leaveStaffSelect')">
                        <span id="leaveStaffText" style="color:#9ca3af;">Select staff member</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="select-content" id="leaveStaffSelect">
                        <div class="select-item" onclick="setSelectVal('leaveStaffSelect','leaveStaffText','Dr. Nakato Sarah')">Dr. Nakato Sarah</div>
                        <div class="select-item" onclick="setSelectVal('leaveStaffSelect','leaveStaffText','Dr. Mwangi Peter')">Dr. Mwangi Peter</div>
                        <div class="select-item" onclick="setSelectVal('leaveStaffSelect','leaveStaffText','Nurse Namyalo Emma')">Nurse Namyalo Emma</div>
                        <div class="select-item" onclick="setSelectVal('leaveStaffSelect','leaveStaffText','Ssentongo James')">Ssentongo James</div>
                        <div class="select-item" onclick="setSelectVal('leaveStaffSelect','leaveStaffText','Nabwire Lisa')">Nabwire Lisa</div>
                        <div class="select-item" onclick="setSelectVal('leaveStaffSelect','leaveStaffText','Dr. Tumusiimeera Robert')">Dr. Tumusiimeera Robert</div>
                        <div class="select-item" onclick="setSelectVal('leaveStaffSelect','leaveStaffText','Nansubuga Sophia')">Nansubuga Sophia</div>
                        <div class="select-item" onclick="setSelectVal('leaveStaffSelect','leaveStaffText','Ssentongo Daniel')">Ssentongo Daniel</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Leave Type</label>
                <div class="select-wrap">
                    <div class="select-trigger" onclick="toggleSelect('leaveTypeSelect')">
                        <span id="leaveTypeText" style="color:#9ca3af;">Select leave type</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="select-content" id="leaveTypeSelect">
                        <div class="select-item" onclick="setSelectVal('leaveTypeSelect','leaveTypeText','Annual Leave')">Annual Leave</div>
                        <div class="select-item" onclick="setSelectVal('leaveTypeSelect','leaveTypeText','Sick Leave')">Sick Leave</div>
                        <div class="select-item" onclick="setSelectVal('leaveTypeSelect','leaveTypeText','Maternity/Paternity')">Maternity/Paternity</div>
                        <div class="select-item" onclick="setSelectVal('leaveTypeSelect','leaveTypeText','Personal')">Personal</div>
                        <div class="select-item" onclick="setSelectVal('leaveTypeSelect','leaveTypeText','Unpaid Leave')">Unpaid Leave</div>
                    </div>
                </div>
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label for="leaveStartDate">Start Date</label>
                    <input type="date" id="leaveStartDate">
                </div>
                <div class="form-group">
                    <label for="leaveEndDate">End Date</label>
                    <input type="date" id="leaveEndDate">
                </div>
            </div>
            <div class="form-group">
                <label for="leaveReason">Reason (Optional)</label>
                <input type="text" id="leaveReason" placeholder="Brief explanation for the leave request">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('leaveRequestModal')">Cancel</button>
            <button class="btn bg-primary hover:bg-primary/90" onclick="saveModal('leaveRequestModal','Leave request submitted')">Submit Request</button>
        </div>
    </div>
</div>

<!-- Leave View Details Modal -->
<div id="leaveDetailsModal" class="modal-overlay" style="display:none;">
    <div class="modal-container">
        <div class="modal-header">
            <div>
                <div class="modal-title">Leave Request Details</div>
                <div class="modal-subtitle" id="leaveDetailsSubtitle"></div>
            </div>
            <button class="modal-close" onclick="closeModal('leaveDetailsModal')">✕</button>
        </div>
        <div class="modal-body" id="leaveDetailsBody"></div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('leaveDetailsModal')">Close</button>
            <button class="btn bg-primary  text-white" onclick="saveModal('leaveDetailsModal','Action taken')">Approve</button>
        </div>
    </div>
</div>

<!-- Record Time Modal -->
<div id="recordTimeModal" class="modal-overlay" style="display:none;">
    <div class="modal-container">
        <div class="modal-header">
            <div>
                <div class="modal-title">Record Attendance</div>
                <div class="modal-subtitle">Record check-in or check-out time for staff members.</div>
            </div>
            <button class="modal-close" onclick="closeModal('recordTimeModal')">✕</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Staff Member</label>
                <div class="select-wrap">
                    <div class="select-trigger" onclick="toggleSelect('recordStaffSelect')">
                        <span id="recordStaffText" style="color:#9ca3af;">Select staff member</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="select-content" id="recordStaffSelect">
                        <div class="select-item" onclick="setSelectVal('recordStaffSelect','recordStaffText','Dr. Nakato Sarah')">Dr. Nakato Sarah</div>
                        <div class="select-item" onclick="setSelectVal('recordStaffSelect','recordStaffText','Dr. Mwangi Peter')">Dr. Mwangi Peter</div>
                        <div class="select-item" onclick="setSelectVal('recordStaffSelect','recordStaffText','Nurse Namyalo Emma')">Nurse Namyalo Emma</div>
                        <div class="select-item" onclick="setSelectVal('recordStaffSelect','recordStaffText','Ssentongo James')">Ssentongo James</div>
                        <div class="select-item" onclick="setSelectVal('recordStaffSelect','recordStaffText','Nabwire Lisa')">Nabwire Lisa</div>
                        <div class="select-item" onclick="setSelectVal('recordStaffSelect','recordStaffText','Dr. Tumusiimeera Robert')">Dr. Tumusiimeera Robert</div>
                        <div class="select-item" onclick="setSelectVal('recordStaffSelect','recordStaffText','Nansubuga Sophia')">Nansubuga Sophia</div>
                        <div class="select-item" onclick="setSelectVal('recordStaffSelect','recordStaffText','Ssentongo Daniel')">Ssentongo Daniel</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Record Type</label>
                <div class="select-wrap">
                    <div class="select-trigger" onclick="toggleSelect('recordTypeSelect2')">
                        <span id="recordTypeText2">Check In</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="select-content" id="recordTypeSelect2">
                        <div class="select-item selected" onclick="setSelectVal('recordTypeSelect2','recordTypeText2','Check In')">Check In</div>
                        <div class="select-item" onclick="setSelectVal('recordTypeSelect2','recordTypeText2','Check Out')">Check Out</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="recordTimeInput">Time</label>
                <input type="time" id="recordTimeInput">
            </div>
            <div class="form-group">
                <label for="recordNotes">Notes (Optional)</label>
                <input type="text" id="recordNotes" placeholder="Add any additional notes">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('recordTimeModal')">Cancel</button>
            <button class="btn bg-primary hover:bg-primary/90" onclick="saveRecordTime()">Save Record</button>
        </div>
    </div>
</div>

<!-- Add Timesheet Modal -->
<div id="addTimesheetModal" class="modal-overlay" style="display:none;">
    <div class="modal-container">
        <div class="modal-header">
            <div>
                <div class="modal-title">Add Timesheet</div>
                <div class="modal-subtitle">Create a new timesheet entry for a staff member.</div>
            </div>
            <button class="modal-close" onclick="closeModal('addTimesheetModal')">✕</button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label>Staff Member</label>
                <div class="select-wrap">
                    <div class="select-trigger" onclick="toggleSelect('timesheetStaffSelect')">
                        <span id="timesheetStaffText" style="color:#9ca3af;">Select staff member</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="select-content" id="timesheetStaffSelect">
                        <div class="select-item" onclick="setSelectVal('timesheetStaffSelect','timesheetStaffText','Dr. Nakato Sarah')">Dr. Nakato Sarah</div>
                        <div class="select-item" onclick="setSelectVal('timesheetStaffSelect','timesheetStaffText','Dr. Mwangi Peter')">Dr. Mwangi Peter</div>
                        <div class="select-item" onclick="setSelectVal('timesheetStaffSelect','timesheetStaffText','Nurse Namyalo Emma')">Nurse Namyalo Emma</div>
                        <div class="select-item" onclick="setSelectVal('timesheetStaffSelect','timesheetStaffText','Ssentongo James')">Ssentongo James</div>
                        <div class="select-item" onclick="setSelectVal('timesheetStaffSelect','timesheetStaffText','Nabwire Lisa')">Nabwire Lisa</div>
                        <div class="select-item" onclick="setSelectVal('timesheetStaffSelect','timesheetStaffText','Dr. Tumusiimeera Robert')">Dr. Tumusiimeera Robert</div>
                        <div class="select-item" onclick="setSelectVal('timesheetStaffSelect','timesheetStaffText','Nansubuga Sophia')">Nansubuga Sophia</div>
                        <div class="select-item" onclick="setSelectVal('timesheetStaffSelect','timesheetStaffText','Ssentongo Daniel')">Ssentongo Daniel</div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="timesheetWeek">Week Starting</label>
                <input type="date" id="timesheetWeek">
            </div>
            <div class="grid-2">
                <div class="form-group">
                    <label for="timesheetHours">Total Hours</label>
                    <input type="text" id="timesheetHours" placeholder="e.g. 40">
                </div>
                <div class="form-group">
                    <label for="timesheetOvertime">Overtime Hours</label>
                    <input type="text" id="timesheetOvertime" placeholder="e.g. 2.5">
                </div>
            </div>
            <div class="form-group">
                <label>Department</label>
                <div class="select-wrap">
                    <div class="select-trigger" onclick="toggleSelect('timesheetDeptSelect')">
                        <span id="timesheetDeptText" style="color:#9ca3af;">Select department</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="select-content" id="timesheetDeptSelect">
                        <div class="select-item" onclick="setSelectVal('timesheetDeptSelect','timesheetDeptText','Medical')">Medical</div>
                        <div class="select-item" onclick="setSelectVal('timesheetDeptSelect','timesheetDeptText','Nursing')">Nursing</div>
                        <div class="select-item" onclick="setSelectVal('timesheetDeptSelect','timesheetDeptText','Laboratory')">Laboratory</div>
                        <div class="select-item" onclick="setSelectVal('timesheetDeptSelect','timesheetDeptText','Administration')">Administration</div>
                        <div class="select-item" onclick="setSelectVal('timesheetDeptSelect','timesheetDeptText','Pharmacy')">Pharmacy</div>
                        <div class="select-item" onclick="setSelectVal('timesheetDeptSelect','timesheetDeptText','IT')">IT</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('addTimesheetModal')">Cancel</button>
            <button class="btn bg-primary hover:bg-primary/90" onclick="saveTimesheet()">Save Timesheet</button>
        </div>
    </div>
</div>

<!-- Timesheet Details Modal -->
<div id="timesheetDetailsModal" class="modal-overlay" style="display:none;">
    <div class="modal-container modal-lg">
        <div class="modal-header">
            <div>
                <div class="modal-title">Timesheet Details</div>
                <div class="modal-subtitle" id="timesheetDetailsSubtitle">Viewing timesheet details.</div>
            </div>
            <button class="modal-close" onclick="closeModal('timesheetDetailsModal')">✕</button>
        </div>
        <div class="modal-body">
            <div id="timesheetDetailsBody"></div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal('timesheetDetailsModal')">Close</button>
            <button class="btn bg-primary text-white" onclick="printTimesheet()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
                Print
            </button>
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

<!-- 4. Main Init (last) -->
<script src="js/init.js"></script>


<script>
    //new addition
    // === SIDEBAR TOGGLE WITH FULL WIDTH HEADER ===
    const menuBtn = document.querySelector('header button:first-child');
    const sidebar = document.querySelector('aside');
    const closeSidebarBtn = document.querySelector('aside .xl\\:hidden');
    const headerLogo = document.getElementById('headerLogo');

    function isMobileView() {
        return window.innerWidth < 1280;
    }

    function openSidebar() {
        if (sidebar) {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            localStorage.setItem('sidebarOpen', 'true');
            if (isMobileView()) {
                document.body.classList.add('sidebar-open');
                document.body.style.overflow = 'hidden';
            }
            updateHeaderAndMain();
        }
    }

    function closeSidebar() {
        if (sidebar) {
            sidebar.classList.add('-translate-x-full');
            sidebar.classList.remove('translate-x-0');
            localStorage.setItem('sidebarOpen', 'false');
            if (isMobileView()) {
                document.body.classList.remove('sidebar-open');
                document.body.style.overflow = '';
            }
            updateHeaderAndMain();
        }
    }

    function toggleSidebar() {
        if (!sidebar) return;
        const isOpen = !sidebar.classList.contains('-translate-x-full');
        if (isOpen) closeSidebar();
        else openSidebar();
    }

    function updateHeaderAndMain() {
        const header = document.querySelector('header');
        const main = document.querySelector('main');
        if (!header || !main) return;
        if (window.innerWidth >= 1280) {
            if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
                header.style.width = 'calc(100% - 16rem)';
                header.style.marginLeft = '16rem';
                main.style.marginLeft = '16rem';
                main.style.width = 'calc(100% - 16rem)';
                if (headerLogo) headerLogo.style.display = 'none';
            } else {
                header.style.width = '100%';
                header.style.marginLeft = '0';
                main.style.marginLeft = '0';
                main.style.width = '100%';
                if (headerLogo) headerLogo.style.display = 'flex';
            }
        } else {
            header.style.width = '100%';
            header.style.marginLeft = '0';
            main.style.marginLeft = '0';
            main.style.width = '100%';
            if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
                if (headerLogo) headerLogo.style.display = 'none';
            } else {
                if (headerLogo) headerLogo.style.display = 'flex';
            }
        }
    }

    function setupSidebar() {
        if (!sidebar) return;
        const isMobile = isMobileView();
        const savedState = localStorage.getItem('sidebarOpen');
        document.body.style.overflow = '';
        document.body.classList.remove('sidebar-open');
        if (isMobile) {
            closeSidebar();
        } else {
            if (savedState === 'false') closeSidebar();
            else openSidebar();
        }
        updateHeaderAndMain();
    }

    if (menuBtn) {
        const newMenuBtn = menuBtn.cloneNode(true);
        menuBtn.parentNode.replaceChild(newMenuBtn, menuBtn);
        newMenuBtn.addEventListener('click', (e) => { e.stopPropagation(); toggleSidebar(); });
    }
    if (closeSidebarBtn) {
        const newCloseBtn = closeSidebarBtn.cloneNode(true);
        closeSidebarBtn.parentNode.replaceChild(newCloseBtn, closeSidebarBtn);
        newCloseBtn.addEventListener('click', (e) => { e.stopPropagation(); closeSidebar(); });
    }

    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => { setupSidebar(); }, 150);
    });
    document.addEventListener('click', (e) => {
        if (isMobileView() && sidebar && !sidebar.classList.contains('-translate-x-full')) {
            if (!sidebar.contains(e.target) && !menuBtn?.contains(e.target)) closeSidebar();
        }
    });
    setupSidebar();
    const mainElement = document.querySelector('main');
    if (mainElement) mainElement.classList.remove('xl:ml-64');
    const headerDiv = document.querySelector('header > div');
    if (headerDiv) headerDiv.style.width = '100%';
    
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && sidebar && !sidebar.classList.contains('-translate-x-full')) closeSidebar();
        if (e.key === 'Escape') closeActionMenu();
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay').forEach(modal => modal.style.display = 'none');
            document.querySelectorAll('.select-content.open').forEach(s => s.classList.remove('open'));
        }
    });

    // === PERSISTENT THEME TOGGLE (with localStorage) ===
    (function() {
        const sunIcon = document.getElementById('sunIcon');
        const moonIcon = document.getElementById('moonIcon');
        const themeToggleBtn = document.getElementById('themeToggleBtn');
        function applyTheme(isDark) {
            if (isDark) {
                document.body.classList.add('dark');
                if (sunIcon && moonIcon) {
                    sunIcon.classList.remove('hidden');
                    moonIcon.classList.add('hidden');
                }
                localStorage.setItem('theme', 'dark');
            } else {
                document.body.classList.remove('dark');
                if (sunIcon && moonIcon) {
                    sunIcon.classList.add('hidden');
                    moonIcon.classList.remove('hidden');
                }
                localStorage.setItem('theme', 'light');
            }
            const activeTab = document.querySelector('.tab-btn[data-state="active"]')?.dataset.tab;
            if (activeTab === 'reports') renderChart();
        }
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') applyTheme(true);
        else if (savedTheme === 'light') applyTheme(false);
        else applyTheme(window.matchMedia('(prefers-color-scheme: dark)').matches);
        if (themeToggleBtn) {
            themeToggleBtn.addEventListener('click', () => {
                const isDark = document.body.classList.contains('dark');
                applyTheme(!isDark);
            });
        }
    })();

    // Notifications & Profile Dropdowns
    document.getElementById('notificationsBtn')?.addEventListener('click', (e) => {
        e.stopPropagation();
        document.getElementById('notificationsDropdown').classList.toggle('hidden');
        document.getElementById('profileDropdown').classList.add('hidden');
    });
    document.getElementById('profileBtn')?.addEventListener('click', (e) => {
        e.stopPropagation();
        document.getElementById('profileDropdown').classList.toggle('hidden');
        document.getElementById('notificationsDropdown').classList.add('hidden');
    });
    document.getElementById('markAllReadBtn')?.addEventListener('click', () => showToast("All marked as read"));

    // Sidebar Accordions
    document.querySelectorAll('.dashboard-toggle, .doctors-toggle, .appointments-toggle, .prescriptions-toggle, .ambulance-toggle, .laboratory-toggle, .bloodbank-toggle, .billing-toggle, .departments-toggle, .inventory-toggle, .staff-toggle, .records-toggle, .rooms-toggle, .reviews-toggle, .reports-toggle, .settings-toggle, .auth-toggle').forEach(btn => {
        btn.addEventListener('click', () => {
            const sub = btn.nextElementSibling;
            const arrow = btn.querySelector('.transition-transform');
            if (sub && sub.classList.contains('hidden')) {
                sub.classList.remove('hidden');
                if (arrow) arrow.style.transform = 'rotate(180deg)';
            } else if (sub) {
                sub.classList.add('hidden');
                if (arrow) arrow.style.transform = 'rotate(0deg)';
            }
        });
    });

    // ===== DATA =====
    const staffMembers = [
        { id:1, name:"Dr. Nakato Sarah", initials:"SJ", department:"Medical", role:"Cardiologist", status:"Present", checkIn:"08:45 AM", checkOut:"05:30 PM", hours:8.75 },
        { id:2, name:"Dr. Mwangi Peter", initials:"MC", department:"Medical", role:"Neurologist", status:"Present", checkIn:"09:15 AM", checkOut:"06:00 PM", hours:8.75 },
        { id:3, name:"Nurse Namyalo Emma", initials:"EW", department:"Nursing", role:"Head Nurse", status:"Present", checkIn:"08:00 AM", checkOut:"04:30 PM", hours:8.5 },
        { id:4, name:"Ssentongo James", initials:"JR", department:"Laboratory", role:"Lab Technician", status:"Present", checkIn:"08:30 AM", checkOut:"05:00 PM", hours:8.5 },
        { id:5, name:"Nabwire Lisa", initials:"LT", department:"Administration", role:"Receptionist", status:"Present", checkIn:"08:55 AM", checkOut:"05:15 PM", hours:8.33 },
        { id:6, name:"Dr. Tumusiimeera Robert", initials:"RD", department:"Medical", role:"Pediatrician", status:"Late", checkIn:"10:30 AM", checkOut:"06:45 PM", hours:8.25 },
        { id:7, name:"Nansubuga Sophia", initials:"SM", department:"Pharmacy", role:"Pharmacist", status:"Absent", checkIn:"-", checkOut:"-", hours:0 },
        { id:8, name:"Ssentongo Daniel", initials:"DL", department:"IT", role:"IT Support", status:"On Leave", checkIn:"-", checkOut:"-", hours:0 }
    ];

    const timesheetData = [
        { name:"Dr. Nakato Sarah", initials:"SJ", dept:"Medical", week:"May 15, 2023", hours:42.5, ot:2.5, status:"Pending" },
        { name:"Nurse Namyalo Emma", initials:"EW", dept:"Nursing", week:"May 15, 2023", hours:40.0, ot:0.0, status:"Approved" },
        { name:"Ssentongo James", initials:"JR", dept:"Laboratory", week:"May 15, 2023", hours:38.5, ot:0.0, status:"Approved" },
        { name:"Dr. Mwangi Peter", initials:"MC", dept:"Medical", week:"May 8, 2023", hours:45.0, ot:5.0, status:"Approved" },
        { name:"Nabwire Lisa", initials:"LT", dept:"Administration", week:"May 8, 2023", hours:39.5, ot:0.0, status:"Approved" }
    ];

    const leaveData = [
        { id:1, name:"Dr. Nakato Sarah", initials:"SJ", dept:"Medical", type:"Annual Leave", duration:"7 days", dates:"May 20 – May 26", status:"Approved" },
        { id:2, name:"Ssentongo Daniel", initials:"DL", dept:"IT", type:"Sick Leave", duration:"3 days", dates:"May 13 – May 15", status:"Approved" },
        { id:3, name:"Nansubuga Sophia", initials:"SM", dept:"Pharmacy", type:"Personal", duration:"1 day", dates:"May 17", status:"Pending" }
    ];

    // ==================== SHIFT VIEW DATA (MUST be before renderShiftView) ====================
    const nurseStaff = [
        { id: 1, name: "Namyalo Emma", initials: "ER", role: "Head Nurse", department: "Nursing" },
        { id: 2, name: "Byaruhanga Robert", initials: "RD", role: "Senior Nurse", department: "Nursing" },
        { id: 3, name: "Nabwire Lisa", initials: "LT", role: "Mid wife", department: "Maternity" },
        { id: 4, name: "Ssentongo James", initials: "JB", role: "Junior Nurse", department: "Nursing" },
        { id: 5, name: "Nabisere Maria", initials: "MG", role: "Junior Nurse", department: "Nursing" },
        { id: 6, name: "Ssentongo Daniel", initials: "DL", role: "Staff Nurse", department: "Nursing" },
        { id: 7, name: "Nansubuga Sophia", initials: "SM", role: "Junior Nurse", department: "Nursing" },
        { id: 8, name: "Ssentongo William", initials: "WT", role: "Staff Nurse", department: "Nursing" }
    ];

    const shiftLabels = { morning: "07:00-15:00", evening: "15:00-23:00", night: "23:00-07:00", off: "Off" };
    const shiftClasses = { morning: "shift-morning", evening: "shift-evening", night: "shift-night", off: "" };

    const nurseWards = {
        1: "ICU & Cardiology", 2: "General Ward A", 3: "General Ward B", 4: "Pediatrics",
        5: "Maternity", 6: "Emergency", 7: "ICU & Cardiology", 8: "General Ward A"
    };

    const nursePatientCount = { 1: 4, 2: 8, 3: 7, 4: 5, 5: 6, 6: 9, 7: 5, 8: 8 };

    const nurseWardExpertise = {
        1: ["ICU & Cardiology", "Emergency", "General Ward A"],
        2: ["General Ward A", "General Ward B", "Maternity"],
        3: ["General Ward B", "Emergency", "ICU & Cardiology"],
        4: ["Pediatrics", "Maternity", "General Ward A"],
        5: ["Maternity", "Pediatrics", "General Ward B"],
        6: ["Emergency", "ICU & Cardiology", "General Ward A"],
        7: ["ICU & Cardiology", "Emergency", "Pediatrics"],
        8: ["General Ward A", "General Ward B", "Rehabilitation Center"]
    };

    const demoShiftData = {
        1: { 0: "morning", 1: "morning", 2: "morning", 3: "morning", 4: "morning", 5: "off", 6: "off" },
        2: { 0: "evening", 1: "evening", 2: "evening", 3: "evening", 4: "evening", 5: "morning", 6: "off" },
        3: { 0: "night", 1: "night", 2: "off", 3: "night", 4: "night", 5: "off", 6: "night" },
        4: { 0: "off", 1: "morning", 2: "morning", 3: "off", 4: "evening", 5: "evening", 6: "evening" },
        5: { 0: "morning", 1: "off", 2: "evening", 3: "evening", 4: "off", 5: "night", 6: "night" },
        6: { 0: "evening", 1: "night", 2: "night", 3: "off", 4: "off", 5: "morning", 6: "morning" },
        7: { 0: "night", 1: "off", 2: "off", 3: "morning", 4: "morning", 5: "evening", 6: "evening" },
        8: { 0: "off", 1: "evening", 2: "evening", 3: "night", 4: "night", 5: "off", 6: "off" }
    };

    let shiftWeekStart = new Date(2023, 5, 12); // June 12, 2023
    let shiftData = demoShiftData;

    function generateShiftData(weekStart) {
        return demoShiftData;
    }

    let deptFilter = "all";
    let activeDropdown = null;

    // ===== TABS =====
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-btn').forEach(b => b.setAttribute('data-state','inactive'));
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            btn.setAttribute('data-state','active');
            document.getElementById('tab-'+btn.dataset.tab).classList.add('active');
            if(btn.dataset.tab === 'reports') {
                setTimeout(() => renderChart(), 100);
            }
            if(btn.dataset.tab === 'calendar') renderCalendar();
            if(btn.dataset.tab === 'shifts') renderShiftView();
        });
    });

    // ===== INNER TABS (History Modal) =====
    document.querySelectorAll('.inner-tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.inner-tab-btn').forEach(b => b.setAttribute('data-state','inactive'));
            document.querySelectorAll('.inner-tab-panel').forEach(p => p.classList.remove('active'));
            btn.setAttribute('data-state','active');
            document.getElementById(btn.dataset.innerTab).classList.add('active');
        });
    });

    // ===== SELECT HELPERS =====
    function toggleSelect(id) {
        const el = document.getElementById(id);
        const isOpen = el.classList.contains('open');
        document.querySelectorAll('.select-content.open').forEach(s => s.classList.remove('open'));
        if(!isOpen) el.classList.add('open');
    }
    function setSelectVal(selectId, textId, value) {
        document.getElementById(textId).textContent = value;
        document.getElementById(textId).style.color = '';
        document.querySelectorAll(`#${selectId} .select-item`).forEach(i => i.classList.remove('selected'));
        event.target.classList.add('selected');
        document.getElementById(selectId).classList.remove('open');
    }
    document.addEventListener('click', e => {
        if(!e.target.closest('.select-wrap')) document.querySelectorAll('.select-content.open').forEach(s => s.classList.remove('open'));
    });

    // ===== DEPT FILTER =====
    function setDeptFilter(val, label) {
        deptFilter = val;
        document.getElementById('deptFilterText').textContent = label;
        document.querySelectorAll('#deptSelect .select-item').forEach(i => i.classList.remove('selected'));
        event.target.classList.add('selected');
        document.getElementById('deptSelect').classList.remove('open');
        renderDailyTable();
    }

    // ===== BADGE HELPERS =====
    function getStatusBadge(status) {
        const icons = {
            Present: `<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>`,
            Late: `<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M12 16h.01"/><path d="M12 8v4"/><path d="M15.312 2a2 2 0 0 1 1.414.586l4.688 4.688A2 2 0 0 1 22 8.688v6.624a2 2 0 0 1-.586 1.414l-4.688 4.688a2 2 0 0 1-1.414.586H8.688a2 2 0 0 1-1.414-.586l-4.688-4.688A2 2 0 0 1 2 15.312V8.688a2 2 0 0 1 .586-1.414l4.688-4.688A2 2 0 0 1 8.688 2z"/></svg>`,
            Absent: `<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>`,
            'On Leave': `<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16.5 12"/></svg>`
        };
        const cls = { Present:'badge-green', Late:'badge-amber', Absent:'badge-red', 'On Leave':'badge-blue' };
        return `<span class="badge ${cls[status]||'badge-gray'}">${icons[status]||''}${status}</span>`;
    }

    function getTimesheetBadge(status) {
        const cls = status === 'Approved' ? 'badge-green' : 'badge-gray';
        return `<span class="badge ${cls}">${status === 'Approved' ? 'Approved' : 'Pending Approval'}</span>`;
    }

    function getLeaveBadge(status) {
        const cls = status === 'Approved' ? 'badge-green' : (status === 'Pending' ? 'badge-gray' : 'badge-red');
        return `<span class="badge ${cls}">${status}</span>`;
    }

    function clockCell(t) {
        if(t === '-') return '<span style="color:#9ca3af;">-</span>';
        return `<span class="clock-icon"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" ><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16.5 12"/></svg>${t}</span>`;
    }

    // ===== RENDER DAILY TABLE =====
    function renderDailyTable() {
        const q = document.getElementById('dailySearch').value.toLowerCase();
        const filtered = staffMembers.filter(s =>
            s.name.toLowerCase().includes(q) && (deptFilter === 'all' || s.department === deptFilter)
        );
        document.getElementById('dailyTableBody').innerHTML = filtered.map(s => `
            <tr>
                <td><div class="staff-cell"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span><span class="staff-name">${s.name}</span></div></td>
                <td>${s.department}</td>
                <td class="hide-mobile">${s.role}</td>
                <td>${clockCell(s.checkIn)}</td>
                <td>${clockCell(s.checkOut)}</td>
                <td class="hide-mobile">${s.hours}</td>
                <td>${getStatusBadge(s.status)}</td>
                <td style="text-align:right;">
                    <button class="btn btn-ghost btn-icon" onclick="openActionMenu(event,${s.id})">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                    </button>
                </td>
            </tr>
        `).join('');
    }

    function renderTimesheetTable() {
        document.getElementById('timesheetTableBody').innerHTML = timesheetData.map(t => `
            <tr>
                <td><div class="staff-cell"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span><span class="staff-name">${t.name}</span></div></td>
                <td>${t.dept}</td>
                <td>${t.week}</td>
                <td>${t.hours}</td>
                <td class="hide-mobile">${t.ot}</td>
                <td>${getTimesheetBadge(t.status)}</td>
                <td style="text-align:right;"><button class="btn btn-ghost btn-sm" onclick="openTimesheetDetails('${t.name}','${t.dept}','${t.week}','${t.hours}','${t.ot}','${t.status}')"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>View</button></td>
            </tr>
        `).join('');
    }

    function renderLeaveTable() {
        document.getElementById('leaveTableBody').innerHTML = leaveData.map(l => `
            <tr>
                <td><div class="staff-cell"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span><span class="staff-name">${l.name}</span></div></td>
                <td class="hide-mobile">${l.dept}</td>
                <td>${l.type}</td>
                <td>${l.duration}</td>
                <td class="hide-mobile">${l.dates}</td>
                <td>${getLeaveBadge(l.status)}</td>
                <td style="text-align:right;">
                    <button class="btn btn-ghost btn-icon" onclick="openLeaveActionMenu(event,${l.id})">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" ><circle cx="12" cy="12" r="1"/><circle cx="19" cy="12" r="1"/><circle cx="5" cy="12" r="1"/></svg>
                    </button>
                </td>
            </tr>
        `).join('');
    }

    // ==================== MODERN ACTION MENU ====================
    let activeActionMenu = null;

    function closeActionMenu() { 
        if (activeActionMenu) { 
            activeActionMenu.remove(); 
            activeActionMenu = null; 
        } 
    }

    function openActionMenu(e, staffId) {
        e.stopPropagation();
        closeActionMenu();
        const staff = staffMembers.find(s => s.id === staffId);
        const rect = e.currentTarget.getBoundingClientRect();
        const menu = document.createElement('div');
        menu.className = 'action-menu';
        let left = rect.left;
        let top = rect.bottom + 6;
        if (left + 220 > window.innerWidth) left = window.innerWidth - 230;
        if (top + 230 > window.innerHeight) top = rect.top - 240;
        menu.style.top = `${top}px`;
        menu.style.left = `${left}px`;
        menu.innerHTML = `
            <div class="action-menu-header">Actions</div>
            <button data-action="edit" class="action-item">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Edit Time
            </button>
            <button data-action="note" class="action-item">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                Add Note
            </button>
            <div class="action-divider"></div>
            <button data-action="history" class="action-item">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 7.5V6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h3.5"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h5"/><path d="M17.5 17.5 16 16.3V14"/><circle cx="16" cy="16" r="6"/></svg>
                View History
            </button>
        `;
        document.body.appendChild(menu);
        activeActionMenu = menu;
        
        const closeHandler = (e) => { if (!menu.contains(e.target) && e.target !== e.currentTarget) { closeActionMenu(); document.removeEventListener('click', closeHandler); } };
        setTimeout(() => document.addEventListener('click', closeHandler), 10);
        
        menu.querySelector('[data-action="edit"]')?.addEventListener('click', () => { openEditTime(staff.name); closeActionMenu(); });
        menu.querySelector('[data-action="note"]')?.addEventListener('click', () => { openAddNote(staff.name); closeActionMenu(); });
        menu.querySelector('[data-action="history"]')?.addEventListener('click', () => { openHistory(staff.name, staff.role, staff.department); closeActionMenu(); });
    }

    function openLeaveActionMenu(e, leaveId) {
        e.stopPropagation();
        closeActionMenu();
        const leave = leaveData.find(l => l.id === leaveId);
        const rect = e.currentTarget.getBoundingClientRect();
        const menu = document.createElement('div');
        menu.className = 'action-menu';
        let left = rect.left;
        let top = rect.bottom + 6;
        if (left + 220 > window.innerWidth) left = window.innerWidth - 230;
        if (top + 230 > window.innerHeight) top = rect.top - 240;
        menu.style.top = `${top}px`;
        menu.style.left = `${left}px`;
        menu.innerHTML = `
            <div class="action-menu-header">Actions</div>
            <button data-action="view" class="action-item">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"/><circle cx="12" cy="12" r="3"/></svg>
                View Details
            </button>
            <div class="action-divider"></div>
            <button data-action="approve" class="action-item text-green-600">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Approve Request
            </button>
            <button data-action="reject" class="action-item text-red-600">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="18" y1="6" x2="6" y2="18"/></svg>
                Reject Request
            </button>
        `;
        document.body.appendChild(menu);
        activeActionMenu = menu;
        
        const closeHandler = (e) => { if (!menu.contains(e.target) && e.target !== e.currentTarget) { closeActionMenu(); document.removeEventListener('click', closeHandler); } };
        setTimeout(() => document.addEventListener('click', closeHandler), 10);
        
        menu.querySelector('[data-action="view"]')?.addEventListener('click', () => { openLeaveDetails(leaveId); closeActionMenu(); });
        menu.querySelector('[data-action="approve"]')?.addEventListener('click', () => { 
            leave.status = 'Approved';
            renderLeaveTable();
            showToast(`Leave request for ${leave.name} approved`);
            closeActionMenu();
        });
        menu.querySelector('[data-action="reject"]')?.addEventListener('click', () => { 
            leave.status = 'Rejected';
            renderLeaveTable();
            showToast(`Leave request for ${leave.name} rejected`);
            closeActionMenu();
        });
    }

    // ===== MODALS =====
    function openModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }
    function saveModal(id, msg) { closeModal(id); showToast(msg); }

    function openEditTime(name) {
        document.getElementById('editTimeSubtitle').textContent = `Update check-in or check-out time for ${name}.`;
        document.getElementById('editDate').value = new Date().toISOString().split('T')[0];
        openModal('editTimeModal');
    }

    function openAddNote(name) {
        document.getElementById('addNoteSubtitle').textContent = `Add a note to ${name}'s attendance record.`;
        document.getElementById('noteText').value = '';
        openModal('addNoteModal');
    }

    function openHistory(name, role, dept) {
        document.getElementById('historySubtitle').textContent = `Viewing attendance history for ${name} (${role} - ${dept})`;
        document.querySelectorAll('.inner-tab-btn').forEach((b,i) => b.setAttribute('data-state', i===0?'active':'inactive'));
        document.querySelectorAll('.inner-tab-panel').forEach((p,i) => { p.classList.toggle('active', i===0); });
        openModal('historyModal');
    }

    function openLeaveDetails(leaveId) {
        const l = leaveData.find(x => x.id === leaveId);
        document.getElementById('leaveDetailsSubtitle').textContent = `${l.name} - ${l.type}`;
        document.getElementById('leaveDetailsBody').innerHTML = `
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div><div style="font-size:.75rem;color:#9ca3af;">Staff</div><div style="font-weight:500;">${l.name}</div></div>
                <div><div style="font-size:.75rem;color:#9ca3af;">Department</div><div style="font-weight:500;">${l.dept}</div></div>
                <div><div style="font-size:.75rem;color:#9ca3af;">Leave Type</div><div style="font-weight:500;">${l.type}</div></div>
                <div><div style="font-size:.75rem;color:#9ca3af;">Duration</div><div style="font-weight:500;">${l.duration}</div></div>
                <div><div style="font-size:.75rem;color:#9ca3af;">Dates</div><div style="font-weight:500;">${l.dates}</div></div>
                <div><div style="font-size:.75rem;color:#9ca3af;">Status</div>${getLeaveBadge(l.status)}</div>
            </div>
        `;
        openModal('leaveDetailsModal');
    }

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => { if(e.target === overlay) overlay.style.display = 'none'; });
    });

    document.getElementById('newLeaveRequestBtn').addEventListener('click', () => {
        document.getElementById('leaveStaffText').textContent = 'Select staff member';
        document.getElementById('leaveStaffText').style.color = '#9ca3af';
        document.getElementById('leaveTypeText').textContent = 'Select leave type';
        document.getElementById('leaveTypeText').style.color = '#9ca3af';
        openModal('leaveRequestModal');
    });

    function showToast(message, isError = false) {
        const existing = document.querySelector('.toast-message');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.className = `toast-message ${isError ? 'error' : ''}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // Date picker
    const dateRangeTrigger = document.getElementById('dateRangeBtn');
    const datePickerPopover = document.getElementById('datePickerPopover');
    let isDatePickerOpen = false;
    function openDatePicker() { datePickerPopover.classList.remove('hidden'); dateRangeTrigger.setAttribute('data-state', 'open'); isDatePickerOpen = true; }
    function closeDatePicker() { datePickerPopover.classList.add('hidden'); dateRangeTrigger.setAttribute('data-state', 'closed'); isDatePickerOpen = false; }
    dateRangeTrigger.addEventListener('click', (e) => { e.stopPropagation(); isDatePickerOpen ? closeDatePicker() : openDatePicker(); });
    document.getElementById('applyDateBtn').addEventListener('click', () => {
        const start = document.getElementById('startDate').value;
        const end = document.getElementById('endDate').value;
        if (start && end) {
            const startDate = new Date(start);
            const endDate = new Date(end);
            document.getElementById('dateRangeText').innerText = `${startDate.toLocaleDateString()} - ${endDate.toLocaleDateString()}`;
            const event = new CustomEvent('dateRangeChange', { detail: { start, end } });
            document.dispatchEvent(event);
        }
        closeDatePicker();
    });
    document.getElementById('cancelDateBtn').addEventListener('click', closeDatePicker);
    document.addEventListener('click', (e) => { if (!dateRangeTrigger.contains(e.target) && !datePickerPopover.contains(e.target)) closeDatePicker(); });
    const today = new Date();
    const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
    const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    document.getElementById('startDate').value = firstDay.toISOString().slice(0, 10);
    document.getElementById('endDate').value = lastDay.toISOString().slice(0, 10);

    // Calendar
    let calDate = new Date(2023, 4, 1);
    const calendarData = {};
    staffMembers.forEach(s => {
        calendarData[s.name] = {};
        for(let d = 1; d <= 31; d++) {
            const dow = new Date(2023, 4, d).getDay();
            if(dow === 0 || dow === 6) { calendarData[s.name][d] = 'weekend'; continue; }
            const r = Math.random();
            if(s.status === 'Absent' && d === 17) calendarData[s.name][d] = 'absent';
            else if(s.status === 'On Leave' && d >= 13 && d <= 15) calendarData[s.name][d] = 'leave';
            else if(r < 0.06) calendarData[s.name][d] = 'absent';
            else if(r < 0.12) calendarData[s.name][d] = 'late';
            else calendarData[s.name][d] = 'present';
        }
    });

    function renderCalendar() {
        const year = calDate.getFullYear(), month = calDate.getMonth();
        const daysInMonth = new Date(year, month+1, 0).getDate();
        document.getElementById('calMonthYear').textContent = calDate.toLocaleString('default',{month:'long',year:'numeric'});
        const days = Array.from({length:daysInMonth},(_,i)=>i+1);
        const iconPresent = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>`;
        const iconAbsent = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>`;
        const iconLate = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2.5"><path d="M12 16h.01"/><path d="M12 8v4"/><path d="M15.312 2a2 2 0 0 1 1.414.586l4.688 4.688A2 2 0 0 1 22 8.688v6.624a2 2 0 0 1-.586 1.414l-4.688 4.688a2 2 0 0 1-1.414.586H8.688a2 2 0 0 1-1.414-.586l-4.688-4.688A2 2 0 0 1 2 15.312V8.688a2 2 0 0 1 .586-1.414l4.688-4.688A2 2 0 0 1 8.688 2z"/></svg>`;
        const iconLeave = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16.5 12"/></svg>`;
        const iconWeekend = `<span style="display:inline-block;width:8px;height:8px;border-radius:50%;background:#e5e7eb;"></span>`;
        const dayHeaders = days.map(d => `<th style="text-align:center;padding:4px;min-width:38px;font-size:.75rem;">${d}</th>`).join('');
        const rows = staffMembers.map(s => {
            const cells = days.map(d => {
                const state = calendarData[s.name]?.[d] || 'present';
                let icon = iconWeekend;
                if(state === 'present') icon = iconPresent;
                else if(state === 'absent') icon = iconAbsent;
                else if(state === 'late') icon = iconLate;
                else if(state === 'leave') icon = iconLeave;
                return `<td style="text-align:center;padding:4px;">${icon}</td>`;
            }).join('');
            return `<tr>
                <td class="calendar-staff-col"><div class="staff-cell"><span class="relative flex h-10 w-10 shrink-0 overflow-hidden rounded-full"><img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo"></span><span class="staff-name">${s.name}</span></div></td>
                ${cells}
            </tr>`;
        }).join('');
        document.getElementById('calendarContainer').innerHTML = `
            <table>
                <thead><tr><th class="calendar-staff-col" style="min-width:220px;">Staff</th>${dayHeaders}</tr></thead>
                <tbody>${rows}</tbody>
            </table>
        `;
    }

    document.getElementById('prevMonthBtn').addEventListener('click', () => { calDate.setMonth(calDate.getMonth()-1); renderCalendar(); });
    document.getElementById('nextMonthBtn').addEventListener('click', () => { calDate.setMonth(calDate.getMonth()+1); renderCalendar(); });

    // ===== APEX CHARTS – Monthly Attendance Trends =====
    let attendanceChartInstance = null;

    function renderChart() {
        const el = document.getElementById('attendanceChart');
        if (!el) return;
        if (attendanceChartInstance) {
            attendanceChartInstance.destroy();
            attendanceChartInstance = null;
        }
        const isDark = document.body.classList.contains('dark');
        const textColor = isDark ? '#e5e5e5' : '#374151';
        const gridColor = isDark ? '#2a2a2a' : '#e5e7eb';
        
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const presentData = [92, 88, 95, 90, 93, 91, 94, 89, 96, 92, 88, 93];
        const absentData = [3, 5, 2, 4, 3, 4, 2, 5, 1, 3, 6, 3];
        const lateData = [3, 4, 2, 4, 2, 3, 2, 4, 2, 3, 4, 2];
        const leaveDataPoints = [2, 3, 1, 2, 2, 2, 2, 2, 1, 2, 2, 2];

        const options = {
            chart: {
                type: 'area', height: 300, background: 'transparent',
                toolbar: { show: true, tools: { download: true, zoom: false, zoomin: false, zoomout: false, pan: false, reset: false } },
                zoom: { enabled: false }, fontFamily: 'Inter, system-ui, sans-serif',
            },
            theme: { mode: isDark ? 'Dark' : 'Light' },
            series: [
                { name: 'Present', data: presentData },
                { name: 'Absent', data: absentData },
                { name: 'Late', data: lateData },
                { name: 'On Leave', data: leaveDataPoints }
            ],
            xaxis: {
                categories: months,
                labels: { style: { colors: textColor, fontSize: '12px' }, rotate: 0 },
                axisBorder: { color: gridColor }, axisTicks: { color: gridColor },
                title: { text: 'Month', style: { color: textColor } }
            },
            yaxis: {
                labels: { style: { colors: textColor }, formatter: (val) => val + '%' },
                title: { text: 'Percentage of Staff', style: { color: textColor } },
                max: 100, min: 0,
            },
            colors: ['#10b981', '#ef4444', '#f59e0b', '#3b82f6'],
            stroke: { curve: 'smooth', width: 2.5 },
            fill: { type: 'gradient', gradient: { shadeIntensity: 0.5, opacityFrom: 0.35, opacityTo: 0.05, stops: [0, 100] } },
            legend: {
                position: 'top', labels: { colors: textColor, useSeriesColors: false },
                markers: { width: 12, height: 12, radius: 4 }, itemMargin: { horizontal: 10 }
            },
            grid: { borderColor: gridColor, strokeDashArray: 4, padding: { top: 10, right: 10, bottom: 5, left: 10 } },
            tooltip: { theme: isDark ? 'Dark' : 'Light', y: { formatter: (val) => val + '%' }, shared: true },
            dataLabels: { enabled: false },
            markers: { size: 3, hover: { size: 5 } },
        };
        attendanceChartInstance = new ApexCharts(el, options);
        attendanceChartInstance.render();
    }

    window.addEventListener('resize', () => {
        const activeTab = document.querySelector('.tab-btn[data-state="active"]')?.dataset.tab;
        if (activeTab === 'reports' && attendanceChartInstance) {
            attendanceChartInstance.render();
        }
    });

    function exportDailyCSV() {
        const headers = ['Name','Department','Role','Check In','Check Out','Hours','Status'];
        const rows = staffMembers.map(s => [s.name,s.department,s.role,s.checkIn,s.checkOut,s.hours,s.status]);
        const csv = [headers,...rows].map(r => r.join(',')).join('\n');
        const a = document.createElement('a');
        a.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
        a.download = 'attendance.csv';
        a.click();
        showToast('CSV exported');
    }

    function printDailyTable() { window.print(); }

    function saveRecordTime() {
        const staff = document.getElementById('recordStaffText').textContent;
        const type = document.getElementById('recordTypeText2').textContent;
        const time = document.getElementById('recordTimeInput').value;
        if (staff === 'Select staff member') { showToast('Please select a staff member', true); return; }
        if (!time) { showToast('Please select a time', true); return; }
        const [hours, minutes] = time.split(':');
        const h = parseInt(hours);
        const ampm = h >= 12 ? 'PM' : 'AM';
        const h12 = h % 12 || 12;
        const timeStr = `${h12}:${minutes} ${ampm}`;
        const staffMember = staffMembers.find(s => s.name === staff);
        if (staffMember) {
            if (type === 'Check In') staffMember.checkIn = timeStr;
            else staffMember.checkOut = timeStr;
            staffMember.status = 'Present';
            renderDailyTable();
            updateStats();
        }
        closeModal('recordTimeModal');
        showToast(`${type} recorded for ${staff}`);
        document.getElementById('recordStaffText').textContent = 'Select staff member';
        document.getElementById('recordStaffText').style.color = '#9ca3af';
        document.getElementById('recordTimeInput').value = '';
        document.getElementById('recordNotes').value = '';
    }

    function saveTimesheet() {
        const staff = document.getElementById('timesheetStaffText').textContent;
        const week = document.getElementById('timesheetWeek').value;
        const hours = document.getElementById('timesheetHours').value;
        const overtime = document.getElementById('timesheetOvertime').value;
        const dept = document.getElementById('timesheetDeptText').textContent;
        if (staff === 'Select staff member') { showToast('Please select a staff member', true); return; }
        if (!week) { showToast('Please select a week', true); return; }
        if (!hours) { showToast('Please enter total hours', true); return; }
        const dateObj = new Date(week + 'T00:00:00');
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        const formattedDate = `${monthNames[dateObj.getMonth()]} ${dateObj.getDate()}, ${dateObj.getFullYear()}`;
        const initials = staff.split(' ').map(n => n[0]).join('').substring(0, 2);
        timesheetData.unshift({
            name: staff, initials: initials,
            dept: dept !== 'Select department' ? dept : 'Medical',
            week: formattedDate, hours: parseFloat(hours),
            ot: parseFloat(overtime) || 0, status: 'Pending'
        });
        renderTimesheetTable();
        closeModal('addTimesheetModal');
        showToast('Timesheet added successfully');
        document.getElementById('timesheetStaffText').textContent = 'Select staff member';
        document.getElementById('timesheetStaffText').style.color = '#9ca3af';
        document.getElementById('timesheetDeptText').textContent = 'Select department';
        document.getElementById('timesheetDeptText').style.color = '#9ca3af';
        document.getElementById('timesheetWeek').value = '';
        document.getElementById('timesheetHours').value = '';
        document.getElementById('timesheetOvertime').value = '';
    }

    let currentTimesheetDetails = null;

    function openTimesheetDetails(name, dept, week, hours, ot, status) {
        currentTimesheetDetails = { name, dept, week, hours, ot, status };
        document.getElementById('timesheetDetailsSubtitle').textContent = `${name} - Week of ${week}`;
        
        const statusBadge = status === 'Approved' 
            ? '<span class="badge badge-green"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>Approved</span>' 
            : '<span class="badge badge-gray"><svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>Pending Approval</span>';
        
        const dailyBreakdown = [
            { day: 'Monday', date: getDateForDay(week, 0), hours: (parseFloat(hours) / 5).toFixed(1), overtime: (parseFloat(ot) / 5).toFixed(1) },
            { day: 'Tuesday', date: getDateForDay(week, 1), hours: (parseFloat(hours) / 5).toFixed(1), overtime: '0.0' },
            { day: 'Wednesday', date: getDateForDay(week, 2), hours: (parseFloat(hours) / 5).toFixed(1), overtime: (parseFloat(ot) / 5).toFixed(1) },
            { day: 'Thursday', date: getDateForDay(week, 3), hours: (parseFloat(hours) / 5).toFixed(1), overtime: '0.0' },
            { day: 'Friday', date: getDateForDay(week, 4), hours: (parseFloat(hours) / 5).toFixed(1), overtime: (parseFloat(ot) / 5).toFixed(1) },
            { day: 'Saturday', date: getDateForDay(week, 5), hours: '0.0', overtime: '0.0' },
            { day: 'Sunday', date: getDateForDay(week, 6), hours: '0.0', overtime: '0.0' },
        ];
        
        document.getElementById('timesheetDetailsBody').innerHTML = `
            <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;padding:1rem;background:#f9fafb;border-radius:0.75rem;border:1px solid #e5e7eb;">
                <span class="relative flex h-14 w-14 shrink-0 overflow-hidden rounded-full">
                    <img class="aspect-square h-full w-full object-cover" src="user.png" alt="User profile photo">
                </span>
                <div style="flex:1;">
                    <h3 style="font-size:1.125rem;font-weight:600;margin:0 0 0.25rem 0;">${name}</h3>
                    <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
                        <span style="display:flex;align-items:center;gap:0.375rem;font-size:0.8125rem;color:#6b7280;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9 22v-4h6v4"/></svg>
                            ${dept}
                        </span>
                        <span style="display:flex;align-items:center;gap:0.375rem;font-size:0.8125rem;color:#6b7280;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M3 10h18"/></svg>
                            Week of ${week}
                        </span>
                    </div>
                </div>
                <div>${statusBadge}</div>
            </div>
            
            <div style="display:grid;grid-template-columns:repeat(3, 1fr);gap:0.75rem;margin-bottom:1.5rem;">
                <div style="background:white;border:1px solid #e5e7eb;border-radius:0.5rem;padding:1rem;text-align:center;">
                    <div style="font-size:0.75rem;color:#6b7280;margin-bottom:0.25rem;">Total Hours</div>
                    <div style="font-size:1.75rem;font-weight:700;color:#2563eb;">${hours}</div>
                    <div style="font-size:0.75rem;color:#6b7280;">hours worked</div>
                </div>
                <div style="background:white;border:1px solid #e5e7eb;border-radius:0.5rem;padding:1rem;text-align:center;">
                    <div style="font-size:0.75rem;color:#6b7280;margin-bottom:0.25rem;">Overtime</div>
                    <div style="font-size:1.75rem;font-weight:700;color:#f59e0b;">${ot}</div>
                    <div style="font-size:0.75rem;color:#6b7280;">extra hours</div>
                </div>
                <div style="background:white;border:1px solid #e5e7eb;border-radius:0.5rem;padding:1rem;text-align:center;">
                    <div style="font-size:0.75rem;color:#6b7280;margin-bottom:0.25rem;">Daily Average</div>
                    <div style="font-size:1.75rem;font-weight:700;color:#10b981;">${(parseFloat(hours) / 5).toFixed(1)}</div>
                    <div style="font-size:0.75rem;color:#6b7280;">hours/day</div>
                </div>
            </div>
            
            <div style="background:white;border:1px solid #e5e7eb;border-radius:0.5rem;overflow:hidden;">
                <div style="padding:0.75rem 1rem;border-bottom:1px solid #e5e7eb;font-weight:600;font-size:0.875rem;background:#f9fafb;">Daily Breakdown</div>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>Day</th><th>Date</th><th>Regular</th><th>Overtime</th><th style="text-align:right;">Total</th></tr></thead>
                        <tbody>
                            ${dailyBreakdown.map((d, i) => {
                                const isWeekend = i >= 5;
                                const rowStyle = isWeekend ? 'opacity:0.5;' : '';
                                return `<tr style="${rowStyle}">
                                    <td style="font-weight:500;">${d.day}</td>
                                    <td style="color:#6b7280;font-size:0.8125rem;">${d.date}</td>
                                    <td>${d.hours}h</td>
                                    <td>${isWeekend ? '-' : d.overtime + 'h'}</td>
                                    <td style="text-align:right;font-weight:500;">${isWeekend ? '-' : (parseFloat(d.hours) + parseFloat(d.overtime)).toFixed(1) + 'h'}</td>
                                </tr>`;
                            }).join('')}
                        </tbody>
                        <tfoot>
                            <tr style="background:#f9fafb;font-weight:600;border-top:2px solid #e5e7eb;">
                                <td colspan="2">Weekly Total</td>
                                <td>${hours}h</td><td>${ot}h</td>
                                <td style="text-align:right;">${(parseFloat(hours) + parseFloat(ot)).toFixed(1)}h</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        `;
        openModal('timesheetDetailsModal');
    }

    function getDateForDay(weekStart, dayOffset) {
        const parts = weekStart.split(' ');
        const monthMap = { 'Jan': 0, 'Feb': 1, 'Mar': 2, 'Apr': 3, 'May': 4, 'Jun': 5, 'Jul': 6, 'Aug': 7, 'Sep': 8, 'Oct': 9, 'Nov': 10, 'Dec': 11 };
        let date;
        if (parts.length === 3) {
            const month = monthMap[parts[0]];
            const day = parseInt(parts[1]);
            const year = parseInt(parts[2]);
            date = new Date(year, month, day);
        } else {
            date = new Date();
        }
        date.setDate(date.getDate() + dayOffset);
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        return `${monthNames[date.getMonth()]} ${date.getDate()}`;
    }

    function printTimesheet() {
        if (currentTimesheetDetails) {
            showToast('Printing timesheet...');
            setTimeout(() => window.print(), 300);
        }
        closeModal('timesheetDetailsModal');
    }

    function updateStats() {
        const present = staffMembers.filter(s => s.status === 'Present' || s.status === 'Late').length;
        const absent = staffMembers.filter(s => s.status === 'Absent').length;
        const onLeave = staffMembers.filter(s => s.status === 'On Leave').length;
        const late = staffMembers.filter(s => s.status === 'Late').length;
        const statCards = document.querySelectorAll('.stat-card');
        if (statCards.length >= 4) {
            statCards[0].querySelector('.stat-value').textContent = present;
            statCards[1].querySelector('.stat-value').textContent = absent;
            statCards[2].querySelector('.stat-value').textContent = onLeave;
            statCards[3].querySelector('.stat-value').textContent = late;
        }
    }

    // ==================== RENDER SHIFT VIEW (with first-day support) ====================
    function renderShiftView() {
        const DAY_NAMES_SHORT = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
        
        let firstDayIndex = 0;
        if (window.MeditrackRegional && typeof window.MeditrackRegional.getFirstDayIndex === 'function') {
            firstDayIndex = window.MeditrackRegional.getFirstDayIndex();
        } else {
            const pref = localStorage.getItem('meditrack_first_day') || 'Sunday';
            if (pref === 'Monday') firstDayIndex = 1;
            else if (pref === 'Saturday') firstDayIndex = 6;
        }
        
        const currentDayOfWeek = shiftWeekStart.getDay();
        const offset = (currentDayOfWeek - firstDayIndex + 7) % 7;
        const weekStart = new Date(shiftWeekStart);
        weekStart.setDate(shiftWeekStart.getDate() - offset);
        
        const weekEnd = new Date(weekStart);
        weekEnd.setDate(weekStart.getDate() + 6);
        
        const shiftWeekHeaderEl = document.getElementById('shiftWeekHeader');
        if (shiftWeekHeaderEl) {
            shiftWeekHeaderEl.textContent = 
                `Week of ${weekStart.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} - ${weekEnd.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
        }

            // ADD THIS: Update the month label between nav arrows
    const shiftNavMonth = document.getElementById('shiftNavMonth');
    if (shiftNavMonth) {
        shiftNavMonth.textContent = weekStart.toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
    }
        
        const dayNames = [];
        const dayDates = [];
        const dayDateStrs = [];
        
        for (let i = 0; i < 7; i++) {
            const d = new Date(weekStart);
            d.setDate(weekStart.getDate() + i);
            const dayIndex = d.getDay();
            dayNames.push(DAY_NAMES_SHORT[dayIndex]);
            dayDates.push(d);
            dayDateStrs.push(
                d.getFullYear() + '-' + 
                String(d.getMonth() + 1).padStart(2, '0') + '-' + 
                String(d.getDate()).padStart(2, '0')
            );
        }
        
        const theadRow = document.querySelector('#shiftGridContainer thead tr');
        if (theadRow) {
            let headerHTML = '<th class="calendar-staff-col">Staff Name</th>';
            for (let i = 0; i < 7; i++) {
                const dateStr = dayDates[i].toLocaleDateString('en-US', { month: 'numeric', day: 'numeric' });
                headerHTML += `<th style="text-align:center;padding:8px;min-width:80px;font-size:0.75rem;" data-date="${dayDateStrs[i]}">
                    ${dayNames[i]}<br><span id="shiftDate${i}">${dateStr}</span>
                </th>`;
            }
            theadRow.innerHTML = headerHTML;
        }
        
        shiftData = generateShiftData(shiftWeekStart);
        
        const tbody = document.getElementById('shiftGridBody');
        if (!tbody) return;
        
        tbody.innerHTML = nurseStaff.map(nurse => {
            let cells = '';
            let morningCount = 0, eveningCount = 0, nightCount = 0;
            
            for (let d = 0; d < 7; d++) {
                const shift = shiftData[nurse.id]?.[d] || 'off';
                const cls = shiftClasses[shift] || '';
                const label = shiftLabels[shift] || 'Off';
                if (shift === 'morning') morningCount++;
                if (shift === 'evening') eveningCount++;
                if (shift === 'night') nightCount++;
                
                const today = new Date();
                const cellDate = dayDates[d];
                const isToday = today.toDateString() === cellDate.toDateString();
                const todayStyle = isToday ? 'background:#eef2ff;border-radius:6px;' : '';
                
                cells += `<td style="text-align:center;padding:6px;${todayStyle}" data-date="${dayDateStrs[d]}">
                    <span class="shift-block ${cls}">${label}</span>
                </td>`;
            }
            
            const totalHours = (morningCount + eveningCount + nightCount) * 8;
            const patients = nursePatientCount[nurse.id] || 0;
            const ward = nurseWards[nurse.id] || 'Unassigned';
            let workloadColor = patients >= 8 ? '#ef4444' : patients >= 6 ? '#f59e0b' : '#10b981';
            
            return `<tr style="border-bottom:1px solid #e5e7eb;">
                <td class="calendar-staff-col" style="padding:10px 12px;">
                    <div style="display:flex;flex-direction:column;gap:4px;">
                        <div style="font-weight:600;font-size:0.875rem;line-height:1.2;">${nurse.name}</div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span style="font-size:0.7rem;color:#6b7280;background:#f3f4f6;padding:1px 6px;border-radius:4px;font-weight:500;">${nurse.role}</span>
                            <span style="font-size:0.7rem;color:#6366f1;background:#eef2ff;padding:1px 6px;border-radius:4px;font-weight:500;display:flex;align-items:center;gap:3px;">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/></svg>
                                ${ward}
                            </span>
                        </div>
                        <div style="display:flex;align-items:center;gap:12px;margin-top:2px;">
                            <span style="display:flex;align-items:center;gap:4px;font-size:0.7rem;color:#6b7280;">
                                <span style="width:7px;height:7px;border-radius:50%;background:${workloadColor};display:inline-block;flex-shrink:0;"></span>
                                <span style="font-weight:500;">${patients}</span> pts
                            </span>
                            <span style="font-size:0.7rem;color:#9ca3af;font-weight:500;">${totalHours}h</span>
                        </div>
                    </div>
                </td>
                ${cells}
            </tr>`;
        }).join('');
        
        const summaryCells = [];
        for (let d = 0; d < 7; d++) {
            let morningCount = 0, eveningCount = 0, nightCount = 0;
            nurseStaff.forEach(nurse => {
                const shift = shiftData[nurse.id]?.[d] || 'off';
                if (shift === 'morning') morningCount++;
                if (shift === 'evening') eveningCount++;
                if (shift === 'night') nightCount++;
            });
            summaryCells.push(`<td style="text-align:center;padding:6px;font-size:0.7rem;color:#6b7280;" data-date="${dayDateStrs[d]}">
                <div style="display:flex;align-items:center;justify-content:center;gap:6px;">
                    <span style="display:flex;align-items:center;gap:2px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2"><circle cx="12" cy="12" r="5"/><path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/></svg>
                        ${morningCount}
                    </span>
                    <span style="display:flex;align-items:center;gap:2px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
                        ${eveningCount}
                    </span>
                    <span style="display:flex;align-items:center;gap:2px;">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" stroke-width="2"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
                        ${nightCount}
                    </span>
                </div>
            </td>`);
        }
        
        tbody.innerHTML += `<tr style="background:#f9fafb;border-top:2px solid #d1d5db;">
            <td class="calendar-staff-col" style="padding:8px 12px;font-weight:600;font-size:0.75rem;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">
                <span style="display:flex;align-items:center;gap:6px;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    On Duty
                </span>
            </td>
            ${summaryCells.join('')}
        </tr>`;
    }

    // ==================== INTELLIGENT SHIFT SHUFFLE ====================
    function intelligentShuffleShifts() {
        const newShiftData = {};
        const nurseHours = {};
        const consecutiveDays = {};
        const lastShiftType = {};
        const hasHadOff = {};
        
        nurseStaff.forEach(n => { 
            nurseHours[n.id] = 0; consecutiveDays[n.id] = 0;
            lastShiftType[n.id] = null; hasHadOff[n.id] = false;
        });
        
        const weekdayStaff = { morning: 3, evening: 3, night: 2 };
        const weekendStaff = { morning: 2, evening: 2, night: 2 };
        const offsPerDay = { 0: 4, 1: 1, 2: 1, 3: 1, 4: 1, 5: 2, 6: 3 };
        
        const weekStart = new Date(shiftWeekStart);
        const currentDayOfWeek = weekStart.getDay();
        let firstDayIndex = 0;
        if (window.MeditrackRegional && typeof window.MeditrackRegional.getFirstDayIndex === 'function') {
            firstDayIndex = window.MeditrackRegional.getFirstDayIndex();
        }
        const weekOffset = (currentDayOfWeek - firstDayIndex + 7) % 7;
        weekStart.setDate(weekStart.getDate() - weekOffset);
        
        for (let d = 0; d < 7; d++) {
            const dayDate = new Date(weekStart);
            dayDate.setDate(weekStart.getDate() + d);
            const dayOfWeek = dayDate.getDay();
            const isWeekend = (dayOfWeek === 0 || dayOfWeek === 6);
            const staffing = isWeekend ? weekendStaff : weekdayStaff;
            const offSlots = offsPerDay[dayOfWeek] || 1;
            
            const dayAssignments = { morning: [], evening: [], night: [], off: [] };
            
            const needsOff = nurseStaff.filter(n => {
                if (hasHadOff[n.id]) return false;
                if (consecutiveDays[n.id] >= 5) return true;
                if (d >= 3 && !hasHadOff[n.id]) return true;
                return false;
            });
            
            const sortedByConsecutive = [...nurseStaff]
                .filter(n => !needsOff.some(x => x.id === n.id))
                .sort((a, b) => consecutiveDays[b.id] - consecutiveDays[a.id]);
            
            const offCandidates = [...needsOff, ...sortedByConsecutive];
            
            let offsAssigned = 0;
            offCandidates.forEach(nurse => {
                if (offsAssigned >= offSlots) return;
                if (dayAssignments.off.includes(nurse.id)) return;
                dayAssignments.off.push(nurse.id);
                consecutiveDays[nurse.id] = 0;
                lastShiftType[nurse.id] = null;
                hasHadOff[nurse.id] = true;
                offsAssigned++;
            });
            
            const availableForWork = nurseStaff.filter(n => !dayAssignments.off.includes(n.id));
            availableForWork.sort((a, b) => nurseHours[a.id] - nurseHours[b.id]);
            
            ['night', 'evening', 'morning'].forEach(shift => {
                const needed = staffing[shift];
                const scored = availableForWork
                    .filter(n => !dayAssignments.morning.includes(n.id) && !dayAssignments.evening.includes(n.id) && !dayAssignments.night.includes(n.id))
                    .map(nurse => {
                        let score = 0;
                        score += (40 - nurseHours[nurse.id]) * 3;
                        if (lastShiftType[nurse.id] === shift) score -= 15;
                        if (shift === 'night' && lastShiftType[nurse.id] === 'evening') score -= 30;
                        if (shift === 'morning' && lastShiftType[nurse.id] === 'night') score -= 30;
                        score += Math.max(0, (4 - consecutiveDays[nurse.id])) * 2;
                        score += Math.random() * 4;
                        return { nurse, score };
                    });
                
                scored.sort((a, b) => b.score - a.score);
                
                let assigned = 0;
                scored.forEach(({ nurse }) => {
                    if (assigned >= needed) return;
                    dayAssignments[shift].push(nurse.id);
                    nurseHours[nurse.id] += 8;
                    consecutiveDays[nurse.id]++;
                    lastShiftType[nurse.id] = shift;
                    assigned++;
                });
            });
            
            nurseStaff.forEach(nurse => {
                const alreadyAssigned = dayAssignments.morning.includes(nurse.id) || dayAssignments.evening.includes(nurse.id) || dayAssignments.night.includes(nurse.id) || dayAssignments.off.includes(nurse.id);
                if (!alreadyAssigned) {
                    dayAssignments.off.push(nurse.id);
                    consecutiveDays[nurse.id] = 0;
                    lastShiftType[nurse.id] = null;
                    hasHadOff[nurse.id] = true;
                }
            });
            
            nurseStaff.forEach(nurse => {
                if (!newShiftData[nurse.id]) newShiftData[nurse.id] = {};
                if (dayAssignments.morning.includes(nurse.id)) newShiftData[nurse.id][d] = 'morning';
                else if (dayAssignments.evening.includes(nurse.id)) newShiftData[nurse.id][d] = 'evening';
                else if (dayAssignments.night.includes(nurse.id)) newShiftData[nurse.id][d] = 'night';
                else newShiftData[nurse.id][d] = 'off';
            });
        }
        return newShiftData;
    }

    // ==================== SHUFFLE BUTTON HANDLER ====================
    document.getElementById('shuffleShiftsBtn')?.addEventListener('click', () => {
        const btn = document.getElementById('shuffleShiftsBtn');
        const originalHTML = btn.innerHTML;
        btn.innerHTML = `<svg class="animate-spin" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Shuffling...`;
        btn.disabled = true;
        
        setTimeout(() => {
            const newData = intelligentShuffleShifts();
            Object.keys(demoShiftData).forEach(nurseId => {
                demoShiftData[nurseId] = newData[nurseId];
            });
            shiftData = newData;
            renderShiftView();
            btn.innerHTML = originalHTML;
            btn.disabled = false;
            showToast('Shifts intelligently shuffled! Off days distributed across the week.');
        }, 500);
    });

    // ==================== SHIFT NAVIGATION ====================
    document.getElementById('prevShiftWeekBtn')?.addEventListener('click', () => {
        shiftWeekStart.setDate(shiftWeekStart.getDate() - 7);
        renderShiftView();
    });
    document.getElementById('nextShiftWeekBtn')?.addEventListener('click', () => {
        shiftWeekStart.setDate(shiftWeekStart.getDate() + 7);
        renderShiftView();
    });

    // ==================== EXPORT PDF ====================
    document.getElementById('exportShiftPDFBtn')?.addEventListener('click', () => {
        const weekText = document.getElementById('shiftWeekHeader')?.textContent || 'Shift Schedule';
        const tableHTML = document.querySelector('#shiftGridContainer table')?.outerHTML || '';
        var printWindow = window.open('', '_blank', 'width=1200,height=800');
        printWindow.document.write('<!DOCTYPE html><html><head><title>Nurse Shift Schedule - ' + weekText + '<\/title>');
        printWindow.document.write('<style>*{font-family:Inter,system-ui,sans-serif;margin:0;padding:0}body{padding:30px;color:#1f2937}.header{margin-bottom:20px;border-bottom:2px solid #6366f1;padding-bottom:16px}.header h1{font-size:20px;margin-bottom:4px}.shift-block{padding:3px 8px;border-radius:4px;font-size:10px;font-weight:500;display:inline-block}.shift-morning{background:#fef3c7;color:#92400e;border:1px solid #fcd34d}.shift-evening{background:#dbeafe;color:#1e40af;border:1px solid #93c5fd}.shift-night{background:#ede9fe;color:#5b21b6;border:1px solid #c4b5fd}table{width:100%;border-collapse:collapse;font-size:11px;margin-top:10px}th{background:#f9fafb;padding:10px 8px;text-align:center;font-weight:600;border:1px solid #e5e7eb;font-size:10px}td{padding:8px 6px;text-align:center;border:1px solid #e5e7eb}@media print{body{padding:15px}}<\/style><\/head><body>');
        printWindow.document.write('<div class="header"><h1>Nurse Shift Schedule</h1><p>' + weekText + '</p><p style="font-size:11px;color:#9ca3af;">Generated on ' + new Date().toLocaleDateString() + '</p></div>');
        printWindow.document.write(tableHTML);
        printWindow.document.write('<script>window.onload=function(){window.print()}<\/script><\/body><\/html>');
        printWindow.document.close();
    });

    // ==================== EXPORT CSV ====================
    document.getElementById('exportShiftCSVBtn')?.addEventListener('click', () => {
        const weekText = document.getElementById('shiftWeekHeader')?.textContent || 'Shift Schedule';
        const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        var csv = 'Nurse Shift Schedule - ' + weekText + '\nGenerated on,' + new Date().toLocaleDateString() + '\n\nNurse,Role,Ward,Patients,';
        for (var d = 0; d < 7; d++) {
            var dateEl = document.getElementById('shiftDate' + d);
            csv += (dateEl ? dateEl.textContent : '') + ',';
        }
        csv += 'Total Hours\n';
        nurseStaff.forEach(function(nurse) {
            var morningCount = 0, eveningCount = 0, nightCount = 0;
            csv += '"' + nurse.name + '","' + nurse.role + '","' + (nurseWards[nurse.id] || 'Unassigned') + '",' + (nursePatientCount[nurse.id] || 0) + ',';
            for (var d2 = 0; d2 < 7; d2++) {
                var shift = shiftData[nurse.id] ? (shiftData[nurse.id][d2] || 'off') : 'off';
                var label = shiftLabels[shift] || 'Off';
                if (shift === 'morning') morningCount++;
                if (shift === 'evening') eveningCount++;
                if (shift === 'night') nightCount++;
                csv += label + ',';
            }
            csv += ((morningCount + eveningCount + nightCount) * 8) + '\n';
        });
        var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        var url = URL.createObjectURL(blob);
        var link = document.createElement('a');
        link.href = url;
        link.download = 'Nurse_Shift_Schedule_' + weekText.replace(/[^a-zA-Z0-9]/g, '_') + '.csv';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
        showToast('CSV exported successfully!');
    });

    // ==================== ADD SHIFT STYLES DYNAMICALLY ====================
    (function addShiftStyles() {
        if (document.getElementById('shift-block-styles')) return;
        const style = document.createElement('style');
        style.id = 'shift-block-styles';
        style.textContent = `
            .shift-block { padding:4px 8px; border-radius:6px; font-size:0.75rem; font-weight:500; text-align:center; white-space:nowrap; display:inline-block; }
            .shift-morning { background:#fef3c7; color:#92400e; border:1px solid #fcd34d; }
            .shift-evening { background:#dbeafe; color:#1e40af; border:1px solid #93c5fd; }
            .shift-night { background:#ede9fe; color:#5b21b6; border:1px solid #c4b5fd; }
            body.dark .shift-morning { background:#78350f; color:#fde68a; border-color:#92400e; }
            body.dark .shift-evening { background:#1e3a5f; color:#bfdbfe; border-color:#1e40af; }
            body.dark .shift-night { background:#3b2f5c; color:#ddd6fe; border-color:#5b21b6; }
        `;
        document.head.appendChild(style);
    })();

    // ==================== SMART EXPORT - Context-aware CSV export ====================
function smartExport() {
    const activeTab = document.querySelector('.tab-btn[data-state="active"]')?.dataset.tab;
    
    switch(activeTab) {
        case 'daily':
            exportDailyCSV();
            break;
        case 'calendar':
            exportCalendarCSV();
            break;
        case 'timesheet':
            exportTimesheetCSV();
            break;
        case 'leave':
            exportLeaveCSV();
            break;
        case 'shifts':
            exportShiftCSV();
            break;
        case 'reports':
            showToast('Use the Export Report button in the Reports tab');
            break;
        default:
            exportDailyCSV();
    }
}

function exportCalendarCSV() {
    const monthYear = document.getElementById('calMonthYear')?.textContent || 'Calendar';
    const headers = ['Staff Name'];
    // Get all day headers from the calendar table
    const dayHeaders = document.querySelectorAll('#calendarContainer thead th:not(.calendar-staff-col)');
    dayHeaders.forEach(th => headers.push(th.textContent.trim()));
    
    const rows = [];
    const staffRows = document.querySelectorAll('#calendarContainer tbody tr');
    staffRows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const rowData = [];
        cells.forEach((cell, index) => {
            if (index === 0) {
                // Staff name from the first cell
                const nameEl = cell.querySelector('.staff-name');
                rowData.push(nameEl ? nameEl.textContent.trim() : cell.textContent.trim());
            } else {
                // Determine status from SVG icon
                const svg = cell.querySelector('svg');
                if (svg) {
                    const stroke = svg.getAttribute('stroke');
                    if (stroke === '#10b981') rowData.push('Present');
                    else if (stroke === '#ef4444') rowData.push('Absent');
                    else if (stroke === '#f59e0b') rowData.push('Late');
                    else if (stroke === '#3b82f6') rowData.push('On Leave');
                    else rowData.push('Unknown');
                } else {
                    const span = cell.querySelector('span');
                    rowData.push(span ? 'Weekend' : 'Unknown');
                }
            }
        });
        rows.push(rowData);
    });
    
    const csv = [headers, ...rows].map(r => r.join(',')).join('\n');
    downloadCSV(csv, `attendance_calendar_${monthYear.replace(/\s/g, '_')}.csv`);
    showToast('Calendar data exported');
}

function exportTimesheetCSV() {
    const headers = ['Staff Name', 'Department', 'Week Starting', 'Total Hours', 'Overtime', 'Status'];
    const rows = [];
    const tableRows = document.querySelectorAll('#timesheetTableBody tr');
    tableRows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const rowData = [];
        cells.forEach((cell, index) => {
            if (index === 0) {
                const nameEl = cell.querySelector('.staff-name');
                rowData.push(nameEl ? nameEl.textContent.trim() : '');
            } else if (index < 6) {
                rowData.push(cell.textContent.trim());
            }
            // Skip the actions column
        });
        if (rowData.length === 6) rows.push(rowData);
    });
    
    const csv = [headers, ...rows].map(r => r.join(',')).join('\n');
    downloadCSV(csv, 'timesheets.csv');
    showToast('Timesheet data exported');
}

function exportLeaveCSV() {
    const headers = ['Staff Name', 'Department', 'Leave Type', 'Duration', 'Dates', 'Status'];
    const rows = [];
    const tableRows = document.querySelectorAll('#leaveTableBody tr');
    tableRows.forEach(row => {
        const cells = row.querySelectorAll('td');
        const rowData = [];
        cells.forEach((cell, index) => {
            if (index === 0) {
                const nameEl = cell.querySelector('.staff-name');
                rowData.push(nameEl ? nameEl.textContent.trim() : '');
            } else if (index < 6) {
                rowData.push(cell.textContent.trim());
            }
        });
        if (rowData.length === 6) rows.push(rowData);
    });
    
    const csv = [headers, ...rows].map(r => r.join(',')).join('\n');
    downloadCSV(csv, 'leave_requests.csv');
    showToast('Leave data exported');
}

function exportShiftCSV() {
    const weekText = document.getElementById('shiftWeekHeader')?.textContent || 'Shift Schedule';
    
    var csv = 'Nurse Shift Schedule - ' + weekText + '\n';
    csv += 'Generated on,' + new Date().toLocaleDateString() + '\n\n';
    csv += 'Nurse,Role,Ward,Patients,';
    for (var d = 0; d < 7; d++) {
        var dateEl = document.getElementById('shiftDate' + d);
        var dateText = dateEl ? dateEl.textContent : '';
        csv += dateText + ',';
    }
    csv += 'Total Hours\n';
    
    nurseStaff.forEach(function(nurse) {
        var morningCount = 0, eveningCount = 0, nightCount = 0;
        csv += '"' + nurse.name + '","' + nurse.role + '","' + (nurseWards[nurse.id] || 'Unassigned') + '",' + (nursePatientCount[nurse.id] || 0) + ',';
        for (var d2 = 0; d2 < 7; d2++) {
            var shift = shiftData[nurse.id] ? (shiftData[nurse.id][d2] || 'off') : 'off';
            var label = shiftLabels[shift] || 'Off';
            if (shift === 'morning') morningCount++;
            if (shift === 'evening') eveningCount++;
            if (shift === 'night') nightCount++;
            csv += label + ',';
        }
        csv += ((morningCount + eveningCount + nightCount) * 8) + '\n';
    });
    
    var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    var url = URL.createObjectURL(blob);
    var link = document.createElement('a');
    link.href = url;
    link.download = 'Nurse_Shift_Schedule_' + weekText.replace(/[^a-zA-Z0-9]/g, '_') + '.csv';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
    
    showToast('Shift data exported');
}

// Helper function for CSV download
function downloadCSV(csvContent, filename) {
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}

    // Initialize everything
    document.addEventListener('DOMContentLoaded', () => {
        renderDailyTable();
        renderTimesheetTable();
        renderLeaveTable();
        renderCalendar();

        document.getElementById('smartExportBtn')?.addEventListener('click', smartExport);
    });

    // Expose global functions for inline onclick
    window.openActionMenu = openActionMenu;
    window.openLeaveActionMenu = openLeaveActionMenu;
    window.openEditTime = openEditTime;
    window.openAddNote = openAddNote;
    window.openHistory = openHistory;
    window.openLeaveDetails = openLeaveDetails;
    window.saveRecordTime = saveRecordTime;
    window.saveTimesheet = saveTimesheet;
    window.exportDailyCSV = exportDailyCSV;
    window.printDailyTable = printDailyTable;
    window.showToast = showToast;
    window.renderChart = renderChart;
    window.renderShiftView = renderShiftView;
    window.openTimesheetDetails = openTimesheetDetails;
    window.printTimesheet = printTimesheet;
    window.smartExport = smartExport;
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
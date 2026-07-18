<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover, maximum-scale=1.0, user-scalable=yes">
    <title>Medi-track | Queue Kiosk</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        body { background-color: #f9fafb; }
        body.dark { background-color: #131212 !important; }
        body.dark .bg-white, body.dark .bg-card, body.dark .rounded-lg.border, body.dark .bg-background { background-color: #131212 !important; border-color: #333 !important; }
        body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
        body.dark .bg-gray-100, body.dark .bg-muted { background-color: #262626 !important; }
        body.dark input { background-color: #262626 !important; border-color: #404040 !important; color: #e5e5e5 !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        .tab-btn { transition: all 0.2s ease; color: #6b7280; }
        .tab-btn.active { background-color: white; color: #1f2937; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05); }
        body.dark .tab-btn.active { background-color: #131212; color: #e5e5e5; }

        .modal-overlay {
            position: fixed; inset: 0; background-color: rgb(0 0 0 / 87%);
            backdrop-filter: blur(2px); z-index: 1000; display: none;
            align-items: center; justify-content: center;
        }
        .modal-overlay.show { display: flex; animation: fadeIn 0.2s ease-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        .modal-container {
            background: white; border-radius: 0.75rem; width: 100%;
            max-width: 800px; max-height: 85vh; overflow-y: auto;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); animation: slideUp 0.2s ease;
        }
        body.dark .modal-container { background: #1e293b; border: 1px solid #334155; }
        @keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-header {
            padding: 1rem 1.5rem; border-bottom: 1px solid #e5e7eb;
            display: flex; justify-content: space-between; align-items: center;
            position: sticky; top: 0; background: white; z-index: 10;
        }
        body.dark .modal-header { border-bottom-color: #334155; background: #1e293b; }
        .modal-title { font-size: 1.125rem; font-weight: 600; }
        .modal-close {
            background: transparent; border: none; font-size: 1.5rem; cursor: pointer;
            color: #6b7280; line-height: 1; padding: 0;
            width: 28px; height: 28px; display: flex;
            align-items: center; justify-content: center; border-radius: 0.375rem;
        }
        .modal-close:hover { color: #1f2937; background-color: #f3f4f6; }
        body.dark .modal-close:hover { color: #e5e5e5; background-color: #374151; }
        .modal-body { padding: 1.5rem; }
        .modal-footer {
            padding: 1rem 1.5rem; border-top: 1px solid #e5e7eb;
            display: flex; justify-content: flex-end; gap: 0.75rem;
            position: sticky; bottom: 0; background: white;
        }
        body.dark .modal-footer { border-top-color: #334155; background: #1e293b; }

        .alert-dialog-overlay {
            position: fixed; inset: 0; background-color: rgb(0 0 0 / 87%);
            z-index: 1100; display: none; align-items: center; justify-content: center;
        }
        .alert-dialog-overlay.show { display: flex; animation: fadeIn 0.2s ease-out; }
        .alert-dialog {
            background-color: white; border-radius: 0.75rem; width: 90%;
            max-width: 450px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
            animation: slideUp 0.2s ease; overflow: hidden;
        }
        body.dark .alert-dialog { background-color: #1f1f1f; border: 1px solid #333; }
        .alert-dialog-header { padding: 1.5rem 1.5rem 0.75rem 1.5rem; }
        .alert-dialog-title { font-size: 1.125rem; font-weight: 600; color: #111827; margin: 0 0 0.5rem 0; }
        body.dark .alert-dialog-title { color: #f3f4f6; }
        .alert-dialog-description { font-size: 0.875rem; color: #6b7280; line-height: 1.5; margin: 0; }
        body.dark .alert-dialog-description { color: #9ca3af; }
        .alert-dialog-footer { padding: 1rem 1.5rem 1.5rem 1.5rem; display: flex; justify-content: flex-end; gap: 0.75rem; }
        .alert-dialog-cancel {
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 0.5rem; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500;
            background-color: transparent; border: 1px solid #e5e7eb; color: #374151; cursor: pointer;
        }
        body.dark .alert-dialog-cancel { border-color: #404040; color: #e5e5e5; }
        .alert-dialog-delete {
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 0.5rem; padding: 0.5rem 1rem; font-size: 0.875rem; font-weight: 500;
            background-color: #ef4444; border: none; color: white; cursor: pointer;
        }
        .alert-dialog-delete:hover { background-color: #dc2626; }

        .toast-message {
            position: fixed; bottom: 20px; right: 20px; background: #10b981;
            color: white; padding: 12px 20px; border-radius: 8px; z-index: 1200;
            font-size: 0.875rem; animation: slideIn 0.3s ease-out;
            display: flex; align-items: center; gap: 8px;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1);
        }
        .toast-message.error { background: #ef4444; }
        @keyframes slideIn { from { opacity: 0; transform: translateX(100%); } to { opacity: 1; transform: translateX(0); } }

        .status-badge { display: inline-flex; align-items: center; border-radius: 9999px; padding: 0.25rem 0.625rem; font-size: 0.75rem; font-weight: 600; }
        .status-waiting { background-color: #dbeafe; color: #1e40af; }
        .status-serving { background-color: #fef3c7; color: #92400e; }
        .status-completed { background-color: #dcfce7; color: #166534; }
        body.dark .status-waiting { background-color: #1e3a5f; color: #dbeafe; }
        body.dark .status-serving { background-color: #78350f; color: #fef3c7; }
        body.dark .status-completed { background-color: #14532d; color: #dcfce7; }

        .type-badge { display: inline-flex; align-items: center; gap: 4px; border-radius: 9999px; padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 600; }
        .type-walkin { background-color: #e0e7ff; color: #3730a3; }
        .type-appointment { background-color: #fce7f3; color: #9d174d; }
        .type-ipd { background-color: #d1fae5; color: #065f46; }
        .type-emergency { background-color: #fee2e2; color: #991b1b; }
        body.dark .type-walkin { background-color: #312e81; color: #c7d2fe; }
        body.dark .type-appointment { background-color: #831843; color: #fbcfe8; }
        body.dark .type-ipd { background-color: #064e3b; color: #a7f3d0; }
        body.dark .type-emergency { background-color: #7f1d1d; color: #fecaca; }

        .data-row:hover { background-color: #f9fafb; }
        body.dark .data-row:hover { background-color: #1f1f1f; }
        .data-row.priority-high { border-left: 3px solid #ef4444; }

        .step-indicator { display: flex; align-items: center; gap: 0.5rem; margin-bottom: 2rem; }
        .step-dot { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.875rem; background: #e5e7eb; color: #6b7280; transition: all 0.3s; }
        .step-dot.active { background: #6366f1; color: white; }
        .step-dot.done { background: #10b981; color: white; }
        .step-line { flex: 1; height: 2px; background: #e5e7eb; transition: all 0.3s; }
        .step-line.done { background: #10b981; }

        input:focus { outline: none; border-color: #6366f1 !important; box-shadow: 0 0 0 2px rgba(99,102,241,0.2) !important; }

        @media print {
            body * { visibility: hidden; }
            .print-area, .print-area * { visibility: visible; }
            .print-area { position: absolute; left: 0; top: 0; width: 100%; }
            .no-print { display: none !important; }
        }
                .type-facility { background-color: #ccfbf1; color: #0f766e; }
        .type-external { background-color: #fff7ed; color: #c2410c; }
        body.dark .type-facility { background-color: #134e4a; color: #99f6e4; }
        body.dark .type-external { background-color: #7c2d12; color: #fed7aa; }
    </style>
</head>
<body class="bg-gray-50 antialiased">

<!-- Sticky Header (Medi-track Standard) -->
<header class="sticky top-0 z-40 border-b bg-background shadow-sm border-gray-200">
    <div class="flex h-16 items-center justify-between px-6 md:px-10 lg:px-16">
        <div class="flex items-center gap-2">
            <a href="index.html" id="headerLogo" class="flex items-center space-x-2">
                <img alt="Medi-track" src="logo.png" class="h-8" >
                <span class="font-bold text-xl">Medi-track</span>
            </a>
            <span class="text-sm text-gray-500 hidden sm:inline">| Queue Kiosk</span>
        </div>
        <div class="flex items-center gap-4">
            <button id="meditrack-lang-btn" class="inline-flex items-center justify-center gap-1 rounded-md border border-gray-200 bg-white px-2.5 py-1.5 text-sm font-medium text-gray-700 transition-colors hover:border-indigo-500 hover:bg-gray-50 size-10" aria-label="Language">
                        <span style="font-size: 16px;">🇬🇧</span>
                        <span class="hidden sm:inline">EN</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>
            <button id="themeToggleBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-gray-100 size-10" aria-label="Toggle theme">
                <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="hidden text-gray-600"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M6.34 17.66l-1.41 1.41M19.07 4.93l-1.41 1.41"/></svg>
                <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-600"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
            </button>
            <div class="relative">
                <button id="notificationsBtn" class="inline-flex items-center justify-center rounded-md transition-colors hover:bg-gray-100 size-10 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
                    <span class="absolute right-1 top-1 flex h-2 w-2 rounded-full bg-red-500"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span></span>
                </button>
                <div id="notificationsDropdown" class="hidden absolute right-0 mt-2 z-50 w-80 rounded-md border bg-background shadow-lg overflow-hidden">
                    <div class="px-3 py-2 text-sm font-semibold flex justify-between border-b"><span>Notifications</span><button id="markAllReadBtn" class="text-xs text-indigo-600">Mark all as read</button></div>
                    <div class="max-h-[300px] overflow-y-auto">
                        <div class="flex items-start gap-2 p-3 text-sm hover:bg-muted/50 rounded-md bg-muted/30">
                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-primary/10"><span>🗓️</span></div>
                            <div class="flex-1"><p class="font-semibold">Queue Alert</p><p class="text-xs text-muted-foreground">Radiology: 8 waiting</p></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative">
                <button id="profileBtn" class="flex items-center justify-center h-8 w-8 rounded-full hover:ring-2 hover:ring-gray-200">
                    <img src="user.png" alt="Profile" class="h-8 w-8 rounded-full object-cover">
                </button>
                <div id="profileDropdown" class="hidden absolute right-0 mt-2 z-50 w-56 rounded-md border bg-background shadow-lg p-1">
                    <div class="px-2 py-1.5 border-b"><p class="font-medium text-sm">Dr. Nakato Sarah</p><p class="text-xs text-gray-500">admin@hospital.ug</p></div>
                    <a href="profile-setting.html" class="flex items-center gap-2 px-2 py-1.5 text-sm hover:bg-gray-100 rounded"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Profile</a>
                    <a href="#" id="staffPanelLink" class="flex items-center gap-2 px-2 py-1.5 text-sm hover:bg-gray-100 rounded"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>Staff Panel</a>
                    <div class="border-t my-1"></div>
                    <a href="login.html" class="flex items-center gap-2 px-2 py-1.5 text-sm text-red-600 hover:bg-gray-100 rounded"><svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>Log out</a>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="px-6 md:px-10 lg:px-16 py-6 md:py-10 w-full">


    <!-- STEP 1: Select Visitor Type -->
    <div id="step1" class="space-y-6">
        <div class="step-indicator">
            <div class="step-dot active">1</div><div class="step-line"></div>
            <div class="step-dot">2</div><div class="step-line"></div>
            <div class="step-dot">3</div><div class="step-line"></div>
            <div class="step-dot">✓</div>
        </div>

        <div class="text-center mb-6">
            <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Welcome to Medi-track</h1>
            <p class="text-gray-500 mt-2 text-lg">Why are you visiting us today?</p>
        </div>

        <!-- Stats Cards Row -->
        <div class="grid gap-4 md:grid-cols-4 mb-6">
            <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition cursor-pointer" id="cardWaiting">
                <div class="flex items-center space-x-2">
                    <div class="bg-blue-100 p-2 rounded-lg"><svg class="h-5 w-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/></svg></div>
                    <span class="font-medium text-sm">Waiting</span>
                </div>
                <div class="mt-4"><div class="text-3xl font-bold" id="statWaiting">0</div><p class="text-xs text-gray-500">All departments</p></div>
            </div>
            <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition cursor-pointer" id="cardServing">
                <div class="flex items-center space-x-2">
                    <div class="bg-amber-100 p-2 rounded-lg"><svg class="h-5 w-5 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                    <span class="font-medium text-sm">Serving Now</span>
                </div>
                <div class="mt-4"><div class="text-3xl font-bold" id="statServing">0</div><p class="text-xs text-gray-500">Active counters</p></div>
            </div>
            <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition cursor-pointer" id="cardCompleted">
                <div class="flex items-center space-x-2">
                    <div class="bg-green-100 p-2 rounded-lg"><svg class="h-5 w-5 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 6 9 17l-5-5"/></svg></div>
                    <span class="font-medium text-sm">Completed Today</span>
                </div>
                <div class="mt-4"><div class="text-3xl font-bold" id="statCompleted">0</div><p class="text-xs text-gray-500">Avg wait: 12m</p></div>
            </div>
            <div class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition cursor-pointer" id="cardEmergency">
                <div class="flex items-center space-x-2">
                    <div class="bg-red-100 p-2 rounded-lg"><svg class="h-5 w-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v4"/><path d="M12 17h.01"/><circle cx="12" cy="12" r="10"/></svg></div>
                    <span class="font-medium text-sm">Emergency</span><span class="ml-auto text-sm text-red-500 font-medium" id="statEmergencyBadge">0 urgent</span>
                </div>
                <div class="mt-4"><div class="text-3xl font-bold" id="statEmergency">0</div><p class="text-xs text-gray-500">Priority queue</p></div>
            </div>
        </div>

        <!-- Visitor Type Cards -->
        <div class="grid gap-6 md:grid-cols-2">
            <div onclick="selectType('emergency')" class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition cursor-pointer border-red-300 bg-red-50/30">
                <div class="flex items-center space-x-2">
                    <div class="bg-red-100 p-2 rounded-lg"><svg class="h-5 w-5 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v4"/><path d="M12 17h.01"/><circle cx="12" cy="12" r="10"/></svg></div>
                    <span class="font-medium text-red-700">🚨 Emergency</span>
                </div>
                <div class="mt-4"><div class="text-xl font-bold text-red-600">Urgent Care Needed</div><p class="text-xs text-gray-500">Priority service - immediate attention</p></div>
                <div class="mt-6"><button class="flex items-center justify-between w-full text-sm text-red-600 font-medium hover:underline"><span>Select Emergency</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg></button></div>
            </div>
            <div onclick="selectType('appointment')" class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition cursor-pointer">
                <div class="flex items-center space-x-2">
                    <div class="bg-orange-100 p-2 rounded-lg"><svg class="h-5 w-5 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg></div>
                    <span class="font-medium">📅 I Have an Appointment</span>
                </div>
                <div class="mt-4"><div class="text-xl font-bold">Pre-scheduled Visit</div><p class="text-xs text-gray-500">Already booked with a doctor</p></div>
                <div class="mt-6"><button class="flex items-center justify-between w-full text-sm text-orange-600 font-medium hover:underline"><span>Select Appointment</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg></button></div>
            </div>
            <div onclick="selectType('ipd')" class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition cursor-pointer">
                <div class="flex items-center space-x-2">
                    <div class="bg-emerald-100 p-2 rounded-lg"><svg class="h-5 w-5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/></svg></div>
                    <span class="font-medium">🛏️ In-Patient (IPD)</span>
                </div>
                <div class="mt-4"><div class="text-xl font-bold">Already Admitted</div><p class="text-xs text-gray-500">Currently in hospital ward</p></div>
                <div class="mt-6"><button class="flex items-center justify-between w-full text-sm text-emerald-600 font-medium hover:underline"><span>Select IPD</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg></button></div>
            </div>
            <div onclick="selectType('walkin')" class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition cursor-pointer">
                <div class="flex items-center space-x-2">
                    <div class="bg-blue-100 p-2 rounded-lg"><svg class="h-5 w-5 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></svg></div>
                    <span class="font-medium">🚶 Walk-in Visit</span>
                </div>
                <div class="mt-4"><div class="text-xl font-bold">General Consultation</div><p class="text-xs text-gray-500">No appointment needed</p></div>
                <div class="mt-6"><button class="flex items-center justify-between w-full text-sm text-indigo-600 font-medium hover:underline"><span>Select Walk-in</span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg></button></div>
            </div>
        </div>

        <div class="text-center mt-4">
            <button id="helpBtn" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-indigo-600 h-10 px-4 rounded-md hover:bg-gray-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                Need Help? Call Staff
            </button>
        </div>
    </div>

    <!-- STEP 2: Select Department -->
    <div id="step2" class="hidden space-y-6">
        <div class="step-indicator">
            <div class="step-dot done">✓</div><div class="step-line done"></div>
            <div class="step-dot active">2</div><div class="step-line"></div>
            <div class="step-dot">3</div><div class="step-line"></div>
            <div class="step-dot">✓</div>
        </div>

        <div class="flex items-center gap-3 mb-4">
            <button onclick="goBack()" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background size-10 hover:bg-accent hover:text-accent-foreground h-10">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            </button>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Select Department</h1>
                <p class="text-gray-500">You selected: <span id="selectedTypeLabel" class="font-semibold"></span></p>
            </div>
        </div>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3" id="departmentGrid"></div>
    </div>

    <!-- STEP 3: Enter Details -->
    <div id="step3" class="hidden space-y-6">
        <div class="step-indicator">
            <div class="step-dot done">✓</div><div class="step-line done"></div>
            <div class="step-dot done">✓</div><div class="step-line done"></div>
            <div class="step-dot active">3</div><div class="step-line"></div>
            <div class="step-dot">✓</div>
        </div>

        <div class="flex items-center gap-3 mb-4">
            <button onclick="goBack()" class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-background size-10 hover:bg-accent hover:text-accent-foreground h-10">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            </button>
            <div>
                <h1 class="text-2xl lg:text-3xl font-bold tracking-tight">Your Details</h1>
                <p class="text-gray-500"><span id="step3DeptLabel"></span></p>
            </div>
        </div>

        <div class="rounded-lg border bg-background shadow-sm">
                <div class="p-6 space-y-4">
                    <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-4 text-sm flex items-start gap-3">
                        <span class="text-xl">🔒</span>
                        <div><p class="font-semibold text-gray-800">Your information is secure</p><p class="text-gray-500 mt-1">Used only to call you. Data deleted after 48 hours. Max 3 tickets per day.</p></div>
                    </div>
                    <div>
                        <label class="text-sm font-medium block mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" id="visitorName" class="w-full rounded-md border h-10 border-gray-300 px-3 py-2.5 text-base" placeholder="Enter your full name">
                    </div>
                    <div>
                        <label class="text-sm font-medium block mb-1">Phone Number <span class="text-red-500">*</span></label>
                        <input type="tel" id="visitorPhone" class="w-full rounded-md border h-10 border-gray-300 px-3 py-2.5 text-base" placeholder="We'll notify you when it's your turn">
                    </div>
                </div>
                <div class="p-6 pt-0">
                    <button onclick="generateFinalTicket()" class="w-full bg-primary text-white hover:bg-primary/90 h-10 rounded-md text-base font-semibold flex items-center justify-center gap-2 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17l-5-5"/></svg>
                        Get My Queue Ticket
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- STEP 4: Ticket Display -->
    <div id="step4" class="hidden space-y-6">
        <div class="step-indicator">
            <div class="step-dot done">✓</div><div class="step-line done"></div>
            <div class="step-dot done">✓</div><div class="step-line done"></div>
            <div class="step-dot done">✓</div><div class="step-line done"></div>
            <div class="step-dot active">✓</div>
        </div>

        <div class="max-w-md mx-auto">
            <div class="rounded-lg border bg-background shadow-lg print-area">
                <div class="bg-primary text-white p-6 text-center rounded-t-lg">
                    <h2 class="text-xl font-bold">Medi-track Queue Ticket</h2>
                    <p class="text-sm opacity-80 mt-1">Official Queue Number</p>
                </div>
                <div class="p-6 text-center space-y-4">
                    <div class="text-6xl font-extrabold text-indigo-600" id="ticketNum">—</div>
                    <div><span class="type-badge text-sm px-3 py-1" id="ticketTypeBadge">—</span></div>
                    <div class="text-xl font-semibold" id="ticketDeptName">—</div>
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 text-left space-y-2 text-sm">
                        <p><strong>Visitor:</strong> <span id="ticketVisitorName">—</span></p>
                        <p><strong>Phone:</strong> <span id="ticketVisitorPhone">—</span></p>
                        <p class="text-red-500"><strong>Expires:</strong> <span id="ticketExpiryTime">—</span></p>
                    </div>
                    <div class="border-t border-dashed border-gray-300 dark:border-gray-600 pt-4">
                        <p class="text-2xl font-bold text-indigo-600" id="ticketEstWaitTime">~5 min</p>
                        <p class="text-sm text-gray-500">Estimated wait time</p>
                        <p class="text-sm text-gray-400 mt-1">People ahead: <span id="ticketAheadPeople" class="font-semibold">0</span></p>
                    </div>
                    <p class="text-xs text-gray-400">Verify: <span id="ticketVerifyId" class="font-mono">—</span></p>
                </div>
            </div>
            <div class="flex justify-center gap-3 mt-6 no-print">
                <button onclick="printTicket()" class="bg-primary text-white hover:bg-primary/90 h-10 px-6 rounded-md text-sm font-semibold flex items-center gap-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 12H4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-5a2 2 0 0 0-2-2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
                    Print Ticket
                </button>
                <button onclick="resetKiosk()" class="border border-gray-300 bg-background hover:bg-gray-50 h-10 px-6 rounded-md text-sm font-semibold flex items-center gap-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                    New Ticket
                </button>
            </div>
        </div>
    </div>
</main>

<!-- Staff Panel Modal -->
<div id="staffModal" class="modal-overlay">
    <div class="modal-container" style="max-width:800px;">
        <div class="modal-header"><h2 class="modal-title">Staff Queue Management</h2><button class="modal-close" data-close="staffModal">&times;</button></div>
        <div class="modal-body">
            <div class="space-y-4">
                <button id="callNextGlobalBtn" class="bg-primary text-white hover:bg-primary/90 h-10 px-4 rounded-md text-sm flex items-center gap-2 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 17 20 12 15 7"/><path d="M4 12h16"/></svg>
                    Call Next (Priority Order)
                </button>
                <div class="overflow-x-auto rounded-md border">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b dark:bg-gray-800"><tr><th class="px-4 py-3 text-left">Ticket</th><th class="px-4 py-3 text-left">Visitor</th><th class="px-4 py-3 text-left">Type</th><th class="px-4 py-3 text-left">Dept</th><th class="px-4 py-3 text-left hidden sm:table-cell">Time</th><th class="px-4 py-3 text-left">Status</th><th class="px-4 py-3 text-right">Actions</th></tr></thead>
                        <tbody id="staffTableBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- 1. Settings Manager FIRST -->
<script src="js/features/settings-manager.js"></script>

<!-- 2. Core -->
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

<!-- 4. Init Last -->
<script src="js/init.js"></script>

<script>
    // ==================== UNIFIED DEPARTMENT LIST ====================
    const DEPARTMENTS = [
        // Medical Departments
        { name: "General Medicine",    icon: "🩺", color: "blue",    category: "medical" },
        { name: "Cardiology",          icon: "❤️", color: "red",     category: "medical" },
        { name: "Orthopedics",         icon: "🦴", color: "amber",   category: "medical" },
        { name: "Pediatrics",          icon: "👶", color: "pink",    category: "medical" },
        { name: "Radiology",           icon: "🩻", color: "purple",  category: "medical" },
        { name: "Laboratory",          icon: "🧪", color: "green",   category: "medical" },
        { name: "Pharmacy",            icon: "💊", color: "teal",    category: "medical" },
        { name: "Dermatology",         icon: "🧴", color: "orange",  category: "medical" },
        { name: "ENT",                 icon: "👂", color: "cyan",    category: "medical" },
        { name: "Ophthalmology",       icon: "👁️", color: "indigo",  category: "medical" },
        { name: "Dental",              icon: "🦷", color: "emerald", category: "medical" },
        { name: "Physiotherapy",       icon: "💪", color: "lime",    category: "medical" },
        
        // Non-Medical - Facility Services (for facility & external visitors)
        { name: "Medical Records Pickup",  icon: "📋", color: "teal",   category: "non-medical", desc: "Collect lab reports or medical records" },
        { name: "Equipment Maintenance",   icon: "🔧", color: "orange", category: "non-medical", desc: "Repair or service medical equipment" },
        { name: "Waste Management",        icon: "🗑️", color: "gray",   category: "non-medical", desc: "Garbage/waste collection pickup" },
        { name: "Supply Delivery",         icon: "📦", color: "orange", category: "non-medical", desc: "Deliver medical supplies or goods" },
        { name: "Laundry Exchange",        icon: "👕", color: "teal",   category: "non-medical", desc: "Linen and laundry services" },
        { name: "Administrative Office",   icon: "📝", color: "gray",   category: "non-medical", desc: "Billing, HR, admin inquiries" },
        { name: "IT / Technical Support",  icon: "💻", color: "orange", category: "non-medical", desc: "Technical support or installation" },
        { name: "Building Maintenance",    icon: "🏗️", color: "gray",   category: "non-medical", desc: "Plumbing, electrical, HVAC" },
        { name: "Health Inspector Visit",  icon: "🔍", color: "orange", category: "non-medical", desc: "Official inspection or audit" },
        { name: "Security / Transport",    icon: "🚛", color: "gray",   category: "non-medical", desc: "Security detail or patient transport" }
    ];

    // ==================== VISITOR TYPES ====================
    const VISITOR_TYPES = [
        { 
            id: "emergency", 
            label: " Emergency", 
            desc: "Urgent Care Needed", 
            subdesc: "Priority service - immediate attention",
            color: "red",
            bgClass: "bg-red-50/30 border-red-300",
            iconBg: "bg-red-100",
            iconColor: "text-red-600",
            textColor: "text-red-700",
            titleColor: "text-red-600",
            priority: 1,
            phoneRequired: true,
            categories: ["medical"]
        },
        { 
            id: "appointment", 
            label: " I Have an Appointment", 
            desc: "Pre-scheduled Visit", 
            subdesc: "Already booked with a doctor",
            color: "pink",
            bgClass: "",
            iconBg: "bg-orange-100",
            iconColor: "text-orange-600",
            textColor: "",
            titleColor: "",
            priority: 2,
            phoneRequired: true,
            categories: ["medical"]
        },
        { 
            id: "ipd", 
            label: " In-Patient (IPD)", 
            desc: "Already Admitted", 
            subdesc: "Currently in hospital ward",
            color: "emerald",
            bgClass: "",
            iconBg: "bg-emerald-100",
            iconColor: "text-emerald-600",
            textColor: "",
            titleColor: "",
            priority: 2,
            phoneRequired: true,
            categories: ["medical"]
        },
        { 
            id: "walkin", 
            label: " Walk-in Visit", 
            desc: "General Consultation", 
            subdesc: "No appointment needed",
            color: "yellow",
            bgClass: "",
            iconBg: "bg-yellow-100",
            iconColor: "text-yellow-600",
            textColor: "",
            titleColor: "",
            priority: 3,
            phoneRequired: true,
            categories: ["medical"]
        },
        { 
            id: "facility", 
            label: " Facility Services", 
            desc: "Non-Medical Visit", 
            subdesc: "Pickup, delivery, maintenance, admin",
            color: "teal",
            bgClass: "",
            iconBg: "bg-green-100",
            iconColor: "text-teal-600",
            textColor: "",
            titleColor: "",
            priority: 4,
            phoneRequired: false,
            categories: ["non-medical"]
        },
        { 
            id: "external", 
            label: " External Visitor", 
            desc: "Vendor / Contractor", 
            subdesc: "Delivery, maintenance, inspection",
            color: "orange",
            bgClass: "",
            iconBg: "bg-orange-100",
            iconColor: "text-orange-600",
            textColor: "",
            titleColor: "",
            priority: 4,
            phoneRequired: false,
            categories: ["non-medical"]
        }
    ];

    // ==================== TYPE BADGE CSS MAPS ====================
    const TYPE_BADGE_CLASS = {
        emergency: "type-emergency",
        appointment: "type-appointment",
        ipd: "type-ipd",
        walkin: "type-walkin",
        facility: "type-facility",
        external: "type-external"
    };

    // ==================== STATE ====================
    let queue = [
        { id:"Q-101",type:"walkin",dept:"General Medicine",name:"John D.",phone:"***1234",time:"08:15 AM",status:"Serving",vc:"MT-A7X",exp:Date.now()+86400000 },
        { id:"Q-102",type:"appointment",dept:"Cardiology",name:"Mary S.",phone:"***5678",time:"08:22 AM",status:"Waiting",vc:"MT-B9Y",exp:Date.now()+86400000 },
        { id:"Q-103",type:"emergency",dept:"Radiology",name:"Robert J.",phone:"***9012",time:"08:30 AM",status:"Waiting",vc:"MT-C2Z",exp:Date.now()+86400000 },
        { id:"Q-104",type:"facility",dept:"Waste Management",name:"CleanCo Ltd",phone:"***7890",time:"08:45 AM",status:"Waiting",vc:"MT-E6V",exp:Date.now()+86400000 }
    ];
    let counter = 105, step = 1, selectedType = null, selectedTypeObj = null, selectedDept = null;

    // ==================== HELPERS ====================
    function save() { try { localStorage.setItem('meditrack_kiosk_v6', JSON.stringify({queue,counter})); } catch(e) {} }
    function load() { try { const d = localStorage.getItem('meditrack_kiosk_v6'); if(d) { const p = JSON.parse(d); queue = p.queue; counter = p.counter; } } catch(e) {} }
    
    function showToast(m, e=false) { 
        const t = document.createElement('div'); 
        t.className = `toast-message ${e?'error':''}`; 
        t.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle>${e?'<line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line>':'<path d="m9 12 2 2 4-4"></path>'}</svg> ${m}`; 
        document.body.appendChild(t); 
        setTimeout(() => t.remove(), 3500); 
    }
    
    function openModal(id) { document.getElementById(id)?.classList.add('show'); }
    function closeModal(id) { document.getElementById(id)?.classList.remove('show'); }
    function showStep(n) { [1,2,3,4].forEach(s => document.getElementById('step'+s).classList.add('hidden')); document.getElementById('step'+n).classList.remove('hidden'); step = n; }
    
    function getStatusBadge(s) { 
        const m = { 'Waiting': 'status-waiting', 'Serving': 'status-serving', 'Completed': 'status-completed' }; 
        return `<span class="status-badge ${m[s] || 'status-waiting'}">${s}</span>`; 
    }
    
    function getTypeBadge(t) { 
        const vt = VISITOR_TYPES.find(v => v.id === t) || VISITOR_TYPES[4]; // fallback to facility
        return `<span class="type-badge ${TYPE_BADGE_CLASS[t] || 'type-facility'}">${vt.label.replace(/[🚨📅🛏️🚶🏢👤]\s*/, '')}</span>`; 
    }
    
    function getTypeById(id) {
        return VISITOR_TYPES.find(v => v.id === id) || null;
    }
    
    function updateStats() {
        document.getElementById('statWaiting').textContent = queue.filter(q => q.status === 'Waiting').length;
        document.getElementById('statServing').textContent = queue.filter(q => q.status === 'Serving').length;
        document.getElementById('statCompleted').textContent = queue.filter(q => q.status === 'Completed').length;
        const emerg = queue.filter(q => q.type === 'emergency' && q.status === 'Waiting').length;
        document.getElementById('statEmergency').textContent = emerg;
        document.getElementById('statEmergencyBadge').textContent = emerg + ' urgent';
    }

    // ==================== STEP 1: RENDER VISITOR TYPE CARDS ====================
    function renderVisitorTypeCards() {
        var container = document.querySelector('#step1 .grid.gap-6');
        if (!container) return;
        
        container.innerHTML = VISITOR_TYPES.map(function(vt) {
            var isHighlight = vt.id === 'emergency';
            return `
            <div onclick="selectType('${vt.id}')" class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition cursor-pointer ${vt.bgClass}">
                <div class="flex items-center space-x-2">
                    <div class="${vt.iconBg} p-2 rounded-lg">
                        <svg class="h-5 w-5 ${vt.iconColor}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            ${vt.id === 'emergency' ? '<path d="M12 9v4"/><path d="M12 17h.01"/><circle cx="12" cy="12" r="10"/>' :
                              vt.id === 'appointment' ? '<rect width="18" height="18" x="3" y="4" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/>' :
                              vt.id === 'ipd' ? '<path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/>' :
                              vt.id === 'walkin' ? '<circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/>' :
                              vt.id === 'facility' ? '<path d="M3 7v10a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-6l-2-2H5a2 2 0 0 0-2 2z"/>' :
                              '<circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/><path d="M12 2v4"/><path d="M12 18v4"/>'}
                        </svg>
                    </div>
                    <span class="font-medium ${vt.textColor}">${vt.label}</span>
                </div>
                <div class="mt-4">
                    <div class="text-xl font-bold ${vt.titleColor}">${vt.desc}</div>
                    <p class="text-xs text-gray-500">${vt.subdesc}</p>
                </div>
                <div class="mt-6">
                    <button class="flex items-center justify-between w-full text-sm ${vt.color === 'red' ? 'text-red-600' : vt.color === 'pink' ? 'text-orange-600' : vt.color === 'emerald' ? 'text-emerald-600' : vt.color === 'indigo' ? 'text-indigo-600' : vt.color === 'teal' ? 'text-teal-600' : 'text-orange-600'} font-medium hover:underline">
                        <span>Select ${vt.label.replace(/[^\w\s]/g, '').trim().split(' ').pop()}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
                    </button>
                </div>
            </div>`;
        }).join('');
    }

    // ==================== STEP 2: SELECT TYPE + RENDER DEPARTMENTS ====================
    window.selectType = function(typeId) {
        selectedType = typeId;
        selectedTypeObj = getTypeById(typeId);
        
        var labelSpan = document.getElementById('selectedTypeLabel');
        if (labelSpan && selectedTypeObj) {
            labelSpan.innerHTML = `<span class="type-badge ${TYPE_BADGE_CLASS[typeId] || 'type-facility'}">${selectedTypeObj.label.replace(/[🚨📅🛏️🚶🏢👤]\s*/, '')}</span>`;
        }
        
        // Filter departments based on visitor type's allowed categories
        renderDepartments(selectedTypeObj);
        showStep(2);
    };

    function renderDepartments(vt) {
        if (!vt) return;
        
        // Filter: show only departments matching this visitor type's categories
        var filteredDepts = DEPARTMENTS.filter(function(d) {
            return vt.categories.indexOf(d.category) !== -1;
        });
        
        var colorMap = { 
            blue: 'bg-blue-100 text-blue-600', red: 'bg-red-100 text-red-600', 
            amber: 'bg-amber-100 text-amber-600', pink: 'bg-orange-100 text-orange-600', 
            purple: 'bg-purple-100 text-purple-600', green: 'bg-green-100 text-green-600', 
            teal: 'bg-green-100 text-teal-600', orange: 'bg-orange-100 text-orange-600', 
            cyan: 'bg-green-100 text-green-600', indigo: 'bg-blue-100 text-indigo-600', 
            emerald: 'bg-emerald-100 text-emerald-600', lime: 'bg-lime-100 text-lime-600',
            gray: 'bg-gray-100 text-gray-600'
        };
        
        document.getElementById('departmentGrid').innerHTML = filteredDepts.map(function(d) {
            var w = queue.filter(function(q) { return q.dept === d.name && q.status === 'Waiting'; }).length;
            var s = queue.find(function(q) { return q.dept === d.name && q.status === 'Serving'; });
            
            return `<div onclick="selectDept('${d.name.replace(/'/g, "\\'")}')" class="rounded-lg text-card-foreground p-4 border bg-background dark:bg-background shadow-sm hover:shadow-md transition cursor-pointer">
                <div class="flex items-center space-x-2">
                    <div class="${colorMap[d.color] || 'bg-gray-100 text-gray-600'} p-2 rounded-lg"><span class="text-xl">${d.icon}</span></div>
                    <span class="font-medium text-sm">${d.name}</span>
                    <span class="ml-auto text-sm text-blue-500 font-medium">${w} waiting</span>
                </div>
                <div class="mt-4">
                    <div class="text-lg font-bold">${s ? 'Now: ' + s.id : 'Available'}</div>
                    <p class="text-xs text-gray-500">${d.desc || '~' + Math.max(3, w*5) + ' min wait'}</p>
                </div>
                <div class="mt-6">
                    <button class="flex items-center justify-between w-full text-sm text-indigo-600 font-medium hover:underline">
                        <span>Select ${d.name}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4"><path d="M7 7h10v10"/><path d="M7 17 17 7"/></svg>
                    </button>
                </div>
            </div>`;
        }).join('');
    }

    // ==================== STEP 3: SELECT DEPARTMENT ====================
    window.selectDept = function(dept) { 
        selectedDept = dept; 
        document.getElementById('step3DeptLabel').innerHTML = `<span class="type-badge ${TYPE_BADGE_CLASS[selectedType] || 'type-facility'}">${(selectedTypeObj ? selectedTypeObj.label.replace(/[🚨📅🛏️🚶🏢👤]\s*/, '') : '')}</span> → <span class="font-semibold">${dept}</span>`; 
        
        // Adjust phone field based on visitor type
        var phoneInput = document.getElementById('visitorPhone');
        var phoneLabel = phoneInput.closest('div').querySelector('label');
        var isPhoneRequired = selectedTypeObj ? selectedTypeObj.phoneRequired : true;
        
        if (isPhoneRequired) {
            phoneInput.placeholder = "We'll notify you when it's your turn";
            if (phoneLabel) phoneLabel.innerHTML = 'Phone Number <span class="text-red-500">*</span>';
        } else {
            phoneInput.placeholder = "Company phone or contact number (optional)";
            if (phoneLabel) phoneLabel.innerHTML = 'Phone Number <span class="text-gray-400 text-xs">(optional)</span>';
        }
        
        showStep(3); 
    };
    
    window.goBack = function() { 
        if (step === 2) showStep(1); 
        else if (step === 3) showStep(2); 
    };

    // ==================== STEP 4: GENERATE TICKET ====================
    window.generateFinalTicket = function() {
        var name = document.getElementById('visitorName').value.trim();
        var phone = document.getElementById('visitorPhone').value.trim();
        var isPhoneRequired = selectedTypeObj ? selectedTypeObj.phoneRequired : true;
        
        if (!name) { showToast('Please enter your name', true); return; }
        
        // Phone required only for medical types
        if (isPhoneRequired && (!phone || phone.length < 7)) { 
            showToast('Please enter a valid phone number', true); 
            return; 
        }
        
        // Check daily limit for medical types only
        if (isPhoneRequired && phone.length >= 7) {
            if (queue.filter(function(q) { return q.phone === '***' + phone.slice(-4) && q.status !== 'Cancelled'; }).length >= 3) { 
                showToast('Maximum 3 tickets per day', true); 
                return; 
            }
        }
        
        var id = 'Q-' + (counter++);
        var vc = 'MT-' + Math.random().toString(36).substring(2,5).toUpperCase();
        var now = new Date();
        var exp = new Date(now.getTime() + 86400000);
        var maskedPhone = phone.length >= 7 ? '***' + phone.slice(-4) : (phone || 'N/A');
        
        queue.push({ 
            id: id, 
            type: selectedType, 
            dept: selectedDept, 
            name: name, 
            phone: maskedPhone, 
            time: now.toLocaleTimeString('en-US',{hour:'2-digit',minute:'2-digit',hour12:true}), 
            status: "Waiting", 
            vc: vc, 
            exp: exp.getTime() 
        }); 
        save();
        
        // Populate ticket display
        document.getElementById('ticketNum').textContent = id; 
        document.getElementById('ticketTypeBadge').textContent = selectedTypeObj ? selectedTypeObj.label.replace(/[🚨📅🛏️🚶🏢👤]\s*/, '') : 'Visitor'; 
        document.getElementById('ticketTypeBadge').className = 'type-badge ' + (TYPE_BADGE_CLASS[selectedType] || 'type-facility') + ' text-sm px-3 py-1';
        document.getElementById('ticketDeptName').textContent = selectedDept; 
        document.getElementById('ticketVisitorName').textContent = name; 
        document.getElementById('ticketVisitorPhone').textContent = maskedPhone;
        document.getElementById('ticketExpiryTime').textContent = exp.toLocaleDateString('en-US',{month:'short',day:'numeric'}) + ' ' + exp.toLocaleTimeString('en-US',{hour:'2-digit',minute:'2-digit'});
        document.getElementById('ticketEstWaitTime').textContent = '~' + Math.max(3, queue.filter(function(q) { return q.dept===selectedDept && q.status==='Waiting'; }).length * 5) + ' min';
        document.getElementById('ticketAheadPeople').textContent = queue.filter(function(q) { return q.dept===selectedDept && q.status==='Waiting'; }).length;
        document.getElementById('ticketVerifyId').textContent = vc; 
        
        showStep(4); 
        updateStats(); 
        showToast('Ticket generated'); 
        setTimeout(resetKiosk, 180000);
    };

    window.printTicket = function() { window.print(); };
    
    window.resetKiosk = function() { 
        selectedType = null; 
        selectedTypeObj = null;
        selectedDept = null; 
        document.getElementById('visitorName').value = ''; 
        document.getElementById('visitorPhone').value = ''; 
        showStep(1); 
        updateStats(); 
    };

    // ==================== STAFF PANEL ====================
    function renderStaffTable() {
        var active = queue.filter(function(q) { return q.status !== 'Completed' && q.status !== 'Cancelled'; });
        document.getElementById('staffTableBody').innerHTML = active.sort(function(a,b) {
            var pa = (getTypeById(a.type) || {priority:4}).priority;
            var pb = (getTypeById(b.type) || {priority:4}).priority;
            return pa - pb;
        }).map(function(q) {
            var vt = getTypeById(q.type);
            var isEmergency = q.type === 'emergency';
            return `<tr class="border-b data-row ${isEmergency ? 'priority-high' : ''}">
                <td class="px-4 py-3 font-medium text-indigo-600">${q.id}</td>
                <td class="px-4 py-3 text-sm">${q.name}</td>
                <td class="px-4 py-3">${getTypeBadge(q.type)}</td>
                <td class="px-4 py-3 text-sm">${q.dept}</td>
                <td class="px-4 py-3 hidden sm:table-cell text-gray-500 text-sm">${q.time}</td>
                <td class="px-4 py-3">${getStatusBadge(q.status)}</td>
                <td class="px-4 py-3 text-right"><div class="flex justify-end gap-2">
                    ${q.status==='Waiting' ? `<button onclick="callTicket('${q.id}')" class="bg-primary text-white px-3 h-8 rounded-md text-xs hover:bg-primary/90">Call</button>` : ''}
                    ${q.status==='Serving' ? `<button onclick="completeTicket('${q.id}')" class="border border-green-300 bg-green-50 text-green-700 px-3 h-8 rounded-md text-xs hover:bg-green-100">Complete</button>` : ''}
                </div></td>
            </tr>`;
        }).join('');
    }

    window.callTicket = function(id) { 
        var t = queue.find(function(q) { return q.id === id; }); 
        if(t) { 
            queue.forEach(function(q) { if(q.dept === t.dept && q.status === 'Serving') q.status = 'Completed'; }); 
            t.status = 'Serving'; 
            save(); 
            renderStaffTable(); 
            updateStats(); 
            showToast('Now serving: ' + id); 
        } 
    };
    
    window.completeTicket = function(id) { 
        var t = queue.find(function(q) { return q.id === id; }); 
        if(t) { 
            t.status = 'Completed'; 
            save(); 
            renderStaffTable(); 
            updateStats(); 
        } 
    };

    // ==================== EVENT LISTENERS ====================
    document.getElementById('helpBtn').addEventListener('click', function() { showToast('Staff has been notified. Please wait for assistance.'); });
    document.getElementById('staffPanelLink').addEventListener('click', function(e) { e.preventDefault(); renderStaffTable(); openModal('staffModal'); });
    document.getElementById('callNextGlobalBtn').addEventListener('click', function() { 
        var n = queue.filter(function(q) { return q.status === 'Waiting'; }).sort(function(a,b) {
            var pa = (getTypeById(a.type) || {priority:4}).priority;
            var pb = (getTypeById(b.type) || {priority:4}).priority;
            return pa - pb;
        })[0]; 
        if(n) { callTicket(n.id); renderStaffTable(); } 
        else showToast('No waiting tickets', true); 
    });
    
    document.querySelectorAll('.modal-close, [data-close]').forEach(function(b) {
        b.addEventListener('click', function(e) { e.stopPropagation(); closeModal(b.dataset.close || b.closest('.modal-overlay').id); });
    });
    
    document.querySelectorAll('.modal-overlay').forEach(function(o) {
        o.addEventListener('click', function(e) { if(e.target === o) closeModal(o.id); });
    });
    
    document.addEventListener('keydown', function(e) { if(e.key === 'Escape') closeModal('staffModal'); });
    
    ['cardWaiting','cardServing','cardCompleted'].forEach(function(id) {
        document.getElementById(id)?.addEventListener('click', function() { resetKiosk(); });
    });

    // ==================== INITIALIZATION ====================
    load(); 
    renderVisitorTypeCards();
    showStep(1); 
    updateStats();
    setInterval(updateStats, 30000);
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
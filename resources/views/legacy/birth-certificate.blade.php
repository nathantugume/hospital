<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Birth Certificate</title>
    <link rel="stylesheet" href="style.css">
    
    </script>    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" crossorigin="anonymous"></script>
    <style>
        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        body {
            background-color: #f0fdf4;
        }
        .certificate-font {
            font-family: 'Playfair Display', 'Inter', serif;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        @media print {
            .print\:hidden {
                display: none !important;
            }
            body {
                background-color: white !important;
                padding: 0;
                margin: 0;
            }
            .certificate-container {
                margin: 0;
                padding: 0;
                box-shadow: none;
            }
            .certificate-border {
                border: 2px solid #d1d5db !important;
            }
        }
        /* Certificate decorative styles */
        .certificate-border {
            position: relative;
        }
        .certificate-border::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border: 1px solid rgba(99, 102, 241, 0.3);
            pointer-events: none;
            border-radius: 8px;
        }
        .watermark {
            position: relative;
        }
        .watermark::after {
            content: '🏥';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 150px;
            opacity: 0.05;
            pointer-events: none;
            font-family: sans-serif;
        }
    </style>

<style>
body.dark { background-color: #131212 !important; }
body.dark .bg-white, body.dark .bg-card, body.dark .bg-background { background-color: #1a1a1a !important; border-color: #333 !important; color: #e5e5e5 !important; }
body.dark .text-gray-900, body.dark .text-gray-800, body.dark .text-gray-700 { color: #e5e5e5 !important; }
body.dark .text-gray-600, body.dark .text-gray-500 { color: #9ca3af !important; }
body.dark .text-gray-400 { color: #6b7280 !important; }
body.dark .bg-gray-100, body.dark .bg-muted, body.dark .bg-gray-50 { background-color: #262626 !important; }
body.dark .bg-gray-200 { background-color: #333 !important; }
body.dark .border-gray-200, body.dark .border-gray-300 { border-color: #404040 !important; }
body.dark .bg-indigo-50 { background-color: #1e1b4b !important; }
body.dark .text-indigo-600 { color: #818cf8 !important; }
body.dark input, body.dark textarea, body.dark select { background-color: #262626 !important; border-color: #404040 !important; color: #e5e5e5 !important; }
body.dark input::placeholder, body.dark textarea::placeholder { color: #6b7280 !important; }
body.dark .shadow-sm { box-shadow: 0 1px 2px 0 rgba(0,0,0,0.3) !important; }
body.dark .modal-container, body.dark [class*="modal"] { background-color: #1a1a1a !important; }
body.dark table thead { background-color: #262626 !important; }
body.dark table tbody tr:hover { background-color: #333 !important; }
body.dark .action-menu { background: #2a2a2a !important; border-color: #404040 !important; }
body.dark .action-item { color: #e5e5e5 !important; }
body.dark .action-item:hover { background: #333 !important; }
body.dark .action-divider { background: #404040 !important; }
body.dark ::-webkit-scrollbar-track { background: #1a1a1a !important; }
body.dark ::-webkit-scrollbar-thumb { background: #555 !important; }
body.dark .switch-root[data-state="checked"] { background-color: #4f46e5 !important; }
body.dark .switch-root[data-state="unchecked"] { background-color: #404040 !important; }
body.dark .tab-btn[data-state="active"] { background: #1a1a1a !important; color: #e5e5e5 !important; }
body.dark .tab-btn[data-state="inactive"] { color: #9ca3af !important; }
body.dark a { color: #818cf8 !important; }
body.dark .bg-green-100 { background-color: #064e3b !important; }
body.dark .text-green-700 { color: #6ee7b7 !important; }
body.dark .bg-red-100 { background-color: #7f1d1d !important; }
body.dark .text-red-700 { color: #fca5a5 !important; }
body.dark .bg-amber-100 { background-color: #78350f !important; }
body.dark .text-amber-700 { color: #fcd34d !important; }
body.dark .bg-blue-100 { background-color: #1e3a8a !important; }
body.dark .text-blue-700 { color: #93c5fd !important; }
body.dark .bg-purple-100 { background-color: #4c1d95 !important; }
body.dark .text-purple-700 { color: #c4b5fd !important; }
</style>

</head>
<body class="bg-gradient-to-br from-green-50 to-indigo-50 font-sans antialiased">

<div class="flex min-h-screen flex-col">
    <!-- Header - Hidden when printing -->
<!-- Sticky Header -->
<header class="sticky top-0 z-40 border-b bg-background duration-300 shadow-sm border-gray-200 print:hidden">
    <div class="flex h-16 items-center justify-between px-4 md:px-6">
        <button class="focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class=" accordion-arrowlucide lucide-menu">
                <line x1="4" x2="20" y1="12" y2="12"></line>
                <line x1="4" x2="20" y1="6" y2="6"></line>
                <line x1="4" x2="20" y1="18" y2="18"></line>
            </svg>
        </button>
        <div class="ml-auto flex items-center space-x-4">
            <div class="flex items-center gap-4">
                <button id="themeToggleBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-gray-100 size-10" aria-label="Toggle theme">
                    <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="hidden text-gray-600">
                        <circle cx="12" cy="12" r="4"></circle>
                        <path d="M12 2v2"></path>
                        <path d="M12 20v2"></path>
                        <path d="m4.93 4.93 1.41 1.41"></path>
                        <path d="m17.66 17.66 1.41 1.41"></path>
                        <path d="M2 12h2"></path>
                        <path d="M20 12h2"></path>
                        <path d="m6.34 17.66-1.41 1.41"></path>
                        <path d="m19.07 4.93-1.41 1.41"></path>
                    </svg>
                    <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-600">
                        <path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path>
                    </svg>
                </button>

                <!-- Notifications Dropdown -->
                <div class="relative">
                    <button id="notificationsBtn" class="inline-flex items-center justify-center rounded-md transition-colors hover:bg-gray-100 size-10 relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path></svg>
                        <span class="absolute right-1 top-1 flex h-2 w-2 rounded-full bg-red-500"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-500 opacity-75"></span></span>
                    </button>
                    <div id="notificationsDropdown" class="hidden absolute right-0 mt-2 z-50 w-80 rounded-md border bg-background shadow-lg overflow-hidden">
                        <div class="px-3 py-2 text-sm font-semibold flex justify-between border-b"><span>Notifications</span><button id="markAllReadBtn" class="text-xs text-indigo-600">Mark all as read</button></div>
                        <div class="max-h-[300px] overflow-y-auto">
                            <div class="p-3 text-center text-gray-500">No new notifications</div>
                        </div>
                        <div class="p-2 text-center border-t"><a href="notifications.html" class="text-sm text-indigo-600">View all notifications</a></div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button id="profileBtn" class="flex items-center justify-center h-8 w-8 rounded-full hover:ring-2 hover:ring-gray-200">
                        <img src="user.png" alt="Profile" class="h-8 w-8 rounded-full object-cover" onerror="this.src='https://placehold.co/32x32?text=U'">
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
                        <div class="border-t my-1"></div>
                        <a href="login.html" class="flex items-center gap-2 px-2 py-1.5 text-sm text-red-600 hover:bg-gray-100 rounded">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" x2="9" y1="12" y2="12"></line></svg>
                            Log out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

    <!-- Main Certificate Content -->
    <main class="flex-1 overflow-auto p-4 md:p-8 print:p-0">
        <!-- Action Buttons - Centered -->
<div class="flex justify-center gap-3 mb-6 print:hidden">
    <button id="printBtn" class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium border border-gray-300 bg-background hover:bg-gray-100 h-10 px-4 py-2 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 9V3a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v6"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>
        Print Certificate
    </button>
    <button id="downloadBtn" class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium bg-primary text-white hover:bg-primary/90 h-10 px-4 py-2 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>
        Download PDF
    </button>
    <a href="birth-records-details.html" class="inline-flex items-center justify-center gap-2 rounded-md text-sm font-medium border border-gray-300 bg-background hover:bg-gray-100 h-10 px-4 py-2 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m15 18-6-6 6-6"/></svg>
        Back to Record
    </a>
</div>
        <div class="container mx-auto flex justify-center items-center min-h-[calc(100vh-8rem)] print:min-h-0">
            <div id="certificateContent" class="certificate-container w-full max-w-4xl">
                <!-- Certificate Card -->
                <div class="bg-background rounded-xl shadow-2xl overflow-hidden certificate-border print:shadow-none print:rounded-none">
                    <!-- Decorative top border -->
                    <div class="h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
                    
                    <div class="p-6 md:p-10 lg:p-12 watermark">
                        <!-- Hospital Logo & Header -->
                        <div class="text-center mb-8">
                            <div class="flex justify-center mb-4">
                                <div class="w-24 h-24 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center shadow-md">
                                    <img src="logo.png" alt="Medi-track" class="w-16 h-16 object-contain" onerror="this.src="logo.png"">
                                </div>
                            </div>
                            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold certificate-font text-indigo-900 mb-2">Certificate of Birth</h1>
                            <p class="text-gray-500 text-sm md:text-base">Official Birth Registration Document</p>
                            <div class="mt-3 inline-block bg-indigo-50 px-4 py-1 rounded-full">
                                <span class="text-xs md:text-sm font-medium text-indigo-700">Certificate No: BC-2023-0542</span>
                            </div>
                        </div>

                        <!-- Ornamental Divider -->
                        <div class="flex justify-center items-center gap-3 my-6">
                            <div class="h-px flex-1 bg-gradient-to-r from-transparent via-indigo-300 to-transparent"></div>
                            <svg class="w-6 h-6 text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12z"/><circle cx="10" cy="10" r="2"/></svg>
                            <div class="h-px flex-1 bg-gradient-to-r from-transparent via-indigo-300 to-transparent"></div>
                        </div>

                        <!-- Main Content -->
                        <div class="space-y-6">
                            <!-- Child Information Section -->
                            <div class="border-2 border-indigo-100 rounded-lg p-5 bg-gradient-to-r from-indigo-50/30 to-transparent">
                                <h2 class="text-xl md:text-2xl font-bold certificate-font text-indigo-800 mb-4 flex items-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"  d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                    Child Information
                                </h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div><p class="text-xs text-gray-500 uppercase tracking-wide">Full Name</p><p class="text-lg font-semibold text-gray-800">Nalwoga Emma</p></div>
                                    <div><p class="text-xs text-gray-500 uppercase tracking-wide">Gender</p><p class="text-lg font-semibold text-gray-800">Female</p></div>
                                    <div><p class="text-xs text-gray-500 uppercase tracking-wide">Date of Birth</p><p class="text-lg font-semibold text-gray-800">May 15, 2023</p></div>
                                    <div><p class="text-xs text-gray-500 uppercase tracking-wide">Time of Birth</p><p class="text-lg font-semibold text-gray-800">08:30 AM</p></div>
                                    <div><p class="text-xs text-gray-500 uppercase tracking-wide">Place of Birth</p><p class="text-lg font-semibold text-gray-800">Mulago National Referral Hospital</p></div>
                                    <div><p class="text-xs text-gray-500 uppercase tracking-wide">Weight & Height</p><p class="text-lg font-semibold text-gray-800">3.2 kg / 50 cm</p></div>
                                </div>
                            </div>

                            <!-- Parents Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="border-2 border-indigo-100 rounded-lg p-5 bg-gradient-to-r from-indigo-50/30 to-transparent">
                                    <h2 class="text-lg md:text-xl font-bold certificate-font text-indigo-800 mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                        Mother's Information
                                    </h2>
                                    <div class="space-y-2">
                                        <div><p class="text-xs text-gray-500">Full Name</p><p class="font-medium text-gray-800">Nakato Sarah</p></div>
                                        <div><p class="text-xs text-gray-500">Date of Birth</p><p class="font-medium text-gray-800">March 12, 1988</p></div>
                                        <div><p class="text-xs text-gray-500">Nationality</p><p class="font-medium text-gray-800">American</p></div>
                                        <div><p class="text-xs text-gray-500">Occupation</p><p class="font-medium text-gray-800">Software Engineer</p></div>
                                    </div>
                                </div>
                                <div class="border-2 border-indigo-100 rounded-lg p-5 bg-gradient-to-r from-indigo-50/30 to-transparent">
                                    <h2 class="text-lg md:text-xl font-bold certificate-font text-indigo-800 mb-3 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Father's Information
                                    </h2>
                                    <div class="space-y-2">
                                        <div><p class="text-xs text-gray-500">Full Name</p><p class="font-medium text-gray-800">Kimera John</p></div>
                                        <div><p class="text-xs text-gray-500">Date of Birth</p><p class="font-medium text-gray-800">July 22, 1986</p></div>
                                        <div><p class="text-xs text-gray-500">Nationality</p><p class="font-medium text-gray-800">American</p></div>
                                        <div><p class="text-xs text-gray-500">Occupation</p><p class="font-medium text-gray-800">Architect</p></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Medical Information -->
                            <div class="border-2 border-indigo-100 rounded-lg p-5 bg-gradient-to-r from-indigo-50/30 to-transparent">
                                <h2 class="text-lg md:text-xl font-bold certificate-font text-indigo-800 mb-3 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"  d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 9h-6L8 4z"/></svg>
                                    Medical Information
                                </h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div><p class="text-xs text-gray-500">Attending Doctor</p><p class="font-medium text-gray-800">Dr. Lisa Chen</p></div>
                                    <div><p class="text-xs text-gray-500">Hospital/Facility</p><p class="font-medium text-gray-800">Mulago National Referral Hospital</p></div>
                                    <div class="md:col-span-2"><p class="text-xs text-gray-500">Remarks</p><p class="font-medium text-gray-800">Normal delivery without complications. Mother and baby are healthy.</p></div>
                                </div>
                            </div>
                        </div>

                        <!-- Signature and Seal Section -->
                        <div class="border-t-2 border-indigo-200 pt-6 mt-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="text-center">
                                    <div class="mb-2">
                                        <svg class="w-12 h-12 mx-auto text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 9h6m-6 3h6m-6 3h6M3 9h6m-6 3h6m-6 3h6M9 3v18M12 3v18M15 3v18M18 3v18"/></svg>
                                    </div>
                                    <div class="border-t-2 border-gray-300 w-48 mx-auto mb-2"></div>
                                    <p class="text-sm font-medium text-gray-700">Registrar's Signature</p>
                                    <p class="text-xs text-gray-500">Dr. Emily Carter</p>
                                </div>
                                <div class="text-center">
                                    <div class="mb-2">
                                        <div class="w-16 h-16 mx-auto bg-gradient-to-br from-indigo-100 to-purple-100 rounded-full flex items-center justify-center">
                                            <span class="text-2xl">🏥</span>
                                        </div>
                                    </div>
                                    <div class="border-t-2 border-gray-300 w-48 mx-auto mb-2"></div>
                                    <p class="text-sm font-medium text-gray-700">Official Seal</p>
                                    <p class="text-xs text-gray-500">Mulago National Referral Hospital</p>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="text-center mt-8 pt-4 border-t border-gray-200">
                            <p class="text-xs text-gray-500">Registered on May 17, 2023 in accordance with the Civil Registry Law</p>
                            <p class="text-xs text-gray-500 mt-1">This certificate is an official document and any alteration or falsification is punishable by law</p>
                            <p class="text-xs text-gray-400 mt-3">Medi-track Health System | www.meditrack.com</p>
                        </div>
                    </div>
                    
                    <!-- Decorative bottom border -->
                    <div class="h-2 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
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


    (function() {
        // Print functionality
        const printBtn = document.getElementById('printBtn');
        const downloadBtn = document.getElementById('downloadBtn');
        const certificateContent = document.getElementById('certificateContent');

        // Print certificate
        printBtn.addEventListener('click', () => {
            window.print();
        });

        // Download as PDF
        downloadBtn.addEventListener('click', () => {
            const element = certificateContent;
            const opt = {
                margin: [0.5, 0.5, 0.5, 0.5],
                filename: 'Birth_Certificate_BC-2023-0542.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { 
                    scale: 2,
                    letterRendering: true,
                    useCORS: true,
                    logging: false
                },
                jsPDF: { 
                    unit: 'in', 
                    format: 'letter', 
                    orientation: 'portrait' 
                }
            };
            html2pdf().set(opt).from(element).save();
        });



    })();
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
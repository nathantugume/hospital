<header class="sticky top-0 z-40 border-b bg-background shadow-sm border-gray-200">
            <div class="flex h-16 items-center justify-between px-4 md:px-6">
                <div class="flex items-center gap-2">
                    <button type="button" class="focus:outline-none" data-menu-toggle aria-controls="primary-navigation" aria-expanded="false" aria-label="Toggle navigation"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="18" y2="18"></line></svg></button>
                    <a href="{{ route('dashboard') }}" id="headerLogo" class="flex items-center space-x-2">
                        <img alt="Medi-track" src="{{ asset('logo.png') }}" class="h-8 " >
                        <span class="font-bold text-xl">Medi-track</span>
                    </a>
                </div>
            <div class="flex items-center gap-4">
                <!-- Fullscreen Toggle Button -->
                <span id="meditrack-lang-btn" class="inline-flex items-center justify-center gap-1 rounded-md border border-gray-200 bg-white px-2.5 py-1.5 text-sm font-medium text-gray-700 transition-colors hover:border-indigo-500 hover:bg-gray-50 size-10" aria-label="Language">
                        <span style="font-size: 16px;">🇬🇧</span>
                        <span class="hidden sm:inline">EN</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </span>

                <!-- Theme Toggle Button -->
                <button id="themeToggleBtn" class="inline-flex items-center justify-center rounded-md text-sm font-medium transition-colors hover:bg-gray-100 size-10" aria-label="Toggle theme">
                    <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="hidden text-gray-600"><circle cx="12" cy="12" r="4"></circle><path d="M12 2v2"></path><path d="M12 20v2"></path><path d="m4.93 4.93 1.41 1.41"></path><path d="m17.66 17.66 1.41 1.41"></path><path d="M2 12h2"></path><path d="M20 12h2"></path><path d="m6.34 17.66-1.41 1.41"></path><path d="m19.07 4.93-1.41 1.41"></path></svg>
                    <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="text-gray-600"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"></path></svg>
                </button>

                <details class="relative header-menu">
 <summary class="inline-flex items-center justify-center rounded-md size-10 cursor-pointer relative" aria-label="Notifications"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4"/></svg>@if($headerNotifications->contains('is_read', false))<span class="absolute top-1 right-1 h-2 w-2 rounded-full bg-red-500" aria-label="Unread notifications"></span>@endif</summary>
 <div class="absolute right-0 mt-2 w-64 rounded-md border bg-background shadow-lg p-4 text-sm"><strong>Notifications</strong>@forelse($headerNotifications as $notification)<div class="py-3 border-b"><p class="font-medium">{{ $notification->title }}</p><p class="text-gray-500">{{ $notification->message }}</p><p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p></div>@empty<p class="mt-2 text-gray-500">No new notifications.</p>@endforelse</div>
</details>
<details class="relative header-menu">
 <summary class="flex items-center cursor-pointer" aria-label="Account menu"><img src="{{ asset('user.png') }}" alt="" class="h-8 w-8 rounded-full"></summary>
 <div class="absolute right-0 mt-2 w-64 rounded-md border bg-background shadow-lg p-2">
  <div class="px-2 py-2 border-b"><p class="text-sm font-medium">{{ auth()->user()->name }}</p><p class="text-xs text-gray-500">{{ auth()->user()->role_label }}</p></div>
  @if(auth()->user()->isAdmin())<a href="{{ route('admin.settings.edit') }}" class="block px-2 py-2 text-sm hover:bg-gray-100 rounded">Settings</a>@endif
  <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="w-full text-left px-2 py-2 text-sm text-red-600 hover:bg-gray-100 rounded">Sign out</button></form>
 </div>
</details>
</div></div></header>

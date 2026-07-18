// ============================================
// SIDEBAR MODULE - Responsive sidebar management
// ============================================
(function(window, document) {
    'use strict';
    
    let sidebar, menuBtn, closeBtn;
    const MOBILE_BREAKPOINT = 1280;
    
    function isMobile() {
        return window.innerWidth < MOBILE_BREAKPOINT;
    }
    
    function updateLayout() {
        const header = document.querySelector('header');
        const main = document.querySelector('main');
        const headerLogo = document.getElementById('headerLogo');
        
        if (!header || !main) return;
        
        if (window.innerWidth >= MOBILE_BREAKPOINT) {
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
    
    function openSidebar() {
        if (!sidebar) return;
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        localStorage.setItem('sidebarOpen', 'true');
        if (isMobile()) {
            document.body.classList.add('sidebar-open');
            document.body.style.overflow = 'hidden';
        }
        updateLayout();
    }
    
    function closeSidebar() {
        if (!sidebar) return;
        sidebar.classList.add('-translate-x-full');
        sidebar.classList.remove('translate-x-0');
        localStorage.setItem('sidebarOpen', 'false');
        if (isMobile()) {
            document.body.classList.remove('sidebar-open');
            document.body.style.overflow = '';
        }
        updateLayout();
    }
    
    function toggleSidebar() {
        if (!sidebar) return;
        sidebar.classList.contains('-translate-x-full') ? openSidebar() : closeSidebar();
    }
    
    function setupSidebar() {
        if (!sidebar) return;
        const isMobileView = isMobile();
        const savedState = localStorage.getItem('sidebarOpen');
        document.body.style.overflow = '';
        document.body.classList.remove('sidebar-open');
        
        if (isMobileView) {
            closeSidebar();
        } else {
            savedState === 'false' ? closeSidebar() : openSidebar();
        }
        updateLayout();
    }
    
    function init() {
        sidebar = document.querySelector('aside');
        if (!sidebar) return;
        
        menuBtn = document.querySelector('header button:first-child');
        closeBtn = document.querySelector('aside .xl\\:hidden');
        
        if (menuBtn) {
            const newBtn = menuBtn.cloneNode(true);
            menuBtn.parentNode.replaceChild(newBtn, menuBtn);
            document.querySelector('header button:first-child').addEventListener('click', (e) => {
                e.stopPropagation();
                toggleSidebar();
            });
        }
        
        if (closeBtn) {
            const newBtn = closeBtn.cloneNode(true);
            closeBtn.parentNode.replaceChild(newBtn, closeBtn);
            document.querySelector('aside .xl\\:hidden').addEventListener('click', (e) => {
                e.stopPropagation();
                closeSidebar();
            });
        }
        
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(setupSidebar, 150);
        });
        
        document.addEventListener('click', (e) => {
            if (isMobile() && sidebar && !sidebar.classList.contains('-translate-x-full')) {
                if (!sidebar.contains(e.target) && !menuBtn?.contains(e.target)) {
                    closeSidebar();
                }
            }
        });
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar && !sidebar.classList.contains('-translate-x-full')) {
                closeSidebar();
            }
        });
        
        setupSidebar();
        
        const mainEl = document.querySelector('main');
        if (mainEl) mainEl.classList.remove('xl:ml-64');
        
        const headerDiv = document.querySelector('header > div');
        if (headerDiv) headerDiv.style.width = '100%';
    }
    
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
    
    window.MeditrackSidebar = {
        open: openSidebar,
        close: closeSidebar,
        toggle: toggleSidebar,
        isOpen: () => sidebar && !sidebar.classList.contains('-translate-x-full')
    };
    
})(window, document);
// === ADDITIONAL SIDEBAR LINKS (auto-injected) ===
(function() {
    'use strict';
    const additionalLinks = [
        { href: 'payroll.html', label: 'Payroll', icon: '<path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>', section: 'admin' },
        { href: 'super-admin.html', label: 'Super Admin', icon: '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>', section: 'admin' },
        { href: 'roles-permissions.html', label: 'Roles & Permissions', icon: '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/>', section: 'admin' },
        { href: 'integrations.html', label: 'Integrations', icon: '<path d="M22 12h-4l-3 9L9 3l-3 9H2"/>', section: 'system' },
        { href: 'pricing.html', label: 'Pricing Plans', icon: '<path d="M12 2v20M2 7h20M2 17h20"/>', section: 'system' },
        { href: 'birth-records.html', label: 'Birth Records', icon: '<path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="10"/>', section: 'records' },
        { href: 'death-records.html', label: 'Death Records', icon: '<path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="10"/>', section: 'records' },
        { href: 'vaccination.html', label: 'Vaccination', icon: '<path d="M11 2v20M5 2v6c0 2 2 4 4 4M19 2v6c0 2-2 4-4 4"/>', section: 'clinical' },
        { href: 'physiotherapy-dashboard.html', label: 'Physiotherapy', icon: '<path d="M6.5 6.5h11M6.5 17.5h11M4 6.5v11M20 6.5v11"/>', section: 'clinical' },
        { href: 'feedback.html', label: 'Surveys', icon: '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>', section: 'communication' },
        { href: 'support.html', label: 'Support', icon: '<path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/>', section: 'communication' },
    ];
    
    function injectAdditionalLinks() {
        const sidebar = document.querySelector('.sidebar, nav, [class*="sidebar"]');
        if (!sidebar) return;
        
        additionalLinks.forEach(link => {
            // Skip if already present
            if (sidebar.querySelector('a[href="' + link.href + '"]')) return;
            
            // Find appropriate section based on the section field
            let targetSection = null;
            const sections = sidebar.querySelectorAll('div, section, [class*="section"], [class*="group"]');
            for (const section of sections) {
                const text = section.textContent.toLowerCase();
                if (link.section === 'admin' && (text.includes('staff') || text.includes('admin') || text.includes('management'))) {
                    targetSection = section;
                    break;
                } else if (link.section === 'system' && (text.includes('setting') || text.includes('system'))) {
                    targetSection = section;
                    break;
                } else if (link.section === 'records' && (text.includes('record') || text.includes('patient'))) {
                    targetSection = section;
                    break;
                } else if (link.section === 'clinical' && (text.includes('lab') || text.includes('pharma') || text.includes('clinical'))) {
                    targetSection = section;
                    break;
                } else if (link.section === 'communication' && (text.includes('chat') || text.includes('email') || text.includes('calendar'))) {
                    targetSection = section;
                    break;
                }
            }
            
            // If no section found, append to the sidebar itself
            const container = targetSection || sidebar;
            
            // Create the link
            const a = document.createElement('a');
            a.href = link.href;
            a.className = 'flex items-center rounded-md px-3 py-2 text-sm font-medium transition-colors text-gray-600 hover:bg-gray-100 hover:text-gray-900';
            a.innerHTML = '<svg class="mr-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">' + link.icon + '</svg>' + link.label;
            
            container.appendChild(a);
        });
    }
    
    // Run after sidebar is rendered
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => setTimeout(injectAdditionalLinks, 500));
    } else {
        setTimeout(injectAdditionalLinks, 500);
    }
    setTimeout(injectAdditionalLinks, 1500);
})();

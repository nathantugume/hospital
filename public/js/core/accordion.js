// ============================================
// ACCORDION MODULE - Sidebar navigation accordion
// ============================================
(function(window, document) {
    'use strict';
    
    // Accordion config - maps toggle button classes to their submenu selectors
    const ACCORDION_CONFIG = {
        'dashboard-toggle': '.dashboard-submenu',
        'doctors-toggle': '.doctors-submenu',
        'physio-toggle': '.physio-submenu',
        'appointments-toggle': '.appointments-submenu',
        'vaccination-toggle': '.vaccination-submenu',
        'prescriptions-toggle': '.prescriptions-submenu',
        'radiology-toggle': '.radiology-submenu',
        'ambulance-toggle': '.ambulance-submenu',
        'surgery-toggle': '.surgery-submenu',
        'laboratory-toggle': '.laboratory-submenu',
        'bloodbank-toggle': '.bloodbank-submenu',
        'billing-toggle': '.billing-submenu',
        'departments-toggle': '.departments-submenu',
        'inventory-toggle': '.inventory-submenu',
        'staff-toggle': '.staff-submenu',
        'records-toggle': '.records-submenu',
        'rooms-toggle': '.rooms-submenu',
        'reviews-toggle': '.reviews-submenu',
        'reports-toggle': '.reports-submenu',
        'settings-toggle': '.settings-submenu',
        'auth-toggle': '.auth-submenu'
    };
    
    // Arrow class mapping - toggle class to arrow class
    const ARROW_MAP = {
        'physio-toggle': '.physio-arrow',
        'doctors-toggle': '.doctors-arrow',
        'appointments-toggle': '.appointments-arrow',
        'dashboard-toggle': '.dashboard-arrow',
        'vaccination-toggle': '.vaccination-arrow',
        'prescriptions-toggle': '.prescriptions-arrow',
        'radiology-toggle': '.radiology-arrow',
        'ambulance-toggle': '.ambulance-arrow',
        'surgery-toggle': '.surgery-arrow',
        'laboratory-toggle': '.laboratory-arrow',
        'bloodbank-toggle': '.bloodbank-arrow',
        'billing-toggle': '.billing-arrow',
        'departments-toggle': '.departments-arrow',
        'inventory-toggle': '.inventory-arrow',
        'staff-toggle': '.staff-arrow',
        'records-toggle': '.records-arrow',
        'rooms-toggle': '.rooms-arrow',
        'reviews-toggle': '.reviews-arrow',
        'reports-toggle': '.reports-arrow',
        'settings-toggle': '.settings-arrow',
        'auth-toggle': '.auth-arrow'
    };
    
    function getCurrentPage() {
        const path = window.location.pathname;
        return path.split('/').pop() || 'index.html';
    }
    
    function isLinkActive(link) {
        const href = link.getAttribute('href');
        if (!href) return false;
        const linkPage = href.split('/').pop();
        const currentPage = getCurrentPage();
        return linkPage === currentPage || 
               (linkPage === 'index.html' && currentPage === '') ||
               linkPage === currentPage;
    }
    
    function setActiveLink(activeLink) {
        // Remove all active states
        document.querySelectorAll('aside nav a').forEach(link => {
            link.classList.remove('bg-indigo-50', 'text-indigo-700', 'font-medium');
            link.classList.add('text-gray-600');
        });
        
        // Also remove from any toggle buttons
        document.querySelectorAll('aside nav button[class*="toggle"]').forEach(btn => {
            btn.classList.remove('bg-indigo-50', 'text-indigo-700');
            btn.classList.add('text-gray-700');
        });
        
        // Set new active state
        if (activeLink) {
            activeLink.classList.remove('text-gray-600');
            activeLink.classList.add('bg-indigo-50', 'text-indigo-700', 'font-medium');
            
            // Also highlight the parent toggle button
            const parent = findParentAccordion(activeLink);
            if (parent) {
                const parentToggle = document.querySelector(`.${parent.toggleClass}`);
                if (parentToggle) {
                    parentToggle.classList.remove('text-gray-700');
                    parentToggle.classList.add('bg-indigo-50', 'text-indigo-700');
                }
            }
        }
    }
    
    function getArrow(toggle) {
        if (!toggle) return null;
        // First try to find by mapped arrow class
        for (const [toggleClass, arrowClass] of Object.entries(ARROW_MAP)) {
            if (toggle.classList.contains(toggleClass)) {
                return toggle.querySelector(arrowClass) || toggle.querySelector('svg:last-child');
            }
        }
        // Fallback: last SVG with a polyline
        const arrow = toggle.querySelector('svg:last-child');
        if (arrow && arrow.querySelector('polyline')) return arrow;
        return toggle.querySelector('svg:last-child');
    }
    
    function closeAll() {
        Object.entries(ACCORDION_CONFIG).forEach(([toggleClass, subSelector]) => {
            const submenu = document.querySelector(subSelector);
            const toggle = document.querySelector(`.${toggleClass}`);
            const arrow = getArrow(toggle);
            
            if (submenu) submenu.classList.add('hidden');
            if (arrow) arrow.style.transform = 'rotate(0deg)';
        });
        localStorage.setItem('openAccordion', '');
    }
    
    function openAccordion(toggleClass, subSelector) {
        closeAll();
        
        const toggle = document.querySelector(`.${toggleClass}`);
        const submenu = document.querySelector(subSelector);
        const arrow = getArrow(toggle);
        
        if (submenu) submenu.classList.remove('hidden');
        if (arrow) arrow.style.transform = 'rotate(180deg)';
        
        localStorage.setItem('openAccordion', toggleClass);
    }
    
    function closeAccordion(toggleClass, subSelector) {
        const toggle = document.querySelector(`.${toggleClass}`);
        const submenu = document.querySelector(subSelector);
        const arrow = getArrow(toggle);
        
        if (submenu) submenu.classList.add('hidden');
        if (arrow) arrow.style.transform = 'rotate(0deg)';
        
        if (localStorage.getItem('openAccordion') === toggleClass) {
            localStorage.setItem('openAccordion', '');
        }
    }
    
    function toggleAccordion(toggleClass, subSelector) {
        const submenu = document.querySelector(subSelector);
        const isOpen = submenu && !submenu.classList.contains('hidden');
        isOpen ? closeAccordion(toggleClass, subSelector) : openAccordion(toggleClass, subSelector);
    }
    
    function findParentAccordion(link) {
        for (const [toggleClass, subSelector] of Object.entries(ACCORDION_CONFIG)) {
            const submenu = document.querySelector(subSelector);
            if (submenu?.contains(link)) {
                return { toggleClass, subSelector };
            }
        }
        return null;
    }
    
    function openSilent(toggleClass, subSelector) {
        const toggle = document.querySelector(`.${toggleClass}`);
        const submenu = document.querySelector(subSelector);
        const arrow = getArrow(toggle);
        
        // Close all others
        Object.entries(ACCORDION_CONFIG).forEach(([otherToggleClass, otherSubSelector]) => {
            if (otherToggleClass !== toggleClass) {
                const otherSubmenu = document.querySelector(otherSubSelector);
                const otherToggle = document.querySelector(`.${otherToggleClass}`);
                const otherArrow = getArrow(otherToggle);
                if (otherSubmenu) otherSubmenu.classList.add('hidden');
                if (otherArrow) otherArrow.style.transform = 'rotate(0deg)';
            }
        });
        
        // Open this one
        if (submenu) submenu.classList.remove('hidden');
        if (arrow) arrow.style.transform = 'rotate(180deg)';
        
        localStorage.setItem('openAccordion', toggleClass);
    }
    
    function initNavigation() {
        let activeLink = null;
        
        // Find the link matching current page
        document.querySelectorAll('aside nav a').forEach(link => {
            if (isLinkActive(link)) activeLink = link;
        });
        
        if (activeLink) {
            setActiveLink(activeLink);
            const parent = findParentAccordion(activeLink);
            if (parent) {
                openSilent(parent.toggleClass, parent.subSelector);
                return;
            }
        }
        
        // Restore saved accordion
        const saved = localStorage.getItem('openAccordion');
        if (saved && ACCORDION_CONFIG[saved]) {
            openSilent(saved, ACCORDION_CONFIG[saved]);
        }
    }
    
    function init() {
        // Check if current page uses accordion navigation
        const hasAccordionItems = document.querySelector('.dashboard-toggle, .doctors-toggle, .physio-toggle, .appointments-toggle');
        if (!hasAccordionItems) return;
        
        // Add click handlers to all toggle buttons
        Object.entries(ACCORDION_CONFIG).forEach(([toggleClass, subSelector]) => {
            const toggle = document.querySelector(`.${toggleClass}`);
            if (toggle) {
                // Clone to remove existing listeners
                const newToggle = toggle.cloneNode(true);
                toggle.parentNode.replaceChild(newToggle, toggle);
                
                // Add fresh listener
                const freshToggle = document.querySelector(`.${toggleClass}`);
                if (freshToggle) {
                    freshToggle.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        toggleAccordion(toggleClass, subSelector);
                    });
                }
            }
        });
        
        // Add click handlers to all nav links for active state
        document.querySelectorAll('aside nav a').forEach(link => {
            link.addEventListener('click', function() {
                setActiveLink(this);
            });
        });
        
        // Initialize navigation state
        initNavigation();
    }
    
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();
    
})(window, document);
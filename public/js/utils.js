// ============================================
// MAIN INITIALIZATION - Loads all modules
// ============================================
(function(window, document) {
    'use strict';
    
    const loadedModules = new Set();

    function log(message) {
        if (window.MeditrackDebug) console.log(`[Meditrack] ${message}`);
    }

    function init() {
        log('🚀 Initializing Meditrack system...');

        // Core Settings Manager
        if (typeof window.MeditrackSettings !== 'undefined') {
            log('✅ Settings Manager loaded');
            loadedModules.add('settings');
        }

        // Core Modules
        if (typeof window.MeditrackTheme !== 'undefined') {
            log('✅ Theme module loaded');
            loadedModules.add('theme');
        }

        if (typeof window.MeditrackSidebar !== 'undefined') {
            log('✅ Sidebar module loaded');
            loadedModules.add('sidebar');
        }

        if (typeof window.MeditrackNotifications !== 'undefined') {
            log('✅ Notifications module loaded');
            loadedModules.add('notifications');
        }

        if (typeof window.MeditrackProfile !== 'undefined' || document.getElementById('profileBtn')) {
            log('✅ Profile module loaded');
            loadedModules.add('profile');
        }

        // Feature Modules
        if (typeof window.MeditrackCurrency !== 'undefined') {
            log('✅ Currency module loaded');
            loadedModules.add('currency');
        }

        if (typeof window.MeditrackTabs !== 'undefined') {
            log('✅ Tabs module loaded');
            loadedModules.add('tabs');
        }

        if (typeof window.MeditrackPipWidget !== 'undefined') {
            log('✅ PiP Widget module loaded');
            loadedModules.add('pip-widget');
        }

        log(`✅ System ready! ${loadedModules.size} modules loaded: ${Array.from(loadedModules).join(', ')}`);

        // Fire global ready event
        window.dispatchEvent(new CustomEvent('meditrack-ready', {
            detail: { modules: Array.from(loadedModules) }
        }));
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})(window, document);
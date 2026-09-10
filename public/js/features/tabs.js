// ============================================
// TABS MODULE - Settings page tab switching
// ============================================
(function (window, document) {
    'use strict';

    function MeditrackTabsController() {
        this.init();
    }

    MeditrackTabsController.prototype.init = function () {
        var self = this;
        document.querySelectorAll('.tab-btn').forEach(function (btn) {
            btn.addEventListener('click', function () { self.switchTab(btn); });
        });
        // Activate first tab that is already marked active, or the first one
        var active = document.querySelector('.tab-btn[data-state="active"]') ||
                     document.querySelector('.tab-btn');
        if (active) self.switchTab(active);
    };

    MeditrackTabsController.prototype.switchTab = function (activeBtn) {
        var tabId = activeBtn.getAttribute('data-tab');

        document.querySelectorAll('.tab-btn').forEach(function (b) {
            b.classList.remove('active');
            b.setAttribute('data-state', 'inactive');
        });
        activeBtn.classList.add('active');
        activeBtn.setAttribute('data-state', 'active');

        document.querySelectorAll('[role="tabpanel"]').forEach(function (panel) {
            panel.setAttribute('data-state',
                panel.id === ('tab-' + tabId) ? 'active' : 'inactive');
        });
    };

    window.MeditrackTabs = new MeditrackTabsController();

})(window, document);
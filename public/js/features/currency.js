// ============================================
// CURRENCY MODULE
// Thin wrapper — all logic is in settings-manager.js
// ============================================
(function(window) {
    'use strict';

    // MeditrackCurrency is already created by settings-manager.js.
    // This file just makes sure it exists in case load order is off,
    // and adds any additional helpers.

    if (!window.MeditrackCurrency) {
        window.MeditrackCurrency = {
            setCurrency: function(str) {
                if (window.getClinicSetting && window.setClinicSetting) {
                    window.setClinicSetting('currency', str);
                }
                if (window.refreshAllCurrencyDisplays) window.refreshAllCurrencyDisplays();
            },
            getAll: function() { return window.getAllCurrencies ? window.getAllCurrencies() : []; },
            format: function(amount) { return window.formatCurrency ? window.formatCurrency(amount) : String(amount); },
            refresh: function() { if (window.refreshAllCurrencyDisplays) window.refreshAllCurrencyDisplays(); }
        };
    }

})(window);
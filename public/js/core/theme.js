// ============================================
// THEME MODULE - Unified theme management
// Depends on: settings-manager.js (MeditrackSettings)
// ============================================
(function (window, document) {
    'use strict';

    const MODE_KEY    = 'meditrack_theme_mode';
    const LEGACY_KEY  = 'theme';

    function applyThemeMode(mode) {
        let isDark = false;
        if (mode === 'dark')   isDark = true;
        else if (mode === 'system') isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        document.body.classList.toggle('dark', isDark);
        document.documentElement.classList.toggle('dark', isDark);

        const sun  = document.getElementById('sunIcon');
        const moon = document.getElementById('moonIcon');
        if (sun && moon) {
            sun.classList.toggle('hidden', !isDark);
            moon.classList.toggle('hidden', isDark);
        }

        const themeModeSelected = document.getElementById('themeModeSelected');
        if (themeModeSelected) {
            themeModeSelected.textContent =
                mode === 'dark' ? 'Dark' : mode === 'system' ? 'System' : 'Light';
        }

        localStorage.setItem(MODE_KEY,   mode);
        localStorage.setItem(LEGACY_KEY, isDark ? 'dark' : 'light');

        if (window.MeditrackSettings) {
            window.MeditrackSettings.set('theme_mode', mode);
        }

        // Force refresh of settings page elements if needed
if (window.refreshMeditrackSettings) {
    window.refreshMeditrackSettings();
}

        window.dispatchEvent(new CustomEvent('themeChanged', { detail: { mode, isDark } }));
    }

    function loadTheme() {
        const saved = localStorage.getItem(MODE_KEY);
        if (saved && ['light','dark','system'].includes(saved)) { applyThemeMode(saved); return; }
        const leg = localStorage.getItem(LEGACY_KEY);
        applyThemeMode(leg === 'dark' ? 'dark' : leg === 'light' ? 'light' : 'system');
    }

    function initHeaderToggle() {
        const btn = document.getElementById('themeToggleBtn');
        if (!btn) return;
        // Clone to remove stale listeners
        const nb = btn.cloneNode(true);
        btn.parentNode.replaceChild(nb, btn);
        document.getElementById('themeToggleBtn').addEventListener('click', function () {
            const cur = localStorage.getItem(MODE_KEY) || 'system';
            const dark = document.body.classList.contains('dark');
            let next;
            if (cur === 'dark')        next = 'light';
            else if (cur === 'light')  next = 'dark';
            else                       next = dark ? 'light' : 'dark';
            applyThemeMode(next);
        });
    }

    function initSettingsDropdown() {
        const btn = document.getElementById('themeModeBtn');
        const dd  = document.getElementById('themeModeDropdown');
        if (!btn || !dd) return;

        dd.innerHTML = `
            <div class="select-item" data-theme="light">Light</div>
            <div class="select-item" data-theme="dark">Dark</div>
            <div class="select-item" data-theme="system">System</div>`;

        const nb = btn.cloneNode(true);
        btn.parentNode.replaceChild(nb, btn);

        document.getElementById('themeModeBtn').addEventListener('click', function (e) {
            e.stopPropagation();
            document.getElementById('themeModeDropdown').classList.toggle('hidden');
        });

        document.getElementById('themeModeDropdown').querySelectorAll('.select-item').forEach(function (item) {
            item.addEventListener('click', function (e) {
                e.stopPropagation();
                const theme = item.getAttribute('data-theme');
                if (theme) {
                    applyThemeMode(theme);
                    document.getElementById('themeModeDropdown').classList.add('hidden');
                }
            });
        });

        document.addEventListener('click', function (e) {
            const b = document.getElementById('themeModeBtn');
            const d = document.getElementById('themeModeDropdown');
            if (b && d && !b.contains(e.target) && !d.contains(e.target)) d.classList.add('hidden');
        });
    }

    // Cross-tab sync via MeditrackSettings
    if (window.MeditrackSettings) {
        window.MeditrackSettings.onChange(function (detail) {
            if (detail.key === 'theme_mode' && detail.fromOtherTab) applyThemeMode(detail.newValue);
        });
    }

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function () {
        if (localStorage.getItem(MODE_KEY) === 'system') applyThemeMode('system');
    });

    function init() {
        loadTheme();
        initHeaderToggle();
        initSettingsDropdown();
    }

    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
    else init();

    window.MeditrackTheme = {
        apply:   applyThemeMode,
        getMode: function () { return localStorage.getItem(MODE_KEY) || 'system'; },
        isDark:  function () { return document.body.classList.contains('dark'); }
    };

})(window, document);
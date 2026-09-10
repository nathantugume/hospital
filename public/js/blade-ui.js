/* UI-only interactions for the original MediTrack markup. Records and authentication stay in Laravel. */
(() => {
    'use strict';
    const readPreference = key => { try { return localStorage.getItem(key); } catch { return null; } };
    const savePreference = (key, value) => { try { localStorage.setItem(key, value); } catch {} };
    const theme = mode => {
        const dark = mode === 'dark' || (mode === 'system' && matchMedia('(prefers-color-scheme: dark)').matches);
        document.body.classList.toggle('dark', dark);
        document.documentElement.classList.toggle('dark', dark);
        document.getElementById('sunIcon')?.classList.toggle('hidden', !dark);
        document.getElementById('moonIcon')?.classList.toggle('hidden', dark);
        document.dispatchEvent(new CustomEvent('blade:theme', {detail: {dark}}));
    };
    theme(readPreference('meditrack_theme_mode') || 'system');
    matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
        if ((readPreference('meditrack_theme_mode') || 'system') === 'system') theme('system');
    });
    document.getElementById('themeToggleBtn')?.addEventListener('click', () => {
        const mode = document.body.classList.contains('dark') ? 'light' : 'dark';
        savePreference('meditrack_theme_mode', mode); theme(mode);
    });
    const sidebar = document.querySelector('[data-sidebar]');
    const toggle = document.querySelector('[data-menu-toggle]');
    const backdrop = document.querySelector('.blade-backdrop');
    const desktop = matchMedia('(min-width: 1280px)');
    let desktopOpen = readPreference('meditrack_blade_sidebar') !== 'closed';
    const navigation = open => {
        if (!sidebar) return;
        sidebar.classList.toggle('translate-x-0', open);
        document.body.classList.toggle('sidebar-desktop-open', desktop.matches && open);
        document.body.classList.toggle('sidebar-desktop-closed', desktop.matches && !open);
        document.body.classList.toggle('sidebar-open', !desktop.matches && open);
        toggle?.setAttribute('aria-expanded', String(open));
        sidebar.inert = !open;
        if (backdrop) backdrop.hidden = desktop.matches || !open;
        const logo = document.getElementById('headerLogo');
        if (logo) logo.style.display = desktop.matches && open ? 'none' : 'flex';
    };
    navigation(desktop.matches && desktopOpen);
    desktop.addEventListener('change', () => navigation(desktop.matches && desktopOpen));
    toggle?.addEventListener('click', () => {
        const open = !sidebar.classList.contains('translate-x-0');
        if (desktop.matches) { desktopOpen = open; savePreference('meditrack_blade_sidebar', open ? 'open' : 'closed'); }
        navigation(open);
        if (open && !desktop.matches) sidebar.querySelector('[data-menu-close]')?.focus();
    });
    document.querySelectorAll('[data-menu-close]').forEach(button => button.addEventListener('click', () => { navigation(false); toggle?.focus(); }));
    document.querySelectorAll('[data-sidebar] nav button').forEach((button, index) => {
        const panel = button.nextElementSibling;
        if (!panel) return;
        panel.id = `navigation-group-${index}`;
        button.type = 'button'; button.setAttribute('aria-controls', panel.id);
        const open = [...panel.querySelectorAll('a')].some(link => new URL(link.href).pathname === location.pathname);
        panel.classList.toggle('hidden', !open); button.setAttribute('aria-expanded', String(open));
        button.addEventListener('click', () => {
            const expanded = button.getAttribute('aria-expanded') !== 'true';
            panel.classList.toggle('hidden', !expanded); button.setAttribute('aria-expanded', String(expanded));
        });
    });
    document.querySelectorAll('[data-sidebar] nav a').forEach(link => {
        if (new URL(link.href).pathname === location.pathname) { link.setAttribute('aria-current', 'page'); link.classList.add('bg-gray-100'); }
    });
    document.addEventListener('click', event => document.querySelectorAll('details[open]').forEach(menu => { if (!menu.contains(event.target)) menu.open = false; }));
    document.querySelectorAll('.row-actions').forEach(details => details.addEventListener('toggle', () => {
        if (!details.open) return;
        const menu = details.querySelector('.row-actions-menu');
        const anchor = details.querySelector('summary').getBoundingClientRect();
        const width = menu.offsetWidth;
        const height = menu.offsetHeight;
        // Escape the table's horizontal scroll container without clipping actions.
        Object.assign(menu.style, {
            position: 'fixed', right: 'auto', bottom: 'auto',
            left: `${Math.max(8, Math.min(innerWidth - width - 8, anchor.right - width))}px`,
            top: `${anchor.bottom + height + 8 <= innerHeight ? anchor.bottom + 4 : Math.max(8, anchor.top - height - 4)}px`,
        });
    }));
    document.addEventListener('scroll', () => document.querySelectorAll('.row-actions[open]').forEach(menu => { menu.open = false; }), true);
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape') {
            document.querySelectorAll('details[open]').forEach(menu => { menu.open = false; menu.querySelector('summary')?.focus(); });
            if (!desktop.matches && sidebar?.classList.contains('translate-x-0')) { navigation(false); toggle?.focus(); }
        }
        if (event.key === 'Tab' && !desktop.matches && sidebar?.classList.contains('translate-x-0')) {
            const focusable = [...sidebar.querySelectorAll('a, button')].filter(el => el.getClientRects().length);
            const first = focusable[0], last = focusable.at(-1);
            if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last?.focus(); }
            if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first?.focus(); }
        }
    });
    document.getElementById('togglePassword')?.addEventListener('click', event => {
        const field = document.getElementById('password');
        field.type = field.type === 'password' ? 'text' : 'password';
        event.currentTarget.setAttribute('aria-label', field.type === 'password' ? 'Show password' : 'Hide password');
    });
    const dashboardTabs = [...document.querySelectorAll('[data-dashboard-tab]')];
    const activateTab = button => {
        dashboardTabs.forEach(tab => {
            const active = tab === button;
            tab.dataset.state = active ? 'active' : 'inactive';
            tab.setAttribute('aria-selected', String(active));
            tab.tabIndex = active ? 0 : -1;
            document.getElementById(`tab-${tab.dataset.dashboardTab}`)?.classList.toggle('hidden', !active);
        });
        window.dispatchEvent(new Event('resize'));
    };
    dashboardTabs.forEach((button, index) => {
        button.tabIndex = index === 0 ? 0 : -1;
        button.addEventListener('click', () => activateTab(button));
        button.addEventListener('keydown', event => {
            const next = {ArrowRight: (index + 1) % dashboardTabs.length, ArrowLeft: (index - 1 + dashboardTabs.length) % dashboardTabs.length, Home: 0, End: dashboardTabs.length - 1}[event.key];
            if (next === undefined) return;
            event.preventDefault(); activateTab(dashboardTabs[next]); dashboardTabs[next].focus();
        });
    });
    document.querySelectorAll('[data-export-table]').forEach(button => button.addEventListener('click', () => {
        const table = document.getElementById(button.dataset.exportTable);
        if (!table) return;
        const rows = [...table.rows].map(row => [...row.cells].slice(0, -1).map(cell => {
            let value = cell.textContent.trim().replace(/\s+/g, ' ');
            if (/^[=+@-]/.test(value)) value = "'" + value;
            return '"' + value.replaceAll('"', '""') + '"';
        }).join(','));
        const url = URL.createObjectURL(new Blob([rows.join('\r\n')], {type: 'text/csv;charset=utf-8;'}));
        const link = document.createElement('a'); link.href = url; link.download = 'meditrack-visible-records.csv'; link.click(); URL.revokeObjectURL(url);
    }));
    document.querySelector('[data-export-dashboard]')?.addEventListener('click', () => {
        const rows = [['Metric', 'Value'], ...[...document.querySelectorAll('[data-metric]')].map(el => [el.dataset.metric, el.dataset.value])];
        const csv = rows.map(row => row.map(value => '"' + String(value).replaceAll('"', '""') + '"').join(',')).join('\r\n');
        const url = URL.createObjectURL(new Blob([csv], {type: 'text/csv;charset=utf-8;'}));
        const link = document.createElement('a'); link.href = url; link.download = 'meditrack-dashboard.csv'; link.click(); URL.revokeObjectURL(url);
    });
})();

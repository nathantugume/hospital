/**
 * Meditrack HMS — Pagination Helper
 * ============================================================
 * Wraps any HTML <table> with client-side pagination:
 *   - Prev / Next buttons
 *   - Page number buttons (with ellipsis for large page counts)
 *   - "Showing X to Y of Z" counter
 *   - Per-page selector (10 / 15 / 25 / 50 / 100)
 *
 * Usage:
 *   MeditrackUI.paginate(table, { perPage: 15 });    // initialize
 *   MeditrackUI.paginateAll();                        // auto-paginate all tables
 *   <table data-paginate="15">...</table>             // declarative
 *
 * Auto-wires:
 *   - Sortable column headers (click to sort asc/desc)
 *   - "Showing X to Y of Z entries" counter
 *   - Smooth page transitions
 *
 * Works alongside search filtering — pagination re-calculates
 * when rows are hidden by search.
 */

(function(window, document) {
    'use strict';

    const DEFAULTS = {
        perPage: 15,
        perPageOptions: [10, 15, 25, 50, 100],
        maxPageButtons: 7,
        containerClass: 'meditrack-pagination',
        styleId: 'meditrack-pagination-styles',
    };

    const paginatedTables = new WeakMap();

    // ============================================================
    // INJECT CSS (once)
    // ============================================================
    function injectStyles() {
        if (document.getElementById(DEFAULTS.styleId)) return;
        const style = document.createElement('style');
        style.id = DEFAULTS.styleId;
        style.textContent = `
            .${DEFAULTS.containerClass} {
                display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between;
                gap: 12px; padding: 12px 16px;
                font-family: 'Inter', -apple-system, sans-serif; font-size: 13px;
                border-top: 1px solid #e5e7eb; margin-top: 0;
                background: #fafafa;
            }
            .${DEFAULTS.containerClass} .pg-info { color: #6b7280; }
            .${DEFAULTS.containerClass} .pg-info b { color: #1f2937; font-weight: 600; }
            .${DEFAULTS.containerClass} .pg-controls { display: flex; align-items: center; gap: 4px; }
            .${DEFAULTS.containerClass} .pg-btn {
                min-width: 32px; height: 32px; padding: 0 8px;
                border: 1px solid #d1d5db; background: white; color: #374151;
                border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: 500;
                display: inline-flex; align-items: center; justify-content: center;
                transition: all 0.15s;
            }
            .${DEFAULTS.containerClass} .pg-btn:hover:not(:disabled) {
                background: #4f46e5; color: white; border-color: #4f46e5;
            }
            .${DEFAULTS.containerClass} .pg-btn.active {
                background: #4f46e5; color: white; border-color: #4f46e5; font-weight: 600;
            }
            .${DEFAULTS.containerClass} .pg-btn:disabled {
                opacity: 0.4; cursor: not-allowed;
            }
            .${DEFAULTS.containerClass} .pg-ellipsis {
                padding: 0 6px; color: #9ca3af; user-select: none;
            }
            .${DEFAULTS.containerClass} .pg-per-page {
                display: flex; align-items: center; gap: 8px;
            }
            .${DEFAULTS.containerClass} .pg-per-page select {
                height: 32px; padding: 0 8px; border: 1px solid #d1d5db; border-radius: 4px;
                background: white; font-size: 12px; font-family: 'Inter', sans-serif;
                cursor: pointer;
            }
            /* Dark mode support */
            body.dark .${DEFAULTS.containerClass} { background: #1a1a1a; border-color: #333; }
            body.dark .${DEFAULTS.containerClass} .pg-info { color: #9ca3af; }
            body.dark .${DEFAULTS.containerClass} .pg-info b { color: #e5e5e5; }
            body.dark .${DEFAULTS.containerClass} .pg-btn { background: #262626; color: #e5e5e5; border-color: #404040; }
            body.dark .${DEFAULTS.containerClass} .pg-per-page select { background: #262626; color: #e5e5e5; border-color: #404040; }

            /* Sortable column headers */
            th[data-sortable="true"] { cursor: pointer; user-select: none; position: relative; padding-right: 22px !important; }
            th[data-sortable="true"]::after {
                content: '⇅'; position: absolute; right: 6px; top: 50%; transform: translateY(-50%);
                font-size: 12px; color: #9ca3af; opacity: 0.6;
            }
            th[data-sort-direction="asc"]::after { content: '↑'; color: #4f46e5; opacity: 1; }
            th[data-sort-direction="desc"]::after { content: '↓'; color: #4f46e5; opacity: 1; }

            @media (max-width: 640px) {
                .${DEFAULTS.containerClass} { flex-direction: column; align-items: stretch; }
                .${DEFAULTS.containerClass} .pg-controls { justify-content: center; flex-wrap: wrap; }
            }
        `;
        document.head.appendChild(style);
    }

    // ============================================================
    // PAGINATE A SINGLE TABLE
    // ============================================================
    function paginate(table, options = {}) {
        if (paginatedTables.has(table)) {
            // Update options and re-render
            const state = paginatedTables.get(table);
            state.options = { ...state.options, ...options };
            renderPagination(table);
            return state;
        }

        const opts = { ...DEFAULTS, ...options };
        const state = {
            options: opts,
            currentPage: 1,
            perPage: opts.perPage,
            sortBy: null,
            sortDir: 'asc',
            filteredRows: [],
        };
        paginatedTables.set(table, state);

        // Wrap table in a container if not already wrapped
        const wrapper = table.parentElement;
        if (!wrapper.classList.contains('meditrack-table-wrapper')) {
            const newWrapper = document.createElement('div');
            newWrapper.className = 'meditrack-table-wrapper';
            newWrapper.style.cssText = 'overflow-x: auto;';
            table.parentNode.insertBefore(newWrapper, table);
            newWrapper.appendChild(table);
        }

        // Create pagination footer
        const footer = document.createElement('div');
        footer.className = DEFAULTS.containerClass;
        if (table.parentNode.nextSibling !== footer) {
            table.parentNode.after(footer);
        }
        state.footer = footer;

        // Make column headers sortable
        const headers = table.querySelectorAll('thead th');
        headers.forEach((th, idx) => {
            if (opts.sortable !== false) {
                th.setAttribute('data-sortable', 'true');
                th.setAttribute('data-column-idx', String(idx));
                th.addEventListener('click', () => {
                    if (state.sortBy === idx) {
                        state.sortDir = state.sortDir === 'asc' ? 'desc' : 'asc';
                    } else {
                        state.sortBy = idx;
                        state.sortDir = 'asc';
                    }
                    // Update visual indicators
                    headers.forEach(h => { h.removeAttribute('data-sort-direction'); });
                    th.setAttribute('data-sort-direction', state.sortDir);
                    state.currentPage = 1;
                    renderPagination(table);
                });
            }
        });

        // Initial render
        renderPagination(table);
        return state;
    }

    // ============================================================
    // RENDER PAGINATION
    // ============================================================
    function renderPagination(table) {
        const state = paginatedTables.get(table);
        if (!state) return;

        const tbody = table.querySelector('tbody');
        if (!tbody) return;

        // Get all rows (visible + hidden, since search may hide some)
        const allRows = Array.from(tbody.querySelectorAll('tr'));
        // Filter to visible (search may set display:none)
        const visibleRows = allRows.filter(r => r.style.display !== 'none' && !r.classList.contains('no-results'));

        // Sort if sortBy is set
        if (state.sortBy !== null) {
            visibleRows.sort((a, b) => {
                const aCell = a.querySelectorAll('td, th')[state.sortBy];
                const bCell = b.querySelectorAll('td, th')[state.sortBy];
                let aVal = aCell?.textContent?.trim() || '';
                let bVal = bCell?.textContent?.trim() || '';
                // Try numeric sort
                const aNum = parseFloat(aVal.replace(/[^0-9.-]/g, ''));
                const bNum = parseFloat(bVal.replace(/[^0-9.-]/g, ''));
                if (!isNaN(aNum) && !isNaN(bNum)) {
                    return state.sortDir === 'asc' ? aNum - bNum : bNum - aNum;
                }
                // Try date sort
                const aDate = new Date(aVal);
                const bDate = new Date(bVal);
                if (!isNaN(aDate) && !isNaN(bDate)) {
                    return state.sortDir === 'asc' ? aDate - bDate : bDate - aDate;
                }
                // String sort
                return state.sortDir === 'asc' ? aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
            });
        }

        // Calculate pagination
        const totalRows = visibleRows.length;
        const perPage = state.perPage;
        const totalPages = Math.max(1, Math.ceil(totalRows / perPage));
        if (state.currentPage > totalPages) state.currentPage = totalPages;
        if (state.currentPage < 1) state.currentPage = 1;

        const startIdx = (state.currentPage - 1) * perPage;
        const endIdx = Math.min(startIdx + perPage, totalRows);

        // Hide all rows, then show only the current page's slice
        allRows.forEach(r => { r.style.display = 'none'; });
        // If sorting, reorder the DOM
        if (state.sortBy !== null) {
            visibleRows.forEach(row => tbody.appendChild(row));
        }
        // Show only current page rows
        for (let i = startIdx; i < endIdx; i++) {
            if (visibleRows[i]) visibleRows[i].style.display = '';
        }

        // Build pagination footer
        const footer = state.footer;
        if (!footer) return;

        // Info text
        const info = document.createElement('div');
        info.className = 'pg-info';
        if (totalRows === 0) {
            info.innerHTML = 'No records to display';
        } else {
            info.innerHTML = `Showing <b>${startIdx + 1}</b> to <b>${endIdx}</b> of <b>${totalRows}</b> entries`;
        }

        // Controls (prev/next + page numbers)
        const controls = document.createElement('div');
        controls.className = 'pg-controls';

        // Prev button
        const prevBtn = document.createElement('button');
        prevBtn.className = 'pg-btn';
        prevBtn.textContent = '‹ Prev';
        prevBtn.disabled = state.currentPage <= 1;
        prevBtn.addEventListener('click', () => {
            if (state.currentPage > 1) { state.currentPage--; renderPagination(table); }
        });
        controls.appendChild(prevBtn);

        // Page number buttons
        const pageButtons = buildPageButtonList(state.currentPage, totalPages, state.options.maxPageButtons);
        pageButtons.forEach(p => {
            if (p === '...') {
                const ellipsis = document.createElement('span');
                ellipsis.className = 'pg-ellipsis';
                ellipsis.textContent = '…';
                controls.appendChild(ellipsis);
            } else {
                const btn = document.createElement('button');
                btn.className = 'pg-btn' + (p === state.currentPage ? ' active' : '');
                btn.textContent = String(p);
                btn.addEventListener('click', () => {
                    state.currentPage = p;
                    renderPagination(table);
                });
                controls.appendChild(btn);
            }
        });

        // Next button
        const nextBtn = document.createElement('button');
        nextBtn.className = 'pg-btn';
        nextBtn.textContent = 'Next ›';
        nextBtn.disabled = state.currentPage >= totalPages;
        nextBtn.addEventListener('click', () => {
            if (state.currentPage < totalPages) { state.currentPage++; renderPagination(table); }
        });
        controls.appendChild(nextBtn);

        // Per-page selector
        const perPageWrap = document.createElement('div');
        perPageWrap.className = 'pg-per-page';
        const perPageLabel = document.createElement('span');
        perPageLabel.style.color = '#6b7280';
        perPageLabel.textContent = 'Rows:';
        const perPageSelect = document.createElement('select');
        state.options.perPageOptions.forEach(n => {
            const opt = document.createElement('option');
            opt.value = String(n);
            opt.textContent = String(n);
            if (n === state.perPage) opt.selected = true;
            perPageSelect.appendChild(opt);
        });
        perPageSelect.addEventListener('change', () => {
            state.perPage = parseInt(perPageSelect.value, 10);
            state.currentPage = 1;
            renderPagination(table);
        });
        perPageWrap.appendChild(perPageLabel);
        perPageWrap.appendChild(perPageSelect);

        // Clear footer + rebuild
        footer.innerHTML = '';
        footer.appendChild(info);
        footer.appendChild(controls);
        footer.appendChild(perPageWrap);
    }

    // ============================================================
    // BUILD PAGE BUTTON LIST (with ellipsis)
    // ============================================================
    function buildPageButtonList(current, total, maxButtons) {
        if (total <= maxButtons) {
            return Array.from({ length: total }, (_, i) => i + 1);
        }
        const buttons = [];
        const half = Math.floor(maxButtons / 2);
        let start = Math.max(1, current - half);
        let end = Math.min(total, start + maxButtons - 1);
        if (end - start + 1 < maxButtons) {
            start = Math.max(1, end - maxButtons + 1);
        }
        if (start > 1) {
            buttons.push(1);
            if (start > 2) buttons.push('...');
        }
        for (let i = start; i <= end; i++) {
            buttons.push(i);
        }
        if (end < total) {
            if (end < total - 1) buttons.push('...');
            buttons.push(total);
        }
        return buttons;
    }

    // ============================================================
    // PAGINATE ALL TABLES ON THE PAGE
    // ============================================================
    function paginateAll(options = {}) {
        // Find all data tables (skip small ones used for layout)
        const tables = document.querySelectorAll('table');
        let count = 0;
        tables.forEach(table => {
            // Skip if already paginated
            if (paginatedTables.has(table)) return;
            // Skip if table has fewer than 10 rows
            const rowCount = table.querySelectorAll('tbody tr').length;
            if (rowCount < 5) return;
            // Skip if inside a modal
            if (table.closest('.modal, .modal-overlay, [role="dialog"]')) return;
            // Skip if has data-no-paginate
            if (table.hasAttribute('data-no-paginate')) return;
            // Skip layout tables (no thead)
            if (!table.querySelector('thead')) return;

            const perPage = parseInt(table.getAttribute('data-paginate') || options.perPage || DEFAULTS.perPage, 10);
            paginate(table, { perPage, ...options });
            count++;
        });
        return count;
    }

    // ============================================================
    // REFRESH PAGINATION (call after data changes)
    // ============================================================
    function refresh(table) {
        if (table && paginatedTables.has(table)) {
            renderPagination(table);
        } else {
            // Refresh all
            paginatedTables.forEach((_, t) => renderPagination(t));
        }
    }

    // ============================================================
    // EXPOSE + INIT
    // ============================================================
    window.MeditrackUI = window.MeditrackUI || {};
    window.MeditrackUI.paginate = paginate;
    window.MeditrackUI.paginateAll = paginateAll;
    window.MeditrackUI.refreshPagination = refresh;

    // Also expose on Meditrack namespace
    if (window.Meditrack) {
        window.Meditrack.paginate = paginate;
        window.Meditrack.paginateAll = paginateAll;
        window.Meditrack.refreshPagination = refresh;
    }

    function init() {
        injectStyles();
        // Defer to allow table content to render first
        setTimeout(() => {
            const count = paginateAll();
            if (count > 0) console.log(`[Pagination] Wired ${count} table(s)`);
        }, 800);

        // Re-run after store changes (data may have been added/removed)
        if (window.MeditrackStore) {
            window.MeditrackStore.onChange(() => {
                setTimeout(() => refresh(), 200);
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    // Re-run after delays for dynamically rendered pages
    setTimeout(init, 2000);
    setTimeout(init, 4000);

})(window, document);

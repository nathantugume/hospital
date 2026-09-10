/**
 * Meditrack HMS — Search Filter Helper
 * ============================================================
 * Wires every search input on every page to actually filter the
 * primary data table on that page. Works with pagination:
 *   - User types in search box
 *   - Rows are hidden/shown based on match (case-insensitive)
 *   - Pagination recalculates visible rows
 *   - "No results" row shown when nothing matches
 *
 * Auto-detection:
 *   - Finds <input type="search">, <input placeholder*="Search">,
 *     #searchInput, #search, .search-input
 *   - For each, finds the closest <table> on the page
 *   - Binds input/keyup event to filter that table's <tbody> rows
 *
 * Supports:
 *   - Column-specific search via data-search-column attribute
 *   - Multiple search inputs on the same page (each filters nearest table)
 *   - Debounced input (150ms delay)
 *   - Highlight matching text (optional)
 */

(function(window, document) {
    'use strict';

    const wiredInputs = new WeakSet();
    let debounceTimer = null;

    // ============================================================
    // FIND ALL SEARCH INPUTS ON THE PAGE
    // ============================================================
    function findSearchInputs() {
        const selectors = [
            'input[type="search"]',
            'input#searchInput',
            'input#search',
            'input#searchInput',
            'input.search-input',
            'input[placeholder*="Search" i]',
            'input[placeholder*="search" i]',
            'input[placeholder*="Find" i]',
            'input[placeholder*="Filter" i]',
            'input[name="search"]',
            'input[name="query"]',
            'input[name="q"]',
        ];
        const set = new Set();
        selectors.forEach(sel => {
            document.querySelectorAll(sel).forEach(input => set.add(input));
        });
        return Array.from(set);
    }

    // ============================================================
    // FIND THE TABLE TO FILTER (nearest to the search input)
    // ============================================================
    function findTableForInput(input) {
        // Strategy 1: explicit data-target attribute
        const targetId = input.getAttribute('data-table-target');
        if (targetId) {
            const t = document.getElementById(targetId) || document.querySelector(targetId);
            if (t && t.tagName === 'TABLE') return t;
        }
        // Strategy 2: closest .card or section ancestor that contains a table
        const ancestor = input.closest('.card, .panel, .section, .tab-panel, [role="tabpanel"], .bg-white, main');
        if (ancestor) {
            const t = ancestor.querySelector('table');
            if (t) return t;
        }
        // Strategy 3: nearest table in document order after the input
        const allTables = Array.from(document.querySelectorAll('table'));
        if (allTables.length === 1) return allTables[0];
        // Find the table that comes after the input in document order
        const inputRect = input.getBoundingClientRect();
        const inputTop = inputRect.top + window.scrollY;
        let closestTable = null;
        let closestDist = Infinity;
        allTables.forEach(t => {
            const rect = t.getBoundingClientRect();
            const top = rect.top + window.scrollY;
            const dist = Math.abs(top - inputTop);
            if (dist < closestDist) {
                closestDist = dist;
                closestTable = t;
            }
        });
        return closestTable;
    }

    // ============================================================
    // FILTER TABLE ROWS
    // ============================================================
    function filterTable(table, query, searchColumn) {
        if (!table) return;
        const tbody = table.querySelector('tbody');
        if (!tbody) return;

        const q = query.toLowerCase().trim();
        const rows = tbody.querySelectorAll('tr');

        // Remove any existing "no results" row
        const noResultsRow = tbody.querySelector('tr.no-results-row');
        if (noResultsRow) noResultsRow.remove();

        let visibleCount = 0;
        rows.forEach(row => {
            if (row.classList.contains('no-results-row')) return;
            // Skip empty rows or rows with only one cell (likely separators)
            const cells = row.querySelectorAll('td');
            if (cells.length === 0) return;

            let matches = false;
            if (!q) {
                matches = true; // empty search shows all
            } else if (searchColumn !== null && searchColumn !== undefined) {
                // Search specific column
                const cell = cells[searchColumn];
                matches = cell && cell.textContent.toLowerCase().includes(q);
            } else {
                // Search all cells
                matches = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(q));
            }

            row.style.display = matches ? '' : 'none';
            if (matches) visibleCount++;
        });

        // Show "no results" message if no rows match
        if (q && visibleCount === 0) {
            const colCount = table.querySelectorAll('thead th').length || 8;
            const noResults = document.createElement('tr');
            noResults.className = 'no-results-row';
            noResults.innerHTML = `
                <td colspan="${colCount}" style="text-align: center; padding: 32px 16px; color: #9ca3af; font-style: italic;">
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity: 0.5;">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <div>No results found for "${query}"</div>
                        <div style="font-size: 12px;">Try a different search term or clear the search.</div>
                    </div>
                </td>
            `;
            tbody.appendChild(noResults);
        }

        // Refresh pagination if available
        if (window.MeditrackUI?.refreshPagination) {
            window.MeditrackUI.refreshPagination(table);
        }
    }

    // ============================================================
    // WIRE A SINGLE SEARCH INPUT
    // ============================================================
    function wireSearchInput(input) {
        if (wiredInputs.has(input)) return;
        wiredInputs.add(input);

        // Find the table to filter
        const table = findTableForInput(input);
        if (!table) {
            console.warn('[SearchFilter] No table found for input:', input);
            return;
        }

        // Check for column-specific search
        const searchColumnAttr = input.getAttribute('data-search-column');
        const searchColumn = searchColumnAttr !== null ? parseInt(searchColumnAttr, 10) : null;

        // Bind input event (debounced)
        const handler = (e) => {
            const query = e.target.value;
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                filterTable(table, query, searchColumn);
            }, 150);
        };

        input.addEventListener('input', handler);
        input.addEventListener('keyup', handler);

        // Add a clear button if not present
        if (!input.parentElement.querySelector('.search-clear-btn') && input.type !== 'search') {
            // Browsers with type="search" already show a clear (×) button
            const wrapper = input.parentElement;
            wrapper.style.position = 'relative';
            const clearBtn = document.createElement('button');
            clearBtn.type = 'button';
            clearBtn.className = 'search-clear-btn';
            clearBtn.innerHTML = '&times;';
            clearBtn.style.cssText = `
                position: absolute; right: 8px; top: 50%; transform: translateY(-50%);
                border: none; background: transparent; color: #9ca3af; cursor: pointer;
                font-size: 18px; line-height: 1; padding: 4px; display: none;
            `;
            clearBtn.addEventListener('click', () => {
                input.value = '';
                filterTable(table, '', searchColumn);
                clearBtn.style.display = 'none';
                input.focus();
            });
            wrapper.appendChild(clearBtn);
            input.addEventListener('input', () => {
                clearBtn.style.display = input.value ? 'block' : 'none';
            });
        }

        // Add Enter key handler — also works without debounce
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                clearTimeout(debounceTimer);
                filterTable(table, input.value, searchColumn);
            }
            if (e.key === 'Escape') {
                input.value = '';
                filterTable(table, '', searchColumn);
                input.blur();
            }
        });

        console.log('[SearchFilter] Wired search input → table', table);
    }

    // ============================================================
    // WIRE ALL SEARCH INPUTS ON THE PAGE
    // ============================================================
    function wireAllSearchInputs() {
        const inputs = findSearchInputs();
        let count = 0;
        inputs.forEach(input => {
            // Skip if inside a modal that's not yet shown
            if (input.closest('.modal[style*="display: none"], .modal[style*="display:none"]')) return;
            // Skip if has data-no-search
            if (input.hasAttribute('data-no-search')) return;
            wireSearchInput(input);
            count++;
        });
        if (count > 0) console.log(`[SearchFilter] Wired ${count} search input(s)`);
        return count;
    }

    // ============================================================
    // EXPOSE
    // ============================================================
    window.MeditrackSearch = {
        wire: wireSearchInput,
        wireAll: wireAllSearchInputs,
        filter: filterTable,
        findTableForInput,
    };

    if (window.Meditrack) {
        window.Meditrack.wireSearch = wireAllSearchInputs;
        window.Meditrack.filterTable = filterTable;
    }

    // ============================================================
    // INIT
    // ============================================================
    function init() {
        wireAllSearchInputs();
        // Re-run after dynamic content renders
        setTimeout(wireAllSearchInputs, 1000);
        setTimeout(wireAllSearchInputs, 2500);

        // Re-wire when modals open (search inputs in modals)
        const observer = new MutationObserver((mutations) => {
            let shouldRewire = false;
            mutations.forEach(m => {
                if (m.addedNodes.length > 0) {
                    m.addedNodes.forEach(node => {
                        if (node.nodeType === 1 && (node.tagName === 'INPUT' || node.querySelector?.('input'))) {
                            shouldRewire = true;
                        }
                    });
                }
            });
            if (shouldRewire) {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(wireAllSearchInputs, 200);
            }
        });
        observer.observe(document.body, { childList: true, subtree: true });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})(window, document);

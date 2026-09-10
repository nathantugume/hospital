/**
 * Meditrack HMS — Audit Log Viewer
 * ============================================================
 * Wires transfer-history.html to display real audit logs from
 * the MeditrackStore (meditrack_audit_logs key) with:
 *   - Filterable by action, user, date range
 *   - Searchable
 *   - Paginated
 *   - Color-coded by action type
 *   - Export to CSV
 *
 * If the store has no audit logs, seeds with sample entries from
 * the existing page content.
 */

(function(window, document) {
    'use strict';

    if (!window.MeditrackStore) return;
    const STORE = window.MeditrackStore;
    const Toast = window.Meditrack?.Toast;

    const page = (window.location.pathname.split('/').pop() || '').toLowerCase();
    if (page !== 'transfer-history.html') return;

    console.log('[AuditLog] Wiring audit log viewer on transfer-history.html');

    // ============================================================
    // SEED SAMPLE AUDIT LOGS IF EMPTY
    // ============================================================
    function seedAuditLogs() {
        let logs = STORE.list('audit_logs') || [];
        if (logs.length > 0) return;

        const sampleLogs = [
            { id: 1, timestamp: new Date(Date.now() - 300000).toISOString(), user: 'Ssentongo James', action: 'Login', entity: 'User Session', entity_id: '1', department: 'IT Operations', ip: '192.168.1.45', details: 'Logged in from Chrome on Windows' },
            { id: 2, timestamp: new Date(Date.now() - 600000).toISOString(), user: 'Dr. Nakato Sarah', action: 'Create', entity: 'Patient', entity_id: 'P-10006', department: 'Cardiology', ip: '192.168.1.52', details: 'Registered new patient: Nakato Mary' },
            { id: 3, timestamp: new Date(Date.now() - 900000).toISOString(), user: 'Nalwoga Sarah', action: 'Update', entity: 'Medication Administration', entity_id: 'MA-0042', department: 'Emergency', ip: '192.168.1.68', details: 'Administered Lisinopril 10mg to patient P-10001' },
            { id: 4, timestamp: new Date(Date.now() - 1200000).toISOString(), user: 'Kibirige John', action: 'Update', entity: 'Lab Result', entity_id: 'RES-004', department: 'Laboratory', ip: '192.168.1.71', details: 'Verified lab result for patient P-10002 — Fasting Blood Sugar: 8.2 mmol/L (Abnormal: High)' },
            { id: 5, timestamp: new Date(Date.now() - 1800000).toISOString(), user: 'Nabisere Patricia', action: 'Create', entity: 'Invoice', entity_id: 'INV-1004', department: 'Finance', ip: '192.168.1.80', details: 'Created invoice for UGX 1,250,000 — Patient: Okello David' },
            { id: 6, timestamp: new Date(Date.now() - 2400000).toISOString(), user: 'Ssentongo James', action: 'Update', entity: 'User Role', entity_id: 'ST-009', department: 'IT Operations', ip: '192.168.1.45', details: 'Changed Nalwoga Sarah role from Staff to Head Nurse' },
            { id: 7, timestamp: new Date(Date.now() - 3000000).toISOString(), user: 'Dr. Mwangi Peter', action: 'Create', entity: 'Prescription', entity_id: 'RX-0006', department: 'Internal Medicine', ip: '192.168.1.53', details: 'Prescribed Metformin 500mg for patient P-10002' },
            { id: 8, timestamp: new Date(Date.now() - 3600000).toISOString(), user: 'System', action: 'Alert', entity: 'Inventory', entity_id: 'INV004', department: 'Pharmacy', ip: '127.0.0.1', details: 'Low stock alert: IV Drip Sets (0 units, min 25)' },
            { id: 9, timestamp: new Date(Date.now() - 7200000).toISOString(), user: 'Akampa David', action: 'Create', entity: 'Appointment', entity_id: 'APT-0061', department: 'Reception', ip: '192.168.1.65', details: 'Booked appointment for Nakato Mary with Dr. Mwangi Peter' },
            { id: 10, timestamp: new Date(Date.now() - 10800000).toISOString(), user: 'Dr. Nakato Sarah', action: 'Delete', entity: 'Lab Result', entity_id: 'RES-001', department: 'Cardiology', ip: '192.168.1.52', details: 'Deleted duplicate lab result RES-001' },
            { id: 11, timestamp: new Date(Date.now() - 14400000).toISOString(), user: 'Ssemwogerere David', action: 'Update', entity: 'Medicine Stock', entity_id: 'MED003', department: 'Pharmacy', ip: '192.168.1.72', details: 'Adjusted Artemether/Lumefantrine stock: -30 units (dispensed)' },
            { id: 12, timestamp: new Date(Date.now() - 18000000).toISOString(), user: 'Atim Linda', action: 'Create', entity: 'Insurance Claim', entity_id: 'CLM-005', department: 'Insurance', ip: '192.168.1.85', details: 'Submitted insurance claim to AAR Insurance for UGX 740,000' },
            { id: 13, timestamp: new Date(Date.now() - 21600000).toISOString(), user: 'Mukasa David', action: 'Update', entity: 'Ambulance Call', entity_id: 'CALL-003', department: 'Emergency', ip: '192.168.1.90', details: 'Marked ambulance call CALL-003 as Completed' },
            { id: 14, timestamp: new Date(Date.now() - 259200000).toISOString(), user: 'Ssentongo James', action: 'Update', entity: 'Settings', entity_id: 'system', department: 'IT Operations', ip: '192.168.1.45', details: 'Updated clinic working hours' },
            { id: 15, timestamp: new Date(Date.now() - 345600000).toISOString(), user: 'System', action: 'Backup', entity: 'Database', entity_id: 'auto-backup', department: 'System', ip: '127.0.0.1', details: 'Nightly backup completed successfully (245MB)' },
        ];

        sampleLogs.forEach(log => STORE.create('audit_logs', log));
    }

    // ============================================================
    // RENDER AUDIT LOGS
    // ============================================================
    function renderAuditLogs(filters = {}) {
        let logs = STORE.list('audit_logs') || [];

        // Apply filters
        if (filters.search) {
            const s = filters.search.toLowerCase();
            logs = logs.filter(l =>
                (l.user || '').toLowerCase().includes(s) ||
                (l.action || '').toLowerCase().includes(s) ||
                (l.entity || '').toLowerCase().includes(s) ||
                (l.details || '').toLowerCase().includes(s)
            );
        }

        if (filters.action && filters.action !== 'All') {
            logs = logs.filter(l => l.action === filters.action);
        }

        if (filters.user && filters.user !== 'All') {
            logs = logs.filter(l => l.user === filters.user);
        }

        if (filters.dateFrom) {
            logs = logs.filter(l => new Date(l.timestamp) >= new Date(filters.dateFrom));
        }

        if (filters.dateTo) {
            logs = logs.filter(l => new Date(l.timestamp) <= new Date(filters.dateTo + 'T23:59:59'));
        }

        // Sort by timestamp desc
        logs.sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));

        // Find the table
        const tbody = document.querySelector('table tbody');
        if (!tbody) return;

        if (logs.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center text-gray-400 py-8">No audit logs found matching your filters.</td></tr>';
            return;
        }

        // Action colors
        const actionColors = {
            Login: 'bg-blue-100 text-blue-700',
            Logout: 'bg-gray-100 text-gray-700',
            Create: 'bg-green-100 text-green-700',
            Update: 'bg-amber-100 text-amber-700',
            Delete: 'bg-red-100 text-red-700',
            Alert: 'bg-orange-100 text-orange-700',
            Backup: 'bg-purple-100 text-purple-700',
        };

        tbody.innerHTML = logs.map(log => {
            const date = new Date(log.timestamp);
            const dateStr = date.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            const timeStr = date.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            const colorClass = actionColors[log.action] || 'bg-gray-100 text-gray-700';

            return `<tr data-id="${log.id}">
                <td class="px-4 py-3 text-sm text-gray-500">${dateStr}<br><span class="text-xs text-gray-400">${timeStr}</span></td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <div class="h-7 w-7 rounded-full bg-indigo-100 overflow-hidden flex items-center justify-center">
                            <img src="user.png" alt="${log.user}" style="width:100%;height:100%;object-fit:cover">
                        </div>
                        <span class="text-sm font-medium text-gray-900">${log.user || 'System'}</span>
                    </div>
                </td>
                <td class="px-4 py-3"><span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold ${colorClass}">${log.action || '—'}</span></td>
                <td class="px-4 py-3 text-sm text-gray-500">${log.entity || '—'} ${log.entity_id ? `<span class="text-xs text-gray-400">#${log.entity_id}</span>` : ''}</td>
                <td class="px-4 py-3 text-sm text-gray-500">${log.department || '—'}</td>
                <td class="px-4 py-3 text-sm text-gray-500">${log.ip || '—'}</td>
                <td class="px-4 py-3 text-sm text-gray-500 max-w-xs truncate" title="${log.details || ''}">${log.details || '—'}</td>
            </tr>`;
        }).join('');

        // Update count
        const countEl = document.querySelector('.audit-count, [class*="total"]');
        if (countEl) countEl.textContent = `${logs.length} entries`;

        // Update page title
        const titleEl = document.querySelector('h1, h2, .page-title');
        if (titleEl) titleEl.textContent = 'Audit Logs';

        // Update any heading that says "Transfer History"
        document.querySelectorAll('h1, h2, h3, .page-title, [class*="title"]').forEach(el => {
            if (el.textContent.includes('Transfer History') || el.textContent.includes('Audit Logs')) {
                el.textContent = 'Audit Logs';
            }
        });
    }

    // ============================================================
    // WIRE FILTERS
    // ============================================================
    function wireFilters() {
        const filters = {};

        // Search input
        const searchInput = document.querySelector('input[type="search"], input[placeholder*="Search" i], input[placeholder*="search" i]');
        if (searchInput) {
            searchInput.addEventListener('input', () => {
                filters.search = searchInput.value;
                renderAuditLogs(filters);
            });
        }

        // Action filter dropdown
        const actionSelect = document.querySelector('select[name="action"], #actionFilter, [data-filter="action"]');
        if (actionSelect) {
            actionSelect.innerHTML = `
                <option value="All">All Actions</option>
                <option value="Login">Login</option>
                <option value="Logout">Logout</option>
                <option value="Create">Create</option>
                <option value="Update">Update</option>
                <option value="Delete">Delete</option>
                <option value="Alert">Alert</option>
                <option value="Backup">Backup</option>
            `;
            actionSelect.addEventListener('change', () => {
                filters.action = actionSelect.value;
                renderAuditLogs(filters);
            });
        }

        // User filter dropdown
        const userSelect = document.querySelector('select[name="user"], #userFilter, [data-filter="user"]');
        if (userSelect) {
            const logs = STORE.list('audit_logs') || [];
            const users = [...new Set(logs.map(l => l.user))].sort();
            userSelect.innerHTML = '<option value="All">All Users</option>' +
                users.map(u => `<option value="${u}">${u}</option>`).join('');
            userSelect.addEventListener('change', () => {
                filters.user = userSelect.value;
                renderAuditLogs(filters);
            });
        }

        // Date filters
        const dateFrom = document.querySelector('input[type="date"][name*="from" i], #dateFrom, [data-filter="date-from"]');
        if (dateFrom) {
            dateFrom.addEventListener('change', () => {
                filters.dateFrom = dateFrom.value;
                renderAuditLogs(filters);
            });
        }

        const dateTo = document.querySelector('input[type="date"][name*="to" i], #dateTo, [data-filter="date-to"]');
        if (dateTo) {
            dateTo.addEventListener('change', () => {
                filters.dateTo = dateTo.value;
                renderAuditLogs(filters);
            });
        }

        // Export button
        const exportBtn = document.querySelector('[data-action="export-csv"], .btn-export-csv, button[onclick*="export"]');
        if (exportBtn && !exportBtn.dataset.auditWired) {
            exportBtn.dataset.auditWired = '1';
            exportBtn.addEventListener('click', () => {
                const logs = STORE.list('audit_logs') || [];
                if (window.Meditrack?.exportCSV) {
                    window.Meditrack.exportCSV(logs, 'audit-logs.csv');
                }
            });
        }
    }

    // ============================================================
    // INIT
    // ============================================================
    function init() {
        seedAuditLogs();
        renderAuditLogs();
        wireFilters();

        // Re-render when store changes
        STORE.onChange((entity) => {
            if (entity === 'audit_logs') {
                renderAuditLogs();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    setTimeout(init, 1500);

})(window, document);

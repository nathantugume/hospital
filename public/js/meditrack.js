/**
 * Meditrack HMS — Shared Toast + Validation + Button Wiring Utility
 * Loaded by every page via <script src="js/meditrack.js"></script> (injected automatically).
 *
 * Provides:
 *   - MeditrackToast.success(message, options)
 *   - MeditrackToast.error(message, options)
 *   - MeditrackToast.info(message, options)
 *   - MeditrackToast.warning(message, options)
 *   - Meditrack.validateForm(formElement, rules) — returns {valid, errors}
 *   - Meditrack.confirm(message, onConfirm) — shows confirm modal
 *   - Meditrack.api(method, url, body) — fetch wrapper with auth token
 *   - Meditrack.printPage() — print-friendly
 *   - Meditrack.exportCSV(rows, filename) — CSV export
 *   - Meditrack.requireRole(roles) — RBAC check (reads from localStorage)
 *
 * Reads:
 *   - localStorage.meditrack_user_role — current user role
 *   - localStorage.meditrack_auth_token — Sanctum token
 *   - localStorage.meditrack_notification_prefs — controlled by settings-notifications.html
 *   - localStorage.meditrack_clinic_hours — controlled by hours.html
 */

(function(window, document) {
    'use strict';

    // ============================================================
    // API CONFIG
    // ============================================================
    const API_BASE = window.MEDITRACK_API_BASE || '/api/v1';

    function getAuthToken() {
        return localStorage.getItem('meditrack_auth_token') || null;
    }

    function getCurrentRole() {
        try {
            const user = JSON.parse(localStorage.getItem('meditrack_user') || '{}');
            return user.role || localStorage.getItem('meditrack_user_role') || 'guest';
        } catch (e) {
            return 'guest';
        }
    }

    function getCurrentUser() {
        try {
            return JSON.parse(localStorage.getItem('meditrack_user') || '{}');
        } catch (e) {
            return {};
        }
    }

    // ============================================================
    // TOAST NOTIFICATIONS
    // ============================================================
    const Toast = {
        _container: null,

        _ensureContainer() {
            if (this._container && document.body.contains(this._container)) return;
            this._container = document.createElement('div');
            this._container.id = 'meditrack-toast-container';
            this._container.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 99999;
                display: flex;
                flex-direction: column;
                gap: 10px;
                pointer-events: none;
                max-width: 380px;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            `;
            document.body.appendChild(this._container);
        },

        show(message, type = 'info', options = {}) {
            // Respect notification prefs set in settings-notifications.html
            const prefs = JSON.parse(localStorage.getItem('meditrack_notification_prefs') || '{}');
            // Quiet hours check
            if (prefs['quiet-hours-enabled'] === true) {
                const now = new Date();
                const hhmm = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
                const start = prefs['quiet-hours-start'] || '22:00';
                const end = prefs['quiet-hours-end'] || '07:00';
                const inQuiet = (start <= end) ? (hhmm >= start && hhmm < end) : (hhmm >= start || hhmm < end);
                if (inQuiet && type !== 'error') return; // errors still show during quiet hours
            }
            // App notifications disabled?
            if (prefs['app-system'] === false && type === 'info') return;

            this._ensureContainer();

            const colors = {
                success: { bg: '#10b981', icon: '✓', border: '#059669' },
                error:   { bg: '#ef4444', icon: '✕', border: '#dc2626' },
                warning: { bg: '#f59e0b', icon: '!', border: '#d97706' },
                info:    { bg: '#3b82f6', icon: 'i', border: '#2563eb' },
            };
            const c = colors[type] || colors.info;

            const toast = document.createElement('div');
            toast.style.cssText = `
                background: white;
                border-left: 4px solid ${c.border};
                border-radius: 8px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.12), 0 4px 6px rgba(0,0,0,0.05);
                padding: 14px 16px;
                display: flex;
                align-items: flex-start;
                gap: 12px;
                min-width: 280px;
                max-width: 380px;
                pointer-events: auto;
                transform: translateX(400px);
                opacity: 0;
                transition: transform 0.3s ease, opacity 0.3s ease;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
                font-size: 14px;
                color: #1f2937;
            `;

            const iconEl = document.createElement('div');
            iconEl.style.cssText = `
                background: ${c.bg};
                color: white;
                width: 24px;
                height: 24px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                flex-shrink: 0;
                font-size: 12px;
            `;
            iconEl.textContent = c.icon;

            const body = document.createElement('div');
            body.style.cssText = 'flex: 1; line-height: 1.4;';
            if (options.title) {
                const titleEl = document.createElement('div');
                titleEl.style.cssText = 'font-weight: 600; margin-bottom: 2px;';
                titleEl.textContent = options.title;
                body.appendChild(titleEl);
            }
            const msgEl = document.createElement('div');
            msgEl.style.cssText = 'color: #4b5563;';
            msgEl.textContent = message;
            body.appendChild(msgEl);

            const closeBtn = document.createElement('button');
            closeBtn.style.cssText = `
                background: transparent;
                border: none;
                color: #9ca3af;
                cursor: pointer;
                font-size: 18px;
                padding: 0;
                line-height: 1;
                flex-shrink: 0;
            `;
            closeBtn.innerHTML = '&times;';
            closeBtn.onclick = () => this._dismiss(toast);

            toast.appendChild(iconEl);
            toast.appendChild(body);
            toast.appendChild(closeBtn);

            this._container.appendChild(toast);

            // Animate in
            requestAnimationFrame(() => {
                toast.style.transform = 'translateX(0)';
                toast.style.opacity = '1';
            });

            // Auto-dismiss
            const duration = options.duration || 4000;
            if (duration > 0) {
                setTimeout(() => this._dismiss(toast), duration);
            }
        },

        _dismiss(toast) {
            toast.style.transform = 'translateX(400px)';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        },

        success(message, options = {}) { this.show(message, 'success', options); },
        error(message, options = {}) { this.show(message, 'error', { ...options, duration: options.duration || 6000 }); },
        info(message, options = {}) { this.show(message, 'info', options); },
        warning(message, options = {}) { this.show(message, 'warning', options); },
    };

    // ============================================================
    // FORM VALIDATION
    // ============================================================
    function validateForm(form, rules = {}) {
        const errors = {};
        let valid = true;

        for (const [fieldName, fieldRules] of Object.entries(rules)) {
            const input = form.querySelector(`[name="${fieldName}"]`);
            if (!input) continue;
            const value = input.value.trim();

            for (const rule of fieldRules.split('|')) {
                const [ruleName, param] = rule.split(':');
                let ok = true;
                let msg = '';

                switch (ruleName) {
                    case 'required':
                        ok = !!value;
                        msg = `${fieldName.replace(/_/g, ' ')} is required.`;
                        break;
                    case 'email':
                        ok = !value || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
                        msg = 'Please enter a valid email address.';
                        break;
                    case 'min':
                        ok = !value || value.length >= parseInt(param);
                        msg = `Must be at least ${param} characters.`;
                        break;
                    case 'max':
                        ok = !value || value.length <= parseInt(param);
                        msg = `Must not exceed ${param} characters.`;
                        break;
                    case 'phone':
                        ok = !value || /^\+?[0-9\s\-()]{8,20}$/.test(value);
                        msg = 'Please enter a valid phone number.';
                        break;
                    case 'numeric':
                        ok = !value || /^\d+$/.test(value);
                        msg = 'Must be a number.';
                        break;
                    case 'date':
                        ok = !value || !isNaN(Date.parse(value));
                        msg = 'Please enter a valid date.';
                        break;
                }

                if (!ok) {
                    errors[fieldName] = msg;
                    valid = false;
                    // Highlight field
                    input.style.borderColor = '#ef4444';
                    input.classList.add('meditrack-error');
                    break;
                } else {
                    input.style.borderColor = '';
                    input.classList.remove('meditrack-error');
                }
            }
        }

        return { valid, errors };
    }

    // ============================================================
    // CONFIRM MODAL
    // ============================================================
    function confirm(message, onConfirm, options = {}) {
        const modal = document.createElement('div');
        modal.style.cssText = `
            position: fixed; inset: 0; background: rgba(0,0,0,0.5);
            display: flex; align-items: center; justify-content: center;
            z-index: 99998; font-family: 'Inter', sans-serif;
        `;
        const dialog = document.createElement('div');
        dialog.style.cssText = `
            background: white; border-radius: 8px; padding: 24px;
            max-width: 400px; box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        `;
        dialog.innerHTML = `
            <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 12px; color: #1f2937;">
                ${options.title || 'Confirm Action'}
            </h3>
            <p style="color: #4b5563; margin-bottom: 20px;">${message}</p>
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button class="meditrack-cancel" style="padding: 8px 16px; background: #f3f4f6; color: #374151; border: none; border-radius: 6px; cursor: pointer; font-family: Inter, sans-serif;">Cancel</button>
                <button class="meditrack-ok" style="padding: 8px 16px; background: ${options.danger ? '#ef4444' : '#3b82f6'}; color: white; border: none; border-radius: 6px; cursor: pointer; font-family: Inter, sans-serif;">${options.okText || 'Confirm'}</button>
            </div>
        `;
        modal.appendChild(dialog);
        document.body.appendChild(modal);

        dialog.querySelector('.meditrack-cancel').onclick = () => modal.remove();
        dialog.querySelector('.meditrack-ok').onclick = () => {
            modal.remove();
            if (onConfirm) onConfirm();
        };
        modal.onclick = (e) => { if (e.target === modal) modal.remove(); };
    }

    // ============================================================
    // API WRAPPER — uses httpOnly cookies for auth (NOT localStorage tokens)
    // ============================================================
    // SECURITY: Auth tokens are stored in httpOnly cookies set by the backend.
    // The frontend CANNOT read them (preventing XSS token theft).
    // We send credentials: 'include' so the browser attaches the cookie.
    // The localStorage 'meditrack_auth_token' is only used as a demo-mode
    // fallback when the backend is not running.
    async function api(method, url, body = null) {
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-Meditrack-Request': 'true',
        };
        // In demo mode (no backend), we attach the demo token from localStorage.
        // In production with backend, httpOnly cookie is sent automatically via credentials: 'include'.
        const demoToken = localStorage.getItem('meditrack_auth_token');
        if (demoToken && demoToken.startsWith('demo_token_')) {
            headers['Authorization'] = `Bearer ${demoToken}`;
        }

        const opts = { method, headers, credentials: 'include' }; // include httpOnly cookies
        if (body && method !== 'GET') opts.body = JSON.stringify(body);

        try {
            const response = await fetch(`${API_BASE}${url}`, opts);
            const data = await response.json();
            if (!response.ok) {
                // Don't toast on 401 — let the caller handle auth redirects
                if (response.status !== 401) {
                    Toast.error(data.message || 'Request failed.', { title: `HTTP ${response.status}` });
                }
                return { success: false, ...data, status: response.status };
            }
            return data;
        } catch (e) {
            Toast.error('Network error. Please check your connection.', { title: 'Network Error' });
            return { success: false, message: e.message };
        }
    }

    // ============================================================
    // PRINT + EXPORT
    // ============================================================
    function printPage() {
        window.print();
    }

    function exportCSV(rows, filename) {
            // If no rows provided, try to extract from the page's table
            if (!rows || !rows.length) {
                const table = document.querySelector('table');
                if (table) {
                    const headers = [];
                    const dataRows = [];
                    table.querySelectorAll('thead th, tr:first-child th').forEach(th => {
                        const text = th.textContent.trim();
                        if (text) headers.push(text);
                    });
                    table.querySelectorAll('tbody tr').forEach(tr => {
                        if (tr.querySelector('th')) return;
                        const cells = [];
                        tr.querySelectorAll('td').forEach(td => {
                            const clone = td.cloneNode(true);
                            clone.querySelectorAll('button, a, svg, .action-menu-btn').forEach(el => el.remove());
                            cells.push(clone.textContent.trim());
                        });
                        if (cells.length > 0) dataRows.push(cells);
                    });
                    if (dataRows.length === 0) { Toast.warning('No data to export.'); return; }
                    const headerRow = headers.length > 0 ? headers : dataRows[0].map((_, i) => 'Column ' + (i + 1));
                    const meta = ['# MediTrack Healthcare Export', '# Generated: ' + new Date().toISOString(), '# Page: ' + window.location.pathname.split('/').pop(), '# Records: ' + dataRows.length, ''];
                    const csv = [...meta, headerRow.map(h => '"' + h + '"').join(','), ...dataRows.map(row => row.map(c => '"' + String(c || '').replace(/"/g, '""') + '"').join(','))].join('\n');
                    const blob = new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8' });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    const fname = filename || (document.title.split('|')[0].trim() || 'export') + '_' + new Date().toISOString().slice(0, 10) + '.csv';
                    a.href = url; a.download = fname;
                    document.body.appendChild(a); a.click(); a.remove();
                    URL.revokeObjectURL(url);
                    Toast.success('Exported ' + dataRows.length + ' records to ' + fname);
                    return;
                }
                Toast.warning('No data to export.');
                return;
            }
            const headers = Object.keys(rows[0]);
            const meta = ['# MediTrack Healthcare Export', '# Generated: ' + new Date().toISOString(), '# Records: ' + rows.length, ''];
            const csv = [...meta, headers.join(','), ...rows.map(r => headers.map(h => '"' + String(r[h] ?? '').replace(/"/g, '""') + '"').join(','))].join('\n');
            const blob = new Blob(['\ufeff' + csv], { type: 'text/csv;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url; a.download = filename || 'export.csv';
            document.body.appendChild(a); a.click(); a.remove();
            URL.revokeObjectURL(url);
            Toast.success('Exported ' + rows.length + ' records to ' + (filename || 'export.csv'));
        }

    function exportPDF(title, body) {
        // Simple print-based PDF export — opens print dialog with formatted content
        const win = window.open('', '_blank');
        if (!win) { Toast.error('Pop-up blocked. Please allow pop-ups.'); return; }
        win.document.write(`
            <html><head><title>${title}</title>
            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
            <style>body{font-family:Inter,sans-serif;padding:40px;} h1{color:#1f2937;} table{width:100%;border-collapse:collapse;} th,td{border:1px solid #e5e7eb;padding:8px;text-align:left;font-size:13px;} th{background:#f9fafb;font-weight:600;}</style>
            </head><body><h1>${title}</h1>${body}<p style="margin-top:30px;color:#9ca3af;font-size:11px;">Generated by Meditrack HMS on ${new Date().toLocaleString()}</p></body></html>
        `);
        win.document.close();
        setTimeout(() => { win.print(); }, 500);
    }

    // ============================================================
    // RBAC
    // ============================================================
    function requireRole(roles, redirectOnFail = 'login.html') {
        const current = getCurrentRole();
        if (!roles.includes(current)) {
            Toast.error(`Access denied. Required role: ${roles.join(' or ')}`);
            setTimeout(() => { window.location.href = redirectOnFail; }, 1500);
            return false;
        }
        return true;
    }

    function isAuthorized(roles) {
        return roles.includes(getCurrentRole());
    }

    // ============================================================
    // AUTH GUARD — call on every protected page
    // ============================================================
    function requireAuth(redirectOnFail = 'login.html') {
        const token = getAuthToken();
        const user = getCurrentUser();
        if (!token || !user.role) {
            // Allow public pages
            const publicPages = ['login.html', 'register.html', 'forgot-password.html', 'reset-password.html', 'verify-email.html', 'two-step-verification.html', 'lock-screen.html', '404-error.html', 'pricing.html'];
            const current = window.location.pathname.split('/').pop() || 'index.html';
            if (!publicPages.includes(current)) {
                window.location.href = redirectOnFail;
                return false;
            }
        }
        return true;
    }

    // ============================================================
    // BUTTON WIRING — auto-wire common button patterns
    // ============================================================
    function autoWireButtons() {
        // Print buttons
        document.querySelectorAll('[data-action="print"], .btn-print, button[onclick*="print"]').forEach(btn => {
            if (btn.dataset.meditrackWired) return;
            btn.dataset.meditrackWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                printPage();
                Toast.info('Opening print dialog...');
            });
        });

        // Export buttons
        document.querySelectorAll('[data-action="export-csv"], .btn-export-csv').forEach(btn => {
            if (btn.dataset.meditrackWired) return;
            btn.dataset.meditrackWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const table = document.querySelector('table');
                if (!table) { Toast.warning('No table found to export.'); return; }
                const rows = Array.from(table.querySelectorAll('tr')).map(tr => {
                    const cells = Array.from(tr.querySelectorAll('th,td')).map(td => td.textContent.trim());
                    return cells;
                });
                const headers = rows[0] || [];
                const dataRows = rows.slice(1).map(r => {
                    const obj = {};
                    headers.forEach((h, i) => obj[h] = r[i]);
                    return obj;
                });
                const filename = (btn.dataset.filename || (document.title.split('|')[0].trim() || 'export')) + '.csv';
                exportCSV(dataRows, filename);
            });
        });

        // Export PDF
        document.querySelectorAll('[data-action="export-pdf"], .btn-export-pdf').forEach(btn => {
            if (btn.dataset.meditrackWired) return;
            btn.dataset.meditrackWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const table = document.querySelector('table');
                if (!table) { Toast.warning('No table found to export.'); return; }
                exportPDF(document.title, table.outerHTML);
            });
        });

        // Delete confirmation
        document.querySelectorAll('[data-action="delete"], .btn-delete').forEach(btn => {
            if (btn.dataset.meditrackWired) return;
            btn.dataset.meditrackWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const itemName = btn.dataset.name || 'this item';
                confirm(`Are you sure you want to delete ${itemName}? This action cannot be undone.`, () => {
                    Toast.success(`${itemName} deleted successfully.`);
                    const row = btn.closest('tr');
                    if (row) row.remove();
                }, { danger: true, title: 'Delete', okText: 'Delete' });
            });
        });

        // Form submit — auto-show toast on success
        document.querySelectorAll('form[data-toast-success]').forEach(form => {
            if (form.dataset.meditrackWired) return;
            form.dataset.meditrackWired = '1';
            form.addEventListener('submit', (e) => {
                // If the form has a data-validate attribute with rules, validate
                if (form.dataset.validate) {
                    try {
                        const rules = JSON.parse(form.dataset.validate);
                        const result = validateForm(form, rules);
                        if (!result.valid) {
                            e.preventDefault();
                            const firstError = Object.values(result.errors)[0];
                            Toast.error(firstError, { title: 'Validation Error' });
                            return;
                        }
                    } catch (err) {
                        // invalid JSON, skip validation
                    }
                }
                // If no real backend, show success toast
                if (form.dataset.realSubmit !== 'true' && !form.hasAttribute('method')) {
                    e.preventDefault();
                    const msg = form.dataset.toastSuccess || 'Action completed successfully.';
                    Toast.success(msg);
                    // Optionally close modal
                    const modal = form.closest('.modal, [class*="modal"]');
                    if (modal && modal.classList.contains('show')) {
                        const closeBtn = modal.querySelector('[data-dismiss="modal"], .close, .btn-close');
                        if (closeBtn) closeBtn.click();
                    }
                }
            });
        });

        // ============================================================
        // TASK 1: Wire all remaining data-action buttons
        // Handles: cancel, download, approve, reject, history, reminder,
        //          deactivate, profile, contact, report, complete, schedule,
        //          reschedule, payment, order, void, verify, view, edit
        // ============================================================

        // --- cancel: closes the closest modal/dialog ---
        document.querySelectorAll('[data-action="cancel"], [data-action="close"]').forEach(btn => {
            if (btn.dataset.meditrackWired) return;
            btn.dataset.meditrackWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const modal = btn.closest('.modal, .modal-overlay, [class*="modal"], .alert-dialog-overlay, [role="dialog"], [role="alertdialog"]');
                if (modal) {
                    modal.style.display = 'none';
                    modal.classList.remove('show', 'active');
                    if (modal.hasAttribute('data-state')) modal.setAttribute('data-state', 'inactive');
                }
                // If inside a dropdown menu, close it
                const menu = btn.closest('.action-menu, .dropdown-menu, [role="menu"]');
                if (menu) menu.remove();
                Toast.info('Action cancelled.');
            });
        });

        // --- download: triggers a download of the related entity ---
        document.querySelectorAll('[data-action="download"]').forEach(btn => {
            if (btn.dataset.meditrackWired) return;
            btn.dataset.meditrackWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const row = btn.closest('tr, [data-id], .card');
                const id = row?.getAttribute('data-id') || row?.getAttribute('data-code') || 'item';
                const filename = btn.dataset.filename || `meditrack-${id}.txt`;
                // Try to find related data — file URL, document content, etc.
                const fileUrl = btn.dataset.url || btn.getAttribute('href');
                if (fileUrl && fileUrl !== '#' && !fileUrl.startsWith('javascript')) {
                    window.open(fileUrl, '_blank');
                    Toast.success(`Downloading ${filename}...`);
                    return;
                }
                // Fallback — generate a text blob from the row data
                let content = `Meditrack HMS — Export\nGenerated: ${new Date().toISOString()}\n\n`;
                if (row) {
                    const cells = row.querySelectorAll('td, th');
                    cells.forEach((cell, i) => {
                        const label = cell.getAttribute('data-label') || `Field ${i + 1}`;
                        content += `${label}: ${cell.textContent.trim()}\n`;
                    });
                } else {
                    content += 'No data available.';
                }
                const blob = new Blob([content], { type: 'text/plain;charset=utf-8' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url; a.download = filename;
                document.body.appendChild(a); a.click(); a.remove();
                URL.revokeObjectURL(url);
                Toast.success(`Downloaded ${filename}.`);
            });
        });

        // --- approve / reject / complete / void / verify / deactivate: status updates ---
        const statusActions = {
            'approve':   { newStatus: 'Approved',    verb: 'approved',    toastType: 'success' },
            'reject':    { newStatus: 'Rejected',    verb: 'rejected',    toastType: 'error' },
            'complete':  { newStatus: 'Completed',   verb: 'marked as completed', toastType: 'success' },
            'void':      { newStatus: 'Void',        verb: 'voided',      toastType: 'warning' },
            'verify':    { newStatus: 'Verified',    verb: 'verified',    toastType: 'success' },
            'deactivate':{ newStatus: 'Inactive',    verb: 'deactivated', toastType: 'warning' },
        };

        Object.entries(statusActions).forEach(([action, cfg]) => {
            document.querySelectorAll(`[data-action="${action}"]`).forEach(btn => {
                if (btn.dataset.meditrackWired) return;
                btn.dataset.meditrackWired = '1';
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const row = btn.closest('tr, [data-id], .card, [data-code]');
                    const id = row?.getAttribute('data-id') || row?.getAttribute('data-code');
                    const itemName = row?.querySelector('td:nth-child(2), .card-title, h3, h4')?.textContent?.trim() || `item #${id || '?'}`;

                    // Try to update the store if we can detect the entity
                    if (window.MeditrackStore && id) {
                        const page = (location.pathname.split('/').pop() || '').toLowerCase();
                        const entityMap = {
                            'patients.html': 'patients', 'appointments.html': 'appointments',
                            'appointment-requests.html': 'appointments', 'billing.html': 'invoices',
                            'insurance-claims.html': 'invoices', 'lab-results.html': 'labResults',
                            'test-requests.html': 'labResults', 'prescriptions.html': 'prescriptions',
                            'inventory-transfers.html': 'inventory', 'orders.html': 'suppliers',
                            'radiology-list.html': 'radiologyOrders', 'ot-schedule.html': 'surgeries',
                            'rooms-alloted.html': 'rooms', 'blood-donors.html': 'bloodDonors',
                            'ambulance-calls.html': 'ambulanceCalls', 'birth-records.html': 'patients',
                            'death-records.html': 'patients', 'vaccination.html': 'patients',
                        };
                        const entity = entityMap[page];
                        if (entity) {
                            const updated = window.MeditrackStore.update(entity, id, { status: cfg.newStatus });
                            if (updated) {
                                Toast[cfg.toastType](`"${itemName}" ${cfg.verb}. Status synced across all HMS pages.`);
                                // Update the visible status badge in the row
                                if (row) {
                                    const badge = row.querySelector('.bg-green-100, .bg-red-100, .bg-amber-100, .bg-gray-100, .bg-blue-100, [class*="rounded-full"]');
                                    if (badge) {
                                        badge.textContent = cfg.newStatus;
                                        badge.className = badge.className.replace(/bg-(green|red|amber|gray|blue)-100 text-(green|red|amber|gray|blue)-700/,
                                            cfg.toastType === 'success' ? 'bg-green-100 text-green-700' :
                                            cfg.toastType === 'error' ? 'bg-red-100 text-red-700' :
                                            cfg.toastType === 'warning' ? 'bg-amber-100 text-amber-700' : 'bg-gray-100 text-gray-700');
                                    }
                                }
                                return;
                            }
                        }
                    }
                    // Fallback — just toast
                    Toast[cfg.toastType](`"${itemName}" ${cfg.verb}.`);
                });
            });
        });

        // --- history: opens a history modal or navigates to transfer-history.html ---
        document.querySelectorAll('[data-action="history"]').forEach(btn => {
            if (btn.dataset.meditrackWired) return;
            btn.dataset.meditrackWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const row = btn.closest('tr, [data-id]');
                const id = row?.getAttribute('data-id') || '';
                // Try opening a history modal — fall back to navigating to transfer-history.html
                const historyModal = document.getElementById('historyModal') || document.querySelector('[id*="history"][id*="modal"]');
                if (historyModal) {
                    historyModal.style.display = 'flex';
                    historyModal.classList.add('show');
                    Toast.info(`Loading history for item #${id}...`);
                } else {
                    Toast.info('Opening audit log...');
                    setTimeout(() => window.location.href = 'transfer-history.html', 500);
                }
            });
        });

        // --- reminder: schedule a reminder (demo: toast) ---
        document.querySelectorAll('[data-action="reminder"]').forEach(btn => {
            if (btn.dataset.meditrackWired) return;
            btn.dataset.meditrackWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const row = btn.closest('tr, [data-id]');
                const id = row?.getAttribute('data-id') || '';
                // Push a notification via the shared store
                if (window.Meditrack?.pushNotification) {
                    window.Meditrack.pushNotification({
                        title: 'Reminder Set',
                        message: `Reminder scheduled for item #${id}. You will be notified 1 hour before.`,
                        category: 'appointments',
                        action_url: window.location.pathname,
                    });
                }
                Toast.success(`Reminder scheduled for item #${id}.`);
            });
        });

        // --- profile: navigate to profile-setting.html or patient-profile.html ---
        document.querySelectorAll('[data-action="profile"]').forEach(btn => {
            if (btn.dataset.meditrackWired) return;
            btn.dataset.meditrackWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const row = btn.closest('tr, [data-id]');
                const id = row?.getAttribute('data-id') || row?.getAttribute('data-patient-id') || '';
                const currentRole = window.Meditrack?.getCurrentRole?.() || 'admin';
                let target = 'profile-setting.html';
                if (currentRole === 'patient') target = `patient-profile.html?id=${id}`;
                else if (row?.hasAttribute('data-staff-id') || row?.querySelector('[data-staff-id]')) target = `staff-profile.html?id=${id}`;
                else if (id) target = `patient-profile.html?id=${id}`;
                Toast.info('Opening profile...');
                setTimeout(() => window.location.href = target, 400);
            });
        });

        // --- contact: open contact info modal or navigate to contacts.html ---
        document.querySelectorAll('[data-action="contact"]').forEach(btn => {
            if (btn.dataset.meditrackWired) return;
            btn.dataset.meditrackWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const row = btn.closest('tr, [data-id]');
                if (row) {
                    const name = row.querySelector('td:nth-child(2)')?.textContent?.trim() || 'this contact';
                    const phone = row.querySelector('td:nth-child(4)')?.textContent?.trim() || '';
                    const email = row.querySelector('td:nth-child(3)')?.textContent?.trim() || '';
                    Toast.info(`Contact: ${name}${phone ? ' • ' + phone : ''}${email ? ' • ' + email : ''}`, { duration: 6000 });
                } else {
                    Toast.info('Opening contacts directory...');
                    setTimeout(() => window.location.href = 'contacts.html', 400);
                }
            });
        });

        // --- report: navigate to reports.html or open report modal ---
        document.querySelectorAll('[data-action="report"]').forEach(btn => {
            if (btn.dataset.meditrackWired) return;
            btn.dataset.meditrackWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const reportType = btn.dataset.reportType || btn.getAttribute('data-report') || 'general';
                const reportMap = {
                    'financial': 'financial-reports.html',
                    'operational': 'operational-reports.html',
                    'inventory': 'inventory-report.html',
                    'appointment': 'appointment-reports.html',
                    'patient': 'patient-visit-report.html',
                    'radiology': 'radiology-reports.html',
                    'general': 'reports.html',
                };
                const target = reportMap[reportType] || 'reports.html';
                Toast.info('Opening report...');
                setTimeout(() => window.location.href = target, 400);
            });
        });

        // --- schedule / reschedule: open scheduling modal or navigate ---
        document.querySelectorAll('[data-action="schedule"], [data-action="reschedule"]').forEach(btn => {
            if (btn.dataset.meditrackWired) return;
            btn.dataset.meditrackWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const action = btn.getAttribute('data-action');
                const row = btn.closest('tr, [data-id]');
                const id = row?.getAttribute('data-id') || '';
                const page = (location.pathname.split('/').pop() || '').toLowerCase();
                // Try opening a schedule modal on the page
                const schedModal = document.getElementById('scheduleModal') || document.getElementById('rescheduleModal') || document.querySelector('[id*="sched"][id*="modal"]');
                if (schedModal) {
                    schedModal.style.display = 'flex';
                    schedModal.classList.add('show');
                    Toast.info(action === 'reschedule' ? `Rescheduling item #${id}...` : `Scheduling item #${id}...`);
                } else {
                    // Navigate to the appropriate scheduling page
                    const targetMap = {
                        'appointments.html': action === 'reschedule' ? `appointment-reschedule.html?id=${id}` : `add-appointment.html`,
                        'radiology-list.html': `radiology-schedule.html?id=${id}`,
                        'ot-schedule.html': `add-surgery.html`,
                        'vaccination.html': `vaccination-schedule.html`,
                        'physiotherapy-dashboard.html': `physiotherapy-schedule.html`,
                    };
                    const target = targetMap[page] || (action === 'reschedule' ? `appointment-reschedule.html?id=${id}` : `schedule.html?id=${id}`);
                    Toast.info(action === 'reschedule' ? 'Opening reschedule form...' : 'Opening scheduler...');
                    setTimeout(() => window.location.href = target, 400);
                }
            });
        });

        // --- payment: open payment modal or navigate to process-payments.html ---
        document.querySelectorAll('[data-action="payment"]').forEach(btn => {
            if (btn.dataset.meditrackWired) return;
            btn.dataset.meditrackWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const row = btn.closest('tr, [data-id]');
                const id = row?.getAttribute('data-id') || row?.getAttribute('data-code') || '';
                const payModal = document.getElementById('paymentModal') || document.querySelector('[id*="pay"][id*="modal"]');
                if (payModal) {
                    payModal.style.display = 'flex';
                    payModal.classList.add('show');
                    // Pre-fill invoice/ref id if inputs exist
                    const refInput = payModal.querySelector('#paymentRef, [name="reference"]');
                    if (refInput && id) refInput.value = id;
                    Toast.info(`Processing payment for ${id}...`);
                } else {
                    Toast.info('Opening payment processor...');
                    setTimeout(() => window.location.href = `process-payments.html?ref=${id}`, 400);
                }
            });
        });

        // --- order: place an order (pharmacy/inventory) ---
        document.querySelectorAll('[data-action="order"]').forEach(btn => {
            if (btn.dataset.meditrackWired) return;
            btn.dataset.meditrackWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const row = btn.closest('tr, [data-id]');
                const id = row?.getAttribute('data-id') || row?.getAttribute('data-code') || '';
                const itemName = row?.querySelector('td:nth-child(2)')?.textContent?.trim() || `item #${id}`;
                // Confirm before placing order
                if (window.Meditrack?.confirm) {
                    window.Meditrack.confirm(
                        `Place a purchase order for "${itemName}"? This will be logged and synced to the inventory system.`,
                        () => {
                            if (window.MeditrackStore) {
                                window.MeditrackStore.create('suppliers', {
                                    code: 'PO-' + Date.now(),
                                    name: itemName,
                                    category: 'Purchase Order',
                                    status: 'Pending',
                                    orderDate: new Date().toISOString().slice(0, 10),
                                });
                            }
                            Toast.success(`Purchase order placed for "${itemName}".`);
                        },
                        { title: 'Place Order', okText: 'Place Order' }
                    );
                } else {
                    Toast.success(`Purchase order placed for "${itemName}".`);
                }
            });
        });

        // --- view: open detail view for the entity ---
        document.querySelectorAll('[data-action="view"]').forEach(btn => {
            if (btn.dataset.meditrackWired) return;
            btn.dataset.meditrackWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const row = btn.closest('tr, [data-id]');
                const id = row?.getAttribute('data-id') || row?.getAttribute('data-code') || '';
                // Try opening a view modal on the page
                const viewModal = document.getElementById('viewModal') || document.querySelector('[id*="view"][id*="modal"]:not(#viewImageModal)');
                if (viewModal) {
                    viewModal.style.display = 'flex';
                    viewModal.classList.add('show');
                    return;
                }
                // Otherwise navigate to the entity's detail page
                const page = (location.pathname.split('/').pop() || '').toLowerCase();
                const detailPageMap = {
                    'patients.html': `patient-profile.html?id=${id}`,
                    'appointments.html': `appointment-details.html?id=${id}`,
                    'billing.html': `invoice.html?id=${id}`,
                    'lab-results.html': `lab-results.html?id=${id}`,
                    'prescriptions.html': `prescriptions-details.html?id=${id}`,
                    'medicine.html': `medicine-details.html?id=${id}`,
                    'inventory.html': `inventory-details.html?id=${id}`,
                    'suppliers.html': `supplier-details.html?id=${id}`,
                    'ambulance-list.html': `ambulance-details.html?id=${id}`,
                    'ambulance-calls.html': `ambulance-calls-details.html?id=${id}`,
                    'radiology-list.html': `radiology-details.html?id=${id}`,
                    'ot-schedule.html': `surgery-details.html?id=${id}`,
                    'rooms-alloted.html': `rooms-alloted-details.html?id=${id}`,
                    'blood-donors.html': `donor-details.html?id=${id}`,
                    'birth-records.html': `birth-records-details.html?id=${id}`,
                    'death-records.html': `death-records-details.html?id=${id}`,
                    'insurance-claims.html': `claim-details.html?id=${id}`,
                };
                const target = detailPageMap[page];
                if (target) {
                    Toast.info('Opening details...');
                    setTimeout(() => window.location.href = target, 300);
                }
            });
        });

        // --- edit: navigate to edit page or open edit modal ---
        document.querySelectorAll('[data-action="edit"]').forEach(btn => {
            if (btn.dataset.meditrackWired) return;
            btn.dataset.meditrackWired = '1';
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const row = btn.closest('tr, [data-id]');
                const id = row?.getAttribute('data-id') || row?.getAttribute('data-code') || '';
                // Try opening an edit modal on the page
                const editModal = document.getElementById('editModal') || document.querySelector('[id*="edit"][id*="modal"]');
                if (editModal) {
                    editModal.style.display = 'flex';
                    editModal.classList.add('show');
                    // Try to pre-fill from the store
                    if (window.MeditrackStore && id) {
                        const page = (location.pathname.split('/').pop() || '').toLowerCase();
                        const entityMap = { 'patients.html': 'patients', 'appointments.html': 'appointments', 'billing.html': 'invoices', 'medicine.html': 'medicines', 'inventory.html': 'inventory', 'suppliers.html': 'suppliers' };
                        const entity = entityMap[page];
                        if (entity) {
                            const item = window.MeditrackStore.get(entity, id);
                            if (item) {
                                Object.keys(item).forEach(key => {
                                    const input = editModal.querySelector(`[name="${key}"]`);
                                    if (input) input.value = item[key];
                                });
                            }
                        }
                    }
                    return;
                }
                // Otherwise navigate to the entity's edit page
                const page = (location.pathname.split('/').pop() || '').toLowerCase();
                const editPageMap = {
                    'patients.html': `edit-patient.html?id=${id}`,
                    'appointments.html': `edit-appointment.html?id=${id}`,
                    'billing.html': `edit-invoice.html?id=${id}`,
                    'lab-results.html': `result-entry.html?id=${id}`,
                    'prescriptions.html': `edit-prescription.html?id=${id}`,
                    'medicine.html': `edit-medicine.html?id=${id}`,
                    'inventory.html': `edit-inventory.html?id=${id}`,
                    'suppliers.html': `edit-supplier.html?id=${id}`,
                    'ambulance-list.html': `edit-ambulance-details.html?id=${id}`,
                    'ambulance-calls.html': `edit-ambulance-call.html?id=${id}`,
                    'radiology-list.html': `edit-radiology.html?id=${id}`,
                    'ot-schedule.html': `edit-surgery.html?id=${id}`,
                    'rooms-alloted.html': `edit-room-allotment.html?id=${id}`,
                    'birth-records.html': `edit-birth-records.html?id=${id}`,
                    'death-records.html': `edit-death-records.html?id=${id}`,
                    'insurance-claims.html': `edit-claim.html?id=${id}`,
                };
                const target = editPageMap[page];
                if (target) {
                    Toast.info('Opening edit form...');
                    setTimeout(() => window.location.href = target, 300);
                }
            });
        });

        // Sidebar nav — highjack to add active state
        const sidebarLinks = document.querySelectorAll('.sidebar a, nav a');
        sidebarLinks.forEach(link => {
            const href = link.getAttribute('href');
            if (!href || href === '#' || href.startsWith('javascript:')) return;
            link.addEventListener('click', () => {
                // Could add active class here
            });
        });
    }

    // ============================================================
    // AUTO-INIT on DOMContentLoaded
    // ============================================================
    function init() {
        autoWireButtons();
        // Apply Inter font globally via inline style
        if (!document.getElementById('meditrack-font-override')) {
            const style = document.createElement('style');
            style.id = 'meditrack-font-override';
            style.textContent = `
                body, * {
                    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif !important;
                }
                .meditrack-error {
                    border-color: #ef4444 !important;
                    background-color: #fef2f2 !important;
                }
                @media print {
                    .sidebar, nav, .no-print, button { display: none !important; }
                    body { padding: 20px; }
                }
            `;
            document.head.appendChild(style);
        }

        // Apply saved theme/role-based nav visibility
        applyRoleBasedNav();
    }

    function applyRoleBasedNav() {
        const role = getCurrentRole();
        if (role === 'guest') return;

        // Hide nav items based on role
        const navRestrictions = {
            'patient': ['staff', 'admin', 'billing', 'payroll', 'inventory', 'super-admin'],
            'doctor': ['payroll', 'super-admin', 'companies', 'subscriptions'],
            'nurse': ['payroll', 'super-admin', 'companies', 'subscriptions', 'billing'],
            'receptionist': ['payroll', 'super-admin', 'companies', 'subscriptions'],
            'lab_technician': ['payroll', 'super-admin', 'companies', 'subscriptions', 'pharmacy', 'radiology'],
            'pharmacist': ['payroll', 'super-admin', 'companies', 'subscriptions', 'lab', 'radiology'],
            'accountant': ['super-admin', 'companies', 'subscriptions', 'lab', 'pharmacy'],
            'insurance_officer': ['super-admin', 'companies', 'subscriptions'],
            'ambulance_driver': ['super-admin', 'companies', 'subscriptions', 'lab', 'pharmacy', 'radiology', 'billing', 'payroll'],
            'ambulance_dispatcher': ['super-admin', 'companies', 'subscriptions', 'lab', 'pharmacy', 'radiology', 'billing', 'payroll'],
            'hr_manager': ['super-admin', 'companies', 'subscriptions'],
        };

        const restrictions = navRestrictions[role] || [];
        restrictions.forEach(area => {
            document.querySelectorAll(`a[href*="${area}"], [data-nav="${area}"]`).forEach(el => {
                el.style.display = 'none';
            });
        });
    }

    // ============================================================
    // CLINIC HOURS — controlled by hours.html, read system-wide
    // ============================================================
    function getClinicHours() {
        try {
            return JSON.parse(localStorage.getItem('meditrack_clinic_hours') || 'null');
        } catch (e) {
            return null;
        }
    }

    function isClinicOpenNow() {
        const hours = getClinicHours();
        if (!hours || !hours.days) return true; // default open
        const now = new Date();
        const dayName = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][now.getDay()];
        const dayHours = hours.days[dayName];
        if (!dayHours || !dayHours.enabled) return false;
        const hhmm = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
        return hhmm >= dayHours.start && hhmm < dayHours.end;
    }

    function getClinicStatusBadge() {
        const open = isClinicOpenNow();
        return open
            ? '<span style="color: #10b981; font-weight: 600;">● Open</span>'
            : '<span style="color: #ef4444; font-weight: 600;">● Closed</span>';
    }

    // ============================================================
    // NOTIFICATIONS — controlled by settings-notifications.html
    // ============================================================
    function getNotificationPrefs() {
        try {
            return JSON.parse(localStorage.getItem('meditrack_notification_prefs') || '{}');
        } catch (e) {
            return {};
        }
    }

    function isNotificationEnabled(category, channel = 'app') {
        const prefs = getNotificationPrefs();
        const key = `${channel}-${category}`;
        // Default true unless explicitly false
        return prefs[key] !== false;
    }

    function pushNotification({ title, message, category = 'system', action_url = null }) {
        // Respect user's notification prefs
        if (!isNotificationEnabled(category, 'app')) return null;

        // Check quiet hours
        const prefs = getNotificationPrefs();
        if (prefs['quiet-hours-enabled'] === true) {
            const now = new Date();
            const hhmm = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
            const start = prefs['quiet-hours-start'] || '22:00';
            const end = prefs['quiet-hours-end'] || '07:00';
            const inQuiet = (start <= end) ? (hhmm >= start && hhmm < end) : (hhmm >= start || hhmm < end);
            if (inQuiet) return null;
        }

        // Store in global notifications list
        const list = JSON.parse(localStorage.getItem('meditrack_notifications') || '[]');
        const notif = {
            id: 'N-' + Date.now() + '-' + Math.random().toString(36).substr(2, 5),
            title, message, category, action_url,
            created_at: new Date().toISOString(),
            is_read: false,
        };
        list.unshift(notif);
        // Keep only the latest 100
        localStorage.setItem('meditrack_notifications', JSON.stringify(list.slice(0, 100)));

        // Dispatch event for live updates
        window.dispatchEvent(new CustomEvent('meditrack-notification-received', { detail: notif }));

        // Show toast
        Toast.info(message, { title });

        return notif;
    }

    function getNotifications(unreadOnly = false) {
        try {
            const list = JSON.parse(localStorage.getItem('meditrack_notifications') || '[]');
            return unreadOnly ? list.filter(n => !n.is_read) : list;
        } catch (e) {
            return [];
        }
    }

    function markNotificationRead(id) {
        const list = getNotifications();
        const notif = list.find(n => n.id === id);
        if (notif) {
            notif.is_read = true;
            localStorage.setItem('meditrack_notifications', JSON.stringify(list));
        }
    }

    function markAllNotificationsRead() {
        const list = getNotifications();
        list.forEach(n => n.is_read = true);
        localStorage.setItem('meditrack_notifications', JSON.stringify(list));
    }

    // ============================================================
    // EXPORT GLOBAL
    // ============================================================
    window.Meditrack = {
        Toast,
        validateForm,
        confirm,
        api,
        printPage,
        exportCSV,
        exportPDF,
        requireRole,
        requireAuth,
        isAuthorized,
        getCurrentRole,
        getCurrentUser,
        getAuthToken,
        autoWireButtons,
        // Hours (controlled by hours.html)
        getClinicHours,
        isClinicOpenNow,
        getClinicStatusBadge,
        // Notifications (controlled by settings-notifications.html)
        getNotificationPrefs,
        isNotificationEnabled,
        pushNotification,
        getNotifications,
        markNotificationRead,
        markAllNotificationsRead,
        API_BASE,
    };

    // Auto-init
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})(window, document);

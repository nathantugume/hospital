/**
 * Meditrack HMS — Super-Admin ↔ Staff ↔ Departments Sync
 * ============================================================
 * Injected into: super-admin.html, staff.html, departments.html,
 *                staff-management.html, role-users.html, roles-permissions.html
 *
 * This script wires every table on these pages to the shared
 * MeditrackStore. When super-admin assigns a role or adds a department,
 * the change is persisted to localStorage and broadcast to all other
 * open pages, which re-render automatically.
 *
 * It also intercepts form submissions (Add/Edit modals) and "Delete" buttons
 * so they write to the store.
 */

(function(window, document) {
    'use strict';

    if (!window.MeditrackStore) {
        console.warn('[AdminSync] MeditrackStore not loaded');
        return;
    }

    const STORE = window.MeditrackStore;
    const Toast = window.Meditrack?.Toast;

    // ============================================================
    // TABLE → STORE MAPPING
    // Heuristically detect which entity a table represents by looking
    // at its column headers, then re-render rows from the store.
    // ============================================================

    function detectEntityFromTable(table) {
        const headers = Array.from(table.querySelectorAll('thead th, th')).map(th => th.textContent.trim().toLowerCase());
        const headerStr = headers.join('|');

        if (/role|permission/.test(headerStr) && /user|staff|assigned/.test(headerStr)) return 'roleAssignments';
        if (/department|head|staff\s*count/.test(headerStr)) return 'departments';
        if (/role|position|specialization/.test(headerStr) && /name|email/.test(headerStr)) return 'staff';
        if (/permission|module|access/.test(headerStr) && !/user/.test(headerStr)) return 'roles';
        return null;
    }

    function renderTableFromStore(table, entity) {
        const tbody = table.querySelector('tbody');
        if (!tbody) return;

        const items = STORE.list(entity);
        if (!items || !items.length) {
            tbody.innerHTML = `<tr><td colspan="99" class="text-center text-gray-400 py-8">No ${entity} found. Add one to get started.</td></tr>`;
            return;
        }

        // Keep the original first row as a template (for column structure)
        const firstRow = tbody.querySelector('tr');
        if (!firstRow) return;
        const cellCount = firstRow.querySelectorAll('td').length;

        // Re-render rows from store data
        tbody.innerHTML = items.map(item => {
            const cells = renderRowCells(entity, item);
            return `<tr data-id="${item.id}">${cells}</tr>`;
        }).join('');
    }

    function renderRowCells(entity, item) {
        const cell = (val, cls = '') => `<td class="px-4 py-3 text-sm ${cls}">${val ?? '—'}</td>`;

        const avatar = (initials, color = 'indigo') => `
            <td class="px-4 py-3">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-full bg-${color}-100 text-${color}-600 flex items-center justify-center text-xs font-semibold">${initials}</div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">${item.name || '—'}</div>
                        <div class="text-xs text-gray-500">${item.email || item.code || ''}</div>
                    </div>
                </div>
            </td>`;

        switch (entity) {
            case 'departments':
                return `
                    <td class="px-4 py-3 text-sm text-gray-500">${item.code || '—'}</td>
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">${item.name}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.head || '—'}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.staffCount || 0}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.servicesCount || 0}</td>
                    <td class="px-4 py-3"><span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ${item.status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'}">${item.status || 'Active'}</span></td>
                    <td class="px-4 py-3 text-right">
                        <button class="text-indigo-600 hover:text-indigo-900 text-sm mr-2" data-action="edit-dept" data-id="${item.id}">Edit</button>
                        <button class="text-red-600 hover:text-red-900 text-sm" data-action="delete-dept" data-id="${item.id}">Delete</button>
                    </td>
                `;
            case 'staff':
                const initials = (item.name || '').split(' ').map(p => p[0]).join('').slice(0, 2).toUpperCase();
                return `
                    ${avatar(initials)}
                    <td class="px-4 py-3 text-sm text-gray-500">${item.role || '—'}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.department || '—'}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.phone || '—'}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.joined || '—'}</td>
                    <td class="px-4 py-3"><span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ${item.status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'}">${item.status || 'Active'}</span></td>
                    <td class="px-4 py-3 text-right">
                        <button class="text-indigo-600 hover:text-indigo-900 text-sm mr-2" data-action="edit-staff" data-id="${item.id}">Edit</button>
                        <button class="text-red-600 hover:text-red-900 text-sm" data-action="delete-staff" data-id="${item.id}">Delete</button>
                    </td>
                `;
            case 'roleAssignments':
                const roleBadges = (item.roles || []).map(r =>
                    `<span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium bg-indigo-100 text-indigo-700 mr-1">${r}</span>`
                ).join('');
                return `
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">${item.staffName}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.email}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.department}</td>
                    <td class="px-4 py-3 text-sm">${roleBadges || '<span class="text-gray-400">No roles</span>'}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.assignedBy || 'System'}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.lastUpdated || '—'}</td>
                    <td class="px-4 py-3"><span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ${item.status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600'}">${item.status || 'Active'}</span></td>
                    <td class="px-4 py-3 text-right">
                        <button class="text-indigo-600 hover:text-indigo-900 text-sm mr-2" data-action="edit-role" data-id="${item.id}">Edit Roles</button>
                        <button class="text-red-600 hover:text-red-900 text-sm" data-action="delete-role" data-id="${item.id}">Remove</button>
                    </td>
                `;
            case 'roles':
                const perms = (item.permissions || []).slice(0, 3).map(p =>
                    `<span class="inline-flex items-center rounded px-1.5 py-0.5 text-xs bg-gray-100 text-gray-700 mr-1">${p}</span>`
                ).join('');
                return `
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">${item.name}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.description || '—'}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.usersCount || 0}</td>
                    <td class="px-4 py-3 text-sm">${perms}${(item.permissions || []).length > 3 ? `<span class="text-xs text-gray-400 ml-1">+${item.permissions.length - 3} more</span>` : ''}</td>
                    <td class="px-4 py-3 text-right">
                        <button class="text-indigo-600 hover:text-indigo-900 text-sm mr-2" data-action="edit-role-def" data-id="${item.id}">Edit</button>
                        <button class="text-red-600 hover:text-red-900 text-sm" data-action="delete-role-def" data-id="${item.id}">Delete</button>
                    </td>
                `;
            default:
                return '<td colspan="99" class="px-4 py-3 text-sm text-gray-400">Unknown entity</td>';
        }
    }

    // ============================================================
    // INTERCEPT FORM SUBMISSIONS (Add/Edit modals)
    // ============================================================
    function interceptForms() {
        // Add Department form
        const addDeptForms = document.querySelectorAll('form#addDepartmentForm, form[data-entity="departments"]');
        addDeptForms.forEach(form => {
            if (form.dataset.storeWired) return;
            form.dataset.storeWired = '1';
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const fd = new FormData(form);
                const data = {
                    code: fd.get('code') || 'DEP-' + String(STORE.count('departments') + 1).padStart(3, '0'),
                    name: fd.get('name'),
                    head: fd.get('head') || '—',
                    staffCount: parseInt(fd.get('staffCount') || '0', 10),
                    servicesCount: parseInt(fd.get('servicesCount') || '0', 10),
                    status: fd.get('status') || 'Active',
                    description: fd.get('description') || '',
                    icon: fd.get('icon') || 'department',
                };
                if (!data.name) {
                    Toast?.error('Department name is required.');
                    return;
                }
                STORE.create('departments', data);
                Toast?.success(`Department "${data.name}" created and synced to all pages.`);
                form.reset();
                // Close modal if open
                const modal = form.closest('.modal, [class*="modal"]');
                if (modal) modal.style.display = 'none';
            });
        });

        // Add Staff form
        const addStaffForms = document.querySelectorAll('form#addStaffForm, form[data-entity="staff"]');
        addStaffForms.forEach(form => {
            if (form.dataset.storeWired) return;
            form.dataset.storeWired = '1';
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const fd = new FormData(form);
                const firstName = fd.get('firstName') || fd.get('name') || '';
                const lastName = fd.get('lastName') || '';
                const fullName = `${firstName} ${lastName}`.trim() || firstName;
                const initials = fullName.split(' ').map(p => p[0]).join('').slice(0, 2).toUpperCase();
                const data = {
                    code: fd.get('code') || 'ST-' + String(STORE.count('staff') + 1).padStart(3, '0'),
                    name: fullName,
                    initials,
                    role: fd.get('role') || fd.get('position') || 'Staff',
                    department: fd.get('department') || '—',
                    email: fd.get('email') || '',
                    phone: fd.get('phone') || '',
                    joined: fd.get('joined') || new Date().toISOString().slice(0, 10),
                    status: fd.get('status') || 'Active',
                    ward: fd.get('ward') || '—',
                    wardPatients: 0,
                };
                if (!data.name) {
                    Toast?.error('Staff name is required.');
                    return;
                }
                STORE.create('staff', data);
                Toast?.success(`Staff "${data.name}" added and synced to all pages.`);
                form.reset();
                const modal = form.closest('.modal, [class*="modal"]');
                if (modal) modal.style.display = 'none';
            });
        });

        // Assign Role form
        const assignRoleForms = document.querySelectorAll('form#assignRoleForm, form[data-entity="roleAssignments"]');
        assignRoleForms.forEach(form => {
            if (form.dataset.storeWired) return;
            form.dataset.storeWired = '1';
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const fd = new FormData(form);
                const staffName = fd.get('staffName') || fd.get('name') || '';
                const rolesRaw = fd.get('roles') || fd.getAll('roles[]') || [];
                const roles = Array.isArray(rolesRaw) ? rolesRaw : String(rolesRaw).split(',').map(r => r.trim()).filter(Boolean);
                const data = {
                    staffName,
                    email: fd.get('email') || '',
                    department: fd.get('department') || '—',
                    roles,
                    assignedBy: (window.Meditrack?.getCurrentUser()?.name) || 'Admin',
                    lastUpdated: new Date().toISOString().slice(0, 10),
                    status: 'Active',
                };
                if (!data.staffName) {
                    Toast?.error('Staff name is required.');
                    return;
                }
                STORE.create('roleAssignments', data);
                Toast?.success(`Roles assigned to "${data.staffName}" and synced to all pages.`);
                form.reset();
                const modal = form.closest('.modal, [class*="modal"]');
                if (modal) modal.style.display = 'none';
            });
        });
    }

    // ============================================================
    // INTERCEPT DELETE BUTTONS (event delegation)
    // ============================================================
    function interceptDeleteButtons() {
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-action^="delete-"], [data-action^="remove-"]');
            if (!btn) return;
            e.preventDefault();
            const action = btn.getAttribute('data-action');
            const id = btn.getAttribute('data-id');
            if (!id) return;

            const entityMap = {
                'delete-dept': 'departments',
                'delete-staff': 'staff',
                'delete-role': 'roleAssignments',
                'delete-role-def': 'roles',
                'remove-role': 'roleAssignments',
                'remove-staff': 'staff',
                'remove-dept': 'departments',
            };
            const entity = entityMap[action];
            if (!entity) return;

            const item = STORE.get(entity, id);
            const name = item?.name || item?.staffName || `#${id}`;

            if (window.Meditrack?.confirm) {
                window.Meditrack.confirm(
                    `Are you sure you want to delete "${name}"? This action cannot be undone and will be reflected across all HMS pages.`,
                    () => {
                        STORE.delete(entity, id);
                        Toast?.success(`"${name}" deleted and synced to all pages.`);
                    },
                    { danger: true, title: 'Confirm Delete', okText: 'Delete' }
                );
            } else {
                if (confirm(`Delete "${name}"?`)) {
                    STORE.delete(entity, id);
                    Toast?.success(`"${name}" deleted.`);
                }
            }
        });
    }

    // ============================================================
    // INTERCEPT EDIT BUTTONS — pre-fill modal with store data
    // ============================================================
    function interceptEditButtons() {
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-action^="edit-"]');
            if (!btn) return;
            e.preventDefault();
            const action = btn.getAttribute('data-action');
            const id = btn.getAttribute('data-id');
            if (!id) return;

            const entityMap = {
                'edit-dept': 'departments',
                'edit-staff': 'staff',
                'edit-role': 'roleAssignments',
                'edit-role-def': 'roles',
            };
            const entity = entityMap[action];
            if (!entity) return;

            const item = STORE.get(entity, id);
            if (!item) {
                Toast?.error('Item not found in store.');
                return;
            }

            // Try to find an edit modal and pre-fill it
            const modal = document.querySelector('#editModal, .modal.show, [id*="edit"][id*="modal"]');
            if (modal) {
                modal.style.display = 'block';
                modal.classList.add('show');
                // Pre-fill inputs by name
                Object.keys(item).forEach(key => {
                    const input = modal.querySelector(`[name="${key}"]`);
                    if (input) input.value = item[key];
                });
                Toast?.info(`Editing "${item.name || item.staffName || 'item'}"`);
            } else {
                Toast?.info(`Edit form for "${item.name || item.staffName || 'item'}" — pre-filled from store.`);
            }
        });
    }

    // ============================================================
    // INIT
    // ============================================================
    function init() {
        // Find all tables and try to wire them
        const tables = document.querySelectorAll('table');
        let wiredCount = 0;
        tables.forEach(table => {
            const entity = detectEntityFromTable(table);
            if (entity) {
                renderTableFromStore(table, entity);
                wiredCount++;
            }
        });

        interceptForms();
        interceptDeleteButtons();
        interceptEditButtons();

        // Listen for store changes from other pages/tabs
        STORE.onChange((changedEntity) => {
            tables.forEach(table => {
                const entity = detectEntityFromTable(table);
                if (entity === changedEntity) {
                    renderTableFromStore(table, entity);
                }
            });
        });

        if (wiredCount > 0 && Toast) {
            console.log(`[AdminSync] Wired ${wiredCount} table(s) to MeditrackStore`);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})(window, document);

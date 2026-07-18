/**
 * Meditrack HMS — Clinical/Operational Pages Sync
 * ============================================================
 * Injected into: patients.html, appointments.html, billing.html, lab-results.html,
 *                medicine.html, prescriptions.html, inventory.html, suppliers.html,
 *                ambulance-list.html, ambulance-calls.html, blood-donors.html,
 *                blood-stock.html, radiology-list.html, ot-schedule.html,
 *                rooms-alloted.html, etc.
 *
 * Wires the primary table on each page to MeditrackStore so that
 * data entered on one page (e.g., add patient) appears on related
 * pages (appointments, invoices, lab results).
 */

(function(window, document) {
    'use strict';

    if (!window.MeditrackStore) return;
    const STORE = window.MeditrackStore;
    const Toast = window.Meditrack?.Toast;

    // ============================================================
    // PAGE → ENTITY MAPPING (based on current page filename)
    // ============================================================
    function getEntityForCurrentPage() {
        const page = (window.location.pathname.split('/').pop() || 'index.html').toLowerCase();
        const map = {
            'patients.html': 'patients',
            'patient-profile.html': 'patients',
            'add-patient.html': 'patients',
            'edit-patient.html': 'patients',
            'appointments.html': 'appointments',
            'add-appointment.html': 'appointments',
            'appointment-requests.html': 'appointments',
            'appointment-calendar.html': 'appointments',
            'billing.html': 'invoices',
            'create-invoice.html': 'invoices',
            'edit-invoice.html': 'invoices',
            'invoice.html': 'invoices',
            'lab-results.html': 'labResults',
            'result-entry.html': 'labResults',
            'test-requests.html': 'labResults',
            'prescriptions.html': 'prescriptions',
            'create-prescription.html': 'prescriptions',
            'patient-prescription.html': 'prescriptions',
            'medicine.html': 'medicines',
            'add-medicine.html': 'medicines',
            'inventory.html': 'inventory',
            'add-inventory.html': 'inventory',
            'suppliers.html': 'suppliers',
            'ambulance-list.html': 'ambulances',
            'add-ambulance.html': 'ambulances',
            'ambulance-calls.html': 'ambulanceCalls',
            'add-ambulance-call.html': 'ambulanceCalls',
            'blood-donors.html': 'bloodDonors',
            'blood-stock.html': 'bloodUnits',
            'radiology-list.html': 'radiologyOrders',
            'radiology-schedule.html': 'radiologyOrders',
            'radiology-details.html': 'radiologyOrders',
            'add-radiology.html': 'radiologyOrders',
            'ot-schedule.html': 'surgeries',
            'ot-dashboard.html': 'surgeries',
            'add-surgery.html': 'surgeries',
            'surgery-details.html': 'surgeries',
            'rooms-alloted.html': 'rooms',
            'room-allotment.html': 'rooms',
        };
        return map[page] || null;
    }

    // ============================================================
    // RENDER ROWS PER ENTITY
    // ============================================================
    function renderRow(entity, item) {
        const escape = (s) => String(s ?? '').replace(/[&<>"\']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
        const badge = (status, color = 'green') => `<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-${color}-100 text-${color}-700">${escape(status)}</span>`;
        const statusColor = (s) => ({
            'Active': 'green', 'Available': 'green', 'In Stock': 'green', 'Paid': 'green', 'Completed': 'green', 'Normal': 'green', 'Verified': 'green', 'Eligible': 'green', 'Final': 'green',
            'Pending': 'amber', 'Unpaid': 'amber', 'Draft': 'amber', 'Scheduled': 'amber', 'In Progress': 'amber',
            'Inactive': 'gray', 'Discharged': 'gray', 'Cancelled': 'gray', 'Expired': 'gray',
            'Critical': 'red', 'Out of Stock': 'red', 'Abnormal': 'red', 'High': 'red', 'Low': 'red',
            'On Call': 'blue', 'Confirmed': 'blue', 'En Route': 'blue',
            'Urgent': 'orange', 'Emergency': 'red',
        }[s] || 'gray');

        // 3-dot action menu button (original pattern)
        const actionBtn = (id, entity) => `<td class="px-4 py-3 text-right"><button class="action-menu-btn w-8 h-8 rounded-full hover:bg-gray-200 flex items-center justify-center ml-auto transition-colors" data-id="${id}" data-entity="${entity}"><svg class="h-4 w-4 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg></button></td>`;

        switch (entity) {
            case 'patients':
                return `<tr data-id="${item.id}">
                    <td class="px-4 py-3"><div class="flex items-center gap-3"><div class="h-9 w-9 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-semibold overflow-hidden"><img src="user.png" alt="User" style="width:100%;height:100%;object-fit:cover;border-radius:inherit"></div><div><div class="text-sm font-medium text-gray-900">${escape(item.name)}</div><div class="text-xs text-gray-500">${escape(item.code)}</div></div></div></td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.age || '\u2014'}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.gender)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.phone)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.condition || '\u2014')}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.doctor || '\u2014')}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.lastVisit || '\u2014'}</td>
                    <td class="px-4 py-3">${badge(item.status, statusColor(item.status))}</td>
                    ${actionBtn(item.id, 'patients')}
                </tr>`;
            case 'appointments':
                return `<tr data-id="${item.id}">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">${escape(item.patient)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.doctor)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.date}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.time}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.type)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.duration}</td>
                    <td class="px-4 py-3">${badge(item.status, statusColor(item.status))}</td>
                    ${actionBtn(item.id, 'appointments')}
                </tr>`;
            case 'invoices':
                const amountFmt = (n) => 'UGX ' + Number(n || 0).toLocaleString();
                return `<tr data-id="${escape(item.id)}">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">${escape(item.id)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.patient)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.date}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.dueDate}</td>
                    <td class="px-4 py-3 text-sm text-gray-900 font-medium">${amountFmt(item.amount)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${amountFmt(item.balance)}</td>
                    <td class="px-4 py-3">${badge(item.status, statusColor(item.status))}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.insuranceStatus || '\u2014')}</td>
                    ${actionBtn(escape(item.id), 'invoices')}
                </tr>`;
            case 'labResults':
                return `<tr data-id="${escape(item.id)}">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">${escape(item.id)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.patientName)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.testName)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.resultValue)} ${escape(item.unit || '')}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.normalRange)}</td>
                    <td class="px-4 py-3">${badge(item.flag, statusColor(item.flag))}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.resultDate}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.orderedBy)}</td>
                    ${actionBtn(escape(item.id), 'labResults')}
                </tr>`;
            case 'medicines':
                return `<tr data-id="${escape(item.id)}">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">${escape(item.name)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.generic)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.category)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.manufacturer)}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">UGX ${Number(item.sellingPrice).toLocaleString()}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.stock}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.expiry}</td>
                    <td class="px-4 py-3">${badge(item.status, statusColor(item.status))}</td>
                    ${actionBtn(escape(item.id), 'medicines')}
                </tr>`;
            case 'prescriptions':
                return `<tr data-id="${item.id}">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">#${item.id}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.patient)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.doctor)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.date}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.medications)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.refills}</td>
                    <td class="px-4 py-3">${badge(item.status, statusColor(item.status))}</td>
                    ${actionBtn(item.id, 'prescriptions')}
                </tr>`;
            case 'inventory':
                return `<tr data-id="${escape(item.id)}">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">${escape(item.name)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.category)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.stockCurrent}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.minLevel}</td>
                    <td class="px-4 py-3">${badge(item.status, statusColor(item.status))}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.lastUpdated}</td>
                    ${actionBtn(escape(item.id), 'inventory')}
                </tr>`;
            case 'suppliers':
                const rating = '\u2605'.repeat(item.rating || 0) + '\u2606'.repeat(5 - (item.rating || 0));
                return `<tr data-id="${escape(item.id)}">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">${escape(item.name)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.category)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.email)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.phone)}</td>
                    <td class="px-4 py-3 text-sm text-amber-500">${rating}</td>
                    <td class="px-4 py-3">${badge(item.status, statusColor(item.status))}</td>
                    ${actionBtn(escape(item.id), 'suppliers')}
                </tr>`;
            case 'ambulances':
                return `<tr data-id="${item.id}">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">${escape(item.regNo)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.model)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.year}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.type)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.driver)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.location)}</td>
                    <td class="px-4 py-3">${badge(item.status, statusColor(item.status))}</td>
                    ${actionBtn(item.id, 'ambulances')}
                </tr>`;
            case 'ambulanceCalls':
                return `<tr data-id="${escape(item.id)}">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">${escape(item.id)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.caller)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.patient)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.pickup)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.callTime}</td>
                    <td class="px-4 py-3">${badge(item.severity, statusColor(item.severity))}</td>
                    <td class="px-4 py-3">${badge(item.status, statusColor(item.status))}</td>
                    ${actionBtn(escape(item.id), 'ambulanceCalls')}
                </tr>`;
            case 'bloodDonors':
                return `<tr data-id="${escape(item.id)}">
                    <td class="px-4 py-3"><div class="flex items-center gap-3"><div class="h-9 w-9 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xs font-semibold overflow-hidden"><img src="user.png" alt="User" style="width:100%;height:100%;object-fit:cover;border-radius:inherit"></div><div class="text-sm font-medium text-gray-900">${escape(item.name)}</div></div></td>
                    <td class="px-4 py-3 text-sm text-red-600 font-semibold">${escape(item.bloodType)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.phone)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.lastDonation}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.totalDonations}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.donorTier)}</td>
                    <td class="px-4 py-3">${badge(item.status, statusColor(item.status))}</td>
                    ${actionBtn(escape(item.id), 'bloodDonors')}
                </tr>`;
            case 'bloodUnits':
                return `<tr data-id="${escape(item.id)}">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">${escape(item.id)}</td>
                    <td class="px-4 py-3 text-sm text-red-600 font-semibold">${escape(item.bloodType)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.units}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.collectionDate}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.expiryDate}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.location)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.donor)}</td>
                    <td class="px-4 py-3">${badge(item.status, statusColor(item.status))}</td>
                </tr>`;
            case 'radiologyOrders':
                return `<tr data-id="${escape(item.id)}">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">${escape(item.id)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.patient)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.modality)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.bodyPart)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.referringDoctor)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.orderDate}</td>
                    <td class="px-4 py-3">${badge(item.status, statusColor(item.status))}</td>
                    ${actionBtn(escape(item.id), 'radiologyOrders')}
                </tr>`;
            case 'surgeries':
                return `<tr data-id="${escape(item.id)}">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">${escape(item.id)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.patient)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.procedure)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.otRoom)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.surgeon)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.date}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.startTime}</td>
                    <td class="px-4 py-3">${badge(item.status, statusColor(item.status))}</td>
                    ${actionBtn(escape(item.id), 'surgeries')}
                </tr>`;
            case 'rooms':
                return `<tr data-id="${escape(item.id)}">
                    <td class="px-4 py-3 text-sm font-medium text-gray-900">${escape(item.id)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.patient)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.room)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.roomType)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.department)}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${item.allotmentDate}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">${escape(item.doctor)}</td>
                    <td class="px-4 py-3">${badge(item.status, statusColor(item.status))}</td>
                </tr>`;
            default:
                return '';
        }
    }

    function renderTableFromStore(table, entity) {
        const tbody = table.querySelector('tbody');
        if (!tbody) return;
        const items = STORE.list(entity);
        if (!items || !items.length) {
            tbody.innerHTML = `<tr><td colspan="99" class="text-center text-gray-400 py-8">No ${entity} yet. Add one to get started.</td></tr>`;
            return;
        }
        tbody.innerHTML = items.map(item => renderRow(entity, item)).join('');
    }

    // ============================================================
    // INTERCEPT FORMS — when Add forms submit, write to store
    // ============================================================
    function interceptForms(entity) {
        const forms = document.querySelectorAll('form[data-store-entity], form#addPatientForm, form#addAppointmentForm, form#addInvoiceForm, form#addLabResultForm, form#addMedicineForm, form#addPrescriptionForm, form#addInventoryForm, form#addSupplierForm, form#addAmbulanceForm, form#addAmbulanceCallForm, form#addBloodDonorForm, form#addBloodUnitForm, form#addRadiologyForm, form#addSurgeryForm, form#addRoomForm');
        forms.forEach(form => {
            if (form.dataset.storeWired) return;
            form.dataset.storeWired = '1';
            form.addEventListener('submit', (e) => {
                // Only intercept if form has no real backend (no method/action or data-no-backend)
                if (form.hasAttribute('method') && form.getAttribute('method').toLowerCase() === 'post' && form.hasAttribute('action')) {
                    return; // let it submit normally
                }
                e.preventDefault();
                const fd = new FormData(form);
                const data = {};
                for (const [k, v] of fd.entries()) {
                    data[k] = v;
                }
                // Auto-generate code/id if missing
                if (!data.code && !data.id) {
                    const prefix = (entity || '').replace(/([A-Z])/g, '_$1').toUpperCase().slice(0, 3);
                    data.code = `${prefix}-${String(STORE.count(entity) + 1).padStart(4, '0')}`;
                }
                // Build display name for patients/staff
                if (entity === 'patients' && data.firstName) {
                    data.name = `${data.firstName} ${data.lastName || ''}`.trim();
                }
                const created = STORE.create(entity, data);
                const label = data.name || data.code || data.id || 'item';
                Toast?.success(`${entity.replace(/([A-Z])/g, ' $1')} "${label}" created and synced across all HMS pages.`);
                form.reset();
                const modal = form.closest('.modal, [class*="modal"]');
                if (modal) modal.style.display = 'none';
            });
        });
    }

    // ============================================================
    // INTERCEPT DELETE BUTTONS
    // ============================================================
    function interceptDeletes(entity) {
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('[data-action^="delete-"], [data-action^="cancel-"]');
            if (!btn) return;
            const action = btn.getAttribute('data-action');
            if (!action.startsWith('delete') && !action.startsWith('cancel')) return;
            e.preventDefault();
            const id = btn.getAttribute('data-id');
            if (!id) return;
            const item = STORE.get(entity, id);
            const label = item?.name || item?.code || item?.id || `#${id}`;
            if (window.Meditrack?.confirm) {
                window.Meditrack.confirm(
                    `Are you sure you want to delete "${label}"? This will remove it from all HMS pages.`,
                    () => {
                        STORE.delete(entity, id);
                        Toast?.success(`"${label}" deleted and synced across all HMS pages.`);
                    },
                    { danger: true, title: 'Confirm Delete', okText: 'Delete' }
                );
            } else {
                if (confirm(`Delete "${label}"?`)) {
                    STORE.delete(entity, id);
                    Toast?.success(`"${label}" deleted.`);
                }
            }
        });
    }

    // ============================================================
    // INIT
    // ============================================================
    function init() {
        const entity = getEntityForCurrentPage();
        if (!entity) return;

        // Find the primary data table on the page
        const tables = document.querySelectorAll('table');
        let primaryTable = null;
        tables.forEach(t => {
            if (t.querySelector('thead') && t.querySelectorAll('tbody tr').length > 0) {
                if (!primaryTable) primaryTable = t;
            }
        });

        if (primaryTable) {
            renderTableFromStore(primaryTable, entity);
            interceptForms(entity);
            interceptDeletes(entity);

            // Listen for store changes
            STORE.onChange((changedEntity) => {
                if (changedEntity === entity) {
                    renderTableFromStore(primaryTable, entity);
                }
            });
            console.log(`[ClinicalSync] Wired ${entity} table to MeditrackStore`);
        } else {
            // Even if no table, intercept any forms (e.g., add-patient.html)
            interceptForms(entity);
            interceptDeletes(entity);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})(window, document);

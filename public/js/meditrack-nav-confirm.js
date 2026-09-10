/**
 * Meditrack HMS — Navigation Button Confirmation Module
 * ============================================================
 * Wires every "Cancel", "Back", "Return", "Redo" button across the
 * entire HMS to open a confirmation popover/modal BEFORE navigating.
 *
 * Preserves the EXISTING modal styling (modal-overlay, modal-container,
 * alert-dialog classes) so the UI looks identical to current popovers.
 *
 * Behavior:
 *   1. User clicks Cancel/Back/Return/Redo
 *   2. Confirmation popover opens: "Are you sure you want to leave?
 *      Unsaved changes will be lost."
 *   3. User clicks "Confirm" → navigates to the correct page
 *   4. User clicks "Stay" → popover closes, no navigation
 *
 * Smart detection:
 *   - If the page has a form with unsaved changes, shows stronger warning
 *   - If the button has data-target, navigates to that URL
 *   - If no data-target, uses history.back() for "Back" buttons,
 *     closes the parent modal for "Cancel" buttons
 *   - "Redo" buttons reset the form to its initial state
 *
 * Buttons are auto-detected by text content (Cancel, Back, Return, Redo)
 * and by class (btn-cancel, btn-back, btn-return, btn-redo) and by
 * data-action="cancel|back|return|redo".
 */

(function(window, document) {
    'use strict';

    if (!window.Meditrack) {
        console.warn('[NavConfirm] Meditrack not loaded');
        return;
    }

    const Toast = window.Meditrack.Toast;

    // ============================================================
    // CONFIG
    // ============================================================
    const BUTTON_LABELS = ['cancel', 'back', 'return', 'redo', 'close'];
    const BUTTON_CLASSES = ['btn-cancel', 'btn-back', 'btn-return', 'btn-redo', 'btn-close'];
    const BUTTON_ACTIONS = ['cancel', 'back', 'return', 'redo'];

    // Pages where "Back" should go to a specific parent page (not history.back)
    const BACK_PAGE_MAP = {
        'patient-profile.html': 'patients.html',
        'edit-patient.html': 'patients.html',
        'add-patient.html': 'patients.html',
        'appointment-details.html': 'appointments.html',
        'edit-appointment.html': 'appointments.html',
        'add-appointment.html': 'appointments.html',
        'invoice.html': 'billing.html',
        'edit-invoice.html': 'billing.html',
        'create-invoice.html': 'billing.html',
        'lab-results.html': 'lab-dashboard.html',
        'result-entry.html': 'lab-results.html',
        'edit-medicine.html': 'medicine.html',
        'add-medicine.html': 'medicine.html',
        'medicine-details.html': 'medicine.html',
        'edit-inventory.html': 'inventory.html',
        'add-inventory.html': 'inventory.html',
        'inventory-details.html': 'inventory.html',
        'edit-supplier.html': 'suppliers.html',
        'add-supplier.html': 'suppliers.html',
        'supplier-details.html': 'suppliers.html',
        'edit-doctor.html': 'doctors.html',
        'add-doctor.html': 'doctors.html',
        'doctor-profile.html': 'doctors.html',
        'edit-staff-profile.html': 'staff-management.html',
        'add-staff.html': 'staff-management.html',
        'staff-profile.html': 'staff-management.html',
        'edit-department.html': 'departments.html',
        'add-department.html': 'departments.html',
        'department-details.html': 'departments.html',
        'edit-claim.html': 'insurance-claims.html',
        'add-claim.html': 'insurance-claims.html',
        'claim-details.html': 'insurance-claims.html',
        'edit-radiology.html': 'radiology-list.html',
        'add-radiology.html': 'radiology-list.html',
        'radiology-details.html': 'radiology-list.html',
        'edit-surgery.html': 'ot-schedule.html',
        'add-surgery.html': 'ot-schedule.html',
        'surgery-details.html': 'ot-schedule.html',
        'edit-room.html': 'rooms-alloted.html',
        'add-room.html': 'rooms-alloted.html',
        'room-details.html': 'rooms-alloted.html',
        'edit-room-allotment.html': 'rooms-alloted.html',
        'room-allotment.html': 'rooms-alloted.html',
        'edit-donor.html': 'blood-donors.html',
        'donor-details.html': 'blood-donors.html',
        'add-blood-unit.html': 'blood-stock.html',
        'update-blood-unit.html': 'blood-stock.html',
        'blood-unit-details.html': 'blood-stock.html',
        'edit-ambulance-details.html': 'ambulance-list.html',
        'add-ambulance.html': 'ambulance-list.html',
        'ambulance-details.html': 'ambulance-list.html',
        'edit-ambulance-call.html': 'ambulance-calls.html',
        'add-ambulance-call.html': 'ambulance-calls.html',
        'ambulance-calls-details.html': 'ambulance-calls.html',
        'edit-birth-records.html': 'birth-records.html',
        'add-birth-records.html': 'birth-records.html',
        'birth-records-details.html': 'birth-records.html',
        'edit-death-records.html': 'death-records.html',
        'add-death-records.html': 'death-records.html',
        'death-records-details.html': 'death-records.html',
        'edit-prescription.html': 'prescriptions.html',
        'create-prescription.html': 'prescriptions.html',
        'prescriptions-details.html': 'prescriptions.html',
        'renew-prescription.html': 'prescriptions.html',
        'edit-vaccination.html': 'vaccination.html',
        'add-vaccination.html': 'vaccination.html',
        'edit-physiotherapy-session.html': 'physiotherapy-schedule.html',
        'add-physiotherapy-session.html': 'physiotherapy-schedule.html',
        'edit-transfer.html': 'transfers.html',
        'add-transfer.html': 'transfers.html',
        'transfer-details.html': 'transfers.html',
        'edit-payslip.html': 'payroll.html',
        'create-payslip.html': 'payroll.html',
        'payslip.html': 'payroll.html',
        'edit-services.html': 'services.html',
        'add-services.html': 'services.html',
        'service-details.html': 'services.html',
        'edit-specialisation.html': 'specialisation.html',
        'edit-survey.html': 'feedback.html',
        'create-survey.html': 'feedback.html',
        'survey-details.html': 'feedback.html',
        'edit-template.html': 'medicine-templates.html',
        'template-details.html': 'medicine-templates.html',
        'role-details.html': 'roles-permissions.html',
        'role-users.html': 'roles-permissions.html',
        'edit-admin-role.html': 'roles-permissions.html',
        'profile-setting.html': 'index.html',
        'profile-activity.html': 'profile-setting.html',
        'settings-notifications.html': 'settings.html',
        'birth-certificate.html': 'birth-records.html',
    };

    // ============================================================
    // DETECT IF A BUTTON IS A NAVIGATION BUTTON
    // ============================================================
    function isNavButton(el) {
        if (!el || el.tagName !== 'BUTTON' && el.tagName !== 'A') return false;
        const text = (el.textContent || '').trim().toLowerCase();
        const className = (el.className || '').toLowerCase();
        const action = (el.getAttribute('data-action') || '').toLowerCase();

        // Check text content
        if (BUTTON_LABELS.some(label => text === label || text.startsWith(label + ' '))) {
            return true;
        }
        // Check class
        if (BUTTON_CLASSES.some(cls => className.includes(cls))) {
            return true;
        }
        // Check data-action
        if (BUTTON_ACTIONS.includes(action)) {
            return true;
        }
        return false;
    }

    // ============================================================
    // DETECT BUTTON TYPE (cancel vs back vs redo)
    // ============================================================
    function getButtonType(el) {
        const text = (el.textContent || '').trim().toLowerCase();
        const className = (el.className || '').toLowerCase();
        const action = (el.getAttribute('data-action') || '').toLowerCase();

        if (text.includes('redo') || className.includes('btn-redo') || action === 'redo') return 'redo';
        if (text.includes('back') || className.includes('btn-back') || action === 'back') return 'back';
        if (text.includes('return') || className.includes('btn-return') || action === 'return') return 'return';
        return 'cancel';
    }

    // ============================================================
    // DETECT UNSAVED CHANGES
    // ============================================================
    function hasUnsavedChanges() {
        const forms = document.querySelectorAll('form');
        for (const form of forms) {
            // Skip search forms
            if (form.getAttribute('role') === 'search') continue;
            // Skip forms with data-no-confirm
            if (form.hasAttribute('data-no-confirm')) continue;
            // Check if any input has been modified
            const inputs = form.querySelectorAll('input, textarea, select');
            for (const input of inputs) {
                if (input.type === 'button' || input.type === 'submit' || input.type === 'reset') continue;
                if (input.type === 'hidden') continue;
                // Compare current value to default
                if (input.value !== input.defaultValue && input.value !== '') {
                    return true;
                }
                // Check checkboxes/radios
                if ((input.type === 'checkbox' || input.type === 'radio') && input.checked !== input.defaultChecked) {
                    return true;
                }
            }
        }
        return false;
    }

    // ============================================================
    // GET TARGET URL FOR NAVIGATION
    // ============================================================
    function getTargetUrl(button, type) {
        // 1. Explicit data-target attribute
        const dataTarget = button.getAttribute('data-target') || button.getAttribute('data-href');
        if (dataTarget && dataTarget !== '#' && !dataTarget.startsWith('javascript')) {
            return dataTarget;
        }

        // 2. If it's an <a> with href
        if (button.tagName === 'A' && button.getAttribute('href')) {
            const href = button.getAttribute('href');
            if (href && href !== '#' && !href.startsWith('javascript')) return href;
        }

        // 3. If button has onclick with window.location.href
        const onclick = button.getAttribute('onclick') || '';
        const locMatch = onclick.match(/(?:window\.)?location\.href\s*=\s*['"]([^'"]+)['"]/);
        if (locMatch) return locMatch[1];

        // 4. Map based on current page
        const currentPage = (window.location.pathname.split('/').pop() || 'index.html').toLowerCase();
        if (BACK_PAGE_MAP[currentPage]) {
            return BACK_PAGE_MAP[currentPage];
        }

        // 5. Fall back to history.back() for "back" type
        if (type === 'back' || type === 'return') {
            return null; // signals history.back()
        }

        // 6. Default to dashboard
        return 'index.html';
    }

    // ============================================================
    // BUILD CONFIRMATION POPOVER (uses existing modal styling)
    // ============================================================
    function showConfirmPopover(options) {
        const {
            title = 'Confirm Navigation',
            message = 'Are you sure you want to leave this page?',
            details = '',
            confirmText = 'Confirm',
            cancelText = 'Stay',
            danger = false,
            onConfirm = () => {},
            onCancel = () => {},
        } = options;

        // Remove any existing nav-confirm modal
        const existing = document.getElementById('meditrackNavConfirmModal');
        if (existing) existing.remove();

        // Build modal using EXISTING modal-overlay / modal-container classes
        // so it inherits current styling
        const modal = document.createElement('div');
        modal.id = 'meditrackNavConfirmModal';
        modal.className = 'modal-overlay';
        modal.style.cssText = 'display: flex; align-items: center; justify-content: center; z-index: 99999;';

        modal.innerHTML = `
            <div class="modal-container" style="max-width: 440px; width: 90%; animation: modalFadeIn 0.2s ease-out;">
                <div class="modal-header">
                    <h2 class="modal-title" style="display: flex; align-items: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: ${danger ? '#ef4444' : '#f59e0b'};">
                            <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                            <line x1="12" y1="9" x2="12" y2="13"/>
                            <line x1="12" y1="17" x2="12.01" y2="17"/>
                        </svg>
                        ${title}
                    </h2>
                    <button class="modal-close" data-action="close-nav-modal" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #6b7280;">&times;</button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <p style="color: #374151; margin-bottom: 8px; font-size: 14px;">${message}</p>
                    ${details ? `<p style="color: #6b7280; font-size: 13px; margin-bottom: 12px;">${details}</p>` : ''}
                </div>
                <div class="modal-footer" style="display: flex; justify-content: flex-end; gap: 8px; padding: 16px 20px; border-top: 1px solid #e5e7eb;">
                    <button type="button" class="border border-gray-300 px-4 py-2 rounded-md text-sm hover:bg-gray-100" data-action="stay-nav-modal" style="cursor: pointer;">
                        ${cancelText}
                    </button>
                    <button type="button" class="${danger ? 'bg-red-600 hover:bg-red-700' : 'bg-primary hover:bg-primary/90'} text-white px-4 py-2 rounded-md text-sm" data-action="confirm-nav-modal" style="cursor: pointer; background: ${danger ? '#ef4444' : '#4f46e5'}; color: white; border: none;">
                        ${confirmText}
                    </button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Wire buttons
        const closeBtn = modal.querySelector('[data-action="close-nav-modal"]');
        const stayBtn = modal.querySelector('[data-action="stay-nav-modal"]');
        const confirmBtn = modal.querySelector('[data-action="confirm-nav-modal"]');

        const closeModal = () => {
            modal.style.animation = 'modalFadeOut 0.15s ease-out';
            setTimeout(() => modal.remove(), 150);
            onCancel();
        };

        closeBtn.addEventListener('click', closeModal);
        stayBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        // ESC to close
        const escHandler = (e) => {
            if (e.key === 'Escape') {
                closeModal();
                document.removeEventListener('keydown', escHandler);
            }
        };
        document.addEventListener('keydown', escHandler);

        confirmBtn.addEventListener('click', () => {
            modal.remove();
            document.removeEventListener('keydown', escHandler);
            onConfirm();
        });

        // Focus the stay button by default (safer default)
        setTimeout(() => stayBtn.focus(), 100);
    }

    // ============================================================
    // HANDLE BUTTON CLICK
    // ============================================================
    function handleButtonClick(button, event) {
        const type = getButtonType(button);
        const unsaved = hasUnsavedChanges();
        const targetUrl = getTargetUrl(button, type);

        // If inside a modal and it's a Cancel/Close, just close the modal (no confirmation needed)
        const parentModal = button.closest('.modal-overlay, .modal-container, .alert-dialog-overlay, [role="dialog"], [role="alertdialog"]');
        if (parentModal && (type === 'cancel' || type === 'back')) {
            // Check if this is a form modal with unsaved changes
            const form = parentModal.querySelector('form');
            if (form && hasUnsavedChanges.call({ forms: [form] }) === false) {
                // No unsaved changes — just close
                parentModal.style.display = 'none';
                parentModal.classList.remove('show', 'active');
                return;
            }
        }

        // For "Redo" — confirm reset
        if (type === 'redo') {
            showConfirmPopover({
                title: 'Reset Form',
                message: 'Are you sure you want to reset all changes? This will clear the form and start over.',
                details: 'All unsaved data will be lost.',
                confirmText: 'Reset Form',
                cancelText: 'Keep Changes',
                danger: true,
                onConfirm: () => {
                    // Reset all forms on the page
                    document.querySelectorAll('form').forEach(f => {
                        if (!f.hasAttribute('data-no-reset')) f.reset();
                    });
                    Toast?.success('Form reset to initial state.');
                },
            });
            return;
        }

        // For Cancel/Back/Return — confirm navigation
        const messages = {
            cancel: {
                title: 'Cancel and Leave?',
                message: unsaved
                    ? 'You have unsaved changes. Are you sure you want to cancel and leave this page?'
                    : 'Are you sure you want to cancel and leave this page?',
                details: unsaved ? 'All unsaved data will be lost.' : '',
                confirmText: 'Yes, Leave',
                cancelText: 'Stay',
                danger: unsaved,
            },
            back: {
                title: 'Go Back?',
                message: unsaved
                    ? 'You have unsaved changes. Going back will lose them.'
                    : 'Are you sure you want to go back?',
                details: unsaved ? 'All unsaved data will be lost.' : '',
                confirmText: 'Go Back',
                cancelText: 'Stay',
                danger: unsaved,
            },
            return: {
                title: 'Return to Previous Page?',
                message: unsaved
                    ? 'You have unsaved changes. Returning will lose them.'
                    : 'Are you sure you want to return to the previous page?',
                details: unsaved ? 'All unsaved data will be lost.' : '',
                confirmText: 'Return',
                cancelText: 'Stay',
                danger: unsaved,
            },
        };

        const cfg = messages[type] || messages.cancel;

        showConfirmPopover({
            ...cfg,
            onConfirm: () => {
                // Execute navigation
                if (targetUrl) {
                    // Add a small toast for feedback
                    Toast?.info('Navigating...');
                    setTimeout(() => {
                        window.location.href = targetUrl;
                    }, 200);
                } else if (type === 'back' || type === 'return') {
                    // Use history.back()
                    Toast?.info('Going back...');
                    setTimeout(() => {
                        if (window.history.length > 1) {
                            window.history.back();
                        } else {
                            window.location.href = 'index.html';
                        }
                    }, 200);
                } else {
                    // Close parent modal if inside one
                    if (parentModal) {
                        parentModal.style.display = 'none';
                        parentModal.classList.remove('show', 'active');
                        Toast?.info('Closed.');
                    } else {
                        window.location.href = 'index.html';
                    }
                }
            },
        });
    }

    // ============================================================
    // WIRE ALL NAVIGATION BUTTONS
    // ============================================================
    function wireNavButtons() {
        // Find all buttons and links
        const candidates = document.querySelectorAll('button, a');
        let wiredCount = 0;

        candidates.forEach(el => {
            if (el.dataset.navWired) return;
            if (!isNavButton(el)) return;

            // Skip buttons inside the nav-confirm modal itself
            if (el.closest('#meditrackNavConfirmModal')) return;

            // Skip buttons that are part of pagination or search controls
            if (el.closest('.meditrack-pagination, .search-clear-btn')) return;

            // Skip submit buttons (they should submit, not navigate)
            if (el.type === 'submit') return;

            el.dataset.navWired = '1';

            // Determine the button type for icon injection (if no icon present)
            const type = getButtonType(el);
            const hasIcon = el.querySelector('svg, img');
            if (!hasIcon && !el.textContent.trim()) {
                // Empty button — skip
                return;
            }

            // Add appropriate icon if missing (matches existing button styles)
            if (!hasIcon) {
                const icons = {
                    cancel: '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 4px;"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>',
                    back: '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 4px;"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>',
                    return: '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 4px;"><polyline points="9 14 4 9 9 4"/><path d="M20 20v-7a4 4 0 0 0-4-4H4"/></svg>',
                    redo: '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: inline-block; vertical-align: middle; margin-right: 4px;"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"/></svg>',
                };
                const text = el.textContent;
                el.innerHTML = icons[type] + '<span>' + text + '</span>';
            }

            // Intercept click
            el.addEventListener('click', (e) => {
                // Don't intercept if modifier keys (allow cmd+click etc.)
                if (e.metaKey || e.ctrlKey || e.shiftKey) return;

                e.preventDefault();
                e.stopPropagation();
                handleButtonClick(el, e);
            }, true); // capture phase to intercept before other handlers

            wiredCount++;
        });

        if (wiredCount > 0) {
            console.log(`[NavConfirm] Wired ${wiredCount} navigation button(s)`);
        }
    }

    // ============================================================
    // INJECT MODAL ANIMATION CSS (if not present)
    // ============================================================
    function injectAnimationStyles() {
        if (document.getElementById('meditrack-nav-confirm-styles')) return;
        const style = document.createElement('style');
        style.id = 'meditrack-nav-confirm-styles';
        style.textContent = `
            @keyframes modalFadeIn {
                from { opacity: 0; transform: translateY(-10px) scale(0.97); }
                to { opacity: 1; transform: translateY(0) scale(1); }
            }
            @keyframes modalFadeOut {
                from { opacity: 1; transform: translateY(0) scale(1); }
                to { opacity: 0; transform: translateY(-10px) scale(0.97); }
            }
            #meditrackNavConfirmModal .modal-container {
                animation: modalFadeIn 0.2s ease-out;
            }
            #meditrackNavConfirmModal .modal-overlay {
                background: rgba(0, 0, 0, 0.5);
            }
        `;
        document.head.appendChild(style);
    }

    // ============================================================
    // INIT
    // ============================================================
    function init() {
        injectAnimationStyles();
        wireNavButtons();

        // Re-wire after dynamic content renders (modals, etc.)
        setTimeout(wireNavButtons, 1000);
        setTimeout(wireNavButtons, 2500);

        // Watch for new buttons added to the DOM
        const observer = new MutationObserver((mutations) => {
            let shouldRewire = false;
            mutations.forEach(m => {
                if (m.addedNodes.length > 0) {
                    m.addedNodes.forEach(node => {
                        if (node.nodeType === 1) {
                            if (node.tagName === 'BUTTON' || node.tagName === 'A' || node.querySelector?.('button, a')) {
                                shouldRewire = true;
                            }
                        }
                    });
                }
            });
            if (shouldRewire) {
                clearTimeout(window._navConfirmRewireTimer);
                window._navConfirmRewireTimer = setTimeout(wireNavButtons, 200);
            }
        });
        observer.observe(document.body, { childList: true, subtree: true });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expose for manual triggering
    window.MeditrackNavConfirm = {
        wire: wireNavButtons,
        showConfirm: showConfirmPopover,
        hasUnsavedChanges,
    };

})(window, document);

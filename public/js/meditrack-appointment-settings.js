/**
 * Meditrack HMS — Appointment Settings Controller
 * ============================================================
 * Wires the Appointment Settings section in settings.html to:
 *   - Save settings to localStorage (meditrack_appointment_settings)
 *   - Be read by appointments.html, add-appointment.html, etc.
 *   - Control: online booking, approval required, reminders,
 *     reminder time, buffer time between appointments
 *
 * When settings are saved, all appointment pages read them and
 * adjust their behavior accordingly.
 */

(function(window, document) {
    'use strict';

    const STORAGE_KEY = 'meditrack_appointment_settings';

    const DEFAULT_SETTINGS = {
        onlineBooking: true,
        requireApproval: false,
        sendReminders: true,
        reminderTime: '24 hours before',
        bufferTime: '15 minutes',
        updatedAt: null,
    };

    // ============================================================
    // GET / SAVE SETTINGS
    // ============================================================
    function getSettings() {
        try {
            return { ...DEFAULT_SETTINGS, ...JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}') };
        } catch (e) { return { ...DEFAULT_SETTINGS }; }
    }

    function saveSettings(settings) {
        settings.updatedAt = new Date().toISOString();
        localStorage.setItem(STORAGE_KEY, JSON.stringify(settings));
        window.dispatchEvent(new CustomEvent('meditrack-appointment-settings-changed', { detail: settings }));
        if (window.Meditrack?.Toast) {
            window.Meditrack.Toast.success('Appointment settings saved — applied system-wide.');
        }
    }

    // ============================================================
    // WIRE SETTINGS UI (on settings.html)
    // ============================================================
    function wireSettingsUI() {
        const onlineBookingSwitch = document.getElementById('onlineBookingSwitch');
        const requireApprovalSwitch = document.getElementById('requireApprovalSwitch');
        const sendRemindersSwitch = document.getElementById('sendRemindersSwitch');
        const saveBtn = document.getElementById('saveAppointmentSettingsBtn');
        const cancelBtn = document.getElementById('cancelAppointmentSettingsBtn');

        if (!saveBtn) return; // Not on settings.html or section not rendered

        const settings = getSettings();

        // Set initial switch states
        if (onlineBookingSwitch) {
            onlineBookingSwitch.setAttribute('data-state', settings.onlineBooking ? 'checked' : 'unchecked');
            onlineBookingSwitch.addEventListener('click', () => {
                const newState = onlineBookingSwitch.getAttribute('data-state') !== 'checked';
                onlineBookingSwitch.setAttribute('data-state', newState ? 'checked' : 'unchecked');
                const thumb = onlineBookingSwitch.querySelector('.switch-thumb');
                if (thumb) thumb.setAttribute('data-state', newState ? 'checked' : 'unchecked');
            });
        }

        if (requireApprovalSwitch) {
            requireApprovalSwitch.setAttribute('data-state', settings.requireApproval ? 'checked' : 'unchecked');
            requireApprovalSwitch.addEventListener('click', () => {
                const newState = requireApprovalSwitch.getAttribute('data-state') !== 'checked';
                requireApprovalSwitch.setAttribute('data-state', newState ? 'checked' : 'unchecked');
                const thumb = requireApprovalSwitch.querySelector('.switch-thumb');
                if (thumb) thumb.setAttribute('data-state', newState ? 'checked' : 'unchecked');
            });
        }

        if (sendRemindersSwitch) {
            sendRemindersSwitch.setAttribute('data-state', settings.sendReminders ? 'checked' : 'unchecked');
            sendRemindersSwitch.addEventListener('click', () => {
                const newState = sendRemindersSwitch.getAttribute('data-state') !== 'checked';
                sendRemindersSwitch.setAttribute('data-state', newState ? 'checked' : 'unchecked');
                const thumb = sendRemindersSwitch.querySelector('.switch-thumb');
                if (thumb) thumb.setAttribute('data-state', newState ? 'checked' : 'unchecked');
            });
        }

        // Wire reminder time dropdown
        const reminderTimeBtn = document.getElementById('reminderTimeBtn');
        const reminderTimeDropdown = document.getElementById('reminderTimeDropdown');
        const reminderTimeSelected = document.getElementById('reminderTimeSelected');
        if (reminderTimeBtn && reminderTimeDropdown) {
            reminderTimeSelected.textContent = settings.reminderTime;
            reminderTimeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                reminderTimeDropdown.classList.toggle('hidden');
            });
            reminderTimeDropdown.querySelectorAll('.select-item').forEach(item => {
                item.addEventListener('click', () => {
                    reminderTimeSelected.textContent = item.textContent.trim();
                    reminderTimeDropdown.classList.add('hidden');
                });
            });
        }

        // Wire buffer time dropdown
        const bufferTimeBtn = document.getElementById('bufferTimeBtn');
        const bufferTimeDropdown = document.getElementById('bufferTimeDropdown');
        const bufferTimeSelected = document.getElementById('bufferTimeSelected');
        if (bufferTimeBtn && bufferTimeDropdown) {
            bufferTimeSelected.textContent = settings.bufferTime;
            bufferTimeBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                bufferTimeDropdown.classList.toggle('hidden');
            });
            bufferTimeDropdown.querySelectorAll('.select-item').forEach(item => {
                item.addEventListener('click', () => {
                    bufferTimeSelected.textContent = item.textContent.trim();
                    bufferTimeDropdown.classList.add('hidden');
                });
            });
        }

        // Wire save button
        saveBtn.addEventListener('click', () => {
            const newSettings = {
                onlineBooking: onlineBookingSwitch?.getAttribute('data-state') === 'checked',
                requireApproval: requireApprovalSwitch?.getAttribute('data-state') === 'checked',
                sendReminders: sendRemindersSwitch?.getAttribute('data-state') === 'checked',
                reminderTime: reminderTimeSelected?.textContent || settings.reminderTime,
                bufferTime: bufferTimeSelected?.textContent || settings.bufferTime,
            };
            saveSettings(newSettings);
        });

        // Wire cancel button
        if (cancelBtn) {
            cancelBtn.addEventListener('click', () => {
                // Reset to saved settings
                if (onlineBookingSwitch) onlineBookingSwitch.setAttribute('data-state', settings.onlineBooking ? 'checked' : 'unchecked');
                if (requireApprovalSwitch) requireApprovalSwitch.setAttribute('data-state', settings.requireApproval ? 'checked' : 'unchecked');
                if (sendRemindersSwitch) sendRemindersSwitch.setAttribute('data-state', settings.sendReminders ? 'checked' : 'unchecked');
                if (reminderTimeSelected) reminderTimeSelected.textContent = settings.reminderTime;
                if (bufferTimeSelected) bufferTimeSelected.textContent = settings.bufferTime;
                if (window.Meditrack?.Toast) window.Meditrack.Toast.info('Changes discarded.');
            });
        }

        // Close dropdowns on outside click
        document.addEventListener('click', (e) => {
            if (reminderTimeDropdown && !reminderTimeBtn?.contains(e.target) && !reminderTimeDropdown.contains(e.target)) {
                reminderTimeDropdown.classList.add('hidden');
            }
            if (bufferTimeDropdown && !bufferTimeBtn?.contains(e.target) && !bufferTimeDropdown.contains(e.target)) {
                bufferTimeDropdown.classList.add('hidden');
            }
        });

        console.log('[AppointmentSettings] Wired settings UI on settings.html');
    }

    // ============================================================
    // APPLY SETTINGS ON APPOINTMENT PAGES
    // ============================================================
    function applySettingsOnAppointmentPages() {
        const page = (window.location.pathname.split('/').pop() || '').toLowerCase();
        if (!['appointments.html', 'add-appointment.html', 'appointment-requests.html', 'appointment-calendar.html'].includes(page)) return;

        const settings = getSettings();

        // Show/hide online booking notice
        if (page === 'add-appointment.html' && !settings.onlineBooking) {
            const banner = document.createElement('div');
            banner.style.cssText = 'background: #fef3c7; border: 1px solid #fcd34d; color: #92400e; padding: 10px 16px; border-radius: 6px; margin: 16px; font-size: 13px;';
            banner.textContent = '⚠ Online booking is currently disabled. New appointments can still be created by staff.';
            const main = document.querySelector('main, .main, [class*="main"]');
            if (main) main.insertBefore(banner, main.firstChild);
        }

        // Show approval required notice
        if (page === 'appointment-requests.html' && settings.requireApproval) {
            const banner = document.createElement('div');
            banner.style.cssText = 'background: #dbeafe; border: 1px solid #93c5fd; color: #1e40af; padding: 10px 16px; border-radius: 6px; margin: 16px; font-size: 13px;';
            banner.textContent = 'ℹ All online bookings require admin approval before confirmation.';
            const main = document.querySelector('main, .main, [class*="main"]');
            if (main) main.insertBefore(banner, main.firstChild);
        }

        // Add buffer time notice on add-appointment
        if (page === 'add-appointment.html' && settings.bufferTime !== '0 minutes') {
            // Could add validation here to prevent booking too close to another appointment
            console.log('[AppointmentSettings] Buffer time:', settings.bufferTime);
        }
    }

    // ============================================================
    // EXPOSE
    // ============================================================
    window.MeditrackAppointmentSettings = {
        get: getSettings,
        save: saveSettings,
    };

    if (window.Meditrack) {
        window.Meditrack.AppointmentSettings = window.MeditrackAppointmentSettings;
    }

    // ============================================================
    // INIT
    // ============================================================
    function init() {
        wireSettingsUI();
        applySettingsOnAppointmentPages();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    setTimeout(init, 1000);
    setTimeout(init, 2500);

})(window, document);

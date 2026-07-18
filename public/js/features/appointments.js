// js/features/appointments.js
// Centralized Appointment Management Module
// Handles appointments CRUD, settings sync, and shared utilities

(function() {
    'use strict';

    // ==================== STORAGE KEYS ====================
    const STORAGE_KEYS = {
        APPOINTMENTS: 'meditrack_appointments',
        REQUESTS: 'meditrack_appointment_requests',
        SETTINGS: 'meditrack_appointment_settings'
    };

    // ==================== DEFAULT SETTINGS ====================
    const DEFAULT_SETTINGS = {
        online_booking: true,
        require_approval: false,
        send_reminders: true,
        reminder_time: '24 hours before',
        buffer_time: '15 minutes',
        default_duration: '30',
        slot_duration: '30',
        show_weekends: true,
        calendar_view: 'month'
    };

    // ==================== HELPER FUNCTIONS ====================
    
    function showToast(message, isError = false) {
        const existing = document.querySelector('.toast-message');
        if (existing) existing.remove();
        const toast = document.createElement('div');
        toast.className = `toast-message ${isError ? 'error' : ''}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // ==================== SETTINGS MANAGEMENT ====================
    
    function getSettings() {
        const stored = localStorage.getItem(STORAGE_KEYS.SETTINGS);
        if (stored) {
            return { ...DEFAULT_SETTINGS, ...JSON.parse(stored) };
        }
        return { ...DEFAULT_SETTINGS };
    }

    function saveSettings(settings) {
        localStorage.setItem(STORAGE_KEYS.SETTINGS, JSON.stringify(settings));
        // Dispatch event for other components to react
        window.dispatchEvent(new CustomEvent('appointmentSettingsChanged', { detail: settings }));
        return settings;
    }

    function updateSetting(key, value) {
        const settings = getSettings();
        settings[key] = value;
        saveSettings(settings);
        return settings;
    }

    // ==================== APPOINTMENT CRUD ====================
    
    function getAppointments() {
        const stored = localStorage.getItem(STORAGE_KEYS.APPOINTMENTS);
        return stored ? JSON.parse(stored) : [];
    }

    function saveAppointments(appointments) {
        localStorage.setItem(STORAGE_KEYS.APPOINTMENTS, JSON.stringify(appointments));
        window.dispatchEvent(new CustomEvent('appointmentsChanged', { detail: appointments }));
    }

    function getAppointmentById(id) {
        const appointments = getAppointments();
        return appointments.find(a => a.id == id);
    }

    function addAppointment(appointment) {
        const appointments = getAppointments();
        const newId = appointments.length > 0 ? Math.max(...appointments.map(a => a.id)) + 1 : 1;
        const newAppointment = { ...appointment, id: newId, createdAt: new Date().toISOString() };
        appointments.push(newAppointment);
        saveAppointments(appointments);
        return newAppointment;
    }

    function updateAppointment(id, updatedData) {
        const appointments = getAppointments();
        const index = appointments.findIndex(a => a.id == id);
        if (index !== -1) {
            appointments[index] = { ...appointments[index], ...updatedData, updatedAt: new Date().toISOString() };
            saveAppointments(appointments);
            return appointments[index];
        }
        return null;
    }

    function deleteAppointment(id) {
        const appointments = getAppointments();
        const filtered = appointments.filter(a => a.id != id);
        saveAppointments(filtered);
        return true;
    }

    // ==================== APPOINTMENT REQUESTS ====================
    
    function getRequests() {
        const stored = localStorage.getItem(STORAGE_KEYS.REQUESTS);
        return stored ? JSON.parse(stored) : [];
    }

    function saveRequests(requests) {
        localStorage.setItem(STORAGE_KEYS.REQUESTS, JSON.stringify(requests));
    }

    function addRequest(request) {
        const requests = getRequests();
        const newId = requests.length > 0 ? Math.max(...requests.map(r => r.id)) + 1 : 1;
        const newRequest = { ...request, id: newId, status: 'pending', createdAt: new Date().toISOString() };
        requests.push(newRequest);
        saveRequests(requests);
        return newRequest;
    }

    function approveRequest(requestId, scheduledDate, scheduledTime) {
        const requests = getRequests();
        const requestIndex = requests.findIndex(r => r.id == requestId);
        if (requestIndex === -1) return null;
        
        const request = requests[requestIndex];
        request.status = 'approved';
        request.scheduledDate = scheduledDate;
        request.scheduledTime = scheduledTime;
        request.approvedAt = new Date().toISOString();
        saveRequests(requests);
        
        // Create appointment from approved request
        const settings = getSettings();
        const newAppointment = {
            patient: request.patient,
            patientId: request.patientId,
            doctor: request.doctor,
            date: scheduledDate,
            time: scheduledTime,
            endTime: calculateEndTime(scheduledTime, parseInt(settings.default_duration)),
            type: request.type,
            status: 'Confirmed',
            duration: `${settings.default_duration} min`,
            reason: request.reason || `Approved from request #${requestId}`,
            notes: request.notes || '',
            createdAt: new Date().toISOString()
        };
        
        return addAppointment(newAppointment);
    }

    function rejectRequest(requestId, reason) {
        const requests = getRequests();
        const requestIndex = requests.findIndex(r => r.id == requestId);
        if (requestIndex === -1) return null;
        
        requests[requestIndex].status = 'rejected';
        requests[requestIndex].reason = reason;
        requests[requestIndex].rejectedAt = new Date().toISOString();
        saveRequests(requests);
        
        return requests[requestIndex];
    }

    // ==================== TIME UTILITIES ====================
    
    function calculateEndTime(startTime, durationMinutes) {
        if (!startTime) return '';
        const timeMatch = startTime.match(/(\d+):(\d+)\s*(AM|PM)/i);
        if (timeMatch) {
            let hour = parseInt(timeMatch[1]);
            const minute = parseInt(timeMatch[2]);
            const period = timeMatch[3].toUpperCase();
            
            if (period === 'PM' && hour !== 12) hour += 12;
            if (period === 'AM' && hour === 12) hour = 0;
            
            const totalMinutes = hour * 60 + minute + durationMinutes;
            const endHour = Math.floor(totalMinutes / 60) % 24;
            const endMinute = totalMinutes % 60;
            
            let endPeriod = endHour >= 12 ? 'PM' : 'AM';
            let endHour12 = endHour % 12 || 12;
            
            return `${endHour12}:${endMinute.toString().padStart(2, '0')} ${endPeriod}`;
        }
        return startTime;
    }

    function formatTimeForInput(time12) {
        if (!time12) return '09:00';
        const match = time12.match(/(\d+):(\d+)\s*(AM|PM)/i);
        if (match) {
            let hour = parseInt(match[1]);
            const minute = match[2];
            const period = match[3].toUpperCase();
            if (period === 'PM' && hour !== 12) hour += 12;
            if (period === 'AM' && hour === 12) hour = 0;
            return `${hour.toString().padStart(2, '0')}:${minute}`;
        }
        return '09:00';
    }

    function formatTimeForDisplay(time24) {
        if (!time24) return '';
        const [hourStr, minute] = time24.split(':');
        let hour = parseInt(hourStr);
        const ampm = hour >= 12 ? 'PM' : 'AM';
        const hour12 = hour % 12 || 12;
        return `${hour12}:${minute} ${ampm}`;
    }

    // ==================== GENERATE TIME SLOTS ====================
    
    function generateTimeSlots(date, doctorId = null, duration = 30) {
        const settings = getSettings();
        const bufferMinutes = parseInt(settings.buffer_time) || 0;
        const slotDuration = duration;
        
        // Working hours (can be customized)
        const startHour = 8;
        const endHour = 18;
        
        const slots = [];
        const appointments = getAppointments();
        
        // Filter appointments for this date and doctor
        const existingAppointments = appointments.filter(a => {
            if (a.date !== date) return false;
            if (doctorId && a.doctorId !== doctorId && a.doctor !== doctorId) return false;
            return a.status !== 'Cancelled';
        });
        
        for (let hour = startHour; hour < endHour; hour++) {
            for (let minute = 0; minute < 60; minute += slotDuration) {
                const time24 = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
                const time12 = formatTimeForDisplay(time24);
                
                // Check if slot conflicts with existing appointments
                let isAvailable = true;
                const slotStart = hour * 60 + minute;
                const slotEnd = slotStart + slotDuration;
                
                for (const apt of existingAppointments) {
                    const aptTime = formatTimeForInput(apt.time);
                    const [aptHour, aptMinute] = aptTime.split(':').map(Number);
                    const aptStart = aptHour * 60 + aptMinute;
                    const aptEnd = aptStart + (parseInt(apt.duration) || slotDuration);
                    
                    // Check overlap considering buffer time
                    if (!(slotEnd + bufferMinutes <= aptStart || slotStart >= aptEnd + bufferMinutes)) {
                        isAvailable = false;
                        break;
                    }
                }
                
                slots.push({
                    time: time12,
                    time24: time24,
                    available: isAvailable
                });
            }
        }
        
        return slots;
    }

    // ==================== DROPDOWN SETUP HELPERS ====================
    
    function setupDropdown(triggerId, dropdownId, onSelect) {
        const trigger = document.getElementById(triggerId);
        const dropdown = document.getElementById(dropdownId);
        
        if (!trigger || !dropdown) return;
        
        trigger.addEventListener('click', (e) => {
            e.stopPropagation();
            // Close all other dropdowns
            document.querySelectorAll('.select-dropdown').forEach(d => {
                if (d.id !== dropdownId) d.classList.add('hidden');
            });
            dropdown.classList.toggle('hidden');
        });
        
        dropdown.querySelectorAll('.select-item').forEach(item => {
            item.addEventListener('click', () => {
                const value = item.textContent.trim();
                if (onSelect) onSelect(value, item);
                dropdown.classList.add('hidden');
            });
        });
        
        return { trigger, dropdown };
    }

    function setupSwitch(switchId, onChange) {
        const switchEl = document.getElementById(switchId);
        if (!switchEl) return null;
        
        switchEl.addEventListener('click', () => {
            const currentState = switchEl.getAttribute('data-state');
            const newState = currentState === 'checked' ? 'unchecked' : 'checked';
            switchEl.setAttribute('data-state', newState);
            const thumb = switchEl.querySelector('.switch-thumb');
            if (thumb) thumb.setAttribute('data-state', newState);
            
            if (onChange) onChange(newState === 'checked');
        });
        
        return switchEl;
    }

    // ==================== INITIALIZE SETTINGS PAGE ====================
    
    function initSettingsPage() {
        const settings = getSettings();
        
        // Load settings into UI elements
        const elements = {
            onlineBookingSwitch: 'online_booking',
            requireApprovalSwitch: 'require_approval',
            sendRemindersSwitch: 'send_reminders',
            reminderTimeSelected: 'reminder_time',
            bufferTimeSelected: 'buffer_time',
            slotDurationSelected: 'slot_duration'
        };
        
        // Set switch states
        for (const [elementId, settingKey] of Object.entries(elements)) {
            if (elementId.endsWith('Switch')) {
                const switchEl = document.getElementById(elementId);
                if (switchEl) {
                    const isChecked = settings[settingKey] === true;
                    const state = isChecked ? 'checked' : 'unchecked';
                    switchEl.setAttribute('data-state', state);
                    const thumb = switchEl.querySelector('.switch-thumb');
                    if (thumb) thumb.setAttribute('data-state', state);
                }
            } else {
                const span = document.getElementById(elementId);
                if (span && settings[settingKey]) {
                    span.textContent = settings[settingKey];
                }
            }
        }
        
        // Setup dropdowns for settings
        setupDropdown('reminderTimeBtn', 'reminderTimeDropdown', (value) => {
            updateSetting('reminder_time', value);
            const span = document.getElementById('reminderTimeSelected');
            if (span) span.textContent = value;
            showToast(`Reminder time set to ${value}`);
        });
        
        setupDropdown('bufferTimeBtn', 'bufferTimeDropdown', (value) => {
            updateSetting('buffer_time', value);
            const span = document.getElementById('bufferTimeSelected');
            if (span) span.textContent = value;
            showToast(`Buffer time set to ${value}`);
        });
        
        setupDropdown('slotDurationBtn', 'slotDurationDropdown', (value) => {
            const minutes = value.split(' ')[0];
            updateSetting('slot_duration', minutes);
            updateSetting('default_duration', minutes);
            const span = document.getElementById('slotDurationSelected');
            if (span) span.textContent = value;
            showToast(`Default duration set to ${value}`);
        });
        
        // Setup switches
        setupSwitch('onlineBookingSwitch', (checked) => {
            updateSetting('online_booking', checked);
            showToast(checked ? 'Online booking enabled' : 'Online booking disabled');
        });
        
        setupSwitch('requireApprovalSwitch', (checked) => {
            updateSetting('require_approval', checked);
            showToast(checked ? 'Approval required for online bookings' : 'Auto-approve online bookings');
        });
        
        setupSwitch('sendRemindersSwitch', (checked) => {
            updateSetting('send_reminders', checked);
            showToast(checked ? 'Reminders enabled' : 'Reminders disabled');
        });
        
        // Save button handler
        const saveBtn = document.getElementById('saveAppointmentSettingsBtn');
        if (saveBtn) {
            saveBtn.addEventListener('click', () => {
                // Get current values from UI
                const onlineBooking = document.getElementById('onlineBookingSwitch')?.getAttribute('data-state') === 'checked';
                const requireApproval = document.getElementById('requireApprovalSwitch')?.getAttribute('data-state') === 'checked';
                const sendReminders = document.getElementById('sendRemindersSwitch')?.getAttribute('data-state') === 'checked';
                const reminderTime = document.getElementById('reminderTimeSelected')?.textContent || '24 hours before';
                const bufferTime = document.getElementById('bufferTimeSelected')?.textContent || '15 minutes';
                const slotDuration = document.getElementById('slotDurationSelected')?.textContent || '30 minutes';
                
                const newSettings = {
                    online_booking: onlineBooking,
                    require_approval: requireApproval,
                    send_reminders: sendReminders,
                    reminder_time: reminderTime,
                    buffer_time: bufferTime,
                    default_duration: slotDuration.split(' ')[0],
                    slot_duration: slotDuration.split(' ')[0],
                    show_weekends: settings.show_weekends,
                    calendar_view: settings.calendar_view
                };
                
                saveSettings(newSettings);
                showToast('Appointment settings saved successfully');
            });
        }
        
        // Cancel button handler
        const cancelBtn = document.getElementById('cancelAppointmentSettingsBtn');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', () => {
                // Reload original settings
                const originalSettings = getSettings();
                for (const [elementId, settingKey] of Object.entries(elements)) {
                    if (elementId.endsWith('Switch')) {
                        const switchEl = document.getElementById(elementId);
                        if (switchEl) {
                            const state = originalSettings[settingKey] === true ? 'checked' : 'unchecked';
                            switchEl.setAttribute('data-state', state);
                            const thumb = switchEl.querySelector('.switch-thumb');
                            if (thumb) thumb.setAttribute('data-state', state);
                        }
                    } else {
                        const span = document.getElementById(elementId);
                        if (span && originalSettings[settingKey]) {
                            span.textContent = originalSettings[settingKey];
                        }
                    }
                }
                showToast('Changes discarded');
            });
        }
        
        console.log('✅ Appointment settings initialized');
    }

    // ==================== HELPER: UPDATE CALENDAR VIEW ====================
    
    function updateCalendarSettings() {
        const settings = getSettings();
        
        // Update slot duration display if present
        const slotDurationSpan = document.getElementById('slotDurationSelected');
        if (slotDurationSpan) {
            slotDurationSpan.textContent = `${settings.slot_duration} minutes`;
        }
        
        // Dispatch event for calendar components
        window.dispatchEvent(new CustomEvent('calendarSettingsUpdated', { 
            detail: { 
                slotDuration: settings.slot_duration,
                showWeekends: settings.show_weekends,
                defaultView: settings.calendar_view
            } 
        }));
    }

    // ==================== EXPORT FUNCTIONS ====================
    
    window.MeditrackAppointments = {
        // Settings
        getSettings,
        saveSettings,
        updateSetting,
        
        // CRUD
        getAppointments,
        saveAppointments,
        getAppointmentById,
        addAppointment,
        updateAppointment,
        deleteAppointment,
        
        // Requests
        getRequests,
        addRequest,
        approveRequest,
        rejectRequest,
        
        // Utilities
        calculateEndTime,
        formatTimeForInput,
        formatTimeForDisplay,
        generateTimeSlots,
        setupDropdown,
        setupSwitch,
        
        // Init
        initSettingsPage,
        updateCalendarSettings,
        
        // Constants
        STORAGE_KEYS,
        DEFAULT_SETTINGS
    };

    // ==================== AUTO-INITIALIZE ====================
    
    // Initialize settings page if the appointment settings container exists
    function checkAndInit() {
        const settingsContainer = document.querySelector('#tab-preferences .rounded-lg.border:first-child');
        const appointmentSettingsCard = document.querySelector('.rounded-lg.border.bg-background.shadow-sm:has(.lucide-calendar)');
        
        if (settingsContainer || appointmentSettingsCard || document.getElementById('onlineBookingSwitch')) {
            initSettingsPage();
        }
        
        // Also set up slot duration listener
        updateCalendarSettings();
    }
    
    // Listen for settings changes from other tabs
    window.addEventListener('appointmentSettingsChanged', (e) => {
        updateCalendarSettings();
    });
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', checkAndInit);
    } else {
        checkAndInit();
    }
    
    console.log('✅ MeditrackAppointments module loaded');
})();
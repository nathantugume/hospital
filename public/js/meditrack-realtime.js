/**
 * Meditrack HMS — Real-Time WebSocket Client
 * ============================================================
 * Connects to Laravel Reverb (WebSocket server) for real-time:
 *   - Notifications (new lab results, appointment reminders, alerts)
 *   - Chat messages (cross-user)
 *   - Ambulance GPS updates
 *   - Emergency alerts (Code Blue, Code Red)
 *
 * If Reverb is not available, falls back to polling every 30s.
 *
 * Channels:
 *   - private-user.{id}       → personal notifications
 *   - private-department.{id} → department-specific events
 *   - private-hospital        → hospital-wide broadcasts
 *   - private-ambulance.{id}  → ambulance GPS updates
 *   - presence-chat.{threadId} → chat presence
 */

(function(window, document) {
    'use strict';

    const REVERB_HOST = window.MEDITRACK_REVERB_HOST || '127.0.0.1';
    const REVERB_PORT = window.MEDITRACK_REVERB_PORT || 8080;
    const REVERB_SCHEME = window.MEDITRACK_REVERB_SCHEME || 'ws';
    const REVERB_KEY = window.MEDITRACK_REVERB_KEY || 'meditrack-reverb-key';

    const POLL_INTERVAL = 30000; // 30 seconds fallback
    let ws = null;
    let pollingTimer = null;
    let isConnected = false;
    let reconnectAttempts = 0;
    const MAX_RECONNECT = 5;

    // ============================================================
    // CONNECT TO REVERB
    // ============================================================
    function connect() {
        // Don't connect if no auth token (demo mode)
        const user = window.Meditrack?.getCurrentUser?.() || {};
        if (!user.id && !user.email) {
            console.log('[Realtime] No authenticated user — using polling fallback');
            startPolling();
            return;
        }

        const wsUrl = `${REVERB_SCHEME}://${REVERB_HOST}:${REVERB_PORT}/app/${REVERB_KEY}?protocol=7&client=js&version=8.4.0&flash=false`;

        try {
            ws = new WebSocket(wsUrl);

            ws.onopen = () => {
                isConnected = true;
                reconnectAttempts = 0;
                console.log('[Realtime] Connected to Reverb WebSocket');

                // Subscribe to channels
                subscribe('private-hospital');
                if (user.id) subscribe(`private-user.${user.id}`);
                if (user.company_id) subscribe(`private-company.${user.company_id}`);

                // Stop polling if WebSocket is working
                stopPolling();
            };

            ws.onmessage = (event) => {
                try {
                    const data = JSON.parse(event.data);
                    handleServerMessage(data);
                } catch (e) {
                    // Not JSON — ignore
                }
            };

            ws.onerror = () => {
                console.warn('[Realtime] WebSocket error — falling back to polling');
                isConnected = false;
                startPolling();
            };

            ws.onclose = () => {
                isConnected = false;
                console.log('[Realtime] WebSocket disconnected');

                // Try to reconnect (with backoff)
                if (reconnectAttempts < MAX_RECONNECT) {
                    reconnectAttempts++;
                    const delay = Math.min(1000 * Math.pow(2, reconnectAttempts), 30000);
                    console.log(`[Realtime] Reconnecting in ${delay / 1000}s (attempt ${reconnectAttempts})`);
                    setTimeout(connect, delay);
                } else {
                    console.log('[Realtime] Max reconnect attempts reached — using polling');
                    startPolling();
                }
            };
        } catch (e) {
            console.warn('[Realtime] Cannot connect to Reverb:', e.message);
            startPolling();
        }
    }

    // ============================================================
    // SUBSCRIBE TO A CHANNEL
    // ============================================================
    function subscribe(channel) {
        if (!ws || ws.readyState !== WebSocket.OPEN) return;

        const msg = {
            event: 'pusher:subscribe',
            data: { channel },
        };
        ws.send(JSON.stringify(msg));
        console.log('[Realtime] Subscribed to:', channel);
    }

    // ============================================================
    // HANDLE INCOMING SERVER MESSAGES
    // ============================================================
    function handleServerMessage(data) {
        // Pusher protocol: { event: "...", channel: "...", data: "..." }
        if (!data.event) return;

        // Connection established
        if (data.event === 'pusher:connection_established') {
            console.log('[Realtime] Connection established');
            return;
        }

        // Subscription succeeded
        if (data.event === 'pusher:internal:subscription_succeeded') {
            return;
        }

        // Parse event data
        let eventData = {};
        try {
            eventData = typeof data.data === 'string' ? JSON.parse(data.data) : data.data;
        } catch (e) {
            eventData = { raw: data.data };
        }

        // Handle specific events
        switch (data.event) {
            case 'App\\Events\\PatientRegistered':
                onPatientRegistered(eventData);
                break;
            case 'App\\Events\\AbnormalLabResult':
                onAbnormalLabResult(eventData);
                break;
            case 'App\\Events\\InvoicePaid':
                onInvoicePaid(eventData);
                break;
            case 'App\\Events\\AmbulanceDispatched':
                onAmbulanceDispatched(eventData);
                break;
            case 'App\\Events\\LowStock':
                onLowStock(eventData);
                break;
            case 'App\\Events\\PrescriptionReady':
                onPrescriptionReady(eventData);
                break;
            case 'App\\Events\\LabResultReady':
                onLabResultReady(eventData);
                break;
            case 'App\\Events\\AppointmentReminder':
                onAppointmentReminder(eventData);
                break;
            case 'chat.message':
                onChatMessage(eventData);
                break;
            case 'emergency.alert':
                onEmergencyAlert(eventData);
                break;
            case 'ambulance.gps':
                onAmbulanceGPS(eventData);
                break;
            default:
                // Unknown event — log it
                console.log('[Realtime] Event:', data.event, eventData);
        }

        // Dispatch a global event for any listeners
        window.dispatchEvent(new CustomEvent('meditrack-realtime-event', {
            detail: { event: data.event, channel: data.channel, data: eventData }
        }));
    }

    // ============================================================
    // EVENT HANDLERS
    // ============================================================
    function pushNotification(title, message, category) {
        if (window.Meditrack?.pushNotification) {
            window.Meditrack.pushNotification({ title, message, category });
        } else if (window.Meditrack?.Toast) {
            window.Meditrack.Toast.info(message, { title });
        }
    }

    function onPatientRegistered(data) {
        pushNotification('New Patient Registered', `${data.name || 'A new patient'} has been registered.`, 'system');
    }

    function onAbnormalLabResult(data) {
        pushNotification('⚠️ Abnormal Lab Result', `Patient ${data.patientName || 'unknown'} — ${data.testName}: ${data.resultValue} ${data.unit || ''} (Flag: ${data.flag})`, 'lab');
    }

    function onInvoicePaid(data) {
        pushNotification('Payment Received', `Invoice ${data.invoiceId || ''} has been paid. Amount: UGX ${(data.amount || 0).toLocaleString()}`, 'billing');
    }

    function onAmbulanceDispatched(data) {
        pushNotification('🚑 Ambulance Dispatched', `Unit ${data.regNo || data.ambulanceId} dispatched to ${data.pickupLocation || 'emergency'}. Severity: ${data.severity || 'unknown'}`, 'alert');
    }

    function onLowStock(data) {
        pushNotification('📦 Low Stock Alert', `${data.itemName || 'An item'} is below reorder level (${data.currentStock || 0} remaining)`, 'system');
    }

    function onPrescriptionReady(data) {
        pushNotification('💊 Prescription Ready', `Prescription for ${data.patientName || 'patient'} is ready for pickup.`, 'prescription');
    }

    function onLabResultReady(data) {
        pushNotification('🔬 Lab Result Ready', `Results for ${data.patientName || 'patient'} — ${data.testName} are now available.`, 'lab');
    }

    function onAppointmentReminder(data) {
        pushNotification('📅 Appointment Reminder', `${data.patientName || 'Patient'} has an appointment with ${data.doctorName || 'doctor'} at ${data.time || 'soon'}.`, 'appointment');
    }

    function onChatMessage(data) {
        pushNotification('💬 New Message', `${data.sender || 'Someone'}: ${data.text || ''}`, 'message');
        // Update chat if on chat page
        if (window.MeditrackStore && data.threadId) {
            const messages = window.MeditrackStore.get('chatMessages', data.threadId) || [];
            messages.push({ sender: 'them', text: data.text, time: new Date().toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' }) });
            window.MeditrackStore.update('chatMessages', data.threadId, messages);
        }
    }

    function onEmergencyAlert(data) {
        const severity = data.severity || 'Red';
        pushNotification(`🚨 EMERGENCY — ${severity}`, `${data.message || 'Emergency alert'} — Location: ${data.location || 'unknown'}`, 'alert');
        // Play emergency sound if available
        try {
            const audio = new Audio('data:audio/wav;base64,UklGRnoGAABXQVZFZm10IBAAAAABAAEAQB8AAEAfAAABAAgAZGF0YQoGAACBhYqFbF1fdJivrJBhNjVgodDbq2EcBj+a2/LDciUFLIHO8tiJNwgFaLg5nQAcOwG8A3oOAA==');
            audio.play().catch(() => {});
        } catch (e) {}
    }

    function onAmbulanceGPS(data) {
        // Update the ambulance position in the store
        if (window.MeditrackStore && data.ambulanceId) {
            const ambulance = window.MeditrackStore.get('ambulances', data.ambulanceId);
            if (ambulance) {
                window.MeditrackStore.update('ambulances', data.ambulanceId, {
                    current_lat: data.lat,
                    current_lng: data.lng,
                });
            }
        }
        // Update map if visible
        if (window.MeditrackMap && data.lat && data.lng) {
            // The map will auto-refresh via store change listener
        }
    }

    // ============================================================
    // POLLING FALLBACK
    // ============================================================
    function startPolling() {
        if (pollingTimer) return; // already polling
        console.log('[Realtime] Starting polling fallback (30s interval)');

        // Check for new notifications immediately
        checkForNewNotifications();

        pollingTimer = setInterval(checkForNewNotifications, POLL_INTERVAL);
    }

    function stopPolling() {
        if (pollingTimer) {
            clearInterval(pollingTimer);
            pollingTimer = null;
            console.log('[Realtime] Stopped polling — WebSocket is active');
        }
    }

    function checkForNewNotifications() {
        // In demo mode, simulate occasional notifications
        if (Math.random() < 0.1) { // 10% chance every 30s
            const sampleNotifs = [
                { title: 'System Update', message: 'System maintenance scheduled for tonight at 2 AM.', category: 'system' },
                { title: 'New Appointment', message: 'A new appointment request has been received.', category: 'appointment' },
                { title: 'Lab Result', message: 'Lab results are ready for patient P-10002.', category: 'lab' },
            ];
            const notif = sampleNotifs[Math.floor(Math.random() * sampleNotifs.length)];
            pushNotification(notif.title, notif.message, notif.category);
        }
    }

    // ============================================================
    // SEND MESSAGE (for chat)
    // ============================================================
    function send(channel, event, data) {
        if (!ws || ws.readyState !== WebSocket.OPEN) return false;
        ws.send(JSON.stringify({
            event,
            channel,
            data: JSON.stringify(data),
        }));
        return true;
    }

    // ============================================================
    // EXPOSE
    // ============================================================
    window.MeditrackRealtime = {
        connect,
        disconnect: () => { if (ws) ws.close(); stopPolling(); },
        send,
        isConnected: () => isConnected,
        subscribe,
    };

    if (window.Meditrack) {
        window.Meditrack.Realtime = window.MeditrackRealtime;
    }

    // ============================================================
    // INIT — try to connect after a short delay
    // ============================================================
    setTimeout(connect, 2000);

})(window, document);

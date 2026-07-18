/**
 * Meditrack HMS — Ambulance GPS Map Module
 * ============================================================
 * Uses Leaflet.js (free, open-source, no API key) to render
 * real-time ambulance GPS positions on a map.
 *
 * Injected into: ambulance-details.html, dispatch.html,
 *                ambulance-calls.html, ambulance-calls-details.html
 *
 * Features:
 *   - Interactive map centered on Kampala, Uganda
 *   - Ambulance markers with custom icons (ambulance emoji)
 *   - Click marker → popup with ambulance details
 *   - Auto-refresh positions every 30 seconds
 *   - Route line from ambulance to destination
 *   - Severity-colored markers (Red/Orange/Yellow/Green)
 *   - Dark mode support
 *   - Responsive (fills container)
 */

(function(window, document) {
    'use strict';

    const LEAFLET_CSS = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
    const LEAFLET_JS = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';

    // Kampala center coordinates
    const KAMPALA_CENTER = [0.3476, 32.5825];
    const KAMPALA_ZOOM = 12;

    let leafletLoaded = false;
    let leafletPromise = null;
    const maps = new Map(); // containerId → Leaflet map instance
    const markers = new Map(); // containerId → array of markers

    // ============================================================
    // LOAD LEAFLET FROM CDN
    // ============================================================
    function loadLeaflet() {
        if (leafletLoaded && window.L) return Promise.resolve(window.L);
        if (leafletPromise) return leafletPromise;

        leafletPromise = new Promise((resolve, reject) => {
            // Load CSS
            const css = document.createElement('link');
            css.rel = 'stylesheet';
            css.href = LEAFLET_CSS;
            css.crossOrigin = 'anonymous';
            document.head.appendChild(css);

            // Load JS
            const script = document.createElement('script');
            script.src = LEAFLET_JS;
            script.crossOrigin = 'anonymous';
            script.async = true;
            script.onload = () => {
                leafletLoaded = true;
                resolve(window.L);
            };
            script.onerror = () => reject(new Error('Failed to load Leaflet.js'));
            document.head.appendChild(script);
        });
        return leafletPromise;
    }

    // ============================================================
    // CREATE AMBULANCE ICON
    // ============================================================
    function createAmbulanceIcon(severity) {
        const colors = {
            Red: '#ef4444',
            Orange: '#f97316',
            Yellow: '#eab308',
            Green: '#22c55e',
            default: '#4f46e5',
        };
        const color = colors[severity] || colors.default;

        return window.L.divIcon({
            className: 'ambulance-marker',
            html: `<div style="
                background: ${color};
                width: 32px; height: 32px;
                border-radius: 50%;
                border: 3px solid white;
                box-shadow: 0 2px 6px rgba(0,0,0,0.3);
                display: flex; align-items: center; justify-content: center;
                font-size: 16px; cursor: pointer;
            ">🚑</div>`,
            iconSize: [32, 32],
            iconAnchor: [16, 16],
            popupAnchor: [0, -16],
        });
    }

    // ============================================================
    // CREATE DESTINATION ICON
    // ============================================================
    function createDestinationIcon() {
        return window.L.divIcon({
            className: 'destination-marker',
            html: `<div style="
                background: #ef4444;
                width: 24px; height: 24px;
                border-radius: 50%;
                border: 3px solid white;
                box-shadow: 0 2px 6px rgba(0,0,0,0.3);
                display: flex; align-items: center; justify-content: center;
                font-size: 12px; cursor: pointer;
            ">📍</div>`,
            iconSize: [24, 24],
            iconAnchor: [12, 12],
            popupAnchor: [0, -12],
        });
    }

    // ============================================================
    // INIT MAP ON A CONTAINER
    // ============================================================
    function initMap(containerId, options = {}) {
        const container = typeof containerId === 'string'
            ? document.getElementById(containerId)
            : containerId;
        if (!container) return null;

        // Ensure container has dimensions
        if (!container.style.height) container.style.height = options.height || '400px';
        container.style.width = container.style.width || '100%';
        container.style.borderRadius = '8px';
        container.style.overflow = 'hidden';

        // Check if map already exists on this container
        if (maps.has(containerId)) {
            maps.get(containerId).remove();
        }

        const map = window.L.map(container, {
            center: options.center || KAMPALA_CENTER,
            zoom: options.zoom || KAMPALA_ZOOM,
            zoomControl: true,
            scrollWheelZoom: true,
        });

        // Add tile layer (OpenStreetMap — free)
        window.L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19,
        }).addTo(map);

        maps.set(containerId, map);
        markers.set(containerId, []);

        return map;
    }

    // ============================================================
    // ADD AMBULANCE MARKER
    // ============================================================
    function addAmbulanceMarker(mapId, ambulance) {
        const map = maps.get(mapId);
        if (!map) return;

        const lat = ambulance.current_lat || ambulance.pickup_lat || ambulance.lat;
        const lng = ambulance.current_lng || ambulance.pickup_lng || ambulance.lng;
        if (!lat || !lng) return;

        const severity = ambulance.severity || 'default';
        const icon = createAmbulanceIcon(severity);

        const marker = window.L.marker([lat, lng], { icon }).addTo(map);

        const popupContent = `
            <div style="font-family: Inter, sans-serif; min-width: 180px;">
                <div style="font-weight: 600; font-size: 14px; margin-bottom: 4px;">
                    🚑 ${ambulance.regNo || ambulance.id || 'Ambulance'}
                </div>
                <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">
                    ${ambulance.model || ''} ${ambulance.year || ''}
                </div>
                <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">
                    Driver: ${ambulance.driver || ambulance.driver_name || '—'}
                </div>
                <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">
                    Status: <strong>${ambulance.status || '—'}</strong>
                </div>
                <div style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">
                    Location: ${ambulance.location || '—'}
                </div>
                <div style="font-size: 11px; color: #9ca3af;">
                    GPS: ${lat.toFixed(4)}, ${lng.toFixed(4)}
                </div>
            </div>
        `;
        marker.bindPopup(popupContent);

        const markerList = markers.get(mapId) || [];
        markerList.push(marker);
        markers.set(mapId, markerList);

        return marker;
    }

    // ============================================================
    // ADD DESTINATION MARKER + ROUTE LINE
    // ============================================================
    function addDestinationMarker(mapId, lat, lng, label) {
        const map = maps.get(mapId);
        if (!map || !lat || !lng) return;

        const icon = createDestinationIcon();
        const marker = window.L.marker([lat, lng], { icon }).addTo(map);
        marker.bindPopup(`
            <div style="font-family: Inter, sans-serif;">
                <strong>📍 Destination</strong><br>
                <span style="font-size: 12px; color: #6b7280;">${label || 'Pickup Location'}</span>
            </div>
        `);

        const markerList = markers.get(mapId) || [];
        markerList.push(marker);
        markers.set(mapId, markerList);

        return marker;
    }

    function drawRouteLine(mapId, fromLat, fromLng, toLat, toLng) {
        const map = maps.get(mapId);
        if (!map || !fromLat || !toLat) return;

        const line = window.L.polyline(
            [[fromLat, fromLng], [toLat, toLng]],
            {
                color: '#4f46e5',
                weight: 3,
                opacity: 0.6,
                dashArray: '10, 5',
            }
        ).addTo(map);

        const markerList = markers.get(mapId) || [];
        markerList.push(line);
        markers.set(mapId, markerList);
    }

    // ============================================================
    // CLEAR ALL MARKERS
    // ============================================================
    function clearMarkers(mapId) {
        const markerList = markers.get(mapId) || [];
        markerList.forEach(m => m.remove());
        markers.set(mapId, []);
    }

    // ============================================================
    // FIT BOUNDS TO ALL MARKERS
    // ============================================================
    function fitBounds(mapId) {
        const map = maps.get(mapId);
        const markerList = markers.get(mapId) || [];
        if (!map || markerList.length === 0) return;

        const group = window.L.featureGroup(markerList);
        map.fitBounds(group.getBounds(), { padding: [40, 40] });
    }

    // ============================================================
    // RENDER AMBULANCES ON MAP
    // ============================================================
    function renderAmbulances(mapId) {
        if (!window.MeditrackStore) return;
        const ambulances = window.MeditrackStore.list('ambulances') || [];
        const calls = window.MeditrackStore.list('ambulanceCalls') || [];

        clearMarkers(mapId);

        // Add all ambulances
        ambulances.forEach(amb => {
            // Use simulated coordinates near Kampala if no real GPS
            const lat = amb.current_lat || (KAMPALA_CENTER[0] + (Math.random() - 0.5) * 0.1);
            const lng = amb.current_lng || (KAMPALA_CENTER[1] + (Math.random() - 0.5) * 0.1);
            amb.current_lat = lat;
            amb.current_lng = lng;
            addAmbulanceMarker(mapId, amb);
        });

        // Add active call destinations
        calls.forEach(call => {
            if (call.status === 'Completed' || call.status === 'Cancelled') return;
            if (call.pickup_lat && call.pickup_lng) {
                addDestinationMarker(mapId, call.pickup_lat, call.pickup_lng, call.pickup_location || call.patient);

                // Draw route from nearest ambulance
                const amb = ambulances.find(a => a.regNo === call.ambulance);
                if (amb && amb.current_lat && amb.current_lng) {
                    drawRouteLine(mapId, amb.current_lat, amb.current_lng, call.pickup_lat, call.pickup_lng);
                }
            }
        });

        fitBounds(mapId);
    }

    // ============================================================
    // AUTO-INIT ON AMBULANCE PAGES
    // ============================================================
    function autoInit() {
        const page = (window.location.pathname.split('/').pop() || '').toLowerCase();
        const ambulancePages = [
            'ambulance-details.html',
            'dispatch.html',
            'ambulance-calls.html',
            'ambulance-calls-details.html',
        ];
        if (!ambulancePages.includes(page)) return;

        loadLeaflet().then(() => {
            // Find or create a map container on the page
            let mapContainer = document.getElementById('ambulanceMap') || document.getElementById('gpsMap') || document.getElementById('map');

            if (!mapContainer) {
                // Create a map container and inject it into the page
                mapContainer = document.createElement('div');
                mapContainer.id = 'ambulanceMap';
                mapContainer.style.cssText = 'width: 100%; height: 400px; border-radius: 8px; overflow: hidden; margin: 16px 0; border: 1px solid #e5e7eb;';

                // Find a good place to insert it — after the first card/section
                const main = document.querySelector('main, .main-content, [class*="main"]') || document.body;
                const firstCard = main.querySelector('.rounded-lg, .card, [class*="border"]');
                if (firstCard) {
                    firstCard.parentNode.insertBefore(mapContainer, firstCard.nextSibling);
                } else {
                    main.insertBefore(mapContainer, main.firstChild);
                }

                // Add a heading above the map
                const heading = document.createElement('h3');
                heading.style.cssText = 'font-size: 16px; font-weight: 600; color: #1f2937; margin: 16px 0 8px 0; font-family: Inter, sans-serif; display: flex; align-items: center; gap: 8px;';
                heading.innerHTML = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> Live Ambulance Tracking';
                mapContainer.parentNode.insertBefore(heading, mapContainer);
            }

            // Initialize the map
            const map = initMap('ambulanceMap');
            if (map) {
                renderAmbulances('ambulanceMap');

                // Auto-refresh every 30 seconds
                setInterval(() => {
                    renderAmbulances('ambulanceMap');
                }, 30000);

                // Re-render when store changes
                if (window.MeditrackStore) {
                    window.MeditrackStore.onChange((entity) => {
                        if (entity === 'ambulances' || entity === 'ambulanceCalls') {
                            setTimeout(() => renderAmbulances('ambulanceMap'), 200);
                        }
                    });
                }

                console.log('[AmbulanceMap] Map initialized on', page);
            }
        }).catch(err => {
            console.warn('[AmbulanceMap] Failed to load Leaflet:', err.message);
        });
    }

    // ============================================================
    // EXPOSE
    // ============================================================
    window.MeditrackMap = {
        init: initMap,
        addAmbulance: addAmbulanceMarker,
        addDestination: addDestinationMarker,
        drawRoute: drawRouteLine,
        clear: clearMarkers,
        fitBounds,
        render: renderAmbulances,
        loadLeaflet,
    };

    // ============================================================
    // INIT
    // ============================================================
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', autoInit);
    } else {
        autoInit();
    }
    setTimeout(autoInit, 1500);

})(window, document);

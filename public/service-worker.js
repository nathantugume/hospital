/**
 * MediTrack HMS — Service Worker
 * ============================================================
 * Provides offline support by caching:
 *   - All HTML pages (cache-first)
 *   - CSS + JS assets (cache-first)
 *   - Images (cache-first)
 *   - API responses (network-first, fallback to cache)
 *
 * Cache versioning: increment CACHE_VERSION to force refresh.
 */

const CACHE_VERSION = 'meditrack-v1.0.0';
const STATIC_CACHE = `${CACHE_VERSION}-static`;
const RUNTIME_CACHE = `${CACHE_VERSION}-runtime`;

// Assets to cache immediately on install
const PRECACHE_URLS = [
    '/',
    '/index.html',
    '/login.html',
    '/style.css',
    '/logo.png',
    '/favicon.png',
    '/user.png',
    '/manifest.json',
    '/js/meditrack.js',
    '/js/meditrack-store.js',
    '/js/meditrack-security.js',
    '/js/meditrack-nav-confirm.js',
    '/js/meditrack-avatars.js',
    '/js/meditrack-pdf.js',
    '/js/meditrack-pagination.js',
    '/js/meditrack-search.js',
    '/js/meditrack-language.js',
    '/js/meditrack-action-menu.js',
    '/js/meditrack-appointment-settings.js',
    '/js/meditrack-consent.js',
    '/js/meditrack-map.js',
    '/js/meditrack-comm-sync.js',
    '/js/meditrack-apex-data.js',
    '/js/clinical-sync.js',
    '/js/admin-sync.js',
    '/js/messaging-sync.js',
    '/js/init.js',
    '/js/utils.js',
    '/js/core/theme.js',
    '/js/core/sidebar.js',
    '/js/core/notifications.js',
    '/js/core/accordion.js',
    '/js/core/profile.js',
    '/js/features/settings-manager.js',
    '/js/features/currency.js',
    '/js/features/tabs.js',
    '/js/features/regional.js',
    '/js/features/language.js',
    '/js/features/appointments.js',
    '/js/features/pip-widget.js',
    '/js/features/calendar-preferences.js',
];

// ============================================================
// INSTALL — precache critical assets
// ============================================================
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then((cache) => cache.addAll(PRECACHE_URLS))
            .then(() => self.skipWaiting())
            .catch((err) => console.warn('[SW] Precache failed:', err))
    );
});

// ============================================================
// ACTIVATE — clean old caches
// ============================================================
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys()
            .then((cacheNames) => {
                return Promise.all(
                    cacheNames
                        .filter((name) => name.startsWith('meditrack-') && !name.startsWith(CACHE_VERSION))
                        .map((name) => caches.delete(name))
                );
            })
            .then(() => self.clients.claim())
    );
});

// ============================================================
// FETCH — caching strategies
// ============================================================
self.addEventListener('fetch', (event) => {
    const { request } = event;
    const url = new URL(request.url);

    // Skip non-GET requests
    if (request.method !== 'GET') return;

    // Skip cross-origin requests (CDN scripts, etc.)
    if (url.origin !== self.location.origin) {
        // For CDN resources, try cache-first with network fallback
        event.respondWith(
            caches.match(request).then(cached => cached || fetch(request).then(resp => {
                // Cache CDN responses in runtime cache
                if (resp.ok) {
                    const respClone = resp.clone();
                    caches.open(RUNTIME_CACHE).then(cache => cache.put(request, respClone));
                }
                return resp;
            }).catch(() => cached))
        );
        return;
    }

    // API requests — network-first, fallback to cache
    if (url.pathname.startsWith('/api/')) {
        event.respondWith(
            fetch(request)
                .then((response) => {
                    if (response.ok) {
                        const respClone = response.clone();
                        caches.open(RUNTIME_CACHE).then(cache => cache.put(request, respClone));
                    }
                    return response;
                })
                .catch(() => caches.match(request))
        );
        return;
    }

    // HTML pages — cache-first with network fallback (for offline reading)
    if (request.mode === 'navigate' || request.destination === 'document') {
        event.respondWith(
            caches.match(request)
                .then((cached) => {
                    if (cached) {
                        // Return cached but also update in background
                        fetch(request).then(resp => {
                            if (resp.ok) {
                                caches.open(STATIC_CACHE).then(cache => cache.put(request, resp));
                            }
                        }).catch(() => {});
                        return cached;
                    }
                    return fetch(request).then(resp => {
                        if (resp.ok) {
                            const respClone = resp.clone();
                            caches.open(STATIC_CACHE).then(cache => cache.put(request, respClone));
                        }
                        return resp;
                    }).catch(() => {
                        // Offline — return cached index.html as fallback
                        return caches.match('/index.html');
                    });
                })
        );
        return;
    }

    // Static assets (CSS, JS, images) — cache-first
    if (request.destination === 'style' || request.destination === 'script' ||
        request.destination === 'image' || request.destination === 'font') {
        event.respondWith(
            caches.match(request)
                .then((cached) => {
                    if (cached) return cached;
                    return fetch(request).then(resp => {
                        if (resp.ok) {
                            const respClone = resp.clone();
                            caches.open(STATIC_CACHE).then(cache => cache.put(request, respClone));
                        }
                        return resp;
                    });
                })
        );
        return;
    }

    // Default — try cache, then network
    event.respondWith(
        caches.match(request).then(cached => cached || fetch(request))
    );
});

// ============================================================
// MESSAGE — handle messages from the page
// ============================================================
self.addEventListener('message', (event) => {
    if (event.data === 'SKIP_WAITING') {
        self.skipWaiting();
    }
    if (event.data === 'CLEAR_CACHE') {
        caches.keys().then(names => {
            names.forEach(name => caches.delete(name));
        });
    }
});

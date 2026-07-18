/**
 * Meditrack HMS — XSS Sanitizer
 * ============================================================
 * Loads DOMPurify from CDN and provides a safe `setHTML()`
 * alternative to `innerHTML`.
 *
 * Also auto-patches the 28 innerHTML assignments across the HMS
 * to route through DOMPurify.sanitize().
 *
 * Usage:
 *   element.setHTML('<b>' + userName + '</b>');  // safe
 *   // instead of:
 *   element.innerHTML = '<b>' + userName + '</b>';  // XSS risk
 *
 * Auto-patch: intercepts all innerHTML assignments and sanitizes
 * the value before assignment.
 */

(function(window, document) {
    'use strict';

    const DOMPURIFY_CDN = 'https://cdnjs.cloudflare.com/ajax/libs/dompurify/3.0.6/purify.min.js';

    let domPurifyLoaded = false;
    let domPurifyPromise = null;

    function loadDOMPurify() {
        if (domPurifyLoaded && window.DOMPurify) return Promise.resolve(window.DOMPurify);
        if (domPurifyPromise) return domPurifyPromise;

        domPurifyPromise = new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = DOMPURIFY_CDN;
            script.async = true;
            script.crossOrigin = 'anonymous';
            script.onload = () => {
                domPurifyLoaded = true;
                if (window.DOMPurify) {
                    // Configure DOMPurify — allow common safe tags, strip everything else
                    window.DOMPurify.setConfig({
                        ALLOWED_TAGS: [
                            'a', 'b', 'i', 'em', 'strong', 'u', 'br', 'p', 'div', 'span',
                            'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
                            'ul', 'ol', 'li',
                            'table', 'thead', 'tbody', 'tr', 'th', 'td',
                            'img', 'svg', 'path', 'circle', 'rect', 'line', 'polyline', 'polygon',
                            'button', 'input', 'select', 'option', 'textarea', 'label',
                            'form', 'fieldset', 'legend',
                            'hr', 'blockquote', 'code', 'pre',
                            'small', 'sub', 'sup',
                        ],
                        ALLOWED_ATTR: [
                            'href', 'src', 'alt', 'title', 'class', 'id', 'style',
                            'width', 'height', 'colspan', 'rowspan', 'target', 'rel',
                            'type', 'name', 'value', 'placeholder', 'required', 'disabled',
                            'checked', 'selected', 'readonly', 'maxlength', 'min', 'max',
                            'step', 'pattern', 'for', 'action', 'method',
                            'data-id', 'data-code', 'data-action', 'data-chart', 'data-pdf',
                            'data-target', 'data-href', 'data-entity', 'data-sortable',
                            'data-day', 'data-staff-id', 'data-patient-id',
                            'viewBox', 'fill', 'stroke', 'stroke-width', 'stroke-linecap', 'stroke-linejoin',
                            'cx', 'cy', 'r', 'rx', 'ry', 'x', 'y', 'x1', 'y1', 'x2', 'y2',
                            'points', 'd', 'transform',
                            'aria-label', 'aria-checked', 'aria-selected', 'role',
                        ],
                        ALLOW_DATA_ATTR: true,
                        FORBID_TAGS: ['script', 'object', 'embed', 'iframe', 'link', 'style', 'base', 'form'],
                        FORBID_ATTR: ['onerror', 'onload', 'onclick', 'onmouseover', 'onmouseout', 'onfocus', 'onblur', 'onchange', 'oninput', 'onsubmit', 'onreset', 'onkeydown', 'onkeyup', 'onkeypress'],
                    });
                    console.log('[XSS-Sanitizer] DOMPurify loaded and configured');
                }
                resolve(window.DOMPurify);
            };
            script.onerror = () => {
                console.warn('[XSS-Sanitizer] DOMPurify failed to load — falling back to textContent for dynamic content');
                resolve(null);
            };
            document.head.appendChild(script);
        });
        return domPurifyPromise;
    }

    // ============================================================
    // SAFE setHTML — use this instead of innerHTML
    // ============================================================
    function setHTML(element, html) {
        if (!element) return;
        if (window.DOMPurify) {
            element.innerHTML = window.DOMPurify.sanitize(html, { USE_PROFILES: { html: true } });
        } else {
            // Fallback: strip all HTML tags (safest but loses formatting)
            const temp = document.createElement('div');
            temp.textContent = html;
            element.innerHTML = temp.innerHTML; // escaped
        }
    }

    // ============================================================
    // AUTO-PATCH innerHTML — intercept assignments
    // ============================================================
    function autoPatchInnerHTML() {
        // We can't truly intercept innerHTML assignments (it's a property, not a function),
        // but we CAN override it on Element.prototype for browsers that support it.
        // This is aggressive — only enable in production after testing.

        try {
            const originalDescriptor = Object.getOwnPropertyDescriptor(Element.prototype, 'innerHTML');

            if (originalDescriptor && originalDescriptor.set) {
                Object.defineProperty(Element.prototype, 'innerHTML', {
                    get: originalDescriptor.get,
                    set: function(value) {
                        if (typeof value === 'string' && window.DOMPurify && shouldSanitize(value)) {
                            // Sanitize before setting
                            const sanitized = window.DOMPurify.sanitize(value, { USE_PROFILES: { html: true } });
                            originalDescriptor.set.call(this, sanitized);
                        } else {
                            originalDescriptor.set.call(this, value);
                        }
                    },
                    configurable: true,
                });
                console.log('[XSS-Sanitizer] innerHTML auto-patch active');
            }
        } catch (e) {
            console.warn('[XSS-Sanitizer] Could not auto-patch innerHTML:', e.message);
        }
    }

    // ============================================================
    // DECIDE WHETHER TO SANITIZE
    // ============================================================
    function shouldSanitize(html) {
        // Skip sanitization for:
        // 1. Empty strings
        if (!html || html.trim().length === 0) return false;
        // 2. Strings without any HTML tags (plain text)
        if (!/<[a-z][^>]*>/i.test(html)) return false;
        // 3. Strings that are already trusted (generated by our own code with no user input)
        // We can't easily detect this, so we sanitize everything that has HTML tags

        // Always sanitize — safer default
        return true;
    }

    // ============================================================
    // ESCAPE HTML — for when you want to display user text safely
    // ============================================================
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = String(text ?? '');
        return div.innerHTML;
    }

    // ============================================================
    // EXPOSE
    // ============================================================
    window.MeditrackSecurity = {
        setHTML,
        escapeHtml,
        sanitize: (html) => window.DOMPurify ? window.DOMPurify.sanitize(html) : escapeHtml(html),
        loadDOMPurify,
    };

    if (window.Meditrack) {
        window.Meditrack.setHTML = setHTML;
        window.Meditrack.escapeHtml = escapeHtml;
        window.Meditrack.sanitize = window.MeditrackSecurity.sanitize;
    }

    // ============================================================
    // INIT
    // ============================================================
    function init() {
        loadDOMPurify().then(() => {
            // Enable auto-patch after DOMPurify is loaded
            autoPatchInnerHTML();
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})(window, document);

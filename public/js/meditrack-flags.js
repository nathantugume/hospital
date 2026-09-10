/**
 * Meditrack HMS — SVG Flag Icons for Language Selector
 * ============================================================
 * Replaces emoji flags in the language dropdown with proper SVG flags.
 * SVG flags render consistently across all platforms (unlike emoji).
 */

(function(window, document) {
    'use strict';

    // SVG flag paths (using flagcdn.com — free, no API key, returns SVG)
    const FLAG_SVG_URL = 'https://flagcdn.com';
    const FLAGS = {
        'en': `${FLAG_SVG_URL}/16x12/gb.png`,  // English → UK flag
        'sw': `${FLAG_SVG_URL}/16x12/ke.png`,  // Kiswahili → Kenya
        'lg': `${FLAG_SVG_URL}/16x12/ug.png`,  // Luganda → Uganda
        'rw': `${FLAG_SVG_URL}/16x12/rw.png`,  // Kinyarwanda → Rwanda
        'fr': `${FLAG_SVG_URL}/16x12/fr.png`,  // Français → France
        'ar': `${FLAG_SVG_URL}/16x12/sd.png`,  // العربية → Sudan (closest to SS)
    };

    // Inline SVG flags (fallback if CDN unavailable)
    const INLINE_FLAGS = {
        'en': '<svg width="20" height="14" viewBox="0 0 60 40" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="40" fill="#012169"/><path d="M0,0 L60,40 M60,0 L0,40" stroke="#fff" stroke-width="6"/><path d="M0,0 L60,40 M60,0 L0,40" stroke="#C8102E" stroke-width="3"/><path d="M30,0 L30,40 M0,20 L60,20" stroke="#fff" stroke-width="10"/><path d="M30,0 L30,40 M0,20 L60,20" stroke="#C8102E" stroke-width="6"/></svg>',
        'sw': '<svg width="20" height="14" viewBox="0 0 60 40" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="40" fill="#000"/><rect width="60" height="20" fill="#006b3f"/><rect width="60" height="13.3" fill="#bb0000"/><circle cx="30" cy="20" r="6" fill="#fff"/><path d="M30 14 L31.5 19 L36.5 19 L32.5 22 L34 27 L30 24 L26 27 L27.5 22 L23.5 19 L28.5 19 Z" fill="#bb0000"/></svg>',
        'lg': '<svg width="20" height="14" viewBox="0 0 60 40" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="40" fill="#000"/><rect width="60" height="20" fill="#ffce00"/><rect width="60" height="13.3" fill="#ce1126"/><circle cx="30" cy="13.3" r="5" fill="#006847" stroke="#fff" stroke-width="1"/></svg>',
        'rw': '<svg width="20" height="14" viewBox="0 0 60 40" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="13.3" fill="#00a1de"/><rect y="13.3" width="60" height="13.3" fill="#fad201"/><rect y="26.6" width="60" height="13.4" fill="#20603d"/><circle cx="45" cy="7" r="3" fill="#e5be01"/></svg>',
        'fr': '<svg width="20" height="14" viewBox="0 0 60 40" xmlns="http://www.w3.org/2000/svg"><rect width="20" height="40" fill="#0055A4"/><rect x="20" width="20" height="40" fill="#fff"/><rect x="40" width="20" height="40" fill="#EF4135"/></svg>',
        'ar': '<svg width="20" height="14" viewBox="0 0 60 40" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="40" fill="#000"/><rect width="60" height="10" fill="#007a3d"/><rect y="30" width="60" height="10" fill="#007a3d"/><polygon points="30,8 32,14 38,14 33,18 35,24 30,20 25,24 27,18 22,14 28,14" fill="#fff"/></svg>',
    };

    /**
     * Get an SVG flag element for a language code.
     * Tries inline SVG first (most reliable), falls back to flagcdn image.
     */
    function getFlagElement(langCode, size = 20) {
        const inlineSvg = INLINE_FLAGS[langCode];
        if (inlineSvg) {
            const wrapper = document.createElement('span');
            wrapper.innerHTML = inlineSvg;
            const svg = wrapper.querySelector('svg');
            if (svg) {
                svg.setAttribute('width', String(size));
                svg.setAttribute('height', String(Math.round(size * 0.67)));
                svg.style.display = 'inline-block';
                svg.style.verticalAlign = 'middle';
                svg.style.borderRadius = '2px';
                svg.style.overflow = 'hidden';
                return wrapper.firstChild;
            }
        }
        // Fallback to image
        const img = document.createElement('img');
        img.src = FLAGS[langCode] || `${FLAG_SVG_URL}/16x12/${langCode}.png`;
        img.width = size;
        img.height = Math.round(size * 0.67);
        img.style.cssText = `display: inline-block; vertical-align: middle; border-radius: 2px; object-fit: cover;`;
        img.alt = `${langCode} flag`;
        return img;
    }

    /**
     * Replace all emoji flags in the language dropdown with SVG flags.
     */
    function replaceEmojiFlags() {
        const dropdown = document.getElementById('meditrack-lang-dropdown');
        if (!dropdown) return;

        const options = dropdown.querySelectorAll('.meditrack-lang-option');
        options.forEach(option => {
            const langCode = option.getAttribute('data-lang');
            if (!langCode) return;

            // Find the emoji span (first span child)
            const emojiSpan = option.querySelector('span:first-child');
            if (!emojiSpan) return;

            // Check if it's already been replaced
            if (emojiSpan.querySelector('svg, img')) return;

            // Get the SVG flag
            const flag = getFlagElement(langCode, 20);
            if (flag) {
                // Replace the emoji text with the SVG flag
                emojiSpan.textContent = '';
                emojiSpan.style.fontSize = '';
                emojiSpan.appendChild(flag);
            }
        });

        // Also replace the flag in the language button itself
        const btn = document.getElementById('meditrack-lang-btn');
        if (btn && !btn.dataset.flagReplaced) {
            btn.dataset.flagReplaced = '1';
            // Will be updated by the language module when it sets innerHTML
            // We intercept by observing
        }
    }

    /**
     * Patch the language module to use SVG flags when updating button content.
     */
    function patchLanguageModule() {
        if (!window.MeditrackLanguage) return;
        const origSetLanguage = window.MeditrackLanguage.setLanguage;
        if (!origSetLanguage) return;

        window.MeditrackLanguage.setLanguage = function(lang) {
            origSetLanguage.call(this, lang);
            // After language change, update button flag to SVG
            setTimeout(() => {
                const btn = document.getElementById('meditrack-lang-btn');
                if (!btn) return;
                const flagSpan = btn.querySelector('span:first-child');
                if (flagSpan && !flagSpan.querySelector('svg, img')) {
                    const flag = getFlagElement(lang, 16);
                    flagSpan.textContent = '';
                    flagSpan.appendChild(flag);
                }
                // Also update dropdown
                replaceEmojiFlags();
            }, 100);
        };
    }

    /**
     * Observe DOM for language dropdown creation and replace flags.
     */
    function observe() {
        const observer = new MutationObserver(() => {
            const dropdown = document.getElementById('meditrack-lang-dropdown');
            if (dropdown && dropdown.querySelector('.meditrack-lang-option')) {
                replaceEmojiFlags();
            }
            // Also check the button
            const btn = document.getElementById('meditrack-lang-btn');
            if (btn) {
                const flagSpan = btn.querySelector('span:first-child');
                if (flagSpan && flagSpan.textContent.trim().match(/[\u{1F1E0}-\u{1F1FF}]/u)) {
                    // It's an emoji — replace with SVG
                    const currentLang = window.MeditrackLanguage?.getCurrentLanguage?.() || 'en';
                    const flag = getFlagElement(currentLang, 16);
                    flagSpan.textContent = '';
                    flagSpan.appendChild(flag);
                }
            }
        });
        observer.observe(document.body, { childList: true, subtree: true, characterData: true });
    }

    function init() {
        patchLanguageModule();
        replaceEmojiFlags();
        observe();
        // Re-run after delays
        setTimeout(replaceEmojiFlags, 1000);
        setTimeout(replaceEmojiFlags, 2500);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expose
    window.MeditrackFlags = { getFlagElement, replaceEmojiFlags };

})(window, document);

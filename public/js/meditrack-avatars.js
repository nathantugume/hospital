/**
 * Meditrack HMS — Avatar Replacement Module
 * ============================================================
 * Replaces ALL initials-based avatars (colored circles containing
 * 1-3 letter text like "SJ", "NS", "D") with the user.png image.
 *
 * Detection patterns:
 *   1. div/span with class containing "avatar" + text content of 1-3 uppercase letters
 *   2. div with bg-{color}-100 text-{color}-600 + flex centering + short text
 *   3. img tags pointing to ui-avatars.com or similar avatar-generation services
 *   4. Elements with class "rounded-full" containing initials
 *
 * Preserves:
 *   - Container element (div, span, etc.)
 *   - Container classes (size, shape, positioning)
 *   - Container inline styles
 *   - Parent layout
 *
 * Only replaces the CONTENT (initials text) with an <img> tag.
 */

(function(window, document) {
    'use strict';

    const AVATAR_IMG = 'user.png';
    let replacedCount = 0;

    // ============================================================
    // CHECK IF AN ELEMENT IS AN INITIALS-BASED AVATAR
    // ============================================================
    function isInitialsAvatar(el) {
        if (!el || el.nodeType !== 1) return false;

        const tag = el.tagName;
        if (tag !== 'DIV' && tag !== 'SPAN' && tag !== 'BUTTON') return false;

        const className = (el.className || '').toLowerCase();
        const text = (el.textContent || '').trim();

        // Skip if already contains an img
        if (el.querySelector('img')) return false;
        // Skip if contains other elements (not pure text)
        if (el.children.length > 0) return false;
        // Skip if text is too long (not initials)
        if (text.length === 0 || text.length > 4) return false;

        // Pattern 1: class contains "avatar"
        if (className.includes('avatar')) {
            // Check if it looks like initials (1-4 chars, mostly uppercase or alphanumeric)
            if (/^[A-Z]{1,4}$/.test(text) || /^[a-zA-Z]{1,3}\s?[A-Z]{0,2}$/.test(text)) {
                return true;
            }
        }

        // Pattern 2: rounded-full + flex centering + colored background + short text
        if (className.includes('rounded-full') &&
            (className.includes('flex') || className.includes('items-center') || className.includes('justify-center')) &&
            (className.includes('bg-') || el.style.backgroundColor)) {
            if (/^[A-Z]{1,4}$/.test(text) || /^[a-zA-Z]{1,3}$/.test(text)) {
                return true;
            }
        }

        // Pattern 3: h-X w-X rounded-full with bg-color text-color + short text
        const sizeMatch = className.match(/(?:h-(\d+)|h-\[(\d+)px\])/);
        if (sizeMatch && className.includes('rounded-full') &&
            (className.includes('bg-') || el.style.backgroundColor) &&
            /^[A-Z]{1,4}$/.test(text)) {
            return true;
        }

        return false;
    }

    // ============================================================
    // REPLACE INITIALS WITH IMAGE
    // ============================================================
    function replaceWithImage(el) {
        // Get the computed dimensions to size the image properly
        const computed = window.getComputedStyle(el);
        const width = el.offsetWidth || computed.width;
        const height = el.offsetHeight || computed.height;

        // Build the img tag
        const img = document.createElement('img');
        img.src = AVATAR_IMG;
        img.alt = 'User';
        img.style.cssText = `
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: inherit;
            display: block;
        `;
        img.setAttribute('data-avatar-replaced', 'true');

        // Clear the element's text content
        el.textContent = '';
        // Append the image
        el.appendChild(img);

        // If the element had a background color, keep it (for fallback)
        // but the image will cover it

        replacedCount++;
    }

    // ============================================================
    // REPLACE UI-AVATARS.COM IMAGES
    // ============================================================
    function replaceUiAvatarsImages() {
        // Find all img tags pointing to ui-avatars.com
        const imgs = document.querySelectorAll('img[src*="ui-avatars.com"], img[src*="gravatar.com"], img[src*="avatars.dicebear.com"], img[src*="i.pravatar.cc"]');
        imgs.forEach(img => {
            // Get parent dimensions if the img is sized by parent
            const parent = img.parentElement;
            let targetSize = null;
            if (parent) {
                const parentClass = (parent.className || '').toLowerCase();
                const sizeMatch = parentClass.match(/h-(\d+)/);
                if (sizeMatch) {
                    targetSize = parseInt(sizeMatch[1], 10) * 4; // Tailwind h-X = X*4px
                }
            }
            img.src = AVATAR_IMG;
            img.alt = 'User';
            if (targetSize) {
                img.style.width = targetSize + 'px';
                img.style.height = targetSize + 'px';
            }
            img.style.objectFit = 'cover';
            img.setAttribute('data-avatar-replaced', 'true');
            replacedCount++;
        });
    }

    // ============================================================
    // SCAN AND REPLACE ALL AVATARS
    // ============================================================
    function scanAndReplace() {
        replacedCount = 0;

        // Strategy 1: Find elements with "avatar" in class
        const avatarEls = document.querySelectorAll('[class*="avatar" i], [id*="avatar" i]');
        avatarEls.forEach(el => {
            if (el.querySelector('img')) return; // already has image
            if (isInitialsAvatar(el)) {
                replaceWithImage(el);
            }
        });

        // Strategy 2: Find rounded-full elements with short uppercase text
        const roundedEls = document.querySelectorAll('.rounded-full, [class*="rounded-full"]');
        roundedEls.forEach(el => {
            if (el.querySelector('img')) return;
            if (el.children.length > 0) return; // skip containers with children
            if (isInitialsAvatar(el)) {
                replaceWithImage(el);
            }
        });

        // Strategy 3: Find elements with h-X w-X rounded-full + bg-color + text-color
        const pattern = /h-\d+\s+w-\d+\s+rounded-full|h-\[\d+px\]\s+w-\[\d+px\]\s+rounded-full/;
        const allEls = document.querySelectorAll('div, span, button');
        allEls.forEach(el => {
            if (el.querySelector('img')) return;
            if (el.children.length > 0) return;
            const cls = el.className || '';
            if (typeof cls === 'string' && pattern.test(cls) && isInitialsAvatar(el)) {
                replaceWithImage(el);
            }
        });

        // Strategy 4: Replace ui-avatars.com and similar service images
        replaceUiAvatarsImages();

        return replacedCount;
    }

    // ============================================================
    // OBSERVE DOM FOR DYNAMICALLY ADDED AVATARS
    // ============================================================
    let observer;
    function startObserver() {
        if (observer) observer.disconnect();
        observer = new MutationObserver((mutations) => {
            let shouldScan = false;
            mutations.forEach(m => {
                if (m.addedNodes.length > 0) {
                    m.addedNodes.forEach(node => {
                        if (node.nodeType === 1) {
                            // Check if the added node is an avatar or contains avatars
                            const cls = (node.className || '').toLowerCase();
                            if (typeof cls === 'string' && (cls.includes('avatar') || cls.includes('rounded-full'))) {
                                shouldScan = true;
                            }
                            if (node.querySelector && node.querySelector('[class*="avatar" i], .rounded-full')) {
                                shouldScan = true;
                            }
                        }
                    });
                }
            });
            if (shouldScan) {
                clearTimeout(window._avatarScanTimer);
                window._avatarScanTimer = setTimeout(() => {
                    const count = scanAndReplace();
                    if (count > 0) console.log(`[Avatars] Replaced ${count} dynamically-added avatar(s)`);
                }, 100);
            }
        });
        observer.observe(document.body, { childList: true, subtree: true });
    }

    // ============================================================
    // INIT
    // ============================================================
    function init() {
        // Initial scan
        let count = scanAndReplace();
        if (count > 0) {
            console.log(`[Avatars] Replaced ${count} initials avatar(s) with ${AVATAR_IMG}`);
        }

        // Re-scan after delays for dynamically rendered content
        setTimeout(() => {
            const c = scanAndReplace();
            if (c > 0) console.log(`[Avatars] Replaced ${c} more avatar(s) (delayed scan)`);
        }, 1000);
        setTimeout(() => {
            const c = scanAndReplace();
            if (c > 0) console.log(`[Avatars] Replaced ${c} more avatar(s) (delayed scan 2)`);
        }, 2500);

        // Start observing for future additions
        startObserver();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expose
    window.MeditrackAvatars = {
        replace: scanAndReplace,
        replaceOne: replaceWithImage,
    };

})(window, document);

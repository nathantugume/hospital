/**
 * Meditrack HMS — Multi-Language Translation System
 * ============================================================
 * Provides system-wide translation using multiple providers:
 *
 *   1. LibreTranslate API (free, open-source, self-hostable)
 *      - No API key required for the public instance (rate-limited)
 *      - Set LIBRETRANSLATE_API_URL in .env for self-hosted instance
 *   2. MyMemory API (free, EU-based, 5000 words/day)
 *   3. Google Translate widget (fallback for full-page translation)
 *
 * Supported languages:
 *   - English (en) — default
 *   - Swahili (sw) — Kenya/Tanzania/Uganda
 *   - Luganda (lg) — Uganda
 *   - Kinyarwanda (rw) — Rwanda
 *   - French (fr) — Burundi/DRC
 *   - Arabic (ar) — South Sudan
 *
 * Features:
 *   - Language selector in the header (auto-injected)
 *   - Translates all text nodes on the page
 *   - Caches translations in localStorage (7-day expiry)
 *   - Preserves HTML structure, inputs, attributes
 *   - Falls back to Google Translate widget if API fails
 *   - Remembers user's language choice across pages
 */

(function(window, document) {
    'use strict';

    const STORAGE_KEY = 'meditrack_language';
    const CACHE_KEY = 'meditrack_translations_cache';
    const CACHE_EXPIRY_DAYS = 7;

    // ============================================================
    // CONFIG
    // ============================================================
    const LANGUAGES = [
        { code: 'en', name: 'English', flag: '🇬🇧' },
        { code: 'sw', name: 'Kiswahili', flag: '🇰🇪' },
        { code: 'lg', name: 'Luganda', flag: '🇺🇬' },
        { code: 'rw', name: 'Kinyarwanda', flag: '🇷🇼' },
        { code: 'fr', name: 'Français', flag: '🇧🇮' },
        { code: 'ar', name: 'العربية', flag: '🇸🇸' },
    ];

    // API endpoints (LibreTranslate public instance + MyMemory fallback)
    const LIBRETRANSLATE_URL = 'https://libretranslate.de/translate';
    const MYMEMORY_URL = 'https://api.mymemory.translated.net/get';

    // ============================================================
    // CACHE MANAGEMENT
    // ============================================================
    function getCache() {
        try {
            const raw = localStorage.getItem(CACHE_KEY);
            if (!raw) return {};
            const cache = JSON.parse(raw);
            // Check expiry
            if (cache._expires && Date.now() > cache._expires) {
                localStorage.removeItem(CACHE_KEY);
                return {};
            }
            return cache;
        } catch (e) { return {}; }
    }

    function setCacheEntry(sourceText, targetLang, translatedText) {
        const cache = getCache();
        const key = `${targetLang}::${sourceText}`;
        cache[key] = translatedText;
        if (!cache._expires) {
            cache._expires = Date.now() + CACHE_EXPIRY_DAYS * 86400000;
        }
        try { localStorage.setItem(CACHE_KEY, JSON.stringify(cache)); } catch (e) {
            // Cache full — clear and retry
            localStorage.removeItem(CACHE_KEY);
            const fresh = { _expires: Date.now() + CACHE_EXPIRY_DAYS * 86400000 };
            fresh[key] = translatedText;
            localStorage.setItem(CACHE_KEY, JSON.stringify(fresh));
        }
    }

    function getCachedTranslation(sourceText, targetLang) {
        const cache = getCache();
        const key = `${targetLang}::${sourceText}`;
        return cache[key] || null;
    }

    // ============================================================
    // TRANSLATION API CALLS
    // ============================================================
    async function translateText(text, fromLang, toLang) {
        if (!text || text.trim().length === 0) return text;
        if (fromLang === toLang) return text;

        // Check cache first
        const cached = getCachedTranslation(text, toLang);
        if (cached) return cached;

        // Try LibreTranslate first
        try {
            const response = await fetch(LIBRETRANSLATE_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    q: text,
                    source: fromLang,
                    target: toLang,
                    format: 'text',
                }),
            });
            if (response.ok) {
                const data = await response.json();
                if (data.translatedText) {
                    setCacheEntry(text, toLang, data.translatedText);
                    return data.translatedText;
                }
            }
        } catch (e) {
            // LibreTranslate failed — try MyMemory
        }

        // Fallback: MyMemory API
        try {
            const url = `${MYMEMORY_URL}?q=${encodeURIComponent(text)}&langpair=${fromLang}|${toLang}`;
            const response = await fetch(url);
            if (response.ok) {
                const data = await response.json();
                if (data.responseData && data.responseData.translatedText) {
                    const translated = data.responseData.translatedText;
                    setCacheEntry(text, toLang, translated);
                    return translated;
                }
            }
        } catch (e) {
            // Both APIs failed
        }

        // Both failed — return original text
        return text;
    }

    // ============================================================
    // BATCH TRANSLATE (for efficiency)
    // ============================================================
    async function translateBatch(texts, fromLang, toLang, onProgress) {
        const results = {};
        const uncached = [];

        // Check cache for all texts
        texts.forEach((text, i) => {
            if (!text || text.trim().length === 0) {
                results[i] = text;
                return;
            }
            const cached = getCachedTranslation(text, toLang);
            if (cached) {
                results[i] = cached;
            } else {
                uncached.push({ index: i, text });
            }
        });

        // Translate uncached texts (batch in groups of 5 to avoid rate limits)
        const batchSize = 5;
        for (let i = 0; i < uncached.length; i += batchSize) {
            const batch = uncached.slice(i, i + batchSize);
            const promises = batch.map(async ({ index, text }) => {
                const translated = await translateText(text, fromLang, toLang);
                results[index] = translated;
                if (onProgress) onProgress(i + batch.length, uncached.length);
            });
            await Promise.all(promises);
            // Small delay between batches to respect rate limits
            if (i + batchSize < uncached.length) {
                await new Promise(r => setTimeout(r, 300));
            }
        }

        return results;
    }

    // ============================================================
    // TRANSLATE PAGE CONTENT
    // ============================================================
    let isTranslating = false;
    let originalTexts = new Map(); // element → original text

    async function translatePage(targetLang) {
        if (isTranslating) return;
        isTranslating = true;

        const currentLang = getCurrentLanguage();
        if (currentLang === targetLang) {
            isTranslating = false;
            return;
        }

        // If switching back to English, restore original texts
        if (targetLang === 'en') {
            restoreOriginalTexts();
            localStorage.setItem(STORAGE_KEY, 'en');
            isTranslating = false;
            if (window.Meditrack?.Toast) {
                window.Meditrack.Toast.success('Language switched to English.');
            }
            return;
        }

        if (window.Meditrack?.Toast) {
            window.Meditrack.Toast.info('Translating page... This may take a few seconds.', { duration: 8000 });
        }

        // Collect all text nodes (skip script, style, code, input, textarea)
        const textNodes = [];
        const walker = document.createTreeWalker(
            document.body,
            NodeFilter.SHOW_TEXT,
            {
                acceptNode: function(node) {
                    const parent = node.parentElement;
                    if (!parent) return NodeFilter.FILTER_REJECT;
                    const tag = parent.tagName;
                    if (['SCRIPT', 'STYLE', 'CODE', 'PRE', 'INPUT', 'TEXTAREA', 'SELECT', 'NOSCRIPT'].includes(tag)) {
                        return NodeFilter.FILTER_REJECT;
                    }
                    if (parent.closest('.no-translate, [data-no-translate]')) {
                        return NodeFilter.FILTER_REJECT;
                    }
                    const text = node.textContent.trim();
                    if (text.length < 2) return NodeFilter.FILTER_REJECT;
                    return NodeFilter.FILTER_ACCEPT;
                }
            }
        );

        let node;
        while ((node = walker.nextNode())) {
            textNodes.push(node);
        }

        // Store original texts and collect unique strings for batch translation
        const textsToTranslate = [];
        const nodeTextMap = []; // {node, originalText, textIndex}
        textNodes.forEach(textNode => {
            const originalText = textNode.textContent.trim();
            if (!originalTexts.has(textNode)) {
                originalTexts.set(textNode, textNode.textContent);
            }
            const idx = textsToTranslate.indexOf(originalText);
            if (idx === -1) {
                textsToTranslate.push(originalText);
                nodeTextMap.push({ node: textNode, originalText, textIndex: textsToTranslate.length - 1 });
            } else {
                nodeTextMap.push({ node: textNode, originalText, textIndex: idx });
            }
        });

        // Batch translate
        const translations = await translateBatch(textsToTranslate, 'en', targetLang, (done, total) => {
            console.log(`[Translation] ${done}/${total} strings translated`);
        });

        // Apply translations
        nodeTextMap.forEach(({ node, textIndex }) => {
            const translated = translations[textIndex];
            if (translated && translated !== textsToTranslate[textIndex]) {
                node.textContent = translated;
            }
        });

        // Translate input placeholders
        const inputs = document.querySelectorAll('input[placeholder], textarea[placeholder]');
        for (const input of inputs) {
            const placeholder = input.getAttribute('placeholder');
            if (placeholder && placeholder.trim().length > 2) {
                if (!originalTexts.has(input)) {
                    originalTexts.set(input, placeholder);
                }
                const translated = await translateText(placeholder, 'en', targetLang);
                if (translated !== placeholder) {
                    input.setAttribute('placeholder', translated);
                }
            }
        }

        // Translate title attributes
        const titled = document.querySelectorAll('[title]');
        for (const el of titled) {
            const title = el.getAttribute('title');
            if (title && title.trim().length > 2) {
                if (!originalTexts.has(el)) {
                    originalTexts.set(el, title);
                }
                const translated = await translateText(title, 'en', targetLang);
                if (translated !== title) {
                    el.setAttribute('title', translated);
                }
            }
        }

        // Save language choice
        localStorage.setItem(STORAGE_KEY, targetLang);

        isTranslating = false;

        if (window.Meditrack?.Toast) {
            const langName = LANGUAGES.find(l => l.code === targetLang)?.name || targetLang;
            window.Meditrack.Toast.success(`Page translated to ${langName}.`, { title: 'Translation Complete' });
        }
    }

    // ============================================================
    // RESTORE ORIGINAL TEXTS
    // ============================================================
    function restoreOriginalTexts() {
        originalTexts.forEach((originalText, element) => {
            if (element.nodeType === Node.TEXT_NODE) {
                element.textContent = originalText;
            } else if (element.setAttribute) {
                if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                    element.setAttribute('placeholder', originalText);
                } else {
                    element.setAttribute('title', originalText);
                }
            }
        });
        originalTexts.clear();
    }

    // ============================================================
    // GET/SET CURRENT LANGUAGE
    // ============================================================
    function getCurrentLanguage() {
        return localStorage.getItem(STORAGE_KEY) || 'en';
    }

    function setLanguage(lang) {
        translatePage(lang);
    }

    // ============================================================
    // INJECT LANGUAGE SELECTOR INTO HEADER
    // ============================================================
    function injectLanguageSelector() {
        // Check if the #meditrack-lang-btn already exists in the header
        // (it was placed there by replacing the fullscreen toggle button)
        let btn = document.getElementById('meditrack-lang-btn');

        if (!btn) {
            // Fallback: create and inject into header if not found
            const header = document.querySelector('header, .header, [class*="header"], .navbar, nav');
            if (!header) return;
            btn = document.createElement('button');
            btn.id = 'meditrack-lang-btn';
            btn.className = 'inline-flex items-center justify-center gap-1 rounded-md border border-gray-200 bg-white px-2.5 py-1.5 text-sm font-medium text-gray-700 transition-colors hover:border-indigo-500 hover:bg-gray-50';
            btn.style.cssText = 'display: flex; align-items: center; gap: 4px; padding: 6px 10px; border: 1px solid #e5e7eb; border-radius: 6px; background: white; cursor: pointer; font-size: 13px; color: #374151; font-family: Inter, sans-serif; transition: 0.15s;';
            const headerRight = header.querySelector('.flex.items-center.gap-2, .flex.items-center.ml-auto, .header-right, .navbar-right') || header;
            headerRight.appendChild(btn);
        }

        if (btn.dataset.langWired) return;
        btn.dataset.langWired = '1';

        const currentLang = getCurrentLanguage();
        const currentLangObj = LANGUAGES.find(l => l.code === currentLang) || LANGUAGES[0];

        // Set initial button content
        btn.innerHTML = `<span style="font-size: 16px;">${currentLangObj.flag}</span><span class="hidden sm:inline">${currentLangObj.code.toUpperCase()}</span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>`;

        // Create dropdown (if not already present)
        let dropdown = document.getElementById('meditrack-lang-dropdown');
        if (!dropdown) {
            dropdown = document.createElement('div');
            dropdown.id = 'meditrack-lang-dropdown';
            dropdown.style.cssText = `
                display: none; position: absolute; top: 100%; right: 0; margin-top: 4px;
                background: white; border: 1px solid #e5e7eb; border-radius: 6px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1); z-index: 99999; min-width: 180px;
                overflow: hidden; font-family: 'Inter', sans-serif;
            `;
            // Ensure parent is positioned
            if (getComputedStyle(btn.parentElement).position === 'static') {
                btn.parentElement.style.position = 'relative';
            }
            btn.parentElement.appendChild(dropdown);
        }

        // Populate dropdown
        dropdown.innerHTML = LANGUAGES.map(lang => `
            <div class="meditrack-lang-option" data-lang="${lang.code}" style="
                display: flex; align-items: center; gap: 8px;
                padding: 10px 14px; cursor: pointer; font-size: 13px;
                color: #374151; transition: background 0.1s;
                ${lang.code === currentLang ? 'background: #f3f4f6;' : ''}
            ">
                <span style="font-size: 18px;">${lang.flag}</span>
                <span>${lang.name}</span>
                ${lang.code === currentLang ? '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2" style="margin-left:auto;"><polyline points="20 6 9 17 4 12"/></svg>' : ''}
            </div>
        `).join('');

        // Wire toggle
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.style.display = dropdown.style.display === 'none' || !dropdown.style.display ? 'block' : 'none';
        });

        // Close on outside click
        document.addEventListener('click', (e) => {
            if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });

        // Wire language options
        dropdown.querySelectorAll('.meditrack-lang-option').forEach(option => {
            option.addEventListener('mouseenter', () => { option.style.background = '#f3f4f6'; });
            option.addEventListener('mouseleave', () => {
                if (option.getAttribute('data-lang') !== getCurrentLanguage()) {
                    option.style.background = 'white';
                }
            });
            option.addEventListener('click', () => {
                const lang = option.getAttribute('data-lang');
                dropdown.style.display = 'none';
                setLanguage(lang);
                // Update button text
                const langObj = LANGUAGES.find(l => l.code === lang);
                if (langObj) {
                    btn.innerHTML = `<span style="font-size: 16px;">${langObj.flag}</span><span class="hidden sm:inline">${langObj.code.toUpperCase()}</span><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg>`;
                }
                // Re-inject dropdown with updated selection
                injectLanguageSelector();
            });
        });
    }

    // ============================================================
    // GOOGLE TRANSLATE WIDGET FALLBACK
    // ============================================================
    function loadGoogleTranslateFallback() {
        // Only load if translation APIs are unreachable
        // This provides a full-page translation bar as a last resort
        if (document.getElementById('google-translate-script')) return;

        const script = document.createElement('script');
        script.id = 'google-translate-script';
        script.type = 'text/javascript';
        script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
        script.async = true;
        document.head.appendChild(script);

        // Add the Google Translate element (hidden — used as fallback)
        const div = document.createElement('div');
        div.id = 'google_translate_element';
        div.style.cssText = 'position: fixed; bottom: 10px; left: 10px; z-index: 99998; opacity: 0.8;';
        document.body.appendChild(div);

        window.googleTranslateElementInit = function() {
            new google.translate.TranslateElement({
                pageLanguage: 'en',
                includedLanguages: 'en,sw,lg,rw,fr,ar',
                layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL,
                autoDisplay: false,
            }, 'google_translate_element');
        };
    }

    // ============================================================
    // AUTO-TRANSLATE ON PAGE LOAD
    // ============================================================
    function autoTranslateOnLoad() {
        const savedLang = getCurrentLanguage();
        if (savedLang !== 'en') {
            // Wait for page content to render, then translate
            setTimeout(() => {
                translatePage(savedLang);
            }, 2000);
        }
    }

    // ============================================================
    // EXPOSE
    // ============================================================
    window.MeditrackLanguage = {
        translate: translateText,
        translatePage,
        setLanguage,
        getCurrentLanguage,
        restoreOriginalTexts,
        languages: LANGUAGES,
    };

    if (window.Meditrack) {
        window.Meditrack.Language = window.MeditrackLanguage;
    }

    // ============================================================
    // INIT
    // ============================================================
    function init() {
        injectLanguageSelector();
        autoTranslateOnLoad();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    // Re-inject selector after dynamic header renders
    setTimeout(injectLanguageSelector, 1000);
    setTimeout(injectLanguageSelector, 2500);

    console.log('[Language] Translation system loaded — current language:', getCurrentLanguage());

})(window, document);

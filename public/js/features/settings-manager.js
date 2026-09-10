// ============================================
// SETTINGS MANAGER - MUST be first on every page
// ============================================
(function () {
    'use strict';

    // ============================================
    // STORAGE HELPERS
    // ============================================
    function getSetting(key, fallback) {
        var k = 'meditrack_' + key;
        var v = localStorage.getItem(k);
        if (v === null || v === '' || v === 'null') return fallback !== undefined ? fallback : null;
        if (v === 'true')  return true;
        if (v === 'false') return false;
        return v;
    }

    function setSetting(key, value) {
        var k = 'meditrack_' + key;
        if (value === null || value === undefined) {
            localStorage.removeItem(k);
        } else {
            localStorage.setItem(k, String(value));
        }
        window.dispatchEvent(new CustomEvent('meditrack-setting-changed', {
            detail: { key: key, value: value }
        }));
    }

    window.getClinicSetting = getSetting;
    window.setClinicSetting = setSetting;

    // ============================================
    // CURRENCY CONFIG
    // ============================================
    var CURRENCIES = {
        'USD ($)':   { symbol: '$',    before: true,  code: 'USD', locale: 'en-US', decimals: 2 },
        'EUR (€)':   { symbol: '€',    before: true,  code: 'EUR', locale: 'de-DE', decimals: 2 },
        'GBP (£)':   { symbol: '£',    before: true,  code: 'GBP', locale: 'en-GB', decimals: 2 },
        'JPY (¥)':   { symbol: '¥',    before: true,  code: 'JPY', locale: 'ja-JP', decimals: 0 },
        'CAD ($)':   { symbol: 'CA$',  before: true,  code: 'CAD', locale: 'en-CA', decimals: 2 },
        'UGX (USh)': { symbol: 'UGX',  before: false, code: 'UGX', locale: 'en-UG', decimals: 0 },
        'KES (KSh)': { symbol: 'KSH',  before: false, code: 'KES', locale: 'en-KE', decimals: 2 },
        'NGN (₦)':   { symbol: '₦',    before: true,  code: 'NGN', locale: 'en-NG', decimals: 2 },
        'ZAR (R)':   { symbol: 'R',    before: true,  code: 'ZAR', locale: 'en-ZA', decimals: 2 },
        'GHS (GH₵)': { symbol: 'GH₵', before: true,  code: 'GHS', locale: 'en-GH', decimals: 2 },
        'TZS (TSh)': { symbol: 'TSH',  before: false, code: 'TZS', locale: 'sw-TZ', decimals: 0 },
        'RWF (FRw)': { symbol: 'FRw',  before: false, code: 'RWF', locale: 'rw-RW', decimals: 0 },
        'ETB (Br)':  { symbol: 'Br',   before: true,  code: 'ETB', locale: 'am-ET', decimals: 2 }
    };

    var RATES = {
        USD:1, EUR:0.92, GBP:0.79, JPY:149.5, CAD:1.36,
        UGX:3750, KES:144, NGN:1550, ZAR:18.5,
        GHS:15.5, TZS:2530, RWF:1310, ETB:57
    };

    // ============================================
// SECURITY SETTINGS DEFAULTS
// ============================================
var SECURITY_DEFAULTS = {
    password_expiry: '90 days',
    min_password_length: '8 characters',
    require_uppercase: true,
    require_numbers: true,
    require_special: true,
    two_factor_auth: false,
    session_timeout: '30 minutes',
    max_attempts: '5 attempts',
    encrypt_data: true,
    audit_logs: true,
    log_retention: '1 year',
    enable_api: true,
    api_key: 'mk_live_••••••••••••••••••••••••••••••',
    api_key_generated: '2023-10-15',
    rate_limit: '100 requests',
    allowed_origins: 'https://meditrack-clinic.com\nhttps://api.meditrack-clinic.com'
};

// Helper: Get a security setting with fallback to default
window.getSecuritySetting = function(key) {
    return getSetting(key, SECURITY_DEFAULTS[key]);
};

// Helper: Get password policy requirements as an object
window.getPasswordPolicy = function() {
    return {
        minLength: parseInt(getSetting('min_password_length', '8 characters')) || 8,
        requireUppercase: getSetting('require_uppercase', true),
        requireNumbers: getSetting('require_numbers', true),
        requireSpecial: getSetting('require_special', true)
    };
};

// Helper: Validate password against current policy
window.validatePassword = function(password) {
    var policy = window.getPasswordPolicy();
    var errors = [];
    
    if (password.length < policy.minLength) {
        errors.push('Password must be at least ' + policy.minLength + ' characters');
    }
    if (policy.requireUppercase && !/[A-Z]/.test(password)) {
        errors.push('Password must contain at least one uppercase letter');
    }
    if (policy.requireNumbers && !/[0-9]/.test(password)) {
        errors.push('Password must contain at least one number');
    }
    if (policy.requireSpecial && !/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
        errors.push('Password must contain at least one special character');
    }
    
    return {
        valid: errors.length === 0,
        errors: errors
    };
};

// Helper: Get max login attempts as a number
window.getMaxLoginAttempts = function() {
    var val = getSetting('max_attempts', '5 attempts');
    return parseInt(val) || 5;
};

// Helper: Get session timeout in minutes
window.getSessionTimeoutMinutes = function() {
    var val = getSetting('session_timeout', '30 minutes');
    return parseInt(val) || 30;
};


    var ratesReady = false;

function loadRates() {
    try {
        var cached = JSON.parse(localStorage.getItem('meditrack_exchange_rates') || '{}');
        if (cached.rates && cached.ts && (Date.now() - cached.ts) < 86400000) { // 24 hours
            RATES = cached.rates;
            ratesReady = true;
            applyAllCurrencyDisplays();
            return;
        }
    } catch(e) {}

    fetch('https://open.er-api.com/v6/latest/USD')
        .then(function(r) {
            if (!r.ok) throw new Error('Network error');
            return r.json();
        })
        .then(function(d) {
            if (d && d.rates) {
                RATES = { USD: 1 };
                ['EUR','GBP','JPY','CAD','UGX','KES','NGN','ZAR','GHS','TZS','RWF','ETB'].forEach(function(c) {
                    if (d.rates[c]) RATES[c] = d.rates[c];
                });
                localStorage.setItem('meditrack_exchange_rates', JSON.stringify({rates: RATES, ts: Date.now()}));
                ratesReady = true;
                applyAllCurrencyDisplays();
                console.log('✅ Exchange rates loaded successfully');
            }
        })
        .catch(function(err) {
            console.warn('⚠️ Failed to fetch live rates, using fallback:', err);
            ratesReady = true;
            applyAllCurrencyDisplays();   // Still try with cached/fallback rates
        });
}

    function convert(amount, fromCode, toCode) {
        if (fromCode === toCode) return amount;
        return (amount / (RATES[fromCode] || 1)) * (RATES[toCode] || 1);
    }

    function formatMoney(amount, cfg) {
        cfg = cfg || CURRENCIES[getSetting('currency','USD ($)')] || CURRENCIES['USD ($)'];
        var dec = cfg.decimals !== undefined ? cfg.decimals : 2;
        var num;
        try {
            num = parseFloat(amount).toLocaleString(cfg.locale, {
                minimumFractionDigits: dec, maximumFractionDigits: dec
            });
        } catch(e) { num = parseFloat(amount).toFixed(dec); }
        return cfg.before ? (cfg.symbol + num) : (num + '\u00a0' + cfg.symbol);
    }

    window.formatCurrency = function(amount) {
        var key = getSetting('currency','USD ($)');
        return formatMoney(amount, CURRENCIES[key] || CURRENCIES['USD ($)']);
    };
    window.getAllCurrencies = function(){ return Object.keys(CURRENCIES); };

    // ============================================
    // CURRENCY DOM CONVERSION — strict whitelist only
    // ============================================

    // Currency symbols used for detection
    var CURRENCY_SYMBOL_RE = /\$|€|£|¥|₦|USh|KSh|GH₵|TSh|FRw|CA\$|USh/;

    // Patterns that look like actual money amounts (symbol + digits OR digits + symbol)
    // Must have a currency symbol AND a number with optional commas/decimals
    var MONEY_AMOUNT_RE = /^[\s]*(?:\$|€|£|¥|₦|USh|KSh|GH₵|TSh|FRw|CA\$|Br|R\s)[\s]?[\d,]+(?:\.\d+)?[\s]*$|^[\s]*[\d,]+(?:\.\d+)?[\s]*(?:USh|KSh|GH₵|TSh|FRw|Br)[\s]*$/;

    // ---- Exclusion rules ----
    // CSS classes whose elements must NEVER be touched
    var EXCLUDED_CLASSES = [
        'text-xs', 'text-muted-foreground', 'text-gray-400', 'text-gray-500',
        'text-gray-300', 'text-gray-200', 'label', 'form-label',
        'select-item', 'select-trigger', 'tab-btn', 'nav-link',
        'badge', 'status-badge', 'tooltip', 'placeholder'
    ];

    // Tag names whose content must never be converted
    var EXCLUDED_TAGS = ['LABEL','BUTTON','A','INPUT','TEXTAREA','SELECT','OPTION',
                         'TH','CAPTION','LEGEND','FIGCAPTION','SMALL','SUP','SUB',
                         'SCRIPT','STYLE','NOSCRIPT','CODE','PRE','KBD','SAMP'];

    // Text patterns that are definitely NOT money (keywords)
    var NON_MONEY_PATTERNS = [
        /\d+\s*(days?|hours?|mins?|minutes?|secs?|seconds?|weeks?|months?|years?)/i,
        /\d+\s*(px|pt|em|rem|vh|vw|%|kb|mb|gb|tb)/i,
        /\d+\s*(mg|ml|kg|g|lb|oz|cm|mm|m|km|ft|in)/i,
        /\d+x\d+/i,         // dimensions like 512x512
        /v\d+\.\d+/i,       // versions like v2.5.3
        /\d+:\d+/,           // times like 8:00
        /\d+\/\d+\/\d+/,    // dates
        /\d+\s*(items?|records?|results?|users?|patients?|doctors?|rooms?|beds?)/i,
        /\d+\s*(attempts?|requests?|messages?)/i,
        /remember\s+me/i,
        /recommended/i,
        /file\s+size/i,
        /max\s+file/i,
        /format/i,
        /size/i
    ];

    function isExcludedElement(el) {
        if (!el || el.nodeType !== 1) return true;
        // Check tag
        if (EXCLUDED_TAGS.indexOf(el.tagName) !== -1) return true;
        // Check if inside excluded tags
        if (el.closest) {
            var excTagSel = EXCLUDED_TAGS.map(function(t){ return t.toLowerCase(); }).join(',');
            if (el.closest(excTagSel)) return true;
            // Check containers that should never have money converted
            if (el.closest('label, button, a, nav, header .tab-btn, [role="tablist"], [role="tab"], .select-dropdown, .select-item, form label, .form-group label')) return true;
        }
        // Check classes
        var cls = (el.className || '');
        if (typeof cls !== 'string') cls = '';
        for (var i = 0; i < EXCLUDED_CLASSES.length; i++) {
            if (cls.indexOf(EXCLUDED_CLASSES[i]) !== -1) return true;
        }
        // Check data-no-convert
        if (el.hasAttribute('data-no-convert')) return true;
        return false;
    }

    function isMoneyText(text) {
        if (!text) return false;
        var t = text.trim();
        // Must be short — real price labels are short
        if (t.length > 30) return false;
        // Must contain a currency symbol
        if (!CURRENCY_SYMBOL_RE.test(t)) return false;
        // Must NOT match any non-money pattern
        for (var i = 0; i < NON_MONEY_PATTERNS.length; i++) {
            if (NON_MONEY_PATTERNS[i].test(t)) return false;
        }
        // Must look like an actual amount: symbol + digits (with optional commas/dots)
        // Allow: $1,234.56  |  1,234 USh  |  KSh 500  |  ₦1,550
        if (/[\d]/.test(t) && CURRENCY_SYMBOL_RE.test(t)) return true;
        return false;
    }

    function parseMoneyText(text) {
        // Strip all currency symbols, keep digits / . / , / - / +
        var clean = text
            .replace(/CA\$/g,'').replace(/USh/g,'').replace(/KSh/g,'')
            .replace(/GH₵/g,'').replace(/TSh/g,'').replace(/FRw/g,'')
            .replace(/[$€£¥₦Br]/g,'')
            .replace(/[^\d.,-]/g,'').trim();
        // European format? 1.234,56
        if (/\d{1,3}(\.\d{3})+(,\d+)?$/.test(clean)) {
            clean = clean.replace(/\./g,'').replace(',','.');
        } else {
            clean = clean.replace(/,/g,'');
        }
        return parseFloat(clean);
    }

    function detectSourceCurrency(text) {
        // Check longest symbols first to avoid false positives (CA$ before $)
        var ordered = ['CA$','USh','KSh','GH₵','TSh','FRw','€','£','¥','₦','Br','$'];
        for (var i = 0; i < ordered.length; i++) {
            if (text.indexOf(ordered[i]) !== -1) {
                // Map symbol to code
                var map = {
                    'CA$':'CAD','USh':'UGX','KSh':'KES','GH₵':'GHS',
                    'TSh':'TZS','FRw':'RWF','€':'EUR','£':'GBP',
                    '¥':'JPY','₦':'NGN','Br':'ETB','$':'USD'
                };
                return map[ordered[i]] || 'USD';
            }
        }
        return 'USD';
    }

    function applyAllCurrencyDisplays() {
        var currKey = getSetting('currency','USD ($)');
        var currCfg = CURRENCIES[currKey] || CURRENCIES['USD ($)'];
        var toCode  = currCfg.code;

        // 1. Re-render already-tagged elements (fast path)
        document.querySelectorAll('[data-usd]').forEach(function(el) {
            if (el.hasAttribute('data-no-convert') || isExcludedElement(el)) return;
            var usd = parseFloat(el.getAttribute('data-usd'));
            if (isNaN(usd)) return;
            el.textContent = formatMoney(convert(usd, 'USD', toCode), currCfg);
        });

        // 2. Scan for new untagged money elements
        // Walk all text nodes
        var walker = document.createTreeWalker(
            document.body || document.documentElement,
            NodeFilter.SHOW_TEXT,
            {
                acceptNode: function(node) {
                    var p = node.parentElement;
                    if (!p) return NodeFilter.FILTER_SKIP;
                    if (p.hasAttribute('data-usd') || p.hasAttribute('data-no-convert')) return NodeFilter.FILTER_SKIP;
                    if (isExcludedElement(p)) return NodeFilter.FILTER_SKIP;
                    if (isMoneyText(node.textContent)) return NodeFilter.FILTER_ACCEPT;
                    return NodeFilter.FILTER_SKIP;
                }
            }
        );

        var toProcess = [];
        while (walker.nextNode()) {
            toProcess.push(walker.currentNode.parentElement);
        }

        // Deduplicate
        var seen = new Set ? new Set() : { _d:{}, has:function(x){return !!this._d[x];}, add:function(x){this._d[x]=true;} };
        toProcess.forEach(function(el) {
            if (!el || seen.has(el)) return;
            seen.add(el);
            if (el.hasAttribute('data-usd') || isExcludedElement(el)) return;

            var text = el.textContent.trim();
            if (!isMoneyText(text)) return;

            var fromCode = detectSourceCurrency(text);
            var amount   = parseMoneyText(text);
            if (isNaN(amount) || amount === 0) return;

            // Store as canonical USD
            var asUSD = convert(amount, fromCode, 'USD');
            el.setAttribute('data-usd', asUSD.toFixed(6));
            el.setAttribute('data-original-text', text);

            el.textContent = formatMoney(convert(asUSD, 'USD', toCode), currCfg);
        });
    }

    window.refreshAllCurrencyDisplays = applyAllCurrencyDisplays;
    window.markAsFixedAmount = function(el, usdAmount) { el.setAttribute('data-usd', usdAmount); };
    window.markAsNoConvert   = function(el) { el.setAttribute('data-no-convert','1'); };

    // ============================================
// GLOBAL DATE & TIME FORMATTER
// ============================================
window.refreshAllDates = function() {
    const dateFormat = getSetting('date_format', 'MM/DD/YYYY');
    const timeFormat = getSetting('time_format', '12-hour (AM/PM)');

    const walker = document.createTreeWalker(
        document.body,
        NodeFilter.SHOW_TEXT,
        {
            acceptNode: function(node) {
                const parent = node.parentElement;
                if (!parent) return NodeFilter.FILTER_SKIP;
                
                // Skip interactive and structural elements
                if (parent.closest('script, style, input, textarea, select, button, [contenteditable]')) {
                    return NodeFilter.FILTER_SKIP;
                }

                const text = node.textContent.trim();
                if (text.length < 4 || text.length > 60) return NodeFilter.FILTER_SKIP;

                // Common date patterns
                if (
                    /\b(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*\.?\s+\d{1,2},?\s+\d{4}\b/i.test(text) ||  // May 15, 2023
                    /\b\d{1,2}[-\/]\d{1,2}[-\/]\d{2,4}\b/.test(text) ||                                                // 04/13/2026 or 13-04-2026
                    /\b\d{4}[-\/]\d{1,2}[-\/]\d{1,2}\b/.test(text) ||                                                 // 2026-04-13
                    /\b(Today|Tomorrow|Yesterday)\b/i.test(text) ||                                                    // Today, Tomorrow
                    /\b\d{1,2}:\d{2}\s*(AM|PM)\b/i.test(text)                                                        // 09:45 AM
                ) {
                    return NodeFilter.FILTER_ACCEPT;
                }
                return NodeFilter.FILTER_SKIP;
            }
        }
    );

    let node;
    while ((node = walker.nextNode())) {
        let text = node.textContent;
        let originalText = text;

        // Replace full dates
        text = text.replace(/\b(\d{1,2})[-\/](\d{1,2})[-\/](\d{4})\b/g, (match, m1, m2, year) => {
            const d = new Date(year, m2-1, m1);
            return isNaN(d) ? match : formatDate(d);
        });

        text = text.replace(/\b(\d{4})[-\/](\d{1,2})[-\/](\d{1,2})\b/g, (match, year, m1, m2) => {
            const d = new Date(year, m1-1, m2);
            return isNaN(d) ? match : formatDate(d);
        });

        // Replace month name dates
        text = text.replace(/\b(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec)[a-z]*\.?\s+(\d{1,2}),?\s+(\d{4})\b/gi, (match, monthName, day, year) => {
            const monthMap = {"jan":0,"feb":1,"mar":2,"apr":3,"may":4,"jun":5,"jul":6,"aug":7,"sep":8,"oct":9,"nov":10,"dec":11};
            const m = monthMap[monthName.toLowerCase().slice(0,3)];
            const d = new Date(year, m, day);
            return isNaN(d) ? match : formatDate(d);
        });

        // Replace time
        text = text.replace(/\b(\d{1,2}):(\d{2})\s*(AM|PM)?\b/gi, (match, h, m, ampm) => {
            let hour = parseInt(h);
            if (timeFormat === '24-hour') {
                if (ampm === 'PM' && hour < 12) hour += 12;
                if (ampm === 'AM' && hour === 12) hour = 0;
                return `${hour.toString().padStart(2,'0')}:${m}`;
            }
            return match; // Keep 12-hour as is for now
        });

        if (text !== originalText) {
            node.textContent = text;
        }
    }

    console.log('✅ Date formatting applied across the page');
};

// ============================================
    // LOGO / FAVICON
    // ============================================
    function applyLogo() {
        var logo = getSetting('logo_base64');
        if (!logo) return;
        document.querySelectorAll(
            'aside img[alt="Meditrack"], aside img[alt="Medi-track"], ' +
            'aside a[href="index.html"] img, #headerLogo img, img.logo, img#appLogo'
        ).forEach(function(img){ img.src = logo; });
        // Update settings page preview if open
        var prev = document.getElementById('logoPreview');
        if (prev) { prev.src = logo; prev.classList.remove('hidden'); }
        var ph = document.getElementById('logoPlaceholder');
        if (ph) ph.classList.add('hidden');
    }

    function resetLogo() {
        setSetting('logo_base64', null);
        document.querySelectorAll(
            'aside img[alt="Meditrack"], aside img[alt="Medi-track"], ' +
            'aside a[href="index.html"] img, #headerLogo img, img.logo, img#appLogo'
        ).forEach(function(img){ img.src = 'logo.png'; });
        var prev = document.getElementById('logoPreview');
        if (prev) { prev.src = 'logo.png'; prev.classList.add('hidden'); }
        var ph = document.getElementById('logoPlaceholder');
        if (ph) ph.classList.remove('hidden');
        var inp = document.getElementById('logoFileInput');
        if (inp) inp.value = '';
    }

    function applyFavicon() {
        var fav = getSetting('favicon_base64');
        if (!fav) return;
        var link = document.querySelector("link[rel*='icon']");
        if (!link) { link = document.createElement('link'); link.rel = 'icon'; document.head.appendChild(link); }
        link.href = fav;
        // Update settings page preview if open
        var prev = document.getElementById('faviconPreview');
        if (prev) { prev.src = fav; prev.classList.remove('hidden'); }
        var ph = document.getElementById('faviconPlaceholder');
        if (ph) ph.classList.add('hidden');
    }

    function resetFavicon() {
        setSetting('favicon_base64', null);
        var link = document.querySelector("link[rel*='icon']");
        if (link) link.href = 'logo.png';
        var prev = document.getElementById('faviconPreview');
        if (prev) { prev.src = 'logo.png'; prev.classList.add('hidden'); }
        var ph = document.getElementById('faviconPlaceholder');
        if (ph) ph.classList.remove('hidden');
        var inp = document.getElementById('faviconFileInput');
        if (inp) inp.value = '';
    }

    function initLogoUpload() {
        var btn  = document.getElementById('uploadLogoBtn');
        var inp  = document.getElementById('logoFileInput');
        if (!btn || !inp) return;

        btn.addEventListener('click', function(){ inp.click(); });
        inp.addEventListener('change', function(e){
            var file = e.target.files[0]; if (!file) return;
            if (file.size > 2 * 1024 * 1024) { showToast('File too large. Max 2MB.', true); return; }
            var reader = new FileReader();
            reader.onload = function(ev){
                setSetting('logo_base64', ev.target.result);
                applyLogo();
                showToast('Logo updated successfully.');
            };
            reader.readAsDataURL(file);
        });
    }

    function initFaviconUpload() {
        var btn  = document.getElementById('uploadFaviconBtn');
        var inp  = document.getElementById('faviconFileInput');
        if (!btn || !inp) return;

        btn.addEventListener('click', function(){ inp.click(); });
        inp.addEventListener('change', function(e){
            var file = e.target.files[0]; if (!file) return;
            if (file.size > 512 * 1024) { showToast('Favicon too large. Max 512KB.', true); return; }
            var reader = new FileReader();
            reader.onload = function(ev){
                setSetting('favicon_base64', ev.target.result);
                applyFavicon();
                showToast('Favicon updated successfully.');
            };
            reader.readAsDataURL(file);
        });
    }

    // ============================================
    // RESET BRANDING (called by resetBrandingBtn)
    // ============================================
function resetBranding() {
    // Reset colors to original defaults
    setSetting('primary_color', '#4f46e5');
    setSetting('secondary_color', '#7c3aed');

    // Reset theme
    setSetting('theme_mode', 'light');

    // Reset logo and favicon
    setSetting('logo_base64', null);
    setSetting('favicon_base64', null);

    // Reset email templates
    setSetting('emailHeader', 'Medi-track Clinic - Your Health, Our Priority');
    setSetting('emailFooter', '© 2025 Medi-track Clinic. All rights reserved. 123 Medical Plaza, Healthcare District, City, State, 12345');

    // Clear dynamic style elements
    const primaryStyle = document.getElementById('meditrack-primary-styles');
    const secondaryStyle = document.getElementById('meditrack-secondary-styles');
    if (primaryStyle) primaryStyle.textContent = '';
    if (secondaryStyle) secondaryStyle.textContent = '';

    // Re-apply everything
    applyColorScheme();
    applyTheme();
    applyLogo();
    applyFavicon();

    // Dispatch event so settings page can refresh UI
    window.dispatchEvent(new CustomEvent('meditrack-settings-reset'));

    showToast('Branding reset to defaults successfully.');
}

// Reset Branding
document.getElementById('resetBrandingBtn')?.addEventListener('click', () => {
    if (window.MeditrackSettings && typeof window.MeditrackSettings.resetBranding === 'function') {
        window.MeditrackSettings.resetBranding();
        
        // Refresh form fields and color pickers
        setTimeout(() => {
            loadForm();
        }, 100);
    } else {
        // Fallback if function doesn't exist
        showToast('Reset function not available', true);
    }
});

    // ============================================
    // PROTECT NON-MONEY ELEMENTS on settings page
    // ============================================
    function protectSettingsPageText() {
        // Mark elements that contain size/format hints as no-convert
        var selectors = [
            '#logoFileInput + *',  // siblings of file inputs
            '.text-xs',            // all tiny helper text
            'p.text-xs',
            'small',
            'label',
            'button',
            '[placeholder]'
        ];
        try {
            document.querySelectorAll(selectors.join(',')).forEach(function(el){
                el.setAttribute('data-no-convert','1');
            });
        } catch(e) {}

        // Specifically protect the file-size hint paragraphs by content
        document.querySelectorAll('p, span, div').forEach(function(el){
            var t = (el.textContent || '').trim();
            if (/recommended|file size|format|ICO|PNG|JPG|SVG|512x512|32x32|2MB|512KB/i.test(t)) {
                el.setAttribute('data-no-convert','1');
            }
        });
    }

    // ============================================
    // COLOR SCHEME
    // ============================================
    function hexToRgb(hex) {
        var r = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
        return r ? {r:parseInt(r[1],16),g:parseInt(r[2],16),b:parseInt(r[3],16)} : null;
    }
    function shadeColor(hex, pct) {
        var rgb = hexToRgb(hex); if (!rgb) return hex;
        var s = function(c){ return Math.min(255,Math.max(0,Math.round(c+c*pct/100))); };
        return 'rgb('+s(rgb.r)+','+s(rgb.g)+','+s(rgb.b)+')';
    }
    function alphaColor(hex, a) {
        var rgb = hexToRgb(hex); if (!rgb) return hex;
        return 'rgba('+rgb.r+','+rgb.g+','+rgb.b+','+a+')';
    }

function applyColorScheme() {
    var pc = getSetting('primary_color');
    var sc = getSetting('secondary_color');
    if (!pc && !sc) return;

    const root = document.documentElement;

    if (pc) {
        root.style.setProperty('--primary-color', pc);
        root.style.setProperty('--color-primary', pc);
        root.style.setProperty('--primary', pc);

        // Better contrast handling
        const isLight = isColorLight(pc);
        const textColor = isLight ? '#1f2937' : '#ffffff';

        let primaryStyles = `
            .bg-primary,
            button.bg-primary,
            .bg-primary\\/10 {
                background-color: ${pc} !important;
            }
            .text-primary,
            .text-primary\\/90 {
                color: ${pc} !important;
            }
            .border-primary {
                border-color: ${pc} !important;
            }
            .switch-root[data-state="checked"],
            input[type="checkbox"]:checked,
            input[type="radio"]:checked {
                background-color: ${pc} !important;
                accent-color: ${pc} !important;
            }
            .tab-btn.active,
            .tab-btn[data-state="active"] {
                color: ${pc} !important;
                box-shadow: inset 0 -2px 0 ${pc} !important;
            }
            aside nav a.bg-primary\\/10,
            aside nav a.text-primary {
                background-color: ${alphaColor(pc, 0.1)} !important;
                color: ${pc} !important;
            }
            .hover\\:bg-primary:hover,
            button.bg-primary:hover {
                background-color: ${shadeColor(pc, -8)} !important;
            }
            input:focus, textarea:focus, select:focus {
                border-color: ${pc} !important;
                box-shadow: 0 0 0 3px ${alphaColor(pc, 0.2)} !important;
            }
        `;

        // Only add text color if needed
        if (!isLight) {
            primaryStyles += `
                .bg-primary, button.bg-primary { color: ${textColor} !important; }
            `;
        }

        let styleEl = document.getElementById('meditrack-primary-styles');
        if (!styleEl) {
            styleEl = document.createElement('style');
            styleEl.id = 'meditrack-primary-styles';
            document.head.appendChild(styleEl);
        }
        styleEl.textContent = primaryStyles;
    }

    if (sc) {
        root.style.setProperty('--secondary-color', sc);

        let styleEl2 = document.getElementById('meditrack-secondary-styles');
        if (!styleEl2) {
            styleEl2 = document.createElement('style');
            styleEl2.id = 'meditrack-secondary-styles';
            document.head.appendChild(styleEl2);
        }
        styleEl2.textContent = `
            .bg-secondary { background-color: ${sc} !important; }
            .text-secondary { color: ${sc} !important; }
            .border-secondary { border-color: ${sc} !important; }
        `;
    }
}

// Helper function
function isColorLight(hex) {
    const rgb = hexToRgb(hex);
    if (!rgb) return true;
    const luminance = (0.299 * rgb.r + 0.587 * rgb.g + 0.114 * rgb.b) / 255;
    return luminance > 0.6;
}

// ============================================
    // THEME
    // ============================================
    function applyTheme() {
        var mode = getSetting('theme_mode','light');
        var dark = mode === 'dark' || (mode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
        document.body.classList.toggle('dark', dark);
        document.documentElement.classList.toggle('dark', dark);
        var sun  = document.getElementById('sunIcon');
        var moon = document.getElementById('moonIcon');
        if (sun)  sun.classList.toggle('hidden', !dark);
        if (moon) moon.classList.toggle('hidden', dark);
    }

    // ============================================
    // CLINIC NAME
    // ============================================
    function applyClinicName() {
        var name = getSetting('clinicName');
        if (!name) return;
        var s = document.querySelector('aside .font-bold.inline-block, aside .font-bold');
        if (s) s.textContent = name;
        var h = document.querySelector('#headerLogo span');
        if (h) h.textContent = name;
        if (document.title && document.title.indexOf('|') !== -1) {
            document.title = name + ' | ' + document.title.split('|').slice(1).join('|').trim();
        }
    }

    // ============================================
    // MAINTENANCE BANNER
    // ============================================
    function applyMaintenance() {
        var on = getSetting('maintenance_mode', false);
        var isSettings = window.location.href.indexOf('settings.html') !== -1;
        if (on && !isSettings && !document.getElementById('maintenanceBanner')) {
            var b = document.createElement('div');
            b.id = 'maintenanceBanner';
            b.style.cssText = 'position:fixed;top:0;left:0;right:0;background:#f59e0b;color:#000;text-align:center;padding:8px;z-index:10000;font-weight:bold;font-size:14px;';
            b.textContent = '⚠️ MAINTENANCE MODE ACTIVE — Read Only Access';
            document.body.prepend(b);
        }
        if (!on) {
            var ex = document.getElementById('maintenanceBanner');
            if (ex) ex.remove();
        }
    }

    // ============================================
    // DATE / TIME
    // ============================================
    window.formatDate = function(date) {
        var fmt = getSetting('date_format','MM/DD/YYYY');
        var d = new Date(date); if (isNaN(d)) return '';
        var dd = String(d.getDate()).padStart(2,'0'), mm = String(d.getMonth()+1).padStart(2,'0'), yy = d.getFullYear();
        if (fmt==='DD/MM/YYYY') return dd+'/'+mm+'/'+yy;
        if (fmt==='YYYY-MM-DD') return yy+'-'+mm+'-'+dd;
        return mm+'/'+dd+'/'+yy;
    };
    window.formatTime = function(date) {
        var fmt = getSetting('time_format','12-hour (AM/PM)');
        var d = new Date(date); if (isNaN(d)) return '';
        var h = d.getHours(), m = String(d.getMinutes()).padStart(2,'0');
        if (fmt==='24-hour') return String(h).padStart(2,'0')+':'+m;
        var ap = h>=12?'PM':'AM'; h = h%12||12;
        return h+':'+m+' '+ap;
    };

    function applySecuritySettings() {
    // This runs on every page load - can be used to enforce session timeout, etc.
    // For now, it's a placeholder that logs if in debug mode
    if (window.MeditrackDebug) {
        console.log('[Security] Policy loaded:', window.getPasswordPolicy());
    }
}

// ============================================
// FULLSCREEN TOGGLE
// ============================================
function initFullscreenToggle() {
    var btn = document.getElementById('fullscreenToggleBtn');
    var enterIcon = document.getElementById('fullscreenEnterIcon');
    var exitIcon = document.getElementById('fullscreenExitIcon');
    
    if (!btn || !enterIcon || !exitIcon) return;
    
    function updateIcons() {
        var isFullscreen = !!(document.fullscreenElement || 
                             document.webkitFullscreenElement || 
                             document.mozFullScreenElement || 
                             document.msFullscreenElement);
        
        if (isFullscreen) {
            enterIcon.classList.add('hidden');
            exitIcon.classList.remove('hidden');
            btn.setAttribute('aria-label', 'Exit fullscreen');
        } else {
            enterIcon.classList.remove('hidden');
            exitIcon.classList.add('hidden');
            btn.setAttribute('aria-label', 'Enter fullscreen');
        }
    }
    
    function toggleFullscreen() {
        if (!document.fullscreenElement && 
            !document.webkitFullscreenElement && 
            !document.mozFullScreenElement && 
            !document.msFullscreenElement) {
            // Enter fullscreen
            var elem = document.documentElement;
            if (elem.requestFullscreen) {
                elem.requestFullscreen().catch(function(err) {
                    console.warn('Fullscreen request failed:', err);
                    showToast('Fullscreen mode not supported or was denied', true);
                });
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen();
            } else if (elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            }
        } else {
            // Exit fullscreen
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
        }
    }
    
    btn.addEventListener('click', toggleFullscreen);
    
    // Listen for fullscreen changes
    document.addEventListener('fullscreenchange', updateIcons);
    document.addEventListener('webkitfullscreenchange', updateIcons);
    document.addEventListener('mozfullscreenchange', updateIcons);
    document.addEventListener('MSFullscreenChange', updateIcons);
    
    // Initial icon state
    updateIcons();
    
    // Save fullscreen preference
    window.addEventListener('fullscreenchange', function() {
        var isFullscreen = !!document.fullscreenElement;
        setSetting('fullscreen_mode', isFullscreen);
    });
    
    console.log('✅ Fullscreen toggle initialized');
}

// ============================================
// KEYBOARD SHORTCUT FOR FULLSCREEN (F11)
// ============================================
function initFullscreenKeyboardShortcut() {
    document.addEventListener('keydown', function(e) {
        // F11 key or Ctrl+Shift+F
        if (e.key === 'F11' || (e.ctrlKey && e.shiftKey && e.key === 'F')) {
            e.preventDefault();
            var btn = document.getElementById('fullscreenToggleBtn');
            if (btn) btn.click();
        }
    });
}


    // ============================================
    // TOAST
    // ============================================
    function showToast(msg, isError) {
        var existing = document.querySelectorAll('.meditrack-toast');
        existing.forEach(function(t){ t.remove(); });
        var t = document.createElement('div');
        t.className = 'meditrack-toast';
        t.style.cssText = 'position:fixed;bottom:20px;right:20px;background:'+(isError?'#ef4444':'#10b981')+';color:#fff;padding:12px 20px;border-radius:8px;z-index:9999;font-size:14px;box-shadow:0 4px 12px rgba(0,0,0,.15);animation:slideIn 0.3s ease-out;max-width:380px;';
        t.textContent = msg;
        document.body.appendChild(t);
        setTimeout(function(){ t.style.opacity='0'; t.style.transition='opacity 0.3s'; setTimeout(function(){ t.remove(); }, 300); }, 3000);
    }
    window.meditrackToast = showToast;

    // ============================================
    // APPLY ALL
    // ============================================
    function applyAll() {
        applyTheme();
        applyColorScheme();
        applyLogo();
        applyFavicon();
        applyClinicName();
        applyMaintenance();
        applySecuritySettings();
    }

    // ============================================
    // CROSS-TAB SYNC
    // ============================================
    window.addEventListener('storage', function(e) {
        if (!e.key || e.key.indexOf('meditrack_') !== 0) return;
        applyAll();
        if (e.key === 'meditrack_currency') applyAllCurrencyDisplays();
    });
    window.addEventListener('meditrack-setting-changed', function(e) {
        applyAll();
        if (e.detail && e.detail.key === 'currency') applyAllCurrencyDisplays();
    });
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function() {
        if (getSetting('theme_mode','light') === 'system') applyTheme();
    });

    // ============================================
    // MUTATION OBSERVER
    // ============================================
    var moTimer;
    var mo = new MutationObserver(function(muts) {
        var needs = false;
        muts.forEach(function(m){
            m.addedNodes.forEach(function(n){
                if (n.nodeType===1 && CURRENCY_SYMBOL_RE.test(n.textContent||'')) needs = true;
            });
        });
        if (needs) { clearTimeout(moTimer); moTimer = setTimeout(applyAllCurrencyDisplays, 200); }
    });

    // ============================================
    // PUBLIC API
    // ============================================
    window.MeditrackSettings = {
        get: getSetting,
        set: setSetting,
        resetBranding: resetBranding,
        onChange: function(cb) {
            window.addEventListener('meditrack-setting-changed', function(e) {
                cb({ key: e.detail.key, newValue: e.detail.value, fromOtherTab: false });
            });
            window.addEventListener('storage', function(e) {
                if (e.key && e.key.indexOf('meditrack_') === 0) {
                    cb({ key: e.key.replace('meditrack_',''), newValue: e.newValue, fromOtherTab: true });
                }
            });
        }
    };

    window.MeditrackCurrency = {
        setCurrency: function(str) {
            setSetting('currency', str);
            applyAllCurrencyDisplays();
        },
        getAll:   function(){ return Object.keys(CURRENCIES); },
        format:   function(amount){ return window.formatCurrency(amount); },
        refresh:  applyAllCurrencyDisplays
    };

    window.refreshAllCurrencyDisplays = applyAllCurrencyDisplays;
    window.refreshMeditrackSettings    = applyAll;


    // ============================================
    // INIT
    // ============================================
    function init() {
        loadRates();
        applyAll();
        initLogoUpload();
        initFaviconUpload();
        initFullscreenToggle();
        initResetBranding();
        protectSettingsPageText();

        applyAllCurrencyDisplays();
        setTimeout(applyAllCurrencyDisplays, 400);
        setTimeout(applyAllCurrencyDisplays, 1000);
        setTimeout(applyAllCurrencyDisplays, 2000);

        setTimeout(function(){
            if (document.body) mo.observe(document.body, { childList: true, subtree: true });
        }, 600);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
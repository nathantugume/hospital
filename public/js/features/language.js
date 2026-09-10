// ============================================
// LANGUAGE MODULE - Free Google Translate integration
// Uses Google's public translate API (no key required)
// ============================================
(function (window, document) {
    'use strict';

    var LANGUAGE_KEY = 'meditrack_language';
    var currentLang = 'en';
    var googleTranslateLoaded = false;
    var googleTranslateInitStarted = false;

    // Map language codes to Google Translate supported codes
    var LANG_MAP = {
        'English': 'en',
        'Spanish': 'es',
        'French': 'fr',
        'German': 'de',
        'Chinese': 'zh-CN',
        'Arabic': 'ar',
        'Portuguese': 'pt',
        'Swahili': 'sw'
    };

    // Reverse map for display
    var LANG_NAMES = {
        'en': 'English',
        'es': 'Español',
        'fr': 'Français',
        'de': 'Deutsch',
        'zh-CN': '中文',
        'ar': 'العربية',
        'pt': 'Português',
        'sw': 'Kiswahili'
    };

    // ============================================
    // METHOD 1: Google Translate Element (no API key needed)
    // Uses the free Google Translate website widget
    // ============================================

    function loadGoogleTranslateWidget() {
        if (googleTranslateInitStarted) return;
        googleTranslateInitStarted = true;

        // Create a hidden div for Google Translate
        var gtDiv = document.createElement('div');
        gtDiv.id = 'google_translate_element';
        gtDiv.style.cssText = 'position:fixed;top:-9999px;left:-9999px;z-index:-1;';
        document.body.appendChild(gtDiv);

        // Google Translate callback
        window.googleTranslateElementInit = function() {
            googleTranslateLoaded = true;
            // Apply saved language if not English
            var savedLang = getSavedLanguage();
            if (savedLang && savedLang !== 'en') {
                setTimeout(function() {
                    changeGoogleTranslateLanguage(savedLang);
                }, 500);
            }
        };

        // Load the Google Translate script
        var script = document.createElement('script');
        script.src = 'https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
        script.async = true;
        document.head.appendChild(script);

        // Initialize the translate element after script loads
        var checkInterval = setInterval(function() {
            if (window.google && window.google.translate) {
                clearInterval(checkInterval);
                try {
                    new window.google.translate.TranslateElement({
                        pageLanguage: 'en',
                        includedLanguages: 'en,es,fr,de,zh-CN,ar,pt,sw',
                        layout: window.google.translate.TranslateElement.InlineLayout.SIMPLE,
                        autoDisplay: false
                    }, 'google_translate_element');
                } catch(e) {
                    console.warn('Google Translate init error:', e);
                    googleTranslateLoaded = true;
                }
            }
        }, 200);

        // Timeout fallback
        setTimeout(function() {
            clearInterval(checkInterval);
            googleTranslateLoaded = true;
        }, 10000);
    }

    function changeGoogleTranslateLanguage(langCode) {
        if (!window.google || !window.google.translate) {
            // Retry in 500ms
            setTimeout(function() { changeGoogleTranslateLanguage(langCode); }, 500);
            return;
        }

        try {
            // Find the Google Translate iframe and change its language
            var iframe = document.querySelector('.goog-te-menu-frame, iframe[src*="translate"]');
            if (iframe) {
                var select = iframe.contentDocument?.querySelector('select');
                if (select) {
                    select.value = langCode;
                    select.dispatchEvent(new Event('change'));
                    return;
                }
            }

            // Alternative: trigger via cookie method
            var cookiePath = '/';
            var cookieDomain = '';
            document.cookie = 'googtrans=/en/' + langCode + ';path=' + cookiePath + 
                            ';domain=' + cookieDomain + ';expires=' + 
                            new Date(Date.now() + 365*24*60*60*1000).toUTCString();
            
            // Reload the translate element
            var gtDiv = document.getElementById('google_translate_element');
            if (gtDiv) {
                gtDiv.innerHTML = '';
                new window.google.translate.TranslateElement({
                    pageLanguage: 'en',
                    includedLanguages: 'en,es,fr,de,zh-CN,ar,pt,sw',
                    layout: window.google.translate.TranslateElement.InlineLayout.SIMPLE,
                    autoDisplay: false
                }, 'google_translate_element');
            }
        } catch(e) {
            console.warn('Google Translate language change error:', e);
        }
    }

    function restoreEnglish() {
        try {
            document.cookie = 'googtrans=/en/en;path=/;expires=' + 
                            new Date(Date.now() + 365*24*60*60*1000).toUTCString();
            var gtDiv = document.getElementById('google_translate_element');
            if (gtDiv) {
                gtDiv.innerHTML = '';
                if (window.google && window.google.translate) {
                    new window.google.translate.TranslateElement({
                        pageLanguage: 'en',
                        includedLanguages: 'en,es,fr,de,zh-CN,ar,pt,sw',
                        layout: window.google.translate.TranslateElement.InlineLayout.SIMPLE,
                        autoDisplay: false
                    }, 'google_translate_element');
                }
            }
        } catch(e) {
            // Fallback: reload page
            window.location.reload();
        }
    }

    // ============================================
    // STORAGE HELPERS
    // ============================================
    function getSavedLanguage() {
        var saved = null;
        if (window.MeditrackSettings) {
            saved = window.MeditrackSettings.get('language');
        }
        if (!saved) {
            saved = localStorage.getItem(LANGUAGE_KEY);
        }
        return saved || 'English';
    }

    function setSavedLanguage(langName) {
        if (window.MeditrackSettings) {
            window.MeditrackSettings.set('language', langName);
        }
        localStorage.setItem(LANGUAGE_KEY, langName);
    }

    // ============================================
    // PUBLIC API
    // ============================================
    function switchLanguage(langName) {
        if (langName === currentLang) return;

        var langCode = LANG_MAP[langName] || 'en';
        
        setSavedLanguage(langName);

        if (langCode === 'en') {
            restoreEnglish();
        } else {
            if (!googleTranslateLoaded) {
                loadGoogleTranslateWidget();
            }
            changeGoogleTranslateLanguage(langCode);
        }

        currentLang = langName;

        // Update the dropdown display
        var langSelected = document.getElementById('languageSelected');
        if (langSelected) {
            langSelected.textContent = langName;
        }

        // Update html lang attribute
        document.documentElement.lang = langCode;

        // Show toast
        if (window.MeditrackNotifications && window.MeditrackNotifications.showToast) {
            window.MeditrackNotifications.showToast('Language changed to ' + langName);
        } else if (window.meditrackToast) {
            window.meditrackToast('Language changed to ' + langName);
        }
    }

    function init() {
        currentLang = getSavedLanguage();

        // Update dropdown display
        var langSelected = document.getElementById('languageSelected');
        if (langSelected) {
            langSelected.textContent = currentLang;
        }

        // If not English, load the translate widget
        var langCode = LANG_MAP[currentLang] || 'en';
        if (langCode !== 'en') {
            loadGoogleTranslateWidget();
        }

        // Update html lang attribute
        document.documentElement.lang = langCode;
    }

    // ============================================
    // INIT
    // ============================================
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // Expose public API
    window.MeditrackLanguage = {
        switchLanguage: switchLanguage,
        getCurrentLanguage: function() { return currentLang; },
        getLangCode: function() { return LANG_MAP[currentLang] || 'en'; },
        getSupportedLanguages: function() { return Object.keys(LANG_MAP); }
    };

})(window, document);
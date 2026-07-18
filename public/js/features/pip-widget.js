// ============================================
// PIP WIDGET MODULE  v3.0
// Picture-in-Picture call widget that persists
// across ALL 150+ pages via sessionStorage.
//
// How it works:
//   chat.html  → saves pipData to sessionStorage when minimising
//   every page → pip-widget.js reads pipData on load and renders
//                a draggable floating widget
//   Expand btn → returns to chat.html and restores the call modal
//   End btn    → clears sessionStorage, removes widget
// ============================================
(function (window, document) {
    'use strict';

    // ─── SVG icon library ───────────────────────────────────────────────────
    var I = {
        muteOn:  '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19v3"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><rect x="9" y="2" width="6" height="13" rx="3"/></svg>',
        muteOff: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19v3"/><path d="M15 9.34V5a3 3 0 0 0-5.68-1.33"/><path d="M16.95 16.95A7 7 0 0 1 5 12v-2"/><path d="M18.89 13.23A7 7 0 0 0 19 12v-2"/><path d="m2 2 20 20"/><path d="M9 9v3a3 3 0 0 0 5.12 2.12"/></svg>',
        spkOn:   '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"/><path d="M16 9a5 5 0 0 1 0 6"/><path d="M19.364 18.364a9 9 0 0 0 0-12.728"/></svg>',
        spkOff:  '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4.702a.705.705 0 0 0-1.203-.498L6.413 7.587A1.4 1.4 0 0 1 5.416 8H3a1 1 0 0 0-1 1v6a1 1 0 0 0 1 1h2.416a1.4 1.4 0 0 1 .997.413l3.383 3.384A.705.705 0 0 0 11 19.298z"/><line x1="22" x2="16" y1="9" y2="15"/><line x1="16" x2="22" y1="9" y2="15"/></svg>',
        camOn:   '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M13.997 4a2 2 0 0 1 1.76 1.05l.486.9A2 2 0 0 0 18.003 7H20a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1.997a2 2 0 0 0 1.759-1.048l.489-.904A2 2 0 0 1 10.004 4z"/><circle cx="12" cy="13" r="3"/></svg>',
        camOff:  '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.564 14.558a3 3 0 1 1-4.122-4.121"/><path d="m2 2 20 20"/><path d="M20 20H4a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1.997a2 2 0 0 0 .819-.175"/><path d="M9.695 4.024A2 2 0 0 1 10.004 4h3.993a2 2 0 0 1 1.76 1.05l.486.9A2 2 0 0 0 18.003 7H20a2 2 0 0 1 2 2v7.344"/></svg>',
        // Expand = arrows pointing inward (restore to full call)
        expand:  '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m14 10 7-7"/><path d="M20 10h-6V4"/><path d="m3 21 7-7"/><path d="M4 14h6v6"/></svg>',
        // Phone call icon for audio label
        phone:   '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
        // Video camera icon
        video:   '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"/><rect x="2" y="6" width="14" height="12" rx="2"/></svg>',
        endSvg:  '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18.59 5.41L5.41 18.59"/><path d="M5.41 5.41l13.18 13.18"/></svg>'
    };

    // ─── Helpers ──────────────────────────────────────────────────────────────
    function esc(s) {
        return String(s || '').replace(/[&<>"']/g, function(c){
            return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c];
        });
    }

    function fmt(secs) {
        var h = Math.floor(secs / 3600),
            m = Math.floor((secs % 3600) / 60),
            s = secs % 60;
        return [h, m, s].map(function(n){ return String(n).padStart(2,'0'); }).join(':');
    }

    function persist(patch) {
        try {
            var d = JSON.parse(sessionStorage.getItem('pipData') || '{}');
            Object.assign(d, patch);
            sessionStorage.setItem('pipData', JSON.stringify(d));
        } catch(e) {}
    }

    function isOnChatPage() {
        return window.location.pathname.split('/').pop() === 'chat.html';
    }

    // ─── STYLES (injected once) ──────────────────────────────────────────────
    var WIDGET_CSS = `
    #pip-widget {
        position: fixed; bottom: 20px; right: 20px; z-index: 99999;
        font-family: 'Inter', system-ui, sans-serif;
        user-select: none; pointer-events: auto;
    }
    #pip-widget * { box-sizing: border-box; }
    #pip-widget .pw-wrap {
        background: #0f0f1a; border-radius: 14px;
        box-shadow: 0 12px 40px rgba(0,0,0,.55), 0 0 0 1px rgba(255,255,255,.06);
        overflow: hidden; min-width: 280px; max-width: 320px;
        animation: pipSlideIn .25s cubic-bezier(.34,1.56,.64,1) both;
    }
    #pip-widget .pw-wrap.pw-video { min-width: 340px; max-width: 380px; }
    @keyframes pipSlideIn {
        from { opacity:0; transform:translateY(16px) scale(.95); }
        to   { opacity:1; transform:translateY(0) scale(1); }
    }
    /* Header */
    #pip-widget .pw-hdr {
        display:flex; align-items:center; justify-content:space-between;
        padding:8px 10px 8px 12px; background:#16162a; cursor:move; gap:8px;
        border-bottom:1px solid rgba(255,255,255,.07);
    }
    #pip-widget .pw-hdr-l { display:flex; align-items:center; gap:9px; min-width:0; }
    #pip-widget .pw-avatar {
        width:30px; height:30px; border-radius:50%; flex-shrink:0;
        background:linear-gradient(135deg,#6366f1,#8b5cf6);
        display:flex; align-items:center; justify-content:center;
        font-size:13px; font-weight:700; color:#fff;
    }
    #pip-widget .pw-info { min-width:0; }
    #pip-widget .pw-name {
        font-size:12px; font-weight:600; color:#e2e8f0;
        white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:130px;
    }
    #pip-widget .pw-meta {
        display:flex; align-items:center; gap:5px;
        font-size:10px; color:#64748b; margin-top:1px;
    }
    #pip-widget .pw-meta-dot { width:6px; height:6px; border-radius:50%; background:#22c55e; flex-shrink:0; animation:pipPulse 2s ease infinite; }
    @keyframes pipPulse { 0%,100%{opacity:1;} 50%{opacity:.4;} }
    #pip-widget .pw-timer { font-size:11px; color:#f59e0b; font-family:monospace; font-weight:600; }
    #pip-widget .pw-hdr-r { display:flex; gap:3px; flex-shrink:0; }
    /* Icon buttons */
    #pip-widget .pw-icon-btn {
        background:transparent; border:none; color:#94a3b8; cursor:pointer;
        width:28px; height:28px; border-radius:7px; display:flex;
        align-items:center; justify-content:center; transition:all .15s;
    }
    #pip-widget .pw-icon-btn:hover { background:rgba(255,255,255,.1); color:#e2e8f0; }
    #pip-widget .pw-icon-btn.expand-btn { color:#a5b4fc; }
    #pip-widget .pw-icon-btn.expand-btn:hover { background:rgba(99,102,241,.2); color:#818cf8; }
    /* Video preview */
    #pip-widget .pw-video-frame {
        position:relative; margin:8px 8px 0; border-radius:10px; overflow:hidden;
        aspect-ratio:16/9; background:#131212;
    }
    #pip-widget .pw-video-frame img.pw-remote { width:100%; height:100%; object-fit:cover; display:block; }
    #pip-widget .pw-video-frame .pw-local {
        position:absolute; bottom:7px; right:7px; width:70px; border-radius:6px;
        overflow:hidden; border:2px solid rgba(255,255,255,.25);
        box-shadow:0 2px 8px rgba(0,0,0,.4); background:#1a1a2e; aspect-ratio:16/9;
    }
    #pip-widget .pw-video-frame .pw-local img { width:100%; height:100%; object-fit:cover; display:block; }
    #pip-widget .pw-video-frame .pw-live {
        position:absolute; top:7px; left:7px;
        display:flex; align-items:center; gap:5px;
        background:rgba(0,0,0,.65); backdrop-filter:blur(4px);
        border-radius:20px; padding:3px 8px;
    }
    #pip-widget .pw-live-dot { width:6px; height:6px; border-radius:50%; background:#ef4444; animation:pipPulse 1s ease infinite; }
    #pip-widget .pw-live span { font-size:9px; color:#fff; font-weight:600; letter-spacing:.3px; }
    /* Audio wave animation */
    #pip-widget .pw-wave {
        display:flex; align-items:flex-end; gap:2px; height:18px;
        padding:0 2px; margin-left:4px;
    }
    #pip-widget .pw-wave span {
        display:inline-block; width:3px; border-radius:2px;
        background:linear-gradient(to top,#6366f1,#8b5cf6);
        animation:pipWave 1.2s ease-in-out infinite;
    }
    #pip-widget .pw-wave span:nth-child(1){height:6px; animation-delay:0s;}
    #pip-widget .pw-wave span:nth-child(2){height:12px;animation-delay:.15s;}
    #pip-widget .pw-wave span:nth-child(3){height:18px;animation-delay:.3s;}
    #pip-widget .pw-wave span:nth-child(4){height:10px;animation-delay:.45s;}
    #pip-widget .pw-wave span:nth-child(5){height:6px; animation-delay:.6s;}
    @keyframes pipWave {
        0%,100%{transform:scaleY(1);}
        50%{transform:scaleY(.3);}
    }
    #pip-widget .pw-wave.muted span { background:#4b5563; animation:none; height:4px; }
    /* Controls */
    #pip-widget .pw-controls {
        display:flex; justify-content:center; gap:8px;
        padding:10px 12px; background:#0a0a14;
        border-top:1px solid rgba(255,255,255,.06);
    }
    #pip-widget .pw-ctrl {
        width:36px; height:36px; border-radius:9px; border:none; cursor:pointer;
        display:flex; align-items:center; justify-content:center;
        background:#1e293b; color:#94a3b8; transition:all .15s;
    }
    #pip-widget .pw-ctrl:hover { background:#334155; color:#e2e8f0; transform:scale(1.07); }
    #pip-widget .pw-ctrl.active { background:#ef4444; color:#fff; }
    #pip-widget .pw-ctrl.active:hover { background:#dc2626; }
    #pip-widget .pw-end {
        height:36px; padding:0 16px; border-radius:9px; border:none; cursor:pointer;
        display:flex; align-items:center; justify-content:center; gap:6px;
        background:linear-gradient(135deg,#ef4444,#dc2626); color:#fff;
        font-size:11px; font-weight:600; transition:all .15s; white-space:nowrap;
    }
    #pip-widget .pw-end:hover { background:linear-gradient(135deg,#dc2626,#b91c1c); transform:scale(1.03); }
    `;

    function injectStyles() {
        if (document.getElementById('pip-widget-styles')) return;
        var s = document.createElement('style');
        s.id = 'pip-widget-styles';
        s.textContent = WIDGET_CSS;
        document.head.appendChild(s);
    }

    // ─── Widget builder ────────────────────────────────────────────────────────
    function buildWidget(data) {
        var isAudio   = data.type === 'audio';
        var name      = data.contactName || (isAudio ? 'Unknown' : 'Dr. Mette Andersen');
        var initial   = name.charAt(0).toUpperCase();
        var muted     = !!data.muted;
        var spkOff    = !!data.speakerOff;
        var camOff    = !!data.cameraOff;
        var secs      = data.seconds || 0;

        var outer = document.createElement('div');
        outer.id  = 'pip-widget';

        var videoSection = '';
        if (!isAudio) {
            var camSrc = camOff
                ? 'https://ui-avatars.com/api/?name=CAM+OFF&background=ef4444&color=fff&size=160'
                : 'b.jpg';
            videoSection = `
            <div class="pw-video-frame">
                <img class="pw-remote" src="a.jpg" alt="Remote" onerror="this.style.background='#1a1a2e';">
                <div class="pw-live"><div class="pw-live-dot"></div><span>LIVE</span></div>
                <div class="pw-local">
                    <img id="pip-local-img" src="${camSrc}" alt="Local" onerror="this.style.background='#1a1a2e';">
                </div>
            </div>`;
        }

        var waveOrType = isAudio
            ? `<div class="pw-wave ${muted ? 'muted' : ''}" id="pip-wave">
                   <span></span><span></span><span></span><span></span><span></span>
               </div>`
            : (I.video + '<span style="color:#a5b4fc;font-size:10px;font-weight:500;">Video</span>');

        outer.innerHTML = `
        <div class="pw-wrap ${isAudio ? '' : 'pw-video'}">
            <!-- Header / drag handle -->
            <div class="pw-hdr" id="pip-drag">
                <div class="pw-hdr-l">
                    <div class="pw-avatar">${esc(initial)}</div>
                    <div class="pw-info">
                        <div class="pw-name" title="${esc(name)}">${esc(name)}</div>
                        <div class="pw-meta">
                            <div class="pw-meta-dot"></div>
                            ${waveOrType}
                        </div>
                    </div>
                </div>
                <div class="pw-hdr-r">
                    <div class="pw-timer" id="pip-timer">${fmt(secs)}</div>
                    <button class="pw-icon-btn expand-btn" id="pip-expand" title="Return to call">${I.expand}</button>
                </div>
            </div>

            ${videoSection}

            <!-- Controls -->
            <div class="pw-controls">
                <button class="pw-ctrl ${muted ? 'active' : ''}" id="pip-mute" title="${muted ? 'Unmute' : 'Mute'}">
                    ${muted ? I.muteOff : I.muteOn}
                </button>
                ${isAudio ? `
                <button class="pw-ctrl ${spkOff ? 'active' : ''}" id="pip-speaker" title="${spkOff ? 'Speaker on' : 'Speaker off'}">
                    ${spkOff ? I.spkOff : I.spkOn}
                </button>` : `
                <button class="pw-ctrl ${camOff ? 'active' : ''}" id="pip-camera" title="${camOff ? 'Cam on' : 'Cam off'}">
                    ${camOff ? I.camOff : I.camOn}
                </button>`}
                <button class="pw-end" id="pip-end">
                    ${I.endSvg} End
                </button>
            </div>
        </div>`;

        return outer;
    }

    // ─── Draggable ────────────────────────────────────────────────────────────
    function makeDraggable(widget) {
        var handle = widget.querySelector('#pip-drag');
        var drag = false, ox = 0, oy = 0;

        function clamp(v, min, max){ return Math.max(min, Math.min(v, max)); }

        function onDown(cx, cy) {
            drag = true;
            var r = widget.getBoundingClientRect();
            ox = cx - r.left; oy = cy - r.top;
        }
        function onMove(cx, cy) {
            if (!drag) return;
            widget.style.left   = clamp(cx - ox, 5, window.innerWidth  - widget.offsetWidth  - 5) + 'px';
            widget.style.bottom = 'auto';
            widget.style.right  = 'auto';
            widget.style.top    = clamp(cy - oy, 5, window.innerHeight - widget.offsetHeight - 5) + 'px';
        }
        function onUp() { drag = false; }

        handle.addEventListener('mousedown',  function(e){ onDown(e.clientX, e.clientY); e.preventDefault(); });
        document.addEventListener('mousemove',function(e){ onMove(e.clientX, e.clientY); });
        document.addEventListener('mouseup',  onUp);

        handle.addEventListener('touchstart', function(e){ var t=e.touches[0]; onDown(t.clientX,t.clientY); }, { passive:true });
        document.addEventListener('touchmove', function(e){ var t=e.touches[0]; onMove(t.clientX,t.clientY); }, { passive:true });
        document.addEventListener('touchend',  onUp);
    }

    // ─── Timer ────────────────────────────────────────────────────────────────
    function startTimer(widget, initialSecs) {
        var secs    = initialSecs;
        var timerEl = widget.querySelector('#pip-timer');
        var interval = setInterval(function() {
            if (!document.body.contains(widget)) { clearInterval(interval); return; }
            secs++;
            if (timerEl) timerEl.textContent = fmt(secs);
            persist({ seconds: secs });
        }, 1000);
        return interval;
    }

    // ─── Wire up buttons ──────────────────────────────────────────────────────
    function wireButtons(widget, data, interval) {
        var isAudio = data.type === 'audio';
        var muted   = !!data.muted;
        var spkOff  = !!data.speakerOff;
        var camOff  = !!data.cameraOff;

        // Mute
        var muteBtn = widget.querySelector('#pip-mute');
        if (muteBtn) {
            muteBtn.addEventListener('click', function() {
                muted = !muted;
                muteBtn.classList.toggle('active', muted);
                muteBtn.innerHTML = muted ? I.muteOff : I.muteOn;
                muteBtn.title = muted ? 'Unmute' : 'Mute';
                // Animate wave
                var wave = widget.querySelector('#pip-wave');
                if (wave) wave.classList.toggle('muted', muted);
                persist({ muted: muted });
            });
        }

        // Speaker (audio only)
        var spkBtn = widget.querySelector('#pip-speaker');
        if (spkBtn) {
            spkBtn.addEventListener('click', function() {
                spkOff = !spkOff;
                spkBtn.classList.toggle('active', spkOff);
                spkBtn.innerHTML = spkOff ? I.spkOff : I.spkOn;
                spkBtn.title = spkOff ? 'Speaker on' : 'Speaker off';
                persist({ speakerOff: spkOff });
            });
        }

        // Camera (video only)
        var camBtn = widget.querySelector('#pip-camera');
        if (camBtn) {
            camBtn.addEventListener('click', function() {
                camOff = !camOff;
                camBtn.classList.toggle('active', camOff);
                camBtn.innerHTML = camOff ? I.camOff : I.camOn;
                camBtn.title = camOff ? 'Cam on' : 'Cam off';
                var localImg = widget.querySelector('#pip-local-img');
                if (localImg) {
                    localImg.src = camOff
                        ? 'https://ui-avatars.com/api/?name=CAM+OFF&background=ef4444&color=fff&size=160'
                        : 'b.jpg';
                }
                persist({ cameraOff: camOff });
            });
        }

        // Expand — returns to chat.html, call modal auto-restores from sessionStorage
        var expandBtn = widget.querySelector('#pip-expand');
        if (expandBtn) {
            expandBtn.addEventListener('click', function() {
                // Save latest second count before navigating
                var timerEl = widget.querySelector('#pip-timer');
                if (timerEl) {
                    var parts = timerEl.textContent.split(':');
                    var s = (+parts[0])*3600 + (+parts[1])*60 + (+parts[2]);
                    persist({ seconds: s });
                }
                // Navigate — chat.html DOMContentLoaded will pick up sessionStorage
                window.location.href = 'chat.html';
            });
        }

        // End call
        function endCall() {
            clearInterval(interval);
            widget.remove();
            sessionStorage.removeItem('pipData');
        }
        var closeBtn = widget.querySelector('#pip-close');
        var endBtn   = widget.querySelector('#pip-end');
        if (closeBtn) closeBtn.addEventListener('click', endCall);
        if (endBtn)   endBtn.addEventListener('click', endCall);
    }

    // ─── Main init ────────────────────────────────────────────────────────────
    function init() {
        // Don't run on chat.html — it manages its own call UI
        if (isOnChatPage()) return;

        var raw = sessionStorage.getItem('pipData');
        if (!raw) return;

        var data;
        try { data = JSON.parse(raw); } catch(e) { sessionStorage.removeItem('pipData'); return; }
        if (!data.type) return;

        // Prevent duplicate widgets
        if (document.getElementById('pip-widget')) return;

        injectStyles();

        var widget   = buildWidget(data);
        document.body.appendChild(widget);

        makeDraggable(widget);

        var interval = startTimer(widget, data.seconds || 0);
        wireButtons(widget, data, interval);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    // ─── Public API ───────────────────────────────────────────────────────────
    window.MeditrackPipWidget = {
        // Programmatically start a PiP call (useful for non-chat pages)
        startCall: function(opts) {
            sessionStorage.setItem('pipData', JSON.stringify({
                type:        opts.type        || 'audio',
                contactName: opts.contactName || 'Unknown',
                seconds:     opts.seconds     || 0,
                muted:       opts.muted       || false,
                speakerOff:  opts.speakerOff  || false,
                cameraOff:   opts.cameraOff   || false
            }));
            if (!isOnChatPage()) {
                // Remove old widget if present, then render new one
                var old = document.getElementById('pip-widget');
                if (old) old.remove();
                init();
            }
        },
        endCall: function() {
            var w = document.getElementById('pip-widget');
            if (w) { var b = w.querySelector('#pip-end'); if (b) b.click(); }
            else sessionStorage.removeItem('pipData');
        },
        isCallActive: function() { return !!sessionStorage.getItem('pipData'); }
    };

})(window, document);
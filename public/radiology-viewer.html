<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="manifest" href="manifest.json">
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Medi-track | Radiology Viewer</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/features/google-translate.css">
    <style>
        * { font-family: 'Inter', system-ui, sans-serif; }
        
        body { background-color: #0f0f0f; overflow: hidden; }
        body.dark { background-color: #0f0f0f; }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #1a1a1a; border-radius: 10px; }
        ::-webkit-scrollbar-thumb { background: #404040; border-radius: 10px; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        .toast-message {
            position: fixed; bottom: 20px; right: 20px;
            background: #10b981; color: white;
            padding: 12px 20px; border-radius: 8px;
            z-index: 1200;
            animation: slideIn 0.3s ease-out;
        }

        .tool-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px; height: 36px;
            border-radius: 8px;
            border: 1px solid #404040;
            background: #1a1a1a;
            color: #d1d5db;
            cursor: pointer;
            transition: all 0.15s;
        }
        .tool-btn:hover { background: #333; color: #fff; border-color: #6366f1; }
        .tool-btn.active { background: #6366f1; border-color: #6366f1; color: #fff; }
        .tool-btn:disabled { opacity: 0.4; cursor: not-allowed; }

        .series-thumb {
            border: 2px solid transparent;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.2s;
        }
        .series-thumb:hover { border-color: #6366f1; transform: translateY(-2px); }
        .series-thumb.active { border-color: #6366f1; box-shadow: 0 0 0 2px rgba(99,102,241,0.3); }

        .measurement-overlay {
            position: absolute;
            background: rgba(99,102,241,0.15);
            border: 2px solid #6366f1;
            pointer-events: none;
        }
        .measurement-label {
            position: absolute;
            background: rgba(0,0,0,0.8);
            color: #fff;
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 4px;
            white-space: nowrap;
            pointer-events: none;
        }

        .viewport-indicator {
            position: absolute;
            bottom: 12px;
            right: 12px;
            background: rgba(0,0,0,0.7);
            color: #fff;
            font-size: 10px;
            padding: 3px 8px;
            border-radius: 4px;
            font-family: monospace;
        }
    </style>
</head>
<body class="antialiased text-white">

    <!-- Top Toolbar -->
    <header class="sticky top-0 z-40 border-b border-gray-800 bg-[#0f0f0f] h-12 flex items-center px-4 gap-3 shadow-lg">
        <!-- Back -->
        <a href="radiology-list.html" class="tool-btn" title="Back to Dashboard">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
        </a>
        
        <!-- Separator -->
        <div class="w-px h-6 bg-gray-700"></div>
        
        <!-- Patient Info -->
        <div class="flex items-center gap-3 flex-1 min-w-0">
            <span class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center text-xs font-bold text-white flex-shrink-0">JD</span>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-white truncate">Ssentongo John • 45M</p>
                <p class="text-xs text-gray-400 truncate">CT Chest w/ Contrast • MRN: 1001</p>
            </div>
        </div>

        <!-- Separator -->
        <div class="w-px h-6 bg-gray-700"></div>

        <!-- Study Navigation -->
        <div class="flex items-center gap-2">
            <span class="text-xs text-gray-400">Series:</span>
            <select id="seriesSelector" class="bg-[#1a1a1a] border border-gray-700 rounded-md px-2 py-1 text-xs text-white focus:outline-none focus:border-indigo-500">
                <option value="0">1 - Scout</option>
                <option value="1" selected>2 - Axial C+</option>
                <option value="2">3 - Coronal C+</option>
                <option value="3">4 - Sagittal C+</option>
                <option value="4">5 - Lung Window</option>
            </select>
            <span class="text-xs text-gray-500 mx-1">Image:</span>
            <button id="prevImageBtn" class="tool-btn" title="Previous Image (←)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <span id="imageCounter" class="text-xs text-gray-300 font-mono min-w-[60px] text-center">42 / 128</span>
            <button id="nextImageBtn" class="tool-btn" title="Next Image (→)">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
            <input type="range" id="imageSlider" class="w-24 accent-indigo-500" min="1" max="128" value="42" title="Scroll through images">
        </div>

        <!-- Separator -->
        <div class="w-px h-6 bg-gray-700"></div>

        <!-- Tools -->
        <div class="flex items-center gap-1.5">
            <button id="toolPan" class="tool-btn" title="Pan (P)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 11V6a2 2 0 0 0-4 0v4"/><path d="M14 10V4a2 2 0 0 0-4 0v6"/><path d="M10 10.5V6a2 2 0 0 0-4 0v8"/><path d="M18 8a2 2 0 0 1 4 0v6a8 8 0 0 1-8 8h-2c-2.21 0-4.21-.9-5.66-2.34L2.34 15.66A2 2 0 0 1 3.75 13H6a2 2 0 0 1 2 2"/></svg>
            </button>
            <button id="toolZoom" class="tool-btn active" title="Zoom (Z)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
            </button>
            <button id="toolWindow" class="tool-btn" title="Window/Level (W)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M12 2v4"/><path d="M12 18v4"/><path d="M4.93 4.93l2.83 2.83"/><path d="M16.24 16.24l2.83 2.83"/><path d="M2 12h4"/><path d="M18 12h4"/></svg>
            </button>
            <button id="toolMeasure" class="tool-btn" title="Measure (M)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M7 16V8l4 4 4-4v8"/></svg>
            </button>
            <button id="toolAngle" class="tool-btn" title="Angle (A)">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12a9 9 0 1 1-6.219-8.56"/><path d="M21 3v5h-5"/></svg>
            </button>
        </div>

        <!-- Separator -->
        <div class="w-px h-6 bg-gray-700"></div>

        <!-- Window Presets -->
        <div class="flex items-center gap-1.5">
            <select id="windowPreset" class="bg-[#1a1a1a] border border-gray-700 rounded-md px-2 py-1 text-xs text-white focus:outline-none focus:border-indigo-500">
                <option value="mediastinum">Mediastinum (400/40)</option>
                <option value="lung" selected>Lung (1500/-600)</option>
                <option value="bone">Bone (1800/400)</option>
                <option value="abdomen">Abdomen (400/40)</option>
                <option value="brain">Brain (80/40)</option>
            </select>
        </div>

        <!-- Separator -->
        <div class="w-px h-6 bg-gray-700"></div>

        <!-- Actions -->
        <div class="flex items-center gap-1.5">
            <button id="btnReset" class="tool-btn" title="Reset View">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
            </button>
            <button id="btnInvert" class="tool-btn" title="Invert">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 2a10 10 0 0 1 0 20"/></svg>
            </button>
            <button id="btnFullscreen" class="tool-btn" title="Fullscreen">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/><rect width="10" height="8" x="7" y="8" rx="1"/></svg>
            </button>
            <button id="btnReport" class="px-3 h-9 rounded-md bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium flex items-center gap-1.5 transition-colors" title="Create Report">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Report
            </button>
        </div>
    </header>

    <!-- Main Viewer Area -->
    <div class="flex" style="height: calc(100vh - 48px);">
        
        <!-- Left Sidebar: Series Thumbnails -->
        <aside id="seriesPanel" class="w-56 border-r border-gray-800 bg-[#0f0f0f] overflow-y-auto flex-shrink-0 hidden md:block">
            <div class="p-3 border-b border-gray-800">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Series</p>
            </div>
            <div class="p-2 space-y-2" id="seriesThumbnails">
                <!-- Populated by JS -->
            </div>
            <div class="p-3 border-t border-gray-800 mt-auto">
                <div class="flex items-center justify-between text-xs text-gray-500">
                    <span>Total: 128 images</span>
                    <span>5 series</span>
                </div>
            </div>
        </aside>

        <!-- Main Viewport -->
        <div class="flex-1 relative bg-black flex items-center justify-center overflow-hidden" id="mainViewport">
            <!-- DICOM Image Canvas -->
            <canvas id="dicomCanvas" class="max-w-full max-h-full object-contain cursor-crosshair"></canvas>
            
            <!-- Patient Demographics Overlay -->
            <div class="absolute top-0 left-0 p-3 text-xs text-white/70 font-mono leading-relaxed pointer-events-none select-none">
                <p>Ssentongo John</p>
                <p>MRN: 1001 | 45M</p>
                <p>CT CHEST W/ CONTRAST</p>
                <p id="seriesInfo">Series 2: Axial C+</p>
            </div>

            <!-- Scale Bar -->
            <div class="absolute bottom-3 left-3 flex items-center gap-2 text-xs text-white/60 font-mono pointer-events-none select-none">
                <span id="scaleBarLabel">5 cm</span>
                <div class="w-16 h-0.5 bg-white/60"></div>
            </div>

            <!-- Viewport Info -->
            <div class="viewport-indicator">
                <span id="viewportInfo">W:1500 L:-600</span>
            </div>

            <!-- Zoom Level Indicator -->
            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 text-xs text-white/50 font-mono pointer-events-none select-none" id="zoomIndicator">
                100%
            </div>

            <!-- Loading Overlay -->
            <div id="loadingOverlay" class="absolute inset-0 bg-black/80 flex items-center justify-center z-20 hidden">
                <div class="text-center">
                    <div class="w-10 h-10 border-2 border-indigo-500 border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                    <p class="text-sm text-gray-400">Loading images...</p>
                </div>
            </div>
        </div>

        <!-- Right Sidebar: Tools & Info -->
        <aside id="toolsPanel" class="w-64 border-l border-gray-800 bg-[#0f0f0f] overflow-y-auto flex-shrink-0 hidden lg:block">
            <!-- Patient Info -->
            <div class="p-3 border-b border-gray-800">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Patient Info</p>
                <div class="space-y-1.5 text-xs">
                    <div class="flex justify-between"><span class="text-gray-500">Name</span><span class="text-white">Ssentongo John</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">MRN</span><span class="text-white">1001</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">DOB</span><span class="text-white">01/15/1981</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Sex</span><span class="text-white">Male</span></div>
                </div>
            </div>

            <!-- Study Info -->
            <div class="p-3 border-b border-gray-800">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Study Info</p>
                <div class="space-y-1.5 text-xs">
                    <div class="flex justify-between"><span class="text-gray-500">Study</span><span class="text-white">CT Chest w/ Contrast</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Date</span><span class="text-white">06/03/2026</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Time</span><span class="text-white">10:30 AM</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Modality</span><span class="text-white">CT</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Contrast</span><span class="text-white">IV Contrast</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Priority</span><span class="text-red-400 font-semibold">STAT</span></div>
                </div>
            </div>

            <!-- Measurements -->
            <div class="p-3 border-b border-gray-800">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Measurements</p>
                <div id="measurementsList" class="space-y-2 text-xs">
                    <p class="text-gray-500 italic">No measurements yet</p>
                </div>
                <button id="clearMeasurementsBtn" class="mt-2 w-full py-1.5 rounded-md border border-gray-700 text-xs text-gray-400 hover:text-white hover:border-gray-500 transition-colors hidden">
                    Clear All
                </button>
            </div>

            <!-- Keyboard Shortcuts -->
            <div class="p-3">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Shortcuts</p>
                <div class="space-y-1 text-xs text-gray-500">
                    <p><kbd class="px-1.5 py-0.5 bg-gray-800 rounded text-gray-300 text-[10px]">← →</kbd> Navigate images</p>
                    <p><kbd class="px-1.5 py-0.5 bg-gray-800 rounded text-gray-300 text-[10px]">Scroll</kbd> Scroll images</p>
                    <p><kbd class="px-1.5 py-0.5 bg-gray-800 rounded text-gray-300 text-[10px]">Z</kbd> Zoom tool</p>
                    <p><kbd class="px-1.5 py-0.5 bg-gray-800 rounded text-gray-300 text-[10px]">P</kbd> Pan tool</p>
                    <p><kbd class="px-1.5 py-0.5 bg-gray-800 rounded text-gray-300 text-[10px]">W</kbd> Window/Level</p>
                    <p><kbd class="px-1.5 py-0.5 bg-gray-800 rounded text-gray-300 text-[10px]">M</kbd> Measure</p>
                    <p><kbd class="px-1.5 py-0.5 bg-gray-800 rounded text-gray-300 text-[10px]">R</kbd> Reset view</p>
                    <p><kbd class="px-1.5 py-0.5 bg-gray-800 rounded text-gray-300 text-[10px]">I</kbd> Invert</p>
                    <p><kbd class="px-1.5 py-0.5 bg-gray-800 rounded text-gray-300 text-[10px]">F</kbd> Fullscreen</p>
                </div>
            </div>
        </aside>
    </div>

    <!-- Scripts -->
    <script src="js/features/settings-manager.js"></script>
    <script src="js/features/regional.js"></script>
    <script src="js/features/pip-widget.js"></script>
    <script src="js/features/google-translate.js"></script>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script>function googleTranslateElementInit(){}</script>

    <script>
    (function() {
        'use strict';

        // ============================================
        // STATE
        // ============================================
        var currentImage = 42;
        var totalImages = 128;
        var currentSeries = 1;
        var zoomLevel = 1;
        var panX = 0, panY = 0;
        var isInverted = false;
        var activeTool = 'zoom'; // zoom | pan | window | measure | angle
        var windowWidth = 1500;
        var windowLevel = -600;
        var measurements = [];
        var isDragging = false;
        var dragStartX = 0, dragStartY = 0;
        var measureStartX = 0, measureStartY = 0;

        // Series data
        var seriesData = [
            { id: 0, name: 'Scout', images: 2, description: 'CT Scout Topogram' },
            { id: 1, name: 'Axial C+', images: 58, description: 'Axial CT with IV Contrast' },
            { id: 2, name: 'Coronal C+', images: 32, description: 'Coronal Reformats C+' },
            { id: 3, name: 'Sagittal C+', images: 28, description: 'Sagittal Reformats C+' },
            { id: 4, name: 'Lung Window', images: 8, description: 'High-res Lung Windows' }
        ];

        // Window presets
        var presets = {
            'mediastinum': { w: 400, l: 40 },
            'lung': { w: 1500, l: -600 },
            'bone': { w: 1800, l: 400 },
            'abdomen': { w: 400, l: 40 },
            'brain': { w: 80, l: 40 }
        };

        // ============================================
        // UTILITY FUNCTIONS
        // ============================================
        function showToast(msg, isError) {
            document.querySelectorAll('.toast-message').forEach(function(t) { t.remove(); });
            var toast = document.createElement('div');
            toast.className = 'toast-message';
            toast.style.background = isError ? '#ef4444' : '#10b981';
            toast.textContent = msg;
            document.body.appendChild(toast);
            setTimeout(function() { toast.remove(); }, 3000);
        }

        function updateImageCounter() {
            var counter = document.getElementById('imageCounter');
            var slider = document.getElementById('imageSlider');
            if (counter) counter.textContent = currentImage + ' / ' + totalImages;
            if (slider) slider.value = currentImage;
        }

        function updateViewportInfo() {
            var info = document.getElementById('viewportInfo');
            if (info) info.textContent = 'W:' + windowWidth + ' L:' + windowLevel;
        }

        function updateZoomIndicator() {
            var indicator = document.getElementById('zoomIndicator');
            if (indicator) indicator.textContent = Math.round(zoomLevel * 100) + '%';
        }

        function updateSeriesInfo() {
            var info = document.getElementById('seriesInfo');
            var series = seriesData[currentSeries];
            if (info && series) info.textContent = 'Series ' + (series.id + 1) + ': ' + series.name;
        }

        // ============================================
        // CANVAS RENDERING (Simulated DICOM)
        // ============================================
        var canvas = document.getElementById('dicomCanvas');
        var ctx = canvas ? canvas.getContext('2d') : null;

        function renderImage() {
            if (!canvas || !ctx) return;

            var viewport = document.getElementById('mainViewport');
            var w = viewport.clientWidth;
            var h = viewport.clientHeight;

            canvas.width = w;
            canvas.height = h;

            // Clear
            ctx.fillStyle = isInverted ? '#fff' : '#000';
            ctx.fillRect(0, 0, w, h);

            // Apply zoom and pan
            ctx.save();
            ctx.translate(w / 2 + panX, h / 2 + panY);
            ctx.scale(zoomLevel, zoomLevel);
            ctx.translate(-w / 2, -h / 2);

            // Simulate DICOM image with a gradient that looks like a CT chest
            drawSimulatedCT(w, h);

            // Draw measurements
            drawMeasurements();

            ctx.restore();

            // Draw patient overlay text
            drawPatientOverlay(w, h);
        }

        function drawSimulatedCT(w, h) {
            // Create a realistic-looking CT image using canvas primitives
            var centerX = w / 2;
            var centerY = h / 2;
            var imgW = Math.min(w * 0.85, h * 0.75);
            var imgH = imgW * 0.75;
            var x = centerX - imgW / 2;
            var y = centerY - imgH / 2;

            // Background (soft tissue)
            ctx.fillStyle = isInverted ? '#ddd' : '#333';
            ctx.fillRect(x, y, imgW, imgH);

            // Body outline (oval)
            ctx.beginPath();
            ctx.ellipse(centerX, centerY, imgW / 2, imgH / 2, 0, 0, Math.PI * 2);
            
            // Window/level effect
            var alpha = (windowLevel + 600) / 2000;
            alpha = Math.max(0, Math.min(1, alpha));
            
            if (isInverted) {
                ctx.fillStyle = 'rgba(255,255,255,' + (1 - alpha * 0.7) + ')';
            } else {
                ctx.fillStyle = 'rgba(30,30,30,' + (0.3 + alpha * 0.7) + ')';
            }
            ctx.fill();

            // Ribs (posterior)
            ctx.strokeStyle = isInverted ? '#666' : '#ccc';
            ctx.lineWidth = 2;
            for (var i = 0; i < 6; i++) {
                var ribY = centerY - imgH * 0.25 + i * (imgH * 0.1);
                ctx.beginPath();
                ctx.arc(centerX - imgW * 0.3, ribY, imgW * 0.15, -Math.PI * 0.6, Math.PI * 0.6);
                ctx.stroke();
                ctx.beginPath();
                ctx.arc(centerX + imgW * 0.3, ribY, imgW * 0.15, Math.PI * 0.4, Math.PI * 1.6);
                ctx.stroke();
            }

            // Spine (vertebral body)
            ctx.fillStyle = isInverted ? '#999' : '#ddd';
            ctx.beginPath();
            ctx.ellipse(centerX, centerY - imgH * 0.08, imgW * 0.06, imgH * 0.08, 0, 0, Math.PI * 2);
            ctx.fill();

            // Heart (mediastinum)
            ctx.fillStyle = isInverted ? '#aaa' : '#555';
            ctx.beginPath();
            ctx.ellipse(centerX - imgW * 0.05, centerY - imgH * 0.05, imgW * 0.12, imgH * 0.15, -0.2, 0, Math.PI * 2);
            ctx.fill();

            // Aorta
            ctx.fillStyle = isInverted ? '#bbb' : '#666';
            ctx.beginPath();
            ctx.arc(centerX + imgW * 0.02, centerY - imgH * 0.08, imgW * 0.03, 0, Math.PI * 2);
            ctx.fill();

            // Lungs (dark areas)
            ctx.fillStyle = isInverted ? '#eee' : '#111';
            // Left lung
            ctx.beginPath();
            ctx.ellipse(centerX - imgW * 0.18, centerY + imgH * 0.02, imgW * 0.18, imgH * 0.25, 0.1, 0, Math.PI * 2);
            ctx.fill();
            // Right lung
            ctx.beginPath();
            ctx.ellipse(centerX + imgW * 0.18, centerY + imgH * 0.02, imgW * 0.18, imgH * 0.25, -0.1, 0, Math.PI * 2);
            ctx.fill();

            // Lung markings (bronchovascular)
            ctx.strokeStyle = isInverted ? '#ccc' : '#444';
            ctx.lineWidth = 0.5;
            for (var j = 0; j < 15; j++) {
                var bx = centerX - imgW * 0.25 + Math.random() * imgW * 0.3;
                var by = centerY - imgH * 0.15 + Math.random() * imgH * 0.3;
                ctx.beginPath();
                ctx.moveTo(bx, by);
                ctx.lineTo(bx + (Math.random() - 0.5) * 30, by + (Math.random() - 0.5) * 20);
                ctx.stroke();
            }
            for (var k = 0; k < 15; k++) {
                var bx2 = centerX + imgW * 0.05 + Math.random() * imgW * 0.25;
                var by2 = centerY - imgH * 0.15 + Math.random() * imgH * 0.3;
                ctx.beginPath();
                ctx.moveTo(bx2, by2);
                ctx.lineTo(bx2 + (Math.random() - 0.5) * 30, by2 + (Math.random() - 0.5) * 20);
                ctx.stroke();
            }

            // Crosshair
            ctx.strokeStyle = isInverted ? '#000' : '#0f0';
            ctx.lineWidth = 0.5;
            ctx.setLineDash([4, 4]);
            ctx.beginPath();
            ctx.moveTo(centerX, y + 5);
            ctx.lineTo(centerX, y + imgH - 5);
            ctx.moveTo(x + 5, centerY);
            ctx.lineTo(x + imgW - 5, centerY);
            ctx.stroke();
            ctx.setLineDash([]);

            // Scale marker
            ctx.strokeStyle = isInverted ? '#000' : '#fff';
            ctx.lineWidth = 2;
            ctx.beginPath();
            ctx.moveTo(x + 15, y + imgH - 25);
            ctx.lineTo(x + 65, y + imgH - 25);
            ctx.stroke();
            ctx.fillStyle = isInverted ? '#000' : '#fff';
            ctx.font = '10px monospace';
            ctx.fillText('5 cm', x + 18, y + imgH - 30);
        }

        function drawMeasurements() {
            if (!ctx) return;
            
            measurements.forEach(function(m, index) {
                ctx.strokeStyle = '#6366f1';
                ctx.fillStyle = '#6366f1';
                ctx.lineWidth = 2;

                if (m.type === 'line') {
                    ctx.beginPath();
                    ctx.setLineDash([6, 3]);
                    ctx.moveTo(m.x1, m.y1);
                    ctx.lineTo(m.x2, m.y2);
                    ctx.stroke();
                    ctx.setLineDash([]);

                    // Endpoints
                    ctx.beginPath();
                    ctx.arc(m.x1, m.y1, 4, 0, Math.PI * 2);
                    ctx.fill();
                    ctx.beginPath();
                    ctx.arc(m.x2, m.y2, 4, 0, Math.PI * 2);
                    ctx.fill();

                    // Label
                    var midX = (m.x1 + m.x2) / 2;
                    var midY = (m.y1 + m.y2) / 2;
                    var dist = Math.sqrt(Math.pow(m.x2 - m.x1, 2) + Math.pow(m.y2 - m.y1, 2));
                    var distCm = (dist / 10).toFixed(1);

                    ctx.fillStyle = 'rgba(0,0,0,0.8)';
                    ctx.fillRect(midX - 25, midY - 18, 50, 16);
                    ctx.fillStyle = '#fff';
                    ctx.font = '11px Inter, sans-serif';
                    ctx.textAlign = 'center';
                    ctx.fillText(distCm + ' cm', midX, midY - 6);
                }
            });
        }

        function drawPatientOverlay(w, h) {
            // This is handled by the HTML overlay elements
        }

        function updateCanvas() {
            renderImage();
            updateImageCounter();
            updateViewportInfo();
            updateZoomIndicator();
            updateSeriesInfo();
        }

        // ============================================
        // SERIES THUMBNAILS
        // ============================================
        function renderSeriesThumbnails() {
            var container = document.getElementById('seriesThumbnails');
            if (!container) return;

            container.innerHTML = seriesData.map(function(series) {
                var isActive = series.id === currentSeries;
                return '<div class="series-thumb p-2 ' + (isActive ? 'active' : '') + '" data-series="' + series.id + '">' +
                    '<div class="w-full aspect-square bg-gray-800 rounded-md flex items-center justify-center mb-1.5 relative overflow-hidden">' +
                        '<div class="text-gray-600 text-xs">' + series.images + ' imgs</div>' +
                        (isActive ? '<div class="absolute top-1 right-1 w-2 h-2 rounded-full bg-indigo-500"></div>' : '') +
                    '</div>' +
                    '<p class="text-xs font-medium text-white truncate">' + series.name + '</p>' +
                    '<p class="text-[10px] text-gray-500 truncate">' + series.description + '</p>' +
                    '<p class="text-[10px] text-gray-600">' + series.images + ' images</p>' +
                '</div>';
            }).join('');

            container.querySelectorAll('.series-thumb').forEach(function(thumb) {
                thumb.addEventListener('click', function() {
                    var seriesId = parseInt(this.getAttribute('data-series'));
                    switchSeries(seriesId);
                });
            });
        }

        function switchSeries(seriesId) {
            currentSeries = seriesId;
            totalImages = seriesData[seriesId].images;
            currentImage = Math.min(currentImage, totalImages);
            document.getElementById('imageSlider').max = totalImages;
            document.getElementById('seriesSelector').value = seriesId;
            renderSeriesThumbnails();
            updateCanvas();
            showToast('Switched to series: ' + seriesData[seriesId].name);
        }

        // ============================================
        // TOOL HANDLERS
        // ============================================
        function setActiveTool(tool) {
            activeTool = tool;
            document.querySelectorAll('#toolPan, #toolZoom, #toolWindow, #toolMeasure, #toolAngle').forEach(function(btn) {
                btn.classList.remove('active');
            });
            var toolMap = {
                'pan': 'toolPan',
                'zoom': 'toolZoom',
                'window': 'toolWindow',
                'measure': 'toolMeasure',
                'angle': 'toolAngle'
            };
            var btnId = toolMap[tool];
            if (btnId) document.getElementById(btnId).classList.add('active');

            // Update cursor
            var cursors = {
                'pan': 'grab',
                'zoom': 'zoom-in',
                'window': 'crosshair',
                'measure': 'crosshair',
                'angle': 'crosshair'
            };
            canvas.style.cursor = cursors[tool] || 'crosshair';
        }

        function resetView() {
            zoomLevel = 1;
            panX = 0;
            panY = 0;
            isInverted = false;
            windowWidth = presets['lung'].w;
            windowLevel = presets['lung'].l;
            document.getElementById('windowPreset').value = 'lung';
            updateCanvas();
            showToast('View reset');
        }

        function addMeasurement(x1, y1, x2, y2) {
            measurements.push({
                type: 'line',
                x1: x1, y1: y1,
                x2: x2, y2: y2
            });
            updateMeasurementsList();
            updateCanvas();
        }

        function updateMeasurementsList() {
            var list = document.getElementById('measurementsList');
            var clearBtn = document.getElementById('clearMeasurementsBtn');
            
            if (!list) return;

            if (measurements.length === 0) {
                list.innerHTML = '<p class="text-gray-500 italic text-xs">No measurements yet</p>';
                if (clearBtn) clearBtn.classList.add('hidden');
            } else {
                list.innerHTML = measurements.map(function(m, i) {
                    var dist = Math.sqrt(Math.pow(m.x2 - m.x1, 2) + Math.pow(m.y2 - m.y1, 2));
                    var distCm = (dist / 10).toFixed(1);
                    return '<div class="flex items-center justify-between py-1 border-b border-gray-800">' +
                        '<span class="text-indigo-400">#' + (i + 1) + '</span>' +
                        '<span class="text-white">' + distCm + ' cm</span>' +
                        '<button class="text-gray-500 hover:text-red-400 text-[10px] delete-measurement" data-index="' + i + '">✕</button>' +
                    '</div>';
                }).join('');
                if (clearBtn) clearBtn.classList.remove('hidden');
            }

            // Attach delete handlers
            list.querySelectorAll('.delete-measurement').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    var index = parseInt(this.getAttribute('data-index'));
                    measurements.splice(index, 1);
                    updateMeasurementsList();
                    updateCanvas();
                });
            });
        }

        // ============================================
        // EVENT HANDLERS
        // ============================================
        // Mouse events on canvas
        canvas.addEventListener('mousedown', function(e) {
            isDragging = true;
            var rect = canvas.getBoundingClientRect();
            dragStartX = e.clientX;
            dragStartY = e.clientY;
            measureStartX = (e.clientX - rect.left - rect.width / 2 - panX) / zoomLevel + rect.width / 2;
            measureStartY = (e.clientY - rect.top - rect.height / 2 - panY) / zoomLevel + rect.height / 2;

            if (activeTool === 'pan') {
                canvas.style.cursor = 'grabbing';
            }
        });

        canvas.addEventListener('mousemove', function(e) {
            if (!isDragging) return;

            var dx = e.clientX - dragStartX;
            var dy = e.clientY - dragStartY;

            if (activeTool === 'pan') {
                panX += dx;
                panY += dy;
                dragStartX = e.clientX;
                dragStartY = e.clientY;
                updateCanvas();
            } else if (activeTool === 'zoom') {
                zoomLevel = Math.max(0.1, Math.min(10, zoomLevel + dy * 0.005));
                dragStartX = e.clientX;
                dragStartY = e.clientY;
                updateCanvas();
            } else if (activeTool === 'window') {
                windowWidth = Math.max(1, windowWidth + dx * 2);
                windowLevel = Math.max(-1000, Math.min(1000, windowLevel + dy));
                dragStartX = e.clientX;
                dragStartY = e.clientY;
                updateCanvas();
            } else if (activeTool === 'measure') {
                // Preview measurement
                renderImage();
                var rect = canvas.getBoundingClientRect();
                var currentX = (e.clientX - rect.left - rect.width / 2 - panX) / zoomLevel + rect.width / 2;
                var currentY = (e.clientY - rect.top - rect.height / 2 - panY) / zoomLevel + rect.height / 2;
                
                ctx.save();
                ctx.translate(rect.width / 2 + panX, rect.height / 2 + panY);
                ctx.scale(zoomLevel, zoomLevel);
                ctx.translate(-rect.width / 2, -rect.height / 2);
                ctx.strokeStyle = '#6366f1';
                ctx.lineWidth = 2;
                ctx.setLineDash([6, 3]);
                ctx.beginPath();
                ctx.moveTo(measureStartX, measureStartY);
                ctx.lineTo(currentX, currentY);
                ctx.stroke();
                ctx.setLineDash([]);
                ctx.restore();
            }
        });

        canvas.addEventListener('mouseup', function(e) {
            if (!isDragging) return;
            isDragging = false;

            if (activeTool === 'measure') {
                var rect = canvas.getBoundingClientRect();
                var endX = (e.clientX - rect.left - rect.width / 2 - panX) / zoomLevel + rect.width / 2;
                var endY = (e.clientY - rect.top - rect.height / 2 - panY) / zoomLevel + rect.height / 2;
                
                if (Math.abs(endX - measureStartX) > 5 || Math.abs(endY - measureStartY) > 5) {
                    addMeasurement(measureStartX, measureStartY, endX, endY);
                }
            }

            canvas.style.cursor = activeTool === 'pan' ? 'grab' : 'crosshair';
            updateCanvas();
        });

        canvas.addEventListener('wheel', function(e) {
            e.preventDefault();
            if (e.ctrlKey || e.metaKey) {
                // Zoom with Ctrl+Scroll
                zoomLevel = Math.max(0.1, Math.min(10, zoomLevel - e.deltaY * 0.001));
            } else {
                // Scroll through images
                if (e.deltaY > 0) {
                    currentImage = Math.min(totalImages, currentImage + 1);
                } else {
                    currentImage = Math.max(1, currentImage - 1);
                }
            }
            updateCanvas();
        }, { passive: false });

        // Prevent context menu on canvas for right-click tools
        canvas.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Don't trigger shortcuts when typing in inputs
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'SELECT' || e.target.tagName === 'TEXTAREA') return;

            switch(e.key.toLowerCase()) {
                case 'arrowleft':
                    e.preventDefault();
                    currentImage = Math.max(1, currentImage - 1);
                    updateCanvas();
                    break;
                case 'arrowright':
                    e.preventDefault();
                    currentImage = Math.min(totalImages, currentImage + 1);
                    updateCanvas();
                    break;
                case 'arrowup':
                    e.preventDefault();
                    currentImage = Math.max(1, currentImage - 5);
                    updateCanvas();
                    break;
                case 'arrowdown':
                    e.preventDefault();
                    currentImage = Math.min(totalImages, currentImage + 5);
                    updateCanvas();
                    break;
                case 'z':
                    if (!e.ctrlKey && !e.metaKey) {
                        setActiveTool('zoom');
                        showToast('Tool: Zoom');
                    }
                    break;
                case 'p':
                    setActiveTool('pan');
                    showToast('Tool: Pan');
                    break;
                case 'w':
                    setActiveTool('window');
                    showToast('Tool: Window/Level');
                    break;
                case 'm':
                    setActiveTool('measure');
                    showToast('Tool: Measure');
                    break;
                case 'a':
                    setActiveTool('angle');
                    showToast('Tool: Angle');
                    break;
                case 'r':
                    resetView();
                    break;
                case 'i':
                    isInverted = !isInverted;
                    updateCanvas();
                    showToast(isInverted ? 'Inverted' : 'Normal');
                    break;
                case 'f':
                    toggleFullscreen();
                    break;
                case 'home':
                    e.preventDefault();
                    currentImage = 1;
                    updateCanvas();
                    break;
                case 'end':
                    e.preventDefault();
                    currentImage = totalImages;
                    updateCanvas();
                    break;
                case 'escape':
                    setActiveTool('zoom');
                    if (measurements.length > 0) {
                        measurements = [];
                        updateMeasurementsList();
                        updateCanvas();
                    }
                    break;
            }
        });

        // Slider
        document.getElementById('imageSlider').addEventListener('input', function() {
            currentImage = parseInt(this.value);
            updateCanvas();
        });

        // Series selector dropdown
        document.getElementById('seriesSelector').addEventListener('change', function() {
            switchSeries(parseInt(this.value));
        });

        // Window preset
        document.getElementById('windowPreset').addEventListener('change', function() {
            var preset = presets[this.value];
            if (preset) {
                windowWidth = preset.w;
                windowLevel = preset.l;
                updateCanvas();
                showToast('Window: ' + this.options[this.selectedIndex].text);
            }
        });

        // Tool buttons
        document.getElementById('toolPan').addEventListener('click', function() { setActiveTool('pan'); });
        document.getElementById('toolZoom').addEventListener('click', function() { setActiveTool('zoom'); });
        document.getElementById('toolWindow').addEventListener('click', function() { setActiveTool('window'); });
        document.getElementById('toolMeasure').addEventListener('click', function() { setActiveTool('measure'); });
        document.getElementById('toolAngle').addEventListener('click', function() { setActiveTool('angle'); });

        // Action buttons
        document.getElementById('btnReset').addEventListener('click', resetView);
        document.getElementById('btnInvert').addEventListener('click', function() {
            isInverted = !isInverted;
            updateCanvas();
        });
        document.getElementById('btnFullscreen').addEventListener('click', toggleFullscreen);
        document.getElementById('btnReport').addEventListener('click', function() {
            showToast('Opening report for this study...');
            // window.location.href = 'radiology-report.html?study=' + currentSeries;
        });
        document.getElementById('prevImageBtn').addEventListener('click', function() {
            currentImage = Math.max(1, currentImage - 1);
            updateCanvas();
        });
        document.getElementById('nextImageBtn').addEventListener('click', function() {
            currentImage = Math.min(totalImages, currentImage + 1);
            updateCanvas();
        });
        document.getElementById('clearMeasurementsBtn').addEventListener('click', function() {
            measurements = [];
            updateMeasurementsList();
            updateCanvas();
        });

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(function() {});
            } else {
                document.exitFullscreen();
            }
        }

        // Window resize
        window.addEventListener('resize', function() {
            updateCanvas();
        });

        // ============================================
        // INIT
        // ============================================
        function init() {
            document.getElementById('imageSlider').max = totalImages;
            document.getElementById('imageSlider').value = currentImage;
            updateCanvas();
            renderSeriesThumbnails();
            setActiveTool('zoom');
            console.log('Radiology Viewer initialized');
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init);
        } else {
            init();
        }
    })();
    </script>

    <!-- Google Translate UI Hider -->
    <style>
        .goog-te-banner-frame.skiptranslate, .goog-te-banner-frame, iframe.skiptranslate, iframe.goog-te-banner-frame { display:none!important; visibility:hidden!important; height:0!important; width:0!important; position:absolute!important; top:-1000px!important; }
        body { top:0px!important; position:static!important; }
        body[style*="top"] { top:0!important; position:static!important; }
        .goog-tooltip, .goog-tooltip:hover, #goog-gt-tt, .goog-te-balloon-frame { display:none!important; visibility:hidden!important; }
        .goog-text-highlight { background-color:transparent!important; border:none!important; box-shadow:none!important; }
        .goog-te-gadget, .goog-te-gadget-simple { display:none!important; visibility:hidden!important; height:0!important; overflow:hidden!important; }
        body > .skiptranslate { height:0!important; overflow:hidden!important; position:fixed!important; top:-999px!important; left:-999px!important; width:1px!important; pointer-events:none!important; }
        body > .skiptranslate > * { display:none!important; }
        .goog-te-spinner-pos, .goog-te-spinner, .goog-te-spinner div { display:none!important; visibility:hidden!important; opacity:0!important; }
        .goog-logo-link, .goog-logo-link img { display:none!important; }
        html { margin-top:0!important; }
    </style>
    <script src="js/meditrack-security.js"></script>
    <script src="js/meditrack.js"></script>
    <script src="js/meditrack-realtime.js"></script>
    <script src="js/meditrack-language.js"></script>
    <script src="js/meditrack-flags.js"></script>
    <script src="js/meditrack-avatars.js"></script>
    <script src="js/meditrack-nav-confirm.js"></script>
    <script src="js/meditrack-store.js"></script>
    <script src="js/meditrack-pagination.js"></script>
    <script src="js/meditrack-search.js"></script>
    <script src="js/meditrack-pdf.js"></script>
    <script src="js/clinical-sync.js"></script>
    <script src="js/meditrack-action-menu.js"></script>
    <script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('service-worker.js').then(function(reg) {
            console.log('[PWA] Service Worker registered:', reg.scope);
        }).catch(function(err) {
            console.warn('[PWA] Service Worker registration failed:', err);
        });
    });
}
</script>
</body>
</html>
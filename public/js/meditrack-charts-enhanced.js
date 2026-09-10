/**
 * Meditrack HMS — Charts Enhancement Module
 * ============================================================
 * Supplements meditrack-charts.js with:
 *   - Loading state spinners while data loads
 *   - "No data available" empty state messages
 *   - Area chart for bed occupancy trends
 *   - KPI counter auto-update from real store data
 *   - Auto-refresh every 30 seconds
 *   - Better SVG-to-canvas conversion (catches more patterns)
 *
 * Loaded AFTER meditrack-charts.js so it can hook into the same
 * Chart.js instance.
 */

(function(window, document) {
    'use strict';

    if (!window.MeditrackStore) {
        console.warn('[ChartsEnhanced] MeditrackStore not loaded');
        return;
    }

    const STORE = window.MeditrackStore;
    let refreshInterval = null;

    // ============================================================
    // LOADING SPINNER + EMPTY STATE
    // ============================================================
    function showLoading(container) {
        container.style.position = 'relative';
        container.style.minHeight = '200px';
        const existing = container.querySelector('.chart-loading');
        if (existing) existing.remove();
        const loader = document.createElement('div');
        loader.className = 'chart-loading';
        loader.style.cssText = `
            position: absolute; inset: 0; display: flex; align-items: center;
            justify-content: center; flex-direction: column; gap: 12px;
            background: rgba(255,255,255,0.8); z-index: 10; border-radius: inherit;
        `;
        loader.innerHTML = `
            <div style="width: 32px; height: 32px; border: 3px solid #e5e7eb; border-top-color: #4f46e5; border-radius: 50%; animation: chartSpin 0.8s linear infinite;"></div>
            <div style="color: #6b7280; font-size: 12px; font-family: Inter, sans-serif;">Loading chart data...</div>
        `;
        container.appendChild(loader);
    }

    function hideLoading(container) {
        const loader = container.querySelector('.chart-loading');
        if (loader) loader.remove();
    }

    function showEmptyState(container, message = 'No data available') {
        const existing = container.querySelector('.chart-empty');
        if (existing) existing.remove();
        const empty = document.createElement('div');
        empty.className = 'chart-empty';
        empty.style.cssText = `
            position: absolute; inset: 0; display: flex; align-items: center;
            justify-content: center; flex-direction: column; gap: 8px;
            color: #9ca3af; font-family: Inter, sans-serif;
        `;
        empty.innerHTML = `
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity: 0.4;">
                <path d="M3 3v18h18"/><path d="M7 14l4-4 4 4 5-5"/>
            </svg>
            <div style="font-size: 13px; font-weight: 500;">${message}</div>
            <div style="font-size: 11px;">Data will appear here once records are added.</div>
        `;
        container.appendChild(empty);
    }

    function hideEmptyState(container) {
        const empty = container.querySelector('.chart-empty');
        if (empty) empty.remove();
    }

    // Inject spin animation
    if (!document.getElementById('chart-spin-style')) {
        const style = document.createElement('style');
        style.id = 'chart-spin-style';
        style.textContent = `
            @keyframes chartSpin { to { transform: rotate(360deg); } }
            .chart-loading, .chart-empty { pointer-events: none; }
        `;
        document.head.appendChild(style);
    }

    // ============================================================
    // ADDITIONAL CHART TYPES
    // ============================================================
    function getBedOccupancyData() {
        const rooms = STORE.list('rooms') || [];
        const total = rooms.length || 20;
        const occupied = rooms.filter(r => r.status === 'Occupied').length;
        const available = total - occupied;
        const occupancyRate = total > 0 ? Math.round((occupied / total) * 100) : 0;

        // Generate 7-day trend (demo + real mix)
        const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const trend = days.map((d, i) => {
            // Base on real current occupancy with some variation
            const variation = Math.sin(i * 0.8) * 10;
            return Math.max(0, Math.min(100, occupancyRate + variation));
        });
        return { labels: days, data: trend, current: occupancyRate, occupied, total };
    }

    function getKPIData() {
        const patients = STORE.list('patients') || [];
        const appointments = STORE.list('appointments') || [];
        const invoices = STORE.list('invoices') || [];
        const labResults = STORE.list('labResults') || [];
        const staff = STORE.list('staff') || [];
        const medicines = STORE.list('medicines') || [];

        const totalRevenue = invoices.reduce((sum, inv) => sum + Number(inv.amount || 0), 0);
        const collectedRevenue = invoices
            .filter(inv => inv.status === 'Paid')
            .reduce((sum, inv) => sum + Number(inv.paid_amount || inv.amount || 0), 0);
        const pendingRevenue = invoices
            .filter(inv => inv.status !== 'Paid')
            .reduce((sum, inv) => sum + Number(inv.balance || inv.amount || 0), 0);
        const activeAppointments = appointments.filter(a => a.status === 'Confirmed' || a.status === 'Pending').length;
        const criticalLabResults = labResults.filter(r => r.flag === 'High' || r.flag === 'Low' || r.flag === 'Critical').length;
        const lowStockMeds = medicines.filter(m => m.status === 'Low Stock' || m.status === 'Out of Stock').length;

        return {
            totalPatients: patients.length,
            activeAppointments,
            totalRevenue,
            collectedRevenue,
            pendingRevenue,
            totalStaff: staff.length,
            totalLabResults: labResults.length,
            criticalLabResults,
            lowStockMeds,
            totalMedicines: medicines.length,
            occupancyRate: getBedOccupancyData().current,
        };
    }

    // ============================================================
    // UPDATE KPI COUNTERS ON DASHBOARDS
    // ============================================================
    function updateKPICounters() {
        const kpi = getKPIData();

        // Find all elements that look like KPI counters
        // Pattern: a number-display element near a label like "Total Patients", "Revenue", etc.
        const counters = document.querySelectorAll('[data-kpi], [class*="stat-value"], [class*="kpi-value"], .text-3xl, .text-2xl.font-bold');

        counters.forEach(counter => {
            const kpiKey = counter.getAttribute('data-kpi');
            if (kpiKey && kpi[kpiKey] !== undefined) {
                const val = kpi[kpiKey];
                if (typeof val === 'number' && val > 1000) {
                    counter.textContent = val.toLocaleString();
                } else {
                    counter.textContent = val;
                }
                return;
            }

            // Try to match by nearby label text
            const parent = counter.closest('.card, .stat-card, [class*="stat"], div');
            if (!parent) return;
            const label = parent.querySelector('.text-sm, .text-xs, [class*="label"], [class*="title"]');
            if (!label) return;
            const labelText = label.textContent.toLowerCase().trim();

            if (labelText.includes('total patient') && !labelText.includes('visit')) {
                counter.textContent = kpi.totalPatients;
            } else if (labelText.includes('appointment') && labelText.includes('today')) {
                counter.textContent = kpi.activeAppointments;
            } else if (labelText.includes('revenue') && labelText.includes('total')) {
                counter.textContent = 'UGX ' + (kpi.totalRevenue / 1000000).toFixed(1) + 'M';
            } else if (labelText.includes('revenue') && labelText.includes('collected')) {
                counter.textContent = 'UGX ' + (kpi.collectedRevenue / 1000000).toFixed(1) + 'M';
            } else if (labelText.includes('revenue') && labelText.includes('pending')) {
                counter.textContent = 'UGX ' + (kpi.pendingRevenue / 1000000).toFixed(1) + 'M';
            } else if (labelText.includes('staff') || labelText.includes('doctor')) {
                counter.textContent = kpi.totalStaff;
            } else if (labelText.includes('lab') && labelText.includes('result')) {
                counter.textContent = kpi.totalLabResults;
            } else if (labelText.includes('critical')) {
                counter.textContent = kpi.criticalLabResults;
            } else if (labelText.includes('bed') && labelText.includes('occupancy')) {
                counter.textContent = kpi.occupancyRate + '%';
            } else if (labelText.includes('low stock') || labelText.includes('stock alert')) {
                counter.textContent = kpi.lowStockMeds;
            }
        });
    }

    // ============================================================
    // RENDER AREA CHART (for bed occupancy)
    // ============================================================
    function renderAreaChart(canvas) {
        if (!window.Chart) return;
        const data = getBedOccupancyData();

        // Destroy existing
        if (canvas._chart) canvas._chart.destroy();

        const ctx = canvas.getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(79, 70, 229, 0.4)');
        gradient.addColorStop(1, 'rgba(79, 70, 229, 0.02)');

        canvas._chart = new window.Chart(canvas, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Bed Occupancy %',
                    data: data.data,
                    borderColor: '#4f46e5',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#4f46e5',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `${ctx.parsed.y.toFixed(1)}% occupancy`,
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: (v) => v + '%',
                            font: { family: 'Inter', size: 10 },
                            color: '#6b7280',
                        },
                        grid: { color: '#f3f4f6' },
                    },
                    x: {
                        ticks: { font: { family: 'Inter', size: 10 }, color: '#6b7280' },
                        grid: { display: false },
                    },
                },
            },
        });
    }

    // ============================================================
    // ENHANCED SVG-TO-CANVAS CONVERSION
    // ============================================================
    function enhancedSvgConversion() {
        const page = (location.pathname.split('/').pop() || '').toLowerCase();

        // Find ALL SVGs on the page that might be charts
        const svgs = document.querySelectorAll('svg');
        const chartSvgs = [];

        svgs.forEach(svg => {
            // Skip if already replaced or inside a canvas parent
            if (svg.getAttribute('data-chart-converted')) return;
            if (svg.closest('canvas')) return;

            const w = parseInt(svg.getAttribute('width') || svg.style.width || '0', 10);
            const h = parseInt(svg.getAttribute('height') || svg.style.height || '0', 10);
            const viewBox = svg.getAttribute('viewBox');
            let vbW = 0, vbH = 0;
            if (viewBox) {
                const parts = viewBox.split(/\s+/);
                vbW = parseFloat(parts[2]) || 0;
                vbH = parseFloat(parts[3]) || 0;
            }

            // Heuristic: SVG is a chart if it has rect/circle/path/polyline AND is reasonably large
            const hasChartShapes = svg.querySelector('rect:not([width="24"]):not([width="20"]):not([width="16"]), circle:not([r="3"]):not([r="10"]), polyline, path[d^="M"][d*="L"]');
            const isLarge = w > 100 || h > 100 || vbW > 100 || vbH > 100;

            if (hasChartShapes && isLarge) {
                chartSvgs.push(svg);
            }
        });

        // Map pages to chart types
        const pageCharts = {
            'index.html': ['appointments-by-day', 'appointments-by-status', 'revenue-by-month', 'bed-occupancy'],
            'doctor-dashboard.html': ['appointments-by-day', 'patients-by-department'],
            'patient-dashboard.html': ['appointments-by-status'],
            'lab-dashboard.html': ['lab-results-by-flag'],
            'nurse-station.html': ['appointments-by-status', 'bed-occupancy'],
            'ot-dashboard.html': ['surgeries-by-status'],
            'physiotherapy-dashboard.html': ['appointments-by-status'],
            'business-dashboard.html': ['revenue-by-month', 'invoices-by-status'],
            'super-admin.html': ['staff-by-department', 'patients-by-gender'],
            'billing.html': ['invoices-by-status', 'revenue-by-month'],
            'inventory.html': ['inventory-by-status'],
            'blood-stock.html': ['blood-units-by-type'],
            'appointments.html': ['appointments-by-day'],
            'patients.html': ['patients-by-gender'],
            'operational-reports.html': ['appointments-by-status', 'bed-occupancy'],
            'financial-reports.html': ['revenue-by-month', 'invoices-by-status'],
            'reports.html': ['appointments-by-day', 'revenue-by-month'],
        };

        const charts = pageCharts[page] || [];
        let replaced = 0;

        chartSvgs.forEach((svg, idx) => {
            if (idx >= charts.length) return;
            const chartType = charts[idx];

            // Create canvas replacement
            const canvas = document.createElement('canvas');
            canvas.setAttribute('data-chart', chartType);
            canvas.style.width = '100%';
            canvas.style.height = '240px';
            canvas.style.maxHeight = '240px';
            canvas.setAttribute('data-chart-converted', 'true');

            // Preserve parent styling
            const parent = svg.parentElement;
            if (parent) {
                parent.style.position = 'relative';
                parent.style.minHeight = '200px';
            }

            svg.parentNode.replaceChild(canvas, svg);
            replaced++;
        });

        return replaced;
    }

    // ============================================================
    // RENDER WITH LOADING + EMPTY STATES
    // ============================================================
    function renderChartsWithStates() {
        const canvases = document.querySelectorAll('canvas[data-chart]');
        canvases.forEach(canvas => {
            const chartType = canvas.getAttribute('data-chart');
            const parent = canvas.parentElement;
            if (!parent) return;

            // Show loading
            showLoading(parent);

            // Simulate async data fetch (in production, this would be an API call)
            setTimeout(() => {
                hideLoading(parent);

                // Check if there's data
                const data = getDataForChartCheck(chartType);
                if (!data || data.length === 0 || (Array.isArray(data) && data.every(v => v === 0))) {
                    showEmptyState(parent, `No ${chartType.replace(/-/g, ' ')} data`);
                } else {
                    hideEmptyState(parent);
                }

                // For bed-occupancy, use the area chart renderer
                if (chartType === 'bed-occupancy') {
                    renderAreaChart(canvas);
                }
            }, 300);
        });
    }

    function getDataForChartCheck(chartType) {
        try {
            switch (chartType) {
                case 'appointments-by-day':
                case 'appointments-by-status':
                    return STORE.list('appointments') || [];
                case 'revenue-by-month':
                case 'invoices-by-status':
                    return STORE.list('invoices') || [];
                case 'patients-by-department':
                case 'patients-by-gender':
                    return STORE.list('patients') || [];
                case 'lab-results-by-flag':
                    return STORE.list('labResults') || [];
                case 'inventory-by-status':
                    return STORE.list('inventory') || [];
                case 'staff-by-department':
                    return STORE.list('staff') || [];
                case 'blood-units-by-type':
                    return STORE.list('bloodUnits') || [];
                case 'surgeries-by-status':
                    return STORE.list('surgeries') || [];
                case 'bed-occupancy':
                    return STORE.list('rooms') || [];
                default:
                    return [];
            }
        } catch (e) {
            return [];
        }
    }

    // ============================================================
    // AUTO-REFRESH EVERY 30 SECONDS
    // ============================================================
    function startAutoRefresh() {
        if (refreshInterval) clearInterval(refreshInterval);
        refreshInterval = setInterval(() => {
            // Re-render charts
            if (window.MeditrackChartRenderers?.renderAll) {
                window.MeditrackChartRenderers.renderAll();
            }
            // Update KPIs
            updateKPICounters();
            // Re-render with states
            renderChartsWithStates();
        }, 30000);
    }

    // ============================================================
    // INIT
    // ============================================================
    function init() {
        // Enhanced SVG conversion (catches more patterns than the base module)
        const converted = enhancedSvgConversion();
        if (converted > 0) {
            console.log(`[ChartsEnhanced] Converted ${converted} SVG chart(s) to canvas`);
        }

        // Render with loading/empty states
        setTimeout(renderChartsWithStates, 500);

        // Update KPI counters
        setTimeout(updateKPICounters, 800);

        // Start auto-refresh
        startAutoRefresh();

        // Re-run when store changes
        STORE.onChange(() => {
            setTimeout(() => {
                renderChartsWithStates();
                updateKPICounters();
            }, 200);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    setTimeout(init, 1500);
    setTimeout(init, 3000);

})(window, document);

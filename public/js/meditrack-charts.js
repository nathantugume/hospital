/**
 * Meditrack HMS — Charts Module
 * ============================================================
 * Loads Chart.js from CDN if not present, then renders charts on
 * dashboard pages by reading live data from MeditrackStore.
 *
 * Supported chart types:
 *   - Bar chart (e.g., appointments by day)
 *   - Line chart (e.g., revenue trend)
 *   - Donut/Pie chart (e.g., patients by department)
 *   - Stacked bar (e.g., lab results by flag)
 *
 * Usage (auto-detect on dashboards):
 *   Place a <canvas data-chart="appointments-by-day"></canvas>
 *   anywhere on a dashboard page and this script will render it.
 *
 * Supported data-chart attributes:
 *   - appointments-by-day       (bar)
 *   - appointments-by-status    (donut)
 *   - revenue-by-month          (line)
 *   - patients-by-department    (bar)
 *   - patients-by-gender        (donut)
 *   - lab-results-by-flag       (donut)
 *   - inventory-by-status       (donut)
 *   - staff-by-department       (bar)
 *   - invoices-by-status        (donut)
 *   - blood-units-by-type       (bar)
 *   - surgeries-by-status       (donut)
 *   - weekly-activity           (line)
 */

(function(window, document) {
    'use strict';

    const CHART_JS_CDN = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js';

    // ============================================================
    // 1. LOAD CHART.JS FROM CDN (if not already loaded)
    // ============================================================
    function loadChartJs() {
        return new Promise((resolve, reject) => {
            if (window.Chart) {
                resolve(window.Chart);
                return;
            }
            const script = document.createElement('script');
            script.src = CHART_JS_CDN;
            script.async = true;
            script.onload = () => resolve(window.Chart);
            script.onerror = () => reject(new Error('Failed to load Chart.js from CDN'));
            document.head.appendChild(script);
        });
    }

    // ============================================================
    // 2. DATA EXTRACTORS — read from MeditrackStore
    // ============================================================
    function getDataForChart(chartType) {
        if (!window.MeditrackStore) return null;
        const S = window.MeditrackStore;

        switch (chartType) {
            case 'appointments-by-day': {
                const appts = S.list('appointments') || [];
                const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                const counts = [0, 0, 0, 0, 0, 0, 0];
                appts.forEach(a => {
                    if (!a.date) return;
                    const d = new Date(a.date);
                    const dayIdx = (d.getDay() + 6) % 7; // Mon=0, Sun=6
                    counts[dayIdx]++;
                });
                // If no data, show demo data
                if (counts.every(c => c === 0)) return { labels: days, data: [12, 19, 15, 22, 18, 8, 4] };
                return { labels: days, data: counts };
            }

            case 'appointments-by-status': {
                const appts = S.list('appointments') || [];
                const statuses = {};
                appts.forEach(a => { statuses[a.status] = (statuses[a.status] || 0) + 1; });
                const labels = Object.keys(statuses);
                const data = Object.values(statuses);
                if (!labels.length) return { labels: ['Confirmed', 'Pending', 'Completed', 'Cancelled'], data: [45, 12, 28, 8] };
                return { labels, data };
            }

            case 'revenue-by-month': {
                const invoices = S.list('invoices') || [];
                const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                const revenue = new Array(12).fill(0);
                invoices.forEach(inv => {
                    if (!inv.date) return;
                    const m = new Date(inv.date).getMonth();
                    revenue[m] += Number(inv.amount || 0);
                });
                // If no real data, show demo
                if (revenue.every(r => r === 0)) return { labels: months, data: [4500000, 5200000, 4800000, 6100000, 5900000, 6700000, 7200000, 6800000, 7400000, 8100000, 7600000, 8900000] };
                return { labels: months, data: revenue };
            }

            case 'patients-by-department': {
                const patients = S.list('patients') || [];
                const depts = {};
                patients.forEach(p => {
                    const d = p.doctor || 'Unassigned';
                    depts[d] = (depts[d] || 0) + 1;
                });
                const labels = Object.keys(depts);
                const data = Object.values(depts);
                if (!labels.length) return { labels: ['Cardiology', 'Pediatrics', 'Internal Medicine', 'Surgery', 'OB/GYN'], data: [12, 18, 22, 8, 15] };
                return { labels, data };
            }

            case 'patients-by-gender': {
                const patients = S.list('patients') || [];
                const male = patients.filter(p => p.gender === 'Male').length;
                const female = patients.filter(p => p.gender === 'Female').length;
                const other = patients.filter(p => p.gender && p.gender !== 'Male' && p.gender !== 'Female').length;
                if (male + female + other === 0) return { labels: ['Male', 'Female'], data: [55, 45] };
                return { labels: ['Male', 'Female', 'Other'], data: [male, female, other] };
            }

            case 'lab-results-by-flag': {
                const results = S.list('labResults') || [];
                const normal = results.filter(r => r.flag === 'Normal' || r.status === 'Normal').length;
                const high = results.filter(r => r.flag === 'High').length;
                const low = results.filter(r => r.flag === 'Low').length;
                const critical = results.filter(r => r.flag === 'Critical').length;
                if (normal + high + low + critical === 0) return { labels: ['Normal', 'High', 'Low', 'Critical'], data: [85, 8, 5, 2] };
                return { labels: ['Normal', 'High', 'Low', 'Critical'], data: [normal, high, low, critical] };
            }

            case 'inventory-by-status': {
                const items = S.list('inventory') || [];
                const inStock = items.filter(i => i.status === 'In Stock').length;
                const low = items.filter(i => i.status === 'Low Stock' || i.status === 'Critical').length;
                const out = items.filter(i => i.status === 'Out of Stock').length;
                if (inStock + low + out === 0) return { labels: ['In Stock', 'Low Stock', 'Out of Stock'], data: [120, 18, 7] };
                return { labels: ['In Stock', 'Low Stock', 'Out of Stock'], data: [inStock, low, out] };
            }

            case 'staff-by-department': {
                const staff = S.list('staff') || [];
                const depts = {};
                staff.forEach(s => {
                    const d = s.department || 'Unassigned';
                    depts[d] = (depts[d] || 0) + 1;
                });
                const labels = Object.keys(depts);
                const data = Object.values(depts);
                if (!labels.length) return { labels: ['Cardiology', 'Pediatrics', 'Surgery', 'Emergency', 'Lab', 'Pharmacy'], data: [4, 5, 6, 8, 3, 2] };
                return { labels, data };
            }

            case 'invoices-by-status': {
                const invoices = S.list('invoices') || [];
                const paid = invoices.filter(i => i.status === 'Paid').length;
                const unpaid = invoices.filter(i => i.status === 'Unpaid').length;
                const partial = invoices.filter(i => i.status === 'Partially Paid').length;
                const overdue = invoices.filter(i => i.status === 'Overdue').length;
                if (paid + unpaid + partial + overdue === 0) return { labels: ['Paid', 'Unpaid', 'Partially Paid', 'Overdue'], data: [45, 18, 7, 4] };
                return { labels: ['Paid', 'Unpaid', 'Partially Paid', 'Overdue'], data: [paid, unpaid, partial, overdue] };
            }

            case 'blood-units-by-type': {
                const units = S.list('bloodUnits') || [];
                const types = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];
                const counts = new Array(8).fill(0);
                units.forEach(u => {
                    const idx = types.indexOf(u.bloodType);
                    if (idx !== -1) counts[idx]++;
                });
                if (counts.every(c => c === 0)) return { labels: types, data: [12, 3, 8, 2, 4, 1, 15, 5] };
                return { labels: types, data: counts };
            }

            case 'surgeries-by-status': {
                const surgeries = S.list('surgeries') || [];
                const scheduled = surgeries.filter(s => s.status === 'Scheduled').length;
                const inProgress = surgeries.filter(s => s.status === 'In Progress').length;
                const completed = surgeries.filter(s => s.status === 'Completed').length;
                const cancelled = surgeries.filter(s => s.status === 'Cancelled').length;
                if (scheduled + inProgress + completed + cancelled === 0) return { labels: ['Scheduled', 'In Progress', 'Completed', 'Cancelled'], data: [8, 2, 15, 3] };
                return { labels: ['Scheduled', 'In Progress', 'Completed', 'Cancelled'], data: [scheduled, inProgress, completed, cancelled] };
            }

            case 'weekly-activity': {
                // Composite: appointments + lab results + invoices over last 7 days
                const today = new Date();
                const labels = [];
                const apptData = [];
                const labData = [];
                const invData = [];
                for (let i = 6; i >= 0; i--) {
                    const d = new Date(today);
                    d.setDate(d.getDate() - i);
                    const dateStr = d.toISOString().slice(0, 10);
                    labels.push(d.toLocaleDateString('en', { weekday: 'short' }));
                    apptData.push((S.list('appointments') || []).filter(a => a.date === dateStr).length);
                    labData.push((S.list('labResults') || []).filter(r => r.resultDate === dateStr).length);
                    invData.push((S.list('invoices') || []).filter(inv => inv.date === dateStr).length);
                }
                // If all zero, show demo
                if (apptData.every(c => c === 0)) {
                    return { labels, datasets: [
                        { label: 'Appointments', data: [8, 12, 15, 10, 18, 22, 14] },
                        { label: 'Lab Results', data: [3, 5, 7, 4, 8, 6, 5] },
                        { label: 'Invoices', data: [2, 4, 6, 3, 7, 5, 4] },
                    ]};
                }
                return { labels, datasets: [
                    { label: 'Appointments', data: apptData },
                    { label: 'Lab Results', data: labData },
                    { label: 'Invoices', data: invData },
                ]};
            }

            default:
                return null;
        }
    }

    // ============================================================
    // 3. CHART CONFIGS — colors, options per chart type
    // ============================================================
    const PALETTE = ['#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#3b82f6', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316', '#84cc16'];

    function buildChartConfig(chartType, canvas) {
        const data = getDataForChart(chartType);
        if (!data) return null;

        // Determine chart type from chart name
        const donutCharts = ['appointments-by-status', 'patients-by-gender', 'lab-results-by-flag', 'inventory-by-status', 'invoices-by-status', 'surgeries-by-status'];
        const lineCharts = ['revenue-by-month', 'weekly-activity'];
        const isDonut = donutCharts.includes(chartType);
        const isLine = lineCharts.includes(chartType);
        const type = isDonut ? 'doughnut' : (isLine ? 'line' : 'bar');

        const config = {
            type,
            data: {},
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: isDonut,
                        position: 'bottom',
                        labels: { font: { family: 'Inter', size: 11 }, color: '#6b7280' }
                    },
                    tooltip: {
                        bodyFont: { family: 'Inter' },
                        titleFont: { family: 'Inter' },
                    }
                },
                scales: isDonut ? {} : {
                    x: { ticks: { font: { family: 'Inter', size: 10 }, color: '#6b7280' }, grid: { display: false } },
                    y: { ticks: { font: { family: 'Inter', size: 10 }, color: '#6b7280' }, grid: { color: '#f3f4f6' }, beginAtZero: true }
                }
            }
        };

        if (isLine && data.datasets) {
            // Multi-dataset line chart (weekly-activity)
            config.data.labels = data.labels;
            config.data.datasets = data.datasets.map((ds, i) => ({
                label: ds.label,
                data: ds.data,
                borderColor: PALETTE[i % PALETTE.length],
                backgroundColor: PALETTE[i % PALETTE.length] + '20',
                tension: 0.3,
                fill: false,
            }));
        } else if (isDonut) {
            config.data.labels = data.labels;
            config.data.datasets = [{
                data: data.data,
                backgroundColor: PALETTE.slice(0, data.labels.length),
                borderWidth: 2,
                borderColor: '#fff',
            }];
        } else {
            // Bar chart
            config.data.labels = data.labels;
            config.data.datasets = [{
                label: chartType.replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()),
                data: data.data,
                backgroundColor: PALETTE[0],
                borderRadius: 4,
            }];
            // For revenue-by-month, format Y axis as currency
            if (chartType === 'revenue-by-month') {
                config.options.scales.y.ticks.callback = function(value) {
                    if (value >= 1000000) return 'UGX ' + (value / 1000000).toFixed(1) + 'M';
                    if (value >= 1000) return 'UGX ' + (value / 1000).toFixed(0) + 'K';
                    return 'UGX ' + value;
                };
            }
        }

        return config;
    }

    // ============================================================
    // 4. AUTO-RENDER — find all <canvas data-chart="..."> on the page
    // ============================================================
    const renderedCharts = new Map();

    function renderAllCharts() {
        const canvases = document.querySelectorAll('canvas[data-chart]');
        if (canvases.length === 0) return;

        canvases.forEach(canvas => {
            const chartType = canvas.getAttribute('data-chart');
            const config = buildChartConfig(chartType, canvas);
            if (!config) return;

            // Destroy existing chart if re-rendering
            if (renderedCharts.has(canvas)) {
                renderedCharts.get(canvas).destroy();
            }

            // Set canvas height if not set
            if (!canvas.style.height && !canvas.parentElement.style.height) {
                canvas.parentElement.style.height = '300px';
            }

            try {
                const chart = new window.Chart(canvas, config);
                renderedCharts.set(canvas, chart);
                console.log(`[Charts] Rendered ${chartType} on`, canvas);
            } catch (e) {
                console.error(`[Charts] Failed to render ${chartType}:`, e);
            }
        });
    }

    // ============================================================
    // 5. AUTO-CONVERT EXISTING SVG CHARTS — replace static SVG
    //    bar/line/donut visualizations with live Chart.js canvases
    // ============================================================
    function autoConvertSvgCharts() {
        // Look for common patterns of static SVG charts and replace them
        // Pattern 1: Donut SVGs with class containing "donut" or "pie"
        const svgDonuts = document.querySelectorAll('svg[class*="donut"], svg[class*="pie"], svg[data-chart-type="donut"]');
        svgDonuts.forEach((svg, idx) => {
            const parent = svg.parentElement;
            if (!parent) return;
            // Determine which chart to render based on page
            const page = (location.pathname.split('/').pop() || '').toLowerCase();
            const pageChartMap = {
                'index.html': 'appointments-by-status',
                'doctor-dashboard.html': 'appointments-by-status',
                'lab-dashboard.html': 'lab-results-by-flag',
                'inventory.html': 'inventory-by-status',
                'billing.html': 'invoices-by-status',
                'blood-stock.html': 'blood-units-by-type',
                'ot-dashboard.html': 'surgeries-by-status',
            };
            const chartType = pageChartMap[page];
            if (!chartType) return;
            // Replace SVG with canvas
            const canvas = document.createElement('canvas');
            canvas.setAttribute('data-chart', chartType);
            canvas.style.maxHeight = '240px';
            svg.parentNode.replaceChild(canvas, svg);
        });
    }

    // ============================================================
    // 6. INIT
    // ============================================================
    function init() {
        // Only run on dashboard pages
        const page = (location.pathname.split('/').pop() || '').toLowerCase();
        const dashboardPages = [
            'index.html', 'doctor-dashboard.html', 'patient-dashboard.html',
            'lab-dashboard.html', 'nurse-station.html', 'ot-dashboard.html',
            'physiotherapy-dashboard.html', 'business-dashboard.html',
            'super-admin.html', 'queue-dashboard.html',
            'billing.html', 'inventory.html', 'blood-stock.html',
            'appointments.html', 'patients.html', 'radiology-list.html',
            'operational-reports.html', 'financial-reports.html', 'reports.html',
        ];
        if (!dashboardPages.includes(page)) return;

        // Auto-convert SVG charts to canvas
        autoConvertSvgCharts();

        // Render all data-chart canvases
        if (document.querySelectorAll('canvas[data-chart]').length === 0) {
            // No explicit chart canvases — try to inject some based on the page
            injectDefaultCharts(page);
        }

        loadChartJs().then(() => {
            renderAllCharts();
            // Re-render when store changes
            if (window.MeditrackStore) {
                window.MeditrackStore.onChange(() => {
                    setTimeout(renderAllCharts, 100);
                });
            }
        }).catch(err => {
            console.warn('[Charts] Chart.js failed to load:', err.message);
        });
    }

    function injectDefaultCharts(page) {
        // Find chart containers on the page and inject canvases
        // Look for elements with class containing "chart" or "stats" that are empty or have placeholder SVGs
        const chartContainers = document.querySelectorAll('[class*="chart"], [id*="chart"], .card-body:has(svg)');
        const pageChartMap = {
            'index.html': [['appointments-by-day', 'bar'], ['appointments-by-status', 'donut'], ['revenue-by-month', 'line']],
            'doctor-dashboard.html': [['appointments-by-day', 'bar'], ['patients-by-department', 'bar']],
            'patient-dashboard.html': [['appointments-by-status', 'donut']],
            'lab-dashboard.html': [['lab-results-by-flag', 'donut']],
            'nurse-station.html': [['appointments-by-status', 'donut']],
            'ot-dashboard.html': [['surgeries-by-status', 'donut']],
            'business-dashboard.html': [['revenue-by-month', 'line'], ['invoices-by-status', 'donut']],
            'super-admin.html': [['staff-by-department', 'bar'], ['patients-by-gender', 'donut']],
            'billing.html': [['invoices-by-status', 'donut'], ['revenue-by-month', 'line']],
            'inventory.html': [['inventory-by-status', 'donut']],
            'blood-stock.html': [['blood-units-by-type', 'bar']],
        };
        const charts = pageChartMap[page];
        if (!charts) return;

        // Find SVG charts and replace them
        const svgs = document.querySelectorAll('svg');
        let svgIdx = 0;
        charts.forEach(([chartType, chartShape]) => {
            // Find an SVG that looks like a chart (has paths/circles/rects)
            for (let i = svgIdx; i < svgs.length; i++) {
                const svg = svgs[i];
                const hasChartElements = svg.querySelector('rect, circle, path, polyline');
                const w = parseInt(svg.getAttribute('width') || svg.style.width || '0', 10);
                const h = parseInt(svg.getAttribute('height') || svg.style.height || '0', 10);
                // Skip tiny SVGs (icons)
                if (hasChartElements && (w > 100 || h > 100 || svg.viewBox?.baseVal?.width > 100)) {
                    const canvas = document.createElement('canvas');
                    canvas.setAttribute('data-chart', chartType);
                    canvas.style.width = '100%';
                    canvas.style.height = '240px';
                    canvas.style.maxHeight = '240px';
                    svg.parentNode.replaceChild(canvas, svg);
                    svgIdx = i + 1;
                    break;
                }
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    // Re-run after delay for dynamically rendered content
    setTimeout(init, 1000);
    setTimeout(init, 2500);

})(window, document);

(() => {
    const instances = [];
    const dark = () => document.body.classList.contains('dark');
    const mount = (id, options) => {
        const element = document.getElementById(id);
        if (!element) return;
        const data = JSON.parse(element.dataset.chart);
        if (!window.ApexCharts) {
            element.textContent = 'Chart unavailable.';
            if (id === 'revenueChart') {
                element.nextElementSibling.open = true;
            } else {
                const list = document.createElement('ul');
                data.forEach(record => {
                    const item = document.createElement('li');
                    item.textContent = Object.entries(record).map(([key, value]) => `${key}: ${value}`).join(' · ');
                    list.append(item);
                });
                element.append(list);
            }
            return;
        }
        const configuration = options(data, element);
        if (!configuration) {
            element.classList.add('py-6', 'text-sm', 'text-gray-500', 'text-center');
            element.textContent = 'No data recorded for this period.';
            return;
        }
        const chart = new ApexCharts(element, {
            ...configuration,
            chart: {...configuration.chart, toolbar: {show: false}, fontFamily: 'Inter, sans-serif', background: 'transparent', redrawOnWindowResize: true},
            theme: {mode: dark() ? 'dark' : 'light'},
            grid: {borderColor: dark() ? '#333' : '#e5e7eb'},
        });
        chart.render();
        instances.push(chart);
        // The template animates the sidebar and hides tab panels. Re-measure
        // their actual width instead of retaining ApexCharts' initial width.
        let previousWidth = 0;
        let frame;
        const observer = new ResizeObserver(() => {
            cancelAnimationFrame(frame);
            frame = requestAnimationFrame(() => {
                const width = Math.floor(element.clientWidth);
                if (width > 0 && width !== previousWidth) {
                    previousWidth = width;
                    chart.updateOptions({chart: {width}}, false, false);
                }
            });
        });
        observer.observe(element);
    };
    mount('revenueChart', (data, element) => ({
        chart: {type: 'area', height: 320},
        series: [{name: `Revenue (${element.dataset.currency})`, data: data.map(point => point.revenue)}],
        colors: ['#4f46e5'],
        stroke: {curve: 'smooth', width: 3},
        fill: {type: 'gradient'},
        dataLabels: {enabled: false},
        xaxis: {categories: data.map(point => point.month)},
        yaxis: {labels: {formatter: value => new Intl.NumberFormat('en', {notation: 'compact'}).format(value)}},
        legend: {show: false},
    }));
    mount('demographicsChart', data => ({
        chart: {type: 'bar', height: 250},
        series: ['male', 'female', 'other'].map(key => ({name: key[0].toUpperCase() + key.slice(1), data: data.map(point => point[key])})),
        xaxis: {categories: data.map(point => point.label)},
        colors: ['#171717', '#ec4899', '#6366f1'],
        plotOptions: {bar: {borderRadius: 0, columnWidth: '60%'}},
        dataLabels: {enabled: false},
        yaxis: {decimalsInFloat: 0},
    }));
    ['appointmentTypesChart', 'revenueSourcesChart'].forEach(id => mount(id, data => data.length ? {
        chart: {type: 'donut', height: 250},
        series: data.map(point => point.value),
        labels: data.map(point => point.label),
        colors: ['#4f46e5', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6', '#64748b'],
        legend: {position: 'bottom'},
    } : null));
    document.addEventListener('blade:theme', () => instances.forEach(chart => chart.updateOptions({theme: {mode: dark() ? 'dark' : 'light'}, grid: {borderColor: dark() ? '#333' : '#e5e7eb'}})));
})();

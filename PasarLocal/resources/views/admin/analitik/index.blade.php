<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Analitik</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">Dashboard Analitik</h2>
    <button onclick="addAnalyticCard()" class="btn btn-primary mb-4">+ Tambah Analitik</button>
    <div id="analytic-container" class="row g-4"></div>
</div>

<script>
    let chartId = 0;
    let chartInstances = {};

    function addAnalyticCard() {
        chartId++;
        const container = document.getElementById('analytic-container');

        const col = document.createElement('div');
        col.className = 'col-md-6';

        const card = document.createElement('div');
        card.className = 'card p-3 shadow';
        card.innerHTML = `
            <div class="mb-2">
                <label class="form-label">Jenis Chart</label>
                <select class="form-select chart-type-${chartId}" onchange="autoDetectColumns(${chartId})">
                    <option value="bar">Bar</option>
                    <option value="line">Line</option>
                    <option value="pie">Pie</option>
                </select>
            </div>
            <div class="mb-2">
                <label class="form-label">Tabel</label>
                <select onchange="loadColumns(this, ${chartId})" class="form-select table-select-${chartId}"></select>
            </div>
            <div class="mb-2">
                <label class="form-label">Kolom X</label>
                <select class="form-select x-column-${chartId}"></select>
            </div>
            <div class="mb-2">
                <label class="form-label">Kolom Y</label>
                <select class="form-select y-column-${chartId}"></select>
            </div>
            <div class="mb-2">
                <label class="form-label">Agregasi</label>
                <select class="form-select aggregation-${chartId}">
                    <option value="count">Count</option>
                    <option value="sum">Sum</option>
                    <option value="avg">Average</option>
                </select>
            </div>
            <button onclick="generateChart(${chartId})" class="btn btn-success mb-2">Tampilkan</button>
            <div style="height: 300px;">
                <canvas id="chartCanvas-${chartId}"></canvas>
            </div>
        `;

        col.appendChild(card);
        container.appendChild(col);
        loadTables(chartId);
    }

    async function loadTables(id) {
        const res = await fetch("/admin/tables");
        const tables = await res.json();
        const select = document.querySelector(`.table-select-${id}`);
        select.innerHTML = tables.map(t => `<option value="${t}">${t}</option>`).join("");
        await loadColumns(select, id);
        autoDetectColumns(id);
    }
    async function autoDetectColumns(id) {
        const table = document.querySelector(`.table-select-${id}`).value;
        const chartType = document.querySelector(`.chart-type-${id}`).value;

        const res = await fetch(`/admin/columns/${table}`);
        const columns = await res.json();

        const timeCols = columns.filter(c =>
            c.type === 'date' || c.type === 'datetime' || c.name.includes('created') || c.name.includes('tanggal') || c.name.includes('waktu')
        );
        const numericCols = columns.filter(c => ['integer', 'bigint', 'decimal', 'float', 'double'].includes(c.type));
        const categoricalCols = columns.filter(c =>
            !numericCols.includes(c) && !timeCols.includes(c) && !c.name.includes('id')
        );

        let x = '', y = '', agg = 'sum';

        if (chartType === 'pie') {
            x = categoricalCols[0]?.name || 'id';
            y = numericCols[0]?.name || 'id';
            agg = 'sum';
        } else if (chartType === 'line') {
            x = timeCols[0]?.name || 'created_at';
            y = numericCols[0]?.name || 'id';
            agg = 'sum';
        } else { // bar
            x = categoricalCols[0]?.name || 'id';
            y = numericCols[0]?.name || 'id';
            agg = 'count';
        }

        const xSelect = document.querySelector(`.x-column-${id}`);
        const ySelect = document.querySelector(`.y-column-${id}`);
        const aggSelect = document.querySelector(`.aggregation-${id}`);

        if (xSelect && ySelect && aggSelect) {
            xSelect.value = x;
            ySelect.value = y;
            aggSelect.value = agg;
        }
    }

    async function loadColumns(selectEl, id) {
        const table = selectEl.value;
        const res = await fetch(`/admin/columns/${table}`);
        const columns = await res.json();
        console.log(columns);  // <-- tambahkan ini untuk cek data kolom yang didapat
        document.querySelector(`.x-column-${id}`).innerHTML = columns.map(c => `<option value="${c.name}">${c.name}</option>`).join("");
    document.querySelector(`.y-column-${id}`).innerHTML = columns.map(c => `<option value="${c.name}">${c.name}</option>`).join("");
    }

    async function generateChart(id) {
        const table = document.querySelector(`.table-select-${id}`).value;
        const x = document.querySelector(`.x-column-${id}`).value;
        const y = document.querySelector(`.y-column-${id}`).value;
        const aggregation = document.querySelector(`.aggregation-${id}`).value;
        const chartType = document.querySelector(`.chart-type-${id}`).value;

        const res = await fetch('/admin/chart-data', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ table, x, y, aggregation })
        });

        const data = await res.json();

        const labels = data.map(item => item.x);
        const values = data.map(item => item.value);

        const ctx = document.getElementById(`chartCanvas-${id}`).getContext('2d');
        if (chartInstances[id]) chartInstances[id].destroy();

        // Label dataset lebih dinamis: kalau agregasi count, cukup tampilkan "COUNT"
        let datasetLabel;
        if (aggregation.toLowerCase() === 'count') {
            datasetLabel = 'COUNT';
        } else {
            datasetLabel = `${aggregation.toUpperCase()} of ${y}`;
        }

        chartInstances[id] = new Chart(ctx, {
            type: chartType,
            data: {
                labels: labels,
                datasets: [{
                    label: datasetLabel,
                    data: values,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

</script>
</body>
</html>

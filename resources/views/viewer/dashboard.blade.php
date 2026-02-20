<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Monitoring Pencairan Dana</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 30px;
        }

        h1 {
            margin-bottom: 30px;
        }

        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 40px;
        }

        .card {
            flex: 1;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 3px 8px rgba(0,0,0,0.1);
        }

        .card h3 {
            margin: 0;
            font-size: 16px;
            color: #666;
        }

        .card h2 {
            margin-top: 10px;
            font-size: 24px;
        }

        .chart-container {
            background: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 40px;
            box-shadow: 0px 3px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<h1>Dashboard Monitoring Pencairan Dana</h1>

<div class="cards">
    <div class="card">
        <h3>Total Transaksi</h3>
        <h2>{{ $totalTransaksi }}</h2>
    </div>

    <div class="card">
        <h3>Total Dana Disalurkan</h3>
        <h2>Rp {{ number_format($totalDana,0,',','.') }}</h2>
    </div>

    <div class="card">
        <h3>Total Potongan</h3>
        <h2>Rp {{ number_format($totalPotongan,0,',','.') }}</h2>
    </div>

    <div class="card">
        <h3>Total Diterima</h3>
        <h2>Rp {{ number_format($totalDiterima,0,',','.') }}</h2>
    </div>
</div>

<div class="chart-container">
    <h3>Tren Pencairan per Bulan</h3>
    <canvas id="lineChart"></canvas>
</div>

<div class="chart-container">
    <h3>Distribusi Jenis Dana</h3>
    <canvas id="pieChart"></canvas>
</div>

<div class="chart-container">
    <h3>Status Notifikasi</h3>
    <canvas id="donutChart"></canvas>
</div>

<script>
// LINE CHART
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: [
            @foreach($perBulan as $item)
                "{{ $item->bulan }}",
            @endforeach
        ],
        datasets: [{
            label: 'Total Diterima',
            data: [
                @foreach($perBulan as $item)
                    {{ $item->total }},
                @endforeach
            ],
            fill: false,
            tension: 0.2
        }]
    }
});

// PIE CHART
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: [
            @foreach($perJenis as $item)
                "{{ $item->jenis_dana }}",
            @endforeach
        ],
        datasets: [{
            data: [
                @foreach($perJenis as $item)
                    {{ $item->total }},
                @endforeach
            ]
        }]
    }
});

// DONUT CHART
new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
        labels: [
            @foreach($statusNotif as $item)
                "{{ $item->status_notifikasi }}",
            @endforeach
        ],
        datasets: [{
            data: [
                @foreach($statusNotif as $item)
                    {{ $item->total }},
                @endforeach
            ]
        }]
    }
});
</script>

</body>
</html>
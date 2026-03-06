@extends('layouts.app')

@section('title')

@section('content')

<div class="flex justify-between items-start mb-8">

    <div>
        <h1 class="text-2xl font-semibold text-slate-800">
            Dashboard Monitoring
        </h1>

        <p class="text-sm text-slate-500">
            Ringkasan aktivitas sistem WAKU
        </p>
    </div>

</div>


{{-- ======================= STAT CARDS ======================= --}}

<div class="grid grid-cols-4 gap-6 mb-8">

    <div class="bg-white rounded-xl shadow-sm p-6 flex justify-between items-center">

        <div>
            <p class="text-sm text-slate-500">Total Pegawai</p>
            <h2 class="text-2xl font-semibold mt-2">
                {{ $totalPegawai }}
            </h2>
        </div>

        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
            <x-heroicon-o-user class="w-6 h-6 text-blue-500"/>
        </div>

    </div>


    <div class="bg-white rounded-xl shadow-sm p-6 flex justify-between items-center">

        <div>
            <p class="text-sm text-slate-500">Total Mitra</p>
            <h2 class="text-2xl font-semibold mt-2">
                {{ $totalMitra }}
            </h2>
        </div>

        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center">
            <x-heroicon-o-user-group class="w-6 h-6 text-indigo-500" />
        </div>

    </div>


    <div class="bg-white rounded-xl shadow-sm p-6 flex justify-between items-center">

        <div>
            <p class="text-sm text-slate-500">Kelompok Mitra</p>
            <h2 class="text-2xl font-semibold mt-2">
                {{ $totalKelompok }}
            </h2>
        </div>

        <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
            <x-heroicon-o-users class="w-6 h-6 text-purple-500"/>
        </div>

    </div>


    <div class="bg-white rounded-xl shadow-sm p-6 flex justify-between items-center">

        <div>
            <p class="text-sm text-slate-500">Total Pencairan</p>
            <h2 class="text-2xl font-semibold mt-2">
                Rp {{ number_format($totalPencairan,0,',','.') }}
            </h2>
        </div>

        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center">
            <x-heroicon-o-circle-stack class="w-6 h-6 text-slate-600"/>
        </div>

    </div>

</div>



{{-- ======================= WA STATUS ======================= --}}

<div class="grid grid-cols-3 gap-6 mb-10">

    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">

        <p class="text-sm text-slate-500">WA Berhasil</p>

        <h2 class="text-2xl font-semibold text-green-600 mt-2">
            {{ $waSuccess }}
        </h2>

    </div>


    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-red-500">

        <p class="text-sm text-slate-500">WA Gagal</p>

        <h2 class="text-2xl font-semibold text-red-600 mt-2">
            {{ $waError }}
        </h2>

    </div>


    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500">

        <p class="text-sm text-slate-500">WA Dalam Antrian</p>

        <h2 class="text-2xl font-semibold text-yellow-600 mt-2">
            {{ $waPending }}
        </h2>

    </div>

</div>

<!-- ================= GRAFIK MONITORING ================= -->

<div class="grid grid-cols-2 gap-6 mb-10">

    <!-- Grafik Pencairan Dana -->
    <div class="bg-white rounded-xl shadow-sm p-6">

        <h2 class="font-semibold text-slate-700 mb-4">
            Grafik Pencairan Dana
        </h2>

        <div class="h-[220px]">
        <canvas id="chartPencairan"></canvas>
        </div>

    </div>


    <!-- Grafik Status WhatsApp -->
    <div class="bg-white rounded-xl shadow-sm p-6">

        <h2 class="font-semibold text-slate-700 mb-4">
            Status Notifikasi WhatsApp
        </h2>

      <div class="h-[220px] flex justify-center items-center">
    <canvas id="chartWA"></canvas>
</div>
    </div>

</div>



{{-- ======================= PENCAIRAN TERBARU ======================= --}}

<div class="bg-white rounded-xl shadow-sm">

    <div class="px-6 py-4 border-b">

        <h2 class="font-semibold text-slate-700">
            Pencairan Terbaru
        </h2>

    </div>

    <table class="w-full text-sm">

        <thead class="bg-slate-50 text-slate-500">

        <tr>
            <th class="text-left px-6 py-3">Nama</th>
            <th class="text-left px-6 py-3">Jenis Dana</th>
            <th class="text-left px-6 py-3">Nominal</th>
            <th class="text-left px-6 py-3">Tanggal</th>
            <th class="text-left px-6 py-3">Status</th>
        </tr>

        </thead>

        <tbody>

        @forelse($latest as $item)

        <tr class="border-b hover:bg-slate-50">

            <td class="px-6 py-3">
                {{ $item->pegawai->nama ?? '-' }}
            </td>

            <td class="px-6 py-3">
                {{ $item->jenis_dana }}
            </td>

            <td class="px-6 py-3">
                Rp {{ number_format($item->nominal,0,',','.') }}
            </td>

            <td class="px-6 py-3">
                {{ $item->created_at->format('d M Y') }}
            </td>

            <td class="px-6 py-3">

                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                    berhasil
                </span>

            </td>

        </tr>

        @empty

        <tr>

            <td colspan="5" class="text-center py-6 text-slate-400">
                Tidak ada data pencairan
            </td>

        </tr>

        @endforelse

        </tbody>

    </table>

</div>
</div>

<script>

const ctxPencairan = document.getElementById('chartPencairan');

if (ctxPencairan) {

    new Chart(ctxPencairan, {

        type: 'line',

        data: {
            labels: @json($bulan),

            datasets: [{
                label: 'Pencairan Dana',

                data: @json($totalPencairanBulanan),

                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.15)',

                borderWidth: 2,
                tension: 0.45,
                fill: true,

                pointBackgroundColor: '#6366f1',
                pointBorderWidth: 0,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },

        options: {

            responsive: true,
            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                }

            },

            scales: {

                x: {
                    grid: {
                        display: false
                    }
                },

                y: {
                    beginAtZero: true,

                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },

                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }

            }

        }

    });

}


const ctxWA = document.getElementById('chartWA');

if (ctxWA) {

    new Chart(ctxWA, {

        type: 'doughnut',

        data: {

            labels: ['Success', 'Error', 'Pending'],

            datasets: [{

                data: [
                    {{ $waSuccess }},
                    {{ $waError }},
                    {{ $waPending }}
                ],

                backgroundColor: [
                    '#22c55e',
                    '#ef4444',
                    '#f59e0b'
                ],

                hoverOffset: 6,
                borderWidth: 0

            }]

        },

        options: {

            responsive: true,
            maintainAspectRatio: false,

            cutout: '75%',

            plugins: {

                legend: {

                    position: 'bottom',

                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 20
                    }

                }

            }

        }

    });

}

</script>

@endsection
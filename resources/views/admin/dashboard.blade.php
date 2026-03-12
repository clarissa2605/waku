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

<!-- Pegawai -->
<div class="rounded-2xl bg-blue-100 p-6 flex justify-between items-center shadow-sm">

<div>
<p class="text-sm text-slate-600">
Total Pegawai
</p>

<h2 class="text-3xl font-bold text-slate-900 mt-2">
{{ $totalPegawai }}
</h2>

<p class="text-xs text-blue-600 mt-1">
Data pegawai aktif
</p>
</div>

<div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center">
<x-heroicon-o-user class="w-6 h-6 text-white"/>
</div>

</div>


<!-- Mitra -->
<div class="rounded-2xl bg-yellow-100 p-6 flex justify-between items-center shadow-sm">

<div>
<p class="text-sm text-slate-600">
Total Mitra
</p>

<h2 class="text-3xl font-bold text-slate-900 mt-2">
{{ $totalMitra }}
</h2>

<p class="text-xs text-yellow-600 mt-1">
Mitra terdaftar
</p>
</div>

<div class="w-12 h-12 rounded-full bg-yellow-500 flex items-center justify-center">
<x-heroicon-o-user-group class="w-6 h-6 text-white"/>
</div>

</div>


<!-- Kelompok -->
<div class="rounded-2xl bg-green-100 p-6 flex justify-between items-center shadow-sm">

<div>
<p class="text-sm text-slate-600">
Kelompok Mitra
</p>

<h2 class="text-3xl font-bold text-slate-900 mt-2">
{{ $totalKelompok }}
</h2>

<p class="text-xs text-green-600 mt-1">
Kelompok aktif
</p>
</div>

<div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center">
<x-heroicon-o-users class="w-6 h-6 text-white"/>
</div>

</div>


<!-- Pencairan -->
<div class="rounded-2xl bg-purple-100 p-6 flex justify-between items-center shadow-sm">

<div>
<p class="text-sm text-slate-600">
Total Pencairan
</p>

<h2 class="text-2xl font-bold text-slate-900 mt-2">
Rp {{ number_format($totalPencairan,0,',','.') }}
</h2>

<p class="text-xs text-purple-600 mt-1">
Dana tersalurkan
</p>
</div>

<div class="w-12 h-12 rounded-full bg-purple-500 flex items-center justify-center">
<x-heroicon-o-circle-stack class="w-6 h-6 text-white"/>
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

<div class="grid grid-cols-[7fr_3fr] gap-6 mb-10">

<!-- Grafik Pencairan Dana -->
<div class="bg-white rounded-2xl shadow-[0_10px_25px_rgba(0,0,0,0.05)] p-6">

<div class="flex items-center justify-between mb-4">

<h2 class="font-semibold text-slate-700">
Grafik Pencairan Dana
</h2>

<div class="flex gap-2">

<button id="btn-bulan"
onclick="updateChart('bulan')" 
class="filter-btn px-3 py-1 text-xs rounded-lg bg-slate-100 hover:bg-slate-200 transition">
Bulan
</button>

<button id="btn-tahun"
onclick="updateChart('tahun')" 
class="filter-btn px-3 py-1 text-xs rounded-lg bg-slate-100 hover:bg-slate-200 transition">
Tahun
</button>

<button id="btn-semua"
onclick="updateChart('semua')" 
class="filter-btn px-3 py-1 text-xs rounded-lg bg-slate-100 hover:bg-slate-200 transition">
Semua
</button>

</div>

</div>

<div class="h-[260px]">
<canvas id="chartPencairan"></canvas>
</div>

</div>


<!-- Grafik Status WhatsApp -->
<div class="bg-white rounded-2xl shadow-[0_10px_25px_rgba(0,0,0,0.05)] p-6">

<div class="flex items-center justify-between mb-4">

<h2 class="font-semibold text-slate-700">
Status Notifikasi WhatsApp
</h2>

<div class="text-slate-400 text-xl cursor-pointer">
⋯
</div>

</div>

<div class="h-[260px] flex items-center justify-center">
<canvas id="chartWA"></canvas>
</div>

</div>

</div>



{{-- ======================= PENCAIRAN TERBARU ======================= --}}

<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">

<div class="px-6 py-4 border-b border-slate-200">
<h2 class="font-semibold text-slate-700">
Pencairan Terbaru
</h2>
</div>

<table class="w-full text-sm">

<thead class="bg-slate-50 text-slate-500 border-b border-slate-200">
<tr class="text-left">
<th class="px-6 py-3">Nama</th>
<th class="px-6 py-3">Jenis Dana</th>
<th class="px-6 py-3">Nominal</th>
<th class="px-6 py-3">Tanggal</th>
<th class="px-6 py-3">Status</th>
</tr>
</thead>

<tbody class="divide-y divide-slate-200">

@forelse($latest as $item)

<tr class="hover:bg-slate-50 transition">

<td class="px-6 py-3">

{{ $item->pegawai->nama ?? $item->mitra->nama_mitra ?? '-' }}

@if(isset($item->mitra))
<span class="text-xs text-orange-500 ml-1">(Mitra)</span>
@endif

</td>

<td class="px-6 py-3 text-slate-600">
{{ $item->jenis_dana }}
</td>

<td class="px-6 py-3 font-medium">
Rp {{ number_format($item->nominal,0,',','.') }}
</td>

<td class="px-6 py-3 text-slate-600">
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

</div>
</div>

<style>
.filter-active{
background:#01214d;
color:white;
box-shadow:0 4px 10px rgba(0,0,0,0.08);
}

.filter-active:hover{
background:#0a2f63;
}
</style>

<script>

const dataBulanan = @json($totalPencairanBulanan);
const labelBulanan = @json($bulan);

const dataTahunan = @json($totalPencairanTahunan);
const labelTahunan = @json($tahun);

const ctxPencairan = document.getElementById('chartPencairan');

let chart;

if (ctxPencairan) {

const ctx = ctxPencairan.getContext('2d');

const gradient = ctx.createLinearGradient(0,0,0,250);
gradient.addColorStop(0,'rgba(99,102,241,0.35)');
gradient.addColorStop(1,'rgba(99,102,241,0)');

chart = new Chart(ctxPencairan, {

type:'line',

data:{
labels:labelBulanan,

datasets:[{
label:'Pencairan Dana',
data:dataBulanan,
borderColor:'#6366f1',
backgroundColor:gradient,
borderWidth:3,
tension:0.45,
fill:true,

pointBackgroundColor:'#ffffff',
pointBorderColor:'#6366f1',
pointBorderWidth:3,
pointRadius:5,
pointHoverRadius:7
}]
},

options:{
responsive:true,
maintainAspectRatio:false,

interaction:{
intersect:false,
mode:'index'
},

plugins:{
legend:{display:false},

tooltip:{
backgroundColor:'#111827',
titleColor:'#fff',
bodyColor:'#fff',
padding:10,
displayColors:false
}
},

scales:{
x:{
grid:{display:false},
ticks:{color:'#64748b',font:{size:11}}
},

y:{
beginAtZero:true,
grid:{color:'rgba(0,0,0,0.04)'},
ticks:{
color:'#64748b',
font:{size:11},
callback:function(value){
return 'Rp '+value.toLocaleString('id-ID');
}
}
}
}
}

});

}

function updateChart(type){

document.querySelectorAll('.filter-btn')
.forEach(btn=>btn.classList.remove('filter-active'));

if(type==='bulan'){

document.getElementById('btn-bulan').classList.add('filter-active');

chart.data.labels=labelBulanan;
chart.data.datasets[0].data=dataBulanan;

}

if(type==='tahun'){

document.getElementById('btn-tahun').classList.add('filter-active');

chart.data.labels=labelTahunan;
chart.data.datasets[0].data=dataTahunan;

}

if(type==='semua'){

document.getElementById('btn-semua').classList.add('filter-active');

chart.data.labels=labelBulanan;
chart.data.datasets[0].data=dataBulanan;

}

chart.update();

}

document.getElementById('btn-bulan').classList.add('filter-active');


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
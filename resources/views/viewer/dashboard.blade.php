@extends('layouts.app')

@section('title','Executive Monitoring Dashboard')

@section('content')

<div class="space-y-6">

<!-- HEADER -->

<div>

<h2 class="text-2xl font-semibold text-slate-800">
Executive Monitoring Dashboard
</h2>

<p class="text-sm text-slate-500">
Monitoring pencairan dana pegawai dan mitra BPS
</p>

</div>



<!-- KPI SECTION -->

<div class="grid grid-cols-4 gap-5">

<div class="bg-blue-100 rounded-xl p-6 flex items-center justify-between">

<div>

<p class="text-sm text-slate-600">Total Dana</p>

<p class="text-2xl font-semibold">
Rp {{ number_format($totalDana,0,',','.') }}
</p>

<p class="text-xs text-blue-600">Dana tersalurkan</p>

</div>

<div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white">

<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M12 8c-3.866 0-7 1.343-7 3v4c0 1.657 3.134 3 7 3s7-1.343 7-3v-4c0-1.657-3.134-3-7-3z"/>
</svg>

</div>

</div>



<div class="bg-green-100 rounded-xl p-6 flex items-center justify-between">

<div>

<p class="text-sm text-slate-600">Dana Pegawai</p>

<p class="text-2xl font-semibold">
Rp {{ number_format($totalDanaPegawai,0,',','.') }}
</p>

<p class="text-xs text-green-600">Pencairan pegawai</p>

</div>

<div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white">

<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M5.121 17.804A8 8 0 1118.364 6.64M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
</svg>

</div>

</div>



<div class="bg-yellow-100 rounded-xl p-6 flex items-center justify-between">

<div>

<p class="text-sm text-slate-600">Dana Mitra</p>

<p class="text-2xl font-semibold">
Rp {{ number_format($totalDanaMitra,0,',','.') }}
</p>

<p class="text-xs text-yellow-600">Pencairan mitra</p>

</div>

<div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center text-white">

<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M17 20h5V4H2v16h5m10 0v-6a4 4 0 10-8 0v6"/>
</svg>

</div>

</div>



<div class="bg-purple-100 rounded-xl p-6 flex items-center justify-between">

<div>

<p class="text-sm text-slate-600">Total Transaksi</p>

<p class="text-2xl font-semibold">
{{ $totalTransaksi }}
</p>

<p class="text-xs text-purple-600">Total pencairan</p>

</div>

<div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center text-white">

<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M9 17v-6h13v6M9 7V3h13v4"/>
</svg>

</div>

</div>

</div>



<!-- ROW 1 -->

<div class="grid grid-cols-12 gap-6">

<!-- LINE CHART -->

<div class="col-span-6 bg-white border rounded-xl p-6">

<h3 class="font-semibold mb-4">
Tren Pencairan Dana
</h3>

<canvas id="lineChart" height="90"></canvas>

</div>



<!-- PIE CHART -->

<div class="col-span-3 bg-white border rounded-xl p-6">

<h3 class="font-semibold mb-4 text-sm">
Distribusi Jenis Dana
</h3>

<canvas id="pieChart" height="90"></canvas>

</div>



<!-- PIE CHART -->

<div class="col-span-3 bg-white border rounded-xl p-6">

<h3 class="font-semibold mb-4 text-sm">
Pegawai vs Mitra
</h3>

<canvas id="pegawaiMitraChart" height="90"></canvas>

</div>

</div>



<!-- ROW 2 -->

<div class="grid grid-cols-12 gap-6">

<!-- BAR CHART -->

<div class="col-span-6 bg-white border rounded-xl p-6">

<h3 class="font-semibold mb-4">
Pencairan per Unit Kerja
</h3>

<canvas id="barChart" height="90"></canvas>

</div>



<!-- TOP 10 -->

<div class="col-span-6 bg-white border rounded-xl p-6">

<h3 class="font-semibold mb-4">
Top 10 Pencairan Terbesar
</h3>

<table class="w-full text-sm">

<thead class="border-b text-slate-500">

<tr>
<th class="py-2 text-left">Nama</th>
<th class="text-left">Jenis Dana</th>
<th class="text-right">Nominal</th>
</tr>

</thead>

<tbody>

@foreach($topPencairan as $item)

<tr class="border-b">

<td class="py-2">
{{ $item->nama }}
</td>

<td>
{{ $item->jenis_dana }}
</td>

<td class="text-right font-medium">
Rp {{ number_format($item->nominal_bersih,0,',','.') }}
</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>



</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('lineChart'),{

type:'line',

data:{
labels:[
@foreach($perBulan as $item)
"{{ $item->nama_bulan }}",
@endforeach
],

datasets:[{

label:'Total Dana',

data:[
@foreach($perBulan as $item)
{{ $item->total }},
@endforeach
],

borderColor:'#4f46e5',

backgroundColor:'rgba(79,70,229,0.15)',

fill:true,

tension:0.4

}]

},

options:{
responsive:true,
maintainAspectRatio:false
}

});



new Chart(document.getElementById('pieChart'),{

type:'pie',

data:{
labels:[
@foreach($perJenis as $item)
"{{ $item->jenis_dana }}",
@endforeach
],

datasets:[{

data:[
@foreach($perJenis as $item)
{{ $item->total }},
@endforeach
],

backgroundColor:[
'#4f46e5',
'#22c55e',
'#f59e0b',
'#ef4444'
]

}]

}

});



new Chart(document.getElementById('pegawaiMitraChart'),{

type:'doughnut',

data:{
labels:['Pegawai','Mitra'],

datasets:[{

data:[
{{ $totalDanaPegawai }},
{{ $totalDanaMitra }}
],

backgroundColor:[
'#4f46e5',
'#22c55e'
]

}]

}

});



new Chart(document.getElementById('barChart'),{

type:'bar',

data:{
labels:[
@foreach($perUnit as $item)
"{{ $item->unit_kerja }}",
@endforeach
],

datasets:[{

label:'Total Dana',

data:[
@foreach($perUnit as $item)
{{ $item->total }},
@endforeach
],

backgroundColor:'#4f46e5'

}]

},

options:{
responsive:true,
maintainAspectRatio:false
}

});

</script>

@endsection
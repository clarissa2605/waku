@extends('layouts.app')

@section('title')

@section('content')

<div class="space-y-6">

<div>
<h2 class="text-2xl font-semibold text-slate-800">
Executive Monitoring Dashboard
</h2>

<p class="text-sm text-slate-500">
Monitoring pencairan dana pegawai dan mitra BPS
</p>
</div>


<!-- KPI -->

<!-- KPI -->

<div class="grid grid-cols-4 gap-5">

<!-- TOTAL DANA -->
<div class="bg-blue-100 rounded-xl p-6 flex justify-between items-center">
<div>
<p class="text-sm text-slate-600">Total Dana</p>
<p class="text-2xl font-semibold">
Rp {{ number_format($totalDana,0,',','.') }}
</p>
<p class="text-xs text-blue-600">Dana tersalurkan</p>
</div>

<div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white shrink-0">

<!-- Heroicon: banknotes -->
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
<path stroke-linecap="round" stroke-linejoin="round"
d="M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z"/>
<path stroke-linecap="round" stroke-linejoin="round"
d="M12 8v8m4-4H8"/>
</svg>

</div>
</div>


<!-- DANA PEGAWAI -->
<div class="bg-green-100 rounded-xl p-6 flex justify-between items-center">
<div>
<p class="text-sm text-slate-600">Dana Pegawai</p>
<p class="text-2xl font-semibold">
Rp {{ number_format($totalDanaPegawai,0,',','.') }}
</p>
<p class="text-xs text-green-600">Pencairan pegawai</p>
</div>

<div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center text-white shrink-0">

<!-- Heroicon: user -->
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
<path stroke-linecap="round" stroke-linejoin="round"
d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
<path stroke-linecap="round" stroke-linejoin="round"
d="M4.5 20.25a7.5 7.5 0 0115 0"/>
</svg>

</div>
</div>


<!-- DANA MITRA -->
<div class="bg-yellow-100 rounded-xl p-6 flex justify-between items-center">
<div>
<p class="text-sm text-slate-600">Dana Mitra</p>
<p class="text-2xl font-semibold">
Rp {{ number_format($totalDanaMitra,0,',','.') }}
</p>
<p class="text-xs text-yellow-600">Pencairan mitra</p>
</div>

<div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center text-white shrink-0">

<!-- Heroicon: users -->
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
<path stroke-linecap="round" stroke-linejoin="round"
d="M18 18.72a8.96 8.96 0 00-6-2.22 8.96 8.96 0 00-6 2.22"/>
<path stroke-linecap="round" stroke-linejoin="round"
d="M12 12a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z"/>
</svg>

</div>
</div>


<!-- TOTAL TRANSAKSI -->
<div class="bg-purple-100 rounded-xl p-6 flex justify-between items-center">
<div>
<p class="text-sm text-slate-600">Total Transaksi</p>
<p class="text-2xl font-semibold">
{{ $totalTransaksi }}
</p>
<p class="text-xs text-purple-600">Total pencairan</p>
</div>

<div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center text-white shrink-0">

<!-- Heroicon: receipt -->
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
<path stroke-linecap="round" stroke-linejoin="round"
d="M3 7.5h18M3 12h18M3 16.5h18"/>
</svg>

</div>
</div>

</div>


<!-- ROW 1 -->

<div class="grid grid-cols-12 gap-6 items-stretch">

<div class="col-span-6 bg-white border rounded-xl p-5 h-[260px] flex flex-col">
<h3 class="font-semibold text-slate-700 mb-3">
Tren Pencairan Dana
</h3>
<div class="flex-1">
<canvas id="lineChart"></canvas>
</div>
</div>


<div class="col-span-3 bg-white border rounded-xl p-5 h-[260px] flex flex-col">
<h3 class="font-semibold text-slate-700 text-sm mb-3">
Distribusi Jenis Dana
</h3>
<div class="flex-1 flex items-center justify-center">
<canvas id="pieChart" class="max-h-[180px]"></canvas>
</div>
</div>


<div class="col-span-3 bg-white border rounded-xl p-5 h-[260px] flex flex-col">
<h3 class="font-semibold text-slate-700 text-sm mb-3">
Pegawai vs Mitra
</h3>
<div class="flex-1 flex items-center justify-center">
<canvas id="pegawaiMitraChart" class="max-h-[180px]"></canvas>
</div>
</div>

</div>


<div class="grid grid-cols-12 gap-6">

<div class="col-span-6 bg-white border rounded-xl p-5 h-[260px] flex flex-col">
<h3 class="font-semibold text-slate-700 mb-3">
Pencairan per Unit Kerja
</h3>
<div class="flex-1">
<canvas id="barChart"></canvas>
</div>
</div>


<div class="col-span-6 bg-white border rounded-xl p-5 h-[260px] flex flex-col">
<h3 class="font-semibold text-slate-700 mb-3">
Top 10 Pencairan Terbesar
</h3>

<div class="flex-1 overflow-y-auto">

<table class="w-full text-sm">

<thead class="border-b text-slate-500">
<tr>
<th class="text-left py-2">Nama</th>
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

const perBulan = @json($perBulan);
const perJenis = @json($perJenis);
const perUnit = @json($perUnit);

const wakuColor = '#01214d'
const wakuGreen = '#22c55e'

const rupiah = (value)=>{
return 'Rp ' + new Intl.NumberFormat('id-ID').format(value)
}

document.addEventListener("DOMContentLoaded", function() {


/* LINE CHART */

new Chart(document.getElementById('lineChart'),{

type:'line',

data:{
labels: perBulan.map(item => item.nama_bulan),

datasets:[{

data: perBulan.map(item => item.total),

borderColor:wakuColor,
backgroundColor:'rgba(1,33,77,0.15)',
fill:true,
tension:0.45

}]

},

options:{
responsive:true,
maintainAspectRatio:false,

plugins:{
legend:{display:false},

tooltip:{
callbacks:{
label:(context)=>rupiah(context.raw)
}
}

},

scales:{
y:{
ticks:{
callback:(value)=>rupiah(value)
}
}
}

}

})


/* PIE JENIS DANA */

new Chart(document.getElementById('pieChart'),{

type:'doughnut',

data:{
labels: perJenis.map(item => item.jenis_dana),

datasets:[{

data: perJenis.map(item => item.total),

backgroundColor:[
'#01214d',
'#2563eb',
'#22c55e',
'#f59e0b',
'#ef4444',
'#06b6d4',
'#8b5cf6'
]

}]

},

options:{
responsive:true,
maintainAspectRatio:false,
cutout:'60%',

layout:{
padding:20
},

plugins:{
legend:{display:false},

tooltip:{
callbacks:{
label:(context)=>context.label + ' : ' + rupiah(context.raw)
}
}

}

}

})


/* PEGAWAI VS MITRA */

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
wakuColor,
wakuGreen
]

}]

},

options:{
responsive:true,
maintainAspectRatio:false,
cutout:'60%'
}


})


/* BAR UNIT KERJA */

new Chart(document.getElementById('barChart'),{

type:'bar',

data:{
labels: perUnit.map(item => item.unit_kerja),

datasets:[{

data: perUnit.map(item => item.total),

backgroundColor:wakuColor,
borderRadius:6

}]

},

options:{
responsive:true,
maintainAspectRatio:false,

plugins:{
legend:{display:false},

tooltip:{
callbacks:{
label:(context)=>rupiah(context.raw)
}
}

},

scales:{
y:{
ticks:{
callback:(value)=>rupiah(value)
}
}
}

}

})

})

</script>

@endsection
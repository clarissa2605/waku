@extends('layouts.app')

@section('title')

@section('content')

<div class="space-y-8">

{{-- ================= HEADER ================= --}}
<div>

<h1 class="text-2xl font-semibold text-slate-800">
Laporan Aktivitas
</h1>

<p class="text-sm text-slate-500 mt-1">
Monitoring pencairan dana dan notifikasi WhatsApp
</p>

</div>



{{-- ================= FILTER & DOWNLOAD BOX ================= --}}
<div class="bg-white border border-slate-200 rounded-xl p-6 shadow-sm">

<div class="flex items-start justify-between flex-wrap gap-6">

{{-- TEXT EXPLANATION --}}
<div>

<h3 class="text-sm font-semibold text-slate-700">
Filter dan Unduh Laporan
</h3>

<p class="text-sm text-slate-500 mt-1 max-w-xl">
Silakan pilih bulan dan tahun laporan yang ingin ditampilkan.
Admin dapat menggunakan fitur ini untuk memfilter data pencairan dana
serta mengunduh laporan dalam bentuk PDF sesuai periode yang dipilih.
</p>

</div>



{{-- FILTER + DOWNLOAD --}}
<div class="flex items-center gap-3">

<form method="GET"
action="{{ route('laporan.index') }}"
class="flex items-center gap-2">

<select name="bulan"
class="bg-white border border-slate-300 rounded-lg px-4 py-2 text-sm">

@for($i=1;$i<=12;$i++)

<option value="{{ $i }}"
{{ request('bulan')==$i ? 'selected' : '' }}>

{{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}

</option>

@endfor

</select>


<select name="tahun"
class="bg-white border border-slate-300 rounded-lg px-7 py-2 text-sm">

@for($i=date('Y');$i>=2023;$i--)

<option value="{{ $i }}"
{{ request('tahun')==$i ? 'selected' : '' }}>

{{ $i }}

</option>

@endfor

</select>


<button
class="bg-slate-700 hover:bg-slate-800 text-white px-4 py-2 rounded-lg text-sm">

Filter

</button>

</form>


<a href="{{ route('laporan.export.pdf',[
'bulan'=>request('bulan'),
'tahun'=>request('tahun')
]) }}"

class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 text-sm shadow-sm">

<x-heroicon-o-arrow-down-tray class="w-5 h-5"/>

Unduh PDF

</a>

</div>

</div>

</div>


{{-- ================= SUMMARY CARDS ================= --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">

{{-- TOTAL PENCAIRAN --}}
<div class="bg-white border border-slate-200 rounded-xl p-6 hover:bg-slate-50">

<div class="flex items-center justify-between">

<div>

<p class="text-sm text-slate-500">
Total Pencairan
</p>

<p class="text-2xl font-semibold text-slate-800 mt-1">
{{ $totalPencairan }}
</p>

</div>

<div class="bg-blue-100 p-3 rounded-full">
<x-heroicon-o-banknotes class="w-6 h-6 text-blue-600"/>
</div>

</div>

</div>



{{-- TOTAL DANA --}}
<div class="bg-white border border-slate-200 rounded-xl p-6 hover:bg-slate-50">

<div class="flex items-center justify-between">

<div>

<p class="text-sm text-slate-500">
Total Dana
</p>

<p class="text-2xl font-semibold text-slate-800 mt-1">
Rp {{ number_format($totalDana,0,',','.') }}
</p>

</div>

<div class="bg-indigo-100 p-3 rounded-full">
<x-heroicon-o-currency-dollar class="w-6 h-6 text-indigo-600"/>
</div>

</div>

</div>



{{-- WA TERKIRIM --}}
<div class="bg-white border border-slate-200 rounded-xl p-6 hover:bg-slate-50">

<div class="flex items-center justify-between">

<div>

<p class="text-sm text-slate-500">
WA Terkirim
</p>

<p class="text-2xl font-semibold text-green-600 mt-1">
{{ $waTerkirim }}
</p>

</div>

<div class="bg-green-100 p-3 rounded-full">
<x-heroicon-o-check-circle class="w-6 h-6 text-green-600"/>
</div>

</div>

</div>



{{-- WA GAGAL --}}
<div class="bg-white border border-slate-200 rounded-xl p-6 hover:bg-slate-50">

<div class="flex items-center justify-between">

<div>

<p class="text-sm text-slate-500">
WA Gagal
</p>

<p class="text-2xl font-semibold text-red-600 mt-1">
{{ $waGagal }}
</p>

</div>

<div class="bg-red-100 p-3 rounded-full">
<x-heroicon-o-x-circle class="w-6 h-6 text-red-600"/>
</div>

</div>

</div>

</div>



{{-- ================= SUCCESS RATE ================= --}}
@php
$totalWA = $waTerkirim + $waGagal;
$successRate = $totalWA > 0 ? round(($waTerkirim/$totalWA)*100) : 0;
@endphp

<div class="bg-white border border-slate-200 rounded-xl p-6">

<div class="flex items-center justify-between mb-3">

<p class="text-sm font-medium text-slate-700">
Tingkat Keberhasilan Pengiriman WhatsApp
</p>

<p class="text-sm font-semibold text-blue-600">
{{ $successRate }}%
</p>

</div>

<div class="w-full bg-slate-100 rounded-full h-2">

<div class="bg-blue-600 h-2 rounded-full"
style="width: {{ $successRate }}%"></div>

</div>

</div>



{{-- ================= TABLE ================= --}}
<div class="bg-white border border-slate-200 rounded-xl">

<div class="p-6 border-b border-slate-200">

<h2 class="font-semibold text-slate-800">
Detail Laporan Pencairan
</h2>

</div>



<div class="overflow-x-auto">

<table class="w-full text-sm">

<thead class="text-slate-500 border-b border-slate-200 bg-slate-50">

<tr>

<th class="text-left px-6 py-3">
Tanggal
</th>

<th class="text-left px-6 py-3">
Nama
</th>

<th class="text-left px-6 py-3">
Tipe
</th>

<th class="text-left px-6 py-3">
Jenis Dana
</th>

<th class="text-left px-6 py-3">
Total Diterima
</th>

<th class="text-left px-6 py-3">
Status WA
</th>

</tr>

</thead>



<tbody>

@if($pencairans->count() == 0)

<tr>
<td colspan="6" class="text-center py-10 text-slate-400">
Belum ada data pencairan
</td>
</tr>

@else

@foreach($pencairans as $item)

<tr class="border-b border-slate-200 hover:bg-slate-50">

<td class="px-6 py-4">
{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
</td>

<td class="px-6 py-4 font-medium text-slate-700">
{{ $item->nama_penerima }}
</td>

<td class="px-6 py-4">

<span class="px-2 py-1 text-xs rounded-full
{{ $item->tipe == 'Pegawai'
? 'bg-blue-100 text-blue-600'
: 'bg-purple-100 text-purple-600' }}">

{{ $item->tipe }}

</span>

</td>

<td class="px-6 py-4 text-slate-600">
{{ $item->jenis_dana }}
</td>

<td class="px-6 py-4 font-medium">
Rp {{ number_format($item->total_diterima,0,',','.') }}
</td>

<td class="px-6 py-4">

@if($item->status_wa == 'terkirim')

<span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs">
Terkirim
</span>

@elseif($item->status_wa == 'gagal')

<span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs">
Gagal
</span>

@else

<span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs">
Belum
</span>

@endif

</td>

</tr>

@endforeach

@endif

</tbody>

</table>

</div>

</div>

</div>

@endsection
@extends('layouts.app')

@section('title')

@section('content')

<div class="space-y-8">

{{-- HEADER --}}
<div>

<h1 class="text-2xl font-semibold text-slate-800">
Dashboard
</h1>

<p class="text-sm text-slate-500">
Ringkasan pencairan dana yang Anda terima
</p>

</div>



{{-- ======================= STAT CARDS ======================= --}}

<div class="grid grid-cols-3 gap-6">

<!-- Total Dana -->
<div class="rounded-2xl bg-blue-100 p-6 flex justify-between items-center shadow-sm">

<div>
<p class="text-sm text-slate-600">
Total Dana
</p>

<h2 class="text-2xl font-bold text-slate-900 mt-2">
Rp {{ number_format($totalNominal,0,',','.') }}
</h2>

<p class="text-xs text-blue-600 mt-1">
Total dana diterima
</p>
</div>

<div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center">
<x-heroicon-o-banknotes class="w-6 h-6 text-white"/>
</div>

</div>


<!-- Potongan -->
<div class="rounded-2xl bg-red-100 p-6 flex justify-between items-center shadow-sm">

<div>
<p class="text-sm text-slate-600">
Total Potongan
</p>

<h2 class="text-2xl font-bold text-slate-900 mt-2">
Rp {{ number_format($totalPotongan,0,',','.') }}
</h2>

<p class="text-xs text-red-600 mt-1">
Potongan pajak / lainnya
</p>
</div>

<div class="w-12 h-12 rounded-full bg-red-500 flex items-center justify-center">
<x-heroicon-o-minus-circle class="w-6 h-6 text-white"/>
</div>

</div>


<!-- Bersih -->
<div class="rounded-2xl bg-green-100 p-6 flex justify-between items-center shadow-sm">

<div>
<p class="text-sm text-slate-600">
Total Diterima
</p>

<h2 class="text-2xl font-bold text-slate-900 mt-2">
Rp {{ number_format($totalBersih,0,',','.') }}
</h2>

<p class="text-xs text-green-600 mt-1">
Dana bersih diterima
</p>
</div>

<div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center">
<x-heroicon-o-check-circle class="w-6 h-6 text-white"/>
</div>

</div>

</div>



{{-- ======================= PENCAIRAN TERAKHIR ======================= --}}

<div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">

<p class="text-sm text-slate-500">
Pencairan Terakhir
</p>

@if($riwayat->first())

<h2 class="text-3xl font-semibold text-slate-800 mt-2">
Rp {{ number_format($riwayat->first()->nominal_bersih,0,',','.') }}
</h2>

<p class="text-sm text-slate-500 mt-1">
{{ $riwayat->first()->tanggal }}
</p>

@endif

</div>



{{-- ======================= RIWAYAT PENCAIRAN ======================= --}}

<div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">

<div class="px-6 py-4 border-b border-slate-200">

<h2 class="font-semibold text-slate-700">
Riwayat Pencairan Dana
</h2>

</div>

<table class="w-full text-sm">

<thead class="bg-slate-50 text-slate-500 border-b border-slate-200">

<tr class="text-left">
<th class="px-6 py-3">Tanggal</th>
<th class="px-6 py-3">Jenis Dana</th>
<th class="px-6 py-3">Nominal</th>
<th class="px-6 py-3">Potongan</th>
<th class="px-6 py-3">Diterima</th>
<th class="px-6 py-3">Status</th>
<th class="px-6 py-3"></th>
</tr>

</thead>

<tbody class="divide-y divide-slate-200">

@forelse($riwayat as $item)

<tr class="hover:bg-slate-50 transition">

<td class="px-6 py-3">
{{ $item->tanggal }}
</td>

<td class="px-6 py-3 text-slate-600">
{{ $item->jenis_dana }}
</td>

<td class="px-6 py-3 font-medium">
Rp {{ number_format($item->nominal,0,',','.') }}
</td>

<td class="px-6 py-3 text-red-600">
Rp {{ number_format($item->potongan,0,',','.') }}
</td>

<td class="px-6 py-3 text-green-600 font-medium">
Rp {{ number_format($item->nominal_bersih,0,',','.') }}
</td>

<td class="px-6 py-3">

@if($item->status_notifikasi == 'terkirim')

<span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
Terkirim
</span>

@elseif($item->status_notifikasi == 'gagal')

<span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600">
Gagal
</span>

@else

<span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
Diproses
</span>

@endif

</td>


<td class="px-6 py-3">

<a href="{{ route('pegawai.pencairan.detail', $item->id_pencairan) }}"
class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 transition">
Lihat Detail
</a>

</td>

</tr>

@empty

<tr>

<td colspan="7" class="text-center py-6 text-slate-400">
Belum ada data pencairan
</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

@endsection
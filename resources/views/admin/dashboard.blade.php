@extends('layouts.app')

@section('title', 'Dashboard Monitoring')

@section('content')

<div class="grid grid-cols-4 gap-6 mb-10">

    <div class="bg-white/70 backdrop-blur-lg p-6 rounded-2xl shadow-lg">
        <p class="text-sm text-gray-500">Total Pencairan</p>
        <h2 class="text-2xl font-bold text-indigo-600 mt-2">
            Rp {{ number_format($totalPencairan ?? 0) }}
        </h2>
    </div>

    <div class="bg-white/70 backdrop-blur-lg p-6 rounded-2xl shadow-lg">
        <p class="text-sm text-gray-500">Total Pegawai</p>
        <h2 class="text-2xl font-bold text-blue-600 mt-2">
            {{ $totalPegawai ?? 0 }}
        </h2>
    </div>

    <div class="bg-white/70 backdrop-blur-lg p-6 rounded-2xl shadow-lg">
        <p class="text-sm text-gray-500">Total Mitra</p>
        <h2 class="text-2xl font-bold text-purple-600 mt-2">
            {{ $totalMitra ?? 0 }}
        </h2>
    </div>

    <div class="bg-white/70 backdrop-blur-lg p-6 rounded-2xl shadow-lg">
        <p class="text-sm text-gray-500">Bulan Ini</p>
        <h2 class="text-2xl font-bold text-green-600 mt-2">
            Rp {{ number_format($bulanIni ?? 0) }}
        </h2>
    </div>

</div>

<!-- Riwayat Terbaru -->
<div class="bg-white/70 backdrop-blur-lg rounded-2xl shadow-lg p-8">

    <h2 class="text-lg font-semibold mb-6">Riwayat Pencairan Terbaru</h2>

    <table class="w-full text-sm">
        <thead class="text-gray-400 border-b">
            <tr>
                <th class="py-3 text-left">Nama</th>
                <th class="py-3 text-left">Mitra</th>
                <th class="py-3 text-left">Nominal</th>
                <th class="py-3 text-left">Tanggal</th>
                <th class="py-3 text-left">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($latest ?? [] as $item)
            <tr class="border-b hover:bg-white/50 transition">
                <td class="py-3">{{ $item->pegawai->nama ?? '-' }}</td>
                <td>{{ $item->mitra->nama ?? '-' }}</td>
                <td>Rp {{ number_format($item->nominal) }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>
                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                        {{ $item->status }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

@endsection
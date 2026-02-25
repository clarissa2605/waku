@extends('layouts.app')

@section('title')

@section('content')

<div class="mb-6">
    <h2 class="text-2xl font-semibold text-slate-800">
        Detail Mitra
    </h2>
    <p class="text-sm text-slate-500 mt-1">
        Informasi lengkap data mitra dalam sistem.
    </p>
</div>

<div class="bg-white border border-slate-200 rounded-xl p-8">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- LEFT --}}
        <div class="space-y-6">

            <div>
                <label class="text-sm text-slate-500">Nama Mitra</label>
                <div class="text-slate-800 font-medium">
                    {{ $mitra->nama_mitra }}
                </div>
            </div>

            <div>
                <label class="text-sm text-slate-500">NIK</label>
                <div class="text-slate-800">
                    {{ $mitra->nik }}
                </div>
            </div>

            <div>
                <label class="text-sm text-slate-500">Nomor WhatsApp</label>
                <div class="text-slate-800">
                    {{ $mitra->no_whatsapp ?? '-' }}
                </div>
            </div>

            <div>
                <label class="text-sm text-slate-500">Alamat</label>
                <div class="text-slate-800">
                    {{ $mitra->alamat ?? '-' }}
                </div>
            </div>

        </div>

        {{-- RIGHT --}}
        <div class="space-y-6">

            <div>
                <label class="text-sm text-slate-500">Jenis Mitra</label>
                <div class="text-slate-800">
                    {{ $mitra->jenis_mitra ?? '-' }}
                </div>
            </div>

            <div>
                <label class="text-sm text-slate-500">Tanggal Mulai Kontrak</label>
                <div class="text-slate-800">
                    {{ $mitra->tanggal_mulai_kontrak ?? '-' }}
                </div>
            </div>

            <div>
                <label class="text-sm text-slate-500">Tanggal Selesai Kontrak</label>
                <div class="text-slate-800">
                    {{ $mitra->tanggal_selesai_kontrak ?? '-' }}
                </div>
            </div>

            <div>
                <label class="text-sm text-slate-500">Status</label>
                <div>
                    @if($mitra->status === 'aktif')
                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                            Aktif
                        </span>
                    @else
                        <span class="px-3 py-1 text-xs rounded-full bg-slate-200 text-slate-600">
                            Nonaktif
                        </span>
                    @endif
                </div>
            </div>

        </div>

    </div>

    {{-- KELOMPOK --}}
    <div class="mt-8">
        <label class="text-sm text-slate-500">Kelompok Mitra</label>

        <div class="mt-2 flex flex-wrap gap-2">
            @if($mitra->kelompok->count())
                @foreach($mitra->kelompok as $kel)
                    <span class="px-3 py-1 text-xs bg-blue-100 text-blue-600 rounded-full">
                        {{ $kel->nama_kelompok }}
                    </span>
                @endforeach
            @else
                <span class="text-slate-500 text-sm">-</span>
            @endif
        </div>
    </div>

    <hr class="my-8">
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-2">
            <a href="{{ route('mitra.index') }}"
               class="text-sm text-slate-500 hover:text-blue-600 transition">
                ← Kembali ke Data Mitra
            </a>
    </div>

</div>

@endsection
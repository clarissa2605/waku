@extends('layouts.app')

@section('title')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-800">
        Edit Mitra
    </h1>
    <p class="text-sm text-slate-500 mt-1">
        Perbarui informasi mitra dalam sistem.
    </p>
</div>

<div class="bg-white border border-slate-200 rounded-xl p-8">

<form action="{{ route('mitra.update', $mitra->id_mitra) }}" method="POST">
@csrf
@method('PUT')

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">

    {{-- LEFT COLUMN --}}
    <div class="space-y-6">

        {{-- NAMA --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
                Nama Mitra
            </label>
            <input type="text"
                   name="nama_mitra"
                   value="{{ old('nama_mitra', $mitra->nama_mitra) }}"
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- NIK (LOCKED) --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
                NIK
            </label>

            <input type="text"
                   value="{{ $mitra->nik }}"
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm bg-slate-100 text-slate-500"
                   readonly>

            <input type="hidden" name="nik" value="{{ $mitra->nik }}">

            <p class="text-xs text-slate-500 mt-1">
                NIK merupakan master data dan tidak dapat diubah.
            </p>
        </div>

        {{-- WHATSAPP (LOCKED) --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
                Nomor WhatsApp
            </label>

            <input type="text"
                   value="{{ $mitra->no_whatsapp }}"
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm bg-slate-100 text-slate-500"
                   readonly>

            <input type="hidden" name="no_whatsapp" value="{{ $mitra->no_whatsapp }}">

            <p class="text-xs text-slate-500 mt-1">
                Nomor WhatsApp terdaftar sebagai kanal notifikasi resmi sistem.
            </p>
        </div>

        {{-- ALAMAT --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
                Alamat
            </label>
            <textarea name="alamat"
                rows="4"
                class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('alamat', $mitra->alamat) }}</textarea>
        </div>

    </div>


    {{-- RIGHT COLUMN --}}
    <div class="space-y-6">

        {{-- JENIS MITRA --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
                Jenis Mitra
            </label>
            <input type="text"
                   name="jenis_mitra"
                   value="{{ old('jenis_mitra', $mitra->jenis_mitra) }}"
                   class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        {{-- KELOMPOK --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
                Kelompok
            </label>

            <div class="bg-slate-100 border border-slate-200 rounded-lg p-4 text-sm space-y-1">

                @forelse($mitra->kelompok as $kel)
                    <div class="text-slate-700">
                        • {{ $kel->nama_kelompok }}
                    </div>
                @empty
                    <div class="text-slate-500">
                        Tidak tergabung dalam kelompok.
                    </div>
                @endforelse

            </div>

            <p class="text-xs text-slate-500 mt-1">
                Keanggotaan kelompok dikelola melalui menu Kelompok Mitra.
            </p>
        </div>

        {{-- STATUS --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">
                Status
            </label>

            <select name="status"
                    class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="aktif" {{ $mitra->status == 'aktif' ? 'selected' : '' }}>
                    Aktif
                </option>
                <option value="nonaktif" {{ $mitra->status == 'nonaktif' ? 'selected' : '' }}>
                    Nonaktif
                </option>
            </select>
        </div>

    </div>

</div>

<hr class="my-8">

<div class="flex justify-between items-center">

    <a href="{{ route('mitra.index') }}"
       class="text-sm text-slate-500 hover:text-blue-600 transition">
       ← Kembali ke Data Mitra
    </a>

    <button type="submit"
        class="bg-blue-600 text-white px-6 py-2 text-sm rounded-lg hover:bg-blue-700 transition">
        Update Mitra
    </button>

</div>

</form>
</div>

@endsection
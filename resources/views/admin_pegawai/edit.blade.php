@extends('layouts.app')

@section('title')

@section('content')

{{-- ================= PAGE HEADER ================= --}}
<div class="mb-8">
    <h1 class="text-2xl font-semibold text-slate-800">
        Edit Pegawai
    </h1>
    <p class="text-sm text-slate-500 mt-2">
        Perbarui informasi pegawai dalam sistem WAKU.
    </p>
</div>

{{-- ================= CARD ================= --}}
<div class="bg-white border border-slate-200 rounded-lg p-8">

    <form action="{{ route('pegawai.update', $pegawai->id_pegawai) }}"
          method="POST"
          class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- LEFT --}}
            <div class="space-y-6">

                {{-- NIP --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        NIP
                    </label>
                    <input type="text"
                           value="{{ $pegawai->nip }}"
                           readonly
                           class="w-full bg-slate-100 border border-slate-200 rounded-md px-4 py-2 text-sm text-slate-500 cursor-not-allowed">
                    <p class="text-xs text-slate-400 mt-1">
                        NIP tidak dapat diubah.
                    </p>
                </div>

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Lengkap
                    </label>
                    <input type="text"
                           name="nama"
                           value="{{ $pegawai->nama }}"
                           required
                           class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

            </div>

            {{-- RIGHT --}}
            <div class="space-y-6">

                {{-- Unit Kerja --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Unit Kerja
                    </label>
                    <input type="text"
                           name="unit_kerja"
                           value="{{ $pegawai->unit_kerja }}"
                           required
                           class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                {{-- Nomor WhatsApp --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nomor WhatsApp
                    </label>
                    <input type="text"
                           value="{{ $pegawai->no_whatsapp }}"
                           readonly
                           class="w-full bg-slate-100 border border-slate-200 rounded-md px-4 py-2 text-sm text-slate-500 cursor-not-allowed">
                    <p class="text-xs text-slate-400 mt-1">
                        Hubungi admin jika ingin mengubah nomor WhatsApp.
                    </p>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Status Pegawai
                    </label>
                    <select name="status"
                            required
                            class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm
                                   focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        <option value="aktif" {{ $pegawai->status == 'aktif' ? 'selected' : '' }}>
                            Aktif
                        </option>
                        <option value="nonaktif" {{ $pegawai->status == 'nonaktif' ? 'selected' : '' }}>
                            Nonaktif
                        </option>
                    </select>
                </div>

            </div>

        </div>

        {{-- ACTION --}}
        <div class="flex justify-between items-center pt-8 border-t border-slate-200">

            <a href="{{ route('pegawai.index') }}"
               class="text-sm text-slate-500 hover:text-blue-600 transition">
                ← Kembali ke Daftar Pegawai
            </a>

            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white text-sm rounded-md
                           hover:bg-blue-700 transition">
                Update Data
            </button>

        </div>

    </form>

</div>

@endsection
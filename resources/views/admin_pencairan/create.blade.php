@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-800">
            Input Pencairan Dana
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Input data pencairan dana individu pegawai.
        </p>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="mb-6 border border-green-200 bg-green-50 rounded-lg p-4">
            <p class="text-sm font-medium text-green-700">
                {{ session('success') }}
            </p>
        </div>
    @endif

    <!-- Card -->
    <div class="bg-white border border-slate-200 rounded-lg p-6">

        <form method="POST" action="{{ route('pencairan.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Pegawai -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Pegawai
                    </label>
                    <select name="pegawai_id"
                            required
                            class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                   focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                        <option value="">-- Pilih Pegawai --</option>
                        @foreach($pegawai as $p)
                            <option value="{{ $p->id_pegawai }}">
                                {{ $p->nama }} ({{ $p->nip }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Nama Bank -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Nama Bank
                    </label>
                    <input type="text"
                           name="nama_bank"
                           value="{{ old('nama_bank') }}"
                           required
                           class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                </div>

                <!-- Nama Rekening -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Nama Rekening
                    </label>
                    <input type="text"
                           name="nama_rekening"
                           value="{{ old('nama_rekening') }}"
                           required
                           class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                </div>

                <!-- Nomor Rekening -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Nomor Rekening
                    </label>
                    <input type="text"
                           name="no_rekening"
                           pattern="[0-9]*"
                           inputmode="numeric"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           value="{{ old('no_rekening') }}"
                           required
                           class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                </div>

                <!-- Jenis Dana -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Jenis Dana
                    </label>
                    <input type="text"
                           name="jenis_dana"
                           required
                           class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                </div>

                <!-- Nominal -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Nominal (Total)
                    </label>
                    <input type="number"
                           name="nominal"
                           required
                           class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                </div>

                <!-- Potongan -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Potongan
                    </label>
                    <input type="number"
                           name="potongan"
                           value="0"
                           min="0"
                           class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                    <p class="text-xs text-slate-500 mt-1">
                        Isi 0 jika tidak ada potongan.
                    </p>
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Tanggal
                    </label>
                    <input type="date"
                           name="tanggal"
                           required
                           class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                </div>

                <!-- Keterangan -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Keterangan
                    </label>
                    <textarea name="keterangan"
                              rows="3"
                              class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                     focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none"></textarea>
                </div>

            </div>

            <!-- Divider -->
            <div class="border-t border-slate-200 pt-6 flex justify-end">

                <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm font-medium
                               rounded-lg hover:bg-blue-700 transition">
                    Simpan Pencairan
                </button>

            </div>

        </form>

    </div>

</div>
@endsection
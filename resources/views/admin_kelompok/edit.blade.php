@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-slate-800">
            Edit Kelompok Mitra
        </h1>
        <p class="text-slate-500 mt-1">
            Perbarui informasi kelompok mitra yang telah terdaftar dalam sistem.
        </p>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="mb-6 border border-green-200 bg-green-50 rounded-lg p-4">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="1.5"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-medium text-green-700">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    @endif

    <!-- Error Alert -->
    @if($errors->any())
        <div class="mb-6 border border-red-200 bg-red-50 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" stroke-width="1.5"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 9v3.75m0 3.75h.007M4.5 19.5h15L12 4.5 4.5 19.5z" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-red-700 mb-1">
                        Terjadi kesalahan pada input:
                    </p>
                    <ul class="text-sm text-red-600 list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Card -->
    <div class="bg-white border border-slate-200 rounded-lg p-6">

        <form method="POST" action="{{ route('kelompok.update', $kelompok->id_kelompok) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Nama Kelompok -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Nama Kelompok
                    </label>
                    <input type="text"
                           name="nama_kelompok"
                           value="{{ old('nama_kelompok', $kelompok->nama_kelompok) }}"
                           required
                           class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-600 focus:border-blue-600
                                  outline-none transition">
                </div>

                <!-- Nama Kegiatan -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Nama Kegiatan
                    </label>
                    <input type="text"
                           name="nama_kegiatan"
                           value="{{ old('nama_kegiatan', $kelompok->nama_kegiatan) }}"
                           required
                           class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-600 focus:border-blue-600
                                  outline-none transition">
                </div>

                <!-- Tahun -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Tahun
                    </label>
                    <input type="number"
                           name="tahun"
                           value="{{ old('tahun', $kelompok->tahun) }}"
                           required
                           class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-600 focus:border-blue-600
                                  outline-none transition">
                </div>

                <!-- Keterangan -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Keterangan
                    </label>
                    <textarea name="keterangan"
                              rows="4"
                              class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                     focus:ring-2 focus:ring-blue-600 focus:border-blue-600
                                     outline-none transition">{{ old('keterangan', $kelompok->keterangan) }}</textarea>
                </div>

            </div>

            <!-- Divider -->
            <div class="border-t border-slate-200 pt-6 flex items-center justify-between">

                <!-- Cancel -->
                <a href="{{ route('kelompok.show', $kelompok->id_kelompok) }}"
                   class="text-sm text-slate-500 hover:text-blue-600 transition">
                    ← Batal & Kembali
                </a>

                <!-- Update Button -->
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2.5
                               bg-blue-600 text-white text-sm font-medium
                               rounded-lg hover:bg-blue-700
                               transition">
                    <!-- Heroicon Save -->
                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.5"
                         stroke="currentColor"
                         class="w-4 h-4">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M16.5 3.75H8.25A2.25 2.25 0 006 6v12a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 18V8.25L16.5 3.75z" />
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 9v6m3-3H9" />
                    </svg>
                    Update Kelompok
                </button>

            </div>

        </form>

    </div>
</div>
@endsection
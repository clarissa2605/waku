@extends('layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

<!-- Header -->
<div class="mb-6">
    <h1 class="text-2xl font-semibold text-slate-800">
        Import Data Mitra (CSV)
    </h1>
    <p class="text-sm text-slate-500 mt-1">
        Import data mitra secara massal menggunakan file CSV.
    </p>
</div>


@if(session('success'))

<div class="mb-6 border border-green-200 bg-green-50 rounded-lg p-4 flex justify-between items-center">

<div class="flex items-center gap-2 text-sm text-green-700">
    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-5 h-5"
         fill="none"
         viewBox="0 0 24 24"
         stroke="currentColor">
        <path stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 13l4 4L19 7" />
    </svg>

    {{ session('success') }}
</div>

<a href="{{ route('mitra.index') }}"
   class="text-sm font-medium text-blue-600 hover:underline">
    Lihat Data Mitra
</a>


</div>
@endif


<!-- Card Upload -->
<div class="bg-white border border-slate-200 rounded-lg p-6 mb-8">

    <form method="POST"
      action="{{ route('mitra.import.preview') }}"
      enctype="multipart/form-data">

        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">

            <!-- LEFT SIDE -->
            <div class="md:col-span-2 space-y-6">

                <!-- File -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Pilih File CSV *
                    </label>

                    <input type="file"
                           name="file_csv"
                           accept=".csv"
                           required
                           class="block w-full text-sm text-slate-700
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-lg file:border-0
                                  file:text-sm file:font-medium
                                  file:bg-blue-600 file:text-white
                                  hover:file:bg-blue-700">

                    <!-- Template -->
                    <div class="mt-3">
                        <a href="{{ route('mitra.template') }}"
                           class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-800 transition">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.5"
                                 stroke="currentColor"
                                 class="w-4 h-4">
                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M7.5 10.5L12 15m0 0l4.5-4.5M12 15V3" />
                            </svg>

                            Download Template CSV Mitra

                        </a>
                    </div>
                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="flex justify-start md:justify-end">
                <button type="submit"
                        class="w-full md:w-auto px-8 py-3
                               bg-blue-600 text-white text-sm font-semibold
                               rounded-lg hover:bg-blue-700 transition">
                    Import CSV & Preview
                </button>
            </div>

        </div>

    </form>

</div>

<!-- Format Guide -->
<div class="bg-white border border-slate-200 rounded-lg p-6 space-y-6">

    <h3 class="text-lg font-semibold text-slate-800">
        Petunjuk Format CSV
    </h3>

    <div>
        <p class="text-sm font-medium text-slate-700 mb-2">
            Format CSV:
        </p>

        <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 text-sm font-mono text-slate-700">

nik,nama_mitra,no_whatsapp,alamat,jenis_mitra,tanggal_mulai_kontrak,tanggal_selesai_kontrak,keterangan,status </div> </div>

    <!-- Contoh -->
    <div>
        <p class="text-sm font-medium text-slate-700 mb-2">
            Contoh Isi CSV:
        </p>

<pre class="bg-slate-50 border border-slate-200 rounded-lg p-4 text-xs text-slate-700 overflow-x-auto">
7171010101010001,Andi Saputra,081234567890,Manado,Surveyor,2025-01-01,2025-12-31,Petugas Lapangan,aktif
7171010101010002,Budi Santoso,081234567891,Tomohon,Pengolah Data,2025-01-01,2025-12-31,Petugas Statistik,aktif
</pre>

    </div>

    <!-- Catatan -->
    <div>
        <h4 class="text-sm font-semibold text-slate-800 mb-2">
            Catatan Penting:
        </h4>

        <ul class="text-sm text-slate-600 list-disc list-inside space-y-1">
            <li>File harus berformat <strong>.csv</strong></li>
            <li>Gunakan tanda pemisah <strong>koma ( , )</strong></li>
            <li>NIK harus berisi <strong>16 digit angka</strong></li>
            <li>Nomor WhatsApp akan otomatis dikonversi menjadi format <strong>628xxxxxxxx</strong></li>
            <li>Format tanggal harus <strong>YYYY-MM-DD</strong></li>
            <li>Status hanya boleh <strong>aktif</strong> atau <strong>nonaktif</strong></li>
        </ul>
    </div>

</div>


</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-800">
            Import Pencairan Dana (CSV)
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Import data pencairan dana secara massal menggunakan file CSV.
        </p>
    </div>

    <!-- Card -->
    <div class="bg-white border border-slate-200 rounded-lg p-6 mb-8">

        <form method="POST"
              action="{{ route('pencairan.import.preview') }}"
              enctype="multipart/form-data">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">

                <!-- LEFT SIDE -->
                <div class="md:col-span-2 space-y-6">

                    <!-- Mode -->
                    <div>
                        <label class="block text-sm font-medium text-slate-800 mb-2">
                            Jenis Pencairan *
                        </label>
                        <select name="mode"
                                id="modeSelect"
                                required
                                class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                       focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                            <option value="pegawai">Pegawai</option>
                            <option value="mitra">Mitra</option>
                        </select>
                    </div>

                    <!-- File -->
                    <div>
                        <label class="block text-sm font-medium text-slate-800 mb-2">
                            Pilih File CSV *
                        </label>

                        <input type="file"
                               name="file"
                               accept=".csv"
                               required
                               class="block w-full text-sm text-slate-700
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:text-sm file:font-medium
                                      file:bg-blue-600 file:text-white
                                      hover:file:bg-blue-700">

                        <!-- Dynamic Template -->
                        <div class="mt-3">
                            <a id="templateLink"
   href="{{ route('pencairan.template', ['mode' => 'pegawai']) }}"
   class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-800 transition">

    <!-- Heroicon: Arrow Down Tray -->
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

    Download Template CSV (Pegawai)
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
                        Import & Preview
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

        <!-- Pegawai Format -->
        <div id="formatPegawai">
            <p class="text-sm font-medium text-slate-700 mb-2">
                Format Pegawai:
            </p>
            <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 text-sm font-mono text-slate-700">
                nip;tanggal;jenis_dana;nominal;potongan;nama_bank;nama_rekening;no_rekening;keterangan
            </div>
        </div>

        <!-- Mitra Format -->
        <div id="formatMitra" class="hidden">
            <p class="text-sm font-medium text-slate-700 mb-2">
                Format Mitra:
            </p>
            <div class="bg-slate-50 border border-slate-200 rounded-lg p-3 text-sm font-mono text-slate-700">
                nik;tanggal;jenis_dana;nominal;potongan;kelompok_id;nama_bank;nama_rekening;no_rekening;keterangan
            </div>
        </div>

                <!-- Contoh -->
        <div>
            <p class="text-sm font-medium text-slate-700 mb-2">
                Contoh Isi CSV:
            </p>
            <pre class="bg-slate-50 border border-slate-200 rounded-lg p-4 text-xs text-slate-700 overflow-x-auto">
123456789012345678;2024-07-01;Tunjangan Kinerja;5000000;0;BRI;JOHN DOE;1234567890;Tunjangan bulan Juli
123456789012345679;2024-07-02;Bonus Tahunan;10000000;1000000;MANDIRI;JANE SMITH;0987654321;Bonus kinerja tahunan
            </pre>
        </div>

        <!-- Catatan -->
        <div>
            <h4 class="text-sm font-semibold text-slate-800 mb-2">
                Catatan Penting:
            </h4>
            <ul class="text-sm text-slate-600 list-disc list-inside space-y-1">
                <li>File harus berformat <strong>.csv</strong></li>
                <li>Gunakan tanda pemisah <strong>titik koma ( ; )</strong></li>
                <li>Nomor rekening hanya boleh berisi angka</li>
                <li>Kolom <strong>potongan</strong> dapat diisi 0 jika tidak ada potongan</li>
                <li>Data pegawai/mitra harus sudah terdaftar dan aktif</li>
                <li>Data tidak valid akan ditandai pada halaman preview</li>
            </ul>
        </div>

    </div>

</div>

<script>
const modeSelect = document.getElementById('modeSelect');
const templateLink = document.getElementById('templateLink');
const formatPegawai = document.getElementById('formatPegawai');
const formatMitra = document.getElementById('formatMitra');

modeSelect.addEventListener('change', function() {

    if (this.value === 'mitra') {

        templateLink.href = "{{ route('pencairan.template', ['mode' => 'mitra']) }}";
        templateLink.innerText = "📥 Download Template CSV (Mitra)";

        formatPegawai.classList.add('hidden');
        formatMitra.classList.remove('hidden');

    } else {

        templateLink.href = "{{ route('pencairan.template', ['mode' => 'pegawai']) }}";
        templateLink.innerText = "📥 Download Template CSV (Pegawai)";

        formatPegawai.classList.remove('hidden');
        formatMitra.classList.add('hidden');
    }

});
</script>

@endsection
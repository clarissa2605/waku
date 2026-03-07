@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-800">
            Input Pencairan Dana Mitra
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Input pencairan dana individu mitra berdasarkan kelompok.
        </p>
    </div>

    <!-- Error Alert -->
    @if($errors->any())
        <div class="mb-6 border border-red-200 bg-red-50 rounded-lg p-4">
            <p class="text-sm font-medium text-red-700 mb-2">
                Terjadi kesalahan:
            </p>
            <ul class="text-sm text-red-600 list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Success Alert -->
@if(session('success'))
<div class="mb-6 border border-green-200 bg-green-50 rounded-lg p-4 flex items-center justify-between">

    <div class="flex items-center gap-2 text-green-700 text-sm">
        <!-- Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 13l4 4L19 7" />
        </svg>

        <span>
            {{ session('success') }}
        </span>
    </div>

    <a href="{{ route('pencairan.index', ['mode'=>'mitra']) }}"
       class="text-blue-600 text-sm font-medium hover:underline">
        Lihat Riwayat
    </a>

</div>
@endif

    <!-- Card -->
    <div class="bg-white border border-slate-200 rounded-lg p-6">

        <form method="POST" action="{{ route('pencairan.mitra.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Mitra -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Mitra *
                    </label>
                    <select name="mitra_id"
                            id="mitraSelect"
                            required
                            class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                   focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                        <option value="">-- Pilih Mitra --</option>
                        @foreach($mitra as $m)
                            <option value="{{ $m->id_mitra }}">
                                {{ $m->nama_mitra }} ({{ $m->nik }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Kelompok -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Kelompok *
                    </label>
                    <select name="kelompok_id"
                            id="kelompokSelect"
                            required
                            class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                   focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                        <option value="">-- Pilih Mitra Dulu --</option>
                    </select>
                </div>

                <!-- Jenis Dana -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Jenis Dana *
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
                        Nominal (Total) *
                    </label>
                    <input type="number"
                           name="nominal"
                           id="nominal"
                           min="1"
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
                           id="potongan"
                           value="0"
                           min="0"
                           class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                    <p class="text-xs text-slate-500 mt-1">
                        Isi 0 jika tidak ada potongan.
                    </p>
                </div>

                <!-- Nominal Bersih (Auto) -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Nominal Bersih
                    </label>
                    <input type="number"
                           id="nominalBersih"
                           readonly
                           class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 text-sm text-slate-700">
                </div>

                <!-- Nama Bank -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Nama Bank *
                    </label>
                    <input type="text"
                           name="nama_bank"
                           required
                           class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                </div>

                <!-- Nama Rekening -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Nama Rekening *
                    </label>
                    <input type="text"
                           name="nama_rekening"
                           required
                           class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                </div>

                <!-- Nomor Rekening -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Nomor Rekening *
                    </label>
                    <input type="text"
                           name="no_rekening"
                           pattern="[0-9]*"
                           inputmode="numeric"
                           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                           required
                           class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Tanggal *
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

<script>
document.getElementById('mitraSelect').addEventListener('change', function() {

    let mitraId = this.value;
    let kelompokSelect = document.getElementById('kelompokSelect');

    if (!mitraId) {
        kelompokSelect.innerHTML = '<option value="">-- Pilih Mitra Dulu --</option>';
        return;
    }

    kelompokSelect.innerHTML = '<option value="">Loading...</option>';

    fetch('/admin/mitra/' + mitraId + '/kelompok')
    .then(response => response.json())
    .then(data => {

        kelompokSelect.innerHTML = '<option value="">-- Pilih Kelompok --</option>';

        if (data.length === 0) {
            kelompokSelect.innerHTML = '<option value="">Tidak ada kelompok</option>';
        }

        data.forEach(function(k) {
            kelompokSelect.innerHTML += `
                <option value="${k.id_kelompok}">
                    ${k.nama_kelompok} - ${k.nama_kegiatan ?? ''}
                </option>
            `;
        });
    })
    .catch(() => {
        kelompokSelect.innerHTML = '<option value="">Error mengambil data</option>';
    });
});

document.getElementById('nominal').addEventListener('input', hitungBersih);
document.getElementById('potongan').addEventListener('input', hitungBersih);

function hitungBersih() {
    let nominal = parseFloat(document.getElementById('nominal').value) || 0;
    let potongan = parseFloat(document.getElementById('potongan').value) || 0;

    document.getElementById('nominalBersih').value = nominal - potongan;
}
</script>

@endsection
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-800">
            Detail Kelompok Mitra
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Informasi lengkap dan statistik kelompok mitra.
        </p>
    </div>

    <!-- Informasi Kelompok -->
    <div class="bg-white border border-slate-200 rounded-lg p-6 mb-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">
            {{ $kelompok->nama_kelompok }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <span class="text-slate-500">Kegiatan</span>
                <p class="font-medium text-slate-800">{{ $kelompok->nama_kegiatan }}</p>
            </div>

            <div>
                <span class="text-slate-500">Tahun</span>
                <p class="font-medium text-slate-800">{{ $kelompok->tahun }}</p>
            </div>

            @if($kelompok->keterangan)
            <div class="md:col-span-2">
                <span class="text-slate-500">Keterangan</span>
                <p class="text-slate-700">{{ $kelompok->keterangan }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Statistik -->
    <div class="mb-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">
            Statistik Kelompok
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-white border border-slate-200 rounded-lg p-5">
                <p class="text-sm text-slate-500">Total Anggota</p>
                <p class="text-xl font-semibold text-slate-800 mt-2">
                    {{ $totalAnggota }}
                </p>
            </div>

            <div class="bg-white border border-slate-200 rounded-lg p-5">
                <p class="text-sm text-slate-500">Total Transaksi</p>
                <p class="text-xl font-semibold text-slate-800 mt-2">
                    {{ $totalTransaksi }}
                </p>
            </div>

            <div class="bg-white border border-slate-200 rounded-lg p-5">
                <p class="text-sm text-slate-500">Total Nominal</p>
                <p class="text-xl font-semibold text-slate-800 mt-2">
                    Rp {{ number_format($totalNominal,0,',','.') }}
                </p>
            </div>

            <div class="bg-white border border-slate-200 rounded-lg p-5">
                <p class="text-sm text-slate-500">Total Dana Bersih</p>
                <p class="text-xl font-semibold text-slate-800 mt-2">
                    Rp {{ number_format($totalDanaBersih,0,',','.') }}
                </p>
            </div>

        </div>
    </div>

    <!-- Daftar Anggota -->
    <div class="bg-white border border-slate-200 rounded-lg overflow-hidden mb-6">

        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-800">
                Daftar Anggota Kelompok
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">

                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-slate-500 text-left">
                        <th class="px-6 py-4 font-medium">No</th>
                        <th class="px-6 py-4 font-medium">Nama Mitra</th>
                        <th class="px-6 py-4 font-medium">NIK</th>
                        <th class="px-6 py-4 font-medium">No WhatsApp</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 font-medium text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">

                @forelse($kelompok->mitra as $i => $m)
                    <tr class="hover:bg-slate-50">

                        <td class="px-6 py-4 text-slate-500">
                            {{ $i + 1 }}
                        </td>

                        <td class="px-6 py-4 font-medium text-slate-800">
                            {{ $m->nama_mitra }}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $m->nik }}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $m->no_whatsapp }}
                        </td>

                        <td class="px-6 py-4">
                            @if($m->status == 'aktif')
                                <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-600">
                                    Aktif
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-600">
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                <form method="POST"
                                      action="{{ route('kelompok.removeMitra', [$kelompok->id_kelompok, $m->id_mitra]) }}"
                                      onsubmit="return confirm('Yakin ingin menghapus mitra ini dari kelompok?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="px-3 py-1 text-xs rounded-full
                                            bg-red-100 text-red-600
                                            hover:bg-red-200 transition">
                                    Hapus
                                </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6"
                            class="px-6 py-12 text-center text-slate-500">
                            Belum ada anggota dalam kelompok ini.
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>

    </div>

    <!-- Tambah Anggota -->
    <div class="bg-white border border-slate-200 rounded-lg p-6">

        <div class="flex justify-between items-center mb-4">

    <!-- Kembali -->
    <a href="{{ route('kelompok.index') }}"
       class="text-sm text-slate-500 hover:text-blue-600 transition">
        ← Kembali ke List Kelompok
    </a>

    <!-- Tambah -->
    <button onclick="toggleForm()"
            class="inline-flex items-center gap-2 px-4 py-2.5
                   bg-blue-600 text-white text-sm font-medium
                   rounded-lg hover:bg-blue-700 transition">
        Tambah Anggota
    </button>
</div>

        <div id="formTambah" class="hidden mt-6 max-w-md">

            <input type="text"
                   id="searchMitra"
                   placeholder="Cari nama atau NIK..."
                   class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
                          focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">

            <div id="searchResult"
                 class="border border-slate-200 rounded-lg mt-2 max-h-48 overflow-y-auto">
            </div>

            <form method="POST"
                  action="{{ route('kelompok.addMitra', $kelompok->id_kelompok) }}">
                @csrf

                <input type="hidden" name="mitra_id" id="selectedMitra">

                <button type="submit"
                        class="mt-4 px-4 py-2 bg-green-500 text-white text-sm font-medium rounded-lg hover:bg-green-600 transition">
                    Simpan
                </button>
            </form>
        </div>

    </div>

</div>

<script>
function toggleForm() {
    const form = document.getElementById('formTambah');
    form.classList.toggle('hidden');
}

const mitraData = @json($mitra);
const searchInput = document.getElementById('searchMitra');
const resultBox = document.getElementById('searchResult');
const hiddenInput = document.getElementById('selectedMitra');

searchInput.addEventListener('input', function() {

    const keyword = this.value.toLowerCase();
    resultBox.innerHTML = '';

    if (keyword.length < 2) return;

    const filtered = mitraData.filter(m =>
        m.nama_mitra.toLowerCase().includes(keyword) ||
        m.nik.includes(keyword)
    );

    filtered.forEach(m => {

        const div = document.createElement('div');
        div.className = 'px-4 py-2 cursor-pointer hover:bg-slate-50 border-b border-slate-200 text-sm';

        div.innerHTML = `
            <div class="font-medium text-slate-800">${m.nama_mitra}</div>
            <div class="text-slate-500 text-xs">${m.nik}</div>
        `;

        div.onclick = function() {
            hiddenInput.value = m.id_mitra;
            searchInput.value = m.nama_mitra + ' (' + m.nik + ')';
            resultBox.innerHTML = '';
        };

        resultBox.appendChild(div);

    });

});
</script>

@endsection
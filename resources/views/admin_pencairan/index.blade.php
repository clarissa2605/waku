@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-800">
            Riwayat Pencairan Dana
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Monitoring transaksi dan pengiriman notifikasi WhatsApp.
        </p>
    </div>

    <!-- Filter Card -->
    <div class="bg-white border border-slate-200 rounded-lg p-6 mb-6">
       <form method="GET" class="grid md:grid-cols-5 gap-4">

            <!-- Mode -->
            <div>
                <label class="text-sm text-slate-500">Mode</label>
                <select id="modeSelect" name="mode"
                        class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua</option>
                    <option value="pegawai" {{ request('mode') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                    <option value="mitra" {{ request('mode') == 'mitra' ? 'selected' : '' }}>Mitra</option>
                </select>
            </div>

            <!-- Kelompok -->
            <div>
                <label class="text-sm text-slate-500">Kelompok</label>
                <select id="kelompokSelect" name="kelompok"
                        class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua</option>
                    @foreach($kelompokList as $k)
                        <option value="{{ $k->id_kelompok }}"
                            {{ request('kelompok') == $k->id_kelompok ? 'selected' : '' }}>
                            {{ $k->nama_kelompok }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div>
                <label class="text-sm text-slate-500">Status Notifikasi</label>
                <select name="status"
                        class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua</option>
                    <option value="belum" {{ request('status')=='belum'?'selected':'' }}>Belum</option>
                    <option value="antrian" {{ request('status')=='antrian'?'selected':'' }}>Dalam Antrian</option>
                    <option value="terkirim" {{ request('status')=='terkirim'?'selected':'' }}>Terkirim</option>
                    <option value="gagal" {{ request('status')=='gagal'?'selected':'' }}>Gagal</option>
                </select>
            </div>

            <!-- Search -->
            <div>
                <label class="text-sm text-slate-500">Cari</label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Nama / NIP / NIK"
                       class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm">
            </div>

            <!-- Button -->
            <div class="flex items-end">
                <button type="submit"
                        class="w-full bg-blue-600 text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    Terapkan Filter
                </button>
            </div>

        </form>
    </div>

    <!-- Multi Action -->
    <form method="POST" action="{{ route('pencairan.bulk_send') }}">
        @csrf
        <input type="hidden" name="mode" value="{{ request('mode') ?? 'pegawai' }}">

        <div class="mb-4 flex justify-between items-center">

            <div class="flex items-center gap-3">
                <input type="checkbox" id="selectAll"
                       class="w-4 h-4 text-blue-600 border-slate-300 rounded">
                <label for="selectAll" class="text-sm text-slate-600">
                    Pilih Semua
                </label>
            </div>

            <button type="submit"
                    class="flex items-center gap-2 bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition">

                <!-- Heroicon Paper Airplane -->
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-4 h-4"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 10l18-7-7 18-2-7-9-4z"/>
                </svg>

                Kirim WA Terpilih
            </button>

        </div>

        <!-- Table -->
        <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-slate-500 text-left">
                            <th class="px-6 py-4"></th>
                            <th class="px-6 py-4 font-medium">Nama</th>
                            <th class="px-6 py-4 font-medium">Tanggal</th>
                            <th class="px-6 py-4 font-medium">Jenis Dana</th>
                            <th class="px-6 py-4 font-medium">Nominal Bersih</th>
                            <th class="px-6 py-4 font-medium text-center">Status</th>
                            <th class="px-6 py-4 font-medium text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200">

                        @foreach($pencairan as $p)

                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4">
                                @if(in_array($p->status_notifikasi, ['belum','gagal']))
                                    <input type="checkbox"
                                           name="selected[]"
                                           value="{{ request('mode') === 'mitra' 
                                                ? $p->id_pencairan_mitra 
                                                : $p->id_pencairan }}"
                                           class="rowCheckbox w-4 h-4 text-blue-600 border-slate-300 rounded">
                                @endif
                            </td>

                            <td class="px-6 py-4 font-medium text-slate-800">
                                @if(request('mode') === 'mitra')
                                    {{ $p->mitra->nama_mitra ?? '-' }}
                                @else
                                    {{ $p->pegawai->nama ?? '-' }}
                                @endif
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $p->tanggal }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $p->jenis_dana }}
                            </td>

                            <td class="px-6 py-4 font-semibold text-slate-800">
                                Rp {{ number_format($p->nominal_bersih,0,',','.') }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                @switch($p->status_notifikasi)

                                    @case('belum')
                                        <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-600">
                                            Belum
                                        </span>
                                    @break

                                    @case('antrian')
                                        <span class="px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-600">
                                            Dalam Antrian
                                        </span>
                                    @break

                                    @case('terkirim')
                                        <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-600">
                                            Terkirim
                                        </span>
                                    @break

                                    @case('gagal')
                                        <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-600">
                                            Gagal
                                        </span>
                                    @break

                                @endswitch
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if(in_array($p->status_notifikasi, ['belum','gagal']))

                                    @php
                                        $idRoute = request('mode') === 'mitra'
                                            ? ($p->id_pencairan_mitra ?? null)
                                            : ($p->id_pencairan ?? null);
                                    @endphp

                                    @if($idRoute)
                                        <a href="{{ route('pencairan.kirim_wa', $idRoute) }}"
                                        class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-sm font-medium">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="w-4 h-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 10l18-7-7 18-2-7-9-4z"/>
                                            </svg>

                                            Kirim
                                        </a>
                                    @endif

                                @else
                                    <span class="text-slate-400 text-sm">
                                        Diproses
                                    </span>
                                @endif
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>
        </div>

    </form>

</div>

<script>
document.getElementById('selectAll').addEventListener('change', function() {
    document.querySelectorAll('.rowCheckbox').forEach(cb => {
        cb.checked = this.checked;
    });
});

document.addEventListener('DOMContentLoaded', function () {

    const modeSelect = document.getElementById('modeSelect');
    const kelompokSelect = document.getElementById('kelompokSelect');

    function toggleKelompok() {
        if (modeSelect.value === 'mitra') {
            kelompokSelect.disabled = false;
            kelompokSelect.classList.remove('bg-slate-100','cursor-not-allowed');
        } else {
            kelompokSelect.disabled = true;
            kelompokSelect.value = '';
            kelompokSelect.classList.add('bg-slate-100','cursor-not-allowed');
        }
    }

    toggleKelompok();
    modeSelect.addEventListener('change', toggleKelompok);

});
</script>

@endsection
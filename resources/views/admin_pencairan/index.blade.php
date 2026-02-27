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
        <form method="GET" class="grid md:grid-cols-4 gap-4">

            <!-- Mode -->
            <div>
                <label class="text-sm text-slate-500">Mode</label>
                <select name="mode"
                        class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua</option>
                    <option value="pegawai">Pegawai</option>
                    <option value="mitra">Mitra</option>
                </select>
            </div>

            <!-- Status -->
            <div>
                <label class="text-sm text-slate-500">Status Notifikasi</label>
                <select name="status"
                        class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua</option>
                    <option value="belum">Belum</option>
                    <option value="antrian">Dalam Antrian</option>
                    <option value="terkirim">Terkirim</option>
                    <option value="gagal">Gagal</option>
                </select>
            </div>

            <!-- Search -->
            <div>
                <label class="text-sm text-slate-500">Cari</label>
                <input type="text"
                       name="search"
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

        <div class="mb-4 flex justify-between items-center">

            <div class="flex items-center gap-3">
                <input type="checkbox" id="selectAll"
                       class="w-4 h-4 text-blue-600 border-slate-300 rounded">
                <label for="selectAll" class="text-sm text-slate-600">
                    Pilih Semua
                </label>
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-blue-700 transition">
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

                            <!-- Checkbox -->
                            <td class="px-6 py-4">
                                @if(in_array($p->status_notifikasi, ['belum','gagal']))
                                    <input type="checkbox"
                                           name="selected[]"
                                           value="{{ $p->id_pencairan }}"
                                           class="rowCheckbox w-4 h-4 text-blue-600 border-slate-300 rounded">
                                @endif
                            </td>

                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $p->pegawai->nama ?? '-' }}
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

                            <!-- Status -->
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

                            <!-- Aksi -->
                            <td class="px-6 py-4 text-center">
                                @if(in_array($p->status_notifikasi, ['belum','gagal']))
                                    <a href="{{ route('pencairan.kirim_wa', $p->id_pencairan) }}"
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Kirim WA
                                    </a>
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

<!-- Select All Script -->
<script>
document.getElementById('selectAll').addEventListener('change', function() {
    document.querySelectorAll('.rowCheckbox').forEach(cb => {
        cb.checked = this.checked;
    });
});
</script>

@endsection
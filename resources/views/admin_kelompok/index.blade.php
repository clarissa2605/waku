@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Page Header (Standardized) -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-slate-800">
                Daftar Kelompok Mitra
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Kelola dan monitor seluruh kelompok mitra dalam sistem.
            </p>
        </div>

        <a href="{{ route('kelompok.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2.5
                  bg-blue-600 text-white text-sm font-medium
                  rounded-lg hover:bg-blue-700 transition">
            <!-- Heroicon Plus -->
            <svg xmlns="http://www.w3.org/2000/svg"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke-width="1.5"
                 stroke="currentColor"
                 class="w-4 h-4">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Buat Kelompok
        </a>
    </div>

    <!-- Card -->
    <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">

                <!-- Table Header -->
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr class="text-slate-500 text-left">
                        <th class="px-6 py-4 font-medium">No</th>
                        <th class="px-6 py-4 font-medium">Nama Kelompok</th>
                        <th class="px-6 py-4 font-medium">Kegiatan</th>
                        <th class="px-6 py-4 font-medium">Tahun</th>
                        <th class="px-6 py-4 font-medium">Jumlah Anggota</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                        <th class="px-6 py-4 font-medium text-center">Aksi</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="divide-y divide-slate-200">

                @forelse($kelompok as $i => $k)
                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-6 py-4 text-slate-500">
                            {{ $i + 1 }}
                        </td>

                        <td class="px-6 py-4 font-medium text-slate-800">
                            {{ $k->nama_kelompok }}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $k->nama_kegiatan }}
                        </td>

                        <td class="px-6 py-4 text-slate-600">
                            {{ $k->tahun }}
                        </td>

                        <!-- Jumlah Anggota -->
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs bg-blue-50 text-blue-600">
                                {{ $k->mitra_count }} orang
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4">
                            @if($k->mitra_count > 0)
                                <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-600">
                                    Aktif
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs bg-yellow-100 text-yellow-600">
                                    Kosong
                                </span>
                            @endif
                        </td>

                        <!-- Aksi (Bold & Professional) -->
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-4">

                                <a href="{{ route('kelompok.show', $k->id_kelompok) }}"
                                   class="font-semibold text-slate-700 hover:text-blue-600 transition">
                                    Detail
                                </a>

                                <a href="{{ route('kelompok.edit', $k->id_kelompok) }}"
                                   class="font-semibold text-blue-600 hover:text-blue-800 transition">
                                    Edit
                                </a>

                                <form action="{{ route('kelompok.destroy', $k->id_kelompok) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus kelompok ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="font-semibold text-red-600 hover:text-red-800 transition">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="7"
                            class="px-6 py-12 text-center text-slate-500">
                            Belum ada kelompok mitra yang terdaftar.
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>

    </div>

</div>
@endsection
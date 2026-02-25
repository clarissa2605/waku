@extends('layouts.app')

@section('title')

@section('content')

{{-- ================= HEADER DI LUAR BOX ================= --}}
<div class="mb-6">
    <h2 class="text-2xl font-semibold text-slate-800">
        Data Mitra
    </h2>
    <p class="text-sm text-slate-500 mt-1">
        Kelola dan monitor seluruh data mitra dalam sistem.
    </p>
</div>

<div class="bg-white border border-slate-200 rounded-lg p-6">

    {{-- ================= FILTER SECTION ================= --}}
    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">

        {{-- Search --}}
        <div class="md:col-span-2">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari Nama atau NIK..."
                   class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm
                          focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        {{-- Status --}}
        <div>
            <select name="status"
                    class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm bg-white
                           focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>
                    Aktif
                </option>
                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>
                    Nonaktif
                </option>
            </select>
        </div>

        {{-- Kelompok --}}
        <div>
            <select name="kelompok"
                    class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm bg-white
                           focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">Semua Kelompok</option>
                @foreach($kelompokList as $kelompok)
                    <option value="{{ $kelompok->id }}"
                        {{ request('kelompok') == $kelompok->id ? 'selected' : '' }}>
                        {{ $kelompok->nama_kelompok }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Button --}}
        <div class="flex items-center justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                Terapkan Filter
            </button>
        </div>

    </form>

    {{-- ================= TABLE ================= --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">

            <thead class="text-slate-500 border-b border-slate-200">
                <tr>
                    <th class="py-3 text-left">Nama Mitra</th>
                    <th class="py-3 text-left">NIK</th>
                    <th class="py-3 text-left">Kelompok</th>
                    <th class="py-3 text-left">WhatsApp</th>
                    <th class="py-3 text-left">Status</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">

                @forelse($mitra as $item)
                <tr class="hover:bg-slate-50 transition">

                    <td class="py-3 font-medium text-slate-800">
                        {{ $item->nama_mitra }}
                    </td>

                    <td class="py-3 text-slate-600">
                        {{ $item->nik }}
                    </td>

                    <td class="py-3 text-slate-600">
                        @if($item->kelompok->count())
                            <div class="flex flex-wrap gap-1">
                                @foreach($item->kelompok as $kel)
                                    <span class="px-2 py-1 text-xs bg-blue-100 text-blue-600 rounded-full">
                                        {{ $kel->nama_kelompok }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            -
                        @endif
                    </td>

                    <td class="py-3 text-slate-600">
                        {{ $item->no_whatsapp ?? '-' }}
                    </td>

                    {{-- STATUS --}}
                    <td class="py-3">
                        <form action="{{ route('mitra.toggle-status', $item->id_mitra) }}"
                            method="POST">
                            @csrf
                            @method('PATCH')

                            @if($item->status === 'aktif')
                                <button type="submit"
                                    class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600
                                        hover:bg-green-200 transition">
                                    Aktif
                                </button>
                            @else
                                <button type="submit"
                                    class="px-3 py-1 text-xs rounded-full bg-slate-200 text-slate-600
                                        hover:bg-slate-300 transition">
                                    Nonaktif
                                </button>
                            @endif

                        </form>
                    </td>

                    {{-- AKSI --}}
                    <td class="py-3 text-center space-x-4">

                        <a href="{{ route('mitra.show', $item->id_mitra) }}"
                           class="text-slate-600 hover:text-blue-600 text-sm font-medium">
                            Detail
                        </a>

                        <a href="{{ route('mitra.edit', $item->id_mitra) }}"
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Edit
                        </a>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="6" class="text-center py-10 text-slate-500">
                        Belum ada data mitra.
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $mitra->links() }}
    </div>

</div>

@endsection
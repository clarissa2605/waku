@extends('layouts.app')

@section('title')

@section('content')


    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-slate-800">
                Data Pegawai
            </h2>
            <p class="text-sm text-slate-500 mt-1">
                Kelola dan monitor seluruh data pegawai dalam sistem.
            </p>
        </div>
    </div>

{{-- ================= CARD ================= --}}
<div class="bg-white border border-slate-200 rounded-lg p-6">
    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-100 text-green-700 rounded-md text-sm border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 px-4 py-3 bg-red-100 text-red-700 rounded-md text-sm border border-red-200">
            {{ session('error') }}
        </div>
    @endif


    {{-- FILTER SECTION --}}
    <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">

        {{-- Search --}}
        <div class="md:col-span-2">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari NIP atau Nama..."
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

        {{-- Akun --}}
        <div>
            <select name="akun"
                    class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm bg-white
                           focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <option value="">Semua Akun</option>
                <option value="ada" {{ request('akun') == 'ada' ? 'selected' : '' }}>
                    Sudah Ada Akun
                </option>
                <option value="belum" {{ request('akun') == 'belum' ? 'selected' : '' }}>
                    Belum Ada Akun
                </option>
            </select>
        </div>

        <div class="md:col-span-4 flex justify-end">
            <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                Terapkan Filter
            </button>
        </div>

    </form>


    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">

            <thead class="text-slate-500 border-b border-slate-200">
                <tr class="text-left">
                    <th class="py-3">NIP</th>
                    <th class="py-3">Nama</th>
                    <th class="py-3">Unit Kerja</th>
                    <th class="py-3">No WhatsApp</th>
                    <th class="py-3">Status</th>
                    <th class="py-3">Akun Login</th>
                    <th class="py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">

                @forelse($pegawai as $p)
                <tr class="transition hover:bg-slate-50 
                    {{ $p->status === 'nonaktif' ? 'bg-slate-50 opacity-70' : '' }}">

                    <td class="py-3 text-slate-600">
                        {{ $p->nip }}
                    </td>

                    <td class="py-3 font-medium text-slate-800">
                        {{ $p->nama }}
                    </td>

                    <td class="py-3 text-slate-600">
                        {{ $p->unit_kerja }}
                    </td>

                    <td class="py-3 text-slate-600">
                        {{ $p->no_whatsapp }}
                    </td>

                    {{-- STATUS --}}
                    <td class="py-3">
                        @if($p->status === 'aktif')
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                                Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-slate-200 text-slate-600">
                                Nonaktif
                            </span>
                        @endif
                    </td>

                    {{-- AKUN LOGIN --}}
                    <td class="py-3">
                        @if($p->user)
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                                Aktif
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600">
                                Belum Ada
                            </span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td class="py-3 text-right space-x-4">

                        <a href="{{ route('pegawai.edit', $p->id_pegawai) }}"
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Edit
                        </a>

                        @if(!$p->user)
                            <a href="{{ route('pegawai.user.create', $p->id_pegawai) }}"
                               class="text-emerald-600 hover:text-emerald-800 text-sm font-medium">
                                Buat Akun
                            </a>
                        @endif

                        {{-- TOGGLE STATUS --}}
                        <form action="{{ route('pegawai.toggle', $p->id_pegawai) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Yakin ingin mengubah status pegawai ini?')">
                            @csrf
                            @method('PATCH')

                            @if($p->status === 'aktif')
                                <button type="submit"
                                        class="text-red-500 hover:text-red-700 text-sm font-medium">
                                    Nonaktifkan
                                </button>
                            @else
                                <button type="submit"
                                        class="text-green-600 hover:text-green-700 text-sm font-medium">
                                    Aktifkan
                                </button>
                            @endif
                        </form>

                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-slate-500">
                        Tidak ada data pegawai ditemukan.
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>
    </div>

</div>

@endsection
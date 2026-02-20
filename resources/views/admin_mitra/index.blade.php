@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-10">

    <div class="max-w-7xl mx-auto">

        <!-- HEADER -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-semibold text-white">Manajemen Mitra</h1>
                <p class="text-slate-400 text-sm mt-1">
                    Kelola data mitra & kontrak kegiatan
                </p>
            </div>

            <a href="{{ route('mitra.create') }}"
               class="px-5 py-2 rounded-xl bg-gradient-to-r from-indigo-500 to-blue-500 
                      text-white shadow-lg hover:scale-105 transition duration-300">
                + Tambah Mitra
            </a>
        </div>

        <!-- GLASS CARD -->
        <div class="backdrop-blur-xl bg-white/10 border border-white/20 
                    rounded-2xl shadow-xl p-6">

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-200">
                    <thead class="text-slate-400 border-b border-white/20">
                        <tr>
                            <th class="py-3">Nama</th>
                            <th>NIK</th>
                            <th>Status</th>
                            <th>WhatsApp</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mitra as $item)
                        <tr class="border-b border-white/10 hover:bg-white/5 transition">
                            <td class="py-3 font-medium">
                                {{ $item->nama_mitra }}
                            </td>
                            <td>{{ $item->nik }}</td>
                            <td>
                                <span class="px-3 py-1 text-xs rounded-full 
                                    {{ $item->status == 'aktif' 
                                        ? 'bg-green-500/20 text-green-400' 
                                        : 'bg-red-500/20 text-red-400' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>{{ $item->no_whatsapp ?? '-' }}</td>
                            <td class="text-right space-x-2">
                                <a href="{{ route('mitra.edit', $item->id_mitra) }}"
                                   class="text-indigo-400 hover:text-indigo-300">
                                   Edit
                                </a>
                                <form action="{{ route('mitra.destroy', $item->id_mitra) }}" 
                                      method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus mitra?')"
                                            class="text-red-400 hover:text-red-300">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $mitra->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
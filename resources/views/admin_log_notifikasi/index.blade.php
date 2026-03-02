@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-800">
            Log Notifikasi WhatsApp
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Monitoring pengiriman notifikasi berdasarkan mode.
        </p>
    </div>

    <!-- Statistik -->
    <div class="grid md:grid-cols-2 gap-4 mb-6">
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <p class="text-sm text-green-600">Total Success</p>
            <p class="text-2xl font-bold text-green-700">{{ $totalSuccess }}</p>
        </div>

        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <p class="text-sm text-red-600">Total Error</p>
            <p class="text-2xl font-bold text-red-700">{{ $totalError }}</p>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white border border-slate-200 rounded-lg p-6 mb-6">
        <form method="GET" class="grid md:grid-cols-4 gap-4">

            <div>
                <label class="text-sm text-slate-500">Mode</label>
                <select name="mode"
                        class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm">
                    <option value="pegawai" {{ $mode=='pegawai'?'selected':'' }}>Pegawai</option>
                    <option value="mitra" {{ $mode=='mitra'?'selected':'' }}>Mitra</option>
                </select>
            </div>

            <div>
                <label class="text-sm text-slate-500">Status</label>
                <select name="status"
                        class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm">
                    <option value="">Semua</option>
                    <option value="success" {{ request('status')=='success'?'selected':'' }}>Success</option>
                    <option value="error" {{ request('status')=='error'?'selected':'' }}>Error</option>
                </select>
            </div>

            <div>
                <label class="text-sm text-slate-500">Cari Nomor</label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="mt-1 w-full border border-slate-200 rounded-lg px-3 py-2 text-sm">
            </div>

            <div class="flex items-end">
                <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                    Terapkan
                </button>
            </div>

        </form>
    </div>

    <!-- Table -->
    <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
        <table class="min-w-full text-sm">

            <thead class="bg-slate-50 border-b border-slate-200">
                <tr class="text-left text-slate-500">
                    <th class="px-6 py-4">Nomor WA</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Response</th>
                    <th class="px-6 py-4">Waktu</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-200">

                @forelse($logs as $log)
                <tr class="hover:bg-slate-50">

                    <td class="px-6 py-4 font-medium">
                        {{ $log->no_whatsapp }}
                    </td>

                    <td class="px-6 py-4">
                        @if($log->status == 'success')
                            <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-600">
                                Success
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-600">
                                Error
                            </span>
                        @endif
                    </td>

                    <td class="px-6 py-4 text-slate-600 text-xs">
                        {{ \Illuminate\Support\Str::limit($log->response, 60) }}
                    </td>

                    <td class="px-6 py-4 text-slate-600">
                        {{ $log->created_at->format('d M Y H:i') }}
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-slate-400">
                        Tidak ada data log.
                    </td>
                </tr>
                @endforelse

            </tbody>

        </table>

        <div class="p-4">
            {{ $logs->withQueryString()->links() }}
        </div>

    </div>

</div>
@endsection
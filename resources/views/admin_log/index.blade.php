@extends('layouts.app')

@section('content')

<div class="p-6 bg-slate-50 min-h-screen">

    {{-- PAGE HEADER --}}
    <div class="mb-6 flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-semibold text-slate-800">
                Log Aktivitas Sistem
            </h1>

            <p class="text-slate-500 text-sm mt-1">
                Riwayat aktivitas pengguna dalam sistem WAKU
            </p>
        </div>

    </div>


    {{-- CARD --}}
    <div class="bg-white border border-slate-200 rounded-lg">

        {{-- FILTER BAR --}}
        <div class="p-6 border-b border-slate-200 flex flex-wrap gap-4 items-center">

            <form method="GET" class="flex gap-3 w-full md:w-auto">

                {{-- SEARCH --}}
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari aktivitas..."
                    class="border border-slate-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600">

                {{-- FILTER MODUL --}}
                <select
                    name="modul"
                    class="border border-slate-200 rounded-lg px-7 py-2 text-sm">

                    <option value="">Semua Modul</option>

                    @foreach($modulList as $modul)
                        <option value="{{ $modul }}"
                        {{ request('modul') == $modul ? 'selected' : '' }}>
                            {{ $modul }}
                        </option>
                    @endforeach

                </select>

                <button
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                    Filter
                </button>

            </form>

        </div>


        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="text-slate-500 border-b border-slate-200 bg-slate-50">

                    <tr class="text-left">

                        <th class="px-6 py-3">Waktu</th>
                        <th class="px-6 py-3">User</th>
                        <th class="px-6 py-3">Modul</th>
                        <th class="px-6 py-3">Aktivitas</th>
                        <th class="px-6 py-3">Detail</th>
                        <th class="px-6 py-3">IP</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($logs as $log)

                    <tr class="border-b border-slate-200 hover:bg-slate-50">

                        {{-- WAKTU --}}
                        <td class="px-6 py-4 text-slate-500 whitespace-nowrap">
                            {{ $log->created_at->format('d M Y H:i') }}
                        </td>

                        {{-- USER --}}
                        <td class="px-6 py-4 text-slate-800 font-medium">
                            {{ $log->nama_user ?? ($log->user->name ?? 'System') }}
                        </td>

                        {{-- MODUL --}}
                        <td class="px-6 py-4">

                            <span class="px-3 py-1 rounded-full text-xs bg-blue-50 text-blue-600">
                                {{ $log->modul }}
                            </span>

                        </td>

                        {{-- AKTIVITAS --}}
                        <td class="px-6 py-4 text-slate-800">
                            {{ $log->aktivitas }}
                        </td>

                        {{-- DETAIL --}}
                        <td class="px-6 py-4 text-slate-500">
                            {{ $log->detail }}
                        </td>

                        {{-- IP --}}
                        <td class="px-6 py-4 text-slate-400 text-xs">
                            {{ $log->ip_address }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center py-10 text-slate-500">
                            Tidak ada aktivitas tercatat
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}
        <div class="p-4 border-t border-slate-200">

            {{ $logs->links() }}

        </div>

    </div>

</div>

@endsection
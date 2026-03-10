@extends('layouts.app')

@section('title','Detail Pencairan Dana')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- SLIP CARD --}}
    <div class="bg-white border border-slate-200 rounded-lg shadow-sm">

        {{-- HEADER --}}
        <div class="border-b border-slate-200 p-6 flex justify-between items-center">

            <div>
                <h2 class="text-xl font-semibold text-slate-800">
                    Slip Pencairan Dana
                </h2>

                <p class="text-sm text-slate-500">
                    Sistem WAKU • BPS Sulawesi Utara
                </p>
            </div>

            <div class="text-right">
                <p class="text-sm text-slate-500">Tanggal</p>
                <p class="font-medium text-slate-800">
                    {{ $data->tanggal }}
                </p>
            </div>

        </div>


        {{-- BODY --}}
        <div class="p-6">

            <div class="grid grid-cols-2 gap-6 text-sm">

                <div>
                    <p class="text-slate-500">Jenis Dana</p>
                    <p class="font-medium text-slate-800">
                        {{ $data->jenis_dana }}
                    </p>
                </div>

                <div>
                    <p class="text-slate-500">Bank</p>
                    <p class="font-medium text-slate-800">
                        {{ $data->nama_bank }}
                    </p>
                </div>

                <div>
                    <p class="text-slate-500">Nama Rekening</p>
                    <p class="font-medium text-slate-800">
                        {{ $data->nama_rekening }}
                    </p>
                </div>

                <div>
                    <p class="text-slate-500">Nomor Rekening</p>
                    <p class="font-medium text-slate-800">
                        {{ $data->no_rekening }}
                    </p>
                </div>

            </div>


            {{-- GARIS PEMISAH --}}
            <div class="my-8 border-t border-slate-200"></div>


            {{-- RINCIAN PEMBAYARAN --}}
            <div class="space-y-4 text-sm">

                <div class="flex justify-between">
                    <span class="text-slate-500">
                        Nominal Dana
                    </span>

                    <span class="font-medium text-slate-800">
                        Rp {{ number_format($data->nominal,0,',','.') }}
                    </span>
                </div>


                <div class="flex justify-between">
                    <span class="text-slate-500">
                        Potongan
                    </span>

                    <span class="font-medium text-red-600">
                        Rp {{ number_format($data->potongan,0,',','.') }}
                    </span>
                </div>


                <div class="border-t border-slate-200 pt-4 flex justify-between">

                    <span class="font-semibold text-slate-700">
                        Total Diterima
                    </span>

                    <span class="text-lg font-bold text-green-600">
                        Rp {{ number_format($data->nominal_bersih,0,',','.') }}
                    </span>

                </div>

            </div>


            {{-- STATUS --}}
            <div class="mt-8">

                <p class="text-sm text-slate-500 mb-2">
                    Status Notifikasi
                </p>

                @if($data->status_notifikasi == 'terkirim')

                    <span class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full">
                        Notifikasi WhatsApp Terkirim
                    </span>

                @elseif($data->status_notifikasi == 'gagal')

                    <span class="px-3 py-1 text-xs bg-red-100 text-red-700 rounded-full">
                        Gagal Terkirim
                    </span>

                @else

                    <span class="px-3 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full">
                        Belum Dikirim
                    </span>

                @endif

            </div>

        </div>


        {{-- FOOTER --}}
        <div class="border-t border-slate-200 p-6 flex justify-between items-center">

            <p class="text-xs text-slate-400">
                Slip ini dihasilkan otomatis oleh sistem WAKU
            </p>

            <a href="{{ route('pegawai.dashboard') }}"
               class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700">

                Kembali ke Dashboard

            </a>

        </div>

    </div>

</div>

@endsection
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-800">
            Preview Import Mitra
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Periksa kembali data mitra sebelum dikonfirmasi dan disimpan ke sistem.
        </p>
    </div>

    <!-- Card -->
    <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">

        <form method="POST" action="{{ route('mitra.import.confirm') }}">
            @csrf

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">

                    <!-- Header -->
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-slate-500 text-left">
                            <th class="px-6 py-4 font-medium">No</th>
                            <th class="px-6 py-4 font-medium">NIK</th>
                            <th class="px-6 py-4 font-medium">Nama Mitra</th>
                            <th class="px-6 py-4 font-medium">WhatsApp</th>
                            <th class="px-6 py-4 font-medium">Alamat</th>
                            <th class="px-6 py-4 font-medium">Jenis Mitra</th>
                            <th class="px-6 py-4 font-medium">Mulai Kontrak</th>
                            <th class="px-6 py-4 font-medium">Selesai Kontrak</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                            <th class="px-6 py-4 font-medium text-center">Validasi</th>
                        </tr>
                    </thead>

                    <!-- Body -->
                    <tbody class="divide-y divide-slate-200">

                        @foreach ($rows as $i => $row)

                        <tr class="{{ $row['valid'] ? 'hover:bg-slate-50' : 'bg-red-50' }}">

                            <td class="px-6 py-4 text-slate-500">
                                {{ $i + 1 }}
                            </td>

                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $row['nik'] }}
                            </td>

                            <td class="px-6 py-4 text-slate-700">
                                {{ $row['nama_mitra'] }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $row['no_whatsapp'] ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $row['alamat'] ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $row['jenis_mitra'] ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $row['tanggal_mulai_kontrak'] ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $row['tanggal_selesai_kontrak'] ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $row['status'] }}
                            </td>

                            <td class="px-6 py-4 text-center">

                                @if($row['valid'])
                                    <span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-600">
                                        Valid
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs bg-red-100 text-red-600">
                                        Tidak Valid
                                    </span>
                                @endif

                            </td>

                        </tr>

                        <!-- Hidden Inputs -->
                        <input type="hidden" name="data[{{ $i }}][nik]" value="{{ $row['nik'] }}">
                        <input type="hidden" name="data[{{ $i }}][nama_mitra]" value="{{ $row['nama_mitra'] }}">
                        <input type="hidden" name="data[{{ $i }}][no_whatsapp]" value="{{ $row['no_whatsapp'] }}">
                        <input type="hidden" name="data[{{ $i }}][alamat]" value="{{ $row['alamat'] }}">
                        <input type="hidden" name="data[{{ $i }}][jenis_mitra]" value="{{ $row['jenis_mitra'] }}">
                        <input type="hidden" name="data[{{ $i }}][tanggal_mulai_kontrak]" value="{{ $row['tanggal_mulai_kontrak'] }}">
                        <input type="hidden" name="data[{{ $i }}][tanggal_selesai_kontrak]" value="{{ $row['tanggal_selesai_kontrak'] }}">
                        <input type="hidden" name="data[{{ $i }}][keterangan]" value="{{ $row['keterangan'] }}">
                        <input type="hidden" name="data[{{ $i }}][status]" value="{{ $row['status'] }}">
                        <input type="hidden" name="data[{{ $i }}][valid]" value="{{ $row['valid'] ? 1 : 0 }}">

                        @endforeach

                    </tbody>

                </table>
            </div>

            <!-- Footer -->
            <div class="border-t border-slate-200 p-6 flex justify-between items-center">

                <a href="{{ route('mitra.import.form') }}"
                   class="text-sm font-medium text-slate-600 hover:text-blue-600 transition">
                    ← Batal
                </a>

                <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm font-semibold
                               rounded-lg hover:bg-blue-700 transition">
                    Konfirmasi & Simpan
                </button>

            </div>

        </form>

    </div>

</div>
@endsection
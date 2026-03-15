@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-800">
            Preview Import Pencairan Dana
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Periksa kembali data sebelum dikonfirmasi dan disimpan ke sistem.
        </p>
    </div>

    <!-- Card -->
    <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">

        <form method="POST" action="{{ route('pencairan.import.confirm') }}">
            @csrf

            <!-- WAJIB KIRIM MODE -->
            <input type="hidden" name="mode" value="{{ $mode }}">

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">

                    <!-- Header Table -->
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr class="text-slate-500 text-left">
                            <th class="px-6 py-4 font-medium">No</th>
                            <th class="px-6 py-4 font-medium">
                                {{ $mode === 'pegawai' ? 'NIP' : 'NIK' }}
                            </th>
                            <th class="px-6 py-4 font-medium">Nama</th>
                            <th class="px-6 py-4 font-medium">Kelompok</th>
                            <th class="px-6 py-4 font-medium">Tanggal</th>
                            <th class="px-6 py-4 font-medium">Jenis Dana</th>
                            <th class="px-6 py-4 font-medium">Bank</th>
                            <th class="px-6 py-4 font-medium">Nama Rekening</th>
                            <th class="px-6 py-4 font-medium">No Rekening</th>
                            <th class="px-6 py-4 font-medium">Nominal</th>
                            <th class="px-6 py-4 font-medium">Potongan</th>
                            <th class="px-6 py-4 font-medium">Diterima</th>
                            <th class="px-6 py-4 font-medium text-center">Status</th>
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
                                {{ $row['identifier'] }}
                            </td>

                            <td class="px-6 py-4 text-slate-700">
                                {{ $row['nama'] }}
                            </td>

                            <td>
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded">
                                    {{ $row['kelompok_nama'] }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $row['tanggal'] }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $row['jenis_dana'] }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $row['nama_bank'] ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $row['nama_rekening'] ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ $row['no_rekening'] ?? '-' }}
                            </td>

                            <td class="px-6 py-4 text-slate-700">
                                Rp {{ number_format($row['nominal'], 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-slate-700">
                                Rp {{ number_format($row['potongan'], 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 font-semibold text-slate-800">
                                Rp {{ number_format($row['bersih'], 0, ',', '.') }}
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

                        <!-- Hidden Inputs (WAJIB) -->
                        <input type="hidden" name="data[{{ $i }}][identifier]" value="{{ $row['identifier'] }}">
                        <input type="hidden" name="data[{{ $i }}][tanggal]" value="{{ $row['tanggal'] }}">
                        <input type="hidden" name="data[{{ $i }}][jenis_dana]" value="{{ $row['jenis_dana'] }}">
                        <input type="hidden" name="data[{{ $i }}][nominal]" value="{{ $row['nominal'] }}">
                        <input type="hidden" name="data[{{ $i }}][potongan]" value="{{ $row['potongan'] }}">
                        <input type="hidden" name="data[{{ $i }}][kelompok_id]" value="{{ $row['kelompok_id'] ?? '' }}">
                        <input type="hidden" name="data[{{ $i }}][nama_bank]" value="{{ $row['nama_bank'] }}">
                        <input type="hidden" name="data[{{ $i }}][nama_rekening]" value="{{ $row['nama_rekening'] }}">
                        <input type="hidden" name="data[{{ $i }}][no_rekening]" value="{{ $row['no_rekening'] }}">
                        <input type="hidden" name="data[{{ $i }}][keterangan]" value="{{ $row['keterangan'] }}">
                        <input type="hidden" name="data[{{ $i }}][valid]" value="{{ $row['valid'] ? 1 : 0 }}">

                        @endforeach

                    </tbody>
                </table>
            </div>

            <!-- Footer Action -->
            <div class="border-t border-slate-200 p-6 flex justify-between items-center">

                <a href="{{ route('pencairan.import.form') }}"
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
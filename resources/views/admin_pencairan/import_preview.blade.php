@extends('layouts.app')

@section('content')

<h1>Preview Import Pencairan Dana</h1>

<form method="POST" action="{{ route('pencairan.import.confirm') }}">
    @csrf

    <table border="1" cellpadding="6" cellspacing="0" width="100%">
        <tr style="background:#f2f2f2;">
            <th>No</th>
            <th>NIP</th>
            <th>Nama Pegawai</th>
            <th>Tanggal</th>
            <th>Jenis Dana</th>
            <th>Bank</th>
            <th>Nama Rekening</th>
            <th>No Rekening</th>
            <th>Nominal</th>
            <th>Potongan</th>
            <th>Diterima</th>
            <th>Status</th>
        </tr>

        @foreach ($rows as $i => $row)
            <tr style="{{ $row['valid'] ? '' : 'background:#ffe6e6' }}">
                <td>{{ $i + 1 }}</td>
                <td>{{ $row['nip'] }}</td>
                <td>{{ $row['nama'] }}</td>
                <td>{{ $row['tanggal'] }}</td>
                <td>{{ $row['jenis_dana'] }}</td>
                <td>{{ $row['nama_bank'] ?? '-' }}</td>
                <td>{{ $row['nama_rekening'] ?? '-' }}</td>
                <td>{{ $row['no_rekening'] ?? '-' }}</td>
                <td>Rp {{ number_format($row['nominal'], 0, ',', '.') }}</td>
                <td>Rp {{ number_format($row['potongan'], 0, ',', '.') }}</td>
                <td>
                    <strong>
                        Rp {{ number_format($row['bersih'], 0, ',', '.') }}
                    </strong>
                </td>
                <td>
                    {!! $row['valid'] 
                        ? '<span style="color:green;">✓ Valid</span>' 
                        : '<span style="color:red;">✗ Tidak valid</span>' !!}
                </td>
            </tr>

            {{-- ===============================
                 HIDDEN INPUT (WAJIB LENGKAP)
               =============================== --}}
            <input type="hidden" name="data[{{ $i }}][nip]" value="{{ $row['nip'] }}">
            <input type="hidden" name="data[{{ $i }}][tanggal]" value="{{ $row['tanggal'] }}">
            <input type="hidden" name="data[{{ $i }}][jenis_dana]" value="{{ $row['jenis_dana'] }}">
            <input type="hidden" name="data[{{ $i }}][nominal]" value="{{ $row['nominal'] }}">
            <input type="hidden" name="data[{{ $i }}][potongan]" value="{{ $row['potongan'] }}">
            <input type="hidden" name="data[{{ $i }}][nama_bank]" value="{{ $row['nama_bank'] }}">
            <input type="hidden" name="data[{{ $i }}][nama_rekening]" value="{{ $row['nama_rekening'] }}">
            <input type="hidden" name="data[{{ $i }}][no_rekening]" value="{{ $row['no_rekening'] }}">
            <input type="hidden" name="data[{{ $i }}][keterangan]" value="{{ $row['keterangan'] }}">
            <input type="hidden" name="data[{{ $i }}][valid]" value="{{ $row['valid'] ? 1 : 0 }}">
        @endforeach
    </table>

    <br>

    <button type="submit">✅ Konfirmasi & Simpan</button>
    <a href="{{ route('pencairan.import.form') }}">❌ Batal</a>
</form>

@endsection

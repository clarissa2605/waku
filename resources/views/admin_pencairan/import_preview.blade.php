<h1>Preview Import Pencairan Dana</h1>

<form method="POST" action="{{ route('pencairan.import.confirm') }}">
    @csrf

    <table border="1" cellpadding="6">
        <tr>
            <th>No</th>
            <th>NIP</th>
            <th>Nama Pegawai</th>
            <th>Tanggal</th>
            <th>Jenis Dana</th>
            <th>Nominal</th>
            <th>Status</th>
        </tr>

        @foreach ($rows as $i => $row)
            <tr style="{{ $row['valid'] ? '' : 'background:#ffe6e6' }}">
                <td>{{ $i + 1 }}</td>
                <td>{{ $row['nip'] }}</td>
                <td>{{ $row['nama'] }}</td>
                <td>{{ $row['tanggal'] }}</td>
                <td>{{ $row['jenis_dana'] }}</td>
                <td>Rp {{ number_format($row['nominal'], 0, ',', '.') }}</td>
                <td>{{ $row['valid'] ? '✓ Valid' : '✗ Tidak valid' }}</td>

                {{-- HIDDEN INPUT WAJIB DI DALAM TD --}}
                <td style="display:none;">
                    <input type="hidden" name="data[{{ $i }}][nip]" value="{{ $row['nip'] }}">
                    <input type="hidden" name="data[{{ $i }}][tanggal]" value="{{ $row['tanggal'] }}">
                    <input type="hidden" name="data[{{ $i }}][jenis_dana]" value="{{ $row['jenis_dana'] }}">
                    <input type="hidden" name="data[{{ $i }}][nominal]" value="{{ $row['nominal'] }}">
                    <input type="hidden" name="data[{{ $i }}][keterangan]" value="{{ $row['keterangan'] }}">
                    <input type="hidden" name="data[{{ $i }}][valid]" value="{{ $row['valid'] ? 1 : 0 }}">
                </td>
            </tr>
        @endforeach
    </table>

    <br>

    <button type="submit">✅ Konfirmasi & Simpan</button>
    <a href="{{ route('pencairan.import.form') }}">❌ Batal</a>
</form>

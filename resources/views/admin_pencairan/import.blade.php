<h1>Import Pencairan Dana (CSV)</h1>

@if ($errors->any())
    <ul style="color:red;">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST"
      action="{{ route('pencairan.import.preview') }}"
      enctype="multipart/form-data">
    @csrf

    <label>File CSV</label><br>
    <input type="file" name="file" accept=".csv" required>
    <br><br>

    <button type="submit">Import & Preview</button>
</form>

<p>
    <small>
        <b>Format CSV (WAJIB):</b><br>
        nip;tanggal;jenis_dana;nominal;keterangan<br><br>

        <i>Contoh:</i><br>
        200104112022012067;2026-02-10;Honor Kegiatan;500000;Honor rapat
    </small>
</p>

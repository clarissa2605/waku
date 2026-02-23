@extends('layouts.app')

@section('content')

<h1>Import Pencairan Dana (CSV)</h1>

@if ($errors->any())
    <div style="color:red; margin-bottom:15px;">
        <b>Terjadi kesalahan:</b>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST"
      action="{{ route('pencairan.import.preview') }}"
      enctype="multipart/form-data">

    @csrf

    <!-- MODE -->
    <label><b>Jenis Pencairan *</b></label><br>
    <select name="mode" id="modeSelect" required>
        <option value="pegawai">Pegawai</option>
        <option value="mitra">Mitra</option>
    </select>
    <br><br>

    <label><b>Pilih File CSV</b></label><br>
    <input type="file" name="file" accept=".csv" required>
    <br><br>

    <button type="submit">📂 Import & Preview</button>
</form>

<br><br>

<hr style="margin:25px 0;">

<h3>📄 Petunjuk Format CSV</h3>

<div id="formatPegawai">
    <p><b>Format Pegawai:</b></p>
    <code>
        nip;tanggal;jenis_dana;nominal;potongan;nama_bank;nama_rekening;no_rekening;keterangan
    </code>
</div>

<div id="formatMitra" style="display:none;">
    <p><b>Format Mitra:</b></p>
    <code>
        nik;tanggal;jenis_dana;nominal;potongan;kelompok_id;nama_bank;nama_rekening;no_rekening;keterangan
    </code>
</div>

<script>
document.getElementById('modeSelect').addEventListener('change', function() {
    if (this.value === 'mitra') {
        document.getElementById('formatPegawai').style.display = 'none';
        document.getElementById('formatMitra').style.display = 'block';
    } else {
        document.getElementById('formatPegawai').style.display = 'block';
        document.getElementById('formatMitra').style.display = 'none';
    }
});
</script>

<a href="{{ route('pencairan.template') }}">
    📥 Download Template CSV
</a>


<hr style="margin:25px 0;">

<h3>📄 Petunjuk Format CSV</h3>

<p>
    <b>Format kolom (WAJIB urut dan lengkap):</b><br>
    <code>
        nip;tanggal;jenis_dana;nominal;potongan;nama_bank;nama_rekening;no_rekening;keterangan
    </code>
</p>

<p>
    <b>Contoh isi file CSV:</b>
</p>

<pre style="background:#f4f4f4; padding:10px;">
123456789012345678;2024-07-01;Tunjangan Kinerja;5000000;0;BRI;JOHN DOE;1234567890;Tunjangan bulan Juli
123456789012345679;2024-07-02;Bonus Tahunan;10000000;1000000;MANDIRI;JANE SMITH;0987654321;Bonus kinerja tahunan
</pre>

<h4>📝 Catatan Penting:</h4>
<ul>
    <li>File harus berformat <b>.csv</b></li>
    <li>Gunakan tanda pemisah <b>titik koma ( ; )</b></li>
    <li>Nomor rekening hanya boleh berisi angka</li>
    <li>Kolom <b>potongan</b> dapat diisi 0 jika tidak ada potongan</li>
    <li>Data pegawai harus sudah terdaftar dan berstatus aktif</li>
    <li>Data tidak valid akan ditandai pada halaman preview dan tidak akan disimpan</li>
</ul>

@endsection

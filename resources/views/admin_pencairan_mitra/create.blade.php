@extends('layouts.app')

@section('content')
<h1>Input Pencairan Dana Mitra</h1>

@if($errors->any())
    <div style="color:red">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('pencairan.mitra.store') }}">
    @csrf

    <!-- MITRA -->
    <label>Mitra *</label><br>
    <select name="mitra_id" id="mitraSelect" required>
        <option value="">-- Pilih Mitra --</option>
        @foreach($mitra as $m)
            <option value="{{ $m->id_mitra }}">
                {{ $m->nama_mitra }} ({{ $m->nik }})
            </option>
        @endforeach
    </select>
    <br><br>

    <!-- KELOMPOK OTOMATIS -->
    <label>Kelompok *</label><br>
    <select name="kelompok_id" id="kelompokSelect" required>
        <option value="">-- Pilih Mitra Dulu --</option>
    </select>
    <br><br>

    <!-- JENIS -->
    <label>Jenis Dana *</label><br>
    <input type="text" name="jenis_dana" required>
    <br><br>

    <!-- NOMINAL -->
    <label>Nominal (Total) *</label><br>
    <input type="number" name="nominal" id="nominal" min="1" required>
    <br><br>

    <!-- POTONGAN -->
    <label>Potongan</label><br>
    <input type="number" name="potongan" id="potongan" value="0" min="0">
    <small>Isi 0 jika tidak ada potongan</small>
    <br><br>

    <!-- REKENING DIINPUT SAAT PENCAIRAN -->
    <label>Nama Bank *</label><br>
    <input type="text" name="nama_bank" required>
    <br><br>

    <label>Nama Rekening *</label><br>
    <input type="text" name="nama_rekening" required>
    <br><br>

    <label>Nomor Rekening *</label><br>
    <input type="text" name="no_rekening"
           pattern="[0-9]*"
           inputmode="numeric"
           oninput="this.value = this.value.replace(/[^0-9]/g, '')"
           required>
    <br><br>

    <!-- TANGGAL -->
    <label>Tanggal *</label><br>
    <input type="date" name="tanggal" required>
    <br><br>

    <!-- KETERANGAN -->
    <label>Keterangan</label><br>
    <textarea name="keterangan"></textarea>
    <br><br>

    <button type="submit">Simpan</button>
</form>


<!-- ===============================
     SCRIPT FILTER KELOMPOK OTOMATIS
================================ -->

<script>
document.getElementById('mitraSelect').addEventListener('change', function() {

    let mitraId = this.value;
    let kelompokSelect = document.getElementById('kelompokSelect');

    if (!mitraId) {
        kelompokSelect.innerHTML = '<option value="">-- Pilih Mitra Dulu --</option>';
        return;
    }

    kelompokSelect.innerHTML = '<option value="">Loading...</option>';

    fetch('/admin/mitra/' + mitraId + '/kelompok')
    .then(response => response.json())
    .then(data => {

        kelompokSelect.innerHTML = '<option value="">-- Pilih Kelompok --</option>';

        if (data.length === 0) {
            kelompokSelect.innerHTML = '<option value="">Tidak ada kelompok</option>';
        }

        data.forEach(function(k) {
            kelompokSelect.innerHTML += `
                <option value="${k.id_kelompok}">
                    ${k.nama_kelompok} - ${k.nama_kegiatan ?? ''}
                </option>
            `;
        });
    })
    .catch(error => {
        kelompokSelect.innerHTML = '<option value="">Error mengambil data</option>';
    });

});


/* ===============================
   HITUNG NOMINAL BERSIH OTOMATIS
================================ */

document.getElementById('nominal').addEventListener('input', hitungBersih);
document.getElementById('potongan').addEventListener('input', hitungBersih);

function hitungBersih() {
    let nominal = parseFloat(document.getElementById('nominal').value) || 0;
    let potongan = parseFloat(document.getElementById('potongan').value) || 0;

    document.getElementById('nominalBersih').value = nominal - potongan;
}
</script>

@endsection
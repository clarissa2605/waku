@extends('layouts.app')

@section('content')

<h1 style="margin-bottom:20px;">Detail Kelompok Mitra</h1>

{{-- ===============================
     INFORMASI KELOMPOK
================================ --}}
<div style="margin-bottom:25px;">
    <h2>{{ $kelompok->nama_kelompok }}</h2>
    <p><strong>Kegiatan:</strong> {{ $kelompok->nama_kegiatan }}</p>
    <p><strong>Tahun:</strong> {{ $kelompok->tahun }}</p>
    @if($kelompok->keterangan)
        <p><strong>Keterangan:</strong> {{ $kelompok->keterangan }}</p>
    @endif
</div>

<hr>

{{-- ===============================
     STATISTIK
================================ --}}
<h3 style="margin-top:20px;">Statistik Kelompok</h3>

<div style="display:flex; gap:20px; margin:20px 0; flex-wrap:wrap;">

    <div style="flex:1; min-width:200px; padding:15px; background:#f5f5f5; border-radius:10px;">
        <h4>Total Anggota</h4>
        <h2>{{ $totalAnggota }}</h2>
    </div>

    <div style="flex:1; min-width:200px; padding:15px; background:#f5f5f5; border-radius:10px;">
        <h4>Total Transaksi</h4>
        <h2>{{ $totalTransaksi }}</h2>
    </div>

    <div style="flex:1; min-width:200px; padding:15px; background:#f5f5f5; border-radius:10px;">
        <h4>Total Nominal</h4>
        <h2>Rp {{ number_format($totalNominal,0,',','.') }}</h2>
    </div>

    <div style="flex:1; min-width:200px; padding:15px; background:#f5f5f5; border-radius:10px;">
        <h4>Total Dana Bersih</h4>
        <h2>Rp {{ number_format($totalDanaBersih,0,',','.') }}</h2>
    </div>

</div>

<hr>

{{-- ===============================
     DAFTAR ANGGOTA
================================ --}}
<h3>Daftar Anggota Kelompok</h3>

<table border="1" width="100%" cellpadding="6" cellspacing="0">
    <tr style="background:#f2f2f2;">
        <th>No</th>
        <th>Nama Mitra</th>
        <th>NIK</th>
        <th>No WhatsApp</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @forelse($kelompok->mitra as $i => $m)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $m->nama_mitra }}</td>
            <td>{{ $m->nik }}</td>
            <td>{{ $m->no_whatsapp }}</td>
            <td>
                @if($m->status == 'aktif')
                    <span style="color:green;">Aktif</span>
                @else
                    <span style="color:red;">Nonaktif</span>
                @endif
            </td>
            <td>
                <form method="POST"
                      action="{{ route('kelompok.removeMitra', [$kelompok->id_kelompok, $m->id_mitra]) }}"
                      onsubmit="return confirm('Yakin ingin menghapus mitra ini dari kelompok?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" style="background:red; color:white;">
                        Hapus
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" style="text-align:center;">Belum ada anggota</td>
        </tr>
    @endforelse
</table>

<br>

{{-- ===============================
     TOMBOL TAMBAH ANGGOTA
================================ --}}
<button onclick="toggleForm()" 
        style="padding:8px 15px; background:#007bff; color:white; border:none; border-radius:5px;">
    ➕ Tambah Anggota
</button>

<div id="formTambah" style="display:none; margin-top:20px; max-width:400px;">

    <input type="text" id="searchMitra"
           placeholder="Cari nama atau NIK..."
           style="width:100%; padding:8px; margin-bottom:10px;">

    <div id="searchResult"
         style="border:1px solid #ddd; border-radius:5px; max-height:200px; overflow-y:auto;">
    </div>

    <form method="POST" action="{{ route('kelompok.addMitra', $kelompok->id_kelompok) }}">
        @csrf
        <input type="hidden" name="mitra_id" id="selectedMitra">
        <button type="submit"
                style="margin-top:10px; padding:6px 12px; background:green; color:white; border:none; border-radius:5px;">
            Simpan
        </button>
    </form>
</div>

<script>

function toggleForm() {
    const form = document.getElementById('formTambah');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

// Data mitra dari backend
const mitraData = @json($mitra);

const searchInput = document.getElementById('searchMitra');
const resultBox = document.getElementById('searchResult');
const hiddenInput = document.getElementById('selectedMitra');

searchInput.addEventListener('input', function() {

    const keyword = this.value.toLowerCase();
    resultBox.innerHTML = '';

    if (keyword.length < 2) return;

    const filtered = mitraData.filter(m =>
        m.nama_mitra.toLowerCase().includes(keyword) ||
        m.nik.includes(keyword)
    );

    filtered.forEach(m => {

        const div = document.createElement('div');
        div.style.padding = '8px';
        div.style.cursor = 'pointer';
        div.style.borderBottom = '1px solid #eee';

        div.innerHTML = `
            <strong>${m.nama_mitra}</strong><br>
            <small>${m.nik}</small>
        `;

        div.onclick = function() {
            hiddenInput.value = m.id_mitra;
            searchInput.value = m.nama_mitra + ' (' + m.nik + ')';
            resultBox.innerHTML = '';
        };

        resultBox.appendChild(div);

    });

});

</script>

@endsection
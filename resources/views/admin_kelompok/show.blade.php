<h1>Detail Kelompok</h1>

<h3>{{ $kelompok->nama_kelompok }}</h3>
<p>Kegiatan: {{ $kelompok->nama_kegiatan }}</p>
<p>Tahun: {{ $kelompok->tahun }}</p>

<hr>

<h4>Daftar Mitra</h4>

<ul>
@foreach($kelompok->mitra as $m)
    <li>
        {{ $m->nama_mitra }} ({{ $m->nik }})
        <form action="{{ route('kelompok.removeMitra', [$kelompok->id_kelompok, $m->id_mitra]) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Hapus</button>
        </form>
    </li>
@endforeach
</ul>

<hr>

<h4>Tambah Mitra ke Kelompok</h4>

<form action="{{ route('kelompok.addMitra', $kelompok->id_kelompok) }}" method="POST">
    @csrf
    <select name="mitra_id" required>
        <option value="">-- Pilih Mitra --</option>
        @foreach($mitra as $m)
            <option value="{{ $m->id_mitra }}">
                {{ $m->nama_mitra }} ({{ $m->nik }})
            </option>
        @endforeach
    </select>
    <button type="submit">Tambah</button>
</form>

@if(session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif
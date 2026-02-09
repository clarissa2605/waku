<h1>Edit Pegawai</h1>

<form action="{{ route('pegawai.update', $pegawai->id_pegawai) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>NIP</label><br>
        <input type="text" value="{{ $pegawai->nip }}" readonly>
    </div>

    <div>
        <label>Nama</label><br>
        <input type="text" name="nama" value="{{ $pegawai->nama }}" required>
    </div>

    <div>
        <label>Unit Kerja</label><br>
        <input type="text" name="unit_kerja" value="{{ $pegawai->unit_kerja }}" required>
    </div>

    <div>
        <label>Nomor WhatsApp</label><br>
        <input type="text" value="{{ $pegawai->no_whatsapp }}" readonly>
        <small>*Hubungi admin untuk perubahan nomor</small>
    </div>

    <div>
        <label>Status</label><br>
        <select name="status" required>
            <option value="aktif" {{ $pegawai->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ $pegawai->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>
    </div>

    <br>
    <button type="submit">Update</button>
</form>

<a href="{{ route('pegawai.index') }}">← Kembali</a>

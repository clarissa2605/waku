<h1>Tambah Pegawai</h1>

<form action="{{ route('pegawai.store') }}" method="POST">
    @csrf

    <div>
        <label>NIP</label><br>
        <input type="text" name="nip" pattern="[0-9]{18}" required>
    </div>

    <div>
        <label>Nama</label><br>
        <input type="text" name="nama" required>
    </div>

    <div>
        <label>Unit Kerja</label><br>
        <input type="text" name="unit_kerja" required>
    </div>

    <div>
        <label>Nomor WhatsApp</label><br>
        <input type="text" name="no_whatsapp" pattern="[0-9]+" required>
    </div>

    <div>
        <label>Status</label><br>
        <select name="status" required>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
        </select>
    </div>

    <br>
    <button type="submit">Simpan</button>
</form>

<a href="{{ route('pegawai.index') }}">← Kembali</a>

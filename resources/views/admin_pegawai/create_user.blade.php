<h2>Buat Akun Login Pegawai</h2>

<p><strong>Nama:</strong> {{ $pegawai->nama }}</p>
<p><strong>NIP:</strong> {{ $pegawai->nip }}</p>

<form method="POST" action="{{ route('pegawai.user.store', $pegawai->id_pegawai) }}">
    @csrf

    <label>Email</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Buat Akun Login</button>
</form>

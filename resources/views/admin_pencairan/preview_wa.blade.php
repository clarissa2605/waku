<h2>Preview Pesan WhatsApp</h2>

<p><strong>Pegawai:</strong> {{ $pencairan->pegawai->nama }}</p>
<p><strong>Jenis Dana:</strong> {{ $pencairan->jenis_dana }}</p>

<hr>

<pre style="background:#f7f7f7;padding:15px;">
{{ $pesan }}
</pre>

<br>

<a href="{{ route('pencairan.index') }}">⬅ Kembali</a>

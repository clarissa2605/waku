<h1>Data Pegawai</h1>

<a href="{{ route('pegawai.create') }}">Tambah Pegawai</a>

<ul>
@foreach($pegawai as $p)
    <li>
        {{ $p->nama }} - {{ $p->unit_kerja }}
        <a href="{{ route('pegawai.edit', $p->id_pegawai) }}">Edit</a>
    </li>
@endforeach
</ul>

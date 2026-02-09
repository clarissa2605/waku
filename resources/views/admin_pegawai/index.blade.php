<h1>Data Pegawai</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red">{{ session('error') }}</p>
@endif

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>NIP</th>
            <th>Nama</th>
            <th>Unit Kerja</th>
            <th>No WhatsApp</th>
            <th>Status</th>
            <th>Akun Login</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pegawai as $p)
        <tr>
            <td>{{ $p->nip }}</td>
            <td>{{ $p->nama }}</td>
            <td>{{ $p->unit_kerja }}</td>
            <td>{{ $p->no_whatsapp }}</td>
            <td>{{ $p->status }}</td>

            {{-- STATUS AKUN LOGIN --}}
            <td>
                @if($p->user)
                    <span style="color: green;">Akun Aktif</span>
                @else
                    <span style="color: rgb(255, 30, 0);">Belum Ada</span>
                @endif
            </td>

            {{-- AKSI --}}
            <td>
                <a href="{{ route('pegawai.edit', $p->id_pegawai) }}">Edit</a>

                @if(!$p->user)
                    |
                    <a href="{{ route('pegawai.user.create', $p->id_pegawai) }}">
                        Buat Akun Login
                    </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>
<a href="{{ route('pegawai.create') }}">+ Tambah Pegawai</a>
<ul>
@foreach($pegawai as $p)
    <li>
        {{ $p->nama }} - {{ $p->unit_kerja }}
        <a href="{{ route('pegawai.edit', $p->id_pegawai) }}">Edit</a>
    </li>
    <form action="{{ route('pegawai.destroy', $p->id_pegawai) }}" 
      method="POST" 
      style="display:inline;"
      onsubmit="return confirm('Yakin ingin menonaktifkan pegawai ini?')">
    @csrf
    @method('DELETE')
    <button type="submit">Nonaktifkan</button>
</form>
@endforeach
</ul>


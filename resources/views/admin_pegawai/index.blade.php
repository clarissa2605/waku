<h1>Data Pegawai</h1>

{{-- FLASH MESSAGE --}}
@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@if(session('error'))
    <p style="color: red">{{ session('error') }}</p>
@endif

<br>

<a href="{{ route('pegawai.create') }}">+ Tambah Pegawai</a>

<br><br>

<table border="1" cellpadding="8" cellspacing="0" width="100%">
    <thead style="background:#f5f5f5">
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
        @forelse($pegawai as $p)
        <tr>
            <td>{{ $p->nip }}</td>
            <td>{{ $p->nama }}</td>
            <td>{{ $p->unit_kerja }}</td>
            <td>{{ $p->no_whatsapp }}</td>

            {{-- STATUS PEGAWAI --}}
            <td>
                @if($p->status === 'aktif')
                    <span style="color: green; font-weight: bold;">Aktif</span>
                @else
                    <span style="color: gray;">Nonaktif</span>
                @endif
            </td>

            {{-- STATUS AKUN LOGIN --}}
            <td>
                @if($p->user)
                    <span style="color: green;">Akun Aktif</span>
                @else
                    <span style="color: red;">Belum Ada</span>
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

                |
                <form action="{{ route('pegawai.destroy', $p->id_pegawai) }}"
                      method="POST"
                      style="display:inline"
                      onsubmit="return confirm('Yakin ingin menonaktifkan pegawai ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        style="
                            background:none;
                            border:none;
                            color:red;
                            cursor:pointer;
                            padding:0;
                        ">
                        Nonaktifkan
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" align="center">Belum ada data pegawai</td>
        </tr>
        @endforelse
    </tbody>
</table>

@extends('layouts.app')

@section('content')
    <h1>Daftar Pencairan Dana</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif

    <table border="1" cellpadding="5">
        <tr>
            <th>No</th>
            <th>Pegawai</th>
            <th>Tanggal</th>
            <th>Jenis Dana</th>
            <th>Nominal</th>
            <th>Potongan</th>
            <th>Nominal Bersih</th>
            <th>Status Notifikasi</th>
            <th>Aksi</th>
        </tr>

        @foreach($pencairan as $i => $p)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $p->pegawai->nama ?? '-' }}</td>
            <td>{{ $p->tanggal }}</td>
            <td>{{ $p->jenis_dana }}</td>

            <td>
                Rp {{ number_format($p->nominal, 0, ',', '.') }}
            </td>

            <td>
                Rp {{ number_format($p->potongan ?? 0, 0, ',', '.') }}
            </td>

            <td>
                <strong>
                    Rp {{ number_format($p->nominal_bersih ?? ($p->nominal - ($p->potongan ?? 0)), 0, ',', '.') }}
                </strong>
            </td>

            <td>
                @if($p->status_notifikasi == 'terkirim')
                    <span style="color:green;">✔ Terkirim</span>
                @elseif($p->status_notifikasi == 'gagal')
                    <span style="color:red;">✖ Gagal</span>
                @else
                    <span style="color:orange;">Belum</span>
                @endif
            </td>

            <td>
                <a href="{{ route('pencairan.preview_wa', $p->id_pencairan) }}">
                    👁 Preview
                </a>
                <br><br>

                <a href="{{ route('pencairan.kirim_wa', $p->id_pencairan) }}"
                   onclick="return confirm('Kirim notifikasi WhatsApp sekarang?')">
                    🚀 Kirim WA
                </a>
            </td>
        </tr>
        @endforeach
    </table>
@endsection

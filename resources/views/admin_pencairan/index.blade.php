@extends('layouts.app')

@section('content')
    <h1>Daftar Pencairan Dana</h1>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="5">
        <tr>
            <th>No</th>
            <th>Pegawai</th>
            <th>Tanggal</th>
            <th>Jenis Dana</th>
            <th>Nominal</th>
        </tr>

        @foreach($pencairan as $i => $p)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $p->pegawai->nama ?? '-' }}</td>
            <td>{{ $p->tanggal }}</td>
            <td>{{ $p->jenis_dana }}</td>
            <td>Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>
@endsection


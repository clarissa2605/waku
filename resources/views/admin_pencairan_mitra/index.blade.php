@extends('layouts.app')

@section('content')
<h1>Daftar Pencairan Dana Mitra</h1>

<a href="{{ route('pencairan.mitra.create') }}">
    + Tambah Pencairan Mitra
</a>

<br><br>

<table border="1" cellpadding="5">
    <tr>
        <th>No</th>
        <th>Mitra</th>
        <th>Tanggal</th>
        <th>Jenis Dana</th>
        <th>Nominal</th>
        <th>Potongan</th>
        <th>Bersih</th>
        <th>Status</th>
    </tr>

    @foreach($pencairan as $i => $p)
    <tr>
        <td>{{ $i+1 }}</td>
        <td>{{ $p->mitra->nama_mitra }}</td>
        <td>{{ $p->tanggal }}</td>
        <td>{{ $p->jenis_dana }}</td>
        <td>{{ number_format($p->nominal,0,',','.') }}</td>
        <td>{{ number_format($p->potongan,0,',','.') }}</td>
        <td>{{ number_format($p->nominal_bersih,0,',','.') }}</td>
        <td>{{ $p->status_notifikasi }}</td>
    </tr>
    @endforeach
</table>

@endsection
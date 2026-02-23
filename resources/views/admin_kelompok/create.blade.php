@extends('layouts.app')

@section('content')

<h1>Buat Kelompok Mitra</h1>

@if($errors->any())
    <div style="color:red; margin-bottom:15px;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('kelompok.store') }}">
    @csrf

    <label>Nama Kelompok</label><br>
    <input type="text" name="nama_kelompok" required>
    <br><br>

    <label>Nama Kegiatan</label><br>
    <input type="text" name="nama_kegiatan" required>
    <br><br>

    <label>Tahun</label><br>
    <input type="number" name="tahun" required>
    <br><br>

    <label>Keterangan</label><br>
    <textarea name="keterangan"></textarea>
    <br><br>

    <button type="submit"
            style="padding:8px 15px; background:green; color:white; border:none; border-radius:5px;">
        Simpan
    </button>
</form>

@endsection
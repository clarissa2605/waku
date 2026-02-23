@extends('layouts.app')

@section('content')

<h1 style="margin-bottom:20px;">Edit Kelompok Mitra</h1>

@if(session('success'))
    <div style="background:#d4edda; color:#155724; padding:10px; margin-bottom:15px; border-radius:5px;">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="background:#f8d7da; color:#721c24; padding:10px; margin-bottom:15px; border-radius:5px;">
        <strong>Terjadi kesalahan:</strong>
        <ul style="margin-top:5px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="max-width:500px;">

<form method="POST" action="{{ route('kelompok.update', $kelompok->id_kelompok) }}">
    @csrf
    @method('PUT')

    <label>Nama Kelompok</label><br>
    <input type="text"
           name="nama_kelompok"
           value="{{ old('nama_kelompok', $kelompok->nama_kelompok) }}"
           style="width:100%; padding:8px; margin-bottom:15px;"
           required>

    <label>Nama Kegiatan</label><br>
    <input type="text"
           name="nama_kegiatan"
           value="{{ old('nama_kegiatan', $kelompok->nama_kegiatan) }}"
           style="width:100%; padding:8px; margin-bottom:15px;"
           required>

    <label>Tahun</label><br>
    <input type="number"
           name="tahun"
           value="{{ old('tahun', $kelompok->tahun) }}"
           style="width:100%; padding:8px; margin-bottom:15px;"
           required>

    <label>Keterangan</label><br>
    <textarea name="keterangan"
              style="width:100%; padding:8px; margin-bottom:15px;">{{ old('keterangan', $kelompok->keterangan) }}</textarea>

    <div style="margin-top:10px;">
        <button type="submit"
                style="padding:8px 15px; background:green; color:white; border:none; border-radius:5px;">
            💾 Update
        </button>

        <a href="{{ route('kelompok.show', $kelompok->id_kelompok) }}"
           style="margin-left:10px; text-decoration:none;">
           Batal
        </a>
    </div>

</form>

</div>

@endsection
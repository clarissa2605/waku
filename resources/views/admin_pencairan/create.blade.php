
@extends('layouts.app')

@section('content')
    <h1>Input Pencairan Dana</h1>

    @if(session('success'))
        <div style="color: green; margin-bottom: 10px;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('pencairan.store') }}">
        @csrf

        <label>Pegawai</label><br>
        <select name="pegawai_id">
            @foreach($pegawai as $p)
                <option value="{{ $p->id_pegawai }}">
                    {{ $p->nama }} ({{ $p->nip }})
                </option>
            @endforeach
        </select><br><br>

        <label>Jenis Dana</label><br>
        <input type="text" name="jenis_dana"><br><br>

        <label>Nominal (Total)</label><br>
        <input type="number" name="nominal" required>

        <br><br>

        <label>Potongan</label><br>
        <input type="number" name="potongan" value="0" min="0">
        <small>Isi 0 jika tidak ada potongan</small>


        <label>Tanggal</label><br>
        <input type="date" name="tanggal"><br><br>

        <label>Keterangan</label><br>
        <textarea name="keterangan"></textarea><br><br>

        <button type="submit">Simpan</button>
    </form>
@endsection

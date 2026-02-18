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
        <select name="pegawai_id" required>
            @foreach($pegawai as $p)
                <option value="{{ $p->id_pegawai }}">
                    {{ $p->nama }} ({{ $p->nip }})
                </option>
            @endforeach
        </select><br><br>

        <!-- ✅ TAMBAHAN NAMA BANK DI SINI -->

        <label>Nama Bank</label><br>
        <input type="text"
               name="nama_bank"
               value="{{ old('nama_bank') }}"
               required><br><br>

        <!-- 🔥 TAMBAHAN REKENING -->

        <label>Nama Rekening</label><br>
        <input type="text"
               name="nama_rekening"
               value="{{ old('nama_rekening') }}"
               required><br><br>

        <label>Nomor Rekening</label><br>
        <input type="text"
               name="no_rekening"
               pattern="[0-9]*"
               inputmode="numeric"
               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
               value="{{ old('no_rekening') }}"
               required><br><br>

        <!-- 🔥 END TAMBAHAN -->

        <label>Jenis Dana</label><br>
        <input type="text" name="jenis_dana" required><br><br>

        <label>Nominal (Total)</label><br>
        <input type="number" name="nominal" required><br><br>

        <label>Potongan</label><br>
        <input type="number" name="potongan" value="0" min="0">
        <small>Isi 0 jika tidak ada potongan</small>
        <br><br>

        <label>Tanggal</label><br>
        <input type="date" name="tanggal" required><br><br>

        <label>Keterangan</label><br>
        <textarea name="keterangan"></textarea><br><br>

        <button type="submit">Simpan</button>
    </form>
@endsection

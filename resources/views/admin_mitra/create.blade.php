@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow">

    <h1 class="text-2xl font-bold mb-6">Tambah Mitra</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mitra.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block font-semibold">Nama Mitra *</label>
            <input type="text" name="nama_mitra" 
                   class="w-full border rounded-lg p-3"
                   required>
        </div>

        <div>
            <label class="block font-semibold">NIK *</label>
            <input type="text" name="nik" 
                   class="w-full border rounded-lg p-3"
                   required>
        </div>

        <div>
            <label class="block font-semibold">WhatsApp *</label>
            <input type="text" name="no_whatsapp" 
                   class="w-full border rounded-lg p-3"
                   required>
        </div>

        <div>
            <label class="block font-semibold">Alamat</label>
            <textarea name="alamat" 
                      class="w-full border rounded-lg p-3"></textarea>
        </div>

        <div>
            <label class="block font-semibold">Jenis Mitra</label>
            <input type="text" name="jenis_mitra" 
                   class="w-full border rounded-lg p-3">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold">Tanggal Mulai Kontrak</label>
                <input type="date" name="tanggal_mulai_kontrak" 
                       class="w-full border rounded-lg p-3">
            </div>

            <div>
                <label class="block font-semibold">Tanggal Selesai Kontrak</label>
                <input type="date" name="tanggal_selesai_kontrak" 
                       class="w-full border rounded-lg p-3">
            </div>
        </div>

        <div>
            <label class="block font-semibold">Keterangan</label>
            <textarea name="keterangan" 
                      class="w-full border rounded-lg p-3"></textarea>
        </div>

        <div>
            <label class="block font-semibold">Status</label>
            <select name="status" class="w-full border rounded-lg p-3">
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
            </select>
        </div>

        <button type="submit"
                class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
            Simpan Mitra
        </button>
    </form>

</div>
@endsection
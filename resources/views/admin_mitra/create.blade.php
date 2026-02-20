@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 flex items-center justify-center py-10">

    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-xl p-10 border border-gray-200">

        <h2 class="text-2xl font-semibold text-slate-800 mb-8">
            Tambah Mitra
        </h2>

        <form action="{{ route('mitra.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-2 gap-6">

                <div>
                    <label class="block text-sm text-slate-600 mb-2">
                        Nama Mitra
                    </label>
                    <input type="text" name="nama"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition"
                        required>
                </div>

                <div>
                    <label class="block text-sm text-slate-600 mb-2">
                        NIK
                    </label>
                    <input type="text" name="nik"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                </div>

                <div>
                    <label class="block text-sm text-slate-600 mb-2">
                        WhatsApp
                    </label>
                    <input type="text" name="whatsapp"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                </div>

                <div>
                    <label class="block text-sm text-slate-600 mb-2">
                        Status
                    </label>
                    <select name="status"
                        class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

            </div>

            <div class="mt-8">
                <button type="submit"
                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-md transition">
                    Simpan Mitra
                </button>
            </div>

        </form>
    </div>

</div>
@endsection
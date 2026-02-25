@extends('layouts.app')

@section('title')

@section('content')

<div class="mb-6">
    <h2 class="text-2xl font-semibold text-slate-800">
        Tambah Mitra
    </h2>
    <p class="text-sm text-slate-500 mt-1">
        Lengkapi informasi mitra untuk didaftarkan ke dalam sistem.
    </p>
</div>

<div class="bg-white border border-slate-200 rounded-lg p-8">

    @if ($errors->any())
        <div class="mb-6 bg-red-100 text-red-600 text-sm p-4 rounded-md border border-red-200">
            <div class="font-semibold mb-2">Terjadi kesalahan:</div>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mitra.store') }}" method="POST" class="space-y-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="space-y-6">

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Mitra *
                    </label>
                    <input type="text" name="nama_mitra" required
                           class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        NIK *
                    </label>
                    <input type="text" name="nik" required
                           class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <p class="text-xs text-slate-500 mt-1">
                     16 digit angka sesuai data kependudukan.
                     </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nomor WhatsApp *
                    </label>
                    <input type="text" name="no_whatsapp" required
                           class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                </label>
                    <p class="text-xs text-slate-500 mt-1">
                        Otomatis dikonversi ke format 628xxxxxxxxxx
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Alamat
                    </label>
                    <textarea name="alamat" rows="3"
                              class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                </div>

            </div>

            <div class="space-y-6">

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Jenis Mitra
                    </label>
                    <input type="text" name="jenis_mitra"
                           class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Tanggal Mulai Kontrak
                        </label>
                        <input type="date" name="tanggal_mulai_kontrak"
                               class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            Tanggal Selesai Kontrak
                        </label>
                        <input type="date" name="tanggal_selesai_kontrak"
                               class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Keterangan
                    </label>
                    <textarea name="keterangan" rows="3"
                              class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Status
                    </label>
                    <select name="status"
                            class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

            </div>

        </div>

        <div class="flex justify-between items-center pt-8 border-t border-slate-200">

            <a href="{{ route('mitra.index') }}"
               class="text-sm text-slate-500 hover:text-blue-600 transition">
                ← Kembali ke Data Mitra
            </a>

            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                Simpan Mitra
            </button>

        </div>

    </form>

</div>

{{-- ================= MODAL PREVIEW ================= --}}
<div id="previewModal"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-lg rounded-xl p-8 shadow-xl">

        <h3 class="text-lg font-semibold mb-6">
            Konfirmasi Data Mitra
        </h3>

        <div class="space-y-3 text-sm">
            <p><strong>Nama:</strong> <span id="p_nama"></span></p>
            <p><strong>NIK:</strong> <span id="p_nik"></span></p>
            <p><strong>WhatsApp:</strong> <span id="p_wa"></span></p>
            <p><strong>Jenis Mitra:</strong> <span id="p_jenis"></span></p>
            <p><strong>Status:</strong> <span id="p_status"></span></p>
        </div>

        <div class="flex justify-end gap-3 mt-8">
            <button onclick="closePreview()"
                class="px-4 py-2 bg-slate-200 rounded-lg">
                Batal
            </button>

            <button onclick="submitForm()"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                Konfirmasi & Simpan
            </button>
        </div>
    </div>
</div>

<script>
/* ================= AUTO FORMAT WHATSAPP ================= */
document.getElementById('no_whatsapp').addEventListener('input', function(e){
    let value = e.target.value.replace(/\D/g, '');

    if(value.startsWith('0')){
        value = '62' + value.substring(1);
    }

    if(!value.startsWith('62')){
        value = '62' + value;
    }

    e.target.value = value;
});

/* ================= PREVIEW ================= */
function showPreview(){

    document.getElementById('p_nama').innerText =
        document.getElementById('nama_mitra').value;

    document.getElementById('p_nik').innerText =
        document.getElementById('nik').value;

    document.getElementById('p_wa').innerText =
        document.getElementById('no_whatsapp').value;

    document.getElementById('p_jenis').innerText =
        document.getElementById('jenis_mitra').value || '-';

    document.getElementById('p_status').innerText =
        document.getElementById('status').value;

    document.getElementById('previewModal').classList.remove('hidden');
    document.getElementById('previewModal').classList.add('flex');
}

function closePreview(){
    document.getElementById('previewModal').classList.add('hidden');
}

function submitForm(){
    document.getElementById('mitraForm').submit();
}
</script>

@endsection
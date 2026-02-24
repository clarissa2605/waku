@extends('layouts.app')

@section('title')

@section('content')

{{-- ================= PAGE HEADER ================= --}}
<div class="mb-8">
    <h1 class="text-2xl font-semibold text-slate-800">
        Tambah Pegawai
    </h1>
    <p class="text-sm text-slate-500 mt-2">
        Lengkapi informasi pegawai untuk didaftarkan ke dalam sistem WAKU.
    </p>
</div>

{{-- ================= CARD ================= --}}
<div x-data="pegawaiForm()" class="bg-white border border-slate-200 rounded-lg p-8">

    {{-- ERROR MESSAGE --}}
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

    <form action="{{ route('pegawai.store') }}"
          method="POST"
          class="space-y-8"
          @submit.prevent="openPreview">
        @csrf

        {{-- FORM GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- LEFT COLUMN --}}
            <div class="space-y-6">

                {{-- NIP --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        NIP
                    </label>
                    <input type="text"
                           name="nip"
                           x-model="nip"
                           pattern="[0-9]{18}"
                           required
                           class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <p class="text-xs text-slate-500 mt-1">
                        18 digit angka sesuai data kepegawaian.
                    </p>
                </div>

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nama Lengkap
                    </label>
                    <input type="text"
                           name="nama"
                           x-model="nama"
                           required
                           class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

            </div>

            {{-- RIGHT COLUMN --}}
            <div class="space-y-6">

                {{-- Unit Kerja --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Unit Kerja
                    </label>
                    <input type="text"
                           name="unit_kerja"
                           x-model="unit_kerja"
                           required
                           class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                {{-- Nomor WA --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Nomor WhatsApp
                    </label>
                    <input type="text"
                           name="no_whatsapp"
                           x-model="no_whatsapp"
                           @input="formatWA"
                           required
                           class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm
                                  focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    <p class="text-xs text-slate-500 mt-1">
                        Otomatis dikonversi ke format 628xxxxxxxx
                    </p>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Status Pegawai
                    </label>
                    <select name="status"
                            x-model="status"
                            required
                            class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm
                                   focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>

            </div>

        </div>

        {{-- ACTION --}}
        <div class="flex justify-between items-center pt-8 border-t border-slate-200">

            <a href="{{ route('pegawai.index') }}"
               class="text-sm text-slate-500 hover:text-blue-600 transition">
                ← Kembali ke Daftar Pegawai
            </a>

            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white text-sm rounded-md
                           hover:bg-blue-700 transition">
                Simpan Data
            </button>

        </div>

    </form>

    {{-- ================= PREVIEW MODAL ================= --}}
    <div x-show="previewOpen"
         x-transition
         class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">

        <div class="bg-white w-full max-w-lg rounded-lg border border-slate-200 p-6">

            <h3 class="text-lg font-semibold text-slate-800 mb-4">
                Konfirmasi Data Pegawai
            </h3>

            <div class="space-y-3 text-sm">

                <div class="flex justify-between">
                    <span class="text-slate-500">NIP</span>
                    <span x-text="nip"></span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">Nama</span>
                    <span x-text="nama"></span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">Unit Kerja</span>
                    <span x-text="unit_kerja"></span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">WhatsApp</span>
                    <span x-text="no_whatsapp"></span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-500">Status</span>
                    <span x-text="status"></span>
                </div>

            </div>

            <div class="flex justify-end space-x-3 mt-6">

                <button @click="previewOpen = false"
                        class="px-4 py-2 text-sm text-slate-600 hover:text-slate-800">
                    Batal
                </button>

                <button @click="$el.closest('[x-data]').querySelector('form').submit()"
                        class="px-5 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                    Konfirmasi & Simpan
                </button>

            </div>

        </div>

    </div>

</div>

{{-- ================= ALPINE LOGIC ================= --}}
<script>
function pegawaiForm() {
    return {
        nip: '',
        nama: '',
        unit_kerja: '',
        no_whatsapp: '',
        status: 'aktif',
        previewOpen: false,

        formatWA() {
            this.no_whatsapp = this.no_whatsapp.replace(/\D/g, '');

            if (this.no_whatsapp.startsWith('08')) {
                this.no_whatsapp = '628' + this.no_whatsapp.slice(2);
            }
        },

        openPreview() {
            this.previewOpen = true;
        }
    }
}
</script>

@endsection
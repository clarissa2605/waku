@extends('layouts.app')

@section('title')

@section('content')

{{-- ================= PAGE HEADER ================= --}}
<div class="mb-8">
    <h1 class="text-2xl font-semibold text-slate-800">
        Buat Akun Login Pegawai
    </h1>
    <p class="text-sm text-slate-500 mt-2">
        Buat akun login untuk pegawai agar dapat mengakses sistem WAKU.
    </p>
</div>

{{-- ================= CARD ================= --}}
<div class="bg-white border border-slate-200 rounded-lg p-8">

    {{-- INFO PEGAWAI --}}
    <div class="mb-8">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">
            Informasi Pegawai
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

            <div>
                <p class="text-slate-500">Nama</p>
                <p class="font-medium text-slate-800">
                    {{ $pegawai->nama }}
                </p>
            </div>

            <div>
                <p class="text-slate-500">NIP</p>
                <p class="font-medium text-slate-800">
                    {{ $pegawai->nip }}
                </p>
            </div>

        </div>
    </div>

    <div class="border-t border-slate-200 my-6"></div>

    {{-- FORM --}}
    <form method="POST"
          action="{{ route('pegawai.user.store', $pegawai->id_pegawai) }}"
          class="space-y-6">
        @csrf

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Email
            </label>
            <input type="email"
                   name="email"
                   required
                   class="w-full border border-slate-200 rounded-md px-4 py-2 text-sm
                          focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Password
            </label>

            <div class="relative">
                <input type="password"
                    id="password"
                    name="password"
                    required
                    class="w-full border border-slate-200 rounded-md px-4 py-2 pr-12 text-sm
                            focus:ring-2 focus:ring-blue-500 focus:outline-none">

                <button type="button"
                        id="togglePassword"
                        class="absolute inset-y-0 right-0 flex items-center px-3 text-slate-400 hover:text-slate-600">
                    <svg id="eyeIcon"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.036 12.322a1.012 1.012 0 010-.644
                                C3.423 7.51 7.36 4.5 12 4.5
                                c4.638 0 8.573 3.007 9.963 7.178
                                .07.207.07.431 0 .644
                                C20.577 16.49 16.64 19.5 12 19.5
                                c-4.638 0-8.573-3.007-9.964-7.178z" />
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>

            <p class="text-xs text-slate-400 mt-1">
                Pastikan password minimal 8 karakter.
            </p>
        </div>

        {{-- ACTION --}}
        <div class="flex justify-between items-center pt-6 border-t border-slate-200">

            <a href="{{ route('pegawai.index') }}"
               class="text-sm text-slate-500 hover:text-blue-600 transition">
                ← Kembali ke Daftar Pegawai
            </a>

            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white text-sm rounded-md
                           hover:bg-blue-700 transition">
                Buat Akun Login
            </button>

        </div>

    </form>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const password = document.getElementById('password');
    const toggle = document.getElementById('togglePassword');

    toggle.addEventListener('click', function () {

        if (password.type === 'password') {
            password.type = 'text';
        } else {
            password.type = 'password';
        }

    });

});
</script>
@endpush

@endsection
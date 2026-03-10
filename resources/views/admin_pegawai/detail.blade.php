@extends('layouts.app')

@section('title')

@section('content')

{{-- HEADER --}}
<div class="flex justify-between items-center mb-6">

    <div>
        <h2 class="text-2xl font-semibold text-slate-800">
            Detail Pegawai
        </h2>

        <p class="text-sm text-slate-500 mt-1">
            Informasi lengkap data pegawai dalam sistem.
        </p>
    </div>

</div>


{{-- CARD --}}
<div class="bg-white border border-slate-200 rounded-lg p-8">

<div class="grid md:grid-cols-2 gap-x-12 gap-y-6 text-sm">

{{-- NIP --}}
<div>
<p class="text-slate-500 mb-1">NIP</p>
<p class="font-medium text-slate-800">
{{ $pegawai->nip }}
</p>
</div>


{{-- NAMA --}}
<div>
<p class="text-slate-500 mb-1">Nama</p>
<p class="font-medium text-slate-800">
{{ $pegawai->nama }}
</p>
</div>


{{-- UNIT KERJA --}}
<div>
<p class="text-slate-500 mb-1">Unit Kerja</p>
<p class="font-medium text-slate-800">
{{ $pegawai->unit_kerja }}
</p>
</div>


{{-- WHATSAPP --}}
<div>
<p class="text-slate-500 mb-1">Nomor WhatsApp</p>
<p class="font-medium text-slate-800">
{{ $pegawai->no_whatsapp }}
</p>
</div>


{{-- EMAIL LOGIN --}}
<div>
<p class="text-slate-500 mb-1">Email Login</p>

@if($pegawai->user)
<p class="font-medium text-slate-800">
{{ $pegawai->user->email }}
</p>
@else
<p class="text-slate-400 italic">
Belum memiliki akun
</p>
@endif

</div>


{{-- STATUS --}}
<div>
<p class="text-slate-500 mb-1">Status</p>

@if($pegawai->status == 'aktif')
<span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
Aktif
</span>
@else
<span class="px-3 py-1 text-xs rounded-full bg-slate-200 text-slate-600">
Nonaktif
</span>
@endif

</div>

</div>


{{-- DIVIDER --}}
<hr class="my-8 border-slate-200">


{{-- BUTTON --}}
<a href="{{ route('pegawai.index') }}"
class="text-sm text-slate-500 hover:text-slate-700 flex items-center gap-2">

← Kembali ke Data Pegawai

</a>

</div>

@endsection
@extends('layouts.app')

@section('title','Profil Saya')

@section('content')

<div class="max-w-3xl mx-auto">

<div class="bg-white border border-slate-200 rounded-xl p-8 space-y-8">


{{-- HEADER PROFIL --}}
<div class="flex items-center gap-4">

<div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-semibold text-lg">

{{ strtoupper(substr($pegawai->nama,0,1)) }}

</div>

<div>
<h2 class="text-xl font-semibold text-slate-800">
Profil Pegawai
</h2>

<p class="text-sm text-slate-500">
Informasi akun pegawai pada sistem WAKU
</p>
</div>

</div>



{{-- INFORMASI PEGAWAI --}}
<div class="grid md:grid-cols-2 gap-6 text-sm">

<div>
<p class="text-slate-500">NIP</p>
<p class="font-medium">{{ $pegawai->nip }}</p>
</div>

<div>
<p class="text-slate-500">Nama</p>
<p class="font-medium">{{ $pegawai->nama }}</p>
</div>

<div>
<p class="text-slate-500">Unit Kerja</p>
<p class="font-medium">{{ $pegawai->unit_kerja }}</p>
</div>

<div>
<p class="text-slate-500">Nomor WhatsApp</p>
<p class="font-medium">{{ $pegawai->no_whatsapp }}</p>
</div>

<div class="md:col-span-2">
<p class="text-slate-500">Email</p>
<p class="font-medium">{{ $user->email }}</p>
</div>

</div>



{{-- KEAMANAN AKUN --}}
<div class="border-t border-slate-200 pt-6">

<p class="text-sm text-slate-500 mb-3">
Keamanan Akun
</p>

<div class="flex items-center justify-between text-sm mb-4">

<span class="text-slate-700">
Password
</span>

<span class="font-medium tracking-widest">
********
</span>

</div>



{{-- INFO LUPA PASSWORD --}}
<div class="flex items-start gap-3 bg-yellow-50 border border-yellow-200 text-yellow-800 text-sm p-4 rounded-lg">

{{-- HEROICON WARNING --}}
<svg xmlns="http://www.w3.org/2000/svg"
class="w-5 h-5 mt-0.5 text-yellow-600"
fill="none"
viewBox="0 0 24 24"
stroke-width="1.5"
stroke="currentColor">

<path stroke-linecap="round"
stroke-linejoin="round"
d="M12 9v3.75m0 3.75h.007M3.981 20.49h16.038c1.54 0 2.502-1.667 1.732-3L13.732 4.5c-.77-1.333-2.694-1.333-3.464 0L2.249 17.49c-.77 1.333.192 3 1.732 3z" />

</svg>

<p>
Jika Anda lupa password, silakan hubungi 
<span class="font-medium">administrator sistem</span> 
untuk melakukan reset password akun Anda.
</p>

</div>

</div>

</div>

</div>

@endsection
<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-[#01214d] relative overflow-hidden">

{{-- BATIK BACKGROUND --}}
<div class="absolute inset-0 opacity-20"
style="
background-image:url('{{ asset('images/batik-pattern2.png') }}');
background-size:600px;
background-repeat:repeat;
"></div>


<div class="relative w-full max-w-6xl flex items-center justify-between px-10">


{{-- LEFT PANEL --}}
<div class="w-[55%] text-white pr-16">

<div class="flex items-center gap-4 mb-10">

<img src="{{ asset('images/logo-app-nobg.png') }}" class="h-24">

<div>
<h1 class="text-4xl font-bold tracking-wide">
WAKU
</h1>

<p class="text-blue-200 text-sm">
Web Administrasi Keuangan Unit
</p>
</div>

</div>


<h2 class="text-4xl font-semibold leading-tight mb-6">
Web Administrasi <br>
Keuangan Unit
</h2>


<p class="text-blue-100 leading-relaxed max-w-lg mb-12">
Sistem notifikasi dan riwayat pencairan dana pegawai berbasis web
dan WhatsApp untuk mendukung pengelolaan keuangan yang
transparan dan terintegrasi.
</p>


<div class="flex items-center gap-3 opacity-80">

<span class="text tracking-wider uppercase">
SUPPORTED BY
</span>

<img src="{{ asset('images/logoBps.png') }}" class="h-12">

</div>

<p class="text-blue-100 text-sm mt-2">
Tim Keuangan Badan Pusat Statistik Sulawesi Utara
</p>

</div>



{{-- RIGHT PANEL --}}
<div class="w-[420px]">

<div class="bg-white rounded-2xl shadow-xl p-10">

<div class="mb-8">

<h2 class="text-2xl font-semibold text-slate-800">
Sign in to WAKU
</h2>

<p class="text-slate-500 text-sm mt-1">
Access your dashboard securely
</p>


<div class="flex items-center gap-2 mt-3 text-sm text-slate-500">

<svg xmlns="http://www.w3.org/2000/svg"
class="w-5 h-5 text-emerald-500"
fill="none"
viewBox="0 0 24 24"
stroke-width="2"
stroke="currentColor">

<path stroke-linecap="round" stroke-linejoin="round"
d="M12 3l7 4v5c0 5-3.5 8-7 9-3.5-1-7-4-7-9V7l7-4z"/>

<path stroke-linecap="round" stroke-linejoin="round"
d="M9 12l2 2 4-4"/>

</svg>

Secure Internal System

</div>

</div>


<form method="POST" action="{{ url('/login') }}">
@csrf


<div class="mb-5">

<label class="block text-sm font-medium text-slate-700 mb-2">
Email
</label>

<div class="relative">

<svg xmlns="http://www.w3.org/2000/svg"
class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"
fill="none"
viewBox="0 0 24 24"
stroke-width="1.8"
stroke="currentColor">

<path stroke-linecap="round" stroke-linejoin="round"
d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5A2.25 2.25 0 012.25 17.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5A2.25 2.25 0 002.25 6.75m19.5 0l-9.75 6-9.75-6"/>

</svg>

<input
type="email"
name="email"
required
class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-lg
focus:outline-none focus:ring-2 focus:ring-[#01214d]">

</div>

</div>

<div class="mb-6">

<label class="block text-sm font-medium text-slate-700 mb-2">
Password
</label>

<div class="relative">

<svg xmlns="http://www.w3.org/2000/svg"
class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"
fill="none"
viewBox="0 0 24 24"
stroke-width="1.8"
stroke="currentColor">

<path stroke-linecap="round" stroke-linejoin="round"
d="M16.5 10.5V7.875a4.125 4.125 0 10-8.25 0V10.5m-1.5 0h11.25A2.25 2.25 0 0120.25 12.75v6a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25v-6A2.25 2.25 0 016 10.5z"/>

</svg>

<input
type="password"
name="password"
required
class="w-full pl-10 pr-4 py-3 border border-slate-300 rounded-lg
focus:outline-none focus:ring-2 focus:ring-[#01214d]">

</div>

</div>


<div class="flex items-center mb-6 text-sm text-slate-600">

<label class="flex items-center">
<input type="checkbox" class="mr-2">
Remember me
</label>

</div>


<button
id="loginButton"
class="w-full bg-[#01214d] hover:bg-[#0a2f63]
text-white py-3 rounded-xl
font-medium shadow-md hover:shadow-lg transition">

Sign In

</button>

</form>


<div class="mt-8 pt-6 border-t text-center text-xs text-gray-400">
© {{ date('Y') }} WAKU System • BPS Sulawesi Utara
</div>


</div>

</div>

</div>

</div>



</x-guest-layout>
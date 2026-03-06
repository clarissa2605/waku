<x-guest-layout>

<div class="min-h-screen flex items-center justify-center relative overflow-hidden
bg-[#ece5dd]">

{{-- batik pattern seperti whatsapp --}}
<div class="absolute inset-0 opacity-40"
style="
background-image:url('{{ asset('images/batik-pattern.png') }}');
background-size:500px;
background-repeat:repeat;
"></div>


<div class="relative w-full max-w-md bg-white rounded-3xl shadow-2xl p-10">

<div class="flex justify-center mb-6">
<img src="{{ asset('images/waku-logo.png') }}" class="h-16">
</div>

<div class="text-center mb-8">
<h2 class="text-2xl font-semibold text-slate-800">
Sign in to WAKU
</h2>

<p class="text-slate-500 text-sm mt-2">
Access your dashboard securely
</p>
</div>

<form method="POST" action="{{ url('/login') }}">
@csrf

<div class="mb-5">
<label class="block text-sm text-slate-700 mb-2">Email</label>
<input type="email" name="email"
class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-600">
</div>

<div class="mb-5">
<label class="block text-sm text-slate-700 mb-2">Password</label>
<input type="password" name="password"
class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-blue-600">
</div>

<div class="mb-6 text-sm">
<label class="flex items-center">
<input type="checkbox" class="mr-2"> Remember me
</label>
</div>

<button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg">
Sign In
</button>

</form>

<div class="mt-8 text-center text-xs text-gray-400">
© {{ date('Y') }} WAKU System • BPS Kota Manado
</div>

</div>

</div>

</x-guest-layout>
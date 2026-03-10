<aside class="w-64 bg-[#01214d] text-white flex flex-col h-screen">

<!-- LOGO -->
<div class="px-6 py-6 border-b border-[#1e3a5f]">
    <div class="flex items-center gap-3">
        <img src="{{ asset('images/logo-waku.png') }}" class="h-10">
        <div>
            <p class="font-semibold text-lg">WAKU</p>
            <p class="text-xs text-blue-200">BPS Sulawesi Utara</p>
        </div>
    </div>
</div>

<!-- USER -->
<div class="px-6 py-6 border-b border-[#1e3a5f] flex items-center gap-3">

<div class="w-10 h-10 rounded-full bg-blue-900 flex items-center justify-center font-semibold">
{{ strtoupper(substr(Auth::user()->name,0,1)) }}
</div>

<div>
<p class="font-medium">{{ Auth::user()->name }}</p>
<p class="text-xs text-blue-200">Pimpinan</p>
</div>

</div>

<!-- MENU -->
<div class="flex-1 px-4 py-4 space-y-2">

<a href="{{ route('viewer.dashboard') }}"
class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-[#1b3b6f]">

<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5">
<path stroke-linecap="round" stroke-linejoin="round"
d="M3 9.75L12 4l9 5.75M4.5 10.5v7.5h5.25v-4.5h4.5V18h5.25v-7.5"/>
</svg>

Dashboard

</a>

</div>

<!-- LOGOUT -->
<div class="px-6 py-6 border-t border-[#1e3a5f]">

<form method="POST" action="{{ route('logout') }}">
@csrf

<button class="flex items-center gap-3 text-red-300 hover:text-red-400">

<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5">
<path stroke-linecap="round" stroke-linejoin="round"
d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-7.5A2.25 2.25 0 003.75 5.25v13.5A2.25 2.25 0 006 21h7.5A2.25 2.25 0 0015.75 18.75V15M18 12H9m0 0l3-3m-3 3l3 3"/>
</svg>

Logout

</button>

</form>

</div>

</aside>
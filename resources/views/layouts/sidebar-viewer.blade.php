<aside class="w-64 bg-[#01214d] border-r border-[#1e3a5f] fixed inset-y-0 left-0 flex flex-col overflow-y-auto overflow-x-hidden text-white no-scrollbar">

<!-- LOGO -->
<div class="px-6 py-6 border-b border-[#1e3a5f]">

    <div class="flex items-center gap-3">

        <img src="{{ asset('images/logo-app1.png') }}" class="h-12">

        <div>
            <h1 class="text-white text-xl font-semibold tracking-wide leading-none">
                WAKU
            </h1>

            <p class="text-xs text-blue-200 mt-1 tracking-wide opacity-80">
                BPS SULAWESI UTARA
            </p>
        </div>

    </div>

</div>


<!-- USER -->
<div class="px-6 py-6 border-b border-[#1e3a5f]">

<div class="flex items-center space-x-3">

<div class="w-10 h-10 rounded-full bg-[#0a2f63] flex items-center justify-center text-white font-semibold">
{{ strtoupper(substr(auth()->user()->name,0,1)) }}
</div>

<div>
<p class="text-sm font-medium">
{{ auth()->user()->name }}
</p>

<p class="text-xs text-blue-200">
Pimpinan
</p>
</div>

</div>

</div>


<!-- MENU -->
<nav class="flex-1 px-3 py-6 text-sm">

<div class="space-y-2">

<!-- Dashboard -->

<a href="{{ route('viewer.dashboard') }}"
class="flex items-center px-4 py-3 rounded-xl transition
{{ request()->routeIs('viewer.dashboard') ? 'bg-[#0a2f63] text-white font-medium' : 'hover:bg-[#0a2f63]/60 hover:translate-x-[2px] text-blue-100' }}">

<x-heroicon-o-home class="w-5 h-5 mr-3 shrink-0"/>

<span>Dashboard</span>

</a>


<!-- Profile -->

<a href="{{ route('viewer.profile') }}"
class="flex items-center px-4 py-3 rounded-xl transition
{{ request()->routeIs('viewer.profile') ? 'bg-[#0a2f63] text-white font-medium' : 'hover:bg-[#0a2f63]/60 hover:translate-x-[2px] text-blue-100' }}">

<x-heroicon-o-user-circle class="w-5 h-5 mr-3 shrink-0"/>

<span>Profil Saya</span>

</a>

</div>

</nav>


<!-- LOGOUT -->
<div class="mt-auto border-t border-[#1e3a5f] p-6">

<form method="POST" action="{{ route('logout') }}">
@csrf

<button class="flex items-center text-red-300 hover:text-red-400 transition">

<x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5 mr-3"/>

Logout

</button>
</form>

</div>

</aside>
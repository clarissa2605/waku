<aside class="w-72 bg-[#01214d] border-r border-[#1e3a5f] flex flex-col h-screen overflow-y-auto overflow-x-hidden text-white">

    <!-- Logo -->
    <div class="px-6 py-6 border-b border-[#1e3a5f]">
        <img src="{{ asset('images/logo-app.png') }}" class="h-10">
        <p class="text-xs text-blue-200 mt-2">
            Web Aktif Komunikasi Keuangan
        </p>
    </div>

    <!-- User Info -->
    <div class="px-6 py-6 border-b border-[#1e3a5f]">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-[#0a2f63] flex items-center justify-center text-white font-semibold">
                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            </div>
            <div>
                <p class="text-sm font-medium">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-blue-200 capitalize">
                    {{ auth()->user()->role }}
                </p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-3 py-6 text-sm">
    <div class="space-y-2 max-w-[240px] mx-auto">


        {{-- DASHBOARD --}}
        <a href="{{ route('admin.dashboard') }}"
        class="flex items-center mx-2 px-4 py-3 rounded-xl
        transition-all duration-200 ease-out
        {{ request()->routeIs('admin.dashboard')
        ? 'bg-[#0a2f63] text-white font-medium'
        : 'text-blue-100 hover:bg-[#0a2f63]/60' }}">

        <x-heroicon-o-home class="w-5 h-5 mr-3"/>
        Dashboard

        </a>
        {{-- DATA MANAGEMENT --}}
        <p class="text-xs uppercase tracking-wider text-blue-300 mt-6 px-2">
            Data Management
        </p>

        {{-- Pegawai --}}
        <div x-data="{ open: {{ request()->routeIs('pegawai.*') ? 'true' : 'false' }} }">

            <button @click="open = !open"
                class="w-full flex items-center justify-between gap-2 px-4 py-3 rounded-lg transition
                hover:bg-[#0a2f63] text-blue-100">

                <div class="flex items-center">
                    <x-heroicon-o-user class="w-5 h-5 mr-3" />
                    Pegawai
                </div>

                <x-heroicon-o-chevron-down
                class="w-4 h-4 text-blue-300 transition-transform"
                x-bind:class="open ? 'rotate-180' : ''" />

            </button>

            <div x-show="open" x-transition class="ml-10 mt-2 space-y-1">

                <a href="{{ route('pegawai.index') }}"
                   class="block py-2
                   {{ request()->routeIs('pegawai.index') ? 'text-white font-medium' : 'text-blue-200 hover:text-white' }}">
                    List Pegawai
                </a>

                <a href="{{ route('pegawai.create') }}"
                   class="block py-2
                   {{ request()->routeIs('pegawai.create') ? 'text-white font-medium' : 'text-blue-200 hover:text-white' }}">
                    Tambah Pegawai
                </a>

            </div>

        </div>

        {{-- Mitra --}}
        <div x-data="{ open: {{ request()->routeIs('mitra.*') ? 'true' : 'false' }} }">

            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition
                hover:bg-[#0a2f63] text-blue-100">

                <div class="flex items-center">
                    <x-heroicon-o-user-group class="w-5 h-5 mr-3" />
                    Mitra
                </div>

                <x-heroicon-o-chevron-down
                class="w-4 h-4 text-blue-300 transition-transform"
                x-bind:class="open ? 'rotate-180' : ''" />

            </button>

            <div x-show="open" x-transition class="ml-10 mt-2 space-y-1">

                <a href="{{ route('mitra.index') }}"
                   class="block py-2
                   {{ request()->routeIs('mitra.index') ? 'text-white font-medium' : 'text-blue-200 hover:text-white' }}">
                    List Mitra
                </a>

                <a href="{{ route('mitra.create') }}"
                   class="block py-2
                   {{ request()->routeIs('mitra.create') ? 'text-white font-medium' : 'text-blue-200 hover:text-white' }}">
                    Tambah Mitra
                </a>

            </div>

        </div>

        {{-- Kelompok Mitra --}}
        <a href="{{ route('kelompok.index') }}"
        class="flex items-center px-4 py-3 rounded-lg transition
        {{ request()->routeIs('kelompok.*') ? 'bg-[#0a2f63] text-white font-medium' : 'hover:bg-[#0a2f63] text-blue-100' }}">
            <x-heroicon-o-users class="w-5 h-5 mr-3" />
            Kelompok Mitra
        </a>

        {{-- TRANSACTION --}}
        <p class="text-xs uppercase tracking-wider text-blue-300 px-4 mt-6">
            Transaction
        </p>
        
        {{-- ================= Pencairan Individu ================= --}}
        <div x-data="{ open: {{ request()->routeIs('pencairan.create') || request()->routeIs('pencairan.mitra.create') ? 'true' : 'false' }} }">

            <button @click="open = !open"
            class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition
            hover:bg-[#0a2f63] text-blue-100">

            <div class="flex items-center">
            <x-heroicon-o-banknotes class="w-5 h-5 mr-3" />
            Pencairan Individu
            </div>

            <x-heroicon-o-chevron-down
            class="w-4 h-4 text-blue-300 transition-transform"
            x-bind:class="open ? 'rotate-180' : ''" />

            </button>

            <div x-show="open" x-transition class="ml-10 mt-2 space-y-1">

                <a href="{{ route('pencairan.create') }}"
                class="block py-2
                {{ request()->routeIs('pencairan.create') ? 'text-white font-medium' : 'text-blue-200 hover:text-white' }}">
                Pegawai
                </a>

                <a href="{{ route('pencairan.mitra.create') }}"
                class="block py-2
                {{ request()->routeIs('pencairan.mitra.create') ? 'text-white font-medium' : 'text-blue-200 hover:text-white' }}">
                    Mitra
                </a>

            </div>
        </div>

        {{-- ================= Pencairan Massal ================= --}}
        <div x-data="{ open: {{ request()->routeIs('pencairan.import.*') ? 'true' : 'false' }} }">

            <button @click="open = !open"
            class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition
            hover:bg-[#0a2f63] text-blue-100">

            <div class="flex items-center">
            <x-heroicon-o-document-arrow-up class="w-5 h-5 mr-3" />
            Pencairan Massal
            </div>

            <x-heroicon-o-chevron-down
            class="w-4 h-4 text-blue-300 transition-transform"
            x-bind:class="open ? 'rotate-180' : ''" />

            </button>

            <div x-show="open" x-transition class="ml-10 mt-2 space-y-1">

                <a href="{{ route('pencairan.import.form') }}"
                class="block py-2
                {{ request()->routeIs('pencairan.import.form') ? 'text-white font-medium' : 'text-blue-200 hover:text-white' }}">
                Import CSV
                </a>

            </div>
        </div>

    
        <a href="{{ route('pencairan.index') }}"
        class="flex items-center px-4 py-3 rounded-lg transition
        {{ request()->routeIs('pencairan.index') ? 'bg-[#0a2f63] text-white font-medium' : 'hover:bg-[#0a2f63] text-blue-100' }}">

            <x-heroicon-o-clock class="w-5 h-5 mr-3" />
            Riwayat Pencairan

        </a>

        {{-- COMMUNICATION --}}
        <p class="text-xs uppercase tracking-wider text-blue-300 px-4 mt-6">
            Communication
        </p>

        <a href="{{ route('log.notifikasi') }}"
        class="flex items-center px-4 py-3 rounded-lg transition
        {{ request()->routeIs('log.notifikasi') ? 'bg-[#0a2f63] text-white font-medium' : 'hover:bg-[#0a2f63] text-blue-100' }}">

        <x-heroicon-o-bell class="w-5 h-5 mr-3" />
        Log Notifikasi WA

        </a>

        <a href="{{ route('template.index') }}"
        class="flex items-center px-4 py-3 rounded-lg transition
        {{ request()->routeIs('template.*') ? 'bg-[#0a2f63] text-white font-medium' : 'hover:bg-[#0a2f63] text-blue-100' }}">

        <x-heroicon-o-chat-bubble-left-right class="w-5 h-5 mr-3" />
        Template Pesan WA

        </a>

        {{-- REPORTING --}}
        <p class="text-xs uppercase tracking-wider text-blue-300 px-4 mt-6">
            Reporting
        </p>

        <a href="{{ route('laporan.index') }}"
        class="flex items-center px-4 py-3 rounded-lg transition
        {{ request()->routeIs('laporan.*') ? 'bg-[#0a2f63] text-white font-medium' : 'hover:bg-[#0a2f63] text-blue-100' }}">

        <x-heroicon-o-chart-bar class="w-5 h-5 mr-3" />
        Laporan

        </a>

        {{-- SYSTEM --}}
        <p class="text-xs uppercase tracking-wider text-blue-300 px-4 mt-6">
            System
        </p>

        <a href="{{ route('log.aktivitas') }}"
        class="flex items-center px-4 py-3 rounded-lg transition
        {{ request()->routeIs('log.aktivitas') ? 'bg-[#0a2f63] text-white font-medium' : 'hover:bg-[#0a2f63] text-blue-100' }}">

        <x-heroicon-o-document-text class="w-5 h-5 mr-3" />
        Log Aktivitas

        </a>

        <a href="{{ route('profile.edit') }}"
           class="flex items-center px-4 py-3 rounded-lg transition
           {{ request()->routeIs('profile.edit') ? 'bg-[#0a2f63] text-white font-medium' : 'hover:bg-[#0a2f63] text-blue-100' }}">
            <x-heroicon-o-user-circle class="w-5 h-5 mr-3" />
            Profil Saya
        </a>

    </nav>

    <!-- Logout -->
    <div class="border-t border-[#1e3a5f] p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full text-left flex items-center text-red-300 hover:text-red-400">
                <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5 mr-2" />
                Logout
            </button>
        </form>
    </div>

</aside>
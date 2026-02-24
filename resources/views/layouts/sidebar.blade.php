<aside class="w-72 bg-white border-r border-slate-200 flex flex-col">

    <!-- Logo -->
    <div class="px-6 py-6 border-b border-slate-200">
        <img src="{{ asset('images/logo-waku.png') }}" class="h-10">
        <p class="text-xs text-slate-500 mt-2">
            Web Aktif Komunikasi Keuangan
        </p>
    </div>

    <!-- User Info -->
    <div class="px-6 py-6 border-b border-slate-200">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold">
                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            </div>
            <div>
                <p class="text-sm font-medium text-slate-800">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-slate-500 capitalize">
                    {{ auth()->user()->role }}
                </p>
            </div>
        </div>
    </div>

    <nav class="flex-1 px-4 py-6 text-sm space-y-2 overflow-y-auto">

        {{-- ================= DASHBOARD ================= --}}
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center px-4 py-3 rounded-lg transition
           {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600 font-medium' : 'hover:bg-blue-50 text-slate-600' }}">
            <x-heroicon-o-home class="w-5 h-5 mr-3" />
            Dashboard
        </a>

        {{-- ================= DATA MANAGEMENT ================= --}}
        <p class="text-xs uppercase tracking-wider text-slate-400 px-4 mt-6">
            Data Management
        </p>

        {{-- Pegawai --}}
        <div x-data="{ open: {{ request()->routeIs('pegawai.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-blue-50 text-slate-600 transition">

                <div class="flex items-center">
                    <x-heroicon-o-user class="w-5 h-5 mr-3" />
                    Pegawai
                </div>

                <x-heroicon-o-chevron-down
                    class="w-4 h-4 transition-transform"
                    x-bind:class="open ? 'rotate-180' : ''" />
            </button>

            <div x-show="open" x-transition class="ml-10 mt-2 space-y-1">
                <a href="{{ route('pegawai.index') }}"
                   class="block py-2 {{ request()->routeIs('pegawai.index') ? 'text-blue-600 font-medium' : 'text-slate-500 hover:text-blue-600' }}">
                    List Pegawai
                </a>

                <a href="{{ route('pegawai.create') }}"
                   class="block py-2 text-slate-500 hover:text-blue-600">
                    Tambah Pegawai
                </a>
            </div>
        </div>

        {{-- Mitra --}}
        <div x-data="{ open: {{ request()->routeIs('mitra.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-blue-50 text-slate-600 transition">

                <div class="flex items-center">
                    <x-heroicon-o-user-group class="w-5 h-5 mr-3" />
                    Mitra
                </div>

                <x-heroicon-o-chevron-down
                    class="w-4 h-4 transition-transform"
                    x-bind:class="open ? 'rotate-180' : ''" />
            </button>

            <div x-show="open" x-transition class="ml-10 mt-2 space-y-1">
                <a href="{{ route('mitra.index') }}"
                   class="block py-2 text-slate-500 hover:text-blue-600">
                    List Mitra
                </a>

                <a href="{{ route('mitra.create') }}"
                   class="block py-2 text-slate-500 hover:text-blue-600">
                    Tambah Mitra
                </a>
            </div>
        </div>

        {{-- Kelompok Mitra --}}
        <a href="{{ route('kelompok.index') }}"
           class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 text-slate-600 transition">
            <x-heroicon-o-users class="w-5 h-5 mr-3" />
            Kelompok Mitra
        </a>

        {{-- ================= TRANSACTION ================= --}}
        <p class="text-xs uppercase tracking-wider text-slate-400 px-4 mt-6">
            Transaction
        </p>

        {{-- ================= Pencairan Individu ================= --}}
        <div x-data="{ open: {{ request()->routeIs('pencairan.create') || request()->routeIs('pencairan.mitra.create') ? 'true' : 'false' }} }">

            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition
                hover:bg-blue-50 text-slate-600">

                <div class="flex items-center">
                    <x-heroicon-o-banknotes class="w-5 h-5 mr-3" />
                    Pencairan Individu
                </div>

                <x-heroicon-o-chevron-down
                    class="w-4 h-4 transition-transform"
                    x-bind:class="open ? 'rotate-180' : ''" />
            </button>

            <div x-show="open" x-transition class="ml-10 mt-2 space-y-1">

                <a href="{{ route('pencairan.create') }}"
                class="block py-2
                {{ request()->routeIs('pencairan.create') ? 'text-blue-600 font-medium' : 'text-slate-500 hover:text-blue-600' }}">
                    Pegawai
                </a>

                <a href="{{ route('pencairan.mitra.create') }}"
                class="block py-2
                {{ request()->routeIs('pencairan.mitra.create') ? 'text-blue-600 font-medium' : 'text-slate-500 hover:text-blue-600' }}">
                    Mitra
                </a>

            </div>
        </div>

        {{-- ================= Pencairan Massal ================= --}}
        <div x-data="{ open: {{ request()->routeIs('pencairan.import.*') ? 'true' : 'false' }} }">

            <button @click="open = !open"
                class="w-full flex items-center justify-between px-4 py-3 rounded-lg transition
                hover:bg-blue-50 text-slate-600">

                <div class="flex items-center">
                    <x-heroicon-o-document-arrow-up class="w-5 h-5 mr-3" />
                    Pencairan Massal
                </div>

                <x-heroicon-o-chevron-down
                    class="w-4 h-4 transition-transform"
                    x-bind:class="open ? 'rotate-180' : ''" />
            </button>

            <div x-show="open" x-transition class="ml-10 mt-2 space-y-1">

                <a href="{{ route('pencairan.import.form') }}"
                class="block py-2
                {{ request()->routeIs('pencairan.import.form') ? 'text-blue-600 font-medium' : 'text-slate-500 hover:text-blue-600' }}">
                    Import CSV
                </a>

            </div>
        </div>

        {{-- ================= Riwayat Pencairan (Standalone) ================= --}}
        <a href="{{ route('pencairan.index') }}"
        class="flex items-center px-4 py-3 rounded-lg transition
        {{ request()->routeIs('pencairan.index') ? 'bg-blue-50 text-blue-600 font-medium' : 'hover:bg-blue-50 text-slate-600' }}">

            <x-heroicon-o-clock class="w-5 h-5 mr-3" />
            Riwayat Pencairan

        </a>

        {{-- ================= COMMUNICATION ================= --}}
        <p class="text-xs uppercase tracking-wider text-slate-400 px-4 mt-6">
            Communication
        </p>

        <a href="#"
           class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 text-slate-600 transition">
            <x-heroicon-o-chat-bubble-left-right class="w-5 h-5 mr-3" />
            Log Notifikasi WA
        </a>

        <a href="#"
           class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 text-slate-600 transition">
            <x-heroicon-o-envelope class="w-5 h-5 mr-3" />
            Template Pesan
        </a>

        {{-- ================= REPORTING ================= --}}
        <p class="text-xs uppercase tracking-wider text-slate-400 px-4 mt-6">
            Reporting
        </p>

        <a href="#"
           class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 text-slate-600 transition">
            <x-heroicon-o-chart-bar class="w-5 h-5 mr-3" />
            Laporan
        </a>

        {{-- ================= SYSTEM ================= --}}
        <p class="text-xs uppercase tracking-wider text-slate-400 px-4 mt-6">
            System
        </p>

        <a href="#"
           class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 text-slate-600 transition">
            <x-heroicon-o-document-text class="w-5 h-5 mr-3" />
            Log Aktivitas
        </a>

        <a href="{{ route('profile.edit') }}"
           class="flex items-center px-4 py-3 rounded-lg hover:bg-blue-50 text-slate-600 transition">
            <x-heroicon-o-user-circle class="w-5 h-5 mr-3" />
            Profil Saya
        </a>

    </nav>

    <!-- Logout -->
    <div class="border-t border-slate-200 p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full text-left flex items-center text-red-500 hover:text-red-600">
                <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5 mr-2" />
                Logout
            </button>
        </form>
    </div>

</aside>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WAKU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-50 text-slate-800">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-72 bg-white border-r border-slate-200 shadow-sm flex flex-col">

        <!-- Logo -->
        <div class="px-6 py-6 border-b border-slate-200">
            <img src="{{ asset('images/logo-waku.png') }}" class="h-10">
            <p class="text-xs text-slate-500 mt-2">
                Web Aktif Komunikasi Keuangan
            </p>
        </div>

        <!-- User -->
        <div class="px-6 py-6 border-b border-slate-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold">
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                </div>
                <div>
                    <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500 capitalize">{{ auth()->user()->role }}</p>
                </div>
            </div>
        </div>

        <!-- Menu -->
        <nav class="flex-1 px-4 py-6 text-sm space-y-2">

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-4 py-3 rounded-lg transition
               {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600 font-medium' : 'hover:bg-slate-100 text-slate-600' }}">
               
               <x-heroicon-o-squares-2x2 class="w-5 h-5 mr-3" />
               Dashboard
            </a>

            <!-- Dropdown Pegawai -->
            <div x-data="{ open: false }">

                <button @click="open = !open"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-lg hover:bg-slate-100 text-slate-600 transition">
                    
                    <div class="flex items-center">
                        <x-heroicon-o-user class="w-5 h-5 mr-3" />
                        Pegawai
                    </div>

                    <x-heroicon-o-chevron-down class="w-4 h-4" />
                </button>

                <div x-show="open" x-transition class="ml-10 mt-2 space-y-1">

                    <a href="{{ route('pegawai.index') }}"
                       class="block py-2 text-slate-500 hover:text-blue-600">
                        List Pegawai
                    </a>

                    <a href="{{ route('pegawai.create') }}"
                       class="block py-2 text-slate-500 hover:text-blue-600">
                        Tambah Pegawai
                    </a>

                </div>
            </div>

            <!-- Mitra -->
            <a href="{{ route('mitra.index') }}"
               class="flex items-center px-4 py-3 rounded-lg hover:bg-slate-100 text-slate-600 transition">
               
               <x-heroicon-o-user-group class="w-5 h-5 mr-3" />
               Mitra
            </a>

            <!-- Pencairan -->
            <a href="{{ route('pencairan.index') }}"
               class="flex items-center px-4 py-3 rounded-lg hover:bg-slate-100 text-slate-600 transition">
               
               <x-heroicon-o-banknotes class="w-5 h-5 mr-3" />
               Pencairan Dana
            </a>

        </nav>

    </aside>

    <!-- MAIN -->
    <main class="flex-1 p-10">

        <!-- Topbar -->
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-2xl font-semibold text-slate-800">
                @yield('title')
            </h1>

            <div class="flex items-center space-x-4">
                <div class="bg-white px-4 py-2 rounded-lg border border-slate-200 text-sm text-slate-600">
                    {{ now()->format('d M Y') }}
                </div>
            </div>
        </div>

        @yield('content')

    </main>

</div>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WAKU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-700">

<div class="flex min-h-screen">

    <!-- SIDEBAR (SLEEK STYLE) -->
    <aside class="w-64 bg-white border-r border-gray-200">

        <!-- Logo -->
        <div class="px-6 py-6 border-b border-gray-100">
            <img src="{{ asset('images/logo-waku.png') }}" class="h-9 mb-2">
            <p class="text-xs text-gray-400 tracking-wide">
                Web Aktif Komunikasi Keuangan
            </p>
        </div>

        <nav class="px-4 py-6 text-sm space-y-1">

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
                🏠 <span class="ml-2">Dashboard</span>
            </a>

            <!-- Section -->
            <p class="mt-6 mb-2 text-xs text-gray-400 uppercase tracking-wider">
                Manajemen Data
            </p>

            <a href="{{ route('pegawai.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
               Pegawai
            </a>

            <a href="{{ route('mitra.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
               Mitra
            </a>

            <a href="{{ route('kelompok.show',1) }}"
               class="block px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
               Kelompok Mitra
            </a>

            <p class="mt-6 mb-2 text-xs text-gray-400 uppercase tracking-wider">
                Pencairan Dana
            </p>

            <a href="{{ route('pencairan.create') }}"
               class="block px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
               Input Individu
            </a>

            <a href="{{ route('pencairan.import.form') }}"
               class="block px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
               Import CSV
            </a>

            <a href="{{ route('pencairan.index') }}"
               class="block px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
               Riwayat Pencairan
            </a>

            <p class="mt-6 mb-2 text-xs text-gray-400 uppercase tracking-wider">
                Sistem
            </p>

            <a href="{{ route('profile.edit') }}"
               class="block px-4 py-2 rounded-lg hover:bg-blue-50 hover:text-blue-600 transition">
               Profile
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-2 rounded-lg hover:bg-red-50 hover:text-red-500 transition">
                    Logout
                </button>
            </form>

        </nav>
    </aside>

    <!-- CONTENT -->
    <main class="flex-1 p-10">

        <!-- Top bar -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-xl font-semibold text-gray-800">
                @yield('title')
            </h1>

            <div class="text-sm text-gray-400">
                Admin WAKU
            </div>
        </div>

        <!-- Page Content -->
        @yield('content')

    </main>

</div>

</body>
</html>
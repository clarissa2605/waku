<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WAKU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="text-slate-800 h-screen overflow-hidden">


<!-- Background Batik -->
<div style="
position: fixed;
inset: 0;
z-index: -1;
background-image: url('/images/batik-bg.png');
background-repeat: repeat;
background-size: 700px;
opacity: 20;
"></div>

<div class="flex h-screen">

{{-- SIDEBAR --}}
<aside class="w-64 bg-[#01214d] border-r border-[#1e3a5f] fixed inset-y-0 left-0 overflow-y-auto overflow-x-hidden text-white">

@auth

    @if(Auth::user()->role == 'admin')
        @include('layouts.sidebar-admin')

    @elseif(Auth::user()->role == 'pegawai')
        @include('layouts.sidebar-pegawai')

    @elseif(Auth::user()->role == 'viewer')
        @include('layouts.sidebar-viewer')

    @endif

@endauth

</aside>

    {{-- MAIN CONTENT --}}
    <main class="ml-64 flex-1 overflow-y-auto">

        <div class="p-10">

            {{-- Page Header --}}
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-semibold text-slate-800">
                    @yield('title')
                </h1>

                <div class="text-sm text-slate-500">
                    {{ now()->format('d M Y') }}
                </div>
            </div>

            {{-- Page Content --}}
            @yield('content')

        </div>

    </main>

</div>

{{-- Scripts dari halaman --}}
@yield('scripts')

</body>
</html>
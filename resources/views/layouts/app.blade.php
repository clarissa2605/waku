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

    {{-- SIDEBAR --}}
    @include('layouts.sidebar')

    {{-- MAIN CONTENT --}}
    <main class="flex-1 p-10">

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

    </main>

</div>

</body>
</html>
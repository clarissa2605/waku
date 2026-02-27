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

<div class="min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-64 bg-white border-r border-slate-200
                  fixed inset-y-0 left-0 overflow-y-auto">
        @include('layouts.sidebar')
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="ml-64 min-h-screen">

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

</body>
</html>
<x-guest-layout>

<div class="min-h-screen flex">

    {{-- LEFT PANEL (40%) --}}
    <div class="hidden lg:flex w-2/5 relative bg-gradient-to-br from-slate-900 via-blue-900 to-slate-800 text-white items-center justify-center p-16 overflow-hidden">

        {{-- Subtle official line pattern --}}
        <div class="absolute inset-0 opacity-5"
             style="background-image: repeating-linear-gradient(
                 135deg,
                 rgba(255,255,255,0.2) 0px,
                 rgba(255,255,255,0.2) 1px,
                 transparent 1px,
                 transparent 26px
             );">
        </div>

        <div class="relative z-10 max-w-md">

            {{-- Logo WAKU --}}
            <img src="{{ asset('images/waku-logo.png') }}" class="h-24 mb-10">

            <h1 class="text-3xl font-semibold leading-snug tracking-tight mb-6">
                Web Administrasi <br>
                Keuangan Unit
            </h1>

            <p class="text-blue-100 text-sm leading-relaxed mb-10">
                Sistem notifikasi dan riwayat pencairan dana pegawai berbasis web dan WhatsApp untuk mendukung pengelolaan keuangan yang transparan dan terintegrasi.
            </p>

            <div class="flex items-center space-x-3 opacity-90">
                <span class="text-xs uppercase tracking-wider">Supported by</span>
                <img src="{{ asset('images/bps-logo.png') }}" class="h-9">
            </div>

        </div>
    </div>


    {{-- RIGHT PANEL (60%) --}}
    <div class="w-full lg:w-3/5 flex items-center justify-center bg-slate-50 p-10">

        <div class="w-full max-w-xl bg-white p-12 rounded-xl border border-slate-200 shadow-md">

            <div class="mb-8">
                <h2 class="text-2xl font-semibold text-slate-800">
                    Sign in to WAKU
                </h2>
                <p class="text-slate-500 text-sm mt-2">
                    Access your dashboard securely
                </p>

                {{-- Security indicator --}}
                <div class="flex items-center text-xs text-slate-500 mt-3">
                    <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4M12 3l7 4v5c0 5-3.5 8-7 9-3.5-1-7-4-7-9V7l7-4z"/>
                    </svg>
                    Secure Internal System
                </div>
            </div>

            <form method="POST" action="{{ url('/login') }}">
                @csrf

                {{-- Email --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Email
                    </label>
                    <input type="email"
                        name="email"
                        required
                        autofocus
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                </div>

                {{-- Password --}}
                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Password
                    </label>
                    <input type="password"
                        name="password"
                        required
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:outline-none transition">
                </div>

                {{-- Remember --}}
                <div class="flex items-center justify-between mb-8">
                    <label class="flex items-center text-sm text-slate-600">
                        <input type="checkbox" name="remember" class="mr-2">
                        Remember me
                    </label>
                </div>

                {{-- Button --}}
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-medium">
                    Sign In
                </button>

            </form>

            <div class="mt-10 text-xs text-slate-400 border-t border-slate-200 pt-4">
                © {{ date('Y') }} WAKU System • BPS Kota Manado
            </div>

        </div>

    </div>

</div>

</x-guest-layout>
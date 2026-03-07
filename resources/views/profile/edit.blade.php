@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto">

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-slate-800">
            Profil Saya
        </h1>
        <p class="text-sm text-slate-500 mt-1">
            Informasi akun pengguna sistem WAKU.
        </p>
    </div>

    <!-- Success Notification -->
    @if(session('success'))
        <div class="mb-6 border border-green-200 bg-green-50 rounded-lg p-4">
            <p class="text-sm font-medium text-green-700">
                {{ session('success') }}
            </p>
        </div>
    @endif


    <!-- ============================= -->
    <!-- INFORMASI AKUN -->
    <!-- ============================= -->

    <div class="bg-white border border-slate-200 rounded-lg p-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Nama -->
            <div>
                <label class="block text-sm font-medium text-slate-800 mb-2">
                    Nama
                </label>

                <input type="text"
                       value="{{ auth()->user()->name }}"
                       readonly
                       class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 text-sm text-slate-700">
            </div>


            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-slate-800 mb-2">
                    Email
                </label>

                <input type="text"
                       value="{{ auth()->user()->email }}"
                       readonly
                       class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 text-sm text-slate-700">
            </div>


            <!-- Role -->
            <div>
                <label class="block text-sm font-medium text-slate-800 mb-2">
                    Role
                </label>

                <input type="text"
                       value="{{ auth()->user()->role }}"
                       readonly
                       class="w-full bg-slate-50 border border-slate-200 rounded-lg px-4 py-2 text-sm text-slate-700">
            </div>

        </div>

    </div>



    <!-- ============================= -->
    <!-- UBAH PASSWORD -->
    <!-- ============================= -->

    <div class="bg-white border border-slate-200 rounded-lg p-6 mt-6">

        <h3 class="text-lg font-semibold text-slate-800 mb-4">
            Ubah Password
        </h3>

        <form method="POST" action="{{ route('profile.password.update') }}">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Password Baru -->
<div>
    <label class="block text-sm font-medium text-slate-800 mb-2">
        Password Baru
    </label>

    <div class="relative">

        <input type="password"
               id="password"
               name="password"
               required
               class="w-full border border-slate-200 rounded-lg px-4 py-2 pr-10 text-sm
                      focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">

        <!-- Toggle Password -->
        <button type="button"
                id="togglePassword"
                class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600">
        </button>

    </div>

    <!-- Password Strength -->
    <div class="mt-2">
        <div class="w-full h-2 bg-slate-200 rounded">
            <div id="passwordStrengthBar"
                class="h-2 rounded bg-red-500"
                style="width:0%"></div>
        </div>

        <p id="passwordStrengthText"
           class="text-xs mt-1 text-slate-500">
            Password strength
        </p>
    </div>

    <p class="text-xs text-slate-500 mt-1">
        Minimal 8 karakter, termasuk huruf besar, huruf kecil, angka, dan simbol.
    </p>

    @error('password')
        <p class="text-sm text-red-500 mt-1">
            {{ $message }}
        </p>
    @enderror
</div>


                <!-- Konfirmasi Password -->
                <div>
                    <label class="block text-sm font-medium text-slate-800 mb-2">
                        Konfirmasi Password
                    </label>

                    <input type="password"
                     id="confirmPassword"
                    name="password_confirmation"
                    required
                    class="w-full border border-slate-200 rounded-lg px-4 py-2 text-sm
              focus:ring-2 focus:ring-blue-600 focus:border-blue-600 outline-none">

<p id="passwordMatchText"
   class="text-xs mt-1 text-slate-500">
</p>
                </div>

            </div>


            <!-- Button -->
            <div class="border-t border-slate-200 pt-6 mt-6 flex justify-end">

                <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm font-medium
                               rounded-lg hover:bg-blue-700 transition">
                    Update Password
                </button>

            </div>

        </form>

    </div>

</div>

@endsection

@section('scripts')
@section('scripts')

<script>

document.addEventListener("DOMContentLoaded", function(){

const passwordInput = document.getElementById('password');
const confirmInput = document.getElementById('confirmPassword');
const bar = document.getElementById('passwordStrengthBar');
const text = document.getElementById('passwordStrengthText');
const matchText = document.getElementById('passwordMatchText');
const toggle = document.getElementById('togglePassword');


/* =========================
PASSWORD STRENGTH
========================= */

passwordInput.addEventListener('input', function(){

    const password = this.value;
    let strength = 0;

    if(password.length >= 8) strength++;
    if(/[A-Z]/.test(password)) strength++;
    if(/[0-9]/.test(password)) strength++;
    if(/[^A-Za-z0-9]/.test(password)) strength++;

    if(strength === 0){
        bar.style.width = "0%";
        text.innerText = "";
    }

    if(strength === 1){
        bar.style.width = "25%";
        bar.className = "h-2 rounded bg-red-500";
        text.innerText = "Weak password";
    }

    if(strength === 2){
        bar.style.width = "50%";
        bar.className = "h-2 rounded bg-orange-500";
        text.innerText = "Medium password";
    }

    if(strength === 3){
        bar.style.width = "75%";
        bar.className = "h-2 rounded bg-yellow-500";
        text.innerText = "Strong password";
    }

    if(strength === 4){
        bar.style.width = "100%";
        bar.className = "h-2 rounded bg-green-500";
        text.innerText = "Very strong password";
    }

});


/* =========================
SHOW / HIDE PASSWORD
========================= */

toggle.addEventListener('click', function(){

    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);

});


/* =========================
PASSWORD MATCH CHECK
========================= */

confirmInput.addEventListener('input', function(){

    if(confirmInput.value === ""){
        matchText.innerText = "";
        return;
    }

    if(confirmInput.value === passwordInput.value){

        matchText.innerText = "Password cocok";
        matchText.className = "text-xs mt-1 text-green-600";

    }else{

        matchText.innerText = "Password tidak sama";
        matchText.className = "text-xs mt-1 text-red-500";

    }

});

});

</script>

@endsection
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ================= ADMIN =================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return 'Dashboard Admin';
    });
});

// ================= PEGAWAI =================
Route::middleware(['auth', 'role:pegawai'])->group(function () {
    Route::get('/pegawai/dashboard', function () {
        return 'Dashboard Pegawai';
    });
});

// ================= VIEWER / MITRA =================
Route::middleware(['auth', 'role:viewer'])->group(function () {
    Route::get('/viewer/dashboard', function () {
        return 'Dashboard Viewer';
    });
});

require __DIR__.'/auth.php';

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// ================= FORCE LOGOUT (DEV ONLY) =================
Route::get('/force-logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
});

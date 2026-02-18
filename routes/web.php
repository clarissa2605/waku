<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PencairanDanaController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */
        Route::get('/dashboard', function () {
            return 'Dashboard Admin';
        });

        /*
        |--------------------------------------------------------------------------
        | CRUD PEGAWAI
        |--------------------------------------------------------------------------
        */
        Route::resource('pegawai', PegawaiController::class);

        // Akun login pegawai
        Route::get('pegawai/{id}/user', [PegawaiController::class, 'createUser'])
            ->name('pegawai.user.create');

        Route::post('pegawai/{id}/user', [PegawaiController::class, 'storeUser'])
            ->name('pegawai.user.store');

        /*
        |--------------------------------------------------------------------------
        | PENCAIRAN DANA
        |--------------------------------------------------------------------------
        */

        // List pencairan
        Route::get('pencairan', [PencairanDanaController::class, 'index'])
            ->name('pencairan.index');

        // Form input individu
        Route::get('pencairan/create', [PencairanDanaController::class, 'create'])
            ->name('pencairan.create');

        // Simpan pencairan individu
        Route::post('pencairan', [PencairanDanaController::class, 'store'])
            ->name('pencairan.store');

        /*
        |--------------------------------------------------------------------------
        | IMPORT CSV PENCAIRAN
        |--------------------------------------------------------------------------
        */

        // Form import
        Route::get('pencairan/import', [PencairanDanaController::class, 'importForm'])
            ->name('pencairan.import.form');

        // Preview CSV
        Route::post('pencairan/import/preview', [PencairanDanaController::class, 'importPreview'])
            ->name('pencairan.import.preview');

        // Konfirmasi & simpan hasil import
        Route::post('pencairan/import/confirm', [PencairanDanaController::class, 'importConfirm'])
            ->name('pencairan.import.confirm');
        
        // Preview CSV (POST)
        Route::post('pencairan/import/preview', [PencairanDanaController::class, 'importPreview'])
            ->name('pencairan.import.preview');

        // Preview CSV (GET) → redirect agar tidak error 405
        Route::get('pencairan/import/preview', function () {
            return redirect()->route('pencairan.import.form');
        });
        // Konfirmasi & simpan hasil import (GET) → redirect agar tidak error 405
        Route::get('pencairan/import/confirm', function () {
            return redirect()->route('pencairan.import.form');
        });

        Route::get('pencairan/{id}/preview-wa',[PencairanDanaController::class, 'previewPesanWA'])->name('pencairan.preview.wa');

        Route::get('admin/pencairan/{id}/kirim-wa', [PencairanDanaController::class, 'kirimWA'])->name('pencairan.kirim_wa');

        Route::get('admin/pencairan/{id}/preview-wa',[PencairanDanaController::class, 'previewPesanWA'])->name('pencairan.preview_wa');

        Route::get('/admin/pencairan/template', [\App\Http\Controllers\PencairanDanaController::class, 'downloadTemplate'])->name('pencairan.template');

    });



/*
|--------------------------------------------------------------------------
| PEGAWAI
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pegawai'])->group(function () {
    Route::get('/pegawai/dashboard', function () {
        return 'Dashboard Pegawai';
    });
});

/*
|--------------------------------------------------------------------------
| VIEWER / MITRA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:viewer'])->group(function () {
    Route::get('/viewer/dashboard', function () {
        return 'Dashboard Viewer';
    });
});

/*
|--------------------------------------------------------------------------
| AUTH (Laravel Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| DEV UTILITIES
|--------------------------------------------------------------------------
*/
Route::get('/force-logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
});

Route::get('/whoami', function () {
    return Auth::check() ? Auth::user() : 'NOT LOGGED IN';
});

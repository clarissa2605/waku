<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PencairanDanaController;
use App\Http\Controllers\KelompokMitraController;

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
    return view('dashboard');
})->name('admin.dashboard');

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

        /*
|--------------------------------------------------------------------------
| KELOMPOK MITRA
|--------------------------------------------------------------------------
*/


Route::get('kelompok/{id}', [KelompokMitraController::class, 'show'])
    ->name('kelompok.show');

Route::post('kelompok/{id}/add-mitra', [KelompokMitraController::class, 'addMitra'])
    ->name('kelompok.addMitra');

Route::delete('kelompok/{kelompokId}/remove/{mitraId}', [KelompokMitraController::class, 'removeMitra'])
    ->name('kelompok.removeMitra');

Route::resource('mitra', \App\Http\Controllers\MitraController::class);
    });



/*
|--------------------------------------------------------------------------
| PEGAWAI
|--------------------------------------------------------------------------
*/
Route::get('/pegawai/dashboard', [PencairanDanaController::class, 'dashboardPegawai'])
    ->name('pegawai.dashboard');


/*
|--------------------------------------------------------------------------
| VIEWER / MITRA
|--------------------------------------------------------------------------
*/
Route::prefix('viewer')
    ->middleware(['auth', 'role:viewer'])
    ->group(function () {

        Route::get('/dashboard',
            [PencairanDanaController::class, 'dashboardViewer']
        )->name('viewer.dashboard');

        

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

Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
});
Route::get('/whoami', function () {
    return Auth::check() ? Auth::user() : 'NOT LOGGED IN';
});
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    \Illuminate\Support\Facades\Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');
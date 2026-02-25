<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PencairanDanaController;
use App\Http\Controllers\KelompokMitraController;
use App\Http\Controllers\PencairanDanaMitraController;
use App\Http\Controllers\MitraController;

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

        Route::patch('pegawai/{id}/toggle', [PegawaiController::class, 'toggleStatus'])
            ->name('pegawai.toggle');

        Route::get('pegawai/{id}/user', [PegawaiController::class, 'createUser'])
            ->name('pegawai.user.create');

        Route::post('pegawai/{id}/user', [PegawaiController::class, 'storeUser'])
            ->name('pegawai.user.store');

        /*
        |--------------------------------------------------------------------------
        | PENCAIRAN DANA
        |--------------------------------------------------------------------------
        */

        Route::get('pencairan', [PencairanDanaController::class, 'index'])
            ->name('pencairan.index');

        Route::get('pencairan/create', [PencairanDanaController::class, 'create'])
            ->name('pencairan.create');

        Route::post('pencairan', [PencairanDanaController::class, 'store'])
            ->name('pencairan.store');

        /*
        |--------------------------------------------------------------------------
        | IMPORT CSV
        |--------------------------------------------------------------------------
        */

        Route::get('pencairan/import', [PencairanDanaController::class, 'importForm'])
            ->name('pencairan.import.form');

        Route::post('pencairan/import/preview', [PencairanDanaController::class, 'importPreview'])
            ->name('pencairan.import.preview');

        Route::post('pencairan/import/confirm', [PencairanDanaController::class, 'importConfirm'])
            ->name('pencairan.import.confirm');

        Route::get('pencairan/{id}/preview-wa', [PencairanDanaController::class, 'previewPesanWA'])
            ->name('pencairan.preview_wa');

        Route::get('pencairan/{id}/kirim-wa', [PencairanDanaController::class, 'kirimWA'])
            ->name('pencairan.kirim_wa');

        Route::get('pencairan/template', [PencairanDanaController::class, 'downloadTemplate'])
            ->name('pencairan.template');

        /*
        |--------------------------------------------------------------------------
        | PENCAIRAN MITRA
        |--------------------------------------------------------------------------
        */

        Route::get('pencairan-mitra', [PencairanDanaMitraController::class, 'index'])
            ->name('pencairan.mitra.index');

        Route::get('pencairan-mitra/create', [PencairanDanaMitraController::class, 'create'])
            ->name('pencairan.mitra.create');

        Route::post('pencairan-mitra', [PencairanDanaMitraController::class, 'store'])
            ->name('pencairan.mitra.store');

        /*
        |--------------------------------------------------------------------------
        | KELOMPOK MITRA
        |--------------------------------------------------------------------------
        */

        Route::get('kelompok', [KelompokMitraController::class, 'index'])
            ->name('kelompok.index');

        Route::get('kelompok/create', [KelompokMitraController::class, 'create'])
            ->name('kelompok.create');

        Route::post('kelompok', [KelompokMitraController::class, 'store'])
            ->name('kelompok.store');

        Route::get('kelompok/{id}', [KelompokMitraController::class, 'show'])
            ->name('kelompok.show');

        Route::get('kelompok/{id}/edit', [KelompokMitraController::class, 'edit'])
            ->name('kelompok.edit');

        Route::put('kelompok/{id}', [KelompokMitraController::class, 'update'])
            ->name('kelompok.update');

        Route::delete('kelompok/{id}', [KelompokMitraController::class, 'destroy'])
            ->name('kelompok.destroy');

        Route::post('kelompok/{id}/add-mitra', [KelompokMitraController::class, 'addMitra'])
            ->name('kelompok.addMitra');

        Route::delete('kelompok/{kelompokId}/remove/{mitraId}', [KelompokMitraController::class, 'removeMitra'])
            ->name('kelompok.removeMitra');

        /*
        |--------------------------------------------------------------------------
        | MITRA CRUD
        |--------------------------------------------------------------------------
        */
        Route::resource('mitra', MitraController::class);
    });

         Route::patch('/admin/mitra/{id}/toggle-status',  [MitraController::class, 'toggleStatus']
         )->name('mitra.toggle-status');

/*
|--------------------------------------------------------------------------
| API UTIL
|--------------------------------------------------------------------------
*/

Route::get('/admin/mitra/{id}/kelompok', function ($id) {
    $mitra = \App\Models\Mitra::with('kelompok')->findOrFail($id);
    return response()->json($mitra->kelompok);
});

/*
|--------------------------------------------------------------------------
| PEGAWAI DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/pegawai/dashboard', [PencairanDanaController::class, 'dashboardPegawai'])
    ->name('pegawai.dashboard');

/*
|--------------------------------------------------------------------------
| VIEWER AREA
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
| AUTH
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| DEV UTIL
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
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
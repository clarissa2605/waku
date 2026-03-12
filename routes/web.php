<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PencairanDanaController;
use App\Http\Controllers\KelompokMitraController;
use App\Http\Controllers\PencairanDanaMitraController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\ViewerController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
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
        Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('admin.dashboard');

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
        
        Route::post('pencairan/bulk-send', [PencairanDanaController::class, 'bulkSend'])
            ->name('pencairan.bulk_send');

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

        Route::patch('/admin/mitra/{id}/toggle-status',  [MitraController::class, 'toggleStatus']
         )->name('mitra.toggle-status');

        /*
        |--------------------------------------------------------------------------
        | LOG NOTIFIKASI WA
        |--------------------------------------------------------------------------
        */
        Route::get('log-notifikasi',
            [\App\Http\Controllers\LogNotifikasiController::class, 'index']
        )->name('log.notifikasi');

        /*
        |--------------------------------------------------------------------------
        | LOG AKTIVITAS SISTEM
        |--------------------------------------------------------------------------
        */
        Route::get('log-aktivitas',
            [LogAktivitasController::class, 'index']
        )->name('log.aktivitas');

        /*
        |--------------------------------------------------------------------------
        | Template Pesan WA
        |--------------------------------------------------------------------------
        */
        Route::get('template-pesan', function () { return view('admin.admin_template.index');
        })->name('template.index');

        /*
        |--------------------------------------------------------------------------
        | MEECHAT API MONITORING
        |--------------------------------------------------------------------------
        */
        Route::get('meechat/saldo',
            [\App\Http\Controllers\MeechatController::class, 'saldo']
        )->name('meechat.saldo');

        /*
        |--------------------------------------------------------------------------
        | LAPORAN
        |--------------------------------------------------------------------------
        */

        Route::get('/laporan', [LaporanController::class,'index'])
            ->name('laporan.index');

        Route::get('/laporan/export/pdf',[LaporanController::class,'exportPdf'])
            ->name('laporan.export.pdf');

        Route::patch('pegawai/reset-password/{user}', [PegawaiController::class, 'resetPassword'])
            ->name('pegawai.reset.password');
        
        Route::get('pegawai/{id}/detail', [PegawaiController::class, 'detailPegawai'])
            ->name('pegawai.detail');

});
    

         

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
Route::middleware(['auth'])->group(function () {

    Route::get('/pegawai/dashboard', [PegawaiController::class, 'dashboard'])
        ->name('pegawai.dashboard');

    Route::get('/pegawai/profile', [PegawaiController::class, 'profile'])
        ->name('pegawai.profile');

    Route::get('/pegawai/pencairan/{id}', [PegawaiController::class, 'detail'])
        ->name('pegawai.pencairan.detail');
    

});


/*
|--------------------------------------------------------------------------
| VIEWER AREA
|--------------------------------------------------------------------------
*/

Route::prefix('viewer')
    ->middleware(['auth','role:viewer'])
    ->group(function () {

        Route::get('/dashboard', [ViewerController::class, 'dashboard'])
            ->name('viewer.dashboard');

        Route::get('/profile', [ViewerController::class, 'profile'])
            ->name('viewer.profile');

        Route::post('/profile/password', [ViewerController::class, 'updatePassword'])
            ->name('viewer.password');

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

    Route::post('/profile/update-password', function (Request $request) {

    $request->validate([
        'password' => [
            'required',
            'min:8',
            'regex:/[A-Z]/',
            'regex:/[0-9]/',
            'confirmed'
        ]
    ],[
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 8 karakter.',
        'password.regex' => 'Password harus mengandung huruf besar dan angka.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.'
    ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');

    })->name('profile.password.update');

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
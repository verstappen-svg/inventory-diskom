<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\SDMController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\JaringanController;
use App\Http\Controllers\DataCenterController;
use App\Http\Controllers\SplpController;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\SoftwareMasterController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\NotificationController;


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get(
    '/login',
    [AuthController::class, 'showLogin']
)->name('login');

Route::post(
    '/login',
    [AuthController::class, 'login']
)->name('login.process');

Route::post(
    '/logout',
    [AuthController::class, 'logout']
)->name('logout');


/*
|--------------------------------------------------------------------------
| HALAMAN YANG MEMBUTUHKAN LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | NOTIFIKASI
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/notifikasi',
        [NotificationController::class, 'index']
    )->name('notifikasi.index');


    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:verifikator')->group(function () {

        Route::get(
            '/verifikasi',
            [VerificationController::class, 'index']
        )->name('verifikasi.index');

        Route::post(
            '/verifikasi/{verificationRequest}/approve',
            [VerificationController::class, 'approve']
        )->name('verifikasi.approve');

        Route::post(
            '/verifikasi/{verificationRequest}/reject',
            [VerificationController::class, 'reject']
        )->name('verifikasi.reject');
    });


    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN — MANAJEMEN PENGGUNA
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'pengguna',
        UserController::class
    )->except(['show']);

    Route::post(
        '/pengguna/{pengguna}/aktifkan',
        [UserController::class, 'activate']
    )->name('pengguna.activate');

    Route::post(
        '/pengguna/{pengguna}/nonaktifkan',
        [UserController::class, 'deactivate']
    )->name('pengguna.deactivate');


    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN — HAK AKSES
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/hak-akses/{role}',
        [PermissionController::class, 'show']
    )->name('hak-akses.show');

    Route::post(
        '/hak-akses/{role}',
        [PermissionController::class, 'update']
    )->name('hak-akses.update');


    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN — LOG AKTIVITAS
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/log-aktivitas',
        [LogAktivitasController::class, 'index']
    )->name('log-aktivitas.index');


    /*
    |--------------------------------------------------------------------------
    | HARDWARE
    |--------------------------------------------------------------------------
    */

    Route::middleware(
        'menu.permission:hardware'
    )->group(function () {

        Route::get(
            '/hardware',
            [HardwareController::class, 'index']
        )->name('hardware.index');

        Route::post(
            '/hardware',
            [HardwareController::class, 'store']
        )->name('hardware.store');

        Route::put(
            '/hardware/{hardware}',
            [HardwareController::class, 'update']
        )->name('hardware.update');

        Route::delete(
            '/hardware/{hardware}',
            [HardwareController::class, 'destroy']
        )->name('hardware.destroy');

        Route::post(
            '/hardware/import',
            [HardwareController::class, 'import']
        )->name('hardware.import');
    });


/*
|--------------------------------------------------------------------------
| SOFTWARE
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| DATA MASTER SOFTWARE
|--------------------------------------------------------------------------
|
| Route Data Master diletakkan SEBELUM resource software.
| Jangan dipindahkan ke bawah Route::resource('software', ...),
| supaya /software/master tidak dianggap sebagai {software}.
|
*/

Route::get('/software/master', [
    SoftwareMasterController::class,
    'index'
])->name('software.master.index');

Route::post('/software/master', [
    SoftwareMasterController::class,
    'store'
])->name('software.master.store');

Route::put('/software/master/{type}/{id}', [
    SoftwareMasterController::class,
    'update'
])->name('software.master.update');

Route::patch('/software/master/{type}/{id}/toggle', [
    SoftwareMasterController::class,
    'toggle'
])->name('software.master.toggle');

Route::delete('/software/master/{type}/{id}', [
    SoftwareMasterController::class,
    'destroy'
])->name('software.master.destroy');


/*
|--------------------------------------------------------------------------
| SOFTWARE
|--------------------------------------------------------------------------
*/

Route::resource(
    'software',
    SoftwareController::class
)->except(['show'])
  ->middleware('menu.permission:software');

Route::post('/software/import', [
    SoftwareController::class,
    'import'
])->name('software.import');


/*
|--------------------------------------------------------------------------
| INFRASTRUKTUR — JARINGAN
|--------------------------------------------------------------------------
*/

Route::resource(
    'infrastruktur/jaringan',
    JaringanController::class
)->names([
    'index'   => 'jaringan.index',
    'create'  => 'jaringan.create',
    'store'   => 'jaringan.store',
    'show'    => 'jaringan.show',
    'edit'    => 'jaringan.edit',
    'update'  => 'jaringan.update',
    'destroy' => 'jaringan.destroy',
])->except(['show'])
  ->middleware('menu.permission:infrastruktur.jaringan');


/*
|--------------------------------------------------------------------------
| INFRASTRUKTUR — DATA CENTER
|--------------------------------------------------------------------------
*/

Route::resource(
    'infrastruktur/data-center',
    DataCenterController::class
)->names([
    'index'   => 'data-center.index',
    'create'  => 'data-center.create',
    'store'    => 'data-center.store',
    'show'    => 'data-center.show',
    'edit'    => 'data-center.edit',
    'update'  => 'data-center.update',
    'destroy' => 'data-center.destroy',
])->except(['show'])
  ->middleware('menu.permission:infrastruktur.data-center');


/*
|--------------------------------------------------------------------------
| DOWNLOAD TEMPLATE EXCEL — DATA CENTER
|--------------------------------------------------------------------------
*/

Route::get(
    '/infrastruktur/data-center/template',
    [DataCenterController::class, 'downloadTemplate']
)->name('data-center.template')
 ->middleware('menu.permission:infrastruktur.data-center');


/*
|--------------------------------------------------------------------------
| IMPORT EXCEL — DATA CENTER
|--------------------------------------------------------------------------
*/

Route::post(
    '/infrastruktur/data-center/import',
    [DataCenterController::class, 'import']
)->name('data-center.import')
 ->middleware('menu.permission:infrastruktur.data-center');


/*
|--------------------------------------------------------------------------
| INFRASTRUKTUR — SPLP
|--------------------------------------------------------------------------
*/

Route::resource(
    'infrastruktur/splp',
    SplpController::class
)->names([
    'index'   => 'splp.index',
    'create'  => 'splp.create',
    'store'   => 'splp.store',
    'show'    => 'splp.show',
    'edit'    => 'splp.edit',
    'update'  => 'splp.update',
    'destroy' => 'splp.destroy',
])->except(['show'])
  ->middleware('menu.permission:infrastruktur.splp');

    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    Route::middleware(
        'menu.permission:data'
    )->group(function () {

        Route::get(
            '/data',
            [DataController::class, 'index']
        )->name('data.index');

        Route::post(
            '/data',
            [DataController::class, 'store']
        )->name('data.store');

        Route::get(
            '/data/{id}/preview',
            [DataController::class, 'preview']
        )->name('data.preview');

        Route::get(
            '/data/{id}/edit',
            [DataController::class, 'edit']
        )->name('data.edit');

        Route::put(
            '/data/{id}',
            [DataController::class, 'update']
        )->name('data.update');

        Route::delete(
            '/data/{id}',
            [DataController::class, 'destroy']
        )->name('data.destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | SDM
    |--------------------------------------------------------------------------
    */

    Route::middleware(
        'menu.permission:sdm'
    )->group(function () {

        Route::get(
            '/sdm',
            [SDMController::class, 'index']
        )->name('sdm.index');

        Route::post(
            '/sdm',
            [SDMController::class, 'store']
        )->name('sdm.store');

        Route::put(
            '/sdm/{sdm}',
            [SDMController::class, 'update']
        )->name('sdm.update');

        Route::delete(
            '/sdm/{sdm}',
            [SDMController::class, 'destroy']
        )->name('sdm.destroy');

        Route::post(
            '/sdm/{sdm}/approve',
            [SDMController::class, 'approve']
        )->name('sdm.approve');

        Route::post(
            '/sdm/{sdm}/reject',
            [SDMController::class, 'reject']
        )->name('sdm.reject');
    });


    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */

    Route::middleware('menu.permission:laporan')->group(function () {

        Route::get(
            '/laporan',
            function () {
                return view('laporan.index');
            }
        )->name('laporan.index');
    });

});
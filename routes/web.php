<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\VerifikasiHardwareController;
use App\Http\Controllers\SDMController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\JaringanController;
use App\Http\Controllers\DataCenterController;
use App\Http\Controllers\SplpController;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\DataController;

use App\Models\ActivityLog;


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


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

    Route::get('/dashboard', function () {

        $role = auth()->user()->role;

        return match ($role) {

            'super_admin' => view('dashboard.super-admin', [
                'totalUser'        => \App\Models\User::count(),
                'totalOperator'    => \App\Models\User::where('role', 'operator')->count(),
                'totalVerifikator' => \App\Models\User::where('role', 'verifikator')->count(),
                'totalPimpinan'    => \App\Models\User::where('role', 'pimpinan')->count(),

                'activities' => ActivityLog::latest()
                    ->take(5)
                    ->get()
                    ->map(function ($log) {

                        $meta = match ($log->action) {
                            'create' => [
                                'icon' => 'plus-lg',
                                'type' => 'add'
                            ],

                            'update' => [
                                'icon' => 'pencil',
                                'type' => 'role'
                            ],

                            'delete' => [
                                'icon' => 'trash',
                                'type' => 'reject'
                            ],

                            'login' => [
                                'icon' => 'box-arrow-in-right',
                                'type' => 'login'
                            ],

                            default => [
                                'icon' => 'info-circle',
                                'type' => 'add'
                            ],
                        };

                        return [
                            'icon' => $meta['icon'],
                            'type' => $meta['type'],
                            'text' => $log->description,
                            'by'   => $log->user_name,
                            'time' => $log->created_at->diffForHumans(),
                        ];
                    })
                    ->toArray(),
            ]),

            'operator' => view('dashboard.operator'),

            'verifikator' => view('dashboard.verifikator'),

            'pimpinan' => view('dashboard.pimpinan'),

            default => abort(403, 'Role pengguna tidak valid.'),
        };

    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN — MANAJEMEN PENGGUNA
    |--------------------------------------------------------------------------
    */

    Route::resource('pengguna', UserController::class)
        ->except(['show']);

    Route::post('/pengguna/{pengguna}/aktifkan', [UserController::class, 'activate'])
        ->name('pengguna.activate');

    Route::post('/pengguna/{pengguna}/nonaktifkan', [UserController::class, 'deactivate'])
        ->name('pengguna.deactivate');


    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN — HAK AKSES
    |--------------------------------------------------------------------------
    */

    Route::get('/hak-akses/{role}', [PermissionController::class, 'show'])
        ->name('hak-akses.show');

    Route::post('/hak-akses/{role}', [PermissionController::class, 'update'])
        ->name('hak-akses.update');


    /*
    |--------------------------------------------------------------------------
    | SUPER ADMIN — LOG AKTIVITAS
    |--------------------------------------------------------------------------
    */

    Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])
        ->name('log-aktivitas.index');


    /*
    |--------------------------------------------------------------------------
    | HARDWARE
    |--------------------------------------------------------------------------
    */

    Route::middleware('menu.permission:hardware')->group(function () {

        Route::get('/hardware', [HardwareController::class, 'index'])
            ->name('hardware.index');

        Route::post('/hardware', [HardwareController::class, 'store'])
            ->name('hardware.store');

        Route::put('/hardware/{hardware}', [HardwareController::class, 'update'])
            ->name('hardware.update');

        Route::delete('/hardware/{hardware}', [HardwareController::class, 'destroy'])
            ->name('hardware.destroy');

        Route::patch(
            '/hardware/{hardware}/verifikasi',
            [VerifikasiHardwareController::class, 'update']
        )->name('hardware.verifikasi.update');

    });


    /*
    |--------------------------------------------------------------------------
    | SOFTWARE
    |--------------------------------------------------------------------------
    */

    Route::resource('software', SoftwareController::class)
        ->except(['show'])
        ->middleware('menu.permission:software');


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
    ])
    ->except(['show'])
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
        'store'   => 'data-center.store',
        'show'    => 'data-center.show',
        'edit'    => 'data-center.edit',
        'update'  => 'data-center.update',
        'destroy' => 'data-center.destroy',
    ])
    ->except(['show'])
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
    ])
    ->except(['show'])
    ->middleware('menu.permission:infrastruktur.splp');


    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    Route::middleware('menu.permission:data')->group(function () {

        Route::get('/data', [DataController::class, 'index'])
            ->name('data.index');

        Route::post('/data', [DataController::class, 'store'])
            ->name('data.store');

        Route::get('/data/{id}/preview', [DataController::class, 'preview'])
            ->name('data.preview');

        Route::get('/data/{id}/edit', [DataController::class, 'edit'])
            ->name('data.edit');

        Route::put('/data/{id}', [DataController::class, 'update'])
            ->name('data.update');

        Route::delete('/data/{id}', [DataController::class, 'destroy'])
            ->name('data.destroy');

    });


    /*
    |--------------------------------------------------------------------------
    | SDM
    |--------------------------------------------------------------------------
    */

    Route::middleware('menu.permission:sdm')->group(function () {

        Route::get('/sdm', [SDMController::class, 'index'])
            ->name('sdm.index');

        Route::post('/sdm', [SDMController::class, 'store'])
            ->name('sdm.store');

        Route::put('/sdm/{sdm}', [SDMController::class, 'update'])
            ->name('sdm.update');

        Route::delete('/sdm/{sdm}', [SDMController::class, 'destroy'])
            ->name('sdm.destroy');

        Route::post('/sdm/{sdm}/approve', [SDMController::class, 'approve'])
            ->name('sdm.approve');

        Route::post('/sdm/{sdm}/reject', [SDMController::class, 'reject'])
            ->name('sdm.reject');

    });


    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */

    Route::middleware('menu.permission:laporan')->group(function () {

        Route::get('/laporan', function () {
            return view('laporan.index');
        })->name('laporan.index');

    });

});
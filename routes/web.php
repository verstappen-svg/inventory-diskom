<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SDMController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\DataController;

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

            'super_admin' => view('dashboard.super-admin'),

            'operator' => view('dashboard.operator'),

            'verifikator' => view('dashboard.verifikator'),

            'pimpinan' => view('dashboard.pimpinan'),

            default => abort(403, 'Role pengguna tidak valid.'),

        };

    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | HARDWARE
    |--------------------------------------------------------------------------
    */

    Route::get('/hardware', [HardwareController::class, 'index'])
        ->name('hardware.index');

    Route::post('/hardware', [HardwareController::class, 'store'])
        ->name('hardware.store');

    Route::put('/hardware/{hardware}', [HardwareController::class, 'update'])
        ->name('hardware.update');

    Route::delete('/hardware/{hardware}', [HardwareController::class, 'destroy'])
        ->name('hardware.destroy');


    /*
    |--------------------------------------------------------------------------
    | SOFTWARE
    |--------------------------------------------------------------------------
    */

    Route::resource('software', SoftwareController::class)
        ->except(['show']);


    /*
    |--------------------------------------------------------------------------
    | INFRASTRUKTUR
    |--------------------------------------------------------------------------
    */

    Route::get('/infrastruktur/jaringan', function () {
        return view('infrastruktur.jaringan');
    });

    Route::get('/infrastruktur/data-center', function () {
        return view('infrastruktur.data-center');
    });

    Route::get('/infrastruktur/splp', function () {
        return view('infrastruktur.splp');
    });


    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    Route::get('/data', [DataController::class, 'index'])
        ->name('data.index');

    Route::post('/data', [DataController::class, 'store'])
        ->name('data.store');

    // Preview file
    Route::get('/data/{id}/preview', [DataController::class, 'preview'])
        ->name('data.preview');

    // Edit data
    Route::get('/data/{id}/edit', [DataController::class, 'edit'])
        ->name('data.edit');

    // Update data
    Route::put('/data/{id}', [DataController::class, 'update'])
        ->name('data.update');

    // Pengajuan hapus data
    Route::delete('/data/{id}', [DataController::class, 'destroy'])
        ->name('data.destroy');


    /*
    |--------------------------------------------------------------------------
    | SDM
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */

    Route::get('/laporan', function () {
        return view('laporan.index');
    });

});
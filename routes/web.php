<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\VerifikasiHardwareController;


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

// Halaman login
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

// Proses login
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

// Logout
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
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Hardware
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
    | Verifikasi Hardware
    |--------------------------------------------------------------------------
    */

    Route::patch(
        '/hardware/{hardware}/verifikasi',
        [VerifikasiHardwareController::class, 'update']
    )->name('hardware.verifikasi.update');


    /*
    |--------------------------------------------------------------------------
    | Software
    |--------------------------------------------------------------------------
    */

    Route::get('/software', function () {
        return view('software.index');
    });


    /*
    |--------------------------------------------------------------------------
    | Infrastruktur
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
    | Data
    |--------------------------------------------------------------------------
    */

    Route::get('/data', function () {
        return view('data.index');
    });


    /*
    |--------------------------------------------------------------------------
    | SDM
    |--------------------------------------------------------------------------
    */

    Route::get('/sdm', function () {
        return view('sdm.index');
    });


    /*
    |--------------------------------------------------------------------------
    | Laporan
    |--------------------------------------------------------------------------
    */

    Route::get('/laporan', function () {
        return view('laporan.index');
    });

});
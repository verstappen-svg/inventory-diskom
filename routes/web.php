<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SDMController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\JaringanController;
use App\Http\Controllers\SplpController;
use App\Http\Controllers\DataCenterController;
use App\Http\Controllers\LaporanController;


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

// Jaringan
Route::get('/infrastruktur/jaringan', [JaringanController::class, 'index'])
    ->name('jaringan.index');

Route::post('/infrastruktur/jaringan', [JaringanController::class, 'store'])
    ->name('jaringan.store');

Route::put('/infrastruktur/jaringan/{id}', [JaringanController::class, 'update'])
    ->name('jaringan.update');

Route::delete('/infrastruktur/jaringan/{id}', [JaringanController::class, 'destroy'])
    ->name('jaringan.destroy');


// Data Center
Route::get('/infrastruktur/data-center', [DataCenterController::class, 'index'])
    ->name('data-center.index');

Route::post('/infrastruktur/data-center', [DataCenterController::class, 'store'])
    ->name('data-center.store');

Route::put('/infrastruktur/data-center/{id}', [DataCenterController::class, 'update'])
    ->name('data-center.update');

Route::delete('/infrastruktur/data-center/{id}', [DataCenterController::class, 'destroy'])
    ->name('data-center.destroy');


// SPLP
Route::get('/infrastruktur/splp', [SplpController::class, 'index'])
    ->name('splp.index');

Route::post('/infrastruktur/splp', [SplpController::class, 'store'])
    ->name('splp.store');

Route::put('/infrastruktur/splp/{id}', [SplpController::class, 'update'])
    ->name('splp.update');

Route::delete('/infrastruktur/splp/{id}', [SplpController::class, 'destroy'])
    ->name('splp.destroy');

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

    Route::get('/laporan', [LaporanController::class, 'index'])
    ->name('laporan.index');


    });


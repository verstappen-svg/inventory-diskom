<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;

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

    // =====================================================
    // DASHBOARD
    // =====================================================

    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');


    // =====================================================
    // HARDWARE
    // =====================================================

    Route::get('/hardware', function () {
        return view('hardware.index');
    });


    // =====================================================
    // SOFTWARE
    // =====================================================

    Route::get('/software', function () {
        return view('software.index');
    });


    // =====================================================
    // INFRASTRUKTUR
    // =====================================================

    Route::get('/infrastruktur/jaringan', function () {
        return view('infrastruktur.jaringan');
    });

    Route::get('/infrastruktur/data-center', function () {
        return view('infrastruktur.data-center');
    });

    Route::get('/infrastruktur/splp', function () {
        return view('infrastruktur.splp');
    });


    // =====================================================
    // DATA
    // =====================================================

    Route::get('/data', [DataController::class, 'index'])
        ->name('data.index');

    Route::post('/data', [DataController::class, 'store'])
        ->name('data.store');

    // Preview file
    Route::get('/data/{id}/preview', [DataController::class, 'preview'])
        ->name('data.preview');

    Route::get('/data/{id}/edit', [DataController::class, 'edit'])
        ->name('data.edit');

    Route::put('/data/{id}', [DataController::class, 'update'])
        ->name('data.update');

    Route::delete('/data/{id}', [DataController::class, 'destroy'])
        ->name('data.destroy');


    // =====================================================
    // SDM
    // =====================================================

    Route::get('/sdm', function () {
        return view('sdm.index');
    });


    // =====================================================
    // LAPORAN
    // =====================================================

    Route::get('/laporan', function () {
        return view('laporan.index');
    });

});
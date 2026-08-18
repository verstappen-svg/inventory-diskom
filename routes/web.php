<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');


    // Hardware
    Route::get('/hardware', function () {
        return view('hardware.index');
    });


    // Software
    Route::get('/software', function () {
        return view('software.index');
    });


    // Infrastruktur
    Route::get('/infrastruktur/jaringan', function () {
        return view('infrastruktur.jaringan');
    });

    Route::get('/infrastruktur/data-center', function () {
        return view('infrastruktur.data-center');
    });

    Route::get('/infrastruktur/splp', function () {
        return view('infrastruktur.splp');
    });


    // Data
    Route::get('/data', function () {
        return view('data.index');
    });


    // SDM
    Route::get('/sdm', function () {
        return view('sdm.index');
    });


    // Laporan
    Route::get('/laporan', function () {
        return view('laporan.index');
    });

});
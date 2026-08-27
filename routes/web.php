<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SoftwareController;


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

    Route::get('/hardware', function () {
        return view('hardware.index');
    });


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
    | LAPORAN
    |--------------------------------------------------------------------------
    */

    Route::get('/laporan', function () {
        return view('laporan.index');
    });

});
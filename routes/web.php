<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JaringanController;
use App\Http\Controllers\DataCenterController;
use App\Http\Controllers\SplpController;


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
        return view('dashboard.index');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | HARDWARE
    |--------------------------------------------------------------------------
    */

    Route::get('/hardware', function () {
        return view('hardware.index');
    })->name('hardware.index');


    /*
    |--------------------------------------------------------------------------
    | SOFTWARE
    |--------------------------------------------------------------------------
    */

    Route::get('/software', function () {
        return view('software.index');
    })->name('software.index');


    /*
    |--------------------------------------------------------------------------
    | INFRASTRUKTUR
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | JARINGAN - CRUD
    |--------------------------------------------------------------------------
    |
    | GET     /infrastruktur/jaringan
    | POST    /infrastruktur/jaringan
    | GET     /infrastruktur/jaringan/{jaringan}/edit
    | PUT     /infrastruktur/jaringan/{jaringan}
    | DELETE  /infrastruktur/jaringan/{jaringan}
    |
    */

    Route::resource(
        'infrastruktur/jaringan', JaringanController::class)
    ->names([
        'index'   => 'jaringan.index',
        'create'  => 'jaringan.create',
        'store'   => 'jaringan.store',
        'show'    => 'jaringan.show',
        'edit'    => 'jaringan.edit',
        'update'  => 'jaringan.update',
        'destroy' => 'jaringan.destroy',
    ])
    ->except(['show']);


    /*
    |--------------------------------------------------------------------------
    | DATA CENTER - CRUD
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
    ])->except(['show']);


    /*
    |--------------------------------------------------------------------------
    | SPLP - CRUD
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
    ])->except(['show']);


    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    Route::get('/data', function () {
        return view('data.index');
    })->name('data.index');


    /*
    |--------------------------------------------------------------------------
    | SDM
    |--------------------------------------------------------------------------
    */

    Route::get('/sdm', function () {
        return view('sdm.index');
    })->name('sdm.index');


    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */

    Route::get('/laporan', function () {
        return view('laporan.index');
    })->name('laporan.index');

});
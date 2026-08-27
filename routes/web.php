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
            'operator'    => view('dashboard.operator'),
            'verifikator' => view('dashboard.verifikator'),
            'pimpinan'    => view('dashboard.pimpinan'),
            default       => abort(403, 'Role pengguna tidak valid.'),
        };
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | HARDWARE
    |--------------------------------------------------------------------------
    */
    Route::get('/hardware', [HardwareController::class, 'index'])->name('hardware.index');
    Route::post('/hardware', [HardwareController::class, 'store'])->name('hardware.store');
    Route::put('/hardware/{hardware}', [HardwareController::class, 'update'])->name('hardware.update');
    Route::delete('/hardware/{hardware}', [HardwareController::class, 'destroy'])->name('hardware.destroy');


    /*
    |-----------------------------------------------------------------
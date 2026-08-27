<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SDMController;
use App\Http\Controllers\AuthController;
<<<<<<< HEAD
use App\Http\Controllers\HardwareController;
=======
use App\Http\Controllers\SoftwareController;
>>>>>>> c312f5b16b5e652a59efe8b8a431ce069767414e


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| HALAMAN YANG MEMBUTUHKAN LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

<<<<<<< HEAD
    // Dashboard
Route::get('/dashboard', function () {
    return view('dashboard.index');
})->name('dashboard');

    // Hardware
    Route::get('/hardware', [HardwareController::class, 'index'])->name('hardware.index');
    Route::post('/hardware', [HardwareController::class, 'store'])->name('hardware.store');
    Route::put('/hardware/{hardware}', [HardwareController::class, 'update'])->name('hardware.update');
    Route::delete('/hardware/{hardware}', [HardwareController::class, 'destroy'])->name('hardware.destroy');
=======
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

>>>>>>> c312f5b16b5e652a59efe8b8a431ce069767414e

    /*
    |--------------------------------------------------------------------------
    | SOFTWARE
    |--------------------------------------------------------------------------
    */

    Route::resource('software', SoftwareController::class)
        ->except(['show']);

<<<<<<< HEAD
    // Infrastruktur
=======

    /*
    |--------------------------------------------------------------------------
    | INFRASTRUKTUR
    |--------------------------------------------------------------------------
    */

>>>>>>> c312f5b16b5e652a59efe8b8a431ce069767414e
    Route::get('/infrastruktur/jaringan', function () {
        return view('infrastruktur.jaringan');
    });
    Route::get('/infrastruktur/data-center', function () {
        return view('infrastruktur.data-center');
    });
    Route::get('/infrastruktur/splp', function () {
        return view('infrastruktur.splp');
    });

<<<<<<< HEAD
    // Data
=======

    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

>>>>>>> c312f5b16b5e652a59efe8b8a431ce069767414e
    Route::get('/data', function () {
        return view('data.index');
    });

<<<<<<< HEAD
    // SDM
    Route::get('/sdm', [SDMController::class, 'index'])->name('sdm.index');
    Route::post('/sdm', [SDMController::class, 'store'])->name('sdm.store');
    Route::put('/sdm/{sdm}', [SDMController::class, 'update'])->name('sdm.update');
    Route::delete('/sdm/{sdm}', [SDMController::class, 'destroy'])->name('sdm.destroy');
    Route::post('/sdm/{sdm}/approve', [SDMController::class, 'approve'])->name('sdm.approve');
    Route::post('/sdm/{sdm}/reject', [SDMController::class, 'reject'])->name('sdm.reject');
=======

    /*
    |--------------------------------------------------------------------------
    | SDM
    |--------------------------------------------------------------------------
    */

    Route::get('/sdm', function () {
        return view('sdm.index');
    });

>>>>>>> c312f5b16b5e652a59efe8b8a431ce069767414e

    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */

    Route::get('/laporan', function () {
        return view('laporan.index');
    });

});
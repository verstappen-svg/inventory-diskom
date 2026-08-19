<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SDMController;

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');
Route::get('/sdm', [SDMController::class, 'index'])->name('sdm.index');
Route::post('/sdm', [SDMController::class, 'store'])->name('sdm.store');
Route::put('/sdm/{sdm}', [SDMController::class, 'update'])->name('sdm.update');
Route::delete('/sdm/{sdm}', [SDMController::class, 'destroy'])->name('sdm.destroy');
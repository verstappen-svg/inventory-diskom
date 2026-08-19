<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HardwareController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hardware', [HardwareController::class, 'index'])
    ->name('hardware.index');
<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/login', function () {
        return view('login');
    })->name('login');

    Route::get('/dashboard', function () {
        return view('welcome');
    })->name('welcome');

    Route::get('/data', function () {
        return view('data.index');
    })->name('data');

});


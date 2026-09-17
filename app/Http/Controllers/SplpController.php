<?php

namespace App\Http\Controllers;

class SplpController extends Controller
{
    /**
     * Menampilkan halaman informasi SPLP.
     */
    public function index()
    {
        return view('infrastruktur.splp.index');
    }
}
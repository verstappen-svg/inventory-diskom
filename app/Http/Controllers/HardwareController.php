<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HardwareController extends Controller
{
    public function index()
    {
        return view('hardware.index');
    }
}
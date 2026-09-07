<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class LogAktivitasController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::orderBy('created_at', 'desc')->paginate(15);

        return view('dashboard.log-aktivitas', compact('logs'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 10);

        // Batasi pilihan agar tidak sembarang angka
        if (!in_array($perPage, [10, 30, 50, 100])) {
            $perPage = 10;
        }

        $query = ActivityLog::query();

        // Search aktivitas, user, dan role
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('user_name', 'like', "%{$search}%")
                    ->orWhere('role', 'like', "%{$search}%");
            });
        }

        // Filter role
        if ($role = $request->get('role')) {
            $query->where('role', $role);
        }

        $logs = $query
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view('super-admin.log-aktivitas', compact(
            'logs',
            'perPage'
        ));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\RolePermission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private function ensureSuperAdmin()
    {
        if (auth()->user()->role !== 'super_admin') {
            abort(403, 'Hanya Super Admin yang boleh mengakses halaman ini.');
        }
    }

    public function show($role)
    {
        $this->ensureSuperAdmin();

        $permissions = RolePermission::where('role', $role)
            ->orderBy('sort')
            ->get();

        return response()->json($permissions);
    }

    public function update(Request $request, $role)
    {
        $this->ensureSuperAdmin();

        $items = $request->validate([
            'items' => ['required', 'array'],
            'items.*.menu_key' => ['required', 'string'],
            'items.*.can_view' => ['boolean'],
            'items.*.can_add' => ['boolean'],
            'items.*.can_delete' => ['boolean'],
            'items.*.extra_action_checked' => ['boolean'],
        ])['items'];

        foreach ($items as $item) {
            RolePermission::where('role', $role)
                ->where('menu_key', $item['menu_key'])
                ->update([
                    'can_view' => $item['can_view'] ?? false,
                    'can_add' => $item['can_add'] ?? false,
                    'can_delete' => $item['can_delete'] ?? false,
                    'extra_action_checked' => $item['extra_action_checked'] ?? false,
                ]);
        }

        ActivityLog::record(
            'Mengubah hak akses untuk role "' . ucfirst(str_replace('_', ' ', $role)) . '"',
            'update',
            'Hak Akses'
        );

        return response()->json(['message' => 'Hak akses berhasil disimpan.']);
    }
}
<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use App\Models\RolePermission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMenuPermission
{
    public function handle(Request $request, Closure $next, string $menuKey): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(403);
        }

        $ability = match ($request->method()) {
            'POST', 'PUT', 'PATCH' => 'can_add',
            'DELETE' => 'can_delete',
            default => 'can_view',
        };

        if (!RolePermission::allows($user->role, $menuKey, $ability)) {

            if ($request->isMethod('GET')) {
                abort(403, 'Anda tidak memiliki hak akses untuk mengakses halaman ini.');
            }

            return back()->with('permission_denied', 'Anda tidak memiliki hak akses untuk melakukan aksi ini.');
        }

        $response = $next($request);

        if (!$request->isMethod('GET') && $user->role !== 'super_admin') {

            $actionLabel = match ($request->method()) {
                'POST' => 'menambahkan data baru',
                'PUT', 'PATCH' => 'mengubah data',
                'DELETE' => 'menghapus data',
                default => 'melakukan aksi',
            };

            $menuLabel = ucwords(str_replace(['-', '.'], [' ', ' - '], $menuKey));

            ActivityLog::record(
                'User "' . $user->name . '" ' . $actionLabel . ' pada menu ' . $menuLabel,
                match ($request->method()) {
                    'POST' => 'create',
                    'PUT', 'PATCH' => 'update',
                    'DELETE' => 'delete',
                    default => 'update',
                },
                $menuLabel
            );
        }

        return $response;
    }
}
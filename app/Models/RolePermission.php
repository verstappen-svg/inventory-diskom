<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $fillable = [
        'role',
        'menu_key',
        'menu_label',
        'can_view',
        'can_add',
        'can_delete',
        'supports_add',
        'supports_delete',
        'extra_action_label',
        'extra_action_checked',
        'sort',
    ];

    protected function casts(): array
    {
        return [
            'can_view' => 'boolean',
            'can_add' => 'boolean',
            'can_delete' => 'boolean',
            'supports_add' => 'boolean',
            'supports_delete' => 'boolean',
            'extra_action_checked' => 'boolean',
        ];
    }

    public static function allows(string $role, string $menuKey, string $ability = 'can_view'): bool
    {
        static $cache = [];

        if ($role === 'super_admin') {
            return true;
        }

        $cacheKey = $role . '|' . $menuKey;

        if (!array_key_exists($cacheKey, $cache)) {
            $cache[$cacheKey] = self::where('role', $role)
                ->where('menu_key', $menuKey)
                ->first();
        }

        $permission = $cache[$cacheKey];

        if (!$permission) {
            return false;
        }

        return (bool) $permission->{$ability};
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'role',
        'action',
        'menu_label',
        'description',
    ];

    public static function record(string $description, ?string $action = null, ?string $menuLabel = null): void
    {
        $user = auth()->user();

        self::create([
            'user_id' => $user?->id,
            'user_name' => $user?->name ?? 'System',
            'role' => $user?->role ?? 'system',
            'action' => $action,
            'menu_label' => $menuLabel,
            'description' => $description,
        ]);
    }
}
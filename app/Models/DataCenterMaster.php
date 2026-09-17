<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataCenterMaster extends Model
{
    protected $table = 'data_center_masters';

    protected $fillable = [
        'jenis',
        'nama',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
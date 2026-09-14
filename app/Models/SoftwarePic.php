<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwarePic extends Model
{
    use HasFactory;

    protected $table = 'software_pics';

    protected $fillable = [
        'nama',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}
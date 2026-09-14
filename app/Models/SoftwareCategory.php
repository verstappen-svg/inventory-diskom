<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareCategory extends Model
{
    use HasFactory;

    protected $table = 'software_categories';

    protected $fillable = [
        'nama',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}
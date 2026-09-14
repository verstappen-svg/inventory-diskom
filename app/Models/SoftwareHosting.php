<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareHosting extends Model
{
    use HasFactory;

    protected $table = 'software_hostings';

    protected $fillable = [
        'nama',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}
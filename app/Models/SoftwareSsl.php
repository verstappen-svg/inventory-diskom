<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareSsl extends Model
{
    use HasFactory;

    protected $table = 'software_ssls';

    protected $fillable = [
        'nama_ssl',
        'tanggal_expire',
        'status',
    ];

    protected $casts = [
        'tanggal_expire' => 'date',
        'status' => 'string',
    ];
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareCounter extends Model
{
    use HasFactory;

    protected $table = 'software_counters';

    protected $fillable = [
        'year',
        'last_number',
    ];

    protected $casts = [
        'year' => 'integer',
        'last_number' => 'integer',
    ];
}
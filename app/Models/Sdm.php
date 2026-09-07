<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sdm extends Model
{
    use HasFactory;

    protected $table = 'sdms'; // pastikan sama dengan nama tabel migration

    protected $fillable = [
        'nip',
        'kode_dk',
        'nama',
        'jabatan',
        'kompetensi',
        'masa_berlaku',
        'dokumen',
    ];
}
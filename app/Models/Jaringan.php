<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jaringan extends Model
{
    protected $table = 'jaringans';

    /*
    |--------------------------------------------------------------------------
    | PRIMARY KEY
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';


    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'id',
        'jenis_data',
        'lokasi',
        'jarak_kabel',
        'jumlah_core',
        'jumlah_titik',
        'verifikasi',
        'komentar',
    ];


    /*
    |--------------------------------------------------------------------------
    | CAST
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'jarak_kabel' => 'decimal:2',
        'jumlah_core' => 'integer',
        'jumlah_titik' => 'integer',
    ];
}
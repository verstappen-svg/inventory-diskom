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
        'nama_infrastruktur',
        'spesifikasi',
        'pengadaan',
        'harga',
        'tanggal_pengadaan',
        'tanggal_berakhir',
        'status',
        'verifikasi',
        'komentar',
    ];


    /*
    |--------------------------------------------------------------------------
    | CAST
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'tanggal_pengadaan' => 'date',
        'tanggal_berakhir' => 'date',
        'harga' => 'decimal:2',
    ];
}
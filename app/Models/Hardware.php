<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\VerificationRequest;
use App\Models\Lokasi;

class Hardware extends Model
{
    protected $table = 'hardware';

    /*
    |--------------------------------------------------------------------------
    | Primary Key
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'asset_id';

    public $incrementing = false;

    protected $keyType = 'string';

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'asset_id',
        'nama_barang',
        'spesifikasi',
        'jenis_barang',
        'lokasi_id',
        'sistem_operasi',
        'tahun_pembelian',
        'harga',
        'kondisi',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'tahun_pembelian' => 'integer',
        'harga' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Route Model Binding
    |--------------------------------------------------------------------------
    |
    | Laravel akan menggunakan asset_id ketika route:
    | /hardware/{hardware}
    |
    */

    public function getRouteKeyName()
    {
        return 'asset_id';
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi Lokasi
    |--------------------------------------------------------------------------
    */

    public function lokasi()
    {
        return $this->belongsTo(
            Lokasi::class,
            'lokasi_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Verification Request
    |--------------------------------------------------------------------------
    */

    public function latestVerificationRequest()
    {
        return $this->hasOne(
            VerificationRequest::class,
            'record_id',
            'asset_id'
        )
        ->where('module', 'hardware')
        ->latestOfMany();
    }
}
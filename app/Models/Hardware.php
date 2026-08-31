<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Hardware extends Model
{
    protected $table = 'hardware';

    protected $fillable = [
        'asset_id',
        'nama_barang',
        'spesifikasi',
        'jenis_barang',
        'tahun_pembelian',
        'harga',
        'kondisi',
    ];

    public function verifikasi()
    {
        return $this->hasOne(VerifikasiHardware::class, 'hardware_id');
    }
}
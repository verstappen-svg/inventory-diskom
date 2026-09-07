<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SoftwareAsset extends Model
{
    use HasFactory;

    protected $table = 'software_assets';

    protected $fillable = [
        'kode',
        'jenis',
        'spesifikasi',
        'jumlah_lisensi',
        'pengadaan',
        'periode_sewa',
        'harga',
        'tanggal_pengadaan',
        'tanggal_berakhir',
    ];

    protected $casts = [
        'tanggal_pengadaan' => 'date',
        'tanggal_berakhir' => 'date',
        'harga' => 'decimal:2',
    ];
}
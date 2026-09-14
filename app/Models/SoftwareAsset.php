<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareAsset extends Model
{
    use HasFactory;

    protected $table = 'software_assets';

    protected $fillable = [
        'kode',
        'nama_aset',
        'jenis',
        'spesifikasi',

        // Master Data
        'kategori_id',
        'ssl_id',
        'hosting_id',
        'pic_id',

        // Kolom lama — sementara tetap dipertahankan
        'kategori',
        'ssl',
        'hosting',
        'pic',

        'url_homepage',
        'ip_public',
        'ip_private',
        'status',

        'kerahasiaan',
        'integritas',
        'ketersediaan',
        'nilai',
        'keterangan',
        'deskripsi_aplikasi',

        'jumlah_lisensi',
        'pengadaan',
        'periode_sewa',
        'harga',
        'tanggal_pengadaan',
        'tanggal_berakhir',

        'verifikasi',
        'komentar',
    ];

    protected $casts = [
        'kategori_id' => 'integer',
        'ssl_id' => 'integer',
        'hosting_id' => 'integer',
        'pic_id' => 'integer',

        'jumlah_lisensi' => 'integer',

        'kerahasiaan' => 'integer',
        'integritas' => 'integer',
        'ketersediaan' => 'integer',

        'nilai' => 'decimal:2',
        'harga' => 'decimal:2',

        'tanggal_pengadaan' => 'date',
        'tanggal_berakhir' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI DATA MASTER
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(
            SoftwareCategory::class,
            'kategori_id'
        );
    }

    public function sslMaster()
    {
        return $this->belongsTo(
            SoftwareSsl::class,
            'ssl_id'
        );
    }

    public function hostingMaster()
    {
        return $this->belongsTo(
            SoftwareHosting::class,
            'hosting_id'
        );
    }

    public function picMaster()
    {
        return $this->belongsTo(
            SoftwarePic::class,
            'pic_id'
        );
    }
}
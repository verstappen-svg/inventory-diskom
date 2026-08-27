<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $table = 'data';

    protected $fillable = [
        'nama_dataset',
        'jenis_data',
        'tahun',
        'file_data',
        'verifikasi',
        'tanggal_pengajuan',
        'komentar_verifikasi',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
    ];
}
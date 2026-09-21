<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    protected $table = 'data';

    protected $fillable = [
        'nama_dataset',
        'topik',
        'tahun',
        'deskripsi',
        'metadata',
        'file_data',
        'verifikasi',
        'tanggal_pengajuan',
        'komentar_verifikasi',
    ];

    protected $casts = [
        'metadata' => 'array',
        'tanggal_pengajuan' => 'datetime',
    ];

    /**
     * Relasi ke seluruh baris dataset.
     *
     * Satu dataset dapat memiliki banyak baris
     * pada tabel dataset_rows.
     */
    public function datasetRows()
    {
        return $this->hasMany(
            DatasetRow::class,
            'data_id'
        );
    }
}
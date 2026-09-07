<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Data;

class DataPengajuan extends Model
{
    protected $table = 'data_pengajuans';

    protected $fillable = [
        'data_id',
        'user_id',
        'aksi',
        'data_lama',
        'data_baru',
        'status',
        'komentar',
        'tanggal_pengajuan',
    ];

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
        'tanggal_pengajuan' => 'datetime',
    ];

    /**
     * Pengajuan berkaitan dengan data
     */
    public function data()
    {
        return $this->belongsTo(Data::class);
    }

    /**
     * Pengajuan dibuat oleh user/operator
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\VerificationRequest;

class Sdm extends Model
{
    protected $table = 'sdms';

    protected $fillable = [
        'jenis_pegawai',
        'nip',
        'nama',
        'jabatan',
        'kompetensi',
        'masa_berlaku',
        'dokumen',
    ];

    protected $casts = [
        'masa_berlaku' => 'date',
    ];

    public function verificationRequests()
    {
        return $this->hasMany(
            VerificationRequest::class,
            'record_id',
            'id'
        )->where(
            'module',
            'sdm'
        );
    }
}
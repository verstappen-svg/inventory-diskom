<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerifikasiHardware extends Model
{
    protected $table = 'verifikasi_hardware';

    protected $fillable = [
        'hardware_id',
        'status',
        'catatan',
        'verified_by',
        'verified_at',
    ];

    public function hardware()
    {
        return $this->belongsTo(Hardware::class, 'hardware_id');
    }
}
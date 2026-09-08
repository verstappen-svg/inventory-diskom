<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationRequest extends Model
{
    use HasFactory;

    protected $table = 'verification_requests';

    protected $fillable = [
        'module',
        'record_id',
        'action',
        'data',
        'status',
        'submitted_by',
        'verified_by',
        'verified_at',
        'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'verified_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | User yang mengajukan
    |--------------------------------------------------------------------------
    */
    public function submitter()
    {
        return $this->belongsTo(
            User::class,
            'submitted_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | User yang melakukan verifikasi
    |--------------------------------------------------------------------------
    */
    public function verifier()
    {
        return $this->belongsTo(
            User::class,
            'verified_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Status helper
    |--------------------------------------------------------------------------
    */
    public function isPending(): bool
    {
        return $this->status === 'menunggu';
    }

    public function isApproved(): bool
    {
        return $this->status === 'disetujui';
    }

    public function isRejected(): bool
    {
        return $this->status === 'ditolak';
    }

    /*
    |--------------------------------------------------------------------------
    | Label module
    |--------------------------------------------------------------------------
    */
    public function getModuleLabelAttribute(): string
    {
        return match ($this->module) {
            'software' => 'Software',
            'hardware' => 'Hardware',
            'jaringan' => 'Jaringan',
            'data-center',
            'data_center' => 'Data Center',
            'splp' => 'SPLP',
            'data' => 'Data',
            'sdm' => 'SDM',
            default => ucfirst(str_replace('_', ' ', $this->module ?? '-')),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Label action
    |--------------------------------------------------------------------------
    */
    public function getActionLabelAttribute(): string
    {
        return match ($this->action) {
            'create' => 'Tambah',
            'update' => 'Edit',
            'delete' => 'Hapus',
            default => ucfirst($this->action ?? '-'),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Label status
    |--------------------------------------------------------------------------
    */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu' => 'Menunggu',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            default => ucfirst($this->status ?? '-'),
        };
    }
}
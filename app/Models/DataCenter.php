<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataCenter extends Model
{
    protected $table = 'data_centers';

    /*
    |--------------------------------------------------------------------------
    | PRIMARY KEY
    |--------------------------------------------------------------------------
    */

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';


    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'id',

        // Identitas perangkat
        'name',
        'status',
        'tenant',
        'site',
        'rack',
        'role',

        // Spesifikasi perangkat
        'manufacturer',
        'type',
        'platform',
        'version',
        'serial_number',
        'ip_address',
        'cpu',
        'harddisk',
        'ram',
        'pic',

        // Organisasi & lokasi
        'tenant_group',
        'region',
        'location',
        'position',
        'rack_face',
        'ipv4_address',
        'cluster',

        // Keterangan
        'description',
        'comments',

        // Owner
        'owner_group',
        'owner',

        // Rack
        'u_height',

        // Verifikasi
        'verifikasi',
        'komentar',
    ];
}
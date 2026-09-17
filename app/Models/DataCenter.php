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

    // ID Data Center aplikasi
    // Contoh: INFDC-001
    protected $primaryKey = 'id_data_center';

    public $incrementing = false;

    protected $keyType = 'string';


    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        // ID Data Center aplikasi
        'id_data_center',

        // 28 field dari Excel
        'name',
        'tahun',
        'status',
        'tenant',
        'site',
        'rack',
        'role',
        'manufacturer',
        'type',
        'platform',
        'serial_number',
        'ip_address',
        'cpu',
        'harddisk',
        'ram',
        'pic',
        'id',
        'tenant_group',
        'region',
        'location',
        'position',
        'rack_face',
        'ipv4_address',
        'cluster',
        'description',
        'owner_group',
        'owner',
        'u_height',

        // Verifikasi aplikasi
        'verifikasi',
        'komentar',
    ];


    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'tahun' => 'integer',
    ];
}

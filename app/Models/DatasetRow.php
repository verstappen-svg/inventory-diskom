<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatasetRow extends Model
{
    protected $table = 'dataset_rows';

    protected $fillable = [
        'data_id',
        'row_data',
    ];

    protected $casts = [
        'row_data' => 'array',
    ];

    /**
     * Setiap baris dataset
     * dimiliki oleh satu dataset.
     */
    public function data()
    {
        return $this->belongsTo(
            Data::class,
            'data_id'
        );
    }
}
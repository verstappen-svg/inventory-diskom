<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataCenterTemplateExport implements FromArray, WithHeadings
{
    /**
     * Data awal template.
     *
     * Sengaja kosong karena file ini hanya digunakan
     * sebagai template input Excel.
     */
    public function array(): array
    {
        return [];
    }

    /**
     * Header Excel.
     *
     * Total 28 field.
     *
     * Version TIDAK digunakan.
     * Comments TIDAK digunakan.
     */
    public function headings(): array
    {
        return [
            'Name',
            'Tahun',
            'Status',
            'Tenant',
            'Site',
            'Rack',
            'Role',
            'Manufacturer',
            'Type',
            'Platform',
            'Serial number',
            'IP Address',
            'CPU',
            'HARDDISK',
            'RAM',
            'PIC',
            'ID',
            'Tenant Group',
            'Region',
            'Location',
            'Position',
            'Rack face',
            'IPv4 Address',
            'Cluster',
            'Description',
            'Owner Group',
            'Owner',
            'U Height',
        ];
    }
}
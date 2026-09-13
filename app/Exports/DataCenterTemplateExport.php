<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataCenterTemplateExport implements FromArray, WithHeadings
{
    /**
     * Data awal template.
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
     * Total 27 field.
     * Comments TIDAK digunakan.
     */
    public function headings(): array
    {
        return [
            'Name',
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
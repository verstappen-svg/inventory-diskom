<?php

namespace App\Imports;

use App\Models\DataCenter;
use App\Models\VerificationRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use RuntimeException;

class DataCenterImport implements ToModel, WithHeadingRow
{
    /*
    |--------------------------------------------------------------------------
    | PILIHAN DROPDOWN
    |--------------------------------------------------------------------------
    */

    private array $allowedStatuses = [
        'Active',
        'Offline',
    ];

    private array $allowedTenants = [
        'Diskominfostandi',
        'Dinas Pendidikan',
        'Sekretariat Daerah',
        'SatpolPP',
        'DPMPTSP',
        'Dinas Tata Ruang',
        'Bappelitbangda',
        'Dinas Lingkungan Hidup',
        'Disdamkarmat',
        'BKPSDM',
        'BPKAD',
    ];

    private array $allowedSites = [
        'Data Center Pemerintah Kota Bekasi',
        'DRC-Batam',
    ];

    private array $allowedRacks = [
        'Rack A01',
        'Rack A02',
        'Rack DRC',
    ];

    private array $allowedRoles = [
        'Switch Manage',
        'Server Managed by Disdik',
        'Server Managed by Diskominfostandi',
        'Server Managed by DPMPTSP',
        'Server Managed by BPKAD',
        'NAS Managed by Diskominfo',
        'Router',
    ];

    private array $allowedManufacturers = [
        'Mikrotik',
        'Hewlett Packard Enterprise',
        'Lenovo',
        'Synology',
        'Supermicro',
    ];

    private array $allowedRams = [
        '4 GB',
        '8 GB',
        '16 GB',
        '32 GB',
        '40 GB',
        '64 GB',
        '96 GB',
        '128 GB',
        '192 GB',
        '256 GB',
        '512 GB',
        '1024 GB',
    ];

    private array $allowedRegions = [
        'Kota Bekasi',
        'Kota Batam',
    ];

    private array $allowedRackFaces = [
        'Front',
        'Rear',
    ];

    private array $allowedClusters = [
        'DC-Diskominfo',
    ];

    private array $allowedPositions = [
        '01', '02', '03', '04', '05', '06', '07',
        '08', '09', '10', '11', '12', '13', '14',
        '15', '16', '17', '18', '19', '20', '21',
        '22', '23', '24', '25', '26', '27', '28',
        '29', '30', '31', '32', '33', '34', '35',
        '36', '37', '38', '39', '40', '41', '42',
    ];

    /*
    |--------------------------------------------------------------------------
    | U HEIGHT
    |--------------------------------------------------------------------------
    |
    | U Height menggunakan ANGKA saja:
    | 1, 2, 3, ... 42
    |
    | BUKAN:
    | 1U, 2U, 3U, ... 42U
    |
    */

    private array $allowedUHeights = [
        '1', '2', '3', '4', '5', '6', '7',
        '8', '9', '10', '11', '12', '13',
        '14', '15', '16', '17', '18', '19',
        '20', '21', '22', '23', '24', '25',
        '26', '27', '28', '29', '30', '31',
        '32', '33', '34', '35', '36', '37',
        '38', '39', '40', '41', '42',
    ];


    /*
    |--------------------------------------------------------------------------
    | TRACKING DUPLIKAT DALAM FILE EXCEL
    |--------------------------------------------------------------------------
    */

    private array $importedRows = [];


    /*
    |--------------------------------------------------------------------------
    | FIELD YANG DIBANDINGKAN UNTUK DUPLIKAT
    |--------------------------------------------------------------------------
    */

    private array $duplicateFields = [
        'name',
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
    ];


    /*
    |--------------------------------------------------------------------------
    | IMPORT
    |--------------------------------------------------------------------------
    */

    public function model(array $row): Model|array|null
    {
        /*
        |--------------------------------------------------------------------------
        | LEWATI BARIS KOSONG
        |--------------------------------------------------------------------------
        */

        if (
            empty($this->value($row, 'name')) &&
            empty($this->value($row, 'status'))
        ) {
            return null;
        }


        /*
        |--------------------------------------------------------------------------
        | NOMOR BARIS EXCEL
        |--------------------------------------------------------------------------
        */

        $excelRow = $this->getExcelRowNumber();


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA EXCEL
        |--------------------------------------------------------------------------
        */

        $name = $this->value($row, 'name');

        $status = $this->value($row, 'status');

        $tenant = $this->value($row, 'tenant');

        $site = $this->value($row, 'site');

        $rack = $this->value($row, 'rack');

        $role = $this->value($row, 'role');

        $manufacturer = $this->value(
            $row,
            'manufacturer'
        );

        $type = $this->value(
            $row,
            'type'
        );

        $platform = $this->value(
            $row,
            'platform'
        );

        $serialNumber = $this->value(
            $row,
            'serial_number'
        );

        $ipAddress = $this->value(
            $row,
            'ip_address'
        );

        $cpu = $this->value(
            $row,
            'cpu'
        );

        $harddisk = $this->value(
            $row,
            'harddisk'
        );

        $ram = $this->value(
            $row,
            'ram'
        );

        $pic = $this->value(
            $row,
            'pic'
        );

        $region = $this->value(
            $row,
            'region'
        );

        $location = $this->value(
            $row,
            'location'
        );

        $position = $this->value(
            $row,
            'position'
        );

        $rackFace = $this->value(
            $row,
            'rack_face'
        );

        $ipv4Address = $this->value(
            $row,
            'ipv4_address'
        );

        $cluster = $this->value(
            $row,
            'cluster'
        );

        $description = $this->value(
            $row,
            'description'
        );

        $ownerGroup = $this->value(
            $row,
            'owner_group'
        );

        $owner = $this->value(
            $row,
            'owner'
        );

        $uHeight = $this->value(
            $row,
            'u_height'
        );


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI STATUS
        |--------------------------------------------------------------------------
        */

        if ($status !== null) {

            if (strtolower($status) === 'active') {
                $status = 'Active';
            }

            if (strtolower($status) === 'offline') {
                $status = 'Offline';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI U HEIGHT
        |--------------------------------------------------------------------------
        |
        | Excel bisa membaca angka sebagai:
        | 2
        | 2.0
        |
        | Kita ubah menjadi string angka:
        | "2"
        |
        */

        if ($uHeight !== null) {

            if (
                is_numeric($uHeight) &&
                (float) $uHeight == (int) $uHeight
            ) {
                $uHeight = (string) ((int) $uHeight);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | NORMALISASI POSITION
        |--------------------------------------------------------------------------
        |
        | Position tetap menggunakan:
        | 01 - 42
        |
        */

        if ($position !== null && is_numeric($position)) {

            $position = str_pad(
                (string) ((int) $position),
                2,
                '0',
                STR_PAD_LEFT
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DATA FIELD
        |--------------------------------------------------------------------------
        */

        $data = [

            'name' =>
                $name,

            'status' =>
                $status ?: 'Active',

            'tenant' =>
                $tenant,

            'site' =>
                $site,

            'rack' =>
                $rack,

            'role' =>
                $role,

            'manufacturer' =>
                $manufacturer,

            'type' =>
                $type,

            'platform' =>
                $platform,

            'serial_number' =>
                $serialNumber,

            'ip_address' =>
                $ipAddress,

            'cpu' =>
                $cpu,

            'harddisk' =>
                $harddisk,

            'ram' =>
                $ram,

            'pic' =>
                $pic,

            'region' =>
                $region,

            'location' =>
                $location,

            'position' =>
                $position,

            'rack_face' =>
                $rackFace,

            'ipv4_address' =>
                $ipv4Address,

            'cluster' =>
                $cluster,

            'description' =>
                $description,

            'owner_group' =>
                $ownerGroup,

            'owner' =>
                $owner,

            'u_height' =>
                $uHeight,
        ];


        /*
        |--------------------------------------------------------------------------
        | VALIDASI DROPDOWN
        |--------------------------------------------------------------------------
        */

        $errors = [];


        /*
        |--------------------------------------------------------------------------
        | STATUS
        |--------------------------------------------------------------------------
        */

        if (
            $status !== null &&
            !in_array(
                $status,
                $this->allowedStatuses,
                true
            )
        ) {

            $errors[] =
                "Status \"$status\" tidak valid. " .
                "Pilihan yang tersedia: " .
                implode(', ', $this->allowedStatuses);
        }


        /*
        |--------------------------------------------------------------------------
        | TENANT
        |--------------------------------------------------------------------------
        */

        if (
            $tenant !== null &&
            !in_array(
                $tenant,
                $this->allowedTenants,
                true
            )
        ) {

            $errors[] =
                "Tenant \"$tenant\" tidak tersedia.";
        }


        /*
        |--------------------------------------------------------------------------
        | SITE
        |--------------------------------------------------------------------------
        */

        if (
            $site !== null &&
            !in_array(
                $site,
                $this->allowedSites,
                true
            )
        ) {

            $errors[] =
                "Site \"$site\" tidak tersedia.";
        }


        /*
        |--------------------------------------------------------------------------
        | RACK
        |--------------------------------------------------------------------------
        */

        if (
            $rack !== null &&
            !in_array(
                $rack,
                $this->allowedRacks,
                true
            )
        ) {

            $errors[] =
                "Rack \"$rack\" tidak tersedia.";
        }


        /*
        |--------------------------------------------------------------------------
        | ROLE
        |--------------------------------------------------------------------------
        */

        if (
            $role !== null &&
            !in_array(
                $role,
                $this->allowedRoles,
                true
            )
        ) {

            $errors[] =
                "Role \"$role\" tidak tersedia.";
        }


        /*
        |--------------------------------------------------------------------------
        | MANUFACTURER
        |--------------------------------------------------------------------------
        */

        if (
            $manufacturer !== null &&
            !in_array(
                $manufacturer,
                $this->allowedManufacturers,
                true
            )
        ) {

            $errors[] =
                "Manufacturer \"$manufacturer\" tidak tersedia.";
        }


        /*
        |--------------------------------------------------------------------------
        | RAM
        |--------------------------------------------------------------------------
        */

        if (
            $ram !== null &&
            !in_array(
                $ram,
                $this->allowedRams,
                true
            )
        ) {

            $errors[] =
                "RAM \"$ram\" tidak tersedia.";
        }


        /*
        |--------------------------------------------------------------------------
        | REGION
        |--------------------------------------------------------------------------
        */

        if (
            $region !== null &&
            !in_array(
                $region,
                $this->allowedRegions,
                true
            )
        ) {

            $errors[] =
                "Region \"$region\" tidak tersedia.";
        }


        /*
        |--------------------------------------------------------------------------
        | RACK FACE
        |--------------------------------------------------------------------------
        */

        if (
            $rackFace !== null &&
            !in_array(
                $rackFace,
                $this->allowedRackFaces,
                true
            )
        ) {

            $errors[] =
                "Rack Face \"$rackFace\" tidak tersedia.";
        }


        /*
        |--------------------------------------------------------------------------
        | CLUSTER
        |--------------------------------------------------------------------------
        */

        if (
            $cluster !== null &&
            !in_array(
                $cluster,
                $this->allowedClusters,
                true
            )
        ) {

            $errors[] =
                "Cluster \"$cluster\" tidak tersedia.";
        }


        /*
        |--------------------------------------------------------------------------
        | POSITION
        |--------------------------------------------------------------------------
        */

        if (
            $position !== null &&
            !in_array(
                $position,
                $this->allowedPositions,
                true
            )
        ) {

            $errors[] =
                "Position \"$position\" tidak valid. " .
                "Gunakan posisi 01 sampai 42.";
        }


        /*
        |--------------------------------------------------------------------------
        | U HEIGHT
        |--------------------------------------------------------------------------
        |
        | SEKARANG:
        | 1 - 42
        |
        | BUKAN:
        | 1U - 42U
        |
        */

        if (
            $uHeight !== null &&
            !in_array(
                $uHeight,
                $this->allowedUHeights,
                true
            )
        ) {

            $errors[] =
                "U Height \"$uHeight\" tidak valid. " .
                "Gunakan angka 1 sampai 42.";
        }


        /*
        |--------------------------------------------------------------------------
        | JIKA VALIDASI GAGAL
        |--------------------------------------------------------------------------
        */

        if (!empty($errors)) {

            throw new RuntimeException(
                "Baris Excel {$excelRow}: " .
                implode(' | ', $errors)
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CEK DUPLIKAT DI DALAM FILE EXCEL
        |--------------------------------------------------------------------------
        */

        $signature =
            $this->makeSignature($data);


        if (
            isset(
                $this->importedRows[$signature]
            )
        ) {

            $firstRow =
                $this->importedRows[$signature];

            throw new RuntimeException(
                "Baris Excel {$excelRow}: " .
                "data duplikat dengan baris Excel {$firstRow}. " .
                "Seluruh data pada kedua baris sama."
            );
        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN SIGNATURE
        |--------------------------------------------------------------------------
        */

        $this->importedRows[$signature] =
            $excelRow;


        /*
        |--------------------------------------------------------------------------
        | CEK DUPLIKAT DENGAN DATABASE
        |--------------------------------------------------------------------------
        */

        $duplicateQuery =
            DataCenter::query();


        foreach (
            $this->duplicateFields as $field
        ) {

            $value =
                $data[$field] ?? null;


            if ($value === null) {

                $duplicateQuery =
                    $duplicateQuery->whereNull(
                        $field
                    );

            } else {

                $duplicateQuery =
                    $duplicateQuery->where(
                        $field,
                        $value
                    );
            }
        }


        $existingDataCenter =
            $duplicateQuery->first();


        if ($existingDataCenter) {

            throw new RuntimeException(
                "Baris Excel {$excelRow}: " .
                "data sudah ada di database " .
                "dengan ID {$existingDataCenter->id}. " .
                "Seluruh data pada baris Excel sama " .
                "dengan data yang sudah tersimpan."
            );
        }


        /*
        |--------------------------------------------------------------------------
        | GENERATE ID OTOMATIS
        |--------------------------------------------------------------------------
        */

        $newId =
            $this->generateNextId();


        /*
        |--------------------------------------------------------------------------
        | DATA YANG DISIMPAN
        |--------------------------------------------------------------------------
        */

        $saveData = [

            'id' =>
                $newId,

            'name' =>
                $name,

            'status' =>
                $status ?: 'Active',

            'tenant' =>
                $tenant,

            'site' =>
                $site,

            'rack' =>
                $rack,

            'role' =>
                $role,

            'manufacturer' =>
                $manufacturer,

            'type' =>
                $type,

            'platform' =>
                $platform,

            /*
            |--------------------------------------------------------------------------
            | Version tidak tersedia di Excel
            |--------------------------------------------------------------------------
            */

            'version' =>
                null,

            'serial_number' =>
                $serialNumber,

            'ip_address' =>
                $ipAddress,

            'cpu' =>
                $cpu,

            'harddisk' =>
                $harddisk,

            'ram' =>
                $ram,

            'pic' =>
                $pic,

            /*
            |--------------------------------------------------------------------------
            | Tenant Group otomatis
            |--------------------------------------------------------------------------
            */

            'tenant_group' =>
                'Pemerintah Kota Bekasi',

            'region' =>
                $region,

            'location' =>
                $location,

            'position' =>
                $position,

            'rack_face' =>
                $rackFace,

            'ipv4_address' =>
                $ipv4Address,

            'cluster' =>
                $cluster,

            'description' =>
                $description,

            'owner_group' =>
                $ownerGroup,

            'owner' =>
                $owner,

            /*
            |--------------------------------------------------------------------------
            | U HEIGHT
            |--------------------------------------------------------------------------
            |
            | Disimpan sebagai angka string:
            | "1", "2", ..., "42"
            |
            */

            'u_height' =>
                $uHeight,

            /*
            |--------------------------------------------------------------------------
            | VERIFIKASI INTERNAL
            |--------------------------------------------------------------------------
            */

            'verifikasi' =>
                'menunggu',

            'komentar' =>
                null,
        ];


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA + VERIFICATION REQUEST
        |--------------------------------------------------------------------------
        */

        return DB::transaction(
            function () use ($saveData) {

                $dataCenter =
                    DataCenter::create(
                        $saveData
                    );


                VerificationRequest::create([

                    'module' =>
                        'data-center',

                    'record_id' =>
                        $dataCenter->id,

                    'action' =>
                        'create',

                    'data' =>
                        $dataCenter->toArray(),

                    'status' =>
                        'menunggu',

                    'submitted_by' =>
                        auth()->id(),

                ]);


                return $dataCenter;
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GENERATE ID
    |--------------------------------------------------------------------------
    */

    private function generateNextId(): string
    {
        $prefix = 'INFDC-';


        $lastDataCenter =
            DataCenter::query()
                ->where(
                    'id',
                    'like',
                    $prefix . '%'
                )
                ->orderByRaw(
                    "CAST(SUBSTRING(id, 7) AS UNSIGNED) DESC"
                )
                ->first();


        $newNumber =
            $lastDataCenter
                ? (
                    (int) substr(
                        $lastDataCenter->id,
                        strlen($prefix)
                    )
                ) + 1
                : 1;


        return $prefix .
            str_pad(
                $newNumber,
                3,
                '0',
                STR_PAD_LEFT
            );
    }


    /*
    |--------------------------------------------------------------------------
    | BUAT SIGNATURE DATA
    |--------------------------------------------------------------------------
    */

    private function makeSignature(
        array $data
    ): string {

        $values = [];


        foreach (
            $this->duplicateFields as $field
        ) {

            $value =
                $data[$field] ?? null;


            /*
            |--------------------------------------------------------------------------
            | Null dan string kosong dianggap sama
            |--------------------------------------------------------------------------
            */

            if ($value === null) {
                $value = '';
            }


            $values[$field] =
                trim(
                    (string) $value
                );
        }


        return md5(
            json_encode(
                $values,
                JSON_UNESCAPED_UNICODE
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HELPER NILAI EXCEL
    |--------------------------------------------------------------------------
    */

    private function value(
        array $row,
        string $key
    ): ?string {

        if (
            !array_key_exists(
                $key,
                $row
            )
        ) {
            return null;
        }


        $value =
            $row[$key];


        if (is_null($value)) {
            return null;
        }


        $value =
            trim(
                (string) $value
            );


        return $value === ''
            ? null
            : $value;
    }


    /*
    |--------------------------------------------------------------------------
    | NOMOR BARIS EXCEL
    |--------------------------------------------------------------------------
    */

    private function getExcelRowNumber(): int
    {
        static $rowNumber = 1;

        $rowNumber++;

        return $rowNumber;
    }
}
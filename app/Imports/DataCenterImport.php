<?php

namespace App\Imports;

use App\Models\DataCenter;
use App\Models\DataCenterMaster;
use App\Models\VerificationRequest;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use RuntimeException;

class DataCenterImport implements ToCollection, WithHeadingRow
{
    /**
     * Field yang digunakan untuk menentukan apakah
     * isi data benar-benar sama.
     *
     * IMPORTANT:
     * - id TIDAK termasuk.
     * - id_data_center TIDAK termasuk.
     * - verifikasi TIDAK termasuk.
     * - komentar TIDAK termasuk.
     */
    private array $duplicateFields = [
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
    ];

    /**
     * Field yang mengambil data dari Data Master.
     */
    private array $masterLabels = [
        'tenant' => 'Tenant',
        'site' => 'Site',
        'rack' => 'Rack',
        'region' => 'Region',
        'location' => 'Location',
        'role' => 'Role',
        'manufacturer' => 'Manufacturer',
        'pic' => 'PIC',
        'platform' => 'Platform',
    ];

    /**
     * Pilihan yang diperbolehkan.
     */
    private array $allowedStatuses = [
        'Active',
        'Offline',
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

    private array $allowedRackFaces = [
        'Front',
        'Rear',
    ];

    private array $allowedClusters = [
        'DC-Diskominfo',
    ];

    private array $allowedPositions;

    private array $allowedUHeights;

    /**
     * Statistik hasil import.
     */
    private int $totalRows = 0;

    private int $existingRows = 0;

    private int $importedRows = 0;

    public function __construct()
    {
        $this->allowedPositions = array_map(
            fn ($value) => str_pad(
                (string) $value,
                2,
                '0',
                STR_PAD_LEFT
            ),
            range(1, 42)
        );

        $this->allowedUHeights = array_map(
            'strval',
            range(1, 42)
        );
    }

    /**
     * Proses seluruh Excel sebagai satu kumpulan data.
     *
     * VALIDATION FLOW:
     *
     * 1. Baca semua row.
     * 2. Validasi semua row.
     * 3. Cek duplikat di dalam Excel.
     * 4. Cek data yang sudah ada di database.
     * 5. Jika SEMUA sudah ada -> reject seluruh file.
     * 6. Jika sebagian sudah ada -> skip yang lama.
     * 7. Insert hanya data baru.
     */
    public function collection(Collection $rows): void
    {
        $this->totalRows = 0;
        $this->existingRows = 0;
        $this->importedRows = 0;

        $validatedRows = [];
        $seenSignatures = [];

        /*
         * ==========================================================
         * PHASE 1
         * Baca dan validasi SELURUH row terlebih dahulu.
         * Tidak ada insert database di tahap ini.
         * ==========================================================
         */
        foreach ($rows as $index => $row) {
            $row = $row->toArray();

            /*
             * Karena row pertama adalah heading,
             * data pertama berada di Excel row 2.
             */
            $excelRow = $index + 2;

            /*
             * Abaikan row kosong.
             */
            if ($this->isEmptyRow($row)) {
                continue;
            }

            $data = $this->prepareRow(
                $row,
                $excelRow
            );

            /*
             * Signature hanya berdasarkan 27 field isi.
             * ID manual TIDAK ikut.
             */
            $signature = $this->makeSignature($data);

            /*
             * ======================================================
             * CEK DUPLIKAT DI DALAM FILE EXCEL
             * ======================================================
             */
            if (isset($seenSignatures[$signature])) {
                $firstRow = $seenSignatures[$signature];

                throw new RuntimeException(
                    "Data pada Excel baris {$excelRow} merupakan duplikat "
                    . "dari data pada baris {$firstRow}. "
                    . "Duplikat data dalam satu file tidak diperbolehkan. "
                    . "Tidak ada data yang diimport."
                );
            }

            $seenSignatures[$signature] = $excelRow;

            $validatedRows[] = [
                'excel_row' => $excelRow,
                'id' => $data['id'],
                'data' => $this->onlyDuplicateFields($data),
            ];
        }

        /*
         * Tidak boleh upload file kosong.
         */
        $this->totalRows = count($validatedRows);

        if ($this->totalRows === 0) {
            throw new RuntimeException(
                'File Excel tidak memiliki data Data Center yang dapat diimport.'
            );
        }

        /*
         * ==========================================================
         * PHASE 2
         * Cek apakah data sudah ada di database.
         *
         * ID MANUAL TIDAK DIGUNAKAN.
         * ==========================================================
         */
        foreach ($validatedRows as $index => $item) {
            $existing = $this->findExistingData(
                $item['data']
            );

            $validatedRows[$index]['existing'] = $existing !== null;

            if ($existing !== null) {
                $this->existingRows++;
            }
        }

        /*
         * ==========================================================
         * SEMUA DATA SUDAH ADA
         *
         * Ini kondisi yang sebelumnya salah:
         * import dianggap berhasil padahal semua row dilewati.
         *
         * Sekarang kita THROW ERROR.
         * ==========================================================
         */
        if ($this->existingRows === $this->totalRows) {
            throw new RuntimeException(
                "Seluruh {$this->totalRows} data dalam file Excel "
                . "sudah terdaftar di Data Center. "
                . "File tidak diimport karena tidak ada data baru."
            );
        }

        /*
         * ==========================================================
         * PHASE 3
         * Insert hanya data yang BELUM ADA.
         *
         * Semua validation sudah selesai sebelum masuk sini.
         * ==========================================================
         */
        foreach ($validatedRows as $item) {
            /*
             * Data sudah ada -> skip.
             */
            if ($item['existing']) {
                continue;
            }

            $idDataCenter = $this->generateNextId();

            $saveData = array_merge(
                [
                    'id_data_center' => $idDataCenter,
                    'id' => $item['id'],
                ],
                $item['data'],
                [
                    'verifikasi' => 'menunggu',
                    'komentar' => null,
                ]
            );

            $dataCenter = DataCenter::create(
                $saveData
            );

            /*
             * Buat pengajuan verifikasi.
             */
            VerificationRequest::create([
                'module' => 'data-center',
                'record_id' => $dataCenter->id_data_center,
                'action' => 'create',
                'data' => $saveData,
                'status' => 'menunggu',
                'submitted_by' => auth()->id(),
            ]);

            $this->importedRows++;
        }
    }

    /**
     * Menyiapkan dan memvalidasi satu row Excel.
     */
    private function prepareRow(
        array $row,
        int $excelRow
    ): array {
        /*
         * ==========================================================
         * AMBIL DATA DARI HEADING EXCEL
         * ==========================================================
         */
        $id = $this->cleanValue(
            $this->getValue($row, 'id')
        );

        $name = $this->cleanValue(
            $this->getValue($row, 'name')
        );

        $tahun = $this->cleanValue(
            $this->getValue($row, 'tahun')
        );

        $status = $this->cleanValue(
            $this->getValue($row, 'status')
        );

        $tenant = $this->cleanValue(
            $this->getValue($row, 'tenant')
        );

        $site = $this->cleanValue(
            $this->getValue($row, 'site')
        );

        $rack = $this->cleanValue(
            $this->getValue($row, 'rack')
        );

        $role = $this->cleanValue(
            $this->getValue($row, 'role')
        );

        $manufacturer = $this->cleanValue(
            $this->getValue($row, 'manufacturer')
        );

        $type = $this->cleanValue(
            $this->getValue($row, 'type')
        );

        $platform = $this->cleanValue(
            $this->getValue($row, 'platform')
        );

        $serialNumber = $this->cleanValue(
            $this->getValue($row, 'serial_number')
        );

        $ipAddress = $this->cleanValue(
            $this->getValue($row, 'ip_address')
        );

        $cpu = $this->cleanValue(
            $this->getValue($row, 'cpu')
        );

        $harddisk = $this->cleanValue(
            $this->getValue($row, 'harddisk')
        );

        $ram = $this->cleanValue(
            $this->getValue($row, 'ram')
        );

        $pic = $this->cleanValue(
            $this->getValue($row, 'pic')
        );

        $tenantGroup = $this->cleanValue(
            $this->getValue($row, 'tenant_group')
        );

        $region = $this->cleanValue(
            $this->getValue($row, 'region')
        );

        $location = $this->cleanValue(
            $this->getValue($row, 'location')
        );

        $position = $this->cleanValue(
            $this->getValue($row, 'position')
        );

        $rackFace = $this->cleanValue(
            $this->getValue($row, 'rack_face')
        );

        $ipv4Address = $this->cleanValue(
            $this->getValue($row, 'ipv4_address')
        );

        $cluster = $this->cleanValue(
            $this->getValue($row, 'cluster')
        );

        $description = $this->cleanValue(
            $this->getValue($row, 'description')
        );

        $ownerGroup = $this->cleanValue(
            $this->getValue($row, 'owner_group')
        );

        $owner = $this->cleanValue(
            $this->getValue($row, 'owner')
        );

        $uHeight = $this->cleanValue(
            $this->getValue($row, 'u_height')
        );

        /*
         * ==========================================================
         * VALIDASI ID MANUAL
         * ==========================================================
         */
        if ($id === null) {
            $this->fail(
                $excelRow,
                'ID wajib diisi.'
            );
        }

        if (mb_strlen($id) > 50) {
            $this->fail(
                $excelRow,
                'ID maksimal 50 karakter.'
            );
        }

        /*
         * ==========================================================
         * VALIDASI NAME
         * ==========================================================
         */
        if ($name === null) {
            $this->fail(
                $excelRow,
                'Name wajib diisi.'
            );
        }

        if (mb_strlen($name) > 255) {
            $this->fail(
                $excelRow,
                'Name maksimal 255 karakter.'
            );
        }

        /*
         * ==========================================================
         * TAHUN
         * ==========================================================
         */
        if ($tahun !== null) {
            if (
                !is_numeric($tahun)
                || (int) $tahun != $tahun
            ) {
                $this->fail(
                    $excelRow,
                    "Tahun '{$tahun}' harus berupa angka."
                );
            }

            $tahun = (int) $tahun;

            $maxYear = (int) date('Y') + 1;

            if (
                $tahun < 1900
                || $tahun > $maxYear
            ) {
                $this->fail(
                    $excelRow,
                    "Tahun harus antara 1900 sampai {$maxYear}."
                );
            }
        }

        /*
         * ==========================================================
         * STATUS
         *
         * Jika kosong, samakan dengan behavior sebelumnya:
         * Active.
         *
         * Ini penting supaya file yang sama pada upload berikutnya
         * menghasilkan signature yang sama.
         * ==========================================================
         */
        if ($status === null) {
            $status = 'Active';
        }

        $status = $this->normalizeStatus(
            $status
        );

        if (
            !in_array(
                $status,
                $this->allowedStatuses,
                true
            )
        ) {
            $this->fail(
                $excelRow,
                "Status '{$status}' tidak valid. "
                . 'Gunakan Active atau Offline.'
            );
        }

        /*
         * ==========================================================
         * DATA MASTER
         * ==========================================================
         */
        $masterFields = [
            'tenant' => $tenant,
            'site' => $site,
            'rack' => $rack,
            'role' => $role,
            'manufacturer' => $manufacturer,
            'platform' => $platform,
            'pic' => $pic,
            'region' => $region,
            'location' => $location,
        ];

        foreach ($masterFields as $field => $value) {
            if ($value === null) {
                continue;
            }

            $this->validateMasterValue(
                $field,
                $value,
                $excelRow
            );
        }

        /*
         * ==========================================================
         * RAM
         * ==========================================================
         */
        if (
            $ram !== null
            && !in_array(
                $ram,
                $this->allowedRams,
                true
            )
        ) {
            $this->fail(
                $excelRow,
                "RAM '{$ram}' tidak valid. "
                . 'Silakan gunakan pilihan RAM yang tersedia.'
            );
        }

        /*
         * ==========================================================
         * RACK FACE
         * ==========================================================
         */
        if (
            $rackFace !== null
            && !in_array(
                $rackFace,
                $this->allowedRackFaces,
                true
            )
        ) {
            $this->fail(
                $excelRow,
                "Rack Face '{$rackFace}' tidak valid. "
                . 'Gunakan Front atau Rear.'
            );
        }

        /*
         * ==========================================================
         * CLUSTER
         * ==========================================================
         */
        if (
            $cluster !== null
            && !in_array(
                $cluster,
                $this->allowedClusters,
                true
            )
        ) {
            $this->fail(
                $excelRow,
                "Cluster '{$cluster}' tidak valid."
            );
        }

        /*
         * ==========================================================
         * POSITION
         * ==========================================================
         */
        if ($position !== null) {
            $position = $this->normalizePosition(
                $position
            );

            if (
                !in_array(
                    $position,
                    $this->allowedPositions,
                    true
                )
            ) {
                $this->fail(
                    $excelRow,
                    "Position '{$position}' tidak valid. "
                    . 'Gunakan posisi 01 sampai 42.'
                );
            }
        }

        /*
         * ==========================================================
         * U HEIGHT
         * ==========================================================
         */
        if ($uHeight !== null) {
            if (
                !is_numeric($uHeight)
                || (int) $uHeight != $uHeight
            ) {
                $this->fail(
                    $excelRow,
                    "U Height '{$uHeight}' harus berupa angka."
                );
            }

            $uHeight = (int) $uHeight;

            if (
                $uHeight < 1
                || $uHeight > 42
            ) {
                $this->fail(
                    $excelRow,
                    'U Height harus antara 1 sampai 42.'
                );
            }
        }

        /*
         * ==========================================================
         * DATA FINAL
         * ==========================================================
         *
         * ID manual tetap disimpan.
         *
         * Tetapi nanti saat membuat signature,
         * ID sengaja tidak dipakai.
         */
        return [
            'id' => $id,

            'name' => $name,
            'tahun' => $tahun,
            'status' => $status,
            'tenant' => $tenant,
            'site' => $site,
            'rack' => $rack,
            'role' => $role,
            'manufacturer' => $manufacturer,
            'type' => $type,
            'platform' => $platform,
            'serial_number' => $serialNumber,
            'ip_address' => $ipAddress,
            'cpu' => $cpu,
            'harddisk' => $harddisk,
            'ram' => $ram,
            'pic' => $pic,
            'tenant_group' => $tenantGroup,
            'region' => $region,
            'location' => $location,
            'position' => $position,
            'rack_face' => $rackFace,
            'ipv4_address' => $ipv4Address,
            'cluster' => $cluster,
            'description' => $description,
            'owner_group' => $ownerGroup,
            'owner' => $owner,
            'u_height' => $uHeight,
        ];
    }

    /**
     * Ambil value berdasarkan heading Excel.
     */
    private function getValue(
        array $row,
        string $key
    ) {
        return $row[$key] ?? null;
    }

    /**
     * Bersihkan value Excel.
     */
    private function cleanValue($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        return $value;
    }

    /**
     * Normalisasi status.
     */
    private function normalizeStatus(
        string $status
    ): string {
        $status = trim($status);

        foreach ($this->allowedStatuses as $allowed) {
            if (
                strcasecmp(
                    $status,
                    $allowed
                ) === 0
            ) {
                return $allowed;
            }
        }

        return $status;
    }

    /**
     * Normalisasi position.
     *
     * 1 -> 01
     * 2 -> 02
     * 10 -> 10
     */
    private function normalizePosition(
        string $position
    ): string {
        if (
            is_numeric($position)
            && (int) $position >= 1
            && (int) $position <= 42
        ) {
            return str_pad(
                (string) ((int) $position),
                2,
                '0',
                STR_PAD_LEFT
            );
        }

        return $position;
    }

    /**
     * Validasi Data Master.
     */
    private function validateMasterValue(
        string $field,
        string $value,
        int $excelRow
    ): void {
        $master = DataCenterMaster::query()
            ->where('jenis', $field)
            ->where('status', 'Active')
            ->whereRaw(
                'LOWER(TRIM(nama)) = ?',
                [mb_strtolower(trim($value))]
            )
            ->first();

        if ($master) {
            return;
        }

        $label = $this->masterLabels[$field]
            ?? ucfirst(str_replace('_', ' ', $field));

        throw new RuntimeException(
            "Data pada Excel baris {$excelRow}: "
            . "{$label} '{$value}' belum terdaftar di Data Master. "
            . "Silakan tambahkan '{$value}' terlebih dahulu melalui "
            . "Data Center → Data Master → {$label}, "
            . "kemudian upload kembali file Excel."
        );
    }

    /**
     * Ambil hanya 27 field yang digunakan untuk
     * membandingkan isi data.
     */
    private function onlyDuplicateFields(
        array $data
    ): array {
        return collect($this->duplicateFields)
            ->mapWithKeys(
                fn ($field) => [
                    $field => $data[$field] ?? null,
                ]
            )
            ->toArray();
    }

    /**
     * Buat signature unik dari isi data.
     *
     * ID manual sengaja TIDAK dimasukkan.
     */
    private function makeSignature(
        array $data
    ): string {
        $values = [];

        foreach ($this->duplicateFields as $field) {
            $value = $data[$field] ?? null;

            if ($value === null) {
                $values[$field] = null;
                continue;
            }

            $values[$field] = mb_strtolower(
                trim((string) $value)
            );
        }

        return md5(
            json_encode(
                $values,
                JSON_UNESCAPED_UNICODE
                | JSON_UNESCAPED_SLASHES
            )
        );
    }

    /**
     * Cari data yang isinya sama di database.
     *
     * ID manual TIDAK dibandingkan.
     */
    private function findExistingData(
        array $data
    ): ?DataCenter {
        $query = DataCenter::query();

        foreach ($this->duplicateFields as $field) {
            $value = $data[$field] ?? null;

            if ($value === null) {
                $query->whereNull($field);
            } else {
                $query->where(
                    $field,
                    $value
                );
            }
        }

        return $query->first();
    }

    /**
     * Generate ID Data Center sistem.
     *
     * Contoh:
     * INFDC-001
     * INFDC-002
     * INFDC-003
     */
    private function generateNextId(): string
    {
        $prefix = 'INFDC-';

        $lastDataCenter = DataCenter::query()
            ->where(
                'id_data_center',
                'like',
                $prefix . '%'
            )
            ->orderByRaw(
                "CAST(SUBSTRING(id_data_center, 7) AS UNSIGNED) DESC"
            )
            ->first();

        if ($lastDataCenter) {
            $lastNumber = (int) substr(
                $lastDataCenter->id_data_center,
                strlen($prefix)
            );

            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad(
            $newNumber,
            3,
            '0',
            STR_PAD_LEFT
        );
    }

    /**
     * Cek apakah satu row Excel kosong.
     */
    private function isEmptyRow(
        array $row
    ): bool {
        foreach ($row as $value) {
            if (
                $value !== null
                && trim((string) $value) !== ''
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Lempar error dengan nomor row Excel.
     */
    private function fail(
        int $excelRow,
        string $message
    ): never {
        throw new RuntimeException(
            "Data pada Excel baris {$excelRow}: {$message} "
            . 'Tidak ada data yang diimport.'
        );
    }

    /**
     * Jumlah total row yang terbaca.
     */
    public function getTotalRows(): int
    {
        return $this->totalRows;
    }

    /**
     * Jumlah row yang sudah ada di database.
     */
    public function getExistingRows(): int
    {
        return $this->existingRows;
    }

    /**
     * Jumlah row baru yang berhasil dibuat.
     */
    public function getImportedRows(): int
    {
        return $this->importedRows;
    }
}
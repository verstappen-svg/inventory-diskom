<?php

namespace App\Imports;

use App\Models\Hardware;
use App\Models\Lokasi;
use App\Models\VerificationRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class HardwareImport implements
    ToModel,
    WithHeadingRow,
    WithValidation
{
    private function generateAssetId(string $jenisBarang): string
    {
        $year = now()->format('y');

        $endDevices = [
            'PC All in One',
            'PC Desktop',
            'Laptop',
            'NoteBook',
            'Notebook',
            'Tablet',
            'Smartphone',
            'Perangkat Komunikasi',
        ];

        $securityDevices = [
            'CCTV',
        ];

        if (in_array($jenisBarang, $endDevices, true)) {
            $prefix = 'ED-' . $year . '-';
        } elseif (in_array($jenisBarang, $securityDevices, true)) {
            $prefix = 'SD-' . $year . '-';
        } else {
            $prefix = 'PD-' . $year . '-';
        }

        $lastHardware = Hardware::where(
            'asset_id',
            'like',
            $prefix . '%'
        )
            ->orderByRaw(
                "CAST(SUBSTRING_INDEX(asset_id, '-', -1) AS UNSIGNED) DESC"
            )
            ->first();

        if (!$lastHardware) {
            $number = 1;
        } else {
            $lastNumber = (int) substr(
                $lastHardware->asset_id,
                strlen($prefix)
            );

            $number = $lastNumber + 1;
        }

        return $prefix . str_pad(
            $number,
            4,
            '0',
            STR_PAD_LEFT
        );
    }

    public function model(array $row): Model|array|null
    {
        $namaBarang = trim(
            (string) ($row['nama_barang'] ?? '')
        );

        $namaLokasi = trim(
            (string) ($row['lokasi'] ?? '')
        );

        $jenisBarang = trim(
            (string) ($row['jenis_barang'] ?? '')
        );

        $spesifikasi = trim(
            (string) ($row['spesifikasi'] ?? '')
        );

        $sistemOperasi = trim(
            (string) ($row['sistem_operasi'] ?? '')
        );

        $sistemOperasi = $sistemOperasi ?: 'N/A';

        $tahunPembelian = $this->resolveTahunPembelian(
            $row['tahun_perolehan'] ?? null
        );

        $harga = $this->normalizeHarga(
            $row['harga_rp'] ?? 0
        );

        $kondisi = trim(
            (string) ($row['kondisi'] ?? '')
        );

        $kondisi = $kondisi ?: 'N/A';

        $lokasi = Lokasi::where(
            'nama_lokasi',
            $namaLokasi
        )->first();

        if (!$lokasi) {
            throw new \Exception(
                "Lokasi '{$namaLokasi}' tidak ditemukan di Data Master."
            );
        }

        $hardwareData = [
            'asset_id' => $this->generateAssetId(
                $jenisBarang
            ),

            'nama_barang' => $namaBarang,

            'spesifikasi' => $spesifikasi ?: 'N/A',

            'jenis_barang' => $jenisBarang,

            'lokasi_id' => $lokasi->id,

            'sistem_operasi' => $sistemOperasi,

            'tahun_pembelian' => $tahunPembelian,

            'harga' => $harga,

            'kondisi' => $kondisi,
        ];

        $hardware = null;

        DB::transaction(function () use (
            $hardwareData,
            &$hardware
        ) {
            $hardware = Hardware::create(
                $hardwareData
            );

            VerificationRequest::create([
                'module' => 'hardware',
                'record_id' => $hardware->asset_id,
                'action' => 'create',
                'data' => $hardware->toArray(),
                'status' => 'menunggu',
                'submitted_by' => auth()->id(),
            ]);
        });

        return $hardware;
    }

    private function resolveTahunPembelian($value): int
    {
        if ($value === null || $value === '') {
            return now()->year;
        }

        if (is_numeric($value)) {
            $value = (int) $value;

            /*
             * Excel date serial.
             */
            if ($value > 2100) {
                try {
                    $date =
                        \PhpOffice\PhpSpreadsheet\Shared\Date
                            ::excelToDateTimeObject($value);

                    return (int) $date->format('Y');
                } catch (\Throwable $e) {
                    return now()->year;
                }
            }

            if ($value >= 1900 && $value <= 2100) {
                return $value;
            }
        }

        $value = trim((string) $value);

        /*
         * Coba ambil tahun dari format tanggal
         * seperti 2024-01-01 / 01-01-2024.
         */
        if (preg_match('/\b(19|20)\d{2}\b/', $value, $matches)) {
            return (int) $matches[0];
        }

        return now()->year;
    }

    private function normalizeHarga($harga): float
    {
        if ($harga === null || $harga === '') {
            return 0;
        }

        if (is_numeric($harga)) {
            return (float) $harga;
        }

        $harga = trim((string) $harga);

        $harga = str_replace(
            ['Rp', 'rp', ' '],
            '',
            $harga
        );

        if (
            str_contains($harga, '.') &&
            str_contains($harga, ',')
        ) {
            $harga = str_replace('.', '', $harga);
            $harga = str_replace(',', '.', $harga);
        } elseif (str_contains($harga, ',')) {
            $harga = str_replace(',', '.', $harga);
        } elseif (str_contains($harga, '.')) {
            /*
             * Format Indonesia:
             * 1.500.000 -> 1500000
             */
            $harga = str_replace('.', '', $harga);
        }

        return (float) $harga;
    }

    public function rules(): array
    {
        return [
            'nama_barang' => [
                'required',
                'string',
                'max:255',
            ],

            'lokasi' => [
                'required',
                'string',
            ],

            'spesifikasi' => [
                'required',
                'string',
            ],

            'jenis_barang' => [
                'required',
                'string',
                'max:255',
            ],

            'sistem_operasi' => [
                'nullable',
                'string',
                'max:255',
            ],

            'tahun_perolehan' => [
                'required',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'harga_rp' => [
                'required',
            ],

            'kondisi' => [
                'required',
                'string',
                'max:100',
            ],
        ];
    }
}
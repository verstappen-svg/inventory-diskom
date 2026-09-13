<?php

namespace App\Imports;

use App\Models\Hardware;
use App\Models\Lokasi;
use App\Models\VerificationRequest;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class HardwareImport implements
    ToModel,
    WithHeadingRow,
    WithValidation
{
    /**
     * Menentukan Asset ID berdasarkan jenis barang.
     */
    private function generateAssetId(string $jenisBarang): string
    {
        $year = now()->format('y');

        $endDevices = [
            'PC All in One',
            'PC Desktop',
            'Laptop',
            'NoteBook',
            'Tablet',
            'Smartphone',
            'Perangkat Komunikasi',
        ];

        $securityDevices = [
            'CCTV',
        ];

        if (in_array($jenisBarang, $endDevices)) {
            $prefix = 'ED-' . $year . '-';
        } elseif (in_array($jenisBarang, $securityDevices)) {
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

    /**
     * Membaca setiap baris dari Excel.
     */
    public function model(array $row): \Illuminate\Database\Eloquent\Model|array|null
    {
        $lokasi = Lokasi::where(
            'nama_lokasi',
            trim($row['lokasi'] ?? '')
        )->first();

        if (!$lokasi) {
            return null;
        }

        $jenisBarang = trim($row['jenis_barang'] ?? '');

        $sistemOperasi = trim(
            $row['sistem_operasi'] ?? ''
        ) ?: 'N/A';

        $hardwareData = [
            'asset_id' => $this->generateAssetId(
                $jenisBarang
            ),

            'nama_barang' => trim(
                $row['nama_barang'] ?? ''
            ),

            'spesifikasi' => trim(
                $row['spesifikasi'] ?? ''
            ),

            'jenis_barang' => $jenisBarang,

            'lokasi_id' => $lokasi->id,

            'sistem_operasi' => $sistemOperasi,

            'tahun_pembelian' => (int) (
                $row['tahun_perolehan'] ?? 0
            ),

            'harga' => $this->normalizeHarga(
                $row['harga_rp'] ?? $row['harga'] ?? 0
            ),

            'kondisi' => trim(
                $row['kondisi'] ?? ''
            ),
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

    /**
     * Mengubah format harga Excel menjadi angka.
     *
     * Contoh:
     * 7.300.000,00 -> 7300000
     * 10604500    -> 10604500
     */
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

        /*
         * Format Indonesia:
         * 7.300.000,00
         */
        if (
            str_contains($harga, '.') &&
            str_contains($harga, ',')
        ) {
            $harga = str_replace('.', '', $harga);
            $harga = str_replace(',', '.', $harga);
        }

        /*
         * Format angka dengan koma sebagai desimal:
         * 7300000,00
         */
        elseif (str_contains($harga, ',')) {
            $harga = str_replace(',', '.', $harga);
        }

        /*
         * Format angka dengan titik sebagai pemisah ribuan:
         * 7.300.000
         */
        elseif (str_contains($harga, '.')) {
            $harga = str_replace('.', '', $harga);
        }

        return (float) $harga;
    }

    /**
     * Validasi setiap baris Excel.
     */
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
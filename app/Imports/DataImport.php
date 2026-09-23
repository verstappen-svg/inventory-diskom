<?php

namespace App\Imports;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataImport
{
    protected array $metadata = [];

    protected array $headers = [];

    protected array $rows = [];

    /*
    |--------------------------------------------------------------------------
    | IMPORT EXCEL LENGKAP
    |--------------------------------------------------------------------------
    */

    public function import(string $filePath): void
    {
        $this->reset();

        $spreadsheet = IOFactory::load($filePath);

        $metadataSheet = $this->findSheet(
            $spreadsheet,
            'Metadata'
        );

        $datasetSheet = $this->findSheet(
            $spreadsheet,
            'Dataset'
        );

        if (!$metadataSheet) {
            throw new \Exception(
                'Sheet "Metadata" tidak ditemukan. Pastikan Excel memiliki sheet Metadata.'
            );
        }

        if (!$datasetSheet) {
            throw new \Exception(
                'Sheet "Dataset" tidak ditemukan. Pastikan Excel memiliki sheet Dataset.'
            );
        }

        $this->readMetadata(
            $metadataSheet
        );

        $this->readDataset(
            $datasetSheet
        );

        if (empty($this->headers)) {
            throw new \Exception(
                'Sheet Dataset tidak memiliki header.'
            );
        }

        if (empty($this->rows)) {
            throw new \Exception(
                'Sheet Dataset tidak memiliki data.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | IMPORT DATASET SAJA
    |--------------------------------------------------------------------------
    */

    public function importDatasetOnly(string $filePath): void
    {
        $this->reset();

        $spreadsheet = IOFactory::load($filePath);

        $datasetSheet = $this->findSheet(
            $spreadsheet,
            'Dataset'
        );

        if (!$datasetSheet) {
            $worksheets = [];

            foreach (
                $spreadsheet->getWorksheetIterator()
                as $sheet
            ) {
                $worksheets[] = $sheet;
            }

            if (count($worksheets) === 1) {
                $datasetSheet = $worksheets[0];
            }
        }

        if (!$datasetSheet) {
            throw new \Exception(
                'Excel untuk Tambah Data harus memiliki sheet bernama "Dataset".'
            );
        }

        $this->readDataset(
            $datasetSheet
        );

        if (empty($this->headers)) {
            throw new \Exception(
                'Sheet Dataset tidak memiliki header.'
            );
        }

        if (empty($this->rows)) {
            throw new \Exception(
                'Sheet Dataset tidak memiliki data.'
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CARI SHEET
    |--------------------------------------------------------------------------
    */

    protected function findSheet(
        $spreadsheet,
        string $sheetName
    ): ?Worksheet {
        foreach (
            $spreadsheet->getWorksheetIterator()
            as $sheet
        ) {
            $currentTitle = trim(
                (string) $sheet->getTitle()
            );

            if (
                strcasecmp(
                    $currentTitle,
                    $sheetName
                ) === 0
            ) {
                return $sheet;
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | BACA METADATA
    |--------------------------------------------------------------------------
    */

    protected function readMetadata(
        Worksheet $sheet
    ): void {
        $metadata = [];

        $rows = $sheet->toArray(
            null,
            true,
            true,
            true
        );

        foreach ($rows as $row) {
            $values = array_values($row);

            if (count($values) < 2) {
                continue;
            }

            $key = trim(
                (string) ($values[0] ?? '')
            );

            $value = $values[1] ?? null;

            if ($key === '') {
                continue;
            }

            if (
                strcasecmp(
                    $key,
                    'Metadata'
                ) === 0 &&
                strcasecmp(
                    trim((string) $value),
                    'Nilai'
                ) === 0
            ) {
                continue;
            }

            if (is_string($value)) {
                $value = trim($value);
            }

            if (
                $value === null ||
                $value === ''
            ) {
                continue;
            }

            $metadata[$key] = $value;
        }

        $this->metadata = $metadata;
    }

    /*
    |--------------------------------------------------------------------------
    | BACA DATASET
    |--------------------------------------------------------------------------
    */

    protected function readDataset(
        Worksheet $sheet
    ): void {
        $rows = $sheet->toArray(
            null,
            true,
            true,
            true
        );

        if (empty($rows)) {
            $this->headers = [];
            $this->rows = [];

            return;
        }

        /*
        |----------------------------------------------------------------------
        | HEADER
        |----------------------------------------------------------------------
        */

        $firstRow = array_shift($rows);

        $headers = array_values($firstRow);

        $headers = array_map(
            function ($header) {
                return trim(
                    (string) $header
                );
            },
            $headers
        );

        /*
        |----------------------------------------------------------------------
        | HAPUS KOLOM KOSONG DI BELAKANG
        |----------------------------------------------------------------------
        */

        while (
            !empty($headers) &&
            end($headers) === ''
        ) {
            array_pop($headers);
        }

        if (empty($headers)) {
            $this->headers = [];
            $this->rows = [];

            return;
        }

        /*
        |----------------------------------------------------------------------
        | VALIDASI HEADER KOSONG
        |----------------------------------------------------------------------
        */

        foreach (
            $headers as $index => $header
        ) {
            if ($header === '') {
                $column = $this->columnLetter(
                    $index
                );

                throw new \Exception(
                    'Header pada Sheet Dataset tidak boleh kosong. Kolom ' .
                    $column .
                    ' belum memiliki nama.'
                );
            }
        }

        /*
        |----------------------------------------------------------------------
        | VALIDASI HEADER DUPLIKAT
        |----------------------------------------------------------------------
        */

        $normalizedHeaders = [];

        foreach (
            $headers as $header
        ) {
            $normalizedHeaders[] = strtolower(
                preg_replace(
                    '/\s+/',
                    ' ',
                    trim($header)
                )
            );
        }

        $duplicates = array_diff_assoc(
            $normalizedHeaders,
            array_unique(
                $normalizedHeaders
            )
        );

        if (!empty($duplicates)) {
            $duplicateNames = [];

            foreach (
                array_unique($duplicates)
                as $duplicate
            ) {
                $duplicateNames[] = $duplicate;
            }

            throw new \Exception(
                'Header pada Sheet Dataset tidak boleh sama. Header duplikat: ' .
                implode(
                    ', ',
                    $duplicateNames
                )
            );
        }

        /*
        |----------------------------------------------------------------------
        | BACA DATA
        |----------------------------------------------------------------------
        */

        $dataset = [];

        foreach (
            $rows as $rowNumber => $row
        ) {
            $values = array_values($row);

            $isEmpty = true;

            foreach ($values as $value) {
                if (
                    $value !== null &&
                    trim((string) $value) !== ''
                ) {
                    $isEmpty = false;
                    break;
                }
            }

            if ($isEmpty) {
                continue;
            }

            $record = [];

            foreach (
                $headers as $index => $header
            ) {
                $value = $values[$index] ?? null;

                if (is_string($value)) {
                    $value = trim($value);
                }

                $record[$header] = $value;
            }

            $dataset[] = $record;
        }

        $this->headers = $headers;

        $this->rows = $dataset;
    }

    /*
    |--------------------------------------------------------------------------
    | KOLOM EXCEL
    |--------------------------------------------------------------------------
    */

    protected function columnLetter(
        int $index
    ): string {
        $index++;

        $letter = '';

        while ($index > 0) {
            $remainder = ($index - 1) % 26;

            $letter =
                chr(65 + $remainder) .
                $letter;

            $index =
                intdiv(
                    $index - 1,
                    26
                );
        }

        return $letter;
    }

    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    protected function reset(): void
    {
        $this->metadata = [];

        $this->headers = [];

        $this->rows = [];
    }

    /*
    |--------------------------------------------------------------------------
    | GET METADATA
    |--------------------------------------------------------------------------
    */

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    /*
    |--------------------------------------------------------------------------
    | GET HEADERS
    |--------------------------------------------------------------------------
    */

    public function getHeaders(): array
    {
        return $this->headers;
    }

    /*
    |--------------------------------------------------------------------------
    | GET ROWS
    |--------------------------------------------------------------------------
    */

    public function getRows(): array
    {
        return $this->rows;
    }
}
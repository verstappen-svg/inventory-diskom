<?php

namespace App\Imports;

use PhpOffice\PhpSpreadsheet\IOFactory;

class DataImport
{
    protected array $metadata = [];
    protected array $headers = [];
    protected array $rows = [];

    public function import(string $filePath): void
    {
        $spreadsheet = IOFactory::load($filePath);

        $sheets = $spreadsheet->getWorksheetIterator();

        $worksheets = [];

        foreach ($sheets as $sheet) {
            $worksheets[] = $sheet;
        }

        if (count($worksheets) < 2) {
            throw new \Exception(
                'Excel harus memiliki minimal 2 sheet.'
            );
        }

        $this->readMetadata($worksheets[0]);
        $this->readDataset($worksheets[1]);
    }

    protected function readMetadata($sheet): void
    {
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

            $key = trim((string) ($values[0] ?? ''));
            $value = $values[1] ?? null;

            if ($key === '') {
                continue;
            }

            if ($value !== null) {
                $value = trim((string) $value);
            }

            if ($key === 'Metadata' && $value === 'Nilai') {
                continue;
            }

            $metadata[$key] = $value;
        }

        $this->metadata = $metadata;
    }

    protected function readDataset($sheet): void
    {
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

        $firstRow = array_shift($rows);

        $headers = array_values($firstRow);

        $headers = array_map(
            fn ($header) => trim((string) $header),
            $headers
        );

        $headers = array_values(
            array_filter(
                $headers,
                fn ($header) => $header !== ''
            )
        );

        $dataset = [];

        foreach ($rows as $row) {
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

            foreach ($headers as $index => $header) {
                $record[$header] = $values[$index] ?? null;
            }

            $dataset[] = $record;
        }

        $this->headers = $headers;
        $this->rows = $dataset;
    }

    public function getMetadata(): array
    {
        return $this->metadata;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getRows(): array
    {
        return $this->rows;
    }
}
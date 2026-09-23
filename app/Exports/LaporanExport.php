<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Export;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class LaporanExport implements Export, WithMultipleSheets
{
    protected array $jenis;
    protected array $jenisLabel;
    protected array $kolom;
    protected array $kolomDiizinkan;
    protected array $hasil;
    protected array $filter;

    public function __construct(
        array $jenis,
        array $jenisLabel,
        array $kolom,
        array $kolomDiizinkan,
        array $hasil,
        array $filter = []
    ) {
        $this->jenis = $jenis;
        $this->jenisLabel = $jenisLabel;
        $this->kolom = $kolom;
        $this->kolomDiizinkan = $kolomDiizinkan;
        $this->hasil = $hasil;
        $this->filter = $filter;
    }

    public function sheets(): array
    {
        $sheets = [];

        foreach ($this->jenis as $jenisHasil) {

            $sheets[] = new class(
                $jenisHasil,
                $this->jenisLabel,
                $this->kolom,
                $this->kolomDiizinkan,
                $this->hasil,
                $this->filter
            ) implements FromView, WithTitle {

                protected string $jenisHasil;
                protected array $jenisLabel;
                protected array $kolom;
                protected array $kolomDiizinkan;
                protected array $hasil;
                protected array $filter;

                public function __construct(
                    string $jenisHasil,
                    array $jenisLabel,
                    array $kolom,
                    array $kolomDiizinkan,
                    array $hasil,
                    array $filter
                ) {
                    $this->jenisHasil = $jenisHasil;
                    $this->jenisLabel = $jenisLabel;
                    $this->kolom = $kolom;
                    $this->kolomDiizinkan = $kolomDiizinkan;
                    $this->hasil = $hasil;
                    $this->filter = $filter;
                }

                public function view(): View
                {
                    return view('laporan.export', [
                        'jenis' => [$this->jenisHasil],
                        'jenisLabel' => $this->jenisLabel,
                        'kolom' => $this->kolom,
                        'kolomDiizinkan' => $this->kolomDiizinkan,
                        'hasil' => [
                            $this->jenisHasil =>
                                $this->hasil[$this->jenisHasil]
                                ?? collect()
                        ],
                        'filter' => $this->filter,
                    ]);
                }

                public function title(): string
                {
                    $label = $this->jenisLabel[$this->jenisHasil]
                        ?? $this->jenisHasil;

                    $label = preg_replace(
                        '/[\\\\\/\?\*\[\]\:]/',
                        '',
                        $label
                    );

                    return mb_substr($label, 0, 31);
                }
            };
        }

        return $sheets;
    }
}
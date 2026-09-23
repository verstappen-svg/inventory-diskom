@extends('layouts.app')

@section('title', 'Laporan - Inventory IT Assets')

@section('page-title', 'LAPORAN')

@section('content')

<style>
/* =========================================================
   LAPORAN PAGE
========================================================= */

.laporan-page {
    width: 100%;
}

/* =========================================================
   HEADER
========================================================= */

.laporan-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 24px;
}

.laporan-heading h2 {
    margin: 0 0 6px;
    font-size: 25px;
    font-weight: 700;
    color: #111827;
}

.laporan-heading p {
    margin: 0;
    color: #6b7280;
    font-size: 14px;
    line-height: 1.6;
}

/* =========================================================
   HEADER ACTION
========================================================= */

.laporan-actions {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-shrink: 0;
}

.btn-laporan {
    border: 0;
    border-radius: 8px;
    padding: 10px 16px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: .2s ease;
}

.btn-reset {
    background: #f3f4f6;
    color: #374151;
}

.btn-reset:hover {
    background: #e5e7eb;
}

/* =========================================================
   DOWNLOAD EXCEL
========================================================= */

.btn-excel {
    background: #166534;
    color: #fff;
}

.btn-excel:hover {
    background: #14532d;
}

.btn-excel:disabled {
    opacity: .6;
    cursor: not-allowed;
}

/* =========================================================
   SECTION CARD
========================================================= */

.laporan-section {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .04);
    margin-bottom: 20px;
    overflow: hidden;
}

.laporan-section-header {
    padding: 18px 20px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
}

.laporan-section-title {
    display: flex;
    align-items: center;
    gap: 10px;
}

.laporan-section-title i {
    color: #071b88;
    font-size: 18px;
}

.laporan-section-title h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #111827;
}

.laporan-section-body {
    padding: 20px;
}

/* =========================================================
   JENIS DATA
========================================================= */

.jenis-grid {
    display: grid;
    grid-template-columns: repeat(6, minmax(0, 1fr));
    gap: 12px;
}

.jenis-card {
    position: relative;
}

.jenis-card input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.jenis-card label {
    min-height: 115px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    background: #fff;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 9px;
    padding: 14px;
    cursor: pointer;
    text-align: center;
    transition: .2s ease;
}

.jenis-card label:hover {
    border-color: #a5b4fc;
    background: #f8faff;
    transform: translateY(-1px);
}

.jenis-card input:checked + label {
    border-color: #071b88;
    background: #f2f5ff;
    box-shadow: 0 0 0 2px rgba(7, 27, 136, .08);
}

.jenis-card-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: #eef2ff;
    color: #071b88;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.jenis-card input:checked + label .jenis-card-icon {
    background: #071b88;
    color: #fff;
}

.jenis-card-title {
    font-size: 13px;
    font-weight: 700;
    color: #1f2937;
}

/* =========================================================
   SPLP INFO
========================================================= */

.splp-info {
    margin-top: 16px;
    padding: 14px 16px;
    border-radius: 9px;
    border: 1px solid #dbeafe;
    background: #eff6ff;
    display: flex;
    gap: 12px;
    align-items: flex-start;
}

.splp-info i {
    color: #2563eb;
    font-size: 18px;
    margin-top: 1px;
}

.splp-info strong {
    display: block;
    font-size: 13px;
    color: #1e3a8a;
    margin-bottom: 3px;
}

.splp-info span {
    display: block;
    color: #475569;
    font-size: 12px;
    line-height: 1.5;
}

/* =========================================================
   KOLOM
========================================================= */

.kolom-container {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.kolom-panel {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
}

.kolom-panel.hidden {
    display: none;
}

.kolom-panel-header {
    background: #f8fafc;
    padding: 13px 15px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
}

.kolom-panel-title {
    display: flex;
    align-items: center;
    gap: 8px;
}

.kolom-panel-title i {
    color: #071b88;
}

.kolom-panel-title strong {
    font-size: 13px;
    color: #1f2937;
}

.kolom-panel-actions {
    display: flex;
    gap: 7px;
}

.btn-mini {
    border: 1px solid #d1d5db;
    background: #fff;
    color: #374151;
    border-radius: 6px;
    padding: 5px 9px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
}

.btn-mini:hover {
    background: #f3f4f6;
}

.kolom-panel-body {
    padding: 15px;
}

.kolom-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 9px 12px;
}

.kolom-item {
    position: relative;
}

.kolom-item input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}

.kolom-item label {
    display: flex;
    align-items: center;
    gap: 9px;
    padding: 9px 10px;
    border: 1px solid #e5e7eb;
    border-radius: 7px;
    cursor: pointer;
    font-size: 12px;
    color: #374151;
    background: #fff;
    transition: .15s ease;
}

.kolom-item label:hover {
    border-color: #c7d2fe;
    background: #f8faff;
}

.kolom-item input:checked + label {
    border-color: #071b88;
    background: #f3f5ff;
    color: #071b88;
    font-weight: 600;
}

.kolom-check {
    width: 16px;
    height: 16px;
    border: 1px solid #cbd5e1;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.kolom-item input:checked + label .kolom-check {
    background: #071b88;
    border-color: #071b88;
}

.kolom-item input:checked + label .kolom-check::after {
    content: "✓";
    color: #fff;
    font-size: 10px;
    font-weight: 700;
}

/* =========================================================
   FILTER
========================================================= */

.filter-container {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.filter-global {
    padding: 14px;
    border: 1px solid #e5e7eb;
    background: #f8fafc;
    border-radius: 9px;
}

.filter-global label {
    display: block;
    margin-bottom: 7px;
    font-size: 12px;
    font-weight: 700;
    color: #374151;
}

.filter-global-input {
    position: relative;
}

.filter-global-input i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 14px;
}

.filter-global-input input {
    width: 100%;
    box-sizing: border-box;
    height: 40px;
    padding: 0 12px 0 36px;
    border: 1px solid #d1d5db;
    border-radius: 7px;
    outline: none;
    font-size: 13px;
    background: #fff;
}

.filter-global-input input:focus {
    border-color: #071b88;
    box-shadow: 0 0 0 2px rgba(7, 27, 136, .08);
}

.filter-panel {
    border: 1px solid #e5e7eb;
    border-radius: 9px;
    overflow: hidden;
}

.filter-panel.hidden {
    display: none;
}

.filter-panel-header {
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    padding: 12px 14px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.filter-panel-header strong {
    font-size: 12px;
    color: #374151;
}

.filter-panel-header i {
    color: #071b88;
    margin-right: 6px;
}

.filter-panel-body {
    padding: 14px;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 12px;
}

.filter-field label {
    display: block;
    margin-bottom: 6px;
    font-size: 11px;
    font-weight: 700;
    color: #4b5563;
}

.filter-field select,
.filter-field input {
    width: 100%;
    height: 38px;
    box-sizing: border-box;
    border: 1px solid #d1d5db;
    border-radius: 7px;
    background: #fff;
    padding: 0 10px;
    outline: none;
    color: #374151;
    font-size: 12px;
}

.filter-field select:focus,
.filter-field input:focus {
    border-color: #071b88;
    box-shadow: 0 0 0 2px rgba(7, 27, 136, .08);
}

.filter-clear {
    border: 0;
    background: transparent;
    color: #6b7280;
    font-size: 11px;
    cursor: pointer;
}

.filter-clear:hover {
    color: #dc2626;
}

/* =========================================================
   AUTO STATUS
========================================================= */

.preview-auto-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 11px;
    color: #6b7280;
}

.preview-auto-status.loading {
    color: #071b88;
}

.preview-auto-status .status-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #22c55e;
}

.preview-auto-status.loading .status-dot {
    background: #f59e0b;
}

/* =========================================================
   PREVIEW
========================================================= */

.preview-container {
    min-height: 160px;
}

.preview-empty {
    min-height: 180px;
    border: 1px dashed #d1d5db;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 30px;
    color: #6b7280;
}

.preview-empty i {
    font-size: 34px;
    color: #cbd5e1;
    margin-bottom: 12px;
}

.preview-empty strong {
    color: #374151;
    font-size: 14px;
    margin-bottom: 5px;
}

.preview-empty span {
    font-size: 12px;
}

.preview-loading {
    min-height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 10px;
    color: #6b7280;
    font-size: 12px;
}

.preview-spinner {
    width: 28px;
    height: 28px;
    border: 3px solid #e5e7eb;
    border-top-color: #071b88;
    border-radius: 50%;
    animation: laporanSpin .7s linear infinite;
}

@keyframes laporanSpin {
    to {
        transform: rotate(360deg);
    }
}

.preview-warning {
    margin-bottom: 14px;
    padding: 12px 14px;
    border-radius: 8px;
    border: 1px solid #fde68a;
    background: #fffbeb;
    color: #92400e;
    font-size: 12px;
}

.preview-warning div + div {
    margin-top: 4px;
}

.preview-table-wrapper {
    width: 100%;
    overflow-x: auto;
    border: 1px solid #e5e7eb;
    border-radius: 9px;
}

.preview-table {
    width: 100%;
    min-width: 800px;
    border-collapse: collapse;
    font-size: 12px;
}

.preview-table th {
    background: #f8fafc;
    color: #374151;
    font-weight: 700;
    white-space: nowrap;
    border-bottom: 1px solid #e5e7eb;
    padding: 11px 12px;
    text-align: left;
}

.preview-table td {
    padding: 10px 12px;
    border-bottom: 1px solid #f1f5f9;
    color: #4b5563;
    vertical-align: top;
    word-break: break-word;
}

.preview-table tbody tr:hover {
    background: #fafafa;
}

.preview-table tbody tr:last-child td {
    border-bottom: 0;
}

.preview-title {
    margin: 0 0 10px;
    font-size: 14px;
    font-weight: 700;
    color: #111827;
}

.preview-meta {
    margin: 0 0 10px;
    color: #6b7280;
    font-size: 11px;
}

.preview-block {
    margin-bottom: 22px;
}

.preview-block:last-child {
    margin-bottom: 0;
}

.preview-empty-table {
    padding: 20px;
    text-align: center;
    color: #9ca3af;
    font-size: 12px;
}

/* =========================================================
   FOOTER INFO
========================================================= */

.laporan-footer-info {
    margin-top: 12px;
    color: #9ca3af;
    font-size: 11px;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1200px) {

    .jenis-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .kolom-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }

    .filter-grid {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
}

@media (max-width: 900px) {

    .laporan-header {
        flex-direction: column;
    }

    .laporan-actions {
        width: 100%;
    }

    .laporan-actions .btn-laporan {
        flex: 1;
    }

    .jenis-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .kolom-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .filter-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 600px) {

    .laporan-section-body {
        padding: 14px;
    }

    .jenis-grid,
    .kolom-grid,
    .filter-grid {
        grid-template-columns: 1fr;
    }

    .laporan-section-header {
        align-items: flex-start;
        flex-direction: column;
    }
}
</style>


<div class="laporan-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="laporan-header">

        <div class="laporan-heading">

            <h2>Report Builder</h2>

            <p>
                Pilih jenis data, tentukan kolom, gunakan filter,
                kemudian preview laporan akan diperbarui otomatis.
            </p>

        </div>

        <div class="laporan-actions">

            <button
                type="button"
                class="btn-laporan btn-reset"
                id="btnReset"
            >
                <i class="bi bi-arrow-counterclockwise me-1"></i>
                Reset Laporan
            </button>

        </div>

    </div>


    {{-- =====================================================
         FORM UTAMA
    ====================================================== --}}

    <form
        id="laporanForm"
        action="{{ route('laporan.index') }}"
        method="GET"
    >

        {{-- =================================================
             1. JENIS DATA
        ================================================== --}}

        <div class="laporan-section">

            <div class="laporan-section-header">

                <div class="laporan-section-title">

                    <i class="bi bi-collection"></i>

                    <h3>1. Pilih Jenis Data</h3>

                </div>

                <span
                    class="preview-auto-status"
                    id="previewStatus"
                >
                    <span class="status-dot"></span>
                    Preview otomatis aktif
                </span>

            </div>

            <div class="laporan-section-body">

                <div class="jenis-grid">

                    @foreach($jenisConfig as $key => $config)

                        <div class="jenis-card">

                            <input
                                type="checkbox"
                                name="jenis[]"
                                value="{{ $key }}"
                                id="jenis_{{ str_replace('-', '_', $key) }}"
                                class="jenis-checkbox"
                                {{ in_array($key, $jenis ?? []) ? 'checked' : '' }}
                            >

                            <label
                                for="jenis_{{ str_replace('-', '_', $key) }}"
                            >

                                <span class="jenis-card-icon">

                                    <i class="bi {{ $config['icon'] }}"></i>

                                </span>

                                <span class="jenis-card-title">
                                    {{ $config['label'] }}
                                </span>

                            </label>

                        </div>

                    @endforeach

                </div>


                {{-- =================================================
                     SPLP HANYA INFORMASI
                ================================================== --}}

                <div class="splp-info">

                    <i class="bi bi-info-circle-fill"></i>

                    <div>

                        <strong>SPLP</strong>

                        <span>
                            Data SPLP tidak tersedia pada database lokal.
                            SPLP dikelola pada sistem/website lain sehingga
                            tidak tersedia sebagai jenis data pada Report Builder.
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- =================================================
             2. PILIH KOLOM
        ================================================== --}}

        <div class="laporan-section">

            <div class="laporan-section-header">

                <div class="laporan-section-title">

                    <i class="bi bi-layout-three-columns"></i>

                    <h3>2. Pilih Kolom</h3>

                </div>

            </div>

            <div class="laporan-section-body">

                <div class="kolom-container">

                    @foreach($kolomDiizinkan as $jenisKey => $columns)

                        <div
                            class="kolom-panel {{ in_array($jenisKey, $jenis ?? []) ? '' : 'hidden' }}"
                            data-kolom-panel="{{ $jenisKey }}"
                        >

                            <div class="kolom-panel-header">

                                <div class="kolom-panel-title">

                                    <i
                                        class="bi {{ $jenisConfig[$jenisKey]['icon'] ?? 'bi-table' }}"
                                    ></i>

                                    <strong>
                                        {{ $jenisLabel[$jenisKey] ?? ucfirst($jenisKey) }}
                                    </strong>

                                </div>

                                <div class="kolom-panel-actions">

                                    <button
                                        type="button"
                                        class="btn-mini btn-select-all"
                                        data-type="{{ $jenisKey }}"
                                    >
                                        Pilih Semua
                                    </button>

                                    <button
                                        type="button"
                                        class="btn-mini btn-reset-columns"
                                        data-type="{{ $jenisKey }}"
                                    >
                                        Reset
                                    </button>

                                </div>

                            </div>

                            <div class="kolom-panel-body">

                                <div class="kolom-grid">

                                    @foreach($columns as $columnKey => $columnLabel)

                                        <div class="kolom-item">

                                            <input
                                                type="checkbox"
                                                name="kolom[{{ $jenisKey }}][]"
                                                value="{{ $columnKey }}"
                                                id="kolom_{{ str_replace('-', '_', $jenisKey) }}_{{ $loop->index }}"
                                                class="column-checkbox"
                                                data-type="{{ $jenisKey }}"
                                                {{ in_array(
                                                    $columnKey,
                                                    $kolom[$jenisKey] ?? []
                                                ) ? 'checked' : '' }}
                                            >

                                            <label
                                                for="kolom_{{ str_replace('-', '_', $jenisKey) }}_{{ $loop->index }}"
                                            >

                                                <span class="kolom-check"></span>

                                                <span>
                                                    {{ $kolomDiizinkan[$jenisKey][$columnKey] ?? $columnLabel }}
                                                </span>

                                            </label>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>


        {{-- =================================================
             3. FILTER DATA
        ================================================== --}}

        <div class="laporan-section">

            <div class="laporan-section-header">

                <div class="laporan-section-title">

                    <i class="bi bi-funnel"></i>

                    <h3>3. Filter Data</h3>

                </div>

                <button
                    type="button"
                    class="filter-clear"
                    id="clearAllFilter"
                >
                    <i class="bi bi-x-circle me-1"></i>
                    Bersihkan Semua Filter
                </button>

            </div>

            <div class="laporan-section-body">

                <div class="filter-container">

                    {{-- =================================================
                         SEARCH UMUM
                    ================================================== --}}

                    <div class="filter-global">

                        <label for="filter_search">
                            Pencarian Umum
                        </label>

                        <div class="filter-global-input">

                            <i class="bi bi-search"></i>

                            <input
                                type="text"
                                id="filter_search"
                                name="filter[search]"
                                value="{{ $filter['search'] ?? request('filter.search', '') }}"
                                placeholder="Cari berdasarkan data yang tersedia..."
                                autocomplete="off"
                            >

                        </div>

                    </div>


                    {{-- =================================================
                         HARDWARE
                    ================================================== --}}

                    <div
                        class="filter-panel {{ in_array('hardware', $jenis ?? []) ? '' : 'hidden' }}"
                        data-filter-panel="hardware"
                    >

                        <div class="filter-panel-header">

                            <strong>
                                <i class="bi bi-pc-display"></i>
                                Filter Hardware
                            </strong>

                        </div>

                        <div class="filter-panel-body">

                            <div class="filter-grid">

                                <div class="filter-field">

                                    <label>Tahun Pembelian</label>

                                    <select
                                        name="filter[hardware_tahun]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Tahun
                                        </option>

                                        @foreach($filterOptions['hardware']['tahun'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['hardware_tahun'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>Kondisi</label>

                                    <select
                                        name="filter[hardware_kondisi]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Kondisi
                                        </option>

                                        @foreach($filterOptions['hardware']['kondisi'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['hardware_kondisi'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>Jenis Barang</label>

                                    <select
                                        name="filter[hardware_jenis]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Jenis
                                        </option>

                                        @foreach($filterOptions['hardware']['jenis'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['hardware_jenis'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>ID Lokasi</label>

                                    <input
                                        type="text"
                                        name="filter[hardware_lokasi]"
                                        class="filter-input"
                                        value="{{ $filter['hardware_lokasi'] ?? '' }}"
                                        placeholder="Masukkan ID lokasi..."
                                    >

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         SOFTWARE
                    ================================================== --}}

                    <div
                        class="filter-panel {{ in_array('software', $jenis ?? []) ? '' : 'hidden' }}"
                        data-filter-panel="software"
                    >

                        <div class="filter-panel-header">

                            <strong>
                                <i class="bi bi-window-stack"></i>
                                Filter Software
                            </strong>

                        </div>

                        <div class="filter-panel-body">

                            <div class="filter-grid">

                                <div class="filter-field">

                                    <label>Tahun Pengadaan</label>

                                    <select
                                        name="filter[software_tahun]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Tahun
                                        </option>

                                        @foreach($filterOptions['software']['tahun'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['software_tahun'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>Status</label>

                                    <select
                                        name="filter[software_status]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Status
                                        </option>

                                        @foreach($filterOptions['software']['status'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['software_status'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>Kategori</label>

                                    <select
                                        name="filter[software_kategori]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Kategori
                                        </option>

                                        @foreach($filterOptions['software']['kategori'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['software_kategori'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>Pengadaan</label>

                                    <select
                                        name="filter[software_pengadaan]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Pengadaan
                                        </option>

                                        @foreach($filterOptions['software']['pengadaan'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['software_pengadaan'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>PIC</label>

                                    <input
                                        type="text"
                                        name="filter[software_pic]"
                                        class="filter-input"
                                        value="{{ $filter['software_pic'] ?? '' }}"
                                        placeholder="Cari PIC..."
                                    >

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         JARINGAN
                    ================================================== --}}

                    <div
                        class="filter-panel {{ in_array('jaringan', $jenis ?? []) ? '' : 'hidden' }}"
                        data-filter-panel="jaringan"
                    >

                        <div class="filter-panel-header">

                            <strong>
                                <i class="bi bi-diagram-3"></i>
                                Filter Jaringan
                            </strong>

                        </div>

                        <div class="filter-panel-body">

                            <div class="filter-grid">

                                <div class="filter-field">

                                    <label>Jenis Data</label>

                                    <select
                                        name="filter[jaringan_jenis]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Jenis
                                        </option>

                                        @foreach(collect($filterOptions['jaringan']['jenis'] ?? [])->filter(fn ($value) => filled($value))->unique()->values() as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ (string) ($filter['jaringan_jenis'] ?? '') === (string) $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>Lokasi</label>

                                    <input
                                        type="text"
                                        name="filter[jaringan_lokasi]"
                                        class="filter-input"
                                        value="{{ $filter['jaringan_lokasi'] ?? '' }}"
                                        placeholder="Cari lokasi..."
                                    >

                                </div>


                                <div class="filter-field">

                                    <label>Verifikasi</label>

                                    <select
                                        name="filter[jaringan_verifikasi]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Status
                                        </option>

                                        @foreach($filterOptions['jaringan']['verifikasi'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['jaringan_verifikasi'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         DATA CENTER
                    ================================================== --}}

                    <div
                        class="filter-panel {{ in_array('data-center', $jenis ?? []) ? '' : 'hidden' }}"
                        data-filter-panel="data-center"
                    >

                        <div class="filter-panel-header">

                            <strong>
                                <i class="bi bi-server"></i>
                                Filter Data Center
                            </strong>

                        </div>

                        <div class="filter-panel-body">

                            <div class="filter-grid">

                                <div class="filter-field">

                                    <label>Tahun</label>

                                    <select
                                        name="filter[datacenter_tahun]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Tahun
                                        </option>

                                        @foreach($filterOptions['data-center']['tahun'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['datacenter_tahun'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>Status</label>

                                    <select
                                        name="filter[datacenter_status]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Status
                                        </option>

                                        @foreach($filterOptions['data-center']['status'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['datacenter_status'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>Tenant</label>

                                    <select
                                        name="filter[datacenter_tenant]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Tenant
                                        </option>

                                        @foreach($filterOptions['data-center']['tenant'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['datacenter_tenant'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>Site</label>

                                    <select
                                        name="filter[datacenter_site]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Site
                                        </option>

                                        @foreach($filterOptions['data-center']['site'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['datacenter_site'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>Rack</label>

                                    <select
                                        name="filter[datacenter_rack]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Rack
                                        </option>

                                        @foreach($filterOptions['data-center']['rack'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['datacenter_rack'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>Region</label>

                                    <select
                                        name="filter[datacenter_region]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Region
                                        </option>

                                        @foreach($filterOptions['data-center']['region'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['datacenter_region'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>Manufacturer</label>

                                    <select
                                        name="filter[datacenter_manufacturer]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Manufacturer
                                        </option>

                                        @foreach($filterOptions['data-center']['manufacturer'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['datacenter_manufacturer'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>Verifikasi</label>

                                    <select
                                        name="filter[datacenter_verifikasi]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Status
                                        </option>

                                        @foreach($filterOptions['data-center']['verifikasi'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['datacenter_verifikasi'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         DATA
                    ================================================== --}}

                    <div
                        class="filter-panel {{ in_array('data', $jenis ?? []) ? '' : 'hidden' }}"
                        data-filter-panel="data"
                    >

                        <div class="filter-panel-header">

                            <strong>
                                <i class="bi bi-database"></i>
                                Filter Data
                            </strong>

                        </div>

                        <div class="filter-panel-body">

                            <div class="filter-grid">

                                <div class="filter-field">

                                    <label>Tahun</label>

                                    <select
                                        name="filter[data_tahun]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Tahun
                                        </option>

                                        @foreach($filterOptions['data']['tahun'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['data_tahun'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>Topik</label>

                                    <select
                                        name="filter[data_topik]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Topik
                                        </option>

                                        @foreach($filterOptions['data']['topik'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['data_topik'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>Verifikasi</label>

                                    <select
                                        name="filter[data_verifikasi]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Status
                                        </option>

                                        @foreach($filterOptions['data']['verifikasi'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['data_verifikasi'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         SDM
                    ================================================== --}}

                    <div
                        class="filter-panel {{ in_array('sdm', $jenis ?? []) ? '' : 'hidden' }}"
                        data-filter-panel="sdm"
                    >

                        <div class="filter-panel-header">

                            <strong>
                                <i class="bi bi-people"></i>
                                Filter SDM
                            </strong>

                        </div>

                        <div class="filter-panel-body">

                            <div class="filter-grid">

                                <div class="filter-field">

                                    <label>Jenis Pegawai</label>

                                    <select
                                        name="filter[sdm_jenis_pegawai]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Jenis
                                        </option>

                                        @foreach($filterOptions['sdm']['jenis_pegawai'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['sdm_jenis_pegawai'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>


                                <div class="filter-field">

                                    <label>Jabatan</label>

                                    <select
                                        name="filter[sdm_jabatan]"
                                        class="filter-select"
                                    >

                                        <option value="">
                                            Semua Jabatan
                                        </option>

                                        @foreach($filterOptions['sdm']['jabatan'] ?? [] as $value)

                                            <option
                                                value="{{ $value }}"
                                                {{ ($filter['sdm_jabatan'] ?? '') == $value ? 'selected' : '' }}
                                            >
                                                {{ $value }}
                                            </option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =================================================
             4. PREVIEW
        ================================================== --}}

        <div class="laporan-section">

            <div class="laporan-section-header">

                <div class="laporan-section-title">

                    <i class="bi bi-table"></i>

                    <h3>4. Preview Laporan</h3>

                </div>


                {{-- =================================================
                     ACTION PREVIEW
                ================================================== --}}

                <div class="laporan-actions">

                    <button
                        type="button"
                        class="btn-laporan btn-excel"
                        id="btnDownloadExcel"
                    >
                        <i class="bi bi-file-earmark-excel me-1"></i>
                        Download Excel
                    </button>

                    <span
                        class="preview-auto-status"
                        id="previewStatusBottom"
                    >
                        <span class="status-dot"></span>
                        Otomatis
                    </span>

                </div>

            </div>

            <div class="laporan-section-body">

                <div
                    id="previewContainer"
                    class="preview-container"
                >

                    @if(empty($jenis))

                        <div class="preview-empty">

                            <i class="bi bi-bar-chart-line"></i>

                            <strong>
                                Belum ada data untuk ditampilkan
                            </strong>

                            <span>
                                Pilih minimal satu jenis data di atas
                                untuk melihat preview laporan.
                            </span>

                        </div>

                    @else

                        @if(!empty($peringatan))

                            <div class="preview-warning">

                                @foreach($peringatan as $warning)

                                    <div>

                                        <i class="bi bi-exclamation-triangle me-1"></i>

                                        {{ $warning }}

                                    </div>

                                @endforeach

                            </div>

                        @endif


                        @forelse($hasil as $jenisHasil => $rows)

                            <div class="preview-block">

                                <h4 class="preview-title">
                                    {{ $jenisLabel[$jenisHasil] ?? ucfirst($jenisHasil) }}
                                </h4>

                                <p class="preview-meta">

                                    Menampilkan maksimal 100 data.
                                    Total hasil saat ini:
                                    {{ $rows->count() }}

                                </p>


                                @if($rows->count() > 0)

                                    @if(empty($kolom[$jenisHasil] ?? []))

                                        <div class="preview-empty-table">

                                            <i class="bi bi-layout-three-columns me-1"></i>

                                            Belum ada kolom yang dipilih untuk laporan ini.

                                        </div>

                                    @else

                                        <div class="preview-table-wrapper">

                                            <table class="preview-table">

                                                <thead>

                                                    <tr>

                                                        @foreach($kolom[$jenisHasil] ?? [] as $column)

                                                            <th>

                                                                {{ $kolomDiizinkan[$jenisHasil][$column] ?? ucwords(str_replace('_', ' ', $column)) }}

                                                            </th>

                                                        @endforeach

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    @foreach($rows as $row)

    <tr>

        @foreach($kolom[$jenisHasil] ?? [] as $column)

            @php

                $value = $row->{$column} ?? null;

                /*
                 * Format field tanggal dan waktu
                 */
                if (
                    $value !== null &&
                    $value !== '' &&
                    in_array($column, [
                        'created_at',
                        'updated_at',
                        'tanggal_pengadaan',
                        'tanggal_berakhir',
                        'tanggal_pengajuan',
                        'masa_berlaku',
                    ])
                ) {
                    try {

                        $date = \Carbon\Carbon::parse($value);

                        /*
                         * Field yang hanya menampilkan tanggal
                         */
                        if (in_array($column, [
                            'tanggal_pengadaan',
                            'tanggal_berakhir',
                            'tanggal_pengajuan',
                        ])) {

                            $value = $date
                                ->locale('id')
                                ->translatedFormat('d F Y');

                        }

                        /*
                         * Field yang menampilkan tanggal + waktu
                         */
                        else {

                            $value = $date
                                ->locale('id')
                                ->translatedFormat('d F Y, H:i');

                        }

                    } catch (\Throwable $e) {

                        // Jika bukan format tanggal, tampilkan nilai asli

                    }
                }

            @endphp

            <td>

                @if(is_array($value))

                    {{ json_encode($value, JSON_UNESCAPED_UNICODE) }}

                @elseif(is_object($value))

                    {{ json_encode($value, JSON_UNESCAPED_UNICODE) }}

                @elseif($value === null || $value === '')

                    -

                @else

                    {{ $value }}

                @endif

            </td>

        @endforeach

    </tr>

@endforeach

                                                </tbody>

                                            </table>

                                        </div>

                                    @endif

                                @else

                                    <div class="preview-empty-table">

                                        <i class="bi bi-inbox me-1"></i>

                                        Tidak ada data yang sesuai dengan filter.

                                    </div>

                                @endif

                            </div>

                        @empty

                            <div class="preview-empty">

                                <i class="bi bi-inbox"></i>

                                <strong>
                                    Tidak ada data
                                </strong>

                                <span>
                                    Tidak ditemukan data yang sesuai dengan filter.
                                </span>

                            </div>

                        @endforelse

                    @endif

                </div>


                <div class="laporan-footer-info">

                    Preview menampilkan maksimal 100 data per jenis laporan.
                    Perubahan filter dan pilihan kolom akan memperbarui preview otomatis.

                </div>

            </div>

        </div>

    </form>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const form =
        document.getElementById('laporanForm');

    const previewContainer =
        document.getElementById('previewContainer');

    const resetButton =
        document.getElementById('btnReset');

    const downloadExcelButton =
        document.getElementById('btnDownloadExcel');

    const clearAllFilterButton =
        document.getElementById('clearAllFilter');

    const previewStatus =
        document.getElementById('previewStatus');

    const previewStatusBottom =
        document.getElementById('previewStatusBottom');

    let previewController = null;

    let searchTimer = null;


    /* =========================================================
       STATUS PREVIEW
    ========================================================= */

    function setLoadingStatus(isLoading) {

        [
            previewStatus,
            previewStatusBottom
        ].forEach(function (element) {

            if (!element) {
                return;
            }

            if (isLoading) {

                element.classList.add('loading');

                if (element.id === 'previewStatus') {

                    element.innerHTML =
                        '<span class="status-dot"></span> Memperbarui preview...';

                } else {

                    element.innerHTML =
                        '<span class="status-dot"></span> Memuat...';

                }

            } else {

                element.classList.remove('loading');

                if (element.id === 'previewStatus') {

                    element.innerHTML =
                        '<span class="status-dot"></span> Preview otomatis aktif';

                } else {

                    element.innerHTML =
                        '<span class="status-dot"></span> Otomatis';

                }

            }

        });

    }


    /* =========================================================
       AMBIL PARAMETER FORM
    ========================================================= */

    function getFormQueryString() {

        const formData =
            new FormData(form);

        const params =
            new URLSearchParams();

        for (const [key, value] of formData.entries()) {

            if (value === '') {
                continue;
            }

            params.append(
                key,
                value
            );

        }

        return params;

    }


    /* =========================================================
       UPDATE URL BROWSER
    ========================================================= */

    function updateBrowserUrl(params) {

        const queryString =
            params.toString();

        const targetUrl =
            "{{ route('laporan.index') }}" +
            (
                queryString
                    ? '?' + queryString
                    : ''
            );

        window.history.replaceState(
            {},
            '',
            targetUrl
        );

    }


    /* =========================================================
       REFRESH PREVIEW
    ========================================================= */

    async function refreshPreview() {

        if (
            !form ||
            !previewContainer
        ) {
            return;
        }


        /*
        | Batalkan request sebelumnya.
        */

        if (previewController) {

            previewController.abort();

        }


        previewController =
            new AbortController();


        const params =
            getFormQueryString();


        /*
        | URL browser ikut berubah.
        */

        updateBrowserUrl(params);


        setLoadingStatus(true);


        previewContainer.innerHTML = `
            <div class="preview-loading">

                <div class="preview-spinner"></div>

                <span>
                    Memperbarui preview laporan...
                </span>

            </div>
        `;


        try {

            const queryString =
                params.toString();


            const url =
                "{{ route('laporan.preview') }}" +
                (
                    queryString
                        ? '?' + queryString
                        : ''
                );


            const response =
                await fetch(
                    url,
                    {
                        method: 'GET',

                        headers: {
                            'X-Requested-With':
                                'XMLHttpRequest',

                            'Accept':
                                'application/json'
                        },

                        credentials:
                            'same-origin',

                        signal:
                            previewController.signal
                    }
                );


            if (!response.ok) {

                throw new Error(
                    'HTTP ' +
                    response.status
                );

            }


            const result =
                await response.json();


            if (!result.success) {

                throw new Error(
                    result.message ||
                    'Preview gagal diperbarui.'
                );

            }


            const parser =
                new DOMParser();


            const documentResponse =
                parser.parseFromString(
                    result.html,
                    'text/html'
                );


            const newPreview =
                documentResponse.getElementById(
                    'previewContainer'
                );


            if (!newPreview) {

                throw new Error(
                    'Container preview tidak ditemukan pada response.'
                );

            }


            previewContainer.innerHTML =
                newPreview.innerHTML;


            setLoadingStatus(false);


        } catch (error) {

            if (
                error.name ===
                'AbortError'
            ) {

                return;

            }


            console.error(
                'Laporan preview error:',
                error
            );


            previewContainer.innerHTML = `

                <div class="preview-empty">

                    <i class="bi bi-exclamation-triangle"></i>

                    <strong>
                        Preview gagal diperbarui
                    </strong>

                    <span>
                        Silakan coba lagi atau periksa koneksi aplikasi.
                    </span>

                </div>

            `;


            setLoadingStatus(false);

        }

    }


    /* =========================================================
       TOGGLE PANEL JENIS
    ========================================================= */

    function updateJenisPanels() {

        const selectedTypes =
            Array.from(
                document.querySelectorAll(
                    '.jenis-checkbox:checked'
                )
            ).map(function (checkbox) {

                return checkbox.value;

            });


        /*
        | Panel kolom
        */

        document
            .querySelectorAll(
                '[data-kolom-panel]'
            )
            .forEach(function (panel) {

                const type =
                    panel.dataset.kolomPanel;


                if (
                    selectedTypes.includes(type)
                ) {

                    panel.classList.remove(
                        'hidden'
                    );

                } else {

                    panel.classList.add(
                        'hidden'
                    );

                }

            });


        /*
        | Panel filter
        */

        document
            .querySelectorAll(
                '[data-filter-panel]'
            )
            .forEach(function (panel) {

                const type =
                    panel.dataset.filterPanel;


                if (
                    selectedTypes.includes(type)
                ) {

                    panel.classList.remove(
                        'hidden'
                    );

                } else {

                    panel.classList.add(
                        'hidden'
                    );

                }

            });

    }


    /* =========================================================
       JENIS DATA BERUBAH
    ========================================================= */

    document
        .querySelectorAll(
            '.jenis-checkbox'
        )
        .forEach(function (checkbox) {

            checkbox.addEventListener(
                'change',
                function () {

                    updateJenisPanels();

                    refreshPreview();

                }
            );

        });


    /* =========================================================
       KOLOM BERUBAH
    ========================================================= */

    document
        .querySelectorAll(
            '.column-checkbox'
        )
        .forEach(function (checkbox) {

            checkbox.addEventListener(
                'change',
                function () {

                    refreshPreview();

                }
            );

        });


    /* =========================================================
       PILIH SEMUA KOLOM
    ========================================================= */

    document
        .querySelectorAll(
            '.btn-select-all'
        )
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function () {

                    const type =
                        this.dataset.type;


                    document
                        .querySelectorAll(
                            '.column-checkbox[data-type="' +
                            type +
                            '"]'
                        )
                        .forEach(function (checkbox) {

                            checkbox.checked =
                                true;

                        });


                    refreshPreview();

                }
            );

        });


    /* =========================================================
       RESET KOLOM PER JENIS
    ========================================================= */

    document
        .querySelectorAll(
            '.btn-reset-columns'
        )
        .forEach(function (button) {

            button.addEventListener(
                'click',
                function () {

                    const type =
                        this.dataset.type;


                    document
                        .querySelectorAll(
                            '.column-checkbox[data-type="' +
                            type +
                            '"]'
                        )
                        .forEach(function (checkbox) {

                            checkbox.checked =
                                false;

                        });


                    refreshPreview();

                }
            );

        });


    /* =========================================================
       FILTER SELECT
    ========================================================= */

    document
        .querySelectorAll(
            '.filter-select'
        )
        .forEach(function (select) {

            select.addEventListener(
                'change',
                function () {

                    refreshPreview();

                }
            );

        });


    /* =========================================================
       FILTER INPUT
    ========================================================= */

    document
        .querySelectorAll(
            '.filter-input'
        )
        .forEach(function (input) {

            input.addEventListener(
                'input',
                function () {

                    clearTimeout(
                        searchTimer
                    );


                    searchTimer =
                        setTimeout(
                            function () {

                                refreshPreview();

                            },
                            350
                        );

                }
            );

        });


    /* =========================================================
       SEARCH GLOBAL
    ========================================================= */

    const globalSearch =
        document.getElementById(
            'filter_search'
        );


    if (globalSearch) {

        globalSearch.addEventListener(
            'input',
            function () {

                clearTimeout(
                    searchTimer
                );


                searchTimer =
                    setTimeout(
                        function () {

                            refreshPreview();

                        },
                        350
                    );

            }
        );

    }


    /* =========================================================
       BERSIHKAN SEMUA FILTER
    ========================================================= */

    if (clearAllFilterButton) {

        clearAllFilterButton.addEventListener(
            'click',
            function () {

                /*
                | Reset semua select.
                */

                document
                    .querySelectorAll(
                        '.filter-select'
                    )
                    .forEach(function (select) {

                        select.value = '';

                    });


                /*
                | Reset semua input filter.
                */

                document
                    .querySelectorAll(
                        '.filter-input'
                    )
                    .forEach(function (input) {

                        input.value = '';

                    });


                /*
                | Reset pencarian umum.
                */

                if (globalSearch) {

                    globalSearch.value = '';

                }


                refreshPreview();

            }
        );

    }


    /* =========================================================
       RESET SELURUH LAPORAN
    ========================================================= */

    if (resetButton) {

        resetButton.addEventListener(
            'click',
            function () {

                if (previewController) {

                    previewController.abort();

                }


                window.location.href =
                    "{{ route('laporan.index') }}";

            }
        );

    }


    /* =========================================================
       DOWNLOAD EXCEL
    ========================================================= */

    if (downloadExcelButton) {

        downloadExcelButton.addEventListener(
            'click',
            function () {

                /*
                | Ambil semua pilihan yang sedang aktif
                | dari Report Builder.
                */

                const params =
                    getFormQueryString();


                /*
                | Pastikan minimal ada jenis data.
                */

                const selectedTypes =
                    document.querySelectorAll(
                        '.jenis-checkbox:checked'
                    );


                if (selectedTypes.length === 0) {

                    alert(
                        'Pilih minimal satu jenis data terlebih dahulu.'
                    );

                    return;

                }


                /*
                | Pastikan minimal ada kolom
                | yang dipilih pada jenis data.
                */

                let selectedColumns = 0;

                document
                    .querySelectorAll(
                        '.column-checkbox:checked'
                    )
                    .forEach(function () {

                        selectedColumns++;

                    });


                if (selectedColumns === 0) {

                    alert(
                        'Pilih minimal satu kolom untuk laporan terlebih dahulu.'
                    );

                    return;

                }


                /*
                | Nonaktifkan tombol sementara.
                */

                downloadExcelButton.disabled =
                    true;


                downloadExcelButton.innerHTML =
                    '<i class="bi bi-hourglass-split me-1"></i>' +
                    'Menyiapkan Excel...';


                /*
                | Buat URL export dengan parameter
                | yang sama persis dengan preview.
                */

                const queryString =
                    params.toString();


                const exportUrl =
                    "{{ route('laporan.export.excel') }}" +
                    (
                        queryString
                            ? '?' + queryString
                            : ''
                    );


                /*
                | Jalankan download Excel.
                */

                window.location.href =
                    exportUrl;


                /*
                | Kembalikan tombol.
                */

                setTimeout(
                    function () {

                        downloadExcelButton.disabled =
                            false;


                        downloadExcelButton.innerHTML =
                            '<i class="bi bi-file-earmark-excel me-1"></i>' +
                            'Download Excel';

                    },
                    2000
                );

            }
        );

    }


    /* =========================================================
       CEGAH SUBMIT FORM NORMAL
    ========================================================= */

    form.addEventListener(
        'submit',
        function (event) {

            event.preventDefault();

            refreshPreview();

        }
    );


    /* =========================================================
       INITIAL STATE
    ========================================================= */

    updateJenisPanels();


    const initialTypes =
        document.querySelectorAll(
            '.jenis-checkbox:checked'
        );


    if (initialTypes.length > 0) {

        refreshPreview();

    }

});
</script>

@endsection
@extends('layouts.app')

@section('title', 'Jaringan')
@section('page-title', 'Jaringan')

@section('content')

<style>
/* =========================================================
   JARINGAN PAGE
========================================================= */

.jaringan-page {
    width: 100%;
}

/* =========================================================
   HEADER
========================================================= */

.jaringan-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.jaringan-heading h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
}

.jaringan-heading p {
    margin: 6px 0 0;
    font-size: 13px;
    color: #6b7280;
}

.add-jaringan-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    height: 38px;
    padding: 0 15px;

    border: none;
    border-radius: 8px;

    background: #071b88;
    color: #ffffff;

    font-size: 12px;
    font-weight: 600;

    cursor: pointer;
    white-space: nowrap;

    box-shadow: 0 2px 5px rgba(37, 99, 235, 0.18);
    transition: 0.2s ease;
}

.add-jaringan-button:hover {
    background: #050f63;
    transform: translateY(-1px);
}

.add-jaringan-button i {
    font-size: 13px;
}

/* =========================================================
   ALERT
========================================================= */

.alert-success,
.alert-error {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 15px;
    border-radius: 9px;
    margin-bottom: 20px;
    font-size: 13px;
}

.alert-success {
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    color: #047857;
}

.alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #b91c1c;
}

/* =========================================================
   STATISTICS
========================================================= */

.jaringan-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 25px;
}

.jaringan-stat-card {
    min-height: 125px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 20px;
    display: flex;
    align-items: flex-start;
    gap: 15px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
}

.jaringan-stat-icon {
    width: 45px;
    height: 45px;
    flex-shrink: 0;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.jaringan-stat-icon.blue {
    background: #e0f2fe;
    color: #0284c7;
}

.jaringan-stat-icon.purple {
    background: #ede9fe;
    color: #7c3aed;
}

.jaringan-stat-icon.orange {
    background: #ffedd5;
    color: #ea580c;
}

.jaringan-stat-icon.green {
    background: #dcfce7;
    color: #16a34a;
}

.jaringan-stat-content {
    display: flex;
    flex-direction: column;
}

.jaringan-stat-label {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 5px;
}

.jaringan-stat-value {
    font-size: 23px;
    font-weight: 700;
    color: #075985;
    line-height: 1.2;
}

.jaringan-stat-description {
    margin-top: 7px;
    font-size: 10px;
    color: #9ca3af;
}

/* =========================================================
   TABLE CARD
========================================================= */

.jaringan-table-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.04);
}

.jaringan-table-header {
    padding: 20px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    border-bottom: 1px solid #e5e7eb;
}

.jaringan-table-header-left {
    display: flex;
    align-items: center;
    gap: 8px;
}

.jaringan-table-title {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
}

.jaringan-table-count {
    font-size: 12px;
    color: #6b7280;
}

/* =========================================================
   TOOLBAR
========================================================= */

.jaringan-toolbar {
    display: flex;
    align-items: center;
    gap: 9px;
}

.jaringan-search {
    position: relative;
}

.jaringan-search i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 14px;
}

.jaringan-search input {
    width: 230px;
    height: 38px;
    padding: 0 12px 0 35px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    outline: none;
    font-size: 12px;
    color: #374151;
    background: white;
}

.jaringan-search input:focus {
    border-color: #079bd8;
    box-shadow: 0 0 0 3px rgba(7, 155, 216, 0.10);
}

.jaringan-filter-select {
    height: 38px;
    padding: 0 32px 0 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    background: white;
    color: #374151;
    font-size: 12px;
    outline: none;
    cursor: pointer;
}

/* =========================================================
   TABLE
========================================================= */

.jaringan-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.jaringan-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 1150px;
}

.jaringan-table th {
    padding: 14px 16px;
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    text-align: left;
    white-space: nowrap;
}

.jaringan-table td {
    padding: 15px 16px;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    font-size: 13px;
    vertical-align: middle;
}

.jaringan-table tbody tr:hover {
    background: #f8fafc;
}

.jaringan-table tbody tr:last-child td {
    border-bottom: none;
}

/* =========================================================
   ID
========================================================= */

.jaringan-code {
    font-weight: 700;
    color: #075985;
    white-space: nowrap;
}

/* =========================================================
   JENIS DATA
========================================================= */

.jenis-data-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.jenis-fo {
    background: #e0f2fe;
    color: #075985;
}

.jenis-local-loop {
    background: #ede9fe;
    color: #6d28d9;
}

/* =========================================================
   LOKASI
========================================================= */

.jaringan-name {
    font-weight: 600;
    color: #1f2937;
}

/* =========================================================
   VALUE
========================================================= */

.jaringan-value {
    color: #374151;
    white-space: nowrap;
}

.jaringan-empty {
    color: #9ca3af;
}

.jaringan-komentar {
    max-width: 260px;
    line-height: 1.5;
    color: #64748b;
}

/* =========================================================
   VERIFIKASI
========================================================= */

.verifikasi-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.verifikasi-menunggu {
    background: #fef3c7;
    color: #92400e;
}

.verifikasi-disetujui {
    background: #dcfce7;
    color: #166534;
}

.verifikasi-ditolak {
    background: #fee2e2;
    color: #991b1b;
}

/* =========================================================
   ACTION
========================================================= */

.jaringan-action-buttons {
    display: flex;
    align-items: center;
    gap: 7px;
}

.jaringan-action-button {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 7px;
    border: none;
    cursor: pointer;
    transition: 0.2s ease;
}

.jaringan-edit-button {
    background: #e0f2fe;
    color: #075985;
}

.jaringan-edit-button:hover {
    background: #bae6fd;
}

.jaringan-delete-button {
    background: #fee2e2;
    color: #dc2626;
}

.jaringan-delete-button:hover {
    background: #fecaca;
}

.jaringan-action-button i {
    font-size: 14px;
}

.jaringan-delete-form {
    display: inline;
}

/* =========================================================
   EMPTY
========================================================= */

.jaringan-empty-state {
    padding: 55px 20px;
    text-align: center;
}

.jaringan-empty-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 15px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f1f5f9;
    color: #94a3b8;
}

.jaringan-empty-icon i {
    font-size: 27px;
}

.jaringan-empty-state h3 {
    margin: 0 0 6px;
    font-size: 15px;
    color: #374151;
}

.jaringan-empty-state p {
    margin: 0;
    font-size: 12px;
    color: #9ca3af;
}

/* =========================================================
   MODAL
========================================================= */

.jaringan-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 30px;
    background: rgba(15, 23, 42, 0.55);
    overflow-y: auto;
}

.jaringan-modal-overlay.show {
    display: flex;
}

.jaringan-modal {
    width: 100%;
    max-width: 700px;
    max-height: calc(100vh - 60px);
    background: white;
    border-radius: 16px;
    box-shadow: 0 25px 60px rgba(15, 23, 42, 0.25);
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.jaringan-modal-header {
    min-height: 78px;
    padding: 18px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #e5e7eb;
}

.jaringan-modal-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.jaringan-modal-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e0f2fe;
    color: #075985;
}

.jaringan-modal-header-text h2 {
    margin: 0;
    font-size: 17px;
    font-weight: 700;
    color: #1f2937;
}

.jaringan-modal-header-text p {
    margin: 4px 0 0;
    font-size: 11px;
    color: #6b7280;
}

.jaringan-modal-close {
    width: 34px;
    height: 34px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 8px;
    background: #f1f5f9;
    color: #64748b;
    cursor: pointer;
}

/* =========================================================
   FORM
========================================================= */

#jaringanForm {
    display: flex;
    flex-direction: column;
    min-height: 0;
}

.jaringan-modal-body {
    padding: 24px;
    overflow-y: auto;
    max-height: calc(100vh - 190px);
}

.jaringan-form-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 24px;
}

.jaringan-form-card-header {
    display: flex;
    align-items: center;
    gap: 9px;
    padding-bottom: 13px;
    margin-bottom: 20px;
    border-bottom: 1px solid #e5e7eb;
}

.jaringan-form-card-header i {
    color: #075985;
    font-size: 16px;
}

.jaringan-form-card-header h3 {
    margin: 0;
    font-size: 14px;
    font-weight: 700;
    color: #1f2937;
}

.jaringan-form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
}

.jaringan-form-group {
    display: flex;
    flex-direction: column;
}

.jaringan-form-group.full {
    grid-column: 1 / -1;
}

.jaringan-form-group label {
    margin-bottom: 7px;
    font-size: 12px;
    font-weight: 600;
    color: #374151;
}

.jaringan-form-group label span {
    color: #dc2626;
}

.jaringan-form-group input,
.jaringan-form-group select {
    width: 100%;
    box-sizing: border-box;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    background: white;
    color: #374151;
    outline: none;
    font-family: inherit;
    font-size: 12px;
}

.jaringan-form-group input,
.jaringan-form-group select {
    height: 40px;
    padding: 0 12px;
}

.jaringan-form-group input:focus,
.jaringan-form-group select:focus {
    border-color: #079bd8;
    box-shadow: 0 0 0 3px rgba(7, 155, 216, 0.10);
}

.jaringan-form-group input[readonly],
.jaringan-form-group select:disabled {
    background: #f8fafc;
    color: #64748b;
    cursor: not-allowed;
}

.jaringan-form-error {
    margin-top: 5px;
    font-size: 10px;
    color: #dc2626;
}

.jaringan-form-info {
    margin-top: 6px;
    font-size: 10px;
    line-height: 1.5;
    color: #9ca3af;
}

/* =========================================================
   DYNAMIC FIELD
========================================================= */

.jaringan-dynamic-fields {
    display: none;
}

.jaringan-dynamic-fields.show {
    display: contents;
}

/* =========================================================
   FOOTER
========================================================= */

.jaringan-modal-footer {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
    padding: 16px 24px;
    border-top: 1px solid #e5e7eb;
    background: white;
}

.jaringan-btn-batal,
.jaringan-btn-simpan {
    height: 40px;
    padding: 0 18px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
}

.jaringan-btn-batal {
    border: 1px solid #d1d5db;
    background: white;
    color: #4b5563;
}

.jaringan-btn-simpan {
    border: none;
    background: #079bd8;
    color: white;
}

.jaringan-btn-simpan:hover {
    background: #075985;
}

/* =========================================================
   BODY LOCK
========================================================= */

body.jaringan-modal-open {
    overflow: hidden;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1100px) {
    .jaringan-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 800px) {
    .jaringan-header {
        align-items: flex-start;
        flex-direction: column;
        gap: 15px;
    }

    .add-jaringan-button {
        width: 100%;
    }

    .jaringan-table-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .jaringan-toolbar {
        width: 100%;
        flex-wrap: wrap;
    }

    .jaringan-search {
        flex: 1;
    }

    .jaringan-search input {
        width: 100%;
    }
}

@media (max-width: 600px) {
    .jaringan-stats {
        grid-template-columns: 1fr;
    }

    .jaringan-form-grid {
        grid-template-columns: 1fr;
    }

    .jaringan-modal-overlay {
        padding: 15px;
    }

    .jaringan-modal {
        max-height: calc(100vh - 30px);
    }

    .jaringan-modal-body {
        padding: 15px;
    }
}
</style>


<div class="jaringan-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="jaringan-header">

        <div class="jaringan-heading">
            <h2>Jaringan</h2>

            <p>
                Kelola data infrastruktur jaringan.
            </p>
        </div>

    </div>


    {{-- =====================================================
         SUCCESS
    ====================================================== --}}

    @if(session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle-fill"></i>

            <span>
                {{ session('success') }}
            </span>
        </div>
    @endif


    {{-- =====================================================
         ERROR
    ====================================================== --}}

    @if(session('error'))
        <div class="alert-error">
            <i class="bi bi-exclamation-circle-fill"></i>

            <span>
                {{ session('error') }}
            </span>
        </div>
    @endif


    {{-- =====================================================
         VALIDATION ERROR
    ====================================================== --}}

    @if($errors->any())
        <div class="alert-error">

            <i class="bi bi-exclamation-triangle-fill"></i>

            <div>
                <strong>
                    Data belum dapat disimpan.
                </strong>

                <div style="margin-top:3px;">
                    {{ $errors->first() }}
                </div>
            </div>

        </div>
    @endif


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="jaringan-stats">

        <div class="jaringan-stat-card">

            <div class="jaringan-stat-icon blue">
                <i class="bi bi-diagram-3-fill"></i>
            </div>

            <div class="jaringan-stat-content">

                <span class="jaringan-stat-label">
                    Total Jaringan
                </span>

                <span class="jaringan-stat-value">
                    {{ $totalJaringan }}
                </span>

                <span class="jaringan-stat-description">
                    Seluruh data jaringan
                </span>

            </div>

        </div>


        <div class="jaringan-stat-card">

            <div class="jaringan-stat-icon purple">
                <i class="bi bi-bezier2"></i>
            </div>

            <div class="jaringan-stat-content">

                <span class="jaringan-stat-label">
                    Jalur Kabel FO
                </span>

                <span class="jaringan-stat-value">
                    {{ $totalFO }}
                </span>

                <span class="jaringan-stat-description">
                    Data jalur kabel fiber optic
                </span>

            </div>

        </div>


        <div class="jaringan-stat-card">

            <div class="jaringan-stat-icon orange">
                <i class="bi bi-share-fill"></i>
            </div>

            <div class="jaringan-stat-content">

                <span class="jaringan-stat-label">
                    Local Loop Sewa
                </span>

                <span class="jaringan-stat-value">
                    {{ $totalLocalLoop }}
                </span>

                <span class="jaringan-stat-description">
                    Data titik local loop
                </span>

            </div>

        </div>


        <div class="jaringan-stat-card">

            <div class="jaringan-stat-icon green">
                <i class="bi bi-shield-check"></i>
            </div>

            <div class="jaringan-stat-content">

                <span class="jaringan-stat-label">
                    Menunggu Verifikasi
                </span>

                <span class="jaringan-stat-value">
                    {{ $menunggu }}
                </span>

                <span class="jaringan-stat-description">
                    Data menunggu pemeriksaan
                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="jaringan-table-card">

        <div class="jaringan-table-header">

            <div class="jaringan-table-header-left">

                <h3 class="jaringan-table-title">
                    Data Jaringan
                </h3>

                <span class="jaringan-table-count">
                    ({{ $jaringans->count() }} data)
                </span>

            </div>


            <div class="jaringan-toolbar">

                {{-- SEARCH --}}

                <div class="jaringan-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        id="jaringanSearch"
                        placeholder="Cari ID, jenis data, lokasi..."
                    >

                </div>


                {{-- FILTER JENIS --}}

                <select
                    id="jaringanJenisFilter"
                    class="jaringan-filter-select"
                >
                    <option value="">
                        Semua Jenis
                    </option>

                    <option value="Jalur Kabel FO">
                        Jalur Kabel FO
                    </option>

                    <option value="Local Loop Sewa">
                        Local Loop Sewa
                    </option>
                </select>


                {{-- FILTER VERIFIKASI --}}

                <select
                    id="jaringanVerifikasiFilter"
                    class="jaringan-filter-select"
                >
                    <option value="">
                        Semua Verifikasi
                    </option>

                    <option value="menunggu">
                        Menunggu
                    </option>

                    <option value="disetujui">
                        Disetujui
                    </option>

                    <option value="ditolak">
                        Ditolak
                    </option>
                </select>


                {{-- TAMBAH JARINGAN --}}

                <button
                    type="button"
                    class="add-jaringan-button"
                    onclick="openAddJaringanModal()"
                >
                    <i class="bi bi-plus-lg"></i>
                    <span>Tambah Jaringan</span>
                </button>

            </div>

        </div>


        <div class="jaringan-table-wrapper">

            <table class="jaringan-table">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Jenis Data</th>
                        <th>Lokasi</th>
                        <th>Jarak</th>
                        <th>Core</th>
                        <th>Titik</th>
                        <th>Verifikasi</th>
                        <th>Komentar</th>
                        <th>Aksi</th>
                    </tr>

                </thead>


                <tbody id="jaringanTableBody">

                    @forelse($jaringans as $jaringan)

                        @php

                            $jenisData =
                                $jaringan->jenis_data;

                            $verifikasi =
                                strtolower(
                                    (string) (
                                        $jaringan->verifikasi
                                        ?? 'menunggu'
                                    )
                                );

                            $verifikasiLabel =
                                match ($verifikasi) {

                                    'disetujui'
                                        => 'Disetujui',

                                    'ditolak'
                                        => 'Ditolak',

                                    default
                                        => 'Menunggu',
                                };

                            $verifikasiClass =
                                match ($verifikasi) {

                                    'disetujui'
                                        => 'verifikasi-disetujui',

                                    'ditolak'
                                        => 'verifikasi-ditolak',

                                    default
                                        => 'verifikasi-menunggu',
                                };

                            $jenisClass =
                                $jenisData === 'Jalur Kabel FO'
                                    ? 'jenis-fo'
                                    : 'jenis-local-loop';

                        @endphp


                        <tr
                            data-search="{{ strtolower(
                                ($jaringan->id ?? '') . ' ' .
                                ($jaringan->jenis_data ?? '') . ' ' .
                                ($jaringan->lokasi ?? '')
                            ) }}"
                            data-jenis="{{ $jenisData }}"
                            data-verifikasi="{{ $verifikasi }}"
                        >

                            {{-- NO --}}

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            {{-- ID --}}

                            <td>
                                <span class="jaringan-code">
                                    {{ $jaringan->id }}
                                </span>
                            </td>


                            {{-- JENIS DATA --}}

                            <td>
                                <span
                                    class="jenis-data-badge {{ $jenisClass }}"
                                >
                                    {{ $jenisData }}
                                </span>
                            </td>


                            {{-- LOKASI --}}

                            <td>
                                <div class="jaringan-name">
                                    {{ $jaringan->lokasi }}
                                </div>
                            </td>


                            {{-- JARAK --}}

                            <td>

                                @if($jaringan->jarak_kabel !== null)

                                    <span class="jaringan-value">
                                        {{ number_format(
                                            (float) $jaringan->jarak_kabel,
                                            2,
                                            ',',
                                            '.'
                                        ) }}
                                        m
                                    </span>

                                @else

                                    <span class="jaringan-empty">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- CORE --}}

                            <td>

                                @if($jaringan->jumlah_core !== null)

                                    <span class="jaringan-value">
                                        {{ $jaringan->jumlah_core }}
                                        core
                                    </span>

                                @else

                                    <span class="jaringan-empty">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- TITIK --}}

                            <td>

                                @if($jaringan->jumlah_titik !== null)

                                    <span class="jaringan-value">
                                        {{ number_format(
                                            $jaringan->jumlah_titik,
                                            0,
                                            ',',
                                            '.'
                                        ) }}
                                    </span>

                                @else

                                    <span class="jaringan-empty">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- VERIFIKASI --}}

                            <td>

                                <span
                                    class="verifikasi-badge {{ $verifikasiClass }}"
                                >
                                    {{ $verifikasiLabel }}
                                </span>

                            </td>


                            {{-- KOMENTAR VERIFIKATOR --}}

                            <td>

                                @if($jaringan->komentar)

                                    <div
                                        class="jaringan-komentar"
                                        title="{{ $jaringan->komentar }}"
                                    >
                                        {{ $jaringan->komentar }}
                                    </div>

                                @else

                                    <span class="jaringan-empty">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}

                            <td>

                                <div class="jaringan-action-buttons">

                                    {{-- EDIT --}}

                                    <button
                                        type="button"
                                        class="jaringan-action-button jaringan-edit-button"
                                        title="Edit"
                                        onclick="openEditJaringanModal(@js($jaringan->id))"
                                    >
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>


                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route(
                                            'jaringan.destroy',
                                            $jaringan->id
                                        ) }}"
                                        method="POST"
                                        class="jaringan-delete-form"
                                        onsubmit="return confirm(
                                            'Yakin ingin menghapus data jaringan ini?'
                                        );"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="jaringan-action-button jaringan-delete-button"
                                            title="Hapus"
                                        >
                                            <i class="bi bi-trash-fill"></i>
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="10"
                                style="padding:0;"
                            >

                                <div class="jaringan-empty-state">

                                    <div class="jaringan-empty-icon">
                                        <i class="bi bi-wifi-off"></i>
                                    </div>

                                    <h3>
                                        Belum ada data jaringan
                                    </h3>

                                    <p>
                                        Data infrastruktur jaringan belum tersedia.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- =========================================================
     MODAL TAMBAH / EDIT
========================================================= --}}

<div
    id="jaringanModal"
    class="jaringan-modal-overlay"
    aria-hidden="true"
>

    <div
        class="jaringan-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="jaringanModalTitle"
    >

        {{-- HEADER --}}

        <div class="jaringan-modal-header">

            <div class="jaringan-modal-header-left">

                <div class="jaringan-modal-icon">
                    <i class="bi bi-diagram-3-fill"></i>
                </div>

                <div class="jaringan-modal-header-text">

                    <h2 id="jaringanModalTitle">
                        Tambah Jaringan
                    </h2>

                    <p id="jaringanModalDescription">
                        Masukkan data infrastruktur jaringan baru.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="jaringan-modal-close"
                onclick="closeJaringanModal()"
                title="Tutup"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>


        {{-- FORM --}}

        <form
            id="jaringanForm"
            method="POST"
            action="{{ route('jaringan.store') }}"
        >

            @csrf

            <input
                type="hidden"
                name="_method"
                id="jaringanMethod"
                value="POST"
            >


            <div class="jaringan-modal-body">

                <div class="jaringan-form-card">

                    <div class="jaringan-form-card-header">

                        <i class="bi bi-diagram-3-fill"></i>

                        <h3>
                            Informasi Jaringan
                        </h3>

                    </div>


                    <div class="jaringan-form-grid">

                        {{-- ID --}}

                        <div class="jaringan-form-group">

                            <label for="jaringan_id">
                                ID Jaringan
                            </label>

                            <input
                                type="text"
                                id="jaringan_id"
                                name="id"
                                value="{{ old('id') }}"
                                placeholder="Otomatis"
                                readonly
                            >

                            <small class="jaringan-form-info">
                                <i class="bi bi-info-circle"></i>
                                ID dibuat otomatis berdasarkan jenis data.
                            </small>

                        </div>


                        {{-- JENIS DATA --}}

                        <div class="jaringan-form-group">

                            <label for="jaringan_jenis_data">
                                Jenis Data
                                <span>*</span>
                            </label>

                            <select
                                id="jaringan_jenis_data"
                                name="jenis_data"
                                onchange="updateJaringanFields()"
                                required
                            >

                                <option value="">
                                    Pilih jenis data
                                </option>

                                <option
                                    value="Jalur Kabel FO"
                                    {{ old('jenis_data') === 'Jalur Kabel FO' ? 'selected' : '' }}
                                >
                                    Jalur Kabel FO
                                </option>

                                <option
                                    value="Local Loop Sewa"
                                    {{ old('jenis_data') === 'Local Loop Sewa' ? 'selected' : '' }}
                                >
                                    Local Loop Sewa
                                </option>

                            </select>

                            {{-- Dipakai ketika mode edit --}}
                            <input
                                type="hidden"
                                id="jaringanJenisDataHidden"
                                name="jenis_data"
                                value=""
                                disabled
                            >

                            @error('jenis_data')
                                <small class="jaringan-form-error">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- LOKASI --}}

                        <div class="jaringan-form-group full">

                            <label for="jaringan_lokasi">
                                Lokasi
                                <span>*</span>
                            </label>

                            <input
                                type="text"
                                id="jaringan_lokasi"
                                name="lokasi"
                                value="{{ old('lokasi') }}"
                                placeholder="Masukkan lokasi atau jalur jaringan"
                                maxlength="255"
                                required
                            >

                            @error('lokasi')
                                <small class="jaringan-form-error">
                                    {{ $message }}
                                </small>
                            @enderror

                        </div>


                        {{-- =================================================
                             FIELD FO
                        ================================================== --}}

                        <div
                            id="jaringanFOFields"
                            class="jaringan-dynamic-fields"
                        >

                            {{-- JARAK KABEL --}}

                            <div class="jaringan-form-group">

                                <label for="jaringan_jarak_kabel">
                                    Jarak Kabel FO
                                    <span>*</span>
                                </label>

                                <input
                                    type="number"
                                    id="jaringan_jarak_kabel"
                                    name="jarak_kabel"
                                    value="{{ old('jarak_kabel') }}"
                                    placeholder="Contoh: 1500"
                                    min="0"
                                    step="0.01"
                                >

                                <small class="jaringan-form-info">
                                    Satuan dalam meter.
                                </small>

                                @error('jarak_kabel')
                                    <small class="jaringan-form-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- CORE --}}

                            <div class="jaringan-form-group">

                                <label for="jaringan_jumlah_core">
                                    Jumlah Core
                                    <span>*</span>
                                </label>

                                <input
                                    type="number"
                                    id="jaringan_jumlah_core"
                                    name="jumlah_core"
                                    value="{{ old('jumlah_core') }}"
                                    placeholder="Contoh: 12"
                                    min="1"
                                    step="1"
                                >

                                <small class="jaringan-form-info">
                                    Contoh: 12 core.
                                </small>

                                @error('jumlah_core')
                                    <small class="jaringan-form-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>


                        {{-- =================================================
                             FIELD LOCAL LOOP
                        ================================================== --}}

                        <div
                            id="jaringanLocalLoopFields"
                            class="jaringan-dynamic-fields"
                        >

                            <div class="jaringan-form-group">

                                <label for="jaringan_jumlah_titik">
                                    Jumlah Titik
                                    <span>*</span>
                                </label>

                                <input
                                    type="number"
                                    id="jaringan_jumlah_titik"
                                    name="jumlah_titik"
                                    value="{{ old('jumlah_titik') }}"
                                    placeholder="Contoh: 54"
                                    min="1"
                                    step="1"
                                >

                                <small class="jaringan-form-info">
                                    Jumlah titik lokasi.
                                </small>

                                @error('jumlah_titik')
                                    <small class="jaringan-form-error">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- FOOTER --}}

            <div class="jaringan-modal-footer">

                <button
                    type="button"
                    class="jaringan-btn-batal"
                    onclick="closeJaringanModal()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="jaringan-btn-simpan"
                    id="jaringanSaveButton"
                >
                    <i class="bi bi-check-lg"></i>
                    Simpan Jaringan
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     JAVASCRIPT
========================================================= --}}

@push('scripts')

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        updateJaringanFields();

        setupJaringanFilter();

        @if($errors->any())
            openAddJaringanModal();
        @endif

    }
);


/* =========================================================
   FILTER TABLE
========================================================= */

function setupJaringanFilter()
{
    const searchInput =
        document.getElementById('jaringanSearch');

    const jenisFilter =
        document.getElementById('jaringanJenisFilter');

    const verifikasiFilter =
        document.getElementById('jaringanVerifikasiFilter');

    const tableBody =
        document.getElementById('jaringanTableBody');


    function filterTable()
    {
        if (!tableBody) {
            return;
        }

        const rows =
            tableBody.querySelectorAll(
                'tr[data-search]'
            );

        const searchValue =
            (
                searchInput?.value || ''
            )
            .toLowerCase()
            .trim();

        const jenisValue =
            (
                jenisFilter?.value || ''
            )
            .toLowerCase()
            .trim();

        const verifikasiValue =
            (
                verifikasiFilter?.value || ''
            )
            .toLowerCase()
            .trim();


        rows.forEach(
            function (row) {

                const rowSearch =
                    (
                        row.dataset.search || ''
                    )
                    .toLowerCase();

                const rowJenis =
                    (
                        row.dataset.jenis || ''
                    )
                    .toLowerCase();

                const rowVerifikasi =
                    (
                        row.dataset.verifikasi || ''
                    )
                    .toLowerCase();


                const matchSearch =
                    !searchValue ||
                    rowSearch.includes(searchValue);

                const matchJenis =
                    !jenisValue ||
                    rowJenis === jenisValue;

                const matchVerifikasi =
                    !verifikasiValue ||
                    rowVerifikasi === verifikasiValue;


                row.style.display =
                    matchSearch &&
                    matchJenis &&
                    matchVerifikasi
                        ? ''
                        : 'none';

            }
        );
    }


    searchInput?.addEventListener(
        'input',
        filterTable
    );

    jenisFilter?.addEventListener(
        'change',
        filterTable
    );

    verifikasiFilter?.addEventListener(
        'change',
        filterTable
    );
}


/* =========================================================
   UPDATE DYNAMIC FIELD
========================================================= */

function updateJaringanFields()
{
    const jenisData =
        document.getElementById(
            'jaringan_jenis_data'
        )?.value;

    const foFields =
        document.getElementById(
            'jaringanFOFields'
        );

    const localLoopFields =
        document.getElementById(
            'jaringanLocalLoopFields'
        );

    const jarakKabel =
        document.getElementById(
            'jaringan_jarak_kabel'
        );

    const jumlahCore =
        document.getElementById(
            'jaringan_jumlah_core'
        );

    const jumlahTitik =
        document.getElementById(
            'jaringan_jumlah_titik'
        );


    if (!foFields || !localLoopFields) {
        return;
    }


    /* =====================================================
       JALUR KABEL FO
    ===================================================== */

    if (jenisData === 'Jalur Kabel FO') {

        foFields.classList.add('show');

        localLoopFields.classList.remove('show');


        if (jarakKabel) {
            jarakKabel.disabled = false;
            jarakKabel.required = true;
        }


        if (jumlahCore) {
            jumlahCore.disabled = false;
            jumlahCore.required = true;
        }


        if (jumlahTitik) {
            jumlahTitik.disabled = true;
            jumlahTitik.required = false;
            jumlahTitik.value = '';
        }

    }


    /* =====================================================
       LOCAL LOOP SEWA
    ===================================================== */

    else if (jenisData === 'Local Loop Sewa') {

        foFields.classList.remove('show');

        localLoopFields.classList.add('show');


        if (jarakKabel) {
            jarakKabel.disabled = true;
            jarakKabel.required = false;
            jarakKabel.value = '';
        }


        if (jumlahCore) {
            jumlahCore.disabled = true;
            jumlahCore.required = false;
            jumlahCore.value = '';
        }


        if (jumlahTitik) {
            jumlahTitik.disabled = false;
            jumlahTitik.required = true;
        }

    }


    /* =====================================================
       BELUM MEMILIH JENIS
    ===================================================== */

    else {

        foFields.classList.remove('show');

        localLoopFields.classList.remove('show');


        if (jarakKabel) {
            jarakKabel.disabled = true;
            jarakKabel.required = false;
        }


        if (jumlahCore) {
            jumlahCore.disabled = true;
            jumlahCore.required = false;
        }


        if (jumlahTitik) {
            jumlahTitik.disabled = true;
            jumlahTitik.required = false;
        }

    }
}


/* =========================================================
   OPEN ADD
========================================================= */

function openAddJaringanModal()
{
    const modal =
        document.getElementById(
            'jaringanModal'
        );

    const form =
        document.getElementById(
            'jaringanForm'
        );

    const jenisSelect =
        document.getElementById(
            'jaringan_jenis_data'
        );

    const jenisHidden =
        document.getElementById(
            'jaringanJenisDataHidden'
        );


    if (!modal || !form) {
        return;
    }


    /* FORM */

    form.action =
        "{{ route('jaringan.store') }}";

    document.getElementById(
        'jaringanMethod'
    ).value = 'POST';


    /* HEADER */

    document.getElementById(
        'jaringanModalTitle'
    ).textContent =
        'Tambah Jaringan';

    document.getElementById(
        'jaringanModalDescription'
    ).textContent =
        'Masukkan data infrastruktur jaringan baru.';

    document.getElementById(
        'jaringanSaveButton'
    ).innerHTML =
        '<i class="bi bi-check-lg"></i> Simpan Jaringan';


    /* RESET */

    @if(!$errors->any())

        form.reset();

        document.getElementById(
            'jaringan_id'
        ).value = '';

    @endif


    /* JENIS DATA AKTIF */

    if (jenisSelect) {
        jenisSelect.disabled = false;
        jenisSelect.name = 'jenis_data';
    }

    if (jenisHidden) {
        jenisHidden.disabled = true;
        jenisHidden.value = '';
    }


    updateJaringanFields();


    /* OPEN */

    modal.classList.add('show');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add(
        'jaringan-modal-open'
    );
}


/* =========================================================
   OPEN EDIT
========================================================= */

function openEditJaringanModal(id)
{
    const jaringans =
        @json($jaringans->values());

    const jaringan =
        jaringans.find(
            function (item) {
                return String(item.id) === String(id);
            }
        );


    if (!jaringan) {

        alert(
            'Data jaringan tidak ditemukan.'
        );

        return;
    }


    const modal =
        document.getElementById(
            'jaringanModal'
        );

    const form =
        document.getElementById(
            'jaringanForm'
        );

    const jenisSelect =
        document.getElementById(
            'jaringan_jenis_data'
        );

    const jenisHidden =
        document.getElementById(
            'jaringanJenisDataHidden'
        );


    if (!modal || !form) {
        return;
    }


    /* FORM ACTION */

    form.action =
        "{{ url('/infrastruktur/jaringan') }}/" +
        encodeURIComponent(id);

    document.getElementById(
        'jaringanMethod'
    ).value = 'PUT';


    /* HEADER */

    document.getElementById(
        'jaringanModalTitle'
    ).textContent =
        'Edit Jaringan';

    document.getElementById(
        'jaringanModalDescription'
    ).textContent =
        'Perbarui data jaringan yang dipilih.';

    document.getElementById(
        'jaringanSaveButton'
    ).innerHTML =
        '<i class="bi bi-check-lg"></i> Simpan Perubahan';


    /* ISI FORM */

    document.getElementById(
        'jaringan_id'
    ).value =
        jaringan.id ?? '';


    if (jenisSelect) {

        jenisSelect.value =
            jaringan.jenis_data ?? '';

        /*
         * Jenis data dikunci saat edit.
         * ID FO harus tetap FO.
         * ID LL harus tetap LL.
         */
        jenisSelect.disabled = true;
        jenisSelect.name = '';

    }


    if (jenisHidden) {

        jenisHidden.value =
            jaringan.jenis_data ?? '';

        jenisHidden.disabled = false;

    }


    document.getElementById(
        'jaringan_lokasi'
    ).value =
        jaringan.lokasi ?? '';


    document.getElementById(
        'jaringan_jarak_kabel'
    ).value =
        jaringan.jarak_kabel ?? '';


    document.getElementById(
        'jaringan_jumlah_core'
    ).value =
        jaringan.jumlah_core ?? '';


    document.getElementById(
        'jaringan_jumlah_titik'
    ).value =
        jaringan.jumlah_titik ?? '';


    /*
     * TIDAK ADA PENGISIAN KOMENTAR.
     *
     * Komentar adalah milik verifikator.
     */


    /* UPDATE FIELD */

    updateJaringanFields();


    /* OPEN */

    modal.classList.add('show');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add(
        'jaringan-modal-open'
    );
}


/* =========================================================
   CLOSE MODAL
========================================================= */

function closeJaringanModal()
{
    const modal =
        document.getElementById(
            'jaringanModal'
        );


    if (!modal) {
        return;
    }


    modal.classList.remove('show');

    modal.setAttribute(
        'aria-hidden',
        'true'
    );

    document.body.classList.remove(
        'jaringan-modal-open'
    );
}


/* =========================================================
   CLICK OUTSIDE MODAL
========================================================= */

document.addEventListener(
    'click',
    function (event) {

        const modal =
            document.getElementById(
                'jaringanModal'
            );


        if (
            modal &&
            event.target === modal
        ) {
            closeJaringanModal();
        }

    }
);


/* =========================================================
   ESCAPE
========================================================= */

document.addEventListener(
    'keydown',
    function (event) {

        const modal =
            document.getElementById(
                'jaringanModal'
            );


        if (
            event.key === 'Escape' &&
            modal?.classList.contains('show')
        ) {
            closeJaringanModal();
        }

    }
);

</script>

@endpush

@endsection
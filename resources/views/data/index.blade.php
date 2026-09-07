@extends('layouts.app')

@section('title', 'Data')

@section('page-title', 'Data')

@section('content')

<style>

/* =========================================================
   DATA PAGE
========================================================= */

.data-page {
    width: 100%;
    padding-bottom: 30px;
    font-family: Arial, sans-serif;
}

.data-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 22px;
}

.data-title {
    margin: 0;
    color: #1f2937;
    font-size: 25px;
    font-weight: 700;
}

.data-subtitle {
    margin: 6px 0 0;
    color: #6b7280;
    font-size: 13px;
}


/* =========================================================
   ALERT
========================================================= */

.data-alert {
    padding: 12px 15px;
    border-radius: 10px;
    margin-bottom: 18px;
    font-size: 12px;
    font-weight: 600;
}

.data-alert-success {
    background: #dcfce7;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.data-alert-error {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}


/* =========================================================
   STATISTICS
========================================================= */

.data-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 20px;
}

.data-stat-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 13px;
    padding: 17px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
}

.data-stat-icon {
    width: 43px;
    height: 43px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 19px;
}

.data-stat-icon.blue {
    background: #e0f2fe;
    color: #0369a1;
}

.data-stat-icon.green {
    background: #dcfce7;
    color: #15803d;
}

.data-stat-icon.orange {
    background: #fef3c7;
    color: #b45309;
}

.data-stat-content {
    min-width: 0;
}

.data-stat-label {
    display: block;
    color: #6b7280;
    font-size: 10px;
    font-weight: 600;
    margin-bottom: 3px;
}

.data-stat-value {
    display: block;
    color: #1f2937;
    font-size: 22px;
    line-height: 1.1;
    font-weight: 700;
}

.data-stat-description {
    display: block;
    margin-top: 4px;
    color: #9ca3af;
    font-size: 10px;
}


/* =========================================================
   MAIN CARD
========================================================= */

.data-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: visible;
    box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
}


/* =========================================================
   TOOLBAR
========================================================= */

.data-toolbar {
    padding: 17px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    border-bottom: 1px solid #edf0f3;
}

.data-toolbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.data-toolbar-title {
    color: #1f2937;
    font-size: 14px;
    font-weight: 700;
}

.data-toolbar-right {
    display: flex;
    align-items: center;
    gap: 9px;
}


/* =========================================================
   SEARCH
========================================================= */

.data-search {
    position: relative;
    width: 235px;
}

.data-search i {
    position: absolute;
    left: 11px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 13px;
    pointer-events: none;
}

.data-search input {
    width: 100%;
    height: 37px;
    padding: 0 12px 0 33px;
    border: 1px solid #d1d5db;
    border-radius: 9px;
    outline: none;
    color: #374151;
    font-size: 11px;
    background: #ffffff;
    box-sizing: border-box;
}

.data-search input:focus {
    border-color: #079bd8;
    box-shadow: 0 0 0 3px rgba(7, 155, 216, 0.08);
}


/* =========================================================
   BUTTON
========================================================= */

.data-add-button {
    height: 37px;
    padding: 0 14px;
    border: none;
    border-radius: 9px;
    background: #071b88;
    color: #ffffff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s ease;
}

.data-add-button:hover {
    background: #050f63;
}


/* =========================================================
   FILTER
========================================================= */

.data-filter-wrap {
    position: relative;
}

.data-filter-button {
    height: 37px;
    padding: 0 12px;
    border: 1px solid #d1d5db;
    border-radius: 9px;
    background: #ffffff;
    color: #4b5563;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
}

.data-filter-button:hover {
    background: #f8fafc;
}

.data-filter-dropdown {
    position: absolute;
    top: calc(100% + 7px);
    right: 0;
    width: 255px;
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 11px;
    padding: 14px;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.13);
    z-index: 50;
    display: none;
}

.data-filter-dropdown.show {
    display: block;
}

.data-filter-group {
    margin-bottom: 11px;
}

.data-filter-group:last-child {
    margin-bottom: 0;
}

.data-filter-label {
    display: block;
    margin-bottom: 5px;
    color: #475569;
    font-size: 10px;
    font-weight: 700;
}

.data-filter-group select {
    width: 100%;
    height: 34px;
    padding: 0 9px;
    border: 1px solid #d1d5db;
    border-radius: 7px;
    background: #ffffff;
    color: #374151;
    outline: none;
    font-size: 11px;
}

.data-filter-actions {
    display: flex;
    justify-content: flex-end;
    margin-top: 13px;
}

.data-reset-filter {
    border: none;
    background: transparent;
    color: #075985;
    font-size: 10px;
    font-weight: 600;
    cursor: pointer;
}


/* =========================================================
   TABLE
========================================================= */

.data-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.data-table {
    width: 100%;
    min-width: 1050px;
    border-collapse: collapse;
}

.data-table th {
    padding: 13px 14px;
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    color: #475569;
    font-size: 10px;
    font-weight: 700;
    text-align: left;
    white-space: nowrap;
}

.data-table td {
    padding: 13px 14px;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    font-size: 11px;
    vertical-align: middle;
}

.data-table tbody tr:hover {
    background: #f8fafc;
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}


/* =========================================================
   DATA NAME
========================================================= */

.data-name {
    display: block;
    max-width: 230px;
    color: #1f2937;
    font-weight: 600;
    line-height: 1.35;
}

.data-type {
    display: block;
    margin-top: 3px;
    color: #9ca3af;
    font-size: 10px;
    max-width: 230px;
}


/* =========================================================
   YEAR
========================================================= */

.data-year {
    font-weight: 600;
    color: #374151;
    white-space: nowrap;
}


/* =========================================================
   CATEGORY
========================================================= */

.data-category-badge {
    display: inline-flex;
    align-items: center;
    padding: 5px 9px;
    border-radius: 20px;
    background: #e0f2fe;
    color: #075985;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}


/* =========================================================
   FILE
========================================================= */

.data-file {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    max-width: 180px;
    color: #475569;
    text-decoration: none;
    font-size: 10px;
    font-weight: 600;
}

.data-file:hover {
    color: #075985;
}

.data-file i {
    color: #dc2626;
    font-size: 13px;
}

.data-no-file {
    color: #9ca3af;
}


/* =========================================================
   VERIFICATION
========================================================= */

.data-verification {
    display: inline-flex;
    align-items: center;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}

.data-verification.pending {
    background: #fef3c7;
    color: #92400e;
}

.data-verification.approved {
    background: #dcfce7;
    color: #166534;
}

.data-verification.rejected {
    background: #fee2e2;
    color: #991b1b;
}


/* =========================================================
   DATE
========================================================= */

.data-date {
    color: #4b5563;
    white-space: nowrap;
}


/* =========================================================
   ACTION
========================================================= */

.data-action-buttons {
    display: flex;
    align-items: center;
    gap: 6px;
}

.data-action-button {
    width: 29px;
    height: 29px;
    border-radius: 7px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: 0.2s ease;
    font-size: 11px;
}

.data-edit-button {
    background: #e0f2fe;
    color: #0369a1;
}

.data-edit-button:hover {
    background: #bae6fd;
}

.data-delete-button {
    background: #fee2e2;
    color: #dc2626;
}

.data-delete-button:hover {
    background: #fecaca;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.data-empty {
    padding: 55px 20px;
    text-align: center;
}

.data-empty-icon {
    width: 54px;
    height: 54px;
    margin: 0 auto 12px;
    border-radius: 14px;
    background: #e0f2fe;
    color: #0284c7;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}

.data-empty h3 {
    margin: 0 0 5px;
    color: #374151;
    font-size: 14px;
}

.data-empty p {
    margin: 0;
    color: #9ca3af;
    font-size: 11px;
}


/* =========================================================
   FOOTER / PAGINATION
========================================================= */

.data-table-footer {
    min-height: 59px;
    padding: 12px 17px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    border-top: 1px solid #edf0f3;
}

.data-showing-text {
    color: #9ca3af;
    font-size: 10px;
}

.data-pagination {
    display: flex;
    align-items: center;
    gap: 5px;
}

.data-page-link {
    min-width: 29px;
    height: 29px;
    padding: 0 7px;
    border: 1px solid #e5e7eb;
    border-radius: 7px;
    background: #ffffff;
    color: #64748b;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    font-size: 10px;
    font-weight: 600;
}

.data-page-link:hover {
    background: #f8fafc;
}

.data-page-link.active {
    background: #071b88;
    border-color: #071b88;
    color: #ffffff;
}

.data-page-link.disabled {
    opacity: 0.45;
    pointer-events: none;
}


/* =========================================================
   MODAL
========================================================= */

.data-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.58);
    display: none;
    align-items: center;
    justify-content: center;
    padding: 25px;
    z-index: 9999;
    box-sizing: border-box;
}

.data-modal-overlay.show {
    display: flex;
}

body.data-modal-open {
    overflow: hidden;
}

.data-modal {
    width: min(760px, 100%);
    max-height: 90vh;
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 25px 70px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    display: flex;
    flex-direction: column;
}


/* =========================================================
   MODAL HEADER
========================================================= */

.data-modal-header {
    flex-shrink: 0;
    padding: 19px 21px;
    border-bottom: 1px solid #edf0f3;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.data-modal-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.data-modal-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: #e0f2fe;
    color: #0369a1;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    flex-shrink: 0;
}

.data-modal-title {
    margin: 0;
    color: #1f2937;
    font-size: 17px;
    font-weight: 700;
}

.data-modal-subtitle {
    margin: 4px 0 0;
    color: #9ca3af;
    font-size: 10px;
}

.data-modal-close {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 8px;
    background: #f8fafc;
    color: #64748b;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.data-modal-close:hover {
    background: #fee2e2;
    color: #dc2626;
}


/* =========================================================
   MODAL BODY
========================================================= */

.data-modal-body {
    padding: 19px 21px;
    overflow-y: auto;
}

.data-modal-body::-webkit-scrollbar {
    width: 5px;
}

.data-modal-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}

.data-form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.data-form-group {
    display: flex;
    flex-direction: column;
}

.data-form-group.full {
    grid-column: 1 / -1;
}

.data-form-label {
    margin-bottom: 6px;
    color: #374151;
    font-size: 11px;
    font-weight: 700;
}

.data-form-label span {
    color: #ef4444;
}

.data-form-control {
    width: 100%;
    min-height: 39px;
    padding: 9px 11px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    outline: none;
    background: #ffffff;
    color: #374151;
    font-family: inherit;
    font-size: 11px;
    box-sizing: border-box;
}

.data-form-control:focus {
    border-color: #079bd8;
    box-shadow: 0 0 0 3px rgba(7, 155, 216, 0.08);
}

textarea.data-form-control {
    min-height: 85px;
    resize: vertical;
}

.data-file-input {
    padding: 7px 9px;
}

.data-form-help {
    margin-top: 5px;
    color: #9ca3af;
    font-size: 9px;
}

.data-error {
    margin-top: 5px;
    color: #dc2626;
    font-size: 9px;
}


/* =========================================================
   MODAL FOOTER
========================================================= */

.data-modal-footer {
    flex-shrink: 0;
    padding: 13px 21px;
    border-top: 1px solid #edf0f3;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
}

.data-modal-cancel {
    height: 37px;
    padding: 0 15px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    background: #ffffff;
    color: #4b5563;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
}

.data-modal-cancel:hover {
    background: #f8fafc;
}

.data-modal-save {
    height: 37px;
    padding: 0 16px;
    border: none;
    border-radius: 8px;
    background: #071b88;
    color: #ffffff;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
}

.data-modal-save:hover {
    background: #050f63;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1000px) {

    .data-stats {
        grid-template-columns: repeat(2, 1fr);
    }

    .data-toolbar {
        flex-direction: column;
        align-items: stretch;
    }

    .data-toolbar-left,
    .data-toolbar-right {
        width: 100%;
    }

    .data-toolbar-right {
        justify-content: flex-end;
    }
}

@media (max-width: 700px) {

    .data-stats {
        grid-template-columns: 1fr;
    }

    .data-toolbar-right {
        flex-wrap: wrap;
    }

    .data-search {
        width: 100%;
    }

    .data-form-grid {
        grid-template-columns: 1fr;
    }

    .data-form-group.full {
        grid-column: auto;
    }

    .data-modal-overlay {
        padding: 10px;
    }

    .data-modal {
        max-height: 94vh;
    }

    .data-table-footer {
        flex-direction: column;
        align-items: flex-start;
    }
}

</style>


<div class="data-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="data-header">

        <div>
            <h1 class="data-title">
                Data
            </h1>

            <p class="data-subtitle">
                Kelola dataset dan informasi data yang tersimpan dalam inventory.
            </p>
        </div>

    </div>


    {{-- =====================================================
         ALERT
    ====================================================== --}}

    @if(session('success'))
        <div class="data-alert data-alert-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="data-alert data-alert-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            {{ session('error') }}
        </div>
    @endif


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="data-stats">

        <div class="data-stat-card">

            <div class="data-stat-icon blue">
                <i class="bi bi-database-fill"></i>
            </div>

            <div class="data-stat-content">

                <span class="data-stat-label">
                    Total Data
                </span>

                <span class="data-stat-value">
                    {{ $totalData ?? ($data->total() ?? $data->count()) }}
                </span>

                <span class="data-stat-description">
                    Dataset terdaftar
                </span>

            </div>

        </div>


        <div class="data-stat-card">

            <div class="data-stat-icon green">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div class="data-stat-content">

                <span class="data-stat-label">
                    Disetujui
                </span>

                <span class="data-stat-value">
                    {{ $disetujui ?? 0 }}
                </span>

                <span class="data-stat-description">
                    Data telah diverifikasi
                </span>

            </div>

        </div>


        <div class="data-stat-card">

            <div class="data-stat-icon orange">
                <i class="bi bi-clock-history"></i>
            </div>

            <div class="data-stat-content">

                <span class="data-stat-label">
                    Menunggu
                </span>

                <span class="data-stat-value">
                    {{ $menunggu ?? 0 }}
                </span>

                <span class="data-stat-description">
                    Menunggu verifikasi
                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         MAIN CARD
    ====================================================== --}}

    <div class="data-card">

        {{-- TOOLBAR --}}

        <div class="data-toolbar">

            <div class="data-toolbar-left">

                <span class="data-toolbar-title">
                    Daftar Data
                </span>

            </div>


            <div class="data-toolbar-right">

                {{-- SEARCH --}}

                <form
                    method="GET"
                    action="{{ route('data.index') }}"
                    class="data-search"
                >

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari dataset..."
                    >

                </form>


                {{-- FILTER --}}

                <div class="data-filter-wrap">

                    <button
                        type="button"
                        class="data-filter-button"
                        onclick="toggleDataFilter(event)"
                    >
                        <i class="bi bi-funnel-fill"></i>
                        Filter
                    </button>


                    <div
                        id="dataFilterDropdown"
                        class="data-filter-dropdown"
                    >

                        <form
                            method="GET"
                            action="{{ route('data.index') }}"
                        >

                            <input
                                type="hidden"
                                name="search"
                                value="{{ request('search') }}"
                            >

                            <div class="data-filter-group">

                                <label class="data-filter-label">
                                    Jenis Data
                                </label>

                                <select name="jenis_data">

                                    <option value="">
                                        Semua Jenis
                                    </option>

                                    @foreach(($jenisDataList ?? collect()) as $jenis)
                                        <option
                                            value="{{ $jenis }}"
                                            {{ request('jenis_data') == $jenis ? 'selected' : '' }}
                                        >
                                            {{ $jenis }}
                                        </option>
                                    @endforeach

                                </select>

                            </div>


                            <div class="data-filter-group">

                                <label class="data-filter-label">
                                    Status Verifikasi
                                </label>

                                <select name="verifikasi">

                                    <option value="">
                                        Semua Status
                                    </option>

                                    <option
                                        value="menunggu"
                                        {{ request('verifikasi') == 'menunggu' ? 'selected' : '' }}
                                    >
                                        Menunggu
                                    </option>

                                    <option
                                        value="disetujui"
                                        {{ request('verifikasi') == 'disetujui' ? 'selected' : '' }}
                                    >
                                        Disetujui
                                    </option>

                                    <option
                                        value="ditolak"
                                        {{ request('verifikasi') == 'ditolak' ? 'selected' : '' }}
                                    >
                                        Ditolak
                                    </option>

                                </select>

                            </div>


                            <div class="data-filter-group">

                                <label class="data-filter-label">
                                    Tampilkan
                                </label>

                                <select name="show">

                                    @foreach([10,25,50,100] as $jumlah)

                                        <option
                                            value="{{ $jumlah }}"
                                            {{ request('show', 10) == $jumlah ? 'selected' : '' }}
                                        >
                                            {{ $jumlah }} data
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="data-filter-actions">

                                <button
                                    type="button"
                                    class="data-reset-filter"
                                    onclick="resetDataFilter()"
                                >
                                    Reset
                                </button>

                                <button
                                    type="submit"
                                    class="data-reset-filter"
                                    style="margin-left:10px;"
                                >
                                    Terapkan
                                </button>

                            </div>

                        </form>

                    </div>

                </div>


                {{-- ADD --}}

                <button
                    type="button"
                    class="data-add-button"
                    onclick="openDataModal()"
                >
                    <i class="bi bi-plus-lg"></i>
                    Tambah Data
                </button>

            </div>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="data-table-wrapper">

            @if($data->count() > 0)

                <table class="data-table">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Nama Dataset</th>
                            <th>Jenis Data</th>
                            <th>Tahun</th>
                            <th>File</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Verifikasi</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($data as $row)

                            @php

                                $verifikasi = strtolower(
                                    $row->verifikasi ?? 'menunggu'
                                );

                                $verificationClass = match($verifikasi) {

                                    'disetujui' => 'approved',

                                    'ditolak' => 'rejected',

                                    default => 'pending',

                                };

                                $verificationLabel = match($verifikasi) {

                                    'disetujui' => 'Disetujui',

                                    'ditolak' => 'Ditolak',

                                    default => 'Menunggu',

                                };

                            @endphp


                            <tr>

                                {{-- NO --}}

                                <td>
                                    {{ $data->firstItem() + $loop->index }}
                                </td>


                                {{-- NAMA DATASET --}}

                                <td>

                                    <span class="data-name">
                                        {{ $row->nama_dataset }}
                                    </span>

                                </td>


                                {{-- JENIS DATA --}}

                                <td>

                                    <span class="data-category-badge">
                                        {{ $row->jenis_data ?: '-' }}
                                    </span>

                                </td>


                                {{-- TAHUN --}}

                                <td>

                                    <span class="data-year">
                                        {{ $row->tahun ?: '-' }}
                                    </span>

                                </td>


                                {{-- FILE --}}

                                <td>

                                    @if($row->file_data)

                                        <a
                                            href="{{ asset('storage/' . $row->file_data) }}"
                                            target="_blank"
                                            class="data-file"
                                            title="Buka file"
                                        >
                                            <i class="bi bi-file-earmark-text-fill"></i>

                                            {{ basename($row->file_data) }}
                                        </a>

                                    @else

                                        <span class="data-no-file">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- TANGGAL --}}

                                <td>

                                    <span class="data-date">

                                        @if($row->tanggal_pengajuan)

                                            {{ \Carbon\Carbon::parse($row->tanggal_pengajuan)->format('d/m/Y') }}

                                        @else

                                            -

                                        @endif

                                    </span>

                                </td>


                                {{-- VERIFIKASI --}}

                                <td>

                                    <span class="data-verification {{ $verificationClass }}">

                                        {{ $verificationLabel }}

                                    </span>

                                </td>


                                {{-- AKSI --}}

                                <td>

                                    <div class="data-action-buttons">

                                        <button
                                            type="button"
                                            class="data-action-button data-edit-button"
                                            title="Edit"
                                            onclick="openEditDataModal({{ $row->id }})"
                                        >
                                            <i class="bi bi-pencil-fill"></i>
                                        </button>


                                        <form
                                            action="{{ route('data.destroy', $row->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?');"
                                            style="display:inline;"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="data-action-button data-delete-button"
                                                title="Hapus"
                                            >
                                                <i class="bi bi-trash-fill"></i>
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="data-empty">

                    <div class="data-empty-icon">
                        <i class="bi bi-database"></i>
                    </div>

                    <h3>
                        @if(request('search') || request('jenis_data') || request('verifikasi'))
                            Data tidak ditemukan
                        @else
                            Belum ada data
                        @endif
                    </h3>

                    <p>
                        @if(request('search') || request('jenis_data') || request('verifikasi'))
                            Coba ubah kata pencarian atau filter.
                        @else
                            Belum ada dataset yang tersimpan.
                        @endif
                    </p>

                </div>

            @endif

        </div>


        {{-- =================================================
             FOOTER
        ================================================== --}}

        @if($data->total() > 0)

            <div class="data-table-footer">

                <span class="data-showing-text">

                    Showing
                    {{ $data->firstItem() }}
                    to
                    {{ $data->lastItem() }}
                    of
                    {{ $data->total() }}
                    entries

                </span>


                <div class="data-pagination">

                    @if($data->onFirstPage())

                        <span class="data-page-link disabled">
                            <i class="bi bi-chevron-left"></i>
                        </span>

                    @else

                        <a
                            href="{{ $data->previousPageUrl() }}"
                            class="data-page-link"
                        >
                            <i class="bi bi-chevron-left"></i>
                        </a>

                    @endif


                    @foreach($data->getUrlRange(
                        max(1, $data->currentPage() - 2),
                        min($data->lastPage(), $data->currentPage() + 2)
                    ) as $page => $url)

                        <a
                            href="{{ $url }}"
                            class="data-page-link {{ $page == $data->currentPage() ? 'active' : '' }}"
                        >
                            {{ $page }}
                        </a>

                    @endforeach


                    @if($data->hasMorePages())

                        <a
                            href="{{ $data->nextPageUrl() }}"
                            class="data-page-link"
                        >
                            <i class="bi bi-chevron-right"></i>
                        </a>

                    @else

                        <span class="data-page-link disabled">
                            <i class="bi bi-chevron-right"></i>
                        </span>

                    @endif

                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     MODAL TAMBAH / EDIT DATA
========================================================= --}}

<div
    id="dataModal"
    class="data-modal-overlay"
    aria-hidden="true"
>

    <div
        class="data-modal"
        onclick="event.stopPropagation()"
    >

        {{-- HEADER --}}

        <div class="data-modal-header">

            <div class="data-modal-header-left">

                <div class="data-modal-icon">
                    <i class="bi bi-database-fill"></i>
                </div>

                <div>

                    <h2
                        id="dataModalTitle"
                        class="data-modal-title"
                    >
                        Tambah Data
                    </h2>

                    <p
                        id="dataModalSubtitle"
                        class="data-modal-subtitle"
                    >
                        Tambahkan dataset baru ke dalam sistem.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="data-modal-close"
                onclick="closeDataModal()"
                title="Tutup"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>


        {{-- FORM --}}

        <form
            id="dataForm"
            action="{{ route('data.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <input
                type="hidden"
                name="_method"
                id="dataMethod"
                value="POST"
            >


            {{-- BODY --}}

            <div class="data-modal-body">

                <div class="data-form-grid">


                    {{-- NAMA DATASET --}}

                    <div class="data-form-group full">

                        <label
                            for="data_nama_dataset"
                            class="data-form-label"
                        >
                            Nama Dataset
                            <span>*</span>
                        </label>

                        <input
                            type="text"
                            id="data_nama_dataset"
                            name="nama_dataset"
                            class="data-form-control"
                            value="{{ old('nama_dataset') }}"
                            placeholder="Contoh: Data Penduduk Kabupaten Bekasi"
                            required
                        >

                        @error('nama_dataset')
                            <small class="data-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- JENIS DATA --}}

                    <div class="data-form-group">

                        <label
                            for="data_jenis_data"
                            class="data-form-label"
                        >
                            Jenis Data
                            <span>*</span>
                        </label>

                        <input
                            type="text"
                            id="data_jenis_data"
                            name="jenis_data"
                            class="data-form-control"
                            value="{{ old('jenis_data') }}"
                            placeholder="Contoh: Kependudukan"
                            required
                        >

                        @error('jenis_data')
                            <small class="data-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- TAHUN --}}

                    <div class="data-form-group">

                        <label
                            for="data_tahun"
                            class="data-form-label"
                        >
                            Tahun
                            <span>*</span>
                        </label>

                        <input
                            type="number"
                            id="data_tahun"
                            name="tahun"
                            class="data-form-control"
                            value="{{ old('tahun') }}"
                            min="1900"
                            max="2100"
                            placeholder="Contoh: 2026"
                            required
                        >

                        @error('tahun')
                            <small class="data-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- FILE --}}

                    <div class="data-form-group full">

                        <label
                            for="data_file_data"
                            class="data-form-label"
                        >
                            File Data
                        </label>

                        <input
                            type="file"
                            id="data_file_data"
                            name="file_data"
                            class="data-form-control data-file-input"
                        >

                        <small class="data-form-help">
                            Upload file dataset jika tersedia.
                        </small>

                        @error('file_data')
                            <small class="data-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- KOMENTAR --}}

                    <div class="data-form-group full">

                        <label
                            for="data_komentar_verifikasi"
                            class="data-form-label"
                        >
                            Keterangan
                        </label>

                        <textarea
                            id="data_komentar_verifikasi"
                            name="komentar_verifikasi"
                            class="data-form-control"
                            placeholder="Tambahkan keterangan jika diperlukan..."
                        >{{ old('komentar_verifikasi') }}</textarea>

                        @error('komentar_verifikasi')
                            <small class="data-error">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>

            </div>


            {{-- FOOTER --}}

            <div class="data-modal-footer">

                <button
                    type="button"
                    class="data-modal-cancel"
                    onclick="closeDataModal()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="data-modal-save"
                    id="dataSaveButton"
                >
                    <i class="bi bi-check-lg"></i>
                    Simpan Data
                </button>

            </div>

        </form>

    </div>

</div>


<script>

const dataRecords = @json($data->items());


/* =========================================================
   FILTER
========================================================= */

function toggleDataFilter(event)
{
    if (event) {
        event.stopPropagation();
    }

    const dropdown =
        document.getElementById('dataFilterDropdown');

    if (!dropdown) {
        return;
    }

    dropdown.classList.toggle('show');
}


function resetDataFilter()
{
    window.location.href =
        "{{ route('data.index') }}";
}


document.addEventListener('click', function(event)
{
    const wrap =
        document.querySelector('.data-filter-wrap');

    const dropdown =
        document.getElementById('dataFilterDropdown');

    if (
        dropdown &&
        wrap &&
        !wrap.contains(event.target)
    ) {
        dropdown.classList.remove('show');
    }
});


/* =========================================================
   OPEN ADD
========================================================= */

function openDataModal()
{
    const modal =
        document.getElementById('dataModal');

    const form =
        document.getElementById('dataForm');

    if (!modal || !form) {
        return;
    }

    form.action =
        "{{ route('data.store') }}";

    document.getElementById('dataMethod').value =
        'POST';

    document.getElementById('dataModalTitle').textContent =
        'Tambah Data';

    document.getElementById('dataModalSubtitle').textContent =
        'Tambahkan dataset baru ke dalam sistem.';

    document.getElementById('dataSaveButton').innerHTML =
        '<i class="bi bi-check-lg"></i> Simpan Data';

    form.reset();

    modal.classList.add('show');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add(
        'data-modal-open'
    );
}


/* =========================================================
   OPEN EDIT
========================================================= */

function openEditDataModal(id)
{
    const data =
        dataRecords.find(function(item)
        {
            return String(item.id) === String(id);
        });

    if (!data) {

        alert(
            'Data tidak ditemukan pada halaman ini.'
        );

        return;
    }


    const modal =
        document.getElementById('dataModal');

    const form =
        document.getElementById('dataForm');

    if (!modal || !form) {
        return;
    }


    form.action =
        `/data/${id}`;

    document.getElementById('dataMethod').value =
        'PUT';

    document.getElementById('dataModalTitle').textContent =
        'Edit Data';

    document.getElementById('dataModalSubtitle').textContent =
        'Perbarui dataset yang dipilih.';

    document.getElementById('dataSaveButton').innerHTML =
        '<i class="bi bi-check-lg"></i> Simpan Perubahan';


    document.getElementById('data_nama_dataset').value =
        data.nama_dataset ?? '';

    document.getElementById('data_jenis_data').value =
        data.jenis_data ?? '';

    document.getElementById('data_tahun').value =
        data.tahun ?? '';

    document.getElementById('data_komentar_verifikasi').value =
        data.komentar_verifikasi ?? '';


    const fileInput =
        document.getElementById('data_file_data');

    if (fileInput) {
        fileInput.value = '';
    }


    modal.classList.add('show');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add(
        'data-modal-open'
    );
}


/* =========================================================
   CLOSE
========================================================= */

function closeDataModal()
{
    const modal =
        document.getElementById('dataModal');

    if (!modal) {
        return;
    }

    modal.classList.remove('show');

    modal.setAttribute(
        'aria-hidden',
        'true'
    );

    document.body.classList.remove(
        'data-modal-open'
    );
}


/* =========================================================
   BACKDROP
========================================================= */

document.getElementById('dataModal')
    ?.addEventListener(
        'click',
        function(event)
        {
            if (event.target === this) {
                closeDataModal();
            }
        }
    );


/* =========================================================
   ESCAPE
========================================================= */

document.addEventListener(
    'keydown',
    function(event)
    {
        if (event.key === 'Escape') {

            const modal =
                document.getElementById('dataModal');

            if (
                modal &&
                modal.classList.contains('show')
            ) {
                closeDataModal();
            }
        }
    }
);


/* =========================================================
   AUTO OPEN VALIDATION ERROR
========================================================= */

@if($errors->any())

document.addEventListener(
    'DOMContentLoaded',
    function()
    {
        openDataModal();
    }
);

@endif

</script>

@endsection
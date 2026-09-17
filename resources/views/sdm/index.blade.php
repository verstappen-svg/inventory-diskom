@extends('layouts.app')

@section('title', 'Sumber Daya Manusia')
@section('page-title', 'Sumber Daya Manusia')

@section('content')

<style>
/* =========================================================
   SDM PAGE
========================================================= */

.sdm-page {
    width: 100%;
}

/* =========================================================
   HEADER
========================================================= */

.sdm-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.sdm-heading h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
}

.sdm-heading p {
    margin: 6px 0 0;
    font-size: 13px;
    color: #6b7280;
}

.add-sdm-button {
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

.add-sdm-button:hover {
    background: #050f63;
    transform: translateY(-1px);
}

.add-sdm-button i {
    font-size: 13px;
}

/* =========================================================
   ALERT
========================================================= */

.alert-success,
.alert-error {
    display: flex;
    align-items: flex-start;
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

.sdm-stats {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 25px;
}

.sdm-stat-card {
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

.sdm-stat-icon {
    width: 45px;
    height: 45px;
    flex-shrink: 0;

    border-radius: 12px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 20px;
}

.sdm-stat-icon.blue {
    background: #e0f2fe;
    color: #0284c7;
}

.sdm-stat-icon.green {
    background: #dcfce7;
    color: #16a34a;
}

.sdm-stat-icon.orange {
    background: #ffedd5;
    color: #ea580c;
}

.sdm-stat-content {
    display: flex;
    flex-direction: column;
}

.sdm-stat-label {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 5px;
}

.sdm-stat-value {
    font-size: 23px;
    font-weight: 700;
    color: #075985;
    line-height: 1.2;
}

.sdm-stat-description {
    margin-top: 7px;
    font-size: 10px;
    color: #9ca3af;
}

/* =========================================================
   TABLE CARD
========================================================= */

.sdm-table-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.04);
}

.sdm-table-header {
    padding: 20px 22px;

    display: flex;
    justify-content: space-between;
    align-items: center;

    gap: 20px;

    border-bottom: 1px solid #e5e7eb;
}

.sdm-table-header-left {
    display: flex;
    align-items: center;
    gap: 8px;
}

.sdm-table-title {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
}

.sdm-table-count {
    font-size: 12px;
    color: #6b7280;
}

/* =========================================================
   TOOLBAR
========================================================= */

.sdm-toolbar {
    display: flex;
    align-items: center;
    gap: 9px;
}

.sdm-search {
    position: relative;
}

.sdm-search i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);

    color: #94a3b8;
    font-size: 14px;
}

.sdm-search input {
    width: 250px;
    height: 38px;

    padding: 0 12px 0 35px;

    border: 1px solid #d1d5db;
    border-radius: 8px;

    outline: none;

    font-size: 12px;
    color: #374151;

    background: white;
}

.sdm-search input:focus {
    border-color: #079bd8;
    box-shadow: 0 0 0 3px rgba(7, 155, 216, 0.10);
}

.sdm-filter-select {
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

.sdm-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.sdm-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 1550px;
}

.sdm-table th {
    padding: 14px 16px;

    background: #f8fafc;

    border-bottom: 1px solid #e5e7eb;

    color: #475569;

    font-size: 12px;
    font-weight: 700;

    text-align: left;
    white-space: nowrap;
}

.sdm-table td {
    padding: 15px 16px;

    border-bottom: 1px solid #f1f5f9;

    color: #374151;

    font-size: 13px;

    vertical-align: middle;
}

.sdm-table tbody tr:hover {
    background: #f8fafc;
}

.sdm-table tbody tr:last-child td {
    border-bottom: none;
}

/* =========================================================
   TABLE CONTENT
========================================================= */

.sdm-code {
    font-weight: 700;
    color: #075985;
    white-space: nowrap;
}

.sdm-nip {
    font-weight: 600;
    color: #374151;
    white-space: nowrap;
}

.sdm-name {
    min-width: 160px;
    font-weight: 600;
    color: #1f2937;
}

.sdm-value {
    color: #374151;
}

.sdm-empty {
    color: #9ca3af;
}

.sdm-komentar {
    max-width: 260px;
    line-height: 1.5;
    color: #64748b;

    word-break: break-word;
}

/* =========================================================
   JENIS PEGAWAI
========================================================= */

.jenis-pegawai-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 5px 10px;

    border-radius: 20px;

    font-size: 11px;
    font-weight: 600;

    white-space: nowrap;
}

.jenis-pns {
    background: #e0f2fe;
    color: #075985;
}

.jenis-pppk {
    background: #ede9fe;
    color: #6d28d9;
}

.jenis-tidak-diketahui {
    background: #f1f5f9;
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
   STATUS
========================================================= */

.status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    padding: 5px 10px;

    border-radius: 20px;

    font-size: 11px;
    font-weight: 600;

    white-space: nowrap;
}

.status-aktif {
    background: #dcfce7;
    color: #166534;
}

.status-berakhir {
    background: #fee2e2;
    color: #991b1b;
}

/* =========================================================
   DOKUMEN
========================================================= */

.sdm-dokumen-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;

    color: #075985;
    text-decoration: none;

    font-weight: 600;
    white-space: nowrap;
}

.sdm-dokumen-link:hover {
    text-decoration: underline;
}

/* =========================================================
   ACTION
========================================================= */

.sdm-action-buttons {
    display: flex;
    align-items: center;
    gap: 7px;
}

.sdm-action-button {
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

.sdm-edit-button {
    background: #e0f2fe;
    color: #075985;
}

.sdm-edit-button:hover {
    background: #bae6fd;
}

.sdm-delete-button {
    background: #fee2e2;
    color: #dc2626;
}

.sdm-delete-button:hover {
    background: #fecaca;
}

.sdm-action-button i {
    font-size: 14px;
}

.sdm-delete-form {
    display: inline;
}

/* =========================================================
   EMPTY
========================================================= */

.sdm-empty-state {
    padding: 55px 20px;
    text-align: center;
}

.sdm-empty-icon {
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

.sdm-empty-icon i {
    font-size: 27px;
}

.sdm-empty-state h3 {
    margin: 0 0 6px;

    font-size: 15px;
    color: #374151;
}

.sdm-empty-state p {
    margin: 0;

    font-size: 12px;
    color: #9ca3af;
}

/* =========================================================
   PAGINATION
========================================================= */

.sdm-pagination {
    padding: 16px 22px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 15px;

    border-top: 1px solid #e5e7eb;
}

.sdm-pagination-info {
    font-size: 12px;
    color: #6b7280;
}

/* =========================================================
   MODAL
========================================================= */

.sdm-modal-overlay {
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

.sdm-modal-overlay.show {
    display: flex;
}

.sdm-modal {
    width: 100%;
    max-width: 850px;

    max-height: calc(100vh - 60px);

    background: white;

    border-radius: 16px;

    box-shadow: 0 25px 60px rgba(15, 23, 42, 0.25);

    overflow: hidden;

    display: flex;
    flex-direction: column;
}

.sdm-modal-header {
    min-height: 78px;

    padding: 18px 22px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    border-bottom: 1px solid #e5e7eb;
}

.sdm-modal-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.sdm-modal-icon {
    width: 40px;
    height: 40px;

    border-radius: 10px;

    display: flex;
    align-items: center;
    justify-content: center;

    background: #e0f2fe;
    color: #075985;
}

.sdm-modal-header-text h2 {
    margin: 0;

    font-size: 17px;
    font-weight: 700;

    color: #1f2937;
}

.sdm-modal-header-text p {
    margin: 4px 0 0;

    font-size: 11px;
    color: #6b7280;
}

.sdm-modal-close {
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

.sdm-modal-close:hover {
    background: #e2e8f0;
}

/* =========================================================
   MODAL FORM
========================================================= */

#sdmForm {
    display: flex;
    flex-direction: column;
    min-height: 0;
}

.sdm-modal-body {
    padding: 24px;

    overflow-y: auto;

    max-height: calc(100vh - 190px);
}

.sdm-form-card {
    background: white;

    border: 1px solid #e5e7eb;
    border-radius: 14px;

    padding: 24px;
}

.sdm-form-card-header {
    display: flex;
    align-items: center;
    gap: 9px;

    padding-bottom: 13px;
    margin-bottom: 20px;

    border-bottom: 1px solid #e5e7eb;
}

.sdm-form-card-header i {
    color: #075985;
    font-size: 16px;
}

.sdm-form-card-header h3 {
    margin: 0;

    font-size: 14px;
    font-weight: 700;

    color: #1f2937;
}

.sdm-form-grid {
    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 18px;
}

.sdm-form-group {
    display: flex;
    flex-direction: column;
}

.sdm-form-group.full {
    grid-column: 1 / -1;
}

.sdm-form-group label {
    margin-bottom: 7px;

    font-size: 12px;
    font-weight: 600;

    color: #374151;
}

.sdm-form-group label span {
    color: #dc2626;
}

.sdm-form-control {
    width: 100%;
    box-sizing: border-box;

    height: 40px;

    padding: 0 12px;

    border: 1px solid #d1d5db;
    border-radius: 8px;

    background: white;
    color: #374151;

    outline: none;

    font-family: inherit;
    font-size: 12px;
}

.sdm-form-control:focus {
    border-color: #079bd8;
    box-shadow: 0 0 0 3px rgba(7, 155, 216, 0.10);
}

textarea.sdm-form-control {
    height: 90px;
    padding-top: 10px;
    resize: vertical;
}

.sdm-form-control:disabled {
    background: #f8fafc;
    color: #64748b;
    cursor: not-allowed;
}

.sdm-form-error {
    margin-top: 5px;

    font-size: 10px;
    color: #dc2626;
}

.sdm-form-info {
    margin-top: 6px;

    font-size: 10px;
    line-height: 1.5;

    color: #9ca3af;
}

/* =========================================================
   JENIS PEGAWAI FORM
========================================================= */

.jenis-pegawai-box {
    width: 100%;
    height: 40px;

    box-sizing: border-box;

    display: flex;
    align-items: center;

    padding: 0 12px;

    border: 1px solid #d1d5db;
    border-radius: 8px;

    background: #f8fafc;

    color: #64748b;

    font-size: 12px;
}

.jenis-pegawai-box.pns {
    background: #e0f2fe;
    color: #075985;
    border-color: #bae6fd;
    font-weight: 600;
}

.jenis-pegawai-box.pppk {
    background: #ede9fe;
    color: #6d28d9;
    border-color: #ddd6fe;
    font-weight: 600;
}

.jenis-pegawai-box.invalid {
    background: #fef2f2;
    color: #dc2626;
    border-color: #fecaca;
}

/* =========================================================
   BATCH DATA
========================================================= */

.batch-row {
    border: 1px solid #e5e7eb;

    border-radius: 12px;

    padding: 18px;

    margin-bottom: 14px;

    background: #f8fafc;

    position: relative;
}

.batch-row-number {
    display: flex;
    align-items: center;

    min-height: 32px;

    margin-bottom: 16px;

    font-size: 13px;
    font-weight: 700;

    color: #075985;
}

.batch-grid {
    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 18px;
}

.batch-remove {
    position: absolute;

    top: 14px;
    right: 14px;

    width: 32px;
    height: 32px;

    border: none;
    border-radius: 7px;

    background: #fee2e2;
    color: #dc2626;

    cursor: pointer;
}

.batch-remove:hover {
    background: #fecaca;
}

.btn-add-row {
    display: inline-flex;
    align-items: center;
    gap: 7px;

    height: 38px;

    padding: 0 14px;

    border: 1px dashed #079bd8;
    border-radius: 8px;

    background: #f0f9ff;
    color: #075985;

    cursor: pointer;

    font-size: 12px;
    font-weight: 600;
}

.btn-add-row:hover {
    background: #e0f2fe;
}

/* =========================================================
   CURRENT FILE
========================================================= */

.current-file {
    margin-top: 7px;

    font-size: 11px;
    color: #64748b;
}

.current-file a {
    color: #075985;
    text-decoration: none;
    font-weight: 600;
}

.current-file a:hover {
    text-decoration: underline;
}

/* =========================================================
   MODAL FOOTER
========================================================= */

.sdm-modal-footer {
    display: flex;
    justify-content: flex-end;
    align-items: center;

    gap: 10px;

    padding: 16px 24px;

    border-top: 1px solid #e5e7eb;

    background: white;
}

.sdm-btn-batal,
.sdm-btn-simpan {
    height: 40px;

    padding: 0 18px;

    border-radius: 8px;

    font-size: 12px;
    font-weight: 600;

    cursor: pointer;
}

.sdm-btn-batal {
    border: 1px solid #d1d5db;

    background: white;
    color: #4b5563;
}

.sdm-btn-batal:hover {
    background: #f8fafc;
}

.sdm-btn-simpan {
    border: none;

    background: #079bd8;
    color: white;
}

.sdm-btn-simpan:hover {
    background: #075985;
}

.sdm-btn-simpan:disabled {
    opacity: .6;
    cursor: not-allowed;
}

/* =========================================================
   BODY LOCK
========================================================= */

body.sdm-modal-open {
    overflow: hidden;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1200px) {

    .sdm-toolbar {
        flex-wrap: wrap;
    }

    .sdm-search {
        flex: 1;
    }

    .sdm-search input {
        width: 100%;
    }

}

@media (max-width: 1000px) {

    .sdm-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

}

@media (max-width: 800px) {

    .sdm-header {
        align-items: flex-start;
        flex-direction: column;
        gap: 15px;
    }

    .add-sdm-button {
        width: 100%;
    }

    .sdm-table-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .sdm-toolbar {
        width: 100%;
        flex-wrap: wrap;
    }

    .sdm-search {
        width: 100%;
    }

    .sdm-filter-select {
        flex: 1;
    }

    .sdm-form-grid,
    .batch-grid {
        grid-template-columns: 1fr;
    }

}

@media (max-width: 600px) {

    .sdm-stats {
        grid-template-columns: 1fr;
    }

    .sdm-modal-overlay {
        padding: 15px;
    }

    .sdm-modal {
        max-height: calc(100vh - 30px);
    }

    .sdm-modal-body {
        padding: 15px;
    }

    .sdm-form-card {
        padding: 18px;
    }

    .sdm-pagination {
        align-items: flex-start;
        flex-direction: column;
    }

}
</style>


<div class="sdm-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="sdm-header">

        <div class="sdm-heading">

            <h2>
                Sumber Daya Manusia
            </h2>

            <p>
                Kelola data sumber daya manusia dan dokumen pendukung.
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

    <div class="sdm-stats">

        <div class="sdm-stat-card">

            <div class="sdm-stat-icon blue">
                <i class="bi bi-people-fill"></i>
            </div>

            <div class="sdm-stat-content">

                <span class="sdm-stat-label">
                    Total SDM
                </span>

                <span class="sdm-stat-value">
                    {{ $totalData ?? 0 }}
                </span>

                <span class="sdm-stat-description">
                    Seluruh data sumber daya manusia
                </span>

            </div>

        </div>


        <div class="sdm-stat-card">

            <div class="sdm-stat-icon green">
                <i class="bi bi-person-check-fill"></i>
            </div>

            <div class="sdm-stat-content">

                <span class="sdm-stat-label">
                    SDM Aktif
                </span>

                <span class="sdm-stat-value">
                    {{ $aktif ?? 0 }}
                </span>

                <span class="sdm-stat-description">
                    Data dengan masa berlaku aktif
                </span>

            </div>

        </div>


        <div class="sdm-stat-card">

            <div class="sdm-stat-icon orange">
                <i class="bi bi-calendar-x-fill"></i>
            </div>

            <div class="sdm-stat-content">

                <span class="sdm-stat-label">
                    Masa Berlaku Berakhir
                </span>

                <span class="sdm-stat-value">
                    {{ $berakhir ?? 0 }}
                </span>

                <span class="sdm-stat-description">
                    Data yang masa berlakunya berakhir
                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="sdm-table-card">

        <div class="sdm-table-header">

            <div class="sdm-table-header-left">

                <h3 class="sdm-table-title">
                    Data Sumber Daya Manusia
                </h3>

                <span class="sdm-table-count">
                    ({{ $sdm->total() }} data)
                </span>

            </div>


            <div class="sdm-toolbar">

                {{-- SEARCH --}}

                <div class="sdm-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        id="sdmSearch"
                        placeholder="Cari NIP, nama, jabatan..."
                        value="{{ request('search') }}"
                    >

                </div>


                {{-- FILTER VERIFIKASI --}}

                <select
                    id="sdmVerifikasiFilter"
                    class="sdm-filter-select"
                >

                    <option value="">
                        Semua Verifikasi
                    </option>

                    <option
                        value="menunggu"
                        {{ request('verifikasi') === 'menunggu' ? 'selected' : '' }}
                    >
                        Menunggu
                    </option>

                    <option
                        value="disetujui"
                        {{ request('verifikasi') === 'disetujui' ? 'selected' : '' }}
                    >
                        Disetujui
                    </option>

                    <option
                        value="ditolak"
                        {{ request('verifikasi') === 'ditolak' ? 'selected' : '' }}
                    >
                        Ditolak
                    </option>

                </select>


                {{-- TAMBAH SDM --}}

                <button
                    type="button"
                    class="add-sdm-button"
                    onclick="openSdmModal()"
                >
                    <i class="bi bi-plus-lg"></i>
                    <span>Tambah SDM</span>
                </button>

            </div>

        </div>


        <div class="sdm-table-wrapper">

            <table class="sdm-table">

                <thead>

                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>NIP</th>
                        <th>Jenis Pegawai</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Kompetensi</th>
                        <th>Masa Berlaku</th>
                        <th>Dokumen</th>
                        <th>Verifikasi</th>
                        <th>Status</th>
                        <th>Komentar</th>
                        <th>Aksi</th>
                    </tr>

                </thead>


                <tbody id="sdmTableBody">

                    @forelse($sdm as $index => $row)

                        @php

                            $displayId =
                                'SDM-' .
                                str_pad(
                                    $row->id,
                                    5,
                                    '0',
                                    STR_PAD_LEFT
                                );


                            $verification =
                                \App\Models\VerificationRequest::where(
                                    'module',
                                    'sdm'
                                )
                                ->where(
                                    'record_id',
                                    $row->id
                                )
                                ->latest()
                                ->first();


                            $verifikasi =
                                strtolower(
                                    trim(
                                        $row->verifikasi ?? ''
                                    )
                                );


                            if ($verifikasi === 'menunggu') {

                                $verifikasiLabel =
                                    'Menunggu';

                                $verifikasiClass =
                                    'verifikasi-menunggu';

                            }

                            elseif ($verifikasi === 'disetujui') {

                                $verifikasiLabel =
                                    'Disetujui';

                                $verifikasiClass =
                                    'verifikasi-disetujui';

                            }

                            elseif ($verifikasi === 'ditolak') {

                                $verifikasiLabel =
                                    'Ditolak';

                                $verifikasiClass =
                                    'verifikasi-ditolak';

                            }

                            else {

                                $verifikasi =
                                    'menunggu';

                                $verifikasiLabel =
                                    'Menunggu';

                                $verifikasiClass =
                                    'verifikasi-menunggu';

                            }


                            $nipValue =
                                preg_replace(
                                    '/[^0-9]/',
                                    '',
                                    $row->nip ?? ''
                                );


                            if (strlen($nipValue) === 18) {

                                $jenisPegawai =
                                    'PNS';

                                $jenisClass =
                                    'jenis-pns';

                            }

                            elseif (strlen($nipValue) === 20) {

                                $jenisPegawai =
                                    'PPPK';

                                $jenisClass =
                                    'jenis-pppk';

                            }

                            else {

                                $jenisPegawai =
                                    '-';

                                $jenisClass =
                                    'jenis-tidak-diketahui';

                            }


                            $masaBerlaku =
                                $row->masa_berlaku
                                    ? \Carbon\Carbon::parse(
                                        $row->masa_berlaku
                                    )
                                    : null;


                            $statusMasaBerlaku =
                                $masaBerlaku &&
                                $masaBerlaku->isPast()
                                    ? 'Berakhir'
                                    : 'Aktif';


                            $statusClass =
                                $statusMasaBerlaku === 'Aktif'
                                    ? 'status-aktif'
                                    : 'status-berakhir';


                            $komentarVerifikator =
                                $verification->rejection_reason
                                ?? null;

                        @endphp


                        <tr
                            data-search="{{ strtolower(
                                ($row->id ?? '') . ' ' .
                                ($row->nip ?? '') . ' ' .
                                ($row->nama ?? '') . ' ' .
                                ($row->jabatan ?? '') . ' ' .
                                ($row->kompetensi ?? '')
                            ) }}"
                            data-verifikasi="{{ $verifikasi }}"
                        >

                            {{-- NO --}}

                            <td>
                                {{
                                    ($sdm->currentPage() - 1)
                                    * $sdm->perPage()
                                    + $index
                                    + 1
                                }}
                            </td>


                            {{-- ID --}}

                            <td>
                                <span class="sdm-code">
                                    {{ $displayId }}
                                </span>
                            </td>


                            {{-- NIP --}}

                            <td>
                                <span class="sdm-nip">
                                    {{ $row->nip ?? '-' }}
                                </span>
                            </td>


                            {{-- JENIS PEGAWAI --}}

                            <td>

                                <span
                                    class="jenis-pegawai-badge {{ $jenisClass }}"
                                >
                                    {{ $jenisPegawai }}
                                </span>

                            </td>


                            {{-- NAMA --}}

                            <td>

                                <div class="sdm-name">
                                    {{ $row->nama ?? '-' }}
                                </div>

                            </td>


                            {{-- JABATAN --}}

                            <td>

                                @if($row->jabatan)

                                    <span class="sdm-value">
                                        {{ $row->jabatan }}
                                    </span>

                                @else

                                    <span class="sdm-empty">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- KOMPETENSI --}}

                            <td>

                                @if($row->kompetensi)

                                    <span class="sdm-value">
                                        {{ $row->kompetensi }}
                                    </span>

                                @else

                                    <span class="sdm-empty">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- MASA BERLAKU --}}

                            <td>

                                @if($masaBerlaku)

                                    <span class="sdm-value">
                                        {{ $masaBerlaku->format('d-m-Y') }}
                                    </span>

                                @else

                                    <span class="sdm-empty">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- DOKUMEN --}}

                            <td>

                                @if($row->dokumen)

                                    <a
                                        href="{{ asset('storage/' . $row->dokumen) }}"
                                        target="_blank"
                                        class="sdm-dokumen-link"
                                    >
                                        <i class="bi bi-file-earmark-text-fill"></i>
                                        Lihat
                                    </a>

                                @else

                                    <span class="sdm-empty">
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


                            {{-- STATUS --}}

                            <td>

                                <span
                                    class="status-badge {{ $statusClass }}"
                                >
                                    {{ $statusMasaBerlaku }}
                                </span>

                            </td>


                            {{-- KOMENTAR --}}

                            <td>

                                @if($komentarVerifikator)

                                    <div
                                        class="sdm-komentar"
                                        title="{{ $komentarVerifikator }}"
                                    >
                                        {{ $komentarVerifikator }}
                                    </div>

                                @else

                                    <span class="sdm-empty">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}

                            <td>

                                <div class="sdm-action-buttons">

                                    {{-- EDIT --}}

                                    <button
                                        type="button"
                                        class="sdm-action-button sdm-edit-button"
                                        title="Edit"
                                        onclick="openEditSdmModal(@js($row->id))"
                                    >
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>


                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route(
                                            'sdm.destroy',
                                            $row->id
                                        ) }}"
                                        method="POST"
                                        class="sdm-delete-form"
                                        onsubmit="return confirm(
                                            'Yakin ingin menghapus data SDM ini?'
                                        );"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="sdm-action-button sdm-delete-button"
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
                                colspan="13"
                                style="padding:0;"
                            >

                                <div class="sdm-empty-state">

                                    <div class="sdm-empty-icon">
                                        <i class="bi bi-people"></i>
                                    </div>

                                    <h3>
                                        Belum ada data SDM
                                    </h3>

                                    <p>
                                        Data sumber daya manusia belum tersedia.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINATION --}}

        @if($sdm->hasPages() || $sdm->total() > 0)

            <div class="sdm-pagination">

                <div class="sdm-pagination-info">

                    Menampilkan
                    {{ $sdm->firstItem() ?? 0 }}
                    -
                    {{ $sdm->lastItem() ?? 0 }}
                    dari
                    {{ $sdm->total() }}
                    data

                </div>

                <div>
                    {{ $sdm->links() }}
                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     MODAL TAMBAH / EDIT SDM
========================================================= --}}

<div
    id="sdmModal"
    class="sdm-modal-overlay"
    aria-hidden="true"
>

    <div
        class="sdm-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="sdmModalTitle"
    >

        {{-- HEADER MODAL --}}

        <div class="sdm-modal-header">

            <div class="sdm-modal-header-left">

                <div class="sdm-modal-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div class="sdm-modal-header-text">

                    <h2 id="sdmModalTitle">
                        Tambah SDM
                    </h2>

                    <p id="sdmModalDescription">
                        Masukkan data sumber daya manusia baru.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="sdm-modal-close"
                onclick="closeSdmModal()"
                title="Tutup"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>


        {{-- FORM --}}

        <form
            id="sdmForm"
            method="POST"
            action="{{ route('sdm.store') }}"
            enctype="multipart/form-data"
        >

            @csrf

            <input
                type="hidden"
                name="_method"
                id="sdmMethod"
                value="POST"
            >


            <div class="sdm-modal-body">

                {{-- =================================================
                     BATCH TAMBAH
                ================================================== --}}

                <div
                    id="sdmBatchSection"
                >

                    <div class="sdm-form-card">

                        <div class="sdm-form-card-header">

                            <i class="bi bi-person-plus-fill"></i>

                            <h3>
                                Data Sumber Daya Manusia
                            </h3>

                        </div>


                        <div id="sdmRowsContainer"></div>


                        <button
                            type="button"
                            class="btn-add-row"
                            onclick="addSdmRow()"
                        >
                            <i class="bi bi-plus-circle"></i>
                            Tambah Baris
                        </button>

                    </div>

                </div>


                {{-- =================================================
                     EDIT
                ================================================== --}}

                <div
                    id="sdmEditSection"
                    style="display:none;"
                >

                    <div class="sdm-form-card">

                        <div class="sdm-form-card-header">

                            <i class="bi bi-pencil-square"></i>

                            <h3>
                                Informasi SDM
                            </h3>

                        </div>


                        <div class="sdm-form-grid">

                            {{-- NIP --}}

                            <div class="sdm-form-group">

                                <label for="edit_nip">
                                    NIP
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="edit_nip"
                                    class="sdm-form-control"
                                    inputmode="numeric"
                                    minlength="18"
                                    maxlength="20"
                                    pattern="([0-9]{18}|[0-9]{20})"
                                    oninput="handleNipType(
                                        this,
                                        'edit_jenis_pegawai'
                                    )"
                                    placeholder="Masukkan 18 atau 20 digit NIP"
                                    autocomplete="off"
                                    disabled
                                >

                                <small class="sdm-form-info">
                                    18 digit = PNS, 20 digit = PPPK.
                                </small>

                            </div>


                            {{-- JENIS PEGAWAI --}}

                            <div class="sdm-form-group">

                                <label>
                                    Jenis Pegawai
                                </label>

                                <div
                                    id="edit_jenis_pegawai"
                                    class="jenis-pegawai-box"
                                >
                                    Otomatis berdasarkan NIP
                                </div>

                            </div>


                            {{-- NAMA --}}

                            <div class="sdm-form-group">

                                <label for="edit_nama">
                                    Nama
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="edit_nama"
                                    class="sdm-form-control"
                                    autocomplete="off"
                                    disabled
                                >

                            </div>


                            {{-- JABATAN --}}

                            <div class="sdm-form-group">

                                <label for="edit_jabatan">
                                    Jabatan
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="edit_jabatan"
                                    class="sdm-form-control"
                                    autocomplete="off"
                                    disabled
                                >

                            </div>


                            {{-- KOMPETENSI --}}

                            <div class="sdm-form-group">

                                <label for="edit_kompetensi">
                                    Kompetensi
                                    <span>*</span>
                                </label>

                                <input
                                    type="text"
                                    id="edit_kompetensi"
                                    class="sdm-form-control"
                                    autocomplete="off"
                                    disabled
                                >

                            </div>


                            {{-- MASA BERLAKU --}}

                            <div class="sdm-form-group">

                                <label for="edit_masa_berlaku">
                                    Masa Berlaku
                                    <span>*</span>
                                </label>

                                <input
                                    type="date"
                                    id="edit_masa_berlaku"
                                    class="sdm-form-control"
                                    disabled
                                >

                            </div>


                            {{-- DOKUMEN --}}

                            <div class="sdm-form-group full">

                                <label for="edit_dokumen">
                                    Dokumen
                                </label>

                                <input
                                    type="file"
                                    id="edit_dokumen"
                                    class="sdm-form-control"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    disabled
                                >

                                <div
                                    id="currentSdmFile"
                                    class="current-file"
                                ></div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- FOOTER --}}

            <div class="sdm-modal-footer">

                <button
                    type="button"
                    class="sdm-btn-batal"
                    onclick="closeSdmModal()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="sdm-btn-simpan"
                    id="sdmSubmitButton"
                >
                    <i class="bi bi-check-lg"></i>
                    Simpan SDM
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

const sdmRecords =
    @json($sdm->items());


const sdmModal =
    document.getElementById('sdmModal');

const sdmForm =
    document.getElementById('sdmForm');

const sdmMethod =
    document.getElementById('sdmMethod');

const sdmBatchSection =
    document.getElementById('sdmBatchSection');

const sdmEditSection =
    document.getElementById('sdmEditSection');

const sdmRowsContainer =
    document.getElementById('sdmRowsContainer');

const sdmModalTitle =
    document.getElementById('sdmModalTitle');

const sdmModalDescription =
    document.getElementById('sdmModalDescription');

const sdmSubmitButton =
    document.getElementById('sdmSubmitButton');


const editInputs = {

    nip:
        document.getElementById('edit_nip'),

    nama:
        document.getElementById('edit_nama'),

    jabatan:
        document.getElementById('edit_jabatan'),

    kompetensi:
        document.getElementById('edit_kompetensi'),

    masa_berlaku:
        document.getElementById('edit_masa_berlaku'),

    dokumen:
        document.getElementById('edit_dokumen')

};


/* =========================================================
   FILTER TABLE
========================================================= */

function setupSdmFilter()
{
    const searchInput =
        document.getElementById('sdmSearch');

    const verifikasiFilter =
        document.getElementById(
            'sdmVerifikasiFilter'
        );

    const tableBody =
        document.getElementById(
            'sdmTableBody'
        );


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


                const rowVerifikasi =
                    (
                        row.dataset.verifikasi || ''
                    )
                    .toLowerCase();


                const matchSearch =
                    !searchValue ||
                    rowSearch.includes(
                        searchValue
                    );


                const matchVerifikasi =
                    !verifikasiValue ||
                    rowVerifikasi ===
                        verifikasiValue;


                row.style.display =
                    matchSearch &&
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


    verifikasiFilter?.addEventListener(
        'change',
        filterTable
    );
}


/* =========================================================
   NIP
========================================================= */

function sanitizeNip(input)
{
    if (!input) {
        return;
    }


    input.value =
        input.value
            .replace(/[^0-9]/g, '')
            .slice(0, 20);
}


function getJenisPegawai(nip)
{
    nip =
        String(nip ?? '')
            .replace(/[^0-9]/g, '');


    if (nip.length === 18) {
        return 'PNS';
    }


    if (nip.length === 20) {
        return 'PPPK';
    }


    return '';
}


function updateJenisPegawai(
    nipInput,
    jenisElement
)
{
    if (!nipInput || !jenisElement) {
        return;
    }


    const nip =
        nipInput.value
            .replace(/[^0-9]/g, '');


    const jenis =
        getJenisPegawai(nip);


    jenisElement.classList.remove(
        'pns',
        'pppk',
        'invalid'
    );


    if (jenis === 'PNS') {

        jenisElement.textContent =
            'PNS';

        jenisElement.classList.add(
            'pns'
        );

    }

    else if (jenis === 'PPPK') {

        jenisElement.textContent =
            'PPPK';

        jenisElement.classList.add(
            'pppk'
        );

    }

    else {

        if (nip.length === 0) {

            jenisElement.textContent =
                'Otomatis berdasarkan NIP';

        }

        else {

            jenisElement.textContent =
                'NIP harus 18 atau 20 digit';

            jenisElement.classList.add(
                'invalid'
            );

        }

    }
}


function handleNipType(
    input,
    jenisElementId
)
{
    sanitizeNip(input);


    const jenisElement =
        document.getElementById(
            jenisElementId
        );


    updateJenisPegawai(
        input,
        jenisElement
    );
}


function isValidNip(nip)
{
    nip =
        String(nip ?? '')
            .replace(/[^0-9]/g, '');


    return (
        nip.length === 18 ||
        nip.length === 20
    );
}


/* =========================================================
   EDIT INPUT
========================================================= */

function enableSdmEditInputs()
{
    Object.values(editInputs)
        .forEach(
            function (input) {

                input.disabled = false;

            }
        );


    editInputs.nip.name =
        'nip';

    editInputs.nama.name =
        'nama';

    editInputs.jabatan.name =
        'jabatan';

    editInputs.kompetensi.name =
        'kompetensi';

    editInputs.masa_berlaku.name =
        'masa_berlaku';

    editInputs.dokumen.name =
        'dokumen';


    editInputs.nip.required =
        true;

    editInputs.nama.required =
        true;

    editInputs.jabatan.required =
        true;

    editInputs.kompetensi.required =
        true;

    editInputs.masa_berlaku.required =
        true;

    editInputs.dokumen.required =
        false;
}


function disableSdmEditInputs()
{
    Object.values(editInputs)
        .forEach(
            function (input) {

                input.removeAttribute(
                    'name'
                );

                input.removeAttribute(
                    'required'
                );

                input.disabled = true;

            }
        );


    editInputs.nip.value = '';
    editInputs.nama.value = '';
    editInputs.jabatan.value = '';
    editInputs.kompetensi.value = '';
    editInputs.masa_berlaku.value = '';
    editInputs.dokumen.value = '';


    const jenisElement =
        document.getElementById(
            'edit_jenis_pegawai'
        );


    if (jenisElement) {

        jenisElement.textContent =
            'Otomatis berdasarkan NIP';

        jenisElement.classList.remove(
            'pns',
            'pppk',
            'invalid'
        );

    }
}


/* =========================================================
   OPEN ADD
========================================================= */

function openSdmModal()
{
    if (!sdmModal || !sdmForm) {
        return;
    }


    sdmForm.action =
        "{{ route('sdm.store') }}";


    sdmMethod.value =
        'POST';


    sdmModalTitle.textContent =
        'Tambah SDM';


    sdmModalDescription.textContent =
        'Masukkan data sumber daya manusia baru.';


    sdmBatchSection.style.display =
        'block';


    sdmEditSection.style.display =
        'none';


    disableSdmEditInputs();


    sdmForm.reset();


    sdmSubmitButton.disabled =
        false;


    sdmSubmitButton.innerHTML =
        '<i class="bi bi-check-lg"></i> Simpan SDM';


    sdmRowsContainer.innerHTML =
        '';


    addSdmRow();


    sdmModal.classList.add(
        'show'
    );


    sdmModal.setAttribute(
        'aria-hidden',
        'false'
    );


    document.body.classList.add(
        'sdm-modal-open'
    );
}


/* =========================================================
   OPEN EDIT
========================================================= */

function openEditSdmModal(id)
{
    const record =
        sdmRecords.find(
            function (item) {

                return Number(item.id) ===
                    Number(id);

            }
        );


    if (!record) {

        alert(
            'Data SDM tidak ditemukan.'
        );

        return;
    }


    if (!sdmModal || !sdmForm) {
        return;
    }


    sdmForm.action =
        "{{ url('/sdm') }}/" +
        encodeURIComponent(id);


    sdmMethod.value =
        'PUT';


    sdmModalTitle.textContent =
        'Edit SDM';


    sdmModalDescription.textContent =
        'Perbarui data sumber daya manusia yang dipilih.';


    sdmBatchSection.style.display =
        'none';


    sdmEditSection.style.display =
        'block';


    enableSdmEditInputs();


    editInputs.nip.value =
        record.nip ?? '';


    sanitizeNip(
        editInputs.nip
    );


    updateJenisPegawai(
        editInputs.nip,
        document.getElementById(
            'edit_jenis_pegawai'
        )
    );


    editInputs.nama.value =
        record.nama ?? '';


    editInputs.jabatan.value =
        record.jabatan ?? '';


    editInputs.kompetensi.value =
        record.kompetensi ?? '';


    editInputs.masa_berlaku.value =
        record.masa_berlaku
            ? String(
                record.masa_berlaku
            ).substring(0, 10)
            : '';


    editInputs.dokumen.value =
        '';


    const currentFile =
        document.getElementById(
            'currentSdmFile'
        );


    if (record.dokumen) {

        currentFile.innerHTML =
            'Dokumen saat ini: ' +

            '<a href="{{ asset('storage') }}/' +
            record.dokumen +
            '" target="_blank">' +
            'Lihat dokumen' +
            '</a>';

    }

    else {

        currentFile.innerHTML =
            'Belum ada dokumen.';

    }


    sdmSubmitButton.disabled =
        false;


    sdmSubmitButton.innerHTML =
        '<i class="bi bi-check-lg"></i> Simpan Perubahan';


    sdmModal.classList.add(
        'show'
    );


    sdmModal.setAttribute(
        'aria-hidden',
        'false'
    );


    document.body.classList.add(
        'sdm-modal-open'
    );
}


/* =========================================================
   ADD BATCH ROW
========================================================= */

function addSdmRow()
{
    const rowCount =
        sdmRowsContainer
            .querySelectorAll(
                '.batch-row'
            ).length + 1;


    const row =
        document.createElement(
            'div'
        );


    row.className =
        'batch-row';


    row.innerHTML = `

        <div class="batch-row-number">
            Data SDM ${rowCount}
        </div>

        <button
            type="button"
            class="batch-remove"
            onclick="removeSdmRow(this)"
            title="Hapus baris"
        >
            <i class="bi bi-x-lg"></i>
        </button>


        <div class="batch-grid">

            <div class="sdm-form-group">

                <label>
                    NIP
                    <span>*</span>
                </label>

                <input
                    type="text"
                    name="nip[]"
                    class="sdm-form-control nip-input batch-nip"
                    inputmode="numeric"
                    minlength="18"
                    maxlength="20"
                    pattern="([0-9]{18}|[0-9]{20})"
                    placeholder="Masukkan 18 atau 20 digit NIP"
                    autocomplete="off"
                    required
                >

                <small class="sdm-form-info">
                    18 digit = PNS, 20 digit = PPPK.
                </small>

            </div>


            <div class="sdm-form-group">

                <label>
                    Jenis Pegawai
                </label>

                <div class="jenis-pegawai-box batch-jenis-pegawai">
                    Otomatis berdasarkan NIP
                </div>

            </div>


            <div class="sdm-form-group">

                <label>
                    Nama
                    <span>*</span>
                </label>

                <input
                    type="text"
                    name="nama[]"
                    class="sdm-form-control"
                    required
                >

            </div>


            <div class="sdm-form-group">

                <label>
                    Jabatan
                    <span>*</span>
                </label>

                <input
                    type="text"
                    name="jabatan[]"
                    class="sdm-form-control"
                    required
                >

            </div>


            <div class="sdm-form-group">

                <label>
                    Kompetensi
                    <span>*</span>
                </label>

                <input
                    type="text"
                    name="kompetensi[]"
                    class="sdm-form-control"
                    required
                >

            </div>


            <div class="sdm-form-group">

                <label>
                    Masa Berlaku
                    <span>*</span>
                </label>

                <input
                    type="date"
                    name="masa_berlaku[]"
                    class="sdm-form-control"
                    required
                >

            </div>


            <div class="sdm-form-group full">

                <label>
                    Dokumen
                    <span>*</span>
                </label>

                <input
                    type="file"
                    name="dokumen[]"
                    class="sdm-form-control"
                    accept=".pdf,.jpg,.jpeg,.png"
                    required
                >

                <small class="sdm-form-info">
                    Format yang didukung: PDF, JPG, JPEG, PNG.
                </small>

            </div>

        </div>
    `;


    sdmRowsContainer.appendChild(
        row
    );


    const nipInput =
        row.querySelector(
            '.batch-nip'
        );


    const jenisElement =
        row.querySelector(
            '.batch-jenis-pegawai'
        );


    nipInput.addEventListener(
        'input',
        function () {

            sanitizeNip(this);

            updateJenisPegawai(
                this,
                jenisElement
            );

        }
    );


    updateSdmRowNumbers();
}


/* =========================================================
   REMOVE BATCH ROW
========================================================= */

function removeSdmRow(button)
{
    const rows =
        sdmRowsContainer
            .querySelectorAll(
                '.batch-row'
            );


    if (rows.length <= 1) {

        alert(
            'Minimal harus ada satu data SDM.'
        );

        return;
    }


    button
        .closest('.batch-row')
        .remove();


    updateSdmRowNumbers();
}


/* =========================================================
   UPDATE ROW NUMBER
========================================================= */

function updateSdmRowNumbers()
{
    const rows =
        sdmRowsContainer
            .querySelectorAll(
                '.batch-row'
            );


    rows.forEach(
        function (row, index) {

            const number =
                row.querySelector(
                    '.batch-row-number'
                );


            if (number) {

                number.textContent =
                    'Data SDM ' +
                    (index + 1);

            }

        }
    );
}


/* =========================================================
   VALIDATE BATCH NIP
========================================================= */

function validateBatchNips()
{
    const nipInputs =
        sdmRowsContainer
            .querySelectorAll(
                '.batch-nip'
            );


    for (
        let i = 0;
        i < nipInputs.length;
        i++
    ) {

        const nip =
            nipInputs[i].value
                .replace(
                    /[^0-9]/g,
                    ''
                );


        if (!isValidNip(nip)) {

            alert(
                'NIP pada Data SDM ' +
                (i + 1) +
                ' harus terdiri dari tepat 18 digit untuk PNS atau 20 digit untuk PPPK.'
            );


            nipInputs[i].focus();

            return false;
        }

    }


    return true;
}


/* =========================================================
   CLOSE MODAL
========================================================= */

function closeSdmModal()
{
    if (!sdmModal) {
        return;
    }


    sdmModal.classList.remove(
        'show'
    );


    sdmModal.setAttribute(
        'aria-hidden',
        'true'
    );


    document.body.classList.remove(
        'sdm-modal-open'
    );


    sdmSubmitButton.disabled =
        false;


    sdmSubmitButton.innerHTML =
        '<i class="bi bi-check-lg"></i> Simpan SDM';


    disableSdmEditInputs();
}


/* =========================================================
   CLICK OUTSIDE
========================================================= */

document.addEventListener(
    'click',
    function (event) {

        if (
            sdmModal &&
            event.target === sdmModal
        ) {

            closeSdmModal();

        }

    }
);


/* =========================================================
   ESCAPE
========================================================= */

document.addEventListener(
    'keydown',
    function (event) {

        if (
            event.key === 'Escape' &&
            sdmModal?.classList.contains('show')
        ) {

            closeSdmModal();

        }

    }
);


/* =========================================================
   SUBMIT
========================================================= */

sdmForm.addEventListener(
    'submit',
    function (event) {

        if (
            sdmMethod.value === 'POST'
        ) {

            if (!validateBatchNips()) {

                event.preventDefault();

                return;
            }

        }


        if (
            sdmMethod.value === 'PUT'
        ) {

            const nip =
                editInputs.nip.value
                    .replace(
                        /[^0-9]/g,
                        ''
                    );


            if (!isValidNip(nip)) {

                event.preventDefault();


                alert(
                    'NIP harus tepat 18 digit untuk PNS atau 20 digit untuk PPPK.'
                );


                editInputs.nip.focus();

                return;
            }

        }


        sdmSubmitButton.disabled =
            true;


        sdmSubmitButton.innerHTML =
            '<i class="bi bi-hourglass-split"></i> Menyimpan...';

    }
);


/* =========================================================
   DOM READY
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function () {

        setupSdmFilter();

        disableSdmEditInputs();


        @if($errors->any())

            openSdmModal();

        @endif

    }
);

</script>

@endpush

@endsection
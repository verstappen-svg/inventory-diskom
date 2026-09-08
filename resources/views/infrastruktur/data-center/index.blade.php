@extends('layouts.app')

@section('title', 'Data Center')

@section('page-title', 'Data Center')

@section('content')

<style>

/* =========================================================
   DATA CENTER PAGE
========================================================= */

.data-center-page {
    width: 100%;
}


/* =========================================================
   HEADER
========================================================= */

.data-center-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.data-center-heading h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
}

.data-center-heading p {
    margin: 6px 0 0;
    font-size: 13px;
    color: #6b7280;
}

.add-data-center-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 11px 18px;
    border: none;
    border-radius: 10px;
    background: #071b88;
    color: white;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s ease;
}

.add-data-center-button:hover {
    background: #050f63;
    color: white;
    transform: translateY(-1px);
}

.add-data-center-button i {
    font-size: 16px;
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

.alert-success i,
.alert-error i {
    font-size: 17px;
}


/* =========================================================
   STATISTIC CARDS
========================================================= */

.data-center-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 25px;
}

.data-center-stat-card {
    min-height: 135px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 20px;
    display: flex;
    align-items: flex-start;
    gap: 15px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease;
}

.data-center-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(0, 0, 0, 0.08);
}

.data-center-stat-icon {
    width: 45px;
    height: 45px;
    flex-shrink: 0;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.data-center-stat-icon.blue {
    background: #e0f2fe;
    color: #0284c7;
}

.data-center-stat-icon.purple {
    background: #ede9fe;
    color: #7c3aed;
}

.data-center-stat-icon.orange {
    background: #ffedd5;
    color: #ea580c;
}

.data-center-stat-icon.green {
    background: #dcfce7;
    color: #16a34a;
}

.data-center-stat-icon.red {
    background: #fee2e2;
    color: #dc2626;
}

.data-center-stat-content {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.data-center-stat-label {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 5px;
}

.data-center-stat-value {
    font-size: 23px;
    font-weight: 700;
    color: #075985;
    line-height: 1.2;
}

.data-center-stat-value.currency {
    font-size: 17px;
    white-space: nowrap;
}

.data-center-stat-description {
    margin-top: 7px;
    font-size: 10px;
    color: #9ca3af;
}


/* =========================================================
   TABLE CARD
========================================================= */

.data-center-table-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.04);
}


/* =========================================================
   TABLE HEADER
========================================================= */

.data-center-table-header {
    padding: 20px 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    border-bottom: 1px solid #e5e7eb;
}

.data-center-table-header-left {
    display: flex;
    align-items: center;
    gap: 8px;
}

.data-center-table-title {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
}

.data-center-table-count {
    font-size: 12px;
    color: #6b7280;
}


/* =========================================================
   TOOLBAR
========================================================= */

.data-center-toolbar {
    display: flex;
    align-items: center;
    gap: 9px;
}

.data-center-search {
    position: relative;
}

.data-center-search i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 14px;
}

.data-center-search input {
    width: 220px;
    height: 38px;
    padding: 0 12px 0 35px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    outline: none;
    font-size: 12px;
    color: #374151;
    background: white;
    transition: 0.2s ease;
}

.data-center-search input:focus {
    border-color: #079bd8;
    box-shadow: 0 0 0 3px rgba(7, 155, 216, 0.10);
}

.data-center-filter-select {
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

.data-center-filter-select:focus {
    border-color: #079bd8;
}


/* =========================================================
   TABLE
========================================================= */

.data-center-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.data-center-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 1450px;
}

.data-center-table th {
    padding: 14px 16px;
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    text-align: left;
    white-space: nowrap;
}

.data-center-table td {
    padding: 15px 16px;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    font-size: 13px;
    vertical-align: middle;
}

.data-center-table tbody tr {
    transition: 0.15s ease;
}

.data-center-table tbody tr:hover {
    background: #f8fafc;
}

.data-center-table tbody tr:last-child td {
    border-bottom: none;
}


/* =========================================================
   ID
========================================================= */

.data-center-code {
    font-weight: 700;
    color: #075985;
    white-space: nowrap;
}


/* =========================================================
   NAME
========================================================= */

.data-center-name {
    font-weight: 600;
    color: #1f2937;
}

.data-center-spec {
    margin-top: 3px;
    font-size: 11px;
    color: #9ca3af;
    max-width: 250px;
}


/* =========================================================
   PENGADAAN
========================================================= */

.procurement-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.procurement-sewa {
    background: #fef3c7;
    color: #92400e;
}

.procurement-beli {
    background: #dcfce7;
    color: #166534;
}


/* =========================================================
   PRICE
========================================================= */

.data-center-price {
    font-weight: 600;
    color: #374151;
    white-space: nowrap;
}


/* =========================================================
   DATE
========================================================= */

.data-center-date {
    white-space: nowrap;
    color: #4b5563;
}

.data-center-date-empty {
    color: #9ca3af;
}


/* =========================================================
   STATUS
========================================================= */

.data-center-status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.status-perpetual {
    background: #dcfce7;
    color: #166534;
}

.status-active {
    background: #e0f2fe;
    color: #075985;
}

.status-warning {
    background: #fef3c7;
    color: #92400e;
}

.status-expired {
    background: #fee2e2;
    color: #991b1b;
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
   KOMENTAR
========================================================= */

.data-center-comment {
    max-width: 220px;
    font-size: 11px;
    color: #6b7280;
    line-height: 1.5;
}


/* =========================================================
   ACTION
========================================================= */

.data-center-action-buttons {
    display: flex;
    align-items: center;
    gap: 7px;
}

.data-center-action-button {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 7px;
    border: none;
    text-decoration: none;
    cursor: pointer;
    transition: 0.2s ease;
}

.data-center-edit-button {
    background: #e0f2fe;
    color: #071b88;
}

.data-center-edit-button:hover {
    background: #bae6fd;
    color: #071b88;
}

.data-center-delete-button {
    background: #fee2e2;
    color: #dc2626;
}

.data-center-delete-button:hover {
    background: #fecaca;
    color: #dc2626;
}

.data-center-action-button i {
    font-size: 14px;
}

.data-center-delete-form {
    display: inline;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.data-center-empty-state {
    padding: 55px 20px;
    text-align: center;
}

.data-center-empty-icon {
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

.data-center-empty-icon i {
    font-size: 27px;
}

.data-center-empty-state h3 {
    margin: 0 0 6px;
    font-size: 15px;
    color: #374151;
}

.data-center-empty-state p {
    margin: 0;
    font-size: 12px;
    color: #9ca3af;
}


/* =========================================================
   PAGINATION
========================================================= */

.data-center-table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    border-top: 1px solid #e5e7eb;
}

.data-center-showing-text {
    font-size: 11px;
    color: #6b7280;
}


/* =========================================================
   MODAL OVERLAY
========================================================= */

.data-center-modal-overlay {
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

.data-center-modal-overlay.show {
    display: flex;
}


/* =========================================================
   MODAL
========================================================= */

.data-center-modal {
    width: 100%;
    max-width: 1050px;
    height: min(720px, calc(100vh - 60px));
    max-height: calc(100vh - 60px);
    background: white;
    border-radius: 16px;
    box-shadow:
        0 25px 60px rgba(15, 23, 42, 0.25);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    min-height: 0;
    animation: dataCenterModalIn 0.18s ease;
}

@keyframes dataCenterModalIn {

    from {
        opacity: 0;
        transform: translateY(10px) scale(0.99);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

}


/* =========================================================
   MODAL HEADER
========================================================= */

.data-center-modal-header {
    min-height: 78px;
    padding: 18px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #e5e7eb;
    flex-shrink: 0;
}

.data-center-modal-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.data-center-modal-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e0f2fe;
    color: #075985;
    flex-shrink: 0;
}

.data-center-modal-icon i {
    font-size: 18px;
}

.data-center-modal-header-text h2 {
    margin: 0;
    font-size: 17px;
    font-weight: 700;
    color: #1f2937;
}

.data-center-modal-header-text p {
    margin: 4px 0 0;
    font-size: 11px;
    color: #6b7280;
}

.data-center-modal-close {
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
    transition: 0.2s ease;
}

.data-center-modal-close:hover {
    background: #e2e8f0;
    color: #1f2937;
}


/* =========================================================
   MODAL FORM
========================================================= */

#dataCenterForm {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    min-height: 0;
    height: 100%;
    overflow: hidden;
}

.data-center-modal-body {
    padding: 24px;
    flex: 1 1 0%;
    min-height: 0;
    height: 0;
    overflow-y: scroll;
    overflow-x: hidden;
    -webkit-overflow-scrolling: touch;
    overscroll-behavior: contain;
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
}


/* =========================================================
   FORM CARD
========================================================= */

.data-center-form-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 24px;
    margin-bottom: 18px;
    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.03);
}

.data-center-form-card:last-child {
    margin-bottom: 0;
}

.data-center-form-card-header {
    display: flex;
    align-items: center;
    gap: 9px;
    padding-bottom: 13px;
    margin-bottom: 20px;
    border-bottom: 1px solid #e5e7eb;
}

.data-center-form-card-header i {
    color: #075985;
    font-size: 16px;
}

.data-center-form-card-header h3 {
    margin: 0;
    font-size: 14px;
    font-weight: 700;
    color: #1f2937;
}


/* =========================================================
   FORM GRID
========================================================= */

.data-center-form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
}

.data-center-form-group {
    display: flex;
    flex-direction: column;
}

.data-center-form-group.full {
    grid-column: 1 / -1;
}

.data-center-form-group label {
    margin-bottom: 7px;
    font-size: 12px;
    font-weight: 600;
    color: #374151;
}

.data-center-form-group label span {
    color: #dc2626;
}

.data-center-form-group input,
.data-center-form-group select,
.data-center-form-group textarea {
    width: 100%;
    box-sizing: border-box;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    background: white;
    color: #374151;
    outline: none;
    font-family: inherit;
    font-size: 12px;
    transition: 0.2s ease;
}

.data-center-form-group input,
.data-center-form-group select {
    height: 40px;
    padding: 0 12px;
}

.data-center-form-group textarea {
    min-height: 85px;
    padding: 10px 12px;
    resize: vertical;
}

.data-center-form-group input:focus,
.data-center-form-group select:focus,
.data-center-form-group textarea:focus {
    border-color: #079bd8;
    box-shadow:
        0 0 0 3px rgba(7, 155, 216, 0.10);
}

.data-center-form-group input[readonly] {
    background: #f8fafc;
    color: #64748b;
    cursor: not-allowed;
}

.data-center-form-error {
    margin-top: 5px;
    font-size: 10px;
    color: #dc2626;
}


/* =========================================================
   PRICE INPUT
========================================================= */

.data-center-price-input {
    position: relative;
}

.data-center-price-prefix {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    pointer-events: none;
}

.data-center-price-input input {
    padding-left: 38px;
}


/* =========================================================
   SEWA SECTION
========================================================= */

#dataCenterSewaSection {
    display: none;
    margin-top: 20px;
    padding: 18px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
}

#dataCenterSewaSection.show {
    display: block;
}

.data-center-sewa-title {
    margin-bottom: 15px;
    font-size: 12px;
    font-weight: 700;
    color: #075985;
}

.data-center-sewa-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
}


/* =========================================================
   CUSTOM PERIOD
========================================================= */

#dataCenterCustomPeriod {
    display: none;
    margin-top: 16px;
}

#dataCenterCustomPeriod.show {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 16px;
}


/* =========================================================
   INFO
========================================================= */

.data-center-form-info {
    margin-top: 6px;
    font-size: 10px;
    line-height: 1.5;
    color: #9ca3af;
}

.data-center-form-info i {
    margin-right: 3px;
}


/* =========================================================
   MODAL FOOTER
========================================================= */

.data-center-modal-footer {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
    padding: 16px 24px;
    border-top: 1px solid #e5e7eb;
    background: white;
    flex-shrink: 0;
}

.data-center-btn-batal,
.data-center-btn-simpan {
    height: 40px;
    padding: 0 18px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s ease;
}

.data-center-btn-batal {
    border: 1px solid #d1d5db;
    background: white;
    color: #4b5563;
}

.data-center-btn-batal:hover {
    background: #f8fafc;
}

.data-center-btn-simpan {
    border: none;
    background: #079bd8;
    color: white;
}

.data-center-btn-simpan:hover {
    background: #075985;
}

.data-center-btn-simpan i {
    margin-right: 5px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1200px) {

    .data-center-stats {
        grid-template-columns: repeat(3, 1fr);
    }

}

@media (max-width: 900px) {

    .data-center-header {
        align-items: flex-start;
        flex-direction: column;
        gap: 15px;
    }

    .add-data-center-button {
        width: 100%;
    }

    .data-center-stats {
        grid-template-columns: repeat(2, 1fr);
    }

    .data-center-table-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .data-center-toolbar {
        width: 100%;
        flex-wrap: wrap;
    }

    .data-center-search {
        flex: 1;
        min-width: 220px;
    }

    .data-center-search input {
        width: 100%;
    }

}

@media (max-width: 700px) {

    .data-center-modal-overlay {
        padding: 15px;
    }

    .data-center-modal {
        height: calc(100vh - 30px);
        max-height: calc(100vh - 30px);
    }

    .data-center-modal-body {
        padding: 15px;
    }

    .data-center-form-card {
        padding: 18px;
    }

    .data-center-form-grid,
    .data-center-sewa-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    #dataCenterCustomPeriod.show {
        grid-template-columns: 1fr;
    }

    .data-center-modal-footer {
        padding: 14px 15px;
    }

}

@media (max-width: 500px) {

    .data-center-stats {
        grid-template-columns: 1fr;
    }

    .data-center-toolbar {
        flex-direction: column;
        align-items: stretch;
    }

    .data-center-filter-select {
        width: 100%;
    }

    .data-center-modal-header {
        padding: 15px;
    }

}


/* =========================================================
   BODY LOCK WHEN MODAL OPEN
========================================================= */

body.data-center-modal-open {
    overflow: hidden;
}

</style>


<div class="data-center-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="data-center-header">

        <div class="data-center-heading">

            <h2>
                Data Center
            </h2>

            <p>
                Kelola data infrastruktur data center yang tersedia.
            </p>

        </div>


        <button
            type="button"
            class="add-data-center-button"
            onclick="openAddDataCenterModal()"
        >

            <i class="bi bi-plus-lg"></i>

            <span>
                Tambah Data Center
            </span>

        </button>

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
                    Silakan periksa kembali isian form.
                </div>

            </div>

        </div>

    @endif


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="data-center-stats">


        {{-- TOTAL --}}

        <div class="data-center-stat-card">

            <div class="data-center-stat-icon blue">

                <i class="bi bi-server"></i>

            </div>

            <div class="data-center-stat-content">

                <span class="data-center-stat-label">
                    Total Data Center
                </span>

                <span class="data-center-stat-value">

                    {{ $totalDataCenter ?? $dataCenters->count() }}

                </span>

                <span class="data-center-stat-description">
                    Infrastruktur data center terdaftar
                </span>

            </div>

        </div>


        {{-- AKAN HABIS --}}

        <div class="data-center-stat-card">

            <div class="data-center-stat-icon orange">

                <i class="bi bi-clock-history"></i>

            </div>

            <div class="data-center-stat-content">

                <span class="data-center-stat-label">
                    Akan Habis
                </span>

                <span class="data-center-stat-value">

                    {{ $akanHabis ?? $akanBerakhir ?? 0 }}

                </span>

                <span class="data-center-stat-description">
                    Sewa berakhir dalam 30 hari
                </span>

            </div>

        </div>


        {{-- TIDAK BERAKHIR --}}

        <div class="data-center-stat-card">

            <div class="data-center-stat-icon green">

                <i class="bi bi-infinity"></i>

            </div>

            <div class="data-center-stat-content">

                <span class="data-center-stat-label">
                    Tidak Berakhir
                </span>

                <span class="data-center-stat-value">

                    {{ $tidakBerakhir ?? 0 }}

                </span>

                <span class="data-center-stat-description">
                    Data center hasil pembelian
                </span>

            </div>

        </div>


        {{-- EXPIRED --}}

        <div class="data-center-stat-card">

            <div class="data-center-stat-icon red">

                <i class="bi bi-x-circle-fill"></i>

            </div>

            <div class="data-center-stat-content">

                <span class="data-center-stat-label">
                    Expired
                </span>

                <span class="data-center-stat-value">

                    {{ $expired ?? 0 }}

                </span>

                <span class="data-center-stat-description">
                    Data center sudah berakhir
                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="data-center-table-card">


        {{-- =================================================
             TABLE HEADER
        ================================================== --}}

        <div class="data-center-table-header">


            <div class="data-center-table-header-left">

                <h3 class="data-center-table-title">
                    Data Data Center
                </h3>

                <span class="data-center-table-count">
                    ({{ $dataCenters->count() }} data)
                </span>

            </div>


            {{-- TOOLBAR --}}

            <div class="data-center-toolbar">


                {{-- SEARCH --}}

                <div class="data-center-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        id="dataCenterSearch"
                        placeholder="Cari data center..."
                    >

                </div>


                {{-- FILTER STATUS --}}

                <select
                    id="dataCenterStatusFilter"
                    class="data-center-filter-select"
                >

                    <option value="">
                        Semua Status
                    </option>

                    <option value="tidak berakhir">
                        Tidak Berakhir
                    </option>

                    <option value="digunakan">
                        Digunakan
                    </option>

                    <option value="akan habis">
                        Akan Habis
                    </option>

                    <option value="expired">
                        Expired
                    </option>

                </select>


                {{-- FILTER PENGADAAN --}}

                <select
                    id="dataCenterPengadaanFilter"
                    class="data-center-filter-select"
                >

                    <option value="">
                        Semua Pengadaan
                    </option>

                    <option value="beli">
                        Beli
                    </option>

                    <option value="sewa">
                        Sewa
                    </option>

                </select>


                {{-- FILTER VERIFIKASI --}}

                <select
                    id="dataCenterVerifikasiFilter"
                    class="data-center-filter-select"
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


                {{-- FILTER TAHUN --}}

                @if(isset($tahuns) && count($tahuns))

                    <select
                        id="dataCenterTahunFilter"
                        class="data-center-filter-select"
                    >

                        <option value="">
                            Semua Tahun
                        </option>

                        @foreach($tahuns as $tahun)

                            <option value="{{ $tahun }}">
                                {{ $tahun }}
                            </option>

                        @endforeach

                    </select>

                @endif

            </div>

        </div>


        {{-- =================================================
             TABLE WRAPPER
        ================================================== --}}

        <div class="data-center-table-wrapper">

            <table class="data-center-table">

                <thead>

                    <tr>

                        <th>
                            No
                        </th>

                        <th>
                            ID
                        </th>

                        <th>
                            Nama Infrastruktur
                        </th>

                        <th>
                            Spesifikasi
                        </th>

                        <th>
                            Pengadaan
                        </th>

                        <th>
                            Harga
                        </th>

                        <th>
                            Tanggal Pengadaan
                        </th>

                        <th>
                            Tanggal Berakhir
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Verifikasi
                        </th>

                        <th>
                            Komentar
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody id="dataCenterTableBody">


                    @forelse($dataCenters as $dataCenter)

                        @php

                            /*
                             * STATUS OTOMATIS
                             *
                             * Beli
                             *      -> Tidak Berakhir
                             *
                             * Sewa > 30 hari
                             *      -> Digunakan
                             *
                             * Sewa <= 30 hari
                             *      -> Akan Habis
                             *
                             * Sewa lewat tanggal
                             *      -> Expired
                             */

                            $pengadaanLower =
                                strtolower(
                                    trim(
                                        $dataCenter->pengadaan ?? ''
                                    )
                                );

                            $statusLabel =
                                'Tidak Berakhir';

                            $statusClass =
                                'status-perpetual';


                            if (
                                $pengadaanLower === 'sewa' &&
                                $dataCenter->tanggal_berakhir
                            ) {

                                $today =
                                    now()->startOfDay();

                                $endDate =
                                    \Carbon\Carbon::parse(
                                        $dataCenter->tanggal_berakhir
                                    )->startOfDay();

                                $daysLeft =
                                    $today->diffInDays(
                                        $endDate,
                                        false
                                    );


                                if ($daysLeft < 0) {

                                    $statusLabel =
                                        'Expired';

                                    $statusClass =
                                        'status-expired';

                                } elseif ($daysLeft <= 30) {

                                    $statusLabel =
                                        'Akan Habis';

                                    $statusClass =
                                        'status-warning';

                                } else {

                                    $statusLabel =
                                        'Digunakan';

                                    $statusClass =
                                        'status-active';

                                }

                            }


                            /*
                             * VERIFIKASI
                             */

                            $verifikasi =
                                strtolower(
                                    $dataCenter->verifikasi
                                    ?? 'menunggu'
                                );


                            $verifikasiLabel =
                                match ($verifikasi) {

                                    'disetujui',
                                    'approved',
                                    'approve'
                                        => 'Disetujui',

                                    'ditolak',
                                    'rejected',
                                    'reject'
                                        => 'Ditolak',

                                    default
                                        => 'Menunggu',

                                };


                            $verifikasiClass =
                                match ($verifikasi) {

                                    'disetujui',
                                    'approved',
                                    'approve'
                                        => 'verifikasi-disetujui',

                                    'ditolak',
                                    'rejected',
                                    'reject'
                                        => 'verifikasi-ditolak',

                                    default
                                        => 'verifikasi-menunggu',

                                };


                            /*
                             * TAHUN
                             */

                            $tahunData = null;

                            if (
                                $dataCenter->tanggal_pengadaan
                            ) {

                                $tahunData =
                                    \Carbon\Carbon::parse(
                                        $dataCenter->tanggal_pengadaan
                                    )->format('Y');

                            }

                        @endphp


                        <tr
                            data-search="{{ strtolower(
                                ($dataCenter->id ?? '') . ' ' .
                                ($dataCenter->nama_infrastruktur ?? '') . ' ' .
                                ($dataCenter->spesifikasi ?? '') . ' ' .
                                ($dataCenter->pengadaan ?? '') . ' ' .
                                ($dataCenter->harga ?? '') . ' ' .
                                ($statusLabel ?? '') . ' ' .
                                ($verifikasiLabel ?? '') . ' ' .
                                ($dataCenter->komentar ?? '')
                            ) }}"
                            data-status="{{ strtolower($statusLabel) }}"
                            data-pengadaan="{{ strtolower($dataCenter->pengadaan ?? '') }}"
                            data-verifikasi="{{ strtolower($verifikasiLabel) }}"
                            data-tahun="{{ $tahunData }}"
                        >


                            {{-- NO --}}

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            {{-- ID --}}

                            <td>

                                <span class="data-center-code">

                                    {{ $dataCenter->id }}

                                </span>

                            </td>


                            {{-- NAMA --}}

                            <td>

                                <div class="data-center-name">

                                    {{ $dataCenter->nama_infrastruktur }}

                                </div>

                            </td>


                            {{-- SPESIFIKASI --}}

                            <td>

                                @if($dataCenter->spesifikasi)

                                    <div class="data-center-spec">

                                        {{ $dataCenter->spesifikasi }}

                                    </div>

                                @else

                                    <span class="data-center-date-empty">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- PENGADAAN --}}

                            <td>

                                @if(
                                    strtolower(
                                        $dataCenter->pengadaan ?? ''
                                    ) === 'sewa'
                                )

                                    <span
                                        class="procurement-badge procurement-sewa"
                                    >
                                        Sewa
                                    </span>

                                @else

                                    <span
                                        class="procurement-badge procurement-beli"
                                    >
                                        Beli
                                    </span>

                                @endif

                            </td>


                            {{-- HARGA --}}

                            <td>

                                <span class="data-center-price">

                                    Rp
                                    {{ number_format(
                                        (float) ($dataCenter->harga ?? 0),
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </span>

                            </td>


                            {{-- TANGGAL PENGADAAN --}}

                            <td>

                                @if($dataCenter->tanggal_pengadaan)

                                    <span class="data-center-date">

                                        {{ \Carbon\Carbon::parse(
                                            $dataCenter->tanggal_pengadaan
                                        )->format('d M Y') }}

                                    </span>

                                @else

                                    <span class="data-center-date-empty">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- TANGGAL BERAKHIR --}}

                            <td>

                                @if($dataCenter->tanggal_berakhir)

                                    <span class="data-center-date">

                                        {{ \Carbon\Carbon::parse(
                                            $dataCenter->tanggal_berakhir
                                        )->format('d M Y') }}

                                    </span>

                                @else

                                    <span class="data-center-date-empty">
                                        Tidak Berakhir
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS --}}

                            <td>

                                <span
                                    class="data-center-status-badge {{ $statusClass }}"
                                >

                                    {{ $statusLabel }}

                                </span>

                            </td>


                            {{-- VERIFIKASI --}}

                            <td>

                                <span
                                    class="verifikasi-badge {{ $verifikasiClass }}"
                                >

                                    {{ $verifikasiLabel }}

                                </span>

                            </td>


                            {{-- KOMENTAR --}}

                            <td>

                                @if($dataCenter->komentar)

                                    <div class="data-center-comment">

                                        {{ $dataCenter->komentar }}

                                    </div>

                                @else

                                    <span class="data-center-date-empty">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- AKSI --}}

                            <td>

                                <div class="data-center-action-buttons">


                                    {{-- EDIT --}}

                                    <button
                                        type="button"
                                        class="data-center-action-button data-center-edit-button"
                                        title="Edit"
                                        onclick="openEditDataCenterModal(@js($dataCenter->id))"
                                    >

                                        <i class="bi bi-pencil-fill"></i>

                                    </button>


                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route(
                                            'data-center.destroy',
                                            $dataCenter->id
                                        ) }}"
                                        method="POST"
                                        class="data-center-delete-form"
                                        onsubmit="return confirm(
                                            'Yakin ingin menghapus data Data Center ini?'
                                        );"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="data-center-action-button data-center-delete-button"
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
                                colspan="12"
                                style="padding:0;"
                            >

                                <div class="data-center-empty-state">

                                    <div class="data-center-empty-icon">

                                        <i class="bi bi-server"></i>

                                    </div>

                                    <h3>
                                        Belum ada data Data Center
                                    </h3>

                                    <p>
                                        Data infrastruktur Data Center belum tersedia.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =================================================
             TABLE FOOTER
        ================================================== --}}

        @if(
            method_exists($dataCenters, 'links')
            &&
            $dataCenters->hasPages()
        )

            <div class="data-center-table-footer">

                <span class="data-center-showing-text">

                    Menampilkan
                    {{ $dataCenters->firstItem() }}
                    -
                    {{ $dataCenters->lastItem() }}
                    dari
                    {{ $dataCenters->total() }}
                    data

                </span>

                <div>
                    {{ $dataCenters->links() }}
                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     MODAL TAMBAH / EDIT DATA CENTER
========================================================= --}}

<div
    id="dataCenterModal"
    class="data-center-modal-overlay"
    aria-hidden="true"
>

    <div
        class="data-center-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="dataCenterModalTitle"
    >


        {{-- =================================================
             MODAL HEADER
        ================================================== --}}

        <div class="data-center-modal-header">

            <div class="data-center-modal-header-left">

                <div class="data-center-modal-icon">

                    <i class="bi bi-server"></i>

                </div>


                <div class="data-center-modal-header-text">

                    <h2 id="dataCenterModalTitle">
                        Tambah Data Center
                    </h2>

                    <p id="dataCenterModalDescription">
                        Masukan detail infrastruktur Data Center baru ke dalam sistem.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="data-center-modal-close"
                onclick="closeDataCenterModal()"
                title="Tutup"
            >

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        {{-- =================================================
             FORM
        ================================================== --}}

        <form
            id="dataCenterForm"
            method="POST"
        >

            @csrf

            <input
                type="hidden"
                name="_method"
                id="dataCenterMethod"
                value="POST"
            >


            {{-- =================================================
                 MODAL BODY
            ================================================== --}}

            <div class="data-center-modal-body">


                {{-- =================================================
                     INFORMASI DATA CENTER
                ================================================== --}}

                <div class="data-center-form-card">


                    <div class="data-center-form-card-header">

                        <i class="bi bi-server"></i>

                        <h3>
                            Informasi Data Center
                        </h3>

                    </div>


                    <div class="data-center-form-grid">


                        {{-- ID --}}

                        <div class="data-center-form-group">

                            <label for="data_center_id">

                                ID Data Center

                            </label>

                            <input
                                type="text"
                                id="data_center_id"
                                name="id"
                                value="{{ old('id') }}"
                                placeholder="ID Data Center"
                                readonly
                            >

                            <small class="data-center-form-info">

                                <i class="bi bi-info-circle"></i>

                                ID dibuat otomatis oleh sistem.

                            </small>

                        </div>


                        {{-- NAMA --}}

                        <div class="data-center-form-group">

                            <label for="data_center_nama_infrastruktur">

                                Nama Infrastruktur

                                <span>*</span>

                            </label>

                            <input
                                type="text"
                                id="data_center_nama_infrastruktur"
                                name="nama_infrastruktur"
                                value="{{ old('nama_infrastruktur') }}"
                                placeholder="Masukkan nama infrastruktur Data Center"
                                required
                            >

                            @error('nama_infrastruktur')

                                <small class="data-center-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        {{-- SPESIFIKASI --}}

                        <div class="data-center-form-group full">

                            <label for="data_center_spesifikasi">

                                Spesifikasi

                            </label>

                            <textarea
                                id="data_center_spesifikasi"
                                name="spesifikasi"
                                placeholder="Masukkan spesifikasi Data Center"
                            >{{ old('spesifikasi') }}</textarea>

                            @error('spesifikasi')

                                <small class="data-center-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                    </div>

                </div>


                {{-- =================================================
                     PENGADAAN
                ================================================== --}}

                <div class="data-center-form-card">


                    <div class="data-center-form-card-header">

                        <i class="bi bi-receipt"></i>

                        <h3>
                            Pengadaan
                        </h3>

                    </div>


                    <div class="data-center-form-grid">


                        {{-- PENGADAAN --}}

                        <div class="data-center-form-group">

                            <label for="data_center_pengadaan">

                                Pengadaan

                                <span>*</span>

                            </label>

                            <select
                                id="data_center_pengadaan"
                                name="pengadaan"
                                onchange="updateDataCenterPengadaan()"
                                required
                            >

                                <option value="">
                                    Pilih pengadaan
                                </option>

                                <option
                                    value="Beli"
                                    {{ old('pengadaan') === 'Beli' ? 'selected' : '' }}
                                >
                                    Beli
                                </option>

                                <option
                                    value="Sewa"
                                    {{ old('pengadaan') === 'Sewa' ? 'selected' : '' }}
                                >
                                    Sewa
                                </option>

                            </select>

                            @error('pengadaan')

                                <small class="data-center-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        {{-- HARGA --}}

                        <div class="data-center-form-group">

                            <label for="data_center_harga">

                                Harga

                                <span>*</span>

                            </label>

                            <div class="data-center-price-input">

                                <span class="data-center-price-prefix">
                                    Rp
                                </span>

                                <input
                                    type="number"
                                    id="data_center_harga"
                                    name="harga"
                                    value="{{ old('harga') }}"
                                    placeholder="0"
                                    min="0"
                                    step="0.01"
                                    required
                                >

                            </div>

                            @error('harga')

                                <small class="data-center-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        {{-- TANGGAL PENGADAAN --}}

                        <div class="data-center-form-group">

                            <label for="data_center_tanggal_pengadaan">

                                Tanggal Pengadaan

                                <span>*</span>

                            </label>

                            <input
                                type="date"
                                id="data_center_tanggal_pengadaan"
                                name="tanggal_pengadaan"
                                value="{{ old('tanggal_pengadaan') }}"
                                onchange="calculateDataCenterEndDate()"
                                required
                            >

                            @error('tanggal_pengadaan')

                                <small class="data-center-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        {{-- TANGGAL BERAKHIR --}}

                        <div class="data-center-form-group">

                            <label for="data_center_tanggal_berakhir">

                                Tanggal Berakhir

                            </label>

                            <input
                                type="date"
                                id="data_center_tanggal_berakhir"
                                name="tanggal_berakhir"
                                value="{{ old('tanggal_berakhir') }}"
                            >

                            <small class="data-center-form-info">

                                <i class="bi bi-info-circle"></i>

                                Untuk pembelian, tanggal berakhir dapat dikosongkan.

                            </small>

                            @error('tanggal_berakhir')

                                <small class="data-center-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                    </div>


                    {{-- =================================================
                         SEWA
                    ================================================== --}}

                    <div
                        id="dataCenterSewaSection"
                        class="{{ old('pengadaan') === 'Sewa' ? 'show' : '' }}"
                    >

                        <div class="data-center-sewa-title">

                            Periode Sewa

                        </div>


                        <div class="data-center-sewa-grid">


                            {{-- PERIODE --}}

                            <div class="data-center-form-group">

                                <label for="data_center_periode_sewa">

                                    Periode Pembayaran

                                </label>

                                <select
                                    id="data_center_periode_sewa"
                                    name="periode_sewa"
                                    onchange="updateDataCenterCustomPeriod(); calculateDataCenterEndDate();"
                                >

                                    <option value="">
                                        Pilih periode
                                    </option>

                                    <option
                                        value="Monthly"
                                        {{ old('periode_sewa') === 'Monthly' ? 'selected' : '' }}
                                    >
                                        Monthly
                                    </option>

                                    <option
                                        value="3 Months"
                                        {{ old('periode_sewa') === '3 Months' ? 'selected' : '' }}
                                    >
                                        3 Months
                                    </option>

                                    <option
                                        value="6 Months"
                                        {{ old('periode_sewa') === '6 Months' ? 'selected' : '' }}
                                    >
                                        6 Months
                                    </option>

                                    <option
                                        value="Yearly"
                                        {{ old('periode_sewa') === 'Yearly' ? 'selected' : '' }}
                                    >
                                        Yearly
                                    </option>

                                    <option
                                        value="Custom"
                                        {{ old('periode_sewa') === 'Custom' ? 'selected' : '' }}
                                    >
                                        Custom
                                    </option>

                                </select>

                            </div>


                            {{-- KETERANGAN --}}

                            <div class="data-center-form-group">

                                <label>
                                    Keterangan
                                </label>

                                <div
                                    class="data-center-form-info"
                                    style="margin-top:10px;"
                                >

                                    <i class="bi bi-info-circle"></i>

                                    Pilih periode sesuai dengan kontrak atau pembayaran Data Center.

                                </div>

                            </div>


                        </div>


                        {{-- CUSTOM --}}

                        <div
                            id="dataCenterCustomPeriod"
                            class="{{ old('periode_sewa') === 'Custom' ? 'show' : '' }}"
                        >


                            <div class="data-center-form-group">

                                <label for="data_center_durasi_sewa">

                                    Durasi

                                </label>

                                <input
                                    type="number"
                                    id="data_center_durasi_sewa"
                                    name="durasi_sewa"
                                    value="{{ old('durasi_sewa') }}"
                                    min="1"
                                    placeholder="Contoh: 18"
                                    onchange="calculateDataCenterEndDate()"
                                >

                            </div>


                            <div class="data-center-form-group">

                                <label for="data_center_satuan_sewa">

                                    Satuan

                                </label>

                                <select
                                    id="data_center_satuan_sewa"
                                    name="satuan_sewa"
                                    onchange="calculateDataCenterEndDate()"
                                >

                                    <option value="Months">
                                        Bulan
                                    </option>

                                    <option
                                        value="Years"
                                        {{ old('satuan_sewa') === 'Years' ? 'selected' : '' }}
                                    >
                                        Tahun
                                    </option>

                                </select>

                            </div>


                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 FOOTER
            ================================================== --}}

            <div class="data-center-modal-footer">

                <button
                    type="button"
                    class="data-center-btn-batal"
                    onclick="closeDataCenterModal()"
                >

                    Batal

                </button>


                <button
                    type="submit"
                    class="data-center-btn-simpan"
                    id="dataCenterSaveButton"
                >

                    <i class="bi bi-check-lg"></i>

                    Simpan Data Center

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

document.addEventListener('DOMContentLoaded', function () {


    /* =====================================================
       SEARCH & FILTER
    ===================================================== */

    const searchInput =
        document.getElementById('dataCenterSearch');

    const statusFilter =
        document.getElementById('dataCenterStatusFilter');

    const pengadaanFilter =
        document.getElementById('dataCenterPengadaanFilter');

    const verifikasiFilter =
        document.getElementById('dataCenterVerifikasiFilter');

    const tahunFilter =
        document.getElementById('dataCenterTahunFilter');

    const tableBody =
        document.getElementById('dataCenterTableBody');


    function filterDataCenterTable() {

        if (!tableBody) {
            return;
        }


        const rows =
            tableBody.querySelectorAll(
                'tr[data-search]'
            );


        const searchValue =
            (searchInput?.value || '')
                .toLowerCase()
                .trim();


        const statusValue =
            (statusFilter?.value || '')
                .toLowerCase()
                .trim();


        const pengadaanValue =
            (pengadaanFilter?.value || '')
                .toLowerCase()
                .trim();


        const verifikasiValue =
            (verifikasiFilter?.value || '')
                .toLowerCase()
                .trim();


        const tahunValue =
            (tahunFilter?.value || '')
                .toLowerCase()
                .trim();


        rows.forEach(function (row) {

            const rowSearch =
                row.dataset.search || '';

            const rowStatus =
                row.dataset.status || '';

            const rowPengadaan =
                row.dataset.pengadaan || '';

            const rowVerifikasi =
                row.dataset.verifikasi || '';

            const rowTahun =
                row.dataset.tahun || '';


            const matchSearch =
                !searchValue ||
                rowSearch.includes(searchValue);


            const matchStatus =
                !statusValue ||
                rowStatus === statusValue;


            const matchPengadaan =
                !pengadaanValue ||
                rowPengadaan === pengadaanValue;


            const matchVerifikasi =
                !verifikasiValue ||
                rowVerifikasi === verifikasiValue;


            const matchTahun =
                !tahunValue ||
                rowTahun === tahunValue;


            row.style.display =
                matchSearch &&
                matchStatus &&
                matchPengadaan &&
                matchVerifikasi &&
                matchTahun
                    ? ''
                    : 'none';

        });

    }


    if (searchInput) {

        searchInput.addEventListener(
            'input',
            filterDataCenterTable
        );

    }


    if (statusFilter) {

        statusFilter.addEventListener(
            'change',
            filterDataCenterTable
        );

    }


    if (pengadaanFilter) {

        pengadaanFilter.addEventListener(
            'change',
            filterDataCenterTable
        );

    }


    if (verifikasiFilter) {

        verifikasiFilter.addEventListener(
            'change',
            filterDataCenterTable
        );

    }


    if (tahunFilter) {

        tahunFilter.addEventListener(
            'change',
            filterDataCenterTable
        );

    }


    /* =====================================================
       MODAL OVERLAY
    ===================================================== */

    const modal =
        document.getElementById(
            'dataCenterModal'
        );


    if (modal) {

        modal.addEventListener(
            'click',
            function (event) {

                if (
                    event.target === modal
                ) {

                    closeDataCenterModal();

                }

            }
        );

    }


    /* =====================================================
       ESCAPE
    ===================================================== */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape' &&
                modal?.classList.contains('show')
            ) {

                closeDataCenterModal();

            }

        }
    );


    /* =====================================================
       INITIAL PENGADAAN
    ===================================================== */

    updateDataCenterPengadaan();


    /* =====================================================
       VALIDATION ERROR
    ===================================================== */

    @if($errors->any())

        openAddDataCenterModal();

    @endif

});


/* =========================================================
   OPEN ADD MODAL
========================================================= */

function openAddDataCenterModal()
{

    const modal =
        document.getElementById(
            'dataCenterModal'
        );

    const form =
        document.getElementById(
            'dataCenterForm'
        );


    if (!modal || !form) {
        return;
    }


    form.action =
        "{{ route('data-center.store') }}";


    document.getElementById(
        'dataCenterMethod'
    ).value = 'POST';


    document.getElementById(
        'dataCenterModalTitle'
    ).textContent =
        'Tambah Data Center';


    document.getElementById(
        'dataCenterModalDescription'
    ).textContent =
        'Masukan detail infrastruktur Data Center baru ke dalam sistem.';


    document.getElementById(
        'dataCenterSaveButton'
    ).innerHTML =
        '<i class="bi bi-check-lg"></i> Simpan Data Center';


    /*
     * Jangan reset ketika validation error
     */

    @if(!$errors->any())

        form.reset();


        document.getElementById(
            'data_center_id'
        ).value = '';


        document.getElementById(
            'dataCenterSewaSection'
        ).classList.remove('show');


        document.getElementById(
            'dataCenterCustomPeriod'
        ).classList.remove('show');


        const tanggalBerakhir =
            document.getElementById(
                'data_center_tanggal_berakhir'
            );


        if (tanggalBerakhir) {

            tanggalBerakhir.readOnly = false;

            tanggalBerakhir.style.background =
                'white';

        }

    @endif


    modal.classList.add('show');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add(
        'data-center-modal-open'
    );

}


/* =========================================================
   OPEN EDIT MODAL
========================================================= */

function openEditDataCenterModal(id)
{

    const dataCenters =
        @php

            $dataCenterJson =
                method_exists(
                    $dataCenters,
                    'getCollection'
                )
                    ? $dataCenters->getCollection()
                    : collect($dataCenters);

        @endphp

        @json($dataCenterJson->values());


    const dataCenter =
        dataCenters.find(
            function (item) {

                return String(item.id) === String(id);

            }
        );


    if (!dataCenter) {

        alert(
            'Data Data Center tidak ditemukan.'
        );

        return;

    }


    const modal =
        document.getElementById(
            'dataCenterModal'
        );

    const form =
        document.getElementById(
            'dataCenterForm'
        );


    if (!modal || !form) {
        return;
    }


    form.action =
        "{{ url('/infrastruktur/data-center') }}/" +
        encodeURIComponent(id);


    document.getElementById(
        'dataCenterMethod'
    ).value = 'PUT';


    document.getElementById(
        'dataCenterModalTitle'
    ).textContent =
        'Edit Data Center';


    document.getElementById(
        'dataCenterModalDescription'
    ).textContent =
        'Perbarui data infrastruktur Data Center yang dipilih.';


    document.getElementById(
        'dataCenterSaveButton'
    ).innerHTML =
        '<i class="bi bi-check-lg"></i> Simpan Perubahan';


    /* =====================================================
       ISI FORM
    ===================================================== */

    document.getElementById(
        'data_center_id'
    ).value =
        dataCenter.id ?? '';


    document.getElementById(
        'data_center_nama_infrastruktur'
    ).value =
        dataCenter.nama_infrastruktur ?? '';


    document.getElementById(
        'data_center_spesifikasi'
    ).value =
        dataCenter.spesifikasi ?? '';


    document.getElementById(
        'data_center_pengadaan'
    ).value =
        dataCenter.pengadaan ?? '';


    document.getElementById(
        'data_center_harga'
    ).value =
        dataCenter.harga ?? '';


    document.getElementById(
        'data_center_tanggal_pengadaan'
    ).value =
        formatDataCenterDate(
            dataCenter.tanggal_pengadaan
        );


    document.getElementById(
        'data_center_tanggal_berakhir'
    ).value =
        formatDataCenterDate(
            dataCenter.tanggal_berakhir
        );


    document.getElementById(
        'data_center_periode_sewa'
    ).value =
        dataCenter.periode_sewa ?? '';


    document.getElementById(
        'data_center_durasi_sewa'
    ).value =
        dataCenter.durasi_sewa ?? '';


    document.getElementById(
        'data_center_satuan_sewa'
    ).value =
        dataCenter.satuan_sewa ?? 'Months';


    updateDataCenterPengadaan();

    updateDataCenterCustomPeriod();


    modal.classList.add('show');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add(
        'data-center-modal-open'
    );

}


/* =========================================================
   FORMAT DATE
========================================================= */

function formatDataCenterDate(value)
{

    if (!value) {
        return '';
    }


    if (
        typeof value === 'string' &&
        /^\d{4}-\d{2}-\d{2}$/.test(value)
    ) {

        return value;

    }


    const date =
        new Date(value);


    if (isNaN(date.getTime())) {
        return '';
    }


    const year =
        date.getFullYear();


    const month =
        String(
            date.getMonth() + 1
        ).padStart(2, '0');


    const day =
        String(
            date.getDate()
        ).padStart(2, '0');


    return (
        year +
        '-' +
        month +
        '-' +
        day
    );

}


/* =========================================================
   CLOSE MODAL
========================================================= */

function closeDataCenterModal()
{

    const modal =
        document.getElementById(
            'dataCenterModal'
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
        'data-center-modal-open'
    );

}


/* =========================================================
   PENGADAAN
========================================================= */

function updateDataCenterPengadaan()
{

    const pengadaan =
        document.getElementById(
            'data_center_pengadaan'
        )?.value;


    const sewaSection =
        document.getElementById(
            'dataCenterSewaSection'
        );


    const tanggalBerakhir =
        document.getElementById(
            'data_center_tanggal_berakhir'
        );


    if (!sewaSection) {
        return;
    }


    if (
        String(pengadaan).toLowerCase()
        === 'sewa'
    ) {

        sewaSection.classList.add(
            'show'
        );


        if (tanggalBerakhir) {

            tanggalBerakhir.readOnly =
                true;

            tanggalBerakhir.style.background =
                '#f8fafc';

        }


        calculateDataCenterEndDate();

    } else {

        sewaSection.classList.remove(
            'show'
        );


        document.getElementById(
            'dataCenterCustomPeriod'
        )?.classList.remove('show');


        if (tanggalBerakhir) {

            tanggalBerakhir.readOnly =
                false;

            tanggalBerakhir.style.background =
                'white';

        }

    }

}


/* =========================================================
   CUSTOM PERIOD
========================================================= */

function updateDataCenterCustomPeriod()
{

    const periode =
        document.getElementById(
            'data_center_periode_sewa'
        )?.value;


    const custom =
        document.getElementById(
            'dataCenterCustomPeriod'
        );


    if (!custom) {
        return;
    }


    if (periode === 'Custom') {

        custom.classList.add(
            'show'
        );

    } else {

        custom.classList.remove(
            'show'
        );

    }

}


/* =========================================================
   CALCULATE END DATE
========================================================= */

function calculateDataCenterEndDate()
{

    const pengadaan =
        document.getElementById(
            'data_center_pengadaan'
        )?.value;


    if (
        String(pengadaan).toLowerCase()
        !== 'sewa'
    ) {

        return;

    }


    const tanggalMulai =
        document.getElementById(
            'data_center_tanggal_pengadaan'
        )?.value;


    const periode =
        document.getElementById(
            'data_center_periode_sewa'
        )?.value;


    const tanggalBerakhir =
        document.getElementById(
            'data_center_tanggal_berakhir'
        );


    if (
        !tanggalMulai ||
        !periode ||
        !tanggalBerakhir
    ) {

        return;

    }


    const date =
        new Date(
            tanggalMulai + 'T00:00:00'
        );


    if (isNaN(date.getTime())) {
        return;
    }


    switch (periode) {

        case 'Monthly':

            date.setMonth(
                date.getMonth() + 1
            );

            break;


        case '3 Months':

            date.setMonth(
                date.getMonth() + 3
            );

            break;


        case '6 Months':

            date.setMonth(
                date.getMonth() + 6
            );

            break;


        case 'Yearly':

            date.setFullYear(
                date.getFullYear() + 1
            );

            break;


        case 'Custom':

            const duration =
                parseInt(
                    document.getElementById(
                        'data_center_durasi_sewa'
                    )?.value || 0
                );


            const unit =
                document.getElementById(
                    'data_center_satuan_sewa'
                )?.value;


            if (
                !duration ||
                duration < 1
            ) {

                return;

            }


            if (unit === 'Years') {

                date.setFullYear(
                    date.getFullYear() +
                    duration
                );

            } else {

                date.setMonth(
                    date.getMonth() +
                    duration
                );

            }

            break;


        default:

            return;

    }


    /* =====================================================
       FORMAT YYYY-MM-DD
    ===================================================== */

    const year =
        date.getFullYear();


    const month =
        String(
            date.getMonth() + 1
        ).padStart(2, '0');


    const day =
        String(
            date.getDate()
        ).padStart(2, '0');


    tanggalBerakhir.value =
        year +
        '-' +
        month +
        '-' +
        day;

}

</script>

@endpush

@endsection
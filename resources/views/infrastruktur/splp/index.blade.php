@extends('layouts.app')

@section('title', 'SPLP')

@section('page-title', 'SPLP')

@section('content')

<style>

/* =========================================================
   SPLP PAGE
========================================================= */

.splp-page {
    width: 100%;
}


/* =========================================================
   HEADER
========================================================= */

.splp-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.splp-heading h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
}

.splp-heading p {
    margin: 6px 0 0;
    font-size: 13px;
    color: #6b7280;
}

.add-splp-button {
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

.add-splp-button:hover {
    background: #050f63;
    color: white;
    transform: translateY(-1px);
}

.add-splp-button i {
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

.splp-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;

    margin-bottom: 25px;
}

.splp-stat-card {
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

.splp-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(0, 0, 0, 0.08);
}

.splp-stat-icon {
    width: 45px;
    height: 45px;

    flex-shrink: 0;

    border-radius: 12px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 20px;
}

.splp-stat-icon.blue {
    background: #e0f2fe;
    color: #0284c7;
}

.splp-stat-icon.orange {
    background: #ffedd5;
    color: #ea580c;
}

.splp-stat-icon.green {
    background: #dcfce7;
    color: #16a34a;
}

.splp-stat-icon.red {
    background: #fee2e2;
    color: #dc2626;
}

.splp-stat-content {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.splp-stat-label {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 5px;
}

.splp-stat-value {
    font-size: 23px;
    font-weight: 700;
    color: #075985;
    line-height: 1.2;
}

.splp-stat-description {
    margin-top: 7px;
    font-size: 10px;
    color: #9ca3af;
}


/* =========================================================
   TABLE CARD
========================================================= */

.splp-table-card {
    background: white;

    border: 1px solid #e5e7eb;
    border-radius: 14px;

    overflow: hidden;

    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.04);
}


/* =========================================================
   TABLE HEADER
========================================================= */

.splp-table-header {
    padding: 20px 22px;

    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;

    border-bottom: 1px solid #e5e7eb;
}

.splp-table-header-left {
    display: flex;
    align-items: center;
    gap: 8px;
}

.splp-table-title {
    margin: 0;

    font-size: 16px;
    font-weight: 700;

    color: #1f2937;
}

.splp-table-count {
    font-size: 12px;
    color: #6b7280;
}


/* =========================================================
   TOOLBAR
========================================================= */

.splp-toolbar {
    display: flex;
    align-items: center;
    gap: 9px;
}

.splp-search {
    position: relative;
}

.splp-search i {
    position: absolute;

    left: 12px;
    top: 50%;

    transform: translateY(-50%);

    color: #94a3b8;

    font-size: 14px;
}

.splp-search input {
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

.splp-search input:focus {
    border-color: #079bd8;
    box-shadow: 0 0 0 3px rgba(7, 155, 216, 0.10);
}

.splp-filter-select {
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

.splp-filter-select:focus {
    border-color: #079bd8;
}


/* =========================================================
   TABLE
========================================================= */

.splp-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.splp-table {
    width: 100%;

    border-collapse: collapse;

    min-width: 1150px;
}

.splp-table th {
    padding: 14px 16px;

    background: #f8fafc;

    border-bottom: 1px solid #e5e7eb;

    color: #475569;

    font-size: 12px;
    font-weight: 700;

    text-align: left;

    white-space: nowrap;
}

.splp-table td {
    padding: 15px 16px;

    border-bottom: 1px solid #f1f5f9;

    color: #374151;

    font-size: 13px;

    vertical-align: middle;
}

.splp-table tbody tr {
    transition: 0.15s ease;
}

.splp-table tbody tr:hover {
    background: #f8fafc;
}

.splp-table tbody tr:last-child td {
    border-bottom: none;
}


/* =========================================================
   ID
========================================================= */

.splp-code {
    font-weight: 700;
    color: #075985;

    white-space: nowrap;
}


/* =========================================================
   NAME
========================================================= */

.splp-name {
    font-weight: 600;
    color: #1f2937;
}

.splp-spec {
    margin-top: 3px;

    font-size: 11px;
    color: #9ca3af;

    max-width: 230px;
}


/* =========================================================
   PROCUREMENT
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

.splp-price {
    font-weight: 600;
    color: #374151;

    white-space: nowrap;
}


/* =========================================================
   DATE
========================================================= */

.splp-date {
    white-space: nowrap;
    color: #4b5563;
}

.splp-date-empty {
    color: #9ca3af;
}


/* =========================================================
   STATUS
========================================================= */

.splp-status-badge {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    padding: 5px 10px;

    border-radius: 20px;

    font-size: 11px;
    font-weight: 600;

    white-space: nowrap;
}

.status-active {
    background: #dcfce7;
    color: #166534;
}

.status-warning {
    background: #fef3c7;
    color: #92400e;
}

.status-expired {
    background: #fee2e2;
    color: #991b1b;
}

.status-perpetual {
    background: #e0f2fe;
    color: #075985;
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

.splp-action-buttons {
    display: flex;
    align-items: center;
    gap: 7px;
}

.splp-action-button {
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

.splp-edit-button {
    background: #e0f2fe;
    color: #075985;
}

.splp-edit-button:hover {
    background: #bae6fd;
    color: #075985;
}

.splp-delete-button {
    background: #fee2e2;
    color: #dc2626;
}

.splp-delete-button:hover {
    background: #fecaca;
    color: #dc2626;
}

.splp-action-button i {
    font-size: 14px;
}

.splp-delete-form {
    display: inline;
}


/* =========================================================
   EMPTY STATE
========================================================= */

.splp-empty-state {
    padding: 55px 20px;

    text-align: center;
}

.splp-empty-icon {
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

.splp-empty-icon i {
    font-size: 27px;
}

.splp-empty-state h3 {
    margin: 0 0 6px;

    font-size: 15px;
    color: #374151;
}

.splp-empty-state p {
    margin: 0;

    font-size: 12px;
    color: #9ca3af;
}


/* =========================================================
   PAGINATION
========================================================= */

.splp-table-footer {
    display: flex;

    justify-content: space-between;
    align-items: center;

    padding: 15px 20px;

    border-top: 1px solid #e5e7eb;
}

.splp-showing-text {
    font-size: 11px;
    color: #6b7280;
}


/* =========================================================
   MODAL OVERLAY
========================================================= */

.splp-modal-overlay {
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

.splp-modal-overlay.show {
    display: flex;
}


/* =========================================================
   MODAL
========================================================= */

.splp-modal {
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

    animation: splpModalIn 0.18s ease;
}

@keyframes splpModalIn {
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

.splp-modal-header {
    min-height: 78px;

    padding: 18px 22px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    border-bottom: 1px solid #e5e7eb;

    flex-shrink: 0;
}

.splp-modal-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}

.splp-modal-icon {
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

.splp-modal-icon i {
    font-size: 18px;
}

.splp-modal-header-text h2 {
    margin: 0;

    font-size: 17px;
    font-weight: 700;

    color: #1f2937;
}

.splp-modal-header-text p {
    margin: 4px 0 0;

    font-size: 11px;
    color: #6b7280;
}

.splp-modal-close {
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

.splp-modal-close:hover {
    background: #e2e8f0;
    color: #1f2937;
}


/* =========================================================
   MODAL FORM
========================================================= */

#splpForm {
    display: flex;
    flex-direction: column;

    flex: 1 1 auto;

    min-height: 0;

    height: 100%;

    overflow: hidden;
}

.splp-modal-body {
    padding: 24px;

    flex: 1 1 0%;

    min-height: 0;

    height: 0;

    overflow-y: scroll;
    overflow-x: hidden;

    -webkit-overflow-scrolling: touch;
}


/* =========================================================
   FORM CARD
========================================================= */

.splp-form-card {
    background: white;

    border: 1px solid #e5e7eb;

    border-radius: 14px;

    padding: 24px;

    margin-bottom: 18px;

    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.03);
}

.splp-form-card:last-child {
    margin-bottom: 0;
}

.splp-form-card-header {
    display: flex;
    align-items: center;
    gap: 9px;

    padding-bottom: 13px;

    margin-bottom: 20px;

    border-bottom: 1px solid #e5e7eb;
}

.splp-form-card-header i {
    color: #075985;
    font-size: 16px;
}

.splp-form-card-header h3 {
    margin: 0;

    font-size: 14px;
    font-weight: 700;

    color: #1f2937;
}


/* =========================================================
   FORM GRID
========================================================= */

.splp-form-grid {
    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 20px;
}

.splp-form-group {
    display: flex;
    flex-direction: column;
}

.splp-form-group.full {
    grid-column: 1 / -1;
}

.splp-form-group label {
    margin-bottom: 7px;

    font-size: 12px;
    font-weight: 600;

    color: #374151;
}

.splp-form-group label span {
    color: #dc2626;
}

.splp-form-group input,
.splp-form-group select,
.splp-form-group textarea {
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

.splp-form-group input,
.splp-form-group select {
    height: 40px;

    padding: 0 12px;
}

.splp-form-group textarea {
    min-height: 85px;

    padding: 10px 12px;

    resize: vertical;
}

.splp-form-group input:focus,
.splp-form-group select:focus,
.splp-form-group textarea:focus {
    border-color: #079bd8;

    box-shadow:
        0 0 0 3px rgba(7, 155, 216, 0.10);
}

.splp-form-group input[readonly] {
    background: #f8fafc;
    color: #64748b;
    cursor: not-allowed;
}

.splp-form-error {
    margin-top: 5px;

    font-size: 10px;

    color: #dc2626;
}


/* =========================================================
   PRICE
========================================================= */

.splp-price-input {
    position: relative;
}

.splp-price-prefix {
    position: absolute;

    left: 12px;
    top: 50%;

    transform: translateY(-50%);

    font-size: 12px;
    font-weight: 600;

    color: #64748b;

    pointer-events: none;
}

.splp-price-input input {
    padding-left: 38px;
}


/* =========================================================
   SEWA
========================================================= */

#splpSewaSection {
    display: none;

    margin-top: 20px;

    padding: 18px;

    background: #f8fafc;

    border: 1px solid #e2e8f0;

    border-radius: 10px;
}

#splpSewaSection.show {
    display: block;
}

.splp-sewa-title {
    margin-bottom: 15px;

    font-size: 12px;
    font-weight: 700;

    color: #075985;
}

.splp-sewa-grid {
    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 16px;
}


/* =========================================================
   CUSTOM PERIOD
========================================================= */

#splpCustomPeriod {
    display: none;

    margin-top: 16px;
}

#splpCustomPeriod.show {
    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 16px;
}


/* =========================================================
   INFO
========================================================= */

.splp-form-info {
    margin-top: 6px;

    font-size: 10px;

    line-height: 1.5;

    color: #9ca3af;
}

.splp-form-info i {
    margin-right: 3px;
}


/* =========================================================
   MODAL FOOTER
========================================================= */

.splp-modal-footer {
    display: flex;

    justify-content: flex-end;

    align-items: center;

    gap: 10px;

    padding: 16px 24px;

    border-top: 1px solid #e5e7eb;

    background: white;

    flex-shrink: 0;
}

.splp-btn-batal,
.splp-btn-simpan {
    height: 40px;

    padding: 0 18px;

    border-radius: 8px;

    font-size: 12px;

    font-weight: 600;

    cursor: pointer;

    transition: 0.2s ease;
}

.splp-btn-batal {
    border: 1px solid #d1d5db;

    background: white;

    color: #4b5563;
}

.splp-btn-batal:hover {
    background: #f8fafc;
}

.splp-btn-simpan {
    border: none;

    background: #079bd8;

    color: white;
}

.splp-btn-simpan:hover {
    background: #075985;
}

.splp-btn-simpan i {
    margin-right: 5px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1200px) {

    .splp-stats {
        grid-template-columns: repeat(3, 1fr);
    }

}

@media (max-width: 900px) {

    .splp-header {
        align-items: flex-start;
        flex-direction: column;
        gap: 15px;
    }

    .add-splp-button {
        width: 100%;
    }

    .splp-stats {
        grid-template-columns: repeat(2, 1fr);
    }

    .splp-table-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .splp-toolbar {
        width: 100%;
    }

    .splp-search {
        flex: 1;
    }

    .splp-search input {
        width: 100%;
    }

}

@media (max-width: 700px) {

    .splp-modal-overlay {
        padding: 15px;
    }

    .splp-modal {
        height: calc(100vh - 30px);
        max-height: calc(100vh - 30px);
    }

    .splp-modal-body {
        padding: 15px;
    }

    .splp-form-card {
        padding: 18px;
    }

    .splp-form-grid,
    .splp-sewa-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }

    #splpCustomPeriod.show {
        grid-template-columns: 1fr;
    }

    .splp-modal-footer {
        padding: 14px 15px;
    }

}

@media (max-width: 500px) {

    .splp-stats {
        grid-template-columns: 1fr;
    }

    .splp-toolbar {
        flex-direction: column;
        align-items: stretch;
    }

    .splp-filter-select {
        width: 100%;
    }

    .splp-modal-header {
        padding: 15px;
    }

}


/* =========================================================
   BODY LOCK
========================================================= */

body.splp-modal-open {
    overflow: hidden;
}

</style>


<div class="splp-page">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="splp-header">

        <div class="splp-heading">

            <h2>
                SPLP
            </h2>

            <p>
                Kelola data infrastruktur Sistem Pemerintahan Berbasis Elektronik (SPBE).
            </p>

        </div>


        <button
            type="button"
            class="add-splp-button"
            onclick="openAddSplpModal()"
        >

            <i class="bi bi-plus-lg"></i>

            <span>
                Tambah SPLP
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

    @php

        $splpCollection = method_exists($splps, 'getCollection')
            ? $splps->getCollection()
            : collect($splps);

        $totalSplpValue =
            $totalSplp
            ?? $splpCollection->count();

        $akanHabisValue =
            $akanHabis
            ?? $akanBerakhir
            ?? 0;

        $tidakBerakhirValue =
            $tidakBerakhir
            ?? 0;

        $expiredValue =
            $expired
            ?? 0;

    @endphp


    <div class="splp-stats">


        {{-- TOTAL --}}

        <div class="splp-stat-card">

            <div class="splp-stat-icon blue">

                <i class="bi bi-diagram-3-fill"></i>

            </div>

            <div class="splp-stat-content">

                <span class="splp-stat-label">
                    Total SPLP
                </span>

                <span class="splp-stat-value">
                    {{ $totalSplpValue }}
                </span>

                <span class="splp-stat-description">
                    Infrastruktur SPLP terdaftar
                </span>

            </div>

        </div>


        {{-- AKAN HABIS --}}

        <div class="splp-stat-card">

            <div class="splp-stat-icon orange">

                <i class="bi bi-clock-history"></i>

            </div>

            <div class="splp-stat-content">

                <span class="splp-stat-label">
                    Akan Habis
                </span>

                <span class="splp-stat-value">
                    {{ $akanHabisValue }}
                </span>

                <span class="splp-stat-description">
                    Berakhir dalam 30 hari
                </span>

            </div>

        </div>


        {{-- TIDAK BERAKHIR --}}

        <div class="splp-stat-card">

            <div class="splp-stat-icon green">

                <i class="bi bi-infinity"></i>

            </div>

            <div class="splp-stat-content">

                <span class="splp-stat-label">
                    Tidak Berakhir
                </span>

                <span class="splp-stat-value">
                    {{ $tidakBerakhirValue }}
                </span>

                <span class="splp-stat-description">
                    SPLP tanpa tanggal berakhir
                </span>

            </div>

        </div>


        {{-- EXPIRED --}}

        <div class="splp-stat-card">

            <div class="splp-stat-icon red">

                <i class="bi bi-x-circle-fill"></i>

            </div>

            <div class="splp-stat-content">

                <span class="splp-stat-label">
                    Expired
                </span>

                <span class="splp-stat-value">
                    {{ $expiredValue }}
                </span>

                <span class="splp-stat-description">
                    SPLP sudah berakhir
                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="splp-table-card">


        {{-- TABLE HEADER --}}

        <div class="splp-table-header">

            <div class="splp-table-header-left">

                <h3 class="splp-table-title">
                    Data SPLP
                </h3>

                <span class="splp-table-count">
                    ({{ $splpCollection->count() }} data)
                </span>

            </div>


            <div class="splp-toolbar">


                {{-- SEARCH --}}

                <div class="splp-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        id="splpSearch"
                        placeholder="Cari SPLP..."
                    >

                </div>


                {{-- STATUS --}}

                <select
                    id="splpStatusFilter"
                    class="splp-filter-select"
                >

                    <option value="">
                        Semua Status
                    </option>

                    <option value="tidak berakhir">
                        Tidak Berakhir
                    </option>

                    <option value="akan habis">
                        Akan Habis
                    </option>

                    <option value="digunakan">
                        Digunakan
                    </option>

                    <option value="expired">
                        Expired
                    </option>

                </select>


                {{-- VERIFIKASI --}}

                <select
                    id="splpVerifikasiFilter"
                    class="splp-filter-select"
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

            </div>

        </div>


        {{-- TABLE --}}

        <div class="splp-table-wrapper">

            <table class="splp-table">

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
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody id="splpTableBody">


                    @forelse($splpCollection as $splp)

                        @php

                            /*
                            |--------------------------------------------------------------------------
                            | STATUS OTOMATIS
                            |--------------------------------------------------------------------------
                            */

                            $statusLabel = 'Tidak Berakhir';

                            $statusClass = 'status-perpetual';


                            if (
                                strtolower($splp->pengadaan ?? '') === 'sewa'
                                && $splp->tanggal_berakhir
                            ) {

                                $today =
                                    now()
                                        ->startOfDay();

                                $endDate =
                                    \Carbon\Carbon::parse(
                                        $splp->tanggal_berakhir
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
                            |--------------------------------------------------------------------------
                            | VERIFIKASI
                            |--------------------------------------------------------------------------
                            */

                            $verifikasi =
                                strtolower(
                                    $splp->verifikasi
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

                        @endphp


                        <tr
                            data-search="{{ strtolower(
                                ($splp->id ?? '') . ' ' .
                                ($splp->nama_infrastruktur ?? '') . ' ' .
                                ($splp->spesifikasi ?? '') . ' ' .
                                ($splp->pengadaan ?? '') . ' ' .
                                ($statusLabel ?? '') . ' ' .
                                ($verifikasiLabel ?? '')
                            ) }}"
                            data-status="{{ strtolower($statusLabel) }}"
                            data-verifikasi="{{ strtolower($verifikasiLabel) }}"
                        >


                            {{-- NO --}}

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            {{-- ID --}}

                            <td>

                                <span class="splp-code">
                                    {{ $splp->id }}
                                </span>

                            </td>


                            {{-- NAMA --}}

                            <td>

                                <div class="splp-name">
                                    {{ $splp->nama_infrastruktur }}
                                </div>

                                @if($splp->spesifikasi)

                                    <div class="splp-spec">
                                        {{ $splp->spesifikasi }}
                                    </div>

                                @endif

                            </td>


                            {{-- PENGADAAN --}}

                            <td>

                                @if(
                                    strtolower(
                                        $splp->pengadaan ?? ''
                                    ) === 'sewa'
                                )

                                    <span class="procurement-badge procurement-sewa">
                                        Sewa
                                    </span>

                                @else

                                    <span class="procurement-badge procurement-beli">
                                        Beli
                                    </span>

                                @endif

                            </td>


                            {{-- HARGA --}}

                            <td>

                                <span class="splp-price">

                                    Rp
                                    {{ number_format(
                                        (float) ($splp->harga ?? 0),
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </span>

                            </td>


                            {{-- TANGGAL PENGADAAN --}}

                            <td>

                                @if($splp->tanggal_pengadaan)

                                    <span class="splp-date">

                                        {{ \Carbon\Carbon::parse(
                                            $splp->tanggal_pengadaan
                                        )->format('d M Y') }}

                                    </span>

                                @else

                                    <span class="splp-date-empty">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- TANGGAL BERAKHIR --}}

                            <td>

                                @if($splp->tanggal_berakhir)

                                    <span class="splp-date">

                                        {{ \Carbon\Carbon::parse(
                                            $splp->tanggal_berakhir
                                        )->format('d M Y') }}

                                    </span>

                                @else

                                    <span class="splp-date-empty">
                                        Tidak Berakhir
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS --}}

                            <td>

                                <span
                                    class="splp-status-badge {{ $statusClass }}"
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


                            {{-- AKSI --}}

                            <td>

                                <div class="splp-action-buttons">


                                    {{-- EDIT --}}

                                    <button
                                        type="button"
                                        class="splp-action-button splp-edit-button"
                                        title="Edit"
                                        onclick="openEditSplpModal(@js($splp->id))"
                                    >

                                        <i class="bi bi-pencil-fill"></i>

                                    </button>


                                    {{-- DELETE --}}

                                    <form
                                        action="{{ route(
                                            'splp.destroy',
                                            $splp->id
                                        ) }}"
                                        method="POST"
                                        class="splp-delete-form"
                                        onsubmit="return confirm(
                                            'Yakin ingin mengajukan penghapusan data SPLP ini?'
                                        );"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="splp-action-button splp-delete-button"
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

                                <div class="splp-empty-state">

                                    <div class="splp-empty-icon">

                                        <i class="bi bi-diagram-3"></i>

                                    </div>

                                    <h3>
                                        Belum ada data SPLP
                                    </h3>

                                    <p>
                                        Data infrastruktur SPLP belum tersedia.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- FOOTER --}}

        @if(
            method_exists($splps, 'links')
            &&
            $splps->hasPages()
        )

            <div class="splp-table-footer">

                <span class="splp-showing-text">

                    Menampilkan
                    {{ $splps->firstItem() }}
                    -
                    {{ $splps->lastItem() }}
                    dari
                    {{ $splps->total() }}
                    data

                </span>

                <div>
                    {{ $splps->links() }}
                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     MODAL TAMBAH / EDIT SPLP
========================================================= --}}

<div
    id="splpModal"
    class="splp-modal-overlay"
    aria-hidden="true"
>

    <div
        class="splp-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="splpModalTitle"
    >


        {{-- MODAL HEADER --}}

        <div class="splp-modal-header">

            <div class="splp-modal-header-left">

                <div class="splp-modal-icon">

                    <i class="bi bi-diagram-3-fill"></i>

                </div>

                <div class="splp-modal-header-text">

                    <h2 id="splpModalTitle">
                        Tambah SPLP
                    </h2>

                    <p id="splpModalDescription">
                        Masukan detail infrastruktur SPLP baru ke dalam sistem.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="splp-modal-close"
                onclick="closeSplpModal()"
                title="Tutup"
            >

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        {{-- FORM --}}

        <form
            id="splpForm"
            method="POST"
        >

            @csrf

            <input
                type="hidden"
                name="_method"
                id="splpMethod"
                value="POST"
            >


            {{-- MODAL BODY --}}

            <div class="splp-modal-body">


                {{-- =================================================
                     INFORMASI SPLP
                ================================================== --}}

                <div class="splp-form-card">

                    <div class="splp-form-card-header">

                        <i class="bi bi-diagram-3-fill"></i>

                        <h3>
                            Informasi SPLP
                        </h3>

                    </div>


                    <div class="splp-form-grid">


                        {{-- ID --}}

                        <div class="splp-form-group">

                            <label for="splp_id">
                                ID SPLP
                            </label>

                            <input
                                type="text"
                                id="splp_id"
                                value="{{ old('id') }}"
                                placeholder="ID SPLP"
                                readonly
                            >

                            <small class="splp-form-info">

                                <i class="bi bi-info-circle"></i>

                                ID dibuat otomatis oleh sistem.

                            </small>

                        </div>


                        {{-- NAMA --}}

                        <div class="splp-form-group">

                            <label for="splp_nama_infrastruktur">

                                Nama Infrastruktur

                                <span>*</span>

                            </label>

                            <input
                                type="text"
                                id="splp_nama_infrastruktur"
                                name="nama_infrastruktur"
                                value="{{ old('nama_infrastruktur') }}"
                                placeholder="Masukkan nama infrastruktur SPLP"
                                required
                            >

                            @error('nama_infrastruktur')

                                <small class="splp-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        {{-- SPESIFIKASI --}}

                        <div class="splp-form-group full">

                            <label for="splp_spesifikasi">
                                Spesifikasi
                            </label>

                            <textarea
                                id="splp_spesifikasi"
                                name="spesifikasi"
                                placeholder="Masukkan spesifikasi SPLP"
                            >{{ old('spesifikasi') }}</textarea>

                            @error('spesifikasi')

                                <small class="splp-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                    </div>

                </div>


                {{-- =================================================
                     PENGADAAN
                ================================================== --}}

                <div class="splp-form-card">

                    <div class="splp-form-card-header">

                        <i class="bi bi-receipt"></i>

                        <h3>
                            Pengadaan
                        </h3>

                    </div>


                    <div class="splp-form-grid">


                        {{-- PENGADAAN --}}

                        <div class="splp-form-group">

                            <label for="splp_pengadaan">

                                Pengadaan

                                <span>*</span>

                            </label>

                            <select
                                id="splp_pengadaan"
                                name="pengadaan"
                                onchange="updateSplpPengadaan()"
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

                                <small class="splp-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        {{-- HARGA --}}

                        <div class="splp-form-group">

                            <label for="splp_harga">

                                Harga

                                <span>*</span>

                            </label>

                            <div class="splp-price-input">

                                <span class="splp-price-prefix">
                                    Rp
                                </span>

                                <input
                                    type="number"
                                    id="splp_harga"
                                    name="harga"
                                    value="{{ old('harga') }}"
                                    placeholder="0"
                                    min="0"
                                    step="0.01"
                                    required
                                >

                            </div>

                            @error('harga')

                                <small class="splp-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        {{-- TANGGAL PENGADAAN --}}

                        <div class="splp-form-group">

                            <label for="splp_tanggal_pengadaan">

                                Tanggal Pengadaan

                                <span>*</span>

                            </label>

                            <input
                                type="date"
                                id="splp_tanggal_pengadaan"
                                name="tanggal_pengadaan"
                                value="{{ old('tanggal_pengadaan') }}"
                                onchange="calculateSplpEndDate()"
                                required
                            >

                            @error('tanggal_pengadaan')

                                <small class="splp-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        {{-- TANGGAL BERAKHIR --}}

                        <div class="splp-form-group">

                            <label for="splp_tanggal_berakhir">
                                Tanggal Berakhir
                            </label>

                            <input
                                type="date"
                                id="splp_tanggal_berakhir"
                                name="tanggal_berakhir"
                                value="{{ old('tanggal_berakhir') }}"
                            >

                            <small class="splp-form-info">

                                <i class="bi bi-info-circle"></i>

                                Untuk pembelian, tanggal berakhir dikosongkan.
                                Untuk sewa, tanggal berakhir digunakan untuk
                                menentukan status otomatis.

                            </small>

                            @error('tanggal_berakhir')

                                <small class="splp-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>

                    </div>


                    {{-- =================================================
                         SEWA
                    ================================================== --}}

                    <div
                        id="splpSewaSection"
                        class="{{ old('pengadaan') === 'Sewa' ? 'show' : '' }}"
                    >

                        <div class="splp-sewa-title">
                            Periode Sewa
                        </div>


                        <div class="splp-sewa-grid">


                            {{-- PERIODE --}}

                            <div class="splp-form-group">

                                <label for="splp_periode_sewa">
                                    Periode Pembayaran
                                </label>

                                <select
                                    id="splp_periode_sewa"
                                    name="periode_sewa"
                                    onchange="
                                        updateSplpCustomPeriod();
                                        calculateSplpEndDate();
                                    "
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

                            <div class="splp-form-group">

                                <label>
                                    Keterangan
                                </label>

                                <div
                                    class="splp-form-info"
                                    style="margin-top:10px;"
                                >

                                    <i class="bi bi-info-circle"></i>

                                    Pilih periode sesuai dengan kontrak atau pembayaran SPLP.

                                </div>

                            </div>

                        </div>


                        {{-- CUSTOM --}}

                        <div
                            id="splpCustomPeriod"
                            class="{{ old('periode_sewa') === 'Custom' ? 'show' : '' }}"
                        >


                            <div class="splp-form-group">

                                <label for="splp_durasi_sewa">
                                    Durasi
                                </label>

                                <input
                                    type="number"
                                    id="splp_durasi_sewa"
                                    name="durasi_sewa"
                                    value="{{ old('durasi_sewa') }}"
                                    min="1"
                                    placeholder="Contoh: 18"
                                    onchange="calculateSplpEndDate()"
                                >

                            </div>


                            <div class="splp-form-group">

                                <label for="splp_satuan_sewa">
                                    Satuan
                                </label>

                                <select
                                    id="splp_satuan_sewa"
                                    name="satuan_sewa"
                                    onchange="calculateSplpEndDate()"
                                >

                                    <option
                                        value="Months"
                                        {{ old('satuan_sewa', 'Months') === 'Months' ? 'selected' : '' }}
                                    >
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


            {{-- FOOTER --}}

            <div class="splp-modal-footer">

                <button
                    type="button"
                    class="splp-btn-batal"
                    onclick="closeSplpModal()"
                >
                    Batal
                </button>


                <button
                    type="submit"
                    class="splp-btn-simpan"
                    id="splpSaveButton"
                >

                    <i class="bi bi-check-lg"></i>

                    Simpan SPLP

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
        document.getElementById('splpSearch');

    const statusFilter =
        document.getElementById('splpStatusFilter');

    const verifikasiFilter =
        document.getElementById('splpVerifikasiFilter');

    const tableBody =
        document.getElementById('splpTableBody');


    function filterSplpTable()
    {

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


        const verifikasiValue =
            (verifikasiFilter?.value || '')
                .toLowerCase()
                .trim();


        rows.forEach(function (row) {

            const rowSearch =
                row.dataset.search || '';

            const rowStatus =
                row.dataset.status || '';

            const rowVerifikasi =
                row.dataset.verifikasi || '';


            const matchSearch =
                !searchValue ||
                rowSearch.includes(
                    searchValue
                );


            const matchStatus =
                !statusValue ||
                rowStatus === statusValue;


            const matchVerifikasi =
                !verifikasiValue ||
                rowVerifikasi ===
                    verifikasiValue;


            row.style.display =
                matchSearch &&
                matchStatus &&
                matchVerifikasi
                    ? ''
                    : 'none';

        });

    }


    if (searchInput) {

        searchInput.addEventListener(
            'input',
            filterSplpTable
        );

    }


    if (statusFilter) {

        statusFilter.addEventListener(
            'change',
            filterSplpTable
        );

    }


    if (verifikasiFilter) {

        verifikasiFilter.addEventListener(
            'change',
            filterSplpTable
        );

    }


    /* =====================================================
       MODAL OVERLAY
    ===================================================== */

    const modal =
        document.getElementById(
            'splpModal'
        );


    if (modal) {

        modal.addEventListener(
            'click',
            function (event) {

                if (
                    event.target === modal
                ) {

                    closeSplpModal();

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

                closeSplpModal();

            }

        }
    );


    /* =====================================================
       INITIAL
    ===================================================== */

    updateSplpPengadaan();


    /* =====================================================
       VALIDATION ERROR
    ===================================================== */

    @if($errors->any())

        openAddSplpModal();

    @endif

});


/* =========================================================
   OPEN ADD
========================================================= */

function openAddSplpModal()
{

    const modal =
        document.getElementById(
            'splpModal'
        );

    const form =
        document.getElementById(
            'splpForm'
        );


    if (!modal || !form) {
        return;
    }


    form.action =
        "{{ route('splp.store') }}";


    document.getElementById(
        'splpMethod'
    ).value =
        'POST';


    document.getElementById(
        'splpModalTitle'
    ).textContent =
        'Tambah SPLP';


    document.getElementById(
        'splpModalDescription'
    ).textContent =
        'Masukan detail infrastruktur SPLP baru ke dalam sistem.';


    document.getElementById(
        'splpSaveButton'
    ).innerHTML =
        '<i class="bi bi-check-lg"></i> Simpan SPLP';


    /*
     * Jangan reset saat validation error.
     */

    @if(!$errors->any())

        form.reset();

        document.getElementById(
            'splp_id'
        ).value = '';

        document.getElementById(
            'splpSewaSection'
        ).classList.remove(
            'show'
        );

        document.getElementById(
            'splpCustomPeriod'
        ).classList.remove(
            'show'
        );

    @endif


    modal.classList.add(
        'show'
    );

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add(
        'splp-modal-open'
    );

}


/* =========================================================
   OPEN EDIT
========================================================= */

function openEditSplpModal(id)
{

    const splps =
        @json($splpCollection->values());


    const splp =
        splps.find(
            function (item) {

                return String(item.id) ===
                    String(id);

            }
        );


    if (!splp) {

        alert(
            'Data SPLP tidak ditemukan.'
        );

        return;

    }


    const modal =
        document.getElementById(
            'splpModal'
        );

    const form =
        document.getElementById(
            'splpForm'
        );


    if (!modal || !form) {
        return;
    }


    form.action =
        "{{ url('/infrastruktur/splp') }}/" +
        encodeURIComponent(id);


    document.getElementById(
        'splpMethod'
    ).value =
        'PUT';


    document.getElementById(
        'splpModalTitle'
    ).textContent =
        'Edit SPLP';


    document.getElementById(
        'splpModalDescription'
    ).textContent =
        'Perbarui data infrastruktur SPLP yang dipilih.';


    document.getElementById(
        'splpSaveButton'
    ).innerHTML =
        '<i class="bi bi-check-lg"></i> Simpan Perubahan';


    /* =====================================================
       ISI FORM
    ===================================================== */

    document.getElementById(
        'splp_id'
    ).value =
        splp.id ?? '';


    document.getElementById(
        'splp_nama_infrastruktur'
    ).value =
        splp.nama_infrastruktur ?? '';


    document.getElementById(
        'splp_spesifikasi'
    ).value =
        splp.spesifikasi ?? '';


    document.getElementById(
        'splp_pengadaan'
    ).value =
        splp.pengadaan ?? '';


    document.getElementById(
        'splp_harga'
    ).value =
        splp.harga ?? '';


    document.getElementById(
        'splp_tanggal_pengadaan'
    ).value =
        formatDateForInput(
            splp.tanggal_pengadaan
        );


    document.getElementById(
        'splp_tanggal_berakhir'
    ).value =
        formatDateForInput(
            splp.tanggal_berakhir
        );


    document.getElementById(
        'splp_periode_sewa'
    ).value =
        splp.periode_sewa ?? '';


    document.getElementById(
        'splp_durasi_sewa'
    ).value =
        splp.durasi_sewa ?? '';


    document.getElementById(
        'splp_satuan_sewa'
    ).value =
        splp.satuan_sewa ?? 'Months';


    updateSplpPengadaan();

    updateSplpCustomPeriod();


    modal.classList.add(
        'show'
    );

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add(
        'splp-modal-open'
    );

}


/* =========================================================
   FORMAT DATE
========================================================= */

function formatDateForInput(value)
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

function closeSplpModal()
{

    const modal =
        document.getElementById(
            'splpModal'
        );


    if (!modal) {
        return;
    }


    modal.classList.remove(
        'show'
    );


    modal.setAttribute(
        'aria-hidden',
        'true'
    );


    document.body.classList.remove(
        'splp-modal-open'
    );

}


/* =========================================================
   PENGADAAN
========================================================= */

function updateSplpPengadaan()
{

    const pengadaan =
        document.getElementById(
            'splp_pengadaan'
        )?.value;


    const sewaSection =
        document.getElementById(
            'splpSewaSection'
        );


    const tanggalBerakhir =
        document.getElementById(
            'splp_tanggal_berakhir'
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


        /*
         * Tanggal berakhir tetap bisa
         * diklik/edit manual.
         */

        if (tanggalBerakhir) {

            tanggalBerakhir.readOnly =
                false;

            tanggalBerakhir.style.background =
                'white';

        }


        calculateSplpEndDate();

    } else {

        sewaSection.classList.remove(
            'show'
        );


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

function updateSplpCustomPeriod()
{

    const periode =
        document.getElementById(
            'splp_periode_sewa'
        )?.value;


    const custom =
        document.getElementById(
            'splpCustomPeriod'
        );


    if (!custom) {
        return;
    }


    if (
        periode === 'Custom'
    ) {

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

function calculateSplpEndDate()
{

    const pengadaan =
        document.getElementById(
            'splp_pengadaan'
        )?.value;


    if (
        String(pengadaan).toLowerCase()
        !== 'sewa'
    ) {

        return;

    }


    const tanggalMulai =
        document.getElementById(
            'splp_tanggal_pengadaan'
        )?.value;


    const periode =
        document.getElementById(
            'splp_periode_sewa'
        )?.value;


    const tanggalBerakhir =
        document.getElementById(
            'splp_tanggal_berakhir'
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
            tanggalMulai +
            'T00:00:00'
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
                        'splp_durasi_sewa'
                    )?.value || 0
                );


            const unit =
                document.getElementById(
                    'splp_satuan_sewa'
                )?.value;


            if (
                !duration ||
                duration < 1
            ) {

                return;

            }


            if (
                unit === 'Years'
            ) {

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
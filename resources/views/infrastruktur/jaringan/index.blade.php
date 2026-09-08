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

.add-jaringan-button:hover {
    background: #050f63;
    color: white;
    transform: translateY(-1px);
}

.add-jaringan-button i {
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

.jaringan-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;

    margin-bottom: 25px;
}

.jaringan-stat-card {
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

.jaringan-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(0, 0, 0, 0.08);
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

.jaringan-stat-icon.red {
    background: #fee2e2;
    color: #dc2626;
}

.jaringan-stat-content {
    display: flex;
    flex-direction: column;
    min-width: 0;
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

.jaringan-stat-value.currency {
    font-size: 17px;
    white-space: nowrap;
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


/* =========================================================
   TABLE HEADER
========================================================= */

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

.jaringan-filter-select:focus {
    border-color: #079bd8;
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

.jaringan-table tbody tr {
    transition: 0.15s ease;
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
   NAME
========================================================= */

.jaringan-name {
    font-weight: 600;
    color: #1f2937;
}

.jaringan-spec {
    margin-top: 3px;

    font-size: 11px;
    color: #9ca3af;

    max-width: 230px;
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

.jaringan-price {
    font-weight: 600;
    color: #374151;

    white-space: nowrap;
}


/* =========================================================
   DATE
========================================================= */

.jaringan-date {
    white-space: nowrap;
    color: #4b5563;
}

.jaringan-date-empty {
    color: #9ca3af;
}


/* =========================================================
   STATUS OTOMATIS
========================================================= */

.jaringan-status-badge {
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

    text-decoration: none;

    cursor: pointer;

    transition: 0.2s ease;
}

.jaringan-edit-button {
    background: #e0f2fe;
    color: #075985;
}

.jaringan-edit-button:hover {
    background: #bae6fd;
    color: #075985;
}

.jaringan-delete-button {
    background: #fee2e2;
    color: #dc2626;
}

.jaringan-delete-button:hover {
    background: #fecaca;
    color: #dc2626;
}

.jaringan-action-button i {
    font-size: 14px;
}


/* =========================================================
   EMPTY STATE
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
   PAGINATION
========================================================= */

.jaringan-table-footer {
    display: flex;

    justify-content: space-between;
    align-items: center;

    padding: 15px 20px;

    border-top: 1px solid #e5e7eb;
}

.jaringan-showing-text {
    font-size: 11px;
    color: #6b7280;
}


/* =========================================================
   MODAL OVERLAY
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


/* =========================================================
   MODAL
========================================================= */

.jaringan-modal {
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

    animation: jaringanModalIn 0.18s ease;
}

@keyframes jaringanModalIn {

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

.jaringan-modal-header {
    min-height: 78px;

    padding: 18px 22px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    border-bottom: 1px solid #e5e7eb;

    flex-shrink: 0;
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

    flex-shrink: 0;
}

.jaringan-modal-icon i {
    font-size: 18px;
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

    transition: 0.2s ease;
}

.jaringan-modal-close:hover {
    background: #e2e8f0;
    color: #1f2937;
}


/* =========================================================
   MODAL FORM
========================================================= */

#jaringanForm {
    min-height: 0;

    height: 100%;

    display: flex;
    flex-direction: column;

    flex: 1 1 auto;

    overflow: hidden;
}


/* =========================================================
   MODAL BODY
========================================================= */

.jaringan-modal-body {
    padding: 24px;

    overflow-y: scroll;
    overflow-x: hidden;

    flex: 1 1 0%;

    min-height: 0;
    height: 0;

    overscroll-behavior: contain;

    -webkit-overflow-scrolling: touch;

    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 transparent;
}


/* =========================================================
   FORM CARD
========================================================= */

.jaringan-form-card {
    background: white;

    border: 1px solid #e5e7eb;

    border-radius: 14px;

    padding: 24px;

    margin-bottom: 18px;

    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.03);
}

.jaringan-form-card:last-child {
    margin-bottom: 0;
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


/* =========================================================
   FORM GRID
========================================================= */

.jaringan-form-grid {
    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 20px;
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
.jaringan-form-group select,
.jaringan-form-group textarea {
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

.jaringan-form-group input,
.jaringan-form-group select {
    height: 40px;

    padding: 0 12px;
}

.jaringan-form-group textarea {
    min-height: 85px;

    padding: 10px 12px;

    resize: vertical;
}

.jaringan-form-group input:focus,
.jaringan-form-group select:focus,
.jaringan-form-group textarea:focus {
    border-color: #079bd8;

    box-shadow:
        0 0 0 3px rgba(7, 155, 216, 0.10);
}

.jaringan-form-group input[readonly] {
    background: #f8fafc;

    color: #64748b;

    cursor: not-allowed;
}

.jaringan-form-error {
    margin-top: 5px;

    font-size: 10px;

    color: #dc2626;
}


/* =========================================================
   PRICE INPUT
========================================================= */

.jaringan-price-input {
    position: relative;
}

.jaringan-price-prefix {
    position: absolute;

    left: 12px;
    top: 50%;

    transform: translateY(-50%);

    font-size: 12px;
    font-weight: 600;

    color: #64748b;

    pointer-events: none;
}

.jaringan-price-input input {
    padding-left: 38px;
}


/* =========================================================
   SEWA SECTION
========================================================= */

#jaringanSewaSection {
    display: none;

    margin-top: 20px;

    padding: 18px;

    background: #f8fafc;

    border: 1px solid #e2e8f0;

    border-radius: 10px;
}

#jaringanSewaSection.show {
    display: block;
}

.jaringan-sewa-title {
    margin-bottom: 15px;

    font-size: 12px;
    font-weight: 700;

    color: #075985;
}

.jaringan-sewa-grid {
    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 16px;
}


/* =========================================================
   CUSTOM PERIOD
========================================================= */

#jaringanCustomPeriod {
    display: none;

    margin-top: 16px;
}

#jaringanCustomPeriod.show {
    display: grid;

    grid-template-columns: repeat(2, minmax(0, 1fr));

    gap: 16px;
}


/* =========================================================
   INFO
========================================================= */

.jaringan-form-info {
    margin-top: 6px;

    font-size: 10px;

    line-height: 1.5;

    color: #9ca3af;
}

.jaringan-form-info i {
    margin-right: 3px;
}


/* =========================================================
   MODAL FOOTER
========================================================= */

.jaringan-modal-footer {
    display: flex;

    justify-content: flex-end;

    align-items: center;

    gap: 10px;

    padding: 16px 24px;

    border-top: 1px solid #e5e7eb;

    background: white;

    flex-shrink: 0;
}

.jaringan-btn-batal,
.jaringan-btn-simpan {
    height: 40px;

    padding: 0 18px;

    border-radius: 8px;

    font-size: 12px;

    font-weight: 600;

    cursor: pointer;

    transition: 0.2s ease;
}

.jaringan-btn-batal {
    border: 1px solid #d1d5db;

    background: white;

    color: #4b5563;
}

.jaringan-btn-batal:hover {
    background: #f8fafc;
}

.jaringan-btn-simpan {
    border: none;

    background: #079bd8;

    color: white;
}

.jaringan-btn-simpan:hover {
    background: #075985;
}

.jaringan-btn-simpan i {
    margin-right: 5px;
}


/* =========================================================
   DELETE CONFIRM
========================================================= */

.jaringan-delete-form {
    display: inline;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1200px) {

    .jaringan-stats {
        grid-template-columns: repeat(3, 1fr);
    }

}


@media (max-width: 900px) {

    .jaringan-header {
        align-items: flex-start;

        flex-direction: column;

        gap: 15px;
    }

    .add-jaringan-button {
        width: 100%;
    }

    .jaringan-stats {
        grid-template-columns: repeat(2, 1fr);
    }

    .jaringan-table-header {
        align-items: flex-start;

        flex-direction: column;
    }

    .jaringan-toolbar {
        width: 100%;
    }

    .jaringan-search {
        flex: 1;
    }

    .jaringan-search input {
        width: 100%;
    }

}


@media (max-width: 700px) {

    .jaringan-modal-overlay {
        padding: 15px;
    }

    .jaringan-modal {
        height: calc(100vh - 30px);

        max-height: calc(100vh - 30px);
    }

    .jaringan-modal-body {
        padding: 15px;
    }

    .jaringan-form-card {
        padding: 18px;
    }

    .jaringan-form-grid,
    .jaringan-sewa-grid {
        grid-template-columns: 1fr;

        gap: 15px;
    }

    #jaringanCustomPeriod.show {
        grid-template-columns: 1fr;
    }

    .jaringan-modal-footer {
        padding: 14px 15px;
    }

}


@media (max-width: 500px) {

    .jaringan-stats {
        grid-template-columns: 1fr;
    }

    .jaringan-toolbar {
        flex-direction: column;

        align-items: stretch;
    }

    .jaringan-filter-select {
        width: 100%;
    }

    .jaringan-modal-header {
        padding: 15px;
    }

}


/* =========================================================
   BODY LOCK WHEN MODAL OPEN
========================================================= */

body.jaringan-modal-open {
    overflow: hidden;
}

</style>


<div class="jaringan-page">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="jaringan-header">

        <div class="jaringan-heading">

            <h2>
                Jaringan
            </h2>

            <p>
                Kelola data infrastruktur jaringan yang tersedia.
            </p>

        </div>


        <button
            type="button"
            class="add-jaringan-button"
            onclick="openAddJaringanModal()"
        >

            <i class="bi bi-plus-lg"></i>

            <span>
                Tambah Jaringan
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

    <div class="jaringan-stats">


        {{-- TOTAL JARINGAN --}}

        <div class="jaringan-stat-card">

            <div class="jaringan-stat-icon blue">

                <i class="bi bi-wifi"></i>

            </div>

            <div class="jaringan-stat-content">

                <span class="jaringan-stat-label">
                    Total Jaringan
                </span>

                <span class="jaringan-stat-value">

                    {{ $totalJaringan ?? $jaringans->count() }}

                </span>

                <span class="jaringan-stat-description">
                    Infrastruktur jaringan terdaftar
                </span>

            </div>

        </div>


        {{-- AKAN BERAKHIR --}}

        <div class="jaringan-stat-card">

            <div class="jaringan-stat-icon orange">

                <i class="bi bi-clock-history"></i>

            </div>

            <div class="jaringan-stat-content">

                <span class="jaringan-stat-label">
                    Akan Berakhir
                </span>

                <span class="jaringan-stat-value">

                    {{ $akanHabis ?? $akanBerakhir ?? 0 }}

                </span>

                <span class="jaringan-stat-description">
                    Berakhir dalam 30 hari
                </span>

            </div>

        </div>


        {{-- TIDAK BERAKHIR --}}

        <div class="jaringan-stat-card">

            <div class="jaringan-stat-icon green">

                <i class="bi bi-infinity"></i>

            </div>

            <div class="jaringan-stat-content">

                <span class="jaringan-stat-label">
                    Tidak Berakhir
                </span>

                <span class="jaringan-stat-value">
                    {{ $tersedia ?? 0 }}
                </span>

                <span class="jaringan-stat-description">
                    Jaringan tanpa tanggal berakhir
                </span>

            </div>

        </div>


        {{-- EXPIRED --}}

        <div class="jaringan-stat-card">

            <div class="jaringan-stat-icon red">

                <i class="bi bi-x-circle-fill"></i>

            </div>

            <div class="jaringan-stat-content">

                <span class="jaringan-stat-label">
                    Expired
                </span>

                <span class="jaringan-stat-value">

                    {{ $expired ?? 0 }}

                </span>

                <span class="jaringan-stat-description">
                    Jaringan sudah berakhir
                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="jaringan-table-card">


        {{-- =================================================
             TABLE HEADER
        ================================================== --}}

        <div class="jaringan-table-header">


            <div class="jaringan-table-header-left">

                <h3 class="jaringan-table-title">
                    Data Jaringan
                </h3>

                <span class="jaringan-table-count">
                    ({{ $jaringans->count() }} data)
                </span>

            </div>


            {{-- TOOLBAR --}}

            <div class="jaringan-toolbar">


                {{-- SEARCH --}}

                <div class="jaringan-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        id="jaringanSearch"
                        placeholder="Cari jaringan..."
                    >

                </div>


                {{-- FILTER STATUS --}}

                <select
                    id="jaringanStatusFilter"
                    class="jaringan-filter-select"
                >

                    <option value="">
                        Semua Status
                    </option>

                    <option value="tidak berakhir">
                        Tidak Berakhir
                    </option>

                    <option value="segera berakhir">
                        Segera Berakhir
                    </option>

                    <option value="expired">
                        Expired
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

            </div>

        </div>


        {{-- =================================================
             TABLE WRAPPER
        ================================================== --}}

        <div class="jaringan-table-wrapper">

            <table class="jaringan-table">

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


                <tbody id="jaringanTableBody">


                    @forelse($jaringans as $jaringan)

                        @php

                            /*
                             * STATUS BERDASARKAN TANGGAL
                             */

                            $statusLabel = 'Tidak Berakhir';
                            $statusClass = 'status-perpetual';

                            if ($jaringan->tanggal_berakhir) {

                                $today = now()->startOfDay();

                                $endDate =
                                    \Carbon\Carbon::parse(
                                        $jaringan->tanggal_berakhir
                                    )->startOfDay();

                                $daysLeft =
                                    $today->diffInDays(
                                        $endDate,
                                        false
                                    );

                                if ($daysLeft < 0) {

                                    $statusLabel = 'Expired';
                                    $statusClass = 'status-expired';

                                } elseif ($daysLeft <= 30) {

                                    $statusLabel = 'Segera Berakhir';
                                    $statusClass = 'status-warning';

                                }

                            }


                            /*
                             * VERIFIKASI
                             */

                            $verifikasi =
                                strtolower(
                                    (string) (
                                        $jaringan->verifikasi
                                        ?? 'menunggu'
                                    )
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
                                ($jaringan->id ?? '') . ' ' .
                                ($jaringan->nama_infrastruktur ?? '') . ' ' .
                                ($jaringan->spesifikasi ?? '') . ' ' .
                                ($jaringan->pengadaan ?? '') . ' ' .
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

                                <span class="jaringan-code">

                                    {{ $jaringan->id }}

                                </span>

                            </td>


                            {{-- NAMA --}}

                            <td>

                                <div class="jaringan-name">

                                    {{ $jaringan->nama_infrastruktur }}

                                </div>


                                @if($jaringan->spesifikasi)

                                    <div class="jaringan-spec">

                                        {{ $jaringan->spesifikasi }}

                                    </div>

                                @endif

                            </td>


                            {{-- PENGADAAN --}}

                            <td>

                                @if(
                                    strtolower(
                                        $jaringan->pengadaan ?? ''
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

                                <span class="jaringan-price">

                                    Rp
                                    {{ number_format(
                                        (float) ($jaringan->harga ?? 0),
                                        0,
                                        ',',
                                        '.'
                                    ) }}

                                </span>

                            </td>


                            {{-- TANGGAL PENGADAAN --}}

                            <td>

                                @if($jaringan->tanggal_pengadaan)

                                    <span class="jaringan-date">

                                        {{ \Carbon\Carbon::parse(
                                            $jaringan->tanggal_pengadaan
                                        )->format('d M Y') }}

                                    </span>

                                @else

                                    <span class="jaringan-date-empty">
                                        -
                                    </span>

                                @endif

                            </td>


                            {{-- TANGGAL BERAKHIR --}}

                            <td>

                                @if($jaringan->tanggal_berakhir)

                                    <span class="jaringan-date">

                                        {{ \Carbon\Carbon::parse(
                                            $jaringan->tanggal_berakhir
                                        )->format('d M Y') }}

                                    </span>

                                @else

                                    <span class="jaringan-date-empty">
                                        Tidak Berakhir
                                    </span>

                                @endif

                            </td>


                            {{-- STATUS --}}

                            <td>

                                <span
                                    class="jaringan-status-badge {{ $statusClass }}"
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


        {{-- =================================================
             TABLE FOOTER
        ================================================== --}}

        @if(
            method_exists($jaringans, 'links')
            &&
            $jaringans->hasPages()
        )

            <div class="jaringan-table-footer">

                <span class="jaringan-showing-text">

                    Menampilkan
                    {{ $jaringans->firstItem() }}
                    -
                    {{ $jaringans->lastItem() }}
                    dari
                    {{ $jaringans->total() }}
                    data

                </span>

                <div>
                    {{ $jaringans->links() }}
                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     MODAL TAMBAH / EDIT JARINGAN
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


        {{-- =================================================
             MODAL HEADER
        ================================================== --}}

        <div class="jaringan-modal-header">

            <div class="jaringan-modal-header-left">

                <div class="jaringan-modal-icon">

                    <i class="bi bi-wifi"></i>

                </div>


                <div class="jaringan-modal-header-text">

                    <h2 id="jaringanModalTitle">
                        Tambah Jaringan
                    </h2>

                    <p id="jaringanModalDescription">
                        Masukan detail infrastruktur jaringan baru ke dalam sistem.
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


        {{-- =================================================
             FORM
        ================================================== --}}

        <form
            id="jaringanForm"
            method="POST"
        >

            @csrf

            <input
                type="hidden"
                name="_method"
                id="jaringanMethod"
                value="POST"
            >


            {{-- =================================================
                 MODAL BODY
            ================================================== --}}

            <div class="jaringan-modal-body">


                {{-- =================================================
                     INFORMASI JARINGAN
                ================================================== --}}

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
                                placeholder="ID jaringan"
                                readonly
                            >

                            <small class="jaringan-form-info">

                                <i class="bi bi-info-circle"></i>

                                ID dibuat otomatis oleh sistem.

                            </small>

                        </div>


                        {{-- NAMA --}}

                        <div class="jaringan-form-group">

                            <label for="jaringan_nama_infrastruktur">

                                Nama Infrastruktur

                                <span>*</span>

                            </label>

                            <input
                                type="text"
                                id="jaringan_nama_infrastruktur"
                                name="nama_infrastruktur"
                                value="{{ old('nama_infrastruktur') }}"
                                placeholder="Masukkan nama infrastruktur jaringan"
                                required
                            >

                            @error('nama_infrastruktur')

                                <small class="jaringan-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        {{-- SPESIFIKASI --}}

                        <div class="jaringan-form-group full">

                            <label for="jaringan_spesifikasi">

                                Spesifikasi

                            </label>

                            <textarea
                                id="jaringan_spesifikasi"
                                name="spesifikasi"
                                placeholder="Masukkan spesifikasi jaringan"
                            >{{ old('spesifikasi') }}</textarea>

                            @error('spesifikasi')

                                <small class="jaringan-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                    </div>

                </div>


                {{-- =================================================
                     PENGADAAN
                ================================================== --}}

                <div class="jaringan-form-card">


                    <div class="jaringan-form-card-header">

                        <i class="bi bi-receipt"></i>

                        <h3>
                            Pengadaan
                        </h3>

                    </div>


                    <div class="jaringan-form-grid">


                        {{-- PENGADAAN --}}

                        <div class="jaringan-form-group">

                            <label for="jaringan_pengadaan">

                                Pengadaan

                                <span>*</span>

                            </label>

                            <select
                                id="jaringan_pengadaan"
                                name="pengadaan"
                                onchange="updateJaringanPengadaan()"
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

                                <small class="jaringan-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        {{-- HARGA --}}

                        <div class="jaringan-form-group">

                            <label for="jaringan_harga">

                                Harga

                                <span>*</span>

                            </label>

                            <div class="jaringan-price-input">

                                <span class="jaringan-price-prefix">
                                    Rp
                                </span>

                                <input
                                    type="number"
                                    id="jaringan_harga"
                                    name="harga"
                                    value="{{ old('harga') }}"
                                    placeholder="0"
                                    min="0"
                                    step="0.01"
                                    required
                                >

                            </div>

                            @error('harga')

                                <small class="jaringan-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        {{-- TANGGAL PENGADAAN --}}

                        <div class="jaringan-form-group">

                            <label for="jaringan_tanggal_pengadaan">

                                Tanggal Pengadaan

                                <span>*</span>

                            </label>

                            <input
                                type="date"
                                id="jaringan_tanggal_pengadaan"
                                name="tanggal_pengadaan"
                                value="{{ old('tanggal_pengadaan') }}"
                                onchange="calculateJaringanEndDate()"
                                required
                            >

                            @error('tanggal_pengadaan')

                                <small class="jaringan-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        {{-- TANGGAL BERAKHIR --}}

                        <div class="jaringan-form-group">

                            <label for="jaringan_tanggal_berakhir">

                                Tanggal Berakhir

                            </label>

                            <input
                                type="date"
                                id="jaringan_tanggal_berakhir"
                                name="tanggal_berakhir"
                                value="{{ old('tanggal_berakhir') }}"
                            >

                            <small class="jaringan-form-info">

                                <i class="bi bi-info-circle"></i>

                                Untuk pembelian, tanggal berakhir dapat dikosongkan.

                            </small>

                            @error('tanggal_berakhir')

                                <small class="jaringan-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                    </div>


                    {{-- =================================================
                         SEWA
                    ================================================== --}}

                    <div
                        id="jaringanSewaSection"
                        class="{{ old('pengadaan') === 'Sewa' ? 'show' : '' }}"
                    >

                        <div class="jaringan-sewa-title">

                            Periode Sewa

                        </div>


                        <div class="jaringan-sewa-grid">


                            {{-- PERIODE --}}

                            <div class="jaringan-form-group">

                                <label for="jaringan_periode_sewa">

                                    Periode Pembayaran

                                </label>

                                <select
                                    id="jaringan_periode_sewa"
                                    name="periode_sewa"
                                    onchange="updateJaringanCustomPeriod(); calculateJaringanEndDate();"
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

                            <div class="jaringan-form-group">

                                <label>
                                    Keterangan
                                </label>

                                <div
                                    class="jaringan-form-info"
                                    style="margin-top:10px;"
                                >

                                    <i class="bi bi-info-circle"></i>

                                    Pilih periode sesuai dengan kontrak atau pembayaran jaringan.

                                </div>

                            </div>


                        </div>


                        {{-- CUSTOM --}}

                        <div
                            id="jaringanCustomPeriod"
                            class="{{ old('periode_sewa') === 'Custom' ? 'show' : '' }}"
                        >


                            <div class="jaringan-form-group">

                                <label for="jaringan_durasi_sewa">

                                    Durasi

                                </label>

                                <input
                                    type="number"
                                    id="jaringan_durasi_sewa"
                                    name="durasi_sewa"
                                    value="{{ old('durasi_sewa') }}"
                                    min="1"
                                    placeholder="Contoh: 18"
                                    onchange="calculateJaringanEndDate()"
                                >

                            </div>


                            <div class="jaringan-form-group">

                                <label for="jaringan_satuan_sewa">

                                    Satuan

                                </label>

                                <select
                                    id="jaringan_satuan_sewa"
                                    name="satuan_sewa"
                                    onchange="calculateJaringanEndDate()"
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

document.addEventListener('DOMContentLoaded', function () {


    /* =====================================================
       SEARCH
    ===================================================== */

    const searchInput =
        document.getElementById('jaringanSearch');

    const statusFilter =
        document.getElementById('jaringanStatusFilter');

    const verifikasiFilter =
        document.getElementById('jaringanVerifikasiFilter');

    const tableBody =
        document.getElementById('jaringanTableBody');


    function filterJaringanTable() {

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
                rowVerifikasi === verifikasiValue;


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
            filterJaringanTable
        );

    }


    if (statusFilter) {

        statusFilter.addEventListener(
            'change',
            filterJaringanTable
        );

    }


    if (verifikasiFilter) {

        verifikasiFilter.addEventListener(
            'change',
            filterJaringanTable
        );

    }


    /* =====================================================
       MODAL OVERLAY
    ===================================================== */

    const modal =
        document.getElementById(
            'jaringanModal'
        );


    if (modal) {

        modal.addEventListener(
            'click',
            function (event) {

                if (event.target === modal) {

                    closeJaringanModal();

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

                closeJaringanModal();

            }

        }
    );


    /* =====================================================
       INITIAL PENGADAAN
    ===================================================== */

    updateJaringanPengadaan();


    /* =====================================================
       VALIDATION ERROR
    ===================================================== */

    @if($errors->any())

        openAddJaringanModal();

    @endif

});


/* =========================================================
   OPEN ADD MODAL
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


    if (!modal || !form) {
        return;
    }


    form.action =
        "{{ route('jaringan.store') }}";


    document.getElementById(
        'jaringanMethod'
    ).value = 'POST';


    document.getElementById(
        'jaringanModalTitle'
    ).textContent =
        'Tambah Jaringan';


    document.getElementById(
        'jaringanModalDescription'
    ).textContent =
        'Masukan detail infrastruktur jaringan baru ke dalam sistem.';


    document.getElementById(
        'jaringanSaveButton'
    ).innerHTML =
        '<i class="bi bi-check-lg"></i> Simpan Jaringan';


    /*
     * Jangan reset ketika validation error
     */

    @if(!$errors->any())

        form.reset();


        document.getElementById(
            'jaringan_id'
        ).value = '';


        document.getElementById(
            'jaringanSewaSection'
        ).classList.remove('show');


        document.getElementById(
            'jaringanCustomPeriod'
        ).classList.remove('show');

    @endif


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
   OPEN EDIT MODAL
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


    if (!modal || !form) {
        return;
    }


    form.action =
        "{{ url('/infrastruktur/jaringan') }}/" +
        encodeURIComponent(id);


    document.getElementById(
        'jaringanMethod'
    ).value = 'PUT';


    document.getElementById(
        'jaringanModalTitle'
    ).textContent =
        'Edit Jaringan';


    document.getElementById(
        'jaringanModalDescription'
    ).textContent =
        'Perbarui data infrastruktur jaringan yang dipilih.';


    document.getElementById(
        'jaringanSaveButton'
    ).innerHTML =
        '<i class="bi bi-check-lg"></i> Simpan Perubahan';


    /*
     * Isi form
     */

    document.getElementById(
        'jaringan_id'
    ).value =
        jaringan.id ?? '';


    document.getElementById(
        'jaringan_nama_infrastruktur'
    ).value =
        jaringan.nama_infrastruktur ?? '';


    document.getElementById(
        'jaringan_spesifikasi'
    ).value =
        jaringan.spesifikasi ?? '';


    document.getElementById(
        'jaringan_pengadaan'
    ).value =
        jaringan.pengadaan ?? '';


    document.getElementById(
        'jaringan_harga'
    ).value =
        jaringan.harga ?? '';


    document.getElementById(
        'jaringan_tanggal_pengadaan'
    ).value =
        formatDateForInput(
            jaringan.tanggal_pengadaan
        );


    document.getElementById(
        'jaringan_tanggal_berakhir'
    ).value =
        formatDateForInput(
            jaringan.tanggal_berakhir
        );


    document.getElementById(
        'jaringan_periode_sewa'
    ).value =
        jaringan.periode_sewa ?? '';


    document.getElementById(
        'jaringan_durasi_sewa'
    ).value =
        jaringan.durasi_sewa ?? '';


    document.getElementById(
        'jaringan_satuan_sewa'
    ).value =
        jaringan.satuan_sewa ?? 'Months';


    updateJaringanPengadaan();

    updateJaringanCustomPeriod();


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
   FORMAT DATE
========================================================= */

function formatDateForInput(value)
{

    if (!value) {
        return '';
    }


    /*
     * Kalau sudah YYYY-MM-DD
     */

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
   PENGADAAN
========================================================= */

function updateJaringanPengadaan()
{

    const pengadaan =
        document.getElementById(
            'jaringan_pengadaan'
        )?.value;


    const sewaSection =
        document.getElementById(
            'jaringanSewaSection'
        );


    const tanggalBerakhir =
        document.getElementById(
            'jaringan_tanggal_berakhir'
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


        calculateJaringanEndDate();

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

function updateJaringanCustomPeriod()
{

    const periode =
        document.getElementById(
            'jaringan_periode_sewa'
        )?.value;


    const custom =
        document.getElementById(
            'jaringanCustomPeriod'
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

function calculateJaringanEndDate()
{

    const pengadaan =
        document.getElementById(
            'jaringan_pengadaan'
        )?.value;


    if (
        String(pengadaan).toLowerCase()
        !== 'sewa'
    ) {

        return;

    }


    const tanggalMulai =
        document.getElementById(
            'jaringan_tanggal_pengadaan'
        )?.value;


    const periode =
        document.getElementById(
            'jaringan_periode_sewa'
        )?.value;


    const tanggalBerakhir =
        document.getElementById(
            'jaringan_tanggal_berakhir'
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
                        'jaringan_durasi_sewa'
                    )?.value || 0
                );


            const unit =
                document.getElementById(
                    'jaringan_satuan_sewa'
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


    /*
     * Format YYYY-MM-DD
     */

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


/* =========================================================
   AUTO OPEN AFTER VALIDATION ERROR
========================================================= */

@if($errors->any())

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            openAddJaringanModal();

        }
    );

@endif

</script>

@endpush

@endsection
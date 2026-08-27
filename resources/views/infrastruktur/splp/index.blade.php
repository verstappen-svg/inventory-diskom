@extends('layouts.app')

@section('title', 'SPLP')

@section('page-title', 'SPLP')

@section('header')

    <div class="custom-header">

        <div class="header-breadcrumb">

            <span class="breadcrumb-main">
                INFRASTRUKTUR
            </span>

            <i class="bi bi-chevron-right"></i>

            <span class="breadcrumb-active">
                SPLP
            </span>

        </div>

    </div>

@endsection


@section('content')

<style>

/* =========================================================
   PAGE
========================================================= */

.infrastruktur-page {
    width: 100%;
}


/* =========================================================
   CUSTOM HEADER
========================================================= */

.custom-header {
    display: flex;
    align-items: center;
    height: 100%;
}

.header-breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    font-weight: 700;
    color: #1f2937;
}

.header-breadcrumb i {
    font-size: 10px;
    color: #9ca3af;
}

.breadcrumb-main,
.breadcrumb-active {
    color: #1f2937;
    letter-spacing: 0.2px;
}


/* =========================================================
   MESSAGE
========================================================= */

.success-message {
    margin-bottom: 20px;
    padding: 12px 15px;
    background: #eff9e9;
    border: 1px solid #c9e6ca;
    border-radius: 8px;
    color: #397542;
    font-size: 12px;
}

.error-message {
    margin-bottom: 20px;
    padding: 12px 15px;
    background: #fff1f2;
    border: 1px solid #fecdd3;
    border-radius: 8px;
    color: #b42318;
    font-size: 12px;
}


/* =========================================================
   STATISTICS
========================================================= */

.statistics {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 20px;
    min-height: 80px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    border: 1px solid #eef0f4;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
    box-sizing: border-box;
}

.stat-card:nth-child(1) {
    background: #eef4ff;
}

.stat-card:nth-child(2) {
    background: #fff8e7;
}

.stat-card:nth-child(3) {
    background: #eff9e9;
}

.stat-title {
    font-size: 11px;
    font-weight: 600;
    margin-bottom: 7px;
    letter-spacing: 0.4px;
    text-transform: uppercase;
}

.stat-card:nth-child(1) .stat-title {
    color: #4f7da7;
}

.stat-card:nth-child(2) .stat-title {
    color: #c38a19;
}

.stat-card:nth-child(3) .stat-title {
    color: #4f8a5a;
}

.stat-value {
    font-size: 24px;
    line-height: 1;
    font-weight: 700;
    color: #1f2937;
}


/* =========================================================
   TABLE CONTAINER
========================================================= */

.table-container {
    background: white;
    border-radius: 15px;
    border: 1px solid #eef0f4;
    overflow: hidden;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.06);
}


/* =========================================================
   TABLE HEADER
========================================================= */

.table-header {
    display: flex;
    flex-direction: column;
    gap: 12px;
    padding: 18px 20px;
}

.top-tools {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.left-tools,
.right-tools {
    display: flex;
    align-items: center;
}

.right-tools {
    gap: 10px;
}


/* =========================================================
   SEARCH
========================================================= */

.search-box {
    position: relative;
    width: 210px;
    height: 36px;
}

.search-box i {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-size: 13px;
    z-index: 2;
    pointer-events: none;
}

.search-box input {
    width: 100%;
    height: 36px;
    display: block;
    background: #f3f4f6;
    border: 1px solid #eef0f4;
    outline: none;
    border-radius: 18px;
    padding: 0 14px 0 36px;
    font-size: 11px;
    color: #374151;
    box-sizing: border-box;
}

.search-box input:focus {
    border-color: #d1d5db;
    background: #f9fafb;
}

.search-box input::placeholder {
    color: #9ca3af;
    opacity: 1;
}


/* =========================================================
   FILTER
========================================================= */

.filter-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.filter-btn {
    height: 36px;
    padding: 0 13px;
    background: white;
    border: 1px solid #d9dee7;
    border-radius: 8px;
    color: #374151;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 600;
    text-decoration: none;
    box-sizing: border-box;
}

.filter-btn:hover {
    background: #f8fafc;
}

.filter-panel {
    display: none;
    width: 100%;
    padding: 15px 0 3px;
    border-top: 1px solid #eef0f4;
    margin-top: 2px;
}

.filter-panel.show {
    display: block;
}

.filter-form {
    display: flex;
    align-items: flex-end;
    gap: 12px;
    width: 100%;
}

.filter-group {
    flex: 1;
    min-width: 150px;
}

.filter-label {
    display: block;
    margin-bottom: 6px;
    font-size: 10px;
    font-weight: 600;
    color: #374151;
}

.filter-select {
    width: 100%;
    height: 35px;
    padding: 0 10px;
    border: 1px solid #d9dee7;
    border-radius: 7px;
    background: white;
    color: #374151;
    font-size: 10px;
    outline: none;
    cursor: pointer;
    box-sizing: border-box;
}

.filter-select:focus {
    border-color: #17146b;
    box-shadow: 0 0 0 2px rgba(23, 20, 107, 0.06);
}

.filter-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    padding-bottom: 0;
}

.filter-apply {
    height: 35px;
    padding: 0 14px;
    border: none;
    border-radius: 7px;
    background: #17146b;
    color: white;
    font-size: 10px;
    font-weight: 600;
    cursor: pointer;
    white-space: nowrap;
}

.filter-apply:hover {
    background: #100e58;
}

.filter-reset {
    height: 35px;
    padding: 0 14px;
    border: 1px solid #d9dee7;
    border-radius: 7px;
    background: white;
    color: #374151;
    font-size: 10px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
    white-space: nowrap;
}

.filter-reset:hover {
    background: #f8fafc;
}

.filter-btn.active {
    background: #f4f3ff;
    border-color: #17146b;
    color: #17146b;
}


/* =========================================================
   ADD BUTTON
========================================================= */

.add-btn {
    height: 36px;
    padding: 0 15px;
    border: none;
    border-radius: 8px;
    background: #17146b;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: 11px;
    font-weight: 600;
    box-shadow: 0 3px 7px rgba(23, 20, 107, 0.20);
}

.add-btn:hover {
    background: #100e58;
}


/* =========================================================
   TABLE
========================================================= */

.table-wrapper {
    overflow-x: auto;
}

.splp-table {
    width: 100%;
    min-width: 1250px;
    border-collapse: collapse;
}

.splp-table th {
    background: #f8f9fb;
    color: #4b5563;
    font-size: 10px;
    font-weight: 700;
    text-align: center;
    padding: 13px 10px;
    border-top: 1px solid #eef0f4;
    border-bottom: 1px solid #e5e7eb;
    white-space: nowrap;
    letter-spacing: 0.2px;
}

.splp-table td {
    height: 50px;
    padding: 8px 10px;
    border-bottom: 1px solid #f0f1f3;
    font-size: 10px;
    color: #4b5563;
    white-space: nowrap;
    text-align: center;
}

.splp-table tbody tr:hover {
    background: #fafafa;
}

.splp-table td:nth-child(2),
.splp-table td:nth-child(3) {
    max-width: 180px;
    overflow: hidden;
    text-overflow: ellipsis;
}

.id {
    font-weight: 600;
    color: #4b5563;
}


/* =========================================================
   STATUS
========================================================= */

.status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 75px;
    padding: 7px 14px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
    line-height: 1;
    white-space: nowrap;
    box-sizing: border-box;
}

.status-tersedia {
    background: #d9f8e5;
    color: #247a47;
}

.status-digunakan {
    background: #dce9ff;
    color: #315ea8;
}

.status-akan-habis {
    background: #ffeb91;
    color: #966315;
}

.status-expired {
    background: #ffe0e0;
    color: #b42318;
}

.status-default {
    background: #e5e7eb;
    color: #4b5563;
}


/* =========================================================
   VERIFIKASI
========================================================= */

.verifikasi {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 110px;
    padding: 6px 10px;
    border-radius: 15px;
    font-size: 9px;
    font-weight: 600;
    line-height: 1.2;
    white-space: nowrap;
}

.verifikasi-menunggu {
    background: #fff4cc;
    color: #946200;
}

.verifikasi-disetujui {
    background: #d9f8e5;
    color: #247a47;
}

.verifikasi-ditolak {
    background: #ffe0e0;
    color: #b42318;
}


/* =========================================================
   KOMENTAR
========================================================= */

.komentar-cell {
    max-width: 180px;
    overflow: hidden;
    text-overflow: ellipsis;
}

.komentar-cell.empty {
    color: #9ca3af;
}


/* =========================================================
   ACTION
========================================================= */

.action {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}

.action button {
    width: 20px;
    height: 20px;
    padding: 0;
    border: none;
    background: transparent;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    transition: 0.15s ease;
}

.edit-btn {
    color: #198754;
}

.edit-btn:hover {
    color: #146c43;
    transform: scale(1.08);
}

.delete-btn {
    color: #dc3545;
}

.delete-btn:hover {
    color: #b02a37;
    transform: scale(1.08);
}


/* =========================================================
   EMPTY DATA
========================================================= */

.empty-data {
    text-align: center !important;
    padding: 40px !important;
    color: #6b7280 !important;
    font-size: 11px !important;
}


/* =========================================================
   TABLE FOOTER
========================================================= */

.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 13px 20px;
    min-height: 35px;
    border-top: 1px solid #eef0f4;
}

.showing-info {
    font-size: 10px;
    color: #6b7280;
}

.pagination {
    display: flex;
    align-items: center;
    gap: 4px;
}

.page-btn {
    width: 25px;
    height: 25px;
    border: 1px solid #e1e5eb;
    background: white;
    color: #8b95a1;
    border-radius: 5px;
    font-size: 9px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.page-btn:hover {
    background: #f5f6f8;
}

.page-btn.active {
    background: #17146b;
    border-color: #17146b;
    color: white;
}


/* =========================================================
   MODAL
========================================================= */

.modal {
    display: none;
    position: fixed;
    z-index: 9999;
    inset: 0;
    background: rgba(0, 0, 0, 0.78);
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
    overflow: hidden;
}

.modal-content {
    width: 780px;
    max-width: 100%;
    max-height: 92vh;
    background: white;
    border-radius: 14px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.18);
    display: flex;
    flex-direction: column;
    overflow: hidden;
}

.modal-header {
    flex-shrink: 0;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 18px 30px 15px;
    border-bottom: 1px solid #e5e7eb;
    background: white;
}

.modal-title-wrapper {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.modal-header h2 {
    margin: 0;
    font-size: 22px;
    line-height: 1.2;
    font-weight: 700;
    color: #111111;
}

.modal-subtitle {
    margin: 0;
    font-size: 11px;
    line-height: 1.4;
    color: #374151;
}

.close {
    flex-shrink: 0;
    border: none;
    background: transparent;
    font-size: 27px;
    line-height: 1;
    cursor: pointer;
    color: #555555;
    padding: 0;
    width: 25px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s ease;
}

.close:hover {
    color: #111111;
    transform: scale(1.05);
}

.modal-body {
    flex: 1;
    min-height: 0;
    padding: 28px 30px 20px;
    overflow-y: auto;
    overflow-x: hidden;
    box-sizing: border-box;
    scrollbar-width: thin;
    scrollbar-color: #c7cbd4 transparent;
}

.modal-body::-webkit-scrollbar {
    width: 7px;
}

.modal-body::-webkit-scrollbar-track {
    background: transparent;
}

.modal-body::-webkit-scrollbar-thumb {
    background: #c7cbd4;
    border-radius: 10px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background: #aeb4bf;
}


/* =========================================================
   FORM
========================================================= */

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-size: 11px;
    font-weight: 500;
    color: #374151;
}

.form-group label span {
    color: #ef4444;
}

.form-group input,
.form-group textarea,
.form-group select {
    width: 100%;
    height: 39px;
    padding: 0 11px;
    border: 1px solid #e5e7eb;
    border-radius: 7px;
    outline: none;
    font-family: inherit;
    font-size: 11px;
    color: #374151;
    background: white;
    box-sizing: border-box;
    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease;
}

.form-group input::placeholder,
.form-group textarea::placeholder {
    color: #d1d5db;
    opacity: 1;
}

.form-group input:focus,
.form-group textarea:focus,
.form-group select:focus {
    border-color: #17146b;
    box-shadow: 0 0 0 2px rgba(23, 20, 107, 0.06);
}

.form-group textarea {
    height: 87px;
    padding: 10px 11px;
    resize: vertical;
    min-height: 87px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 20px;
    margin-bottom: 0;
}

.form-row .form-group {
    margin-bottom: 20px;
}

.date-input {
    position: relative;
}

.date-input i {
    position: absolute;
    left: 11px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-size: 12px;
    pointer-events: none;
    z-index: 2;
}

.date-input input {
    padding-left: 32px;
}

.date-readonly {
    background: #f8f9fb !important;
}


/* =========================================================
   SEWA
========================================================= */

.sewa-section {
    display: none;
    margin-top: 0;
    padding-top: 0;
}

.sewa-section.show {
    display: block;
}

.custom-period {
    display: none;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 2px;
}

.custom-period.show {
    display: grid;
}

.form-info {
    display: block;
    margin-top: 5px;
    font-size: 9px;
    color: #6b7280;
    line-height: 1.4;
}


/* =========================================================
   EDIT ID
========================================================= */

#editId {
    background: #f8f9fb;
    color: #6b7280;
    cursor: not-allowed;
}


/* =========================================================
   FORM FOOTER
========================================================= */

.form-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 15px;
    padding: 14px 0 4px;
    margin-top: 8px;
    border-top: 1px solid #e5e7eb;
    background: white;
}

.cancel-btn {
    height: 39px;
    min-width: 79px;
    padding: 0 18px;
    border: 1px solid #d6dbea;
    background: white;
    color: #111111;
    border-radius: 7px;
    cursor: pointer;
    font-size: 11px;
    font-weight: 600;
}

.cancel-btn:hover {
    background: #f8f9fb;
}

.save-btn {
    height: 39px;
    min-width: 79px;
    padding: 0 18px;
    border: none;
    background: #17146b;
    color: white;
    border-radius: 7px;
    cursor: pointer;
    font-size: 11px;
    font-weight: 600;
    box-shadow: 0 2px 5px rgba(23, 20, 107, 0.20);
}

.save-btn:hover {
    background: #100e58;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1100px) {

    .filter-form {
        flex-wrap: wrap;
    }

    .filter-group {
        flex: 1 1 calc(50% - 12px);
    }

    .filter-actions {
        width: 100%;
        justify-content: flex-end;
    }

}

@media (max-width: 900px) {

    .statistics {
        grid-template-columns: 1fr;
    }

    .top-tools {
        flex-wrap: wrap;
    }

    .modal-content {
        width: 760px;
    }

}

@media (max-width: 700px) {

    .modal {
        padding: 12px;
    }

    .modal-content {
        width: 100%;
        max-height: 94vh;
        border-radius: 12px;
    }

    .modal-header {
        padding: 16px 20px 12px;
    }

    .modal-body {
        padding: 25px 20px 10px;
    }

    .form-row {
        grid-template-columns: 1fr;
        gap: 0;
    }

    .form-row .form-group {
        margin-bottom: 20px;
    }

    .custom-period {
        grid-template-columns: 1fr;
        gap: 0;
    }

    .filter-group {
        flex: 1 1 100%;
    }

}

@media (max-width: 600px) {

    .top-tools {
        flex-direction: column;
        align-items: stretch;
    }

    .left-tools,
    .right-tools {
        width: 100%;
    }

    .search-box {
        width: 100%;
    }

    .right-tools {
        justify-content: flex-end;
    }

}

</style>


<div class="infrastruktur-page">


    {{-- =====================================================
         SUCCESS MESSAGE
    ====================================================== --}}

    @if (session('success'))

        <div class="success-message">
            {{ session('success') }}
        </div>

    @endif


    {{-- =====================================================
         ERROR MESSAGE
    ====================================================== --}}

    @if ($errors->any())

        <div class="error-message">

            @foreach ($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="statistics">

        <div class="stat-card">

            <div class="stat-title">
                JUMLAH SPLP
            </div>

            <div class="stat-value">
                {{ $totalSplp }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-title">
                AKAN HABIS
            </div>

            <div class="stat-value">
                {{ $akanHabis }}
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-title">

                @if (request('tahun'))

                    PENGELUARAN {{ request('tahun') }}

                @else

                    PENGELUARAN TAHUNAN

                @endif

            </div>

            <div class="stat-value">

                Rp {{ number_format($splps->sum('harga'), 0, ',', '.') }}

            </div>

        </div>

    </div>


    {{-- =====================================================
         TABLE
    ====================================================== --}}

    <div class="table-container">


        <div class="table-header">


            <div class="top-tools">


                <div class="left-tools">

                    <div class="search-box">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Search..."
                        >

                    </div>

                </div>


                <div class="right-tools">


                    <div class="filter-wrapper">

                        <button
                            type="button"
                            class="filter-btn"
                            id="filterButton"
                            onclick="toggleFilter()"
                        >

                            <i class="bi bi-funnel"></i>

                            Filter

                            <i
                                class="bi bi-chevron-down"
                                id="filterArrow"
                            ></i>

                        </button>

                    </div>


                    <button
                        type="button"
                        class="add-btn"
                        onclick="openAddModal()"
                    >

                        <i class="bi bi-plus-lg"></i>

                        Add

                    </button>

                </div>

            </div>


            {{-- =================================================
                 FILTER PANEL
            ================================================== --}}

            <div
                class="filter-panel"
                id="filterPanel"
            >

                <form
                    action="{{ route('splp.index') }}"
                    method="GET"
                    class="filter-form"
                >


                    <div class="filter-group">

                        <label class="filter-label">
                            Status
                        </label>

                        <select
                            name="status"
                            class="filter-select"
                        >

                            <option value="">
                                Semua Status
                            </option>

                            <option
                                value="Tersedia"
                                {{ request('status') == 'Tersedia' ? 'selected' : '' }}
                            >
                                Tersedia
                            </option>

                            <option
                                value="Digunakan"
                                {{ request('status') == 'Digunakan' ? 'selected' : '' }}
                            >
                                Digunakan
                            </option>

                            <option
                                value="Akan Habis"
                                {{ request('status') == 'Akan Habis' ? 'selected' : '' }}
                            >
                                Akan Habis
                            </option>

                            <option
                                value="Expired"
                                {{ request('status') == 'Expired' ? 'selected' : '' }}
                            >
                                Expired
                            </option>

                        </select>

                    </div>


                    <div class="filter-group">

                        <label class="filter-label">
                            Pengadaan
                        </label>

                        <select
                            name="pengadaan"
                            class="filter-select"
                        >

                            <option value="">
                                Semua Pengadaan
                            </option>

                            <option
                                value="Beli"
                                {{ request('pengadaan') == 'Beli' ? 'selected' : '' }}
                            >
                                Beli
                            </option>

                            <option
                                value="Sewa"
                                {{ request('pengadaan') == 'Sewa' ? 'selected' : '' }}
                            >
                                Sewa
                            </option>

                        </select>

                    </div>


                    <div class="filter-group">

                        <label class="filter-label">
                            Verifikasi
                        </label>

                        <select
                            name="verifikasi"
                            class="filter-select"
                        >

                            <option value="">
                                Semua Verifikasi
                            </option>

                            <option
                                value="Menunggu disetujui"
                                {{ request('verifikasi') == 'Menunggu disetujui' ? 'selected' : '' }}
                            >
                                Menunggu disetujui
                            </option>

                            <option
                                value="Disetujui"
                                {{ request('verifikasi') == 'Disetujui' ? 'selected' : '' }}
                            >
                                Disetujui
                            </option>

                            <option
                                value="Ditolak"
                                {{ request('verifikasi') == 'Ditolak' ? 'selected' : '' }}
                            >
                                Ditolak
                            </option>

                        </select>

                    </div>


                    <div class="filter-group">

                        <label class="filter-label">
                            Tahun
                        </label>

                        <select
                            name="tahun"
                            class="filter-select"
                        >

                            <option value="">
                                Semua Tahun
                            </option>

                            @foreach ($tahuns as $item)

                                <option
                                    value="{{ $item }}"
                                    {{ request('tahun') == $item ? 'selected' : '' }}
                                >
                                    {{ $item }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="filter-actions">

                        <a
                            href="{{ route('splp.index') }}"
                            class="filter-reset"
                        >
                            Reset
                        </a>

                        <button
                            type="submit"
                            class="filter-apply"
                        >
                            Terapkan
                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="table-wrapper">

            <table class="splp-table">

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>
                            NAMA<br>
                            INFRASTRUKTUR
                        </th>

                        <th>
                            SPESIFIKASI
                        </th>

                        <th>
                            PENGADAAN
                        </th>

                        <th>
                            TGL.<br>
                            PENGADAAN
                        </th>

                        <th>
                            TGL.<br>
                            BERAKHIR
                        </th>

                        <th>
                            HARGA
                        </th>

                        <th>
                            STATUS
                        </th>

                        <th>
                            VERIFIKASI
                        </th>

                        <th>
                            KOMENTAR
                        </th>

                        <th>
                            AKSI
                        </th>

                    </tr>

                </thead>


                <tbody id="splpTable">


                    @forelse ($splps as $splp)

                        @php

                            $statusValue =
                                $splp->status_otomatis
                                ?? $splp->status
                                ?? 'Tersedia';


                            $statusClass = match (
                                strtolower(trim($statusValue))
                            ) {

                                'tersedia' =>
                                    'status-tersedia',

                                'digunakan' =>
                                    'status-digunakan',

                                'akan habis' =>
                                    'status-akan-habis',

                                'expired' =>
                                    'status-expired',

                                default =>
                                    'status-default',

                            };


                            $verifikasiValue =
                                $splp->verifikasi
                                ?? 'Menunggu disetujui';


                            $verifikasiClass = match (
                                strtolower(trim($verifikasiValue))
                            ) {

                                'menunggu disetujui' =>
                                    'verifikasi-menunggu',

                                'disetujui' =>
                                    'verifikasi-disetujui',

                                'ditolak' =>
                                    'verifikasi-ditolak',

                                default =>
                                    'verifikasi-menunggu',

                            };

                        @endphp


                        <tr>


                            <td class="id">
                                {{ $splp->id }}
                            </td>


                            <td
                                title="{{ $splp->nama_infrastruktur }}"
                            >
                                {{ $splp->nama_infrastruktur }}
                            </td>


                            <td
                                title="{{ $splp->spesifikasi }}"
                            >

                                @if ($splp->spesifikasi)

                                    {{ $splp->spesifikasi }}

                                @else

                                    -

                                @endif

                            </td>


                            <td>
                                {{ $splp->pengadaan }}
                            </td>


                            <td>

                                @if ($splp->tanggal_pengadaan)

                                    {{ $splp->tanggal_pengadaan->format('d/m/Y') }}

                                @else

                                    -

                                @endif

                            </td>


                            <td>

                                @if ($splp->tanggal_berakhir)

                                    {{ $splp->tanggal_berakhir->format('d/m/Y') }}

                                @else

                                    -

                                @endif

                            </td>


                            <td>

                                Rp
                                {{ number_format($splp->harga, 0, ',', '.') }}

                            </td>


                            <td>

                                <span class="status {{ $statusClass }}">

                                    {{ $statusValue }}

                                </span>

                            </td>


                            <td>

                                <span class="verifikasi {{ $verifikasiClass }}">

                                    {{ $verifikasiValue }}

                                </span>

                            </td>


                            <td
                                class="komentar-cell {{ !$splp->komentar ? 'empty' : '' }}"
                                title="{{ $splp->komentar ?? '' }}"
                            >

                                @if ($splp->komentar)

                                    {{ $splp->komentar }}

                                @else

                                    -

                                @endif

                            </td>


                            <td>

                                <div class="action">


                                    <button
                                        type="button"
                                        class="edit-btn"
                                        title="Edit"
                                        onclick='openEditModal(
                                            @json($splp->id),
                                            @json($splp->nama_infrastruktur),
                                            @json($splp->spesifikasi),
                                            @json($splp->pengadaan),
                                            @json($splp->tanggal_pengadaan ? $splp->tanggal_pengadaan->format("Y-m-d") : ""),
                                            @json($splp->tanggal_berakhir ? $splp->tanggal_berakhir->format("Y-m-d") : ""),
                                            @json($splp->harga),
                                            @json($splp->status)
                                        )'
                                    >

                                        <i class="bi bi-pencil-fill"></i>

                                    </button>


                                    <form
                                        action="{{ route('splp.destroy', $splp->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin mengajukan penghapusan data ini?')"
                                        style="display: inline;"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="delete-btn"
                                            title="Ajukan Penghapusan"
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
                                colspan="11"
                                class="empty-data"
                            >

                                @if (request('tahun'))

                                    Tidak ada data SPLP untuk tahun
                                    {{ request('tahun') }}.

                                @else

                                    Belum ada data SPLP.

                                @endif

                            </td>

                        </tr>

                    @endforelse


                </tbody>

            </table>

        </div>


        {{-- =================================================
             TABLE FOOTER
        ================================================== --}}

        <div class="table-footer">

            <div class="showing-info">

                Showing
                {{ $splps->count() }}
                entries

                @if (request('tahun'))

                    — Tahun {{ request('tahun') }}

                @endif

            </div>


            <div class="pagination">

                <button
                    type="button"
                    class="page-btn"
                >
                    <i class="bi bi-chevron-left"></i>
                </button>

                <button
                    type="button"
                    class="page-btn active"
                >
                    1
                </button>

                <button
                    type="button"
                    class="page-btn"
                >
                    2
                </button>

                <button
                    type="button"
                    class="page-btn"
                >
                    3
                </button>

                <button
                    type="button"
                    class="page-btn"
                >
                    <i class="bi bi-chevron-right"></i>
                </button>

            </div>

        </div>


    </div>

</div>


{{-- =========================================================
     MODAL TAMBAH
========================================================= --}}

<div
    class="modal"
    id="addModal"
>

    <div class="modal-content">

        <div class="modal-header">

            <div class="modal-title-wrapper">

                <h2>
                    Tambah Data SPLP
                </h2>

                <p class="modal-subtitle">
                    Masukan detail aset infrastruktur SPLP baru ke dalam sistem.
                </p>

            </div>

            <button
                type="button"
                class="close"
                onclick="closeAddModal()"
            >

                &times;

            </button>

        </div>


        <div class="modal-body">

            <form
                action="{{ route('splp.store') }}"
                method="POST"
                id="addForm"
            >

                @csrf


                <div class="form-group">

                    <label>
                        Nama Infrastruktur
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        name="nama_infrastruktur"
                        placeholder="SPLP"
                        value="{{ old('nama_infrastruktur') }}"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Spesifikasi
                    </label>

                    <textarea
                        name="spesifikasi"
                        placeholder="Masukkan spesifikasi"
                    >{{ old('spesifikasi') }}</textarea>

                    <small class="form-info">
                        Spesifikasi dapat dikosongkan jika tidak tersedia.
                    </small>

                </div>


                <div class="form-group">

                    <label>
                        Pengadaan
                        <span>*</span>
                    </label>

                    <select
                        id="pengadaan"
                        name="pengadaan"
                        required
                    >

                        <option value="">
                            Pilih Jenis Pengadaan
                        </option>

                        <option
                            value="Sewa"
                            {{ old('pengadaan') === 'Sewa' ? 'selected' : '' }}
                        >
                            Sewa
                        </option>

                        <option
                            value="Beli"
                            {{ old('pengadaan') === 'Beli' ? 'selected' : '' }}
                        >
                            Beli
                        </option>

                    </select>

                </div>


                <div class="form-row">


                    <div class="form-group">

                        <label>
                            Harga
                            <span>*</span>
                        </label>

                        <input
                            type="number"
                            name="harga"
                            placeholder="Rp"
                            value="{{ old('harga', 0) }}"
                            min="0"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Status
                            <span>*</span>
                        </label>

                        <select
                            name="status"
                            id="addStatus"
                            required
                        >

                            <option value="">
                                Pilih Status
                            </option>

                            <option
                                value="Tersedia"
                                {{ old('status') === 'Tersedia' ? 'selected' : '' }}
                            >
                                Tersedia
                            </option>

                            <option
                                value="Digunakan"
                                {{ old('status') === 'Digunakan' ? 'selected' : '' }}
                            >
                                Digunakan
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label>
                            Tanggal Pengadaan
                        </label>

                        <div class="date-input">

                            <i class="bi bi-calendar3"></i>

                            <input
                                type="date"
                                id="tanggal_pengadaan"
                                name="tanggal_pengadaan"
                                value="{{ old('tanggal_pengadaan') }}"
                                required
                            >

                        </div>

                    </div>


                </div>


                <div class="form-group">

                    <label>
                        Tanggal Berakhir
                    </label>

                    <div class="date-input">

                        <i class="bi bi-calendar3"></i>

                        <input
                            type="date"
                            id="tanggal_berakhir"
                            name="tanggal_berakhir"
                            value="{{ old('tanggal_berakhir') }}"
                        >

                    </div>

                    <small
                        id="tanggal-info"
                        class="form-info"
                    >
                        Untuk pengadaan Beli, tanggal berakhir dapat dikosongkan.
                    </small>

                </div>


                <div
                    id="sewa-section"
                    class="sewa-section"
                >

                    <div class="form-group">

                        <label>
                            Periode Sewa
                        </label>

                        <select id="periode_sewa">

                            <option value="">
                                Pilih Periode
                            </option>

                            <option value="1">
                                1 Bulan
                            </option>

                            <option value="3">
                                3 Bulan
                            </option>

                            <option value="6">
                                6 Bulan
                            </option>

                            <option value="12">
                                12 Bulan
                            </option>

                            <option value="custom">
                                Lainnya
                            </option>

                        </select>

                    </div>


                    <div
                        id="custom-period"
                        class="custom-period"
                    >

                        <div class="form-group">

                            <label>
                                Jumlah
                            </label>

                            <input
                                type="number"
                                id="custom_jumlah"
                                min="1"
                                placeholder="Contoh: 2"
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Satuan
                            </label>

                            <select id="custom_satuan">

                                <option value="months">
                                    Bulan
                                </option>

                                <option value="years">
                                    Tahun
                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                <div class="form-actions">

                    <button
                        type="button"
                        class="cancel-btn"
                        onclick="closeAddModal()"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="save-btn"
                    >
                        Simpan
                    </button>

                </div>


            </form>

        </div>

    </div>

</div>


{{-- =========================================================
     MODAL EDIT
========================================================= --}}

<div
    class="modal"
    id="editModal"
>

    <div class="modal-content">

        <div class="modal-header">

            <div class="modal-title-wrapper">

                <h2>
                    Edit Data SPLP
                </h2>

                <p class="modal-subtitle">
                    Ubah detail aset infrastruktur SPLP yang sudah tersimpan.
                </p>

            </div>

            <button
                type="button"
                class="close"
                onclick="closeEditModal()"
            >

                &times;

            </button>

        </div>


        <div class="modal-body">

            <form
                id="editForm"
                method="POST"
            >

                @csrf

                @method('PUT')


                <div class="form-group">

                    <label>
                        ID SPLP
                    </label>

                    <input
                        type="text"
                        id="editId"
                        readonly
                    >

                </div>


                <div class="form-group">

                    <label>
                        Nama Infrastruktur
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        name="nama_infrastruktur"
                        id="editNama"
                        required
                    >

                </div>


                <div class="form-group">

                    <label>
                        Spesifikasi
                    </label>

                    <textarea
                        name="spesifikasi"
                        id="editSpesifikasi"
                    ></textarea>

                    <small class="form-info">
                        Spesifikasi dapat dikosongkan jika tidak tersedia.
                    </small>

                </div>


                <div class="form-group">

                    <label>
                        Pengadaan
                        <span>*</span>
                    </label>

                    <select
                        name="pengadaan"
                        id="editPengadaan"
                        required
                    >

                        <option value="Sewa">
                            Sewa
                        </option>

                        <option value="Beli">
                            Beli
                        </option>

                    </select>

                </div>


                <div class="form-row">


                    <div class="form-group">

                        <label>
                            Harga
                            <span>*</span>
                        </label>

                        <input
                            type="number"
                            name="harga"
                            id="editHarga"
                            min="0"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Status
                            <span>*</span>
                        </label>

                        <select
                            name="status"
                            id="editStatus"
                            required
                        >

                            <option value="Tersedia">
                                Tersedia
                            </option>

                            <option value="Digunakan">
                                Digunakan
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label>
                            Tanggal Pengadaan
                        </label>

                        <div class="date-input">

                            <i class="bi bi-calendar3"></i>

                            <input
                                type="date"
                                name="tanggal_pengadaan"
                                id="editTanggalPengadaan"
                                required
                            >

                        </div>

                    </div>


                </div>


                <div class="form-group">

                    <label>
                        Tanggal Berakhir
                    </label>

                    <div class="date-input">

                        <i class="bi bi-calendar3"></i>

                        <input
                            type="date"
                            name="tanggal_berakhir"
                            id="editTanggalBerakhir"
                        >

                    </div>

                    <small
                        id="editTanggalInfo"
                        class="form-info"
                    >
                        Untuk pengadaan Beli, tanggal berakhir dapat dikosongkan.
                    </small>

                </div>


                <div
                    id="editSewaSection"
                    class="sewa-section"
                >

                    <div class="form-group">

                        <label>
                            Periode Sewa
                        </label>

                        <select id="editPeriodeSewa">

                            <option value="">
                                Tidak mengubah periode
                            </option>

                            <option value="1">
                                1 Bulan
                            </option>

                            <option value="3">
                                3 Bulan
                            </option>

                            <option value="6">
                                6 Bulan
                            </option>

                            <option value="12">
                                12 Bulan
                            </option>

                            <option value="custom">
                                Lainnya
                            </option>

                        </select>

                    </div>


                    <div
                        id="editCustomPeriod"
                        class="custom-period"
                    >

                        <div class="form-group">

                            <label>
                                Jumlah
                            </label>

                            <input
                                type="number"
                                id="editCustomJumlah"
                                min="1"
                                placeholder="Contoh: 2"
                            >

                        </div>


                        <div class="form-group">

                            <label>
                                Satuan
                            </label>

                            <select id="editCustomSatuan">

                                <option value="months">
                                    Bulan
                                </option>

                                <option value="years">
                                    Tahun
                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                <div class="form-actions">

                    <button
                        type="button"
                        class="cancel-btn"
                        onclick="closeEditModal()"
                    >
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="save-btn"
                    >
                        Update
                    </button>

                </div>


            </form>

        </div>

    </div>

</div>


<script>

/* =========================================================
   FILTER
========================================================= */

function toggleFilter()
{
    const panel =
        document.getElementById('filterPanel');

    const button =
        document.getElementById('filterButton');

    const arrow =
        document.getElementById('filterArrow');

    if (!panel || !button || !arrow)
    {
        return;
    }

    if (panel.classList.contains('show'))
    {
        panel.classList.remove('show');
        button.classList.remove('active');

        arrow.classList.remove('bi-chevron-up');
        arrow.classList.add('bi-chevron-down');
    }
    else
    {
        panel.classList.add('show');
        button.classList.add('active');

        arrow.classList.remove('bi-chevron-down');
        arrow.classList.add('bi-chevron-up');
    }
}


/* =========================================================
   ADD MODAL
========================================================= */

function openAddModal()
{
    document.getElementById('addModal').style.display = 'flex';
}

function closeAddModal()
{
    document.getElementById('addModal').style.display = 'none';
}


/* =========================================================
   ADD ELEMENT
========================================================= */

const pengadaan =
    document.getElementById('pengadaan');

const tanggalPengadaan =
    document.getElementById('tanggal_pengadaan');

const tanggalBerakhir =
    document.getElementById('tanggal_berakhir');

const sewaSection =
    document.getElementById('sewa-section');

const periodeSewa =
    document.getElementById('periode_sewa');

const customPeriod =
    document.getElementById('custom-period');

const customJumlah =
    document.getElementById('custom_jumlah');

const customSatuan =
    document.getElementById('custom_satuan');

const tanggalInfo =
    document.getElementById('tanggal-info');


/* =========================================================
   HITUNG TANGGAL SEWA
========================================================= */

function calculateEndDate()
{
    if (!pengadaan || pengadaan.value !== 'Sewa')
    {
        return;
    }

    if (!tanggalPengadaan.value)
    {
        tanggalBerakhir.value = '';
        return;
    }

    let jumlah = 0;
    let satuan = 'months';

    if (
        periodeSewa.value &&
        periodeSewa.value !== 'custom'
    )
    {
        jumlah =
            parseInt(periodeSewa.value);
    }

    if (periodeSewa.value === 'custom')
    {
        jumlah =
            parseInt(customJumlah.value) || 0;

        satuan =
            customSatuan.value;
    }

    if (jumlah <= 0)
    {
        tanggalBerakhir.value = '';
        return;
    }

    const date =
        new Date(
            tanggalPengadaan.value + 'T00:00:00'
        );

    if (satuan === 'years')
    {
        date.setFullYear(
            date.getFullYear() + jumlah
        );
    }
    else
    {
        date.setMonth(
            date.getMonth() + jumlah
        );
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
        `${year}-${month}-${day}`;
}


/* =========================================================
   CUSTOM PERIOD
========================================================= */

function updateCustomPeriod()
{
    if (
        periodeSewa.value === 'custom'
    )
    {
        customPeriod.classList.add('show');
    }
    else
    {
        customPeriod.classList.remove('show');
    }

    calculateEndDate();
}


/* =========================================================
   PENGADAAN
========================================================= */

function updatePengadaan()
{
    if (pengadaan.value === 'Sewa')
    {
        sewaSection.classList.add('show');

        tanggalBerakhir.readOnly = true;

        tanggalBerakhir.classList.add('date-readonly');

        tanggalInfo.textContent =
            'Tanggal berakhir dihitung otomatis berdasarkan periode sewa.';

        calculateEndDate();
    }
    else
    {
        sewaSection.classList.remove('show');

        customPeriod.classList.remove('show');

        periodeSewa.value = '';

        customJumlah.value = '';

        tanggalBerakhir.value = '';

        tanggalBerakhir.readOnly = false;

        tanggalBerakhir.classList.remove('date-readonly');

        tanggalInfo.textContent =
            'Untuk pengadaan Beli, tanggal berakhir dapat dikosongkan.';
    }
}


if (pengadaan)
{
    pengadaan.addEventListener(
        'change',
        updatePengadaan
    );
}

if (periodeSewa)
{
    periodeSewa.addEventListener(
        'change',
        updateCustomPeriod
    );
}

if (customJumlah)
{
    customJumlah.addEventListener(
        'input',
        calculateEndDate
    );
}

if (customSatuan)
{
    customSatuan.addEventListener(
        'change',
        calculateEndDate
    );
}

if (tanggalPengadaan)
{
    tanggalPengadaan.addEventListener(
        'change',
        calculateEndDate
    );
}


/* =========================================================
   EDIT MODAL
========================================================= */

function openEditModal(
    id,
    nama,
    spesifikasi,
    pengadaanValue,
    tanggalPengadaanValue,
    tanggalBerakhirValue,
    harga,
    status
)
{
    document.getElementById('editModal').style.display = 'flex';

    document.getElementById('editId').value =
        id;

    document.getElementById('editNama').value =
        nama;

    document.getElementById('editSpesifikasi').value =
        spesifikasi ?? '';

    document.getElementById('editPengadaan').value =
        pengadaanValue;

    document.getElementById('editTanggalPengadaan').value =
        tanggalPengadaanValue;

    document.getElementById('editTanggalBerakhir').value =
        tanggalBerakhirValue;

    document.getElementById('editHarga').value =
        harga;

    document.getElementById('editStatus').value =
        status;

    document.getElementById('editForm').action =
        "{{ url('/infrastruktur/splp') }}/" + id;

    document.getElementById('editPeriodeSewa').value = '';

    document.getElementById('editCustomPeriod')
        .classList.remove('show');

    document.getElementById('editCustomJumlah').value = '';

    updateEditPengadaan();
}


/* =========================================================
   EDIT ELEMENT
========================================================= */

const editPengadaan =
    document.getElementById('editPengadaan');

const editTanggalPengadaan =
    document.getElementById('editTanggalPengadaan');

const editTanggalBerakhir =
    document.getElementById('editTanggalBerakhir');

const editSewaSection =
    document.getElementById('editSewaSection');

const editPeriodeSewa =
    document.getElementById('editPeriodeSewa');

const editCustomPeriod =
    document.getElementById('editCustomPeriod');

const editCustomJumlah =
    document.getElementById('editCustomJumlah');

const editCustomSatuan =
    document.getElementById('editCustomSatuan');

const editTanggalInfo =
    document.getElementById('editTanggalInfo');


/* =========================================================
   HITUNG TANGGAL EDIT
========================================================= */

function calculateEditEndDate()
{
    if (
        editPengadaan.value !== 'Sewa'
    )
    {
        return;
    }

    if (!editTanggalPengadaan.value)
    {
        editTanggalBerakhir.value = '';
        return;
    }

    let jumlah = 0;
    let satuan = 'months';

    if (
        editPeriodeSewa.value &&
        editPeriodeSewa.value !== 'custom'
    )
    {
        jumlah =
            parseInt(editPeriodeSewa.value);
    }

    if (
        editPeriodeSewa.value === 'custom'
    )
    {
        jumlah =
            parseInt(editCustomJumlah.value) || 0;

        satuan =
            editCustomSatuan.value;
    }

    if (jumlah <= 0)
    {
        return;
    }

    const date =
        new Date(
            editTanggalPengadaan.value + 'T00:00:00'
        );

    if (satuan === 'years')
    {
        date.setFullYear(
            date.getFullYear() + jumlah
        );
    }
    else
    {
        date.setMonth(
            date.getMonth() + jumlah
        );
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

    editTanggalBerakhir.value =
        `${year}-${month}-${day}`;
}


/* =========================================================
   CUSTOM EDIT
========================================================= */

function updateEditCustomPeriod()
{
    if (
        editPeriodeSewa.value === 'custom'
    )
    {
        editCustomPeriod.classList.add('show');
    }
    else
    {
        editCustomPeriod.classList.remove('show');
    }

    calculateEditEndDate();
}


/* =========================================================
   UPDATE EDIT PENGADAAN
========================================================= */

function updateEditPengadaan()
{
    if (
        editPengadaan.value === 'Sewa'
    )
    {
        editSewaSection.classList.add('show');

        editTanggalBerakhir.readOnly = true;

        editTanggalBerakhir.classList.add(
            'date-readonly'
        );

        editTanggalInfo.textContent =
            'Tanggal berakhir dihitung otomatis berdasarkan periode sewa. Pilih periode jika ingin mengubahnya.';
    }
    else
    {
        editSewaSection.classList.remove('show');

        editCustomPeriod.classList.remove('show');

        editPeriodeSewa.value = '';

        editCustomJumlah.value = '';

        editTanggalBerakhir.value = '';

        editTanggalBerakhir.readOnly = false;

        editTanggalBerakhir.classList.remove(
            'date-readonly'
        );

        editTanggalInfo.textContent =
            'Untuk pengadaan Beli, tanggal berakhir dapat dikosongkan.';
    }
}


if (editPengadaan)
{
    editPengadaan.addEventListener(
        'change',
        updateEditPengadaan
    );
}

if (editPeriodeSewa)
{
    editPeriodeSewa.addEventListener(
        'change',
        updateEditCustomPeriod
    );
}

if (editCustomJumlah)
{
    editCustomJumlah.addEventListener(
        'input',
        calculateEditEndDate
    );
}

if (editCustomSatuan)
{
    editCustomSatuan.addEventListener(
        'change',
        calculateEditEndDate
    );
}

if (editTanggalPengadaan)
{
    editTanggalPengadaan.addEventListener(
        'change',
        function()
        {
            if (
                editPeriodeSewa &&
                editPeriodeSewa.value
            )
            {
                calculateEditEndDate();
            }
        }
    );
}


/* =========================================================
   CLOSE EDIT
========================================================= */

function closeEditModal()
{
    document.getElementById('editModal').style.display = 'none';
}


/* =========================================================
   CLOSE MODAL
========================================================= */

window.addEventListener('click', function(event)
{
    const addModal =
        document.getElementById('addModal');

    const editModal =
        document.getElementById('editModal');

    if (event.target === addModal)
    {
        closeAddModal();
    }

    if (event.target === editModal)
    {
        closeEditModal();
    }
});


/* =========================================================
   SEARCH
========================================================= */

const searchInput =
    document.getElementById('searchInput');

if (searchInput)
{
    searchInput.addEventListener(
        'keyup',
        function()
        {
            const keyword =
                this.value.toLowerCase();

            const rows =
                document.querySelectorAll(
                    '#splpTable tr'
                );

            rows.forEach(function(row)
            {
                const text =
                    row.innerText.toLowerCase();

                if (text.includes(keyword))
                {
                    row.style.display = '';
                }
                else
                {
                    row.style.display = 'none';
                }
            });
        }
    );
}


/* =========================================================
   BUKA MODAL JIKA ERROR
========================================================= */

@if ($errors->any())

    document.addEventListener(
        'DOMContentLoaded',
        function()
        {
            openAddModal();

            if (pengadaan)
            {
                updatePengadaan();
            }
        }
    );

@endif


/* =========================================================
   INITIAL STATE
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function()
    {
        if (pengadaan)
        {
            updatePengadaan();
        }

        const hasActiveFilter =
            {{ request()->hasAny(['status', 'pengadaan', 'verifikasi', 'tahun']) ? 'true' : 'false' }};

        if (hasActiveFilter)
        {
            const panel =
                document.getElementById('filterPanel');

            const button =
                document.getElementById('filterButton');

            const arrow =
                document.getElementById('filterArrow');

            if (panel && button && arrow)
            {
                panel.classList.add('show');

                button.classList.add('active');

                arrow.classList.remove(
                    'bi-chevron-down'
                );

                arrow.classList.add(
                    'bi-chevron-up'
                );
            }
        }
    }
);

</script>

@endsection
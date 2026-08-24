@extends('layouts.app')

@section('title', 'Data - Inventory IT Assets')

@section('page-title', 'DATA')

@section('content')

<style>
    /* =====================================================
       DATA PAGE
    ====================================================== */

    .data-page {
        width: 100%;
    }


    /* =====================================================
       SUMMARY CARD
    ====================================================== */

    .summary-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        margin-bottom: 24px;
    }

    .summary-card {
        background: white;
        min-height: 95px;
        padding: 15px 18px;
        border-radius: 7px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
    }

    .summary-label {
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .summary-value {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
    }

    .total-card {
        background: #f1f5ff;
    }

    .total-card .summary-label {
        color: #2563eb;
    }

    .jenis-card {
        background: #fff9e8;
    }

    .jenis-card .summary-label {
        color: #d97706;
    }

    .pending-card {
        background: #f2ffe9;
    }

    .pending-card .summary-label {
        color: #16a34a;
    }


    /* =====================================================
       TABLE CONTAINER
    ====================================================== */

    .data-table-container {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }


    /* =====================================================
       TABLE TOOLBAR
    ====================================================== */

    .table-toolbar {
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 12px;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-toolbar-left {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .table-search {
        width: 200px;
        height: 33px;
        background: #e5e7eb;
        border: none;
        border-radius: 20px;
        display: flex;
        align-items: center;
        padding: 0 12px;
    }

    .table-search i {
        font-size: 14px;
        color: #666;
        margin-right: 7px;
    }

    .table-search input {
        width: 100%;
        border: none;
        outline: none;
        background: transparent;
        font-size: 11px;
    }

    .table-actions {
        display: flex;
        gap: 10px;
    }

    .filter-button,
    .add-button {
        height: 33px;
        padding: 0 13px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .filter-button {
        background: white;
        color: #071b88;
        border: 1px solid #071b88;
    }

    .filter-button:hover {
        background: #f0f4ff;
    }

    .add-button {
        background: #071b88;
        color: white;
        border: 1px solid #071b88;
    }

    .add-button:hover {
        background: #08089a;
    }


    /* =====================================================
       TABLE
    ====================================================== */

    .data-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
    }

    .data-table th {
        height: 42px;
        background: #fafafa;
        color: #374151;
        font-size: 10px;
        font-weight: 600;
        text-align: center;
        border-right: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
        padding: 0 10px;
        white-space: nowrap;
    }

    .data-table td {
        height: 55px;
        color: #374151;
        text-align: center;
        border-right: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
        padding: 0 10px;
        white-space: nowrap;
    }

    .data-table th:last-child,
    .data-table td:last-child {
        border-right: none;
    }

    .data-table tbody tr:hover {
        background: #f8fafc;
    }


    /* =====================================================
       STATUS
    ====================================================== */

    .status {
        display: inline-block;
        padding: 4px 9px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 600;
    }

    .status-publish {
        color: #16a34a;
        background: #dcfce7;
    }

    .status-pending {
        color: #d97706;
        background: #fef3c7;
    }


    /* =====================================================
       ACTION
    ====================================================== */

    .action-buttons {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
    }

    .action-button {
        width: 21px;
        height: 21px;
        border: none;
        background: transparent;
        cursor: pointer;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .action-button.edit {
        color: #16a34a;
    }

    .action-button.delete {
        color: #dc2626;
    }

    .action-button:hover {
        transform: scale(1.15);
    }


    /* =====================================================
       TABLE FOOTER
    ====================================================== */

    .table-footer {
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 15px;
        font-size: 9px;
        color: #555;
    }

    .pagination {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .pagination button {
        width: 22px;
        height: 22px;
        border: 1px solid #e5e7eb;
        background: white;
        border-radius: 3px;
        font-size: 9px;
        color: #374151;
        cursor: pointer;
    }

    .pagination button.active {
        background: #071b88;
        color: white;
        border-color: #071b88;
    }

    .pagination button:hover:not(.active) {
        background: #f1f5f9;
    }


    /* =====================================================
       RESPONSIVE
    ====================================================== */

    @media (max-width: 900px) {

        .summary-cards {
            grid-template-columns: 1fr;
        }

        .table-toolbar {
            height: auto;
            padding: 12px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .table-toolbar-left {
            width: 100%;
        }

        .table-search {
            width: 100%;
        }
    }
</style>


<div class="data-page">


    {{-- =================================================
         SUMMARY
    ================================================== --}}

    <div class="summary-cards">

        {{-- TOTAL DATASET --}}
        <div class="summary-card total-card">

            <div class="summary-label">
                TOTAL DATASET
            </div>

            <div class="summary-value">
                125
            </div>

        </div>


        {{-- JENIS DATA --}}
        <div class="summary-card jenis-card">

            <div class="summary-label">
                JENIS DATA
            </div>

            <div class="summary-value">
                8
            </div>

        </div>


        {{-- PENDING --}}
        <div class="summary-card pending-card">

            <div class="summary-label">
                PENDING
            </div>

            <div class="summary-value">
                112
            </div>

        </div>

    </div>


    {{-- =================================================
         TABLE
    ================================================== --}}

    <div class="data-table-container">


        {{-- TOOLBAR --}}
        <div class="table-toolbar">

            <div class="table-toolbar-left">

                <div class="table-search">

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        placeholder="Search..."
                    >

                </div>

            </div>


            <div class="table-actions">

                <button
                    type="button"
                    class="filter-button">

                    <i class="bi bi-filter"></i>

                    Filter

                </button>


                <button
                    type="button"
                    class="add-button">

                    <i class="bi bi-plus-circle"></i>

                    Add

                </button>

            </div>

        </div>


        {{-- TABLE --}}
        <div class="data-table-wrapper">

            <table class="data-table">

                <thead>

                    <tr>

                        <th width="10%">
                            ID
                        </th>

                        <th width="25%">
                            NAMA DATASET
                        </th>

                        <th width="20%">
                            JENIS DATA
                        </th>

                        <th width="12%">
                            TAHUN
                        </th>

                        <th width="13%">
                            STATUS
                        </th>

                        <th width="12%">
                            AKSI
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <tr>

                        <td>DS-001</td>

                        <td>Penduduk Kota Bekasi</td>

                        <td>Dokumen</td>

                        <td>2022</td>

                        <td>
                            <span class="status status-publish">
                                Publish
                            </span>
                        </td>

                        <td>

                            <div class="action-buttons">

                                <button
                                    class="action-button edit"
                                    title="Edit">

                                    <i class="bi bi-pencil-fill"></i>

                                </button>

                                <button
                                    class="action-button delete"
                                    title="Hapus">

                                    <i class="bi bi-trash-fill"></i>

                                </button>

                            </div>

                        </td>

                    </tr>


                    <tr>

                        <td>DS-002</td>

                        <td>Penduduk</td>

                        <td>Dokumen</td>

                        <td>2022</td>

                        <td>
                            <span class="status status-publish">
                                Publish
                            </span>
                        </td>

                        <td>

                            <div class="action-buttons">

                                <button
                                    class="action-button edit"
                                    title="Edit">

                                    <i class="bi bi-pencil-fill"></i>

                                </button>

                                <button
                                    class="action-button delete"
                                    title="Hapus">

                                    <i class="bi bi-trash-fill"></i>

                                </button>

                            </div>

                        </td>

                    </tr>


                    <tr>

                        <td>DS-003</td>

                        <td>Penduduk</td>

                        <td>Dokumen</td>

                        <td>2022</td>

                        <td>
                            <span class="status status-publish">
                                Publish
                            </span>
                        </td>

                        <td>

                            <div class="action-buttons">

                                <button
                                    class="action-button edit"
                                    title="Edit">

                                    <i class="bi bi-pencil-fill"></i>

                                </button>

                                <button
                                    class="action-button delete"
                                    title="Hapus">

                                    <i class="bi bi-trash-fill"></i>

                                </button>

                            </div>

                        </td>

                    </tr>


                    <tr>

                        <td>DS-004</td>

                        <td>Penduduk</td>

                        <td>Dokumen</td>

                        <td>2022</td>

                        <td>
                            <span class="status status-publish">
                                Publish
                            </span>
                        </td>

                        <td>

                            <div class="action-buttons">

                                <button
                                    class="action-button edit"
                                    title="Edit">

                                    <i class="bi bi-pencil-fill"></i>

                                </button>

                                <button
                                    class="action-button delete"
                                    title="Hapus">

                                    <i class="bi bi-trash-fill"></i>

                                </button>

                            </div>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>


        {{-- FOOTER TABLE --}}
        <div class="table-footer">

            <span>
                Showing 1 to 4 of 125 entries
            </span>


            <div class="pagination">

                <button>
                    <i class="bi bi-chevron-left"></i>
                </button>

                <button class="active">
                    1
                </button>

                <button>
                    2
                </button>

                <button>
                    3
                </button>

                <button>
                    <i class="bi bi-chevron-right"></i>
                </button>

            </div>

        </div>

    </div>

</div>

@endsection
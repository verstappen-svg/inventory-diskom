index.blade

@extends('layouts.app')

@section('title', 'Data')
@section('page-title', 'Data')

@section('content')

<style>
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

.data-alert ul {
    margin: 6px 0 0 18px;
    padding: 0;
}

/* =========================================================
   SUMMARY CARD
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
    flex: 1;
}

.data-toolbar-title {
    color: #1f2937;
    font-size: 13px;
    font-weight: 700;
}

.data-toolbar-right {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 9px;
}

/* =========================================================
   SEARCH
========================================================= */

.data-search {
    position: relative;
    width: 270px;
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

.data-button {
    height: 37px;
    padding: 0 13px;
    border-radius: 9px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s ease;
    white-space: nowrap;
}

.data-button-primary {
    border: none;
    background: #071b88;
    color: #ffffff;
}

.data-button-primary:hover {
    background: #050f63;
}

.data-button-secondary {
    border: 1px solid #d1d5db;
    background: #ffffff;
    color: #374151;
}

.data-button-secondary:hover {
    background: #f8fafc;
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
    white-space: nowrap;
}

.data-filter-button:hover {
    background: #f8fafc;
}

.data-filter-dropdown {
    position: absolute;
    top: calc(100% + 7px);
    right: 0;
    width: 260px;
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
    align-items: center;
    margin-top: 13px;
}

.data-filter-action {
    border: none;
    background: transparent;
    color: #075985;
    font-size: 10px;
    font-weight: 600;
    cursor: pointer;
    padding: 0;
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
    min-width: 1350px;
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
   ID
========================================================= */

.data-id {
    display: inline-flex;
    align-items: center;
    padding: 5px 9px;
    border-radius: 7px;
    background: #eef2ff;
    color: #3730a3;
    font-size: 10px;
    font-weight: 700;
    white-space: nowrap;
}

/* =========================================================
   ID
========================================================= */

.data-id {
    display: inline-flex;
    align-items: center;
    padding: 5px 9px;
    border-radius: 7px;
    background: #eef2ff;
    color: #3730a3;
    font-size: 10px;
    font-weight: 700;
    white-space: nowrap;
}


/* =========================================================
   NAME
========================================================= */

.data-name {
    display: block;
    max-width: 250px;
    color: #1f2937;
    font-weight: 600;
    line-height: 1.35;
}

/* =========================================================
   TOPIK
========================================================= */

.data-topic {
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
   YEAR
========================================================= */

.data-year {
    font-weight: 600;
    color: #374151;
    white-space: nowrap;
}

/* =========================================================
   FILE
========================================================= */

.data-file {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #475569;
    text-decoration: none;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}

.data-file:hover {
    color: #075985;
}

.data-file i {
    color: #15803d;
    font-size: 13px;
}

.data-no-file {
    color: #9ca3af;
    font-size: 10px;
}

/* =========================================================
   DATE
========================================================= */

.data-date {
    color: #4b5563;
    white-space: nowrap;
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
   COMMENT
========================================================= */

.data-comment {
    display: block;
    width: 220px;
    max-width: 220px;
    line-height: 1.4;
    color: #64748b;
    font-size: 10px;
}

.data-comment-text {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    word-break: break-word;
}

.data-comment-empty {
    color: #9ca3af;
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
    text-decoration: none;
    box-sizing: border-box;
}

.data-detail-button {
    background: #f1f5f9;
    color: #475569;
}

.data-detail-button:hover {
    background: #e2e8f0;
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

.data-comment-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 29px;
    height: 29px;
    border: none;
    border-radius: 7px;
    background: #fef3c7;
    color: #92400e;
    cursor: pointer;
}

/* =========================================================
   EMPTY
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
   FOOTER
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
    padding: 20px;
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
    width: min(1100px, 100%);
    max-height: 90vh;
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 25px 70px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    min-height: 0;
}

.data-modal-small {
    width: min(700px, 100%);
}

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
    min-width: 0;
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
    flex-shrink: 0;
}

.data-modal-close:hover {
    background: #fee2e2;
    color: #dc2626;
}

/* =========================================================
   FORM DALAM MODAL
========================================================= */

.data-modal > form {
    display: flex;
    flex-direction: column;
    flex: 1 1 auto;
    min-height: 0;
    overflow: hidden;
}

/* =========================================================
   MODAL BODY - BISA SCROLL
========================================================= */

.data-modal-body {
    flex: 1 1 auto;
    min-height: 0;
    padding: 19px 21px;
    overflow-y: auto;
    overflow-x: hidden;
    box-sizing: border-box;
}

.data-modal-body::-webkit-scrollbar {
    width: 6px;
}

.data-modal-body::-webkit-scrollbar-track {
    background: transparent;
}

.data-modal-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 10px;
}


/* =========================================================
   BATCH TABLE
========================================================= */

.batch-info {
    padding: 11px 13px;
    margin-bottom: 14px;
    border-radius: 9px;
    background: #eff6ff;
    border: 1px solid #dbeafe;
    color: #1e40af;
    font-size: 10px;
    line-height: 1.5;
}

.batch-table-wrapper {
    width: 100%;
    overflow-x: auto;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
}

.batch-table {
    width: 100%;
    min-width: 900px;
    border-collapse: collapse;
}

.batch-table th {
    padding: 10px 9px;
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    color: #475569;
    font-size: 10px;
    font-weight: 700;
    text-align: left;
    white-space: nowrap;
}

.batch-table td {
    padding: 8px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}

.batch-table tr:last-child td {
    border-bottom: none;
}

.batch-row-number {
    width: 35px;
    text-align: center;
    color: #64748b;
    font-size: 10px;
    font-weight: 700;
}

.batch-input {
    width: 100%;
    height: 36px;
    padding: 0 9px;
    border: 1px solid #d1d5db;
    border-radius: 7px;
    outline: none;
    background: #ffffff;
    color: #374151;
    font-family: inherit;
    font-size: 10px;
    box-sizing: border-box;
}

.batch-input:focus {
    border-color: #079bd8;
    box-shadow: 0 0 0 3px rgba(7, 155, 216, 0.08);
}

.batch-file {
    padding: 6px;
}

.batch-delete {
    width: 30px;
    height: 30px;
    border: none;
    border-radius: 7px;
    background: #fee2e2;
    color: #dc2626;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.batch-delete:hover {
    background: #fecaca;
}

.batch-add-row {
    margin-top: 12px;
    height: 36px;
    padding: 0 13px;
    border: 1px dashed #93c5fd;
    border-radius: 8px;
    background: #eff6ff;
    color: #075985;
    font-size: 10px;
    font-weight: 700;
    cursor: pointer;
}

.batch-add-row:hover {
    background: #dbeafe;
}


/* =========================================================
   EDIT FORM
========================================================= */

.edit-form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px 16px;
}

.edit-form-group {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.edit-form-group.full {
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

.data-file-input {
    padding: 7px 9px;
}

.data-form-help {
    margin-top: 5px;
    color: #9ca3af;
    font-size: 9px;
    line-height: 1.5;
}

.metadata-note {
    padding: 10px 12px;
    margin-bottom: 16px;
    border: 1px solid #dbeafe;
    background: #eff6ff;
    border-radius: 8px;
    color: #1e40af;
    font-size: 10px;
    line-height: 1.5;
}

.data-current-file {
    display: none;
    margin-top: 8px;
    padding: 8px 10px;
    background: #f8fafc;
    border-radius: 7px;
    color: #64748b;
    font-size: 10px;
}

.data-current-file a {
    color: #0369a1;
    font-weight: 600;
    text-decoration: none;
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
    position: relative;
    z-index: 2;
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

.data-modal-save:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}


/* =========================================================
   COMMENT MODAL
========================================================= */

.data-comment-modal {
    width: min(500px, 100%);
}

.data-comment-box {
    padding: 20px 21px;
    color: #475569;
    font-size: 12px;
    line-height: 1.6;
    word-break: break-word;
}

.data-comment-box i {
    color: #075985;
    margin-right: 6px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1200px) {

    .data-toolbar {
        flex-wrap: wrap;
    }

    .data-toolbar-left {
        width: 100%;
        flex-basis: 100%;
    }

    .data-toolbar-right {
        width: 100%;
        justify-content: flex-end;
    }
}

@media (max-width: 800px) {

    .data-stats {
        grid-template-columns: repeat(2, 1fr);
    }

    .data-toolbar-right {
        justify-content: flex-start;
        flex-wrap: wrap;
    }
}

@media (max-width: 600px) {

    .data-stats {
        grid-template-columns: 1fr;
    }

    .edit-form-grid {
        grid-template-columns: 1fr;
    }

    .edit-form-group.full {
        grid-column: auto;
    }

    .data-modal-overlay {
        padding: 10px;
        align-items: center;
    }

    .data-modal {
        width: 100%;
        height: 95vh;
        max-height: 95vh;
        border-radius: 12px;
    }

    .data-modal-header {
        padding: 15px;
    }

    .data-modal-body {
        padding: 16px;
    }

    .data-modal-footer {
        padding: 12px 16px;
    }

    .data-table-footer {
        flex-direction: column;
        align-items: flex-start;
    }

}
</style>


<div class="data-page">

    {{-- HEADER --}}

    <div class="data-header">

        <div>

            <h1 class="data-title">
                Data
            </h1>

            <p class="data-subtitle">
                Kelola dataset dan metadata yang tersimpan dalam inventory.
            </p>

        </div>

    </div>


    {{-- =====================================================
         ALERT SUCCESS
    ====================================================== --}}

    @if(session('success'))

        <div class="data-alert data-alert-success">

            <i class="bi bi-check-circle-fill"></i>

            {{ session('success') }}

        </div>

    @endif


    {{-- =====================================================
         ALERT ERROR
    ====================================================== --}}

    @if(session('error'))

        <div class="data-alert data-alert-error">

            <i class="bi bi-exclamation-circle-fill"></i>

            {{ session('error') }}

        </div>

    @endif


    {{-- =====================================================
         VALIDATION ERROR
    ====================================================== --}}

    @if($errors->any())

        <div class="data-alert data-alert-error">

            <div>

                <strong>
                    Data gagal disimpan.
                </strong>

                <ul>

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

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
                    Total Dataset
                </span>

                <span class="data-stat-value">
                    {{ $totalData ?? 0 }}
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
                    {{ $totalDisetujui ?? 0 }}
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
                    {{ $totalPending ?? 0 }}
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

        {{-- =================================================
             TOOLBAR
        ================================================== --}}

        <div class="data-toolbar">

            <div class="data-toolbar-left">

                <span class="data-toolbar-title">
                    Daftar Dataset
                </span>

            </div>


            <div class="data-toolbar-right">

                {{-- SEARCH --}}

                <form
                    method="GET"
                    action="{{ route('data.index') }}"
                    class="data-search"
                >

                    <input
                        type="hidden"
                        name="jenis_data"
                        value="{{ request('jenis_data') }}"
                    >

                    <input
                        type="hidden"
                        name="tahun"
                        value="{{ request('tahun') }}"
                    >

                    <input
                        type="hidden"
                        name="verifikasi"
                        value="{{ request('verifikasi') }}"
                    >

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari data..."
                        autocomplete="off"
                    >

                </form>


                {{-- FILTER --}}

                <div class="data-filter-wrap">

                    <button
                        type="button"
                        class="data-button data-button-secondary"
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
                                    Topik
                                </label>

                                <select name="topik">

                                    <option value="">
                                        Semua Topik
                                    </option>

                                    @foreach(($topikData ?? collect()) as $topik)

                                        <option
                                            value="{{ $topik }}"
                                            {{ request('topik') === $topik ? 'selected' : '' }}
                                        >
                                            {{ $topik }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="data-filter-group">

                                <label class="data-filter-label">
                                    Tahun
                                </label>

                                <select name="tahun">

                                    <option value="">
                                        Semua Tahun
                                    </option>

                                    @foreach(($tahunData ?? []) as $tahun)

                                        <option
                                            value="{{ $tahun }}"
                                            {{ request('tahun') == $tahun ? 'selected' : '' }}
                                        >
                                            {{ $tahun }}
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
                                        {{ strtolower(request('verifikasi')) == 'menunggu' ? 'selected' : '' }}
                                    >
                                        Menunggu Disetujui
                                    </option>

                                    <option
                                        value="menunggu disetujui"
                                        {{ strtolower(request('verifikasi')) == 'menunggu disetujui' ? 'selected' : '' }}
                                    >
                                        Menunggu Disetujui
                                    </option>

                                    <option
                                        value="disetujui"
                                        {{ strtolower(request('verifikasi')) == 'disetujui' ? 'selected' : '' }}
                                    >
                                        Disetujui
                                    </option>

                                    <option
                                        value="ditolak"
                                        {{ strtolower(request('verifikasi')) == 'ditolak' ? 'selected' : '' }}
                                    >
                                        Ditolak
                                    </option>

                                </select>

                            </div>


                            <div class="data-filter-actions">

                                <button
                                    type="button"
                                    class="data-filter-action"
                                    onclick="resetDataFilter()"
                                >
                                    Reset
                                </button>

                                <button
                                    type="submit"
                                    class="data-filter-action"
                                >
                                    Terapkan
                                </button>

                            </div>

                        </form>

                    </div>

                </div>


                {{-- TAMBAH DATA --}}

                <button
                    type="button"
                    class="data-button data-button-secondary"
                    onclick="openImportModal()"
                >
                    <i class="bi bi-file-earmark-excel"></i>
                    Import Excel
                </button>


                {{-- TAMBAH MANUAL --}}

                <button
                    type="button"
                    class="data-button data-button-primary"
                    onclick="openAddModal()"
                >

                    <i class="bi bi-plus-lg"></i>

                    Tambah Data

                </button>

            </div>

        </div>


        {{-- =====================================================
             TABLE
        ====================================================== --}}

        <div class="data-table-wrapper">

            @if($data->count() > 0)

                <table class="data-table">

                    <thead>

                        <tr>
                            <th>No</th>
                            <th>ID</th>
                            <th>Nama Dataset</th>
                            <th>Topik</th>
                            <th>Tahun</th>
                            <th>File</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Verifikasi</th>
                            <th>Komentar</th>
                            <th>Aksi</th>
                        </tr>

                    </thead>


                    <tbody>

                        @foreach($data as $row)

                            @php

                                $verifikasi = strtolower(
                                    trim($row->verifikasi ?? 'menunggu')
                                );

                                $verificationClass = match($verifikasi) {

                                    'disetujui' =>
                                        'approved',

                                    'ditolak' =>
                                        'rejected',

                                    'menunggu',
                                    'menunggu disetujui' =>
                                        'pending',

                                    default =>
                                        'pending',

                                };

                                $verificationLabel = match($verifikasi) {

                                    'disetujui' => 'Disetujui',

                                    'ditolak' => 'Ditolak',

                                    'menunggu disetujui' =>
                                        'Menunggu Disetujui',

                                    default => 'Menunggu',

                                };

                            @endphp


                            <tr>

                                <td>
                                    {{ $data->firstItem() + $loop->index }}
                                </td>


                                <td>

                                    <span class="data-id">

                                        DS-{{
                                            str_pad(
                                                $row->id,
                                                5,
                                                '0',
                                                STR_PAD_LEFT
                                            )
                                        }}

                                    </span>

                                </td>


                                <td>

                                    <span class="data-name">

                                        {{ $row->nama_dataset }}

                                    </span>

                                </td>


                                <td>

                                    <span class="data-category-badge">

                                        {{ $row->jenis_data ?: '-' }}

                                    </span>

                                </td>


                                <td>

                                    <span class="data-year">

                                        {{ $row->tahun ?: '-' }}

                                    </span>

                                </td>


                                <td>

                                    @if($row->file_data)

                                        <a
                                            href="{{ asset('storage/' . $row->file_data) }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="data-file"
                                        >

                                            <i class="bi bi-file-earmark-text-fill"></i>

                                            {{ basename($row->file_data) }}

                                        </a>

                                    @else

                                        <span class="data-no-file">
                                            Manual
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <span class="data-date">

                                        @if($row->tanggal_pengajuan)

                                            {{
                                                \Carbon\Carbon::parse(
                                                    $row->tanggal_pengajuan
                                                )->format('d/m/Y H:i')
                                            }}

                                        @else
                                            -
                                        @endif

                                    </span>

                                </td>


                                <td>

                                    <span
                                        class="data-verification {{ $verificationClass }}"
                                    >

                                        {{ $verificationLabel }}

                                    </span>

                                </td>


                                <td>

                                    @if(!empty($row->komentar_verifikasi))

                                        <div
                                            class="data-comment"
                                            title="{{ $row->komentar_verifikasi }}"
                                        >

                                            <span class="data-comment-text">

                                                {{
                                                    $row->komentar_verifikasi
                                                }}

                                            </span>

                                        </div>

                                    @else

                                        <span class="data-comment-empty">
                                            -
                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <div class="data-action-buttons">

                                        {{-- EDIT --}}

                                        <button
                                            type="button"
                                            class="data-action-button data-edit-button"
                                            title="Edit"
                                            onclick="openEditModal({{ $row->id }})"
                                        >

                                            <i class="bi bi-pencil-fill"></i>

                                        </button>


                                        {{-- DELETE --}}

                                        <form
                                            action="{{ route('data.destroy', $row->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin mengajukan penghapusan dataset ini?');"
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

                        @if(
                            request('search')
                            || request('jenis_data')
                            || request('tahun')
                            || request('verifikasi')
                        )

                            Data tidak ditemukan

                        @else

                            Belum ada data

                        @endif

                    </h3>


                    <p>

                        @if(
                            request('search')
                            || request('jenis_data')
                            || request('tahun')
                            || request('verifikasi')
                        )

                            Coba ubah kata pencarian atau filter.

                        @else

                            Belum ada dataset yang tersimpan.

                        @endif

                    </p>

                </div>

            @endif

        </div>


        {{-- =====================================================
             FOOTER
        ====================================================== --}}

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
                            href="{{ $data->appends(request()->query())->previousPageUrl() }}"
                            class="data-page-link"
                        >

                            <i class="bi bi-chevron-left"></i>

                        </a>

                    @endif


                    @foreach(
                        $data->getUrlRange(
                            max(1, $data->currentPage() - 2),
                            min($data->lastPage(), $data->currentPage() + 2)
                        )
                        as $page => $url
                    )

                        <a
                            href="{{ $url }}"
                            class="data-page-link {{ $page == $data->currentPage() ? 'active' : '' }}"
                        >

                            {{ $page }}

                        </a>

                    @endforeach


                    @if($data->hasMorePages())

                        <a
                            href="{{ $data->appends(request()->query())->nextPageUrl() }}"
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
     MODAL TAMBAH / EDIT
========================================================= --}}

<div
    id="dataModal"
    class="data-modal-overlay"
    aria-hidden="true"
>

    <div class="data-modal">

        <div class="data-modal-header">

            <div class="data-modal-header-left">

                <div class="data-modal-icon">

                    <i
                        id="dataModalIcon"
                        class="bi bi-database-fill"
                    ></i>

                </div>

                <div>

                    <h2 id="dataModalTitle" class="data-modal-title">
                        Tambah Data
                    </h2>

                    <p
                        id="dataModalSubtitle"
                        class="data-modal-subtitle"
                    >
                        Tambahkan beberapa dataset sekaligus ke dalam sistem.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="data-modal-close"
                onclick="closeModal('dataModal')"
            >

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        {{-- =================================================
             FORM
        ================================================== --}}

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


            <div class="data-modal-body">

                {{-- =================================================
                     TAMBAH BATCH
                ================================================== --}}

                <div id="batchFormContainer">

                    <div class="batch-info">

                        <i class="bi bi-info-circle-fill"></i>

                        Kamu dapat menambahkan beberapa dataset sekaligus.
                        Setiap baris merupakan satu dataset dan setiap dataset
                        akan mendapatkan ID serta proses verifikasi masing-masing.

                    </div>


                    <div class="batch-table-wrapper">

                        <table class="batch-table">

                            <thead>

                                <tr>

                                    <th style="width:40px;">
                                        No
                                    </th>

                                    <th style="width:27%;">
                                        Nama Dataset
                                    </th>

                                    <th style="width:20%;">
                                        Jenis Data
                                    </th>

                                    <th style="width:100px;">
                                        Tahun
                                    </th>

                                    <th style="width:30%;">
                                        File Data
                                    </th>

                                    <th style="width:45px;">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody id="batchRows">

                            </tbody>

                        </table>

                    </div>


                    <button
                        type="button"
                        class="batch-add-row"
                        onclick="addBatchRow()"
                    >

                        <i class="bi bi-plus-lg"></i>

                        Tambah Baris

                    </button>

                </div>


                {{-- =================================================
                     EDIT FORM
                ================================================== --}}

                <div
                    id="editFormContainer"
                    style="display:none;"
                >

                    <div class="edit-form-grid">

                        {{-- NAMA DATASET --}}

                        <div class="edit-form-group full">

                            <label class="data-form-label">

                                Nama Dataset

                                <span>*</span>

                            </label>

                            <input
                                type="text"
                                id="edit_nama_dataset"
                                class="data-form-control"
                                placeholder="Contoh: Data Penduduk"
                            >

                        </div>


                        {{-- JENIS DATA --}}

                        <div class="edit-form-group">

                            <label class="data-form-label">

                                Jenis Data

                                <span>*</span>

                            </label>

                            <input
                                type="text"
                                id="edit_jenis_data"
                                class="data-form-control"
                                placeholder="Contoh: Kependudukan"
                            >

                        </div>


                        {{-- TAHUN --}}

                        <div class="edit-form-group">

                            <label class="data-form-label">

                                Tahun

                                <span>*</span>

                            </label>

                            <input
                                type="number"
                                id="edit_tahun"
                                class="data-form-control"
                                min="1900"
                                max="2100"
                                placeholder="Contoh: 2026"
                            >

                        </div>


                        {{-- FILE --}}

                        <div class="edit-form-group full">

                            <label class="data-form-label">

                                File Data

                            </label>

                            <input
                                type="file"
                                id="edit_file_data"
                                class="data-form-control data-file-input"
                                accept=".csv,.xls,.xlsx,.pdf,.zip"
                            >

                            <small class="data-form-help">

                                Kosongkan jika tidak ingin mengganti file.

                            </small>


                            <div
                                id="dataCurrentFile"
                                class="data-current-file"
                            >

                                <i class="bi bi-file-earmark"></i>

                                File saat ini:

                                <a
                                    id="dataCurrentFileLink"
                                    href="#"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    Lihat File
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="data-modal-footer">

                <button
                    type="button"
                    class="data-modal-cancel"
                    onclick="closeModal('dataModal')"
                >

                    Batal

                </button>

                <button
                    type="submit"
                    id="dataSaveButton"
                    class="data-modal-save"
                >

                    <i class="bi bi-check-lg"></i>

                    Simpan Semua Data

                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     MODAL IMPORT EXCEL
========================================================= --}}

<div
    id="commentModal"
    class="data-modal-overlay"
    aria-hidden="true"
>

    <div
        class="data-modal data-comment-modal"
        onclick="event.stopPropagation()"
    >

        <div class="data-modal-header">

            <div class="data-modal-header-left">

                <div class="data-modal-icon">

                    <i class="bi bi-chat-left-text"></i>

                </div>

                <div>

                    <h2 class="data-modal-title">
                        Komentar Verifikator
                    </h2>

                    <p class="data-modal-subtitle">
                        Catatan dari proses verifikasi data.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="data-modal-close"
                onclick="closeCommentModal()"
            >

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        <div class="data-comment-box">

            <i class="bi bi-chat-left-text-fill"></i>

            <span id="commentText"></span>

                <div class="metadata-note">

                    Gunakan template Excel.
                    Sheet pertama bernama
                    <strong>Metadata</strong>
                    dan sheet kedua bernama
                    <strong>Dataset</strong>.

                    Metadata akan dibaca otomatis dari Sheet Metadata.

                </div>


        <div class="data-modal-footer">

            <button
                type="button"
                class="data-modal-cancel"
                onclick="closeCommentModal()"
            >

                        <label class="data-form-label">
                            Nama Dataset <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="nama_dataset"
                            class="data-form-control"
                            placeholder="Contoh: Data Penduduk Kota Bekasi"
                            required
                        >

                    </div>

    </div>

</div>


<script>

/* =========================================================
   DATA RECORDS
========================================================= */

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
        document.getElementById(
            'dataFilterDropdown'
        );

    if (!dropdown) {
        return;
    }

    dropdown.classList.toggle(
        'show'
    );
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
   BATCH ROW
========================================================= */

let batchRowNumber = 0;


function addBatchRow(
    nama = '',
    jenis = '',
    tahun = ''
)
{
    batchRowNumber++;

    const tbody =
        document.getElementById('batchRows');

    if (!tbody) {
        return;
    }

    const row =
        document.createElement('tr');

    row.className =
        'batch-data-row';


    row.innerHTML = `

        <td class="batch-row-number">
            ${batchRowNumber}
        </td>

        <td>

            <input
                type="text"
                name="nama_dataset[]"
                class="batch-input"
                placeholder="Nama dataset"
                value="${escapeHtml(nama)}"
                required
            >

        </td>

        <td>

            <input
                type="text"
                name="jenis_data[]"
                class="batch-input"
                placeholder="Jenis data"
                value="${escapeHtml(jenis)}"
                required
            >

        </td>

        <td>

            <input
                type="number"
                name="tahun[]"
                class="batch-input"
                min="1900"
                max="2100"
                placeholder="2026"
                value="${escapeHtml(tahun)}"
                required
            >

        </td>

        <td>

            <input
                type="file"
                name="file_data[]"
                class="batch-input batch-file"
                accept=".csv,.xls,.xlsx,.pdf,.zip"
                required
            >

            <div
                style="
                    margin-top:4px;
                    color:#9ca3af;
                    font-size:8px;
                "
            >
                CSV, XLS, XLSX, PDF, ZIP. Maks. 10 MB.
            </div>

        </td>

        <td style="text-align:center;">

            <button
                type="button"
                class="batch-delete"
                title="Hapus baris"
                onclick="removeBatchRow(this)"
            >

                <i class="bi bi-trash-fill"></i>

            </button>

        </td>

    `;


    tbody.appendChild(row);

    updateBatchNumbers();
}


function removeBatchRow(button)
{
    const row =
        button.closest('.batch-data-row');

    if (!row) {
        return;
    }

    const tbody =
        document.getElementById('batchRows');


    if (
        tbody &&
        tbody.querySelectorAll('.batch-data-row').length <= 1
    ) {

        alert(
            'Minimal harus ada satu dataset.'
        );

        return;
    }


    row.remove();

    updateBatchNumbers();
}


function updateBatchNumbers()
{
    const rows =
        document.querySelectorAll(
            '#batchRows .batch-data-row'
        );


    rows.forEach(function(row, index)
    {

        const number =
            row.querySelector(
                '.batch-row-number'
            );

        if (number) {

            number.textContent =
                index + 1;

        }

    });
}


function escapeHtml(value)
{
    if (value === null || value === undefined) {
        return '';
    }

    return String(value)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}


/* =========================================================
   REMOVE EDIT NAME
   MODE TAMBAH
========================================================= */

function disableEditFields()
{
    const nama =
        document.getElementById('edit_nama_dataset');

    const jenis =
        document.getElementById('edit_jenis_data');

    const tahun =
        document.getElementById('edit_tahun');

    const file =
        document.getElementById('edit_file_data');


    if (nama) {
        nama.removeAttribute('name');
        nama.disabled = true;
    }

    if (jenis) {
        jenis.removeAttribute('name');
        jenis.disabled = true;
    }

    if (tahun) {
        tahun.removeAttribute('name');
        tahun.disabled = true;
    }

    if (file) {
        file.removeAttribute('name');
        file.disabled = true;
    }
}


/* =========================================================
   ENABLE EDIT FIELDS
   MODE EDIT
========================================================= */

function enableEditFields()
{
    const nama =
        document.getElementById('edit_nama_dataset');

    const jenis =
        document.getElementById('edit_jenis_data');

    const tahun =
        document.getElementById('edit_tahun');

    const file =
        document.getElementById('edit_file_data');


    if (nama) {
        nama.setAttribute(
            'name',
            'nama_dataset'
        );

        nama.disabled = false;
    }

    if (jenis) {
        jenis.setAttribute(
            'name',
            'jenis_data'
        );

        jenis.disabled = false;
    }

    if (tahun) {
        tahun.setAttribute(
            'name',
            'tahun'
        );

        tahun.disabled = false;
    }

    if (file) {
        file.setAttribute(
            'name',
            'file_data'
        );

        file.disabled = false;
    }
}


/* =========================================================
   OPEN ADD
========================================================= */

function openAddModal()
{
    const modal = document.getElementById('dataModal');
    const form = document.getElementById('dataForm');

    if (!modal || !form) {
        console.error('Modal/form Data tidak ditemukan.');
        return;
    }

    form.reset();

    form.action = "{{ route('data.store') }}";
    document.getElementById('dataMethod').value = 'POST';

    const title = document.getElementById('dataModalTitle');
    const subtitle = document.getElementById('dataModalSubtitle');
    const saveButton = document.getElementById('dataSaveButton');

    if (title) {
        title.textContent = 'Tambah Data';
    }

    if (subtitle) {
        subtitle.textContent =
            'Tambahkan beberapa dataset sekaligus ke dalam sistem.';
    }

    if (saveButton) {
        saveButton.innerHTML =
            '<i class="bi bi-check-lg"></i> Simpan Semua Data';
        saveButton.disabled = false;
    }

    document.getElementById('batchFormContainer').style.display = 'block';
    document.getElementById('editFormContainer').style.display = 'none';

    const tbody = document.getElementById('batchRows');

    if (tbody) {
        tbody.innerHTML = '';
    }

    batchRowNumber = 0;
    addBatchRow();

    disableEditFields();

    modal.classList.add('show');
    modal.setAttribute('aria-hidden', 'false');
    document.body.classList.add('data-modal-open');
}

/*
|--------------------------------------------------------------------------
| BACKWARD COMPATIBILITY
|--------------------------------------------------------------------------
| Kalau ada bagian lain yang masih memanggil openModal(), arahkan ke
| fungsi yang sesuai.
*/
function openModal(id)
{
    if (id === 'addModal' || id === 'dataModal') {
        openAddModal();
        return;
    }

    if (id === 'editModal') {
        return;
    }

    const modal = document.getElementById(id);

    if (modal) {
        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('data-modal-open');
    }
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


    /*
    |----------------------------------------------------------------------
    | MODE EDIT
    |----------------------------------------------------------------------
    */

    enableEditFields();


    /*
    |----------------------------------------------------------------------
    | ACTION
    |----------------------------------------------------------------------
    */

    form.action =
        "{{ url('/data') }}/" + id;


    document.getElementById(
        'dataMethod'
    ).value =
        'PUT';


    /*
    |----------------------------------------------------------------------
    | TITLE
    |----------------------------------------------------------------------
    */

    document.getElementById(
        'dataModalTitle'
    ).textContent =
        'Edit Data';


    document.getElementById(
        'dataModalSubtitle'
    ).textContent =
        'Perbarui dataset yang dipilih.';


    document.getElementById(
        'dataSaveButton'
    ).innerHTML =
        '<i class="bi bi-check-lg"></i> Simpan Perubahan';


    /*
    |----------------------------------------------------------------------
    | HIDE BATCH
    |----------------------------------------------------------------------
    */

    document.getElementById(
        'batchFormContainer'
    ).style.display =
        'none';


    /*
    |----------------------------------------------------------------------
    | SHOW EDIT
    |----------------------------------------------------------------------
    */

    document.getElementById(
        'editFormContainer'
    ).style.display =
        'block';


    /*
    |----------------------------------------------------------------------
    | DATA
    |----------------------------------------------------------------------
    */

    document.getElementById(
        'edit_nama_dataset'
    ).value =
        data.nama_dataset ?? '';


    document.getElementById(
        'edit_jenis_data'
    ).value =
        data.jenis_data ?? '';


    document.getElementById(
        'edit_tahun'
    ).value =
        data.tahun ?? '';


    /*
    |----------------------------------------------------------------------
    | FILE
    |----------------------------------------------------------------------
    */

    const fileInput =
        document.getElementById(
            'edit_file_data'
        );

    if (fileInput) {

        fileInput.value = '';

    }


    const currentFile =
        document.getElementById(
            'dataCurrentFile'
        );

    const currentFileLink =
        document.getElementById(
            'dataCurrentFileLink'
        );


    if (
        currentFile &&
        currentFileLink &&
        data.file_data
    ) {

        currentFileLink.href =
            "{{ asset('storage') }}/" +
            data.file_data;

        currentFile.style.display =
            'block';

    } else if (currentFile) {

        currentFile.style.display =
            'none';

    }


    /*
    |----------------------------------------------------------------------
    | SHOW MODAL
    |----------------------------------------------------------------------
    */

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
   CLOSE DATA MODAL
========================================================= */

function closeDataModal()
{
    closeModal('dataModal');
}


function closeModal(id)
{
    const modal = document.getElementById(id);

    if (!modal) {
        return;
    }

    modal.classList.remove('show');
    modal.setAttribute('aria-hidden', 'true');

    const anotherOpenModal = document.querySelector(
        '.data-modal-overlay.show'
    );

    if (!anotherOpenModal) {
        document.body.classList.remove('data-modal-open');
    }
}


/* =========================================================
   COMMENT
========================================================= */

function showComment(comment)
{
    const modal =
        document.getElementById('commentModal');

    const text =
        document.getElementById('commentText');

    if (!modal || !text) {
        return;
    }

    text.textContent =
        comment || 'Tidak ada komentar.';

    modal.classList.add('show');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.classList.add(
        'data-modal-open'
    );
}


function closeCommentModal()
{
    const modal =
        document.getElementById('commentModal');

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

document
    .getElementById('dataModal')
    ?.addEventListener(
        'click',
        function(event)
        {
            if (event.target === this) {

                closeDataModal();

            }
        }
    );


document
    .getElementById('commentModal')
    ?.addEventListener(
        'click',
        function(event)
        {
            if (event.target === this) {

                closeCommentModal();

            }
        }
    );


/* =========================================================
   IMPORT
========================================================= */

function openImportModal()
{
    alert('Form Import Excel belum tersedia pada view Data ini.');
}


/* =========================================================
   EDIT
========================================================= */

function openEditModal(id)
{
    openEditDataModal(id);
}


/* =========================================================
   CLICK OUTSIDE FILTER
=========================================================


========================================================= */

document.addEventListener(
    'keydown',
    function(event)
    {
        if (event.key !== 'Escape') {
            return;
        }


        const dataModal =
            document.getElementById('dataModal');

        const commentModal =
            document.getElementById('commentModal');


        if (
            dataModal &&
            dataModal.classList.contains('show')
        ) {

            closeDataModal();

        }


        if (
            commentModal &&
            commentModal.classList.contains('show')
        ) {

            closeCommentModal();

        }
    }
);


/* =========================================================
   VALIDATION ERROR
========================================================= */

@if($errors->any())

document.addEventListener(
    'DOMContentLoaded',
    function()
    {
        /*
        |--------------------------------------------------------------
        | BUKA MODAL DALAM MODE TAMBAH
        |--------------------------------------------------------------
        */

        openAddModal();

    }
);

@endif


/* =========================================================
   PREVENT DOUBLE SUBMIT
========================================================= */

document
    .getElementById('dataForm')
    ?.addEventListener(
        'submit',
        function()
        {
            const button =
                document.getElementById(
                    'dataSaveButton'
                );

            if (!button) {
                return;
            }


            button.disabled = true;

            button.innerHTML =
                '<i class="bi bi-hourglass-split"></i> Menyimpan...';
        }
    );

</script>

@endsection
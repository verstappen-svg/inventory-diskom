@extends('layouts.app')

@section('title', 'Data Center')
@section('page-title', 'Data Center')

@section('content')

{{-- =========================================================
NOTIFIKASI
========================================================= --}}

@if(session('success')) <div class="alert alert-success" style="
     margin-bottom: 20px;
     padding: 14px 18px;
     border-radius: 10px;
     background: #d1fae5;
     color: #065f46;
     border: 1px solid #a7f3d0;
 "> <strong>Berhasil!</strong>
{{ session('success') }} </div>
@endif

@if(session('error')) <div class="alert alert-danger" style="
     margin-bottom: 20px;
     padding: 14px 18px;
     border-radius: 10px;
     background: #fee2e2;
     color: #991b1b;
     border: 1px solid #fecaca;
 "> <strong>Import Excel gagal.</strong>

    <div style="margin-top: 8px; white-space: pre-line;">
        {{ session('error') }}
    </div>
</div>

@endif

<style>

/* =========================================================
   DATA CENTER PAGE
========================================================= */

.dc-page {
    width: 100%;
}


/* =========================================================
   HEADER
========================================================= */

.dc-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    margin-bottom: 24px;
}

.dc-heading h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
}

.dc-heading p {
    margin: 6px 0 0;
    font-size: 13px;
    color: #6b7280;
}


/* =========================================================
   BUTTON
========================================================= */

.add-dc-button,
.import-dc-button,
.download-dc-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;

    height: 38px;
    padding: 0 15px;

    border-radius: 8px;

    font-size: 12px;
    font-weight: 600;

    cursor: pointer;
    white-space: nowrap;

    transition: 0.2s ease;
}


/* =========================================================
   TAMBAH DATA CENTER
========================================================= */

.add-dc-button {
    border: none;
    background: #071b88;
    color: #ffffff;

    box-shadow:
        0 2px 5px rgba(37, 99, 235, 0.18);
}

.add-dc-button:hover {
    background: #050f63;
    transform: translateY(-1px);
}

.add-dc-button i {
    font-size: 13px;
}


/* =========================================================
   IMPORT EXCEL
========================================================= */

.import-dc-button {
    border: 1px solid #d1d5db;
    background: #ffffff;
    color: #374151;
}

.import-dc-button:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    color: #075985;
    transform: translateY(-1px);
}

.import-dc-button i {
    font-size: 14px;
}


/* =========================================================
   DOWNLOAD TEMPLATE
========================================================= */

.download-dc-button {
    border: 1px solid #bbf7d0;
    background: #f0fdf4;
    color: #15803d;

    text-decoration: none;
}

.download-dc-button:hover {
    background: #dcfce7;
    border-color: #86efac;
    color: #166534;
    transform: translateY(-1px);
}

.download-dc-button i {
    font-size: 14px;
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

.alert-error ul {
    margin: 5px 0 0 18px;
    padding: 0;
}


/* =========================================================
   STATISTICS
========================================================= */

.dc-stats {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: 18px;

    margin-bottom: 25px;
}

.dc-stat-card {
    width: 100%;
    min-height: 125px;

    box-sizing: border-box;

    background: #ffffff;

    border: 1px solid #e5e7eb;
    border-radius: 14px;

    padding: 20px;

    display: flex;
    align-items: flex-start;

    gap: 15px;

    box-shadow:
        0 2px 6px rgba(0, 0, 0, 0.05);
}

.dc-stat-icon {
    width: 45px;
    height: 45px;

    flex-shrink: 0;

    border-radius: 12px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 20px;
}

.dc-stat-icon.blue {
    background: #e0f2fe;
    color: #0284c7;
}

.dc-stat-icon.orange {
    background: #ffedd5;
    color: #ea580c;
}

.dc-stat-icon.green {
    background: #dcfce7;
    color: #16a34a;
}

.dc-stat-content {
    display: flex;
    flex-direction: column;
}

.dc-stat-label {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 5px;
}

.dc-stat-value {
    font-size: 23px;
    font-weight: 700;
    color: #075985;
    line-height: 1.2;
}

.dc-stat-description {
    margin-top: 7px;

    font-size: 10px;
    color: #9ca3af;
}


/* =========================================================
   TABLE CARD
========================================================= */

.dc-table-card {
    background: #ffffff;

    border: 1px solid #e5e7eb;
    border-radius: 14px;

    overflow: hidden;

    box-shadow:
        0 2px 7px rgba(0, 0, 0, 0.04);
}


/* =========================================================
   TABLE HEADER
========================================================= */

.dc-table-header {
    padding: 20px 22px;

    display: flex;
    align-items: center;

    gap: 15px;

    border-bottom: 1px solid #e5e7eb;

    flex-wrap: wrap;
}

.dc-table-header-left {
    display: flex;
    align-items: center;

    gap: 8px;

    flex-shrink: 0;
}

.dc-table-title {
    margin: 0;

    font-size: 16px;
    font-weight: 700;

    color: #1f2937;
}

.dc-table-count {
    font-size: 12px;
    color: #6b7280;
}


/* =========================================================
   TABLE HEADER ACTIONS
========================================================= */

.dc-table-header-actions {
    display: flex;

    align-items: center;

    gap: 9px;

    margin-left: auto;

    flex-shrink: 0;
}


/* =========================================================
   TOOLBAR
========================================================= */

.dc-toolbar {
    display: flex;
    align-items: center;

    gap: 9px;

    width: 100%;

    flex-wrap: wrap;

    margin-top: 2px;
}

.dc-search {
    position: relative;
}

.dc-search i {
    position: absolute;

    left: 12px;
    top: 50%;

    transform: translateY(-50%);

    color: #94a3b8;
    font-size: 14px;
}

.dc-search input {
    width: 230px;
    height: 38px;

    padding: 0 12px 0 35px;

    box-sizing: border-box;

    border: 1px solid #d1d5db;
    border-radius: 8px;

    outline: none;

    font-size: 12px;
    color: #374151;

    background: #ffffff;
}

.dc-search input:focus {
    border-color: #079bd8;

    box-shadow:
        0 0 0 3px
        rgba(7, 155, 216, 0.10);
}

.dc-filter-select {
    height: 38px;

    padding: 0 32px 0 12px;

    border: 1px solid #d1d5db;
    border-radius: 8px;

    background: #ffffff;

    color: #374151;

    font-size: 12px;

    outline: none;

    cursor: pointer;
}

.dc-filter-select:focus {
    border-color: #079bd8;

    box-shadow:
        0 0 0 3px
        rgba(7, 155, 216, 0.10);
}


/* =========================================================
   TABLE
========================================================= */

.dc-table-wrapper {
    width: 100%;

    overflow-x: auto;
}

.dc-table {
    width: 100%;

    min-width: 2350px;

    border-collapse: collapse;
}

.dc-table th {
    padding: 14px 16px;

    background: #f8fafc;

    border-bottom: 1px solid #e5e7eb;

    color: #475569;

    font-size: 12px;
    font-weight: 700;

    text-align: left;

    white-space: nowrap;
}

.dc-table td {
    padding: 15px 16px;

    border-bottom: 1px solid #f1f5f9;

    color: #374151;

    font-size: 13px;

    vertical-align: middle;
}

.dc-table tbody tr:hover {
    background: #f8fafc;
}

.dc-table tbody tr:last-child td {
    border-bottom: none;
}


/* =========================================================
   ID
========================================================= */

.dc-code {
    font-weight: 700;

    color: #075985;

    white-space: nowrap;
}


/* =========================================================
   NAME
========================================================= */

.dc-name {
    font-weight: 600;
    color: #1f2937;
}


/* =========================================================
   VALUE
========================================================= */

.dc-value {
    color: #374151;

    white-space: nowrap;
}

.dc-empty-value {
    color: #9ca3af;
}


/* =========================================================
   DESCRIPTION
========================================================= */

.dc-description {
    max-width: 280px;
    min-width: 180px;

    line-height: 1.5;

    color: #475569;

    white-space: normal;

    word-break: break-word;
}


/* =========================================================
   STATUS
========================================================= */

.dc-status-badge {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    padding: 5px 10px;

    border-radius: 20px;

    font-size: 11px;
    font-weight: 600;

    white-space: nowrap;
}

.dc-status-active {
    background: #dcfce7;
    color: #166534;
}

.dc-status-offline {
    background: #fee2e2;
    color: #991b1b;
}


/* =========================================================
   VERIFIKASI
========================================================= */

.dc-verifikasi-badge {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    padding: 5px 10px;

    border-radius: 20px;

    font-size: 11px;
    font-weight: 600;

    white-space: nowrap;
}

.dc-verifikasi-menunggu {
    background: #fef3c7;
    color: #92400e;
}

.dc-verifikasi-disetujui {
    background: #dcfce7;
    color: #166534;
}

.dc-verifikasi-ditolak {
    background: #fee2e2;
    color: #991b1b;
}


/* =========================================================
   KOMENTAR
========================================================= */

.dc-komentar {
    max-width: 260px;

    line-height: 1.5;

    color: #64748b;

    white-space: normal;

    word-break: break-word;
}


/* =========================================================
   ACTION
========================================================= */

.dc-action-buttons {
    display: flex;

    align-items: center;

    gap: 7px;
}

.dc-action-button {
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

.dc-edit-button {
    background: #e0f2fe;
    color: #075985;
}

.dc-edit-button:hover {
    background: #bae6fd;
}

.dc-delete-button {
    background: #fee2e2;
    color: #dc2626;
}

.dc-delete-button:hover {
    background: #fecaca;
}

.dc-action-button i {
    font-size: 14px;
}

.dc-delete-form {
    display: inline;
}


/* =========================================================
   EMPTY
========================================================= */

.dc-empty-state {
    padding: 55px 20px;

    text-align: center;
}

.dc-empty-icon {
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

.dc-empty-icon i {
    font-size: 27px;
}

.dc-empty-state h3 {
    margin: 0 0 6px;

    font-size: 15px;

    color: #374151;
}

.dc-empty-state p {
    margin: 0;

    font-size: 12px;

    color: #9ca3af;
}


/* =========================================================
   GENERAL MODAL
========================================================= */

.dc-modal-overlay {
    position: fixed;

    inset: 0;

    z-index: 9999;

    display: none;

    align-items: center;
    justify-content: center;

    padding: 30px;

    background:
        rgba(15, 23, 42, 0.55);

    overflow-y: auto;
}

.dc-modal-overlay.show {
    display: flex;
}

.dc-modal {
    width: 100%;
    max-width: 1100px;

    max-height:
        calc(100vh - 60px);

    background: #ffffff;

    border-radius: 16px;

    box-shadow:
        0 25px 60px
        rgba(15, 23, 42, 0.25);

    overflow: hidden;

    display: flex;

    flex-direction: column;
}


/* =========================================================
   GENERAL MODAL HEADER
========================================================= */

.dc-modal-header {
    min-height: 78px;

    padding: 18px 22px;

    display: flex;

    align-items: center;
    justify-content: space-between;

    border-bottom:
        1px solid #e5e7eb;
}

.dc-modal-header-left {
    display: flex;

    align-items: center;

    gap: 12px;
}

.dc-modal-icon {
    width: 40px;
    height: 40px;

    border-radius: 10px;

    display: flex;

    align-items: center;
    justify-content: center;

    background: #e0f2fe;

    color: #075985;
}

.dc-modal-icon i {
    font-size: 17px;
}

.dc-modal-header-text h2 {
    margin: 0;

    font-size: 17px;
    font-weight: 700;

    color: #1f2937;
}

.dc-modal-header-text p {
    margin: 4px 0 0;

    font-size: 11px;

    color: #6b7280;
}

.dc-modal-close {
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

.dc-modal-close:hover {
    background: #e2e8f0;
}


/* =========================================================
   FORM
========================================================= */

#dataCenterForm {
    display: flex;

    flex-direction: column;

    min-height: 0;
}

.dc-modal-body {
    flex: 1 1 auto;

    min-height: 0;

    overflow-y: auto;
    overflow-x: hidden;

    padding: 24px;
}

.dc-modal-body::-webkit-scrollbar {
    width: 8px;
}

.dc-modal-body::-webkit-scrollbar-track {
    background: #f1f5f9;
}

.dc-modal-body::-webkit-scrollbar-thumb {
    background: #cbd5e1;

    border-radius: 10px;
}

.dc-modal-body::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}


/* =========================================================
   FORM CARD
========================================================= */

.dc-form-card {
    background: #ffffff;

    border: 1px solid #e5e7eb;

    border-radius: 14px;

    padding: 24px;
}

.dc-section {
    margin-bottom: 28px;
}

.dc-section:last-child {
    margin-bottom: 0;
}

.dc-section-header {
    display: flex;

    align-items: center;

    gap: 9px;

    padding-bottom: 13px;

    margin-bottom: 20px;

    border-bottom:
        1px solid #e5e7eb;
}

.dc-section-header i {
    color: #075985;

    font-size: 16px;
}

.dc-section-header h3 {
    margin: 0;

    font-size: 14px;
    font-weight: 700;

    color: #1f2937;
}

.dc-form-grid {
    display: grid;

    grid-template-columns:
        repeat(2, minmax(0, 1fr));

    gap: 18px;
}

.dc-form-group {
    display: flex;

    flex-direction: column;

    min-width: 0;
}

.dc-form-group.full {
    grid-column: 1 / -1;
}

.dc-form-label {
    margin-bottom: 7px;

    font-size: 12px;

    font-weight: 600;

    color: #374151;
}

.dc-required {
    color: #dc2626;
}

.dc-form-control {
    width: 100%;

    box-sizing: border-box;

    height: 40px;

    padding: 0 12px;

    border:
        1px solid #d1d5db;

    border-radius: 8px;

    background: #ffffff;

    color: #374151;

    outline: none;

    font-family: inherit;

    font-size: 12px;
}

textarea.dc-form-control {
    min-height: 90px;

    height: auto;

    padding: 10px 12px;

    resize: vertical;
}

.dc-form-control:focus {
    border-color: #079bd8;

    box-shadow:
        0 0 0 3px
        rgba(7, 155, 216, 0.10);
}

.dc-form-control[readonly] {
    background: #f8fafc;

    color: #64748b;

    cursor: not-allowed;
}

.dc-help {
    margin-top: 6px;

    font-size: 10px;

    line-height: 1.5;

    color: #9ca3af;
}

.dc-form-error {
    margin-top: 5px;

    font-size: 10px;

    color: #dc2626;
}


/* =========================================================
   FORM FOOTER
========================================================= */

.dc-modal-footer {
    flex-shrink: 0;

    display: flex;

    justify-content: space-between;

    align-items: center;

    gap: 15px;

    padding: 16px 24px;

    border-top:
        1px solid #e5e7eb;

    background: #ffffff;
}


/* =========================================================
   FOOTER LEFT — EXCEL
========================================================= */

.dc-footer-left {
    display: flex;

    align-items: center;

    gap: 9px;
}


/* =========================================================
   FOOTER RIGHT — FORM ACTION
========================================================= */

.dc-footer-right {
    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 10px;
}


/* =========================================================
   BUTTON BATAL & SIMPAN
========================================================= */

.dc-btn-batal,
.dc-btn-simpan {
    height: 40px;

    padding: 0 18px;

    border-radius: 8px;

    font-size: 12px;

    font-weight: 600;

    cursor: pointer;
}

.dc-btn-batal {
    border:
        1px solid #d1d5db;

    background: #ffffff;

    color: #4b5563;
}

.dc-btn-batal:hover {
    background: #f8fafc;
}

.dc-btn-simpan {
    border: none;

    background: #079bd8;

    color: #ffffff;
}

.dc-btn-simpan:hover {
    background: #075985;
}


/* =========================================================
   IMPORT MODAL
========================================================= */

.dc-import-modal-overlay {
    position: fixed;

    inset: 0;

    z-index: 10000;

    display: none;

    align-items: center;
    justify-content: center;

    padding: 20px;

    background:
        rgba(15, 23, 42, 0.55);
}

.dc-import-modal-overlay.show {
    display: flex;
}

.dc-import-modal {
    width: 100%;

    max-width: 500px;

    background: #ffffff;

    border-radius: 16px;

    box-shadow:
        0 25px 60px
        rgba(15, 23, 42, 0.25);

    overflow: hidden;
}

.dc-import-header {
    display: flex;

    align-items: center;

    justify-content: space-between;

    padding: 18px 22px;

    border-bottom:
        1px solid #e5e7eb;
}

.dc-import-header-left {
    display: flex;

    align-items: center;

    gap: 12px;
}

.dc-import-icon {
    width: 40px;
    height: 40px;

    display: flex;

    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #dcfce7;

    color: #15803d;
}

.dc-import-icon i {
    font-size: 18px;
}

.dc-import-title h3 {
    margin: 0;

    font-size: 16px;

    font-weight: 700;

    color: #1f2937;
}

.dc-import-title p {
    margin: 4px 0 0;

    font-size: 11px;

    color: #6b7280;
}

.dc-import-close {
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

.dc-import-close:hover {
    background: #e2e8f0;
}

.dc-import-body {
    padding: 24px;
}

.dc-import-info {
    padding: 13px 15px;

    margin-bottom: 18px;

    border-radius: 9px;

    background: #eff6ff;

    border:
        1px solid #bfdbfe;

    color: #1e40af;

    font-size: 11px;

    line-height: 1.6;
}

.dc-import-info i {
    margin-right: 5px;
}

.dc-import-file-wrapper {
    display: flex;

    flex-direction: column;

    gap: 8px;
}

.dc-import-label {
    font-size: 12px;

    font-weight: 600;

    color: #374151;
}

.dc-import-file {
    width: 100%;

    box-sizing: border-box;

    padding: 10px;

    border:
        1px solid #d1d5db;

    border-radius: 8px;

    background: #ffffff;

    font-size: 12px;

    color: #374151;

    cursor: pointer;
}

.dc-import-file:focus {
    outline: none;

    border-color: #079bd8;

    box-shadow:
        0 0 0 3px
        rgba(7, 155, 216, 0.10);
}

.dc-import-help {
    margin-top: 6px;

    font-size: 10px;

    line-height: 1.5;

    color: #9ca3af;
}

.dc-import-footer {
    display: flex;

    justify-content: flex-end;

    align-items: center;

    gap: 10px;

    padding: 16px 24px;

    border-top:
        1px solid #e5e7eb;
}

.dc-import-cancel,
.dc-import-submit {
    height: 40px;

    padding: 0 18px;

    border-radius: 8px;

    font-size: 12px;

    font-weight: 600;

    cursor: pointer;
}

.dc-import-cancel {
    border:
        1px solid #d1d5db;

    background: #ffffff;

    color: #4b5563;
}

.dc-import-cancel:hover {
    background: #f8fafc;
}

.dc-import-submit {
    display: inline-flex;

    align-items: center;

    justify-content: center;

    gap: 7px;

    border: none;

    background: #15803d;

    color: #ffffff;
}

.dc-import-submit:hover {
    background: #166534;
}


/* =========================================================
   BODY LOCK
========================================================= */

body.dc-modal-open,
body.dc-import-modal-open {
    overflow: hidden;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1250px) {

    .dc-table-header {
        align-items: flex-start;
    }

    .dc-table-header-actions {
        margin-left: auto;
    }

    .dc-toolbar {
        width: 100%;
    }

    .dc-search {
        flex: 1;
    }

    .dc-search input {
        width: 100%;
    }
}


@media (max-width: 1100px) {

    .dc-stats {
        grid-template-columns:
            repeat(2, 1fr);
    }
}


@media (max-width: 800px) {

    .dc-header {
        align-items: flex-start;

        flex-direction: column;

        gap: 15px;
    }

    .dc-table-header-actions {
        width: 100%;

        margin-left: 0;
    }

    .add-dc-button {
        width: auto;
    }

    .dc-toolbar {
        width: 100%;

        flex-wrap: wrap;
    }

    .dc-filter-select {
        flex: 1;

        min-width: 140px;
    }

    .dc-form-grid {
        grid-template-columns: 1fr;
    }

    .dc-form-group.full {
        grid-column: auto;
    }

    .dc-modal-overlay {
        padding: 15px;
    }

    .dc-modal {
        max-height:
            calc(100vh - 30px);
    }

    .dc-modal-body {
        padding: 15px;
    }

    .dc-form-card {
        padding: 18px;
    }

    .dc-modal-footer {
        padding: 14px 18px;
    }
}


@media (max-width: 600px) {

    .dc-stats {
        grid-template-columns: 1fr;
    }

    .dc-filter-select {
        width: 100%;

        flex: none;
    }

    .dc-table-header-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .add-dc-button {
        width: 100%;
    }


    /* FOOTER MODAL */

    .dc-modal-footer {
        flex-direction: column;

        align-items: stretch;

        gap: 12px;

        padding: 14px 15px;
    }

    .dc-footer-left {
        width: 100%;

        display: flex;

        gap: 8px;
    }

    .dc-footer-left .download-dc-button,
    .dc-footer-left .import-dc-button {
        flex: 1;

        width: auto;
    }

    .dc-footer-right {
        width: 100%;

        display: flex;

        gap: 8px;
    }

    .dc-btn-batal,
    .dc-btn-simpan {
        flex: 1;
    }


    /* IMPORT MODAL */

    .dc-import-modal-overlay {
        padding: 15px;
    }

    .dc-import-body {
        padding: 18px;
    }

    .dc-import-footer {
        padding: 14px 18px;
    }

    .dc-import-cancel,
    .dc-import-submit {
        flex: 1;
    }
}

.dc-pagination-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 16px 20px;
    border-top: 1px solid #e5e7eb;
    background: #ffffff;
}

.dc-pagination-info {
    font-size: 12px;
    color: #64748b;
}

.dc-pagination-info strong {
    color: #374151;
}

.dc-pagination {
    display: flex;
    align-items: center;
    gap: 5px;
}

.dc-page-button {
    min-width: 32px;
    height: 32px;
    padding: 0 9px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #d1d5db;
    border-radius: 7px;
    background: #ffffff;
    color: #475569;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    transition: 0.2s ease;
}

.dc-page-button:hover {
    background: #f1f5f9;
    border-color: #94a3b8;
    color: #075985;
}

.dc-page-button.active {
    background: #075985;
    border-color: #075985;
    color: #ffffff;
}

.dc-page-button.disabled {
    opacity: 0.45;
    cursor: not-allowed;
    background: #f8fafc;
}

@media (max-width: 600px) {

    .dc-pagination-wrapper {
        flex-direction: column;
        align-items: stretch;
    }

    .dc-pagination-info {
        text-align: center;
    }

    .dc-pagination {
        justify-content: center;
        flex-wrap: wrap;
    }

}

</style>

<div class="dc-page">

{{-- =====================================================
HEADER
====================================================== --}}

<div class="dc-heading">

    <h2>
        Data Center
    </h2>

    <p>
        Kelola data infrastruktur Data Center.
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

<div class="dc-stats">

{{-- TOTAL --}}

<div class="dc-stat-card">

    <div class="dc-stat-icon blue">
        <i class="bi bi-hdd-stack-fill"></i>
    </div>

    <div class="dc-stat-content">

        <span class="dc-stat-label">
            Total Data Center
        </span>

        <span class="dc-stat-value">
            {{ $totalDataCenter }}
        </span>

        <span class="dc-stat-description">
            Seluruh perangkat Data Center
        </span>

    </div>

</div>


{{-- ACTIVE --}}

<div class="dc-stat-card">

    <div class="dc-stat-icon green">
        <i class="bi bi-check-circle-fill"></i>
    </div>

    <div class="dc-stat-content">

        <span class="dc-stat-label">
            Active
        </span>

        <span class="dc-stat-value">
            {{ $active }}
        </span>

        <span class="dc-stat-description">
            Perangkat dalam kondisi aktif
        </span>

    </div>

</div>


{{-- OFFLINE --}}

<div class="dc-stat-card">

    <div class="dc-stat-icon orange">
        <i class="bi bi-power"></i>
    </div>

    <div class="dc-stat-content">

        <span class="dc-stat-label">
            Offline
        </span>

        <span class="dc-stat-value">
            {{ $offline }}
        </span>

        <span class="dc-stat-description">
            Perangkat sedang offline
        </span>

    </div>

</div>

</div>

{{-- =====================================================
TABLE CARD
====================================================== --}}

<div class="dc-table-card">

{{-- =================================================
     TABLE HEADER
================================================== --}}

<div class="dc-table-header">

    <div class="dc-table-header-left">

        <h3 class="dc-table-title">
            Data Data Center
        </h3>

        <span class="dc-table-count">
            ({{ $dataCenters->count() }} data)
        </span>

    </div>


    {{-- =================================================
         HANYA TOMBOL TAMBAH
    ================================================== --}}

    <div class="dc-table-header-actions">

        <button
            type="button"
            class="add-dc-button"
            onclick="openAddDataCenterModal()"
        >

            <i class="bi bi-plus-lg"></i>

            <span>
                Tambah Data Center
            </span>

        </button>

    </div>


    {{-- =================================================
         TOOLBAR
    ================================================== --}}

    <div class="dc-toolbar">

        {{-- SEARCH --}}

        <div class="dc-search">

            <i class="bi bi-search"></i>

            <input
                type="text"
                id="dcSearch"
                placeholder="Cari ID, nama, serial number..."
            >

        </div>


        {{-- STATUS --}}

        <select
            id="filterStatus"
            class="dc-filter-select"
        >

            <option value="">
                Semua Status
            </option>

            @foreach($statuses as $status)

                <option
                    value="{{ strtolower($status) }}"
                >
                    {{ $status }}
                </option>

            @endforeach

        </select>


        {{-- TENANT --}}

        <select
            id="filterTenant"
            class="dc-filter-select"
        >

            <option value="">
                Semua Tenant
            </option>

            @foreach($tenants as $tenant)

                <option
                    value="{{ strtolower($tenant) }}"
                >
                    {{ $tenant }}
                </option>

            @endforeach

        </select>


        {{-- SITE --}}

        <select
            id="filterSite"
            class="dc-filter-select"
        >

            <option value="">
                Semua Site
            </option>

            @foreach($sites as $site)

                <option
                    value="{{ strtolower($site) }}"
                >
                    {{ $site }}
                </option>

            @endforeach

        </select>

    </div>

</div>


{{-- =================================================
     TABLE
================================================== --}}

<div class="dc-table-wrapper">

    <table class="dc-table">

        <thead>

            <tr>

                <th>No</th>
                <th>ID</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Tenant</th>
                <th>Site</th>
                <th>Rack</th>
                <th>Position</th>
                <th>U Height</th>
                <th>Rack Face</th>
                <th>Role</th>
                <th>Manufacturer</th>
                <th>Type</th>
                <th>Platform</th>
                <th>Version</th>
                <th>Serial Number</th>
                <th>IP Address</th>
                <th>IPv4 Address</th>
                <th>CPU</th>
                <th>Hard Disk</th>
                <th>RAM</th>
                <th>PIC</th>
                <th>Tenant Group</th>
                <th>Region</th>
                <th>Location</th>
                <th>Cluster</th>
                <th>Owner Group</th>
                <th>Owner</th>
                <th>Description</th>
                <th>Verifikasi</th>
                <th>Komentar</th>
                <th>Aksi</th>

            </tr>

        </thead>


        <tbody id="dcTableBody">

            @forelse($dataCenters as $index => $data)

                @php

                    $status = strtolower(
                        (string) ($data->status ?? '')
                    );

                    $verifikasi = strtolower(
                        (string) (
                            $data->verifikasi
                            ?? 'menunggu'
                        )
                    );

                @endphp


                <tr
                    class="dc-row"

                    data-search="{{ strtolower(
                        ($data->id ?? '') . ' ' .
                        ($data->name ?? '') . ' ' .
                        ($data->serial_number ?? '') . ' ' .
                        ($data->ip_address ?? '') . ' ' .
                        ($data->ipv4_address ?? '') . ' ' .
                        ($data->tenant ?? '') . ' ' .
                        ($data->site ?? '') . ' ' .
                        ($data->rack ?? '') . ' ' .
                        ($data->role ?? '') . ' ' .
                        ($data->manufacturer ?? '') . ' ' .
                        ($data->platform ?? '') . ' ' .
                        ($data->owner ?? '') . ' ' .
                        ($data->description ?? '') . ' ' .
                        ($data->komentar ?? '')
                    ) }}"

                    data-status="{{ $status }}"

                    data-tenant="{{ strtolower(
                        $data->tenant ?? ''
                    ) }}"

                    data-site="{{ strtolower(
                        $data->site ?? ''
                    ) }}"
                >


                    {{-- NO --}}

                    <td class="row-number">
                        {{ $index + 1 }}
                    </td>


                    {{-- ID --}}

                    <td>
                        <span class="dc-code">
                            {{ $data->id }}
                        </span>
                    </td>


                    {{-- NAMA --}}

                    <td>
                        <div class="dc-name">
                            {{ $data->name ?? '-' }}
                        </div>
                    </td>


                    {{-- STATUS --}}

                    <td>

                        @if($status === 'active')

                            <span class="dc-status-badge dc-status-active">
                                Active
                            </span>

                        @else

                            <span class="dc-status-badge dc-status-offline">
                                Offline
                            </span>

                        @endif

                    </td>


                    {{-- TENANT --}}

                    <td>
                        {{ $data->tenant ?? '-' }}
                    </td>


                    {{-- SITE --}}

                    <td>
                        {{ $data->site ?? '-' }}
                    </td>


                    {{-- RACK --}}

                    <td>
                        {{ $data->rack ?? '-' }}
                    </td>


                    {{-- POSITION --}}

                    <td>
                        {{ $data->position ?? '-' }}
                    </td>


                    {{-- U HEIGHT --}}

                    <td>
                        {{ $data->u_height ?? '-' }}
                    </td>


                    {{-- RACK FACE --}}

                    <td>
                        {{ $data->rack_face ?? '-' }}
                    </td>


                    {{-- ROLE --}}

                    <td>
                        {{ $data->role ?? '-' }}
                    </td>


                    {{-- MANUFACTURER --}}

                    <td>
                        {{ $data->manufacturer ?? '-' }}
                    </td>


                    {{-- TYPE --}}

                    <td>
                        {{ $data->type ?? '-' }}
                    </td>


                    {{-- PLATFORM --}}

                    <td>
                        {{ $data->platform ?? '-' }}
                    </td>


                    {{-- VERSION --}}

                    <td>
                        {{ $data->version ?? '-' }}
                    </td>


                    {{-- SERIAL NUMBER --}}

                    <td>
                        {{ $data->serial_number ?? '-' }}
                    </td>


                    {{-- IP ADDRESS --}}

                    <td>
                        {{ $data->ip_address ?? '-' }}
                    </td>


                    {{-- IPV4 ADDRESS --}}

                    <td>
                        {{ $data->ipv4_address ?? '-' }}
                    </td>


                    {{-- CPU --}}

                    <td>
                        {{ $data->cpu ?? '-' }}
                    </td>


                    {{-- HARD DISK --}}

                    <td>
                        {{ $data->harddisk ?? '-' }}
                    </td>


                    {{-- RAM --}}

                    <td>
                        {{ $data->ram ?? '-' }}
                    </td>


                    {{-- PIC --}}

                    <td>
                        {{ $data->pic ?? '-' }}
                    </td>


                    {{-- TENANT GROUP --}}

                    <td>
                        {{ $data->tenant_group ?? '-' }}
                    </td>


                    {{-- REGION --}}

                    <td>
                        {{ $data->region ?? '-' }}
                    </td>


                    {{-- LOCATION --}}

                    <td>
                        {{ $data->location ?? '-' }}
                    </td>


                    {{-- CLUSTER --}}

                    <td>
                        {{ $data->cluster ?? '-' }}
                    </td>


                    {{-- OWNER GROUP --}}

                    <td>
                        {{ $data->owner_group ?? '-' }}
                    </td>


                    {{-- OWNER --}}

                    <td>
                        {{ $data->owner ?? '-' }}
                    </td>


                    {{-- DESCRIPTION --}}

                    <td>

                        @if($data->description)

                            <div
                                class="dc-description"
                                title="{{ $data->description }}"
                            >
                                {{ $data->description }}
                            </div>

                        @else

                            <span class="dc-empty-value">
                                -
                            </span>

                        @endif

                    </td>


                    {{-- VERIFIKASI --}}

                    <td>

                        @if($verifikasi === 'disetujui')

                            <span class="dc-verifikasi-badge dc-verifikasi-disetujui">
                                Disetujui
                            </span>

                        @elseif($verifikasi === 'ditolak')

                            <span class="dc-verifikasi-badge dc-verifikasi-ditolak">
                                Ditolak
                            </span>

                        @else

                            <span class="dc-verifikasi-badge dc-verifikasi-menunggu">
                                Menunggu
                            </span>

                        @endif

                    </td>


                    {{-- KOMENTAR --}}

                    <td>

                        @if($data->komentar)

                            <div
                                class="dc-komentar"
                                title="{{ $data->komentar }}"
                            >
                                {{ $data->komentar }}
                            </div>

                        @else

                            <span class="dc-empty-value">
                                -
                            </span>

                        @endif

                    </td>


                    {{-- AKSI --}}

                    <td>

                        <div class="dc-action-buttons">

                            {{-- EDIT --}}

                            <button
                                type="button"
                                class="dc-action-button dc-edit-button"
                                title="Edit"
                                onclick='openEditDataCenterModal(@json($data))'
                            >

                                <i class="bi bi-pencil-fill"></i>

                            </button>


                            {{-- DELETE --}}

                            <form
                                action="{{ route(
                                    'data-center.destroy',
                                    $data->id
                                ) }}"
                                method="POST"
                                class="dc-delete-form"

                                onsubmit="return confirm(
                                    'Yakin ingin mengajukan penghapusan data Data Center ini?'
                                );"
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="dc-action-button dc-delete-button"
                                    title="Hapus"
                                >

                                    <i class="bi bi-trash-fill"></i>

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>


            @empty

                <tr id="dcEmptyRow">

                    <td
                        colspan="32"
                        style="padding:0;"
                    >

                        <div class="dc-empty-state">

                            <div class="dc-empty-icon">
                                <i class="bi bi-hdd-rack"></i>
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

    @if($dataCenters->hasPages())

    <div class="dc-pagination-wrapper">

        <div class="dc-pagination-info">
            Menampilkan
            <strong>{{ $dataCenters->firstItem() }}</strong>
            -
            <strong>{{ $dataCenters->lastItem() }}</strong>
            dari
            <strong>{{ $dataCenters->total() }}</strong>
            data
        </div>

        <div class="dc-pagination">

            @if($dataCenters->onFirstPage())

                <span class="dc-page-button disabled">
                    <i class="bi bi-chevron-left"></i>
                </span>

            @else

                <a
                    href="{{ $dataCenters->previousPageUrl() }}"
                    class="dc-page-button"
                >
                    <i class="bi bi-chevron-left"></i>
                </a>

            @endif

            @foreach(
                $dataCenters->getUrlRange(
                    max(1, $dataCenters->currentPage() - 2),
                    min(
                        $dataCenters->lastPage(),
                        $dataCenters->currentPage() + 2
                    )
                ) as $page => $url
            )

                @if($page == $dataCenters->currentPage())

                    <span class="dc-page-button active">
                        {{ $page }}
                    </span>

                @else

                    <a
                        href="{{ $url }}"
                        class="dc-page-button"
                    >
                        {{ $page }}
                    </a>

                @endif

            @endforeach

            @if($dataCenters->hasMorePages())

                <a
                    href="{{ $dataCenters->nextPageUrl() }}"
                    class="dc-page-button"
                >
                    <i class="bi bi-chevron-right"></i>
                </a>

            @else

                <span class="dc-page-button disabled">
                    <i class="bi bi-chevron-right"></i>
                </span>

            @endif

        </div>

    </div>

@endif

    @if($dataCenters->hasPages())

    <div class="dc-pagination-wrapper">

        {{-- INFO DATA --}}
        <div class="dc-pagination-info">

            Menampilkan

            <strong>
                {{ $dataCenters->firstItem() }}
            </strong>

            -
            
            <strong>
                {{ $dataCenters->lastItem() }}
            </strong>

            dari

            <strong>
                {{ $dataCenters->total() }}
            </strong>

            data

        </div>


        {{-- PAGINATION --}}
        <div class="dc-pagination">

            {{-- PREVIOUS --}}
            @if($dataCenters->onFirstPage())

                <span class="dc-page-button disabled">
                    <i class="bi bi-chevron-left"></i>
                </span>

            @else

                <a
                    href="{{ $dataCenters->previousPageUrl() }}"
                    class="dc-page-button"
                >
                    <i class="bi bi-chevron-left"></i>
                </a>

            @endif


            {{-- NOMOR HALAMAN --}}
            @foreach(
                $dataCenters->getUrlRange(
                    max(1, $dataCenters->currentPage() - 2),
                    min(
                        $dataCenters->lastPage(),
                        $dataCenters->currentPage() + 2
                    )
                ) as $page => $url
            )

                @if($page == $dataCenters->currentPage())

                    <span class="dc-page-button active">
                        {{ $page }}
                    </span>

                @else

                    <a
                        href="{{ $url }}"
                        class="dc-page-button"
                    >
                        {{ $page }}
                    </a>

                @endif

            @endforeach


            {{-- NEXT --}}
            @if($dataCenters->hasMorePages())

                <a
                    href="{{ $dataCenters->nextPageUrl() }}"
                    class="dc-page-button"
                >
                    <i class="bi bi-chevron-right"></i>
                </a>

            @else

                <span class="dc-page-button disabled">
                    <i class="bi bi-chevron-right"></i>
                </span>

            @endif

        </div>

    </div>

@endif

</div>

</div>

</div>

{{-- =========================================================
MODAL TAMBAH / EDIT
========================================================= --}}

<div
    id="dataCenterModal"
    class="dc-modal-overlay"
    aria-hidden="true"
>

<div
    class="dc-modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="dcModalTitle"
>


    {{-- HEADER MODAL --}}

    <div class="dc-modal-header">

        <div class="dc-modal-header-left">

            <div class="dc-modal-icon">
                <i class="bi bi-hdd-rack-fill"></i>
            </div>

            <div class="dc-modal-header-text">

                <h2 id="dcModalTitle">
                    Tambah Data Center
                </h2>

                <p id="dcModalDescription">
                    Masukkan data infrastruktur Data Center baru.
                </p>

            </div>

        </div>


        <button
            type="button"
            class="dc-modal-close"
            onclick="closeDataCenterModal()"
            title="Tutup"
        >

            <i class="bi bi-x-lg"></i>

        </button>

    </div>


    {{-- FORM --}}

    <form
        id="dataCenterForm"
        method="POST"
        action="{{ route('data-center.store') }}"
    >

        @csrf

        <input
            type="hidden"
            name="_method"
            id="dcMethod"
            value="POST"
        >


        <div class="dc-modal-body">

            <div class="dc-form-card">


                {{-- =================================================
                     IDENTITAS
                ================================================== --}}

                <div class="dc-section">

                    <div class="dc-section-header">

                        <i class="bi bi-info-circle-fill"></i>

                        <h3>
                            Identitas Perangkat
                        </h3>

                    </div>


                    <div class="dc-form-grid">


                        {{-- ID --}}

                        <div class="dc-form-group">

                            <label class="dc-form-label">
                                ID Data Center
                            </label>

                            <input
                                type="text"
                                class="dc-form-control"
                                value="Otomatis"
                                readonly
                            >

                            <div class="dc-help">

                                <i class="bi bi-info-circle"></i>

                                ID dibuat otomatis oleh sistem.

                            </div>

                        </div>


                        {{-- NAME --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_name"
                            >

                                Nama

                                <span class="dc-required">
                                    *
                                </span>

                            </label>

                            <input
                                type="text"
                                name="name"
                                id="dc_name"
                                class="dc-form-control"
                                value="{{ old('name') }}"
                                placeholder="Masukkan nama perangkat"
                                maxlength="255"
                                required
                            >

                            @error('name')

                                <small class="dc-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        {{-- STATUS --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_status"
                            >

                                Status

                                <span class="dc-required">
                                    *
                                </span>

                            </label>

                            <select
                                name="status"
                                id="dc_status"
                                class="dc-form-control"
                                required
                            >

                                <option value="">
                                    Pilih Status
                                </option>

                                @foreach($statuses as $status)

                                    <option
                                        value="{{ $status }}"
                                        {{ old('status') === $status
                                            ? 'selected'
                                            : '' }}
                                    >
                                        {{ $status }}
                                    </option>

                                @endforeach

                            </select>

                            @error('status')

                                <small class="dc-form-error">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        {{-- TYPE --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_type"
                            >
                                Type
                            </label>

                            <input
                                type="text"
                                name="type"
                                id="dc_type"
                                class="dc-form-control"
                                value="{{ old('type') }}"
                                placeholder="Contoh: Server, Switch, Router"
                            >

                        </div>


                        {{-- PLATFORM --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_platform"
                            >
                                Platform
                            </label>

                            <input
                                type="text"
                                name="platform"
                                id="dc_platform"
                                class="dc-form-control"
                                value="{{ old('platform') }}"
                                placeholder="Masukkan platform"
                            >

                        </div>


                        {{-- VERSION --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_version"
                            >
                                Version
                            </label>

                            <input
                                type="text"
                                name="version"
                                id="dc_version"
                                class="dc-form-control"
                                value="{{ old('version') }}"
                                placeholder="Masukkan versi"
                            >

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     LOKASI & RACK
                ================================================== --}}

                <div class="dc-section">

                    <div class="dc-section-header">

                        <i class="bi bi-diagram-3-fill"></i>

                        <h3>
                            Lokasi & Rack
                        </h3>

                    </div>


                    <div class="dc-form-grid">


                        {{-- TENANT --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_tenant"
                            >
                                Tenant
                            </label>

                            <select
                                name="tenant"
                                id="dc_tenant"
                                class="dc-form-control"
                            >

                                <option value="">
                                    Pilih Tenant
                                </option>

                                @foreach($tenants as $tenant)

                                    <option
                                        value="{{ $tenant }}"
                                        {{ old('tenant') === $tenant
                                            ? 'selected'
                                            : '' }}
                                    >
                                        {{ $tenant }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- SITE --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_site"
                            >
                                Site
                            </label>

                            <select
                                name="site"
                                id="dc_site"
                                class="dc-form-control"
                            >

                                <option value="">
                                    Pilih Site
                                </option>

                                @foreach($sites as $site)

                                    <option
                                        value="{{ $site }}"
                                        {{ old('site') === $site
                                            ? 'selected'
                                            : '' }}
                                    >
                                        {{ $site }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- RACK --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_rack"
                            >
                                Rack
                            </label>

                            <select
                                name="rack"
                                id="dc_rack"
                                class="dc-form-control"
                            >

                                <option value="">
                                    Pilih Rack
                                </option>

                                @foreach($racks as $rack)

                                    <option
                                        value="{{ $rack }}"
                                        {{ old('rack') === $rack
                                            ? 'selected'
                                            : '' }}
                                    >
                                        {{ $rack }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- POSITION --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_position"
                            >
                                Position
                            </label>

                            <select
                                name="position"
                                id="dc_position"
                                class="dc-form-control"
                            >

                                <option value="">
                                    Pilih Position
                                </option>

                                @foreach($positions as $position)

                                    <option
                                        value="{{ $position }}"
                                        {{ old('position') === $position
                                            ? 'selected'
                                            : '' }}
                                    >
                                        {{ $position }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- U HEIGHT --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_u_height"
                            >
                                U Height
                            </label>

                            <select
                                name="u_height"
                                id="dc_u_height"
                                class="dc-form-control"
                            >

                                <option value="">
                                    Pilih U Height
                                </option>

                                @foreach ($uHeights as $height)
        <option value="{{ $height }}">
            {{ $height }}
        </option>
    @endforeach

                            </select>

                        </div>


                        {{-- RACK FACE --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_rack_face"
                            >
                                Rack Face
                            </label>

                            <select
                                name="rack_face"
                                id="dc_rack_face"
                                class="dc-form-control"
                            >

                                <option value="">
                                    Pilih Rack Face
                                </option>

                                @foreach($rackFaces as $face)

                                    <option
                                        value="{{ $face }}"
                                        {{ old('rack_face') === $face
                                            ? 'selected'
                                            : '' }}
                                    >
                                        {{ $face }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- REGION --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_region"
                            >
                                Region
                            </label>

                            <select
                                name="region"
                                id="dc_region"
                                class="dc-form-control"
                            >

                                <option value="">
                                    Pilih Region
                                </option>

                                @foreach($regions as $region)

                                    <option
                                        value="{{ $region }}"
                                        {{ old('region') === $region
                                            ? 'selected'
                                            : '' }}
                                    >
                                        {{ $region }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- LOCATION --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_location"
                            >
                                Location
                            </label>

                            <input
                                type="text"
                                name="location"
                                id="dc_location"
                                class="dc-form-control"
                                value="{{ old('location') }}"
                                placeholder="Masukkan lokasi"
                            >

                        </div>


                        {{-- CLUSTER --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_cluster"
                            >
                                Cluster
                            </label>

                            <select
                                name="cluster"
                                id="dc_cluster"
                                class="dc-form-control"
                            >

                                <option value="">
                                    Pilih Cluster
                                </option>

                                @foreach($clusters as $cluster)

                                    <option
                                        value="{{ $cluster }}"
                                        {{ old('cluster') === $cluster
                                            ? 'selected'
                                            : '' }}
                                    >
                                        {{ $cluster }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     SPESIFIKASI
                ================================================== --}}

                <div class="dc-section">

                    <div class="dc-section-header">

                        <i class="bi bi-cpu-fill"></i>

                        <h3>
                            Spesifikasi Perangkat
                        </h3>

                    </div>


                    <div class="dc-form-grid">


                        {{-- ROLE --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_role"
                            >
                                Role
                            </label>

                            <select
                                name="role"
                                id="dc_role"
                                class="dc-form-control"
                            >

                                <option value="">
                                    Pilih Role
                                </option>

                                @foreach($roles as $role)

                                    <option
                                        value="{{ $role }}"
                                        {{ old('role') === $role
                                            ? 'selected'
                                            : '' }}
                                    >
                                        {{ $role }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- MANUFACTURER --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_manufacturer"
                            >
                                Manufacturer
                            </label>

                            <select
                                name="manufacturer"
                                id="dc_manufacturer"
                                class="dc-form-control"
                            >

                                <option value="">
                                    Pilih Manufacturer
                                </option>

                                @foreach($manufacturers as $manufacturer)

                                    <option
                                        value="{{ $manufacturer }}"
                                        {{ old('manufacturer') === $manufacturer
                                            ? 'selected'
                                            : '' }}
                                    >
                                        {{ $manufacturer }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- RAM --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_ram"
                            >
                                RAM
                            </label>

                            <select
                                name="ram"
                                id="dc_ram"
                                class="dc-form-control"
                            >

                                <option value="">
                                    Pilih RAM
                                </option>

                                @foreach($rams as $ram)

                                    <option
                                        value="{{ $ram }}"
                                        {{ old('ram') === $ram
                                            ? 'selected'
                                            : '' }}
                                    >
                                        {{ $ram }}
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- CPU --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_cpu"
                            >
                                CPU
                            </label>

                            <textarea
                                name="cpu"
                                id="dc_cpu"
                                class="dc-form-control"
                                placeholder="Masukkan spesifikasi CPU"
                            >{{ old('cpu') }}</textarea>

                        </div>


                        {{-- HARDDISK --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_harddisk"
                            >
                                Hard Disk
                            </label>

                            <textarea
                                name="harddisk"
                                id="dc_harddisk"
                                class="dc-form-control"
                                placeholder="Masukkan kapasitas / tipe harddisk"
                            >{{ old('harddisk') }}</textarea>

                        </div>


                        {{-- SERIAL NUMBER --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_serial_number"
                            >
                                Serial Number
                            </label>

                            <input
                                type="text"
                                name="serial_number"
                                id="dc_serial_number"
                                class="dc-form-control"
                                value="{{ old('serial_number') }}"
                                placeholder="Masukkan serial number"
                            >

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     NETWORK
                ================================================== --}}

                <div class="dc-section">

                    <div class="dc-section-header">

                        <i class="bi bi-router-fill"></i>

                        <h3>
                            Network
                        </h3>

                    </div>


                    <div class="dc-form-grid">


                        {{-- IP ADDRESS --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_ip_address"
                            >
                                IP Address
                            </label>

                            <input
                                type="text"
                                name="ip_address"
                                id="dc_ip_address"
                                class="dc-form-control"
                                value="{{ old('ip_address') }}"
                                placeholder="Masukkan IP Address"
                            >

                        </div>


                        {{-- IPV4 --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_ipv4_address"
                            >
                                IPv4 Address
                            </label>

                            <input
                                type="text"
                                name="ipv4_address"
                                id="dc_ipv4_address"
                                class="dc-form-control"
                                value="{{ old('ipv4_address') }}"
                                placeholder="Masukkan IPv4 Address"
                            >

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     PIC & OWNER
                ================================================== --}}

                <div class="dc-section">

                    <div class="dc-section-header">

                        <i class="bi bi-person-badge-fill"></i>

                        <h3>
                            PIC & Kepemilikan
                        </h3>

                    </div>


                    <div class="dc-form-grid">


                        {{-- PIC --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_pic"
                            >
                                PIC
                            </label>

                            <input
                                type="text"
                                name="pic"
                                id="dc_pic"
                                class="dc-form-control"
                                value="{{ old('pic') }}"
                                placeholder="Masukkan PIC"
                            >

                        </div>


                        {{-- OWNER GROUP --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_owner_group"
                            >
                                Owner Group
                            </label>

                            <input
                                type="text"
                                name="owner_group"
                                id="dc_owner_group"
                                class="dc-form-control"
                                value="{{ old('owner_group') }}"
                                placeholder="Masukkan owner group"
                            >

                        </div>


                        {{-- OWNER --}}

                        <div class="dc-form-group">

                            <label
                                class="dc-form-label"
                                for="dc_owner"
                            >
                                Owner
                            </label>

                            <input
                                type="text"
                                name="owner"
                                id="dc_owner"
                                class="dc-form-control"
                                value="{{ old('owner') }}"
                                placeholder="Masukkan owner"
                            >

                        </div>


                        {{-- TENANT GROUP --}}

                        <div class="dc-form-group">

                            <label class="dc-form-label">
                                Tenant Group
                            </label>

                            <input
                                type="text"
                                class="dc-form-control"
                                value="Pemerintah Kota Bekasi"
                                readonly
                            >

                            <div class="dc-help">

                                <i class="bi bi-info-circle"></i>

                                Diatur otomatis oleh sistem.

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     KETERANGAN
                ================================================== --}}

                <div class="dc-section">

                    <div class="dc-section-header">

                        <i class="bi bi-card-text"></i>

                        <h3>
                            Keterangan
                        </h3>

                    </div>


                    <div class="dc-form-grid">

                        <div class="dc-form-group full">

                            <label
                                class="dc-form-label"
                                for="dc_description"
                            >
                                Description
                            </label>

                            <textarea
                                name="description"
                                id="dc_description"
                                class="dc-form-control"
                                placeholder="Masukkan deskripsi perangkat"
                            >{{ old('description') }}</textarea>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =================================================
             FOOTER FORM
        ================================================== --}}

        <div class="dc-modal-footer">


            {{-- =================================================
                 KIRI — DOWNLOAD & IMPORT EXCEL
            ================================================== --}}

            <div class="dc-footer-left">


                {{-- DOWNLOAD TEMPLATE --}}

                <a
                    href="{{ route('data-center.template') }}"
                    class="download-dc-button"
                    title="Download Template Excel"
                >

                    <i class="bi bi-download"></i>

                    <span>
                        Download Template
                    </span>

                </a>


                {{-- IMPORT EXCEL --}}

                <button
                    type="button"
                    class="import-dc-button"
                    onclick="openImportDataCenterModal()"
                    title="Import Data dari Excel"
                >

                    <i class="bi bi-file-earmark-excel-fill"></i>

                    <span>
                        Import Excel
                    </span>

                </button>

            </div>


            {{-- =================================================
                 KANAN — BATAL & SIMPAN
            ================================================== --}}

            <div class="dc-footer-right">


                {{-- BATAL --}}

                <button
                    type="button"
                    class="dc-btn-batal"
                    onclick="closeDataCenterModal()"
                >
                    Batal
                </button>


                {{-- SIMPAN --}}

                <button
                    type="submit"
                    class="dc-btn-simpan"
                    id="dcSaveButton"
                >

                    <i class="bi bi-check-lg"></i>

                    Simpan Data Center

                </button>

            </div>

        </div>

    </form>

</div>

</div>

{{-- =========================================================
MODAL IMPORT EXCEL
========================================================= --}}

<div
    id="dataCenterImportModal"
    class="dc-import-modal-overlay"
    aria-hidden="true"
>

<div
    class="dc-import-modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="dcImportModalTitle"
>


    {{-- HEADER --}}

    <div class="dc-import-header">

        <div class="dc-import-header-left">

            <div class="dc-import-icon">

                <i class="bi bi-file-earmark-excel-fill"></i>

            </div>

            <div class="dc-import-title">

                <h3 id="dcImportModalTitle">
                    Import Data Center
                </h3>

                <p>
                    Import banyak data Data Center sekaligus.
                </p>

            </div>

        </div>


        <button
            type="button"
            class="dc-import-close"
            onclick="closeImportDataCenterModal()"
            title="Tutup"
        >

            <i class="bi bi-x-lg"></i>

        </button>

    </div>


    {{-- FORM IMPORT --}}

    <form
        action="{{ route('data-center.import') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf


        <div class="dc-import-body">


            {{-- INFO --}}

            <div class="dc-import-info">

                <i class="bi bi-info-circle-fill"></i>

                File Excel dapat digunakan untuk memasukkan
                banyak data Data Center sekaligus.
                ID Data Center dan Tenant Group akan dibuat
                otomatis oleh sistem.

            </div>


            {{-- FILE --}}

            <div class="dc-import-file-wrapper">

                <label
                    for="dc_import_file"
                    class="dc-import-label"
                >
                    File Excel
                </label>

                <input
                    type="file"
                    name="file"
                    id="dc_import_file"
                    class="dc-import-file"
                    accept=".xlsx,.xls"
                    required
                >

                <div class="dc-import-help">

                    <i class="bi bi-info-circle"></i>

                    Format yang diperbolehkan:
                    <strong>.xlsx</strong> atau
                    <strong>.xls</strong>.
                    Maksimal 10 MB.

                </div>

            </div>

        </div>


        {{-- FOOTER IMPORT --}}

        <div class="dc-import-footer">

            <button
                type="button"
                class="dc-import-cancel"
                onclick="closeImportDataCenterModal()"
            >
                Batal
            </button>


            <button
                type="submit"
                class="dc-import-submit"
            >

                <i class="bi bi-upload"></i>

                Import Data

            </button>

        </div>

    </form>

</div>

</div>

{{-- =========================================================
JAVASCRIPT
========================================================= --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        setupDataCenterFilter();

        @if($errors->any())

            openAddDataCenterModal();

        @endif

    }
);


/* =========================================================
   FILTER TABLE
========================================================= */

function setupDataCenterFilter()
{
    const searchInput =
        document.getElementById('dcSearch');

    const statusFilter =
        document.getElementById('filterStatus');

    const tenantFilter =
        document.getElementById('filterTenant');

    const siteFilter =
        document.getElementById('filterSite');

    const rows =
        document.querySelectorAll('.dc-row');


    function filterDataCenter()
    {

        const search =
            (
                searchInput?.value || ''
            )
            .toLowerCase()
            .trim();


        const status =
            (
                statusFilter?.value || ''
            )
            .toLowerCase()
            .trim();


        const tenant =
            (
                tenantFilter?.value || ''
            )
            .toLowerCase()
            .trim();


        const site =
            (
                siteFilter?.value || ''
            )
            .toLowerCase()
            .trim();


        let number = 1;


        rows.forEach(
            function (row) {

                const rowSearch =
                    (
                        row.dataset.search || ''
                    )
                    .toLowerCase();


                const rowStatus =
                    (
                        row.dataset.status || ''
                    )
                    .toLowerCase();


                const rowTenant =
                    (
                        row.dataset.tenant || ''
                    )
                    .toLowerCase();


                const rowSite =
                    (
                        row.dataset.site || ''
                    )
                    .toLowerCase();


                const matchSearch =
                    !search ||
                    rowSearch.includes(search);


                const matchStatus =
                    !status ||
                    rowStatus === status;


                const matchTenant =
                    !tenant ||
                    rowTenant === tenant;


                const matchSite =
                    !site ||
                    rowSite === site;


                const show =
                    matchSearch &&
                    matchStatus &&
                    matchTenant &&
                    matchSite;


                row.style.display =
                    show ? '' : 'none';


                if (show) {

                    const numberCell =
                        row.querySelector(
                            '.row-number'
                        );


                    if (numberCell) {

                        numberCell.textContent =
                            number++;

                    }

                }

            }
        );

    }


    searchInput?.addEventListener(
        'input',
        filterDataCenter
    );


    statusFilter?.addEventListener(
        'change',
        filterDataCenter
    );


    tenantFilter?.addEventListener(
        'change',
        filterDataCenter
    );


    siteFilter?.addEventListener(
        'change',
        filterDataCenter
    );
}


/* =========================================================
   OPEN ADD
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


    form.reset();


    form.action =
        "{{ route('data-center.store') }}";


    document.getElementById(
        'dcMethod'
    ).value = 'POST';


    document.getElementById(
        'dcModalTitle'
    ).textContent =
        'Tambah Data Center';


    document.getElementById(
        'dcModalDescription'
    ).textContent =
        'Masukkan data infrastruktur Data Center baru.';


    document.getElementById(
        'dcSaveButton'
    ).innerHTML =
        '<i class="bi bi-check-lg"></i> Simpan Data Center';


    const status =
        document.getElementById(
            'dc_status'
        );


    if (status) {

        status.value =
            'Active';

    }


    const body =
        document.querySelector(
            '.dc-modal-body'
        );


    if (body) {

        body.scrollTop = 0;

    }


    modal.classList.add('show');


    modal.setAttribute(
        'aria-hidden',
        'false'
    );


    document.body.classList.add(
        'dc-modal-open'
    );
}


/* =========================================================
   OPEN EDIT
========================================================= */

function openEditDataCenterModal(data)
{
    const modal =
        document.getElementById(
            'dataCenterModal'
        );


    const form =
        document.getElementById(
            'dataCenterForm'
        );


    if (!modal || !form || !data) {
        return;
    }


    form.action =
        "{{ url('/infrastruktur/data-center') }}/" +
        encodeURIComponent(data.id);


    document.getElementById(
        'dcMethod'
    ).value = 'PUT';


    document.getElementById(
        'dcModalTitle'
    ).textContent =
        'Edit Data Center';


    document.getElementById(
        'dcModalDescription'
    ).textContent =
        'Perbarui data Data Center yang dipilih.';


    document.getElementById(
        'dcSaveButton'
    ).innerHTML =
        '<i class="bi bi-check-lg"></i> Simpan Perubahan';


    function setValue(
        elementId,
        value
    ) {

        const element =
            document.getElementById(
                elementId
            );


        if (element) {

            element.value =
                value ?? '';

        }

    }


    /* IDENTITAS */

    setValue(
        'dc_name',
        data.name
    );

    setValue(
        'dc_status',
        data.status
    );

    setValue(
        'dc_type',
        data.type
    );

    setValue(
        'dc_platform',
        data.platform
    );

    setValue(
        'dc_version',
        data.version
    );


    /* LOKASI */

    setValue(
        'dc_tenant',
        data.tenant
    );

    setValue(
        'dc_site',
        data.site
    );

    setValue(
        'dc_rack',
        data.rack
    );

    setValue(
        'dc_position',
        data.position
    );

    setValue(
        'dc_u_height',
        data.u_height
    );

    setValue(
        'dc_rack_face',
        data.rack_face
    );

    setValue(
        'dc_region',
        data.region
    );

    setValue(
        'dc_location',
        data.location
    );

    setValue(
        'dc_cluster',
        data.cluster
    );


    /* SPESIFIKASI */

    setValue(
        'dc_role',
        data.role
    );

    setValue(
        'dc_manufacturer',
        data.manufacturer
    );

    setValue(
        'dc_ram',
        data.ram
    );

    setValue(
        'dc_cpu',
        data.cpu
    );

    setValue(
        'dc_harddisk',
        data.harddisk
    );

    setValue(
        'dc_serial_number',
        data.serial_number
    );


    /* NETWORK */

    setValue(
        'dc_ip_address',
        data.ip_address
    );

    setValue(
        'dc_ipv4_address',
        data.ipv4_address
    );


    /* PIC / OWNER */

    setValue(
        'dc_pic',
        data.pic
    );

    setValue(
        'dc_owner_group',
        data.owner_group
    );

    setValue(
        'dc_owner',
        data.owner
    );


    /* DESCRIPTION */

    setValue(
        'dc_description',
        data.description
    );


    const body =
        document.querySelector(
            '.dc-modal-body'
        );


    if (body) {

        body.scrollTop = 0;

    }


    modal.classList.add('show');


    modal.setAttribute(
        'aria-hidden',
        'false'
    );


    document.body.classList.add(
        'dc-modal-open'
    );
}


/* =========================================================
   CLOSE ADD / EDIT MODAL
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
        'dc-modal-open'
    );
}


/* =========================================================
   OPEN IMPORT MODAL
========================================================= */

function openImportDataCenterModal()
{
    const modal =
        document.getElementById(
            'dataCenterImportModal'
        );


    if (!modal) {
        return;
    }


    const fileInput =
        document.getElementById(
            'dc_import_file'
        );


    if (fileInput) {

        fileInput.value = '';

    }


    modal.classList.add('show');


    modal.setAttribute(
        'aria-hidden',
        'false'
    );


    document.body.classList.add(
        'dc-import-modal-open'
    );
}


/* =========================================================
   CLOSE IMPORT MODAL
========================================================= */

function closeImportDataCenterModal()
{
    const modal =
        document.getElementById(
            'dataCenterImportModal'
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
        'dc-import-modal-open'
    );
}


/* =========================================================
   CLICK OUTSIDE MODAL
========================================================= */

document.addEventListener(
    'click',
    function (event) {

        const dataCenterModal =
            document.getElementById(
                'dataCenterModal'
            );


        if (
            dataCenterModal &&
            event.target === dataCenterModal
        ) {

            closeDataCenterModal();

        }


        const importModal =
            document.getElementById(
                'dataCenterImportModal'
            );


        if (
            importModal &&
            event.target === importModal
        ) {

            closeImportDataCenterModal();

        }

    }
);


/* =========================================================
   ESCAPE
========================================================= */

document.addEventListener(
    'keydown',
    function (event) {

        if (event.key !== 'Escape') {
            return;
        }


        const dataCenterModal =
            document.getElementById(
                'dataCenterModal'
            );


        if (
            dataCenterModal &&
            dataCenterModal.classList.contains(
                'show'
            )
        ) {

            closeDataCenterModal();

        }


        const importModal =
            document.getElementById(
                'dataCenterImportModal'
            );


        if (
            importModal &&
            importModal.classList.contains(
                'show'
            )
        ) {

            closeImportDataCenterModal();

        }

    }
);

</script>

@endsection

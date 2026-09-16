@extends('layouts.app')

@section('title', 'Software')

@section('page-title', 'Software')

@section('content')

<style>

/* =========================================================
   SOFTWARE PAGE
========================================================= */

.software-page {
    width: 100%;
}

/* =========================================================
   HEADER
========================================================= */

.software-header {
    margin-bottom: 24px;
}

.software-heading h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
}

.software-heading p {
    margin: 6px 0 0;
    font-size: 13px;
    color: #6b7280;
}

/* =========================================================
   SUCCESS ALERT
========================================================= */

.alert-success {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    color: #047857;
    padding: 12px 15px;
    border-radius: 9px;
    margin-bottom: 20px;
    font-size: 13px;
}

.alert-success i {
    font-size: 17px;
}

/* =========================================================
   ERROR ALERT
========================================================= */

.alert-error {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #b91c1c;
    padding: 12px 15px;
    border-radius: 9px;
    margin-bottom: 20px;
    font-size: 13px;
}

.alert-error i {
    font-size: 17px;
}

/* =========================================================
   STATISTIC SECTION TITLE
========================================================= */

.stats-section-title {
    font-size: 13px;
    font-weight: 700;
    color: #374151;
}

/* =========================================================
   STATISTIC CARDS
========================================================= */

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px;
    margin-bottom: 25px;
}

.stat-card {
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

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 12px rgba(0, 0, 0, 0.08);
}

.stat-icon {
    width: 45px;
    height: 45px;
    flex-shrink: 0;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.stat-icon.blue {
    background: #e0f2fe;
    color: #0284c7;
}

.stat-icon.purple {
    background: #ede9fe;
    color: #7c3aed;
}

.stat-icon.orange {
    background: #ffedd5;
    color: #ea580c;
}

.stat-icon.green {
    background: #dcfce7;
    color: #16a34a;
}

.stat-icon.red {
    background: #fee2e2;
    color: #dc2626;
}

.stat-content {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.stat-label {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 5px;
}

.stat-value {
    font-size: 23px;
    font-weight: 700;
    color: #075985;
    line-height: 1.2;
}

.stat-value.currency {
    font-size: 17px;
    white-space: nowrap;
}

.stat-description {
    margin-top: 7px;
    font-size: 10px;
    color: #9ca3af;
}

/* =========================================================
   DATA MASTER
========================================================= */

.software-master-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 18px 20px;
    margin-bottom: 25px;
    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.04);
}

.software-master-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    margin-bottom: 15px;
}

.software-master-title-wrap {
    display: flex;
    align-items: center;
    gap: 11px;
}

.software-master-icon {
    width: 38px;
    height: 38px;
    border-radius: 9px;
    background: #e0f2fe;
    color: #075985;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
    flex-shrink: 0;
}

.software-master-title {
    margin: 0;
    font-size: 14px;
    font-weight: 700;
    color: #1f2937;
}

.software-master-description {
    margin: 3px 0 0;
    font-size: 10px;
    color: #9ca3af;
}

.software-master-manage {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    height: 32px;
    padding: 0 11px;
    border-radius: 7px;
    background: #f8fafc;
    border: 1px solid #d1d5db;
    color: #075985;
    font-size: 10px;
    font-weight: 600;
    text-decoration: none;
    transition: .2s ease;
    white-space: nowrap;
}

.software-master-manage:hover {
    background: #e0f2fe;
    border-color: #bae6fd;
    color: #075985;
}

.software-master-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 10px;
}

.software-master-item {
    min-height: 68px;
    padding: 12px 13px;
    border: 1px solid #eef2f7;
    border-radius: 9px;
    background: #f8fafc;
    display: flex;
    align-items: center;
    gap: 10px;
}

.software-master-item-icon {
    width: 31px;
    height: 31px;
    flex-shrink: 0;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    color: #075985;
    border: 1px solid #e5e7eb;
    font-size: 14px;
}

.software-master-item-content {
    min-width: 0;
    display: flex;
    flex-direction: column;
}

.software-master-item-label {
    font-size: 10px;
    color: #9ca3af;
    margin-bottom: 2px;
}

.software-master-item-value {
    font-size: 15px;
    font-weight: 700;
    color: #075985;
}

.software-master-item-note {
    margin-top: 1px;
    font-size: 9px;
    color: #9ca3af;
}

/* =========================================================
   SOFTWARE TABLE CARD
========================================================= */

.software-table-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: visible;
    box-shadow: 0 2px 7px rgba(0, 0, 0, 0.04);
}

/* =========================================================
   TABLE HEADER
========================================================= */

.table-header {
    min-height: 70px;
    padding: 15px 18px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    border-bottom: 1px solid #e5e7eb;
}

.table-header-left {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

.table-title {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: #1f2937;
}

.table-count {
    font-size: 11px;
    color: #9ca3af;
}

/* =========================================================
   TOOLBAR
========================================================= */

.software-toolbar {
    position: relative;
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
}

/* =========================================================
   SEARCH
========================================================= */

.software-search {
    width: 230px;
    height: 36px;
    display: flex;
    align-items: center;
    padding: 0 13px;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 18px;
}

.software-search i {
    margin-right: 8px;
    color: #9ca3af;
    font-size: 14px;
}

.software-search input {
    width: 100%;
    border: none;
    outline: none;
    background: transparent;
    font-size: 11px;
    color: #374151;
}

.software-search input::placeholder {
    color: #9ca3af;
}

/* =========================================================
   TOOLBAR BUTTON
========================================================= */

.filter-button,
.add-button {
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 0 13px;
    border-radius: 7px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
}

.filter-button {
    background: white;
    border: 1px solid #d1d5db;
    color: #374151;
}

.filter-button:hover {
    background: #f3f4f6;
}

.filter-button i {
    font-size: 12px;
}

.add-button {
    background: #071b88;
    border: 1px solid #071b88;
    color: white;
}

.add-button:hover {
    background: #050f63;
    border-color: #050f63;
    color: white;
}

.add-button i {
    font-size: 13px;
}

/* =========================================================
   IMPORT BUTTON
========================================================= */

.import-software-btn {
    height: 36px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 0 13px;
    border-radius: 7px;
    border: 1px solid #16a34a;
    background: #f0fdf4;
    color: #15803d;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.import-software-btn:hover {
    background: #dcfce7;
    border-color: #15803d;
    color: #166534;
}

.import-software-btn i {
    font-size: 13px;
}

/* =========================================================
   FILTER DROPDOWN
========================================================= */

.filter-dropdown {
    display: none;
    position: absolute;
    top: 44px;
    right: 65px;
    width: 230px;
    padding: 15px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    z-index: 1000;
}

.filter-dropdown.show {
    display: block;
}

.filter-title {
    margin-bottom: 14px;
    font-size: 13px;
    font-weight: 700;
    color: #075985;
}

.filter-dropdown label {
    display: block;
    margin-bottom: 6px;
    font-size: 11px;
    font-weight: 600;
    color: #374151;
}

.filter-dropdown select {
    width: 100%;
    height: 34px;
    padding: 0 10px;
    margin-bottom: 12px;
    background: white;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    font-size: 11px;
    color: #374151;
    outline: none;
}

.filter-dropdown select:focus {
    border-color: #075985;
}

.filter-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 7px;
    margin-top: 15px;
}

.reset-filter,
.apply-filter {
    height: 31px;
    padding: 0 11px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
}

.reset-filter {
    background: #f3f4f6;
    color: #6b7280;
}

.reset-filter:hover {
    background: #e5e7eb;
    color: #374151;
}

.apply-filter {
    border: none;
    background: #071b88;
    color: white;
}

.apply-filter:hover {
    background: #050f63;
}

/* =========================================================
   TABLE
========================================================= */

.table-wrapper {
    width: 100%;
    overflow-x: auto;
    border-radius: 0 0 14px 14px;
}

.software-table {
    width: 100%;
    min-width: 1500px;
    border-collapse: collapse;
}

.software-table th {
    padding: 13px 14px;
    background: #f8fafc;
    border-bottom: 1px solid #e5e7eb;
    color: #475569;
    font-size: 10px;
    font-weight: 700;
    text-align: left;
    white-space: nowrap;
}

.software-table td {
    padding: 13px 14px;
    border-bottom: 1px solid #f1f5f9;
    color: #374151;
    font-size: 11px;
    vertical-align: middle;
}

.software-table tbody tr:hover {
    background: #f8fafc;
}

.software-table tbody tr:last-child td {
    border-bottom: none;
}

/* =========================================================
   KODE
========================================================= */

.software-code {
    font-weight: 700;
    color: #075985;
    white-space: nowrap;
}

/* =========================================================
   SOFTWARE NAME
========================================================= */

.software-name {
    font-weight: 600;
    color: #1f2937;
}

.software-spec {
    margin-top: 3px;
    max-width: 180px;
    font-size: 10px;
    color: #9ca3af;
    line-height: 1.4;
}

/* =========================================================
   BADGES
========================================================= */

.badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
    background: #f1f5f9;
    color: #475569;
}

.badge-blue {
    background: #e0f2fe;
    color: #075985;
}

.badge-green {
    background: #dcfce7;
    color: #166534;
}

.badge-purple {
    background: #ede9fe;
    color: #6d28d9;
}

.badge-orange {
    background: #ffedd5;
    color: #9a3412;
}

.badge-red {
    background: #fee2e2;
    color: #991b1b;
}

.badge-gray {
    background: #f1f5f9;
    color: #64748b;
}

/* =========================================================
   STATUS
========================================================= */

.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 10px;
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

.verification-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 5px 9px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 600;
    white-space: nowrap;
}

.verification-approved {
    background: #dcfce7;
    color: #166534;
}

.verification-rejected {
    background: #fee2e2;
    color: #991b1b;
}

.verification-pending {
    background: #fef3c7;
    color: #92400e;
}

/* =========================================================
   COMMENT
========================================================= */

.software-comment {
    max-width: 180px;
    min-width: 120px;
    font-size: 10px;
    line-height: 1.4;
    color: #6b7280;
    white-space: normal;
    word-break: break-word;
}

/* =========================================================
   ACTION
========================================================= */

.action-buttons {
    display: flex;
    align-items: center;
    gap: 6px;
}

.action-buttons form {
    margin: 0;
}

.action-button {
    width: 30px;
    height: 30px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 7px;
    text-decoration: none;
    cursor: pointer;
    transition: 0.2s ease;
}

.action-button i {
    font-size: 12px;
}

.edit-button {
    background: #e0f2fe;
    color: #075985;
}

.edit-button:hover {
    background: #bae6fd;
    color: #075985;
}

.delete-button {
    background: #fee2e2;
    color: #dc2626;
}

.delete-button:hover {
    background: #fecaca;
    color: #dc2626;
}

/* =========================================================
   EMPTY STATE
========================================================= */

.empty-state {
    padding: 55px 20px;
    text-align: center;
}

.empty-state-icon {
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

.empty-state-icon i {
    font-size: 27px;
}

.empty-state h3 {
    margin: 0 0 6px;
    font-size: 15px;
    color: #374151;
}

.empty-state p {
    margin: 0;
    font-size: 12px;
    color: #9ca3af;
}

/* =========================================================
   IMPORT MODAL
========================================================= */

#import-software-modal {
    position: fixed;
    inset: 0;
    z-index: 10000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 25px;
    background: rgba(15, 23, 42, 0.62);
    overflow-y: auto;
}

#import-software-modal.show {
    display: flex;
}

.import-software-modal-box {
    position: relative;
    width: 100%;
    max-width: 620px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, .22);
    overflow: hidden;
}

.import-software-modal-header {
    min-height: 68px;
    padding: 16px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid #e5e7eb;
}

.import-software-modal-title-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
}

.import-software-modal-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #dcfce7;
    color: #15803d;
    font-size: 19px;
}

.import-software-modal-title {
    margin: 0;
    color: #1f2937;
    font-size: 16px;
    font-weight: 700;
}

.import-software-modal-subtitle {
    margin: 3px 0 0;
    color: #9ca3af;
    font-size: 10px;
}

.import-software-close {
    width: 32px;
    height: 32px;
    border: none;
    border-radius: 7px;
    background: #f3f4f6;
    color: #6b7280;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.import-software-close:hover {
    background: #e5e7eb;
    color: #374151;
}

.import-software-modal-body {
    padding: 22px;
}

.import-software-info {
    margin-bottom: 15px;
    padding: 11px 13px;
    border-radius: 8px;
    background: #eff6ff;
    border: 1px solid #dbeafe;
    color: #1d4ed8;
    font-size: 11px;
    line-height: 1.5;
}

.import-software-dropzone {
    min-height: 210px;
    padding: 25px;
    border: 2px dashed #cbd5e1;
    border-radius: 12px;
    background: #f8fafc;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    cursor: pointer;
    transition: all .2s ease;
}

.import-software-dropzone:hover,
.import-software-dropzone.dragover {
    border-color: #071b88;
    background: #f8faff;
}

.import-software-dropzone-icon {
    width: 54px;
    height: 54px;
    margin-bottom: 12px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #e0f2fe;
    color: #075985;
    font-size: 23px;
}

.import-software-dropzone-title {
    margin: 0;
    color: #374151;
    font-size: 13px;
    font-weight: 700;
}

.import-software-dropzone-text {
    margin: 5px 0 0;
    color: #9ca3af;
    font-size: 10px;
}

.import-software-selected {
    display: none;
    margin-top: 13px;
    padding: 12px 13px;
    align-items: center;
    gap: 11px;
    border: 1px solid #d1fae5;
    border-radius: 9px;
    background: #f0fdf4;
}

.import-software-selected.show {
    display: flex;
}

.import-software-selected-icon {
    width: 36px;
    height: 36px;
    flex-shrink: 0;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #dcfce7;
    color: #15803d;
    font-size: 17px;
}

.import-software-selected-info {
    flex: 1;
    min-width: 0;
}

.import-software-selected-name {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #166534;
    font-size: 11px;
    font-weight: 700;
}

.import-software-selected-size {
    display: block;
    margin-top: 2px;
    color: #6b7280;
    font-size: 9px;
}

.import-software-remove {
    width: 28px;
    height: 28px;
    flex-shrink: 0;
    border: none;
    border-radius: 6px;
    background: #fee2e2;
    color: #dc2626;
    cursor: pointer;
}

.import-software-remove:hover {
    background: #fecaca;
}

.import-software-error {
    display: none;
    margin-top: 10px;
    padding: 9px 11px;
    border-radius: 7px;
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #b91c1c;
    font-size: 10px;
}

.import-software-error.show {
    display: block;
}

.import-software-modal-footer {
    min-height: 65px;
    padding: 12px 22px;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 9px;
    border-top: 1px solid #e5e7eb;
}

.import-software-cancel,
.import-software-submit {
    height: 37px;
    padding: 0 16px;
    border-radius: 7px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
}

.import-software-cancel {
    border: 1px solid #d1d5db;
    background: #fff;
    color: #6b7280;
}

.import-software-cancel:hover {
    background: #f3f4f6;
    color: #374151;
}

.import-software-submit {
    border: 1px solid #071b88;
    background: #071b88;
    color: #fff;
}

.import-software-submit:hover:not(:disabled) {
    background: #050f63;
}

.import-software-submit:disabled {
    opacity: .5;
    cursor: not-allowed;
}

/* =========================================================
   MODAL BODY LOCK
========================================================= */

body.software-modal-open {
    overflow: hidden;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1200px) {

    .stats-grid {
        grid-template-columns: repeat(3, 1fr);
    }

    .software-master-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .table-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .software-toolbar {
        width: 100%;
        justify-content: flex-start;
    }

    .filter-dropdown {
        left: 238px;
        right: auto;
    }
}

@media (max-width: 800px) {

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .software-master-grid {
        grid-template-columns: 1fr;
    }

    .software-master-header {
        align-items: flex-start;
    }

    .software-toolbar {
        flex-wrap: wrap;
    }

    .software-search {
        width: 100%;
    }

    .filter-dropdown {
        left: 0;
        right: auto;
    }

    .import-software-btn span {
        display: none;
    }
}

@media (max-width: 500px) {

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .software-master-card {
        padding: 15px;
    }

    .software-master-header {
        flex-direction: column;
    }

    .software-master-manage {
        width: 100%;
        justify-content: center;
    }

    #import-software-modal {
        padding: 12px;
    }

    .import-software-modal-body,
    .import-software-modal-footer {
        padding-left: 15px;
        padding-right: 15px;
    }
}

/* =========================================================
   PAGINATION (Bootstrap 5 markup, custom styling)
========================================================= */

.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
    margin: 10px 0 0;
    gap: 4px;
    flex-wrap: wrap;
}

.page-item .page-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 26px;
    height: 26px;
    padding: 0 6px;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    background: white;
    color: #374151;
    font-size: 10px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s ease;
}

.page-item .page-link:hover {
    background: #f3f4f6;
    color: #075985;
}

.page-item.active .page-link {
    background: #071b88;
    border-color: #071b88;
    color: white;
}

.page-item.disabled .page-link {
    color: #9ca3af;
    background: #f9fafb;
    cursor: not-allowed;
}

/* =========================================================
   PAGINATION INFO TEXT (Showing X to Y of Z results)
========================================================= */

.software-table-card nav .d-flex > div:first-child {
    font-size: 10px;
    color: #9ca3af;
}


/* =========================================================
   CUSTOM SOFTWARE PAGINATION
========================================================= */
.software-pagination {
    width: calc(100% - 32px);
    margin: 16px auto 8px auto;

    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;

    padding: 8px 0;
}

.pagination-info {
    color: #64748b;
    font-size: 12px;
    font-weight: 400;
    line-height: 1.4;
}

.pagination-links {
    display: flex;
    align-items: center;
    gap: 4px;
}

.page-btn {
    box-sizing: border-box;
    width: 28px;
    min-width: 28px;
    height: 28px;
    padding: 0;
    margin: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    background: #ffffff;
    color: #475569;
    text-decoration: none;
    font-family: inherit;
    font-size: 11px;
    font-weight: 600;
    line-height: 1;
    cursor: pointer;
    transition: background-color .15s ease, border-color .15s ease, color .15s ease;
}

.page-btn:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #1e293b;
    text-decoration: none;
}

.page-btn.active {
    background: #2563eb;
    border-color: #2563eb;
    color: #ffffff;
}

.page-btn.active:hover {
    background: #1d4ed8;
    border-color: #1d4ed8;
    color: #ffffff;
}

.page-btn.disabled {
    background: #f8fafc;
    border-color: #e2e8f0;
    color: #cbd5e1;
    cursor: default;
    pointer-events: none;
}

.pagination-links .page-btn:first-child,
.pagination-links .page-btn:last-child {
    width: 26px;
    min-width: 26px;
    height: 26px;
    font-size: 14px;
    font-weight: 400;
}

@media (max-width: 768px) {
    .software-pagination {
        flex-direction: column;
        align-items: flex-start;
    }

    .pagination-links {
        width: 100%;
        justify-content: flex-start;
    }
}

</style>


<div class="software-page">

    {{-- =====================================================
         PAGE HEADER
    ====================================================== --}}

    <div class="software-header">

        <div class="software-heading">

            <h2>
                Software
            </h2>

            <p>
                Kelola data aset software dan lisensi yang tersedia.
            </p>

        </div>

    </div>


    {{-- =====================================================
         SUCCESS MESSAGE
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
         ERROR MESSAGE
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

    @if($errors->any() && !request()->isMethod('GET'))

        <div class="alert-error">

            <i class="bi bi-exclamation-circle-fill"></i>

            <div>

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        </div>

    @endif


    {{-- =====================================================
         STATISTIK PERANGKAT LUNAK
    ====================================================== --}}

    <div
        class="stats-section-title"
        style="margin-bottom:12px;"
    >
        Keterangan Berdasarkan Total
    </div>


    <div class="stats-grid">

        {{-- TOTAL ASET --}}

        <div class="stat-card">

            <div class="stat-icon blue">
                <i class="bi bi-grid-fill"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Total Aset Perangkat Lunak
                </span>

                <span class="stat-value">
                    {{ $totalAset }}
                </span>

                <span class="stat-description">
                    Seluruh aset perangkat lunak
                </span>

            </div>

        </div>


        {{-- TOTAL WEBSITE --}}

        <div class="stat-card">

            <div class="stat-icon purple">
                <i class="bi bi-globe2"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Total Website
                </span>

                <span class="stat-value">
                    {{ $totalWebsite }}
                </span>

                <span class="stat-description">
                    Aset dengan kategori Website
                </span>

            </div>

        </div>


        {{-- TOTAL MONITORING --}}

        <div class="stat-card">

            <div class="stat-icon orange">
                <i class="bi bi-display"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Total Aplikasi Monitoring
                </span>

                <span class="stat-value">
                    {{ $totalAplikasiMonitoring }}
                </span>

                <span class="stat-description">
                    Aplikasi monitoring terdaftar
                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         STATUS KEAKTIFAN
    ====================================================== --}}

    <div
        class="stats-section-title"
        style="margin:20px 0 12px;"
    >
        Keterangan Berdasarkan Status Keaktifan
    </div>


    <div class="stats-grid">

        {{-- WEBSITE AKTIF --}}

        <div class="stat-card">

            <div class="stat-icon green">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Total Website Aktif
                </span>

                <span class="stat-value">
                    {{ $websiteAktif }}
                </span>

                <span class="stat-description">
                    Website dengan status Aktif
                </span>

            </div>

        </div>


        {{-- WEBSITE TIDAK AKTIF --}}

        <div class="stat-card">

            <div class="stat-icon red">
                <i class="bi bi-x-circle-fill"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Total Website Tidak Aktif
                </span>

                <span class="stat-value">
                    {{ $websiteTidakAktif }}
                </span>

                <span class="stat-description">
                    Website dengan status Tidak Aktif
                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         SSL
    ====================================================== --}}

    <div
        class="stats-section-title"
        style="margin:20px 0 12px;"
    >
        Keterangan Berdasarkan SSL
    </div>


    <div class="stats-grid">

        {{-- SSL BEKASI KOTA --}}

        <div class="stat-card">

            <div class="stat-icon green">
                <i class="bi bi-shield-check"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    SSL Bekasi Kota
                </span>

                <span class="stat-value">
                    {{ $sslBerlisensi }}
                </span>

                <span class="stat-description">
                    Menggunakan SSL yang dikelola Bekasi Kota
                </span>

            </div>

        </div>


        {{-- SSL NON BEKASI KOTA --}}

        <div class="stat-card">

            <div class="stat-icon orange">
                <i class="bi bi-shield-lock"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    SSL Non Bekasi Kota
                </span>

                <span class="stat-value">
                    {{ $sslNonBerlisensi }}
                </span>

                <span class="stat-description">
                    Menggunakan SSL dari vendor atau pihak lain
                </span>

            </div>

        </div>


        {{-- TANPA SSL --}}

        <div class="stat-card">

            <div class="stat-icon red">
                <i class="bi bi-shield-x"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Tidak Menggunakan SSL
                </span>

                <span class="stat-value">
                    {{ $sslTidakMenerapkan }}
                </span>

                <span class="stat-description">
                    Website tidak menggunakan SSL
                </span>

            </div>

        </div>

    </div>


    {{-- =====================================================
         DATA MASTER SOFTWARE
    ====================================================== --}}

    <div class="software-master-card">

        <div class="software-master-header">

            <div class="software-master-title-wrap">

                <div class="software-master-icon">
                    <i class="bi bi-database-fill"></i>
                </div>

                <div>

                    <h3 class="software-master-title">
                        Data Master
                    </h3>

                    <p class="software-master-description">
                        Kelola data kategori, SSL, hosting, dan PIC yang digunakan pada data software.
                    </p>

                </div>

            </div>


            <a
                href="{{ route('software.master.index') }}"
                class="software-master-manage"
            >

                Kelola Data Master

                <i class="bi bi-arrow-right"></i>

            </a>

        </div>


        <div class="software-master-grid">

            {{-- KATEGORI --}}

            <div class="software-master-item">

                <div class="software-master-item-icon">
                    <i class="bi bi-tags-fill"></i>
                </div>

                <div class="software-master-item-content">

                    <span class="software-master-item-label">
                        Kategori
                    </span>

                    <span class="software-master-item-value">
                        {{ $kategoriOptions->count() }}
                    </span>

                    <span class="software-master-item-note">
                        data aktif
                    </span>

                </div>

            </div>


            {{-- SSL --}}

            <div class="software-master-item">

                <div class="software-master-item-icon">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>

                <div class="software-master-item-content">

                    <span class="software-master-item-label">
                        SSL
                    </span>

                    <span class="software-master-item-value">
                        {{ $sslOptions->count() }}
                    </span>

                    <span class="software-master-item-note">
                        data aktif
                    </span>

                </div>

            </div>


            {{-- HOSTING --}}

            <div class="software-master-item">

                <div class="software-master-item-icon">
                    <i class="bi bi-server"></i>
                </div>

                <div class="software-master-item-content">

                    <span class="software-master-item-label">
                        Hosting
                    </span>

                    <span class="software-master-item-value">
                        {{ $hostingOptions->count() }}
                    </span>

                    <span class="software-master-item-note">
                        data aktif
                    </span>

                </div>

            </div>


            {{-- PIC --}}

            <div class="software-master-item">

                <div class="software-master-item-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

                <div class="software-master-item-content">

                    <span class="software-master-item-label">
                        PIC
                    </span>

                    <span class="software-master-item-value">
                        {{ $picOptions->count() }}
                    </span>

                    <span class="software-master-item-note">
                        data aktif
                    </span>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         SOFTWARE TABLE
    ====================================================== --}}

    <div class="software-table-card">

        {{-- =================================================
             TABLE HEADER
        ================================================== --}}

        <div class="table-header">

            <div class="table-header-left">

                <h3 class="table-title">
                    Data Perangkat Lunak
                </h3>

                <span class="table-count">
                    ({{ $softwares->total() }} data)
                </span>

            </div>


            <div class="software-toolbar">

                {{-- SEARCH --}}

                <form
                    action="{{ route('software.index') }}"
                    method="GET"
                    class="software-search"
                >

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama aset, kode, URL..."
                    >


                    @if(request('kategori'))

                        <input
                            type="hidden"
                            name="kategori"
                            value="{{ request('kategori') }}"
                        >

                    @endif


                    @if(request('hosting'))

                        <input
                            type="hidden"
                            name="hosting"
                            value="{{ request('hosting') }}"
                        >

                    @endif


                    @if(request('status'))

                        <input
                            type="hidden"
                            name="status"
                            value="{{ request('status') }}"
                        >

                    @endif


                    @if(request('pic'))

                        <input
                            type="hidden"
                            name="pic"
                            value="{{ request('pic') }}"
                        >

                    @endif

                </form>


                {{-- FILTER --}}

                <button
                    type="button"
                    class="filter-button"
                    onclick="toggleFilter()"
                >

                    <i class="bi bi-funnel"></i>

                    <span>
                        Filter
                    </span>

                </button>


                {{-- IMPORT --}}

                <button
                    type="button"
                    class="import-software-btn"
                    onclick="openImportSoftwareModal()"
                    title="Import Excel / CSV"
                >

                    <i class="bi bi-file-earmark-excel-fill"></i>

                    <span>
                        Import Excel / CSV
                    </span>

                </button>


                {{-- TAMBAH SOFTWARE --}}

                <button
                    type="button"
                    class="add-button"
                    onclick="openSoftwareModal()"
                >

                    <i class="bi bi-plus-lg"></i>

                    <span>
                        Tambah Software
                    </span>

                </button>


                {{-- =================================================
                     FILTER DROPDOWN
                ================================================== --}}

                <div
                    id="filter-dropdown"
                    class="filter-dropdown"
                >

                    <form
                        action="{{ route('software.index') }}"
                        method="GET"
                    >

                        <div class="filter-title">
                            Filter Perangkat Lunak
                        </div>


                        <input
                            type="hidden"
                            name="search"
                            value="{{ request('search') }}"
                        >


                        {{-- KATEGORI --}}

                        <label for="filter-kategori">
                            Kategori
                        </label>

                        <select
                            name="kategori"
                            id="filter-kategori"
                        >

                            <option value="">
                                Semua
                            </option>

                            @foreach($kategoriOptions as $item)

                                <option
                                    value="{{ $item->nama }}"
                                    {{ request('kategori') === $item->nama ? 'selected' : '' }}
                                >
                                    {{ $item->nama }}
                                </option>

                            @endforeach

                        </select>


                        {{-- HOSTING --}}

                        <label for="filter-hosting">
                            Hosting
                        </label>

                        <select
                            name="hosting"
                            id="filter-hosting"
                        >

                            <option value="">
                                Semua
                            </option>

                            @foreach($hostingOptions as $item)

                                <option
                                    value="{{ $item->nama }}"
                                    {{ request('hosting') === $item->nama ? 'selected' : '' }}
                                >
                                    {{ $item->nama }}
                                </option>

                            @endforeach

                        </select>


                        {{-- STATUS --}}

                        <label for="filter-status">
                            Status
                        </label>

                        <select
                            name="status"
                            id="filter-status"
                        >

                            <option value="">
                                Semua
                            </option>

                            <option
                                value="Aktif"
                                {{ request('status') === 'Aktif' ? 'selected' : '' }}
                            >
                                Aktif
                            </option>

                            <option
                                value="Tidak Aktif"
                                {{ request('status') === 'Tidak Aktif' ? 'selected' : '' }}
                            >
                                Tidak Aktif
                            </option>

                        </select>


                        {{-- PIC --}}

                        <label for="filter-pic">
                            PIC
                        </label>

                        <select
                            name="pic"
                            id="filter-pic"
                        >

                            <option value="">
                                Semua
                            </option>

                            @foreach($picOptions as $item)

                                <option
                                    value="{{ $item->nama }}"
                                    {{ request('pic') === $item->nama ? 'selected' : '' }}
                                >
                                    {{ $item->nama }}
                                </option>

                            @endforeach

                        </select>


                        {{-- FILTER BUTTONS --}}

                        <div class="filter-buttons">

                            <a
                                href="{{ route('software.index') }}"
                                class="reset-filter"
                            >
                                Reset
                            </a>

                            <button
                                type="submit"
                                class="apply-filter"
                            >
                                Terapkan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>


        {{-- =================================================
             TABLE
        ================================================== --}}

        <div class="table-wrapper">

            @if($softwares->count() > 0)

                <table class="software-table">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama Aset</th>
                            <th>Kategori</th>
                            <th>Kategori Sistem Elektronik</th>
                            <th>SSL</th>
                            <th>URL Homepage</th>
                            <th>IP Public</th>
                            <th>IP Private</th>
                            <th>Hosting</th>
                            <th>Status</th>
                            <th>PIC</th>
                            <th>Kerahasiaan</th>
                            <th>Integritas</th>
                            <th>Ketersediaan</th>
                            <th>Nilai</th>
                            <th>Keterangan</th>
                            <th>Verifikasi</th>
                            <th>Komentar</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($softwares as $software)

                            @php

                                $namaAset =
                                    $software->nama_aset
                                    ?: $software->jenis
                                    ?: '-';


                                $kategori =
                                    $software->category?->nama
                                    ?: $software->kategori
                                    ?: '-';


                                $kategoriSistemElektronik =
                                    $software->kategori_sistem_elektronik
                                    ?: '-';


                                $ssl =
                                    $software->sslMaster?->nama_ssl
                                    ?: $software->ssl
                                    ?: 'Tidak Menggunakan SSL';


                                $hosting =
                                    $software->hostingMaster?->nama
                                    ?: $software->hosting
                                    ?: '-';


                                $pic =
                                    $software->picMaster?->nama
                                    ?: $software->pic
                                    ?: '-';


                                $statusClass = match(
                                    $software->status
                                ) {

                                    'Aktif'
                                        => 'status-active',

                                    'Tidak Aktif'
                                        => 'status-expired',

                                    default
                                        => 'status-perpetual',

                                };


                                $kategoriClass = match(
                                    $kategori
                                ) {

                                    'Website'
                                        => 'badge-blue',

                                    'Open Source'
                                        => 'badge-green',

                                    'Utilities'
                                        => 'badge-purple',

                                    default
                                        => 'badge-gray',

                                };


                                /*
                                 * SSL sekarang mengikuti
                                 * Data Master SSL.
                                 *
                                 * SSL Bekasi Kota
                                 * SSL Vendor
                                 * Tidak Menggunakan SSL
                                 */

                                $sslLower =
                                    strtolower(
                                        trim($ssl)
                                    );


                                if (
                                    str_contains(
                                        $sslLower,
                                        'bekasi kota'
                                    )
                                ) {

                                    $sslClass =
                                        'badge-green';

                                } elseif (
                                    str_contains(
                                        $sslLower,
                                        'vendor'
                                    )
                                ) {

                                    $sslClass =
                                        'badge-orange';

                                } elseif (
                                    in_array(
                                        $ssl,
                                        [
                                            'Tidak Menggunakan SSL',
                                            'Tidak Menerapkan SSL',
                                            '-',
                                        ],
                                        true
                                    )
                                ) {

                                    $sslClass =
                                        'badge-red';

                                } else {

                                    $sslClass =
                                        'badge-gray';

                                }


                                $verifikasi =
                                    $software->verifikasi
                                    ?? 'menunggu';


                                $verifikasiClass =
                                    match(
                                        strtolower(
                                            $verifikasi
                                        )
                                    ) {

                                        'disetujui'
                                            => 'verification-approved',

                                        'ditolak'
                                            => 'verification-rejected',

                                        default
                                            => 'verification-pending',

                                    };

                            @endphp


                            <tr>

                                {{-- NO --}}

                                <td>

                                    {{ $softwares->firstItem() + $loop->index }}

                                </td>


                                {{-- KODE --}}

                                <td>

                                    <span class="software-code">

                                        {{ $software->kode ?: '-' }}

                                    </span>

                                </td>


                                {{-- NAMA --}}

                                <td>

                                    <div class="software-name">

                                        {{ $namaAset }}

                                    </div>


                                    @if($software->deskripsi_aplikasi)

                                        <div class="software-spec">

                                            {{ $software->deskripsi_aplikasi }}

                                        </div>

                                    @elseif($software->spesifikasi)

                                        <div class="software-spec">

                                            {{ $software->spesifikasi }}

                                        </div>

                                    @endif

                                </td>


                                {{-- KATEGORI --}}

                                <td>

                                    <span
                                        class="badge {{ $kategoriClass }}"
                                    >

                                        {{ $kategori }}

                                    </span>

                                </td>


                                {{-- KATEGORI SISTEM ELEKTRONIK --}}

                                <td>

                                    @php
                                        $kseClass = match ($kategoriSistemElektronik) {
                                            'Rendah' => 'badge-green',
                                            'Tinggi' => 'badge-orange',
                                            'Strategis' => 'badge-red',
                                            default => 'badge-gray',
                                        };
                                    @endphp

                                    <span class="badge {{ $kseClass }}">
                                        {{ $kategoriSistemElektronik }}
                                    </span>

                                </td>


                                {{-- SSL --}}

                                <td>

                                    <span
                                        class="badge {{ $sslClass }}"
                                    >

                                        {{ $ssl }}

                                    </span>


                                    @if($software->sslMaster?->tanggal_expire)

                                        <div
                                            style="
                                                margin-top:4px;
                                                font-size:9px;
                                                color:#9ca3af;
                                                white-space:nowrap;
                                            "
                                        >

                                            Exp:

                                            {{
                                                $software
                                                    ->sslMaster
                                                    ->tanggal_expire
                                                    ->format('d-m-Y')
                                            }}

                                        </div>

                                    @endif

                                </td>


                                {{-- URL --}}

                                <td>

                                    @if($software->url_homepage)

                                        <a
                                            href="{{ $software->url_homepage }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            title="{{ $software->url_homepage }}"
                                            style="
                                                display:block;
                                                max-width:180px;
                                                overflow:hidden;
                                                text-overflow:ellipsis;
                                                white-space:nowrap;
                                                color:#2563eb;
                                                text-decoration:none;
                                            "
                                        >

                                            {{ $software->url_homepage }}

                                        </a>

                                    @else

                                        -

                                    @endif

                                </td>


                                {{-- IP PUBLIC --}}

                                <td>

                                    <span
                                        style="
                                            font-family:monospace;
                                            font-size:10px;
                                        "
                                    >

                                        {{ $software->ip_public ?: '-' }}

                                    </span>

                                </td>


                                {{-- IP PRIVATE --}}

                                <td>

                                    <span
                                        style="
                                            font-family:monospace;
                                            font-size:10px;
                                        "
                                    >

                                        {{ $software->ip_private ?: '-' }}

                                    </span>

                                </td>


                                {{-- HOSTING --}}

                                <td>

                                    <span class="badge badge-blue">

                                        {{ $hosting }}

                                    </span>

                                </td>


                                {{-- STATUS --}}

                                <td>

                                    <span
                                        class="status-badge {{ $statusClass }}"
                                    >

                                        {{ $software->status ?: '-' }}

                                    </span>

                                </td>


                                {{-- PIC --}}

                                <td>

                                    {{ $pic }}

                                </td>


                                {{-- KERAHASIAAN --}}

                                <td>

                                    <span class="badge">

                                        {{ $software->kerahasiaan ?? '-' }}

                                    </span>

                                </td>


                                {{-- INTEGRITAS --}}

                                <td>

                                    <span class="badge">

                                        {{ $software->integritas ?? '-' }}

                                    </span>

                                </td>


                                {{-- KETERSEDIAAN --}}

                                <td>

                                    <span class="badge">

                                        {{ $software->ketersediaan ?? '-' }}

                                    </span>

                                </td>


                                {{-- NILAI --}}

                                <td>

                                    <strong style="color:#075985;">

                                        {{
                                            $software->nilai !== null
                                                ? number_format(
                                                    (float) $software->nilai,
                                                    2,
                                                    ',',
                                                    '.'
                                                )
                                                : '-'
                                        }}

                                    </strong>

                                </td>


                                {{-- KETERANGAN --}}

                                <td>

                                    @php

                                        $keteranganClass =
                                            match(
                                                $software->keterangan
                                            ) {

                                                'Tinggi'
                                                    => 'status-expired',

                                                'Sedang'
                                                    => 'status-warning',

                                                'Rendah'
                                                    => 'status-active',

                                                default
                                                    => 'status-perpetual',

                                            };

                                    @endphp


                                    <span
                                        class="status-badge {{ $keteranganClass }}"
                                    >

                                        {{ $software->keterangan ?: '-' }}

                                    </span>

                                </td>


                                {{-- VERIFIKASI --}}

                                <td>

                                    <span
                                        class="
                                            verification-badge
                                            {{ $verifikasiClass }}
                                        "
                                    >

                                        {{ ucfirst($verifikasi) }}

                                    </span>

                                </td>


                                {{-- KOMENTAR --}}

                                <td>

                                    <div class="software-comment">

                                        {{ $software->komentar ?: '-' }}

                                    </div>

                                </td>


                                {{-- AKSI --}}

                                <td>

                                    <div class="action-buttons">

                                        {{-- EDIT --}}

                                        <button
                                            type="button"
                                            class="
                                                action-button
                                                edit-button
                                            "
                                            title="Edit"
                                            onclick="
                                                openEditSoftwareModal(
                                                    '{{ $software->id }}'
                                                )
                                            "
                                        >

                                            <i class="bi bi-pencil-fill"></i>

                                        </button>


                                        {{-- DELETE --}}

                                        <form
                                            action="{{ route('software.destroy', $software) }}"
                                            method="POST"
                                            onsubmit="
                                                return confirm(
                                                    'Yakin ingin menghapus software ini? Data akan diajukan untuk verifikasi.'
                                                );
                                            "
                                        >

                                            @csrf

                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="
                                                    action-button
                                                    delete-button
                                                "
                                                title="Hapus"
                                            >

                                                <i class="bi bi-trash-fill"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>


                            {{-- EDIT MODAL --}}

                            @include(
                                'software.edit',
                                ['software' => $software]
                            )

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="empty-state">

                    <div class="empty-state-icon">

                        <i class="bi bi-laptop"></i>

                    </div>


                    <h3>

                        @if(
                            request('search')
                            || request('kategori')
                            || request('hosting')
                            || request('status')
                            || request('pic')
                        )

                            Data perangkat lunak tidak ditemukan

                        @else

                            Belum ada data perangkat lunak

                        @endif

                    </h3>


                    <p>

                        @if(
                            request('search')
                            || request('kategori')
                            || request('hosting')
                            || request('status')
                            || request('pic')
                        )

                            Coba ubah kata pencarian atau filter.

                        @else

                            Belum ada aset perangkat lunak yang tersimpan.

                        @endif

                    </p>

                </div>

            @endif

        </div>


        {{-- =================================================
             PAGINATION
        ================================================== --}}

        @if($softwares->hasPages())

            <div class="software-pagination">

                <div class="pagination-info">
                    Menampilkan
                    {{ $softwares->firstItem() ?? 0 }}
                    -
                    {{ $softwares->lastItem() ?? 0 }}
                    dari
                    {{ $softwares->total() }}
                    data
                </div>

                <div class="pagination-links">

                    {{-- Previous --}}
                    @if($softwares->onFirstPage())
                        <span class="page-btn disabled" aria-disabled="true">‹</span>
                    @else
                        <a
                            href="{{ $softwares->previousPageUrl() }}"
                            class="page-btn"
                            aria-label="Halaman sebelumnya"
                        >‹</a>
                    @endif

                    {{-- Page numbers --}}
                    @php
                        $startPage = max(1, $softwares->currentPage() - 2);
                        $endPage = min(
                            $softwares->lastPage(),
                            $softwares->currentPage() + 2
                        );
                    @endphp

                    @foreach($softwares->getUrlRange($startPage, $endPage) as $page => $url)
                        @if($page == $softwares->currentPage())
                            <span class="page-btn active" aria-current="page">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="page-btn">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if($softwares->hasMorePages())
                        <a
                            href="{{ $softwares->nextPageUrl() }}"
                            class="page-btn"
                            aria-label="Halaman berikutnya"
                        >›</a>
                    @else
                        <span class="page-btn disabled" aria-disabled="true">›</span>
                    @endif

                </div>
            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     MODAL TAMBAH SOFTWARE
========================================================= --}}

@include('software.create')


{{-- =========================================================
     MODAL IMPORT EXCEL / CSV
========================================================= --}}

<div
    id="import-software-modal"
    aria-hidden="true"
>

    <div class="import-software-modal-box">

        {{-- HEADER --}}

        <div class="import-software-modal-header">

            <div class="import-software-modal-title-wrap">

                <div class="import-software-modal-icon">

                    <i class="bi bi-file-earmark-spreadsheet-fill"></i>

                </div>

                <div>

                    <h3 class="import-software-modal-title">
                        Import Software
                    </h3>

                    <p class="import-software-modal-subtitle">
                        Masukkan data perangkat lunak dari Excel atau CSV.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="import-software-close"
                onclick="closeImportSoftwareModal()"
                aria-label="Tutup"
            >

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        {{-- FORM --}}

        <form
            id="software-import-form"
            action="{{ route('software.import') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf


            <div class="import-software-modal-body">

                {{-- INFO --}}

                <div class="import-software-info">

                    <i class="bi bi-info-circle-fill"></i>

                    Format yang didukung:

                    <strong>.xlsx</strong>,
                    <strong>.xls</strong>,
                    dan
                    <strong>.csv</strong>.

                    Maksimal ukuran file 5 MB.

                </div>


                {{-- DROPZONE --}}

                <label
                    for="software-import-file"
                    id="software-import-drop"
                    class="import-software-dropzone"
                >

                    <input
                        type="file"
                        id="software-import-file"
                        name="file"
                        accept=".xlsx,.xls,.csv"
                        required
                        style="display:none"
                    >


                    <div class="import-software-dropzone-icon">

                        <i class="bi bi-cloud-arrow-up-fill"></i>

                    </div>


                    <p class="import-software-dropzone-title">
                        Klik untuk memilih file
                    </p>


                    <p class="import-software-dropzone-text">
                        atau drag & drop file Excel / CSV ke area ini
                    </p>

                </label>


                {{-- SELECTED FILE --}}

                <div
                    id="software-import-selected"
                    class="import-software-selected"
                >

                    <div class="import-software-selected-icon">

                        <i class="bi bi-file-earmark-excel-fill"></i>

                    </div>


                    <div class="import-software-selected-info">

                        <span
                            id="software-import-name"
                            class="import-software-selected-name"
                        ></span>


                        <span
                            id="software-import-size"
                            class="import-software-selected-size"
                        ></span>

                    </div>


                    <button
                        type="button"
                        class="import-software-remove"
                        onclick="removeImportSoftwareFile()"
                        title="Hapus file"
                    >

                        <i class="bi bi-trash-fill"></i>

                    </button>

                </div>


                {{-- ERROR --}}

                <div
                    id="software-import-error"
                    class="import-software-error"
                ></div>

            </div>


            {{-- FOOTER --}}

            <div class="import-software-modal-footer">

                <button
                    type="button"
                    class="import-software-cancel"
                    onclick="closeImportSoftwareModal()"
                >

                    Batal

                </button>


                <button
                    type="submit"
                    id="software-import-submit"
                    class="import-software-submit"
                    disabled
                >

                    <i class="bi bi-upload"></i>

                    Import

                </button>

            </div>

        </form>

    </div>

</div>


<script>

/* =========================================================
   FILTER
========================================================= */

function toggleFilter()
{
    const dropdown =
        document.getElementById(
            'filter-dropdown'
        );

    if (!dropdown) {
        return;
    }

    dropdown.classList.toggle(
        'show'
    );
}


/* =========================================================
   CLOSE FILTER WHEN CLICK OUTSIDE
========================================================= */

document.addEventListener(
    'click',
    function(event)
    {

        const dropdown =
            document.getElementById(
                'filter-dropdown'
            );

        const button =
            document.querySelector(
                '.filter-button'
            );


        if (
            dropdown &&
            button &&
            !dropdown.contains(
                event.target
            ) &&
            !button.contains(
                event.target
            )
        ) {

            dropdown.classList.remove(
                'show'
            );

        }

    }
);


/* =========================================================
   OPEN CREATE SOFTWARE MODAL
========================================================= */

function openSoftwareModal()
{
    const modal =
        document.getElementById(
            'software-modal'
        );


    if (!modal) {

        console.error(
            'Modal Tambah Software tidak ditemukan. Pastikan create.blade.php memiliki id="software-modal".'
        );

        return;
    }


    /*
     * CREATE MODAL SEKARANG TIDAK MENGGUNAKAN
     * class "show".
     *
     * create.blade.php menggunakan:
     *
     * display: none;
     *
     * sehingga kita buka menggunakan:
     *
     * display: flex;
     */

    modal.style.display = 'flex';


    modal.setAttribute(
        'aria-hidden',
        'false'
    );


    document.body.classList.add(
        'software-modal-open'
    );


    if (
        typeof updatePengadaan ===
        'function'
    ) {

        updatePengadaan();

    }


    if (
        typeof updateSslExpiry ===
        'function'
    ) {

        updateSslExpiry();

    }

}


/* =========================================================
   CLOSE CREATE SOFTWARE MODAL
========================================================= */

function closeSoftwareModal()
{
    const modal =
        document.getElementById(
            'software-modal'
        );


    if (!modal) {
        return;
    }


    /*
     * Tutup modal menggunakan display none.
     */

    modal.style.display = 'none';


    modal.setAttribute(
        'aria-hidden',
        'true'
    );


    document.body.classList.remove(
        'software-modal-open'
    );
}


/* =========================================================
   OPEN EDIT SOFTWARE MODAL
========================================================= */

function openEditSoftwareModal(id)
{
    const modal =
        document.getElementById(
            'software-edit-modal-' + id
        );


    if (!modal) {

        console.error(
            'Edit modal tidak ditemukan:',
            id
        );

        return;
    }


    modal.classList.add(
        'show'
    );


    modal.setAttribute(
        'aria-hidden',
        'false'
    );


    document.body.classList.add(
        'software-modal-open'
    );


    if (
        typeof window[
            'initEditSoftwareModal_' + id
        ] === 'function'
    ) {

        window[
            'initEditSoftwareModal_' + id
        ]();

    }

}


/* =========================================================
   CLOSE EDIT SOFTWARE MODAL
========================================================= */

function closeEditSoftwareModal(id)
{
    const modal =
        document.getElementById(
            'software-edit-modal-' + id
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
        'software-modal-open'
    );
}


/* =========================================================
   CLICK BACKDROP
========================================================= */

document.addEventListener(
    'click',
    function(event)
    {

        /* CREATE */

        const createModal =
            document.getElementById(
                'software-modal'
            );


        if (
            createModal &&
            event.target === createModal
        ) {

            closeSoftwareModal();

            return;
        }


        /* EDIT */

        if (
            event.target.classList &&
            event.target.classList.contains(
                'software-edit-modal'
            )
        ) {

            const id =
                event.target.dataset
                    .softwareId;


            if (id) {

                closeEditSoftwareModal(
                    id
                );

            }

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

        if (
            event.key !== 'Escape'
        ) {

            return;

        }


        /* IMPORT */

        const importModal =
            document.getElementById(
                'import-software-modal'
            );


        if (
            importModal &&
            importModal.classList.contains(
                'show'
            )
        ) {

            closeImportSoftwareModal();

            return;
        }


        /* CREATE */

        const createModal =
            document.getElementById(
                'software-modal'
            );


        /*
         * CREATE MODAL MENGGUNAKAN
         * style.display, BUKAN class "show".
         */

        if (
            createModal &&
            createModal.style.display === 'flex'
        ) {

            closeSoftwareModal();

            return;
        }


        /* EDIT */

        const editModals =
            document.querySelectorAll(
                '.software-edit-modal.show'
            );


        editModals.forEach(
            function(modal)
            {

                const id =
                    modal.dataset
                        .softwareId;


                if (id) {

                    closeEditSoftwareModal(
                        id
                    );

                }

            }
        );

    }
);


/* =========================================================
   IMPORT EXCEL / CSV
========================================================= */

let selectedImportSoftwareFile =
    null;


/* =========================================================
   OPEN IMPORT MODAL
========================================================= */

function openImportSoftwareModal()
{
    const modal =
        document.getElementById(
            'import-software-modal'
        );


    if (!modal) {
        return;
    }


    modal.classList.add(
        'show'
    );


    modal.setAttribute(
        'aria-hidden',
        'false'
    );


    document.body.classList.add(
        'software-modal-open'
    );
}


/* =========================================================
   CLOSE IMPORT MODAL
========================================================= */

function closeImportSoftwareModal()
{
    const modal =
        document.getElementById(
            'import-software-modal'
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
        'software-modal-open'
    );
}


/* =========================================================
   FORMAT FILE SIZE
========================================================= */

function formatImportSoftwareSize(
    bytes
)
{
    if (!bytes) {
        return '0 B';
    }


    const units = [
        'B',
        'KB',
        'MB',
        'GB'
    ];


    const index =
        Math.floor(
            Math.log(bytes) /
            Math.log(1024)
        );


    const size =
        bytes /
        Math.pow(
            1024,
            index
        );


    return (
        size.toFixed(
            index === 0
                ? 0
                : 2
        )
        + ' '
        + units[index]
    );
}


/* =========================================================
   SHOW IMPORT ERROR
========================================================= */

function showImportSoftwareError(
    message
)
{
    const error =
        document.getElementById(
            'software-import-error'
        );


    if (!error) {
        return;
    }


    error.textContent =
        message;


    error.classList.add(
        'show'
    );
}


/* =========================================================
   CLEAR IMPORT ERROR
========================================================= */

function clearImportSoftwareError()
{
    const error =
        document.getElementById(
            'software-import-error'
        );


    if (!error) {
        return;
    }


    error.textContent = '';


    error.classList.remove(
        'show'
    );
}


/* =========================================================
   HANDLE IMPORT FILE
========================================================= */

function handleImportSoftwareFile(
    file
)
{
    clearImportSoftwareError();


    if (!file) {
        return;
    }


    const ext =
        file.name
            .split('.')
            .pop()
            .toLowerCase();


    const allowedExtensions = [
        'xlsx',
        'xls',
        'csv'
    ];


    if (
        !allowedExtensions.includes(
            ext
        )
    ) {

        removeImportSoftwareFile();


        showImportSoftwareError(
            'Format file harus .xlsx, .xls, atau .csv.'
        );


        return;
    }


    const maxSize =
        5 * 1024 * 1024;


    if (
        file.size > maxSize
    ) {

        removeImportSoftwareFile();


        showImportSoftwareError(
            'Ukuran file maksimal 5 MB.'
        );


        return;
    }


    selectedImportSoftwareFile =
        file;


    const input =
        document.getElementById(
            'software-import-file'
        );


    const name =
        document.getElementById(
            'software-import-name'
        );


    const size =
        document.getElementById(
            'software-import-size'
        );


    const selected =
        document.getElementById(
            'software-import-selected'
        );


    const submit =
        document.getElementById(
            'software-import-submit'
        );


    if (
        input &&
        input.files.length === 0
    ) {

        try {

            const dataTransfer =
                new DataTransfer();


            dataTransfer.items.add(
                file
            );


            input.files =
                dataTransfer.files;

        } catch (error) {

            console.warn(
                'Tidak dapat mengisi input file secara otomatis:',
                error
            );

        }

    }


    if (name) {

        name.textContent =
            file.name;

    }


    if (size) {

        size.textContent =
            formatImportSoftwareSize(
                file.size
            );

    }


    if (selected) {

        selected.classList.add(
            'show'
        );

    }


    if (submit) {

        submit.disabled =
            false;

    }

}


/* =========================================================
   REMOVE IMPORT FILE
========================================================= */

function removeImportSoftwareFile()
{
    selectedImportSoftwareFile =
        null;


    const input =
        document.getElementById(
            'software-import-file'
        );


    const selected =
        document.getElementById(
            'software-import-selected'
        );


    const submit =
        document.getElementById(
            'software-import-submit'
        );


    if (input) {

        input.value = '';

    }


    if (selected) {

        selected.classList.remove(
            'show'
        );

    }


    if (submit) {

        submit.disabled =
            true;

    }

}


/* =========================================================
   INIT IMPORT
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function()
    {

        const input =
            document.getElementById(
                'software-import-file'
            );


        const drop =
            document.getElementById(
                'software-import-drop'
            );


        const modal =
            document.getElementById(
                'import-software-modal'
            );


        const form =
            document.getElementById(
                'software-import-form'
            );


        /* FILE INPUT */

        if (input) {

            input.addEventListener(
                'change',
                function(event)
                {

                    handleImportSoftwareFile(
                        event.target.files[0]
                    );

                }
            );

        }


        /* DRAG OVER */

        if (drop) {

            drop.addEventListener(
                'dragover',
                function(event)
                {

                    event.preventDefault();


                    drop.classList.add(
                        'dragover'
                    );

                }
            );


            drop.addEventListener(
                'dragleave',
                function()
                {

                    drop.classList.remove(
                        'dragover'
                    );

                }
            );


            drop.addEventListener(
                'drop',
                function(event)
                {

                    event.preventDefault();


                    drop.classList.remove(
                        'dragover'
                    );


                    const file =
                        event.dataTransfer
                            .files[0];


                    if (!file) {
                        return;
                    }


                    if (input) {

                        try {

                            const dataTransfer =
                                new DataTransfer();


                            dataTransfer.items.add(
                                file
                            );


                            input.files =
                                dataTransfer.files;

                        } catch (error) {

                            console.warn(
                                'Browser tidak mendukung DataTransfer:',
                                error
                            );

                        }

                    }


                    handleImportSoftwareFile(
                        file
                    );

                }
            );

        }


        /* BACKDROP */

        if (modal) {

            modal.addEventListener(
                'click',
                function(event)
                {

                    if (
                        event.target === modal
                    ) {

                        closeImportSoftwareModal();

                    }

                }
            );

        }


        /* FORM SUBMIT */

        if (form) {

            form.addEventListener(
                'submit',
                function(event)
                {

                    const currentFile =
                        input &&
                        input.files
                            ? input.files[0]
                            : selectedImportSoftwareFile;


                    if (!currentFile) {

                        event.preventDefault();


                        showImportSoftwareError(
                            'Pilih file Excel atau CSV terlebih dahulu.'
                        );


                        return;

                    }


                    const submit =
                        document.getElementById(
                            'software-import-submit'
                        );


                    if (submit) {

                        submit.disabled =
                            true;


                        submit.innerHTML =
                            '<i class="bi bi-hourglass-split"></i> Mengimpor...';

                    }

                }
            );

        }

    }
);


/* =========================================================
   AUTO OPEN CREATE JIKA VALIDATION ERROR
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function()
    {

        @if($errors->any())

            openSoftwareModal();

        @endif

    }
);

</script>

@endsection
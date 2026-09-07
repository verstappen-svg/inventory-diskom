@extends('layouts.app')

@section('title', 'Hardware')

@section('page-title', 'Hardware')

@section('content')

<style>
    /* =====================================================
       HARDWARE PAGE
    ===================================================== */

    .hardware-page {
        width: 100%;
        padding: 0;
    }

    .hardware-page-header {
        margin-bottom: 22px;
    }

    .hardware-page-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #172033;
        line-height: 1.25;
    }

    .hardware-page-header p {
        margin: 6px 0 0;
        font-size: 13px;
        color: #7b8495;
    }


    /* =====================================================
       ALERT
    ===================================================== */

    .hardware-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 500;
    }

    .hardware-alert-success {
        background: #ecfdf3;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .hardware-alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .hardware-alert i {
        margin-top: 1px;
        font-size: 16px;
    }


    /* =====================================================
       STATISTICS
    ===================================================== */

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 22px;
    }

    .stat-card {
        min-height: 135px;
        padding: 20px;
        background: #ffffff;
        border: 1px solid #e7eaf0;
        border-radius: 14px;
        box-shadow: 0 3px 12px rgba(16, 24, 40, 0.04);
        display: flex;
        align-items: center;
        gap: 15px;
        transition: 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 16px rgba(16, 24, 40, 0.07);
    }

    .stat-icon {
        width: 45px;
        height: 45px;
        min-width: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .stat-icon.blue {
        background: #eaf2ff;
        color: #2563eb;
    }

    .stat-icon.purple {
        background: #f2eaff;
        color: #7c3aed;
    }

    .stat-icon.orange {
        background: #fff3df;
        color: #f59e0b;
    }

    .stat-icon.red {
        background: #feecec;
        color: #dc2626;
    }

    .stat-icon.green {
        background: #eaf9f0;
        color: #16a34a;
    }

    .stat-icon.cyan {
        background: #e7f8fb;
        color: #0891b2;
    }

    .stat-content {
        min-width: 0;
    }

    .stat-label {
        display: block;
        margin-bottom: 5px;
        font-size: 12px;
        font-weight: 600;
        color: #7b8495;
    }

    .stat-value {
        display: block;
        font-size: 21px;
        font-weight: 700;
        color: #172033;
        line-height: 1.2;
    }

    .stat-value.currency {
        font-size: 18px;
    }

    .stat-description {
        display: block;
        margin-top: 5px;
        font-size: 11px;
        color: #98a1b2;
    }


    /* =====================================================
       TABLE CARD
    ===================================================== */

    .hardware-table-card {
        background: #ffffff;
        border: 1px solid #e7eaf0;
        border-radius: 14px;
        box-shadow: 0 3px 12px rgba(16, 24, 40, 0.04);
        overflow: hidden;
    }

    .hardware-table-header {
        min-height: 70px;
        padding: 16px 18px;
        border-bottom: 1px solid #edf0f4;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .hardware-table-title {
        min-width: 0;
    }

    .hardware-table-title h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        color: #172033;
    }

    .hardware-table-title p {
        margin: 4px 0 0;
        font-size: 11px;
        color: #8a93a3;
    }

    .hardware-table-toolbar {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-shrink: 0;
    }

    .hardware-search {
        position: relative;
        width: 230px;
    }

    .hardware-search i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9aa3b2;
        font-size: 13px;
        pointer-events: none;
    }

    .hardware-search input {
        width: 100%;
        height: 36px;
        padding: 0 12px 0 34px;
        border: 1px solid #dfe3ea;
        border-radius: 8px;
        outline: none;
        background: #ffffff;
        color: #30394b;
        font-size: 11px;
        transition: 0.2s ease;
        box-sizing: border-box;
    }

    .hardware-search input:focus {
        border-color: #26364f;
        box-shadow: 0 0 0 3px rgba(38, 54, 79, 0.08);
    }

    .hardware-toolbar-button {
        height: 36px;
        padding: 0 12px;
        border-radius: 8px;
        border: 1px solid #dfe3ea;
        background: #ffffff;
        color: #465166;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: 0.2s ease;
        white-space: nowrap;
    }

    .hardware-toolbar-button:hover {
        background: #f7f8fa;
        border-color: #cdd3dd;
    }

    .hardware-add-button {
        border-color: #071b88;
        background: #071b88;
        color: #ffffff;
    }

    .hardware-add-button:hover {
        background: #050f63;
        border-color: #050f63;
    }


    /* =====================================================
       FILTER
    ===================================================== */

    .hardware-filter-wrapper {
        position: relative;
    }

    .hardware-filter-menu {
        position: absolute;
        right: 0;
        top: calc(100% + 7px);
        width: 220px;
        padding: 12px;
        background: #ffffff;
        border: 1px solid #e5e8ee;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(16, 24, 40, 0.12);
        display: none;
        z-index: 100;
    }

    .hardware-filter-menu.active {
        display: block;
    }

    .hardware-filter-menu label {
        display: block;
        margin-bottom: 6px;
        font-size: 11px;
        font-weight: 600;
        color: #596274;
    }

    .hardware-filter-menu select {
        width: 100%;
        height: 34px;
        padding: 0 8px;
        border: 1px solid #dfe3ea;
        border-radius: 7px;
        background: #ffffff;
        color: #374151;
        font-size: 11px;
        outline: none;
    }

    .hardware-filter-menu select:focus {
        border-color: #26364f;
    }

    .hardware-filter-reset {
        width: 100%;
        height: 32px;
        margin-top: 10px;
        border: 0;
        border-radius: 7px;
        background: #f1f3f6;
        color: #4b5563;
        font-size: 11px;
        font-weight: 600;
        cursor: pointer;
    }

    .hardware-filter-reset:hover {
        background: #e7eaf0;
    }


    /* =====================================================
       TABLE
    ===================================================== */

    .hardware-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .hardware-table {
        width: 100%;
        min-width: 1250px;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .hardware-table thead th {
        height: 52px;
        padding: 0 12px;
        background: #fafbfc;
        border-bottom: 1px solid #e8ebf0;
        color: #697386;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.02em;
        text-align: left;
        white-space: nowrap;
    }

    .hardware-table tbody td {
        padding: 13px 12px;
        border-bottom: 1px solid #f0f2f5;
        color: #3f4859;
        font-size: 11px;
        vertical-align: middle;
    }

    .hardware-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .hardware-table tbody tr:hover {
        background: #fafbfd;
    }

    .hardware-table th:nth-child(1),
    .hardware-table td:nth-child(1) {
        width: 11%;
    }

    .hardware-table th:nth-child(2),
    .hardware-table td:nth-child(2) {
        width: 17%;
    }

    .hardware-table th:nth-child(3),
    .hardware-table td:nth-child(3) {
        width: 14%;
    }

    .hardware-table th:nth-child(4),
    .hardware-table td:nth-child(4) {
        width: 12%;
    }

    .hardware-table th:nth-child(5),
    .hardware-table td:nth-child(5) {
        width: 10%;
    }

    .hardware-table th:nth-child(6),
    .hardware-table td:nth-child(6) {
        width: 10%;
    }

    .hardware-table th:nth-child(7),
    .hardware-table td:nth-child(7) {
        width: 10%;
    }

    .hardware-table th:nth-child(8),
    .hardware-table td:nth-child(8) {
        width: 8%;
    }

    .hardware-table th:nth-child(9),
    .hardware-table td:nth-child(9) {
        width: 8%;
    }


    /* =====================================================
       TABLE CONTENT
    ===================================================== */

    .hardware-asset-id {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-weight: 700;
        color: #26364f;
        white-space: nowrap;
    }

    .hardware-asset-id i {
        color: #071b88;
        font-size: 10px;
    }

    .hardware-name {
        font-weight: 600;
        color: #30394b;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .hardware-spec {
        color: #687386;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .hardware-type {
        color: #596274;
    }

    .hardware-year {
        white-space: nowrap;
        color: #596274;
    }

    .hardware-price {
        white-space: nowrap;
        font-weight: 600;
        color: #374151;
    }


    /* =====================================================
       BADGES
    ===================================================== */

    .hardware-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        max-width: 100%;
        min-height: 25px;
        padding: 4px 8px;
        border-radius: 999px;
        font-size: 9px;
        font-weight: 700;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .hardware-condition-baru {
        background: #eaf9f0;
        color: #15803d;
    }

    .hardware-condition-baik {
        background: #eaf2ff;
        color: #2563eb;
    }

    .hardware-condition-perbaikan {
        background: #fff3df;
        color: #b45309;
    }

    .hardware-condition-rusak {
        background: #feecec;
        color: #dc2626;
    }

    .hardware-condition-default {
        background: #f1f3f6;
        color: #667085;
    }

    .hardware-verification-menunggu {
        background: #fff7df;
        color: #b7791f;
    }

    .hardware-verification-disetujui {
        background: #eaf9f0;
        color: #15803d;
    }

    .hardware-verification-ditolak {
        background: #feecec;
        color: #dc2626;
    }

    .hardware-verification-default {
        background: #f1f3f6;
        color: #667085;
    }


    /* =====================================================
       COMMENT
    ===================================================== */

    .hardware-comment {
        max-width: 150px;
        color: #7a8495;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .hardware-comment.empty {
        color: #b0b7c3;
        font-style: italic;
    }


    /* =====================================================
       ACTION
    ===================================================== */

    .hardware-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        white-space: nowrap;
    }

    .hardware-action-button {
        width: 30px;
        height: 30px;
        min-width: 30px;
        padding: 0;
        border-radius: 7px;
        border: 1px solid #e0e4ea;
        background: #ffffff;
        color: #5f697a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .hardware-action-button i {
        font-size: 12px;
    }

    .hardware-edit-button:hover {
        background: #eef4ff;
        border-color: #c8d8ff;
        color: #2563eb;
    }

    .hardware-delete-button:hover {
        background: #fff0f0;
        border-color: #fecaca;
        color: #dc2626;
    }


    /* =====================================================
       EMPTY STATE
    ===================================================== */

    .hardware-empty {
        padding: 55px 20px !important;
        text-align: center;
    }

    .hardware-empty-icon {
        width: 52px;
        height: 52px;
        margin: 0 auto 12px;
        border-radius: 50%;
        background: #f2f4f7;
        color: #98a2b3;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .hardware-empty-title {
        margin: 0;
        font-size: 13px;
        font-weight: 700;
        color: #4b5563;
    }

    .hardware-empty-text {
        margin: 5px 0 0;
        font-size: 11px;
        color: #98a2b3;
    }


    /* =====================================================
       PAGINATION
    ===================================================== */

    .hardware-pagination {
        padding: 14px 18px;
        border-top: 1px solid #edf0f4;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .hardware-pagination-info {
        font-size: 10px;
        color: #8a93a3;
    }

    .hardware-pagination-links {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .hardware-pagination-links a,
    .hardware-pagination-links span {
        min-width: 28px;
        height: 28px;
        padding: 0 8px;
        border-radius: 6px;
        border: 1px solid #e0e4ea;
        background: #ffffff;
        color: #596274;
        text-decoration: none;
        font-size: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .hardware-pagination-links a:hover {
        background: #f5f7fa;
    }

    .hardware-pagination-links .active {
        background: #26364f;
        border-color: #26364f;
        color: #ffffff;
    }


    /* =====================================================
       MODAL OVERLAY
    ===================================================== */

    .hardware-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        z-index: 9999;
        overflow: hidden;
    }

    .hardware-modal-overlay.active {
        display: flex;
    }


    /* =====================================================
       MODAL
    ===================================================== */

    .hardware-modal {
        width: min(1050px, 100%);

        height: min(720px, calc(100vh - 40px));
        max-height: calc(100vh - 40px);

        background: #ffffff;

        border-radius: 15px;

        box-shadow:
            0 25px 60px rgba(15, 23, 42, 0.20);

        overflow: hidden;

        display: flex;
        flex-direction: column;

        min-height: 0;
    }


    /* =====================================================
       FIX SCROLL POPUP
       SATU-SATUNYA BAGIAN YANG DITAMBAHKAN
    ===================================================== */

    .hardware-modal > form {
        display: flex;
        flex-direction: column;

        flex: 1 1 auto;

        min-height: 0;
        height: 100%;

        overflow: hidden;
    }


    .hardware-modal-header {
        min-height: 70px;

        padding: 15px 20px;

        border-bottom: 1px solid #edf0f4;

        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 15px;

        flex: 0 0 auto;
    }

    .hardware-modal-title-wrapper {
        display: flex;
        align-items: center;

        gap: 12px;

        min-width: 0;
    }

    .hardware-modal-icon {
        width: 40px;
        height: 40px;

        min-width: 40px;

        border-radius: 10px;

        background: #eaf2ff;
        color: #2563eb;

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 18px;
    }

    .hardware-modal-title {
        min-width: 0;
    }

    .hardware-modal-title h3 {
        margin: 0;

        font-size: 17px;
        font-weight: 700;

        color: #172033;
    }

    .hardware-modal-title p {
        margin: 4px 0 0;

        font-size: 11px;

        color: #8a93a3;
    }

    .hardware-modal-close {
        width: 32px;
        height: 32px;

        min-width: 32px;

        border: 0;
        border-radius: 7px;

        background: #f3f4f6;
        color: #667085;

        cursor: pointer;

        display: flex;
        align-items: center;
        justify-content: center;

        transition: 0.2s ease;
    }

    .hardware-modal-close:hover {
        background: #e8eaee;
        color: #374151;
    }


    /* =====================================================
       MODAL BODY
       FIX SCROLL
    ===================================================== */

    .hardware-modal-body {
        flex: 1 1 0%;

        min-height: 0;

        height: 0;

        overflow-y: scroll;
        overflow-x: hidden;

        padding: 20px;

        overscroll-behavior: contain;

        -webkit-overflow-scrolling: touch;

        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 transparent;
    }


    .hardware-modal-body::-webkit-scrollbar {
        width: 7px;
    }

    .hardware-modal-body::-webkit-scrollbar-track {
        background: transparent;
    }

    .hardware-modal-body::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .hardware-modal-body::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }


    /* =====================================================
       FORM SECTION
    ===================================================== */

    .hardware-form-section {
        padding: 17px;

        margin-bottom: 15px;

        background: #ffffff;

        border: 1px solid #e7eaf0;

        border-radius: 14px;

        box-shadow:
            0 2px 8px rgba(16, 24, 40, 0.025);
    }

    .hardware-form-section:last-child {
        margin-bottom: 0;
    }

    .hardware-form-section-title {
        margin: 0 0 14px;

        font-size: 13px;
        font-weight: 700;

        color: #26364f;
    }

    .hardware-form-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 15px;
    }

    .hardware-form-group {
        min-width: 0;
    }

    .hardware-form-group.full {
        grid-column: 1 / -1;
    }

    .hardware-form-label {
        display: block;

        margin-bottom: 7px;

        font-size: 11px;
        font-weight: 700;

        color: #4b5563;
    }

    .hardware-required {
        color: #dc2626;
    }

    .hardware-form-control {
        width: 100%;
        height: 40px;

        padding: 0 11px;

        border: 1px solid #dfe3ea;

        border-radius: 8px;

        outline: none;

        background: #ffffff;

        color: #30394b;

        font-size: 11px;

        transition: 0.2s ease;

        box-sizing: border-box;
    }

    textarea.hardware-form-control {
        height: 100px;

        padding-top: 10px;
        padding-bottom: 10px;

        resize: vertical;

        line-height: 1.5;
    }

    .hardware-form-control:focus {
        border-color: #26364f;

        box-shadow:
            0 0 0 3px rgba(38, 54, 79, 0.08);
    }

    .hardware-form-control.is-invalid {
        border-color: #dc2626;
    }

    .hardware-form-control[readonly] {
        background: #f8fafc;

        color: #667085;

        cursor: not-allowed;
    }

    .hardware-form-error {
        margin-top: 5px;

        font-size: 10px;

        color: #dc2626;
    }


    /* =====================================================
       AUTO ASSET ID
    ===================================================== */

    .hardware-auto-id {
        width: 100%;
        height: 40px;

        padding: 0 11px;

        box-sizing: border-box;

        border: 1px solid #e5e7eb;

        border-radius: 8px;

        background: #f8fafc;

        color: #8a93a3;

        font-size: 11px;

        display: flex;
        align-items: center;

        gap: 7px;
    }

    .hardware-auto-id i {
        color: #071b88;

        font-size: 13px;
    }

    .hardware-readonly-help {
        display: block;

        margin-top: 5px;

        font-size: 10px;

        color: #98a2b3;
    }


    /* =====================================================
       MODAL FOOTER
    ===================================================== */

    .hardware-modal-footer {
        min-height: 66px;

        padding: 13px 20px;

        border-top: 1px solid #edf0f4;

        background: #ffffff;

        display: flex;
        align-items: center;
        justify-content: flex-end;

        gap: 8px;

        flex: 0 0 auto;
    }

    .hardware-modal-button {
        height: 36px;

        padding: 0 15px;

        border-radius: 8px;

        border: 1px solid #dfe3ea;

        background: #ffffff;

        color: #596274;

        font-size: 11px;
        font-weight: 600;

        cursor: pointer;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        gap: 6px;
    }

    .hardware-modal-button:hover {
        background: #f6f7f9;
    }

    .hardware-modal-submit {
        border-color: #071b88;

        background: #071b88;

        color: #ffffff;
    }

    .hardware-modal-submit:hover {
        background: #050f63;

        border-color: #050f63;
    }


    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 1200px) {

        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .hardware-table {
            min-width: 1200px;
        }
    }

    @media (max-width: 800px) {

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .hardware-table-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .hardware-table-toolbar {
            width: 100%;
            flex-wrap: wrap;
        }

        .hardware-search {
            width: min(100%, 300px);
        }

        .hardware-form-grid {
            grid-template-columns: 1fr;
        }

        .hardware-form-group.full {
            grid-column: auto;
        }

        .hardware-pagination {
            align-items: flex-start;
            flex-direction: column;
        }

        .hardware-modal {
            height: calc(100vh - 20px);
            max-height: calc(100vh - 20px);
        }
    }

    @media (max-width: 500px) {

        .hardware-page-header h2 {
            font-size: 21px;
        }

        .hardware-table-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .hardware-search {
            width: 100%;
        }

        .hardware-toolbar-button,
        .hardware-add-button {
            width: 100%;
        }

        .hardware-filter-wrapper {
            width: 100%;
        }

        .hardware-filter-wrapper > .hardware-toolbar-button {
            width: 100%;
        }

        .hardware-filter-menu {
            left: 0;
            right: auto;
            width: 100%;
        }

        .hardware-modal-overlay {
            padding: 10px;
        }

        .hardware-modal-header {
            padding: 14px 15px;
        }

        .hardware-modal-body {
            padding: 15px;
        }

        .hardware-modal-footer {
            padding: 12px 15px;
        }

        .hardware-form-section {
            padding: 14px;
        }

        .hardware-modal-title h3 {
            font-size: 15px;
        }
    }
</style>


<div class="hardware-page">

    <div class="hardware-page-header">

        <h2>Hardware</h2>

        <p>
            Kelola dan pantau seluruh aset hardware yang tersedia.
        </p>

    </div>


    @if(session('success'))

        <div class="hardware-alert hardware-alert-success">

            <i class="bi bi-check-circle-fill"></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    @if(session('error'))

        <div class="hardware-alert hardware-alert-error">

            <i class="bi bi-exclamation-circle-fill"></i>

            <span>
                {{ session('error') }}
            </span>

        </div>

    @endif


    @if($errors->any())

        <div class="hardware-alert hardware-alert-error">

            <i class="bi bi-exclamation-triangle-fill"></i>

            <div>

                <strong>Terjadi kesalahan.</strong>

                <ul style="margin:4px 0 0 18px;padding:0;">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        </div>

    @endif


    @php

        $hardwareData = $hardwares->getCollection();

        $jumlahBarang = $hardwares->total();

        $hargaBarang = $hardwareData->sum(function ($hardware) {
            return (float) ($hardware->harga ?? 0);
        });

        $perluPerbaikan = $hardwareData->filter(function ($hardware) {

            return strtolower(trim($hardware->kondisi ?? '')) === 'perlu perbaikan';

        })->count();

        $rusak = $hardwareData->filter(function ($hardware) {

            return strtolower(trim($hardware->kondisi ?? '')) === 'rusak';

        })->count();

        $tersedia = $hardwareData->filter(function ($hardware) {

            $kondisi = strtolower(trim($hardware->kondisi ?? ''));

            return in_array($kondisi, [
                'baru',
                'baik'
            ]);

        })->count();

        $tahunTerbaru = $hardwareData
            ->pluck('tahun_pembelian')
            ->filter()
            ->max();

    @endphp


    <div class="stats-grid">

        <div class="stat-card">

            <div class="stat-icon blue">
                <i class="bi bi-pc-display"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Jumlah Barang
                </span>

                <span class="stat-value">
                    {{ $jumlahBarang }}
                </span>

                <span class="stat-description">
                    Total aset hardware
                </span>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon purple">
                <i class="bi bi-cash-stack"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Harga Barang
                </span>

                <span class="stat-value currency">
                    Rp {{ number_format($hargaBarang, 0, ',', '.') }}
                </span>

                <span class="stat-description">
                    Total nilai hardware
                </span>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon orange">
                <i class="bi bi-tools"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Perlu Perbaikan
                </span>

                <span class="stat-value">
                    {{ $perluPerbaikan }}
                </span>

                <span class="stat-description">
                    Hardware perlu diperbaiki
                </span>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon red">
                <i class="bi bi-x-octagon-fill"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Rusak
                </span>

                <span class="stat-value">
                    {{ $rusak }}
                </span>

                <span class="stat-description">
                    Hardware dalam kondisi rusak
                </span>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon green">
                <i class="bi bi-check-circle-fill"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Tersedia
                </span>

                <span class="stat-value">
                    {{ $tersedia }}
                </span>

                <span class="stat-description">
                    Hardware siap digunakan
                </span>

            </div>

        </div>


        <div class="stat-card">

            <div class="stat-icon cyan">
                <i class="bi bi-calendar3"></i>
            </div>

            <div class="stat-content">

                <span class="stat-label">
                    Tahun Pembelian Terbaru
                </span>

                <span class="stat-value">
                    {{ $tahunTerbaru ?: '-' }}
                </span>

                <span class="stat-description">
                    Tahun pembelian terakhir
                </span>

            </div>

        </div>

    </div>


    <div class="hardware-table-card">

        <div class="hardware-table-header">

            <div class="hardware-table-title">

                <h3>
                    Daftar Hardware
                </h3>

                <p>
                    Menampilkan
                    <strong>{{ $hardwares->count() }}</strong>
                    dari
                    <strong>{{ $hardwares->total() }}</strong>
                    data hardware
                </p>

            </div>


            <div class="hardware-table-toolbar">

                <form
                    method="GET"
                    action="{{ route('hardware.index') }}"
                    class="hardware-search"
                >

                    <i class="bi bi-search"></i>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari hardware..."
                        autocomplete="off"
                    >

                </form>


                <div class="hardware-filter-wrapper">

                    <button
                        type="button"
                        class="hardware-toolbar-button"
                        onclick="toggleHardwareFilter(event)"
                    >

                        <i class="bi bi-funnel"></i>

                        Filter

                    </button>


                    <div
                        class="hardware-filter-menu"
                        id="hardwareFilterMenu"
                    >

                        <label for="hardwareConditionFilter">
                            Kondisi
                        </label>

                        <select id="hardwareConditionFilter">

                            <option value="">
                                Semua Kondisi
                            </option>

                            <option value="baru">
                                Baru
                            </option>

                            <option value="baik">
                                Baik
                            </option>

                            <option value="perlu perbaikan">
                                Perlu Perbaikan
                            </option>

                            <option value="rusak">
                                Rusak
                            </option>

                        </select>


                        <button
                            type="button"
                            class="hardware-filter-reset"
                            onclick="resetHardwareFilter()"
                        >
                            Reset Filter
                        </button>

                    </div>

                </div>


                <button
                    type="button"
                    class="hardware-toolbar-button hardware-add-button"
                    onclick="openCreateHardwareModal()"
                >

                    <i class="bi bi-plus-lg"></i>

                    Tambah Hardware

                </button>

            </div>

        </div>


        <div class="hardware-table-wrapper">

            <table class="hardware-table">

                <thead>

                    <tr>

                        <th>
                            Asset ID
                        </th>

                        <th>
                            Nama Barang
                        </th>

                        <th>
                            Spesifikasi
                        </th>

                        <th>
                            Jenis Barang
                        </th>

                        <th>
                            Tahun Pembelian
                        </th>

                        <th>
                            Harga
                        </th>

                        <th>
                            Kondisi
                        </th>

                        <th>
                            Verifikasi
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($hardwares as $hardware)

                        @php

                            $kondisi = strtolower(
                                trim($hardware->kondisi ?? '')
                            );

                            $verificationRequest =
                                $hardware->latestVerificationRequest;

                            $verifikasi = strtolower(
                                trim(
                                    $verificationRequest?->status
                                    ?? 'menunggu'
                                )
                            );

                            $komentar =
                                $verificationRequest?->rejection_reason
                                ?? null;

                            $conditionClass = match ($kondisi) {

                                'baru' =>
                                    'hardware-condition-baru',

                                'baik' =>
                                    'hardware-condition-baik',

                                'perlu perbaikan' =>
                                    'hardware-condition-perbaikan',

                                'rusak' =>
                                    'hardware-condition-rusak',

                                default =>
                                    'hardware-condition-default',

                            };

                            $verificationClass = match ($verifikasi) {

                                'menunggu' =>
                                    'hardware-verification-menunggu',

                                'disetujui' =>
                                    'hardware-verification-disetujui',

                                'ditolak' =>
                                    'hardware-verification-ditolak',

                                default =>
                                    'hardware-verification-default',

                            };

                        @endphp


                        <tr
                            data-hardware-condition="{{ $kondisi }}"
                        >

                            <td>

                                <span class="hardware-asset-id">

                                    <i class="bi bi-hash"></i>

                                    {{ $hardware->asset_id }}

                                </span>

                            </td>


                            <td>

                                <div
                                    class="hardware-name"
                                    title="{{ $hardware->nama_barang }}"
                                >
                                    {{ $hardware->nama_barang }}
                                </div>

                            </td>


                            <td>

                                <div
                                    class="hardware-spec"
                                    title="{{ $hardware->spesifikasi }}"
                                >
                                    {{ $hardware->spesifikasi }}
                                </div>

                            </td>


                            <td>

                                <span class="hardware-type">
                                    {{ $hardware->jenis_barang }}
                                </span>

                            </td>


                            <td>

                                <span class="hardware-year">
                                    {{ $hardware->tahun_pembelian }}
                                </span>

                            </td>


                            <td>

                                <span class="hardware-price">

                                    Rp
                                    {{ number_format((float) ($hardware->harga ?? 0), 0, ',', '.') }}

                                </span>

                            </td>


                            <td>

                                <span
                                    class="hardware-badge {{ $conditionClass }}"
                                >
                                    {{ $hardware->kondisi }}
                                </span>

                            </td>


                            <td>

                                <span
                                    class="hardware-badge {{ $verificationClass }}"
                                >
                                    {{ ucfirst($verifikasi) }}
                                </span>

                            </td>


                            <td>

                                <div class="hardware-actions">

                                    <button
                                        type="button"
                                        class="hardware-action-button hardware-edit-button"
                                        title="Edit"

                                        data-asset-id="{{ $hardware->asset_id }}"
                                        data-nama-barang="{{ $hardware->nama_barang }}"
                                        data-spesifikasi="{{ $hardware->spesifikasi }}"
                                        data-jenis-barang="{{ $hardware->jenis_barang }}"
                                        data-tahun-pembelian="{{ $hardware->tahun_pembelian }}"
                                        data-harga="{{ $hardware->harga }}"
                                        data-kondisi="{{ $hardware->kondisi }}"

                                        onclick="openEditHardwareModal(this); return false;"
                                    >

                                        <i class="bi bi-pencil-fill"></i>

                                    </button>


                                    <form
                                        method="POST"
                                        action="{{ route('hardware.destroy', $hardware->asset_id) }}"
                                        onsubmit="return confirm('Yakin ingin mengajukan penghapusan hardware ini?');"
                                        style="margin:0;"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="hardware-action-button hardware-delete-button"
                                            title="Hapus"
                                        >

                                            <i class="bi bi-trash3-fill"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="9"
                                class="hardware-empty"
                            >

                                <div class="hardware-empty-icon">

                                    <i class="bi bi-inbox"></i>

                                </div>

                                <p class="hardware-empty-title">
                                    Belum ada data hardware
                                </p>

                                <p class="hardware-empty-text">
                                    Silakan tambahkan hardware baru untuk mulai mengelola aset.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($hardwares->hasPages())

            <div class="hardware-pagination">

                <div class="hardware-pagination-info">

                    Menampilkan

                    <strong>
                        {{ $hardwares->firstItem() }}
                    </strong>

                    -

                    <strong>
                        {{ $hardwares->lastItem() }}
                    </strong>

                    dari

                    <strong>
                        {{ $hardwares->total() }}
                    </strong>

                    data

                </div>


                <div class="hardware-pagination-links">

                    {{ $hardwares->onEachSide(1)->links('pagination::bootstrap-5') }}

                </div>

            </div>

        @endif

    </div>

</div>


{{-- =========================================================
     CREATE MODAL
========================================================= --}}

<div
    class="hardware-modal-overlay"
    id="createHardwareModal"
>

    <div
        class="hardware-modal"
        onclick="event.stopPropagation()"
    >

        <div class="hardware-modal-header">

            <div class="hardware-modal-title-wrapper">

                <div class="hardware-modal-icon">
                    <i class="bi bi-pc-display"></i>
                </div>

                <div class="hardware-modal-title">

                    <h3>
                        Tambah Hardware
                    </h3>

                    <p>
                        Tambahkan data hardware baru.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="hardware-modal-close"
                onclick="closeCreateHardwareModal()"
            >

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        <form
            method="POST"
            action="{{ route('hardware.store') }}"
            id="createHardwareForm"
        >

            @csrf


            <div class="hardware-modal-body">

                <div class="hardware-form-section">

                    <h4 class="hardware-form-section-title">
                        Informasi Hardware
                    </h4>


                    <div class="hardware-form-grid">

                        <div class="hardware-form-group">

                            <label class="hardware-form-label">
                                Asset ID
                            </label>

                            <div class="hardware-auto-id">

                                <i class="bi bi-magic"></i>

                                <span>
                                    Otomatis dibuat oleh sistem
                                </span>

                            </div>

                            <small class="hardware-readonly-help">
                                Asset ID akan dibuat otomatis saat data disimpan.
                            </small>

                        </div>


                        <div class="hardware-form-group">

                            <label
                                for="create_nama_barang"
                                class="hardware-form-label"
                            >

                                Nama Barang

                                <span class="hardware-required">
                                    *
                                </span>

                            </label>

                            <input
                                type="text"
                                id="create_nama_barang"
                                name="nama_barang"
                                class="hardware-form-control @error('nama_barang') is-invalid @enderror"
                                value="{{ old('nama_barang') }}"
                                placeholder="Contoh: Laptop"
                                required
                            >

                            @error('nama_barang')

                                <div class="hardware-form-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <div class="hardware-form-group">

                            <label
                                for="create_jenis_barang"
                                class="hardware-form-label"
                            >

                                Jenis Barang

                                <span class="hardware-required">
                                    *
                                </span>

                            </label>

                            <input
                                type="text"
                                id="create_jenis_barang"
                                name="jenis_barang"
                                class="hardware-form-control @error('jenis_barang') is-invalid @enderror"
                                value="{{ old('jenis_barang') }}"
                                placeholder="Contoh: Laptop"
                                required
                            >

                            @error('jenis_barang')

                                <div class="hardware-form-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <div class="hardware-form-group">

                            <label
                                for="create_kondisi"
                                class="hardware-form-label"
                            >

                                Kondisi

                                <span class="hardware-required">
                                    *
                                </span>

                            </label>

                            <select
                                id="create_kondisi"
                                name="kondisi"
                                class="hardware-form-control @error('kondisi') is-invalid @enderror"
                                required
                            >

                                <option value="">
                                    Pilih kondisi
                                </option>

                                <option
                                    value="Baru"
                                    {{ old('kondisi') === 'Baru' ? 'selected' : '' }}
                                >
                                    Baru
                                </option>

                                <option
                                    value="Baik"
                                    {{ old('kondisi') === 'Baik' ? 'selected' : '' }}
                                >
                                    Baik
                                </option>

                                <option
                                    value="Perlu Perbaikan"
                                    {{ old('kondisi') === 'Perlu Perbaikan' ? 'selected' : '' }}
                                >
                                    Perlu Perbaikan
                                </option>

                                <option
                                    value="Rusak"
                                    {{ old('kondisi') === 'Rusak' ? 'selected' : '' }}
                                >
                                    Rusak
                                </option>

                            </select>

                            @error('kondisi')

                                <div class="hardware-form-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>


                <div class="hardware-form-section">

                    <h4 class="hardware-form-section-title">
                        Detail Pembelian
                    </h4>


                    <div class="hardware-form-grid">

                        <div class="hardware-form-group">

                            <label
                                for="create_tahun_pembelian"
                                class="hardware-form-label"
                            >

                                Tahun Pembelian

                                <span class="hardware-required">
                                    *
                                </span>

                            </label>

                            <input
                                type="number"
                                id="create_tahun_pembelian"
                                name="tahun_pembelian"
                                class="hardware-form-control @error('tahun_pembelian') is-invalid @enderror"
                                value="{{ old('tahun_pembelian') }}"
                                placeholder="Contoh: 2025"
                                min="1900"
                                max="2100"
                                required
                            >

                            @error('tahun_pembelian')

                                <div class="hardware-form-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <div class="hardware-form-group">

                            <label
                                for="create_harga"
                                class="hardware-form-label"
                            >

                                Harga

                                <span class="hardware-required">
                                    *
                                </span>

                            </label>

                            <input
                                type="number"
                                id="create_harga"
                                name="harga"
                                class="hardware-form-control @error('harga') is-invalid @enderror"
                                value="{{ old('harga') }}"
                                placeholder="Contoh: 10000000"
                                min="0"
                                step="0.01"
                                required
                            >

                            @error('harga')

                                <div class="hardware-form-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>


                <div class="hardware-form-section">

                    <h4 class="hardware-form-section-title">
                        Spesifikasi
                    </h4>


                    <div class="hardware-form-grid">

                        <div class="hardware-form-group full">

                            <label
                                for="create_spesifikasi"
                                class="hardware-form-label"
                            >

                                Spesifikasi

                                <span class="hardware-required">
                                    *
                                </span>

                            </label>

                            <textarea
                                id="create_spesifikasi"
                                name="spesifikasi"
                                class="hardware-form-control @error('spesifikasi') is-invalid @enderror"
                                placeholder="Masukkan spesifikasi hardware..."
                                required
                            >{{ old('spesifikasi') }}</textarea>

                            @error('spesifikasi')

                                <div class="hardware-form-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            <div class="hardware-modal-footer">

                <button
                    type="button"
                    class="hardware-modal-button"
                    onclick="closeCreateHardwareModal()"
                >

                    Batal

                </button>


                <button
                    type="submit"
                    class="hardware-modal-button hardware-modal-submit"
                >

                    <i class="bi bi-check2"></i>

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================================================
     EDIT MODAL
========================================================= --}}

<div
    class="hardware-modal-overlay"
    id="editHardwareModal"
>

    <div
        class="hardware-modal"
        onclick="event.stopPropagation()"
    >

        <div class="hardware-modal-header">

            <div class="hardware-modal-title-wrapper">

                <div class="hardware-modal-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>

                <div class="hardware-modal-title">

                    <h3>
                        Edit Hardware
                    </h3>

                    <p>
                        Perbarui informasi hardware.
                    </p>

                </div>

            </div>


            <button
                type="button"
                class="hardware-modal-close"
                onclick="closeEditHardwareModal()"
            >

                <i class="bi bi-x-lg"></i>

            </button>

        </div>


        <form
            method="POST"
            action=""
            id="editHardwareForm"
        >

            @csrf

            @method('PUT')


            <div class="hardware-modal-body">

                <div class="hardware-form-section">

                    <h4 class="hardware-form-section-title">
                        Informasi Hardware
                    </h4>


                    <div class="hardware-form-grid">

                        <div class="hardware-form-group">

                            <label
                                for="edit_asset_id"
                                class="hardware-form-label"
                            >
                                Asset ID
                            </label>

                            <input
                                type="text"
                                id="edit_asset_id"
                                class="hardware-form-control"
                                readonly
                            >

                            <small class="hardware-readonly-help">
                                Asset ID dibuat otomatis dan tidak dapat diubah.
                            </small>

                        </div>


                        <div class="hardware-form-group">

                            <label
                                for="edit_nama_barang"
                                class="hardware-form-label"
                            >

                                Nama Barang

                                <span class="hardware-required">
                                    *
                                </span>

                            </label>

                            <input
                                type="text"
                                id="edit_nama_barang"
                                name="nama_barang"
                                class="hardware-form-control"
                                required
                            >

                        </div>


                        <div class="hardware-form-group">

                            <label
                                for="edit_jenis_barang"
                                class="hardware-form-label"
                            >

                                Jenis Barang

                                <span class="hardware-required">
                                    *
                                </span>

                            </label>

                            <input
                                type="text"
                                id="edit_jenis_barang"
                                name="jenis_barang"
                                class="hardware-form-control"
                                required
                            >

                        </div>


                        <div class="hardware-form-group">

                            <label
                                for="edit_kondisi"
                                class="hardware-form-label"
                            >

                                Kondisi

                                <span class="hardware-required">
                                    *
                                </span>

                            </label>

                            <select
                                id="edit_kondisi"
                                name="kondisi"
                                class="hardware-form-control"
                                required
                            >

                                <option value="">
                                    Pilih kondisi
                                </option>

                                <option value="Baru">
                                    Baru
                                </option>

                                <option value="Baik">
                                    Baik
                                </option>

                                <option value="Perlu Perbaikan">
                                    Perlu Perbaikan
                                </option>

                                <option value="Rusak">
                                    Rusak
                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                <div class="hardware-form-section">

                    <h4 class="hardware-form-section-title">
                        Detail Pembelian
                    </h4>


                    <div class="hardware-form-grid">

                        <div class="hardware-form-group">

                            <label
                                for="edit_tahun_pembelian"
                                class="hardware-form-label"
                            >

                                Tahun Pembelian

                                <span class="hardware-required">
                                    *
                                </span>

                            </label>

                            <input
                                type="number"
                                id="edit_tahun_pembelian"
                                name="tahun_pembelian"
                                class="hardware-form-control"
                                min="1900"
                                max="2100"
                                required
                            >

                        </div>


                        <div class="hardware-form-group">

                            <label
                                for="edit_harga"
                                class="hardware-form-label"
                            >

                                Harga

                                <span class="hardware-required">
                                    *
                                </span>

                            </label>

                            <input
                                type="number"
                                id="edit_harga"
                                name="harga"
                                class="hardware-form-control"
                                min="0"
                                step="0.01"
                                required
                            >

                        </div>

                    </div>

                </div>


                <div class="hardware-form-section">

                    <h4 class="hardware-form-section-title">
                        Spesifikasi
                    </h4>


                    <div class="hardware-form-grid">

                        <div class="hardware-form-group full">

                            <label
                                for="edit_spesifikasi"
                                class="hardware-form-label"
                            >

                                Spesifikasi

                                <span class="hardware-required">
                                    *
                                </span>

                            </label>

                            <textarea
                                id="edit_spesifikasi"
                                name="spesifikasi"
                                class="hardware-form-control"
                                placeholder="Masukkan spesifikasi hardware..."
                                required
                            ></textarea>

                        </div>

                    </div>

                </div>

            </div>


            <div class="hardware-modal-footer">

                <button
                    type="button"
                    class="hardware-modal-button"
                    onclick="closeEditHardwareModal()"
                >

                    Batal

                </button>


                <button
                    type="submit"
                    class="hardware-modal-button hardware-modal-submit"
                >

                    <i class="bi bi-check2"></i>

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>


<script>
    /* =====================================================
       CREATE MODAL
    ===================================================== */

    function openCreateHardwareModal() {

        const modal =
            document.getElementById('createHardwareModal');

        if (!modal) {
            return;
        }

        modal.classList.add('active');

        document.body.style.overflow = 'hidden';


        setTimeout(() => {

            const input =
                document.getElementById('create_nama_barang');

            if (input) {
                input.focus();
            }

        }, 100);
    }


    function closeCreateHardwareModal() {

        const modal =
            document.getElementById('createHardwareModal');

        if (!modal) {
            return;
        }

        modal.classList.remove('active');

        document.body.style.overflow = '';

    }


    /* =====================================================
       EDIT MODAL
    ===================================================== */

    function openEditHardwareModal(button) {

        if (!button) {
            return;
        }


        const modal =
            document.getElementById('editHardwareModal');

        const form =
            document.getElementById('editHardwareForm');

        if (!modal || !form) {
            return;
        }


        const assetId =
            button.dataset.assetId || '';

        const namaBarang =
            button.dataset.namaBarang || '';

        const spesifikasi =
            button.dataset.spesifikasi || '';

        const jenisBarang =
            button.dataset.jenisBarang || '';

        const tahunPembelian =
            button.dataset.tahunPembelian || '';

        const harga =
            button.dataset.harga || '';

        const kondisi =
            button.dataset.kondisi || '';


        document.getElementById('edit_asset_id').value =
            assetId;

        document.getElementById('edit_nama_barang').value =
            namaBarang;

        document.getElementById('edit_spesifikasi').value =
            spesifikasi;

        document.getElementById('edit_jenis_barang').value =
            jenisBarang;

        document.getElementById('edit_tahun_pembelian').value =
            tahunPembelian;

        document.getElementById('edit_harga').value =
            harga;

        document.getElementById('edit_kondisi').value =
            kondisi;


        form.action =
            "{{ url('/hardware') }}/" +
            encodeURIComponent(assetId);


        modal.classList.add('active');

        document.body.style.overflow = 'hidden';


        setTimeout(() => {

            const input =
                document.getElementById('edit_nama_barang');

            if (input) {
                input.focus();
            }

        }, 100);

    }


    function closeEditHardwareModal() {

        const modal =
            document.getElementById('editHardwareModal');

        if (!modal) {
            return;
        }

        modal.classList.remove('active');

        document.body.style.overflow = '';

    }


    /* =====================================================
       FILTER
    ===================================================== */

    function toggleHardwareFilter(event) {

        if (event) {
            event.stopPropagation();
        }


        const menu =
            document.getElementById('hardwareFilterMenu');

        if (!menu) {
            return;
        }

        menu.classList.toggle('active');

    }


    function resetHardwareFilter() {

        const select =
            document.getElementById('hardwareConditionFilter');

        if (select) {
            select.value = '';
        }

        filterHardwareRows();

    }


    function filterHardwareRows() {

        const select =
            document.getElementById(
                'hardwareConditionFilter'
            );

        const selected =
            select
                ? select.value.toLowerCase().trim()
                : '';


        const rows =
            document.querySelectorAll(
                '.hardware-table tbody tr[data-hardware-condition]'
            );


        rows.forEach(row => {

            const condition =
                (row.dataset.hardwareCondition || '')
                    .toLowerCase()
                    .trim();


            if (!selected || condition === selected) {

                row.style.display = '';

            } else {

                row.style.display = 'none';

            }

        });

    }


    /* =====================================================
       SEARCH
    ===================================================== */

    const hardwareSearchInput =
        document.querySelector(
            '.hardware-search input'
        );


    if (hardwareSearchInput) {

        hardwareSearchInput.addEventListener(
            'keydown',
            function(event) {

                if (event.key === 'Enter') {

                    event.preventDefault();

                    this.form.submit();

                }

            }
        );

    }


    /* =====================================================
       FILTER CHANGE
    ===================================================== */

    const hardwareConditionFilter =
        document.getElementById(
            'hardwareConditionFilter'
        );


    if (hardwareConditionFilter) {

        hardwareConditionFilter.addEventListener(
            'change',
            filterHardwareRows
        );

    }


    /* =====================================================
       CLICK OUTSIDE FILTER
    ===================================================== */

    document.addEventListener(
        'click',
        function(event) {

            const wrapper =
                document.querySelector(
                    '.hardware-filter-wrapper'
                );

            const menu =
                document.getElementById(
                    'hardwareFilterMenu'
                );


            if (!wrapper || !menu) {
                return;
            }


            if (!wrapper.contains(event.target)) {

                menu.classList.remove('active');

            }

        }
    );


    /* =====================================================
       CLICK OUTSIDE CREATE MODAL
    ===================================================== */

    const createModal =
        document.getElementById(
            'createHardwareModal'
        );


    if (createModal) {

        createModal.addEventListener(
            'click',
            function(event) {

                if (event.target === createModal) {

                    closeCreateHardwareModal();

                }

            }
        );

    }


    /* =====================================================
       CLICK OUTSIDE EDIT MODAL
    ===================================================== */

    const editModal =
        document.getElementById(
            'editHardwareModal'
        );


    if (editModal) {

        editModal.addEventListener(
            'click',
            function(event) {

                if (event.target === editModal) {

                    closeEditHardwareModal();

                }

            }
        );

    }


    /* =====================================================
       ESC KEY
    ===================================================== */

    document.addEventListener(
        'keydown',
        function(event) {

            if (event.key !== 'Escape') {
                return;
            }


            closeCreateHardwareModal();

            closeEditHardwareModal();


            const filterMenu =
                document.getElementById(
                    'hardwareFilterMenu'
                );


            if (filterMenu) {

                filterMenu.classList.remove('active');

            }

        }
    );


    /* =====================================================
       AUTO OPEN CREATE MODAL AFTER VALIDATION ERROR
    ===================================================== */

    @if($errors->any() && old('_token') && !old('_method'))

        document.addEventListener(
            'DOMContentLoaded',
            function() {

                openCreateHardwareModal();

            }
        );

    @endif
</script>

@endsection
@extends('layouts.app')

@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('content')

<style>
    /* =========================================================
       BASE
    ========================================================= */

    .user-dashboard {
        width: 100%;
        box-sizing: border-box;
    }

    .breadcrumb {
        font-size: 20px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 4px;
    }

    .breadcrumb .sep {
        color: #9ca3af;
        margin: 0 6px;
        font-weight: 400;
    }

    .breadcrumb .current {
        color: #6b7280;
        font-weight: 700;
    }

    .welcome-text {
        font-size: 13px;
        color: #6b7280;
        margin: 0 0 22px;
    }

    /* =========================================================
       ALERT
    ========================================================= */

    .alert {
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 13px;
        margin-bottom: 18px;
        border: 1px solid transparent;
    }

    .alert-error {
        background: #fef2f2;
        color: #991b1b;
        border-color: #fecaca;
    }

    /* =========================================================
       STATISTICS
    ========================================================= */

    .stats-grid {
        width: 100%;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 22px;
        box-sizing: border-box;
    }

    .stat-card {
        min-width: 0;
        min-height: 110px;
        background: #ffffff;
        border: 1px solid #eef0f4;
        border-radius: 14px;
        padding: 18px 20px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        gap: 15px;
        box-sizing: border-box;
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

    .stat-card.total .stat-icon {
        background: #fff7ed;
        color: #f97316;
    }

    .stat-card.aktif .stat-icon {
        background: #ecfdf3;
        color: #16a34a;
    }

    .stat-card.nonaktif .stat-icon {
        background: #fef2f2;
        color: #dc2626;
    }

    .stat-content {
        min-width: 0;
    }

    .stat-label {
        display: block;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        margin-bottom: 5px;
    }

    .stat-value {
        display: block;
        font-size: 25px;
        line-height: 1.1;
        font-weight: 700;
        color: #1f2937;
    }

    /* =========================================================
       MAIN CARD
    ========================================================= */

    .table-card {
        width: 100%;
        background: #ffffff;
        border: 1px solid #eef0f4;
        border-radius: 14px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
        box-sizing: border-box;
        overflow: visible;
    }

    /* =========================================================
       TOOLBAR
    ========================================================= */

    .toolbar {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 18px;
        box-sizing: border-box;
    }

    .search-box {
        flex: 1;
        min-width: 0;
        height: 40px;
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 9px;
        padding: 0 13px;
        box-sizing: border-box;
    }

    .search-box i {
        color: #9ca3af;
        font-size: 14px;
    }

    .search-box input {
        width: 100%;
        min-width: 0;
        border: none;
        outline: none;
        background: transparent;
        color: #374151;
        font-size: 13px;
    }

    .search-box input::placeholder {
        color: #9ca3af;
    }

    .btn-outline,
    .btn-primary,
    .btn-secondary {
        height: 40px;
        padding: 0 15px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        box-sizing: border-box;
        white-space: nowrap;
    }

    .btn-outline {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        color: #374151;
    }

    .btn-outline:hover {
        background: #f8fafc;
        border-color: #d1d5db;
    }

    .btn-primary {
        background: #071b88;
        color: #ffffff;
        border: 1px solid #071b88;
    }

    .btn-primary:hover {
        background: #05146b;
        border-color: #05146b;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
        border: 1px solid #f3f4f6;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    /* =========================================================
       FILTER
    ========================================================= */

    .filter-wrapper {
        position: relative;
        flex-shrink: 0;
    }

    .filter-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        width: 230px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        padding: 16px;
        z-index: 100;
        box-sizing: border-box;
    }

    .filter-dropdown.show {
        display: block;
    }

    .filter-label {
        display: block;
        font-size: 10px;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: .03em;
        margin: 10px 0 6px;
    }

    .filter-label:first-child {
        margin-top: 0;
    }

    .filter-select {
        width: 100%;
        height: 36px;
        padding: 0 10px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #374151;
        font-size: 12px;
        outline: none;
        box-sizing: border-box;
    }

    .filter-select:focus {
        border-color: #93c5fd;
    }

    .filter-apply {
        width: 100%;
        margin-top: 14px;
    }

    /* =========================================================
       TABLE
    ========================================================= */

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
        border-radius: 8px;
    }

    table.users-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    table.users-table th {
        text-align: left;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #9ca3af;
        padding: 0 10px 12px;
        border-bottom: 1px solid #eef0f4;
        white-space: nowrap;
    }

    table.users-table th:first-child,
    table.users-table td:first-child {
        padding-left: 8px;
    }

    table.users-table th:last-child,
    table.users-table td:last-child {
        padding-right: 8px;
    }

    table.users-table td {
        padding: 13px 10px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 12px;
        color: #374151;
        vertical-align: middle;
    }

    table.users-table tbody tr:last-child td {
        border-bottom: none;
    }

    table.users-table tbody tr:hover {
        background: #fafbfc;
    }

    .user-name {
        font-weight: 600;
        color: #1f2937;
    }

    .username-text {
        color: #6b7280;
    }

    .role-text {
        color: #4b5563;
        font-weight: 500;
    }

    /* =========================================================
       STATUS
    ========================================================= */

    .status-pill {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-aktif {
        background: #dcfce7;
        color: #16a34a;
    }

    .status-nonaktif {
        background: #fee2e2;
        color: #dc2626;
    }

    /* =========================================================
       ACTION BUTTON
    ========================================================= */

    .action-buttons {
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }

    .icon-btn {
        width: 32px;
        height: 32px;
        border: none;
        background: transparent;
        border-radius: 7px;
        cursor: pointer;
        font-size: 15px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background .15s ease;
    }

    .icon-btn:hover {
        background: #f3f4f6;
    }

    .icon-hakakses {
        color: #6b7280;
    }

    .icon-hakakses:hover {
        color: #374151;
    }

    .icon-activate {
        color: #16a34a;
    }

    .icon-deactivate {
        color: #dc2626;
    }

    .icon-delete {
        color: #dc2626;
    }

    /* =========================================================
       PAGINATION
    ========================================================= */

    .pagination-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid #f3f4f6;
    }

    .pagination-info {
        font-size: 11px;
        color: #9ca3af;
        white-space: nowrap;
    }

    .pagination-bar nav {
        margin-left: auto;
    }

    /* =========================================================
       MODAL TAMBAH / EDIT
    ========================================================= */

    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.58);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-box {
        width: 100%;
        max-width: 430px;
        max-height: 90vh;
        overflow-y: auto;
        background: #ffffff;
        border-radius: 15px;
        padding: 24px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.18);
        box-sizing: border-box;
    }

    .modal-box h3 {
        margin: 0 0 20px;
        font-size: 17px;
        font-weight: 700;
        color: #1f2937;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-size: 11px;
        color: #6b7280;
        margin-bottom: 6px;
        font-weight: 600;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        height: 40px;
        padding: 0 11px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #374151;
        font-size: 12px;
        outline: none;
        box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.08);
    }

    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 9px;
        margin-top: 22px;
    }

    /* =========================================================
       MODAL HAK AKSES
    ========================================================= */

    .hakakses-box {
        width: 100%;
        max-width: 680px;
        max-height: 88vh;
        overflow-y: auto;
        background: #ffffff;
        border-radius: 15px;
        padding: 24px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.18);
        box-sizing: border-box;
    }

    .hakakses-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 20px;
    }

    .hakakses-user {
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 0;
    }

    .hakakses-avatar {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: #f3f4f6;
        border: 1px solid #eef0f4;
        flex-shrink: 0;
    }

    .hakakses-name {
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
    }

    .hakakses-role {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 2px;
    }

    .hakakses-role-select {
        text-align: right;
        flex-shrink: 0;
    }

    .hakakses-role-select label {
        display: block;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .03em;
        color: #9ca3af;
        margin-bottom: 5px;
    }

    .hakakses-role-select select {
        height: 36px;
        padding: 0 10px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #374151;
        font-size: 11px;
        font-weight: 600;
        outline: none;
    }

    .hakakses-table-wrapper {
        max-height: 360px;
        overflow: auto;
        border: 1px solid #eef0f4;
        border-radius: 10px;
    }

    table.hakakses-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 560px;
    }

    table.hakakses-table th {
        position: sticky;
        top: 0;
        z-index: 2;
        text-align: left;
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #9ca3af;
        padding: 11px 14px;
        background: #f8fafc;
        border-bottom: 1px solid #eef0f4;
    }

    table.hakakses-table td {
        padding: 10px 14px;
        border-top: 1px solid #f3f4f6;
        font-size: 11px;
        color: #374151;
    }

    table.hakakses-table tbody tr:first-child td {
        border-top: none;
    }

    table.hakakses-table td.menu-sub {
        padding-left: 27px;
        color: #6b7280;
    }

    table.hakakses-table td.center,
    table.hakakses-table th:not(:first-child) {
        text-align: center;
    }

    table.hakakses-table input[type="checkbox"] {
        width: 15px;
        height: 15px;
        cursor: pointer;
        accent-color: #071b88;
    }

    .extra-action-label {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        font-size: 10px;
        color: #374151;
    }

    .dash {
        color: #d1d5db;
    }

    .hakakses-actions {
        display: flex;
        justify-content: flex-end;
        gap: 9px;
        margin-top: 20px;
    }

    /* =========================================================
       SUCCESS POPUP
    ========================================================= */

    .success-popup-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.58);
        z-index: 3000;
        align-items: center;
        justify-content: center;
        padding: 20px;
        box-sizing: border-box;
        opacity: 0;
        transition: opacity .25s ease;
    }

    .success-popup-overlay.show {
        display: flex;
        opacity: 1;
    }

    .success-popup-box {
        width: 100%;
        max-width: 280px;
        background: #ffffff;
        border-radius: 16px;
        padding: 30px 26px;
        text-align: center;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.2);
        transform: scale(.7) translateY(10px);
        opacity: 0;
        transition:
            transform .35s cubic-bezier(.34,1.56,.64,1),
            opacity .25s ease;
        box-sizing: border-box;
    }

    .success-popup-overlay.show .success-popup-box {
        transform: scale(1) translateY(0);
        opacity: 1;
    }

    .success-popup-icon {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        border: 3px solid #16a34a;
        color: #16a34a;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
        margin: 0 auto 16px;
        transform: scale(0);
        opacity: 0;
        transition:
            transform .4s cubic-bezier(.34,1.56,.64,1) .15s,
            opacity .2s ease .15s;
    }

    .success-popup-overlay.show .success-popup-icon {
        transform: scale(1);
        opacity: 1;
        animation: successPulse .5s ease .15s;
    }

    @keyframes successPulse {
        0% {
            box-shadow: 0 0 0 0 rgba(22, 163, 74, .4);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(22, 163, 74, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(22, 163, 74, 0);
        }
    }

    .success-popup-icon i {
        opacity: 0;
        transform: scale(.5);
        transition:
            transform .3s ease .3s,
            opacity .3s ease .3s;
    }

    .success-popup-overlay.show .success-popup-icon i {
        opacity: 1;
        transform: scale(1);
    }

    .success-popup-text {
        font-size: 13px;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 20px;
        line-height: 1.4;
        opacity: 0;
        transform: translateY(6px);
        transition:
            transform .3s ease .2s,
            opacity .3s ease .2s;
    }

    .success-popup-overlay.show .success-popup-text {
        opacity: 1;
        transform: translateY(0);
    }

    .success-popup-ok {
        height: 36px;
        background: #071b88;
        color: #ffffff;
        border: none;
        padding: 0 26px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        opacity: 0;
        transform: translateY(6px);
        transition:
            transform .3s ease .25s,
            opacity .3s ease .25s,
            background .2s ease;
    }

    .success-popup-overlay.show .success-popup-ok {
        opacity: 1;
        transform: translateY(0);
    }

    .success-popup-ok:hover {
        background: #05146b;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 850px) {
        .stats-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .stat-card {
            padding: 15px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            min-width: 40px;
            font-size: 18px;
        }

        .stat-value {
            font-size: 22px;
        }

        .toolbar {
            flex-wrap: wrap;
        }

        .search-box {
            flex: 1 1 100%;
            order: 1;
        }

        .filter-wrapper {
            order: 2;
        }

        .toolbar > .btn-primary {
            order: 3;
        }
    }

    @media (max-width: 650px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stat-card {
            min-height: 90px;
        }

        .table-card {
            padding: 15px;
        }

        .hakakses-header {
            flex-direction: column;
            align-items: stretch;
        }

        .hakakses-role-select {
            text-align: left;
        }

        .hakakses-role-select select {
            width: 100%;
        }

        .pagination-bar {
            flex-direction: column;
            align-items: flex-start;
        }

        .pagination-bar nav {
            margin-left: 0;
        }
    }

    @media (max-width: 450px) {
        .breadcrumb {
            font-size: 17px;
        }

        .toolbar {
            gap: 8px;
        }

        .filter-wrapper,
        .toolbar > .btn-primary {
            flex: 1;
        }

        .filter-wrapper .btn-outline,
        .toolbar > .btn-primary {
            width: 100%;
        }

        .filter-dropdown {
            width: 100%;
        }

        .modal-box,
        .hakakses-box {
            padding: 18px;
        }
    }
</style>

<div class="user-dashboard">

{{-- =====================================================
     HEADER
====================================================== --}}

<div class="breadcrumb">
    Manajemen Pengguna
</div>

<p class="welcome-text">
    Selamat datang Super Admin!
</p>


{{-- =====================================================
     ALERT
====================================================== --}}

@if (session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif


{{-- =====================================================
     STATISTIK
====================================================== --}}

<div class="stats-grid">

    <div class="stat-card total">
        <div class="stat-icon">
            <i class="bi bi-people"></i>
        </div>

        <div class="stat-content">
            <span class="stat-label">Total User</span>
            <span class="stat-value">{{ $totalUser }}</span>
        </div>
    </div>


    <div class="stat-card aktif">
        <div class="stat-icon">
            <i class="bi bi-person-check"></i>
        </div>

        <div class="stat-content">
            <span class="stat-label">Pengguna Aktif</span>
            <span class="stat-value">{{ $totalAktif }}</span>
        </div>
    </div>


    <div class="stat-card nonaktif">
        <div class="stat-icon">
            <i class="bi bi-person-x"></i>
        </div>

        <div class="stat-content">
            <span class="stat-label">Pengguna Non Aktif</span>
            <span class="stat-value">{{ $totalNonAktif }}</span>
        </div>
    </div>

</div>


{{-- =====================================================
     TABLE CARD
====================================================== --}}

<div class="table-card">

    {{-- TOOLBAR --}}
    <form method="GET"
          action="{{ route('pengguna.index') }}"
          class="toolbar">

        <div class="search-box">
            <i class="bi bi-search"></i>

            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari pengguna..."
            >
        </div>


        {{-- FILTER --}}
        <div class="filter-wrapper">

            <button
                type="button"
                class="btn-outline"
                onclick="toggleFilter()"
            >
                <i class="bi bi-funnel"></i>
                Filter
            </button>


            <div
                class="filter-dropdown"
                id="filterDropdown"
            >

                <label class="filter-label">
                    Role
                </label>

                <select
                    name="role"
                    class="filter-select"
                >
                    <option value="">Semua Role</option>

                    <option value="operator"
                        {{ request('role') === 'operator' ? 'selected' : '' }}>
                        Operator
                    </option>

                    <option value="verifikator"
                        {{ request('role') === 'verifikator' ? 'selected' : '' }}>
                        Verifikator
                    </option>

                    <option value="pimpinan"
                        {{ request('role') === 'pimpinan' ? 'selected' : '' }}>
                        Pimpinan
                    </option>

                    <option value="super_admin"
                        {{ request('role') === 'super_admin' ? 'selected' : '' }}>
                        Super Admin
                    </option>
                </select>


                <label class="filter-label">
                    Status
                </label>

                <select
                    name="status"
                    class="filter-select"
                >
                    <option value="">Semua Status</option>

                    <option value="aktif"
                        {{ request('status') === 'aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="nonaktif"
                        {{ request('status') === 'nonaktif' ? 'selected' : '' }}>
                        Non Aktif
                    </option>
                </select>


                <button
                    type="submit"
                    class="btn-primary filter-apply"
                >
                    Terapkan
                </button>

            </div>

        </div>


        {{-- ADD --}}
        <button
            type="button"
            class="btn-primary"
            onclick="openAddModal()"
        >
            <i class="bi bi-plus-circle"></i>
            Tambah
        </button>

    </form>


    {{-- TABLE --}}
    <div class="table-wrapper">

        <table class="users-table">

            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Terakhir Login</th>
                    <th>Hak Akses</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($users as $user)

                    <tr>

                        <td>
                            <span class="user-name">
                                {{ $user->name }}
                            </span>
                        </td>


                        <td>
                            <span class="username-text">
                                {{ $user->username }}
                            </span>
                        </td>


                        <td>
                            <span class="role-text">
                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                            </span>
                        </td>


                        <td>

                            <span class="status-pill
                                {{ $user->is_active
                                    ? 'status-aktif'
                                    : 'status-nonaktif' }}">

                                {{ $user->is_active
                                    ? 'Aktif'
                                    : 'Non Aktif' }}

                            </span>

                        </td>


                        <td>
                            {{ $user->last_login_at
                                ? $user->last_login_at->diffForHumans()
                                : '-' }}
                        </td>


                        <td>

                            <button
                                type="button"
                                class="icon-btn icon-hakakses"
                                title="Hak Akses"
                                onclick='openHakAksesModal(@json($user))'
                            >
                                <i class="bi bi-person-gear"></i>
                            </button>

                        </td>


                        <td>

                            <div class="action-buttons">

                                @if ($user->is_active)

                                    <form
                                        action="{{ route('pengguna.deactivate', $user->id) }}"
                                        method="POST"
                                        style="display:inline"
                                        onsubmit="return confirm('Nonaktifkan pengguna ini?')"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="icon-btn icon-activate"
                                            title="Aktif — klik untuk nonaktifkan"
                                        >
                                            <i class="bi bi-check-circle-fill"></i>
                                        </button>

                                    </form>

                                @else

                                    <form
                                        action="{{ route('pengguna.activate', $user->id) }}"
                                        method="POST"
                                        style="display:inline"
                                    >
                                        @csrf

                                        <button
                                            type="submit"
                                            class="icon-btn icon-deactivate"
                                            title="Non aktif — klik untuk aktifkan"
                                        >
                                            <i class="bi bi-x-circle-fill"></i>
                                        </button>

                                    </form>

                                @endif


                                <form
                                    action="{{ route('pengguna.destroy', $user->id) }}"
                                    method="POST"
                                    style="display:inline"
                                    onsubmit="return confirm('Hapus pengguna ini?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="icon-btn icon-delete"
                                        title="Hapus"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="7"
                            style="
                                text-align:center;
                                color:#9ca3af;
                                padding:30px 0;
                            "
                        >
                            <i
                                class="bi bi-people"
                                style="
                                    display:block;
                                    font-size:24px;
                                    margin-bottom:8px;
                                "
                            ></i>

                            Belum ada pengguna.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- PAGINATION --}}
    <div class="pagination-bar">

        <span class="pagination-info">
            Showing
            {{ $users->firstItem() ?? 0 }}
            –
            {{ $users->lastItem() ?? 0 }}
            of
            {{ $users->total() }}
            entries
        </span>

        {{ $users->links() }}

    </div>

</div>

</div>

{{-- =========================================================
MODAL TAMBAH / EDIT
========================================================= --}}

<div
    class="modal-overlay"
    id="userModal"
>

<div class="modal-box">

    <h3 id="modalTitle">
        Tambah Pengguna
    </h3>


    <form
        id="userForm"
        method="POST"
        action="{{ route('pengguna.store') }}"
    >

        @csrf

        <div id="methodField"></div>


        <div class="form-group">

            <label>Nama</label>

            <input
                type="text"
                name="name"
                id="field_name"
                required
            >

        </div>


        <div class="form-group">

            <label>Username</label>

            <input
                type="text"
                name="username"
                id="field_username"
                required
            >

        </div>


        <div class="form-group">

            <label>
                Password
                <span
                    id="passwordHint"
                    style="font-weight:400;"
                ></span>
            </label>

            <input
                type="password"
                name="password"
                id="field_password"
            >

        </div>


        <div class="form-group">

            <label>Role</label>

            <select
                name="role"
                id="field_role"
                required
            >
                <option value="super_admin">
                    Super Admin
                </option>

                <option value="operator">
                    Operator
                </option>

                <option value="verifikator">
                    Verifikator
                </option>

                <option value="pimpinan">
                    Pimpinan
                </option>

            </select>

        </div>


        <div class="modal-actions">

            <button
                type="button"
                class="btn-secondary"
                onclick="closeModal()"
            >
                Batal
            </button>

            <button
                type="submit"
                class="btn-primary"
            >
                <i class="bi bi-check-lg"></i>
                Simpan
            </button>

        </div>

    </form>

</div>

</div>

{{-- =========================================================
MODAL HAK AKSES
========================================================= --}}

<div
    class="modal-overlay"
    id="hakAksesModal"
>

<div class="hakakses-box">

    <div class="hakakses-header">

        <div class="hakakses-user">

            <img
                id="hakAksesAvatar"
                src=""
                alt="avatar"
                class="hakakses-avatar"
            >

            <div>

                <div
                    class="hakakses-name"
                    id="hakAksesName"
                ></div>

                <div
                    class="hakakses-role"
                    id="hakAksesCurrentRole"
                ></div>

            </div>

        </div>


        <div class="hakakses-role-select">

            <label>
                Role Saat Ini
            </label>

            <select
                id="hakAksesRoleDropdown"
                onchange="loadPermissions(this.value)"
            >

                <option value="super_admin">
                    Super Admin
                </option>

                <option value="operator">
                    Operator
                </option>

                <option value="verifikator">
                    Verifikator
                </option>

                <option value="pimpinan">
                    Pimpinan
                </option>

            </select>

        </div>

    </div>


    <div class="hakakses-table-wrapper">

        <table class="hakakses-table">

            <thead>

                <tr>
                    <th>Menu/Fitur</th>
                    <th>Lihat</th>
                    <th>Tambah</th>
                    <th>Hapus</th>
                    <th>Aksi Lain</th>
                </tr>

            </thead>

            <tbody id="hakAksesTableBody">

                <tr>

                    <td
                        colspan="5"
                        style="
                            text-align:center;
                            padding:20px;
                            color:#9ca3af;
                        "
                    >
                        Memuat...

                    </td>

                </tr>

            </tbody>

        </table>

    </div>


    <div class="hakakses-actions">

        <button
            type="button"
            class="btn-secondary"
            onclick="closeHakAksesModal()"
        >
            Batal
        </button>

        <button
            type="button"
            class="btn-primary"
            onclick="saveHakAkses()"
        >
            <i class="bi bi-check-lg"></i>
            Simpan
        </button>

    </div>

</div>

</div>

{{-- =========================================================
POPUP SUKSES
========================================================= --}}

<div
    class="success-popup-overlay"
    id="successPopup"
>

<div class="success-popup-box">

    <div class="success-popup-icon">

        <i class="bi bi-check-lg"></i>

    </div>


    <div
        class="success-popup-text"
        id="successPopupText"
    >
        Data berhasil disimpan!
    </div>


    <button
        type="button"
        class="success-popup-ok"
        onclick="closeSuccessPopup()"
    >
        OK
    </button>

</div>

</div>

<script>
    /* =========================================================
       MODAL TAMBAH / EDIT
    ========================================================= */

    function openAddModal() {

        document.getElementById('modalTitle').textContent =
            'Tambah Pengguna';

        document.getElementById('userForm').action =
            "{{ route('pengguna.store') }}";

        document.getElementById('methodField').innerHTML = '';

        document.getElementById('field_name').value = '';
        document.getElementById('field_username').value = '';
        document.getElementById('field_password').value = '';

        document.getElementById('field_password').required = true;

        document.getElementById('passwordHint').textContent = '';

        document.getElementById('field_role').value = 'operator';

        document.getElementById('userModal')
            .classList.add('show');
    }


    function openEditModal(user) {

        document.getElementById('modalTitle').textContent =
            'Edit Pengguna';

        document.getElementById('userForm').action =
            "{{ url('pengguna') }}/" + user.id;

        document.getElementById('methodField').innerHTML =
            '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('field_name').value =
            user.name || '';

        document.getElementById('field_username').value =
            user.username || '';

        document.getElementById('field_password').value = '';

        document.getElementById('field_password').required = false;

        document.getElementById('passwordHint').textContent =
            '(kosongkan jika tidak diganti)';

        document.getElementById('field_role').value =
            user.role || 'operator';

        document.getElementById('userModal')
            .classList.add('show');
    }


    function closeModal() {

        document.getElementById('userModal')
            .classList.remove('show');

    }


    /* =========================================================
       FILTER DROPDOWN
    ========================================================= */

    function toggleFilter() {

        document.getElementById('filterDropdown')
            .classList.toggle('show');

    }


    document.addEventListener('click', function (event) {

        const wrapper =
            document.querySelector('.filter-wrapper');

        const dropdown =
            document.getElementById('filterDropdown');

        if (
            wrapper &&
            dropdown &&
            !wrapper.contains(event.target)
        ) {
            dropdown.classList.remove('show');
        }

    });


    /* =========================================================
       POPUP SUKSES
    ========================================================= */

    function showSuccessPopup(message, onOk) {

        document.getElementById('successPopupText').textContent =
            message || 'Data berhasil disimpan!';

        document.getElementById('successPopup')
            .classList.add('show');

        window._successPopupOnOk =
            onOk || null;
    }


    function closeSuccessPopup() {

        document.getElementById('successPopup')
            .classList.remove('show');

        if (
            typeof window._successPopupOnOk ===
            'function'
        ) {

            const cb =
                window._successPopupOnOk;

            window._successPopupOnOk = null;

            cb();

        }

    }


    @if (session('success'))

        document.addEventListener(
            'DOMContentLoaded',
            function () {

                showSuccessPopup(
                    @json(session('success'))
                );

            }
        );

    @endif


    /* =========================================================
       MODAL HAK AKSES
    ========================================================= */

    let currentHakAksesRole = null;


    function openHakAksesModal(user) {

        document.getElementById('hakAksesAvatar').src =
            'https://api.dicebear.com/7.x/avataaars/svg?seed=' +
            encodeURIComponent(user.username || user.name || 'user');

        document.getElementById('hakAksesName').textContent =
            user.name || '-';

        document.getElementById('hakAksesCurrentRole').textContent =
            formatRole(user.role);

        document.getElementById('hakAksesRoleDropdown').value =
            user.role;

        loadPermissions(user.role);

        document.getElementById('hakAksesModal')
            .classList.add('show');
    }


    function formatRole(role) {

        if (!role) {
            return '-';
        }

        return role
            .charAt(0)
            .toUpperCase() +
            role.slice(1).replace('_', ' ');

    }


    function closeHakAksesModal() {

        document.getElementById('hakAksesModal')
            .classList.remove('show');

    }


    function loadPermissions(role) {

        currentHakAksesRole = role;

        const tbody =
            document.getElementById('hakAksesTableBody');

        tbody.innerHTML = `
            <tr>
                <td
                    colspan="5"
                    style="
                        text-align:center;
                        padding:20px;
                        color:#9ca3af;
                    "
                >
                    Memuat...
                </td>
            </tr>
        `;


        fetch("{{ url('hak-akses') }}/" + role)

            .then(res => {

                if (!res.ok) {
                    throw new Error(
                        'Gagal mengambil data hak akses.'
                    );
                }

                return res.json();

            })

            .then(data => {

                tbody.innerHTML = '';

                let infraHeaderAdded = false;


                const checkboxOrDash =
                    (checked, field) => {

                        return `
                            <input
                                type="checkbox"
                                data-field="${field}"
                                ${checked ? 'checked' : ''}
                            >
                        `;

                    };


                const cell =
                    (supports, checked, field) => {

                        if (!supports) {
                            return '<span class="dash">-</span>';
                        }

                        return checkboxOrDash(
                            checked,
                            field
                        );

                    };


                data.forEach(item => {

                    const isSub =
                        item.menu_key.includes('.');


                    if (
                        isSub &&
                        !infraHeaderAdded
                    ) {

                        const headerRow =
                            document.createElement('tr');

                        headerRow.innerHTML = `
                            <td
                                style="
                                    font-weight:600;
                                    color:#1f2937;
                                    background:#fafbfc;
                                "
                            >
                                Infrastruktur
                            </td>

                            <td
                                class="center"
                                style="background:#fafbfc;"
                            >
                                <span class="dash">-</span>
                            </td>

                            <td
                                class="center"
                                style="background:#fafbfc;"
                            >
                                <span class="dash">-</span>
                            </td>

                            <td
                                class="center"
                                style="background:#fafbfc;"
                            >
                                <span class="dash">-</span>
                            </td>

                            <td
                                class="center"
                                style="background:#fafbfc;"
                            >
                                <span class="dash">-</span>
                            </td>
                        `;

                        tbody.appendChild(headerRow);

                        infraHeaderAdded = true;
                    }


                    const row =
                        document.createElement('tr');

                    row.dataset.menuKey =
                        item.menu_key;


                    row.innerHTML = `
                        <td
                            class="${isSub ? 'menu-sub' : ''}"
                        >
                            ${isSub ? '↳ ' : ''}
                            ${item.menu_label}
                        </td>

                        <td class="center">
                            ${checkboxOrDash(
                                item.can_view,
                                'can_view'
                            )}
                        </td>

                        <td class="center">
                            ${cell(
                                item.supports_add,
                                item.can_add,
                                'can_add'
                            )}
                        </td>

                        <td class="center">
                            ${cell(
                                item.supports_delete,
                                item.can_delete,
                                'can_delete'
                            )}
                        </td>

                        <td class="center">
                            ${
                                item.extra_action_label
                                    ? `
                                        <label
                                            class="extra-action-label"
                                        >
                                            <input
                                                type="checkbox"
                                                data-field="extra_action_checked"
                                                ${
                                                    item.extra_action_checked
                                                        ? 'checked'
                                                        : ''
                                                }
                                            >

                                            ${item.extra_action_label}
                                        </label>
                                      `
                                    : '<span class="dash">-</span>'
                            }
                        </td>
                    `;


                    tbody.appendChild(row);

                });

            })

            .catch(error => {

                console.error(error);

                tbody.innerHTML = `
                    <tr>
                        <td
                            colspan="5"
                            style="
                                text-align:center;
                                padding:20px;
                                color:#dc2626;
                            "
                        >
                            Gagal memuat hak akses.
                        </td>
                    </tr>
                `;

            });

    }


    /* =========================================================
       SIMPAN HAK AKSES
    ========================================================= */

    function saveHakAkses() {

        const rows =
            document.querySelectorAll(
                '#hakAksesTableBody tr'
            );

        const items = [];


        rows.forEach(row => {

            const menuKey =
                row.dataset.menuKey;

            if (!menuKey) {
                return;
            }


            const getChecked =
                (field) => {

                    const el =
                        row.querySelector(
                            `[data-field="${field}"]`
                        );

                    return el
                        ? el.checked
                        : false;

                };


            items.push({

                menu_key: menuKey,

                can_view:
                    getChecked('can_view'),

                can_add:
                    getChecked('can_add'),

                can_delete:
                    getChecked('can_delete'),

                extra_action_checked:
                    getChecked(
                        'extra_action_checked'
                    ),

            });

        });


        fetch(
            "{{ url('hak-akses') }}/" +
            currentHakAksesRole,
            {
                method: 'POST',

                headers: {
                    'Content-Type':
                        'application/json',

                    'X-CSRF-TOKEN':
                        '{{ csrf_token() }}',
                },

                body: JSON.stringify({
                    items
                }),
            }
        )

        .then(res => {

            if (!res.ok) {
                throw new Error(
                    'Gagal menyimpan hak akses.'
                );
            }

            return res.json();

        })

        .then(() => {

            closeHakAksesModal();

            showSuccessPopup(
                'Hak akses berhasil disimpan!',
                function () {
                    location.reload();
                }
            );

        })

        .catch(error => {

            console.error(error);

            alert(
                'Gagal menyimpan hak akses.'
            );

        });

    }


    /* =========================================================
       CLOSE MODAL SAAT KLIK AREA LUAR
    ========================================================= */

    document.addEventListener('click', function (event) {

        const userModal =
            document.getElementById('userModal');

        const hakAksesModal =
            document.getElementById('hakAksesModal');


        if (
            event.target === userModal
        ) {
            closeModal();
        }


        if (
            event.target === hakAksesModal
        ) {
            closeHakAksesModal();
        }

    });


    /* =========================================================
       ESCAPE
    ========================================================= */

    document.addEventListener('keydown', function (event) {

        if (event.key !== 'Escape') {
            return;
        }

        closeModal();
        closeHakAksesModal();

    });
</script>

@endsection
@extends('layouts.app')

@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas')

@section('content')

<style>
    .log-page {
        width: 100%;
    }

    /* =========================
       HEADER
    ========================= */
    .log-page-header {
        margin-bottom: 18px;
    }

    .log-page-title {
        font-size: 22px;
        font-weight: 700;
        color: #111827;
        margin: 0;
    }

    .log-page-subtitle {
        font-size: 13px;
        color: #9ca3af;
        margin-top: 5px;
    }

    /* =========================
       MAIN CARD
    ========================= */
    .log-table-card {
        background: #fff;
        border: 1px solid #eef0f4;
        border-radius: 15px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    /* =========================
       CARD HEADER
    ========================= */
    .log-card-header {
        padding: 20px 22px;
        border-bottom: 1px solid #f0f1f3;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .log-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .log-card-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #eef2ff;
        color: #071b88;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .log-card-title h3 {
        margin: 0;
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
    }

    .log-card-title p {
        margin: 3px 0 0;
        font-size: 12px;
        color: #9ca3af;
    }

    .log-total-badge {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        color: #6b7280;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    /* =========================
       TOOLBAR
    ========================= */
    .log-toolbar {
        padding: 16px 22px;
        border-bottom: 1px solid #f0f1f3;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .log-search {
        position: relative;
        flex: 1;
        min-width: 240px;
    }

    .log-search i {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 14px;
        pointer-events: none;
    }

    .log-search input {
        width: 100%;
        height: 38px;
        border: 1px solid #e5e7eb;
        border-radius: 9px;
        padding: 0 13px 0 36px;
        font-size: 12px;
        color: #374151;
        outline: none;
        background: #fff;
        transition: .2s;
    }

    .log-search input:focus {
        border-color: #071b88;
        box-shadow: 0 0 0 3px rgba(7, 27, 136, 0.08);
    }

    .log-filter {
        height: 38px;
        min-width: 150px;
        border: 1px solid #e5e7eb;
        border-radius: 9px;
        padding: 0 12px;
        font-size: 12px;
        color: #374151;
        background: #fff;
        outline: none;
        cursor: pointer;
    }

    .log-filter:focus {
        border-color: #071b88;
    }

    .btn-reset-log {
        height: 38px;
        padding: 0 14px;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #6b7280;
        border-radius: 9px;
        font-size: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: .2s;
    }

    .btn-reset-log:hover {
        background: #f8fafc;
        color: #071b88;
        border-color: #dbe1f5;
    }

    /* =========================
       TABLE
    ========================= */
    .log-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    table.log-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 780px;
    }

    table.log-table thead th {
        text-align: left;
        padding: 12px 22px;
        background: #fafbfc;
        border-bottom: 1px solid #eef0f4;
        font-size: 10px;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: .5px;
        white-space: nowrap;
    }

    table.log-table tbody td {
        padding: 14px 22px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 12px;
        color: #374151;
        vertical-align: middle;
    }

    table.log-table tbody tr:last-child td {
        border-bottom: none;
    }

    table.log-table tbody tr {
        transition: background .15s;
    }

    table.log-table tbody tr:hover {
        background: #fafbff;
    }

    .log-number {
        width: 50px;
        color: #9ca3af !important;
        font-weight: 600;
    }

    /* =========================
       ACTIVITY
    ========================= */
    .activity-wrapper {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .activity-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 14px;
    }

    .activity-create {
        background: #ecfdf5;
        color: #059669;
    }

    .activity-update {
        background: #eff6ff;
        color: #2563eb;
    }

    .activity-delete {
        background: #fef2f2;
        color: #dc2626;
    }

    .activity-login {
        background: #f0fdf4;
        color: #16a34a;
    }

    .activity-logout {
        background: #fff7ed;
        color: #ea580c;
    }

    .activity-default {
        background: #f3f4f6;
        color: #6b7280;
    }

    .activity-text {
        font-weight: 500;
        color: #374151;
        line-height: 1.5;
    }

    /* =========================
       USER
    ========================= */
    .user-wrapper {
        display: flex;
        align-items: center;
        gap: 9px;
    }

    .user-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #eef2ff;
        color: #071b88;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        flex-shrink: 0;
    }

    .user-name {
        font-size: 12px;
        font-weight: 600;
        color: #374151;
        white-space: nowrap;
    }

    /* =========================
       ROLE
    ========================= */
    .log-role-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .role-super_admin {
        background: #ede9fe;
        color: #6d28d9;
    }

    .role-operator {
        background: #fef3c7;
        color: #d97706;
    }

    .role-verifikator,
    .role-verifier {
        background: #dcfce7;
        color: #16a34a;
    }

    .role-pimpinan {
        background: #fee2e2;
        color: #dc2626;
    }

    .role-default {
        background: #f3f4f6;
        color: #6b7280;
    }

    /* =========================
       TIME
    ========================= */
    .log-time-main {
        color: #374151;
        font-weight: 500;
        white-space: nowrap;
    }

    .log-time-sub {
        color: #9ca3af;
        font-size: 10px;
        margin-top: 3px;
        white-space: nowrap;
    }

    /* =========================
       EMPTY
    ========================= */
    .log-empty {
        text-align: center;
        padding: 55px 20px !important;
    }

    .log-empty-icon {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: #f3f4f6;
        color: #9ca3af;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 20px;
    }

    .log-empty-title {
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
    }

    .log-empty-text {
        margin-top: 4px;
        font-size: 11px;
        color: #9ca3af;
    }

    /* =========================
       PAGINATION
    ========================= */
    .log-pagination {
        padding: 16px 22px;
        border-top: 1px solid #f0f1f3;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 15px;
        flex-wrap: wrap;
    }

    .pagination-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        flex-wrap: wrap;
    }

    .per-page-wrapper {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .per-page-label {
        font-size: 11px;
        color: #9ca3af;
        white-space: nowrap;
    }

    .per-page-select {
        height: 32px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #fff;
        padding: 0 28px 0 9px;
        font-size: 11px;
        color: #374151;
        outline: none;
        cursor: pointer;
    }

    .per-page-select:focus {
        border-color: #071b88;
    }

    /* =========================
       CUSTOM PAGINATION
       TANPA "SHOWING 1 TO 10..."
    ========================= */
    .custom-pagination {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .pagination-btn {
        min-width: 30px;
        height: 30px;
        padding: 0 8px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border: 1px solid #e5e7eb;
        border-radius: 7px;

        font-size: 11px;
        text-decoration: none;

        color: #6b7280;
        background: #fff;

        transition: .2s;
    }

    .pagination-btn:hover {
        border-color: #cfd5e5;
        color: #071b88;
        background: #f8fafc;
    }

    .pagination-btn.active {
        background: #071b88;
        border-color: #071b88;
        color: #fff;
        font-weight: 600;
    }

    .pagination-btn.disabled {
        color: #d1d5db;
        background: #f9fafb;
        cursor: not-allowed;
    }

    .pagination-btn i {
        font-size: 11px;
    }

    .pagination-dots {
        min-width: 25px;
        height: 30px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        color: #9ca3af;
        font-size: 11px;
    }

    /* =========================
       RESPONSIVE
    ========================= */
    @media (max-width: 768px) {

        .log-card-header {
            align-items: flex-start;
        }

        .log-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .log-search {
            width: 100%;
            min-width: 0;
        }

        .log-filter,
        .btn-reset-log {
            width: 100%;
        }

        .log-pagination {
            justify-content: center;
        }

        .pagination-right {
            width: 100%;
            justify-content: center;
        }

        .custom-pagination {
            justify-content: center;
        }
    }
</style>


<div class="log-page">

    {{-- =========================
         HEADER
    ========================== --}}
    <div class="log-page-header">

        <h1 class="log-page-title">
            Log Aktivitas
        </h1>

        <div class="log-page-subtitle">
            Riwayat aktivitas pengguna dalam sistem.
        </div>

    </div>


    {{-- =========================
         MAIN CARD
    ========================== --}}
    <div class="log-table-card">

        {{-- =========================
             CARD HEADER
        ========================== --}}
        <div class="log-card-header">

            <div class="log-card-title">

                <div class="log-card-icon">
                    <i class="bi bi-clock-history"></i>
                </div>

                <div>

                    <h3>
                        Riwayat Aktivitas
                    </h3>

                    <p>
                        Daftar aktivitas terbaru pengguna
                    </p>

                </div>

            </div>


            <div class="log-total-badge">
                {{ number_format($logs->total()) }} aktivitas
            </div>

        </div>


        {{-- =========================
             TOOLBAR
        ========================== --}}
        <form
            method="GET"
            action="{{ route('log-aktivitas.index') }}"
            class="log-toolbar"
        >

            {{-- SEARCH --}}
            <div class="log-search">

                <i class="bi bi-search"></i>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari aktivitas, pengguna, atau role..."
                >

            </div>


            {{-- ROLE --}}
            <select
                name="role"
                class="log-filter"
                onchange="this.form.submit()"
            >

                <option value="">
                    Semua Role
                </option>

                <option
                    value="super_admin"
                    {{ request('role') === 'super_admin' ? 'selected' : '' }}
                >
                    Super Admin
                </option>

                <option
                    value="operator"
                    {{ request('role') === 'operator' ? 'selected' : '' }}
                >
                    Operator
                </option>

                <option
                    value="verifikator"
                    {{ request('role') === 'verifikator' ? 'selected' : '' }}
                >
                    Verifikator
                </option>

                <option
                    value="pimpinan"
                    {{ request('role') === 'pimpinan' ? 'selected' : '' }}
                >
                    Pimpinan
                </option>

            </select>


            {{-- RESET --}}
            @if(request('search') || request('role'))

                <a
                    href="{{ route('log-aktivitas.index') }}"
                    class="btn-reset-log"
                >

                    <i class="bi bi-arrow-counterclockwise"></i>

                    Reset

                </a>

            @endif

        </form>


        {{-- =========================
             TABLE
        ========================== --}}
        <div class="log-table-wrapper">

            <table class="log-table">

                <thead>

                    <tr>

                        <th style="width: 60px;">
                            #
                        </th>

                        <th>
                            Aktivitas
                        </th>

                        <th>
                            Oleh
                        </th>

                        <th>
                            Role
                        </th>

                        <th>
                            Waktu
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($logs as $index => $log)

                        @php

                            $action = strtolower(
                                $log->action ?? ''
                            );

                            if ($action === 'create') {

                                $activityClass = 'activity-create';
                                $activityIcon = 'bi-plus-circle';

                            } elseif ($action === 'update') {

                                $activityClass = 'activity-update';
                                $activityIcon = 'bi-pencil-square';

                            } elseif ($action === 'delete') {

                                $activityClass = 'activity-delete';
                                $activityIcon = 'bi-trash3';

                            } elseif ($action === 'login') {

                                $activityClass = 'activity-login';
                                $activityIcon = 'bi-box-arrow-in-right';

                            } elseif ($action === 'logout') {

                                $activityClass = 'activity-logout';
                                $activityIcon = 'bi-box-arrow-right';

                            } else {

                                $activityClass = 'activity-default';
                                $activityIcon = 'bi-activity';

                            }


                            $role = strtolower(
                                $log->role ?? ''
                            );


                            $roleClass = match ($role) {

                                'super_admin' =>
                                    'role-super_admin',

                                'operator' =>
                                    'role-operator',

                                'verifikator' =>
                                    'role-verifikator',

                                'verifier' =>
                                    'role-verifier',

                                'pimpinan' =>
                                    'role-pimpinan',

                                default =>
                                    'role-default',

                            };


                            $userName =
                                $log->user_name ?? '-';


                            $initial =
                                $userName !== '-'
                                    ? strtoupper(
                                        substr($userName, 0, 1)
                                    )
                                    : '?';

                        @endphp


                        <tr>

                            {{-- NOMOR --}}
                            <td class="log-number">

                                {{ $logs->firstItem() + $index }}

                            </td>


                            {{-- AKTIVITAS --}}
                            <td>

                                <div class="activity-wrapper">

                                    <div
                                        class="activity-icon {{ $activityClass }}"
                                    >

                                        <i
                                            class="bi {{ $activityIcon }}"
                                        ></i>

                                    </div>


                                    <div class="activity-text">

                                        {{ $log->description ?? '-' }}

                                    </div>

                                </div>

                            </td>


                            {{-- USER --}}
                            <td>

                                <div class="user-wrapper">

                                    <div class="user-avatar">

                                        {{ $initial }}

                                    </div>


                                    <div class="user-name">

                                        {{ $userName }}

                                    </div>

                                </div>

                            </td>


                            {{-- ROLE --}}
                            <td>

                                <span
                                    class="log-role-badge {{ $roleClass }}"
                                >

                                    {{
                                        $role
                                            ? str_replace('_', ' ', $role)
                                            : '-'
                                    }}

                                </span>

                            </td>


                            {{-- WAKTU --}}
<td>

    @if($log->created_at)

        @php
            $createdAt = $log->created_at;
            $now = now();

            $diffInSeconds = abs($createdAt->diffInSeconds($now));
            $diffInMinutes = intdiv($diffInSeconds, 60);
            $diffInHours = intdiv($diffInSeconds, 3600);
            $diffInDays = intdiv($diffInSeconds, 86400);
        @endphp

        <div class="log-time-main">

            @if($diffInSeconds < 60)

                Baru saja

            @elseif($diffInMinutes < 60)

                {{ $diffInMinutes }} menit lalu

            @elseif($diffInHours < 24)

                {{ $diffInHours }} jam lalu

            @elseif($diffInDays < 7)

                {{ $diffInDays }} hari lalu

            @else

                {{ $createdAt->format('d M Y') }}

            @endif

        </div>

        <div class="log-time-sub">
            {{ $createdAt->format('d M Y, H:i:s') }}
        </div>

    @else

        <div class="log-time-main">
            -
        </div>

    @endif

</td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="log-empty"
                            >

                                <div class="log-empty-icon">

                                    <i class="bi bi-clock-history"></i>

                                </div>


                                <div class="log-empty-title">

                                    Belum ada aktivitas

                                </div>


                                <div class="log-empty-text">

                                    Belum terdapat riwayat aktivitas
                                    yang dapat ditampilkan.

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =========================
             PAGINATION
        ========================== --}}
        @if($logs->hasPages())

            <div class="log-pagination">

                <div class="pagination-right">

                    {{-- =========================
                         PER PAGE
                    ========================== --}}
                    <form
                        method="GET"
                        action="{{ route('log-aktivitas.index') }}"
                        class="per-page-wrapper"
                    >

                        {{-- Pertahankan SEARCH --}}
                        @if(request('search'))

                            <input
                                type="hidden"
                                name="search"
                                value="{{ request('search') }}"
                            >

                        @endif


                        {{-- Pertahankan ROLE --}}
                        @if(request('role'))

                            <input
                                type="hidden"
                                name="role"
                                value="{{ request('role') }}"
                            >

                        @endif


                        <span class="per-page-label">
                            Per halaman
                        </span>


                        <select
                            name="per_page"
                            class="per-page-select"
                            onchange="this.form.submit()"
                        >

                            <option
                                value="10"
                                {{ (int)($perPage ?? 10) === 10 ? 'selected' : '' }}
                            >
                                10
                            </option>

                            <option
                                value="30"
                                {{ (int)($perPage ?? 10) === 30 ? 'selected' : '' }}
                            >
                                30
                            </option>

                            <option
                                value="50"
                                {{ (int)($perPage ?? 10) === 50 ? 'selected' : '' }}
                            >
                                50
                            </option>

                            <option
                                value="100"
                                {{ (int)($perPage ?? 10) === 100 ? 'selected' : '' }}
                            >
                                100
                            </option>

                        </select>

                    </form>


                    {{-- =========================
                         CUSTOM PAGINATION
                         TANPA SHOWING RESULTS
                    ========================== --}}
                    <div class="custom-pagination">

                        {{-- PREVIOUS --}}
                        @if($logs->onFirstPage())

                            <span class="pagination-btn disabled">

                                <i class="bi bi-chevron-left"></i>

                            </span>

                        @else

                            <a
                                href="{{ $logs->appends(request()->query())->previousPageUrl() }}"
                                class="pagination-btn"
                            >

                                <i class="bi bi-chevron-left"></i>

                            </a>

                        @endif


                        @php

                            $currentPage = $logs->currentPage();
                            $lastPage = $logs->lastPage();

                            $startPage = max(
                                1,
                                $currentPage - 2
                            );

                            $endPage = min(
                                $lastPage,
                                $currentPage + 2
                            );

                        @endphp


                        {{-- HALAMAN 1 --}}
                        @if($startPage > 1)

                            <a
                                href="{{ $logs->appends(request()->query())->url(1) }}"
                                class="pagination-btn"
                            >
                                1
                            </a>


                            @if($startPage > 2)

                                <span class="pagination-dots">
                                    ...
                                </span>

                            @endif

                        @endif


                        {{-- HALAMAN DI SEKITAR CURRENT --}}
                        @for(
                            $page = $startPage;
                            $page <= $endPage;
                            $page++
                        )

                            @if($page == $currentPage)

                                <span class="pagination-btn active">
                                    {{ $page }}
                                </span>

                            @else

                                <a
                                    href="{{ $logs->appends(request()->query())->url($page) }}"
                                    class="pagination-btn"
                                >
                                    {{ $page }}
                                </a>

                            @endif

                        @endfor


                        {{-- HALAMAN TERAKHIR --}}
                        @if($endPage < $lastPage)

                            @if($endPage < $lastPage - 1)

                                <span class="pagination-dots">
                                    ...
                                </span>

                            @endif


                            <a
                                href="{{ $logs->appends(request()->query())->url($lastPage) }}"
                                class="pagination-btn"
                            >
                                {{ $lastPage }}
                            </a>

                        @endif


                        {{-- NEXT --}}
                        @if($logs->hasMorePages())

                            <a
                                href="{{ $logs->appends(request()->query())->nextPageUrl() }}"
                                class="pagination-btn"
                            >

                                <i class="bi bi-chevron-right"></i>

                            </a>

                        @else

                            <span class="pagination-btn disabled">

                                <i class="bi bi-chevron-right"></i>

                            </span>

                        @endif

                    </div>

                </div>

            </div>

        @endif

    </div>

</div>

@endsection
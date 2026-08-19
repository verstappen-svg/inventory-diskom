@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')


@section('content')

<style>

    /* =====================================================
       DASHBOARD
    ====================================================== */

    .dashboard {

        width: 100%;

    }


    /* =====================================================
       WELCOME
    ====================================================== */

    .welcome-section {

        margin-bottom: 25px;

    }


    .welcome-title {

        margin: 0 0 6px;

        font-size: 24px;

        font-weight: 700;

        color: #1f2937;

    }


    .welcome-text {

        margin: 0;

        font-size: 13px;

        color: #6b7280;

    }


    /* =====================================================
       STAT CARD
    ====================================================== */

    .stats-grid {

        display: grid;

        grid-template-columns:
            repeat(4, 1fr);

        gap: 20px;

        margin-bottom: 25px;

    }


    .stat-card {

        background: white;

        border-radius: 15px;

        padding: 20px;

        display: flex;

        align-items: center;

        gap: 15px;

        box-shadow:
            0 3px 10px rgba(0,0,0,0.06);

        border: 1px solid #eef0f4;

    }


    .stat-icon {

        width: 50px;

        height: 50px;

        border-radius: 13px;

        display: flex;

        align-items: center;

        justify-content: center;

        background: #e0f2fe;

        color: #075985;

        flex-shrink: 0;

    }


    .stat-icon i {

        font-size: 23px;

    }


    .stat-info {

        display: flex;

        flex-direction: column;

        gap: 4px;

    }


    .stat-label {

        font-size: 12px;

        color: #6b7280;

    }


    .stat-value {

        font-size: 24px;

        font-weight: 700;

        color: #1f2937;

    }


    /* =====================================================
       CONTENT GRID
    ====================================================== */

    .dashboard-grid {

        display: grid;

        grid-template-columns:
            1.5fr 1fr;

        gap: 20px;

        margin-bottom: 25px;

    }


    /* =====================================================
       CARD
    ====================================================== */

    .dashboard-card {

        background: white;

        border-radius: 15px;

        padding: 22px;

        border: 1px solid #eef0f4;

        box-shadow:
            0 3px 10px rgba(0,0,0,0.06);

    }


    .card-header {

        display: flex;

        align-items: center;

        justify-content: space-between;

        margin-bottom: 20px;

    }


    .card-title {

        margin: 0;

        font-size: 16px;

        font-weight: 700;

        color: #1f2937;

    }


    .card-link {

        font-size: 12px;

        color: #075985;

        text-decoration: none;

        font-weight: 600;

    }


    .card-link:hover {

        text-decoration: underline;

    }


    /* =====================================================
       STATUS
    ====================================================== */

    .status-list {

        display: flex;

        flex-direction: column;

        gap: 16px;

    }


    .status-item {

        display: flex;

        align-items: center;

        justify-content: space-between;

    }


    .status-left {

        display: flex;

        align-items: center;

        gap: 10px;

    }


    .status-dot {

        width: 10px;

        height: 10px;

        border-radius: 50%;

    }


    .status-name {

        font-size: 13px;

        color: #4b5563;

    }


    .status-count {

        font-size: 13px;

        font-weight: 700;

        color: #1f2937;

    }


    /* =====================================================
       CATEGORY
    ====================================================== */

    .category-list {

        display: flex;

        flex-direction: column;

        gap: 18px;

    }


    .category-item {

        width: 100%;

    }


    .category-info {

        display: flex;

        justify-content: space-between;

        margin-bottom: 7px;

    }


    .category-name {

        font-size: 13px;

        color: #4b5563;

    }


    .category-number {

        font-size: 12px;

        font-weight: 700;

        color: #1f2937;

    }


    .progress {

        width: 100%;

        height: 8px;

        background: #eef2f7;

        border-radius: 10px;

        overflow: hidden;

    }


    .progress-bar {

        height: 100%;

        background: #079bd8;

        border-radius: 10px;

    }


    /* =====================================================
       ACTIVITY
    ====================================================== */

    .activity-list {

        display: flex;

        flex-direction: column;

    }


    .activity-item {

        display: flex;

        align-items: flex-start;

        gap: 13px;

        padding: 15px 0;

        border-bottom: 1px solid #f0f1f3;

    }


    .activity-item:first-child {

        padding-top: 0;

    }


    .activity-item:last-child {

        border-bottom: none;

        padding-bottom: 0;

    }


    .activity-icon {

        width: 35px;

        height: 35px;

        border-radius: 10px;

        background: #e0f2fe;

        color: #075985;

        display: flex;

        align-items: center;

        justify-content: center;

        flex-shrink: 0;

    }


    .activity-icon i {

        font-size: 16px;

    }


    .activity-content {

        display: flex;

        flex-direction: column;

        gap: 4px;

    }


    .activity-text {

        font-size: 13px;

        color: #374151;

        line-height: 1.4;

    }


    .activity-time {

        font-size: 11px;

        color: #9ca3af;

    }


    /* =====================================================
       RESPONSIVE
    ====================================================== */

    @media (max-width: 1100px) {

        .stats-grid {

            grid-template-columns:
                repeat(2, 1fr);

        }


        .dashboard-grid {

            grid-template-columns: 1fr;

        }

    }


    @media (max-width: 600px) {

        .stats-grid {

            grid-template-columns: 1fr;

        }


        .welcome-title {

            font-size: 20px;

        }

    }

</style>



<div class="dashboard">


    {{-- =================================================
         WELCOME
    ================================================== --}}

    <div class="welcome-section">

        <h2 class="welcome-title">
            Selamat Datang 👋
        </h2>

        <p class="welcome-text">
            Pantau dan kelola seluruh aset IT melalui
            sistem Inventory IT Assets.
        </p>

    </div>



    {{-- =================================================
         STATISTICS
    ================================================== --}}

    <div class="stats-grid">


        {{-- TOTAL ASET --}}

        <div class="stat-card">

            <div class="stat-icon">

                <i class="bi bi-box-seam"></i>

            </div>

            <div class="stat-info">

                <span class="stat-label">
                    Total Aset
                </span>

                <span class="stat-value">
                    248
                </span>

            </div>

        </div>


        {{-- HARDWARE --}}

        <div class="stat-card">

            <div class="stat-icon">

                <i class="bi bi-pc-display"></i>

            </div>

            <div class="stat-info">

                <span class="stat-label">
                    Hardware
                </span>

                <span class="stat-value">
                    120
                </span>

            </div>

        </div>


        {{-- SOFTWARE --}}

        <div class="stat-card">

            <div class="stat-icon">

                <i class="bi bi-laptop"></i>

            </div>

            <div class="stat-info">

                <span class="stat-label">
                    Software
                </span>

                <span class="stat-value">
                    68
                </span>

            </div>

        </div>


        {{-- INFRASTRUKTUR --}}

        <div class="stat-card">

            <div class="stat-icon">

                <i class="bi bi-diagram-3-fill"></i>

            </div>

            <div class="stat-info">

                <span class="stat-label">
                    Infrastruktur
                </span>

                <span class="stat-value">
                    60
                </span>

            </div>

        </div>

    </div>



    {{-- =================================================
         STATUS + KATEGORI
    ================================================== --}}

    <div class="dashboard-grid">


        {{-- STATUS ASET --}}

        <div class="dashboard-card">

            <div class="card-header">

                <h3 class="card-title">
                    Status Aset
                </h3>

                <a href="/laporan"
                   class="card-link">

                    Lihat Laporan

                </a>

            </div>


            <div class="status-list">


                <div class="status-item">

                    <div class="status-left">

                        <span class="status-dot"
                              style="background:#22c55e;">
                        </span>

                        <span class="status-name">
                            Aktif
                        </span>

                    </div>

                    <span class="status-count">
                        190
                    </span>

                </div>


                <div class="status-item">

                    <div class="status-left">

                        <span class="status-dot"
                              style="background:#f59e0b;">
                        </span>

                        <span class="status-name">
                            Pending
                        </span>

                    </div>

                    <span class="status-count">
                        18
                    </span>

                </div>


                <div class="status-item">

                    <div class="status-left">

                        <span class="status-dot"
                              style="background:#ef4444;">
                        </span>

                        <span class="status-name">
                            Rusak
                        </span>

                    </div>

                    <span class="status-count">
                        25
                    </span>

                </div>


                <div class="status-item">

                    <div class="status-left">

                        <span class="status-dot"
                              style="background:#6b7280;">
                        </span>

                        <span class="status-name">
                            Tidak Digunakan
                        </span>

                    </div>

                    <span class="status-count">
                        15
                    </span>

                </div>

            </div>

        </div>



        {{-- KATEGORI ASET --}}

        <div class="dashboard-card">

            <div class="card-header">

                <h3 class="card-title">
                    Kategori Aset
                </h3>

            </div>


            <div class="category-list">


                {{-- HARDWARE --}}

                <div class="category-item">

                    <div class="category-info">

                        <span class="category-name">
                            Hardware
                        </span>

                        <span class="category-number">
                            120
                        </span>

                    </div>

                    <div class="progress">

                        <div class="progress-bar"
                             style="width: 75%;">
                        </div>

                    </div>

                </div>


                {{-- SOFTWARE --}}

                <div class="category-item">

                    <div class="category-info">

                        <span class="category-name">
                            Software
                        </span>

                        <span class="category-number">
                            68
                        </span>

                    </div>

                    <div class="progress">

                        <div class="progress-bar"
                             style="width: 55%;">
                        </div>

                    </div>

                </div>


                {{-- INFRASTRUKTUR --}}

                <div class="category-item">

                    <div class="category-info">

                        <span class="category-name">
                            Infrastruktur
                        </span>

                        <span class="category-number">
                            60
                        </span>

                    </div>

                    <div class="progress">

                        <div class="progress-bar"
                             style="width: 48%;">
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    {{-- =================================================
         AKTIVITAS TERBARU
    ================================================== --}}

    <div class="dashboard-card">

        <div class="card-header">

            <h3 class="card-title">
                Aktivitas Terbaru
            </h3>

            <a href="#"
               class="card-link">

                Lihat Semua

            </a>

        </div>


        <div class="activity-list">


            {{-- AKTIVITAS 1 --}}

            <div class="activity-item">

                <div class="activity-icon">

                    <i class="bi bi-plus-lg"></i>

                </div>

                <div class="activity-content">

                    <span class="activity-text">
                        Data hardware baru ditambahkan
                    </span>

                    <span class="activity-time">
                        10 menit yang lalu
                    </span>

                </div>

            </div>


            {{-- AKTIVITAS 2 --}}

            <div class="activity-item">

                <div class="activity-icon">

                    <i class="bi bi-check-lg"></i>

                </div>

                <div class="activity-content">

                    <span class="activity-text">
                        Data aset berhasil diverifikasi
                    </span>

                    <span class="activity-time">
                        30 menit yang lalu
                    </span>

                </div>

            </div>


            {{-- AKTIVITAS 3 --}}

            <div class="activity-item">

                <div class="activity-icon">

                    <i class="bi bi-pencil"></i>

                </div>

                <div class="activity-content">

                    <span class="activity-text">
                        Data software diperbarui
                    </span>

                    <span class="activity-time">
                        1 jam yang lalu
                    </span>

                </div>

            </div>


            {{-- AKTIVITAS 4 --}}

            <div class="activity-item">

                <div class="activity-icon">

                    <i class="bi bi-person-plus"></i>

                </div>

                <div class="activity-content">

                    <span class="activity-text">
                        Pengguna baru ditambahkan
                    </span>

                    <span class="activity-time">
                        2 jam yang lalu
                    </span>

                </div>

            </div>

        </div>

    </div>


</div>

@endsection
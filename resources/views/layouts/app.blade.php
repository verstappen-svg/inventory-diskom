<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Inventory IT Assets')
    </title>


    {{-- =====================================================
         BOOTSTRAP ICONS
    ====================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    {{-- =====================================================
         VITE
    ====================================================== --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    <style>

        /* =====================================================
           RESET
        ===================================================== */

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            width: 100%;
            min-height: 100%;
        }

        body {
            font-family: Arial, sans-serif;
            background: #eef4fc;
            color: #1f2937;
        }


        /* =====================================================
           APP LAYOUT
        ===================================================== */

        .app-layout {
            width: 100%;
            min-height: 100vh;

            margin: 0;
            padding: 0;
        }


        /* =====================================================
           MAIN AREA
        ===================================================== */

        .main-area {
            margin-left: 270px;

            width: calc(100% - 270px);

            min-width: 0;
            min-height: 100vh;

            margin-top: 0;
            padding-top: 0;

            box-sizing: border-box;
        }


        /* =====================================================
           TOP HEADER
        ===================================================== */

        .top-header {
            width: 100%;
            min-height: 75px;

            background: #ffffff;

            border: none;
            border-bottom: 1px solid #e5e7eb;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 30px;

            margin: 0;

            position: sticky;
            top: 0;

            z-index: 900;
        }


        /* =====================================================
           HEADER LEFT
        ===================================================== */

        .header-left {
            display: flex;
            align-items: center;

            gap: 20px;

            min-width: 0;
        }


        .page-title {
            margin: 0;

            font-size: 20px;
            font-weight: 700;

            color: #075985;

            white-space: nowrap;

            line-height: 1;
        }


        /* =====================================================
           HEADER SEARCH
           SEARCH HANYA UNTUK DASHBOARD
        ===================================================== */

        .top-header .search-box {
            width: 340px;
            height: 46px;

            flex-shrink: 0;

            background: #f5f6fa;

            border: 1px solid #e1e5ec;

            border-radius: 24px;

            display: flex;
            align-items: center;

            padding: 0 16px;
        }


        .top-header .search-box i {
            font-size: 19px;

            color: #8fa3bf;

            margin-right: 12px;
        }


        .top-header .search-box input {
            width: 100%;

            border: none;
            outline: none;

            background: transparent;

            font-size: 14px;

            color: #374151;
        }


        .top-header .search-box input::placeholder {
            color: #9ca3af;
        }


        /* =====================================================
           HEADER RIGHT
        ===================================================== */

        .header-right {
            display: flex;
            align-items: center;

            gap: 20px;

            flex-shrink: 0;

            height: 100%;
        }


        /* =====================================================
           NOTIFICATION
        ===================================================== */

        .notification-wrapper {
            position: relative;

            display: flex;
            align-items: center;
            justify-content: center;
        }


        .notification-button {
            position: relative;

            width: 40px;
            height: 40px;

            border: none;

            background: transparent;

            color: #374151;

            display: flex;
            align-items: center;
            justify-content: center;

            cursor: pointer;

            border-radius: 7px;

            transition: 0.2s ease;
        }


        .notification-button:hover {
            background: #f3f4f6;
        }


        .notification-button i {
            font-size: 18px;
        }


        /* =====================================================
           NOTIFICATION BADGE
        ===================================================== */

        .notification-badge {
            position: absolute;

            top: 2px;
            right: 1px;

            min-width: 17px;
            height: 17px;

            padding: 0 4px;

            background: #ef4444;

            color: #ffffff;

            border-radius: 20px;

            border: 2px solid #ffffff;

            font-size: 9px;
            font-weight: 700;

            display: flex;
            align-items: center;
            justify-content: center;

            line-height: 1;
        }


        /* =====================================================
           NOTIFICATION POPUP
        ===================================================== */

        .notification-popup {
            display: none;

            position: absolute;

            top: 48px;
            right: 0;

            width: 360px;

            background: #ffffff;

            border: 1px solid #e5e7eb;

            border-radius: 12px;

            box-shadow:
                0 10px 30px rgba(0, 0, 0, 0.12);

            overflow: hidden;

            z-index: 9999;
        }


        .notification-popup.show {
            display: block;
        }


        /* =====================================================
           NOTIFICATION POPUP HEADER
        ===================================================== */

        .notification-popup-header {
            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 15px 17px;

            background: #ffffff;

            border-bottom: 1px solid #eeeeee;
        }


        .notification-popup-header strong {
            font-size: 15px;

            color: #111827;
        }


        .notification-popup-header a {
            font-size: 12px;

            color: #2563eb;

            text-decoration: none;
        }


        .notification-popup-header a:hover {
            text-decoration: underline;
        }


        /* =====================================================
           NOTIFICATION LIST
        ===================================================== */

        .notification-popup-list {
            max-height: 350px;

            overflow-y: auto;
        }


        /* =====================================================
           NOTIFICATION ITEM
        ===================================================== */

        .notification-item {
            position: relative;

            display: flex;

            gap: 12px;

            padding: 13px 15px;

            text-decoration: none;

            color: #374151;

            border-bottom: 1px solid #f1f1f1;

            transition: 0.2s ease;
        }


        .notification-item:hover {
            background: #f9fafb;
        }


        /* =====================================================
           UNREAD NOTIFICATION
        ===================================================== */

        .notification-item.unread {
            background: #f5f9ff;
        }


        /* =====================================================
           NOTIFICATION ICON
        ===================================================== */

        .notification-item-icon {
            width: 35px;
            height: 35px;

            min-width: 35px;

            border-radius: 50%;

            background: #eef2ff;

            display: flex;

            align-items: center;

            justify-content: center;
        }


        .notification-item-icon i {
            font-size: 14px;

            color: #2563eb;
        }


        /* =====================================================
           NOTIFICATION CONTENT
        ===================================================== */

        .notification-item-content {
            min-width: 0;

            padding-right: 8px;
        }


        .notification-item-content strong {
            display: block;

            font-size: 13px;

            color: #111827;

            margin-bottom: 3px;
        }


        .notification-item-content p {
            margin: 0 0 4px;

            font-size: 12px;

            color: #6b7280;

            line-height: 1.4;
        }


        .notification-item-content small {
            font-size: 10px;

            color: #9ca3af;
        }


        /* =====================================================
           UNREAD DOT
        ===================================================== */

        .notification-unread-dot {
            position: absolute;

            right: 12px;

            top: 18px;

            width: 7px;
            height: 7px;

            background: #ef4444;

            border-radius: 50%;
        }


        /* =====================================================
           EMPTY NOTIFICATION
        ===================================================== */

        .notification-empty {
            padding: 35px 20px;

            text-align: center;

            color: #9ca3af;
        }


        .notification-empty i {
            display: block;

            font-size: 30px;

            margin-bottom: 8px;
        }


        .notification-empty p {
            margin: 0;

            font-size: 13px;
        }


        /* =====================================================
           USER PROFILE
        ===================================================== */

        .user-info {
            display: flex;
            align-items: center;

            gap: 8px;

            padding-left: 12px;

            border-left: 1px solid #d1d5db;
        }


        .user-avatar {
            width: 38px;
            height: 38px;

            border-radius: 50%;

            background: #071b88;

            color: #ffffff;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 15px;
            font-weight: bold;

            flex-shrink: 0;
        }


        .user-text {
            display: flex;
            flex-direction: column;

            gap: 2px;

            min-width: 75px;
        }


        .user-name {
            font-size: 10px;

            font-weight: 700;

            color: #374151;

            line-height: 1.2;
        }


        .user-role {
            font-size: 8px;

            color: #9ca3af;

            line-height: 1.2;
        }


        /* =====================================================
           MAIN CONTENT
        ===================================================== */

        .main-content {
            width: 100%;

            min-width: 0;

            min-height: calc(100vh - 75px);

            padding: 30px;

            box-sizing: border-box;
        }


        /* =====================================================
           HARDWARE PAGE
        ===================================================== */

        .hardware-page {
            width: 100% !important;

            max-width: none !important;

            min-width: 0;

            box-sizing: border-box;
        }


        .hardware-table-container {
            width: 100% !important;

            max-width: none !important;

            min-width: 0;

            box-sizing: border-box;
        }


        /* =====================================================
           LAPORAN PAGE
        ===================================================== */

        .laporan-page {
            width: 100% !important;

            max-width: none !important;

            min-width: 0;

            box-sizing: border-box;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1200px) {

            .main-area {
                margin-left: 270px;

                width: calc(100% - 270px);
            }


            .top-header .search-box {
                width: 280px;
            }

        }


        @media (max-width: 900px) {

            .main-area {
                margin-left: 0;

                width: 100%;
            }


            .top-header {
                padding: 0 20px;
            }


            .top-header .search-box {
                width: 250px;
            }


            .main-content {
                padding: 20px;
            }

        }


        @media (max-width: 700px) {

            .top-header {
                height: 70px;

                padding: 0 15px;
            }


            .header-left {
                gap: 12px;
            }


            .page-title {
                font-size: 16px;
            }


            .header-right {
                gap: 5px;
            }


            .user-info {
                padding-left: 8px;
            }


            .user-text {
                display: none;
            }


            .top-header .search-box {
                width: 180px;
            }


            .main-content {
                padding: 18px 15px 25px;
            }


            .notification-popup {
                position: fixed;

                top: 70px;

                right: 15px;

                width: calc(100vw - 30px);

                max-width: 360px;
            }

        }


        @media (max-width: 500px) {

            .top-header .search-box {
                width: 150px;
            }


            .main-content {
                padding: 15px;
            }


            .notification-popup {
                right: 10px;

                width: calc(100vw - 20px);
            }

        }

    </style>


    @stack('styles')

</head>


<body>


<div class="app-layout">


    {{-- =================================================
         SIDEBAR
    ================================================== --}}

    @include('sidebar')


    {{-- =================================================
         MAIN AREA
    ================================================== --}}

    <div class="main-area">


        {{-- =================================================
             TOP HEADER
        ================================================== --}}

        <header class="top-header">


            {{-- =================================================
                 HEADER LEFT
            ================================================== --}}

            <div class="header-left">


                {{-- PAGE TITLE --}}

                <h1 class="page-title">

                    @yield(
                        'page-title',
                        'Dashboard'
                    )

                </h1>


                {{-- =================================================
                     SEARCH HANYA DI DASHBOARD
                ================================================== --}}

                @if(
                    View::hasSection('dashboard-search')
                )

                    @yield('dashboard-search')

                @endif


            </div>


            {{-- =================================================
                 HEADER RIGHT
            ================================================== --}}

            <div class="header-right">


                {{-- =================================================
                     NOTIFICATION
                ================================================== --}}

                @php

                    /*
                    |--------------------------------------------------------------------------
                    | HANYA AMBIL NOTIFIKASI YANG BELUM DIBACA
                    |--------------------------------------------------------------------------
                    */

                    $latestNotifications =
                        \App\Models\Notification::where(
                            'dibaca',
                            false
                        )
                        ->latest()
                        ->take(5)
                        ->get();


                    /*
                    |--------------------------------------------------------------------------
                    | HITUNG JUMLAH NOTIFIKASI BELUM DIBACA
                    |--------------------------------------------------------------------------
                    */

                    $unreadNotifications =
                        \App\Models\Notification::where(
                            'dibaca',
                            false
                        )->count();

                @endphp


                <div class="notification-wrapper">


                    {{-- TOMBOL BELL --}}

                    <button
                        class="notification-button"
                        type="button"
                        title="Notifikasi"
                        onclick="toggleNotification()"
                    >

                        <i class="bi bi-bell"></i>


                        {{-- BADGE HANYA KALAU ADA YANG BELUM DIBACA --}}

                        @if($unreadNotifications > 0)

                            <span class="notification-badge">

                                {{
                                    $unreadNotifications > 99
                                    ? '99+'
                                    : $unreadNotifications
                                }}

                            </span>

                        @endif

                    </button>


                    {{-- =================================================
                         POPUP NOTIFIKASI
                    ================================================== --}}

                    <div
                        class="notification-popup"
                        id="notificationPopup"
                    >


                        {{-- HEADER POPUP --}}

                        <div class="notification-popup-header">

                            <strong>
                                Notifikasi
                            </strong>


                            <a
                                href="{{ route('notifikasi.index') }}"
                            >
                                Lihat Semua
                            </a>

                        </div>


                        {{-- =================================================
                             LIST NOTIFIKASI BELUM DIBACA
                        ================================================== --}}

                        <div class="notification-popup-list">


                            @forelse(
                                $latestNotifications
                                as $notification
                            )


                                <a
                                    href="{{ route(
                                        'notifikasi.read',
                                        $notification->id
                                    ) }}"
                                    class="notification-item unread"
                                >


                                    {{-- ICON --}}

                                    <div class="notification-item-icon">

                                        <i class="bi bi-bell-fill"></i>

                                    </div>


                                    {{-- ISI NOTIFIKASI --}}

                                    <div class="notification-item-content">


                                        <strong>

                                            {{ $notification->judul }}

                                        </strong>


                                        <p>

                                            {{ $notification->pesan }}

                                        </p>


                                        {{-- WAKTU INDONESIA --}}

                                        <small>

                                            {{
                                                $notification
                                                    ->created_at
                                                    ->locale('id')
                                                    ->diffForHumans()
                                            }}

                                        </small>


                                    </div>


                                    {{-- TITIK BELUM DIBACA --}}

                                    <span
                                        class="notification-unread-dot"
                                    ></span>


                                </a>


                            @empty


                                {{-- TIDAK ADA NOTIFIKASI BARU --}}

                                <div class="notification-empty">

                                    <i class="bi bi-bell-slash"></i>

                                    <p>
                                        Belum ada notifikasi baru
                                    </p>

                                </div>


                            @endforelse


                        </div>

                    </div>


                </div>


                {{-- =================================================
                     USER
                ================================================== --}}

                <div class="user-info">


                    {{-- AVATAR --}}

                    <div class="user-avatar">

                        {{
                            strtoupper(
                                substr(
                                    auth()->user()->name ?? 'U',
                                    0,
                                    1
                                )
                            )
                        }}

                    </div>


                    {{-- USER TEXT --}}

                    <div class="user-text">


                        <span class="user-name">

                            {{ auth()->user()->name ?? 'User' }}

                        </span>


                        <span class="user-role">

                            {{
                                ucwords(
                                    str_replace(
                                        '_',
                                        ' ',
                                        auth()->user()->role ?? 'User'
                                    )
                                )
                            }}

                        </span>


                    </div>


                </div>


            </div>

        </header>


        {{-- =================================================
             MAIN CONTENT
        ================================================== --}}

        <main class="main-content">

            @yield('content')

        </main>


    </div>


</div>


{{-- =====================================================
     JAVASCRIPT NOTIFIKASI
====================================================== --}}

<script>

    function toggleNotification() {

        const popup =
            document.getElementById('notificationPopup');

        if (!popup) {
            return;
        }

        popup.classList.toggle('show');

    }


    /*
    |--------------------------------------------------------------------------
    | TUTUP POPUP KETIKA KLIK DI LUAR
    |--------------------------------------------------------------------------
    */

    document.addEventListener('click', function(event) {

        const wrapper =
            document.querySelector('.notification-wrapper');

        const popup =
            document.getElementById('notificationPopup');


        if (
            wrapper &&
            popup &&
            !wrapper.contains(event.target)
        ) {

            popup.classList.remove('show');

        }

    });

</script>


@stack('scripts')


</body>

</html>
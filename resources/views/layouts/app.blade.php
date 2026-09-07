<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

<<<<<<< HEAD
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
=======
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
>>>>>>> origin/main

    <title>
        @yield('title', 'Inventory IT Assets')
    </title>

<<<<<<< HEAD

    {{-- =====================================================
         BOOTSTRAP ICONS
    ====================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

=======
    {{-- =====================================================
         BOOTSTRAP ICONS
    ====================================================== --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
>>>>>>> origin/main

    {{-- =====================================================
         VITE
    ====================================================== --}}
<<<<<<< HEAD

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

=======
    @vite(['resources/css/app.css', 'resources/js/app.js'])
>>>>>>> origin/main

    <style>

        /* =====================================================
           RESET
        ===================================================== */

<<<<<<< HEAD
        *,
        *::before,
        *::after {
=======
        * {
>>>>>>> origin/main
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
<<<<<<< HEAD
=======
           Sidebar = 270px
>>>>>>> origin/main
        ===================================================== */

        .main-area {
            margin-left: 270px;

            width: calc(100% - 270px);
<<<<<<< HEAD

            min-width: 0;
            min-height: 100vh;

            margin-top: 0;
            padding-top: 0;

            box-sizing: border-box;
        }

=======
            min-width: 0;
            min-height: 100vh;
            box-sizing: border-box;
        }
>>>>>>> origin/main

        /* =====================================================
           TOP HEADER
        ===================================================== */

        .top-header {
            width: 100%;
            min-height: 75px;
<<<<<<< HEAD

            background: #ffffff;

            border: none;
=======
            background: #ffffff;
>>>>>>> origin/main
            border-bottom: 1px solid #e5e7eb;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 30px;

<<<<<<< HEAD
            margin: 0;

=======
>>>>>>> origin/main
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
<<<<<<< HEAD

            line-height: 1;
        }

=======
        }
>>>>>>> origin/main

        /* =====================================================
           HEADER SEARCH
           SEARCH HANYA UNTUK DASHBOARD
        ===================================================== */

        .top-header .search-box {
<<<<<<< HEAD
            width: 340px;
            height: 46px;
=======
            width: 300px;
            height: 40px;
>>>>>>> origin/main

            flex-shrink: 0;

            background: #f5f6fa;
<<<<<<< HEAD

            border: 1px solid #e1e5ec;

            border-radius: 24px;
=======
            border: 1px solid #e5e7eb;
            border-radius: 20px;
>>>>>>> origin/main

            display: flex;
            align-items: center;

<<<<<<< HEAD
            padding: 0 16px;
=======
            padding: 0 15px;
>>>>>>> origin/main
        }

        .top-header .search-box i {
<<<<<<< HEAD
            font-size: 19px;

            color: #8fa3bf;

            margin-right: 12px;
=======
            font-size: 16px;
            color: #9ca3af;
            margin-right: 9px;
>>>>>>> origin/main
        }

        .top-header .search-box input {
            width: 100%;

            border: none;
            outline: none;

            background: transparent;

<<<<<<< HEAD
            font-size: 14px;

=======
            font-size: 13px;
>>>>>>> origin/main
            color: #374151;
        }

        .top-header .search-box input::placeholder {
            color: #9ca3af;
        }
<<<<<<< HEAD

=======
>>>>>>> origin/main

        /* =====================================================
           HEADER RIGHT
        ===================================================== */

        .header-right {
            display: flex;
            align-items: center;
<<<<<<< HEAD

=======
>>>>>>> origin/main
            gap: 20px;
            flex-shrink: 0;
<<<<<<< HEAD

            height: 100%;
=======
>>>>>>> origin/main
        }


        /* =====================================================
           NOTIFICATION
        ===================================================== */

        .notification-wrapper {
            position: relative;
<<<<<<< HEAD

=======
>>>>>>> origin/main
            display: flex;
            align-items: center;
            justify-content: center;
        }

<<<<<<< HEAD

        .notification-button {
            position: relative;

=======
        .notification-button {
>>>>>>> origin/main
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
<<<<<<< HEAD
            background: #f3f4f6;
=======
            background: #f5f6fa;
>>>>>>> origin/main
        }


        .notification-button i {
<<<<<<< HEAD
            font-size: 18px;
=======
            font-size: 17px;
>>>>>>> origin/main
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

<<<<<<< HEAD
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

=======
        /* =====================================================
           USER
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

            flex-shrink: 0;

            border-radius: 50%;
            background: #071b88;
            color: #ffffff;

>>>>>>> origin/main
            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 15px;
            font-weight: bold;
<<<<<<< HEAD

            flex-shrink: 0;
=======
>>>>>>> origin/main
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
<<<<<<< HEAD

                width: calc(100% - 270px);
            }


            .top-header .search-box {
                width: 280px;
=======
                width: calc(100% - 270px);
            }

            .top-header .search-box {
                width: 240px;
>>>>>>> origin/main
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
<<<<<<< HEAD
                width: 250px;
            }


=======
                width: 220px;
            }

>>>>>>> origin/main
            .main-content {
                padding: 20px;
            }

        }

<<<<<<< HEAD

        @media (max-width: 700px) {

            .top-header {
                height: 70px;

                padding: 0 15px;
            }


            .header-left {
                gap: 12px;
            }

=======
        @media (max-width: 600px) {

            .top-header {
                min-height: 90px;
            }
>>>>>>> origin/main

            .page-title {
                font-size: 16px;
            }

<<<<<<< HEAD

=======
>>>>>>> origin/main
            .header-right {
                gap: 5px;
            }


            .user-info {
                padding-left: 8px;
            }

<<<<<<< HEAD
=======
            .top-header .search-box {
                width: 200px;
            }
>>>>>>> origin/main

            .user-text {
                display: none;
            }


            .top-header .search-box {
                width: 180px;
            }


            .main-content {
                padding: 18px 15px 25px;
            }
<<<<<<< HEAD


            .notification-popup {
                position: fixed;

                top: 70px;

                right: 15px;

                width: calc(100vw - 30px);

                max-width: 360px;
            }

        }
=======
>>>>>>> origin/main

        }

        @media (max-width: 500px) {

            .top-header .search-box {
<<<<<<< HEAD
                width: 150px;
=======
                width: 160px;
>>>>>>> origin/main
            }


            .main-content {
                padding: 15px;
<<<<<<< HEAD
            }


            .notification-popup {
                right: 10px;

                width: calc(100vw - 20px);
=======
>>>>>>> origin/main
            }

        }

<<<<<<< HEAD
=======
        /* =====================================================
           POPUP AKSES DITOLAK (GLOBAL)
        ===================================================== */

        .denied-popup-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 3000;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.25s ease;
        }

        .denied-popup-overlay.show {
            display: flex;
            opacity: 1;
        }

        .denied-popup-box {
            background: white;
            border-radius: 18px;
            padding: 32px 28px;
            width: 100%;
            max-width: 280px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            transform: scale(0.7) translateY(10px);
            opacity: 0;
            transition: transform 0.35s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.25s ease;
        }

        .denied-popup-overlay.show .denied-popup-box {
            transform: scale(1) translateY(0);
            opacity: 1;
        }

        .denied-popup-icon {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            border: 3px solid #dc2626;
            color: #dc2626;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin: 0 auto 16px;
            transform: scale(0);
            opacity: 0;
            transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) 0.15s, opacity 0.2s ease 0.15s;
        }

        .denied-popup-overlay.show .denied-popup-icon {
            transform: scale(1);
            opacity: 1;
            animation: deniedPulse 0.5s ease 0.15s;
        }

        @keyframes deniedPulse {
            0% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
            100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
        }

        .denied-popup-text {
            font-size: 14px;
            font-weight: 700;
            color: #7f1d1d;
            margin-bottom: 20px;
            line-height: 1.4;
            opacity: 0;
            transform: translateY(6px);
            transition: transform 0.3s ease 0.2s, opacity 0.3s ease 0.2s;
        }

        .denied-popup-overlay.show .denied-popup-text {
            opacity: 1;
            transform: translateY(0);
        }

        .denied-popup-ok {
            background: #dc2626;
            color: white;
            border: none;
            padding: 9px 28px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            opacity: 0;
            transform: translateY(6px);
            transition: transform 0.3s ease 0.25s, opacity 0.3s ease 0.25s, background 0.2s ease;
        }

        .denied-popup-overlay.show .denied-popup-ok {
            opacity: 1;
            transform: translateY(0);
        }

        .denied-popup-ok:hover {
            background: #b91c1c;
        }

>>>>>>> origin/main
    </style>


    @stack('styles')

</head>


<body>


<<<<<<< HEAD
<div class="app-layout">


=======
>>>>>>> origin/main
    {{-- =================================================
         SIDEBAR
    ================================================== --}}

    @include('sidebar')


    {{-- =================================================
         MAIN AREA
    ================================================== --}}

    <div class="main-area">
<<<<<<< HEAD

=======
>>>>>>> origin/main

        {{-- =================================================
             TOP HEADER
        ================================================== --}}

        <header class="top-header">

<<<<<<< HEAD

=======
>>>>>>> origin/main
            {{-- =================================================
                 HEADER LEFT
            ================================================== --}}

            <div class="header-left">


                {{-- PAGE TITLE --}}

                <h1 class="page-title">
<<<<<<< HEAD

                    @yield(
                        'page-title',
                        'Dashboard'
                    )

=======
                    @yield('page-title', 'Dashboard')
>>>>>>> origin/main
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

<<<<<<< HEAD

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

=======
                {{-- NOTIFICATION --}}

                <div class="notification-wrapper">

                    <button
                        class="notification-button"
                        type="button"
                        title="Notifikasi"
                    >

                        <i class="bi bi-bell"></i>

                        <span class="notification-badge"></span>

                    </button>

                </div>


                {{-- USER --}}

                <div class="user-info">

                    <div class="user-avatar">

                        {{ strtoupper(
                            substr(
                                auth()->user()->name ?? 'U',
                                0,
                                1
                            )
                        ) }}

                    </div>

                    <div class="user-text">

                        <span class="user-name">

                            {{ auth()->user()->name ?? 'User' }}

                        </span>

                        <span class="user-role">

                            {{ ucwords(
                                str_replace(
                                    '_',
                                    ' ',
                                    auth()->user()->role ?? 'User'
                                )
                            ) }}

                        </span>
>>>>>>> origin/main

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

<<<<<<< HEAD

=======
>>>>>>> origin/main
    </div>


</div>

<<<<<<< HEAD

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


=======
{{-- =================================================
     POPUP AKSES DITOLAK (GLOBAL)
================================================== --}}

<div class="denied-popup-overlay" id="deniedPopup">
    <div class="denied-popup-box">
        <div class="denied-popup-icon">
            <i class="bi bi-x-lg"></i>
        </div>
        <div class="denied-popup-text" id="deniedPopupText">
            Anda tidak memiliki hak akses untuk melakukan aksi ini.
        </div>
        <button type="button" class="denied-popup-ok" onclick="document.getElementById('deniedPopup').classList.remove('show')">
            OK
        </button>
    </div>
</div>

@if (session('permission_denied'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('deniedPopupText').textContent = @json(session('permission_denied'));
            document.getElementById('deniedPopup').classList.add('show');
        });
    </script>
@endif

>>>>>>> origin/main
@stack('scripts')


</body>
<<<<<<< HEAD

</html>
=======
</html>
</parameter>
>>>>>>> origin/main

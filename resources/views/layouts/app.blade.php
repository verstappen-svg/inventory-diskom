<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        /* =====================================================
           RESET
        ===================================================== */

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;
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
        }


        /* =====================================================
           MAIN AREA
        ===================================================== */

        .main-area {
            margin-left: 270px;
            width: calc(100% - 270px);
            min-width: 0;
            min-height: 100vh;
            box-sizing: border-box;
        }


        /* =====================================================
           TOP HEADER
        ===================================================== */

        .top-header {
            width: 100%;
            height: 75px;

            background: #ffffff;

            border-bottom: 1px solid #e5e7eb;

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 30px;

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
        }


        /* =====================================================
           HEADER SEARCH
        ===================================================== */

        .top-header .search-box {
            width: 300px;
            height: 40px;

            flex-shrink: 0;

            background: #f5f6fa;

            border: 1px solid #e5e7eb;

            border-radius: 20px;

            display: flex;
            align-items: center;

            padding: 0 15px;
        }


        .top-header .search-box i {
            font-size: 16px;

            color: #9ca3af;

            margin-right: 9px;
        }


        .top-header .search-box input {
            width: 100%;

            border: none;
            outline: none;

            background: transparent;

            font-size: 13px;

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
            background: rgba(255, 255, 255, 0.6);
        }


        .notification-button i {
            font-size: 15px;
        }


        .notification-badge {
            position: absolute;

            top: 5px;
            right: 4px;

            width: 8px;
            height: 8px;

            background: #ef4444;

            border-radius: 50%;

            border: 1px solid white;
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
           RESPONSIVE
        ===================================================== */

        @media (max-width: 1200px) {

            .main-area {
                margin-left: 270px;
                width: calc(100% - 270px);
            }

            .top-header .search-box {
                width: 240px;
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
                width: 220px;
            }

            .main-content {
                padding: 20px;
            }

        }


        @media (max-width: 600px) {

            .top-header {
                height: 90px;
            }

            .page-title {
                font-size: 13px;
            }

            .header-right {
                gap: 5px;
            }

            .user-info {
                padding-left: 8px;
            }

            .top-header .search-box {
                width: 200px;
            }

            .user-text {
                display: none;
            }

            .main-content {
                padding: 18px 15px 25px;
            }

        }


        @media (max-width: 500px) {

            .top-header .search-box {
                width: 160px;
            }

            .main-content {
                padding: 15px;
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
             HEADER
        ================================================== --}}

        <header class="top-header">


            {{-- HEADER LEFT --}}

            <div class="header-left">

                <h1 class="page-title">
                    @yield('page-title', 'Dashboard')
                </h1>


                {{-- SEARCH --}}

                @hasSection('search')

                    @yield('search')

                @else

                    <div class="search-box">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            placeholder="Search..."
                        >

                    </div>

                @endif

            </div>


            {{-- =================================================
                 HEADER RIGHT
            ================================================== --}}

            <div class="header-right">


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

                    </div>

                </div>

            </div>

        </header>


        {{-- =================================================
             CONTENT
        ================================================== --}}

        <main class="main-content">

            @yield('content')

        </main>


    </div>

</div>


@stack('scripts')

</body>

</html>
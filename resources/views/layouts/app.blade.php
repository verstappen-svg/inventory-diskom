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

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <style>

        * {
            box-sizing: border-box;
        }


        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
        }


        body {

            font-family: Arial, sans-serif;

            background: #eef4fc;

            color: #1f2937;

        }


        /* =====================================================
           APP LAYOUT
        ====================================================== */

        .app-layout {
            min-height: 100vh;
        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR
        |--------------------------------------------------------------------------
        | JANGAN DIUBAH.
        | Sidebar tetap menggunakan file milik teman.
        */

        .main-area {
            margin-left: 270px;

            width: calc(100% - 270px);
<<<<<<< HEAD
=======

            min-height: 100vh;

>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba
        }


        /* =====================================================
           TOP HEADER
        ====================================================== */

        .top-header {
<<<<<<< HEAD
            height: 75px;
=======

            height: 104px;
>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba

            background: #ffffff;

            border-bottom: 1px solid #e5e7eb;

            padding: 0 28px 10px;

            position: sticky;

            top: 0;

            z-index: 900;
        }


        /* =====================================================
           BRAND / SYSTEM TITLE
        ====================================================== */

<<<<<<< HEAD
        .header-left {
=======
        .header-brand {

            height: 34px;

>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba
            display: flex;

            align-items: center;

<<<<<<< HEAD
            gap: 20px;
        }


        .page-title {
            font-size: 20px;
=======
            justify-content: center;

        }


        .header-brand-title {

            margin: 0;

            font-size: 11px;
>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba

            font-weight: 700;

            letter-spacing: 0.3px;

<<<<<<< HEAD
            margin: 0;
        }
=======
            color: #111827;

            text-transform: uppercase;
>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba


        /* =====================================================
           HEADER RIGHT
        ====================================================== */

        .header-right {
            display: flex;

            align-items: center;

            gap: 20px;
        }


        /* =====================================================
<<<<<<< HEAD
           SEARCH
           HANYA MUNCUL DI DASHBOARD
        ====================================================== */

        .search-box {
            width: 300px;
=======
           PAGE HEADER BAR
        ====================================================== */

        .page-header-bar {

            height: 52px;
>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba

            width: 100%;

            background: #e5e7eb;

            border-radius: 12px;

            display: flex;

            align-items: center;

<<<<<<< HEAD
            padding: 0 15px;
        }


        .search-box i {
=======
            justify-content: space-between;

            padding: 0 15px 0 18px;

        }


        /* =====================================================
           PAGE TITLE
        ====================================================== */

        .page-title {

            margin: 0;

>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba
            font-size: 16px;

            font-weight: 700;

<<<<<<< HEAD
            margin-right: 9px;
        }


        .search-box input {
            width: 100%;

            border: none;

            outline: none;

            background: transparent;

            font-size: 13px;

            color: #374151;
        }


        .search-box input::placeholder {
            color: #9ca3af;
=======
            color: #111827;

            text-transform: uppercase;

        }


        /* =====================================================
           HEADER RIGHT
        ====================================================== */

        .header-right {

            display: flex;

            align-items: center;

            gap: 14px;

>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba
        }


        /* =====================================================
           NOTIFICATION
        ====================================================== */

<<<<<<< HEAD
        .notification-button {
            width: 40px;

            height: 40px;

            border: none;

            background: transparent;
=======
        .notification-wrapper {

            position: relative;
>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .notification-button {

            width: 32px;

            height: 32px;

            border: none;

            background: transparent;

            color: #374151;

            display: flex;

            align-items: center;

            justify-content: center;

            cursor: pointer;

<<<<<<< HEAD
            color: #075985;
=======
            border-radius: 7px;

            transition: 0.2s ease;

        }


        .notification-button:hover {

            background: rgba(255,255,255,0.6);

>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba
        }


        .notification-button i {
<<<<<<< HEAD
            font-size: 21px;
=======

            font-size: 15px;

>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba
        }


        .notification-badge {
            position: absolute;

            top: 6px;

            right: 5px;

            width: 6px;

            height: 6px;

            background: #ef4444;

            border-radius: 50%;

<<<<<<< HEAD
            border: 2px solid white;
=======
            border: 1px solid white;

>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba
        }


        /* =====================================================
           USER PROFILE
        ====================================================== */

        .user-info {
            display: flex;

            align-items: center;

<<<<<<< HEAD
            gap: 10px;
=======
            gap: 8px;

            padding-left: 12px;

            border-left: 1px solid #d1d5db;

>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba
        }


        .user-avatar {
<<<<<<< HEAD
            width: 38px;
=======

            width: 32px;
>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba

            height: 32px;

            flex-shrink: 0;

            border-radius: 50%;

            background: #071b88;

            color: #ffffff;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 12px;

<<<<<<< HEAD
            font-weight: bold;
=======
            font-weight: 700;

>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba
        }


        .user-text {
            display: flex;

            flex-direction: column;

            gap: 2px;
<<<<<<< HEAD
=======

            min-width: 75px;

>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba
        }


        .user-name {
<<<<<<< HEAD
            font-size: 13px;
=======

            font-size: 10px;
>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba

            font-weight: 700;

            color: #374151;
<<<<<<< HEAD
=======

            line-height: 1.2;

>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba
        }


        .user-role {
<<<<<<< HEAD
            font-size: 11px;

            color: #9ca3af;
=======

            font-size: 8px;

            color: #9ca3af;

            line-height: 1.2;

>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba
        }


        /* =====================================================
           MAIN CONTENT
        ====================================================== */

        .main-content {
<<<<<<< HEAD
            padding: 30px;

            min-height: calc(100vh - 75px);
=======

            padding: 27px 28px 35px;

            min-height: calc(100vh - 104px);

>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba
        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 1000px) {

            .main-area {
                margin-left: 0;

                width: 100%;
            }

            .top-header {

<<<<<<< HEAD
            .search-box {
                width: 230px;
=======
                padding-left: 20px;

                padding-right: 20px;

            }

            .main-content {

                padding: 22px 20px 30px;

>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba
            }

        }


<<<<<<< HEAD
        @media (max-width: 750px) {

            .search-box {
                width: 200px;
            }

=======
        @media (max-width: 600px) {

            .top-header {

                height: 90px;

            }

            .header-brand {

                height: 29px;

            }

            .page-header-bar {

                height: 46px;

            }

            .page-title {

                font-size: 13px;

            }
>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba

            .user-text {
                display: none;
            }

        }


        @media (max-width: 600px) {

            .page-title {
                font-size: 17px;
            }


            .search-box {
                width: 170px;
            }


            .header-right {
                gap: 5px;
            }

            .user-info {

                padding-left: 8px;

            }

            .main-content {

                padding: 18px 15px 25px;

            }

        }

    </style>


    @stack('styles')

</head>


<body>


<div class="app-layout">


    {{-- =================================================
         SIDEBAR
         TIDAK DIUBAH
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


            {{-- =================================================
                 INVENTORY IT ASSETS
            ================================================== --}}

            <div class="header-brand">

                <h1 class="header-brand-title">

                    INVENTORY IT ASSETS

                </h1>

            </div>


            {{-- =================================================
<<<<<<< HEAD
                 HEADER
=======
                 PAGE HEADER BAR
>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba
            ================================================== --}}

            <div class="page-header-bar">


<<<<<<< HEAD
                {{-- =============================================
                     JUDUL HALAMAN
                ============================================== --}}
=======
                {{-- PAGE TITLE --}}
>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba

                <h2 class="page-title">

                    @yield('page-title', 'Dashboard')

                </h2>

                </div>

<<<<<<< HEAD

                {{-- =============================================
                     HEADER RIGHT
                ============================================== --}}
=======
                {{-- RIGHT SIDE --}}
>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba

                <div class="header-right">


<<<<<<< HEAD
                    {{-- =========================================
                         SEARCH
                         HANYA DASHBOARD
                    ========================================== --}}

                    @if(request()->routeIs('dashboard'))

                        <div class="search-box">

                            <i class="bi bi-search"></i>

                            <input
                                type="text"
                                placeholder="Search..."
                            >

                        </div>

                    @endif


                    {{-- =========================================
                         NOTIFICATION
                    ========================================== --}}

                    <button
                        type="button"
                        class="notification-button">
=======
                    {{-- NOTIFICATION --}}

                    <div class="notification-wrapper">
>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba

                        <button
                            type="button"
                            class="notification-button"
                            title="Notifikasi"
                        >

                            <i class="bi bi-bell"></i>

                            <span class="notification-badge"></span>

                        </button>

                    </div>


                    {{-- =========================================
                         USER
                    ========================================== --}}

                    <div class="user-info">


                        {{-- AVATAR --}}

                        <div class="user-avatar">

                            {{ strtoupper(
                                substr(
                                    auth()->user()->name ?? 'U',
                                    0,
                                    1
                                )
                            ) }}

                        </div>


                        {{-- USER NAME + ROLE --}}

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


            </div>


<<<<<<< HEAD
            {{-- =================================================
                 CONTENT
            ================================================== --}}

            <main class="main-content">

                @yield('content')

            </main>
=======
        </header>
>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba


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
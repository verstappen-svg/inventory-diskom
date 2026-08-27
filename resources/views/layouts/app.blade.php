<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">


    {{-- =====================================================
         TITLE
    ====================================================== --}}

    <title>
        @yield('title', 'Inventory IT Assets')
    </title>


    {{-- =====================================================
         BOOTSTRAP ICONS
    ====================================================== --}}

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    {{-- =====================================================
         STYLE UTAMA
    ====================================================== --}}

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
            margin: 0;

            font-family: Arial, sans-serif;

            background: #f5f6fa;

            color: #1f2937;
        }


        /* =====================================================
           LAYOUT
        ====================================================== */

        .app-layout {
            min-height: 100vh;
        }


        /* =====================================================
           MAIN AREA
        ====================================================== */

        .main-area {
            margin-left: 270px;

            min-height: 100vh;

            width: calc(100% - 270px);
        }


        /* =====================================================
           HEADER
        ====================================================== */

        .top-header {
            height: 75px;

            background: white;

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
        ====================================================== */

        .header-left {
            display: flex;

            align-items: center;

            gap: 20px;
        }


        .page-title {
            font-size: 20px;

            font-weight: 700;

            color: #075985;

            margin: 0;
        }


        /* =====================================================
           HEADER RIGHT
        ====================================================== */

        .header-right {
            display: flex;

            align-items: center;

            gap: 20px;
        }


        /* =====================================================
           SEARCH
           HANYA MUNCUL DI DASHBOARD
        ====================================================== */

        .search-box {
            width: 300px;

            height: 40px;

            background: #f5f6fa;

            border: 1px solid #e5e7eb;

            border-radius: 20px;

            display: flex;

            align-items: center;

            padding: 0 15px;
        }


        .search-box i {
            font-size: 16px;

            color: #9ca3af;

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
        }


        /* =====================================================
           NOTIFICATION
        ====================================================== */

        .notification-button {
            width: 40px;

            height: 40px;

            border: none;

            background: transparent;

            display: flex;

            align-items: center;

            justify-content: center;

            position: relative;

            cursor: pointer;

            color: #075985;
        }


        .notification-button i {
            font-size: 21px;
        }


        .notification-badge {
            position: absolute;

            top: 5px;

            right: 4px;

            width: 8px;

            height: 8px;

            background: #ef4444;

            border-radius: 50%;

            border: 2px solid white;
        }


        /* =====================================================
           PROFILE
        ====================================================== */

        .user-info {
            display: flex;

            align-items: center;

            gap: 10px;
        }


        .user-avatar {
            width: 38px;

            height: 38px;

            border-radius: 50%;

            background: #071b88;

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 15px;

            font-weight: bold;
        }


        .user-text {
            display: flex;

            flex-direction: column;

            gap: 2px;
        }


        .user-name {
            font-size: 13px;

            font-weight: 700;

            color: #374151;
        }


        .user-role {
            font-size: 11px;

            color: #9ca3af;
        }


        /* =====================================================
           CONTENT
        ====================================================== */

        .main-content {
            padding: 30px;

            min-height: calc(100vh - 75px);
        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 1000px) {

            .main-area {
                margin-left: 0;

                width: 100%;
            }


            .search-box {
                width: 230px;
            }

        }


        @media (max-width: 750px) {

            .search-box {
                width: 200px;
            }


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


                {{-- =============================================
                     JUDUL HALAMAN
                ============================================== --}}

                <div class="header-left">

                    <h1 class="page-title">

                        @yield('page-title', 'Dashboard')

                    </h1>

                </div>


                {{-- =============================================
                     HEADER RIGHT
                ============================================== --}}

                <div class="header-right">


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

                        <i class="bi bi-bell"></i>

                        <span class="notification-badge"></span>

                    </button>


                    {{-- =========================================
                         USER
                    ========================================== --}}

                    <div class="user-info">

                        <div class="user-avatar">
                            A
                        </div>


                        <div class="user-text">

                            <span class="user-name">
                                Admin
                            </span>

                            <span class="user-role">
                                Super Admin
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
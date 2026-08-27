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

            min-height: 100vh;

        }


        /* =====================================================
           TOP HEADER
        ====================================================== */

        .top-header {

            height: 104px;

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

        .header-brand {

            height: 34px;

            display: flex;

            align-items: center;

            justify-content: center;

        }


        .header-brand-title {

            margin: 0;

            font-size: 11px;

            font-weight: 700;

            letter-spacing: 0.3px;

            color: #111827;

            text-transform: uppercase;

        }


        /* =====================================================
           PAGE HEADER BAR
        ====================================================== */

        .page-header-bar {

            height: 52px;

            width: 100%;

            background: #e5e7eb;

            border-radius: 12px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 0 15px 0 18px;

        }


        /* =====================================================
           PAGE TITLE
        ====================================================== */

        .page-title {

            margin: 0;

            font-size: 16px;

            font-weight: 700;

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

        }


        /* =====================================================
           NOTIFICATION
        ====================================================== */

        .notification-wrapper {

            position: relative;

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

            border-radius: 7px;

            transition: 0.2s ease;

        }


        .notification-button:hover {

            background: rgba(255,255,255,0.6);

        }


        .notification-button i {

            font-size: 15px;

        }


        .notification-badge {

            position: absolute;

            top: 6px;

            right: 5px;

            width: 6px;

            height: 6px;

            background: #ef4444;

            border-radius: 50%;

            border: 1px solid white;

        }


        /* =====================================================
           USER PROFILE
        ====================================================== */

        .user-info {

            display: flex;

            align-items: center;

            gap: 8px;

            padding-left: 12px;

            border-left: 1px solid #d1d5db;

        }


        .user-avatar {

            width: 32px;

            height: 32px;

            flex-shrink: 0;

            border-radius: 50%;

            background: #071b88;

            color: #ffffff;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 12px;

            font-weight: 700;

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
        ====================================================== */

        .main-content {

            padding: 27px 28px 35px;

            min-height: calc(100vh - 104px);

        }


        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 900px) {

            .main-area {

                margin-left: 0;

                width: 100%;

            }

            .top-header {

                padding-left: 20px;

                padding-right: 20px;

            }

            .main-content {

                padding: 22px 20px 30px;

            }

        }


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

            .user-text {

                display: none;

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
                 PAGE HEADER BAR
            ================================================== --}}

            <div class="page-header-bar">


                {{-- PAGE TITLE --}}

                <h2 class="page-title">

                    @yield('page-title', 'Dashboard')

                </h2>


                {{-- RIGHT SIDE --}}

                <div class="header-right">


                    {{-- NOTIFICATION --}}

                    <div class="notification-wrapper">

                        <button
                            type="button"
                            class="notification-button"
                            title="Notifikasi"
                        >

                            <i class="bi bi-bell"></i>

                            <span class="notification-badge"></span>

                        </button>

                    </div>


                    {{-- USER --}}

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
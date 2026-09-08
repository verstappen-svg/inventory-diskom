<<<<<<< HEAD
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
=======
{{-- =========================================================
     SIDEBAR
========================================================= --}}

<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

@php
    $role = auth()->user()->role ?? null;
@endphp

>>>>>>> 43dae04 (Update verification and layout)

<aside class="sidebar">

    {{-- =====================================================
         LOGO
    ====================================================== --}}
<<<<<<< HEAD
=======

>>>>>>> 43dae04 (Update verification and layout)
    <div class="logo-section">

        <div class="logo-box">

<<<<<<< HEAD
            <img src="{{ asset('images/logo-diskominfo.png') }}"
                 alt="Logo Diskominfo">

            <img src="{{ asset('images/logo-pemkot.png') }}"
                 alt="Logo Kota Bekasi">
=======
            <img
                src="{{ asset('images/logo-diskominfo.png') }}"
                alt="Logo Diskominfo"
            >

            <img
                src="{{ asset('images/logo-pemkot.png') }}"
                alt="Logo Kota Bekasi"
            >
>>>>>>> 43dae04 (Update verification and layout)

        </div>

        <div class="logo-title">
            INVENTORY IT ASSETS
        </div>

    </div>

<<<<<<< HEAD
    {{-- =====================================================
         MENU
    ====================================================== --}}
    <nav class="menu">

        @if (auth()->user()->role === 'super_admin')

            {{-- ============== MENU SUPER ADMIN ============== --}}

            <a href="/dashboard"
               class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('pengguna.index') }}"
               class="menu-item {{ request()->is('pengguna*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Manajemen Pengguna</span>
            </a>

            <a href="{{ route('log-aktivitas.index') }}"
               class="menu-item {{ request()->is('log-aktivitas*') ? 'active' : '' }}">
                <i class="bi bi-activity"></i>
                <span>Log Aktivitas</span>
            </a>

        @else

            @php
                $role = auth()->user()->role;
                $canView = fn($menuKey) => \App\Models\RolePermission::allows($role, $menuKey, 'can_view');
            @endphp

            {{-- ============== MENU OPERATOR/VERIFIKATOR/PIMPINAN (sesuai hak akses) ============== --}}

            <a href="/dashboard"
               class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>

            @if ($canView('hardware'))
                <a href="/hardware"
                   class="menu-item {{ request()->is('hardware*') ? 'active' : '' }}">
                    <i class="bi bi-pc-display"></i>
                    <span>Hardware</span>
                </a>
            @endif

            @if ($canView('software'))
                <a href="/software"
                   class="menu-item {{ request()->is('software*') ? 'active' : '' }}">
                    <i class="bi bi-laptop"></i>
                    <span>Software</span>
                </a>
            @endif

            @php
                $showInfra = $canView('infrastruktur.jaringan') || $canView('infrastruktur.data-center') || $canView('infrastruktur.splp');
            @endphp

            @if ($showInfra)
                <div class="infrastructure">

                    <button type="button"
                            id="infrastructure-button"
                            class="menu-item infrastructure-button {{ request()->is('infrastruktur/*') ? 'active' : '' }}"
                            onclick="toggleInfrastructure()">
                        <i class="bi bi-diagram-3-fill"></i>
                        <span>Infrastruktur</span>
                        <i id="infrastructure-arrow"
                           class="bi {{ request()->is('infrastruktur/*') ? 'bi-chevron-down' : 'bi-chevron-right' }} arrow"></i>
                    </button>

                    <div id="infrastructure-submenu"
                         class="submenu {{ request()->is('infrastruktur/*') ? 'show' : '' }}">

                        @if ($canView('infrastruktur.jaringan'))
                            <a href="/infrastruktur/jaringan"
                               class="{{ request()->is('infrastruktur/jaringan') ? 'active' : '' }}">
                                <i class="bi bi-wifi"></i>
                                <span>Jaringan</span>
                            </a>
                        @endif

                        @if ($canView('infrastruktur.data-center'))
                            <a href="/infrastruktur/data-center"
                               class="{{ request()->is('infrastruktur/data-center') ? 'active' : '' }}">
                                <i class="bi bi-pie-chart-fill"></i>
                                <span>Data Center</span>
                            </a>
                        @endif

                        @if ($canView('infrastruktur.splp'))
                            <a href="/infrastruktur/splp"
                               class="{{ request()->is('infrastruktur/splp') ? 'active' : '' }}">
                                <i class="bi bi-diagram-2-fill"></i>
                                <span>SPLP</span>
                            </a>
                        @endif

                    </div>

                </div>
            @endif

            @if ($canView('data'))
                <a href="/data"
                   class="menu-item {{ request()->is('data*') ? 'active' : '' }}">
                    <i class="bi bi-server"></i>
                    <span>Data</span>
                </a>
            @endif

            @if ($canView('sdm'))
                <a href="/sdm"
                   class="menu-item {{ request()->is('sdm*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>SDM</span>
                </a>
            @endif

            @if ($canView('laporan'))
                <a href="/laporan"
                   class="menu-item {{ request()->is('laporan*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    <span>Laporan</span>
                </a>
            @endif

=======

    {{-- =====================================================
         MENU
    ====================================================== --}}

    <nav class="menu">


        {{-- =================================================
             DASHBOARD
        ================================================== --}}

        <a
            href="{{ route('dashboard') }}"
            class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}"
        >

            <i class="bi bi-grid-fill"></i>

            <span>
                Dashboard
            </span>

        </a>


        {{-- =================================================
             MENU KHUSUS VERIFIKATOR
        ================================================== --}}

        @if($role === 'verifikator')

            <a
                href="{{ route('verifikasi.index') }}"
                class="menu-item {{ request()->is('verifikasi*') ? 'active' : '' }}"
            >

                <i class="bi bi-journal-check"></i>

                <span>
                    Verifikasi
                </span>

            </a>


        {{-- =================================================
             MENU OPERATOR / SUPER ADMIN
        ================================================== --}}

        @elseif(in_array($role, ['operator', 'super_admin']))

            {{-- HARDWARE --}}

            <a
                href="{{ route('hardware.index') }}"
                class="menu-item {{ request()->is('hardware*') ? 'active' : '' }}"
            >

                <i class="bi bi-pc-display"></i>

                <span>
                    Hardware
                </span>

            </a>


            {{-- SOFTWARE --}}

            <a
                href="{{ route('software.index') }}"
                class="menu-item {{ request()->is('software*') ? 'active' : '' }}"
            >

                <i class="bi bi-laptop"></i>

                <span>
                    Software
                </span>

            </a>


            {{-- =================================================
                 INFRASTRUKTUR
            ================================================== --}}

            <div class="infrastructure">

                <button
                    type="button"
                    id="infrastructure-button"
                    class="menu-item infrastructure-button
                    {{ request()->is('infrastruktur/*') ? 'active' : '' }}"
                    onclick="toggleInfrastructure()"
                >

                    <i class="bi bi-diagram-3-fill"></i>

                    <span>
                        Infrastruktur
                    </span>

                    <i
                        id="infrastructure-arrow"
                        class="bi
                        {{ request()->is('infrastruktur/*')
                            ? 'bi-chevron-down'
                            : 'bi-chevron-right' }}
                        arrow"
                    ></i>

                </button>


                {{-- SUBMENU --}}

                <div
                    id="infrastructure-submenu"
                    class="submenu
                    {{ request()->is('infrastruktur/*') ? 'show' : '' }}"
                >

                    {{-- JARINGAN --}}

                    <a
                        href="{{ route('jaringan.index') }}"
                        class="{{ request()->is('infrastruktur/jaringan*') ? 'active' : '' }}"
                    >

                        <i class="bi bi-wifi"></i>

                        <span>
                            Jaringan
                        </span>

                    </a>


                    {{-- DATA CENTER --}}

                    <a
                        href="{{ route('data-center.index') }}"
                        class="{{ request()->is('infrastruktur/data-center*') ? 'active' : '' }}"
                    >

                        <i class="bi bi-pie-chart-fill"></i>

                        <span>
                            Data Center
                        </span>

                    </a>


                    {{-- SPLP --}}

                    <a
                        href="{{ route('splp.index') }}"
                        class="{{ request()->is('infrastruktur/splp*') ? 'active' : '' }}"
                    >

                        <i class="bi bi-diagram-2-fill"></i>

                        <span>
                            SPLP
                        </span>

                    </a>

                </div>

            </div>


            {{-- DATA --}}

            <a
                href="{{ route('data.index') }}"
                class="menu-item {{ request()->is('data*') ? 'active' : '' }}"
            >

                <i class="bi bi-server"></i>

                <span>
                    Data
                </span>

            </a>


            {{-- SDM --}}

            <a
                href="{{ route('sdm.index') }}"
                class="menu-item {{ request()->is('sdm*') ? 'active' : '' }}"
            >

                <i class="bi bi-people-fill"></i>

                <span>
                    SDM
                </span>

            </a>


            {{-- LAPORAN --}}

            <a
                href="{{ route('laporan.index') }}"
                class="menu-item {{ request()->is('laporan*') ? 'active' : '' }}"
            >

                <i class="bi bi-file-earmark-text-fill"></i>

                <span>
                    Laporan
                </span>

            </a>


        {{-- =================================================
             PIMPINAN
        ================================================== --}}

        @elseif($role === 'pimpinan')

            <a
                href="{{ route('laporan.index') }}"
                class="menu-item {{ request()->is('laporan*') ? 'active' : '' }}"
            >

                <i class="bi bi-file-earmark-text-fill"></i>

                <span>
                    Laporan
                </span>

            </a>

>>>>>>> 43dae04 (Update verification and layout)
        @endif

    </nav>

<<<<<<< HEAD
    {{-- =====================================================
         LOGOUT
    ====================================================== --}}
    <div class="sidebar-bottom">

        <form action="/logout" method="POST">
            @csrf

            <button type="submit"
                    class="logout-button"
                    title="Logout">
=======

    {{-- =====================================================
         LOGOUT
    ====================================================== --}}

    <div class="sidebar-bottom">

        <form
            action="{{ route('logout') }}"
            method="POST"
        >

            @csrf

            <button
                type="submit"
                class="logout-button"
                title="Logout"
            >

>>>>>>> 43dae04 (Update verification and layout)
                <i class="bi bi-box-arrow-right"></i>

            </button>

        </form>

    </div>

</aside>


<style>
<<<<<<< HEAD
    /* =========================================================
       SIDEBAR
    ========================================================= */
    .sidebar {
        position: fixed;
        left: 0;
        top: 0;
        width: 270px;
        height: 100vh;
        background: #079bd8;
        color: white;
        display: flex;
        flex-direction: column;
        box-shadow: 3px 0 10px rgba(0, 0, 0, 0.20);
        z-index: 1000;
        overflow: hidden;
    }

    /* =========================================================
       LOGO
    ========================================================= */
    .logo-section {
        padding: 18px 18px 21px;
        text-align: center;
    }

    .logo-box {
        height: 105px;
        background: white;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 20px;
        padding: 8px 17px;
        overflow: hidden;
    }

    .logo-box img {
        width: 43%;
        max-height: 86px;
        object-fit: contain;
        opacity: 1 !important;
        filter: none !important;
    }

    .logo-title {
        margin-top: 12px;
        font-size: 13px;
        font-weight: bold;
        letter-spacing: 1.3px;
    }

    /* =========================================================
       MENU
    ========================================================= */
    .menu {
        padding: 0 18px;
        flex: 1;
        overflow-y: auto;
    }
=======

/* =========================================================
   SIDEBAR
========================================================= */

.sidebar {
    position: fixed;
    left: 0;
    top: 0;

    width: 270px;
    height: 100vh;

    background: #079bd8;
    color: white;

    display: flex;
    flex-direction: column;

    box-shadow: 3px 0 10px rgba(0, 0, 0, 0.20);

    z-index: 1000;

    overflow: hidden;
}


/* =========================================================
   LOGO
========================================================= */

.logo-section {
    padding: 18px 18px 21px;
    text-align: center;
}

.logo-box {
    height: 105px;

    background: white;

    border-radius: 13px;

    display: flex;
    align-items: center;
    justify-content: center;

    gap: 20px;

    padding: 8px 17px;

    overflow: hidden;
}

.logo-box img {
    width: 43%;
    max-height: 86px;

    object-fit: contain;
}

.logo-title {
    margin-top: 12px;

    font-size: 13px;
    font-weight: bold;

    letter-spacing: 1.3px;
}


/* =========================================================
   MENU
========================================================= */

.menu {
    padding: 0 18px;

    flex: 1;

    overflow-y: auto;
}
>>>>>>> 43dae04 (Update verification and layout)

    .menu::-webkit-scrollbar {
        width: 0;
    }

<<<<<<< HEAD
    /* =========================================================
       MENU ITEM
    ========================================================= */
    .menu-item {
        width: 100%;
        height: 47px;
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 0 18px;
        margin-bottom: 12px;
        border: none;
        border-radius: 24px;
        background: white;
        color: #075985;
        text-decoration: none;
        font-family: Arial, sans-serif;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    /* =========================================================
       ICON
    ========================================================= */
    .menu-item i {
        font-size: 17px;
        min-width: 20px;
        text-align: center;
    }

    /* =========================================================
       HOVER
    ========================================================= */
    .menu-item:hover {
        background: #071b88;
        color: white;
    }

    /* =========================================================
       MENU AKTIF
    ========================================================= */
    .menu-item.active {
        background: #071b88;
        color: white;
        box-shadow: 0 4px 7px rgba(0, 0, 0, 0.30);
    }

    .menu-item.active:hover {
        background: #071b88;
        color: white;
    }

    /* =========================================================
       INFRASTRUKTUR
    ========================================================= */
    .infrastructure-button {
        background: white;
        color: #075985;
    }
=======

/* =========================================================
   MENU ITEM
========================================================= */

.menu-item {
    width: 100%;
    height: 47px;

    display: flex;
    align-items: center;

    gap: 15px;

    padding: 0 18px;

    margin-bottom: 12px;

    border: none;

    border-radius: 24px;

    background: white;
    color: #075985;

    text-decoration: none;

    font-size: 13px;
    font-weight: 600;

    cursor: pointer;

    transition: all 0.2s ease;
}

.menu-item i {
    font-size: 17px;

    min-width: 20px;

    text-align: center;
}


/* =========================================================
   ACTIVE / HOVER
========================================================= */

.menu-item:hover,
.menu-item.active,
.infrastructure-button:hover,
.infrastructure-button.active,
.submenu a:hover,
.submenu a.active {
    background: #071b88;
    color: white;
}


/* =========================================================
   INFRASTRUCTURE
========================================================= */

.infrastructure {
    margin-bottom: 12px;
}

.infrastructure-button {
    margin-bottom: 0;

    justify-content: space-between;
}

.infrastructure-button > span {
    flex: 1;
    text-align: left;
}

.infrastructure-button .arrow {
    min-width: auto;
    font-size: 13px;
}


/* =========================================================
   SUBMENU
========================================================= */

.submenu {
    display: none;

    flex-direction: column;

    gap: 6px;

    padding: 8px 0 0 15px;
}
>>>>>>> 43dae04 (Update verification and layout)

    .infrastructure-button:hover,
    .infrastructure-button.active,
    .infrastructure-button.active:hover {
        background: #071b88;
        color: white;
    }

<<<<<<< HEAD
    .infrastructure-button.active {
        box-shadow: 0 4px 7px rgba(0, 0, 0, 0.30);
    }

    /* =========================================================
       ARROW
    ========================================================= */
    .arrow {
        margin-left: auto;
        min-width: auto !important;
        font-size: 12px !important;
    }

    /* =========================================================
       SUBMENU
    ========================================================= */
    .submenu {
        display: none;
        padding-left: 28px;
        margin-bottom: 11px;
    }

    .submenu.show {
        display: block;
    }

    /* =========================================================
       SUBMENU ITEM
    ========================================================= */
    .submenu a {
        height: 40px;
        display: flex;
        align-items: center;
        gap: 11px;
        padding: 0 16px;
        margin-bottom: 9px;
        background: white;
        color: #075985;
        text-decoration: none;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .submenu a i {
        font-size: 15px;
        min-width: 16px;
        text-align: center;
    }

    .submenu a:hover,
    .submenu a.active,
    .submenu a.active:hover {
        background: #071b88;
        color: white;
    }

    .submenu a.active {
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.20);
    }

    /* =========================================================
       BAGIAN BAWAH
    ========================================================= */
    .sidebar-bottom {
        padding: 15px 24px 25px;
        display: flex;
        align-items: center;
        justify-content: flex-end;
        border-top: 1px solid rgba(255, 255, 255, 0.15);
    }

    .sidebar-bottom form {
        margin: 0;
    }

    /* =========================================================
       LOGOUT
    ========================================================= */
    .logout-button {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        background: transparent;
        color: white;
        font-size: 29px;
        cursor: pointer;
        padding: 0;
        transition: all 0.2s ease;
    }

    .logout-button i {
        color: white;
        display: block;
    }

    .logout-button:hover {
        opacity: 0.7;
        transform: scale(1.08);
    }
=======
.submenu a {
    display: flex;
    align-items: center;

    gap: 12px;

    padding: 10px 15px;

    border-radius: 18px;

    background: rgba(255, 255, 255, 0.15);

    color: white;

    text-decoration: none;

    font-size: 12px;
    font-weight: 500;

    transition: all 0.2s ease;
}

.submenu a i {
    font-size: 14px;
}


/* =========================================================
   LOGOUT
========================================================= */

.sidebar-bottom {
    padding: 18px;

    display: flex;

    justify-content: flex-end;
}

.logout-button {
    background: #ef4444;

    color: white;

    border: none;

    width: 40px;
    height: 40px;

    border-radius: 50%;

    display: flex;
    align-items: center;
    justify-content: center;

    cursor: pointer;

    transition: background 0.2s ease;
}

.logout-button:hover {
    background: #dc2626;
}

.logout-button i {
    font-size: 18px;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 1000px) {

    .sidebar {
        width: 240px;
    }

}

>>>>>>> 43dae04 (Update verification and layout)
</style>


<script>
<<<<<<< HEAD
    /* =========================================================
       TOGGLE INFRASTRUKTUR
    ========================================================= */
    function toggleInfrastructure() {

        const button = document.getElementById('infrastructure-button');
        const submenu = document.getElementById('infrastructure-submenu');
        const arrow = document.getElementById('infrastructure-arrow');

        if (!button || !submenu || !arrow) {
            return;
        }

        if (submenu.classList.contains('show')) {
            submenu.classList.remove('show');
            button.classList.remove('active');
            arrow.classList.remove('bi-chevron-down');
            arrow.classList.add('bi-chevron-right');
        } else {
            submenu.classList.add('show');
            button.classList.add('active');
            arrow.classList.remove('bi-chevron-right');
            arrow.classList.add('bi-chevron-down');
        }
    }
=======

function toggleInfrastructure() {

    const submenu =
        document.getElementById('infrastructure-submenu');

    const arrow =
        document.getElementById('infrastructure-arrow');


    if (!submenu || !arrow) {
        return;
    }


    if (submenu.classList.contains('show')) {

        submenu.classList.remove('show');

        arrow.classList.replace(
            'bi-chevron-down',
            'bi-chevron-right'
        );

    } else {

        submenu.classList.add('show');

        arrow.classList.replace(
            'bi-chevron-right',
            'bi-chevron-down'
        );

    }

}

>>>>>>> 43dae04 (Update verification and layout)
</script>
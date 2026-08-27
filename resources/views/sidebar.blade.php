<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<aside class="sidebar">

    {{-- =====================================================
         LOGO
    ====================================================== --}}

    <div class="logo-section">

        <div class="logo-box">

            <img src="{{ asset('images/logo-diskominfo.png') }}"
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 6169ebcf4cdae25d56b05bc747c66aaa5fc790ba
                 alt="Logo Diskom">

            <img src="{{ asset('images/logo-pemkot.png') }}"
                 alt="Logo Kota Bekasi">
=======
                alt="Logo Diskominfo">

            <img src="{{ asset('images/logo-pemkot.png') }}"
                alt="Logo Kota Bekasi">
>>>>>>> c312f5b16b5e652a59efe8b8a431ce069767414e

        </div>

        <div class="logo-title">
            INVENTORY IT ASSETS
        </div>

    </div>


    {{-- =====================================================
         MENU
    ====================================================== --}}

    <nav class="menu">

         {{-- DASHBOARD --}}
        <a href="/dashboard"
            class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">

            <i class="bi bi-grid-fill"></i>

            <span>Dashboard</span>

        </a>
        

        {{-- HARDWARE --}}
        <a href="/hardware"
           class="menu-item {{ request()->is('hardware*') ? 'active' : '' }}">

            <i class="bi bi-pc-display"></i>

            <span>Hardware</span>

        </a>


        {{-- SOFTWARE --}}
        <a href="/software"
           class="menu-item {{ request()->is('software*') ? 'active' : '' }}">

            <i class="bi bi-laptop"></i>

            <span>Software</span>

        </a>


        {{-- =================================================
             INFRASTRUKTUR
        ================================================== --}}

        

        <div class="infrastructure">
            

            <button type="button"
                    id="infrastructure-button"
                    class="menu-item infrastructure-button
                    {{ request()->is('infrastruktur/*') ? 'active' : '' }}"
                    onclick="toggleInfrastructure()">

                <i class="bi bi-diagram-3-fill"></i>

                <span>Infrastruktur</span>

                <i id="infrastructure-arrow"
                   class="bi
                   {{ request()->is('infrastruktur/*') ? 'bi-chevron-down' : 'bi-chevron-right' }}
                   arrow">
                </i>

            </button>


            {{-- SUBMENU --}}
            <div id="infrastructure-submenu"
                 class="submenu
                 {{ request()->is('infrastruktur/*') ? 'show' : '' }}">

                {{-- JARINGAN --}}
                <a href="/infrastruktur/jaringan"
                   class="{{ request()->is('infrastruktur/jaringan') ? 'active' : '' }}">

                    <i class="bi bi-wifi"></i>

                    <span>Jaringan</span>

                </a>


                {{-- DATA CENTER --}}
                <a href="/infrastruktur/data-center"
                   class="{{ request()->is('infrastruktur/data-center') ? 'active' : '' }}">

                    <i class="bi bi-pie-chart-fill"></i>

                    <span>Data Center</span>

                </a>


                {{-- SPLP --}}
                <a href="/infrastruktur/splp"
                   class="{{ request()->is('infrastruktur/splp') ? 'active' : '' }}">

                    <i class="bi bi-diagram-2-fill"></i>

                    <span>SPLP</span>

                </a>

            </div>

        </div>


        {{-- DATA --}}
        <a href="/data"
           class="menu-item {{ request()->is('data*') ? 'active' : '' }}">

            <i class="bi bi-server"></i>

            <span>Data</span>

        </a>


        {{-- SDM --}}
        <a href="/sdm"
           class="menu-item {{ request()->is('sdm*') ? 'active' : '' }}">

            <i class="bi bi-people-fill"></i>

            <span>SDM</span>

        </a>


        {{-- LAPORAN --}}
        <a href="/laporan"
           class="menu-item {{ request()->is('laporan*') ? 'active' : '' }}">

            <i class="bi bi-file-earmark-text-fill"></i>

            <span>Laporan</span>

        </a>

    </nav>


    {{-- =====================================================
         LOGOUT
    ====================================================== --}}

    <div class="sidebar-bottom">

        <form action="/logout" method="POST">

            @csrf

            <button type="submit"
                    class="logout-button"
                    title="Logout">

                <i class="bi bi-box-arrow-right"></i>

            </button>

        </form>

    </div>

</aside>


<style>

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


.menu::-webkit-scrollbar {

    width: 0;
}


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


/* =========================================================
   MENU AKTIF + HOVER
========================================================= */

.menu-item.active:hover {

    background: #071b88;

    color: white;
}


/* =========================================================
   INFRASTRUKTUR NORMAL
========================================================= */

.infrastructure-button {

    background: white;

    color: #075985;
}


/* =========================================================
   INFRASTRUKTUR HOVER
========================================================= */

.infrastructure-button:hover {

    background: #071b88;

    color: white;
}


/* =========================================================
   INFRASTRUKTUR AKTIF
========================================================= */

.infrastructure-button.active {

    background: #071b88;

    color: white;

    box-shadow: 0 4px 7px rgba(0, 0, 0, 0.30);
}


.infrastructure-button.active:hover {

    background: #071b88;

    color: white;
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


/* =========================================================
   SUBMENU ICON
========================================================= */

.submenu a i {

    font-size: 15px;

    min-width: 16px;

    text-align: center;
}


/* =========================================================
   SUBMENU HOVER
========================================================= */

.submenu a:hover {

    background: #071b88;

    color: white;
}


/* =========================================================
   SUBMENU AKTIF
========================================================= */

.submenu a.active {

    background: #071b88;

    color: white;

    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.20);
}


/* =========================================================
   SUBMENU AKTIF + HOVER
========================================================= */

.submenu a.active:hover {

    background: #071b88;

    color: white;
}


/* =========================================================
   BAGIAN BAWAH
========================================================= */

.sidebar-bottom {

    padding: 15px 24px 25px;

    display: flex;

    align-items: center;

    justify-content: flex-end;

    border-top: 1px solid rgba(255,255,255,0.15);
}


/* =========================================================
   LOGOUT
========================================================= */

.sidebar-bottom form {

    margin: 0;
}


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

</style>


<script>

/* =========================================================
   TOGGLE INFRASTRUKTUR
========================================================= */

function toggleInfrastructure() {

    const button =
        document.getElementById('infrastructure-button');

    const submenu =
        document.getElementById('infrastructure-submenu');

    const arrow =
        document.getElementById('infrastructure-arrow');


    if (submenu.classList.contains('show')) {

        // TUTUP SUBMENU
        submenu.classList.remove('show');

        button.classList.remove('active');

        arrow.classList.remove('bi-chevron-down');

        arrow.classList.add('bi-chevron-right');

    } else {

        // BUKA SUBMENU
        submenu.classList.add('show');

        button.classList.add('active');

        arrow.classList.remove('bi-chevron-right');

        arrow.classList.add('bi-chevron-down');

    }

}

</script>
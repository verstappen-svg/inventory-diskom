@extends('layouts.app')

@section('title', 'SPLP')
@section('page-title', 'SPLP')

@section('content')

<style>

/* =========================================================
   SPLP INFORMATION PAGE
========================================================= */

.splp-page {
    width: 100%;
}


/* =========================================================
   HEADER
========================================================= */

.splp-header {
    margin-bottom: 24px;
}

.splp-heading h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
}

.splp-heading p {
    margin: 6px 0 0;
    font-size: 13px;
    color: #6b7280;
}


/* =========================================================
   MAIN CARD
========================================================= */

.splp-info-card {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);

    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;

    min-height: 380px;
    justify-content: center;
}


/* =========================================================
   ICON
========================================================= */

.splp-info-icon {
    width: 82px;
    height: 82px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 20px;

    background: #e0f2fe;
    color: #075985;

    margin-bottom: 22px;
}

.splp-info-icon i {
    font-size: 38px;
}


/* =========================================================
   TITLE
========================================================= */

.splp-info-card h3 {
    margin: 0;

    font-size: 21px;
    font-weight: 700;

    color: #1f2937;
}


/* =========================================================
   DESCRIPTION
========================================================= */

.splp-description {
    max-width: 650px;

    margin: 12px auto 0;

    font-size: 13px;
    line-height: 1.7;

    color: #6b7280;
}


/* =========================================================
   NOTICE
========================================================= */

.splp-notice {
    max-width: 650px;

    margin-top: 25px;

    padding: 16px 20px;

    display: flex;
    align-items: flex-start;

    gap: 12px;

    background: #f8fafc;

    border: 1px solid #e2e8f0;

    border-radius: 10px;

    text-align: left;
}

.splp-notice-icon {
    flex-shrink: 0;

    width: 30px;
    height: 30px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 8px;

    background: #e0f2fe;
    color: #075985;
}

.splp-notice-icon i {
    font-size: 15px;
}

.splp-notice-content {
    flex: 1;
}

.splp-notice-title {
    margin: 0 0 4px;

    font-size: 12px;
    font-weight: 700;

    color: #374151;
}

.splp-notice-text {
    margin: 0;

    font-size: 11px;
    line-height: 1.6;

    color: #6b7280;
}


/* =========================================================
   PORTAL BUTTON
========================================================= */

.splp-portal-button {
    display: inline-flex;

    align-items: center;
    justify-content: center;

    gap: 8px;

    margin-top: 25px;

    padding: 11px 20px;

    border: none;
    border-radius: 9px;

    background: #071b88;
    color: #ffffff;

    font-size: 12px;
    font-weight: 600;

    text-decoration: none;

    transition: all 0.2s ease;
}

.splp-portal-button:hover {
    background: #050f63;
    color: #ffffff;

    transform: translateY(-1px);
}

.splp-portal-button i {
    font-size: 14px;
}


/* =========================================================
   FOOTER INFO
========================================================= */

.splp-footer-info {
    margin-top: 18px;

    text-align: center;

    font-size: 11px;

    color: #9ca3af;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 700px) {

    .splp-info-card {
        padding: 30px 20px;
    }

    .splp-info-icon {
        width: 70px;
        height: 70px;
    }

    .splp-info-icon i {
        font-size: 32px;
    }

    .splp-info-card h3 {
        font-size: 18px;
    }

    .splp-description {
        font-size: 12px;
    }

    .splp-notice {
        padding: 14px;
    }

}

</style>


<div class="splp-page">

    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="splp-header">

        <div class="splp-heading">

            <h2>
                SPLP
            </h2>

            <p>
                Sistem Penghubung Layanan Pemerintah
            </p>

        </div>

    </div>


    {{-- =====================================================
         INFORMATION CARD
    ====================================================== --}}

    <div class="splp-info-card">

        {{-- ICON --}}

        <div class="splp-info-icon">

            <i class="bi bi-diagram-3-fill"></i>

        </div>


        {{-- TITLE --}}

        <h3>
            Pengelolaan SPLP
        </h3>


        {{-- DESCRIPTION --}}

        <p class="splp-description">

            Sistem Penghubung Layanan Pemerintah (SPLP)
            merupakan layanan yang digunakan untuk mendukung
            integrasi dan pertukaran data antar layanan
            pemerintahan berbasis elektronik.

        </p>


        {{-- NOTICE --}}

        <div class="splp-notice">

            <div class="splp-notice-icon">

                <i class="bi bi-info-circle-fill"></i>

            </div>

            <div class="splp-notice-content">

                <p class="splp-notice-title">
                    Informasi Pengelolaan
                </p>

                <p class="splp-notice-text">

                    Pengelolaan dan pemutakhiran data SPLP
                    dilakukan melalui portal atau sistem
                    khusus SPLP. Modul ini pada sistem
                    Inventory IT Assets hanya menyediakan
                    informasi mengenai layanan SPLP.

                </p>

            </div>

        </div>


        {{-- PORTAL BUTTON --}}
        {{-- 
            Jika URL portal SPLP sudah tersedia,
            aktifkan tombol di bawah ini dan ganti URL-nya.
        --}}

        {{--
        <a
            href="URL_PORTAL_SPLP"
            target="_blank"
            rel="noopener noreferrer"
            class="splp-portal-button"
        >

            <i class="bi bi-box-arrow-up-right"></i>

            Buka Portal SPLP

        </a>
        --}}


        {{-- FOOTER INFO --}}

        <div class="splp-footer-info">

            Data SPLP tidak dikelola secara langsung
            melalui sistem Inventory IT Assets.

        </div>

    </div>

</div>

@endsection
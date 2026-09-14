<style>
    /* =========================================================
       SOFTWARE CREATE MODAL
    ========================================================= */

    .software-create-wrapper {
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(15, 23, 42, 0.58);

        /* PENTING:
           Modal tidak muncul otomatis saat halaman Software dibuka */
        display: none;

        align-items: center;
        justify-content: center;
        padding: 24px;
        overflow-y: auto;
    }

    .software-create-wrapper.show {
        display: flex;
    }

    .software-create-modal {
        width: 100%;
        max-width: 980px;
        max-height: calc(100vh - 48px);
        overflow-y: auto;
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 25px 70px rgba(0, 0, 0, 0.25);
    }

    /* =========================================================
       HEADER
    ========================================================= */

    .software-create-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 22px 28px;
        border-bottom: 1px solid #e5e7eb;
        position: sticky;
        top: 0;
        z-index: 5;
        background: #ffffff;
    }

    .software-create-header-left h2 {
        margin: 0;
        font-size: 21px;
        font-weight: 700;
        color: #111827;
    }

    .software-create-header-left p {
        margin: 5px 0 0;
        font-size: 13px;
        color: #6b7280;
    }

    .software-create-close {
        width: 36px;
        height: 36px;
        border: 0;
        border-radius: 9px;
        background: #f3f4f6;
        color: #4b5563;
        font-size: 22px;
        line-height: 36px;
        text-align: center;
        cursor: pointer;
        transition: .2s;
    }

    .software-create-close:hover {
        background: #e5e7eb;
        color: #111827;
    }

    /* =========================================================
       BODY
    ========================================================= */

    .software-create-body {
        padding: 26px 28px 28px;
    }

    .software-form-section {
        margin-bottom: 26px;
    }

    .software-form-section:last-child {
        margin-bottom: 0;
    }

    .software-section-title {
        margin-bottom: 16px;
        font-size: 15px;
        font-weight: 700;
        color: #1f2937;
    }

    .software-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 17px 20px;
    }

    .software-form-group {
        min-width: 0;
    }

    .software-form-group.full {
        grid-column: 1 / -1;
    }

    .software-form-group label {
        display: block;
        margin-bottom: 7px;
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .required-mark {
        color: #dc2626;
    }

    .software-input,
    .software-select,
    .software-textarea {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #d1d5db;
        border-radius: 9px;
        background: #ffffff;
        color: #111827;
        font-family: inherit;
        font-size: 13px;
        outline: none;
        transition: .2s;
    }

    .software-input,
    .software-select {
        height: 42px;
        padding: 0 12px;
    }

    .software-textarea {
        min-height: 110px;
        padding: 11px 12px;
        resize: vertical;
    }

    .software-input:focus,
    .software-select:focus,
    .software-textarea:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
    }

    .software-input::placeholder,
    .software-textarea::placeholder {
        color: #9ca3af;
    }

    .software-input.error,
    .software-select.error,
    .software-textarea.error {
        border-color: #ef4444;
    }

    .field-error {
        margin-top: 5px;
        color: #dc2626;
        font-size: 11px;
    }

    /* =========================================================
       SSL
    ========================================================= */

    .ssl-select-wrapper {
        position: relative;
    }

    .ssl-expire-info {
        display: none;
        margin-top: 7px;
        padding: 8px 11px;
        border-radius: 8px;
        background: #eff6ff;
        border: 1px solid #dbeafe;
        color: #1d4ed8;
        font-size: 12px;
    }

    .ssl-expire-info.show {
        display: block;
    }

    .ssl-expire-info.warning {
        background: #fffbeb;
        border-color: #fde68a;
        color: #b45309;
    }

    .ssl-expire-info.expired {
        background: #fef2f2;
        border-color: #fecaca;
        color: #b91c1c;
    }

    /* =========================================================
       IP
    ========================================================= */

    .ip-hint {
        margin-top: 5px;
        font-size: 11px;
        color: #9ca3af;
    }

    /* =========================================================
       CIA
    ========================================================= */

    .cia-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
    }

    .cia-card {
        padding: 14px;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #f9fafb;
    }

    .cia-card label {
        margin-bottom: 7px;
    }

    .cia-description {
        margin-top: 5px;
        font-size: 10px;
        color: #9ca3af;
    }

    /* =========================================================
       NILAI
    ========================================================= */

    .nilai-preview {
        display: flex;
        gap: 12px;
        align-items: stretch;
    }

    .nilai-box {
        flex: 1;
        padding: 13px 15px;
        border-radius: 10px;
        border: 1px solid #dbeafe;
        background: #eff6ff;
    }

    .nilai-box-label {
        font-size: 11px;
        color: #6b7280;
        margin-bottom: 3px;
    }

    .nilai-box-value {
        font-size: 20px;
        font-weight: 700;
        color: #1d4ed8;
    }

    .keterangan-box {
        flex: 1;
        padding: 13px 15px;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
    }

    .keterangan-box-label {
        font-size: 11px;
        color: #6b7280;
        margin-bottom: 3px;
    }

    .keterangan-box-value {
        font-size: 15px;
        font-weight: 700;
        color: #374151;
    }

    /* =========================================================
       FOOTER
    ========================================================= */

    .software-create-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 18px 28px;
        border-top: 1px solid #e5e7eb;
        background: #ffffff;
        position: sticky;
        bottom: 0;
        z-index: 5;
    }

    .software-btn-cancel,
    .software-btn-save {
        height: 40px;
        padding: 0 17px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
    }

    .software-btn-cancel {
        border: 1px solid #d1d5db;
        background: #ffffff;
        color: #374151;
    }

    .software-btn-cancel:hover {
        background: #f9fafb;
    }

    .software-btn-save {
        border: 0;
        background: #2563eb;
        color: #ffffff;
    }

    .software-btn-save:hover {
        background: #1d4ed8;
    }

    /* =========================================================
       MASTER INFO
    ========================================================= */

    .master-info {
        margin-top: 6px;
        font-size: 11px;
        color: #9ca3af;
    }

    .master-info a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 700px) {

        .software-create-wrapper {
            padding: 10px;
        }

        .software-create-modal {
            max-height: calc(100vh - 20px);
            border-radius: 14px;
        }

        .software-create-header {
            padding: 17px 18px;
        }

        .software-create-body {
            padding: 20px 18px;
        }

        .software-form-grid {
            grid-template-columns: 1fr;
        }

        .software-form-group.full {
            grid-column: auto;
        }

        .cia-grid {
            grid-template-columns: 1fr;
        }

        .nilai-preview {
            flex-direction: column;
        }

        .software-create-footer {
            padding: 15px 18px;
        }

        .software-btn-cancel,
        .software-btn-save {
            flex: 1;
        }
    }
</style>


{{-- =========================================================
     MODAL TAMBAH SOFTWARE
========================================================= --}}

<div
    class="software-create-wrapper"
    id="softwareCreateModal"
    aria-hidden="true"
>

    <div
        class="software-create-modal"
        role="dialog"
        aria-modal="true"
        aria-labelledby="softwareCreateTitle"
    >

        {{-- =====================================================
             HEADER
        ====================================================== --}}

        <div class="software-create-header">

            <div class="software-create-header-left">

                <h2 id="softwareCreateTitle">
                    Tambah Software
                </h2>

                <p>
                    Tambahkan data aplikasi/software ke dalam inventory.
                </p>

            </div>

            <button
                type="button"
                class="software-create-close"
                onclick="closeSoftwareCreateModal()"
                aria-label="Tutup"
            >
                ×
            </button>

        </div>


        {{-- =====================================================
             FORM
        ====================================================== --}}

        <form
            action="{{ route('software.store') }}"
            method="POST"
            id="softwareCreateForm"
        >

            @csrf

            <div class="software-create-body">

                {{-- =================================================
                     INFORMASI SOFTWARE
                ================================================== --}}

                <div class="software-form-section">

                    <div class="software-section-title">
                        Informasi Software
                    </div>

                    <div class="software-form-grid">

                        {{-- NAMA ASET --}}

                        <div class="software-form-group full">

                            <label for="nama_aset">
                                Nama Aset / Nama Software
                                <span class="required-mark">*</span>
                            </label>

                            <input
                                type="text"
                                id="nama_aset"
                                name="nama_aset"
                                class="software-input @error('nama_aset') error @enderror"
                                value="{{ old('nama_aset') }}"
                                placeholder="Masukkan nama aplikasi/software"
                                required
                            >

                            @error('nama_aset')
                                <div class="field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- KATEGORI --}}

                        <div class="software-form-group">

                            <label for="kategori_id">
                                Kategori
                                <span class="required-mark">*</span>
                            </label>

                            <select
                                id="kategori_id"
                                name="kategori_id"
                                class="software-select @error('kategori_id') error @enderror"
                                required
                            >

                                <option value="">
                                    Pilih Kategori
                                </option>

                                @foreach($kategoriOptions as $kategori)

                                    <option
                                        value="{{ $kategori->id }}"
                                        {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}
                                    >
                                        {{ $kategori->nama }}
                                    </option>

                                @endforeach

                            </select>

                            <div class="master-info">
                                Data berasal dari
                                <a href="{{ route('software.master.index') }}">
                                    Data Master
                                </a>
                            </div>

                            @error('kategori_id')
                                <div class="field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- SSL --}}

                        <div class="software-form-group">

                            <label for="ssl_id">
                                SSL
                                <span class="required-mark">*</span>
                            </label>

                            <div class="ssl-select-wrapper">

                                <select
                                    id="ssl_id"
                                    name="ssl_id"
                                    class="software-select @error('ssl_id') error @enderror"
                                    required
                                >

                                    <option value="">
                                        Pilih SSL
                                    </option>

                                    @foreach($sslOptions as $ssl)

                                        <option
                                            value="{{ $ssl->id }}"
                                            data-expire="{{ $ssl->tanggal_expire ? $ssl->tanggal_expire->format('Y-m-d') : '' }}"
                                            data-name="{{ $ssl->nama_ssl }}"
                                            {{ old('ssl_id') == $ssl->id ? 'selected' : '' }}
                                        >
                                            {{ $ssl->nama_ssl }}
                                        </option>

                                    @endforeach

                                </select>

                                <div
                                    id="sslExpireInfo"
                                    class="ssl-expire-info"
                                ></div>

                            </div>

                            <div class="master-info">
                                SSL dikelola melalui
                                <a href="{{ route('software.master.index') }}">
                                    Data Master
                                </a>
                            </div>

                            @error('ssl_id')
                                <div class="field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- URL HOMEPAGE --}}

                        <div class="software-form-group full">

                            <label for="url_homepage">
                                URL Homepage
                            </label>

                            <input
                                type="url"
                                id="url_homepage"
                                name="url_homepage"
                                class="software-input @error('url_homepage') error @enderror"
                                value="{{ old('url_homepage') }}"
                                placeholder="https://contoh.bekasikota.go.id"
                            >

                            @error('url_homepage')
                                <div class="field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- IP PUBLIC --}}

                        <div class="software-form-group">

                            <label for="ip_public">
                                IP Public
                            </label>

                            <input
                                type="text"
                                id="ip_public"
                                name="ip_public"
                                class="software-input @error('ip_public') error @enderror"
                                value="{{ old('ip_public') }}"
                                placeholder="Contoh: 103.123.45.67"
                                inputmode="decimal"
                                autocomplete="off"
                            >

                            <div class="ip-hint">
                                Hanya menerima alamat IPv4/IPv6 yang valid.
                            </div>

                            @error('ip_public')
                                <div class="field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- IP PRIVATE --}}

                        <div class="software-form-group">

                            <label for="ip_private">
                                IP Private
                            </label>

                            <input
                                type="text"
                                id="ip_private"
                                name="ip_private"
                                class="software-input @error('ip_private') error @enderror"
                                value="{{ old('ip_private') }}"
                                placeholder="Contoh: 192.168.1.10"
                                inputmode="decimal"
                                autocomplete="off"
                            >

                            <div class="ip-hint">
                                Hanya menerima alamat IP yang valid.
                            </div>

                            @error('ip_private')
                                <div class="field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     SERVER / HOSTING
                ================================================== --}}

                <div class="software-form-section">

                    <div class="software-section-title">
                        Server & Hosting
                    </div>

                    <div class="software-form-grid">

                        {{-- HOSTING --}}

                        <div class="software-form-group">

                            <label for="hosting_id">
                                Hosting
                                <span class="required-mark">*</span>
                            </label>

                            <select
                                id="hosting_id"
                                name="hosting_id"
                                class="software-select @error('hosting_id') error @enderror"
                                required
                            >

                                <option value="">
                                    Pilih Hosting
                                </option>

                                @foreach($hostingOptions as $hosting)

                                    <option
                                        value="{{ $hosting->id }}"
                                        {{ old('hosting_id') == $hosting->id ? 'selected' : '' }}
                                    >
                                        {{ $hosting->nama }}
                                    </option>

                                @endforeach

                            </select>

                            <div class="master-info">
                                Data berasal dari
                                <a href="{{ route('software.master.index') }}">
                                    Data Master
                                </a>
                            </div>

                            @error('hosting_id')
                                <div class="field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- STATUS --}}

                        <div class="software-form-group">

                            <label for="status">
                                Status
                                <span class="required-mark">*</span>
                            </label>

                            <select
                                id="status"
                                name="status"
                                class="software-select @error('status') error @enderror"
                                required
                            >

                                <option value="">
                                    Pilih Status
                                </option>

                                <option
                                    value="Aktif"
                                    {{ old('status') === 'Aktif' ? 'selected' : '' }}
                                >
                                    Aktif
                                </option>

                                <option
                                    value="Tidak Aktif"
                                    {{ old('status') === 'Tidak Aktif' ? 'selected' : '' }}
                                >
                                    Tidak Aktif
                                </option>

                            </select>

                            @error('status')
                                <div class="field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     PIC
                ================================================== --}}

                <div class="software-form-section">

                    <div class="software-section-title">
                        Penanggung Jawab
                    </div>

                    <div class="software-form-grid">

                        <div class="software-form-group">

                            <label for="pic_id">
                                PIC
                                <span class="required-mark">*</span>
                            </label>

                            <select
                                id="pic_id"
                                name="pic_id"
                                class="software-select @error('pic_id') error @enderror"
                                required
                            >

                                <option value="">
                                    Pilih PIC
                                </option>

                                @foreach($picOptions as $pic)

                                    <option
                                        value="{{ $pic->id }}"
                                        {{ old('pic_id') == $pic->id ? 'selected' : '' }}
                                    >
                                        {{ $pic->nama }}
                                    </option>

                                @endforeach

                            </select>

                            <div class="master-info">
                                Data berasal dari
                                <a href="{{ route('software.master.index') }}">
                                    Data Master
                                </a>
                            </div>

                            @error('pic_id')
                                <div class="field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     CIA
                ================================================== --}}

                <div class="software-form-section">

                    <div class="software-section-title">
                        Penilaian CIA
                    </div>

                    <div class="cia-grid">

                        {{-- KERAHASIAAN --}}

                        <div class="cia-card">

                            <div class="software-form-group">

                                <label for="kerahasiaan">
                                    Kerahasiaan
                                    <span class="required-mark">*</span>
                                </label>

                                <select
                                    id="kerahasiaan"
                                    name="kerahasiaan"
                                    class="software-select @error('kerahasiaan') error @enderror"
                                    required
                                >

                                    <option value="">
                                        Pilih Nilai
                                    </option>

                                    <option value="1"
                                        {{ old('kerahasiaan') == '1' ? 'selected' : '' }}>
                                        1
                                    </option>

                                    <option value="2"
                                        {{ old('kerahasiaan') == '2' ? 'selected' : '' }}>
                                        2
                                    </option>

                                    <option value="3"
                                        {{ old('kerahasiaan') == '3' ? 'selected' : '' }}>
                                        3
                                    </option>

                                </select>

                                <div class="cia-description">
                                    Tingkat kerahasiaan data.
                                </div>

                                @error('kerahasiaan')
                                    <div class="field-error">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>


                        {{-- INTEGRITAS --}}

                        <div class="cia-card">

                            <div class="software-form-group">

                                <label for="integritas">
                                    Integritas
                                    <span class="required-mark">*</span>
                                </label>

                                <select
                                    id="integritas"
                                    name="integritas"
                                    class="software-select @error('integritas') error @enderror"
                                    required
                                >

                                    <option value="">
                                        Pilih Nilai
                                    </option>

                                    <option value="1"
                                        {{ old('integritas') == '1' ? 'selected' : '' }}>
                                        1
                                    </option>

                                    <option value="2"
                                        {{ old('integritas') == '2' ? 'selected' : '' }}>
                                        2
                                    </option>

                                    <option value="3"
                                        {{ old('integritas') == '3' ? 'selected' : '' }}>
                                        3
                                    </option>

                                </select>

                                <div class="cia-description">
                                    Tingkat integritas data.
                                </div>

                                @error('integritas')
                                    <div class="field-error">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>


                        {{-- KETERSEDIAAN --}}

                        <div class="cia-card">

                            <div class="software-form-group">

                                <label for="ketersediaan">
                                    Ketersediaan
                                    <span class="required-mark">*</span>
                                </label>

                                <select
                                    id="ketersediaan"
                                    name="ketersediaan"
                                    class="software-select @error('ketersediaan') error @enderror"
                                    required
                                >

                                    <option value="">
                                        Pilih Nilai
                                    </option>

                                    <option value="1"
                                        {{ old('ketersediaan') == '1' ? 'selected' : '' }}>
                                        1
                                    </option>

                                    <option value="2"
                                        {{ old('ketersediaan') == '2' ? 'selected' : '' }}>
                                        2
                                    </option>

                                    <option value="3"
                                        {{ old('ketersediaan') == '3' ? 'selected' : '' }}>
                                        3
                                    </option>

                                </select>

                                <div class="cia-description">
                                    Tingkat ketersediaan layanan.
                                </div>

                                @error('ketersediaan')
                                    <div class="field-error">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     NILAI CIA
                ================================================== --}}

                <div class="software-form-section">

                    <div class="software-section-title">
                        Hasil Penilaian
                    </div>

                    <div class="nilai-preview">

                        <div class="nilai-box">

                            <div class="nilai-box-label">
                                Nilai CIA
                            </div>

                            <div
                                class="nilai-box-value"
                                id="nilaiPreview"
                            >
                                -
                            </div>

                        </div>

                        <div class="keterangan-box">

                            <div class="keterangan-box-label">
                                Keterangan
                            </div>

                            <div
                                class="keterangan-box-value"
                                id="keteranganPreview"
                            >
                                -
                            </div>

                        </div>

                    </div>


                    {{-- Hidden input --}}

                    <input
                        type="hidden"
                        name="nilai"
                        id="nilai"
                        value="{{ old('nilai') }}"
                    >

                    <input
                        type="hidden"
                        name="keterangan"
                        id="keterangan"
                        value="{{ old('keterangan') }}"
                    >

                </div>


                {{-- =================================================
                     DESKRIPSI
                ================================================== --}}

                <div class="software-form-section">

                    <div class="software-section-title">
                        Deskripsi
                    </div>

                    <div class="software-form-grid">

                        <div class="software-form-group full">

                            <label for="deskripsi_aplikasi">
                                Deskripsi Aplikasi
                            </label>

                            <textarea
                                id="deskripsi_aplikasi"
                                name="deskripsi_aplikasi"
                                class="software-textarea @error('deskripsi_aplikasi') error @enderror"
                                placeholder="Masukkan deskripsi aplikasi/software..."
                            >{{ old('deskripsi_aplikasi') }}</textarea>

                            @error('deskripsi_aplikasi')
                                <div class="field-error">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 FOOTER
            ====================================================== --}}

            <div class="software-create-footer">

                <button
                    type="button"
                    class="software-btn-cancel"
                    onclick="closeSoftwareCreateModal()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="software-btn-save"
                    id="softwareSaveButton"
                >
                    Simpan Software
                </button>

            </div>

        </form>

    </div>

</div>


<script>
(function () {

    'use strict';


    /* =========================================================
       OPEN MODAL
    ========================================================= */

    window.openSoftwareCreateModal = function () {

        const modal =
            document.getElementById('softwareCreateModal');

        if (!modal) {
            return;
        }

        modal.classList.add('show');

        modal.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.style.overflow = 'hidden';


        // Fokus ke nama software
        setTimeout(function () {

            const namaAset =
                document.getElementById('nama_aset');

            if (namaAset) {
                namaAset.focus();
            }

        }, 100);
    };


    /* =========================================================
       CLOSE MODAL
    ========================================================= */

    window.closeSoftwareCreateModal = function () {

        const modal =
            document.getElementById('softwareCreateModal');

        if (!modal) {
            return;
        }

        modal.classList.remove('show');

        modal.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.style.overflow = '';
    };


    /* =========================================================
       SSL EXPIRE
    ========================================================= */

    const sslSelect =
        document.getElementById('ssl_id');

    const sslExpireInfo =
        document.getElementById('sslExpireInfo');


    function updateSslExpire() {

        if (!sslSelect || !sslExpireInfo) {
            return;
        }


        const selected =
            sslSelect.options[
                sslSelect.selectedIndex
            ];


        if (!selected || !selected.value) {

            sslExpireInfo.classList.remove(
                'show',
                'warning',
                'expired'
            );

            sslExpireInfo.innerHTML = '';

            return;
        }


        const expire =
            selected.getAttribute('data-expire');

        const name =
            selected.getAttribute('data-name')
            || selected.textContent.trim();


        if (!expire) {

            sslExpireInfo.classList.remove(
                'warning',
                'expired'
            );

            sslExpireInfo.classList.add('show');

            sslExpireInfo.innerHTML =
                '<strong>' +
                name +
                '</strong> — Tidak memiliki tanggal expire.';

            return;
        }


        const expireDate =
            new Date(expire + 'T00:00:00');


        if (isNaN(expireDate.getTime())) {

            sslExpireInfo.classList.remove(
                'warning',
                'expired'
            );

            sslExpireInfo.classList.add('show');

            sslExpireInfo.innerHTML =
                'Tanggal expire: ' + expire;

            return;
        }


        const formattedDate =
            expireDate.toLocaleDateString(
                'id-ID',
                {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                }
            );


        const today =
            new Date();

        today.setHours(
            0,
            0,
            0,
            0
        );


        const diffTime =
            expireDate.getTime() -
            today.getTime();


        const diffDays =
            Math.ceil(
                diffTime /
                (1000 * 60 * 60 * 24)
            );


        sslExpireInfo.classList.remove(
            'warning',
            'expired'
        );

        sslExpireInfo.classList.add('show');


        if (diffDays < 0) {

            sslExpireInfo.classList.add(
                'expired'
            );

            sslExpireInfo.innerHTML =
                '<strong>' +
                name +
                '</strong> — Expire pada ' +
                formattedDate +
                ' <strong>(Expired)</strong>';

        } else if (diffDays <= 30) {

            sslExpireInfo.classList.add(
                'warning'
            );

            sslExpireInfo.innerHTML =
                '<strong>' +
                name +
                '</strong> — Expire pada ' +
                formattedDate +
                ' <strong>(' +
                diffDays +
                ' hari lagi)</strong>';

        } else {

            sslExpireInfo.innerHTML =
                '<strong>' +
                name +
                '</strong> — Expire pada ' +
                formattedDate;

        }
    }


    if (sslSelect) {

        sslSelect.addEventListener(
            'change',
            updateSslExpire
        );

        updateSslExpire();
    }


    /* =========================================================
       CIA CALCULATION
    ========================================================= */

    const kerahasiaan =
        document.getElementById('kerahasiaan');

    const integritas =
        document.getElementById('integritas');

    const ketersediaan =
        document.getElementById('ketersediaan');

    const nilaiPreview =
        document.getElementById('nilaiPreview');

    const keteranganPreview =
        document.getElementById('keteranganPreview');

    const nilaiInput =
        document.getElementById('nilai');

    const keteranganInput =
        document.getElementById('keterangan');


    function calculateCIA() {

        if (
            !kerahasiaan ||
            !integritas ||
            !ketersediaan
        ) {
            return;
        }


        const k =
            parseInt(
                kerahasiaan.value,
                10
            );

        const i =
            parseInt(
                integritas.value,
                10
            );

        const a =
            parseInt(
                ketersediaan.value,
                10
            );


        if (
            isNaN(k) ||
            isNaN(i) ||
            isNaN(a)
        ) {

            if (nilaiPreview) {
                nilaiPreview.textContent = '-';
            }

            if (keteranganPreview) {
                keteranganPreview.textContent = '-';
            }

            if (nilaiInput) {
                nilaiInput.value = '';
            }

            if (keteranganInput) {
                keteranganInput.value = '';
            }

            return;
        }


        const nilai =
            ((k + i + a) / 3).toFixed(2);


        let keterangan = '';


        if (parseFloat(nilai) <= 1) {

            keterangan = 'Rendah';

        } else if (parseFloat(nilai) <= 2) {

            keterangan = 'Sedang';

        } else {

            keterangan = 'Tinggi';

        }


        if (nilaiPreview) {
            nilaiPreview.textContent = nilai;
        }

        if (keteranganPreview) {
            keteranganPreview.textContent =
                keterangan;
        }

        if (nilaiInput) {
            nilaiInput.value = nilai;
        }

        if (keteranganInput) {
            keteranganInput.value =
                keterangan;
        }
    }


    if (kerahasiaan) {

        kerahasiaan.addEventListener(
            'change',
            calculateCIA
        );

    }


    if (integritas) {

        integritas.addEventListener(
            'change',
            calculateCIA
        );

    }


    if (ketersediaan) {

        ketersediaan.addEventListener(
            'change',
            calculateCIA
        );

    }


    calculateCIA();


    /* =========================================================
       IP VALIDATION
    ========================================================= */

    const ipPublic =
        document.getElementById('ip_public');

    const ipPrivate =
        document.getElementById('ip_private');


    function isValidIPv4(ip) {

        const parts =
            ip.trim().split('.');


        if (parts.length !== 4) {
            return false;
        }


        return parts.every(
            function (part) {

                if (!/^\d+$/.test(part)) {
                    return false;
                }


                const number =
                    Number(part);


                return (
                    number >= 0 &&
                    number <= 255
                );
            }
        );
    }


    function isValidIPv6(ip) {

        /*
         * Validasi client-side sederhana.
         * Validasi utama tetap dilakukan Laravel.
         */

        return (
            /^[0-9a-fA-F:]+$/.test(ip) &&
            ip.includes(':')
        );
    }


    function isValidIP(ip) {

        if (!ip || !ip.trim()) {
            return true;
        }


        return (
            isValidIPv4(ip) ||
            isValidIPv6(ip)
        );
    }


    function validateIPInput(input) {

        if (!input) {
            return true;
        }


        const value =
            input.value.trim();


        if (!value) {

            input.classList.remove(
                'error'
            );

            return true;
        }


        const valid =
            isValidIP(value);


        input.classList.toggle(
            'error',
            !valid
        );


        return valid;
    }


    if (ipPublic) {

        ipPublic.addEventListener(
            'blur',
            function () {

                validateIPInput(
                    ipPublic
                );

            }
        );

    }


    if (ipPrivate) {

        ipPrivate.addEventListener(
            'blur',
            function () {

                validateIPInput(
                    ipPrivate
                );

            }
        );

    }


    /* =========================================================
       FORM SUBMIT
    ========================================================= */

    const form =
        document.getElementById(
            'softwareCreateForm'
        );


    if (form) {

        form.addEventListener(
            'submit',
            function (event) {

                const publicValid =
                    validateIPInput(
                        ipPublic
                    );

                const privateValid =
                    validateIPInput(
                        ipPrivate
                    );


                if (
                    !publicValid ||
                    !privateValid
                ) {

                    event.preventDefault();

                    alert(
                        'IP Public atau IP Private tidak valid. Silakan periksa kembali.'
                    );

                    return;
                }


                // Pastikan nilai CIA terbaru dikirim
                calculateCIA();

            }
        );

    }


    /* =========================================================
       ESC CLOSE
    ========================================================= */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key !== 'Escape'
            ) {
                return;
            }


            const modal =
                document.getElementById(
                    'softwareCreateModal'
                );


            if (
                modal &&
                modal.classList.contains('show')
            ) {

                closeSoftwareCreateModal();

            }

        }
    );


    /* =========================================================
       CLICK OUTSIDE
    ========================================================= */

    const modal =
        document.getElementById(
            'softwareCreateModal'
        );


    if (modal) {

        modal.addEventListener(
            'click',
            function (event) {

                if (
                    event.target === modal
                ) {

                    closeSoftwareCreateModal();

                }

            }
        );

    }


    /* =========================================================
       AUTO OPEN SAAT VALIDASI GAGAL
       Kalau Laravel redirect back karena validation error,
       modal otomatis dibuka kembali.
    ========================================================= */

    @if($errors->any())

        openSoftwareCreateModal();

    @endif


})();
</script>
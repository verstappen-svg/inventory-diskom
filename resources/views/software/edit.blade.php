{{-- =========================================================
     EDIT SOFTWARE MODAL
========================================================= --}}

<style>
/* =========================================================
   EDIT SOFTWARE MODAL
========================================================= */

.software-edit-modal {
    position: fixed;
    inset: 0;
    z-index: 9999;

    display: none;
    align-items: flex-start;
    justify-content: center;

    padding: 25px 20px 40px;

    background: rgba(0, 0, 0, 0.55);

    overflow-y: auto;
    box-sizing: border-box;
}

.software-edit-modal.show {
    display: flex;
}

/* =========================================================
   MODAL BOX
========================================================= */

.software-edit-modal-box {
    width: 100%;
    max-width: 700px;

    margin: 0 auto;

    background: #ffffff;

    border-radius: 10px;

    overflow: hidden;

    box-shadow:
        0 20px 45px rgba(0, 0, 0, 0.25),
        0 8px 20px rgba(0, 0, 0, 0.12);

    animation: softwareEditModalShow 0.18s ease-out;
}

@keyframes softwareEditModalShow {
    from {
        opacity: 0;
        transform: translateY(-12px) scale(0.98);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

/* =========================================================
   HEADER
========================================================= */

.software-edit-modal-header {
    min-height: 72px;

    padding:
        14px
        18px
        14px
        22px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    background: #ffffff;

    border-bottom: 1px solid #e5e7eb;

    box-sizing: border-box;
}

.software-edit-modal-header-text h2 {
    margin: 0;

    font-size: 21px;
    font-weight: 700;

    color: #071b88;
}

.software-edit-modal-header-text p {
    margin: 5px 0 0;

    font-size: 12px;

    color: #6b7280;
}

/* =========================================================
   CLOSE BUTTON
========================================================= */

.software-edit-close {
    width: 32px;
    height: 32px;

    display: flex;
    align-items: center;
    justify-content: center;

    border: none;
    background: transparent;

    color: #6b7280;

    font-size: 17px;

    cursor: pointer;

    border-radius: 6px;

    transition: 0.15s ease;

    flex-shrink: 0;
}

.software-edit-close:hover {
    background: #f3f4f6;
    color: #111827;
}

/* =========================================================
   BODY
========================================================= */

.software-edit-modal-body {
    background: #ffffff;

    padding: 20px 34px;

    max-height: calc(100vh - 210px);

    overflow-y: auto;

    box-sizing: border-box;
}

/* =========================================================
   SCROLLBAR
========================================================= */

.software-edit-modal-body::-webkit-scrollbar {
    width: 7px;
}

.software-edit-modal-body::-webkit-scrollbar-track {
    background: #f3f4f6;
}

.software-edit-modal-body::-webkit-scrollbar-thumb {
    background: #c7cbd1;
    border-radius: 10px;
}

.software-edit-modal-body::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}

/* =========================================================
   FORM GROUP
========================================================= */

.software-edit-modal-body .edit-form-group {
    display: flex;
    flex-direction: column;

    gap: 6px;

    margin-bottom: 17px;
}

.software-edit-modal-body .edit-form-group label {
    font-size: 12px;

    font-weight: 600;

    color: #374151;
}

.software-edit-modal-body .edit-form-group label span {
    color: #ef4444;
}

/* =========================================================
   INPUT / SELECT / TEXTAREA
========================================================= */

.software-edit-modal-body .edit-form-group input,
.software-edit-modal-body .edit-form-group select,
.software-edit-modal-body .edit-form-group textarea {
    width: 100%;

    min-height: 42px;

    padding: 0 13px;

    border: 1px solid #d1d5db;

    border-radius: 8px;

    outline: none;

    background: #ffffff;

    color: #374151;

    font-family: Arial, sans-serif;

    font-size: 13px;

    box-sizing: border-box;

    transition: 0.15s ease;
}

.software-edit-modal-body .edit-form-group textarea {
    min-height: 90px;

    padding-top: 11px;
    padding-bottom: 11px;

    resize: vertical;

    line-height: 1.5;
}

.software-edit-modal-body .edit-form-group input:focus,
.software-edit-modal-body .edit-form-group select:focus,
.software-edit-modal-body .edit-form-group textarea:focus {
    border-color: #071b88;

    box-shadow:
        0 0 0 3px rgba(7, 27, 136, 0.08);
}

.software-edit-modal-body .edit-form-group input::placeholder,
.software-edit-modal-body .edit-form-group textarea::placeholder {
    color: #aeb4bd;
}

.software-edit-modal-body .edit-form-group select {
    cursor: pointer;
}

/* =========================================================
   GRID
========================================================= */

.edit-form-grid {
    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 18px;
}

/* =========================================================
   Lainnya
========================================================= */

.edit-other-input {
    display: none;
}

.edit-other-input.show {
    display: flex;
}

/* =========================================================
   CIA GRID
========================================================= */

.edit-cia-grid {
    display: grid;

    grid-template-columns:
        repeat(3, 1fr);

    gap: 18px;
}

/* =========================================================
   CIA RESULT
========================================================= */

.edit-cia-result {
    display: grid;

    grid-template-columns: 1fr 1fr;

    gap: 18px;

    margin-top: 2px;
}

.edit-result-box {
    display: flex;
    flex-direction: column;

    gap: 6px;
}

.edit-result-box label {
    font-size: 12px;

    font-weight: 600;

    color: #374151;
}

.edit-result-value {
    width: 100%;

    height: 42px;

    display: flex;
    align-items: center;

    padding: 0 13px;

    border: 1px solid #d1d5db;

    border-radius: 8px;

    background: #f8fafc;

    color: #374151;

    font-size: 13px;

    font-weight: 600;

    box-sizing: border-box;
}

/* =========================================================
   INFO
========================================================= */

.edit-form-info {
    margin-top: 2px;

    font-size: 10px;

    line-height: 1.4;

    color: #6b7280;
}

/* =========================================================
   ERROR
========================================================= */

.edit-error-message {
    font-size: 11px;

    color: #dc2626;
}

/* =========================================================
   FOOTER
========================================================= */

.software-edit-modal-footer {
    min-height: 64px;

    padding: 11px 22px;

    display: flex;
    align-items: center;
    justify-content: flex-end;

    gap: 10px;

    background: #ffffff;

    border-top: 1px solid #e5e7eb;

    box-sizing: border-box;
}

/* =========================================================
   BUTTON
========================================================= */

.edit-btn-cancel,
.edit-btn-save {
    min-width: 75px;

    height: 38px;

    padding: 0 17px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    gap: 6px;

    border-radius: 7px;

    font-size: 12px;

    font-weight: 600;

    cursor: pointer;

    text-decoration: none;

    font-family: Arial, sans-serif;

    transition: 0.15s ease;

    box-sizing: border-box;
}

.edit-btn-cancel {
    background: #ffffff;

    color: #374151;

    border: 1px solid #d1d5db;
}

.edit-btn-cancel:hover {
    background: #f9fafb;
}

.edit-btn-save {
    background: #071b88;

    color: #ffffff;

    border: 1px solid #071b88;
}

.edit-btn-save:hover {
    background: #050f63;
}

.edit-btn-save i {
    font-size: 12px;
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 700px) {

    .software-edit-modal {
        padding: 15px 10px;
    }

    .software-edit-modal-box {
        max-width: 100%;
    }

    .software-edit-modal-header {
        padding-left: 16px;
        padding-right: 14px;
    }

    .software-edit-modal-header-text h2 {
        font-size: 18px;
    }

    .software-edit-modal-header-text p {
        font-size: 11px;
    }

    .software-edit-modal-body {
        padding: 18px 16px;
    }

    .edit-form-grid {
        grid-template-columns: 1fr;

        gap: 0;
    }

    .edit-cia-grid {
        grid-template-columns: 1fr;

        gap: 0;
    }

    .edit-cia-result {
        grid-template-columns: 1fr;

        gap: 0;
    }

    .software-edit-modal-footer {
        padding: 10px 16px;
    }
}
</style>


{{-- =========================================================
     EDIT MODAL
========================================================= --}}

<div
    id="software-edit-modal-{{ $software->id }}"
    class="software-edit-modal"
    data-software-id="{{ $software->id }}"
>

    <div class="software-edit-modal-box">

        {{-- =================================================
             HEADER
        ================================================== --}}

        <div class="software-edit-modal-header">

            <div class="software-edit-modal-header-text">

                <h2>
                    Edit Data Software
                </h2>

                <p>
                    Perbarui detail aset perangkat lunak yang tersimpan dalam sistem.
                </p>

            </div>

            <button
                type="button"
                class="software-edit-close"
                title="Tutup"
                onclick="closeEditSoftwareModal('{{ $software->id }}')"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>


        {{-- =================================================
             FORM
        ================================================== --}}

        <form
            action="{{ route('software.update', $software) }}"
            method="POST"
            id="software-edit-form-{{ $software->id }}"
        >

            @csrf

            @method('PUT')


            {{-- =================================================
                 BODY
            ================================================== --}}

            <div class="software-edit-modal-body">

                {{-- =================================================
                     NAMA ASET
                ================================================== --}}

                <div class="edit-form-group">

                    <label
                        for="edit-nama-aset-{{ $software->id }}"
                    >
                        Nama Aset
                        <span>*</span>
                    </label>

                    <input
                        type="text"
                        id="edit-nama-aset-{{ $software->id }}"
                        name="nama_aset"
                        value="{{ old('nama_aset', $software->nama_aset ?? $software->jenis) }}"
                        placeholder="Masukkan nama aset software"
                        required
                    >

                    @error('nama_aset')
                        <small class="edit-error-message">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- =================================================
                     KATEGORI + SSL
                ================================================== --}}

                <div class="edit-form-grid">

                    {{-- KATEGORI --}}

                    <div class="edit-form-group">

                        <label
                            for="edit-kategori-{{ $software->id }}"
                        >
                            Kategori
                            <span>*</span>
                        </label>

                        <select
                            id="edit-kategori-{{ $software->id }}"
                            name="kategori"
                            required
                        >

                            <option value="">
                                Pilih Kategori
                            </option>

                            <option
                                value="Website"
                                {{ old('kategori', $software->kategori) === 'Website' ? 'selected' : '' }}
                            >
                                Website
                            </option>

                            <option
                                value="Open Source"
                                {{ old('kategori', $software->kategori) === 'Open Source' ? 'selected' : '' }}
                            >
                                Open Source
                            </option>

                            <option
                                value="Utilities"
                                {{ old('kategori', $software->kategori) === 'Utilities' ? 'selected' : '' }}
                            >
                                Utilities
                            </option>

                            <option
                                value="Lainnya"
                                {{ old('kategori', $software->kategori) === 'Lainnya' ? 'selected' : '' }}
                            >
                                Lainnya
                            </option>

                        </select>

                        @error('kategori')
                            <small class="edit-error-message">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- SSL --}}

                    <div class="edit-form-group">

                        <label
                            for="edit-ssl-{{ $software->id }}"
                        >
                            SSL
                        </label>

                        <input
                            type="date"
                            id="edit-ssl-{{ $software->id }}"
                            name="ssl"
                            value="{{ old(
                                'ssl',
                                optional($software->ssl)->format('Y-m-d')
                            ) }}"
                        >

                        <small class="edit-form-info">
                            Isi tanggal berlaku/berakhir SSL jika website menggunakan SSL.
                        </small>

                        @error('ssl')
                            <small class="edit-error-message">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>


                {{-- =================================================
                     KATEGORI LAINNYA
                ================================================== --}}

                <div
                    id="edit-kategori-other-{{ $software->id }}"
                    class="edit-form-group edit-other-input"
                >

                    <label
                        for="edit-kategori-lainnya-{{ $software->id }}"
                    >
                        Kategori Lainnya
                    </label>

                    <input
                        type="text"
                        id="edit-kategori-lainnya-{{ $software->id }}"
                        name="kategori_lainnya"
                        value="{{ old('kategori_lainnya') }}"
                        placeholder="Masukkan kategori lainnya"
                    >

                </div>


                {{-- =================================================
                     URL HOMEPAGE
                ================================================== --}}

                <div class="edit-form-group">

                    <label
                        for="edit-url-homepage-{{ $software->id }}"
                    >
                        URL Homepage
                    </label>

                    <input
                        type="url"
                        id="edit-url-homepage-{{ $software->id }}"
                        name="url_homepage"
                        value="{{ old('url_homepage', $software->url_homepage) }}"
                        placeholder="https://contoh.bekasikota.go.id"
                    >

                    @error('url_homepage')
                        <small class="edit-error-message">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- =================================================
                     IP PUBLIC + IP PRIVATE
                ================================================== --}}

                <div class="edit-form-grid">

                    {{-- IP PUBLIC --}}

                    <div class="edit-form-group">

                        <label
                            for="edit-ip-public-{{ $software->id }}"
                        >
                            IP Public
                        </label>

                        <input
                            type="text"
                            id="edit-ip-public-{{ $software->id }}"
                            name="ip_public"
                            value="{{ old('ip_public', $software->ip_public) }}"
                            placeholder="Contoh: 103.xxx.xxx.xxx"
                        >

                        @error('ip_public')
                            <small class="edit-error-message">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- IP PRIVATE --}}

                    <div class="edit-form-group">

                        <label
                            for="edit-ip-private-{{ $software->id }}"
                        >
                            IP Private
                        </label>

                        <input
                            type="text"
                            id="edit-ip-private-{{ $software->id }}"
                            name="ip_private"
                            value="{{ old('ip_private', $software->ip_private) }}"
                            placeholder="Contoh: 192.168.x.x"
                        >

                        @error('ip_private')
                            <small class="edit-error-message">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>


                {{-- =================================================
                     HOSTING + STATUS
                ================================================== --}}

                <div class="edit-form-grid">

                    {{-- HOSTING --}}

                    <div class="edit-form-group">

                        <label
                            for="edit-hosting-{{ $software->id }}"
                        >
                            Hosting
                            <span>*</span>
                        </label>

                        <select
                            id="edit-hosting-{{ $software->id }}"
                            name="hosting"
                            required
                        >

                            <option value="">
                                Pilih Hosting
                            </option>

                            <option
                                value="DC Pemerintahan Kota Bekasi"
                                {{ old('hosting', $software->hosting) === 'DC Pemerintahan Kota Bekasi' ? 'selected' : '' }}
                            >
                                DC Pemerintahan Kota Bekasi
                            </option>

                            <option
                                value="BAPENDA"
                                {{ old('hosting', $software->hosting) === 'BAPENDA' ? 'selected' : '' }}
                            >
                                BAPENDA
                            </option>

                            <option
                                value="Vendor"
                                {{ old('hosting', $software->hosting) === 'Vendor' ? 'selected' : '' }}
                            >
                                Vendor
                            </option>

                            <option
                                value="Lainnya"
                                {{ old('hosting', $software->hosting) === 'Lainnya' ? 'selected' : '' }}
                            >
                                Lainnya
                            </option>

                        </select>

                        @error('hosting')
                            <small class="edit-error-message">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- STATUS --}}

                    <div class="edit-form-group">

                        <label
                            for="edit-status-{{ $software->id }}"
                        >
                            Status
                            <span>*</span>
                        </label>

                        <select
                            id="edit-status-{{ $software->id }}"
                            name="status"
                            required
                        >

                            <option value="">
                                Pilih Status
                            </option>

                            <option
                                value="Aktif"
                                {{ old('status', $software->status) === 'Aktif' ? 'selected' : '' }}
                            >
                                Aktif
                            </option>

                            <option
                                value="Tidak Aktif"
                                {{ old('status', $software->status) === 'Tidak Aktif' ? 'selected' : '' }}
                            >
                                Tidak Aktif
                            </option>

                        </select>

                        @error('status')
                            <small class="edit-error-message">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>


                {{-- =================================================
                     HOSTING LAINNYA
                ================================================== --}}

                <div
                    id="edit-hosting-other-{{ $software->id }}"
                    class="edit-form-group edit-other-input"
                >

                    <label
                        for="edit-hosting-lainnya-{{ $software->id }}"
                    >
                        Hosting Lainnya
                    </label>

                    <input
                        type="text"
                        id="edit-hosting-lainnya-{{ $software->id }}"
                        name="hosting_lainnya"
                        value="{{ old('hosting_lainnya') }}"
                        placeholder="Masukkan hosting lainnya"
                    >

                </div>


                {{-- =================================================
                     PIC
                ================================================== --}}

                <div class="edit-form-group">

                    <label
                        for="edit-pic-{{ $software->id }}"
                    >
                        PIC
                        <span>*</span>
                    </label>

                    <select
                        id="edit-pic-{{ $software->id }}"
                        name="pic"
                        required
                    >

                        <option value="">
                            Pilih PIC
                        </option>

                        <option
                            value="Diskominfostandi_E-Govermment"
                            {{ old('pic', $software->pic) === 'Diskominfostandi_E-Govermment' ? 'selected' : '' }}
                        >
                            Diskominfostandi_E-Govermment
                        </option>

                        <option
                            value="Diskomfostandi_Santik"
                            {{ old('pic', $software->pic) === 'Diskomfostandi_Santik' ? 'selected' : '' }}
                        >
                            Diskomfostandi_Santik
                        </option>

                        <option
                            value="Diskominfostandi_Statistik"
                            {{ old('pic', $software->pic) === 'Diskominfostandi_Statistik' ? 'selected' : '' }}
                        >
                            Diskominfostandi_Statistik
                        </option>

                        <option
                            value="Diskominfostandi_Sekretariat"
                            {{ old('pic', $software->pic) === 'Diskominfostandi_Sekretariat' ? 'selected' : '' }}
                        >
                            Diskominfostandi_Sekretariat
                        </option>

                        <option
                            value="Diskominfostandi_IKP"
                            {{ old('pic', $software->pic) === 'Diskominfostandi_IKP' ? 'selected' : '' }}
                        >
                            Diskominfostandi_IKP
                        </option>

                        <option
                            value="Lainnya"
                            {{ old('pic', $software->pic) === 'Lainnya' ? 'selected' : '' }}
                        >
                            Lainnya
                        </option>

                    </select>

                    @error('pic')
                        <small class="edit-error-message">
                            {{ $message }}
                        </small>
                    @enderror

                </div>


                {{-- =================================================
                     PIC LAINNYA
                ================================================== --}}

                <div
                    id="edit-pic-other-{{ $software->id }}"
                    class="edit-form-group edit-other-input"
                >

                    <label
                        for="edit-pic-lainnya-{{ $software->id }}"
                    >
                        PIC Lainnya
                    </label>

                    <input
                        type="text"
                        id="edit-pic-lainnya-{{ $software->id }}"
                        name="pic_lainnya"
                        value="{{ old('pic_lainnya') }}"
                        placeholder="Masukkan PIC lainnya"
                    >

                </div>


                {{-- =================================================
                     CIA
                ================================================== --}}

                <div class="edit-form-group">

                    <label>
                        Penilaian CIA
                        <span>*</span>
                    </label>

                </div>


                <div class="edit-cia-grid">

                    {{-- KERAHASIAAN --}}

                    <div class="edit-form-group">

                        <label
                            for="edit-kerahasiaan-{{ $software->id }}"
                        >
                            Kerahasiaan
                            <span>*</span>
                        </label>

                        <select
                            id="edit-kerahasiaan-{{ $software->id }}"
                            name="kerahasiaan"
                            required
                        >

                            <option value="">
                                Pilih Nilai
                            </option>

                            <option
                                value="1"
                                {{ (string) old('kerahasiaan', $software->kerahasiaan) === '1' ? 'selected' : '' }}
                            >
                                1
                            </option>

                            <option
                                value="2"
                                {{ (string) old('kerahasiaan', $software->kerahasiaan) === '2' ? 'selected' : '' }}
                            >
                                2
                            </option>

                            <option
                                value="3"
                                {{ (string) old('kerahasiaan', $software->kerahasiaan) === '3' ? 'selected' : '' }}
                            >
                                3
                            </option>

                        </select>

                        @error('kerahasiaan')
                            <small class="edit-error-message">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- INTEGRITAS --}}

                    <div class="edit-form-group">

                        <label
                            for="edit-integritas-{{ $software->id }}"
                        >
                            Integritas
                            <span>*</span>
                        </label>

                        <select
                            id="edit-integritas-{{ $software->id }}"
                            name="integritas"
                            required
                        >

                            <option value="">
                                Pilih Nilai
                            </option>

                            <option
                                value="1"
                                {{ (string) old('integritas', $software->integritas) === '1' ? 'selected' : '' }}
                            >
                                1
                            </option>

                            <option
                                value="2"
                                {{ (string) old('integritas', $software->integritas) === '2' ? 'selected' : '' }}
                            >
                                2
                            </option>

                            <option
                                value="3"
                                {{ (string) old('integritas', $software->integritas) === '3' ? 'selected' : '' }}
                            >
                                3
                            </option>

                        </select>

                        @error('integritas')
                            <small class="edit-error-message">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>


                    {{-- KETERSEDIAAN --}}

                    <div class="edit-form-group">

                        <label
                            for="edit-ketersediaan-{{ $software->id }}"
                        >
                            Ketersediaan
                            <span>*</span>
                        </label>

                        <select
                            id="edit-ketersediaan-{{ $software->id }}"
                            name="ketersediaan"
                            required
                        >

                            <option value="">
                                Pilih Nilai
                            </option>

                            <option
                                value="1"
                                {{ (string) old('ketersediaan', $software->ketersediaan) === '1' ? 'selected' : '' }}
                            >
                                1
                            </option>

                            <option
                                value="2"
                                {{ (string) old('ketersediaan', $software->ketersediaan) === '2' ? 'selected' : '' }}
                            >
                                2
                            </option>

                            <option
                                value="3"
                                {{ (string) old('ketersediaan', $software->ketersediaan) === '3' ? 'selected' : '' }}
                            >
                                3
                            </option>

                        </select>

                        @error('ketersediaan')
                            <small class="edit-error-message">
                                {{ $message }}
                            </small>
                        @enderror

                    </div>

                </div>


                {{-- =================================================
                     NILAI + KETERANGAN
                ================================================== --}}

                <div class="edit-cia-result">

                    {{-- NILAI --}}

                    <div class="edit-result-box">

                        <label
                            for="edit-nilai-{{ $software->id }}"
                        >
                            Nilai
                        </label>

                        <div
                            id="edit-nilai-{{ $software->id }}"
                            class="edit-result-value"
                        >
                            {{ number_format((float) ($software->nilai ?? 0), 2) }}
                        </div>

                    </div>


                    {{-- KETERANGAN --}}

                    <div class="edit-result-box">

                        <label
                            for="edit-keterangan-{{ $software->id }}"
                        >
                            Keterangan
                        </label>

                        <div
                            id="edit-keterangan-{{ $software->id }}"
                            class="edit-result-value"
                        >
                            {{ $software->keterangan ?? '-' }}
                        </div>

                    </div>

                </div>


                {{-- =================================================
                     HIDDEN NILAI
                ================================================== --}}

                <input
                    type="hidden"
                    id="edit-nilai-hidden-{{ $software->id }}"
                    name="nilai"
                    value="{{ old('nilai', $software->nilai ?? '') }}"
                >


                {{-- =================================================
                     HIDDEN KETERANGAN
                ================================================== --}}

                <input
                    type="hidden"
                    id="edit-keterangan-hidden-{{ $software->id }}"
                    name="keterangan"
                    value="{{ old('keterangan', $software->keterangan ?? '') }}"
                >


                {{-- =================================================
                     DESKRIPSI APLIKASI
                ================================================== --}}

                <div
                    class="edit-form-group"
                    style="margin-top: 18px;"
                >

                    <label
                        for="edit-deskripsi-aplikasi-{{ $software->id }}"
                    >
                        Deskripsi Aplikasi
                    </label>

                    <textarea
                        id="edit-deskripsi-aplikasi-{{ $software->id }}"
                        name="deskripsi_aplikasi"
                        placeholder="Masukkan deskripsi aplikasi/software"
                    >{{ old('deskripsi_aplikasi', $software->deskripsi_aplikasi) }}</textarea>

                    @error('deskripsi_aplikasi')
                        <small class="edit-error-message">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

            </div>


            {{-- =================================================
                 FOOTER
            ================================================== --}}

            <div class="software-edit-modal-footer">

                <button
                    type="button"
                    class="edit-btn-cancel"
                    onclick="closeEditSoftwareModal('{{ $software->id }}')"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="edit-btn-save"
                >
                    <i class="bi bi-check-lg"></i>

                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>


<script>
(function () {

    const id = @json($software->id);


    /* =========================================================
       ELEMENT
    ========================================================= */

    const kategori = document.getElementById(
        'edit-kategori-' + id
    );

    const kategoriOther = document.getElementById(
        'edit-kategori-other-' + id
    );

    const hosting = document.getElementById(
        'edit-hosting-' + id
    );

    const hostingOther = document.getElementById(
        'edit-hosting-other-' + id
    );

    const pic = document.getElementById(
        'edit-pic-' + id
    );

    const picOther = document.getElementById(
        'edit-pic-other-' + id
    );


    const kerahasiaan = document.getElementById(
        'edit-kerahasiaan-' + id
    );

    const integritas = document.getElementById(
        'edit-integritas-' + id
    );

    const ketersediaan = document.getElementById(
        'edit-ketersediaan-' + id
    );


    const nilai = document.getElementById(
        'edit-nilai-' + id
    );

    const nilaiHidden = document.getElementById(
        'edit-nilai-hidden-' + id
    );

    const keterangan = document.getElementById(
        'edit-keterangan-' + id
    );

    const keteranganHidden = document.getElementById(
        'edit-keterangan-hidden-' + id
    );


    /* =========================================================
       TOGGLE LAINNYA
    ========================================================= */

    function updateKategoriOther() {

        if (!kategori || !kategoriOther) {
            return;
        }

        if (kategori.value === 'Lainnya') {

            kategoriOther.classList.add('show');

        } else {

            kategoriOther.classList.remove('show');

        }
    }


    function updateHostingOther() {

        if (!hosting || !hostingOther) {
            return;
        }

        if (hosting.value === 'Lainnya') {

            hostingOther.classList.add('show');

        } else {

            hostingOther.classList.remove('show');

        }
    }


    function updatePicOther() {

        if (!pic || !picOther) {
            return;
        }

        if (pic.value === 'Lainnya') {

            picOther.classList.add('show');

        } else {

            picOther.classList.remove('show');

        }
    }


    /* =========================================================
       HITUNG NILAI CIA
    ========================================================= */

    function calculateCIA() {

        if (
            !kerahasiaan ||
            !integritas ||
            !ketersediaan ||
            !nilai ||
            !keterangan
        ) {
            return;
        }


        const c = parseInt(
            kerahasiaan.value,
            10
        );

        const i = parseInt(
            integritas.value,
            10
        );

        const a = parseInt(
            ketersediaan.value,
            10
        );


        if (
            isNaN(c) ||
            isNaN(i) ||
            isNaN(a)
        ) {

            nilai.textContent = '-';

            keterangan.textContent = '-';

            if (nilaiHidden) {
                nilaiHidden.value = '';
            }

            if (keteranganHidden) {
                keteranganHidden.value = '';
            }

            return;
        }


        const hasil = (
            (c + i + a) / 3
        ).toFixed(2);


        let hasilKeterangan = '';


        if (parseFloat(hasil) <= 1) {

            hasilKeterangan = 'Rendah';

        } else if (parseFloat(hasil) <= 2) {

            hasilKeterangan = 'Sedang';

        } else {

            hasilKeterangan = 'Tinggi';

        }


        nilai.textContent = hasil;

        keterangan.textContent = hasilKeterangan;


        if (nilaiHidden) {
            nilaiHidden.value = hasil;
        }

        if (keteranganHidden) {
            keteranganHidden.value = hasilKeterangan;
        }

    }


    /* =========================================================
       EVENTS
    ========================================================= */

    if (kategori) {

        kategori.addEventListener(
            'change',
            updateKategoriOther
        );

    }


    if (hosting) {

        hosting.addEventListener(
            'change',
            updateHostingOther
        );

    }


    if (pic) {

        pic.addEventListener(
            'change',
            updatePicOther
        );

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


    /* =========================================================
       INITIAL STATE
    ========================================================= */

    window[
        'initEditSoftwareModal_' + id
    ] = function () {

        updateKategoriOther();

        updateHostingOther();

        updatePicOther();

        calculateCIA();

    };


    /*
     * Jalankan juga saat file Blade selesai dimuat.
     */
    updateKategoriOther();

    updateHostingOther();

    updatePicOther();

    calculateCIA();


})();
</script>
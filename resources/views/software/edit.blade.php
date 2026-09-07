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
   MODAL
========================================================= */

.software-edit-modal-box {
    width: 100%;
    max-width: 620px;

    margin: 0 auto;

    background: #fff;

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
        transform:
            translateY(-12px)
            scale(0.98);
    }

    to {
        opacity: 1;
        transform:
            translateY(0)
            scale(1);
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

    background: #fff;

    border-bottom:
        1px solid #e5e7eb;

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
   CLOSE
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

    background: #fff;

    padding: 20px 34px;

    max-height:
        calc(100vh - 210px);

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
   FORM
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
   INPUT & SELECT
========================================================= */

.software-edit-modal-body .edit-form-group input,
.software-edit-modal-body .edit-form-group select {

    width: 100%;

    height: 42px;

    padding: 0 13px;

    border:
        1px solid #d1d5db;

    border-radius: 8px;

    outline: none;

    background: #fff;

    color: #374151;

    font-family: Arial, sans-serif;

    font-size: 13px;

    box-sizing: border-box;

    transition: 0.15s ease;
}

.software-edit-modal-body .edit-form-group input:focus,
.software-edit-modal-body .edit-form-group select:focus {

    border-color: #071b88;

    box-shadow:
        0 0 0 3px
        rgba(7, 27, 136, 0.08);
}

.software-edit-modal-body .edit-form-group input::placeholder {

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

    grid-template-columns:
        1fr 1fr;

    gap: 18px;
}


/* =========================================================
   PRICE
========================================================= */

.edit-price-input {

    display: flex;

    width: 100%;

    height: 42px;

    background: #fff;

    border:
        1px solid #d1d5db;

    border-radius: 8px;

    overflow: hidden;

    box-sizing: border-box;
}

.edit-price-input:focus-within {

    border-color: #071b88;

    box-shadow:
        0 0 0 3px
        rgba(7, 27, 136, 0.08);
}

.edit-price-prefix {

    width: 43px;

    flex-shrink: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    background: #f3f4f6;

    border-right:
        1px solid #d1d5db;

    color: #6b7280;

    font-size: 12px;

    font-weight: 600;
}

.edit-price-input input {

    width: 100%;

    height: 100%;

    border: none !important;

    border-radius: 0 !important;

    padding: 0 12px;

    outline: none;

    box-shadow: none !important;
}


/* =========================================================
   LICENSE
========================================================= */

.edit-license-input {

    position: relative;
}

.edit-license-input input {

    padding-right: 65px !important;
}

.edit-license-suffix {

    position: absolute;

    right: 13px;

    top: 50%;

    transform:
        translateY(-50%);

    color: #9ca3af;

    font-size: 11px;

    pointer-events: none;
}


/* =========================================================
   DATE
========================================================= */

.edit-date-input {

    position: relative;
}

.edit-date-input i {

    position: absolute;

    left: 13px;

    top: 50%;

    transform:
        translateY(-50%);

    color: #6b7280;

    font-size: 14px;

    pointer-events: none;

    z-index: 1;
}

.edit-date-input input {

    padding-left: 38px !important;
}


/* =========================================================
   READONLY
========================================================= */

.software-edit-modal-body
.edit-form-group
input[readonly] {

    background: #f8fafc;

    color: #6b7280;

    cursor: not-allowed;
}


/* =========================================================
   SEWA
========================================================= */

.edit-sewa-section {

    display: none;

    margin-top: 2px;

    padding-top: 2px;
}

.edit-sewa-section.show {

    display: block;
}


/* =========================================================
   CUSTOM PERIOD
========================================================= */

.edit-custom-period {

    display: none;

    grid-template-columns:
        1fr 1fr;

    gap: 18px;

    margin-top: 2px;
}

.edit-custom-period.show {

    display: grid;
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

    padding:
        11px 22px;

    display: flex;

    align-items: center;

    justify-content: flex-end;

    gap: 10px;

    background: #fff;

    border-top:
        1px solid #e5e7eb;

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

    background: #fff;

    color: #374151;

    border:
        1px solid #d1d5db;
}

.edit-btn-cancel:hover {

    background: #f9fafb;
}

.edit-btn-save {

    background: #071b88;

    color: #fff;

    border:
        1px solid #071b88;
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

        padding:
            15px 10px;
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

        padding:
            18px 16px;
    }

    .edit-form-grid {

        grid-template-columns: 1fr;

        gap: 0;
    }

    .edit-custom-period {

        grid-template-columns: 1fr;

        gap: 0;
    }

    .software-edit-modal-footer {

        padding:
            10px 16px;
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
                    Perbarui detail aset software yang tersimpan dalam sistem.
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


                {{-- JENIS --}}

                <div class="edit-form-group">

                    <label
                        for="edit-jenis-{{ $software->id }}"
                    >

                        Jenis
                        <span>*</span>

                    </label>

                    <input
                        type="text"
                        id="edit-jenis-{{ $software->id }}"
                        name="jenis"
                        value="{{ old('jenis', $software->jenis) }}"
                        placeholder="Masukkan jenis software"
                        required
                    >

                    @error('jenis')

                        <small class="edit-error-message">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- SPESIFIKASI --}}

                <div class="edit-form-group">

                    <label
                        for="edit-spesifikasi-{{ $software->id }}"
                    >

                        Spesifikasi

                    </label>

                    <input
                        type="text"
                        id="edit-spesifikasi-{{ $software->id }}"
                        name="spesifikasi"
                        value="{{ old('spesifikasi', $software->spesifikasi) }}"
                        placeholder="Masukkan spesifikasi software"
                    >

                    @error('spesifikasi')

                        <small class="edit-error-message">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- PENGADAAN --}}

                <div class="edit-form-group">

                    <label
                        for="edit-pengadaan-{{ $software->id }}"
                    >

                        Pengadaan
                        <span>*</span>

                    </label>

                    <select
                        id="edit-pengadaan-{{ $software->id }}"
                        name="pengadaan"
                        required
                    >

                        <option value="">
                            Pilih Jenis Pengadaan
                        </option>

                        <option
                            value="Sewa"
                            {{ old('pengadaan', $software->pengadaan) === 'Sewa' ? 'selected' : '' }}
                        >
                            Sewa
                        </option>

                        <option
                            value="Beli"
                            {{ old('pengadaan', $software->pengadaan) === 'Beli' ? 'selected' : '' }}
                        >
                            Beli
                        </option>

                    </select>

                    @error('pengadaan')

                        <small class="edit-error-message">
                            {{ $message }}
                        </small>

                    @enderror

                </div>


                {{-- HARGA + LISENSI --}}

                <div class="edit-form-grid">


                    {{-- HARGA --}}

                    <div class="edit-form-group">

                        <label
                            for="edit-harga-{{ $software->id }}"
                        >

                            Harga
                            <span>*</span>

                        </label>

                        <div class="edit-price-input">

                            <span class="edit-price-prefix">
                                Rp
                            </span>

                            <input
                                type="number"
                                id="edit-harga-{{ $software->id }}"
                                name="harga"
                                value="{{ old('harga', $software->harga ?? 0) }}"
                                min="0"
                                step="1"
                                placeholder="0"
                                required
                            >

                        </div>

                        @error('harga')

                            <small class="edit-error-message">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- JUMLAH LISENSI --}}

                    <div class="edit-form-group">

                        <label
                            for="edit-jumlah-lisensi-{{ $software->id }}"
                        >

                            Jumlah Lisensi
                            <span>*</span>

                        </label>

                        <div class="edit-license-input">

                            <input
                                type="number"
                                id="edit-jumlah-lisensi-{{ $software->id }}"
                                name="jumlah_lisensi"
                                value="{{ old('jumlah_lisensi', $software->jumlah_lisensi ?? 1) }}"
                                min="1"
                                placeholder="Jumlah lisensi"
                                required
                            >

                            <span class="edit-license-suffix">
                                Lisensi
                            </span>

                        </div>

                        @error('jumlah_lisensi')

                            <small class="edit-error-message">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>

                </div>


                {{-- TANGGAL --}}

                <div class="edit-form-grid">


                    {{-- TANGGAL PENGADAAN --}}

                    <div class="edit-form-group">

                        <label
                            for="edit-tanggal-pengadaan-{{ $software->id }}"
                        >

                            Tanggal Pengadaan
                            <span>*</span>

                        </label>

                        <div class="edit-date-input">

                            <i class="bi bi-calendar3"></i>

                            <input
                                type="date"
                                id="edit-tanggal-pengadaan-{{ $software->id }}"
                                name="tanggal_pengadaan"
                                value="{{ old(
                                    'tanggal_pengadaan',
                                    optional($software->tanggal_pengadaan)->format('Y-m-d')
                                ) }}"
                                required
                            >

                        </div>

                        @error('tanggal_pengadaan')

                            <small class="edit-error-message">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>


                    {{-- TANGGAL BERAKHIR --}}

                    <div class="edit-form-group">

                        <label
                            for="edit-tanggal-berakhir-{{ $software->id }}"
                        >

                            Tanggal Berakhir

                        </label>

                        <div class="edit-date-input">

                            <i class="bi bi-calendar3"></i>

                            <input
                                type="date"
                                id="edit-tanggal-berakhir-{{ $software->id }}"
                                name="tanggal_berakhir"
                                value="{{ old(
                                    'tanggal_berakhir',
                                    optional($software->tanggal_berakhir)->format('Y-m-d')
                                ) }}"
                            >

                        </div>

                        <small
                            id="edit-tanggal-info-{{ $software->id }}"
                            class="edit-form-info"
                        >

                            Untuk software Beli,
                            tanggal berakhir dikosongkan (Perpetual).

                        </small>

                        @error('tanggal_berakhir')

                            <small class="edit-error-message">
                                {{ $message }}
                            </small>

                        @enderror

                    </div>

                </div>


                {{-- =================================================
                     PERIODE SEWA
                ================================================== --}}

                <div
                    id="edit-sewa-section-{{ $software->id }}"
                    class="edit-sewa-section"
                >

                    <div class="edit-form-group">

                        <label
                            for="edit-periode-sewa-{{ $software->id }}"
                        >

                            Periode Sewa

                        </label>

                        <select
                            id="edit-periode-sewa-{{ $software->id }}"
                        >

                            <option value="">
                                Pilih Periode
                            </option>

                            <option value="1">
                                1 Bulan
                            </option>

                            <option value="3">
                                3 Bulan
                            </option>

                            <option value="5">
                                5 Bulan
                            </option>

                            <option value="6">
                                6 Bulan
                            </option>

                            <option value="12">
                                12 Bulan
                            </option>

                            <option value="custom">
                                Lainnya
                            </option>

                        </select>

                    </div>


                    {{-- CUSTOM PERIOD --}}

                    <div
                        id="edit-custom-period-{{ $software->id }}"
                        class="edit-custom-period"
                    >

                        <div class="edit-form-group">

                            <label
                                for="edit-custom-jumlah-{{ $software->id }}"
                            >

                                Jumlah

                            </label>

                            <input
                                type="number"
                                id="edit-custom-jumlah-{{ $software->id }}"
                                min="1"
                                placeholder="Contoh: 2"
                            >

                        </div>


                        <div class="edit-form-group">

                            <label
                                for="edit-custom-satuan-{{ $software->id }}"
                            >

                                Satuan

                            </label>

                            <select
                                id="edit-custom-satuan-{{ $software->id }}"
                            >

                                <option value="months">
                                    Bulan
                                </option>

                                <option value="years">
                                    Tahun
                                </option>

                            </select>

                        </div>

                    </div>

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

    const id =
        @json($software->id);

    const pengadaan =
        document.getElementById(
            'edit-pengadaan-' + id
        );

    const tanggalPengadaan =
        document.getElementById(
            'edit-tanggal-pengadaan-' + id
        );

    const tanggalBerakhir =
        document.getElementById(
            'edit-tanggal-berakhir-' + id
        );

    const sewaSection =
        document.getElementById(
            'edit-sewa-section-' + id
        );

    const periodeSewa =
        document.getElementById(
            'edit-periode-sewa-' + id
        );

    const customPeriod =
        document.getElementById(
            'edit-custom-period-' + id
        );

    const customJumlah =
        document.getElementById(
            'edit-custom-jumlah-' + id
        );

    const customSatuan =
        document.getElementById(
            'edit-custom-satuan-' + id
        );

    const tanggalInfo =
        document.getElementById(
            'edit-tanggal-info-' + id
        );


    /*
    |--------------------------------------------------------------------------
    | DATA LAMA
    |--------------------------------------------------------------------------
    */

    const tanggalPengadaanLama =
        tanggalPengadaan.value;

    const tanggalBerakhirLama =
        tanggalBerakhir.value;


    /*
    |--------------------------------------------------------------------------
    | FORMAT DATE
    |--------------------------------------------------------------------------
    */

    function formatDate(date)
    {

        const year =
            date.getFullYear();

        const month =
            String(
                date.getMonth() + 1
            ).padStart(2, '0');

        const day =
            String(
                date.getDate()
            ).padStart(2, '0');

        return `${year}-${month}-${day}`;

    }


    /*
    |--------------------------------------------------------------------------
    | HITUNG SELISIH BULAN
    |--------------------------------------------------------------------------
    */

    function hitungSelisihPeriode()
    {

        if (
            !tanggalPengadaanLama ||
            !tanggalBerakhirLama
        ) {

            return null;

        }


        const mulai =
            new Date(
                tanggalPengadaanLama +
                'T00:00:00'
            );

        const akhir =
            new Date(
                tanggalBerakhirLama +
                'T00:00:00'
            );


        let bulan =
            (
                akhir.getFullYear() -
                mulai.getFullYear()
            ) * 12
            +
            (
                akhir.getMonth() -
                mulai.getMonth()
            );


        if (
            akhir.getDate() <
            mulai.getDate()
        ) {

            bulan--;

        }


        return bulan > 0
            ? bulan
            : null;

    }


    /*
    |--------------------------------------------------------------------------
    | SET PERIODE DARI DATA LAMA
    |--------------------------------------------------------------------------
    */

    function setPeriodeDariDataLama()
    {

        if (
            pengadaan.value !== 'Sewa' ||
            !tanggalPengadaanLama ||
            !tanggalBerakhirLama
        ) {

            return;

        }


        const bulan =
            hitungSelisihPeriode();


        if (!bulan) {

            return;

        }


        const pilihanStandar = [
            '1',
            '3',
            '5',
            '6',
            '12'
        ];


        if (
            pilihanStandar.includes(
                String(bulan)
            )
        ) {

            periodeSewa.value =
                String(bulan);

            customPeriod.classList.remove(
                'show'
            );

            customJumlah.value = '';

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | TAHUN
        |--------------------------------------------------------------------------
        */

        if (
            bulan % 12 === 0 &&
            bulan / 12 >= 1
        ) {

            const tahun =
                bulan / 12;

            periodeSewa.value =
                'custom';

            customPeriod.classList.add(
                'show'
            );

            customJumlah.value =
                tahun;

            customSatuan.value =
                'years';

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | CUSTOM BULAN
        |--------------------------------------------------------------------------
        */

        periodeSewa.value =
            'custom';

        customPeriod.classList.add(
            'show'
        );

        customJumlah.value =
            bulan;

        customSatuan.value =
            'months';

    }


    /*
    |--------------------------------------------------------------------------
    | HITUNG TANGGAL BERAKHIR
    |--------------------------------------------------------------------------
    */

    function calculateEndDate()
    {

        /*
        |--------------------------------------------------------------------------
        | BELI = PERPETUAL
        |--------------------------------------------------------------------------
        */

        if (
            pengadaan.value === 'Beli'
        ) {

            tanggalBerakhir.value =
                '';

            tanggalBerakhir.readOnly =
                true;

            tanggalInfo.textContent =
                'Untuk software Beli, tanggal berakhir dikosongkan (Perpetual).';

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | SEWA
        |--------------------------------------------------------------------------
        */

        if (
            !tanggalPengadaan.value
        ) {

            tanggalBerakhir.value =
                '';

            return;

        }


        let jumlah = 0;

        let satuan =
            'months';


        /*
        |--------------------------------------------------------------------------
        | PERIODE STANDAR
        |--------------------------------------------------------------------------
        */

        if (
            periodeSewa.value &&
            periodeSewa.value !== 'custom'
        ) {

            jumlah =
                parseInt(
                    periodeSewa.value,
                    10
                );

        }


        /*
        |--------------------------------------------------------------------------
        | CUSTOM
        |--------------------------------------------------------------------------
        */

        if (
            periodeSewa.value ===
            'custom'
        ) {

            jumlah =
                parseInt(
                    customJumlah.value,
                    10
                ) || 0;

            satuan =
                customSatuan.value;

        }


        if (jumlah <= 0) {

            return;

        }


        const date =
            new Date(
                tanggalPengadaan.value +
                'T00:00:00'
            );


        /*
        |--------------------------------------------------------------------------
        | TAHUN
        |--------------------------------------------------------------------------
        */

        if (
            satuan === 'years'
        ) {

            date.setFullYear(
                date.getFullYear() +
                jumlah
            );

        }


        /*
        |--------------------------------------------------------------------------
        | BULAN
        |--------------------------------------------------------------------------
        */

        else {

            date.setMonth(
                date.getMonth() +
                jumlah
            );

        }


        tanggalBerakhir.value =
            formatDate(date);

    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE PENGADAAN
    |--------------------------------------------------------------------------
    */

    function updatePengadaan(
        hitungOtomatis = true
    )
    {

        if (
            pengadaan.value === 'Sewa'
        ) {

            sewaSection.classList.add(
                'show'
            );

            tanggalBerakhir.readOnly =
                true;

            tanggalInfo.textContent =
                'Tanggal berakhir dihitung otomatis berdasarkan periode sewa.';


            if (
                hitungOtomatis
            ) {

                calculateEndDate();

            }

            return;

        }


        /*
        |--------------------------------------------------------------------------
        | BELI
        |--------------------------------------------------------------------------
        */

        sewaSection.classList.remove(
            'show'
        );

        customPeriod.classList.remove(
            'show'
        );

        periodeSewa.value =
            '';

        customJumlah.value =
            '';

        customSatuan.value =
            'months';

        tanggalBerakhir.value =
            '';

        tanggalBerakhir.readOnly =
            true;

        tanggalInfo.textContent =
            'Untuk software Beli, tanggal berakhir dikosongkan (Perpetual).';

    }


    /*
    |--------------------------------------------------------------------------
    | EVENT PERIODE
    |--------------------------------------------------------------------------
    */

    periodeSewa.addEventListener(
        'change',
        function ()
        {

            if (
                periodeSewa.value ===
                'custom'
            ) {

                customPeriod.classList.add(
                    'show'
                );

            } else {

                customPeriod.classList.remove(
                    'show'
                );

                customJumlah.value =
                    '';

            }

            calculateEndDate();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CUSTOM JUMLAH
    |--------------------------------------------------------------------------
    */

    customJumlah.addEventListener(
        'input',
        function ()
        {

            calculateEndDate();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CUSTOM SATUAN
    |--------------------------------------------------------------------------
    */

    customSatuan.addEventListener(
        'change',
        function ()
        {

            calculateEndDate();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | TANGGAL PENGADAAN
    |--------------------------------------------------------------------------
    */

    tanggalPengadaan.addEventListener(
        'change',
        function ()
        {

            calculateEndDate();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | PENGADAAN
    |--------------------------------------------------------------------------
    */

    pengadaan.addEventListener(
        'change',
        function ()
        {

            updatePengadaan(true);

        }
    );


    /*
    |--------------------------------------------------------------------------
    | INITIAL STATE
    |--------------------------------------------------------------------------
    */

    window[
        'initEditSoftwareModal_' + id
    ] = function ()
    {

        if (
            pengadaan.value ===
            'Sewa'
        ) {

            sewaSection.classList.add(
                'show'
            );

            tanggalBerakhir.readOnly =
                true;

            tanggalInfo.textContent =
                'Tanggal berakhir dihitung otomatis berdasarkan periode sewa.';


            /*
            |--------------------------------------------------------------------------
            | BACA PERIODE DARI DATA LAMA
            |--------------------------------------------------------------------------
            */

            setPeriodeDariDataLama();


            /*
            |--------------------------------------------------------------------------
            | JIKA PERIODE TIDAK TERBACA
            |--------------------------------------------------------------------------
            */

            if (
                !periodeSewa.value &&
                tanggalPengadaan.value &&
                tanggalBerakhir.value
            ) {

                /*
                | Data lama tetap dipertahankan.
                */

            }

        } else {

            updatePengadaan(false);

        }

    };


})();

</script>
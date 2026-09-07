{{-- =========================================================
     MODAL TAMBAH SOFTWARE
     File ini adalah PARTIAL.
     JANGAN gunakan @extends / @section / @endsection.
========================================================= --}}

<style>
    /* =========================================================
       MODAL OVERLAY
    ========================================================= */

    #software-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;

        display: none;

        align-items: center;
        justify-content: center;

        padding: 30px;

        background: rgba(15, 23, 42, 0.55);

        overflow-y: auto;
    }

    #software-modal.show {
        display: flex;
    }

    body.software-modal-open {
        overflow: hidden;
    }

    /* =========================================================
       MODAL BOX
    ========================================================= */

    .software-modal-box {
        position: relative;

        width: 100%;
        max-width: 1050px;

        max-height: calc(100vh - 60px);

        background: #ffffff;

        border-radius: 16px;

        box-shadow:
            0 20px 50px rgba(0, 0, 0, 0.20);

        overflow: hidden;

        animation: softwareModalShow 0.2s ease;
    }

    @keyframes softwareModalShow {
        from {
            opacity: 0;
            transform: translateY(10px) scale(0.98);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* =========================================================
       MODAL HEADER
    ========================================================= */

    .software-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: 20px 24px;

        border-bottom: 1px solid #e5e7eb;

        background: #ffffff;
    }

    .software-modal-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .software-modal-header-icon {
        width: 40px;
        height: 40px;

        display: flex;
        align-items: center;
        justify-content: center;

        border-radius: 10px;

        background: #e0f2fe;
        color: #075985;

        font-size: 18px;
    }

    .software-modal-title {
        margin: 0;

        font-size: 17px;
        font-weight: 700;

        color: #1f2937;
    }

    .software-modal-subtitle {
        margin: 3px 0 0;

        font-size: 11px;

        color: #9ca3af;
    }

    .software-modal-close {
        width: 34px;
        height: 34px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        border: none;
        border-radius: 8px;

        background: #f3f4f6;

        color: #6b7280;

        font-size: 17px;

        cursor: pointer;

        transition: 0.2s ease;
    }

    .software-modal-close:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    /* =========================================================
       MODAL BODY
    ========================================================= */

    .software-modal-body {
        max-height: calc(100vh - 155px);

        padding: 24px;

        overflow-y: auto;
    }

    /* =========================================================
       FORM
    ========================================================= */

    .software-form-wrapper {
        width: 100%;
    }

    .form-card {
        background: white;

        border: 1px solid #e5e7eb;

        border-radius: 14px;

        padding: 24px;

        margin-bottom: 18px;

        box-shadow: 0 2px 6px rgba(0, 0, 0, .03);
    }

    .card-title {
        display: flex;
        align-items: center;

        gap: 9px;

        padding-bottom: 17px;

        margin-bottom: 20px;

        border-bottom: 1px solid #eef0f3;

        color: #075985;

        font-size: 15px;
        font-weight: 700;
    }

    .card-title i {
        font-size: 17px;
    }

    .form-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;

        gap: 7px;
    }

    .form-group label {
        font-size: 12px;
        font-weight: 600;

        color: #374151;
    }

    .required {
        color: #ef4444;
    }

    .form-group input,
    .form-group select {
        width: 100%;

        height: 40px;

        padding: 0 12px;

        border: 1px solid #d1d5db;

        border-radius: 8px;

        outline: none;

        background: white;

        color: #374151;

        font-size: 12px;

        box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #079bd8;

        box-shadow:
            0 0 0 3px rgba(7, 155, 216, .10);
    }

    /* =========================================================
       PREFIX HARGA
    ========================================================= */

    .input-prefix {
        display: flex;

        height: 40px;

        border: 1px solid #d1d5db;

        border-radius: 8px;

        overflow: hidden;

        background: white;
    }

    .input-prefix span {
        display: flex;

        align-items: center;

        padding: 0 12px;

        background: #f5f6fa;

        border-right: 1px solid #d1d5db;

        color: #6b7280;

        font-size: 12px;
    }

    .input-prefix input {
        height: 100%;

        border: none;

        border-radius: 0;

        box-shadow: none;
    }

    .input-prefix input:focus {
        box-shadow: none;
    }

    /* =========================================================
       PERIODE SEWA
    ========================================================= */

    #sewa-section {
        display: none;

        margin-top: 20px;

        padding: 20px;

        background: #f8fafc;

        border: 1px solid #e2e8f0;

        border-radius: 10px;
    }

    #sewa-section.show {
        display: block;
    }

    .sewa-title {
        display: flex;
        align-items: center;

        gap: 8px;

        margin-bottom: 15px;

        color: #075985;

        font-size: 12px;
        font-weight: 700;
    }

    .sewa-grid {
        display: grid;

        grid-template-columns:
            1fr 1fr;

        gap: 20px;
    }

    /* =========================================================
       CUSTOM PERIODE
    ========================================================= */

    #custom-period {
        display: none;

        grid-template-columns:
            1fr 1fr;

        gap: 20px;

        margin-top: 15px;

        padding-top: 15px;

        border-top: 1px dashed #cbd5e1;
    }

    #custom-period.show {
        display: grid;
    }

    /* =========================================================
       INFO & ERROR
    ========================================================= */

    .form-info {
        font-size: 10px;

        line-height: 1.5;

        color: #94a3b8;
    }

    .error-message {
        color: #ef4444;

        font-size: 10px;
    }

    /* =========================================================
       ACTION
    ========================================================= */

    .form-actions {
        display: flex;

        justify-content: flex-end;

        gap: 10px;

        margin-top: 5px;

        margin-bottom: 5px;
    }

    .btn-cancel,
    .btn-save {
        height: 40px;

        padding: 0 18px;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 7px;

        border-radius: 8px;

        font-size: 12px;

        font-weight: 600;

        text-decoration: none;

        cursor: pointer;
    }

    .btn-cancel {
        background: white;

        border: 1px solid #d1d5db;

        color: #6b7280;
    }

    .btn-cancel:hover {
        background: #f8fafc;

        color: #374151;
    }

    .btn-save {
        border: none;

        background: #079bd8;

        color: white;
    }

    .btn-save:hover {
        background: #075985;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 700px) {

        #software-modal {
            padding: 10px;
        }

        .software-modal-box {
            max-height: calc(100vh - 20px);

            border-radius: 12px;
        }

        .software-modal-body {
            max-height: calc(100vh - 105px);

            padding: 15px;
        }

        .form-grid,
        .sewa-grid,
        #custom-period {
            grid-template-columns: 1fr;
        }

        .software-modal-header {
            padding: 15px;
        }

        .form-card {
            padding: 18px;
        }
    }
</style>


{{-- =========================================================
     MODAL
========================================================= --}}

<div
    id="software-modal"
    aria-hidden="true"
>

    <div class="software-modal-box">

        {{-- =================================================
             HEADER MODAL
        ================================================== --}}

        <div class="software-modal-header">

            <div class="software-modal-header-left">

                <div class="software-modal-header-icon">
                    <i class="bi bi-box"></i>
                </div>

                <div>

                    <h2 class="software-modal-title">
                        Tambah Software
                    </h2>

                    <p class="software-modal-subtitle">
                        Tambahkan data software ke dalam inventory.
                    </p>

                </div>

            </div>

            <button
                type="button"
                class="software-modal-close"
                onclick="closeSoftwareModal()"
                aria-label="Tutup"
            >
                <i class="bi bi-x-lg"></i>
            </button>

        </div>


        {{-- =================================================
             BODY MODAL
        ================================================== --}}

        <div class="software-modal-body">

            <div class="software-form-wrapper">

                <form
                    action="{{ route('software.store') }}"
                    method="POST"
                    id="software-form"
                >

                    @csrf


                    {{-- =====================================
                         INFORMASI SOFTWARE
                    ====================================== --}}

                    <div class="form-card">

                        <div class="card-title">

                            <i class="bi bi-box"></i>

                            <span>
                                Informasi Software
                            </span>

                        </div>


                        <div class="form-grid">

                            {{-- JENIS --}}

                            <div class="form-group">

                                <label for="jenis">

                                    Jenis Software

                                    <span class="required">
                                        *
                                    </span>

                                </label>

                                <input
                                    type="text"
                                    id="jenis"
                                    name="jenis"
                                    value="{{ old('jenis') }}"
                                    placeholder="Contoh: Adobe Creative Cloud"
                                    required
                                >

                                @error('jenis')
                                    <small class="error-message">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- SPESIFIKASI --}}

                            <div class="form-group">

                                <label for="spesifikasi">
                                    Spesifikasi
                                </label>

                                <input
                                    type="text"
                                    id="spesifikasi"
                                    name="spesifikasi"
                                    value="{{ old('spesifikasi') }}"
                                    placeholder="Contoh: Premium, Business, Enterprise"
                                >

                                @error('spesifikasi')
                                    <small class="error-message">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- JUMLAH LISENSI --}}

                            <div class="form-group">

                                <label for="jumlah_lisensi">

                                    Jumlah Lisensi

                                    <span class="required">
                                        *
                                    </span>

                                </label>

                                <input
                                    type="number"
                                    id="jumlah_lisensi"
                                    name="jumlah_lisensi"
                                    value="{{ old('jumlah_lisensi', 1) }}"
                                    min="1"
                                    required
                                >

                                @error('jumlah_lisensi')
                                    <small class="error-message">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- =====================================
                         PENGADAAN
                    ====================================== --}}

                    <div class="form-card">

                        <div class="card-title">

                            <i class="bi bi-cart-check"></i>

                            <span>
                                Pengadaan
                            </span>

                        </div>


                        <div class="form-grid">

                            {{-- PENGADAAN --}}

                            <div class="form-group">

                                <label for="pengadaan">

                                    Pengadaan

                                    <span class="required">
                                        *
                                    </span>

                                </label>

                                <select
                                    id="pengadaan"
                                    name="pengadaan"
                                    required
                                >

                                    <option value="">
                                        Pilih Pengadaan
                                    </option>

                                    <option
                                        value="Sewa"
                                        {{ old('pengadaan') === 'Sewa' ? 'selected' : '' }}
                                    >
                                        Sewa
                                    </option>

                                    <option
                                        value="Beli"
                                        {{ old('pengadaan') === 'Beli' ? 'selected' : '' }}
                                    >
                                        Beli
                                    </option>

                                </select>

                                @error('pengadaan')
                                    <small class="error-message">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- HARGA --}}

                            <div class="form-group">

                                <label for="harga">

                                    Harga

                                    <span class="required">
                                        *
                                    </span>

                                </label>

                                <div class="input-prefix">

                                    <span>
                                        Rp
                                    </span>

                                    <input
                                        type="number"
                                        id="harga"
                                        name="harga"
                                        value="{{ old('harga', 0) }}"
                                        min="0"
                                        step="0.01"
                                        placeholder="0"
                                        required
                                    >

                                </div>

                                @error('harga')
                                    <small class="error-message">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>


                            {{-- TANGGAL PENGADAAN --}}

                            <div class="form-group">

                                <label for="tanggal_pengadaan">

                                    Tanggal Pengadaan

                                    <span class="required">
                                        *
                                    </span>

                                </label>

                                <input
                                    type="date"
                                    id="tanggal_pengadaan"
                                    name="tanggal_pengadaan"
                                    value="{{ old('tanggal_pengadaan') }}"
                                    required
                                >

                                @error('tanggal_pengadaan')
                                    <small class="error-message">
                                        {{ $message }}
                                    </small>
                                @enderror

                            </div>

                        </div>


                        {{-- =================================
                             PERIODE SEWA
                        ================================== --}}

                        <div id="sewa-section">

                            <div class="sewa-title">

                                <i class="bi bi-calendar-range"></i>

                                <span>
                                    Periode Sewa
                                </span>

                            </div>


                            <div class="sewa-grid">

                                {{-- PERIODE --}}

                                <div class="form-group">

                                    <label for="periode_sewa">
                                        Pilih Periode Sewa
                                    </label>

                                    <select id="periode_sewa">

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


                                {{-- TANGGAL BERAKHIR PREVIEW --}}

                                <div class="form-group">

                                    <label for="tanggal_berakhir_preview">
                                        Tanggal Berakhir
                                    </label>

                                    <input
                                        type="date"
                                        id="tanggal_berakhir_preview"
                                        readonly
                                    >

                                    <small class="form-info">
                                        Tanggal berakhir dihitung otomatis
                                        berdasarkan tanggal pengadaan dan
                                        periode sewa.
                                    </small>

                                </div>

                            </div>


                            {{-- =================================
                                 CUSTOM PERIODE
                            ================================== --}}

                            <div id="custom-period">

                                <div class="form-group">

                                    <label for="custom_jumlah">
                                        Jumlah
                                    </label>

                                    <input
                                        type="number"
                                        id="custom_jumlah"
                                        min="1"
                                        placeholder="Contoh: 2"
                                    >

                                </div>


                                <div class="form-group">

                                    <label for="custom_satuan">
                                        Satuan
                                    </label>

                                    <select id="custom_satuan">

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


                        {{-- =================================
                             TANGGAL BERAKHIR DATABASE
                        ================================== --}}

                        <input
                            type="hidden"
                            id="tanggal_berakhir"
                            name="tanggal_berakhir"
                            value="{{ old('tanggal_berakhir') }}"
                        >


                        {{-- INFO BELI --}}

                        <div
                            id="beli-info"
                            class="form-info"
                            style="margin-top: 15px;"
                        >

                            Untuk software
                            <strong>Beli</strong>,
                            tanggal berakhir dapat dikosongkan
                            karena dianggap perpetual.

                        </div>

                    </div>


                    {{-- =====================================
                         ACTION
                    ====================================== --}}

                    <div class="form-actions">

                        <button
                            type="button"
                            class="btn-cancel"
                            onclick="closeSoftwareModal()"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="btn-save"
                        >

                            <i class="bi bi-check-lg"></i>

                            Simpan Software

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


<script>
(function () {

    /* =====================================================
       AMBIL ELEMENT
    ===================================================== */

    const pengadaan =
        document.getElementById('pengadaan');

    const tanggalPengadaan =
        document.getElementById('tanggal_pengadaan');

    const tanggalBerakhir =
        document.getElementById('tanggal_berakhir');

    const tanggalBerakhirPreview =
        document.getElementById('tanggal_berakhir_preview');

    const sewaSection =
        document.getElementById('sewa-section');

    const periodeSewa =
        document.getElementById('periode_sewa');

    const customPeriod =
        document.getElementById('custom-period');

    const customJumlah =
        document.getElementById('custom_jumlah');

    const customSatuan =
        document.getElementById('custom_satuan');

    const beliInfo =
        document.getElementById('beli-info');


    /* =====================================================
       FORMAT DATE
    ===================================================== */

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


    /* =====================================================
       HITUNG TANGGAL BERAKHIR
    ===================================================== */

    function calculateEndDate()
    {
        if (!pengadaan) {
            return;
        }

        if (pengadaan.value !== 'Sewa') {

            tanggalBerakhir.value = '';
            tanggalBerakhirPreview.value = '';

            return;
        }


        if (!tanggalPengadaan.value) {

            tanggalBerakhir.value = '';
            tanggalBerakhirPreview.value = '';

            return;
        }


        let jumlah = 0;
        let satuan = 'months';


        /* ================================================
           PERIODE BAWAAN
        ================================================= */

        if (
            periodeSewa.value &&
            periodeSewa.value !== 'custom'
        ) {

            jumlah = parseInt(
                periodeSewa.value,
                10
            );

        }


        /* ================================================
           CUSTOM
        ================================================= */

        if (
            periodeSewa.value === 'custom'
        ) {

            jumlah =
                parseInt(
                    customJumlah.value,
                    10
                ) || 0;

            satuan =
                customSatuan.value;

        }


        /* ================================================
           BELUM MEMILIH PERIODE
        ================================================= */

        if (jumlah <= 0) {

            tanggalBerakhir.value = '';
            tanggalBerakhirPreview.value = '';

            return;
        }


        /* ================================================
           BUAT DATE
        ================================================= */

        const date =
            new Date(
                tanggalPengadaan.value +
                'T00:00:00'
            );


        /* ================================================
           TAMBAH TAHUN
        ================================================= */

        if (satuan === 'years') {

            date.setFullYear(
                date.getFullYear() + jumlah
            );

        }

        /* ================================================
           TAMBAH BULAN
        ================================================= */

        else {

            date.setMonth(
                date.getMonth() + jumlah
            );

        }


        /* ================================================
           SIMPAN
        ================================================= */

        const result =
            formatDate(date);

        tanggalBerakhir.value =
            result;

        tanggalBerakhirPreview.value =
            result;
    }


    /* =====================================================
       UPDATE PENGADAAN
    ===================================================== */

    function updatePengadaan()
    {
        if (!pengadaan) {
            return;
        }


        if (pengadaan.value === 'Sewa') {

            sewaSection.classList.add('show');

            beliInfo.style.display = 'none';

        }

        else {

            sewaSection.classList.remove('show');

            customPeriod.classList.remove('show');

            periodeSewa.value = '';

            customJumlah.value = '';

            tanggalBerakhir.value = '';

            tanggalBerakhirPreview.value = '';

            beliInfo.style.display = 'block';

        }


        calculateEndDate();
    }


    /* =====================================================
       UPDATE CUSTOM PERIOD
    ===================================================== */

    function updateCustomPeriod()
    {
        if (
            periodeSewa.value === 'custom'
        ) {

            customPeriod.classList.add('show');

        }

        else {

            customPeriod.classList.remove('show');

        }


        calculateEndDate();
    }


    /* =====================================================
       EXPOSE FUNCTION KE INDEX
    ===================================================== */

    window.updatePengadaan =
        updatePengadaan;


    window.updateCustomPeriod =
        updateCustomPeriod;


    /* =====================================================
       EVENT
    ===================================================== */

    if (pengadaan) {

        pengadaan.addEventListener(
            'change',
            updatePengadaan
        );

    }


    if (periodeSewa) {

        periodeSewa.addEventListener(
            'change',
            updateCustomPeriod
        );

    }


    if (customJumlah) {

        customJumlah.addEventListener(
            'input',
            calculateEndDate
        );

    }


    if (customSatuan) {

        customSatuan.addEventListener(
            'change',
            calculateEndDate
        );

    }


    if (tanggalPengadaan) {

        tanggalPengadaan.addEventListener(
            'change',
            calculateEndDate
        );

    }


    /* =====================================================
       INITIAL STATE
    ===================================================== */

    updatePengadaan();

})();
</script>
{{-- =========================================================
     SOFTWARE EDIT MODAL
     ========================================================= --}}

<div
    class="software-create-wrapper software-edit-modal"
    id="software-edit-modal-{{ $software->id }}"
    data-software-id="{{ $software->id }}"
    aria-hidden="true"
>
    <div class="software-create-modal">

        <div class="software-create-header">

            <div class="software-create-header-left">

                <h2>Edit Software</h2>

                <p>
                    Perbarui data aplikasi/software yang dipilih.
                </p>

            </div>

            <button
                type="button"
                class="software-create-close"
                onclick="closeEditSoftwareModal('{{ $software->id }}')"
                aria-label="Tutup"
            >
                ×
            </button>

        </div>


        <form
            action="{{ route('software.update', $software) }}"
            method="POST"
            id="softwareEditForm{{ $software->id }}"
        >

            @csrf
            @method('PUT')

            <div class="software-create-body">

                {{-- =================================================
                     INFORMASI SOFTWARE
                ================================================== --}}

                <div class="software-form-section">

                    <div class="software-section-title">
                        Informasi Software
                    </div>

                    <div class="software-form-grid">

                        {{-- KODE --}}

                        <div class="software-form-group">

                            <label for="kode_{{ $software->id }}">
                                Kode
                            </label>

                            <input
                                type="text"
                                id="kode_{{ $software->id }}"
                                class="software-input"
                                value="{{ $software->kode }}"
                                readonly
                            >

                        </div>


                        {{-- NAMA ASET --}}

                        <div class="software-form-group">

                            <label for="nama_aset_{{ $software->id }}">
                                Nama Aset / Nama Software
                                <span class="required-mark">*</span>
                            </label>

                            <input
                                type="text"
                                id="nama_aset_{{ $software->id }}"
                                name="nama_aset"
                                class="software-input @error('nama_aset') error @enderror"
                                value="{{ old('nama_aset', $software->nama_aset ?: $software->jenis) }}"
                                placeholder="Masukkan nama aplikasi/software"
                                required
                            >

                            @error('nama_aset')
                                <div class="field-error">{{ $message }}</div>
                            @enderror

                        </div>


                        {{-- KATEGORI --}}

                        <div class="software-form-group">

                            <label for="kategori_id_{{ $software->id }}">
                                Kategori
                                <span class="required-mark">*</span>
                            </label>

                            <select
                                id="kategori_id_{{ $software->id }}"
                                name="kategori_id"
                                class="software-select @error('kategori_id') error @enderror"
                                required
                            >

                                <option value="">
                                    Pilih Kategori
                                </option>

                                @foreach($kategoriOptions ?? [] as $kategori)

                                    <option
                                        value="{{ $kategori->id }}"
                                        {{ old('kategori_id', $software->kategori_id) == $kategori->id ? 'selected' : '' }}
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
                                <div class="field-error">{{ $message }}</div>
                            @enderror

                        </div>


                        {{-- KATEGORI SISTEM ELEKTRONIK --}}

                        <div class="software-form-group">

                            <label for="kategori_sistem_elektronik_{{ $software->id }}">
                                Kategori Sistem Elektronik
                            </label>

                            <select
                                id="kategori_sistem_elektronik_{{ $software->id }}"
                                name="kategori_sistem_elektronik"
                                class="software-select @error('kategori_sistem_elektronik') error @enderror"
                            >

                                <option value="">
                                    Pilih Kategori
                                </option>

                                <option
                                    value="Rendah"
                                    {{ old('kategori_sistem_elektronik', $software->kategori_sistem_elektronik) === 'Rendah' ? 'selected' : '' }}
                                >
                                    Rendah
                                </option>

                                <option
                                    value="Tinggi"
                                    {{ old('kategori_sistem_elektronik', $software->kategori_sistem_elektronik) === 'Tinggi' ? 'selected' : '' }}
                                >
                                    Tinggi
                                </option>

                                <option
                                    value="Strategis"
                                    {{ old('kategori_sistem_elektronik', $software->kategori_sistem_elektronik) === 'Strategis' ? 'selected' : '' }}
                                >
                                    Strategis
                                </option>

                            </select>

                            <div class="master-info">
                                Opsional. Dapat dikosongkan.
                                <a
                                    href="https://pse.layanan.go.id/api/downloadguide?fileName=FORMAT%20KATEGORI%20SISTEM%20ELEKTRONIK.pdf&nd=1779680847073&utm_source=kominfo&utm_medium=shorturl"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    Lihat Template Penilaian
                                </a>
                            </div>

                            @error('kategori_sistem_elektronik')
                                <div class="field-error">{{ $message }}</div>
                            @enderror

                        </div>


                        {{-- SSL --}}

                        <div class="software-form-group">

                            <label for="ssl_id_{{ $software->id }}">
                                SSL
                                <span class="required-mark">*</span>
                            </label>

                            <div class="ssl-select-wrapper">

                                <select
                                    id="ssl_id_{{ $software->id }}"
                                    name="ssl_id"
                                    class="software-select @error('ssl_id') error @enderror"
                                    required
                                >

                                    <option value="">
                                        Pilih SSL
                                    </option>

                                    @foreach($sslOptions ?? [] as $ssl)

                                        <option
                                            value="{{ $ssl->id }}"
                                            data-expire="{{ $ssl->tanggal_expire ? $ssl->tanggal_expire->format('Y-m-d') : '' }}"
                                            data-name="{{ $ssl->nama_ssl }}"
                                            {{ old('ssl_id', $software->ssl_id) == $ssl->id ? 'selected' : '' }}
                                        >
                                            {{ $ssl->nama_ssl }}
                                        </option>

                                    @endforeach

                                </select>

                                <div
                                    id="sslExpireInfoEdit{{ $software->id }}"
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
                                <div class="field-error">{{ $message }}</div>
                            @enderror

                        </div>


                        {{-- URL HOMEPAGE --}}

                        <div class="software-form-group full">

                            <label for="url_homepage_{{ $software->id }}">
                                URL Homepage
                            </label>

                            <input
                                type="url"
                                id="url_homepage_{{ $software->id }}"
                                name="url_homepage"
                                class="software-input @error('url_homepage') error @enderror"
                                value="{{ old('url_homepage', $software->url_homepage) }}"
                                placeholder="https://contoh.bekasikota.go.id"
                            >

                            @error('url_homepage')
                                <div class="field-error">{{ $message }}</div>
                            @enderror

                        </div>


                        {{-- IP PUBLIC --}}

                        <div class="software-form-group">

                            <label for="ip_public_{{ $software->id }}">
                                IP Public
                            </label>

                            <input
                                type="text"
                                id="ip_public_{{ $software->id }}"
                                name="ip_public"
                                class="software-input @error('ip_public') error @enderror"
                                value="{{ old('ip_public', $software->ip_public) }}"
                                placeholder="Contoh: 103.123.45.67"
                                inputmode="decimal"
                                autocomplete="off"
                            >

                            <div class="ip-hint">
                                Hanya menerima alamat IP yang valid.
                            </div>

                            @error('ip_public')
                                <div class="field-error">{{ $message }}</div>
                            @enderror

                        </div>


                        {{-- IP PRIVATE --}}

                        <div class="software-form-group">

                            <label for="ip_private_{{ $software->id }}">
                                IP Private
                            </label>

                            <input
                                type="text"
                                id="ip_private_{{ $software->id }}"
                                name="ip_private"
                                class="software-input @error('ip_private') error @enderror"
                                value="{{ old('ip_private', $software->ip_private) }}"
                                placeholder="Contoh: 192.168.1.10"
                                inputmode="decimal"
                                autocomplete="off"
                            >

                            <div class="ip-hint">
                                Hanya menerima alamat IP yang valid.
                            </div>

                            @error('ip_private')
                                <div class="field-error">{{ $message }}</div>
                            @enderror

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     SERVER & HOSTING
                ================================================== --}}

                <div class="software-form-section">

                    <div class="software-section-title">
                        Server & Hosting
                    </div>

                    <div class="software-form-grid">

                        {{-- HOSTING --}}

                        <div class="software-form-group">

                            <label for="hosting_id_{{ $software->id }}">
                                Hosting
                                <span class="required-mark">*</span>
                            </label>

                            <select
                                id="hosting_id_{{ $software->id }}"
                                name="hosting_id"
                                class="software-select @error('hosting_id') error @enderror"
                                required
                            >

                                <option value="">
                                    Pilih Hosting
                                </option>

                                @foreach($hostingOptions ?? [] as $hosting)

                                    <option
                                        value="{{ $hosting->id }}"
                                        {{ old('hosting_id', $software->hosting_id) == $hosting->id ? 'selected' : '' }}
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
                                <div class="field-error">{{ $message }}</div>
                            @enderror

                        </div>


                        {{-- STATUS --}}

                        <div class="software-form-group">

                            <label for="status_{{ $software->id }}">
                                Status
                                <span class="required-mark">*</span>
                            </label>

                            <select
                                id="status_{{ $software->id }}"
                                name="status"
                                class="software-select @error('status') error @enderror"
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
                                <div class="field-error">{{ $message }}</div>
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

                            <label for="pic_id_{{ $software->id }}">
                                PIC
                                <span class="required-mark">*</span>
                            </label>

                            <select
                                id="pic_id_{{ $software->id }}"
                                name="pic_id"
                                class="software-select @error('pic_id') error @enderror"
                                required
                            >

                                <option value="">
                                    Pilih PIC
                                </option>

                                @foreach($picOptions ?? [] as $pic)

                                    <option
                                        value="{{ $pic->id }}"
                                        {{ old('pic_id', $software->pic_id) == $pic->id ? 'selected' : '' }}
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
                                <div class="field-error">{{ $message }}</div>
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

                                <label for="kerahasiaan_{{ $software->id }}">
                                    Kerahasiaan
                                    <span class="required-mark">*</span>
                                </label>

                                <select
                                    id="kerahasiaan_{{ $software->id }}"
                                    name="kerahasiaan"
                                    class="software-select @error('kerahasiaan') error @enderror"
                                    required
                                >

                                    <option value="">
                                        Pilih Nilai
                                    </option>

                                    @for($i = 1; $i <= 3; $i++)

                                        <option
                                            value="{{ $i }}"
                                            {{ old('kerahasiaan', $software->kerahasiaan) == $i ? 'selected' : '' }}
                                        >
                                            {{ $i }}
                                        </option>

                                    @endfor

                                </select>

                            </div>

                        </div>


                        {{-- INTEGRITAS --}}

                        <div class="cia-card">

                            <div class="software-form-group">

                                <label for="integritas_{{ $software->id }}">
                                    Integritas
                                    <span class="required-mark">*</span>
                                </label>

                                <select
                                    id="integritas_{{ $software->id }}"
                                    name="integritas"
                                    class="software-select @error('integritas') error @enderror"
                                    required
                                >

                                    <option value="">
                                        Pilih Nilai
                                    </option>

                                    @for($i = 1; $i <= 3; $i++)

                                        <option
                                            value="{{ $i }}"
                                            {{ old('integritas', $software->integritas) == $i ? 'selected' : '' }}
                                        >
                                            {{ $i }}
                                        </option>

                                    @endfor

                                </select>

                            </div>

                        </div>


                        {{-- KETERSEDIAAN --}}

                        <div class="cia-card">

                            <div class="software-form-group">

                                <label for="ketersediaan_{{ $software->id }}">
                                    Ketersediaan
                                    <span class="required-mark">*</span>
                                </label>

                                <select
                                    id="ketersediaan_{{ $software->id }}"
                                    name="ketersediaan"
                                    class="software-select @error('ketersediaan') error @enderror"
                                    required
                                >

                                    <option value="">
                                        Pilih Nilai
                                    </option>

                                    @for($i = 1; $i <= 3; $i++)

                                        <option
                                            value="{{ $i }}"
                                            {{ old('ketersediaan', $software->ketersediaan) == $i ? 'selected' : '' }}
                                        >
                                            {{ $i }}
                                        </option>

                                    @endfor

                                </select>

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
                                Nilai
                            </div>

                            <div class="nilai-box-value">
                                {{ $software->nilai !== null ? number_format((float) $software->nilai, 2) : '-' }}
                            </div>

                        </div>


                        <div class="keterangan-box">

                            <div class="keterangan-box-label">
                                Keterangan
                            </div>

                            <div class="keterangan-box-value">
                                {{ $software->keterangan ?: '-' }}
                            </div>

                        </div>

                    </div>

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

                            <label for="deskripsi_aplikasi_{{ $software->id }}">
                                Deskripsi Aplikasi
                            </label>

                            <textarea
                                id="deskripsi_aplikasi_{{ $software->id }}"
                                name="deskripsi_aplikasi"
                                class="software-textarea @error('deskripsi_aplikasi') error @enderror"
                                placeholder="Masukkan deskripsi aplikasi/software"
                            >{{ old('deskripsi_aplikasi', $software->deskripsi_aplikasi) }}</textarea>

                            @error('deskripsi_aplikasi')
                                <div class="field-error">{{ $message }}</div>
                            @enderror

                        </div>

                    </div>

                </div>

            </div>


            <div class="software-create-footer">

                <button
                    type="button"
                    class="software-btn-cancel"
                    onclick="closeEditSoftwareModal('{{ $software->id }}')"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="software-btn-save"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

<script>
(function () {

    const id = @json($software->id);

    window['initEditSoftwareModal_' + id] = function () {

        const modal = document.getElementById(
            'software-edit-modal-' + id
        );

        if (!modal) {
            return;
        }

        modal.setAttribute('aria-hidden', 'false');

        const sslSelect = document.getElementById(
            'ssl_id_' + id
        );

        const expireInfo = document.getElementById(
            'sslExpireInfoEdit' + id
        );

        if (!sslSelect || !expireInfo) {
            return;
        }

        const selected =
            sslSelect.options[sslSelect.selectedIndex];

        if (!selected || !selected.value) {
            expireInfo.classList.remove(
                'show',
                'warning',
                'expired'
            );

            expireInfo.innerHTML = '';

            return;
        }

        const expire =
            selected.getAttribute('data-expire');

        const name =
            selected.getAttribute('data-name') ||
            selected.textContent.trim();

        if (!expire) {

            expireInfo.classList.remove(
                'warning',
                'expired'
            );

            expireInfo.classList.add('show');

            expireInfo.innerHTML =
                '<strong>' +
                name +
                '</strong> — Tidak memiliki tanggal expire.';

            return;
        }

        const expireDate =
            new Date(expire + 'T00:00:00');

        const today = new Date();

        today.setHours(
            0,
            0,
            0,
            0
        );

        const diffDays =
            Math.ceil(
                (
                    expireDate.getTime() -
                    today.getTime()
                ) /
                (1000 * 60 * 60 * 24)
            );

        expireInfo.classList.remove(
            'warning',
            'expired'
        );

        expireInfo.classList.add('show');

        const formattedDate =
            expireDate.toLocaleDateString(
                'id-ID',
                {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                }
            );

        if (diffDays < 0) {

            expireInfo.classList.add('expired');

            expireInfo.innerHTML =
                '<strong>' +
                name +
                '</strong> — Expire pada ' +
                formattedDate +
                ' <strong>(Expired)</strong>';

        } else if (diffDays <= 30) {

            expireInfo.classList.add('warning');

            expireInfo.innerHTML =
                '<strong>' +
                name +
                '</strong> — Expire pada ' +
                formattedDate +
                ' <strong>(' +
                diffDays +
                ' hari lagi)</strong>';

        } else {

            expireInfo.innerHTML =
                '<strong>' +
                name +
                '</strong> — Expire pada ' +
                formattedDate;

        }

    };


    const sslSelect = document.getElementById(
        'ssl_id_' + id
    );

    if (sslSelect) {

        sslSelect.addEventListener(
            'change',
            function () {

                window[
                    'initEditSoftwareModal_' + id
                ]();

            }
        );

    }

})();
</script>

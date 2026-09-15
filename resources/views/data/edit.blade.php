@extends('layouts.app')

@section('title', 'Edit Dataset')
@section('page-title', 'Edit Dataset')

@section('content')

<style>
.edit-page {
    max-width: 900px;
    margin: 0 auto;
}

.edit-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    box-shadow: 0 2px 10px rgba(15,23,42,.04);
    overflow: hidden;
}

.edit-header {
    padding: 20px 22px;
    border-bottom: 1px solid #edf0f3;
}

.edit-title {
    margin: 0;
    color: #1f2937;
    font-size: 20px;
    font-weight: 700;
}

.edit-subtitle {
    margin: 5px 0 0;
    color: #9ca3af;
    font-size: 11px;
}

.edit-body {
    padding: 22px;
}

.edit-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.edit-group.full {
    grid-column: 1 / -1;
}

.edit-label {
    display: block;
    margin-bottom: 6px;
    color: #374151;
    font-size: 11px;
    font-weight: 700;
}

.edit-label span {
    color: #ef4444;
}

.edit-control {
    width: 100%;
    min-height: 40px;
    padding: 9px 11px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    outline: none;
    font-size: 11px;
    box-sizing: border-box;
}

.edit-control:focus {
    border-color: #079bd8;
    box-shadow: 0 0 0 3px rgba(7,155,216,.08);
}

.edit-help {
    display: block;
    margin-top: 5px;
    color: #9ca3af;
    font-size: 9px;
}

.edit-file-current {
    margin-top: 8px;
    padding: 10px 12px;
    background: #f8fafc;
    border-radius: 8px;
    color: #64748b;
    font-size: 10px;
}

.edit-file-current a {
    color: #0369a1;
    font-weight: 600;
    text-decoration: none;
}

.edit-footer {
    padding: 14px 22px;
    border-top: 1px solid #edf0f3;
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

.edit-cancel,
.edit-save {
    height: 38px;
    padding: 0 16px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
}

.edit-cancel {
    border: 1px solid #d1d5db;
    background: #fff;
    color: #4b5563;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.edit-save {
    border: none;
    background: #071b88;
    color: #fff;
}

.edit-alert {
    padding: 12px 14px;
    border-radius: 9px;
    margin-bottom: 16px;
    background: #fee2e2;
    color: #991b1b;
    font-size: 11px;
}

@media(max-width:700px) {
    .edit-grid {
        grid-template-columns: 1fr;
    }

    .edit-group.full {
        grid-column: auto;
    }
}
</style>

<div class="edit-page">

    @if($errors->any())
        <div class="edit-alert">
            <strong>Data gagal disimpan.</strong>

            <ul style="margin:6px 0 0 18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="edit-card">

        <div class="edit-header">
            <h1 class="edit-title">
                Edit Dataset
            </h1>

            <p class="edit-subtitle">
                Perubahan dataset akan diajukan kembali untuk verifikasi.
            </p>
        </div>

        <form
            action="{{ route('data.update', $data->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf
            @method('PUT')

            <div class="edit-body">

                <div class="edit-grid">

                    <div class="edit-group full">
                        <label class="edit-label">
                            Nama Dataset <span>*</span>
                        </label>

                        <input
                            type="text"
                            name="nama_dataset"
                            class="edit-control"
                            value="{{ old('nama_dataset', $data->nama_dataset) }}"
                            required
                        >
                    </div>

                    <div>
                        <label class="edit-label">
                            Topik <span>*</span>
                        </label>

                        <select
                            name="topik"
                            class="edit-control"
                            required
                        >
                            <option value="">
                                Pilih Topik
                            </option>

                            @foreach(($topikData ?? collect()) as $topik)
                                <option
                                    value="{{ $topik }}"
                                    {{ old('topik', $data->topik) == $topik ? 'selected' : '' }}
                                >
                                    {{ $topik }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="edit-label">
                            Tahun <span>*</span>
                        </label>

                        <input
                            type="number"
                            name="tahun"
                            class="edit-control"
                            min="1900"
                            max="2100"
                            value="{{ old('tahun', $data->tahun) }}"
                            required
                        >
                    </div>

                    <div class="edit-group full">

                        <label class="edit-label">
                            Deskripsi
                        </label>

                        <textarea
                            name="deskripsi"
                            class="edit-control"
                            rows="5"
                        >{{ old('deskripsi', $data->deskripsi) }}</textarea>

                    </div>

                    <div class="edit-group full">

                        <label class="edit-label">
                            Ganti File Excel
                        </label>

                        <input
                            type="file"
                            name="file_data"
                            class="edit-control"
                            accept=".xls,.xlsx"
                        >

                        <small class="edit-help">
                            Kosongkan jika file Excel tidak ingin diganti.
                            Jika diganti, Sheet 1 harus Metadata dan Sheet 2 harus Dataset.
                        </small>

                        @if($data->file_data)
                            <div class="edit-file-current">
                                <i class="bi bi-file-earmark-excel"></i>
                                File saat ini:
                                <a
                                    href="{{ route('data.download', $data->id) }}"
                                >
                                    Download Excel
                                </a>
                            </div>
                        @endif

                    </div>

                </div>

            </div>

            <div class="edit-footer">

                <a
                    href="{{ route('data.index') }}"
                    class="edit-cancel"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="edit-save"
                >
                    <i class="bi bi-check-lg"></i>
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
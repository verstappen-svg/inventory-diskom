@extends('layouts.app')

@section('title', 'SDM - Inventory IT Assets')
@section('page-title', 'Human Resource Management')

@section('content')

<style>
  :root{
    --blue-dark:#0b2b52;
    --blue-active:#0e63c9;
    --border:#e3e8ef;
    --green:#22b573;
    --red:#e6483f;
    --radius:14px;
    --shadow:0 2px 10px rgba(16,40,80,.06);
  }
  .stats{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-bottom:22px;}
  .stat-card{border-radius:var(--radius);padding:18px 20px;box-shadow:var(--shadow);}
  .stat-card .label{font-size:12.5px;font-weight:600;margin-bottom:8px;}
  .stat-card .value{font-size:26px;font-weight:700;color:#1c2c47;}
  .stat-1{background:#eaf6ff;} .stat-1 .label{color:#1f9fe0;}
  .stat-2{background:#fdf6e3;} .stat-2 .label{color:#d6a400;}
  .stat-3{background:#eafaf0;} .stat-3 .label{color:#1fb673;}

  .panel{
    background:#fff;border-radius:var(--radius);
    box-shadow:var(--shadow);padding:18px 20px 10px;
  }
  .panel-top{display:flex;align-items:center;gap:12px;margin-bottom:16px;}
  .search-box{
    flex:1;display:flex;align-items:center;gap:8px;
    background:#f3f5f8;border-radius:22px;padding:9px 16px;
    color:#8a97ab;font-size:13px;
  }
  .search-box input{border:none;background:transparent;outline:none;flex:1;font-size:13px;color:#1c2c47;}
  .btn{
    border:none;border-radius:10px;padding:9px 16px;font-size:13px;
    font-weight:600;cursor:pointer;display:flex;align-items:center;gap:6px;
    white-space:nowrap;text-decoration:none;
  }
  .btn-outline{background:#fff;border:1px solid var(--border);color:#3b4b63;}
  .btn-primary{background:var(--blue-active);color:#fff;}
  .btn-primary:hover{background:#0a54ac;}
  .btn-outline:hover{background:#f3f5f8;}

  .filter-wrapper{position:relative;}
  .filter-dropdown{
    display:none;position:absolute;top:calc(100% + 8px);left:0;
    background:#fff;border:1px solid var(--border);border-radius:12px;
    box-shadow:0 10px 30px rgba(16,40,80,.15);padding:14px 16px;
    min-width:220px;z-index:50;
  }
  .filter-dropdown.show{display:block;}
  .filter-dropdown-title{
    font-size:12px;font-weight:700;color:#1c2c47;
    margin-bottom:10px;text-transform:uppercase;letter-spacing:.4px;
  }
  .filter-checkbox{
    display:flex;align-items:center;gap:8px;
    font-size:13px;color:#3b4b63;padding:6px 0;cursor:pointer;
  }
  .filter-checkbox input{width:15px;height:15px;cursor:pointer;}
  .filter-actions{
    display:flex;justify-content:space-between;gap:8px;
    margin-top:12px;padding-top:10px;border-top:1px solid var(--border);
  }
  .filter-reset{background:none;border:none;color:#8a97ab;font-size:12px;cursor:pointer;font-weight:600;}
  .filter-reset:hover{color:var(--red);}
  .filter-apply{
    background:var(--blue-active);color:#fff;border:none;
    border-radius:8px;padding:7px 16px;font-size:12px;font-weight:600;cursor:pointer;
  }
  .filter-apply:hover{background:#0a54ac;}

  table{width:100%;border-collapse:collapse;font-size:13px;}
  thead th{
    text-align:left;
    color:#8a97ab;
    font-weight:600;
    font-size:11.5px;
    text-transform:uppercase;
    letter-spacing:.4px;
    padding:14px 16px;
    border-bottom:2px solid var(--border);
    white-space:nowrap;
  }
  tbody td{padding:18px 16px;border-bottom:1px solid var(--border);color:#2b3a54;vertical-align:middle;line-height:1.5;}
  tbody tr{transition:background 0.15s;}
  tbody tr:last-child td{border-bottom:none;}
  tbody tr:hover{background:#fafbfd;}
  .nip{font-weight:600;}
  .nip small{display:block;font-weight:400;color:#8a97ab;font-size:11px;}
  .file-btn{
    border:1px solid var(--border);background:#fff;border-radius:8px;
    padding:6px 12px;font-size:12px;color:#3b4b63;cursor:pointer;
    text-decoration:none;display:inline-block;
  }
  .actions{display:flex;gap:8px;}
  .icon-btn{
    width:28px;height:28px;border-radius:50%;border:none;
    display:flex;align-items:center;justify-content:center;
    cursor:pointer;font-size:12px;color:#fff;text-decoration:none;
  }
  .icon-btn.edit{background:var(--green);}
  .icon-btn.delete{background:var(--red);}
  .icon-btn.approve{background:#22c55e;}
  .icon-btn.reject{background:#f59e0b;}

  .badge{
  display:inline-block;padding:5px 12px;border-radius:20px;
  font-size:11px;font-weight:700;
  }
  .badge-pending{background:#fef3c7;color:#d97706;}
  .badge-approved{background:#dcfce7;color:#16a34a;}
  .badge-rejected{background:#fee2e2;color:#dc2626;}
  .table-footer{
    display:flex;justify-content:space-between;align-items:center;
    padding:14px 4px 16px;font-size:12px;color:#8a97ab;
  }

  .overlay{
    position:fixed;inset:0;background:rgba(10,20,40,.55);
    display:none;align-items:center;justify-content:center;z-index:1100;
  }
  .overlay.show{display:flex;}
  .modal{
    background:#fff;border-radius:16px;width:520px;max-width:92vw;
    padding:24px 26px;box-shadow:0 20px 50px rgba(0,0,0,.25);
  }
  .modal-head{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:4px;}
  .modal-head h2{margin:0;font-size:17px;color:#1c2c47;}
  .modal-head .close{cursor:pointer;font-size:18px;color:#8a97ab;background:none;border:none;}
  .modal-sub{font-size:12.5px;color:#8a97ab;margin:0 0 18px;}
  .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px 16px;margin-bottom:20px;}
  .field label{display:block;font-size:12px;font-weight:600;color:#3b4b63;margin-bottom:6px;}
  .field input{
    width:100%;padding:10px 12px;border:1px solid var(--border);
    border-radius:9px;font-size:13px;outline:none;color:#1c2c47;background:#fff;
  }
  .field input[type="file"]{padding:8px 10px;}
  .field input:focus{border-color:var(--blue-active);}
  .field small{color:#8a97ab;display:block;margin-top:4px;font-size:11px;}
  .modal-actions{display:flex;justify-content:flex-end;gap:10px;}
  .btn-cancel{background:#fff;border:1px solid var(--border);color:#3b4b63;padding:10px 20px;border-radius:9px;font-size:13px;font-weight:600;cursor:pointer;}
  .btn-save{background:var(--blue-dark);color:#fff;padding:10px 22px;border-radius:9px;font-size:13px;font-weight:600;border:none;cursor:pointer;}

  .alert{
    background:#eafaf0;color:#1fb673;border-radius:10px;padding:10px 16px;
    font-size:13px;margin-bottom:16px;font-weight:600;
  }
  .alert-error{
    background:#fdeceb;color:var(--red);border-radius:10px;padding:10px 16px;
    font-size:13px;margin-bottom:16px;font-weight:600;
  }

  @media(max-width:900px){
    .stats{grid-template-columns:1fr;}
    table{font-size:12px;}
  }
</style>

@if(session('success'))
  <div class="alert">{{ session('success') }}</div>
@endif

@if($errors->any())
  <div class="alert-error">
    Gagal menyimpan data:
    <ul style="margin:6px 0 0 18px;padding:0;">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="stats">
  <div class="stat-card stat-1">
    <div class="label">Total Personel</div>
    <div class="value">{{ $sdm->total() ?? $sdm->count() }}</div>
  </div>
  <div class="stat-card stat-2">
    <div class="label">Sertifikasi Aktif</div>
    <div class="value">{{ $aktif ?? 0 }}</div>
  </div>
  <div class="stat-card stat-3">
    <div class="label">Sertifikasi Berakhir</div>
    <div class="value">{{ $berakhir ?? 0 }}</div>
  </div>
</div>

<div class="panel">
  <div class="panel-top">
    <div class="search-box">
      🔍 <input id="searchInput" type="text" placeholder="Search...">
    </div>

    <div class="filter-wrapper">
      <button class="btn btn-outline" id="filterBtn" type="button">☰ Filter</button>
      <div class="filter-dropdown" id="filterDropdown">
        <div class="filter-dropdown-title">Filter berdasarkan Jabatan</div>
        @php
          $jabatanList = $sdm->pluck('jabatan')->unique()->sort()->values();
        @endphp
        @foreach($jabatanList as $jab)
          <label class="filter-checkbox">
            <input type="checkbox" class="jabatan-filter" value="{{ $jab }}">
            {{ $jab }}
          </label>
        @endforeach
        <div class="filter-actions">
          <button type="button" class="filter-reset" id="filterReset">Reset</button>
          <button type="button" class="filter-apply" id="filterApply">Terapkan</button>
        </div>
      </div>
    </div>

    <button class="btn btn-primary" id="openModalBtn" type="button">+ Add</button>
  </div>

  <table>
    <thead>
      <tr>
        <th>NIP / ID</th>
        <th>NAMA</th>
        <th>JABATAN</th>
        <th>JENIS KOMPETENSI</th>
        <th>MASA BERLAKU</th>
        <th>DOKUMEN</th>
        <th>VERIFIKASI</th>
        <th>KOMENTAR</th>
        <th>AKSI</th>
      </tr>
    </thead>
    <tbody id="tableBody">
      @forelse($sdm as $row)
      <tr data-jabatan="{{ $row->jabatan }}">
        <td class="nip">{{ $row->nip }}<small>{{ $row->kode_dk }}</small></td>
        <td>{{ $row->nama }}</td>
        <td>{{ $row->jabatan }}</td>
        <td>{{ $row->kompetensi }}</td>
        <td>{{ \Carbon\Carbon::parse($row->masa_berlaku)->translatedFormat('d F Y') }}</td>
        <td>
          @if($row->dokumen)
            <a class="file-btn" href="{{ Storage::url($row->dokumen) }}" target="_blank" rel="noopener">Lihat File</a>
          @else
            <span class="file-btn" style="opacity:.5">Tidak ada</span>
          @endif
        </td>
        <td>
          @if($row->status_verifikasi == 'disetujui')
            <span class="badge badge-approved">Disetujui</span>
          @elseif($row->status_verifikasi == 'ditolak')
            <span class="badge badge-rejected">Ditolak</span>
          @else
            <span class="badge badge-pending">Menunggu Disetujui</span>
          @endif
        </td>
        <td>
          @if($row->catatan_verifikasi)
            <span style="font-size:12px;color:#6b7280;">{{ $row->catatan_verifikasi }}</span>
          @else
            <span style="font-size:12px;color:#c1c7d0;">-</span>
          @endif
        </td>
        <td class="actions">
          <button type="button" class="icon-btn edit" title="Edit"
            onclick="openEditModal({{ $row->id }}, '{{ $row->nip }}', '{{ addslashes($row->nama) }}', '{{ addslashes($row->jabatan) }}', '{{ addslashes($row->kompetensi) }}', '{{ $row->masa_berlaku }}', {{ $row->dokumen ? 'true' : 'false' }})">✎</button>
          <form action="{{ route('sdm.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?')" style="display:inline">
          @csrf
          @method('DELETE')
          <button type="submit" class="icon-btn delete" title="Hapus">🗑</button>
          </form>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="7" style="text-align:center;color:#8a97ab;padding:24px;">Belum ada data SDM.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <div class="table-footer">
  <span>Showing {{ $sdm->count() }} of {{ $sdm->total() ?? $sdm->count() }} entries</span>
  <div style="display:flex;gap:6px;">
    @for($i = 1; $i <= $sdm->lastPage(); $i++)
      <a href="{{ $sdm->url($i) }}"
         style="width:26px;height:26px;border-radius:6px;display:flex;align-items:center;justify-content:center;
         border:1px solid #e3e8ef;color:#3b4b63;text-decoration:none;font-size:12px;font-weight:600;
         {{ $sdm->currentPage() == $i ? 'background:#0e63c9;color:#fff;border-color:#0e63c9;' : '' }}">
        {{ $i }}
      </a>
    @endfor
  </div>
</div>

<!-- MODAL: Edit Data SDM -->
<div class="overlay" id="overlayEdit">
  <div class="modal">
    <div class="modal-head">
      <div>
        <h2>Edit Data SDM</h2>
        <p class="modal-sub">Perbarui detail data SDM.</p>
      </div>
      <button class="close" id="closeEditModalBtn" type="button">✕</button>
    </div>

    <form id="editForm" action="" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div class="form-grid">
        <div class="field">
          <label>NIP</label>
          <input type="text" name="nip" id="edit_nip" required>
        </div>
        <div class="field">
          <label>Jenis Kompetensi</label>
          <input type="text" name="kompetensi" id="edit_kompetensi" required>
        </div>
        <div class="field">
          <label>Nama</label>
          <input type="text" name="nama" id="edit_nama" required>
        </div>
        <div class="field">
          <label>Upload Dokumen</label>
          <input type="file" name="dokumen" accept=".pdf,.jpg,.jpeg,.png">
          <small id="edit_dokumen_info"></small>
        </div>
        <div class="field">
          <label>Jabatan</label>
          <input type="text" name="jabatan" id="edit_jabatan" required>
        </div>
        <div class="field">
          <label>Masa Berlaku</label>
          <input type="date" name="masa_berlaku" id="edit_masaberlaku" required>
        </div>
      </div>

      <div class="modal-actions">
        <button type="button" class="btn-cancel" id="cancelEditBtn">Batal</button>
        <button type="submit" class="btn-save">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- MODAL: Tambah Data SDM -->
<div class="overlay" id="overlay">
  <div class="modal">
    <div class="modal-head">
      <div>
        <h2>Tambah Data SDM</h2>
        <p class="modal-sub">Masukan detail aset data sdm baru ke dalam sistem.</p>
      </div>
      <button class="close" id="closeModalBtn" type="button">✕</button>
    </div>

    <form action="{{ route('sdm.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-grid">
        <div class="field">
          <label>NIP</label>
          <input type="text" name="nip" placeholder="Contoh: 1234567891" value="{{ old('nip') }}" required>
        </div>
        <div class="field">
          <label>Jenis Kompetensi</label>
          <input type="text" name="kompetensi" placeholder="Contoh: UX Design" value="{{ old('kompetensi') }}" required>
        </div>
        <div class="field">
          <label>Nama</label>
          <input type="text" name="nama" placeholder="Nama lengkap" value="{{ old('nama') }}" required>
        </div>
        <div class="field">
          <label>Upload Dokumen</label>
          <input type="file" name="dokumen" accept=".pdf,.jpg,.jpeg,.png">
        </div>
        <div class="field">
          <label>Jabatan</label>
          <input type="text" name="jabatan" placeholder="Contoh: Programmer" value="{{ old('jabatan') }}" required>
        </div>
        <div class="field">
          <label>Masa Berlaku</label>
          <input type="date" name="masa_berlaku" value="{{ old('masa_berlaku') }}" required>
        </div>
      </div>

      <div class="modal-actions">
        <button type="button" class="btn-cancel" id="cancelBtn">Batal</button>
        <button type="submit" class="btn-save">Simpan</button>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script>
  function applyFilters(){
    const checked = Array.from(document.querySelectorAll('.jabatan-filter:checked')).map(cb => cb.value);
    const searchQuery = document.getElementById('searchInput').value.toLowerCase();

    document.querySelectorAll('#tableBody tr').forEach(tr=>{
      const jabatan = tr.dataset.jabatan;
      const matchJabatan = checked.length === 0 || checked.includes(jabatan);
      const matchSearch = tr.textContent.toLowerCase().includes(searchQuery);
      tr.style.display = (matchJabatan && matchSearch) ? '' : 'none';
    });
  }
  document.getElementById('searchInput').addEventListener('input', applyFilters);

  const filterBtn = document.getElementById('filterBtn');
  const filterDropdown = document.getElementById('filterDropdown');

  filterBtn.addEventListener('click', (e)=>{
    e.stopPropagation();
    filterDropdown.classList.toggle('show');
  });
  document.addEventListener('click', (e)=>{
    if(!filterDropdown.contains(e.target) && e.target !== filterBtn){
      filterDropdown.classList.remove('show');
    }
  });
  document.getElementById('filterApply').addEventListener('click', ()=>{
    applyFilters();
    filterDropdown.classList.remove('show');
  });
  document.getElementById('filterReset').addEventListener('click', ()=>{
    document.querySelectorAll('.jabatan-filter').forEach(cb => cb.checked = false);
    applyFilters();
  });

  const overlay = document.getElementById('overlay');
  document.getElementById('openModalBtn').addEventListener('click', ()=> overlay.classList.add('show'));
  document.getElementById('closeModalBtn').addEventListener('click', ()=> overlay.classList.remove('show'));
  document.getElementById('cancelBtn').addEventListener('click', ()=> overlay.classList.remove('show'));
  overlay.addEventListener('click', (e)=>{ if(e.target === overlay) overlay.classList.remove('show'); });

  const overlayEdit = document.getElementById('overlayEdit');
  const editForm = document.getElementById('editForm');

  function openEditModal(id, nip, nama, jabatan, kompetensi, masaBerlaku, hasDokumen) {
    editForm.action = `/sdm/${id}`;
    document.getElementById('edit_nip').value = nip;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_jabatan').value = jabatan;
    document.getElementById('edit_kompetensi').value = kompetensi;
    document.getElementById('edit_masaberlaku').value = masaBerlaku;
    document.getElementById('edit_dokumen_info').textContent = hasDokumen
      ? 'Dokumen sudah tersimpan. Upload file baru untuk mengganti.'
      : 'Belum ada dokumen.';
    overlayEdit.classList.add('show');
  }

  document.getElementById('closeEditModalBtn').addEventListener('click', ()=> overlayEdit.classList.remove('show'));
  document.getElementById('cancelEditBtn').addEventListener('click', ()=> overlayEdit.classList.remove('show'));
  overlayEdit.addEventListener('click', (e)=>{ if(e.target === overlayEdit) overlayEdit.classList.remove('show'); });

  @if($errors->any() && old('nip'))
    overlay.classList.add('show');
  @endif
</script>
@endpush
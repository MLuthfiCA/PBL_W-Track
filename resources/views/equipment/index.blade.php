@extends('layouts.app')

@section('title', 'Equipment')
@section('page-title', 'Equipment')
@section('page-subtitle', 'Daftar dan pengelolaan master data equipment workshop')

@section('styles')
<style>
    .eq-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .eq-filter-form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        min-width: 260px;
        flex-wrap: wrap;
    }

    .search-input-wrap {
        position: relative;
        flex: 1;
        min-width: 220px;
        max-width: 340px;
    }

    .search-input-wrap svg,
    .search-input-wrap i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-neutral);
        width: 17px;
        height: 17px;
        pointer-events: none;
    }

    .search-input-wrap .wt-input {
        padding-left: 36px;
    }

    .filter-select-wrap {
        width: 180px;
    }

    .alert-banner {
        padding: 12px 16px;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 16px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    .alert-success {
        background: var(--success-bg);
        color: #1B6E3E;
        border: 1px solid #BBF7D0;
    }

    .alert-danger {
        background: var(--danger-bg);
        color: #B3261E;
        border: 1px solid #FECACA;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .wt-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 640px;
    }

    .wt-table th {
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-secondary);
        padding: 12px 16px;
        border-bottom: 1px solid var(--border-subtle);
        background: #FAFBFD;
        white-space: nowrap;
    }

    .wt-table td {
        height: 54px;
        padding: 10px 16px;
        font-size: 14px;
        color: var(--text-main);
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    .wt-table tbody tr:last-child td {
        border-bottom: none;
    }

    .wt-table tbody tr:hover {
        background: #F8FAFC;
    }

    .action-btns {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-icon-sm {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1px solid var(--border-subtle);
        background: #FFFFFF;
        color: var(--text-secondary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-icon-sm:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: var(--primary-light);
    }

    .btn-icon-sm.danger:hover {
        border-color: var(--danger);
        color: var(--danger);
        background: var(--danger-bg);
    }

    .empty-state-box {
        text-align: center;
        padding: 48px 20px;
    }

    .empty-state-circle {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: var(--primary-light);
        color: var(--primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
    }

    .modal-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.5);
        z-index: 200;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }

    .modal-backdrop.open {
        display: flex;
    }

    .modal-card {
        background: #FFFFFF;
        border-radius: 12px;
        width: 100%;
        max-width: 460px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .modal-header {
        padding: 18px 20px;
        border-bottom: 1px solid var(--border-subtle);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .modal-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-main);
    }

    .modal-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 6px;
    }

    .form-hint {
        font-size: 12px;
        color: var(--text-neutral);
        margin-top: 4px;
    }

    .modal-footer {
        padding: 14px 20px;
        border-top: 1px solid var(--border-subtle);
        background: #FAFBFD;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
</style>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert-banner alert-success">
            <i data-lucide="check-circle-2" style="width:18px;height:18px;flex-shrink:0;margin-top:1px;"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert-banner alert-danger">
            <i data-lucide="alert-circle" style="width:18px;height:18px;flex-shrink:0;margin-top:1px;"></i>
            <div>
                <strong style="display:block;margin-bottom:2px;">Gagal menyimpan data equipment:</strong>
                <ul style="margin-left:16px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="wt-card">
        <div class="eq-toolbar">
            <form method="GET" action="{{ route('equipment.index') }}" class="eq-filter-form">
                <div class="search-input-wrap">
                    <i data-lucide="search"></i>
                    <input type="text"
                           name="search"
                           class="wt-input"
                           value="{{ request('search') }}"
                           placeholder="Cari nama, kategori, atau UID RFID...">
                </div>

                <div class="filter-select-wrap">
                    <select name="status" class="wt-select" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Di Workshop</option>
                        <option value="borrowed" {{ request('status') === 'borrowed' ? 'selected' : '' }}>Di Luar Workshop</option>
                    </select>
                </div>

                <button type="submit" class="wt-btn wt-btn-outline">Filter</button>

                @if(request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('equipment.index') }}" class="wt-btn wt-btn-outline" style="color:var(--text-secondary);">Reset</a>
                @endif
            </form>

            <button type="button" class="wt-btn wt-btn-primary" onclick="openAddModal()">
                <i data-lucide="plus" style="width:18px;height:18px;"></i>
                <span>Tambah Equipment</span>
            </button>
        </div>

        @if($equipments->count() > 0)
            <div class="table-responsive">
                <table class="wt-table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Equipment</th>
                            <th>UID Tag RFID</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th style="width: 100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($equipments as $eq)
                            @php
                                $kodeEq = 'EQ-' . str_pad($eq->id, 3, '0', STR_PAD_LEFT);
                            @endphp
                            <tr>
                                <td><span class="font-mono">{{ $kodeEq }}</span></td>
                                <td style="font-weight: 600;">{{ $eq->name }}</td>
                                <td>
                                    <span class="font-mono" style="background:#F1F5F9;padding:3px 8px;border-radius:6px;color:var(--primary-dark);">
                                        {{ $eq->rfid_uid }}
                                    </span>
                                </td>
                                <td style="color: var(--text-secondary);">{{ $eq->category }}</td>
                                <td>
                                    @if($eq->status === 'available')
                                        <span class="badge badge-success">
                                            <i data-lucide="check-circle-2" style="width:13px;height:13px;"></i>
                                            Di Workshop
                                        </span>
                                    @else
                                        <span class="badge badge-warning">
                                            <i data-lucide="arrow-up-right" style="width:13px;height:13px;"></i>
                                            Di Luar Workshop
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <button type="button"
                                                class="btn-icon-sm"
                                                title="Edit Equipment"
                                                onclick="openEditModal({{ $eq->id }}, @js($eq->name), @js($eq->rfid_uid), @js($eq->category), @js($eq->status))">
                                            <i data-lucide="pencil" style="width:15px;height:15px;"></i>
                                        </button>

                                        <form method="POST"
                                              action="{{ route('equipment.destroy', $eq->id) }}"
                                              onsubmit="return confirm('Hapus equipment {{ $eq->name }} ({{ $kodeEq }})?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon-sm danger" title="Hapus Equipment">
                                                <i data-lucide="trash-2" style="width:15px;height:15px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state-box">
                <div class="empty-state-circle">
                    <i data-lucide="package" style="width:26px;height:26px;"></i>
                </div>
                <h3 style="font-size:16px;font-weight:700;color:var(--text-main);margin-bottom:6px;">
                    @if(request()->filled('search') || request()->filled('status'))
                        Equipment tidak ditemukan
                    @else
                        Belum ada data equipment. Tambahkan equipment pertama Anda.
                    @endif
                </h3>
                <p style="font-size:13px;color:var(--text-secondary);margin-bottom:18px;">
                    Daftarkan peralatan workshop beserta UID Tag RFID agar dapat dipantau saat keluar-masuk.
                </p>
                <button type="button" class="wt-btn wt-btn-primary" onclick="openAddModal()">
                    <i data-lucide="plus" style="width:18px;height:18px;"></i>
                    <span>Tambah Equipment</span>
                </button>
            </div>
        @endif
    </div>

    <!-- MODAL TAMBAH EQUIPMENT -->
    <div class="modal-backdrop" id="addModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Tambah Equipment Baru</h3>
                <button type="button" class="btn-icon-sm" onclick="closeModal('addModal')" aria-label="Tutup">
                    <i data-lucide="x" style="width:16px;height:16px;"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('equipment.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="add_name">Nama Equipment *</label>
                        <input type="text" id="add_name" name="name" class="wt-input" placeholder="Contoh: Solder Digital 60W" required>
                    </div>

                    <div class="form-group">
                        <label for="add_rfid">UID Tag RFID *</label>
                        <input type="text" id="add_rfid" name="rfid_uid" class="wt-input font-mono" placeholder="Contoh: B4C9102E" required>
                        <div class="form-hint">Harus unik dan sesuai identitas tag RFID yang ditempel pada alat.</div>
                    </div>

                    <div class="form-group">
                        <label for="add_category">Kategori Equipment *</label>
                        <select id="add_category" name="category" class="wt-select" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Power Tools">Power Tools</option>
                            <option value="Alat Ukur & Testing">Alat Ukur & Testing</option>
                            <option value="Soldering & Elektronik">Soldering & Elektronik</option>
                            <option value="Perkakas Tangan">Perkakas Tangan</option>
                            <option value="Perlengkapan K3">Perlengkapan K3</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="wt-btn wt-btn-outline" onclick="closeModal('addModal')">Batal</button>
                    <button type="submit" class="wt-btn wt-btn-primary">Simpan Equipment</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT EQUIPMENT -->
    <div class="modal-backdrop" id="editModal">
        <div class="modal-card">
            <div class="modal-header">
                <h3 class="modal-title">Perbarui Data Equipment</h3>
                <button type="button" class="btn-icon-sm" onclick="closeModal('editModal')" aria-label="Tutup">
                    <i data-lucide="x" style="width:16px;height:16px;"></i>
                </button>
            </div>
            <form method="POST" id="editForm" action="">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_name">Nama Equipment *</label>
                        <input type="text" id="edit_name" name="name" class="wt-input" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_rfid">UID Tag RFID *</label>
                        <input type="text" id="edit_rfid" name="rfid_uid" class="wt-input font-mono" required>
                    </div>

                    <div class="form-group">
                        <label for="edit_category">Kategori Equipment *</label>
                        <select id="edit_category" name="category" class="wt-select" required>
                            <option value="Power Tools">Power Tools</option>
                            <option value="Alat Ukur & Testing">Alat Ukur & Testing</option>
                            <option value="Soldering & Elektronik">Soldering & Elektronik</option>
                            <option value="Perkakas Tangan">Perkakas Tangan</option>
                            <option value="Perlengkapan K3">Perlengkapan K3</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edit_status">Status Lokasi *</label>
                        <select id="edit_status" name="status" class="wt-select" required>
                            <option value="available">Di Workshop</option>
                            <option value="borrowed">Di Luar Workshop</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="wt-btn wt-btn-outline" onclick="closeModal('editModal')">Batal</button>
                    <button type="submit" class="wt-btn wt-btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function openAddModal() {
        document.getElementById('addModal').classList.add('open');
    }

    function openEditModal(id, name, rfidUid, category, status) {
        const form = document.getElementById('editForm');
        form.action = '/equipment/' + id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_rfid').value = rfidUid;
        document.getElementById('edit_category').value = category;
        document.getElementById('edit_status').value = status;
        document.getElementById('editModal').classList.add('open');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('open');
    }
</script>
@endsection

@extends('layouts.app')

@section('title', 'Equipment')

@section('styles')
<style>
    body {
        background: #f0f4f8;
        display: flex;
    }

    .app-wrapper {
        display: flex;
        width: 100%;
        min-height: 100vh;
    }

    /* ── MAIN CONTENT ────────────────────────── */
    .main-content {
        margin-left: 220px;
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        min-width: 0;
    }

    /* ── TOPBAR ──────────────────────────────── */
    .topbar {
        height: 60px;
        background: #fff;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 28px;
        position: sticky;
        top: 0;
        z-index: 50;
        box-shadow: 0 1px 4px rgba(0,0,0,0.05);
    }

    .topbar-left {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .hamburger-btn {
        display: none;
        background: none;
        border: none;
        font-size: 22px;
        color: var(--text-secondary);
        cursor: pointer;
        padding: 4px;
    }

    .topbar-title h2 {
        font-size: 19px;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1.1;
    }

    .topbar-title p {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 1px;
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .notif-btn {
        position: relative;
        width: 38px;
        height: 38px;
        background: #f8fafc;
        border: 1px solid var(--border);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 19px;
        color: var(--text-secondary);
        transition: all var(--transition);
        text-decoration: none;
    }

    .notif-btn:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: #fff;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 12px;
        background: #f8fafc;
        border: 1px solid var(--border);
        border-radius: 10px;
    }

    .user-avatar {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
    }

    .user-details {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-primary);
    }

    .user-role {
        font-size: 11px;
        color: var(--text-muted);
    }

    /* ── PAGE CONTENT ────────────────────────── */
    .page-content {
        padding: 24px 28px;
        flex: 1;
    }

    /* ── PAGE HEADER ────────────────────────── */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .page-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .page-header p {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 4px;
    }

    /* ── PRIMARY BUTTON ─────────────────────── */
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 20px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all var(--transition);
        text-decoration: none;
        font-family: 'Inter', sans-serif;
    }

    .btn-primary:hover {
        box-shadow: 0 4px 14px var(--primary-glow);
        transform: translateY(-1px);
    }

    /* ── FLASH ALERTS ──────────────────────── */
    .alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 18px;
        border-radius: var(--radius-sm);
        font-size: 13.5px;
        font-weight: 500;
        margin-bottom: 20px;
        animation: alertSlideIn 0.3s ease-out;
    }

    @keyframes alertSlideIn {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .alert-success {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        color: #059669;
    }

    .alert-error {
        background: #FEF2F2;
        border: 1px solid #FECACA;
        color: #DC2626;
    }

    .alert-close {
        margin-left: auto;
        background: none;
        border: none;
        font-size: 18px;
        cursor: pointer;
        color: inherit;
        opacity: 0.6;
        padding: 0 2px;
        line-height: 1;
    }

    .alert-close:hover {
        opacity: 1;
    }

    /* ── SUMMARY ───────────────────────────── */
    .summary-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 18px 22px;
        box-shadow: var(--shadow-sm);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .summary-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: #EFF6FF;
        color: #3B82F6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .summary-label {
        font-size: 12px;
        color: var(--text-muted);
    }

    .summary-value {
        font-size: 22px;
        font-weight: 700;
        color: var(--text-primary);
        margin-top: 2px;
    }

    /* ── TABLE ───────────────────────────────── */
    .table-card {
        background: #fff;
        border-radius: var(--radius);
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 22px;
        border-bottom: 1px solid var(--border);
    }

    .section-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .table-info {
        font-size: 12px;
        color: var(--text-muted);
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead tr {
        background: #fafbfc;
    }

    .data-table th {
        padding: 11px 22px;
        text-align: left;
        font-size: 11.5px;
        font-weight: 600;
        color: var(--text-muted);
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-bottom: 1px solid var(--border);
        white-space: nowrap;
    }

    .data-table td {
        padding: 14px 22px;
        font-size: 13.5px;
        color: var(--text-primary);
        border-bottom: 1px solid #f5f7fa;
        vertical-align: middle;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .data-table tbody tr:hover {
        background: #fafcff;
    }

    .equipment-name {
        font-weight: 600;
    }

    .equipment-code {
        font-family: 'Courier New', monospace;
        font-size: 12.5px;
        color: var(--text-secondary);
    }

    /* ── BADGES ─────────────────────────────── */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 11px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .badge-out {
        background: #FFFBEB;
        color: #D97706;
    }

    .badge-workshop {
        background: #F0FDF4;
        color: #059669;
    }

    /* ── ACTION BUTTONS ────────────────────── */
    .action-btns {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        background: #fff;
        color: var(--text-secondary);
        cursor: pointer;
        font-size: 15px;
        transition: all var(--transition);
    }

    .btn-action:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: #F0FDFA;
    }

    .btn-action.btn-danger:hover {
        border-color: #EF4444;
        color: #EF4444;
        background: #FEF2F2;
    }

    /* ── EMPTY STATE ────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
    }

    .empty-icon {
        width: 54px;
        height: 54px;
        margin: 0 auto 14px;
        border-radius: 14px;
        background: #f1f5f9;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 25px;
    }

    .empty-state h3 {
        font-size: 15px;
        color: var(--text-primary);
        margin-bottom: 5px;
    }

    .empty-state p {
        font-size: 12.5px;
        color: var(--text-muted);
    }

    /* ── MODAL ──────────────────────────────── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.2s ease-out;
    }

    .modal-overlay.active {
        display: flex;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    .modal-box {
        background: #fff;
        border-radius: var(--radius);
        box-shadow: var(--shadow-lg);
        width: 100%;
        max-width: 480px;
        margin: 16px;
        animation: modalSlide 0.25s ease-out;
    }

    @keyframes modalSlide {
        from { opacity: 0; transform: translateY(-16px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px 0;
    }

    .modal-header h3 {
        font-size: 17px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .modal-close {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        border: none;
        background: #f1f5f9;
        color: var(--text-secondary);
        cursor: pointer;
        font-size: 18px;
        transition: all var(--transition);
    }

    .modal-close:hover {
        background: #e2e8f0;
        color: var(--text-primary);
    }

    .modal-body {
        padding: 20px 24px;
    }

    .modal-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 0 24px 20px;
    }

    /* ── FORM ───────────────────────────────── */
    .form-group {
        margin-bottom: 16px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 6px;
    }

    .form-group label .required {
        color: #EF4444;
        margin-left: 2px;
    }

    .form-input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 13.5px;
        font-family: 'Inter', sans-serif;
        color: var(--text-primary);
        background: #fff;
        transition: border-color var(--transition), box-shadow var(--transition);
        outline: none;
    }

    .form-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-glow);
    }

    .form-input.is-invalid {
        border-color: #DC2626;
    }

    .form-error {
        color: #DC2626;
        font-size: 12px;
        margin-top: 4px;
    }

    .form-select {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 13.5px;
        font-family: 'Inter', sans-serif;
        color: var(--text-primary);
        background: #fff;
        cursor: pointer;
        outline: none;
        transition: border-color var(--transition), box-shadow var(--transition);
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23718096' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
    }

    .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-glow);
    }

    /* ── MODAL BUTTONS ─────────────────────── */
    .btn-cancel {
        padding: 10px 20px;
        background: #f1f5f9;
        color: var(--text-secondary);
        border: 1px solid var(--border);
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all var(--transition);
    }

    .btn-cancel:hover {
        background: #e2e8f0;
        color: var(--text-primary);
    }

    .btn-danger {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 10px 20px;
        background: #EF4444;
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        transition: all var(--transition);
    }

    .btn-danger:hover {
        background: #DC2626;
        box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3);
    }

    /* ── DELETE MODAL ──────────────────────── */
    .delete-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #FEF2F2;
        color: #EF4444;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin: 0 auto 14px;
    }

    .delete-message {
        text-align: center;
    }

    .delete-message h4 {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 6px;
    }

    .delete-message p {
        font-size: 13px;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    .delete-name {
        font-weight: 600;
        color: var(--text-primary);
    }

    /* ── RESPONSIVE ─────────────────────────── */
    @media (max-width: 768px) {
        .main-content {
            margin-left: 0;
        }

        .hamburger-btn {
            display: block;
        }

        .page-content {
            padding: 16px;
        }

        .topbar {
            padding: 0 16px;
        }

        .user-details {
            display: none;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }

        .modal-box {
            max-width: 100%;
            margin: 12px;
        }
    }
</style>
@endsection

@section('content')
<div class="app-wrapper">

    <!-- SIDEBAR -->
    @include('partials.sidebar')

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="hamburger-btn" id="hamburgerBtn" aria-label="Toggle menu">
                    <i class="ri-menu-line"></i>
                </button>

                <div class="topbar-title">
                    <h2>Equipment</h2>
                    <p>Daftar equipment dan status keberadaannya</p>
                </div>
            </div>

            <div class="topbar-right">

                <a href="{{ route('notifikasi.index') }}"
                   class="notif-btn"
                   aria-label="Notifikasi">
                    <i class="ri-notification-3-line"></i>
                </a>

                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>

                    <div class="user-details">
                        <span class="user-name">
                            {{ Auth::user()->name }}
                        </span>
                        <span class="user-role">
                            Administrator
                        </span>
                    </div>
                </div>

            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="page-content">

            <!-- FLASH MESSAGES -->
            @if(session('success'))
            <div class="alert alert-success" id="alertSuccess">
                <i class="ri-checkbox-circle-line" style="font-size: 18px;"></i>
                <span>{{ session('success') }}</span>
                <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-error" id="alertError">
                <i class="ri-error-warning-line" style="font-size: 18px;"></i>
                <span>{{ session('error') }}</span>
                <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
            </div>
            @endif

            <!-- PAGE HEADER -->
            <div class="page-header">
                <div>
                    <h1>Daftar Equipment</h1>
                    <p>Data equipment yang terdaftar pada sistem W-Track.</p>
                </div>
                <button class="btn-primary" onclick="openAddModal()">
                    <i class="ri-add-line"></i> Tambah Equipment
                </button>
            </div>

            <!-- SUMMARY -->
            <div class="summary-card">
                <div class="summary-icon">
                    <i class="ri-archive-line"></i>
                </div>

                <div>
                    <div class="summary-label">
                        Total Equipment
                    </div>

                    <div class="summary-value">
                        {{ $equipment->count() }}
                    </div>
                </div>
            </div>

            <!-- TABLE -->
            <div class="table-card">

                <div class="table-header">
                    <div class="section-title">
                        Data Equipment
                    </div>

                    <div class="table-info">
                        {{ $equipment->count() }} equipment
                    </div>
                </div>

                <div class="table-wrapper">

                    @if($equipment->count() > 0)

                    <table class="data-table">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode RFID</th>
                                <th>Nama Equipment</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($equipment as $index => $eq)

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    <span class="equipment-code">
                                        {{ $eq->rfid_uid }}
                                    </span>
                                </td>

                                <td>
                                    <span class="equipment-name">
                                        {{ $eq->name }}
                                    </span>
                                </td>

                                <td>
                                    {{ $eq->category ?? '-' }}
                                </td>

                                <td>

                                    @if($eq->status === 'borrowed')

                                        <span class="badge badge-out">
                                            Dipinjam
                                        </span>

                                    @else

                                        <span class="badge badge-workshop">
                                            Tersedia
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    <div class="action-btns">
                                        <button class="btn-action"
                                                title="Edit"
                                                onclick="openEditModal({{ $eq->id }}, '{{ addslashes($eq->name) }}', '{{ addslashes($eq->category) }}', '{{ addslashes($eq->rfid_uid) }}', '{{ $eq->status }}')">
                                            <i class="ri-pencil-line"></i>
                                        </button>
                                        <button class="btn-action btn-danger"
                                                title="Hapus"
                                                onclick="openDeleteModal({{ $eq->id }}, '{{ addslashes($eq->name) }}')">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </div>
                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                    @else

                    <div class="empty-state">

                        <div class="empty-icon">
                            <i class="ri-inbox-line"></i>
                        </div>

                        <h3>Belum ada equipment</h3>

                        <p>
                            Data equipment belum tersedia di dalam sistem.
                        </p>

                    </div>

                    @endif

                </div>
            </div>

        </main>
    </div>

</div>

<!-- ════════════════════════════════════════════════ -->
<!-- ADD EQUIPMENT MODAL                             -->
<!-- ════════════════════════════════════════════════ -->
<div class="modal-overlay" id="addModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Tambah Equipment</h3>
            <button class="modal-close" onclick="closeAddModal()">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <form action="{{ route('equipment.store') }}" method="POST" id="addForm">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Equipment <span class="required">*</span></label>
                    <input type="text"
                           name="name"
                           class="form-input @error('name') is-invalid @enderror"
                           placeholder="Masukkan nama equipment"
                           value="{{ old('name') }}">
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Kategori <span class="required">*</span></label>
                    <input type="text"
                           name="category"
                           class="form-input @error('category') is-invalid @enderror"
                           placeholder="Masukkan kategori equipment"
                           value="{{ old('category') }}">
                    @error('category')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>UID Tag RFID <span class="required">*</span></label>
                    <input type="text"
                           name="rfid_uid"
                           class="form-input @error('rfid_uid') is-invalid @enderror"
                           placeholder="Masukkan UID tag RFID"
                           value="{{ old('rfid_uid') }}">
                    @error('rfid_uid')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeAddModal()">Batal</button>
                <button type="submit" class="btn-primary">
                    <i class="ri-save-line"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ════════════════════════════════════════════════ -->
<!-- EDIT EQUIPMENT MODAL                            -->
<!-- ════════════════════════════════════════════════ -->
<div class="modal-overlay" id="editModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Edit Equipment</h3>
            <button class="modal-close" onclick="closeEditModal()">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Equipment <span class="required">*</span></label>
                    <input type="text"
                           name="name"
                           id="editName"
                           class="form-input"
                           placeholder="Masukkan nama equipment">
                </div>

                <div class="form-group">
                    <label>Kategori <span class="required">*</span></label>
                    <input type="text"
                           name="category"
                           id="editCategory"
                           class="form-input"
                           placeholder="Masukkan kategori equipment">
                </div>

                <div class="form-group">
                    <label>UID Tag RFID <span class="required">*</span></label>
                    <input type="text"
                           name="rfid_uid"
                           id="editRfidUid"
                           class="form-input"
                           placeholder="Masukkan UID tag RFID">
                </div>

                <div class="form-group">
                    <label>Status <span class="required">*</span></label>
                    <select name="status" id="editStatus" class="form-select">
                        <option value="available">Tersedia</option>
                        <option value="borrowed">Dipinjam</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="btn-primary">
                    <i class="ri-save-line"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ════════════════════════════════════════════════ -->
<!-- DELETE CONFIRMATION MODAL                       -->
<!-- ════════════════════════════════════════════════ -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Hapus Equipment</h3>
            <button class="modal-close" onclick="closeDeleteModal()">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-body">
                <div class="delete-icon">
                    <i class="ri-delete-bin-line"></i>
                </div>
                <div class="delete-message">
                    <h4>Apakah Anda yakin?</h4>
                    <p>Equipment <span class="delete-name" id="deleteEquipmentName"></span> akan dihapus secara permanen dan tidak dapat dikembalikan.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeDeleteModal()">Batal</button>
                <button type="submit" class="btn-danger">
                    <i class="ri-delete-bin-line"></i> Hapus
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // ── Sidebar toggle pada perangkat mobile ──
    var hamburgerBtn = document.getElementById('hamburgerBtn');
    var sidebar = document.getElementById('sidebar');
    var sidebarClose = document.getElementById('sidebarClose');
    var sidebarOverlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        if (sidebar) sidebar.classList.add('open');
        if (sidebarOverlay) sidebarOverlay.classList.add('open');
    }

    function closeSidebar() {
        if (sidebar) sidebar.classList.remove('open');
        if (sidebarOverlay) sidebarOverlay.classList.remove('open');
    }

    if (hamburgerBtn) hamburgerBtn.addEventListener('click', openSidebar);
    if (sidebarClose) sidebarClose.addEventListener('click', closeSidebar);
    if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);

    // ── Add Modal ──
    function openAddModal() {
        document.getElementById('addModal').classList.add('active');
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.remove('active');
    }

    // ── Edit Modal ──
    function openEditModal(id, name, category, rfidUid, status) {
        var form = document.getElementById('editForm');
        form.action = '/equipment/' + id;
        document.getElementById('editName').value = name;
        document.getElementById('editCategory').value = category;
        document.getElementById('editRfidUid').value = rfidUid;
        document.getElementById('editStatus').value = status;
        document.getElementById('editModal').classList.add('active');
    }

    function closeEditModal() {
        document.getElementById('editModal').classList.remove('active');
    }

    // ── Delete Modal ──
    function openDeleteModal(id, name) {
        var form = document.getElementById('deleteForm');
        form.action = '/equipment/' + id;
        document.getElementById('deleteEquipmentName').textContent = name;
        document.getElementById('deleteModal').classList.add('active');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('active');
    }

    // ── Close modals on overlay click ──
    document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                overlay.classList.remove('active');
            }
        });
    });

    // ── Close modals on Escape key ──
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay.active').forEach(function(modal) {
                modal.classList.remove('active');
            });
        }
    });

    // ── Auto-open Add modal if there are validation errors (from store) ──
    @if($errors->any() && old('_method') === null)
        openAddModal();
    @endif

    // ── Auto-dismiss flash alerts after 5 seconds ──
    setTimeout(function() {
        var alert = document.getElementById('alertSuccess');
        if (alert) alert.style.display = 'none';
    }, 5000);

    setTimeout(function() {
        var alert = document.getElementById('alertError');
        if (alert) alert.style.display = 'none';
    }, 5000);
</script>
@endsection

@extends('layouts.app')

@section('title', 'Pemeliharaan Equipment')

@section('styles')
<style>
    /* ── TOPBAR SMOOTH EDGES ─────────────────── */
    .topbar {
        height: 64px;
        background: #fff;
        border: 1px solid var(--border);
        border-radius: 16px;
        margin: 16px 28px 0 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 24px;
        position: sticky;
        top: 16px;
        z-index: 50;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        transition: all var(--transition);
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

    /* ── SUMMARY CARDS ──────────────────────── */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .summary-card {
        background: #fff;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 18px 22px;
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .summary-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
    }

    .summary-icon.warning {
        background: #FEF2F2;
        color: #EF4444;
    }

    .summary-icon.success {
        background: #F0FDF4;
        color: #10B981;
    }

    .summary-label {
        font-size: 12.5px;
        color: var(--text-muted);
        font-weight: 500;
    }

    .summary-value {
        font-size: 24px;
        font-weight: 800;
        color: var(--text-primary);
        margin-top: 2px;
    }

    /* ── TABLE CARD ──────────────────────────── */
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
        padding: 12px 22px;
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

    /* ── BADGES ──────────────────────────────── */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
    }

    .badge-repair {
        background: #FEF2F2;
        color: #DC2626;
        border: 1px solid #FECACA;
    }

    /* ── BUTTONS ─────────────────────────────── */
    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        border: none;
        border-radius: var(--radius-sm);
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all var(--transition);
        box-shadow: 0 2px 8px var(--primary-glow);
        text-decoration: none;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 14px rgba(0, 188, 212, 0.4);
    }

    .btn-success {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        background: #10B981;
        color: #fff;
        border: none;
        border-radius: var(--radius-sm);
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all var(--transition);
    }

    .btn-success:hover {
        background: #059669;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.35);
    }

    .btn-cancel {
        padding: 10px 18px;
        background: #f1f5f9;
        color: var(--text-secondary);
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all var(--transition);
    }

    .btn-cancel:hover {
        background: #e2e8f0;
        color: var(--text-primary);
    }

    /* ── ALERTS ──────────────────────────────── */
    .alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 18px;
        border-radius: var(--radius-sm);
        margin-bottom: 20px;
        font-size: 13.5px;
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
    }

    .alert-close:hover {
        opacity: 1;
    }

    /* ── EMPTY STATE ────────────────────────── */
    .empty-state {
        text-align: center;
        padding: 56px 20px;
    }

    .empty-icon {
        width: 60px;
        height: 60px;
        margin: 0 auto 16px;
        border-radius: 16px;
        background: #f0fdf4;
        color: #10B981;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .empty-state h3 {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 6px;
    }

    .empty-state p {
        font-size: 13px;
        color: var(--text-muted);
        max-width: 360px;
        margin: 0 auto;
    }

    /* ── MODALS ──────────────────────────────── */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 1000;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(2px);
    }

    .modal-overlay.active {
        display: flex;
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
        margin: 0;
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

    .form-select, .form-input, .form-textarea {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 13.5px;
        font-family: 'Inter', sans-serif;
        color: var(--text-primary);
        background: #fff;
        outline: none;
        transition: border-color var(--transition), box-shadow var(--transition);
    }

    .form-select:focus, .form-input:focus, .form-textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px var(--primary-glow);
    }

    @media (max-width: 768px) {
        .topbar {
            margin: 12px 16px 0 16px;
            padding: 0 16px;
        }

        .hamburger-btn {
            display: block;
        }

        .page-content {
            padding: 16px;
        }

        .user-details {
            display: none;
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

        <!-- TOPBAR WITH SMOOTH EDGES -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="hamburger-btn" id="hamburgerBtn" aria-label="Toggle menu">
                    <i class="ri-menu-line"></i>
                </button>

                <div class="topbar-title">
                    <h2>Pemeliharaan Equipment</h2>
                    <p>Monitoring dan manajemen perbaikan equipment workshop</p>
                </div>
            </div>

            <div class="topbar-right">
                <a href="{{ route('notifikasi.index') }}" class="notif-btn" aria-label="Notifikasi">
                    <i class="ri-notification-3-line"></i>
                </a>

                <div class="user-info">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="user-details">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-role">Administrator</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="page-content">

            <!-- FLASH ALERTS -->
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
                    <h1>Daftar Pemeliharaan</h1>
                    <p>Equipment yang sedang dalam tahap pemeriksaan atau perbaikan.</p>
                </div>
                <button class="btn-primary" onclick="openMasukModal()">
                    <i class="ri-tools-line"></i> Masukkan ke Perbaikan
                </button>
            </div>

            <!-- SUMMARY STATS -->
            <div class="summary-grid">
                <div class="summary-card">
                    <div class="summary-icon warning">
                        <i class="ri-tools-fill"></i>
                    </div>
                    <div>
                        <div class="summary-label">Sedang Diperbaiki</div>
                        <div class="summary-value">{{ $totalMaintenance }}</div>
                    </div>
                </div>

                <div class="summary-card">
                    <div class="summary-icon success">
                        <i class="ri-checkbox-circle-fill"></i>
                    </div>
                    <div>
                        <div class="summary-label">Siap Digunakan</div>
                        <div class="summary-value">{{ $allEquipment->count() }}</div>
                    </div>
                </div>
            </div>

            <!-- TABLE -->
            <div class="table-card">
                <div class="table-header">
                    <h3 class="section-title">Equipment dalam Perbaikan</h3>
                    <span class="table-info">{{ $totalMaintenance }} equipment</span>
                </div>

                <div class="table-wrapper">
                    @if($maintenanceEquipment->count() > 0)
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode RFID</th>
                                <th>Nama Equipment</th>
                                <th>Kategori</th>
                                <th>Terakhir Update</th>
                                <th>Status</th>
                                <th style="text-align: right;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maintenanceEquipment as $idx => $eq)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td>
                                    <span class="equipment-code">{{ $eq->rfid_uid }}</span>
                                </td>
                                <td>
                                    <span class="equipment-name">{{ $eq->name }}</span>
                                </td>
                                <td>{{ $eq->category ?? '-' }}</td>
                                <td>{{ $eq->updated_at->diffForHumans() }}</td>
                                <td>
                                    <span class="badge badge-repair">
                                        <i class="ri-error-warning-fill"></i> Diperbaiki
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <form action="{{ route('pemeliharaan.selesai', $eq->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Tandai equipment \"{{ $eq->name }}\" sudah selesai diperbaiki dan siap digunakan kembali?')">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn-success">
                                            <i class="ri-check-line"></i> Selesai Perbaikan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="ri-shield-check-line"></i>
                        </div>
                        <h3>Tidak Ada Equipment dalam Perbaikan</h3>
                        <p>Semua equipment workshop saat ini dalam kondisi siap kerja atau sedang digunakan.</p>
                    </div>
                    @endif
                </div>
            </div>

        </main>
    </div>

</div>

<!-- MODAL MASUKKAN KE PERBAIKAN -->
<div class="modal-overlay" id="masukModal">
    <div class="modal-box">
        <div class="modal-header">
            <h3>Tandai Equipment untuk Perbaikan</h3>
            <button class="modal-close" onclick="closeMasukModal()">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <form action="{{ route('pemeliharaan.masuk') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Pilih Equipment <span class="required">*</span></label>
                    <select name="equipment_id" class="form-select" required>
                        <option value="" disabled selected>Pilih alat yang rusak/perlu perawatan</option>
                        @foreach($allEquipment as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }} ({{ $item->category }}) - [{{ $item->rfid_uid }}]
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeMasukModal()">Batal</button>
                <button type="submit" class="btn-primary">
                    <i class="ri-tools-line"></i> Masukkan ke Perbaikan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Sidebar toggle (mobile)
    const hamburgerBtn   = document.getElementById('hamburgerBtn');
    const sidebar        = document.getElementById('sidebar');
    const sidebarClose   = document.getElementById('sidebarClose');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        sidebar?.classList.add('open');
        sidebarOverlay?.classList.add('open');
    }
    function closeSidebar() {
        sidebar?.classList.remove('open');
        sidebarOverlay?.classList.remove('open');
    }

    hamburgerBtn?.addEventListener('click', openSidebar);
    sidebarClose?.addEventListener('click', closeSidebar);
    sidebarOverlay?.addEventListener('click', closeSidebar);

    // Modal Masuk Perbaikan
    function openMasukModal() {
        document.getElementById('masukModal').classList.add('active');
    }
    function closeMasukModal() {
        document.getElementById('masukModal').classList.remove('active');
    }

    document.querySelectorAll('.modal-overlay').forEach(function(overlay) {
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                overlay.classList.remove('active');
            }
        });
    });

    // Auto dismiss flash
    setTimeout(function() {
        const s = document.getElementById('alertSuccess');
        if (s) s.style.display = 'none';
        const e = document.getElementById('alertError');
        if (e) e.style.display = 'none';
    }, 5000);
</script>
@endsection


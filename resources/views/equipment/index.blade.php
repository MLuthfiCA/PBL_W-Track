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

            <!-- PAGE HEADER -->
            <div class="page-header">
                <div>
                    <h1>Daftar Equipment</h1>
                    <p>Data equipment yang terdaftar pada sistem W-Track.</p>
                </div>
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
                                <th>Kode Equipment</th>
                                <th>Nama Equipment</th>
                                <th>Lokasi</th>
                                <th>Status</th>
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
                                        {{ $eq->kode_equipment }}
                                    </span>
                                </td>

                                <td>
                                    <span class="equipment-name">
                                        {{ $eq->nama_equipment }}
                                    </span>
                                </td>

                                <td>
                                    {{ $eq->lokasi ?? '-' }}
                                </td>

                                <td>

                                    @if($eq->status === 'keluar')

                                        <span class="badge badge-out">
                                            Keluar
                                        </span>

                                    @else

                                        <span class="badge badge-workshop">
                                            Di Workshop
                                        </span>

                                    @endif

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
@endsection

@section('scripts')
<script>
    // Sidebar toggle pada perangkat mobile
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const sidebar = document.getElementById('sidebar');
    const sidebarClose = document.getElementById('sidebarClose');
    const overlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        sidebar?.classList.add('open');
        overlay?.classList.add('open');
    }

    function closeSidebar() {
        sidebar?.classList.remove('open');
        overlay?.classList.remove('open');
    }

    hamburgerBtn?.addEventListener('click', openSidebar);
    sidebarClose?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);
</script>
@endsection

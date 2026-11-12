@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<style>
    /* ── LAYOUT ──────────────────────────────── */
    body {
        background: #f0f4f8;
        display: flex;
    }

    .app-wrapper {
        display: flex;
        width: 100%;
        min-height: 100vh;
    }

    /* ── SIDEBAR ─────────────────────────────── */
    .sidebar {
        width: 220px;
        min-height: 100vh;
        background: var(--sidebar-bg);
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 100;
        transition: transform var(--transition);
        overflow: hidden;
    }

    .sidebar::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--primary-dark));
    }

    .sidebar-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 22px 20px 20px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        flex-shrink: 0;
    }

    .logo-icon-sm {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        color: #fff;
        flex-shrink: 0;
        box-shadow: 0 2px 8px var(--primary-glow);
    }

    .sidebar-logo .logo-text {
        font-size: 16px;
        font-weight: 700;
        color: #fff;
        flex: 1;
    }

    .sidebar-close {
        display: none;
        background: none;
        border: none;
        color: rgba(255,255,255,0.5);
        font-size: 20px;
        cursor: pointer;
        padding: 4px;
    }

    /* Nav */
    .sidebar-nav {
        flex: 1;
        padding: 14px 12px;
        overflow-y: auto;
    }

    .sidebar-nav::-webkit-scrollbar { width: 4px; }
    .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
    .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

    .nav-list {
        list-style: none;
        margin-bottom: 6px;
    }

    .nav-section-label {
        font-size: 10px;
        font-weight: 600;
        color: rgba(255,255,255,0.25);
        letter-spacing: 1.2px;
        padding: 14px 8px 6px;
    }

    .nav-item {
        margin-bottom: 2px;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: var(--radius-sm);
        color: rgba(255,255,255,0.55);
        text-decoration: none;
        font-size: 13.5px;
        font-weight: 500;
        transition: all var(--transition);
        background: none;
        border: none;
        width: 100%;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
    }

    .nav-link:hover {
        background: rgba(255,255,255,0.07);
        color: rgba(255,255,255,0.9);
    }

    .nav-item.active .nav-link {
        background: linear-gradient(90deg, rgba(0,188,212,0.18), rgba(0,188,212,0.05));
        color: var(--primary);
        font-weight: 600;
        position: relative;
    }

    .nav-item.active .nav-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 20%;
        bottom: 20%;
        width: 3px;
        background: var(--primary);
        border-radius: 0 3px 3px 0;
        margin-left: -12px;
    }

    .nav-icon {
        font-size: 18px;
        flex-shrink: 0;
    }

    .nav-logout {
        color: rgba(255,100,100,0.65);
    }

    .nav-logout:hover {
        background: rgba(239,68,68,0.1);
        color: #FC8181;
    }

    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 99;
        backdrop-filter: blur(2px);
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
        box-shadow: 0 4px 12px var(--primary-glow);
    }

    .notif-badge {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 8px;
        height: 8px;
        background: #EF4444;
        border-radius: 50%;
        border: 1.5px solid #fff;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 6px 12px;
        background: #f8fafc;
        border: 1px solid var(--border);
        border-radius: 10px;
        cursor: pointer;
        transition: all var(--transition);
    }

    .user-info:hover {
        border-color: var(--primary);
        background: #fff;
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
        flex-shrink: 0;
    }

    .user-details {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-size: 13px;
        font-weight: 600;
        color: var(--text-primary);
        line-height: 1;
    }

    .user-role {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    /* ── PAGE CONTENT ────────────────────────── */
    .page-content {
        padding: 24px 28px;
        flex: 1;
    }

    /* ── STAT CARDS ──────────────────────────── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    .stat-card {
        background: #fff;
        border-radius: var(--radius);
        padding: 20px 22px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
        display: flex;
        flex-direction: column;
        gap: 12px;
        transition: all var(--transition);
        position: relative;
        overflow: hidden;
    }

    .stat-card::after {
        content: '';
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity var(--transition);
        background: linear-gradient(135deg, rgba(0,188,212,0.03), transparent);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        border-color: rgba(0,188,212,0.3);
    }

    .stat-card:hover::after { opacity: 1; }

    .stat-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .stat-label {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 500;
        letter-spacing: 0.2px;
    }

    .stat-icon {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
    }

    .stat-icon.total   { background: #EFF6FF; color: #3B82F6; }
    .stat-icon.used    { background: #FEF2F2; color: #EF4444; } /* Merah - Dipinjam */
    .stat-icon.repair  { background: #FFFBEB; color: #F59E0B; } /* Orange - Perbaikan */
    .stat-icon.avail   { background: #F0FDF4; color: #10B981; } /* Hijau - Tersedia */

    .stat-value {
        font-size: 32px;
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1;
        letter-spacing: -1px;
    }

    .stat-sub {
        font-size: 11.5px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .stat-sub.warning { color: #F59E0B; }
    .stat-sub.success { color: #10B981; }

    /* ── BOTTOM GRID ─────────────────────────── */
    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }

    /* ── STATUS CARD ─────────────────────────── */
    .section-card {
        background: #fff;
        border-radius: var(--radius);
        padding: 22px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-sm);
    }

    .section-title {
        font-size: 15px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 20px;
    }

    /* Donut chart */
    .status-chart-wrapper {
        display: flex;
        align-items: center;
        gap: 28px;
    }

    .donut-container {
        position: relative;
        width: 140px;
        height: 140px;
        flex-shrink: 0;
    }

    .donut-svg {
        width: 140px;
        height: 140px;
        transform: rotate(-90deg);
        overflow: visible;
    }

    .donut-track {
        fill: none;
        stroke: #f1f5f9;
        stroke-width: 16;
    }

    .donut-circle {
        fill: none;
        stroke-width: 16;
        stroke-dasharray: 0 251.2;
        stroke-dashoffset: 0;
        transition: stroke-dasharray 1.3s cubic-bezier(0.4, 0, 0.2, 1), stroke-dashoffset 1.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Warna sesuai permintaan user: Hijau = Available, Orange = Diperbaiki, Merah = Dipinjam */
    .donut-avail {
        stroke: #10B981; /* Hijau */
    }

    .donut-repair {
        stroke: #F59E0B; /* Orange */
    }

    .donut-borrowed {
        stroke: #EF4444; /* Merah */
    }

    .donut-center {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        pointer-events: none;
    }

    .donut-pct {
        font-size: 22px;
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1;
    }

    .donut-desc {
        font-size: 11px;
        font-weight: 600;
        color: var(--text-muted);
        margin-top: 3px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-legend {
        display: flex;
        flex-direction: column;
        gap: 12px;
        flex: 1;
    }

    .legend-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13px;
    }

    .legend-dot-label {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 4px;
        flex-shrink: 0;
    }

    /* Legenda 3 Warna */
    .dot-avail  { background: #10B981; } /* Hijau */
    .dot-repair { background: #F59E0B; } /* Orange */
    .dot-borrow { background: #EF4444; } /* Merah */

    .legend-val {
        font-weight: 700;
        color: var(--text-primary);
        font-size: 14px;
    }

    /* ── ACTIVITY CARD ───────────────────────── */
    .activity-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
    }

    .activity-header .section-title { margin-bottom: 0; }

    .link-all {
        font-size: 12.5px;
        font-weight: 500;
        color: var(--primary-dark);
        text-decoration: none;
        transition: color var(--transition);
    }

    .link-all:hover {
        color: var(--primary);
        text-decoration: underline;
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 8px 10px;
        border-radius: 10px;
        transition: background var(--transition);
    }

    .activity-item:hover {
        background: #f8fafc;
    }

    .activity-icon-badge {
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
    }

    .activity-title {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text-primary);
        line-height: 1.3;
    }

    .activity-text {
        font-size: 12.5px;
        color: var(--text-secondary);
        margin-top: 2px;
        line-height: 1.4;
    }

    .activity-time {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ── EQUIPMENT TABLE ─────────────────────── */
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

    .table-header .section-title { margin-bottom: 0; }

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
    }

    .data-table td {
        padding: 13px 22px;
        font-size: 13.5px;
        color: var(--text-primary);
        border-bottom: 1px solid #f5f7fa;
        vertical-align: middle;
    }

    .data-table tbody tr:last-child td { border-bottom: none; }

    .data-table tbody tr {
        transition: background var(--transition);
    }

    .data-table tbody tr:hover {
        background: #fafcff;
    }

    .equipment-name {
        font-weight: 600;
        color: var(--text-primary);
    }

    .equipment-code {
        font-family: 'Courier New', monospace;
        font-size: 12.5px;
        color: var(--text-secondary);
    }

    /* Status badges */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: 0.2px;
    }

    .badge-used    { background: #FFFBEB; color: #D97706; }
    .badge-avail   { background: #F0FDF4; color: #059669; }
    .badge-repair  { background: #FEF2F2; color: #DC2626; }

    /* ── RESPONSIVE ──────────────────────────── */
    @media (max-width: 1200px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 900px) {
        .bottom-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .sidebar-overlay.open {
            display: block;
        }

        .sidebar-close {
            display: block;
        }

        .main-content {
            margin-left: 0;
        }

        .hamburger-btn {
            display: block;
        }

        .page-content {
            padding: 16px;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .topbar {
            margin: 12px 16px 0 16px;
            padding: 0 16px;
            border-radius: 12px;
        }

        .user-details {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
        .status-chart-wrapper { flex-direction: column; }
    }

    /* ── ANIMATIONS ──────────────────────────── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(14px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .stat-card {
        animation: fadeUp 0.5s ease both;
    }

    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.10s; }
    .stat-card:nth-child(3) { animation-delay: 0.15s; }
    .stat-card:nth-child(4) { animation-delay: 0.20s; }

    .section-card, .table-card {
        animation: fadeUp 0.5s ease 0.25s both;
    }
</style>
@endsection

@section('content')
<div class="app-wrapper">

    <!-- SIDEBAR -->
    @include('partials.sidebar')

    <!-- MAIN -->
    <div class="main-content">

        <!-- TOPBAR -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="hamburger-btn" id="hamburgerBtn" aria-label="Toggle menu">
                    <i class="ri-menu-line"></i>
                </button>
                <div class="topbar-title">
                    <h2>Dashboard</h2>
                    <p>Ringkasan operasional equipment</p>
                </div>
            </div>

            <div class="topbar-right">
                <a href="{{ route('notifikasi.index') }}" class="notif-btn" id="notifBtn" aria-label="Notifikasi">
                    <i class="ri-notification-3-line"></i>
                    <span class="notif-badge"></span>
                </a>

                <div class="user-info" id="userMenu">
                    <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                    <div class="user-details">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-role">Administrator</span>
                    </div>
                    <i class="ri-arrow-down-s-line" style="color: var(--text-muted); font-size: 16px;"></i>
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="page-content">

            <!-- ── STAT CARDS ───────────────────── -->
            <div class="stats-grid">
                <!-- Total Equipment -->
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Total Equipment</span>
                        <div class="stat-icon total"><i class="ri-archive-line"></i></div>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['total'] }}</div>
                        <div class="stat-sub">12 kategori</div>
                    </div>
                </div>

                <!-- Sedang Digunakan -->
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Sedang Digunakan</span>
                        <div class="stat-icon used"><i class="ri-pulse-line"></i></div>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['digunakan'] }}</div>
                        <div class="stat-sub">{{ $stats['total'] > 0 ? round(($stats['digunakan'] / $stats['total']) * 100) : 0 }}% dari total</div>
                    </div>
                </div>

                <!-- Dalam Perbaikan -->
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Dalam Perbaikan</span>
                        <div class="stat-icon repair"><i class="ri-tools-line"></i></div>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['perbaikan'] }}</div>
                        <div class="stat-sub warning">{{ $stats['perbaikan'] > 0 ? $stats['perbaikan'] . ' perlu perhatian' : 'Tidak ada perbaikan' }}</div>
                    </div>
                </div>

                <!-- Tersedia -->
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-label">Tersedia</span>
                        <div class="stat-icon avail"><i class="ri-checkbox-circle-line"></i></div>
                    </div>
                    <div>
                        <div class="stat-value">{{ $stats['tersedia'] }}</div>
                        <div class="stat-sub success">Siap digunakan</div>
                    </div>
                </div>
            </div>

            <!-- ── BOTTOM GRID ──────────────────── -->
            <div class="bottom-grid">

                <!-- Status Equipment (3 Warna: Hijau=Tersedia, Orange=Diperbaiki, Merah=Dipinjam) -->
                <div class="section-card">
                    <div class="section-title">Status Equipment</div>
                    <div class="status-chart-wrapper">
                        <div class="donut-container">
                            <svg class="donut-svg" viewBox="0 0 100 100">
                                <circle class="donut-track" cx="50" cy="50" r="40"/>
                                <!-- 1. Hijau: Tersedia -->
                                <circle id="donutAvail"
                                        class="donut-circle donut-avail"
                                        cx="50" cy="50" r="40"
                                        data-length="{{ $chart['avail_len'] }}"
                                        data-offset="{{ $chart['avail_offset'] }}"/>
                                <!-- 2. Orange: Diperbaiki -->
                                <circle id="donutRepair"
                                        class="donut-circle donut-repair"
                                        cx="50" cy="50" r="40"
                                        data-length="{{ $chart['repair_len'] }}"
                                        data-offset="{{ $chart['repair_offset'] }}"/>
                                <!-- 3. Merah: Dipinjam -->
                                <circle id="donutBorrowed"
                                        class="donut-circle donut-borrowed"
                                        cx="50" cy="50" r="40"
                                        data-length="{{ $chart['borrowed_len'] }}"
                                        data-offset="{{ $chart['borrowed_offset'] }}"/>
                            </svg>
                            <div class="donut-center">
                                <div class="donut-pct">{{ $chart['avail_pct'] }}%</div>
                                <div class="donut-desc">tersedia</div>
                            </div>
                        </div>

                        <div class="status-legend">
                            <!-- Tersedia (Hijau) -->
                            <div class="legend-item">
                                <div class="legend-dot-label">
                                    <div class="legend-dot dot-avail"></div>
                                    Tersedia
                                </div>
                                <span class="legend-val">{{ $stats['tersedia'] }}</span>
                            </div>
                            <!-- Diperbaiki (Orange) -->
                            <div class="legend-item">
                                <div class="legend-dot-label">
                                    <div class="legend-dot dot-repair"></div>
                                    Diperbaiki
                                </div>
                                <span class="legend-val">{{ $stats['perbaikan'] }}</span>
                            </div>
                            <!-- Dipinjam (Merah) -->
                            <div class="legend-item">
                                <div class="legend-dot-label">
                                    <div class="legend-dot dot-borrow"></div>
                                    Dipinjam
                                </div>
                                <span class="legend-val">{{ $stats['digunakan'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aktivitas Terbaru (3 Most Recent Aktivitas) -->
                <div class="section-card">
                    <div class="activity-header">
                        <div class="section-title">Aktivitas Terbaru</div>
                        <a href="{{ route('equipment.index') }}" class="link-all">Lihat equipment</a>
                    </div>

                    <div class="activity-list">
                        @forelse($aktivitas as $item)
                        <div class="activity-item">
                            <div class="activity-icon-badge" style="background: {{ $item['color'] }}15; color: {{ $item['color'] }};">
                                <i class="{{ $item['icon'] }}"></i>
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div class="activity-title">{{ $item['title'] }}</div>
                                <div class="activity-text">{{ $item['text'] }}</div>
                                <div class="activity-time">
                                    <i class="ri-time-line"></i> {{ $item['time'] }}
                                </div>
                            </div>
                        </div>
                        @empty
                        <p style="color:var(--text-muted); font-size:13px; text-align: center; padding: 20px;">Belum ada aktivitas terbaru.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- ── EQUIPMENT TABLE ──────────────── -->
            <div class="table-card">
                <div class="table-header">
                    <div class="section-title">Equipment Terbaru</div>
                    <a href="{{ route('equipment.index') }}" class="link-all">Lihat semua equipment</a>
                </div>

                <div style="overflow-x: auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Equipment</th>
                                <th>Kode</th>
                                <th>Lokasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($equipmentTerbaru as $eq)
                            @php
                                $badgeClass = match($eq['status']) {
                                    'Digunakan' => 'badge-used',
                                    'Perbaikan' => 'badge-repair',
                                    'Tersedia'  => 'badge-avail',
                                    default     => 'badge-avail',
                                };
                            @endphp
                            <tr>
                                <td><span class="equipment-name">{{ $eq['nama'] }}</span></td>
                                <td><span class="equipment-code">{{ $eq['kode'] }}</span></td>
                                <td>{{ $eq['lokasi'] }}</td>
                                <td><span class="badge {{ $badgeClass }}">{{ $eq['status'] }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" style="text-align:center; color:var(--text-muted); padding:28px;">Belum ada data equipment.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div><!-- /main-content -->

</div><!-- /app-wrapper -->
@endsection

@section('scripts')
<script>
    // Sidebar toggle (mobile)
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const sidebar      = document.getElementById('sidebar');
    const sidebarClose = document.getElementById('sidebarClose');
    const overlay      = document.getElementById('sidebarOverlay');

    function openSidebar()  { sidebar.classList.add('open'); overlay.classList.add('open'); }
    function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('open'); }

    hamburgerBtn?.addEventListener('click', openSidebar);
    sidebarClose?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);

    // Donut chart animation on load - membuat graph circle bergerak mulus dengan 3 warna
    function animateDonutChart() {
        const availCircle    = document.getElementById('donutAvail');
        const repairCircle   = document.getElementById('donutRepair');
        const borrowedCircle = document.getElementById('donutBorrowed');

        if (availCircle) {
            availCircle.style.strokeDasharray  = `${availCircle.dataset.length} 251.2`;
            availCircle.style.strokeDashoffset = availCircle.dataset.offset;
        }
        if (repairCircle) {
            repairCircle.style.strokeDasharray  = `${repairCircle.dataset.length} 251.2`;
            repairCircle.style.strokeDashoffset = repairCircle.dataset.offset;
        }
        if (borrowedCircle) {
            borrowedCircle.style.strokeDasharray  = `${borrowedCircle.dataset.length} 251.2`;
            borrowedCircle.style.strokeDashoffset = borrowedCircle.dataset.offset;
        }
    }

    if (document.readyState === 'complete') {
        setTimeout(animateDonutChart, 100);
    } else {
        window.addEventListener('load', () => setTimeout(animateDonutChart, 100));
    }
</script>
@endsection

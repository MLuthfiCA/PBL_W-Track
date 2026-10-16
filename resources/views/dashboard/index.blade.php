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
    .stat-icon.used    { background: #FFFBEB; color: var(--status-used); }
    .stat-icon.repair  { background: #FEF2F2; color: var(--status-repair); }
    .stat-icon.avail   { background: #F0FDF4; color: var(--status-available); }

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
        width: 130px;
        height: 130px;
        flex-shrink: 0;
    }

    .donut-svg {
        width: 130px;
        height: 130px;
        transform: rotate(-90deg);
    }

    .donut-track {
        fill: none;
        stroke: #f0f4f8;
        stroke-width: 18;
    }

    .donut-used {
        fill: none;
        stroke: var(--primary);
        stroke-width: 18;
        stroke-linecap: round;
        stroke-dasharray: 251.2;
        stroke-dashoffset: 75.36; /* 70% used → 251.2 * 0.30 offset = 75.36 */
        transition: stroke-dashoffset 1s ease;
    }

    .donut-avail {
        fill: none;
        stroke: #6EE7B7;
        stroke-width: 18;
        stroke-dasharray: 251.2;
        stroke-dashoffset: 226.08; /* 10% avail → offset = 251.2 * 0.90 */
        opacity: 0.8;
        transition: stroke-dashoffset 1s ease;
    }

    .donut-repair {
        fill: none;
        stroke: #FCA5A5;
        stroke-width: 18;
        stroke-dasharray: 251.2;
        stroke-dashoffset: 243.66; /* 3% repair */
        opacity: 0.8;
        transition: stroke-dashoffset 1s ease;
    }

    .donut-center {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
    }

    .donut-pct {
        font-size: 20px;
        font-weight: 800;
        color: var(--text-primary);
        line-height: 1;
    }

    .donut-desc {
        font-size: 10px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .status-legend {
        display: flex;
        flex-direction: column;
        gap: 10px;
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
        gap: 8px;
        color: var(--text-secondary);
    }

    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 3px;
        flex-shrink: 0;
    }

    .dot-used  { background: var(--primary); }
    .dot-avail { background: #6EE7B7; }
    .dot-repair{ background: #FCA5A5; }

    .legend-val {
        font-weight: 700;
        color: var(--text-primary);
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
        gap: 14px;
    }

    .activity-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .activity-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--primary);
        margin-top: 4px;
        flex-shrink: 0;
        box-shadow: 0 0 0 3px rgba(0,188,212,0.15);
    }

    .activity-text {
        font-size: 13.5px;
        color: var(--text-primary);
        font-weight: 500;
        line-height: 1.4;
    }

    .activity-time {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 2px;
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
            padding: 0 16px;
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
                        <div class="stat-sub warning">7 perlu perhatian</div>
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

                <!-- Status Equipment -->
                <div class="section-card">
                    <div class="section-title">Status Equipment</div>
                    <div class="status-chart-wrapper">
                        <div class="donut-container">
                            <svg class="donut-svg" viewBox="0 0 100 100">
                                <circle class="donut-track" cx="50" cy="50" r="40"/>
                                <circle class="donut-used"   cx="50" cy="50" r="40"/>
                                <circle class="donut-avail"  cx="50" cy="50" r="40"/>
                                <circle class="donut-repair" cx="50" cy="50" r="40"/>
                            </svg>
                            <div class="donut-center">
                                <div class="donut-pct">71%</div>
                                <div class="donut-desc">digunakan</div>
                            </div>
                        </div>

                        <div class="status-legend">
                            <div class="legend-item">
                                <div class="legend-dot-label">
                                    <div class="legend-dot dot-used"></div>
                                    Digunakan
                                </div>
                                <span class="legend-val">{{ $stats['digunakan'] }}</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-dot-label">
                                    <div class="legend-dot dot-avail"></div>
                                    Tersedia
                                </div>
                                <span class="legend-val">{{ $stats['tersedia'] }}</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-dot-label">
                                    <div class="legend-dot dot-repair"></div>
                                    Perbaikan
                                </div>
                                <span class="legend-val">{{ $stats['perbaikan'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aktivitas Terbaru -->
                <div class="section-card">
                    <div class="activity-header">
                        <div class="section-title">Aktivitas Terbaru</div>
                        <a href="{{ route('laporan.index') }}" class="link-all">Lihat semua</a>
                    </div>

                    <div class="activity-list">
                        @forelse($aktivitas as $item)
                        <div class="activity-item">
                            <div class="activity-dot"></div>
                            <div>
                                <div class="activity-text">{{ $item['text'] }}</div>
                                <div class="activity-time">{{ $item['time'] }}</div>
                            </div>
                        </div>
                        @empty
                        <p style="color:var(--text-muted); font-size:13px;">Belum ada aktivitas terbaru.</p>
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

    // Donut chart animation on load
    window.addEventListener('load', () => {
        const circles = document.querySelectorAll('.donut-used, .donut-avail, .donut-repair');
        circles.forEach(c => {
            const offset = parseFloat(c.style.strokeDashoffset || c.getAttribute('stroke-dashoffset') || getComputedStyle(c).strokeDashoffset);
        });
    });
</script>
@endsection

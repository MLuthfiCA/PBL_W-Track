@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Monitoring keluar-masuk equipment workshop')

@section('styles')
<style>
    /* ── STATISTIC CARDS (3 KOLOM DESKTOP) ─────────────── */
    .dash-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-subtle);
        border-radius: var(--radius-card);
        padding: 20px;
        box-shadow: var(--shadow-card);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        text-decoration: none;
        color: inherit;
        transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(32, 37, 53, 0.08);
        border-color: #CBD5E1;
    }

    .stat-title {
        font-size: 14px;
        font-weight: 500;
        color: var(--text-main);
        margin-bottom: 8px;
    }

    .stat-number {
        font-size: 30px;
        font-weight: 700;
        line-height: 1.15;
        margin-bottom: 6px;
    }

    .stat-number.primary { color: var(--text-main); }
    .stat-number.success { color: var(--success); }
    .stat-number.warning { color: var(--warning); }

    .stat-caption {
        font-size: 12px;
        color: var(--text-neutral);
    }

    .stat-icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .stat-icon-box.primary { background: var(--primary-light); color: var(--primary); }
    .stat-icon-box.success { background: var(--success-bg); color: var(--success); }
    .stat-icon-box.warning { background: var(--warning-bg); color: var(--warning); }

    /* ── MAIN DASHBOARD GRID (KIRI TABEL, KANAN IOT & NOTIF) */
    .dash-main-grid {
        display: grid;
        grid-template-columns: 1.65fr 1fr;
        gap: 20px;
        align-items: start;
    }

    .card-header-flex {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 16px;
        gap: 12px;
    }

    .card-heading {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-main);
    }

    .card-action-link {
        font-size: 13px;
        font-weight: 500;
        color: var(--primary);
        text-decoration: none;
    }

    .card-action-link:hover {
        text-decoration: underline;
    }

    /* ── ACTIVITY TABLE (ROW 54px) ─────────────────────── */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .wt-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 520px;
    }

    .wt-table th {
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-secondary);
        padding: 12px 14px;
        border-bottom: 1px solid var(--border-subtle);
        background: #FAFBFD;
        white-space: nowrap;
    }

    .wt-table td {
        height: 54px;
        padding: 10px 14px;
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

    /* ── RIGHT COLUMN PANELS ───────────────────────────── */
    .dash-right-stack {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .iot-device-item {
        border: 1px solid var(--border-subtle);
        border-radius: 10px;
        padding: 14px;
        background: #FFFFFF;
    }

    .iot-device-item + .iot-device-item {
        margin-top: 12px;
    }

    .iot-device-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }

    .iot-device-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .iot-icon-circle {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .iot-icon-circle.offline { background: var(--danger-bg); color: var(--danger); }
    .iot-icon-circle.online  { background: var(--success-bg); color: var(--success); }

    .iot-device-name {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-main);
    }

    .iot-device-loc {
        font-size: 12px;
        color: var(--text-secondary);
    }

    .iot-last-seen {
        font-size: 12px;
        color: var(--text-neutral);
        margin-top: 8px;
    }

    .iot-alert-box {
        margin-top: 10px;
        padding: 8px 10px;
        border-radius: 6px;
        background: var(--danger-bg);
        color: #B3261E;
        font-size: 12px;
        line-height: 1.4;
    }

    /* ── NOTIFICATION LIST ─────────────────────────────── */
    .notif-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .notif-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border-color);
    }

    .notif-item:last-child {
        padding-bottom: 0;
        border-bottom: none;
    }

    .notif-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
    }

    .notif-icon.success { background: var(--success-bg); color: var(--success); }
    .notif-icon.warning { background: var(--warning-bg); color: var(--warning); }
    .notif-icon.danger  { background: var(--danger-bg);  color: var(--danger); }

    .notif-msg {
        font-size: 13px;
        color: var(--text-main);
        line-height: 1.4;
    }

    .notif-time {
        font-size: 12px;
        color: var(--text-neutral);
        margin-top: 2px;
    }

    /* ── EMPTY STATE ───────────────────────────────────── */
    .empty-state-box {
        text-align: center;
        padding: 36px 16px;
    }

    .empty-state-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: var(--primary-light);
        color: var(--primary);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
    }

    /* ── RESPONSIVE BREAKPOINTS (Design Handoff Sec 10) */
    @media (max-width: 1024px) {
        .dash-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .dash-main-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .dash-stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
    <!-- 1. STATISTIC CARDS -->
    <section class="dash-stats-grid" aria-label="Ringkasan Statistik Equipment">
        <a href="{{ route('equipment.index') }}" class="stat-card">
            <div>
                <div class="stat-title">Total Equipment</div>
                <div class="stat-number primary">{{ $stats['total'] }}</div>
                <div class="stat-caption">Total equipment terdaftar</div>
            </div>
            <div class="stat-icon-box primary">
                <i data-lucide="package" style="width:20px;height:20px;"></i>
            </div>
        </a>

        <a href="{{ route('equipment.index', ['status' => 'available']) }}" class="stat-card">
            <div>
                <div class="stat-title">Di Workshop</div>
                <div class="stat-number success">{{ $stats['di_workshop'] }}</div>
                <div class="stat-caption">Equipment berada di workshop</div>
            </div>
            <div class="stat-icon-box success">
                <i data-lucide="check-circle-2" style="width:20px;height:20px;"></i>
            </div>
        </a>

        <a href="{{ route('equipment.index', ['status' => 'borrowed']) }}" class="stat-card">
            <div>
                <div class="stat-title">Di Luar Workshop</div>
                <div class="stat-number warning">{{ $stats['di_luar'] }}</div>
                <div class="stat-caption">Equipment berada di luar workshop</div>
            </div>
            <div class="stat-icon-box warning">
                <i data-lucide="arrow-up-right" style="width:20px;height:20px;"></i>
            </div>
        </a>
    </section>

    <!-- 2. MAIN CONTENT GRID -->
    <div class="dash-main-grid">
        <!-- KOLOM KIRI: AKTIVITAS EQUIPMENT TERBARU -->
        <section class="wt-card">
            <div class="card-header-flex">
                <h2 class="card-heading">Aktivitas Equipment Terbaru</h2>
                <a href="{{ route('riwayat.index') }}" class="card-action-link">Lihat Semua</a>
            </div>

            @if($aktivitasTerbaru->count() > 0)
                <div class="table-responsive">
                    <table class="wt-table">
                        <thead>
                            <tr>
                                <th>Nama Equipment</th>
                                <th>Kode Equipment</th>
                                <th>Pergerakan</th>
                                <th>Waktu</th>
                                <th>Pengguna</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($aktivitasTerbaru as $item)
                                <tr>
                                    <td style="font-weight: 500;">{{ $item['nama'] }}</td>
                                    <td><span class="font-mono">{{ $item['kode'] }}</span></td>
                                    <td>
                                        @if($item['type'] === 'in')
                                            <span class="badge badge-success">
                                                <i data-lucide="arrow-down-left" style="width:13px;height:13px;"></i>
                                                Masuk
                                            </span>
                                        @else
                                            <span class="badge badge-warning">
                                                <i data-lucide="arrow-up-right" style="width:13px;height:13px;"></i>
                                                Keluar
                                            </span>
                                        @endif
                                    </td>
                                    <td style="color: var(--text-secondary); white-space: nowrap;">{{ $item['waktu'] }}</td>
                                    <td style="color: var(--text-secondary);">{{ $item['pengguna'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state-box">
                    <div class="empty-state-icon">
                        <i data-lucide="history" style="width:22px;height:22px;"></i>
                    </div>
                    <p style="font-weight:600; color:var(--text-main); margin-bottom:4px;">Belum ada riwayat transaksi equipment.</p>
                    <p style="font-size:13px; color:var(--text-secondary);">Aktivitas keluar-masuk akan muncul secara otomatis setelah ada transaksi tercatat.</p>
                </div>
            @endif
        </section>

        <!-- KOLOM KANAN: STATUS PERANGKAT IOT & NOTIFIKASI TERBARU -->
        <div class="dash-right-stack">
            <!-- Status Perangkat IoT -->
            <section class="wt-card">
                <div class="card-header-flex">
                    <h2 class="card-heading">Status Perangkat IoT</h2>
                    <a href="{{ route('monitoring-iot.index') }}" class="card-action-link">Monitoring IoT</a>
                </div>

                @foreach($iotDevices as $device)
                    <div class="iot-device-item">
                        <div class="iot-device-top">
                            <div class="iot-device-info">
                                <div class="iot-icon-circle {{ $device['status'] }}">
                                    <i data-lucide="radio-tower" style="width:18px;height:18px;"></i>
                                </div>
                                <div>
                                    <div class="iot-device-name">{{ $device['name'] }}</div>
                                    <div class="iot-device-loc">{{ $device['location'] }}</div>
                                </div>
                            </div>

                            @if($device['status'] === 'online')
                                <span class="badge badge-success">
                                    <i data-lucide="check-circle-2" style="width:13px;height:13px;"></i>
                                    Online
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i data-lucide="x-circle" style="width:13px;height:13px;"></i>
                                    Offline
                                </span>
                            @endif
                        </div>

                        <div class="iot-last-seen">
                            Terakhir terhubung: {{ $device['last_seen'] }}
                        </div>

                        @if($device['status'] !== 'online')
                            <div class="iot-alert-box">
                                {{ $device['message'] }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </section>

            <!-- Notifikasi Terbaru -->
            <section class="wt-card">
                <div class="card-header-flex">
                    <h2 class="card-heading">Notifikasi Terbaru</h2>
                </div>

                <div class="notif-list">
                    @foreach($notifikasi as $notif)
                        <div class="notif-item">
                            <div class="notif-icon {{ $notif['type'] }}">
                                @if($notif['type'] === 'success')
                                    <i data-lucide="arrow-down-left" style="width:14px;height:14px;"></i>
                                @elseif($notif['type'] === 'warning')
                                    <i data-lucide="arrow-up-right" style="width:14px;height:14px;"></i>
                                @else
                                    <i data-lucide="alert-circle" style="width:14px;height:14px;"></i>
                                @endif
                            </div>
                            <div>
                                <div class="notif-msg">{{ $notif['message'] }}</div>
                                <div class="notif-time">{{ $notif['time'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
@endsection
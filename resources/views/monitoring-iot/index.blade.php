@extends('layouts.app')

@section('title', 'Monitoring IoT')
@section('page-title', 'Monitoring IoT')
@section('page-subtitle', 'Pemantauan status koneksi perangkat RFID Reader dan alur komunikasi')

@section('styles')
<style>
    .iot-devices-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }

    .device-card-head {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 14px;
    }

    .device-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .device-icon-lg {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background: var(--danger-bg);
        color: var(--danger);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .device-spec-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding: 12px 0;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
        font-size: 13px;
    }

    .spec-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
    }

    .spec-label { color: var(--text-secondary); }
    .spec-val   { font-weight: 500; color: var(--text-main); text-align: right; }

    .device-warning-banner {
        margin-top: 14px;
        padding: 10px 12px;
        border-radius: 8px;
        background: var(--danger-bg);
        color: #B3261E;
        font-size: 12.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Component States Guide (Design Handoff Sec 4 & 6) */
    .states-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-top: 14px;
    }

    .state-box {
        border: 1px solid var(--border-subtle);
        border-radius: 10px;
        padding: 14px;
        background: #FAFBFD;
    }

    .state-box-title {
        font-size: 13px;
        font-weight: 700;
        margin-top: 8px;
        margin-bottom: 4px;
        color: var(--text-main);
    }

    .state-box-desc {
        font-size: 12px;
        color: var(--text-secondary);
        line-height: 1.45;
    }

    @media (max-width: 1024px) {
        .iot-devices-grid { grid-template-columns: 1fr; }
        .states-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 600px) {
        .states-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
    <!-- KARTU STATUS PERANGKAT RFID -->
    <section class="iot-devices-grid" aria-label="Daftar Perangkat RFID">
        @foreach($devices as $device)
            <div class="wt-card">
                <div class="device-card-head">
                    <div class="device-title-wrap">
                        <div class="device-icon-lg">
                            <i data-lucide="radio-tower" style="width:22px;height:22px;"></i>
                        </div>
                        <div>
                            <div style="font-size:16px;font-weight:700;color:var(--text-main);">{{ $device['name'] }}</div>
                            <div style="font-size:13px;color:var(--text-secondary);">{{ $device['location'] }}</div>
                        </div>
                    </div>

                    <span class="badge badge-danger">
                        <i data-lucide="x-circle" style="width:13px;height:13px;"></i>
                        Offline
                    </span>
                </div>

                <div class="device-spec-list">
                    <div class="spec-row">
                        <span class="spec-label">ID Perangkat</span>
                        <span class="spec-val font-mono">{{ $device['id'] }}</span>
                    </div>
                    <div class="spec-row">
                        <span class="spec-label">Spesifikasi Hardware</span>
                        <span class="spec-val">{{ $device['board'] }}</span>
                    </div>
                    <div class="spec-row">
                        <span class="spec-label">Endpoint Backend</span>
                        <span class="spec-val font-mono">{{ $device['endpoint'] }}</span>
                    </div>
                    <div class="spec-row">
                        <span class="spec-label">Terakhir Terhubung</span>
                        <span class="spec-val">{{ $device['last_seen'] }}</span>
                    </div>
                </div>

                <div class="device-warning-banner">
                    <i data-lucide="alert-triangle" style="width:16px;height:16px;flex-shrink:0;"></i>
                    <span>{{ $device['message'] }}</span>
                </div>
            </div>
        @endforeach
    </section>

    <!-- PANDUAN KONDISI & FAIL-SAFE PERANGKAT (Design Handoff Sec 4 & 6) -->
    <section class="wt-card">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
            <div>
                <h2 style="font-size:16px;font-weight:700;color:var(--text-main);">Penanganan Koneksi Terputus (Fail-safe) & Status Pembacaan</h2>
                <p style="font-size:13px;color:var(--text-secondary);margin-top:2px;">
                    Acuan perilaku sistem ketika perangkat keras ESP32 & RFID Reader RC522 diintegrasikan dengan W-Track.
                </p>
            </div>
            <a href="{{ route('transaksi.index') }}" class="wt-btn wt-btn-outline">
                <i data-lucide="arrow-left-right" style="width:16px;height:16px;"></i>
                <span>Buka Simulasi Transaksi</span>
            </a>
        </div>

        <div class="states-grid">
            <div class="state-box">
                <span class="badge badge-danger">1. Koneksi Terputus</span>
                <div class="state-box-title">Status Offline</div>
                <p class="state-box-desc">Jika mikrokontroler ESP32 belum terhubung Wi-Fi atau server, status perangkat ditampilkan Offline.</p>
            </div>

            <div class="state-box">
                <span class="badge badge-neutral">2. Fail-safe Aktif</span>
                <div class="state-box-title">Transaksi Tidak Diproses</div>
                <p class="state-box-desc">Data pembacaan yang gagal terkirim tidak akan disimpan sebagai transaksi parsial atau ganda.</p>
            </div>

            <div class="state-box">
                <span class="badge badge-warning">3. Validasi UID</span>
                <div class="state-box-title">Pencocokan Master Data</div>
                <p class="state-box-desc">UID Tag wajib cocok dengan tabel <code>equipments</code>; tag asing otomatis ditolak oleh API.</p>
            </div>

            <div class="state-box">
                <span class="badge badge-success">4. Siap Integrasi</span>
                <div class="state-box-title">Pembaruan Otomatis</div>
                <p class="state-box-desc">Saat perangkat terhubung, setiap tap valid langsung memperbarui status Di Workshop / Di Luar Workshop.</p>
            </div>
        </div>
    </section>
@endsection

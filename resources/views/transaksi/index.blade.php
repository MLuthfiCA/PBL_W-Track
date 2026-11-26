@extends('layouts.app')

@section('title', 'Transaksi')
@section('page-title', 'Transaksi')
@section('page-subtitle', 'Pencatatan dan simulasi validasi pergerakan equipment keluar-masuk')

@section('styles')
<style>
    .trx-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        align-items: start;
        margin-bottom: 24px;
    }

    .card-heading {
        font-size: 16px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 4px;
    }

    .card-desc {
        font-size: 13px;
        color: var(--text-secondary);
        margin-bottom: 18px;
    }

    .form-stack {
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

    .rules-box {
        margin-top: 16px;
        padding: 12px 14px;
        border-radius: 8px;
        background: #F8FAFC;
        border: 1px solid var(--border-subtle);
        font-size: 12px;
        color: var(--text-secondary);
    }

    .rules-box strong {
        display: block;
        color: var(--text-main);
        margin-bottom: 4px;
    }

    .rules-box ul {
        margin-left: 16px;
        line-height: 1.6;
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

    .alert-success { background: var(--success-bg); color: #1B6E3E; border: 1px solid #BBF7D0; }
    .alert-danger  { background: var(--danger-bg);  color: #B3261E; border: 1px solid #FECACA; }

    /* Panel Hasil Validasi RFID */
    .rfid-result-box {
        margin-top: 14px;
        padding: 14px;
        border-radius: 10px;
        border: 1px solid var(--border-subtle);
        background: #FAFBFD;
    }

    .rfid-result-box.valid   { background: var(--success-bg); border-color: #BBF7D0; color: #1B6E3E; }
    .rfid-result-box.invalid { background: var(--danger-bg);  border-color: #FECACA; color: #B3261E; }
    .rfid-result-box.warning { background: var(--warning-bg); border-color: #FDE68A; color: #9A5A00; }

    .rfid-btn-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    /* Tabel Transaksi Terbaru */
    .table-responsive { width: 100%; overflow-x: auto; }
    .wt-table { width: 100%; border-collapse: collapse; min-width: 520px; }
    .wt-table th {
        text-align: left;
        font-size: 12px;
        font-weight: 600;
        color: var(--text-secondary);
        padding: 12px 14px;
        border-bottom: 1px solid var(--border-subtle);
        background: #FAFBFD;
    }
    .wt-table td {
        height: 54px;
        padding: 10px 14px;
        font-size: 14px;
        border-bottom: 1px solid var(--border-color);
    }

    @media (max-width: 1024px) {
        .trx-grid { grid-template-columns: 1fr; }
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

    @if(session('error'))
        <div class="alert-banner alert-danger">
            <i data-lucide="alert-circle" style="width:18px;height:18px;flex-shrink:0;margin-top:1px;"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="trx-grid">
        <!-- PANEL 1: FORM TRANSAKSI MANUAL (Design Handoff Sec 5) -->
        <section class="wt-card">
            <h2 class="card-heading">Form Transaksi Manual</h2>
            <p class="card-desc">Catat pergerakan equipment keluar atau masuk workshop oleh Staff Admin.</p>

            <form method="POST" action="{{ route('transaksi.store') }}" class="form-stack">
                @csrf
                <div class="form-group">
                    <label for="equipment_id">Equipment *</label>
                    <select id="equipment_id" name="equipment_id" class="wt-select" required>
                        <option value="">Pilih Equipment...</option>
                        @foreach($equipments as $eq)
                            @php
                                $kode = 'EQ-' . str_pad($eq->id, 3, '0', STR_PAD_LEFT);
                                $statusLabel = $eq->status === 'available' ? 'Di Workshop' : 'Di Luar Workshop';
                            @endphp
                            <option value="{{ $eq->id }}" {{ old('equipment_id') == $eq->id ? 'selected' : '' }}>
                                {{ $kode }} — {{ $eq->name }} ({{ $statusLabel }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="type">Jenis Transaksi *</label>
                    <select id="type" name="type" class="wt-select" required>
                        <option value="">Pilih Masuk atau Keluar</option>
                        <option value="out" {{ old('type') === 'out' ? 'selected' : '' }}>Keluar Workshop (Check Out)</option>
                        <option value="in" {{ old('type') === 'in' ? 'selected' : '' }}>Masuk Workshop (Check In)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Waktu Pencatatan</label>
                    <input type="text"
                           class="wt-input"
                           value="{{ now()->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB (Otomatis)"
                           readonly
                           style="background:#F8FAFC;color:var(--text-secondary);">
                </div>

                <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:4px;">
                    <button type="submit" class="wt-btn wt-btn-primary">
                        <i data-lucide="save" style="width:17px;height:17px;"></i>
                        <span>Simpan Transaksi</span>
                    </button>
                </div>
            </form>

            <div class="rules-box">
                <strong>Aturan Validasi:</strong>
                <ul>
                    <li>Equipment harus terdaftar pada master data sistem.</li>
                    <li>Barang berstatus <em>Di Luar Workshop</em> tidak dapat dicatat keluar ganda.</li>
                    <li>Barang berstatus <em>Di Workshop</em> tidak dapat dicatat masuk ulang.</li>
                </ul>
            </div>
        </section>

        <!-- PANEL 2: SIMULASI & VALIDASI DATA RFID -->
        <section class="wt-card">
            <h2 class="card-heading">Simulasi Validasi Pembacaan RFID</h2>
            <p class="card-desc">Uji endpoint pemindaian tag RFID (<span class="font-mono">/scan-out</span> & <span class="font-mono">/scan-in</span>) sebelum integrasi hardware fisik.</p>

            <div class="form-stack">
                <div class="form-group">
                    <label for="sim_rfid_uid">UID Tag RFID *</label>
                    <input type="text"
                           id="sim_rfid_uid"
                           class="wt-input font-mono"
                           placeholder="Masukkan UID Tag (misal: A3B8129F)">
                </div>

                <div class="rfid-btn-row">
                    <button type="button" class="wt-btn wt-btn-primary" onclick="simulateRfid('out')">
                        <i data-lucide="arrow-up-right" style="width:17px;height:17px;"></i>
                        <span>Simulasi Gate Keluar</span>
                    </button>
                    <button type="button" class="wt-btn wt-btn-outline" onclick="simulateRfid('in')">
                        <i data-lucide="arrow-down-left" style="width:17px;height:17px;"></i>
                        <span>Simulasi Gate Masuk</span>
                    </button>
                </div>
            </div>

            <div id="rfidResultBox" class="rfid-result-box">
                <div style="font-weight:600;font-size:13px;margin-bottom:2px;">Menunggu Data Pembacaan</div>
                <div style="font-size:12px;color:var(--text-secondary);">Masukkan UID Tag RFID dan tekan tombol simulasi untuk menguji kecocokan UID serta perubahan status.</div>
            </div>

            <div class="rules-box">
                <strong>Aturan Validasi RFID:</strong>
                <ul>
                    <li>UID RFID tidak boleh kosong dan dicocokkan dengan tabel <code>equipments</code>.</li>
                    <li>Tag yang tidak dikenali ditolak otomatis (HTTP 404).</li>
                    <li>Pembacaan status berulang ditolak untuk mencegah duplikasi (HTTP 400).</li>
                </ul>
            </div>
        </section>
    </div>

    <!-- TABEL 5 TRANSAKSI TERAKHIR -->
    <section class="wt-card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
            <h2 class="card-heading" style="margin-bottom:0;">5 Transaksi Terakhir</h2>
            <a href="{{ route('riwayat.index') }}" style="font-size:13px;font-weight:500;color:var(--primary);text-decoration:none;">Lihat Semua Riwayat</a>
        </div>

        @if($recentTransactions->count() > 0)
            <div class="table-responsive">
                <table class="wt-table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Equipment</th>
                            <th>UID Tag</th>
                            <th>Jenis Pergerakan</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $trx)
                            @php
                                $eq = $trx->equipment;
                                $kode = $eq ? 'EQ-' . str_pad($eq->id, 3, '0', STR_PAD_LEFT) : '-';
                            @endphp
                            <tr>
                                <td><span class="font-mono">{{ $kode }}</span></td>
                                <td style="font-weight:600;">{{ $eq->name ?? 'Tidak Dikenal' }}</td>
                                <td><span class="font-mono">{{ $eq->rfid_uid ?? '-' }}</span></td>
                                <td>
                                    @if($trx->type === 'in')
                                        <span class="badge badge-success">Masuk</span>
                                    @else
                                        <span class="badge badge-warning">Keluar</span>
                                    @endif
                                </td>
                                <td style="color:var(--text-secondary);">
                                    {{ $trx->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p style="text-align:center;color:var(--text-secondary);padding:24px;">Belum ada riwayat transaksi equipment.</p>
        @endif
    </section>
@endsection

@section('scripts')
<script>
    async function simulateRfid(direction) {
        const uidInput = document.getElementById('sim_rfid_uid');
        const resultBox = document.getElementById('rfidResultBox');
        const uid = uidInput.value.trim();

        if (!uid) {
            resultBox.className = 'rfid-result-box invalid';
            resultBox.innerHTML = '<strong>UID Kosong</strong><div style="font-size:12px;margin-top:2px;">UID RFID tidak boleh kosong. Masukkan UID terlebih dahulu.</div>';
            return;
        }

        const url = direction === 'out' ? '{{ route("scan.out") }}' : '{{ route("scan.in") }}';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        resultBox.className = 'rfid-result-box';
        resultBox.innerHTML = '<strong>Memproses identifikasi RFID...</strong>';

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ rfid_uid: uid })
            });

            const data = await response.json();

            if (response.ok && data.success) {
                resultBox.className = 'rfid-result-box valid';
                resultBox.innerHTML = `<strong>Valid — ${data.message}</strong>
                    <div style="font-size:12px;margin-top:4px;">Equipment: <b>${data.data.equipment_name}</b> (${data.data.rfid_uid}) • Status baru: <b>${data.data.status}</b></div>`;
                setTimeout(() => window.location.reload(), 1200);
            } else {
                resultBox.className = response.status === 404 ? 'rfid-result-box warning' : 'rfid-result-box invalid';
                resultBox.innerHTML = `<strong>Ditolak (HTTP ${response.status})</strong>
                    <div style="font-size:12px;margin-top:4px;">${data.message || 'Data RFID gagal diterima.'}</div>`;
            }
        } catch (err) {
            resultBox.className = 'rfid-result-box invalid';
            resultBox.innerHTML = '<strong>Gagal Terhubung</strong><div style="font-size:12px;margin-top:2px;">Terjadi kesalahan jaringan saat mengirim simulasi ke server.</div>';
        }
    }
</script>
@endsection
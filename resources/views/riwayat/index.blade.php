@extends('layouts.app')

@section('title', 'Riwayat')
@section('page-title', 'Riwayat')
@section('page-subtitle', 'Catatan log pergerakan equipment keluar dan masuk workshop')

@section('styles')
<style>
    .riwayat-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

    .riwayat-filter-form {
        display: flex;
        align-items: center;
        gap: 10px;
        flex: 1;
        flex-wrap: wrap;
    }

    .search-input-wrap {
        position: relative;
        flex: 1;
        min-width: 220px;
        max-width: 320px;
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

    .filter-box-sm {
        width: 175px;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .wt-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 680px;
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

    .pagination-wrap {
        margin-top: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        font-size: 13px;
        color: var(--text-secondary);
    }

    .pagination-links {
        display: flex;
        gap: 6px;
    }

    .page-pill {
        padding: 6px 12px;
        border-radius: 6px;
        border: 1px solid var(--border-subtle);
        background: #FFFFFF;
        color: var(--text-main);
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
    }

    .page-pill.active {
        background: var(--primary);
        border-color: var(--primary);
        color: #FFFFFF;
    }

    .page-pill.disabled {
        opacity: 0.45;
        pointer-events: none;
    }
</style>
@endsection

@section('content')
    <div class="wt-card">
        <!-- TOOLBAR PENCARIAN & FILTER (Design Handoff Sec 3 & 7) -->
        <div class="riwayat-toolbar">
            <form method="GET" action="{{ route('riwayat.index') }}" class="riwayat-filter-form">
                <div class="search-input-wrap">
                    <i data-lucide="search"></i>
                    <input type="text"
                           name="search"
                           class="wt-input"
                           value="{{ request('search') }}"
                           placeholder="Cari nama equipment atau UID...">
                </div>

                <div class="filter-box-sm">
                    <select name="type" class="wt-select" onchange="this.form.submit()">
                        <option value="">Semua Pergerakan</option>
                        <option value="in" {{ request('type') === 'in' ? 'selected' : '' }}>Masuk (Check In)</option>
                        <option value="out" {{ request('type') === 'out' ? 'selected' : '' }}>Keluar (Check Out)</option>
                    </select>
                </div>

                <div class="filter-box-sm">
                    <input type="date"
                           name="date"
                           class="wt-input"
                           value="{{ request('date') }}"
                           onchange="this.form.submit()">
                </div>

                <button type="submit" class="wt-btn wt-btn-outline">Filter</button>

                @if(request()->filled('search') || request()->filled('type') || request()->filled('date'))
                    <a href="{{ route('riwayat.index') }}" class="wt-btn wt-btn-outline" style="color:var(--text-secondary);">Reset</a>
                @endif
            </form>

            <a href="{{ route('transaksi.index') }}" class="wt-btn wt-btn-primary">
                <i data-lucide="arrow-left-right" style="width:17px;height:17px;"></i>
                <span>Catat Transaksi</span>
            </a>
        </div>

        <!-- TABEL LOG RIWAYAT -->
        @if($transactions->count() > 0)
            <div class="table-responsive">
                <table class="wt-table">
                    <thead>
                        <tr>
                            <th>Kode Equipment</th>
                            <th>Nama Equipment</th>
                            <th>UID Tag RFID</th>
                            <th>Pergerakan</th>
                            <th>Waktu Transaksi</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $trx)
                            @php
                                $eq = $trx->equipment;
                                $kodeEq = $eq ? 'EQ-' . str_pad($eq->id, 3, '0', STR_PAD_LEFT) : '-';
                            @endphp
                            <tr>
                                <td><span class="font-mono">{{ $kodeEq }}</span></td>
                                <td style="font-weight: 600;">{{ $eq->name ?? 'Equipment Terhapus' }}</td>
                                <td>
                                    <span class="font-mono" style="background:#F1F5F9;padding:3px 8px;border-radius:6px;color:var(--primary-dark);">
                                        {{ $eq->rfid_uid ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    @if($trx->type === 'in')
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
                                <td style="color: var(--text-main); white-space: nowrap;">
                                    {{ $trx->created_at->timezone('Asia/Jakarta')->format('d M Y, H:i') }} WIB
                                </td>
                                <td style="color: var(--text-secondary); font-size: 13px;">
                                    {{ $trx->type === 'in' ? 'Kembali ke Workshop' : 'Dibawa Keluar Workshop' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- PAGINASI SEDERHANA -->
            <div class="pagination-wrap">
                <div>
                    Menampilkan {{ $transactions->firstItem() }}–{{ $transactions->lastItem() }} dari {{ $transactions->total() }} transaksi
                </div>

                @if($transactions->hasPages())
                    <div class="pagination-links">
                        <a href="{{ $transactions->previousPageUrl() ?? '#' }}"
                           class="page-pill {{ $transactions->onFirstPage() ? 'disabled' : '' }}">
                            Sebelumnya
                        </a>
                        <a href="{{ $transactions->nextPageUrl() ?? '#' }}"
                           class="page-pill {{ !$transactions->hasMorePages() ? 'disabled' : '' }}">
                            Berikutnya
                        </a>
                    </div>
                @endif
            </div>
        @else
            <!-- EMPTY STATE (Design Handoff Sec 6) -->
            <div class="empty-state-box">
                <div class="empty-state-circle">
                    <i data-lucide="history" style="width:26px;height:26px;"></i>
                </div>
                <h3 style="font-size:16px;font-weight:700;color:var(--text-main);margin-bottom:6px;">
                    Belum ada riwayat transaksi equipment.
                </h3>
                <p style="font-size:13px;color:var(--text-secondary);">
                    Data riwayat akan tercatat otomatis setiap kali equipment keluar atau masuk workshop.
                </p>
            </div>
        @endif
    </div>
@endsection

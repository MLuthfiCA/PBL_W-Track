@extends('layouts.app')

@section('title', 'Notifikasi')
@section('page-title', 'Notifikasi')
@section('page-subtitle', 'Pemberitahuan aktivitas pergerakan equipment dan status perangkat')

@section('content')
    <div class="wt-card">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
            <h2 style="font-size:16px;font-weight:700;color:var(--text-main);">Daftar Notifikasi Sistem</h2>
            <a href="{{ route('dashboard') }}" class="wt-btn wt-btn-outline">Kembali ke Dashboard</a>
        </div>

        <div style="display:flex;flex-direction:column;gap:12px;">
            @foreach($notifications as $notif)
                @php
                    $bg = match($notif['type']) {
                        'success' => 'var(--success-bg)',
                        'warning' => 'var(--warning-bg)',
                        default   => 'var(--danger-bg)',
                    };
                    $color = match($notif['type']) {
                        'success' => 'var(--success)',
                        'warning' => 'var(--warning)',
                        default   => 'var(--danger)',
                    };
                    $icon = match($notif['type']) {
                        'success' => 'arrow-down-left',
                        'warning' => 'arrow-up-right',
                        default   => 'alert-circle',
                    };
                @endphp
                <div style="display:flex;align-items:flex-start;gap:12px;padding:14px;border:1px solid var(--border-subtle);border-radius:10px;background:#FFFFFF;">
                    <div style="width:36px;height:36px;border-radius:50%;background:{{ $bg }};color:{{ $color }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i data-lucide="{{ $icon }}" style="width:18px;height:18px;"></i>
                    </div>
                    <div style="flex:1;">
                        <div style="font-size:14px;font-weight:600;color:var(--text-main);">{{ $notif['title'] }}</div>
                        <div style="font-size:13px;color:var(--text-secondary);margin-top:2px;">{{ $notif['message'] }}</div>
                        <div style="font-size:12px;color:var(--text-neutral);margin-top:4px;">{{ $notif['time'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

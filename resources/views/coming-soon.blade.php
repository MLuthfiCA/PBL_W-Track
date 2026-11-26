@extends('layouts.app')

@section('title', $page)
@section('page-title', $page)
@section('page-subtitle', 'Halaman ' . $page . ' W-Track')

@section('content')
<div class="wt-card" style="min-height: 360px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 40px 20px;">
    <div style="width: 64px; height: 64px; border-radius: 16px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
        <i data-lucide="construction" style="width: 30px; height: 30px;"></i>
    </div>
    <h2 style="font-size: 20px; font-weight: 700; color: var(--text-main); margin-bottom: 8px;">
        Halaman {{ $page }} Dalam Pengembangan
    </h2>
    <p style="font-size: 14px; color: var(--text-secondary); max-width: 420px; margin-bottom: 24px;">
        Modul ini sedang diselaraskan dengan spesifikasi Design Handoff W-Track dan akan segera diaktifkan pada tahap berikutnya.
    </p>
    <a href="{{ route('dashboard') }}" class="wt-btn wt-btn-primary">
        <i data-lucide="arrow-left" style="width: 18px; height: 18px;"></i>
        <span>Kembali ke Dashboard</span>
    </a>
</div>
@endsection
@extends('layouts.app')

@section('title', $page)

@section('styles')
<style>
    body { background: #f0f4f8; display: flex; }

    .app-wrapper { display: flex; width: 100%; min-height: 100vh; }

    /* Reuse sidebar styles from dashboard */
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
        box-shadow: 0 2px 8px var(--primary-glow);
    }

    .sidebar-logo .logo-text {
        font-size: 16px;
        font-weight: 700;
        color: #fff;
        flex: 1;
    }

    .sidebar-close { display: none; background: none; border: none; color: rgba(255,255,255,0.5); font-size: 20px; cursor: pointer; }

    .sidebar-nav { flex: 1; padding: 14px 12px; }

    .nav-list { list-style: none; margin-bottom: 6px; }

    .nav-section-label {
        font-size: 10px;
        font-weight: 600;
        color: rgba(255,255,255,0.25);
        letter-spacing: 1.2px;
        padding: 14px 8px 6px;
    }

    .nav-item { margin-bottom: 2px; }

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

    .nav-link:hover { background: rgba(255,255,255,0.07); color: rgba(255,255,255,0.9); }

    .nav-item.active .nav-link {
        background: linear-gradient(90deg, rgba(0,188,212,0.18), rgba(0,188,212,0.05));
        color: var(--primary);
        font-weight: 600;
        position: relative;
    }

    .nav-item.active .nav-link::before {
        content: '';
        position: absolute;
        left: 0; top: 20%; bottom: 20%;
        width: 3px;
        background: var(--primary);
        border-radius: 0 3px 3px 0;
        margin-left: -12px;
    }

    .nav-icon { font-size: 18px; flex-shrink: 0; }
    .nav-logout { color: rgba(255,100,100,0.65); }
    .nav-logout:hover { background: rgba(239,68,68,0.1); color: #FC8181; }

    .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 99; }
    .sidebar-overlay.open { display: block; }

    .main-content {
        margin-left: 220px;
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

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

    .topbar-left { display: flex; align-items: center; gap: 14px; }

    .hamburger-btn {
        display: none;
        background: none;
        border: none;
        font-size: 22px;
        color: var(--text-secondary);
        cursor: pointer;
    }

    .topbar-title h2 { font-size: 19px; font-weight: 700; color: var(--text-primary); }
    .topbar-title p { font-size: 12px; color: var(--text-muted); margin-top: 1px; }

    .topbar-right { display: flex; align-items: center; gap: 12px; }

    .notif-btn {
        position: relative;
        width: 38px; height: 38px;
        background: #f8fafc;
        border: 1px solid var(--border);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        font-size: 19px;
        color: var(--text-secondary);
        transition: all var(--transition);
        text-decoration: none;
    }

    .notif-btn:hover { background: var(--primary); border-color: var(--primary); color: #fff; }
    .notif-badge { position: absolute; top: 5px; right: 5px; width: 8px; height: 8px; background: #EF4444; border-radius: 50%; border: 1.5px solid #fff; }

    .user-info {
        display: flex; align-items: center; gap: 10px;
        padding: 6px 12px;
        background: #f8fafc;
        border: 1px solid var(--border);
        border-radius: 10px;
        cursor: pointer;
        transition: all var(--transition);
    }

    .user-info:hover { border-color: var(--primary); }

    .user-avatar {
        width: 30px; height: 30px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700; color: #fff;
    }

    .user-name { font-size: 13px; font-weight: 600; color: var(--text-primary); }
    .user-role { font-size: 11px; color: var(--text-muted); }

    /* Coming Soon content */
    .page-content {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
    }

    .coming-soon-box {
        text-align: center;
        max-width: 400px;
    }

    .coming-soon-icon {
        width: 80px; height: 80px;
        background: linear-gradient(135deg, var(--primary-light), rgba(0,188,212,0.15));
        border-radius: 24px;
        display: flex; align-items: center; justify-content: center;
        font-size: 36px;
        color: var(--primary);
        margin: 0 auto 24px;
        box-shadow: 0 4px 20px var(--primary-glow);
    }

    .coming-soon-box h3 {
        font-size: 22px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 10px;
    }

    .coming-soon-box p {
        font-size: 14px;
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 28px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        border-radius: var(--radius-sm);
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all var(--transition);
        box-shadow: 0 4px 12px var(--primary-glow);
    }

    .btn-back:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(0,188,212,0.45);
    }

    @media (max-width: 768px) {
        .sidebar { transform: translateX(-100%); }
        .sidebar.open { transform: translateX(0); }
        .sidebar-close { display: block; }
        .main-content { margin-left: 0; }
        .hamburger-btn { display: block; }
    }
</style>
@endsection

@section('content')
<div class="app-wrapper">
    @include('partials.sidebar')

    <div class="main-content">
        <header class="topbar">
            <div class="topbar-left">
                <button class="hamburger-btn" id="hamburgerBtn"><i class="ri-menu-line"></i></button>
                <div class="topbar-title">
                    <h2>{{ $page }}</h2>
                    <p>Fitur sedang dalam pengembangan</p>
                </div>
            </div>
            <div class="topbar-right">
                <a href="{{ route('notifikasi.index') }}" class="notif-btn">
                    <i class="ri-notification-3-line"></i>
                    <span class="notif-badge"></span>
                </a>
                <div class="user-info">
                    <div class="user-avatar">AO</div>
                    <div>
                        <div class="user-name">Admin Operasional</div>
                        <div class="user-role">Administrator</div>
                    </div>
                    <i class="ri-arrow-down-s-line" style="color:var(--text-muted); font-size:16px;"></i>
                </div>
            </div>
        </header>

        <div class="page-content">
            <div class="coming-soon-box">
                <div class="coming-soon-icon">
                    <i class="ri-time-line"></i>
                </div>
                <h3>Halaman {{ $page }} Segera Hadir</h3>
                <p>Fitur ini sedang dalam tahap pengembangan dan akan segera tersedia. Pantau terus pembaruan sistem.</p>
                <a href="{{ route('dashboard') }}" class="btn-back">
                    <i class="ri-arrow-left-line"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const sidebar      = document.getElementById('sidebar');
    const sidebarClose = document.getElementById('sidebarClose');
    const overlay      = document.getElementById('sidebarOverlay');

    hamburgerBtn?.addEventListener('click', () => { sidebar.classList.add('open'); overlay.classList.add('open'); });
    sidebarClose?.addEventListener('click', () => { sidebar.classList.remove('open'); overlay.classList.remove('open'); });
    overlay?.addEventListener('click',      () => { sidebar.classList.remove('open'); overlay.classList.remove('open'); });
</script>
@endsection

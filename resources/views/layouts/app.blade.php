<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - W-Track</title>

    <!-- Google Fonts: Roboto & Roboto Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@500;600&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #3949AB;
            --primary-dark: #283593;
            --primary-light: #E8EAF6;
            --bg-body: #F5F7FA;
            --bg-surface: #FFFFFF;
            --border-color: #EDEBEB;
            --border-subtle: #E2E8F0;
            --text-main: #202535;
            --text-secondary: #687386;
            --text-neutral: #8A94A3;
            --accent: #FFB300;
            --success: #2E9E5B;
            --success-bg: #EBF5EC;
            --warning: #F59E0B;
            --warning-bg: #FFF4E5;
            --danger: #E53935;
            --danger-bg: #FDECEC;
            --sidebar-width: 220px;
            --topbar-height: 68px;
            --radius-card: 12px;
            --radius-btn: 8px;
            --shadow-card: 0 1px 3px rgba(32, 37, 53, 0.06), 0 1px 2px rgba(32, 37, 53, 0.04);
        }

        body {
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            line-height: 1.5;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        .font-mono {
            font-family: 'Roboto Mono', monospace;
            font-weight: 500;
            font-size: 13px;
        }

        /* ── APP SHELL ─────────────────────────────────── */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* ── SIDEBAR (220px) ───────────────────────────── */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--bg-surface);
            border-right: 1px solid var(--border-subtle);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            transition: transform 0.25s ease;
        }

        .sidebar-header {
            height: var(--topbar-height);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            border-bottom: 1px solid var(--border-color);
        }

        .brand-box {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .brand-logo {
            width: 34px;
            height: 34px;
            background: var(--primary);
            color: #FFFFFF;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 18px;
            position: relative;
        }

        .brand-logo::after {
            content: '';
            width: 6px;
            height: 6px;
            background: var(--accent);
            border-radius: 50%;
            position: absolute;
            top: 5px;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--primary);
            letter-spacing: -0.2px;
        }

        .sidebar-close-btn {
            display: none;
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }

        .nav-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            min-height: 44px;
            padding: 10px 14px;
            border-radius: var(--radius-btn);
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.15s ease;
        }

        .nav-link:hover {
            background: #F1F3F9;
            color: var(--primary);
        }

        .nav-link.active {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
        }

        .nav-link i, .nav-link svg {
            width: 19px;
            height: 19px;
            flex-shrink: 0;
        }

        /* ── SIDEBAR FOOTER (STAFF ADMIN + LOGOUT) ─────── */
        .sidebar-footer {
            padding: 14px 16px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            background: #FAFBFD;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }

        .user-avatar-sm {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--primary-light);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .user-name-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-main);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .btn-logout-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid transparent;
            background: transparent;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-logout-icon:hover {
            background: var(--danger-bg);
            color: var(--danger);
        }

        /* ── MAIN CONTAINER & TOPBAR (68px) ────────────── */
        .main-container {
            flex: 1;
            margin-left: var(--sidebar-width);
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .topbar {
            height: var(--topbar-height);
            background: var(--bg-surface);
            border-bottom: 1px solid var(--border-subtle);
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mobile-menu-btn {
            display: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 1px solid var(--border-subtle);
            background: var(--bg-surface);
            color: var(--text-main);
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .page-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-main);
            line-height: 1.2;
        }

        .page-subtitle {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 2px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-meta {
            text-align: right;
        }

        .topbar-date {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-main);
        }

        .topbar-updated {
            font-size: 12px;
            color: var(--text-neutral);
        }

        .topbar-icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid var(--border-subtle);
            background: var(--bg-surface);
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            position: relative;
            transition: all 0.15s ease;
        }

        .topbar-icon-btn:hover {
            background: var(--primary-light);
            color: var(--primary);
            border-color: var(--primary-light);
        }

        .content-area {
            padding: 24px;
            flex: 1;
        }

        /* ── REUSABLE CARDS, BUTTONS, INPUTS, BADGES ───── */
        .wt-card {
            background: var(--bg-surface);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-card);
            padding: 20px;
            box-shadow: var(--shadow-card);
        }

        .wt-btn {
            height: 40px;
            padding: 0 16px;
            border-radius: var(--radius-btn);
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            border: 1px solid transparent;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .wt-btn-primary {
            background: var(--primary);
            color: #FFFFFF;
        }

        .wt-btn-primary:hover {
            background: var(--primary-dark);
        }

        .wt-btn-outline {
            background: #FFFFFF;
            border-color: var(--border-subtle);
            color: var(--text-main);
        }

        .wt-btn-outline:hover {
            background: #F5F7FA;
        }

        .wt-input, .wt-select {
            height: 40px;
            padding: 0 12px;
            border-radius: var(--radius-btn);
            border: 1px solid #CBD5E1;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
            color: var(--text-main);
            background: #FFFFFF;
            width: 100%;
        }

        .wt-input:focus, .wt-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(57, 73, 171, 0.15);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-success { background: var(--success-bg); color: #1B6E3E; }
        .badge-warning { background: var(--warning-bg); color: #9A5A00; }
        .badge-danger  { background: var(--danger-bg);  color: #B3261E; }
        .badge-neutral { background: #F1F5F9; color: var(--text-secondary); }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            z-index: 90;
        }

        /* ── RESPONSIVE BREAKPOINTS (Design Handoff Sec 10) */
        @media (max-width: 1024px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
            }
            .sidebar-close-btn {
                display: flex;
            }
            .sidebar-overlay.active {
                display: block;
            }
            .main-container {
                margin-left: 0;
            }
            .mobile-menu-btn {
                display: flex;
            }
        }

        @media (max-width: 600px) {
            .topbar {
                padding: 0 16px;
            }
            .topbar-meta {
                display: none;
            }
            .content-area {
                padding: 16px;
            }
            .page-title {
                font-size: 20px;
            }
        }

        /* ── GLOBAL LAYOUT & SIDEBAR ─────────────────── */
        body {
            background: #f0f4f8;
            display: flex;
        }

        .app-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

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

        .sidebar-overlay.open {
            display: block;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-close {
                display: block;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    @auth
        <div class="app-wrapper">
            @include('partials.sidebar')

            <div class="main-container">
                @include('partials.topbar')

                <main class="content-area">
                    @yield('content')
                </main>
            </div>
        </div>
    @else
        @yield('content')
    @endauth

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const openBtn = document.getElementById('mobileMenuBtn');
            const closeBtn = document.getElementById('sidebarCloseBtn');

            function openSidebar() {
                if (sidebar) sidebar.classList.add('open');
                if (overlay) overlay.classList.add('active');
            }

            function closeSidebar() {
                if (sidebar) sidebar.classList.remove('open');
                if (overlay) overlay.classList.remove('active');
            }

            if (openBtn) openBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (overlay) overlay.addEventListener('click', closeSidebar);
        });
    </script>

    @yield('scripts')
</body>
</html>
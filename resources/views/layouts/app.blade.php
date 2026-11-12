<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="W-Track - Sistem Manajemen Equipment Workshop">
    <title>@yield('title', 'W-Track') | Sistem Manajemen Equipment</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Remix Icons -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #00BCD4;
            --primary-dark: #0097A7;
            --primary-light: #B2EBF2;
            --primary-glow: rgba(0, 188, 212, 0.25);
            --sidebar-bg: #0D1B2A;
            --sidebar-hover: #1a2d42;
            --sidebar-active: #00BCD4;
            --dark-bg: #0a1628;
            --card-bg: #ffffff;
            --body-bg: #f0f4f8;
            --text-primary: #1a202c;
            --text-secondary: #718096;
            --text-muted: #a0aec0;
            --border: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.10);
            --shadow-lg: 0 8px 32px rgba(0,0,0,0.14);
            --radius: 12px;
            --radius-sm: 8px;
            --radius-lg: 16px;
            --status-used: #F59E0B;
            --status-available: #10B981;
            --status-repair: #EF4444;
            --transition: 0.22s cubic-bezier(0.4, 0, 0.2, 1);
        }

        html, body {
            height: 100%;
            font-family: 'Inter', sans-serif;
            background: var(--body-bg);
            color: var(--text-primary);
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
            border-radius: 0 16px 16px 0;
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

        /* ── GLOBAL TOPBAR (smooth edges) ─────────────── */
        .main-content {
            margin-left: 220px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            min-width: 0;
        }

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

        @media (max-width: 768px) {
            .topbar {
                margin: 12px 16px 0 16px;
                padding: 0 16px;
                border-radius: 12px;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .sidebar-close {
                display: block;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    @yield('content')
    @yield('scripts')
</body>
</html>

<aside class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <div class="logo-icon-sm">
            <i class="ri-tools-line"></i>
        </div>
        <span class="logo-text">W-Track</span>
        <button class="sidebar-close" id="sidebarClose" aria-label="Tutup sidebar">
            <i class="ri-close-line"></i>
        </button>
    </div>

    <!-- Menu Utama -->
    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="ri-dashboard-3-line nav-icon"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('equipment*') ? 'active' : '' }}">
                <a href="{{ route('equipment.index') }}" class="nav-link">
                    <i class="ri-box-3-line nav-icon"></i>
                    <span class="nav-label">Equipment</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('pemeliharaan*') ? 'active' : '' }}">
                <a href="{{ route('pemeliharaan.index') }}" class="nav-link">
                    <i class="ri-tools-fill nav-icon"></i>
                    <span class="nav-label">Pemeliharaan</span>
                </a>
            </li>
            <li class="nav-item {{ request()->routeIs('laporan*') ? 'active' : '' }}">
                <a href="{{ route('laporan.index') }}" class="nav-link">
                    <i class="ri-bar-chart-2-line nav-icon"></i>
                    <span class="nav-label">Laporan</span>
                </a>
            </li>
        </ul>

        <!-- Section Sistem -->
        <div class="nav-section-label">SISTEM</div>
        <ul class="nav-list">
            <li class="nav-item {{ request()->routeIs('pengaturan*') ? 'active' : '' }}">
                <a href="{{ route('pengaturan.index') }}" class="nav-link">
                    <i class="ri-settings-3-line nav-icon"></i>
                    <span class="nav-label">Pengaturan</span>
                </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                    @csrf
                    <button type="submit" class="nav-link nav-logout" onclick="return confirm('Yakin ingin keluar?')">
                        <i class="ri-logout-box-r-line nav-icon"></i>
                        <span class="nav-label">Keluar</span>
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

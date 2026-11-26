<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('dashboard') }}" class="brand-box">
            <div class="brand-logo">W</div>
            <span class="brand-name">W-Track</span>
        </a>
        <button type="button" class="sidebar-close-btn" id="sidebarCloseBtn" aria-label="Tutup menu">
            <i data-lucide="x"></i>
        </button>
    </div>

    <nav class="sidebar-nav" aria-label="Navigasi Utama">
        <ul class="nav-list">
            <li>
                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('equipment.index') }}"
                   class="nav-link {{ request()->routeIs('equipment.*') ? 'active' : '' }}">
                    <i data-lucide="package"></i>
                    <span>Equipment</span>
                </a>
            </li>
            <li>
                <a href="{{ route('monitoring-iot.index') }}"
                   class="nav-link {{ request()->routeIs('monitoring-iot.*') ? 'active' : '' }}">
                    <i data-lucide="radio-tower"></i>
                    <span>Monitoring IoT</span>
                </a>
            </li>
            <li>
                <a href="{{ route('transaksi.index') }}"
                   class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                    <i data-lucide="arrow-left-right"></i>
                    <span>Transaksi</span>
                </a>
            </li>
            <li>
                <a href="{{ route('riwayat.index') }}"
                   class="nav-link {{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                    <i data-lucide="history"></i>
                    <span>Riwayat</span>
                </a>
            </li>
        </ul>
    </nav>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar-sm">
                <i data-lucide="user-round" style="width:18px;height:18px;"></i>
            </div>
            <span class="user-name-label">{{ Auth::user()->name ?? 'Staff Admin' }}</span>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout-icon" aria-label="Keluar" title="Keluar dari aplikasi"
                    onclick="return confirm('Yakin ingin keluar dari W-Track?')">
                <i data-lucide="log-out" style="width:18px;height:18px;"></i>
            </button>
        </form>
    </div>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>
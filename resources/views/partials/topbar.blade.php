<header class="topbar">
    <div class="topbar-left">
        <button type="button" class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Buka menu">
            <i data-lucide="menu" style="width:20px;height:20px;"></i>
        </button>
        <div>
            <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
            <p class="page-subtitle">@yield('page-subtitle', 'Monitoring keluar-masuk equipment workshop')</p>
        </div>
    </div>

    <div class="topbar-right">
        <div class="topbar-meta">
            <div class="topbar-date">{{ now()->translatedFormat('l, d M Y') }}</div>
            <div class="topbar-updated">Terakhir diperbarui: {{ now()->format('d M Y, H:i') }} WIB</div>
        </div>

        <a href="{{ route('notifikasi.index') }}" class="topbar-icon-btn" aria-label="Notifikasi" title="Notifikasi">
            <i data-lucide="bell" style="width:18px;height:18px;"></i>
        </a>

        <div class="topbar-icon-btn" title="{{ Auth::user()->email ?? 'Staff Admin' }}">
            <i data-lucide="user-round" style="width:18px;height:18px;"></i>
        </div>
    </div>
</header>
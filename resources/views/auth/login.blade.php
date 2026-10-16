@extends('layouts.app')

@section('title', 'Masuk')

@section('styles')
<style>
    body {
        background: var(--body-bg);
        min-height: 100vh;
        display: flex;
    }

    .login-wrapper {
        display: flex;
        width: 100%;
        min-height: 100vh;
    }

    /* ── LEFT PANEL ─────────────────────────── */
    .login-left {
        width: 300px;
        min-height: 100vh;
        background: var(--sidebar-bg);
        display: flex;
        flex-direction: column;
        padding: 32px 28px;
        position: relative;
        overflow: hidden;
        flex-shrink: 0;
    }

    .login-left::before {
        content: '';
        position: absolute;
        top: -80px;
        left: -80px;
        width: 260px;
        height: 260px;
        background: radial-gradient(circle, rgba(0,188,212,0.12) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .login-left::after {
        content: '';
        position: absolute;
        bottom: -60px;
        right: -60px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(0,188,212,0.08) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .left-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: auto;
        z-index: 1;
    }

    .logo-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #fff;
        box-shadow: 0 4px 12px var(--primary-glow);
        flex-shrink: 0;
    }

    .logo-text {
        font-size: 18px;
        font-weight: 700;
        color: #ffffff;
        letter-spacing: 0.3px;
    }

    .left-illustration {
        width: 180px;
        height: 140px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: var(--radius);
        margin: 40px auto 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 1;
        backdrop-filter: blur(8px);
    }

    .left-illustration svg {
        width: 90px;
        height: 90px;
        opacity: 0.7;
    }

    /* Floating dots decoration */
    .left-dots {
        position: absolute;
        width: 80px;
        height: 80px;
        bottom: 200px;
        left: 20px;
        z-index: 0;
        opacity: 0.15;
        background-image: radial-gradient(circle, var(--primary) 1.5px, transparent 1.5px);
        background-size: 12px 12px;
    }

    .left-tagline {
        z-index: 1;
        margin-bottom: 40px;
    }

    .left-tagline h2 {
        font-size: 22px;
        font-weight: 700;
        color: #ffffff;
        line-height: 1.4;
        margin-bottom: 12px;
    }

    .left-tagline h2 span {
        color: var(--primary);
    }

    .left-tagline p {
        font-size: 13px;
        color: rgba(255,255,255,0.5);
        line-height: 1.6;
    }

    .left-version {
        font-size: 11px;
        color: rgba(255,255,255,0.25);
        z-index: 1;
        margin-top: auto;
    }

    /* ── RIGHT PANEL ─────────────────────────── */
    .login-right {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f5f7fb;
        padding: 40px 24px;
        position: relative;
    }

    .login-right::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(ellipse at 20% 20%, rgba(0,188,212,0.04) 0%, transparent 50%),
            radial-gradient(ellipse at 80% 80%, rgba(0,150,180,0.04) 0%, transparent 50%);
        pointer-events: none;
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1.5px dashed rgba(0, 188, 212, 0.4);
        padding: 40px 36px;
        box-shadow: var(--shadow-md);
        position: relative;
        z-index: 1;
    }

    .login-card-header {
        margin-bottom: 28px;
    }

    .login-card-header h1 {
        font-size: 22px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 6px;
    }

    .login-card-header p {
        font-size: 13.5px;
        color: var(--text-secondary);
    }

    /* Alert */
    .alert {
        padding: 12px 16px;
        border-radius: var(--radius-sm);
        margin-bottom: 20px;
        font-size: 13.5px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .alert-error {
        background: #FEF2F2;
        border: 1px solid #FECACA;
        color: #DC2626;
    }

    .alert-success {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        color: #16A34A;
    }

    /* Form */
    .form-group {
        margin-bottom: 18px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 7px;
    }

    .input-wrapper {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 17px;
        pointer-events: none;
        transition: color var(--transition);
    }

    .form-input {
        width: 100%;
        height: 44px;
        padding: 0 14px 0 42px;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        color: var(--text-primary);
        background: #f8fafc;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        outline: none;
        transition: all var(--transition);
    }

    .form-input:focus {
        border-color: var(--primary);
        background: #fff;
        box-shadow: 0 0 0 3px var(--primary-glow);
    }

    .form-input:focus + .input-icon,
    .input-wrapper:focus-within .input-icon {
        color: var(--primary);
    }

    .form-input.has-error {
        border-color: #EF4444;
    }

    .form-input::placeholder {
        color: var(--text-muted);
    }

    /* Password toggle */
    .input-wrapper .toggle-password {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: var(--text-muted);
        font-size: 17px;
        padding: 0;
        transition: color var(--transition);
    }

    .toggle-password:hover {
        color: var(--primary);
    }

    .form-error {
        font-size: 12px;
        color: #EF4444;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Remember + Forgot row */
    .form-options {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .remember-label {
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        font-size: 13px;
        color: var(--text-secondary);
        user-select: none;
    }

    .remember-label input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--primary);
        cursor: pointer;
    }

    .forgot-link {
        font-size: 13px;
        color: var(--primary-dark);
        font-weight: 500;
        text-decoration: none;
        transition: color var(--transition);
    }

    .forgot-link:hover {
        color: var(--primary);
        text-decoration: underline;
    }

    /* Submit button */
    .btn-login {
        width: 100%;
        height: 46px;
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        border: none;
        border-radius: var(--radius-sm);
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        letter-spacing: 0.3px;
        transition: all var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(0, 188, 212, 0.4);
        position: relative;
        overflow: hidden;
    }

    .btn-login::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.15), transparent);
        opacity: 0;
        transition: opacity var(--transition);
    }

    .btn-login:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0, 188, 212, 0.5);
    }

    .btn-login:hover::before {
        opacity: 1;
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .btn-login.loading {
        pointer-events: none;
        opacity: 0.8;
    }

    .spinner {
        width: 18px;
        height: 18px;
        border: 2px solid rgba(255,255,255,0.4);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 0.7s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* ── Responsive ─────────────────────────── */
    @media (max-width: 768px) {
        .login-wrapper {
            flex-direction: column;
        }

        .login-left {
            width: 100%;
            min-height: auto;
            padding: 24px 24px 32px;
            flex-direction: row;
            align-items: center;
            gap: 16px;
        }

        .left-illustration,
        .left-dots,
        .left-tagline,
        .left-version {
            display: none;
        }

        .left-logo {
            margin-bottom: 0;
        }

        .login-card {
            padding: 28px 24px;
        }
    }

    /* Card entrance animation */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .login-card {
        animation: fadeSlideUp 0.5s ease both;
    }
</style>
@endsection

@section('content')
<div class="login-wrapper">

    <!-- LEFT PANEL -->
    <div class="login-left">
        <div class="left-logo">
            <div class="logo-icon">
                <i class="ri-tools-line"></i>
            </div>
            <span class="logo-text">W-Track</span>
        </div>

        <div class="left-illustration">
            <svg viewBox="0 0 100 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Workshop shelf illustration -->
                <rect x="10" y="60" width="80" height="5" rx="2" fill="rgba(0,188,212,0.6)"/>
                <rect x="10" y="35" width="80" height="5" rx="2" fill="rgba(0,188,212,0.6)"/>
                <rect x="10" y="10" width="80" height="5" rx="2" fill="rgba(0,188,212,0.6)"/>
                <rect x="10" y="10" width="5" height="55" rx="2" fill="rgba(0,188,212,0.4)"/>
                <rect x="85" y="10" width="5" height="55" rx="2" fill="rgba(0,188,212,0.4)"/>
                <!-- Tools on shelves -->
                <rect x="20" y="48" width="10" height="12" rx="2" fill="rgba(0,188,212,0.5)"/>
                <rect x="35" y="51" width="8" height="9" rx="1.5" fill="rgba(255,255,255,0.3)"/>
                <rect x="48" y="46" width="12" height="14" rx="2" fill="rgba(0,188,212,0.4)"/>
                <circle cx="72" cy="53" r="5" fill="rgba(255,255,255,0.25)"/>
                <!-- Top shelf items -->
                <rect x="20" y="18" width="15" height="17" rx="2" fill="rgba(0,188,212,0.35)"/>
                <rect x="40" y="22" width="10" height="13" rx="2" fill="rgba(255,255,255,0.2)"/>
                <rect x="55" y="18" width="12" height="17" rx="2" fill="rgba(0,188,212,0.45)"/>
                <circle cx="75" cy="25" r="6" fill="rgba(255,255,255,0.2)"/>
            </svg>
        </div>

        <div class="left-dots"></div>

        <div class="left-tagline">
            <h2>Pendataan equipment keluar masuk <span>Workshop</span> dengan lebih mudah.</h2>
            <p>Pantau aset, status, lokasi, dan aktivitas pemeliharaan dalam satu tempat.</p>
        </div>

        <div class="left-version">Sistem Manajemen Equipment • v1.0</div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="login-right">
        <div class="login-card">
            <div class="login-card-header">
                <h1>Masuk ke akun</h1>
                <p>Gunakan akun Anda untuk melanjutkan.</p>
            </div>

            @if(session('error'))
                <div class="alert alert-error">
                    <i class="ri-error-warning-line"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="ri-checkbox-circle-line"></i>
                    {{ session('success') }}
                </div>
            @endif

            <form id="loginForm" method="POST" action="{{ route('login.post') }}" novalidate>
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <div class="input-wrapper">
                        <i class="ri-mail-line input-icon"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-input @error('email') has-error @enderror"
                            placeholder="nama@perusahaan.co.id"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            required
                        >
                    </div>
                    @error('email')
                        <div class="form-error">
                            <i class="ri-error-warning-line"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="ri-lock-line input-icon"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input @error('password') has-error @enderror"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                        >
                        <button type="button" class="toggle-password" id="togglePassword" aria-label="Tampilkan password">
                            <i class="ri-eye-off-line" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="form-error">
                            <i class="ri-error-warning-line"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Options -->
                <div class="form-options">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        Ingat saya
                    </label>
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-login" id="btnLogin">
                    <span id="btnText">Masuk</span>
                </button>
            </form>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    // Toggle password visibility
    const toggleBtn = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    toggleBtn.addEventListener('click', () => {
        const isHidden = passwordInput.type === 'password';
        passwordInput.type = isHidden ? 'text' : 'password';
        toggleIcon.className = isHidden ? 'ri-eye-line' : 'ri-eye-off-line';
    });

    // Loading state on form submit
    const loginForm = document.getElementById('loginForm');
    const btnLogin = document.getElementById('btnLogin');
    const btnText = document.getElementById('btnText');

    loginForm.addEventListener('submit', function (e) {
        btnLogin.classList.add('loading');
        btnText.textContent = 'Memproses...';
        btnLogin.innerHTML = '<div class="spinner"></div><span>Memproses...</span>';
    });
</script>
@endsection

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Kampung Tematik Malang</title>
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .nav-dropdown { position: relative; }
        .nav-item-trigger { background: transparent; border: none; cursor: pointer; }
        .nav-dropdown-menu {
            position: absolute;
            top: 48px;
            left: 0;
            min-width: 240px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.08);
            display: none;
            flex-direction: column;
            padding: 10px 0;
            z-index: 10;
        }
        .nav-dropdown.open .nav-dropdown-menu { display: flex; }
        .nav-dropdown-item { padding: 10px 14px; color: #4b5563; font-weight: 600; }
        .nav-dropdown-item:hover { background: #f4f6f9; }
        .arrow {
            margin-left: 6px;
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 6px solid #6b7280;
            transition: transform 0.15s ease, border-color 0.15s ease;
        }
        .arrow.up {
            border-top: 0;
            border-bottom: 6px solid #6b7280;
        }
    </style>
    @stack('styles')
</head>
<body class="admin-body">
    <div class="admin-topbar">
        <div class="topbar-inner">
            <button class="mobile-toggle" id="navToggle" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>

            <nav class="nav-desktop" aria-label="Main navigation">
                <a class="nav-item" href="{{ url('/') }}">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                    </span>
                    <span>View Website</span>
                </a>
                <a class="nav-item active" href="{{ route('admin.dashboard') }}">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7"></path><path d="M9 22V12h6v10"></path><path d="M21 22H3"></path><path d="M21 9v13"></path><path d="M3 22V9"></path></svg>
                    </span>
                    <span>Dashboard</span>
                </a>
                <a class="nav-item" href="{{ route('admin.pesanan.index') }}">
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2l-1 4H3.5a1.5 1.5 0 0 0-1.46 1.82l1.8 9A1.5 1.5 0 0 0 5.82 18h12.36a1.5 1.5 0 0 0 1.48-1.18l1.8-9A1.5 1.5 0 0 0 20.5 6H19l-1-4H6z"></path><path d="M9 9a3 3 0 1 0 6 0"></path></svg>
                    </span>
                    <span>Pesanan</span>
                </a>
                <div class="nav-dropdown">
                    <button class="nav-item nav-link dropdown-toggle arrow-none nav-item-trigger" type="button">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94L14.7 6.3Z"></path></svg>
                        </span>
                        <span>Konfigurasi</span>
                        <span class="arrow"></span>
                    </button>
                    <div class="nav-dropdown-menu">
                        <a href="{{ route('admin.berita.index') }}" class="nav-dropdown-item">Konfigurasi Berita & Rekomendasi Desa Wisata</a>
                        <a href="{{ route('admin.users.index') }}" class="nav-dropdown-item">Konfigurasi Pengguna</a>
                        <a href="{{ route('admin.methodpayments.index') }}" class="nav-dropdown-item">Konfigurasi Payment</a>
                        <a href="{{ route('admin.galeri.index') }}" class="nav-dropdown-item">Konfigurasi Event dan Galeri</a>
                    </div>
                </div>
            </nav>

            <div class="topbar-user">
                <button class="avatar-circle user-toggle" type="button" aria-label="User menu"></button>
                <div class="user-dropdown" id="desktopUserDropdown">
                    <div class="user-dropdown-header">Hallo Admin</div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="user-dropdown-item">
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            </span>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-header">
            <button class="mobile-toggle open" id="navClose" aria-label="Close menu">
                <span></span><span></span><span></span>
            </button>
            <button class="avatar-circle user-toggle" type="button" aria-label="User menu"></button>
            <div class="user-dropdown mobile" id="mobileUserDropdown">
                <div class="user-dropdown-header">Hallo Admin</div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="user-dropdown-item">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        </span>
                        Keluar
                    </button>
                </form>
            </div>
        </div>
        <div class="mobile-menu-body">
            <ul class="mobile-nav-list">
                <li class="mobile-nav-item">
                    <a href="{{ url('/') }}">
                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></span>
                        View Website
                    </a>
                </li>
                <li class="mobile-nav-item">
                    <a class="active" href="{{ route('admin.dashboard') }}">
                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7"></path><path d="M9 22V12h6v10"></path><path d="M21 22H3"></path><path d="M21 9v13"></path><path d="M3 22V9"></path></svg></span>
                        Dashboard
                    </a>
                </li>
                <li class="mobile-nav-item">
                    <a href="{{ route('admin.pesanan.index') }}">
                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2l-1 4H3.5a1.5 1.5 0 0 0-1.46 1.82l1.8 9A1.5 1.5 0 0 0 5.82 18h12.36a1.5 1.5 0 0 0 1.48-1.18l1.8-9A1.5 1.5 0 0 0 20.5 6H19l-1-4H6z"></path><path d="M9 9a3 3 0 1 0 6 0"></path></svg></span>
                        Pesanan
                    </a>
                </li>
                <li class="mobile-nav-item">
                    <a href="#"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"></path><path d="M3 6h18"></path><path d="M16 10a4 4 0 0 1-8 0"></path></svg></span>Pesanan</a>
                </li>
                                <li class="mobile-nav-item mobile-nav-group">
                    <button type="button" class="mobile-nav-trigger nav-link dropdown-toggle arrow-none">
                        <span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94L14.7 6.3Z"></path></svg></span>
                        Konfigurasi
                        <span class="arrow"></span>
                    </button>
                    <ul class="mobile-submenu">
                        <li><a href="{{ route('admin.berita.index') }}">Konfigurasi Berita & Rekomendasi Desa Wisata & Rekomendasi Desa Wisata</a></li>
                        <li><a href="{{ route('admin.users.index') }}">Konfigurasi Pengguna</a></li>
                        <li><a href="{{ route('admin.methodpayments.index') }}">Konfigurasi Payment</a></li>
                        <li><a href="{{ route('admin.galeri.index') }}">Konfigurasi Event dan Galeri</a></li>
                    </ul>
                </li>
                <li class="mobile-nav-item">
                    <button type="button"><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg></span>Produk <span class="chevron">▾</span></button>
                </li>
            </ul>
        </div>
    </div>

    <main class="admin-main">
        @yield('content')
    </main>

    @stack('scripts')
    <script src="{{ asset('js/admin-dashboard.js') }}"></script>
</body>
</html>

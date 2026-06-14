<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HematCuy - Atur Keuanganmu</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%233b82f6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4'/><path d='M4 6v12c0 1.1.9 2 2 2h14v-4'/><path d='M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z'/></svg>">
</head>
<body>
    <div class="app-container">
        <header class="app-header">
            <div class="logo header-item-logo">
                <span class="logo-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #60a5fa;"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z"/></svg>
                </span>
                <h1>HematCuy</h1>
            </div>

            <button class="mobile-menu-btn header-item-hamburger" onclick="document.getElementById('main-nav').classList.toggle('show')">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </button>

            <nav id="main-nav" class="nav-container header-item-nav">
            @auth
            <div class="nav-links">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dasbor</a>
                <a href="{{ route('report') }}" class="nav-link {{ request()->routeIs('report') ? 'active' : '' }}">Laporan</a>
                <a href="{{ route('notes.index') }}" class="nav-link {{ request()->routeIs('notes.*') ? 'active' : '' }}">Catatan</a>
                <a href="{{ route('splitbill.index') }}" class="nav-link {{ request()->routeIs('splitbill.*') ? 'active' : '' }}" style="display: flex; align-items: center; gap: 0.25rem;">
                    Bagi Tagihan <span style="background: rgba(167, 139, 250, 0.2); color: #a78bfa; font-size: 0.65rem; padding: 0.1rem 0.3rem; border-radius: 4px; font-weight: bold;">AI</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0; display: flex; align-items: center;" class="form-logout">
                    @csrf
                    <button type="submit" class="btn-logout" style="background: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.2); color: #f43f5e; padding: 0.4rem 0.8rem; border-radius: var(--radius-md); font-size: 0.85rem; cursor: pointer; transition: all 0.2s ease; display: flex; align-items: center; justify-content: center; width: 100%;">Logout</button>
                </form>
            </div>
            @else
            <div class="nav-guest">
                <a href="{{ route('login') }}" class="btn btn-guest" style="background: transparent; color: var(--text-main); border: 1px solid var(--border-color); text-decoration: none; width: auto; display: inline-flex; align-items: center; justify-content: center;">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-guest" style="text-decoration: none; width: auto; display: inline-flex; align-items: center; justify-content: center;">Daftar</a>
            </div>
            @endauth
            </nav>

            @auth
            <div class="header-item-user">
                <span style="color: var(--text-muted); font-size: 0.9rem;">Halo, {{ auth()->user()->name }}</span>
            </div>
            @endauth
        </header>

        <main class="app-main">
            @yield('content')
        </main>
    </div>
</body>
</html>

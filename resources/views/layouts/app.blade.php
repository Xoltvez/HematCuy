<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HematCuy - Atur Keuanganmu</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%233b82f6' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><path d='M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4'/><path d='M4 6v12c0 1.1.9 2 2 2h14v-4'/><path d='M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z'/></svg>">

    <!-- Flatpickr (Custom Datepicker) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
</head>

<body>
    <div class="app-layout">

        <!-- Mobile Sidebar Overlay -->
        <div class="sidebar-overlay" id="sidebar-overlay" onclick="document.getElementById('sidebar').classList.remove('open'); document.getElementById('sidebar-overlay').classList.remove('show');"></div>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <a href="{{ url('/') }}" class="logo">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4" />
                        <path d="M4 6v12c0 1.1.9 2 2 2h14v-4" />
                        <path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z" />
                    </svg>
                    <h1>HematCuy</h1>
                </a>
            </div>

            <nav class="sidebar-nav">
                <!-- MENU UTAMA -->
                <div class="nav-group">
                    <div class="nav-label">MENU UTAMA</div>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="7" height="9" x="3" y="3" rx="1" />
                            <rect width="7" height="5" x="14" y="3" rx="1" />
                            <rect width="7" height="9" x="14" y="12" rx="1" />
                            <rect width="7" height="5" x="3" y="16" rx="1" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('transactions.create') }}" class="nav-link {{ request()->routeIs('transactions.create') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                            <line x1="12" x2="12" y1="8" y2="16" />
                            <line x1="8" x2="16" y1="12" y2="12" />
                        </svg>
                        Catat Transaksi
                    </a>
                    <a href="{{ route('transactions.history') }}" class="nav-link {{ request()->routeIs('transactions.history') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                        Riwayat
                    </a>
                    <a href="{{ route('allocations.index') }}" class="nav-link {{ request()->routeIs('allocations.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12V7H5a2 2 0 0 1 0-4h14v4" />
                            <path d="M3 5v14a2 2 0 0 0 2 2h16v-5" />
                            <path d="M18 12a2 2 0 0 0 0 4h4v-4Z" />
                        </svg>
                        Budgeting
                    </a>
                    <a href="{{ route('report') }}" class="nav-link {{ request()->routeIs('report') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3v18h18" />
                            <path d="m19 9-5 5-4-4-3 3" />
                        </svg>
                        Laporan
                    </a>
                </div>

                <!-- MENU TAMBAHAN -->
                <div class="nav-group" style="margin-top: 1rem;">
                    <div class="nav-label">MENU LANJUTAN</div>
                    <a href="{{ route('target.index') }}" class="nav-link {{ request()->routeIs('target.index') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 2a10 10 0 0 1 10 10c0 5.5-4.5 10-10 10S2 17.5 2 12 6.5 2 12 2Z" />
                            <path d="M12 12v.01" />
                            <path d="M12 16v.01" />
                            <path d="M12 8v.01" />
                        </svg>
                        Target Harian
                    </a>
                    <a href="{{ route('wishlists.index') }}" class="nav-link {{ request()->routeIs('wishlists.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="14" x="2" y="5" rx="2" />
                            <line x1="2" x2="22" y1="10" y2="10" />
                        </svg>
                        Tabungan & Wishlist
                    </a>
                    <a href="{{ route('calendar') }}" class="nav-link {{ request()->routeIs('calendar') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        Kalender
                    </a>
                    <a href="{{ route('notes.index') }}" class="nav-link {{ request()->routeIs('notes.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" x2="8" y1="13" y2="13" />
                            <line x1="16" x2="8" y1="17" y2="17" />
                            <polyline points="10 9 9 9 8 9" />
                        </svg>
                        Catatan
                    </a>
                    <a href="{{ route('receipt.index') }}" class="nav-link {{ request()->routeIs('receipt.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1-2-1Z" />
                            <path d="M14 8H8" />
                            <path d="M16 12H8" />
                            <path d="M13 16H8" />
                        </svg>
                        Catat Struk
                    </a>
                </div>

                <!-- LANJUTAN -->
                <div class="nav-group" style="margin-top: 1rem;">
                    <div class="nav-label">LANJUTAN</div>
                    <a href="{{ route('settings.index') }}" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3" />
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                        </svg>
                        Pengaturan
                    </a>
                    <a href="{{ route('guide.index') }}" class="nav-link {{ request()->routeIs('guide.*') ? 'active' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                            <line x1="16" x2="16" y1="2" y2="6" />
                            <line x1="8" x2="8" y1="2" y2="6" />
                            <line x1="3" x2="21" y1="10" y2="10" />
                            <path d="M12 14v4" />
                            <path d="M12 14h.01" />
                        </svg>
                        Panduan
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">

            <!-- Top Header -->
            <header class="top-header">
                <div class="header-left" style="display: flex; align-items: center; gap: 1rem;">
                    <button class="mobile-toggle" onclick="document.getElementById('sidebar').classList.toggle('open'); document.getElementById('sidebar-overlay').classList.toggle('show');">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <!-- Global Date Indicator -->
                    <div id="top-date-indicator" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); padding: 0 1rem; height: 42px; border-radius: 12px; display: flex; align-items: center; gap: 0.5rem; box-sizing: border-box;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                        <span style="font-weight: 500; font-size: 0.85rem; color: #fff;">{{ now()->translatedFormat('d M Y') }}</span>
                    </div>
                </div>
                <!-- Global Search -->
                @auth
                <div class="header-center" id="search-bar-container" style="flex: 1; max-width: 400px; margin-left: 1rem; margin-right: auto; position: relative;">
                    <div style="position: relative; display: flex; align-items: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 1rem; color: var(--text-muted);">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" id="global-search-input" placeholder="Cari transaksi atau catatan..." style="width: 100%; height: 42px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 0 1rem 0 2.5rem; color: #fff; font-size: 0.85rem; outline: none; transition: all 0.2s; box-sizing: border-box;" onfocus="this.style.background='rgba(255, 255, 255, 0.1)'; this.style.borderColor='var(--accent-blue)';" onblur="this.style.background='rgba(255, 255, 255, 0.05)'; this.style.borderColor='rgba(255, 255, 255, 0.1)';">
                    </div>

                    <!-- Search Results Dropdown -->
                    <div id="global-search-results" style="display: none; position: absolute; top: 110%; left: 0; min-width: 300px; max-width: 90vw; background: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 0.5rem; box-shadow: 0 10px 30px -5px rgba(0,0,0,0.8); z-index: 70; max-height: 400px; overflow-y: auto;">
                        <div id="search-results-content"></div>
                        <div id="search-loading" style="display: none; text-align: center; padding: 1rem; color: var(--text-muted); font-size: 0.8rem;">Mencari...</div>
                        <div id="search-empty" style="display: none; text-align: center; padding: 1rem; color: var(--text-muted); font-size: 0.8rem;">Tidak ada hasil ditemukan.</div>
                    </div>
                </div>
                @endauth


                <div class="header-right" style="display: flex; gap: 1rem; align-items: center;">
                    <!-- Notification Bell -->
                    <div class="user-profile" style="position: relative; cursor: pointer;" onclick="document.getElementById('notif-dropdown').classList.toggle('show'); event.stopPropagation();">
                        <div class="btn-icon" style="position: relative;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9" />
                                <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0" />
                            </svg>
                            @if(isset($notifications) && count($notifications) > 0)
                            <div id="notif-indicator" style="display: none; position: absolute; top: 0px; right: 0px; width: 10px; height: 10px; background-color: #ef4444; border-radius: 50%; border: 2px solid var(--surface);"></div>
                            @endif
                        </div>

                        <!-- Notification Dropdown -->
                        <style>
                            @media (max-width: 768px) {
                                #top-date-indicator {
                                    display: none !important;
                                }
                                #search-bar-container {
                                    margin-left: 1rem !important;
                                    margin-right: 1rem !important;
                                }
                                #notif-dropdown {
                                    position: fixed !important;
                                    top: 70px !important;
                                    left: 50% !important;
                                    right: auto !important;
                                    transform: translateX(-50%) !important;
                                    width: 95vw !important;
                                    max-width: none !important;
                                }
                            }
                        </style>
                        <div id="notif-dropdown" class="profile-dropdown" style="display: none; position: absolute; top: 120%; right: -10px; background: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 1rem; width: 320px; max-width: 85vw; box-shadow: 0 10px 30px -5px rgba(0,0,0,0.8); z-index: 60;">
                            <div style="font-size: 0.85rem; font-weight: 700; color: #fff; margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
                                <div style="display: flex; align-items: center;">
                                    <span>Notifikasi</span>
                                    @if(isset($notifications) && count($notifications) > 0)
                                    <span id="notif-badge" style="display: none; background: rgba(239, 68, 68, 0.2); color: #ef4444; padding: 2px 8px; border-radius: 99px; font-size: 0.7rem; margin-left: 0.5rem;">{{ count($notifications) }} Baru</span>
                                    @endif
                                </div>
                                @if(isset($notifications) && count($notifications) > 0)
                                <button onclick="markNotifRead(event)" style="background: none; border: none; color: var(--text-muted); font-size: 0.75rem; cursor: pointer; padding: 0; outline: none;">Tandai sudah dibaca</button>
                                @endif
                            </div>

                            <div style="max-height: 300px; overflow-y: auto; padding-right: 0.5rem; display: flex; flex-direction: column; gap: 0.75rem;">
                                @if(isset($notifications) && count($notifications) > 0)
                                @foreach($notifications as $notif)
                                <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); padding: 0.75rem; border-radius: 8px;">
                                    <div style="display: flex; gap: 0.75rem;">
                                        <div style="width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; {{ $notif['type'] === 'alert' ? 'background: rgba(239, 68, 68, 0.1); color: #ef4444;' : 'background: rgba(245, 158, 11, 0.1); color: #f59e0b;' }}">
                                            @if($notif['type'] === 'alert')
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                            </svg>
                                            @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                                <line x1="3" y1="10" x2="21" y2="10"></line>
                                            </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <div style="font-size: 0.85rem; font-weight: 600; color: #fff; margin-bottom: 0.25rem;">{{ $notif['title'] }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem; line-height: 1.4;">{{ $notif['message'] }}</div>
                                            <a href="{{ $notif['action_url'] }}" style="font-size: 0.75rem; color: var(--accent-blue); text-decoration: none; font-weight: 600;">{{ $notif['action_text'] }} &rarr;</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div style="text-align: center; padding: 2rem 0; color: var(--text-muted); font-size: 0.85rem;">
                                    Tidak ada notifikasi saat ini.
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <script>
                        // Check if notification has been read today, if not, show the indicators
                        document.addEventListener('DOMContentLoaded', function() {
                            try {
                                const readDate = localStorage.getItem('hematcuy_notif_read_date');
                                const today = '{{ date("Y-m-d") }}';
                                if (readDate !== today) {
                                    const ind = document.getElementById('notif-indicator');
                                    const bdg = document.getElementById('notif-badge');
                                    if (ind) ind.style.display = 'block';
                                    if (bdg) bdg.style.display = 'inline-block';
                                }
                            } catch(e) {
                                console.error('Error checking notification status:', e);
                            }
                        });

                        function markNotifRead(event) {
                            if (event) event.stopPropagation();
                            const today = '{{ date("Y-m-d") }}';
                            localStorage.setItem('hematcuy_notif_read_date', today);
                            if (document.getElementById('notif-indicator')) document.getElementById('notif-indicator').style.display = 'none';
                            if (document.getElementById('notif-badge')) document.getElementById('notif-badge').style.display = 'none';
                        }
                    </script>

                    @auth
                    <div class="user-profile" style="position: relative; cursor: pointer;" onclick="document.getElementById('profile-dropdown').classList.toggle('show'); event.stopPropagation();">
                        <div class="user-avatar" style="overflow: hidden; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.05);">
                            @if(auth()->user()->profile_photo_path)
                                <img src="{{ asset(auth()->user()->profile_photo_path) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="user-info" style="display: none;">
                            <span class="user-name">{{ auth()->user()->name }}</span>
                            <span class="user-role">Member HematCuy</span>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted);">
                            <path d="m6 9 6 6 6-6" />
                        </svg>

                        <!-- Dropdown Menu -->
                        <div id="profile-dropdown" class="profile-dropdown" style="display: none; position: absolute; top: 120%; right: 0; background: #0f172a; border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 1.25rem; min-width: 240px; box-shadow: 0 10px 30px -5px rgba(0,0,0,0.8); z-index: 50;">

                            <div style="font-size: 0.7rem; font-weight: 700; color: var(--text-muted); letter-spacing: 1px; margin-bottom: 1rem; margin-top: 0.25rem;">PENGATURAN AKUN</div>

                            <a href="#" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: var(--text-main); margin-bottom: 1rem;">
                                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; color: var(--text-main);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                </div>
                                <span style="font-size: 0.95rem; font-weight: 500;">Profil Lengkap</span>
                            </a>

                            <a href="{{ route('password.change') }}" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: var(--text-main); margin-bottom: 1rem;">
                                <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; color: var(--text-main);">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                    </svg>
                                </div>
                                <span style="font-size: 0.95rem; font-weight: 500;">Ubah Password</span>
                            </a>

                            <div style="height: 1px; background: var(--border-color); margin: 1.25rem 0; width: 100%;"></div>

                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" style="width: 100%; text-align: left; background: none; border: none; cursor: pointer; color: #fb7185; display: flex; align-items: center; gap: 0.75rem;">
                                    <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.15); display: flex; align-items: center; justify-content: center; color: #fb7185;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                            <polyline points="16 17 21 12 16 7" />
                                            <line x1="21" x2="9" y1="12" y2="12" />
                                        </svg>
                                    </div>
                                    <span style="font-size: 0.95rem; font-weight: 500;">Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>

                    <style>
                        .profile-dropdown.show {
                            display: block !important;
                            animation: fadeIn 0.2s ease-out;
                        }

                        @keyframes fadeIn {
                            from {
                                opacity: 0;
                                transform: translateY(-5px);
                            }

                            to {
                                opacity: 1;
                                transform: translateY(0);
                            }
                        }
                    </style>

                    <script>
                        document.addEventListener('click', function(event) {
                            var notifDropdown = document.getElementById('notif-dropdown');
                            var profileDropdown = document.getElementById('profile-dropdown');
                            var searchDropdown = document.getElementById('global-search-results');
                            var searchInput = document.getElementById('global-search-input');

                            if (notifDropdown && !event.target.closest('#notif-dropdown') && !event.target.closest('.user-profile')) {
                                notifDropdown.classList.remove('show');
                            }
                            if (profileDropdown && !event.target.closest('#profile-dropdown') && !event.target.closest('.user-profile')) {
                                profileDropdown.classList.remove('show');
                            }
                            if (searchDropdown && searchInput && event.target !== searchInput && !event.target.closest('#global-search-results')) {
                                searchDropdown.style.display = 'none';
                            }
                        });

                        // Live Search Logic
                        const searchInput = document.getElementById('global-search-input');
                        const searchResults = document.getElementById('global-search-results');
                        const searchContent = document.getElementById('search-results-content');
                        const searchLoading = document.getElementById('search-loading');
                        const searchEmpty = document.getElementById('search-empty');
                        let searchTimeout = null;

                        if (searchInput) {
                            searchInput.addEventListener('focus', function() {
                                if (this.value.length >= 2) searchResults.style.display = 'block';
                            });

                            searchInput.addEventListener('input', function() {
                                const query = this.value;

                                if (query.length < 2) {
                                    searchResults.style.display = 'none';
                                    return;
                                }

                                searchResults.style.display = 'block';
                                searchContent.innerHTML = '';
                                searchEmpty.style.display = 'none';
                                searchLoading.style.display = 'block';

                                clearTimeout(searchTimeout);
                                searchTimeout = setTimeout(() => {
                                    fetch(`/search?q=${encodeURIComponent(query)}`)
                                        .then(response => response.json())
                                        .then(data => {
                                            searchLoading.style.display = 'none';
                                            searchContent.innerHTML = '';

                                            let hasResults = false;

                                            if (data.transactions && data.transactions.length > 0) {
                                                hasResults = true;
                                                searchContent.innerHTML += `<div style="font-size: 0.7rem; font-weight: 700; color: var(--text-muted); letter-spacing: 1px; margin: 0.5rem 0.5rem 0.25rem 0.5rem;">TRANSAKSI</div>`;
                                                data.transactions.forEach(t => {
                                                    const color = t.type === 'income' ? '#10b981' : '#ef4444';
                                                    searchContent.innerHTML += `
                                                        <a href="${t.url}" style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem; text-decoration: none; border-radius: 8px; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">
                                                            <div>
                                                                <div style="font-size: 0.85rem; font-weight: 600; color: #fff;">${t.title}</div>
                                                                <div style="font-size: 0.7rem; color: var(--text-muted);">${t.subtitle}</div>
                                                            </div>
                                                            <div style="font-size: 0.85rem; font-weight: 600; color: ${color};">${t.amount}</div>
                                                        </a>
                                                    `;
                                                });
                                            }

                                            if (data.notes && data.notes.length > 0) {
                                                hasResults = true;
                                                searchContent.innerHTML += `<div style="font-size: 0.7rem; font-weight: 700; color: var(--text-muted); letter-spacing: 1px; margin: 1rem 0.5rem 0.25rem 0.5rem;">CATATAN / UTANG</div>`;
                                                data.notes.forEach(n => {
                                                    searchContent.innerHTML += `
                                                        <a href="${n.url}" style="display: flex; justify-content: space-between; align-items: center; padding: 0.5rem; text-decoration: none; border-radius: 8px; transition: background 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.05)'" onmouseout="this.style.background='transparent'">
                                                            <div>
                                                                <div style="font-size: 0.85rem; font-weight: 600; color: #fff;">${n.title}</div>
                                                                <div style="font-size: 0.7rem; color: var(--text-muted);">${n.subtitle}</div>
                                                            </div>
                                                            <div style="font-size: 0.85rem; font-weight: 600; color: var(--text-main);">${n.amount}</div>
                                                        </a>
                                                    `;
                                                });
                                            }

                                            if (!hasResults) {
                                                searchEmpty.style.display = 'block';
                                            }
                                        })
                                        .catch(err => {
                                            searchLoading.style.display = 'none';
                                            searchEmpty.style.display = 'block';
                                            searchEmpty.innerText = 'Terjadi kesalahan jaringan.';
                                        });
                                }, 300);
                            });
                        }
                    </script>
                    @endauth
                </div>
            </header>

            <!-- Page Content -->
            <div class="content-area animate-fade-in-up">
                @yield('content')
            </div>

        </main>
    </div>

    <!-- For Mobile Sidebar Overlay -->
    <style>
        @media (min-width: 901px) {
            .user-info {
                display: flex !important;
            }
        }

        /* Custom tweaks for Flatpickr in our theme */
        .flatpickr-calendar.dark {
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
        }

        /* SweetAlert2 Glassmorphism Styling */
        div.swal2-popup.swal-custom-popup {
            background: rgba(15, 23, 42, 0.7) !important;
            backdrop-filter: blur(24px) !important;
            -webkit-backdrop-filter: blur(24px) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
            border-radius: var(--radius-xl) !important;
        }

        .swal-custom-title {
            color: #fff !important;
            font-weight: 700 !important;
        }

        div.swal2-html-container {
            color: var(--text-muted) !important;
        }

        button.swal2-confirm.swal-custom-confirm,
        button.swal2-cancel.swal-custom-cancel {
            border-radius: 9999px !important;
            font-weight: 600 !important;
            padding: 10px 24px !important;
            transition: all 0.2s ease !important;
        }

        button.swal2-confirm.swal-custom-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(244, 63, 94, 0.3) !important;
        }

        button.swal2-cancel.swal-custom-cancel:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(71, 85, 105, 0.3) !important;
        }
    </style>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("input[type=date], .custom-filter-date", {
                dateFormat: "Y-m-d",
                allowInput: true,
                disableMobile: "true", // Force use of flatpickr on mobile instead of native
                locale: "id"
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event, form, message = 'Hapus data ini?') {
            event.preventDefault();
            Swal.fire({
                title: 'Konfirmasi',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fb7185',
                cancelButtonColor: '#475569',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                borderRadius: '16px',
                customClass: {
                    popup: 'swal-custom-popup',
                    title: 'swal-custom-title',
                    confirmButton: 'swal-custom-confirm',
                    cancelButton: 'swal-custom-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
    <style>
        .swal-custom-popup {
            border-radius: 16px !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        .swal-custom-title {
            font-size: 1.25rem !important;
            font-weight: 700 !important;
        }

        .swal-custom-confirm {
            border-radius: 8px !important;
            font-weight: 600 !important;
        }

        .swal-custom-cancel {
            border-radius: 8px !important;
            font-weight: 600 !important;
        }
    </style>
    @if(!request()->routeIs('transactions.create'))
    <!-- Floating Action Button for Mobile -->
    <a href="{{ route('transactions.create') }}" class="mobile-fab" title="Catat Transaksi">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14" />
            <path d="M5 12h14" />
        </svg>
    </a>
    @endif
    @auth
    <!-- Idle Timeout Script -->
    <script>
        let idleTime = 0;
        const maxIdleTime = 15 * 60; // DISET 5 DETIK UNTUK TESTING (nanti kembalikan ke 15 * 60)

        function resetIdleTime() {
            idleTime = 0;
        }

        ['mousemove', 'keydown', 'mousedown', 'touchstart', 'scroll'].forEach(evt =>
            document.addEventListener(evt, resetIdleTime, {
                passive: true
            })
        );

        const idleInterval = setInterval(() => {
            idleTime++;

            if (idleTime >= maxIdleTime) {
                clearInterval(idleInterval);

                // Logout via AJAX
                fetch('{{ route("logout") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }).then(() => {
                    // Tampilkan Modal "Sesi Berakhir"
                    Swal.fire({
                        icon: 'info',
                        iconColor: '#3b82f6',
                        title: 'Sesi Berakhir',
                        text: 'Kamu otomatis keluar karena tidak ada aktivitas beberapa saat.',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3b82f6',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        background: '#1e293b',
                        color: '#ffffff',
                        customClass: {
                            popup: 'swal-custom-popup',
                            title: 'swal-custom-title',
                            confirmButton: 'swal-custom-confirm px-5 py-2'
                        }
                    }).then(() => {
                        window.location.href = '/login';
                    });
                }).catch(() => {
                    window.location.href = '/login';
                });
            }
        }, 1000);
    </script>
    @endauth

    @include('components.toast')
</body>

</html>
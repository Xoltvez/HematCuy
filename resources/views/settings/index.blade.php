@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding-bottom: 3rem;">
    
    <div style="margin-bottom: 2.5rem;">
        <h2 style="margin: 0; font-size: 2rem; font-weight: 800; letter-spacing: -0.5px; background: linear-gradient(135deg, #fff, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Pengaturan</h2>
        <p style="color: var(--text-muted); font-size: 1rem; margin-top: 0.5rem;">Sesuaikan preferensi aplikasi agar lebih personal dan nyaman.</p>
    </div>

    <div class="settings-layout">
        <!-- Floating Island Sidebar -->
        <div class="settings-sidebar">
            <ul id="settings-menu" style="list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 0.5rem;">
                <li>
                    <button class="settings-tab-btn active" data-target="profil">
                        <div class="icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        Profil
                    </button>
                </li>
                <li>
                    <button class="settings-tab-btn" data-target="notifikasi">
                        <div class="icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        </div>
                        Notifikasi
                    </button>
                </li>
                <li>
                    <button class="settings-tab-btn" data-target="tampilan">
                        <div class="icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        </div>
                        Tampilan
                    </button>
                </li>
                <li>
                    <button class="settings-tab-btn" data-target="bantuan">
                        <div class="icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        </div>
                        Bantuan
                    </button>
                </li>
                <li>
                    <button class="settings-tab-btn" data-target="tentang">
                        <div class="icon-wrapper">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        </div>
                        Tentang
                    </button>
                </li>
            </ul>
        </div>

        <!-- Konten Pengaturan -->
        <div class="settings-content-area">
            
            <!-- Profil Content -->
            <div id="profil-content" class="settings-content active">
                <div class="settings-card profile-card">
                    <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.25rem;">Informasi Akun</h3>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label class="settings-label">Nama Lengkap</label>
                        <input type="text" class="form-control settings-input" value="{{ auth()->user()->name }}" disabled>
                    </div>

                    <div style="margin-bottom: 2rem;">
                        <label class="settings-label">Alamat Email</label>
                        <input type="email" class="form-control settings-input" value="{{ auth()->user()->email }}" disabled>
                    </div>

                    <a href="{{ route('password.change') }}" class="btn btn-outline" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Ubah Password
                    </a>
                </div>
            </div>

            <!-- Notifikasi Content -->
            <div id="notifikasi-content" class="settings-content">
                
                <div class="settings-card toggle-card">
                    <div class="card-text">
                        <h4>Pengingat batas anggaran harian</h4>
                        <p>Notifikasi saat pengeluaran mendekati atau melewati batas harian.</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="settings-card toggle-card">
                    <div class="card-text">
                        <h4>Notifikasi laporan mingguan</h4>
                        <p>Pemberitahuan ringkasan keuangan setiap akhir pekan.</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="settings-card toggle-card">
                    <div class="card-text">
                        <h4>Notifikasi via email</h4>
                        <p>Kirim ringkasan laporan dan peringatan melalui email.</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <!-- Tampilan Content -->
            <div id="tampilan-content" class="settings-content">
                <div class="settings-card toggle-card">
                    <div class="card-text">
                        <h4>Mode Gelap (Dark Mode)</h4>
                        <p>Gunakan tema gelap agar lebih nyaman di mata.</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked disabled>
                        <span class="slider"></span>
                    </label>
                </div>
                <p style="color: var(--text-muted); font-size: 0.85rem; margin-top: 1rem; padding: 0 0.5rem;">
                    * Mode terang (Light Mode) sedang dalam tahap pengembangan dan akan segera hadir.
                </p>
            </div>

            <!-- Bantuan Content -->
            <div id="bantuan-content" class="settings-content">
                <div class="settings-card center-card">
                    <div class="big-icon blue-glow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    </div>
                    <h3>Butuh Bantuan?</h3>
                    <p>Temukan jawaban dari pertanyaan Anda di Pusat Panduan kami yang lengkap dan interaktif.</p>
                    <a href="{{ route('guide.index') }}" class="btn btn-primary" style="text-decoration: none;">Lihat Pusat Panduan</a>
                </div>
            </div>

            <!-- Tentang Content -->
            <div id="tentang-content" class="settings-content">
                <div class="settings-card center-card">
                    <div class="big-icon blue-glow" style="margin-bottom: 1.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z"/></svg>
                    </div>
                    <h3 style="font-size: 1.75rem;">HematCuy.</h3>
                    <div class="version-badge">Versi 1.0.0 (BETA)</div>
                    <p style="max-width: 400px; margin: 0 auto 2rem auto;">Aplikasi pencatatan keuangan cerdas yang membantu Anda melacak pengeluaran dan mencapai target finansial impian Anda.</p>
                    <div class="copyright">&copy; {{ date('Y') }} HematCuy. Hak Cipta Dilindungi.</div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Layout */
    .settings-layout {
        display: flex;
        gap: 2.5rem;
        align-items: flex-start;
    }
    
    /* Sidebar Floating Island */
    .settings-sidebar {
        width: 260px;
        flex-shrink: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius-xl);
        padding: 1rem;
        position: sticky;
        top: 2rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }
    
    .settings-tab-btn {
        width: 100%;
        text-align: left;
        padding: 0.85rem 1rem;
        border-radius: var(--radius-md);
        border: 1px solid transparent;
        background: transparent;
        color: var(--text-muted);
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .settings-tab-btn .icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
    }
    
    .settings-tab-btn:hover:not(.active) {
        background: rgba(255, 255, 255, 0.03);
        color: var(--text-main);
    }
    
    .settings-tab-btn:hover:not(.active) .icon-wrapper {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }
    
    .settings-tab-btn.active {
        background: rgba(59, 130, 246, 0.1);
        border-color: rgba(59, 130, 246, 0.3);
        color: #fff;
        box-shadow: inset 0 0 20px rgba(59, 130, 246, 0.05);
    }
    
    .settings-tab-btn.active .icon-wrapper {
        background: #3b82f6;
        color: #fff;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    /* Content Area */
    .settings-content-area {
        flex: 1;
        min-width: 0;
        position: relative;
    }
    
    .settings-content {
        display: none;
        animation: fadeSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    
    .settings-content.active {
        display: block;
    }
    
    @keyframes fadeSlideUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Cards */
    .settings-card {
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius-xl);
        padding: 1.75rem;
        margin-bottom: 1rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
    }
    
    .settings-card:hover {
        border-color: rgba(255, 255, 255, 0.15);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
    }
    
    .profile-card {
        padding: 2.5rem;
    }
    
    .toggle-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .center-card {
        padding: 4rem 2rem;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    
    .card-text h4 {
        margin: 0 0 0.35rem 0;
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--text-main);
    }
    
    .card-text p {
        margin: 0;
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    /* Form Elements */
    .settings-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
        margin-bottom: 0.75rem;
    }
    
    .settings-input {
        width: 100%;
        padding: 0.85rem 1.2rem;
        border-radius: var(--radius-md);
        border: 1px solid rgba(255, 255, 255, 0.1);
        background: rgba(255, 255, 255, 0.02);
        color: var(--text-main);
        font-size: 1rem;
        transition: all 0.2s;
    }
    
    .settings-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        outline: none;
    }

    .btn-outline {
        background: rgba(255,255,255,0.05);
        color: var(--text-main);
        border: 1px solid rgba(255,255,255,0.1);
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        transition: all 0.2s;
        text-decoration: none;
    }
    
    .btn-outline:hover {
        background: rgba(255,255,255,0.1);
        border-color: rgba(255,255,255,0.2);
    }

    /* Toggle Switch */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 30px;
        flex-shrink: 0;
    }
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.1);
        transition: .4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 34px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 3px;
        bottom: 3px;
        background-color: #94a3b8;
        transition: .4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    input:checked + .slider {
        background-color: rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.4);
    }
    input:checked + .slider:before {
        transform: translateX(22px);
        background-color: #3b82f6;
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.6);
    }
    input:disabled + .slider {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .toggle-switch:active .slider:before {
        width: 28px;
    }
    .toggle-switch input:checked:active + .slider:before {
        transform: translateX(16px);
    }

    /* Utilities */
    .big-icon {
        color: #3b82f6;
        margin-bottom: 1.25rem;
    }
    
    .blue-glow {
        filter: drop-shadow(0 0 12px rgba(59, 130, 246, 0.4));
    }
    
    .version-badge {
        display: inline-block;
        background: rgba(59, 130, 246, 0.1);
        color: #60a5fa;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }
    
    .copyright {
        font-size: 0.85rem;
        color: #475569;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .settings-layout {
            flex-direction: column;
        }
        .settings-sidebar {
            width: 100%;
            position: static;
        }
        .settings-tab-btn {
            padding: 0.75rem;
        }
        .toggle-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.settings-tab-btn');
        const contents = document.querySelectorAll('.settings-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active classes
                tabBtns.forEach(b => b.classList.remove('active'));
                contents.forEach(c => c.classList.remove('active'));

                // Add active class to clicked button
                this.classList.add('active');

                // Show target content
                const targetId = this.getAttribute('data-target') + '-content';
                document.getElementById(targetId).classList.add('active');
            });
        });
    });
</script>
@endsection

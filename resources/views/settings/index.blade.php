@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding-bottom: 5rem;">
    
    <div style="margin-bottom: 3rem; text-align: center;">
        <h2 style="margin: 0; font-size: 2.25rem; font-weight: 800; letter-spacing: -0.5px; background: linear-gradient(135deg, #fff, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Pengaturan</h2>
        <p style="color: var(--text-muted); font-size: 1.05rem; margin-top: 0.5rem;">Sesuaikan preferensi Anda dengan mudah.</p>
    </div>

    <!-- Accordion Container -->
    <div class="accordion-container">

        <!-- Accordion Item: Profil -->
        <div class="accordion-item" id="acc-profil">
            <button class="accordion-header" aria-expanded="false">
                <div class="acc-title-group">
                    <div class="acc-icon blue">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <span>Profil Akun</span>
                </div>
                <div class="acc-chevron">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </button>
            <div class="accordion-content">
                <div class="accordion-content-inner">
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
        </div>

        <!-- Accordion Item: Notifikasi -->
        <div class="accordion-item" id="acc-notif">
            <button class="accordion-header" aria-expanded="false">
                <div class="acc-title-group">
                    <div class="acc-icon yellow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    </div>
                    <span>Notifikasi</span>
                </div>
                <div class="acc-chevron">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </button>
            <div class="accordion-content">
                <div class="accordion-content-inner">
                    <div class="toggle-card">
                        <div class="card-text">
                            <h4>Pengingat batas anggaran harian</h4>
                            <p>Notifikasi saat pengeluaran mendekati atau melewati batas harian.</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="toggle-card">
                        <div class="card-text">
                            <h4>Notifikasi laporan mingguan</h4>
                            <p>Pemberitahuan ringkasan keuangan setiap akhir pekan.</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="toggle-card">
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
            </div>
        </div>

        <!-- Accordion Item: Tampilan -->
        <div class="accordion-item" id="acc-tampilan">
            <button class="accordion-header" aria-expanded="false">
                <div class="acc-title-group">
                    <div class="acc-icon purple">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    </div>
                    <span>Tampilan</span>
                </div>
                <div class="acc-chevron">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </button>
            <div class="accordion-content">
                <div class="accordion-content-inner">
                    <div class="toggle-card">
                        <div class="card-text">
                            <h4>Mode Gelap (Dark Mode)</h4>
                            <p>Gunakan tema gelap agar lebih nyaman di mata.</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" checked disabled>
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="alert-box">
                        * Mode terang (Light Mode) sedang dalam tahap pengembangan dan akan segera hadir.
                    </div>
                </div>
            </div>
        </div>

        <!-- Accordion Item: Bantuan -->
        <div class="accordion-item" id="acc-bantuan">
            <button class="accordion-header" aria-expanded="false">
                <div class="acc-title-group">
                    <div class="acc-icon green">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    </div>
                    <span>Pusat Bantuan</span>
                </div>
                <div class="acc-chevron">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </button>
            <div class="accordion-content">
                <div class="accordion-content-inner">
                    <div class="center-content">
                        <h3 style="font-size: 1.25rem; margin-bottom: 0.5rem; color: #fff;">Ada Kendala?</h3>
                        <p style="color: var(--text-muted); margin-bottom: 1.5rem; max-width: 80%; margin-left: auto; margin-right: auto;">Temukan jawaban dari pertanyaan Anda di Pusat Panduan kami yang lengkap dan interaktif.</p>
                        <a href="{{ route('guide.index') }}" class="btn btn-primary" style="text-decoration: none;">Buka Pusat Panduan</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Accordion Item: Tentang -->
        <div class="accordion-item" id="acc-tentang">
            <button class="accordion-header" aria-expanded="false">
                <div class="acc-title-group">
                    <div class="acc-icon pink">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                    </div>
                    <span>Tentang Aplikasi</span>
                </div>
                <div class="acc-chevron">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
                </div>
            </button>
            <div class="accordion-content">
                <div class="accordion-content-inner">
                    <div class="center-content">
                        <h3 style="font-size: 1.5rem; margin-bottom: 0.25rem; color: #fff;">HematCuy.</h3>
                        <div class="version-badge">Versi 1.0.0 (BETA)</div>
                        <p style="color: var(--text-muted); line-height: 1.6; margin-bottom: 1.5rem; max-width: 80%; margin-left: auto; margin-right: auto;">Aplikasi pencatatan keuangan cerdas yang membantu Anda melacak pengeluaran dan mencapai target finansial impian Anda.</p>
                        <div class="copyright">&copy; {{ date('Y') }} HematCuy. Hak Cipta Dilindungi.</div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    /* Accordion Container */
    .accordion-container {
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    /* Accordion Item */
    .accordion-item {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .accordion-item:last-child {
        border-bottom: none;
    }

    /* Accordion Header */
    .accordion-header {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        background: transparent;
        border: none;
        cursor: pointer;
        color: #fff;
        font-size: 1.05rem;
        font-weight: 500;
        transition: background-color 0.2s;
    }

    .accordion-header:hover {
        background-color: rgba(255, 255, 255, 0.02);
    }
    
    .accordion-header[aria-expanded="true"] {
        background-color: rgba(255, 255, 255, 0.03);
    }

    .acc-title-group {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .acc-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .acc-icon.blue { background: rgba(59, 130, 246, 0.15); color: #60a5fa; }
    .acc-icon.yellow { background: rgba(234, 179, 8, 0.15); color: #facc15; }
    .acc-icon.purple { background: rgba(168, 85, 247, 0.15); color: #c084fc; }
    .acc-icon.green { background: rgba(34, 197, 94, 0.15); color: #4ade80; }
    .acc-icon.pink { background: rgba(236, 72, 153, 0.15); color: #f472b6; }

    .acc-chevron {
        color: var(--text-muted);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
    }

    /* Active State Rotation */
    .accordion-header[aria-expanded="true"] .acc-chevron {
        transform: rotate(180deg);
        color: #fff;
    }

    /* Accordion Content */
    .accordion-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background-color: rgba(0, 0, 0, 0.15);
    }

    .accordion-content-inner {
        padding: 1.5rem 2rem 2rem 4rem; /* Indented padding to align with text */
    }

    @media (max-width: 600px) {
        .accordion-content-inner {
            padding: 1.25rem 1.25rem 1.5rem 1.25rem;
        }
    }

    /* Form & UI Elements inside accordion */
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

    .toggle-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 1.25rem;
        margin-bottom: 1.25rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .toggle-card:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .card-text h4 {
        margin: 0 0 0.25rem 0;
        font-size: 0.95rem;
        font-weight: 600;
        color: #fff;
    }
    
    .card-text p {
        margin: 0;
        font-size: 0.85rem;
        color: var(--text-muted);
        line-height: 1.5;
        max-width: 90%;
    }

    /* Toggle Switch */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 26px;
        flex-shrink: 0;
    }
    .toggle-switch input { opacity: 0; width: 0; height: 0; }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: rgba(255, 255, 255, 0.1);
        transition: .4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 34px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
    .slider:before {
        position: absolute; content: "";
        height: 18px; width: 18px;
        left: 3px; bottom: 3px;
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
    input:disabled + .slider { opacity: 0.5; cursor: not-allowed; }

    .center-content { text-align: center; }

    .version-badge {
        display: inline-block;
        background: rgba(236, 72, 153, 0.1);
        color: #f472b6;
        padding: 0.2rem 0.6rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-bottom: 1rem;
        border: 1px solid rgba(236, 72, 153, 0.2);
    }

    .alert-box {
        background: rgba(255, 255, 255, 0.03);
        border: 1px dashed rgba(255,255,255,0.1);
        padding: 1rem;
        border-radius: 12px;
        color: var(--text-muted);
        font-size: 0.85rem;
        text-align: center;
    }
    
    .copyright {
        font-size: 0.85rem;
        color: #475569;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const headers = document.querySelectorAll('.accordion-header');

        // Optional: Open the first one by default
        if(headers.length > 0) {
            const firstHeader = headers[0];
            const firstContent = firstHeader.nextElementSibling;
            firstHeader.setAttribute('aria-expanded', 'true');
            firstContent.style.maxHeight = firstContent.scrollHeight + 'px';
        }

        headers.forEach(header => {
            header.addEventListener('click', function() {
                const content = this.nextElementSibling;
                const isExpanded = this.getAttribute('aria-expanded') === 'true';

                // Close all other accordions (Optional, comment out if you want multiple open)
                document.querySelectorAll('.accordion-header').forEach(otherHeader => {
                    if (otherHeader !== this) {
                        otherHeader.setAttribute('aria-expanded', 'false');
                        otherHeader.nextElementSibling.style.maxHeight = null;
                    }
                });

                // Toggle the clicked one
                if (isExpanded) {
                    this.setAttribute('aria-expanded', 'false');
                    content.style.maxHeight = null;
                } else {
                    this.setAttribute('aria-expanded', 'true');
                    content.style.maxHeight = content.scrollHeight + 'px';
                }
            });
        });
        
        // Window resize handler to fix maxHeight if screen size changes
        window.addEventListener('resize', function() {
            document.querySelectorAll('.accordion-header[aria-expanded="true"]').forEach(header => {
                const content = header.nextElementSibling;
                // Temporarily set to auto to get new height
                content.style.maxHeight = 'none';
                const newHeight = content.scrollHeight;
                content.style.maxHeight = newHeight + 'px';
            });
        });
    });
</script>
@endsection

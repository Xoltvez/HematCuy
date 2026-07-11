@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding-bottom: 5rem;">
    
    <div style="margin-bottom: 2.5rem; text-align: center;">
        <h2 style="margin: 0; font-size: 2.25rem; font-weight: 800; letter-spacing: -0.5px; background: linear-gradient(135deg, #fff, #94a3b8); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Pengaturan</h2>
        <p style="color: var(--text-muted); font-size: 1.05rem; margin-top: 0.5rem;">Pusat kendali personalisasi akun dan preferensi Anda.</p>
    </div>

    <!-- Bento Grid Layout -->
    <div class="bento-grid">
        
        <!-- Profil Card (Bigger) -->
        <div class="bento-item bento-large" data-modal="profil-modal">
            <div class="bento-bg profile-bg"></div>
            <div class="bento-content">
                <div class="icon-circle blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
                <h3>Profil Akun</h3>
                <p>Kelola informasi pribadi, email, dan ubah password Anda di sini.</p>
            </div>
            <div class="bento-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </div>
        </div>

        <!-- Notifikasi Card -->
        <div class="bento-item" data-modal="notifikasi-modal">
            <div class="bento-bg notif-bg"></div>
            <div class="bento-content">
                <div class="icon-circle yellow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                </div>
                <h3>Notifikasi</h3>
                <p>Atur pengingat anggaran harian & laporan.</p>
            </div>
        </div>

        <!-- Tampilan Card -->
        <div class="bento-item" data-modal="tampilan-modal">
            <div class="bento-bg theme-bg"></div>
            <div class="bento-content">
                <div class="icon-circle purple">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <h3>Tampilan</h3>
                <p>Ubah tema gelap, warna & antarmuka.</p>
            </div>
        </div>

        <!-- Bantuan Card -->
        <div class="bento-item" data-modal="bantuan-modal">
            <div class="bento-content">
                <div class="icon-circle green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <h3>Bantuan</h3>
                <p>Pusat panduan dan FAQ interaktif.</p>
            </div>
        </div>

        <!-- Tentang Card -->
        <div class="bento-item" data-modal="tentang-modal">
            <div class="bento-content">
                <div class="icon-circle pink">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                </div>
                <h3>Tentang</h3>
                <p>Versi aplikasi & info developer.</p>
            </div>
        </div>

    </div>
</div>

<!-- MODAL OVERLAY -->
<div class="modal-overlay" id="settingsModal">
    <div class="modal-container">
        
        <!-- Modal Header -->
        <div class="modal-header">
            <h3 id="modalTitle">Pengaturan</h3>
            <button class="modal-close" id="closeModalBtn">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>

        <!-- Modal Body Content Container -->
        <div class="modal-body">
            
            <!-- Profil Modal -->
            <div id="profil-modal" class="modal-content-panel">
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

            <!-- Notifikasi Modal -->
            <div id="notifikasi-modal" class="modal-content-panel">
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

            <!-- Tampilan Modal -->
            <div id="tampilan-modal" class="modal-content-panel">
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

            <!-- Bantuan Modal -->
            <div id="bantuan-modal" class="modal-content-panel">
                <div class="center-content">
                    <div class="icon-circle green" style="width: 64px; height: 64px; margin: 0 auto 1.5rem auto;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    </div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 0.5rem;">Butuh Bantuan?</h3>
                    <p style="color: var(--text-muted); margin-bottom: 2rem;">Temukan jawaban dari pertanyaan Anda di Pusat Panduan kami yang lengkap dan interaktif.</p>
                    <a href="{{ route('guide.index') }}" class="btn btn-primary" style="text-decoration: none;">Lihat Pusat Panduan</a>
                </div>
            </div>

            <!-- Tentang Modal -->
            <div id="tentang-modal" class="modal-content-panel">
                <div class="center-content">
                    <div class="icon-circle pink" style="width: 64px; height: 64px; margin: 0 auto 1.5rem auto;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z"/></svg>
                    </div>
                    <h3 style="font-size: 1.75rem; margin-bottom: 0.25rem;">HematCuy.</h3>
                    <div class="version-badge">Versi 1.0.0 (BETA)</div>
                    <p style="color: var(--text-muted); line-height: 1.6; margin-bottom: 2rem;">Aplikasi pencatatan keuangan cerdas yang membantu Anda melacak pengeluaran dan mencapai target finansial impian Anda.</p>
                    <div class="copyright">&copy; {{ date('Y') }} HematCuy. Hak Cipta Dilindungi.</div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Bento Grid */
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        max-width: 900px;
        margin: 0 auto;
    }
    
    .bento-item {
        background: rgba(15, 23, 42, 0.4);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        padding: 1.75rem;
        position: relative;
        overflow: hidden;
        cursor: pointer;
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease, border-color 0.4s ease;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        min-height: 200px;
    }
    
    .bento-item:hover {
        transform: translateY(-5px) scale(1.02);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.25);
        border-color: rgba(255, 255, 255, 0.15);
        z-index: 2;
    }

    .bento-large {
        grid-column: span 2;
        min-height: 220px;
    }

    .bento-content {
        position: relative;
        z-index: 2;
    }

    .bento-item h3 {
        margin: 0 0 0.5rem 0;
        font-size: 1.25rem;
        color: #fff;
    }

    .bento-large h3 {
        font-size: 1.5rem;
    }

    .bento-item p {
        margin: 0;
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.5;
    }

    .bento-arrow {
        position: absolute;
        top: 1.75rem;
        right: 1.75rem;
        color: var(--text-muted);
        opacity: 0;
        transform: translateX(-10px);
        transition: all 0.3s ease;
    }

    .bento-item:hover .bento-arrow {
        opacity: 1;
        transform: translateX(0);
        color: #fff;
    }

    /* Bento Background Gradients */
    .bento-bg {
        position: absolute;
        top: 0;
        right: 0;
        width: 150px;
        height: 150px;
        border-radius: 50%;
        filter: blur(40px);
        opacity: 0.15;
        z-index: 1;
        transition: opacity 0.5s ease;
    }
    
    .bento-item:hover .bento-bg {
        opacity: 0.3;
    }

    .profile-bg { background: #3b82f6; right: -50px; top: -50px; width: 250px; height: 250px; }
    .notif-bg { background: #eab308; top: -30px; right: -30px; }
    .theme-bg { background: #a855f7; top: -30px; right: -30px; }

    /* Icons */
    .icon-circle {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .icon-circle.blue { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2); }
    .icon-circle.yellow { background: rgba(234, 179, 8, 0.15); color: #facc15; border: 1px solid rgba(234, 179, 8, 0.2); }
    .icon-circle.purple { background: rgba(168, 85, 247, 0.15); color: #c084fc; border: 1px solid rgba(168, 85, 247, 0.2); }
    .icon-circle.green { background: rgba(34, 197, 94, 0.15); color: #4ade80; border: 1px solid rgba(34, 197, 94, 0.2); }
    .icon-circle.pink { background: rgba(236, 72, 153, 0.15); color: #f472b6; border: 1px solid rgba(236, 72, 153, 0.2); }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(2, 6, 23, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        padding: 1rem;
    }

    .modal-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .modal-container {
        background: #0f172a;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 24px;
        width: 100%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        transform: scale(0.9) translateY(20px);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
    }

    .modal-overlay.show .modal-container {
        transform: scale(1) translateY(0);
        opacity: 1;
    }

    .modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        position: sticky;
        top: 0;
        background: rgba(15, 23, 42, 0.9);
        backdrop-filter: blur(8px);
        z-index: 10;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 700;
        color: #fff;
    }

    .modal-close {
        background: rgba(255,255,255,0.05);
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.2s;
    }

    .modal-close:hover {
        background: rgba(255,255,255,0.1);
        color: #fff;
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-content-panel {
        display: none;
        animation: fadeIn 0.3s ease forwards;
    }

    .modal-content-panel.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Forms & Utilities within Modal */
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
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .toggle-card:last-child {
        border-bottom: none;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .card-text h4 {
        margin: 0 0 0.35rem 0;
        font-size: 1rem;
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

    /* Toggle Switch (reused) */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 28px;
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
        height: 20px; width: 20px;
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
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
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

    /* Responsive */
    @media (max-width: 768px) {
        .bento-grid {
            grid-template-columns: 1fr;
        }
        .bento-large {
            grid-column: span 1;
        }
        .modal-body {
            padding: 1.5rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bentoItems = document.querySelectorAll('.bento-item');
        const modalOverlay = document.getElementById('settingsModal');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modalTitle = document.getElementById('modalTitle');
        const modalPanels = document.querySelectorAll('.modal-content-panel');

        // Open Modal
        bentoItems.forEach(item => {
            item.addEventListener('click', function() {
                const targetModalId = this.getAttribute('data-modal');
                const titleText = this.querySelector('h3').innerText;

                // Update Title
                modalTitle.innerText = titleText;

                // Hide all panels, show target panel
                modalPanels.forEach(panel => panel.classList.remove('active'));
                const targetPanel = document.getElementById(targetModalId);
                if(targetPanel) {
                    targetPanel.classList.add('active');
                }

                // Show Overlay
                modalOverlay.classList.add('show');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            });
        });

        // Close Modal functions
        function closeModal() {
            modalOverlay.classList.remove('show');
            document.body.style.overflow = '';
            
            // Wait for transition before hiding panels completely
            setTimeout(() => {
                modalPanels.forEach(panel => panel.classList.remove('active'));
            }, 300);
        }

        closeModalBtn.addEventListener('click', closeModal);

        // Close when clicking outside container
        modalOverlay.addEventListener('click', function(e) {
            if (e.target === modalOverlay) {
                closeModal();
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modalOverlay.classList.contains('show')) {
                closeModal();
            }
        });
    });
</script>
@endsection

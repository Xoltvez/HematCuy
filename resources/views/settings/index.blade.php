@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">
    
    <div style="margin-bottom: 2rem;">
        <h2 style="margin: 0; font-size: 1.75rem; font-weight: 700;">Pengaturan</h2>
        <p style="color: var(--text-muted); font-size: 0.95rem; margin-top: 0.5rem;">Kelola preferensi dan profil akun Anda di sini.</p>
    </div>

    <div style="display: flex; gap: 2rem; flex-wrap: wrap;">
        <!-- Sidebar Menu Pengaturan -->
        <div style="width: 250px; flex-shrink: 0; background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 1rem;">
            <ul id="settings-menu" style="list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; gap: 0.5rem;">
                <li>
                    <button class="settings-tab-btn" data-target="profil" style="width: 100%; text-align: left; padding: 0.8rem 1rem; border-radius: var(--radius-md); border: none; background: transparent; color: var(--text-muted); cursor: pointer; font-size: 0.95rem; font-weight: 500; transition: all 0.2s;">
                        Profil
                    </button>
                </li>
                <li>
                    <button class="settings-tab-btn active" data-target="notifikasi" style="width: 100%; text-align: left; padding: 0.8rem 1rem; border-radius: var(--radius-md); border: none; background: #3b82f6; color: #fff; cursor: pointer; font-size: 0.95rem; font-weight: 500; transition: all 0.2s;">
                        Notifikasi
                    </button>
                </li>
                <li>
                    <button class="settings-tab-btn" data-target="tampilan" style="width: 100%; text-align: left; padding: 0.8rem 1rem; border-radius: var(--radius-md); border: none; background: transparent; color: var(--text-muted); cursor: pointer; font-size: 0.95rem; font-weight: 500; transition: all 0.2s;">
                        Tampilan
                    </button>
                </li>
                <li>
                    <button class="settings-tab-btn" data-target="bantuan" style="width: 100%; text-align: left; padding: 0.8rem 1rem; border-radius: var(--radius-md); border: none; background: transparent; color: var(--text-muted); cursor: pointer; font-size: 0.95rem; font-weight: 500; transition: all 0.2s;">
                        Bantuan
                    </button>
                </li>
                <li>
                    <button class="settings-tab-btn" data-target="tentang" style="width: 100%; text-align: left; padding: 0.8rem 1rem; border-radius: var(--radius-md); border: none; background: transparent; color: var(--text-muted); cursor: pointer; font-size: 0.95rem; font-weight: 500; transition: all 0.2s;">
                        Tentang
                    </button>
                </li>
            </ul>
        </div>

        <!-- Konten Pengaturan -->
        <div style="flex: 1; min-width: 300px;">
            
            <!-- Profil Content -->
            <div id="profil-content" class="settings-content" style="display: none;">
                <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 2rem;">
                    <h3 style="margin-top: 0; margin-bottom: 1.5rem; font-size: 1.25rem;">Informasi Akun</h3>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.9rem; color: var(--text-muted); margin-bottom: 0.5rem;">Nama Lengkap</label>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(255,255,255,0.03); color: var(--text-main);" disabled>
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.9rem; color: var(--text-muted); margin-bottom: 0.5rem;">Alamat Email</label>
                        <input type="email" class="form-control" value="{{ auth()->user()->email }}" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background: rgba(255,255,255,0.03); color: var(--text-main);" disabled>
                    </div>

                    <a href="{{ route('password.change') }}" class="btn" style="background: rgba(255,255,255,0.1); color: var(--text-main); border: none; display: inline-flex; align-items: center; gap: 0.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Ubah Password
                    </a>
                </div>
            </div>

            <!-- Notifikasi Content (Sesuai Mockup) -->
            <div id="notifikasi-content" class="settings-content" style="display: block;">
                
                <div class="settings-card premium-glow-card">
                    <div style="flex: 1; padding-right: 1rem;">
                        <h4 style="margin: 0 0 0.25rem 0; font-size: 1rem; font-weight: 600;">Pengingat batas anggaran harian</h4>
                        <p style="margin: 0; font-size: 0.85rem; color: var(--text-muted);">Notifikasi saat pengeluaran mendekati atau melewati batas harian.</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="settings-card premium-glow-card">
                    <div style="flex: 1; padding-right: 1rem;">
                        <h4 style="margin: 0 0 0.25rem 0; font-size: 1rem; font-weight: 600;">Notifikasi laporan mingguan</h4>
                        <p style="margin: 0; font-size: 0.85rem; color: var(--text-muted);">Pemberitahuan ringkasan keuangan setiap akhir pekan.</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked>
                        <span class="slider"></span>
                    </label>
                </div>

                <div class="settings-card premium-glow-card">
                    <div style="flex: 1; padding-right: 1rem;">
                        <h4 style="margin: 0 0 0.25rem 0; font-size: 1rem; font-weight: 600;">Notifikasi via email</h4>
                        <p style="margin: 0; font-size: 0.85rem; color: var(--text-muted);">Kirim ringkasan laporan dan peringatan melalui email.</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox">
                        <span class="slider"></span>
                    </label>
                </div>

            </div>

            <!-- Tampilan Content -->
            <div id="tampilan-content" class="settings-content" style="display: none;">
                <div class="settings-card premium-glow-card">
                    <div style="flex: 1; padding-right: 1rem;">
                        <h4 style="margin: 0 0 0.25rem 0; font-size: 1rem; font-weight: 600;">Mode Gelap (Dark Mode)</h4>
                        <p style="margin: 0; font-size: 0.85rem; color: var(--text-muted);">Gunakan tema gelap agar lebih nyaman di mata.</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" checked disabled>
                        <span class="slider"></span>
                    </label>
                </div>
            </div>

            <!-- Bantuan Content -->
            <div id="bantuan-content" class="settings-content" style="display: none;">
                <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 2rem; text-align: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6; margin-bottom: 1rem;"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <h3 style="margin-top: 0; margin-bottom: 0.5rem; font-size: 1.25rem;">Butuh Bantuan?</h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 1.5rem;">Jika Anda mengalami kendala atau memiliki pertanyaan terkait fitur HematCuy, silakan kunjungi halaman Panduan atau hubungi kami.</p>
                    <a href="{{ route('guide.index') }}" class="btn btn-primary" style="text-decoration: none;">Lihat Panduan</a>
                </div>
            </div>

            <!-- Tentang Content -->
            <div id="tentang-content" class="settings-content" style="display: none;">
                <div style="background: var(--bg-card); border: 1px solid var(--border-color); border-radius: var(--radius-lg); padding: 2rem; text-align: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem;"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12c0 1.1.9 2 2 2h14v-4"/><path d="M18 12a2 2 0 0 0-2 2c0 1.1.9 2 2 2h4v-4h-4z"/></svg>
                    <h3 style="margin-top: 0; margin-bottom: 0.5rem; font-size: 1.5rem;">HematCuy.</h3>
                    <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 0.5rem;">Versi 1.0.0 (BETA)</p>
                    <p style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 2rem;">Aplikasi pencatatan keuangan cerdas yang membantu Anda melacak pengeluaran dan mencapai target finansial.</p>
                    <div style="font-size: 0.85rem; color: #64748b;">&copy; {{ date('Y') }} HematCuy. Hak Cipta Dilindungi.</div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* CSS untuk Toggle Switch bergaya iOS */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 28px;
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
        transition: .4s;
        border-radius: 34px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    input:checked + .slider {
        background-color: #3b82f6;
        border-color: #3b82f6;
    }
    input:checked + .slider:before {
        transform: translateX(20px);
    }
    input:disabled + .slider {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* CSS untuk Kotak Pengaturan */
    .settings-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        margin-bottom: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .settings-card:hover {
        border-color: rgba(255,255,255,0.1);
    }
</style>

<script>
    // Javascript untuk memindah Tab secara instan
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.settings-tab-btn');
        const contents = document.querySelectorAll('.settings-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                // Hapus active dari semua tombol
                tabBtns.forEach(b => {
                    b.classList.remove('active');
                    b.style.background = 'transparent';
                    b.style.color = 'var(--text-muted)';
                });

                // Tambah active ke tombol yang diklik
                this.classList.add('active');
                this.style.background = '#3b82f6';
                this.style.color = '#fff';

                // Sembunyikan semua konten
                contents.forEach(c => c.style.display = 'none');

                // Tampilkan konten yang sesuai
                const targetId = this.getAttribute('data-target') + '-content';
                document.getElementById(targetId).style.display = 'block';
            });
        });
    });
</script>
@endsection

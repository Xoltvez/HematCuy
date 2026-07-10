@extends('layouts.app')

@section('content')
<div class="wishlist-section" style="max-width: 1200px; margin: 0 auto; padding-bottom: 3rem;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="margin: 0; font-size: 1.5rem; font-weight: 700; color: #ffffff;">Tabungan & Wishlist</h2>
            <p style="color: var(--text-muted); margin-top: 0.25rem; font-size: 0.9rem; margin-bottom: 0;">Rencanakan pembelian barang impian dari sisa uang bulanan Anda</p>
        </div>
        <button type="button" onclick="openModal('addWishlistModal')" style="background: #3b82f6; color: #fff; border-radius: 8px; padding: 0.6rem 1.2rem; display: flex; align-items: center; gap: 0.5rem; font-weight: 500; font-size: 0.9rem; border: none; cursor: pointer; width: max-content; flex-shrink: 0; transition: all 0.2s ease;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Tambah Wishlist
        </button>
    </div>

    @if(session('success'))
    <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #10b981; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
            <polyline points="22 4 12 14.01 9 11.01" />
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- Summary Cards Row -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; align-items: stretch; margin-bottom: 2.5rem;">

        <!-- Tabungan Card -->
        <div class="premium-glow-card" style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0.03) 100%); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: var(--radius-lg); padding: 1.5rem; transition: all 0.3s ease; display: flex; flex-direction: column; height: 100%;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(59, 130, 246, 0.2); display: flex; align-items: center; justify-content: center; color: #60a5fa;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="20" height="12" x="2" y="6" rx="2" />
                        <circle cx="12" cy="12" r="2" />
                        <path d="M6 12h.01M18 12h.01" />
                    </svg>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 1.1rem; color: #fff;">Sisa Uang Bulan Ini</h3>
                    <p style="margin: 0; font-size: 0.85rem; color: var(--text-muted);">Gaji - Pengeluaran</p>
                </div>
            </div>

            <div style="font-size: 2rem; font-weight: 700; color: #60a5fa;">
                Rp {{ number_format($tabunganAmount, 0, ',', '.') }}
            </div>
            <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.5rem; line-height: 1.5; flex: 1;">
                Sisa uang ini yang akan menjadi acuan kecepatan pencapaian wishlist Anda.
            </div>

            <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.05); margin: 1rem 0;">
            <button type="button" onclick="openModal('historyModal')" style="background: rgba(59, 130, 246, 0.1); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.2); padding: 0.5rem 1rem; border-radius: 0.4rem; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.4rem; transition: all 0.2s ease;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 3v18h18" />
                    <path d="m19 9-5 5-4-4-3 3" />
                </svg>
                Lihat Riwayat Sisa Uang
            </button>
        </div>

        <!-- Total Tabungan (Brankas) Card -->
        <div class="premium-glow-card" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.03) 100%); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: var(--radius-lg); padding: 1.5rem; transition: all 0.3s ease;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                <div style="width: 40px; height: 40px; border-radius: 12px; background: rgba(16, 185, 129, 0.2); display: flex; align-items: center; justify-content: center; color: #10b981;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="20" height="14" x="2" y="5" rx="2" />
                        <line x1="2" x2="22" y1="10" y2="10" />
                    </svg>
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 1.1rem; color: #fff;">Total Tabungan</h3>
                    <p style="margin: 0; font-size: 0.85rem; color: var(--text-muted);">Mulai menabung sekarang</p>
                </div>
            </div>

            <div style="font-size: 2rem; font-weight: 700; color: #10b981;">
                Rp {{ number_format($totalTabungan, 0, ',', '.') }}
            </div>
            <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 0.5rem; line-height: 1.5; margin-bottom: 1rem;">
                Akumulasi sisa uang dari bulan-bulan lalu dan tabungan Anda.
            </div>

            <hr style="border: 0; border-top: 1px solid rgba(255,255,255,0.05); margin: 1rem 0;">

            <form action="{{ route('wishlists.addSavings') }}" method="POST" style="display: flex; gap: 0.5rem; align-items: stretch;">
                @csrf
                <input type="text" id="tabungan_amount_display" placeholder="Nominal (Rp)" required inputmode="numeric" style="flex: 1; border: 1px solid rgba(16, 185, 129, 0.3); background: rgba(0,0,0,0.2); padding: 0.6rem; border-radius: 0.4rem; font-size: 0.85rem; color: white; min-width: 0;">
                <input type="hidden" id="tabungan_amount" name="amount" required min="0">
                <button type="submit" style="background: rgba(16, 185, 129, 0.2); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.6rem 1rem; font-size: 0.85rem; border-radius: 0.4rem; cursor: pointer; width: max-content; flex-shrink: 0; transition: all 0.2s ease;">+ Nabung</button>
            </form>
        </div>

    </div>

    <!-- Right Column: Wishlist Cards (Now Full Width) -->
    <div>
        <h3 style="margin: 0 0 1rem 0; font-size: 1.25rem; font-weight: 600; color: #ffffff;">Daftar Wishlist Anda</h3>

        @if($wishlistData->isEmpty())
        <div class="empty-state" style="background: rgba(255,255,255,0.02); border: 1px dashed rgba(255,255,255,0.1); border-radius: var(--radius-lg); padding: 3rem 1rem; text-align: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem; opacity: 0.5;">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
            <p style="margin: 0; color: var(--text-muted);">Belum ada barang impian yang dicatat.</p>
        </div>
        @else
        <div class="wishlist-grid" style="display: grid; gap: 1.25rem;">
            @foreach($wishlistData as $item)
            @if($item['purchased_date'])
            <!-- Purchased Card -->
            <div class="premium-glow-card" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); border-radius: var(--radius-lg); padding: 1.25rem; position: relative; opacity: 0.7; filter: grayscale(50%);">
                <!-- Delete Button -->
                <form action="{{ route('wishlists.destroy', $item['id']) }}" method="POST" style="position: absolute; top: 1rem; right: 1rem;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete" onclick="confirmDelete(event, this.closest('form'), 'Hapus wishlist ini?');" style="color: var(--text-muted); padding: 0.2rem; background: transparent; border: none; cursor: pointer;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18" />
                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                        </svg>
                    </button>
                </form>

                <div style="margin-bottom: 1rem; padding-right: 2rem;">
                    <h4 style="margin: 0 0 0.5rem 0; font-size: 1.1rem; font-weight: 600; color: #fff; text-decoration: line-through;">
                        {{ $item['name'] }}
                    </h4>
                    <div style="font-size: 1.35rem; font-weight: 700; color: var(--text-muted); margin-bottom: 0.5rem;">
                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                    </div>
                </div>

                <div style="background: rgba(16, 185, 129, 0.1); border-radius: 1rem; padding: 0.75rem; margin-top: 1rem; border: 1px solid rgba(16, 185, 129, 0.2);">
                    <div style="display: flex; align-items: center; gap: 0.5rem; font-weight: 600; color: #10b981;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                        Sudah Dibeli: {{ \Carbon\Carbon::parse($item['purchased_date'])->translatedFormat('d M Y') }}
                    </div>
                </div>
            </div>
            @else
            <!-- Active Card -->
            <div class="premium-glow-card" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: var(--radius-lg); padding: 1.25rem; position: relative; transition: all 0.3s ease; display: flex; flex-direction: column;">
                
                <!-- Header: Title & Actions -->
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                    <div>
                        <h4 style="margin: 0 0 0.25rem 0; font-size: 1.2rem; font-weight: 700; color: #fff;">
                            {{ $item['name'] }}
                        </h4>
                        @if($item['target_date'])
                        <div style="display: flex; align-items: center; gap: 0.4rem; color: var(--text-muted); font-size: 0.85rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                            Tenggat: {{ \Carbon\Carbon::parse($item['target_date'])->translatedFormat('d F Y') }}
                        </div>
                        @elseif(isset($item['estimated_months']))
                        <div style="display: flex; align-items: center; gap: 0.4rem; color: var(--text-muted); font-size: 0.85rem;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#a78bfa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            Estimasi: {{ $item['estimated_months'] === -1 ? 'Belum menabung bulan ini' : $item['estimated_months'] . ' Bulan lagi' }}
                        </div>
                        @endif
                    </div>
                    
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="button" class="btn-delete" onclick="openEditModal({{ $item['id'] }}, '{{ addslashes($item['name']) }}', {{ $item['price'] }}, '{{ $item['target_date'] ?? '' }}')" style="color: var(--text-muted); padding: 0.2rem; background: transparent; border: none; cursor: pointer;" title="Edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                <path d="m15 5 4 4" />
                            </svg>
                        </button>
                        <form action="{{ route('wishlists.destroy', $item['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="confirmDelete(event, this.closest('form'), 'Hapus wishlist ini?');" style="color: var(--text-muted); padding: 0.2rem; background: transparent; border: none; cursor: pointer;" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18" />
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Price Info -->
                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: 1rem; margin-bottom: 0.5rem;">
                    <div style="font-size: 1.25rem; font-weight: 700; color: #fff;">
                        Rp {{ number_format($item['saved_amount'], 0, ',', '.') }}
                    </div>
                    <div style="font-size: 0.85rem; color: var(--text-muted);">
                        Target: Rp {{ number_format($item['price'], 0, ',', '.') }}
                    </div>
                </div>

                <!-- Progress Bar -->
                <div style="width: 100%; height: 8px; background: rgba(255,255,255,0.1); border-radius: 9999px; overflow: hidden; margin-bottom: 0.5rem;">
                    <div style="height: 100%; width: {{ $item['percentage'] }}%; background: #3b82f6; border-radius: 9999px; transition: width 0.5s ease;"></div>
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                    <div>Status tabungan</div>
                    <div style="color: #3b82f6; font-weight: 600;">{{ $item['percentage'] }}%</div>
                </div>

                <!-- Action Button -->
                @if($item['percentage'] >= 100)
                <button type="button" onclick="openPurchaseModal({{ $item['id'] }}, '{{ addslashes($item['name']) }}')" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.4); color: #10b981; border-radius: 9999px; padding: 0.65rem; width: 100%; font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                    🛍️ Tandai Sudah Dibeli
                </button>
                @else
                <button type="button" onclick="openAllocateModal({{ $item['id'] }}, '{{ addslashes($item['name']) }}', {{ $item['price'] - $item['saved_amount'] }})" style="background: transparent; border: 1px solid rgba(255,255,255,0.3); color: #3b82f6; border-radius: 9999px; padding: 0.65rem; width: 100%; font-size: 0.9rem; font-weight: 600; cursor: pointer; transition: all 0.2s;">
                    💰 Isi Tabungan
                </button>
                @endif
            </div>
            @endif
            @endforeach
        </div>
        @endif
    </div>
</div>

</div>

<style>
    .wishlist-grid {
        grid-template-columns: 1fr 1fr;
    }
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 2fr;"] {
            grid-template-columns: 1fr !important;
        }
        .wishlist-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Modal Tambah Wishlist -->
<div id="addWishlistModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
    <div class="premium-glow-card" style="background: #111827; border: 1px solid rgba(255,255,255,0.05); border-radius: var(--radius-lg); padding: 1.5rem; width: 90%; max-width: 400px; position: relative;">
        <button type="button" onclick="closeModal('addWishlistModal')" style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; color: var(--text-muted); cursor: pointer;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <h3 style="margin: 0 0 1rem 0; font-size: 1.1rem; color: #fff; display: flex; align-items: center; gap: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;">
                <path d="M5 12h14" />
                <path d="M12 5v14" />
            </svg>
            Tambah Wishlist Baru
        </h3>

        <form action="{{ route('wishlists.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
            @csrf
            <div>
                <label for="name" style="color: var(--text-muted); font-size: 0.85rem;">Nama Barang / Target</label>
                <input type="text" id="name" name="name" placeholder="Misal: iPhone 15, Liburan ke Bali" required style="border-color: rgba(59, 130, 246, 0.3); background: rgba(0,0,0,0.2); width: 100%;">
            </div>
            <div>
                <label for="price_display" style="color: var(--text-muted); font-size: 0.85rem;">Target Harga (Rp)</label>
                <input type="text" id="price_display" placeholder="Misal: 15.000.000" required style="border-color: rgba(59, 130, 246, 0.3); background: rgba(0,0,0,0.2); width: 100%;" inputmode="numeric">
                <input type="hidden" id="price" name="price" required min="0">
            </div>
            <div>
                <label for="target_date" style="color: var(--text-muted); font-size: 0.85rem;">Target Tanggal (Opsional)</label>
                <input type="date" id="target_date" name="target_date" style="border-color: rgba(59, 130, 246, 0.3); background: rgba(0,0,0,0.2); width: 100%; color-scheme: dark;">
            </div>
            <button type="submit" class="btn" style="background: #3b82f6; color: #fff; margin-top: 0.5rem; border-radius: var(--radius-md); width: 100%;">Simpan Wishlist</button>
        </form>
    </div>
</div>

<!-- History Modal -->
<div id="historyModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: #1e293b; border: 1px solid rgba(255,255,255,0.1); border-radius: var(--radius-xl); padding: 2rem; width: 90%; max-width: 450px; position: relative; max-height: 80vh; overflow-y: auto;">
        <button type="button" onclick="closeModal('historyModal')" style="position: absolute; top: 1.5rem; right: 1.5rem; background: none; border: none; color: var(--text-muted); cursor: pointer; padding: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18" />
                <path d="m6 6 12 12" />
            </svg>
        </button>

        <h3 style="margin: 0 0 1.5rem 0; font-size: 1.25rem; font-weight: 600; color: #fff; display: flex; align-items: center; gap: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 3v18h18" />
                <path d="m19 9-5 5-4-4-3 3" />
            </svg>
            Riwayat Sisa Uang
        </h3>

        @if(empty($rolloverHistory))
        <div style="text-align: center; color: var(--text-muted); padding: 2rem 0; font-size: 0.9rem;">
            Belum ada riwayat sisa uang dari bulan sebelumnya.
        </div>
        @else
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            @foreach($rolloverHistory as $history)
            <div style="display: flex; justify-content: space-between; align-items: center; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); padding: 1rem; border-radius: var(--radius-md);">
                <div style="font-weight: 500; color: var(--text-main);">{{ $history['month_name'] }}</div>
                <div style="font-weight: 600; color: #10b981;">+ Rp {{ number_format($history['amount'], 0, ',', '.') }}</div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<!-- Modal Edit Wishlist -->
<div id="editWishlistModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
    <div class="premium-glow-card" style="background: #111827; border: 1px solid rgba(255,255,255,0.05); border-radius: var(--radius-lg); padding: 1.5rem; width: 90%; max-width: 400px; position: relative;">
        <button type="button" onclick="closeModal('editWishlistModal')" style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; color: var(--text-muted); cursor: pointer;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <h3 style="margin: 0 0 1rem 0; font-size: 1.1rem; color: #fff; display: flex; align-items: center; gap: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #60a5fa;">
                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                <path d="m15 5 4 4" />
            </svg>
            Edit Wishlist
        </h3>

        <form id="editWishlistForm" action="" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
            @csrf
            @method('PUT')
            <div>
                <label for="edit_name" style="color: var(--text-muted); font-size: 0.85rem;">Nama Barang / Target</label>
                <input type="text" id="edit_name" name="name" required style="border-color: rgba(59, 130, 246, 0.3); background: rgba(0,0,0,0.2); width: 100%;">
            </div>
            <div>
                <label for="edit_price_display" style="color: var(--text-muted); font-size: 0.85rem;">Target Harga (Rp)</label>
                <input type="text" id="edit_price_display" required style="border-color: rgba(59, 130, 246, 0.3); background: rgba(0,0,0,0.2); width: 100%;" inputmode="numeric">
                <input type="hidden" id="edit_price" name="price" required min="0">
            </div>
            <div>
                <label for="edit_target_date" style="color: var(--text-muted); font-size: 0.85rem;">Target Tanggal (Opsional)</label>
                <input type="date" id="edit_target_date" name="target_date" style="border-color: rgba(59, 130, 246, 0.3); background: rgba(0,0,0,0.2); width: 100%; color-scheme: dark;">
            </div>
            <button type="submit" class="btn" style="background: #3b82f6; color: #fff; margin-top: 0.5rem; border-radius: var(--radius-md); width: 100%;">Simpan Perubahan</button>
        </form>
    </div>
</div>

<!-- Modal Tandai Dibeli -->
<div id="purchaseWishlistModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
    <div class="premium-glow-card" style="background: #111827; border: 1px solid rgba(255,255,255,0.05); border-radius: var(--radius-lg); padding: 1.5rem; width: 90%; max-width: 400px; position: relative;">
        <button type="button" onclick="closeModal('purchaseWishlistModal')" style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; color: var(--text-muted); cursor: pointer;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <h3 style="margin: 0 0 1rem 0; font-size: 1.1rem; color: #fff; display: flex; align-items: center; gap: 0.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #10b981;">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
            Tandai Sudah Dibeli
        </h3>

        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;" id="purchaseWishlistText"></p>

        <form id="purchaseWishlistForm" action="" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
            @csrf
            <div>
                <label for="purchased_date" style="color: var(--text-muted); font-size: 0.85rem;">Tanggal Pembelian</label>
                <input type="date" id="purchased_date" name="purchased_date" value="{{ date('Y-m-d') }}" required style="border-color: rgba(16, 185, 129, 0.3); background: rgba(0,0,0,0.2); width: 100%;">
            </div>
            <button type="submit" class="btn" style="background: #10b981; color: #fff; margin-top: 0.5rem; border-radius: 9999px; width: 100%;">Tandai Terbeli & Potong Saldo</button>
        </form>
    </div>
</div>

<!-- Modal Isi Tabungan -->
<div id="allocateWishlistModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
    <div class="premium-glow-card" style="background: #111827; border: 1px solid rgba(255,255,255,0.05); border-radius: var(--radius-lg); padding: 1.5rem; width: 90%; max-width: 400px; position: relative;">
        <button type="button" onclick="closeModal('allocateWishlistModal')" style="position: absolute; top: 1rem; right: 1rem; background: none; border: none; color: var(--text-muted); cursor: pointer;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
        <h3 style="margin: 0 0 1rem 0; font-size: 1.1rem; color: #fff; display: flex; align-items: center; gap: 0.5rem;">
            💰 Isi Tabungan
        </h3>

        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;" id="allocateWishlistText"></p>

        <form id="allocateWishlistForm" action="" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
            @csrf
            <div>
                <label for="allocate_amount_display" style="color: var(--text-muted); font-size: 0.85rem;">Nominal (Rp)</label>
                <input type="text" id="allocate_amount_display" placeholder="Misal: 50.000" required style="border-color: rgba(59, 130, 246, 0.3); background: rgba(0,0,0,0.2); width: 100%;" inputmode="numeric">
                <input type="hidden" id="allocate_amount" name="amount" required min="1">
                <small style="color: var(--text-muted); display: block; margin-top: 0.25rem;">Dana akan diambil dari brankas Total Tabungan Anda.</small>
            </div>
            <button type="submit" class="btn" style="background: #3b82f6; color: #fff; margin-top: 0.5rem; border-radius: 9999px; width: 100%;">Simpan Tabungan</button>
        </form>
    </div>
</div>


<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }

    function openEditModal(id, name, price, target_date) {
        document.getElementById('editWishlistForm').action = '/tabungan/' + id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_price').value = price;
        document.getElementById('edit_price_display').value = parseInt(price, 10).toLocaleString('id-ID');
        document.getElementById('edit_target_date').value = target_date || '';
        openModal('editWishlistModal');
    }

    function openPurchaseModal(id, name) {
        document.getElementById('purchaseWishlistForm').action = '/tabungan/' + id + '/purchase';
        document.getElementById('purchaseWishlistText').innerText = "Apakah Anda yakin ingin menandai '" + name + "' sebagai terbeli?";
        openModal('purchaseWishlistModal');
    }

    function openAllocateModal(id, name, remaining) {
        document.getElementById('allocateWishlistForm').action = '/tabungan/' + id + '/allocate';
        document.getElementById('allocateWishlistText').innerText = "Masukkan nominal untuk mengisi tabungan '" + name + "'. Kekurangan saat ini: Rp " + parseInt(remaining, 10).toLocaleString('id-ID') + ".";
        document.getElementById('allocate_amount_display').value = '';
        document.getElementById('allocate_amount').value = '';
        openModal('allocateWishlistModal');
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        function setupFormatting(displayId, hiddenId) {
            const displayInput = document.getElementById(displayId);
            const hiddenInput = document.getElementById(hiddenId);

            if (displayInput && hiddenInput) {
                displayInput.addEventListener('input', function(e) {
                    // Remove non-digit characters
                    let value = this.value.replace(/[^0-9]/g, '');

                    // Update hidden input
                    hiddenInput.value = value;

                    // Format display value with thousands separator
                    if (value) {
                        this.value = parseInt(value, 10).toLocaleString('id-ID');
                    } else {
                        this.value = '';
                    }
                });
            }
        }

        setupFormatting('price_display', 'price');
        setupFormatting('edit_price_display', 'edit_price');
        setupFormatting('tabungan_amount_display', 'tabungan_amount');
        setupFormatting('allocate_amount_display', 'allocate_amount');
    });
</script>
@endsection
@extends('layouts.app')

@section('content')
<div style="max-width: 1200px; margin: 0 auto;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h3 style="margin: 0; font-size: 1.5rem; font-weight: 700;">Catatan</h3>
            <p style="color: var(--text-muted); margin-top: 0.25rem;">Simpan pengingat, utang, atau ide finansial Anda di sini.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; padding: 1rem; border-radius: var(--radius-md); margin-bottom: 1.5rem;">
        {{ session('success') }}
    </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 2.5fr; gap: 2rem; align-items: start;">
        
        <!-- Form Tambah Catatan (Sidebar Kiri) -->
        <div style="background: rgba(59, 130, 246, 0.05); border: 1px solid rgba(59, 130, 246, 0.2); padding: 1.5rem; border-radius: var(--radius-xl); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px); position: sticky; top: 100px;">
            <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#60a5fa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
                <h4 style="margin: 0; color: #60a5fa; font-size: 1.1rem;">Tulis Catatan</h4>
            </div>
            
            <form action="{{ route('notes.store') }}" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
                @csrf
                <div>
                    <label for="title" style="color: var(--text-muted); font-size: 0.85rem; font-weight: 500;">Judul</label>
                    <input type="text" id="title" name="title" required placeholder="Cth: Tagihan Listrik" style="border-color: rgba(59, 130, 246, 0.3); background: rgba(0,0,0,0.2); margin-top: 0.25rem;">
                </div>
                <div>
                    <label for="amount" style="color: var(--text-muted); font-size: 0.85rem; font-weight: 500;">Nominal (Opsional)</label>
                    <div style="position: relative; margin-top: 0.25rem;">
                        <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-weight: 600;">Rp</span>
                        <input type="text" id="amount" name="amount" placeholder="0" class="rupiah-input" style="padding-left: 2.5rem; border-color: rgba(59, 130, 246, 0.3); background: rgba(0,0,0,0.2); width: 100%;">
                    </div>
                </div>
                <div>
                    <label for="due_date" style="color: var(--text-muted); font-size: 0.85rem; font-weight: 500;">Jatuh Tempo (Opsional)</label>
                    <input type="date" id="due_date" name="due_date" placeholder="dd:mm:yy" style="width: 100%; border-color: rgba(59, 130, 246, 0.3); background: rgba(0,0,0,0.2); margin-top: 0.25rem; color: var(--text-main); font-family: inherit;">
                </div>
                <div>
                    <label for="content" style="color: var(--text-muted); font-size: 0.85rem; font-weight: 500;">Isi Catatan</label>
                    <textarea id="content" name="content" rows="5" required style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid rgba(59, 130, 246, 0.3); background-color: rgba(0,0,0,0.2); color: var(--text-main); font-family: inherit; font-size: 0.95rem; resize: vertical; outline: none; transition: all 0.2s ease; margin-top: 0.25rem;" placeholder="Cth: Jangan lupa bayar tanggal 20..."></textarea>
                </div>
                <button type="submit" class="btn" style="background: #3b82f6; color: white; font-weight: 600; margin-top: 0.5rem; border-radius: var(--radius-md);">Simpan</button>
            </form>
        </div>

        <!-- Daftar Catatan (Grid Kanan) -->
        <div>
            @if($notes->isEmpty())
                <div class="empty-state" style="background: var(--bg-card); border-radius: var(--radius-xl); border: 1px solid var(--border-color); padding: 4rem 1.5rem; text-align: center; backdrop-filter: blur(12px);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted); margin-bottom: 1rem; opacity: 0.5;"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <p style="margin-bottom: 0;">Ruang catatan Anda masih kosong.<br>Tulis ide atau pengingat pertama Anda di kolom sebelah!</p>
                </div>
            @else
                <div class="notes-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
                    @foreach($notes as $note)
                        <div class="note-card" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.08); border-radius: var(--radius-lg); padding: 1.5rem; display: flex; flex-direction: column; backdrop-filter: blur(12px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: transform 0.2s ease, border-color 0.2s ease;">
                            
                            <!-- Header Catatan -->
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 1rem;">
                                <div>
                                    <h4 style="margin: 0 0 0.25rem 0; font-size: 1.15rem; font-weight: 600; color: {{ $note->is_paid ? '#10b981' : '#60a5fa' }}; text-decoration: {{ $note->is_paid ? 'line-through' : 'none' }};">{{ $note->title }}</h4>
                                    <div style="font-size: 0.75rem; color: var(--text-muted); display: flex; align-items: center; gap: 0.25rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        {{ $note->created_at->format('d M Y, H:i') }}
                                    </div>
                                    @if($note->due_date)
                                        <div style="font-size: 0.75rem; color: {{ $note->is_paid ? 'var(--text-muted)' : '#f59e0b' }}; display: flex; align-items: center; gap: 0.25rem; margin-top: 0.25rem; font-weight: 600;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                            Jatuh Tempo: {{ \Carbon\Carbon::parse($note->due_date)->format('d M Y') }}
                                        </div>
                                    @endif
                                </div>
                                @if($note->is_paid)
                                    <span style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600; border: 1px solid rgba(16, 185, 129, 0.2);">✅ Lunas</span>
                                @elseif($note->amount > 0)
                                    <div style="font-weight: 700; color: #fff;">Rp {{ number_format($note->amount, 0, ',', '.') }}</div>
                                @endif
                            </div>
                            
                            <!-- Isi Catatan -->
                            <p style="color: var(--text-main); font-size: 0.95rem; line-height: 1.6; white-space: pre-wrap; margin: 0 0 1.5rem 0; flex: 1;">{{ $note->content }}</p>
                            
                            <!-- Aksi -->
                            <div style="display: grid; grid-template-columns: {{ ($note->amount > 0 && !$note->is_paid) ? '1fr 1fr 1fr' : '1fr 1fr' }}; gap: 0.5rem; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 1rem; margin-top: auto;">
                                @if($note->amount > 0 && !$note->is_paid)
                                    <button type="button" onclick="openPayModal({{ $note->id }}, '{{ addslashes($note->title) }}', {{ $note->amount }})" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.2); color: #34d399; padding: 0.5rem; border-radius: var(--radius-md); font-size: 0.85rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.4rem; transition: all 0.2s; height: 100%; box-sizing: border-box;">
                                        💸 Bayar
                                    </button>
                                @endif
                                <a href="{{ route('notes.edit', $note) }}" style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: #60a5fa; padding: 0.5rem; border-radius: var(--radius-md); font-size: 0.85rem; font-weight: 600; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 0.4rem; transition: all 0.2s; text-align: center; height: 100%; box-sizing: border-box;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                    Edit
                                </a>
                                
                                <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="confirmDelete(event, this, 'Apakah Anda yakin ingin menghapus catatan ini?');" style="margin: 0; width: 100%; height: 100%;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="width: 100%; height: 100%; box-sizing: border-box; background: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.2); color: #fb7185; padding: 0.5rem; border-radius: var(--radius-md); font-size: 0.85rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.4rem; transition: all 0.2s;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>

<style>
    textarea:focus, input[type="text"]:focus {
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3) !important;
        border-color: #60a5fa !important;
    }
    
    .note-card {
        transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease !important;
    }

    .note-card:hover {
        transform: translateY(-4px);
        border-color: #38bdf8 !important; /* Neon blue */
        box-shadow: 0 10px 20px -5px rgba(56, 189, 248, 0.3) !important; /* Neon glow */
    }

    @media (max-width: 800px) {
        div[style*="grid-template-columns: 1fr 2.5fr;"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<!-- Modal Bayar Tagihan -->
<div id="payNoteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(5px);">
    <div style="background: rgba(15, 23, 42, 0.95); border: 1px solid var(--border-color); border-radius: var(--radius-xl); width: 90%; max-width: 400px; padding: 2rem; box-shadow: 0 20px 40px rgba(0,0,0,0.6); position: relative; backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);">
        <button type="button" onclick="closePayModal()" style="position: absolute; top: 1.5rem; right: 1.5rem; background: none; border: none; color: var(--text-muted); cursor: pointer;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        
        <h3 style="margin: 0 0 1.5rem 0; font-size: 1.25rem; font-weight: 700;">Konfirmasi Pembayaran</h3>
        <p id="payNoteTitle" style="color: var(--text-muted); margin-bottom: 1.5rem; font-size: 0.9rem;"></p>
        
        <form id="payNoteForm" method="POST" action="">
            @csrf
            
            <div style="margin-bottom: 1rem;">
                <label style="color: var(--text-muted); font-size: 0.85rem; font-weight: 500;">Tipe Transaksi</label>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-top: 0.25rem;">
                    <label style="cursor: pointer;">
                        <input type="radio" name="type" value="expense" checked style="display: none;" onchange="updatePayType(this)">
                        <div class="pay-type-btn" style="padding: 0.5rem; text-align: center; border-radius: var(--radius-md); border: 1px solid #fb7185; background: rgba(251, 113, 133, 0.1); color: #fb7185; font-weight: 600; transition: all 0.2s;">Pengeluaran</div>
                    </label>
                    <label style="cursor: pointer;">
                        <input type="radio" name="type" value="income" style="display: none;" onchange="updatePayType(this)">
                        <div class="pay-type-btn" style="padding: 0.5rem; text-align: center; border-radius: var(--radius-md); border: 1px solid rgba(255,255,255,0.1); background: transparent; color: var(--text-muted); font-weight: 600; transition: all 0.2s;">Pemasukan</div>
                    </label>
                </div>
            </div>
            
            <div style="margin-bottom: 1rem;">
                <label for="payCategory" style="color: var(--text-muted); font-size: 0.85rem; font-weight: 500;">Kategori</label>
                <input type="text" id="payCategory" name="category" required value="Pembayaran Tagihan" style="border-color: rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); margin-top: 0.25rem; width: 100%;">
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label for="payAccount" style="color: var(--text-muted); font-size: 0.85rem; font-weight: 500;">Sumber Dana</label>
                <select id="payAccount" name="account" required style="width: 100%; margin-top: 0.25rem; border-color: rgba(255,255,255,0.1); background: var(--bg-card); color: var(--text-main);">
                    <option value="bank">🏦 Saldo Bank</option>
                    <option value="cash">💵 Uang Tunai</option>
                </select>
            </div>
            
            <button type="submit" class="btn" style="width: 100%; background: #10b981; color: white; font-weight: 600; border-radius: var(--radius-md);">
                Bayar Rp <span id="payNoteAmountLabel">0</span>
            </button>
        </form>
    </div>
</div>

<script>
    // Format Rupiah Input
    const rupiahInputs = document.querySelectorAll('.rupiah-input');
    rupiahInputs.forEach(input => {
        input.addEventListener('keyup', function(e) {
            let value = this.value.replace(/[^,\d]/g, '').toString();
            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            this.value = rupiah;
        });
    });

    // Pay Modal Logic
    function openPayModal(noteId, noteTitle, noteAmount) {
        document.getElementById('payNoteModal').style.display = 'flex';
        document.getElementById('payNoteTitle').innerText = noteTitle;
        document.getElementById('payCategory').value = noteTitle; // Set default category to note title
        
        let formattedAmount = new Intl.NumberFormat('id-ID').format(noteAmount);
        document.getElementById('payNoteAmountLabel').innerText = formattedAmount;
        
        let form = document.getElementById('payNoteForm');
        form.action = `/notes/${noteId}/pay`;
    }

    function closePayModal() {
        document.getElementById('payNoteModal').style.display = 'none';
    }

    function updatePayType(radio) {
        document.querySelectorAll('.pay-type-btn').forEach(btn => {
            btn.style.background = 'transparent';
            btn.style.borderColor = 'rgba(255,255,255,0.1)';
            btn.style.color = 'var(--text-muted)';
        });
        
        let selectedBtn = radio.nextElementSibling;
        if (radio.value === 'expense') {
            selectedBtn.style.background = 'rgba(251, 113, 133, 0.1)';
            selectedBtn.style.borderColor = '#fb7185';
            selectedBtn.style.color = '#fb7185';
        } else {
            selectedBtn.style.background = 'rgba(52, 211, 153, 0.1)';
            selectedBtn.style.borderColor = '#34d399';
            selectedBtn.style.color = '#34d399';
        }
    }
</script>
@endsection

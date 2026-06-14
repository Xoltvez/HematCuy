@extends('layouts.app')

@section('content')
<div class="dashboard-header">
    <h2>Catatan</h2>
    <p>Simpan daftar utang, tagihan bulanan, atau pengingat lainnya di sini.</p>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="transaction-form-section" style="margin-bottom: 2.5rem;">
    <h3 style="margin-bottom: 1.5rem;">Tambah Catatan Baru</h3>
    <form action="{{ route('notes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Judul Catatan</label>
            <input type="text" id="title" name="title" required placeholder="Cth: Bayar tagihan PDAM">
        </div>
        <div class="form-group">
            <label for="content">Isi Catatan</label>
            <textarea id="content" name="content" rows="3" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background-color: rgba(15, 23, 42, 0.5); color: var(--text-main); font-family: inherit; font-size: 1rem; resize: vertical; outline: none; transition: all 0.2s ease;" placeholder="Cth: Jatuh tempo tanggal 20..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Catatan</button>
    </form>
</div>

<style>
    textarea:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
    }
</style>

<div class="notes-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
    @forelse($notes as $note)
        <div class="note-card" style="background: linear-gradient(135deg, rgba(253, 224, 71, 0.15), rgba(250, 204, 21, 0.05)); border: 1px solid rgba(250, 204, 21, 0.3); border-radius: var(--radius-lg); padding: 1.5rem; position: relative; display: flex; flex-direction: column; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
            <div style="margin-bottom: 1rem;">
                <h4 style="color: #fde047; margin-bottom: 0.5rem; font-size: 1.15rem; font-weight: 600;">{{ $note->title }}</h4>
                <div style="font-size: 0.75rem; color: rgba(255,255,255,0.4); margin-bottom: 0.75rem;">{{ $note->created_at->format('d M Y, H:i') }}</div>
                <p style="color: var(--text-main); font-size: 0.95rem; white-space: pre-wrap; margin: 0;">{{ $note->content }}</p>
            </div>
            <div style="margin-top: auto; display: flex; justify-content: flex-end; gap: 0.5rem;">
                <a href="{{ route('notes.edit', $note) }}" style="background: rgba(59, 130, 246, 0.1); border: 1px solid rgba(59, 130, 246, 0.2); color: var(--color-primary); padding: 0.4rem; border-radius: 0.5rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease; text-decoration: none;" title="Edit catatan">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                </a>
                
                <form action="{{ route('notes.destroy', $note) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?');" style="margin: 0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: rgba(244, 63, 94, 0.1); border: 1px solid rgba(244, 63, 94, 0.2); color: var(--color-expense); padding: 0.4rem; border-radius: 0.5rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;" title="Hapus catatan">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="empty-state" style="grid-column: 1 / -1; padding: 4rem 1rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--text-muted); margin-bottom: 1rem; opacity: 0.5;"><path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><line x1="10" x2="8" y1="9" y2="9"/></svg>
            <p>Belum ada catatan. Tambahkan catatan pertamamu!</p>
        </div>
    @endforelse
</div>
@endsection

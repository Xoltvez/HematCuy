@extends('layouts.app')

@section('content')
<div class="dashboard-header" style="margin-bottom: 2rem;">
    <h2>Edit Catatan</h2>
    <p>Perbarui catatan Anda di sini.</p>
</div>

<div class="transaction-form-section">
    <form action="{{ route('notes.update', $note) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="title">Judul Catatan</label>
            <input type="text" id="title" name="title" value="{{ old('title', $note->title) }}" required>
        </div>
        
        <div class="form-group">
            <label for="content">Isi Catatan</label>
            <textarea id="content" name="content" rows="6" style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); background-color: rgba(15, 23, 42, 0.5); color: var(--text-main); font-family: inherit; font-size: 1rem; resize: vertical; outline: none; transition: all 0.2s ease;">{{ old('content', $note->content) }}</textarea>
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 1rem;">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('notes.index') }}" class="btn" style="background: rgba(255,255,255,0.1); color: white; text-align: center;">Batal</a>
        </div>
    </form>
</div>

<style>
    textarea:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
    }
</style>
@endsection

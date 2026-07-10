<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Note;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        
        if (!$query || strlen($query) < 2) {
            return response()->json(['transactions' => [], 'notes' => []]);
        }

        $userId = auth()->id();

        // Cari transaksi berdasarkan deskripsi atau kategori
        $transactions = Transaction::where('user_id', $userId)
            ->where(function($q) use ($query) {
                $q->where('description', 'LIKE', "%{$query}%")
                  ->orWhere('category', 'LIKE', "%{$query}%");
            })
            ->orderBy('date', 'desc')
            ->take(5)
            ->get()
            ->map(function($t) {
                return [
                    'id' => $t->id,
                    'title' => $t->description ?: $t->category,
                    'subtitle' => date('d M Y', strtotime($t->date)) . ' • ' . $t->category,
                    'amount' => 'Rp ' . number_format($t->amount, 0, ',', '.'),
                    'type' => $t->type,
                    'url' => route('transactions.edit', $t->id)
                ];
            });

        // Cari catatan berdasarkan judul atau deskripsi
        $notes = Note::where('user_id', $userId)
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($n) {
                $status = $n->is_paid ? 'Lunas' : 'Belum Lunas';
                return [
                    'id' => $n->id,
                    'title' => $n->title,
                    'subtitle' => 'Jatuh Tempo: ' . ($n->due_date ? date('d M Y', strtotime($n->due_date)) : '-') . ' • ' . $status,
                    'amount' => $n->amount ? 'Rp ' . number_format($n->amount, 0, ',', '.') : '-',
                    'type' => 'note',
                    'url' => route('notes.index') . '?highlight=' . $n->id
                ];
            });

        return response()->json([
            'transactions' => $transactions,
            'notes' => $notes
        ]);
    }
}

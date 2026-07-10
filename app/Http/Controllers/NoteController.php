<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Transaction;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = auth()->user()->notes()->latest()->get();
        return view('notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'amount' => 'nullable|string',
            'due_date' => 'nullable|date'
        ]);

        if (isset($validated['amount'])) {
            $validated['amount'] = (float) str_replace(['Rp', '.', ' '], '', $validated['amount']);
        }

        $validated['user_id'] = auth()->id();
        Note::create($validated);

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }
        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'amount' => 'nullable|string',
            'due_date' => 'nullable|date'
        ]);

        if (isset($validated['amount'])) {
            $validated['amount'] = (float) str_replace(['Rp', '.', ' '], '', $validated['amount']);
        }

        $note->update($validated);

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }
        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil dihapus!');
    }

    public function pay(Request $request, Note $note)
    {
        if ($note->user_id !== auth()->id()) {
            abort(403);
        }

        if ($note->is_paid) {
            return back()->with('error', 'Catatan ini sudah lunas.');
        }

        $request->validate([
            'type' => 'required|in:income,expense',
            'category' => 'required|string',
            'account' => 'required|in:cash,bank',
        ]);

        // Create transaction
        Transaction::create([
            'user_id' => auth()->id(),
            'title' => $note->title,
            'type' => $request->type,
            'category' => $request->category,
            'amount' => $note->amount,
            'date' => now()->format('Y-m-d'),
            'account' => $request->account,
            'description' => 'Pembayaran otomatis dari catatan'
        ]);

        // Mark note as paid
        $note->update(['is_paid' => true]);

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil dibayar dan transaksi telah dicatat!');
    }
}

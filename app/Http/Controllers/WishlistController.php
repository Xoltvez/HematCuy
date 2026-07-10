<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Transaction;

class WishlistController extends Controller
{
    public function index()
    {
        $currentMonth = now()->format('Y-m');

        // Fetch Monthly Salary
        $salaryRecord = auth()->user()->monthlySalaries()->where('month_year', $currentMonth)->first();
        $monthlySalary = $salaryRecord ? $salaryRecord->amount : 0;
        
        // Total All Spent (semua pengeluaran di bulan ini)
        $totalSpent = auth()->user()->transactions()
                ->where('type', 'expense')
                ->where('category', '!=', 'Pembelian Wishlist')
                ->where('date', 'like', $currentMonth . '%')
                ->sum('amount');
        
        // Sisa Uang Bulan Ini = Gaji - Total Pengeluaran
        $tabunganAmount = max(0, $monthlySalary - $totalSpent);

        // Calculate Rollover Tabungan
        $previousSalaries = auth()->user()->monthlySalaries()->where('month_year', '<', $currentMonth)->orderBy('month_year', 'desc')->get();
        $rolloverSavings = 0;
        $rolloverHistory = [];
        
        foreach($previousSalaries as $ps) {
            $month = $ps->month_year;
            $spent = auth()->user()->transactions()
                ->where('type', 'expense')
                ->where('category', '!=', 'Pembelian Wishlist')
                ->where('date', 'like', $month . '%')
                ->sum('amount');
            
            $leftover = max(0, $ps->amount - $spent);
            if ($leftover > 0) {
                // Format month_year (YYYY-MM) to something more readable like "Jan 2026"
                $dateObj = \Carbon\Carbon::createFromFormat('Y-m', $month);
                $rolloverHistory[] = [
                    'month_name' => $dateObj->translatedFormat('F Y'),
                    'amount' => $leftover
                ];
            }
            $rolloverSavings += $leftover;
        }
        
        // Fetch all manual savings ever added
        $manualSavings = auth()->user()->transactions()
                ->where('type', 'income')
                ->where('category', 'Tabungan Ekstra')
                ->sum('amount');
                
        // Calculate total wishlist purchases
        $wishlistPurchases = auth()->user()->transactions()
                ->where('type', 'expense')
                ->where('category', 'Pembelian Wishlist')
                ->sum('amount');

        // Uang yang sudah dialokasikan ke wishlist yang belum dibeli
        $allocatedToWishlists = auth()->user()->wishlists()->whereNull('purchased_date')->sum('saved_amount');

        $totalTabungan = $rolloverSavings + $manualSavings - $wishlistPurchases - $allocatedToWishlists;

        // Get user's wishlists
        $wishlists = auth()->user()->wishlists()->orderBy('created_at', 'desc')->get();

        // Calculate estimated months for each wishlist
        $wishlistData = $wishlists->map(function ($item) use ($tabunganAmount) {
            $percentage = 0;
            if ($item->price > 0) {
                $percentage = min(100, round(($item->saved_amount / $item->price) * 100));
            }

            $estimatedMonths = null;
            if (!$item->target_date && !$item->purchased_date && $percentage < 100) {
                $remaining = $item->price - $item->saved_amount;
                if ($tabunganAmount > 0) {
                    $estimatedMonths = ceil($remaining / $tabunganAmount);
                } else {
                    $estimatedMonths = -1; // Indicate no monthly savings
                }
            }

            return [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'target_date' => $item->target_date,
                'saved_amount' => $item->saved_amount,
                'purchased_date' => $item->purchased_date,
                'percentage' => $percentage,
                'estimated_months' => $estimatedMonths
            ];
        });

        return view('wishlists.index', compact('wishlistData', 'tabunganAmount', 'totalTabungan', 'rolloverHistory'));
    }

    public function addSavings(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'title' => 'nullable|string|max:255'
        ]);

        Transaction::create([
            'user_id' => auth()->id(),
            'title' => $request->title ?: 'Tabungan Manual',
            'amount' => $request->amount,
            'type' => 'income',
            'account' => 'cash',
            'category' => 'Tabungan Ekstra',
            'date' => date('Y-m-d')
        ]);

        return redirect()->route('wishlists.index')->with('success', 'Berhasil menambahkan uang ke Tabungan Ekstra!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'target_date' => 'nullable|date'
        ]);

        Wishlist::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'price' => $request->price,
            'target_date' => $request->target_date
        ]);

        return redirect()->route('wishlists.index')->with('success', 'Wishlist berhasil ditambahkan!');
    }

    public function update(Request $request, Wishlist $wishlist)
    {
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'target_date' => 'nullable|date'
        ]);

        $wishlist->update([
            'name' => $request->name,
            'price' => $request->price,
            'target_date' => $request->target_date
        ]);

        return redirect()->route('wishlists.index')->with('success', 'Wishlist berhasil diubah!');
    }

    public function allocate(Request $request, Wishlist $wishlist)
    {
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $currentMonth = now()->format('Y-m');
        $previousSalaries = auth()->user()->monthlySalaries()->where('month_year', '<', $currentMonth)->get();
        
        $rolloverSavings = 0;
        foreach($previousSalaries as $ps) {
            $spent = auth()->user()->transactions()
                ->where('type', 'expense')
                ->where('category', '!=', 'Pembelian Wishlist')
                ->where('date', 'like', $ps->month_year . '%')
                ->sum('amount');
            $rolloverSavings += max(0, $ps->amount - $spent);
        }

        $manualSavings = auth()->user()->transactions()->where('category', 'Tabungan Ekstra')->sum('amount');
        $wishlistPurchases = auth()->user()->transactions()->where('category', 'Pembelian Wishlist')->sum('amount');
        $allocatedToWishlists = auth()->user()->wishlists()->whereNull('purchased_date')->sum('saved_amount');
        
        $totalTabungan = $rolloverSavings + $manualSavings - $wishlistPurchases - $allocatedToWishlists;

        if ($request->amount > $totalTabungan) {
            return redirect()->back()->with('error', 'Saldo brankas (Total Tabungan) tidak mencukupi!');
        }

        $wishlist->update([
            'saved_amount' => $wishlist->saved_amount + $request->amount
        ]);

        return redirect()->route('wishlists.index')->with('success', 'Berhasil mengisi tabungan wishlist!');
    }

    public function markPurchased(Request $request, Wishlist $wishlist)
    {
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'purchased_date' => 'required|date'
        ]);

        // Tandai terbeli
        $wishlist->update([
            'purchased_date' => $request->purchased_date
        ]);

        // Potong dari tabungan dengan membuat transaksi pengeluaran
        Transaction::create([
            'user_id' => auth()->id(),
            'title' => 'Beli Wishlist: ' . $wishlist->name,
            'amount' => $wishlist->price,
            'type' => 'expense',
            'account' => 'cash',
            'category' => 'Pembelian Wishlist',
            'date' => $request->purchased_date
        ]);

        return redirect()->route('wishlists.index')->with('success', 'Selamat! Wishlist ' . $wishlist->name . ' berhasil terbeli!');
    }

    public function destroy(Wishlist $wishlist)
    {
        if ($wishlist->user_id !== auth()->id()) {
            abort(403);
        }

        $wishlist->delete();

        return redirect()->route('wishlists.index')->with('success', 'Wishlist berhasil dihapus!');
    }
}

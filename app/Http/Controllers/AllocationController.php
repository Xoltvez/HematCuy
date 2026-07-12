<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Allocation;
use App\Models\Transaction;

class AllocationController extends Controller
{
    public function index()
    {
        $currentMonth = now()->format('Y-m');
        $allocations = auth()->user()->allocations()->where('month_year', $currentMonth)->get();

        $daysInMonth = now()->daysInMonth;
        $currentDay = now()->day;

        $allocationsData = $allocations->map(function ($allocation) use ($currentMonth, $daysInMonth, $currentDay) {
            $spent = auth()->user()->transactions()
                ->where('type', 'expense')
                ->where('category', $allocation->category_name)
                ->where('date', 'like', $currentMonth . '%')
                ->sum('amount');
                
            $remaining = $allocation->amount - $spent;
            $percentage = $allocation->amount > 0 ? min(100, round(($spent / $allocation->amount) * 100)) : 0;
            
            // Smart Insights (Burn Rate & Alert)
            $burnRate = $currentDay > 0 ? $spent / $currentDay : 0;
            $predictedTotalSpent = $burnRate * $daysInMonth;
            
            $status = 'safe'; // safe, warning, danger
            $insight = 'Pengeluaran aman dan terkendali. 👍';
            
            if ($percentage >= 100) {
                $status = 'danger';
                $insight = 'Budget sudah habis! 🛑 Hentikan pengeluaran di pos ini.';
            } else if ($percentage >= 80) {
                $status = 'warning';
                $insight = 'Awas! Budget sudah menipis (' . $percentage . '% terpakai).';
            } else if ($predictedTotalSpent > $allocation->amount && $currentDay >= 3 && $spent > 0) {
                $status = 'warning';
                $daysLeft = floor($remaining / $burnRate);
                $insight = 'Budget diprediksi akan habis dalam ' . $daysLeft . ' hari ke depan.';
            }

            return [
                'id' => $allocation->id,
                'category_name' => $allocation->category_name,
                'amount' => $allocation->amount,
                'spent' => $spent,
                'remaining' => $remaining,
                'percentage' => $percentage,
                'status' => $status,
                'insight' => $insight
            ];
        });

        // Total allocated
        $totalAllocated = $allocations->sum('amount');
        
        // Fetch Monthly Salary
        $salaryRecord = auth()->user()->monthlySalaries()->where('month_year', $currentMonth)->first();
        $monthlySalary = $salaryRecord ? $salaryRecord->amount : 0;
        
        // Total All Spent (semua pengeluaran di bulan ini)
        $totalSpent = auth()->user()->transactions()
                ->where('type', 'expense')
                ->whereNotIn('category', ['Tabungan Ekstra', 'Pembelian Wishlist'])
                ->where('date', 'like', $currentMonth . '%')
                ->sum('amount');
        
        // Tabungan = Gaji - Total Pengeluaran (Bukan Gaji - Total Alokasi)
        $tabunganAmount = max(0, $monthlySalary - $totalSpent);
        
        $monthName = \Carbon\Carbon::createFromFormat('Y-m', $currentMonth)->translatedFormat('F Y');
        
        $tabunganItem = [
            'id' => 'tabungan',
            'category_name' => 'Sisa Uang Bulan Ini',
            'amount' => $tabunganAmount, // Nilai tabungan menyesuaikan sisa uang
            'spent' => 0, // Tabungan tidak punya "terpakai" karena ia sendiri adalah sisa
            'remaining' => $tabunganAmount,
            'percentage' => 0,
            'status' => 'safe',
            'insight' => 'Sisa Uang Bulan ' . $monthName,
            'is_tabungan' => true
        ];
        
        $allocationsData->push($tabunganItem);

        return view('allocations.index', compact('allocationsData', 'currentMonth', 'totalAllocated', 'totalSpent', 'monthlySalary'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0'
        ]);

        $currentMonth = now()->format('Y-m');

        $existing = auth()->user()->allocations()
            ->where('month_year', $currentMonth)
            ->where('category_name', $request->category_name)
            ->first();

        if ($existing) {
            $existing->amount = $request->amount; 
            $existing->save();
        } else {
            Allocation::create([
                'user_id' => auth()->id(),
                'category_name' => $request->category_name,
                'amount' => $request->amount,
                'month_year' => $currentMonth
            ]);
        }

        return redirect()->route('allocations.index')->with('success', 'Alokasi uang berhasil disimpan!');
    }

    public function destroy($id)
    {
        $allocation = Allocation::where('user_id', auth()->id())->findOrFail($id);
        $allocation->delete();

        return redirect()->route('allocations.index')->with('success', 'Pos pengeluaran berhasil dihapus!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0'
        ]);

        $allocation = auth()->user()->allocations()->findOrFail($id);
        
        $allocation->update([
            'category_name' => $request->category_name,
            'amount' => $request->amount
        ]);

        return redirect()->route('allocations.index')->with('success', 'Alokasi berhasil diperbarui!');
    }

    public function saveSalary(Request $request)
    {
        $request->validate([
            'salary' => 'required|numeric|min:0'
        ]);

        $currentMonth = now()->format('Y-m');
        $salaryRecord = auth()->user()->monthlySalaries()->where('month_year', $currentMonth)->first();

        if ($salaryRecord) {
            $salaryRecord->amount = $request->salary;
            $salaryRecord->save();
        } else {
            auth()->user()->monthlySalaries()->create([
                'month_year' => $currentMonth,
                'amount' => $request->salary
            ]);
        }

        return redirect()->route('allocations.index')->with('success', 'Gaji bulanan berhasil disimpan! Tabungan telah diperbarui.');
    }
}

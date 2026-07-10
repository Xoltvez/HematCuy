<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaction;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));

        // Initialize Carbon instance for the requested month/year
        $currentDate = Carbon::createFromDate($year, $month, 1);
        
        $monthName = $currentDate->translatedFormat('F');
        $prevMonth = $currentDate->copy()->subMonth();
        $nextMonth = $currentDate->copy()->addMonth();

        // Get transactions for the current month
        $transactions = auth()->user()->transactions()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        // Get notes with due date for the current month
        $notes = auth()->user()->notes()
            ->whereYear('due_date', $year)
            ->whereMonth('due_date', $month)
            ->get();

        // Group transactions by day (Y-m-d)
        $dailyData = [];
        foreach ($transactions as $t) {
            $date = Carbon::parse($t->date)->format('Y-m-d');
            if (!isset($dailyData[$date])) {
                $dailyData[$date] = [
                    'income' => 0,
                    'expense' => 0,
                    'transactions' => [],
                    'notes' => []
                ];
            }
            if ($t->type === 'income') {
                $dailyData[$date]['income'] += $t->amount;
            } else {
                $dailyData[$date]['expense'] += $t->amount;
            }
            $dailyData[$date]['transactions'][] = $t;
        }

        // Add notes to dailyData
        foreach ($notes as $note) {
            $date = Carbon::parse($note->due_date)->format('Y-m-d');
            if (!isset($dailyData[$date])) {
                $dailyData[$date] = [
                    'income' => 0,
                    'expense' => 0,
                    'transactions' => [],
                    'notes' => []
                ];
            }
            $dailyData[$date]['notes'][] = $note;
        }

        // Build the calendar grid
        $calendar = [];
        
        $startOfMonth = $currentDate->copy()->startOfMonth();
        $endOfMonth = $currentDate->copy()->endOfMonth();

        // ISO format: 1 (Monday) to 7 (Sunday)
        $startDayOfWeek = $startOfMonth->isoWeekday(); 
        
        // Add padding for previous month
        $paddingStart = $startDayOfWeek - 1;
        $prevMonthDate = $startOfMonth->copy()->subDays($paddingStart);
        
        for ($i = 0; $i < $paddingStart; $i++) {
            $calendar[] = [
                'date' => $prevMonthDate->format('Y-m-d'),
                'day' => $prevMonthDate->day,
                'is_current_month' => false,
                'income' => 0,
                'expense' => 0,
                'net' => 0,
                'transactions' => [],
                'notes' => []
            ];
            $prevMonthDate->addDay();
        }

        // Add days for current month
        $currentMonthDate = $startOfMonth->copy();
        while ($currentMonthDate->lte($endOfMonth)) {
            $dateStr = $currentMonthDate->format('Y-m-d');
            $income = $dailyData[$dateStr]['income'] ?? 0;
            $expense = $dailyData[$dateStr]['expense'] ?? 0;
            $dayTransactions = $dailyData[$dateStr]['transactions'] ?? [];
            $dayNotes = $dailyData[$dateStr]['notes'] ?? [];

            $calendar[] = [
                'date' => $dateStr,
                'day' => $currentMonthDate->day,
                'is_current_month' => true,
                'income' => $income,
                'expense' => $expense,
                'net' => $income - $expense,
                'transactions' => $dayTransactions,
                'notes' => $dayNotes
            ];
            $currentMonthDate->addDay();
        }

        // Add padding for next month to complete the last week
        $paddingEnd = 7 - (count($calendar) % 7);
        if ($paddingEnd < 7) {
            $nextMonthDate = $endOfMonth->copy()->addDay();
            for ($i = 0; $i < $paddingEnd; $i++) {
                $calendar[] = [
                    'date' => $nextMonthDate->format('Y-m-d'),
                    'day' => $nextMonthDate->day,
                    'is_current_month' => false,
                    'income' => 0,
                    'expense' => 0,
                    'net' => 0,
                    'transactions' => [],
                    'notes' => []
                ];
                $nextMonthDate->addDay();
            }
        }

        return view('calendar.index', compact(
            'calendar', 
            'month', 
            'year', 
            'monthName', 
            'prevMonth', 
            'nextMonth'
        ));
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('layouts.app', function ($view) {
            $notifications = [];
            
            if (auth()->check()) {
                $user = auth()->user();
                $today = now()->format('Y-m-d');
                $currentMonth = now()->format('Y-m');

                // 1. Daily Budget Check
                if ($user->daily_budget > 0) {
                    $todayExpense = \App\Models\Transaction::where('user_id', $user->id)
                        ->where('type', 'expense')
                        ->whereDate('date', $today)
                        ->sum('amount');
                    
                    if ($todayExpense > $user->daily_budget) {
                        $notifications[] = [
                            'type' => 'alert',
                            'title' => 'Overbudget Harian!',
                            'message' => 'Pengeluaran hari ini (Rp ' . number_format($todayExpense, 0, ',', '.') . ') melebihi batas budget harian Anda (Rp ' . number_format($user->daily_budget, 0, ',', '.') . ').',
                            'action_url' => route('target.index'),
                            'action_text' => 'Lihat Target'
                        ];
                    }
                }

                // 2. Allocation Overbudget Check
                $allocations = \App\Models\Allocation::where('user_id', $user->id)
                    ->where('month_year', $currentMonth)
                    ->get();
                
                foreach ($allocations as $alloc) {
                    $spent = \App\Models\Transaction::where('user_id', $user->id)
                        ->where('type', 'expense')
                        ->where('category', $alloc->category_name)
                        ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$currentMonth])
                        ->sum('amount');
                    
                    if ($spent > $alloc->amount) {
                        $notifications[] = [
                            'type' => 'alert',
                            'title' => 'Alokasi ' . $alloc->category_name . ' Habis!',
                            'message' => 'Pengeluaran ' . $alloc->category_name . ' (Rp ' . number_format($spent, 0, ',', '.') . ') melebihi alokasi (Rp ' . number_format($alloc->amount, 0, ',', '.') . ').',
                            'action_url' => route('allocations.index'),
                            'action_text' => 'Lihat Alokasi'
                        ];
                    }
                }

                // 3. Due Date Note Check
                $dueNotes = \App\Models\Note::where('user_id', $user->id)
                    ->where('due_date', $today)
                    ->where('is_paid', false)
                    ->get();
                
                foreach ($dueNotes as $note) {
                    $notifications[] = [
                        'type' => 'warning',
                        'title' => 'Tagihan Jatuh Tempo',
                        'message' => 'Catatan "' . $note->title . '" jatuh tempo hari ini.',
                        'action_url' => route('notes.index'),
                        'action_text' => 'Bayar Sekarang'
                    ];
                }
            }

            $view->with('notifications', $notifications);
        });
    }
}

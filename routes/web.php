<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\NoteController;

use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtpForm'])->name('otp.verify');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify.submit');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [TransactionController::class, 'index'])->name('dashboard');
    Route::get('/kalkulator', function() { return view('calculator'); })->name('calculator');
    Route::get('/laporan', [TransactionController::class, 'report'])->name('report');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    Route::post('/budget', [TransactionController::class, 'updateBudget'])->name('budget.update');

    Route::resource('notes', NoteController::class)->except(['create', 'show']);

    // Split Bill (Bagi Tagihan AI)
    Route::get('/split-bill', [App\Http\Controllers\BillSplitterController::class, 'index'])->name('splitbill.index');
    Route::post('/split-bill/analyze', [App\Http\Controllers\BillSplitterController::class, 'analyze'])->name('splitbill.analyze');
});

// Webhook untuk Bot WhatsApp (Tanpa Auth Web, karena via API)
Route::post('/api/bot/transaction', [App\Http\Controllers\Api\BotController::class, 'handleWebhook']);

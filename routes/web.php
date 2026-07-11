<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\NoteController;

use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:1,1');
    
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtpForm'])->name('otp.verify');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify.submit');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('otp.resend')->middleware('throttle:1,1');

    // Lupa Password
    Route::get('/forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email')->middleware('throttle:1,1');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [TransactionController::class, 'index'])->name('dashboard');
    Route::get('/riwayat', [TransactionController::class, 'history'])->name('transactions.history');
    
    // Global Search
    Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search.index');
    
    // Export Routes

    Route::get('/riwayat/export/pdf', [TransactionController::class, 'exportPdf'])->name('transactions.export.pdf');

    Route::get('/target-harian', [TransactionController::class, 'target'])->name('target.index');
    Route::get('/kalkulator', function() { return view('calculator'); })->name('calculator');
    Route::get('/laporan', [TransactionController::class, 'report'])->name('report');
    Route::get('/calendar', [App\Http\Controllers\CalendarController::class, 'index'])->name('calendar');
    
    // Transaksi Baru
    Route::get('/transaksi/baru', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');
    
    // Alokasi Uang
    Route::get('/budgeting', [App\Http\Controllers\AllocationController::class, 'index'])->name('allocations.index');
    Route::post('/budgeting', [App\Http\Controllers\AllocationController::class, 'store'])->name('allocations.store');
    Route::post('/budgeting/salary', [App\Http\Controllers\AllocationController::class, 'saveSalary'])->name('allocations.salary');
    Route::delete('/budgeting/{id}', [App\Http\Controllers\AllocationController::class, 'destroy'])->name('allocations.destroy');
    Route::post('/budget', [TransactionController::class, 'updateBudget'])->name('budget.update');

    Route::resource('notes', NoteController::class)->except(['create', 'show']);
    Route::post('/notes/{note}/pay', [NoteController::class, 'pay'])->name('notes.pay');

    // Tabungan & Wishlist
    Route::get('/tabungan', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlists.index');
    Route::post('/tabungan', [App\Http\Controllers\WishlistController::class, 'store'])->name('wishlists.store');
    Route::post('/tabungan/add-savings', [App\Http\Controllers\WishlistController::class, 'addSavings'])->name('wishlists.addSavings');
    Route::put('/tabungan/{wishlist}', [App\Http\Controllers\WishlistController::class, 'update'])->name('wishlists.update');
    Route::post('/tabungan/{wishlist}/allocate', [App\Http\Controllers\WishlistController::class, 'allocate'])->name('wishlists.allocate');
    Route::post('/tabungan/{wishlist}/purchase', [App\Http\Controllers\WishlistController::class, 'markPurchased'])->name('wishlists.purchase');
    Route::delete('/tabungan/{wishlist}', [App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlists.destroy');

    // Catat Struk Belanja AI
    Route::get('/catat-struk', [App\Http\Controllers\ReceiptController::class, 'index'])->name('receipt.index');
    Route::post('/catat-struk/analyze', [App\Http\Controllers\ReceiptController::class, 'analyze'])->name('receipt.analyze');
    Route::post('/catat-struk/store', [App\Http\Controllers\ReceiptController::class, 'store'])->name('receipt.store');

    // Pengaturan & Panduan
    Route::get('/pengaturan', [App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/pengaturan/profil', [App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::post('/pengaturan/reset-akun', [App\Http\Controllers\SettingsController::class, 'resetAccount'])->name('settings.reset');
    Route::get('/panduan', function() { return view('guide.index'); })->name('guide.index');

    // Ubah Password
    Route::get('/password/change', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/password/change', [AuthController::class, 'updatePassword']);
});

// Webhook untuk Bot WhatsApp (Tanpa Auth Web, karena via API)
Route::post('/api/bot/transaction', [App\Http\Controllers\Api\BotController::class, 'handleWebhook']);

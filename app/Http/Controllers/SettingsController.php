<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function resetAccount(Request $request)
    {
        $user = auth()->user();

        try {
            DB::beginTransaction();

            // Hapus semua data yang berhubungan dengan user
            $user->transactions()->delete();
            $user->notes()->delete();
            $user->allocations()->delete();
            $user->monthlySalaries()->delete();
            $user->wishlists()->delete();

            // Reset profil terkait budgeting
            $user->update([
                'daily_budget' => null,
                'daily_alert_sent_at' => null
            ]);

            DB::commit();

            return redirect()->route('dashboard')->with('success', 'Semua aktivitas akun Anda telah berhasil direset. Silakan mulai lembaran baru!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal mereset akun: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mereset akun. Silakan coba lagi.');
        }
    }
}

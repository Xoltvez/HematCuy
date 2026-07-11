<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Simpan foto baru
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $data['profile_photo_path'] = $path;
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui.');
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

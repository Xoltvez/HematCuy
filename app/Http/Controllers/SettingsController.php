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
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $data = [
            'name' => $request->name,
        ];

        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada (hanya jika tersimpan di disk public_uploads / public)
            if ($user->profile_photo_path && file_exists(public_path($user->profile_photo_path))) {
                unlink(public_path($user->profile_photo_path));
            }

            // Simpan foto baru langsung ke folder public/uploads
            $path = $request->file('profile_photo')->store('profile-photos', 'public_uploads');
            $data['profile_photo_path'] = 'uploads/' . $path;
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui.');
    }

    public function updateNotifications(Request $request)
    {
        $user = auth()->user();
        $key = $request->input('key');
        $value = filter_var($request->input('value'), FILTER_VALIDATE_BOOLEAN);

        $allowedKeys = ['alert_daily_budget', 'alert_weekly_report', 'alert_email'];

        if (in_array($key, $allowedKeys)) {
            $user->update([$key => $value]);
            return response()->json(['success' => true, 'message' => 'Pengaturan berhasil disimpan.']);
        }

        return response()->json(['success' => false, 'message' => 'Key tidak valid.'], 400);
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

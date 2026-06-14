<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class BotController extends Controller
{
    public function handleWebhook(Request $request)
    {
        // Validasi Token Rahasia
        $token = $request->header('Authorization');
        if ($token !== 'Bearer RAHASIA_HEMATCUY_123') {
            Log::warning('Unauthorized bot access attempt', ['ip' => $request->ip()]);
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $message = trim($request->input('message', ''));
        
        // Pattern: [Pemasukan/Pengeluaran] [Nominal] [Judul] [Kategori (opsional)]
        // Contoh: Pemasukan 5000000 Gaji Bulanan Gaji
        // Contoh: Pengeluaran 20000 Makan Siang Makanan
        
        $parts = explode(' ', $message);
        
        if (count($parts) >= 3) {
            $typeStr = strtolower($parts[0]);
            
            $type = null;
            if ($typeStr === 'pemasukan' || $typeStr === 'masuk') {
                $type = 'income';
            } elseif ($typeStr === 'pengeluaran' || $typeStr === 'keluar') {
                $type = 'expense';
            }

            if ($type) {
                $account = 'cash'; // default
                $cleanParts = [];
                
                foreach ($parts as $part) {
                    if (str_starts_with($part, '#')) {
                        $tag = strtolower(substr($part, 1)); // Hilangkan tanda '#'
                        if (in_array($tag, ['bank', 'tunai', 'cash'])) {
                            $account = ($tag === 'tunai' || $tag === 'cash') ? 'cash' : 'bank';
                        }
                    } else {
                        $cleanParts[] = $part;
                    }
                }
                
                // Sekarang $cleanParts berisi: [0] => Type, [1] => Nominal, sisanya judul + kategori
                $amount = isset($cleanParts[1]) ? (float) preg_replace('/[^0-9]/', '', $cleanParts[1]) : 0;
                
                $category = 'Lainnya';
                $titleParts = array_slice($cleanParts, 2);
                
                // Jika ada lebih dari 1 kata setelah nominal, kata terakhir adalah kategori
                if (count($titleParts) > 1) {
                    $category = array_pop($titleParts);
                }
                
                $title = count($titleParts) > 0 ? implode(' ', $titleParts) : 'Transaksi WhatsApp';

                $transactionData = [
                    'title' => $title,
                    'amount' => $amount,
                    'type' => $type,
                    'account' => $account,
                    'category' => $category,
                    'date' => date('Y-m-d'),
                ];

                $user = \App\Models\User::first();
                if ($user) {
                    $transactionData['user_id'] = $user->id;
                }

                Transaction::create($transactionData);

                return response()->json(['success' => true, 'message' => 'Transaksi berhasil dicatat via WhatsApp!']);
            }
        }
        
        return response()->json(['error' => 'Format salah. Gunakan: [Pemasukan/Pengeluaran] [Bank/Tunai] [Nominal] [Judul] [Kategori]'], 400);
    }
}

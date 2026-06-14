<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BillSplitterController extends Controller
{
    public function index()
    {
        return view('splitbill.index');
    }

    public function analyze(Request $request)
    {
        $request->validate([
            'receipt_image' => 'required|image|max:5120', // Max 5MB
        ]);

        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'API Key Gemini belum diatur di file .env'
            ], 500);
        }

        try {
            $imagePath = $request->file('receipt_image')->getPathname();
            $mimeType = $request->file('receipt_image')->getMimeType();
            $base64Image = base64_encode(file_get_contents($imagePath));

            $prompt = 'Kamu adalah asisten kasir ahli. Ekstrak data dari gambar struk/nota makanan ini. ' .
                'Kembalikan HANYA format JSON valid tanpa format markdown (tanpa ```json ... ```), dengan struktur berikut: ' .
                '{"items": [{"name": "nama item", "price": 15000, "qty": 1}], "subtotal": 15000, "tax": 1500, "service_charge": 0, "total": 16500}. ' .
                'Pastikan tipe data harga/nominal adalah angka (integer) tanpa titik/koma. Jika ada item yang gratis atau tidak jelas harganya, harganya jadikan 0.';

            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

            $response = Http::withoutVerifying()->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                            [
                                'inline_data' => [
                                    'mime_type' => $mimeType,
                                    'data' => $base64Image
                                ]
                            ]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $result = $response->json();
                
                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    $jsonText = $result['candidates'][0]['content']['parts'][0]['text'];
                    
                    // Bersihkan dari potensi markdown jika model bandel
                    $jsonText = str_replace(['```json', '```'], '', $jsonText);
                    $jsonText = trim($jsonText);

                    $data = json_decode($jsonText, true);
                    
                    if (json_last_error() === JSON_ERROR_NONE) {
                        return response()->json([
                            'success' => true,
                            'data' => $data
                        ]);
                    }
                }
                
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membaca format JSON dari respon AI.'
                ], 500);

            } else {
                Log::error('Gemini API Error: ' . $response->body());
                $errorMsg = 'Gagal menghubungi server AI.';
                if ($response->json('error.message')) {
                    $errorMsg .= ' (Pesan dari Google: ' . $response->json('error.message') . ')';
                }
                return response()->json([
                    'success' => false,
                    'message' => $errorMsg
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Split Bill Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }
}

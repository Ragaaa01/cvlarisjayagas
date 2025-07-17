<?php

namespace App\Http\Controllers\API\Firebase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FcmTokenController extends Controller
{
    public function store(Request $request)
    {

        Log::info('Menerima request untuk menyimpan FCM Token.');
        Log::info('Payload:', $request->all());

        $validated = $request->validate([
            'token' => 'required|string',
            'nama_perangkat' => 'nullable|string',
        ]);

        $user = $request->user();

        if (!$user) {
            Log::warning('Gagal menyimpan FCM Token: User tidak terautentikasi.');
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        try {
            // Simpan atau perbarui token untuk user dan perangkat ini
            $user->fcmTokens()->updateOrCreate(
                [
                    // Gunakan 'id_akun' untuk memastikan keunikan per user
                    'id_akun' => $user->id_akun,
                    'nama_perangkat' => $validated['nama_perangkat'] ?? 'unknown_device',
                ],
                [
                    'token' => $validated['token'],
                ]
            );

            Log::info("FCM Token untuk user ID {$user->id_akun} berhasil disimpan.");
            return response()->json(['success' => true, 'message' => 'FCM token berhasil disimpan.']);
        } catch (\Exception $e) {
            Log::error("Database error saat menyimpan FCM Token: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menyimpan token di server.'], 500);
        }
    }
}

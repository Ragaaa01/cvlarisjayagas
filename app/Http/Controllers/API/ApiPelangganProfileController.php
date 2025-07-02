<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiPeroranganResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ApiPelangganProfileController extends Controller
{
    /**
     * Memastikan semua method di controller ini dilindungi oleh autentikasi.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Mengambil data profil pelanggan yang sedang login.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $user = $request->user();
        $perorangan = $user->perorangan;

        // Jika data perorangan tidak ada, beri error
        if (!$perorangan) {
            return response()->json(['success' => false, 'message' => 'Data profil tidak ditemukan.'], 404);
        }

        // --- TAMBAHKAN BARIS INI ---
        // Memuat relasi 'akun' pada objek perorangan
        $perorangan->load('akun');

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diambil',
            'data' => new ApiPeroranganResource($perorangan),
        ]);
    }

    /**
     * Memperbarui data profil pelanggan yang sedang login.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = $request->user();
        $perorangan = $user->perorangan;

        // Jika data perorangan tidak ditemukan, kembalikan error.
        if (!$perorangan) {
            return response()->json(['success' => false, 'message' => 'Data profil tidak ditemukan.'], 404);
        }

        // Validasi data yang masuk (hanya nomor telepon dan alamat)
        $validatedData = $request->validate([
            'no_telepon' => ['required', 'string', 'max:15'],
            'alamat' => ['required', 'string', 'max:255'],
        ]);

        try {
            // Memperbarui data pada record perorangan yang ada
            $perorangan->update([
                'no_telepon' => $validatedData['no_telepon'],
                'alamat' => $validatedData['alamat'],
            ]);

            // Muat ulang data untuk memastikan respons berisi data terbaru
            $perorangan->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui',
                'data' => new ApiPeroranganResource($perorangan),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal memperbarui profil pelanggan: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'payload' => $request->all(),
            ]);
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui profil.'], 500);
        }
    }
}

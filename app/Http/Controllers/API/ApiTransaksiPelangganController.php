<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiTransaksiResource;
use App\Models\Transaksi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiTransaksiPelangganController extends Controller
{
    public function __construct()
    {
        // Pastikan semua method di controller ini dilindungi oleh autentikasi.
        $this->middleware('auth:sanctum');
    }

    /**
     * Mengambil semua riwayat transaksi milik pelanggan yang sedang login.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getTransaksi(Request $request): JsonResponse
    {
        try {
            // Mengambil data user yang terautentikasi
            $user = Auth::user();

            // Jika user tidak ditemukan, kembalikan error.
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 401);
            }

            // Mengambil semua transaksi yang berelasi dengan id_akun user.
            $transaksis = Transaksi::where('id_akun', $user->id_akun)
                // --- PERBAIKAN UTAMA DI SINI ---
                // Memuat semua relasi yang dibutuhkan oleh Flutter dalam satu query.
                ->with([
                    'statusTransaksi',
                    'latestTagihan',      // WAJIB untuk status dan sisa tagihan terakhir.
                    'detailTransaksis'    // WAJIB untuk menghitung jumlah item.
                ])
                ->latest() // Mengurutkan dari yang terbaru
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Riwayat transaksi berhasil diambil',
                'data' => ApiTransaksiResource::collection($transaksis),
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil riwayat transaksi pelanggan: ' . $e->getMessage(), [
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data transaksi: Terjadi kesalahan pada server.',
            ], 500);
        }
    }
}

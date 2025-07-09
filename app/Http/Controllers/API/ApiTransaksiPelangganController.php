<?php

namespace App\Http\Controllers\API;

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

            // Jika user tidak ditemukan (seharusnya tidak terjadi karena middleware), kembalikan error.
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                ], 401);
            }

            // Mengambil semua transaksi yang berelasi dengan id_akun user.
            // Memuat relasi yang dibutuhkan oleh aplikasi Flutter:
            // - tagihan: Untuk menampilkan status lunas/belum lunas.
            // - detailTransaksis: Untuk menghitung jumlah item.
            $transaksis = Transaksi::with(['tagihan', 'detailTransaksis'])
                ->where('id_akun', $user->id_akun)
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

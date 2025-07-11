<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiRiwayatTransaksiResource;
use App\Models\RiwayatTransaksi;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiRiwayatTransaksiController extends Controller
{
    //
    public function index(Request $request)
    {
        // Ambil data riwayat, urutkan dari yang terbaru
        $riwayat = RiwayatTransaksi::query()
            ->with(['akun.perorangan', 'perorangan', 'perusahaan']) // Eager load relasi untuk data pelanggan
            ->latest('tanggal_selesai') // Urutkan berdasarkan tanggal selesai
            ->paginate(15); // Gunakan pagination!

        // Gunakan API Resource untuk transformasi data yang bersih
        return ApiRiwayatTransaksiResource::collection($riwayat);
    }

    // /**
    //  * Mengambil daftar semua riwayat transaksi.
    //  *
    //  * @param Request $request
    //  * @return JsonResponse
    //  */
    // public function index(Request $request): JsonResponse
    // {
    //     try {
    //         // Eager load relasi 'perorangan' dan 'akun.perorangan' untuk mendapatkan nama pelanggan
    //         $riwayat = RiwayatTransaksi::with(['perorangan', 'akun.perorangan', 'akun.perorangan.perusahaan'])
    //             ->latest('tanggal_transaksi') // Urutkan dari yang terbaru
    //             ->get();

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Data riwayat transaksi berhasil diambil',
    //             'data' => ApiRiwayatTransaksiResource::collection($riwayat)
    //         ], 200);
    //     } catch (\Exception $e) {
    //         Log::error('Gagal mengambil riwayat transaksi: ' . $e->getMessage());
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Terjadi kesalahan pada server saat mengambil riwayat transaksi.',
    //         ], 500);
    //     }
    // }
}

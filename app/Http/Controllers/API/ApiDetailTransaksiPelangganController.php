<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiTagihanResource;
use App\Http\Resources\ApiTransaksiResource;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiDetailTransaksiPelangganController extends Controller
{
    /**
     * Menampilkan detail satu transaksi milik pelanggan yang sedang login.
     */
    public function show(Request $request, Transaksi $transaksi)
    {
        // --- KEAMANAN PENTING ---
        // Pastikan transaksi yang diminta adalah milik user yang sedang login.
        if ($request->user()->id_akun !== $transaksi->id_akun) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses ke transaksi ini.',
            ], 403); // 403 Forbidden
        }

        // Muat semua relasi yang dibutuhkan oleh frontend
        $transaksi->load([
            'statusTransaksi',
            'latestTagihan',
            'detailTransaksis.tabung.jenisTabung',
            'detailTransaksis.jenisTransaksi'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Detail transaksi berhasil diambil.',
            'data' => new ApiTransaksiResource($transaksi)
        ]);
    }

    /**
     * Mengambil semua riwayat pembayaran (tagihan) untuk satu transaksi.
     */
    public function getRiwayatPembayaran(Request $request, Transaksi $transaksi)
    {
        // Keamanan: Pastikan transaksi ini milik user yang sedang login
        if ($request->user()->id_akun !== $transaksi->id_akun) {
            return response()->json(['success' => false, 'message' => 'Akses ditolak.'], 403);
        }

        // Ambil semua record tagihan yang terkait dengan transaksi ini
        $riwayatPembayaran = $transaksi->tagihans()->latest('tanggal_bayar_tagihan')->get();

        return response()->json([
            'success' => true,
            'message' => 'Riwayat pembayaran berhasil diambil.',
            // Kita bisa gunakan resource yang sama untuk konsistensi
            'data'    => ApiTagihanResource::collection($riwayatPembayaran)
        ]);
    }
}

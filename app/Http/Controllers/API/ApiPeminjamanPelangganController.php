<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiPeminjamanResource;
use App\Models\Peminjaman;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiPeminjamanPelangganController extends Controller
{
    /**
     * Menampilkan daftar peminjaman aktif milik pelanggan yang sedang login.
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized',
                    'data'    => null
                ], 401);
            }

            $peminjamanAktif = Peminjaman::where('status_pinjam', 'aktif')
                ->whereHas('detailTransaksi.transaksi', function ($query) use ($user) {
                    $query->where('id_akun', $user->id_akun);
                })
                ->with([
                    'detailTransaksi.tabung.jenisTabung',
                    'detailTransaksi.transaksi'
                ])
                ->latest('tanggal_pinjam')
                ->get();

            // --- PERUBAHAN DI SINI ---
            // Mengembalikan data dalam format JSON standar
            return response()->json([
                'success' => true,
                'message' => 'Daftar peminjaman aktif berhasil diambil.',
                'data'    => ApiPeminjamanResource::collection($peminjamanAktif)
            ], 200);
        } catch (Exception $e) {
            // Mencatat error untuk keperluan debugging
            Log::error('Gagal mengambil peminjaman pelanggan: ' . $e->getMessage());

            // Mengembalikan respons error dalam format JSON standar
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data.',
                'data'    => null
            ], 500);
        }
    }
}

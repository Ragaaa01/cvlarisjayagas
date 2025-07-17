<?php

namespace App\Http\Controllers\API\Pelanggan;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotifikasiResource;
use App\Models\Notifikasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiNotifikasiPelangganController extends Controller
{
    /**
     * Menampilkan daftar notifikasi milik pelanggan yang sedang login.
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();

            $notifikasis = Notifikasi::whereHas('tagihan.transaksi', function ($query) use ($user) {
                $query->where('id_akun', $user->id_akun);
            })
                ->with('template')
                ->latest('created_at')
                ->paginate(20);

            // --- Mengembalikan data dalam format JSON standar ---
            return response()->json([
                'success' => true,
                'message' => 'Daftar notifikasi berhasil diambil.',
                'data'    => NotifikasiResource::collection($notifikasis)
            ], 200);
        } catch (Exception $e) {
            Log::error('Gagal mengambil notifikasi pelanggan: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data.',
                'data'    => null
            ], 500);
        }
    }

    /**
     * Menandai satu notifikasi sebagai sudah dibaca.
     */
    public function markAsRead(Request $request, Notifikasi $notifikasi)
    {
        try {
            // Keamanan: Pastikan notifikasi ini milik user yang sedang login
            if ($request->user()->id_akun !== $notifikasi->tagihan->transaksi->id_akun) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak.',
                    'data'    => null
                ], 403);
            }

            // Update status baca
            $notifikasi->status_baca = true;
            $notifikasi->save();

            // --- Mengembalikan data dalam format JSON standar ---
            return response()->json([
                'success' => true,
                'message' => 'Notifikasi ditandai sebagai sudah dibaca.',
                'data'    => null // Tidak perlu mengirim data kembali untuk aksi ini
            ]);
        } catch (Exception $e) {
            Log::error("Gagal menandai notifikasi #{$notifikasi->id_notifikasi} sebagai dibaca: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server.',
                'data'    => null
            ], 500);
        }
    }
}

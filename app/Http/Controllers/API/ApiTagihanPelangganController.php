<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiTagihanResource; // Gunakan resource yang sudah ada
use App\Models\Tagihan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ApiTagihanPelangganController extends Controller
{
    /**
     * Menampilkan daftar semua tagihan milik pelanggan yang sedang login.
     */
    public function index(Request $request)
    {
        try {
            $user = Auth::user();

            $tagihan = Tagihan::whereHas('transaksi', function ($query) use ($user) {
                $query->where('id_akun', $user->id_akun);
            })
                ->with('transaksi')
                ->latest()
                ->paginate(15);

            return response()->json([
                'success' => true,
                'message' => 'Daftar tagihan berhasil diambil.',
                'data'    => ApiTagihanResource::collection($tagihan)
            ], 200);
        } catch (Exception $e) {
            Log::error('Gagal mengambil tagihan pelanggan: ' . $e->getMessage());

            // Mengembalikan respons error dalam format JSON standar
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data tagihan.',
                'data'    => null
            ], 500);
        }
    }
}

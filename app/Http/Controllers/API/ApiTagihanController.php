<?php

namespace App\Http\Controllers\Api;

use App\Events\TransactionStatusCheck;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApiTagihanResource;
use App\Models\Tagihan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiTagihanController extends Controller
{
    /**
     * Menampilkan daftar semua tagihan dengan filter dan pagination.
     */
    public function index(Request $request)
    {
        // 1. Validasi input filter
        $request->validate([
            'status' => 'nullable|string|in:lunas,belum_lunas',
            'search' => 'nullable|string|max:255',
        ]);

        // 2. Mulai query dasar dengan eager loading relasi yang dibutuhkan
        $tagihanQuery = Tagihan::query()->with([
            'transaksi.akun.perorangan',
            'transaksi.perorangan'
        ]);

        // 3. Terapkan filter berdasarkan status
        if ($request->filled('status')) {
            $tagihanQuery->where('status', $request->status);
        }

        // 4. Terapkan filter berdasarkan pencarian
        $tagihanQuery->when($request->filled('search'), function ($query, $search) {
            return $query->whereHas('transaksi', function ($q) use ($search) {
                // Cari berdasarkan ID Transaksi
                $q->where('id_transaksi', 'like', "%{$search}%")
                    // ATAU cari berdasarkan nama pelanggan
                    ->orWhereHas('perorangan', function ($subq) use ($search) {
                        $subq->where('nama_lengkap', 'like', "%{$search}%");
                    })
                    ->orWhereHas('akun.perorangan', function ($subq) use ($search) {
                        $subq->where('nama_lengkap', 'like', "%{$search}%");
                    });
            });
        });

        // 5. Urutkan dari yang terbaru dan gunakan pagination
        $tagihans = $tagihanQuery->latest()->paginate(20);

        // 6. Kembalikan data menggunakan API Resource
        return ApiTagihanResource::collection($tagihans);
    }

    /**
     * Mencatat pembayaran baru untuk sebuah tagihan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\JsonResponse
     */
    public function bayar(Request $request, Tagihan $tagihan)
    {
        // 1. Validasi input dari Flutter
        $validated = $request->validate([
            'jumlah_bayar' => 'required|numeric|min:1',
        ]);

        // Pastikan tagihan belum lunas
        if ($tagihan->status === 'lunas') {
            return response()->json(['message' => 'Tagihan ini sudah lunas.'], 422);
        }

        $jumlahBayar = (float) $validated['jumlah_bayar'];

        // Pastikan pembayaran tidak melebihi sisa tagihan
        if ($jumlahBayar > $tagihan->sisa) {
            return response()->json([
                'message' => 'Jumlah pembayaran melebihi sisa tagihan. Sisa: ' . $tagihan->sisa,
            ], 422);
        }

        // 2. Gunakan DB Transaction untuk keamanan data finansial
        try {
            DB::transaction(function () use ($tagihan, $jumlahBayar) {
                // 3. Update record tagihan
                $tagihan->jumlah_dibayar += $jumlahBayar;
                $tagihan->sisa -= $jumlahBayar;
                $tagihan->tanggal_bayar_tagihan = now();

                // 4. Update status jika lunas
                if ($tagihan->sisa <= 0) {
                    $tagihan->sisa = 0; // Pastikan sisa tidak negatif
                    $tagihan->status = 'lunas';
                }

                $tagihan->save();

                // 5. Update juga total pembayaran di tabel transaksi utama
                $transaksi = $tagihan->transaksi;
                $transaksi->jumlah_dibayar += $jumlahBayar;
                $transaksi->save();

                // 6. Panggil Event untuk cek apakah transaksi sudah selesai total
                if ($tagihan->status === 'lunas') {
                    event(new TransactionStatusCheck($transaksi));
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil dicatat.',
                'data' => $tagihan->fresh(), // Kirim kembali data tagihan terbaru
            ]);
        } catch (Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat memproses pembayaran.'], 500);
        }
    }
}

```php
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ApiTagihanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role !== 'pelanggan') {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses hanya untuk pelanggan'
                ], 403);
            }
            return $next($request);
        });
    }

    /**
     * Get all tagihan pelanggan.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = Auth::user();
        $tagihans = Tagihan::with(['transaksi.detailTransaksis.tabung.jenisTabung'])
            ->whereHas('transaksi', function ($query) use ($user) {
                $query->where('id_akun', $user->id_akun);
            })
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tagihans->map(function ($tagihan) {
                return [
                    'id_tagihan' => $tagihan->id_tagihan,
                    'id_transaksi' => $tagihan->transaksi->id_transaksi,
                    'jumlah_dibayar' => $tagihan->jumlah_dibayar,
                    'sisa' => $tagihan->sisa,
                    'status' => $tagihan->status,
                    'tanggal_bayar_tagihan' => $tagihan->tanggal_bayar_tagihan,
                    'hari_keterlambatan' => $tagihan->hari_keterlambatan,
                    'transaksi' => [
                        'tanggal_transaksi' => $tagihan->transaksi->tanggal_transaksi,
                        'metode_pembayaran' => $tagihan->transaksi->metode_pembayaran,
                        'items' => $tagihan->transaksi->detailTransaksis->map(function ($detail) {
                            return [
                                'id_tabung' => $detail->tabung->id_tabung,
                                'kode_tabung' => $detail->tabung->kode_tabung,
                                'nama_jenis' => $detail->tabung->jenisTabung->nama_jenis,
                                'harga' => $detail->harga,
                                'total_transaksi' => $detail->total_transaksi,
                            ];
                        })
                    ]
                ];
            })
        ], 200);
    }

    /**
     * Update pembayaran tagihan.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePembayaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_tagihan' => 'required|exists:tagihans,id_tagihan',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:tunai,transfer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        return DB::transaction(function () use ($request) {
            $user = Auth::user();
            $tagihan = Tagihan::where('id_tagihan', $request->id_tagihan)
                ->whereHas('transaksi', function ($query) use ($user) {
                    $query->where('id_akun', $user->id_akun);
                })
                ->firstOrFail();

            $newJumlahDibayar = $tagihan->jumlah_dibayar + $request->jumlah_dibayar;
            $sisa = $tagihan->sisa - $request->jumlah_dibayar;

            if ($sisa < 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jumlah pembayaran melebihi sisa tagihan',
                ], 422);
            }

            $tagihan->update([
                'jumlah_dibayar' => $newJumlahDibayar,
                'sisa' => $sisa,
                'status' => $sisa == 0 ? 'lunas' : 'belum_lunas',
                'tanggal_bayar_tagihan' => $sisa == 0 ? Carbon::now() : $tagihan->tanggal_bayar_tagihan,
            ]);

            $transaksi = $tagihan->transaksi;
            $transaksi->update([
                'jumlah_dibayar' => $newJumlahDibayar,
                'metode_pembayaran' => $request->metode_pembayaran,
                'id_status_transaksi' => $sisa == 0 ? 2 : 1, // Success or Pending
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pembayaran berhasil diperbarui',
                'data' => [
                    'id_tagihan' => $tagihan->id_tagihan,
                    'jumlah_dibayar' => $tagihan->jumlah_dibayar,
                    'sisa' => $tagihan->sisa,
                    'status' => $tagihan->status,
                    'tanggal_bayar_tagihan' => $tagihan->tanggal_bayar_tagihan,
                ]
            ], 200);
        });
    }

    /**
     * Get the nearest due date for the authenticated customer.
     * @return JsonResponse
     */
    public function getNearestDueDate()
    {
        try {
            $user = Auth::user();
            $nearestDue = Tagihan::whereHas('transaksi', function ($query) use ($user) {
                $query->where('id_akun', $user->id_akun);
            })
            ->where('status', 'belum_lunas')
            ->whereNotNull('transaksi.tanggal_jatuh_tempo')
            ->join('transaksis', 'tagihans.id_transaksi', '=', 'transaksis.id_transaksi')
            ->orderBy('transaksis.tanggal_jatuh_tempo', 'asc')
            ->select('transaksis.tanggal_jatuh_tempo as due_date')
            ->first();

            return response()->json([
                'success' => true,
                'data' => [
                    'due_date' => $nearestDue ? $nearestDue->due_date : null,
                ],
            ], 200);
        } catch (Exception $e) {
            \Log::error('Gagal mengambil tanggal jatuh tempo terdekat', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tanggal jatuh tempo: ' . $e->getMessage(),
            ], 500);
        }
    }
}
```
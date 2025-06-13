<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Tabung;
use App\Models\StatusTransaksi;
use App\Models\Tagihan;
use App\Models\Peminjaman;
use App\Models\JenisTabung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ApiTransaksiController extends Controller
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

    // Definisikan konstanta untuk status tagihan dan transaksi
    const STATUS_TAGIHAN_LUNAS = 'lunas';
    const STATUS_TAGIHAN_BELUM_LUNAS = 'belum_lunas';
    const STATUS_TRANSAKSI_SUCCESS = 2; // id_status_transaksi untuk success
    const STATUS_TRANSAKSI_PENDING = 1; // id_status_transaksi untuk pending
    const STATUS_TRANSAKSI_FAILED = 3;  // id_status_transaksi untuk failed

    /**
     * Create peminjaman transaksi.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createPeminjaman(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.id_jenis_tabung' => 'required|exists:jenis_tabungs,id_jenis_tabung',
            'items.*.jumlah' => 'required|integer|min:1',
            'metode_pembayaran' => 'required|in:tunai,transfer',
            'jumlah_dibayar' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        return $this->processTransaksi($request, 'peminjaman');
    }

    /**
     * Create isi ulang transaksi.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createIsiUlang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.id_jenis_tabung' => 'required|exists:jenis_tabungs,id_jenis_tabung',
            'items.*.jumlah' => 'required|integer|min:1',
            'metode_pembayaran' => 'required|in:tunai,transfer',
            'jumlah_dibayar' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        return $this->processTransaksi($request, 'isi ulang');
    }

    /**
     * Create combined peminjaman and isi ulang transaksi.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createGabungan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'items' => 'required|array',
            'items.*.id_jenis_tabung' => 'required|exists:jenis_tabungs,id_jenis_tabung',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.jenis_transaksi' => 'required|in:peminjaman,isi ulang',
            'metode_pembayaran' => 'required|in:tunai,transfer',
            'jumlah_dibayar' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        return $this->processTransaksi($request, 'gabungan');
    }

    /**
     * Process transaksi (peminjaman, isi ulang, or gabungan).
     * @param Request $request
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     */
    private function processTransaksi(Request $request, $type)
    {
        try {
            return DB::transaction(function () use ($request, $type) {
                $user = Auth::user();
                $items = $request->items;
                $total_transaksi = 0;
                $allocated_tubes = [];

                // Validasi ketersediaan tabung berdasarkan jenis tabung
                foreach ($items as $item) {
                    $jumlah = $item['jumlah'];
                    $available_tubes = Tabung::where('id_jenis_tabung', $item['id_jenis_tabung'])
                        ->where('id_status_tabung', 1) // Tersedia
                        ->count();

                    if ($available_tubes < $jumlah) {
                        $jenis_tabung = JenisTabung::find($item['id_jenis_tabung'])->nama_jenis;
                        throw new \Exception("Jumlah tabung {$jenis_tabung} yang tersedia ($available_tubes) kurang dari yang diminta ($jumlah)");
                    }
                }

                // Buat transaksi
                $transaksi = Transaksi::create([
                    'id_akun' => $user->id_akun,
                    'id_perorangan' => $user->id_perorangan,
                    'tanggal_transaksi' => Carbon::now(),
                    'waktu_transaksi' => Carbon::now()->toTimeString(),
                    'jumlah_dibayar' => $request->jumlah_dibayar,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'id_status_transaksi' => self::STATUS_TRANSAKSI_PENDING,
                    'tanggal_jatuh_tempo' => $type === 'isi ulang' ? null : Carbon::now()->addDays(30),
                ]);

                Log::info('Transaksi dibuat', ['id_transaksi' => $transaksi->id_transaksi]);

                // Proses item transaksi dan alokasi tabung
                foreach ($items as $item) {
                    $jumlah = $item['jumlah'];
                    $jenis_tabung = JenisTabung::find($item['id_jenis_tabung']);
                    $harga = $jenis_tabung->harga;

                    // Ambil tabung yang tersedia untuk jenis ini
                    $tubes = Tabung::where('id_jenis_tabung', $item['id_jenis_tabung'])
                        ->where('id_status_tabung', 1)
                        ->take($jumlah)
                        ->get();

                    foreach ($tubes as $tube) {
                        $total_item = $harga;
                        $jenis_transaksi_id = $type === 'gabungan' ?
                            ($item['jenis_transaksi'] === 'peminjaman' ? 1 : 2) :
                            ($type === 'peminjaman' ? 1 : 2);

                        // Buat detail transaksi
                        $detail = DetailTransaksi::create([
                            'id_transaksi' => $transaksi->id_transaksi,
                            'id_tabung' => $tube->id_tabung,
                            'id_jenis_transaksi' => $jenis_transaksi_id,
                            'harga' => $harga,
                            'total_transaksi' => $total_item,
                            'batas_waktu_peminjaman' => $type === 'isi ulang' ? null : Carbon::now()->addDays(30),
                        ]);

                        $total_transaksi += $total_item;

                        // Update status tabung untuk peminjaman
                        if ($type === 'peminjaman' || ($type === 'gabungan' && $item['jenis_transaksi'] === 'peminjaman')) {
                            $tube->update(['id_status_tabung' => 2]); // Dipinjam
                            Peminjaman::create([
                                'id_detail_transaksi' => $detail->id_detail_transaksi,
                                'tanggal_pinjam' => Carbon::now(),
                                'status_pinjam' => 'aktif',
                            ]);
                        }

                        // Simpan tabung yang dialokasikan untuk respons
                        $allocated_tubes[] = [
                            'id_tabung' => $tube->id_tabung,
                            'kode_tabung' => $tube->kode_tabung,
                            'nama_jenis' => $jenis_tabung->nama_jenis,
                            'harga' => $harga,
                            'total_transaksi' => $total_item,
                            'jenis_transaksi' => $jenis_transaksi_id === 1 ? 'peminjaman' : 'isi ulang',
                        ];
                    }
                }

                // Log data tagihan sebelum dibuat
                $tagihan_data = [
                    'id_transaksi' => $transaksi->id_transaksi,
                    'jumlah_dibayar' => $request->jumlah_dibayar,
                    'sisa' => $total_transaksi - $request->jumlah_dibayar,
                    'status' => $request->jumlah_dibayar >= $total_transaksi ? self::STATUS_TAGIHAN_LUNAS : self::STATUS_TAGIHAN_BELUM_LUNAS,
                    'periode_ke' => 1,
                    'hari_keterlambatan' => 0,
                ];
                Log::info('Membuat tagihan', $tagihan_data);

                // Buat tagihan
                $tagihan = Tagihan::create($tagihan_data);

                if (!$tagihan) {
                    Log::error('Gagal membuat tagihan', ['id_transaksi' => $transaksi->id_transaksi]);
                    throw new \Exception('Gagal membuat tagihan');
                }

                // Tentukan status transaksi berdasarkan status tagihan
                $status_transaksi = $tagihan->status === self::STATUS_TAGIHAN_LUNAS ?
                    self::STATUS_TRANSAKSI_SUCCESS :
                    self::STATUS_TRANSAKSI_PENDING;

                // Update status transaksi
                $transaksi->update([
                    'id_status_transaksi' => $status_transaksi,
                ]);

                Log::info('Transaksi diperbarui', ['id_transaksi' => $transaksi->id_transaksi, 'status' => $status_transaksi]);

                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi berhasil dibuat',
                    'data' => [
                        'transaksi' => [
                            'id_transaksi' => $transaksi->id_transaksi,
                            'tanggal_transaksi' => $transaksi->tanggal_transaksi,
                            'jumlah_dibayar' => $transaksi->jumlah_dibayar,
                            'metode_pembayaran' => $transaksi->metode_pembayaran,
                            'status' => $transaksi->statusTransaksi->status,
                            'tanggal_jatuh_tempo' => $transaksi->tanggal_jatuh_tempo,
                            'items' => $allocated_tubes,
                        ],
                        'tagihan' => [
                            'id_tagihan' => $tagihan->id_tagihan,
                            'jumlah_dibayar' => $tagihan->jumlah_dibayar,
                            'sisa' => $tagihan->sisa,
                            'status' => $tagihan->status,
                            'periode_ke' => $tagihan->periode_ke,
                            'hari_keterlambatan' => $tagihan->hari_keterlambatan,
                        ]
                    ]
                ], 201);
            });
        } catch (\Exception $e) {
            Log::error('Gagal memproses transaksi', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
            ]);

            // Jika transaksi sudah dibuat, tandai sebagai failed
            if (isset($transaksi)) {
                $transaksi->update([
                    'id_status_transaksi' => self::STATUS_TRANSAKSI_FAILED,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal memproses transaksi: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get riwayat transaksi pelanggan.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRiwayatTransaksi()
    {
        $user = Auth::user();
        $transaksis = Transaksi::with(['detailTransaksis.tabung.jenisTabung', 'statusTransaksi', 'tagihan'])
            ->where('id_akun', $user->id_akun)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $transaksis->map(function ($transaksi) {
                return [
                    'id_transaksi' => $transaksi->id_transaksi,
                    'tanggal_transaksi' => $transaksi->tanggal_transaksi,
                    'jumlah_dibayar' => $transaksi->jumlah_dibayar,
                    'metode_pembayaran' => $transaksi->metode_pembayaran,
                    'status' => $transaksi->statusTransaksi->status,
                    'tanggal_jatuh_tempo' => $transaksi->tanggal_jatuh_tempo,
                    'items' => $transaksi->detailTransaksis->map(function ($detail) {
                        return [
                            'id_tabung' => $detail->tabung->id_tabung,
                            'kode_tabung' => $detail->tabung->kode_tabung,
                            'nama_jenis' => $detail->tabung->jenisTabung->nama_jenis,
                            'harga' => $detail->harga,
                            'total_transaksi' => $detail->total_transaksi,
                            'jenis_transaksi' => $detail->jenisTransaksi->nama_jenis_transaksi,
                        ];
                    }),
                    'tagihan' => [
                        'id_tagihan' => $transaksi->tagihan->id_tagihan,
                        'jumlah_dibayar' => $transaksi->tagihan->jumlah_dibayar,
                        'sisa' => $transaksi->tagihan->sisa,
                        'status' => $transaksi->tagihan->status,
                        'periode_ke' => $transaksi->tagihan->periode_ke,
                        'hari_keterlambatan' => $transaksi->tagihan->hari_keterlambatan,
                    ]
                ];
            })
        ], 200);
    }

    /**
     * Get available jenis tabung for selection.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableJenisTabung()
    {
        $jenis_tabungs = JenisTabung::withCount(['tabungs' => function ($query) {
            $query->where('id_status_tabung', 1); // Hanya hitung tabung yang tersedia
        }])
        ->having('tabungs_count', '>', 0)
        ->get();

        return response()->json([
            'success' => true,
            'data' => $jenis_tabungs->map(function ($jenis) {
                return [
                    'id_jenis_tabung' => $jenis->id_jenis_tabung,
                    'nama_jenis' => $jenis->nama_jenis,
                    'harga' => $jenis->harga,
                    'jumlah_tersedia' => $jenis->tabungs_count,
                ];
            })
        ], 200);
    }

    /**
     * Get detail of a specific transaction.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTransaksiDetail($id)
    {
        $user = Auth::user();
        $transaksi = Transaksi::with(['detailTransaksis.tabung.jenisTabung', 'statusTransaksi', 'tagihan'])
            ->where('id_akun', $user->id_akun)
            ->where('id_transaksi', $id)
            ->first();

        if (!$transaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan atau tidak diizinkan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id_transaksi' => $transaksi->id_transaksi,
                'tanggal_transaksi' => $transaksi->tanggal_transaksi,
                'jumlah_dibayar' => $transaksi->jumlah_dibayar,
                'metode_pembayaran' => $transaksi->metode_pembayaran,
                'status' => $transaksi->statusTransaksi->status,
                'tanggal_jatuh_tempo' => $transaksi->tanggal_jatuh_tempo,
                'items' => $transaksi->detailTransaksis->map(function ($detail) {
                    return [
                        'id_tabung' => $detail->tabung->id_tabung,
                        'kode_tabung' => $detail->tabung->kode_tabung,
                        'nama_jenis' => $detail->tabung->jenisTabung->nama_jenis,
                        'harga' => $detail->harga,
                        'total_transaksi' => $detail->total_transaksi,
                        'jenis_transaksi' => $detail->jenisTransaksi->nama_jenis_transaksi,
                    ];
                }),
                'tagihan' => [
                    'id_tagihan' => $transaksi->tagihan->id_tagihan,
                    'jumlah_dibayar' => $transaksi->tagihan->jumlah_dibayar,
                    'sisa' => $transaksi->tagihan->sisa,
                    'status' => $transaksi->tagihan->status,
                    'periode_ke' => $transaksi->tagihan->periode_ke,
                    'hari_keterlambatan' => $transaksi->tagihan->hari_keterlambatan,
                ]
            ]
        ], 200);
    }
}
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BayarTagihanRequest;
use App\Http\Requests\StoreApiTransaksiRequest;
use App\Http\Requests\UpdateApiTransaksiRequest;
use App\Http\Resources\ApiTabungResource;
use App\Http\Resources\ApiTransaksiResource;
use App\Models\DetailTransaksi;
use App\Models\Peminjaman;
use App\Models\Perorangan;
use App\Models\StatusTabung;
use App\Models\StatusTransaksi;
use App\Models\Tabung;
use App\Models\Tagihan;
use App\Models\Transaksi;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Controller untuk mengelola transaksi (peminjaman/isi ulang tabung).
 */
class ApiTransaksiController extends Controller
{
    /**
     * Helper function untuk memuat semua relasi yang dibutuhkan oleh ApiTransaksiResource.
     * Ini untuk menghindari duplikasi kode dan memastikan semua data terkirim.
     */
    private function loadTransaksiRelations(Transaksi $transaksi): Transaksi
    {
        // --- PERBAIKAN: Menambahkan relasi 'perusahaan' ---
        // Ini memastikan data perusahaan akan selalu termuat, baik dari
        // relasi langsung (pelanggan) maupun dari relasi tidak langsung (akun).
        return $transaksi->load([
            'perorangan.perusahaan', // Memuat perusahaan dari perorangan walk-in
            'akun.perorangan.perusahaan', // Memuat perusahaan dari perorangan yang punya akun
            'statusTransaksi',
            'detailTransaksis.tabung.jenisTabung',
            'tagihans',
            'latestTagihan'
        ]);
    }
    /**
     * Tampilkan daftar transaksi (untuk admin).
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Memuat semua relasi yang dibutuhkan untuk setiap transaksi dalam daftar
            $transaksis = Transaksi::with([
                'perorangan.perusahaan',
                'akun.perorangan.perusahaan',
                'statusTransaksi',
                'detailTransaksis.tabung.jenisTabung',
                'tagihans',
                'latestTagihan'
            ])->latest()->get();

            return response()->json([
                'success' => true,
                'message' => 'Daftar transaksi berhasil diambil',
                'data' => ApiTransaksiResource::collection($transaksis),
            ], 200);
        } catch (Exception $e) {
            Log::error('Gagal mengambil transaksi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil transaksi: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Simpan transaksi baru beserta detail, peminjaman, dan tagihan.
     *
     * @param StoreApiTransaksiRequest $request
     * @return JsonResponse
     */
    public function store(StoreApiTransaksiRequest $request): JsonResponse
    {
        // Data sudah divalidasi oleh StoreApiTransaksiRequest
        $validatedData = $request->validated();

        return DB::transaction(function () use ($validatedData) {

            // --- PERBAIKAN UTAMA DI SINI ---

            // 1. Ambil ID perorangan dari data yang sudah divalidasi.
            $idPerorangan = $validatedData['id_perorangan'];

            // 2. Cari model Perorangan untuk mendapatkan id_perusahaan.
            $perorangan = Perorangan::find($idPerorangan);

            // Jika karena suatu alasan perorangan tidak ditemukan, lemparkan error.
            if (!$perorangan) {
                throw new Exception("Data pelanggan dengan ID {$idPerorangan} tidak ditemukan.");
            }

            // 3. Ambil data yang dibutuhkan dari model dan request.
            $idAkun = $validatedData['id_akun'] ?? null;
            $idPerusahaan = $perorangan->id_perusahaan;

            $detailTransaksis = $validatedData['detail_transaksis'];
            $totalTransaksi = 0;
            foreach ($detailTransaksis as $detail) {
                $totalTransaksi += $detail['harga'];
            }

            // Buat transaksi utama
            $transaksi = Transaksi::create([
                'id_akun' => $idAkun,
                'id_perorangan' => $idPerorangan,
                'id_perusahaan' => $idPerusahaan, // <-- Nilai ini sekarang otomatis dan benar
                'tanggal_transaksi' => now()->toDateString(),
                'waktu_transaksi' => now()->toTimeString(),
                'total_transaksi' => $totalTransaksi,
                'jumlah_dibayar' => $validatedData['jumlah_dibayar'],
                'metode_pembayaran' => $validatedData['metode_pembayaran'],
                'id_status_transaksi' => StatusTransaksi::PENDING,
                'tanggal_jatuh_tempo' => in_array('1', array_column($detailTransaksis, 'id_jenis_transaksi')) ? now()->addDays(30) : null,
            ]);

            // Simpan detail transaksi dan peminjaman
            foreach ($detailTransaksis as $detail) {
                $detailTransaksi = DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_tabung' => $detail['id_tabung'],
                    'id_jenis_transaksi' => $detail['id_jenis_transaksi'],
                    'harga' => $detail['harga'],
                    'batas_waktu_peminjaman' => $detail['id_jenis_transaksi'] == 1 ? now()->addDays(30)->toDateString() : null,
                ]);
                if ($detail['id_jenis_transaksi'] == 1) {
                    Tabung::where('id_tabung', $detail['id_tabung'])->update(['id_status_tabung' => StatusTabung::DIPINJAM]);

                    // Buat juga catatan peminjaman
                    Peminjaman::create([
                        'id_detail_transaksi' => $detailTransaksi->id_detail_transaksi,
                        'tanggal_pinjam' => now()->toDateString(),
                        'status_pinjam' => 'aktif',
                    ]);
                }
            }


            // Buat catatan tagihan pertama
            $sisa = $totalTransaksi - $validatedData['jumlah_dibayar'];
            Tagihan::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'jumlah_dibayar' => $validatedData['jumlah_dibayar'],
                'sisa' => $sisa > 0 ? $sisa : 0,
                'status' => ($sisa <= 0) ? 'lunas' : 'belum_lunas',
                'tanggal_bayar_tagihan' => now(),
                'keterangan' => 'Tagihan awal dibuat saat transaksi.',
            ]);

            if ($sisa <= 0) {
                $transaksi->id_status_transaksi = StatusTransaksi::SUCCESS;
                $transaksi->save();
            }

            // Muat semua relasi yang dibutuhkan untuk respons
            // $transaksi->load(['perorangan', 'akun.perorangan', 'statusTransaksi', 'detailTransaksis.tabung.jenisTabung', 'tagihans', 'latestTagihan']);
            $this->loadTransaksiRelations($transaksi);
            return response()->json(['success' => true, 'message' => 'Transaksi berhasil dibuat', 'data' => new ApiTransaksiResource($transaksi)], 201);
        });
    }

    // /**
    //  * Simpan transaksi baru beserta detail, peminjaman, dan tagihan.
    //  *
    //  * @param StoreApiTransaksiRequest $request
    //  * @return JsonResponse
    //  */
    // public function store(StoreApiTransaksiRequest $request): JsonResponse
    // {
    //     try {
    //         return DB::transaction(function () use ($request) {
    //             // Handle pelanggan
    //             $idAkun = $request['id_akun'];
    //             $idPerorangan = $request['id_perorangan'] ?? null;
    //             $idPerusahaan = $request['id_perusahaan'] ?? null;
    //             $detailTransaksis = $request['detail_transaksis'];
    //             $totalTransaksi = 0;

    //             $detailTransaksis = $request['detail_transaksis'];
    //             $idTabungs = array_column($detailTransaksis, 'id_tabung');

    //             $tabungs = Tabung::with('jenisTabung', 'statusTabung')->whereIn('id_tabung', $idTabungs)->get()->keyBy('id_tabung');

    //             // Validasi dan hitung total transaksi
    //             $totalTransaksi = 0;
    //             foreach ($detailTransaksis as $detail) {
    //                 $tabung = $tabungs[$detail['id_tabung']] ?? null;

    //                 if (!$tabung) {
    //                     throw new Exception("Tabung dengan ID {$detail['id_tabung']} tidak ditemukan.");
    //                 }
    //                 if ($tabung->statusTabung->status_tabung !== 'tersedia') {
    //                     throw new Exception("Tabung {$tabung->kode_tabung} tidak tersedia");
    //                 }
    //                 if ($detail['harga'] != $tabung->jenisTabung->harga) {
    //                     throw new Exception("Harga tabung {$tabung->kode_tabung} tidak valid");
    //                 }
    //                 $totalTransaksi += $detail['harga'];
    //             }

    //             // Buat transaksi
    //             $transaksi = Transaksi::create([
    //                 'id_akun' => $idAkun,
    //                 'id_perorangan' => $idPerorangan,
    //                 'id_perusahaan' => $idPerusahaan,
    //                 'tanggal_transaksi' => now()->toDateString(),
    //                 'waktu_transaksi' => now()->toTimeString(),
    //                 'total_transaksi' => $totalTransaksi,
    //                 'jumlah_dibayar' => $request['jumlah_dibayar'],
    //                 'metode_pembayaran' => $request['metode_pembayaran'],
    //                 'id_status_transaksi' => StatusTransaksi::PENDING, // Pending
    //                 'tanggal_jatuh_tempo' => in_array(1, array_column($request['detail_transaksis'], 'id_jenis_transaksi'))
    //                     ? now()->addDays(30)->toDateString()
    //                     : null,
    //             ]);

    //             // Simpan detail transaksi dan peminjaman
    //             foreach ($detailTransaksis as $detail) {
    //                 $tabung = $tabungs[$detail['id_tabung']];
    //                 $detailTransaksi = DetailTransaksi::create([
    //                     'id_transaksi' => $transaksi->id_transaksi,
    //                     'id_tabung' => $detail['id_tabung'],
    //                     'id_jenis_transaksi' => $detail['id_jenis_transaksi'],
    //                     'harga' => $detail['harga'],
    //                     'batas_waktu_peminjaman' => $detail['id_jenis_transaksi'] == 1
    //                         ? now()->addDays(30)->toDateString()
    //                         : null,
    //                 ]);

    //                 if ($detail['id_jenis_transaksi'] == 1) { // Peminjaman
    //                     Peminjaman::create([
    //                         'id_detail_transaksi' => $detailTransaksi->id_detail_transaksi,
    //                         'tanggal_pinjam' => now()->toDateString(),
    //                         'status_pinjam' => 'aktif',
    //                     ]);
    //                 }
    //             }

    //             Tabung::whereIn('id_tabung', $idTabungs)->update(['id_status_tabung' => StatusTabung::DIPINJAM]); // ID 2 = Dipinjam

    //             // Buat tagihan
    //             $sisa = $totalTransaksi - $request['jumlah_dibayar'];
    //             Tagihan::create([
    //                 'id_transaksi' => $transaksi->id_transaksi,
    //                 'jumlah_dibayar' => $request['jumlah_dibayar'],
    //                 'sisa' => $sisa,
    //                 'status' => $sisa <= 0 ? 'lunas' : 'belum_lunas',
    //                 'tanggal_bayar_tagihan' => $sisa <= 0 ? now()->toDateString() : null,
    //                 'hari_keterlambatan' => 0,
    //                 'periode_ke' => 1,
    //                 'keterangan' => $request->keterangan ?? null,
    //             ]);

    //             return response()->json([
    //                 'success' => true,
    //                 'message' => 'Transaksi berhasil dibuat',
    //                 'data' => new ApiTransaksiResource($transaksi->load('detailTransaksis', 'tagihans')),
    //             ], 201);
    //         });
    //     } catch (Exception $e) {
    //         Log::error('Gagal membuat transaksi: ' . $e->getMessage());
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal membuat transaksi: ' . $e->getMessage(),
    //             'data' => null,
    //         ], 500);
    //     }
    // }

    /**
     * Tampilkan detail transaksi.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $transaksi = Transaksi::findOrFail($id);
            $this->loadTransaksiRelations($transaksi);

            return response()->json([
                'success' => true,
                'message' => 'Detail transaksi berhasil diambil',
                'data' => new ApiTransaksiResource($transaksi),
            ], 200);
        } catch (Exception $e) {
            Log::error('Gagal mengambil transaksi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan',
                'data' => null,
            ], 404);
        }
    }

    /**
     * Update transaksi (hanya untuk admin).
     *
     * @param UpdateApiTransaksiRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateApiTransaksiRequest $request, $id): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request, $id) {
                $transaksi = Transaksi::findOrFail($id);

                $transaksi->update([
                    'id_akun' => $request->id_akun ?? $transaksi->id_akun,
                    'id_perorangan' => $request->id_perorangan ?? $transaksi->id_perorangan,
                    'id_perusahaan' => $request->id_perusahaan ?? $transaksi->id_perusahaan,
                    'tanggal_transaksi' => $request->tanggal_transaksi ?? $transaksi->tanggal_transaksi,
                    'waktu_transaksi' => $request->waktu_transaksi ?? $transaksi->waktu_transaksi,
                    'total_transaksi' => $request->total_transaksi ?? $transaksi->total_transaksi,
                    'jumlah_dibayar' => $request->jumlah_dibayar ?? $transaksi->jumlah_dibayar,
                    'metode_pembayaran' => $request->metode_pembayaran ?? $transaksi->metode_pembayaran,
                    'id_status_transaksi' => $request->id_status_transaksi ?? $transaksi->id_status_transaksi,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi berhasil diperbarui',
                    'data' => new ApiTransaksiResource($transaksi->load('detailTransaksis', 'tagihans')),
                ], 200);
            });
        } catch (Exception $e) {
            Log::error('Gagal memperbarui transaksi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui transaksi: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Ambil daftar tabung berdasarkan status (default: tersedia).
     *
     * @return JsonResponse
     */
    public function getTabung(): JsonResponse
    {
        try {
            $status = request()->query('status', 'tersedia');
            $tabungs = Tabung::whereHas('statusTabung', fn($query) => $query->where('status_tabung', $status))
                ->with('jenisTabung', 'statusTabung')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Daftar tabung berhasil diambil',
                'data' => ApiTabungResource::collection($tabungs),
            ], 200);
        } catch (Exception $e) {
            Log::error('Gagal mengambil tabung: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil tabung: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Ambil riwayat transaksi pelanggan.
     *
     * @return JsonResponse
     */
    public function getRiwayatTransaksi(): JsonResponse
    {
        try {
            $user = auth()->user();
            $transaksis = Transaksi::with(['detailTransaksis.tabung.jenisTabung', 'statusTransaksi', 'tagihans'])
                ->where('id_akun', $user->id_akun)
                ->latest()
                ->get(); // Tambahkan get() untuk mengeksekusi query

            return response()->json([
                'success' => true,
                'message' => 'Riwayat transaksi berhasil diambil',
                'data' => ApiTransaksiResource::collection($transaksis),
            ], 200);
        } catch (Exception $e) {
            Log::error('Gagal mengambil riwayat transaksi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil riwayat transaksi: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Menerima pembayaran, membuat catatan pembayaran baru,
     * dan mengupdate status transaksi utama.
     *
     * @param BayarTagihanRequest $request
     * @param int $id ID dari transaksi yang akan dibayar
     * @return JsonResponse
     */
    public function bayarTagihan(BayarTagihanRequest $request, $id): JsonResponse
    {
        // Menggunakan DB::transaction untuk memastikan semua operasi berhasil atau semua gagal.
        return DB::transaction(function () use ($request, $id) {
            try {
                // 1. Temukan transaksi dan ambil tagihan TERAKHIR-nya.
                $transaksi = Transaksi::with('latestTagihan')->findOrFail($id);
                $tagihanTerakhir = $transaksi->latestTagihan;

                // Validasi: Jika tagihan terakhir sudah lunas, hentikan proses.
                if ($tagihanTerakhir && $tagihanTerakhir->status === 'lunas') {
                    return response()->json(['success' => false, 'message' => 'Tagihan ini sudah lunas.'], 422);
                }

                $pembayaranSaatIni = (float) $request['jumlah_dibayar'];

                // 2. Hitung total akumulasi pembayaran dan sisa saldo yang baru.
                $totalSudahDibayar = $transaksi->jumlah_dibayar + $pembayaranSaatIni;
                $sisaBaru = $transaksi->total_transaksi - $totalSudahDibayar;

                // 3. BUAT record tagihan BARU untuk mencatat pembayaran ini.
                $tagihanBaru = Tagihan::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'jumlah_dibayar' => $pembayaranSaatIni,
                    'sisa' => $sisaBaru > 0 ? $sisaBaru : 0,
                    'status' => ($sisaBaru <= 0) ? 'lunas' : 'belum_lunas',
                    'tanggal_bayar_tagihan' => now(),
                    'keterangan' => 'Pembayaran cicilan dicatat',
                ]);

                // 4. UPDATE total pembayaran dan status di transaksi utama.
                $transaksi->jumlah_dibayar = $totalSudahDibayar;
                if ($tagihanBaru->status === 'lunas') {
                    $transaksi->id_status_transaksi = StatusTransaksi::SUCCESS;
                }
                $transaksi->save();

                // 5. Muat ulang semua relasi yang dibutuhkan oleh ApiTransaksiResource.
                // $transaksi = $transaksi->fresh()->load([
                //     'perorangan',
                //     'akun.perorangan',
                //     'statusTransaksi',
                //     'detailTransaksis.tabung.jenisTabung',
                //     'tagihans',
                //     'latestTagihan'
                // ]);
                $this->loadTransaksiRelations($transaksi);

                return response()->json([
                    'success' => true,
                    'message' => 'Pembayaran berhasil dicatat.',
                    'data' => new ApiTransaksiResource($transaksi),
                ], 200);
            } catch (Exception $e) {
                // Mencatat error yang mungkin terjadi untuk keperluan maintenance.
                Log::error('Gagal memproses pembayaran untuk transaksi ID ' . $id . ': ' . $e->getMessage());

                // Mengembalikan respons error yang umum ke pengguna.
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan pada server.'], 500);
            }
        });
    }
}

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
     * Tampilkan daftar transaksi (untuk admin).
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $transaksis = Transaksi::with(['detailTransaksis.tabung.jenisTabung', 'tagihan', 'statusTransaksi', 'akun.perorangan',])
                ->latest()
                ->get(); // Tambahkan get() untuk mengeksekusi query

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
        try {
            return DB::transaction(function () use ($request) {
                // Handle pelanggan
                $idAkun = $request['id_akun'];
                $idPerorangan = $request['id_perorangan'] ?? null;
                $idPerusahaan = $request['id_perusahaan'] ?? null;

                // if ($request['tipe_pelanggan'] === 'perorangan_tanpa_akun') {
                //     // $pelanggan = $request['pelanggan'];
                //     // $perorangan = Perorangan::create([
                //     //     'nama_lengkap' => $pelanggan['nama_lengkap'],
                //     //     'nik' => $pelanggan['nik'],
                //     //     'no_telepon' => $pelanggan['no_telepon'],
                //     //     'alamat' => $pelanggan['alamat'],
                //     //     'id_perusahaan' => null,
                //     // ]);
                //     // $idPerorangan = $perorangan->id_perorangan;
                // } elseif ($request['tipe_pelanggan'] === 'perorangan_dengan_akun') {
                //     $idPerorangan = $request['id_perorangan'];
                // } elseif ($request['tipe_pelanggan'] === 'perusahaan_dengan_akun') { // Perbaiki kondisi
                //     $idPerorangan = $request['id_perorangan'];
                //     $idPerusahaan = $request['id_perusahaan'];
                // }

                $detailTransaksis = $request['detail_transaksis'];
                $idTabungs = array_column($detailTransaksis, 'id_tabung');

                $tabungs = Tabung::with('jenisTabung', 'statusTabung')->whereIn('id_tabung', $idTabungs)->get()->keyBy('id_tabung');

                // Validasi dan hitung total transaksi
                $totalTransaksi = 0;
                foreach ($detailTransaksis as $detail) {
                    $tabung = $tabungs[$detail['id_tabung']] ?? null;

                    if (!$tabung) {
                        throw new Exception("Tabung dengan ID {$detail['id_tabung']} tidak ditemukan.");
                    }
                    if ($tabung->statusTabung->status_tabung !== 'tersedia') {
                        throw new Exception("Tabung {$tabung->kode_tabung} tidak tersedia");
                    }
                    if ($detail['harga'] != $tabung->jenisTabung->harga) {
                        throw new Exception("Harga tabung {$tabung->kode_tabung} tidak valid");
                    }
                    $totalTransaksi += $detail['harga'];
                }

                // Buat transaksi
                $transaksi = Transaksi::create([
                    'id_akun' => $idAkun,
                    'id_perorangan' => $idPerorangan,
                    'id_perusahaan' => $idPerusahaan,
                    'tanggal_transaksi' => now()->toDateString(),
                    'waktu_transaksi' => now()->toTimeString(),
                    'total_transaksi' => $totalTransaksi,
                    'jumlah_dibayar' => $request['jumlah_dibayar'],
                    'metode_pembayaran' => $request['metode_pembayaran'],
                    'id_status_transaksi' => StatusTransaksi::PENDING, // Pending
                    'tanggal_jatuh_tempo' => in_array(1, array_column($request['detail_transaksis'], 'id_jenis_transaksi'))
                        ? now()->addDays(30)->toDateString()
                        : null,
                ]);

                // Simpan detail transaksi dan peminjaman
                foreach ($detailTransaksis as $detail) {
                    $tabung = $tabungs[$detail['id_tabung']];
                    $detailTransaksi = DetailTransaksi::create([
                        'id_transaksi' => $transaksi->id_transaksi,
                        'id_tabung' => $detail['id_tabung'],
                        'id_jenis_transaksi' => $detail['id_jenis_transaksi'],
                        'harga' => $detail['harga'],
                        'batas_waktu_peminjaman' => $detail['id_jenis_transaksi'] == 1
                            ? now()->addDays(30)->toDateString()
                            : null,
                    ]);

                    if ($detail['id_jenis_transaksi'] == 1) { // Peminjaman
                        Peminjaman::create([
                            'id_detail_transaksi' => $detailTransaksi->id_detail_transaksi,
                            'tanggal_pinjam' => now()->toDateString(),
                            'status_pinjam' => 'aktif',
                        ]);
                    }
                }

                Tabung::whereIn('id_tabung', $idTabungs)->update(['id_status_tabung' => StatusTabung::DIPINJAM]); // ID 2 = Dipinjam

                // Buat tagihan
                $sisa = $totalTransaksi - $request['jumlah_dibayar'];
                Tagihan::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'jumlah_dibayar' => $request['jumlah_dibayar'],
                    'sisa' => $sisa,
                    'status' => $sisa <= 0 ? 'lunas' : 'belum_lunas',
                    'tanggal_bayar_tagihan' => $sisa <= 0 ? now()->toDateString() : null,
                    'hari_keterlambatan' => 0,
                    'periode_ke' => 1,
                    'keterangan' => $request->keterangan ?? null,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Transaksi berhasil dibuat',
                    'data' => new ApiTransaksiResource($transaksi->load('detailTransaksis', 'tagihan')),
                ], 201);
            });
        } catch (Exception $e) {
            Log::error('Gagal membuat transaksi: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi: ' . $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Tampilkan detail transaksi.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $transaksi = Transaksi::with(['detailTransaksis.tabung.jenisTabung', 'tagihan', 'statusTransaksi'])
                ->findOrFail($id);

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
                    'data' => new ApiTransaksiResource($transaksi->load('detailTransaksis', 'tagihan')),
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
            $transaksis = Transaksi::with(['detailTransaksis.tabung.jenisTabung', 'statusTransaksi', 'tagihan'])
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
     * Menerima dan mencatat pembayaran cicilan untuk sebuah transaksi.
     *
     * @param BayarTagihanRequest $request
     * @param int $id ID dari transaksi yang akan dibayar
     * @return JsonResponse
     */
    public function bayarTagihan(BayarTagihanRequest $request, $id): JsonResponse
    {
        // Memulai DB Transaction untuk memastikan integritas data.
        // Jika ada kegagalan, semua perubahan akan dibatalkan.
        return DB::transaction(function () use ($request, $id) {
            try {
                // 1. Temukan transaksi beserta relasi tagihannya.
                // findOrFail akan otomatis melempar error 404 jika transaksi tidak ditemukan.
                $transaksi = Transaksi::with('tagihan')->findOrFail($id);
                $tagihan = $transaksi->tagihan;

                // Validasi tambahan: jangan proses jika tagihan sudah lunas.
                if ($tagihan->status === 'lunas') {
                    // Beri respons error yang jelas ke frontend.
                    return response()->json([
                        'success' => false,
                        'message' => 'Tagihan ini sudah lunas.',
                    ], 422); // 422 Unprocessable Entity
                }

                // Ambil jumlah pembayaran dari request yang sudah divalidasi.
                $pembayaranBaru = (float) $request['jumlah_dibayar'];

                // 2. Tambah (akumulasi) jumlah_dibayar di tabel transaksis.
                $totalSudahDibayar = $transaksi->jumlah_dibayar + $pembayaranBaru;

                // Hitung sisa tagihan yang baru.
                $sisaBaru = $transaksi->total_transaksi - $totalSudahDibayar;

                // 4. Logika untuk mengubah status jika lunas.
                if ($sisaBaru <= 0) {
                    // Jika LUNAS
                    $transaksi->jumlah_dibayar = $transaksi->total_transaksi; // Set agar pas, tidak minus
                    $transaksi->id_status_transaksi = StatusTransaksi::SUCCESS;

                    // 3. Update sisa dan status di tabel tagihans.
                    $tagihan->sisa = 0;
                    $tagihan->status = 'lunas';
                    $tagihan->tanggal_bayar_tagihan = now(); // Catat tanggal pelunasan
                    $tagihan->jumlah_dibayar = $transaksi->total_transaksi;
                } else {
                    // Jika BELUM LUNAS (masih mencicil)
                    $transaksi->jumlah_dibayar = $totalSudahDibayar;
                    // id_status_transaksi tetap PENDING

                    // 3. Update sisa di tabel tagihans.
                    $tagihan->sisa = $sisaBaru;
                    $tagihan->jumlah_dibayar = $totalSudahDibayar;
                }

                // Simpan perubahan ke database.
                $transaksi->save();
                $tagihan->save();

                // Berikan respons sukses ke frontend.
                // Muat ulang relasi untuk memastikan data yang dikirim adalah data terbaru.
                return response()->json([
                    'success' => true,
                    'message' => 'Pembayaran berhasil dicatat.',
                    'data' => new ApiTransaksiResource($transaksi->fresh()->load('tagihan', 'statusTransaksi')),
                ], 200);
            } catch (Exception $e) {
                // Tangani error tak terduga lainnya.
                Log::error('Gagal memproses pembayaran: ' . $e->getMessage());
                // Kembalikan error 500. DB::transaction akan otomatis rollback.
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan pada server saat memproses pembayaran.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        });
    }
}

<?php

namespace App\Http\Controllers\API\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Resources\ApiTransaksiResource;
use App\Models\DetailTransaksi;
use App\Models\StatusTabung;
use App\Models\StatusTransaksi;
use App\Models\Tabung;
use App\Models\Transaksi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiPengajuanAdministratorController extends Controller
{
    //
    /**
     * Menampilkan daftar semua transaksi yang berstatus 'pengajuan'.
     */
    public function index()
    {
        // 1. Cari ID untuk status 'pengajuan'
        $statusPengajuanId = StatusTransaksi::where('status', 'pengajuan')->value('id_status_transaksi');

        if (!$statusPengajuanId) {
            return response()->json(['success' => false, 'message' => 'Status "pengajuan" tidak ditemukan.'], 404);
        }

        // 2. Ambil semua transaksi dengan status tersebut
        $pengajuanMasuk = Transaksi::where('id_status_transaksi', $statusPengajuanId)
            // 3. Muat relasi yang dibutuhkan untuk menampilkan info pelanggan
            ->with([
                'akun.perorangan',
                'perorangan',
                'detailTransaksis' // Untuk menghitung jumlah item
            ])
            ->latest() // Urutkan dari yang terbaru
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar pengajuan berhasil diambil.',
            'data' => ApiTransaksiResource::collection($pengajuanMasuk)
        ]);
    }

    /**
     * Menampilkan detail satu pengajuan spesifik.
     */
    public function show(Transaksi $transaksi)
    {
        // Pastikan transaksi yang diakses statusnya benar
        if ($transaksi->statusTransaksi->status !== 'pengajuan') {
            return response()->json(['success' => false, 'message' => 'Transaksi ini sudah diproses.'], 404);
        }

        // Muat semua relasi yang dibutuhkan oleh frontend
        $transaksi->load([
            'akun.perorangan.perusahaan',
            'perorangan.perusahaan',
            'detailTransaksis.jenisTransaksi',
            'detailTransaksis.tabung.jenisTabung'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Detail pengajuan berhasil diambil.',
            'data' => new ApiTransaksiResource($transaksi)
        ]);
    }

    /**
     * Memproses pengajuan, mengalokasikan tabung, dan mengubah status.
     */
    public function proses(Request $request, Transaksi $transaksi)
    {
        // Validasi input: kita mengharapkan array 'alokasi'
        $validated = $request->validate([
            'alokasi' => 'required|array',
            'alokasi.*.id_detail_transaksi' => 'required|integer|exists:detail_transaksis,id_detail_transaksi',
            'alokasi.*.id_tabung' => 'required|integer|exists:tabungs,id_tabung',
        ]);

        try {
            DB::transaction(function () use ($validated, $transaksi) {
                // Cari ID untuk status 'pending' dan 'dipinjam'
                $statusPendingId = StatusTransaksi::where('status', 'pending')->value('id_status_transaksi');
                $statusDipinjamId = StatusTabung::where('status_tabung', 'dipinjam')->value('id_status_tabung');

                if (!$statusPendingId || !$statusDipinjamId) {
                    throw new Exception("Status 'pending' atau 'dipinjam' tidak ditemukan di database.");
                }

                // 1. Loop melalui setiap alokasi dan update detail transaksi
                foreach ($validated['alokasi'] as $item) {
                    $detail = DetailTransaksi::find($item['id_detail_transaksi']);
                    // Pastikan detail ini milik transaksi yang benar
                    if ($detail && $detail->id_transaksi === $transaksi->id_transaksi) {
                        // Alokasikan id_tabung
                        $detail->id_tabung = $item['id_tabung'];
                        $detail->save();

                        // Update status tabung yang dialokasikan menjadi 'dipinjam'
                        Tabung::where('id_tabung', $item['id_tabung'])->update(['id_status_tabung' => $statusDipinjamId]);
                    }
                }

                // 2. Buat tagihan pertama untuk transaksi ini
                $transaksi->tagihans()->create([
                    'jumlah_dibayar' => 0,
                    'sisa' => $transaksi->total_transaksi,
                    'status' => 'belum_lunas',
                ]);

                // 3. Update status transaksi utama menjadi 'pending'
                $transaksi->id_status_transaksi = $statusPendingId;
                $transaksi->save();

                // TODO: Kirim notifikasi ke pelanggan bahwa pengajuan disetujui
            });

            return response()->json([
                'success' => true,
                'message' => 'Pengajuan berhasil diproses dan transaksi telah dibuat.',
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}

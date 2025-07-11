<?php

namespace App\Http\Controllers\Api;

use App\Events\TransactionStatusCheck; // Panggil event yang sudah kita rancang
use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\StatusTabung;
use App\Models\Tabung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ApiPengembalianController extends Controller
{
    /**
     * Menyimpan data pengembalian baru berdasarkan kode tabung.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari Flutter
        $validated = $request->validate([
            'kode_tabung' => 'required|string|exists:tabungs,kode_tabung',
            'kondisi_tabung' => 'required|string|in:baik,rusak', // 'baik' atau 'rusak'
            'keterangan' => 'nullable|string',
        ]);

        try {
            // 2. Gunakan DB Transaction untuk memastikan semua operasi berhasil atau gagal bersamaan
            $pengembalian = DB::transaction(function () use ($validated) {

                // Cari tabung berdasarkan kode uniknya
                $tabung = Tabung::where('kode_tabung', $validated['kode_tabung'])->firstOrFail();

                // Cari peminjaman yang masih aktif untuk tabung ini
                // Ini adalah query yang paling penting
                $peminjamanAktif = Peminjaman::whereHas('detailTransaksi', function ($query) use ($tabung) {
                    $query->where('id_tabung', $tabung->id_tabung);
                })->where('status_pinjam', 'aktif')->first();

                // Jika tidak ada peminjaman aktif, berarti tabung ini tidak sedang dipinjam
                if (!$peminjamanAktif) {
                    throw new Exception('Tabung dengan kode ' . $validated['kode_tabung'] . ' tidak tercatat sedang dipinjam.');
                }

                // 3. Buat record baru di tabel pengembalians
                $pengembalian = Pengembalian::create([
                    'id_peminjaman' => $peminjamanAktif->id_peminjaman,
                    'tanggal_kembali' => now(),
                    'kondisi_tabung' => $validated['kondisi_tabung'],
                    'keterangan' => $validated['keterangan'],
                ]);

                // 4. Update status peminjaman menjadi 'selesai'
                $peminjamanAktif->update(['status_pinjam' => 'selesai']);

                // 5. Update status tabung
                // Jika kondisi 'baik', status kembali 'Tersedia'. Jika 'rusak', status menjadi 'Rusak'.
                $statusTabungBaru = ($validated['kondisi_tabung'] == 'baik')
                    ? StatusTabung::TERSEDIA // Asumsi Anda punya konstanta atau ID=1
                    : StatusTabung::RUSAK;   // Asumsi Anda punya konstanta atau ID=3

                $tabung->update(['id_status_tabung' => $statusTabungBaru]);

                // 6. Panggil Event untuk cek apakah transaksi sudah selesai total
                // Ini akan memicu listener yang sudah kita rancang sebelumnya
                $transaksi = $peminjamanAktif->detailTransaksi->transaksi;
                event(new TransactionStatusCheck($transaksi));

                return $pengembalian;
            });

            return response()->json([
                'success' => true,
                'message' => 'Pengembalian tabung berhasil dicatat.',
                'data' => $pengembalian->load('peminjaman.detailTransaksi.transaksi'),
            ], 201);
        } catch (Exception $e) {
            // Tangani error dengan respons yang jelas
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422); // 422 Unprocessable Entity cocok untuk error validasi bisnis
        }
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Tagihan;
use App\Models\Peminjaman;
use App\Models\Tabung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller {
    public function index($akunId) {
        $transaksis = Transaksi::with(['detailTransaksis.tabung.jenisTabung', 'statusTransaksi', 'perorangan', 'perusahaan', 'tagihan'])
            ->where('id_akuns', $akunId)
            ->get();
        return response()->json($transaksis);
    }

    public function store(Request $request) {
        $data = $request->validate([
            'id_akuns' => 'nullable|exists:akuns,id_akuns',
            'id_perorangan' => 'nullable|exists:perorangans,id_perorangan',
            'id_perusahaan' => 'nullable|exists:perusahaans,id_perusahaan',
            'jumlah_dibayar' => 'required|numeric',
            'metode_pembayaran' => 'required|in:tunai,transfer',
            'detail_transaksis' => 'required|array',
            'detail_transaksis.*.id_tabung' => 'required|exists:tabungs,id_tabungs',
            'detail_transaksis.*.id_jenis_transaksi' => 'required|exists:jenis_transaksis,id_jenis_transaksi',
            'detail_transaksis.*.harga' => 'required|numeric',
        ]);

        return DB::transaction(function () use ($data) {
            $transaksi = Transaksi::create([
                'id_akuns' => $data['id_akuns'],
                'id_perorangan' => $data['id_perorangan'],
                'id_perusahaan' => $data['id_perusahaan'],
                'tanggal_transaksi' => now(),
                'waktu_transaksi' => now()->format('H:i:s'),
                'jumlah_dibayar' => $data['jumlah_dibayar'],
                'metode_pembayaran' => $data['metode_pembayaran'],
                'id_status_transaksi' => 2, // Pending (STS002)
                'tanggal_jatuh_tempo' => $data['detail_transaksis'][0]['id_jenis_transaksi'] == 1 ? now()->addDays(30) : null,
            ]);

            $totalTransaksi = 0;
            foreach ($data['detail_transaksis'] as $detail) {
                $totalTransaksi += $detail['harga'];
                $detailTransaksi = DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksis,
                    'id_tabung' => $detail['id_tabung'],
                    'id_jenis_transaksi' => $detail['id_jenis_transaksi'],
                    'harga' => $detail['harga'],
                    'total_transaksi' => $detail['harga'],
                    'batas_waktu_peminjaman' => $detail['id_jenis_transaksi'] == 1 ? now()->addDays(30) : null,
                ]);

                if ($detail['id_jenis_transaksi'] == 1) { // Peminjaman
                    Peminjaman::create([
                        'id_detail_transaksi' => $detailTransaksi->id_detail_transaksi,
                        'tanggal_pinjam' => now(),
                        'status_pinjam' => 'aktif',
                    ]);
                    Tabung::where('id_tabungs', $detail['id_tabung'])->update(['id_status_tabung' => 2]); // Dipinjam
                }
            }

            if ($data['detail_transaksis'][0]['id_jenis_transaksi'] == 1) {
                Tagihan::create([
                    'id_transaksi' => $transaksi->id_transaksis,
                    'jumlah_dibayar' => $data['jumlah_dibayar'],
                    'sisa' => $totalTransaksi - $data['jumlah_dibayar'],
                    'status' => $totalTransaksi - $data['jumlah_dibayar'] <= 0 ? 'lunas' : 'belum_lunas',
                    'hari_keterlambatan' => 0,
                    'periode_ke' => 0,
                    'keterangan' => 'Pembayaran awal',
                ]);
            }

            return response()->json($transaksi->load(['detailTransaksis', 'tagihan']), 201);
        });
    }
}

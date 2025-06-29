<?php

namespace App\Http\Controllers\Api;

use App\Models\DetailTransaksi;
use App\Models\Peminjaman;
use App\Models\RiwayatTransaksi;
use App\Models\Tagihan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller {
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_akun' => 'nullable|exists:akuns,id_akun',
            'id_perorangan' => 'nullable|exists:perorangans,id_perorangan',
            'id_perusahaan' => 'nullable|exists:perusahaans,id_perusahaan',
            'total_transaksi' => 'required|numeric|min:0',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|in:transfer,tunai',
            'details' => 'required|array|min:1',
            'details.*.id_tabung' => 'required|exists:tabungs,id_tabung',
            'details.*.id_jenis_transaksi' => 'required|exists:jenis_transaksis,id_jenis_transaksi',
            'details.*.harga' => 'required|numeric|min:0',
            'details.*.batas_waktu_peminjaman' => 'nullable|date'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'gagal',
                'pesan' => $validator->errors()->first(),
                'data' => null
            ], 422);
        }

        if (!$request->id_akun && !$request->id_perorangan && !$request->id_perusahaan) {
            return response()->json([
                'status' => 'gagal',
                'pesan' => 'Pilih pelanggan (akun, perorangan, atau perusahaan).',
                'data' => null
            ], 422);
        }

        DB::beginTransaction();
        try {
            $now = Carbon::now();
            $transaksi = Transaksi::create([
                'id_akun' => $request->id_akun,
                'id_perorangan' => $request->id_perorangan,
                'id_perusahaan' => $request->id_perusahaan,
                'tanggal_transaksi' => $now->toDateString(),
                'waktu_transaksi' => $now->toTimeString(),
                'total_transaksi' => $request->total_transaksi,
                'jumlah_dibayar' => $request->jumlah_dibayar,
                'metode_pembayaran' => $request->metode_pembayaran,
                'id_status_transaksi' => 1, // Success
                'tanggal_jatuh_tempo' => $request->details[0]['batas_waktu_peminjaman']
                    ? Carbon::parse($request->details[0]['batas_waktu_peminjaman'])->toDateString()
                    : null
            ]);

            foreach ($request->details as $detail) {
                $detailTransaksi = DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_tabung' => $detail['id_tabung'],
                    'id_jenis_transaksi' => $detail['id_jenis_transaksi'],
                    'harga' => $detail['harga'],
                    'batas_waktu_peminjaman' => $detail['batas_waktu_peminjaman']
                ]);

                if ($detail['id_jenis_transaksi'] == 1) { // Peminjaman
                    Peminjaman::create([
                        'id_detail_transaksi' => $detailTransaksi->id_detail_transaksi,
                        'tanggal_pinjam' => $now->toDateString(),
                        'status_pinjam' => 'aktif'
                    ]);

                    // Update tabung status to 'dipinjam'
                    $tabung = \App\Models\Tabung::find($detail['id_tabung']);
                    $tabung->id_status_tabung = \App\Models\StatusTabung::where('status_tabung', 'dipinjam')->first()->id_status_tabung;
                    $tabung->save();
                }
            }

            // Create tagihan
            $sisa = $request->total_transaksi - $request->jumlah_dibayar;
            Tagihan::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'jumlah_dibayar' => $request->jumlah_dibayar,
                'sisa' => $sisa,
                'status' => $sisa <= 0 ? 'lunas' : 'belum_lunas',
                'tanggal_bayar_tagihan' => $sisa <= 0 ? $now->toDateString() : null,
                'hari_keterlambatan' => 0,
                'periode_ke' => 1,
                'keterangan' => null
            ]);

            // Create riwayat transaksi
            RiwayatTransaksi::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'id_akun' => $request->id_akun,
                'id_perorangan' => $request->id_perorangan,
                'id_perusahaan' => $request->id_perusahaan,
                'tanggal_transaksi' => $now->toDateString(),
                'total_transaksi' => $request->total_transaksi,
                'jumlah_dibayar' => $request->jumlah_dibayar,
                'metode_pembayaran' => $request->metode_pembayaran,
                'tanggal_jatuh_tempo' => $transaksi->tanggal_jatuh_tempo,
                'tanggal_selesai' => $sisa <= 0 ? $now->toDateString() : null,
                'status_akhir' => 'success',
                'total_pembayaran' => $request->jumlah_dibayar,
                'denda' => 0,
                'durasi_peminjaman' => null,
                'keterangan' => null
            ]);

            DB::commit();

            return response()->json([
                'status' => 'sukses',
                'pesan' => 'Transaksi berhasil dibuat.',
                'data' => $transaksi->load('details')
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'gagal',
                'pesan' => 'Gagal membuat transaksi: ' . $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

}

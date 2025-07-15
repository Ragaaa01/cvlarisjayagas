<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JenisTabung;
use App\Models\StatusTransaksi;
use App\Models\Transaksi;
use App\Rules\StokCukup;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class ApiPengajuanPelangganController extends Controller
{
    /**
     * Menyimpan pengajuan baru dari pelanggan.
     * Method ini menangani alur 'tunai' dan 'transfer' (dengan DP).
     */
    public function store(Request $request)
    {
        // --- 1. VALIDASI YANG SUDAH DIPERBAIKI ---
        $validated = $request->validate([
            'tipe_pengajuan'      => 'required|string|in:peminjaman,isi_ulang',
            'metode_pembayaran'   => 'required|string|in:tunai,transfer',
            'keterangan_pelanggan' => 'nullable|string',
            'items'               => 'required|array|min:1',
            'items.*.id_jenis_tabung' => 'required|integer|exists:jenis_tabungs,id_jenis_tabung',
            // Menggabungkan semua aturan untuk 'jumlah' ke dalam satu array
            'items.*.jumlah'      => [
                'required',
                'integer',
                'min:1',
                // Validasi stok kustom
                function ($attribute, $value, $fail) use ($request) {
                    // Hanya validasi stok jika jenisnya peminjaman
                    if ($request->input('tipe_pengajuan') == 'peminjaman') {
                        $index = explode('.', $attribute)[1];
                        $id_jenis_tabung = $request->input("items.$index.id_jenis_tabung");
                        $rule = new StokCukup($id_jenis_tabung);
                        if (!$rule->passes($attribute, $value)) {
                            $fail($rule->message());
                        }
                    }
                }
            ],
        ]);

        // --- 2. LOGIKA YANG DIGABUNGKAN ---
        try {
            $result = DB::transaction(function () use ($validated, $request) {
                $user = $request->user();
                $perorangan = $user->perorangan;
                if (!$perorangan) {
                    throw new Exception("Data profil perorangan untuk akun ini tidak ditemukan.");
                }

                $totalTransaksi = 0;
                foreach ($validated['items'] as $item) {
                    $jenisTabung = JenisTabung::find($item['id_jenis_tabung']);
                    $totalTransaksi += $jenisTabung->harga * $item['jumlah'];
                }

                // --- PERCABANGAN LOGIKA BERDASARKAN METODE BAYAR ---
                if ($validated['metode_pembayaran'] == 'tunai') {
                    // ALUR PENGAJUAN TUNAI
                    $statusPengajuanId = StatusTransaksi::where('status', 'pengajuan')->value('id_status_transaksi');
                    $transaksi = $this->createTransaksi($user, $perorangan, $statusPengajuanId, $totalTransaksi, $validated);
                    $this->createDetailTransaksi($transaksi, $validated);

                    return ['tipe' => 'pengajuan', 'data' => ['id_transaksi' => $transaksi->id_transaksi]];
                } else {
                    // ALUR PEMBAYARAN DP VIA TRANSFER (GATEWAY)
                    $statusPendingId = StatusTransaksi::where('status', 'pending')->value('id_status_transaksi');
                    $transaksi = $this->createTransaksi($user, $perorangan, $statusPendingId, $totalTransaksi, $validated);
                    $transaksi->tagihans()->create(['sisa' => $totalTransaksi, 'status' => 'belum_lunas']);
                    $this->createDetailTransaksi($transaksi, $validated);

                    // Tentukan jumlah DP
                    $dpAmount = max(50000, $totalTransaksi * 0.2); // Contoh: 20% atau minimal 50rb

                    // Buat URL Pembayaran Midtrans
                    $paymentUrl = $this->createMidtransPaymentUrl($transaksi, $dpAmount, $user);

                    return ['tipe' => 'pembayaran', 'data' => ['payment_url' => $paymentUrl]];
                }
            });

            // Kirim respons sesuai tipe alur
            if ($result['tipe'] == 'pengajuan') {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengajuan Anda berhasil dikirim.',
                    'data' => $result['data']
                ], 201);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'URL pembayaran berhasil dibuat.',
                    'data' => $result['data']
                ], 201);
            }
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /** Helper untuk membuat record transaksi utama */
    private function createTransaksi($user, $perorangan, $statusId, $total, $validated)
    {
        return Transaksi::create([
            'id_akun' => $user->id_akun,
            'id_perorangan' => $perorangan->id_perorangan,
            'id_perusahaan' => $perorangan->id_perusahaan,
            'id_status_transaksi' => $statusId,
            'tanggal_transaksi' => now(),
            'waktu_transaksi' => now(),
            'total_transaksi' => $total,
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'jumlah_dibayar' => 0, // Selalu 0 di awal, akan diupdate oleh webhook/admin
            'tanggal_jatuh_tempo' => ($validated['tipe_pengajuan'] == 'peminjaman') ? now()->addDays(30) : null,
        ]);
    }

    /** Helper untuk membuat detail transaksi */
    private function createDetailTransaksi($transaksi, $validated)
    {
        foreach ($validated['items'] as $item) {
            $hargaItem = JenisTabung::find($item['id_jenis_tabung'])->harga;
            $idJenisTransaksi = ($validated['tipe_pengajuan'] == 'peminjaman') ? 1 : 2;
            for ($i = 0; $i < $item['jumlah']; $i++) {
                $transaksi->detailTransaksis()->create([
                    'id_tabung' => null,
                    'id_jenis_transaksi' => $idJenisTransaksi,
                    'harga' => $hargaItem,
                ]);
            }
        }
    }

    /** Helper untuk membuat URL pembayaran Midtrans */
    private function createMidtransPaymentUrl($transaksi, $amount, $user)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'DP-TRX-' . $transaksi->id_transaksi . '-' . time(),
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => $user->perorangan->nama_lengkap,
                'email' => $user->email,
            ],
        ];

        $midtransTransaction = Snap::createTransaction($params);
        return $midtransTransaction->redirect_url;
    }
}

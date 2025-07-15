<?php

namespace App\Http\Controllers\Api;

use App\Events\TransactionStatusCheck;
use App\Http\Controllers\Controller;
use App\Models\StatusTransaksi;
use App\Models\Tagihan;
use App\Models\Transaksi; // Pastikan model Transaksi di-import
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Notification;
use Exception;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Log paling awal untuk memastikan controller ini terpanggil
        Log::info('Webhook handle method executed.');
        Log::info('Request Body:', $request->all());


        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');

        try {
            // $notification = new Notification();
            // $notification = new Notification(file_get_contents('php://input'));
            // $notification = new Notification($request->getContent());
            $notification = new Notification();

            // Verifikasi signature key untuk keamanan
            $this->verifySignature($notification);

            $status = $notification->transaction_status;
            $orderId = $notification->order_id;
            $grossAmount = (float) $notification->gross_amount;

            Log::info("Memproses Order ID: {$orderId} dengan status: {$status}");

            // Hanya proses jika pembayaran sudah berhasil (settlement)
            if ($status == 'settlement') {
                // Temukan transaksi berdasarkan order_id
                $transaksi = $this->findTransaksi($orderId);

                if ($transaksi && $transaksi->latestTagihan && $transaksi->latestTagihan->status != 'lunas') {
                    Log::info("Transaksi #{$transaksi->id_transaksi} ditemukan. Memproses pembayaran.");
                    $this->prosesPembayaran($transaksi, $grossAmount);
                } else {
                    Log::warning("Gagal menemukan transaksi/tagihan atau sudah lunas untuk order_id: {$orderId}");
                }
            }

            return response()->json(['status' => 'ok']);
        } catch (Exception $e) {
            Log::error('Webhook Midtrans Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    private function verifySignature(Notification $notification)
    {
        $orderId = $notification->order_id;
        $statusCode = $notification->status_code;
        $grossAmount = $notification->gross_amount;
        $serverKey = config('services.midtrans.server_key');
        $signature = $notification->signature_key;

        $localSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);

        if ($signature !== $localSignature) {
            throw new Exception('Invalid signature key.');
        }
    }

    /**
     * Mencari Transaksi dari order_id yang dikirim Midtrans.
     */
    private function findTransaksi(string $orderId): ?Transaksi
    {
        // Pecah string order_id berdasarkan tanda "-"
        $parts = explode('-', $orderId);

        // Pastikan struktur format sesuai: TRX-{id_transaksi}-TAGIHAN-{id_tagihan}-{timestamp}
        if (count($parts) >= 5 && $parts[0] === 'TRX' && $parts[2] === 'TAGIHAN') {
            $transaksiId = $parts[1];
            $tagihanId = $parts[3];

            // Cari transaksi dengan relasi tagihan yang sesuai
            return Transaksi::with(['latestTagihan' => function ($q) use ($tagihanId) {
                $q->where('id_tagihan', $tagihanId);
            }])->find($transaksiId);
        }

        Log::warning("Format order_id tidak dikenali: {$orderId}");
        return null;
    }

    /**
     * Logika untuk memproses pembayaran dan mengupdate status.
     */
    private function prosesPembayaran(Transaksi $transaksi, float $amount)
    {
        DB::transaction(function () use ($transaksi, $amount) {
            // 1. Buat record tagihan baru untuk mencatat pembayaran ini
            $tagihanBaru = $transaksi->tagihans()->create([
                'jumlah_dibayar' => $amount,
                'sisa' => $transaksi->total_transaksi - ($transaksi->jumlah_dibayar + $amount),
                'status' => 'belum_lunas', // Default, akan diupdate jika lunas
                'tanggal_bayar_tagihan' => now(),
                'keterangan' => 'Pembayaran via Midtrans'
            ]);

            // 2. Update total pembayaran di transaksi utama
            $transaksi->jumlah_dibayar += $amount;

            // 3. Cek apakah pembayaran ini melunasi seluruh tagihan
            if ($tagihanBaru->sisa <= 0) {
                $tagihanBaru->sisa = 0;
                $tagihanBaru->status = 'lunas';
                $tagihanBaru->save();

                // Ubah status transaksi utama menjadi 'success'
                $statusSuccessId = StatusTransaksi::where('status', 'success')->value('id_status_transaksi');
                if ($statusSuccessId) {
                    $transaksi->id_status_transaksi = $statusSuccessId;
                }
            }

            $transaksi->save();
            Log::info("Pembayaran untuk Transaksi #{$transaksi->id_transaksi} berhasil dicatat.");

            // Panggil event untuk arsip jika transaksi sudah lunas DAN semua barang kembali
            event(new TransactionStatusCheck($transaksi));
        });
    }
}

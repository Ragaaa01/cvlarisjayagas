<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PembayaranController extends Controller
{
    public function createPayment(Request $request, Tagihan $tagihan)
    {
        // 1. Konfigurasi Midtrans dari file .env
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // 2. Siapkan detail transaksi untuk Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => 'TRX-' . $tagihan->transaksi->id_transaksi . '-TAGIHAN-' . $tagihan->id_tagihan . '-' . time(),
                'gross_amount' => $tagihan->sisa,
            ],
            'customer_details' => [
                'first_name' => $request->user()->perorangan->nama_lengkap,
                'email' => $request->user()->email,
                'phone' => $request->user()->perorangan->no_telepon,
            ],
        ];

        try {
            // 3. Minta Snap Token dari Midtrans
            $transaction = \Midtrans\Snap::createTransaction($params);
            $paymentUrl = $transaction->redirect_url; // Ambil redirect_url

            return response()->json([
                'success' => true,
                'message' => 'Token pembayaran berhasil dibuat.',
                'data' => [
                    'payment_url' => $paymentUrl
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}

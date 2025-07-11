<?php

namespace App\Listeners;

use App\Events\TransactionStatusCheck;
use App\Models\RiwayatTransaksi;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateTransactionHistory
{
    use Dispatchable, SerializesModels;

    public $transaksi;

    /**
     * Create a new event instance.
     */
    public function __construct($transaksi)
    {
        $this->transaksi = $transaksi;
    }

    /**
     * Handle the event.
     */
    public function handle(TransactionStatusCheck $event): void
    {
        $transaksi = $event->transaksi;

        // 1. Cek apakah sudah ada di riwayat untuk menghindari duplikat
        if (RiwayatTransaksi::where('id_transaksi', $transaksi->id_transaksi)->exists()) {
            return; // Jika sudah ada, hentikan proses
        }

        // 2. Cek status pembayaran
        $isLunas = !$transaksi->tagihans()->where('status', 'belum_lunas')->exists();
        if (!$isLunas) {
            return; // Jika belum lunas, hentikan proses
        }

        // 3. Cek apakah semua pinjaman sudah dikembalikan
        $totalPinjaman = $transaksi->detailTransaksis()->where('id_jenis_transaksi', 1)->count(); // Asumsi 1 = peminjaman
        if ($totalPinjaman > 0) {
            $totalPengembalian = 0;
            foreach ($transaksi->detailTransaksis as $detail) {
                if ($detail->peminjaman && $detail->peminjaman->pengembalian) {
                    $totalPengembalian++;
                }
            }

            if ($totalPinjaman !== $totalPengembalian) {
                return; // Jika jumlah pinjaman dan pengembalian tidak sama, hentikan proses
            }
        }

        // --- Jika semua syarat terpenuhi, buat Riwayat Transaksi ---
        Log::info("Membuat riwayat untuk transaksi ID: {$transaksi->id_transaksi}");

        // 4. Kalkulasi data tambahan
        $tanggalSelesai = now();
        // Anda bisa menambahkan logika kalkulasi denda atau durasi di sini jika diperlukan

        RiwayatTransaksi::create([
            'id_transaksi' => $transaksi->id_transaksi,
            'id_akun' => $transaksi->id_akun,
            'id_perorangan' => $transaksi->id_perorangan,
            'id_perusahaan' => $transaksi->id_perusahaan,
            'tanggal_transaksi' => $transaksi->tanggal_transaksi,
            'total_transaksi' => $transaksi->total_transaksi,
            'jumlah_dibayar' => $transaksi->jumlah_dibayar, // atau ambil dari total tagihan
            'metode_pembayaran' => $transaksi->metode_pembayaran,
            'tanggal_jatuh_tempo' => $transaksi->tanggal_jatuh_tempo,
            'tanggal_selesai' => $tanggalSelesai,
            'status_akhir' => 'success', // atau 'failed' jika ada logika lain
            'total_pembayaran' => $transaksi->tagihans()->sum('jumlah_dibayar'),
            'denda' => 0, // Implementasikan logika denda di sini
            'durasi_peminjaman' => null, // Implementasikan logika durasi di sini
            'keterangan' => 'Transaksi telah selesai dan diarsipkan.',
        ]);

        // Opsional: Tandai transaksi asli sebagai sudah diarsipkan
        $transaksi->is_archived = true;
        $transaksi->save();
    }
}

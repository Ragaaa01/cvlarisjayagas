<?php

namespace App\Console\Commands;

use App\Models\Notifikasi;
use App\Models\NotifikasiTemplate;
use App\Models\Tagihan;
use App\Notifications\JatuhTempoNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SendDueDateNotifications extends Command
{
    protected $signature = 'notifications:send-due-dates';
    protected $description = 'Mencari tagihan yang akan jatuh tempo dan mengirim notifikasi';

    

    public function handle()
    {
        $this->info('Memulai proses pengiriman notifikasi jatuh tempo...');
        Log::info('Cron Job: Memulai proses notifikasi.');

        $templates = NotifikasiTemplate::all();

        foreach ($templates as $template) {
            $targetDate = Carbon::now()->addDays($template->hari_set)->toDateString();

            $tagihans = Tagihan::where('status', 'belum_lunas')
                ->whereHas('transaksi', fn($q) => $q->whereDate('tanggal_jatuh_tempo', $targetDate))
                ->with('transaksi.akun')
                ->get();

            if ($tagihans->isEmpty()) {
                continue;
            }

            $this->info("Ditemukan {$tagihans->count()} tagihan untuk template '{$template->nama_template}'.");

            foreach ($tagihans as $tagihan) {
                $akun = $tagihan->transaksi->akun;

                if ($akun) {
                    try {
                        // Kirim notifikasi push via Firebase
                        $akun->notify(new JatuhTempoNotification($tagihan, $template));

                        // --- 2. PERBAIKAN UTAMA: SIMPAN KE DATABASE ---
                        // Buat record baru di tabel 'notifikasis'
                        Notifikasi::create([
                            'id_tagihan' => $tagihan->id_tagihan,
                            'id_template' => $template->id_template,
                            'tanggal_terjadwal' => now(),
                            'status_baca' => false,
                            'waktu_dikirim' => now(),
                        ]);

                        $this->info("Notifikasi untuk Transaksi #{$tagihan->id_transaksi} telah dikirim dan dicatat untuk {$akun->email}.");
                    } catch (\Exception $e) {
                        $this->error("Gagal memproses notifikasi untuk {$akun->email}: " . $e->getMessage());
                        Log::error("Gagal memproses notifikasi untuk akun ID {$akun->id_akun}: " . $e->getMessage());
                    }
                }
            }
        }

        $this->info('Proses pengiriman notifikasi selesai.');
        return 0;
    }
}

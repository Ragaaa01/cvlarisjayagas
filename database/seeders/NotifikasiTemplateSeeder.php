<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NotifikasiTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'id_template' => 1,
                'hari_set' => -3,
                'nama_template' => 'Reminder 3 Hari Sebelum',
                'judul' => 'Tagihan Akan Jatuh Tempo',
                'isi' => 'Yth. Pelanggan, tagihan #{{id_tagihan}} akan jatuh tempo dalam 3 hari ({{tanggal_jatuh_tempo}}). Total: Rp{{total_tagihan}}. Segera lakukan pembayaran untuk menghindari denda.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_template' => 2,
                'hari_set' => -1,
                'nama_template' => 'Reminder 1 Hari Sebelum',
                'judul' => 'Tagihan Akan Jatuh Tempo Besok',
                'isi' => 'Yth. Pelanggan, tagihan #{{id_tagihan}} akan jatuh tempo besok ({{tanggal_jatuh_tempo}}). Total: Rp{{total_tagihan}}. Mohon segera lunasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_template' => 3,
                'hari_set' => 0,
                'nama_template' => 'Notifikasi Jatuh Tempo',
                'judul' => 'Tagihan Jatuh Tempo Hari Ini',
                'isi' => 'Yth. Pelanggan, tagihan #{{id_tagihan}} jatuh tempo hari ini. Total: Rp{{total_tagihan}}. Segera lakukan pembayaran.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_template' => 4,
                'hari_set' => 1,
                'nama_template' => 'Notifikasi Terlambat 1 Hari',
                'judul' => 'Tagihan Melewati Jatuh Tempo',
                'isi' => 'Yth. Pelanggan, tagihan #{{id_tagihan}} telah melewati jatuh tempo. Denda Rp70.000/bulan akan berlaku jika tidak dibayar dalam 24 jam.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_template' => 5,
                'hari_set' => 0,
                'nama_template' => 'Notifikasi Pelunasan',
                'judul' => 'Pembayaran Diterima',
                'isi' => 'Terima kasih! Pembayaran untuk tagihan #{{id_tagihan}} sebesar Rp{{jumlah_dibayar}} telah diterima pada {{tanggal_bayar}}.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_template' => 7,
                'hari_set' => -7,
                'nama_template' => 'Reminder Peminjaman Aktif',
                'judul' => 'Peminjaman Masih Berlangsung',
                'isi' => 'Yth. Pelanggan, peminjaman tabung #{{id_tabung}} masih aktif. Jatuh tempo pengembalian: {{tanggal_jatuh_tempo}}. Hindari denda Rp70.000/hari jika terlambat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_template' => 8,
                'hari_set' => 0,
                'nama_template' => 'Notifikasi Pengembalian',
                'judul' => 'Tabung Diterima Kembali',
                'isi' => 'Terima kasih! Tabung #{{id_tabung}} telah diterima kembali pada {{tanggal_kembali}}. Kondisi: {{kondisi_tabung}}.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('notifikasi_templates')->insert($templates);
    }
}

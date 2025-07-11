<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiPeminjamanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Mendapatkan objek transaksi dari relasi yang sudah di-eager load
        $transaksi = $this->detailTransaksi->transaksi;
        $namaPelanggan = 'Pelanggan';
        $namaPerusahaan = null;

        // Logika untuk menentukan nama pelanggan
        if ($transaksi->akun && $transaksi->akun->perorangan) {
            // Prioritas 1: Pelanggan dengan akun
            $namaPelanggan = $transaksi->akun->perorangan->nama_lengkap;
            $namaPerusahaan = $transaksi->akun->perorangan->perusahaan->nama_perusahaan ?? null;
        } elseif ($transaksi->perorangan) {
            // Prioritas 2: Pelanggan walk-in (tanpa akun)
            $namaPelanggan = $transaksi->perorangan->nama_lengkap;
            $namaPerusahaan = $transaksi->perorangan->perusahaan->nama_perusahaan ?? null;
        }

        // Jika ada nama perusahaan, gabungkan
        if ($namaPerusahaan) {
            $namaPelanggan = "$namaPelanggan ($namaPerusahaan)";
        }

        // Mengembalikan struktur JSON yang rapi
        return [
            'id_peminjaman'         => $this->id_peminjaman,
            'tanggal_pinjam'        => $this->tanggal_pinjam,
            'status_pinjam'         => $this->status_pinjam,
            'batas_waktu_peminjaman' => $this->detailTransaksi->batas_waktu_peminjaman,

            // Informasi detail tabung yang dipinjam
            'tabung' => [
                'kode_tabung'   => $this->detailTransaksi->tabung->kode_tabung,
                'jenis_tabung'  => $this->detailTransaksi->tabung->jenisTabung->nama_jenis,
            ],

            // Informasi transaksi dan pelanggan terkait
            'transaksi' => [
                'id_transaksi'    => $transaksi->id_transaksi,
                'total_transaksi' => $transaksi->total_transaksi,
                'pelanggan'       => [
                    'nama' => $namaPelanggan,
                ]
            ],
        ];
    }
}

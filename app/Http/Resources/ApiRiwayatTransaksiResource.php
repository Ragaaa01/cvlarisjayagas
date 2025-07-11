<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiRiwayatTransaksiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Menentukan nama pelanggan berdasarkan relasi yang tersedia
        $namaPelanggan = null;
        if ($this->whenLoaded('perorangan')) {
            $namaPelanggan = $this->perorangan->nama_lengkap;
        } elseif ($this->whenLoaded('akun') && $this->akun->perorangan) {
            $namaPelanggan = $this->akun->perorangan->nama_lengkap;
        }

        return [
            'id_riwayat_transaksi' => $this->id_riwayat_transaksi,
            'id_transaksi' => $this->id_transaksi,
            'nama_pelanggan' => $namaPelanggan, // Mengirim nama pelanggan langsung
            'tanggal_transaksi' => Carbon::parse($this->tanggal_transaksi)->format('Y-m-d'),
            'total_transaksi' => $this->total_transaksi,
            'jumlah_dibayar' => $this->jumlah_dibayar,
            'metode_pembayaran' => $this->metode_pembayaran,
            'tanggal_selesai' => $this->tanggal_selesai ? Carbon::parse($this->tanggal_selesai)->format('Y-m-d') : null,
            'status_akhir' => $this->status_akhir,
            'denda' => $this->denda,
            'keterangan' => $this->keterangan,

            // Sertakan relasi jika dibutuhkan untuk detail lebih lanjut di frontend
            // 'perorangan' => new ApiPeroranganResource($this->whenLoaded('perorangan')),
        ];
    }
}

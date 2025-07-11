<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ApiTagihanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Logika untuk mendapatkan nama pelanggan
        $transaksi = $this->transaksi;
        $namaPelanggan = 'Pelanggan';
        if ($transaksi->akun?->perorangan) {
            $namaPelanggan = $transaksi->akun->perorangan->nama_lengkap;
        } elseif ($transaksi->perorangan) {
            $namaPelanggan = $transaksi->perorangan->nama_lengkap;
        }

        return [
            'id_tagihan' => $this->id_tagihan,
            'id_transaksi' => $this->id_transaksi,
            'nama_pelanggan' => $namaPelanggan,
            'total_transaksi' => (float) $this->transaksi->total_transaksi,
            'sisa' => (float) $this->sisa,
            'status' => $this->status,
            'tanggal_jatuh_tempo' => $this->transaksi->tanggal_jatuh_tempo,
        ];
    }
}

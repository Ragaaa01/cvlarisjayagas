<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ApiTransaksiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_transaksi' => $this->id_transaksi,
            'id_akun' => $this->id_akun,
            'id_perorangan' => $this->id_perorangan,
            'id_perusahaan' => $this->id_perusahaan,

            // --- PERBAIKAN: Menghapus definisi 'pelanggan' yang duplikat ---
            // Sekarang hanya menggunakan satu cara yang konsisten untuk memuat data relasi.
            'pelanggan' => new ApiPeroranganResource($this->whenLoaded('pelanggan')),
            'akun' => new ApiAkunResource($this->whenLoaded('akun')),

            'tanggal_transaksi' => $this->tanggal_transaksi ? Carbon::parse($this->tanggal_transaksi)->format('Y-m-d') : null,
            'waktu_transaksi' => $this->waktu_transaksi ? Carbon::parse($this->waktu_transaksi)->format('H:i:s') : null,
            'total_transaksi' => $this->total_transaksi,
            'jumlah_dibayar' => $this->jumlah_dibayar,
            'metode_pembayaran' => $this->metode_pembayaran,
            'status_transaksi' => $this->statusTransaksi ? $this->statusTransaksi->status : null,
            'tanggal_jatuh_tempo' => $this->tanggal_jatuh_tempo ? Carbon::parse($this->tanggal_jatuh_tempo)->format('Y-m-d') : null,

            'detail_transaksis' => ApiDetailTransaksiResource::collection($this->whenLoaded('detailTransaksis')),

            'tagihans' => ApiTagihanResource::collection($this->whenLoaded('tagihans')),
            'latest_tagihan' => new ApiTagihanResource($this->whenLoaded('latestTagihan')),
        ];
    }
}

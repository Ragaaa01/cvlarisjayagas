<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class ApiDetailTransaksiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        Log::info('ApiDetailTransaksiResource data', [
            'id_detail_transaksi' => $this->id_detail_transaksi,
            'batas_waktu_peminjaman' => $this->batas_waktu_peminjaman,
            'batas_waktu_peminjaman_type' => gettype($this->batas_waktu_peminjaman),
            'tanggal_pinjam' => $this->peminjaman ? $this->peminjaman->tanggal_pinjam : null,
            'tanggal_pinjam_type' => $this->peminjaman ? gettype($this->peminjaman->tanggal_pinjam) : null,
        ]);

        return [
            'id_detail_transaksi' => $this->id_detail_transaksi,
            'id_transaksi' => $this->id_transaksi,
            'id_tabung' => $this->id_tabung,
            'id_jenis_transaksi' => $this->id_jenis_transaksi,
            'kode_tabung' => $this->tabung ? $this->tabung->kode_tabung : null,
            'jenis_transaksi' => $this->jenisTransaksi ? $this->jenisTransaksi->nama_jenis_transaksi : null,
            'harga' => $this->harga,
            'batas_waktu_peminjaman' => $this->batas_waktu_peminjaman
                ? Carbon::parse($this->batas_waktu_peminjaman)->format('Y-m-d')
                : null,
            'peminjaman' => $this->peminjaman ? [
                'id_peminjaman' => $this->peminjaman->id_peminjaman,
                'tanggal_pinjam' => $this->peminjaman->tanggal_pinjam
                    ? Carbon::parse($this->peminjaman->tanggal_pinjam)->format('Y-m-d')
                    : null,
                'status_pinjam' => $this->peminjaman->status_pinjam,
            ] : null,
            'tabung' => new ApiTabungResource($this->whenLoaded('tabung')),
        ];
    }
}

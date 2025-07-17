<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotifikasiResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_notifikasi' => $this->id_notifikasi,
            'id_transaksi'  => $this->tagihan->id_transaksi, // Untuk navigasi
            'judul'         => $this->template->judul,
            'isi'           => str_replace('{id_transaksi}', $this->tagihan->id_transaksi, $this->template->isi),
            'status_baca'   => (bool) $this->status_baca,
            'waktu_dikirim' => $this->created_at->toDateTimeString(),
        ];
    }
}

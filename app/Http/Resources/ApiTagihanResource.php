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
        return [
            'id_tagihan' => $this->id_tagihan,
            'id_transaksi' => $this->id_transaksi,
            'jumlah_dibayar' => $this->jumlah_dibayar,
            'sisa' => $this->sisa,
            'status' => $this->status,
            'tanggal_bayar_tagihan' => $this->tanggal_bayar_tagihan
                ? Carbon::parse($this->tanggal_bayar_tagihan)->format('Y-m-d')
                : null,
            'keterangan' => $this->keterangan,
        ];
    }
}

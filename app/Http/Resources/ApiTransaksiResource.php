<?php

namespace App\Http\Resources;

use App\Http\Resources\ApiDetailTransaksiResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ApiTransaksiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id_transaksi' => $this->id_transaksi,
            'id_akun' => $this->id_akun,
            'id_perorangan' => $this->id_perorangan,
            'id_perusahaan' => $this->id_perusahaan,
            'pelanggan' => $this->when($this->perorangan, fn() => [
                'nama_lengkap' => $this->perorangan->nama_lengkap,
                'nik' => $this->perorangan->nik,
                'no_telepon' => $this->perorangan->no_telepon,
                'alamat' => $this->perorangan->alamat,
                'perusahaan' => $this->when($this->perusahaan, fn() => [
                    'nama_perusahaan' => $this->perusahaan->nama_perusahaan,
                    'alamat_perusahaan' => $this->perusahaan->alamat_perusahaan,
                ]),
            ]),
            'tanggal_transaksi' => $this->tanggal_transaksi
                ? Carbon::parse($this->tanggal_transaksi)->format('Y-m-d')
                : null,
            'waktu_transaksi' => $this->waktu_transaksi
                ? Carbon::parse($this->waktu_transaksi)->format('H:i:s')
                : null,
            'total_transaksi' => $this->total_transaksi,
            'jumlah_dibayar' => $this->jumlah_dibayar,
            'metode_pembayaran' => $this->metode_pembayaran,
            'status_transaksi' => $this->statusTransaksi ? $this->statusTransaksi->status : null,
            'tanggal_jatuh_tempo' => $this->tanggal_jatuh_tempo
                ? Carbon::parse($this->tanggal_jatuh_tempo)->format('Y-m-d')
                : null,
            'detail_transaksis' => ApiDetailTransaksiResource::collection($this->whenLoaded('detailTransaksis')),
            'tagihan' => $this->whenLoaded('tagihan', fn() => [
                'id_tagihan' => $this->tagihan->id_tagihan,
                'jumlah_dibayar' => $this->tagihan->jumlah_dibayar,
                'sisa' => $this->tagihan->sisa,
                'status' => $this->tagihan->status,
                'tanggal_bayar_tagihan' => $this->tagihan->tanggal_bayar_tagihan
                    ? Carbon::parse($this->tagihan->tanggal_bayar_tagihan)->format('Y-m-d')
                    : null,
            ]),
        ];
    }
}

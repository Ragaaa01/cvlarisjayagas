<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiPelangganResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_perorangan' => $this->id_perorangan,
            'nama_lengkap'  => $this->nama_lengkap,
            'nik'           => $this->nik,
            'no_telepon'    => $this->no_telepon,
            'alamat'        => $this->alamat,
            'id_perusahaan' => $this->id_perusahaan,

            // Menggunakan null-safe operator secara langsung.
            // Jika relasi 'akun' tidak ada (null), maka hasilnya akan null.
            'id_akun'       => $this->akun?->id_akun,

            // Menyertakan detail objek 'akun' jika relasinya ada.
            'akun'          => $this->when($this->akun, function () {
                return [
                    'id_akun' => $this->akun->id_akun,
                    'email'   => $this->akun->email,
                ];
            }),

            // Menyertakan detail objek 'perusahaan' jika relasinya ada.
            'perusahaan'    => $this->when($this->perusahaan, function () {
                return [
                    'id_perusahaan'   => $this->perusahaan->id_perusahaan,
                    'nama_perusahaan' => $this->perusahaan->nama_perusahaan,
                    'email_perusahaan' => $this->perusahaan->email_perusahaan,
                    'alamat_perusahaan' => $this->perusahaan->alamat_perusahaan,
                ];
            }),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiPeroranganResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_perorangan' => $this->id_perorangan,
            'id_akun' => $this->id_akun ?? $this->akun?->id_akun,
            'id_perusahaan' => $this->id_perusahaan,
            'nama_lengkap' => $this->nama_lengkap,
            'nik' => $this->nik,
            'no_telepon' => $this->no_telepon,
            'alamat' => $this->alamat,
            'perusahaan' => $this->when($this->perusahaan, [
                'id_perusahaan' => $this->perusahaan?->id_perusahaan,
                'nama_perusahaan' => $this->perusahaan?->nama_perusahaan,
                'alamat_perusahaan' => $this->perusahaan?->alamat_perusahaan,
                'email_perusahaan' => $this->perusahaan?->email_perusahaan,
            ]),

            // Secara kondisional menyertakan data relasi 'akun' jika sudah di-load
            // Ini berguna agar tidak selalu memuat data yang tidak perlu
            // 'akun' => new ApiAkunResource($this->whenLoaded('akun')),
        ];
    }
}

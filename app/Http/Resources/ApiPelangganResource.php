<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiPelangganResource extends JsonResource
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
            'nama_lengkap' => $this->nama_lengkap,
            'nik' => $this->nik,
            'no_telepon' => $this->no_telepon,
            'alamat' => $this->alamat,
            'akun' => $this->when($this->akun, [
                'id_akun' => $this->akun?->id_akun,
                'email' => $this->akun?->email,
                'status_aktif' => $this->akun?->status_aktif,
                'role' => $this->akun?->role,
            ]),
            'perusahaan' => $this->when($this->perusahaan, [
                'id_perusahaan' => $this->perusahaan?->id_perusahaan,
                'nama_perusahaan' => $this->perusahaan?->nama_perusahaan,
                'alamat_perusahaan' => $this->perusahaan?->alamat_perusahaan,
                'email_perusahaan' => $this->perusahaan?->email_perusahaan,
            ]),
            'created_at' => $this->created_at ? $this->created_at->toDateTimeString() : null,
            'updated_at' => $this->updated_at ? $this->updated_at->toDateTimeString() : null,
            'deleted_at' => $this->deleted_at ? $this->deleted_at->toDateTimeString() : null,
        ];
    }   
}

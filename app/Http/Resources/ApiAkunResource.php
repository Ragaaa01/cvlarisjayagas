<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiAkunResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_akun' => $this->id_akun,
            'id_perorangan' => $this->id_perorangan,
            'email' => $this->email,
            'role' => $this->role,
            'status_aktif' => (bool) $this->status_aktif,

            // Secara kondisional menyertakan data relasi 'perorangan' jika sudah di-load.
            // Ini adalah praktik terbaik untuk mencegah pemuatan data yang tidak perlu
            // dan menghindari potensi infinite loop.
            'perorangan' => new ApiPeroranganResource($this->whenLoaded('perorangan')),
        ];
    }
}

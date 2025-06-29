<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiTabungResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id_tabung' => $this->id_tabung,
            'kode_tabung' => $this->kode_tabung,
            'jenis_tabung' => [
                'id_jenis_tabung' => $this->jenisTabung->id_jenis_tabung,
                'kode_jenis' => $this->jenisTabung->kode_jenis,
                'nama_jenis' => $this->jenisTabung->nama_jenis,
                'harga' => $this->jenisTabung->harga,
            ],
            'status_tabung' => [
                'id_status_tabung' => $this->statusTabung->id_status_tabung,
                'status_tabung' => $this->statusTabung->status_tabung,
            ],
        ];
    }
}

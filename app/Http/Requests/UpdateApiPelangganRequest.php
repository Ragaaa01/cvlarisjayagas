<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApiPelangganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'administrator';
    }

    public function rules(): array
    {
        $perorangan = $this->route('perorangan');

        // Ambil ID dari route parameter 'id' (sesuai method update)
        $id_perorangan = $this->route('id');

        return [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nik' => [
                'required',
                'string',
                'size:16',
                Rule::unique('perorangans', 'nik')->ignore($id_perorangan, 'id_perorangan'),
            ],
            'no_telepon' => [
                'required',
                'string',
                'regex:/^[0-9]{9,14}$/',
                Rule::unique('perorangans', 'no_telepon')->ignore($id_perorangan, 'id_perorangan'),
            ],
            'alamat' => ['required', 'string'],
            'email' => [
                'nullable',
                'email',
                Rule::unique('akuns', 'email')->ignore($this->route('id'), 'id_perorangan'),
            ],
            'password' => ['nullable', 'string', 'min:8'],
            'nama_perusahaan' => ['nullable', 'string', 'max:255'],
            'alamat_perusahaan' => ['nullable', 'string', 'required_with:nama_perusahaan'],
            'email_perusahaan' => [
                'nullable',
                'email',
                Rule::unique('perusahaans', 'email_perusahaan')->ignore($this->route('id'), 'id_perusahaan'),
                'required_with:nama_perusahaan',
            ],
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApiPelangganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Sesuaikan dengan middleware autentikasi jika perlu
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => ['sometimes', 'required', 'string', 'max:255'],
            'nik' => ['sometimes', 'required', 'string', 'size:16', Rule::unique('perorangans', 'nik')->ignore($this->pelanggan, 'id_perorangan')],
            'no_telepon' => ['sometimes', 'required', 'string', 'max:15', Rule::unique('perorangans', 'no_telepon')->ignore($this->pelanggan, 'id_perorangan')],
            'alamat' => ['sometimes', 'required', 'string'],
            'id_perusahaan' => ['nullable', 'exists:perusahaans,id_perusahaan'],
            'email' => ['sometimes', 'required', 'email', Rule::unique('akuns', 'email')->ignore($this->pelanggan)],
            'password' => ['sometimes', 'nullable', 'string', 'min:8', 'confirmed'],
            'status_aktif' => ['sometimes', 'required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nik.unique' => 'NIK sudah terdaftar.',
            'no_telepon.unique' => 'Nomor telepon sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApiPelangganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Sesuaikan dengan middleware autentikasi jika perlu
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'size:16', 'unique:perorangans,nik'],
            'no_telepon' => ['required', 'string', 'max:15', 'unique:perorangans,no_telepon'],
            'alamat' => ['required', 'string'],
            'id_perusahaan' => ['nullable', 'exists:perusahaans,id_perusahaan'],
            'email' => ['required', 'email', 'unique:akuns,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_authenticated' => ['required', 'boolean'],
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
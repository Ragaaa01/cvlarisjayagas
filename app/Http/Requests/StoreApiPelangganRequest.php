<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApiPelangganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'administrator';
    }

    public function rules(): array
    {
        return [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nik' => [
                'required',
                'string',
                'size:16',
                Rule::unique('perorangans', 'nik')->where(function ($query) {
                    $query->whereNull('deleted_at');
                    // Jika request tidak menyertakan nama_perusahaan, izinkan nik yang sebelumnya digunakan untuk perusahaan
                    if (!$this->filled('nama_perusahaan')) {
                        $query->whereNotNull('id_perusahaan');
                    }
                    return $query;
                }),
            ],
            'no_telepon' => [
                'required',
                'string',
                'regex:/^[0-9]{9,14}$/',
                Rule::unique('perorangans', 'no_telepon')->where(function ($query) {
                    $query->whereNull('deleted_at');
                    // Jika request tidak menyertakan nama_perusahaan, izinkan no_telepon yang sebelumnya digunakan untuk perusahaan
                    if (!$this->filled('nama_perusahaan')) {
                        $query->whereNotNull('id_perusahaan');
                    }
                    return $query;
                }),
            ],
            'alamat' => ['required', 'string'],
            'email' => ['nullable', 'email', 'unique:akuns,email'],
            'password' => ['nullable', 'string', 'min:8', 'required_with:email'],
            'nama_perusahaan' => ['nullable', 'string', 'max:255'],
            'alamat_perusahaan' => ['nullable', 'string', 'required_with:nama_perusahaan'],
            'email_perusahaan' => ['nullable', 'email', 'unique:perusahaans,email_perusahaan', 'required_with:nama_perusahaan'],
        ];
    }
}
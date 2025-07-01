<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApiTransaksiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'administrator';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'id_akun' => ['nullable', 'exists:akuns,id_akun'],
            'id_perorangan' => ['nullable', 'exists:perorangans,id_perorangan'],
            'id_perusahaan' => ['nullable', 'exists:perusahaans,id_perusahaan'],
            'tanggal_transaksi' => ['nullable', 'date'],
            'waktu_transaksi' => ['nullable', 'date_format:H:i:s'],
            'total_transaksi' => ['nullable', 'numeric', 'min:0'],
            'jumlah_dibayar' => ['nullable', 'numeric', 'min:0'],
            'metode_pembayaran' => ['nullable', 'in:transfer,tunai'],
            'id_status_transaksi' => ['nullable', 'exists:status_transaksis,id_status_transaksi'],
        ];
    }

    /**
     * Get custom error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'id_akun.exists' => 'Akun tidak ditemukan.',
            'id_perorangan.exists' => 'Pelanggan tidak ditemukan.',
            'id_perusahaan.exists' => 'Perusahaan tidak ditemukan.',
            'tanggal_transaksi.date' => 'Tanggal transaksi tidak valid.',
            'waktu_transaksi.date_format' => 'Waktu transaksi harus dalam format H:i:s.',
            'total_transaksi.numeric' => 'Total transaksi harus angka.',
            'jumlah_dibayar.numeric' => 'Jumlah dibayar harus angka.',
            'metode_pembayaran.in' => 'Metode pembayaran tidak valid.',
            'id_status_transaksi.exists' => 'Status transaksi tidak ditemukan.',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApiTransaksiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'administrator';
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'tipe_pelanggan' => 'required|in:perorangan_tanpa_akun,perorangan_dengan_akun,perusahaan_dengan_akun',
            'pelanggan' => 'required_if:tipe_pelanggan,perorangan_tanpa_akun|array',
            'pelanggan.nama_lengkap' => 'required_if:tipe_pelanggan,perorangan_tanpa_akun|string|max:255',
            'pelanggan.nik' => 'required_if:tipe_pelanggan,perorangan_tanpa_akun|string|size:16',
            'pelanggan.no_telepon' => 'required_if:tipe_pelanggan,perorangan_tanpa_akun|string|max:15',
            'pelanggan.alamat' => 'required_if:tipe_pelanggan,perorangan_tanpa_akun|string|max:255',
            'id_akun' => 'nullable|integer|exists:users,id',
            'id_perorangan' => 'nullable|integer|exists:perorangans,id_perorangan',
            'id_perusahaan' => 'nullable|integer|exists:perusahaans,id_perusahaan',
            'jumlah_dibayar' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|string|in:tunai,transfer',
            'detail_transaksis' => 'required|array|min:1',
            'detail_transaksis.*.id_tabung' => 'required|integer|exists:tabungs,id_tabung',
            'detail_transaksis.*.id_jenis_transaksi' => 'required|integer|exists:jenis_transaksis,id_jenis_transaksi',
            'detail_transaksis.*.harga' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom error messages for validation.
     */
    public function messages(): array
    {
        return [
            'tipe_pelanggan.required' => 'Tipe pelanggan wajib diisi.',
            'tipe_pelanggan.in' => 'Tipe pelanggan tidak valid.',
            'pelanggan.required_if' => 'Data pelanggan wajib diisi untuk tipe perorangan tanpa akun.',
            'pelanggan.nama_lengkap.required_if' => 'Nama lengkap wajib diisi.',
            'pelanggan.nik.required_if' => 'NIK wajib diisi.',
            'pelanggan.nik.size' => 'NIK harus 16 digit.',
            'pelanggan.no_telepon.required_if' => 'Nomor telepon wajib diisi.',
            'pelanggan.alamat.required_if' => 'Alamat wajib diisi.',
            'id_akun.exists' => 'ID akun tidak valid.',
            'id_perorangan.exists' => 'ID perorangan tidak valid.',
            'id_perusahaan.exists' => 'ID perusahaan tidak valid.',
            'jumlah_dibayar.required' => 'Jumlah dibayar wajib diisi.',
            'jumlah_dibayar.numeric' => 'Jumlah dibayar harus berupa angka.',
            'metode_pembayaran.required' => 'Metode pembayaran wajib diisi.',
            'metode_pembayaran.in' => 'Metode pembayaran tidak valid.',
            'detail_transaksis.required' => 'Detail transaksi wajib diisi.',
            'detail_transaksis.array' => 'Detail transaksi harus berupa array.',
            'detail_transaksis.min' => 'Setidaknya satu detail transaksi harus diisi.',
            'detail_transaksis.*.id_tabung.required' => 'ID tabung wajib diisi.',
            'detail_transaksis.*.id_tabung.exists' => 'ID tabung tidak valid.',
            'detail_transaksis.*.id_jenis_transaksi.required' => 'ID jenis transaksi wajib diisi.',
            'detail_transaksis.*.id_jenis_transaksi.exists' => 'ID jenis transaksi tidak valid.',
            'detail_transaksis.*.harga.required' => 'Harga wajib diisi.',
            'detail_transaksis.*.harga.numeric' => 'Harga harus berupa angka.',
        ];
    }
}

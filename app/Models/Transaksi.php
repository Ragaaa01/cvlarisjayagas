<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_akun',
        'id_perorangan',
        'id_perusahaan',
        'tanggal_transaksi',
        'waktu_transaksi',
        'total_transaksi',
        'jumlah_dibayar',
        'metode_pembayaran',
        'id_status_transaksi',
        'tanggal_jatuh_tempo'
    ];

    // Relasi ke akun
    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun');
    }

    // Relasi ke perorangan
    public function perorangan()
    {
        return $this->belongsTo(Perorangan::class, 'id_perorangan');
    }

    // Relasi ke perusahaan
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan');
    }

    // Relasi ke status transaksi
    public function statusTransaksi()
    {
        return $this->belongsTo(StatusTransaksi::class, 'id_status_transaksi');
    }

    // Relasi ke detail transaksi
    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }

    // Relasi ke tagihan
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'id_transaksi');
    }

    // Relasi ke riwayat transaksi
    public function riwayatTransaksis()
    {
        return $this->hasMany(RiwayatTransaksi::class, 'id_transaksi');
    }
}

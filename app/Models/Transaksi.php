<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksis';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_akun', 'id_perorangan', 'tanggal_transaksi', 'waktu_transaksi',
        'total_transaksi', 'jumlah_dibayar', 'metode_pembayaran',
        'id_status_transaksi', 'tanggal_jatuh_tempo'
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun');
    }

    public function perorangan()
    {
        return $this->belongsTo(Perorangan::class, 'id_perorangan');
    }

    public function status()
    {
        return $this->belongsTo(StatusTransaksi::class, 'id_status_transaksi');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }

    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'id_transaksi');
    }

    public function riwayatTransaksis()
    {
        return $this->hasMany(RiwayatTransaksi::class, 'id_transaksi');
    }
}

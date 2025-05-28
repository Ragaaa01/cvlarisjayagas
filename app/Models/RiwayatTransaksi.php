<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatTransaksi extends Model
{
    protected $table = 'riwayat_transaksis';
     protected $primaryKey = 'id_riwayat_transaksi';

    protected $fillable = [
        'id_transaksi', 'id_akun', 'id_perorangan', 'tanggal_transaksi',
        'total_transaksi', 'jumlah_dibayar', 'metode_pembayaran',
        'tanggal_jatuh_tempo', 'tanggal_selesai', 'status_akhir',
        'total_pembayaran', 'denda', 'durasi_peminjaman', 'keterangan'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun');
    }

    public function perorangan()
    {
        return $this->belongsTo(Perorangan::class, 'id_perorangan');
    }
}

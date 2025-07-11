<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatTransaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'riwayat_transaksis';
    protected $primaryKey = 'id_riwayat_transaksi';

    protected $fillable = [
        'id_transaksi',
        'id_akun',
        'id_perorangan',
        'id_perusahaan',
        'tanggal_transaksi',
        'total_transaksi',
        'jumlah_dibayar',
        'metode_pembayaran',
        'tanggal_jatuh_tempo',
        'tanggal_selesai',
        'status_akhir',
        'total_pembayaran',
        'denda',
        'durasi_peminjaman',
        'keterangan'
    ];

    protected $casts = [
        'total_transaksi' => 'decimal:2',
        'jumlah_dibayar' => 'decimal:2',
        'total_pembayaran' => 'decimal:2',
        'denda' => 'decimal:2',
        'tanggal_transaksi' => 'date',
        'tanggal_jatuh_tempo' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }

    public function perorangan()
    {
        return $this->belongsTo(Perorangan::class, 'id_perorangan', 'id_perorangan');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }
}

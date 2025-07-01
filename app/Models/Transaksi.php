<?php

namespace App\Models;

use App\Models\Akun;
use App\Models\Tagihan;
use App\Models\Perorangan;
use App\Models\Perusahaan;
use App\Models\DetailTransaksi;
use App\Models\StatusTransaksi;
use App\Models\RiwayatTransaksi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use SoftDeletes;

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

    protected $casts = [
        'tanggal_transaksi' => 'date',
        'waktu_transaksi' => 'datetime',
        'tanggal_jatuh_tempo' => 'date',
        'total_transaksi' => 'decimal:2',
        'jumlah_dibayar' => 'decimal:2',
    ];

    // Relasi ke akun
    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }

    // Relasi ke perorangan
    public function perorangan()
    {
        return $this->belongsTo(Perorangan::class, 'id_perorangan', 'id_perorangan');
    }

    // public function perusahaan()
    // {
    //     return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    // }

    // Relasi ke perusahaan
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan');
    }

    // Relasi ke status transaksi
    public function statusTransaksi()
    {
        return $this->belongsTo(StatusTransaksi::class, 'id_status_transaksi', 'id_status_transaksi');
    }

    // Relasi ke detail transaksi
    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }

    // Relasi ke tagihan
    public function tagihan()
    {
        return $this->hasOne(Tagihan::class, 'id_transaksi', 'id_transaksi');
    }

    // Relasi ke riwayat transaksi
    public function riwayatTransaksis()
    {
        return $this->hasMany(RiwayatTransaksi::class, 'id_transaksi');
    }
}

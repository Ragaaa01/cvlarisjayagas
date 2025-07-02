<?php

namespace App\Models;

use App\Models\Akun;
use App\Models\DetailTransaksi;
use App\Models\Perorangan;
use App\Models\Perusahaan;
use App\Models\RiwayatTransaksi;
use App\Models\StatusTransaksi;
use App\Models\Tagihan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use SoftDeletes;

    protected $table = 'transaksis';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_akun',
        'id_perorangan',
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

    public function statusTransaksi()
    {
        return $this->belongsTo(StatusTransaksi::class, 'id_status_transaksi', 'id_status_transaksi');
    }

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'id_transaksi', 'id_transaksi');
    }

    /**
     * Helper untuk mendapatkan SATU catatan tagihan TERBARU.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function latestTagihan()
    {
        return $this->hasOne(Tagihan::class, 'id_transaksi', 'id_transaksi')->latestOfMany('id_tagihan');
    }

    public function riwayatTransaksis()
    {
        return $this->hasMany(RiwayatTransaksi::class, 'id_transaksi');
    }
}

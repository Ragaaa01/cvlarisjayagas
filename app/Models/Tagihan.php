<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihans';
    protected $primaryKey = 'id_tagihan';

    protected $fillable = [
        'id_transaksi', 'jumlah_dibayar', 'sisa', 'status',
        'tanggal_bayar_tagihan', 'hari_keterlambatan', 'periode_ke', 'keterangan'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class, 'id_tagihan');
    }
}

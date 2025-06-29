<?php

namespace App\Models;

use App\Models\Notifikasi;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihans';
    protected $primaryKey = 'id_tagihan';

    protected $fillable = [
        'id_transaksi',
        'jumlah_dibayar',
        'sisa',
        'status',
        'tanggal_bayar_tagihan',
        'hari_keterlambatan',
        'periode_ke',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_bayar_tagihan' => 'date',
        'jumlah_dibayar' => 'decimal:2',
        'sisa' => 'decimal:2',
    ];

    public function calculateDenda()
    {
        $transaksi = $this->transaksi;
        if ($transaksi->tanggal_jatuh_tempo && now()->gt($transaksi->tanggal_jatuh_tempo)) {
            $daysLate = now()->diffInDays($transaksi->tanggal_jatuh_tempo);
            if ($daysLate > 30) {
                $monthsLate = floor($daysLate / 30);
                $denda = $monthsLate * 70000; // Rp70.000 per bulan
                $this->sisa += $denda;
                $this->keterangan = "Denda: Rp$denda";
                $this->save();
            }
        }
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    public function notifikasis()
    {
        return $this->hasMany(Notifikasi::class, 'id_tagihan');
    }
}

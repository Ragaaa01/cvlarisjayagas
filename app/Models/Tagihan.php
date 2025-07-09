<?php

namespace App\Models;

use App\Models\Transaksi;
use App\Models\Notifikasi;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function calculateLateDaysAndPeriod()
    {
        if ($this->status === 'lunas') {
            return [
                'hari_keterlambatan' => $this->hari_keterlambatan ?? 0,
                'periode_ke' => $this->periode_ke ?? 0
            ];
        }

        $transaksi = $this->transaksi;
        $hari_keterlambatan = 0;
        $periode_ke = 0;

        if ($transaksi && $transaksi->tanggal_jatuh_tempo) {
            $jatuh_tempo = Carbon::parse($transaksi->tanggal_jatuh_tempo);
            if (now()->gt($jatuh_tempo)) {
                $hari_keterlambatan = now()->diffInDays($jatuh_tempo);
                $periode_ke = $hari_keterlambatan > 0 ? floor($hari_keterlambatan / 30) + 1 : 0;
            }
        }

        // Simpan ke database jika berbeda
        if ($this->hari_keterlambatan != $hari_keterlambatan || $this->periode_ke != $periode_ke) {
            $this->update([
                'hari_keterlambatan' => $hari_keterlambatan,
                'periode_ke' => $periode_ke
            ]);
        }

        return [
            'hari_keterlambatan' => $hari_keterlambatan,
            'periode_ke' => $periode_ke
        ];
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

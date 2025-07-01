<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = ['id_detail_transaksi', 'tanggal_pinjam', 'status_pinjam'];

    protected $casts = [
        'tanggal_pinjam' => 'datetime', // Konversi otomatis ke Carbon
    ];

    public function detailTransaksi()
    {
        return $this->belongsTo(DetailTransaksi::class, 'id_detail_transaksi', 'id_detail_transaksi');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'id_peminjaman');
    }
}

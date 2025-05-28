<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalians';
    protected $primaryKey = 'id_pengembalian';

    protected $fillable = ['id_peminjaman', 'tanggal_kembali', 'kondisi_tabung', 'keterangan'];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
}

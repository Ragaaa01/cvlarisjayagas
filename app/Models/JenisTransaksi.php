<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTransaksi extends Model
{
    protected $table = 'jenis_transaksis';
     protected $primaryKey = 'id_jenis_transaksi';

    protected $fillable = ['nama_jenis_transaksi'];

    public function detailTransaksis()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_jenis_transaksi');
    }
}

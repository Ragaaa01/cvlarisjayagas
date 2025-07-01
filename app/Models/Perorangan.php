<?php

namespace App\Models;

use App\Models\Akun;
use App\Models\Perusahaan;
use App\Models\RiwayatTransaksi;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perorangan extends Model
{
    use SoftDeletes;

    protected $table = 'perorangans';
     protected $primaryKey = 'id_perorangan';

    protected $fillable = ['nama_lengkap', 'nik', 'no_telepon', 'alamat', 'id_perusahaan'];

    public function akun()
    {
        return $this->hasOne(Akun::class, 'id_perorangan', 'id_perorangan');
    }

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_perorangan');
    }

    public function riwayatTransaksis()
    {
        return $this->hasMany(RiwayatTransaksi::class, 'id_perorangan');
    }
}

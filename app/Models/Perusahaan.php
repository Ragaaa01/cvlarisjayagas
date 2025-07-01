<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    protected $table = 'perusahaans';
    protected $primaryKey = 'id_perusahaan';

    protected $fillable = ['nama_perusahaan', 'alamat_perusahaan', 'email_perusahaan'];

    public function perorangans()
    {
        return $this->hasMany(Perorangan::class, 'id_perusahaan');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_perusahaan', 'id_perusahaan');
    }
}

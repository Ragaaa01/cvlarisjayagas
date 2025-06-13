<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Akun extends Authenticatable // Extend Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'akuns';
    protected $primaryKey = 'id_akun';

    protected $fillable = ['id_perorangan', 'email', 'password', 'role', 'status_aktif'];
     protected $hidden = ['password', 'remember_token'];
     protected $casts = [
    'id_akun' => 'integer',
    'status_aktif' => 'boolean',
];

    public function perorangan()
    {
        return $this->belongsTo(Perorangan::class, 'id_perorangan');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_akun');
    }

    public function riwayatTransaksis()
    {
        return $this->hasMany(RiwayatTransaksi::class, 'id_akun');
    }
}

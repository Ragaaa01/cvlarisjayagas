<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTransaksi extends Model
{
    protected $table = 'status_transaksis';
    protected $primaryKey = 'id_status_transaksi';

    protected $fillable = ['status'];

    public const SUCCESS = 1;
    public const PENDING = 2;
    public const FAILED = 3;

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_status_transaksi');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasis';
    protected $primaryKey = 'id_notifikasi';

    protected $fillable = ['id_tagihan', 'id_template', 'tanggal_terjadwal', 'status_baca', 'waktu_dikirim'];

    protected $dates = ['tanggal_terjadwal', 'waktu_dikirim'];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class, 'id_tagihan');
    }

    public function template()
    {
        return $this->belongsTo(NotifikasiTemplate::class, 'id_template');
    }
}